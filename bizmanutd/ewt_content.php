<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
function level_name($L,$id){
	global $db;
		if($L == "A"){
			echo "<img src=\"../images/user_a.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT emp_type_name FROM emp_type WHERE emp_type_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "D"){
			echo "<img src=\"../images/user_group.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_org FROM org_name WHERE org_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "L"){
			echo "<img src=\"../images/user_c.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT ul_name FROM user_level WHERE ul_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "P"){
			echo "<img src=\"../images/user_pos.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT position_name.pos_name FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.up_id = '".$id."' ORDER BY user_position.up_rank ASC ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "U"){
			echo "<img src=\"../images/user_logo.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_thai,surname_thai FROM gen_user WHERE gen_user_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0]." ".$R[1];
		}
	}

	$sql = $db->query("SELECT * FROM web_group_member WHERE ug_id = '".$_GET["UID"]."' ORDER BY ugm_type ASC");

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script language="JavaScript" type="text/javascript">
function news_data(bid) {	
	return true;
	/*
	var objDiv = document.getElementById("show_comment"+bid);
	url='news_ajax.php?bid='+bid;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
			}
		}
	);
	setTimeout("news_data("+bid+")",2000); */
}

function usem(mid,mtype,muse,i){
self.parent.document.formlink.mid.value = mid;
self.parent.document.formlink.mtype.value = mtype;
self.parent.document.formlink.muse.value = muse;
	if(document.form1.truse.value != ""){
		document.getElementById('tr'+document.form1.truse.value).style.backgroundColor = "#FFFFFF";
	}
		document.getElementById('tr'+i).style.backgroundColor = "#CCCCCC";
		document.form1.truse.value = i;
		self.parent.p_permission.location.href="ewt_p_list.php?UID=<?php echo $_GET["UID"]; ?>&mid=" + mid + "&mtype=" + mtype;
		self.parent.p_advance.location.href="blank.php";
		self.parent.document.all.bt_remove.disabled = false;
	}
</script>
</head>

<body>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <form name="form1" method="post" action="">
    <?php
 $i=0;
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr id="tr<?php echo $i;?>" bgcolor="#FFFFFF" style="cursor:hand" onClick="usem('<?php echo $U["ugm_tid"]; ?>','<?php echo $U["ugm_type"]; ?>','<?php echo $U["ugm_id"]; ?>','<?php echo $i;?>');"> 
      
    <td > 
      <?php level_name($U["ugm_type"],$U["ugm_tid"]); ?>
      
        
       </td>
    </tr>
    <?php 
	$i++;
  }
  ?><input type="hidden" name="truse" value=""></form>
  </table>
</body>
</html>
<?php
$db->db_close();
?>
