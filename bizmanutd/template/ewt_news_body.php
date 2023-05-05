<?php
session_start();
$start_time_counter = date("YmdHis");
ini_set("session.gc_maxlifetime", 60*60); 

include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

function datetime($str){
  $y=substr($str,0,4);
  $m=substr($str,4,2);
  $d=substr($str,6,2);
  $h=substr($str,8,2);
  $i=substr($str,10,2);
  $s=substr($str,12,2);
  
  $str=" [$d/$m/$y - $h:$i:$s]";
  if(trim($str)=="[// - ::]"){ return ''; }else{ return  $str;}
}

$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

$lang_config_id = $sql_lang_comfig[lang_config_id];

$sql_article = $db->query("SELECT * FROM article_list WHERE n_id = '".$_GET["nid"]."'");
$RR= $db->db_fetch_array($sql_article);

$date_txt = 'วันที่';
$date = explode("-",$RR["n_date"]);
$date =  number_format($date[2],0)." ".$monthname[number_format($date[1],0)]." ".$date[0];

$nid = $_GET["nid"];

$page = 'news';
//include("ewt_function.php");
if($use_template != ""){
	$_GET["d_id"] =$use_template;
}
$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);

$global_theme = $R["d_bottom_content"];
$mainwidth = "0";
?>
<table width="99%" border="0" cellpadding="5" cellspacing="0" >
		  <?php 	if($RR[show_topic] == '1'){ ?>
                  <tr>
            <td><div style="FONT: 17px 'Tahoma';"><?php echo $RR["n_topic"]; ?></div><hr size="1">
			<?php } ?>
			<?php 	if($RR[show_date] == '1'){ ?>
			<span style="FONT: 12px 'Tahoma';"><?php echo $date_txt;?> <?php echo $date ; ?> <?php echo $RR["n_time"]; ?></span>
			<?php } ?>
			<br><span style="FONT: 12px 'Tahoma';"><?php echo $text_genarticle_textsource;?><?php if($RR["sourceLink"] ==''){echo $RR["source"];}else{ ?><a href="<?php echo $RR["sourceLink"];?>" target="_blank" ><?php echo $RR["source"]; ?></a><?php } ?></span>
</td>
          </tr>
	  </table>
<?php
	$sql_t = $db->query("SELECT * FROM article_template WHERE at_id = '$RR[at_id]'");
	$A = $db->db_fetch_array($sql_t);
	include("../../article_template/".$A["at_use"]);

$db->db_close(); ?>
