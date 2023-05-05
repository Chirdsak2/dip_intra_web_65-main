<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
	if($oper == ""){
			$oper = "OR";
	}
function like_word($w){
global $db;
global $EWT_DB_NAME;
if(trim($w) != ""){
	$like = "";
			$db->query("USE ".$EWT_DB_USER);
			$sql_dict = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD = '".trim($w)."' ");
			if($db->db_num_rows($sql_dict) == 0){
				$sql_dict1 = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '".trim($w)."%' ORDER BY DICT_WORD LIMIT 0,1");
					if($db->db_num_rows($sql_dict1) > 0){
						$D = $db->db_fetch_row($sql_dict1);
						$like = $D[0];
					}else{
							$sql_dict2 = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '%".trim($w)."' ORDER BY DICT_WORD  LIMIT 0,1");
							if($db->db_num_rows($sql_dict2) > 0){
								$D = $db->db_fetch_row($sql_dict2);
								$like = $D[0];
							}else{
								$countw = strlen($w);
					//			if($countw > 2){
									for($x=1;$x<($countw);$x++){
										$newword = substr($w, 0,-$x);
										$sql_dict3 = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '".$newword."%' ORDER BY DICT_WORD LIMIT 0,1");
										if($db->db_num_rows($sql_dict3) > 0){
											$D = $db->db_fetch_row($sql_dict3);
											$like = $D[0];
											$x = $countw;
										}
						//			}
								}
							}
					}
			}
	}
	$db->query("USE ".$EWT_DB_NAME);
	return $like;
}

	?>
<html>
<head>
<title>Search Result...</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<link id="stext" href="css/normal.css" rel="stylesheet" type="text/css">
<link  href="css/interface.css" rel="stylesheet" type="text/css">
</head>
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
<script language="javascript">
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
function txt_data(w) {
	var mytop = findPosY(document.formSearchEWT.keyword) + document.all.keyword.offsetHeight;
	var myleft = findPosX(document.formSearchEWT.keyword);	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='ewt_nav_pad.php?d='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
			}
		}
	);
	
}
</script>
<body  leftmargin="0" topmargin="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="formgoogle" method="get" action="http://www.google.co.th/search" target="_blank">
    <input type="hidden" name="q">
  </form>
  <form name="formSearchEWT" method="get" action="search_result.php">
    <tr> 
      <td  align="right" bgcolor="E7E7E7">ค้นหา 
        <input name="keyword" type="text" id="keyword"  size="30" value="<?php echo stripslashes(htmlspecialchars(trim($_REQUEST["keyword"]),ENT_QUOTES));; ?>" autocomplete="off" onKeyUp="txt_data(this.value)" > 
        <input name="oper" type="hidden" id="oper" value="OR"> <input type="submit" name="Submit" value=" ค้นหา... " > 
        <input type="button" name="Button" value="ค้นหาขั้นสูง" onClick="window.location.href='search_advance.php?filename=<?php echo $_REQUEST["filename"]; ?>';" > 
        <input type="button" name="Button" value="ค้นหาจากภายนอก" onClick="document.formgoogle.q.value=document.formSearchEWT.keyword.value;formgoogle.submit();" > </font> 
        <div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div></td>
    </tr>
    <tr> 
      <td bgcolor="#666666" height="1"></td>
    </tr>
  </form>
  <script language="JavaScript">
document.formSearchEWT.keyword.focus();
</script>
</table>
<?php
$today=date('Y-m-d');
$ip_address=getenv("REMOTE_ADDR");
	if(trim($_REQUEST["keyword"]) != ""){
		$data_default = stripslashes(htmlspecialchars(trim($_REQUEST["keyword"]),ENT_QUOTES));
		$data = $data_default;
		$data = str_replace('+',' ',$data);
		$data = str_replace('*',' ',$data);
		$dt = explode(" ",$data);
		$num = count($dt);
		$word_b = "";
		$word_a = "";
		$word_ah = "";
		for($i=0;$i<$num;$i++){
			if(trim($dt[$i]) != ""){
				$check = like_word($dt[$i]);
				$word_b .= $check." ";
						if($check != ""){
							$word_a .= "<font color=red>".$check."</font> ";
							$word_ah .= $check." ";
						}else{
							$word_a .= $dt[$i]." ";
							$word_ah .= $dt[$i]." ";
						}
						$db->query("insert into search_stat (search_word,search_date,search_ip)  values ('$dt[$i]','$today','$ip_address') ");
						$seld .= " ( temp_index.cms_keyword REGEXP  '$dt[$i]' OR temp_index.filename REGEXP  '$dt[$i]' )".$oper;
				}
		}
		//echo $seld;
		$word_b = trim($word_b);
		$summ = strlen($oper);
		$seld = substr($seld,0,-$summ);

$limit = "10";

 $sql_search = "SELECT  temp_index.filename,temp_index.cms_keyword FROM  temp_index  WHERE ".$seld." ORDER BY temp_index.filename  ";

 $query_search = $db->query($sql_search);
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
	 $totalrows = $db->db_num_rows($query_search);

	// Set $begin and $end to record range of the current page 
 $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
	 $sql_search .= " LIMIT $offset, $limit ";
	 
	 //echo  $sql_search;
	$query_search = $db->query($sql_search);
  ?>
            
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td align="left" bgcolor="F7F7F7"> 
      <?php
						if($word_b != ""){
			echo "คำใกล้เคียง : <a href=\"search_result.php?keyword=".$word_ah."\">".$word_a."</a>";
		}
				?>
    </td>
  </tr>
  <tr> 
    <td align="left" bgcolor="F7F7F7" >รายการที่ <strong><? echo $offset + 1; ?> 
      - <? echo $offset + $limit; ?></strong> จากผลการค้นหาทั้งหมด <strong><? echo number_format($totalrows,0); ?></strong> 
      รายการของคำค้น <strong><? echo $data_default; ?></td>
  </tr></tr>
  <?php 
			  if($db->db_num_rows($query_search)){ 
			  while($R=$db->db_fetch_array($query_search)){ 
					$filename1 = $R[filename];
					$pos = strpos($R[cms_keyword], $dt[0]);
							if (!($pos === false)) { // note: three equal signs
							$pos1 = $pos - 100;
							if($pos1 < 0){
							$pos1 = 0;
							}
								 $rest = substr($R[cms_keyword], $pos1, 200);
								 $rest = htmlspecialchars($rest,ENT_QUOTES);
										for($q = 0;$q<$num;$q++){
																		if($dt[$q] != ""){
																		$rest = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $rest);
																		$filename1 = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $filename1);
																		}
										}
					}
	?>
  <tr> 
    <td bgcolor="#F3F3F3"></td>
  </tr>
  <tr> 
    <td><a href="search_open.php?filename=<?=$filename1; ?>&keyword=<? echo $keyword; ?>" target="_blank"><b><? echo $filename1; ?></b></a></td>
  </tr>
  <tr> 
    <td>...<? echo stripslashes($rest); ?>...</td>
  </tr>
  <tr> 
    <td height="15">&nbsp;</td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#999999"></td>
  </tr>
  <? } ?>
  <tr> 
    <td align="center"> <table  border="0" cellpadding="1" cellspacing="0">
        <tr valign="bottom"> 
          <td width="120" align="right"><font size="2" face="MS Sans Serif"><strong>ผลการค้นหาหน้าที่:</strong></font></td>
          <td align="center" ><font size="2" face="MS Sans Serif"> 
            <? if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='search_result.php?offset=$prevoffset&keyword=$keyword&oper=$oper&filename=$filename'>
ย้อนกลับ</a> ";
}
     ?>
            </font></td>
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
                  echo  "<td align=\"center\" width=16><a href='search_result.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'><font size=\"2\" face=\"MS Sans Serif\">$i</font></a></td>"; 
        } 
    } 

?></font>
          <td width="65" align="center"><font size="2" face="MS Sans Serif"> 
            <? 
			if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='search_result.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'>ถัดไป</a>"; 
    }  ?>
            </font></td>
        </tr>
      </table></td>
  </tr>
  <?php
	}else{
	?>
  <tr> 
    <td><br> <font size="2" face="MS Sans Serif">ผลการค้นหา - <? echo $keyword; ?> 
      - ไม่ตรงกับเอกสารใดเลย <br>
      คำแนะนำ:<br>
      - ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br>
      - ลองคำหลักที่ต่างจากนี้<br>
      - ลองใช้คำหลักทั่วๆไป<br>
      - ลองใช้คำให้น้อยลง</font><br> <br> </td>
  </tr>
  <?
	} ?>
  <tr> 
    <td bgcolor="#666666" height="1"></td>
  </tr>
</table>
            <? } ?>
</body>
</html>
<?php $db->db_close(); ?>
