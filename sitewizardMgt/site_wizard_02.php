<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE db_00_template");
function GenPic($data){
$s = explode("_",$data);
	for($i=2;$i<count($s);$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
?><html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Site Wizard</title>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: medium;
	color: #000000;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: xx-small;
}
.style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: small;
}
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: medium; color: #FFFFFF; }
.style11 {font-size: x-small}
-->
</style>
</head>

<body>
<table width="600" border="0">
  <tr>
    <td colspan="2" valign="top"><img src="images/top_help.jpg" alt="EasyWebTime Help" width="600" height="150" /></td>
  </tr>
  <tr>
    <td width="80%" height="206" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
      <tr>
        <td><table width="100%" border="0" cellpadding="2" cellspacing="1">
          <tr>
            <td height=25 background="images/block_bg_orange.jpg" bgcolor="#000066"><span class="style1">Step 2: Edit your menu</span></td>
          </tr><form action="" method="post" name="frm">
          <tr>
            <td height="320" valign="top" bgcolor="#FFFFFF">
			<div style="overflow:-moz-scrollbars-vertical; overflow-x:auto;overflow-y:auto; width:100%; height:330; " >
			<?php 
			$temp = "SELECT block.BID,block.block_name,block.block_link,block.block_type,block.block_edit FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE block.block_type= 'menu' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC";
			$sql_temp= $db->query($temp);
			$F = $db->db_fetch_array($sql_temp);
			//echo "SELECT * FROM menu_list WHERE m_id = '".$F[block_link]."' ";
			$sql = $db->query("SELECT * FROM menu_list WHERE m_id = '".$F[block_link]."' ");
			$R = $db->db_fetch_array($sql);
			$sql1 = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$F[block_link]."' ORDER BY mp_id ASC");
			?>
			 <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php 
	$i = 1;
		while($RR=$db->db_fetch_array($sql1)){
		if($i == '1'){
		$page = 'index';
		}else{
		$page = 'page'.(sprintf("%03d",$i-1));
		}
	 ?>
          <tr> 
            <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;
              <?php GenPic($RR[mp_id]); ?>
              <img src="../theme/main_theme/menu_list.gif" width="21" height="20" border="0" align="absmiddle"> 
              <input name="mp_name<?php echo $RR["mp_id"];?>" type="text"  value="<?php echo $RR["mp_name"];?>" size="30" >
			  <input name="mp_id<?php echo $i;?>" type="hidden" value="<?php echo $RR["mp_id"];?>"></td>
            <td valign="top"><input name="m_page<?php echo $RR["mp_id"];?>" type="text" size="12" value="<?php echo $page;?>"></td>
          </tr>
          <?php $i++; } ?>
        </table>
        <input name="num" type="hidden" id="num" value="<?php echo $i; ?>">
		<input name="d_id" type="hidden" id="d_id" value="<?php echo $_GET["d_id"];?>">
		<input name="m_id" type="hidden" id="m_id" value="<?php echo $F[block_link];?>">
		<input name="flag" type="hidden" id="flag" value="addtemplate">
			</div>
			</td>
          </tr>
          <tr>
            <td height="15" align="right" valign="top" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="site_wizard_01.php"><img src="../images/arrow_left_blue.gif" width="24" height="24" border="0" align="absmiddle">BACK</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="open1();" >NEXT<img src="../images/arrow_right_blue.gif"  width="24" height="24" border="0" align="absmiddle" />
              
            </a></td>
          </tr></form>
        </table></td>
      </tr>
    </table></td>
    <td width="20%" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
      <tr>
        <td><table width="100%" border="0" cellpadding="2" cellspacing="1">
            <tr>
              <td height="25" background="images/block_bg_dblue.jpg" bgcolor="#000066"><span class="style6">Note:</span></td>
            </tr>
            <tr>
                <td height="30" valign="top" bgcolor="#FFFFFF"><span class="style11">เลือกโครงสร้างของเมนูที่คุณต้องการ</span><span class="style3"><br />
                  <br />
                </span></td>
            </tr>
        </table></td>
      </tr>
    </table>
    <br />    </td>
  </tr>
  <tr>
    <td colspan="2"><span class="style2">&copy; 2008 BizPotential Co., Ltd.</span></td>
  </tr>
</table>
</body>
</html>
<script language="javascript1.2">
function open1(){

				//	var link_t = ;
					frm.action = 'functiontemplate.php';
					frm.submit();
}
</script>