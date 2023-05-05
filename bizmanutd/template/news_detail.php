<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$filename_temp = "index";
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$F = $db->db_fetch_array($sql_temp);
$design_id = $F["d_id"];

$global_theme = $F["d_bottom_content"];
$mainwidth = "0";

$sql_article = $db->query("SELECT * FROM article_list WHERE n_id = '".$_GET["nid"]."'");
$RR= $db->db_fetch_array($sql_article);
$nid = $_GET["nid"];

			?>
<html>
<head>
<title><?php echo $RR["n_topic"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript">

function chk_comment(){
var name_comment = document.getElementById('name_comment').value;
var detail = document.getElementById('detail').value;
	if (detail=='' || name_comment == ''){
		alert('กรุณากรอกข้อมูลให้ครบถ้วน');
		return false;
	}else{
		open_data('', 'show_comment','','');
	}
}


function open_data(url, divId,account_sub_type_id,bank_account_id) {
	var name_comment = document.getElementById('name_comment').value;
	var detail = document.getElementById('detail').value;		
	var news_id = <?php echo $_GET["nid"];?>	
	var objDiv = document.getElementById(divId);
	url='ewt_comment_news.php?news_id='+news_id+'&name_comment='+name_comment+'&detail='+detail;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					document.getElementById('name_comment').value = '';
					document.getElementById('detail').value = '';
					objDiv.innerHTML = req.responseText; 
			}
			//,'onSuccess':function(req) { }
		}
	);
}

</script>
<?php
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>&nbsp;</td>
          
    <td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"> 
     <table width="100%" border="0" cellpadding="4" cellspacing="0" >
        <tr> 
          <td height="10" valign="top">
		  <?php
			$mainwidth = $F["d_site_content"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		    <?php } ?>
            <?php
	 $sql_group ="select * from  article_group where c_id = '".$RR[c_id]."'";
	 $query_group = $db->query($sql_group);
	 $U = $db->db_fetch_array($query_group);
	 ?>
	 <table width="99%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td><span  style="FONT: 12px 'Tahoma';"><a href="more_news.php?cid=<?php echo $RR[c_id]; ?>&filename=index"  style="FONT: 12px 'Tahoma';"> <?php echo $U[c_name]; ?></a> <?php if($U[c_rss] == "Y"){ ?><a href="rss/group<?php echo $U[c_id]; ?>.xml" target="_blank"><img src="mainpic/ico_rss.gif"  border="0" align="absmiddle"></a><?php } ?></span>
</td>
          </tr>
                  <tr>
            <td><span style="FONT: 17px 'Tahoma';"><?php echo $RR["n_topic"]; ?></span><hr size="1">
			<span style="FONT: 12px 'Tahoma';">วันที่ <?php $date = explode("-",$RR["n_date"]); echo number_format($date[2],0)." ".$monthname[number_format($date[1],0)]." ".$date[0]; ?></span>
</td>
          </tr>
		  </table>
            <table width="99%" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="3" valign="top"><?php if($RR["picture"] != ""){ ?>
<table width="50%" border="0" cellpadding="0" cellspacing="1" bgcolor="E0DFE3">
        <tr> 
          <td align="center" valign="middle" bgcolor="#FFFFFF" style="cursor:hand" onClick="win1=window.open('<?php if($RR["picture"] != ""){ echo "images/article/news".$nid."/".$RR["picture"]; }else{ echo "../../images/o.gif"; } ?>','','width=500,height=500,resizable=1,scrollbars=1');"><img src="<?php if($RR["picture"] != ""){ echo "images/article/news".$nid."/".$RR["picture"]; }else{ echo "../../images/o.gif"; } ?>" ></td>
        </tr>
      </table>
      <?php } ?>     </tr>
</table>

      <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
          <td><b><?php echo eregi_replace ( chr(13), "<br>" , $RR["n_des"] ); ?></b></td>
        </tr>
      </table>
      <br>
            <?php
	$news_id = $_GET["nid"];	  
 	$ip_view = getenv("REMOTE_ADDR");
	$date_view = date("Y-m-d");
	$time_view = date("h:i:s");

	####### บันทึกข้อมูล ข้อมูลจำนวนคนเข้ามาอ่าน ###########
	if(!session_is_registered("newsvisit".$news_id)){
	$sql = "INSERT INTO news_view(news_id,ip_view,date_view,time_view) VALUE ('$news_id','$ip_view','$date_view','$time_view') ";
	$query = mysql_query($sql);	
	session_register("newsvisit".$news_id);
	}
?>
          </td>
        </tr>
      </table></td>
          <td id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth = $F["d_site_right"]; 
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>
