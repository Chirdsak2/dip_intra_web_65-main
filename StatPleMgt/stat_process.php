<?php
session_start();
//include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");

if($_POST[flag] == "add"){

	/*if($_POST['dates'] != ''){
		$date_s = explode('/',$_POST[dates]);
		$start_date = ($date_s[2]-543).'-'.$date_s[1].'-'.$date_s[0];
	}*/
	$date = $_POST[datey]."-".$_POST[datem];
	

	$sql_add = "INSERT INTO stat_population (p_date,p_nthai,p_nother) VALUES ('".$date."','".$_POST[n1]."','".$_POST[n2]."')";
	$db->query($sql_add);

   ?>
      <script language="JavaScript">
		  alert('เพิ่มสถิติเรียบร้อย');
          location.href='main_stat_index.php';
     </script>
   <?php
}

if($_POST[flag] == "edit"){	
	//$date_s = explode('/',$_POST[dates]);
	//$start_date = ($date_s[2]-543).'-'.$date_s[1].'-'.$date_s[0];
	$start_date = $_POST[datey]."-".$_POST[datem];
	
	$sql_edit = "UPDATE stat_population SET p_date='".$start_date."',p_nthai ='".$_POST[n1]."',p_nother= '".$_POST[n2]."' WHERE p_id = '".$_POST[p_id]."' ";
	$db->query($sql_edit);
	
	?>
      <script language="JavaScript">
		  alert('แก้ไขสถิติเรียบร้อย');
          location.href='main_stat_index.php';
     </script>
   <?php

}

if($_GET[flag] == 'del'){
	$sql_del1 = "DELETE FROM stat_population WHERE p_id = '".$_GET[p_id]."' ";
	$db->query($sql_del1);
		?>
      <script language="JavaScript">
		  alert('ลบสถิติเรียบร้อย');
          location.href='main_stat_index.php';
     </script>
   <?php
	
}


$db->db_close(); ?>
