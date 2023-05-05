<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/menu_language.php");
$sql_menu_sub = $db->query("SELECT * FROM menu_properties WHERE mp_id = '".$_GET["mp_id"]."' ");
$R = $db->db_fetch_array($sql_menu_sub);

$f1 = fopen("../font_list.txt","r");
			  while($line1 = fgets($f1,1024)){
			  $fontL .= $line1; 
			  }
			  fclose($f1);
			 $FontA = explode("###",$fontL);  
			 
			$selSub = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '".$_GET["mp_id"]."_%'"); 
			$sub_row=$db->db_num_rows($selSub);
			
			//setting hide/show
			if($_GET["tb_show"] == ""){
			$tbshow = "01";
			}else{
			$tbshow = $_GET["tb_show"];
			}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
var mybrowser=navigator.userAgent;
function deleteM(){
	var r = confirm('Are you sure you want to delete menu "<?php echo stripslashes($R[mp_name]); ?>" and all its contents?');
	if(r == true){
		if(mybrowser.indexOf('MSIE')>0){
			document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"delform\" method=\"post\" action=\"menu_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"DELMENU\"><input name=\"m_id\" type=\"hidden\" id=\"m_id\" value=\"<?php echo $R["m_id"]; ?>\"><input name=\"m_name\" type=\"hidden\" id=\"m_name\" value=\"<?php echo $R["mp_name"]; ?>\"><input name=\"mp_id\" type=\"hidden\" id=\"mp_id\" value=\"<?php echo $R["mp_id"]; ?>\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";

		}else{
			document.write("<form name=\"delform\" method=\"post\" action=\"menu_function.php\">");
			document.write("<input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"DELMENU\">");
			document.write("<input name=\"m_id\" type=\"hidden\" id=\"m_id\" value=\"<?php echo $R["m_id"]; ?>\">");
			document.write("<input name=\"mp_id\" type=\"hidden\" id=\"mp_id\" value=\"<?php echo $R["mp_id"]; ?>\">");
			document.write("<br><br><br><br><br><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div>");
			document.write("</form>"); 
		}
		delform.submit();				
	}
}
function addSub(c,d){
document.all.addspan.innerHTML = c;
document.form1.Flag.value = d;
document.all.AddLayer.style.display='';
document.form1.m_name.focus();
}
function ChkValue(c,d){ 
	if(d.value == ""){
		 alert("Please insert menu name"); d.focus(); 
	return false;
	 } 

} 
		  	function selColor(c,d){
				Win2=window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
			}
		function choose_pic(c){
	formPopUpBg.action = "../FileMgt/gallery_insert.php";
	window.open('','bg_popup','top=60,left=80,width=780,height=480,resizable=1,status=0');
		document.formPopUpBg.o_value.value = c;
		formPopUpBg.submit();
		}
					function setbox(c,d){
				if(c.checked == true){
					d.checked = true;
				}else{
					d.checked = false;
				}
			}
</script>
</head>
<body leftmargin="0" topmargin="0">
<span id="formtext"></span>
  <form name="formPopUpBg" method="post" action="" target="bg_popup">
		<input name="o_value" type="hidden" id="o_value" value="">
		<input name="stype" type="hidden" id="stype" value="images">
		<input name="Flag" type="hidden" id="Flag" value="Link">
	</form>
<div id="AddLayer" style="display:none;position:absolute; left:61px; top:54px; width:300px; height:50px; z-index:1" >
  <table width="300" height="50" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666" >
  <form name="form1" method="post" action="menu_function.php" onSubmit="return ChkValue(this,document.form1.m_name);">
  <tr>
    <td height="25" background="../images/m_bg.gif"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="95%"><strong><span id="addspan">เพิ่มเมนูย่อย</span></strong></td>
    <td width="5%" valign="top"><img src="../images/error.gif" width="16" height="16" align="top" style="cursor:hand" onClick="document.all.AddLayer.style.display='none'"></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td height="25" align="center" bgcolor="#FFFFFF">ชื่อเมนู 
      <input name="m_name" type="text" id="m_name" >
      
      <input name="Flag" type="hidden" id="Flag">
          <input type="submit" name="Submit3" value="Save">
          <input name="m_id" type="hidden" id="m_id" value="<?php echo $R["m_id"]; ?>"><input name="mp_id" type="hidden" id="mp_id" value="<?php echo $R["mp_id"]; ?>"></td>
  </tr></form>
</table></div>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#333333">
  <tr> 
    <td height="30"  bgcolor="#FFFFFF" class="ewttablehead"><img src="../theme/main_theme/menu_properties.gif" width="24" height="24" align="absmiddle"> 
      <?php echo $text_menu_properties; ?> &gt;&gt;  <?php echo $R["mp_name"]; ?> </td>
  </tr>
	<form name="linkForm" method="post" action="menu_function.php">
	<input type="hidden" name="tbshow" value="<?php echo $tbshow; ?>">
    <tr id="tr01" style="display:<?php if($tbshow == "01"){ echo '\'\''; }else{ echo "none"; } ?>"> 
      <td valign="top" bgcolor="F7F7F7"><br>
	  
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="F7F7F7">
          <tr>
            <td height="25"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
          <tr>
                  <td width="100" align="center" background="../images/bg1_on.gif">Menu 
                    Setting </td>
                  <td width="100" align="center" background="../images/bg3_off.gif"><a href="#design" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='';<?php if($sub_row > 0){ ?>document.all.tr03.style.display='none';<?php } ?>document.linkForm.tbshow.value='02';">Design</a></td>
                  <?php if($sub_row > 0){ ?>
				  <td width="100" align="center" background="../images/bg3_off.gif"><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';">Pop-up 
                    Setting</a> </td>
					<?php } ?>
            <td background="../images/bg2_off.gif">&nbsp;</td>
          </tr>
        </table></td>
          </tr>
          <tr>
            <td>
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#E6E6E6">
                <tr bgcolor="#F7F7F7"> 
                  <td width="50%"><a href="#ewt" onClick="addSub('เพิ่มเมนูย่อย','ADDY');"><img src="../images/element_on.gif" width="24" height="24" border="0" align="absmiddle"> 
                    เพิ่มเมนูย่อยภายใต้เมนู '<?php echo $R["mp_name"]; ?>'</a></td>
                  <td width="50%"><a href="#ewt" onClick="addSub('สร้างเมนูต่อจากเมนูนี้','AFTER');"><img src="../images/element_new_after.gif" width="24" height="24" border="0" align="absmiddle"> 
                    สร้างเมนูต่อจากเมนู '<?php echo $R["mp_name"]; ?>'</a></td>
                </tr>
                <tr bgcolor="#F7F7F7"> 
                  <td><a href="#ewt" onClick="addSub('แทรกเมนูก่อนหน้าเมนูนี้','BEFORE');"><img src="../images/element_new_before.gif" width="24" height="24" border="0" align="absmiddle"> 
                    แทรกเมนูก่อนหน้าเมนู '<?php echo $R["mp_name"]; ?>'</a></td>
                  <td><a href="#ewt" onClick="deleteM();"><img src="../images/element_delete.gif" width="24" height="24" border="0" align="absmiddle"> 
                    ลบเมนู '<?php echo $R["mp_name"]; ?>'</a> </td>
                </tr>
                <tr bgcolor="#F7F7F7">
                  <td><a href="#ewt" onClick="self.location.href='menu_move.php?m_id=<?php echo $R["m_id"]; ?>&mp_id=<?php echo $R["mp_id"]; ?>';"><img src="../images/element_move.gif" width="24" height="24" border="0" align="absmiddle"> 
                    ย้ายเมนู '<?php echo $R["mp_name"]; ?>'</a></td>
                  <td>&nbsp;</td>
                </tr>
</table>

<table width="100%" border="0" align="center" class="table table-bordered" >
          <tr bgcolor="#FFFFFF"> 
            <td colspan="3"></td>
          </tr>
          <tr bgcolor="F7F7F7"> 
            <td width="52%" height="30">ข้อความ  :
              <input class="form-control" style="width:80%" name="mp_name" type="text"  id="mp_name" value="<?php echo $R[mp_name]; ?>" size="40"> 
            </td>
            <td width="22%">จัดหน้า  :
              <select name="Galign"  id="Galign" class="form-control" style="width:50%">
                <option value="0" <?php if($R[Galign] == "0"){ echo "selected"; } ?>>Left</option>
                <option value="1" <?php if($R[Galign] == "1"){ echo "selected"; } ?>>Center</option>
                <option value="2" <?php if($R[Galign] == "2"){ echo "selected"; } ?>>Right</option>
              </select> </td>
            <td width="26%">ตำแหน่ง  :
              <select name="Gvalign"  id="Gvalign" class="form-control" style="width:50%">
                <option value="0" <?php if($R[Gvalign] == "0"){ echo "selected"; } ?>>Top</option>
                <option value="1" <?php if($R[Gvalign] == "1"){ echo "selected"; } ?>>Middle</option>
                <option value="2" <?php if($R[Gvalign] == "2"){ echo "selected"; } ?>>Bottom</option>
              </select></td>
          </tr>
          <tr bgcolor="F7F7F7"> 
            <td height="30" colspan="2">เชื่อมโยงไปยัง  :
              <input class="form-control" style="width:50%" name="link" type="text"  id="link" value="<?php echo $R[Glink]; ?>" size="40">  <a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.linkForm.link.value','WebsiteLink','top=100,left=100,width=660,height=500,resizable=1,status=0');win2.focus();	"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a> 
              <select name="Gtarget"  id="Gtarget" class="form-control" style="width:10%">
                <option value="_self" <?php if($R[Gtarget] == "_self"){ echo "selected"; } ?>>_self</option>
                <option value="_parent" <?php if($R[Gtarget] == "_parent"){ echo "selected"; } ?>>_parent</option>
                <option value="_top" <?php if($R[Gtarget] == "_top"){ echo "selected"; } ?>>_top</option>
                <option value="_blank" <?php if($R[Gtarget] == "_blank"){ echo "selected"; } ?>>_blank</option>
              </select> <br> <font color="#FF0000"><b><font face="MS Sans Serif" size="1"></font></b></font></td>
            <td>รายละเอียดเพิ่มเติม  :
              <input class="form-control" style="width:50%" name="Gtip" type="text"  id="Gtip" value="<?php echo $R[Gtip]; ?>"></td>
          </tr>
          <tr align="right" bgcolor="F7F7F7"> 
            <td height="30" colspan="3">
			<input name="m_id" type="hidden" id="m_id" value="<?php echo $R["m_id"]; ?>">
			<input name="m_name" type="hidden" id="m_name" value="<?php echo $R["mp_name"]; ?>">
			<input name="mp_id" type="hidden" id="mp_id" value="<?php echo $R["mp_id"]; ?>">
              <input name="Flag" type="hidden" id="Flag" value="EDIT"> 
              <input type="submit" name="Submit" value="Save" class="btn btn-success" /> 
			  </td>
          </tr>
        </table></td>
          </tr>
        </table>
        
</td>
    </tr>
    <tr id="tr02" style="display:<?php if($tbshow == "02"){ echo '\'\''; }else{ echo "none"; } ?>"> 
      <td  valign="top" bgcolor="F7F7F7"><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="25"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="100" align="center" background="../images/bg1_off.gif"><a href="#menu" onClick="document.all.tr01.style.display='';document.all.tr02.style.display='none';<?php if($sub_row > 0){ ?>document.all.tr03.style.display='none';<?php } ?>document.linkForm.tbshow.value='01';">Menu 
                    Setting</a> </td>
                  <td width="100" align="center" background="../images/bg1_on.gif">Design</td>
				  <?php if($sub_row > 0){ ?>
                  <td width="100" align="center" background="../images/bg3_off.gif"><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';">Pop-up 
                    Setting</a> </td>
					<?php } ?>
                  <td background="../images/bg2_off.gif">&nbsp;</td>
                </tr>
              </table></td>
          </tr>

<tr> 
<td>			
<table width="100%" border="0" align="center"  class="table table-bordered" >
          
		   <tr bgcolor="#CCCCCC"> 
            <td height="25" colspan="4"><strong>รูปแบบพิเศษเมื่อเอา mouse ออก 
              </strong></td>
          </tr>
          <tr bgcolor="#F7F7F7"> 
            <td width="27%">แบบตัวหนังสือ  : 
              <select name="Oufont"  id="Oufont" class="form-control" style="width:50%">
                <?php
		$i = 0;
		 while($FontA[$i]){ ?>
                <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$R[Oufont]){ echo "selected"; } ?>> 
                <?php echo $FontA[$i]; ?> </option>
                <?php
		$i++;
		 } ?>
              </select></td>
            <td width="23%">ขนาด  : 
              <select name="Ousize"  id="Ousize" class="form-control" style="width:40%">
                <?php for($f=5;$f<=72;$f++){ ?>
                <option value="<?php echo $f; ?>" <?php if($f==$R[Ousize]){ echo "selected"; } ?>><?php echo $f; ?></option>
                <?php } ?>
              </select> 
			  <select name="Ousizepr"  id="Ousizepr" class="form-control" style="width:30%">
                <option value="pt" <?php if($R[Ousizepr]=="pt"){ echo "selected"; } ?>>pt</option>
                <option value="px" <?php if($R[Ousizepr]=="px"){ echo "selected"; } ?>>px</option>
              </select></td>
            <td width="23%">
			<table width="100%" >
                <tr> 
                  <td width="20%">สี : </td>
                  <td width="80%">
				  <a id="CPreview1" style="background-color: <?php echo $R[Oucolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.Oucolor.value','window.opener.document.all.CPreview1.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>
                   <input class="form-control" style="width:50%" name="Oucolor" type="text"   id="Oucolor" value="<?php echo $R[Oucolor]; ?>"  size=7 maxlength="7"> 
                  </td>
                </tr>
              </table></td>
            <td width="27%">
			<input name="Oubold" type="checkbox" id="Oubold" value="bold" <?php if($R[Oubold]=="bold"){ echo "checked"; } ?>> 
              <strong><font face="Tahoma">หนา : </font> 
              <input name="Ouitalic" type="checkbox" id="Ouitalic" value="italic" <?php if($R[Ouitalic]=="italic"){ echo "checked"; } ?>>
              </strong> <em><font face="Tahoma">เอียง : </font></em> </td>
          </tr>
          <tr bgcolor="#F7F7F7"> 
            <td><table width="100%" >
                <tr> 
                  <td width="20%">สีพื้นหลัง : </td>
				  <td width="80%" > 
				  <a id="CPreview2" style="background-color: <?php echo $R[Oubgcolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.Oubgcolor.value','window.opener.document.all.CPreview2.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>               
				  <input class="form-control" style="width:40%" name="Oubgcolor" type="text"   id="Oubgcolor" value="<?php echo $R[Oubgcolor]; ?>"  size=7 maxlength="7"> 
                  </td>
                </tr>
              </table>
              <!--<input name="Outrans" type="checkbox" id="Outrans" value="1" <?php if($R[Outrans]=="1"){ echo "checked"; } ?>>
              Transparent--></td>
            <td colspan="3" valign="top"><div align="left"></div>
              <table width="100%" >
                <tr> 
                  <td width="5%">สีขอบ : </td>
				  <td width="35%" > 
				  <a id="CPreview3" style="background-color: <?php echo $R[Oubordercolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.Oubordercolor.value','window.opener.document.all.CPreview3.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>               
				  <input class="form-control" style="width:40%" name="Oubordercolor" type="text"   id="Oubordercolor" value="<?php echo $R[Oubordercolor]; ?>"  size=7 maxlength="7"> 
                  </td>
                  <td width="30%">กว้าง  :
                    <input class="form-control" style="width:20%" name="Ouborderw" type="text"  id="Ouborderw" value="<?php echo $R[Ouborderw]; ?>" size="2" maxlength="2" onKeyUp="document.getElementById('Ouborderw1').value=this.value"></td>
                  <td width="30%">รูปแบบ  : 
                    <select class="form-control" style="width:50%" name="Ouborderstyle"  id="Ouborderstyle" onChange="document.getElementById('Ouborderstyle1').value=this.value">
                      <option value="0" <?php if($R[Ouborderstyle]=="0"){ echo "selected"; } ?>>None 
                      <option value="1" <?php if($R[Ouborderstyle]=="1"){ echo "selected"; } ?>>Solid 
                      <option value="2" <?php if($R[Ouborderstyle]=="2"){ echo "selected"; } ?>>Double 
                      <option value="3" <?php if($R[Ouborderstyle]=="3"){ echo "selected"; } ?>>Dotted 
                      <option value="4" <?php if($R[Ouborderstyle]=="4"){ echo "selected"; } ?>>Dashed 
                      <option value="5" <?php if($R[Ouborderstyle]=="5"){ echo "selected"; } ?>>Groove 
                      <option value="6" <?php if($R[Ouborderstyle]=="6"){ echo "selected"; } ?>>Ridge 
                    </select> </td>
                </tr>
              </table>
			        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr valign="top"> 
                        <td width="40%"><div align="left">รูปภาพพื้นหลัง :</div>
					  <input class="form-control" style="width:80%" name="Oubgpic" type="text" id="Oubgpic" value="<?php echo $R[Oubgpic]; ?>">
                          <a href="#choose" onClick="choose_pic('window.opener.document.linkForm.Oubgpic.value');"><img src="../images/bar_open.gif" width="20" height="20" border="0" align="absmiddle"></a> 
                        </td>
                        <td width="30%"><div align="left">Icon :</div>
                      <input class="form-control" style="width:80%"  name="Gicon" type="text" id="Gicon" value="<?php echo $R[Gicon]; ?>">
                          <a href="#choose" onClick="choose_pic('window.opener.document.linkForm.Gicon.value');"><img src="../images/bar_open.gif" width="20" height="20" border="0" align="absmiddle"></a></td>
                        <td width="30%"><div align="left">Arrow :</div>
                      <input class="form-control" style="width:80%" name="Garrow" type="text" id="Garrow" value="<?php echo $R[Garrow]; ?>">
                          <a href="#choose" onClick="choose_pic('window.opener.document.linkForm.Garrow.value');"><img src="../images/bar_open.gif" width="20" height="20" border="0" align="absmiddle"></a></td>
                      </tr>
                    </table>
                  </td>
          </tr>
          
</table>
</td>
</tr>

<tr>
<td>
<table width="100%" border="0" align="center" class="table table-bordered" >
<tr bgcolor="#CCCCCC"> 
<td height="25" colspan="4"><strong>รูปแบบพิเศษเมื่อวาง mouse ผ่าน </strong></td>
</tr>
<tr bgcolor="#F7F7F7"> 
<td width="27%">แบบตัวหนังสือ  :
<select name="Ovfont"  id="Ovfont" class="form-control" style="width:40%">
                <?php $i = 0;
		 while($FontA[$i]){ ?>
                <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$R[Ovfont]){ echo "selected"; } ?>><?php echo $FontA[$i]; ?></option>
                <?php $i++;
		 } ?>
</select>
</td>
 <td width="23%">ขนาด  :
<select name="Ovsize"  id="Ovsize" class="form-control" style="width:40%">
                <?php for($f=5;$f<=72;$f++){ ?>
                <option value="<?php echo $f; ?>" <?php if($f==$R[Ovsize]){ echo "selected"; } ?>><?php echo $f; ?></option>
                <?php } ?>
</select> 
<select name="Ovsizepr"  id="Ovsizepr" class="form-control" style="width:40%">
                <option value="pt" <?php if($R[Ovsizepr]=="pt"){ echo "selected"; } ?>>pt</option>
                <option value="px" <?php if($R[Ovsizepr]=="px"){ echo "selected"; } ?>>px</option>
</select>
</td>
<td width="22%">
<table width="100%" >
<tr> 
	<td width="20%">สี  : </td>
	<td width="80%" > 
	<a id="CPreview4" style="background-color: <?php echo $R[Ovcolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.Ovcolor.value','window.opener.document.all.CPreview4.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>	
	<input class="form-control" style="width:40%" name="Ovcolor" type="text"   id="Ovcolor" value="<?php echo $R[Ovcolor]; ?>"  size=7 maxlength="7"> 
	</td>
</tr>
</table>
</td>
<td width="28%">
	<input name="Ovbold" type="checkbox" id="Ovbold" value="bold" <?php if($R[Ovbold]=="bold"){ echo "checked"; } ?>> 
	<strong><font face="Tahoma">หนา :</font> 
	<input name="Ovitalic" type="checkbox" id="Ovitalic" value="italic" <?php if($R[Ovitalic]=="italic"){ echo "checked"; } ?>>
	</strong><em><font face="Tahoma">เอียง :</font></em>
</td>
</tr>
<tr bgcolor="#F7F7F7"> 
<td>
<table  width="100%" >
<tr> 
	<td width="20%">สีพื้นหลัง  : </td>
	<td width="80%" > 
	<a id="CPreview5" style="background-color: <?php echo $R[Ovbgcolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.Ovbgcolor.value','window.opener.document.all.CPreview5.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>	
	<input class="form-control" style="width:40%" name="Ovbgcolor" type="text"   id="Ovbgcolor" value="<?php echo $R[Ovbgcolor]; ?>"  size=7 maxlength="7"> 
	</td>
</tr>
</table>
              <!--<input name="Ovtrans" type="checkbox" id="Ovtrans" value="1" <?php if($R[Ovtrans]=="1"){ echo "checked"; } ?>>
              Transparent-->
</td>
            <td colspan="3" valign="top"><div align="left"> </div>
              <table width="100%" >
                <tr> 
                  <td width="5%">สีขอบ  :</td>
                  <td width="35%" valign=center>
				  <a id="CPreview6" style="background-color: <?php echo $R[Ovbordercolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.Ovbordercolor.value','window.opener.document.all.CPreview6.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>
				  <input class="form-control" style="width:40%" name="Ovbordercolor" type="text"   id="Ovbordercolor" value="<?php echo $R[Ovbordercolor]; ?>"  size=7 maxlength="7"> 
                  </td>
                  <td width="30%"  valign=center>กว้าง  :
                    <input class="form-control" style="width:40%" name="Ouborderw1" type="text"  id="Ouborderw1" value="<?php echo $R[Ouborderw]; ?>" size="2" maxlength="2" onKeyUp="document.getElementById('Ouborderw').value=this.value"></td>
                  <td width="30%"  valign=center>รูปแบบ  :
                    <select  class="form-control" style="width:40%" name="Ouborderstyle1"  id="Ouborderstyle1" onChange="document.getElementById('Ouborderstyle').value=this.value">
                      <option value="0" <?php if($R[Ouborderstyle]=="0"){ echo "selected"; } ?>>None 
                      <option value="1" <?php if($R[Ouborderstyle]=="1"){ echo "selected"; } ?>>Solid 
                      <option value="2" <?php if($R[Ouborderstyle]=="2"){ echo "selected"; } ?>>Double 
                      <option value="3" <?php if($R[Ouborderstyle]=="3"){ echo "selected"; } ?>>Dotted 
                      <option value="4" <?php if($R[Ouborderstyle]=="4"){ echo "selected"; } ?>>Dashed 
                      <option value="5" <?php if($R[Ouborderstyle]=="5"){ echo "selected"; } ?>>Groove 
                      <option value="6" <?php if($R[Ouborderstyle]=="6"){ echo "selected"; } ?>>Ridge 
                    </select> 
					</td>
                </tr>
              </table>
              <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <tr> 
                  <td><div align="left">รูปพื้นหลัง :
                      <input class="form-control" style="width:40%" name="Ovbgpic" type="text" id="Ovbgpic" value="<?php echo $R[Ovbgpic]; ?>">
                           <a href="#choose" onClick="choose_pic('window.opener.document.linkForm.Ovbgpic.value');"><img src="../images/bar_open.gif" width="20" height="20" border="0" align="absmiddle"></a> 
                          </div>
                        </td>
                </tr>
              </table></td>
          </tr>
          <tr align="right" bgcolor="#F7F7F7"> 
            <td colspan="2"><div align="left"> 
                <input type="checkbox" name="set_default1" id="set_default1" value="Y">
                <font color="#FF0000"><strong>กำหนดค่าทั้งหมดเป็นค่าเริ่มต้น(Set 
                Default)</strong></font></div><div align="left"> 
                <input type="checkbox" name="set_to1" id="set_to1" value="Y" onClick="setbox(this,document.linkForm.set_to2)">
                <font color="#FF0000"><strong>ต้องการนำดีไซน์นี้ไปใช้กับเมนูอื่น</strong></font></div></td>
            <td colspan="2"><input type="submit" name="Submit2" value="Save" class="btn btn-success" /></td>
          </tr>
        </table></td>
          </tr>
        </table>

        </td>
    </tr>
    <?php
if($sub_row > 0){
?>
    
<tr id="tr03" style="display:<?php if($tbshow == "03"){ echo '\'\''; }else{ echo "none"; } ?>"> 
<td valign="top" bgcolor="F7F7F7">
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="25"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
          <tr>
                  <td width="100" align="center" background="../images/bg1_off.gif"><a href="#menu" onClick="document.all.tr01.style.display='';document.all.tr02.style.display='none';document.all.tr03.style.display='none';document.linkForm.tbshow.value='01';">Menu 
                    Setting</a> </td>
                  <td width="100" align="center" background="../images/bg1_off.gif"><a href="#design" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='';document.all.tr03.style.display='none';document.linkForm.tbshow.value='02';">Design</a></td>
                  <td width="100" align="center" background="../images/bg1_on.gif">Pop-up 
                    Setting </td>
            <td background="../images/bg2_off.gif">&nbsp;</td>
          </tr>
        </table></td>
          </tr>
          <tr>
            <td>

<table width="100%" border="0" align="center" class="table table-bordered">
          <tr bgcolor="#F7F7F7"> 
            <td width="27%">แสดงรูปแบบ  :
              <select name="PopDisplay"  id="PopDisplay" class="form-control" style="width:50%">
                <option value="1" <?php if($R[PopDisplay] == "1"){ echo "selected"; } ?>>Vertically 
                <option value="0" <?php if($R[PopDisplay] == "0"){ echo "selected"; } ?>>Horizontally 
              </select> </td>
            <td width="23%">แสดงพื้นหลัง : 
              <input class="form-control" style="width:20%" name="PopTrans" type="text"  id="PopTrans" value="<?php echo $R[PopTrans]; ?>" size="2" maxlength="2"></td>
            <td width="25%">กั้นขอบ  : 
              <input  class="form-control" style="width:20%" name="PopSpac" type="text"  id="PopSpac" value="<?php echo $R[PopSpac]; ?>" size="3" maxlength="2"></td>
            <td width="25%">กั้นขอบตัวหนังสือ  : 
              <input class="form-control" style="width:20%" name="PopPad" type="text"  id="PopPad" value="<?php echo $R[PopPad]; ?>" size="2" maxlength="2"></td>
          </tr>
          <tr bgcolor="#F7F7F7"> 
            <td><table border=0 cellspacing=0 cellpadding=1 width=100% >
                <tr> 
                  <td width="20%">สีพื้นหลัง : </td> 
				  <td width="70%"  > 
                  <a id="CPreview7" style="background-color: <?php echo $R[Popbgcolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.Popbgcolor.value','window.opener.document.all.CPreview7.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>
                 
				  <input class="form-control" style="width:50%" name="Popbgcolor" type="text"   id="Popbgcolor" value="<?php echo $R[Popbgcolor]; ?>"  size=7 maxlength="7"> 
                  </td>
                </tr>
              </table></td>
            <td colspan="3"><div align="left"> </div>
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr> 
                  <td>
				  <div align="left">รูปพื้นหลัง  : 
                      <input class="form-control" style="width:50%" name="Popbgpic" type="text" id="Popbgpic" value="<?php echo $R[Popbgpic]; ?>">
                     <a href="#choose" onClick="choose_pic('window.opener.document.linkForm.Popbgpic.value');"><img src="../images/bar_open.gif" width="20" height="20" border="0" align="absmiddle"></a></div>    </td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#F7F7F7"> 
            <td>ขนาดเส้นขอบ : 
              <input class="form-control" style="width:20%" name="PopBorderW" type="text"  id="PopBorderW" value="<?php echo $R[PopBorderW]; ?>" size="3"></td>
            <td><table border=0 cellspacing=0 cellpadding=1 width=100% >
                <tr> 
                  <td width="20%">สีเส้นขอบ : </td>
				  <td width="80%" > 
					<a id="CPreview8" style="background-color: <?php echo $R[Popbordercolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.Popbordercolor.value','window.opener.document.all.CPreview8.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>
                  
				  <input class="form-control" style="width:50%" name="Popbordercolor" type="text"   id="Popbordercolor" value="<?php echo $R[Popbordercolor]; ?>"  size=7 maxlength="7"> 
                  </td>
                </tr>
              </table></td>
            <td>รูปแบบพิเศษ  :
              <select name="Popborderstyle"  id="Popborderstyle" class="form-control" style="width:50%">
                <option value="0" <?php if($R[Popborderstyle]=="0"){ echo "selected"; } ?>>None 
                <option value="1" <?php if($R[Popborderstyle]=="1"){ echo "selected"; } ?>>Solid 
                <option value="2" <?php if($R[Popborderstyle]=="2"){ echo "selected"; } ?>>Double 
                <option value="3" <?php if($R[Popborderstyle]=="3"){ echo "selected"; } ?>>Dotted 
                <option value="4" <?php if($R[Popborderstyle]=="4"){ echo "selected"; } ?>>Dashed 
                <option value="5" <?php if($R[Popborderstyle]=="5"){ echo "selected"; } ?>>Groove 
                <option value="6" <?php if($R[Popborderstyle]=="6"){ echo "selected"; } ?>>Ridge 
              </select></td>
            <td rowspan="2" valign="top">เงา  : 
              <select name="Popshadowstyle" class="form-control" style="width:50%">
                <option value="0" <?php if($R[Popshadowstyle]=="0"){ echo "selected"; } ?>>None 
                <option value="1" <?php if($R[Popshadowstyle]=="1"){ echo "selected"; } ?>>Sample 
                <option value="2" <?php if($R[Popshadowstyle]=="2"){ echo "selected"; } ?>>Complex 
              </select> <br> <table border=0 cellspacing=0 cellpadding=1 width=100% >
                <tr> 
                  <td width="30%">ขนาด  :
                    <input class="form-control" style="width:50%" name="Popshadowsize" type="text"  id="Popshadowsize" value="<?php echo $R[Popshadowsize]; ?>" size="2" maxlength="2"></td>
                   <td width="70%" >
				   <a id="CPreview9" style="background-color: <?php echo $R[Popshadowcolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.Popshadowcolor.value','window.opener.document.all.CPreview9.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>
                  
				  <input class="form-control" style="width:50%" name="Popshadowcolor" type="text"   value="<?php echo $R[Popshadowcolor]; ?>"  size=7 maxlength="7" > 
                  </td>
                </tr>
              </table>
		  </td>
          </tr>
          <tr bgcolor="#F7F7F7"> 
            <td>ตำแหน่ง Popup :  
              <select name="PopDirect"  id="PopDirect" class="form-control" style="width:50%">
                <option value="1" <?php if($R[PopDirect]=="1"){ echo "selected"; } ?>>Left 
                <option value="2" <?php if($R[PopDirect]=="2"){ echo "selected"; } ?>>Right 
                <option value="3" <?php if($R[PopDirect]=="3"){ echo "selected"; } ?>>Up 
                <option value="4" <?php if($R[PopDirect]=="4"){ echo "selected"; } ?>>Down 
              </select></td>
            <td>ตำแหน่งแกน X :
              <input class="form-control" style="width:20%" name="PopX" type="text"  id="PopX" value="<?php echo $R[PopX]; ?>" size="3"></td>
            <td>ตำแหน่งแกน Y :
              <input class="form-control" style="width:20%" name="PopY" type="text"  id="PopY" value="<?php echo $R[PopY]; ?>" size="3"></td>
          </tr>
          <tr bgcolor="#F7F7F7"> 
            <td colspan="4">ความเร็วของรูปแบบพิเศษ  :
              <input class="form-control" style="width:5%" name="PopEffectSpeed" type="text"  id="PopEffectSpeed" value="<?php echo $R[PopEffectSpeed]; ?>" size="2" maxlength="2"> 
            </td>
          </tr>
          <tr bgcolor="#F7F7F7"> 
            <td colspan="2"><input type="checkbox" name="set_default2" id="set_default2" value="Y"> 
              <font color="#FF0000"><strong>กำหนดค่าทั้งหมดเป็นค่าเริ่มต้น(Set 
              Default)</strong></font><div align="left"> 
                <input type="checkbox" name="set_to2" id="set_to2" value="Y" onClick="setbox(this,document.linkForm.set_to1)">
                <font color="#FF0000"><strong>ต้องการนำดีไซน์นี้ไปใช้กับเมนูอื่น</strong></font></div></td>
            <td colspan="2" align="right"><input type="submit" name="Submit4" value="Save" class="btn btn-success" /></td>
          </tr>
        </table></td>
          </tr>
</table>
</td>
</tr>

    <?php }else{ ?>
    <input name="PopDisplay" type="hidden" value="<?php echo $R[PopDisplay]; ?>">
    <input name="PopTrans" type="hidden" value="<?php echo $R[PopTrans]; ?>">
    <input name="PopSpac" type="hidden" value="<?php echo $R[PopSpac]; ?>">
    <input name="PopPad" type="hidden" value="<?php echo $R[PopPad]; ?>">
    <input name="Popbgcolor" type="hidden" value="<?php echo $R[Popbgcolor]; ?>">
    <input name="Popbgpicn" type="hidden" value="<?php echo $R[Popbgpicn]; ?>">
    <input name="PopBorderW" type="hidden" value="<?php echo $R[PopBorderW]; ?>">
    <input name="Popbordercolor" type="hidden" value="<?php echo $R[Popbordercolor]; ?>">
    <input name="Popborderstyle" type="hidden" value="<?php echo $R[Popborderstyle]; ?>">
    <input name="Popshadowstyle" type="hidden" value="<?php echo $R[Popshadowstyle]; ?>">
    <input name="PopDirect" type="hidden" value="<?php echo $R[PopDirect]; ?>">
    <input name="PopX" type="hidden" value="<?php echo $R[PopX]; ?>">
    <input name="PopY" type="hidden" value="<?php echo $R[PopY]; ?>">
    <input name="Popshadowsize" type="hidden" value="<?php echo $R[Popshadowsize]; ?>">
    <input name="Popshadowcolor" type="hidden" value="<?php echo $R[Popshadowcolor]; ?>">
    <input name="PopEffectSpeed" type="hidden" value="<?php echo $R[PopEffectSpeed]; ?>">
	<input type="checkbox" name="set_to2" id="set_to2" value="Y" style="display:none">
    <?php }?>
  </form>
</table>
</body>
</html>
<?php
$db->db_close(); ?>