<?php
	session_start();
	header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	$db->query("USE datawarehouse");
		// check OS
		function os_detection ( $var )

		{
			if (preg_match("/windows nt 5.1/i",$var)) $temp = 'Windows XP';
			elseif (preg_match("/windows xp/i",$var)) $temp = 'Windows XP';
			elseif (preg_match("/windows nt 6.0/i",$var)) $temp = 'Windows Vista';
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
			else $temp = "unknown";

			return $temp;
		}
		function Dot2LongIP ($IPaddr)
{
    if ($IPaddr == "") {
        return 0;
    } else {
        $ips = split ("\.", "$IPaddr");
        return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
    }
}
// check Browser
	function getBrowser($userAgent) {
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
			'Internet Explorer 8' => '(MSIE 8\.[0-9]+)',
			'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
			'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
			'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
			'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
		);
		foreach($browsers as $browser=>$pattern) { 
			if(eregi($pattern, $userAgent)) { 
				return $browser; 
			}
		}
		return 'Unknown'; 
	}
if($_GET["mid"] != ""){
	
				if($_SERVER["REMOTE_ADDR"]){
						$IPn = $_SERVER["REMOTE_ADDR"];
					}else{
						$IPn = $_SERVER["REMOTE_HOST"];
					}
	
	$myip = $IPn;
	$visitor = "";
	$newvisitor = "";
	$mydate = date("Y-m-d");
	$mytime = date("H:i:s");
	$mytimestamp = date("YmdHis");
	$mycountry = "";
	$mybrowser = "";
	$myresolution = $_GET["res"];
	$mydomain = "";
	$myisp = "";
	$myregion = "";
	$mycity = "";
	$mylatitude = "";
	$mylonditude = "";
	$myreferer = "";
	$mysearchengine = "";
	$mykeyword = "";
	$myos = "";
	$myload = $_GET["load"];
	$myreferer = "";
	$mylanguage = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
	// check visitor & new visitor

	if(!session_is_registered("DWH_VISITOR_STAT")){
		session_register("DWH_VISITOR_STAT");
		$visitor = "Y";
		$myreferer = $_SESSION["DWH_REFERER"];
		$sql_new = $db->query("SELECT COUNT(stat_id) FROM stat_meeting WHERE ip = '".$myip."' ");
		$CIP = $db->db_fetch_row($sql_new);
			if($CIP[0] == 0){
				$newvisitor = "Y";
			}
	}
	//end check visitor & new visitor
if($visitor == "Y"){	
	// check country


		$ipno = Dot2LongIP($myip);
		$db->query("USE ".$EWT_DB_USER);
		$sql_country = $db->query("SELECT * FROM location WHERE " . $ipno . " BETWEEN IP_FROM AND IP_TO LIMIT 0,1");
		$C = $db->db_fetch_row($sql_country);
			$mycountry = $C[3];
			$mydomain = $C[9];
			$myisp = $C[8];
			$myregion = $C[4];
			$mycity = $C[5];
			$mylatitude = $C[6];
			$mylonditude = $C[7];
			if($mycountry  == ""){
			$mycountry  = "-";
			}
	//end check country

	
	$mybrowser = getBrowser($_SERVER['HTTP_USER_AGENT']);
	// end check Browser


			if($myreferer != ""){
				$referer_temp = $myreferer;
                parse_str ( str_replace ( "?","&","___url_http_referer=".$referer_temp ) , $vars );
                $searchengine = "";
                $altterms = "";

                if ( !array_key_exists ( "q" , $vars) )
                 $vars [ "q" ] = "";
                if ( !array_key_exists ( "p" , $vars) )
                 $vars [ "p" ] = "";
                if ( !array_key_exists ( "query" , $vars) )
                 $vars [ "query" ] = "";
                if ( !array_key_exists ( "search" , $vars) )
                 $vars [ "search" ] = "";
                if ( !array_key_exists ( "Keywords" , $vars) )
                 $vars [ "Keywords" ] = "";
                if ( !array_key_exists ( "ask" , $vars) )
                 $vars [ "ask" ] = "";
                if ( !array_key_exists ( "qkw" , $vars) )
                 $vars [ "qkw" ] = "";
                if ( !array_key_exists ( "searchfor" , $vars) )
                 $vars [ "searchfor" ] = "";
                if ( !array_key_exists ( "terms" , $vars) )
                 $vars [ "terms" ] = "";

                if ( preg_match ("/http.+google\..+\/.+/",$vars["___url_http_referer"] ) )
                 { $searchengine = "Google"; $terms = $vars [ "q" ]; }

                if ( preg_match ("/http.+altavista\..+\/.+/",$vars["___url_http_referer"] ) )
                 { $searchengine = "Altavista"; $terms = $vars["q"]; }

                if ( preg_match ("/http.+wisenut\..+\/.+/",$vars["___url_http_referer"] ) )
                 { $searchengine = "WiseNet"; $terms = $vars["q"];   }

                if ( preg_match ("/http.+alltheweb\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "AllTheWeb"; $terms = $vars["q"]; }

                if ( preg_match ("/http.+\.yahoo\..+\/.+/",$vars["___url_http_referer"] ) )
                 { $searchengine = "Yahoo"; $terms = $vars["p"]; }

                if ( preg_match ("/http.+\.aol\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "AOL"; $terms = $vars["query"]; }

                if ( preg_match ("/http.+netscape\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "Netscape"; $terms = $vars["query"]; }

                if ( preg_match ("/http.+\.lycos\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "Lycos"; $terms = $vars["query"]; }

                if ( preg_match ("/http.+\.teoma\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "Teoma"; $terms = $vars["query"]; }

                if ( preg_match ("/http.+\.dmoz\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "dmoz"; $terms = $vars["search"]; }

                if ( preg_match ("/http.+\.overture\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "Overture"; $terms = $vars["Keywords"]; }

                if ( preg_match ("/http.+\.ask\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "AskJeeves"; $terms = $vars["ask"]; }

                if ( preg_match ("/http.+\.about\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "About"; $terms = $vars["terms"]; }

                if ( preg_match ("/http.+\.looksmart\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "LookSmart"; $terms = $vars["key"]; }

                if ( preg_match ("/http.+\.excite\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "Excite"; $terms = $vars["qkw"]; }

                if ( preg_match ("/http.+\.iwon\.com.+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "IWon"; $terms = $vars["searchfor"]; }

                if ( preg_match ("/http.+\.webcrawler\.com.+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "WebCrawler"; $terms = $vars["qkw"]; }

                if ( preg_match("/http.+\.msn\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "MSN"; $terms = $vars["q"]; }

				 if ( preg_match("/http.+\.live\..+\/.+/",$vars["___url_http_referer"]) )
                 { $searchengine = "LIVE"; $terms = $vars["q"]; }

				$mysearchengine = $searchengine;
				$mykeyword = urldecode($terms);
				
				}
	// end check Search Engines


		$myos = os_detection($_SERVER['HTTP_USER_AGENT']);
	// end check OS
		$db->query("USE ".$EWT_DB_NAME);
		$db->query("USE datawarehouse");
		$db->query("INSERT INTO stat_meeting (data_wh_id,timestamp,date,time,ip,country,
															language,new,browser,resolution,domain,isp,region,city,latitude,
															longitude,search,os) 
								VALUES ('".$_GET[mid]."','".$mytimestamp."','".$mydate."','".$mytime."','".$myip."','".$mycountry."',
													'".$mylanguage."','".$newvisitor."','".$mybrowser."','".$myresolution."','".$mydomain."','".$myisp."','".$myregion."','".$mycity."','".$mylatitude."','".$mylonditude."','','".$myos."')");
	}else{
		$db->query("USE ".$EWT_DB_NAME);
		$db->query("USE datawarehouse");
				$db->query("INSERT INTO stat_meeting (data_wh_id,timestamp,date,time,ip,country,
															language,new,browser,resolution,domain,isp,region,city,latitude,
															longitude,search,os) 
								VALUES ('".$_GET[mid]."','".$mytimestamp."','".$mydate."','".$mytime."','".$myip."',NULL,
													NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL)");
	}
}
$db->db_close(); ?>
