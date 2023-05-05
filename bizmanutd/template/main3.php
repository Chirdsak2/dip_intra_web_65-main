<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
include("../../ewt_public_function.php");
		if($_POST["Flag"] == "SetupB"){
				$sql_content_max = $db->query("SELECT MAX(block_member.position) FROM block INNER JOIN block_member ON block_member.BID = block.BID WHERE block_member.side = '5' AND block_member.filename = '".$_POST["filename"]."' AND block_member.mid = '".$_SESSION["EWT_MID"]."' ");
				$M = $db->db_fetch_row($sql_content_max);
				$pos = $M[0] + 1;
				$all = count($_POST["chk"]);
					for($y=0;$y<$all;$y++){
						$chkk = $_POST["chk"][$y];
							if($chkk != ""){
								$db->query("INSERT INTO block_member (BID,side,position,filename,mid) VALUES ('".$chkk."','5','".$pos."','".$_POST["filename"]."','".$_SESSION["EWT_MID"]."')");
								$pos++;
							}
					}
					?>
					<script language="JavaScript">
					self.location.href= "main3.php?filename=<?php echo $_POST["filename"]; ?>";
					</script>
					<?php
					exit;
		}
		if($_GET["reset"] == "1"){
		$db->query("DELETE FROM block_member WHERE filename = '".$_GET["filename"]."' AND mid = '".$_SESSION["EWT_MID"]."' ");
		$db->query("DELETE FROM block_visit WHERE filename = '".$_GET["filename"]."' AND mid = '".$_SESSION["EWT_MID"]."' ");
							?>
					<script language="JavaScript">
					self.location.href= "main3.php?filename=<?php echo $_GET["filename"]; ?>";
					</script>
					<?php
					exit;
		}
$sql_visit = $db->query("SELECT * FROM block_visit WHERE  filename = '".$_GET["filename"]."' AND mid = '".$_SESSION["EWT_MID"]."' ");
if($db->db_num_rows($sql_visit) == 0){

$sql_left = $db->query("SELECT block_function.* FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_array($sql_left)){
			$db->query("INSERT INTO block_member (BID,UID,side,position,filename,mid) VALUES ('".$B["BID"]."','".$B["UID"]."','".$B["side"]."','".$B["position"]."','".$_GET["filename"]."','".$_SESSION["EWT_MID"]."') ");		
			
			}
$sql_content = $db->query("SELECT block_function.* FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_array($sql_content)){
			$db->query("INSERT INTO block_member (BID,UID,side,position,filename,mid) VALUES ('".$B["BID"]."','".$B["UID"]."','".$B["side"]."','".$B["position"]."','".$_GET["filename"]."','".$_SESSION["EWT_MID"]."') ");		
		  }
$sql_right = $db->query("SELECT block_function.* FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_array($sql_right)){
			$db->query("INSERT INTO block_member (BID,UID,side,position,filename,mid) VALUES ('".$B["BID"]."','".$B["UID"]."','".$B["side"]."','".$B["position"]."','".$_GET["filename"]."','".$_SESSION["EWT_MID"]."') ");		  
		  }

$db->query("INSERT INTO block_visit (filename,mid) VALUES ('".$_GET["filename"]."','".$_SESSION["EWT_MID"]."')");
}

$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);

	$use_template = "";
	if($_SESSION["EWT_TYPE_ID"] != ""){
	$sql_person = $db->query("SELECT * FROM personal_map WHERE p_group = '".$_SESSION["EWT_TYPE_ID"]."' ");
		if($db->db_num_rows($sql_person) > 0){
		$PW = $db->db_fetch_array($sql_person);
			if($PW["p_template"] != "" AND $PW["p_template"] != "0" ){
				$use_template = $PW["p_template"];
			}
		}
	}

	if($use_template != ""){
		$sql_theme= $db->query("SELECT d_bottom_content FROM design_list WHERE d_id = '".$use_template."'");
		$X = $db->db_fetch_row($sql_theme);
		$global_theme = $X[0];
	}else{
		$sql_theme= $db->query("SELECT d_bottom_content FROM design_list WHERE d_id = '".$F["template_id"]."'");
		$X = $db->db_fetch_row($sql_theme);
		$global_theme = $X[0];
	}
$mainwidth = "0";

	?>
<html>
<head>
<title>Costomize Page [<?php echo $_GET["filename"]; ?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="css/dragdrop.css" type=text/css rel=stylesheet>
<script language="JavaScript" src="js/drag_drop.js"></script>
<script language="javascript">
function reload_p(){
window.location.reload();
}
</script>
<script language="JavaScript">
function divshow(c,d){
		if(c.style.display == ""){
			c.style.display = 'none';
			d.src = "mainpic/plus.gif";
			//d.src = "plus.gif";
		}else{
			c.style.display = '';
			d.src = "mainpic/minus.gif";
			//d.src = "minus.gif";
		}
}
	function delete_d(c){
		if(confirm("Are you sure to hide this Block ?")){
			document.getElementById("EWTID_S"+c+"EWTID_E").outerHTML = "";
			auto_save.document.form1.DelBID.value= c;
			autosave();
		}
	}
		function autosave(){
		auto_save.document.form1.tagdetect.value=document.all.Demo4.innerHTML;
		auto_save.form1.submit();
		addb_show();
	}
	function show_d(d,e){
	if(d.src.search('bar_down.gif') > 0){
		document.getElementById(e).style.display = '';
		d.src = "mainpic/bar_up.gif";
	}else{
		document.getElementById(e).style.display = 'none';
		d.src = "mainpic/bar_down.gif";
	}
}
function addb(){
if(document.all.addblobk.style.display == 'none'){
document.all.addblobk.style.display = '';
addb_show();
}else{
if(document.formTosave){
formTosave.submit();
}}
}
function resetb(){
window.location.href = "main3.php?reset=1&filename=<?php echo $_GET["filename"] ?>";
}
function addb_show(){
url='load_block.php?filename=<?php echo $filename; ?>&mid=<?php echo $_SESSION["EWT_MID"]; ?>';
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					document.all.load_data_block.innerHTML = req.responseText; 
			}
		}
	);
}
</script>
<?php
include("ewt_script.php");	
?>
</head>
<body   leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
  <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
    <tr> 
      
    <td align="right" bgcolor="#FFCC66"><font size="2" face="Tahoma"><strong>Welcome <?php echo $_SESSION["EWT_NAME"];?></strong></font> 
      <input type="button" name="Button" value="Save change" onClick="autosave()"> 
        <input type="button" name="Submit2" value="Add block" onClick="addb();"> <input type="button" name="Submit2" value=" Reset " onClick="resetb();"> <input type="button" name="Button" value="Exit mode" onClick="self.location.href='main.php?filename=<?php echo $_GET["filename"]; ?>';"></td>
    </tr>
    <tr id="addblobk" style="display:none">
      <td bgcolor="#FFCC66"><span id="load_data_block"></span></td>
    </tr>
  </table>
<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
		  //echo "SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC";
			if($use_template != ""){
				$sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$use_template."' ORDER BY design_block.position ASC");
			}else{
				$sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
			}
		  while($B = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
        </tr>
		</table>
		<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>" id=Demo4>
        <tr align="center" valign="top" > 
		<!--ewt_left_design-->
          <td width="33%"  class=DragContainer id="tbleft" overClass="OverDragContainer" background="<?php echo $F["d_left_bg_p"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>">
			<?php
		  $sql_left = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_member ON block_member.BID = block.BID WHERE block_member.side = '1' AND block_member.filename = '".$_GET["filename"]."' AND block_member.mid = '".$_SESSION["EWT_MID"]."' ORDER BY block_member.position ASC");
		  while($B = $db->db_fetch_row($sql_left)){
		  ?>
<DIV class=DragBox id="EWTID_S<?php echo $B[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $B[1]; ?> :: 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="cursor:hand">
            <td height="20" align="right" bgcolor="F3F3EE"><img id="EWTpospic" src="mainpic/bar_up.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $B[0]; ?>')">&nbsp;&nbsp;&nbsp;&nbsp;<img src="mainpic/bar_delete.gif" width="20" height="20" onClick="delete_d('<?php echo $B[0]; ?>')">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr id="tr<?php echo $B[0]; ?>" >
    <td valign="top" id="td<?php echo $B[0]; ?>"  style="cursor: no-drop;" onClick="return false;"><DIV align="center"   style="OVERFLOW: scroll;HEIGHT: 180;WIDTH: 305;"><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV></td>
  </tr>
</table></DIV>
		<?php } ?>
			</td>
			<!--ewt_left_design-->
			<!--ewt_content_design-->
          <td width="33%" height="160" background="<?php echo $F["d_body_bg_p"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" class=DragContainer   id="tbcontent" overClass="OverDragContainer">
			<?php
		  $sql_content = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_member ON block_member.BID = block.BID WHERE block_member.side = '5' AND block_member.filename = '".$_GET["filename"]."' AND block_member.mid = '".$_SESSION["EWT_MID"]."' ORDER BY block_member.position ASC");
		  while($B = $db->db_fetch_row($sql_content)){
		  ?>
<DIV class=DragBox id="EWTID_S<?php echo $B[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $B[1]; ?> :: 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="cursor:hand">
            <td height="20" align="right" bgcolor="F3F3EE"><img id="EWTpospic" src="mainpic/bar_up.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $B[0]; ?>')">&nbsp;&nbsp;&nbsp;&nbsp;<img src="mainpic/bar_delete.gif" width="20" height="20" onClick="delete_d('<?php echo $B[0]; ?>')">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr id="tr<?php echo $B[0]; ?>" >
    <td valign="top" id="td<?php echo $B[0]; ?>"  style="cursor: no-drop;" onClick="return false;"><DIV align="center"   style="OVERFLOW: scroll;HEIGHT: 180;WIDTH: 305;"><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV></td>
  </tr>
</table></DIV>
		<?php } ?>
			</td>
			<!--ewt_content_design-->
			<!--ewt_right_design-->
          <td width="33%" background="<?php echo $F["d_right_bg_p"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" class=DragContainer id="tbright" overClass="OverDragContainer">
			<?php
		  $sql_right = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_member ON block_member.BID = block.BID WHERE block_member.side = '2' AND block_member.filename = '".$_GET["filename"]."' AND block_member.mid = '".$_SESSION["EWT_MID"]."' ORDER BY block_member.position ASC");
		  while($B = $db->db_fetch_row($sql_right)){
		  ?>
<DIV class=DragBox id="EWTID_S<?php echo $B[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $B[1]; ?> :: 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="cursor:hand">
            <td height="20" align="right" bgcolor="F3F3EE"><img id="EWTpospic" src="mainpic/bar_up.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $B[0]; ?>')">&nbsp;&nbsp;&nbsp;&nbsp;<img src="mainpic/bar_delete.gif" width="20" height="20" onClick="delete_d('<?php echo $B[0]; ?>')">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr id="tr<?php echo $B[0]; ?>" >
    <td valign="top" id="td<?php echo $B[0]; ?>"  style="cursor: no-drop;" onClick="return false;"><DIV align="center"   style="OVERFLOW: scroll;HEIGHT: 180;WIDTH: 305;"><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV></td>
  </tr>
</table></DIV>
		<?php } ?>
			</td>
			<!--ewt_right_design-->
        </tr>
		</table>
		<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr valign="top" > 
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
if($use_template != ""){
$sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$use_template."' ORDER BY design_block.position ASC");
}else{
$sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
}
		  while($B = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
	  <img id="EWTpospic" src="mainpic/o.gif" width="1" height="1">
<iframe name="auto_save" src="ewt_m_send.php?filename=<?php echo $_GET["filename"]; ?>"  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
</body>
</html>
<?php $db->db_close(); ?>
