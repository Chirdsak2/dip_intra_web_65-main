<?php
$path = "../";
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	?>
<table width="100%" border="0">
<?php
if($_GET[page] != ''){
$wh = "and  tips_main.tips_main_type_id = '".$_GET[page]."' ";
}
$sql = "select * from tips_list inner join tips_main on tips_main.tips_list_id = tips_list.tips_list_id inner join tips_group on tips_group.tips_group_id = tips_list.tips_group_id where tips_list.tips_group_id = '".$_GET[gtips_id]."' $wh GROUP BY  tips_list.tips_list_id ";
	$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
?>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="../mainpic/arrow_r.gif" width="7" height="7" border="0"  alt="">&nbsp;<a href="#G" onClick="show_detailsub(<?php echo $R[tips_list_id];?>,<?php echo $_GET[gtips_id];?>);" accesskey=<?php echo $db->genaccesskey();?>><span  class="text_normal"><?php echo $R[tips_list_title];?></span></a></td>
  </tr>
 <? } ?>
</table>
<?php $db->db_close(); ?>
