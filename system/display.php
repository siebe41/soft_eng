<?PHP 
	$stunum = $_GET['num']; 
	include 'includes/connection.php';
	include 'includes/displaytable.php';
?>
<html>
<head></head>
<body>
	<?PHP
		$q = "SELECT * FROM `schedule` WHERE `stu_num_rand` = '$stunum'";
		$res = mysql_query($q,$conm);
		$rc = mysql_num_rows($res);
		$int = 12*$rc;
		//echo $rc.'<br>';
		//echo $int.'<br>';
		$array = new SplFixedArray($int);
		$count = 0;
		while($count < $rc){
			$row = mysql_fetch_row($res);
			$i = 0;
			$int = $count*12;
			//echo $int.'<br>';
			//echo $count.'<br>';
			while($i < 12){
				$array[$i + $int] = $row[$i];
				$i++;
			}
			$count++;
		}
	?>
	<?PHP
		if(isset($_GET['snum'])){
			$snum = $_GET['snum'];
			$int = 12*$snum;
			$car = array(0,0,0,0,0,0,0);
			$ttcount = 0;
			$cc = 0;
			while($ttcount < 7){
				$car[$ttcount] = $array[$ttcount+3+$int];
				if($array[$ttcount+3+$int] > 0)
					$cc++;
				$ttcount++;
			}
			$ccc = 0;
			echo '<div id="full" style="width:100%;"><div id="fulll" style="float:left;width: 50%;">';
			echo '<b>Selected Schedule:</b><br><br>';
			while($cc > 0){ 
				$num = $car[$ccc];
				$ccc++;
				$cc--;
				$q = "SELECT * FROM `classlist` WHERE `number` = '$num'";
				$ress = mysql_query($q,$conm);
				$row = mysql_fetch_row($ress);
				$q = "SELECT `name` FROM `class_num` WHERE `number` = '$num'";
				$rest = mysql_query($q,$conm);
				$rowt = mysql_fetch_row($rest);
				$name = $rowt[0];
				$days = $row[1];
				$stime = $row[2];
				$etime = $row[3];
				$room = $row[4];
				$inst = $row[5];
				echo '<b>'.$name.'</b><br>';
				echo 'Course Number: '.$num.'<br>';
				echo 'Days: '.$days.'<br>';
				echo 'Start: '.$stime.'<br>';
				echo 'End: '.$etime.'<br>';
				echo 'Room: '.$room.'<br>';
				echo 'Instructor: '.$inst.'<br><br><br>';
			}		
				echo '<i>Note: All times in 24 hour format</i>';
				echo '</div><div id="fullr" style="float:left;width:49.9%;">';
				displaytable($car[0],$car[1],$car[2],$car[3],$car[4],$car[5],$car[6]);
				echo '</div></div>';
				echo '<hr><br>';
		}	
	?>
	<b>Click To View Schedule</b>
	<br><br>
	<table>
		<tr>
			<th>Schedule #</th>
			<th>Days</th>
			<th>Credit Hours</th>
			<th>Number of Classes</th>
		</tr>
		<?PHP
			$count = 0;
			while($count < $rc){
				$int = ($count)*12;
				echo '<tr>';
				echo '<td><a href="display.php?num='.$stunum.'&snum='.$count.'">';
				echo $count+1;
				echo '</a></td><td>';
				echo $array[2+$int];
				echo '</td><td>';
				echo $array[1+$int];
				echo '</td><td>';
				echo $array[11+$int];
				echo '</tr>';
				$count++;
			}
		?>
		</table>
</body>
</html>