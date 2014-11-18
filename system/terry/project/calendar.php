<?php

function displayTable() {
	$timeArray = array(800, 830, 900, 930, 1000, 1030, 1100, 1130, 1230, 1300, 1330, 1400, 1430, 1530, 1600, 1630, 1700, 1730); 
	print "<table id=\"specialTable\">";
	print "<tr><th></th><th>mon</th><th>tue</th><th>wed</th><th>thu</th><th>fri</th></tr>";
	for($i=1; $i<=18; $i++) {
		print "<tr><th>".$timeArray[$i-1]."</th>";
		for($j=1; $j<=5; $j++) {
			//$printVar = $j+($i-1)*7;
			print "<td></td>";
		}
		print "</tr>";
	}
	print "</table>";
}
displayTable();
print "<script>
function replaceContentInContainer(matchClass) {
    var elems = document.getElementsByTagName('*'), i;
    for (i in elems) {
        if((' ' + elems[i].className + ' ').indexOf(' ' + matchClass + ' ')
                > -1) {
            elems[i].style.backgroundColor = \"green\";
        }
    }
}
function highlightTime(time, day){
	timeArray = [800, 830, 900, 930, 1000, 1030, 1100, 1130, 1230, 1300, 1330, 1400, 1430, 1530, 1600, 1630, 1700, 1730];
	document.getElementById(\"par\").innerHTML = timeArray.indexOf(time);
	if(day == \"tue\") {
		for(var i = 1; i<=3; i++) {
			document.getElementById(\"specialTable\").childNodes[0].childNodes[timeArray.indexOf(time)+i].childNodes[2].style.backgroundColor = \"green\";
			document.getElementById(\"specialTable\").childNodes[0].childNodes[timeArray.indexOf(time)+i].childNodes[4].style.backgroundColor = \"green\";
		}
	}
	else {
		for(var i = 1; i<=2; i++) {
			document.getElementById(\"specialTable\").childNodes[0].childNodes[timeArray.indexOf(time)+i].childNodes[1].style.backgroundColor = \"green\";
			document.getElementById(\"specialTable\").childNodes[0].childNodes[timeArray.indexOf(time)+i].childNodes[3].style.backgroundColor = \"green\";
			document.getElementById(\"specialTable\").childNodes[0].childNodes[timeArray.indexOf(time)+i].childNodes[5].style.backgroundColor = \"green\";
		}
	}
}
window.onload = function() {
	replaceContentInContainer(\"filled\");
	highlightTime(900, \"mon\");
};
</script>"
?>

<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
?>
<p id="par"></p>
</body>
</html>