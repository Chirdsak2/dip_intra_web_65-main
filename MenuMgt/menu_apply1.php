<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

function GenPic($data){
$s = explode("_",$data);
	for($i=2;$i<count($s);$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}

$sql_menu = $db->query("SELECT m_id,m_name FROM menu_list WHERE m_id = '".$_GET["m_id"]."' ");
$M = $db->db_fetch_array($sql_menu);
$sql_menu_sub = $db->query("SELECT mp_id,m_id,mp_name FROM menu_properties WHERE m_id = '".$_GET["m_id"]."' ORDER BY mp_id ASC");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
			function exit(){
				self.top.ewt_main.location.href = "menu_index.php";
			}
			function hlah(c){
				var d = document.form1.num.value;
				for(i=0;i<d;i++){
				if(i == c){
					document.getElementById('ah'+i).style.backgroundColor = "#E6E6E6";
				}else{
					document.getElementById('ah'+i).removeAttribute("style");
				}
				}
			}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#333333">
<form name="form1" method="post" action="menu_function.php">
  <tr> 
    <td height="30" background="../images/m_bg.gif" bgcolor="E8F1F8">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td>&nbsp;&nbsp;<strong><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> 
              Apply Menu</strong>&nbsp;</td>
          </tr>
        </table></td>
  </tr>
  <tr> 
    <td height="30" valign="middle" bgcolor="#E6E6E6"><div align="left">
          <input type="submit" name="Submit" value="Apply">
          <input type="button" name="Submit2" value="Back" onClick="self.location.href = 'menu_detail.php?mp_id=<?php echo $_GET["mp_id"]; ?>&tb_show=<?php echo $_GET["tbshow"]; ?>';">
        </div>  </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php 
	$i = 0;
		while($R = $db->db_fetch_array($sql_menu_sub)){
	 ?>
        <tr>
          <td valign="top">&nbsp;<?php GenPic($R[mp_id]); ?><input type="checkbox" name="use<?php echo $i; ?>" value="<?php echo $R["mp_id"]; ?>" <?php if($R[mp_id] == $_GET["mp_id"]){ echo "disabled"; } ?>> <img src="../images/element.gif" width="21" height="20" border="0" align="absmiddle"> <?php echo $R["mp_name"]; ?>
              </td>
        </tr>
		<?php $i++; } ?>
      </table>
	  <input name="num" type="hidden" id="num" value="<?php echo $i; ?>"><input name="Flag" type="hidden" id="Flag" value="Apply"><input name="mp_id" type="hidden" id="mp_id" value="<?php echo $_GET["mp_id"]; ?>"><input name="m_id" type="hidden" id="m_id" value="<?php echo $_GET["m_id"]; ?>"><input name="tb_show" type="hidden" id="tb_show" value="<?php echo $_GET["tb_show"]; ?>">
	  </td>
  </tr>
  </form>
</table>
</body>
</html>
<?php
$db->db_close(); ?>