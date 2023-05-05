<?php
include("authority.php");
?>
<?php 

if($flag == 'Edit'){

	$sel = "select * from n_domain where d_id = '$did'";
	$r = $db->query($sel);
	$R = mysql_fetch_array($r);
}
?>
<html>
<head>
<title>Newsletter Domain Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<SCRIPT language=JavaScript>
<!--
	 function emptyField(textObj) {
	   if (textObj.value.length == 0)
    		 return true;
	   for (var i=0; i<textObj.value.length; ++i) {
		     var ch = textObj.value.charAt(i);
		     if (ch != ' ' && ch != '	')
		        return false;
	   }
	   return true;
	 } 

	function  validateForm() {
if (emptyField(document.form1.d_name)){
				alert("กรุณากรอกชื่อ Domain name");
				document.form1.d_name.focus();
				return false;
		}

return true;
	}																														//end function()
//-->
</script>
</head>

<body bgcolor="#FFFFFF">
<form name="form1" method="post" action="domain_function.php" onSubmit="return validateForm();">
  <table width="95%" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="B2B4BF">
    <tr bgcolor="#33CCFF"> 
      <td height="30" bgcolor="B2B4BF"> <b><font face="MS Sans Serif" size="1">&nbsp;Domain 
        Name </font></b></td>
    </tr>
    <tr> 
      <td height="49"> 
        <table width="100%" border="0" cellpadding="2" cellspacing="1">
          <tr bgcolor="ECEBF0"> 
            <td width="22%" height="38"><b><font face="MS Sans Serif" size="1">ชื่อ Domain name</font><font face="MS Sans Serif" size="1" color="#FF0000">*</font></b></td>
            <td width="78%" height="38"> <input name="d_name" type="text" id="d_name" value="<?php if($flag == 'Edit') {echo $R['d_name']; }?>" size="40"> 
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr bgcolor="#33CCFF"> 
      <td bgcolor="B2B4BF" height="27"> 
        <div align="right"> 
          <?php 
if($flag == 'Edit'){
?>
          <input type="hidden" name="flag" value="Edit">
	    	<input type="hidden" name="did" value="<?php echo $R['d_id'];?>">	
			<input type="hidden" name="dn" value="<?php echo $R['d_name'];?>">	
<?php }else{ ?>
          <input type="hidden" name="flag" value="Add">
<?php } ?>
          <input type="submit" name="Submit" value="บันทึก">
        </div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
