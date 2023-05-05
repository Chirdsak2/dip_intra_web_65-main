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
$wh1 .= "  (date_view  between '".$st."' AND '".$ed."'  ) AND";
}

$wh = substr($wh1,0,-3);
/*if($wh != ''){
$wh = "WHERE " .$wh."  and  n_owner =".$_GET[n_owner];
}*/
//set for old
 $db->query("USE db_00_stat_visitor");
 $table = base64_decode ( $_REQUEST["db"]);
  $db_table = explode("EX",$table);
   $sql_list= "select * from list_name where list_id ='".$db_table[0]."' order by list_id ASC";
   $query_list = $db->query($sql_list);
   $R_list = $db->db_fetch_array($query_list);
   $name_list = $R_list["list_name"];
$sql_article = $db->query("select count(news_id) as count_view,news_id from ".$db_table[1]." where  date_view $wh
													group by news_id order by count_view DESC ");

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
/*$disabled1='style="display:none"';
$disabled2='style="display:none"';
if($db->check_permission('art','w','')){ $disabled1='';}
if($db->check_permission('art','a','')){ $disabled2=''; }
$db->query("USE ".$_SESSION["EWT_SDB"]);
$db->query("use ewt_user_default");
	$sql_user = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id = '".$_GET[n_owner]."'"));
	$name = $sql_user[name_thai].'  '.$sql_user[surname_thai];
	
	$db->query("use ".$EWT_DB_NAME);*/
?>

<span id="formtext"></span>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
	<span class="ewtfunction"><a href="article_admin_stat.php">รายงานการใช้งานข่าว/บทความ</a> >> <a href="article_admin_stat2.php?search_word=<?=$_GET[search_word]; ?>&&start_date=<?php echo $_GET[start_date];?>&&end_date=<?php echo $_GET[end_date];?>"><?php echo $_GET[search_word];?></a> >>  <?php echo  $name;?></span></td>
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
    <form name="form2" method="post" action="article_admin_stat3.php"  onSubmit="return CHK(this)" >
      <td> <table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
         <tr>
           <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ระหว่างวันที่</td>
          </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">วันที่ :<span class="style1">*</span> </td>
           <td width="73%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" value="<?php echo $_POST[start_date];?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>
			 ถึงวันที่ <input name="end_date" type="text" size="15" value="<?php echo $_POST[end_date];?>">
             <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a></td>
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
<table width="94%" border="0" align="center">
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<?php 	if($_REQUEST[flag]=='search'){  ?>
<table  width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td height="18" align="center">ชื่อข่าว/บทความ</td>
      <td width="20%" align="center">หมวด</td>
      <td width="10%" align="center">จำนวนผู้อ่าน</td>
    </tr>
    <?php

	$i = 0;
	
	 while($G = $db->db_fetch_array($sql_article)){ 
	 $nid =$G[news_id];
	  $db->query("USE ".$EWT_DB_NAME);
	   //group article
	 $sql_art = "select * from article_list where n_id = '".$nid."'";
	 $query_art = $db->query($sql_art);
	 $rec_art = $db->db_fetch_array($query_art);
	 $articleName = $rec_art[n_topic];
	 //group article
	 $sql_g = "select * from article_group where c_id = '".$rec_art[c_id]."'";
	 $query_g = $db->query($sql_g);
	 $rec_g = $db->db_fetch_array($query_g);
	 $groupName = $rec_g[c_name];
	  $db->query("USE db_00_stat_visitor");
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> 
      <?php echo $articleName; ?></td>
      <td height="25"><?php echo $groupName;?></td>
      <td align="center" ><?php echo number_format($G[count_view],0); ?></td>
    </tr>
    <?php $i++; } ?>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
</table>
<?php } ?>

</body>
</html>
<?php $db->db_close(); ?>
