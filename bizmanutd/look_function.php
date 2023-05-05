<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
//$m_name = stripslashes(htmlspecialchars($_REQUEST["m_name"],ENT_QUOTES));

if($_POST["Flag"] == "Add"){

	$sql_check = $db->query("SELECT d_name FROM design_list WHERE d_name = '".$_POST["design_name"]."'");
	if($db->db_num_rows($sql_check) > 0){
		?>
			<script language="javascript">
				alert("\"<?php echo $_POST["design_name"]; ?>\" is already exist!!!!");
				self.location.href = "site_template.php";
			</script>
		<?php
			exit;
	}

$sql_default = $db->query("SELECT * FROM design_list WHERE d_default = 'Y' ");
if($db->db_num_rows($sql_default) > 0){
$D = $db->db_fetch_array($sql_default);
$d_default = "";
$d_site_align = $D["d_site_align"];
$d_site_width = $D["d_site_width"];
$d_site_left = $D["d_site_left"];
$d_site_content = $D["d_site_content"];
$d_site_right = $D["d_site_right"];
$d_site_bg_c = $D["d_site_bg_c"];
$d_site_bg_p = $D["d_site_bg_p"];
$d_top_height = $D["d_top_height"];
$d_top_bg_c = $D["d_top_bg_c"];
$d_top_bg_p = $D["d_top_bg_p"];
$d_top_content = $D["d_top_content"];
$d_left_bg_c = $D["d_left_bg_c"];
$d_left_bg_p = $D["d_left_bg_p"];
$d_right_bg_c = $D["d_right_bg_c"];
$d_right_bg_p = $D["d_right_bg_p"];
$d_bottom_height = $D["d_bottom_height"];
$d_bottom_bg_c = $D["d_bottom_bg_c"];
$d_bottom_bg_p = $D["d_bottom_bg_p"];
$d_bottom_content = $D["d_bottom_content"];
}else{
$d_default = "Y";
$d_site_align = "center";
$d_site_width = "800";
$d_site_left = "200";
$d_site_content = "400";
$d_site_right = "200";
$d_site_bg_c = "#FFFFFF";
$d_site_bg_p = "";
$d_top_height = "80";
$d_top_bg_c = "#FFFFFF";
$d_top_bg_p = "";
$d_top_content = "";
$d_left_bg_c = "#FFFFFF";
$d_left_bg_p = "";
$d_right_bg_c = "#FFFFFF";
$d_right_bg_p = "";
$d_bottom_height = "30";
$d_bottom_bg_c = "#FFFFFF";
$d_bottom_bg_p = "";
$d_bottom_content = "";
}

$db->query("INSERT INTO design_list (d_name,d_default,d_site_align,d_site_width,d_site_left,d_site_content,d_site_right,d_site_bg_c,d_site_bg_p,d_top_height,d_top_bg_c,d_top_bg_p,d_top_content,d_left_bg_c,d_left_bg_p,d_right_bg_c,d_right_bg_p,d_bottom_height,d_bottom_bg_c,d_bottom_bg_p,d_bottom_content) VALUES ('".$_POST["design_name"]."','".$d_default."','".$d_site_align."','".$d_site_width."','".$d_site_left."','".$d_site_content."','".$d_site_right."','".$d_site_bg_c."','".$d_site_bg_p."','".$d_top_height."','".$d_top_bg_c."','".$d_top_bg_p."','".$d_top_content."','".$d_left_bg_c."','".$d_left_bg_p."','".$d_right_bg_c."','".$d_right_bg_p."','".$d_bottom_height."','".$d_bottom_bg_c."','".$d_bottom_bg_p."','".$d_bottom_content."')");

		$sql_max = $db->query("SELECT MAX(d_id) AS DID FROM design_list WHERE d_name = '".$_POST["design_name"]."' ");
		$M = $db->db_fetch_row($sql_max);
	@mkdir("../template/tmp".$M[0], 0777);
	@chmod("../template/tmp".$M[0], 0777);
	@mkdir("../template/tmp".$M[0]."/images", 0777);
	@chmod("../template/tmp".$M[0]."/images", 0777);
				?>
			<script language="javascript">
				self.location.href = "content_mgt.php?d_id=<?php echo $M[0]; ?>";
			</script>
		<?php
}
if($_POST["Flag"] == "SaveDataConfig"){
				if($_POST["no_bgsite"] == "Y"){
				$_POST["d_site_bg_p"] = "";
			}
			if($_POST["no_bgtop"] == "Y"){
				$_POST["d_top_bg_p"] = "";
			}
			if($_POST["no_bgleft"] == "Y"){
				$_POST["d_left_bg_p"] = "";
			}
			if($_POST["no_bgcontent"] == "Y"){
				$_POST["d_body_bg_p"] = "";
			}
			if($_POST["no_bgright"] == "Y"){
				$_POST["d_right_bg_p"] = "";
			}
			if($_POST["no_bgbottom"] == "Y"){
				$_POST["d_bottom_bg_p"] = "";
			}
$Update = "UPDATE design_list SET d_site_align = '".$_POST["d_site_align"]."',
d_site_width = '".$_POST["d_site_width"]."',
d_site_left = '".$_POST["d_site_left"]."',
d_site_content = '".$_POST["d_site_content"]."',
d_site_right = '".$_POST["d_site_right"]."',
d_site_bg_c = '".$_POST["d_site_bg_c"]."',
d_site_bg_p = '".$_POST["d_site_bg_p"]."',
d_top_height = '".$_POST["d_top_height"]."',
d_top_bg_c = '".$_POST["d_top_bg_c"]."',
d_top_bg_p = '".$_POST["d_top_bg_p"]."',
d_body_bg_c = '".$_POST["d_body_bg_c"]."',
d_body_bg_p = '".$_POST["d_body_bg_p"]."',
d_left_bg_c = '".$_POST["d_left_bg_c"]."',
d_left_bg_p = '".$_POST["d_left_bg_p"]."',
d_right_bg_c = '".$_POST["d_right_bg_c"]."',
d_right_bg_p = '".$_POST["d_right_bg_p"]."',
d_bottom_height = '".$_POST["d_bottom_height"]."',
d_bottom_bg_c = '".$_POST["d_bottom_bg_c"]."',
d_bottom_bg_p = '".$_POST["d_bottom_bg_p"]."' WHERE d_id = '".$_POST["d_id"]."'";
$db->query($Update);
				?>
<script language="javascript">
self.location.href = "content_mgt.php?d_id=<?php echo $_POST["d_id"]; ?>";
</script>
		<?php 
}
$db->db_close(); ?>
