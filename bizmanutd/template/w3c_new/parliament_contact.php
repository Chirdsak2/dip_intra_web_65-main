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
	include("ewt_template.php");
	if($_POST["Flag"] == "Send" AND $_POST["m"] != ""){

			$c_name = stripslashes(htmlspecialchars($_POST["c_name"],ENT_QUOTES));
			$c_surname = stripslashes(htmlspecialchars($_POST["c_surname"],ENT_QUOTES));
			$c_address = stripslashes(htmlspecialchars($_POST["c_address"],ENT_QUOTES));
			$c_email = stripslashes(htmlspecialchars($_POST["c_email"],ENT_QUOTES));
			$c_comment = stripslashes(htmlspecialchars($_POST["c_comment"],ENT_QUOTES));
			
					if($_SERVER["REMOTE_ADDR"]){
						$c_ip = $_SERVER["REMOTE_ADDR"];
					}else{
						$c_ip = $_SERVER["REMOTE_HOST"];
					}
					
					$db->query("INSERT INTO mp_contact (mp_member,contact_name,contact_surname,contact_address,contact_email,contact_comment,contact_date,contact_time,contact_ip,contact_deleted) VALUES ('".$_POST["m"]."','".$c_name."','".$c_surname."','".$c_address."','".$c_email."','".$c_comment."',NOW( ),NOW( ),'".$c_ip."','N') ");
			?>
			<script type="text/javascript">
			alert("ข้อความของท่านถูกส่งมายังสมาชิกเรียบร้อยแล้ว\n ขอขอบพระคุณ");
			window.location.href = "parliament_contact.php?m=<?php echo $_POST["m"]; ?>";
			</script>
			<?php
			exit();
}

$db->query("USE ".$EWT_DB_NAME);
$sql_check = $db->query("SELECT gen_user.gen_user_id , title.title_thai,gen_user.name_thai,gen_user.surname_thai,org_name.name_org,gen_user.position_person,gen_user.path_image FROM gen_user INNER JOIN title ON title.title_id = gen_user.title_thai INNER JOIN org_name ON org_name.org_id = gen_user.org_id WHERE gen_user_id = '".$_GET["m"]."' ");
$P = $db->db_fetch_array($sql_check);
$db->query("USE ".$EWT_DB_NAME);
$sql_check1 = $db->query("SELECT * FROM mp_profile WHERE mp_member = '".$_GET["m"]."' ");
$T = $db->db_fetch_array($sql_check1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
<?php include("ewt_script.php");?>
<script type="text/javascript"  language="javascript" >
function chk(){
	if(document.form1.c_name.value == ""){
		alert("กรุณาใส่ชื่อของท่าน");
		document.form1.c_name.focus();
		return false;
	}
		if(document.form1.c_surname.value == ""){
		alert("กรุณาใส่นามสกุลของท่าน");
		document.form1.c_surname.focus();
		return false;
	}
}
</script>
<style type="text/css">
<!--
.style2 {	font-size: 17px;
	color: #FFFFFF;
}
-->
</style>
</head>
<body <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?>>
<table <?php if($F["d_site_width"] != ""){ echo "width=\"".$F["d_site_width"]."\""; } ?> border="0" cellpadding="0" cellspacing="0" <?php if($F["d_site_align"] != ""){ echo "align=\"".$F["d_site_align"]."\""; } ?>>
  <tr>
    <td  <?php if($F["d_top_height"] != ""){ echo "height=\"".$F["d_top_height"]."\""; } ?> <?php  if($F["d_top_bg_c"] != ""){ echo "bgcolor=\"".$F["d_top_bg_c"]."\""; } ?>  colspan="3" >
	  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
	</td>
  </tr>
  <tr>
    <td  valign="top"  <?php if($F["d_site_left"] != ""){ echo "width=\"".$F["d_site_left"]."\""; } ?> <?php  if($F["d_left_bg_c"] != ""){ echo "bgcolor=\"".$F["d_left_bg_c"]."\""; } ?>>
	  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
	
	
	</td>
    <td height="160"  valign="top"  <?php if($F["d_site_content"] != ""){ echo "width=\"".$F["d_site_content"]."\""; } ?> <?php  if($F["d_body_bg_c"] != ""){ echo "bgcolor=\"".$F["d_body_bg_c"]."\""; } ?>>
	<?php
			$mainwidth = $F["d_site_content"];
			?><?php
		  $sql_content = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>

		<?php } ?>

	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
		 <td width="20%" valign="top"><table width="200" border="0" cellpadding="4" cellspacing="0" >
           <tr>
             <td><a href="parliament_index.php?m=<?php echo $_GET["m"]; ?>">หน้าหลัก</a></td>
           </tr>
           <tr>
             <td><a href="parliament_history.php?m=<?php echo $_GET["m"]; ?>">ประวัติสมาชิก</a></td>
           </tr>
           <tr>
             <td><a href="parliament_act.php?m=<?php echo $_GET["m"]; ?>">ผลงาน/กิจกรรม</a></td>
           </tr>
           <tr>
             <td><a href="parliament_contact.php?m=<?php echo $_GET["m"]; ?>">คุยกับสมาชิก</a></td>
           </tr>
         </table></td>
          <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="150" ><?php echo $P[title_thai]; ?> <?php echo $P[name_thai]; ?> <?php echo $P[surname_thai]; ?><br>
                พรรค <?php echo $P[name_org]; ?><br>
                <?php echo $P[position_person]; ?></td>
            </tr>
          </table>
          <table width="96%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td>
      <span class="style4">คุยกับสมาชิก</span></td>
  </tr>
  <tr>
    <td><hr>
    <form name="form1" method="post" action="parliament_contact.php" onSubmit="return chk();"><table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="790102">
      <tr>
        <td colspan="2" align="left" bgcolor="#C15C4A">ส่งข้อความถึงสมาชิกของท่าน</td>
        </tr>
      <tr>
        <td width="38%" align="left" valign="top" bgcolor="#FFFFFF">ชื่อ <span class="style5">*</span> </td>
        <td width="62%" align="left" valign="top" bgcolor="#FFFFFF"><input name="c_name" type="text" id="c_name" size="50"></td>
        </tr>
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF">นามสกุล <span class="style5">*</span> </td>
        <td align="left" valign="top" bgcolor="#FFFFFF"><input name="c_surname" type="text" id="c_surname" size="50"></td>
      </tr>
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF">ที่อยู่</td>
        <td align="left" valign="top" bgcolor="#FFFFFF"><textarea name="c_address" cols="50" rows="3" id="c_address"></textarea></td>
      </tr>
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF">อีเมล์</td>
        <td align="left" valign="top" bgcolor="#FFFFFF"><input name="c_email" type="text" id="c_email" size="50"></td>
      </tr>
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF">ข้อเสนอแนะ/คำถาม</td>
        <td align="left" valign="top" bgcolor="#FFFFFF"><textarea name="c_comment" cols="50" rows="5" id="c_comment"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
        <td align="left" bgcolor="#FFFFFF">
          <input type="submit" name="Submit" value="     ส่ง     ">
          <input type="reset" name="Submit2" value=" ยกเลิก ">
          <input name="m" type="hidden" id="m" value="<?php echo $_GET["m"]; ?>">
          <input name="Flag" type="hidden" id="Flag" value="Send"></td>
      </tr>
    </table></form></td>
  </tr>
  <tr>
    <td align="center">กรุณากรอกข้อความข้างต้นตามความเป็นจริงและกรอกช่องที่มีเครื่องหมาย * ให้ครบถ้วน </td>
  </tr>
</table></td>
        </tr>
      </table>
	</td>
    <td  valign="top"  <?php if($F["d_site_right"] != ""){ echo "width=\"".$F["d_site_right"]."\""; } ?> <?php  if($F["d_right_bg_c"] != ""){ echo "bgcolor=\"".$F["d_right_bg_c"]."\""; } ?>>	 
	 <?php
			$mainwidth =  $F["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?></td>
  </tr>
  <tr valign="top" > 
          <td  colspan="3"  valign="top"  <?php if($F["d_bottom_height"] != ""){ echo "height=\"".$F["d_bottom_height"]."\""; } ?> <?php  if($F["d_bottom_bg_c"] != ""){ echo "bgcolor=\"".$F["d_bottom_bg_c"]."\""; } ?> <?php if($F["d_bottom_bg_p"] != ""){ echo "background=\"".$F["d_bottom_bg_p"]."\""; } ?>>	 
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
  </tr>
</table>
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</body>
</html>
<?php $db->db_close(); ?>