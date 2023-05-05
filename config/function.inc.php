<?php
function redirect($s_url)
{
  if (!headers_sent())    //If headers not sent yet... then do php redirect
  {
    header('Location: '.$s_url);
    exit;
  }
  else //If headers are sent... do java redirect... if java disabled, do html redirect.
  {
    echo '<script type="text/javascript">';
    echo 'window.location.href="'.$s_url.'";';
    echo '</script>';
    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url='.$s_url.'" />';
    echo '</noscript>';
    exit;
  }
}

function nidshare($nid){
	global $db;
	
	$exc = $db->query("select * from article_list where n_id = '".$nid."'");
	$row = $db->db_fetch_array($exc);
	$imgs1 = explode('_',$row["picture"]);
	$imgs2 = explode('.',$imgs1[1]);	
	return $imgs2[0];
		
}

function share_face($nid){
	global $db,$EWT_FOLDER_USER;
	$PHPSELF = explode('/',$_SERVER["PHP_SELF"]);
	$exc = $db->query("select * from article_list where n_id = '".$nid."'");
	$row = $db->db_fetch_array($exc);
	if($row['n_sharename']!=""){
		$paths = $PHPSELF[1]."/ewt/".$row['n_sharename']."/";
	}else{
		$paths = $PHPSELF[1]."/ewt/".$EWT_FOLDER_USER."/";
		//$paths = $PHPSELF[1]."/";
	}

	return "http://".$_SERVER['HTTP_HOST']."/".$paths;	
}	

function link_share_face($s_modal,$s_params)
{
	
	$s_host = $_SERVER['HTTP_HOST'];
	$s_name = $_SERVER['SCRIPT_NAME'];
	$s_url  = $_SERVER['REQUEST_URI'];
	$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';	
	$s_method = strtok($s_url, '?');
    if($s_method)
		{
			$a_method = explode('/', $s_method);
			$chk_site = "/".$a_method[1]."/".$a_method[2]."/".$a_method[3];
		}	
	return $_protocal."://".$s_host.$chk_site.'/'.$s_modal.'.php?'.$s_params;
}



function get_key($s_data)
{
	if(is_array($s_data)){
			 foreach((array)$s_data as $_key=>$_item)
			 {
				 $_arr = $_item;
			 }
	}else{
		$_arr = '';
	}
  return $_arr;
}	
function get_para($s_data)
{
	if(is_array($s_data)){
			 foreach((array)$s_data as $_key=>$_item)
			 {
				 $_arr[] = $_key."=".$_item."";
			 }
	}else{
		$_arr = '';
	}
  return $_arr;
}	
	
function meta_share_all($s_module)
{
	global $db,$s_key,$s_val,$s_get;
	if(SYS_LANG){
	include('language/lang_'.SYS_LANG.'.php');
	}
         
	$a_id	= $s_val[0];
	$a_para = implode('&', get_para($s_get));
	if(empty($s_module)){	
		$a_title = sitetitle();
		$a_pathimage = '';
		$a_site_name = sitetitle();
	}else{
		if (file_exists('sharesocial/'.$s_module.'.php')) {
		include('sharesocial/'.$s_module.'.php');
		$a_site_name = sitetitle();
		}else{
		$a_title = sitetitle();
		$a_pathimage = '';	
		$a_site_name = sitetitle();
		}
	}
	
	$txt ="";
	$txt .="<title>".$a_title."</title>".PHP_EOL;	
	$txt .="<meta name=\"description\" content=\"".$a_description."\" />".PHP_EOL;
	$txt .="<meta name=\"keyword\" content=\"".sitetitle()." , ".$a_title.$a_keyword."\" />".PHP_EOL;
	$txt .="<meta name=\"news_keywords\" content=\"".sitetitle()." , ".$a_keyword."\" >".PHP_EOL;
	$txt .="<meta property=\"og:site_name\" content=\"".$a_site_name."\" />".PHP_EOL;
	$txt .="<meta property=\"og:url\" content=\"".link_share_face($s_module,$a_para)."\" />".PHP_EOL;
	$txt .="<meta property=\"og:title\" content=\"".$a_title."\" />".PHP_EOL;
	$txt .="<meta property=\"og:image\" content=\"".$a_pathimage."\" />".PHP_EOL;
	$txt .="<meta property=\"og:image:secure_url\" content=\"".$a_pathimage."\" />".PHP_EOL;
	$txt .="<meta property=\"og:image:width\" content=\"600\" />".PHP_EOL;
	$txt .="<meta property=\"og:image:height\" content=\"600\" />".PHP_EOL;
	$txt .="<meta property=\"og:description\" content=\"".$a_description."\" />".PHP_EOL;
	$txt .="<meta property=\"og:type\" content=\"website\" />".PHP_EOL;
	$txt .="<meta property=\"twitter:card\" content=\"summary_large_image\" />".PHP_EOL;
	$txt .="<meta property=\"twitter:title\" content=\"".$a_description."\" />".PHP_EOL;
	$txt .="<meta property=\"twitter:site\" content=\"".$a_site_name."\" />".PHP_EOL;
	$txt .="<meta property=\"twitter:description\" content=\"".$a_description."\" />".PHP_EOL;
	$txt .="<meta property=\"twitter:image\" content=\"".$a_pathimage."\" />".PHP_EOL;

	return $txt;
}

function link_face($s_module,$s_id,$s_params)
{
		
	$s_host = $_SERVER['HTTP_HOST'];
	$s_name = $_SERVER['SCRIPT_NAME'];
	$s_url  = $_SERVER['REQUEST_URI'];
	$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';	
	$s_method = strtok($s_url, '?');
    if($s_method)
    {
		$a_method = explode('/', $s_method);
		$chk_site = "/".$a_method[1]."/".$a_method[2]."/".$a_method[3];
	}
	$s_link = "https://www.facebook.com/sharer/sharer.php?u=".urlencode($_protocal."://".$s_host.$chk_site."/".$s_module.".php?".$s_params."=".$s_id."&lang=".SYS_LANG);
	$s_shareUrl = htmlentities($s_link, ENT_QUOTES);
	
	
	return $s_shareUrl;
}

function link_twitter($s_module,$s_id,$s_params)
{
		global $db;	          
		$a_id = $s_id;	
		if (file_exists('sharesocial/'.$s_module.'.php')) {
		//include('sharesocial/'.$s_module.'.php');
		$a_site_name = sitetitle();
		}
		
	$s_host = $_SERVER['HTTP_HOST'];
	$s_name = $_SERVER['SCRIPT_NAME'];
	$s_url  = $_SERVER['REQUEST_URI'];
	$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';	
	$s_method = strtok($s_url, '?');
    if($s_method)
    {
		$a_method = explode('/', $s_method);
		$chk_site = "/".$a_method[1]."/".$a_method[2]."/".$a_method[3];
	}	
	$s_link = "https://twitter.com/intent/tweet?url=".urlencode($_protocal."://".$s_host.$chk_site."/".$s_module.".php?".$s_params."=".$s_id."&lang=".SYS_LANG)."&ref_src=&text=".$a_title."&hashtags=".sitetitle();
	$s_shareUrl = $s_link;
	

	return $s_shareUrl;
}

function link_line($s_module,$s_id,$s_params)
{
	
	$s_host = $_SERVER['HTTP_HOST'];
	$s_name = $_SERVER['SCRIPT_NAME'];
	$s_url  = $_SERVER['REQUEST_URI'];
	$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';	
	$s_method = strtok($s_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/".$a_method[2]."/".$a_method[3];
	}
	$s_link = "https://lineit.line.me/share/ui?country=TH&url=".urlencode($_protocal."://".$s_host.$chk_site."/".$s_module.".php?".$s_params."=".$s_id."&lang=".SYS_LANG);
	$s_shareUrl = $s_link;
	
	return $s_shareUrl;
}										
function share_buttons_all($s_module,$s_id,$s_params,$s_temp)
{
	
	$txt = "";

	if($s_temp  == '1'){
	$txt .="<a class=\"btn-share pr-1\" style=\"color: #B6B6B6 !important;\" onClick=\"JSShare('".link_face($s_module,$s_id,$s_params)."')\"  _href=\"".link_face($s_module,$s_id,$s_params)."\" target=\"_blank\" >";
	$txt .="<em class=\"fab fa-facebook-square fa-lg\"></em>&nbsp;".PHP_EOL;
	$txt .="</a>".PHP_EOL;

	$txt .="<a class=\"btn-share pr-1\"  style=\"color: #B6B6B6 !important;\" onClick=\"JSShare('".link_twitter($s_module,$s_id,$s_params)."')\" _href=\"".link_twitter($s_module,$s_id,$s_params)."\" target=\"_blank\" >";
	$txt .="<em class=\"fab fa-twitter-square fa-lg\"></em>&nbsp;".PHP_EOL;
	$txt .="</a>".PHP_EOL;

	$txt .="<a class=\"btn-share pr-1\"  style=\"color: #B6B6B6 !important;\" onClick=\"JSShare('".link_line($s_module,$s_id,$s_params)."')\" _href=\"".link_line($s_module,$s_id,$s_params)."\" target=\"_blank\"  title=\"share line\">";
	$txt .="<em class=\"fab fa-line fa-lg\"></em>".PHP_EOL;
	$txt .="</a>".PHP_EOL;

	}
	if($s_temp  == '2'){
	
	$txt .="<a class=\"btn-share\" onClick=\"JSShare('".link_face($s_module,$s_id,$s_params)."')\"  _href=\"".link_face($s_module,$s_id,$s_params)."\" target=\"_blank\" >".PHP_EOL;
	$txt .="<em class=\"fab fa-facebook-square size-icon-views fb-color\"></em>".PHP_EOL;
	$txt .="</a>".PHP_EOL;

	$txt .="<a class=\"btn-share\"  onClick=\"JSShare('".link_twitter($s_module,$s_id,$s_params)."')\" _href=\"".link_twitter($s_module,$s_id,$s_params)."\" target=\"_blank\" >".PHP_EOL;
	$txt .="<em class=\"fab fa-twitter-square size-icon-views tw-color\"></em>".PHP_EOL;
	$txt .="</a>".PHP_EOL;

	$txt .="<a class=\"btn-share\" onClick=\"JSShare('".link_line($s_module,$s_id,$s_params)."')\" _href=\"".link_line($s_module,$s_id,$s_params)."\" target=\"_blank\"  title=\"share line\">".PHP_EOL;
	$txt .="<em class=\"fab fa-line size-icon-views line-color\"></em>".PHP_EOL;
	$txt .="</a>".PHP_EOL;

	}
	return $txt;
}

function linkshare()
{
	
	$s_host = $_SERVER['HTTP_HOST'];	
	$s_name = $_SERVER['SCRIPT_NAME'];
	$s_url  = $_SERVER['REQUEST_URI'];	

	return "http://".$s_host.$s_url;
		
}

function share_buttons1($nid,$temp)
{

$txt = "";
$txt .="<a class=\"btn-share pr-1\" style=\"color: #B6B6B6 !important;\" href=\"http://www.facebook.com/sharer.php?u=".linkshare()."\" target=\"_blank\" >";
$txt .="<em class=\"fab fa-facebook-square fa-lg\"></em>&nbsp;".PHP_EOL;
$txt .="</a>".PHP_EOL;

$txt .="<a class=\"btn-share pr-1\"  style=\"color: #B6B6B6 !important;\" href=\"https://twitter.com/share?url=".linkshare()."&amp;text=&amp;hashtags=\" target=\"_blank\" >";
$txt .="<em class=\"fab fa-twitter-square fa-lg\"></em>&nbsp;".PHP_EOL;
$txt .="</a>".PHP_EOL;

$txt .="<a class=\"btn-share pr-1\"  style=\"color: #B6B6B6 !important;\" href=\"https://lineit.line.me/share/ui?url=".linkshare()."\" target=\"_blank\"  title=\"share line\">";
$txt .="<em class=\"fab fa-line fa-lg\"></em>".PHP_EOL;
$txt .="</a>".PHP_EOL;

/*$txt .= "<div id=\"share-buttons\">".PHP_EOL;
/*-- Line --/

//$txt .= "<div style=\"display:inline;top:10px;position:relative\" >\n";
//$txt .= "<div class=\"line-it-button\" data-lang=\"en\" data-type=\"share-c\" data-url=\"https://lineit.line.me/share/ui?url=".linkshare()."\" style=\"display: none;\" ></div></div>\n";
//$txt .= "<script src=\"https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js\" async=\"async\" defer=\"defer\"></script>\n";

$txt .= "<a href=\"https://lineit.line.me/share/ui?url=".linkshare()."\" targettarget=\"_blank\" onClick=\"return  share_buttons_count('".$nid."');\"  title=\"share line\">";
$txt .= "<img src=\"https://scdn.line-apps.com/n/line_regulation/files/ver2/LINE_Icon.png\" width=\"30\" height=\"30\">";
$txt .= "</a>".PHP_EOL;

/*-- Facebook --/
$txt .= "<a id=\"link\" href=\"http://www.facebook.com/sharer.php?u=".linkshare()."\" target=\"_blank\" onClick=\"return  share_buttons_count('".$nid."');\">";
$txt .= "<img src=\"https://simplesharebuttons.com/images/somacro/facebook.png\" alt=\"Facebook share\" width=\"30\"  />";
$txt .= "</a>".PHP_EOL;

/*-- Google+ --/
$txt .= "<a href=\"https://plus.google.com/share?url=".linkshare()."\" target=\"_blank\" onClick=\"return  share_buttons_count('".$nid."');\">";
$txt .= "<img src=\"https://simplesharebuttons.com/images/somacro/google.png\" alt=\"Google share\" width=\"30\" />";
$txt .= "</a>".PHP_EOL;

/*-- Twitter --/
$txt .= "<a href=\"https://twitter.com/share?url=".linkshare()."&amp;text=".gentitle()."&amp;hashtags=".gentitle()."\" target=\"_blank\" onClick=\"return  share_buttons_count('".$nid."');\" >";
$txt .= "<img src=\"https://simplesharebuttons.com/images/somacro/twitter.png\" alt=\"Twitter share\" width=\"30\" />";
$txt .= "</a>".PHP_EOL;

/*-- Print --/
$txt .= "<a href=\"javascript:;\" onclick=\"window.print()\">";
$txt .= "<img src=\"https://simplesharebuttons.com/images/somacro/print.png\" alt=\"Print\" width=\"30\" />";
$txt .= "</a>".PHP_EOL;
$txt .= "</div>".PHP_EOL;*/

	return $txt;

}



function get($s_name, $s_defalut=null)
{
  return ($_GET[$s_name])?$_GET[$s_name]:$s_defalut;
}

function sizeMB2byte($size)
{
	
	$bytesize = $size * (1024.0 * 1024);
 
	return $bytesize;
}

function getIP()
{
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
function EwtMaxfileSize($s_type){
	global $db;
	
	$s_sql = $db->query("SELECT * FROM site_info");
	$a_data = $db->db_fetch_array($s_sql);
	
	if($s_type=='file')
	{		
		$a_size =  $a_data['site_info_max_file'];		
	}else if($s_type=='img'){		
		$a_size = $a_data['site_info_max_img'];		
	}else if($s_type=='vdo'){
		$a_size = $a_data['site_info_max_vdo'];	
	}else{
		$a_size = '';
	}
	
	return $a_size;
	
}
function EwtMaxfile($s_type){
	global $db;
	if(SYS_LANG){
	include('language/lang_'.SYS_LANG.'.php');
	}
	$s_sql = $db->query("SELECT * FROM site_info");
	$a_data = $db->db_fetch_array($s_sql);
	
	if($s_type=='file')
	{		
		$a_size =  $a_data['site_info_max_file'];		
	}else if($s_type=='img'){		
		$a_size = $a_data['site_info_max_img'];		
	}else if($s_type=='vdo'){
		$a_size = $a_data['site_info_max_vdo'];	
	}else{
		$a_size = '';
	}
	
	return $text_size.' '. $a_size.' MB.';
	
}

function EwtTypefile($s_type){
	global $db;
	if(SYS_LANG){
	include('language/lang_'.SYS_LANG.'.php');
	}
	$s_sql = $db->query("SELECT * FROM site_info");
	$a_data = $db->db_fetch_array($s_sql);
	
	if($s_type=='file')
	{		
		$a_tyle = $a_data['site_type_file'];		
	}else if($s_type=='img'){		
		$a_tyle = $a_data['site_type_img_file'];		
	}else if($s_type=='vdo'){
		$a_tyle = $a_data['site_type_vdo_file'];	
	}else{
		$a_tyle = '';
	}
	
return $text_type.' ['. $a_tyle.']';
	
}

function ValidfileType($s_type)
{
  if($s_type)
  {
	  return str_replace(",","|",EwtTypefile($s_type));
  } 	
}

function showWord($s_text, $s_limit=0, $s_type=false)
{
  if($s_limit)
  {
    $i_lenstr = mb_strlen($s_text);
    if($s_limit > 0 && $i_lenstr > $s_limit)
    {
      $s_str = mb_substr(nl2br(showText($s_text, $s_type)), 0, $s_limit);
      return $s_str.'&hellip;';
    }
    else return nl2br(showText($s_text, $s_type));
  }
  else
  {
    if($s_type) return showText($s_text, $s_type);
    else return nl2br(showText($s_text, $s_type));
  }
}

function showText($s_text, $s_type=false)
{
  if($s_type) return $s_text;
  return htmlspecialchars($s_text, ENT_QUOTES);
}

function showNumber($s_data)
{
  if(is_numeric($s_data)) return number_format($s_data, 0, '.', ',');
  else return 0;
}

function showZero($s_text, $s_len=4)
{
  $s_count = mb_strlen($s_text);
  if($_i = $s_count <= $s_len)
  {
    $s_zero = str_repeat('0', ($s_len-$s_count));
  }
  return $s_zero.$s_text;
}

function showFloat($s_data, $s_decimal=2)
{
  if(is_numeric($s_data)) return number_format($s_data, $s_decimal, '.', ',');
  else return number_format(0, $s_decimal, '.', ',');
}

function getExtensionFile($s_fullname, $s_name)
{
  $idx = explode( '.', $s_fullname );
  $count_explode = count($idx);
  if($count_explode == 1)
  {
    $name = $s_name;
  }
  else
  {
    $idx = strtolower($idx[$count_explode-1]);
    $name = $s_name.'.'.$idx;
  }
  return $name;
}

function getExtension($s_fullname)
{
  $idx = explode( '.', $s_fullname );
  $count_explode = count($idx);
  if($count_explode == 1)
  {
    return '';
  }
  else
  {
    $idx = strtolower($idx[$count_explode-1]);
    return $idx;
  }
}

function count_users_online()
{
	global $db,$EWT_DB_NAME;
	$s_count =  $db->query("SELECT so_session_id FROM stat_online WHERE so_user_id = '0'  GROUP BY so_session_id ");
	$a_rec = $db->db_fetch_row($s_count);
	$a_row = $db->db_num_rows($s_count);
	
	return number_format($a_row,0);
}	

function count_users_today()
{
	global $db,$EWT_DB_NAME;
	$date = new DateTime();
	$s_count =  $db->query("SELECT count(sv_id) AS session 
	FROM stat_visitor 
	WHERE sv_visitor = 'Y' AND sv_session_id != '' AND (sv_date = '".$date->format('Y-m-d H:i:s')."') ");
	$a_rec = $db->db_fetch_row($s_count);
	//$a_row = $db->db_num_rows($s_count);
	
	return number_format($a_rec[0],0);
} 

function count_users_allwebsite()
{
	global $db,$EWT_DB_NAME;
	$s_count =  $db->query("SELECT count(sv_id) AS session 
	FROM stat_visitor 
	WHERE sv_visitor = 'Y' AND sv_session_id != '' ");
	$a_rec = $db->db_fetch_row($s_count);
	
	return number_format($a_rec[0],0);
	
} 

function log_view($s_module,$s_module_table,$s_id,$s_module_detail,$s_uid)
{
	global $db;
	  $date = new DateTime();
	  $_query = "INSERT INTO stat_view (
										sv_module,
										sv_module_table,
										sv_module_id,
										sv_module_detail,
										sv_uid,
										sv_ip,
										sv_createdate,
										sv_timestamp
										) 
										VALUES ('{$s_module}',
												'{$s_module_table}',
												'{$s_id}',
												'{$s_module_detail}',
												'{$s_uid}',
												'{".getIP()."}',
												'{$date->format('Y-m-d')}',
												'{$date->format('Y-m-d H:i:s')}'										
										)";
	
	if($db->query($_query)) { 
	$s_count =  $db->query("SELECT * 
							FROM stat_view_daily 
							WHERE svd_module = '{$s_module}' AND svd_module_table = '{$s_module_table}' AND svd_module_id = '{$s_id}' AND svd_module_detail = '{$s_module_detail}' AND svd_date = '{$date('Y-m-d')}' ");
	$a_rec = $db->db_fetch_row($s_count);
	$a_row = $db->db_num_rows($s_count);
	
	if($a_row > 0){
	$_query_daily = " UPDATE stat_view_daily (svd_num) VALUES ('{$a_row}') WHERE  svd_date = '".date('Y-m-d')."' ";
	$db->query($_query_daily);
	}else{
			$_query_daily = "INSERT INTO stat_view_daily (svd_date,svd_num) 
							 SELECT '".date('Y-m-d')."',COUNT(*) AS intYesterday 
							 FROM  stat_view WHERE 1 AND sv_createdate = '".date('Y-m-d')."' ";
			$db->query($_query_daily);
	}
	return true; 
	} else { 
		die("SQL Error: <br>".$sql."<br>".$db->error); 
		return false; 
		}
	
}		 
?>