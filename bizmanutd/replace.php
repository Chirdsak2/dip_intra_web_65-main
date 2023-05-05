<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");
$txt = "";
if($_POST["search"] != "" AND $_POST["Flag"] == "Replace" ){

	for($i=0;$i<$_POST["allx"];$i++){
		$mydb = $_POST["chk".$i];
		if($mydb != ""){
			$db->query("USE ".$mydb);
			$txt .= "<hr>Access to ".$mydb."<hr>";
			
				$sql_sharec = $db->query("SELECT n_id,link_html FROM article_list WHERE link_html LIKE '%".$_POST["search"]."%' ");
					while($C=$db->db_fetch_array($sql_sharec)){
						$link_html = eregi_replace($_POST["search"],$_POST["replace"],$C["link_html"]);
						$db->query("UPDATE article_list SET link_html = '".addslashes($link_html)."' WHERE n_id = '".$C["n_id"]."' ");
					}
					$txt .= "Update article_list (".$db->db_num_rows($sql_sharec).")<br>";

				$sql_sharec = $db->query("SELECT ad_id,ad_des FROM article_detail WHERE ad_des LIKE '%".$_POST["search"]."%' ");
					while($C=$db->db_fetch_array($sql_sharec)){
						$link_html = eregi_replace($_POST["search"],$_POST["replace"],$C["ad_des"]);
						$db->query("UPDATE article_detail SET ad_des = '".addslashes($link_html)."' WHERE ad_id = '".$C["ad_id"]."' ");
					}
					$txt .= "Update article_detail (".$db->db_num_rows($sql_sharec).")<br>";

				$sql_sharec = $db->query("SELECT BID,block_html FROM block WHERE block_html LIKE '%".$_POST["search"]."%' ");
					while($C=$db->db_fetch_array($sql_sharec)){
						$replacehtml = eregi_replace($_POST["search"],$_POST["replace"],$C["block_html"]);
						$db->query("UPDATE block SET block_html = '".addslashes($replacehtml)."' WHERE BID = '".$C["BID"]."' ");
					}
					$txt .= "Update block (".$db->db_num_rows($sql_sharec).")<br>";

				$sql_sharec = $db->query("SELECT text_id,text_html FROM block_text WHERE text_html LIKE '%".$_POST["search"]."%' ");
					while($C=$db->db_fetch_array($sql_sharec)){
						$replacehtml = eregi_replace($_POST["search"],$_POST["replace"],$C["text_html"]);
						$db->query("UPDATE block_text SET text_html = '".addslashes($replacehtml)."' WHERE text_id = '".$C["text_id"]."' ");
					}
					$txt .= "Update block_text (".$db->db_num_rows($sql_sharec).")<br>";			

				$sql_sharec = $db->query("SELECT mp_id,Glink FROM menu_properties WHERE Glink LIKE '%".$_POST["search"]."%' ");
					while($C=$db->db_fetch_array($sql_sharec)){
						$replacehtml = eregi_replace($_POST["search"],$_POST["replace"],$C["Glink"]);
						$db->query("UPDATE menu_properties SET Glink = '".addslashes($replacehtml)."' WHERE mp_id = '".$C["mp_id"]."' ");
					}
					$txt .= "Update menu_properties (".$db->db_num_rows($sql_sharec).")<br>";			
					
		}
	}
	$db->query("USE ".$EWT_DB_NAME);
	
}
?>
<html>
<head>
<title>Document Management System</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="content-type" content="text/html;charset=UTF-8">
</head>
<script>
function hidestatus(){
window.status=''
return true
}
if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)
document.onmouseover=hidestatus
document.onmouseout=hidestatus
function chkall(c){
var allx = document.form1.allx.value;
	if(c.checked == true){
		for(i=0;i<allx;i++){
			document.form1.elements["chk" + i].checked = true;
		}
	}else{
		for(i=0;i<allx;i++){
			document.form1.elements["chk" + i].checked = false;
		}
	}
}
</script>
<body bgcolor="#FFFFFF"  leftmargin="0" topmargin="0">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td height="10" >
	<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#336633">
        <form action="replace.php" method="post" name="form1">
          <tr> 
            <td><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Replace 
              tool</strong></font></td>
          </tr>
          <tr > 
            <td align="center"><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong> 
              Search for 
              <input name="search" type="text" id="search" size="30" >
              Replace with 
              <input name="replace" type="text" id="replace" size="30" >
              <input type="submit" name="Submit2" value="Replace all" >
              <input name="Flag" type="hidden" id="Flag" value="Replace">
              </strong></font></td>
          </tr>
		  <?php
		  $sql = $db->query("SELECT EWT_User,db_db FROM user_info WHERE EWT_Status = 'Y'");
		  ?>
		  <tr> 
            <td bgcolor="#CCCCCC"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"> 
              <input type="checkbox" name="checkbox" value="checkbox" onClick="chkall(this)">
              <strong>All Web</strong></font>
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
			  <?php
			  	$x=0;
				while($B = $db->db_fetch_row($sql)){
		if($x%7 == 0){
		echo "<tr>";
		}
			  ?>
                
                  <td width="14%"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"> 
              <input type="checkbox" name="chk<?php echo $x; ?>" value="<?php echo $B[1]; ?>">
              <?php echo $B[0]; ?></font></td>
                <?php
							$x++;
		if($x%7 == 0){
		echo "</tr>";
		}
	}
				?>
              </table></td>
          </tr>
		  <input type="hidden" name="allx" value="<?php echo $x; ?>">
        </form>
      </table>
	</td>
  </tr>
  <tr>
    <td valign="top" ><font size="2" face="Tahoma"><strong><?php echo $txt; ?></strong></font></td>
  </tr>
</table>
</body>
</html>

