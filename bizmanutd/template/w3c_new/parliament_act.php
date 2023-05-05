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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
<?php include("ewt_script.php");?>
<style type="text/css">
<!--
.style2 {	font-size: 17px;
	color: #FFFFFF;
}
.style4 {font-size: 17px}
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
<?php
$db->query("USE ".$EWT_DB_NAME);
$sql_check = $db->query("SELECT gen_user.gen_user_id , title.title_thai,gen_user.name_thai,gen_user.surname_thai,org_name.name_org,gen_user.position_person,gen_user.path_image FROM gen_user INNER JOIN title ON title.title_id = gen_user.title_thai INNER JOIN org_name ON org_name.org_id = gen_user.org_id WHERE gen_user_id = '".$_GET["m"]."' ");
$P = $db->db_fetch_array($sql_check);
								if($P[path_image] != ""){
								$path_image= "../../pic_upload/".$P[path_image];
													if (file_exists($path_image)) {
												   $path_image=$path_image;
												   }else{
												   $path_image="../images/ImageFile.gif";
												   }
								
								}
$db->query("USE ".$EWT_DB_NAME);
$sql_check1 = $db->query("SELECT * FROM mp_profile WHERE mp_member = '".$_GET["m"]."' ");
$T = $db->db_fetch_array($sql_check1);

function gendate($d){
$e = explode("-",$d);
return $e[2]."/".$e[1]."/".$e[0];
}
function gentime($d){
$e = explode(":",$d);
return $e[0].":".$e[1];
}
?>
	    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr>
		   <td width="25%" valign="top"><table width="200" border="0" cellpadding="4" cellspacing="0" >
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
            <td width="25%" valign="top"><img src="img.php?p=<?php echo base64_encode($path_image); ?>" name="previewField" width="120" border="0"   id="previewField"  alt="รางวัลเกียรติยศ">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="150" ><?php echo $P[title_thai]; ?> <?php echo $P[name_thai]; ?> <?php echo $P[surname_thai]; ?><br>
                    พรรค <?php echo $P[name_org]; ?><br>
                    <?php echo $P[position_person]; ?></td>
                </tr>
              </table></td>
            <td width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="1" >
			<tr><td>&nbsp;</td></tr>
                <?php if($T["mp_honor"] != ""){ ?>
                <tr>
                  <td valign="top"><span class="style4">รางวัลเกียรติยศ</span>
                      <hr>
                      <?php echo $T["mp_honor"]; ?></td>
                </tr>
				
                <?php
		  }
		  if($T["mp_gov"] != ""){
		  ?>
                <tr>
                  <td valign="top"><br>
                      <span class="style4">ผลงานทางการเมือง</span>
                      <hr>
                      <?php echo $T["mp_gov"]; ?></td>
                </tr>
                <?php
		  }
		  if($T["mp_talk"] != ""){
		  ?>
                <tr>
                  <td valign="top"><br>
                      <span class="style4">สารจากสมาชิก</span>
                      <hr>
                      <?php echo $T["mp_talk"]; ?></td>
                </tr>
                <?php
		  }
		  ?>
            </table></td>
           
          </tr>
        </table>	
	    <table width="96%" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td><br>
                <span class="style4">ปฏิทินกิจกรรม</span></td>
          </tr>
          <tr>
            <td><hr>
                <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="790102">
                  <tr>
                    <td width="20%" align="center" bgcolor="#C15C4A">วัน/เดือน/ปี </td>
                    <td width="10%" align="center" bgcolor="#C15C4A">เวลา</td>
                    <td width="70%" align="center" bgcolor="#C15C4A">กิจกรรม</td>
                  </tr>
                  <?php
	  $sql_check = $db->query("SELECT * FROM mp_calendar WHERE mp_member = '".$_GET["m"]."'   AND mp_cal_deleted like 'N'  ORDER BY mp_cal_date DESC,mp_cal_time DESC "); 
$countT=$db->db_num_rows($sql_check);
	  while($T = $db->db_fetch_array($sql_check)){
	  ?>
                  <tr>
                    <td align="center" bgcolor="#FFFFFF">&nbsp;<?php echo gendate($T[mp_cal_date]); ?></td>
                    <td align="center" bgcolor="#FFFFFF">&nbsp;<?php echo gentime($T[mp_cal_time]); ?></td>
                    <td bgcolor="#FFFFFF">&nbsp;<?php echo $T[mp_cal_act]; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if($countT==0){?>
                  <tr>
                    <td bgcolor="#FFFFFF" colspan="3" align="center">ไม่พบข้อมูล</td>
                  </tr>
                  <?php }?>
              </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
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