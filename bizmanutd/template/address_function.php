<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);
@include("language/language.php");

if($_POST["process"]=='add'){
	$Chk_Duplicate=$db->db_num_rows($db->query("SELECT id FROM n_address WHERE a_url like '".$a_url."'"));
	if($Chk_Duplicate==0){
		$db->query("insert into n_address
		( gen_user_id, a_site, a_description, a_url,a_groupid)
		values
		( '".$_SESSION["EWT_MID"]."', '".$a_site."', '".$a_description."', '".$a_url."','".$gid."')");
		?>
		<script language="javascript1.2">
		alert("บันทึกเรียบร้อย");
		//self.location.href = "address_main.php";
		history.go(-2);
		</script>
		<?php
	}else{
		?>
		<script language="javascript1.2">
		alert("URL ที่ท่านใส่มีอยู่แล้วกรุณาตรวจสอบ!!!!!");
		//self.location.href = "address_main.php";
		history.go(-2);
		</script>
		<?php
	}
}
 if($process=='edit'){  
					$Chk_Duplicate=$db->db_num_rows($db->query("SELECT id FROM n_address WHERE a_url like '".$a_url."' AND id!='".$id."' AND gen_user_id = '".$_SESSION["EWT_MID"]."' "));
					if($Chk_Duplicate==0){
							$db->query("update n_address set a_site='".$a_site."',a_description='".$a_description."', a_url='".$a_url."',a_groupid='".$gid."' WHERE id = '".$id."'");
					?>
					<script language="javascript1.2">
					alert("บันทึกเรียบร้อย");
					//self.location.href = "address_main.php";
					history.go(-2);
					</script>
					<?php
					}else{
					?>
						<script language="javascript1.2">
						alert("URL ที่ท่านใส่มีอยู่แล้วกรุณาตรวจสอบ!!!!!");
						//self.location.href = "address_main.php";
						history.go(-2);
						</script>
						<?php
					}
}
 if($process=='delete'){ 
			$db->query("DELETE FROM n_address WHERE id = '".$id."'  ");
		?>
					<script language="javascript1.2">
					alert("ลบเรียบร้อย");
					//self.location.href = "address_main.php";
					history.go(-1);
					</script>
					<?php
}
 if($process=='groupadd'){ 
 $Chk_Data=$db->db_num_rows($db->query("SELECT id FROM n_groupaddress WHERE ganame ='".$ganame."' AND gen_user_id = '".$_SESSION["EWT_MID"]."'"));
				if($Chk_Data==0){
					$db->query("insert into n_groupaddress (gen_user_id, ganame)
																	values ('".$_SESSION["EWT_MID"]."', '".$ganame."')");
				?>
				<script language="javascript1.2">
				alert("บันทึกเรียบร้อย");
				//self.location.href = "groupaddress_list.php";
				history.go(-2);
				</script>
				<?php
				}else{
				?>
						<script language="javascript1.2">
						alert("กลุ่มนี้มีอยู่แล้วกรุณาตรวจสอบ!!!!!");
						//self.location.href = "groupaddress_list.php";
						history.go(-2);
						</script>
						<?php
				}
 }

 if($process=='groupedit'){ 
$Chk_Data=$db->db_num_rows($db->query("SELECT id FROM n_groupaddress WHERE ganame ='".$ganame."' AND gen_user_id = '".$_SESSION["EWT_MID"]."' AND id!='".$id."'"));
						if($Chk_Data==0){
							$db->query("update n_groupaddress set ganame='".$ganame."' WHERE id = '".$id."'");
				?>
				<script language="javascript1.2">
				alert("บันทึกเรียบร้อย");
				//self.location.href = "groupaddress_list.php";
				history.go(-2);
				</script>
				<?php
				}else{
				?>
						<script language="javascript1.2">
						alert("กลุ่มนี้มีอยู่แล้วกรุณาตรวจสอบ!!!!!");
						//self.location.href = "groupaddress_list.php";
						history.go(-2);
						</script>
						<?php
				}
 }

if($process=='groupdelete'){ 
			$db->query("DELETE FROM n_groupaddress WHERE id = '".$id."'  ");
			$db->query("update n_address set a_groupid='0' WHERE a_groupid =  '".$id."'");
		?>
					<script language="javascript1.2">
					alert("ลบเรียบร้อย");
					//self.location.href = "groupaddress_list.php";
					history.go(-1);
					</script>
					<?php
}
  $db->db_close(); ?>
