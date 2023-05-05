<?php
session_start();
header ("Content-Type:text/html;Charset=UTF-8");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
require_once("rsslib.php");
$BID=$_GET[BID];

$query=$db->query("SELECT  *  FROM  rss WHERE rss_id = '$rss_id' "); 
$data = $db->db_fetch_array($query);

echo RSS_Links($data[rss_url], $data[rss_row]);
$db->db_close(); ?>
