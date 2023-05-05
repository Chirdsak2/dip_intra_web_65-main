<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		
$sql_article = $db->query("SELECT article_group.*,article_apply.a_id,article_apply.a_show FROM article_group INNER JOIN article_apply ON article_group.c_id = article_apply.c_id  WHERE article_apply.text_id = '".$_GET["text_id"]."' AND article_apply.a_active = 'Y' ORDER BY article_apply.a_pos ASC");

	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function getValue(c,d){
	document.form1.aid.value=c;
	var e = document.form1.pos.value;
	document.getElementById('ah'+e).style.backgroundColor = "#FFFFFF";
	document.getElementById('ah'+d).style.backgroundColor = "#D5D6DB";
	document.form1.pos.value = d;
	}
		function button_over(eButton){
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "buttonhighlight solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "buttonhighlight solid 1px";
	}
				
	function button_out(eButton){
	eButton.style.borderColor = "F3F3EE";
	}
	function chkPos(c,d,e){
		if(c.value == ""){
			c.value = document.getElementById('opos'+d).value;
		}else if(c.value == document.getElementById('opos'+d).value){
			return false;
		}else if(c.value > 0){
					var gpos = c.value;
					document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"article_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"ChangePosition\"><input name=\"text_id\" type=\"hidden\" value=\"<?php echo $_GET["text_id"]; ?>\"><input name=\"aid\" type=\"hidden\" value=\""+ e + "\"><input name=\"position\" type=\"hidden\" value=\""+ gpos + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
					createform.submit();
		}else{
			c.value = document.getElementById('opos'+d).value;
		}
	}
	function MoveUp(c){
						document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"moveupform\" method=\"post\" action=\"article_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"MoveUp\"><input name=\"text_id\" type=\"hidden\" value=\"<?php echo $_GET["text_id"]; ?>\"><input name=\"aid\" type=\"hidden\" id=\"aid\" value=\""+ c +"\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
						moveupform.submit();
}
function MoveDown(c){
						document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"movedownform\" method=\"post\" action=\"article_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"MoveDown\"><input name=\"text_id\" type=\"hidden\" value=\"<?php echo $_GET["text_id"]; ?>\"><input name=\"aid\" type=\"hidden\" id=\"aid\" value=\""+ c +"\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
						movedownform.submit();
}
</script>
<style type="text/css">
<!--
.text_table {
	width:20px;
	height:18px;
	text-align:right;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<span id="formtext"></span>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <form name="form1" method="post" action="article_function.php" >
    <input type="hidden" name="Flag" value="PositionText">
    <input name="text_id" type="hidden" id="text_id" value="<?php echo $_GET["text_id"]; ?>">
    <input name="pos" type="hidden" id="pos" value="1">
    <input name="aid" type="hidden" id="aid" value="">
    <?php
	$i=1;
	$allrow = $db->db_num_rows($sql_article);
	 while($G = $db->db_fetch_array($sql_article)){ 
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="20" valign="top" bgcolor="#FFFFFF" id="ah<?php echo $i; ?>" style="cursor:hand" onClick="getValue('<?php echo $G["a_id"]; ?>','<?php echo $i; ?>');"> 
        <li><?php echo $G["c_name"]; ?></li></td>
      <td width="30" align="right" valign="top" bgcolor="F3F3EE"><input type="hidden" name="opos<?php echo $i; ?>" id="opos<?php echo $i; ?>" value="<?php echo $G["a_show"]; ?>">
        <input name="apos<?php echo $i; ?>" type="text" size="1" value="<?php echo $G["a_show"]; ?>" class="text_table" onBlur="chkPos(this,'<?php echo $i; ?>','<?php echo $G["a_id"]; ?>')"></td>
      <td width="50" align="right" valign="top" nowrap bgcolor="F3F3EE"><?php if($allrow > 1){ 
						if($i > 1){ 
						?><a href="#up" onClick="MoveUp('<?php echo $G["a_id"]; ?>')"><img src="../images/bar_up.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Move Group Up"></a><?php
						}else{
						?><img src="../images/bar_up_off.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE"><?php
						}
						 if($i != $allrow){ ?><a href="#down" onClick="MoveDown('<?php echo $G["a_id"]; ?>')"><img src="../images/bar_down.gif" width="20" height="20"  align="absmiddle" border="1" style="border-Color:F3F3EE"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Move Group Down"></a><?php }else{
							  ?><img src="../images/bar_down_off.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE"><?php
							   }
							   }else{
							  ?><img src="../images/bar_up_off.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE"><img src="../images/bar_down_off.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE"><?php
							  }
							   ?></td>
    </tr>
    <?php  $i++; } ?>
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
