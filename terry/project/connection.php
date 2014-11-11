<?php
$link = mysqli_connect('phoenixwcus.ipagemysql.com', 'softeng', 'buildmeaprototype', 'cs_soft_eng');

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>