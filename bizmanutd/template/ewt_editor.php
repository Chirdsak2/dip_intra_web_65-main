<?php
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");

$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name,block_link FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_array($sql_file);
$sql_text = $db->query("SELECT * FROM block_text WHERE BID = '".$BID."' AND text_id = '".$R["block_link"]."'");
$T = $db->db_fetch_array($sql_text);
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../../css/style.css" rel="stylesheet" type="text/css">
<script language=JavaScript src='../scripts/innovaeditor.js'></script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#666666">
<form name="frmSaveContents" method="post" action="../../ContentMgt/content_function.php" onSubmit="window.opener.document.getElementById('td<?php echo $BID; ?>').innerHTML = document.frmSaveContents.txtContent.value;">
<tr> 
    <td align="center" bgcolor="#F7F7F7"><textarea id="txtContent" name="txtContent" rows=4 cols=30>
  <?php
  function encodeHTML($sHTML)
    {
    $sHTML=ereg_replace("&","&amp;",$sHTML);
    $sHTML=ereg_replace("<","&lt;",$sHTML);
    $sHTML=ereg_replace(">","&gt;",$sHTML);
    return $sHTML;
    }

  if(isset($T["text_html"]))
    {
    $sContent=stripslashes($T["text_html"]); /*** remove (/) slashes ***/
    echo encodeHTML($sContent);
    }
  ?>
  </textarea>

  <script>
    var oEdit1 = new InnovaEditor("oEdit1");

    oEdit1.width="100%";
    oEdit1.height="480";

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
    "StyleAndFormatting","TextFormatting","ListFormatting",
    "BoxFormatting","ParagraphFormatting","CssText","Styles",
    "Paragraph","FontName","FontSize",
    "Bold","Italic","Underline","Strikethrough",
    "ForeColor","BackColor"];// => Custom Button Placement

oEdit1.useTab = false;
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

    //oEdit1.mode="HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"
	oEdit1.mode="XHTMLBody";
    oEdit1.REPLACE("txtContent");
  </script></td>
  </tr>

    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
      <td height="20" align="left" bgcolor="#FFFFFF">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5" background="../../images/content_bg_line.gif"></td>
            <td align="right">Block name : 
              <input name="bname" type="text" id="bname" value="<?php echo $R["block_name"]; ?>" size="40" maxlength="40"> 
              <input name="imageField" type="image" src="../../images/disk_blue.gif" align="top" width="32" height="32" border="0">
 <strong><font size="2" face="Tahoma">Save</font></strong> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="SaveEditor1"></td>
          </tr>
        </table></td>
  </tr>
    </form>
</table>
</body>
</html>
<?php } ?>
<?php $db->db_close(); ?>
