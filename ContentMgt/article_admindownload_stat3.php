<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
function cuttag($tag){
$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");

$detail = preg_replace ($search, $replace, $tag);
return $detail;
}
		if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}
		$_SESSION["EWT_OPEN_ARTICLE"] = "";



if($_GET[start_date] != '' && $_GET[end_date]!=''){
$st = stripslashes(htmlspecialchars(trim($_GET[start_date]),ENT_QUOTES));
$st = explode("/",$st );
$st = ($st[2] )."-".$st[1]."-".$st[0];
$ed = stripslashes(htmlspecialchars(trim($_GET[end_date]),ENT_QUOTES));
$ed = explode("/",$ed);
$ed = ($ed[2] )."-".$ed[1]."-".$ed[0];
$wh1 .= " (article_list.n_date  between '".$st."' AND '".$ed."'  ) AND";
}

$wh = substr($wh1,0,-3);
if($wh != ''){
$wh = "WHERE " .$wh."  and  news_use='4'  and n_owner ='".$_GET[n_owner]."'";
}
$sql_article = $db->query("SELECT news_view.news_id, count(news_view.id_view) AS count_view, article_list.n_topic,c_id
													FROM article_list  INNER JOIN news_view ON (article_list.n_id = news_view.news_id) $wh
													GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc  ");

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
$db->query("USE ".$EWT_DB_USER);
	$sql_user = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id = '".$_GET[n_owner]."'"));
	$name = $sql_user[name_thai].'  '.$sql_user[surname_thai];
	
	$db->query("use ".$EWT_DB_NAME);
?>

<span id="formtext"></span>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
	<span class="ewtfunction"><a href="article_admin_stat.php">รายงานการ Download ข่าว/บทความ</a> >> <a href="article_admin_stat2.php?search_word=<?php echo $_GET[search_word]; ?>&&start_date=<?php echo $_GET[start_date];?>&&end_date=<?php echo $_GET[end_date];?>"><?php echo $_GET[search_word];?></a> >>  <?php echo  $name;?></span></td>
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
    <form name="form2" method="post" action="article_admin_stat.php"  onSubmit="return CHK(this)" >
      <td><table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
        <tr>
          <td width="100%" bgcolor="#FFFFFF" class="ewttablehead">ระหว่างวันที่ <?php echo $start_date;?> ถึงวันที่ <?php echo $end_date;?></td>
        </tr>
      </table>
          <br>
      </td>
    </form>
  </tr>
</table>
<table width="94%" border="0" align="center">
  <tr>
    <td align="right">[ <a href="##G" onClick="window.open('article_admindownload_stat_mail.php?flag=3&&search_word=<?php echo $_GET[search_word]; ?>&&n_owner=<?php echo $_GET[n_owner]; ?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>', 'search_stat_viewdetail', 'status=no, menubar=no, scrollbars=no, resizable=no, height=150, width=300, left=150,top=100');">ส่งเมล์ </a>][ <a href="article_admin_stat_excel.php?flag=3&&search_word=<?php echo $_GET[search_word]; ?>&&n_owner=<?php echo $_GET[n_owner]; ?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" target="_blank" >ส่งออกเป็น excel</a> ] </td>
  </tr>
</table>
<table  width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td height="18" align="center">ชื่อข่าว/บทความ</td>
      <td width="20%" align="center">หมวด</td>
      <td width="10%" align="center">จำนวนผู้อ่าน</td>
      <td width="10%" align="center">เข้าชมครั้งสุดท้ายวันที่</td>
    </tr>
    <?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_article)){ 
	 if($db->check_permission("Ag","",$G[c_id])){
	 //group article
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
      <td align="center" ><?php echo number_format($G[count_view],0); ?></td>
      <td align="center" ><?php echo $day;?></td>
    </tr>
    <?php $i++; }} ?>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
</table>
<br>

</body>
</html>
<?php $db->db_close(); ?>
