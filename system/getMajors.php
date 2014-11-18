<?php
include 'includes/connection.php';

$q = "SELECT DISTINCT `subject_area` 
FROM `class_num`
ORDER BY `subject_area` 
";
if ($result = mysqli_query($link, $q)) {
	$rows = array(); 
	while ($row = mysqli_fetch_row($result)){
		$rows[] = $row;
	}     
	print json_encode($rows); 
}
else {
	print "error";
}
?>
