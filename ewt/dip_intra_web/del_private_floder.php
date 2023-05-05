<?php
DEFINE('path', 'assets/');
include path . '/config/config.inc.php';

    $fav_id = $_GET['fav_id'];

    $del = db::execute("DELETE FROM " . E_DB_NAME . ".article_favorite_log WHERE fav_id = {$fav_id}");
        echo '<script> alert("ลบรายการโปรดสำเร็จ");</script>';
        header('Refresh:0; url=private_floder.php');
   

?>