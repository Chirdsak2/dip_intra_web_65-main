<?php 
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

$v_id = $_POST['v_id'];
$eng_chat = $sso->getChitChat($v_id)["data"];
$sound1 = $sso->getSound($eng_chat["VOCAB_ID"], 'VOCAB_FILE1')["data"]["FILE_SAVE_NAME"];
$sound2 = $sso->getSound($eng_chat["VOCAB_ID"], 'VOCAB_FILE2')["data"]["FILE_SAVE_NAME"];

$text = '';
$text .= "<tr>";
$text .= "<td>".$eng_chat['VOCAB_TITLE1']."</td>";
$text .= "<td>".$eng_chat['VOCAB_READ1']."</td>";
$text .= "<td>".$eng_chat['VOCAB_EXPL1']."</td>";
$text .= "<td> <audio id=\"player1\" src=\"".HOST_SSO . 'attach/w17/' . $sound1."\"></audio>";
$text .= "<a onclick=\"document.getElementById('player1').play();\" style=\"cursor: pointer;\">";
$text .= "<img src=\"assets/img/icon/volume-down-solid.svg\" class=\"icon-sound\">";
$text .= "</a>";
$text .= "</td>";
$text .= "<td>".$eng_chat['VOCAB_TITLE2']."</td>";
$text .= "<td>".$eng_chat['VOCAB_EXPL2']."</td>";
$text .= "<td>";
$text .= "<audio id=\"player2\" src=\"".HOST_SSO . 'attach/w17/' . $sound2."\"></audio>";
$text .= "<a onclick=\"document.getElementById('player2').play();\" style=\"cursor: pointer;\">";
$text .= "<img src=\"assets/img/icon/volume-down-solid.svg\" class=\"icon-sound\">";
$text .= "</a>";
$text .= "</td>";
$text .= "</tr>";

$array_list = array();
if($eng_chat){
    $array_list["status"] = "success";
    $array_list["output"] = $text;
}else{
    $array_list["status"] = "error";
    $array_list["output"] = null;
}
echo json_encode($array_list);
exit;
