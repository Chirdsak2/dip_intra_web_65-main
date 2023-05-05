<?php
session_start();
header ("Content-Type:text/html;Charset=WINDOW-874");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

					$gc_name = "";
				  if($_POST["gc_id"]){
						$sql= "SELECT * FROM guest_cate WHERE gc_id = '".$_POST["gc_id"]."' ";
						$rec_gc = $db->db_fetch_array($db->query($sql));
						$gc_name = $rec_gc["gc_name"];
					}
					
$path_cal = "";
@include("language/language.php");
$check_data=$_REQUEST['check_data'];
$comment_guest=$_REQUEST['comment_guest'];
$name_guest=$_REQUEST['name_guest'];
$unit=$_REQUEST['unit'];
$email=$_REQUEST['email'];

$query =$db->query( "SELECT * FROM site_info ");
$R=$db->db_fetch_array($query );
$txt_website_of_name=$R[site_top];
$txt_website_of_name1=$R[site_bottom];

if($name_guest == '' && $_SESSION["EWT_MID"] != ''){$name_guest = $_SESSION["EWT_NAME"];}
 function chg_date_th ($date_input)
{
	   $date = substr($date_input,8,2);
	   $mont= substr($date_input,5,2);
	   $year_en = substr($date_input,0,4);
	   $year=$year_en+543;

	   return $date."/".$mont."/".$year;
}

//#####################replace *** to word  #########################
$sql_vul = " SELECT * FROM vulgar_table ";
$query_vul = mysql_query($sql_vul);
$num_vul  = mysql_num_rows($query_vul);
for($i=1;$i<=$num_vul;$i++){
		$rec = mysql_fetch_array($query_vul);
		$vulels[$i] = $rec['vulgar_text'];		
}
//##############################################################
$chk_config = mysql_query("SELECT * FROM guest_config ");
$CO = mysql_fetch_array($chk_config);
$message = explode(',',$CO["guest_config_message"]);

//#########################    Chack Date < guest_config_date ########
$d = date(d) - $CO['guest_config_date'];
$m = date(m);
$y = date(Y);
$today = $y."-".$m."-".date(d);
$chk_date=  date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));
//###############################################################


$sel = "SELECT * FROM guestbook_list  WHERE  status_guest = 'Y' ORDER BY id_guest DESC";//date_guest BETWEEN '$chk_date' AND ' $today' AND

   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = $CO[guest_config_page];

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = mysql_query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = mysql_query($Show); 

if($check_data != 'yes'){ 
			$yes_chk = 'guestbook.php?check_data=yes'; 
			$indata = 'text';
			$diapl = 'none';
			$no_chk = "self.location.href='$HTTP_REFERER';document.frm1.name_guest.value='';document.frm1.comment_guest.value=''; ";
			if(!empty($name_guest))$name_guest = stripslashes(htmlspecialchars($name_guest ,ENT_QUOTES));
			if(!empty($comment_guest))$comment_guest = stripslashes(htmlspecialchars($comment_guest ,ENT_QUOTES));
			
}else if($check_data == 'yes'){ //method การยืนยัน		
			$name_guest = stripslashes(htmlspecialchars($name_guest,ENT_QUOTES));
			$comment_guest = stripslashes(htmlspecialchars($comment_guest,ENT_QUOTES));
			$email = stripslashes(htmlspecialchars($email ,ENT_QUOTES));
			$unit = stripslashes(htmlspecialchars($unit,ENT_QUOTES));
			$name_guest1= $name_guest;
			$comment_guest1 = $comment_guest;
			$sql_vul = " SELECT * FROM vulgar_table ";
			$query_vul = mysql_query($sql_vul);
			$num_vul  = mysql_num_rows($query_vul);
			for($chk=1;$chk<=$num_vul;$chk++){
					$rec = mysql_fetch_array($query_vul);
					$chk_vulels = $rec['vulgar_text'];							
					
					if(eregi($chk_vulels,$name_guest1)){
							$chk_vulgar = 'Y';
					}
					if(eregi($chk_vulels,$comment_guest1)){
							$chk_vulgar = 'Y';
					}
					if(eregi($chk_vulels,$unit)){
							$chk_vulgar = 'Y';
					}
					if(eregi($chk_vulels,$provice_ctry)){
							$chk_vulgar = 'Y';
					}
					$name_guest   = eregi_replace($chk_vulels, "<font style=background-color:red>".$chk_vulels."</font>",$name_guest);
					$comment_guest  = eregi_replace($chk_vulels, "<font style=background-color:red>".$chk_vulels."</font>",$comment_guest);
					
					unset($chk_vulels);
					if($chk_vulgar == 'Y'){
					$lable = "ข้อความของคุณ<font color=\"red\">มี</font>ข้อความไม่สุภาพ กรุณาแก้ไขให้ถูกต้อง";
					
					
					}else{
					$lable = "ข้อความของคุณ<font color=\"red\">ไม่มี</font>ข้อความไม่สุภาพ ถ้าต้องการทำรายการต่อกรุณากดยืนยัน";
					
					
					}
			}					
			$text_genguestbook_cancle = "กลับไปแก้ไขข้อความ";
			$yes_chk="guestbook_function.php?name_guest=$name_guest"; 
			$indata = 'hidden';
			$diapl = '';
			$name_guest_print   = $name_guest;
			$comment_guest_print  = $comment_guest;
			//##############################################################<br>
			//$no_chk = "document.frm1.action='$HTTP_REFERER'";
			$no_chk = "document.frm1.action='?check_data=no'";
			//$no_chk= "document.frm1.action='../thailand/main.php?filename=index';this.frm1.name_guest.value='$name_guest';this.frm1.comment_guest.value='$comment_guest'; ";
} 
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
.style1 {
	color: #000000;
	font-weight: bold;
}
.style3 {color: #FFFFFF}
.style7 {font-size: 10}
-->
</style>

<script language="javascript1.2" type="text/javascript">
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
}
function valid2EMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			//return false;
			if (mailObj.value.search("^.+@.+\\..+$") != -1)
				return true;
			else return false;
 		}
		return true;
}
function validEMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			//return false;
			if (mailObj.value.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
				return true;
			else return false;
 		}
		return true;
}
function chk_input(){


		if(document.frm1.comment_guest.value == '' && document.frm1.title_show.value == ''){
				alert('กรุณาเขียนข้อความหรือเลือกข้อความคิดเห็น!!!!!!');
				return false;
		}
		if(document.frm1.name_guest.value == ''){
				alert('กรุณาระบุชื่อผู้ลงนาม!!!!!');
				return false;
		}
		
		if(document.frm1.email.value != '' && !validEMail(document.frm1.email)){
				alert('กรุณาระบุ e-mail ให้ถูกต้อง!!!!!');
				return false;
		}else{
				document.getElementById('previewDiv').style.display ='' ; 
				document.frm1.action='<?php echo $yes_chk?>';
		}
}

function markMe() {
	setVals();
	markID = setInterval("Refresh()", refresh);
}
function setVals() {
	innerWidth = document.body.clientWidth;
	innerHeight = document.body.clientHeight;
	posX = (innerWidth - width) * (x/100);
	posY = (innerHeight - height) * (y/100);
}
function Refresh() {
	marklogo.left = posX + document.body.scrollLeft;
	marklogo.top = posY + document.body.scrollTop;
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<div id="previewDiv" style="position:absolute; display:none" align="center">
	  <table width="780" height="680"  border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" >
        <tr>
          <td align="center" bgcolor="#FFFFFF"><img src="mainpic/loading.gif" /></td>
        </tr>
      </table></div>
<table width="100%"  border="0" align="center" cellpadding="1" cellspacing="0">
  <form name="frm1" action="" method="post">

<tr>
  <td  align='center' vAlign='top'   bgcolor="#FFFFFF" ><table width="778" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center"><TABLE width=634 border=0 cellPadding=0 cellSpacing=0 class="styleMe">
        <TBODY>
          <TR>
            <TD width=1></TD>
            <TD vAlign=bottom width=14><IMG height=16 
                        src="mainpic/guestbook/hi_box_ci1.gif" 
                        width=14></TD>
            <TD vAlign=bottom colSpan=3 height=16><img 
                        src="mainpic/guestbook/hi_box_ci2.gif" 
                        width=634></TD>
            <TD vAlign=bottom width=10><IMG height=16 
                        src="mainpic/guestbook/hi_box_ci3.gif" 
                        width=12></TD>
            <TD width=12></TD>
          </TR>
          <TR>
            <TD width=1></TD>
            <TD width=14 
                      background=mainpic/guestbook/hi_box_ci4_bg.gif></TD>
            <TD vAlign=top bgColor=#f6f6f6 colSpan=3><TABLE cellSpacing=0 cellPadding=0 width=597 border=0>
                <TBODY>
                  <TR>
                    <TD vAlign=top width=209 height=143><IMG 
                              height="136" 
                              src="mainpic/guestbook/<?php if($CO["guest_config_img"] != ''){echo $CO["guest_config_img"]; }else{echo "pic_service2.jpg";}?>" 
                              width="206"></TD>
                    <TD width="8"></TD>
                    <TD vAlign=top width="380"><?php echo nl2br($CO["guest_config_message"]);?></TD>
                  </TR>
                </TBODY>
            </TABLE></TD>
            <TD width=10 
                      background=mainpic/guestbook/hi_box_ci5_bg.gif></TD>
            <TD width=12></TD>
          </TR>
          <TR>
            <TD width=1></TD>
            <TD vAlign=top width=14><IMG height=16 
                        src="mainpic/guestbook/hi_box_ci6.gif" 
                        width=14></TD>
            <TD vAlign=top colSpan=3><IMG height=16 
                        src="mainpic/guestbook/hi_box_ci7.gif" 
                        width=634></TD>
            <TD vAlign=top width=10><IMG height=16 
                        src="mainpic/guestbook/hi_box_ci8.gif" 
                        width=12></TD>
            <TD width=12></TD>
          </TR>
          <TR>
            <TD width=1></TD>
            <TD vAlign=top width=14></TD>
            <TD vAlign=center colSpan=3><DIV align=left><FONT face="MS Sans Serif" color=#003366 
                        size=2><STRONG>Sign Guest Book ( ลงนามสมุดเยี่ยม 
              )</STRONG></FONT></DIV></TD>
            <TD vAlign=top width=10></TD>
            <TD width=12></TD>
          </TR>
          <TR>
            <TD></TD>
            <TD vAlign=top></TD>
            <TD vAlign=center colSpan=3></TD>
            <TD vAlign=top></TD>
            <TD></TD>
          </TR>
          <TR>
            <TD width=1></TD>
            <TD vAlign=top width=14></TD>
            <TD vAlign=top colSpan=3><?php if($check_data == 'yes'){ ?><table  width="80%" border="0" align="center" cellpadding="1" cellspacing="1" >
			<tr  bgcolor="#FFFFFF">
                  <td height="25" colspan="2" class="styleMe">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#003366"><strong><ol>ระบบตรวจสอบข้อความ <br>
                  <?php echo $lable;?>
                  </ol></strong></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  </tr>
				  <tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe">หัวข้อ&nbsp; : &nbsp;&nbsp;</td>
                  <td width="65%" align="left" valign="top" class="styleMe"> <?php echo $gc_name?><input name="title_message" type="<?php echo $indata?>" value="<?php echo $title_show?>">
				  <input type="hidden" name="title_message" value="<?php echo $title_show; ?>">
				  <input type="hidden" name="gc_id" value="<?php echo $_POST["gc_id"]; ?>">
				  </td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe"><?php echo $text_genguestbook_select1;?>&nbsp; : &nbsp;&nbsp;</td>
                  <td width="65%" align="left" valign="top" class="styleMe"> <?php echo $comment_guest?><input name="comment_guest" type="<?php echo $indata?>" value="<?php echo $comment_guest1?>">
				  <input type="hidden" name="title_message" value="<?php echo $title_show; ?>"></td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td height="25" colspan="2" class="styleMe">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#003366"><strong><ol>ข้อมูลผู้เข้าเยี่ยมชม</ol></strong></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                <tr  bgcolor="#FFFFFF">
                  <td width="35%" align="right" bgcolor="#FFFFFF" class="styleMe"><?php echo $text_genguestbook_person;?>&nbsp; : &nbsp;&nbsp; </td>
                  <td width="65%" align="left" valign="top" class="styleMe">
                      <?php if($check_data == 'yes')  print $name_guest_print; ?>
                      <input name="name_guest" type="<?php echo $indata?>" class="cadweb2007"  value="<?php echo $name_guest_print?>"></td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe"><?php echo $text_genguestbook_unit;?>&nbsp; : &nbsp;&nbsp;</td>
                  <td width="65%" align="left" valign="top" class="styleMe"><?php echo $unit;?><input name="unit" type="hidden" value="<?php echo $unit;?>"></td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe"><?php echo $text_genguestbook_email;?>&nbsp; : &nbsp;&nbsp; </td>
                  <td width="65%" align="left" valign="top" class="styleMe style1"><?php if($check_data != 'yes') {?>
                      <input name="email" type="text">
                      <?php }else{ ?>
                      <?php echo $email?>
                      <input name="email" type="hidden"  value="<?php echo $email?>">
                    &nbsp;
                    <?php } ?>                  </td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe">&nbsp;</td>
                  <td width="65%" align="left" valign="top" class="styleMe style1">&nbsp;</td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="center" valign="top" colspan="2">
                    <input name="submit" type="submit" class="cadweb2007" onClick="<?php if($chk_vulgar == 'Y'){echo "alert('".$text_genguestbook_alertsubmit."');return false;";}else{ echo 'return chk_input()';}?>" value="&nbsp;&nbsp;<?php if($check_data == 'yes'){echo $text_genguestbook_valueconf;}else{echo $text_genguestbook_valueok;}?>&nbsp;&nbsp;">
                    &nbsp;&nbsp;
                    <input name="cancle" type="submit" class="cadweb2007" onClick="<?php echo $no_chk?>" value="&nbsp;&nbsp;<?php echo $text_genguestbook_cancle;?>&nbsp;&nbsp;">                  </td>
                </tr>
            </table>
            <?php  }else{ ?><table  width="80%" border="0" align="center" cellpadding="1" cellspacing="1" >
			<tr  bgcolor="#FFFFFF">
                  <td height="25" colspan="2" class="styleMe">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#003366" ><strong><ol>แสดงความคิดเห็นโดยเลือกอย่างใดอย่างหนึ่ง</ol></strong></font>&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe"> <?php echo $text_genguestbook_comment;?>&nbsp; : &nbsp;&nbsp;</td>
                  <td width="65%" align="left" valign="top" class="styleMe">
                    <select name="gc_id" >
                      <option value=""><?php echo $text_genguestbook_option0;?></option>
                      <?php 
					  $sql = "SELECT * FROM guest_cate";
					  $query = $db->query($sql);
					  while($rec_gc = $db->db_fetch_array($query)){ 
					  ?>
                      <option value="<?php echo $rec_gc["gc_id"];?>"><?php echo $rec_gc["gc_name"];?></option>
                      <?php }?>
                    </select>
                   </td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe"><?php echo $text_genguestbook_select1;?>&nbsp; : &nbsp;&nbsp;</td>
                  <td width="65%" align="left" valign="top" class="styleMe"> <textarea name="comment_guest" cols="30" rows="5" 
													 wrap="VIRTUAL" class="cadweb2007" id="t_detail"><?php echo $comment_guest?></textarea></td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td height="25" colspan="2" class="styleMe">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#003366"><strong><ol>ข้อมูลผู้เข้าเยี่ยมชม</ol></strong></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                <tr  bgcolor="#FFFFFF">
                  <td width="35%" align="right" bgcolor="#FFFFFF" class="styleMe"><?php echo $text_genguestbook_person;?>&nbsp; : &nbsp;&nbsp; </td>
                  <td width="65%" align="left" valign="top" class="styleMe">
                      <?php if($check_data == 'yes')  print $name_guest_print; ?>
                      <input name="name_guest" type="<?php echo $indata?>" class="cadweb2007"  value="<?php echo $name_guest?>"></td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe"><?php echo $text_genguestbook_unit;?>&nbsp; : &nbsp;&nbsp;</td>
                  <td width="65%" align="left" valign="top" class="styleMe"><select name="unit">
                      <option value="">โปรดเลือก....</option>
                      <option value="นักเรียน/นักศึกษา">นักเรียน/นักศึกษา</option>
                      <option value="ข้าราชการ/รัฐวิสาหกิจ">ข้าราชการ/รัฐวิสาหกิจ</option>
                      <option value="เจ้าของกิจการ/ผู้ประกอบการ">เจ้าของกิจการ/ผู้ประกอบการ</option>
					  <option value="พนักงาน/ลูกจ้าง">พนักงาน/ลูกจ้าง</option>
					  <option value="ผู้สนใจทั่วไป">ผู้สนใจทั่วไป</option>
                  </select></td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe"><?php echo $text_genguestbook_email;?>&nbsp; : &nbsp;&nbsp; </td>
                  <td width="65%" align="left" valign="top" class="styleMe style1"><?php if($check_data != 'yes') {?>
                      <input name="email" type="text" value="<?php echo $email?>">
                      <?php }else{ ?>
                      <?php echo $comment_guest_print?>
                      <input name="provice_ctry" type="hidden"  value="<?php echo $provice_ctry?>">
                    &nbsp;
                    <?php } ?>                  </td>
                </tr>
				<tr  bgcolor="#FFFFFF">
                  <td align="right" bgcolor="#FFFFFF" class="styleMe">&nbsp;</td>
                  <td width="65%" align="left" valign="top" class="styleMe style1">&nbsp;</td>
                </tr>
                <tr  bgcolor="#FFFFFF">
                  <td align="center" valign="top" colspan="2">
                    <input name="submit" type="submit" class="cadweb2007" onClick="<?php if($chk_vulgar == 'Y'){echo "alert('".$text_genguestbook_alertsubmit."');return false;";}else{ echo 'return chk_input()';}?>" value="&nbsp;&nbsp;<?php if($check_data == 'yes'){echo $text_genguestbook_valueconf;}else{echo $text_genguestbook_valueok;}?>&nbsp;&nbsp;">
                    &nbsp;&nbsp;
                    <input name="cancle" type="submit" class="cadweb2007" onClick="<?php echo $no_chk?>" value="&nbsp;&nbsp;<?php echo $text_genguestbook_cancle;?>&nbsp;&nbsp;">
                  </td>
                </tr>
            </table><?php } ?></TD>
            <TD vAlign=top width=10></TD>
            <TD width=12></TD>
          </TR>
          <TR>
            <TD width=1></TD>
            <TD vAlign=top width=14></TD>
            <TD vAlign=center width=104 bgColor=#ffffff></TD>
            <TD vAlign=center width=6 bgColor=#ffffff></TD>
            <TD vAlign=center width=487 bgColor=#ffffff></TD>
            <TD vAlign=top width=10></TD>
            <TD width=12></TD>
          </TR>
        </TBODY>
      </TABLE></td>
    </tr>
  </table></td>
</tr>
<tr>
  <td  align='center' vAlign='top'   bgcolor="#FFFFFF" ><TABLE width=649 cellPadding=0 cellSpacing=0 
                        background=mainpic/guestbook/bg_low.gif class="styleMe">
    <TBODY>
      <TR>
        <TD width=21 height="45"><DIV align=left></DIV></TD>
        <TD width=733 align="center"><p class="style3"><?php echo $txt_website_of_name1;?></p></TD>
        <TD width=19 height="45"><DIV align=right></DIV></TD>
      </TR>
    </TBODY>
  </TABLE></td>
</tr>
</form>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
