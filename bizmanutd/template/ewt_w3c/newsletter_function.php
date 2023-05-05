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
	$db->access=200;
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
	
@include("../language/language".$lang_sh.".php");

$mynameconfig = "Webmaster Parliament";
$myemailconfig = "webmaster@parliament.go.th";

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
<?php echo $template_design[0];?>
<?php
			$mainwidth = $F["d_site_content"];
			?>
			
			<?php
if($applynewsletter == "N"){  
	if(($newsletteremail != "")and($newsletteremailpass != "")){
	$Sel = $db->query("SELECT * FROM n_member WHERE m_email = '$newsletteremail' AND m_reg = '$newsletteremailpass'");
			if($rows = mysql_num_rows($Sel)){
			$R = mysql_fetch_array($Sel);
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
				$R = mysql_fetch_array($Sel);
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
				include('../lib/libmail2.php');
				$m = new Mail();
				$m->From($mynameconfig."<".$myemailconfig.">");
				//$m->Subject($langn_subject_confirm_unregistered);
				$m->Subject((iconv('UTF-8','UTF-8',$langn_subject_confirm_unregistered)));
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
					  <a href='".$thisurl."?t=".$_REQUEST[t]."&applynewsletter=N&newsletteremail=".trim($newsletteremail)."&newsletteremailpass=".$R[m_reg]."' target='_blank' accesskey=a><font color='#FFFF00' size='1' face='MS Sans Serif, Tahoma, sans-serif'>".$langn_body_confirm_click."</font></a></strong>      
							<table width='100%' border='0' cellspacing='0' cellpadding='0'>
								<tr>
						  <td height='10' align='right'></td>
						</tr>
					  </table></td>
				  </tr>
				</table>
				";
				
				$sss="<a href='".$thisurl."?t=".$_REQUEST[t]."&applynewsletter=N&newsletteremail=".trim($newsletteremail)."&newsletteremailpass=".$R[m_reg]."' target='_blank' accesskey=b><font color='#FFFF00' size='1' face='MS Sans Serif, Tahoma, sans-serif'>".$langn_body_confirm_click."</font></a>";
				$m->Body($bodytemp,"UTF-8");
			//	$m->Body((iconv('UTF-8','UTF-8',$bodytemp));
				$m->To(trim($newsletteremail));
				@$m->Send();
				$MsgNewsletter = $langn_cancelemail_confirm;
				}else{
				$MsgNewsletter = $langn_email_notfound;

				}
		}
	?>
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"   >
	  <tr>
		<td align="center" height="70" ><? echo $MsgNewsletter; ?></td>
	  </tr>
	</table>
	<?
}elseif($applynewsletter == "Y"){
	
	$db->query("USE ".$EWT_DB_USER);
	$sqlM ="select emp_type_status from emp_type where emp_type_id='".$_SESSION["EWT_TYPE_ID"]."'";
	$queryM = $db->query($sqlM);
	$RM = $db->db_fetch_array($queryM);
	$type_emp = $RM[emp_type_status];
	$db->query("USE ".$EWT_DB_NAME);
	if($type_emp != "2"){
	$whM = " where n_group.g2='2'";
	$whM2 = " and n_group.g2='2'";
	}
	if($lang_sh != ''){
	$lang_shw = explode('_',$lang_sh);
	$Sel = $db->query("select * from  article_group,lang_article_group,lang_config,n_group where lang_article_group.c_id =article_group.c_id  AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw[1]."' AND  article_group.c_id = g_name $whM2 ORDER BY g_name  ");
	}else{
	$Sel = $db->query("SELECT * FROM n_group inner join article_group on article_group.c_id = g_name $whM ORDER BY g_name ");
	}
	//echo "SELECT * FROM n_group inner join article_group on article_group.c_id = g_name $whM ORDER BY g_name ";
	$Sel3 = $db->query("select n_member.m_id from n_member inner join n_group_member on n_member.m_id = n_group_member.m_id  and m_email = '$newsletteremail' ");
	if(mysql_num_rows($Sel3) == 0){
		$Flag = "Add";
	}else if(mysql_num_rows($Sel3) > 0){
		$Flag = "Edit";
	}
	$R=mysql_fetch_array($Sel3);

	$Sel1 = $db->query("SELECT * FROM n_member WHERE m_email = '$newsletteremail' and (m_active='N' or m_active=' ')");
	if($rows = mysql_num_rows($Sel1)){
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	?>
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  >
	  <tr>
		<td align="center" height="70" >Email: <? echo $newsletteremail; ?> <?php echo $langn_email_notfound;?></td>
	  </tr>
	</table>
	<?php
	}else{

	 ?>
	   <form name="NewsLetterFormSubmit" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" onSubmit="return ChkValueNewsLetterSubmit();">
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1" >
	  <tr>
	  <td style="border:dashed 1px;"><? echo $langn_select_group?></td>
	  </tr>
	  <? 
	  $i=0;
	  ?>
	  <tr>
		<td height="70">
		   <table width="100%" border="0">
	  <?php
	  while($RR=mysql_fetch_array($Sel)){ 
					  if($lang_sh!= ''){
						$RR[c_name] = $RR[lang_detail];
						}
	  $Sel2 = $db->query("SELECT * FROM n_group_member WHERE m_id = '$R[m_id]'  AND g_id ='$RR[g_id]'");
	$rowy = mysql_num_rows($Sel2);
	  ?>
	  <tr>
		<td >
		<font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>">
		<input type="checkbox" name="gp<? echo $i; ?>" value="<? echo $RR[g_id]; ?>" <? if($rowy>0){ echo "checked"; } ?>> <? echo $RR[c_name]; ?></span></font></td>
	  </tr>
	  <? 
	  $i++;
	} 
	?>
	</table>
	</td>
	</tr>
	  <tr>
		<td  style="border:dashed 1px;"><input name="m_active" type="hidden" id="m_active" value="<? echo $R[m_active]; ?>">    <input name="newsletteremail" type="hidden" id="newsletteremail" value="<? echo $newsletteremail; ?>">
		<input name="Flag" type="hidden" id="Flag" value="<? echo $Flag; ?>">      <input name="applynewsletter" type="hidden" id="applynewsletter" value="A">      <input name="memid" type="hidden" id="memid" value="<? echo $R[m_id]; ?>">      <input name="allgroup" type="hidden" id="allgroup" value="<? echo $i; ?>">
		  <input name="t" type="hidden" id="t" value="<? echo $_POST[t]; ?>">
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
	alert("<? echo $langn_choose_group; ?>");
	return false;
	}
	}
	</script>
	<? }
	
}elseif($applynewsletter == "A"){ 
	$Sel = $db->query("SELECT * FROM n_member WHERE m_email = '$newsletteremail'  ");
	$MV = $db->db_fetch_array($Sel);
	$m_active = $MV[m_active];
if($Flag=="Add"){

	if($rows = mysql_num_rows($Sel)){ ?>
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  >
	  <tr>
		<td align="center" height="70" ><? echo $langn_cannot_insert; ?></td>
	  </tr>
	</table>
	<?
	 }else{
	$Randompassword = random_codex(8);
	//echo $Randompassword;
	$SQL = $db->query("insert into n_member ( `m_id` , `m_email` , `m_active` , `m_reg` , `m_date` ) VALUES ('','$newsletteremail','N','$Randompassword',NOW( ))");
	//echo $HTTP_REFERER;
	$Sel1 = $db->query("SELECT m_id FROM n_member WHERE m_email = '$newsletteremail'");
	$R = mysql_fetch_array($Sel1);
	for($i=0;$i<$allgroup;$i++){
	$gp = "gp".$i;
	$gp = $$gp;
	if($gp != ""){
	$INS = $db->query("INSERT INTO n_group_member ( m_id , g_id ) VALUES ( '$R[m_id]','$gp' )");
	}
	}
	include('../lib/libmail2.php');
	$m = new Mail();
	$m->From($mynameconfig."<".$myemailconfig.">");
	//$m->Subject($langn_subject_thanks_regis);
	$m->Subject((iconv('UTF-8','UTF-8',$langn_subject_thanks_regis)));
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
				<a href='".$HTTP_REFERER."&usernewsletter=".$newsletteremail."&t=".$_REQUEST[t]."&passnewsletter=".$Randompassword."' target='_blank' accesskey=c><font color='#FFFF00' size='1' face='MS Sans Serif, Tahoma, sans-serif'>".$langn_body_clickto_regis."</font></a></strong>       
		  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
			  <td height='10' align='right'></td>
			</tr>
		  </table></td>
	  </tr>
	</table>
	";
	$m->Body($bodytemplate,"UTF-8");
	//$m->Body((iconv('UTF-8','UTF-8',$bodytemplate));
	$m->To(trim($newsletteremail));
	@$m->Send();
	?>
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"   >
	  <tr>
		<td align="center" height="70"  ><? echo $langn_finish_insert; ?></td>
	  </tr>
	</table>
	<?
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
    <td height="50" align="center" bgcolor="<? echo $NLTBodyBG; ?>"><? echo $langn_update_success; ?><br>
	<? if($m_active != "Y"){ ?>
	<hr color="#FFFFFF"><? echo $langn_not_regis; ?><? } ?>
    </td>
  </tr>
</table>
<?
}
 }else{ //appY
		 if(($usernewsletter != "")and($passnewsletter !="")){
		 $Sel3 = $db->query("SELECT * FROM n_member WHERE m_email = '$usernewsletter' AND m_reg = '$passnewsletter'");
			if($row1 = mysql_num_rows($Sel3)){
			$RS = mysql_fetch_array($Sel3);
			if($RS[m_active]=="N"){ 
			$UpDATENews = $db->query("UPDATE n_member SET m_active = 'Y' WHERE m_email = '$usernewsletter' AND m_reg = '$passnewsletter'");
			?>
			<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1" >
			  <tr>
				<td align="center" height="70" ><? echo $langn_thank_for_regis; ?></td>
			  </tr>
			</table>
			<?
			}else{ ?>
			<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  >
			  <tr>
				<td align="center" height="70" ><? echo $langn_alert_regis_done; ?></td>
			  </tr>
			</table>
			<? }
			}else{ ?>
		  <form name="NewsLetterFormSubmit" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" onSubmit="return ChkValueNewsLetterSubmit();">
		<table width="85%" border="1" align="center" cellpadding="3" cellspacing="2" >
		
		  <tr>
			<td height="35" align="center" bgcolor="<? echo $NLTHeadBG; ?>"><font face="<? echo $NLTHeadF; ?>" color="<? echo $NLTHeadBGTC; ?>" size="<? echo $NLTHeadS; ?>"><span style="<?php if($NLTHeadB=="Y"){ echo "font-Weight:bold"; } ?>;<? if($NLTHeadI=="Y"){ echo "font-Style:italic"; } ?>"><? echo $langn_email_password_error; ?><br>
			  <? echo $langn_confirm_regis; ?></span></font></td>
		  </tr>
		  <tr>
			<td align="center" bgcolor="<? echo $NLTBodyBG; ?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
				  <td height="10" align="right"></td>
				</tr>
			  </table>     
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
				  <td width="33%" height="5" align="right"><font face="<? echo $NLTBodyF; ?>" color="<? echo $NLTBodyBGT; ?>" size="<? echo $NLTBodyS; ?>"><span style="<?php if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<? if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><? echo $langn_email; ?></span></font>&nbsp;
					</td>
				  <td width="67%" align="left"><input name="usernewsletter" type="text" id="usernewsletter"></td>
				  </tr>
					  <tr>
						<td height="5" align="right"><font face="<? echo $NLTBodyF; ?>" color="<? echo $NLTBodyBGT; ?>" size="<? echo $NLTBodyS; ?>"><span style="<? if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<? if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><? echo $langn_password; ?></span></font>&nbsp;</td>
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
		alert('<? echo $langn_email_valid; ?>');
		document.NewsLetterFormSubmit.usernewsletter.focus();
		return false;
		}else if(!validEMail(document.NewsLetterFormSubmit.usernewsletter)){
		alert('<? echo $langn_email_format; ?>');
		document.NewsLetterFormSubmit.usernewsletter.select();
		return false;
		}else if(document.NewsLetterFormSubmit.passnewsletter.value == ""){
		alert('<? echo $langn_password_valid; ?>');
		document.NewsLetterFormSubmit.passnewsletter.focus();
		return false;
		}
		}
		</script>
		<? }
		 }else{
		 ?>
		   <form name="NewsLetterFormSubmit" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" onSubmit="return ChkValueNewsLetterSubmit();">
		 <table width="90%" border="1" align="center" cellpadding="3" cellspacing="2" >
		
		  <tr>
			<td height="35" align="center" bgcolor="<? echo $NLTHeadBG; ?>"><font face="<? echo $NLTHeadF; ?>" color="<? echo $NLTHeadBGTC; ?>" size="<? echo $NLTHeadS; ?>"><span style="<? if($NLTHeadB=="Y"){ echo "font-Weight:bold"; } ?>;<? if($NLTHeadI=="Y"){ echo "font-Style:italic"; } ?>"><? echo $langn_confirm_regis; ?></span></font></td>
		  </tr>
		  <tr>
			<td align="center" bgcolor="<? echo $NLTBodyBG; ?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
				  <td height="10" align="right"></td>
				</tr>
			  </table>     
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
				  <td width="33%" height="5" align="right"><font face="<? echo $NLTBodyF; ?>" color="<? echo $NLTBodyBGT; ?>" size="<? echo $NLTBodyS; ?>"><span style="<? if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<? if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><? echo $langn_email; ?></span></font>&nbsp;
					</td>
				  <td width="67%" align="left"><input name="usernewsletter" type="text" id="usernewsletter"></td>
				  </tr>
					  <tr>
						<td height="5" align="right"><font face="<? echo $NLTBodyF; ?>" color="<? echo $NLTBodyBGT; ?>" size="<? echo $NLTBodyS; ?>"><span style="<? if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<? if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><? echo $langn_password; ?></span></font>&nbsp;</td>
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
		alert('<? echo $langn_email_valid; ?>');
		document.NewsLetterFormSubmit.usernewsletter.focus();
		return false;
		}else if(!validEMail(document.NewsLetterFormSubmit.usernewsletter)){
		alert('<? echo $langn_email_format; ?>');
		document.NewsLetterFormSubmit.usernewsletter.select();
		return false;
		}else if(document.NewsLetterFormSubmit.passnewsletter.value == ""){
		alert('<? echo $langn_password_valid; ?>');
		document.NewsLetterFormSubmit.passnewsletter.focus();
		return false;
		}
	}
	</script>
	 <? }
  }
?>		
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>