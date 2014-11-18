
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
include 'daylogic.php';
//include 'cdays.php';

$tableData = $_POST['tableData'];
$array = json_decode($tableData,TRUE);
$stunum = rand();
$size = count($array);
//echo $size.'<br>'; //TESTING OUTPUT
$count = 0;//count should always equal the number of classes in a students schedule

//Removes other schedules with the same student random number should they exist
$q = "DELETE FROM `schedule` WHERE `stu_num_rand` = '$stunum'";
mysql_query($q,$conm);

$name = $array[0];//gets the first class from the array passed to this page
//echo 'Name: '.$name.'<br>';//echos the name for testing purposes

//gets the list of class numbers that correspond to this class name
$q = "SELECT `number` FROM `class_num` WHERE `name` = '$name'";
$res = mysql_query($q,$conm);
$rcount = mysql_num_rows($res); // counts the number of numbers 
//echo $q.'<br>'; // echo for testing purposes
//echo 'Rcount'.$rcount.'<br>';//echos for testing purposes

//THIS SECTION CREATES THE FIRST SCHEDULE FROM THE LIST OF CLASS NUMBERS OF THE FIRST CLASS
while($rcount > 0){
	$rcount--;
	$rnum = mysql_fetch_row($res);
	$num = $rnum[0];
	//echo 'Number: '.$num.'<br>';
	$q = "INSERT INTO schedule(stu_num_rand,class_num,num_classes) VALUES('$stunum','$num','1')";
	//echo $q.'<br>';
	mysql_query($q,$conm);
}
$count++;//increases count to keep track of how many classes we have

while($count < $size){
	$name = $array[$count];
	//echo 'Name: '.$name.'<br>';
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
		//echo 'Number: '.$num.'<br>';
		$tempcount = $rtcount;
		while($tempcount > 0){//get info from previous schedules
			$tempcount--;
			$car = array(0,0,0,0,0,0,0);
			$days = array(0,0,0,0,0,0,0);
			$stime = array(0,0,0,0,0,0,0);
			$etime = array(0,0,0,0,0,0,0);
			$restrow = mysql_fetch_row($rest);
			$ttcount = 0;
			while($ttcount < 7){
				$tp3 = $ttcount+3;
				$car[$ttcount] = $restrow[$ttcount+3];
				if($restrow[$ttcount+3] != 0){
					$qqr = "SELECT `start_time`,`end_time`,`days` FROM `classlist` WHERE `number` = '$restrow[$tp3]'";
					//echo $qqr.'<br>';
					$resqr = mysql_query($qqr,$conm);
					$rowqr = mysql_fetch_row($resqr);
					$stime[$ttcount] = $rowqr[0];
					$etime[$ttcount] = $rowqr[1];
					$days[$ttcount] = $rowqr[2];
				}
				$ttcount++;
			}
			$car[$count] = $num;
			// HERE WILL BE THE LOGIC TO CHECK if the schedule is valid, the q will go by a bool
			
			// Gets the start time and end time of the class we are looking at
			// need logic for days
				$qn = "SELECT `start_time`,`end_time`,`days` FROM `classlist` WHERE `number` = '$num'";
				//echo $qn.'<br>';
				$resqn = mysql_query($qn,$conm);
				$nrow = mysql_fetch_row($resqn);
				$nstime = $nrow[0];
				$netime = $nrow[1];
				$ndays = $nrow[2];
				$tempc = $count;
				//echo 'Days and Times check<br>';
				//echo $nstime.' '.$netime.' '.$ndays.' '.$tempc.'<br>';
				//echo $stime[$ttcount].' '.$etime[$ttcount].' '.$days[$ttcount].'<br>';
				 $ttcount = 0;
			
				while($ttcount < 7){
					//echo 'Call check days<br>';
					$bool = check_days($ndays,$days[$ttcount],$nstime,$stime[$ttcount],$netime,$etime[$ttcount]);
					//echo 'Check days return. '.$bool.'<br>';
					$ttcount++;
				}
				
			if($bool){
				$tc = $count + 1;
				$q = "INSERT INTO `schedule`(stu_num_rand,class_num,class2_num,class3_num,class4_num,class5_num,class6_num,class7_num,num_classes)";
				$q .= " VALUES('$stunum','$car[0]','$car[1]','$car[2]','$car[3]','$car[4]','$car[5]','$car[6]','$tc')";
				mysql_query($q,$conm);
				//echo $q.'<br>';
			}
				
		}
	}
	
		$q = "DELETE FROM `schedule` WHERE `stu_num_rand` = '$stunum' AND `num_classes` < '$tc'";
		mysql_query($q,$conm);
	echo 'DELETE STEP: '.$q.'<br>';
	
	
	$count++;
}
//here goes the logic to get the days and number of hours.
include '../includes/redirecttwo.php';
?>

</body>
</html>

