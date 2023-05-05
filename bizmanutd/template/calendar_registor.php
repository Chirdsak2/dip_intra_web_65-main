<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	@include("language/language".$lang_sh.".php");
	
	$query =$db->query( "SELECT * FROM site_info ");
	$R=$db->db_fetch_array($query );
	$txt_website_of_name=$R[site_top];
	$txt_website_of_name1=$R[site_bottom];
	
	if($_POST[flag]=='registor_now'){
		$insert_group = "insert into cal_registor_group (cal_id,cal_unit,cal_phone_unit,cal_fax_unit,cal_registor_num) 
										values ('".$_POST[event_id]."','".$_POST[unit_registor]."','".$_POST[phone_unit_registor]."','".$_POST[fax_unit_registor]."','".$_POST[num_registor]."')";
		$db->query($insert_group);
		$sql_count = "select  max(cal_registor_group_id) as maxid from cal_registor_group";
		$query = $db->query($sql_count);
		$R = $db->db_fetch_array($query);
		for($i=0;$i<$_POST[num_registor];$i++){
		$insert = "insert  into cal_registor (cal_id,cal_registor_group_id,cal_registor_name,cal_registor_lastname,cal_registor_position,cal_registor_phone) 
							values ('".$_POST[event_id]."','".$R[maxid]."','".$_POST["name_registor".$i]."','".$_POST["lastname_registor".$i]."','".$_POST["position_registor".$i]."','".$_POST["phone_registor".$i]."')";
		$db->query($insert);
		}
		print "<script>";
		print "alert('ได้บันทึกข้อมูลของท่านเรียบร้อยแล้ว ขอบคุณที่ท่านให้ความสนใจ');";
		print "window.close();";
		print "</script>";
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/interface.css" rel="stylesheet" type="text/css">
<link href="css/normal.css" rel="stylesheet" type="text/css">
<link href="css/jquery.cluetip.css" rel="stylesheet" type="text/css">
<?php include("ewt_script.php");	 ?>
<script language="javascript1.1">
function chk_data(obj){
	if(obj.unit_registor.value==''){
	alert("กรุณาระบุชื่อหน่วยงาน");
	return false;
	}
	if(obj.phone_unit_registor.value==''){
	alert("กรุณาระบุเบอิร์โทรศัพท์ของหน่วยงานที่ติดต่อสะดวก");
	return false;
	}
	if(obj.num_registor.value==''){
	alert("กรุณาระบุจำนวนผู้เข้าร่วมกิจกรรม");
	return false;
	}
	var chk = 1;
	var chk1 = 1;
	var chk2 = 1;
	var chk3 = 1;
	var num = document.getElementById("num_registor").value;
	for(var i=0;i<num;i++){
		if(document.getElementById("name_registor"+i).value == ''){
			chk = 0;
		}
		if(document.getElementById("lastname_registor"+i).value == ''){
			chk1 = 0;
		}
		if(document.getElementById("position_registor"+i).value == ''){
			chk2 = 0;
		}
		if(document.getElementById("phone_registor"+i).value == ''){
			chk3 = 0;
		}
	}
	if(chk==0){
	alert("กรุณาระบุชื่อผู้เข้าร่วมกิจกรรม");
	return false;
	}
	if(chk1==0){
	alert("กรุณาระบุนามสกุล");
	return false;
	}
	if(chk2==0){
	alert("กรุณาระบุตำแหน่ง");
	return false;
	}
	if(chk3==0){
	alert("กรุณาระบุเบอร์โทรศัพท์");
	return false;
	}
	/*if(obj.name_registor.value==''){
	alert("กรุณาระบุชื่อ");
	return false;
	}
	if(obj.lastname_registor.value==''){
	alert("กรุณาระบุนามสกุล");
	return false;
	}
	if(obj.position_registor.value==''){
	alert("กรุณาระบุตำแหน่ง");
	return false;
	}
	if(obj.phone_registor.value==''){
	alert("กรุณาระบุเบอร์โทรศัพท์");
	return false;
	}*/
	return true;
}
function show_data_user(){

var num = document.getElementById("num_registor").value;
if(num == 0 || num == ''){
document.getElementById("tr_registor0").style.display = 'none';
document.getElementById("tr_registor1").style.display = 'none';
document.getElementById("tr_registor2").style.display = 'none';
}else{
var objDiv = document.getElementById("divcalendarregis");
			url='calendar_registor_user.php?num_row='+num;
			AjaxRequest.get({
				'url':url
				,'onLoading':function() { }
				,'onLoaded':function() { }
				,'onInteractive':function() { }
				,'onComplete':function() { }
				,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
				}
			});



document.getElementById("tr_registor0").style.display = '';
document.getElementById("tr_registor1").style.display = '';
document.getElementById("tr_registor2").style.display = '';
}

}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<form id="form1" name="form1" method="post" action="" onSubmit="return chk_data(this);">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="right"></td>
    <td height="5"></td>
    <td></td>
  </tr>
  <tr>
    <td align="right"><img src="mainpic/border_24.jpg" width="12" height="32" /></td>
    <td height="30" background="mainpic/border_25.jpg"><img src="<?php echo $path_cal;?>mainpic/icon_news.gif" border="0"   align="absmiddle">สมัครเข้าร่วมกิจกรรม</td>
    <td><img src="mainpic/border_28.jpg" width="12" height="32" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0">
      <tr>
        <td width="35%" align="right">หน่วยงาน :</td>
        <td width="65%"><input name="unit_registor" type="text" id="unit_registor"><span class="style1">*</span></td>
      </tr>
      <tr>
        <td align="right">เบอร์โทรศัพท์ : </td>
        <td width="65%"><input name="phone_unit_registor" type="text" id="phone_unit_registor"><span class="style1">*</span></td>
      </tr>
      <tr>
        <td align="right">โทรสาร :</td>
        <td width="65%"><input name="fax_unit_registor" type="text" id="fax_unit_registor"></td>
      </tr>
      <tr>
        <td align="right">จำนวนผู้เข้าร่วม : </td>
        <td width="65%"><input name="num_registor" type="text" id="num_registor" size="5" maxlength="5" onKeyUp="show_data_user();"> <span class="style1">*</span>
          คน </td>
      </tr>
	   <tr  id="tr_registor0" style="display:none">
        <td colspan="2" align="right"><hr></td>
        </tr>
      <tr id="tr_registor1" style="display:none">
        <td>รายชื่อผู้เข้าร่วม</td>
        <td width="65%">&nbsp;</td>
      </tr>
      <tr id="tr_registor2" style="display:none">
        <td colspan="2" align="right"><div id="divcalendarregis">&nbsp;</div></td>
      </tr>

    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td height="44" align="center" valign="bottom"><input name="submit" type="submit" id="submit" value="สมัครเข้าร่วม" />
    <input type="hidden" name="flag"  value="registor_now"><input type="hidden" name="event_id"  value="<?php echo $_GET[event_id];?>"></td>
    <td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="44" align="center" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="bottom"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="bottom"><?php echo $txt_website_of_name1;?></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
</body>
</html>
