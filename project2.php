<?php
$tableData = $_POST['tableData'];


$array = json_decode($tableData,TRUE);
foreach ($array as $item) {
		
		echo $item;
	echo "<br>";
}
// now $tableData can be accessed like a PHP array
?>
