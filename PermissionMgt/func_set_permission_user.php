<?php
include("../EWT_ADMIN/comtop_pop.php");

$db->query("USE " . $EWT_DB_USER);

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

if ($a_data['proc'] == 'Add') {
	for ($i = 0; $i < $_POST["alli"]; $i++) {
		$chk = $_POST["chk" . $i];
		$uid = $_POST["uid" . $i];
		if ($chk == "Y") {
			$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE ug_id = '" . $_POST["ug"] . "' AND ugm_type = 'U' AND ugm_tid = '" . $uid . "' ");
			$C = $db->db_fetch_row($sqlchk);
			if ($C[0] == 0) {
				$db->query("INSERT INTO web_group_member (ug_id,ugm_type,ugm_tid) VALUES ('" . $_POST["ug"] . "','U','" . $uid . "') ");
			}
			$s_uid  = $uid;
		}
	}

	echo json_encode($s_uid);
	unset($a_data);
	unset($s_data);
	exit;
}
