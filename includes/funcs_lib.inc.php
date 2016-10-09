<?php
function connect_db()
{
	global $ARR_CFGS;
	if (!isset($GLOBALS['dbcon'])) {
		// $GLOBALS['dbcon'] =	mysql_connect($ARR_CFGS["db_host"], $ARR_CFGS["db_user"], $ARR_CFGS["db_pass"]);
		//$GLOBALS['dbcon'] =	mysql_connect('localhost', 'chiclayo', 'Tri75axe!');
                //$GLOBALS['dbcon'] =	mysql_connect('localhost', 'root', '');
		//mysql_select_db('heytaxi') or die("Could not connect to database. Please check configuration and ensure MySQL is running.");
                $GLOBALS['dbcon'] =	mysql_connect('localhost', 'root', 'root');
		mysql_select_db('gs_geotaxi') or die("Could not connect to database. Please check configuration and ensure MySQL is running.");
	}
}

// db_query: Updated 10 oct 2006
function db_query($sql, $dbcon2 = null)
{
	if($dbcon2==''){
		if(!isset($GLOBALS['dbcon'])) {
			connect_db();
		}
		$dbcon2	= $GLOBALS['dbcon'];
	}
	$time_before_sql = checkpoint();
	$result	= mysql_query($sql,	$dbcon2) or	die(db_error($sql));
	/*
	$time_taken_for_sql = checkpoint();
	//echo "<br>time_taken_for_sql: $time_taken_for_sql";
	if($time_taken_for_sql >.5) {
		$file = SITE_FS_PATH.'/sql_log/opt.txt';
		if(filesize($file)>500*1024) {
			$handle = fopen($file, 'w');
		} else {
			$handle = fopen($file, 'a');
		}
		fwrite($handle, $time_taken_for_sql."/t".$sql);
		fclose($handle); 
	}
	*/
	return $result;
}


function db_scalar($sql, $dbcon2 = null)
{
	if($dbcon2==''){
		if(!isset($GLOBALS['dbcon'])) {
			connect_db();
		}
		$dbcon2	= $GLOBALS['dbcon'];
	}
	$result	= db_query($sql, $dbcon2);
	if ($line =	mysql_fetch_array($result))	{
		$response =	$line[0];
	}
	return $response;
}

function db_error($sql)
{
	echo "<div style='font-family: tahoma; font-size: 11px; color: #333333'><br>".mysql_error()."<br>";
	print_error();
	if(LOCAL_MODE) {
		echo "<br>sql: $sql";
	}
	echo "</div>";
	/*
	$_SESSION['sess_sql_error'] = mysql_error();
	header("location: ".SITE_WS_PATH."/sql_error.php");
	exit;
	*/
}

function print_error() {
	$debug_backtrace = debug_backtrace();
	for ($i = 1; $i < count($debug_backtrace); $i++) {
		$error = $debug_backtrace[$i];
		echo "<br>";
		echo "<div>";
		echo "<b>File:</b> ".$error['file']."<br>";
		echo "<b>Line:</b> ".$error['line']."<br>";
		echo "<b>Function:</b> ".$error['function']."<br>";
		//echo "<b>Args:</b> ";
		//foreach($error['args'] as $arg) {
		//	echo "$arg <br>";
		//}
		echo "</div>";
	}
}

function mysql_time($hour, $minute,	$ampm)
{
	if ($ampm == 'PM' && $hour != '12')	{
		$hour += 12;
	}
	if ($ampm == 'AM' && $hour == '12')	{
		$hour =	'00';
	}
	$mysql_time	= $hour	. ':' .	$minute	. ':00';
	return $mysql_time;
}

function price_format($price)
{
	if ($price != '' &&	$price != '0') {
		$price = number_format($price, 2);
        if($price >="0"){
			return str_replace('.00','',$price);
		}	
	}
}

function date_format1($date)
{
	if (strlen($date) >= 10) {
		if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
			return '';
		}
		$mktime	= mktime(0,	0, 0, substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
		return date("d-m-Y", $mktime);
	} else {
		return $date;
	}
}

function order_date_format1($date)
{
	$d_ar=explode(" ",$date);
	$date_ar=explode("-",$d_ar[0]);
	$time_ar=explode(":",$d_ar[1]);
	$date="$date_ar[2]-$date_ar[1]-$date_ar[0] $time_ar[0]:$time_ar[1]:$time_ar[2]";
	return $date;
}
function only_date_format2($date)
{
	$d_ar=explode(" ",$date);
	$date_ar=explode("-",$d_ar[0]);
	$time_ar=explode(":",$d_ar[1]);
	$date="$date_ar[2]-$date_ar[1]-$date_ar[0]";
	return $date;
}
function date_format2($date)
{
	if (strlen($date) >= 10) {
		if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
			return '';
		}
		$mktime	= mktime(0,	0, 0, substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
		return date("M j, Y", $mktime);
	} else {
		return $date;
	}
}


function datetime_format($date)
{
	global $arr_month_short;
	if (strlen($date) >= 10) {
		if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
			return '';
		}
		$mktime	= mktime(substr($date, 11, 2), substr($date, 14, 2), substr($date, 17, 2),substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
		return date("j-m-Y h:i A ", $mktime);
	} else {
		return $date;
	}
}


function time_format($time)
{
	if (strlen($time) >= 5)	{
		$hour =	substr($time, 0, 2);
		$hour =	str_pad($hour, 2, "0", STR_PAD_LEFT);

		return $hour . ':' . substr($time, 3, 2) . ' ' . $ampm;
	} else {
		return $time;
	}
}

function ms_print_r($var)
{
	//if(LOCAL_MODE || $_SESSION['debug']){
		echo "<textarea rows='10' cols='148' style='font-size: 11px; font-family: tahoma'>";
		print_r($var);
		echo "</textarea>";
	//}
}

function ms_form_value($var)
{
	return is_array($var) ? array_map('ms_form_value', $var) : htmlspecialchars(stripslashes(trim($var)));
}

function ms_display_value($var)
{
	return is_array($var) ? array_map('ms_display_value', $var) : nl2br(htmlspecialchars(stripslashes(trim($var))));
}

function ms_stripslashes($var)
{
	return is_array($var) ? array_map('ms_stripslashes', $var) : stripslashes(trim($var));
}

function ms_addslashes($var)
{
	return is_array($var) ? array_map('ms_addslashes', $var) : addslashes(trim($var));
}


function ms_trim($var)
{
	return is_array($var) ? array_map('ms_trim', $var) : trim($var);
}

function is_image_valid($file_name)
{
	global $ARR_VALID_IMG_EXTS;
	$ext = file_ext($file_name);
	if (in_array($ext, $ARR_VALID_IMG_EXTS))	{
		return true;
	} else {
		return false;
	}
}

function getmicrotime()
{
	list($usec,	$sec) =	explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

function file_ext($file_name)
{
	$path_parts = pathinfo($file_name);
	$ext = strtolower($path_parts["extension"]);
	return $ext;
}

function blank_filter($var)
{
	$var = trim($var);
	return ($var != '' && $var != '&nbsp;');
}

function apply_filter($sql,	$field,	$field_filter, $column)
{
	if (!empty($field))	{
		if ($field_filter == "=" || $field_filter == "") {
			$sql = $sql	. "	and	$column	= '$field' ";
		} else if ($field_filter == "like")	{
			$sql = $sql	. "	and	$column	like '%$field%'	";
		} else if ($field_filter ==	"starts_with") {
			$sql = $sql	. "	and	$column	like '$field%' ";
		} else if ($field_filter ==	"ends_with") {
			$sql = $sql	. "	and	$column	like '%$field' ";
		} else if ($field_filter ==	"not_contains")	{
			$sql = $sql	. "	and	$column	not	like '%$field%'	";
		} else if ($field_filter == ">") {
			$sql = $sql . " and $column > '$field' ";
		} else if ($field_filter == "<") {
			$sql = $sql . " and $column < '$field' ";
		} else if ($field_filter ==	"!=") {
			$sql = $sql	. "	and	$column	!= '$field'	";
		}
	}
	return $sql;
}

function filter_dropdown($name	= 'filter',	$sel_value)
{
	$arr = array( "like" => 'Contains', '=' => 'Is Equal', "starts_with" => 'Starts with', "ends_with"	=> 'Ends with', "!=" => 'Is not' , "not_contains" => 'Not contains');
	return array_dropdown($arr, $sel_value, $name, " class='textfield4'");
}

function move_up($table_name, $where_clause_all, $where_clause_item, $sort_order, $move_by)
{
	$dest_order	= $sort_order -	$move_by;
	// $arr_ids_to_move=Array();
	// echo	"<br>$movie_artist_id, $movie_id, $artistcate_id, $sort_order, $move_by, $dest_order<br>";
	for($i = $sort_order-1;	$i > $dest_order-1;	$i--) {
		$sql = " update	$table_name	set	sort_order=sort_order+1	where $where_clause_all	and	sort_order='$i'";
		// echo	"<br>$sql<br>";
		db_query($sql);
	}
	$sql = " update	$table_name	set	sort_order=sort_order-$move_by where $where_clause_item";
	// echo	"<br>$sql<br>";
	db_query($sql);
}

function move_down($table_name,	$where_clause_all, $where_clause_item, $sort_order,	$move_by)
{
	$dest_order	= $sort_order +	$move_by;
	// $arr_ids_to_move=Array();
	// echo	"<br>$movie_artist_id, $movie_id, $artistcate_id, $sort_order, $move_by, $dest_order<br>";
	for($i = $sort_order + 1; $i < $dest_order + 1;	$i++) {
		$sql = " update	$table_name	set	sort_order=sort_order-1	where $where_clause_all	and	sort_order='$i'	";
		// echo	"<br>$sql<br>";
		db_query($sql);
	}
	$sql = " update	$table_name	set	sort_order=sort_order+$move_by where $where_clause_item";
	// echo	"<br>$sql<br>";
	db_query($sql);
}

function refine_list($id_column, $table_name, $where_clause)
{
	$sql = " select	$id_column,	sort_order from	$table_name	where $where_clause	order by sort_order";
	// echo	"<br>$sql<br>";
	$result	= db_query($sql);
	$i = 1;
	while ($line = mysql_fetch_array($result)) {
		$sql = " update	$table_name	set	sort_order='$i'	where $id_column='$line[0]'";
		// echo	"<br>$sql<br>";
		db_query($sql);
		$i++;
	}
}


function make_url($url)
{
	$parsed_url	= parse_url($url);
	if ($parsed_url['scheme'] == '') {
		return 'http://' . $url;
	} else {
		return $url;
	}
}


function ms_mail($to, $subject, $message, $arr_headers= array())
{
	$str_headers = '';
	foreach($arr_headers as $name=>$value){
		$str_headers .= "$name: $value\n";
	}
	@mail($to, $subject, $message, $str_headers);
	return true;
}


function make_thumb_im($file_path, $arr_options)
{
	$width		= $arr_options['width'];
	$height		= $arr_options['height'];
	$prefix		= $arr_options['prefix'];
	$target_dir	= $arr_options['target_dir'];
	$quality	= $arr_options['quality'];
	
	$path_parts = pathinfo($file_path);

	if($width==''){
		$width = '120';
	}
	
	if($prefix=='') {
		$prefix = 'thumb_';
	}
	if($target_dir=='') {
		$target_dir = $path_parts["dirname"];
	}

	if($quality=='') {
		$quality = '70';
	}
	
	$size = @getimagesize($file_path);
	if($size=='') {
		return false;
	}
	
	/*
	$ratio = round($width/$height, 2);
	$img_width = $size[0];
	$img_height = $size[1];
	*/

	$path_parts = pathinfo($file_path);
		
	$thumb_path="$target_dir/".$prefix.$path_parts["basename"];

	$cmd ="convert -resize ".$width.'x'." -quality $quality \"$file_path\" \"$thumb_path\" ";
	system($cmd);
	//echo("<br>$cmd");
	return $prefix.$path_parts["basename"];
}


function date_to_mysql($date)
{
	list($month, $day, $year) = explode('/', $date);
	return "$year-$month-$day";
}


function date_to_mysql_withtime($date)
{
    $date_arr	=	explode(' ',$date);
	list($month, $day, $year) = explode('/', $date_arr[0]);
	
	list($hour, $min, $sec) = explode(':', $date_arr[1]);
	return $year."-".$month."-".$day." ".$hour.":".$min.":".$sec;
}


function mysql_to_date_withtime($date)
{
    $date_arr	=	explode(' ',$date);
	list($year, $month, $day) = explode('-', $date_arr[0]);
	
	list($hour, $min, $sec) = explode(':', $date_arr[1]);
	return $month."/".$day."/".$year." ".$hour.":".$min.":".$sec;
}

function export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' ){
	//session_cache_limiter('public');
	//header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	//header("Content-Type: application/force-download");
	if($file_name=='') {
		$file_name = time().'.txt';
	}
	header("Content-type: application/txt");
	header("Content-Disposition: attachment; filename=$file_name");
	$arr_db_cols= array_keys($arr_columns);
	$arr_headers= array_values($arr_columns);
	//ms_print_r($arr_columns);
	//ms_print_r($arr_db_cols);
	//ms_print_r($arr_headers);
	//ms_print_r($arr_headers);
	//ms_print_r($arr_headers);
	$str_columns = implode(',', $arr_db_cols);
	$sql= "select ".$str_columns." $sql" ;
	
	$result= db_query($sql);
	$num_cols = count($arr_columns);
	//$i=0;

	foreach($arr_headers as $header){
		//$i++;
		echo $header."\t";
		//if($i!=$num_cols){
		//	echo "\t";
		//}
	}
	while($line=mysql_fetch_array($result, MYSQL_ASSOC))
	{
		echo "\r\n";
		//echo("<br> ");
		foreach($line as $key => $value){
			$value=str_replace("\n","",$value);
			$value=str_replace("\r","",$value);
			$value=str_replace("\t","",$value);
			if(is_array($arr_substitutes[$key])){
				$value = $arr_substitutes[$key][$value];
			}
			if(isset($arr_tpls[$key])){
				$code = str_replace('{1}', $value, $arr_tpls[$key]);
				//echo ("\$value = $code;");
				//echo("<br>");
				eval ("\$value = $code;");
			}
			echo $value."\t";
		}
	}
}

// checkpoint: Updated 2 sep 2006
// to check how much time is lapsed before first call of this function
function checkpoint($from_start = false)
{
	global $PREV_CHECKPOINT;
	if($PREV_CHECKPOINT==''){
		$PREV_CHECKPOINT = SCRIPT_START_TIME;
	}
	$cur_microtime = getmicrotime();
	
	if($from_start) {
		return $cur_microtime - SCRIPT_START_TIME;
	} else {
		$time_taken = $cur_microtime - $PREV_CHECKPOINT;
		$PREV_CHECKPOINT = $cur_microtime;
		return $time_taken;
	}
}


function readable_col_name($str) 
{
	return ucwords( str_replace('_', ' ', strtolower($str) ) );
}


function ms_echo($str) {
	if(LOCAL_MODE){
		echo($str);
	}
}

// make_dropdown: Updated 1 aug 2006
function make_dropdown($sql, $combo_name, $sel_value =	'',	$extra = '', $choose_one = '')
{
	$result	= db_query($sql);
	if (mysql_num_rows($result)	> 0) {
		$str_dropdown = "<select name='$combo_name' id='$combo_name' $extra>";
		if(is_array($choose_one)) {
			foreach($choose_one as $key => $value) {
				$str_dropdown .= "<option value='$key '>$value</option>";
			}
		} else if ($choose_one	!= '') {
			$str_dropdown .= "<option value=''>$choose_one</option>";
		}
		while	($line = mysql_fetch_array($result)) {
			// if($css== "opt1"){ $css='opt2';}else{$css='opt1';};
			$str_dropdown .= "<option value=\"" . ms_form_value($line[0]) . "\"";
			if(is_array($sel_value)) {
				if (in_array($line[0], $sel_value )) {
					$str_dropdown .= "	selected ";
				}
			} else {
			if ($sel_value == $line[0])	{
				$str_dropdown .= "	selected ";
			}
			}
			$str_dropdown .= ">" .	$line[1] . "</option>";
		}
		$str_dropdown .= "</select>";
	}else{
	  $str_dropdown= "<select name='$combo_name' id='$combo_name' $extra><option value=''>$choose_one</option></select>";
	}
	return $str_dropdown;
}


function array_dropdown( $arr, $sel_value='', $name='', $extra='', $choose_one='', $arr_skip= array())
{
	$combo="<select name='$name' id='$name' $extra >";
	if($choose_one!=''){
		$combo.="<option value=\"\">$choose_one</option>";
	}
	foreach($arr as $key => $value)
	{
		if(is_array($arr_skip) && in_array($key, $arr_skip)) {
			continue;
		}
		$combo.='<option value="'.htmlspecialchars($key).'"';
		if(is_array($sel_value)) {
			if(in_array($key, $sel_value) || in_array(htmlspecialchars($key), $sel_value)) {
				$combo.=" selected ";
			}
		} else {
			if($sel_value==$key || $sel_value==htmlspecialchars($key)) {
				$combo.=" selected ";
			}
		}
		//if($value)
		$combo.=" >$value</option>";
	}
	$combo.=" <option value='0'> Other </option>";
	$combo.=" </select>";
	return $combo;
}


function make_checkboxes($manutmp, $checkname, $checksel = '', $cols,	$missit, $style	= '', $tableattr = '')
{
	if ($style != "") {
		$style = "class='" . $style	. "'";
	}

	$colwidth =	100	/ $cols;
	$colwidth =	round($colwidth, 2);
	$j = 0;
	/*
	$manutmp['Any']="Any";
	if($checksel==''){
		$checksel=Array("Any");
	}
	*/
	foreach($manutmp as	$key =>	$value)	{
		$tochecked = "";
		if (is_array($checksel)	&& in_array($key, $checksel)) {
			$tochecked = "checked";
		}
		if ($key !=	$missit) {
			if ($value != "") {
				if ($j == 0) {
					$checkstr .= "<table $tableattr border=0  width='100%'><tr>\n";
					$alt		=	' alt="CHECKBOX~Location~DM~"';
				} else if (($j % $cols)	== 0) {
					$checkstr .= "</tr><tr>\n";
				}
				$checkstr .= "<td valign='top'><INPUT TYPE='checkbox' $javascript	 NAME='$checkname" . '[]' .	"' value='$key'	$tochecked $alt></td><td $style valign='top' width='50%'> $value	</td>\n";
				$j++;
			}
		}
	}
	$j--;
	// echo	"$cols-($j%$cols)=".$cols-($j%$cols);
	// echo	"<BR>($j%$cols)=".($j%$cols);
	for($x = $j	% $cols;$x < 4;$x++) {
		if ($x != 3) {
			$checkstr .= "<td>&nbsp;</td>\n";
		} else {
			$checkstr .= "<td>&nbsp;</td></tr>\n";
		}
	}
	$checkstr .= "</table>";
	return $checkstr;
}


function make_radios($manutmp, $checkname, $checksel = '', $cols,	$missit, $style	= '', $tableattr = '')
{
	if ($style != "") {
		$style = "class='" . $style	. "'";
	}

	$colwidth =	100	/ $cols;
	$colwidth =	round($colwidth, 2);
	$j = 1;
	/*
	$manutmp['Any']="Any";
	if($checksel==''){
		$checksel=Array("Any");
	}
	*/
	foreach($manutmp as	$key =>	$value)	{
		$tochecked = "";
		if ($checksel == $key) {
			$tochecked = "checked";
		}
		if ($key !=	$missit) {
			if ($value != "") {
				if ($j == 1) {
					$checkstr .= "<table $tableattr><tr>\n";
				} else if (($j % $cols)	== 1) {
					$checkstr .= "</tr><tr>\n";
				}
				$checkstr .= "<td width='" . $colwidth . "%' $style	valign=top><INPUT TYPE='radio' $javascript	 NAME='$checkname' value='$key'	$tochecked	   > $value	</td>\n";
				$j++;
			}
		}
	}
	$j--;
	// echo	"$cols-($j%$cols)=".$cols-($j%$cols);
	// echo	"<BR>($j%$cols)=".($j%$cols);
	for($x = $j	% $cols;$x < 4;$x++) {
		if ($x != 3) {
			$checkstr .= "<td>&nbsp;</td>\n";
		} else {
			$checkstr .= "<td>&nbsp;</td></tr>\n";
		}
	}
	$checkstr .= "</table>";
	return $checkstr;
}


function date_dropdown($pre, $selected_date = '', $start_year='', $end_year = '', $sort = 'asc')
{
	$cur_date =	date("Y-m-d");
	$cur_date_day =	substr($cur_date, 8, 2);
	$cur_date_month	= substr($cur_date,	5, 2);
	$cur_date_year = substr($cur_date, 0, 4);

	if ($selected_date != '') {
		$selected_date_day = substr($selected_date,	8, 2);
		$selected_date_month = substr($selected_date, 5, 2);
		$selected_date_year	= substr($selected_date, 0,	4);
	}
	$date_dropdown	.= month_dropdown($pre	. "month", $selected_date_month);
	$date_dropdown	.= day_dropdown($pre .	"day", $selected_date_day);
	// echo($pre . "year: ". $selected_date_year);
	$date_dropdown	.= year_dropdown($pre . "year", $selected_date_year, $start_year,	$end_year,	$sort);
	return $date_dropdown;
}


function month_dropdown($name,	$selected_date_month = '', $extra='')
{
	global $ARR_MONTHS;

	$date_dropdown	= "	<select	name='$name' $extra> <option value=''>MM</option>";
	$i = 0;
	foreach ($ARR_MONTHS as $key => $value) {
		$date_dropdown	.= " <option ";
		if ($key == $selected_date_month)	{
			$date_dropdown	.= " selected ";
		}
		$date_dropdown	.= " value='" .	str_pad($key, 2, "0",	STR_PAD_LEFT) .	"'>$value</option>";
	}
	$date_dropdown	.= "</select>";
	return $date_dropdown;
}


function day_dropdown($name, $selected_date_day = '', $extra='')
{
	$date_dropdown	.= "<select	name='$name' $extra>";
	$date_dropdown	.= "<option	value=''>DD</option>";
	for($i = 1;$i <= 31;$i++) {
		//$s = date('S', mktime(1, 0,	0, 3, $i, 1970));
		$date_dropdown	.= " <option ";
		if ($i == $selected_date_day) {
			$date_dropdown	.= " selected ";
		}
		$date_dropdown	.= " value='" .	str_pad($i,	2, "0",	STR_PAD_LEFT) .	"'>" . $i .	$s . "</option>";
	}
	$date_dropdown	.= "</select>";
	return $date_dropdown;
}


function year_dropdown($name, $selected_date_year = '', $start_year =	'',	$end_year = '', $extra='',$choose='Year')
{
	if ($start_year	== '') {
		$start_year	= DEFAULT_START_YEAR;
	}
	
	if ($end_year == '') {
		$end_year =	DEFAULT_END_YEAR;
	}

	$date_dropdown	.= "<select	name='$name' $extra>";
	$date_dropdown	.= "<option	value=''>$choose</option>";

	for($i = $start_year; $i <= $end_year; $i++) {
		$date_dropdown	.= " <option ";
		if ($i == $selected_date_year) {
			$date_dropdown	.= " selected ";
		}
		$date_dropdown	.= " value='" .	str_pad($i,	2, "0",	STR_PAD_LEFT) .	"'>" . str_pad($i, 2, "0", STR_PAD_LEFT) .	"</option>";
	}
	$date_dropdown	.= "</select>";
	return $date_dropdown;
}


function time_dropdown($pre, $selected_time = '')
{
	// echo("<br>selected_time:$selected_time");
	if ($selected_time != '' &&	$selected_time != ':') {
		$selected_hour = substr($selected_time,	0, 2);
		$selected_minute = substr($selected_time, 3, 2);
		/*
		if($selected_hour >11){
			$selected_ampm = "PM";
			$selected_hour -= 12;
		}else{
			$selected_ampm = "AM";
		}
		if($selected_hour==0){
			$selected_hour = 12;
		}
		*/
	}
	$str .= hour_dropdown($pre, $selected_hour);
	$str .= '<b>:</b>';
	$str .= minute_dropdown($pre, $selected_minute);
	return $str;
	// echo	"<br>$selected_hour, $selected_minute $selected_ampm <br>";
}


function hour_dropdown($pre, $selected_hour,$extra="")
{
	$str .= "<select	name='"	. $pre . "hour' ".$extra.">";
	$str .= "<option	value=''>hrs</option>";
	for($i = 0;	$i <= 23; $i++)	{
		$str .= " <option ";
		if ($i == $selected_hour &&	$selected_hour != '') {
			$str .= " selected ";
		}
		$str .= " value='" .	str_pad($i,	2, "0",	STR_PAD_LEFT) .	"'>" . str_pad($i, 2, "0", STR_PAD_LEFT) .	"</option>";
	}
	$str .= "</select>";
	return $str;
}


function minute_dropdown($pre, $selected_minute,$extra="" )
{
	$str .= "<select	name='"	. $pre . "minute' ".$extra.">";
	$str .= "<option	value=''>mins</option>";
	for($i = 0;	$i <= 59; $i = $i +	1)	{
		$str .= " <option ";
		if (str_pad($i,	2, "0",	STR_PAD_LEFT) === strval($selected_minute))	{
			$str .= " selected ";
		}
		$str	.= " value='" .	str_pad($i,	2, "0",	STR_PAD_LEFT) .	"'>" . str_pad($i, 2, "0", STR_PAD_LEFT) .	"</option>";
	}
	$str .= "</select>";
	return $str;
}


function ampm_dropdown($pre, $selected_ampm)
{
	$str .= "<select name='" . $pre . "ampm'>";
	$str .= " <option ";
	if ($selected_ampm=='AM') {
		$str .= " selected ";
	}
	$str .= " value='AM'>AM</option>";
	$str .= " <option ";
	if ($selected_ampm=='PM') {
		$str	.= " selected ";
	}
	$str .= " value='PM'>PM</option>";
	$str .= "</select>";
	return $str;
}


function get_qry_str($over_write_key = array(),	$over_write_value =	array())
{
	global $_GET;
	$m = $_GET;
	if (is_array($over_write_key)) {
		$i = 0;
		foreach($over_write_key	as $key) {
			$m[$key] = $over_write_value[$i];
			$i++;
		}
	} else {
		$m[$over_write_key]	= $over_write_value;
	}
	$qry_str = qry_str($m);
	return $qry_str;
}


function qry_str($arr, $skip = '')
{
	$s = "?";
	$i = 0;
	foreach($arr as	$key =>	$value)	{
		if ($key !=	$skip) {
			if (is_array($value)) {
				foreach($value as $value2) {
					if ($i == 0) {
						$s .= $key . '[]=' . $value2;
						$i = 1;
					} else {
						$s .= '&' .	$key . '[]=' . $value2;
					}
				}
			} else {
				if ($i == 0) {
					$s .= "$key=$value";
					$i = 1;
				} else {
					$s .= "&$key=$value";
				}
			}
		}
	}
	return $s;
}


function check_radio($s, $s2)
{
	if (is_array($s2)) {
		// echo("<br>$s");
		// print_r($s2);
		if (in_array($s, $s2)) {
			return " checked ";
		}
	} else if ($s == $s2) {
		return " checked ";
	}
}


function sort_arrows($column)
{
	//return '<A HREF="' . $_SERVER['PHP_SELF'] .	get_qry_str(array('order_by', 'order_by2'),	array($column, 'asc')) . '"><img src="'.SITE_WS_PATH.'/images/up_arrow.gif" border="0"></a>	<a href="'	. $_SERVER['PHP_SELF'] . get_qry_str(array('order_by', 'order_by2'), array($column,	'desc')) . '"><img src="'.SITE_WS_PATH.'/images/down_arrow.gif" border="0"></a>';
	return '<A HREF="' . $_SERVER['PHP_SELF'] .	get_qry_str(array('order_by', 'order_by2'),	array($column, 'asc')) . '"><img src="images/up_arrow.gif" border="0"></a>	<a href="'	. $_SERVER['PHP_SELF'] . get_qry_str(array('order_by', 'order_by2'), array($column,	'desc')) . '"><img src="images/down_arrow.gif" border="0"></a>';
}


function select_option($s, $s1)
{
	if ($s == $s1) {
		echo " selected	";
	}
}


function is_post_back(){
	if(count($_POST)>0) {
		return true;
	} else {
		return false;
	}
}


function request_to_hidden($arr_skip='') 
{
	foreach($_REQUEST as $name => $value) {
		$s .= '<input type="hidden" name="'.$name.'" value="'.htmlspecialchars(stripslashes($value)).'">'."\n";
	}
	return $s;
}


function sql_to_array_file($arr_name, $sql, $file, $full_table=false)
{
	$str = "<?\n";
	$result = db_query($sql);
	while ($line = mysql_fetch_array($result)) {
		$line = ms_addslashes($line);
		if($full_table) {
			$key = $line[0];
			foreach($line as $name=>$value) {
				if(!is_numeric($name)) {
					$str .= '$'.$arr_name."['".$key."']['".$name."'] = '".$value."';\n";
				}
			}
			$str .= "\n";
		} else {
			$str .= '$'.$arr_name."['".$line[0]."'] = '".$line[1]."';\n";
		}
	}
	$str .= "\n?>";

	$fh = fopen($file, 'w');
	fwrite($fh, $str);
	fclose($fh);
	return true;
}


function array_radios($arr, $sel_value = '', $name = '', $cols = 3, $extra = '')
{
	if ($style != "") {
		$style = "class='" . $style . "'";
	} 

	$colwidth = 100 / $cols;
	$colwidth = round($colwidth, 2);
	$j = 1;
	/*
	$manutmp['Any']="Any";
	if($checksel==''){
		$checksel=Array("Any");
	}
	*/
	foreach($arr as $key => $value) {
		$tochecked = "";
		if (is_array($sel_value) && in_array($key, $sel_value)) {
			$tochecked = "checked";
		} 
		if ($key != $missit) {
			if ($value != "") {
				if ($j == 1) {
					$checkstr .= "<table $tableattr><tr>\n";
				} else if (($j % $cols) == 1 || $cols==1) {
					$checkstr .= "</tr><tr>\n";
				} 

				$checkstr .= "<td width='" . $colwidth . "%' $style valign=top><INPUT TYPE='radio' $javascript  NAME='$name' value='$key' $tochecked     > $value </td>\n";
				$j++;
			} 
		} 
	} 
	$j--; 
	// echo "$cols-($j%$cols)=".$cols-($j%$cols);
	// echo "<BR>($j%$cols)=".($j%$cols);
	for($x = $j % $cols;$x < 4;$x++) {
		if ($x != 3) {
			$checkstr .= "<td>&nbsp;</td>\n";
		} else {
			$checkstr .= "<td>&nbsp;</td></tr>\n";
		} 
	} 
	$checkstr .= "</table>";
	return $checkstr;
} 

// Updated 24 aug 2006
function make_thumb_gd($imgPath, $destPath, $newWidth, $newHeight, $ratio_type = 'width', $quality = 60, $verbose = false)
{ 
	// options for ratio type = width|height|distort|crop
	// get image info (0 width and 1 height, 2 is (1 = GIF, 2 = JPG, 3 = PNG)
	$size = @getimagesize($imgPath); 
	// break and return false if failed to read image infos
	if (!$size) {
		if ($verbose) {
			echo "Unable to read image info.";
		}
		return false;
	} 
	$curWidth	= $size[0];
	$curHeight	= $size[1];
	$fileType	= $size[2];
	
	// width/height ratio
	$ratio =  $curWidth/$curHeight;

	$srcX = 0;
	$srcY = 0;
	$srcWidth = $curWidth;
	$srcHeight = $curHeight;

	if($ratio_type=='width') {
		// If the dimensions for thumbnails are greater than original image do not enlarge
		if($newWidth > $curWidth) {
			$newWidth = $curWidth;
		}
		$newHeight	= $newWidth / $ratio;
	}else if($ratio_type=='crop') {
		$thumbRatio = $newWidth / $newHeight;
		if($ratio < $thumbRatio) {
			$srcHeight = round($curHeight*$ratio/$thumbRatio);
			$srcY = round(($curHeight-$srcHeight)/2);
		} else {
			$srcWidth = round($curWidth*$thumbRatio/$ratio);
			$srcX = round(($curWidth-$srcWidth)/2);
		}
		/*echo "<br>curWidth: $curWidth";
		echo "<br>curHeight: $curHeight";
		echo "<br>newWidth: $newWidth";
		echo "<br>newHeight: $newHeight";
		echo "<br>ratio: $ratio";
		echo "<br>thumbRatio: $thumbRatio";
		echo "<br>srcWidth: $srcWidth";
		echo "<br>srcX: $srcX";
		echo "<br>srcHeight: $srcHeight";
		echo "<br>srcY: $srcY";*/
	} else if($ratio_type=='height') {
		// If the dimensions for thumbnails are greater than original image do not enlarge
		if($newHeight > $curHeight) {
			$newHeight = $curHeight;
		}
		$newWidth	= $newHeight * $ratio;
	} else if($ratio_type=='distort') {
	}
	
	// create image
	switch ($fileType) {
		case 1:
			if (function_exists("imagecreatefromgif")) {
				$originalImage = imagecreatefromgif($imgPath);
			} else {
				if ($verbose) {
					echo "GIF images are not support in this php installation.";
					return false;
				}
			} 
			$fileExt = 'gif';
			break;
		case 2: 
			$originalImage = imagecreatefromjpeg($imgPath);
			$fileExt = 'jpg';
			break;
		case 3: 
			$originalImage = imagecreatefrompng($imgPath);
			$fileExt = 'png';
			break;
		default:
			if ($verbose) {
				echo "Not a valid image type.";
			}
			return false;
	} 
	// create new image

	$resizedImage = imagecreatetruecolor($newWidth, $newHeight);
	//echo "$srcX, $srcY, $newWidth, $newHeight, $curWidth, $curHeight";
	//echo "<br>$srcX, $srcY, $newWidth, $newHeight, $srcWidth, $srcHeight<br>";
	imagecopyresampled($resizedImage, $originalImage, 0, 0, $srcX, $srcY, $newWidth, $newHeight, $srcWidth, $srcHeight);
	switch ($fileExt) {
		case 'gif':
			imagegif($resizedImage, $destPath, $quality);
			break;
		case 'jpg': 
			imagejpeg($resizedImage, $destPath, $quality);
			break;
		case 'png': 
			imagepng($resizedImage, $destPath, $quality);
			break;
	} 
	// return true if successfull
	return true;
} 

// show_thumb: Updated 6 feb 2007
function show_thumb($file_org, $width, $height, $ratio_type = 'width')
{
	if(preg_match('/(gif|png|jpeg|jpg)/', file_ext($file_org), $matches))
	{	
	$file_name = str_replace(SITE_WS_PATH."/", "", $file_org);
	$file_name = str_replace("/", "^", $file_name);
	$cache_file = $width."x".$height.'__'.$ratio_type .'__'.$file_name;

	$file_fs_path = str_replace(SITE_WS_PATH, SITE_FS_PATH, $file_org);
	if(!is_file(SITE_FS_PATH."/".THUMB_CACHE_DIR."/".$cache_file)) 
	{
		make_thumb_gd($file_fs_path, SITE_FS_PATH."/".THUMB_CACHE_DIR."/".$cache_file, $width, $height, $ratio_type );
	}	
		return SITE_WS_PATH."/".THUMB_CACHE_DIR."/".$cache_file;
	}
	else
	{
	  	return $file_org;
	}
}


// Temporary function. Need to be made more elegant or replace with regular expression
function ms_parse_keywords($keywords)
{
	$arr_keywords = array();
	$dq_end =true;
	$sp_end = true;
	for ($i=0;$i<strlen($keywords);$i++) {
		//echo "<br>cur_token:$cur_token, cur_keyword:$cur_keyword, dq_start:$dq_start, dq_end:$dq_end, sp_start:$sp_start, sp_end:$sp_end,";
		$cur_token = $keywords[$i];
		if($cur_token=='"') {
			if($dq_start) {
				$dq_end = true;
				$dq_start = false;
				$arr_keywords[] = $cur_keyword;
				$cur_keyword = '';
			} else if($dq_end) {
				$dq_end = false;
				$dq_start = true;
				$sp_start = false;
			} else {
				$dq_end = false;
				$dq_start = true;
			}
		} else if($cur_token==' ') {
			if($sp_start || $dq_end) {
				$sp_end = true;
				$sp_start = false;
				$arr_keywords[] = $cur_keyword;
				$cur_keyword = '';
			} else if($sp_end && !$dq_start) {
				$sp_end = false;
				$sp_start = true;
			} else if($dq_start) {
				$cur_keyword .= $cur_token;
			}
		} else {
			$cur_keyword .= $cur_token;
		}
	}

	$arr_keywords[] =$cur_keyword;
	return $arr_keywords;
}



function pagesize_dropdown($name, $value)
{
	$arr = array('10'=>'10','25'=>'25','50'=>'50','100'=>'100');
	$m = $_GET;
	unset($m['pagesize']);
	return array_dropdown($arr, $value , $name, ' class="pagesize_dropdown"  onchange="location.href=\''.$_SERVER['PHP_SELF'].qry_str($m).'&pagesize=\'+this.value" ');
}



// sql_to_assoc_array: Updated 1 aug 2006
function sql_to_assoc_array($sql)
{
	$arr = array();
	$result = db_query($sql);
	while ($line = mysql_fetch_array($result)) {
		$line = ms_form_value($line);
		$arr[$line[0]] = $line[1];
	}
	return $arr;
}


// sql_to_index_array: Updated 1 aug 2006
function sql_to_index_array($sql)
{
	$arr = array();
	$result = db_query($sql);
	while ($line = mysql_fetch_array($result)) {
		$line = ms_form_value($line);
		$arr[] = $line[0];
	}
	return $arr;
}

// sql_to_array: Updated 1 aug 2006
function sql_to_array($sql)
{
	$arr = array();
	$result = db_query($sql);
	while ($line = mysql_fetch_array($result)) {
		$line = ms_form_value($line);
		array_push($arr, $line);
	}
	return $arr;
}

// get_unique_file_name: Updated 2 aug 2006
function get_unique_file_name($file_name)
{
	return str_shuffle(md5(uniqid(rand(), true))) . '.' . file_ext($file_name);
}

function qry_str_to_hidden($str)
{
	$fields='';
	if(substr($str,0,1)=='?') {
		$str = substr($str,1);
	}
	$arr = explode('&', $str);
	foreach($arr as $pair) {
		list($name, $value) = explode('=',$pair);
		if($name!='') {
			$fields.='<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'" />';
		}
	}
	return $fields;
}

// enum_to_array: Updated 14 sep 2006

function enum_to_array($table, $column)
{
	$result = db_query("show fields from $table"); 
	while ($line_raw = mysql_fetch_assoc($result)) {
		$line = ms_display_value($line_raw);
		if($line['Field']==$column) {
			$Type = $line['Type'];
			$Type = substr($Type,6,-2);
			$arr_tmp = explode("','", $Type);
			foreach($arr_tmp as $val) {
				$arr[$val]=$val;
			}
			return $arr;
		}
	}
}

function get_flv_file_name($file_name)
{
	return str_shuffle(md5(uniqid(rand(), true))) . '.flv';
}
function admin_email(){
	$sql=db_query("select * from tbl_config where config_id='1'");
	$result=mysql_fetch_array($sql);
	$email=$result[config_value];
	return $email;	
}
function check_member_session($session_name,$url){
	if(!strlen($_SESSION[$session_name])){
		?>
		<script type="text/javascript">window.location.href='<?=$url?>';</script>
		<?php
		exit;	
	}
}

function billing_address($member_id){
	$result=db_query("select * from tbl_member where email='$member_id'");
	$line_raw=mysql_fetch_array($result);
		$var="$line_raw[f_name] $line_raw[l_name]<br>$line_raw[baddress]<br>$line_raw[bcity], $line_raw[bstate],$line_raw[bzip_code]";
	
	return $var;	
}
function shipping_address($member_id){
	$result=db_query("select * from tbl_member where email='$member_id'");
	$line_raw=mysql_fetch_array($result);
	$var="$line_raw[f_name] $line_raw[l_name]<br>$line_raw[saddress]<br>$line_raw[scity], $line_raw[sstate], $line_raw[szip_code]";
	return $var;	
}

function order_shipping_address($order_id){
	$result=db_query("select * from tbl_order where order_id='$order_id'");
	$line_raw=mysql_fetch_array($result);
	$var="$line_raw[member_name]<br>$line_raw[order_ship_address]<br>$line_raw[order_ship_city], $line_raw[order_ship_state], $line_raw[order_ship_zip]";
	return $var;	
}
function order_billing_address($order_id){
	$result=db_query("select * from tbl_order where order_id='$order_id'");
	$line_raw=mysql_fetch_array($result);
	$var="$line_raw[member_name]<br>$line_raw[order_bill_address]<br>$line_raw[order_bill_city], $line_raw[order_bill_state], $line_raw[order_bill_zip]";
	return $var;	
}
function order_date($order_id){
	$result=db_query("select order_date from tbl_order where order_id='$order_id'");
	$line_raw=mysql_fetch_array($result);
	$var=$line_raw[order_date];
	return $var;	
}



function get_cat_name($catID){
	$res=mysql_fetch_array(db_query("select cat_name from tbl_category where cat_id='$catID'"));
	$cat_name=stripslashes($res[cat_name]);
	return ucfirst($cat_name);
}

/*
function frontpage_nav($catID){
	$res=mysql_fetch_array(db_query("select * from tbl_category where cat_id='$catID' and cat_status='Active'"));
	$flag=0;
	$catparent=$catID;
	while($flag!=1){
		$res1=db_query("select * from tbl_category where cat_id='$catparent' and cat_status='Active'");
		$record=mysql_fetch_array($res1);
		if($record[cat_parent_id]!=0){
			$catparent=$record[cat_parent_id];
			$array.="$record[cat_id]~";
		}else{
			if($record[cat_id]!=""){
				$array.="$record[cat_id]~";
			}
			$flag=1;
		}
	}
	$arr=explode("~",$array);
	//$result = array_reverse($arr);
	$result = $arr;
	
	for($i=1;$i<count($result);$i++){
		$res=mysql_fetch_array(db_query("select * from tbl_category where cat_id='$result[$i]' and cat_status='Active'"));
		$re=db_query("select * from tbl_category where cat_parent_id='$res[cat_id]' and cat_status!='Delete'");
		if(mysql_num_rows($re)!=0){
			echo " <span>".ucwords(strtolower(stripslashes($res[cat_name])))."</span> ";
			if($i<count($result)-1){
   				echo ' &lt;&lt; ';
			}
		}
		else{
			echo "  <a href='category_list.php?cat_id=".$res[cat_id]."' class='tree'>".ucwords(strtolower(stripslashes($res[cat_name])))."</a> ";
		}
		
	}
	echo "&lt;&lt; <a href='index.php' class='tree'>Home</a>";
}
*/
function frontpage_nav($catid){
	$baseurl=SITE_WS_PATH;
	$res=mysql_fetch_array(db_query("select * from tbl_category where cat_id='$catid'"));
	$flag=0;
	$catparent=$catid;
	while($flag!=1){
		$res1=mysql_query("select * from tbl_category where cat_id='$catparent'");
		$record=mysql_fetch_array($res1);
		if($record[cat_parent_id]!=0){
			$catparent=$record[cat_parent_id];
			$array.="$record[cat_id]~";
		}else{
			if($record[cat_id]!=""){
				$array.="$record[cat_id]~";
			}
			$flag=1;
		}
	}
	$arr=explode("~",$array);
	#$result = array_reverse($arr);
	#print_r($arr);
	$result = $arr;
	#echo "<a href='".$baseurl."/index.htm' class='link3'>Home</a> ";
	for($i=0;$i<count($result)-1;$i++){
		$res=mysql_fetch_array(db_query("select * from tbl_category where cat_id='$result[$i]'"));
		$re=mysql_query("select * from tbl_product where (product_cat_id='$res[cat_id]' or product_subcat_id='$res[cat_id]')");
		
		#$cat_name=stripslashes($res[catName]);
		$cat_name=stripslashes($res[cat_name]);
		if(mysql_num_rows($re)==0){
			if($res[cat_id]==$catid){
				echo "".ucwords(strtolower($cat_name))." &lt;&lt; ";
			}else{
				?>
				<a href="sub_categories.php?parent_id=<?=$res[cat_id]?>" class="tree"><?=ucwords(strtolower($cat_name))?></a> &lt;&lt;
				<?php
			}
		}else{
			if($res[cat_id]==$catid){
				echo "".ucwords(strtolower($cat_name))." &lt;&lt; ";
			}else{
				?>
				
				<a href="product_listing.php?parent_id=<?=$res[cat_id]?>" class="normal"><?=ucwords(strtolower($cat_name))?> </a> �
				<?php
			}
		}
		
	}
	echo " <a href='".$baseurl."/categories.php' class='normal'>Collection</a> � <a href='".$baseurl."/index.php' class='normal'>Home</a> ";
}
function setImageToSize($dirNm, $imageName, $w1, $h1, $class, $alt,$vspace="",$align="") { 
      $baseurl=SITE_WS_PATH;
       $basedir=SITE_FS_PATH;
	 if($class!=""){
			$cls=' class="'.$class.'" ';
		}
		if($align!=""){
			$ali=' align="'.$align.'" ';
		}
    if (strlen($imageName) and $size = @GetImageSize("$basedir/$dirNm/$imageName")){
		
		$var='<img src="'.$baseurl.'/thumb.php?x='.$w1.'&y='.$h1.'&src='.$dirNm.'/'.$imageName.'&f=0" border="0" alt="'.$alt.'" title="'.$alt.'" vspace="'.$vspace.'" '.$cls.' '.$ali.'>';

    }/*else{
		$imageName="no-image.jpg";
		$var='<img src="'.$baseurl.'/thumb.php?x='.$w1.'&y='.$h1.'&src=images/'.$imageName.'&f=0" border="0" alt="'.$alt.'" title="'.$alt.'" vspace="'.$vspace.'" '.$cls.' '.$ali.'>';
	}*/
    return $var;
}


function setImageToSize2($dirNm, $imageName, $w1, $h1, $class, $alt,$vspace="",$align="",$id) { 
      $baseurl=SITE_WS_PATH;
       $basedir=SITE_FS_PATH;
	 if($class!=""){
			$cls=$class;
		}
		if($align!=""){
			$ali=' align="'.$align.'" ';
		}
    if (strlen($imageName) and $size = @GetImageSize("$basedir/$dirNm/$imageName")){
		
		$var='<img src="'.$baseurl.'/thumb.php?x='.$w1.'&y='.$h1.'&src='.$dirNm.'/'.$imageName.'&f=0" border="0" alt="'.$alt.'" title="'.$alt.'" vspace="'.$vspace.'" '.$cls.' '.$ali.' id="'.$id.'">';

    }/*else{
		$imageName="no-image.jpg";
		$var='<img src="'.$baseurl.'/thumb.php?x='.$w1.'&y='.$h1.'&src=images/'.$imageName.'&f=0" border="0" alt="'.$alt.'" title="'.$alt.'" vspace="'.$vspace.'" '.$cls.' '.$ali.'>';
	}*/
    return $var;
}


function shiping_charge(){
	$shipres=mysql_fetch_array(db_query("select ship_charges from tbl_config where config_id='1'"));
	$ship_amt=$shipres[0];
	return $ship_amt;	
}

function ucw($name){
	$name=ucwords(strtolower($name));
	return $name;	
}
function discounted_price($price,$discount){
	$dprice=($price*$discount)/100;
	$dprice=$price-$dprice;
	return $dprice;
}
function wholesale_qty($product_id){
	$wholesale_qty=mysql_fetch_array(db_query("select product_wholesale_qty from tbl_product where product_id='$product_id'"));
	$wqty=$wholesale_qty[product_wholesale_qty];
	return $wqty; 	
}
function news_js_write(){
	$cnt=0;
	$content ='var pausecontent=new Array()'."\n";
	$sql=db_query("select * from tbl_news where news_status='Active' order by news_date_post desc");
	while($newsres=mysql_fetch_array($sql)){
		@extract($newsres);
		$b_desc=substr($news_desc,0,138)."...";
		$content .='pausecontent['.$cnt.']=\'<span class="name"><em>'.stripslashes($news_title).'</em></span><br /><a href="news-details.php?news_id='.$news_id.'" class="link_sml03">&quot;'.stripslashes($b_desc).'&quot;</a>\''."\n";
		$cnt++;
	}
	$file_path=SITE_FS_PATH."/Scripts/testimonial.js";
	$fp=fopen($file_path,"w");
	fwrite($fp,$content);
	fclose($fp);
}

function size_parent_id($size_id){
	$res=mysql_fetch_array(db_query("select size_cat_parent_id from tbl_size_category where size_cat_id='$size_id'"));
	$cid=$res[size_cat_parent_id];
	return $cid;
}
function site_address(){
	$site_address=mysql_fetch_array(db_query("select site_address from tbl_config where config_id='1'"));
	$add=nl2br($site_address[site_address]);	
	return $add;
}
function mail_style_body(){
   $var='<style type="text/css">
            body{
			margin:0;
			padding:0
			font-weight: normal;
			line-height:18px;
			color: #000000;
			text-decoration: none;
			text-align: justify;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11px;
			font-weight: normal;
		}
		.border{
			border: 1px solid #c0dc8e;
			padding-left:5px;
			padding-right:5px;
		}
		.boldnew{
			font-family: Arial;
			font-size: 12px;
			font-weight: bold;
			font-variant: normal;
			text-transform: none;
			color: #b3d665;
			text-decoration: none;
		}
		.dates{
			font-family: Arial;
			font-size: 11px;
			font-weight:bolder;
			color: #000000;
			margin-left:10px;
			text-decoration:none;
		}
		.invoice{
			font-family: Arial, Helvetica, sans-serif;
			font-size: 10px;
			font-weight: bold;
			color: #909090;
			text-decoration: none;
			text-align: center;
		}
		</style>';
       return $var;       
}
function invoice_mail($order_no){
	$var=mail_style_body();
	$var .='
	<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
	<table width="500" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="500"  border="0" align="center" cellpadding="0" cellspacing="0" class="border">
      <tr>
        <td   colspan="2" class="boldnew">Your Invoice </td>
        </tr>
      <tr>
        <td width="798"  valign="top" >'.site_address().'</td>
        <td  align="right" valign="top"><img src="'.SITE_WS_PATH.'/'.IMAGE_FOLDER.'/logo.gif" width="165" height="48"></td>
        </tr>
    </table> </td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" height="124"  border="0" align="right" cellpadding="0" cellspacing="0" class="border">
      <tr>
        <td height="24" colspan="3" class="boldnew">Your Details</td>
        </tr>
      <tr>
        <td height="24" class="dates">Billing Address </td>
		<td>&nbsp;</td>
		<td class="dates">Shipping Address </td>
        </tr>
      <tr>
        <td width="481" height="60" valign="top">'.order_billing_address($order_no).'</td>
        <td width="12">&nbsp;</td>
        <td width="455" valign="top">'.order_shipping_address($order_no).'</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0" class="border">
      <tr>
        <td height="24" class="boldnew">Special Comment </td>
      </tr>
      <tr>
        <td  valign="top">'.nl2br(special_comments($order_no)).'</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" height="194" border="0" align="left" cellpadding="0" cellspacing="0" class="border">
      <tr>
        <td height="22" colspan="5" class="boldnew">  
          <table width="100%"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="37%" height="20">Invoice Details</td>
              <td width="31%" align="right" class="invoice">Invoice Date: '.only_date_format2(order_date($order_no)).'</td>
              <td width="32%" align="center" class="invoice">Invoice no: '.$order_no.'</td>
            </tr>
          </table></td>
        </tr>
      <tr class="dates">
        <td height="19" class="dates">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#f5f8eb" class="dates">
        <td width="14%" height="19" bgcolor="#f5f8eb" class="dates"> Product name </td>
        <td width="14%"> Product Code </td>
        <td width="15%"> Qty </td>
        <td width="14%"> Price/Unit </td>
        <td width="14%"> Amount </td>
        </tr>';
      
        $result=db_query("select * from tbl_order_detail where order_id='$order_no'");
        $cnt=0;
        while($line_raw=mysql_fetch_array($result)){
	        $cnt++;
	        $prodDtl=mysql_fetch_array(db_query("select product_code,product_name from tbl_product where product_id='$line_raw[product_id]'"));
	        $total=$line_raw[product_price]*$line_raw[product_qty];
	        $sub_total+=$total;
	      $var.='<tr>
	        <td height="19">'.stripslashes($prodDtl[product_name]).'</td>
	        <td>'.stripslashes($prodDtl[product_code]).'</td>
	        <td>'.$line_raw[product_qty].'</td>
	        <td>'.CURRANCY_SYMBOL.$line_raw[product_price].'</td>
	        <td>'.CURRANCY_SYMBOL.$total.'</td>
        </tr>';
  	  }
      $var.='<tr>
        <td height="24">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="24" colspan="5"><table width="480"  border="0" cellpadding="0" cellspacing="0" >
	   <tr>
	    <td width="293">&nbsp;</td>
	    <td width="113" class="dates">Sub Total </td>
	    <td width="74">'.CURRANCY_SYMBOL.$sub_total.'</td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td class="dates">Shipping Carges</td>
	    <td>'.CURRANCY_SYMBOL.shiping_charge().'</td>
	  </tr>';
		$totalnew=$sub_total+shiping_charge();
	  $var.='<tr>
	    <td>&nbsp;</td>
	    <td class="dates">Grand Total </td>
	    <td>'.CURRANCY_SYMBOL.$totalnew.'</td>
	</tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></body>';
return $var;
}

function country_list_dropdown($val){
	$qry=db_query("select * from tbl_country_master order by contName");
	while($res=mysql_fetch_array($qry)){
		($res[contName]==$val)?$ccsel="selected":$ccsel="";
		$pp.='<option value="'.$res[contName].'" '.$ccsel.'>'.$res[contName].'</option>';
	}
	return $pp;
}
function special_comments($order_id){
	$res=mysql_fetch_array(db_query("select special_comments from tbl_order where order_id='$order_id'"));
	$s=$res[0];
	return $s;
		
}

function GetName($name){
	$name1=stripslashes($name);
	$pname=str_replace("#","",$name1);
	$pname=str_replace("-","",$pname);
	$pname=str_replace(".","",$pname);
	$pname=str_replace("/","",$pname);
	$pname=str_replace("&","",$pname);
	$pname=str_replace("$","",$pname);
	$pname=str_replace(" ","_",$pname);
	$pname=str_replace('"',"",$pname);
	$pname=str_replace("'","",$pname);
	return $pname;	
}
?>