<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$sql_sitemap = $db->query("SELECT menu_sitemap_list.*,menu_list.m_name FROM menu_sitemap_list INNER JOIN menu_list ON menu_sitemap_list.m_id = menu_list.m_id  AND menu_sitemap_list.s_id = '".$_GET["sid"]."' AND sm_active ='Y'");
if($db->db_num_rows($sql_sitemap) == 0){
?>
<script language="JavaScript">
window.location.href='menu_sitemap_select.php?sid=<?php echo $_GET["sid"]; ?>';
</script>
<?php
exit;
}
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
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
		auto_save2.document.form1.mid.value = d;
		auto_save2.form1.submit();
	}
	function edisign(c,d){
	if(c.src.search('a_c_use.gif') > 0){
	win2 = window.open('menu_sitemap.php?mid='+ d +'&sid=<?php echo $_GET["sid"]; ?>','sitemapdisign','height=500,width=600,resizable=1,scrollbars=1');
	win2.focus();
	}
	}
</script>
</head>
<body id=Demo4 leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
  <tr> 
    <td width="50%" align="center" valign="top"> <table width="360" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#333333">
        <tr> 
          <td height="30" align="center" bgcolor="#CCCCCC" class="TxtNormal"><strong>Menu 
            Group</strong></td>
        </tr>
        <tr> 
         <td align="center" valign="top" bgcolor="#F7F7F7" id="tbunuse" > 
            <?php
		  while($G = $db->db_fetch_array($sql_sitemap)){ 
		  ?>
            <DIV class=DragBox id="EWTID_S<?php echo $G["m_id"]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left" style="cursor:hand;"> 
               <?php if($G["sm_active"] == "Y"){ ?> <img src="../images/checked_y.gif" id="chk<?php echo $G["m_id"]; ?>" name="chk<?php echo $G["m_id"]; ?>" width="13" height="13" align="absmiddle"  onClick="autoset(this,'<?php echo $G["m_id"]; ?>')"> <img  id="flo<?php echo $G["m_id"]; ?>" name="flo<?php echo $G["m_id"]; ?>" src="../images/a_f_use.gif" width="16" height="16" border="0" align="absmiddle"> <img id="des<?php echo $G["m_id"]; ?>" name="des<?php echo $G["m_id"]; ?>" src="../images/a_c_use.gif" width="16" height="16" align="absmiddle" onClick="edisign(this,'<?php echo $G["m_id"]; ?>')"> <?php }else{ ?> <img  id="chk<?php echo $G["m_id"]; ?>" name="chk<?php echo $G["m_id"]; ?>" src="../images/checked_n.gif" width="13" height="13" align="absmiddle" onClick="autoset(this,'<?php echo $G["c_id"]; ?>')"> <img id="flo<?php echo $G["m_id"]; ?>" name="flo<?php echo $G["m_id"]; ?>" src="../images/a_fn_use.gif" width="16" height="16" border="0" align="absmiddle"> <img id="des<?php echo $G["c_id"]; ?>" name="des<?php echo $G["m_id"]; ?>" src="../images/a_cn_use.gif" width="16" height="16" align="absmiddle"  onClick="edisign(this,'<?php echo $G["m_id"]; ?>')"> <?php } ?>
               
               <?php echo $G["m_name"]; ?></DIV>
	<?php }?>
          </td>
        </tr>
		<tr> 
          <td height="30" align="center" bgcolor="#CCCCCC" class="TxtNormal">
            <input type="button" name="Button" value=" เพิ่มชุดเมนู " onClick="window.location.href='menu_sitemap_select.php?sid=<?php echo $_GET["sid"]; ?>';" class="TxtNormal"></td>
        </tr>
      </table></td>
  </tr>
</table>
<iframe name="auto_save2" src="menu_sitemap_function.php?sid=<?php echo $_GET["sid"];?>"  frameborder="0"  width="0" height="0" scrolling="no" ></iframe>
</body>
</html>

<?php $db->db_close(); ?>
