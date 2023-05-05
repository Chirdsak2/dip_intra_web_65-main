<br>

<table width="90%" border="0" align="center" cellpadding="4" cellspacing="0"  class="text_normal">
<?php
	
	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '1' AND at_type_col = '1' ");
	 
	 $C1 = $db->db_fetch_array($sql_r);
	 	 if($lang_shw != ''){
		 $C1["ad_des"]=lang_detail($nid,$lang_config_id,'ad_des'.$C1[ad_id],'article_list');
		 }

	  ?>
  <tr align="<?php echo $C1["ad_align"]; ?>" > 
    <td valign="top"><?php echo preg_replace ($search, $replace, stripslashes($C1["ad_des"])); ?>
      </td>
  </tr>
</table>
<table  border="0" align="center" cellpadding="10" cellspacing="0"  class="text_normal">
  <?php
$b = 1;
$sql = $db->query("SELECT MAX(at_type_row) FROM article_detail WHERE n_id = '$nid'");
$M = $db->db_fetch_row($sql);
for($a=2;$a<=$M[0];$a++){

$sql_l = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$a' AND at_type_col = '1' ");

	if($db->db_num_rows($sql_l) > 0){
	$C1 = $db->db_fetch_array($sql_l);
	 if($lang_shw != ''){
		 $C1["ad_des"]=lang_detail($nid,$lang_config_id,'ad_des'.$C1[ad_id],'article_list');
	 }
?>
  <tr  > 
    <td align="<?php echo $C1["ad_align"]; ?>" valign="top"><?php if($C1["ad_pic_s"] != ""){ ?><div>
      <a href="<?php if($C1["ad_pic_b"] != ""){ echo "../images/article/news".$nid."/".$C1["ad_pic_b"]; }else{ echo "../../../images/o.gif"; } ?>"><img src="<?php if($C1["ad_pic_s"] != ""){ echo "../images/article/news".$nid."/".$C1["ad_pic_s"]; }else{ echo "../../../images/o.gif"; } ?>"  alt="<?php if($C1["ad_des"] != ''){echo $C1["ad_des"];}else{ echo $C1["ad_pic_s"];}?>"  border="0"></a>
</div>
      <?php } ?>
      <?php echo preg_replace ($search, $replace,stripslashes($C1["ad_des"])); ?></td>
    <?php
	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$a' AND at_type_col = '2' ");
	  $C1 = $db->db_fetch_array($sql_r);
	   if($lang_shw != ''){
		$C1["ad_des"]=lang_detail($nid,$lang_config_id,'ad_des'.$C1[ad_id],'article_list');
	 }
	  ?>
    <td   valign="top" align="<?php echo $C1["ad_align"]; ?>"> 
      <?php if($C1["ad_pic_s"] != ""){ ?><div>
      <a href="<?php if($C1["ad_pic_b"] != ""){ echo "../images/article/news".$nid."/".$C1["ad_pic_b"]; }else{ echo "../../../images/o.gif"; } ?>" ><img src="<?php if($C1["ad_pic_s"] != ""){ echo "../images/article/news".$nid."/".$C1["ad_pic_s"]; }else{ echo "../../../images/o.gif"; } ?>" alt="<?php if($C1["ad_des"] != ''){echo $C1["ad_des"];}else{ echo $C1["ad_pic_s"];}?>"  border="0"></a>
	</div>
      <?php } ?>
      <?php echo preg_replace ($search, $replace,stripslashes($C1["ad_des"])); ?></td>
    <?php
	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$a' AND at_type_col = '3' ");
	  $C1 = $db->db_fetch_array($sql_r);
	  if($lang_shw != ''){
		 $C1["ad_des"]=lang_detail($nid,$lang_config_id,'ad_des'.$C1[ad_id],'article_list');
	 }
	  ?>
    <td   valign="top" align="<?php echo $C1["ad_align"]; ?>"> 
      <?php if($C1["ad_pic_s"] != ""){ ?>
      <div><a href="<?php if($C1["ad_pic_b"] != ""){ echo "../images/article/news".$nid."/".$C1["ad_pic_b"]; }else{ echo "../../../images/o.gif"; } ?>"><img src="<?php if($C1["ad_pic_s"] != ""){ echo "../images/article/news".$nid."/".$C1["ad_pic_s"]; }else{ echo "../../../images/o.gif"; } ?>"  alt="<?php if($C1["ad_des"] != ''){echo $C1["ad_des"];}else{ echo $C1["ad_pic_s"];}?>"  border="0"></a></div>
      <?php } ?>
     <?php echo preg_replace ($search, $replace,stripslashes($C1["ad_des"])); ?></td>
  </tr>
  <?php $b++; }} ?>
</table>
