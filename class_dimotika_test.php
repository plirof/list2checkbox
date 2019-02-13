<?php
/*
This script takes an ordinary text file and converts it to a text box 
version : 005 -20150205a

to do:
-variable columns
-select text file from menu
-(might not be a point to it) GET text file from url
*/

$filename = "dimotiko_lessons_2018-19.txt";
$myarray = file($filename);
$debug=false; //if($debug)
$debug2=false;

$table_column_name[0]="lesson name";
$table_column_name[1]="10dimA1";
$table_column_name[2]="10dimA2";
$table_column_name[3]="10dimB1";
$table_column_name[4]="10dimB2";
$table_column_name[5]="10dimΓ1";

$table_column_name[7]="10dimΔ1";

$table_column_name[9]="10dimΕ1";

$table_column_name[11]="10dimΣΤ1";

$table_column_name[21]="15dimA1";
$table_column_name[22]="15dimA2";
$table_column_name[23]="15dimB1";
$table_column_name[24]="15dimB2";
$table_column_name[25]="15dimΓ1";

$table_column_name[27]="15dimΔ1";

$table_column_name[29]="15dimΕ1";

$table_column_name[211]="15dimΣΤ1";

require_once "file2checkbox.php";
?>
