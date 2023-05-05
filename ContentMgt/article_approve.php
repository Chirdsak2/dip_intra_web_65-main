<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$db->query("USE ".$EWT_DB_USER);
$ptype = "Ag";
$ppms = "a";
if($_SESSION["EWT_SMTYPE"] == "Y"){
	$glo_sql = "WHERE 1 ";
}else{
	  $sql_supadmin = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' AND (s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id != '0' ) ",$EWT_DB_USER);
	$glo_sql = "WHERE ( 0 ";
	while($G = $db->db_fetch_row($sql_supadmin)){
	$y = 0;
		$glo_sql .= " OR c_id = '".$G[0]."' ";
		to_child($G[0]);
	}
	$glo_sql .= " ) ";
}
//	echo $glo_sql;
	$db->query("USE ".$_SESSION["EWT_SDB"]);

function to_child($cid){
 global $db;
 global $glo_sql,$EWT_DB_USER;
 $db->query("USE ".$_SESSION["EWT_SDB"]);
	$sqlc = $db->query("SELECT c_id FROM article_group WHERE c_parent = '".$cid."' ");
	while($cr = $db->db_fetch_row($sqlc)){
		$glo_sql .= " OR c_id = '".$cr[0]."' ";
		to_child($cr[0]);
	}
	$db->query("USE ".$EWT_DB_USER);
 }

 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
if(empty($limit)){
$limit = 20;
}

	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">อนุมัติข่าว/บทความ</span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ( "อนุมัติข่าว/บทความ"); ?>&module=article&url=<?php echo urlencode ( "article_approve.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form2" method="get" action="article_approve.php" ><td>
                              ค้นหา Article :
        <input name="search_txt" type="text" value="<?php echo $_GET["search_txt"];?>" size="50" class="form-control" style="width:30%;"/>
        <input type="submit" name="Submit" value="ค้นหา" class="btn btn-success"/>
		<input name="serach_flag" type="hidden" value="<?php echo $_POST["serach_flag"];?>">
</td>
    </form>
  </tr>
</table>
<?php
	$sql_query = "SELECT n_id,n_topic,n_date,n_new_modi,n_last_modi,n_owner,news_use,n_share,n_shareuse,n_sharename,n_approve,c_id,link_html FROM article_list ".$glo_sql." AND ( n_approve IS NULL OR n_approve = '' ) and n_id != '' ";
		if($_GET["search_txt"] != ""){
		$sql_query .= " AND n_topic REGEXP '".$_GET["search_txt"]."' ";
		}
		$sql_article = $sql_query." ORDER BY n_id DESC LIMIT $offset,$limit ";
	 $sql_article = $db->query($sql_article);
?>
<table width="94%" border="0" align="center" class="table table-bordered">
  <form name="form1" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="AppArticle">
    <input type="hidden" name="backto" value="article_approve.php">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
	<td width="3%" align="center" >&nbsp;</td>
      <td width="4%" align="center" >วันที่</td>
      <td width="51%"  height="18" align="center" >หัวข้อข่าว/บทความ</td>
      <td width="9%" align="center" >ผู้สร้าง</td>
      <td width="4%" align="center" >สร้าง</td>
      <td width="5%" align="center" >แก้ไข</td>
      <td width="6%" align="center" >อนุมัติ</td>
    </tr>
    <?php
	$i = 0;
	$rows = $db->db_num_rows($db->query($sql_query));
		  $nu = $rows-$offset;
	 while($N = $db->db_fetch_array($sql_article)){ 
	$date = explode("-",$N["n_date"]);
	if($N["n_new_modi"] != ''){
	$n_new_modi_Y=substr($N["n_new_modi"], 0, 4);    
	$n_new_modi_M=substr($N["n_new_modi"], 4, 2);   
	$n_new_modi_D=substr($N["n_new_modi"], 6, 2);   
	$date_create_f =$n_new_modi_D."/".$n_new_modi_M."/".($n_new_modi_Y+543);
	}else{
	$date_create_f  = '-';
	}
	if($N["n_last_modi"] != '' && $N["n_new_modi"] != ''){
	$n_last_modi_Y=substr($N["n_last_modi"], 0, 4);    
	$n_last_modi_M=substr($N["n_last_modi"], 4, 2);   
	$n_last_modi_D=substr($N["n_last_modi"], 6, 2);   
	$date_modi_f = $n_last_modi_D."/".$n_last_modi_M."/".($n_last_modi_Y+543);
	}else{
	$date_modi_f  ='-';
	}
	if($N["n_owner"] == 0 || $N["n_owner"] == ''){
	$owner = 'Web Admin';
	}else{
	$db->query("USE ".$EWT_DB_USER);
	$sql_chk = "SELECT name_thai,surname_thai
							FROM
							  `gen_user`
							  where  gen_user_id ='".$N["n_owner"]."'  ";
	$query = $db->query($sql_chk);
	$rec = $db->db_fetch_array($query);
	$db->query("USE ".$EWT_DB_NAME);
	$owner = $rec[name_thai].'   '.$rec[surname_thai];
	}
	$group_text = "";

			 $sql_gname = $db->query("SELECT c_name FROM article_group WHERE c_id = '".$N["c_id"]."' ");
			 $GN = $db->db_fetch_row($sql_gname);
			 $group_text = "<div><a href=\"#article\" onClick=\"self.location.href='article_list.php?cid=".$N["c_id"]."';\"><img src=\"../theme/main_theme/g_folder_closed.gif\" alt=\"news folder\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\"> ".$GN[0]."</a></div>";

	?>
    <tr bgcolor="#FFFFFF" > 
	<td height="20" align="center" valign="top" nowrap>
	<?php
	$path_news="";
	if($N["news_use"] == "2" OR $N["news_use"] == "3" OR $N["news_use"] == "4"){
			$path_news= "../ewt/".$_SESSION[EWT_SUSER]."/ewt_news.php?nid=".$N["n_id"] ;
	}else{
			if(eregi('http://',$N["link_html"])){
			      $path_news= $N["link_html"];
			}else{
				 $path_news= "../ewt/".$_SESSION[EWT_SUSER]."/".$N["link_html"];
			}
	}
	
	?>
	<a href="#view" onClick="window.open('<?php echo $path_news; ?>');"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" align="absmiddle" alt="ดูข้อมูล"></a>
	</td>
      <td height="20" align="center" valign="top"><?php echo $date[2]."/".$date[1]."/".$date[0]; ?></td>
      <td height="20" valign="top" > 
        <img src="../theme/main_theme/g_document.gif" alt="News" width="16" height="16" align="absmiddle">
        <?php if($N["n_shareuse"] != "Y"){ echo $N["n_topic"]; }else{ ?>
        <img src="../images/share.gif" width="20" height="20" border="0" align="absmiddle"> 
        <font color="#666666"><?php echo $N["n_topic"]; ?></font> [From:<?php echo $N["n_sharename"]; ?>] 
        <?php } ?><?php echo  $group_text; ?></td>
		<td height="20" align="center" valign="top"><?php echo $owner; ?></td>
      <td height="20" align="center" valign="top"><?php echo $date_create_f; ?></td>
      <td height="20" align="center" valign="top"><?php echo $date_modi_f; ?></td>
      <td height="20" align="center" valign="top"  > 
        <input name="app<?php echo $i; ?>" type="checkbox" id="app<?php echo $i; ?>" value="Y" <?php if($N["n_approve"] == "Y"){ echo "checked"; } ?>>
        <input name="nid<?php echo $i; ?>" type="hidden" id="nid<?php echo $i; ?>" value="<?php echo $N["n_id"]; ?>"> 
      </td>
    </tr>
    <?php $i++;$nu--; }?>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
    <tr bgcolor="#FFFFFF"> 
      <td height="30" colspan="6">&nbsp;</td>
      <td height="30" align="center"><input type="submit" name="Submit" value="อนุมัติ" >
	  </td>
	<?php if($rows > 0){ ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="30" colspan="10"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>หน้าที่ 
        :</strong></font> 
        <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&cid=".$_GET["cid"]."&search_type=$search_type&search_txt=$search_txt'>
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
                  echo  "<a href='$PHP_SELF?offset=$newoffset&cid=".$_GET["cid"]."&search_type=$search_type&search_txt=$search_txt' ". 
                  " ><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">&nbsp;$i&nbsp;</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&cid=".$_GET["cid"]."&search_type=$search_type&search_txt=$search_txt'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
    }
?>      </td>
    </tr>
	<?php } ?>
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>