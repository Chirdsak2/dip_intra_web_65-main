<?php 
 	session_start();
	$start_time_counter = date("YmdHis");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");

	
	$main_db = $EWT_DB_NAME;
	
	
	if(!$main_db) { // ถ้าไม่รู้ว่า จะดึงข้อมูลหน้าเว็บจาก db_name อันไหน  ให้ดีดออก
		echo "UnKnown Client Database";
		exit;
	}
	
	
	////////////////////////   connection สำหรับ W3C //////////////////////
    $path = "";
	include ($path.'include/config.inc.php');
	include ($path.'include/class_db.php');
	include ($path.'include/class_display.php');	
	include ($path.'include/class_application.php');	
	$CLASS['db']   = new db2();
    $CLASS['db']->connect ();   
	$CLASS['disp'] = new display();
    $CLASS['app'] = new application();   
		   
	$db2   = $CLASS['db'];
    $disp = $CLASS['disp'];
	$app = $CLASS['app'];		
	
	$charac1 = $disp->convert_qoute_to_db("'");
	$charac2 = $disp->convert_qoute_to_db('"');
	
	
	$invalid = false;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $proj_title;?> - Template Selection</title>
<script type="text/javascript" language="javascript1.2" src="js/AjaxRequest.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/functions.js"></script>
<script type="text/javascript" language="javascript1.2">
function chkInput() {	
	
	if(confirm('ยืนยันการบันทึกหรือไม่')) {
		frm.accept.value = 'save';
		frm.submit();
	}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>
<?php
		$sqlList = " SELECT * FROM webpage_info WHERE  page_type = '2' AND w3c_html = 'w3c' ";
		$execList = $db2->query($sqlList);
		$i=1;
		$bgC="#B4CBF5";
?>
<body onLoad="MM_preloadImages('images/arrow_left_green.gif')">
<table width="250" border="0" cellspacing="0" cellpadding="3">
  <tr bgcolor="#3366CC" style="color:#FFFFFF">
    <td>&nbsp;</td>
    <td width="200">ชื่อ Template</td>
  </tr>
<?php while($recList = $db2->fetch_array($execList)) { 
		//$bgC=($bgC=="#B4CBF5")? "#6091EA":"#B4CBF5";
?>
  <tr >
    <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('icon_arrow','','images/arrow_left_green.gif',1)" onClick="opener.frm.useTemplate.value = '<?php echo $recList[filename];?>'; opener.frm.accept.value='loadTemplate'; opener.frm.submit(); opener.frm.bt_accept.disabled = true; window.close();"><img src="images/arrow_left_blue.gif" alt="" name="icon_arrow" width="24" height="24" border="0" ></a></td>
    <td><?php echo $recList[filename];?> </td>
  </tr>
<?php } ?>
</table>
</body>
</html>