<?php
include 'includes/connection.php';

$major = $_POST['major'];
$q = "SELECT DISTINCT `name`
FROM `class_num`
WHERE `subject_area` = '$major[0]'
ORDER BY `name` 
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
