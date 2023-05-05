<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
include("../language.php");
$today=date("Y-m-d H:i:s");

if($_REQUEST["type"]=="category"){

// add category
	if($_POST["flag"]=='add'){
		$t_topic = addslashes(htmlspecialchars($_POST["t_topic"]));
		$t_detail = addslashes(htmlspecialchars($_POST["t_detail"]));
		$t_detail = eregi_replace(chr(13)," <br> ", $t_detail );
		$db->query("INSERT INTO `f_cat` ( `f_id` , `f_cate` , `f_detail`, `f_use` ,`f_no`,`f_date`,`f_time`) VALUES ('', '$t_topic', '$t_detail','Y','$_POST[f_no]',NOW(),NOW())");
		$db->write_log("create","faq",$text_genfaq_categoryadd.$t_topic);
		?>
			<script language="JavaScript">
			window.location.href = "faq_cate.php";
			</script>
		<?php
	}
	
//edit category
	if($_POST["flag"] == "edit"){
	$t_detail = eregi_replace("<br>","", $_POST["t_detail"] );
	$t_topic = addslashes(htmlspecialchars($_POST["t_topic"]));
	$t_detail = addslashes(htmlspecialchars($t_detail));
	$t_detail = eregi_replace(chr(13)," <br> ", $t_detail );
	$db->query("UPDATE   f_cat SET f_cate = '$t_topic', f_detail = '$t_detail' ,f_no='$_POST[f_no]'   WHERE f_id = '".$_POST["f_id"]."'");
	$db->write_log("update","faq",$text_genfaq_categoryedit.$t_topic);
	?>
	<script language="JavaScript"> 
		alert("<?php echo $text_genfaq_categoryedit_confirm;?>");
	window.location.href = "faq_cate.php?";
	</script>
		<?php
	}
	
	//delete category
	if($_POST["flag"] == "delete"){
		for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
			if($chk != ""){
					$rec = $db->db_fetch_array($db->query("select * from f_cat WHERE f_id = '$chk'"));
					$db->write_log("delete","faq",$text_genfaq_categorydelete.$rec[f_cate]);
					$db->query("DELETE  FROM  f_cat  WHERE f_id = '$chk'");
					$db->query("DELETE  FROM  f_subcat  WHERE f_id = '$chk'");
			}
		}
			?>
				<script language="JavaScript">
					alert("<?php echo $text_genfaq_categorydelete_confirm;?>");
					window.location.href = "faq_cate.php?";
				</script>
			<?php
	}
	//hide category
	if($_GET["flag"] == "hide"){
			$rec = $db->db_fetch_array($db->query("select * from f_cat WHERE f_id = '".$_GET["f_id"]."'"));
			$db->write_log("hidden","faq",$text_genfaq_categoryhide.$rec[f_cate]);
			$db->query("UPDATE `f_cat` SET f_use = 'N' WHERE f_id = '".$_GET["f_id"]."'");
			?>
			<script language="JavaScript">
			window.location.href = "faq_cate.php";
			</script>
			<?php
	}
	//show category
	if($_GET["flag"] == "show"){
			$rec = $db->db_fetch_array($db->query("select * from f_cat WHERE f_id =  '".$_GET["f_id"]."'"));
			$db->write_log("showfile","faq",$text_genfaq_categoryhshow .$rec[f_cate]);
			$db->query("UPDATE `f_cat` SET f_use = 'Y' WHERE f_id =  '".$_GET["f_id"]."'");
			?>
			<script language="JavaScript">
			window.location.href = "faq_cate.php";
			</script>
				<?php
	}
	
}else if($_REQUEST["type"]=="category_sub"){

	// add category sub
	if($_POST["flag"]=='add'){
			$t_topic = addslashes(htmlspecialchars($_POST["t_topic"]));
			$t_detail = addslashes(htmlspecialchars($_POST["t_detail"]));
			$t_detail = eregi_replace(chr(13)," <br> ", $t_detail );
			$db->query("INSERT INTO `f_subcat` ( `f_parent` , `f_subcate` , `f_subdetail`, `f_use` ,`f_sub_no`,`f_sub_date`,`f_sub_time`) VALUES ('".$_POST["f_id"]."', '$t_topic', '$t_detail','Y','$_POST[f_no]',NOW(),NOW())");
			$db->write_log("create","faq",$text_genfaq_categoryadd_sub.$t_topic);
			?>
				<script language="JavaScript">
				window.location.href = "faq_sub.php?f_id=<?php echo $_POST["f_id"]?>";
				</script>
			<?php
	}
	//edit category sub
	if($_POST["flag"] == "edit"){
			$t_detail = eregi_replace("<br>","", $_POST["t_detail"] );
			$t_topic = addslashes(htmlspecialchars($_POST["t_topic"]));
			$t_detail = addslashes(htmlspecialchars($t_detail));
			$t_detail = eregi_replace(chr(13)," <br> ", $t_detail );
			$db->query("UPDATE   f_subcat SET f_subcate = '$t_topic', f_subdetail = '$t_detail' ,  f_id = '".$_POST["f_id"]."',f_sub_no='".$_POST["f_no"]."'  ,f_parent =  '".$_POST["c_parent"]."' 	WHERE f_sub_id = '".$_POST["f_sub_id"]."'   ");
			$db->write_log("update","faq",$text_genfaq_categoryedit_sub.$t_topic);
			?>
				<script language="JavaScript">
				alert("<?php echo $text_genfaq_categoryedit_sub_confirm;?>");
				window.location.href = "faq_sub.php?f_id=<?php echo $_POST["f_id"]?>";
				</script>
			<?php
	}
	//delete category sub
	if($_POST["flag"] == "delete"){
		for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
			if($chk != ""){
					$rec = $db->db_fetch_array($db->query("select * from f_subcat WHERE f_sub_id = '$chk' "));
					$db->write_log("delete","faq",$text_genfaq_categorydelete_sub.$rec[f_subcate]);
					//$db->query("DELETE  FROM  f_subcat  WHERE f_parent = '$chk' ");//delete child
					$db->query("DELETE  FROM  f_subcat  WHERE f_sub_id = '$chk' ");

			}
		}
			?>
				<script language="JavaScript">
						alert("<?php echo $text_genfaq_categorydelete_sub_confirm;?>");
						window.location.href = "faq_sub.php?f_id=<?php echo $_POST["f_id"]?>";
				</script>
			<?php
	}
		//hide category sub
	if($_GET["flag"] == "hide"){
			$rec = $db->db_fetch_array($db->query("select * from f_subcat WHERE f_sub_id = '".$_GET["f_sub_id"]."'"));
			$db->write_log("hidden","faq",$text_genfaq_categoryhide_sub.$rec[f_subcate]);
			$db->query("UPDATE `f_subcat` SET f_use = 'N' WHERE f_sub_id = '".$_GET["f_sub_id"]."'");
		?>
		<script language="JavaScript">
		window.location.href = "faq_sub.php?f_id=<?php echo $_GET["f_id"]?>";
		</script>
		<?php
	}
	//show category sub
	if($_GET["flag"] == "show"){
				$rec = $db->db_fetch_array($db->query("select * from f_subcat WHERE f_sub_id =  '".$_GET["f_sub_id"]."'"));
				$db->write_log("showfile","faq",$text_genfaq_categoryhshow_sub.$rec[f_subcate]);
				$db->query("UPDATE `f_subcat` SET f_use = 'Y' WHERE f_sub_id = '".$_GET["f_sub_id"]."'");
			?>
			<script language="JavaScript">
				window.location.href = "faq_sub.php?f_id=<?php echo $_GET["f_id"]?>";
			</script>
			<?php
	}
}

///End CATEGORY========================================

if($_POST["flag"] == "addfaq"){
		$fdetail = eregi_replace(chr(13)," <br> ", $_POST["fdetail"] );
		$fans = eregi_replace(chr(13)," <br> ", $_POST["fans"] );
		$fname = eregi_replace(chr(13)," <br> ", $_POST["fname"] );
$db->query("INSERT INTO faq (fa_id,f_id,fa_name,fa_detail,fa_user_ask,fa_user_ans,fa_ans,f_sub_id,faq_use,faq_top,faq_date,faq_dateans) VALUES ('','".$_POST["f_id"]."','$fname','$fdetail','".$_SESSION["EWT_SMUSER"]."','".$_SESSION["EWT_SMUSER"]."','$fans','".$_POST["f_sub_id"]."','".$_POST["faq_use"]."','".$_POST["faq_top"]."','$today','$today')");

//multi search function
if($search_center == "Y"){  
	$query_max=$db->query("SELECT MAX(fa_id) as maxid  FROM  faq ");
	$data_max=$db->db_fetch_array($query_max);
	$max_faq_id=$data_max[maxid];

	$db->ms_module='F'; 
	$db->ms_link_id=$max_faq_id;
	$db->multi_search_update();
}

if($_POST["faq_user_id"]){
	$db->query("UPDATE   faq_user  SET faq_status = '1' WHERE faq_user_id = '".$_POST["faq_user_id"]."'   ");
}

$db->write_log("create","faq",$text_genfaq_faqadd.$fname);

?>
<script language="JavaScript">
	alert("<?php echo $text_genfaq_faqadd_confirm;?>");
window.location.href = "faq_sub.php?f_id=<?php echo $_POST["f_sub_id"]; ?>";
</script>
	<?php
}
if($_POST["flag"] == "delfaq"){
for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
			if($chk != ""){
				$rec = $db->db_fetch_array($db->query("select * from faq WHERE fa_id = '$chk' "));
				$db->write_log("delete","faq",$text_genfaq_faqdelete.$rec[fa_name]);
				$db->query("DELETE FROM faq WHERE fa_id = '$chk' " );
				
				//multi search function
				if($search_center == "Y"){  
					$db->ms_module='F'; 
					$db->ms_link_id=$chk; 
					$db->multi_search_delete();
				}
	}
}
?>
<script language="JavaScript">
	alert("<?php echo $text_genfaq_faqdelete_confirm;?>");
window.location.href = "faq_sub.php?f_id=<?php echo $_POST["f_id"]; ?>&f_sub_id=<?php echo $_POST["f_sub_id"]; ?>";
</script>
	<?php
}
if($_POST["flag"] == "editfaq"){
	$fdetail = eregi_replace("<br>","", $_POST["fdetail"] );
	$fans = eregi_replace("<br>","", $_POST["fans"] );
	$fname = eregi_replace("<br>","", $_POST["fname"] );
		$fdetail = eregi_replace(chr(13)," <br> ", $fdetail );
		$fans = eregi_replace(chr(13)," <br> ", $fans );
		$fname = eregi_replace(chr(13)," <br> ", $fname );
$db->query("UPDATE faq SET fa_name = '$fname',fa_detail = '$fdetail',fa_user_ans = '".$_SESSION["EWT_SMUSER"]."',fa_ans = '$fans'  ,faq_use = '".$_POST["faq_use"]."',faq_top = '".$_POST["faq_top"]."',faq_dateans= '$today',f_sub_id='".$_POST["faqsub_id"]."'     WHERE fa_id = '".$_POST["fa_id"]."'");
$db->write_log("update","faq",$text_genfaq_faqedit.$fname);

//multi search function
if($search_center == "Y"){  
	$db->ms_module='F'; 
	$db->ms_link_id=$_POST["fa_id"]; 
	$db->multi_search_update();
}
?>
<script language="JavaScript">
	alert("<?php echo $text_genfaq_faqedit_confirm;?>");
window.location.href = "faq_sub.php?f_id=<?php echo $_POST["f_id"]; ?>&f_sub_id=<?php echo $_POST["f_sub_id"]; ?>";
</script>
	<?php
}

if($_POST["flag"] == "approve"){
	for($i=0;$i<count($_POST["user_id"]);$i++){
		$chk = $_POST["user_id"][$i];
		$list = $i."_".$chk;
		$srt = $_POST[$list];
		if($srt != ""){
		$rec = $db->db_fetch_array($db->query( "select * from faq_user where faq_user_id = '$chk'"));
			if($srt == '1'){
				$db->query("INSERT INTO faq (fa_id,f_id,fa_name,fa_detail,fa_user_ask,fa_ans,f_sub_id,faq_use,faq_top,faq_date) VALUES ('','".$rec["f_id"]."','".$rec["faq_user_name"]."','".$rec["faq_user_detail"]."','".$rec["faq_user_ask"]."','".$rec["faq_user_ans"]."','".$rec["f_sub_id"]."','Y','','$today')");
				$db->query("UPDATE   faq_user  SET faq_status = '1' WHERE faq_user_id = '".$chk."'   ");
				$db->write_log("create","faq",$text_genfaq_faqadd.$fname);
			}else if($srt == '2'){
				$db->write_log("approve","faq","ไม่อนุมัติ faq   ".$rec[faq_user_name]);
				$db->query("UPDATE   faq_user  SET faq_status = '1' WHERE faq_user_id = '$chk'   ");
			}
		}
	}
	?>
<script language="JavaScript">
window.location.href = "faq_user.php";
</script>
	<?php
}

?>
<?php @$db->db_close(); ?>