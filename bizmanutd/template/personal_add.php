<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title>Add To Favorite</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet"  href="css/style.css" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<table width="90%" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td>
		<br>
			<form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post">
			<table width="80%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
			  <tr bgcolor="#FFFFFF">
				<td colspan="2"><strong>Search</strong></td>
			  </tr>
			  <tr bgcolor="#FFFFFF">
				<td width="6%"><strong>Name : </strong></td>
				<td width="94%"><input type="text" name="sname" value="<?php echo $sname;?>" size="30"></td>
			  </tr>
			  <tr bgcolor="#FFFFFF">
				<td><strong>Surname :</strong></td>
				<td><input type="text" name="ssurname" value="<?php echo $ssurname;?>" size="30"></td>
			  </tr>
			  <tr bgcolor="#FFFFFF">
				<td align="center" colspan="2"><input type="submit" name="submit" value="search"> <input type="reset" name="reset" value="cancel"></td>
			  </tr>
			</table>
			</form>
		<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
		  <tr bgcolor="#FFFFFF">
			<td colspan="3"><strong>List Name</strong></td>
		  </tr>
		  <?php
		  		$wh='';
		  		if($sname){
					$wh.="AND name_thai LIKE '%".$sname."%'";
				}
		  		if($ssurname){
					$wh.="AND surname_thai LIKE '%".$ssurname."%'";
				}
				$sql="SELECT gen_user_id,title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id!='' $wh";
				$query=$db->query($sql);
				$rows=$db->db_num_rows($query);
				//start ส่วนการคำนวณตัดหน้า
				if($limit == ""){ $limit = 15;} //ทำการกำหนดค่าการแสดงเรกคอร์ดต่อpage
				if (empty($offset) || $offset < 0) { $offset=0; }//ทำการกำหนดค่าเริ่มต้นpage
				$sqllist=$sql.CalSplitPage($rows, $offset, $limit);
				// end ส่วนการคำนวณตัดหน้า
				$querylist = $db->query($sqllist);
				$numlist = $db->db_num_rows($querylist);
			
			?>
			<form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post">
			<input type="hidden" name="process" value="">
			<input type="hidden" name="id" value="">
			<input name="allrecord" type="hidden" value="<?php echo $rows;?>">
		  <tr bgcolor="#FFFFFF">
			<td width="2%" align="center">
			<strong>เลือก</strong>
			</td>
			<td width="98%" align="center"><strong>Name - Surname</strong></td>
		  </tr>
		  <?php echo $row;
			if($rows > 0){
			$i=1;
					while($reclist=$db->db_fetch_array($querylist)){
				  ?>
				  <tr bgcolor="#FFFFFF">
					<td align="center">
					<img src="mainpic/arrow_left_blue.gif" border="0" align="absmiddle" alt="เลือก" width="20"
					onClick="  
					opener.form1.m_to.value  = '<?php echo $reclist['gen_user_id']?>';
					opener.form1.m_name.value  = '<?php echo $reclist['title_name'].$reclist['name_thai'].' '.$reclist['surname_thai']; ?>';
					window.close();
					"
					>
					</td>
					<td>&nbsp;&nbsp;<?php echo $reclist['title_name'].$reclist['name_thai'].' '.$reclist['surname_thai']; ?></td>
				  </tr>
					  <?php
					  $i++;
						}
						?>
              <tr>
                <td bgcolor="#FFFFFF" align="center"></td>
                <td bgcolor="#FFFFFF" colspan="2" align="right"nowrap>หน้า  <?php print CalShowPage($rows, $offset, $startoffset, $limit, $variables);?></td>
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
		  </form>
		</table>
	</td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
