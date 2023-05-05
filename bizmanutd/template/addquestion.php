<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//=======================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($t){
		$t  = checkNumeric($t);
	}
	if($_GET["t"]){
		$_GET["t"] = checkNumeric($_GET["t"]);
	}
	if($_POST["t"]){
		$_POST["t"] = checkNumeric($_POST["t"]);
	}
	
	if($wcad){
		$wcad  = checkNumeric($wcad);
	}
	if($_GET["wcad"]){
		$_GET["wcad"] = checkNumeric($_GET["wcad"]);
	}
	if($_POST["wcad"]){
		$_POST["wcad"] = checkNumeric($_POST["wcad"]);
	}
	//=======================================================
	
include("webboard_log.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
$lang_sh = explode('___',$F[filename]);
			if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
			include("language/language".$lang_sh.".php");
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$F = $db->db_fetch_array($sql_temp);
$design_id = $F["d_id"];

			$global_theme = $F["d_bottom_content"];
			$mainwidth = "0";
			
function CheckTag($temp){
		global $url;
		$temp = $temp;
		$temp = eregi_replace ( " <br> " ,chr(13), $temp ) ;
		$temp = eregi_replace ( "<b>" , "\[b\]", $temp ) ;
		$temp = eregi_replace (  "</b>" ,"\[/b\]", $temp ) ;
		$temp = eregi_replace (  "<i>" ,"\[i\]", $temp ) ;
		$temp = eregi_replace ( "</i>" ,"\[/i\]",  $temp ) ;
		$temp = eregi_replace (  "<u>" ,"\[u\]", $temp ) ;
		$temp = eregi_replace (  "</u>" ,"\[/u\]", $temp ) ;
		$temp = eregi_replace (  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ,"\[\-\-\-\]", $temp ) ;
		$temp = eregi_replace (  "<font color=red>" ,"\[color=red\]", $temp ) ;
		$temp = eregi_replace (  "<font color=green>" ,"\[color=green\]", $temp ) ;
		$temp = eregi_replace (  "<font color=blue>" ,"\[color=blue\]", $temp ) ;
		$temp = eregi_replace ( "<font color=FF6600>" ,"\[color=orange\]",  $temp ) ;
		$temp = eregi_replace (  "<font color=FF00FF>" ,"\[color=pink\]", $temp ) ;
		$temp = eregi_replace (  "<font color=999999>" ,"\[color=gray\]", $temp ) ;
		$temp = eregi_replace (  "</font>" , "\[/color\]",$temp ) ;
		$temp = eregi_replace ("<img src=\"\\1://\\2\\3\">","\[img\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]])\[/img\]", $temp ) ;
		$temp = eregi_replace ("<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>","\[url\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])\[/url\]",$temp ) ;
		$temp = eregi_replace ("<a href=\"./mail2me/mail2me.php?wemail=\\1@\\2\\3&name=\\1@\\2\\3\" target=\"_blank\">\\1@\\2\\3</a>","([^[:space:]]*)@([^[:space:]]*)([[:alnum:]])",$temp ) ;
		return ( $temp ) ;
	}
	
	function CheckSmile($temp){
		global $url;
				global $db;
		$text = array();
		$pic = array();
		$sql = "select * from emotion ";
		$query = $db->query($sql);
		while($rec = $db->db_fetch_array($query)){
		array_push($text,$rec[emotion_character]);
		array_push($pic,$rec[emotion_img]);
		}
		/*
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
		"brain.gif","phone.gif","zip.gif","download.gif","beer.gif","censore.gif","nolove.gif","cranium.gif");*/

		for ($i=0 ; $i<sizeof($text) ; $i++) {
			$temp = eregi_replace("<img src=\"$pic[$i]\">",$text[$i],$temp);
		}
		return($temp);
	}

function CheckVulgar($msg){
$BanWord="***";
$Sql="SELECT * FROM vulgar_table";
$ExecSql=  mysql_query($Sql);
$total=mysql_num_rows($ExecSql);
if($total>0){
while($R=$db->db_fetch_array($ExecSql)){
$Vtext=$R['vulgar_text'];
$msg=eregi_replace($Vtext,$BanWord,$msg);
}
}
return $msg;
}
if($_GET[t] != '' && $_GET[t] != '0'){
		$_GET[t] = $_GET[t];
	}else{
		$_GET[t] = $global_theme;
	}
if($_GET[t]){
	   $namefolder = "themes".($_GET[t]);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
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
			$bg_color='#C8C9D0';
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
			$body_font_color='#686898';
			$body_font_color2='#000000';
			$body_font_color3='#CC0000';
			$bottom_img='';
			$bottom_color='';
			$bottom_height='0';
			$Current_Dir1 = "";
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
if(document.myForm.aque.value == ""){
alert('<?php echo $text_genwebboard_alerttitle;?>');
document.myForm.aque.focus();
return false;
}
if(document.myForm.amsg.value == ""){
alert('<?php echo $text_genwebboard_alertdetail;?>');
document.myForm.amsg.focus();
return false;
}
if(document.myForm.aname.value == ""){
alert('<?php echo $text_genwebboard_alertname;?>');
document.myForm.aname.focus();
return false;
}
if(document.myForm.chk_email.checked) {
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
if(document.getElementById('chkpic11').value == ""){
alert('Please input picture text.');
document.getElementById('chkpic11').focus();
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

	
	function setsmile(what)
	{
		document.myForm.amsg.value = document.myForm.elements.amsg.value+" "+what;
		document.myForm.amsg.focus();
	} 
	
   function chkValid (f) { 
	   if (isBlank(f.aque.value)){
			  alert ('<?php echo $text_genwebboard_alerttitle;?>');
			  f.aque.focus ();
			  return false;
	   }
	   
	   if (isBlank(f.amsg.value)){
			  alert ('<?php echo $text_genwebboard_alertdetail;?>');
			  f.amsg.focus ();
			  return false;
	   }
	
	   if (isBlank(f.aname.value)){
			  alert ('<?php echo $text_genwebboard_alertname;?>');
			  f.aname.focus ();
			  return false;
	   }
	   f.submit ();
	}
	
// capcha
function openid<?php echo $BID;?>(){
document.frm<?php echo $BID;?>.submit();
 }
function chk<?php echo $BID;?>(){
	if(document.getElementById('ewt_user1').value == ""){
			alert("<?php echo $text_GenLogin_alertusername;?>");
			document.getElementById('ewt_user1').focus();
			return false;
	}else if(document.getElementById('ewt_pass1').value == ""){
			alert("<?php echo $text_GenLogin_alertpassword;?>");
			document.getElementById('ewt_pass1').focus();
			return false;
	}else{
	document.getElementById('firstbox<?php echo $BID;?>').style.display = 'none';
	document.getElementById('secbox<?php echo $BID;?>').style.display = '';
	document.getElementById('chkpic1<?php echo $BID;?>').focus();
	}

}
function chkp<?php echo $BID;?>(){
		if(document.getElementById('chkpic1<?php echo $BID;?>').value == ""){
			alert("<?php echo $text_GenLogin_alertpictext;?>");
			document.getElementById('chkpic1<?php echo $BID;?>').focus();
			return false;
	}
}
</script>
<style type="text/css">
<!--
.style3 {color: #686898; font-weight: bold; }
.style4 {color: #000000}
.style1 {color: #FF0000}
-->
</style>
</head>
<?php
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = $db->db_fetch_array($chk_config);	
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= $db->db_fetch_array($Execsql1);
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
alert("<?php echo $text_genwebboard_alertnotview;?>");
window.location.href = "m_webboard.php?t=<?php echo $_GET[t];?>";
</script>
<?php
}
if(($QQ[c_question] == "2" || $QQ[c_question] == "3" ) AND $_SESSION["EWT_MID"] == ""){
?>
<script language="JavaScript">
alert("<?php echo $text_general_alertloginWebboard;?>");
top.location.href="ewt_login.php?fn=addquestion.php?wcad=<?php echo $wcad; ?>&fn=<?php echo $_GET[t];?>";
</script>
<?php
exit;
}
if(($QQ[c_question] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1)  and $TTYPE != 'Y'){
?>
<script language="JavaScript">
alert("<?php echo $text_general_alertloginWebboard2;?>");
window.location.href = "index_question.php?wcad=<?php echo $wcad; ?>&t=<?php echo $_GET[t];?>";
</script>
<?php
exit;
}
?>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
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
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
<tr>
    <td height="25">&nbsp;</td>
  </tr>
<?php
$sql = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$R = $db->db_fetch_array($sql);
?>
  <tr>
    <td height="25"><strong><a href="m_webboard.php?t=<?php echo $_GET[t];?>&filename=<?php echo $_GET[filename];?>"><?php echo $text_genwebboard_pagemain;?></a> <img src="mainpic/arrow_r.gif" width="7" height="7" align="absmiddle"> <a href="index_question.php?wcad=<?php echo $wcad; ?>&t=<?php echo $_GET[t];?>&filename=<?php echo $_GET[filename];?>"><?php echo $QQ[c_name]; ?></a> <img src="mainpic/arrow_r.gif" width="7" height="7" align="absmiddle"> <?php echo $text_genwebboard_newboard;?></strong></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">
	<?php echo $design[0];?><table width="58%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="<?php echo $bg_color;?>"  background="<?php echo $Current_Dir1.$bg_img;?>" class="normal_font">
	  <form name="myForm" enctype="multipart/form-data" method="post" action="question_function.php" onSubmit="return CHK()" target="save_function_form">
	  <?php
    $img = explode(',',$R[c_img]);
	$num_img = count($img);
	if($R[c_img] == ''){$num_img = 0;}
	echo "<input name=\"num_img\" id=\"num_img\" type=\"hidden\" value=\"".$num_img."\">";
	for($i=0;$i<count($img);$i++){
	echo "<input name=\"img".$i."\" id=\"img[".$i."]\" type=\"hidden\" value=\"".$img[$i]."\">";
	}
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
  <tr >
    <td height="30" colspan="2" align="center" background="<?php echo $Current_Dir1.$head_img;?>"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"><?php echo $text_genwebboard_title;?></span></font></span></td>
  </tr>
  <tr >
    <td colspan="2" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_img;?>"><table border=0 cellpadding=2 cellspacing=1 width="100%">
      <tr>
        <td align=center colspan="2" ><table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr>
              <td width="18%" align="right"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_genwebboard_headboard;?></span></font></span><span class="style1">*</span></td>
              <td width="82%"><input name="aque" type=text class=violet id="aque" size=51>              </td>
            </tr>
            <tr>
              <td width="18%" height="107" align="right"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_genwebboard_detail;?></span></font></span><span class="style1">*</span></td>
              <td width="82%"><textarea rows="5" cols="50" name="amsg" id="amsg" class=violet></textarea>              </td>
            </tr>
			<?php if($_SESSION["EWT_MID"] != ""){ ?>
            <tr>
                          <td width="20%" align="right"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_genwebboard_attactfile;?></span></font></span></td>
              <td width="80%"><input type="file" name="file">
                            <!--( ไม่เกิน 100 Kb) -->
                            <span class="text_normal"><?php echo ereg_replace ("<#size#>", $X[c_sizeupload], $text_genwebboard_filesize);?></span></td>
            </tr>
			<?php } ?>
            <tr>
              <td width="18%" align="right"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_genwebboard_by;?></span></font></span><span class="style1">*</span></td>
              <td width="82%"><input name="aname" type=text class=violet id="aname" value="<?php echo trim($name_a);?>" size=30 maxlength=30 <?php if($_SESSION["EWT_MID"] != ""){ echo 'readonly';}?>>
               <!--<span class="style1"> (* สมาชิกเมื่อ Login แล้ว ไม่ต้องใส่ชื่อ) </span>--></td>
            </tr>
            <tr>
              <td width="18%" align="right"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>">ระบุอีเมล์</span></font></span></td>
              <td width="82%"><input name="chk_email" type="checkbox" class=violet id="chk_email" onClick="if(this.checked) { document.getElementById('tr_email').style.display=''; } else { document.getElementById('tr_email').style.display='none'; }"></td>
            </tr>
			<tr id="tr_email" style="display:none;">
              <td width="18%" align="right"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_genwebboard_email;?></span></font></span><span class="style1">*</span></td>
              <td width="82%"><input name="aemail" type=text class=violet id="aemail" size=24 maxlength=50 value="<?php echo $mail;?>" <?php echo $read;?>>              </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align=center><a href="javascript:setURL()"><img src="pic/link.gif" alt="<?php echo $text_genwebboard_linkurl;?>" width="18" height="17" border=0></a> <a href="javascript:setImage()"><img src="pic/tree.gif" border=0 alt="<?php echo $text_genwebboard_imgurl;?>"></a> <a href="javascript:setsmile('[---]')"><img src="pic/indent.gif" border=0 alt="<?php echo $text_genwebboard_indent;?>"></a> <a href="javascript:setBold()"><img src="pic/b.gif" border=0 alt="<?php echo $text_genwebboard_b;?>"></a> <a href="javascript:setItalic()"><img src="pic/i.gif" border=0 alt="<?php echo $text_genwebboard_i;?>"></a> <a href="javascript:setUnderline()"><img src="pic/u.gif" border=0 alt="<?php echo $text_genwebboard_u;?>"></a> <a href="javascript:setColor('red','<?php echo $text_genwebboard_redcolor;?>')"><img src="pic/redcolor.gif" border=0 alt="<?php echo $text_genwebboard_redcolor;?>"></a> <a href="javascript:setColor('green','<?php echo $text_genwebboard_greencolor;?>')"><img src="pic/greencolor.gif" border=0 alt="<?php echo $text_genwebboard_greencolor;?>"></a> <a href="javascript:setColor('blue','<?php echo $text_genwebboard_bluecolor;?>')"><img src="pic/bluecolor.gif" border=0 alt="<?php echo $text_genwebboard_bluecolor;?>"></a> <a href="javascript:setColor('orange','<?php echo $text_genwebboard_orangecolor;?>')"><img src="pic/orangecolor.gif" border=0 alt="<?php echo $text_genwebboard_orangecolor;?>"></a> <a href="javascript:setColor('pink','<?php echo $text_genwebboard_pinkcolor;?>')"><img src="pic/pinkcolor.gif" border=0 alt="<?php echo $text_genwebboard_pinkcolor;?>"></a> <a href="javascript:setColor('gray','<?php echo $text_genwebboard_graycolor;?>')"><img src="pic/graycolor.gif" border=0 alt="<?php echo $text_genwebboard_graycolor;?>"></a>&nbsp;&nbsp;&nbsp;
           <!-- <input type="button" name="Button2" value="แสดง icon" onClick="document.getElementById('icon').style.display='';">
          &nbsp;
          <input type="button" name="Button2" value="ปิด icon" onClick="document.getElementById('icon').style.display='none';">style="display:none "--></td>
      </tr>
      <tr id="icon" >
        <td colspan=2 align=center ><?php
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
            <font color="blue"><?php echo $text_genwebboard_text;?></font></td>
      </tr>
    </table></td>
    </tr>
  <tr >
              <td colspan="2" align="center"  height="<?php echo $bottom_height ;?>" background="<?php echo $Current_Dir1.$bottom_img;?>"   bgcolor="<?php echo $bottom_color;?>">
              <table width="<?php echo $bg_width; ?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span; ?>" bgcolor="<?php echo $bg_color; ?>">
        <tr>
          <td align="center" bgcolor="#FFFFFF">
		  
<table width="<?php echo $bg_width;?>"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
    <tr>
      <td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ></td>
    </tr>
    <tr>
      <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
	  <!-- capcha -->
	  <?php include('inc_capcha.php'); ?>
            <!-- capcha --></td>
    </tr>
  </table>

  </td>
        </tr>
      </table></td>
  </tr>
  <tr >
              <td colspan="2" align="center"  height="<?php echo $bottom_height ;?>" background="<?php echo $Current_Dir1.$bottom_img;?>"   bgcolor="<?php echo $bottom_color;?>"><b><font color="#FFFFFF" class=size3> 
                <input type="submit" value='<?php echo $text_general_submit;?>' name="Submit" >
                &nbsp; 
                <input type=reset value='<?php echo $text_general_reset;?>' name="reset">
                <input name="flag" type="hidden" id="flag" value="question">
                <input name="wcad" type="hidden" id="wcad" value="<?php echo $wcad; ?>">
				<input name="themes" type="hidden" id="themes" value="<?php echo $_GET[t]; ?>">
				<input name="filename" type="hidden" id="filename" value="<?php echo $_GET[filename]; ?>">
                <input type="hidden" name="fign" value="<?php echo $_SESSION["EWT_FIGN"];?>">
                </font></b></td>
  </tr>
  
  <?php if($R[c_pic] == "Y"){  ?>
                    
  <?php } ?>
</form>
</table><?php echo $design[1];?></td>
  </tr>
  <tr>
    <td height="10">&nbsp;</td>
  </tr>
</table>
 <iframe name="save_function_form" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
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