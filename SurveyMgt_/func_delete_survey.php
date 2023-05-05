<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");


if($_POST['proc'] == 'DelSurvey' ){
	
$id = $_POST['id'];

$s_survey = $db->query("SELECT * FROM `p_survey` WHERE `s_id` ='{$id}' ");
$a_row = $db->db_num_rows($s_survey);

$a_survey = $db->db_fetch_array($s_survey);


$s_update = "UPDATE `p_survey` SET  `s_approve`  = '' WHERE s_id = '{$id}' ";
$db->query($s_update);		
	
//$s_delete = "DELETE FROM article_video WHERE av_id = '{$_GET[id]}'";						
//$db->query($s_delete);
}

$db->db_close(); 	
?>