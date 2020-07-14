<?php

    // Proof of concept

    $dataBase = array( // YES THIS IS A DATABASE SUE ME Q.Q it'll be sqlite later i swear


        /*

        create table codes ( id int not null primary key , code text, name text , events int , team int );
        create table teams ( id int not null primary key , leader int );
        insert into teams (`id`,`leader`) values ( 1 , 2 );
        insert into teams (`id`,`leader`) values ( 2 , 7 );
        insert into codes (`id`,`code`,`name`,`events`,`team`) values ( 1, 'TEST001', 'Masya' , 3 , 1);
        insert into codes (`id`,`code`,`name`,`events`,`team`) values ( 2, 'TEST002', 'Historia' , 3 , 1);
        insert into codes (`id`,`code`,`name`,`events`,`team`) values ( 3, 'TEST003', 'Karn' , 3 , 1);
        insert into codes (`id`,`code`,`name`,`events`,`team`) values ( 4, 'TEST004', 'Wendy' , 2 , 1);
        insert into codes (`id`,`code`,`name`,`events`,`team`) values ( 5, 'TEST005', 'Melittie' , 2 , 1);
        insert into codes (`id`,`code`,`name`,`events`,`team`) values ( 6, 'TEST006', 'Shia' , 3 , 2);
        insert into codes (`id`,`code`,`name`,`events`,`team`) values ( 7, 'TEST007', 'Saidi' , 3 ,2 );
        insert into codes (`id`,`code`,`name`,`events`,`team`) values ( 8, 'TEST008', 'Auri' , 2 , 2);

        create table weight ( id int not null primary key , name text , weight int );

        insert into weight (`id`,`name`,`weight`) values ( 1 , 'Common', 50 );
        insert into weight (`id`,`name`,`weight`) values ( 2 , 'Uncommon', 40 );
        insert into weight (`id`,`name`,`weight`) values ( 3 , 'Rare', 30 );
        insert into weight (`id`,`name`,`weight`) values ( 4 , 'Super Rare', 20 );
        insert into weight (`id`,`name`,`weight`) values ( 5 , 'Legendary', 10 );

        weight -> id in weight , reference -> references code to avoid it being drawn
        create table prizes ( id int not null primary key , name text, weight int , used int , reference int );

        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 1, 'PotD Hairstyle : Samsonian Locks', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 2, 'You may help plan the next event', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 3, 'Swimwear Glam of your choosing', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 4, 'Any minion from the list', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 5, 'Any furniture from the list', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 6, 'You will receive 200x XP food for levelling', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 7, 'Emote : Bread', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 8, '99x HQ Chocolate', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 9, 'PotD Runs 51-60 x10 (Or 1-50 x1 for unlock and 51-60 x5)', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 10, 'HoH Runs 21-30 x10 (Or 1-30 x1 for unlock and 21-30 x5)', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 11, 'Glamour : Pagos Shirt', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 12, 'Glamour : Glacial Coat', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 13, 'Glamour : New World Jacket', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 14, 'Glamour : Wind Silk Coatee', 1, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 15, 'Lala Hug Voucher', 1, 0, 5);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 16, 'Fantasia a volunteer for a week', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 17, 'Fantasia a volunteer for a week', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 18, 'Masya will keep her glamour contest glam and appearance for a month', 2, 0, 1);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 19, 'Any orchestrion roll from the list', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 20, 'Orchestrion Roll : A long fall', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 21, 'Unsync carry through any non-savage/24-man content pre-SHB', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 22, 'Sync carry through any 24 man contents ', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 23, 'Sky Blue Parasol', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 24, 'Mount : Dhalmel', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 25, 'Combat materia from chez Saidi (VII)', 2, 0, 7);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 26, 'Metallic, dark and pastel dyes from chez Saidi', 2, 0, 7);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 27, 'Pre-made 8-man party for all 3 Ivalice raids (or queue booster!)', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 28, "Glamour : Craftman's Apron", 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 29, 'PotD floor 50 or 100 unlock', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 30, 'HoH floor 30 unlock', 2, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 31, 'Glamour Masya however you want for a week', 3, 0, 1);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 32, 'Glamour Shia however you want for a week', 3, 0, 6);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 33, '500k Gil', 3, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 34, 'Masya will become a viera and only wear skimpy outfits + viera heels for a week', 3, 0, 1);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 35, 'Personal Mount Farm (HW or lower)', 3, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 36, 'Any one non-shinryuu shiny weapon will be crafted for you', 3, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 37, "30 mins of Masya's time (any in-game task - standard rules apply)", 3, 0, 1);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 38, "30 mins of Shia's time (any in-game task - standard rules apply)", 3, 0, 6);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 39, 'Full set of crafter or gatherer gear for any given level (ilvl 430 at most)', 3, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 40, 'Combat materia from chez Saidi (VIII)', 3, 0, 7);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 41, 'Eureka Farm up to level 20', 3, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 42, "Glamour : Craftman's Coverall Top", 3, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 43, "2 hrs of Masya's time (any in-game task - standard rules apply)", 4, 0, 1);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 44, "2 hrs of Shia's time (any in-game task - standard rules apply)", 4, 0, 6);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 45, 'Fantasia Masya into Hrothgar or Roe for a week, Lala for a month or anything else for two weeks', 4, 0, 1);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 46, 'Glamour Entire Losing Team', 4, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 47, 'Glamour Masya however you want for two weeks', 4, 0, 1);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 48, 'Glamour Shia however you want for two weeks', 4, 0, 6);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 49, 'Temporary FC Rank just for you for one month', 4, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 50, 'Any one item with material cost of less than 1m will be crafted for you, materials provided', 4, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 51, 'FC-wide vote on fantasia-ing randomly picked volunteer (1 week)', 4, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 52, 'Fantasia Entire Losing Team for a week', 5, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 53, 'Fantasia Shia into Hrothgar for a week or anything else for 2 weeks', 5, 0, 6);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 54, 'Mogstation item with a value of £6 or less', 5, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 55, 'Full set of hand-crafted Neo-Ishgardian (all slots)', 5, 0, 0);
        insert into prizes (`id`,`name`,`weight`,`used`,`reference`)  values ( 56, 'You will receive 1x Fantasia to do with as you please, use on yourself or other', 5, 0, 0);


        */


        'Codes' => array(
            'TEST001' => array(
                'Name' => 'Masya',
                'Events' => 3,
                'Win' => true
            ),
            'TEST002' => array(
                'Name' => 'Historia',
                'Events' => 3,
                'Win' => true
            ),
            'TEST003' => array(
                'Name' => 'Karn',
                'Events' => 3,
                'Win' => true
            ),
            'TEST004' => array(
                'Name' => 'Wendy',
                'Events' => 2,
                'Win' => true
            ),
            'TEST005' => array(
                'Name' => 'Melittie',
                'Events' => 2,
                'Win' => true
            ),
            'TEST006' => array(
                'Name' => 'Shia',
                'Events' => 3,
                'Win' => false
            ),
            'TEST007' => array(
                'Name' => 'Saidi',
                'Events' => 3,
                'Win' => false
            ),
            'TEST008' => array(
                'Name' => 'Auri',
                'Events' => 2,
                'Win' => false
            )
        ),
        'Prizes' => array(
            'Common' => array(            
                'PotD Hairstyle : Samsonian Locks',
                'You may help plan the next event',
                'Swimwear Glam of your choosing',
                'Any minion from the list',
                'Any furniture from the list',
                'You will receive 200x XP food for levelling',
                'Emote : Bread',
                '99x HQ Chocolate',
                'PotD Runs 51-60 x10 (Or 1-50 x1 for unlock and 51-60 x5)',
                'HoH Runs 21-30 x10 (Or 1-30 x1 for unlock and 21-30 x5)',
                'Glamour : Pagos Shirt',
                'Glamour : Glacial Coat',
                'Glamour : New World Jacket',
                'Glamour : Wind Silk Coatee',
                'Lala Hug Voucher'
            ) ,
            'Uncommon' => array(
                'Fantasia a volunteer for a week',
                'Fantasia a volunteer for a week',
                'Masya will keep her glamour contest glam and appearance for a month',
                'Any orchestrion roll from the list',
                'Orchestrion Roll : A long fall',
                'Unsync carry through any non-savage/24-man content pre-SHB',
                'Sync carry through any 24 man contents ',
                'Sky Blue Parasol',
                'Mount : Dhalmel',
                'Combat materia from chez Saidi (VII)',
                'Metallic, dark and pastel dyes from chez Saidi',
                'Pre-made 8-man party for all 3 Ivalice raids (or queue booster!)',
                'Glamour : Craftman\'s Apron',
                'PotD floor 50 or 100 unlock',
                'HoH floor 30 unlock',
            ),
            'Rare' => array(
                'Glamour Masya however you want for a week',
                'Glamour Shia however you want for a week',
                '500k Gil',
                'Masya will become a viera and only wear skimpy outfits + viera heels for a week',
                'Personal Mount Farm (HW or lower)',
                'Any one non-shinryuu shiny weapon will be crafted for you',
                '30 mins of Masya\'s time (any in-game task - standard rules apply)',
                '30 mins of Shia\'s time (any in-game task - standard rules apply)',
                'Full set of crafter or gatherer gear for any given level (ilvl 430 at most)',
                'Combat materia from chez Saidi (VIII)',
                'Eureka Farm up to level 20',
                'Glamour : Craftman\'s Coverall Top',
                '2 hrs of Masya\'s time (any in-game task - standard rules apply)',
                '2 hrs of Shia\'s time (any in-game task - standard rules apply)',
            ),
            'Super Rare' => array(
                'Fantasia Masya into Hrothgar or Roe for a week, Lala for a month or anything else for two weeks',
                'Glamour Entire Losing Team',
                'Glamour Masya however you want for two weeks',
                'Glamour Shia however you want for two weeks',
                'Temporary FC Rank just for you for one month',
                'Any one item with material cost of less than 1m will be crafted for you, materials provided',
                'FC-wide vote on fantasia-ing randomly picked volunteer (1 week)',
            ),
            'Legendary' => array(
                'Fantasia Entire Losing Team for a week',
                'Fantasia Shia into Hrothgar for a week or anything else for 2 weeks',
                'Mogstation item with a value of £6 or less',
                'Full set of hand-crafted Neo-Ishgardian (all slots)',
                'You will receive 1x Fantasia to do with as you please, use on yourself or other',
            )
        ),
        'Weight' => array(
            'Common' => 50,
            'Uncommon' => 40,
            'Rare' => 30,
            'Super Rare' => 20,
            'Legendary' => 10
        )
    ); 

    class mysteryBox {

        public $dataBase;

        public $count;

        public $PDO;
    
        function __construct($db,$code=null){
            $this->$PDO = new PDO('sqlite:'.$db);
            
            $this->dataBase = $db;
            $this->count = array();

            $this->code = $code;

            if(!@$this->checkCode()){
                echo 'Invalid code!';
            }
            else{
                $this->getParticipation();
                echo 'Welcome, '.$this->getName()."!\n";
            }
        }

        function checkCode(){
            /* another sqlite bodge */
            $query = "SELECT * FROM codes WHERE code = :code";
            $stmt = $this->PDO->prepare($query);
            $stmt->execute(['code'=>$this->code]);
            print_r($stmt);
            return @$this->dataBase['Codes'][$code] ? true : false;
        }

        function getName(){
            return $this->dataBase['Codes'][$this->code]['Name'];
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
            return '['.$rarity.'] : '.$prizes[$rng];

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


        function getParticipation(){
            $this->win = $this->dataBase['Codes'][$this->code]['Win'];
            $this->events = $this->dataBase['Codes'][$this->code]['Events'];
        }
        

        function getMyPrizes(){
            // Assumes 3 events, and winning team, and no reroll
            $win = $this->win;
            $events = $this->events;

            if($win){
                for($i = 0; $i < $events ; $i++ ){
                    echo 'Congratulations! You have won : '.$this->rng()."!\n";
                }
            }
            else{
                if ( $events == 3 ) {
                    echo 'Congratulations! You have won : '.$this->rng()."!\n";
                }
                echo 'Congratulations! You have won : '.$this->rng()."!\n";
            }

        }
        function removeCode($code){
        }

    }


  /*  $results = array();
 /*   for($i=0;$i<12;$i++){
        $results[] = $mysteryBox->rng();
    }
//    echo '<pre>';
//    print_r($results);

    print_r($mysteryBox->count);
    print_r($results);
*/


    for($i=1;$i<9;$i++){
        $mysteryBox = new mysteryBox($dataBase,'TEST00'.$i);
        $mysteryBox->getMyPrizes();
    }


    