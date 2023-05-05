<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("webboard_log.php");
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
<title><?php if($MyTitle==""){?>===== Welcome =====<?php }else{ echo $MyTitle; }?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link id="stext" href="css/size.css" rel="stylesheet" type="text/css">
<script language="JavaScript1.2">
<!--
top.window.moveTo(0,0);
if (document.all) {
top.window.resizeTo(screen.availWidth,screen.availHeight);
}
else if (document.layers||document.getElementById) {
if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
top.window.outerHeight = screen.availHeight;
top.window.outerWidth = screen.availWidth;
}
}
//-->
</script>
<style type="text/css">
<!--
.style3 {font-size: 14}
.style4 {font-size: 12px}
-->
</style>
<link href="css/text1.css" rel="stylesheet" type="text/css"></head>
<?php
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
if($QQ["c_rss"]=='Y'){
			 $filename="rss/webboard".$QQ["c_id"].".xml";
			 if(file_exists($filename)){
			     $link='<a href="rss/webboard'.$QQ["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0" align="absmiddle"> </a>';
			 }else{
			     $link='';
			 }
		}else{ $link='';
		}
if($QQ[c_view] == "Y" AND $_SESSION["EWT_MID"] == ""){
?>
<script language="JavaScript">
alert("กรุณา login ก่อนเข้าสู่  Webboard");
</script>
<?php
echo "<table width=\"100%\" height=\"100%\"><form name=\"delform\" method=\"post\" action=\"ewt_login.php\"><input name=\"fn\" type=\"hidden\" id=\"fn\" value=\"index_answer.php?wcad=".$wcad."&wtid=".$wtid."\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
?>
<script language="JavaScript">
delform.submit();
</script>
<?php
exit;
}
if($QQ[c_view] == "Y" AND $QQ[c_view_porf] == "Y"  AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  > 3){
?>
<script language="JavaScript">
alert("Webboard นี้ท่านไม่สามารถร่วมในหมวดนี้ได้");
window.location.href = "m_webboard.php";
</script>
<?php
}
?>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" align="">
<tr>
    <td height="25"><?php @include("com_top.php"); ?></td>
  </tr>
  <?php
$sql = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$X = mysql_fetch_array($sql);

?>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
  <tr>
    <td height="25"><table width="920" border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#006699">
                        <tr>
                          <td width="901" height="23"> <?php  $name =  stripslashes($R[t_name]);  echo CheckVulgar($name); ?></td>
                          <td width="11"><div align="right"><img src="mainpic/content_r2_c4.gif" width="10" height="23" /></div></td>
                        </tr>
                      </table>
                        <!--#F4F4F4-->
                        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="#006699">
                          <tr>
                            <td colspan="2" width="100%" valign="top" class="text11" bgcolor="white"><!--Content-->
                                <table width="0" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><!--detail-->
                                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                                          <tr>
                                            <td align="center"><table width="820" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="149">โดย : 
              <?php 
			  $db->query("USE ".$EWT_DB_USER);
		$sql_img = "select * from gen_user where gen_user_id = '$R[user_id]'";
		$query = $db->query($sql_img);
		$rec_img = $db->db_fetch_array($query);
		$img_port = "../pic_upload_webboard/".$rec_img[webb_pic];
		$db->query("USE ".$EWT_DB_NAME);
			  
			if(!empty($R[q_email])){ ?>
        <a href="mailto:<?php echo $R[q_email]; ?>"><?php if(empty($rec_img[webb_name])){ echo stripslashes($R[q_name]);}else{echo stripslashes($rec_img[webb_name]);} ?></a><?php if($TTYPE == 'Y' && $admin==$R[user_id]){ echo "[ผู้ดูแลระบบ]";}?>
        <?php }else{ ?>
        <?php if(empty($rec_img[webb_name])){ echo stripslashes($R[q_name]);}else{echo stripslashes($rec_img[webb_name]);} ?><?php if($TTYPE == 'Y' && $admin==$R[user_id]){ echo "[ผู้ดูแลระบบ]";}?>
        <?php } ?>
              <br> 
              <?php 
		if (file_exists($img_port) && !empty($rec_img[webb_pic])) {
		?>
		<img src="<?php echo $img_port; ?>" width="70" height="70" >
		<?php 
		} ?>
              <br>
              ( 
              <?php $timer = explode("-",$R[t_date]); $YearT = $timer[0]+543; ?>
              <?php echo $timer[2]."/".$timer[1]."/".$YearT." ".$R[t_time]; ?>)</td>
                                                <td width="8">|</td>
                                                <td width="560" valign="top"><?php 
			  
			 
			   $t_detail =  stripslashes($R[t_detail]);
			    $keyword = trim($keyword);
			  $pkw = explode(" ",$keyword);
			  $sum = count($pkw);
				for($q = 0;$q<$sum;$q++){
									if($pkw[$q] != ""){
									$t_detail = ereg_replace($pkw[$q],"<span style=\"background-color:".$color_websearch[$q]."\" >".$pkw[$q]."</span>", $t_detail);
									}
				}
	  		//$answer_detail = CheckTag($t_detail);
			//$answer_detail = CheckSmile($answer_detail);  
			$t_detail = eregi_replace("&lt;br&gt;","<br>", $t_detail);
			echo CheckVulgar($t_detail); ?>
              <br> 
              <?php 
	  if(!empty($R[keyword])){
	  $type_expl = explode('.',$R[keyword]);
	  $a= 1;
	  if($type_expl[$a] == 'jpg' || $type_expl[$a] =='JPG' || $type_expl[$a] =='Jpg' || $type_expl[$a] == 'GIF' || $type_expl[$a] =='Gif' || $type_expl[$a] == 'gif' || $type_expl[$a] == 'PNG' || $type_expl[$a] == 'Png' || $type_expl[$a] == 'png' || $type_expl[$a] == 'bmp' || $type_expl[$a] == 'BMP' || $type_expl[$a] == 'Bmp'){
		echo  '<br><img src="userpic/'.$R[keyword].'" border="0" >';//<a href="userpic/'.$R[keyword].'" target="_blank">'.$R[keyword].' </a>';
	  }else{
	  	echo  'เอกสารแนบ:<br><a href="userpic/'.$R[keyword].'" target="_blank">'.$R[keyword].' </a>';
	  }
	  }
	  if(!empty($R[t_fign])){
	  echo "<br><hr><br>By".$R[t_fign];
	  }
	   if(!empty($rec_img[fign])){
	  echo "<br><hr><br>By   :".$rec_img[fign];
	  }
	  ?>
              <div align="right">&nbsp; 
                <?php if($TTYPE == 'Y'){ ?>
                <a href="question_function.php?flag=deltopic&wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>" onClick="return confirm('Are you sure to delete?');">ลบกระทู้นี้ทั้งหมด</a>|<a href="editquestion.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>" target="_blank"><img src="../../images/b_edit.gif" border="0">แก้ไข</a>&nbsp;&nbsp;|&nbsp;<a href="#" onClick="window.open('chang_grouupquestion.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>','keyword','menubar=0,toolbar=0,location=0,scrollbars=1,status=1,width=400,height=250');">จัดการหมวดหมู่</a> 
                <?php } ?>
            </div></td>
                                              </tr>
                                              
                                            </table></td>
                                          </tr>
                                        </table>
                                      <!--detail-->                                    </td>
                                  </tr>
                                </table>
                              <!--Content-->                            </td>
                          </tr>
                      </table></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
  <?php 

$ExcAns = $db->query("SELECT * FROM w_answer WHERE t_id = '$wtid' AND s_id = '1'  ORDER BY a_id ASC");
$num = $db->db_num_rows($ExcAns);
$i=1;
while($RR = mysql_fetch_array($ExcAns)){
?>
  <tr>
    <td height="25"><table width="920" border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#88bbdd">
                        <tr>
                          <td width="901" height="23"><strong>ความเห็นที่ <?php echo $i; ?>:</strong></td>
                          <td width="11"><div align="right"><img src="mainpic/content_r2_c4.gif" width="10" height="23" /></div></td>
                        </tr>
                      </table>
                        <!--#F4F4F4-->
                        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="#88bbdd">
                          <tr>
                            <td colspan="2" width="100%" valign="top" class="text11" bgcolor="#FFFFCC"><!--Content-->
                                <table width="0" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><!--detail-->
                                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                                          <tr>
                                            <td align="center"><table width="820" border="0" cellspacing="0" cellpadding="1">
                                              <tr>
                                                <td width="175">โดย :
											  <?php 
												$db->query("USE ".$EWT_DB_USER);
												$sql_img = "select * from gen_user where gen_user_id = '$RR[user_id]'";
												$query = $db->query($sql_img);
												$rec_img = $db->db_fetch_array($query);
												$img_port = "../pic_upload_webboard/".$rec_img[webb_pic];
												$db->query("USE ".$EWT_DB_NAME);
											  if($RR[a_email] !=""){ ?>
											  <a href="mailto:<?php echo $RR[a_email]; ?>"><?php if(empty($rec_img[webb_name])){ echo stripslashes($RR[a_name]); }else{ echo stripslashes($rec_img[webb_name]); }?></a><?php if($TTYPE == 'Y' && $admin==$RR[user_id]){ echo "[ผู้ดูแลระบบ]";}?>
											  <?php }else{ ?>
											  <?php if(empty($rec_img[webb_name])){ echo CheckVulgar(stripslashes($RR[a_name])); }else{ echo stripslashes($rec_img[webb_name]); }?><?php if($TTYPE == 'Y' && $admin==$RR[user_id]){ echo "[ผู้ดูแลระบบ]";}?>
											  <?php } ?>
											  <br>
												<?php if (file_exists($img_port) && !empty($rec_img[webb_pic])) { ?>
												<img src="<?php echo $img_port; ?>" width="70" height="70" >
												<?php } ?>
											<br>
													  ( 
													  <?php $timer = explode("-",$RR[a_date]); $YearT = $timer[0]+543; ?>
											    <?php echo $timer[2]."/".$timer[1]."/".$YearT." ".$RR[a_time]; ?>)</td>
                                                <td width="8">|</td>
                                                <td width="635" valign="top"><?php 
	  	 $a_detail =  stripslashes($RR[a_detail]);
			    $keyword = trim($keyword);
			  $pkw = explode(" ",$keyword);
			  $sum = count($pkw);
				for($q = 0;$q<$sum;$q++){
									if($pkw[$q] != ""){
									$a_detail = ereg_replace($pkw[$q],"<span style=\"background-color:".$color_websearch[$q]."\" >".$pkw[$q]."</span>", $a_detail);
									}
				}
		  //$answer_detail = CheckTag($RR[a_detail]);
			//$answer_detail = CheckSmile($answer_detail);
			$answer_detail = eregi_replace("&lt;br&gt;","<br>", $a_detail);
			echo CheckVulgar(stripslashes($answer_detail));
		 ?><br>
		 	  <?php 
	  if(!empty($RR[a_attact])){
	  $type_expl = explode('.',$RR[a_attact]);
	  $a= 1;
	  if($type_expl[$a] == 'jpg' || $type_expl[$a] =='JPG' || $type_expl[$a] =='Jpg' || $type_expl[$a] == 'GIF' || $type_expl[$a] =='Gif' || $type_expl[$a] == 'gif' || $type_expl[$a] == 'PNG' || $type_expl[$a] == 'Png' || $type_expl[$a] == 'png' || $type_expl[$a] == 'bmp' || $type_expl[$a] == 'BMP' || $type_expl[$a] == 'Bmp'){
		echo  '<br><img src="userpic/'.$RR[a_attact].'" border="0">';//<a href="userpic/'.$RR[a_attact].'" target="_blank">'.$RR[a_attact].' </a>';
	  }else{
	  	echo  'เอกสารแนบ:<br><a href="userpic/'.$RR[a_attact].'" target="_blank">'.$RR[a_attact].' </a>';
	  }
	  }
	     if(!empty($rec_img[fign])){
	  echo "<br>ลายเซ็นต์:".$rec_img[fign];
	  }
	  ?>
	  <div align="right">
                <?php if($TTYPE=='Y'){?>
                <a href="question_function.php?flag=delans&wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>&waid=<?php echo $RR[a_id]; ?>" onClick="return confirm('Are you sure to delete?');"><img src="../../images/b_delete.gif" width="14" height="14" border="0" align="absmiddle">ลบความเห็นนี้</a>
                <?php } ?>
                <?php if($_SESSION["EWT_MID"] == $RR[user_id]){ ?>
                <a href="editanswer.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>&waid=<?php echo $RR[a_id]; ?>" target="_blank"><img src="../../images/b_edit.gif" border="0">แก้ไข</a>
                <?php } ?>
                <?php if($RR[s_id] !="1" && $TTYPE=='Y' ){ ?>
                <a href="question_function.php?flag=appans&wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>&waid=<?php echo $RR[a_id]; ?>" onClick="return confirm('Are you sure to approve?');"><img src="wb_pic/document_check.gif" width="24" height="24" border="0" align="absmiddle">อนุมัติความเห็นนี้</a> 
                <?php }else if($RR[s_id] =="1" && $TTYPE=='Y'){ ?>
                | <a href="question_function.php?flag=unappans&wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>&waid=<?php echo $RR[a_id]; ?>" onClick="return confirm('Are you sure to disable?');">คลิ๊กเพื่อยกเลิกการอนุมัติ</a> 
                <?php } ?>
              </div></td>
                                              </tr>
                                              
                                            </table></td>
                                          </tr>
                                        </table>
                                      <!--detail-->                                    </td>
                                  </tr>
                                  
                                </table>
                            <!--Content-->                            </td>
                          </tr>
                      </table></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <?php $i++; }?>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top">
	<DIV align="center">
	  <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B9BAC6">
 <form name="myForm" enctype="multipart/form-data" method="post" action="question_function.php" onSubmit="return CHK()">
 <?php
    $img = explode('||',$X[c_img]);
	$num_img = count($img);
	if($X[c_img] == ''){$num_img = 0;}
	echo "<input name=\"num_img\" id=\"num_img\" type=\"hidden\" value=\"".$num_img."\">";
	for($i=0;$i<count($img);$i++){
	echo "<input name=\"img".$i."\" id=\"img[".$i."]\" type=\"hidden\" value=\"".$img[$i]."\">";
	}
	
 ?>
  <tr align="center">
    <td height="30" background="mainpic/bg_webboard.gif"><strong>ขอเชิญร่วมแสดงความคิดเห็น </strong>(ถ้อยคำที่สุภาพ สร้างสรรค์ เป็นประโยชน์ต่อส่วนรวม) </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><table width=100% border=0 cellpadding=2 cellspacing=1 align="center">
      <tr >
        <td><table border=0 width=100% cellpadding="2" cellspacing="0">
            <tr>
              <td align=right valign=top><div align="right"><b><font color="686898">ความคิดเห็น</font></b></div></td>
              <td><textarea  name="amsg" cols=45 rows= 5 class=orenge></textarea></td>
            </tr>
			<tr >
			  <td width="20%" align="right" ><strong><font color="686898">รูปภาพประกอบ</font></strong></td>
			  <td width="80%"><input type="file" name="file"></td>
			</tr>
			<?php
		$db->query("USE ".$EWT_DB_USER);
		$sql_img = "select * from gen_user where gen_user_id = '".$_SESSION["EWT_MID"]."'";
		$query = $db->query($sql_img);
		$rec_img = $db->db_fetch_array($query);
		$img_port = "../pic_upload_webboard/".$rec_img[webb_pic];
		$db->query("USE ".$EWT_DB_NAME);
			?>
            <tr>
              <td align=right><div align="right">
                  <b><font color="686898">โดย</font></b></span></td>
                          <td><input name="aname" type=text class=orenge value="<?php if(empty($rec_img[webb_name])){ echo stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); }else{ echo stripslashes($rec_img[webb_name]); }?>"  size=47 maxlength=50>                          </td>
            </tr>
            <tr>
              <td align=right><div align="right">
                  <b><font color="686898">E-mail</font></b></span></td>
              <td><input  size=35 type=text name="aemail" maxlength=50 class=orenge value="<?php echo $rec_img[email_person];?>">
                  <input name="board_id" type="hidden" id="board_id" value="<?php echo $board_id; ?>">
                            <input type="hidden" name="fign" value="<?php echo $rec_img[fign];?>"> </td>
            </tr>
        </table></td>
      </tr>
      <tr  valign="bottom">
        <td align=center ><a href="javascript:setURL()"><img src="pic/link.gif" alt="แทรกลิงค์ URL" width="18" height="17" border=0></a> 
																	<a href="javascript:setImage()"><img src="pic/tree.gif" border=0 alt="แทรกรูป"></a> 
																	<a href="javascript:setsmile('[---]')"><img src="pic/indent.gif" border=0 alt="ย่อหน้า"></a> 
																	<a href="javascript:setBold()"><img src="pic/b.gif" border=0 alt="ตัวหนา"></a> 
																	<a href="javascript:setItalic()"><img src="pic/i.gif" border=0 alt="ตัวเอียง"></a> 
																	<a href="javascript:setUnderline()"><img src="pic/u.gif" border=0 alt="เส้นใต้"></a> 
																	<a href="javascript:setColor('red','แดง')"><img src="pic/redcolor.gif" border=0 alt="สีแดง"></a> 
																	<a href="javascript:setColor('green','เขียว')"><img src="pic/greencolor.gif" border=0 alt="สีเขียว"></a> 
																	<a href="javascript:setColor('blue','น้ำเงิน')"><img src="pic/bluecolor.gif" border=0 alt="สีน้ำเงิน"></a> 
																	<a href="javascript:setColor('orange','ส้ม')"><img src="pic/orangecolor.gif" border=0 alt="สีส้ม"></a> 
																	<a href="javascript:setColor('pink','ชมพู')"><img src="pic/pinkcolor.gif" border=0 alt="สีชมพู"></a> 
					  <a href="javascript:setColor('gray','เทา')"><img src="pic/graycolor.gif" border=0 alt="สีเทา"></a>&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr  id="icon">
        <td align=center>
		<?php
						$i=1;
						$sql_emotion = "select * from emotion";
						$query_emotion = $db->query($sql_emotion);
						while($rec_emotion = $db->db_fetch_array($query_emotion)){
						echo "<a href=\"javascript:setsmile('".$rec_emotion[emotion_character]."')\"><img src=\"".$rec_emotion[emotion_img]."\" border=0 ></a>&nbsp;&nbsp;";
						if($i=='10'){
						echo "<br>";
						$i=0;
						}
						$i++;
						}
						?><!--<a href="javascript:setsmile(':angry:')"><img src="../../WebboardMgt/pic/angry.gif" border=0></a> 
																	<a href="javascript:setsmile(':sad:')"><img src="../../WebboardMgt/pic/frown.gif" border=0></a> 
																	<a href="javascript:setsmile(':red:')"><img src="../../WebboardMgt/pic/redface.gif" border=0></a> 
																	<a href="javascript:setsmile(':big:')"><img src="../../WebboardMgt/pic/biggrin.gif" border=0></a> 
																	<a href="javascript:setsmile(':ent:')"><img src="../../WebboardMgt/pic/blue.gif" border=0></a> <a href="javascript:setsmile(':shy:')"><img src="../../WebboardMgt/pic/shy.gif" border=0></a> <a href="javascript:setsmile(':sleepy:')"><img src="../../WebboardMgt/pic/sleepy.gif" border=0></a> <a href="javascript:setsmile(':sun:')"><img src="../../WebboardMgt/pic/sunglasses.gif" border=0></a> <a href="javascript:setsmile(':sg:')"><img src="../../WebboardMgt/pic/supergrin.gif" border=0></a> <a href="javascript:setsmile(':embarass:')"><img src="../../WebboardMgt/pic/embarass.gif" border=0></a> <a href="javascript:setsmile(':dead:')"><img src="../../WebboardMgt/pic/dead.gif" border=0></a> <a href="javascript:setsmile(':cool:')"><img src="../../WebboardMgt/pic/cool.gif" border=0></a> <a href="javascript:setsmile(':clown:')"><img src="../../WebboardMgt/pic/clown.gif" border=0></a> <a href="javascript:setsmile(':pukey:')"><img src="../../WebboardMgt/pic/pukey.gif" border=0></a> <a href="javascript:setsmile(':eek:')"><img src="../../WebboardMgt/pic/eek.gif" border=0></a> <a href="javascript:setsmile(':roll:')"><img src="../../WebboardMgt/pic/sarcblink.gif" border=0></a> <a href="javascript:setsmile(':smoke:')"><img src="../../WebboardMgt/pic/smokin.gif" border=0></a> <a href="javascript:setsmile(':angry:')"><img src="../../WebboardMgt/pic/reallymad.gif" border=0></a> <a href="javascript:setsmile(':confused:')"><img src="../../WebboardMgt/pic/confused.gif" border=0></a> <a href="javascript:setsmile(':cry:')"><img src="../../WebboardMgt/pic/crying.gif" border=0></a> <a href="javascript:setsmile(':lol:')"><img src="../../WebboardMgt/pic/lol.gif" border=0></a> <a href="javascript:setsmile(':yawn:')"><img src="../../WebboardMgt/pic/yawn.gif" border=0></a> <a href="javascript:setsmile(':devil:')"><img src="../../WebboardMgt/pic/devil.gif" border=0></a> <a href="javascript:setsmile(':brain:')"><img src="../../WebboardMgt/pic/brain.gif" border=0></a> <a href="javascript:setsmile(':phone:')"><img src="../../WebboardMgt/pic/phone.gif" border=0></a> <a href="javascript:setsmile(':zip:')"><img src="../../WebboardMgt/pic/zip.gif" border=0 width="14" height="14"></a><br>
            <a href="javascript:setsmile(':tongue:')"><img src="../../WebboardMgt/pic/tongue.gif" border=0></a> <a href="javascript:setsmile(':alien:')"><img src="../../WebboardMgt/pic/aysmile.gif" border=0></a> <a href="javascript:setsmile(':tasty:')"><img src="../../WebboardMgt/pic/tasty.gif" border=0></a> <a href="javascript:setsmile(':agree:')"><img src="../../WebboardMgt/pic/agree.gif" border=0></a> <a href="javascript:setsmile(':disagree:')"><img src="../../WebboardMgt/pic/disagree.gif" border=0></a> <a href="javascript:setsmile(':bawling:')"><img src="../../WebboardMgt/pic/bawling.gif" border=0></a> <a href="javascript:setsmile(':crap:')"><img src="../../WebboardMgt/pic/crap.gif" border=0></a> <a href="javascript:setsmile(':crying1:')"><img src="../../WebboardMgt/pic/crying1.gif" border=0></a> <a href="javascript:setsmile(':dunce:')"><img src="../../WebboardMgt/pic/dunce.gif" border=0></a> <a href="javascript:setsmile(':error:')"><img src="../../WebboardMgt/pic/error.gif" border=0></a> <a href="javascript:setsmile(':evil:')"><img src="../../WebboardMgt/pic/evil.gif" border=0></a> <a href="javascript:setsmile(':lookaroundb:')"><img src="../../WebboardMgt/pic/lookaroundb.gif" border=0></a> <a href="javascript:setsmile(':laugh:')"><img src="../../WebboardMgt/pic/laugh.gif" border=0></a> <a href="javascript:setsmile(':pimp:')"><img src="../../WebboardMgt/pic/pimp.gif" border=0></a> <a href="javascript:setsmile(':spiny:')"><img src="../../WebboardMgt/pic/spiny.gif" border=0></a> <a href="javascript:setsmile(':wavey:')"><img src="../../WebboardMgt/pic/wavey.gif" border=0></a> <a href="javascript:setsmile(':smash:')"><img src="../../WebboardMgt/pic/smash.gif" border=0></a> <a href="javascript:setsmile(':crazy:')"><img src="../../WebboardMgt/pic/grazy.gif" border=0></a> <a href="javascript:setsmile(':download:')"><img src="../../WebboardMgt/pic/download.gif" border=0></a> <a href="javascript:setsmile(':cranium:')"><img src="../../WebboardMgt/pic/cranium.gif" border=0></a> <a href="javascript:setsmile(':censore:')"><img src="../../WebboardMgt/pic/censore.gif" border=0></a> <a href="javascript:setsmile(':nolove:')"><img src="../../WebboardMgt/pic/nolove.gif" border=0></a> <a href="javascript:setsmile(':beer:')"><img src="../../WebboardMgt/pic/beer.gif" border=0></a>--><br>
            <font color="blue">คลิกที่รูป เพื่อแทรกรูปลงในข้อความ</font> </td>
      </tr>
    </table></td>
    </tr>
  <?php if($X[c_pic] == "Y"){  ?>
                    
  <?php } ?>
  
  <tr bgcolor="#FFFFFF">
    <td height="30" align="center" background="mainpic/bg_webboard.gif"><input type="submit" name="Submit" value="Submit" class="normaltxt">
      <input type="reset" name="Submit2" value="Reset" class="normaltxt">
      <input name="flag" type="hidden" id="flag" value="answer">
	  <input name="wcad" type="hidden" id="wcad" value="<?php echo $wcad; ?>">
	  <input name="wtid" type="hidden" id="wtid" value="<?php echo $wtid; ?>"></td>
    </tr>
</form>
</table>
<br>
	</DIV></td>
  </tr>
  <tr>
    <td height="10"><?php @include("com_bottom.php"); ?></td>
  </tr>
</table>

</body>
</html>
<script language="JavaScript">
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
}
</script>
<script language="JavaScript">
function setURL()
{
	var temp = window.prompt('ใส่ URL ที่คุณต้องการสร้างเป็นลิงค์','http://'); 
	if(temp) 
	setsmile('[url]'+temp+'[/url]');
}

function setImage()
{
	var i =0;
	var temp_c = 0;
	var temp = window.prompt('ใส่ URL ของรูปที่คุณต้องการให้แสดงในกระทู้ของคุณ','http://'); 
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
		alert("ไฟล์รูปที่ท่านเลือก ระบบไม่อนุญาติให้ใช้กรุณาเลือกใหม่อีกครั้ง!!!!!!");
		setsmile('');
		}
	}else{
	setsmile('[img]'+temp+'[/img]');
	}
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
