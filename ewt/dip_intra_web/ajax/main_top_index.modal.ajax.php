<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

//----------------------------------Get Model------------------------------------//
$id = conText($_POST["id"]); 
$gen_user_id = conText($_POST["gen_user_id"]);
//----------------------------------Insert Data----------------------------------//
$ech_ecardid = conText($_POST["ech_ecardid"]); //รหัสการ์ดวันเกิด
$ech_cid = conText($_POST["ech_cid"]); //รหัสคำอวยพร
$ech_from_userid = $_SESSION['EWT_MID']; //รหัส user ส่งการ์ดวันเกิด
$ech_gen_userid = conText($_POST["ech_gen_userid"]); //รหัส user รับการ์ดวันเกิด

if (!empty($id)) {
    //----------------------------------Get Model------------------------------------//
    $user_sso = $sso->getUser(null, $id)["data"];
    $user_ewt = user::chkUser(array("gen_user_id" => $gen_user_id));
    $user_image = getImgbase64("../profile/". $user_sso["USR_PICTURE"], "images/user_profile_empty.png");
    $full_name = $user_sso['USR_FNAME'] . ' ' . $user_sso['USR_LNAME'];
    $user_sso_org = $sso->getDepartment($user_sso["DEP_ID"])["data"]; 
    $user_sso_pos = $sso->getPosition($user_sso["POS_ID"])["data"]; 

    $output = '';
    // $output .= '<img src="' . $user_image . '" title="' . $full_name . '" alt="' . $full_name . '" class="mx-3 border-ra-10px pic-card-wish">';
    // $output .= '<div class="media-body font12px text-left">';
    // $output .= '<div class="txt-color-purple font20px font-weight-bold"> วันนี้วันเกิด </div>';
    // $output .= '<div class="txt-color-purple font30px font-weight-bold"> คุณ' . $full_name . ' </div>';
    // $output .= '<div class="txt-color-purple font20px font-weight-bold"> ' . convDateThai($user_sso['USR_BIRTH_DATE'])['DateDayThaiShort'] . ' </div>';
    // $output .= '<input type="hidden" name="ech_to" id="ech_to" value="' . $full_name . '">';
    // $output .= '<input type="hidden" name="ech_gen_userid" id="ech_gen_userid" value="' . $user_ewt[0]['gen_user_id'] . '">';
    // $output .= '</div>';

    $output .= '<img src="' . $user_image . '" class="mx-3 border-ra-10px pic-card-wish" title="' . $full_name . '" alt="' . $full_name . '">';
    $output .= '<div class="media-body font12px text-left">';
    $output .= '<div class="txt-color-purple font20px font-weight-bold"> วันนี้วันเกิด </div>';
    $output .= '<div class="txt-color-purple font30px font-weight-bold"> ' . $full_name . ' </div>';
    $output .= '<div class="font13px txt-purple-t3"> <i class="far fa-user font11px"></i> '.$user_sso_pos["POS_NAME"].' </div>';
    $output .= '<div class="font13px txt-purple-t3"> <i class="far fa-folder-open font11px"></i> '.$user_sso_org["DEP_NAME"].' </div>';
    $output .= '<div class="txt-color-purple font20px font-weight-bold"> '.convDateThai(date("Y-m-d"))["DateThaiShot"].' </div>';
    $output .= '<input type="hidden" name="ech_to" id="ech_to" value="' . $full_name . '">';
    $output .= '<input type="hidden" name="ech_gen_userid" id="ech_gen_userid" value="' . $user_ewt[0]['gen_user_id'] . '">';
    $output .= '</div>';
    $status = "getModel";
} else {
    //----------------------------------Insert Data----------------------------------//
    $array_insert = array(
        'ech_ecardid' => $ech_ecardid,
        'ech_cid' => $ech_cid,
        'ech_from_userid' => $ech_from_userid,
        'ech_gen_userid' => $ech_gen_userid,
        'ech_ip' => getIP(),
        'ech_status' => "N",
        'ech_datetime' => date('Y-m-d H:i'),
    );

    if (db::insert('ecard_history', $array_insert) == true) {
        //ได้รับคะแนนส่งการ์ดวันเกิด
        km::postPoint(1, $ech_gen_userid, "ecard");
        $status = "success";
    } else {
        $status = "error";
    }
}

$array_list = array(
    "status" => $status,
    "output" => $output,
);

echo json_encode($array_list);
exit();