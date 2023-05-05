<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

</head>
<script language="javascript">
function chkdel(maxs){
     var i=0;
	 for(i=0;i<maxs;i++){  if(document.getElementById('chkdel'+i).checked) return true;    }
	  return false;
 }
</script>
<body>
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="iconform" method="post" enctype="multipart/form-data" action="article_function.php">
<table >
<input type="hidden" name="Flag" value="UploadIcon">
<input type="hidden" name="cur_icon">
</table>

 <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">บริหาร Icon ท้ายข่าว/บทความ</span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
		<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ( "เพิ่ม Icon ท้ายข่าว/บทความ"); ?>&module=article&url=<?php echo urlencode ( "article_iconadd.php?cid=".$R["c_id"]); ?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="article_group.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> หน้าหลัก</a>&nbsp;&nbsp;&nbsp;
<a href="article_iconmgt.php?cid=<?php echo $R["c_id"]; ?>"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> ย้อนกลับ</a>
&nbsp;&nbsp;&nbsp;
<a href="article_iconadd.php?cid=<?php echo $R["c_id"]; ?>"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่ม Icon</a>
    <hr>
	</td>
  </tr>
</table>

<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999"  class="ewttableuse">
  <tr>
    <th height="23" colspan="2" class="ewttablehead"  scope="col"><div align="left">เพิ่ม Icon</div></th>
  </tr>
  <tr>
    <td width="12%" height="23" bgcolor="#FFFFFF">เลือก Icon<font style="color:#FF0000"> *</font></td>
    <td width="88%" height="23" bgcolor="#FFFFFF"><input type="file" name="icon" >    </td>
  </tr>
  <tr>
    <td width="12%" height="23" bgcolor="#FFFFFF"></td>
    <td width="88%" height="23" bgcolor="#FFFFFF">  <input type="button" value="เพิ่ม Icon ใหม่" onClick="if(document.iconform.icon.value==''){alert('กรุณาเลือกไฟล์')}else{document.iconform.submit();}"> </td>
  </tr>
  

  </table>
</form>



</body>
</html>
<?php $db->db_close(); ?>
