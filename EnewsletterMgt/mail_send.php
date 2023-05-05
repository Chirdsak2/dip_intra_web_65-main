<?php
//include("authority.php");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//include("../EWT_ADMIN/comtop.php");
//include("../language/banner_language.php");
include("lang_newsletter.php");

?>
<?php 
$db->write_log("view","enews","เข้าสู่ การจัดการส่ง mail");
?>
<html>
<head>
<title>Newsletter Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet"> 
<link href="../EWT_ADMIN/style.css" rel="stylesheet"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/backend_style.css"/>
</head>
<script  language="JavaScript">
function Mod(c,d,fr1,fr2){
if(document.form1.elements["att"+c].checked){
var ttt = parseFloat(document.form1.total.value)+parseFloat(d);
if(ttt < 1024000){
txt = parseFloat(ttt/1000);
fr1.style.backgroundColor = "#ECEBF0";
fr2.style.backgroundColor = "#ECEBF0";
document.form1.total.value = ttt;
document.form1.tot.value = txt + " KB.";
}else{
alert("<?php echo $lang_sendmail_alert_limit; ?>");
document.form1.elements["att"+c].checked = false;
}
}else{
fr1.style.backgroundColor = "#FFFFFF";
fr2.style.backgroundColor = "#FFFFFF";
var ttt = parseFloat(document.form1.total.value)-parseFloat(d);
txt = parseFloat(ttt/1000);
document.form1.total.value = ttt;
document.form1.tot.value = txt + " KB.";
}
}
function SelT(c){
if(c=="text/html"){
document.all.tb1.style.display = '';
document.all.tb2.style.display = 'none';
}else if(c=="text/plain"){
document.all.tb2.style.display = '';
document.all.tb1.style.display = 'none';
}
}
</script>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<br><br><br>
<?php include("../FavoritesMgt/favorites_include.php");?>
<div class="card-body">
<div class="row ">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
  <tr> 
    <td><!--<img src="../theme/main_theme/enews_function.gif" width="32" height="32" align="absmiddle" border="0"> 
      <span class="ewtfunction"><?php echo $text_genrss_modulesub_email;?></span>--> </td>
  </tr>
</table>
<!--<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genrss_modulesub_email);?>&module=newsletter&url=<?php echo urlencode("mail_send.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <hr>
    </td>
  </tr>
</table>-->
<table width="90%" align="center" class="table table-bordered">
          <form name="form1" method="post" action="sendmail.php" onSubmit="return ChkValue();">
          <tr bgcolor="B2B4BF" class="ewttablehead"> 
            <td height="27" colspan="2"><?php echo $lang_sendmail_head_text; ?>            </td>
            <td width="50%" height="27"><?php echo $lang_sendmail_attach; ?> </strong><?php echo $lang_sendmail_limit; ?>            </td>
            </tr>
<tr> 
      <td width="7%" valign="top" bgcolor="#FFFFFF"><?php echo $lang_sendmail_subject; ?></td>
      <td width="43%" valign="top" bgcolor="#FFFFFF"><input name="subject" type="text" id="subject" size="40" class="form-control"></td>
    <?php
$Sel1 = "select * from n_file order by f_name asc";
$Ex1 = $db->query($Sel1);
?>  
<td rowspan="4" align="center" valign="top" bgcolor="#FFFFFF">      
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <?php 
  $y=0;
  while($RR = $db->db_fetch_array($Ex1)){ ?>	
  <tr valign="top">
    <td width="74%" id="tbx<?php echo $y; ?>"><input type="checkbox" name="att<?php echo $y; ?>" value="<?php echo $RR[f_id]; ?>" onClick="Mod('<?php echo $y; ?>','<?php echo $RR[f_size]; ?>',<?php echo "document.all.tbx".$y; ?>,<?php echo "document.all.tby".$y; ?>);">&nbsp;<?php echo $RR[f_name]; ?>
      <input name="att_name<?php echo $y; ?>" type="hidden" id="att_name<?php echo $y; ?>" value="<?php echo $RR[f_name]; ?>">
      <input name="att_type<?php echo $y; ?>" type="hidden" id="att_type<?php echo $y; ?>" value="<?php echo $RR[f_type]; ?>">    </td>
    <td width="26%" align="right" id="tby<?php echo $y; ?>">(<?php echo number_format($RR[f_size]/1000,3)." KB."; ?>)</td>
    </tr><?php
  $y++;
   } ?>
</table>
	  </td>
</tr>
<tr>
  <td rowspan="2" valign="top" bgcolor="#FFFFFF"><?php echo $lang_sendmail_from; ?></td>
  <?php include($UserPath."enewsletter_email.dll"); ?>
  <td valign="top" bgcolor="#FFFFFF"><?php echo $lang_sendmail_name; ?>  <input name="from_name" type="text" id="from_name" value="<?php echo $mynameconfig; ?>" size="40" class="form-control"></td>
  </tr>
<tr>
  <td valign="top" bgcolor="#FFFFFF"><?php echo $lang_sendmail_email; ?>   <input name="from_email" type="text" id="from_email" value="<?php echo $myemailconfig; ?>" size="40" class="form-control"></td>
</tr>
<?php
$Sel = "select distinct(n_group.g_id),n_group.g_name,c_name from n_group,n_group_member,article_group where n_group.g_id = n_group_member.g_id and c_id = n_group.g_name  order by n_group.g_name asc";
$Ex = $db->query($Sel);
$RowNEWSGroup = $db->db_num_rows($Ex);
?>
<tr>
  <td rowspan="2" valign="top" bgcolor="#FFFFFF"><?php echo $lang_sendmail_to; ?></td>
  <td valign="top" bgcolor="#FFFFFF">
  <table width="100%" align="center" class="table table-bordered">
  <tr>
    <td bgcolor="B2B4BF"><input name="checkxxx" type="checkbox" id="checkxxx" onClick="checkAll();" value="checkbox">
      <?php echo $lang_sendmail_select; ?>
      <script language=javascript>
function checkAll(){
if(document.form1.checkxxx.checked){
	for(i=0;i<document.form1.allg.value;i++){
		document.form1.elements["tog"+i].checked = true;
	}
}else{
	for(i=0;i<document.form1.allg.value;i++){
		document.form1.elements["tog"+i].checked = false;
	}
}
}
      </script></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
  <?php
  $i=0;
   while($R = $db->db_fetch_array($Ex)){ ?>	
  <tr>
    <td><input name="tog<?php echo $i; ?>" type="checkbox" id="tog<?php echo $i; ?>" value="<?php echo $R[g_id]; ?>">&nbsp;<?php echo $R[c_name]; ?></td>
  </tr>
  <?php
  $i++;
   } ?>
</table>	</td>
  </tr>
</table>
      <input name="allg" type="hidden" id="allg" value="<?php echo $i; ?>">
      <input name="sendtosend" type="checkbox" id="sendtosend" value="Yes">
      <?php echo $lang_sendmail_send_to; ?><br>
      <input name="sendtoother" type="checkbox" id="sendtoother" value="Yes" onClick="ShowCus();">
<?php echo $lang_sendmail_custom; ?>
      <?php echo $lang_sendmail_explode; ?>
	   <script language=javascript>
function ShowCus(){
if(document.form1.sendtoother.checked){
document.all.shwc.style.display = '';
}else{
document.all.shwc.style.display = 'none';
}
}
      </script></td>
  </tr>
  <tr bgcolor="ECEBF0"  >
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><table width="100%" height="0%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr valign="bottom" >
          <td height="100%" align="right">
            <input name="alla" type="hidden" id="alla" value="<?php echo $y; ?>">
            <input name="total" type="hidden" id="total" value="0">
            <?php echo $lang_sendmail_total; ?>
              <input name="tot" type="text" id="tot" value="0 KB." size="20"  readonly="true" style="border:none">          </td>
        </tr>
      </table></td>
  </tr>
  <tr bgcolor="ECEBF0"  id="shwc" style="display:none">
  <td bgcolor="#FFFFFF"><?php echo $lang_sendmail_custom_mail; ?></td>
  <td colspan="2" bgcolor="#FFFFFF"><input name="cusmail" type="text" id="cusmail" size="110" class="form-control" ></td>
  </tr>
<tr bgcolor="ECEBF0">
  <td valign="top" bgcolor="#FFFFFF"><?php echo $lang_sendmail_body; ?></td>
  <td colspan="2" valign="top" bgcolor="#FFFFFF"><select name="stype" id="stype" style="WIDTH: 250" onChange="SelT(this.value);" class="form-control">  
  <option value="text/html"><?php echo $lang_sendmail_load_temp; ?>
  <option value="text/plain"><?php echo $lang_sendmail_load_text; ?>
  </select>
    <br>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="tb1">
	<?php
$Sel2 = "select * from n_temp order by t_name asc";
$Ex2 = $db->query($Sel2);
?>
      <tr>
        <td><select name="seltemp" style="WIDTH: 250" onChange="enb(this.value,form1.seltemp.options[form1.seltemp.selectedIndex].text); " class="form-control">  
		<option value=""><?php echo $lang_sendmail_select_temp; ?></option>
		  <?php while($RRR = $db->db_fetch_array($Ex2)){ ?>
  <option value="<?php echo $RRR[t_id]; ?>"><?php echo $RRR[t_name]; ?></option>
  <?php } ?>
  </select>
          <input name="zzz" type="button" disabled id="zzz" value="<?php echo $lang_sendmail_edit_tempp; ?>" onClick="PopEdit();" class="btn btn-info">
		  <?php
		  
		  //$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."";
		  ?>
		  <script language=javascript>
function enb(c,d){

if(c==""){
document.all.zzz.disabled = true;
document.all.prev.style.display = 'none';
}else{
document.all.zzz.disabled = false;
document.all.prev.style.display = '';
document.all.prev.src = "temp_preview.php?tid="+ d;
}
}
function PopEdit(){
win2 = window.open('temp_add.php?tid='+form1.seltemp.options[form1.seltemp.selectedIndex].value+'&Flag=Edit&module=1','TempEdit','height=550,width=600,resizable=1,scrollbars=1');
}
      </script>
	  <br>
<IFRAME name="prev" frameBorder="0" width="99%" ALIGN="center" height="225"  style="display:none"></IFRAME>		  </td>
      </tr>
    </table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tb2" style="display:none">
	<?php
$Sel2 = "select * from n_temp order by t_name asc";
$Ex2 = $db->query($Sel2);
?>
      <tr>
        <td><textarea name="bodytext" cols="100" rows="10" id="bodytext" class="form-control" style="width:80%;" ></textarea></td>
      </tr>
    </table>	</td>
  </tr>
<tr bgcolor="ECEBF0">
  <td bgcolor="#FFFFFF">&nbsp;</td>
  <td colspan="2" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="<?php echo $lang_sendmail_send; ?>" class="btn btn-success btn-ml" />    </td>
</tr>
  </form>
</table>
</div>
</div>
</body>
</html>
<?php
$db->db_close(); 
?>
<script language="JavaScript">
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
function ChkValue(){
if(document.form1.subject.value == ""){
alert('<?php echo $lang_sendmail_alert_subject; ?>');
document.form1.subject.focus();
return false;
}else if(document.form1.from_name.value == ""){
alert('<?php echo $lang_sendmail_alert_name; ?>');
document.form1.from_name.focus();
return false;
}else if(document.form1.from_email.value == ""){
alert('<?php echo $lang_sendmail_alert_email; ?>');
document.form1.from_email.focus();
return false;
}else if(!validEMail(document.form1.from_email)){
alert('<?php echo $lang_sendmail_alert_email_format; ?>');
document.form1.from_email.select();
return false;
}
for(i=0;i<document.form1.allg.value;i++){
if(document.form1.elements["tog"+i].checked){
var pass = 1;
}
	}
	if(pass != 1){
	if(document.form1.sendtoother.checked){
	if(document.form1.cusmail.value == ""){
	alert("<?php echo $lang_sendmail_alert_custom; ?>");
	document.form1.cusmail.focus();
return false;
}
}else{
	alert("<?php echo $lang_sendmail_alert_select_group; ?>");
return false;
}
	}
if(document.form1.stype.value == "text/html"){
if(document.form1.seltemp.value == ""){
	alert("<?php echo $lang_sendmail_alert_select_temp; ?>");
	document.form1.seltemp.focus();
return false;
}
}	
}
</script>