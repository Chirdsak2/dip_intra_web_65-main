<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$sql = $db->query("SELECT block.BID,block.block_name FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE  block_function.filename = '".$_GET["filename"]."' AND (block_function.side = '1' OR block_function.side = '2' OR block_function.side = '5') ORDER BY block_function.position ASC");
echo "<form name=\"formTosave\" method=\"post\" action=\"#\">";
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";
	$x=0;
while($B = $db->db_fetch_row($sql)){
$sql_check = $db->query("SELECT block_member.BID FROM  block_member WHERE block_member.BID = '$B[0]' AND filename = '".$_GET["filename"]."' AND block_member.mid = '".$_GET["mid"]."' ");
	if($db->db_num_rows($sql_check) == 0){
				if($x%4 == 0){
		echo "<tr>";
		}
		?>
		
  <td  valign="top" width="25%"><input type="checkbox" name="chk[]" value="<?php echo $B[0]; ?>"> <font size="1" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $B[1]; ?></font></td>

		<?php
			$x++;
		if($x%4 == 0){
		echo "</tr>";
		}
	}

}
if($x%4==1 OR $x%4==2 OR $x%4==3){
		echo "</tr></table>";
	}
		echo "<input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"SetupB\"><input name=\"filename\" type=\"hidden\" id=\"filename\" value=\"".$_GET["filename"]."\"></form>";
$db->db_close(); ?>
