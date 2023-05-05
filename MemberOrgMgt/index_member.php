<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	$db->query("USE ".$_SESSION["EWT_SDB"]);
	$db->write_log("view","member","เข้าสู่ Module การจัดการสมาชิก ");
	$db->query("USE ".$EWT_DB_USER);

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
		<tr> 
			<td height="28" bgcolor="#F3F3EE">
				<table width="100%" border="0" cellspacing="0" cellpadding="1">
					<tr>
						<td width="32"><img src="../theme/main_theme/ewt_logo.gif" width="28" height="28" align="absmiddle" onClick="top.ewt_main.location.href = '../ewt_main.php';"></td>
						<td><?php include("../ewt_menu.php"); ?></td>
						<td width="15" align="right" valign="top"><div align="right"><img src="../images/bar_close.gif" width="15" height="13" border="1" style="border-Color:threedface"  title="Close" onClick="top.ewt_main.location.href = '../ewt_main.php';"></div></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td height="1" bgcolor="#D8D2BD"></td></tr>
		<tr><td height="1" bgcolor="#FFFFFF"></td></tr>
		<tr> 
			<td height="20" bgcolor="#FFFFFF">
				<table width="100%" border="0" cellpadding="1" cellspacing="0">
					<tr> 
						<td align="right">Website : <?php echo $_SESSION["EWT_SUSER"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User : <?php echo $_SESSION["EWT_SMUSER"]; ?>&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
				<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr> 
						<td width="60" height="58"><img src="../theme/main_theme/g_organize_64.gif"> </td>
						<td>
							<span class="ewthead">Organization Management</span>
							<hr width="100%" size="1"  align="left"  color="#D8D2BD">
							
							<?php if($db->check_permission("org","u","")){ ?>
							<span class="ewtsubmenu" ><nobr><a href="MemberList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" border="0" width="16" height="16" align="absmiddle"> ข้อมูลบุคลากร</a></nobr></span>&nbsp;
							
							<!--<span class="ewtsubmenu"><nobr><a href="MemberList_outside.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle">บริหารข้อมูลสมาชิกจากภายนอก</a></nobr></span>&nbsp;-->
							<?php } if($db->check_permission("org","o","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="unitList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> หน่วยงาน</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","p","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="PositionList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> ตำแหน่ง</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","g","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="GroupList_in.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> กลุ่มบุคลากร</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","m","")){ ?>
							<!-- <span class="ewtsubmenu"><nobr><a href="GroupList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle">บริหารกลุ่มบุคคลภายนอก</a></nobr></span>&nbsp;-->
							<span class="ewtsubmenu"><nobr><a href="TitleList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> คำนำหน้าชื่อ</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","l","")){ ?>
							<?php  //if($_SESSION["EWT_SMID"] == "" || $_SESSION["EWT_SMTYPE"] == 'Y'){ ?>
							<span class="ewtsubmenu"><a href="../SiteMgt/lu_main.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> กำหนดหัวหน้า/ลูกน้อง</a></span>&nbsp;
							<?php //} ?>
							
							<?php } if($db->check_permission("org","c","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="ManageOrgPreson.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> แผนผังบุคลากร</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","t","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="site_group.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle">  กลุ่มสิทธิ์</a></nobr></span>&nbsp;
							
							<?php }if($db->check_permission("org","x","")){  ?>
								<?php
						if($_SESSION["EWT_SMID"] != "" || $_SESSION["EWT_SMTYPE"] != 'Y'){ 
						$db->query("USE ".$EWT_DB_USER);
							$sql = "SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_SMID"]."' AND status = '1' ";
							$query = $db->query($sql);
							if($db->db_num_rows($query) > 0){
								$R = $db->db_fetch_array($query);
								$mdiv = $R["org_id"];
							}
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						}
							?>
							<span class="ewtsubmenu"><nobr><a href="<?php if($_SESSION["EWT_SMID"] == "" || $_SESSION["EWT_SMTYPE"] == 'Y'){  ?>managememberperson.php<?php }else{?>managememberperson_list.php?org_id=<?php echo $mdiv;?><?php }?>" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle">  จัดเรียงบุคคลากร</a></nobr></span>&nbsp;
							<?php } ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td height="10" background="../theme/main_theme/bg.gif" bgcolor="#FF3300"></td></tr>
		<tr> 
			<td valign="top" bgcolor="#FFFFFF">
			<?php
			   if($db->check_permission("org","u","")){ $start_page="MemberList.php";
			   }elseif($db->check_permission("org","o","")){$start_page="unitList.php";
			   }elseif($db->check_permission("org","p","")){$start_page="PositionList.php";
			   }elseif($db->check_permission("org","g","")){$start_page="GroupList_in.php";
			   }elseif($db->check_permission("org","m","")){$start_page="TitleList.php";
			   }elseif($db->check_permission("org","l","")){$start_page="../SiteMgt/lu_main.php";
			   }elseif($db->check_permission("org","c","")){$start_page="ManageOrgPreson.php";
			   }elseif($db->check_permission("org","t","")){$start_page="site_group.php";
			   }
			   		if($_GET[url] != ''){
					$start_page = $_GET[url];
					}else{
					$start_page = $start_page;
					}
			?>
				<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
					<tr><td bgcolor="#FFFFFF"><iframe name="iframe_data" src="<?php echo $start_page;?>"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td></tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
<?php
$db->db_close(); ?>