<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//add
if($_POST['flag']=='add'){
 			$query=$db->query("SELECT * FROM  article_group_module WHERE  c_id='' "); 
		  if($db->db_num_rows($query) == 0){
			 $db->query("INSERT INTO article_group_module(c_id) VALUES('".$_POST["c_parent"]."')"); 
			 	 ?>
				 <script language="JavaScript">
					//win2 = window.open('article_group_module_popup.php?mod=<?php //echo $_POST[mod];?>','article_group_module','top=100,left=100,width=500,height=500,resizable=1,status=0,scrollbars=1');win2.focus();
					window.opener.location.reload();
					window.close();
				</script>
				 <?php
		  }
}
function GenPic($data){
	for($i=0;$i<=$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
		
		
function showgroup($start,$i,$id,$idp,$dis){
	global $db;
	$x = $i+1;
	$sql_show = $db->query("SELECT * FROM article_group WHERE c_parent = '".$start."' ");
	if($db->db_num_rows($sql_show)){
	
					while($R = $db->db_fetch_array($sql_show)){
					//chk data
					$sqlGM = $db->query("select * from  article_group_module where c_id ='".$R[c_id]."'");
					if($db->db_num_rows($sqlGM) == 0){
						echo GenPic($i).'<input type="radio" name="c_parent" value="'.$R[c_id].'" ';
					
						if($id == $R[c_id]){
						echo ' disabled ';
						}
						if($dis == "Y"){
						echo ' disabled ';
						}
						if($id == $R[c_id] OR $dis == "Y"){
						$dis1 = "Y";
						}else{
						$dis1 = "";
						}
						if($idp == $R[c_id]){
						echo ' checked ';
						}
							$y=$i+1;
						 if($y>=1 and $y<10){
							echo '  onClick="window.opener.document.form1.c_parent.value=this.value;   window.opener.document.all.gname.innerHTML= '."'".eregi_replace("&#039;","`",$R["c_name"])."'".' ; window.close(); "><img src="../images/folder_closed'.$y.'.gif" width="16" height="16" border="0" align="absmiddle"> '.$R["c_name"]."<br>";
							$y=0;
						 }else{
							echo '  onClick="window.opener.document.form1.c_parent.value=this.value; window.opener.document.all.gname.innerHTML= '."'".eregi_replace("&#039;","`",$R["c_name"])."'".' ; window.close();"><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> '.$R["c_name"]."<br>";
						}
						}//chk
						showgroup($R[c_id],$x,$id,$idp,$dis1);
					}
	}
}


function showgroup2($start,$i,$id,$idp,$dis){
	global $db;
	$x = $i+1;
	$sql_show = $db->query("SELECT * FROM article_group WHERE c_parent = '".$start."' ");
	if($db->db_num_rows($sql_show)){
					while($R = $db->db_fetch_array($sql_show)){
						echo GenPic($i).'<input type="checkbox" name="ct_parent'.$x.'" value="'.$R[c_id].'" ';
						if($id == $R[c_id]){
						echo ' disabled ';
						}
						if($dis == "Y"){
						echo ' disabled ';
						}
						if($id == $R[c_id] OR $dis == "Y"){
						$dis1 = "Y";
						}else{
						$dis1 = "";
						}
						if($idp == $R[c_id]){
						echo ' checked ';
						}
							$y=$i+1;
						 if($y>=1 and $y<10){
							echo '><img src="../images/folder_closed'.$y.'.gif" width="16" height="16" border="0" align="absmiddle"> '.$R["c_name"]."<br>";
							$y=0;
						 }else{
							echo '><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> '.$R["c_name"]."<br>";
						}
						
						showgroup2($R[c_id],$x,$id,$idp,$dis1);
					}
	}
}

		
		$ptype = "Ag";
		$ppms1 = "w";
		
		
function countparent($c){
		global $db,$EWT_DB_USER,$ptype,$ppms1,$ppms2,$y;
	
		$sql = $db->query_db("SELECT c_parent FROM article_group  WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
		while($U = $db->db_fetch_array($sql)){
				$c = countparent($U["c_parent"]);
				$y += $c;
				$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
				AND (
				   (s_type = '".$ptype."' AND s_permission = '".$ppms1."'  AND s_id = '".$U["c_parent"]."' )
				  ) ",$EWT_DB_USER);
				if($db->db_num_rows($sql2) > 0){
					$y++;
				}
		}
		return $y;
}	

$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$_GET["cid"]."'");
$G = $db->db_fetch_array($sql_group);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body,td,th {
	font-size: 11px;
}
-->
</style></head>
<body leftmargin="0" topmargin="0" bgcolor="#FFFFFF">

<form name="form1" method="post" action="article_select_module.php">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1"  class="ewttableuse">
  <tr valign="top" bgcolor="#FFFFFF"> 
      <td>
	  <SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="../js/find.js"></SCRIPT><hr>
	  <?php
  if($db->check_permission($ptype,$ppms,"0")){
  ?>
         
          <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">กลุ่มข่าว/บทความ<br>
<?php
	  showgroup(0,0,$G["c_id"],$G["c_parent"],"");
	  ?>
  <?php
}else{
?>
      
          <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">กลุ่มข่าว/บทความ<br>
<?php
		$sql_supadmin = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
		AND ( (s_type = 'Ag' AND s_permission = 'w'  AND s_id != '0' )  	)",$EWT_DB_USER);
		
			 $sql_text = "WHERE ( 0 ";
			while($Gx = $db->db_fetch_row($sql_supadmin)){
			$y = 0;
				if(countparent($Gx[0]) == 0){
				$sql_text .= " OR c_id = '".$Gx[0]."' ";
				}
			}
			$sql_text .= " ) ";
		$sql_articleg = $db->query_db("SELECT * FROM article_group  ".$sql_text." ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
		
		while($GP=$db->db_fetch_array($sql_articleg)){
		$dis = "";
		?>
		<input type="radio" name="c_parent" value="<?php echo $GP["c_id"]; ?>" <?php if($G["c_parent"] == $GP["c_id"]){ echo "checked"; } ?> <?php if($G["c_id"] == $GP["c_id"]){ echo "disabled"; $dis = "Y"; }   ?>  onClick="window.opener.document.form1.c_parent.value=this.value;  window.opener.document.all.gname.innerHTML= '<?php echo eregi_replace("&#039;","`",$GP["c_name"])?>'; window.close(); ">
          <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"><?php echo $GP["c_name"]; ?><br>
		<?php
		showgroup($GP["c_id"],0,$G["c_id"],$G["c_parent"],$dis);
		}
}
  ?><hr>
  <table width="100%" border="0">
  <tr>
    <td><input type="submit" name="Submit" value="Submit"><input name="flag" type="hidden" value="add"></td>
  </tr>
</table>
</td>
  </tr>

</table>
</form>
<br>
</body>
</html>
<?php $db->db_close(); ?>
