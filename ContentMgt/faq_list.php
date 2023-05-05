<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
	function GenPic($data){
		for($i=0;$i<=$data;$i++){
			echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
		}
	}
	function count_total($total){
	global $db;
			$sql_show = $db->query("SELECT * FROM f_subcat ");
			$total = $db->db_num_rows($sql_show);
			return $total;
	}
	function showgroup($start,$i,$id,$idp,$dis){
			global $db;
			$x = $i+1;
			$Blink = explode(',',$idp);
			$num = count($Blink);
			$sql_show = $db->query("SELECT * FROM f_subcat WHERE f_parent = '".$start."' ");
			$total = $db->db_num_rows($sql_show);
			$dis += $total;
			if($total>0){
							while($R = $db->db_fetch_array($sql_show)){
							   $cat_id=$R[f_sub_id];
							   $cat_name=$R["f_subcate"];
							   	$sql_show_child= $db->query("SELECT * FROM f_subcat WHERE f_parent = '".$cat_id."' ");
								$total_child = $db->db_num_rows($sql_show_child);
								echo GenPic($i).'<input type="checkbox" id='.$id.'  name="c_parent['.$id.']" value="'.$cat_id.'" ';
								
								for($y=0;$y<$num;$y++){
									if($Blink[$y] == $cat_id){
										echo ' checked ';
										break;
									}
								}
								echo ' onClick="disable_show(this);"><input name="numrow'.$cat_id.'"" type="hidden" value="'.$total_child.'"><input name="id'.$cat_id.'"" type="hidden" value="'.$id.'"><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> '.$cat_name."<br>";
								$go = $id+1;
								$total_child+=showgroup($cat_id,$x,$go,$idp,$dis);
								$id = $go+$total_child;
							}
			}
			return $total_child;
			
		}
if($_POST["Flag"] == "SET"){
$bcode = base64_decode($_POST["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$db->query("UPDATE block SET block_link = '".implode(",",$_POST["c_parent"])."' WHERE BID = '".$BID."' ");
$db->write_log("update","main","แก้ไข block 	faq");
?>
<script language="JavaScript">
window.location.href = "faq_list.php?B=<?php echo $_POST["B"]; ?>";
//self.close();
</script>
<?php
}else{
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name,block_link FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_array($sql_file);
$BLink=$R[block_link];
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function selectG(c){
document.form1.selected.value = c;
form1.submit(); 
}
function disable_show(t){

	if(t.checked==true){
		if(t.value == ''){
			for(var i=1;i<=(eval(document.getElementById('numrowtotal').value));i++){
				document.getElementById(i).checked = false;
				document.getElementById(i).disabled = true;
			}
		}else{
		    document.getElementById(0).checked = false;
			//for(var i=(eval(document.getElementById('id'+t.value).value)+1);i<((eval(document.getElementById('id'+t.value).value)+1)+eval(document.getElementById('numrow'+t.value).value));i++){
				//document.getElementById(i).checked = false;
				//document.getElementById(i).disabled = true;
			//}
		}
	}else{
		if(t.value == ''){
		 //alert('1');
			for(var i=1;i<=(eval(document.getElementById('numrowtotal').value));i++){
				document.getElementById(i).disabled = false;
			}
		}else{
		    //alert('2');
		    document.getElementById(0).checked = false;
			//for(var i=(eval(document.getElementById('id'+t.value).value)+1);i<((eval(document.getElementById('id'+t.value).value)+1)+eval(document.getElementById('numrow'+t.value).value));i++){
				//document.getElementById(i).checked = false ;
				//document.getElementById(i).disabled = false;
			//}
		}
	}
}

</script>

</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="faq_list.php">
<input name="Flag" type="hidden" id="Flag" value="SET">
<input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
<input type="hidden" name="selected">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">



  <tr bgcolor="#E6E6E6"> 
    <td><strong>FAQ group</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF" > 
   <td><DIV style="HEIGHT: 370;OVERFLOW-Y: scroll;WIDTH: 100%;">
		  <input name="c_parent[0]" id="0" type="checkbox" value="" <?php if($BLink == ""){ echo "checked"; } ?> onClick="disable_show(this);">
		  <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">หมวด FAQ ทั้งหมด<br>
		 <?php  showgroup(0,0,1,$BLink,"");  ?></DIV>
    </td>
  </tr>
    <tr bgcolor="#FFFFFF" > 
   <td align="right"><input name="submit" type="submit" value="บันทึก"><input name="numrowtotal" type="hidden" value="<?php echo count_total(0);?>"></td>
  </tr>

</table>
<?php
if($BLink == ""){
?>
<script language="JavaScript">
//alert('pp');
disable_show(document.getElementById(0));
</script>
<?php
}
?>
  </form>
</body>
</html>

<?php }} ?>
<?php

$db->db_close(); ?>
