<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST[Flag]<>' '){
		if($_POST[Flag]=='Add'){
		  $query=$db->query("SELECT * FROM  article_group_module WHERE  c_id='' "); 
		  if($db->db_num_rows($query) == 0){
			 $db->query("INSERT INTO template_module(article_group_module,c_id) VALUES('','')"); 
			 	 ?>
				 <script language="JavaScript">
					win2 = window.open('article_group_module_popup.php?mod=<?php echo $_POST[mod];?>','article_group_module','top=100,left=100,width=500,height=500,resizable=1,status=0,scrollbars=1');win2.focus();
				</script>
				 <?php
		  }
		}
		if($_POST[Flag]=='Cancel'){
		  $db->query("DELETE  FROM  article_group_module WHERE article_group_mid = '$_POST[tmid]' "); 
		}
}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<script language="javascript">
		 function popup_module(mod){
		   win2 = window.open('article_select_module.php','template','top=100,left=100,width=500,height=500,resizable=1,status=0,scrollbars=1');win2.focus();
		 }
 
 		function cancel_template(tmid,mod){
			document.form.Flag.value='Cancel';
			document.form.tmid.value=tmid;
			document.form.mod.value=mod;
			document.form.submit();
		}
 </script>
</head>
<body>
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ตั้งค่ากลุ่มข่าว/บทความให้รับข่าวจากภายนอก</span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
		<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo base64_encode ( "ตั้งค่ากลุ่มข่าว/บทความให้รับข่าวจากภายนอก"); ?>&module=article&url=<?php echo base64_encode ( "article_group_module.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#browse" title="เลือก Icon" onClick="popup_module('Article');"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่มกลุ่มข่าว/บทความ</a>
    <hr>
	</td>
  </tr>
</table>




<table width="94%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
	<tr> 
		<td  valign="top">
			<table width="100%" cellpadding="5"  cellspacing="1" bgcolor="#B74900" class="ewttableuse" id="table-1">
				<tr class="nodrop ewttablehead">
					<td  width="4%" ></td>  
					<td  width="96%" align="center">ชื่อกลุ่มข่าว/บทความ</td>
				</tr>
	<?php
		$sql="SELECT * FROM article_group_module INNER JOIN  article_group ON article_group_module.c_id = article_group.c_id order by c_name ASC ";
		$query = $db->query($sql); 
		if($db->db_num_rows($query) > 0){
				while($R=$db->db_fetch_array($query)){    ?> 
				<tr bgcolor="#FFFFFF" >
						<td height="20"  align="center" nowrap="nowrap">
						<img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" align="absmiddle" alt="ยกเลิกกลุ่มข่าว/บทความ" onClick="if(confirm('ยืนยันการยกเลิกกลุ่มข่าว/บทความ  <?php echo $R["c_name"]; ?>')){cancel_template('<?php echo $R["article_group_mid"]; ?>','Article')}"></td>
						<td >&nbsp;<?php echo $R["c_name"]; ?></td>
				  </tr>
				 <?php
					  $i++;
				} 
			}else{?>
			<tr bgcolor="#FFFFFF" >
						<td height="20"   align="center" 	colspan="2"><span class="style1"> ไม่พบข้อมูล</span> </td> 
			</tr>
	     <?php } ?>
			</table>
			
		</td>
	</tr>
</table>

<form name="form" action="article_group_module.php" method="post">
	<input type="hidden" name="Flag" value="Cancel">
	<input type="hidden" name="did">
	<input type="hidden" name="mod">
	<input type="hidden" name="tmid">
</form>
</body>
</html>
<?php $db->db_close(); ?>
