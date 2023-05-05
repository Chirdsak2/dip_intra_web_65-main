<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);
@include("language/language.php");
$process=$HTTP_POST_VARS['process'];
$allrecord=$HTTP_POST_VARS['allrecord'];
$id=$HTTP_POST_VARS['id'];

?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript">
function ChkAddress(f){
	if (f.a_site.value==''){
	  alert("กรุณากรอก Sitename");
	  f.a_site.focus();
	}else if (f.a_url.value=='http://'){
	  alert("กรุณากรอก URL ");
	  f.a_url.focus();
	}else {
	  return true;
	}
	return false;
}
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
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="mainpic/m_address.gif" width="24" height="24" align="absmiddle"><span class="myhead_02">บริหารข้อมูล Address</span></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="address_add.php?process=add"><img border="0" src="mainpic/add.gif" width="16" height="16" align="absmiddle">เพิ่มข้อมูล</a><hr /></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
                      <td height="447" valign="top"> 
                        <?php 
			$sql="SELECT *,n_address.id AS id ,n_groupaddress.id AS gid FROM n_address LEFT OUTER JOIN n_groupaddress ON n_address.a_groupid = n_groupaddress.id WHERE n_address.gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' ORDER BY  n_groupaddress.ganame,a_site ";
			$query=$db->query($sql);
			$rows=$db->db_num_rows($query);		
			//start ???????????????????
			if($limit == ""){ $limit = 20;} //???????????????????????????????page
			if (empty($offset) || $offset < 0) { $offset=0; $i=1;}else{$i=$offset+1;}//?????????????????????page
			$sqllist=$sql.CalSplitPage($rows, $offset, $limit);
			// end ???????????????????
			$querylist = $db->query($sqllist);
			$numlist = $db->db_num_rows($querylist);
			?>
                        <form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post">
			<input type="hidden" name="process" value="">
			<input type="hidden" name="id" value="">
			<input name="allrecord" type="hidden" value="<?php echo $rows;?>">
            <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
			  <!--<tr bgcolor="#FFFFFF">
				              <td colspan="2" align="right"><a href="address_manage.php"><strong><?php//php echo $text_genaddress_manage;?></strong></a></td>
			  </tr>-->
              <tr>
                <td colspan="2" align="center" bgcolor="#9E96AF" class="mytext_normal_03"> <strong><?php//php echo $text_genaddress_textNo;?></strong><strong><?php echo $text_genaddress_textdetail;?></strong></td>
              </tr>
			  <?php
				if($numlist>0){
				while($reclist=$db->db_fetch_array($querylist)){
					$gid=$reclist['a_groupid'];
					if($chkgid!=$gid){
						$chkgid=$gid;
					?>
						<tr>
							<td colspan="3" bgcolor="#DADADA" class="mytext_normal_03">
							<strong><?php if($reclist['ganame']){ echo 'กลุ่ม : '.$reclist['ganame'];}else{ echo 'ไม่มีกลุ่ม';}?></strong>						</td>
						</tr>
					<?php	
					}
				  ?>
				  <tr>
					<td valign="top" bgcolor="#FFFFFF"><?php//php echo $.i;?><img src="mainpic/arrow_r.gif"><a href="<?php echo $reclist['a_url'];?>" target="_blank"><span class="mytext_normal_blue"><strong> <?php echo $reclist['a_site'];?></strong></span></a><?php if($reclist['a_description']){ echo '['.$reclist['a_description'].']';}?>				    </td>
					<td width="17%" align="center" valign="top" bgcolor="#FFFFFF"><a href="address_add.php?process=edit&id=<?php echo $reclist['id'];?>"><img src="mainpic/cal_edit.gif" align="absmiddle" border="0" style="cursor:hand" alt="แก้ไข" >&nbsp;</a>
					<a href="address_function.php?process=delete&id=<?php echo $reclist['id'];?>"><img src="mainpic/b_delete.gif" width="14" height="14" border="0" alt="ลบ" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');"></a></td>
				  </tr>
				  <?php
				  $i++;
					}?>
              <tr>
                <td bgcolor="#FFFFFF"nowrap colspan="2" align="right"><?php echo $text_genaddress_textpage;?>  <?php print CalShowPage($rows, $offset, $startoffset, $limit, $variables);?></td>
              </tr>
				<?php
			  	}else{
			  ?>
              <tr bgcolor="#FFFFFF">
                <td colspan="3"align="center"><font color="#FF0000"><strong><?php echo $text_genaddress_textNodata;?></strong></font></td>
              </tr>
			  <?php
			  	}
			  ?>
            </table>	
	  </form>		
	</td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>