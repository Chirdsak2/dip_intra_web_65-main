<?php
session_start();
//session_destroy();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("webboard_log.php");
//include("language/language.php");
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
			
			if($_GET[t] != '' && $_GET[t] != '0'){
				$_GET[t] = $_GET[t];
			}else{
				$_GET[t] = $global_theme;
			}
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
		/*$text = array(
		":sad:",":red:", ":big:", ":ent:", ":shy:", ":sleepy:", ":sun:", ":sg:", ":embarass:", 
		":dead:", ":cool:", ":clown:", ":pukey:", ":eek:", ":roll:", ":smoke:", ":angry:", ":confused:", ":cry:", 
		":lol:", ":yawn:", ":devil:", ":tongue:", ":alien:",":tasty:",":crazy:",":agree:",":disagree:",":bawling:", 
		":crap:",":crying1:",":dunce:",":error:",":evil:",":lookaroundb:",":laugh:",":pimp:",":spiny:",":wavey:",":smash:",":angry:",
		":brain:",":phone:",":zip:",":download:",":beer:",":censore:",":nolove:",":cranium:");*/
		//$text = implode(",", $array);

		/*$pic =array(
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
$db->query("UPDATE w_question SET t_count = t_count + 1 WHERE t_id = '$wtid'");
$Execsql = $db->query("SELECT * FROM w_question WHERE t_id = '$wtid' AND s_id = '1' ");
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
if($_GET[t]){
	   $namefolder = "themes".($_GET[t]);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		 //if($themes_type == 'F'){
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
$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php if($MyTitle==""){?>===== Welcome =====<?php }else{ echo $MyTitle; }?></title>
<?php
include("ewt_script.php");	
?>
<style type="text/css">
<!--
.style1 {
	color: #686898;
	font-weight: bold;
}
-->
</style>
</head>
<?php
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);

if(($QQ[c_view] == "2" || $QQ[c_view] == "3" ) AND $_SESSION["EWT_MID"] == "" ){
?>
<script language="JavaScript">
alert("กรุณา login ก่อนเข้าสู่  Webboard");
top.location.href="ewt_login.php?fn=index_question.php?wcad=<?php echo $wcad; ?>&t=<?php echo $_GET[t];?>";
</script>
<?php
exit;
}
if(($QQ[c_view] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1) and $TTYPE != 'Y'){
?>
<script language="JavaScript">
alert("Webboard นี้ท่านไม่สามารถร่วมในหมวดนี้ได้");
window.location.href = "m_webboard.php?t=<?php echo $_GET[t];?>";
</script>
<?php
}
    if(($QQ[c_answer] == "2" || $QQ[c_answer] == "3" ) AND $_SESSION["EWT_MID"] == ""){
		?>
		<script language="JavaScript">
		alert("<?php echo $text_genwebboard_alertnotview;?>");
		window.location.href = "m_webboard.php?t=<?php echo $_GET[t];?>";
		</script>
		<?php
	}else if(($QQ[c_answer] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1)  and $TTYPE != 'Y'){
		?>
		<script language="JavaScript">
		alert("<?php echo $text_genwebboard_alertnotview;?>");
		window.location.href = "m_webboard.php?t=<?php echo $_GET[t];?>";
		</script>
		<?php
	}
$Ex_question= $db->query("SELECT * FROM w_answer WHERE t_id = '$wtid' and a_id = '$waid'");
$QQ_question= mysql_fetch_array($Ex_question);
?>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_top = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">&nbsp;
		
		  </td>
          
    <td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="">
<tr>
    <td height="25">&nbsp;</td>
  </tr>
<?php
$sql = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$X = mysql_fetch_array($sql);
?>
  <tr>
    <td height="25"><strong><a href="m_webboard.php"><?php echo $text_genwebboard_pagemain;?></a> <img src="mainpic/arrow_r.gif" width="7" height="7" align="absmiddle"> <a href="index_question.php?wcad=<?php echo $wcad; ?>"><?php echo $QQ[c_name]; ?></a></strong></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">
	<DIV align="center"><br>
<?php echo $design[0];?>
 <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="<?php echo $bg_color;?>"  background="<?php echo $Current_Dir1.$bg_img;?>" class="normal_font">
 <form name="myForm" enctype="multipart/form-data" method="post" action="question_function.php" onSubmit="return CHK()" target="save_function_form1">
  <tr align="center" >
    <td height="30" background="<?php echo $Current_Dir1.$head_img;?>" bgcolor="<?php echo $head_color;?>"><strong><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"><?php echo $text_genwebboard_editanw;?></span></font></span></strong></td>
  </tr>
  <tr>
    <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_img;?>"><table width=100% border=0 cellpadding=2 cellspacing=1 align="center">
      <tr >
        <td><table border=0 width=100% cellpadding="2" cellspacing="0">
		<?php
		$a_detail =  CheckTag($QQ_question[a_detail]);
		$a_detail =  eregi_replace ( "<br>" ,chr(13), $a_detail ) ;
		$a_detail =  CheckSmile($a_detail);
		
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
              <td align=right valign=top><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_genwebboard_detail;?></span></font></span></td>
              <td><textarea  name="amsg" cols=45 rows= 5 class=orenge><?php echo $a_detail;?></textarea>
              </td>
            </tr>
			 <?php if($_SESSION["EWT_sMID"] != ""){ ?>
			<tr >
			  <td width="20%" align="right" ><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_genwebboard_attactfile;?></span></font></span></td>
			  <td width="80%"><input type="file" name="file"><span class="MemberNormalRed"><?php echo ereg_replace ("<#size#>", $X[c_sizeupload], $text_genwebboard_filesize);?></span></td>
			</tr>
			<?php } ?>
            <tr>
              <td align=right><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_genwebboard_by;?></span></font></span></td>
              <td><input name="aname" type=text class=orenge value="<?php echo $name_a;?>"  size=47 maxlength=50 <?php if($_SESSION["EWT_MID"] != ""){ echo 'readonly';}?>>
              </td>
            </tr>
            <tr>
              <td align=right><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_genwebboard_email;?></span></font></span></td>
              <td><input  size=35 type=text name="aemail" maxlength=50 class=orenge value="<?php echo $mail;?>"  <?php echo $read;?>>
                  <input name="board_id" type="hidden" id="board_id" >
              </td>
            </tr>
        </table></td>
      </tr>
      <tr  valign="bottom">
        <td align=center ><a href="javascript:setURL()"><img src="pic/link.gif" alt="<?php echo $text_genwebboard_linkurl;?>" width="18" height="17" border=0></a> <a href="javascript:setImage()"><img src="pic/tree.gif" border=0 alt="<?php echo $text_genwebboard_imgurl;?>"></a> <a href="javascript:setsmile('[---]')"><img src="pic/indent.gif" border=0 alt="<?php echo $text_genwebboard_indent;?>"></a> <a href="javascript:setBold()"><img src="pic/b.gif" border=0 alt="<?php echo $text_genwebboard_b;?>"></a> <a href="javascript:setItalic()"><img src="pic/i.gif" border=0 alt="<?php echo $text_genwebboard_i;?>"></a> <a href="javascript:setUnderline()"><img src="pic/u.gif" border=0 alt="<?php echo $text_genwebboard_u;?>"></a> <a href="javascript:setColor('red','<?php echo $text_genwebboard_redcolor;?>')"><img src="pic/redcolor.gif" border=0 alt="<?php echo $text_genwebboard_redcolor;?>"></a> <a href="javascript:setColor('green','<?php echo $text_genwebboard_greencolor;?>')"><img src="pic/greencolor.gif" border=0 alt="<?php echo $text_genwebboard_greencolor;?>"></a> <a href="javascript:setColor('blue','<?php echo $text_genwebboard_bluecolor;?>')"><img src="pic/bluecolor.gif" border=0 alt="<?php echo $text_genwebboard_bluecolor;?>"></a> <a href="javascript:setColor('orange','<?php echo $text_genwebboard_orangecolor;?>')"><img src="pic/orangecolor.gif" border=0 alt="<?php echo $text_genwebboard_orangecolor;?>"></a> <a href="javascript:setColor('pink','<?php echo $text_genwebboard_pinkcolor;?>')"><img src="pic/pinkcolor.gif" border=0 alt="<?php echo $text_genwebboard_pinkcolor;?>"></a> <a href="javascript:setColor('gray','<?php echo $text_genwebboard_graycolor;?>')"><img src="pic/graycolor.gif" border=0 alt="<?php echo $text_genwebboard_graycolor;?>"></a>&nbsp;&nbsp;&nbsp;
           <!-- <input type="button" name="Button" value="แสดง icon" onClick="document.getElementById('icon').style.display='';">
          &nbsp;
          <input type="button" name="Button" value="ปิด icon" onClick="document.getElementById('icon').style.display='none';">--></td>
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
						?><!--<a href="javascript:setsmile(':angry:')"><img src="pic/angry.gif" border=0 width="15" height="15"></a> 
																	<a href="javascript:setsmile(':sad:')"><img src="pic/frown.gif" border=0></a> 
																	<a href="javascript:setsmile(':red:')"><img src="pic/redface.gif" border=0></a> 
																	<a href="javascript:setsmile(':big:')"><img src="pic/biggrin.gif" border=0></a> 
																	<a href="javascript:setsmile(':ent:')"><img src="pic/blue.gif" border=0></a> <a href="javascript:setsmile(':shy:')"><img src="pic/shy.gif" border=0></a> <a href="javascript:setsmile(':sleepy:')"><img src="pic/sleepy.gif" border=0></a> <a href="javascript:setsmile(':sun:')"><img src="pic/sunglasses.gif" border=0></a> <a href="javascript:setsmile(':sg:')"><img src="pic/supergrin.gif" border=0></a> <a href="javascript:setsmile(':embarass:')"><img src="pic/embarass.gif" border=0></a> <a href="javascript:setsmile(':dead:')"><img src="pic/dead.gif" border=0></a> <a href="javascript:setsmile(':cool:')"><img src="pic/cool.gif" border=0></a> <a href="javascript:setsmile(':clown:')"><img src="pic/clown.gif" border=0></a> <a href="javascript:setsmile(':pukey:')"><img src="pic/pukey.gif" border=0></a> <a href="javascript:setsmile(':eek:')"><img src="pic/eek.gif" border=0></a> <a href="javascript:setsmile(':roll:')"><img src="pic/sarcblink.gif" border=0></a> <a href="javascript:setsmile(':smoke:')"><img src="pic/smokin.gif" border=0></a> <a href="javascript:setsmile(':angry:')"><img src="pic/reallymad.gif" border=0></a> <a href="javascript:setsmile(':confused:')"><img src="pic/confused.gif" border=0></a> <a href="javascript:setsmile(':cry:')"><img src="pic/crying.gif" border=0></a> <a href="javascript:setsmile(':lol:')"><img src="pic/lol.gif" border=0></a> <a href="javascript:setsmile(':yawn:')"><img src="pic/yawn.gif" border=0></a> <a href="javascript:setsmile(':devil:')"><img src="pic/devil.gif" border=0></a> <a href="javascript:setsmile(':brain:')"><img src="pic/brain.gif" border=0 width="17" height="15"></a> <a href="javascript:setsmile(':phone:')"><img src="pic/phone.gif" border=0 width="9" height="24"></a> <a href="javascript:setsmile(':zip:')"><img src="pic/zip.gif" border=0 width="14" height="14"></a><br>
            <a href="javascript:setsmile(':tongue:')"><img src="pic/tongue.gif" border=0></a> <a href="javascript:setsmile(':alien:')"><img src="pic/aysmile.gif" border=0></a> <a href="javascript:setsmile(':tasty:')"><img src="pic/tasty.gif" border=0></a> <a href="javascript:setsmile(':agree:')"><img src="pic/agree.gif" border=0></a> <a href="javascript:setsmile(':disagree:')"><img src="pic/disagree.gif" border=0></a> <a href="javascript:setsmile(':bawling:')"><img src="pic/bawling.gif" border=0></a> <a href="javascript:setsmile(':crap:')"><img src="pic/crap.gif" border=0></a> <a href="javascript:setsmile(':crying1:')"><img src="pic/crying1.gif" border=0></a> <a href="javascript:setsmile(':dunce:')"><img src="pic/dunce.gif" border=0></a> <a href="javascript:setsmile(':error:')"><img src="pic/error.gif" border=0></a> <a href="javascript:setsmile(':evil:')"><img src="pic/evil.gif" border=0></a> <a href="javascript:setsmile(':lookaroundb:')"><img src="pic/lookaroundb.gif" border=0></a> <a href="javascript:setsmile(':laugh:')"><img src="pic/laugh.gif" border=0></a> <a href="javascript:setsmile(':pimp:')"><img src="pic/pimp.gif" border=0></a> <a href="javascript:setsmile(':spiny:')"><img src="pic/spiny.gif" border=0></a> <a href="javascript:setsmile(':wavey:')"><img src="pic/wavey.gif" border=0></a> <a href="javascript:setsmile(':smash:')"><img src="pic/smash.gif" border=0 width="30" height="26"></a> <a href="javascript:setsmile(':crazy:')"><img src="pic/grazy.gif" border=0 width="16" height="16"></a> <a href="javascript:setsmile(':download:')"><img src="pic/download.gif" border=0></a> <a href="javascript:setsmile(':cranium:')"><img src="pic/cranium.gif" border=0></a> <a href="javascript:setsmile(':censore:')"><img src="pic/censore.gif" border=0></a> <a href="javascript:setsmile(':nolove:')"><img src="pic/nolove.gif" border=0></a> <a href="javascript:setsmile(':beer:')"><img src="pic/beer.gif" border=0></a>--><br>
            <font color="blue"><?php echo $text_genwebboard_text;?></font> </td>
      </tr>
    </table></td>
    </tr>
  <?php if($X[c_pic] == "Y"){  ?>
                    
  <?php } ?>
  
  <tr >
    <td align="center"  height="<?php echo $bottom_height ;?>" background="<?php echo $Current_Dir1.$bottom_img;?>"   bgcolor="<?php echo $bottom_color;?>"><input type="submit" name="Submit" value="<?php echo $text_general_submit;?>" class="normaltxt">
      <input type="reset" name="Submit2" value="<?php echo $text_general_reset;?>" class="normaltxt">
      <input name="flag" type="hidden" id="flag" value="answer_edit">
	  <input name="wcad" type="hidden" id="wcad" value="<?php echo $wcad; ?>">
	  <input name="wtid" type="hidden" id="wtid" value="<?php echo $wtid; ?>">
	   <input name="waid" type="hidden" id="waid" value="<?php echo $waid; ?>">
	  </td>
    </tr>
</form>
</table><?php echo $design[1];?>
<br>
	</DIV></td>
  </tr>
  <tr>
    <td height="10">&nbsp;</td>
  </tr>
</table>
 <iframe name="save_function_form1" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
	</td>
          <td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">&nbsp;
		  
		  </td>
        </tr>
        <tr valign="top" > 
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>
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
alert("กรุณาใส่รายละเอียด");
document.myForm.amsg.focus();
return false;
}
if(document.myForm.aname.value == ""){
alert("กรุณาใส่ชื่อ");
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
	var temp = window.prompt('ใส่ URL ที่คุณต้องการสร้างเป็นลิงค์','http://'); 
	if(temp) setsmile('[url]'+temp+'[/url]');
}

function setImage()
{
	var temp = window.prompt('ใส่ URL ของรูปที่คุณต้องการให้แสดงในกระทู้ของคุณ','http://'); 
	if(temp) setsmile('[img]'+temp+'[/img]');
}

function setBold()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวหนา',''); 
	if(temp) setsmile('[b]'+temp+'[/b]');
}

function setItalic()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเอียง',''); 
	if(temp) setsmile('[i]'+temp+'[/i]');
}

function setUnderline()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้มีเส้นใต้',''); 
	if(temp) setsmile('[u]'+temp+'[/u]');
}

function setColor(color,name)
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้เป็นสี'+name,''); 
	if(temp) setsmile('[color='+color+']'+temp+'[/color]');
}

function setsmile(what)
{
	document.myForm.amsg.value = document.myForm.elements.amsg.value+" "+what;
	document.myForm.amsg.focus();
}
</script>
