<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

	?>
<html>
<head>
<title>Article Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="E0DFE3">
  <tr>
    <td><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td height="10"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>Block : <?php echo $R[0]; ?></strong></td>
              </tr>
              <tr>
                <td height="10"><hr width="100%" size="1"  align="left"  color="#D8D2BD">
                  <span class="ewtsubmenu"><a href="graph_list.php?B=<?php echo $_GET["B"]; ?>" target="graph_move"><img src="../theme/main_theme/bullet.gif" border="0" width="16" height="16" align="absmiddle">Graph name</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="ewtsubmenu"><a href="themes_list.php?B=<?php echo $_GET["B"]; ?>"  target="graph_move"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">Theme Design for block </a></span>				 </td>
              </tr>
              <tr>
                  <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td >&nbsp;</td>
                    </tr>
                    <tr> 
                      <td><iframe name="graph_move" src="graph_list.php?B=<?php echo $_GET["B"]; ?>" frameborder="1" width="100%" height="100%" scrolling="yes"></iframe></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

<?php if($graph_id>0){?>
			<script language="JavaScript">
			window.open ('content_graph.php?graph_id=<?php echo  $_GET['graph_id']; ?>&B=<?php echo $_GET["B"]; ?>','mywindow','status=1,toolbar=0'); 
			</script>
<?php } ?>

<?php $db->db_close(); ?>
