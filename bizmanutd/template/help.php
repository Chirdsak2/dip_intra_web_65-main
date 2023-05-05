<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>help</title>
<link href="css/interface.css" rel="stylesheet" type="text/css">
<script src="js/AjaxRequest.js"></script>
<script language="javascript1.2">
function select_page(obj){
	if(obj=='2'){
	document.getElementById("td2" ).style.background="url(mainpic/bg_on.gif)";
	document.getElementById("td1" ).style.background="url(mainpic/bg_off.gif)";
	 help_list.window.location.href='tooltips_list.php?page=<?php echo $_GET[page];?>';
	  txt_data('<?php echo $_GET[page];?>');
	}else if(obj=='1'){
	document.getElementById("td2" ).style.background="url(mainpic/bg_off.gif)";
	document.getElementById("td1" ).style.background="url(mainpic/bg_on.gif)";
	help_list.window.location.href='tooltips_list.php';
	 txt_data('');
	}
}
function txt_data(p) {
	var objDiv = document.getElementById("help_detail");
	url='ewt_about.php?flag=tips_list&page='+p;
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
function show_detailsub(tid,gid) {
	var objDiv = window.self.document.getElementById("help_detail");
	url='ewt_about.php?flag=tips&tips_id='+tid+'&gtips_id='+gid;
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
</script>
</head>
<body  leftmargin="0" topmargin="0">
<form name="form1" method="post" action="">
  <input type="hidden" name="hdd_page" value="<?php echo $_GET[page];?>">
</form>
<table width="100%"  height="100%" border="0" bgcolor="#CCCCCC">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td id="td1"  align="center" background="mainpic/bg_off.gif"  class="text_normal" onClick="select_page('1');" style="cursor:hand">HOME</td>
	<td id="td2"  width="44" align="center" background="mainpic/bg_on.gif"  class="text_normal" onClick="select_page('2');" style="cursor:hand">PAGE</td>
    <td width="190">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td colspan="3" align="center"  class="text_normal"><iframe id="help_list" src="" scrolling="1"  height="550"></iframe></td>
	<td width="77%"><div id="help_detail" style="height:550px;width:480px; z-index:1; overflow:auto"></div></td>
  </tr>
</table>
</body>
</html>
<script language="javascript1.2">
 txt_data();
 <?php if($_GET[page]!=''){ ?>
 select_page('2');
 <?php }else{ ?>
  select_page('1');
 <?php } ?>
</script>
<?php $db->db_close(); ?>
