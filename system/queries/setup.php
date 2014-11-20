<?php

//SIMPLE FILE USED TO CREATE TEST DATA ORIGINALLY
//THIS FILE IS NO LONGER USED
include '../includes/connection.php';
$q = "SELECT `name` FROM `class_num` WHERE `number` = '70409'";
$res = mysql_query($q,$conm);
$resr = mysql_fetch_row($res);
echo $q;
$num1 = $resr[0];
echo $num1.'<br>';
$q = "SELECT `name` FROM `class_num` WHERE `number` = '70420'";
$res = mysql_query($q,$conm);
$resr = mysql_fetch_row($res);
$num2 = $resr[0];
$q = "SELECT `name` FROM `class_num` WHERE `number` = '70432'";
$res = mysql_query($q,$conm);
$resr = mysql_fetch_row($res);
$num3 = $resr[0];

$array = array($num1,$num2,$num3);

?>