<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$time_H = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');	
$time_s = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59');	
$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$_GET["cid"]."' ");
$G = $db->db_fetch_array($sql_group);
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
<script src='http://code.jquery.com/jquery-1.9.1.min.js'></script>
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script >
$( document ).ready(function() {

});

function show(){
	var b =document.getElementById("showvdo").value;
	var bc =document.getElementById("showvdo1").value;
	if(document.getElementById("showvdo").checked==true){
	document.getElementById("vdomore2").style.display='';
	document.getElementById("vdomore3").style.display='none';
    }if(document.getElementById("showvdo1").checked==true){
	document.getElementById("vdomore2").style.display='none';
    document.getElementById("vdomore3").style.display='';
	}
}
function del_row(id){
		if(confirm('คุณต้องการลบรายการ?')){
		$('#tr_'+id).remove();
		$('#filevdo'+id).val('del');

	}
}	

function del_row2(id){
		if(confirm('คุณต้องการลบรายการ?')){
		$('#tr2_'+id).remove();
		$('#vdo_youtube'+id).val('del');

	}
}
	
function fncaddRow(){
	var run=parseInt($('#temp_num').val())+parseInt(1);
	var html='';
	html+='<tr valign="top" bgcolor="#FFFFFF" id="tr_'+run+'" >';
	html+='<td>&nbsp;</td>';
	html+='<td width="100%">';
	html+='<input name="filevdo[]"  id="filevdo'+run+'" type="file"  class="form-control" style="width:40%;"  />';
	html+='&nbsp;&nbsp;<span style="cursor:pointer" onclick="del_row('+run+')"><img border="0" src="../theme/main_theme/g_del.gif" width="16" height="16"></span></td>';
	html+='</tr>';
	$("#vdo").append(html);
	$('#temp_num').val(run);
   
	}
	
function fncaddRow2(){
	var run=parseInt($('#temp_num2').val())+parseInt(1);
	var html='';
	html+='<tr valign="top" bgcolor="#FFFFFF" id="tr2_'+run+'" >';
	html+='<td>&nbsp;</td>';
	html+='<td >';
	html+='<input name="vdo_youtube[]" id="vdo_youtube'+run+'" type="text" size="40" class="form-control" style="width:40%;" />';
	html+='&nbsp;&nbsp;<span style="cursor:pointer" onclick="del_row2('+run+')"><img border="0" src="../theme/main_theme/g_del.gif" width="16" height="16"></span></td>';
	html+='</tr>';
	$("#vdo2").append(html);
	$('#temp_num2').val(run);
   
	}
function chktime(c){
current_local_time = new Date();
	var nhours = current_local_time.getHours();
	var nmin = current_local_time.getMinutes();
	var nsec = current_local_time.getSeconds();
		if(nhours < 10){
	nhours = "0" + nhours;
	}
		if(nmin < 10){
	nmin = "0" + nmin;
	}
		if(nsec < 10){
	nsec = "0" + nsec;
	}
	 var ntime = nhours + ":" + nmin + ":" +nsec;
	if(c.checked == true){
		document.form1.time_n.style.display = '';
		document.form1.time_n.value = ntime;
	}else{
		document.form1.time_n.style.display = 'none';
		document.form1.time_n.value = "";
	}
}
function chk(){
		var objDiv = document.getElementById("nav");
					url='app_list.php?cid='+ document.form1.cid.value;
					AjaxRequest.get(
						{
							'url':url
							,'onLoading':function() { }
							,'onLoaded':function() { }
							,'onInteractive':function() { }
							,'onComplete':function() { }
							,'onSuccess':function(req) { 
							}
						}
					);
	if(document.form1.topic.value == ""){
		alert("Please insert topic!!");
		document.form1.topic.focus();
		return false;
	}
		if(document.form1.cid.value == ""){
		alert("Please choose group!");
		win2 = window.open('article_select.php?cid=<?php echo $_GET["cid"]; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');win2.focus();
		return false;
	}
	if(document.form1.detail_use[0].checked == true){
		if(document.form1.browsefile[0].checked == true){
				if(document.form1.link.value == ""){
					alert("Please insert link!!");
					document.form1.link.focus();
					return false;
				}
		}
		if(document.form1.date_start.value != "" && document.form1.date_end.value == ''){
					alert("โปรดใส่วันที่สิ้นสุด!!");
					document.form1.date_end.focus();
					return false;
		}
		
		if(document.form1.date_start.value == "" && document.form1.date_end.value != ''){
					alert("โปรดใส่วันที่เริ่มต้น!!");
					document.form1.date_start.focus();
					return false;
		}
		if(document.form1.browsefile[1].checked == true){
					if(document.form1.filebrowse.value == ""){
					alert("Please insert file!!");
					document.form1.filebrowse.focus();
					return false;
					}
			}
	}
			
			if(document.form1.detail_use[3].checked == true){
					if(document.form1.filedl.value == ""){
					alert("Please insert file!!");
					document.form1.filedl.focus();
					return false;
					}
			}
	article_chkp.location.href = "article_check_p.php?cid="+document.form1.cid.value;		
	return false;
}
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
function txt_data(w) {
	var mytop = findPosY(document.form1.source) +document.form1.source.offsetHeight;
	var myleft = findPosX(document.form1.source);	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='plan_list.php?d='+ w;
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
<SCRIPT language=JavaScript src="../js/date-picker.js" type=text/javascript></SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none"  ></div>
<?php include("../FavoritesMgt/favorites_include.php");?>
<form action="article_function.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chk();">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">บริหารข่าว/บทความ</span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">		<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ( "เพิ่มข่าว/บทความภายใต้กลุ่มข่าว : ".$G[c_name]);?>&module=article&url=<?php echo urlencode ( "article_new.php?cid=".$_GET["cid"]); ?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="article_list.php?cid=<?php echo $_GET["cid"]; ?>"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> 
      กลับหน้าก่อนหน้า</a> <a href="article_group.php">&nbsp;&nbsp;<img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> 
      หน้าหลัก</a>
      <hr>
    </td>
  </tr>
</table> 

<table width="90%" border="0" align="center" cellpadding="10"  class="table table-bordered">

<tr valign="top" > 
<td colspan="2" class="ewttablehead">เพิ่มข่าว/บทความ</td>
</tr>

<tr valign="top"> 
<td width="26%" bgcolor="#FFFFFF">หัวข้อ : <font color="#FF0000">*</font></td>
<td width="74%" bgcolor="#FFFFFF"><input name="topic" type="text" id="topic" size="60"  class="form-control" /></td>
</tr>
          
<tr valign="top"> 
<td bgcolor="#FFFFFF">หมวด : </td>
<td bgcolor="#FFFFFF"><span id="txtshow"><?php echo $G[c_name]; ?></span>
        <a href="#browse" title="เลือกกลุ่ม" onClick="win2 = window.open('article_select.php?cid=<?php echo $_GET["cid"]; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');win2.focus();"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle" ></a> 
        <input name="cid" type="hidden" id="cid" value="<?php echo $_GET["cid"]; ?>"> 
</td>
</tr>

<tr valign="top"> 
<td bgcolor="#FFFFFF">วันที่ : </td>
<td bgcolor="#FFFFFF"><input class="form-control" style="width:15%;" name="date_n" type="text" id="date_n" value="<?php echo date("d")."/".date("m")."/".(date("Y")+543); ?>" size="10" readonly="true"> 
<a href="#date" onClick="return show_calendar('form1.date_n');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;"><img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle"></a> 
<input type="checkbox" name="checkbox" value="Y" onClick="chktime(this);"> แสดงเวลา 
<input name="time_n" type="text" id="time_n" size="8" style="display:none">
</td>
</tr>

<tr valign="top"> 
<td bgcolor="#FFFFFF">รูปประกอบข่าวในหน้าแรก  : </td>
<td bgcolor="#FFFFFF">
<input type="file" name="file" class="form-control" style="width:40%;" />
<br>
<?php 
			    $sql_Imsize = "select site_info_max_img from site_info";
				$query_Imsize = $db->query($sql_Imsize);
				$rec_Imsize = $db->db_fetch_array($query_Imsize);
			?>
(ขนาดไม่เกิน <?php echo number_format($rec_Imsize[site_info_max_img],2); ?> KB.)</td>
</tr>

<tr valign="top"> 
<td bgcolor="#FFFFFF">ที่มา/แหล่งข่าว  : </td>
<td bgcolor="#FFFFFF"><input name="source" type="text" id="source" size="60" onKeyUp="txt_data(this.value)"  autocomplete="off" class="form-control" style="width:40%;" /></td>
</tr>

<tr valign="top"> 
<td bgcolor="#FFFFFF">URL ของที่มา/แหล่งข่าว  : </td>
<td bgcolor="#FFFFFF"><input name="source_url" type="text" id="source_url" size="60" class="form-control" style="width:40%;" /></td>
</tr>

<tr valign="top"> 
<td bgcolor="#FFFFFF">Link ของข่าว/บทความ  : </td>
<td bgcolor="#FFFFFF"><input name="detail_use" type="radio" value="1" checked onClick="document.all.trb01.style.display='';document.all.trb02.style.display='none';document.all.trb04.style.display='none';document.all.trb05.style.display='none';document.all.vdomore.style.display='none';document.all.vdomore1.style.display='none';document.all.vdomore2.style.display='none';document.all.vdomore3.style.display='none';">
            เชื่อมต่อไปยังหน้าเว็บหรือไฟล์เอกสาร <input type="radio" name="detail_use" value="2" onClick="document.all.trb01.style.display='none';document.all.trb02.style.display='';document.all.trb04.style.display='none';document.all.trb05.style.display='none';document.form1.at_id[0].checked=true; document.all.vdomore.style.display='';document.all.vdomore1.style.display='';">
            เลือก Template
	<!--input type="radio" name="detail_use" value="3" onClick="document.all.trb01.style.display='none';document.all.trb02.style.display='none';document.all.trb04.style.display='';document.all.trb05.style.display='none';document.form1.at_id[10].checked=true;">
            เลือกกำหนดเอง(advance) <input type="radio" name="detail_use" value="4" onClick="document.all.trb01.style.display='none';document.all.trb02.style.display='none';document.all.trb04.style.display='none';document.all.trb05.style.display='';">
            Private File -->
</td>
</tr>

          <tr valign="top" id="trb01"> 
            <td bgcolor="#FFFFFF"></td>
            <td bgcolor="#FFFFFF">
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC" class="table table-bordered">
                <tr valign="top"> 
                  <td width="28%" bgcolor="#FFFFFF"><input name="browsefile" type="radio" value="1" checked="checked">
                  ใส่ URL ของ web หรือ ไฟล์ </td>
            <td width="72%" bgcolor="#FFFFFF">
			<input class="form-control" style="width:50%;" name="link" type="text" id="link" size="45" onFocus="document.form1.browsefile[0].checked=true" >
              <a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.form1.link.value','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0');document.form1.browsefile[0].checked=true;win2.focus();"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle" ></a></td>
                </tr>
                <tr valign="top">
                  <td bgcolor="#FFFFFF"><input name="browsefile" type="radio" value="2">
                    เลือกไฟล์จากเครื่อง</td>
                  <td bgcolor="#FFFFFF"><input type="file" name="filebrowse"  onClick="document.form1.browsefile[1].checked=true"></td>
                </tr>
			 <tr bgcolor="#FFFFFF">
				  <td colspan="2" ><input type="checkbox" name="chk_show_count_level1"  value="3">
						 แสดงจำนวนการดาวน์โหลด[ครั้ง]</td>
							 </tr>
              </table> </td>
</tr>
<tr valign="top" id="trb02" style="display:none"> 
<td bgcolor="#FFFFFF"></td>
<td bgcolor="#FFFFFF">
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC" class="table table-bordered">
              <!-- <tr bgcolor="F7F7F7">
                <td bgcolor="F7F7F7"><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> Template รูปแบบ editor </td>
              </tr>
             <tr align="center" bgcolor="#FFFFFF">
                <td align="center" ><table width="360" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                    <?php
				/*  $sql_at = $db->query("SELECT * FROM article_template where at_id ='10' ORDER BY at_id");
				  $a=0;
				  while($AT = $db->db_fetch_array($sql_at)){*/

				  ?><tr>
                  <td  align="center" bgcolor="#FFFFFF"><div align="center">
                    <input type="radio" name="at_id" value="<?php //echo $AT[at_id]; ?>"  onClick="document.form1.detail_use[1].checked=true">
                   Edit Template Free style</div>
                <img src="../article_template/pic/editor.gif" border="1"></td></tr>
            <?php

					   //$a++; } ?>
                              </table></td>
              </tr>-->
</table>
<br>
<table width="100%" border="0" class="table table-bordered">
<tr bgcolor="#F7F7F7"> 
<td bgcolor="#F7F7F7">
<img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> Template รูปแบบ Block</td>
</tr>
<tr align="center" bgcolor="#FFFFFF"> 
<td align="center" >
<table width="360" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<?php
						  //$sql_at = $db->query("SELECT * FROM article_template where at_id <>'10' and at_id <>'11' ORDER BY at_id");
						  $sql_at = $db->query("SELECT * FROM article_template where at_id = '6' ORDER BY at_id");
						  $a=0;
						  while($AT = $db->db_fetch_array($sql_at)){
						  if($a%3==0){
						  echo "<tr>";
						  }
						  ?>
							  <td width="120" align="center" bgcolor="#FFFFFF"><div align="center"> 
								  <input type="radio" name="at_id" value="<?php echo $AT[at_id]; ?>" <?php if($a == 0){ echo "checked"; } ?> onClick="document.form1.detail_use[1].checked=true">
								  Template <?php /*echo $AT[at_id];*/ ?></div>
								<img src="../article_template/pic/<?php echo $AT["at_pic"]; ?>" width="64" height="64"></td>
							  <?php
							   if($a%3==2){
						  echo "</tr>";
						  }
					   $a++; } ?>
                    </table></td>
                </tr>
            </table></td>
          </tr>
<tr style="display:none" id="vdomore">
<td bgcolor="#FFFFFF">ไฟล์วิดีโอ :</td>
<td bgcolor="#FFFFFF">		  
<input name="showvdo" type="radio" id="showvdo"  onclick="show();" value="1"  /> นำเข้าจากไฟล์ VIDEO
<br>
<input name="showvdo" type="radio" id="showvdo1"  onclick="show();" value="2" /> นำเข้าจาก YOUTUBE	
</td>
</tr>	  
<tr style="display:none" id="vdomore2">
<td bgcolor="#FFFFFF"></td>
<td bgcolor="#FFFFFF">
<table width="100%" border="0" align="center"  id="vdo" class="table table-bordered">
<tr valign="top" id="tr_1"> 
<td width="20%"> ไฟล์  VIDEO </td>
<td bgcolor="#FFFFFF">
<input type="file" name="filevdo[]" class="form-control" style="width:40%;" />&nbsp;&nbsp;<span style="cursor:pointer" onclick="fncaddRow();"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="" border="0"></span>

<BR><span class="style1">* ประเภทไฟล์ที่สามารถใช้ได้คือ  mp4 เท่านั้น  (ขนาดไฟล์ต้องไม่เกิน 10 MB)</span>
</td>
</tr>
</table>
</td>
</tr>
<tr style="display:none" id="vdomore3">
<td bgcolor="#FFFFFF"></td>
<td bgcolor="#FFFFFF">
<table width="100%" border="0" align="center" id="vdo2" class="table table-bordered">
<tr valign="top" bgcolor="#FFFFFF" id="tr2_1" > 
	<td width="20%" >URL YOUTUBE </td>
	<td><input name="vdo_youtube[]" type="text" size="40" class="form-control" style="width:40%;" />&nbsp;&nbsp;<span style="cursor:pointer" onclick="fncaddRow2();"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="" border="0"></span>

<br><span class="style1">* ตัวอย่าง https://www.youtube.com/watch?v=Yx5ew-ck4B8</span></td>
</tr> 
</table>
</td>
</tr>
<tr valign="top" style="display:none" id="vdomore1"> 
<td bgcolor="#FFFFFF">แหล่งที่มาไฟล์วิดีโอ :</td>
<td bgcolor="#FFFFFF">
 <input name="address1" type="text" value="" size="50" class="form-control" style="width:40%;" />

Url: <input name="address2" type="text" value="" size="50" class="form-control" style="width:40%;" />

</td>
</tr>
<input type="hidden" id="temp_num" name="temp_num" value="1" />
<input type="hidden" id="temp_num2" name="temp_num2" value="1" />		 
		   <tr valign="top" id="trb04" style="display:none">
		     <td bgcolor="#FFFFFF">&nbsp;</td>
             <td  bgcolor="#FFFFFF">
               <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
                 <tr bgcolor="F7F7F7">
                   <td colspan="2" bgcolor="F7F7F7"><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> Template รูปแบบ กำหนดเอง(advance) </td>
                 </tr>
                 <tr bgcolor="#FFFFFF">
                   <td align="center" ><div align="center">
                    <input type="radio" name="at_id" value="11" checked="checked"  onClick="document.form1.detail_use[2].checked=true">ใส่จำนวนที่ต้องการ(row*column)
                   </div></td>
                   <td >

<table width="360" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
  <td bgcolor="#FFFFFF">
  <input name="txtrow" type="text" value="3" size="5" maxlength="2">
    X
        <input name="txtcol" type="text" value="3" size="5" maxlength="2"></td>
                   </table></td>
                 </tr>
               </table></td>
	</tr>
	<tr valign="top" id="trb05" style="display:none">
		     <td bgcolor="#FFFFFF">&nbsp;</td>
      <td  bgcolor="#FFFFFF">
               
<table width="100%" border="0" class="table table-bordered">
                 <tr bgcolor="F7F7F7">
                   <td bgcolor="F7F7F7"><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> เอกสารสำหรับ Download 
                     <input type="file" name="filedl" ></td>
                 </tr>
                 <tr bgcolor="#FFFFFF">
                   <td ><input name="chk_member" type="checkbox" id="chk_member" value="Y"> 
                   Download ได้เฉพาะสมาชิก</td>
                 </tr>
				 <tr bgcolor="#FFFFFF">
                   <td ><input type="checkbox" name="chk_show_count" value="2">
                   แสดงจำนวนการดาวน์โหลด[ครั้ง]</td>
                 </tr>
               </table></td>
	</tr>
		   <tr valign="top"> 
            <td bgcolor="#FFFFFF">ลักษณะการเชื่อมต่อ : </td>
            <td  bgcolor="#FFFFFF">
			<select name="target" id="select" class="form-control" style="width:20%;">
                <option value="_blank">เปิดหน้าต่างใหม่</option>
				<option value="_self">เปิดหน้าต่างเดิม</option>
             </select></td>
          </tr>
		  
<tr valign="top"> 
<td bgcolor="#FFFFFF"></td>
<td  bgcolor="#FFFFFF"><input name="chkkk" type="checkbox" id="chkkk" value="Y" onClick="if(this.checked==true){ document.all.trb03.style.display=''; }else{ document.all.trb03.style.display='none'; }">
ตั้งค่าเพิ่มเติม
<table width="100%" border="0" class="table table-bordered" id="trb03" style="display:none">
<tr valign="top">
<td bgcolor="#FFFFFF"> กำหนดวันที่แสดงข่าว</td>
<td bgcolor="#FFFFFF">             
เริ่มต้น
<input name="date_start" type="text" id="date_start" value="" size="10" class="form-control" style="width:20%;"> 
              <a href="#date" onClick="return show_calendar('form1.date_start');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;"><img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle"></a> เวลา 
              <label>
              <select name="time_H_start" class="form-control" style="width:10%;">
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_H);$i++){ ?>
			  <option value="<?php echo $time_H[$i];?>"><?php echo $time_H[$i];?></option>
			  <?php }?>
              </select>
              :
               <select name="time_s_start" class="form-control" style="width:10%;">
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_s);$i++){ ?>
			  <option value="<?php echo $time_s[$i];?>"><?php echo $time_s[$i];?></option>
			  <?php }?>
              </select>
              นาที              </label><br><br>
              สิ้นสุด 
              <input name="date_end" type="text" id="date_end" value="" size="10" class="form-control" style="width:20%;">
              <a href="#date" onClick="return show_calendar('form1.date_end');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;"><img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle"></a> เวลา 
              <select name="time_H_end" class="form-control" style="width:10%;">
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_H);$i++){ ?>
			  <option value="<?php echo $time_H[$i];?>"><?php echo $time_H[$i];?></option>
			  <?php }?>
              </select>
              :
             <select name="time_s_end" class="form-control" style="width:10%;">
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_s);$i++){ ?>
			  <option value="<?php echo $time_s[$i];?>"><?php echo $time_s[$i];?></option>
			  <?php }?>
              </select>
              นาที  </td>
          </tr>
          
		  <tr valign="top" > 
            <td bgcolor="#FFFFFF">คำอธิบายหัวข้อข่าว</td>
            <td bgcolor="#FFFFFF">
<textarea name="description" cols="60" rows="5" wrap="VIRTUAL" id="description" class="form-control" ></textarea></td>
          </tr>
          <tr valign="top"> 
            <td bgcolor="#FFFFFF">รูปหลังข่าว</td>
            <td bgcolor="#FFFFFF"><span id="iconname">เลือกรูป</span><input type="hidden" name="icon" value="<?php echo $R[logo];?>"><a href="#browse" title="เลือก Icon" onClick="win2 = window.open('article_icon.php?iconname='+window.form1.icon.value,'WebsiteLink','top=100,left=100,width=500,height=500,resizable=1,status=0,scrollbars=1');win2.focus();"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle" ></a></td>
          </tr>
 <tr valign="top" > 
            <td bgcolor="#FFFFFF">แสดงรูปหลังข่าวถึงวันที่</td>
            <td bgcolor="#FFFFFF">
<?php
			$dateshowl= date ("Y-m-d", mktime (0,0,0,date("m"),date("d")+5,date("Y")));
			$date = explode("-",$dateshowl);
			?><input class="form-control" style="width:20%;" name="date_e" type="text" id="date_e" value="<?php echo $date[2]."/".$date[1]."/".($date[0]+543); ?>" size="10" readonly="true"> 
              <a href="#date" onClick="return show_calendar('form1.date_e');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;"><img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle"></a></td>
          </tr>
            </table></td>
		  </tr>
          <tr valign="top"> 
            <td bgcolor="#FFFFFF">&nbsp;</td>
            <td bgcolor="#FFFFFF">
			<input type="submit" name="Submit" value="Submit" class="btn btn-success" /> 
              <input type="reset" name="Submit2" value="Reset" class="btn btn-warning" /> 
			  <input name="Flag" type="hidden" id="Flag" value="AddArticle"><input name="apl" type="hidden" id="apl" value=""></td>
          </tr>
</table></form><iframe name="article_chkp"  frameborder="0"  width="1" height="1" scrolling="no"></iframe>
        <br>
</body>
</html>
<?php
 	$db->db_close(); ?>
