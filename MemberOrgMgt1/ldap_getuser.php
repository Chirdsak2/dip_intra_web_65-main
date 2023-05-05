<?php
$EWT_PATH = '../';	
$IMG_PATH = '';
$MAIN_PATH = '';

include("../EWT_ADMIN/comtop_pop.php");
$username = "testweb.adm@ad-gistda.or.th";
$password = "G1stda2021";

$ldapconfig['host'] = '103.156.151.10';//CHANGE THIS TO THE CORRECT LDAP SERVER
$ldapconfig['port'] = '389';
$ldapconfig['basedn'] = 'dc=ad-gistda,dc=or,dc=th';//CHANGE THIS TO THE CORRECT BASE DN
$ldapconfig['usersdn'] = 'cn=users';//CHANGE THIS TO THE CORRECT USER OU/CN
$ldapconn             = ldap_connect($ldapconfig['host'],$ldapconfig['port']);

$dn       = "uid=".$username.",".$ldapconfig['usersdn'].",".$ldapconfig['basedn'];
$ldaptree = $ldapconfig['basedn'];

ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10);

//echo "TREE:".$ldaptree;
$total_user = 0;

if($ldapconn){
	$ldapbind = ldap_bind($ldapconn, $username, $password);
	
	if ($ldapbind) {
		
		$pageSize = 1000;
		$member_array = array();
		
		
		
		$cookie = '';
		do {
			ldap_control_paged_result($ldapconn, $pageSize, true, $cookie);

			$result = ldap_search($ldapconn,$ldaptree, "(cn=*)");
			$data   = ldap_get_entries($ldapconn, $result);
			//$total_user = $total_user + $data["count"];
			echo "<pre>";
			print_r($data);
			echo "</pre>";/**/
				 
			foreach($data AS $ldap_member){
				if(in_array("user",$ldap_member["objectclass"])){
					$this_member["name"] = $ldap_member["name"][0];
					$this_member["samaccountname"] = $ldap_member["samaccountname"][0];
					$this_member["description"] = $ldap_member["description"][0];
					$this_member["objectclass"] = $ldap_member["objectclass"];
					$this_member["detail"] = $ldap_member;

					array_push($member_array,$this_member);
					$total_user++;
					
					echo $this_member["name"]."<br/>";
					echo $this_member["samaccountname"]."<br/>";
					echo "<hr></hr>";
				}
			}
			
			ldap_control_paged_result_response($ldapconn, $result, $cookie);
		   
		} 
		while($cookie !== null && $cookie != '');
	}
}

echo "TOTAL:".$total_user;
/*echo "<pre>";
print_r($member_array);
echo "</pre>";*/
?>