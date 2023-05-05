<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

$process=$HTTP_POST_VARS['process'];
$f_name=$HTTP_POST_VARS['f_name'];
$f_url=$HTTP_POST_VARS['f_url'];
$f_description=$HTTP_POST_VARS['f_description'];
$gid=$HTTP_POST_VARS['gid'];
$f_description=$HTTP_POST_VARS['f_description'];

?>
<html>
<head>
<title>Add To Favorite</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet"  href="css/style.css" type="text/css">
<script src="js/selectlist2.js" language="javascript1.2"></script>
<script src="js/AjaxRequest.js" language="javascript1.2"></script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="90%" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td>
		<br>
		<?php
			if($process=='save'){ 
				$db->query("insert into n_favorite
											(gen_user_id, f_name, f_url, f_description,f_groupid)
											values
											('".$HTTP_SESSION_VARS['EWT_MID']."', '".$f_name."', '".$f_url."', '".$f_description."','".$gid."')");
		?>
												<script language="javascript">
												<?php if($_GET[man]==1){?> 
                                                  window.opener.document.form1.submit();
												<?php } ?>
													window.close();
												</script>
		<?php
			}else{
		?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		  <tr bgcolor="#FFFFFF"> 
			<td colspan="2"><img src="mainpic/m_favorites.gif" align="absmiddle"> <font size="3"><strong>เพิ่มในรายการโปรด</strong></font></td>
		  </tr>
		  </table><br>

		<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		  <tr bgcolor="#FFFFFF"> 
			<td colspan="2">&nbsp;เพิ่มหน้านี้ไปยังรายการโปรด เพื่อที่จะได้ไว้เข้าใช้งานหรือเข้าชมรายการโปรดได้ในภายหลัง</td>
		  </tr>
	 </table><br>

		  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
		  <form name="form1" method="post" action="<?php $HTTP_SERVER_VARS['PHP_SELF']?>?man=<?php echo $_GET[man];?>">
			<input type="hidden" name="process" value="save">
		  <tr bgcolor="#FFFFFF"> 
			<td width="12%" align="right"><strong>ตั่งชื่อ:</strong></td>
			<td width="88%"><input type="text" name="f_name" value="<?php echo $title_name;?>" size="50"></td>
		  </tr>
		  <tr bgcolor="#FFFFFF"> 
			<td align="right"><strong>URL :</strong></td>
			<td>
                <?php if($_GET[man]==1){?>
                     <input name="f_url" type="text" id="f_url" value="http://www." size="50">
				<?php }else{?>
                    <span id="url_show"></span> <input name="f_url" type="hidden" id="f_url" value="">
                <?php }?>
			  </td>
		  </tr>
		  <tr bgcolor="#FFFFFF"> 
				<td align="right" valign="top" nowrap="nowrap"><strong>รายละเอียด :</strong></td>
				<td>
					<textarea name="f_description" cols="50" rows="4"></textarea>
			  </td>
		  </tr>
		  <tr bgcolor="#FFFFFF"> 
				<td align="right" valign="top"><strong>เลือกกลุ่ม :</strong></td>
				<td>
					<!--iframe name="list_send" src="group_list.php" frameborder="0" width="100%" align="top" height="50" scrolling="yes"></iframe>
					<input type="hidden" name="gid" id="gid"-->
					<select name="gid">
					<?php
						$sqlgroup="SELECT * FROM n_group WHERE gen_user_id ='".$HTTP_SESSION_VARS['EWT_MID']."' ORDER BY gname ASC";
						$querygroup=$db->query($sqlgroup);
						$numgroup= $db->db_num_rows($querygroup);
						if($numgroup>0){  ?>	
							 <?php while($recgroup=$db->db_fetch_array($querygroup)){ ?>
								  <option value="<?php echo $recgroup['gid'];?>" <?php if($chkgid==$recgroup['gid']){ echo 'selected';}?>><?php echo $recgroup['gname'];?></option>
							 <?php } ?>
						<?php } ?>
						</select><br>
                      <input type="button"  onClick="window.open('group_list.php?process=add','','width=400 , height=80, scrollbars=1,resizable=1');" value="สร้างกลุ่มใหม่">
			  </td>
		  </tr>
		  <tr bgcolor="#FFFFFF"> 
			<td align="center" colspan="2"><input type="submit" name="submit"  value=" บันทึก " ><input type="reset" name="reset" value=" ยกเลิก " onClick="window.close();"></td>
		  </tr>
		  </form>
		</table>
		
		<script language="JavaScript">
               <?php if($_GET[man]==1){?> 
				<?php }else{?>
                    document.form1.f_url.value = window.opener.document.URL;
					document.all['url_show'].innerHTML =  window.opener.document.URL; 
					var urlstr=window.opener.document.URL;
					urlreplace = urlstr.replace("http://","");
					document.form1.f_name.value = urlreplace; 
					document.form1.f_name.select();
                <?php }?>
		</script>
		<?php }?>
	</td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
