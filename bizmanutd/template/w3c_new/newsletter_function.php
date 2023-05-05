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
	include("ewt_template.php");
	
	function random_codex($len){
srand((double)microtime()*10000000);
$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
$ret_str = "";
$num = strlen($chars);
for($i=0;$i<$len;$i++){
$ret_str .= $chars[rand()%$num];
}
return $ret_str;
}
	
	$langn_email_valid = "กรุณาระบุอีเมล์ของท่าน";
$langn_email_format = "รูปแบบของอีเมล์ไม่ถูกต้อง";
$langn_cancel_confirm = "คุณต้องการยกเลิกการรับข้อมูลจากทางเรา ?";
$langn_cancelemail_confirm = "กรุณายืนยันการยกเลิกของท่าน<br>โดยทำการยืนยันผ่านอีเมล์ที่เราส่งไปให้";
$langn_email_notfound = "อีเมล์ของท่านไม่มีอยู่ในระบบ";
$langn_select_group = "เลือกกลุ่มข่าวที่คุณต้องการรับ";   //question
$langn_cannot_insert = "ไม่สามารถเพิ่มข้อมูลได้";
$langn_choose_group = "กรุณาเลือกกลุ่มที่ท่านต้องการ";   //alert
$langn_finish_insert = "ระบบบันทึกข้อมูลเรียบร้อยแล้ว<br> คุณจะได้รับอีเมล์ตอบกลับเพื่อให้คุณยืนยันการลงทะเบียน";
$langn_update_success = "แก้ไขข้อมูลของคุณเรียบร้อยแล้ว";
$langn_not_regis = "คุณยังไม่ได้ทำการยืนยันการลงทะเบียน<br>กรุณาเช็ครหัสผ่านจากอีเมล์ของท่านและทำการยืนยันการลงทะเบียน";
$langn_thank_for_regis = "ขอบคุณสำหรับการลงทะเบียน";
$langn_alert_regis_done = "อีเมล์ของท่านได้รับการยืนยันการลงทะเบียนแล้ว";
$langn_email_password_error = "อีเมล์หรือรหัสผ่านไม่ถูกต้อง กรุณาลองอีกครั้ง";
$langn_confirm_regis = "ยืนยันการลงทะเบียน";
$langn_email = "อีเมล์";
$langn_password = "รหัสผ่าน";
$langn_password_valid = "กรุณากรอกรหัสผ่าน";
$langn_delete_email_success = "อีเมล์ของคุณถูกลบออกจากระบบแล้ว";

// for send email to member

$langn_subject_confirm_unregistered = "กรุณายืนยันการยกเลิกรับข่าวสาร";
$langn_body_confirm_un = "ยืนยันการยกเลิก";
$langn_body_confirm_click = "หากต้องการที่จะยกเลิกการรับข่าวสาร กรุณาคลิกที่นี่";

$langn_subject_thanks_regis = "ขอบคุณสำหรับการลงทะเบียน";
$langn_head_thanks_regis = "ขอบคุณสำหรับการลงทะเบียน";
$langn_body_password_regis = "รหัสลงทะเบียนของท่าน : ";
$langn_body_clickto_regis = "กรุณาตรวจสอบและยืนยันการลงทะเบียน โดยการคลิกที่นี่";


$NLTTBW = "160";
$NLTHeadH = "25";
$NLTHeadP = "";
$NLTHeadBG = '#EEEEEE';
$NLTHeadT = "ข่าวสาร";
$NLTHeadF = "MS Sans Serif";
$NLTHeadS = "2";
$NLTHeadBGTC = '#333333';
$NLTHeadB = "Y";
$NLTHeadI = "";
$NLTBodyBG = '';
$NLTBodyP = "";
$NLTBodyTD = "สมัครรับข่าวสาร";
$NLTBodyTA = "สมัคร";
$NLTBodyTC = "ยกเลิก";
$NLTBodyTS = "ตกลง";
$NLTBodyTL = "TH";
$NLTBodyF = "MS Sans Serif";
$NLTBodyS = "1";
$NLTBodyBGT = '#FFFFFF';
$NLTBodyB = "";
$NLTBodyI = "";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
<?php include("ewt_script.php");?>
</head>

<body <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?>>
<table <?php if($F["d_site_width"] != ""){ echo "width=\"".$F["d_site_width"]."\""; } ?> border="0" cellpadding="0" cellspacing="0" <?php if($F["d_site_align"] != ""){ echo "align=\"".$F["d_site_align"]."\""; } ?>>
  <tr>
    <td  <?php if($F["d_top_height"] != ""){ echo "height=\"".$F["d_top_height"]."\""; } ?> <?php  if($F["d_top_bg_c"] != ""){ echo "bgcolor=\"".$F["d_top_bg_c"]."\""; } ?>  colspan="3" >
	  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
	</td>
  </tr>
  <tr>
    <td  valign="top"  <?php if($F["d_site_left"] != ""){ echo "width=\"".$F["d_site_left"]."\""; } ?> <?php  if($F["d_left_bg_c"] != ""){ echo "bgcolor=\"".$F["d_left_bg_c"]."\""; } ?>>
	  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
	</td>
    <td height="160"  valign="top"  <?php if($F["d_site_content"] != ""){ echo "width=\"".$F["d_site_content"]."\""; } ?> <?php  if($F["d_body_bg_c"] != ""){ echo "bgcolor=\"".$F["d_body_bg_c"]."\""; } ?>>
	<?php
			$mainwidth = $F["d_site_content"];
			?>
			
			<?php
if($applynewsletter == "N"){  
	if(($newsletteremail != "")and($newsletteremailpass != "")){
	$Sel = $db->query("SELECT * FROM n_member WHERE m_email = '$newsletteremail' AND m_reg = '$newsletteremailpass'");
			if($rows = mysql_num_rows($Sel)){
			$R = $db->db_fetch_array($Sel);
					$del = "delete from n_member where m_id = '$R[m_id]'";
					$r = $db->query($del);
					$del1 = "delete from n_group_member where m_id = '$R[m_id]'";
					$r1 = $db->query($del1);
			$MsgNewsletter = $langn_delete_email_success;		
			}else{
			$MsgNewsletter = $langn_email_notfound;
			} 
		}else{
		$Sel = $db->query("SELECT * FROM n_member WHERE m_email = '$newsletteremail'");
				if($rows = mysql_num_rows($Sel)){
				$R = $db->db_fetch_array($Sel);
				$thisurl = "http://";
					if($SERVER_NAME){
					$thisurl .= $SERVER_NAME;
					}elseif($HTTP_SERVER_VARS['HTTP_HOST']){
					$thisurl .= $HTTP_SERVER_VARS['HTTP_HOST'];
					}
					if($SCRIPT_NAME){
					$thisurl .= $SCRIPT_NAME;
					}elseif($PHP_SELF){
					$thisurl .= $PHP_SELF;
					}
				include('../lib/libmail.php');
				$m = new Mail();
				$m->From($mynameconfig."<".$myemailconfig.">");
				$m->Subject($langn_subject_confirm_unregistered);
				$bodytemp ="
				<table width='400' border='1' align='center' cellpadding='3' cellspacing='2' >
				  <tr>
					<td height='35' align='center' bgcolor='#FFCC00'><p><font size='2' face='MS Sans Serif, Tahoma, sans-serif'><strong>".$langn_body_confirm_un."</strong></font></p></td>
				  </tr>
				  <tr>
					<td align='center' bgcolor='#003399'>
					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
								<tr>
						  <td height='10' align='right'></td>
						</tr>
					  </table>
							<strong>
					  <a href='".$thisurl."?t=".$_REQUEST[t]."&applynewsletter=N&newsletteremail=".trim($newsletteremail)."&newsletteremailpass=".$R[m_reg]."' target='_blank'><font color='#FFFF00' size='1' face='MS Sans Serif, Tahoma, sans-serif'>".$langn_body_confirm_click."</font></a></strong>      
							<table width='100%' border='0' cellspacing='0' cellpadding='0'>
								<tr>
						  <td height='10' align='right'></td>
						</tr>
					  </table></td>
				  </tr>
				</table>
				";
				
				$sss="<a href='".$thisurl."?t=".$_REQUEST[t]."&applynewsletter=N&newsletteremail=".trim($newsletteremail)."&newsletteremailpass=".$R[m_reg]."' target='_blank'><font color='#FFFF00' size='1' face='MS Sans Serif, Tahoma, sans-serif'>".$langn_body_confirm_click."</font></a>";
				$m->Body($bodytemp,"text/html");
				$m->To(trim($newsletteremail));
				@$m->Send();
				$MsgNewsletter = $langn_cancelemail_confirm;
				}else{
				$MsgNewsletter = $langn_email_notfound;
				}
		}
	?>
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  bgcolor="#FFFFCC"  >
	  <tr>
		<td align="center" height="70" ><?php echo $MsgNewsletter; ?></td>
	  </tr>
	</table>
	<?php
	}elseif($applynewsletter == "Y"){
	$Sel = $db->query("SELECT * FROM n_group inner join article_group on article_group.c_id = g_name  ORDER BY g_name ");
	$Sel3 = $db->query("select n_member.m_id from n_member inner join n_group_member on n_member.m_id = n_group_member.m_id ");
	if(mysql_num_rows($Sel3) == 0){
		$Flag = "Add";
	}else if(mysql_num_rows($Sel3) > 0){
		$Flag = "Edit";
	}
	$R=$db->db_fetch_array($Sel3);
	$Sel1 = $db->query("SELECT * FROM n_member WHERE m_email = '$newsletteremail' and m_active='N'");
	if($rows = mysql_num_rows($Sel1)){
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	?>
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  bgcolor="#FFFFCC" >
	  <tr>
		<td align="center" height="70" >อีเมล์ : <?php echo $newsletteremail; ?> มีในระบบแล้ว</td>
	  </tr>
	</table>
	<?php
	}else{

	 ?>
	   <form name="NewsLetterFormSubmit" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" onSubmit="return ChkValueNewsLetterSubmit();">
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1" >
	  <tr>
	  <td style="border:dashed 1px;"><?php echo $langn_select_group?></td>
	  </tr>
	  <?php 
	  $i=0;
	  ?>
	  <tr>
		<td height="70">
		   <table width="100%" border="0">
	  <?php
	  while($RR=$db->db_fetch_array($Sel)){ 
	  $Sel2 = $db->query("SELECT * FROM n_group_member WHERE m_id = '$R[m_id]'  AND g_id ='$RR[g_id]'");
	$rowy = mysql_num_rows($Sel2);
	  ?>
	  <tr>
		<td >
		<font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>">
		<input type="checkbox" name="gp<?php echo $i; ?>" value="<?php echo $RR[g_id]; ?>" <?php if($rowy>0){ echo "checked"; } ?>> <?php echo $RR[c_name]; ?></span></font></td>
	  </tr>
	  <?php 
	  $i++;
	} 
	?>
	</table>
	</td>
	</tr>
	  <tr>
		<td  style="border:dashed 1px;"><input name="m_active" type="hidden" id="m_active" value="<?php echo $R[m_active]; ?>">    <input name="newsletteremail" type="hidden" id="newsletteremail" value="<?php echo $newsletteremail; ?>">
		<input name="Flag" type="hidden" id="Flag" value="<?php echo $Flag; ?>">      <input name="applynewsletter" type="hidden" id="applynewsletter" value="A">      <input name="memid" type="hidden" id="memid" value="<?php echo $R[m_id]; ?>">      <input name="allgroup" type="hidden" id="allgroup" value="<?php echo $i; ?>">
		  <input name="t" type="hidden" id="t" value="<?php echo $_POST[t]; ?>">
		  <input type="submit" name="Submit" value="Submit"></td>
	  </tr>
	
	</table>	
		  </form>
		   <script language="JavaScript"  type="text/javascript">
	function ChkValueNewsLetterSubmit(){
	for(i=0;i<document.NewsLetterFormSubmit.allgroup.value;i++){
	if(document.NewsLetterFormSubmit.elements["gp"+i].checked){
	var c =1;
	}
	}
	if(c != 1){
	alert("<?php echo $langn_choose_group; ?>");
	return false;
	}
	}
	</script>
	<?php }
	
	}elseif($applynewsletter == "A"){ 
	$Sel = $db->query("SELECT * FROM n_member WHERE m_email = '$newsletteremail'  ");
	$MV = $db->db_fetch_array($Sel);
	$m_active = $MV[m_active];
if($Flag=="Add"){

if($rows = mysql_num_rows($Sel)){ ?>
<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  >
  <tr>
    <td align="center" height="70" ><?php echo $langn_cannot_insert; ?></td>
  </tr>
</table>
<?php
 }else{
$Randompassword = random_codex(8);
//echo $Randompassword;
$SQL = $db->query("insert into n_member ( `m_id` , `m_email` , `m_active` , `m_reg` , `m_date` ) VALUES ('','$newsletteremail','','$Randompassword',NOW( ))");
//echo $HTTP_REFERER;
$Sel1 = $db->query("SELECT m_id FROM n_member WHERE m_email = '$newsletteremail'");
$R = $db->db_fetch_array($Sel1);
for($i=0;$i<$allgroup;$i++){
$gp = "gp".$i;
$gp = $$gp;
if($gp != ""){
$INS = $db->query("INSERT INTO n_group_member ( m_id , g_id ) VALUES ( '$R[m_id]','$gp' )");
}
}
include('../lib/libmail.php');
$m = new Mail();
$m->From($mynameconfig."<".$myemailconfig.">");
$m->Subject($langn_subject_thanks_regis);
$bodytemplate = "
<table width='400' border='1' align='center' cellpadding='3' cellspacing='2' >
  <tr>
    <td height='35' align='center' bgcolor='#FFCC00'><p><font size='2' face='MS Sans Serif, Tahoma, sans-serif'><strong>".$langn_head_thanks_regis."</strong></font></p></td>
  </tr>
  <tr>
    <td align='center' bgcolor='#003399'>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		        <tr>
          <td height='10' align='right'></td>
        </tr>
      </table>
	        <strong><br>
	        <a href='".$HTTP_REFERER."&usernewsletter=".$newsletteremail."&t=".$_REQUEST[t]."&passnewsletter=".$Randompassword."' target='_blank'><font color='#FFFF00' size='1' face='MS Sans Serif, Tahoma, sans-serif'>".$langn_body_clickto_regis."</font></a></strong>       
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
		        <tr>
          <td height='10' align='right'></td>
        </tr>
      </table></td>
  </tr>
</table>
";
$m->Body($bodytemplate,"text/html");
$m->To(trim($newsletteremail));
@$m->Send();
?>
<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"   >
  <tr>
    <td align="center" height="70"  ><?php echo $langn_finish_insert; ?></td>
  </tr>
</table>
<?php
}
}elseif($Flag=="Edit"){
$SSL = $db->query("DELETE FROM n_group_member WHERE m_id = '$memid'");
for($i=0;$i<$allgroup;$i++){
$gp = "gp".$i;
$gp = $$gp;
if($gp != ""){
$INS = $db->query("INSERT INTO n_group_member ( m_id , g_id ) VALUES ( '$memid','$gp' )");
}
}
?>
<table width="85%" border="1" align="center" cellpadding="3" cellspacing="2" >
  <tr>
    <td height="50" align="center" bgcolor="<?php echo $NLTBodyBG; ?>"><?php echo $langn_update_success; ?><br>
	<?php if($m_active != "Y"){ ?>
	<hr color="#FFFFFF"><?php echo $langn_not_regis; ?><?php } ?>
    </td>
  </tr>
</table>
<?php
}
 }else{ 
 if(($usernewsletter != "")and($passnewsletter !="")){
 $Sel3 = $db->query("SELECT * FROM n_member WHERE m_email = '$usernewsletter' AND m_reg = '$passnewsletter'");
if($row1 = mysql_num_rows($Sel3)){
$RS = $db->db_fetch_array($Sel3);
if($RS[m_active]==""){ 
$UpDATENews = $db->query("UPDATE n_member SET m_active = 'Y' WHERE m_email = '$usernewsletter' AND m_reg = '$passnewsletter'");
?>
<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1" >
  <tr>
    <td align="center" height="70" ><?php echo $langn_thank_for_regis; ?></td>
  </tr>
</table>
<?php
}else{ ?>
<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  >
  <tr>
    <td align="center" height="70" ><?php echo $langn_alert_regis_done; ?></td>
  </tr>
</table>
<?php }
}else{ ?>
  <form name="NewsLetterFormSubmit" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" onSubmit="return ChkValueNewsLetterSubmit();">
<table width="85%" border="1" align="center" cellpadding="3" cellspacing="2" >

  <tr>
    <td height="35" align="center" bgcolor="<?php echo $NLTHeadBG; ?>"><font face="<?php echo $NLTHeadF; ?>" color="<?php echo $NLTHeadBGTC; ?>" size="<?php echo $NLTHeadS; ?>"><span style="<?php if($NLTHeadB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTHeadI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $langn_email_password_error; ?><br>
      <?php echo $langn_confirm_regis; ?></span></font></td>
  </tr>
  <tr>
    <td align="center" bgcolor="<?php echo $NLTBodyBG; ?>">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		        <tr>
          <td height="10" align="right"></td>
        </tr>
      </table>     
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
          <td width="33%" height="5" align="right"><font face="<?php echo $NLTBodyF; ?>" color="<?php echo $NLTBodyBGT; ?>" size="<?php echo $NLTBodyS; ?>"><span style="<?php if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $langn_email; ?></span></font>&nbsp;
			</td>
          <td width="67%" align="left"><input name="usernewsletter" type="text" id="usernewsletter"></td>
          </tr>
	          <tr>
	            <td height="5" align="right"><font face="<?php echo $NLTBodyF; ?>" color="<?php echo $NLTBodyBGT; ?>" size="<?php echo $NLTBodyS; ?>"><span style="<?php if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $langn_password; ?></span></font>&nbsp;</td>
                <td align="left"><input name="passnewsletter" type="text" id="passnewsletter"></td>
          </tr>
        <tr>
          <td height="10" align="right"><div align="center">
            </div></td>
          <td height="10" align="left"><input type="submit" name="Submit2" value="Submit">
            <input type="reset" name="Submit3" value="Reset"></td>
        </tr>
		        <tr>
          <td height="10" colspan="2" align="right"></td>
        </tr>
      </table></td>
  </tr>
</table></form>
 <script language="JavaScript"  type="text/javascript">
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
	}
function validEMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			//return false;
			if (mailObj.value.search("^.+@.+\\..+$") != -1)
				return true;
			else return false;
 		}
		return true;
	}
function ChkValueNewsLetterSubmit(){
if(document.NewsLetterFormSubmit.usernewsletter.value == ""){
alert('<?php echo $langn_email_valid; ?>');
document.NewsLetterFormSubmit.usernewsletter.focus();
return false;
}else if(!validEMail(document.NewsLetterFormSubmit.usernewsletter)){
alert('<?php echo $langn_email_format; ?>');
document.NewsLetterFormSubmit.usernewsletter.select();
return false;
}else if(document.NewsLetterFormSubmit.passnewsletter.value == ""){
alert('<?php echo $langn_password_valid; ?>');
document.NewsLetterFormSubmit.passnewsletter.focus();
return false;
}
}
</script>
<?php }
 }else{
 ?>
   <form name="NewsLetterFormSubmit" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" onSubmit="return ChkValueNewsLetterSubmit();">
 <table width="90%" border="1" align="center" cellpadding="3" cellspacing="2" >

  <tr>
    <td height="35" align="center" bgcolor="<?php echo $NLTHeadBG; ?>"><font face="<?php echo $NLTHeadF; ?>" color="<?php echo $NLTHeadBGTC; ?>" size="<?php echo $NLTHeadS; ?>"><span style="<?php if($NLTHeadB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTHeadI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $langn_confirm_regis; ?></span></font></td>
  </tr>
  <tr>
    <td align="center" bgcolor="<?php echo $NLTBodyBG; ?>">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		        <tr>
          <td height="10" align="right"></td>
        </tr>
      </table>     
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
          <td width="33%" height="5" align="right"><font face="<?php echo $NLTBodyF; ?>" color="<?php echo $NLTBodyBGT; ?>" size="<?php echo $NLTBodyS; ?>"><span style="<?php if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $langn_email; ?></span></font>&nbsp;
			</td>
          <td width="67%" align="left"><input name="usernewsletter" type="text" id="usernewsletter"></td>
          </tr>
	          <tr>
	            <td height="5" align="right"><font face="<?php echo $NLTBodyF; ?>" color="<?php echo $NLTBodyBGT; ?>" size="<?php echo $NLTBodyS; ?>"><span style="<?php if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $langn_password; ?></span></font>&nbsp;</td>
                <td align="left"><input name="passnewsletter" type="text" id="passnewsletter"></td>
          </tr>
        <tr>
          <td height="10" align="right"><div align="center">
            </div></td>
          <td height="10" align="left"><input type="submit" name="Submit2" value="Submit">
            <input type="reset" name="Submit3" value="Reset"></td>
        </tr>
		        <tr>
          <td height="10" colspan="2" align="right"></td>
        </tr>
      </table></td>
  </tr>
</table></form>
 <script language="JavaScript"  type="text/javascript">
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
	}
function validEMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			//return false;
			if (mailObj.value.search("^.+@.+\\..+$") != -1)
				return true;
			else return false;
 		}
		return true;
	}
function ChkValueNewsLetterSubmit(){
if(document.NewsLetterFormSubmit.usernewsletter.value == ""){
alert('<?php echo $langn_email_valid; ?>');
document.NewsLetterFormSubmit.usernewsletter.focus();
return false;
}else if(!validEMail(document.NewsLetterFormSubmit.usernewsletter)){
alert('<?php echo $langn_email_format; ?>');
document.NewsLetterFormSubmit.usernewsletter.select();
return false;
}else if(document.NewsLetterFormSubmit.passnewsletter.value == ""){
alert('<?php echo $langn_password_valid; ?>');
document.NewsLetterFormSubmit.passnewsletter.focus();
return false;
}
}
</script>
 <?php }
  }
?>		
			
			
			
			
	
	</td>
    <td  valign="top"  <?php if($F["d_site_right"] != ""){ echo "width=\"".$F["d_site_right"]."\""; } ?> <?php  if($F["d_right_bg_c"] != ""){ echo "bgcolor=\"".$F["d_right_bg_c"]."\""; } ?>>	 
	 <?php
			$mainwidth =  $F["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?></td>
  </tr>
  
<tr valign="top" > 
          <td  colspan="3"  valign="top"  <?php if($F["d_bottom_height"] != ""){ echo "height=\"".$F["d_bottom_height"]."\""; } ?> <?php  if($F["d_bottom_bg_c"] != ""){ echo "bgcolor=\"".$F["d_bottom_bg_c"]."\""; } ?> <?php if($F["d_bottom_bg_p"] != ""){ echo "background=\"".$F["d_bottom_bg_p"]."\""; } ?>>	 
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
</table>
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</body>
</html>
<?php $db->db_close(); ?>