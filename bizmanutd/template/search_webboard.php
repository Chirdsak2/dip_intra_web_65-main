<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
	//==============================================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($keyword){ $keyword= checkPttSearch($keyword); }
	if($_GET['keyword']){ $_GET['keyword']= checkPttSearch($_GET['keyword']); }
	if($_POST['keyword']){ $_POST['keyword']= checkPttSearch($_POST['keyword']); }
	//==============================================================================
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$filename = $_REQUEST["filename"];
$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_REQUEST["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
if(empty($filename)){
$w = "100%";
}else{
$w = $F["d_site_width"];
}
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" language="JavaScript1.2" src="../../js/stm31.js"></script>
<title>Search Result...</title></head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table width="<?php echo $w; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
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
          
    <td width="<?php echo $w; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"> 
     <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="form1" method="post" action="search_webboard.php">
    <tr> 
      <td height="25" align="right" bgcolor="E7E7E7"><font size="1" face="MS Sans Serif, MS Sans Serif, sans-serif">ค้นหา</font> 
        <input name="keyword" type="text" id="keyword" style="font-family:'MS Sans Serif';font-size:12px;color:#000000;" value="<?php echo $keyword; ?>" size="30"> 
                    <input name="oper" type="hidden" id="oper" value="OR"><input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>"><input type="submit" name="Submit" value=" ค้นหา... " style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">
                    </font></td>
    </tr>
    <tr>
      <td bgcolor="#666666" height="1"></td>
    </tr></form><script language="JavaScript">
document.form1.keyword.focus();
</script>
  </table></td>
  </tr>
  <tr>
    <td valign="top"><?php
  $keyword = trim($keyword);
   if($keyword != ""){ 
$limit = "10";
$today=date('Y-m-d');
$ip_address=getenv("REMOTE_ADDR");
$pkw = explode(" ",$keyword);
$sum = count($pkw);
//echo $sum;
$seld = " ( ";
	for($q = 0;$q<$sum;$q++){
			if($pkw[$q] != ""){
				if($q==0){
					 $seld .= " ( t_name REGEXP  '$pkw[$q]' OR t_detail REGEXP  '$pkw[$q]'  OR  a_detail REGEXP  '$pkw[$q]' )";
				 }else{
				 	$seld .= " OR ( t_name REGEXP  '$pkw[$q]' OR t_detail REGEXP  '$pkw[$q]'   OR  a_detail REGEXP  '$pkw[$q]'    )";
				}
			 //$seld .= " OR ( a_detail REGEXP  '$pkw[$q]'    ))";
			}
	}
$seld .= " ) ";

//$sql_search = "select * from w_question,w_answer
							 	//WHERE w_question.t_id = w_answer.t_id ";
$sql_search = "SELECT  w_question.t_name, w_question.t_detail,w_answer.a_detail, w_question.c_id, w_question.t_id
FROM w_question
LEFT JOIN w_answer ON w_question.t_id = w_answer.t_id WHERE 1=1 ";

/*$summ = strlen($oper);
$seld = substr($seld,0,-$summ);
 $seld2 = substr($seld2,0,-3);
$seld .= " )  ";
 $seld2 =" and (". $seld2.")";*/
 if($seld != ''){ $sql_search .= "and"; }
$sql_search .= $seld;
$sql_search .= $seld2;
$sql_search .= "GROUP BY w_question.t_id  order by w_question.t_name DESC";

 $query_search = $db->query($sql_search);
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
	 $totalrows = mysql_num_rows($query_search);

	// Set $begin and $end to record range of the current page 
 $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
	 $sql_search .= " LIMIT $offset, $limit ";
	$query_search = $db->query($sql_search);
  ?>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr>
      <td align="left" bgcolor="F7F7F7"><font size="1" face="MS Sans Serif, MS Sans Serif, sans-serif">รายการที่ <strong><?php echo $offset + 1; ?> 
        - <?php echo $offset + $limit; ?></strong> จากผลการค้นหาทั้งหมด <strong><?php echo number_format($totalrows,0); ?></strong> 
        รายการของคำค้น <strong><?php echo $keyword ?></strong></font></td>
    </tr>
	<td height="1" align="left" bgcolor="#666666"></td>
    </tr>
	<?php if(mysql_num_rows($query_search)){ 
	?>
	<?php while($R=mysql_fetch_array($query_search)){ ?>
	<?php
	$rest = '';
	$filename1 = $R[t_name];
	$block = $R[t_name].$R[t_detail].$R[a_detail];
	$pos = strpos($block, $pkw[0]);
	if(empty($pos) ){
	$pos = strpos($block, $pkw[1]);
	}
		if (!($pos === false)) { // note: three equal signs
		$pos1 = $pos - 100;
		if($pos1 < 0){
		$pos1 = 0;
		}

 $rest .= substr($R[t_detail], $pos1, 200);
 $rest .= substr($R[a_detail], $pos1, 200);
 $filename1.= substr($R[t_name], $pos1, 200);
 $rest = htmlspecialchars($rest,ENT_QUOTES);
 $filename1 = htmlspecialchars($filename1,ENT_QUOTES);
		for($q = 0;$q<$sum;$q++){
							if($pkw[$q] != ""){
							$rest = ereg_replace($pkw[$q],"<b>".$pkw[$q]."</b>", $rest);
							$filename1 = ereg_replace($pkw[$q],"<b>".$pkw[$q]."</b>", $filename1);
							}
		}
}
	?>
    <tr>
      <td bgcolor="#F3F3F3"><font size="2" face="MS Sans Serif, MS Sans Serif, sans-serif"><a href="<?php echo $R[filename]; ?>.html" target="_blank"></a></font></td>
    </tr>
	<tr>
	  <td><a href="index_answer.php?wcad=<?php echo  $R[c_id]; ?>&wtid=<?php echo $R[t_id]; ?>&filename=<?php echo $filename; ?>&keyword=<?php echo $keyword; ?>" target="_blank"><font size="2" face="MS Sans Serif, MS Sans Serif, sans-serif"><?php echo $filename1; ?></font></a></td>
	  </tr>
	<tr>
      <td><font size="1" face="MS Sans Serif, MS Sans Serif, sans-serif">...<?php echo stripslashes($rest); ?>...</font></td>
    </tr>
	 <tr>
      <td><font color="#006600" size="2" face="MS Sans Serif">&nbsp;  
        </font></td>
    </tr>
    <tr> 
      <td height="15">&nbsp;</td>
    </tr>
	<tr> 
      <td height="1" bgcolor="#999999"></td>
    </tr>
	<?php } ?>
	<tr> 
      <td align="center"> 
        <table  border="0" cellpadding="1" cellspacing="0">
          <tr valign="bottom"> 
            
          <td width="120" align="right"><font size="2" face="MS Sans Serif"><strong>ผลการค้นหาหน้าที่:</strong></font></td>
            <td align="center" ><font size="2" face="MS Sans Serif"><?php if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='search_webboard.php?offset=$prevoffset&keyword=$keyword&oper=$oper&filename=$filename'>
ย้อนกลับ</a> ";
}
     ?></font></td>
              <?php

    // Calculate total number of pages in result 
   $pages = intval($totalrows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($totalrows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     $current = ($offset/$limit) - 1;
	 $start = $current - 10;
	 if($start < 1){
	 $start = 1;
	 }
	 $end = $current + 10;
	 	 if($end > $pages){
	 $end = $pages;
	 }
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=$start;$i<=$end;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<td align=\"center\" width=16><font size=\"2\" face=\"MS Sans Serif\"><b>$i</b></font></td>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<td align=\"center\" width=16><a href='search_webboard.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'><font size=\"2\" face=\"MS Sans Serif\">$i</font></a></td>"; 
        } 
    } 

?>
        </font> 
            <td width="65" align="center"><font size="2" face="MS Sans Serif"><?php 
			if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='search_webboard.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'>ถัดไป</a>"; 
    }  ?></font></td>
          </tr>
        </table>
      </td>
    </tr>
	<?php
	}else{
	?>
	<tr>
      <td><br>
        <font size="2" face="MS Sans Serif">ผลการค้นหา - <?php echo $keyword; ?> - ไม่ตรงกับเอกสารใดเลย 
        <br>
        คำแนะนำ:<br>
        - ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br>
        - ลองคำหลักที่ต่างจากนี้<br>
        - ลองใช้คำหลักทั่วๆไป<br>
        - ลองใช้คำให้น้อยลง</font><br>
        <br>
      </td>
    </tr><?php
	} ?>
	<tr>
      <td bgcolor="#666666" height="1"></td>
    </tr>
  </table>
  <?php } ?></td>
  </tr>
  <tr> 
      
    <td height="10" align="center" bgcolor="E7E7E7">&nbsp;</td>
    </tr>
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