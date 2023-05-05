<style type="text/css">
<!--
.style2 {font-size: 11px;FONT-FAMILY: tahoma}
-->
</style>

<style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
-->
</style>
<style type="text/css">
 td.b-11 {background-color: #FFFFFF}
 table.b-10 {COLOR: #000000; FONT-FAMILY: Tahoma; FONT-SIZE: 11px; FONT-WEIGHT: normal; TEXT-DECORATION: none; background-color: (null)}
 input.b-9 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;}
 span.b-8 {font-size: ; font-weight: bold}
 table.b-7 {background-color: (null)}
 td.b-6 {background-color: #6A2B00}
 table.b-5 {background-color: #FFFFFF}
 span.b-4 {font-size: }
 td.b-3 {background-color: (null)}
 span.b-2 {font-size:}
 table.b-1 {background-color: #F7F7F7}
</style>
<body>
<div>
<form name="PollFormZhaj498" onsubmit="return show_data_pollviewZhaj498();" action="ewt_vote.php?lang_sh=" method="post" target=""></form>
<table class="b-1" width="200" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td><img src="../mainpic/vote/head_vote.jpg" width="200" height="25" alt=""></td>
</tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td colspan="2"><span class="text_normal">การสำรวจ</span></td>
</tr>
<tr>
<td colspan="2"><label><input type="radio" value="5" name="vote" alt="">
<span class="text_normal">ความคิดเห็นที่ 1</span></label></td>
</tr>
<tr>
<td colspan="2"><label><input type="radio" value="6" name="vote" alt="">
<span class="text_normal">ความคิดเห็นที่ 2</span></label></td>
</tr>
<tr>
<td width="50%" align="center"><label><input type="hidden" name="flag" alt=""> <input type="image" name="imageField2" src="../mainpic/vote/vote.gif" onclick="document.PollFormZhaj498.flag.value='0'; return chkPollZhaj();" alt=""></label></td>
<td width="50%" align="center"><label><input type="image" name="imageField2" src="../mainpic/vote/result.gif" onclick="document.PollFormZhaj498.flag.value='1';" alt=""></label> <input name="cad_id" type="hidden" id="cad_id" value="1" alt=""></td>
</tr>
</table>
</td>
</tr>
</table>
<iframe name="iframe_showpollZhaj498" src="" frameborder="0" width="1" height="1" scrolling="no"></iframe> <script language="javascript" type="text/javascript">
    function show_data_pollviewZhaj498(){
    var flag = document.PollFormZhaj498.flag.value;
    
      if(flag == '0'){
      
        document.PollFormZhaj498.target = "iframe_showpollZhaj498";
        return true;
      }else if(flag == '1'){
        PollFormZhaj498.target = "PollVote";
        winPollVote = window.open('', 'PollVote', 'alwaysRaised=1,menuber=0,toolbar=0,location=0,directories=0,personalbar=0,scrollbars=1,status=0,resizable=1,width=550,height=410');
        winPollVote.focus(); 
        return true;
      }
    }
    function chkPollZhaj(){
      var x = 0;
        for (var i=0; i<document.PollFormZhaj498.vote.length; i++) {
          if (document.PollFormZhaj498.vote[i].checked) {
            var x = 1;
           }
         }
        if(x==0){
          alert("กรุณาเลือกคำตอบด้วยครับ");
          return false;
        }else{
          return true;
        }
      }    
</script></div>
<div>
<form name="formSearchFAQ" method="post" action="search_result.php"></form>
<table width="" border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
<tr>
<td align="right"><input name="filename" type="hidden" id="filename" value="test" alt=""> <input type="text" name="keyword" class="styleMe" alt=""> <input type="hidden" name="search_mode" value="5" alt="">
<input type="submit" name="search" value="ค้นหา FAQ" class="styleMe" alt=""></td>
</tr>
</table>
<table width="" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<table class="b-7" width="" border="0" align="center" cellpadding="0" cellspacing="" style="background:url(../mainpic/toolbars.gif)">
<tr>
<td class="b-3" style="background:url(../mainpic/toolbars.gif)" height="30">
<span class="text_head b-2"> reee</span></td>
</tr>
<tr>
<td class="b-6" align="center" style="background:url(../mainpic/)">
<table class="b-5" border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="tbbg" style="background:url(../mainpic/)">
<tr>
<td>
<ul>
<li><a href="##lo" onclick="window.open('faq_open.php?fa_id=2','showass','scrollbars=yes,width=650,height=450')">
<span class="b-4">erer</span></a></li>
</ul>
</td>
</tr>
<tr>
<td align="right"><a href="faq_list.php?f_id=&amp;f_sub_id=2&amp;filename=test"><span class="b-4">ดูทั้งหมด&gt;</span></a></td>
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
<table width="" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<table class="b-7" width="" border="0" align="center" cellpadding="0" cellspacing="" style="background:url(../mainpic/toolbars.gif)">
<tr>
<td class="b-3" style="background:url(../mainpic/toolbars.gif)" height="30">
<span class="text_head b-2"> tedt</span></td>
</tr>
<tr>
<td class="b-6" align="center" style="background:url(../mainpic/)">
<table class="b-5" border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="tbbg" style="background:url(../mainpic/)">
<tr>
<td></td>
</tr>
<tr>
<td align="right"><a href="faq_list.php?f_id=&amp;f_sub_id=2&amp;filename=test"><span class="b-4">ดูทั้งหมด&gt;</span></a></td>
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
<table class="b-7" width="99%" border="0" align="center" cellpadding="5" cellspacing="0" style="background:url()">
<tr>
<td class="b-3" align="center" style="background:url()"><span class="text_normal"><span class="b-8">ขณะนี้มีผู้&nbsp;Online&nbsp;อยู่</span>&nbsp;</span>
<div><img src="../ewt_c.php?id=" alt=""></div>
</td>
</tr>
</table>
</div>
<div>
<table width="" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
</tr>
</table>
<table class="b-7" width="" border="0" align="center" cellpadding="0" cellspacing="">
<tr>
<td class="b-11" align="center">
<table class="b-7" width="" align="center" cellpadding="3" cellspacing="1" style="background:url()">
<tr>
<td class="b-3" height="" style="background:url()"></td>
</tr>
<tr>
<td>
<table width="" border="0" align="center" cellpadding="5" cellspacing="0" style="background:url()" class="b-10">
<tr>
<td align="center">
<form name="search1911" method="post" action="search_result.php">
<table cellpadding="0" cellspacing="0">
<tr>
<td><input name="keyword" type="text" id="keyword" size="10" class="b-9" alt=""> <input name="filename" type="hidden" id="filename" value="test" alt=""><input name="oper" type="hidden" id="oper" value="OR" alt=""></td>
<td><input type="button" name="Submit" onclick="
          if(document.search1911.searchby.value==2){
            //location.href='http://www.google.co.th/search?q='+document.search1911.keyword.value;
            window.open ('http://www.google.co.th/search?q='+document.search1911.keyword.value,'mygoogle'); 
          }else{
            document.search1911.submit();
          }" value=" ค้นหา... " class="b-9" alt=""></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="searchby" value="1" alt="">
<input type="radio" name="chk" checked value="1" onclick="if(this.checked==true){document.search1911.searchby.value=this.value;} " alt="">
<span class="b-4">ค้นหาจากในเว็บ</span><br>
<input type="radio" name="chk" value="2" onclick="if(this.checked==true){document.search1911.searchby.value=this.value;} " alt="">
<span class="b-4">ค้นหาจาก</span> Google</td>
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
<div id="show_comment2208"></div>
