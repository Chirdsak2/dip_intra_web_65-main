<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//==========================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	//==========================================================
	
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$filename = $_REQUEST["filename"];
$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_REQUEST["filename"]."' ");
$F = $db->db_fetch_array($sql_index);

		if($keyword){
			$seld = "and  ( ";
			$pkw = explode(" ",$keyword);
			$sum = count($pkw);
							for($q = 0;$q<$sum;$q++){
									if($pkw[$q] != ""){
									 $seld .= " ( fa_name REGEXP  '$pkw[$q]' OR fa_detail  REGEXP  '$pkw[$q]'   OR fa_ans  REGEXP  '$pkw[$q]'   )  OR";
									}
							} 
			$seld = substr($seld,0,-2);
			$seld .= " )  ";
			}


 $sel = "SELECT * FROM faq WHERE   faq.faq_use='Y'  $seld ORDER BY  faq_top DESC ,faq_date DESC";
//$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
//$CO = $db->db_fetch_array($chk_config);
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
//$limit = $CO[c_number];
$limit =20;
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = $db->query($Show);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<link id="stext" href="css/size.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
-->
</style>
<title>FAQ</title></head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_REQUEST["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php if($B[1] != "article" AND $B[1] != "share" AND $B[1] != "org"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
		  $sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_REQUEST["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php if($B[1] != "article" AND $B[1] != "share" AND $B[1] != "org"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
          
    <td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"> 
     <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="styleMe">
<?php
$Execsql1 = $db->query("SELECT * FROM f_subcat WHERE f_sub_id = '$f_sub_id'");
$QQ= $db->db_fetch_array($Execsql1);
?>
  <tr>
    <td valign="top" align="right" height="25"><form name="search_faq" method="post" action="">
	<input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>">
      <input type="text" name="keyword" class="styleMe">
      <input type="submit" name="search" value="ค้นหา FAQ" class="styleMe">
    </form></td>
  </tr>
  <tr>
    <td width="100%" height="265" valign="top"><DIV align="center"  ><strong><font size="2" face="Tahoma">ผลการค้นหา FAQ ทั้งหมด</font></strong><br>
                <br>

                <table width="65%" border="0" cellpadding="3" cellspacing="1" class="styleMe">
                                 <?php
	  if($rows > 0){
   while($R = $db->db_fetch_array($Execsql)){ 
   							for($q = 0;$q<$sum;$q++){
									if($pkw[$q] != ""){
									 $rest = ereg_replace($pkw[$q],"<font style=background-color:red>".$pkw[$q]."</font>", $R[fa_name]);
									}
							} 
	?> 
<tr > 
                    <td width="79%">&diams;&nbsp;&nbsp;<a href="#"  onClick="c=window.open('faq_open.php?fa_id=<?php echo $R['fa_id'];?>','showass','scrollbars=yes,width=650,height=450');c.focus();"><?php echo $rest; ?></a></td>
                    <td width="18%" align="center">(<?php $count= $db->query("SELECT fa_id  FROM faq_stat WHERE fa_id = '$R[fa_id]' ");
   															echo $countrow2 = mysql_num_rows($count);?>)</td>
                  </tr> <?php }}else{ ?>
<tr bgcolor="#F7F7F7">
  <td colspan="2" align="center"><font color="#FF0000"><strong>ไม่มี FAQ ในหมวดนี้</strong></font></td>
  </tr>  
 <?php } ?>
                </table>


                 
				
    </DIV></td>
  </tr>
  <?php  if($rows > 0){ ?>
  <tr bgcolor="#FFF4EA">
    <td height="23" valign="top"><strong>หน้าที่ :</strong>     <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&fcad=$fcad&filename=$filename'>
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
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">[ $i ] </font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&fcad=$fcad&filename=$filename' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&fcad=$fcad&filename=$filename'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
    }
?></td>
  </tr>
  <?php } ?>
</table>
</td>
          <td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
		  $sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_REQUEST["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php if($B[1] != "article" AND $B[1] != "share" AND $B[1] != "org"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_REQUEST["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php if($B[1] != "article" AND $B[1] != "share" AND $B[1] != "org"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>
