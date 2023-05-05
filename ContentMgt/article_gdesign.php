<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name,block_link FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_row($sql_file);
$type = explode('#',$R[1]);
$show_type = $type[0];
$show_marquee = $type[1];
$time_marquee = $type[2];
$show_nextdata = $type[3];
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script  language="javascript1.1" type="text/javascript">
function isNum (charCode) {
	if (charCode >= 48 && charCode <= 57 ) return true;
	else return false;
}
function chkFormatNam (str) {//0-9
	strlen = str.length;
	for (i=0;i<strlen;i++) {
		var charCode = str.charCodeAt(i);
		if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
			return false;
		}
	}
	return true;
}
function chkformatnum(t) { 
	_MyObj = t;
	_MyObj_Name = t.name;
	_MyObj_Value = t.value;
	_MyObj_Strlen =_MyObj_Value.length; 
	if( _MyObj_Strlen >1 && _MyObj_Value.substr(0,1)==0){
		t.value = _MyObj_Value.substr(1);
	}
	if(!chkFormatNam (t.value)){
		alert('กรุณากรอกตัวเลขเท่านั้น');
		t.value = 0;
		t.focus();
	} 
}
</script>

</head>
<body leftmargin="0" topmargin="0">
 <!--<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
   <form name="form1" method="post" action="article_function.php"><tr>
      <td bgcolor="#FFFFFF"> <strong>ตั้งค่าการแสดง</strong><br>
     
       <input type="radio" name="show_type" value="" <?php if($show_type == ""){ echo "checked"; } ?>>
        ทั่วไป<br>
        <input type="radio" name="show_type" value="1"  <?php if($show_type == "1"){ echo "checked"; } ?>>
        แสดงเป็นกลุ่มแบบที่ 1<br>
		<input type="radio" name="show_type" value="2"  <?php if($show_type == "2"){ echo "checked"; } ?>>
        แสดงเป็นกลุ่มแบบที่ 2 <br>
		<input type="radio" name="show_type" value="3"  <?php if($show_type == "3"){ echo "checked"; } ?>>
        แสดงเป็นกลุ่มแบบที่ 3 <br>
		<input type="radio" name="show_type" value="4"  <?php if($show_type == "4"){ echo "checked"; } ?>>
        แสดงเป็น 2 คอลัมน์ <br>
		<input type="radio" name="show_type" value="9"  <?php if($show_type == "9"){ echo "checked"; } ?>>
        แสดงเป็น 3 คอลัมน์ <br>
		<input type="radio" name="show_type" value="5"  <?php if($show_type == "5"){ echo "checked"; } ?>>
        แสดงเป็น Slide Show(แบบทีละ 1 ข่าว)<br>
		<input type="radio" name="show_type" value="6"  <?php if($show_type == "6"){ echo "checked"; } ?>>
        แสดงเป็น Slide Show(แบบแสดง 1 หมวด ทีละ 3 ข่าว)<br>    
		<input type="radio" name="show_type" value="7"  <?php if($show_type == "7"){ echo "checked"; } ?>>
        แสดงเป็น Slide Show(แสดงเฉพาะหมวดทีละ 3 หมวด)<br>   
		<input type="radio" name="show_type" value="8"  <?php if($show_type == "8"){ echo "checked"; } ?>>
        แสดงเป็นคอลัมน์โดยให้ข่าวแรกเด่น(เปลี่ยนรูปแรกอัตโนมัติ)<br>  
		<input type="radio" name="show_type" value="11"  <?php if($show_type == "11"){ echo "checked"; } ?>>
        แสดงเป็นคอลัมน์โดยให้ข่าวแรกเด่น<br> 
		<input type="radio" name="show_type" value="10"  <?php if($show_type == "10"){ echo "checked"; } ?>>
       เปลี่ยนรูปรายละเอียดข่าวแรกอัตโนมัติ<br>
        <input type="submit" name="Submit" value="Submit">
        <input name="Flag" type="hidden" id="Flag" value="SetDisp">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>"></td>
  </tr></form> 
</table>-->
<form name="form1" method="post" action="article_function.php">
<table width="100%" border="0">
<tr>
      <td bgcolor="#FFFFFF" colspan="2"> <strong>ชื่อ Block</strong></td>
</tr>
<tr>
      <td bgcolor="#FFFFFF" colspan="2"> <table cellpadding="0" cellspacing="0" width="100%">
      	<tr>
        	<td width="30">ชื่อ : </td>
          <td><input type="text" name="block_name" id="block_name" value="<?php echo $R[0]; ?>" /></td>
        </tr>
      </table></td>
</tr>
<tr>
      <td bgcolor="#FFFFFF" colspan="2"> <strong>ตั้งค่าการแสดง</strong></td>
</tr>
  <tr>
    <td width="50%"><input type="radio" name="show_type" value="" <?php if($show_type == ""){ echo "checked"; } ?>>
        ทั่วไป</td>
    <td width="50%"><input type="radio" name="show_type" value="5"  <?php if($show_type == "5"){ echo "checked"; } ?>>
แสดงเป็น Slide Show(แบบทีละ 1 ข่าว)
<br>
<font  color="#FF0000"><span style="size:9px">(ไม่สามารถใช้#ตั้งค่าเพิ่มเติมได้)</span></font></td>
  </tr>
  <tr>
    <td><img src="../images/article_s/1.jpg" width="170" height="106"></td>
    <td><img src="../images/article_s/7.gif" width="170" height="106"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="show_type" value="1"  <?php if($show_type == "1"){ echo "checked"; } ?>>
แสดงเป็นกลุ่มแบบที่ 1 </td>
    <td><input type="radio" name="show_type" value="6"  <?php if($show_type == "6"){ echo "checked"; } ?>>
แสดงเป็น Slide Show(แบบแสดง 1 หมวด ทีละ 3 แถว)<br>
<font  color="#FF0000"><span style="size:9px">(ไม่สามารถใช้#ตั้งค่าเพิ่มเติมได้)</span></font></td>
  </tr>
  <tr>
    <td><img src="../images/article_s/2.jpg" width="170" height="106"></td>
    <td><img src="../images/article_s/9.gif" width="170" height="106"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="show_type" value="2"  <?php if($show_type == "2"){ echo "checked"; } ?>>
แสดงเป็นกลุ่มแบบที่ 2 </td>
    <td><input type="radio" name="show_type" value="7"  <?php if($show_type == "7"){ echo "checked"; } ?>>
แสดงเป็น Slide Show(แสดงเฉพาะหมวดทีละ 3 หมวด)<br>
<font  color="#FF0000"><span style="size:9px">(ไม่สามารถใช้#ตั้งค่าเพิ่มเติมได้)</span></font></td>
  </tr>
  <tr>
    <td><img src="../images/article_s/3.jpg" width="170" height="106"></td>
    <td><img src="../images/article_s/8.gif" width="170" height="106"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="show_type" value="3"  <?php if($show_type == "3"){ echo "checked"; } ?>>
แสดงเป็นกลุ่มแบบที่ 3 </td>
    <td><input type="radio" name="show_type" value="8"  <?php if($show_type == "8"){ echo "checked"; } ?>>
แสดงเป็นคอลัมน์โดยให้ข่าวแรกเด่น(เปลี่ยนรูปแรกอัตโนมัติ)</td>
  </tr>
  <tr>
    <td><img src="../images/article_s/4.jpg" width="170" height="106"></td>
    <td><img src="../images/article_s/10.jpg" width="170" height="106"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="show_type" value="4"  <?php if($show_type == "4"){ echo "checked"; } ?>>
แสดงเป็น 2 คอลัมน์ </td>
    <td><input type="radio" name="show_type" value="11"  <?php if($show_type == "11"){ echo "checked"; } ?>>
แสดงเป็นคอลัมน์โดยให้ข่าวแรกเด่น</td>
  </tr>
  <tr>
    <td><img src="../images/article_s/5.jpg" width="170" height="106"></td>
    <td><img src="../images/article_s/11.jpg" width="170" height="106"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="show_type" value="9"  <?php if($show_type == "9"){ echo "checked"; } ?>>
แสดงเป็น 3 คอลัมน์ </td>
    <td><input type="radio" name="show_type" value="10"  <?php if($show_type == "10"){ echo "checked"; } ?>>
เปลี่ยนรูปรายละเอียดข่าวแรกอัตโนมัติ</td>
  </tr>
  <tr>
    <td><img src="../images/article_s/6.jpg" width="170" height="106"></td>
    <td><img src="../images/article_s/12.jpg" width="170" height="106"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="show_type" value="12"  <?php if($show_type == "12"){ echo "checked"; } ?>> 
      แสดง 1 คอลัมน์ โดยรูปประกอบข่าวอยู่ใต้หัวข้อข่าว </td>
    <td><input type="radio" name="show_type" value="13"  <?php if($show_type == "13"){ echo "checked"; } ?>> 
      แสดงข่าวแบบแถวเดียว(เฉพาะหัวข้อข่าว)<br>
      <font  color="#FF0000"><span style="size:9px">(ไม่สามารถใช้#ตั้งค่าเพิ่มเติมlink อ่านข่าวถัดไปได้ )</span></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="show_type" value="14"  <?php if($show_type == "14"){ echo "checked"; } ?>> 
     แสดงข่าวแบบแถวเดียว โดยรูปประกอบข่าวอยู่ใต้หัวข้อข่าว<br>
      <font  color="#FF0000"><span style="size:9px">(ไม่สามารถใช้#ตั้งค่าเพิ่มเติมlink อ่านข่าวถัดไปได้ )</span></font></td>
    <td><input type="radio" name="show_type" value="15"  <?php if($show_type == "15"){ echo "checked"; } ?>> 
     แสดงข่าวแบบ Random เป็น 3 Tab <br><font  color="#FF0000"><span style="size:9px">(ไม่สามารถใช้#ตั้งค่าเพิ่มเติมได้)</span></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="show_type" value="16"  <?php if($show_type == "16"){ echo "checked"; } ?>> 
     แสดงข่าวแบบ 2 คอลัมน์ โดยอยู่หมวดข่าวเดียวกัน รูปประกอบด้านซ้าย</td>
    <td><input type="radio" name="show_type" value="17"  <?php if($show_type == "17"){ echo "checked"; } ?>> 
     แสดงข่าวแบบ 2 คอลัมน์ โดยอยู่หมวดข่าวเดียวกัน รูปประกอบด้านบน</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>#ตั้งค่าเพิ่มเติม : </strong></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="show_nextdata" value="Y" <?php if($show_nextdata == "Y"){ echo "checked"; } ?>> 
      ต้องการแสดง link อ่านข่าวถัดไป </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><hr></td>
    </tr>
  <tr>
    <td colspan="2"><strong>#ตั้งค่าเพิ่มเติม : การแสดงผลของการเลื่อนการแสดงผล(marquee) </strong></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="show_marquee" type="radio" value="" <?php if($show_marquee == ""){ echo "checked"; } ?>> 
      ไม่แสดงผล </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="show_marquee" type="radio" value="B" <?php if($show_marquee == "B"){ echo "checked"; } ?>>      
 เลื่อนแนวตั้ง(วิ่งลง) </td>
    <td><input name="show_marquee" type="radio" value="A" <?php if($show_marquee == "A"){ echo "checked"; } ?>>
เลื่อนแนวตั้ง(วิ่งขึ้น) </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="show_marquee" type="radio" value="D" <?php if($show_marquee == "D"){ echo "checked"; } ?>>
 เลื่อนแนวนอน(วิ่งจากซ้ายไปขวา) </td>
    <td><input name="show_marquee" type="radio" value="C" <?php if($show_marquee == "C"){ echo "checked"; } ?>>
เลื่อนแนวนอน(วิ่งจากขวาไปซ้าย) </td>
  </tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>#ตั้งค่าเพิ่มเติม : ความเร็วของการเลื่อนการแสดงผล(marquee) </strong></td>
    </tr>
  <tr>
    <td>ความเร็ว : 
      <input name="time_marquee" type="text" size="7" value="<?php echo $time_marquee;?>" onKeyUp="chkformatnum(this)" >
      (กรุณาระบุตัวเลขตั้งแต่ 1 ขึ้นไป)</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="Submit" value="Submit">
        <input name="Flag" type="hidden" id="Flag" value="SetDisp">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>"></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
</body>
</html>
<?php } ?>
<?php $db->db_close(); ?>
