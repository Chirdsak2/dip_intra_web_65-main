<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
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
	<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ( "บริหาร Icon ท้ายข่าว/บทความ"); ?>&module=article&url=<?php echo urlencode ( "article_iconmgt.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="article_iconadd.php?cid=<?php echo $R["c_id"]; ?>"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่ม Icon</a>
    <hr>
	</td>
  </tr>
</table>
<table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
	<tr> 
		<td  valign="top">
			<table width="98%" cellpadding="5" align="center" class="table table-bordered" id="table-1">
				<tr class="nodrop ewttablehead">
					<td  width="4%" ></td>  
					<td  width="60%" align="center">Icon</td>
					<td  width="20%"  align="center">ชื่อไฟล์</td>  
					<td  width="20%"  align="center">ลบ</td>
				</tr>
	<?php
		$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/icon";
		$objFolder = opendir($Current_Dir);
		$i = 0;
		rewinddir($objFolder);
		while($file = readdir($objFolder)){
			  if(!(($file == ".") or ($file == "..") or ($file == "Thumbs.db") )){
			  		$FT= filetype($Current_Dir."/".$file);
			  		if($FT == "file"){
			           ?>
					   
					   <tr bgcolor="#FFFFFF" id="<?php echo $i;?>">
							<td height="47"  align="center" nowrap="nowrap"><!--input type="radio" name="icon" value="<?php echo $file; ?>" 
								onClick="if(this.checked==true){window.iconform.cur_icon.value='<?php echo $file; ?>'};" <?php if($_GET[iconname]==$file){echo 'checked';} ?>-->
						 </td>
							<td ><img src="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/icon/".$file; ?>"  border="0" align="absmiddle"></td>
							<td  width="10%" >&nbsp; <?php echo $file; ?></td>  
							<td  width="10%" align="center" ><input type="checkbox" name="chkdel<?php echo $i ?>" value="<?php echo $file;?>"></td>
	</tr>
					  <?php
					  $i++;
				   }
			 }
		} 
		?>
		<tr bgcolor="#FFFFFF"><td align="center"><!--input type="button" value="เลือก" 
			onClick="
			self.opener.document.all.icon.value=window.iconform.cur_icon.value;
			self.opener.document.all.iconname.innerHTML=window.iconform.cur_icon.value;
			self.opener.document.all.noicon.checked=false;
			window.close();
			 "--></td>
			 <td colspan="2"></td>
			 <td align="center">
			 <input type="hidden" name="all_count" value="<?php echo $i;?>">
			 <input type="submit" value=" ลบ "   
			 onClick="window.iconform.Flag.value='Del_Icon'; if(chkdel(<?php echo $i; ?>)){return confirm('แน่ใจที่จะลบหรือไม่?');}else{alert('กรุณาเลือกรายการที่ต้องการลบ'); return false;};"
			 ></td>
 </tr>
		<?php
		closedir($objFolder);
?>
			</table>
			
		</td>
	</tr>
</table>
</form>



</body>
</html>
<?php $db->db_close(); ?>
