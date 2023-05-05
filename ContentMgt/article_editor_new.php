<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST[edit]!=1){

	$SQL = $db->query("SELECT ad_des FROM article_detail WHERE ad_id = '$_GET[ad_id]'");
	$PR = mysql_fetch_array($SQL);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language=JavaScript src='../ewt/scripts/innovaeditor.js'></script>
</head>
			<body topmargin="0" leftmargin="0">
			<form action="article_editor_new.php" method="post">
			<textarea name="ad_des" cols="100" rows="10" wrap="VIRTUAL" id="ad_des" class="form-control" style="width:80%;">  <?php
						function encodeHTML($sHTML){
							$sHTML=ereg_replace("&","&amp;",$sHTML);
							$sHTML=ereg_replace("<","&lt;",$sHTML);
							$sHTML=ereg_replace(">","&gt;",$sHTML);
							return $sHTML;
						}
						if(isset($PR[ad_des])){
							$sContent=stripslashes($PR[ad_des]); /*** remove (/) slashes ***/
							echo encodeHTML($sContent);
						}
					  ?>
			</textarea>
			<br><br>
			<script>
					var oEdit1 = new InnovaEditor("oEdit1");
					
					oEdit1.width="<?php echo $_GET[width]?>";
					oEdit1.height="<?php echo $_GET[height]-100?>";
					oEdit1.tabs=[["tabHome", "", ["grpFont", "grpPara"]]];
				oEdit1.groups=[
				["grpFont", "", ["FontName", "FontSize","Table","Guidelines", "BRK", "Bold", "Italic", "Underline","Strikethrough","Superscript","Subscript", "ForeColor", "BackColor","Hyperlink"]],
				["grpPara", "", ["Paragraph", "Indent", "Outdent", "LTR", "RTL", "BRK", "JustifyLeft", "JustifyCenter","JustifyRight","JustifyFull", "Numbering","Bullets", "XHTMLSource"]]
				];
				//oEdit1.useTab = false;
					oEdit1.mode="XHTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"
					oEdit1.REPLACE("ad_des");
			</script>

			<input type="hidden" name="OP" value="<?php echo $_GET[OP]?>" >
			<input type="hidden" name="OE" value="<?php echo $_GET[OE]?>" >
			<input type="hidden" name="OT" value="<?php echo $_GET[OT]?>" >
			<input type="hidden" name="edit" value="1" >
			<input type="hidden" name="ad_id" value="<?php echo $_GET[ad_id]?>" >

			<input type="submit" name="save" value=" บันทึก " style="width:60 px" class="btn btn-success" >
			<input type="button" name="cancel" value=" ยกเลิก " style="width:60 px" class="btn btn-warning" 
			onclick="
			self.parent.document.all.<?php echo $_GET[OP]?>.style.display='';
			self.parent.document.all.<?php echo $_GET[OE]?>.style.display='none';">
			</form>

<?php  }else{  
	    $update = "UPDATE article_detail SET ad_des = '".addslashes($_POST[ad_des])."'  WHERE ad_id ='$_POST[ad_id]' ";
		$db->query($update);

		$sql_l = $db->query("SELECT * FROM article_detail WHERE ad_id = '$_POST[ad_id]' ");
		$C1 = $db->db_fetch_array($sql_l);
?>
<body id="Move01">
   <?php echo stripslashes($C1["ad_des"]);?>
</body>
    <script language="javascript">
		self.parent.document.all.<?php echo $_POST[OP]?>.style.display='';
		self.parent.document.all.<?php echo $_POST[OE]?>.style.display='none';
		self.parent.document.all.<?php echo $_POST[OT]?>.innerHTML = document.all.Move01.innerHTML;
	</script>
<?php  } ?>
<?php $db->db_close(); ?>
</html>