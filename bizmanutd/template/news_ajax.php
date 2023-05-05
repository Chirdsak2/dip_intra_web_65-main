<?php
session_start();
header ("Content-Type:text/html;charset=UTF-8");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_article_preview.php");
echo GenArticle($_GET["bid"],'');
$db->db_close(); ?>
