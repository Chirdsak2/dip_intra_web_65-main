<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$filename=$_GET['filename'];
$arrSelected=array();
$qSelected=$db->query('SELECT * FROM block_sitemap WHERE filename=\''.$filename.'\' AND sid=\''.$_GET['sid'].'\'');
while($rSelected=$db->db_fetch_array($qSelected)) {
	array_push($arrSelected, $rSelected['BID']);
}

?>
<html>
<head>
<title>Share &amp; Public Content</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="E0DFE3">
  <form  method="post" name="form1" action="menu_sitemap_function.php" ><tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td valign="top" bgcolor="FCFCFE">
              <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
                <tr valign="top"> 
                  <td width="100%" height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>Sitemap block</strong> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <?php echo $filename; ?> 
                    <hr size="1"></td>
                </tr>
                <tr align="center" valign="top"> 
                  <td><div align="left"><strong>Selected 
                      <input type="checkbox" name="checkbox" value="checkbox">
                      to display block on sitemap</strong></div>
                    <table width="99%" border="0" cellpadding="1" cellspacing="1" bgcolor="#006600">
                      <tr valign="top" bgcolor="#FFFFFF"> 
                        <td height="40" colspan="3">
                          <?php
						  $topi = explode("##@@##",$_POST["blocki3"]);
						  $topn = explode("##@@##",$_POST["blockn3"]);
		  			$sql_top = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$filename."' ORDER BY block_function.position ASC");
							while($TB = $db->db_fetch_array($sql_top)) {
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#CCCCFF"><input name="chk[]" type="checkbox"  value="<?php echo $TB['BID']; ?> " <?php if(in_array($TB['BID'],$arrSelected)){ echo "checked"; } ?>><?php echo $TB['block_name']; ?></td>
                            </tr>
                          </table>
                          <?php $y++; } ?>
                        </td>
                      </tr>
                      <tr valign="top" bgcolor="#FFFFFF"> 
                        <td width="33%" height="120">
                          <?php
						  $topi = explode("##@@##",$_POST["blocki1"]);
						  $topn = explode("##@@##",$_POST["blockn1"]);
		  			$sql_left = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$filename."' ORDER BY block_function.position ASC");
							while($LB = $db->db_fetch_array($sql_left)){
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#CCCCFF"><input name="chk[]" type="checkbox"  value="<?php echo $LB['BID']; ?> " <?php if(in_array($LB['BID'],$arrSelected)){ echo "checked"; } ?>><?php echo $LB['block_name']; ?>  </td>
                            </tr>
                          </table>
                          <?php $y++; } ?>
                        </td>
                        <td width="34%">
                          <?php
						  $topi = explode("##@@##",$_POST["blocki5"]);
						  $topn = explode("##@@##",$_POST["blockn5"]);
		  			$sql_content = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$filename."' ORDER BY block_function.position ASC");
							while($CB = $db->db_fetch_array($sql_content)){
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#CCCCFF"><input name="chk[]" type="checkbox"  value="<?php echo $CB['BID']; ?> " <?php if(in_array($CB['BID'],$arrSelected)){ echo "checked"; } ?>><?php echo $CB['block_name']; ?>  </td>
                            </tr>
                          </table>
                          <?php $y++; } ?>
                        </td>
                        <td width="33%">
                         <?php
						  $topi = explode("##@@##",$_POST["blocki2"]);
						  $topn = explode("##@@##",$_POST["blockn2"]);
		  			$sql_right = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$filename."' ORDER BY block_function.position ASC");
							while($RB = $db->db_fetch_array($sql_right)){
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#CCCCFF"><input name="chk[]" type="checkbox"  value="<?php echo $RB['BID']; ?> " <?php if(in_array($RB['BID'],$arrSelected)){ echo "checked"; } ?>><?php echo $RB['block_name']; ?>  </td>
                            </tr>
                          </table>
                          <?php $y++; } ?>
                        </td>
                      </tr>
                      <tr valign="top" bgcolor="#FFFFFF"> 
                        <td height="40" colspan="3">
                          <?php
						  $topi = explode("##@@##",$_POST["blocki4"]);
						  $topn = explode("##@@##",$_POST["blockn4"]);
		  			$sql_bottom = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$filename."' ORDER BY block_function.position ASC");
							while($BB = $db->db_fetch_array($sql_bottom)){
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#CCCCFF"><input name="chk[]" type="checkbox"  value="<?php echo $BB['BID']; ?> " <?php if(in_array($BB['BID'],$arrSelected)){ echo "checked"; } ?>><?php echo $BB['block_name']; ?>  </td>
                            </tr>
                          </table>
                          <?php $y++; } ?>
                        </td>
                      </tr>
                    </table></td>
                </tr>
                <tr valign="top"> 
                  <td height="10" align="right"><hr size="1"> <input name="filename" type="hidden" id="filename" value="<?php echo $_POST["filename"]; ?>"> 
                    <input name="Flag" type="hidden" id="Flag" value="UpdateSitemapBlock">
                    <input name="filename" type="hidden" id="filename" value="<?php echo $filename; ?>">
                    <input name="sid" type="hidden" id="sid" value="<?php echo $_GET['sid']; ?>">
                    <input type="submit" name="Submit" value="แก้ไข"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <input type="button" name="Submit2" value="ยกเลิก" onClick="window.location.href='menu_sitemap_page.php?sid=<?php echo $_GET['sid']; ?>';"></td>
                </tr>
              </table> </td>
        </tr>
      </table></td>
  </tr></form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
