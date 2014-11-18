<?php
include '../includes/connection.php';
$q = "DELETE FROM `schedule` WHERE `stu_num_rand` <> '0'";
echo $q;
mysql_query($q,$conm);

?>