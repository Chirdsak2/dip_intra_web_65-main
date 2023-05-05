<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

include("../ewt_menu_preview.php");

if($_GET["m_id"] != ""){
    $menu_text = GenMenu($_GET["m_id"]);
    if($_GET["flag"]=='del'){
    $db->query("update block set block_link = '' where block_type = 'menu' AND block_link = '".$_GET["m_id"]."'");
    $db->query("delete from menu_list where m_id = '".$_GET["m_id"]."'");
    $db->query("delete from menu_properties where m_id = '".$_GET["m_id"]."'");
    }else{
    $db->query("UPDATE block SET block_html = '".addslashes($menu_text)."' WHERE block_type = 'menu' AND block_link = '".$_GET["m_id"]."' ");
    }
    ?>
    <script language="javascript">
    location.href= "menu_list.php";	
    </script>
    <?php
}

$db->db_close(); ?>
