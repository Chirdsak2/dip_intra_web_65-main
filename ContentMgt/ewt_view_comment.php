<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if ($action=='del'){
		   $sql = "DELETE  FROM news_comment  WHERE news_id LIKE '$nid' AND status_comment LIKE 'Y' AND id_ans = '$id_ans'";
		   $query  = mysql_query($sql);
			unset($action);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.head_table { 
	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
	}
-->
</style>
<script language="JavaScript">
/*
self.parent.document.all.backoff.style.display = 'none';
self.parent.document.all.backon.style.display = '';
self.parent.document.all.folderon.style.display = 'none';
self.parent.document.all.folderoff.style.display = '';
self.parent.document.all.delon.style.display = 'none';
self.parent.document.all.deloff.style.display = '';
*/
</script>
<body><br>
  <form name="form1" method="post" action="article_function.php" onSubmit="return chk();">
    <input type="hidden" name="backto" value="<?php if($_SESSION["EWT_OPEN_ARTICLE"] == ""){ echo "article_group.php"; }else{ echo "article_list.php?cid=".$_SESSION["EWT_OPEN_ARTICLE"]; } ?>"></form>
	<?php
		   $sql_comment = "SELECT * FROM news_comment  WHERE news_id LIKE '$nid' AND status_comment LIKE 'Y' ORDER BY id_ans DESC";
		   $query_comment  = mysql_query($sql_comment);
		   $num_rows = mysql_num_rows($query_comment);
		   if ($num_rows >0){
					   while($res_comment = mysql_fetch_array($query_comment)){
					  ?> 
		<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" >
					  <tr bgcolor="#E9E9E9"  >
						<td width="50%" align="left"><li>ความคิดเห็นที่ <?php print $res_comment[id_ans];?></li></td>
						
    <td width="50%" align="right" bgcolor="#E9E9E9" > <a href="#" onclick="if(confirm('ยืนยันการลบ')){self.location.href='ewt_view_comment.php?action=del&nid=<?php echo $nid?>&id_ans=<?php echo $res_comment[id_ans]?>'}"><img src="../images/error.gif" width="16" height="16" border="0" align="absmiddle"> ลบ 
      </a> </td>
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
