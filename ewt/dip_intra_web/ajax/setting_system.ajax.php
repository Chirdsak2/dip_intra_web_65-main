<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
$systems_id = conText($_POST["systems_id"]);
$org = conText($_POST["org"]);
$type = conText($_POST["type"]);
$list = conText($_POST["list"]);
$ENABLE = conText($_POST["ENABLE"]);
$SYSTEMNAME_LIST = conText($_POST["SYSTEMNAME_LIST"]);
$ORG_NAME = conText($_POST["ORG_NAME"]);
$page_id_array = $_POST["page_id_array"];
$w_status = $_POST["W_STATUS"];
$w_status_unchecked = explode(",",$_POST["w_status_unchecked"]);

$user = $sso->getUser($_SESSION['EWT_USERNAME'])["data"];
$sys = $sso->getSystem($systems_id);
$file = $sso->getFile($sys["data"]["SYSTEMS_ID"]);
$sso_org = $sso->getDepartment($org)["data"];

$output1 = '';
$output2 = '';

switch ($type) {
    case 'getModal':
        $output1 .= 'ท่านต้องการร้องของการใช้สิทธิ์ระบบ <br>';
        $output1 .= '<img src="' . HOST_SSO . 'attach/w3/' . $file["data"]["FILE_SAVE_NAME"] . '" title="' . $sys["data"]["SYSTEMS_NAME"] . '" alt="' . $sys["data"]["SYSTEMS_NAME"] . '">';
        $output1 .= '<span class="txt-color-system">';
        $output1 .= $sys["data"]["SYSTEMS_NAME"];
        $output1 .= '</span>';
        $output1 .= '<input type="hidden" name="SYSTEMNAME_LIST" id="SYSTEMNAME_LIST" value="' . $systems_id . '">';
        $output1 .= '<input type="hidden" name="ORG_NAME" id="ORG_NAME" value="' . $org . '">';

        $output2 .= '<img src="' . HOST_SSO . 'attach/w3/' . $file["data"]["FILE_SAVE_NAME"] . '" title="' . $sys["data"]["SYSTEMS_NAME"] . '" alt="' . $sys["data"]["SYSTEMS_NAME"] . '">';
        $output2 .= '<span class="txt-color-system">';
        $output2 .= $sys["data"]["SYSTEMS_NAME"];
        $output2 .= '</span>';
        $output2 .= '<br>';
        $output2 .= 'โปรดรอการให้สิทธิ์จากแอดมิน';
        $array_list["output1"] = $output1;
        $array_list["output2"] = $output2;
        $array_list["status"] = "success";
        break;
    case 'orderBySys':
        $s_data = array();
        for ($i = 0; $i < count($page_id_array); $i++) {
            $s_data['W_POS']  = $i + 1;
            $sso->update('WF_CHECKBOX', $s_data, array('CHECKBOX_ID' => $page_id_array[$i]));
        }
        $array_list["status"] = "success";
        break;
    case 'sysForm':
        $data_sso["WFR_ID"] = $sso->maxId('WFR_PERMISSION', 'WFR_ID');
        $data_sso["WFR_TIMESTAMP"] = date('Y-m-d');
        $data_sso["WFR_UID"] = 1;
        $data_sso["SYSTEMNAME_LIST"] = $SYSTEMNAME_LIST;
        $data_sso["NAME"] = $user["USR_FNAME"] . ' ' . $user["USR_LNAME"];
        $data_sso["ORG_NAME"] = $ORG_NAME;
        $data_sso["PERMISSION_UNAME"] = $_SESSION['EWT_USERNAME'];
        $check_personal = $sso->checkPermission($data_sso["SYSTEMNAME_LIST"], $data_sso["NAME"]);
        if ($check_personal == false) {
            $sso->insert('WFR_PERMISSION', $data_sso);
        }
        $array_list["type_text"] = "โปรดรอการให้สิทธิ์จากแอดมิน";
        $array_list["status"] = "success";
        break;
    // case 'chkboxForm':
    //     for ($i = 0; $i < count($w_status); $i++) {
    //         $sso->update('WF_CHECKBOX', array("W_STATUS" => "Y"), array('CHECKBOX_ID' => $w_status[$i]));
    //     }

    //     for ($i = 0; $i < count($w_status_unchecked); $i++) {
    //         $sso->update('WF_CHECKBOX', array("W_STATUS" => "N"), array('CHECKBOX_ID' => $w_status_unchecked[$i]));
    //     }

    //     $array_list["type_text"] = "บันทึกข้อมูลเรียบร้อย";
    //     $array_list["status"] = "success";
    //     break;
}

$array_list["type"] = $type;
$array_list["list"] = $list;

echo json_encode($array_list);
exit();
