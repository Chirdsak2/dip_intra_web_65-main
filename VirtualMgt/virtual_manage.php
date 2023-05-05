<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language.php");

$sql_v = $db->query("SELECT * FROM virtual_list WHERE v_id = '".$_GET["vid"]."' ");
$R = $db->db_fetch_array($sql_v);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
		function selColor(c,d,e) {
			Win2 = window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '&c_preview1=' + e + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
		}
		function chkstatus(c){
			if(c.checked == true){
				document.form1.maxwidth.disabled = true;
			}else{
				document.form1.maxwidth.disabled = false;
			}
		}
		function chkfrm(){
			if(document.form1.v_name.value == ""){
				alert("Please insert virtual name!");
				document.form1.v_name.focus();
				return false;
			}
			if(document.form1.cid.value == ""){
				alert("Please select group!");
				window.open('virtual_select.php','','height=400,width=300,resizable=1,scrollbars=1');
				return false;
			}
		}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="99%" height="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse">
  <tr>
    <td align="center" valign="top" bgcolor="#FFFFFF"><iframe name="iframe1" src="virtual_preview.php?vid=<?php echo $_GET["vid"]; ?>" align="top" hspace="0" vspace="0" frameborder="1" scrolling="yes" style="height:100%;Width:100%;"></iframe></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>