<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$i = 0;

	?>
<html>
<head>
<title>Save as Template</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php $checkS = $db->query("select d_name from design_list"); ?>
<SCRIPT LANGUAGE="JavaScript">
	var list= new Array()
	<?php while($W = $db->db_fetch_array($checkS)){ ?>
								list[list.length]='<?php echo $W[d_name]; ?>';
	<?php } ?>
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
					alert("Your Web Template's name is too short or too long");
					document.form1.file_name.select();
					return false;
			}else if (document.form1.file_name.value.search("^[A-Za-z0-9_]+$")){
				alert("Web Template's name is limited to English character  (upper and lower case), number, and underscore only!");
				document.form1.file_name.select();
				return false;
			}
			var tp = 1;
			for(i=0;i<list.length;i++){
				if(document.form1.file_name.value == list[i]){
					tp = 2;
				}
			}
			if(tp == 2){
				var r = confirm("Template name \""+document.form1.file_name.value+"\" already exists!!\nDo you want to replace this template?");
				if(r == true){
				return true;
				}else{
				document.form1.file_name.select();
				return false;
				}
			}
		}else{
				alert("Please assign name for your Web Template");
				document.form1.file_name.focus();
				return false;
		}
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
                    <strong>Save as Template</strong> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <?php echo $_GET["filename"]; ?> <hr size="1"></td>
                </tr>
                <tr valign="top"> 
                  <td width="50%" height="30"> 
                    <table width="100%" border="0" cellspacing="1" cellpadding="3">
                      <tr valign="top"> 
                        <td width="35%">Template name: </td>
                        <td width="65%"><input name="file_name" type="text" id="file_name" size="30"></td>
                      </tr>
                    </table></td>
                  <td width="50%">&nbsp;</td>
                </tr>
                <tr align="center" valign="top">
                  <td colspan="2"><div align="left"><strong>Block Option &gt;&gt; </strong>
                      <input name="checkbox2" type="checkbox" value="checkbox" onClick="this.checked = false;">
                      Can not Edit 
                      <input name="checkbox3" type="checkbox" value="checkbox" checked onClick="this.checked = true;">
                      Editable on each page</div>
                      <table width="99%" border="0" cellpadding="1" cellspacing="1" bgcolor="#006600">
                        <tr valign="top" bgcolor="#FFFFFF"> 
                          <td height="40" colspan="3"><?php
						  $sql_top = $db->query("SELECT block.BID,block.block_name FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
						  ?>
						  <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr>
                              <td bgcolor="#FFFFCC"><input name="chk<?php echo $TB[0]; ?>" type="checkbox" id="chk<?php echo $TB[0]; ?>" value="Y">
                                <?php echo $TB[1]; ?>
                              </td>
                            </tr>
                          </table>
						  <?php $i++; } ?>
                          </td>
                        </tr>
                        <tr valign="top" bgcolor="#FFFFFF"> 
                          <td width="33%" height="120"><?php
		  $sql_left = $db->query("SELECT block.BID,block.block_name FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
						  ?><table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr>
                              <td bgcolor="#CCCCFF"><input name="chk<?php echo $LB[0]; ?>" type="checkbox" id="chk<?php echo $LB[0]; ?>" value="Y">  <?php echo $LB[1]; ?>
                              </td>
                            </tr>
                          </table>
						  <?php $i++;  } ?></td>
                          <td width="34%"><?php
		  $sql_content = $db->query("SELECT block.BID,block.block_name FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?><table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr>
                              <td bgcolor="#CCFFCC"><input name="chk<?php echo $CB[0]; ?>" type="checkbox" id="chk<?php echo $CB[0]; ?>" value="Y">  <?php echo $CB[1]; ?>
                              </td>
                            </tr>
                          </table>
						  <?php $i++;  } ?></td>
                          <td width="33%"><?php
		  $sql_right = $db->query("SELECT block.BID,block.block_name FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?><table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr>
                              <td bgcolor="#FFCCFF"><input name="chk<?php echo $RB[0]; ?>" type="checkbox" id="chk<?php echo $RB[0]; ?>" value="Y">  <?php echo $RB[1]; ?>
                              </td>
                            </tr>
                          </table>
						  <?php $i++;  } ?></td>
                        </tr>
                        <tr valign="top" bgcolor="#FFFFFF"> 
                          <td height="40" colspan="3"><?php
		  $sql_bottom = $db->query("SELECT block.BID,block.block_name FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?><table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr>
                              <td bgcolor="#E0E0E0"><input name="chk<?php echo $BB[0]; ?>" type="checkbox" id="chk<?php echo $BB[0]; ?>" value="Y">  <?php echo $BB[1]; ?>
                              </td>
                            </tr>
                          </table>
						  <?php $i++;  } ?></td>
                        </tr>
                      </table>
                    </td>
                </tr>
				<tr valign="top"> 
                  <td height="10" colspan="2" align="right"><hr size="1">
                    <input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>">
                    <input name="Flag" type="hidden" id="Flag" value="SaveToTemp"> 
                          <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>"><input type="submit" name="Submit" value="Create"> 
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
