<?php
include '../includes/connection.php';
$q = "DELETE FROM `schedule` WHERE `stu_numb_random` != '0'";
echo $q;
mysql_query($q,$conm);

?>