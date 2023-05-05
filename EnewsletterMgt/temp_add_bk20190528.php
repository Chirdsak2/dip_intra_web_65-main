<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("lang_newsletter.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Content Management System</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="content-type" content="text/html;charset=UTF-8">
<link href="../../css/style.css" rel="stylesheet" type="text/css">
</HEAD>
<?php $checkS = $db->query("select * from n_temp"); ?>
<script language="JavaScript">
var list= new Array()
<?php while($W = mysql_fetch_array($checkS)){ ?>
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
else if(document.frmSaveContents.t_name.value.search("^[A-Za-z0-9_]+$")){
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
$Path_true = "file_attach";

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
	$R = mysql_fetch_array($Sel);
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
<FORM action="temp_function.php" method="post" name="frmSaveContents" enctype="multipart/form-data" <?php if($Flag=="Add"){ ?>onSubmit="return Chk2();"<?php } ?>>

<div class="dContainer" >   
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><i class="far fa-times-circle fa-1x"></i></button>
          <h4 class="modal-title">แก้ไขรายละเอียด</h4>
        </div>
        <div class="modal-body" style='overflow-y : auto;  max-height:380px;'>
			<span id="warning"></span>
			<span id="warning1"></span>
			<div class="form-group row" >
				<div class="col-md-12 col-sm-12 col-xs-12">
					<textarea name="Text2" cols="40" rows="5" wrap="VIRTUAL" id="Text2"></textarea>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<font face="MS Sans Serif" size="1">&nbsp;
						<input name="module" type="hidden" id="module" value="<?php echo $module; ?>">
						<input name="newfile" type="hidden" id="newfile">
						</font><font face="MS Sans Serif" color="#FFFFFF"><b><font color="#666666" size="1">
						<input name="tid" type="hidden" id="tid" value="<?php echo $tid; ?>">
						<input name="Flag" type="hidden" id="Flag" value="<?php echo $Flag; ?>">
						<?php if($Flag=="Add"){ ?>
						</font></b></font><font face="MS Sans Serif" size="1"><strong><?php echo $lang_temp_name; ?></strong>        
						<input name="t_name" type="text" id="t_name" value="<?php echo $R[t_name]; ?>" class="form-control">
						<?php }  if($Flag=="Edit"){ ?>
						<input name="t_name" type="hidden" id="t_name" value="<?php echo $R[t_name]; ?>">
						<?php } ?>
					</font>
				</div>
			</div>

        </div>
		
        <div class="modal-footer right">
			<!--<button type="submit" class="btn btn-success  btn-ml " >
				<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;<?="บันทึก";?>
			</button>-->
			<input type="submit" name="save" class="btn btn-success  btn-ml " value="<?php echo $lang_temp_save_text; ?>" >
 
        </div>
      </div>
	 
    </div>
 </div>	 







  <!--<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="B2B4BF" bgcolor="ECEBF0">
    <tr> 
      <td align="right"> 
			<textarea name="Text2" cols="40" rows="5" wrap="VIRTUAL" id="Text2">  <?php
			  /*function encodeHTML($sHTML)
				{
				$sHTML=ereg_replace("&","&amp;",$sHTML);
				$sHTML=ereg_replace("<","&lt;",$sHTML);
				$sHTML=ereg_replace(">","&gt;",$sHTML);
				return $sHTML;
				}
			  if(isset($HtmlCode))
				{
				$sContent=stripslashes($HtmlCode); *//*** remove (/) slashes ***/
				/*echo encodeHTML($sContent);
				}*/
		  ?>
			</textarea>
		<script>
		var oEdit1 = new InnovaEditor("oEdit1");
		
		oEdit1.width="100%";
		oEdit1.height="500";
		oEdit1.useTab = false;
		oEdit1.mode="HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"
		
		oEdit1.REPLACE("Text2");
		</script><font face="MS Sans Serif" size="1">&nbsp;
        <input name="module" type="hidden" id="module" value="<?php echo $module; ?>">
        <input name="newfile" type="hidden" id="newfile">
        </font><font face="MS Sans Serif" color="#FFFFFF"><b><font color="#666666" size="1">
		<input name="tid" type="hidden" id="tid" value="<?php echo $tid; ?>">
        <input name="Flag" type="hidden" id="Flag" value="<?php echo $Flag; ?>">
		<?php if($Flag=="Add"){ ?>
        </font></b></font><font face="MS Sans Serif" size="1"><strong><?php echo $lang_temp_name; ?></strong>        
        <input name="t_name" type="text" id="t_name" value="<?php echo $R[t_name]; ?>">
		<?php } ?>
        <input type="submit" name="save" value="<?php echo $lang_temp_save_text; ?>" >
		<?php if($Flag=="Edit"){ ?>
		<input name="t_name" type="hidden" id="t_name" value="<?php echo $R[t_name]; ?>">
		<?php } ?>
      </font></td>
    </tr>
  </table>-->
  </FORM>
 <script>
  CKEDITOR.replace('Text2', {
		allowedContent: true,
	  	customConfig: '../../js/ckeditor/custom_config.js'
  });

</script>
</body></HTML>
<?php
include("../EWT_ADMIN/combottom.php");
?>
