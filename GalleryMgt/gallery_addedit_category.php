<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	
	function GenPic($data){
		for($i=0;$i<=$data;$i++){
			echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
		}
	}
	
	function showgroup($start,$i,$id,$idp,$dis){
			global $db;
			$x = $i+1;
			$sql_show = $db->query("SELECT * FROM gallery_category WHERE parent_id = '".$start."' ");
			if($db->db_num_rows($sql_show)){
							while($R = $db->db_fetch_array($sql_show)){
							   $cat_id=$R[category_id];
							   $cat_name=$R["category_name"];
								echo GenPic($i).'<input type="radio" name="c_parent" value="'.$cat_id.'" ';
								if($id == $cat_id){
									echo ' disabled ';
								}
								if($dis == "Y"){ 
									echo ' disabled '; 	
								}
								if($id == $cat_id OR $dis == "Y"){
									$dis1 = "Y";
								}else{
									$dis1 = "";
								}
								if($idp == $cat_id){
									echo ' checked ';
								}
								echo '><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> '.$cat_name."<br>";
								
								showgroup($cat_id,$x,$id,$idp,$dis1);
							}
			}
		}

	if($_POST[Flag] == "add") {
		$parent_cat_id_send = $_POST[parent_cat_id_send];
		if($parent_cat_id_send) {
		     $query = $db->query("SELECT category_id FROM gallery_category WHERE category_parent_id LIKE '".$parent_cat_id_send."' ");
			 $rs =  $db->db_fetch_array($query);
			 $parent_id=$rs[category_id];
			$query = $db->query("SELECT MAX(category_parent_id) AS parent_max FROM gallery_category WHERE category_parent_id LIKE '".$parent_cat_id_send."_%' ");
			$rs =  $db->db_fetch_array($query);
			$parent_cat_id_full = $rs[parent_max];
			$parent_send_chk = explode("_",$parent_cat_id_send);
			if($parent_cat_id_full) {
				$parent_cat_id_full_split = explode("_",$parent_cat_id_full);
				$get = count($parent_send_chk);
				$first = "";
				for($i=0; $i<$get; $i++) {
					if($i>0) $first.="_";
					$first.=$parent_cat_id_full_split[$i];
				}
				$parent_cat_id_max = $first."_".sprintf("%04d",$parent_cat_id_full_split[$get]+1);
			} else {
				$parent_cat_id_max = $parent_cat_id_send."_0001";
			}
			$parent_cat_id_max;
		} else {
			$query = $db->query("SELECT MAX(category_parent_id) AS parent_max FROM gallery_category");
			$rs =  $db->db_fetch_array($query);
			$parent_max_id = $rs[parent_max];
			$parent_max_id = explode("_",$parent_max_id);
			$parent_cat_id_max = sprintf("%04d",$parent_max_id[0]+1);
		}
		$sql = "SELECT category_name FROM gallery_category WHERE category_name LIKE '".$_POST[category_name]."'";
		$query = $db->query($sql);
		if($db->db_num_rows($query)>0) {
		?>
			<script language="JavaScript">
				alert("ชื่อหมวดนี้มีอยู่แล้วในระบบ กรุณาตรวจสอบ หรือใช้ชื่อหมวดอื่น!");
				window.location.href = 'main_gallery.php';
			</script>
		<?php
		}
		$insert="
			INSERT INTO  gallery_category(
				category_name, category_parent_id, col, 
				row, category_detail, height_s, 
				width_s, height_b, width_b, 
				category_vote, category_comment, category_send ,cat_timestamp,parent_id) 
			VALUES(
				'".$_POST[category_name]."', '$parent_cat_id_max', '".$_POST[col]."', 
				'".$_POST[row]."', '".$_POST[category_detail]."', '".$_POST["hi_s"]."', 
				'".$_POST["hi_s"]."', '".$_POST["hi_b"]."', '".$_POST["wi_b"]."', 
				'".$_POST["category_vote"]."', '".$_POST["category_comment"]."', '".$_POST["category_send"]."', NOW(),'$parent_id')";	
		$db->query($insert);
		$db->write_log("create","gallery","สร้างหมวดหมู่ gallery   ".$_POST[category_name]);
		echo "<script language=\"javascript\">";
		echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
		echo "window.location.href = 'main_gallery.php' ;" ;
		//echo "window.opener.location.reload();" ;
		//echo "window.close();" ;
		echo "</script>";
	}
	if($_POST[Flag] == "edit") {
		$update = "
			UPDATE gallery_category SET 
				category_name = '".$_POST[category_name]."', 
				category_detail = '".$_POST[category_detail]."', 
				col='".$_POST[col]."', 
				row='".$_POST[row]."' , 
				height_s = '".$_POST["hi_s"]."', 
				width_s ='".$_POST["wi_s"]."', 
				height_b = '".$_POST["hi_b"]."', 
				width_b = '".$_POST["wi_b"]."', 
				category_vote ='".$_POST["category_vote"]."', 
				category_comment = '".$_POST["category_comment"]."', 
				category_send = '".$_POST["category_send"]."', 
				cat_timestamp = NOW() ,
				parent_id = '".$_POST["c_parent"]."'
			WHERE category_id = '".$_POST["id"]."'  ";
		$db->query($update);
		$db->write_log("update","gallery","แก้ไขหมวดหมู่ gallery   ".$_POST[category_name]);
		if($_POST["hi_old"] != $_POST["hi_s"]){
		include("../ewt_thumbnail.php");
		$sql_t = $db->query("SELECT gallery_image.img_path_s,gallery_image.img_path_b FROM gallery_image INNER JOIN gallery_cat_img ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_cat_img.category_id = '".$_POST["id"]."' ");
			while($G = $db->db_fetch_row($sql_t)){
					$paths = "../ewt/".$_SESSION["EWT_SUSER"]."/".$G[0];
					$pathb = "../ewt/".$_SESSION["EWT_SUSER"]."/".$G[1];
							if(file_exists($pathb) AND trim($pathb) != "") {
							$size = getimagesize ($pathb);
							$type = $size['mime'];

												if($type == "image/jpeg"){
													thumb_jpg($pathb ,$paths,$_POST["hi_s"],$_POST["hi_s"]);
												}
												if($type == "image/gif"){
													thumb_gif($pathb ,$paths,$_POST["hi_s"],$_POST["hi_s"]);
												}
												if($type == "image/png"){
													thumb_png($pathb ,$paths,$_POST["hi_s"],$_POST["hi_s"]);
												}
							}
			}
		}
		echo "<script language=\"javascript\">";
		echo "alert('แก้ไขข้อมูลเรียบร้อยแล้ว');";
		echo "window.location.href = 'main_gallery.php' ;" ;
		echo "</script>";
	}

	if($_GET[flag] == "del") {
		/*$sql_num_img = "SELECT count(*) as count_img,img_id FROM gallery_cat_img WHERE category_id = '".$_GET[category_id]."' GROUP BY category_id";
		$query_num_img = $db->query($sql_num_img);
		$rs_num_img = $db->db_fetch_array($query_num_img);
		if($rs_num_img[count_img] == 1){
		$sql_del_img =  "DELETE FROM gallery_image WHERE img_id = '".$rs_num_img[img_id]."' ";
		$db->query($sql_del_img);
		}*/
		$sql_category = "SELECT * FROM gallery_category WHERE category_parent_id LIKE '".$_GET[parent_id]."%' ";
		$query_category = $db->query($sql_category);
		while($rs_category  = $db->db_fetch_array($query_category)){
			$sql_num_img = "SELECT * FROM gallery_cat_img WHERE category_id = '".$rs_category[category_id]."' ";
			$query_num_img = $db->query($sql_num_img);
			while($rs_num_img = $db->db_fetch_array($query_num_img)){
				$sql_num_img2 = "SELECT COUNT(*) AS count_img FROM gallery_cat_img WHERE img_id = '".$rs_num_img[img_id]."' GROUP BY img_id";
				$query_num_img2 = $db->query($sql_num_img2);
				$rs_num_img2 = $db->db_fetch_array($query_num_img2);
				if($rs_num_img2[count_img] == 1){
					$sql_del_img =  "DELETE FROM gallery_image WHERE img_id = '".$rs_num_img[img_id]."' ";
					$db->query($sql_del_img);
				}
			}
			$del = "DELETE FROM gallery_category WHERE category_id LIKE '".$rs_category[category_id]."'";
			$query = $db->query($del);
			$del2 = "DELETE FROM gallery_cat_img WHERE category_id LIKE '".$rs_category[category_id]."'";
			$query = $db->query($del2);
			$del3 = "DELETE FROM gallery_comment WHERE category_id LIKE '".$rs_category[category_id]."'";
			$query = $db->query($del3);
			$db->write_log("delete","gallery","ลบหมวดหมู่ gallery   ".$rs_category[category_name]);
		}
		/*$del = "delete from gallery_category where category_parent_id LIKE '".$_GET[parent_id]."%'";
		$query = $db->query($del);
		$del2 = "delete from gallery_cat_img where category_id LIKE '".$_GET[category_id]."'";
		$query = $db->query($del2);
		$del3 = "delete from gallery_comment where category_id LIKE '".$_GET[category_id]."'";
		$query = $db->query($del3);*/
		echo "<script language=\"javascript\">";
		echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
		echo "window.location.href = 'main_gallery.php' ;" ;
		echo "</script>";
	}
		if($_GET[id] != ''){
		$sql = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[id]."'";
		$query = $db->query($sql);
		$rs = $db->db_fetch_array($query);
		$category_id = $rs[category_id];
		$name = $rs[category_name];
		$detail = $rs[category_detail];
		$col = $rs[col];
		$row = $rs[row];
		$hi_s = $rs[height_s];
		$wi_s = $rs[width_s];
		$hi_b = $rs[height_b];
		$wi_b = $rs[width_b];
		$category_vote = $rs[category_vote];
		$category_comment = $rs[category_comment];
		$category_send = $rs[category_send];
		$total = $rs[col]*$rs[row];
		$parent_id = $rs[parent_id];
		$lable = "แก้ไขหมวดหมู่ห้องแสดงภาพ";
		$_GET[flag] = 'edit';
	}else{
		$total = 9;
		$hi_s =150;
		$wi_s = 150;
		$hi_b = 300;
		$wi_b = 300;
		$lable = "เพิ่มหมวดหมู่ห้องแสดงภาพ";
		$_GET[flag] ='add';
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
	<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr><td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle">&nbsp;<span class="ewtfunction"><?php echo $lable;?></span></td></tr>
	</table>
	<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
		<tr><td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($lable.":".$name);?>&module=gallery&url=<?php if($_GET[id]!=''){ echo urlencode("gallery_addedit_category.php?id=".$_GET[id]);}else{ echo urlencode('gallery_addedit_category.php?parent_cat_id_send='.$_GET[parent_cat_id_send]);}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp<a href="main_gallery.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">&nbsp;หน้าหลัก</a><hr></td></tr>
	</table>
	<table width="94%" height="62%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
		<form name="form1" method="post" action="gallery_addedit_category.php">
			<tr> 
				<td bgcolor="#FFFFFF" valign="top">
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999" class="ewttableuse">
						<tr class="ewttablehead"><td height="23" colspan="2"><?php echo $lable;?></td></tr>
						<tr>
							<td width="18%" height="23" bgcolor="#FFFFFF"><strong>ชื่อหมวดหมู่ : </strong><strong style="color:#FF0000">*</strong></td>
							<td width="82%" height="23" bgcolor="#FFFFFF"><input name="category_name" type="text" size="50" value="<?php echo $name?>"></td>
						</tr>
						<tr>
							<td height="23" bgcolor="#FFFFFF"><strong>รายละเอียด :</strong></td>
							<td height="23" bgcolor="#FFFFFF"><textarea name="category_detail" cols="50" rows="3"><?php echo $detail?></textarea></td>
						</tr>
						<?php 	if($_GET[flag] == "edit") {?>
						 <tr valign="top" bgcolor="#FFFFFF"> 
								  <td><strong>ตำแหน่งภายใต้</strong></td>
								  <td><DIV style="HEIGHT: 300;OVERFLOW-Y: scroll;WIDTH: 100%;">
									  <input type="radio" name="c_parent" value="0" <?php if($parent_id == "0"){ echo "checked"; } ?>>
									  <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">หมวดหลัก Gallery<br>
							         <?php   showgroup(0,0,$category_id,$parent_id,"");  ?></DIV>
								</td>
						</tr>
						<?php } ?>
						<tr>
							<td height="23" bgcolor="#FFFFFF"><strong>จำนวนคอลัมน์ *แถว: </strong></td>
							<td height="23" bgcolor="#FFFFFF">
								<input name="col" type="text" id="col" onBlur="if(this.value == '' ){this.value = '1';document.getElementById('total').innerHTML = document.form1.col.value*document.form1.row.value;} " onKeyUp="if(this.value == '0'){this.value = '1';} document.getElementById('total').innerHTML = document.form1.col.value*document.form1.row.value" value="<?php echo ($col)?$col:"3"?>" size="3" maxlength="4">
								</label>*
								<label ><input name="row" type="text" size="5" value="<?php echo ($row)?$row:"3"?>" onKeyUp="if(this.value == '0'){this.value = '1';} document.getElementById('total').innerHTML = document.form1.col.value*document.form1.row.value" onBlur="if(this.value == '' ){this.value = '1';document.getElementById('total').innerHTML = document.form1.col.value*document.form1.row.value;} ">&nbsp;&nbsp;แสดงผล <span id="total"><?php echo $total?></span> รูปต่อหน้า</label>
							</td>
						</tr>
						<tr>
							<td height="23" bgcolor="#FFFFFF"><strong>ความกว้างขนาดภาพเล็ก : </strong></td>
							<td height="23" bgcolor="#FFFFFF">
								<input name="hi_s" type="text" id="hi_s" value="<?php echo $hi_s; ?>" size="2" > pixels <input name="hi_old" type="hidden" id="hi_old" value="<?php echo $hi_s; ?>" >
								<span>Width:<input name="wi_s" type="text" id="wi_s" value="<?php echo $wi_s; ?>" size="2" ></span>
							</td>
						</tr>
						<tr>
							<td height="23" bgcolor="#FFFFFF"><strong>กำหนดขนาดภาพใหญ่ : </strong></td>
							<td height="23" bgcolor="#FFFFFF">
								Height:<input name="hi_b" type="text" id="hi_b" value="<?php echo $hi_b; ?>" size="2" >
								Width:<input name="wi_b" type="text" id="wi_b" value="<?php echo $wi_b; ?>" size="2" >
							</td>
						</tr>
						<tr>
							<td height="23" bgcolor="#FFFFFF">&nbsp;</td>
							<td height="23" bgcolor="#FFFFFF"><input type="checkbox" name="category_vote" value="1" <?php if($category_vote == 1) { echo "checked"; } ?>>&nbsp;อนุญาตให้มีการ Vote</td>
						</tr>
						<tr>
							<td height="23" bgcolor="#FFFFFF">&nbsp;</td>
							<td height="23" bgcolor="#FFFFFF"><input type="checkbox" name="category_send" value="1" <?php if($category_send == 1) { echo "checked"; } ?>>&nbsp;อนุญาตให้มีการส่งต่อให้เพื่อน</td>
						</tr>
						<tr>
							<td height="23" bgcolor="#FFFFFF">&nbsp;</td>
							<td height="23" bgcolor="#FFFFFF"><input type="checkbox" name="category_comment" value="1" <?php if($category_comment == 1) { echo "checked"; } ?>>&nbsp;อนุญาตให้มีการ Comment</td>
						</tr>
					</table>
					<table width="94%" border="0" align="center">
						<tr>
							<th scope="col">
								<input type="submit" name="Submit" value="<?php echo ($_GET[id] !='')?"แก้ไข":"บันทึก";?>" onClick="return chk_null(this.form);">
								<input type="hidden" name="Flag" value="<?php echo $_GET[flag]?>">
								<input type="hidden" name="id" value="<?php echo $_GET[id]?>">
								<input type="hidden" value="<?php echo $parent_cat_id_send?>" name="parent_cat_id_send" />&nbsp;
								<input type="button" name="Submit2" value="ยกเลิก" onClick="window.close();">
							</th>
						</tr>
					</table>
				</td>
			</tr>
		</form>
	</table>
</body>
</html>
<?php $db->db_close(); ?>
<script language="javascript">
function chk_null(me) {
	if(me.category_name.value == '') {
		alert('กรุณากรอกชื่อหมวดรูปภาพ');
		me.category_name.focus();
		return false;
	}
	if(me.col.value != '') {
		if(parseFloat(me.col.value) > 3) {
			 alert('จำนวนคอลัมน์ต้องไม่เกิน 3');
			 me.col.focus();
			return false;
		};
		
	}
	return true;
}
</script>
