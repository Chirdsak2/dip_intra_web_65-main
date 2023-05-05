<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td align="center"><strong><?php echo $R["n_topic"]; ?></strong></td>
  </tr>
</table>

<table width="99%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
<?php
$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");

$b = 0;
$sql = $db->query("SELECT MAX(at_type_row),MAX(at_type_col) FROM article_detail WHERE n_id = '$nid'");
$M = $db->db_fetch_row($sql);
$width = number_format(100/$M[1], 0, ',', ',');
for($a=1;$a<=$M[0];$a++){
?>
  <tr bgcolor="#FFFFFF"> 
  <?php
  for($c=1;$c<=$M[1];$c++){
  $sql_id= $db->query("select ad_id from article_detail where n_id = '$nid' and at_type_row='$a' and at_type_col ='$c'");
  $A_id = $db->db_fetch_row($sql_id);
  
   $sql_bid= $db->query("select ad_des,block_type,block_name,block_link from article_detail,block where article_detail.ad_des =  block.BID and ad_id = '".$A_id[0]."' ");
   $B_id = $db->db_fetch_row($sql_bid);
  ?>
    <td height="50" width="<?php echo $width;?>%" valign="top">
	<table width="100%" border="0" cellpadding="2" cellspacing="1">
      <tr >
        <td height="20">&nbsp;&nbsp;<a href="#M" onclick="window.open('module_listmain.php?ad_id=<?php echo $A_id[0];?>','modulelist','width=800,height=550,resizable=1,scrollbars=1');"><img src="../theme/main_theme/g_edit.gif" alt="เลือกModule" width="16" height="16"  border="0" /></a>&nbsp;&nbsp;
		<?php if(!empty($B_id[0])){?><img src="<?php echo icon_block2($B_id[1],'../'); ?>" width="20" height="20" align="absmiddle"><?php//php echo $B_id[2];?><?php } ?><?php echo preg_replace ($search, $replace, listname_block($B_id[1],$B_id[3],$B_id[0]));?></td>
      </tr>
      <tr >
        <td height="20"></td>
      </tr>
    </table>
   </td>
  <?php } ?>
  </tr>		
  <?php $b++; } ?>
</table>
