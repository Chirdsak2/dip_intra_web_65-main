<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		
		$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT BID FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_array($sql_file);

$sql_article = $db->query("SELECT article_group.*,article_apply.a_active FROM article_group INNER JOIN article_apply ON article_group.c_id = article_apply.c_id  AND article_apply.text_id = '".$R["BID"]."' AND article_apply.a_active = 'Y' ORDER BY article_apply.a_active DESC,article_apply.a_pos ASC,article_group.c_id ASC");
if($db->db_num_rows($sql_article) == 0){
?>
<script language="JavaScript">
window.location.href='article_position_select.php?B=<?php echo $_GET["B"]; ?>';
</script>
<?php
exit;
}
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../css/dragdrop_a.css" type=text/css rel=stylesheet>
<script language="JavaScript" src="../js/drag_drop_a.js"></script>
<script language="JavaScript">
	function autosave(){
		auto_save1.document.form1.tagdetect.value=document.all.tbunuse.innerHTML;
		auto_save1.form1.submit();
		window.close();
	}
	function autoset(c,d){
		if(c.src.search('checked_y.gif') > 0){
			c.src = "../images/checked_n.gif";
			document.getElementById('flo'+d).src = "../images/a_fn_use.gif";
			document.getElementById('des'+d).src = "../images/a_cn_use.gif";
			auto_save2.document.form1.active.value = "N";
		}else{
			c.src = "../images/checked_y.gif";
			document.getElementById('flo'+d).src = "../images/a_f_use.gif";
			document.getElementById('des'+d).src = "../images/a_c_use.gif";
			auto_save2.document.form1.active.value = "Y";
		}
		auto_save2.document.form1.cid.value = d;
		auto_save2.form1.submit();
	}
	function edisign(c,d){
	if(c.src.search('a_c_use.gif') > 0){
	win2 = window.open('article_edesign.php?cid='+ d +'&B=<?php echo $_GET["B"]; ?>','edisign','height=500,width=600,resizable=1,scrollbars=1');
	win2.focus();
	}
	}
</script>
</head>
<body id=Demo4 leftmargin="0" topmargin="0">
<div align="right"> </div>
<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
  <tr> 
    <td width="50%" align="center" valign="top"> <table width="260" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#333333">
        <tr> 
          <td height="30" align="center" bgcolor="#CCCCCC" class="TxtNormal"><strong>Article 
            Group</strong><br>
            (Move box to manage position)</td>
        </tr>
        <tr> 
          <td align="center" valign="top" bgcolor="#F7F7F7" id="tbunuse" > 
            <?php
		  while($G = $db->db_fetch_array($sql_article)){ 
		  ?>
            <DIV class=DragBox id="EWTID_S<?php echo $G["c_id"]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> 
               <?php if($G["a_active"] == "Y"){ ?> <img src="../images/checked_y.gif" id="chk<?php echo $G["c_id"]; ?>" name="chk<?php echo $G["c_id"]; ?>" width="13" height="13" align="absmiddle"  onClick="autoset(this,'<?php echo $G["c_id"]; ?>')"> <img  id="flo<?php echo $G["c_id"]; ?>" name="flo<?php echo $G["c_id"]; ?>" src="../images/a_f_use.gif" width="16" height="16" border="0" align="absmiddle"> <img id="des<?php echo $G["c_id"]; ?>" name="des<?php echo $G["c_id"]; ?>" src="../images/a_c_use.gif" width="16" height="16" align="absmiddle" onClick="edisign(this,'<?php echo $G["c_id"]; ?>')"> <?php }else{ ?> <img  id="chk<?php echo $G["c_id"]; ?>" name="chk<?php echo $G["c_id"]; ?>" src="../images/checked_n.gif" width="13" height="13" align="absmiddle" onClick="autoset(this,'<?php echo $G["c_id"]; ?>')"> <img id="flo<?php echo $G["c_id"]; ?>" name="flo<?php echo $G["c_id"]; ?>" src="../images/a_fn_use.gif" width="16" height="16" border="0" align="absmiddle"> <img id="des<?php echo $G["c_id"]; ?>" name="des<?php echo $G["c_id"]; ?>" src="../images/a_cn_use.gif" width="16" height="16" align="absmiddle"  onClick="edisign(this,'<?php echo $G["c_id"]; ?>')"> <?php } ?>
               
               <?php echo $G["c_name"]; ?></DIV>
            <?php
		  }
		  ?>
          </td>
        </tr>
		<tr> 
          <td height="30" align="center" bgcolor="#CCCCCC" class="TxtNormal">
            <input type="button" name="Button" value=" เพิ่มกลุ่ม " onClick="window.location.href='article_position_select.php?B=<?php echo $_GET["B"]; ?>';" class="TxtNormal"><input type="button" name="Button" value=" บันทึก " onClick="autosave()" class="TxtNormal"></td>
        </tr>
      </table></td>
  </tr>
</table>
<iframe name="auto_save1" src="../ewt_article_send.php?B=<?php echo $_GET["B"]; ?>"  frameborder="0"  width="0" height="0" scrolling="no" ></iframe>
<iframe name="auto_save2" src="../ewt_article_send1.php?B=<?php echo $_GET["B"]; ?>"  frameborder="0"  width="0" height="0" scrolling="no" ></iframe>
</body>
</html>
<?php } ?>
<?php $db->db_close(); ?>
