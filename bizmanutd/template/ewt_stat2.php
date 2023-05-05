<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	echo gethostbyaddr ("202.57.155.169");
	
	//========================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	//========================================================
	
if($_GET["filename"] != ""){
$pname = "SP_".$_GET["filename"]."_PC";

if(!session_is_registered($pname)){
session_register($pname);
}
$today = date("Y-m-d"); 
$now = date("H:i:s"); 

function Dot2LongIP ($IPaddr){
if ($IPaddr == "") {
return 0;
} else {
$ips = split ("\.", "$IPaddr");
return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
}
}
// get_ip
if(getenv(HTTP_X_FORWARDED_FOR)){
$IPn = getenv(HTTP_X_FORWARDED_FOR);
}else{
$IPn = getenv("REMOTE_ADDR");
}	
echo $IPn."<br>";
$ipno = Dot2LongIP($IPn);

$db->query("USE ".$EWT_DB_USER);

$sql = $db->query("SELECT ip_country_short FROM ip_country WHERE " . $ipno . " BETWEEN ip_start_number AND ip_end_number");
$R = $db->db_fetch_row($sql);



$domain_temp = strtolower($R[0]);
if($domain_temp == ""){
$domain_temp = "th";
}
echo $domain_temp."<br>";
function getBrowser($userAgent) {
  // Create list of browsers with browser name as array key and user agent as value. 
	$browsers = array(
		'Opera' => 'Opera',
		'Mozilla Firefox'=> '(Firebird)|(Firefox)', // Use regular expressions as value to identify browser
		'Galeon' => 'Galeon',
		'Mozilla'=>'Gecko',
		'MyIE'=>'MyIE',
		'Lynx' => 'Lynx',
		'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
		'Konqueror'=>'Konqueror',
		'SearchBot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)',
		'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
		'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
		'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
		'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
	);

	foreach($browsers as $browser=>$pattern) { // Loop through $browsers array
    // Use regular expressions to check browser type
		if(eregi($pattern, $userAgent)) { // Check if a value in $browsers array matches current user agent.
			return $browser; // Browser was matched so return $browsers key
		}
	}
	return 'Unknown'; // Cannot find browser so return Unknown
}
function getOS(){
$curos=strtolower($_SERVER['HTTP_USER_AGENT']);
if (strstr($curos,"mac")) {
$uos="MacOS";
} else if (strstr($curos,"linux")) {
$uos="Linux";
} else if (strstr($curos,"win")) {
$uos="Windows";
} else if (strstr($curos,"bsd")) {
$uos="BSD";
} else if (strstr($curos,"qnx")) {
$uos="QNX";
} else if (strstr($curos,"sun")) {
$uos="SunOS";
} else if (strstr($curos,"solaris")) {
$uos="Solaris";
} else if (strstr($curos,"irix")) {
$uos="IRIX";
} else if (strstr($curos,"aix")) {
$uos="AIX";
} else if (strstr($curos,"unix")) {
$uos="Unix";
} else if (strstr($curos,"amiga")) {
$uos="Amiga";
} else if (strstr($curos,"os/2")) {
$uos="OS/2";
} else if (strstr($curos,"beos")) {
$uos="BeOS";
} else
{ $uos="Unknown OS";
}
return $uos;
}
$browser = getBrowser($_SERVER['HTTP_USER_AGENT']);
echo $browser."<br>";
echo getOS()."<br>";
$ref = "http://www.google.co.th/search?hl=th&q=%E0%B8%95%E0%B8%B0%E0%B8%81%E0%B8%B1%E0%B9%88%E0%B8%A7&meta=";
$p = strlen("q");
$g = explode("&",$ref);
$cg = count($g);
$keyword = "";
for($i=0;$i<$cg;$i++){
$rest = substr($g[$i], 0, $p);
	if($rest == "q"){
		$keyword = substr($g[$i], ($p+1));
	}
}
$url = explode("/",$ref);
echo $url[2]."<br>";
echo urldecode($keyword);
$db->query("USE ".$EWT_DB_NAME);
if($_SESSION["EWT_MID"] != ''){
		$mymember =='Y';
		}
$db->query("INSERT INTO stat_visitor ( sv_id  , sv_url , sv_menu , sv_ip , sv_date , sv_time , sv_country  ) VALUES ('' , 'page', '".$_GET["filename"]."', '".$IPn."', '".$today."', '".$now."', '".$domain_temp."')");
}

$end_time_counter = date("YmdHis");
$gap = $end_time_counter - $start_time_counter;
echo "<font color=white>Server Load Time ".$gap." Sec.</font><br>";
echo "<span id=\"load_client\"></span>";
$db->db_close(); ?>
<script language="JavaScript1.2">
document.write(screen.width + "x" + screen.height);
</script>