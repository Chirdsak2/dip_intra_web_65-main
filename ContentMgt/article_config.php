<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$sql_design = $db->query("SELECT * FROM article_apply WHERE a_id = '".$_GET["aid"]."' ");
$R = $db->db_fetch_array($sql_design);

			  $f1 = fopen("../font_list.txt","r");
			  while($line1 = fgets($f1,1024)){
			  $fontL .= $line1; 
			  }
			  fclose($f1);
			 $FontA = explode("###",$fontL);  
	?>
<html>
<head>
<title>Article Management [<?php echo $_GET["filename"]; ?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function changePic(c,d){
if(c.value != ""){
d.src = c.value;
}else{
d.src = "../images/blank.gif";
}
}
function changePic2(c,d){
d.src = c;
}
function changePic3(c,d){
d.style.background = "url(../images/o.gif)";
d.style.backgroundColor = c.value;
}
		  		function selColor(c,d,e){
					Win2=window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '&c_preview='+ e +'','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
				}
			  	function CreColor(va,bg,pre,flag){
				  	bg.style.backgroundColor= va;
					if(flag == 'color'){
  						pre.style.color = va;
					}else{
						pre.style.backgroundColor = va;
					}
				}
function Chan1(){
self.parent.article_preview.document.all.bg01.style.background = "url("+document.form1.iml03.value+")";
document.form1.nobg01.checked = false;
}
function Chan2(){
self.parent.article_preview.document.all.bg04.style.background = "url("+document.form1.iml06.value+")";
document.form1.nobg02.checked = false;
}
		  function chHTB(){
self.parent.article_preview.document.all.bg04.style.height=document.form1.AMBOTTOMH.value;
}
		  function chwidth(){
self.parent.article_preview.document.all.tbbody.style.width=document.form1.AMWidth.value;
}
		  function chHH(){
self.parent.article_preview.document.all.bg01.style.height=document.form1.AMHeadH.value;
}
		  function inp(c,d){
		  	d.innerHTML = c;
		  }
		  function ChF3(c,d){
			d.style.fontFamily=c;
		}
		function ch3(c,d){
			if(c==""){
				d.style.fontSize = "12pt";
			}else{
				d.style.fontSize = c+"pt";
			}
		}
		function ChB3(c,d){
			if(c.checked){
				d.style.fontWeight='bold';
			}else{
				d.style.fontWeight='';
			}
		}
		function ChI3(c,d){
			if(c.checked){
				d.style.fontStyle='italic';
			}else{
				d.style.fontStyle='';
			}
		}
		  function showtable(c){
	for(i=1;i<5;i++){
		if(i != c){
		document.getElementById("tr0" +i).style.display='none';
		}else{
		document.getElementById("tr0" +i).style.display='';
		}
	}
}
				function choose_bg(c,d){
	formPopUpBg.action = "../FileMgt/gallery_insert.php";
	window.open('','bg_popup','top=60,left=80,width=780,height=480,resizable=1,status=0');
		document.formPopUpBg.o_value.value = c;
		document.formPopUpBg.o_preview.value = d;
		document.formPopUpBg.Flag.value = "SetBg";
		formPopUpBg.submit();
		}
						function choose_pic(c,d){
	formPopUpBg.action = "../FileMgt/gallery_insert.php";
	window.open('','bg_popup','top=60,left=80,width=780,height=480,resizable=1,status=0');
		document.formPopUpBg.o_value.value = c;
		document.formPopUpBg.o_preview.value = d;
		document.formPopUpBg.Flag.value = "SetPic";
		formPopUpBg.submit();
		}
		function topic1(c){
		if(c == ""){
		 choose_pic('window.opener.document.form1.AMBulletBP[2].value','self.opener.parent.article_preview.document.all.img01');
		 }else{
		 self.parent.article_preview.document.all.img01.src = "<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/" ?>"+c;
		 }
		}
				function topic3(c){
		if(c == ""){
		 choose_pic('window.opener.document.form1.AMBulletSP[2].value','self.opener.parent.article_preview.document.all.img02');
		 }else{
		 self.parent.article_preview.document.all.img02.src = "<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/" ?>"+c;
		 }
		}
		function topic0(c){
		if(c == ""){
		 choose_pic('window.opener.document.form1.AMBodyBP[2].value','self.opener.parent.article_preview.document.all.img03_1');
		 }else{
		 self.parent.article_preview.document.all.img03_1.src = "<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/" ?>"+c;
		 self.parent.article_preview.document.all.img03_2.src = "<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/" ?>"+c;
		 }
		}
			function topic4(c){
		if(c == ""){
		 choose_pic('window.opener.document.form1.AMMorePic[1].value','self.opener.parent.article_preview.document.all.img04');
		 }else{
		 self.parent.article_preview.document.all.img04.src = "<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/" ?>"+c;
		 }
		}
				function topic2(c){
		if(c == ""){
		 choose_bg('window.opener.document.form1.AMHeadP[1].value','self.opener.parent.article_preview.document.all.bg01');
		 }else{
		 self.parent.article_preview.document.all.bg01.style.background = "url(<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/" ?>"+c+")";
		 }
		}
						function topic5(c){
		if(c == ""){
		 choose_bg('window.opener.document.form1.AMBOTTOMP[1].value','self.opener.parent.article_preview.document.all.bg04');
		 }else{
		 self.parent.article_preview.document.all.bg04.style.background = "url(<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/" ?>"+c+")";
		 }
		}
		function chkhead(c){
			if(c.checked == true){
				document.all.headuse.style.display = '';
				self.parent.article_preview.document.all.name01.style.display = '';
			}else{
				document.all.headuse.style.display = 'none';
				self.parent.article_preview.document.all.name01.style.display = 'none';
			}
		}
				function chkdetail(c){
			if(c.checked == true){
				document.all.detailuse.style.display = '';
				self.parent.article_preview.document.all.name05_1.style.display = '';
				self.parent.article_preview.document.all.name05_2.style.display = '';
			}else{
				document.all.detailuse.style.display = 'none';
				self.parent.article_preview.document.all.name05_1.style.display = 'none';
				self.parent.article_preview.document.all.name05_2.style.display = 'none';
			}
		}
		 function chkdate(c){
			if(c.checked == true){
				self.parent.article_preview.document.all.namedate1.style.display = '';
				self.parent.article_preview.document.all.namedate2.style.display = '';
			}else{
				self.parent.article_preview.document.all.namedate1.style.display = 'none';
				self.parent.article_preview.document.all.namedate2.style.display = 'none';
			}
		}
		function ChF4(c,d,e){
			d.style.fontFamily=c;
			e.style.fontFamily=c;
		}
		function ch4(c,d,e){
			if(c==""){
				d.style.fontSize = "12pt";
				e.style.fontSize = "12pt";
			}else{
				d.style.fontSize = c+"pt";
				e.style.fontSize = c+"pt";
			}
		}
		function ChB4(c,d,e){
			if(c.checked){
				d.style.fontWeight='bold';
				e.style.fontWeight='bold';
			}else{
				d.style.fontWeight='';
				e.style.fontWeight='';
			}
		}
		function ChI4(c,d,e){
			if(c.checked){
				d.style.fontStyle='italic';
				e.style.fontStyle='italic';
			}else{
				d.style.fontStyle='';
				e.style.fontStyle='';
			}
		}
		function CreColor4(va,bg,pre1,pre2,flag){
				  	bg.style.backgroundColor= va;
					if(flag == 'color'){
  						pre1.style.color = va;
						pre2.style.color = va;
					}else{
						pre1.style.backgroundColor = va;
						pre2.style.backgroundColor = va;
					}
				}
				function chk12(){
				if(self.parent.article_preview.document.all.img03_2.src != self.parent.article_preview.document.all.img03_1.src){
				 self.parent.article_preview.document.all.img03_2.src = self.parent.article_preview.document.all.img03_1.src ;
				 }
				 if(self.parent.article_preview.document.all.name02_2.style.color !=self.parent.article_preview.document.all.name02_1.style.color){
				 self.parent.article_preview.document.all.name02_2.style.color = self.parent.article_preview.document.all.name02_1.style.color ;
				 }
				  if(self.parent.article_preview.document.all.name05_2.style.color !=self.parent.article_preview.document.all.name05_1.style.color){
				 self.parent.article_preview.document.all.name05_2.style.color = self.parent.article_preview.document.all.name05_1.style.color ;
				 }
				}
				function changePic4(c,d,e){
				d.src = c;
				e.src = c;
				}
				function changeinterface(c){
				var allTT = document.all.blockad;
					if(c == ""){
								 for (i=0; i < allTT.length; i++) {
									 allTT[i].style.display = '';
								}
					}else{
								 for (i=0; i < allTT.length; i++) {
									 allTT[i].style.display = 'none';
								}
					}
				}
		  -->
</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
 <form action="article_function.php" method="post" enctype="multipart/form-data" name="form1" target="_parent"> <tr>
      <td height="25" bgcolor="F7F7F7"> <strong>Config Your Article &amp; Design </strong> 
        <table width="100%" border="0" cellspacing="1"  id="tr01" >
          <tr bgcolor="#F7F7F7"> 
            <td ><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="90" align="center" background="../images/bg1_on90.gif">ตั้งค่าทั่วไป</td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#design" onClick="showtable('2')">หมวดข่าว</a></td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('3')">หัวข้อข่าว</a> 
                  </td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">ส่วนล่างของข่าว 
                    </a> </td>
                  <td background="../images/bg2_off.gif">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
		  <tr bgcolor="#FFFFFF"> 
            <td align="center"  ><table width="80%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr valign="top"> 
    <td width="40%">Block themes :</td>
    <td width="60%"><select name="select_block_design" onChange="changeinterface(this.value)">
					<option value=""></option>
					<?php 
						$sql_themes = "SELECT * FROM themes ORDER BY themes_name ASC";
						$query = $db->query($sql_themes);
						while($rec_themes = $db->db_fetch_array($query)) {
							echo " <option value=\"".$rec_themes[themes_id]."\" ";
								if($R[block_theme] == $rec_themes[themes_id]){
									echo "selected";
								}
							echo " >".$rec_themes[themes_name]."</option>";
						}
					?>
				</select></td>
  </tr>
  <tr valign="top" id="blockad"> 
    <td>ความกว้างของ Article : </td>
    <td><input name="AMWidth" type="text" id="AMWidth" value="<?php echo $R["AMWidth"]; ?>" size="4" onBlur="chwidth()"></td>
  </tr>
  <tr valign="top"> 
    <td> จำนวนข่าวที่แสดง :</td>
    <td><input name="a_show" type="text" id="a_show" value="<?php echo $R["a_show"]; ?>" size="1"></td>
  </tr>
  <tr valign="top">
    <td>รูปประกอบ Article :</td>
    <td><input type="radio" name="AMBulletBP" value="" onClick="changePic2('../images/o.gif',self.parent.article_preview.document.all.img01)" <?php if($R["AMBulletBP"] == ""){ echo "checked"; } ?>>
              ไม่ใช้รูปภาพ<br>
              <input type="radio" name="AMBulletBP" value="@first_news#" onClick="changePic2('../images/a_news_pic.gif',self.parent.article_preview.document.all.img01)" <?php if($R["AMBulletBP"] == "@first_news#"){ echo "checked"; } ?>>
              แสดงรูปแรกของข่าว<br>
              <input type="radio" name="AMBulletBP" value="<?php if($R["AMBulletBP"] != "@first_news#"){ echo $R["AMBulletBP"]; } ?>"  <?php if($R["AMBulletBP"] != "@first_news#" AND $R["AMBulletBP"] != ""){ echo "checked"; } ?> onClick="topic1(this.value);"> 
              <a href="#pop" onClick="choose_pic('window.opener.document.form1.AMBulletBP[2].value','self.opener.parent.article_preview.document.all.img01');document.form1.AMBulletBP[2].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
              เลือกจากไฟล์ : 
              <?php if($R["AMBulletBP"] != "@first_news#"){ echo $R["AMBulletBP"]; } ?>
              </a></td>
  </tr>
  
  <tr valign="top">
    <td>ขนาดรูป (กว้างxยาว)</td>
    <td><input name="AMBulletBPW" type="text" size="2" value="<?php echo $R["AMBulletBPW"]; ?>">
              x 
              <input name="AMBulletBPH" type="text" size="2" value="<?php echo $R["AMBulletBPH"]; ?>"></td>
  </tr>
  <tr valign="top"  id="blockad">
    <td>นำเข้าไฟล์ Html สำหรับครอบ Design  :</td>
    <td><?php
			  if($R["code_html"] == "Y" AND file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/article/DA_".$_GET["aid"].".htm")){
			  ?>
              <div><a href="#pop" onClick="window.open('<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/article/DA_".$_GET["aid"].".htm"; ?>','','');">View 
                design</a></div>
              <?php
			  }
			  ?>
              <input name="file_html" type="file" id="file_html"> <br> <input name="cancelCode" type="checkbox" id="cancelCode" value="Y">
              ยกเลิกการใช้งานส่วนนี้ 
              <input type="hidden" name="code_html" value="<?php echo $R["code_html"]; ?>"></td>
  </tr>
  <tr valign="top">
    <td align="right"></td>
    <td><input name="applyto" type="checkbox" id="applyto" value="Y"> ต้องการใช้ดีไซต์นี้กับบทความอื่นๆ</td>
  </tr>
  <tr valign="top">
    <td align="right"></td>
    <td><input name="usedef" type="checkbox" id="usedef" value="Y"> ต้องการใช้ดีไซต์นี้เป็นมาตรฐานสำหรับหมวดข่าวใหม่ที่สร้างขึ้น </td>
  </tr>

</table></td>
          </tr>
        </table>
	
	    <table width="100%" border="0" cellspacing="1" cellpadding="3"  id="tr02" style="display:none">
          <tr bgcolor="#F7F7F7"  > 
            <td  ><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">ตั้งค่าทั่วไป</a></td>
                  <td width="90" align="center" background="../images/bg1_on90.gif">หมวดข่าว</td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('3')">หัวข้อข่าว</a>                  </td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">ส่วนล่างของข่าว 
                    </a> </td>
                  <td background="../images/bg2_off.gif">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td align="center" ><table width="80%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr valign="top"> 
    <td width="40%">&nbsp;</td>
    <td width="60%"><input type="checkbox" name="AMUseHead" value="Y" onClick="chkhead(this)" <?php if($R["AMUseHead"] == "Y"){ echo "checked"; } ?>>
    แสดงชื่อหมวดข่าว</td>
  </tr>
  <tr valign="top" id="headuse" <?php if($R["AMUseHead"] != "Y"){ echo "style=\"display:none\""; } ?>> 
    <td id="blockad">รูปแบบตัวอักษร : </td>
    <td id="blockad"><select name="AMHeadF" id="AMHeadF" onChange="ChF3(this.value,self.parent.article_preview.document.all.name01);">
                <?php $i = 0;
		 while($FontA[$i]){ ?>
                <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$R["AMHeadF"]){ echo "selected"; } ?>> 
                <?php echo $FontA[$i]; ?> </option>
                <?php $i++;
		 } ?>
              </select> <select name="AMHeadS" id="AMHeadS"  onChange="ch3(this.value,self.parent.article_preview.document.all.name01);">
                <option value="">none 
                <option value="8" <?php if($R["AMHeadS"]=="1"){ echo "selected"; } ?>>1 
                <option value="10" <?php if($R["AMHeadS"]=="2"){ echo "selected"; } ?>>2 
                <option value="12" <?php if($R["AMHeadS"]=="3"){ echo "selected"; } ?>>3 
                <option value="14" <?php if($R["AMHeadS"]=="4"){ echo "selected"; } ?>>4 
                <option value="18" <?php if($R["AMHeadS"]=="5"){ echo "selected"; } ?>>5 
                <option value="24" <?php if($R["AMHeadS"]=="6"){ echo "selected"; } ?>>6 
                <option value="36" <?php if($R["AMHeadS"]=="7"){ echo "selected"; } ?>>7 
              </select> <a id="CPreview2" style="background-color: <?php echo $R["AMHeadC"]; ?>" onClick="selColor('window.opener.document.form1.AMHeadC.value','window.opener.document.all.CPreview2.style.backgroundColor','window.opener.self.parent.article_preview.document.all.name01.style.color');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> 
              <input name="AMHeadC" type="text"  onBlur="CreColor(this.value,document.all.CPreview2,self.parent.article_preview.document.all.name01,'color');" value="<?php echo $R["AMHeadC"]; ?>" size=6 maxlength="7" > 
              <input name="AMHeadB" type="checkbox" value="Y" onClick="ChB3(this,self.parent.article_preview.document.all.name01);" <?php if($R["AMHeadB"]=="Y"){ echo "checked"; } ?>> 
              <strong>B</strong> <input name="AMHeadI" type="checkbox" value="Y" onClick="ChI3(this,self.parent.article_preview.document.all.name01);" <?php if($R["AMHeadI"]=="Y"){ echo "checked"; } ?>> 
              <em>I</em></td>
  </tr>
  <tr valign="top"  id="blockad" style="display:'<?php if($R["amd_mode"] == "html"){ echo "none"; } ?>'">
    <td>สีพื้นหลัง : </td>
    <td ><a id="CPreview1" style="background-color: <?php echo $R["AMHeadBG"]; ?>" onClick="selColor('window.opener.document.form1.AMHeadBG.value','window.opener.document.all.CPreview1.style.backgroundColor','window.opener.self.parent.article_preview.document.all.bg01.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> 
              <input name="AMHeadBG" type="text" id="AMHeadBG"  onBlur="CreColor(this.value,document.all.CPreview1,self.parent.article_preview.document.all.bg01,'bg');" value="<?php echo $R["AMHeadBG"]; ?>" size="6" maxlength="7" ></td>
  </tr>
  <tr valign="top" id="blockad"  style="display:'<?php if($R["amd_mode"] == "html"){ echo "none"; } ?>'">
    <td>รูปภาพพื้นหลัง : </td>
    <td ><input type="radio" name="AMHeadP" value="" onClick="changePic3(document.form1.AMHeadBG,self.parent.article_preview.document.all.bg01)" <?php if($R["AMHeadP"] == ""){ echo "checked"; } ?>>
              ไม่ใช้รูปภาพ<br> <input type="radio" name="AMHeadP" value="<?php echo $R["AMHeadP"]; ?>"  <?php if($R["AMHeadP"] != ""){ echo "checked"; } ?> onClick="topic2(this.value);"> 
              <a href="#pop" onClick="choose_bg('window.opener.document.form1.AMHeadP[1].value','self.opener.parent.article_preview.document.all.bg01');document.form1.AMHeadP[1].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
              เลือกจากไฟล์ : <?php echo $R["AMHeadP"]; ?></a></td>
  </tr>
  <tr valign="top"  id="blockad" style="display:'<?php if($R["amd_mode"] == "html"){ echo "none"; } ?>'">
    <td>ความสูงของส่วนบน :</td>
    <td><input name="AMHeadH" type="text" id="AMHeadH" value="<?php echo $R["AMHeadH"]; ?>" size="3" onBlur="chHH();"></td>
  </tr>
  <tr valign="top">
    <td>รูปประกอบหมวดข่าว : </td>
    <td><input type="radio" name="AMBulletSP" value="" onClick="changePic2('../images/o.gif',self.parent.article_preview.document.all.img02)" <?php if($R["AMBulletSP"] == ""){ echo "checked"; } ?>>
              ไม่ใช้รูปภาพ<br> <input type="radio" name="AMBulletSP" value="@first_news#" onClick="changePic2('../images/a_news_pic1.gif',self.parent.article_preview.document.all.img02)" <?php if($R["AMBulletSP"] == "@first_news#"){ echo "checked"; } ?>>
              แสดงรูปแรกของข่าว<br> <input type="radio" name="AMBulletSP" value="<?php if($R["AMBulletSP"] != "@first_news#"){ echo $R["AMBulletSP"]; } ?>"  <?php if($R["AMBulletSP"] != "@first_news#" AND $R["AMBulletSP"] != ""){ echo "checked"; } ?> onClick="topic3(this.value);"> 
              <a href="#pop" onClick="choose_pic('window.opener.document.form1.AMBulletSP[2].value','self.opener.parent.article_preview.document.all.img02');document.form1.AMBulletSP[2].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
              เลือกจากไฟล์ : 
              <?php if($R["AMBulletSP"] != "@first_news#"){ echo $R["AMBulletSP"]; } ?>
              </a></td>
  </tr>
  <tr valign="top"  style="display:'<?php if($R["amd_mode"] == "html"){ echo "none"; } ?>'">
    <td>ขนาด (กว้างxยาว) : </td>
    <td><input name="AMBulletSPW" type="text" size="2" value="<?php echo $R["AMBulletSPW"]; ?>">
              x 
              <input name="AMBulletSPH" type="text" size="2" value="<?php echo $R["AMBulletSPH"]; ?>"></td>
  </tr>
</table></td>
          </tr>
        </table>
	  
	  	<table width="100%" border="0" cellspacing="1" cellpadding="3"  id="tr03" style="display:none">
          <tr bgcolor="#F7F7F7"> 
            <td><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">ตั้งค่าทั่วไป</a></td>
                  <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">หมวดข่าว</a></td>
                  <td width="90" align="center" background="../images/bg1_on90.gif">หัวข้อข่าว                  </td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">ส่วนล่างของข่าว 
                    </a> </td>
                  <td background="../images/bg2_off.gif">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#FFFFFF" > 
            <td align="center"><table width="80%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr valign="top"> 
    <td width="40%">รูปภาพประกอบหัวข้อข่าว :</td>
    <td width="60%"><input type="radio" name="AMBodyBP" value="" onClick="changePic4('../images/o.gif',self.parent.article_preview.document.all.img03_1,self.parent.article_preview.document.all.img03_2)" <?php if($R["AMBodyBP"] == ""){ echo "checked"; } ?>>
              ไม่ใช้รูปภาพ<br> <input type="radio" name="AMBodyBP" value="@detail_news#" onClick="changePic4('../images/a_news_pic1.gif',self.parent.article_preview.document.all.img03_1,self.parent.article_preview.document.all.img03_2)" <?php if($R["AMBodyBP"] == "@detail_news#"){ echo "checked"; } ?>>
              แสดงรูปประกอบของข่าว<br> <input type="radio" name="AMBodyBP" value="<?php if($R["AMBodyBP"] != "@detail_news#"){ echo $R["AMBodyBP"]; } ?>"  <?php if($R["AMBodyBP"] != "@detail_news#" AND $R["AMBodyBP"] != ""){ echo "checked"; } ?> onClick="topic0(this.value);"> 
              <a href="#pop" onClick="choose_pic('window.opener.document.form1.AMBodyBP[2].value','self.opener.parent.article_preview.document.all.img03_1');document.form1.AMBodyBP[2].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
              เลือกจากไฟล์ : 
              <?php if($R["AMBodyBP"] != "@detail_news#"){ echo $R["AMBodyBP"]; } ?>
              </a></td>
  </tr>
  <tr valign="top" > 
    <td >ขนาดรูป (กว้างxยาว) : </td>
    <td ><input name="AMBodyBPW" type="text" size="2" value="<?php echo $R["AMBodyBPW"]; ?>">
              x 
              <input name="AMBodyBPH" type="text" size="2" value="<?php echo $R["AMBodyBPH"]; ?>"></td>
  </tr>
  <tr valign="top"   id="blockad">
    <td >สีพื้นหลัง : </td>
    <td ><a id="CPreview3" style="background-color: <?php echo $R["AMBodyBG"]; ?>" onClick="selColor('window.opener.document.form1.AMBodyBG.value','window.opener.document.all.CPreview3.style.backgroundColor','window.opener.self.parent.article_preview.document.all.bg02.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> <input name="AMBodyBG" type="text"  onBlur="CreColor(this.value,document.all.CPreview3,self.parent.article_preview.document.all.bg02,'bg');" value="<?php echo $R["AMBodyBG"]; ?>" size=6 maxlength="7" ></td>
  </tr>
  <tr valign="top"   id="blockad">
    <td >รูปแบบหัวข้อข่าว : </td>
    <td ><select name="AMBodyF" onChange="ChF4(this.value,self.parent.article_preview.document.all.name02_1,self.parent.article_preview.document.all.name02_2);">
                <?php $i = 0;
		 while($FontA[$i]){ ?>
                <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$R["AMBodyF"]){ echo "selected"; } ?>> 
                <?php echo $FontA[$i]; ?> </option>
                <?php $i++;
		 } ?>
              </select> <select name="AMBodyS"  onChange="ch4(this.value,self.parent.article_preview.document.all.name02_1,self.parent.article_preview.document.all.name02_2);">
                <option value="">none 
                <option value="8"   <?php if($R["AMBodyS"]=="1"){ echo "selected"; } ?>>1 
                <option value="10" <?php if($R["AMBodyS"]=="2"){ echo "selected"; } ?>>2 
                <option value="12" <?php if($R["AMBodyS"]=="3"){ echo "selected"; } ?>>3 
                <option value="14" <?php if($R["AMBodyS"]=="4"){ echo "selected"; } ?>>4 
                <option value="18" <?php if($R["AMBodyS"]=="5"){ echo "selected"; } ?>>5 
                <option value="24" <?php if($R["AMBodyS"]=="6"){ echo "selected"; } ?>>6 
                <option value="36" <?php if($R["AMBodyS"]=="7"){ echo "selected"; } ?>>7 
              </select> <a id="CPreview4_1" style="background-color: <?php echo $R["AMBodyC"]; ?>" onClick="selColor('window.opener.document.form1.AMBodyC.value','window.opener.document.all.CPreview4_1.style.backgroundColor','window.opener.self.parent.article_preview.document.all.name02_1.style.color');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> 
              <input name="AMBodyC" type="text"  onBlur="CreColor4(this.value,document.all.CPreview4_1,self.parent.article_preview.document.all.name02_1,self.parent.article_preview.document.all.name02_2,'color');" value="<?php echo $R["AMBodyC"]; ?>" size=6 maxlength="7" > 
              <input name="AMBodyB" type="checkbox" value="Y" onClick="ChB4(this,self.parent.article_preview.document.all.name02_1,self.parent.article_preview.document.all.name02_2);" <?php if($R["AMBodyB"]=="Y"){ echo "checked"; } ?>> 
              <strong>B</strong> <input name="AMBodyI" type="checkbox" value="Y" onClick="ChI4(this,self.parent.article_preview.document.all.name02_1,self.parent.article_preview.document.all.name02_2);" <?php if($R["AMBodyI"]=="Y"){ echo "checked"; } ?>> 
              <em>I</em></td>
  </tr>
  <tr valign="top" >
    <td >&nbsp;</td>
    <td ><input name="AMDate" type="checkbox" id="AMDate" onClick="chkdate(this)" value="Y" <?php if($R["AMDate"] == "Y"){ echo "checked"; } ?>>
              แสดงวันที่ท้ายข่าว</td>
  </tr>
  <tr valign="top" >
    <td >&nbsp;</td>
    <td ><input type="checkbox" name="AMUseDetail" value="Y" onClick="chkdetail(this)" <?php if($R["AMUseDetail"] == "Y"){ echo "checked"; } ?>>
              แสดงรายละเอียดข่าว</td>
  </tr>
  <tr valign="top"  id="detailuse" <?php if($R["AMUseDetail"] != "Y"){ echo "style=\"display:none\""; } ?>>
    <td  id="blockad">รูปแบบรายละเอียดข่าว :</td>
    <td  id="blockad"><select name="AMDetailF" onChange="ChF4(this.value,self.parent.article_preview.document.all.name05_1,self.parent.article_preview.document.all.name05_2);">
                <?php $i = 0;
		 while($FontA[$i]){ ?>
                <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$R["AMDetailF"]){ echo "selected"; } ?>> 
                <?php echo $FontA[$i]; ?> </option>
                <?php $i++;
		 } ?>
              </select> <select name="AMDetailS"  onChange="ch4(this.value,self.parent.article_preview.document.all.name05_1,self.parent.article_preview.document.all.name05_2);">
                <option value="">none 
                <option value="8"   <?php if($R["AMDetailS"]=="1"){ echo "selected"; } ?>>1 
                <option value="10" <?php if($R["AMDetailS"]=="2"){ echo "selected"; } ?>>2 
                <option value="12" <?php if($R["AMDetailS"]=="3"){ echo "selected"; } ?>>3 
                <option value="14" <?php if($R["AMDetailS"]=="4"){ echo "selected"; } ?>>4 
                <option value="18" <?php if($R["AMDetailS"]=="5"){ echo "selected"; } ?>>5 
                <option value="24" <?php if($R["AMDetailS"]=="6"){ echo "selected"; } ?>>6 
                <option value="36" <?php if($R["AMDetailS"]=="7"){ echo "selected"; } ?>>7 
              </select> <a id="CPreview4_2" style="background-color: <?php echo $R["AMDetailC"]; ?>" onClick="selColor('window.opener.document.form1.AMDetailC.value','window.opener.document.all.CPreview4_2.style.backgroundColor','window.opener.self.parent.article_preview.document.all.name05_1.style.color');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> 
              <input name="AMDetailC" type="text"  onBlur="CreColor4(this.value,document.all.CPreview4_1,self.parent.article_preview.document.all.name05_1,self.parent.article_preview.document.all.name05_2,'color');" value="<?php echo $R["AMDetailC"]; ?>" size=6 maxlength="7" > 
              <input name="AMDetailB" type="checkbox" value="Y" onClick="ChB4(this,self.parent.article_preview.document.all.name05_1,self.parent.article_preview.document.all.name05_2);" <?php if($R["AMDetailB"]=="Y"){ echo "checked"; } ?>> 
              <strong>B</strong> <input name="AMDetailI" type="checkbox" value="Y" onClick="ChI4(this,self.parent.article_preview.document.all.name05_1,self.parent.article_preview.document.all.name05_2);" <?php if($R["AMDetailI"]=="Y"){ echo "checked"; } ?>> 
              <em>I</em></td>
  </tr>
</table></td>
          </tr>
        </table>
	  
	  	  	
        <table width="100%" border="0" cellspacing="1" cellpadding="3"  id="tr04" style="display:none">
          <tr bgcolor="#F7F7F7"> 
            <td><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">ตั้งค่าทั่วไป</a></td>
                  <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">หมวดข่าว</a></td>
                  <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('3')">หัวข้อข่าว 
                    </a> </td>
                  <td width="90" align="center" background="../images/bg1_on90.gif">ส่วนล่างของข่าว                  </td>
                  <td background="../images/bg2_off.gif">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#FFFFFF"  > 
            <td align="center"><table width="80%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr valign="top"> 
    <td width="40%">ข้อความ Link ไปยังข่าวทั้งหมด :</td>
    <td width="60%"><input name="AMMORE" type="text" id="AMMORE" onBlur="inp(this.value,self.parent.article_preview.document.all.name03);" onChange="inp(this.value,self.parent.article_preview.document.all.name03);" onKeyUp="inp(this.value,self.parent.article_preview.document.all.name03);" value="<?php echo $R["AMMORE"]; ?>" size="40"></td>
  </tr>
  <tr valign="top" > 
    <td >รูปภาพประกอบข้อความ Link : </td>
    <td ><input type="radio" name="AMMorePic" value="" onClick="changePic2('../images/o.gif',self.parent.article_preview.document.all.img04)" <?php if($R["AMMorePic"] == ""){ echo "checked"; } ?>>
              ไม่ใช้รูปภาพ<br> <input type="radio" name="AMMorePic" value="<?php echo $R["AMMorePic"]; ?>"  <?php if($R["AMMorePic"] != ""){ echo "checked"; } ?> onClick="topic4(this.value);"> 
              <a href="#pop" onClick="choose_pic('window.opener.document.form1.AMMorePic[1].value','self.opener.parent.article_preview.document.all.img04');document.form1.AMMorePic[1].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
              เลือกจากไฟล์ : <?php echo $R["AMMorePic"]; ?></a> </td>
  </tr>
  <tr valign="top"  id="blockad">
    <td >รูปแบบข้อความ Link :</td>
    <td ><select name="AMBottomF" onChange="ChF3(this.value,self.parent.article_preview.document.all.name03);">
                      <?php $i = 0;
		 while($FontA[$i]){ ?>
                      <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$R["AMBottomF"]){ echo "selected"; } ?>> 
                      <?php echo $FontA[$i]; ?> </option>
                      <?php $i++;
		 } ?>
                    </select> <select name="AMBottomS"  onChange="ch3(this.value,self.parent.article_preview.document.all.name03);">
                      <option value="">none 
                      <option value="8" <?php if($R["AMBottomS"]=="1"){ echo "selected"; } ?>>1 
                      <option value="10" <?php if($R["AMBottomS"]=="2"){ echo "selected"; } ?>>2 
                      <option value="12" <?php if($R["AMBottomS"]=="3"){ echo "selected"; } ?>>3 
                      <option value="14" <?php if($R["AMBottomS"]=="4"){ echo "selected"; } ?>>4 
                      <option value="18" <?php if($R["AMBottomS"]=="5"){ echo "selected"; } ?>>5 
                      <option value="24" <?php if($R["AMBottomS"]=="6"){ echo "selected"; } ?>>6 
                      <option value="36" <?php if($R["AMBottomS"]=="7"){ echo "selected"; } ?>>7 
                    </select> <a id="CPreview5" style="background-color: <?php echo $R["AMBottomC"]; ?>" onClick="selColor('window.opener.document.form1.AMBottomC.value','window.opener.document.all.CPreview5.style.backgroundColor','window.opener.self.parent.article_preview.document.all.name03.style.color');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> 
                  <input name="AMBottomC" type="text"  onBlur="CreColor(this.value,document.all.CPreview5,self.parent.article_preview.document.all.name03,'color');" value="<?php echo $R["AMBottomC"]; ?>" size=6 maxlength="7" > 
                   <input name="AMBottomB" type="checkbox" value="Y" onClick="ChB3(this,self.parent.article_preview.document.all.name03);" <?php if($R["AMBottomB"]=="Y"){ echo "checked"; } ?>> 
                    <strong>B</strong> <input name="AMBottomI" type="checkbox" value="Y" onClick="ChI3(this,self.parent.article_preview.document.all.name03);" <?php if($R["AMBottomI"]=="Y"){ echo "checked"; } ?>> 
                    <em>I</em></td>
  </tr>
  <tr valign="top"  id="blockad">
    <td >รูปภาพพื้นหลัง :</td>
    <td ><input type="radio" name="AMBOTTOMP" value="" onClick="changePic3(document.form1.AMBOTTOMBG,self.parent.article_preview.document.all.bg04)" <?php if($R["AMBOTTOMP"] == ""){ echo "checked"; } ?>>
              ไม่ใช้รูปภาพ<br> <input type="radio" name="AMBOTTOMP" value="<?php echo $R["AMBOTTOMP"]; ?>"  <?php if($R["AMBOTTOMP"] != ""){ echo "checked"; } ?> onClick="topic5(this.value);"> 
              <a href="#pop" onClick="choose_bg('window.opener.document.form1.AMBOTTOMP[1].value','self.opener.parent.article_preview.document.all.bg04');document.form1.AMBOTTOMP[1].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
              เลือกจากไฟล์ : <?php echo $R["AMBOTTOMP"]; ?></a></td>
  </tr>
  <tr valign="top"   id="blockad">
    <td >สีพื้นหลัง :</td>
    <td ><a id="CPreview6" style="background-color: <?php echo $R["AMBOTTOMBG"]; ?>" onClick="selColor('window.opener.document.form1.AMBOTTOMBG.value','window.opener.document.all.CPreview6.style.backgroundColor','window.opener.self.parent.article_preview.document.all.bg04.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> <input name="AMBOTTOMBG" type="text"  onBlur="CreColor(this.value,document.all.CPreview6,self.parent.article_preview.document.all.bg04,'bg');" value="<?php echo $R["AMBOTTOMBG"]; ?>" size=6 maxlength="7" ></td>
  </tr>
  <tr valign="top"   id="blockad">
    <td >ความสูง : </td>
    <td ><input name="AMBOTTOMH" type="text" id="AMBOTTOMH" value="<?php echo $R["AMBOTTOMH"]; ?>" size="3" onBlur="chHTB();"></td>
  </tr>
</table></td>
          </tr>
        </table>
 	    <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr bgcolor="#FFFFFF"  > 
            <td colspan="4" align="right"> <strong> 
              <input name="aid" type="hidden" id="aid" value="<?php echo $_GET["aid"]; ?>">
              <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
              <input name="Flag" type="hidden" id="Flag" value="Design">
              <input type="submit" name="Submit" value="Save">
              </strong></td>
          </tr>
        </table>
	  
	  
	  </td>
  </tr></form>
</table>
  <form name="formPopUpBg" method="post" action="" target="bg_popup">
		<input name="o_value" type="hidden" id="o_value" value="">
        <input name="o_preview" type="hidden" id="o_preview" value="">
		<input name="stype" type="hidden" id="stype" value="images">
		<input name="Flag" type="hidden" id="Flag" value="">
	</form>
</body>
</html>
<?php
if($R[block_theme] != "" AND $R[block_theme] != "0"){
?>
<script language="JavaScript">
changeinterface("Y");
</script>
<?php } ?>
<?php $db->db_close(); ?>
