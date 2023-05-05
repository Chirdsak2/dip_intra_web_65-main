<?php

/*
$UserPath = "\\\\202.122.40.25\\ictweb\\";
$Website = "http://202.122.40.25/ewtadmin/ewt/parliament_parcy/";  // ictweb
$CS_WWW = "http://202.122.40.25"; // อันเก่าคือ "www.mwa.co.th";
*/ 
//include("../../lib/user_config.php");
//$folder_ewt = "ewtadmin";
//$folder = 'ewt_w3c'; //สามารถเปลี่ยนชื่อ folder ที่เก็บดปรแกรมได้
//$UserPath =  "D:\\www\\".$folder_ewt."\\ewt\\".$EWT_FOLDER_USER."\\"; // 
//$Website = "http://".$_SERVER['SERVER_NAME']."/".$folder_ewt."/ewt/".$EWT_FOLDER_USER."/"; // "http://localhost/ewtadmin/ewt/parliament_parcy/";  
$Website = "http://".$_SERVER['SERVER_NAME']."/".dirname($_SERVER['PHP_SELF']);
//$CS_WWW = "http://".$_SERVER['SERVER_NAME']."/".$folder_ewt."/ewt/".$EWT_FOLDER_USER."/"; // อันเก่าคือ "http://localhost/ewtadmin/ewt/parliament_parcy/"
$phpMainPage=$Website."main.php?filename=";
$phpMainBody=$Website."main_body.php?filename=";
$phpMainTemplate=$Website."/ewt_preview_template.php?filename=";
$phpMainTemplate2=$Website."/ewt_preview_templates.php?filename=";
$dir1="checked/";  // w3c\\checked\\
$dir2="template/";
$dir3="mainbkup/";
$SPLITTER = '<?#w3c_spliter#?>';//'<input name="w3c_spliter" type="hidden" value="##" alt="">';

/*database*/
$DB["dbName"] = "w3c_ictweb";
$DB["dbms"] = "mysql";
$DB["host"]   = "localhost"; //"192.168.0.250"; // localhost
$DB["user"]   = "root";
$DB["pass"]   = ""; 

$DB["sqlclass"]  = "class_mysql.php";

$SELF = $HTTP_SERVER_VARS['PHP_SELF'];
if(empty($SID))
      $SID = Session_ID(); // Create session id referent (Require session_start() and PHP4 up)

$$SELF = $HTTP_SERVER_VARS['PHP_SELF'];
if(empty($SID))
      $SID = Session_ID(); // Create session id referent (Require session_start() and PHP4 up)

//$TODAY = date('m/d/Y H:i:s');
$TODAY = date('d-m-').(date('Y')+543);
$TIMESTAMP = date('YmdHis');

//$proj_title=$titlePage="โครงการสายใยรักแห่งครอบครัวในพระเจ้าวรวงศ์เธอ พระองค์เจ้าศรีรัศมิ์ พระวรชายาฯ";
$proj_title=$titlePage="ระบบพัฒนาหน้าเว็บมาตรฐาน W3C";
$admin_email="support@bizpotential.com";
$HTTPROOT = "http://biz1/dsdw_love/home/index.php";
$folder_root = "/love/";

$sign_local = "\\";

$widthL=0;
$widthC=800;
$widthR=200;
$bgL="#F8F8F8";
$bgC="#F8F8F8";
$bgR="#F8F8F8";

$short_bdgyear = substr($year_bdg,2);

global $th2unimap,$th2unimap2,$th2unimap3,$th2unimap4,$th2unimap5,$th2unimap6;

	$th2unimap = array( 
	'ก' => "&#3585;", 'ข' => "&#3586;", 'ฃ' => "&#3587;", 'ค' => "&#3588;", 'ฅ' => "&#3589;", 'ฆ' => "&#3590;", 'ง' => "&#3591;",
	'จ' => "&#3592;", 'ฉ' => "&#3593;", 'ช' => "&#3594;", 'ซ' => "&#3595;", 'ฌ' => "&#3596;", 'ญ' => "&#3597;", 'ฎ' => "&#3598;",
	'ฏ' => "&#3599;", 'ฐ' => "&#3600;", 'ฑ' => "&#3601;", 'ฒ' => "&#3602;", 'ณ' => "&#3603;", 'ด' => "&#3604;", 'ต' => "&#3605;",
	'ถ' => "&#3606;", 'ท' => "&#3607;", 'ธ' => "&#3608;", 'น' => "&#3609;", 'บ' => "&#3610;", 'ป' => "&#3611;", 'ผ' => "&#3612;",
	'ฝ' => "&#3613;", 'พ' => "&#3614;", 'ฟ' => "&#3615;", 'ภ' => "&#3616;", 'ม' => "&#3617;", 'ย' => "&#3618;", 'ร' => "&#3619;",
	'ฤ' => "&#3620;", 'ล' => "&#3621;", 'ฦ' => "&#3622;", 'ว' => "&#3623;", 'ศ' => "&#3624;", 'ษ' => "&#3625;", 'ส' => "&#3626;",
	'ห' => "&#3627;", 'ฬ' => "&#3628;", 'อ' => "&#3629;", 'ฮ' => "&#3630;", 'ฯ' => "&#3631;", 'ะ' => "&#3632;", 'ั' => "&#3633;",
	'า' => "&#3634;", 'ำ' => "&#3635;", 'ิ' => "&#3636;", 'ี' => "&#3637;", 'ึ' => "&#3638;", 'ื' => "&#3639;", 'ุ' => "&#3640;",
	'ู' => "&#3641;", 'ฺ' => "&#3642;", '฿' => "&#3647;", 'เ' => "&#3648;", 'แ' => "&#3649;", 'โ' => "&#3650;", 'ใ' => "&#3651;",
	'ไ' => "&#3652;", 'ๅ' => "&#3653;", 'ๆ' => "&#3654;", '็' => "&#3655;", '่' => "&#3656;", '้' => "&#3657;", '๊' => "&#3658;",
	'๋' => "&#3659;", '์' => "&#3660;", 'ํ' => "&#3661;", '๎' => "&#3662;", '๏' => "&#3663;", '๐' => "&#3664;", '๑' => "&#3665;",
	'๒' => "&#3666;", '๓' => "&#3667;", '๔' => "&#3668;", '๕' => "&#3669;", '๖' => "&#3670;", '๗' => "&#3671;", '๘' => "&#3672;",
	'๙' => "&#3673;", '๚' => "&#3674;", '๛' => "&#3675;");
	
	$th2unimap2 = array( // สำหรับไม่มีสระอยู่ข้างหน้า
	'่' => "&#63242;", 
	'้' => "&#63243;", 
	'๊' => "&#63244;",
	'๋' => "&#63245;", 
	'์' => "&#63246;"
	);
	
	$th2unimap3 = array( // สำหรับมี อักษรมีหางอยู่ข้างหน้า
	'ิ' => "&#63233;",
	'ี' => "&#63234;", 
	'ึ' => "&#63235;", 
	'ื' => "&#63236;",
	'่' => "&#63237;", 
	'้' => "&#63238;", 
	'๊' => "&#63239;",
	'๋' => "&#63240;", 
	'์' => "&#63241;",
	'ั' => "&#63248;",
	'ํ' => "&#63249;",
	'็' => "&#63250;"
	);
	
	$th2unimap4 = array( // สำหรับมี 2 อักษรมีหางอยู่ข้างหน้า และ 1 ตัวอักษรข้างหน้าเป็นสระบน
	'่' => "&#63251;", 
	'้' => "&#63252;", 
	'๊' => "&#63253;",
	'๋' => "&#63254;", 
	'์' => "&#63255;"
	);
	
	$th2unimap5 = array( // สำหรับ ญ ฐ ร่วมกับ สระอุ อู และ อฺ
	'ญ' => "&#63247;", 
	'ฐ' => "&#63232;", 
	);
	
	$th2unimap6 = array( // สำหรับ อักษรภาษาอังกฤษและอักขระพิเศษ
	' ' => "&#32;", '!' => "&#33;", '"' => "&#34;", '#' => "&#35;", '$' => "&#36;", '%' => "&#37;", '&' => "&#38;", "'" => "&#39;", '(' => "&#40;", ')' => "&#41;", 
	'*' => "&#42;", '+' => "&#43;", ',' => "&#44;", '-' => "&#45;", '.' => "&#46;", '/' => "&#47;", '0' => "&#48;", '1' => "&#49;", '2' => "&#50;", '3' => "&#51;", 
	'4' => "&#52;", '5' => "&#53;", '6' => "&#54;", '7' => "&#55;", '8' => "&#56;", '9' => "&#57;", ':' => "&#58;", ';' => "&#59;", '<' => "&#60;", '=' => "&#61;", 
	'>' => "&#62;", '?' => "&#63;", '@' => "&#64;", 'A' => "&#65;", 'B' => "&#66;", 'C' => "&#67;", 'D' => "&#68;", 'E' => "&#69;", 'F' => "&#70;", 'G' => "&#71;", 
	'H' => "&#72;", 'I' => "&#73;", 'J' => "&#74;", 'K' => "&#75;", 'L' => "&#76;", 'M' => "&#77;", 'N' => "&#78;", 'O' => "&#79;", 'P' => "&#80;", 'Q' => "&#81;", 
	'R' => "&#82;", 'S' => "&#83;", 'T' => "&#84;", 'U' => "&#85;", 'V' => "&#86;", 'W' => "&#87;", 'X' => "&#88;", 'Y' => "&#89;", 'Z' => "&#90;", '[' => "&#91;", 
	']' => "&#93;", '^' => "&#94;", '_' => "&#95;", '`' => "&#96;", 'a' => "&#97;", 'b' => "&#98;", 'c' => "&#99;", 'd' => "&#100;", 'e' => "&#101;", 'f' => "&#102;", 
	'g' => "&#103;", 'h' => "&#104;", 'i' => "&#105;", 'j' => "&#106;", 'k' => "&#107;", 'l' => "&#108;", 'm' => "&#109;", 'n' => "&#110;", 'o' => "&#111;", 'p' => "&#112;", 
	'q' => "&#113;", 'r' => "&#114;", 's' => "&#115;", 't' => "&#116;", 'u' => "&#117;", 'v' => "&#118;", 'w' => "&#119;", 'x' => "&#120;", 'y' => "&#121;", 'z' => "&#122;", 
	'{' => "&#123;", '|' => "&#124;", '}' => "&#125;"); // '\' => "&#92;"


	function uEntities_Callback($m) {
	   $d = hexdec($m[1] . $m[2] . $m[3] . $m[4]);
	   if ($d >= 3585 && $d <= 3675)
		   return chr($d - 3424);
	   return '&#' . $d;
	}
	
	function uEntities($x) {
	   return preg_replace_callback('~%u([0-9a-f])([0-9a-f])([0-9a-f])([0-9a-f])~i', 'uEntities_Callback', $x);
	}
	
	function convert_post($array_post) {
		$array_return = array();
		
		for($i=0; $i<count($array_post); $i++) {
			if(is_array(current($array_post))) {
				$key_index = key($array_post);
				for($j=0; $j<count($array_post[$key_index]); $j++) {
					$key_index2 = key($array_post[$key_index]);
					$array_return[$key_index][$key_index2] = uEntities(str_replace("<br>", "\n", trim(current($array_post[$key_index]))));
					next($array_post[$key_index]);
				}
			} else {
				$array_return[key($array_post)] = uEntities(str_replace("<br>", "\n", trim(current($array_post))));
			}
			next($array_post);
		}
		
		return $array_return;
	}
	// ใส่ <TITLE> ไม่ได้  เพราะต้องดึงจาก EWT 
	$dtd_html_head_charset_top = "
	<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
	<HTML lang=\"th\">
	<HEAD>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">		
	";

	/* <SCRIPT type=\"text/JavaScript\">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf('#')!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf('?'))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</SCRIPT> */

	$dtd_html_head_charset_bottom ="</head>"; 
	// <body> ไป กำหนดทีหลัง พร้อม attribute	 ที่ user ต้องการ
	
	
	$END_PAGE = "</HTML>";

?>
