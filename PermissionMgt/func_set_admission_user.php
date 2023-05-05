<?php
// include("../EWT_ADMIN/comtop_pop.php");

// $db->query("USE " . $EWT_DB_USER);

// $date = new DateTime();

// $a_data = array_merge($_POST, $_FILES);

// if ($a_data['proc'] == 'Add_Admission_Article') {
// 	if ($a_data['p_code'] == 'art') {
// 		if ($a_data['s_permission'] == 'w') {
// 			del('permission', "pu_id='" . $a_data['pu_id'] . "' AND UID='" . $a_data['UID'] . "' AND s_type='" . $a_data['code'] . "' AND s_permission='" . $a_data['s_permission'] . "'  ");

// 			if ($a_data['chk'] == '0') {
// 				$s_data['p_type']  		 = $a_data['p_type'];
// 				$s_data['pu_id']  		 = $a_data['pu_id'];
// 				$s_data['UID']  		 = $a_data['UID'];
// 				$s_data['s_type']  		 = $a_data['code'];
// 				$s_data['s_id']  		 = '0';
// 				$s_data['s_name']  		 = '';
// 				$s_data['s_permission']  = $a_data['s_permission'];

// 				insert('permission', $s_data);
// 			} else {
// 				if ($a_data['c_cate']) {
// 					foreach ($a_data['c_cate'] as $_item) {

// 						$s_data['p_type']  		 = $a_data['p_type'];
// 						$s_data['pu_id']  		 = $a_data['pu_id'];
// 						$s_data['UID']  		 = $a_data['UID'];
// 						$s_data['s_type']  		 = $a_data['code'];
// 						$s_data['s_id']  		 = $_item;
// 						$s_data['s_name']  		 = '';
// 						$s_data['s_permission']  = $a_data['s_permission'];

// 						insert('permission', $s_data);
// 					}
// 				}
// 			}
// 		}
// 		if ($a_data['s_permission'] == 'a') {
// 			del('permission', "pu_id='" . $a_data['pu_id'] . "' AND UID='" . $a_data['UID'] . "' AND s_type='" . $a_data['code'] . "' AND s_permission='" . $a_data['s_permission'] . "'  ");

// 			if ($a_data['chk'] == '0') {
// 				$s_data['p_type']  		 = $a_data['p_type'];
// 				$s_data['pu_id']  		 = $a_data['pu_id'];
// 				$s_data['UID']  		 = $a_data['UID'];
// 				$s_data['s_type']  		 = $a_data['code'];
// 				$s_data['s_id']  		 = '0';
// 				$s_data['s_name']  		 = '';
// 				$s_data['s_permission']  = $a_data['s_permission'];

// 				insert('permission', $s_data);
// 			} else {
// 				if ($a_data['c_cate']) {
// 					foreach ($a_data['c_cate'] as $_item) {

// 						$s_data['p_type']  		 = $a_data['p_type'];
// 						$s_data['pu_id']  		 = $a_data['pu_id'];
// 						$s_data['UID']  		 = $a_data['UID'];
// 						$s_data['s_type']  		 = $a_data['code'];
// 						$s_data['s_id']  		 = $_item;
// 						$s_data['s_name']  		 = '';
// 						$s_data['s_permission']  = $a_data['s_permission'];

// 						insert('permission', $s_data);
// 					}
// 				}
// 			}
// 		}
// 	}

// 	if ($a_data['p_code'] == 'img') {
// 		if ($a_data['s_permission'] == 'w') {
// 			del('permission', "pu_id='" . $a_data['pu_id'] . "' AND UID='" . $a_data['UID'] . "' AND s_type='" . $a_data['code'] . "' AND s_permission='" . $a_data['s_permission'] . "'  ");
// 			if ($a_data['chk']) {
// 				$s_data['p_type']  		 = $a_data['p_type'];
// 				$s_data['pu_id']  		 = $a_data['pu_id'];
// 				$s_data['UID']  		 = $a_data['UID'];
// 				$s_data['s_type']  		 = $a_data['code'];
// 				$s_data['s_id']  		 = '0';
// 				$s_data['s_name']  		 = '';
// 				$s_data['s_permission']  = $a_data['s_permission'];

// 				insert('permission', $s_data);
// 			} else {
// 				if ($a_data['c_cate']) {
// 					foreach ($a_data['c_cate'] as $_item) {

// 						$s_data['p_type']  		 = $a_data['p_type'];
// 						$s_data['pu_id']  		 = $a_data['pu_id'];
// 						$s_data['UID']  		 = $a_data['UID'];
// 						$s_data['s_type']  		 = $a_data['code'];
// 						$s_data['s_id']  		 = '';
// 						$s_data['s_name']  		 = $_item;
// 						$s_data['s_permission']  = $a_data['s_permission'];

// 						insert('permission', $s_data);
// 					}
// 				}
// 			}
// 		}
// 	}

// 	if ($a_data['p_code'] == 'dl') {
// 		if ($a_data['s_permission'] == 'w') {
// 			del('permission', "pu_id='" . $a_data['pu_id'] . "' AND UID='" . $a_data['UID'] . "' AND s_type='" . $a_data['code'] . "' AND s_permission='" . $a_data['s_permission'] . "'  ");
// 			if ($a_data['chk']) {
// 				$s_data['p_type']  		 = $a_data['p_type'];
// 				$s_data['pu_id']  		 = $a_data['pu_id'];
// 				$s_data['UID']  		 = $a_data['UID'];
// 				$s_data['s_type']  		 = $a_data['code'];
// 				$s_data['s_id']  		 = '0';
// 				$s_data['s_name']  		 = '';
// 				$s_data['s_permission']  = $a_data['s_permission'];

// 				insert('permission', $s_data);
// 			} else {
// 				if ($a_data['c_cate']) {
// 					foreach ($a_data['c_cate'] as $_item) {

// 						$s_data['p_type']  		 = $a_data['p_type'];
// 						$s_data['pu_id']  		 = $a_data['pu_id'];
// 						$s_data['UID']  		 = $a_data['UID'];
// 						$s_data['s_type']  		 = $a_data['code'];
// 						$s_data['s_id']  		 = '';
// 						$s_data['s_name']  		 = $_item;
// 						$s_data['s_permission']  = $a_data['s_permission'];

// 						insert('permission', $s_data);
// 					}
// 				}
// 			}
// 		}
// 	}
// 	/*$sql_supadmin = $db->query_db("SELECT p_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' AND ((s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '0' ) OR (s_type = 'suser'  )) ",$EWT_DB_USER);

// 	$s_data = array();
// 	$_sql = $db->query("SELECT *
// 						FROM permission 
// 						WHERE 
// 						pu_id = '{$a_data['mid']}' 
// 						AND p_type = '{$a_data['mtype']}'  
// 						AND UID = '{$a_data['UID']}'
// 						AND s_type = 'suser'
// 						");
// 	$a_rows = $db->db_num_rows($_sql);	
// 	$a_data_permission = $db->db_fetch_array($_sql);
// 	//$a_data['page_id_array'];
// 	for($i=0; $i < count($a_data['page_id_array_form']); $i++){
			
// 	$c = explode("#",$a_data['page_id_array_form'][$i]);

// 	if(!empty($c[0])){
// 	if($c[0] != 'suser'){
// 		if($a_rows){
// 			del('permission','p_id='.$a_data_permission['p_id']);
// 		}
// 	}else{
		
// 		del('permission',"pu_id='".$a_data['mid']."' AND UID='".$a_data['UID']."' AND p_type='".$a_data['mtype']."' ");
// 	}
		
// 	$s_data['p_type']  		 = $a_data['mtype'];	
// 	$s_data['pu_id']  		 = $a_data['mid'];
// 	$s_data['UID']  		 = $a_data['UID'];
// 	$s_data['s_type']  		 = $c[0];
// 	$s_data['s_id']  		 = '0';
// 	$s_data['s_name']  		 = '';
// 	$s_data['s_permission']  = $c[1];
// 	//$s_data['com_ele_id']  = $a_data['page_id_array_form'][$i];
// 	//$s_data['com_ele_order']  = $i+1;
		
// 	//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));

// 	insert('permission',$s_data);	

// 	}
// 	}*/
// 		/*for($i=0;$i<$_POST["alli"];$i++){
// 			$chk = $_POST["chk".$i];
// 			$uid = $_POST["uid".$i];
// 			if($chk == "Y"){
// 			$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$uid."' ");
// 			$C = $db->db_fetch_row($sqlchk);
// 					if($C[0] == 0){
// 							$db->query("INSERT INTO web_group_member (ug_id,ugm_type,ugm_tid) VALUES ('".$_POST["ug"]."','U','".$uid."') ");
// 					}
// 			//}else{
// 					//$sqlchk = $db->query("DELETE FROM web_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$uid."' ");
// 					//$sqlchk = $db->query("DELETE FROM permission WHERE UID = '".$_POST["ug"]."' AND p_type = 'U' AND pu_id = '".$uid."' ");
// 			//}
// 		}
// 	}*/
// 	//del('m_complain_form_element','com_ele_fid='.$a_data['com_fid']);	

// 	//$s_data = array();

// 	//$a_data['page_id_array'];
// 	//for($i=0; $i<count($a_data['page_id_array_form']); $i++){

// 	//$s_data['com_ele_fid']  = $a_data['com_fid'];
// 	//$s_data['com_ele_id']  = $a_data['page_id_array_form'][$i];
// 	//$s_data['com_ele_order']  = $i+1;

// 	//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));

// 	//insert('m_complain_form_element',$s_data);	
// 	//}

// 	//print_r($s_data);	
// }elseif($a_data['proc'] == 'Add_Admission_Webboard'){
// 	if ($a_data['p_code'] == 'webboard') {
// 		if ($a_data['s_permission'] == 'w') {
// 			del('permission', "pu_id='" . $a_data['pu_id'] . "' AND UID='" . $a_data['UID'] . "' AND s_type='" . $a_data['code'] . "' AND s_permission='" . $a_data['s_permission'] . "'  ");
// 			if ($a_data['chk'] == '0') {
// 				$s_data['p_type']  		 = $a_data['p_type'];
// 				$s_data['pu_id']  		 = $a_data['pu_id'];
// 				$s_data['UID']  		 = $a_data['UID'];
// 				$s_data['s_type']  		 = $a_data['code'];
// 				$s_data['s_id']  		 = '0';
// 				$s_data['s_name']  		 = '';
// 				$s_data['s_permission']  = $a_data['s_permission'];
// 				insert('permission', $s_data);
// 			} else {
// 				if ($a_data['c_cate']) {
// 					foreach ($a_data['c_cate'] as $_item) {
// 						$s_data['p_type']  		 = $a_data['p_type'];
// 						$s_data['pu_id']  		 = $a_data['pu_id'];
// 						$s_data['UID']  		 = $a_data['UID'];
// 						$s_data['s_type']  		 = $a_data['code'];
// 						$s_data['s_id']  		 = $_item;
// 						$s_data['s_name']  		 = '';
// 						$s_data['s_permission']  = $a_data['s_permission'];
// 						insert('permission', $s_data);
// 					}
// 				}
// 			}
// 		}
		
// 		if ($a_data['s_permission'] == 'a') {
// 			del('permission', "pu_id='" . $a_data['pu_id'] . "' AND UID='" . $a_data['UID'] . "' AND s_type='" . $a_data['code'] . "' AND s_permission='" . $a_data['s_permission'] . "'  ");
// 			if ($a_data['chk'] == '0') {
// 				$s_data['p_type']  		 = $a_data['p_type'];
// 				$s_data['pu_id']  		 = $a_data['pu_id'];
// 				$s_data['UID']  		 = $a_data['UID'];
// 				$s_data['s_type']  		 = $a_data['code'];
// 				$s_data['s_id']  		 = '0';
// 				$s_data['s_name']  		 = '';
// 				$s_data['s_permission']  = $a_data['s_permission'];
// 				insert('permission', $s_data);
// 			} else {
// 				if ($a_data['c_cate']) {
// 					foreach ($a_data['c_cate'] as $_item) {
// 						$s_data['p_type']  		 = $a_data['p_type'];
// 						$s_data['pu_id']  		 = $a_data['pu_id'];
// 						$s_data['UID']  		 = $a_data['UID'];
// 						$s_data['s_type']  		 = $a_data['code'];
// 						$s_data['s_id']  		 = $_item;
// 						$s_data['s_name']  		 = '';
// 						$s_data['s_permission']  = $a_data['s_permission'];
// 						insert('permission', $s_data);
// 					}
// 				}
// 			}
// 		}
// 	}
// }

// echo json_encode($a_data);
// unset($a_data);
// unset($s_data);

// exit;

include("../EWT_ADMIN/comtop_pop.php");

$db->query("USE " . $EWT_DB_USER);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

