<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($_POST["Flag"] == "MoveArticle"){
					if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp")) {
						@mkdir("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp",0700);
					}
$sql = $db->query("SELECT * FROM article_list WHERE c_id = '".$_POST["cid"]."' AND news_use = '1' ");
while($R=$db->db_fetch_array($sql)){
	if((file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/".$R["link_html"])) AND $R["link_html"] != ""){
	
			$myfile = "tmp".$_SESSION["EWT_SMID"]."A".$R["n_id"]."O".date("YmdHis").".tmp";	
			$myname = basename ("../ewt/".$_SESSION["EWT_SUSER"]."/".$R["link_html"]);
			$mysize = filesize("../ewt/".$_SESSION["EWT_SUSER"]."/".$R["link_html"]);
			$mytype = "application/x-www-form-urlencoded";
			
			copy("../ewt/".$_SESSION["EWT_SUSER"]."/".$R["link_html"],"../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$myfile);
			@chmod ("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$myfile, 0777);
			
			$db->query("INSERT INTO download_list (dl_name,dl_userfile,dl_sysfile,dl_filetype,dl_filesize,dl_gid) VALUES ('','".$myname."','".$myfile."','".$mytype."','".$mysize."','".$R["n_id"]."')");
	$db->query("UPDATE article_list SET news_use = '4',show_count = '2' WHERE n_id = '".$R["n_id"]."' ");
	}
}
?>
<script language="javascript">
self.location.href="article_move.php";
</script>
<?php
exit;
}
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
.style1 {color: #FF0000}
-->
</style>
<script language="JavaScript">
function chk(){
		if(document.form1.cid.value == ""){
		alert("Please choose group!");
		win2 = window.open('article_select.php?cid=<?php echo $_GET["cid"]; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');win2.focus();
		return false;
	}
}

</script>

</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">แก้ไขข่าว/บทความ=>Download</span></td>
  </tr>
</table>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="1"  class="ewttableuse">
  <form action="article_move.php" method="post"  name="form1" onSubmit="return chk();">
          <tr valign="top" > 
            <td colspan="2" class="ewttablehead">&nbsp;</td>
          </tr>
          
          <tr valign="top"> 
            <td width="26%" bgcolor="#FFFFFF">หมวด : </td>
            <td width="74%" bgcolor="#FFFFFF"><span id="txtshow"><?php echo $G[c_name]; ?></span>
        <a href="#browse" title="เลือกกลุ่ม" onClick="win2 = window.open('article_select.php?cid=<?php echo $_GET["cid"]; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');win2.focus();"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle" ></a> 
        <input name="cid" type="hidden" id="cid" value=""> </td>
          </tr>
          <tr valign="top"> 
            <td bgcolor="#FFFFFF">&nbsp;</td>
            <td bgcolor="#FFFFFF"><input type="submit" name="Submit" value="Submit"> 
              <input type="reset" name="Submit2" value="Reset"> <input name="Flag" type="hidden" id="Flag" value="MoveArticle"></td>
          </tr></form>
</table>
        <br>
</body>
</html>
<?php
 	$db->db_close(); ?>
