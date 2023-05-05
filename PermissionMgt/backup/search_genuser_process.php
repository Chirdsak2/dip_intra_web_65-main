<?php
include("../EWT_ADMIN/comtop_pop.php");

$db->query("USE ".$EWT_DB_USER);

##============================================================================================================##
$fullname = trim($_POST["fullname"]);
##============================================================================================================##
$where_user   = " AND 1=1 ";

if($fullname!=""){
    $find = explode(" ",$fullname);
    foreach($find AS $find_e){
        if($find_e!=""){
            $find_e = ready($find_e);
            $where_user .= " AND ((name_thai LIKE '%$find_e%') OR (surname_thai LIKE '%$find_e%')) ";
        }
    }
}
##============================================================================================================##

$_GET['ug'] = $_SESSION["EWT_SUID"];

//$info_id = (int)(!isset($_GET['info_id']) ? '' : $_GET['info_id']);

$sql_gen_user  = "SELECT * FROM gen_user INNER JOIN org_name ON org_name.org_id = gen_user.org_id WHERE status ='1' $where_user"; 

/*if($_POST["search_title"] == '0'){
		if($_POST["fname"] != ""){
		
				$sql_gen_user .= " AND gen_user.name_thai LIKE '%".$_POST["fname"]."%' OR gen_user.surname_thai LIKE '%".$_POST["fname"]."%' ";
	
		}
			if($_SESSION["EWT_SMID"] != ''){
		$sql_gen_user .= "  AND gen_user.gen_user_id <> ".$_SESSION["EWT_SMID"]."";
		}
	}else{
		if($_POST["org_id"] != ""){
		//$run .= " WHERE gen_user.org_id LIKE '".$_POST["org_id"]."' ";
		$sql_gen_user.=" AND (org_name.name_org  LIKE  '%".$org_id."%')  ";
		}
		if($_SESSION["EWT_SMID"] != ''){
		$sql_gen_user .= "  AND gen_user.gen_user_id <> ".$_SESSION["EWT_SMID"]."";
		}
	}*/
	
$sql_gen_user .= " ORDER BY gen_user.gen_user_id";
$s_sql  = $db->query($sql_gen_user);
$a_rows = $db->db_num_rows($s_sql);


if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($s_sql)){
    $sql_chk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member 
                            WHERE ug_id = '{$_SESSION['EWT_SUID']}' 
                            AND ugm_type = 'U' 
                            AND ugm_tid = '{$a_data['gen_user_id']}' 
                            ");
$C = $db->db_fetch_row($sql_chk);
//echo $C[0];
if($C[0] == 0){
?>
<tr > 
<td>
<div class="checkbox">&nbsp;&nbsp;
<label>
<input type="checkbox" class="chk" name="chk<?php echo $i;?>" id="chk<?php echo $i;?>" value="Y"  <?php if($C[0] > 0){ echo "checked"; } ?> >
<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;
<b> 
<input name="uid<?php echo $i; ?>" type="hidden" value="<?php echo $a_data['gen_user_id']; ?>"> 
<img src="../images/user_logo.gif" width="20" height="20" border="0" align="absmiddle">  
<?php echo $a_data['name_thai']; ?> <?php echo $a_data['surname_thai']; ?>  
</b>
</label>
</div>
</td>
<td><?php echo $a_data['name_org']; ?>
    <?php  
    if($a_data["ldap_user"]=='1'){ 
    echo "(กำหนดโดยกลุ่ม LDAP )";
    }
    ?>
    </td>
</tr>
<?php 
}
$i++; }}else{ ?>
<tr align="center" bgcolor="#FFFFFF"> 
    <td height="40" colspan="2"><font color="#FF0000">ไม่มีรายชื่อสมาชิก</font></td>
</tr>
<?php } ?>
<input name="alli" type="hidden" value="<?php echo $i; ?>">