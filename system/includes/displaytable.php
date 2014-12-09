<?php
function displayTable($number, $number2, $number3, $number4, $number5, $number6, $number7) {
	include 'connection.php';
	$colorArray = array("#CCFFCC", "#99FF66", "#FF6666", "#FFFF99", "#9966FF", "#669999", "#666699");
	$timeArray = array("08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30");
	$argumentList = func_get_args();
	$idString =  implode($argumentList);
	print '<table id="'.$idString.'" style = "table-layout: fixed; border-collapse: separate;">';
	print "<tr><th></th><th>mon</th><th>tue</th><th>wed</th><th>thu</th><th>fri</th></tr>";
	for($i=1; $i<=count($timeArray); $i++) {
		print "<tr><th>".$timeArray[$i-1]."</th>";
		for($j=1; $j<=5; $j++) {
			//$printVar = $j+($i-1)*7;
			print "<td style = \"width: 125px; border: 1px solid #BBB;\"></td>";
		}
		print "</tr>";
	}
	print "</table>";
	$colorNumber = 0;
	foreach($argumentList as $val) {
		if($val == 0) {break;}
		$q = "SELECT `days`
		FROM `classlist`
		WHERE `number` = '$val'
		";
		$q2 = "SELECT `name`
		FROM `class_num`
		WHERE `number` = '$val'
		";
		$q3 = "SELECT `start_time`, `end_time`
		FROM `classlist`
		WHERE `number` = '$val'
		";
		if ($result = mysqli_query($link, $q2)) {
			$rows = array();
			while ($row = mysqli_fetch_row($result)){
				$name[] = $row;
			}
			//print $name[0][0]." ";
		}
		if ($result = mysqli_query($link, $q)) {
			$rows = array();
			while ($row = mysqli_fetch_row($result)){
				$days[] = $row;
			}
			//print $days[0][0]." ";
		}
		if ($result = mysqli_query($link, $q3)) {
			$rows = array();
			while ($row = mysqli_fetch_row($result)){
				$times[] = $row;
			}
			//print $times[0][0]." ".$times[0][1]."<br>";
		}
		$startTimeArray = explode(':', $times[0][0]);
		$endTimeArray = explode(':', $times[0][1]);
		$minutesTime = (intval($endTimeArray[0])-intval($startTimeArray[0])) * 60 + (intval($endTimeArray[1]) - intval($startTimeArray[1]));
	//	print " ".$minutesTime." ";
		$blocks = ceil($minutesTime/30);
		//print $blocks;
		$days2 = str_split($days[0][0], 1);
		//print_r($days2);
		$daysArrayString =  '"'.implode('", "', $days2).'"';
		//print $daysArrayString;
		print '<script>
				function highlightTime(startTime, blocks, days, id, name) {
					var timeArray = ["08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30"];
					var dayArray = ["M", "T", "W", "R", "F"];
					var pickedDays = [];
					for(var i in days) {
						for(var j in dayArray) {
							if(days[i] == dayArray[j]) {
								pickedDays.push(j);
							}
						}
					}
					for(var x in pickedDays) {
						document.getElementById(id).childNodes[0].childNodes[timeArray.indexOf(startTime)+1].childNodes[parseInt(pickedDays[x])+1].innerText = name;
						for(var i = 1; i<=blocks; i++) {
							document.getElementById(id).childNodes[0].childNodes[timeArray.indexOf(startTime)+i].childNodes[parseInt(pickedDays[x])+1].style.backgroundColor = "'.$colorArray[$colorNumber].'";
						}
					}
				}
				var days = ['.$daysArrayString.'];
				highlightTime("'.$times[0][0].'", '.$blocks.', days, "'.$idString .'", "'.$name[0][0].'");
			</script>';
			unset($days);
			unset($name);
			unset($times);
			$colorNumber++;
			print "<br>";
	}
}
?>