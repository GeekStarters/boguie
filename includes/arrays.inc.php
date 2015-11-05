<?
$ARR_VALID_IMG_EXTS = array('jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp');

$ARR_WEEK_DAYS = array(
'mon' => 'Monday',
'tue' => 'Tuesday',
'wed' => 'Wednesday',
'thu' => 'Thursday',
'fri' => 'Friday',
'sat' => 'Saturday',
'sun' => 'Sunday'
);

$ARR_MONTHS = Array('01'=>'Jan' , '02'=>'Feb' , '03'=>'Mar' , '04'=>'Apr' , '05'=>'May' , '06'=>'Jun' , '07'=>'Jul' , '08'=>'Aug' , '09'=>'Sep' , '10'=>'Oct' , '11'=>'Nov' , '12'=>'Dec');
$ARR_NAME_TITLE = Array('Mr.'=>'Mr.' , 'Miss.'=>'Miss.' , 'Mrs.'=>'Mrs.');

$arr_video_ext=array("aac"=>"aac","aif"=>"aif","m3u"=>"m3u","mid"=>"mid","midi"=>"midi","mp3"=>"mp3","mpa"=>"mpa","ra"=>"ra","ram"=>"ram","wav"=>"wav","wma"=>"wma","3gp"=>"3gp","asf"=>"asf","asx"=>"asx","avi"=>"avi","mov"=>"mov","mp4"=>"mp4","mpg"=>"mpg","qt"=>"qt","rm"=>"rm","swf"=>"swf","wmv"=>"wmv","dat"=>"dat","fla"=>"fla","flv"=>"flv");

$ARR_STORY_FILE = Array('Video'=>'Video' , 'Audio'=>'Audio' , 'Image'=>'Image');
/*if ($handle = opendir(dirname(__FILE__).'/db_arrays')) { 
	while (false !== ($file = readdir($handle))) { 
		if ($file != "." && $file != "..") { 
			include(dirname(__FILE__).'/db_arrays/'.$file);
		} 
	} 
   closedir($handle); 
} */

$AVAILABILITY_ARRAY=array('In Stock', 'Out Stock');

$MEMBER_TYPE_ARR=array("Retailer","Wholesaler");

$CITY_ARR=array("Delhi","Noida","Gurgaon","Mumbai","Kolkata","Chennai","Hyderabad","Bangalore","Pune","Nagpur");
$TITLE_ARR=array("Mr.","Miss.","Mrs.");
?>