<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//==============================================================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($serach_flag){ $serach_flag=checkPttVar($serach_flag); }
	if($_GET["serach_flag"]){ $_GET["serach_flag"]=checkPttVar($_GET["serach_flag"]); }
	if($_POST["serach_flag"]){ $_POST["serach_flag"]=checkPttVar($_POST["serach_flag"]); }
	if($_REQUEST["serach_flag"]){ $_REQUEST["serach_flag"]=checkPttVar($_REQUEST["serach_flag"]); }
	
	if($cid){ $cid = checkNumeric($cid); }
	if($_GET["cid"]){ $_GET["cid"] = checkNumeric($_GET["cid"]); }
	if($_POST["cid"]){ $_POST["cid"] = checkNumeric($_POST["cid"]); }
	
	if($date_e){ $date_e = checkDates($date_e); }
	if($_GET["date_e"]){ $_GET["date_e"] = checkDates($_GET["date_e"]); }
	if($_POST["date_e"]){ $_POST["date_e"] = checkDates($_POST["date_e"]); }
	if($_REQUEST["date_e"]){ $_REQUEST["date_e"] = checkDates($_REQUEST["date_e"]); }
	
	if($date_s){ $date_s = checkDates($date_s); }
	if($_GET["date_s"]){ $_GET["date_s"] = checkDates($_GET["date_s"]); }
	if($_POST["date_s"]){ $_POST["date_s"] = checkDates($_POST["date_s"]); }
	if($_REQUEST["date_s"]){ $_REQUEST["date_s"] = checkDates($_REQUEST["date_s"]); }
	
	if($search_txt){ $search_txt = checkPttSearch($search_txt); }
	if($_GET["search_txt"]){ $_GET["search_txt"] = checkPttSearch($_GET["search_txt"]); }
	if($_POST["search_txt"]){ $_POST["search_txt"] = checkPttSearch($_POST["search_txt"]); }
	if($_REQUEST["search_txt"]){ $_REQUEST["search_txt"] = checkPttSearch($_REQUEST["search_txt"]); }
	//================================================================================================
	
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$temp = "SELECT * FROM design_list WHERE d_id = '".$F["template_id"]."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);
$design_id = $R["d_id"];
	?>
<html>
<head>
<title>More News</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/calendar-th.js"></script>
<?php
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $R["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $R["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $R["d_top_height"]; ?>" bgcolor="<?php echo $R["d_top_bg_c"]; ?>" background="<?php echo $R["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $R["d_site_left"]; ?>" bgcolor="<?php echo $R["d_left_bg_c"]; ?>" background="<?php echo $R["d_left_bg_p"]; ?>">
		  <?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $R["d_site_content"]; ?>" bgcolor="<?php echo $R["d_body_bg_c"]; ?>" height="160" background="<?php echo $R["d_body_bg_p"]; ?>">
	<?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		<?php } ?>      
      <table width="90%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td><font size="4" face="Tahoma"><strong><?php
	 $sql_group ="select * from  article_group where c_id = '".$_GET["cid"]."'";
	 $query_group = $db->query($sql_group);
	 $U = $db->db_fetch_array($query_group);
	 echo " <br><a href=\"index.php\">หน้าหลัก</a> >><a href=\"more_news.php?cid=".$_GET["cid"]."&filename=index\"> ".$U[c_name]."</a>>>ข่าว/บทความทั้งหมด";
	 ?></strong></font> 
            <hr size="1">          </td>
        </tr>
        <tr>
          <td><form name="form1" method="post" action="?cid=<?php echo $cid;?>&filename=<?php echo $filename;?>">
            <table width="60%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="30%"><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><strong>ค้นหา :</strong></font></td>
                <td width="70%"><input type="text" name="search_txt" value="<?php echo $_REQUEST["search_txt"];?>"></td>
              </tr>
              <tr>
                <td><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><strong>วันที่ :</td>
                <td><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><strong><input name="date_s" type="text" size="11" value="<?php echo $_REQUEST["date_s"];?>">
                  <img src="../../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('date_s', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">
                  ถึง
                  <input name="date_e" type="text" size="11" value="<?php echo $_REQUEST["date_e"];?>">
                  <img src="../../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('date_e', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"></strong></font></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input type="submit" name="Submit" value="ค้นหา"><input name="serach_flag" type="hidden" value="<?php echo $_REQUEST["serach_flag"];?>"></td>
                </tr>
            </table>
                    </form>
          <hr></td>
        </tr>
		<?php  
	  
 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
	//=================== ป้องกันช่องโหว่===========================
		if (!is_numeric($offset)) {
			exit;
		}
	//=======================================================
//    Set $limit,  $limit = Max number of results per 'page' 
if(empty($limit)){
$limit = 10;
}
if((!empty($_REQUEST["search_txt"]) or !empty($_REQUEST["date_s"]) or !empty($_REQUEST["date_e"])) and $_REQUEST["serach_flag"]="serach_flag"){
	  	if(!empty($_REQUEST["search_txt"])){
		$pkw = explode(" ",$_REQUEST["search_txt"]);
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
		$date_st = explode("/",$_REQUEST["date_s"]);
		$date_en = explode("/",$_REQUEST["date_e"]);
		$date_1 = ($date_st[2])."-".$date_st[1]."-".$date_st[0];
		$date_2 = ($date_en[2])."-".$date_en[1]."-".$date_en[0];
		if(!empty($_REQUEST["date_s"]) && !empty($_REQUEST["date_e"])){
		 $seld .= "  AND (n_date  between   '".$date_1."' and '".$date_2."' ) ";
		}else if(!empty($_REQUEST["date_s"]) && empty($_REQUEST["date_e"])){
		$seld .= "  AND (n_date  between   '".$date_1."' and '".$date_1."' ) ";
		}else if(empty($_REQUEST["date_s"]) && !empty($_REQUEST["date_e"])){
		$seld .= "  AND (n_date  between   '".$date_2."' and '".$date_2."' ) ";
		}
		$sql_query = "SELECT article_list.n_id,n_topic,n_des,n_date,news_use,link_html,target,picture FROM article_list $wh WHERE n_approve = 'Y' $seld ORDER BY n_date DESC,n_timestamp DESC ";
		$sql_article = $sql_query." LIMIT $offset,$limit ";
	//	echo $sql_article;	
		  $sql_article = $db->query($sql_article);
		 $rows = mysql_num_rows($db->query($sql_query));
		 if($rows>0){
		  $nu = $rows-$offset;
		while($A = $db->db_fetch_array($sql_article)){
?>
        <tr>
          <td><li><font size="2" face="MS Sans Serif"><?php if($A["news_use"] == "2"){
								echo "<a href=\"ewt_news.php?nid=".$A["n_id"]."\" target=\"_blank\">";
							}else{
								echo "<a href=\"".$A["link_html"]."\" target=\"_blank\">";
							}
						
						echo $A["n_topic"];
						echo "</a>"; ?></font></li></td>
        </tr>
        
		<?php $nu--; } ?>
		<tr>
        <td height="30" colspan="2"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>หน้าที่ :</strong></font>      <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='more_news1.php?offset=$prevoffset&cid=$cid&filename=$filename&search_txt=$search_txt&date_s=$date_s&date_e=$date_e'>
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
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">[ $i ]</font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='more_news1.php?offset=$newoffset&cid=$cid&filename=$filename&search_txt=$search_txt&date_s=$date_s&date_e=$date_e' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='more_news1.php?offset=$newoffset&cid=$cid&filename=$filename&search_txt=$search_txt&date_s=$date_s&date_e=$date_e'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
    }
?></td>
        </tr>
		<?php }else{ ?>
		<tr>
		  <td> <font color="#FF0000" size="2" face="Tahoma">ไม่พบข้อมูล <?php echo $_REQUEST["search_txt"].$_REQUEST["date_s"].$_REQUEST["date_e"];?> 
            </font> </td>
		</tr>
		<?php } ?>
      </table>
       </td>
          <td id="ewt_main_structure_right" width="<?php echo $R["d_site_right"]; ?>" bgcolor="<?php echo $R["d_right_bg_c"]; ?>" background="<?php echo $R["d_right_bg_p"]; ?>">
		  <?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $R["d_bottom_height"]; ?>" bgcolor="<?php echo $R["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $R["d_bottom_bg_p"]; ?>">
		  <?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
		<?php } ?>
      </table>
	 
</body>
</html>
<?php $db->db_close(); ?>
