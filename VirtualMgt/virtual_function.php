<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");



if($_POST["Flag"] =="Add"){

$v_name = stripslashes(htmlspecialchars($_POST["v_name"],ENT_QUOTES));
$v_detail = stripslashes(htmlspecialchars($_POST["v_detail"],ENT_QUOTES));

					if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/virtual")) {
						@mkdir("../ewt/".$_SESSION["EWT_SUSER"]."/virtual",0777);
					}
		$nfile = "vt".date("YmdHis");
		if($_FILES['v_file']['size'] > 0 ){
			$F = explode(".",$_FILES["v_file"]["name"]);
			$C = count($F);
			$CT = $C-1;
			$dir = strtolower($F[$CT]);
			if($dir == "jpeg"){
			$dir = "jpg";
			}
					$picname = $nfile.".".$dir;
					if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
						copy($_FILES["v_file"]["tmp_name"],"../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname);
						@chmod ("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname, 0777);
					}
							include("ewt_pthumb.php");
							$size = getimagesize ("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname);
							$type = $size['mime'];

												if($type == "image/jpeg"){
													thumb_jpg("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname, "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$picname,$size[0],$size[1]);
												}
												if($type == "image/gif"){
													thumb_gif("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname, "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$picname,$size[0],$size[1]);
												}
												if($type == "image/png"){
													thumb_png("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname, "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$picname,$size[0],$size[1]);
												}
			if($_POST["fit"] == "Y"){
				$start = 0;
			}else{
			$st = ($size[0] / 2) - ($_POST["maxwidth"] /2);
				if($st > 0){
					$start = number_format($st, 0, '', '');
				}else{
					$start = 0;
				}
			}
		}

$sql_insert = "INSERT INTO virtual_list (vg_id,v_name,v_detail,v_images,v_height,v_width,v_maxwidth,v_fit,v_speed,v_auto,v_360,v_start,v_fontcolor,v_bgcolor,v_status) VALUES ('".$_POST["cid"]."','".$v_name."','".$v_detail."','".$picname."','".$size[1]."','".$size[0]."','".$_POST["maxwidth"]."','".$_POST["fit"]."','".$_POST["speed"]."','".$_POST["autostart"]."','".$_POST["mode_360"]."','".$start."','".$_POST["fontcolor"]."','".$_POST["bgcolor"]."','".$_POST["mode_status"]."')";
$db->query($sql_insert);
$sql_max = $db->query("SELECT MAX(v_id) FROM virtual_list WHERE v_name = '".$v_name."' ");
$M = $db->db_fetch_row($sql_max);
$db->write_log("create","virtual","สร้าง virtual  ".$_POST["v_name"]);
 ?>
      <script language="JavaScript">
          self.location.href="virtual_manage.php?vid=<?php echo $M[0]; ?>";
     </script>
   <?php
}
if($_POST["Flag"] =="MSpot"){
$s_name = stripslashes(htmlspecialchars($_POST["s_name"],ENT_QUOTES));

if($_POST["ctype"] =='VIRTUAL'){
$_POST["s_link"] = $_POST["virtual_id"];
}
	if($_POST["sid"] == ""){
			$db->query("INSERT INTO virtual_spot (v_id,s_name,s_type,s_link,s_target,s_x1,s_x2,s_y1,s_y2) VALUES ('".$_POST["vid"]."','".$s_name."','".$_POST["ctype"]."','".$_POST["s_link"]."','".$_POST["s_target"]."','".$_POST["x1"]."','".$_POST["x2"]."','".$_POST["y1"]."','".$_POST["y2"]."')");
	}else{
			$db->query("UPDATE virtual_spot SET s_name = '".$s_name."',s_type = '".$_POST["ctype"]."',s_link = '".$_POST["s_link"]."',s_target = '".$_POST["s_target"]."',s_x1 = '".$_POST["x1"]."',s_x2 = '".$_POST["x2"]."',s_y1 = '".$_POST["y1"]."',s_y2 = '".$_POST["y2"]."' WHERE s_id = '".$_POST["sid"]."' ");
	}
?>
	<script language="JavaScript">
          window.opener.location.reload();
			window.close();
     </script>
<?php
}
	 if($_POST["Flag"] =="Sdel"){

$sql_insert = "DELETE FROM virtual_spot WHERE s_id = '".$_POST["SID"]."' ";
$db->query($sql_insert);

 ?>
      <script language="JavaScript">
          self.location.href="virtual_preview.php?vid=<?php echo $_POST["vid"]; ?>&&vg_id=<?php echo $_POST["vg_id"]; ?>";
     </script>
   <?php
}
	 if($_POST["Flag"] =="Edit"){

$v_name = stripslashes(htmlspecialchars($_POST["v_name"],ENT_QUOTES));
$v_detail = stripslashes(htmlspecialchars($_POST["v_detail"],ENT_QUOTES));

					if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/virtual")) {
						@mkdir("../ewt/".$_SESSION["EWT_SUSER"]."/virtual",0777);
					}
		
		if($_FILES['v_file']['size'] > 0 ){
			$nfile = "vt".date("YmdHis");
			$F = explode(".",$_FILES["v_file"]["name"]);
			$C = count($F);
			$CT = $C-1;
			$dir = strtolower($F[$CT]);
			if($dir == "jpeg"){
			$dir = "jpg";
			}
					$picname = $nfile.".".$dir;
					if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
						copy($_FILES["v_file"]["tmp_name"],"../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname);
						@chmod ("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname, 0777);
					}
							include("ewt_pthumb.php");
							$size = getimagesize ("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname);
							$type = $size['mime'];

												if($type == "image/jpeg"){
													thumb_jpg("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname, "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$picname,$size[0],$size[1]);
												}
												if($type == "image/gif"){
													thumb_gif("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname, "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$picname,$size[0],$size[1]);
												}
												if($type == "image/png"){
													thumb_png("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$picname, "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$picname,$size[0],$size[1]);
												}
			if($_POST["fit"] == "Y"){
				$start = 0;
			}else{
			$st = ($size[0] / 2) - ($_POST["maxwidth"] /2);
				if($st > 0){
					$start = number_format($st, 0, '', '');
				}else{
					$start = 0;
				}
			}
			@unlink("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$_POST["oldimg"]);
			@unlink("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$_POST["oldimg"]);
		$sql_update1 = "UPDATE virtual_list SET v_images = '".$picname."' ,v_height = '".$size[1]."',v_width = '".$size[0]."',v_start = '".$start."'  WHERE v_id = '".$_POST["vid"]."' ";
		$db->query($sql_update1);
		}

$sql_update = "UPDATE virtual_list SET vg_id = '".$_POST["cid"]."',v_name = '".$v_name."',v_detail = '".$v_detail."',v_maxwidth = '".$_POST["maxwidth"]."',v_fit = '".$_POST["fit"]."',v_speed = '".$_POST["speed"]."',v_auto = '".$_POST["autostart"]."',v_360 = '".$_POST["mode_360"]."',v_fontcolor = '".$_POST["fontcolor"]."',v_bgcolor = '".$_POST["bgcolor"]."' , v_status =  '".$_POST["mode_status"]."' WHERE v_id = '".$_POST["vid"]."' ";
$db->query($sql_update);

 ?>
      <script language="JavaScript">
          self.location.href="virtual_manage.php?vid=<?php echo $_POST["vid"]; ?>";
     </script>
   <?php
}
$db->db_close(); ?>
