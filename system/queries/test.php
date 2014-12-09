<?PHP
$tableData = $_POST['tableData'];
$array = json_decode($tableData,TRUE);
$count = count($array);
//echo $count.'<br>';
$i = 0;
while($i < $count){
	//echo $array[$i].'<br>';
	$i++;
}
?>