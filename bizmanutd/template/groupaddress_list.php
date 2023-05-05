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
</script></head>
<body leftmargin="0" topmargin="0" >

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="mainpic/m_address.gif" width="24" height="24" align="absmiddle"><span class="myhead_02">บริหารกลุ่ม  Address</span></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="groupaddress_add.php?process=groupadd"><img border="0" src="mainpic/add.gif" width="16" height="16" align="absmiddle">เพิ่มข้อมูลกลุ่ม</a>
        <hr /></td>
  </tr>
</table>
<?php
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
                  <td align="center" bgcolor="#CCCCCC"><strong>ชื่อกลุ่ม</strong></td>
                  <td width="7%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <?php
				if($rows>0){
				$i=1;
				while($reclist=$db->db_fetch_array($query)){
				?>
                <td valign="top" bgcolor="#FFFFFF"><?php echo $reclist['ganame'];?></td>
              <td bgcolor="#FFFFFF" valign="top" align="center"><a href="groupaddress_add.php?process=groupedit&id=<?php echo $reclist['id'];?>" ><img src="mainpic/cal_edit.gif" align="absmiddle" border="0" style="cursor:hand" alt="แก้ไข"></a>&nbsp;&nbsp;
			<a href="address_function.php?process=groupdelete&id=<?php echo $reclist['id'];?>" ><img src="mainpic/b_delete.gif" width="14" height="14" border="0" alt="ลบ" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');"></a></td>
                </tr>
                <?php
			  $i++;
			  	}
			  ?>
                <?php
			  	}else{
			  ?>
                <tr bgcolor="#FFFFFF">
                  <td colspan="2"align="center"><font color="#FF0000"><strong>ไม่มีข้อมูล</strong></font></td>
                </tr>
                <?php
			  	}
			  ?>
              </table>
            </form>

</body>
</html>
<?php  $db->db_close(); ?>
