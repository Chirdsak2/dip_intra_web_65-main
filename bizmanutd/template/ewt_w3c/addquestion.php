<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	include($path."language/language".$lang_sh.".php");
	include("ewt_template.php");
	$db->access=200;
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
while($R=mysql_fetch_array($ExecSql)){
$Vtext=$R['vulgar_text'];
$msg=eregi_replace($Vtext,$BanWord,$msg);
}
}
return $msg;
}
?><?php echo $template_design[0];?>
<script language="JavaScript"  type="text/javascript">
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
 </script>

	<?php
			$mainwidth = $F["d_site_content"];
			?>
	<?
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);	
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
if(($QQ[c_view] == "2" || $QQ[c_view] == "3" ) AND $_SESSION["EWT_MID"] == ""){
 
?>
 <script language="JavaScript"  type="text/javascript">
alert("<?php echo $text_genwebboard_alertlogin;?>");
top.location.href="ewt_login.php?fn=index_question.php?wcad=<? echo $wcad; ?>&amp;t=<?php echo $_GET[t];?>";
</script>
<?
exit;
}
if(($QQ[c_view] == "3"   AND $_SESSION["EWT_MID"] != "" AND ($_SESSION["EWT_TYPE_ID"]  != 1)) and $TTYPE != 'Y'){
?>
 <script language="JavaScript"  type="text/javascript">
alert("<?php echo $text_genwebboard_alertnotview;?>");
window.location.href = "m_webboard.php?t=<?php echo $_GET[t];?>";
</script>
<?
}
if(($QQ[c_question] == "2" || $QQ[c_question] == "3" ) AND $_SESSION["EWT_MID"] == ""){
?>
 <script language="JavaScript"  type="text/javascript">
alert("<?php echo $text_general_alertloginWebboard;?>");
top.location.href="ewt_login.php?fn=addquestion.php?wcad=<? echo $wcad; ?>&amp;fn=<?php echo $_GET[t];?>";
</script>
<?
exit;
}
if(($QQ[c_question] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1)  and $TTYPE != 'Y'){
?>
 <script language="JavaScript"  type="text/javascript">
alert("<?php echo $text_general_alertloginWebboard2;?>");
window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&amp;t=<?php echo $_GET[t];?>";
</script>
<?
exit;
}
?>		
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
<tr>
    <td >&nbsp;</td>
  </tr>
<?
$sql = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$R = mysql_fetch_array($sql);
?>
  <tr>
    <td><a href="m_webboard.php?t=<?php echo $_GET[t];?>&amp;filename=<?php echo $_GET[filename];?>" accesskey=<?php echo $db->genaccesskey();?>><?php echo $text_genwebboard_pagemain;?></a> <img src="../mainpic/arrow_r.gif" alt="arrow_r.gif" width="7" height="7" > <a href="index_question.php?wcad=<? echo $wcad; ?>&amp;t=<?php echo $_GET[t];?>&amp;filename=<?php echo $_GET[filename];?>" accesskey=<?php echo $db->genaccesskey();?>><? echo $QQ[c_name]; ?></a> <img src="../mainpic/arrow_r.gif" alt="arrow_r.gif" width="7" height="7" > <?php echo $text_genwebboard_newboard;?></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"> <?
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
		  <form name="myForm" enctype="multipart/form-data" method="post" action="question_function.php" onSubmit="return CHK()">
		  <table width="58%" border="0" cellpadding="0" cellspacing="1"  class="normal_font">
  <tr >
    <td colspan="2" align="center" ><?php echo $text_genwebboard_title;?></td>
  </tr>
  <tr >
    <td colspan="2" ><table border=0 cellpadding=2 cellspacing=1 width="100%">
      <tr>
        <td align=center colspan="2" ><table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr>
              <td width="18%" align="left"><?php echo $text_genwebboard_headboard;?><span  style="color:#FF0000">*</span></td>
              <td width="82%" align="left"><input name="aque" type=text class=violet id="aque" size=51 alt="<?php echo $text_genwebboard_headboard;?>">              </td>
            </tr>
            <tr>
              <td width="18%"  align="left"><span class="text_normal"><?php echo $text_genwebboard_detail;?></span><span  style="color:#FF0000">*</span></td>
              <td width="82%" align="left"><textarea rows="5" cols="50" name="amsg" id="amsg" class=violet title="<?php echo $text_genwebboard_detail;?>"></textarea>              </td>
            </tr>
			<?php if($_SESSION["EWT_MID"] != ""){ ?>
            <tr>
                          <td width="20%" align="left"><span class="text_normal"><?php echo $text_genwebboard_attactfile;?></span></td>
              <td width="80%" align="left"><input type="file" name="file" alt="Browse..">
                            <!--( ไม่เกิน 100 Kb) -->
                            <span class="text_normal"><?php echo ereg_replace ("<#size#>", $R[c_sizeupload], $text_genwebboard_filesize);?></span></td>
            </tr>
			<? } ?>
            <tr>
              <td width="18%" align="left"><span class="text_normal"><?php echo $text_genwebboard_by;?></span><span  style="color:#FF0000">*</span></td>
              <td width="82%" align="left"><input name="aname" type=text class=violet id="aname"  alt="<?php echo $text_genwebboard_by;?>" value="<?php echo trim($name_a);?>" size=30 maxlength=30 <?php if($_SESSION["EWT_MID"] != ""){ echo 'readonly';}?>>
               <!--<span  style="color:#FF0000"> (* สมาชิกเมื่อ Login แล้ว ไม่ต้องใส่ชื่อ) </span>--></td>
            </tr>
            <tr>
              <td width="18%" align="left"><span class="text_normal"><?php echo $text_genwebboard_email;?></span><span  style="color:#FF0000">*</span></td>
              <td width="82%" align="left"><input name="aemail" type=text class=violet id="aemail" alt="<?php echo $text_genwebboard_email;?>" size=24 maxlength=50 value="<?php echo $mail;?>" <?php echo $read;?>>              </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align=center><a href="javascript:setURL()"><img src="../pic/link.gif" alt="<?php echo $text_genwebboard_linkurl;?>" width="18" height="17" border=0></a> <a href="javascript:setImage()"><img src="../pic/tree.gif" alt="<?php echo $text_genwebboard_imgurl;?>" width="18" height="17" border=0></a> <a href="javascript:setsmile('[---]')"><img src="../pic/indent.gif" alt="<?php echo $text_genwebboard_indent;?>" width="18" height="17" border=0></a> <a href="javascript:setBold()"><img src="../pic/b.gif" alt="<?php echo $text_genwebboard_b;?>" width="18" height="17" border=0></a> <a href="javascript:setItalic()"><img src="../pic/i.gif" alt="<?php echo $text_genwebboard_i;?>" width="18" height="17" border=0></a> <a href="javascript:setUnderline()"><img src="../pic/u.gif" alt="<?php echo $text_genwebboard_u;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('red','<?php echo $text_genwebboard_redcolor;?>')"><img src="../pic/redcolor.gif" alt="<?php echo $text_genwebboard_redcolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('green','<?php echo $text_genwebboard_greencolor;?>')"><img src="../pic/greencolor.gif" alt="<?php echo $text_genwebboard_greencolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('blue','<?php echo $text_genwebboard_bluecolor;?>')"><img src="../pic/bluecolor.gif" alt="<?php echo $text_genwebboard_bluecolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('orange','<?php echo $text_genwebboard_orangecolor;?>')"><img src="../pic/orangecolor.gif" alt="<?php echo $text_genwebboard_orangecolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('pink','<?php echo $text_genwebboard_pinkcolor;?>')"><img src="../pic/pinkcolor.gif" alt="<?php echo $text_genwebboard_pinkcolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('gray','<?php echo $text_genwebboard_graycolor;?>')"><img src="../pic/graycolor.gif" alt="<?php echo $text_genwebboard_graycolor;?>" width="18" height="17" border=0></a>&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr id="icon" >
        <td colspan=2 align=center ><?php
						$i=1;
						$sql_emotion = "select * from emotion";
						$query_emotion = $db->query($sql_emotion);
						while($rec_emotion = $db->db_fetch_array($query_emotion)){
						echo "&nbsp;<a href=\"javascript:setsmile('".$rec_emotion[emotion_character]."')\"><img src=\"../".$rec_emotion[emotion_img]."\" border=0 alt=\"".$rec_emotion[emotion_name]."\"></a>&nbsp;&nbsp;&nbsp;";
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
              <td colspan="2" align="center"  ><b><font color="#FFFFFF" class=size3> 
                <input type=submit value='<?php echo $text_general_submit;?>' name="Submit"  alt="submit">
                &nbsp; 
                <input type=reset value='<?php echo $text_general_reset;?>' name="reset" alt="reset">
                <input name="flag" type="hidden" id="flag" value="question" alt="hidden">
                <input name="wcad" type="hidden" id="wcad" value="<? echo $wcad; ?>" alt="hidden">
				<input name="themes" type="hidden" id="themes" value="<? echo $_GET[t]; ?>" alt="hidden">
				<input name="filename" type="hidden"  value="<? echo $_GET[filename]; ?>" alt="hidden">
                <input type="hidden" name="fign" value="<?php echo $_SESSION["EWT_FIGN"];?>" alt="hidden">
                </font></b></td>
  </tr>
  
  <? if($R[c_pic] == "Y"){  ?>
                    
  <? } ?>

</table>
		  </form></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
</table>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>