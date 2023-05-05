<?php
	session_start();
	//header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
	
if($_GET["filename"] == ''){
$_GET["filename"] = "index";
}
if($_GET["filename"] != ""){
$sql_file = $db->query("SELECT template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$Design = $db->db_fetch_row($sql_file);
$did = $Design[0];
}else{
$sql_file = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y' ");
$Design = $db->db_fetch_row($sql_file);
$did = $Design[0];
}

$sql_index = $db->query("SELECT * FROM design_list WHERE d_id = '".$did."' ");
$F = $db->db_fetch_array($sql_index);

$global_theme = $F[d_bottom_content];
$mainwidth = "0";
$lang_sh = explode('___',$_GET["filename"]);
if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
?>
<html>
<head>
<title>ระบบฐานข้อมูลรายงานและบันทึกการประชุม</title>
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
		  <td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>">
<?php
$db->query("USE datawarehouse");
	$sql = "select name,date_update,yearno,year,num,session_name,detail from data_wh where meeting_id = '$mid' and status = 'U'  group by meeting_id"; 
	//echo $sql.'<br>';
	$query = $db->query($sql);
	$R = $db->db_fetch_array($query);
	//echo $R[name];
	//exit;
	//link  list
	$thai_number = array('๑','๒','๓','๔','๕','๖','๗','๘','๙','๐');
	$eng_number = array('1','2','3','4','5','6','7','8','9','0');
?><br />
<br />

<table width="100%" border="0">
   <tr>
    <td><strong><?php echo $R[name];?></strong></td>
  </tr>
  <tr>
    <td><strong>เรื่องที่พิจารณา</strong></td>
  </tr>
  <tr>
    <td><?php echo $R[detail];?><br><br ></td>
  </tr>
  <tr>
    <td><strong>ข้อมูลการประชุม</strong></td>
  </tr>
  <?php
  $i=1; 
	$sql_file = "select path_file from data_wh where meeting_id = '$mid' and status = 'U'  group by path_file";
  $query_file = $db->query($sql_file);
  while($R_file = $db->db_fetch_array($query_file)){
  
  $sql_file_list = "select * from attach_file where attach_file_id ='".$R_file[path_file]."'";
  $query_file_list = $db->query($sql_file_list);
  $RF = $db->db_fetch_array($query_file_list);
  
  ?>
  <tr>
    <td><?php echo str_replace($eng_number,$thai_number,$i++);?>. <a href="##F" onclick="download('<?php echo $RF[attach_file_id];?>','<?php echo $_GET[mid];?>');" ><?php 
	 if($RF[status]=='0'){
	 echo "รายงานการประชุม";
	 }else if($RF[status]=='1'){
	 echo "บันทึกการประชุม";
	  }else if($RF[status]=='2'){
	 echo "บันทึกการออกเสียงและลงคะแนน";
	  }else if($RF[status]=='3'){
	 echo "สรุปเหตุการณ์";
	 }
	?></a></td>
  </tr>
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
<?php
			$db->query("USE ".$EWT_DB_NAME);
?>
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
