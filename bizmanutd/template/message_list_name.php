<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

$code=$_POST[code];
if($code=='')$code=$_GET[code];
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet"  href="css/style.css" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<?php
if($Flag=='add'){

}else{
?>
<form name="form2" enctype="multipart/form-data" method="post" action="message_list_name.php">
<input name="code" type="hidden" id="code" value="<?php echo $code; ?>"> 
			<table width="99%" border="0" cellspacing="1" cellpadding="1" align="center">
					  <tr bgcolor="#CCCCCC">
						<td  height="25" align="center"><strong><font size="3">รายชื่อผู้รับ</font></strong></td>
					  </tr>
			</table>
<?php 
								$i=0;
                                $where=''; 
								$schStr=$_POST[schStr]; 
								if($schStr==''){
									$schStr=$_GET[schStr];
								}
?>
			<table width="99%" border="0" cellspacing="1" cellpadding="1" bgcolor="#999999" align="center">
				<tr> 
					<td >ค้นหา :  <input type="text" name="schStr" value="<?php echo $schStr?>"> <input type="submit" value="ค้นหา" ></td> 
				</tr>
			</table>
</form>

<form name="form1" enctype="multipart/form-data" method="post" action="message_function_name.php">
		<input name="code" type="hidden" id="code" value="<?php echo $code; ?>"> 
		<input name="Flag" type="hidden" id="Flag" value="add">
		<table width="99%" border="0" cellspacing="1" cellpadding="1" bgcolor="#999999" align="center">
                              <?php 
								$i=0;
                                $where=''; 
                                if($schStr!=''){ 
									$schStr=htmlspecialchars(stripslashes($schStr),ENT_QUOTES);
                                    $where=" AND (name_thai like '%$schStr%'  OR  surname_thai like '%$schStr%') ";
                                }

$sqluser1="SELECT gen_user_id,title.title_thai AS title_name,name_thai,surname_thai 
			  FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id 
			 WHERE gen_user_id<>''  $where ";

$queryuser1=$db->query($sqluser1);
$numuser1=$db->db_num_rows($queryuser1);

$limits = 15;
if(!$page)$page=1;
$start=($page-1)*$limits;
$maxpage=floor($numuser1/$limits);
if($numuser1%$limit)$maxpage++;


								$sqluser="SELECT gen_user_id,title.title_thai AS title_name,name_thai,surname_thai 
                                              FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id 
											 WHERE gen_user_id<>''  $where
                                             ORDER BY  name_thai limit $start,$limits";

								$queryuser=$db->query($sqluser);
								$numuser=$db->db_num_rows($queryuser);

								if($numuser>0){
									while($recuser=$db->db_fetch_array($queryuser)){
										$sqltemp="SELECT temp_gen_user_id FROM n_temp_user WHERE temp_gen_user_id = '".$recuser['gen_user_id']."' AND tempcode ='".$code."'";
											$querytemp=$db->query($sqltemp);
											$numtemp=$db->db_num_rows($querytemp);
								  ?>
								  <tr bgcolor="#FFFFFF">
									<td width="2%" align="center">
									<input type="checkbox" name="chksend[<?php echo $i;?>]" value="<?php echo $recuser['gen_user_id'];?>" <?php if($numtemp>0){ echo 'checked';}?>>
									<input type="hidden" name="chkid[<?php echo $i;?>]" value="<?php echo $recuser['gen_user_id'];?>"></td>
									<td width="98%">&nbsp;&nbsp;<?php echo $recuser['title_name'].$recuser['name_thai'].' '.$recuser['surname_thai']; ?></td>
								  </tr>
								  <?php $i++; 
								  }
?>
								<tr bgcolor="#FFFFFF"> 
									 <td  colspan="2">หน้า : 
											<?php
											for($i=1;$i<$page;$i++){?><a href="message_list_name.php?page=<?php echo $i?>&schStr=<?php echo $schStr?>&code=<?php echo $code;?>"><?php echo $i?> </a><?php }
											echo '<b><font color="#FF0000">'.$page.'</font></b>';
											for($i=$page+1;$i<=$maxpage;$i++){?><a href="message_list_name.php?page=<?php echo $i?>&schStr=<?php echo $schStr?>&code=<?php echo $code;?>"> <?php echo $i?></a><?php }
											?>
									</td>
								  </tr>
			<?php  }else{?>
								<tr bgcolor="#FFFFFF">
										<td width="2%" align="center" colspan="2"><font color="#FF0000"><strong>ไม่พบข้อมูล</strong></font>	</td>
								</tr>
			<?php }?>
		</table>
     </form> 
	<input type="button" name="Submit43" value="เลือกผู้รับ" onClick="document.form1.submit()">
<?php }?>
</body>
</html>
<?php  $db->db_close(); ?>
