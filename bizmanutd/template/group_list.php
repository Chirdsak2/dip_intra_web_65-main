<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

$process=$HTTP_POST_VARS['process'];
if(!$process)$process=$HTTP_GET_VARS['process'];
$chkgid=$HTTP_POST_VARS['chkgid'];
$gname=$HTTP_POST_VARS['gname'];

?>
<html>
<head>
<title>Add To Favorite</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet"  href="css/style.css" type="text/css">
<script language="javascript">
function Send_Data(Data){
	self.parent.document.getElementById('gid').value=Data; 
}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<?php
if($process=='add'){ ?>
	<form name="form2" enctype="multipart/form-data" method="post" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF'];?>?man=<?php echo $_GET[man];?>">
		<input name="process" type="hidden"  value="save">
		<input name="chkgid" type="hidden"  value="<?php echo $chkgid;?>">
			<table width="90%"  height="30" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC" align="center">
				  <tr> <td colspan="2" bgcolor="#FFFFFF"><img src="mainpic/star_yellow.gif" align="absmiddle"> <strong>สร้างกลุ่มใหม่</strong></td> </tr>
			</table>
		   <table width="90%" border="0" cellspacing="1" cellpadding="3" bgcolor="#CCCCCC" align="center">
				  <tr>
					<td bgcolor="#FFFFFF"><strong>ตั่งชื่อกลุ่ม</strong></td>
					<td bgcolor="#FFFFFF"><input type="text" name="gname" value="<?php echo $gname;?>" size="40"></td>
				  </tr>
				  <tr>
					<td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="submit" value=" บันทึก "> <input type="button" name="reset" value=" ยกเลิก " onClick="window.close();"></td>
				  </tr>
		</table>
	</form>
	<?php } else if($process=='save'){
			$Chk_Data=$db->db_num_rows($db->query("SELECT gid FROM n_group WHERE gname ='".htmlspecialchars(stripslashes($gname),ENT_QUOTES)."' AND gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."'"));
			if($Chk_Data==0){
					$db->query("insert into n_group (gen_user_id, gname) values ('".$HTTP_SESSION_VARS['EWT_MID']."', '".htmlspecialchars(stripslashes($gname),ENT_QUOTES)."')");	
					$query=$db->query("SELECT gid FROM n_group WHERE gname ='".$gname."' AND gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."'");
					$data=$db->db_fetch_array($query);
					 $newid=$data[gid];
					?>
						<script language="javascript">
							<?php if($_GET[man]==1){?> 
                  					window.opener.document.form1.submit();
							<?php }else{?>
									with (window.opener) {
										oSelect=document.getElementById('gid');
										var oOption=document.createElement('option');
										oOption.innerHTML="<?php echo htmlspecialchars(stripslashes($gname),ENT_QUOTES); ?>";
										oOption.value="<?php echo $newid; ?>";
										oOption.selected = true;
										oSelect.appendChild(oOption);
									} 
							<?php }?>
						  window.close()
						</script>
						
						
						
<?php
				}else{
						?>
						<form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
							<input name="chkgid" type="hidden"  value="<?php echo $chkgid;?>">
							<input name="process" type="hidden"  value="add">
							<input name="gname" type="hidden"  value="<?php echo $gname;?>">
							<script language="javascript">
								alert('ได้มีชื่อ Group นี้แล้ว กรุณาตรวจสอบอีกครั้ง');
								document.formreturn.submit();
							</script>
						</form>
						<?php
				}
	}?>
</body>
</html>
<?php  $db->db_close(); ?>
