<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("../ewt_menu_preview.php");
include("../ewt_article_preview.php");
$user = $_SESSION["EWT_SUSER"];

if($_POST["Flag"] == "Share_Public"){
$use_data = "";
$use_datan = "";
	for($i=0;$i<$_POST["ally"];$i++){
		$bid = $_POST["bi".$i];
		$buse = $_POST["chk".$i];
			if($buse == "Y"){
				$use_data .= $bid."@";
				$share_path = "Y";
				$text = show_block($bid);
				$fw = @fopen("../share_content/".$user."_ewt_".$bid.".inc", "w");
				$FlagW = fwrite($fw, $text);
				@fclose($fw);
				$db->query("UPDATE block SET block_share = 'Y' WHERE BID = '".$bid."' ");
				$sql_n = $db->query("SELECT block_name FROM block WHERE BID = '".$bid."'");
				$BN = $db->db_fetch_row($sql_n);
				$use_datan .= $BN[0]."##@@##";
			}
	}
?>
<html>
<head>
<title>Share &amp; Public Content</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="E0DFE3">
  <form  method="post" name="form1" action="content_share_function.php" ><tr>
      <td align="center" valign="middle"><font color="#666666" size="4" face="Tahoma"><strong>Please 
        Wait.....</strong></font> 
		<input type="hidden" name="buse" value="<?php echo $use_data; ?>">
		<input type="hidden" name="busename" value="<?php echo $use_datan; ?>">
		<input type="hidden" name="Flag" value="UpdateP">
        </td>
  </tr></form>
</table>
</body>
</html>
<script language="JavaScript">
form1.submit();
</script>
<?php
}	
$db->db_close(); ?>
