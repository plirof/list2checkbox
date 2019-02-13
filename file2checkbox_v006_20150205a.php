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

$table_column0_name="Name";
$table_column1_name="Tried-Checked";
$table_column2_name="isNice";

//Create backup
if(!file_exists($filename.".orig")){
	if($debug)echo "<h2>backup not exists</h2>";
	if (!copy($filename, $filename.".orig")) {
		if($debug)echo "failed to copy $filename...\n";
	}
}

if(isSet($_POST["check_request"]) && $_POST["check_request"]=="yes") {
		if($debug)echo "HELLOOOOOOOOOOOOOOOOOO";
		write_my_file();
		
}

if($debug)echo "<h3>ORIGINAL myarray</h3>";
if($debug) print_r($myarray);
print "<form action='' method='post'>\n";
print"<table border=1>";
print "<th>$table_column0_name</th><th>$table_column1_name</th><th>$table_column2_name</th><tr>";
// get number of elements in array with count
$count = -1; // Foreach with counter is probably best here
foreach ($myarray as $line) {
  $count++; // increment the counter
  $par = $line;
  $par = explode ("::",$line);
  //if($debug)print_r($par);echo "<br>";
 
    print "<td>$count - ".$par[0]."</td>"; 
	$check1="";
	$check2="";
	if(isSet($par[1])) 	if (substr($par[1], 0, 4)=="yes1") {$check1="checked"; }
	if(isSet($par[2])) 	if (substr($par[2], 0, 4)=="yes2") {$check2="checked";}
	print "<td><input type='checkbox' name='column_1[$count]' value='yes1-line:$count' $check1/> </td>";
    print "<td><input type='checkbox' name='column_2[$count]' value='yes2-line:$count' $check2 /> </td>";
	print "</tr><tr>\n";

    //print $par[3]."<br />\n";
  
}
print "<input type=hidden name=check_request value=yes>";
print "<input type=submit>";
print "</td></tr></table></form>";


function write_my_file(){
// To DO RECREATE all column1 and 2 in file from scratch
global $filename,$myarray,$debug,$debug2;
$column_1_checked=array();// col1 yes
$column_2_checked=array();// col2 yes
//if($debug)echo "<h2>HELLO INSIDE writemyfile</h2>";
//if($debug)print_r($_POST);
if($debug)var_dump($_POST);
if($debug)echo "<hr>";
if($debug2)var_dump($_POST["column_1"]);
if($debug)echo "<hr>";
// column 1+++++++++++++++++++++++++++++++++++
$count1=0;
if(isSet($_POST["column_1"])){
	foreach ($_POST["column_1"] as $line_raw)
	{
		if($debug)echo substr($line_raw, 10, 15)."<br>";
		$column_1_checked[$count1]=substr($line_raw, 10, 15);
		$count1++;
	}
}
if($debug)echo "<hr>column_1_checked:";
if($debug)var_dump($column_1_checked);
// column 1-----------------------------------

// column 2+++++++++++++++++++++++++++++++++++
$count2=0;
if(isSet($_POST["column_2"])){
	foreach ($_POST["column_2"] as $line_raw)
	{
		//if($debug)echo substr($line_raw, 10, 15)."<br>";
		$column_2_checked[$count2]=substr($line_raw, 10, 15);
		$count2++;
	}
}
// column 2-----------------------------------
$count=-1;
foreach ($myarray as $line) {
  $count++; // increment the counter
  //$par = $line;
  $par = explode ("::",$line);
  if($debug2)print "<hr size=5 color=darkgrey > $count _____- ".$par[0]."<br />\n";
  $par[0]=str_replace(array("\r", "\n",PHP_EOL), '', $par[0]);  // remove all line breaks

    if (in_array($count,$column_2_checked)) {
		//add checkbox2
		if($debug) print "<h3> in_array column_2_checked ".$par[2]."</h3>";
		//if(isSet($par[2])) 	if (substr($par[2], 0, 4)!="yes2") {$par[2]="yes2"; if($debug) print "<h3>$count -   column_2_SET</h3>";  }
		if(isSet($par[1])) {$par[2]="yes2";} else {$par[1]="nop1";$par[2]="yes2";}
	} else if(!in_array($count,$column_2_checked))
	{   //remove "yes2"
		//create values
		if(isSet($par[2])) {$par[2]="nop2";}
		if($debug) print "<h3>$count -   column_2_checked NOT in array</h3>";
		
	}
	
	if (in_array($count,$column_1_checked)){
		if($debug) print "column_1_checked";
		$par[1]="yes1 ";
	} else if(!in_array($count,$column_1_checked))
	{
		if(isSet($par[1])) {$par[1]="nop1";}
	}
	if($debug2)print "<hr color=blue size=5>".$par[2]."<br /> ".implode ("::",$par)."\n";
	//$par[3]="\r\n";
	$myarray[$count] = implode ("::",$par)."\r\n";// maybe we'll need an PHP_EOL
    
  
} // END of foreach ($myarray as $line) {
  if($debug)echo "<hr color=grey size=20> myarray     $count - ";
  if($debug) print_r($myarray);
  if($debug)echo "  -- END ---<br>"; 
file_put_contents( $filename , ( $myarray ) );
}


?>
