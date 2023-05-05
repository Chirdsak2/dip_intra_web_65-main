<?php
// session_start();
DEFINE('path', 'assets/');
include(path.'config/config.inc.php');
include('../../assets/configs/function.inc.php');
//include('../../assets/plugin/browser/browser.class.php'); 

$a_data = array_merge($_POST, $_FILES);
$proc = $a_data['proc'];  
 
switch($proc)  
{
	case "VisitorStat": 
	  
	if(is_array($a_data))
	{
		//exit();

	$strSessionID = session_id(); 
//$browser = new BrowserDetection();
//print_r($_SESSION);
//$s_platform = $browser->__toString();     
//echo $_SERVER["HTTP_ACCEPT_LANGUAGE"];
//echo PHP_VERSION;
//echo PHP_OS;
//echo getIP();


/*$url = "http://www.useragentstring.com/?uas=".urlencode($_SERVER['HTTP_USER_AGENT'])."&getJSON=all";
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
$isp_array = json_decode($result, true);
//$isp_array = ip_detail(getIP());	

echo '<pre>',print_r($isp_array, true),'</pre>';*/

//echo detectdevice();
//echo detectdevice2(); 

	$filename = trim($a_data['filename']); 

	if(!empty($filename)) 
	{

	$filename = $filename;
	$a_ip = getIPVisit();
	$visitor = "";
	$newvisitor = "";
	$a_url = $a_data['t'];
	$a_date = date('Y-m-d');
	$a_time = date("H:i:s");
	$a_timestamp = date("YmdHis");
	$a_keyword = '';
	//$mycountry = "";
	//$mybrowser = ""; 
	
	$a_resolution = $a_data['res'];
	
	//$mydomain = "";
	//$myisp = "";
	//$myregion = "";
	//$mycity = "";
	//$mylatitude = "";
	//$mylonditude = "";
	//$myreferer = "";
	//$mysearchengine = "";
	//$mykeyword = "";
	//$myos = "";
		
	$a_load     =	$a_data['load'];
	$a_language =	$_SERVER['HTTP_ACCEPT_LANGUAGE'];
		
	
	// check device		
	$a_device 	=	detectdevice2(); 	
	// end check device
	
	// check visitor & new visitor	
	if(dirname($_SERVER["SCRIPT_NAME"]) == "/")
	{		
		$urlname = "";
	}
	else
	{
		$urlname = dirname($_SERVER["SCRIPT_NAME"]);	
	}
	$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';	
	//$myfullurl = "http://".$_SERVER['SERVER_NAME'].$urlname."/main.php?filename=".$_GET["filename"];
	$a_fullurl = $_protocal."://".$_SERVER['SERVER_NAME'].$filename;
  
	if(!isset($_SESSION['EWT_VISITOR_STAT']))
	{
		//session_register("EWT_VISITOR_STAT");
		$_SESSION['EWT_VISITOR_STAT'] = '';  
		
		$visitor 	= 	"Y";		
		$myreferer 	= 	$_SESSION["EWT_REFERER"];
		$a_referer 	=	isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		
		$_sql 		=	"SELECT sv_id FROM stat_visitor WHERE sv_ip = '{$a_ip}' AND sv_new = 'Y' LIMIT 0,1 "; 
		$a_row		= 	db::getRowCount($_sql);
		$a_visitor 	= 	db::getFetchAll($_sql,PDO::FETCH_ASSOC);	  
		if($a_row) 
		{	
			$newvisitor = "";
		}
		else
		{
			$newvisitor = "Y";	
		}		
	}  
	//end check visitor & new visitor

	//check country			
	$isp_array = ip_detail($a_ip); 			
			
	//$a_country = $isp_array['country_name'];
	//$a_region = $isp_array['region'];
	//$a_city =  $isp_array['city'];
	//$a_country_code = $isp_array['country_code'];
	$a_region_code = $isp_array['region_code'];	
	//end check country

	//check latitude londitude	 
	//$a_latitude = $isp_array['latitude'];
	//$a_londitude = $isp_array['longitude'];	 
	//end latitude londitude	 
					
	//check domain		
	$hostname = ip_hostname($a_ip); 
	$a_domain = $hostname->hostname; 
	$a_country = $hostname->country;
	$a_region = $hostname->region;
	$a_city =  $hostname->city;
	$a_country_code = $hostname->country;
	$loc = explode( ',',$hostname->loc);
	$a_latitude  = $loc['0'];
	$a_londitude = $loc['1'];	
	// end check domain

	//check isp		
	//$a_isp = $isp_array['organisation'];
	$a_isp = $hostname->org;
	//end check isp
	
	
	//check Browser
	$a_browser = getBrowser($_SERVER['HTTP_USER_AGENT']);  
	//end check Browser


	// check Search Engines
	//$myreferer = "http://www.google.co.th/search?hl=th&q=%E0%B8%95%E0%B8%B0%E0%B8%81%E0%B8%B1%E0%B9%88%E0%B8%A7&meta=";		
	if($myreferer != "")
	{
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

				$a_searchengine = $searchengine;
				$a_keyword = urldecode($terms);
				
	}
	//end check Search Engines

	//check OS
	$a_os = os_detection($_SERVER['HTTP_USER_AGENT']);
	//end check OS
	if($_SESSION['EWT_MID'])
	{
		$a_member = 'Y';
	}
	else
	{
		$a_member = '';	
	}
		
	/*$s_insert = "INSERT INTO stat_visitor (`sv_url`,
											  `sv_visitor`,
											  `sv_menu`,
											  `sv_ip`,
											  `sv_timestamp`,
											  `sv_date`,
											  `sv_time`,
											  `sv_country`,
											  `sv_language`,
											  `sv_new`,
											  `sv_browser`,
											  `sv_resolution`,
											  `sv_domain`,
											  `sv_isp`,
											  `sv_region`,
											  `sv_city`,
											  `sv_latitude`,
											  `sv_longitude`,
											  `sv_referer`,
											  `sv_search`,
											  `sv_keyword`,
											  `sv_os`,
											  `sv_load`,
											  `sv_member`,
											  `sv_fullurl`,
											  `sv_mem_id`,
											  `sv_w3c`,
											  `sv_country_code`,
											  `sv_region_code`,
											  `sv_device`,
											  `sv_op`,
											  `sv_session_id`
											  ) 
											  VALUES 
											  ('{$a_url}',
											  '{$visitor}',
											  '{$filename}',
											  '{$a_ip}',
											  '{$a_timestamp}',
											  '{$a_date}',
											  '{$a_time}',
											  '{$a_country}',
											  '{$a_language}',
											  '{$newvisitor}',
											  '{$a_browser}',
											  '{$a_resolution}',
											  '{$a_domain}',
											  '{$a_isp}',
											  '{$a_region}',
											  '{$a_city}',
											  '{$a_latitude}',
											  '{$a_londitude}',
											  '{$a_referer}',
											  '{$a_searchengine}',
											  '{$a_keyword}',
											  '{$a_os}',
											  '{$a_load}',
											  '{$a_member}',
											  '{$a_fullurl}',
											  '{$_SESSION['EWT_MID']}',
											  '',
											  '{$a_country_code}',
											  '{$a_region_code}',
											  '{$a_device}',
											  '',
											  '{$strSessionID}'
											  )
											  ");*/
											  
		$s_data['sv_url']   		=	$a_url;
		$s_data['sv_visitor']   	=  	$visitor;
		$s_data['sv_menu']    		=  	$filename;
		$s_data['sv_ip']    		=  	$a_ip;
		$s_data['sv_timestamp'] 	=  	$a_timestamp;
		$s_data['sv_date']   		=  	$a_date;
		$s_data['sv_time']    		=  	$a_time; 
		$s_data['sv_country']   	=  	$a_country;
		$s_data['sv_language']  	=  	$a_language;
		$s_data['sv_new']       	=  	$newvisitor;
		$s_data['sv_browser']   	=  	$a_browser;
		$s_data['sv_resolution']	=  	$a_resolution;
		$s_data['sv_domain']    	=  	$a_domain;
		$s_data['sv_isp']       	=  	$a_isp;
		$s_data['sv_region']       	=  	$a_region;
		$s_data['sv_city']        	=  	$a_city;
		$s_data['sv_latitude']      =  	$a_latitude;
		$s_data['sv_longitude']     =  	$a_londitude;
		$s_data['sv_referer']       =  	$a_referer;
		$s_data['sv_search']        =  	$a_searchengine;
		$s_data['sv_keyword']       =  	$a_keyword;
		$s_data['sv_os']        	=  	$a_os;
		$s_data['sv_load']        	=  	$a_load;
		$s_data['sv_member']        =  	$a_member;
		$s_data['sv_fullurl']       =  	$a_fullurl; 
		$s_data['sv_mem_id']        =  	$_SESSION['EWT_MID'];
		$s_data['sv_w3c']        	=  	'';
		$s_data['sv_country_code']	=  	$a_country_code;
		$s_data['sv_region_code']   =  	$a_region_code;
		$s_data['sv_device']       	=  	$a_device;
		$s_data['sv_op']        	=  	'';
		$s_data['sv_session_id']    =  	$strSessionID;   
		
		$s_exec = db::insert("stat_visitor",$s_data);   
		## >> Stat Visitor - Count
		/*if(trim($visitor)==""){
			$this_visitor = "N";
		}
		if(trim($newvisitor)==""){
			$newvisitor   = "N";
		}
		
		$db->query("UPDATE stat_visitor_count 
		            SET sv_count = sv_count+1 
		            WHERE sv_visitor = '$this_visitor' AND sv_new = '$newvisitor'");*/					
		}
	}
	
	$a_array["status"] = true;
	$a_array["StatusMessage"] = "Success";	
	echo json_encode($a_array);	 
		
	unset($a_array);
	unset($s_data);
	unset($a_data);  
		
	exit;	
break;	 
}
 
if(empty($proc))
{
	$a_error['message'] = 'การส่งข้อมูลไม่ถูกต้อง';
	$a_error['warn'] 	= 'warning';
	echo json_encode($a_error);
}			 
// db::closeDB();
// exit; 	 
?>