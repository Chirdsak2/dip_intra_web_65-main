<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);

$process=$HTTP_POST_VARS['process'];
$gname=$HTTP_POST_VARS['gname'];
$id=$HTTP_POST_VARS['id'];
$allrecord=$HTTP_POST_VARS['allrecord'];

?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkfeeall(totalrec){
		if(document.getElementById('chkfeeall').checked == true){
			for(i=1; i<=totalrec.value; i++){
				document.getElementById("chkfee"+i).checked=true;		
			}
		}else{
			for(i = 1; i<=totalrec.value;i++){
				document.getElementById("chkfee"+i).checked=false;
			}
		}
	}
	function checkfeeeach(totalrec){
		var num = 0
		for(i = 1; i<=totalrec.value;i++){
			if(document.getElementById("chkfee"+i).checked==true){
				num = num+1
			}
		}
		if(num==totalrec.value){
			document.getElementById('chkfeeall').checked = true;
		}else{
			document.getElementById('chkfeeall').checked = false;
		}
}	

 function chkchecked(maxx){
    if(maxx==0) {
        alert('กรุูณาเลือกรายการที่ต้องการลบ');
		return false; 
   }else {
         return true;
   }
}

</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><br>
                  <table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666">บริการกลุ่ม</font></strong></font></td>
                    </tr>
                  </table>
                 <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                      <td bgcolor="#FFFFFF"> 
							<a href="#a" onClick="window.location.href='favorite.php'"><img src="mainpic/m_favorites.gif" border="0" align="absmiddle"> หน้าหลักรายการโปรด</a> 
							<a href="#a" onClick="window.location.href='favorite_manage.php'"><img src="mainpic/m_contact.gif" border="0" align="absmiddle"> บริหารรายการโปรด</a> 
							<a href="#a" onClick="window.location.href='group_manage.php'"><img src="mainpic/m_borrow.gif" border="0" align="absmiddle"> บริการกลุ่ม</a>
                      </td>
                    </tr>
                  </table> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="447" valign="top"> 
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="mainpic/m_borrow.gif"align="absmiddle"> <font size="3"><strong>บริหารกลุ่ม</strong></font></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="#v"  onClick="window.open('group_list.php?process=add&man=1','','width=400 , height=80, scrollbars=1,resizable=1');" ><img src="mainpic/add.gif" align="absmiddle"  border="0"> เพิ่มกลุ่ม</a><hr>
    </td>
  </tr>
</table>
      <?php 
			 if($process=='delete'){
				$numdata=1+count($chkdata);
					for($del=1;$del<$numdata;$del++){
						if($chkdata[$del]!=''){
								$db->query("DELETE FROM n_group WHERE gid = '".$chkfee[$del]."'  ");
								$db->query("update n_favorite set f_groupid='0' WHERE f_groupid =  '".$chkfee[$del]."'");
									?>
      <form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
												<script language="javascript">
													alert('ลบข้อมูลเรียบร้อยแล้ว');
													document.formreturn.submit();
												</script>
											</form>
									<?php
							}
					}
				}else if($process=='update'){  
					$Chk_Data=$db->db_num_rows($db->query("SELECT gid FROM n_group WHERE gname ='".$gname."' AND gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' AND gid!='".$id."'"));
						if($Chk_Data==0){
							$db->query("update n_group set gname='".$gname."' WHERE gid = '".$id."'");
									?>
									<form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
										<script language="javascript">
											alert('ได้ทำการแก้ไข Group แล้ว');
											document.formreturn.submit();
										</script>
									</form>
									<?php
							}else{
									?>
									<form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
										<input name="process" type="hidden"  value="edit">
										<input name="id" type="hidden"  value="<?php echo $id;?>">
										<script language="javascript">
											alert('ได้มีชื่อ Group นี้แล้ว กรุณาตรวจสอบอีกครั้ง');
											document.formreturn.submit();
										</script>
									</form>
									<?php
							}
				}else if($process=='edit'){
			?>
				<form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post">
				<input type="hidden" name="process" value="update">
				<input type="hidden" name="id" value="<?php echo $id;?>">
				<?php
						$recedit=$db->db_fetch_array($db->query("SELECT * FROM n_group WHERE gid = '".$id."'"));
							$gname=$recedit['gname'];
				?>
				  <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
                    <tr>
                      <td bgcolor="#CCCCCC" colspan="2"><strong>แก้ไขข้อมูลกลุ่ม</strong></td>
                    </tr>
					  <tr bgcolor="#FFFFFF"> 
						<td width="12%" align="right" nowrap><strong>ชื่อกลุ่ม :</strong></td>
						<td width="88%"><input type="text" name="gname" value="<?php echo $gname;?>" size="50"></td>
					  </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" align="center" colspan="2"><input type="submit"name="Input2" class="submit" value="บันทึก"> 
                        <input  type="reset" name="Input2" class="submit" value="ตั่งค่าตามเดิม"> 
                       <input type="button" name="reset" value=" ยกเลิก " onClick="window.location.href='group_manage.php'">
						</td>
                    </tr>
                  </table>
				</form>
			<?php	
			}else{
			$sql="SELECT * FROM n_group WHERE gen_user_id ='".$HTTP_SESSION_VARS['EWT_MID']."' ORDER BY gname ASC ";
			$query=$db->query($sql);
			$rows=$db->db_num_rows($query);			
			?>
			<form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post">
			<input type="hidden" name="process" value="">
			<input type="hidden" name="id" value="">
			<input name="allrecord" type="hidden" value="<?php echo $rows;?>">
			<input name="dels" type="hidden" value="">
            <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000"> 
	          <tr>
                <td width="7%" align="center" bgcolor="#CCCCCC"><strong>แก้ไข</strong></td>
                <td width="87%" bgcolor="#CCCCCC" align="center"><strong>รายละเอียด</strong></td>
                <td width="6%" align="center" bgcolor="#CCCCCC">
				<?php if($rows!=0){?>
                        <input id="chkfeeall" name="chkfeeall" type="checkbox" value="Y" onClick="checkfeeall(document.getElementById('allrecord'));if(this.checked==true){document.all.dels.value=document.all.allrecord.value*1;}else{document.all.dels.value=0;}">
				<?php }?>
				</td>
              </tr>
			  <?php
				if($rows>0){
				$i=1;
				while($reclist=$db->db_fetch_array($query)){	?> 
				<td bgcolor="#FFFFFF" align="center" valign="top"><img src="mainpic/cal_edit.gif" align="absmiddle" border="0" style="cursor:hand" alt="แก้ไข" onClick="document.form1.process.value='edit';document.form1.id.value='<?php echo $reclist['gid'];?>';document.form1.submit();"></td>
                <td bgcolor="#FFFFFF" valign="top"><?php echo $reclist['gname'];?></td>
                <td bgcolor="#FFFFFF" align="center" valign="top">
					<input name="chkfee[<?php echo $i;?>]" id="chkfee<?php echo $i;?>" type="checkbox" value="<?php echo $reclist['gid'];?>" onClick="checkfeeeach(document.getElementById('allrecord')); if(this.checked==true){document.all.dels.value=(document.all.dels.value*1)+1;}else{document.all.dels.value=(document.all.dels.value*1)-1;}">
					<input type="hidden" name="chkdata[<?php echo $i?>]" value="<?php echo $reclist['gid'];?>">
				</td>
                </tr>
			  <?php
			  $i++;
			  	}
			  ?>
              <tr>
                <td bgcolor="#FFFFFF"nowrap colspan="2"></td>
                <td bgcolor="#FFFFFF" align="center"><input name="button"  type="button" value="ลบรายการ"  
                 onClick="if(chkchecked(document.all.dels.value)){
                                  if(confirm('คุณแน่ใจหรือไม่ที่ต้องการลบข้อมูลนี้')){
                                     document.form1.process.value='delete';
                                    document.form1.submit();
                                 } 
                            }"></td>
             </tr>
			  <?php
			  	}else{
			  ?>
              <tr bgcolor="#FFFFFF">
                <td colspan="3"align="center"><font color="#FF0000"><strong>ไม่มีข้อมูล</strong></font></td>
              </tr>
			  <?php
			  	}
			  ?>
            </table>	
			</form>		
		  <?php
			}
		?>	
	</td>
  </tr>
</table>
                </td>
              </tr>
            </table></td>
          <td width="5" height="100%" background="mainpic/bg_r.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>

</body>
</html>
<?php  $db->db_close(); ?>
