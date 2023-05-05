<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("cms","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.close();
				</script>
				<?php
}
$group = "SELECT * FROM temp_main_group";
$sql_group= $db->query($group);
	?>
<html>
<head>
<title>New Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<SCRIPT LANGUAGE="JavaScript">
	function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
	}
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
	function  chk() {
		if (!emptyField(document.form1.file_name)){
			if (!validLength(document.form1.file_name.value,2,100)){
					alert("Your Web Content Page's name is too short or too long");
					document.form1.file_name.select();
					return false;
			}else if (document.form1.file_name.value.search("^[A-Za-z0-9_]+$")){
				alert("Web Content Page's name is limited to English character  (upper and lower case), number, and underscore only!");
				document.form1.file_name.select();
				return false;
			}
		}else{
				alert("Please assign name for your Web Content Page");
				document.form1.file_name.focus();
				return false;
		}
		if(document.form1.group_id.value == ""){
				alert("Please select group");
				return false;
		}
	} 
	function preview(c){
	t_preview.location.href = "../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id=" + c;
	}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="E0DFE3">
  <form  method="post" enctype="multipart/form-data" name="form1" action="content_function.php" onSubmit="return chk()"><tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td valign="top" bgcolor="FCFCFE">
              <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
                <tr valign="top"> 
                  <td height="20" colspan="2"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>New Page</strong> <hr size="1"></td>
                </tr>
                <tr valign="top"> 
                  <td width="50%"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
                      <tr valign="top"> 
                        <td width="35%">Page Name : </td>
                        <td width="65%"><input name="file_name" type="text" id="file_name" size="30"></td>
                      </tr>
                      <tr valign="top"> 
                        <td>Title : </td>
                        <td><input name="title" type="text" id="title" size="30"></td>
                      </tr>
                      <tr valign="top"> 
                        <td>Description : </td>
                        <td><textarea name="description" cols="30" rows="5" wrap="VIRTUAL" id="description"></textarea></td>
                      </tr>
                      <tr valign="top"> 
                        <td>Keyword : </td>
                        <td><textarea name="keyword" cols="30" rows="5" wrap="VIRTUAL" id="keyword"></textarea></td>
                      </tr>
                    </table></td>
                  <td width="50%"> <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1">
                      <tr> 
                        <td height="20" bgcolor="#FFFFFF">Location : <span id="gname"></span></td>
                      </tr>
                      <tr> 
                        <td bgcolor="#FFFFFF"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#FFFFFF"><iframe name="iframe_data" src="content_list.php" frameborder="1"  width="100%" height="100%" scrolling="yes"></iframe></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center" valign="top">
                  <td height="230" colspan="2"><table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1">
                      <tr> 
                        <td width="50%" valign="top"> 
                          <table width="100%" border="0" cellspacing="1" cellpadding="1">
                            <tr valign="top"> 
                              <td width="35%">Template Design :</td>
                              <td width="65%"> 
                                <?php
						$sql_temp = $db->query("SELECT d_id,d_name,d_default FROM design_list ");
						?>
                                <select name="template" size="16" style="width:180px" onChange="preview(this.value)">
                                  <?php while($T=$db->db_fetch_array($sql_temp)){ ?>
                                  <option value="<?php echo $T["d_id"]; ?>" <?php if($T["d_default"] == "Y"){ echo "selected"; $did = $T["d_id"]; } ?>><?php echo $T["d_name"]; ?></option>
                                  <?php } ?>
                                </select></td>
                            </tr>
                          </table></td>
                        <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1">
                            <tr> 
                              <td height="25" bgcolor="#FFFFFF">Preview : <a href="#view" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id='+document.form1.template.value+'','','width=800,height=600,resizable=1,scrollbars=1');"><img src="../images/bar_view.gif" width="20" height="20" border="0" align="absmiddle"></a></td>
                            </tr>
                            <tr>
                              <td align="center" valign="middle" bgcolor="#FFFFFF"><iframe name="t_preview" src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id=<?php echo $did; ?>" frameborder="1"  width="100%" height="100%" scrolling="yes"></iframe></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
				<tr valign="top"> 
                  <td height="10" colspan="2" align="right"><hr size="1"> <input name="Flag" type="hidden" id="Flag" value="Add"> 
                          <input name="group_id" type="hidden" id="group_id" value=""><input type="submit" name="Submit" value="Create"> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
                </tr>
              </table> </td>
        </tr>
      </table></td>
  </tr></form>
</table>
<script language="JavaScript">
document.form1.file_name.focus();
</script>
</body>
</html>
<?php $db->db_close(); ?>
