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

            $this->weightID = array( 'Common' => 1 , 'Uncommon' => 2, 'Rare' => 3, 'Super Rare' => 4 , 'Legendary' =>5 );
            // echo "\n";

            if(@$_GET['code']){
                $this->code = $_GET['code'];
                $this->checkCode();
         	$this->generateBoxes();
		if(@$_GET['box'] && @$_GET['roll'] == 1){
			$this->doABarrelRoll();
		}
		elseif(@$_GET['box'] && @$_GET['reroll'] == 1){
			$this->doABarrelReRoll();
		}
                //print_r($this->user);
            }

        }

	function genLink($box,$code){
		return "<a href='/mysteryBox.php?roll=1&box=$box&code=".$_GET['code']."'>Click here to roll!</a>";
	}
	function genReroll($box,$code){
		return "<a onclick='return confirm(\"Are you sure? You will not be able to get this prize back if you reroll.\")' href='/mysteryBox.php?reroll=1&box=$box&code=".$_GET['code']."'>Available - Click here</a>";
	}

	function doABarrelRoll(){
		// It's 5AM, I can't sleep atm, sue me for the function name Q.Q
		$output = $this->runQuery("SELECT * FROM boxes WHERE boxID=:box AND codeID=:code",['box'=>$_GET['box'],'code'=>$this->user['uid']]);
		// Should return one thing in  [0], assumptions!
		if($output[0]['prizeID']!=0){
			// THOU SHALT NOT PASS
			return;
		}
		$this->runQuery("UPDATE boxes SET prizeID = :prize, rerolled = 0 WHERE codeID = :code AND boxID = :box", ['prize'=>$this->rng(), 'box'=>$_GET['box'],'code'=>$this->user['uid']]);

	}
	function doABarrelReRoll(){
		// It is now 6AM ok. :V
		$output = $this->runQuery("SELECT * FROM boxes WHERE boxID=:box AND codeID=:code",['box'=>$_GET['box'],'code'=>$this->user['uid']]);
		if($output[0]['prizeID']==0||$output[0]['rerolled']==1){
			return;
		}
		$queries = array(
			array( "UPDATE boxes set rerolled = 1, prizeID = :prize WHERE codeID = :code AND boxID = :box",
				array('prize' => $this->rng($output[0]['prizeID']), 'code' => $this->user['uid'], 'box' => $_GET['box'] )),
			array( "UPDATE prizes set used=0 WHERE id = :prize" , array( 'prize' => $output[0]['prizeID'] )));
		foreach($queries as $query){
			//echo "Running query $query[0]\n";
			$this->runQuery($query[0],$query[1]);
		}
	}

	function generateBoxes(){
		$query = "select count(*) from boxes where codeID = :codeID";
		$stmt = $this->PDO->prepare($query);
		$stmt->execute(['codeID'=>$this->user['uid']]);
		$output = $stmt->fetchAll();
		$count = $output[0][0];
		if($count > 0 ){ return ; }
		$quantityToGen = ($this->user['win'] == 1 ? $this->user['events'] : 1 )+1;
		for($i=1;$i<$quantityToGen;$i++){
			$query = "insert into boxes (`boxID`,`codeID`,`prizeID`,`rerolled`) VALUES (:boxID,:codeID,0,0)";
			$stmt = $this->PDO->prepare($query);
			$stmt->execute(['boxID'=>$i,'codeID'=>$this->user['uid']]);
		}
	}

	function getBoxArray(){
		return $this->runQuery("SELECT * FROM boxes where codeID = :codeID", ['codeID'=>$this->user['uid']]);
	}

	function runQuery($query,$arguments=null){
		$stmt = $this->PDO->prepare($query);
		if($arguments != null){
			$stmt->execute($arguments);
		}
		else{
			$stmt->execute();
		}
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	function getPrizeByID($id){
		$array = $this->runQuery("SELECT name,weight FROM prizes where id = :id", ['id'=>$id]);
//		echo "ID:$id\n";
//		print_r($array);
		return [$array[0]['name'],$array[0]['weight']];
	}

        function didTeamWin(){
            $win = $this->teams[$this->team] == 1 ? 1 : 0 ;
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
                $this->uid = $holding[0]['id'];
                $this->user = ['name' => $holding[0]['name'], 'team' => $holding[0]['team'], 'events' => $holding[0]['events'], 'win' => $this->didTeamWin() , 'uid' => $holding[0]['id'] ];
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
            $this->translationMatrix = array();
            foreach($output as $rarity=>$level){
                $this->translationMatrix[] = $rarity;
            }
            $this->weight = $output;
        }

        function getPrizes($rarity){
            /* this exists so I can switch from array to sqlite without dying inside
                should return in the same format as the array
            */
            // echo "Rarity is $rarity\n";
            $query = "SELECT * FROM prizes WHERE weight = :rarity and reference != :reference AND used=0";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute(["rarity"=>$this->weightID[$rarity],"reference"=>$this->uid]);
            $holding = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($holding);
            return $holding;
        }

        function getClaimedPrizes(){
            $query = "SELECT * FROM claimed WHERE codeID=:code";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute(['code' => $this->user['uid']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function rng($exclude=null){
            /* Two rolls : 
                1) determine rarity
                2) determine which prize from that rarity, this can be meh rng
            */

//            $rarity = $this->determineRarity();

//            $max = count($this->getPrizes($rarity))-1;
		// Error checking for exhausted prizes
		$max = 0;
		$errorCheck = 0;
		while($max==0){
			$rarity = $this->determineRarity();
			$max = count($this->getPrizes($rarity))-1;
			$errorCheck += 1;
			if($errorCheck > 100){ die('Prizes really are depleted wut.'); }
		}

            $prizes = $this->getPrizes($rarity);

            $rng = mt_rand(0,$max);

            if(@$this->count[$rarity]){
                $this->count[$rarity] = $this->count[$rarity] + 1;
            }
            else{
                $this->count[$rarity] = 1;
            }
            if($exclude!=null){
                while($exclude == $prizes[$rng]['id']){
		    if($max == 0){ die('o no prizes exhausted D:'); }
                    $rng = mt_rand(0,$max);
                }
            }
            $this->lockItem($prizes[$rng]['id']);
	    return $prizes[$rng]['id'];
//            return '['.$rarity.'] : '.$prizes[$rng]['name'];

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

        function getMyPrizes($code){
            $this->code = $code;
            if(!@$this->checkCode()){
                echo 'Invalid code!';
            }
            else{
                echo 'Welcome, '.$this->getName().'! You participated in '.$this->events.' events and were'.($this->didTeamWin()?' ':' not ')."part of the winning team!\n";
            }

            
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
            $query = "UPDATE prizes set used=1 where id = :id";
        }

        function getRolledPrizes(){
            $query = "SELECT * FROM prizes where used=0";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute();
            $holding = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $holding;
        }

        /* Render Section */

        function displayPrizeTable(){
            $tableRow = 1;
            echo "<table>
            <th>Prize</th>
            <th>Rarity Level</th>";
            foreach($this->getRolledPrizes() as $prize){
                $tableRow = $tableRow == 1 ? 0 : 1 ;
                echo '<tr '.($tableRow == 1 ? 'class="alt-table"' : '' ).'><td>'.$prize['name'].'</td><td>'.$this->translationMatrix[($prize['weight']-1)].'</td></tr>';
            }
            echo "</table>";
        }

        function displayCodeInput(){
            include('tmpl/codeInput.html');
        }

        function displayPage(){
            include('tmpl/page.php');
        }

        function lockItem($itemCode){
            $query = "Update prizes set used=1 where id=:id";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute(['id'=>$itemCode]);
	    $query = "Insert into claimed (`prizeID`,`codeID`) VALUES (:prizeID, :codeID)";
	    $stmt = $this->PDO->prepare($query);
	    $stmt->execute(['prizeID'=>$itemCode,'codeID'=>$this->user['uid']]);
        }

        function rerollItem($itemCode){
            // Should be an array with the claimedID and prizeID
            $query = "SELECT count(*) FROM rerolls WHERE claimedID=:claimed";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute(['claimed' => $itemCode['claimID']]);
            $count = $stmt->fetchAll();
            if($count[0][0] == 0){
               $prize = $this->rng($itemCode['prizeID']);
		$query = "delete from claimed where prizeID = :prizeID";
		$stmt = $this->PDO->prepare($query);
		$stmt->execute(['prizeID'=>$itemCode['prizeID']]);
		$query = "update prizes set used=0 where id = :prizeID";
		$stmt = $this->PDO->prepare($query);
		$stmt->execute(['prizeID'=>$itemCode['prizeID']]);
            }
            else{
                // NU H UH
                echo "nuh uh";
            }
        }

    }

    include('tmpl/page.php');
    
