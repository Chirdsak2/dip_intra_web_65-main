<?php
include("../EWT_ADMIN/comtop_pop.php");
$db->query("USE " . $EWT_DB_USER);

//$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);

if ($a_data['proc'] == 'DelPermisOrg') {

	del('web_group_member', "ugm_tid='{$a_data['id']}' AND ug_id='{$_SESSION['EWT_SUID']}' AND ugm_type='D'");
	del('permission', "pu_id='{$a_data['id']}'AND UID='{$_SESSION['EWT_SUID']}'AND p_type='D'");

	echo json_encode($s_data);
	unset($a_data);
	unset($s_data);

	exit;
}
