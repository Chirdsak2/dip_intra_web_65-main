<?php
include("lib/permission.php");
include("lib/include.php");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");


if($_POST["hdd_flag"] == 'site_contact'){

$sql_contact = "SELECT * FROM contact ";
$result = $db->query($sql_contact);
$total = $db->db_num_rows($result);

if($total){
	
if($_POST['fa'] == 'Y'){

$T1 = $_POST['fa'].$_POST['contact_other_fa'];	
	
}

if($_POST['tw'] == 'Y'){

$T2 = $_POST['tw'].$_POST['contact_other_tw'];

}

if($_POST['yt'] == 'Y'){
	
$T3 = $_POST['yt'].$_POST['contact_other_yt'];

}

$value = $T1."#@#".$T2."#@#".$T3;	
	
	
$sql_update ="UPDATE contact SET  
				contact_name = '".stripslashes(htmlspecialchars($_POST["contact_name"],ENT_QUOTES))."',
				contact_address ='".$_POST["contact_address"]."',
				contact_tel = '".$_POST["contact_tel"]."',
				contact_off_number = '".$_POST["contact_off_number"]."',
				contact_fax = '".$_POST["contact_fax"]."',
				contact_email = '".$_POST["contact_email"]."' ,
				contact_line = '".$_POST["contact_line"]."',
				contact_map = '".$_POST["contact_map"]."',
				contact_other = '".$value."',
				contact_status = '".$_POST["contact_status"]."'				
				WHERE contact_id = '".$_POST["hdd_site_info_id"]."' ";
$db->query($sql_update);




}else{

if($_POST['fa'] == 'Y'){

$T1 = $_POST['fa'].$_POST['contact_other_fa'];	
	
}

if($_POST['tw'] == 'Y'){

$T2 = $_POST['tw'].$_POST['contact_other_tw'];

}

if($_POST['yt'] == 'Y'){
	
$T3 = $_POST['yt'].$_POST['contact_other_yt'];

}

$value = $T1."#@#".$T2."#@#".$T3;

$sql_intsert_list = "INSERT INTO `contact` (
										`contact_name`,
										`contact_address`,
										`contact_tel`,
										`contact_off_number`,
										`contact_fax`,
										`contact_email`,
										`contact_line`,
										`contact_map`,
										`contact_other`,
										`contact_status`,
										`contact_create_date`
										) 
										VALUES (
												'{$_POST['contact_name']}',
												'{$_POST['contact_address']}',
												'{$_POST['contact_tel']}',
												'{$_POST['contact_off_number']}',
												'{$_POST['contact_fax']}',
												'{$_POST['contact_email']}',
												'{$_POST['contact_line']}',
												'{$_POST['contact_map']}',
												'{$value}',
												'{$_POST['contact_status']}',
												NOW( )
												)";
$db->query($sql_intsert_list);

}	
?>
<script language="JavaScript">
alert("แก้ไขข้อมูลเรียบร้อย");
self.location.href = "ewt_info_contact.php";
</script>
<?php	
	
}


if($_POST["hdd_flag"] == 'site_info'){
$sql_update ="update site_info set  site_info_title = '".stripslashes(htmlspecialchars($_POST["txt_title"],ENT_QUOTES))."',
																		site_info_keyword ='".stripslashes(htmlspecialchars($_POST["txt_keyword"],ENT_QUOTES))."',
																		site_info_description = '".stripslashes(htmlspecialchars($_POST["txt_desc"],ENT_QUOTES))."',
																		site_info_max_img = '".stripslashes(htmlspecialchars($_POST["txt_max_Img"],ENT_QUOTES))."',
																		site_info_max_file = '".$_POST["txt_max_file"]."',
																		set_countor = '".$_POST["txtcountor"]."' ,
																		site_top = '".stripslashes($_POST["txttop"])."',
																		site_bottom = '".stripslashes($_POST["txtbottom"])."',
																		site_type_file = '".$_POST["type_file"]."',
																		site_type_img_file = '".$_POST["type_img_file"]."'
																		where site_info_id = '".$_POST["hdd_site_info_id"]."'";
$db->query($sql_update);
//set url
//if(!empty($_POST["txt_url"])){
$db->query("USE ".$EWT_DB_USER);
$sql_update_user = "update user_info set url = '".stripslashes(htmlspecialchars($_POST["txt_url"],ENT_QUOTES))."' where UID = '".$_SESSION["EWT_SUID"]."'";//,Email = '".stripslashes(htmlspecialchars($_POST["txt_email"],ENT_QUOTES))."'
$db->query($sql_update_user);
$db->query("USE ".$EWT_DB_NAME);
//}
$db->write_log("update","site properties","ปรับปรุงหน้า site properties");
?>
<script language="JavaScript">
alert("แก้ไขข้อมูลเรียบร้อย");
self.location.href = "ewt_info_site.php";
</script>
<?php
}
if($_POST["hdd_flag"] == 'ftp_setting'){
$sql_update ="update site_info set  site_info_host = '".stripslashes(htmlspecialchars($_POST["txt_host"],ENT_QUOTES))."',
																		site_info_user ='".stripslashes(htmlspecialchars($_POST["txt_user"],ENT_QUOTES))."',
																		site_info_pass = '".stripslashes(htmlspecialchars($_POST["txt_pass"],ENT_QUOTES))."',
																		site_info_path = '".stripslashes(htmlspecialchars($_POST["txt_path"],ENT_QUOTES))."'
																		where site_info_id = '".$_POST["hdd_site_info_id"]."'";
$db->query($sql_update);
$db->write_log("update","site properties","ปรับปรุงหน้า  ftp_setting");
}	
if($_POST["hdd_flag"] == 'interface_setting'){
if(stripslashes(htmlspecialchars($_POST["lang"],ENT_QUOTES))==''){
//@copy('language/lang_th/language.php','ewt/'.$EWT_FOLDER_USER.'/language/language.php');
}else if(stripslashes(htmlspecialchars($_POST["lang"],ENT_QUOTES))=='1'){
//@copy('language/lang_en/language.php','ewt/'.$EWT_FOLDER_USER.'/language/language.php');
}
$sql_update ="update site_info set  site_language = '".stripslashes(htmlspecialchars($_POST["lang"],ENT_QUOTES))."',
																		font_face ='".stripslashes(htmlspecialchars($_POST["AMHeadF"],ENT_QUOTES))."',
																		font_size = '".stripslashes(htmlspecialchars($_POST["AMBottomS"],ENT_QUOTES))."',
																		font_type = '".stripslashes(htmlspecialchars($_POST["typefont"],ENT_QUOTES))."',
																		font_color = '".stripslashes(htmlspecialchars($_POST["color_set"],ENT_QUOTES))."',
																		font_B = '".stripslashes(htmlspecialchars($_POST["c_b"],ENT_QUOTES))."',
																		font_i = '".stripslashes(htmlspecialchars($_POST["c_i"],ENT_QUOTES))."',
																		font_faceH ='".stripslashes(htmlspecialchars($_POST["AMHeadFH"],ENT_QUOTES))."',
																		font_sizeH = '".stripslashes(htmlspecialchars($_POST["AMBottomSH"],ENT_QUOTES))."',
																		font_typeH = '".stripslashes(htmlspecialchars($_POST["typefontH"],ENT_QUOTES))."',
																		font_colorH = '".stripslashes(htmlspecialchars($_POST["color_setH"],ENT_QUOTES))."',
																		font_BH = '".stripslashes(htmlspecialchars($_POST["c_bH"],ENT_QUOTES))."',
																		font_iH = '".stripslashes(htmlspecialchars($_POST["c_iH"],ENT_QUOTES))."'
																		where site_info_id = '".$_POST["hdd_site_info_id"]."'";
$db->query($sql_update);
//gen css
if(stripslashes(htmlspecialchars($_POST["c_b"],ENT_QUOTES))=='1'){
$b = 'font-weight: bold;';
}
if(stripslashes(htmlspecialchars($_POST["c_bH"],ENT_QUOTES))=='1'){
$bH = 'font-weight: bold;';
}
if(stripslashes(htmlspecialchars($_POST["c_i"],ENT_QUOTES))=='1'){
$i = 'font-style: italic;';
}
if(stripslashes(htmlspecialchars($_POST["c_iH"],ENT_QUOTES))=='1'){
$iH = 'font-style: italic;';
}
$filename = 'ewt/'.$EWT_FOLDER_USER.'/css/interface.css';
$text .='.text_normal {';
if($_POST["AMBottomS"] != ''){
$text .= 'FONT-SIZE: '.stripslashes(htmlspecialchars($_POST["AMBottomS"],ENT_QUOTES)).stripslashes(htmlspecialchars($_POST["typefont"],ENT_QUOTES)).'; MARGIN: 0px; ';
}
if($_POST["color_set"] != ''){
$text .= ' COLOR: '.stripslashes(htmlspecialchars($_POST["color_set"],ENT_QUOTES)).';';
}
$text .= $b.$i;
if($_POST["AMHeadF"] != ''){
$text .= ' FONT-FAMILY: "'.stripslashes(htmlspecialchars($_POST["AMHeadF"],ENT_QUOTES)).'";';
}
$text .= '}'."\n";

$text .='.text_head {';
if($_POST["AMBottomSH"] != ''){
$text .= 'FONT-SIZE: '.stripslashes(htmlspecialchars($_POST["AMBottomSH"],ENT_QUOTES)).stripslashes(htmlspecialchars($_POST["typefontH"],ENT_QUOTES)).'; MARGIN: 0px; ';
}
if($_POST["color_setH"] != ''){
$text .= 'COLOR: '.stripslashes(htmlspecialchars($_POST["color_setH"],ENT_QUOTES)).';';
}
$text .= $bH.$iH;
if($_POST["AMHeadFH"] != ''){
$test .= ' FONT-FAMILY: "'.stripslashes(htmlspecialchars($_POST["AMHeadFH"],ENT_QUOTES)).'";';
}
$text .= '}';


		if (!$fp = fopen($filename, 'w')) {
         //print "Cannot open file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot open file(<?php echo $filename;?>)");
		</script>
		 <?php
         exit;
   		 }
		 if (!fwrite($fp, $text)) {
        //print "Cannot write to file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot write to file(<?php echo $filename;?>)");
		</script>
		 <?php
        exit;
  	  }
		fclose($fp);
$db->write_log("update","site properties","ปรับปรุงหน้า  interface_setting");
?>
<script language="JavaScript">
alert("แก้ไขข้อมูลเรียบร้อย");
self.location.href = "ewt_info_interf.php";
</script>
<?php
}	
$db->db_close(); ?>

