<?php
/*include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("lang_newsletter.php");*/

include("../EWT_ADMIN/comtop_pop.php");
include("lang_newsletter.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Content Management System</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="content-type" content="text/html;charset=TIS-620">
<link href="../css/style.css" rel="stylesheet" type="text/css">
</HEAD>
<?php $checkS = $db->query("select * from n_temp"); ?>
<script language="JavaScript">
var list= new Array()
<?php while($W = mysqli_fetch_array($checkS)){ ?>
								list[list.length]='<?php echo $W[t_name]; ?>';
<?php } ?>
function Chk1(){
if(document.form1.temp1.value ==""){
alert("<?php echo $lang_temp_alert_upload; ?>");
document.form1.temp1.focus();
return false;
}
}
function Chk2(){
if(document.frmSaveContents.t_name.value ==""){
alert("<?php echo $lang_temp_alert_name; ?>");
document.frmSaveContents.t_name.focus();
return false;
}
else if(document.frmSaveContents.t_name.value.search("^[A-Za-z0-9_]+$")){ //document.frmSaveContents.t_name.value.search("^[A-Za-z0-9_]+$")
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
function SaveAS(c){
result = prompt("Save As Template Name",""+c+"");
if(result != null && result != ""){
document.frmSaveContents.newfile.value = result;
document.frmSaveContents.Flag.value = "SaveAS";
document.frmSaveContents.submit();
}else{
return false;
}
}
</script>
<!--<script language=JavaScript src='../scripts/innovaeditor.js'></script>-->
<body bgColor="#ffffff">
<?php
$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";

if($FlagX=="Upload"){
$pos = strpos($temp1_type, "text");
if (is_integer($pos))  { 
$fp1 = @fopen($temp1, "r");
if(!$fp1){ die("Cannot open $temp1_name"); }
while($html1 = @fgets($fp1, 1024)){
$HtmlCode .= $html1;
}
@fclose($fp1);
}else{ ?>
<table width="100%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="B2B4BF">
    <tr bgcolor="#FF6600"> 
      
    <td align="right" bgcolor="#CC3300"><div align="center"><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_temp_cant_read; ?> <?php echo $temp1_name; ?> <?php echo $lang_temp_tryagain; ?></strong></font></div></td>
    </tr>
</table>
<?php 
$FlagX = "";
}
unlink($temp1);
}


if($Flag=="Edit"){
$Sel = $db->query("select * from n_temp where t_id = '$tid'");
$R = mysqli_fetch_array($Sel);
if($FlagX!="Upload"){
$HtmlCode = "";
$fp1 = @fopen($Path_true."/".$R[t_name].".html", "r");
if(!$fp1){ die("Cannot open "."template/".$R[t_name].".html"); }
while($html1 = @fgets($fp1, 1024)){
$HtmlCode .= $html1;
}
@fclose($fp1);
}
}
?>
<FORM action="temp_function.php" method="post" name="frmSaveContents" <?php if($Flag=="Add"){ ?>onSubmit="return Chk2();"<?php } ?>>
  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="B2B4BF" bgcolor="ECEBF0">
    <tr> 
      <td align="right"> <textarea name="Text2" cols="40" rows="5" id="Text2">  <?php echo $HtmlCode;?></textarea><font face="MS Sans Serif" size="1">&nbsp;
        <input name="module" type="hidden" id="module" value="<?php echo $module; ?>">
        <input name="newfile" type="hidden" id="newfile">
        </font><font face="MS Sans Serif" color="#FFFFFF"><b><font color="#666666" size="1">
		<input name="tid" type="hidden" id="tid" value="<?php echo $tid; ?>">
        <input name="Flag" type="hidden" id="Flag" value="<?php echo $Flag; ?>">
		<?php if($Flag=="Add"){ ?>
        </font></b></font><font face="MS Sans Serif" size="1">        
		<?php }else if($Flag=="Edit"){ ?>
		<input name="t_name" type="hidden" id="t_name" value="<?php echo $R[t_name]; ?>">
		<?php } ?>
		<?php if($Flag=="Add"){ ?>
		<div class="row m-b-sm">
			<div class="col-md-2 col-sm-2 col-xs-12 m-b-sm" >
				<strong><?php echo $lang_temp_name; ?></strong>
			</div>
			<div class="col-md-8 col-sm-8 col-xs-12 m-b-sm" >
			<input name="t_name" type="text" id="t_name" value="<?php echo $R[t_name]; ?>" class="form-control">
			</div>
		</div>
		<?php }?>
		<button type="submit" name="save" class="btn btn-success  btn-ml "> <span class="glyphicon glyphicon-floppy-disk"></span> <?php echo $lang_temp_save_text; ?></button>
      </font></td>
    </tr>
  </table>
  </FORM>
</body></HTML>
<?php include("../EWT_ADMIN/script-all.php");?>
<script>
  CKEDITOR.replace('Text2', {
  allowedContent: true,
    customConfig: '../../js/ckeditor/custom_config.js'
  });

</script>

