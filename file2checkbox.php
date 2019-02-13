<?php
/*
This script takes an ordinary text file and converts it to a text box 
ver: 006 -20150205a (just preparation for 2019 version)
ver: 005 -20150205a
to do:
-variable columns
-select text file from menu
-(might not be a point to it) GET text file from url


to check :
https://stackoverflow.com/questions/4769148/accessing-an-associative-array-by-integer-index-in-php
$keys = array_keys($my_arr);
$my_arr[$keys[1]] = "not so much bling";

*/

if(!isSet($filename))$filename = "!hiddenObject_1502_a_list.txt";
$array_of_file = file($filename);
if(!isSet($debug))$debug=false; //if($debug)
if(!isSet($debug2))$debug2=false;
if(!isSet($debug3))$debug3=false;


//$table_column_name[0]
if($debug3)print_r($_POST);
//var_dump($_POST);


if(!isSet($table_column_name[0]))$table_column_name[0]="Name";
if(!isSet($table_column_name[1]))$table_column_name[1]="class1";
if(!isSet($table_column_name[2]))$table_column_name[2]="class2";
if(!isSet($table_column_name[3]))$table_column_name[3]="class3";
if(!isSet($table_column_name[4]))$table_column_name[4]="comments";

$counted_columns=count($table_column_name);
$keys = array_keys($table_column_name);
//if($debug) print_r($counted_columns);

$table_th_text="\n";
for($i=0;$i<$counted_columns;$i++){
//foreach ($table_column_name as $name){	
	$table_th_text=$table_th_text.'<th>'.$table_column_name[$keys[$i]].'</th>';
	//$table_th_text=$table_th_text.'<th>'.$name.'</th>';
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
if($debug) print_r($array_of_file);
print "<form action='' method='post' name='hello' >\n";
print"<table border=1>";
print $table_th_text;
print '<tr>';
//print "<th>$table_column_name[0]</th><th>$table_column_name[1]</th><th>$table_column_name[2]</th><th>$table_column_name[3]</th><th>$table_column_name[4]</th><tr>";


// get number of elements in array with count
$line_counter = -1; // Foreach with counter is probably best here
foreach ($array_of_file as $line) {
  //if(strlen($line)<5)continue;	
  $line_counter++; // increment the counter
  $par = $line;
  $par = explode ("::",$line);
  //if($debug){echo "<br>LINE 76 -"; print_r($par);echo "<br>";}
    print "\n<td>$line_counter - ".$par[0]."</td>";  


	$count_par=0;
	//if($debug)echo "<hr>".$table_column_name[$keys[$i]];
	//if($debug){echo "<hr>LINE 84 par= "; print_r($par);}
	//foreach ($par as $currect_column_value){
	for($i=1;$i<$counted_columns;$i++){
		$count_par++;
		//$check1="";
		$check[$i]=" ";
		if(isSet($par[$i])) if (substr($par[$i], 0, 4)=="yes1") {$check[$i]="checked"; }
		print "<td><input type='checkbox' name='column_".$i."[$line_counter]' value='yes1-line:$line_counter' ".$check[$i]." /> </td>";
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
global $filename,$array_of_file,$debug,$debug2,$debug3,$counted_columns,$keys;

$column_checked=array();
$comments=array();
//if($debug)echo "<h2>HELLO INSIDE writemyfile</h2>";
//if($debug)print_r($_POST);
if($debug)var_dump($_POST);
if($debug)echo "<hr>";
if($debug2)var_dump($_POST["column_1"]);
if($debug)echo "<hr>";



for($i=1;$i<$counted_columns;$i++){
//foreach ($table_column_name as $name){	
	//$table_th_text=$table_th_text.'<th>'.$name.'</th>';
	$count1=0;
	if(isSet($_POST["column_".$i])){
		foreach ($_POST["column_".$i] as $line_raw)
		{
			if($debug)echo substr($line_raw, 10, 15)."<br>";
			$column_checked[$i][$count1]=substr($line_raw, 10, 15);
			$count1++;
		}
	}

}
if($debug)echo"<hr>column_checked=";
if($debug)print_r($column_checked);

if($debug)echo"<hr>";
/*
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
*/



$line_counter=-1;
foreach ($array_of_file as $line) {
  //if(strlen($line)<5)continue;
  $line_counter++; // increment the counter
  //$par = $line;
  $par = explode ("::",$line);
  if($debug2)print "<hr size=5 color=darkgrey > $count _____- ".$par[0]."<br />\n";
  $par[0]=str_replace(array("\r", "\n",PHP_EOL), '', $par[0]);  // remove all line breaks



	$count_par=0;
	//if($debug)echo "<hr>".$table_column_name[$keys[$i]];
	//if($debug){echo "<hr>LINE 84 par= "; print_r($par);}
	//foreach ($par as $currect_column_value){
	for($i=1;$i<$counted_columns;$i++){


		if (@in_array($line_counter,$column_checked[$i])){
			//if($debug) print_r ($column_checked[$i]);
			$par[$i]="yes1 ";
		} else if(@!in_array($line_counter,$column_checked[$i]))
		{
			//if(isSet($par[1])) {$par[1]="nop1";}
			$par[$i]="nop1";
		}  // always set all par[1] to yes1 or nop1		
	}	

	/*

 
	$par[4]=$comments[$count];

	*/
	if($debug2)print "<hr color=blue size=5>".$par[2]."<br /> ".implode ("::",$par)."\n";
	//$par[3]="\r\n";
	$array_of_file[$line_counter] = implode ("::",$par)."\r\n";// maybe we'll need an PHP_EOL
    
  
} // END of foreach ($array_of_file as $line) {
  if($debug)echo "<hr color=grey size=20> myarray     $line_counter - ";
  if($debug3) print_r($array_of_file);
  if($debug)echo "  -- END ---<br>"; 
file_put_contents( $filename , ( $array_of_file ) );
}


?>
