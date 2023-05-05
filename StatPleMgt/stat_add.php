<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");
if($_GET["flag"] == 'add'){
	$lable = 'เพิ่ม';
	$datem = date("m");
	$datey = date("Y");
}else if($_GET["flag"] == 'edit'){
	$lable = 'แก้ไข';
	$sql_banner = "SELECT * FROM stat_population where p_id ='".$_GET["p_id"]."'";
	$rec = $db->db_fetch_array($db->query($sql_banner));
	$date_e = explode('-',$rec[p_date]);
	//$ndate = $date_e[2].'/'.$date_e[1].'/'.($date_e[0]+543);
	$datem = $date_e[1];
	$datey = $date_e[0];
}

function convert_datedb2($date){ 
			$mont =  array("1"=>"มกราคม","2"=>"กุมภาพันธ์","3"=>"มีนาคม","4"=>"เมษายน","5"=>"พฤษภาคม","6"=>"มิถุนายน", "7"=>"กรกฎาคม","8"=>"สิงหาคม","9"=>"กันยายน","10"=>"ตุลาคม",
							"11"=>"พฤศจิกายน","12"=>"ธันวาคม");
			
			if($date){
				/*$arr = explode("-",$date);
				$month=$mont[(($arr[1]*1))];
				$date = ($month.' '.($arr[0]+543));*/
				
				return $mont[$date];
			}//if
		}//fuction
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
</head>
<script src="../js/jquery.min.js"></script>
<script language="javascript1.2">
	function CHK(t){
		if(t.datem.value == ''){
			alert("กรุณาเลือกเดือน!");
			return false;
		}
		
		if(t.datey.value == ''){
			alert("กรุณาเลือกปี!");
			return false;
		}
		
		if(t.datem.value != '' && t.datey.value != ''){
			$.get("stat_ckedate.php",{
				 dates:t.datey.value+"-"+t.datem.value,pid:t.p_id.value
			 },function(data){ 
				if(data!=""){
					alert("เดือนนี้อยู่ในระบบแล้ว!");
					//t.dates.focus();
					return false;
				}else{
					if(t.n1.value == ''){
						alert("กรุณากรอกจำนวนคนไทย!");
						t.n1.focus();
						return false;
					}else{
						/*if(isNaN(t.n1.value)){
							alert('กรุณากรอกตัวเลขเท่านั้น');
							t.n1.focus();
							return false;
						}*/
					}
					if(t.n2.value == ''){
						alert("กรุณากรอกจำนวนคนต่างชาติ!");
						t.n2.focus();
						return false;
					}else{
						/*if(isNaN(t.n2.value)){
							alert('กรุณากรอกตัวเลขเท่านั้น');
							t.n2.focus();
							return false;
						}*/
					}
					$("#form1").attr("action","stat_process.php").submit();
				}
			});
			
		}
		
	}
</script>
<body leftmargin="0" topmargin="0">
<form name="form1" id="form1" method="post">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/banner_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">ข้อมูลสถิตินักท่องเที่ยว</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"> <a href="main_stat_index.php" target="_self"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php echo $text_genbanner_manage;?></a>
      <hr>
    </td>
  </tr>
</table>
  <table width="30%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999"  class="ewttableuse">
  <tr>
    <th height="23" colspan="2" class="ewttablehead"  scope="col"><div align="left"><?php echo $lable;?>สถิตินักท่องเที่ยว </div></th>
  </tr>
  <tr>
    <td width="30%" height="23" bgcolor="#FFFFFF">เดือน/ปี<font style="color:#FF0000"> *</font></td>
    <td width="" height="23" bgcolor="#FFFFFF"> 
	<select name="datem" id="datem">
		<option class="center" value="">-- เลือกเดือน --</option>
		<?php 
			for($j=1;$j<=12;$j++){
				if($j==$datem){
					echo '<option value="'.$j.'" selected>'.convert_datedb2($j).'</option>';
				}else{
					echo '<option value="'.$j.'">'.convert_datedb2($j).'</option>';
				}
			}
		?>
	</select>
	/ 
	<select name="datey" id="datey">
		<option class="center" value="">-- เลือกปี --</option>
		<?php 
			for($j=(date("Y")-3);$j<=(date("Y")+3);$j++){
				if($j==$datey){
					echo '<option value="'.$j.'" selected>'.($j+543).'</option>';
				}else{
					echo '<option value="'.$j.'">'.($j+543).'</option>';
				}
			}
		?>
	</select>
	</td>
  </tr>
  <tr>
    <td height="23" bgcolor="#FFFFFF">คนไทย <font style="color:#FF0000"> *</font></td>
    <td bgcolor="#FFFFFF"> <input name="n1" id="n1" type="text" size="15" value="<?php echo $rec[p_nthai];?>"></td>
  </tr>
  <tr>
    <td height="23" bgcolor="#FFFFFF">คนต่างชาติ <font style="color:#FF0000"> *</font></td>
    <td bgcolor="#FFFFFF"> <input name="n2" id="n2" type="text" size="15" value="<?php echo $rec[p_nother];?>"></td>
  </tr>
  <tr>
    <td height="23" bgcolor="#FFFFFF"></td>
    <td height="23" bgcolor="#FFFFFF"><label>
      <input type="button" name="Submit" onclick="CHK(document.form1);" value="<?php echo $text_genbanner_formupdate;?>">
&nbsp;&nbsp; </label>
      <input type="hidden" name="flag" value="<?php echo $_GET["flag"];?>">
	  <input type="hidden" name="p_id" value="<?php echo $_GET[p_id]?>">
      </label></td>
  </tr>
</table>
<table width="90%" border="0" align="center">
  <tr>
    <th scope="col"><br>
      </th>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>
