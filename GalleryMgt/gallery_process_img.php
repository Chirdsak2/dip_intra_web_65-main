<?php
	session_start();
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	$sql = "select * from site_info";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	$size_max = $rec[site_info_max_img] * 1024;
	if($_POST[flag] == 'add'){
		include("../ewt_thumbnail.php");
		$usedchk = 0;
		$catchk_id = array();
		//check data name = db ?
		for($i=0;$i<count($_POST[category_id]);$i++){
			$sql_chk = "select gallery_cat_img.category_id from gallery_image,gallery_cat_img where gallery_cat_img.img_id =gallery_image.img_id and   img_name ='".stripslashes(htmlspecialchars($_POST[category_name]))."' and gallery_cat_img.category_id = '".$_POST[category_id][$i]."'";
			$query = $db->query($sql_chk);
			if($db->db_num_rows($query) > 0){
				$usedchk = 1;
				array_push($catchk_id,$_POST[category_id][$i]);
			}
		}

		if($usedchk == 1){
			?>
				<script language="JavaScript">
					alert("ชื่อรูปภาพนี้มีอยู่แล้วในระบบ กรุณาตรวจสอบ หรือใช้ชื่อรูปภาพอื่น!!!!!!!!");
					window.location.href = 'gallery_view_category.php?category_id=<?php echo $catchk_id[0];?>';
				</script>
			<?php
			exit;
		}

		if($_POST[chkchange]=='yes'){
			$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery/";
			$Path_db = "images/gallery/";
			if (!file_exists( "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery")) {
				mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery", 0777);
			}
			$gfile = "g".date("YmdHis")."_g";
			$tfile = "t".date("YmdHis")."_t";
			if($_FILES["filep"]['size'] > 0 ){
				if($_FILES['filep']['size'] > $size_max){
					?>
						<script language="JavaScript">
							alert("Can not upload \"<?php echo $_FILES["filep"]["name"]; ?>\"!! File size over <?php echo $rec[site_info_max_img]; ?> KB.");
							//window.close();
							window.location.href = 'gallery_view_category.php?category_id=<?php echo $_POST[category_id][0];?>';
						</script>
					<?php
					exit;
				}
				$F = explode(".",$_FILES["filep"]["name"]);
				$C = count($F);
				$CT = $C-1;
				$dir = strtolower($F[$CT]);
				if($dir == "jpeg"){ $dir = "jpg"; }
					$picname = $gfile.".".$dir;
					//	echo $Path_true.$picname;
					if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
					copy($_FILES["filep"]["tmp_name"],$Path_true.$picname);
					@chmod ($Path_true.$picname, 0777);
					$hi = "150";
					$wi = "150";
					$tpicname = $tfile.".".$dir;
					if($dir == "jpg"){
						thumb_jpg($Path_true.$picname,$Path_true.$tpicname, $wi, $hi);
					}
					if($dir == "gif"){
						thumb_gif($Path_true.$picname,$Path_true.$tpicname, $wi, $hi);
					}
					if($dir == "png"){
						thumb_png($Path_true.$picname,$Path_true.$tpicname, $wi, $hi);
					}
				}else if($dir == "swf" ){
						copy($_FILES["filep"]["tmp_name"],$Path_true.$picname);
						@chmod ($Path_true.$picname, 0777);
						$tpicname = $picname;
						$picname= $picname;
				}
			}
			/*print $_POST[category_name]; print "<br>";
			print $_POST[category_detail];print "<br>";
			print $_POST[s_images];print "<br>";
			print $_POST[b_images];print "<br>";*/
			//print count($_POST[category_id]);print "<br>";
			//if($_POST[add] == "add_all" ){
			for($i=0;$i<count($_POST[category_id]);$i++){
				$sql_insert  = "INSERT INTO gallery_image (img_name,img_detail,img_path_s,img_path_b,img_update,img_create) VALUES ('".stripslashes(htmlspecialchars($_POST[category_name]))."','".stripslashes(htmlspecialchars($_POST[category_detail]))."','".$Path_db.$tpicname."','".$Path_db.$picname."',NOW(),NOW())";
				$db->query($sql_insert);
				$sql_max_imgId = "SELECT max(img_id) as imgId_mag FROM gallery_image";
				$query_max_imgId = $db->query($sql_max_imgId);
				$imgId_max = $db->db_fetch_array($query_max_imgId);

				//multi search function
				if($search_center == "Y"){   
					$db->ms_module='G'; 
					$db->ms_link_id=$imgId_max[imgId_mag];
					$db->multi_search_update();
				}

				$sql_cat_img = "INSERT INTO gallery_cat_img (category_id,img_id) VALUES ('".$_POST[category_id][$i]."','".$imgId_max[imgId_mag]."')";
				$db->query($sql_cat_img);
				$rec=$db->db_fetch_array($db->query("select * from gallery_category where category_id = '".$_POST[category_id][$i]."'"));
				$db->write_log("create","gallery","เพิ่มรูปภาพ   ".$_POST[category_name]."  ลงในหมวดหมู่ gallery   ".$rec[category_name]);
			}
		}else{
			for($i=0;$i<count($_POST[category_id]);$i++){
				$sql_insert  = "INSERT INTO gallery_image (img_name,img_detail,img_path_s,img_path_b,img_update,img_create) VALUES ('".stripslashes(htmlspecialchars($_POST[category_name]))."','".stripslashes(htmlspecialchars($_POST[category_detail]))."','".$_POST[b_images]."','".$_POST[b_images]."',NOW(),NOW())";
				$db->query($sql_insert);
				$sql_max_imgId = "SELECT max(img_id) as imgId_mag FROM gallery_image";
				$query_max_imgId = $db->query($sql_max_imgId);
				$imgId_max = $db->db_fetch_array($query_max_imgId);

                //multi search function
				if($search_center == "Y"){   
					$db->ms_module='G'; 
					$db->ms_link_id=$imgId_max[imgId_mag];
					$db->multi_search_update();
				}

				$sql_cat_img = "INSERT INTO gallery_cat_img (category_id,img_id) VALUES ('".$_POST[category_id][$i]."','".$imgId_max[imgId_mag]."')";
				$db->query($sql_cat_img);
				$rec=$db->db_fetch_array($db->query("select * from gallery_category where category_id = '".$_POST[category_id][$i]."'"));
				$db->write_log("create","gallery","เพิ่มรูปภาพ   ".$_POST[category_name]."  ลงในหมวดหมู่ gallery   ".$rec[category_name]);
			}
		}	
	//}
		print "<script>";
		print "alert('บันทึกข้อมูลแล้ว');";
		if($_POST[ref] == "2"){
			//echo "window.opener.location.reload();" ;
		}
		//echo "window.opener.location.reload();" ;
		//print "window.close();";
		print "window.location.href = 'gallery_view_category.php?category_id=".$_POST[category_id][0]." '; ";
		print "</script>";
	}

	if($_POST[flag] == 'edit'){
		include("../ewt_thumbnail.php");
		$usedchk = 0;
		$catchk_id = array();
		//check data name = db ?
		$sql_chk = "select * from gallery_image,gallery_cat_img where gallery_cat_img.img_id =gallery_image.img_id and   img_name ='".stripslashes(htmlspecialchars($_POST[category_name]))."' and gallery_cat_img.category_id = '".$_POST[category_id]."' AND  gallery_image.img_id != '".$_POST[img_id]."' ";
		$query = $db->query($sql_chk);
		if($db->db_num_rows($query) > 0){
			$usedchk = 1;
			array_push($catchk_id,$_POST[category_id][$i]);
		}
		if($usedchk == 1){
			?>
				<script language="JavaScript">
					alert("ชื่อรูปภาพนี้มีอยู่แล้วในระบบ กรุณาตรวจสอบ หรือใช้ชื่อรูปภาพอื่น!!!!!!!!");
					window.location.href = 'gallery_view_category.php?category_id=<?php echo $_POST[category_id];?>';
				</script>
			<?php
			exit;
		}
		if($_POST[chkchange]=='yes'){
			$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery/";
			$Path_db = "images/gallery/";
		?><script language="javascript">//alert('<?php//=$Path_true?>');</script><?php
			if (!file_exists( "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery")) {
				mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery", 0777);
			}
			$gfile = "g".date("YmdHis")."_g";
			$tfile = "t".date("YmdHis")."_t";

			if($_FILES["filep"]['size'] > 0 ){
				if($_FILES['filep']['size'] > $size_max){
					?>
						<script language="JavaScript">
							alert("Can not upload \"<?php echo $_FILES["filep"]["name"][$i]; ?>\"!! File size over <?php echo $rec[site_info_max_img]; ?> KB.");
							window.close();
						</script>
					<?php
					exit;
				}
				$F = explode(".",$_FILES["filep"]["name"]);
				$C = count($F);
				$CT = $C-1;
				$dir = strtolower($F[$CT]);
				if($dir == "jpeg"){ $dir = "jpg"; }
				$picname = $gfile.".".$dir;
				//	echo $Path_true.$picname;
			?><script language="javascript">//alert('<?php//=$Path_true.$picname?>');</script><?php
				if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
					copy($_FILES["filep"]["tmp_name"],$Path_true.$picname);
					@chmod ($Path_true.$picname, 0777);
					$wi = "150";
					$hi = "150";
					$tpicname = $tfile.".".$dir;
					if($dir == "jpg"){
						thumb_jpg($Path_true.$picname,$Path_true.$tpicname, $wi, $hi);
					}
					if($dir == "gif"){
						thumb_gif($Path_true.$picname,$Path_true.$tpicname, $wi, $hi);
					}
					if($dir == "png"){
						thumb_png($Path_true.$picname,$Path_true.$tpicname, $wi, $hi);
					}
				}else if($dir == "swf" ){
						copy($_FILES["filep"]["tmp_name"],$Path_true.$picname);
						@chmod ($Path_true.$picname, 0777);
						$tpicname = $picname;
						$picname= $picname;
				}
			}
			/*print $_POST[category_name]; print "<br>";
			print $_POST[category_detail];print "<br>";
			print $_POST[s_images];print "<br>";
			print $_POST[b_images];print "<br>";*/
			//print count($_POST[category_id]);print "<br>";
			//if($_POST[add] == "add_all" ){
			$sql_update = "UPDATE gallery_image SET 
			img_name='".stripslashes(htmlspecialchars($_POST[category_name]))."' , 
			img_detail = '".stripslashes(htmlspecialchars($_POST[category_detail]))."' , 
			img_path_s = '".$Path_db.$tpicname."', 
			img_path_b = '".$Path_db.$picname."' , 
			img_update = NOW() 
			WHERE img_id = '".$_POST[img_id]."' ";
		}else{
			$now = date("Y-m-d");
			$sql_update = "UPDATE gallery_image SET 
			img_name='".stripslashes(htmlspecialchars($_POST[category_name]))."' , 
			img_detail = '".stripslashes(htmlspecialchars($_POST[category_detail]))."' , 
			img_path_s = '".$_POST[b_images]."' , 
			img_path_b = '".$_POST[b_images]."' , 
			img_update = NOW() 
			WHERE img_id = '".$_POST[img_id]."' ";
		}

		$db->query($sql_update);
		$rec=$db->db_fetch_array($db->query("select * from gallery_category where category_id = '".$_POST[category_id]."'"));
		$db->write_log("create","gallery","แก้ไขรูปภาพ   ".$_POST[category_name]."  ลงในหมวดหมู่ gallery   ".$rec[category_name]);

		 //multi search function
		if($search_center == "Y"){   
			$db->ms_module='G'; 
			$db->ms_link_id=$_POST[img_id];
			$db->multi_search_update();
		}
		/*$sql_del_cat_img = "DELETE FROM gallery_cat_img WHERE img_id = '".$_POST[img_id]."' ";
		$db->query($sql_del_cat_img);
		for($i=0;$i<count($_POST[category_id]);$i++){
		$sql_cat_img = "INSERT INTO gallery_cat_img (category_id,img_id) VALUES ('".$_POST[category_id][$i]."','".$_POST[img_id]."')";
		$db->query($sql_cat_img);
		}*/

		print "<script>";
		print "alert('แก้ไขข้อมูลแล้ว');";
		//echo "window.opener.location.reload();" ;
		//print "window.close();";
		print "location.href = 'gallery_view_category.php?category_id=".$_POST[category_id]." '; ";
		print "</script>";
	}

	if($_GET[flag] == 'del'){
		/*$sql_num_img = "SELECT count(*) as count_img FROM gallery_cat_img WHERE img_id = '".$_GET[img_id]."'";
		$query_num_img = $db->query($sql_num_img);
		$rs_num_img = $db->db_fetch_array($query_num_img);
		if($rs_num_img[count_img] == 1){*/
		$sql_del_img =  "DELETE FROM gallery_image WHERE img_id = '".$_GET[img_id]."' ";
		$db->query($sql_del_img);
		//}
		$sql_del_cat_img = "DELETE FROM gallery_cat_img WHERE category_id = '".$_GET[category_id]."' AND img_id = '".$_GET[img_id]."' ";
		$db->query($sql_del_cat_img);

		$sql_del_comment = "DELETE FROM gallery_comment WHERE category_id = '".$_GET[category_id]."' AND img_id = '".$_GET[img_id]."' ";
		$db->query($sql_del_comment);
		$rec=$db->db_fetch_array($db->query("select * from gallery_category where category_id = '".$_GET[category_id]."'"));
		$rec2=$db->db_fetch_array($db->query("select * from gallery_cat_img where img_id = '".$_GET[img_id]."'"));
		$db->write_log("delete","gallery","ลบรูปภาพ   ".$$rec2[category_name]."  ลงในหมวดหมู่ gallery   ".$rec[category_name]);

        //multi search function
		if($search_center == "Y"){   
			$db->ms_module='G'; 
			$db->ms_link_id=$_GET[img_id];
			$db->multi_search_delete();
		}

		print "<script>";
		print "alert('ลบข้อมูลแล้ว');";
		//echo "window.opener.location.reload();" ;
		print "location.href = 'gallery_view_category.php?category_id=".$_GET[category_id]." '; ";
		print "</script>";
	}
	
	if($_GET[flag] == 'add_splash'){
		$sql_insert  = "INSERT INTO splash_img (splash_img_id)  values('".$_GET[img_id]."')";
		$db->query($sql_insert);
	}
	
	if($_GET[flag] == 'del_splash') {
		$sql_delete =  "DELETE FROM splash_img WHERE splash_img_id = '".$_GET[img_id]."' ";
		$db->query($sql_delete);
		if($_GET[process] == '1') {
			print "<script>";
			print "alert('ลบข้อมูลแล้ว');";
			print "location.href = 'main_splash.php'; ";
			print "</script>";
		}
	}
	
	if($_POST[flag] == 'edit_splash'){
			$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/images/splash_gallery/";
			$Path_db = "images/splash_gallery/";
			if (!file_exists( "../ewt/".$_SESSION["EWT_SUSER"]."/images/splash_gallery")) {
				mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/images/splash_gallery", 0777);
			}
			
		for($i=0; $i<count($_POST['img_id']);$i++) {
		$gfile = "sh".$splash_img_id.date("YmdHis")."_g";
			$splash_img_id = $_POST['img_id'][$i];
			$splash_bgcolor = $_POST['splash_bgcolor'.$splash_img_id];
			$date = explode('/', $_POST['splash_start_date'.$splash_img_id]);
			$splash_start_date = ($date[2]-543)."-".$date[1]."-".$date[0];
			$date = explode('/', $_POST['splash_end_date'.$splash_img_id]);
			$splash_end_date = ($date[2]-543)."-".$date[1]."-".$date[0];
			$splash_text = $_POST['splash_text'.$splash_img_id];
			//====
			$splash_text_link = $_POST['splash_text_link'.$splash_img_id];
			$splash_bgcolor_link = $_POST['splash_bgcolor_link'.$splash_img_id];
			if($_POST['splash_status'.$splash_img_id] == 1) {
				$splash_status = 'Y';
			} else {
				$splash_status = 'N';
			}
			
			if($_FILES["file".$splash_img_id]['size'] > 0 ){
				if($_FILES['file'.$splash_img_id]['size'] > $size_max){
					?>
						<script language="JavaScript">
							alert("Can not upload \"<?php echo $_FILES["file".$splash_img_id]["name"][$i]; ?>\"!! File size over <?php echo $rec[site_info_max_img]; ?> KB.");
							window.close();
						</script>
					<?php
					exit;
				}
				$F = explode(".",$_FILES["file".$splash_img_id]["name"]);
				$C = count($F);
				$CT = $C-1;
				$dir = strtolower($F[$CT]);
				if($dir == "jpeg"){ $dir = "jpg"; }
				$picname = $gfile.".".$dir;
				$picname_new = $Path_db.$picname;
					copy($_FILES["file".$splash_img_id]["tmp_name"],$Path_true.$picname);
					@chmod ($Path_true.$picname, 0777);
			}else{
			$picname_new = $_POST["hdd_splash_bg_img".$splash_img_id];
			}
			
			
			
			
			$sql_update = "UPDATE splash_img SET 
			splash_start_date='".$splash_start_date."' , 
			splash_end_date = '".$splash_end_date."' , 
			splash_bgcolor = '".$splash_bgcolor."' , 
			splash_text = '".addslashes($splash_text)."' , 
			splash_status = '".$splash_status."',
			splash_text_link = '".$splash_text_link."' ,
			splash_text_color = '".$splash_bgcolor_link."',
			splash_bg_img = '".$picname_new."'  
			WHERE splash_img_id = '".$splash_img_id."' ";
			$db->query($sql_update);
		}
		print "<script>";
		print "alert('บันทึกข้อมูลแล้ว');";
		print "location.href = 'main_splash.php'; ";
		print "</script>";
	}
?>
<!--<html>
<head>
<title><?php//php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
</body>
</html>-->
<?php $db->db_close();  ?>
