<?php 

$link = mysql_connect('phoenixwcus.ipagemysql.com', 'softeng', 'buildmeaprototype'); 

if (!$link) { 
    die('Could not connect: ' . mysql_error()); 
} 
echo 'Connected successfully'; 
mysql_select_db(cs_soft_eng); 

$q = "SELECT * FROM `class_list`";

$res = mysql_query($q,$link);
$count = mysql_num_rows($res);
echo '<br>';
while($count > 0){
	$count--;
	$row = mysql_fetch_row($res);
	//echo $row[0].' '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4].'<br>';

}



?> 

<html>
<body>
Hello
<?php 
echo '<br>'.rand();
include 'queries/get_times.php';
echo 'Test'; ?>
</body>
</html>

