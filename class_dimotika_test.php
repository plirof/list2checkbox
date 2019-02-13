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

$table_column0_name="lesson name";
$table_column3_name="10dimA2";
$table_column1_name="10dimB1";
$table_column2_name="15dimΓ1";

require_once "file2checkbox.php";
?>
