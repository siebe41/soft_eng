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
//FILE TO GENERATE THE SCHEDULES
//ADDS THE CONNECTION TO THE DATABASE
include '../includes/connection.php';
//ADDS THE FUNCTIONS TO CHECK FOR SCHEDULE LEGALITY
include 'daylogic.php';

//GETS SELECTED CLASSES FROM PREVIOUS PAGE
$tableData = $_POST['tableData'];
//STORES CLASSES INTO AN ARRAY
$array = json_decode($tableData,TRUE);
//GENERATES A RANDOM NUMBER FOR THE STUDENT
$stunum = rand();
//GETS THE NUMBER OF CLASSES SELECTED
$size = count($array);
$count = 0;//count should always equal the number of classes in a students schedule

//Removes other schedules with the same student random number should they exist
$q = "DELETE FROM `schedule` WHERE `stu_num_rand` = '$stunum'";
//EXECUTES QUERY
mysql_query($q,$conm);

$name = $array[0];//gets the first class from the array passed to this page

//gets the list of class numbers that correspond to this class name
$q = "SELECT `number` FROM `class_num` WHERE `name` = '$name'";
//EXECUTES QUERY
$res = mysql_query($q,$conm);
$rcount = mysql_num_rows($res); // counts the number of numbers 

//THIS SECTION CREATES THE FIRST SCHEDULE FROM THE LIST OF CLASS NUMBERS OF THE FIRST CLASS
while($rcount > 0){
	$rcount--;//DECREMENT COUNT
	//GETS THE NEXT ROW WHICH HOLDS THE NEXT SECTION OF THE CLASS WE ARE ADDING
	$rnum = mysql_fetch_row($res);
	//STORE THE COURSE NUMBER
	$num = $rnum[0];
	//WRITES QUERY TO INSERT THE CLASS INTO THE SCHEDULE DB
	$q = "INSERT INTO schedule(stu_num_rand,class_num,num_classes) VALUES('$stunum','$num','1')";
	//EXECUTES QUERY
	mysql_query($q,$conm);
}
$count++;//increases count to keep track of how many classes we have

//WHILE LOOP TO LOOP THROUGH ALL THE REMAINING CLASSES AND ADD THEM 
while($count < $size){
	//STORES THE COURSE NAME
	$name = $array[$count];
	//WRITES QUEYR TO GET THE COURSE NUMBERS
	$q = "SELECT `number` FROM `class_num` WHERE `name` = '$name'";
	//EXECUTES THE QUERY AND STORES THE RESULT
	$res = mysql_query($q,$conm);
	//STORES THE NUMBER OF ROWS AFFECTED
	$rcount = mysql_num_rows($res);
	//WRITES A QUERY TO DELETE THE PREVIOUS SCHEDULES
	$qq = "SELECT * FROM `schedule` WHERE `stu_num_rand` = '$stunum' AND `num_classes` = '$count'";

	while($rcount > 0){//for each section of the class add a new schedule
		$rcount--;//DECREMENT
		//GET THE RESULT OF THE QUERY AS IT IS NOW
		$rest = mysql_query($qq,$conm);
		//GET THE NUMBER OF ROWS RETURNED
		$rtcount = mysql_num_rows($rest);
		//GET THE CURRENT ROW FROM RESULT
		$resrow = mysql_fetch_row($res);
		//STORE THE COURSE NUMBER
		$num = $resrow[0];
		//CREATE TEMP VAR TO USE AS COUNTER
		$tempcount = $rtcount;
		while($tempcount > 0){//get info from previous schedules
			$tempcount--;//DECREMENT
			//INITIALIZE ARRAYS FOR CLASSES, DAYS, START AND END TIMES
			$car = array(0,0,0,0,0,0,0);
			$days = array(0,0,0,0,0,0,0);
			$stime = array(0,0,0,0,0,0,0);
			$etime = array(0,0,0,0,0,0,0);
			//GETST HE NEXT ROW
			$restrow = mysql_fetch_row($rest);
			$ttcount = 0;//RESETS COUNTER
			while($ttcount < 7){//LOOP TO GET ALL THE CLASSES CURRENTLY IN SCHEDULE
				//SETS THE CLASS ARRAY FROM QUERY RESULTS (QUERY CLASS INDEX STARTS AT 3)
				$car[$ttcount] = $restrow[$ttcount+3];
				//CHECKS FOR VALID CLASS
				if($restrow[$ttcount+3] != 0){
					//WRITES QUERY TO GET INFO ABOUT SECTION FROM CLASSLIST DB
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
				//EXECUTES QUERY AND STORES RESULT
				$resqn = mysql_query($qn,$conm);
				//GETS ROW OF QUERY
				$nrow = mysql_fetch_row($resqn);
				//GETS START AND END TIME AND DAYS AND STORES THEM IN VARIABLES
				$nstime = $nrow[0];
				$netime = $nrow[1];
				$ndays = $nrow[2];
				$tempc = $count;//SETS TEMP COUNTER
				//RESETS COUNTER
				 $ttcount = 0;
				//CHECKS SCHEDULE
				while($ttcount < 7){
					//CALLS FUNCTION TO CHECK VALIDITY AND STORES RESULT IN A BOOL
					$bool = check_days($ndays,$days[$ttcount],$nstime,$stime[$ttcount],$netime,$etime[$ttcount]);
					$ttcount++;//INCREMENT COUNT
				}
				//CHECKS FOR VALID CLASS FROM BOOL
			if($bool){
				$tc = $count + 1;//TEMP VAR TO ADD THE RIGHT VALUE FOR NUM_CLASSES
				//WRITES QUERY TO INSERT THE SCHEDULE INTO THE DB
				$q = "INSERT INTO `schedule`(stu_num_rand,class_num,class2_num,class3_num,class4_num,class5_num,class6_num,class7_num,num_classes)";
				$q .= " VALUES('$stunum','$car[0]','$car[1]','$car[2]','$car[3]','$car[4]','$car[5]','$car[6]','$tc')";
				//EXECUTES THE QUERY
				mysql_query($q,$conm);
			}
				
		}
	}
		//WRITES QUERY TO DELETE THE OLD SCHEDULES THAT ARE NOT CURRENT
		$q = "DELETE FROM `schedule` WHERE `stu_num_rand` = '$stunum' AND `num_classes` < '$tc'";
		//EXECUTES THE QUERY
		mysql_query($q,$conm);	
	//INCREMENTS CUONT
	$count++;
}
//here goes the logic to get the days and number of hours.
include '../includes/redirecttwo.php';
?>

</body>
</html>

