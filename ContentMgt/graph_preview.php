<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$_GET["graph_id"]."'");
$R = $db->db_fetch_array($sql_graph);

	?>
<html>
<head>
<title>Graph Management [<?php echo $_GET["filename"]; ?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="E0DFE3">
  <tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td valign="top" bgcolor="F7F7F7">
              <table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="F7F7F7">
                <tr valign="top"> 
                  <td height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>Page : <?php echo $_GET["filename"]; ?></strong> </td>
                </tr>
                <tr valign="top"> 
                  <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="F7F7F7">
                      <tr >
                        <td valign="top" ><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
          <tr>
                              <td width="100" align="center" background="../images/bg1_off.gif"><a href="content_graph.php?graph_id=<?php echo $_GET["graph_id"]; ?>&B=<?php echo $_GET["B"]; ?>&tb_show=1">Graph 
                                Setting</a>s </td>
                              <td width="100" align="center" background="../images/bg1_off.gif"><a href="content_graph.php?graph_id=<?php echo $_GET["graph_id"]; ?>&B=<?php echo $_GET["B"]; ?>&tb_show=2">Graph 
                                Style</a></td>
								
                              <td width="100" align="center" background="../images/bg1_off.gif"><a href="content_graph.php?graph_id=<?php echo $_GET["graph_id"]; ?>&B=<?php echo $_GET["B"]; ?>&tb_show=3">Graph 
                                Data</a></td>
                              <td width="100" align="center" background="../images/bg1_on.gif">Graph 
                                Preview</td>
            <td background="../images/bg2_off.gif">&nbsp;</td>
          </tr>
        </table>
		<table width="100%" height="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="graph_data" src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_graph_frame.php?graph_id=<?php echo $_GET["graph_id"]; ?>" frameborder="0"  width="100%" height="100%" scrolling="yes" ></iframe></td>
                      </tr>
                      
                    </table>
                          
                      </td>
                      </tr>
                    </table> </td>
                </tr>
                
              <tr valign="top"> 
                <td height="20" align="right">
                  <input type="button" name="Submit2" value="Close" onClick="self.close();"></td>
                </tr>
              </table> </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
