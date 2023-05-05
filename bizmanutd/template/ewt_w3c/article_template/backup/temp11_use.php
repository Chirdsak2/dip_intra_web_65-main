<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td align="center"><strong><?php echo $R["n_topic"]; ?></strong></td>
  </tr>
</table>

<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
<?php
$b = 0;
$sql = $db->query("SELECT MAX(at_type_row),MAX(at_type_col) FROM article_detail WHERE n_id = '$nid'");
$M = $db->db_fetch_row($sql);
$width = number_format($R["d_site_content"]/$M[1], 0, ',', ',');
$width2 = number_format(100/$M[1], 0, ',', ',');
for($a=1;$a<=$M[0];$a++){
?>
  <tr bgcolor="#FFFFFF"> 
  <?
  for($c=1;$c<=$M[1];$c++){
  $sql_id= $db->query("select ad_id from article_detail where n_id = '$nid' and at_type_row='$a' and at_type_col ='$c'");
  $A_id = $db->db_fetch_row($sql_id);
  
   $sql_bid= $db->query("select ad_des,block_type,block_name,block_link from article_detail,block where article_detail.ad_des =  block.BID and ad_id = '".$A_id[0]."' ");
   $B_id = $db->db_fetch_row($sql_bid);
  ?>
    <td width="<?php echo $width2;?>%" valign="top">
<?php
$mainwidth = $width;
		  $sql_top = $db->query("SELECT block.BID FROM block  WHERE  BID = '".$B_id[0]."' ");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
      <DIV ><?php echo show_block($TB[0]); ?></DIV>
      <?php } ?>
   </td>
  <? } ?>
  </tr>		
  <?php $b++; } ?>
</table>
