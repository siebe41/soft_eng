<?php

$conm = mysql_connect('localhost', 'softeng', 'buildmeaprototype'); 
$link = mysqli_connect('localhost', 'softeng', 'buildmeaprototype','cs_soft_eng'); 
if (!$conm) { 
    die('Could not connect: ' . mysql_error()); 
} 
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//echo 'Connected successfully'; 
mysql_select_db('cs_soft_eng'); 

?>