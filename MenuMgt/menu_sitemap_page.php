<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

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
          <td height="30" align="center" bgcolor="#CCCCCC" class="TxtNormal"><strong>Web page</strong></td>
        </tr>
        <tr> 
         <td align="left" valign="top" bgcolor="#F7F7F7" id="tbunuse" >
            <?php
			$qFolder=$db->query('SELECT * FROM temp_main_group ORDER BY Main_Position ASC');
		  while($rFolder = $db->db_fetch_array($qFolder)){
				$numSpace=sizeof(explode('_',$rFolder['Main_Position']));
		  ?>
            <DIV class=DragBox id="EWTID_S<?php echo $G["m_id"]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left" style="padding-left:<?php echo $numSpace*10; ?>px"> 
               <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $rFolder['Main_Group_Name']; ?>
               
               <?php echo $G["m_name"]; ?></DIV>
<?php
				$qFile=$db->query('SELECT * FROM temp_index WHERE Main_Group_ID = \''.$rFolder['Main_Group_ID'].'\' ORDER BY filename ASC');
			  while($rFile=$db->db_fetch_array($qFile)){
?>
					<DIV class=DragBox id="EWTID_S<?php echo $rFile['filename']; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left" style="padding-left:<?php echo ($numSpace*5)+25; ?>px">
          <a href="menu_sitemap_page_select.php?filename=<?php echo $rFile['filename']; ?>&sid=<?php echo $_GET['sid']; ?>"><img src="../images/content_page.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $rFile['filename']; ?></a>
           
           <?php echo $G["m_name"]; ?></DIV>
<?php
				}
				//loopChild($rFolder['Main_Position']);
			}
?>
          </td>
        </tr>
		<tr> 
          <td height="30" align="center" bgcolor="#CCCCCC" class="TxtNormal">
            <input type="button" name="Button" value=" Submit" onClick="window.location.href='menu_sitemap_select.php?sid=<?php echo $_GET["sid"]; ?>';" class="TxtNormal"></td>
        </tr>
      </table></td>
  </tr>
</table>
<iframe name="auto_save2" src="menu_sitemap_function.php?sid=<?php echo $_GET["sid"];?>"  frameborder="0"  width="0" height="0" scrolling="no" ></iframe>
</body>
</html>

<?php
	function loopChild($mainPosition) {
		global $db;
		$qFolder=$db->query('SELECT * FROM temp_main_group WHERE Main_Position LIKE \''.$mainPosition.'_%\' ORDER BY Main_Position ASC');
		while($rFolder = $db->db_fetch_array($qFolder)){
			$numSpace=sizeof(explode('_',$rFolder['Main_Position']));
		?>
					<DIV class=DragBox id="EWTID_S<?php echo $G["m_id"]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left" style="padding-left:<?php echo ($numSpace*5); ?>px">
          &nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/content_page.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $rFolder['Main_Group_Name']; ?>
						 
						 <?php echo $G["m_name"]; ?></DIV>
<?php
			$qFile=$db->query('SELECT * FROM temp_index WHERE Main_Group_ID = \''.$rFolder['Main_Group_ID'].'\' ORDER BY filename ASC');
			while($rFile=$db->db_fetch_array($qFile)){
?>
				<DIV class=DragBox id="EWTID_S<?php echo $rFile['filename']; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left" style="padding-left:<?php echo ($numSpace*5)+25; ?>px">
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="menu_sitemap_page_select.php?filename=<?php echo $rFile['filename']; ?>"><img src="../images/content_page.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $rFile['filename']; ?></a>
				 
				 <?php echo $G["m_name"]; ?></DIV>
<?php
			}
			loopChild($rFolder['Main_Position']);
		}
}
	$db->db_close();
?>
