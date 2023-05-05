<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<form name="frm" action="" method="post">
<?php
	if($_POST[page_cat]) $page_cat = $_POST[page_cat];
	else $page_cat = $_GET[page_cat];
	
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";

	$sql_category = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[category_id]."' ";
	$query_category = $db->query($sql_category);
	$rs_category = $db->db_fetch_array($query_category);
	$hi = $rs_category[height_b];
	$wi = $rs_category[width_b];
	
	$sql_img = "SELECT * FROM gallery_image WHERE img_id = '".$_GET[img_id]."' ";
	$query_img = $db->query($sql_img);
	$rs_img = $db->db_fetch_array($query_img);

?>
<table width="94%"  border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="3"><div align="center"><strong style="color:#FFFFFF">หมวด
            <?php echo $rs_category[category_name]?>
          </strong></div></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006699" class="ewttableuse">
      <tr>
        <td width="73%" bgcolor="#FFFFFF"  style="color:#FFFFFF" align="center" valign="top">
		<table  border="0" cellpadding="1" cellspacing="1" bgcolor="#999999" width="<?php echo $wi;?>" height="<?php echo $hi;?>">
          <tr>
            <td bgcolor="#FFFFFF" align="center" ><img src="phpThumb.php?src=<?php echo $Globals_Dir.$rs_img[img_path_s]?>&h=<?php echo $wi;?>&w=<?php echo $hi;?>" hspace="0" vspace="0"></td>
          </tr>
        </table>
		<br>
		<strong style="color:#000000">
		<?php echo " ชื่อรูป : ".$rs_img[img_name]?>
		<br>
		
		<?php
			$sql_vote = "SELECT SUM(vote) as vote_all,count(*) as count_vote FROM gallery_comment WHERE category_id = '".$category_id."' AND img_id = '".$img_id."' Group BY img_id,category_id ";
			$query_vote = $db->query($sql_vote);
			$rs_vote = $db->db_fetch_array($query_vote);
			if($rs_vote[count_vote] > 0){
			print "<br>";
			$rs_vote[vote_all];
			$vote_full = $rs_vote[count_vote]*5;
			@$rate_vote = $rs_vote[vote_all]*100/$vote_full;
			if($rate_vote<100 ){
				if($rate_vote<90){
					if($rate_vote<80){
						if($rate_vote<70){
							if($rate_vote<60){
								if($rate_vote<50){
									if($rate_vote<40){
										if($rate_vote<30){
											if($rate_vote<20){
												if($rate_vote<10){ 
													$round = 1;
													$herf = false;
												}else{
													$round = 1;
													$herf = true;
												}
											}else{
												$round = 2;
												$herf = false;
											}
										}else{
											$round = 2;
											$herf = true;
										}
									}else{
										$round = 3;
										$herf = false;
									}
								}else{
									$round = 3;
									$herf = true;
								}
							}else{
								$round = 4;
								$herf = false;
							}
						}else{
							$round = 4;
							$herf = true;
						}
					}else{
						$round = 5;
						$herf = false;
					}
				}else{
					$round = 5;
					$herf = true;
				}
			}
			//print $round;
		?>
คะแนน Vote  :
<?php
			for($i=1;$i<=$round;$i++){
		?>
<img src="images/star_yellow.GIF" height="16" width="16" align="absmiddle">
<?php 		
			}
			if($herf){
					print '<img src="images/half_star_yellow.gif" height="16" width="8" align="absmiddle"><br>';
			}
		}
		?>
		<br>
		</strong></td>
        <td width="27%" bgcolor="#FFFFFF"  style="color:#FFFFFF" valign="top" align="center">
		<table width="100%" border="0">
          <tr>
            <td><div align="left" style="cursor:hand" onClick="location.href ='gallery_edit_img.php?img_id=<?php echo $rs_img[img_id]?>&flag=edit&category_id=<?php echo $_GET[category_id]?>&page_cat=<?php echo $page_cat?>';"><img src="images/cal_edit.gif" height="16" width="16" align="absmiddle">&nbsp;แก้ไขรูป</div></td>
          </tr>
          <tr>
            <td><span style="cursor:hand" onClick="if(confirm('ยืนยันการลบ')){location.href = 'gallery_process_img.php?flag=del&img_id=<?php echo $_GET[img_id]?>&category_id=<?php echo $_GET[category_id]?>'; }"><img src="images/cal_del.gif" height="16" width="16" align="absmiddle" >&nbsp;ลบรูป</span></td>
          </tr>
          <tr>
		  <?php
		  	$sql_comment = "SELECT count(*) as count_com FROM gallery_comment WHERE category_id = '".$_GET[category_id]."' and img_id = '".$rs_img[img_id]."' ";
			$query_comment = $db->query($sql_comment);
			$rs_comment = $db->db_fetch_array($query_comment);
		  ?>
            <td><span style="cursor:hand" onClick="location.href ='gallery_view_img_comment2.php?category_id=<?php echo $_GET[category_id]?>&img_id=<?php echo $rs_img[img_id]?>&page_cat=<?php echo $page_cat?>';"><img src="images/cal_edit.gif" height="16" width="16" align="absmiddle"> ดูความคิดเห็น (<?php echo $rs_comment[count_com]?>)</span></td>
          </tr>
          <tr>
            <td><span style="cursor:hand" onClick="location.href = 'gallery_view_category.php?category_id=<?php echo $_GET[category_id]?>&page=<?php echo $page_cat?>'; "><img src="images/navi_left.gif" width="16" height="16" > back </span></td>
          </tr>
        </table></td>
      </tr>

    </table></td>
  </tr>
</table>

</form>
</body>
</html>
<?php
$db->db_close(); ?>
