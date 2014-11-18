<?PHP
//ini_set('max_execution_time', 300);
include '../includes/connection.php';
$stunum = $_GET['stunum'];
$tcount = $_GET['count'];

$qq = "SELECT * FROM `schedule` WHERE `stu_num_rand` = '$stunum' AND `num_classes` = '$tcount'";
//echo $qq.'<br>';
$ress = mysql_query($qq,$conm);
$q = "DELETE FROM `schedule` WHERE `stu_num_rand` = '$stunum' AND `days` = ''";
mysql_query($q);
$cc = mysql_num_rows($ress);
//echo 'NUMBER OF ROWS: '.$cc.'<br>';
$ccc = 0;
//echo 'GET DAYS<br>';
$car = array(0,0,0,0,0,0,0);
$days = array(0,0,0,0,0);
while($ccc < $cc){
	$days[0] = 0; $days[1] = 0;$days[2] = 0;$days[3] = 0;$days[4] = 0;
	$ccc++;
	$restrow = mysql_fetch_row($ress);
	$ttcount = 0;
			while($ttcount < 7){
				$car[$ttcount] = $restrow[$ttcount+3];
				//echo 'Class '.$ttcount.': '.$restrow[$ttcount+3].'<br>';
				$ttcount++;
			}
	$count = 0;
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
//echo $days[0].' '.$days[1].' '.$days[2].' '.$days[3].' '.$days[4].'<br>';
$day = '';
if($days[0] == 1)
	$day .= 'M';
if($days[1] == 1)
	$day .= 'T';
if($days[2] == 1)
	$day .= 'W';
if($days[3] == 1)
	$day .= 'R';
if($days[4] == 1)
	$day .= 'F';
//echo 'Day = '.$day.'<br>';
//GET THE HOURS
$i = 0;
$hours = 0;
while($i < 7){
	$num = $car[$i];
	$q = "SELECT `credits` FROM `class_num` WHERE `number` = '$num'";
	$res = mysql_query($q,$conm);
	$row = mysql_fetch_row($res);
	$hours += $row[0];
	$i++;
}
//echo $hours.'<br>';
$q = "INSERT INTO schedule(stu_num_rand,num_hours,days,class_num,class2_num,class3_num,class4_num,class5_num,class6_num,class7_num,num_classes)";
$q .= " VALUES('$stunum','$hours','$day','$car[0]','$car[1]','$car[2]','$car[3]','$car[4]','$car[5]','$car[6]','$tcount')";
mysql_query($q,$conm);
//echo $q.'<br>';

}
include '../includes/redirectone.php';

?>