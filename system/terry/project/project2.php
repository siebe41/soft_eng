<?php
include 'connection.php';
$tableData = $_POST['tableData'];
$newArray = json_decode($tableData,TRUE);
$ids = join("', '", $newArray);
$q = "SELECT `number`
FROM `class_num` 
WHERE `name` IN ('$ids')
";
if ($result = mysqli_query($link, $q)) {
	$rows = array(); 
	while ($row = mysqli_fetch_row($result)){
		$rows[] = $row;
	}     
	print json_encode($rows); 
}
?>
