<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$array_type = array('article','banner','poll','servey','webboard','enews','faq','Gallery','Language Setting ','login','logout','uploadfile','rss','Images','menu','WebBlock','sitemap','ebook','complain','guesbook','calendar','member','Vulgar');
		  $arr_text["article"] = "ข่าว/บทความ";
		  $arr_text["banner"] = "การจัดการป้ายโฆษณา ";
		  $arr_text["poll"] = "การจัดการแบบสำรวจ ";
		  $arr_text["servey"] = "Form Generator";
		  $arr_text["webboard"] = "webboard";
		  $arr_text["enews"] = "การจัดการจดหมายข่าว ";
		  $arr_text["faq"] = "FAQ";
		  $arr_text["Gallery"] = "การจัดการห้องแสดงภาพ ";
		  $arr_text["Language Setting "] = "Language Setting ";
		  $arr_text["login"] = "Login";
		  $arr_text["logout"] = "Logout";
		  $arr_text["uploadfile"] = "My Download ";
		  $arr_text["rss"] = "การจัดการ RSS Reader";
		  $arr_text["Images"] = "My Gallery";
		  $arr_text["menu"] = "บริหารเมนู";
		   $arr_text["WebBlock"] = "WebBlock Management";
		   $arr_text["sitemap"] = "การจัดการผังเว็บไซต์";
		   $arr_text["ebook"] = "E-Book Management";
		   $arr_text["complain"] = "Complain Management";
		   $arr_text["guesbook"] = "การจัดการสมุดเยี่ยมชม";
		   $arr_text["calendar "] = "การจัดการปฏิทินกิจกรรม online";
		    $arr_text["member"] = "การจัดการสมาชิก";
			$arr_text["Vulgar "] = "การตั้งค่าคำไม่สุภาพ";
			$arr_text["save"] = "การจัดการหน้าเว็บ";
			
			if($_GET["orderby"]!=''){
				 $orderby=$_GET["orderby"];
				  if($_GET["adesc"]=='DESC'){  $adesc='ASC';  }else{  $adesc='DESC';  }
				  $orderby_now = 'ORDER BY  '.$orderby.'  '.$adesc.",log_date DESC,log_time DESC";
			}else{
				$orderby_now = "ORDER BY  log_date DESC,log_time DESC";
			}
//set for old
 $db->query("USE db_00_stat_visitor");
 $table = base64_decode ( $_REQUEST["db"]);
  $db_table = explode("EX",$table);
   $sql_list= "select * from list_name where list_id ='".$db_table[0]."' order by list_id ASC";
   $query_list = $db->query($sql_list);
   $R_list = $db->db_fetch_array($query_list);
   $name_list = $R_list["list_name"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script language="javascript1.2">
function orderby(field,adesc){
     
     location.href='view_log.php?orderby='+field+'&adesc='+adesc+'&start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&module=<?php echo  $_REQUEST["module"];?>&flag=search';
}
function CHK(t){
	if(t.start_date.value == ''){
	alert('กรุณาเลือกวันที่ ที่ต้องการ!!!!!!');
	return false;
	}
	if(t.end_date.value == ''){
	alert('กรุณาเลือกวันที่ ที่ต้องการ!!!!!!');
	return false;
	}
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<?
$thisyear = date("Y")+543;
?>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ติดตามการเข้าใช้ระบบ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form2" method="post" action="view_log_old.php"  onSubmit="return CHK(this)" >
      <td> <table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
         <tr>
           <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ค้นหา</td>
          </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">วันที่ :<span class="style1">*</span> </td>
           <td width="73%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" value="<?php echo $_REQUEST[start_date];?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>
			 ถึงวันที่ <input name="end_date" type="text" size="15" value="<?php echo $_REQUEST[end_date];?>">
             <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a></td>
         </tr>
         <tr>
           <td align="right" bgcolor="#FFFFFF">แสดงตามmodule : </td>
           <td bgcolor="#FFFFFF"><select name="module"  >
          <option value="">---ทั้งหมด---</option>
          <option value="article" <?php if($_REQUEST[module]=='article'){ echo 'selected';}?>>ข่าว/บทความ</option>
		  <option value="banner" <?php if($_REQUEST[module]=='banner'){ echo 'selected';}?>>การจัดการป้ายโฆษณา </option>
		  <option value="poll" <?php if($_REQUEST[module]=='poll'){ echo 'selected';}?>>การจัดการแบบสำรวจ </option>
		  <option value="servey" <?php if($_REQUEST[module]=='servey'){ echo 'selected';}?>>Form Generator</option>
		  <option value="webboard" <?php if($_REQUEST[module]=='webboard'){ echo 'selected';}?>>webboard</option>
		  <option value="enews" <?php if($_REQUEST[module]=='enews'){ echo 'selected';}?>>การจัดการจดหมายข่าว </option>
		  <option value="faq" <?php if($_REQUEST[module]=='faq'){ echo 'selected';}?>>faq</option>
		  <option value="gallery" <?php if(strtolower($_REQUEST[module])=='gallery'){ echo 'selected';}?>>การจัดการห้องแสดงภาพ </option>
		  <option value="Language Setting" <?php if($_REQUEST[module]=='Language Setting'){ echo 'selected';}?>>Language Setting </option>
		  <option value="login" <?php if($_REQUEST[module]=='login'){ echo 'selected';}?>>Login</option>
		  <option value="logout" <?php if($_REQUEST[module]=='logout'){ echo 'selected';}?>>Logout </option>
		  <option value="uploadfile" <?php if($_REQUEST[module]=='uploadfile'){ echo 'selected';}?>>My Download  </option>
		  <option value="rss" <?php if($_REQUEST[module]=='rss'){ echo 'selected';}?>>การจัดการ RSS Reader </option>
		  <option value="Images" <?php if($_REQUEST[module]=='Images'){ echo 'selected';}?>>My Gallery </option>
		  <option value="menu" <?php if($_REQUEST[module]=='menu'){ echo 'selected';}?>>บริหารเมนู </option>
		   <option value="WebBlock" <?php if($_REQUEST[module]=='WebBlock'){ echo 'selected';}?>>WebBlock Management  </option>
		   <option value="sitemap" <?php if($_REQUEST[module]=='sitemap'){ echo 'selected';}?>>การจัดการผังเว็บไซต์ </option>
		   <option value="ebook" <?php if($_REQUEST[module]=='ebook'){ echo 'selected';}?>>E-Book Management </option>
		   <option value="complain" <?php if($_REQUEST[module]=='complain'){ echo 'selected';}?>>Complain Management </option>
		   <option value="guesbook" <?php if($_REQUEST[module]=='guesbook'){ echo 'selected';}?>>การจัดการสมุดเยี่ยมชม </option>
		   <option value="calendar" <?php if($_REQUEST[module]=='calendar'){ echo 'selected';}?>>การจัดการปฏิทินกิจกรรม online </option>
		    <option value="member" <?php if($_REQUEST[module]=='member'){ echo 'selected';}?>>การจัดการสมาชิก </option>
			<option value="vulgar" <?php if(strtolower($_REQUEST[module])=='vulgar'){ echo 'selected';}?>>การตั้งค่าคำไม่สุภาพ  </option>
			<option value="save" <?php if(strtolower($_REQUEST[module])=='save'){ echo 'selected';}?>>สร้างหน้าเพจ </option>
		   </select></td>
         </tr>
         <tr>
           <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="ค้นหา">
            <input type="hidden" name="flag" value="search"><input type="hidden" name="db" value="<?php echo $_REQUEST["db"]; ?>"></td>
          </tr>
       </table>
      <br>
</td>
    </form>
  </tr>
</table> 
<? if($_REQUEST[flag]=='search'){ 
	
		if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != '' ){
			$st = stripslashes(htmlspecialchars(trim($_REQUEST[start_date]),ENT_QUOTES));
			$st = explode("/",$st );
			$st = ($st[2] - 543 )."-".$st[1]."-".$st[0];
			$et = stripslashes(htmlspecialchars(trim($_REQUEST[end_date]),ENT_QUOTES));
			$et = explode("/",$et );
			$et = ($et[2] - 543 )."-".$et[1]."-".$et[0];
			$wh1 .= "  (log_date  between '".$st."' AND '".$et."'  ) AND";
		}
		if($_REQUEST[module] == 'save'){
		$wh1 .= "  ((log_module  like '".$_REQUEST[module]."' or log_module  like '%approve%'  or log_module  like '%update%' ) and (log_module_detail not  IN ('".implode ( "','",$array_type)."') )) AND";
		}else if($_REQUEST[module] != ''){
			$wh1 .= "  (log_module_detail  like '".$_REQUEST[module]."' ) AND";
		}
		$wh = substr($wh1,0,-3);
		if($wh != ''){
		$wh = "where " .$wh;
		}
		//$db->write_log("view","View log","ดูรายงานการติดตามการเข้าใช้ระบบ วันที่ ".$_REQUEST[start_date]);
		$graph_name = array();
		$graph_data = array();
		//echo "SELECT  log_module_detail,COUNT(log_module_detail) AS cd  FROM log_user $wh GROUP BY log_module_detail ORDER BY cd desc";
		$sqlg = $db->query("SELECT  log_module_detail as detail,COUNT(log_module_detail) AS cd  FROM ".$db_table[1]." $wh GROUP BY log_module_detail ORDER BY cd desc");
	while($G = mysql_fetch_row($sqlg)){
	//echo $G[0];
		if($arr_text[$G[0]] != ""){
				array_push($graph_name,$arr_text[$G[0]]);
				array_push($graph_data,$G[1]);
		}else{
			array_push($graph_name,'หน้าเว็บเพจ :'.$G[0]);
			array_push($graph_data,$G[1]);
		}
	}
	//print_r($graph_name);
?>
<table  width="80%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
	<tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td  align="center" bgcolor="#FFFFFF"><?php
	  				$graph_height  = "1500";
  				$graph_width  = "850";
				$graph_group = "Y";
				$graph_rotate = "";
				//include("../ewt_graph_include.php");
	  ?><table width="100%" border="0">
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td>Module</td>
    <td>จำนวน</td>
  </tr><?php
	for($i=0;$i<count($graph_name);$i++){
	?>
  <tr>
    <td><?php echo $graph_name[$i]; ?> </td>
    <td><?php echo $graph_data[$i]; ?> </td>
  </tr>
	<?
	}
	?></table></td>
  </tr>
</table>
</td>
    </tr>
</table>
<table  width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
	<tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="10%" height="18" align="center">วันที่</td>
      <td width="10%" align="center">เวลา</td>
      <td width="10%" align="center">IP</td>
      <td width="10%" align="center"><a href="javascript:orderby('log_user','<?php echo $adesc;?>')">ผู้ใช้</a><?php if($adesc == 'ASC'){?><img src="../images/bar_down.gif" align="absmiddle"><?php }else  if($adesc == 'DESC'){ ?><img src="../images/bar_up.gif" align="absmiddle"><?php } ?></td>
      <td width="60%" align="center">รายละเอียด</td>
    </tr>
	<?php
 $sql = $db->query("SELECT * FROM ".$db_table[1]." $wh $orderby_now ");
	while($R = mysql_fetch_array($sql)){
	//
	$db->query("USE ewt_user_default");
	$selete_user="SELECT  * 
                          FROM
  `gen_user`
  LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) 
  LEFT OUTER JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  Where  gen_user.gen_user LIKE '$R[log_user]'  ";
			$exec_user=$db->query($selete_user);
			$rst_user = $db->db_fetch_array($exec_user);
	$db->query("USE ".$EWT_DB_NAME);
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><?php echo $R[log_date];?></td>
      <td align="center" ><?php echo $R[log_time];?></td>
      <td  align="center" ><?php echo $R[log_ip];?></td>
      <td align="center" ><? echo $rec[title_thai]." ".$rst_user[name_thai]."&nbsp;&nbsp;".$rst_user[surname_thai]; ?>[<a href="##" onClick="window.open('view_profile.php?gen_user=<?=$R[log_user]; ?>', 'select_org', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');"><?php echo $R[log_user];?></a>]</td>
      <td ><?php echo $R[log_detail];?></td>
    </tr>
	<?php } ?>
</table>
<?php } ?>
</body>
</html>
<?php
$db->db_close(); ?>
