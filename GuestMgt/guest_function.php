<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
$ip_data = getenv("REMOTE_ADDR");
$date_now = date('Y-m-d');

include("../language/guest_language.php");

  $id_guest=$_REQUEST[id_guest];
  $proc=$_REQUEST[proc];
  $type_page=$_REQUEST[type_page];


if($type_page == 'config'){
		$del_sql = " delete from guest_config";
		$db->query($del_sql);
		
		if($_FILES["guest_config_img"]["name"]){
			$img_name = $_FILES["guest_config_img"]["name"];
			@copy($_FILES["guest_config_img"]["tmp_name"], "../ewt/".$_SESSION["EWT_SUSER"]."/mainpic/guestbook/".$_FILES["guest_config_img"]["name"]);
		}else{
			$img_name = $_POST["o_img"];
		}
		 $add_sql = "INSERT INTO guest_config(guest_config_id,guest_config_page,guest_config_date,guest_config_email,guest_config_message,guest_config_apply_auto,guest_config_img) VALUE ('','".$_POST[page_data]."','".$_POST[date_data]."','".$_POST[email_data]."','".$_POST["message"]."','".$_POST["app_auto"]."','".$img_name."')";
		$db->query($add_sql);
		$db->write_log("update","guesbook",$text_genguest_configedit);
		?>
		 <script type="text/javascript">
		 				alert('<?php echo $text_genguest_complete;?>'); 
		 				self.location.href='guest_config.php';
		 </script>
		<?php	
		exit;
		
}
if($type_page == 'edit'){
		 $add_sql = "UPDATE guestbook_list SET detail_guest = '".$_POST["message"]."' WHERE id_guest = '".$_POST["id_guest"]."'";
		$db->query($add_sql);
		$db->write_log("update","guesbook",$text_genguest_textedit);
	
}
if($type_page == 'cate'){
		$rec = $db->db_fetch_array($db->query("select * from guestbook_list where (id_guest='$id_guest') "));
		$db->write_log("delete","guesbook",$text_genguest_textdelete.$rec[detail_guest]);
		$del_sql = " delete from guestbook_list where (id_guest='$id_guest') ";
		$db->query($del_sql);
}

if(!empty($id_guest) && !empty($proc)){
		$rec = $db->db_fetch_array($db->query("select * from guestbook_list where (id_guest='$id_guest') "));
		if($proc == 'cancel'){
				$status = 'N';
				$ti =$text_genguest_altcancel;
		}else{
				$status = 'Y';
				$ti =$text_genguest_altapp;
		}
		$cancel_confirm = "UPDATE guestbook_list SET status_guest = '$status' WHERE id_guest = '$id_guest' ";
		$db->query($cancel_confirm);
		$db->write_log("approve","guesbook",$ti.$rec[detail_guest]);
}
?>
		 <script>
		 				alert('<?php echo $text_genguest_complete;?>'); 
		 				self.location.href='guest_cate.php';
		 </script>
<?php
//if(!empty() && $type_edit ==cancel_confirm)
$db->db_close(); 

?>
