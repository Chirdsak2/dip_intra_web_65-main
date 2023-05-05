<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$user = $_SESSION["EWT_SUSER"];
$y = 0;

	?>
<html>
<head>
<title>Share &amp; Public Content</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="E0DFE3">
  <form  method="post" name="form1" action="content_bfunction.php" ><tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td valign="top" bgcolor="FCFCFE">
              <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
                <tr valign="top"> 
                  <td width="100%" height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>Share &amp; Public Content</strong> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <?php echo $_POST["filename"]; ?> 
                    <hr size="1"></td>
                </tr>
                <tr align="center" valign="top"> 
                  <td><div align="left"><strong>Selected 
                      <input type="checkbox" name="checkbox" value="checkbox">
                      to Share &amp; Public Content</strong></div>
                    <table width="99%" border="0" cellpadding="1" cellspacing="1" bgcolor="#006600">
                      <tr valign="top" bgcolor="#FFFFFF"> 
                        <td height="40" colspan="3">
                          <?php
						  $topi = explode("##@@##",$_POST["blocki3"]);
						  $topn = explode("##@@##",$_POST["blockn3"]);
		  			for($i=0;$i<count($topi);$i++){
		  				if($topi[$i] != ""){
						$sql = $db->query("SELECT COUNT(s_id) AS CT FROM share_content WHERE s_user = '".$user."' AND s_bid = '".$topi[$i]."' ");
						$c = $db->db_fetch_row($sql);
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#FFFFCC"><input name="chk<?php echo $y; ?>" type="checkbox"  value="Y" <?php if($c[0] > 0){ echo "checked"; } ?>> <input name="bi<?php echo $y; ?>" type="hidden"  value="<?php echo $topi[$i]; ?>">
                                <?php echo $topn[$i]; ?> </td>
                            </tr>
                          </table>
                          <?php $y++; }} ?>
                        </td>
                      </tr>
                      <tr valign="top" bgcolor="#FFFFFF"> 
                        <td width="33%" height="120">
                          <?php
						  $topi = explode("##@@##",$_POST["blocki1"]);
						  $topn = explode("##@@##",$_POST["blockn1"]);
		  			for($i=0;$i<count($topi);$i++){
		  				if($topi[$i] != ""){
						$sql = $db->query("SELECT COUNT(s_id) AS CT FROM share_content WHERE s_user = '".$user."' AND s_bid = '".$topi[$i]."' ");
						$c = $db->db_fetch_row($sql);
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#CCCCFF"><input name="chk<?php echo $y; ?>" type="checkbox"  value="Y" <?php if($c[0] > 0){ echo "checked"; } ?>> <input name="bi<?php echo $y; ?>" type="hidden"  value="<?php echo $topi[$i]; ?>">
                                <?php echo $topn[$i]; ?> </td>
                            </tr>
                          </table>
                          <?php $y++; }} ?>
                        </td>
                        <td width="34%">
                          <?php
						  $topi = explode("##@@##",$_POST["blocki5"]);
						  $topn = explode("##@@##",$_POST["blockn5"]);
		  			for($i=0;$i<count($topi);$i++){
		  				if($topi[$i] != ""){
						$sql = $db->query("SELECT COUNT(s_id) AS CT FROM share_content WHERE s_user = '".$user."' AND s_bid = '".$topi[$i]."' ");
						$c = $db->db_fetch_row($sql);
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#CCFFCC"><input name="chk<?php echo $y; ?>" type="checkbox"  value="Y" <?php if($c[0] > 0){ echo "checked"; } ?>> <input name="bi<?php echo $y; ?>" type="hidden"  value="<?php echo $topi[$i]; ?>">
                                <?php echo $topn[$i]; ?> </td>
                            </tr>
                          </table>
                          <?php $y++; }} ?>
                        </td>
                        <td width="33%">
                         <?php
						  $topi = explode("##@@##",$_POST["blocki2"]);
						  $topn = explode("##@@##",$_POST["blockn2"]);
		  			for($i=0;$i<count($topi);$i++){
		  				if($topi[$i] != ""){
						$sql = $db->query("SELECT COUNT(s_id) AS CT FROM share_content WHERE s_user = '".$user."' AND s_bid = '".$topi[$i]."' ");
						$c = $db->db_fetch_row($sql);
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#FFCCFF"><input name="chk<?php echo $y; ?>" type="checkbox"  value="Y" <?php if($c[0] > 0){ echo "checked"; } ?>> <input name="bi<?php echo $y; ?>" type="hidden"  value="<?php echo $topi[$i]; ?>">
                                <?php echo $topn[$i]; ?> </td>
                            </tr>
                          </table>
                          <?php $y++; }} ?>
                        </td>
                      </tr>
                      <tr valign="top" bgcolor="#FFFFFF"> 
                        <td height="40" colspan="3">
                          <?php
						  $topi = explode("##@@##",$_POST["blocki4"]);
						  $topn = explode("##@@##",$_POST["blockn4"]);
		  			for($i=0;$i<count($topi);$i++){
		  				if($topi[$i] != ""){
						$sql = $db->query("SELECT COUNT(s_id) AS CT FROM share_content WHERE s_user = '".$user."' AND s_bid = '".$topi[$i]."' ");
						$c = $db->db_fetch_row($sql);
						  ?>
                          <table width="180" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#E0E0E0"><input name="chk<?php echo $y; ?>" type="checkbox"  value="Y" <?php if($c[0] > 0){ echo "checked"; } ?>> <input name="bi<?php echo $y; ?>" type="hidden"  value="<?php echo $topi[$i]; ?>">
                                <?php echo $topn[$i]; ?> </td>
                            </tr>
                          </table>
                          <?php $y++; }} ?>
                        </td>
                      </tr>
                    </table></td>
                </tr>
                <tr valign="top"> 
                  <td height="10" align="right"><hr size="1"> <input name="filename" type="hidden" id="filename" value="<?php echo $_POST["filename"]; ?>"> 
                    <input name="Flag" type="hidden" id="Flag" value="Share_Public"> 
                    <input name="ally" type="hidden" id="ally" value="<?php echo $y; ?>">
                    <input type="submit" name="Submit" value="Share&amp;Public"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
                </tr>
              </table> </td>
        </tr>
      </table></td>
  </tr></form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
