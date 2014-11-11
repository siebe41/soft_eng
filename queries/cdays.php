<?php

function gdays($c1,$c2,$c3,$c4,$c5,$c6,$c7){
	$count = 0;
	$days = array(0,0,0,0,0);
	$ar = array($c1,$c2,$c3,$c4,$c5,$c6,$c7);
	while($count < 7){
		$num = $ar[$count];
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
	return $days;
}



?>
