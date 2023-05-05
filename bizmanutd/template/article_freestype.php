<?php
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
@include("language/language.php");


$sql_article = $db->query("SELECT * FROM article_list WHERE n_id = '".$_GET["nid"]."'");
$R = $db->db_fetch_array($sql_article);
$nid = $_GET["nid"];
			   
			 
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language=JavaScript src='../scripts/innovaeditor.js'></script>
<link href="../../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">บริหารข่าว/บทความ</span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="../../ContentMgt/article_edit.php?nid=<?php echo $_GET["nid"]; ?>&cid=<?php echo $R["c_id"]; ?>"><img src="../../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> กลับหน้าก่อนหน้า</a>&nbsp;&nbsp;&nbsp;<a href="../../ContentMgt/article_group.php"><img src="../../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> หน้าหลัก</a> &nbsp;&nbsp;&nbsp;<a href="../../ContentMgt/article_list.php?cid=<?php echo $R["c_id"]; ?>"><img src="../../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> หน้ารายการข่าว/บทความ</a> &nbsp;&nbsp;&nbsp;<a href="../../ContentMgt/article_new.php?cid=<?php echo $R["c_id"]; ?>"><img src="../../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่มข่าว/บทความ</a>
        <hr>
    </td>
  </tr>
</table>
<table width="94%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <form action="../../ContentMgt/article_function_free.php" method="post" name="form1" >
    <input type="hidden" name="backto" value="<?php if($_SESSION["EWT_OPEN_ARTICLE"] == ""){ echo "article_group.php"; }else{ echo "article_list.php?cid=".$_SESSION["EWT_OPEN_ARTICLE"]; } ?>">
        <tr>
      <td height="30" bgcolor="F3F3EE" class="ewttablehead"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
        <?php echo $text_genarticle_textnewsdetail ;?><?php echo $R["at_id"]; ?> :<?php echo $text_genarticle_textdesignpreview;?>  <?php
						$sql_temp = $db->query("SELECT d_id,d_name,d_default FROM design_list,template_module where  template_module.tm_did = design_list.d_id");
						?>
                                <select name="template">
								<option value="" >Default</option>
                                  <?php while($T=$db->db_fetch_array($sql_temp)){ ?>
                                  <option value="<?php echo $T["d_id"]; ?>" <?php if($T["d_id"] == $R["d_id"]){ echo "selected"; } ?>><?php echo $T["d_name"]; ?></option>
                                  <?php } ?>
                                </select>
								<?php $sql_temp = $db->query("SELECT d_id,d_name,d_default FROM design_list,template_module where  template_module.tm_did = design_list.d_id"); ?>
								W3c Template :
								<select name="template_w3c">
                                  <option value="" >Default</option>
                                  <?php while($T=$db->db_fetch_array($sql_temp)){ ?>
                                  <option value="<?php echo $T["d_id"]; ?>" <?php if($T["d_id"] == $R["d_id_w3c"]){ echo "selected"; } ?>><?php echo $T["d_name"]; ?></option>
                                  <?php } ?>
                                </select>
        <input type="submit" name="Button1" value="<?php echo $text_genarticle_buttonupdate;?>"  onClick="document.form1.n_action.value='save';">
        <input type="button" name="Submit2" value="<?php echo $text_genarticle_buttonReset;?>" onClick="self.location.reload();">
		<input type="submit" name="Button3" value="<?php echo $text_genarticle_buttonPreview;?>"  onClick="window.open('','artpv','width=800,height=550,resizable=1,scrollbars=1'); document.form1.n_action.value='preview'; ">
		<input type="submit" name="Button4" value="<?php echo $text_genarticle_buttonexit;?>"  onClick="document.form1.n_action.value='exit';form1.submit();"> 
		<input type="submit" name="Button5" value="Cancel this article"  onClick="document.form1.n_action.value='cancel'; return confirm('คุณแน่ใจหรือไม่ที่ต้องการลบ ข่าว/บทความนี้?'); ">
        <input name="Flag" type="hidden" id="Flag" value="NewsDetail">
        <input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>">
        <input name="cid" type="hidden" id="cid" value="<?php echo $R["c_id"]; ?>">
        <input name="n_action" type="hidden" id="n_action">        </td>
    </tr>
        <tr>
          <td height="30" bgcolor="F3F3EE" class="head_table"><strong><?php echo $text_genarticle_textconfirmarticle;?>: </strong><br>
<input name="chk_group" type="checkbox" id="chk_group" value="1" <?php if($R["show_group"] =='1'){ echo checked;}?>>
            แสดงหมวดข่าว/บทความ 
			 <input name="chk_topic" type="checkbox" id="chk_topic" value="1" <?php if($R["show_topic"] =='1'){ echo checked;}?>>
         แสดงหัวข้อข่าว/บทความ
		  <input name="chk_date" type="checkbox" id="chk_date" value="1" <?php if($R["show_date"] =='1'){ echo checked;}?>>
         แสดงวันที่
		 <input name="chk_textsize" type="checkbox" id="chk_textsize" value="1" <?php if($R["show_textsize"] =='1'){ echo checked;}?>>
        แสดงเครื่องมือปรับขนาดอักษร
		<input name="chk_show_count" type="checkbox" id="chk_show_count" value="1"  <?php if($R["show_count"] =='1'){ echo checked;}?>>
       แสดงจำนวนการเข้าอ่าน[ครั้ง]<br>
            <input name="chk_newsshow" type="checkbox" id="chk_newsshow" value="1" <?php if($R["show_newstop"] =='1'){ echo checked;}?>>
            <?php echo $text_genarticle_textnewstopfive;?>
            
            <input name="chk_vote" type="checkbox" id="chk_vote" value="1" <?php if($R["show_vote"] =='1'){ echo checked;}?>>
         <?php echo $text_genarticle_textvote;?>
		 <input name="chk_comment" type="checkbox" id="chk_comment" value="1" <?php if($R["show_comment"] =='1'){ echo checked;}?> onClick="if(this.checked){document.all.comment_type.style.display='';}else{document.all.comment_type.style.display='none';}">
             <?php echo $text_genarticle_textconment;?> 
            <select name="comment_type">
              <option value="1" <?php if($R["comment_type"] =='1'){ echo "selected";}?>>ทุกคนแสดงความคิดเห็นได้</option>
              <option value="2" <?php if($R["comment_type"] =='2'){ echo "selected";}?>>Login ก่อนแสดงความคิดเห็น</option>
            </select>
			<script language="javascript">
			  if(document.form1.chk_comment.checked){
			  document.all.comment_type.style.display='';
			  }else{
			  document.all.comment_type.style.display='none';}
			</script><hr>
			<a href="../../ContentMgt/article_upload_file.php?n_id=<?php echo $nid; ?>&cid=<?php echo $R["c_id"];?>"><img src="../../theme/main_theme/g_add.gif" border="0" align="middle"> เพิ่มรายการเอกสารแนบ</a></td>
        </tr>
	<?php
	$sql_t = $db->query("SELECT * FROM article_template WHERE at_id = '$R[at_id]'");
	$A = $db->db_fetch_array($sql_t);
	?>
	<tr> 
      <td valign="top">
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td align="center"><strong><?php echo $R["n_topic"]; ?></strong></td>
  </tr>
</table>

<table width="99%" border="0" align="center" cellpadding="4" cellspacing="1" >
  <?php
  //echo "SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '1' AND at_type_col = '1'";
	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '1' AND at_type_col = '1' ");
	  $C1 = $db->db_fetch_array($sql_r);
	  ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td width="100%" >
    <textarea name="dx1y0" cols="80" rows="12" id="dx1y0" >
	<?php
			  function encodeHTML($sHTML)
				{
				$sHTML=ereg_replace("&","&amp;",$sHTML);
				$sHTML=ereg_replace("<","&lt;",$sHTML);
				$sHTML=ereg_replace(">","&gt;",$sHTML);
				return $sHTML;
				}
			  if(isset($C1["ad_des"]))
				{
				$sContent=stripslashes($C1["ad_des"]); /*** remove (/) slashes ***/
				echo encodeHTML($sContent);
				}
		  ?>
			</textarea>
     <script>
    var oEdit1 = new InnovaEditor("oEdit1");

    oEdit1.width="700";
    oEdit1.height="400";

    /***************************************************
    ADDING CUSTOM BUTTONS
    ***************************************************/

    //oEdit1.arrCustomButtons = [["CustomName1","alert('Command 1 here.')","Caption 1 here","btnCustom1.gif"],
  //  ["CustomName2","alert(\"Command '2' here.\")","Caption 2 here","btnCustom2.gif"],
  //  ["CustomName3","alert('Command \"3\" here.')","Caption 3 here","btnCustom3.gif"]]


    /***************************************************
    RECONFIGURE TOOLBAR BUTTONS
    ***************************************************/

    oEdit1.features=["Save","FullScreen","Preview","Print",
    "Search","SpellCheck",
    "Superscript","Subscript","LTR","RTL",
    "Table","Guidelines","Absolute",
    "Flash","Media",
    "Form","Characters","ClearAll","XHTMLFullSource","XHTMLSource","BRK",
    "Cut","Copy","Paste","PasteWord","PasteText",
    "Undo","Redo","Hyperlink","Bookmark","Image",
    "JustifyLeft","JustifyCenter","JustifyRight","JustifyFull",
    "Numbering","Bullets","Indent","Outdent",
    "Line","RemoveFormat","BRK",
    "StyleAndFormatting","ListFormatting",
    "BoxFormatting","ParagraphFormatting","CssText","Styles",
    "Paragraph","FontName","FontSize",
    "Bold","Italic","Underline","Strikethrough",
    "ForeColor","BackColor"];// => Custom Button Placement


    /***************************************************
    OTHER SETTINGS
    ***************************************************/
   // oEdit1.css="style/test.css";//Specify external css file here

  //  oEdit1.cmdAssetManager = "modalDialogShow('../../../FileMgt/gallery_insert.php',640,465)"; //Command to open the Asset Manager add-on.
 //   oEdit1.cmdInternalLink = "modelessDialogShow('links.htm',365,270)"; //Command to open your custom link lookup page.
 //   oEdit1.cmdCustomObject = "modelessDialogShow('objects.htm',365,270)"; //Command to open your custom content lookup page.

 //   oEdit1.arrCustomTag=[["First Name","{%first_name%}"],
 //   ["Last Name","{%last_name%}"],
//    ["Email","{%email%}"]];//Define custom tag selection

 //   oEdit1.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];//predefined custom colors

    oEdit1.mode="XHTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"

    oEdit1.REPLACE("dx1y0");
  </script><input name="adx1y0" type="hidden" value="<?php echo $C1["ad_id"];?>">		</td>
  </tr>
</table></td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
 	$db->db_close(); ?>
