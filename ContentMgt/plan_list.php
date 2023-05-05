<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
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
						$sql_like = $db->query("SELECT source FROM article_list WHERE source LIKE '%".$word_e."%'  GROUP BY source ORDER BY  source LIMIT 0,12");
						$like = $db->db_num_rows($sql_like);
						if($like > 0){
					?>
<body leftmargin="0" topmargin="0">

<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#666666"  >
  <tr>
     <td bgcolor="#FFFFFF" valign="top">
			<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" >
			  <tr>
				<td valign="top" bgcolor="#FFFFFF" width="99%"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF"  style="font-family:Tahoma;font-size:11px;">
								<?php if($like > 0){
									while($L = mysql_fetch_array($sql_like)){ 
									$word = str_replace($word_e,"<font color=green><b>".$word_e."</b></font>",$L["source"]);
									?>
								<tr> 
								  <td onClick="document.form1.source.focus();document.form1.source.value='<?php echo $word_b; ?><?php echo $L["source"]; ?>';document.getElementById('nav').style.display='none';" style="cursor:hand"><?php echo $word; ?></td>
								</tr>
								<?php }} ?>
							  </table>
							  </td>
							  
				<td valign="top" bgcolor="#FFFFFF"><img src="../images/close.gif"  width="16" onClick="document.all.nav.style.display='none'" style="cursor:hand" alt="ปิด"></td>
			  </tr>
			</table>
		</td>
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