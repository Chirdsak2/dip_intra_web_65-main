<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
$path = "../";
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	$EWT_DB_USER = 'ewt_user';
$db->query("USE ".$EWT_DB_USER);
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
						$sql_like = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '".$word_e."%' GROUP BY DICT_WORD ORDER BY DICT_WORD LIMIT 0,12");
						$like = $db->db_num_rows($sql_like);
						if($like > 0){
					?>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#666666"  >
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF"  style="font-family:Tahoma;font-size:11px;">
                    <?php if($like > 0){
						while($L = $db->db_fetch_array($sql_like)){ 
						$word = str_replace($word_e,"<font color=green><b>".$word_e."</b></font>",$L["DICT_WORD"]);
						?>
                    <tr> 
                      <td onClick="document.formSearchAEWT.keyword.focus();document.formSearchAEWT.keyword.value='<?php echo $word_b; ?><?php echo $L["DICT_WORD"]; ?>';document.getElementById('nav').style.display='none';" style="cursor:hand"><?php echo $word; ?></td>
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