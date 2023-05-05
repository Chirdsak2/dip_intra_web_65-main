<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$mailmaster = '<info@bizpotential.com>';

$global_height = "400";
$global_width = "500";

$sql_Imsize   = "select * from site_info";
$query_Imsize = $db->query($sql_Imsize);
$rec_Imsize   = $db->db_fetch_array($query_Imsize);

$max_img_size  = sizeMB2byte($rec_Imsize['site_info_max_img']);
$max_file_size = sizeMB2byte($rec_Imsize['site_info_max_file']);

if ($_POST["Flag"] == "article_pin") {
	$n_id = ready($_POST["n_id"]);
	$db->query("UPDATE article_list SET pinned = 'Y' WHERE n_id = '$n_id'");
}

if ($_POST["Flag"] == "article_unpin") {
	$n_id = ready($_POST["n_id"]);
	$db->query("UPDATE article_list SET pinned = '' WHERE n_id = '$n_id'");
}

if ($_POST["Flag"] == "UploadIcon" and $_FILES["icon"]['size'] > 0) {
	if ($_FILES['icon']['size'] < $max_img_size) {
		$Path_true = "../ewt/" . $_SESSION["EWT_SUSER"] . "/icon/";
		$F = explode(".", $_FILES["icon"]["name"]);
		$C = count($F);
		$CT = $C - 1;
		$dir = strtolower($F[$CT]);
		if ($dir == "jpeg") {
			$dir = "jpg";
		}
		$picname = 'icon' . date("YmdHis") . "." . $dir;

		if ($dir == "jpg" or $dir == "png" or $dir == "gif") {
			copy($_FILES["icon"]["tmp_name"], $Path_true . $picname);
			@chmod($Path_true . $picname, 0777);
			$Err_msg = 'เพิ่ม Icon ใหม่เรียบร้อย';
		} else {
			$Err_msg = 'ไฟล์ภาพต้องเป็นนามสกุล .jpeg .png	หรือ .gif เท่านั้น';
		}
	} else {
		$Err_msg = 'ไฟล์ ภาพต้องมีขนาดไม่เกิน  ' . ($max_img_size / 1024) . ' Kb.';
	}
?>
	<script>
		alert('<?php echo $Err_msg ?>');
		location.href = "article_iconmgt.php";
	</script>
<?php
}
if ($_POST["Flag"] == "Del_Icon") {
	for ($i = 0; $i < $_POST['all_count']; $i++) {
		$a = $_POST['chkdel' . $i];
		if ($a != '') {
			$Path_del = "../ewt/" . $_SESSION["EWT_SUSER"] . "/icon/" . $a;
			@unlink($Path_del);
		}
	}
	$Err_msg = 'ลบ Icon เรียบร้อย';
?>
	<script>
		alert('<?php echo $Err_msg; ?>');
		location.href = 'article_iconmgt.php'
	</script>
	<?php
}
if ($_POST["Flag"] == "CreateFolder") {
	$cid = $_POST['cid'];
	$c_parent = $_POST["c_parent"];
	$c_name = stripslashes(htmlspecialchars($_POST["gname"], ENT_QUOTES));
	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('file'));
	$rEFileTypes = "/^\.(" . ValidfileType('file') . "){1}$/i";

	$dir_base = "../ewt/" . $_SESSION['EWT_SUSER'] . "/images/org/";
	$dir_base1 = "images/org/";

	$isFile = is_uploaded_file($_FILES['image_org']['tmp_name']);

	if ($_POST["c_show_org1"] == 'เลือกข้อมูล') {
		$c_show_org1 = 0;
	} else if (empty($_POST["c_show_org1"])) {
		$c_show_org1 = 0;
	} else {
		$c_show_org1 = $_POST["c_show_org1"];
	}

	if ($_POST["c_show_org2"] == 'เลือกข้อมูล') {
		$c_show_org2 = 0;
	} else if (empty($_POST["c_show_org2"])) {
		$c_show_org2 = 0;
	} else {
		$c_show_org2 = $_POST["c_show_org2"];
	}

	if ($_POST["c_show_org3"] == 'เลือกข้อมูล') {
		$c_show_org3 = 0;
	} else if (empty($_POST["c_show_org3"])) {
		$c_show_org3 = 0;
	} else {
		$c_show_org3 = $_POST["c_show_org3"];
	}

	if ($_POST["select_template"] == 'เลือกข้อมูล') {
		$select_template = 0;
	} else if (empty($_POST["select_template"])) {
		$select_template = 0;
	} else {
		$select_template = $_POST["select_template"];
	}

	if ($_POST["menu_org"] == 'เลือกข้อมูล') {
		$menu_org = 0;
	} else if (empty($_POST["menu_org"])) {
		$menu_org = 0;
	} else {
		$menu_org = $_POST["menu_org"];
	}

	if ($_POST["banner_org"] == 'เลือกข้อมูล') {
		$banner_org = 0;
	} else if (empty($_POST["banner_org"])) {
		$banner_org = 0;
	} else {
		$banner_org = $_POST["banner_org"];
	}

	$array_list = array(
		"c_name" => $c_name,
		"c_parent" => $_POST["c_parent"],
		"c_show_document" => 'Y',
		"c_show_search" => 'Y',
		"c_show_sub" => $_POST["gshowsub"],
		"c_show_pic" => $_POST["gshowpic"],
		"c_show_date" => $_POST["gshowdate"],
		"c_show_detail" => !empty($_POST["gshowdetail"]) ? $_POST["gshowdetail"] : null,
		"c_show_subnew" => $_POST['gshowsubnew'],
		"c_show_org_chk" => $_POST["c_show_org_chk"],
		"c_show_org_menu" => $menu_org,
		"c_show_org_banner" => $banner_org,
		"c_show_org1" => $c_show_org1,
		"c_show_org2" => $c_show_org2,
		"c_show_org3" => $c_show_org3,
		"c_type" => $_POST['gtype'],
		"d_id" => $select_template,
		"d_id_w3c" => 1
	);

	if ($isFile) {
		$safe_filename = preg_replace(
			array("/\s+/", "/[^-\.\w]+/"),
			array("_", ""),
			trim($_FILES['image_org']['name'])
		);

		$type_file =  strrchr($safe_filename, '.');
		$newfile   = "org_attach_" . date("YmdHis") . $type_file;
		if (preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
			$isMove = move_uploaded_file($_FILES['image_org']['tmp_name'], $dir_base . $newfile);
			$a_attach = $dir_base1 . $newfile;
			$array = array_merge($array_list, ["c_show_org_image" => $a_attach]);
		}
	} else {
		$array = $array_list;
	}

	if (insert('article_group', $array)) {
		//กำหนดสิทธ์หมวดย่อย
		$p_sql = "SELECT * FROM ".$EWT_DB_USER.".permission WHERE s_type = 'Ag' AND s_id = '$cid' AND pu_id != 0 AND s_permission = 'w' AND s_type != 'suser' ";
		$p_query = $db->query($p_sql);

		//เช็คข้อมูลผู้ใช้ในหมวดหลัก
		if ($p_query) {
			while ($result = $db->db_fetch_array($p_query)) {
				$s_id = $result['s_id'];
				$pu_id = $result["pu_id"];

				$gp_sql = "SELECT c_id FROM ".$EWT_DB_NAME.".article_group WHERE c_parent = '$s_id' ORDER BY c_id DESC LIMIT 1";
				$gp_query = $db->query($gp_sql);
				$gp_result = $db->db_fetch_array($gp_query);

				//เช็คสิทธิ์หมวดย่อย
				if (!empty($gp_result)) {
					//เพิ่มข้อมูลสิทธิ์หมวดย่อย
					$p_data1 = array();
					$p_data1['p_type']  	 = 'U';
					$p_data1['pu_id']  		 = $pu_id;
					$p_data1['UID']  		 = 1;
					$p_data1['s_type']  	 = 'Ag';
					$p_data1['s_id']  		 = $gp_result["c_id"];
					$p_data1['s_permission'] = 'w';
					insert(''.$EWT_DB_USER.'.permission', $p_data1);

					$p_data2 = array();
					$p_data2['p_type']  	 = 'U';
					$p_data2['pu_id']  		 = $pu_id;
					$p_data2['UID']  		 = 1;
					$p_data2['s_type']  	 = 'Ag';
					$p_data2['s_id']  		 = $gp_result["c_id"];
					$p_data2['s_permission'] = 'a';
					$insert1 = insert(''.$EWT_DB_USER.'.permission', $p_data2);
				}
			}
		}
	}

	//add order
	$sql_u = "select * from article_group WHERE c_parent = '" . $_POST["p"] . "'";
	$query1 = $db->query($sql_u);
	$j = 0;
	while ($rec1 = $db->db_fetch_array($query1)) {
		$j++;
		if ($rec1['d_id_w3c'] == '1' || $j > 0) {
			$db->query("update article_group set d_id = " . ($j) . ",d_id_w3c = 0 WHERE c_id = '" . $rec1['c_id'] . "'");
		} else {
			$db->query("update article_group set d_id = (d_id+1) WHERE c_id = '" . $rec1['c_id'] . "'");
		}
	}

	//add permission
	$sql_max = "select max(c_id) as cid from article_group";
	$query = $db->query($sql_max);
	$rec = $db->db_fetch_array($query);
	$uid = !empty($_POST["hdd_uid"]) ? explode(",", $_POST["hdd_uid"]) : array();
	$uorgid = !empty($_POST["hdd_uorg"]) ? explode(",", $_POST["hdd_uorg"]) : array();
	$ugroupid = !empty($_POST["hdd_ugroup"]) ? explode(",", $_POST["hdd_ugroup"]) : array();
	$ugroup_personalid = !empty($_POST["hdd_ugroup_personal"]) ? explode(",", $_POST["hdd_ugroup_personal"]) : array();
	//user
	if (count($uid) > 0 && !empty($_POST["hdd_uid"])) {
		for ($i = 0; $i < count($uid); $i++) {
			$db->query("insert into article_group_permission (c_id,gen_user_id) values (" . $rec['cid'] . "," . $uid[$i] . ")");
		}
	}
	//org
	if (count($uorgid) > 0 && !empty($_POST["hdd_uorg"])) {
		for ($i = 0; $i < count($uorgid); $i++) {
			$db->query("insert into article_group_permission (c_id,org_id) values (" . $rec['cid'] . "," . $uorgid[$i] . ")");
		}
	}
	//gruop
	if (count($ugroupid) > 0 && !empty($_POST["hdd_ugroup"])) {
		for ($i = 0; $i < count($ugroupid); $i++) {
			$db->query("insert into article_group_permission (c_id,ug_id) values (" . $rec['cid'] . "," . $ugroupid[$i] . ")");
		}
	}
	//type
	if (count($ugroup_personalid) > 0 && !empty($_POST["hdd_ugroup_personal"])) {
		for ($i = 0; $i < count($ugroup_personalid); $i++) {
			$db->query("insert into article_group_permission (c_id,emp_type_id) values (" . $rec['cid'] . "," . $ugroup_personalid[$i] . ")");
		}
	}

	$db->write_log("create", "article", "สร้าง folder กลุ่ม article   " . $c_name);

	if ($_POST['gtype'] == 'M') {
	?>
		<script>
			self.location.href = 'article_gselect.php?cid=<?php echo $rec['cid']; ?>'
		</script>
		<?php
	} else {
		if ($_POST['c_parent']) {
		?>
			<script>
				self.location.href = 'article_group.php?cid=<?php echo $_POST['c_parent']; ?>'
			</script>
			<?php
		} else {
			if ($_POST["p"] == "") {
			?>
				<script>
					self.location.href = 'article_group.php#bottom'
				</script>
			<?php
			} else {
			?>
				<script>
					self.location.href = 'article_list.php?cid=<?php echo $_POST['p']; ?>'
				</script>
		<?php
			}
		}
	}
}

if ($_POST["Flag"] == "EditGroup") {
	if (trim($_POST["c_name"]) == "") {
		?>
		<script>
			self.location.href = 'article_gedit.php?cid=<?php echo $_POST["cid"]; ?>'
		</script>
	<?php
	}

	$c_name = stripslashes(htmlspecialchars($_POST["c_name"], ENT_QUOTES));
	$R_name_old = $db->db_fetch_array($db->query("SELECT c_name FROM article_group WHERE  c_id = '" . $_POST["cid"] . "' "));
	$db->write_log("update", "article", " folder  article    " . $R_name_old['c_name'] . "   " . $c_name);

	//อัพโหลดรูปภาพ Org
	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('file'));
	$rEFileTypes = "/^\.(" . ValidfileType('file') . "){1}$/i";

	$dir_base = "../ewt/" . $_SESSION['EWT_SUSER'] . "/images/org/";
	$dir_base1 = "images/org/";

	$isFile = is_uploaded_file($_FILES['image_org']['tmp_name']);

	$array_list = array(
		"c_name" => $c_name,
		"c_parent" => $_POST["c_parent"],
		"c_show_search" => "Y",
		"c_show_sub" => $_POST["gshowsub"],
		"c_show_pic" => $_POST["gshowpic"],
		"c_show_date" => $_POST["gshowdate"],
		"c_show_detail" => !empty($_POST["gshowdetail"]) ? $_POST["gshowdetail"] : null,
		"c_show_subnew" => $_POST["gshowsubnew"],
		"c_show_org_chk" => $_POST["c_show_org_chk"],
		"c_show_org_menu" => !empty($_POST["menu_org"]) ? $_POST["menu_org"] : 0,
		"c_show_org_banner" => !empty($_POST["banner_org"]) ? $_POST["banner_org"] : 0,
		"c_show_org1" => !empty($_POST["org_group1"]) ? $_POST["org_group1"] : 0,
		"c_show_org2" => !empty($_POST["org_group2"]) ? $_POST["org_group2"] : 0,
		"c_show_org3" => !empty($_POST["org_group3"]) ? $_POST["org_group3"] : 0,
		"c_type" => $_POST["gtype"],
		"d_id" => !empty($_POST["c_order"]) ? $_POST["c_order"] : 0,
		"d_id_w3c" => !empty($_POST["select_template_w3c"]) ? $_POST["select_template_w3c"] : 0
	);

	$array_where = array(
		"c_id" => $_POST["cid"]
	);

	if ($isFile) {
		$safe_filename = preg_replace(
			array("/\s+/", "/[^-\.\w]+/"),
			array("_", ""),
			trim($_FILES['image_org']['name'])
		);

		$type_file =  strrchr($safe_filename, '.');
		$newfile   = "org_attach_" . date("YmdHis") . $type_file;
		if (preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
			$isMove = move_uploaded_file($_FILES['image_org']['tmp_name'], $dir_base . $newfile);
			$a_attach = $dir_base1 . $newfile;
			$array = array_merge($array_list, ["c_show_org_image" => $a_attach]);
		}
	} else {
		$array = $array_list;
	}

	update("article_group", $array, $array_where);

	//edit permission
	$db->query("delete from article_group_permission where c_id = '" . $_POST["cid"] . "' ");
	$uid = !empty($_POST["hdd_uid"]) ? explode(",", $_POST["hdd_uid"]) : array();
	$uorgid = !empty($_POST["hdd_uorg"]) ? explode(",", $_POST["hdd_uorg"]) : array();
	$ugroupid = !empty($_POST["hdd_ugroup"]) ? explode(",", $_POST["hdd_ugroup"]) : array();
	$ugroup_personalid = !empty($_POST["hdd_ugroup_personal"]) ? explode(",", $_POST["hdd_ugroup_personal"]) : array();
	//user
	if (count($uid) > 0 && !empty($_POST["hdd_uid"])) {
		for ($i = 0; $i < count($uid); $i++) {
			$db->query("insert into article_group_permission (c_id,gen_user_id) values (" . $_POST["cid"] . "," . $uid[$i] . ")");
		}
	}
	//org
	if (count($uorgid) > 0 && !empty($_POST["hdd_uorg"])) {
		for ($i = 0; $i < count($uorgid); $i++) {
			$db->query("insert into article_group_permission (c_id,org_id) values (" . $_POST["cid"] . "," . $uorgid[$i] . ")");
		}
	}
	//gruop
	if (count($ugroupid) > 0 && !empty($_POST["hdd_ugroup"])) {
		for ($i = 0; $i < count($ugroupid); $i++) {
			$db->query("insert into article_group_permission (c_id,ug_id) values (" . $_POST["cid"] . "," . $ugroupid[$i] . ")");
		}
	}
	//type
	if (count($ugroup_personalid) > 0 && !empty($_POST["hdd_ugroup_personal"])) {
		for ($i = 0; $i < count($ugroup_personalid); $i++) {
			$db->query("insert into article_group_permission (c_id,emp_type_id) values ('" . $_POST["cid"] . "','" . $ugroup_personalid[$i] . "')");
		}
	}
	$sqlc = $db->query("SELECT c_parent FROM article_group WHERE c_id = '" . $_POST["cid"] . "' ");
	$R = $db->db_fetch_row($sqlc);
	if ($R[0] == "" or $R[0] == "0") {
	?>
		<script>
			self.location.href = 'article_group.php';
		</script>
	<?php
	} else {
	?>
		<script>
			self.location.href = 'article_gedit.php?cid=<?php echo $_POST["cid"]; ?>';
		</script>
		<?php
	}
}

if ($_POST["Flag"] == "AddArticle") {
	$topic = stripslashes(htmlspecialchars($_POST["topic"], ENT_QUOTES));
	$description = stripslashes(htmlspecialchars($_POST["description"], ENT_QUOTES));
	$picture = stripslashes(htmlspecialchars($_POST["picture"], ENT_QUOTES));
	if ($_POST["browsefile"] == '1') {
		$link = addslashes($_POST["link"]);
	} else {
		$Current_Dir2 = "../ewt/" . $_SESSION["EWT_SUSER"] . "/download/article";
		$Current_Dir3 = "download/article";
		@mkdir($Current_Dir2, 0777);
		if ($_FILES["filebrowse"]['size'] > 0) {
			$F = explode(".", $_FILES["filebrowse"]["name"]);
			$C = count($F);
			$CT = $C - 1;
			$dir = strtolower($F[$CT]);

			$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
			$query_type_file = $db->query($sql_type_file);
			$R_type_file = $db->db_fetch_array($query_type_file);
			$type_file = $R_type_file['site_type_file'];
			$pos = strpos($type_file, $dir);
			if ($pos === FALSE) {
		?>
				<script>
					alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด <?php echo $type_file; ?> ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
					self.location.href = 'article_new.php?cid=<?php echo $_POST["cid"]; ?>';
				</script>
			<?php
			} else {
				$nfile = "article_" . date("YmdHis");
				$picname = $nfile . "." . $dir;
				copy($_FILES["filebrowse"]["tmp_name"], $Current_Dir2 . "/" . $picname);
				@chmod($Current_Dir2 . "/" . $picname, 0777);
				$link = $Current_Dir3 . "/" . $picname;
			}
		}
	}
	$source = stripslashes(htmlspecialchars($_POST["source"], ENT_QUOTES));
	$source_url = stripslashes(htmlspecialchars($_POST["source_url"], ENT_QUOTES));
	$keyword = stripslashes(htmlspecialchars($_POST["keyword"], ENT_QUOTES));
	$time_n = stripslashes(htmlspecialchars($_POST["time_n"], ENT_QUOTES));

	$date = explode("/", $_POST["date_n"]);
	$date_n = $date[2] . "-" . $date[1] . "-" . $date[0];

	$date1 = explode("/", $_POST["date_e"]);
	$date_e = $date1[2] . "-" . $date1[1] . "-" . $date1[0];

	if ($_POST["date_start"] != '' && $_POST["date_end"] != '') {
		if ($_POST["time_H_start"] == '') {
			$_POST["time_H_start"] = '00';
		}
		if ($_POST["time_s_start"] == '') {
			$_POST["time_s_start"] = '00';
		}
		if ($_POST["time_H_end"] == '') {
			$_POST["time_H_end"] = '00';
		}
		if ($_POST["time_s_end"] == '') {
			$_POST["time_s_end"] = '00';
		}
		$time_st = $_POST["time_H_start"] . ':' . $_POST["time_s_start"] . ':00';
		$time_ed = $_POST["time_H_end"] . ':' . $_POST["time_s_end"] . ':00';
		$date_st = explode("/", $_POST["date_start"]);
		$date_start = $date_st[2] . "-" . $date_st[1] . "-" . $date_st[0] . ' ' . $time_st;
		$date_ed = explode("/", $_POST["date_end"]);
		$date_end = $date_ed[2] . "-" . $date_ed[1] . "-" . $date_ed[0] . ' ' . $time_ed;
	} else {
		$date_start = '';
		$date_end = '';
	}

	if ($_SESSION["EWT_SMID"] != "") {
		$org = $db->query("SELECT org_name.name_org, org_name.org_id FROM ".$EWT_DB_USER.".gen_user  INNER JOIN ".$EWT_DB_USER.".org_name ON (gen_user.org_id = org_name.org_id) WHERE gen_user_id = '" . $_SESSION["EWT_SMID"] . "'");
		$O = $db->db_fetch_row($org);
		$org_own = $O[0];
		$org_id = $O[1];
		$db->query("USE " . $_SESSION["EWT_SDB"]);
	}
	if ($_POST["apl"] == "AP") {
		$appove_a = "Y";
		$dapp = date("Y-m-d H:i");
	}
	if ($_POST["detail_use"] == "1") {
		$chk_count = $_POST["chk_show_count_level1"];
	} else if ($_POST["detail_use"] == "4") {
		$chk_count = $_POST["chk_show_count"];
	}
	$address .= "";

	for ($i = 0; $i < $_POST['temp_num3']; $i++) {

		if ($_POST["address1"][$i] != '' or $_POST["address2"][$i]) {
			$address .= $_POST["address1"][$i] . "#@#" . $_POST["address2"][$i] . "###";
		}
	}

	##=========================================================================================##
	$array_list = array(
		"c_id" => $_POST['cid'],
		"n_date" => $date_n,
		"n_time" => $time_n,
		"n_timestamp" => date("Y-m-d H:i:s"),
		"n_topic" => $topic,
		"n_des" => $description,
		"source" => $source,
		"sourceLink" => $source_url,
		"keyword" => $keyword,
		"picture" => $picture,
		"news_use" => $_POST['detail_use'],
		"at_id" => $_POST['at_id'],
		"link_html" => $link,
		"target" => $_POST['target'],
		"expire" => $date_e,
		"logo" => $_POST['icon'],
		"n_new_modi" => date('YmdHis'),
		"n_last_modi" => date('YmdHis'),
		"n_owner" => $_SESSION['EWT_SMID'],
		"n_date_start" => $date_start,
		"n_date_end" => $date_end,
		"n_owner_org" => $org_own,
		"n_org" => $org_id,
		"n_approve" => $appove_a,
		"n_approvedate" => $dapp,
		"show_count" => $chk_count,
		"n_address" => $address
	);

	insert("article_list", $array_list);
	$db->write_log("create", "article", "สร้าง article " . $topic);

	##=========================================================================================##
	// $sql_km = "SELECT id,km_category FROM km_point WHERE id = 6";
	// $a_km = $db->db_fetch_array($sql_km);

	// $km_array = array();
	// $array_km = array();

	// $c_pid = $_POST['cid'];
	// $cat_id = $a_km['km_category'];

	// $chk_array = explode(",", getArticleSub($cat_id));

	// if (in_array($c_pid, $chk_array)) {
	// 	$sql_sso = "SELECT USR_FNAME, USR_LNAME FROM USR_MAIN WHERE USR_USERNAME = '" . $_SESSION["EWT_SMID"] . "' ";
	// 	$result_sso = $sso->getFetch($sql_sso);
	// 	$array_km["km_id"] = 6;
	// 	$array_km["module_id"] = $c_pid;
	// 	$array_km["module_name"] = "KM";
	// 	$array_km["username"] = $_SESSION["EWT_SMUSER"];
	// 	$array_km["name"] = $result_sso["USR_FNAME"];
	// 	$array_km["lastname"] = $result_sso["USR_LNAME"];
	// 	$array_km["gen_user_id"] = $_SESSION["EWT_SMID"];
	// 	$array_km["km_date"] = date("Y-m-d");
	// 	$array_km["create_date"] = date("Y-m-d H:i:s");
	// 	insert("km_user", $array_km);
	// }
	##=========================================================================================##

	// rss  Thailand //
	Gen_RSS($_POST["cid"]);

	$sql_max = $db->query("SELECT MAX(n_id) FROM ".$EWT_DB_NAME.".article_list WHERE c_id = '" . $_POST["cid"] . "' AND n_topic = '$topic' ");
	$M = $db->db_fetch_row($sql_max);
	$nid = $M[0];

	##=========================================================================================##
	## >> Article tag
	$article_tag = trim($_POST["article_tag"]);

	if ($article_tag != "") {
		$article_tag = explode(",", $article_tag);
		$unique_tag  = array();

		foreach ($article_tag as $tag_e) {
			if (!in_array($tag_e, $unique_tag)) {
				array_push($unique_tag, ready($tag_e));
			}
		}

		foreach ($unique_tag as $tag_e) {
			## >> Insert
			$db->query("INSERT INTO article_taglist (n_id,lang_id,tag_name) VALUES ('$nid','1','$tag_e')");

			## >> Count and update
			$check_tag  = strtolower($tag_e);
			$check_list = $db->query("SELECT tag_id FROM article_tagcount WHERE tag_name = '$check_tag' COLLATE utf8_bin AND lang_id = '1'");

			if ($db->db_num_rows($check_list) == 0) {
				$db->query("INSERT INTO article_tagcount (tag_name,lang_id,tag_count) VALUES ('$check_tag','1','1')");
			} else {
				$list_info = $db->db_fetch_array($check_list);
				$tag_id    = $list_info["tag_id"];
				$count = $db->query("SELECT COUNT(taglist_id) AS total FROM article_taglist WHERE tag_name = '$tag_e' COLLATE utf8_bin AND lang_id = '1'");
				$count = $db->db_fetch_array($count);
				$total = $count["total"];
				$db->query("UPDATE article_tagcount SET tag_count = '$total' WHERE tag_id = '$tag_id' AND lang_id = '1'");
			}
		}
	}
	##=========================================================================================##

	$Current_DirVdo = "../ewt/" . $_SESSION["EWT_SUSER"] . "/download/file_vdo";
	if ($_POST['showvdo'] == '1') {
		for ($i = 0; $i < $_POST['temp_num']; $i++) {
			if ($_FILES['filevdo']['tmp_name'][$i] != "") {

				$MAXIMUM_FILESIZE = 10 * 1024 * 1024;
				$rEFileTypes =
					"/^\.(mp4){1}$/i";
				$dir_base = "files/";

				$isFile = is_uploaded_file($_FILES['filevdo']['tmp_name'][$i]);
				if ($isFile) {
					$safe_filename = preg_replace(
						array("/\s+/", "/[^-\.\w]+/"),
						array("_", ""),
						trim($_FILES['filevdo']['name'][$i])
					);

					$type_file =  strrchr($safe_filename, '.');

					$newfile = "article_vdo_" . date("YmdHis") . "_" . $i . $type_file;

					if ($_FILES['filevdo']['size'][$i] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {

						$isMove = move_uploaded_file($_FILES['filevdo']['tmp_name'][$i], $Current_DirVdo . $newfile);
					}
					$pate = $newfile;
				} else {
					$pate = "";
				}

				$array_list = array(
					"n_id" => $nid,
					"av_filename" => $pate,
					"av_filenameyoutube" => null,
					"av_type" => "V",
					"av_createdate" => date("Y-m-d"),
				);

				insert("article_video", $array_list);
			}
		}
	}

	if ($_POST['showvdo'] == '2') {
		for ($i = 0; $i < $_POST['temp_num2']; $i++) {
			if ($_POST['vdo_youtube'][$i] != "") {
				$array_list = array(
					"n_id" => $nid,
					"av_filename" => null,
					"av_filenameyoutube" => $_POST['vdo_youtube'][$i],
					"av_type" => "T",
					"av_createdate" => date("Y-m-d"),
				);
				insert("article_video", $array_list);
			}
		}
	}

	if ($appove_a == "Y" && $_POST['approve_user'] == '') {
		$txt = '';
		$sql_ewt = $db->db_fetch_array($db->query("select * from ".$EWT_DB_USER.".user_info where UID='" . $_SESSION["EWT_SUID"] . "'"));
		$text_name = $topic;
		$text_dec = $description;
		if ($_POST["detail_use"] == "2") {
			$text_link = "<a href=\"" . $sql_ewt['url'] . "news_view.php?nid=" . $nid . "\" target=\"_blank\">";
		} else {
			$rest = substr($link, 0, 4);
			if ($rest == 'http') {
				$text_link .= "<a href=\"" . $link . "\" target=\"_blank\">";
			} else {
				$text_link .= "<a href=\"" . $sql_ewt['url'] . "/" . $link . "\" target=\"_blank\">";
			}
		}
		$txt .= "- " . $text_link . $text_name . "</a><br>";
		$txt .= $text_dec;
		$txt .= '<br>';
		$body = "ถึงท่านสมาชิกทุกท่าน  มีข่าวสารใหม่ขอแจ้งให้ทราบดังนี้";
		$G = $db->db_fetch_array($db->query("select * from ".$EWT_DB_NAME.".article_group WHERE c_id = '" . $_POST["cid"] . "' "));
		$subject = "<b>เรื่อง : " . $G['c_name'] . "</b>";
		//File user login
		$sql_info = $db->db_fetch_array($db->query("select * from ".$EWT_DB_USER.".gen_user where gen_user_id='" . $_SESSION["EWT_SMID"] . "'"));
		$name = $sql_info['name_thai'] . '' . $sql_info['surname_thai'];
		$db->query("INSERT INTO ".$EWT_DB_NAME.".n_history (h_subject,h_from_n,h_from_e,h_body,h_attach,h_date,h_time,h_user) VALUES ('" . addslashes($subject) . "','" . addslashes($name) . "','" . addslashes($sql_info['email_kh']) . "','" . addslashes($body) . "','',NOW( ),NOW( ),'0')");

		## >> Get h_id
		$hid_data = $db->query("SELECT MAX(h_id) AS h_id FROM ".$EWT_DB_NAME.".n_history");
		$hid_info = $db->db_fetch_array($hid_data);
		$hid      = $hid_info["h_id"];

		$sql_group_enew = $db->query("select * from ".$EWT_DB_NAME.".n_group inner join ".$EWT_DB_NAME.".n_group_member on n_group.g_id=n_group_member.g_id inner join ".$EWT_DB_NAME.".n_member on  n_group_member.m_id=n_member.m_id where g_name= '" . $_POST["cid"] . "' and m_active ='Y'");

		$nnn = $db->db_num_rows($sql_group_enew);
		echo  "num>>" . $nnn;
		//exit;
		$email_member = array();
		while ($R_M = $db->db_fetch_array($sql_group_enew)) {
			array_push($email_member, $R_M['m_email']);
			$db->query("INSERT INTO ".$EWT_DB_NAME.".n_send (h_id,s_date,s_time,s_email) VALUES ('$hid',NOW( ),NOW( ),'$R_M[m_email]')");
		}

		$strTo2 = implode(",", $email_member);
		for ($i = 0; $i < count($email_member); $i++) {
			$to = $email_member[$i];
			if (!empty($to)) {
				$message = '';
				$subject = "=?UTF-8?B?" . base64_encode("แจ้งการอัพเดทข่าสาร") . "?=";
				$message .= '<html>';
				$message .= '<head>';
				$message .= '<title>' . $subject . '</title>';
				$message .= '</head>';
				$message .= '<body>';
				$message .= '<table bgcolor = "#FFFFFF" border = "0" width = "100%">';
				$message .= '<tr>';
				$message .= '<td  width="100%">' . $subject . '</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td  width="100%">' . $body . '</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td width="100%" >' . $txt . '</td>';
				$message .= '</tr>';
				$message .= '</table><br><br>';
				$message .= '</body>';
				$message .= '</html>';

				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8\r\n";
				$headers .= "To: " . $to . " \r\n";
				$headers .= "From: RTRC Webmaster" . $mailmaster . "  \r\n";

				$flgSends = @mail($to, $subject, $message, $headers);
			}
		}

		//end send mail
	}
	//send mail
	if ($_POST['approve_user'] == 'Y') {
		$db->query("UPDATE ".$EWT_DB_NAME.".article_list SET n_approve = 'Y' , n_approvedate = '" . date("Y-m-d H:i") . "' WHERE n_id = '$nid'");
		//send mail
		$sql_ewt = $db->db_fetch_array($db->query("select * from ".$EWT_DB_USER.".user_info where UID='" . $_SESSION["EWT_SUID"] . "'"));
		$text_name = $topic;
		$text_dec = $description;
		if ($_POST["detail_use"] == "2") {
			$text_link = "<a href=\"" . $sql_ewt['url'] . "/news_view.php?n_id=" . $nid . "\" target=\"_blank\">";
		} else {
			$rest = substr($link, 0, 4);
			if ($rest == 'http') {
				$text_link .= "<a href=\"" . $link . "\" target=\"_blank\">";
			} else {
				$text_link .= "<a href=\"" . $sql_ewt['url'] . "/" . $link . "\" target=\"_blank\">";
			}
		}
		$txt .= "- " . $text_link . $text_name . "</a><br>";
		$txt .= $text_dec;
		$txt .= '<br>';
		//$body = "<font face='MS Sans Serif' size=2>ถึงท่านสมาชิกทุกท่าน  มีข่าวสารใหม่ขอแจ้งให้ทราบดังนี้<br>".$txt."</font>";
		$body = "<font face='MS Sans Serif' size=2>ถึงท่านสมาชิกทุกท่าน  มีข่าวสารใหม่ขอแจ้งให้ทราบดังนี้<br></font>";
		$G = $db->db_fetch_array($db->query("select * from ".$EWT_DB_NAME.".article_group  WHERE c_id = '" . $_POST["cid"] . "' "));
		$subject_new = "เรื่อง" . $G['c_name'];
		//File user login
		$sql_info = $db->db_fetch_array($db->query("select * from ".$EWT_DB_USER.".gen_user where gen_user_id='" . $_SESSION["EWT_SMID"] . "'"));
		$name = $sql_info['name_thai'] . '' . $sql_info['surname_thai'];
		$db->query("INSERT INTO ".$EWT_DB_NAME.".n_history (h_subject,h_from_n,h_from_e,h_body,h_attach,h_date,h_time,h_user) VALUES ('" . addslashes($subject) . "','" . addslashes($name) . "','" . addslashes($sql_info['email_kh']) . "','" . addslashes($body) . "','',NOW( ),NOW( ),'0')");

		## >> Get h_id
		$hid_data = $db->query("SELECT MAX(h_id) AS h_id FROM ".$EWT_DB_NAME.".n_history");
		$hid_info = $db->db_fetch_array($hid_data);
		$hid      = $hid_info["h_id"];

		$sql_group_enew = $db->query("select * from ".$EWT_DB_NAME.".n_group inner join ".$EWT_DB_NAME.".n_group_member on n_group.g_id=n_group_member.g_id inner join ".$EWT_DB_NAME.".n_member on n_group_member.m_id=n_member.m_id where g_name= '" . $_POST["cid"] . "' and m_active ='Y'");

		$nnn = $db->db_num_rows($sql_group_enew);
		echo  "num>>" . $nnn;
		//exit;
		while ($R_M = $db->db_fetch_array($sql_group_enew)) {
			array_push($email_member, $R_M['m_email']);
			$db->query("INSERT INTO ".$EWT_DB_NAME.".n_send (h_id,s_date,s_time,s_email) VALUES ('$hid',NOW( ),NOW( ),'$R_M[m_email]')");
		}

		for ($i = 0; $i < count($email_member); $i++) {
			$to = $email_member[$i];
			if (!empty($to)) {
				$message = '';
				$subject = "=?UTF-8?B?" . base64_encode("แจ้งการอัพเดทข่าสาร " . $subject_new) . "?=";
				$message .= '<html>';
				$message .= '<head>';
				$message .= '<title>' . $subject . '</title>';
				$message .= '</head>';
				$message .= '<body>';

				$message .= '<table bgcolor = "#FFFFFF" border = "0" width = "100%">';
				$message .= '<tr>';
				$message .= '<td  width="100%">' . $subject_new . '</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td  width="100%">' . $body . '</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td width="100%" >' . $txt . '</td>';
				$message .= '</tr>';
				$message .= '</table><br><br>';
				$message .= '</body>';
				$message .= '</html>';

				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8\r\n";
				$headers .= "To: " . $to . " \r\n";
				$headers .= "From: RTRC Webmaster" . $mailmaster . "  \r\n";

				$flgSends = @mail($to, $subject, $message, $headers);
			}
		}
		//end send mail
	}
	$nfile = "n" . date("Ymd") . "_" . $nid;
	$Current_Dir = "../ewt/" . $_SESSION["EWT_SUSER"] . "/images/article/news" . $nid;
	if (!is_dir($Current_Dir)) {
		mkdir($Current_Dir, 0777, true);
	}

	if ($_FILES['file']['size'] > 0 and $_FILES['file']['size'] <= $max_img_size) {
		$F = explode(".", $_FILES["file"]["name"]);
		$C = count($F);
		$CT = $C - 1;
		$dir = strtolower($F[$CT]);
		if ($dir == "jpeg") {
			$dir = "jpg";
		}
		$picname = $nfile . "." . $dir;
		$isMove = move_uploaded_file($_FILES['file']['tmp_name'], $Current_Dir . "/" . $picname);
		@chmod($Current_Dir . "/" . $picname, 0777);
		$db->query("UPDATE article_list SET picture = '$picname' WHERE n_id = '$nid' ");
		include("../ewt_thumbnail.php");

		$size = @getimagesize($Current_Dir . "/" . $picname);
		$chi = $size[1];
		$cwi = $size[0];

		//resize thumb
		if ($dir == "jpg") {
			thumb_jpg($Current_Dir . "/" . $picname, $Current_Dir . "/t" . $picname, "120", "120");
		}
		if ($dir == "gif") {
			thumb_gif($Current_Dir . "/" . $picname, $Current_Dir . "/t" . $picname, "120", "120");
		}
		if ($dir == "png") {
			thumb_png($Current_Dir . "/" . $picname, $Current_Dir . "/t" . $picname, "120", "120");
		}
		//}
	} else {
		if ($_FILES['file']['size'] > $max_img_size) {
			?>
			<script>
				alert('Image file size of <?php echo $_FILES['file']['name']; ?> size[<?php echo number_format($_FILES['file']['size'] / 1024, 2); ?> Kb] is over maximum.\nPlease change or resize your file.')
			</script>
		<?php
		}
	}

	if ($_POST["detail_use"] == "2") {
		if ($_POST["at_id"] != '10') {
			$temp = $db->query("SELECT at_file_new FROM ".$EWT_DB_NAME.".article_template WHERE at_id = '" . $_POST["at_id"] . "'");
			$T = $db->db_fetch_row($temp);
			include("../article_template/code/" . $T[0]);
		?>
			<script>
				self.location.href = 'article_detail.php?nid=<?php echo $nid; ?>'
			</script>
		<?php
		} else {
			$db->query("INSERT INTO ".$EWT_DB_NAME.".article_detail (n_id , at_type_col , at_type_row , ad_pic_s , ad_pic_h , ad_pic_w , ad_pic_b , ad_des , ad_font , ad_size , ad_bold , ad_italic , ad_color, ad_align) VALUES ('$nid', '1', '1', '', '200', '200', '', NULL , 'MS Sans Serif', '1', NULL , NULL , '#000000', 'left')");
		?>
			<script>
				self.location.href = '../ewt/<?php echo $EWT_FOLDER_USER; ?>/article_freestype.php?nid=<?php echo $nid; ?>'
			</script>
		<?php
		}
	} else if ($_POST["detail_use"] == "3") {
		for ($i = 1; $i <= $_POST['txtrow']; $i++) {
			for ($y = 1; $y <= $_POST['txtcol']; $y++) {
				$db->query("INSERT INTO ".$EWT_DB_NAME.".article_detail ( n_id , at_type_col , at_type_row , ad_pic_s , ad_pic_h , ad_pic_w , ad_pic_b , ad_des , ad_font , ad_size , ad_bold , ad_italic , ad_color, ad_align ) VALUES ( '$nid', '" . $y . "', '" . $i . "', '', '200', '200', '', NULL , 'MS Sans Serif', '1', NULL , NULL , '#000000', 'center')");
			}
		}
		?>
		<script>
			self.location.href = 'article_detail.php?nid=<?php echo $nid; ?>'
		</script>
		<?php
	} else if ($_POST["detail_use"] == "4") {
		if (!file_exists("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp")) {
			@mkdir("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp", 0700);
		}
		if ($_FILES['filedl']['size'] > 0) {
			$myfile = "tmp" . $_SESSION["EWT_SMID"] . "A" . $nid . "O" . date("YmdHis") . ".tmp";
			$myname = $_FILES['filedl']['name'];
			$mysize = $_FILES['filedl']['size'];
			$mytype = $_FILES['filedl']['type'];
			//find type File
			$F = explode(".", $_FILES["filedl"]["name"]);
			$C = count($F);
			$CT = $C - 1;
			$dir = strtolower($F[$CT]);
			$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
			$query_type_file = $db->query($sql_type_file);
			$R_type_file = $db->db_fetch_array($query_type_file);
			$type_file = $R_type_file['site_type_file'];
			$pos = strpos($type_file, $dir);
			if ($pos === FALSE) {
		?>
				<script>
					alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด <?php echo $type_file; ?> ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
					self.location.href = 'article_edit.php?cid=<?php echo $_POST['cid'] . '&nid=' . $nid; ?>'
				</script>
		<?php
			} else {
				copy($_FILES["filedl"]["tmp_name"], "../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp/" . $myfile);
				@chmod("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp/" . $myfile, 0777);
			}
			$db->query("INSERT INTO download_list (dl_name,dl_userfile,dl_sysfile,dl_filetype,dl_filesize,dl_gid) VALUES ('" . $_POST["chk_member"] . "','" . $myname . "','" . $myfile . "','" . $mytype . "','" . $mysize . "','" . $nid . "')");
		}
		?>
		<script>
			self.location.href = 'article_list.php?cid=<?php echo $_POST['cid']; ?>'
		</script>
	<?php
	} else {
	?>
		<script>
			self.location.href = 'article_list.php?cid=<?php echo $_POST['cid']; ?>'
		</script>
		<?php
	}
}

if ($_POST["Flag"] == "NewsDetail") {
	include("../ewt_thumbnail.php");
	$array_list = array(
		"d_id" => !empty($_POST["template"]) ? $_POST["template"] : 0,
		"d_id_w3c" => !empty($_POST["template_w3c"]) ? $_POST["template_w3c"] : 0,
		"show_group" => $_POST["chk_group"],
		"show_topic" => $_POST["chk_topic"],
		"show_date" => $_POST["chk_date"],
		"show_newstop" => $_POST["chk_newsshow"],
		"show_vote" => $_POST["chk_vote"],
		"show_comment" => $_POST["chk_comment"],
		"comment_type" => $_POST["comment_type"],
		"show_textsize" => $_POST['chk_textsize'],
		"show_count" => $_POST["chk_show_count"]
	);

	$array_where = array(
		"n_id" => $_POST["nid"]
	);

	update("article_list", $array_list, $array_where);
	$Current_Dir = "../ewt/" . $_SESSION["EWT_SUSER"] . "/images/article/news" . $_POST["nid"] . "/";

	$keyword = "";
	$sql_keyword = $db->query("SELECT ad_des FROM ".$EWT_DB_NAME.".article_detail WHERE n_id = '" . $_POST["nid"] . "' ORDER BY at_type_row,at_type_col");
	while ($D = $db->db_fetch_row($sql_keyword)) {
		$keyword .= $D[0];
	}

	$search = array(
		"'<script[^>]*?>.*?</script>'si",
		"'<[\ /\!]*?[^<>]*?>'si",
		"'([\r\n])[\s]+'",
		"'&(quot|#34);'i",
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		"'&#(\d+);'e"
	);

	$replace = array(
		"",
		"",
		"\\1",
		"\"",
		"&",
		"<", ">", " ", chr(161), chr(162), chr(163), chr(169), "chr(\\1)"
	);
	$keyword = preg_replace(
		$search,
		$replace,
		$keyword
	);

	$db->query("UPDATE article_list SET keyword = '" . addslashes($keyword) . "', n_last_modi='" .
		date('YmdHis') . "' WHERE n_id = '" . $_POST["nid"] . "' ");
	switch ($_POST["n_action"]) {
		case "save":
			break;
		case "preview":
		?>
			<script>
				window.open("../ewt/" . $_SESSION['EWT_SUSER'] . "/article_view.php?n_id=<?php echo $_POST['nid']; ?>", "artpv", "width=1000,height=550,resizable=1,scrollbars=1");
			</script>
		<?php
			break;
		case "cancel":
			$db->query("UPDATE  article_list  SET n_approve='D' WHERE  n_id = '" . $_POST["nid"] . "'");
		?>
			<script>
				self.parent.location.href = 'article_list.php?cid=<?php echo $_POST['cid']; ?>'
			</script>
		<?php
			break;
		case "exit":
			$db->query("update article_list set n_last_modi='" . date('YmdHis') . "' where n_id = '" . $_POST["cid"] . "' ");
		?>
			<script>
				self.parent.location.href = 'article_list.php?cid=<?php echo $_POST['cid']; ?>'
			</script>
			<?php
	}
}

if ($_POST["Flag"] == "EditArticle") {
	$nid = ready($_POST["nid"]);
	##=========================================================================================##
	## >> Article tag

	$article_tag = trim($_POST["article_tag"]);
	$db->query("DELETE FROM article_taglist WHERE n_id = '$nid' AND lang_id = '1'");


	if ($article_tag != "") {
		$article_tag = explode(",", $article_tag);
		$unique_tag  = array();

		foreach ($article_tag as $tag_e) {
			if (!in_array($tag_e, $unique_tag)) {
				array_push($unique_tag, ready($tag_e));
			}
		}

		foreach ($unique_tag as $tag_e) {
			## >> Insert
			$db->query("INSERT INTO article_taglist (n_id,lang_id,tag_name) VALUES ('$nid','1','$tag_e')");

			## >> Count and update
			$check_tag  = strtolower($tag_e);
			$check_list = $db->query("SELECT tag_id FROM article_tagcount WHERE tag_name = '$check_tag' COLLATE utf8_bin AND lang_id = '1'");

			if ($db->db_num_rows($check_list) == 0) {
				$db->query("INSERT INTO article_tagcount (tag_name,lang_id,tag_count) VALUES ('$check_tag','1','1')");
			} else {
				$list_info = $db->db_fetch_array($check_list);
				$tag_id    = $list_info["tag_id"];

				$count = $db->query("SELECT COUNT(taglist_id) AS total FROM article_taglist WHERE tag_name = '$tag_e' COLLATE utf8_bin AND lang_id = '1'");
				$count = $db->db_fetch_array($count);
				$total = $count["total"];

				$db->query("UPDATE article_tagcount SET tag_count = '$total' WHERE tag_id = '$tag_id' AND lang_id = '1'");
			}
		}
	}

	##=========================================================================================##

	if ($_POST["browsefile"] == '1') {
		$link = addslashes($_POST["link"]);
	} else {
		$Current_Dir2 = "../ewt/" . $_SESSION["EWT_SUSER"] . "/download/article";
		$Current_Dir3 = "download/article";
		@mkdir($Current_Dir2, 0777);
		if ($_FILES["filebrowse"]['size'] > 0) {
			$F = explode(".", $_FILES["filebrowse"]["name"]);
			$C = count($F);
			$CT = $C - 1;
			$dir = strtolower($F[$CT]);

			//find type File

			$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
			$query_type_file = $db->query($sql_type_file);
			$R_type_file = $db->db_fetch_array($query_type_file);
			$type_file = $R_type_file['site_type_file'];
			$pos = strpos($type_file, $dir);
			if ($pos === FALSE) {
			?>
				<script>
					alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด <?php echo $type_file; ?> ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
					self.location.href = 'article_edit.php?cid=<?php echo $_POST['cid'] . '&nid=' . $_POST['nid']; ?>'
				</script>
			<?php
			} else {
				$nfile = "article_" . date("YmdHis");
				$picname = $nfile . "." . $dir;
				copy($_FILES["filebrowse"]["tmp_name"], $Current_Dir2 . "/" . $picname);
				unlink("../ewt/" . $_SESSION["EWT_SUSER"] . "/" . $_POST["hdd_file"]);
				@chmod($Current_Dir2 . "/" . $picname, 0777);
				$link = $Current_Dir3 . "/" . $picname;
			}
		}
	}
	$Current_Dir = "../ewt/" . $_SESSION["EWT_SUSER"] . "/images/article/news" . $_POST["nid"];
	if (!file_exists($Current_Dir)) {
		@mkdir($Current_Dir, 0777);
	}
	$picname = $_POST["pict"];
	if ($_POST["cpic"] == "Y") {
		$picname = "";
	} else {
		$nfile = "n" . date("Ymd") . "_" . $_POST["nid"];
		if ($_FILES['file']['size'] > 0 and $_FILES['file']['size'] <= $max_img_size) {
			$F = explode(".", $_FILES["file"]["name"]);
			$C = count($F);
			$CT = $C - 1;
			$dir = strtolower($F[$CT]);
			if ($dir == "jpeg") {
				$dir = "jpg";
			}
			$picname = $nfile . "." . $dir;
			$isMove = move_uploaded_file($_FILES['file']['tmp_name'], $Current_Dir . "/" . $picname);
			@chmod($Current_Dir . "/" . $picname, 0777);

			include("../ewt_thumbnail.php");

			$size = @getimagesize($Current_Dir . "/" . $picname);
			$chi = $size[1];
			$cwi = $size[0];

			if ($dir == "jpg") {
				thumb_jpg($Current_Dir . "/" . $picname, $Current_Dir . "/t" . $picname, "120", "120");
			}
			if ($dir == "gif") {
				thumb_gif($Current_Dir . "/" . $picname, $Current_Dir . "/t" . $picname, "120", "120");
			}
			if ($dir == "png") {
				thumb_png($Current_Dir . "/" . $picname, $Current_Dir . "/t" . $picname, "120", "120");
			}
		}
	}

	$topic = stripslashes(htmlspecialchars($_POST["topic"], ENT_QUOTES));
	$description = stripslashes(htmlspecialchars($_POST["description"], ENT_QUOTES));

	$source = stripslashes(htmlspecialchars($_POST["source"], ENT_QUOTES));
	$source_url = addslashes($_POST["source_url"]);
	$keyword = stripslashes(htmlspecialchars($_POST["keyword"], ENT_QUOTES));
	$time_n = stripslashes(htmlspecialchars($_POST["time_n"], ENT_QUOTES));

	$date = explode("/", $_POST["date_n"]);
	$date_n = $date[2] . "-" . $date[1] . "-" . $date[0];

	$date1 = explode("/", $_POST["date_e"]);
	$date_e = $date1[2] . "-" . $date1[1] . "-" . $date1[0];

	if ($_POST["date_start"] != '' && $_POST["date_end"] != '') {
		if ($_POST["time_H_start"] == '') {
			$_POST["time_H_start"] = '00';
		}
		if ($_POST["time_s_start"] == '') {
			$_POST["time_s_start"] = '00';
		}
		if ($_POST["time_H_end"] == '') {
			$_POST["time_H_end"] = '00';
		}
		if ($_POST["time_s_end"] == '') {
			$_POST["time_s_end"] = '00';
		}
		$time_st = $_POST["time_H_start"] . ':' . $_POST["time_s_start"] . ':00';
		$time_ed = $_POST["time_H_end"] . ':' . $_POST["time_s_end"] . ':00';
		$date_st = explode("/", $_POST["date_start"]);
		$date_start = $date_st[2] . "-" . $date_st[1] . "-" . $date_st[0] . ' ' . $time_st;
		$date_ed = explode("/", $_POST["date_end"]);
		$date_end = $date_ed[2] . "-" . $date_ed[1] . "-" . $date_ed[0] . ' ' . $time_ed;
	} else {
		$date_start = '';
		$date_end = '';
	}
	if ($_POST["ctime"] == "Y") {
		$date_start = '';
		$date_end = '';
	}
	if ($_POST["nuse"] == "1") {
		$chk_count = $_POST["chk_show_count_level1"];
	} else if ($_POST["nuse"] == "4") {
		$chk_count = $_POST["chk_show_count"];
	}

	$array_list = array(
		"c_id" => $_POST["cid"],
		"n_date" => $date_n,
		"n_time" => $time_n,
		"n_timestamp" => date("Y-m-d H:i:s"),
		"n_topic" => $topic,
		"n_des" => $description,
		"source" => $source,
		"sourceLink" => $source_url,
		"link_html" => $link,
		"target" => $_POST["target"],
		"picture" => $picname,
		"expire" => $date_e,
		"logo" => $_POST["icon"],
		"n_date_start" => $date_start,
		"n_date_end" => $date_end,
		"show_count" => $chk_count,
	);

	$array_where = array(
		"n_id" => $_POST["nid"],
	);

	update("article_list", $array_list, $array_where);
	$db->write_log("update", "article", " article " . $topic);

	Gen_RSS($_POST["cid"]);
	//if shere data to site other
	$sql_shere = $db->query("select n_share,news_use,link_html from article_list where n_id ='" . $_POST["nid"] . "'");
	$N = $db->db_fetch_array($sql_shere);
	$typeuse = $N['news_use'];
	$typeshere = $N['n_share'];
	if ($N['n_share'] == 'Y') {
		//select site
		$sql_sl = $db->query("select n_id_t,user_t,UID_t,user_s,UID_s from ".$EWT_DB_USER.".share_article where n_id = '" . $_POST["nid"] . "' and user_s = '" . $_SESSION["EWT_SUSER"] . "' ");
		while ($SL = $db->db_fetch_array($sql_sl)) {
			//update type  ewt_user
			$array_list = array(
				"n_date" => $date_n,
				"n_topic" => $topic,
				"n_des" => $description,
				"source" => $source,
				"sourceLink" => $source_url,
				"link_html" => $link,
				"target" => $_POST["target"],
				"picture" => $picname,
				"expire" => $date_e,
				"logo" => $_POST["icon"],
			);

			$array_where = array(
				"n_id" => $_POST["nid"],
				"user_share" => $_SESSION["EWT_SUSER"],
			);

			update("".$EWT_DB_NAME.".article_list", $array_list, $array_where);

			$sql_tb = $db->query("select * from ".$EWT_DB_USER.".user_info where UID ='" . $SL['UID_s'] . "'");
			$T = $db->db_fetch_array($sql_tb);
			$url = $T['url'];
			$sql_tb = $db->query("select * from ".$EWT_DB_USER.".user_info where UID ='" . $SL['UID_t'] . "'");
			$TT = $db->db_fetch_array($sql_tb);
			$db_main = $TT['db_db'];
			if ($typeuse == "1") {
				$rest = substr($N['link_html'], 0, 7);
				if ($rest == "http://") {
					$linkhtml = $N['link_html'];
				} else {
					$linkhtml = $url . $N['link_html'];
				}
			}
			if ($typeuse == "2" || $typeuse == "3") {
				$dec = base64_encode($SL['user_s'] . "@@@" . $_POST["nid"]);
				$linkhtml = "ewt_snews.php?s=" . $dec;
			}
			if ($typeuse == "4") {
				$linkhtml = $url . "news_view.php?n_id=" . $_POST["nid"];
			}
			//tb
			$linkdata = $linkhtml;
			$db->query('USE ' . $db_main);
			$update = "UPDATE ".$EWT_DB_NAME.".article_list SET n_date = '$date_n',n_topic = '$topic',n_des = '$description',source = '" . $source . "',sourceLink = '" . $source_url . "',link_html = '$linkdata',target = '" . $_POST["target"] . "',picture = '$picname',expire = '$date_e',logo = '" . $_POST["icon"] . "',n_date_start = '" . $date_start . "' ,n_date_end ='" . $date_end . "'  WHERE n_id = '" . $SL["n_id_t"] . "' and n_shareuse = 'Y' ";
			$db->query($update);
		}
		$db->query('USE ' . $EWT_DB_NAME);
	}
	//End if 
	if ($_POST["nuse"] == "4") {
		if ($_FILES['filedl']['size'] > 0) {
			$myfile = "tmp" . $_SESSION["EWT_SMID"] . "A" . $nid . "O" . date("YmdHis") . ".tmp";
			$myname = $_FILES['filedl']['name'];
			$mysize = $_FILES['filedl']['size'];
			$mytype = $_FILES['filedl']['type'];
			//find type File
			$F = explode(".", $_FILES["filedl"]["name"]);
			$C = count($F);
			$CT = $C - 1;
			$dir = strtolower($F[$CT]);
			$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
			$query_type_file = $db->query($sql_type_file);
			$R_type_file = $db->db_fetch_array($query_type_file);
			$type_file = $R_type_file['site_type_file'];
			$pos = strpos($type_file, $dir);
			if ($pos === FALSE) {
			?>
				<script>
					alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด <?php echo  $type_file; ?> ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
					self.location.href = 'article_edit.php?cid=<?php echo $_POST['cid'] . '&nid=' . $_POST['nid']; ?>'
				</script>
	<?php
			} else {
				if ($mysize > 0 && $mysize <= 10240000) {
					copy($_FILES["filedl"]["tmp_name"], "../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp/" . $myfile);
					@chmod("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp/" . $myfile, 0777);
					@unlink("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp/" . $_POST["olddl_file"]);
				} else if ($mysize > 10240000) {
					copy($_FILES["filedl"]["tmp_name"], "../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp/" . $myname);
					@chmod("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp/" . $myname, 0777);
					$myfile = "article_tmp/" . $myname;
					@unlink("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp/" . $_POST["olddl_file"]);
				}
				$db->query("UPDATE download_list SET dl_userfile = '" . $myname . "',dl_sysfile = '" . $myfile . "',dl_filetype = '" . $mytype . "',dl_filesize = '" . $mysize . "' WHERE  dl_gid = '" . $_POST["nid"] . "' ");
			}
		}
		$db->query("UPDATE download_list SET dl_name = '" . $_POST["chk_member"] . "' WHERE  dl_gid = '" . $_POST["nid"] . "' ");
	}
	?>
	<script>
		self.location.href = "article_list.php?cid=<?php echo $_POST['cid']; ?>"
	</script>
<?php
}

if ($_POST["Flag"] == "DelArticle") {
	$nid_line = "";
	for ($i = 0; $i < $_POST["alli"]; $i++) {
		$chk = $_POST["chk" . $i];
		if ($chk != "") {
			$sql_edit = $db->query("SELECT * FROM ".$EWT_DB_NAME.".article_list WHERE n_id = '$chk' ");
			$R = $db->db_fetch_array($sql_edit);
			$cid = $R['c_id'];
			if ($R["n_share"] == "Y") {
				$Share = $db->query("SELECT share_article.n_id_t, user_info.db_db FROM ".$EWT_DB_USER.".share_article INNER JOIN ".$EWT_DB_USER.".user_info ON share_article.user_t = user_info.EWT_User WHERE share_article.n_id = '" . $chk . "' AND share_article.user_s = '" . $_SESSION["EWT_SUSER"] . "' AND share_article.n_id_t != ''");
				while ($S = $db->db_fetch_row($Share)) {
					$db->query("USE " . $S[1]);
					$db->query("DELETE FROM article_list WHERE n_id = '" . $S[0] . "' ");
				}
				$db->query("DELETE FROM ".$EWT_DB_USER.".article_list  WHERE user_share = '" . $_SESSION["EWT_SUSER"] . "' AND n_id = '" . $chk . "' ");
			}
			$db->query("USE " . $_SESSION["EWT_SDB"]);
			$db->write_log("delete", "article", "ลบ article    " . $R['n_topic']);
			$db->query("UPDATE article_list SET n_approve='D',n_share = '',n_delowner='" . $_SESSION['EWT_SMID'] . "' ,n_deldate='" . date('YmdHis') . "' WHERE  n_id = '$chk'  ");
			Gen_RSS($cid);
		}

		if (trim($chk) != "") {
			$nid_line .= "'" . $chk . "',";
		}
	}

	## >> Update Tag count
	$nid_line   = rtrim($nid_line, ",");
	$nid_array  = explode(",", str_replace("'", "", $nid_line));
	$unique_tag = array();

	$tag_data = $db->query("SELECT DISTINCT(tag_name) AS tag_name FROM article_taglist WHERE n_id IN ($nid_line)");
	while ($tag_info = $db->db_fetch_array($tag_data)) {
		array_push($unique_tag, $tag_info["tag_name"]);
	}

	foreach ($nid_array as $chk) {
		$db->query("DELETE FROM article_taglist WHERE n_id = '$chk'");
	}

	foreach ($unique_tag as $tag_e) {
		## >> Count and update
		$check_tag  = strtolower($tag_e);
		$check_list = $db->query("SELECT tag_id FROM article_tagcount WHERE tag_name = '$check_tag' COLLATE utf8_bin AND lang_id = '1'");

		if ($db->db_num_rows($check_list) == 0) {
		} else {
			$list_info = $db->db_fetch_array($check_list);
			$tag_id    = $list_info["tag_id"];

			$count = $db->query("SELECT COUNT(taglist_id) AS total FROM article_taglist WHERE tag_name = '$tag_e' COLLATE utf8_bin AND lang_id = '1'");
			$count = $db->db_fetch_array($count);
			$total = $count["total"];

			$db->query("UPDATE article_tagcount SET tag_count = '$total' WHERE tag_id = '$tag_id' COLLATE utf8_bin AND lang_id = '1'");
		}
	}

?>
	<script>
		self.location.href = 'article_list.php?cid=<?php echo $_POST['cid']; ?>'
	</script>
<?php
}

function LooPDel($p)
{
	$dir = @opendir($p);
	//echo $p;
	while ($data = @readdir($dir)) {
		if (($data != ".") and ($data != "..") and ($data != "")) {
			if (!@unlink($p . "/" . $data)) {
				LooPDel($p . "/" . $data);
			}
		}
	}
	@closedir($dir);
	@rmdir($p);
}

if ($_POST["Flag"] == "RemoveArticle") {
	for ($i = 0; $i < $_POST["alli"]; $i++) {
		$chk = $_POST["chk" . $i];
		if ($chk != "") {
			$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '$chk' ");
			$R = $db->db_fetch_array($sql_edit);
			$cid = $R['c_id'];
			$db->write_log("delete", "article", "ลบ article    " . $R['n_topic']);
			$db->query("DELETE FROM article_list WHERE n_id = '$chk'");

			if ($R['news_use'] == '1') {
				$rest = substr($R['link_html'], 0, 7);
				if ($rest == "http://") {
				} else {
					@unlink("../ewt/" . $_SESSION["EWT_SUSER"] . "/images/article/freetemp/" . $R['link_html']);
				}
			} else if ($R['news_use'] == '2' || $R['news_use'] == '3') {
				$path = '../ewt/' . $EWT_FOLDER_USER . "/images/article";
				if (!@rmdir($path . "/news" . $chk)) {
				}
				LooPDel($path . "/news" . $chk);
				$pathall = "../ewt/" . $EWT_FOLDER_USER . "/article/TEMP" . $chk . ".html";
				@unlink($pathall);
			} else if ($R['news_use'] == '4') {
				$sql_f = "select * from download_list WHERE  dl_gid = '" . $chk . "' ";
				$query_f = $db->query($sql_f);
				$F = $db->db_fetch_array($query_f);
				$FileU = $F['dl_sysfile'];
				@unlink("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_tmp/" . $FileU);
				$db->query("DELETE FROM download_list WHERE dl_gid = '$chk'");
			}
			Gen_RSS($cid);
		}
	}

?>
	<script>
		self.location.href = 'article_dellist.php'
	</script>
<?php
}

if ($_POST["Flag"] == "CancelDelete") {
	for ($i = 0; $i < $_POST["alli"]; $i++) {
		$chk = $_POST["chk" . $i];
		if ($chk != "") {
			$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '$chk' ");
			$R = $db->db_fetch_array($sql_edit);
			$cid = $R['c_id'];
			$db->write_log("cancel delete", "article", "ลบ article    " . $R['n_topic']);
			$db->query("UPDATE  article_list  SET n_approve='' WHERE  n_id = '$chk'  ");
			Gen_RSS($cid);
		}
	}
?>
	<script>
		self.location.href = 'article_dellist.php'
	</script>
	<?php
}

if ($_POST["Flag"] == "AppArticle") {
	$sql_ewt = $db->db_fetch_array($db->query("select * from ".$EWT_DB_USER.".user_info where UID='" . $_SESSION["EWT_SUID"] . "'"));
	for ($i = 0; $i < $_POST["alli"]; $i++) {
		$chk = $_POST["app" . $i];
		$nid = $_POST["nid" . $i];
		$R = $db->db_fetch_array($db->query("select * from ".$EWT_DB_NAME.".article_list  WHERE n_id = '$nid' "));
		if ($chk == "Y") {
			if ($R["n_approve"] <> "Y") {
				$text_name = $R['n_topic'];
				$text_dec = $R['n_des'];
				if ($R["news_use"] == "2" || $R["news_use"] == "3") {
					$text_link = "<a href=\"" . $sql_ewt['url'] . "/article-views.php?nid=" . $R['n_id'] . "\" target=\"_blank\">";
				} else {
					$rest = substr($R["link_html"], 0, 4);
					if ($rest == 'http') {
						$text_link .= "<a href=\"" . $R["link_html"] . "\" target=\"_blank\">";
					} else {
						$text_link .= "<a href=\"" . $sql_ewt['url'] . "/" . $R['link_html'] . "\" target=\"_blank\">";
					}
				}
				$txt .= "- " . $text_link . $text_name . "</a><br>";
				$txt .= $text_dec;
				$txt .= '<br>';
			}
			$db->query("UPDATE ".$EWT_DB_NAME.".article_list SET n_approve = 'Y' , n_approvedate = '" . date("Y-m-d H:i") . "' WHERE n_id = '$nid'");
			$db->write_log("approve", "article", "อนุมติ article " . $R['n_topic']);
		} else {
			$db->query("UPDATE ".$EWT_DB_NAME.".article_list SET n_approve = '' , n_approvedate = '" . date("Y-m-d H:i") . "' WHERE n_id = '$nid'");
			$db->write_log("approve", "article", "ยกเลิกการอนุมัติ article " . $R['n_topic']);
		}
	}

	Gen_RSS($_POST["cid"]);
	if (!empty($txt)) {
		$email_member = array();
		$body = "<font face='MS Sans Serif' size=2>ถึงท่านสมาชิกทุกท่าน  มีข่าวสารใหม่ขอแจ้งให้ทราบดังนี้<br></font>";
		$G = $db->db_fetch_array($db->query("select * from ".$EWT_DB_NAME.".article_group  WHERE c_id = '" . $_POST["cid"] . "' "));
		$subject = "เรื่อง" . $G['c_name'];
		$sql_info = $db->db_fetch_array($db->query("select * from ".$EWT_DB_USER.".gen_user where gen_user_id='" . $_SESSION["EWT_SMID"] . "'"));
		$name = $sql_info['name_thai'] . '' . $sql_info['surname_thai'];
		$db->query("INSERT INTO ".$EWT_DB_NAME.".n_history (h_subject,h_from_n,h_from_e,h_body,h_attach,h_date,h_time,h_user) VALUES ('" . addslashes($subject) . "','" . addslashes($name) . "','" . addslashes($sql_info['email_kh']) . "','" . addslashes($body) . "','',NOW( ),NOW( ),'0')");
		$hid_data = $db->query("SELECT MAX(h_id) AS h_id FROM ".$EWT_DB_NAME.".n_history");
		$hid_info = $db->db_fetch_array($hid_data);
		$hid      = $hid_info["h_id"];

		$sql_group_enew = $db->query("select * from ".$EWT_DB_NAME.".n_group inner join ".$EWT_DB_NAME.".n_group_member on n_group.g_id=n_group_member.g_id inner join ".$EWT_DB_NAME.".n_member on n_group_member.m_id=n_member.m_id where g_name= '" . $_POST["cid"] . "' and m_active ='Y'");
		while ($R_M = $db->db_fetch_array($sql_group_enew)) {
			array_push($email_member, $R_M['m_email']);
			$db->query("INSERT INTO ".$EWT_DB_NAME.".n_send (h_id,s_date,s_time,s_email) VALUES ('$hid',NOW( ),NOW( ),'$R_M[m_email]')");
		}

		for ($i = 0; $i < count($email_member); $i++) {
			$to = $email_member[$i];
			if (!empty($to)) {
				$subject = "=?UTF-8?B?" . base64_encode("แจ้งการอัพเดทข่าวสาร " . $text_name) . "?=";
				$message = '';
				$message .= '<html>';
				$message .= '<head>';
				$message .= '<title>' . $subject . '</title>';
				$message .= '</head>';
				$message .= '<body>';
				$message .= '<table bgcolor = "White" border = "0" width = "100%">';
				$message .= '<tr>';
				$message .= '<td  width="100%">' . $text_name . '</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td  width="100%">' . $body . '</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td width="100%" >' . $txt . '</td>';
				$message .= '</tr>';
				$message .= '</table><br><br>';
				$message .= '</body>';
				$message .= '</html>';
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8\r\n";
				$headers .= "To: " . $to . " \r\n";
				$headers .= "From: OTCC Webmaster" . $mailmaster . "  \r\n";

				$flgSends = @mail($to, $subject, $message, $headers);
			}
		}
		$db->write_log("sendmail", "enews", "ส่ง E-mail จดหมายข่าว เรื่อง  " . $subject);
	}

	if ($_POST["backto"] != "") {
	?>
		<script>
			self.location.href = '<?php echo $_POST['backto']; ?>'
		</script>
	<?php
	} else {
	?>
		<script>
			self.location.href = 'article_group.php'
		</script>
	<?php
	}
}

if ($_POST["Flag"] == "DelGroup") {
	for ($i = 0; $i < $_POST["alli"]; $i++) {
		$chk = $_POST["chk" . $i];
		if ($chk != "") {
			$chk_article_group = $db->db_num_rows($db->query("SELECT c_id FROM article_group WHERE  c_parent = '" . $chk . "' "));
			$chk_article_list = $db->db_num_rows($db->query("SELECT c_id FROM article_list WHERE n_approve != 'D' AND c_id = '" . $chk . "' "));

			if ($chk_article_group == 0 && $chk_article_list == 0) {
				$R_name_old = $db->db_fetch_array($db->query("SELECT c_name FROM article_group WHERE  c_id = '" . $chk . "' "));
				$db->write_log("delete", "article", "ลบ" . $R_name_old['c_name']);
				$db->query("DELETE FROM article_group WHERE c_id = '$chk'");
				$db->query("DELETE FROM article_apply WHERE c_id = '$chk'");
				$db->query("DELETE FROM article_list WHERE c_id = '$chk'");
				$db->query("DELETE FROM article_multigroup WHERE c_id = '$chk' ");

				if ($_POST["p"] != "") {
					$sql_u = "select * from article_group WHERE c_parent = '" . $_POST["p"] . "' order by d_id asc";
					$query1 = $db->query($sql_u);
					$j = 0;
					while ($rec1 = $db->db_fetch_array($query1)) {
						$j++;
						$db->query("update article_group set d_id = '" . $j . "' WHERE c_id = '" . $rec1['c_id'] . "'");
					}
				} else {
					$sql_u = "select * from article_group WHERE c_parent = '0' order by d_id asc";
					$query1 = $db->query($sql_u);
					$j = 0;
					while ($rec1 = $db->db_fetch_array($query1)) {
						$j++;
						$db->query("update article_group set d_id = '" . $j . "' WHERE c_id = '" . $rec1['c_id'] . "'");
					}
				}
			}
		}

		$filename = "../ewt/" . $_SESSION["EWT_SUSER"] . "/rss/group" . $chk . ".xml";
		@unlink($filename);
	}

	if ($_POST["backto"] != "") {
		//header("location:" . $_POST["backto"]);
		//exit;
	?>
		<script>
			self.location.href = '<?php echo $_POST["backto"]; ?>'
		</script>
	<?php
	} else if ($_POST["p"] == "") {
	?>
		<script>
			self.location.href = 'article_group.php'
		</script>
	<?php
	} else {
	?>
		<script>
			self.location.href = 'article_list.php?cid=<?php echo $_POST['p']; ?>'
		</script>
	<?php
	}
}

if ($_POST["Flag"] == "SetRSS") {
	$db->query("Update article_group SET c_rss='' WHERE c_id = '$chk'");
	for ($i = 0; $i < $_POST["alli"]; $i++) {
		$chk = $_POST["chkrss" . $i];
		$nid = $_POST["chkrssH" . $i];
		$R_name_old = $db->db_fetch_array($db->query("SELECT c_name FROM article_group WHERE  c_id = '" . $chk . "' "));
		if ($chk != "") {
			$db->write_log("SetRSS", "article", "SetRSS กลุ่มข่าว/บทความ" . $R_name_old['c_name']);
			$db->query("Update article_group SET c_rss='Y' WHERE c_id = '$chk'");
			Gen_RSS($chk);
		} else {
			$db->write_log("SetRSS", "article", "ยกเลิกการ SetRSS กลุ่มข่าว/บทความ" . $R_name_old['c_name']);
			$db->query("Update article_group SET c_rss=NULL WHERE c_id = '$nid'");
			$filename = "../ewt/" . $_SESSION["EWT_SUSER"] . "/rss/group" . $nid . ".xml";
			if (file_exists($filename)) {
				unlink($filename);
			}
		}
	}

	if ($_POST["backto"] != "") {
		// header("location:" . $_POST["backto"]);
		// exit;
	?>
		<script>
			self.location.href = '<?php echo $_POST["backto"]; ?>'
		</script>
	<?php
	} else if ($_POST["p"] == "") {
	?>
		<script>
			self.location.href = 'article_group.php'
		</script>
	<?php
	} else {
	?>
		<script>
			self.location.href = 'article_list.php?cid=<?php echo $_POST['p']; ?>'
		</script>
	<?php
	}
}

if ($_POST["Flag"] == "SetDocument") {
	$db->query("Update article_group SET c_show_document='' WHERE c_id = '$chk'");
	for ($i = 0; $i < $_POST["alli"]; $i++) {
		$chk = $_POST["chkdocument" . $i];
		$nid = $_POST["chkdocumentH" . $i];
		if ($chk != "") {
			$db->query("Update article_group SET c_show_document='Y' WHERE c_id = '$chk'");
		} else {
			$db->query("Update article_group SET c_show_document='N' WHERE c_id = '$nid'");
		}
	}

	if ($_POST["backto"] != "") {
		// header("location:" . $_POST["backto"]);
		// exit;
	?>
		<script>
			self.location.href = '<?php echo $_POST["backto"]; ?>'
		</script>
	<?php
	} else if ($_POST["p"] == "") {
	?>
		<script>
			self.location.href = 'article_group.php'
		</script>
	<?php
	} else {
	?>
		<script>
			self.location.href = 'article_list.php?cid=<?php echo $_POST['p']; ?>'
		</script>
	<?php
	}
}

if ($_POST["Flag"] == "Design") {
	$amd_mode = $_POST["amd_mode"];
	$AMBulletBP = $_POST["AMBulletBP"];
	$AMBulletSP = $_POST["AMBulletSP"];
	$AMHeadBG = $_POST["AMHeadBG"];
	$AMHeadP = $_POST["AMHeadP"];
	$AMHeadF = $_POST["AMHeadF"];
	$AMHeadS = $_POST["AMHeadS"];
	$AMHeadC = $_POST["AMHeadC"];
	$AMHeadB = $_POST["AMHeadB"];
	$AMHeadI = $_POST["AMHeadI"];
	$AMBodyBP = $_POST["AMBodyBP"];
	$AMBodyBG = $_POST["AMBodyBG"];
	$AMBodyF = $_POST["AMBodyF"];
	$AMBodyS = $_POST["AMBodyS"];
	$AMBodyC = $_POST["AMBodyC"];
	$AMBodyB = $_POST["AMBodyB"];
	$AMBodyI = $_POST["AMBodyI"];
	$AMMorePic = $_POST["AMMorePic"];
	$AMMORE = stripslashes(htmlspecialchars($_POST["AMMORE"], ENT_QUOTES));
	$AMBottomF = $_POST["AMBottomF"];
	$AMBottomS = $_POST["AMBottomS"];
	$AMBottomC = $_POST["AMBottomC"];
	$AMBottomB = $_POST["AMBottomB"];
	$AMBottomI = $_POST["AMBottomI"];
	$AMBOTTOMP = $_POST["AMBOTTOMP"];
	$AMBOTTOMH = $_POST["AMBOTTOMH"];
	$AMBOTTOMBG = $_POST["AMBOTTOMBG"];
	$code_html1 = addslashes($_POST["code_html"]);
	$AMDetailF = $_POST["AMDetailF"];
	$AMDetailS = $_POST["AMDetailS"];
	$AMDetailC = $_POST["AMDetailC"];
	$AMDetailB = $_POST["AMDetailB"];
	$AMDetailI = $_POST["AMDetailI"];
	$a_show = $_POST["a_show"];
	$AMWidth = $_POST["AMWidth"];
	$AMDate = $_POST["AMDate"];
	$AMUseHead = $_POST["AMUseHead"];
	$AMHeadH = $_POST["AMHeadH"];
	$AMUseDetail = $_POST["AMUseDetail"];
	$AMBulletBPW = $_POST["AMBulletBPW"];
	$AMBulletBPH = $_POST["AMBulletBPH"];
	$AMBulletSPW = $_POST["AMBulletSPW"];
	$AMBulletSPH = $_POST["AMBulletSPH"];
	$AMBodyBPW = $_POST["AMBodyBPW"];
	$AMBodyBPH = $_POST["AMBodyBPH"];

	//--------------------------------------font-------------------------------------//

	if ($AMHeadS == "") {
		$AMHeadST = "";
	} elseif ($AMHeadS == "8") {
		$AMHeadST = "1";
	} elseif ($AMHeadS == "10") {
		$AMHeadST = "2";
	} elseif ($AMHeadS == "12") {
		$AMHeadST = "3";
	} elseif ($AMHeadS == "14") {
		$AMHeadST = "4";
	} elseif ($AMHeadS == "18") {
		$AMHeadST = "5";
	} elseif ($AMHeadS == "24") {
		$AMHeadST = "6";
	} elseif ($AMHeadS == "36") {
		$AMHeadST = "7";
	}
	//------------------------------------------------------------------//
	if ($AMBodyS == "") {
		$AMBodyST = "";
	} elseif ($AMBodyS == "8") {
		$AMBodyST = "1";
	} elseif ($AMBodyS == "10") {
		$AMBodyST = "2";
	} elseif ($AMBodyS == "12") {
		$AMBodyST = "3";
	} elseif ($AMBodyS == "14") {
		$AMBodyST = "4";
	} elseif ($AMBodyS == "18") {
		$AMBodyST = "5";
	} elseif ($AMBodyS == "24") {
		$AMBodyST = "6";
	} elseif ($AMBodyS == "36") {
		$AMBodyST = "7";
	}
	//------------------------------------------------------------------//
	if ($AMBottomS == "") {
		$AMBottomST = "";
	} elseif ($AMBottomS == "8") {
		$AMBottomST = "1";
	} elseif ($AMBottomS == "10") {
		$AMBottomST = "2";
	} elseif ($AMBottomS == "12") {
		$AMBottomST = "3";
	} elseif ($AMBottomS == "14") {
		$AMBottomST = "4";
	} elseif ($AMBottomS == "18") {
		$AMBottomST = "5";
	} elseif ($AMBottomS == "24") {
		$AMBottomST = "6";
	} elseif ($AMBottomS == "36") {
		$AMBottomST = "7";
	}
	//------------------------------------------------------------------//
	if ($AMDetailS == "") {
		$AMDetailST = "";
	} elseif ($AMDetailS == "8") {
		$AMDetailST = "1";
	} elseif ($AMDetailS == "10") {
		$AMDetailST = "2";
	} elseif ($AMDetailS == "12") {
		$AMDetailST = "3";
	} elseif ($AMDetailS == "14") {
		$AMDetailST = "4";
	} elseif ($AMDetailS == "18") {
		$AMDetailST = "5";
	} elseif ($AMDetailS == "24") {
		$AMDetailST = "6";
	} elseif ($AMDetailS == "36") {
		$AMDetailST = "7";
	}
	//------------------------------------------------------------------//
	if (!file_exists("../ewt/" . $_SESSION["EWT_SUSER"] . "/article")) {
		@mkdir("../ewt/" . $_SESSION["EWT_SUSER"] . "/article", 0700);
	}
	if ($_POST["cancelCode"] == "Y") {
		$code_html = "";
	} else {
		if ($_FILES["file_html"]['size'] > 0) {
			$tmpname = "DA_" . $_POST["aid"] . ".htm";
			copy($_FILES["file_html"]["tmp_name"], "../ewt/" . $_SESSION["EWT_SUSER"] . "/article/" . $tmpname);
			$code_html = "Y";
		} else {
			$code_html = $code_html1;
		}
	}
	//------------------------------------------------------------------//
	$update = "UPDATE article_apply SET amd_mode = '$amd_mode',code_html = '$code_html',AMBulletBP = '$AMBulletBP',AMBulletSP = '$AMBulletSP',AMHeadBG = '$AMHeadBG',AMHeadP = '$AMHeadP',AMHeadF = '$AMHeadF',AMHeadS = '$AMHeadST',AMHeadC = '$AMHeadC',AMHeadB = '$AMHeadB',AMHeadI = '$AMHeadI',AMBodyBP = '$AMBodyBP',AMBodyBG = '$AMBodyBG',AMBodyF = '$AMBodyF',AMBodyS = '$AMBodyST',AMBodyC = '$AMBodyC',AMBodyB = '$AMBodyB',AMBodyI = '$AMBodyI',AMMorePic = '$AMMorePic',AMMORE = '$AMMORE',AMBottomF = '$AMBottomF',AMBottomS = '$AMBottomST',AMBottomC = '$AMBottomC',AMBottomB = '$AMBottomB',AMBottomI = '$AMBottomI',AMBOTTOMP = '$AMBOTTOMP',AMBOTTOMH = '$AMBOTTOMH',AMBOTTOMBG = '$AMBOTTOMBG',AMDetailF = '$AMDetailF',AMDetailS = '$AMDetailST',AMDetailC = '$AMDetailC',AMDetailB = '$AMDetailB',AMDetailI = '$AMDetailI',a_show = '$a_show',AMWidth = '$AMWidth',AMDate = '$AMDate',AMUseHead = '$AMUseHead',AMHeadH = '$AMHeadH',AMUseDetail = '$AMUseDetail' ,AMBulletBPW = '$AMBulletBPW',AMBulletBPH = '$AMBulletBPH',AMBulletSPW = '$AMBulletSPW',AMBulletSPH = '$AMBulletSPH',AMBodyBPW = '$AMBodyBPW',AMBodyBPH = '$AMBodyBPH',block_theme = '" . $_POST["select_block_design"] . "' WHERE a_id = '" . $_POST["aid"] . "' ";

	$db->query($update);

	if ($_POST["usedef"] == "Y") {
		$db->query("UPDATE  article_apply SET AMDefault = '' ");
		$db->query("UPDATE  article_apply SET AMDefault = 'Y' WHERE a_id = '" . $_POST["aid"] . "' ");
	}
	$sql_edit = $db->query("select block_name from block where BID ='" . $_POST["B"] . "'");
	$R = $db->db_fetch_array($sql_edit);
	$db->write_log("Design", "article", " Design /" . $R['block_name']);

	if ($_POST["applyto"] == "Y") {
	?>
		<script>
			self.location.href = 'article_apply.php?B=<?php echo $_POST['B'] . '&aid=' . $_POST['aid']; ?>'
		</script>
	<?php
	} else {
	?>
		<script>
			self.location.href = 'article_gdesign.php?B=<?php echo $_POST['B']; ?>';
			self.close();
		</script>
	<?php
	}
}

if ($_POST["Flag"] == "SetDisp") {
	$bcode = base64_decode($_POST["B"]);
	$bid_a = explode("z", $bcode);
	$BID = $bid_a[1];
	$block_link = $_POST["show_type"] . '#' . $_POST["show_marquee"] . '#' . $_POST["time_marquee"] . '#' . $_POST["show_nextdata"];
	$block_name = $_POST['block_name'];
	$db->query("UPDATE block SET block_link = '" . $block_link . "', block_name = '" . $block_name . "' WHERE BID = '" . $BID . "'");
	$sql_edit = $db->query("select block_name from block where BID ='" . $BID . "'");
	$R = $db->db_fetch_array($sql_edit);
	$db->write_log("SetDisp", "article", "ตั้งค่าแสดงผลข่าว/บทความใน block : " . $R['block_name']);
	?>
	<script>
		self.location.href = 'article_gdesign.php?B=<?php echo $_POST['B']; ?>'
	</script>
<?php
}

if ($_POST["Flag"] == "Apply") {
	$sql_design = $db->query("SELECT * FROM article_apply WHERE a_id = '" . $_POST["aid"] . "' ");
	$R = $db->db_fetch_array($sql_design);
	for ($i = 0; $i < $_POST["alli"]; $i++) {
		$a_id = $_POST["chk" . $i];
		if ($a_id != "") {
			$db->query("UPDATE article_apply SET a_show = '" . $R["a_show"] . "' ,amd_mode = '" . $R["amd_mode"] . "' ,code_html = '" . $R["code_html"] . "' ,AMBulletBP = '" . $R["AMBulletBP"] . "' ,AMBulletSP = '" . $R["AMBulletSP"] . "' ,AMHeadBG = '" . $R["AMHeadBG"] . "' ,AMHeadP = '" . $R["AMHeadP"] . "' ,AMHeadF = '" . $R["AMHeadF"] . "' ,AMHeadS = '" . $R["AMHeadS"] . "' ,AMHeadC = '" . $R["AMHeadC"] . "' ,AMHeadB = '" . $R["AMHeadB"] . "' ,AMHeadI = '" . $R["AMHeadI"] . "' ,AMBodyBP = '" . $R["AMBodyBP"] . "' ,AMBodyBG = '" . $R["AMBodyBG"] . "' ,AMBodyF = '" . $R["AMBodyF"] . "' ,AMBodyS = '" . $R["AMBodyS"] . "' ,AMBodyC = '" . $R["AMBodyC"] . "' ,AMBodyB = '" . $R["AMBodyB"] . "' ,AMBodyI = '" . $R["AMBodyI"] . "' ,AMMorePic = '" . $R["AMMorePic"] . "' ,AMMORE = '" . $R["AMMORE"] . "' ,AMBottomF = '" . $R["AMBottomF"] . "' ,AMBottomS = '" . $R["AMBottomS"] . "' ,AMBottomC = '" . $R["AMBottomC"] . "' ,AMBottomB = '" . $R["AMBottomB"] . "' ,AMBottomI = '" . $R["AMBottomI"] . "' ,AMBOTTOMP = '" . $R["AMBOTTOMP"] . "' ,AMBOTTOMBG = '" . $R["AMBOTTOMBG"] . "' ,AMBOTTOMH = '" . $R["AMBOTTOMH"] . "' ,AMWidth = '" . $R["AMWidth"] . "' ,AMUseHead = '" . $R["AMUseHead"] . "' ,AMHeadH = '" . $R["AMHeadH"] . "' ,AMUseDetail = '" . $R["AMUseDetail"] . "' ,AMDetailF = '" . $R["AMDetailF"] . "' ,AMDetailS = '" . $R["AMDetailS"] . "' ,AMDetailC = '" . $R["AMDetailC"] . "' ,AMDetailB = '" . $R["AMDetailB"] . "' ,AMDetailI = '" . $R["AMDetailI"] . "' ,AMDate = '" . $R["AMDate"] . "'  ,AMBulletBPW = '" . $R["AMBulletBPW"] . "',AMBulletBPH = '" . $R["AMBulletBPH"] . "',AMBulletSPW = '" . $R["AMBulletSPW"] . "',AMBulletSPH = '" . $R["AMBulletSPH"] . "',AMBodyBPW = '" . $R["AMBodyBPW"] . "',AMBodyBPH = '" . $R["AMBodyBPH"] . "',block_theme = '" . $R["block_theme"] . "' WHERE a_id = '" . $a_id . "' ");
			@copy("../ewt/" . $_SESSION["EWT_SUSER"] . "/article/DA_" . $_POST["aid"] . ".htm", "../ewt/" . $_SESSION["EWT_SUSER"] . "/article/DA_" . $a_id . ".htm");
		}
	}
	$sql_edit = $db->query("select block_name from block where BID ='" . $_POST["B"] . "'");
	$R = $db->db_fetch_array($sql_edit);
	$db->write_log("approve", "article", "อนุมัติ ข่าว/บทความ" . $R['block_name']);
?>
	<script>
		self.close();
	</script>
<?php
}

function Gen_RSS($cid)
{
	global $db, $EWT_DB_USER;
	$sql_url = $db->query("SELECT `url` FROM ".$EWT_DB_USER.".user_info WHERE UID = '" . $_SESSION["EWT_SUID"] . "' ");
	$U = $db->db_fetch_row($sql_url);
	$MyUrl = $U[0];
	$db->query("USE " . $_SESSION["EWT_SDB"]);
	$sql_url1 = $db->query("SELECT site_info_description,site_info_title  FROM site_info");
	$U1 = $db->db_fetch_row($sql_url1);
	$MyTitle = $U1[0];
	$MyCopy = $U1[1];
	$sql = "SELECT * FROM article_group WHERE c_id='$cid'  ";
	$query_rss = $db->query($sql);
	$rss2 = $db->db_fetch_array($query_rss);

	if ($rss2["c_rss"] == 'Y') {
		$xml_text = '<' . '?xml version="1.0" encoding="utf-8"?' . '>
					<rss version="2.0">
					<channel>
						<title>' . $rss2["c_name"] . '</title> 
						<link>' . $MyUrl . '</link> 
						<description>' . $MyTitle . '</description> 
						<language>th-TH</language> 
						<lastBuildDate>' . date('D,d M Y H:i:s e') . '</lastBuildDate> 
						<copyright>Copyright ? 2008 All rights reserved. ' . $MyUrl . '</copyright> 
					';

		$query_rss = $db->query("SELECT * FROM article_list WHERE c_id='$cid' and n_approve='y' ORDER BY n_date DESC, n_timestamp DESC");

		while ($rss = $db->db_fetch_array($query_rss)) {
			$N = array();
			$check_www   = (string)strpos($N['link_html'], "www");
			$check_http  = (string)strpos($N['link_html'], "http://");
			$check_https = (string)strpos($N['link_html'], "http://");

			if ($check_www == "0" && $check_http != "0" && $check_https != "0") {
				$linkURL = str_replace('&', "&amp;", "http://" . $rss["link_html"]);
			} else if ($check_http == "0" || $check_https == "0") {
				$linkURL = str_replace('&', "&amp;", $rss["link_html"]);
			} else {
				$aa = '&amp;';
				if ($rss["news_use"] == "2" || $rss["news_use"] == "3") {
					$linkURL = $MyUrl . "news_view.php?n_id=" . $rss["n_id"];
				} elseif ($rss["news_use"] == "4") {
					$linkURL = $MyUrl . "news_view.php?n_id=" . $rss["n_id"];
				} else {
					$linkURL = $MyUrl . str_replace('&', "&amp;", $rss["link_html"]);
				}
			}
			if ($rss["picture"] != "") {
				$rss_image = '<enclosure url="' . $MyUrl . 'images/article/news' . $rss["n_id"] . '/' . $rss["picture"] . '" />';
			} else {
				$rss_image = "";
			}
			$xml_text .= '<item>
					<title>' . $rss["n_topic"] . '</title>
					<link>' . $linkURL . '</link>
					' . $rss_image . '
					<description>' . $rss["n_des"] . '</description>
					<pubDate>' . $rss["n_timestamp"] . '</pubDate>
					<guid>' . $MyUrl . '</guid>
	            </item>
				';
		}
		$xml_text .= '</channel></rss>';
		$fp = fopen("../ewt/" . $_SESSION["EWT_SUSER"] . "/rss/group" . $cid . ".xml", "w");
		fputs($fp, $xml_text);
		fclose($fp);
	}
}

$db->db_close();

function TIS620toUTF8($string)
{
	if (!preg_match("[\241-\377]", $string))
		return $string;

	$iso8859_11 = array(
		"\x93" => "\xe2\x80\x9c",
		"\x94" => "\xe2\x80\x9d",
		"\xa1" => "\xe0\xb8\x81",
		"\xa2" => "\xe0\xb8\x82",
		"\xa3" => "\xe0\xb8\x83",
		"\xa4" => "\xe0\xb8\x84",
		"\xa5" => "\xe0\xb8\x85",
		"\xa6" => "\xe0\xb8\x86",
		"\xa7" => "\xe0\xb8\x87",
		"\xa8" => "\xe0\xb8\x88",
		"\xa9" => "\xe0\xb8\x89",
		"\xaa" => "\xe0\xb8\x8a",
		"\xab" => "\xe0\xb8\x8b",
		"\xac" => "\xe0\xb8\x8c",
		"\xad" => "\xe0\xb8\x8d",
		"\xae" => "\xe0\xb8\x8e",
		"\xaf" => "\xe0\xb8\x8f",
		"\xb0" => "\xe0\xb8\x90",
		"\xb1" => "\xe0\xb8\x91",
		"\xb2" => "\xe0\xb8\x92",
		"\xb3" => "\xe0\xb8\x93",
		"\xb4" => "\xe0\xb8\x94",
		"\xb5" => "\xe0\xb8\x95",
		"\xb6" => "\xe0\xb8\x96",
		"\xb7" => "\xe0\xb8\x97",
		"\xb8" => "\xe0\xb8\x98",
		"\xb9" => "\xe0\xb8\x99",
		"\xba" => "\xe0\xb8\x9a",
		"\xbb" => "\xe0\xb8\x9b",
		"\xbc" => "\xe0\xb8\x9c",
		"\xbd" => "\xe0\xb8\x9d",
		"\xbe" => "\xe0\xb8\x9e",
		"\xbf" => "\xe0\xb8\x9f",
		"\xc0" => "\xe0\xb8\xa0",
		"\xc1" => "\xe0\xb8\xa1",
		"\xc2" => "\xe0\xb8\xa2",
		"\xc3" => "\xe0\xb8\xa3",
		"\xc4" => "\xe0\xb8\xa4",
		"\xc5" => "\xe0\xb8\xa5",
		"\xc6" => "\xe0\xb8\xa6",
		"\xc7" => "\xe0\xb8\xa7",
		"\xc8" => "\xe0\xb8\xa8",
		"\xc9" => "\xe0\xb8\xa9",
		"\xca" => "\xe0\xb8\xaa",
		"\xcb" => "\xe0\xb8\xab",
		"\xcc" => "\xe0\xb8\xac",
		"\xcd" => "\xe0\xb8\xad",
		"\xce" => "\xe0\xb8\xae",
		"\xcf" => "\xe0\xb8\xaf",
		"\xd0" => "\xe0\xb8\xb0",
		"\xd1" => "\xe0\xb8\xb1",
		"\xd2" => "\xe0\xb8\xb2",
		"\xd3" => "\xe0\xb8\xb3",
		"\xd4" => "\xe0\xb8\xb4",
		"\xd5" => "\xe0\xb8\xb5",
		"\xd6" => "\xe0\xb8\xb6",
		"\xd7" => "\xe0\xb8\xb7",
		"\xd8" => "\xe0\xb8\xb8",
		"\xd9" => "\xe0\xb8\xb9",
		"\xda" => "\xe0\xb8\xba",
		"\xdf" => "\xe0\xb8\xbf",
		"\xe0" => "\xe0\xb9\x80",
		"\xe1" => "\xe0\xb9\x81",
		"\xe2" => "\xe0\xb9\x82",
		"\xe3" => "\xe0\xb9\x83",
		"\xe4" => "\xe0\xb9\x84",
		"\xe5" => "\xe0\xb9\x85",
		"\xe6" => "\xe0\xb9\x86",
		"\xe7" => "\xe0\xb9\x87",
		"\xe8" => "\xe0\xb9\x88",
		"\xe9" => "\xe0\xb9\x89",
		"\xea" => "\xe0\xb9\x8a",
		"\xeb" => "\xe0\xb9\x8b",
		"\xec" => "\xe0\xb9\x8c",
		"\xed" => "\xe0\xb9\x8d",
		"\xee" => "\xe0\xb9\x8e",
		"\xef" => "\xe0\xb9\x8f",
		"\xf0" => "\xe0\xb9\x90",
		"\xf1" => "\xe0\xb9\x91",
		"\xf2" => "\xe0\xb9\x92",
		"\xf3" => "\xe0\xb9\x93",
		"\xf4" => "\xe0\xb9\x94",
		"\xf5" => "\xe0\xb9\x95",
		"\xf6" => "\xe0\xb9\x96",
		"\xf7" => "\xe0\xb9\x97",
		"\xf8" => "\xe0\xb9\x98",
		"\xf9" => "\xe0\xb9\x99",
		"\xfa" => "\xe0\xb9\x9a",
		"\xfb" => "\xe0\xb9\x9b"
	);

	$string = strtr($string, $iso8859_11);
	return $string;
}

function getArticleSub($c_id)
{
	global $db;
	$wh = "";
	$s_cid = array();
	array_push($s_cid, $c_id);

	if ($c_id) {
		$wh .= " AND c_parent = '$c_id'";
	}

	$_sql_sub = "SELECT c_id FROM article_group WHERE c_show_document = 'Y' {$wh}";
	$a_data_sub = $db->db_fetch_array($_sql_sub);

	while ($a_data_sub = $db->db_fetch_array($_sql_sub)) {
		array_push($s_cid, getArticleSub($a_data_sub['c_id']));
	}

	return implode(",", array_unique($s_cid));
}
