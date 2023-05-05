<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);

$process=$HTTP_POST_VARS['process'];
$allrecord=$HTTP_POST_VARS['allrecord'];
$id=$HTTP_POST_VARS['id'];

?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
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
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666">ระบบจัดเก็บเนื้อหา (Favorites)</font></strong></font></td>
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
      <?php 
	        if($_POST[sesrchtxt]){
			   $search= "AND (f_name like '%".$_POST[sesrchtxt]."%'  OR  f_description  like '%".$_POST[sesrchtxt]."%')";
			}
			$sql="SELECT * FROM n_favorite LEFT OUTER JOIN n_group ON n_favorite.f_groupid = n_group.gid 
			          WHERE n_favorite.gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' $search ORDER BY  n_group.gname,f_name ";
			$query=$db->query($sql);
			$rows=$db->db_num_rows($query);	
			//start ส่วนการคำนวณตัดหน้า
			if($limit == ""){ $limit = 10;} //ทำการกำหนดค่าการแสดงเรกคอร์ดต่อpage
			if (empty($offset) || $offset < 0) { $offset=0; $i=1;}else{$i=$offset+1;}//ทำการกำหนดค่าเริ่มต้นpage
			$sqllist=$sql.CalSplitPage($rows, $offset, $limit);
			// end ส่วนการคำนวณตัดหน้า
			$querylist = $db->query($sqllist);
			$numlist = $db->db_num_rows($querylist);
			?>
 <form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post">
			<input type="hidden" name="process" value="">
			<input type="hidden" name="id" value="">
			<input name="allrecord" type="hidden" value="<?php echo $numlist;?>">

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="mainpic/m_favorites.gif"align="absmiddle"> <font size="3"><strong>รายการโปรด</strong></font></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp; <hr>
    </td>
  </tr>
</table><br>
<table width="60%" border="0" align="center" cellpadding="3" cellspacing="1"  >
	   <tr>
			<td ><strong>คำค้น</strong> <input type="text"  name="sesrchtxt" value="<?php echo $_POST[sesrchtxt];?>"> <input type="submit" value="ค้นหา"></td> 
	  </tr>
</table> 

			<table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
              <tr>
                <td width="6%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong>
                </td>
                <td width="87%" bgcolor="#CCCCCC" align="center"><strong>รายละเอียด</strong></td>
              </tr>
              <?php
				if($numlist>0){
				while($reclist=$db->db_fetch_array($querylist)){
				$gid=$reclist['f_groupid'];
				if($chkgid!=$gid){
					$chkgid=$gid;
				?>
              <tr>
                <td bgcolor="#FFFFFF" colspan="3"><strong>
                  <?php if($reclist['gname']){ echo 'Group : '.$reclist['gname'];}else{ echo 'No Group';}?>
                </strong> </td>
              </tr>
              <?php	
				}
			  ?>
              <tr>
                <td bgcolor="#FFFFFF" align="center" valign="top"><?php echo $i;?>.</td>
                <td bgcolor="#FFFFFF" valign="top"><a href="<?php echo $reclist['f_url'];?>" target="_blank"><?php echo $reclist['f_name'];?><br>
                      <?php echo $reclist['f_description'];?></a></td>
              </tr>
              <?php
			  $i++;
			  	}
			  ?>
              <tr>
                <td bgcolor="#FFFFFF"nowrap colspan="2" align="left">หน้า  <?php print CalShowPage($rows, $offset, $startoffset, $limit, $variables);?></td>
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
