<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$_SESSION["EWT_SMID"] = $_SESSION["EWT_MID"];
$sql_site = $db->query("SELECT site_intra FROM user_info WHERE EWT_User = '".$EWT_FOLDER_USER."'  ");
$intra = $db->db_fetch_row($sql_site);
?>
<html>
<head>
<title>My Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="1">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right"><a href="#logout" onClick="if(confirm('ยืนยันออกจากระบบ')){self.location.href='logout.php';}"><img src="mainpic/close.gif" width="24" height="24" align="absmiddle" border="0"> 
                        ออกจากระบบ</a> </td>
                    </tr>
                  </table>
                  <br>
                  <table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666">My 
                        Website :</font> <?php echo $_SESSION["EWT_NAME"]; ?></strong></font></td>
                    </tr>
                  </table>
                  <br>
                  <br><table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr align="center" valign="top">
    <td width="50%">
                        <table width="70%" border="0" cellpadding="0" cellspacing="1" bgcolor="A9A9E0">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#DBDBF2">
                    <tr>
                                  <td bgcolor="#EEEEF9"><strong>: : Website</strong></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><a href="index.php"><img src="mainpic/m_home.gif" width="24" height="24" border="0" align="absmiddle"> Back 
                        to home page</a></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><a href="main3.php?filename=index"><img src="mainpic/m_custom.gif" width="24" height="24" border="0" align="absmiddle"> 
                        Customize your home page</a></td>
                    </tr>
					<tr> 
                                  <td bgcolor="#FFFFFF"><a href="sendprnews.php" target="_blank"><img src="mainpic/m_message.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบฝากข่าวประชาสัมพันธ์</a>
</td>
                                </tr>
					<tr>
                      <td height="10" bgcolor="#FFFFFF"></td>
                    </tr>
                  </table></td>
                          </tr>
                        </table><br><table width="70%" border="0" cellpadding="0" cellspacing="1" bgcolor="A9A9E0">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#DBDBF2">
                     <tr>
                                  <td bgcolor="#EEEEF9"><strong>: : Profile</strong></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><a href="frm_gen_user_edit.php"><img src="mainpic/m_profile.gif" width="24" height="24" border="0" align="absmiddle"> 
                        Edit Profile</a></td>
                    </tr>
					<tr>
                      <td height="10" bgcolor="#FFFFFF"></td>
                    </tr>
                  </table></td>
                          </tr>
                        </table><br>
												<?php
						$pass = "0";
		$reccount1 = $db->db_fetch_row($db->query("SELECT COUNT(permission.p_id) as ccs FROM permission WHERE ( p_type = 'U' AND pu_id = '".$_SESSION["EWT_MID"]."' ) AND permission.s_type = 'asset' "));
		if($reccount1[0] > 0){
			$site1 = "p";
			$pass = "1";
		}
				$reccount2 = $db->db_fetch_row($db->query("SELECT org_id FROM gen_user Where  gen_user_id= '".$_SESSION["EWT_MID"]."' "));
		if($reccount2[0] == '0'){
			$site1 = "";
			$pass = "0";
		}else{
			$site2 = "p";
			$pass = "1";
		}
						?>
						<?php
						if((@include("../blog/lib/blog_config.php")) AND ($site2 == "p")){
						?>
<table width="70%" border="0" cellpadding="0" cellspacing="1" bgcolor="A9A9E0">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#DBDBF2">
                   <tr>
                                  <td bgcolor="#EEEEF9"><strong>: : Blog</strong></td>
                    </tr>
					<?php
		$sql_profile="SELECT * FROM `blog_list` WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";
		$exc_profile=$db->query($sql_profile);
		$count_profile=$db->db_num_rows($exc_profile);
		if($count_profile > 0){
		while($row_profile=$db->db_fetch_array($exc_profile)){
						$photo_name="nophoto.jpg";
				if($row_profile[blog_picture]){
					$photo_name= $row_profile[blog_picture];
				}
					?>
                    <tr>
                                  <td bgcolor="#FFFFFF"><a href="<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank"><img src="phpThumb.php?src=../blog/images_profile/<?php echo $photo_name; ?>&h=120&w=120" border="0" align="absmiddle" > <?php echo $row_profile[blog_title]; ?></a></td>
                    </tr>
					<?php }}else{ ?>
					<tr>
                                  <td bgcolor="#FFFFFF"><a href="<?php echo $blog_url; ?>blog_install.php"><img src="mainpic/m_blog.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    Create Your Blog</a></td>
                    </tr>
					<?php } ?>
					<tr>
                      <td height="10" bgcolor="#FFFFFF"></td>
                    </tr>
                  </table></td>
                          </tr>
                        </table><br>
						<?php } ?>
                        
                        <table width="70%" border="0" cellpadding="0" cellspacing="1" bgcolor="A9A9E0">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#DBDBF2">
						   <tr>
										  <td bgcolor="#EEEEF9"><strong>: : E-newslatter </strong></td>
							</tr>
                          <tr>
                            <td bgcolor="#FFFFFF">
							<img src="mainpic/mail2.gif" width="24" height="24" border="0" align="absmiddle">
							<?php
							//$ewt_email = 'tatorera@hotmail.com';
							$sql_user = "select email_person from gen_user where gen_user_id ='".$_SESSION["EWT_MID"]."'";
							$query_user = $db->query($sql_user);
							$rec_user = $db->db_fetch_array($query_user);
							$db->query("USE ".  $EWT_DB_NAME);
							if($rec_user[email_person] != ''){
									$sql_enews = "select * from n_member where m_email ='".$rec_user[email_person]."'";
									$query_enews = $db->query($sql_enews);
									
								if($db->db_num_rows($query_enews)>0){ 
								?>&nbsp; <a href="#d" onClick="window.open('newsletter_edit.php','','width=500 , height=300, scrollbars=1,resizable=1');">บริหารกจดหมายข่าว</a><br>
								<img src="mainpic/mail_del.gif" width="24"  border="0" align="absmiddle">
								&nbsp; <a href="newsletter_edit.php?del_new=Y" target="funcas" 
								onClick="return confirm('ยืนยันการยกเลิกจดหมายข่าว')"><font color=red>ยกเลิกจดหมายข่าว</font></a></font>
								<?php
								}else{ 
								?>&nbsp; <a href="#d" onClick="window.open('newsletter_add.php','','width=500 , height=300, scrollbars=1,resizable=1');">สมัครจดหมายข่าว</a><?php 
								}
							}else{
								?>
								&nbsp;&nbsp;<font color=red>ท่านยังไม่มี email ค่ะ<br>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(กรุณาแก้ไขที่ <a href="frm_gen_user_edit.php">Edit profile</a> )</font>
								<?php
							}
							$db->query("USE ".$EWT_DB_USER);
							
							?>
							</td>
                          </tr>
                          <tr>
                            <td bgcolor="#FFFFFF"><iframe name="funcas" width="0" height="0" scrolling="no"></iframe></td>
                          </tr>
                        </table></td></tr></table></td>
    <td width="50%">
<table width="70%" border="0" cellpadding="0" cellspacing="1" bgcolor="A9A9E0">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#DBDBF2">
                                <tr> 
                                  <td bgcolor="#EEEEF9"><strong>: : Tools</strong></td>
                                </tr>
								<?php
								if($site2 == "p"){
								?>
                                <tr> 
                                  <td bgcolor="#FFFFFF"><a href="message.php" target="_blank"><img src="mainpic/m_message.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบข้อความ</a>
<?php
$sql_new="SELECT COUNT(id) as newmail FROM n_message 
WHERE m_to = '".$HTTP_SESSION_VARS['EWT_MID']."' 
AND m_flaginout = '1' 
AND m_flagdel='0'  
AND m_flagnewold = '1'
";
$query_new=$db->query($sql_new);
$data_new=$db->db_fetch_array($query_new) ;
echo '(่'.$data_new[newmail].' ข้อความไม่ได้อ่าน)';
?>

</td>
                                </tr>
								<?php } ?>
                                <tr> 
                                  <td bgcolor="#FFFFFF"><a href="favorite.php" target="_blank"><img src="mainpic/m_favorites.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจัดเก็บเนื้อหา (Favorites)</a></td>
                                </tr>
                                <tr> 
                                  <td bgcolor="#FFFFFF"><a href="address.php" target="_blank"><img src="mainpic/m_address.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจัดเก็บ Address</a></td>
                                </tr>
                                <tr> 
                                  <td bgcolor="#FFFFFF"><a href="contact_index.php" target="_blank"><img src="mainpic/m_contact.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบ Contact</a></td>
                                </tr>
								  <tr> 
                                  <td bgcolor="#FFFFFF"><a href="ecard_index.php" target="_blank"><img src="mainpic/mail2.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบส่ง E-card</a></td>
                                </tr>
                                <tr> 
                                  <td height="10" bgcolor="#FFFFFF"></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table><br>
								<?php
								if($pass == "1" AND $EWT_FOLDER_USER == "dmr_web"){
								?>
						<table width="70%" border="0" cellpadding="0" cellspacing="1" bgcolor="A9A9E0">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#DBDBF2">
                                <tr> 
                                  <td bgcolor="#EEEEF9"><strong>: : Application</strong></td>
                                </tr>
								<?php
								if($site1 == "p" AND $intra[0] == "Y"){
								?>
                                <tr> 
                                  <td bgcolor="#FFFFFF"><a href="../w2/asset/Synchronize.php" target="_blank"><img src="mainpic/m_asset.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจัดการทรัพย์สิน</a></td>
                                </tr>
								<?php
								}
								if($site2 == "p"){
								?>
                                <tr> 
                                  <td bgcolor="#FFFFFF"><a href="../w2/monitoring/Synchronize.php" target="_blank"><img src="mainpic/m_task.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจัดการงานที่รับผิดชอบ</a></td>
                                </tr>
								<?php } ?>
								<?php
								if($site2 == "p" AND $intra[0] == "Y"){
								?>
                                <tr> 
                                  <td bgcolor="#FFFFFF"><a href="../w2/reserve/Synchronize.php" target="_blank"><img src="mainpic/m_borrow.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจอง ยืม คืน อุปกรณ์</a></td>
                                </tr>
								<?php } ?>
                                <tr> 
                                  <td height="10" bgcolor="#FFFFFF"></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table>
						<?php } ?><br>
						
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
