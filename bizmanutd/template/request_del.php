<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
	//=========================================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($flag){ $flag=checkPttVar($flag);}
	if($_GET["flag"]){ $_GET["flag"]=checkPttVar($_GET["flag"]); }
	if($_POST["flag"]){ $_POST["flag"]=checkPttVar($_POST["flag"]); }
	if($_REQUEST['flag']){ $_REQUEST['flag']=checkPttVar($_REQUEST['flag']); }
	
	if($t){ $t=checkNumeric($t); }
	if($_GET[t]){ $_GET[t]=checkNumeric($_GET[t]); }
	if($_POST[t]){ $_POST[t]=checkNumeric($_POST[t]); }
	if($_REQUEST[t]){ $_REQUEST[t]=checkNumeric($_REQUEST[t]); }
	
	if($wtid){ $wtid = checkNumeric($wtid); }
	if($_GET["wtid"]){ $_GET["wtid"] = checkNumeric($_GET["wtid"]); }
	if($_POST["wtid"]){ $_POST["wtid"] = checkNumeric($_POST["wtid"]);}
	
	if($wcad){ $wcad = checkNumeric($wcad); }
	if($_GET["wcad"]){ $_GET["wcad"] = checkNumeric($_GET["wcad"]); }
	if($_POST["wcad"]){ $_POST["wcad"] = checkNumeric($_POST["wcad"]); }
	//=========================================================================
//include("webboard_log.php");
//include("language/language.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");


$flag=$_REQUEST['flag'];
if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
			$lang_sh1 = explode('___',$F[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			//echo $lang_sh ;
			include("language/language".$lang_sh.".php");
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$F = $db->db_fetch_array($sql_temp);
$design_id = $F["d_id"];

$global_theme = $F["d_bottom_content"];
$mainwidth = "0";

$target = '_self';
$color_websearch = array("#FFFF00","#00FFFF","#6666FF","#FF9999","#CC6633","#999999","#339900");
function CheckTag($temp){
		global $url;
		$temp = stripslashes(htmlspecialchars($temp));
		$temp = eregi_replace ( chr(13), "<br>" , $temp ) ;
		$temp = eregi_replace ( "\[b\]", "<b>" , $temp ) ;
		$temp = eregi_replace ( "\[/b\]", "</b>" , $temp ) ;
		$temp = eregi_replace ( "\[br\]", "<br>" , $temp ) ;
		$temp = eregi_replace ( "\[i\]", "<i>" , $temp ) ;
		$temp = eregi_replace ( "\[/i\]", "</i>" , $temp ) ;
		$temp = eregi_replace ( "\[u\]", "<u>" , $temp ) ;
		$temp = eregi_replace ( "\[/u\]", "</u>" , $temp ) ;
		$temp = eregi_replace ( "\[hr\]", "<hr>" , $temp ) ;
		$temp = eregi_replace ( "\[\-\-\-\]", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" , $temp ) ;
		$temp = eregi_replace ( "\[color=red\]", "<font color=red>" , $temp ) ;
		$temp = eregi_replace ( "\[color=green\]", "<font color=green>" , $temp ) ;
		$temp = eregi_replace ( "\[color=blue\]", "<font color=blue>" , $temp ) ;
		$temp = eregi_replace ( "\[color=orange\]", "<font color=FF6600>" , $temp ) ;
		$temp = eregi_replace ( "\[color=pink\]", "<font color=FF00FF>" , $temp ) ;
		$temp = eregi_replace ( "\[color=gray\]", "<font color=999999>" , $temp ) ;
		$temp = eregi_replace ( "\[/color\]", "</font>" , $temp ) ;
		$temp = eregi_replace ("\[img\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]])\[/img\]", "<img src=\"\\1://\\2\\3\">",$temp ) ;
		$temp = eregi_replace ("\[img1\]([[:alnum:]])\[/img1\]", "<a href=\"userpic/\\1\" target=\"_blank\"><img src=\"userpic/\\1\"  width=\"100\" height=\"100\">\\1</a>",$temp ) ;
		$temp = eregi_replace ("\[url\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])\[/url\]","<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>",$temp ) ;
	//	$temp = eregi_replace ("([^[:space:]]*)@([^[:space:]]*)([[:alnum:]])","<a href=\"./mail2me/mail2me.php?wemail=\\1@\\2\\3&name=\\1@\\2\\3\" target=\"_blank\">\\1@\\2\\3</a>",$temp ) ;
		return ( $temp ) ;
	}
	
	function CheckSmile($temp){
		global $url;
		$text = array(
		":sad:",":red:", ":big:", ":ent:", ":shy:", ":sleepy:", ":sun:", ":sg:", ":embarass:", 
		":dead:", ":cool:", ":clown:", ":pukey:", ":eek:", ":roll:", ":smoke:", ":angry:", ":confused:", ":cry:", 
		":lol:", ":yawn:", ":devil:", ":tongue:", ":alien:",":tasty:",":crazy:",":agree:",":disagree:",":bawling:", 
		":crap:",":crying1:",":dunce:",":error:",":evil:",":lookaroundb:",":laugh:",":pimp:",":spiny:",":wavey:",":smash:",":angry:",
		":brain:",":phone:",":zip:",":download:",":beer:",":censore:",":nolove:",":cranium:");

		$pic =array(
		"frown.gif","redface.gif","biggrin.gif","blue.gif","shy.gif","sleepy.gif","sunglasses.gif", "supergrin.gif","embarass.gif",
		"dead.gif","cool.gif","clown.gif","pukey.gif","eek.gif","sarcblink.gif","smokin.gif","reallymad.gif","confused.gif","crying.gif",
		"lol.gif","yawn.gif","devil.gif","tongue.gif","aysmile.gif","tasty.gif","grazy.gif","agree.gif","disagree.gif","bawling.gif",
		"crap.gif","crying1.gif","dunce.gif","error.gif","evil.gif","lookaroundb.gif","laugh.gif","pimp.gif","spiny.gif","wavey.gif","smash.gif","angry.gif",
		"brain.gif","phone.gif","zip.gif","download.gif","beer.gif","censore.gif","nolove.gif","cranium.gif");

		for ($i=0 ; $i<sizeof($text) ; $i++) {
			$temp = eregi_replace($text[$i],"<img src=\"pic/$pic[$i]\">",$temp);
		}
		return($temp);
	}
$db->query("UPDATE w_question SET t_count = t_count + 1 WHERE t_id = '$wtid'");
if($TTYPE !='Y'){
$wh= "AND s_id = '1'";
}

$Execsql = $db->query("SELECT * FROM w_question WHERE t_id = '$wtid' $wh ");
$R = mysql_fetch_array($Execsql);
function CheckVulgar($msg){
$BanWord="***";
$Sql="SELECT * FROM vulgar_table";
$ExecSql=  mysql_query($Sql);
$total=mysql_num_rows($ExecSql);
if($total>0){
while($R=mysql_fetch_array($ExecSql)){
$Vtext=$R['vulgar_text'];
$msg=eregi_replace($Vtext,$BanWord,$msg);
}
}
return $msg;
}

	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title><?php if($MyTitle==""){?>===== Welcome =====<?php }else{ echo $MyTitle; }?></title>
<?php
include("ewt_script.php");	
?>

<script language="JavaScript">
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
}
function valid2EMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			//return false;
			if (mailObj.value.search("^.+@.+\\..+$") != -1)
				return true;
			else return false;
 		}
		return true;
}
function validEMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			//return false;
			if (mailObj.value.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
				return true;
			else return false;
 		}
		return true;
}
function CHK(){
if(document.myForm.amsg.value == ""){
alert('<?php echo $text_genwebboard_detail1;?>');
document.myForm.amsg.focus();
return false;
}
if(document.myForm.aname.value == ""){
alert('<?php echo $text_genwebboard_name1;?>');
document.myForm.aname.focus();
return false;
}
if(document.myForm.aemail.value == ""){
alert('<?php echo $text_genwebboard_alertmail;?>');
document.myForm.aemail.focus();
return false;
}
if(document.myForm.aemail.value != "" && !validEMail(document.myForm.aemail)){
alert('<?php echo $text_genwebboard_alertmail;?>');
document.myForm.aemail.focus();
return false;
}
}
</script>
<script language="JavaScript">
function setURL()
{
	var temp = window.prompt('<?php echo $text_genwebboard_alertlinkurl;?>','http://'); 
	if(temp) 
	setsmile('[url]'+temp+'[/url]');
}

function setImage()
{
	var i =0;
	var temp_c = 0;
	var temp = window.prompt('<?php echo $text_genwebboard_alertimgurl;?>','http://'); 
	if(temp) 
	if(document.myForm.num_img.value > 0 ){
	temp_c = temp.length;
	var tempC = temp_c-3;
	temp_cc = temp.substring(tempC,temp_c);
		for(i=0;i<document.myForm.num_img.value;i++){
			if(temp_cc == document.getElementById('img['+i+']').value){
				var chack = 1;
				break;
			}else{
			var chack = 0;
			}
		}
		if(chack == 1){
		setsmile('[img]'+temp+'[/img]');
		}else{
		alert('<?php echo $text_genwebboard_alertimgtype;?>');
		setsmile('');
		}
	}else{
	setsmile('[img]'+temp+'[/img]');
	}
}

function setBold()
{
	var temp = window.prompt('<?php echo $text_genwebboard_alertb;?>',''); 
	if(temp) setsmile('[b]'+temp+'[/b]');
}

function setItalic()
{
	var temp = window.prompt('<?php echo $text_genwebboard_alerti;?>',''); 
	if(temp) setsmile('[i]'+temp+'[/i]');
}

function setUnderline()
{
	var temp = window.prompt('<?php echo $text_genwebboard_alertu;?>',''); 
	if(temp) setsmile('[u]'+temp+'[/u]');
}

function setColor(color,name)
{
	var temp = window.prompt('<?php echo $text_genwebboard_alertcolor;?>'+name,''); 
	if(temp) setsmile('[color='+color+']'+temp+'[/color]');
}

function setsmile(what)
{
	document.myForm.amsg.value = document.myForm.elements.amsg.value+" "+what;
	document.myForm.amsg.focus();
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		 // echo "SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC";
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>">
	<?php
			$mainwidth = $F["d_site_content"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
	<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
<tr>
    <td height="25">&nbsp;</td>
  </tr>
  <?php
  $Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
if($QQ["c_rss"]=='Y'){
			 $filename01="rss/webboard".$QQ["c_id"].".xml";
			 if(file_exists($filename01)){
			     $link='<a href="rss/webboard'.$QQ["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0" align="absmiddle"> </a>';
			 }else{
			     $link='';
			 }
		}else{ $link='';
		}
$sql = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$X = mysql_fetch_array($sql);
			if($_GET[t] != '' && $_GET[t] != '0'){
				$_GET[t] = $_GET[t];
			}else{
				$_GET[t] = $global_theme;
			}
if($_GET[t]){
	   $namefolder = "themes".($_GET[t]);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		$bg_width  ='100%';
		// if($themes_type == 'F'){
			$buffer = "";
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
			$fd = @fopen ($Current_Dir1.$themes_file, "r");
			 while (!@feof ($fd)) {
				$buffer .= @fgets($fd, 4096);
			 }
			@fclose ($fd);
			$design = explode('<?php#htmlshow#?>',$buffer);
		 }
		}else{
			$bg_img='';
			$bg_color='#646464';
			$bg_width='100%';
			$head_img='';
			$head_color='#DADADA';
			$head_font_face='';
			$head_font_face2='';
			$head_font_size='';
			$head_font_size2='';
			$head_font_color='#000000';
			$head_font_color2='#000000';
			$head_height='30';
			$body_bg_img='';
			$body_color='#FFFFFF';
			$body_font_face='';
			$body_font_face2='';
			$body_font_face3='';
			$body_font_size='12px';
			$body_font_size2='11px';
			$body_font_size3='9px';
			$body_font_color='#000000';
			$body_font_color2='#000000';
			$body_font_color3='#CC0000';
			$bottom_img='';
			$bottom_color='';
			$bottom_height='0';
			$Current_Dir1 = "";
}
	if($lang_sh != ''){//chang lang
   $QQ[c_name] = select_lang_detail($wcad,$lang_shw,"c_name",w_cate);
   }
?>
  <tr>
    <td height="25"><?php if($target=='_self'){?>&nbsp;&nbsp;<strong ><a href="m_webboard.php?t=<?php echo $_GET[t];?>&filename=<?php echo $_GET[filename];?>"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genwebboard_pagemain;?></span></font></span></a><img src="mainpic/arrow_r.gif" width="7" height="7" align="absmiddle"> <a href="index_question.php?wcad=<?php echo $wcad; ?>&t=<?php echo $_GET[t];?>&filename=<?php echo $_GET[filename];?>"><span class="text_normal"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $QQ[c_name]; ?></span></font></span></a>&nbsp;&nbsp;&nbsp;<?php echo $link;?></strong><?php }?></td>
  </tr>
  <tr>
    <td height="25"><?php echo $design[0];?><?php echo $design[1];?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">
	<?php
	if(($QQ[c_view] == "2" || $QQ[c_view] == "3" ) AND $_SESSION["EWT_MID"] == ""){
 
		?>
		<script language="JavaScript">
		alert("<?php echo $text_genwebboard_alertlogin;?>");
		top.location.href="ewt_login.php?fn=index_question.php?wcad=<?php echo $wcad; ?>&t=<?php echo $_GET[t];?>";
		</script>
		<?php
		exit;
	}
	if(($QQ[c_view] == "3"   AND $_SESSION["EWT_MID"] != "" AND ($_SESSION["EWT_TYPE_ID"]  != 1)) and $TTYPE != 'Y'){
		?>
		<script language="JavaScript">
		alert("<?php echo $text_genwebboard_alertnotview.$TTYPE ;?>vvv");
		window.location.href = "m_webboard.php?t=<?php echo $_GET[t];?>";
		</script>
		<?php
	}
	if(($QQ[c_answer] == "2" || $QQ[c_answer] == "3" ) AND $_SESSION["EWT_MID"] == ""){
		
	}else if(($QQ[c_answer] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1)  and $TTYPE != 'Y'){
	
	}else {
	?>
	<?php echo $design[0];?>
	  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="<?php echo $bg_color;?>"  background="<?php echo $Current_Dir1.$bg_img;?>" class="normal_font">
        <form name="myForm" enctype="multipart/form-data" method="post" action="question_function.php" onSubmit="return CHK()" target="">
          <tr align="center">
            <td bgcolor="#CCCCCC"class="head_font"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><strong><?php if($flag=='reqRemoveTopic') { echo 'แจ้งลบกระทู้'; } else { echo 'แจ้งลบความคิดเห็น'; } ?></strong>&nbsp;<?php echo $text_genwebboard_addcomment2;?> </span></font></span></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td><table width=100% border=0 cellpadding=2 cellspacing=1 align="center">
                <tr >
                  <td><table border=0 width=100% cellpadding="2" cellspacing="0">
<?php
	$qDetail=$db->query('SELECT t_name, t_detail FROM w_question WHERE t_id=\''.$_REQUEST['wtid'].'\' AND c_id=\''.$_REQUEST['wcad'].'\'');
	$rDetail=$db->db_fetch_array($qDetail);
?>
                      <tr>
                        <td width="30%" align=right valign=top><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">หัวข้อ</span></font></span></td>
                        <td valign="top"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $rDetail['t_name']; ?></span></font></span></td>
                      </tr>
                      <tr>
                        <td width="30%" align=right valign=top><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">เนื้อหา</span></font></span></td>
                        <td valign="top"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $rDetail['t_detail']; ?></span></font></span></td>
                      </tr>
<?php
		$db->query("USE ".$EWT_DB_USER);
		$sql_img = "select * from gen_user where gen_user_id = '".$_SESSION["EWT_MID"]."'";
		$query = $db->query($sql_img);
		$rec_img = $db->db_fetch_array($query);
		$img_port = "../pic_upload_webboard/".$rec_img[webb_pic];
		$db->query("USE ".$EWT_DB_NAME);
		
		
		 if(empty($rec_img[webb_name])){ 
		 $name_a= stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]);
		 }else{ 
		 $name_a= stripslashes($rec_img[webb_name]); 
		 }
		 if(!empty($rec_img[email_person])){ 
		 $mail= $rec_img[email_person];
		 $read = 'readonly';
		 }else{ 
		 $mail= '';
		  $read = '';
		 }
?>
                      <tr>
                        <td align=right><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genwebboard_by;?></span></font></span><span class="style1">*</span></td>
                        <td><input name="aname" type=text class=orenge value="<?php echo trim($name_a);?>"  size=60 maxlength=50 <?php if($_SESSION["EWT_MID"] != ""){ echo 'readonly';}?>>
                        </td>
                      </tr>
                      <tr>
                        <td width="30%" align=right valign=top><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">เหตุผล</span></font></span><span class="style1">*</span></td>
                        <td><textarea  name="amsg" cols=60 rows=10 class=orenge></textarea>
                        </td>
                      </tr>

                      <tr>
                        <td align=right><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genwebboard_email;?></span></font></span><span class="style1">*</span></td>
                        <td><input  size=60 type=text name="aemail" maxlength=50 class=orenge value="<?php echo $mail;?>" <?php echo $read;?>>
                            <input name="board_id" type="hidden" id="board_id" value="<?php echo $board_id; ?>">
                            <input type="hidden" name="fign" value="<?php echo $rec_img[fign];?>">
							<input type="hidden" name="filename" value="<?php echo $_GET[filename];?>">
                        </td>
                      </tr>
                  </table></td>
                </tr>
                <tr  valign="bottom">
                  <td align=center ><a href="javascript:setURL()"><img src="pic/link.gif" alt="<?php echo $text_genwebboard_linkurl;?>" width="18" height="17" border=0></a> <a href="javascript:setImage()"><img src="pic/tree.gif" border=0 alt="<?php echo $text_genwebboard_imgurl;?>"></a> <a href="javascript:setsmile('[---]')"><img src="pic/indent.gif" border=0 alt="<?php echo $text_genwebboard_indent;?>"></a> <a href="javascript:setBold()"><img src="pic/b.gif" border=0 alt="<?php echo $text_genwebboard_b;?>"></a> <a href="javascript:setItalic()"><img src="pic/i.gif" border=0 alt="<?php echo $text_genwebboard_i;?>"></a> <a href="javascript:setUnderline()"><img src="pic/u.gif" border=0 alt="<?php echo $text_genwebboard_u;?>"></a> <a href="javascript:setColor('red','<?php echo $text_genwebboard_redcolor;?>')"><img src="pic/redcolor.gif" border=0 alt="<?php echo $text_genwebboard_redcolor;?>"></a> <a href="javascript:setColor('green','<?php echo $text_genwebboard_greencolor;?>')"><img src="pic/greencolor.gif" border=0 alt="<?php echo $text_genwebboard_greencolor;?>"></a> <a href="javascript:setColor('blue','<?php echo $text_genwebboard_bluecolor;?>')"><img src="pic/bluecolor.gif" border=0 alt="<?php echo $text_genwebboard_bluecolor;?>"></a> <a href="javascript:setColor('orange','<?php echo $text_genwebboard_orangecolor;?>')"><img src="pic/orangecolor.gif" border=0 alt="<?php echo $text_genwebboard_orangecolor;?>"></a> <a href="javascript:setColor('pink','<?php echo $text_genwebboard_pinkcolor;?>')"><img src="pic/pinkcolor.gif" border=0 alt="<?php echo $text_genwebboard_pinkcolor;?>"></a> <a href="javascript:setColor('gray','<?php echo $text_genwebboard_graycolor;?>')"><img src="pic/graycolor.gif" border=0 alt="<?php echo $text_genwebboard_graycolor;?>"></a>&nbsp;&nbsp;&nbsp;
                      <!--<input type="button" name="Button" value="แสดง icon" onClick="document.getElementById('icon').style.display='';">
          &nbsp;
          <input type="button" name="Button" value="ปิด icon" onClick="document.getElementById('icon').style.display='none';">style="display:none"--></td>
                </tr>
                <tr  id="icon" >
                  <td align=center><?php
						$i=1;
						$sql_emotion = "select * from emotion";
						$query_emotion = $db->query($sql_emotion);
						while($rec_emotion = $db->db_fetch_array($query_emotion)){
						echo "&nbsp;<a href=\"javascript:setsmile('".$rec_emotion[emotion_character]."')\"><img src=\"".$rec_emotion[emotion_img]."\" border=0 ></a>&nbsp;&nbsp;&nbsp;";
						if($i=='10'){
						echo "<br>";
						$i=0;
						}
						$i++;
						}
						?><br>
                     <span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>"><span style="font-size:<?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genwebboard_text;?></span></font></span></td>
                </tr>
            </table></td>
          </tr>
          <?php if($X[c_pic] == "Y"){  ?>
          <?php } ?>
          <tr bgcolor="#FFFFFF">
            <td align="center" height="<?php echo $bottom_height ;?>" background="<?php echo $Current_Dir1.$bottom_img;?>"   bgcolor="<?php echo $bottom_color;?>"><input type="submit" name="Submit" value="<?php echo $text_general_submit;?>" class="normaltxt">
                <input type="reset" name="Submit2" value="<?php echo $text_general_reset;?>" class="normaltxt">
                <input name="flag" type="hidden" id="flag" value="<?php echo $_REQUEST['flag']; ?>">
                <input name="wcad" type="hidden" id="wcad" value="<?php echo $_REQUEST['wcad']; ?>">
				<input name="wtid" type="hidden" id="wtid" value="<?php echo $_REQUEST['wtid']; ?>">
                <input name="waid" type="hidden" id="waid" value="<?php echo $_REQUEST['waid']; ?>">
                <input name="t" type="hidden" id="t" value="<?php echo $_REQUEST['t']; ?>">
				<input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST['filename']; ?>">
          </tr>
        </form>
      </table><?php echo $design[1];?>
		<?php } ?>
	</td>
  </tr>
  <tr>
    <td height="10">&nbsp;</td>
  </tr>
</table>
 <iframe name="save_function_form1" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
	</td>
          <td id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth = $F["d_site_right"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		 
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>