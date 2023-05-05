<?php
$EWT_PATH = '../';	
$IMG_PATH = '';
$MAIN_PATH = '';
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);
	

	$currentuser_array = array();
	$currentuser_data  = $db->query("SELECT gen_user FROM $EWT_DB_USER.gen_user");
	while($currentuser_info  = $db->db_fetch_array($currentuser_data)){
		array_push($currentuser_array,$currentuser_info["gen_user"]);
	}

	//$db->query("USE ".$EWT_DB_NAME);							   
	
	$ldap_user = "";
	
	//sys::save_log('create','org',$txt_org_add.' '.$a_data['txt_org_list_name_thai'].' '.$a_data['txt_org_list_surname_thai']);

	##============================================================================================##
	$username = "testweb.adm@ad-gistda.or.th";
	$password = "G1stda2021";
	
	$ldapconfig['host']    = '103.156.151.10';//CHANGE THIS TO THE CORRECT LDAP SERVER
	$ldapconfig['port']    = '389';
	$ldapconfig['basedn']  = 'dc=ad-gistda,dc=or,dc=th';//CHANGE THIS TO THE CORRECT BASE DN
	$ldapconfig['usersdn'] = 'cn=users';//CHANGE THIS TO THE CORRECT USER OU/CN
	$ldapconn              = ldap_connect($ldapconfig['host'],$ldapconfig['port']);
	
	$dn       = "uid=".$username.",".$ldapconfig['usersdn'].",".$ldapconfig['basedn'];
	$ldaptree = $ldapconfig['basedn'];
	
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
	ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10);
	
	$total_user = 0;
		
	if($ldapconn){
		$ldapbind = ldap_bind($ldapconn, $username, $password);
		
		if($ldapbind) {
			
			$pageSize = 1000;
			$member_array = array();
			
			$member_array["new"] = array();
			$member_array["old"] = array();
			$member_array["do_new"] = array();
			$member_array["do_old"] = array();
			
			$cookie = '';
			do {
				ldap_control_paged_result($ldapconn, $pageSize, true, $cookie);

				$result = ldap_search($ldapconn,$ldaptree, "(cn=*)");
				$data   = ldap_get_entries($ldapconn, $result);
				unset($data["count"]);
					
				foreach($data AS $ldap_member){
					if(in_array("user",$ldap_member["objectclass"])){
						$this_member["name"] = $ldap_member["name"][0];
						$this_member["samaccountname"] = $ldap_member["samaccountname"][0];
						$this_member["description"] = $ldap_member["description"][0];
						$this_member["objectclass"] = $ldap_member["objectclass"];
						$this_member["detail"] = $ldap_member;

						if(in_array($this_member["samaccountname"],$currentuser_array)){
							array_push($member_array["old"],$this_member["name"]);
							array_push($member_array["do_old"],$this_member);
							/*  */
						}
						else{
							array_push($member_array["new"],$this_member["name"]);
							array_push($member_array["do_new"],$this_member);
							/**/
						}

						$total_user++;
					}
				}
				
				ldap_control_paged_result_response($ldapconn, $result, $cookie);
			
			} 
			while($cookie !== null && $cookie != '');
		}
	}

	asort($member_array["old"]);
	asort($member_array["new"]);

	$ldap_user .= "<div>"."<b>พบบุคลากร ".(count($member_array["old"])+count($member_array["new"]))." คน </b>"."</div>";

	$ldap_user .= '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">';
	$ldap_user .= "<br><div><b>ใหม่: </b>".count($member_array["new"])." คน "."</div><br>";
	$ldap_user .= '<div style="height:200px;overflow-y: scroll;border-style: outset;">';
	$ldap_user .= "<ul>";
	foreach($member_array["new"] AS $member){
		$ldap_user .= '<li style="margin-left:10px;"> - '.$member.'</li>';
	}
	$ldap_user .= "</ul>";
	$ldap_user .= "</div>";
	$ldap_user .= "</div>";

	$ldap_user .= '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">';
	$ldap_user .= "<br><div><b>เก่า: </b>".count($member_array["old"])." คน "."</div><br>";
	$ldap_user .= '<div style="height:200px;overflow-y: scroll;border-style: outset;">';
	$ldap_user .= "<ul>";
	foreach($member_array["old"] AS $member){
		$ldap_user .= '<li style="margin-left:10px;"> - '.$member.'</li>';
	}
	$ldap_user .= "</ul>";
	$ldap_user .= "</div>";
	$ldap_user .= "</div>";

	foreach($member_array["do_old"] AS $this_member){
		$this_firstname = substr(ready($this_member["name"]),0,50);
		$this_username  = substr(ready($this_member["samaccountname"]),0,30);
		$this_password  = substr(ready(user::encryptPassword($this_member["samaccountname"])),0,30);
		if(filter_number($_SESSION["EWT_SMID"])==""){
			$this_ewt_smid = "0";
		}
		else{
			$this_ewt_smid = ready($_SESSION["EWT_SMID"]);
		}
		
		$db->query("UPDATE $EWT_DB_USER.gen_user 
					SET    name_thai = '$this_firstname',
						   gen_pass  = '$this_password', 
						   last_update = NOW(), 
						   last_update_by = '$this_ewt_smid'
					WHERE  gen_user  = '$this_username' COLLATE utf8_bin");	 
	}
	
	foreach($member_array["do_new"] AS $this_member){
		$this_firstname = substr(ready($this_member["name"]),0,50);
		$this_username  = substr(ready($this_member["samaccountname"]),0,30);
		$this_password  = substr(ready(user::encryptPassword($this_member["samaccountname"])),0,30);
		if(filter_number($_SESSION["EWT_SMID"])==""){
			$this_ewt_smid = "0";
		}
		else{
			$this_ewt_smid = ready($_SESSION["EWT_SMID"]);
		}
		
		$db->query("INSERT INTO $EWT_DB_USER.gen_user (name_thai,gen_user,gen_pass,org_id,emp_type_id,ldap_user,
													   create_date, last_update_by, web_use, `status`)
					VALUES ('$this_firstname','$this_username','$this_password','183','1','1',
													   NOW(),'$this_ewt_smid','gistda_web','1')");
	}
	##============================================================================================##

	$a_data['status'] 	  = true;
	$a_data['message']    = "success";
	$a_data['url']        = "../MemberOrgMgt/org_list.php";
	$a_data['total_ldap'] = $total_user;
	$a_data['ldap_user']  = $ldap_user;
	
	echo json_encode($a_data);	
	exit;
	
?>