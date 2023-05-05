<html>
<head>
<title>Editor test</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language=JavaScript src='../scripts/innovaeditor.js'></script>
<script language="javascript1.2">
function used_txtContent(){
//alert(document.frmSaveContents.txtContent.value);
self.opener.document.all.splash_text<?php echo $_GET['img_id']?>.value= '';
self.opener.document.all.splash_text<?php echo $_GET['img_id']?>.value=document.frmSaveContents.txtContent.value;
window.close();
return false;
}

</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#666666">
<form name="frmSaveContents" method="post" action="" onSubmit="used_txtContent();">
<tr> 
    <td align="center" valign="top" bgcolor="#F7F7F7">
	<textarea id="txtContent" name="txtContent" rows=4 cols=30>
<?php
			//	$detail = $_GET['splash_text'.$_GET['img_id']];
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
	document.frmSaveContents.txtContent.value = self.opener.document.all.splash_text<?php echo $_GET['img_id']?>.value;
    var oEdit1 = new InnovaEditor("oEdit1");

    oEdit1.width="580";
    oEdit1.height="410";

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

    oEdit1.REPLACE("txtContent");
  </script>  </td>
  </tr>
<tr>
  <td valign="top" bgcolor="#F7F7F7"><div align="right">
    <input name="submit" type="submit" value="    ตกลงใช้ข้อมูลนี้    " >
  </div></td>
</tr>
  </form>
</table>

</body>
</html>
