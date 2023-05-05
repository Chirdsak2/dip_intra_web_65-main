<?php 
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$article_subnew_array=array();
function find_sub_group($c_id){
    global $db,$article_subnew_array;
    $qg=$db->query("SELECT * FROM article_group WHERE c_parent='$c_id'");
    while($ar_sub=$db->db_fetch_array($qg)){
        array_push($article_subnew_array,$ar_sub['c_id']);
        find_sub_group($ar_sub['c_id']);
    }
}

find_sub_group(152);

print_r($article_subnew_array);
?>