<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$db->query("USE " . $EWT_DB_USER);

$name_explode = explode(" ", $_POST["search"]);
$name_thai = $name_explode[0];
$surname_thai = $name_explode[1];

$wh = "";

if (empty($surname_thai)) {
	//$wh .= " AND gen_user.name_thai LIKE '%" . trim($_POST["search"]) . "%' ";
	//$wh .= " OR gen_user.surname_thai LIKE '%" . trim($_POST["search"]) . "%' ";
	$wh .= " AND USR_FNAME LIKE '%" . trim($_POST["search"]) . "%' ";
	$wh .= " OR USR_LNAME LIKE '%" . trim($_POST["search"]) . "%' ";
} else {
	//$wh .= " AND gen_user.name_thai LIKE '%" . trim($name_thai) . "%' ";
	//$wh .= " OR gen_user.surname_thai LIKE '%" . trim($surname_thai) . "%' ";
	$wh .= " AND USR_FNAME LIKE '%" . trim($name_thai) . "%' ";
	$wh .= " OR USR_LNAME LIKE '%" . trim($surname_thai) . "%' ";
}

// $_sql_search = $db->query("SELECT * FROM gen_user 
// 		INNER JOIN org_name ON org_name.org_id = gen_user.org_id 
// 		WHERE status ='1' {$wh}
// 		ORDER BY gen_user.gen_user_id DESC LIMIT 0,5");
$_sql_search = "SELECT * FROM USR_MAIN WHERE USR_ID != 1
AND USR_MOVEMENT != 'ลาออก'
AND USR_MOVEMENT != 'ไล่ออก'
AND USR_MOVEMENT != 'เกษียณอายุ'
AND USR_MOVEMENT != 'ถึงแก่กรรม'
{$wh} ORDER BY USR_ID DESC
OFFSET 0 ROWS FETCH NEXT 5 ROWS ONLY";
$user = $sso->getFetchAll($_sql_search);
// while ($val = $db->db_fetch_array($_sql_search)) {
foreach ($user as $val) {
	$user_file = "../ewt/prd_intra_web/profile/" . $val["USR_PICTURE"];
	$user_img = (empty($val["USR_PICTURE"]) ? "../EWT_ADMIN/images/user001.png" : $user_file);

	$sql = $db->query("SELECT gen_user_id FROM gen_user WHERE gen_user = '{$val['USR_USERNAME']}' LIMIT 1;");
	$u_data = $db->db_fetch_array($sql);

	$first_name = ltrim($val['USR_FNAME']);
	$last_name = trim($val['USR_LNAME']);
	$full_name = $first_name . ' ' . $last_name;
	$gen_user_id = trim($u_data["gen_user_id"]);
	$function = 'JQSet_Cal_User(' . "'$gen_user_id'" . ', ' . "'$full_name'" . ');';

	$output .= '<tr>';
	$output .= '<td>';
	$output .= '<img src="' . $IMG_PATH . 'images/grabme.svg">';
	$output .= '<a class="pointer" onClick="' . $function . '">';
	$output .= '<img src="' . $user_img . '" alt="" class="img-circle img-rounded " style="width:24px;height:24px;">';
	$output .= '&nbsp;'.$val['USR_FNAME'] . ' ' . $val['USR_LNAME'];
	$output .= '</a>';
	$output .= '</td>';
	$output .= '</tr>';
}

echo $output;
