<?php
/*
This script takes an ordinary text file and converts it to a text box 
ver: 006 -20150205a (just preparation for 2019 version)
ver: 005 -20150205a
to do:
-variable columns
-select text file from menu
-(might not be a point to it) GET text file from url
*/

if(!isSet($filename))$filename = "!hiddenObject_1502_a_list.txt";
$myarray = file($filename);
if(!isSet($debug))$debug=false; //if($debug)
if(!isSet($debug2))$debug2=false;
if(!isSet($debug3))$debug3=false;


//$table_column_name[0]



if(!isSet($table_column_name[0]))$table_column_name[0]="Name";
if(!isSet($table_column_name[1]))$table_column_name[1]="class1";
if(!isSet($table_column_name[2]))$table_column_name[2]="class2";
if(!isSet($table_column_name[3]))$table_column_name[3]="class3";
if(!isSet($table_column_name[4]))$table_column_name[4]="comments";

$counted_columns=count($table_column_name);
//if($debug) print_r($counted_columns);

$table_th_text="\n";
//for($i=0;$i<$counted_columns;$i++){
foreach ($table_column_name as $name){	
	//$table_th_text=$table_th_text.'<th>'.$table_column_name[$i].'</th>';
	$table_th_text=$table_th_text.'<th>'.$name.'</th>';
}

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
print "<form action='' method='post' name='hello' >\n";
print"<table border=1>";
print $table_th_text;
print '<tr>';
//print "<th>$table_column_name[0]</th><th>$table_column_name[1]</th><th>$table_column_name[2]</th><th>$table_column_name[3]</th><th>$table_column_name[4]</th><tr>";


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
	$check3="";
	foreach ($par as $currect_column_value){
		$check1="";
		if(isSet($currect_column_value)) 	if (substr($currect_column_value, 0, 4)=="yes1") {$check1="checked"; }
		print "<td><input type='checkbox' name='column_1[$count]' value='yes1-line:$count' $check1/> </td>";
	}	

/*
	if(isSet($par[1])) 	if (substr($par[1], 0, 4)=="yes1") {$check1="checked"; }
	if(isSet($par[2])) 	if (substr($par[2], 0, 4)=="yes2") {$check2="checked";}
	if(isSet($par[3])) 	if (substr($par[3], 0, 4)=="yes3") {$check3="checked";}
	if(!isSet($par[4])) $par[4]="";
	print "<td><input type='checkbox' name='column_1[$count]' value='yes1-line:$count' $check1/> </td>";
    print "<td><input type='checkbox' name='column_2[$count]' value='yes2-line:$count' $check2 /> </td>";
	print "<td><input type='checkbox' name='column_3[$count]' value='yes3-line:$count' $check3 /> </td>";
	print "<td><input type='text' size=50 name='comments[$count]' value='".$par[4]."' /> </td>";
	*/
	print "</tr><tr>\n";



    //print $par[3]."<br />\n";
  
}
print "<input type=hidden name=check_request value=yes>";
print "<input type=submit>";
print "</td></tr></table></form>";



function write_my_file(){
// To DO RECREATE all column1 and 2 in file from scratch
global $filename,$myarray,$debug,$debug2,$debug3;
$column_1_checked=array();// col1 yes
$column_2_checked=array();// col2 yes
$column_3_checked=array();// col3 yes
$comments=array();
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
		//if($debug3)echo substr($line_raw, 10, 15)."<br>";
		$column_2_checked[$count2]=substr($line_raw, 10, 15);
		$count2++;
	}
}
// column 2-----------------------------------
// column 3+++++++++++++++++++++++++++++++++++
$count3=0;
if(isSet($_POST["column_3"])){
	foreach ($_POST["column_3"] as $line_raw)
	{
		//if($debug3)echo substr($line_raw, 10, 15)."<br>";
		$column_3_checked[$count3]=substr($line_raw, 10, 15);
		$count3++;
	}
}
// column 3-----------------------------------

$count4=0;
if(isSet($_POST["comments"])){
	foreach ($_POST["comments"] as $line_raw)
	{
		//if($debug)echo substr($line_raw, 10, 15)."<br>";
		$comments[$count4]=$line_raw;
		$count4++;
	}
}


$count=-1;
foreach ($myarray as $line) {
  $count++; // increment the counter
  //$par = $line;
  $par = explode ("::",$line);
  if($debug2)print "<hr size=5 color=darkgrey > $count _____- ".$par[0]."<br />\n";
  $par[0]=str_replace(array("\r", "\n",PHP_EOL), '', $par[0]);  // remove all line breaks

	if (in_array($count,$column_1_checked)){
		if($debug) print "column_1_checked";
		$par[1]="yes1 ";
	} else if(!in_array($count,$column_1_checked))
	{
		//if(isSet($par[1])) {$par[1]="nop1";}
		$par[1]="nop1";
	}  // always set all par[1] to yes1 or nop1
  
 
	if (in_array($count,$column_2_checked)){
		if($debug) print "column_2_checked";
		$par[2]="yes2";
	} else if(!in_array($count,$column_2_checked))
	{
		//if(isSet($par[1])) {$par[1]="nop1";}
		$par[2]="nop2";
	}  // always set all par[1] to yes1 or nop1
 

	if (in_array($count,$column_3_checked)){
		if($debug) print "column_3_checked";
		$par[3]="yes3";
		if($debug3) echo "<h1>column_3_checked $count </h1>";
	} else if(!in_array($count,$column_3_checked))
	{
		//if(isSet($par[1])) {$par[1]="nop1";}
		$par[3]="nop3";
	}  // always set all par[1] to yes1 or nop1
 
	$par[4]=$comments[$count];
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
