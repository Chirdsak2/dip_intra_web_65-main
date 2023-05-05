<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($_POST["Flag"] == "Save"){

$bcode = base64_decode($_POST["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT BID FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$db->query("UPDATE article_apply SET a_active = 'N' WHERE text_id = '".$BID."'  ");
$all = count($_POST["chk"]);
	$txt = " WHERE ( 0 ";
		for($i=0;$i<$all;$i++){
			$txt .= " OR article_group.c_id = '".$_POST["chk"][$i]."' ";
		}
	$txt .= " ) ";
$sql_text = "SELECT article_group.c_id,article_apply.a_id,article_apply.a_pos FROM article_group LEFT JOIN article_apply ON article_group.c_id = article_apply.c_id  AND article_apply.text_id = '".$BID."' ".$txt." ORDER BY article_apply.a_pos ASC";
$sql_check = $db->query($sql_text);
$dshow = "5";
//default
$sql_design = $db->query("SELECT * FROM article_apply WHERE AMDefault = 'Y' ");
							if($db->db_num_rows($sql_design) > 0){
							$R = $db->db_fetch_array($sql_design);
								if($R["AMWidth"] == "" OR $R["AMWidth"] == "0"){
									$R["AMWidth"] = "100%";
								}
								if($R["a_show"] == "" OR $R["a_show"] == "0"){
									$R["a_show"] = $dshow;
								}
							}else{
							$R["AMWidth"] = "100%";
							$R["a_show"] = $dshow;
							$R["AMHeadF"] = "Tahoma";
							$R["AMHeadS"] = "3";
							$R["AMBodyBP"] = "images/assets/main_bl.gif";
							$R["AMBodyF"] = "Tahoma";
							$R["AMBodyS"] = "2";
							$R["AMMORE"] = "อ่านทั้งหมด";
							$R["AMBottomF"] = "Tahoma";
							$R["AMBottomS"] = "1";
							$R["AMUseHead"] = "Y";
							$R["AMDetailF"] = "Tahoma";
							$R["AMDetailS"] = "1";
							$R["AMDate"] = "Y";
							}
//
	$x = 500;
	while($C = $db->db_fetch_array($sql_check)){
		if($C["a_id"] == ""){
									$db->query("INSERT INTO article_apply (text_id,c_id,a_pos,a_show,a_active, amd_mode, code_html, AMBulletBP, AMBulletSP, AMHeadBG, AMHeadP, AMHeadF, AMHeadS, AMHeadC, AMHeadB, AMHeadI, AMBodyBP, AMBodyBG, AMBodyF, AMBodyS, AMBodyC, AMBodyB, AMBodyI, AMMorePic, AMMORE, AMBottomF, AMBottomS, AMBottomC, AMBottomB, AMBottomI, AMBOTTOMP, AMBOTTOMBG, AMBOTTOMH, AMDefault, AMWidth, AMUseHead, AMHeadH, AMUseDetail, AMDetailF, AMDetailS, AMDetailC, AMDetailB, AMDetailI, AMDate,AMBulletBPW ,AMBulletBPH ,AMBulletSPW ,AMBulletSPH ,AMBodyBPW ,AMBodyBPH ,block_theme) VALUES ('".$BID."','".$C["c_id"]."','".$x."','".$R["a_show"]."','Y','".$R[" amd_mode"]."','".$R["code_html"]."','".$R["AMBulletBP"]."','".$R["AMBulletSP"]."','".$R["AMHeadBG"]."','".$R["AMHeadP"]."','".$R["AMHeadF"]."','".$R["AMHeadS"]."','".$R["AMHeadC"]."','".$R["AMHeadB"]."','".$R["AMHeadI"]."','".$R["AMBodyBP"]."','".$R["AMBodyBG"]."','".$R["AMBodyF"]."','".$R["AMBodyS"]."','".$R["AMBodyC"]."','".$R["AMBodyB"]."','".$R["AMBodyI"]."','".$R["AMMorePic"]."','".$R["AMMORE"]."','".$R["AMBottomF"]."','".$R["AMBottomS"]."','".$R["AMBottomC"]."','".$R["AMBottomB"]."','".$R["AMBottomI"]."','".$R["AMBOTTOMP"]."','".$R["AMBOTTOMBG"]."','".$R["AMBOTTOMH"]."','','".$R["AMWidth"]."','".$R["AMUseHead"]."','".$R["AMHeadH"]."','".$R["AMUseDetail"]."','".$R["AMDetailF"]."','".$R["AMDetailS"]."','".$R["AMDetailC"]."','".$R["AMDetailB"]."','".$R["AMDetailI"]."','".$R["AMDate"]."','".$R["AMBulletBPW"]."', '".$R["AMBulletBPH"]."', '".$R["AMBulletSPW"]."', '".$R["AMBulletSPH"]."' , '".$R["AMBodyBPW"]."', '".$R["AMBodyBPH"]."', '".$R["block_theme"]."')");
								if($R["code_html"] == "Y"){
									$max = $db->query("SELECT a_id FROM article_apply WHERE text_id = '".$BID."' AND c_id = '".$C["c_id"]."' ");
									$M = $db->db_fetch_row($max);
									@copy("ewt/".$_SESSION["EWT_SUSER"]."/article/DA_".$R["a_id"].".htm","ewt/".$_SESSION["EWT_SUSER"]."/article/DA_".$M[0].".htm");

								}
								$x++;
		}else{

				$pos = $C["a_pos"];

			$db->query("UPDATE article_apply SET a_active = 'Y',a_pos = '$pos' WHERE a_id = '".$C["a_id"]."' ");
		}
	}
	?>
	<script language="javascript">
	self.location.href = "article_position_all.php?B=<?php echo $_POST["B"];?>";	
	</script>
	<?php
}
}
 $db->db_close(); ?>
