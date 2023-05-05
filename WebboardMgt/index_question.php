<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");

$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);


 $data = $_REQUEST['data'];
 $wcad = $_REQUEST['wcad'];
 if (!empty($data)) {
			  $wh = " AND t_name like '%$data%'   ";
}
$sel = "SELECT * FROM w_question WHERE c_id = '$wcad' $wh ORDER BY t_id DESC";

   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 

$limit = $CO[c_number];
if(empty($limit)){
$limit =10;
}
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
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
  <?php
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><a href="index_cate.php"><?php echo $text_genwebboard_cat;?> </a> <img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"><?php echo $QQ[c_name]; ?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genwebboard_cat.' :: '.$QQ[c_name]);?>&module=webboard&url=<?php echo urlencode("index_question.php?wcad=".$_GET["wcad"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="addquestion.php?wcad=<?php echo $wcad; ?>"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_genwebboard_cataddnew;?></a>
      <hr>
    </td>
  </tr>
</table>

     <table width="94%" border="0" cellspacing="1" cellpadding="3" align="center">
					 <form method="post" action="index_question.php?wcad=<?php echo $wcad?>">
									<tr>
									  <td ><input type="hidden" name="curPage" value="1">
										ค้นหาหัวข้อกระทู้
										<input type="text" name="data" value="<?php echo $data;?>">
									  <input type="submit" name="Submit" value="ค้นหา"></td>
									</tr>
					</form>	
	</table>

  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <tr align="center" bgcolor="#FFCC99" class="ewttablehead">
      <td width="5%" class="head_font">&nbsp;</td>
      <td class="head_font"><?php echo $text_genwebboard_cat2;?></td>
      <td width="10%"><?php echo $text_genwebboard_datepost;?></td>
      <td width="10%"><?php echo $text_genwebboard_numnewpost;?></td>
    </tr>
    <?php
  if($rows > 0){
    if( $db->check_permission("webboard","a",$wcad)  ||  $db->check_permission("webboard","a",0) ){ $pass_a='Y';   }
    if( $db->check_permission("webboard","g",$wcad) ||  $db->check_permission("webboard","g",0)){ $pass_g='Y';   }
   while($R = mysql_fetch_array($Execsql)){ 
   $count = $db->query("SELECT * FROM w_answer WHERE t_id = '$R[t_id]' AND s_id != '1'");
   $countrow = mysql_num_rows($count);
   ?>
    <tr bgcolor="<?php if($R[s_id] == "1"){ echo "FFFFFF"; }else{ echo "E7E7E7"; } ?>"  onMouseOver="this.style.backgroundColor='<?php if($R[s_id] == "1"){ echo "#FFF3E8"; }else{ echo "CCCCCC"; } ?>'" onMouseOut="this.style.backgroundColor='<?php if($R[s_id] == "1"){ echo "FFFFFF"; }else{ echo "E7E7E7"; } ?>'">
      <td width="6%" align="left" bgcolor="#FFFFFF"><nobody>
	  <?php
	  if($pass_a=='Y'){
	   if($R[s_id] != "1"){ ?>
			  <a href="question_function.php?flag=apptopic&wcad=<?php echo $wcad; ?>&wtid=<?php echo $R[t_id]; ?>" onClick="return confirm('<?php echo $text_genwebboard_alertapprove;?>');">
			  <img src="../theme/main_theme/g_add_document.gif" alt="<?php echo $text_genwebboard_listalert1;?>" width="16" height="16" border="0">	  </a>
			   <?php }else{ ?>
				  <a href="question_function.php?flag=unapptopic&wcad=<?php echo $wcad; ?>&wtid=<?php echo $R[t_id]; ?>" onClick="return confirm('<?php echo $text_genwebboard_alertdisable;?>');">
			  <img src="../theme/main_theme/g_approve.gif" alt="<?php echo $text_genwebboard_listalert2;?>" width="16" height="16" border="0">	  </a>
			  <?php } 
	  }
	  
	  ?> <a href="#send" onClick="window.open('sendto.php?wtid=<?php echo $R[t_id]; ?>','','width=800,height=300,scrollbars=1');"><img src="../images/bar_enews.gif" alt="ส่งกระทู้ไปหน่วยงานอื่นๆ" width="16" height="16" border="0"></a>
	  <?php if($pass_g=='Y'){?>
	  <a href="question_function.php?flag=deltopic&wcad=<?php echo $wcad; ?>&wtid=<?php echo $R[t_id]; ?>" onClick="return confirm('<?php echo $text_genwebboard_listalert3;?>');"><img src="../theme/main_theme/g_del.gif" alt="<?php echo $text_general_delete;?>" width="16" height="16"  border="0"></a>
	  <?php }?></nobody> </td>
      <td width="54%" valign="middle" bgcolor="#FFFFFF" style="cursor:'hand'" onClick="window.location.href='index_answer.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $R[t_id]; ?>'">
        <?php  echo stripslashes($R[t_name]); ?>      </td>
      <?php $timer = explode("-",$R[t_date]); $YearT = $timer[0]+543; ?>
      <td align="center" bgcolor="#FFFFFF"><?php echo $timer[2]."/".$timer[1]."/".$YearT."<br>".$R[t_time]; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $countrow; ?></td>
    </tr>
    <?php }   
	}?>
	
    <?php if($rows > 0){ ?>
                    <tr bgcolor="#FFFFFF"> 
                      <td height="25" colspan="15" valign="top"><?php echo $text_general_page;?> :
                        <?php
								// Begin Prev/Next Links 
								// Don't display PREV link if on first page 
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?offset=$prevoffset&data=$data&wcad=$wcad'>
								<font  color=\"red\">$text_general_previous</font></a>\n\n";
								}
								$pages = intval($rows/$limit); 
								if ($rows%$limit) { 
										$pages++; 
								} 
								for ($i=1;$i<=$pages;$i++) { 
									if (($offset/$limit) == ($i-1)) { 
											echo "<b>[ $i ] </b>"; 
									} else { 
											$newoffset=$limit * ($i-1); 
											echo  "<a href=\"$PHP_SELF?offset=$newoffset&data=$data&wcad=$wcad\"". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href=\"$PHP_SELF?offset=$newoffset&data=$data&wcad=$wcad\">
										<font color=\"red\">$text_general_next</font></a>"; 
								}
								?>
                      </td>
                    </tr>
                    <?php }else{?>
					<tr bgcolor="#FFFFFF"> 
                      <td height="30" colspan="15"  align="center"><font color="#FF0000"><?php echo $text_general_notfound;?></font></td>
                    </tr>
			<?php }?>
  </table>
</body>
</html>
<?php @$db->db_close(); ?>