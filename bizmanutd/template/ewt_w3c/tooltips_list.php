<?php
$path = "../";
	session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>help</title>
<link href="../css/interface.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script language="javascript1.2">
function show_detail(gid) {
	var objDiv = window.top.document.getElementById("help_detail");
	<?php if($_GET[page] != ''){?>
	var objpage = window.top.document.getElementById("hdd_page").value;
	url='ewt_about.php?flag=group&gtips_id='+gid+'&page='+objpage;
	<?php }else{ ?>
	url='ewt_about.php?flag=group&gtips_id='+gid;
	<?php }?>
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
	
}
function show_detailsub(tid,gid) {
	var objDiv = window.top.document.getElementById("help_detail");
	<?php if($_GET[page] != ''){?>
	var objpage = window.top.document.getElementById("hdd_page").value;
	url='ewt_about.php?flag=tips&tips_id='+tid+'&page='+objpage+'&gtips_id='+gid;
	<?php }else{ ?>
	url='ewt_about.php?flag=tips&tips_id='+tid+'&gtips_id='+gid;
	<?php }?>
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
	
}
function show_tooltipsdetail(gid) {
	var objDiv = document.getElementById("show_tooltipsdetail"+gid);
	<?php if($_GET[page] != ''){?>
	var objpage = window.top.document.getElementById("hdd_page").value;
	url='tooltips_listsub.php?gtips_id='+gid+'&page='+objpage;
	<?php }else{ ?>
	url='tooltips_listsub.php?gtips_id='+gid;
	<?php }?>
	objDiv.style.display ='';
	
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					document.getElementById("img_plus"+gid).style.display ='none';
					document.getElementById("img_minus"+gid).style.display ='';
			}
		}
	);
	
}
function hide_tooltipsdetail(gid) {
	var objDiv = document.getElementById("show_tooltipsdetail"+gid);
	objDiv.style.display ='none';
	document.getElementById("img_plus"+gid).style.display ='';
	document.getElementById("img_minus"+gid).style.display ='none';
}
</script>
</head>
<body>
<table width="100%" border="0">
<?php
if($_GET[page] != ''){
$sql = "select tips_list.tips_group_id,tips_group_name from tips_list inner join tips_main on tips_main.tips_list_id = tips_list.tips_list_id inner join tips_group on tips_group.tips_group_id = tips_list.tips_group_id where tips_main.tips_main_type_id = '".$_GET[page]."' GROUP BY  tips_list.tips_group_id order by  tips_group_name ASC";
}else{
$sql = "select  tips_group_id,tips_group_name from tips_group order by  tips_group_name ASC";
}
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
?>
  <tr>
    <td><img id="img_plus<?php echo $R[tips_group_id];?>" src="../mainpic/plus.gif" border="0"  alt="" onClick="show_tooltipsdetail(<?php echo $R[tips_group_id];?>);"><img id="img_minus<?php echo $R[tips_group_id];?>" src="../mainpic/minus.gif" border="0" alt=""  style="display:none" onClick="hide_tooltipsdetail(<?php echo $R[tips_group_id];?>);"><a href="#G" onClick="show_detail(<?php echo $R[tips_group_id];?>);" accesskey=<?php echo $db->genaccesskey();?>><span  class="text_normal"><?php echo $R[tips_group_name];?></span></a></td>
  </tr>
  <tr  >
    <td><div id="show_tooltipsdetail<?php echo $R[tips_group_id];?>"></div></td>
  </tr>

 <? } ?>
</table>
</body>
</html>
<?php $db->db_close(); ?>
