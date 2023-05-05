<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

		if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}
		$_SESSION["EWT_OPEN_ARTICLE"] = "";
		
$sql_rss = $db->query("SELECT * FROM rss ORDER BY rss_id ASC");
	?>
<html>
<head>
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
self.parent.document.all.backon.style.display = 'none';
self.parent.document.all.backoff.style.display = '';
self.parent.document.all.folderoff.style.display = 'none';
self.parent.document.all.folderon.style.display = '';
self.parent.document.all.deloff.style.display = 'none';
self.parent.document.all.delon.style.display = '';
			 function chkKeyFo(c){
			 		if(event.keyCode == 13){
						create_fo(c);
					}
			 }
			 function create_fo(c){
				if(c.value == ""){
					document.all.new_fo.style.display = 'none';
				}else{
					var gname = c.value;
					document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"article_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateFolder\"><input name=\"gname\" type=\"hidden\" id=\"gname\" value=\""+ gname + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
					createform.submit();

				}
			}
</script>
</head>
<body leftmargin="0" topmargin="0">
<span id="formtext"></span>
<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#808080">
  <form name="form1" method="post" action="rss_function.php">
  <input type="hidden" name="Flag" value="DelGroup">
  <input type="hidden" name="cid" >
  <input type="hidden" name="rss_title" >
  <input type="hidden" name="rss_url" >
  <input type="hidden" name="rss_row" >

    <tr align="center" bgcolor="E0DFE3"> 
      <td width="35%" height="18" bgcolor="E0DFE3" class="head_table">RSS  Name</td>
	  <td width="35%" class="head_table">URL</td>
      <td width="10%" class="head_table">Record Show</td>
	  <td width="10%" class="head_table">Delete</td>
    </tr>
	<?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_rss)){ ?>
		<tr bgcolor="#FFFFFF"> 
		  <td height="25" valign="top" bgcolor="F7F7F7"> <a href="#article" onClick="top.location.href='rss_index.php?cid=<?php echo $G["rss_id"]; ?>';"><img src="../images/ico_rss.gif" border="0"   align="absmiddle"> <?php echo $G["rss_title"]; ?></a> </td>
			<td  align="left"><a href="#article" onClick="self.location.href='rss_edit.php?cid=<?php echo $G["rss_id"]; ?>';"><?php echo $G["rss_url"]; ?></a></td>
			<td align="center"> <?php echo $G["rss_row"]; ?></td>
			<td align="center"> <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $G["rss_id"]; ?>"> </td>
		</tr>
	<?php $i++; } ?>

    <tr bgcolor="#FFFFFF"> 
      <td valign="top" bgcolor="F7F7F7">&nbsp;<a id="#bottom"></a></td>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
