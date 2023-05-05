<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_GET["Flag"] == "SETDEL"){
				$sqlchk = $db->query("DELETE FROM web_group_member WHERE ug_id = '".$_SESSION["EWT_SUID"]."' AND ugm_type = '".$_GET["mtype"]."' AND ugm_tid = '".$_GET["mid"]."' ");
				$sqlchk = $db->query("DELETE FROM permission WHERE UID = '".$_SESSION["EWT_SUID"]."' AND p_type = '".$_GET["mtype"]."' AND pu_id = '".$_GET["mid"]."' ");
				?>
				<script language="JavaScript">
				window.location.href = "ewt_permission0.php";
				</script>
				<?php
				exit;
}
if($_SESSION["EWT_SMID"] != ""){
	$sql = $db->query("SELECT * FROM leader_list WHERE leader_id = '".$_SESSION["EWT_SMID"]."' ORDER BY under_id ASC");
}else{
//echo "SELECT * FROM web_group_member WHERE ug_id = '".$_GET["UID"]."' ORDER BY ugm_type ASC";
	$sql = $db->query("SELECT * FROM web_group_member WHERE ug_id = '".$_SESSION["EWT_SUID"]."' ORDER BY ugm_type ASC");
}

	function level_name($L,$id){
	global $db;
		if($L == "A"){
			echo "<img src=\"../images/user_a.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT emp_type_name FROM emp_type WHERE emp_type_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "D"){
			echo "<img src=\"../images/user_group.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_org FROM org_name WHERE org_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "L"){
			echo "<img src=\"../images/user_c.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT ul_name FROM user_level WHERE ul_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "P"){
			echo "<img src=\"../images/user_pos.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT position_name.pos_name FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.up_id = '".$id."' ORDER BY user_position.up_rank ASC ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "U"){
			echo "<img src=\"../images/user_logo.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_thai,surname_thai,gen_user FROM gen_user WHERE gen_user_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0]." ".$R[1]." (".$R[2].")";
		}
	}
	function show_permission($type,$id){
	global $db,$EWT_DB_USER;
	echo "<ul>";
			$sql_sadmin = $db->query("SELECT * FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'suser' ");
	if($db->db_num_rows($sql_sadmin) > 0){
			echo "<li>Super admin</li>";
	}else{
	$sql_p = $db->query("SELECT web_permission.p_name,web_permission.p_code,web_permission.p_type FROM permission INNER JOIN web_permission ON permission.s_type = web_permission.p_code AND permission.s_permission = web_permission.p_type WHERE permission.p_type = '".$type."' AND permission.pu_id = '".$id."' AND permission.UID = '".$_SESSION["EWT_SUID"]."'  GROUP BY web_permission.p_name ORDER BY web_permission.p_id");
	
		while($PP = $db->db_fetch_row($sql_p)){
			echo "<li> ".$PP[0]."</li>";
			    // cms w
				if($PP[1] == "cms" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'w' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'w' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT Main_Group_Name FROM temp_main_group WHERE Main_Group_ID = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// cms a
				if($PP[1] == "cms" AND $PP[2] == "a"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'a' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'a' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT Main_Group_Name FROM temp_main_group WHERE Main_Group_ID = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// art w
				if($PP[1] == "art" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'w' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'w' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT c_name FROM article_group WHERE c_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				//art a
				if($PP[1] == "art" AND $PP[2] == "a"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'a' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'a' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT c_name FROM article_group WHERE c_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
					//img and dl
				if(($PP[1] == "img" or $PP[1] == "dl") AND $PP[2] == "w"){
				if($PP[1] == "img" ){
				$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'imgFo' AND s_permission = 'w' AND s_id = '0' and s_name = '0'");
				}else if($PP[1] == "dl"){
				$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'dlFo' AND s_permission = 'w' AND s_id = '0' and s_name = '0'");
				}
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>Folder all</li></ul>";
					}else{
						if($PP[1] == "img"){
							$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";
						}else if($PP[1] == "dl"){
						$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download";
						}

							$folder = base64_decode($_REQUEST["myfolder"]);
							
							$Current_Dir = $Globals_Dir."/".$folder;
							//echo $Current_Dir;
							if (!(file_exists($Current_Dir))) {
							
							$Current_Dir = $Globals_Dir;
							}
							$array_folder = array();
							$objFolder = opendir($Current_Dir);
							rewinddir($objFolder);
							$f = 0;
										  while($file = readdir($objFolder)){
											  if(!(($file == ".") or ($file == "..") or ($file == "Thumbs.db") )){
											  $FT= filetype($Current_Dir."/".$file);
												  if($FT == "dir"){
												  array_push ($array_folder,$file);
												  }else{
												  $array_file[$f][0] = $file;
												$f++;
												  }
											  }
										  }
										  closedir($objFolder);
							 $numfolder = count($array_folder);
							 for($y=0;$y<$numfolder;$y++){
								if($folder != ""){
								$preview_path = $folder."/".$array_folder[$y];
								}else{
								$preview_path = $array_folder[$y];
								}
								$preview_path_en = base64_encode($preview_path);
								if($PP[1] == "img" ){
								 $sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'imgFo' AND s_permission = 'w' AND s_id = '0' AND s_name = '".$array_folder[$y]."' ",$EWT_DB_USER);
								}else if($PP[1] == "dl"){
								$sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'dlFo' AND s_permission = 'w' AND s_id = '0' AND s_name = '".$array_folder[$y]."' ",$EWT_DB_USER);
								}
									if($db->db_num_rows($sql_sadmin) > 0){
										echo "<ul><li>".$array_folder[$y]."</li></ul>";
									}else{
										
									}
								}
							}
						}
				//Gallery w
					if($PP[1] == "Gallery" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Gg' AND s_permission = 'w' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Gg' AND s_permission = 'w' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT category_name FROM gallery_category WHERE category_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				//menu
				if($PP[1] == "menu" AND $PP[2] == "w"){
					    $sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'menu' AND s_permission = 'w' AND s_name = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					     echo "<ul><li>ทุกเมนู</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_name FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'menu'  ");
					//echo "SELECT s_name FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'menu'  ";
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT m_name FROM menu_list WHERE m_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>ดีไซน์ ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				
				// site design
				if($PP[1] == "sdes" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'sdes' AND s_permission = 'm' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'sdes' AND s_permission = 'm' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT d_name FROM design_list WHERE d_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>template ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// download management
				if($PP[1] == "dlmgt" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'dlmgt' AND s_permission = 'm' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'dlmgt' AND s_permission = 'm' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT dlg_name FROM docload_group WHERE dlg_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// calendar
				if($PP[1] == "calendar" AND $PP[2] == "w"){
					    $sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'calendar' AND s_permission = 'a' AND s_name = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					     echo "<ul><li>ทุกเมนู</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'calendar'  ");
					//echo "SELECT s_name FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'menu'  ";
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT cat_name FROM cal_category WHERE cat_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				//end check
		}
		}
		echo "</ul>";
	}
	
include("../lib/config_path.php");
include("../header.php");	
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
</head>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>

<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">รายชื่อลูกน้อง</span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
	<?php if($_SESSION["EWT_SMTYPE"] == "Y" && $_SESSION["EWT_SMID"] == ''){ ?><a href="#g" onClick="win4=window.open('ewt_adds_member.php?ug=<?php echo $_GET["UID"]; ?>','usersq','width=650,height=400,scrollbars=1,resizable=1');win4.focus();"><img src="../theme/main_theme/g_add.gif" border="0" align="middle"> เพิ่มผู้ใช้งาน </a><?php } ?>
<hr>
    </td>
  </tr>
</table>-->



<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?="รายชื่อผู้มีสิทธิ์ใช้งานระบบ" ;?></h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12"></div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >

<!--<a href="banner_add.php?flag=add&banner_gid=<?php echo $banner_gid;?>" target="_self">
<img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php //echo $text_genbanner_addnew;?>
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?=$text_genbanner_addnew;?>
</button>	  	  
</a> &nbsp;-->
<?php if($_SESSION["EWT_SMTYPE"] == "Y" && $_SESSION["EWT_SMID"] == ''){ ?>
<a href="#g" onClick="win4=window.open('ewt_adds_member.php?ug=<?php echo $_GET['UID']; ?>','usersq','width=650,height=500,scrollbars=1,resizable=1');win4.focus();">
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;<?="เพิ่มผู้ใช้งานระบบ";?>
</button>
</a>
<?php } ?>

</div>
</div>
</div>	
<div class="clearfix">&nbsp;</div>

<table width="100%" class="table table-bordered">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <th width="10%" style="text-align:center;">&nbsp;</th>
    <th width="45%" style="text-align:center;">ชื่อ - สกุล</th>
    <th width="45%" style="text-align:center;">สิทธิ์</th>
  </tr>
  <?php
 $i=0;
 if($db->db_num_rows($sql) > 0){
  while($U = $db->db_fetch_array($sql)){
 if($_SESSION["EWT_SMID"] != ""){
  $U["ugm_tid"] = $U["under_id"];
  $U["ugm_type"] = "U";
  $U["ugm_id"] = "";
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center" valign="top">
	<nobr>
	<a href="#123" onClick="self.location.href='ewt_permission1.php?mid=<?=$U['ugm_tid']; ?>&mtype=<?=$U['ugm_type']; ?>';">
	<img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" title="กำหนดสิทธิ์"></a></nobr>
	&nbsp;
	<img src="../theme/main_theme/g_del.gif" width="16" height="16" onClick="if(confirm('Are you sure to remove this person ?')){ self.location.href='ewt_permission0.php?Flag=SETDEL&mid=<?php echo $U["ugm_tid"]; ?>&mtype=<?php echo $U["ugm_type"]; ?>'; }">
	</td>
    <td valign="top"> 
      <?php level_name($U["ugm_type"],$U["ugm_tid"]); ?> 
    </td>
    <td valign="top"><?php
	show_permission($U["ugm_type"],$U["ugm_tid"]);
	?></td>
  </tr>
  <?php }}else{ ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="30" colspan="3" align="center"><font color="#FF0000">ไม่มีข้อมูลลูกน้อง</font></td>
  </tr>
  <?php } ?>
</table>

</div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
<?php
$db->db_close(); ?>