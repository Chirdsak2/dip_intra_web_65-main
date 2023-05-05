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
$sql_check = $db->query("SELECT gen_user.gen_user_id , title.title_thai,gen_user.name_thai,gen_user.surname_thai,org_name.name_org,gen_user.position_person,gen_user.path_image FROM gen_user LEFT JOIN title ON title.title_id = gen_user.title_thai INNER JOIN org_name ON org_name.org_id = gen_user.org_id WHERE gen_user_id = '".$_GET["m"]."' ");
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
$sql_check1 = $db->query("SELECT mp_welcome FROM mp_profile WHERE mp_member = '".$_GET["m"]."' ");
$T = $db->db_fetch_array($sql_check1);
	?>
	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
		 <td width="20%" valign="top"><table width="200" border="0" cellpadding="4" cellspacing="0" >
           <tr>
             <td><a href="parliament_index.php?m=<?php echo $_GET["m"]; ?>" accesskey=<?php echo $db->genaccesskey();?>>หน้าหลัก</a></td>
           </tr>
           <tr>
             <td><a href="parliament_history.php?m=<?php echo $_GET["m"]; ?>" accesskey=<?php echo $db->genaccesskey();?>>ประวัติสมาชิก</a></td>
           </tr>
           <tr>
             <td><a href="parliament_act.php?m=<?php echo $_GET["m"]; ?>" accesskey=<?php echo $db->genaccesskey();?>>ผลงาน/กิจกรรม</a></td>
           </tr>
           <tr>
             <td><a href="parliament_contact.php?m=<?php echo $_GET["m"]; ?>" accesskey=<?php echo $db->genaccesskey();?>>คุยกับสมาชิก</a></td>
           </tr>
         </table></td>
          <td width="30%" valign="top"><img src="img.php?p=<?php echo base64_encode($path_image); ?>" name="previewField" width="120" border="0"  alt="<?php echo $P[title_thai]; ?> <?php echo $P[name_thai]; ?> <?php echo $P[surname_thai]; ?>"  id="previewField" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="150" ><?php echo $P[title_thai]; ?> <?php echo $P[name_thai]; ?> <?php echo $P[surname_thai]; ?><br>
                  พรรค <?php echo $P[name_org]; ?><br>
                  <?php echo $P[position_person]; ?></td>
              </tr>
            </table></td>
          <td width="50%" valign="top"><span class="style5"><?php echo $P[title_thai]; ?> <?php echo $P[name_thai]; ?> <?php echo $P[surname_thai]; ?><br>พรรค <?php echo $P[name_org]; ?><br><?php echo $P[position_person]; ?></span><hr size="1">
<br>
<?php echo stripslashes($T["mp_welcome"]); ?></td>
         
        </tr>
      </table>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>