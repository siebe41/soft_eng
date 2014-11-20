<?php
//THIS FILE IS NO LONGER USED
//THIS WAS INTENDED TO BE USED AS A FUNCTION AND NOW THE CODE HAS BEEN MOVED TO ANOTHER FILE WHERE IT WILL FLOW BETTER
//KEEPING THIS FILE AS AN ARTIFACT AND PROOF OF SYSTEM CHANGE/ADAPTATION

	include '../includes/connection.php';
//function gdays($c1,$c2,$c3,$c4,$c5,$c6,$c7){	//THIS WAS A FUNCTIONAL CHANGE FROM USING THIS AS A FUNCTION TO INCLUDING IT
	$count = 0;
	echo 'HELLO<br>';
	$days = array(0,0,0,0,0);
	$ar = array($car[0],$car[1],$car[2],$car[3],$car[4],$car[5],$car[6]);
	//$ar = array(70006,70048,71211,0,0,0,0);
	while($count < 7){
		$num = $ar[$count];
		$count++;
		if($num > 0){
		$q = "SELECT `days` FROM `classlist` WHERE `number` = '$num'";
		$res = mysql_query($q,$conm);
		$row = mysql_fetch_row($res);
		$ds = $row[0];
		switch($ds){
			case 'M':
				$days[0] = 1;
				break;
			case 'W':
				$days[2] = 1;
				break;
			case 'F':
				$days[4] = 1;
				break;
			case 'MW':
				$days[0] = 1;
				$days[2] = 1;
				break;
			case 'MF':
				$days[0] = 1;
				$days[4] = 1;
				break;
			case 'WF':
				$days[4] = 1;
				$days[2] = 1;
				break;
			case 'MWF':
				$days[0] = 1;
				$days[4] = 1;
				$days[2] = 1;
				break;
			case 'T':
				$days[1] = 1;
				break;
			case 'R':
				$days[3] = 1;
				break;
			case 'TR':
				$days[1] = 1;
				$days[3] = 1;
				break;
			case 'MTWR':
				$days[0] = 1;
				$days[1] = 1;
				$days[3] = 1;
				$days[2] = 1;
				break;
			case 'MTWRF':
				$days[0] = 1;
				$days[1] = 1;
				$days[2] = 1;
				$days[3] = 1;
				$days[4] = 1;
				break;

		}
	}


	}
	echo $days[0].'<br>';
		echo $days[1].'<br>';
			echo $days[2].'<br>';
				echo $days[3].'<br>';
					echo $days[4].'<br>';

	//return $days;
//}



?>
