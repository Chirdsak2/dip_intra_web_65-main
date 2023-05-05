<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/jquery.cluetip.css" rel="stylesheet" type="text/css">
<style type="text/css">
 
    A { COLOR: #0066FF; TEXT-DECORATION: none }
    A:hover { TEXT-DECORATION: underline }
    A.underlined { TEXT-DECORATION: underline }
    A.underlined:visited { TEXT-DECORATION: underline }
    a.cal_head { color: #666666; } 
    a.cal_head:hover { text-decoration: none; } 
    .cal_head15666 { 
        background-color: #EBECE2; 
        color: #8B4513; 
        font-family: Tahoma; 
        font-size: 11; 
        font-weight: normal; 
        font-style: normal; 
    } 
    .cal_days15666 { 
        background-color: #EBECE2; 
        color: #CD7305; 
        font-family: Tahoma; 
        font-size: 11; 
        font-weight: normal; 
        font-style: normal; 
    } 
    .cal_content15666 { 
        background-color: #EBECE2; 
        color: #333333; 
        font-family: Tahoma; 
        font-size: 11; 
        font-weight: normal; 
        font-style: normal; 
    } 
    .cal_today15666 { 
        background-color: #FFDB4F; 
        color: #8B4513; 
        font-family: Tahoma; 
        font-size: 11; 
        font-weight: normal; 
        font-style: normal; 
    } 
    .cal_info15666 { 
        background-color: #FB9D15; 
        color: #3467FF; 
        font-family: Tahoma; 
        font-size: 11; 
        font-weight: bold; 
        font-style: normal; 
    } 
</style>

<style type="text/css">
<!--
.font_basic {
    font-size: 12px;
    font-family: sans-serif,Arial, Helvetica ;
}
-->
</style>
<style type="text/css">
 table.b-19 {display:none}
 span.b-18 {text-decoration: underline}
 span.b-17 {font-size:}
 tr.b-16 {background-color: (null)}
 a.b-15 {font-weight: bold}
 td.b-14 {background-color: #CCCCCC}
 span.b-13 {font-size: 12px;font-weight:bold}
 span.b-12 {font-size:11}
 table.b-11 {background-color: (null)}
 table.b-10 {COLOR: #000000; FONT-FAMILY: Tahoma; FONT-SIZE: 11px; FONT-WEIGHT: normal; TEXT-DECORATION: none; background-color: (null)}
 span.b-9 {font-size: }
 input.b-8 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;}
 td.b-7 {background-color: #FFFFFF}
 table.b-6 {background-color: #E1E1E1}
 td.b-5 {background-color: #F3F1EC}
 td.b-4 {background-color: #E1E1E1}
 span.b-3 {font-size:11px}
 td.b-2 {background-color: (null)}
 span.b-1 {font-size:12px}
</style>
<body>
<div>
<table width="743" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<table class="b-6" width="743" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="b-7" align="center">
<form name="NewsLetterForm15636" method="post" action="newsletter_function.php?filename=w3c_20100629" onsubmit="return ChkValueNewsLetter15636();"></form>
<table class="b-6" id="tball" width="743" border="0" align="center" cellpadding="0" cellspacing="0" style="background:url(themesdesign/themes1/)">
<tbody>
<tr>
<td class="b-2" height="28" style="background:url(themesdesign/themes1/head_img20080910165125.jpg)"><span class="text_head b-1"> สมัครรับข่าวสาร</span></td>
</tr>
<tr>
<td class="b-5" style="background:url(themesdesign/themes1/)">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="left" valign="top">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="10" align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="33" align="center"><label><input name="newsletteremail" type="text" id="newsletteremail" value="ใส่ email ของคุณที่นี่" onfocus="this.value='';" alt=""></label></td>
</tr>
</table>
</td>
</tr>
<tr>
<td height="10" align="center"><input name="applynewsletter" type="radio" value="Y" checked alt=""><span class="text_normal b-3">สมัคร</span> <input type="radio" name="applynewsletter" value="N" alt=""><span class="text_normal b-3">ยกเลิก</span></td>
</tr>
<tr>
<td class="b-4" align="center" height="0" style="background:url(themesdesign/themes1/)"><input type="hidden" name="t" value="1" alt="">
<input name="Button01" type="submit" id="Button01" value="ตกลง" alt=""><br>
<br></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</table>
<table width="743" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<script language="JavaScript" type="text/javascript">
function validLength(item,min,max){
      return (item.length>= min) && (item.length<=max)
}
function validEMail(mailObj){
    if (validLength(mailObj.value,1,50)){
      //return false;
      if (mailObj.value.search("^.+@.+\\..+$") != -1)
        return true;
      else return false;
    }
    return true;
}
function ChkValueNewsLetter15636(){
  if(document.NewsLetterForm15636.newsletteremail.value == ""){
    alert('กรุณาระบุอีเมล์ของท่าน');
    document.NewsLetterForm15636.newsletteremail.focus();
    return false;
  }else if(!validEMail(document.NewsLetterForm15636.newsletteremail)){
    alert('รูปแบบของอีเมล์ไม่ถูกต้อง');
    document.NewsLetterForm15636.newsletteremail.select();
    return false;
  }
  if(document.NewsLetterForm15636.applynewsletter[1].checked){
    r = confirm("คุณต้องการยกเลิกการรับข้อมูลจากทางเรา ?");
    if(r==true){
      return true;
    }else{
      return false;
    }
  }
}
</script></div>
<div>
<table width="" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<table class="b-11" width="" border="0" align="center" cellpadding="0" cellspacing="">
<tr>
<td class="b-7" align="center">
<table class="b-11" width="" align="center" cellpadding="3" cellspacing="1" style="background:url()">
<tr>
<td class="b-2" height="" style="background:url()"></td>
</tr>
<tr>
<td>
<table width="" border="0" align="center" cellpadding="5" cellspacing="0" style="background:url()" class="b-10">
<tr>
<td align="center">
<form name="search15647" method="post" action="search_result.php">
<table cellpadding="0" cellspacing="0">
<tr>
<td><input name="keyword" type="text" id="keyword" size="10" class="b-8" alt=""> <input name="filename" type="hidden" id="filename" value="w3c_20100629" alt=""><input name="oper" type="hidden" id="oper" value="OR" alt=""></td>
<td><input type="button" name="Submit" onclick="
          if(document.search15647.searchby.value==2){
            //location.href='http://www.google.co.th/search?q='+document.search15647.keyword.value;
            window.open ('http://www.google.co.th/search?q='+document.search15647.keyword.value,'mygoogle'); 
          }else{
            document.search15647.submit();
          }" value=" ค้นหา... " class="b-8" alt=""></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="searchby" value="1" alt="">
<input type="radio" name="chk" checked value="1" onclick="if(this.checked==true){document.search15647.searchby.value=this.value;} " alt="">
<span class="b-9">ค้นหาจากในเว็บ</span><br>
<input type="radio" name="chk" value="2" onclick="if(this.checked==true){document.search15647.searchby.value=this.value;} " alt="">
<span class="b-9">ค้นหาจาก</span> Google</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
</div>
<div><script src="../js/AjaxRequest.js" type="text/javascript">
</script> <script src="../js/excute.js" type="text/javascript">
</script> <script src="../js/jquery/jquery.dimensions.js" type="text/javascript">
</script> <script src="../js/jquery/jquery.hoverIntent.js" type="text/javascript">
</script> <script src="../js/jquery/jquery.cluetip.js" type="text/javascript">
</script> <script language="javascript" type="text/javascript">
$(document).ready(
  function() {
    var objDiv = document.getElementById("divCalendar15666");
    url='calendar.php?BID=15666&sh=';
    AjaxRequest.get(
      {
        'url':url
        ,'onLoading':function() { 
            objDiv.innerHTML = '<table cellspacing="0" cellpadding="0" width="100%" border="0" height="180"><tbody><tr><td height="20" align="center"><\/td><\/tr><tr><td width="100%" align="center"><img src="mainpic/loading.gif"><\/td><\/tr><\/tbody><\/table>'; 
        }
        ,'onLoaded':function() { }
        ,'onInteractive':function() { }
        ,'onComplete':function() { }
        ,'onSuccess':function(req) { 
            objDiv.innerHTML = req.responseText; 
            $('span[@title]').cluetip({
              splitTitle: '|', 
              width: '370px',
              arrows: true, 
              dropShadow: false, 
              cluetipClass: 'jtip'}
            );
        }
      }
    );
  }
);

function change_calendar15666(date,BID) {
    var objDiv = document.getElementById("divCalendar"+BID);
    url='calendar.php?date='+date+'&BID='+BID+'&sh=';
    AjaxRequest.get(
      {
        'url':url
        ,'onLoading':function() { 
            objDiv.innerHTML = '<table cellspacing="0" cellpadding="0" width="100%" border="0" height="180"><tbody><tr><td height="20" align="center"><\/td><\/tr><tr><td width="100%" align="center"><img src="mainpic/loading.gif"><\/td><\/tr><\/tbody><\/table>'; 
        }
        ,'onLoaded':function() { }
        ,'onInteractive':function() { }
        ,'onComplete':function() { }
        ,'onSuccess':function(req) { 
            objDiv.innerHTML = req.responseText; 
            $('span[@title]').cluetip({
              splitTitle: '|', 
              width: '370px',
              arrows: true, 
              dropShadow: false, 
              cluetipClass: 'jtip'}
            );
        }
      }
    );
}
</script>
<table width="" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<table class="b-11" width="" border="0" align="center" cellpadding="0" cellspacing="">
<tr>
<td class="b-7" align="center">
<table width="" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
<td height="" style="background:url()"><span class="text_head b-12"> <img src="../mainpic/calendar/head_calendar.jpg" alt=""></span></td>
</tr>
<tr>
<td align="center" valign="top">
<div id='divCalendar15666'></div>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
</div>
<div>
<table width="748" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<table class="b-11" width="748" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="b-7" align="center">
<table class="b-11" width="748" align="center" cellpadding="3" cellspacing="1" style="background:url(themesdesign/themes75/)">
<tr>
<td class="b-2" align="center" style="background:url(themesdesign/themes75/head_img20090929100046.png)"><span class="b-13"><strong>--- UPDATED BLOG ---</strong></span></td>
</tr>
<tr>
<td class="b-7">
<table width="100%" border="0" cellspacing="5" cellpadding="0" class="font_basic">
<tr>
<td>
<table width="100%" border="0" cellpadding="0" cellspacing="5" class="font_basic">
<tr class="b-16" style="background:url(themesdesign/themes75/)">
<td class="b-14" width="50" height="50" align="center" valign="middle"><img src="phpThumb.php?src=../blog/images_profile/n20100709024118_8.jpg&amp;h=48&amp;w=48" border="0" align="middle" alt=""></td>
<td valign="top">
<div><a class="b-15" href="../blog/?blog_id=8" target="_blank"><span class="b-9">ns blog</span></a></div>
<div><b><span class="b-9">Update:</span></b> <span class="b-9">09/07/2553 14:39</span></div>
</td>
</tr>
<tr class="b-16" style="background:url(themesdesign/themes75/)">
<td class="b-14" width="50" height="50" align="center" valign="middle"><img src="phpThumb.php?src=../blog/images_profile/nophoto.jpg&amp;h=48&amp;w=48" border="0" align="middle" alt=""></td>
<td valign="top">
<div><a class="b-15" href="../blog/?blog_id=6" target="_blank"><span class="b-9">เสียงสะท้อนของผู้หญิงไทย
ต่อการเมืองและสิทธิของผู้หญิงและสื่อมวลชนของสังคมไทย</span></a></div>
<div><b><span class="b-9">Update:</span></b> <span class="b-9">29/07/2552 7:52</span></div>
</td>
</tr>
<tr class="b-16" style="background:url(themesdesign/themes75/)">
<td class="b-14" width="50" height="50" align="center" valign="middle"><img src="phpThumb.php?src=../blog/images_profile/nophoto.jpg&amp;h=48&amp;w=48" border="0" align="middle" alt=""></td>
<td valign="top">
<div><a class="b-15" href="../blog/?blog_id=5" target="_blank"><span class="b-9">สร้างการเมืองที่มีคุณธรรม ยุติธรรม
เพื่อประชาชน</span></a></div>
<div><b><span class="b-9">Update:</span></b> <span class="b-9">29/07/2552 7:47</span></div>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="right">ป <a href="blog.php" target="_blank"><span class="b-9">แสดงทั้งหมด</span></a></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="748" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
</div>
<div>
<table width="" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<table class="b-11" width="" border="0" align="center" cellpadding="0" cellspacing="">
<tr>
<td class="b-7" align="center">
<form name="form_loginm15668" method="post" action="ewt_login.php" onsubmit="return chkp15668();"></form>
<form action="http://www.bizpotential.com/sso_project/rpx_sign_in.php" method="post" name="frm15668"><input name="redirect" type="hidden" value="202.122.40.26/openid_function.php" alt=""></form>
<table class="b-11" width="" border="0" align="center" cellpadding="0" cellspacing="0" style="background:url()">
<tr>
<td class="b-2" height="" style="background:url()"><span class="text_head b-17"> เข้าสู่ระบบ</span></td>
</tr>
<tr>
<td class="b-2" style="background:url()">
<table id="firstbox15668" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="30" align="center"><label><span class="text_normal b-9">Username</span> <input name="ewt_user1" type="text" id="ewt_user1" value="" size="10" alt=""></label></td>
</tr>
<tr>
<td height="30" align="center"><label><span class="text_normal b-9">Password</span> <input name="ewt_pass1" id="ewt_pass1" type="password" value="" size="10" alt=""></label></td>
</tr>
<tr>
<td height="22" align="center"><label><input type="button" name="submit2" value="เข้าสู่ระบบ" onclick="chk15668();" alt=""></label></td>
</tr>
</table>
<table id="secbox15668" width="100%" border="0" cellspacing="0" cellpadding="0" class="b-19">
<tr>
<td align="center"><label><span class="text_normal b-9">เพื่อความปลอดภัย กรุณากรอกตัวเลข</span><br>
<a href="#change" onclick="Getmessage15668();"><span class="text_normal b-9"><span class="b-18">คลิ๊กที่นี่</span>
เพื่อเปลี่ยนรูป</span></a></label>
<div id="logpic15668"><img src="ewt_pic.php" align="middle" alt=""></div>
<input name="chkpic115668" type="text" id="chkpic115668" size="4" alt="">
<label><input name="Submit32" type="Submit" value=" OK " alt="">
<script language="javascript" type="text/javascript">
        function Getmessage15668(){
          current_local_time = new Date();
          document.all.logpic15668.innerHTML = "<img src=ewt_pic.php?#" + current_local_time.getDate() + (current_local_time.getMonth()+1) + current_local_time.getYear() + current_local_time.getHours() + current_local_time.getMinutes() +current_local_time.getSeconds() + " align=absmiddle>";
          document.form_loginm15668.chkpic115668.select();

         }  
</script></label></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" height="23"><label><a href="frm_gen_user.php"><span class="text_normal b-9">สมัครสมาชิก </span></a></label> <label><a href="##" onclick="window.open('member_forgot.php','','width=350,height=120');"><span class="text_normal b-9">
| ลืมรหัสผ่าน</span></a><br>
<input name="fn" type="hidden" id="fn" value="main.php?filename=w3c_20100629" alt=""> <input id="Flag" type="hidden" value="AcceptLogin" name="Flag" alt=""> <input id="BID" type="hidden" value="15668" name="BID" alt=""></label></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<script language="JavaScript" type="text/javascript">
function openid15668(){
document.frm15668.submit();
 }
function chk15668(){
  if(document.form_loginm15668.ewt_user1.value == ""){
      alert("Please input username");
      document.form_loginm15668.ewt_user1.focus();
      return false;
  }else if(document.form_loginm15668.ewt_pass1.value == ""){
      alert("Please input password");
      document.form_loginm15668.ewt_pass1.focus();
      return false;
  }else{
  document.all.firstbox15668.style.display = 'none';
  document.all.secbox15668.style.display = '';
  document.form_loginm15668.chkpic115668.focus();
  }

}
function chkp15668(){
    if(document.form_loginm15668.chkpic115668.value == ""){
      alert("Please input picture text");
      document.form_loginm15668.chkpic115668.focus();
      return false;
  }
}
</script></div>
