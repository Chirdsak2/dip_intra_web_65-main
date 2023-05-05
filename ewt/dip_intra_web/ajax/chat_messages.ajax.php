<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

$Flag = conText($_POST["Flag"]);
$chat_id = conText($_POST["chat_id"]);
$chat_from_id = conText($_POST["chat_from_id"]);
$chat_to_id = conText($_POST["chat_to_id"]);
$chat_from_fullname = conText($_POST["chat_from_fullname"]);
$chat_message = conText($_POST["chat_message"]);

$messages = '';
switch ($Flag) {
    case 'refresh_messages':
        if ($chat_id == $_SESSION['EWT_MID']) {
            $chat_form = array();
        } else {
            $chat_form = chat::getChatLog(array("chat_from_id" => $chat_id, "chat_to_id" => $_SESSION['EWT_MID']))["dataAll"];
        }
        $chat_to = chat::getChatLog(array("chat_from_id" => $_SESSION['EWT_MID'], "chat_to_id" => $chat_id))["dataAll"];
        $chat_user = array_merge(!empty($chat_form) ? $chat_form : array(), !empty($chat_to) ? $chat_to : array());
        sort($chat_user);
        foreach ($chat_user as $key => $value) {
            $user_sso = $sso->getUser($value["chat_from_username"])["data"];
            $user_image = !empty($user_sso["USR_PICTURE"]) ? "profile/" . $user_sso["USR_PICTURE"] : "images/user_profile_empty.png";
            if ($value["chat_from_id"] == $_SESSION['EWT_MID']) {
                $messages .= '<div class="media w-50 ml-auto mb-3">';
                $messages .= '<div class="media-body">';
                $messages .= '<div class="bg-primary rounded py-2 px-3 mb-2">';
                $messages .= '<p class="h5 mb-0 text-white">' . $value["chat_message"] . '</p>';
                $messages .= '</div>';
                $messages .= '<p class="small text-muted">' . convDateThai($value["chat_date"])["DateChat"] . '</p>';
                $messages .= '</div>';
                $messages .= '</div>';
            } else {
                $messages .= '<div class="media w-50 mb-3">';
                $messages .= '<img src="' . $user_image . '" alt="' . $user_sso["USR_PICTURE"] . '" width="50" class="rounded-circle">';
                $messages .= '<div class="media-body ml-3">';
                $messages .= '<div class="bg-light rounded py-2 px-3 mb-2">';
                $messages .= '<p class="h5 mb-0">' . $value["chat_message"] . '</p>';
                $messages .= '</div>';
                $messages .= '<p class="small text-muted">' . convDateThai($value["chat_date"])["DateChat"] . '</p>';
                $messages .= '</div>';
                $messages .= '</div>';
            }
        }
        break;
    case 'chat_messages':
        $user = user::chkUser(array("gen_user_id" => $chat_id))[0];
        $array_insert["chat_from_id"] = $_SESSION['EWT_MID'];
        $array_insert["chat_from_username"] = $_SESSION['EWT_USERNAME'];
        $array_insert["chat_to_id"] = $chat_id;
        $array_insert["chat_to_username"] = $user["gen_user"];
        $array_insert["chat_message"] = $chat_message;
        if (db::insert("".E_DB_NAME.".chat_log", $array_insert)) {
            $message = "บันทึกเรียบร้อย";
            if ($chat_id == $_SESSION['EWT_MID']) {
                $chat_form = array();
            } else {
                $chat_form = chat::getChatLog(array("chat_from_id" => $chat_id, "chat_to_id" => $_SESSION['EWT_MID']))["dataAll"];
            }
            $chat_to = chat::getChatLog(array("chat_from_id" => $_SESSION['EWT_MID'], "chat_to_id" => $chat_id))["dataAll"];
            $chat_user = array_merge(!empty($chat_form) ? $chat_form : array(), !empty($chat_to) ? $chat_to : array());
            sort($chat_user);
            foreach ($chat_user as $key => $value) {
                $user_sso = $sso->getUser($value["chat_from_username"])["data"];
                $user_image = !empty($user_sso["USR_PICTURE"]) ? "profile/" . $user_sso["USR_PICTURE"] : "images/user_profile_empty.png";
                if ($value["chat_from_id"] == $_SESSION['EWT_MID']) {
                    $messages .= '<div class="media w-50 ml-auto mb-3">';
                    $messages .= '<div class="media-body">';
                    $messages .= '<div class="bg-primary rounded py-2 px-3 mb-2">';
                    $messages .= '<p class="h5 mb-0 text-white">' . $value["chat_message"] . '</p>';
                    $messages .= '</div>';
                    $messages .= '<p class="small text-muted">' . convDateThai($value["chat_date"])["DateChat"] . '</p>';
                    $messages .= '</div>';
                    $messages .= '</div>';
                } else {
                    $messages .= '<div class="media w-50 mb-3">';
                    $messages .= '<img src="' . $user_image . '" alt="' . $user_sso["USR_PICTURE"] . '" width="50" class="rounded-circle">';
                    $messages .= '<div class="media-body ml-3">';
                    $messages .= '<div class="bg-light rounded py-2 px-3 mb-2">';
                    $messages .= '<p class="h5 mb-0">' . $value["chat_message"] . '</p>';
                    $messages .= '</div>';
                    $messages .= '<p class="small text-muted">' . convDateThai($value["chat_date"])["DateChat"] . '</p>';
                    $messages .= '</div>';
                    $messages .= '</div>';
                }
            }
        }
        break;
}
$array_list = array(
    "messages" => $messages,
    "message" => $message
);
echo json_encode($array_list);
exit();
