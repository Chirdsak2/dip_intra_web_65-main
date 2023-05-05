<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

//==================================================
if($language){ $language = checkPttVar($language); }
//==================================================

$p = strpos( $page,'filename');
$pn= strpos( $page,'main.php');
if($filename == '' || $p === false){
$filename = 'index';
$page = $page.'&filename='.$filename;
}else{
$filename = $filename;
$page = $page;
}

if($language != ''){
$name = explode("___",$filename);
$name = $name[0]."___".$language;
include("language/language_".$language.".php");
}else{
$name = explode("___",$filename);
$name = $name[0];
include("language/language.php");
}
//echo "select * from temp_index where filename = '".$name."'";

$sql = $db->query("select * from temp_index where filename = '".$name."'");
if($db->db_num_rows($sql)==0){// && ($p === false)
$name = $filename;
$alert_lang = str_replace("<#lang#>",$language,$text_general_alert_nopage);
?>
<script language="javascript">
alert("<?php echo $alert_lang;?>");
</script>
<?php
}else{
$rec = $db->db_fetch_array($sql);
$name = $name;
}
//echo $name;
$f = "filename=".$filename;
$e = "filename=".$name;
$page_link = ereg_replace ($f, $e, $page);
//echo $page_link;

?>
<script language="javascript">
//window.location.href="main.php?filename=<?php//php echo $name;?>";
window.location.href="<?php echo $page_link;?>";
</script>
<?php
/*$sql = "select * from lang_setting,lang_page   where lang_setting.lang_setting_id =lang_page.lang_setting_id and  lang_setting_lang = '$language' and lang_setting_status = 'Y' and temp_index_filename ='$filename' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
//echo "<br><br>";
//echo "web goto=>".$rec[user_info_website]."<br>";
//echo "page goto=>".$rec[temp_index_filename_website]."<br>";
//echo "url goto=>".$rec[user_info_url];
//echo phpinfo();
if(!empty($rec[temp_index_filename_website])){
?>
<script language="javascript">
window.location.href="<?php echo $rec[user_info_url];?>main.php?filename=<?php echo $rec[temp_index_filename_website];?>";
</script>
<?php
}else{
?>
<script language="javascript">
window.location.href="<?php echo $rec[user_info_url];?>";
</script>
<?php
}
?>*/

