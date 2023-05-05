<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT BID FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
	$sql_check = $db->query("SELECT a_id FROM article_apply WHERE text_id = '".$BID."' AND c_id = '".$_GET["cid"]."' ");
	$A = $db->db_fetch_row($sql_check);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>
	  <frameset rows="0,*" framespacing="0" frameborder="Yes" border="1" >
    <frame src="article_preview.php?aid=<?php echo $A[0]; ?>&B=<?php echo $_GET["B"]; ?>" name="article_preview" scrolling="YES" frameborder="1" >
    <frame src="article_config.php?aid=<?php echo $A[0]; ?>&B=<?php echo $_GET["B"]; ?>" name="article_config"  scrolling="YES" frameborder="1" >
  </frameset>
<noframes><body>

</body></noframes>
</html>
<?php } ?>
<?php $db->db_close(); ?>
