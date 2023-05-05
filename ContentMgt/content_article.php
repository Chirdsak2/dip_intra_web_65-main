<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_row($sql_file);
	?>
<html>
<head>
<title>Article Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function DelForm(){
		if(confirm("Are you sure you want to delete selected data?")){
			article_data.form1.submit();
		}
	}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="E0DFE3">
  <tr>
    <td><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>Block : <?php echo $R[0]; ?></strong></td>
              </tr>
              <tr>
                  <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td align="center" ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td width="100" align="center" background="../images/bg1_on.gif">Article 
                        Group </td>
                      <td width="100" align="center" background="../images/bg3_off.gif"><a href="article_position.php?B=<?php echo $_GET["B"]; ?>">Manage 
                        Position</a> </td>
                     <td width="100" align="center" background="../images/bg3_off.gif"><a href="article_design.php?B=<?php echo $_GET["B"]; ?>">Design</a> </td>
                      <td background="../images/bg2_off.gif">&nbsp;</td>
                    </tr>
					</table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="10"> <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="display:none">
                          <tr> 
                            <td width="5" background="../images/content_bg_line.gif"></td>
                            <td > &nbsp;&nbsp;<a name="backoff"><img src="../images/article_back_off.gif" width="20" height="20" border="0" align="absmiddle"> 
                              <font color="#999999">Back</font></a><a name="backon" style="display:none" href="#" onClick="article_data.location.href=article_data.document.form1.backto.value;"><img src="../images/article_back.gif" width="20" height="20" border="0" align="absmiddle"> 
                              Back</a>&nbsp;&nbsp;&nbsp;<a name="folderoff" style="display:none"><img src="../images/article_newfolder_off.gif" width="20" height="20" border="0" align="absmiddle"> 
                              <font color="#999999">New Group</font></a><a name="folderon" href="#" onClick="article_data.document.all.new_fo.style.display = '';article_data.document.form1.new_folder.focus();"><img src="../images/article_newfolder.gif" width="20" height="20" border="0" align="absmiddle"> 
                              New Group</a>&nbsp;&nbsp;&nbsp;<a href="#" onClick="article_data.location.href='article_new.php';"><img src="../images/article_newfile.gif" width="20" height="20" border="0" align="absmiddle"> 
                              New Article</a> </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
                          <tr> 
                            <td bgcolor="#FFFFFF"><iframe name="article_data" src="article_group.php" frameborder="0"  width="100%" height="100%" scrolling="yes" ></iframe></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="right" style="display:none"> 
                      <td height="22"><a name="deloff" style="display:none"><img src="../images/article_del_off.gif" width="20" height="20" border="0" align="absmiddle"> 
                        <font color="#999999">Delete Selected</font></a><a name="delon" href="#del" onClick="DelForm()"><img src="../images/article_del.gif" width="20" height="20" border="0" align="absmiddle"> 
                        Delete Selected</a></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php } ?>
<?php $db->db_close(); ?>
