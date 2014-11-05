<?php
//File to get the schedules
include '../includes/connection.php';

$array = array('70049','70062','70023','70019');

$size = count($array);
$count = 0;
echo 'Here is a list of sections of all the course numbers you chose<br>';
while($size > $count){

	$num = $array[$count];
	$count++;
	$q = "SELECT * FROM `classlist` WHERE `number` = '$num'";
	$res = mysql_query($q,$conm);
	$t = mysql_num_rows($res);
	while($t > 0){
		$t--;
		$row = mysql_fetch_array($res);
		echo $row[0].' '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4].' '.$row[5].' '.$row[6].'<br>';
	
	}
	
	
}
//check time logic
//if start time 1 == start time 2 => same time
//if end time 1 == end time 2 => same time
//if start time 1 > start time 2 && end time 1 < end time 2 => same time -- ex geo lab, 1-3:50 this would apply to 2-2:50 classes


?>

<html>
<body>

</body>
</html>