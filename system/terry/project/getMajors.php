<?php
$link = mysqli_connect('phoenixwcus.ipagemysql.com', 'softeng', 'buildmeaprototype', 'cs_soft_eng');
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
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
