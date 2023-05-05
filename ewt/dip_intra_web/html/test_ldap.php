<?php
ini_set("memory_limit", "-1");
set_time_limit(0); 
//$username = "testweb.adm@ad-gistda.or.th";
//$password = "G1stda2021";
$username = 'gensystem'; 
$password = 'eyGlianFioc5';   

$ldapconfig['host'] 	= '118.175.16.156';//CHANGE THIS TO THE CORRECT LDAP SERVER 
$ldapconfig['port'] 	= '389';
$ldapconfig['basedn'] 	= 'ou=authen,dc=prd,dc=go,dc=th';//CHANGE THIS TO THE CORRECT BASE DN
$ldapconfig['usersdn'] 	= 'cn='.$username;//CHANGE THIS TO THE CORRECT USER OU/CN  
$ldapconn  = ldap_connect($ldapconfig['host'],$ldapconfig['port']);  

//$dn       = "uid=".$username.",".$ldapconfig['usersdn'].",".$ldapconfig['basedn'];
$dn       = $ldapconfig['usersdn'].",".$ldapconfig['basedn']; 
$ldaptree = $ldapconfig['basedn']; 

$base_dn ="ou=people,dc=prd,dc=go,dc=th"; //"dc=prd,dc=go,dc=th";    

$auth_user ='cn=gensystem';
$auth_pass ='prdweb$y$tem'; 

ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10); 

$total_user = 0;

if($ldapconn) 
{
	$ldapbind = ldap_bind($ldapconn,"$dn", $password); 
	if(!$ldapbind) die("ldap_bind failed<br>");  
	if ($ldapbind) 
	{
		$result = ldap_search($ldapconn,$base_dn, "(cn=*)");   
		if(!$result) die("ldap_search failed<br>");
		if($result) 
		{
		$data = ldap_get_entries($ldapconn, $result); 
		echo '<pre>';
		print_r($data);
		echo '</pre>';		
		/*foreach($data AS $ldap_member){
			if(in_array("user",$ldap_member["objectclass"])){
				$this_member["name"] = $ldap_member["name"][0];
				$this_member["samaccountname"] = $ldap_member["samaccountname"][0];
				$this_member["description"] = $ldap_member["description"][0];
				$this_member["objectclass"] = $ldap_member["objectclass"];
				$this_member["detail"] = $ldap_member;

				//array_push($member_array,$this_member);
				$total_user++;
				
				echo $this_member["name"]."<br/>";
				echo $this_member["samaccountname"]."<br/>";
				echo $ldap_member["samaccountname"][1];
				echo "<hr></hr>";
			}
		}*/
			echo " ldap_search success ";
		} 
		echo " ldap_bind success "; 
	}	  
} 
else 
{
    echo "Unable to connect to LDAP server";  
}
echo "TOTAL:".$total_user;
?>