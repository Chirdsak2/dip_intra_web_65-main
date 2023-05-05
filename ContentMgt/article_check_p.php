<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_GET["cid"] != ""){

function countparent($c,$ppms){
global $db,$y,$EWT_DB_USER;

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"],$ppms);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
	AND (
	   (s_type = 'Ag' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_parent"]."' ) 
	  ) ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  $db->query("use ".$_SESSION["EWT_SDB"]);
  return $y;
} 

$y = 0; 

			 if($db->check_permission("Ag","a","0") or $db->check_permission("Ag","a",$_GET["cid"]) ){
				 $pass_a='Y';
			 }else{
			   if(countparent($_GET["cid"],"a")>0){
					$pass_a='Y';
			   }
			 }
	if($pass_a == "Y"){
		?>
		<script language="javascript">
	var r = confirm("คุณต้องการอนุมัติข่าว/บทความนี้เลยหรือไม่?");
	if(r == true){
	parent.document.form1.apl.value = "AP";
	self.parent.form1.submit();	
	}else{
	self.parent.form1.submit();	
	}
	</script>
		<?php
	}else{
	?>
	<script language="javascript">
	self.parent.form1.submit();	
	</script>
	<?php	
	}
}
$db->db_close(); 
?>