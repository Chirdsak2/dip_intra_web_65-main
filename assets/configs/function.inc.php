<?php

function count_device($s_id,$s_wh){
	global $db,$EWT_DB_NAME;
	
$s_device = $db->query("SELECT sv_device,count(sv_id) AS device 
FROM stat_visitor 
WHERE sv_device = '{$s_id}' AND sv_device != '' {$s_wh} ");
$a_device = $db->db_fetch_row($s_device);

return $a_device[1];

}

function count_session($s_wh){
	global $db,$EWT_DB_NAME;
	
$s_session = $db->query("SELECT count(sv_session_id) AS session 
FROM stat_visitor 
WHERE  sv_session_id != '' {$s_wh} ");
$a_session = $db->db_fetch_row($s_session);

return $a_session[0];

}

function count_users($s_wh){
	global $db,$EWT_DB_NAME;;
	
$s_users = $db->query("SELECT count(sv_id) AS users 
FROM stat_visitor 
WHERE  sv_visitor = 'Y' AND sv_session_id != '' {$s_wh} ");
$a_users = $db->db_fetch_row($s_users);

return $a_users[0];

}

function count_new_users($s_wh){
	global $db,$EWT_DB_NAME;;
	
$s_session = $db->query("SELECT count(sv_session_id) AS session 
FROM stat_visitor 
WHERE sv_new = 'Y' AND sv_session_id != '' {$s_wh} ");
$a_session = $db->db_fetch_row($s_session);

return $a_session[0];

}

function getIPVisit(){
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
      $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
      $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
      $ipaddress = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
      $ipaddress = getenv('REMOTE_ADDR');
  else
      $ipaddress = 'UNKNOWN';
  return $ipaddress;
}


function ip_hostname($ip) {
    $json = file_get_contents("http://ipinfo.io/{$ip}");
    $details = json_decode($json); // HERE!!!
    return $details;
}


function ip_detail($ip) {
	
$url = "https://api.ipdata.co/{$ip}?api-key=4a1c949c4318dd2a0293a95d9e9d383d3576ee46fe3ceaea8cd16960";
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result = curl_exec($ch); 

if(!$result){
	die("Connection Failure");
	}
// Closing
curl_close($ch);
// Will dump a beauty json :3
//var_dump(json_decode($result, true));
$array = json_decode($result, true);

 return $array;
}


function detectdevice(){
	$userAgent = $_SERVER["HTTP_USER_AGENT"];
	$devicesTypes = array(
        "computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
        "tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
        "mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
        "bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
    );
 	foreach($devicesTypes as $deviceType => $devices) {           
        foreach($devices as $device) {
            if(preg_match("/" . $device . "/i", $userAgent)) {
                $deviceName = $deviceType;
            }
        }
    }
    return ucfirst($deviceName);
 	}
	
	
function detectdevice2(){	
	$tablet_browser = 0;
	$mobile_browser = 0;
 
if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
}
 
if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
}
 
if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
}
 
$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');
 
/*if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}*/
 
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}
 
if ($tablet_browser > 0) {
   // do something for tablet devices
   $deviceName =  '2';
}
else if ($mobile_browser > 0) {
   // do something for mobile devices
   $deviceName = '3';
}
else {
   // do something for everything else
   $deviceName = '1';
} 
 return $deviceName;
 
 	}



function getBrowser($userAgent) {
		$browsers = array(
			'Opera' => 'Opera',
			'Mozilla Firefox'=> '(Firebird)|(Firefox)', // Use regular expressions as value to identify browser
			'Galeon' => 'Galeon',
			'MyIE'=>'MyIE',
			'Edge' => '(Edg)', 
			'Google Chrome'=>'Chrome',
			'Lynx' => 'Lynx',
			'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
			'Konqueror'=>'Konqueror',
			'SearchBot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)',			
			'Safari' => 'safari',
			'Maxthon' => 'maxthon',
			'Handheld Browser' => 'mobile',
			'Internet Explorer 11' => '(RV:11\.[0-9]+)',
			'Internet Explorer 10' => '(MSIE 10\.[0-9]+)',
			'Internet Explorer 9' => '(MSIE 9\.[0-9]+)',
			'Internet Explorer 8' => '(MSIE 8\.[0-9]+)',
			'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
			'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
			'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
			'Internet Explorer 4' => '(MSIE 4\.[0-9]+)'
		);
	
		foreach($browsers as $browser=>$pattern) { 
			if(preg_match('/'.$pattern.'/i', $userAgent)){ 
				return $browser;  
			}
		}
		return 'Unknown'; 
	} 

function os_detection ( $var ){			
			if(preg_match("/windows nt 5.1/i",$var)) $temp = 'Windows XP';
			elseif (preg_match("/windows xp/i",$var)) $temp = 'Windows XP';
			elseif (preg_match("/windows nt 6.0/i",$var)) $temp = 'Windows Vista';
			elseif (preg_match("/Windows NT 6.1/i",$var)) $temp = 'Windows 7';
			elseif (preg_match("/Windows NT 6.2/i",$var)) $temp = 'Windows 8';
			elseif (preg_match("/windows nt 6.3/i",$var)) $temp = 'Windows 8.1';
			elseif (preg_match("/windows nt 10/i",$var)) $temp = 'Windows 10';
			elseif (preg_match("/linux/i",$var)) $temp = 'Linux';
			elseif (preg_match("/macintosh/i",$var)) $temp = 'Macintosh';
			elseif (preg_match("/win 9x 4.90/i",$var)) $temp = 'Windows Me';
			elseif (preg_match("/windows me/i",$var)) $temp = 'Windows Me';
			elseif (preg_match("/windows nt 5.0/i",$var)) $temp = 'Windows 2000';
			elseif (preg_match("/windows nt 5.2/i",$var)) $temp = 'Windows 2003';
			elseif (preg_match("/windows 2000/i",$var)) $temp = 'Windows 2000';
			elseif (preg_match("/windows nt 3.1/i",$var)) $temp = 'Windows 3.1';
			elseif (preg_match("/windows nt 3.5.0/i",$var)) $temp = 'Windows NT 3.5';
			elseif (preg_match("/windows nt 3.5.1/i",$var)) $temp = 'Windows NT 3.5.1';
			elseif (preg_match("/windows nt 4.0/i",$var)) $temp = 'Windows NT 4.0';
			elseif (preg_match("/windows 98/i",$var)) $temp = 'Windows 98';
			elseif (preg_match("/windows 95/i",$var)) $temp = 'Windows 95';
			elseif (preg_match("/sunos/i",$var)) $temp = 'SunOS';
			elseif (preg_match("/mac/i",$var)) $temp = 'MacOS';
			elseif (preg_match("/Android/i",$var)) $temp = 'Android';
			elseif (preg_match("/Ubuntu/i",$var)) $temp = 'Ubuntu';
			elseif (preg_match("/ubuntu/i",$var)) $temp = 'Ubuntu';
			elseif (preg_match("/iPhone/i",$var)) $temp = 'iPhone';
			elseif (preg_match("/iPad/i",$var)) $temp = 'iPad';
			elseif (preg_match("/android/i",$var)) $temp = 'Android';
			elseif (preg_match("/blackberry/i",$var)) $temp = 'BlackBerry';
			elseif (preg_match("/Mac_PowerPC/i",$var)) $temp = 'Mac_PowerPC / Mac OS 9';
			elseif (preg_match("/macintosh|mac os x/i",$var)) $temp = 'Mac OS X';
			elseif (preg_match("/OS2/i",$var)) $temp = 'OS2';
			else $temp = "Unknown";

			return $temp;
}	
?>