<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);
$process=$HTTP_POST_VARS['process'];
$ganame=$HTTP_POST_VARS['ganame'];
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
</script>
</head>
<body leftmargin="0" topmargin="0" ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="447" valign="top"><?php 
			 if($process=='delete'){
				$numdata=1+count($chkdata);
					for($del=1;$del<$numdata;$del++){
						if($chkdata[$del]!=''){
								$db->query("DELETE FROM n_groupaddress WHERE id = '".$chkfee[$del]."'  ");
								$db->query("update n_address set a_groupid='0' WHERE a_groupid =  '".$chkfee[$del]."'");
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
					$Chk_Data=$db->db_num_rows($db->query("SELECT id FROM n_groupaddress WHERE ganame ='".$ganame."' AND gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' AND id!='".$id."'"));
						if($Chk_Data==0){
							$db->query("update n_groupaddress set ganame='".$ganame."' WHERE id = '".$id."'");
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
              <input type="hidden" name="process2" value="update">
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <?php
						$recedit=$db->db_fetch_array($db->query("SELECT * FROM n_groupaddress WHERE id = '".$id."'"));
							$ganame=$recedit['ganame'];
				?>
              <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
                <tr>
                  <td bgcolor="#CCCCCC" colspan="2"><strong>Edit To Group</strong></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="12%" align="right"><strong>Group Name:</strong></td>
                  <td width="88%"><input type="text" name="ganame" value="<?php echo $ganame;?>" size="50"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" align="center" colspan="2"><input type="submit"name="Input2" class="submit" value="Save">
                    &nbsp;
                    <input  type="reset" name="Input2" class="submit" value="Cancel">
                    <input type="button" name="reset" value=" back " onClick="window.location.href='groupaddress_manage.php'">
                  </td>
                </tr>
              </table>
            </form>
          <?php	
			}else{
			$sql="SELECT * FROM n_groupaddress WHERE gen_user_id ='".$HTTP_SESSION_VARS['EWT_MID']."' ORDER BY ganame ASC ";
			$query=$db->query($sql);
			$rows=$db->db_num_rows($query);			
			?>
            <form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post">
              <input type="hidden" name="process2" value="">
              <input type="hidden" name="id" value="">
              <input name="allrecord" type="hidden" value="<?php echo $rows;?>">
              <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
                <tr>
                  <td width="6%" align="center" bgcolor="#CCCCCC"><?php if($rows!=0){?>
                      <input id="chkfeeall" name="chkfeeall" type="checkbox" value="Y" onClick="checkfeeall(document.getElementById('allrecord'));">
                      <?php }?>
                  </td>
                  <td width="87%" bgcolor="#CCCCCC" align="center"><strong>Detail</strong></td>
                  <td width="7%" align="center" bgcolor="#CCCCCC"><strong>Edit</strong></td>
                </tr>
                <?php
				if($rows>0){
				$i=1;
				while($reclist=$db->db_fetch_array($query)){
				?>
                <td bgcolor="#FFFFFF" align="center" valign="top"><input name="chkfee[<?php echo $i;?>]" id="chkfee<?php echo $i;?>" type="checkbox" value="<?php echo $reclist['id'];?>" onClick="checkfeeeach(document.getElementById('allrecord'));">
                  <input type="hidden" name="chkdata[<?php echo $i?>]" value="<?php echo $reclist['id'];?>">
                </td>
              <td bgcolor="#FFFFFF" valign="top"><?php echo $reclist['ganame'];?></td>
                  <td bgcolor="#FFFFFF" valign="top" align="center"><img src="mainpic/cal_edit.gif" align="absmiddle" border="0" style="cursor:hand" alt="แก้ไข" onClick="document.form1.process.value='edit';document.form1.id.value='<?php echo $reclist['id'];?>';document.form1.submit();"></td>
                </tr>
                <?php
			  $i++;
			  	}
			  ?>
                <tr>
                  <td bgcolor="#FFFFFF" align="center"><input name="button"  type="button" value="Delete"  onClick="if(confirm('คุณแน่ใจหรือไม่ที่ต้องการลบข้อมูลนี้')){document.form1.process.value='delete';document.form1.submit();}"></td>
                  <td bgcolor="#FFFFFF"nowrap></td>
                  <td bgcolor="#FFFFFF" align="center"nowrap><input type="button" name="reset" value=" back " onClick="window.location.href='address_manage.php'"></td>
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
    </table></td>
  </tr>
</table>

</body>
</html>
<?php  $db->db_close(); ?>
