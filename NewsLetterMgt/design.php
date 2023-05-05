<?php
include("authority.php");
?>
<?php include($UserPath."enewsletter.dll"); ?>
<html>
<head>
<title>EasyGraph by BizPotential</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body leftmargin="0" topmargin="0" >
<?php
include('menu.php');
?><br>
<?php if($msg == 'Y') {?>
<div align="center">
  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#333333" bgcolor="ECEBF0" <?php if($msg == 'Y') {?>border="1"<?php }?>align="center">
    <tr>
      <td>    
        <div align="center"><font face="MS Sans Serif" size="2"> 
          
          <font color="#000000" size="1"><strong><?php echo $lang_data_update; ?></strong></font></font></div>
      </td>
  </tr>
</table>
</div><br>

<?php }?>
<form name="form1" method="post" action="design_function.php">
<?php $i=0; ?>
<table width="96%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF">
<tr bgcolor="B2B4BF"> 
      <td align="right" valign="top"><div align="center"><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_name; ?></strong></font></div>        <div align="center"><font size="2" face="MS Sans Serif, Tahoma, sans-serif"></font></div>        <div align="center"><font size="2" face="MS Sans Serif, Tahoma, sans-serif"></font></div></td>
      <td align="right" valign="top"><div align="center"><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_use; ?></strong></font></div></td>
      <td width="9%" valign="top"><div align="center"><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_edit; ?></strong></font></div></td>
      <td width="11%" valign="top"><div align="center"><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_design_delete; ?></strong></font></div></td>
  </tr>
<?php 
	  $objFolder = opendir($UserPath."temp");
	  while($data = readdir($objFolder))
			{
				$arrExt = explode(".", $data);
if($data != "." && $data !=".." && $arrExt[1]=="dll")
				{ 
				?>
				
	
    <tr bgcolor="ECEBF0"> 
      <td width="71%"><font color="#000000" size="2" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $arrExt[0]; ?></font>
      </td>
      <td width="9%" align="center"><input type="radio" name="seltemp" value="<?php echo $arrExt[0]; ?>" <?php if($enewsletter == $arrExt[0]){ echo "checked"; } ?>></td>
      <td width="9%" valign="top" bgcolor="ECEBF0"><div align="center"><a href="#" onClick="window.open('design_n.php?Flag=Edit&filenameS=<?php echo $arrExt[0]; ?>','EditDesign','scrollbars=1,resizable=1,location=0');"><img src="../images/document_edit.gif" width="16" height="16" border="0"></a></div></td>
      <td width="11%"><div align="center">
          <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $arrExt[0]; ?>" <?php if(($arrExt[0] == "default_newsletter")or($enewsletter == $arrExt[0])){ echo "disabled"; } ?>>
      </div></td>
    </tr>
	<?php
	$i++;
			}
				}
				closedir($objFolder);
	   ?>	
    <tr bgcolor="B2B4BF">
      <td colspan="3" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="1%"><a href="#" onClick="window.open('design_n.php?Flag=Add','AddDesign','scrollbars=1,resizable=1,location=0');"><img src="../images/document_edit.gif" width="16" height="16" border="0"></a></td>
            <td width="99%"><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><strong><a href="#" onClick="window.open('design_n.php?Flag=Add','AddDesign','scrollbars=1,resizable=1,location=0');"><font color="#000000"><?php echo $lang_design_add; ?></font></a></strong></font></td>
          </tr>
      </table></td>
      <td valign="top"><div align="center">
        
          <input name="all" type="hidden" id="all" value="<?php echo $i; ?>">
          <input name="Flaggo" type="hidden" id="Flaggo" value="del">
          <input type="submit" name="Submit" value="Update" onClick="return confirm('<?php echo $lang_design_change; ?>');">
</div></td>
    </tr>

</table>
</form>
</body>
</html>
<script language="JavaScript">
function chk(){
if(document.form1.style_g.value=="default"){
alert("Please select style of graph");
document.form1.style_g.focus();
return false;
}
else{
return true;
}
}
</script>
