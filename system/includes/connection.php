<?php

//FILE TO ESTABLIST A CONNECTION WITH THE DATABASE

//ESTABLIST VAR FOR MYSQL CONNECTION
$conm = mysql_connect('localhost', 'softeng', 'buildmeaprototype'); 
//ESTABLIST VAR FOR MYSQLI (NEWER WAY OF DOING IT) CONNECTION -- FOR TERRY'S SECTION
$link = mysqli_connect('localhost', 'softeng', 'buildmeaprototype','cs_soft_eng'); 

//CHECKS TO MAKE SURE THE CONNECTION WAS SUCCESSFUL
if (!$conm) { 
    die('Could not connect: ' . mysql_error()); 
} 
//CHECKS MYSQLI CONNECTION
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//SELECTS THE MYSQL DB WE WANT TO USE
mysql_select_db('cs_soft_eng'); 

?>