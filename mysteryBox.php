<?php

    // Proof of concept

    $dataBase = array( // YES THIS IS A DATABASE SUE ME Q.Q it'll be sqlite later i swear
        "Codes" => array(),
        "Prizes" => array(
            "Common" => array("cake","pie","minion","orchestrion roll"),
            "Uncommon" => array("30 mins of one person from losing team's time"),
            "Rare" => array("500k"),
            "Super Rare" => array("fantasia full team","fantasia X","mogstation item of £4 or less")
        ),
        "Weight" => array(
            "Common" => 40,
            "Uncommon" => 30,
            "Rare" => 20,
            "Super Rare" => 10
        )
    ); 

    class mysteryBox {

        public $dataBase;

        public $counts;
    
        function __construct($db){
            $this->dataBase = $db;
            $this->count = array();
        }

        function getWeight(){
            /* this exists so I can switch from array to sqlite without dying inside
                should return in the same format as the array
            */
            return $this->dataBase['Weight'];
        }

        function getPrizes($rarity){
            /* this exists so I can switch from array to sqlite without dying inside
                should return in the same format as the array
            */
            return $this->dataBase['Prizes'][$rarity];
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
            return "[$rarity] : ".$prizes[$rng];

        }

        function determineRarity(){
            $weight = $this->getWeight();
            return $this->getRandomWeightedElement($weight);
        }


          /**
           * Source : https://stackoverflow.com/a/11872928
        * getRandomWeightedElement()
         * Utility function for getting random values with weighting.
         * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
         * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
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


        function removeCode($code){
        }

    }


    $mysteryBox = new mysteryBox($dataBase);
    $results = array();
    for($i=0;$i<1000;$i++){
        $results[] = $mysteryBox->rng();
    }
//    echo "<pre>";
//    print_r($results);

    print_r($mysteryBox->count);