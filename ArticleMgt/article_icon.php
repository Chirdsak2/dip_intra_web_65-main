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
<body>
<form name="iconform" method="post" enctype="multipart/form-data" action="article_function.php">
<table >
<input type="hidden" name="Flag" value="UploadIcon">
<input type="hidden" name="cur_icon" value="<?php echo $_GET[iconname]?>">
<?php //<tr><td> <strong>เลือก Icon </strong>  <input type="file" name="icon" > <input type="submit" value="เพิ่ม Icon ใหม่"><hr></td> </tr> ?>
</table>

<?php $limit=5;?>




<table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
	<tr> 
		<td  valign="top">
			<table width="100%" cellpadding="5"  cellspacing="1" bgcolor="#B74900" class="ewttableuse" id="table-1">
				<tr class="nodrop ewttablehead">
					<td  width="4%" ></td>  
					<td  width="60%" align="center">Icon</td>
					<td  width="20%"  align="center">ชื่อไฟล์</td>  
					<?php //<td  width="20%"  align="center">ลบ</td>?>
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
							<td height="47"  align="center" nowrap="nowrap"><input type="radio" name="icon" value="<?php echo $file; ?>" 
								onClick="if(this.checked==true){window.iconform.cur_icon.value='<?php echo $file; ?>'};" <?php if($_GET[iconname]==$file){echo 'checked';} ?>>
						 </td>
							<td ><img src="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/icon/".$file; ?>"  border="0" align="absmiddle"></td>
							<td  width="10%" >&nbsp; <?php echo $file; ?></td>  
							<?php //<td  width="10%" align="center" ><input type="checkbox" name="chkdel<?php echo $i ? >" value="<?php echo $file;? >"></td>?>
	</tr>
					  <?php
					  $i++;
				   }
			 }
		} 
		?>
		<tr bgcolor="#FFFFFF"><td align="center"><input type="button" value="เลือก" 
			onClick="
			
			if(window.iconform.cur_icon.value != ''){
				self.opener.document.all.icon.value=window.iconform.cur_icon.value;
				self.opener.document.all.iconname.innerHTML=window.iconform.cur_icon.value;
			}else{
				self.opener.document.all.icon.value='';
				self.opener.document.all.iconname.innerHTML='No Icon File';
			}
			window.close();
			 "></td>
			 <td colspan="2"></td>
			 <?php /*
			 <td align="center">
			 <input type="hidden" name="all_count" value="<?php echo $i;?>">
			 <input type="submit" value=" ลบ "  onClick=" window.iconform.Flag.value='Del_Icon';  "></td>
			 */?>
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
