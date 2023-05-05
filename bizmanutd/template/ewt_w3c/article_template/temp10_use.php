
<table width="99%" border="0" align="center" cellpadding="4" cellspacing="0">
<?php

	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '1' AND at_type_col = '1' ");
	  $C1 = $db->db_fetch_array($sql_r);
	   if($lang_shw != ''){
		 $C1["ad_des"]=lang_detail($nid,$lang_config_id,'ad_des'.$C1[ad_id],'article_list');
	 }
	  ?>
  <tr  > 
    <td width="99%"><font color="<?php echo $C1["ad_color"]; ?>" size="<?php echo $C1["ad_size"]; ?>" face="<?php echo $C1["ad_font"]; ?>" style="<?php echo $C1["ad_bold"]; ?><?php echo $C1["ad_italic"]; ?>"><?php echo $detail =  $C1["ad_des"]; ?></font>  </td>
  </tr>
  <?php
$b = 1;
$sql = $db->query("SELECT MAX(at_type_row) FROM article_detail WHERE n_id = '$nid'");
$M = $db->db_fetch_row($sql);
for($a=2;$a<=$M[0];$a++){
$sql_l = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$a' AND at_type_col = '1' ");

	if($db->db_num_rows($sql_l) > 0){
	$C1 = $db->db_fetch_array($sql_l);
	
?>
  <?php $b++; }} ?>
</table>
