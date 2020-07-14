<?php

  // require_once("database.php");

    class config {
        public $databasePath = "7sins.db";
        /*
            Mode 1 = Winning team gets 1 box each
            Mode 2 = Winning team gets 1 box per participation
            Mode 3 = Winning team gets 3 boxes with min rarity of 3, increasing based on participation
            Modifier = Only give rarities
        */
        public $globalMode = 1;
        public $globalModifier = false;
    }

    class mysteryBox extends config {

        public $dataBase;

        public $count;

        public $PDO;

        public $weightID;

        function __construct($code=null){
	    
            $PDO = new PDO('sqlite:'.$this->databasePath);

            $this->PDO = $PDO;

            $this->count = array();

            $this->code = $code;

            $this->weightID = array( 'Common' => 1 , 'Uncommon' => 2, 'Rare' => 3, 'Super Rare' => 4 , 'Legendary' =>5 );

            echo "\n";

            if(!@$this->checkCode()){
                echo 'Invalid code!';
            }
            else{
                echo 'Welcome, '.$this->getName().'! You participated in '.$this->events.' events and were'.($this->didTeamWin()?' ':' not ')."part of the winning team!\n";
            }



        }

        function didTeamWin(){
            $win = $this->teams[$this->team] == 1 ? true : false ;
            $this->win = $win;
            return $win;
        }

        function setupTeams(){
            $query = "SELECT * FROM teams";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute();
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $array = array();
            foreach($teams as $team){
                $array[$team['id']] = $team['win'];
            }
            $this->teams = $array;
        }

        function checkCode(){
            $this->setupTeams();
            /* another sqlite bodge */
            $query = "SELECT * FROM codes WHERE code = :code";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute(['code'=>$this->code]);
            $holding = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($holding)!=0){
                $this->name = $holding[0]['name'];
                $this->team = $holding[0]['team'];
                $this->events = $holding[0]['events'];
                $this->win = $holding[0]['win'];
                $this->uid = $holding[0]['id'];
                return true;
            }
            else{
                return false;
            }
        }

        function getName(){
            return $this->name;
        }

        function getWeight(){
            /* this exists so I can switch from array to sqlite without dying inside
                should return in the same format as the array
            */

            $query = "SELECT * FROM weight";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute();
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $output = array();
            foreach($array as $value){
                $output[$value['name']] = $value['weight'];
            }
            $this->weight = $output;
        }

        function getPrizes($rarity){
            /* this exists so I can switch from array to sqlite without dying inside
                should return in the same format as the array
            */
            // echo "Rarity is $rarity\n";
            $query = "SELECT * FROM prizes WHERE weight = :rarity and reference != :reference";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute(["rarity"=>$this->weightID[$rarity],"reference"=>$this->uid]);
            $holding = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($holding);
            return $holding;
        }

        function rng(){
            /* Two rolls : 
                1) determine rarity
                2) determine which prize from that rarity, this can be meh rng
            */

            $rarity = $this->determineRarity();

            $max = count($this->getPrizes($rarity))-1;

            $prizes = $this->getPrizes($rarity);

            $rng = mt_rand(0,$max);

            if(@$this->count[$rarity]){
                $this->count[$rarity] = $this->count[$rarity] + 1;
            }
            else{
                $this->count[$rarity] = 1;
            }
            return '['.$rarity.'] : '.$prizes[$rng]['name'];

        }

        function determineRarity(){
            $this->getWeight();
            return $this->getRandomWeightedElement($this->weight);
        }


          /**
           * Source : https://stackoverflow.com/a/11872928
        * getRandomWeightedElement()
         * Utility function for getting random values with weighting.
         * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
         * An array like this means that 'A' has a 5% chance of being selected, 'B' 45%, and 'C' 50%.
         * The return value is the array key, A, B, or C in this case.  Note that the values assigned
         * do not have to be percentages.  The values are simply relative to each other.  If one value
         * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
         * chance of being selected.  Also note that weights should be integers.
         * 
         * @param array $weightedValues
         */
        function getRandomWeightedElement(array $weightedValues) {
            $rand = mt_rand(1, (int) array_sum($weightedValues));

            foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
            }
        }

        function getMyPrizes(){
            // Assumes 3 events, and winning team, and no reroll
            $win = $this->win;
            $events = $this->events;

            if($win){
                for($i = 0; $i < $events ; $i++ ){
                    echo '['.$i.'] Congratulations! You have won : '.$this->rng()."!\n";
                }
            }
            else{
                if ( $events == 3 ) {
                    echo '[Bonus] Congratulations! You have won : '.$this->rng()."!\n";
                }
                echo '[0] Congratulations! You have won : '.$this->rng()."!\n";
            }

        }
        function removeCode($code){
        }

    }





    for($i=1;$i<9;$i++){
        $mysteryBox = new mysteryBox('TEST00'.$i);
        $mysteryBox->getMyPrizes();
    }


    
