<?PHP 
	//GETS THE INFO PASSED FROM THE PREVIOUS PAGE
	$stunum = $_GET['num']; 
	//INCLUDES CONNECTION TO THE DB
	include 'includes/connection.php';
?>
<html>
<head></head>
<body>
	<?PHP
		//WRITES QUERY TO GET THE SCHEDULES FOR THE STUDENT
		$q = "SELECT * FROM `schedule` WHERE `stu_num_rand` = '$stunum'";
		//EXECUTES THE QUERY AND STORES THE RESULT
		$res = mysql_query($q,$conm);
		//GETS THE ROW
		$rc = mysql_num_rows($res);
		//SETS UP THE OFFSET AND SIZE OF THE ARRAY TO STORE SCHEDULES
		$int = 12*$rc;
		//CREATES THE ARRAY
		$array = new SplFixedArray($int);
		//CREATES COUNTER
		$count = 0;
		//STORES THE SCHEDULE IN THE RESULT ARRAY
		while($count < $rc){
			//GETS NEXT ROW OF RESULT
			$row = mysql_fetch_row($res);
			//COUNTER
			$i = 0;
			//TEMP COUNTER TO REPRESENT THE OFFSET
			$int = $count*12;
			//STORES RESULT IN PERM ARRAY
			while($i < 12){
				$array[$i + $int] = $row[$i];
				$i++;//INCREMENT
			}
			$count++;//INCREMENT
		}
	?>
	<?PHP
	//SECTION TO PRINT THE SCHEDULE SELECTED
		//CHECKS IF SCHEDULE HAS BEEN SELECTED
		if(isset($_GET['snum'])){
			//STORES NUMBER
			$snum = $_GET['snum'];
			//SETS UP OFF SET
			$int = 12*$snum;
			//CREATES ARRAY TO HOLD CLASSES
			$car = array(0,0,0,0,0,0,0);
			//COUNTERS
			$ttcount = 0;
			$cc = 0;
			//LOOP TO POPULATE THE ARRAY
			while($ttcount < 7){
				$car[$ttcount] = $array[$ttcount+3+$int];
				if($array[$ttcount+3+$int] > 0)
					$cc++;//INCREMENT
				$ttcount++;//INCREMENT
			}
			$ccc = 0;//COUNTER
			
			//SECTION TO ACTUALLY PRINT THE SCHEDULE
			//PRINT HEADER
			echo '<b>Selected Schedule:</b><br><br>';
			//LOOP AND PRINT ALL CLASS INFO
			while($cc > 0){
				//STORES CLASS NUM
				$num = $car[$ccc];
				//ADJUST COUNTERS
				$ccc++;
				$cc--;
				//WRITES QUERY TO GET THE INFO FROM CLASSLIST BASED ON NUMBER
				$q = "SELECT * FROM `classlist` WHERE `number` = '$num'";
				//EXECUTES AND STORES RESULT
				$ress = mysql_query($q,$conm);
				//GETS THE ROW
				$row = mysql_fetch_row($ress);
				//WRITES QUERY TO GET MORE INFO FROM CLASS_NUM
				$q = "SELECT `name` FROM `class_num` WHERE `number` = '$num'";
				//EXECUTES AND STORES RESULT
				$rest = mysql_query($q,$conm);
				//GETS THE ROW
				$rowt = mysql_fetch_row($rest);
				//STORES THE PROPER INFO IN PHP VARIABLES
				$name = $rowt[0];
				$days = $row[1];
				$stime = $row[2];
				$etime = $row[3];
				$room = $row[4];
				$inst = $row[5];
				
				//PRINTS THE VARIABLES
				echo '<b>'.$name.'</b><br>';
				echo 'Days: '.$days.'<br>';
				echo 'Start: '.$stime.'<br>';
				echo 'End: '.$etime.'<br>';
				echo 'Room: '.$room.'<br>';
				echo 'Instructor: '.$inst.'<br><br><br>';
			}		
				echo '<i>Note: All times in 24 hour format</i>';
				echo '<hr>';
		}	
	?>
	<!----SECTION TO PRINT THE SCHEDULE CHOICES--->
	<!---BASIC HTML START---->
	<b>Click To View Schedule</b>
	<table>
		<tr>
			<th>Schedule #</th>
			<th>Days</th>
			<th>Credit Hours</th>
			<th>Number of Classes</th>
		</tr>
		<?PHP
			//PRINTS THE CHOICES
			$count = 0;//COUNTER
			//LOOPS THROUGH ALL THE POSSIBLE SCHEDULES
			while($count < $rc){
				//SETS UP OFFSET
				$int = ($count)*12;
				//PRINTS THE CHOICE AND THE INFO ABOUT IT
				echo '<tr>';//START ROW
				echo '<td><a href="display.php?num='.$stunum.'&snum='.$count.'">';
				echo $count+1;//SCHEDULE #
				echo '</a></td><td>';
				echo $array[2+$int];//DAYS
				echo '</td><td>';
				echo $array[1+$int];//CREDIT HOURS
				echo '</td><td>';
				echo $array[11+$int];//NUM CLASSES
				echo '</tr>';//CLOSES ROW
				$count++;//INCREMENT
			}
		?>
		</table>
		<!----ENDS SCHEDULE OUTPUT---->
</body>
</html>