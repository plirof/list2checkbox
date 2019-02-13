<?php
/*
This script takes an ordinary text file and converts it to a text box 
version : 005 -20150205a

to do:
-variable columns
-select text file from menu
-(might not be a point to it) GET text file from url
*/

$filename = "!hiddenObject_1502_a_list.txt";
$myarray = file($filename);
$debug=false; //if($debug)
$debug2=false;

$table_column_name[0]="Name";
$table_column_name[1]="Tried-Checked_";
$table_column_name[2]="problem";

require_once "file2checkbox.php";
?>
