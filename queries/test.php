<?PHP
$tableData = $_POST['tableData'];
echo $tableData;
$array = json_decode($tableData,TRUE);

echo $array;

?>