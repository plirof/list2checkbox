<html>
<head>
<!--
  
  190223b : $column0_wrap  added wraping to all column 0 entries
  190223a : added seperator and first entry is <B></B>
  190213f - freeze panes NOTE: Thisneed MODERN browser (does NOTwork on firefox 17)  
-->
	<meta charset="utf-8">


<style>

table {
  table-layout: fixed;
  border-spacing: 0px;
}

td, th {
  padding-left: 5px;
  padding-right: 5px;
}

.tr_shaded:nth-child(even) {
  background: #e0e0e0;
}

.tr_shaded:nth-child(odd) {
  background: #ffffff;
}

.scrolly_table {
  white-space: nowrap;
  overflow: auto;
}

/* The frozen cells will each get two class names,
   making it easier for me to select all of them or
   only a subset.  All frozen cells will be "fixed",
   the corner will also be in class "freeze", and the
   row and column headers will be "horizontal" and
   "vertical" respectively. */
.fixed.freeze {
  z-index: 10;
  position: relative;
}

.fixed.freeze_vertical {
  z-index: 5;
  position: relative;
}

.fixed.freeze_horizontal {
  z-index: 1;
  position: relative;
}
</style>

</head>
<body>

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
if(!isSet($seperator))$seperator = "|_|";
if(!isSet($column0_wrap))$column0_wrap = 400; // setting this to 0 will reduce html file size
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

$table_th_text=$table_th_text."\n".'<th style="background-color:white"  class="fixed freeze" >'.$table_column_name[$keys[0]].'</th>'; // first column static
############################################

for($i=1;$i<$counted_columns;$i++){
//foreach ($table_column_name as $name){	
	$table_th_text=$table_th_text."\n".'<th  style="background-color:white" class="fixed freeze_vertical" >'.$table_column_name[$keys[$i]].'</th>';
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
echo '<div id="scrolling_table_1" class="scrolly_table" style="max-width:100%x; max-height:100%">	';
print"<table border=1>";
print $table_th_text;
print '<tr class="tr_shaded" >';
//print "<th>$table_column_name[0]</th><th>$table_column_name[1]</th><th>$table_column_name[2]</th><th>$table_column_name[3]</th><th>$table_column_name[4]</th><tr>";


// get number of elements in array with count
$line_counter = -1; // Foreach with counter is probably best here
foreach ($array_of_file as $line) {
  //if(strlen($line)<5)continue;	
  $line_counter++; // increment the counter
  $par = $line;
  $par = explode ("::",$line);
  //if($debug){echo "<br>LINE 76 -"; print_r($par);echo "<br>";}

  
  $par0_exploded=explode ($seperator,$par[0]  );
  $par0_exploded[0]="<b>".$par0_exploded[0]."</b>";
  $par[0]=implode($seperator." ",$par0_exploded); //space used for helping text wrap
  if($column0_wrap>0) $par[0]="<div style='background-color: lightgrey;width: ".$column0_wrap."px;word-wrap: break-word;'>". $par[0]."</div>";

  print "\n<td  class=\"fixed freeze_horizontal\" >$line_counter - ".$par[0]."</td>";  


	$count_par=0;
	//if($debug)echo "<hr>".$table_column_name[$keys[$i]];
	//if($debug){echo "<hr>LINE 84 par= "; print_r($par);}
	//foreach ($par as $currect_column_value){
	for($i=1;$i<$counted_columns;$i++){
		$count_par++;
		//$check1="";
		$check[$i]=" ";
		if(isSet($par[$i])) if (substr($par[$i], 0, 4)=="yes1") {$check[$i]="checked"; }
		print "\n<td  class=\"fixed\" ><input type='checkbox' name='column_".$i."[$line_counter]' value='yes1-line:$line_counter' ".$check[$i]." /> </td>";
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
	print "</tr><tr  class=\"tr_shaded\"  >\n";



    //print $par[3]."<br />\n";
  
}
print "<input type=hidden name=check_request value=yes>";
print '<input type=submit   class="fixed freeze" >';
print "</td></tr></table></form>";
print "</div>";





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
<script>
function freeze_pane_listener(what_is_this, table_class) {
  // Wrapping a function so that the listener can be defined
  // in a loop over a set of scrolling table id's.
  // Cf. http://stackoverflow.com/questions/750486/javascript-closure-inside-loops-simple-practical-example
  
  return function() {
    var i;
    var translate_y = "translate(0," + what_is_this.scrollTop + "px)";
    var translate_x = "translate(" + what_is_this.scrollLeft + "px,0px)";
    var translate_xy = "translate(" + what_is_this.scrollLeft + "px," + what_is_this.scrollTop + "px)";
    
    var fixed_vertical_elts = document.getElementsByClassName(table_class + " freeze_vertical");
    var fixed_horizontal_elts = document.getElementsByClassName(table_class + " freeze_horizontal");
    var fixed_both_elts = document.getElementsByClassName(table_class + " freeze");
    
    // The webkitTransforms are for a set of ancient smartphones/browsers,
    // one of which I have, so I code it for myself:
    for (i = 0; i < fixed_horizontal_elts.length; i++) {
      fixed_horizontal_elts[i].style.webkitTransform = translate_x;
      fixed_horizontal_elts[i].style.transform = translate_x;
    }

    for (i = 0; i < fixed_vertical_elts.length; i++) {
       fixed_vertical_elts[i].style.webkitTransform = translate_y;
       fixed_vertical_elts[i].style.transform = translate_y;
    }

    for (i = 0; i < fixed_both_elts.length; i++) {
       fixed_both_elts[i].style.webkitTransform = translate_xy;
       fixed_both_elts[i].style.transform = translate_xy;
    }
  }
}

function even_odd_color(i) {
  if (i % 2 == 0) {
    return "#e0e0e0";
  } else {
    return "#ffffff";
  }
}

function parent_id(wanted_node_name, elt) {
  // Function to work up the DOM until it reaches
  // an element of type wanted_node_name, and return
  // that element's id.
  
  var wanted_parent = parent_elt(wanted_node_name, elt);
  
  if ((wanted_parent == undefined) || (wanted_parent.nodeName == null)) {
    // Sad trombone noise.
    return "";
  } else {
    return wanted_parent.id;
  }
}

function parent_elt(wanted_node_name, elt) {
  // Function to work up the DOM until it reaches 
  // an element of type wanted_node_name, and return
  // that element.
  
  var this_parent = elt.parentElement;
  if ((this_parent == undefined) || (this_parent.nodeName == null)) {
    // Sad trombone noise.
    return null;
  } else if (this_parent.nodeName == wanted_node_name) {
    // Found it:
    return this_parent;
  } else {
    // Recurse:
    return parent_elt(wanted_node_name, this_parent);
  }
}

var i, parent_div_id, parent_tr, table_i, scroll_div;
var scrolling_table_div_ids = ["scrolling_table_1", "scrolling_table_2"];

// This array will let us keep track of even/odd rows:
var scrolling_table_tr_counters = [];
for (i = 0; i < scrolling_table_div_ids.length; i++) {
  scrolling_table_tr_counters.push(0);
}

// Append the parent div id to the class of each frozen element:
var fixed_elements = document.getElementsByClassName("fixed");
for (i = 0; i < fixed_elements.length; i++) {
  fixed_elements[i].className += " " + parent_id("DIV", fixed_elements[i]);
}

// Set background colours of row headers, alternating according to 
// even_odd_color(), which should have the same values as those
// defined in the CSS for the tr_shaded class.
var fixed_horizontal_elements = document.getElementsByClassName("freeze_horizontal");
for (i = 0; i < fixed_horizontal_elements.length; i++) {
  parent_div_id = parent_id("DIV", fixed_horizontal_elements[i]);
  table_i = scrolling_table_div_ids.indexOf(parent_div_id);
  
  if (table_i >= 0) {
    parent_tr = parent_elt("TR", fixed_horizontal_elements[i]);
    
    if (parent_tr.className.match("tr_shaded")) {
      fixed_horizontal_elements[i].style.backgroundColor = even_odd_color(scrolling_table_tr_counters[table_i]);
      scrolling_table_tr_counters[table_i]++;
    }
  }
}

// Add event listeners.
for (i = 0; i < scrolling_table_div_ids.length; i++) {
  scroll_div = document.getElementById(scrolling_table_div_ids[i]);
  scroll_div.addEventListener("scroll", freeze_pane_listener(scroll_div, scrolling_table_div_ids[i]));
}

</script>
</body>
</html>
