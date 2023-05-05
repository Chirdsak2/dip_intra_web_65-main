<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$filename = $_REQUEST["filename"];
$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_REQUEST["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link id="stext" href="css/normal.css" rel="stylesheet" type="text/css">
<link  href="css/interface.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<script language="JavaScript" src="js/date-picker.js"></script>
<script language="JavaScript">
function changebg(c){
	for(i=1;i<5;i++){
		if(i != c){
			document.getElementById("mytd" +i).style.background="url(mainpic/bg_off.gif)";
		}else{
			document.getElementById("mytd" +i).style.background="url(mainpic/bg_on.gif)";
		}
			document.formAdvance.search_mode.value=c;
		}
	}
	function ChkStatus(){
		if(document.formAdvance.search_mode.value == "1"){
			formAdvance.action = "search_result.php";
			return true;
		}else if(document.formAdvance.search_mode.value == "2"){
			formAdvance.action = "search_images.php";
			return true;
		}else if(document.formAdvance.search_mode.value == "3"){
			formAdvance.action = "search_webboard.php";
			return true;
		}else if(document.formAdvance.search_mode.value == "4"){
			formAdvance.action = "search_faq.php";
			return true;
		}
	}
</script>
<script type="text/javascript" src="js/AjaxRequest.js"></script>
<script language="javascript1.2">
function category_swebb(obj){
var objDiv = document.getElementById("category_swebb");
	url='webboard_category.php?type='+obj;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
}
function ajax_save_menu_log(m_id, mp_id, Glink, Gtarget){
	
var objDiv = document.getElementById("category_swebb");
	url='menu_log.php?m_id='+m_id+'&mp_id='+mp_id;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
				if(Gtarget=='_blank') {
					window.open(Glink,'myWindow');
				} else {
					window.location.href=Glink;
				}
			}
		}
	);
}
function ajax_save_log(url){
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
			}
		}
	);
}
				</script>
<title>Advance Search</title></head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_REQUEST["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php if($B[1] != "article" AND $B[1] != "share" AND $B[1] != "org"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
		  $sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_REQUEST["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php if($B[1] != "article" AND $B[1] != "share" AND $B[1] != "org"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
          
    <td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"> 
     <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
        <tr> 
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">
              <form name="formAdvance" method="post" action="search_result.php" onSubmit="return ChkStatus()" target="_blank">
			  <tr> 
                  <td bgcolor="#666666" height="1"></td>
                </tr>
                <tr> 
                  <td height="25" align="center" bgcolor="FFFFFF"><br>
                    <font size="2" face="Tahoma"><strong>ค้นหาขั้นสูง</strong></font> 
                    <hr width="80%" size="1">
                    <table width="400" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
                      <tr>
                        <td ><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">
                            <tr>
                              <td width="90" height="25" align="center" background="mainpic/bg_on.gif" id="mytd1" onClick="changebg('1')" style="cursor:hand">เนื้อหา</td>
                              <td width="90" height="25" align="center" background="mainpic/bg_off.gif" id="mytd2" onClick="changebg('2')" style="cursor:hand">รูปภาพ</td>
                              <td width="90" height="25" align="center" background="mainpic/bg_off.gif" id="mytd3" onClick="changebg('3')" style="cursor:hand">Webboard</td>
                              <td width="90" height="25" align="center" background="mainpic/bg_off.gif" id="mytd4" onClick="changebg('4')" style="cursor:hand">FAQ</td>
                              <td background="mainpic/bg_line.gif">&nbsp;</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="center"> <br>
                          คำค้น 
                          <input name="keyword" type="text" id="keyword" style="font-family:'MS Sans Serif';font-size:12px;color:#000000;" value="<?php echo $keyword; ?>" size="30">
                          <br> <input name="oper" type="radio" value="OR" checked>
                    ค้นหาเฉพาะ<strong><font color="#FF0000">บางคำ</font></strong><br> 
                    <input type="radio" name="oper" value="AND">
                    ค้นหา<strong><font color="#FF0000">ทุกเงื่อนไข</font></strong> 
                    <input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>"></font> 
                          <input name="search_mode" type="hidden" id="search_mode" value="1">
                          <br>
                          <br>
                        </td>
                      </tr>
                    </table>
                    <br>
<hr width="80%" size="1">
                    <input type="submit" name="SubmitAdv" value="     ค้นหา...     " style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">
                    <br>
                    <br>
                  </td>
                </tr>
                <tr> 
                  <td bgcolor="#666666" height="1"></td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
      </table>
</td>
          <td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
		  $sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_REQUEST["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php if($B[1] != "article" AND $B[1] != "share" AND $B[1] != "org"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_REQUEST["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php if($B[1] != "article" AND $B[1] != "share" AND $B[1] != "org"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>
