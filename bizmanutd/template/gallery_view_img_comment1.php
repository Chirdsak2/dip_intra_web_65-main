<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<form name="frm" action="gallery_process_comment.php" method="post">
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
<?php
	if($_POST[page_cat]) $page_cat = $_POST[page_cat];
	else $page_cat = $_GET[page_cat];
	
	if($_POST[category_id]) $category_id = $_POST[category_id];
	else $category_id = $_GET[category_id];
	
	if($_POST[img_id]) $img_id = $_POST[img_id];
	else $img_id = $_GET[img_id];
	
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";

	$sql_category = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[category_id]."' ";
	$query_category = $db->query($sql_category);
	$rs_category = $db->db_fetch_array($query_category);
	
	$sql_img = "SELECT * FROM gallery_image WHERE img_id = '".$_GET[img_id]."' ";
	$query_img = $db->query($sql_img);
	$rs_img = $db->db_fetch_array($query_img);

?>
<table width="600"  border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="6" width="7"><img src="<?php echo $path;?>mainpic/head_left.gif" width="7" height="6"></td>
        <td bgcolor="#5599CC"></td>
        <td height="6" width="7"><img src="<?php echo $path;?>mainpic/head_right.gif" width="7" height="6"></td>
      </tr>
      <tr>
        <td height="30" width="7" bgcolor="#5599CC"></td>
        <td valign="middle" bgcolor="#5599CC" height="30"><div align="center"><strong style="color:#FFFFFF">หมวด
              <?php echo $rs_category[category_name]?>
        </strong>
            <input type="hidden" name="category_id" value="<?php echo $category_id?>">
            <input type="hidden" name="page_cat" value="<?php echo $page_cat?>">
			<input type="hidden" name="img_id" value="<?php echo $img_id?>">
        </div></td>
        <td height="30" width="7" bgcolor="#5599CC" valign="top"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#006699">
      <tr>
        <td align="center" valign="top" bgcolor="#FFFFFF"  style="color:#FFFFFF">
		<table  border="0" cellpadding="1" cellspacing="1" bgcolor="#999999">
          <tr>
            <td bgcolor="#FFFFFF" align="center" valign="top"><img src="<?php echo $rs_img[img_path_b]?>" ></td>
          </tr>
        </table>
		<br>
		<strong style="color:#000000">
		<?php echo " ชื่อรูป : ".$rs_img[img_name]?>
		<br>
		<br>
		<?php
			$sql_vote = "SELECT SUM(vote) as vote_all,count(*) as count_vote FROM gallery_comment WHERE category_id = '".$category_id."' AND img_id = '".$img_id."' Group BY img_id,category_id ";
			$query_vote = $db->query($sql_vote);
			$rs_vote = $db->db_fetch_array($query_vote);
			if($rs_vote[count_vote]>0){
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
<img src="mainpic/star_yellow.GIF" height="16" width="16" align="absmiddle">
<?php 		
			}
			if($herf){
					print '<img src="mainpic/half_star_yellow.gif" height="16" width="8" align="absmiddle"><br><br>';
			}
		}
		?>
		</strong></td>
        </tr>

    </table></td>
  </tr>
</table><br>
<div id="div_comment">
<table width="600" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <th height="20" colspan="2" bgcolor="#5599CC" scope="col"><strong style="color:#FFFFFF">ความคิดเห็น</strong></th>
    </tr>
  <tr>
    <td colspan="2" bgcolor="#FFFFFF">
	<?php
	
		if($_POST[page]) $page = $_POST[page];
		else $page = $_GET[page];
		if(!$limit) $limit = 10;
		if($page == '' || $page < 1)$page =1;
		$page1=$page-1;
		if($page1 == '' || $page1 < 0)$page1 =0;
	
		$sql_comment = "SELECT * FROM gallery_comment WHERE category_id = '".$category_id."' AND img_id = '".$img_id."' order by choice desc";
		$query_comment = $db->query($sql_comment);
		$num_comment = $num_all = $db->db_num_rows($query_comment);
		
		if($num_all%$limit==0){
		@$page_all = $num_all/$limit;
		}else{
			@$page_all = (int)($num_all/$limit)+1;
		}
		if($page_all==0) $page_all = 1;
		if($page>=$page_all){$page1 = $page_all-1;$page=$page_all;}
		$sql_2 = $sql_comment."  limit ".$page1*$limit.",$limit";
		$query = $db->query($sql_2);
		$num_rows_2 = $db->db_num_rows($query);
		
		if($num_rows_2 > 0){
			for($i=1;$i<=$num_rows_2;$i++){
				$rs_comment = $db->db_fetch_array($query);
				$date_time = explode(" ",$rs_comment[com_date]);
				$date =  explode("-",$date_time[0]);
				$date = $date[2]."/".$date[1]."/".($date[0]+543);
				
				$date_time_full = " วันที่ ".$date." เวลา ".$date_time[1];
	?>
      <br>
      <table width="580" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#EBEBEB">
      <tr>
        <td width="580"><div align="left"><strong>&nbsp;ความคิดเห็นที่ <?php echo $rs_comment[choice]?>  : คุณ <?php echo $rs_comment[name]?>&nbsp;&nbsp;&nbsp;<?php echo $date_time_full?></strong></div></td>
      </tr>
      <tr>
        <td width="580"><div align="left"> &nbsp;&nbsp;&nbsp;
          <?php echo str_replace("\n","<br>",$rs_comment[comment])?></div></td>
      </tr>
    </table>
	<?php 
		}
		?>
	<table width="580" border="0" align="center" bgcolor="#FFFFFF">
      <tr>
        <th width="580"><div align="right">หน้าที่
            <select name="page" onChange="var url = 'gallery_ajax_comment.php?page='+this.value+'&category_id=<?php echo $category_id?>&img_id=<?php echo $img_id?>&limit=<?php echo $limit?>'; load_divForm(url,'div_comment','');">
              <?php
							for($i=1;$i<=$page_all;$i++){
								if($i == $page) $selected = "selected";
								else $selected = "";
								print "<option value=\"$i\" $selected>$i</option>";
							}
						?>
            </select>
/
<?php echo $page_all?>
หน้า</div></th>
      </tr>
    </table>
		<?php
	}else{
	?>
		<br>
      <table width="580" border="0" align="center" bgcolor="#EBEBEB">
      <tr>
        <th width="580"><div align="center"><strong style="color:#FF0000"> ไม่มีความคิดเห็น </strong></div></th>
      </tr>
    </table>
	<?php }?>
	
	<br></td>
    </tr>
</table>
</div>
<br>
<table width="600"  border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="6" width="7"><img src="<?php echo $path;?>mainpic/head_left.gif" width="7" height="6"></td>
        <td bgcolor="#5599CC"></td>
        <td height="6" width="7"><img src="<?php echo $path;?>mainpic/head_right.gif" width="7" height="6"></td>
      </tr>
      <tr>
        <td height="21" width="7" bgcolor="#5599CC"></td>
        <td valign="middle" bgcolor="#5599CC" height="21"><div align="left" style="color:#FFFFFF"> <strong> &bull; แสดงความคิดเห็น </strong></div></td>
        <td height="21" width="7" bgcolor="#5599CC" valign="top"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#006699">
      <tr>
        <td align="center" valign="top" bgcolor="#FFFFFF"  style="color:#FFFFFF">
          <table width="100%" border="0">
            <tr>
              <th width="15%" scope="col"><div align="right">ชื่อ : &nbsp;&nbsp;&nbsp;</div></th>
              <th width="85%" scope="col"><div align="left">&nbsp;&nbsp;
                <label>
                <input name="name" type="text" size="50">
                </label>
              </div></th>
            </tr>
            <tr>
              <td valign="top"><div align="right"><strong>รายละเอียด : &nbsp;&nbsp;&nbsp;</strong></div></td>
              <td><div align="left">&nbsp;&nbsp;
                <label>
                <textarea name="comment" cols="75" rows="5" onKeyUp="if(this.value.length%50 == 0){}"></textarea>
                </label>
              </div></td>
            </tr>
            <tr>
              <td><div align="right"><strong>vote : &nbsp;&nbsp;&nbsp;</strong></div></td>
              <td>&nbsp;&nbsp;
                <input name="vote" type="radio" value="5"> 5
				<input name="vote" type="radio" value="4"> 4
				<input name="vote" type="radio" value="3" checked="checked"> 3
				<input name="vote" type="radio" value="2"> 2
				<input name="vote" type="radio" value="1"> 1                </td>
            </tr>
            <tr>
              <td><div align="right"><strong>ส่ง E-mail :&nbsp;&nbsp;&nbsp;&nbsp; </strong></div></td>
              <td>&nbsp;&nbsp;
                <label>
                <input name="email" type="text" size="50">
                </label></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;&nbsp;
                <input type="submit" name="Submit" value="ส่งความคิดเห็น" onClick="return chk_name(this.form)">
&nbsp;&nbsp;
<input type="reset" name="Submit2" value="ล้างข้อมูล">
<input type="hidden" name="flag" value="add">
<input type="hidden" name="fn" value="gallery_view_img_comment.php">
</td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<script>
function chk_name(me){
	if(me.name.value == ""){
		alert('กรุณากรอกชื่อ');
		me.name.focus();
		return false;
	}
	return true;
}
</script>
</form>
</body>
</html>
<?php
$db->db_close(); ?>
