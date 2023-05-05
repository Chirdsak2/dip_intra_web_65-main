<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}
		$_SESSION["EWT_OPEN_ARTICLE"] = "";
if($limit == ''){
$limit  = 10;
$list_limit = "limit 0,".$limit;
$lablereting = '('.$limit."อันดับ)";
}else if($limit == 'total'){
$limit  = '';
$list_limit = '';
$lablereting = '';
}else{
$list_limit = "limit 0,".$limit;
$lablereting =  '('.$limit."อันดับ)";
}
if($_POST[article_s_name] != ''){
		$data_default = stripslashes(htmlspecialchars(trim($_POST[article_s_name]),ENT_QUOTES));
		$acticle_name = $data_default;
		$acticle_name = str_replace('+',' \"+\"',$acticle_name);
		$acticle_name = str_replace('*','\"*\"',$acticle_name);
$wh1 .= " (article_list.n_topic REGEXP '".$acticle_name."' or article_list.n_des REGEXP '".$acticle_name."') AND";
}
if($_POST[start_date] != '' && $_POST[end_date]!=''){
$st = stripslashes(htmlspecialchars(trim($_POST[start_date]),ENT_QUOTES));
$st = explode("/",$st);
$st = ($st[2] )."-".$st[1]."-".$st[0];
$ed = stripslashes(htmlspecialchars(trim($_POST[end_date]),ENT_QUOTES));
$ed = explode("/",$ed);
$ed = ($ed[2] )."-".$ed[1]."-".$ed[0];
$wh1 .= "  (article_list.n_date  between '".$st."' AND '".$ed."'  ) AND";
}
if($_POST[start_date] == '' && $_POST[end_date]!=''){
$ed = stripslashes(htmlspecialchars(trim($_POST[end_date]),ENT_QUOTES));
$ed = explode("/",$ed);
$ed = ($ed[2] )."-".$ed[1]."-".$ed[0];
$wh1 .= "  (article_list.n_date  between '".$ed."' AND '".$ed."'  ) AND";
}
if($_POST[start_date] != '' && $_POST[end_date]==''){
$st = stripslashes(htmlspecialchars(trim($_POST[start_date]),ENT_QUOTES));
$st = explode("/",$st );
$st = ($st[2] )."-".$st[1]."-".$st[0];
$wh1 .= "  (article_list.n_date  between '".$st."' AND '".$st."'  ) AND";
}
if($_POST[article_gruop] != ''){
$article_gruop = $_POST[article_gruop];
$wh1 .= "  article_list.c_id = '".$article_gruop."' AND";
}
$wh = substr($wh1,0,-3);
if($wh != ''){
$wh = "WHERE " .$wh;
}
$lablereting = $limit."อันดับ";
$db->write_log("view","article","เข้าสู่ Module Article");
$sql_article = $db->query("SELECT sum(point)/count(news_id) as rating ,n_topic,news_id,c_id,count(news_id) as count_view
											FROM  article_list  INNER JOIN news_vote ON (article_list.n_id = news_vote.news_id) $wh
											GROUP BY  news_id
											ORDER BY rating DESC  $list_limit");
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script language="JavaScript">
//self.parent.document.all.backon.style.display = 'none';
//self.parent.document.all.backoff.style.display = '';
//self.parent.document.all.folderoff.style.display = 'none';
//self.parent.document.all.folderon.style.display = '';
//self.parent.document.all.deloff.style.display = 'none';
//self.parent.document.all.delon.style.display = '';
			 function chkKeyFo(c){
			 		if(event.keyCode == 13){
						create_fo(c);
					}
			 }
			 function create_fo(c){
				if(c.value == ""){
					document.all.new_fo.style.display = 'none';
				}else{
					var gname = c.value;
					document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"article_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateFolder\"><input name=\"gname\" type=\"hidden\" id=\"gname\" value=\""+ gname + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
					createform.submit();

				}
			}
			function CHK(t){
	if(t.search_txt.value == '' && t.date_s.value == '' && t.date_e.value == ''){
	alert("กรุณาระบุเงื่อนไขการค้นหา!!!!!!!!!!!");
	return false;
	}else{
	return true;
	}
	return false;
	}
		function gotosubmit(){
	form2.submit();
	}
</script>
</head>
<body leftmargin="0" topmargin="0">

<?php 
$disabled1='style="display:none"';
$disabled2='style="display:none"';
if($db->check_permission('art','w','')){ $disabled1='';}
if($db->check_permission('art','a','')){ $disabled2=''; }
$db->query("USE ".$_SESSION["EWT_SDB"]);
?>

<span id="formtext"></span>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ข่าว/บทความที่มีคะแนน vote สูงสุด(<?php echo $lablereting;?>)</span> </td>
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
    <form name="form2" method="post" action="article_vote_stat.php"  >
      <td> <table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
         <tr>
           <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ค้นหา</td>
          </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">ชื่อข่าว/บทความ :</td>
           <td width="73%" bgcolor="#FFFFFF"><input name="article_s_name" type="text" size="50" value="<?php echo $_POST[article_s_name];?>"></td>
         </tr>
         <tr>
           <td align="right" bgcolor="#FFFFFF">หมวด : </td>
           <td bgcolor="#FFFFFF">
		   <select name="article_gruop">
		   <option value="">--ทั้งหมด--</option>
		   <?php
		   $sql_gr = "select * from article_group ";
		   $query = $db->query($sql_gr);
		   while($rec_gr=$db->db_fetch_array($query)){
		   ?>
		   <option value="<?php echo $rec_gr[c_id];?>" <?php if($_POST[article_gruop]==$rec_gr[c_id]){ echo 'selected';}?>><?php echo substr($rec_gr[c_name], 0, 50);?></option>
		   <?php 
		   }
		   ?>
           </select>           </td>
         </tr>
         <tr>
           <td align="right" bgcolor="#FFFFFF">วันที่สร้างข่าว/บทความ : </td>
           <td bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" value="<?php echo $_POST[start_date];?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>  
             ถึง 
             <input name="end_date" type="text" size="15"  value="<?php echo $_POST[end_date];?>">
             <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a> </td>
         </tr>
         <tr>
           <td align="right" bgcolor="#FFFFFF">แสดง : </td>
           <td bgcolor="#FFFFFF"><select name="limit"  >
          <option value="10" <?php if($_POST[limit]=='10'){ echo 'selected';}?>>10</option>
          <option value="20" <?php if($_POST[limit]=='20'){ echo 'selected';}?>>20</option>
          <option value="30" <?php if($_POST[limit]=='30'){ echo 'selected';}?>>30</option>
		  <option value="40" <?php if($_POST[limit]=='40'){ echo 'selected';}?>>40</option>
		  <option value="50" <?php if($_POST[limit]=='50'){ echo 'selected';}?>>50</option>
          <option value="total" <?php if($_POST[limit]=='total'){ echo 'selected';}?>>ทั้งหมด</option>
        </select>
       อันดับ </td>
         </tr>
         <tr>
           <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="ค้นหา"></td>
          </tr>
       </table><br>
</td>
    </form>
  </tr>
</table>
<table  width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <form name="form1" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td height="18" align="center">ชื่อข่าว/บทความ</td>
      <td align="center">หมวด</td>
      <td width="20%" align="center">คะแนน</td>
      <td width="20%" align="center">เข้าชมครั้งสุดท้ายวันที่</td>
    </tr>
    <?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_article)){ 
	 if($db->check_permission("Ag","",$G[c_id])){
	 $sql_g = "select * from article_group where c_id = '".$G[c_id]."'";
	 $query_g = $db->query($sql_g);
	 $rec_g = $db->db_fetch_array($query_g);
	 $groupName = $rec_g[c_name];
	 	 //date view leter
	 $sql_day = "select date_view from news_view where news_id = '".$G[news_id]."' order by date_view DESC ";
	 $query_day= $db->query($sql_day);
	 $rec_day= $db->db_fetch_array($query_day);
	 $day = $rec_day[date_view];
	 $day = explode('-',$day);
	 $day = $day[2].'/'.$day[1].'/'.($day[0]+543);
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> 
      <?php echo $G[n_topic]?></td>
      <td height="25"><?php echo $groupName;?></td>
      <td align="center" ><?php echo number_format($G[rating],0); ?></td>
      <td align="center" ><?php echo $day;?></td>
    </tr>
    <?php $i++; }} ?>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
  </form>
</table>
<br>

</body>
</html>
<?php $db->db_close(); ?>
