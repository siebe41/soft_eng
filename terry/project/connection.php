<?php

$conm = mysql_connect('phoenixwcus.ipagemysql.com', 'softeng', 'buildmeaprototype'); 

if (!$conm) { 
    die('Could not connect: ' . mysql_error()); 
} 
//echo 'Connected successfully'; 
mysql_select_db(cs_soft_eng); 

?>