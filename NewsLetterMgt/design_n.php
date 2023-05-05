<?php
include("authority.php");
if($filenameS==""){
include("default.dll");
}else{
include($UserPath."temp".$sign.$filenameS.".dll");
}
?>
<html>
<head>
<title>WebAdmin</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
<script language="JavaScript">
function OpenHead(){
win2=window.open('design_subject.php?data1='+document.form1.SubjectMainF.value+'&data2='+document.form1.SubjectMainS.value+'&data3='+document.form1.SubjectMainC.value+'&data4='+document.form1.SubjectMainB.value+'&data5='+document.form1.SubjectMainI.value+'','SubjectShow', 'height=360,width=300, status=0, menubar=0,resizable=no, location=0, scrollbars=yes, left=0,top=0');
}
function Chan1(){
window.document.all.tbd01.style.background = "url("+document.form1.newslfileh.value+")";
document.form1.NoBGH.checked = false;
}
function Chan2(){
window.document.all.tbd02.style.background = "url("+document.form1.newslfileb.value+")";
}
</script>
		  <script language="JavaScript">
		  function inp(c,d){
		  d.innerHTML = c;
		  }
		   function inps(c,d){
		  d.value = c;
		  }
		  </script>
		  <script language="JavaScript">
		  function Nopic(){
		  if(document.form1.NoBGH.checked){
		  window.document.all.tbd01.style.background = "";
		  window.document.all.tbd01.style.backgroundColor = document.form1.NLTHeadBG.value;
		  }else{
		  if(document.form1.newslfileh.value == "" && document.form1.NLTHeadP.value == ""){
		   window.document.all.tbd01.style.background = "";
		  window.document.all.tbd01.style.backgroundColor = document.form1.NLTHeadBG.value;
		  }else if(document.form1.newslfileh.value != "" ){
		  window.document.all.tbd01.style.background = "url("+document.form1.newslfileh.value+")";
		  }else if(document.form1.NLTHeadP.value != ""){
		  window.document.all.tbd01.style.background = "url(<?php echo $Website."/images/"; ?>"+document.form1.NLTHeadP.value+")";
		  }
		  }
		  }
		  function Nopic1(){
		  if(document.form1.NoBGB.checked){
		  window.document.all.tbd02.style.background = "";
		  window.document.all.tbd02.style.backgroundColor = document.form1.NLTBodyBG.value;
		  }else{
		  if(document.form1.newslfileb.value == "" && document.form1.NLTBodyP.value == ""){
		   window.document.all.tbd02.style.background = "";
		  window.document.all.tbd02.style.backgroundColor = document.form1.NLTBodyBG.value;
		  }else if(document.form1.newslfileb.value != "" ){
		  window.document.all.tbd02.style.background = "url("+document.form1.newslfileb.value+")";
		  }else if(document.form1.NLTBodyP.value != ""){
		  window.document.all.tbd02.style.background = "url(<?php echo $Website."/images/"; ?>"+document.form1.NLTBodyP.value+")";
		  }
		  }
		  }
		  function selColor(c){
Win2=window.open('select_color.php?t='+ c +'','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=100, top=100');
}
function ch3(c,d){
if(c==""){
d.style.fontSize = "12pt";
}else{
d.style.fontSize = c+"pt";
}
}
function ch2(c){
if(c==""){
document.all.newsapp.style.fontSize = "12pt";
document.all.newscan.style.fontSize = "12pt";
document.all.Dnews01.style.fontSize ="12pt";
}else{
document.all.newsapp.style.fontSize = c+"pt";
document.all.newscan.style.fontSize = c+"pt";
document.all.Dnews01.style.fontSize = c+"pt";
}
}
function ChF3(c,d){
d.style.fontFamily=c;
}
function ChF2(c){
document.all.Dnews01.style.fontFamily=c;
document.all.newsapp.style.fontFamily=c;
document.all.newscan.style.fontFamily=c;
}
function ChB3(c){

if(c.checked){
document.all.Hnews01.style.fontWeight='bold';
}else{
document.all.Hnews01.style.fontWeight='';
}
}
function ChB2(c){

if(c.checked){
document.all.Dnews01.style.fontWeight='bold';
document.all.newsapp.style.fontWeight='bold';
document.all.newscan.style.fontWeight='bold';
}else{
document.all.Dnews01.style.fontWeight='';
document.all.newsapp.style.fontWeight='';
document.all.newscan.style.fontWeight='';
}
}
function ChI3(c){
if(c.checked){
document.all.Hnews01.style.fontStyle='italic';
}else{
document.all.Hnews01.style.fontStyle='';
}
}
function ChI2(c){
if(c.checked){
document.all.Dnews01.style.fontStyle='italic';
document.all.newsapp.style.fontStyle='italic';
document.all.newscan.style.fontStyle='italic';
}else{
document.all.Dnews01.style.fontStyle='';
document.all.newsapp.style.fontStyle='';
document.all.newscan.style.fontStyle='';
}
}
function chWTB(){
document.all.tball.style.width=document.form1.NLTTBW.value;
}
function chHTB(){
document.all.tbd01.style.height=document.form1.NLTHeadH.value;
}
function ChkValue(){
if(document.form1.filenameS.value==""){
alert("<?php echo $lang_design_alert_name; ?>");
document.form1.filenameS.focus();
return false;
}else if(document.form1.filenameS.value.search("^[A-Za-z0-9_]+$")){
alert("<?php echo $lang_design_alert_format; ?>");
document.form1.filenameS.focus();
return false;
}else{
return true;
}
}
		  </script>
</head>
<body leftmargin="0" topmargin="0">
<?php  
			  $f1 = fopen("../ContentMgt/font_list.txt","r");
			  while($line1 = fgets($f1,1024)){
			  $fontL .= $line1; 
			  }
			  fclose($f1);
			 $FontA = explode("###",$fontL);  
			  ?>
<table width="100%" height="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#99CCFF">
  <tr>
    <td>
<form name="form1" enctype="multipart/form-data" method="post" action="design_function.php" onSubmit="return ChkValue();">

<table width="99%"  border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#99CCFF">
  <tr>
    <td><div align="center"><FIELDSET style="width: 100%; text-align: center; ">
<LEGEND> <font size="2" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_preview; ?></strong></font></LEGEND>
<br>
<table id="tball" width="<?php echo $NLTTBW; ?>" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="<?php echo $NLTHeadH; ?>" align="center" background="<?php echo $Website."/images/".$NLTHeadP; ?>" bgcolor="<?php echo $NLTHeadBG; ?>" id="tbd01"><font face="<?php echo $NLTHeadF; ?>" color="<?php echo $NLTHeadBGTC; ?>" size="<?php echo $NLTHeadS; ?>"><span id="Hnews01" style="<?php if($NLTHeadB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTHeadI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $NLTHeadT; ?></span></font></td>
  </tr>
  <tr>
    <td align="center" background="<?php echo $Website."/images/".$NLTBodyP; ?>" bgcolor="<?php echo $NLTBodyBG; ?>" id="tbd02">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		        <tr>
          <td height="10" align="center" ><font face="<?php echo $NLTBodyF; ?>" color="<?php echo $NLTBodyBGT; ?>" size="<?php echo $NLTBodyS; ?>"><span id="Dnews01" style="<?php if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $NLTBodyTD; ?></span></font></td>
        </tr>
      </table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		        <tr><td height="10" align="center" >
	  <input name="newsletteremail" type="text" id="newsletteremail"  style="width:92%">
			</td>
        </tr>
      </table>
			<input name="applynewsletter" type="radio" value="Y" checked><font face="<?php echo $NLTBodyF; ?>" color="<?php echo $NLTBodyBGT; ?>" size="<?php echo $NLTBodyS; ?>"><span id="newsapp" style="<?php if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $NLTBodyTA; ?></span></font><input type="radio" name="applynewsletter" value="N"><font face="<?php echo $NLTBodyF; ?>" color="<?php echo $NLTBodyBGT; ?>" size="<?php echo $NLTBodyS; ?>"><span id="newscan" style="<?php if($NLTBodyB=="Y"){ echo "font-Weight:bold"; } ?>;<?php if($NLTBodyI=="Y"){ echo "font-Style:italic"; } ?>"><?php echo $NLTBodyTC; ?></span></font>
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td  align="right"><input name="Button01" type="button" id="Button01" value="<?php echo $NLTBodyTS; ?>" >
         </td>
        </tr>
      </table></td>
  </tr>
</table>
<br>

    </FIELDSET></div></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="B2B4BF">
      <tr>
        <td height="24" colspan="4" align="center" bgcolor="B2B4BF"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_head; ?></strong></font></td>
        </tr>
      <tr align="left">
        <td width="32%" height="32" bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_head_size; ?></strong><br>
            <?php echo $lang_design_head_size_example; ?>
        </font></td>
        <td width="25%"><input name="NLTTBW" type="text" id="NLTTBW" value="<?php echo $NLTTBW; ?>" size="3" onBlur="chWTB();"> 
          <font size="1" face="MS Sans Serif, Tahoma, sans-serif">*</font>          <input name="NLTHeadH" type="text" id="NLTHeadH" value="<?php echo $NLTHeadH; ?>" size="3" onBlur="chHTB();"></td>
        <td width="13%" bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_head_bg_pic; ?></strong><br>
          <input name="NoBGH" type="checkbox" id="NoBGH" value="Y" onClick="Nopic();">
<?php echo $lang_design_head_bg_nopic; ?></font></td>
        <td width="30%"><input name="newslfileh" type="file" id="newslfileh" onChange="Chan1();">
          <input name="NLTHeadP" type="hidden" id="NLTHeadP" value="<?php echo $NLTHeadP; ?>"></td>
      </tr>
      <tr align="left">
        <td bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_head_bg_color; ?>
        </strong></font></td>
        <td><table border=0 cellspacing=0 cellpadding=4 width=100%>
 <tr>
  <td width="6%" valign=center><div id="ColorPreview01" style="background-color: <?php echo $NLTHeadBG; ?>; padding: 1; height: 21px; width: 23px;cursor:hand;border-width:1; border-style:solid;" onClick="javascript:selColor('head');"></div></td>
  <td width="94%"  valign=center><font size="1" face="MS Sans Serif, Tahoma, sans-serif">#</font>    <input name="NLTHeadBG" type="text" id="NLTHeadBG"  onBlur="CreColor01(this.value);" value="<?php echo $NLTHeadBG; ?>" size=6 maxlength="6" >
      <script language="JavaScript">
  function CreColor01(color){
  document.all.tbd01.style.backgroundColor = color;    
 document.all.ColorPreview01.style.backgroundColor = color;
}
    </script>
  </td>
 </tr>
</table></td>
        <td bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_head_text; ?></strong></font></td>
        <td><input name="NLTHeadT" type="text" id="NLTHeadT" onChange="inp(this.value,document.all.Hnews01);" onKeyUp="inp(this.value,document.all.Hnews01);" value="<?php echo $NLTHeadT; ?>" onBlur="inp(this.value,document.all.Hnews01);"></td>
      </tr>
      <tr align="left">
        <td bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_head_design; ?></strong></font></td>
        <td colspan="3"><select name="NLTHeadF" id="NLTHeadF" onChange="ChF3(this.value,document.all.Hnews01);">
		<?php
		$i = 0;
		 while($FontA[$i]){ ?>
		 <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$NLTHeadF){ echo "selected"; } ?>><?php echo $FontA[$i]; ?></option>
		<?php
		$i++;
		 } ?>
        </select>
          <select name="NLTHeadS"  onChange="ch3(this.value,document.all.Hnews01);">
          <option value="">none
          <option value="8" <?php if($NLTHeadS=="1"){ echo "selected"; } ?>>1
          <option value="10" <?php if($NLTHeadS=="2"){ echo "selected"; } ?>>2
          <option value="12" <?php if($NLTHeadS=="3"){ echo "selected"; } ?>>3
          <option value="14" <?php if($NLTHeadS=="4"){ echo "selected"; } ?>>4
          <option value="18" <?php if($NLTHeadS=="5"){ echo "selected"; } ?>>5
          <option value="24" <?php if($NLTHeadS=="6"){ echo "selected"; } ?>>6
          <option value="36" <?php if($NLTHeadS=="7"){ echo "selected"; } ?>>7          
            </select>&nbsp;
          <span id="ColorPreview02" style="background-color: <?php echo $NLTHeadBGTC; ?>; padding: 1; height: 21px; width: 23px;cursor:hand;border-width:1; border-style:solid;" onClick="javascript:selColor('headt');"></span>
&nbsp;<font size="1" face="MS Sans Serif, Tahoma, sans-serif">#</font>&nbsp;<input name="NLTHeadBGTC" type="text" id="NLTHeadBGTC"  onBlur="CreColor02(this.value);" value="<?php echo $NLTHeadBGTC; ?>" size=6 maxlength="6" >          
        <script language="JavaScript">
  function CreColor02(color){
  document.all.Hnews01.style.color = color;      
 document.all.ColorPreview02.style.backgroundColor = color;
}
    </script>
		  <input name="NLTHeadB" type="checkbox" id="NLTHeadB" value="Y" onClick="ChB3(document.form1.NLTHeadB);" <?php if($NLTHeadB=="Y"){ echo "checked"; } ?>>
          <strong><font size="2" face="Tahoma">Bold</font></strong>
          <input name="NLTHeadI" type="checkbox" id="NLTHeadI" value="Y" onClick="ChI3(document.form1.NLTHeadI);" <?php if($NLTHeadI=="Y"){ echo "checked"; } ?>>
          <em><font size="2" face="Tahoma">Italic</font></em>
</td>
        </tr>
      <tr align="center">
        <td height="26" colspan="4" bgcolor="B2B4BF"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_body; ?></strong></font></td>
        </tr>
		<tr align="left">
        <td width="32%" height="24" bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_body_bg_color; ?></strong></font></td>
        <td width="25%"><table border=0 cellspacing=0 cellpadding=4 width=100%>
 <tr>
  <td width="6%" valign=center><div id="ColorPreview03" style="background-color: <?php echo $NLTBodyBG; ?>; padding: 1; height: 21px; width: 23px;cursor:hand;border-width:1; border-style:solid;" onClick="javascript:selColor('body');"></div></td>
  <td width="94%"  valign=center><font size="1" face="MS Sans Serif, Tahoma, sans-serif">#</font>    <input name="NLTBodyBG" type="text" id="NLTBodyBG"  onBlur="CreColor03(this.value);" value="<?php echo $NLTBodyBG; ?>" size=6 maxlength="6" >
    <script language="JavaScript">
  function CreColor03(color){
  document.all.tbd02.style.backgroundColor = color;    
 document.all.ColorPreview03.style.backgroundColor = color;
}
    </script>
	</td>
 </tr>
</table></td>
        <td width="13%" bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_body_bg_pic; ?></strong><br>
          <input name="NoBGB" type="checkbox" id="NoBGB" value="Y" onClick="Nopic1();">
<?php echo $lang_design_body_bg_nopic; ?></font></td>
        <td width="30%"><input name="newslfileb" type="file" id="newslfileb" onChange="Chan2();">
          <input name="NLTBodyP" type="hidden" id="NLTBodyP" value="<?php echo $NLTBodyP; ?>"></td>
      </tr>
      <tr align="left">
        <td bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_body_text_des; ?></strong></font></td>
        <td colspan="3"><font size="1" face="MS Sans Serif, Tahoma, sans-serif">
          <input name="NLTBodyTD" type="text" onChange="inp(this.value,document.all.Dnews01);" onKeyUp="inp(this.value,document.all.Dnews01);" value="<?php echo $NLTBodyTD; ?>" onBlur="inp(this.value,document.all.Dnews01);">
        </font><font size="1" face="MS Sans Serif, Tahoma, sans-serif">&nbsp;</font></td>
        </tr>
      <tr align="left">
        <td bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_body_text_apply; ?></strong></font></td>
        <td><input name="NLTBodyTA" type="text" id="NLTBodyTA" value="<?php echo $NLTBodyTA; ?>" onChange="inp(this.value,document.all.newsapp);" onKeyUp="inp(this.value,document.all.newsapp);" onBlur="inp(this.value,document.all.newsapp);"></td>
        <td bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_body_text_cancel; ?></strong></font></td>
        <td><input name="NLTBodyTC" type="text" id="NLTBodyTC" value="<?php echo $NLTBodyTC; ?>" onChange="inp(this.value,document.all.newscan);" onKeyUp="inp(this.value,document.all.newscan);" onBlur="inp(this.value,document.all.newscan);"></td>
      </tr>
      <tr align="left">
        <td height="28" bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_body_text_submit; ?></strong></font></td>
        <td><input name="NLTBodyTS" type="text" id="NLTBodyTS" value="<?php echo $NLTBodyTS; ?>" onChange="inps(this.value,document.all.Button01);" onKeyUp="inps(this.value,document.all.Button01);" onBlur="inps(this.value,document.all.Button01);"></td>
        <td bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_other_language; ?></strong></font></td>
        <td><select name="NLTBodyTL" id="NLTBodyTL">
        <option value="TH" <?php if($NLTBodyTL=="TH"){ echo "selected"; } ?>>ไทย</option>
        <option value="EN" <?php if($NLTBodyTL=="EN"){ echo "selected"; } ?>>English</option>     
        </select></td>
      </tr>
	        <tr align="left">
        <td bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_body_font_option; ?></strong></font></td>
        <td colspan="3"><select name="NLTBodyF" id="NLTBodyF" onChange="ChF2(this.value);">
		<?php
		$i = 0;
		 while($FontA[$i]){ ?>
		 <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$NLTBodyF){ echo "selected"; } ?>><?php echo $FontA[$i]; ?></option>
		<?php
		$i++;
		 } ?>
        </select>
           <select name="NLTBodyS"  onChange="ch2(this.value);">
          <option value="">none
          <option value="8" <?php if($NLTBodyS=="1"){ echo "selected"; } ?>>1
          <option value="10" <?php if($NLTBodyS=="2"){ echo "selected"; } ?>>2
          <option value="12" <?php if($NLTBodyS=="3"){ echo "selected"; } ?>>3
          <option value="14" <?php if($NLTBodyS=="4"){ echo "selected"; } ?>>4
          <option value="18" <?php if($NLTBodyS=="5"){ echo "selected"; } ?>>5
          <option value="24" <?php if($NLTBodyS=="6"){ echo "selected"; } ?>>6
          <option value="36" <?php if($NLTBodyS=="7"){ echo "selected"; } ?>>7          
            </select>
          &nbsp;
          <span id="ColorPreview04" style="background-color: <?php echo $NLTBodyBGT; ?>; padding: 1; height: 21px; width: 23px;cursor:hand;border-width:1; border-style:solid;" onClick="javascript:selColor('bodyt');"></span>
&nbsp;<font size="1" face="MS Sans Serif, Tahoma, sans-serif">#</font>&nbsp;<input name="NLTBodyBGT" type="text" id="NLTHeadBGT"  onBlur="CreColor04(this.value);" value="<?php echo $NLTBodyBGT; ?>" size=6 maxlength="6" >          
 <script language="JavaScript">
  function CreColor04(color){
  document.all.Dnews01.style.color = color;      
  document.all.newsapp.style.color = color;   
  document.all.newscan.style.color = color;   
 document.all.ColorPreview04.style.backgroundColor = color;
}
    </script>
  <input name="NLTBodyB" type="checkbox" id="NLTBodyB" onClick="ChB2(document.form1.NLTBodyB);" value="Y" <?php if($NLTBodyB=="Y"){ echo "checked"; } ?>>
          <strong><font size="2" face="Tahoma">Bold</font></strong>
          <input name="NLTBodyI" type="checkbox" id="NLTBodyI" value="Y" onClick="ChI2(document.form1.NLTBodyI);" <?php if($NLTBodyI=="Y"){ echo "checked"; } ?>>
          <em><font size="2" face="Tahoma">Italic</font></em>
</td>
        </tr>
      <tr>
        <td align="left" bgcolor="ECEBF0"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_name_is; ?></strong></font>          </td>
        <td align="left"><input name="filenameS" type="text" id="filenameS3" value="<?php echo $filenameS; ?>" <?php if($Flag=="Edit"){ ?>readonly="true" <?php } ?>>        </td>
        <td align="right" bgcolor="ECEBF0"><input name="usethistemp" type="checkbox" id="usethistemp" value="Y"></td>
        <td align="left"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_use_this; ?></strong></font></td>
      </tr>
      <tr>
        <td colspan="4" align="right" bgcolor="ECEBF0"><input type="submit" name="Submit" value="<?php echo $lang_design_save; ?>">
          <input type="button" name="Submit2" value="<?php echo $lang_design_reset; ?>" onClick="javascript:window.location.reload();">
          </td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
</td>
        </tr>
    </table>
</body>
</html>
