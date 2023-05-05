<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST["Flag"] == "Add"){
			$db->query("USE ".$_SESSION["EWT_SDB"]);
	$block_name = "ORG".date("His");
	$value = $_POST["inc"].",".$_POST["otype"].",".$_POST["showname"].",".$_POST["showpic"].",".$_POST["showdetail"];
$db->query("INSERT INTO block (block_name,block_type,block_link,filename,block_edit) VALUES ('".$block_name."','org','".$value."','".$_POST["filename"]."','Y')");
$sql_max = $db->query("SELECT MAX(BID) FROM block WHERE block_name = '".$block_name."' AND filename = '".$_POST["filename"]."' ");
$BM = $db->db_fetch_row($sql_max);
$db->write_log("create","main","สร้าง block Organization : ".$block_name." ใน web page : ".$_POST["filename"]);
$block_html = "<img src=\"../../images/preview_org.gif\" width=\"194\" height=\"155\">";
include("../ewt_block_function.php");
?>
<script language="javascript">
function CreateDragContainer(){
	/*
	Create a new "Container Instance" so that items from one "Set" can not
	be dragged into items from another "Set"
	*/
	var DragDrops   = [];
	var cDrag = DragDrops.length;
	DragDrops[cDrag] = [];

	/*
	Each item passed to this function should be a "container".  Store each
	of these items in our current container
	*/
	for(var i=0; i<arguments.length; i++){
		var cObj = arguments[i];
		DragDrops[cDrag].push(cObj);
		cObj.setAttribute('DropObj', cDrag);

		/*
		Every top level item in these containers should be draggable.  Do this
		by setting the DragObj attribute on each item and then later checking
		this attribute in the mouseMove function
		*/
		for(var j=0; j<cObj.childNodes.length; j++){

			// Firefox puts in lots of #text nodes...skip these
			if(cObj.childNodes[j].nodeName=='#text') continue;

			cObj.childNodes[j].setAttribute('DragObj', cDrag);
		}
	}
}

	
	self.parent.iframe_data.document.all.tbcontent.innerHTML = self.parent.iframe_data.document.all.tbcontent.innerHTML + "<DIV class=DragBox id=EWTID_S<?php echo $BM[0]; ?>EWTID_E overClass=OverDragBox dragClass=DragDragBox align=left> :: <?php echo $block_name; ?> :: <table width=100% border=0 cellspacing=0 cellpadding=0> <tr style=cursor:hand><td height=20 bgcolor=F3F3EE><img src=\"<?php echo icon_block("org"); ?>\" width=20 height=20 align=absmiddle>&nbsp;&nbsp;&nbsp;&nbsp;<img id=EWTpospic src=../../images/bar_down.gif width=20 height=20 onClick=show_d(this,'tr<?php echo $BM[0]; ?>')>&nbsp;&nbsp;<img src=../../images/bar_edit.gif width=20 height=20 onClick=\"edit_d('<?php echo base64_encode(z.$BM[0].z00); ?>')\">&nbsp;&nbsp;<img src=../../images/bar_delete.gif width=20 height=20 onClick=\"delete_d('<?php echo $BM[0]; ?>')\"></td></tr><tr id=tr<?php echo $BM[0]; ?> style=display:none> <td id=td<?php echo $BM[0]; ?>   style=cursor: no-drop; onClick=return false;><?php echo addslashes($block_html); ?></td></tr></table></DIV>" ;
CreateDragContainer(self.parent.iframe_data.document.all.tbcontent);
self.parent.iframe_data.document.all.tbbottom.focus();
self.parent.iframe_data.auto_save.document.form1.tagdetect.value=self.parent.iframe_data.document.all.Demo4.innerHTML;
self.parent.iframe_data.auto_save.form1.submit();
</script>
<?php
  }else{
function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}
function GenPic($data){
$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}

$sql_group = $db->query("SELECT * FROM org_name ORDER BY parent_org_id ASC");
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.head_table { 
	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
	}
-->
</style>
<script language="JavaScript">
function divshow(c,d){
	if(c.style.display == ""){
	c.style.display = 'none';
	d.src = "../images/plus.gif";
	}else{
		c.style.display = '';
	d.src = "../images/minus.gif";
	}
}
function divshow1(c){
	if(c.style.display == ""){
	c.style.display = 'none';
	}else{
		c.style.display = '';
	}
}
	function choose(c){
		document.form1.inc.value = c;
		form1.submit();
		top.close();
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
        <form name="form1" method="post" action="content_org.php" target="save_function">
		<tr> 
          <td height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
            <strong>Insert Organization Chart
            <br>
             </strong>
              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr> 
                        <td width="20%"><input name="otype" type="radio" value="0" checked> แสดงหน่วยงานรูปแบบ tree</td>
                        <td width="18%"><input type="radio" name="otype" value="1"> แสดงบุคคลในหน่วยงาน</td>
                        <td width="20%"><input type="radio" name="otype" value="2"> แสดงหน่วยงานรูปแบบ chart</td>
						<td width="20%"><input type="radio" name="otype" value="3" <?php if($or[1] == "3"){ echo "checked"; } ?>>
						แสดงผังบุคลากรแบบ Chat </td>
                        <td width="22%"><input type="radio" name="otype" value="4" <?php if($or[1] == "4"){ echo "checked"; } ?>>
แสดงผังบุคลากรแบบรายการ</td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td width="33%"><input name="showname" type="checkbox" id="showname" value="Y" checked>
                          แสดงชื่อ - สกุลบุคลากรในหน่วยงาน</td>
                        <td width="33%"><input name="showpic" type="checkbox" id="showpic" value="Y" checked>
                          แสดงรูปภาพบุคลากร </td>
                        <td><input name="showdetail" type="checkbox" id="showdetail" value="Y" checked>
                          แสดงรายละเอียดของหน่วยงาน </td>
                      </tr>
                    </table></td>
                </tr>
              </table> </td>
        </tr>
        <tr> 
          <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">

        <input name="Flag" type="hidden" id="Flag" value="Add"><input name="inc" type="hidden" id="inc" value=""><input type="hidden" name = "filename" value = "<?php echo $_GET["filename"]; ?>">
<tr> 
    <td>
  <?php
  $i = 0;
  $k = 0;
  $LenChk =0;
  	while($R = $db->db_fetch_array($sql_group)){
	$sql_sub = $db->query("SELECT COUNT(org_id) FROM org_name WHERE parent_org_id LIKE '".$R["parent_org_id"]."_%'");
	$count_sub = $db->db_fetch_row($sql_sub);
	
	
				$len = GenLen($R["parent_org_id"],"_");
		
			if($LenChk > $len ){
				for($y=$len;$y<$LenChk;$y++){
					echo "</div>";
			}
		}
		  $LenChk = $len;
  ?>
        <div>
      <?php
	  $sqlchk = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' AND ugm_type = 'D' AND ugm_tid = '".$R["org_id"]."' ");
 		 $C = $db->db_fetch_row($sqlchk);
		  		GenPic($R["parent_org_id"]);
		   if($count_sub[0] > 0){ ?><img src="../images/plus.gif" border="0" align="absmiddle" onClick="divshow(document.all.dv<?php echo $i; ?>,this)"><?php }else{ ?><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php } ?><input type="checkbox" name="chk<?php echo $k; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?> onClick="choose('<?php echo $R["org_id"]; ?>')">
        <a href="#show" onClick="divshow1(document.all.dp<?php echo $i; ?>)"><img src="../images/user_group.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<?php echo $R["name_org"]; ?></a> 
        <input type="hidden" name="uid<?php echo $k; ?>" value="<?php echo $R["org_id"]; ?>"><input type="hidden" name="utype<?php echo $k; ?>" value="D">
      </div>
	                      <?php
	   $k++;
			   $sql_position = $db->query("SELECT * FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.org_id = '".$R["org_id"]."' ORDER BY user_position.up_rank ASC");
				echo "<div id=\"dp".$i."\"  style=\"display:none\">";
					while($P = $db->db_fetch_array($sql_position)){
					$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' AND ugm_type = 'P' AND ugm_tid = '".$P["up_id"]."' ");
 		 $C = $db->db_fetch_row($sqlchk);
						GenPic($R["parent_org_id"]);
						?>
                          <img src="../images/o.gif" width="40" height="20" border="0" align="absmiddle"><img src="../images/l_pos.gif" width="20" height="20" border="0" align="absmiddle"><img src="../images/user_pos.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<?php echo $P["pos_name"]; ?>
<input type="hidden" name="uid<?php echo $k; ?>" value="<?php echo $P["up_id"]; ?>"><input type="hidden" name="utype<?php echo $k; ?>" value="P"><br>
						<?php
						$k++;
					}
				echo "</div>";
		   ?>
	   <?php  if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  style=\"display:none\">"; }  ?>
  <?php 
	
   $i++; } ?>
  </div>
</td>
  </tr><input name="alli" type="hidden" value="<?php echo $k; ?>">
</table></td>
              </tr>
            </table></td>
        </tr>
       </form>
      </table></td>
        </tr>
      </table>
</body>
</html>
<?php
}
 $db->db_close(); ?>
