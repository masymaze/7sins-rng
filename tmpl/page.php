<?php
//    echo '<pre>';
    $mysteryBox = new mysteryBox();
?>

<title>7Sins Triathlon</title>

<link rel='stylesheet' href='style.css' />

<div class='topBanner'>
	<div class="floatRight">
		<small><?php if(@$_GET['code']||@$_GET['report']){ echo "<a href='/mysteryBox.php'>Go back?</a> | "; } ?>
			<a href='/?report=1'>View Claimed Prizes</a>
		</small>
	</div>
	<h1>7Sins Triathlon Prizes</h1>
</div>

<!---
<table>
    <th>Prize</th>
    <th>Rarity Level</th>
<?php

  //  $mysteryBox->displayPrizeTable();

?>
</table> --->



<div style=' width:90%;margin:auto;'>


<?php
if(@$_GET['report']==1){

                $query = "SELECT * FROM boxes";
                $mb = new mysteryBox();
                $table = $mb->runQuery($query);

                $mb->getWeight();
                $rarity = $mb->translationMatrix;
                echo "<table><th>Timestamp</th><th>Name</th><th>Prize</th><th>Rarity</th><th>Re-rolled?</th>";
                foreach($table as $prize){
                        echo "<tr><td>";
			echo $prize['timestamp'];
			echo "</td><td>";
                        echo ($mb->getNameByID($prize['codeID']))[0]['name'];
                        echo "</td><td>";
                        echo ($mb->getPrizeByID($prize['prizeID']))[0];
                        echo "</td><td>";
                        echo $rarity[(($mb->getPrizeByID($prize['prizeID']))[1]-1)];
                        echo "</td><td>";
                        echo $prize['rerolled']==1?"Yes":"No";
                        echo "</td></tr>";
                }
                echo "</table>";
		echo "<hr /><small>Times are in GMT+0 - AKA Server Time :D</small>";

	die(); // LAZY I KNOW
}
?>

<table>
    <tr>
        <td> <!--- Prize Info --->
            <?php $mysteryBox->getRolledPrizes(); ?>
        </td>
        <td> <!--- Code render --->
            <?php 

                if(@$_GET['code']){
			$mysteryBox->getWeight(); // Needed for translation matrix, meh.

			echo '<p><strong>Welcome, '.$mysteryBox->user['name'].'!</strong></p>';
				$ev=$mysteryBox->user['events'];
				$win=$mysteryBox->user['win'];
			if($win == 1){
				echo '<p>Congratulations for being on the winning team!</p>';
				echo '<p>As you participated in '.$ev.' event'.($ev>1?'s':'').' and were on the winning team, you are entitled to '.$ev.' box'.($ev>1?'es':'').'</p>';
			}
			else {
				echo '<p>Sadly, your team did not win :(</p>';
				echo '<p>Whilst you participated in '.$ev.' event'.($ev>1?'s':'').', you are only entitled to one box due to being on the losing team.';
			}
			echo "<p>Each box may be re-rolled one time.</p>";
//                    echo 'Welcome '.$mysteryBox->user['name'].'! '.($mysteryBox->user['win']==1?'Congratulations on winning!':'Unfortunately your team did not win :(')."\n";
  //                  echo "\nAs you participated in ".$mysteryBox->user['events'].' event'.($mysteryBox->user['events']!=1?'s':'').', you are entitled to '.$mysteryBox->user['events'].' box'.($mysteryBox->user['events']!=1?'es':'').'!';
                    echo "<hr /><table><th>Prize</th><th>Rarity</th><th>Re-roll</th>";
                    foreach ( $mysteryBox->getBoxArray() as $row ){
			if($row['prizeID'] != 0 ){
				$prize = $mysteryBox->getPrizeByID($row['prizeID']);
				$name = $prize[0];
				$weight = $prize[1]; 
				$rarity = $mysteryBox->translationMatrix[$weight-1];
				$dev = $prize;
			}
			echo "<tr><td>".($row['prizeID']==0?'Not Rolled - '.$mysteryBox->genLink($row['boxID'],$row['codeID']):$name);
			echo "</td><td>";
			echo ($row['prizeID']!=0?$rarity:'N/A');
			echo "</td><td>".($row['rerolled'] != 1 ? $mysteryBox->genReroll($row['boxID'],$row['codeID']) : 'Used' )."</td></tr>";
		    }
			echo "</table>";
			echo "<hr /><strong>Important: There is no backup, re-rolls are irreversible.</strong>";
                }
                else{
                    $mysteryBox->displayCodeInput(); 
                }
            ?>
        </td>
</table>
</div>
