<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
if ($action=='del'){
		   $sql = "DELETE  FROM news_comment  WHERE news_id LIKE '$nid' AND status_comment LIKE 'Y' AND id_ans = '$id_ans'";
		   $query  = mysql_query($sql);
			unset($action);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
	<?php
		   $sql_comment = "SELECT * FROM news_comment  WHERE news_id LIKE '$nid' AND status_comment LIKE 'Y' ORDER BY id_ans DESC";
		   $query_comment  = mysql_query($sql_comment);
		   $num_rows = mysql_num_rows($query_comment);
		   if ($num_rows >0){
					   while($res_comment = mysql_fetch_array($query_comment)){
					  ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
					  <tr bgcolor="#E9E9E9" >
						<td width="31%" align="left"><li>ความคิดเห็นที่ <?php print $res_comment[id_ans];?></li></td>
						<td width="69%" align="right" bgcolor="#E9E9E9" >
						<a href="#" onclick="if(confirm('ยืนยันการลบ')){self.location.href='ewt_view_comment.php?action=del&nid=<?php echo $nid?>&id_ans=<?php echo $res_comment[id_ans]?>'}">ลบ
						</a>
						</td>
					  </tr>
					  <tr>
						<td colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;<?php print $res_comment[comment];?></td>
					  </tr>
					  <tr>
						<td colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;<span style="color:#FF9900"><?php print $res_comment[name_comment];?></span></td>
					  </tr>
					  <tr>
						<td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
					  </tr>
		</table>
					<?php
					  }//end while
		  }//end if  
  ?>

</body>
</html>
