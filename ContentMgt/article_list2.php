<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
		if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}
		$_SESSION["EWT_OPEN_ARTICLE"] = $_GET["cid"];
		function countchild($c){
global $db;

$sql = $db->query("SELECT c_id FROM article_group WHERE c_parent = '$c'   ");
$x = 0;
  while($U = $db->db_fetch_array($sql)){
	$c = countchild($U["c_id"]);
	$x += $c;
	$x++;
  }
  return $x;
}
function countchild2($c){
global $db;

$sql = $db->query("SELECT c_id FROM article_group WHERE c_parent = '$c'   ");
$x = 0;
  while($U = $db->db_fetch_array($sql)){
	$c = countchild2($U["c_id"]);
	$x += $c;
	$sql2 = $db->query("SELECT COUNT(n_id) FROM article_list WHERE c_id = '".$U["c_id"]."' ");
	$C = $db->db_fetch_row($sql2);
	$x += $C[0];
  }
  return $x;
}
$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$_GET["c_id"]."'");
$G = $db->db_fetch_array($sql_group);

$sql_group2 = $db->query("SELECT * FROM article_group WHERE c_name REGEXP '".$_GET["search_txt"]."'");

 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
if(empty($limit)){
$limit = 20;
}

//$sql_article = $db->query("SELECT n_id,n_topic,n_date,news_use,n_share,n_shareuse,n_sharename,n_approve FROM article_list WHERE c_id = '".$_GET["cid"]."' ORDER BY n_date DESC,n_timestamp DESC");
	
	if(!empty($_GET["search_txt"])){
		$pkw = explode(" ",trim($_GET["search_txt"]));
		$sum = count($pkw);
		//$wh = ",article_detail";
		//$seld .= " AND article_list.n_id = article_detail.n_id AND ";
		$seld .= " AND ( ";
			for($q = 0;$q<$sum;$q++){
					if($q ==0){
					 $seld .= "  (n_topic REGEXP  '$pkw[$q]' OR n_des REGEXP  '$pkw[$q]'   )";
					}else{
					 $seld .= "  OR (n_topic REGEXP  '$pkw[$q]' OR n_des REGEXP  '$pkw[$q]'   )";
					}
			}
			$seld .= " ) ";
		}
		$date_st = explode("/",$_GET["date_s"]);
		$date_en = explode("/",$_GET["date_e"]);
		$date_1 = ($date_st[2])."-".$date_st[1]."-".$date_st[0];
		$date_2 = ($date_en[2])."-".$date_en[1]."-".$date_en[0];
		if(!empty($_GET["date_s"]) && !empty($_GET["date_e"])){
		 $seld .= "  AND (n_date  between   '".$date_1."' and '".$date_2."' ) ";
		}else if(!empty($_GET["date_s"]) && empty($_GET["date_e"])){
		$seld .= "  AND (n_date  between   '".$date_1."' and '".$date_1."' ) ";
		}else if(empty($_GET["date_s"]) && !empty($_GET["date_e"])){
		$seld .= "  AND (n_date  between   '".$date_2."' and '".$date_2."' ) ";
		}
	if($_GET[c_id] != ''){
	$wha = " and article_list.c_id = '".$_GET[c_id]."' ";
	}
	$sql_query = "SELECT n_id,n_topic,n_date,news_use,n_share,n_shareuse,n_sharename,n_approve,c_id FROM article_list $wh WHERE 1=1 $seld $wha ORDER BY n_date DESC,n_timestamp DESC";
		$sql_article = $sql_query." LIMIT $offset,$limit ";
	 $sql_article = $db->query($sql_article);
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
/*self.parent.document.all.backoff.style.display = 'none';
self.parent.document.all.backon.style.display = '';
self.parent.document.all.folderon.style.display = 'none';
self.parent.document.all.folderoff.style.display = '';
self.parent.document.all.deloff.style.display = 'none';
self.parent.document.all.delon.style.display = ''; */
function sharing(){
document.form1.Flag.value = "Share";
form1.action = "article_share.php";
form1.submit();
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
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php 
//$disabled1='style="display:none"';
$disabled2='style="display:none"';
if($db->check_permission('art','w','')){ $disabled1='';}
if($db->check_permission('art','a','')){ $disabled2=''; }
?> 
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ค้นหาข่าว/บทความ  <?php echo $G["c_name"]; ?></span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="article_group.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> หน้าหลัก</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="article_new.php?cid=<?php echo $_GET["c_id"]; ?>"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มข่าว/บทความ</a><hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form2" method="get" action="article_list2.php"  onSubmit="return CHK(this)"><td>
                              ค้นหา Article :
                              <input type="text" name="search_txt" value="<?php echo $_GET["search_txt"];?>">
วันที่ :
<input name="date_s" type="text" size="11" value="<?php echo $_GET["date_s"];?>">
<img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('date_s', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> ถึง
<input name="date_e" type="text" size="11" value="<?php echo $_GET["date_e"];?>">
<img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('date_e', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">
<input type="submit" name="Submit" value="ค้นหา"><input name="serach_flag" type="hidden" value="<?php echo $_GET["serach_flag"];?>">
<input name="c_id" type="hidden" id="c_id" value="<?php echo $_GET["c_id"]; ?>">
                                                        </td></form>
  </tr>
</table>
<table  width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <form name="form11" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="13%" height="18" align="center">&nbsp;</td>
      <td  width="61%" height="18" align="center">ชื่อกลุ่มข่าว/บทความ</td>
      <td  width="8%" align="center">ภาษาอื่น</td>
      <td width="8%" align="center" <?php echo $disabled2;?>>แสดง RSS<a href="#help_01">*</a><br></td>
      <td width="10%" align="center"  <?php echo $disabled1;?>>ลบ</td>
    </tr>
    <?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_group2)){ 
	 if($db->check_permission("Ag","",$G[c_id])){
	$S_count = $db->query("SELECT COUNT(n_id) FROM article_list WHERE c_id = '$G[c_id]' "); 
	$C = $db->db_fetch_row($S_count);
			
		if($G["c_rss"]=='Y'){
		     $checked= "checked";
			 $filename="../ewt/".$_SESSION["EWT_SUSER"]."/rss/group".$G["c_id"].".xml";
			 if(file_exists($filename)){
			     $link='<a href="../ewt/'.$_SESSION["EWT_SUSER"].'/rss/group'.$G["c_id"].'.xml" target="_blank"><img src="../theme/main_theme/g_rss.gif" border="0" alt="ดูข้อมูล RSS"> </a>';
			 }else{
			     $link='';
			 }
			 
		}else{
		    $checked=''; $link='';
		}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td><nobr><a href="article_list.php?cid=<?php echo $G["c_id"]; ?>"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" align="absmiddle" alt="ดูข้อมูล"></a> 
        <a href="article_gedit.php?cid=<?php echo $G["c_id"]; ?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle" alt="แก้ไขหมวดข่าว/บทความ"></a> 
        <a href="#A" onClick="txt_data('<?php echo $G["c_id"]; ?>','')"><img id="lang<?php echo $G["c_id"]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a>
		<?php echo $link;?></nobr></td>
      <td height="25" valign="top"> <img src="../theme/main_theme/g_folder_closed.gif" alt="news folder" width="16" height="16" align="absmiddle"><a href="#article" onClick="self.location.href='article_list.php?cid=<?php echo $G["c_id"]; ?>';"> 
        <?php echo $G["c_name"]; ?> <font color="#666666">[group : <?php echo number_format(countchild($G["c_id"]),0); ?>  news : <?php echo number_format($C[0] + countchild2($G["c_id"]),0); ?>]</font></a>      </td>
      <td height="25" valign="top"><?php echo show_icon_lang($G["c_id"],'article_group');?></td>
      <td align="center" <?php echo $disabled2;?>> 
        <?php if($db->check_permission("Ag","w",$G[c_id])){ ?>
        <input name="chkrss<?php echo $i; ?>" type="checkbox" id="chkrss<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>" <?php echo $checked; ?>> 
        <input name="chkrssH<?php echo $i; ?>" type="hidden" id="chkrssH<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>"> 
        <?php } ?>      </td>
      <td width="10%" align="center" <?php echo $disabled1;?>> 
        <?php if($db->check_permission("Ag","w",$G[c_id])){ ?>
        <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>"> 
        <?php } ?>      </td>
    </tr>
    <?php $i++; }} ?>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3" valign="top">&nbsp;<a id="#bottom"></a></td>
      <td align="center"  <?php echo $disabled2;?>>
        <?php if($db->check_permission("Ag","w",$G[c_id])){ ?>
        <input name="button" type="button" onClick="document.form1.Flag.value='SetRSS'; document.form1.submit();" value="ตั้งค่า">
        <?php } ?>      </td>
      <td width="10%" align="center"  <?php echo $disabled1;?>>
        <?php if($db->check_permission("Ag","w",$G[c_id])){ ?>
        <input type="button" name="Button" value="ลบกลุ่ม" onClick="if(confirm('Are you sure to delete selected group?')){ form1.submit(); }">
    <?php } ?>    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3" valign="top"><span class="ewtnormal"><a name="help_01"></a>* 
        เลือก RSS เป็นการกำหนดให้ข่าวกลุ่มนั้นมีการส่งออกเป็นไฟล์ XML ตามมาตรฐาน 
        RSS ได้</span></td>
      <td align="center"  <?php echo $disabled2;?>>&nbsp;</td>
      <td align="center"  <?php echo $disabled1;?>>&nbsp;</td>
    </tr>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
  </form>
</table>

<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#808080"  class="ewttableuse">
  <form name="form1" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="DelArticle">
    <input name="cid" type="hidden" id="cid" value="<?php echo $_GET["cid"]; ?>">
    <input type="hidden" name="backto" value="article_group.php">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="5%" style="display:none" height="18" align="center"  <?php echo $disabled1;?>><input type="button" name="Button" value="Share" onClick="sharing();"></td>
      <td width="48%"  height="18" align="center" >หัวข้อข่าว/บทความ</td>
      <td width="15%" align="center" >กลุ่มข่าว/บทความ</td>
      <td width="9%" align="center"  <?php echo $disabled1;?> style="display:none">Share 
        Article</td>
      <td width="9%" align="center" >วันที่</td>
      <td width="5%" align="center"  <?php echo $disabled2;?>>อนุมัติ</td>
      <td width="9%" align="center"  <?php echo $disabled1;?>>ลบ</td>
    </tr>
    <?php
	$i = 0;
	$rows = mysql_num_rows($db->query($sql_query));
		  $nu = $rows-$offset;
	 while($N = $db->db_fetch_array($sql_article)){ 
	$date = explode("-",$N["n_date"]);
	?>
    <tr bgcolor="#FFFFFF" > 
      <td height="20" align="center" valign="middle" bgcolor="#FFFFFF" <?php echo $disabled1;?>  style="display:none"> 
        <?php if($N["n_share"] != "Y" AND $N["n_shareuse"] != "Y"){ ?>
        <input name="share<?php echo $i; ?>" type="checkbox" id="share<?php echo $i; ?>" value="<?php echo $N["n_id"]; ?>"> 
        <?php } ?>
      </td>
      <td height="20" valign="top" bgcolor="#FFFFFF" > <img src="../theme/main_theme/g_document.gif" alt="News" width="16" height="16" align="absmiddle"> 
        <?php if($N["n_shareuse"] != "Y"){ ?>
        <a href="#article" onClick="self.location.href='article_edit.php?nid=<?php echo $N["n_id"]; ?>&cid=<?php echo $_GET["cid"]; ?>';"> 
        <?php echo $N["n_topic"]; ?></a> 
        <?php  }else{ ?>
        <img src="../images/share.gif" width="20" height="20" border="0" align="absmiddle"> 
        <font color="#666666"><?php echo $N["n_topic"]; ?></font> [From:<?php echo $N["n_sharename"]; ?>] 
        <?php } ?>      </td>
      <td height="20" align="center" valign="top" bgcolor="#FFFFFF" ><a href="article_list.php?cid=<?php echo $N[c_id]; ?>">
        <?php
	  $sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$N[c_id]."'");
	  $G = $db->db_fetch_array($sql_group);
	  echo $G["c_name"]; 
	  ?></a></td>
      <td height="20" align="center" bgcolor="#FFFFFF" <?php echo $disabled1;?> style="display:none"> 
        <?php if($N["n_share"] == "Y"){ ?>
        <a href="#change" onClick="win2=window.open('article_share_news.php?nid=<?php echo $N["n_id"]; ?>','change','width=400,height=500,resizable=1,scrollbars=1');"><img src="../images/bar_share.gif" width="20" height="20" border="0"></a> 
        <?php } ?>
        <?php if($N["n_shareuse"] == "Y"){ ?>
        <img src="../images/share.gif" width="20" height="20" border="0"> 
        <?php } ?>      </td>
      <td height="20" align="center" valign="top" bgcolor="#FFFFFF"><?php echo $date[2]."/".$date[1]."/".$date[0]; ?></td>
      <td height="20" align="center" valign="top" bgcolor="#FFFFFF"  <?php echo $disabled2;?>> 
        <?php if($db->check_permission("Ag","a",$_GET["cid"])){ ?>
        <input name="app<?php echo $i; ?>" type="checkbox" id="app<?php echo $i; ?>" value="Y" <?php if($N["n_approve"] == "Y"){ echo "checked"; } ?>> 
        <input name="nid<?php echo $i; ?>" type="hidden" id="nid<?php echo $i; ?>" value="<?php echo $N["n_id"]; ?>"> 
        <?php } ?>
      </td>
      <td align="center" valign="top" bgcolor="#FFFFFF" <?php echo $disabled1;?>> 
        <?php if($db->check_permission("Ag","w",$_GET["cid"])){ ?>
        <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $N["n_id"]; ?>"> 
        <?php } ?>
      </td>
    </tr>
    <?php $i++;$nu--; } ?>
    <tr bgcolor="#FFFFFF"> 
      <td valign="top" bgcolor="#FFFFFF" <?php echo $disabled1;?>  style="display:none">&nbsp;<a id="#bottom"></a></td>
      <td colspan="3" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
      <td align="center" valign="top" bgcolor="#FFFFFF" <?php echo $disabled2;?>><input type="button" name="Button" value="อนุมัติ" onClick="document.form1.Flag.value='AppArticle';form1.submit();"></td>
      <td align="center" bgcolor="#FFF9F9" <?php echo $disabled1;?>><input type="submit" name="Submit" value="   ลบ   "></td>
    </tr bgcolor="#FFFFFF">
    <tr bgcolor="#FFFFFF"> 
      <td height="30" colspan="7"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>หน้าที่ 
        :</strong></font> 
        <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&serach_flag=".$_GET["serach_flag"]."&search_txt=".$_GET["search_txt"]."&date_s=".$_GET["date_s"]."&date_e=".$_GET["date_e"]."&c_id=".$_GET["c_id"]."'>
<font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ก่อนหน้า</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($rows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($rows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">&nbsp;[$i]&nbsp;</font>\n\n"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&serach_flag=".$_GET["serach_flag"]."&search_txt=".$_GET["search_txt"]."&date_s=".$_GET["date_s"]."&date_e=".$_GET["date_e"]."&c_id=".$_GET["c_id"]."' "." ><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">&nbsp;$i&nbsp;</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&serach_flag=".$_GET["serach_flag"]."&search_txt=".$_GET["search_txt"]."&date_s=".$_GET["date_s"]."&date_e=".$_GET["date_e"]."&c_id=".$_GET["c_id"]."'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
    }
?>
      </td>
    </tr>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
