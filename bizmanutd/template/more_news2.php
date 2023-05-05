<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
include("language/language.php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);
$design_id = $R["d_id"];

	$sql_group ="select * from  article_group where c_id = '".$_GET["cid"]."'";
	 $query_group = $db->query($sql_group);
	 $U = $db->db_fetch_array($query_group);
	?>
<html>
<head>
<title><?php echo $U["c_name"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/calendar-th.js"></script>
<?php
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($R["d_site_bg_c"] != ""){ echo "bgcolor=\"".$R["d_site_bg_c"]."\""; } ?> <?php if($R["d_site_bg_p"] != ""){ echo "background=\"".$R["d_site_bg_p"]."\""; } ?> >
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
	  <?php
	  
 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
if(empty($limit)){
$limit = 20;
}
	  	if(!empty($_POST["search_txt"])){
		$pkw = explode(" ",$_POST["search_txt"]);
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
		$date_st = explode("/",$_POST["date_s"]);
		$date_en = explode("/",$_POST["date_e"]);
		$date_1 = ($date_st[2])."-".$date_st[1]."-".$date_st[0];
		$date_2 = ($date_en[2])."-".$date_en[1]."-".$date_en[0];
		if(!empty($_POST["date_s"]) && !empty($_POST["date_e"])){
		 $seld .= "  AND (n_date  between   '".$date_1."' and '".$date_2."' ) ";
		}else if(!empty($_POST["date_s"]) && empty($_POST["date_e"])){
		$seld .= "  AND (n_date  between   '".$date_1."' and '".$date_1."' ) ";
		}else if(empty($_POST["date_s"]) && !empty($_POST["date_e"])){
		$seld .= "  AND (n_date  between   '".$date_2."' and '".$date_2."' ) ";
		}
	  	$sql_query = "SELECT * FROM article_list $wh WHERE c_id = '".$_GET["cid"]."' AND n_approve = 'Y' $seld ORDER BY n_date DESC,n_timestamp DESC ";
		$sql_article = $sql_query." LIMIT $offset,$limit ";	
		  $sql_article = $db->query($sql_article);
		  

		  ?>
		  <table width="95%" border="0" align="center" cellpadding="5" cellspacing="0" style="display:none">
          <tr>
            <td><span  style="FONT: 12px 'Tahoma';"><a href="index.php"  style="FONT: 12px 'Tahoma';">หน้าหลัก</a> >><a href="more_news.php?cid=<?php echo $U[c_id]; ?>&filename=index"  style="FONT: 12px 'Tahoma';"> <?php echo $U[c_name]; ?></a> <?php if($U[c_rss] == "Y"){ ?><a href="rss/group<?php echo $U[c_id]; ?>.xml" target="_blank"><img src="mainpic/ico_rss.gif"  border="0" align="absmiddle"></a><?php } ?></span>
</td>
          </tr>
		  </table>
      <table width="95%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr><form name="form1" method="get" action="search_result.php">
          <td>
		  
              <table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr> 
                  <td align="right" ><input type="text" name="keyword" value=""  style="FONT: 11px 'Tahoma';">
                    <input type="submit" name="Submit" value="ค้นหา"  style="FONT: 11px 'Tahoma';"><input name="search_mode" type="hidden" value="2"><br>
                    <input name="g" type="radio" value="<?php echo trim($U[c_id]); ?>" checked> เฉพาะหมวด<?php echo trim($U[c_name]); ?>
                    <input name="g" type="radio" value=""> ข่าว/บทความทั้งหมด
                    <input name="filename" type="hidden" value="<?php echo $_REQUEST["filename"]; ?>"></td>
                </tr>
              </table>
                    
          </td></form>
        </tr>
		<tr>
          <td><span style="FONT: 17px 'Tahoma';"><?php echo $U["c_name"]; ?></span> <?php if($U[c_rss] == "Y"){ ?><a href="rss/group<?php echo $U[c_id]; ?>.xml" target="_blank"><img src="mainpic/ico_rss.gif"  border="0" align="absmiddle"></a><?php } ?><hr size="1"></td>
        </tr>

		<?php  
		
		 $rows = mysql_num_rows($db->query($sql_query));
		  $nu = $rows-$offset;
		while($A = $db->db_fetch_array($sql_article)){
?>		<tr>
          <td>
		  <table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr> 
    <td width="90" valign="top"><?php
	if(($A[picture] != "") AND (file_exists("images/article/news".$A[n_id]."/t".$A[picture]))){
	?><table width="80" height="80" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">
												<tr>
												  <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="phpThumb.php?src=<?php echo "images/article/news".$A[n_id]."/t".$A[picture]; ?>&h=80&w=80" border="0" hspace="0" vspace="0" >
												  </td>
												</tr>
											  </table><?php } ?></td>
    <td valign="top"><?php if($A["news_use"] == "2"){
								echo "<a href=\"ewt_news.php?nid=".$A["n_id"]."\" target=\"".$A["target"]."\"><b>";
							}else{
								echo "<a href=\"".$A["link_html"]."\" target=\"".$A["target"]."\"><b>";
							}
						
						echo $A["n_topic"];
						echo "</b></a>"; ?> 
						<?php
						if($_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_MID"] == $A["n_owner"]){
						echo " [<a href=\"#edit\" onClick=\"wina=window.open('ewt_article?N=".base64_encode($A[n_id])."','articleedit','width=400,height=300,scrollbars=1');wina.focus();\">แก้ไข</a>]";
						}
						?>
						<br>
						<div> <span style="FONT: 11px 'Tahoma';color:#888888"><?php $date = explode("-",$A["n_date"]); echo number_format($date[2],0)." ".$monthname[number_format($date[1],0)]." ".$date[0]; ?></span></div>
						<div><?php 
						$rest = substr($A[n_des], 0, 100);
						$rest = htmlspecialchars($rest,ENT_QUOTES);
						 if($rest != ""){ echo stripslashes($rest)."..."; } ?></div></td>
  </tr>
</table>
       
		</td></tr>
		<?php $nu--; } ?>
		
		<tr>
        <td height="30" colspan="2">
<hr size="1">
<font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>หน้าที่ :</strong></font>      <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&cid=$cid&filename=$filename'>
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
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">[$i]</font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  " <a href='$PHP_SELF?offset=$newoffset&cid=$cid&filename=$filename' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a> \n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href='$PHP_SELF?offset=$newoffset&cid=$cid&filename=$filename'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a> "; 
    }
?></td>
        </tr>
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
      </table>
</body>
</html>
<?php $db->db_close(); ?>
