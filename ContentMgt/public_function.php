<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("../ewt_menu_preview.php");
include("../ewt_article_preview.php");
include("../ewt_public_function.php");

if($_POST["Flag"] == "ChoosePublic" AND $_POST["filename"] != ""){
genpublic($_POST["filename"],"../",$_SESSION["EWT_SUSER"]);
}

$db->db_close(); ?>
