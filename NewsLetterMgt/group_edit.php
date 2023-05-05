<?php
include("authority.php");
?>
<?php 

if($_GET["flag"] == 'Edit'){

	//$sel = "select * from n_group where g_id = '$gid'";
	$sel = "select * from n_group,article_group where c_id = g_name and g_id = '".$_GET["gid"]."'";
	$r = $db->query($sel);
	$R = mysql_fetch_array($r);
}
?>
<html>
<head>
<title>Newsletter Group Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<SCRIPT >
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
if (emptyField(document.form1.g_name)){
				alert("<?php echo $lang_valid_name_group; ?>");
				document.form1.g_name.focus();
				return false;
		}

return true;
	}																														//end function()
//-->
</script>
</head>

<body bgcolor="#FFFFFF">
<form name="form1" method="post" action="group_function.php" onSubmit="return validateForm();">
<br>
  <table width="90%" align="center" class="table table-bordered">
    <tr bgcolor="#33CCFF"> 
      <td height="30" bgcolor="B2B4BF"> &nbsp;<?php echo $lang_group_title; ?></td>
    </tr>
    <tr> 
      <td height="49"> 
        <table width="100%" align="center" class="table table-bordered">
          <tr bgcolor="ECEBF0"> 
            <td width="22%" height="38"><?php echo $lang_group_name_show; ?></td>
            <td width="78%" height="38"><?php echo $R['c_name']; ?><input name="g_name" type="hidden" id="g_name" value="<?php if($flag == 'Edit') {echo $R['g_name']; }?>" size="50"></td>
          </tr>
		  <tr bgcolor="ECEBF0">
            <td height="38">ชนิดกลุ่ม</td>
            <td height="38"><input name="gtype" type="radio" value="1" <?php if($R['g2'] != "2"){ echo "checked"; } ?>>
              เฉพาะบุคลภายใน
              <input name="gtype" type="radio" value="2" <?php if($R['g2'] == "2"){ echo "checked"; } ?>>
              ทั้งภายในภายนอก</td>
          </tr>
          <tr bgcolor="ECEBF0">
            <td height="38"><?php echo $lang_group_detail; ?></td>
            <td height="38"><textarea class="form-control" style="width:100%;" name="g_des" cols="50" rows="3" wrap="VIRTUAL"><?php echo $R['g1']; ?></textarea></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr > 
      <td > 
        <div align="center"> 
          <?php 
if($_GET["flag"] == 'Edit'){
?>
          <input type="hidden" name="flag" value="Edit">
	    	<input type="hidden" name="gid" value="<?php echo $R['g_id'];?>">	
			<input type="hidden" name="gn" value="<?php echo $R['g_name'];?>">	
<?php }else{ ?>
          <input type="hidden" name="flag" value="Add">
<?php } ?>
          <input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
        </div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
