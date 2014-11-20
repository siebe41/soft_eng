<?PHP

//ADDS THE CONNECTION TO THE DATABASE
include '../includes/connection.php';

//GETS THE VARIABLES PASSED FROM THE PREVIOUS PAGE AND STORES THEM IN PHP VARIABLES
$stunum = $_GET['stunum'];
$tcount = $_GET['count'];

//WRITES THE QUERY TO GET ALL THE SCHEDULES FOR THE USER AND DOES AN EXTRA CHECK BY SELECTING ONLY THE ONES WITH THE CORRECT NUMBER OF CLASSES
$qq = "SELECT * FROM `schedule` WHERE `stu_num_rand` = '$stunum' AND `num_classes` = '$tcount'";
//GETS THE RESULT AND STORES IT
$ress = mysql_query($qq,$conm);

//DELETES ALL SCHEDULES FOR THE STUDENT SO WE CAN READD THEM WITH ALL THE CORRECT INFO
$q = "DELETE FROM `schedule` WHERE `stu_num_rand` = '$stunum' AND `days` = ''";
//EXECUTES THE QUERY
mysql_query($q);

//STORES THE NUMBER OF ROWS AFFECTED BY THE FIRST QUERY STORED IN $RESS
$cc = mysql_num_rows($ress);

//INITIALIZES $CCC TO 0. THIS VARIABLE IS USED AS A COUNTER
$ccc = 0;
//INITIALIZEDS THE CAR AND DAYS ARRAYS TO ZEROS THESE ARE USED TO HOLD THE CLASS NUMBERS (CAR) AND DAYS, DAYS HAS 5 VALUES ONE FOR EACH M T W R F
$car = array(0,0,0,0,0,0,0);
$days = array(0,0,0,0,0);

//WHILE LOOP TO LOOP THROUGH ALL THE ROWS RETURNED BY THE FIRST QUERY AND GET THE MISSING HOURS AND DAYS INFO AND THEN REINSERT
while($ccc < $cc){
	//RESETS THE DAY ARRAY
	$days[0] = 0; $days[1] = 0;$days[2] = 0;$days[3] = 0;$days[4] = 0;
	//INCREMENT THE COUNTER
	$ccc++;
	//GETS THE NEXT ROW
	$restrow = mysql_fetch_row($ress);
	//ZERO OUT A SEPERATE COUNTER FOR A NESTED LOOP
	$ttcount = 0;
			//LOOPS THROUGH ALL THE CLASSES IN THIS ROW
			while($ttcount < 7){
				//STORE THE CLASSES IN THE CLASS ARRAY
				$car[$ttcount] = $restrow[$ttcount+3];
				//INCREMENT COUNTER
				$ttcount++;
			}
	//RESET A COUNTER
	$count = 0;
	//SETS UP A NEW ARRAY TO HOLD THE CLASSES
	$ar = array($car[0],$car[1],$car[2],$car[3],$car[4],$car[5],$car[6]);
	//LOOPS THROUGH EACH CLASS
	while($count < 7){
		//STORES THE CURRENT CLASS NUMBER
		$num = $ar[$count];
		//INCREMENT COUNTER
		$count++;
			//CHECKS FOR VALID CLASS NUMBER
			if($num > 0){
				//SETS UP QUERY TO GET INFO FROM THE CLASSLIST DATABASE FOR THE GIVEN CLASS NUMBER
				$q = "SELECT `days` FROM `classlist` WHERE `number` = '$num'";
				//STORES THE RESULT
				$res = mysql_query($q,$conm);
				//GETS THE RESULT IN USABLE FORM
				$row = mysql_fetch_row($res);
				//STORE INTO VARIABLE
				$ds = $row[0];
				//CHECKS THE VARIABLE AND STORES THE APPROPRIATE RESULT
				//THIS ONLY MODIFIES IF IT FINDS A DAY, DOES NOT SUBTRACT DAYS
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
//INITIALIZE DAY STRING
$day = '';
//SETS UP DAY STRING BASED ON DAY ARRAY
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
	
	
//GET THE HOURS

//INITIALIZE COUNTER AND HOURS
$i = 0;
$hours = 0;
//LOOPS THROUGH EACH CLASS AND GETS THE HOURS
while($i < 7){
	//GETS CURRENT CLASS NUM
	$num = $car[$i];
	//WRITES QUERY TO GET NEEDED INFO FROM CLASS_NUM DB
	$q = "SELECT `credits` FROM `class_num` WHERE `number` = '$num'";
	//STORES RESULT
	$res = mysql_query($q,$conm);
	//FETCHES USEABLE VERSION OF RESULT
	$row = mysql_fetch_row($res);
	//ADDS IT TO HOURS
	$hours += $row[0];
	//INCREMENT COUNTER
	$i++;
}
//WRITES QUERY TO READD THE SCHEDULE TO THE DATABASE WITH ALL THE NEEDED INFO
$q = "INSERT INTO schedule(stu_num_rand,num_hours,days,class_num,class2_num,class3_num,class4_num,class5_num,class6_num,class7_num,num_classes)";
$q .= " VALUES('$stunum','$hours','$day','$car[0]','$car[1]','$car[2]','$car[3]','$car[4]','$car[5]','$car[6]','$tcount')";
//EXECUTES QUERY
mysql_query($q,$conm);
}
//INCLUDES THE PAGE TO REDIRECT TO THE NEXT PAGE IN THE SYSTEM
include '../includes/redirectone.php';

?>