<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	include("include/did.php");
	include("ewt_template.php");
	$db->access=200;
?>
<?php echo $template_design[0];?>
<?php
			$mainwidth = $F["d_site_content"];
			?><?php
		  $sql_content = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>

		<?php } ?>
	<?php
$db->query("USE ".$EWT_DB_USER);
$sql_member = $db->query("SELECT gen_user.gen_user_id , title.title_thai,gen_user.name_thai,gen_user.surname_thai,org_name.name_org,gen_user.position_person FROM gen_user LEFT JOIN title ON title.title_id = gen_user.title_thai INNER JOIN org_name ON org_name.org_id = gen_user.org_id WHERE emp_type_id = '3' ");
?>	<br>
<span class="style1">สมาชิกรัฐสภา</span>  <br>

<table width="96%" border="0" cellpadding="3" cellspacing="1" bgcolor="#E7E7E7">
  <tr>
    <td bgcolor="#CCCCCC" width="35%"><h1>ชื่อ-นามสกุล</h1></td>
    <td bgcolor="#CCCCCC" width="25%"><h1>พรรค</h1></td>
    <td bgcolor="#CCCCCC" width="30%"><h1>เขต</h1></td>
	<td width="10%" align="center" bgcolor="#CCCCCC"><h1>เว็บไซต์</h1></td></td>
  </tr>
  <?php
  while($M = $db->db_fetch_row($sql_member)){
  ?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#FFCCFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">
    <td><?php echo $M[1]." ".$M[2]." ".$M[3]; ?></td>
    <td ><?php echo $M[4]; ?></td>
    <td><?php echo $M[5]; ?></td>
	<td align="center"><a href="parliament_index.php?m=<?php echo $M[0]; ?>" target="_blank" accesskey=<?php echo $db->genaccesskey();?>>เว็บไซต์</a></td>
  </tr>
  <?php } 
  $db->query("USE ".$EWT_DB_NAME);
  ?>
</table>
<br>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>