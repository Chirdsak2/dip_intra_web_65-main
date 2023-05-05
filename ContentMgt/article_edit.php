<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$time_H = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');	
$time_s = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59');	

$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '".$_GET["nid"]."' ");
$R = $db->db_fetch_array($sql_edit);
$date = explode("-",$R["n_date"]);
$date1 = explode("-",$R["expire"]);
if($R["n_date_start"]!= '' && $R["n_date_end"] != ''){
$date_start = explode(" ",$R["n_date_start"]);
$time = explode(':',$date_start[1]);
$time_Hn_start = $time[0];
$time_sn_start = $time[1];
$date_start = explode("-",$date_start[0]);
$date_end = explode(" ",$R["n_date_end"]);
$time_end = explode(':',$date_end[1]);
$time_Hn_end = $time_end[0];
$time_sn_end = $time_end[1];
$date_end = explode("-",$date_end[0]);
$date_start = $date_start[2]."/".$date_start[1]."/".$date_start[0];
$date_end = $date_end[2]."/".$date_end[1]."/".$date_end[0];

}else{
$date_start  = '';
$date_end = '';
$time_Hn_start = '';
$time_sn_start = '';
$time_Hn_end = '';
$time_sn_end = '';
}
$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$R["c_id"]."' ");
	
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script language="JavaScript">
function chktime(c){
<?php
	if($R[n_time] != ""){ 
?>
var ntime = "<?php echo $R[n_time]; ?>";
<?php
 	}else{
	?>
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
	<?php
	}
?>

	if(c.checked == true){
		document.form1.time_n.style.display = '';
		document.form1.time_n.value = ntime;
	}else{
		document.form1.time_n.style.display = 'none';
		document.form1.time_n.value = "";
	}
}

function chk(){
	if(document.form1.topic.value == ""){
		alert("Please insert topic!!");
		document.form1.topic.focus();
		return false;
	}
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
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
<?php include("../FavoritesMgt/favorites_include.php");?>
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">บริหารข่าว/บทความ</span></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ("แก้ไขข่าว/บทความ: ".$R["n_topic"]); ?>&module=article&url=<?php echo urlencode ( "article_edit.php?nid=".$_GET["nid"]."&cid=".$R["c_id"]); ?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="article_list.php?cid=<?php echo $R["c_id"]; ?>"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> กลับหน้าก่อนหน้า</a>&nbsp;&nbsp;&nbsp;
<a href="article_group.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> หน้าหลัก</a>&nbsp;&nbsp;&nbsp;
<a href="article_new.php?cid=<?php echo $R["c_id"]; ?>"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่มข่าว/บทความ</a>
    <hr></td>
  </tr>
</table>
        <table width="90%" border="0" align="center" class="table table-bordered">
          <form name="form1" method="post" action="article_function.php" enctype="multipart/form-data" onSubmit="return chk();"><tr> 
            
      <td width="30%" valign="top" bgcolor="F7F7F7">หัวข้อ : <font color="#FF0000">*</font></td>
            <td width="70%" valign="top" bgcolor="#FFFFFF"><input class="form-control" style="width:80%;" name="topic" type="text" id="topic" value="<?php echo $R["n_topic"]; ?>" size="50"></td>
          </tr>
          <tr> 
            
      <td valign="top" bgcolor="F7F7F7">คำอธิบายหัวข้อข่าว : </td>
            <td valign="top" bgcolor="#FFFFFF"><textarea class="form-control" style="width:80%;" name="description" cols="50" rows="5" wrap="VIRTUAL" id="description"><?php echo $R["n_des"]; ?></textarea></td>
          </tr>
          <tr> 
            
      <td valign="top" bgcolor="F7F7F7">กลุ่ม : </td><?php
			$G = $db->db_fetch_array($sql_group);
			?>
            <td valign="top" bgcolor="#FFFFFF"><span id="txtshow"><?php echo $G[c_name]; ?></span>
        <a href="#browse" title="เลือกกลุ่ม" onClick="win2 = window.open('article_select.php?cid=<?php echo $_GET["cid"]; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle" ></a> 
        <input name="cid" type="hidden" id="cid" value="<?php echo $_GET["cid"]; ?>"></td>
          </tr>
          <tr> 
            
      <td valign="top" bgcolor="F7F7F7">วันที่ : </td>
            <td valign="top" bgcolor="#FFFFFF">
			<input class="form-control" style="width:20%;" name="date_n" type="text" id="date_n" value="<?php echo $date[2]."/".$date[1]."/".$date[0]; ?>" size="10" readonly="true"> 
              <a href="#date" onClick="return show_calendar('form1.date_n');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;"><img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle"></a>
			  
			   <input type="checkbox" name="checkbox" value="Y" onClick="chktime(this);" <?php if($R[n_time] != ""){ echo "checked"; } ?>>
              แสดงเวลา 
              <input class="form-control" style="width:20%;" name="time_n" type="text" id="time_n" size="8" style="display:<?php if($R[n_time] == ""){ echo "none"; } ?>" value="<?php echo $R[n_time]; ?>"></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="F7F7F7">กำหนดวันที่แสดงข่าว :
</td>
            <td valign="top" bgcolor="#FFFFFF">เริ่มต้น :
              <input class="form-control" style="width:20%;" name="date_start" type="text" id="date_start" value="<?php echo $date_start; ?>" size="10" readonly="true">
              <a href="#date" onClick="return show_calendar('form1.date_start');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;"><img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle"></a>  <label>
              <select name="time_H_start" class="form-control" style="width:10%;">
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_H);$i++){ ?>
			  <option value="<?php echo $time_H[$i];?>" <?php if($time_Hn_start == $time_H[$i]){ echo 'selected';} ?>><?php echo $time_H[$i];?></option>
			  <?php }?>
              </select>
              :
               <select name="time_s_start" class="form-control" style="width:10%;">
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_s);$i++){ ?>
			  <option value="<?php echo $time_s[$i];?>" <?php if($time_sn_start == $time_s[$i]){ echo 'selected';} ?>><?php echo $time_s[$i];?></option>
			  <?php }?>
              </select>
              นาที  </label><br><br>
			  สิ้นสุด :
              <input class="form-control" style="width:20%;"  name="date_end" type="text" id="date_end" value="<?php echo $date_end; ?>" size="10" readonly="true">
              <a href="#date" onClick="return show_calendar('form1.date_end');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;"><img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle"></a>
			       <select name="time_H_end" class="form-control" style="width:10%;">
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_H);$i++){ ?>
			  <option value="<?php echo $time_H[$i];?>" <?php if($time_Hn_end == $time_H[$i]){ echo 'selected';} ?>><?php echo $time_H[$i];?></option>
			  <?php }?>
              </select>
              :
             <select name="time_s_end" class="form-control" style="width:10%;">
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_s);$i++){ ?>
			  <option value="<?php echo $time_s[$i];?>" <?php if($time_sn_end == $time_s[$i]){ echo 'selected';} ?>><?php echo $time_s[$i];?></option>
			  <?php }?>
              </select>
        นาที <br><input type="checkbox" name="ctime" value="Y"> ยกเลิกการตั้งค่า
      </td>
          </tr>
		  <tr valign="top"> 
            
      <td bgcolor="F7F7F7"> 
        รูปประกอบ : </td>
            <td bgcolor="#FFFFFF">
          <?php
			if($R["picture"] != ""){
			?>
          <div align="left"><img src="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$_GET["nid"]."/".$R["picture"]; ?>" height="120"  border="0" align="absmiddle"> 
          </div>
          <?php
			}
			?><input type="file" name="file" class="form-control" style="width:40%;">
        <input name="pict" type="hidden" id="pict" value="<?php echo $R["picture"]; ?>">
		<?php
			if($R["picture"] != ""){
			?>
          
        <div align="left">
          <input type="checkbox" name="cpic" value="Y">
          ลบรูป</div>
          <?php
			}
			?>
		</td>
          </tr>
          <?php 
		  $Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/icon";
		  $objFolder = opendir($Current_Dir);
		  $i = 1;
		   ?>
		   <tr valign="top"> 
            <td bgcolor="F7F7F7"><p>Icon : </p>
            
			
			</td>
            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr> 
                  <td width="50%"><input type="radio" name="noicon" value="" <?php if($R[logo]==''){?>checked<?php } ?> onClick="
				   self.document.all.icon.value='';
				   self.document.all.iconname.innerHTML='No Icon File';
				   "><font color="#FF0000">No Icon Use</font><br>
				  <input type="hidden" name="icon" value="<?php echo $R[logo];?>">
				  <input type="hidden" name="icon2" value="<?php echo $R[logo];?>">
                    &nbsp; <font color="#FF0000"><span id="iconname"><?php if($R[logo]<>''){echo $R[logo];}else{?>No Icon File<?php } ?></span></font>
					<a href="#browse" title="เลือก Icon" onClick="win2 = window.open('article_icon.php?iconname='+window.form1.icon.value,'WebsiteLink','top=100,left=100,width=500,height=500,resizable=1,status=0,scrollbars=1');win2.focus();"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle" ></a>
				  </td>
				</tr>
              </table></td>
          </tr>
          <tr> 
            
      <td valign="top" bgcolor="F7F7F7">แสดง Icon ถึงวันที่: </td>
            <td valign="top" bgcolor="#FFFFFF">
			<input class="form-control" style="width:20%;" name="date_e" type="text" id="date_e" value="<?php echo $date1[2]."/".$date1[1]."/".$date1[0]; ?>" size="10" readonly="true"> 
              <a href="#date" onClick="return show_calendar('form1.date_e');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;"><img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle"></a></td>
          </tr>
		  <tr valign="top"> 
            <td bgcolor="F7F7F7">ที่มา/แหล่งข่าว : </td>
            <td bgcolor="#FFFFFF"><input class="form-control" style="width:40%;" name="source" type="text" id="source" value="<?php echo $R["source"]; ?>" size="60" onKeyUp="txt_data(this.value)"  autocomplete="off" ></td>
          </tr>
          <tr valign="top"> 
            <td bgcolor="F7F7F7">URL ของที่มา/แหล่งข่าว: </td>
            <td bgcolor="#FFFFFF"><input class="form-control" style="width:40%;" name="source_url" type="text" id="source_url" value="<?php echo $R["sourceLink"]; ?>" size="60"></td>
          </tr>
          <?php if($R["news_use"] == "2" || $R["news_use"] == "3"){ 
		  if($R["at_id"] == '10'){
		  $a_link = "../ewt/".$EWT_FOLDER_USER."/article_freestype.php";
		  }else  if($R["at_id"] == '11'){ 
		   $a_link = "article_detail.php";
		  }else{
		  $a_link = "article_detail.php";
		  }
		  ?>

<tr valign="top"> 
<td bgcolor="F7F7F7">รายละเอียด: </td>
<td bgcolor="#FFFFFF">&nbsp;<a href="#news" onClick="self.location.href='<?php echo $a_link;?>?nid=<?php echo $R["n_id"]; ?>';"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> <font color="#FF3300">แก้ไขรายละเอียดข่าว</font></a></td>
</tr>
		  
<tr valign="top"> 
<td bgcolor="F7F7F7">วิดีโอ: </td>
<td bgcolor="#FFFFFF">&nbsp;<a href="#news" onClick="self.location.href='article_video.php?nid=<?=$R['n_id'];?>';"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> <font color="#FF3300">แก้ไขวิดีโอ</font></a></td>
</tr>
		  
		  		   <tr valign="top"> 
		  <td bgcolor="F7F7F7">เอกสารแนบ: </td>
            <td bgcolor="#FFFFFF">&nbsp;<a href="article_upload_file.php?n_id=<?php echo $R["n_id"]; ?>&cid=<?php echo $R["c_id"]?>" ><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> <font color="#FF3300">แก้ไขเอกสารแนบ</font></a></td>
          </tr>
		  <tr>
		  <td bgcolor="F7F7F7">target: </td>
            <td bgcolor="#FFFFFF">&nbsp;
					<select name="target" class="form-control" style="width:20%;" >
                <option value="_blank" <?php if($R[target] == "_blank"){ echo "selected"; } ?>>เปิดหน้าต่างใหม่</option>
				<option value="_self" <?php if($R[target] == "_self"){ echo "selected"; } ?>>เปิดหน้าต่างเดิม</option>
              </select></td>
          </tr>
		  <?php
		  $sql_comment = "SELECT * FROM news_comment  WHERE news_id LIKE '$R[n_id]' AND status_comment LIKE 'Y' ORDER BY id_ans DESC";
		   $query_comment  = mysql_query($sql_comment);
		   $num_rows = mysql_num_rows($query_comment);
		   if ($num_rows >0){
		  ?>
          <tr valign="top">
            
      <td bgcolor="F7F7F7">ดูความเห็น:</td>
            <td bgcolor="#FFFFFF">&nbsp;<a href="#news" onClick="self.location.href='ewt_view_comment.php?nid=<?php echo $R["n_id"]; ?>';"><img src="../theme/main_theme/g_comment.png" width="16" height="16" border="0" align="absmiddle"> 
              <font color="#FF3300">ดูคำวิจารณ์ข่าว/บทความ</font></a></td>
          </tr>		 
		  <?php }?>
		   
          <?php }elseif($R["news_use"] == "4"){ 
		  	$sqldl = $db->query("SELECT * FROM download_list WHERE dl_gid = '".$_GET["nid"]."'");
			$DL = $db->db_fetch_array($sqldl);
		  ?>
		  <tr> 
            
      <td valign="top" bgcolor="F7F7F7">เอกสาร Download</td>
            <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr valign="top"> 
                  <td rowspan="3" bgcolor="F7F7F7"><img src="../theme/main_theme/arrow_r.gif" width="7" height="7" align="absmiddle"> 
                    Link :</td>
		          <td valign="top" bgcolor="#FFFFFF">
				  <input type="file" name="filedl" class="form-control" style="width:20%;" />
				  <input type="hidden" name="olddl_file" value="<?php echo $DL["dl_sysfile"]; ?>">
				  </td>
	          </tr>
                <tr valign="top">
                  <td bgcolor="#FFFFFF">
				  <input class="form-control" name="chk_member" type="checkbox" id="chk_member" value="Y" <?php if($DL[dl_name] == "Y"){ echo "checked"; } ?>>                    
                  Download ได้เฉพาะสมาชิก</td>
                </tr>
                <tr valign="top">
                  <td bgcolor="#FFFFFF">
				  <input class="form-control" type="checkbox" name="chk_show_count" value="2" <?php if($R[show_count] == "2"){ echo "checked"; } ?>>
                   แสดงจำนวนการดาวน์โหลด[ครั้ง]</td>
                </tr>
				
                <tr valign="top"> 
                  <td bgcolor="F7F7F7"><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> 
                    Target :</td>
                  <td valign="top" bgcolor="#FFFFFF">
				  <select name="select" class="form-control" style="width:20%;">
                    <option value="_self" <?php if($R[target] == "_self"){ echo "selected"; } ?>>_self</option>
                    <option value="_blank" <?php if($R[target] == "_blank"){ echo "selected"; } ?>>_blank</option>
                  </select></td>
                </tr>
              </table></td>
          </tr>
		  <?php }else{ ?>
          <tr> 
            
      <td valign="top" bgcolor="F7F7F7"> URL รายละเอียดข่าว</td>
            <td valign="top" bgcolor="#FFFFFF">
			<table width="100%" border="0" class="table table-bordered">
  <tr valign="top"> 
                  <td rowspan="3" bgcolor="F7F7F7"><img src="../theme/main_theme/arrow_r.gif" width="7" height="7" align="absmiddle"> 
                    Link :</td>
		    <td valign="top" bgcolor="#FFFFFF">
			<input class="form-control" style="width:16px;"  name="browsefile" type="radio" value="1" checked="checked"></td>
            <td valign="top" bgcolor="#FFFFFF">
			<input class="form-control" style="width:80%;"name="link" type="text" id="link" value="<?php echo $R["link_html"]; ?>" size="45"> 
			<a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.form1.link.value','WebsiteLink','top=100,left=100,width=660,height=500,resizable=1,status=0');document.form1.browsefile[0].checked=true;win2.focus();	"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a> <input type="hidden" name="hdd_file" value="<?php echo $R["link_html"]; ?>"></td>
			</tr>
			<tr valign="top">
                  <td bgcolor="#FFFFFF"><input class="form-control" style="width:16px;" name="browsefile" type="radio" value="2"></td>
                  <td bgcolor="#FFFFFF"><input class="form-control" style="width:80%;" type="file" name="filebrowse"  onClick="document.form1.browsefile[1].checked=true"></td>
            </tr>
            <tr valign="top">
                  <td bgcolor="#FFFFFF">&nbsp;</td>
                  <td bgcolor="#FFFFFF"><input class="form-control" style="width:16px;"  type="checkbox" name="chk_show_count_level1" value="3" <?php if($R[show_count] == "3"){ echo "checked"; } ?>>  แสดงจำนวนการดาวน์โหลด[ครั้ง]</td>
            </tr>
            <tr valign="top"> 
                  <td bgcolor="F7F7F7"><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> 
                    Target :</td>
            <td colspan="2" valign="top" bgcolor="#FFFFFF">
			<select name="target" class="form-control" style="width:20%;">
                      <option value="_self" <?php if($R[target] == "_self"){ echo "selected"; } ?>>_self</option>
                      <option value="_blank" <?php if($R[target] == "_blank"){ echo "selected"; } ?>>_blank</option>
                    </select></td>
              </tr>
              </table></td>
          </tr>
          <?php } ?>
          <tr> 
            <td valign="top" bgcolor="F7F7F7">&nbsp;</td>
            <td valign="top" bgcolor="#FFFFFF">
			<input type="submit" name="Submit" value="Submit" class="btn btn-success" /> 
            <input type="reset" name="Submit2" value="Reset" class="btn btn-warning" 
			  onClick="self.document.all.iconname.innerHTML=window.form1.icon2.value;"> 
			  <input name="Flag" type="hidden" id="Flag" value="EditArticle"> 
              <input name="nid" type="hidden" id="nid" value="<?php echo $_GET["nid"]; ?>">
			  <input name="nuse" type="hidden" id="nuse" value="<?php echo $R["news_use"]; ?>"></td>
          </tr></form>
</table>
        <br>

</body>
</html>
<?php
	closedir($objFolder);
 	$db->db_close(); ?>
