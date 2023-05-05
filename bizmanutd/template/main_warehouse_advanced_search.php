<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
if($_GET["filename"] == ''){
$_GET["filename"] = "index";
}
$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);

$sql_theme= $db->query("SELECT d_bottom_content FROM design_list WHERE d_id = '".$F["template_id"]."'");
$X = $db->db_fetch_row($sql_theme);
$global_theme = $X[0];
$mainwidth = "0";
$lang_sh = explode('___',$F[filename]);
if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
	?>
<html>
<head>
<title>การค้นหาขั้นสูง</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"><?php
			$mainwidth = $F["d_site_content"];
			?>
			
			<?php
			//data warehouse
			$db->query("USE datawarehouse");
			?>
			<table width="100%" border="0">
			  <tr>
				<td class="text_head">&nbsp;</td>
			  </tr>
			</table>
			<form name="frmadvS" method="GET" action="main_warehouse.php">
			  <table width="94%" border="0" align="center">
                <tr>
                  <td align="center" class="text_head">การค้นหาขั้นสูง</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bgcolor="#D4D0C8"><table width="100%" border="0">
                    <tr>
                  <td width="26%" valign="top">ที่มีทุกคำต่อไปนี้</td>
                  <td valign="top"><input name="as_q" type="text" id="as_q" size="40"></td>
                </tr>
                <tr>
                  <td>ที่มีประโยคหรือวลีนี้</td>
                  <td valign="top"><table cellpadding="0" cellspacing="0" width="100%"><tr><td style="width:40px; "><input name="as_epq" type="text" id="as_epq" size="40"></td><td style="font-size:12px; padding-left:5px; font-style:italic;">เช่น รัฐธรรมนูญแห่งราชอาณาจักรไทย<br/>พุทธศักราช 2540</td></tr>
                  
                  </table></td>
                </tr>
                <tr>
                      <td valign="top">ที่มีคำเหล่านี้อย่างน้อยหนึ่งคำ</td>
                      <td valign="top"><input name="as_oq" type="text" id="as_oq" size="40"></td>
                    </tr>
                <tr>
                  <td valign="top">ที่ไม่มีคำเหล่านี้</td>
                  <td valign="top"><input name="as_eq" type="text" id="as_eq" size="40"></td>
                </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0">
                    <tr>
                      <td width="26%">ชุดที่</td>
                      <td><select name="yearno">
					  <option value="">ทั้งหมด</option>
	<?php
	$sql_a = "select * from config where config_status = '0'";
	$query_a = $db->query($sql_a);
	$Ra = $db->db_fetch_array($query_a);
	for($i=$Ra[config_start];$i<= $Ra[config_end];$i++){
	if($i==$yno){$chk = 'selected';}else{$chk = '';}
	?>
	<option value="<?php echo $i;?>" <?php echo $chk;?>><?php echo $i;?></option>
	<?php
	}
	?>
    </select></td>
                    </tr>
                    <tr>
                      <td>ปีที่</td>
                      <td><select name="year">
					   <option value="">ทั้งหมด</option>
	<?php
	$sql_b = "select * from config where config_status = '1'";
	$query_b = $db->query($sql_b);
	$Rb = $db->db_fetch_array($query_b);
	for($i=$Rb[config_start];$i<= $Rb[config_end];$i++){
	if($i==$y){$chk = 'selected';}else{$chk = '';}
	?>
	<option value="<?php echo $i;?>" <?php echo $chk;?>><?php echo $i;?></option>
	<?php
	}
	?>
    </select></td>
                    </tr>
                    <tr>
                      <td>ครั้งที่</td>
                      <td><select name="num">
					   <option value="">ทั้งหมด</option>
	<?php
	$sql_c = "select * from config where config_status = '2'";
	$query_c = $db->query($sql_c);
	$Rc = $db->db_fetch_array($query_c);
	for($i=$Rc[config_start];$i<= $Rc[config_end];$i++){
	if($i==$numm){$chk = 'selected';}else{$chk = '';}
	?>
	<option value="<?php echo $i;?>" <?php echo $chk;?>><?php echo $i;?></option>
	<?php
	}
	?>
    </select></td>
                    </tr>
                    <tr>
                      <td>สมัยที่</td>
                      <td><select name="session_id">
					   <option value="">ทั้งหมด</option>
	<?php
	$sql_b = "select * from meeting_session";
	$query_b = $db->query($sql_b);
	while($Rb = $db->db_fetch_array($query_b)){
	if($i==$session){$chk = 'selected';}else{$chk = '';}
	?>
	<option value="<?php echo $Rb[meeting_session_name];?>" <?php echo $chk;?>><?php echo $Rb[meeting_session_name];?></option>
	<?php
	}
	?>
    </select></td>
                    </tr>
                    <tr>
                      <td>รูปแบบไฟล์</td>
                      <td><select name=as_filetype>
					  <option value="" selected>ทั้งหมด</option>
					  <option value="pdf">Adobe Acrobat PDF (.pdf)</option>
					  <option value="xls">Microsoft Excel (.xls)</option>
					  <option value="ppt">Microsoft Powerpoint (.ppt)</option>
					  <option value="doc">Microsoft Word (.doc)</option>
					  <option value="html">HTML (.html)</option>
					  <option value="mht">Web Archive(MHT) (.mht)</option>
					  <option value="txt">TEXT(.txt)</option>
					  </select></td>
                    </tr>
                    <tr>
                      <td>ประเภทเอกสาร</td>
                      <td><select name="as_type" >
					   <option value="">ทั้งหมด</option>
					  <option value="รายงานการประชุม">รายงานการประชุม</option>
					  <option value="บันทึกการประชุม">บันทึกการประชุม</option>
					  <option value="บันทึกการออกเสียงลงคะแนน">บันทึกการออกเสียงลงคะแนน</option>
					  <option value="สรุปเหตุการณ์">สรุปเหตุการณ์</option>
					</select> </td>
                    </tr>
                  </table></td>
                </tr>
                
                <tr>
                  <td align="center"><input type="submit" name="Submit" value="ค้นหา..">
                  <input type="hidden" name="filename" value="<?php echo $_GET[filename];?>"><input type="hidden" name="type" value="6"><input type="hidden" name="formtype" value="advancedS">
				  </td>
                </tr>
              </table>
      </form>
			<?php
			$db->query("USE ".$EWT_DB_NAME);
			?>
			
		  </td>
          <td id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth =  $F["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>

<?php $db->db_close(); ?>
