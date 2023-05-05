<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/menu_language.php");
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
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
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
				function Moveto(c){
					if(confirm("คุณต้องการย้ายเมนูหรือไม่?")){
						document.form1.newpos.value = c;
						form1.submit();
						}
				}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#333333" class="ewttableuse">
  <form name="form1" method="post" action="menu_function.php">
  <input name="Flag" type="hidden" id="Flag" value="Move"><input name="m_id" type="hidden" id="m_id" value="<?php echo $_GET["m_id"]; ?>"><input name="mp_id" type="hidden" id="mp_id" value="<?php echo $_GET["mp_id"]; ?>"><input name="newpos" type="hidden" id="newpos" value="">
    <tr> 
      <td height="15" class="ewttablehead"><img src="../theme/main_theme/menu_structure.gif" width="24" height="24" align="absmiddle"> <?php echo $text_menu_move; ?>
</td>
    </tr>
    <tr>
      <td height="15" bgcolor="#FFFFFF" ><img src="../theme/main_theme/menu_list.gif" width="21" height="20" border="0" align="absmiddle">&nbsp;&nbsp;<?php echo $M["m_name"]; ?></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php 
	$i = 1;
		while($R = $db->db_fetch_array($sql_menu_sub)){
		
	 ?>
          <tr> 
            <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;
              <?php GenPic($R[mp_id]); ?>
			  <?php
		$sql_move = $db->query("SELECT mp_id FROM menu_properties WHERE mp_id = '".$R["mp_id"]."' AND mp_id LIKE '".$_GET[mp_id]."%' AND m_id = '".$R["m_id"]."' ");
		$MC = $db->db_num_rows($sql_move);
		?>
              <?php if($MC ==0){ ?><a href="#" onClick="Moveto('<?php echo $R["mp_id"]; ?>')"  onMouseOver="document.all.showsp<?php echo $i; ?>.style.display='';" onMouseOut="document.all.showsp<?php echo $i; ?>.style.display='none';"  ><?php } ?><img src="../theme/main_theme/menu_list.gif" width="21" height="20" border="0" align="absmiddle"> 
              <span <?php if($_GET["mp_id"] == $R[mp_id]){ ?>style="background-color:'#DDDDDD'"<?php } ?>><?php echo $R["mp_name"]; ?></span>
		<?php if($MC ==0){ ?></a><br><span id="showsp<?php echo $i; ?>" style="display:none"> 
        &nbsp;&nbsp;&nbsp;&nbsp;<?php GenPic($R["mp_id"]); ?> 
        <img src="../images/element_insert.gif" width="40" height="20" border="0" align="absmiddle"> 
        <font color="#999999">ย้ายมาต่อจาก<?php echo $R["mp_name"]; ?></font></span> <?php } ?>
			  </td>
          </tr>
          <?php $i++; } ?>
        </table></td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
