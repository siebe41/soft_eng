<?php
include 'connection.php';
$q = "SELECT DISTINCT `name` 
FROM `class_num` 
WHERE `subject_area` = 'CS'
ORDER BY `name` 
";
$res = mysql_query($q,$conm);

print '<table border="1" id="sampleTbl" width="380">';        
while ($row=mysql_fetch_assoc($res)){                
		print '<tr>';           
		foreach(array_values($row) as $val) {           
			print '<td class = "tableData">' . htmlspecialchars($val) . '</td>';                
		}                       
		print '</tr>';          
 }               
print '</table>';
?>
