<?php
include("authority.php");
?>
<?php 

?>
<html>
<head>
<title>Save Template As...</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="content-type" content="text/html;charset=UTF-8">
<?php 
$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";
if($Flag=="save"){

if(@copy($Path_true."/".$tid.".html",$Path_true."/".$t_name.".html")){
$ins = $db->query("INSERT INTO `n_temp` ( `t_id` , `t_name` , `t_date` ) VALUES ('', '$t_name', NOW( ))");
$db->write_log("coppy","enews","คัดลอกจดหมายข่าว E-news letter  : ".$tid."   เป็น  ".$t_name);
?>
<script language="javascript">
window.opener.location.href="temp_mod.php?msg=Y";
window.close();
</script>
<?php
}else{
?>
<script language="javascript">
	alert("ไม่สามารถบันทึกเป็น Template ได้");
window.close();
</script>
<?php
}
}
 ?>
</HEAD>
<?php $checkS = $db->query("select * from n_temp"); ?>
<script language="JavaScript">
var list= new Array()
<?php while($W = mysql_fetch_array($checkS)){ ?>
								list[list.length]='<?php echo $W[t_name]; ?>';
<?php } ?>
function Chk2(){
if(document.frmSaveContents.t_name.value ==""){
alert("<?php echo $lang_temp_alert_name; ?>");
document.frmSaveContents.t_name.focus();
return false;
}else if(document.frmSaveContents.t_name.value.search("^[A-Za-z0-9_]+$")){
alert("<?php echo $lang_temp_alert_format; ?>");
document.frmSaveContents.t_name.select();
return false;
}
for(i=0;i<list.length;i++){
if(document.frmSaveContents.t_name.value == list[i]){
alert("<?php echo $lang_temp_alert_name_use; ?>");
document.frmSaveContents.t_name.select();
return false;
}
}
}
</script>
<body bgColor="#ffffff">
<FORM action="temp_save.php" method="post" name="frmSaveContents" onSubmit="return Chk2();">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="B2B4BF" bgcolor="ECEBF0">
    <tr> 
      <td height="61" align="center"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Save Template As</strong></font><br>        <input name="t_name" type="text" id="t_name">
        <input type="submit" name="Submit" value="Submit"> <input name="tid" type="hidden" id="tid" value="<?php echo $tid; ?>">
        <input name="Flag" type="hidden" id="Flag" value="บันทึก">
</td>
    </tr>
  </table>
</FORM>
</body></HTML>
