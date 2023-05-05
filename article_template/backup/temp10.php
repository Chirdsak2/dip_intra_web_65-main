<script language=JavaScript src='../scripts/innovaeditor.js'></script>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td align="center"><strong><?php echo $R["n_topic"]; ?></strong></td>
  </tr>
</table>

<table width="99%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
  <?php
	  //echo "SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '1' AND at_type_col = '1' ";
	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '1' AND at_type_col = '1' ");
	  $C1 = $db->db_fetch_array($sql_r);
	  ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td width="100%" ><?php echo $C1["ad_des"];?>
    <textarea name="dx1y0" cols="80" rows="12" id="dx1y0"  wrap="VIRTUAL">
	<?php
			  function encodeHTML($sHTML)
				{
				$sHTML=ereg_replace("&","&amp;",$sHTML);
				$sHTML=ereg_replace("<","&lt;",$sHTML);
				$sHTML=ereg_replace(">","&gt;",$sHTML);
				return $sHTML;
				}
			  if(isset($C1["ad_des"]))
				{
				$sContent=stripslashes($C1["ad_des"]); /*** remove (/) slashes ***/
				echo encodeHTML($sContent);
				}
		  ?>
			</textarea>
    <script>
		var oEdit1 = new InnovaEditor("oEdit1");
		
		oEdit1.width="700";
		oEdit1.height="400";
		
		oEdit1.mode="HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"
		
		oEdit1.REPLACE("dx1y0");
		</script>
		</td>
  </tr>
  <?php
$b = 1;
$sql = $db->query("SELECT MAX(at_type_row) FROM article_detail WHERE n_id = '$nid'");
$M = $db->db_fetch_row($sql);
for($a=2;$a<=$M[0];$a++){
$sql_l = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$a' AND at_type_col = '1' ");

	if($db->db_num_rows($sql_l) > 0){
	$C1 = $db->db_fetch_array($sql_l);
?>
  <?php $b++; }} ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="right" valign="top"><input name="allx" type="hidden" id="allx" value="2"> 
      <input name="ally" type="hidden" id="ally" value="<?php echo $b; ?>"> 
      <!--<img src="../images/add2.gif" width="32" height="32" border="0" align="absmiddle"> 
      <strong>Add Row</strong>-->    </td>
  </tr>
</table>
