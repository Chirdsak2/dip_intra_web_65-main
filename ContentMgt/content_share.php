<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$block_id = array();
$block_n = array();

		for($i=1;$i<=5;$i++){
			$sql_block = $db->query("SELECT block.BID,block.block_name FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '".$i."' AND block.block_type != 'share' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
			$b_id = "";
			$b_n = "";
		  		while($B = $db->db_fetch_row($sql_block)){
		  			$b_id .= $B[0]."##@@##";
					$b_n .= $B[1]."##@@##";			
		  		}
			 	$block_id[$i] = $b_id;
				$block_n[$i] = $b_n;
		  }
	?>
<html>
<head>
<title>Share &amp; Public Content</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="E0DFE3">
  <form  method="post" name="form1" action="content_b_share.php" ><tr>
      <td align="center" valign="middle"><font color="#666666" size="4" face="Tahoma"><strong>Please 
        Wait.....</strong></font> 
        <?php
		for($i=1;$i<=5;$i++){
		?> 
		<input type="hidden" name="blocki<?php echo $i; ?>" value="<?php echo $block_id[$i]; ?>">
        <input type="hidden" name="blockn<?php echo $i; ?>" value="<?php echo $block_n[$i]; ?>">
        <?php
		}
		?>
		<input type="hidden" name="filename" value="<?php echo $_GET["filename"]; ?>">
		<input type="hidden" name="Flag" value="Checked">
        </td>
  </tr></form>
</table>
</body>
</html>
<script language="JavaScript">
form1.submit();
</script>
<?php $db->db_close(); ?>
