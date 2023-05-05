<?php
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
include("../../lib/set_lang.php");
if($_POST[flag]=='set_lang'){
	for($i=0;$i<$_POST[num];$i++){
		if($_POST[lang_detail][$i] != ''){
			$_POST[lang_detail][4] .= $_POST[lang_detail][$i];
		}
	}
	for($i=0;$i<$_POST[num];$i++){
		set_lang($_POST[c_id],$_POST[lang_name],$_POST[lang_field][$i],$_POST[lang_detail][$i],$module);
	}
	?>
      <script language="JavaScript">
		  alert('บันทึกข้อมูลเรียบร้อย');
		   location.href='../../ContentMgt/article_list.php?cid=<?php echo $_POST[c_parent];?>';
     </script>
   <?php
   exit;
}
$type = 'list';
$sql = $db->db_fetch_array($db->query("select c_id,n_date,n_topic,n_des,source,sourceLink,keyword,n_date_start,n_date_end,at_id from article_list where n_id = '".$_GET[id]."'"));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language=JavaScript src='../../scripts/innovaeditor.js'></script>
<script language="javascript1.2">
function chk(){
	if(document.form1.lang_name.value == ""){
		alert("Please insert languang!!");
		document.form1.lang_name.focus();
		return false;
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="article_list.php" onSubmit="return chk();">
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle" /> <span class="ewtfunction">บริหารข่าว/บทความ</span> </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"> <?php if ($type != 'list'){ if($sql[c_parent]==0 ){ ?><a href="../../ContentMgt/article_group.php"><?php }else{ ?><a href="../ContentMgt/article_list.php?cid=<?php echo $sql[c_parent];?>"><?php }}else{?><a href="../ContentMgt/article_list.php?cid=<?php echo $sql[c_id];?>"><?php } ?><img src="../../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle" />กลับ</a> 
          <hr />
      </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"><a href="javascript:void(0);" onClick="document.getElementById('nav').style.display='none';"></a></td>
      </tr>
    </table>
    <table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#999999" class="ewttableuse">
  <tr>
    <th height="23" colspan="4" bgcolor="#FFFFFF" class="ewttablehead" scope="col"><div align="left">&bull;&nbsp;กรุณาใส่ภาษาตามที่ท่านเลือก(<?php echo $_GET[lang];?>)</div></th>
  </tr>
   
  <tr>
    <td width="247" height="11" valign="top" bgcolor="#FFFFFF">Topic   : <strong style="color:#FF0000">*</strong></td>
    <td width="304" height="0" valign="top" bgcolor="#FFFFFF"><input name="lang_detail[0]" type="text" size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'n_topic','article_list');?>"><input type="hidden" name="lang_field[0]" value="n_topic"></td>
    <td width="20" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="270" height="0" valign="top" bgcolor="#FFFFFF"><?php echo nl2br ($sql[n_topic]);?></td>
  </tr>
  <tr>
    <td height="12" valign="top" bgcolor="#FFFFFF">Description : <strong style="color:#FF0000">*</strong></td>
    <td width="277" height="0" valign="top" bgcolor="#FFFFFF"><input name="lang_detail[1]" type="text" id="lang_detail[1]" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'n_des','article_list');?>" size="50">
      <input type="hidden" name="lang_field[1]" value="n_des"></td>
    <td width="13" height="0" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="316" height="0" valign="top" bgcolor="#FFFFFF"><?php echo nl2br ($sql[n_des]);?></td>
  </tr>
 <tr  style="display:none" >
    <td height="23" valign="top" bgcolor="#FFFFFF">Source   : <strong style="color:#FF0000">*</strong></td>
    <td width="277" height="0" valign="top" bgcolor="#FFFFFF"><input name="lang_detail[2]" type="text" size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'source','article_list');?>">
      <input type="hidden" name="lang_field[2]" value="source"></td>
    <td width="13" height="0" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="316" height="0" valign="top" bgcolor="#FFFFFF"><?php echo nl2br ($sql[source]);?></td>
  </tr>
  <tr  style="display:none" >
    <td height="23" valign="top" bgcolor="#FFFFFF">Source URL: <strong style="color:#FF0000">*</strong></td>
    <td width="277" height="0" valign="top" bgcolor="#FFFFFF"><input name="lang_detail[3]" type="text" size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'sourceLink','article_list');?>">
      <input type="hidden" name="lang_field[3]" value="sourceLink"></td>
    <td width="13" height="0" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="316" height="0" valign="top" bgcolor="#FFFFFF"><?php echo nl2br ($sql[sourceLink]);?></td>
  </tr>
  
   <tr  style="display:none" >
    <td height="12" colspan="4" valign="top" bgcolor="#FFFFFF"><hr></td>
    </tr>
  <tr style="display:none" >
    <td height="23" valign="top" bgcolor="#FFFFFF">Keyword  : <strong style="color:#FF0000">*</strong></td>
    <td height="0" colspan="2" valign="top" bgcolor="#FFFFFF"><input name="lang_detail[4]" type="hidden" size="50" value="<?php echo stripslashes(htmlspecialchars(select_lang_detail($_GET[id],$_GET[langid],'keyword','article_list')));?>">
      <input type="hidden" name="lang_field[4]" value="keyword"></td>
    <td width="316" valign="top" bgcolor="#FFFFFF"></td>
  </tr>
  <tr  style="display:none">
    <td height="23" valign="top" bgcolor="#FFFFFF">Date  : <strong style="color:#FF0000">*</strong></td>
    <td height="0" colspan="3" bgcolor="#FFFFFF">
	<?php
	if($sql[n_date] != ''){
		$date_n = explode("-",$sql[n_date]);
		$Y = $date_n[0];
		$m = $date_n[1];
		$d = $date_n[2];
		$date_n = ($Y-543).'-'.$m.'-'.$d;
	}
	if($sql[n_date_start] != ''){
		$date_s = explode(" ",$sql["n_date_start"]);
		$date_start = explode("-",$date_s[0]);
		$date_time = explode(":",$date_s[1]);
		$Y = $date_start[0];
		$m = $date_start[1];
		$d = $date_start[2];
		$date_s = ($Y-543).'-'.$m.'-'.$d.' '.$date_s[1];
	}
	if($sql[n_date_end] != ''){
		$date_e = explode(" ",$sql["n_date_end"]);
		$date_end = explode("-",$date_e[0]);
		$date_time = explode(":",$date_e[1]);
		$Y = $date_end[0];
		$m = $date_end[1];
		$d = $date_end[2];
		$date_e = ($Y-543).'-'.$m.'-'.$d.' '.$date_e[1];
	}
	?>
	<input name="lang_detail[5]" type="hidden" size="50" value="<?php echo $date_n ;?>">
      <input type="hidden" name="lang_field[5]" value="n_date">     </td>
  </tr>
  <tr  style="display:none">
    <td height="23" valign="top" bgcolor="#FFFFFF">กำหนดวันที่แสดงข่าวเริ่มต้น   : <strong style="color:#FF0000">*</strong></td>
    <td height="0" colspan="3" bgcolor="#FFFFFF"><input name="lang_detail[6]" type="hidden" size="50" value="<?php echo $date_s;?>">
      <input type="hidden" name="lang_field[6]" value="n_date_start">
      <?php echo $sql[n_date_start];?></td>
  </tr>
  <tr  style="display:none">
    <td height="11" valign="top" bgcolor="#FFFFFF">กำหนดวันที่แสดงข่าวสิ้นสุด  : <strong style="color:#FF0000">*</strong></td>
    <td height="0" colspan="3" bgcolor="#FFFFFF"><input name="lang_detail[7]" type="hidden" size="50" value="<?php echo $date_e;?>">
      <input type="hidden" name="lang_field[7]" value="n_date_end">
      <?php echo $sql[n_date_end];?></td>
  </tr>
  <tr>
    <td height="33" bgcolor="#FFFFFF">Design Preview    : <strong style="color:#FF0000">*</strong></td>
    <td height="33" bgcolor="#FFFFFF"><?php $sql_temp = $db->query("SELECT d_id,d_name,d_default FROM design_list,template_module where  template_module.tm_did = design_list.d_id");
						?>
                                <select name="lang_detail[8]">
								<option value="" <?php if($sql["d_id"] == ""){ echo "selected"; } ?>>Default</option>
                                  <?php while($T=$db->db_fetch_array($sql_temp)){ ?>
                                  <option value="<?php echo $T["d_id"]; ?>" <?php if($T["d_id"] == select_lang_detail($_GET[id],$_GET[langid],'d_id','article_list')){ echo "selected"; } ?>><?php echo $T["d_name"]; ?></option>
                                  <?php } ?>
            </select><input type="hidden" name="lang_field[8]" value="d_id"></td>
    <td  valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td  height="0" valign="top" bgcolor="#FFFFFF"></td>
  </tr>
  <tr  >
    <td height="12" colspan="4" valign="top" bgcolor="#FFFFFF"><hr></td>
    </tr>
  <tr>
    <td height="23" valign="top" bgcolor="#FFFFFF">detail : <strong style="color:#FF0000">*</strong></td>
    <td height="0" colspan="3" bgcolor="#FFFFFF">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php
	//find data template
	//echo $sql[at_id];
		if($sql[at_id] > 0 && $sql[at_id] < 10){
		$n = 9;
		$sql_detail = "SELECT ad_id,ad_des,at_type_col,at_type_row FROM article_detail where n_id = '".$_GET[id]."'";
		$query_detail = $db->query($sql_detail);
		while($R_detail= $db->db_fetch_array($query_detail)){
		if($R_detail[ad_des] != ''){
	?>
		  <tr>
			<td width="304" valign="top"><textarea name="lang_detail[<?php echo $n;?>]" cols="50" rows="15"><?php echo select_lang_detail($_GET[id],$_GET[langid],'ad_des'.$R_detail[ad_id],'article_list');?></textarea>
      <input type="hidden" name="lang_field[<?php echo $n;?>]" value="ad_des<?php echo $R_detail[ad_id];?>">		</td>
		    <td width="20" valign="top">&nbsp;&nbsp;</td>
		    <td width="270">&nbsp;<?php echo nl2br ($R_detail[ad_des]);?>	  </td>
		  </tr>
		  <?php
		  $n++;
		  }
		  }
		   }else if($sql[at_id]  == 10){
		   $sql_detail = "SELECT ad_id,ad_des,at_type_col,at_type_row FROM article_detail where n_id = '".$_GET[id]."'";
		$query_detail = $db->query($sql_detail);
		while($R_detail= $db->db_fetch_array($query_detail)){
		if($R_detail[ad_des] != ''){
		   ?>
		  <tr>
			<td colspan="3" valign="top"><?php echo nl2br ($R_detail[ad_des]);?> <br>
			  <textarea name="lang_detail[9]" cols="50" rows="6" id="lang_detail[9]" >
	<?php
	 $detail = select_lang_detail($_GET[id],$_GET[langid],'ad_des'.$R_detail[ad_id],'article_list');
			  function encodeHTML($sHTML)
				{
				$sHTML=ereg_replace("&","&amp;",$sHTML);
				$sHTML=ereg_replace("<","&lt;",$sHTML);
				$sHTML=ereg_replace(">","&gt;",$sHTML);
				return $sHTML;
				}
			  if(isset($detail))
				{
				$sContent=stripslashes($detail); /*** remove (/) slashes ***/
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

    oEdit1.mode="HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"

    oEdit1.REPLACE("lang_detail[9]");
  </script>
      <input type="hidden" name="lang_field[9]" value="ad_des<?php echo $R_detail[ad_id];?>">		&nbsp;	  </td>
		    </tr>
		  <?php
		   	}
			}
		   } 
		   ?>
	</table>	</td>
  </tr>
   <tr>
    <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="23" colspan="3" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="บันทึก">
      
      <input type="hidden" name="flag" value="set_lang">
	  <input type="hidden" name="num" value="<?php if($sql[at_id] > 0 && $sql[at_id] < 10){  echo ($n); }else if($sql[at_id]  == 10){  echo '10';}else{ echo '9';}?>">
      <input type="hidden" name="c_id" value="<?php echo $_GET[id]?>">
	  <input type="hidden" name="c_parent" value="<?php echo $sql[c_id];?>">
	  <input type="hidden" name="lang_name" value="<?php echo $_GET[langid]?>">
	  <input type="hidden" name="module" value="article_list"></td>
  </tr>
</table></td>
  </tr>
</table>

</form>
</body>
</html>