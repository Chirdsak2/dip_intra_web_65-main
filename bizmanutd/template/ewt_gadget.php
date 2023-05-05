<?php
session_start();
header ("Content-Type:text/html;Charset=UTF-8");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$sql_text = $db->query("SELECT * FROM block_text WHERE text_id = '".$_GET["B"]."'");
$T = $db->db_fetch_array($sql_text);

$xmlBase = iconv( 'UTF-8' ,'UTF-8', $T["text_html"]);
function is_atom($feedxml) { 
    @$feed = new SimpleXMLElement($feedxml); 
        return $feed->Content; 
} 
echo is_atom($xmlBase);
$db->db_close(); ?>
