
<html>
<head>
<style>
body{
white-space: pre;
}
</style>
</head>
<body>
<?php
//File to get the schedules
include '../includes/connection.php';
//include 'setup.php';
$array = array("COMP SCI   53 - Introduction To Programming",'COMP SCI  153 - Data Structures','COMP SCI  253 - Algorithms');
$stunum = rand();
$size = count($array);
$count = 0;//count should always equal the number of classes in a students schedule

//Removes other schedules with the same student random number should they exist
$q = "DELETE FROM `schedule` WHERE `stu_num_rand` = '$stunum'";
mysql_query($q,$conm);
$name = $array[0];
echo 'Name: '.$name.'<br>';
$q = "SELECT `number` FROM `class_num` WHERE `name` = '$name'";
$res = mysql_query($q,$conm);
$rcount = mysql_num_rows($res);//ERROR HERE NEED TO INVESTIGATE
echo $q.'<br>';
$rcount = 4;
echo 'Rcount'.$rcount.'<br>';

while($rcount > 0){
	$rcount--;
	$rnum = mysql_fetch_row($res);
	$num = $rnum[0];
	echo 'Number: '.$num.'<br>';
	$q = "INSERT INTO schedule(stu_num_rand,class_num,num_classes) VALUES('$stunum','$num','1')";
	echo $q.'<br>';
	mysql_query($q,$conm);
}
$count++;

while($count < $size){
	$name = $array[$count];
	echo 'Name: '.$name.'<br>';
	$q = "SELECT `number` FROM `class_num` WHERE `name` = '$name'";
	$res = mysql_query($q,$conm);
	$rcount = mysql_num_rows($res);
	$qq = "SELECT * FROM `schedule` WHERE `stu_num_rand` = '$stunum' AND `num_classes` = '$count'";

	while($rcount > 0){//for each section of the class add a new schedule
		$rcount--;
		$rest = mysql_query($qq,$conm);
		$rtcount = mysql_num_rows($rest);
		$resrow = mysql_fetch_row($res);
		$num = $resrow[0];
		echo 'Number: '.$num.'<br>';
		$tempcount = $rtcount;
		while($tempcount > 0){//get info from previous schedules
			$tempcount--;
			$car = array(0,0,0,0,0,0,0);
			$restrow = mysql_fetch_row($rest);
			$ttcount = 0;
			while($ttcount < 7){
				$car[$ttcount] = $restrow[$ttcount+3];
				$ttcount++;
			}
			$car[$count] = $num;
			//HERE WILL BE THE LOGIC TO CHECK if the schedule is valid, the q will go by a bool
			//check time logic
			//if start time 1 == start time 2 => same time
			//if end time 1 == end time 2 => same time
			//if start time 1 > start time 2 && end time 1 < end time 2 => same time -- ex geo lab, 1-3:50 this would apply to 2-2:50 classes
			$q = "INSERT INTO `schedule`(stu_num_rand,class_num,class2_num,class3_num,class4_num,class5_num,class6_num,class7_num,num_classes)";
			$q .= " VALUES('$stunum','$car[0]','$car[1]','$car[2]','$car[3]','$car[4]','$car[5]','$car[6]','$count')";
			mysql_query($q,$conm);
			echo $q.'<br>';
				
		}
	}
	$q = "DELETE FROM `schedule` WHERE `stu_num_rand` = '$stunum' AND `num_classes` < '$count'";
	mysql_query($q,$conm);

	$count++;
}
?>

</body>
</html>