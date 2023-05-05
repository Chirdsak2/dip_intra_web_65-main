<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
$db->query("USE ".$EWT_DB_NAME);
$d = $_REQUEST["d"];
if($d != ""){
		$d = stripslashes(htmlspecialchars(trim($d),ENT_QUOTES));
		$data = $d;
		$data = @str_replace('+',' ',$data);
		$data = @str_replace('*',' ',$data);
		$dt = explode(" ",$data);
		$num = count($dt);
		$word_b = "";
		for($i=0;$i<($num-1);$i++){
			$word_b .= $dt[$i]." ";
		}
		$word_e = $dt[($num-1)];
						$sql_like = $db->query("SELECT name_org FROM org_name WHERE name_org LIKE '%".$word_e."%'  GROUP BY name_org ORDER BY  name_org LIMIT 0,12");
						$like = $db->db_num_rows($sql_like);
						if($like > 0){
					?>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#666666"  >
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF"  style="font-family:Tahoma;font-size:11px;">
                    <?php if($like > 0){
						while($L = mysql_fetch_array($sql_like)){ 
						$word = str_replace($word_e,"<font color=green><b>".$word_e."</b></font>",$L["name_org"]);
						?>
                    <tr> 
                      <td onClick="document.form1.org_id.focus();document.form1.org_id.value='<?php echo $word_b; ?><?php echo $L["name_org"]; ?>';document.getElementById('nav').style.display='none';" style="cursor:hand"><?php echo $word; ?></td>
                    </tr>
                    <?php }} ?>
                  </table></td>
  </tr>
</table>
<?php }else{
?>
<script type="text/javascript" language="JavaScript">
document.all.nav.style.display='none';
</script>
<?php
}} ?>
<?php $db->db_close(); ?>