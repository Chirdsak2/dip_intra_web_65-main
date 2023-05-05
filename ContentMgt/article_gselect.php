<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$cdd = $_GET["cid"];

if($_POST[Flag]=="MultiGroup"){
	$sql_del="Delete From article_multigroup Where c_id = '$_POST[cid]' ";
	$db->query($sql_del);
    
	$data_set=$_POST[chkg];
	for($i=0;$i<=sizeof($data_set);$i++){
        //echo  $data_set[$i].'<br>';
		if($data_set[$i]>0){
			$sql_insert="INSERT INTO  article_multigroup(c_id,multi_cid) values('$_POST[cid]','".$data_set[$i]."') ";
			$db->query($sql_insert);
		}
    }
	
	if($_POST[cid] == ""){ ?>
			<script language="javascript">
			   <?php if($_POST[popup]=='Y'){?> 
			          //window.opener.location.href = "article_group.php#bottom";
			   <?php }else{?>
				  self.location.href = "article_group.php#bottom";
				  <?php }?>
			</script>
	<?php }else{ ?>
			<script language="javascript">
			   <?php if($_POST[popup]=='Y'){?> 
			       //window.opener.location.href = "article_list.php?cid=<?php echo $_POST[cid]; ?>";
			   <?php }else{?>
				  self.location.href = "article_list.php?cid=<?php echo $_POST[cid]; ?>";
			    <?php }?>
			</script>
	<?php } ?>
	<?php if($_POST[popup]=='Y'){?><script language="javascript"> window.close();</script><?php }?>
	 
	<?php
	 exit();
}


$sql="SELECT * FROM  article_multigroup WHERE c_id='$_GET[cid]' ";
$query=$db->query($sql);

while($rec = $db->db_fetch_array($query)){
   $array_gx.=$rec[multi_cid].'/';
}
$array_g=explode('/',$array_gx);

function countparent($c){
global $db,$ptype,$ppms1,$ppms2,$y,$EWT_DB_USER;
$ptype = "Ag";
$ppms1 = "w";
$ppms2 = "a";

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"]);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
	AND   (s_type = '".$ptype."' AND s_permission = '".$ppms1."'  AND s_id = '".$U["c_parent"]."' )   ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  return $y;
}


if($db->check_permission('Ag','w',"0")){
  //$sql_article = $db->query_db("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
  $sql = $db->query_db("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC ",$_SESSION["EWT_SDB"]);
}else{
		$sql_supadmin = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."'  AND (s_type = 'Ag' AND s_permission = 'w'  AND s_id != '0' )   ",$EWT_DB_USER);
		
			 $sql_text = "WHERE ( 0 ";
			while($G = $db->db_fetch_row($sql_supadmin)){
			$y = 0;
				if(countparent($G[0]) == 0){
				$sql_text .= " OR c_id = '".$G[0]."' ";
				}
			}
			$sql_text .= " ) ";
		//$sql_group = $db->query_db("SELECT * FROM gallery_category ".$sql_text." ORDER BY category_id ASC ",$_SESSION["EWT_SDB"]);
		$sql = $db->query_db("SELECT * FROM article_group  ".$sql_text." ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
}




function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
function child($c,$x,$decho){
global $db,$i,$txt,$array_g,$cdd;
$y = $x+1;
$sql = $db->query_db("SELECT * FROM article_group WHERE c_parent = '$c' ORDER BY c_id ASC ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php GenPic($y); ?><input type="checkbox" name="chkg[]" value="<?php echo $U["c_id"] ?>" <?php if(in_array($U["c_id"],$array_g)){ echo 'checked';}?> <?php if($U["c_id"] == $cdd){ echo "disabled"; } ?>>
	  
	  <?php if($y>=1 and $y<10){?>
			<img src="../images/folder_closed<?php echo $y;?>.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }else{?>
			<img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }?>
	  
	  <?php echo $U["c_name"]; ?></td>
    </tr>
    <?php
	$i++; 
	child($U["c_id"],$y,$decho);
  }
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

</head>
<body>
<span id="divhtml" style="display:none"></span>
  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <form name="form1" method="post" action="">
	<input type="hidden" name="cid" value="<?php echo $_GET[cid]?>">
	<input type="hidden" name="Flag" value="MultiGroup">
	<input name="popup" type="hidden" id="popup" value="<?php echo $_GET[popup]?>">
	<?php
			$sql_g = "select c_name from article_group where c_id='$_GET[cid]' ";
			$query_g = $db->query($sql_g);
			$rec_g = $db->db_fetch_array($query_g);
	?>
	<tr  bgcolor="#FFFFFF"><td><font size="5">เลือกกลุ่มสำหรับมาแสดงในหมวด : <?php echo $rec_g[c_name]?></font><hr></td></tr>
	<tr bgcolor="#FFFFFF"><td>
	<DIV style="HEIGHT: 300;OVERFLOW-Y: scroll;WIDTH: 100%;BORDER:1;">
	 <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
	<tr bgcolor="#FFFFFF" > 
      <td ><strong>Article group</strong></td>
    </tr>
    <?php
	$i=1;
	$txt = "";
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><input type="checkbox" name="chkg[]" value="<?php echo $U["c_id"] ?>" <?php if(in_array($U["c_id"],$array_g)){ echo 'checked';}?> <?php if($U["c_id"] == $cdd){ echo "disabled"; } ?>><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; 
	  <?php echo $U["c_name"]; ?></td>
    </tr>
    <?php 
	$i++;
	child($U["c_id"],0,$decho);
  }
  ?><input type="hidden" name="numrow" value="<?php echo $i; ?>">
  <tr  bgcolor="#FFFFFF"><td></td></tr>
  </table>
  </div>
  <hr><input type="submit" value="บันทึกข้อมูล" >
  </td></tr>
  </form>
  </table>
</body>
</html>
<?php $db->db_close(); ?>
