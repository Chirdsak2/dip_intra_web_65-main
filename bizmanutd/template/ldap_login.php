<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect_uncheck.php");
function emp_type(){
					global $db;
					$sql = "select emp_type_id from emp_type where emp_type_status ='2'";
					$query = $db->query($sql);
					$R = $db->db_fetch_array($query);
					return $R[emp_type_id];
					}
					function org(){
					global $db;
					$sql = "select org_id from org_name where parent_org_id ='0001'";
					$query = $db->query($sql);
					$R = $db->db_fetch_array($query);
					return $R[org_id];
					}
					function gen_user_id($user,$pass){
					global $db;
					$sql = "select gen_user_id from gen_user where gen_user ='$user' and gen_pass = '$pass'";
					$query = $db->query($sql);
					$R = $db->db_fetch_array($query);
					return $R[gen_user_id];
					}
				function ldap_login($ip,$user,$pass){
					$ldap_server = $ip;
					$base_dn = "ou=people,dc=prd,dc=go,dc=th";
					/////////////////////
					$auth_user = 'uid='.$user;
					$auth_pass = $pass;
					
					if (!($connect=ldap_connect($ldap_server))) {
							 die("Could not connect to ldap server");
					}
					ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
					ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
					// bind to server
					if (!($bind=ldap_bind($connect,"$auth_user,$base_dn",$auth_pass))) {
							 die(ldap_error($connect));
					} else {
						//$filter = "dc=prd";
						$filter = "uid=$user";
						if (!($search=ldap_search($connect,$base_dn, $filter))) {
							 die(ldap_error($connect));
						}
						$number_returned = ldap_count_entries($connect,$search);
						$info = ldap_get_entries($connect, $search);
						$arrName=explode(' ',$info[0]["cn"][0]);
						$infoldap = $info[0]['cn'][0]."||".$info[0]['cn'][0]."||".$info[0]["mail"][0]."||".$info[0]["homephone"][0];
						return $infoldap;
					}
					ldap_close($connect);
				}
	$ewt_user1='test1_p'; $ewt_pass1='123456';
	if(trim($_POST["ewt_user1"]) != "" AND trim($_POST["ewt_pass1"]) != ""){
		//check ldap first
		$sql_info = "SELECT login_ldap,login_ldap_ip FROM user_info WHERE EWT_User = '".$EWT_FOLDER_USER."'";
		$query_info = $db->query($sql_info);
		$rec = $db->db_fetch_array($query_info);
		if($rec['login_ldap'] == 'Y'){
			$chk_ldap = ldap_login($rec["login_ldap_ip"],trim($_POST["ewt_user1"]),$_POST["ewt_pass1"]);
			if($chk_ldap != ''){
				//cese return true
				$infoldap = explode('||',$chk_ldap);
				$user_name = $_POST["ewt_user1"];
				$pass_word = $_POST["ewt_pass1"];
				$telephone = $infoldap[3];
				$email = $infoldap[2];
				$name = $infoldap[0];
				$surname = $infoldap[1];
				
				$emp_type_id = emp_type();
				$org_id = org();
				$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user = '".trim($_POST["ewt_user1"])."' AND  gen_pass = '".trim($_POST["ewt_pass1"])."'  ");
				$row = $db->db_num_rows($sql_login);
				if($row > 0){
					$strUpdLD='UPDATE gen_user SET emp_type_id=\''.$emp_type_id.'\' '.
					',org_id=\''.$org_id.'\' '.
					',name_thai=\''.$name.'\' '.
					',surname_thai=\''.$surname.'\' '.
					',email_person=\''.$email.'\' '.
					',tel_in=\''.$telephone.'\' '.
					',status=1 '.
					'WHERE gen_user=\''.trim($_POST['ewt_user1']).'\' AND gen_pass=\''.trim($_POST['ewt_pass1']).'\'';
					$db->query($strUpdLD);
				} else {
					$db->query("INSERT INTO gen_user (emp_type_id,org_id,name_thai,surname_thai,email_person,tel_in,gen_user,gen_pass,status) VALUES ('".$emp_type_id."','".$org_id."','".$name."','".$surname."','".$email."','".$telephone."','".$_POST["ewt_user1"]."','".$_POST["ewt_pass1"]."','1')");
				}
				$gen_user_id = gen_user_id($_POST["ewt_user1"],$_POST["ewt_pass1"]);
					//
				session_register("EWT_MID");
				session_register("EWT_ORG");
				session_register("EWT_NAME");
				session_register("EWT_LEVEL");
				session_register("EWT_IMG");
				session_register("EWT_MAIL");
				session_register("EWT_USERNAME");
				$_SESSION["EWT_MID"] = $gen_user_id;
				$_SESSION["EWT_ORG"] = $M["org_id"];
				$_SESSION["EWT_NAME"] = $name." ".$surname;
				$_SESSION["EWT_LEVEL"] = $M["level_id"];
				$_SESSION["EWT_TYPE_ID"] = $M["emp_type_id"];
				$_SESSION["EWT_IMG"] = '';
				$_SESSION["EWT_MAIL"] = $email;
				$_SESSION["EWT_FIGN"] = '';
				$_SESSION["EWT_USERNAME"] = $user_name;
				if($_POST[fn] == ""){
?>
				<script language="JavaScript">
					self.location.href = "index.php";
				</script>
<?php
				}else{
?>
				<script language="JavaScript">
					self.location.href = "index.php";
				</script>
<?php
				}
				exit;
			} else {
				//cese no use LDAP and no Username
				$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user = '".trim($_POST["ewt_user1"])."' AND  gen_pass = '".trim($_POST["ewt_pass1"])."' AND org_id=0");
				$row = $db->db_num_rows($sql_login);
				if($row > 0){
					$M = $db->db_fetch_array($sql_login);
					if($M[status] != "1"){
?>
					<script language="JavaScript">
						alert("คุณยังไม่ได้ยืนยันการลงทะเบียน!!!");
<?php
						if($_POST[fn] == ''){
?>
						self.location.href = "ewt_login.php?fn=main.php?filename=index";
<?php
						} else {
?>
						self.location.href = "<?php echo $_POST[fn]?>";
<?php
						}
?>
					</script>
<?php
						exit;
					}else{	// $M['status']==1 (activated)
						session_register("EWT_MID");
						session_register("EWT_ORG");
						session_register("EWT_NAME");
						session_register("EWT_LEVEL");
						session_register("EWT_IMG");
						session_register("EWT_MAIL");
						session_register("EWT_USERNAME");
						$_SESSION["EWT_MID"] = $M["gen_user_id"];
						$_SESSION["EWT_ORG"] = $M["org_id"];
						$_SESSION["EWT_NAME"] = $M["name_thai"]." ".$M["surname_thai"];
						$_SESSION["EWT_LEVEL"] = $M["level_id"];
						$_SESSION["EWT_TYPE_ID"] = $M["emp_type_id"];
						$_SESSION["EWT_IMG"] = $M["path_image"];
						$_SESSION["EWT_MAIL"] = $M["email_person"];
						$_SESSION["EWT_FIGN"] = $M["fign"];
						$_SESSION["EWT_USERNAME"] = $M["gen_user"];
						if($_POST[fn] == ""){
		?>
						<script language="JavaScript">
								self.location.href = "index.php";
						</script>
		<?php
						}else{
		?>
								<script language="JavaScript">
								self.location.href = "index.php";
							</script>
						<?php
						}
						exit;
					}// end $M[status]
				} else {	// no user found both LDAP and gen_user
?>
						<script language="JavaScript">
							alert("Username or pasword not correct!!!");
<?php
					if($_POST[fn] == ''){
?>
						self.location.href = "ewt_login.php?fn=main.php?filename=index";
<?php
					} else {
?>
						self.location.href = "<?=$_POST[fn]?>";
<?php
					}
?>
						</script>
<?php
					exit;
				}
			}
		}else{
			//cese no use LDAP and no Username
			$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user = '".trim($_POST["ewt_user1"])."' AND  gen_pass = '".trim($_POST["ewt_pass1"])."' AND org_id=0");
			$row = $db->db_num_rows($sql_login);
			if($row > 0){
				$M = $db->db_fetch_array($sql_login);
				if($M[status] != "1"){
?>
				<script language="JavaScript">
					alert("คุณยังไม่ได้ยืนยันการลงทะเบียน!!!");
<?php
					if($_POST[fn] == ''){
?>
					self.location.href = "ewt_login.php?fn=main.php?filename=index";
<?php
					} else {
?>
					self.location.href = "<?php echo $_POST[fn]?>";
<?php
					}
?>
				</script>
<?php
					exit;
				}else{	// $M['status']==1 (activated)
					session_register("EWT_MID");
					session_register("EWT_ORG");
					session_register("EWT_NAME");
					session_register("EWT_LEVEL");
					session_register("EWT_IMG");
					session_register("EWT_MAIL");
					session_register("EWT_USERNAME");
					$_SESSION["EWT_MID"] = $M["gen_user_id"];
					$_SESSION["EWT_ORG"] = $M["org_id"];
					$_SESSION["EWT_NAME"] = $M["name_thai"]." ".$M["surname_thai"];
					$_SESSION["EWT_LEVEL"] = $M["level_id"];
					$_SESSION["EWT_TYPE_ID"] = $M["emp_type_id"];
					$_SESSION["EWT_IMG"] = $M["path_image"];
					$_SESSION["EWT_MAIL"] = $M["email_person"];
					$_SESSION["EWT_FIGN"] = $M["fign"];
					$_SESSION["EWT_USERNAME"] = $M["gen_user"];
					if($_POST[fn] == ""){
	?>
					<script language="JavaScript">
							self.location.href = "index.php";
					</script>
	<?php
					}else{
	?>
							<script language="JavaScript">
							self.location.href = "index.php";
						</script>
					<?php
					}
					exit;
				}// end $M[status]
			} else {	// no user found both LDAP and gen_user
?>
					<script language="JavaScript">
						alert("Username or pasword not correct!!!");
<?php
				if($_POST[fn] == ''){
?>
					self.location.href = "ewt_login.php?fn=main.php?filename=index";
<?php
				} else {
?>
					self.location.href = "<?=$_POST[fn]?>";
<?php
				}
?>
					</script>
<?php
				exit;
			}
		}
	}
$db->db_close(); ?>
