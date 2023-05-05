<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];

if($_POST["flag"] == "update"){
	$sql = "DELETE FROM guest_apply WHERE BID = '".$BID."' ";
	$db->query($sql);
	for($i=0; $i < count($_POST["show"]); $i++){
		$sql = "
			INSERT INTO guest_apply(
				gc_id,
				BID
			)VALUES(
				'".$_POST["show"][$i]."', 
				'".$BID."'
			)
		";
		$db->query($sql);
	}
	echo "
		<script>alert('UPDATE show guestbook success.');</script>
	";
}

$sql = "SELECT * FROM guest_cate";
$query = $db->query($sql);
$rows = $db->db_num_rows($query);

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
		<form id="form1" name="form1" method="post" action="">
	<?php
		while($rec_guestbook = $db->db_fetch_array($query)){
			$g_sql = "
				SELECT * FROM guest_apply
				WHERE BID = '".$BID."'
				AND gc_id = '".$rec_guestbook["gc_id"]."'
			";
			$g_query = $db->query($g_sql);
			if($db->db_num_rows($g_query) > 0){ $checked = "checked=\"checked\" "; }
			else{ $checked = ""; }
			echo '<input name="show[]" type="checkbox" id="show[]" '.$checked.' value="'.$rec_guestbook["gc_id"].'" /> '.$rec_guestbook["gc_name"].'<br />';
		}
	?>
	<input type="submit" name="Submit" value="Submit">
        <input name="flag" type="hidden" id="flag" value="update">
		</form>
</body>
</html>