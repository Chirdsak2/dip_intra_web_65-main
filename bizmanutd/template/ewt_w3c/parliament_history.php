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
$sql_check1 = $db->query("SELECT * FROM mp_profile WHERE mp_member = '".$_GET["m"]."' ");
$T = $db->db_fetch_array($sql_check1);
	?>
	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
	          <td width="25%" valign="top"><table width="200" border="0" cellpadding="4" cellspacing="0" >
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
        <td width="30%" valign="top"><img src="img.php?p=<?php echo base64_encode($path_image); ?>" name="previewField" width="120" border="0" alt="ประวัติ"   id="previewField" >
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="150" ><?php echo $P[title_thai]; ?> <?php echo $P[name_thai]; ?> <?php echo $P[surname_thai]; ?><br>
                พรรค <?php echo $P[name_org]; ?><br>
                <?php echo $P[position_person]; ?></td>
            </tr>
          </table></td>
        <td width="70%" valign="top"><span class="style4">ประวัติ</span>
            <hr>
            <table width="100%" border="0" cellspacing="0" cellpadding="1" >
              <?php if($T["mp_birth"] != ""){ ?>
              <tr>
                <td width="25%" valign="top">เกิด :</td>
                <td width="50%" valign="top"><?php echo $T["mp_birth"]; ?></td>
              </tr>
              <?php
		  }
		  if($T["mp_age"] != ""){
		  ?>
              <tr>
                <td valign="top">อายุ :</td>
                <td valign="top"><?php echo $T["mp_age"]; ?> ปี </td>
              </tr>
              <?php
		  }
		  if($T["mp_bplace"] != ""){
		  ?>
              <tr>
                <td valign="top">สถานที่เกิด :</td>
                <td valign="top"><?php echo $T["mp_bplace"]; ?></td>
              </tr>
              <?php
		  }
		  if($T["mp_address"] != ""){
		  ?>
              <tr>
                <td valign="top">ที่อยู่ปัจจุบัน : </td>
                <td valign="top"><?php echo $T["mp_address"]; ?></td>
              </tr>
              <?php
		  }
		  if($T["mp_tel"] != ""){
		  ?>
              <tr>
                <td valign="top">โทรศัพท์  : </td>
                <td valign="top"><?php echo $T["mp_tel"]; ?></td>
              </tr>
              <?php
		  }
		  if($T["mp_email"] != ""){
		  ?>
              <tr>
                <td valign="top">อีเมล์  : </td>
                <td valign="top"><?php echo $T["mp_email"]; ?></td>
              </tr>
              <?php
		  }
		  if($T["mp_opp"] != ""){
		  ?>
              <tr>
                <td valign="top">อาชีพ  : </td>
                <td valign="top"><?php echo $T["mp_opp"]; ?></td>
              </tr>
              <?php
		  }
		  ?>
          </table></td>

      </tr>
    </table>
	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" >
	<tr><td>&nbsp;</td></tr>
      <?php if($T["mp_edu"] != ""){ ?>
      <tr>
        <td width="25%" valign="top"><span class="style4">การศึกษา</span>
            <hr>
            <?php echo $T["mp_edu"]; ?></td>
      </tr>
      <?php
		  }
		  if($T["mp_cert"] != ""){
		  ?>
      <tr>
        <td valign="top"><br>
            <span class="style4">เครื่องราชอิสริยาภรณ์</span>
            <hr>
            <?php echo $T["mp_cert"]; ?></td>
      </tr>
      <?php
		  }
		  if($T["mp_exp"] != ""){
		  ?>
      <tr>
        <td valign="top"><br>
            <span class="style4">ประสบการณ์การทำงาน</span>
          <hr>
            <?php echo $T["mp_exp"]; ?></td>
      </tr>
      <?php
		  }
		  if($T["mp_expgov"] != ""){
		  ?>
      <tr>
        <td valign="top"><br>
            <span class="style4">ประสบการณ์ทางการเมือง</span>
          <hr>
            <?php echo $T["mp_expgov"]; ?></td>
      </tr>
      <?php
		  }
		  if($T["mp_family"] != ""){
		  ?>
      <tr>
        <td valign="top"><br>
            <span class="style4">ครอบครัว</span>
          <hr>
            <?php echo $T["mp_family"]; ?></td>
      </tr>
      <?php
		  }
		  ?>
    </table>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>