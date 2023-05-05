<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
	//========================================================================
	if($wcad){ $wcad = checkNumeric($wcad); }
	if($_GET["wcad"]){ $_GET["wcad"] = checkNumeric($_GET["wcad"]); }
	if($_POST["wcad"]){ $_POST["wcad"] = checkNumeric($_POST["wcad"]); }
	
	if($offset){ $offset = checkNumeric($offset); }
	if($_GET["offset"]){ $_GET["offset"] = checkNumeric($_GET["offset"]); }
	if($_POST["offset"]){ $_POST["offset"] = checkNumeric($_POST["offset"]); }
	//=========================================================================
include("webboard_log.php");
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);

  if($TTYPE !='Y'){
	$wh= "AND s_id = '1'";
	}
echo $sel = "SELECT * FROM w_question WHERE c_id = '$wcad'  $wh ORDER BY t_id DESC";
function CheckVulgar($msg){
$BanWord="***";
$Sql="SELECT * FROM vulgar_table";
$ExecSql=  mysql_query($Sql);
$total=mysql_num_rows($ExecSql);
if($total>0){
while($R=mysql_fetch_array($ExecSql)){
$Vtext=$R['vulgar_text'];
$msg=eregi_replace($Vtext,$BanWord,$msg);
}
}
return $msg;
}

   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = $CO[c_number];
if(empty($limit)){
$limit = 10;
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

$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
if($QQ["c_rss"]=='Y'){
			 $filename="rss/webboard".$QQ["c_id"].".xml";
			 if(file_exists($filename)){
			     $link='<a href="rss/webboard'.$QQ["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0" align="absmiddle"> </a>';
			 }else{
			     $link='';
			 }
		}else{ $link='';
		}
if($QQ[c_view] == "Y" AND $_SESSION["EWT_MID"] == ""){
 
?>
<script language="JavaScript">
alert("กรุณา login ก่อนเข้าสู่  Webboard");
top.location.href="ewt_login.php?fn=index_question.php?wcad=<?php echo $wcad; ?>";
</script>
<?php
exit;
}
if($QQ[c_view] == "Y" AND $QQ[c_view_porf] == "Y"  AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  > 3){
?>
<script language="JavaScript">
alert("Webboard นี้ท่านไม่สามารถร่วมในหมวดนี้ได้");
window.location.href = "m_webboard.php";
</script>
<?php
}
?>
<html>
<head>
<title><?php if($MyTitle==""){?>===== Welcome =====<?php }else{ echo $MyTitle; }?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link id="stext" href="css/size.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-weight: bold;
}
.style2 {color: #000000}
.style4 {font-size: 14}
-->
</style>
<link href="css/text1.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"  align="center">
<tr>
    <td height="12" colspan="2"><?php @include("com_top.php"); ?></td>
  </tr>
<tr>
  <td height="13" colspan="2" align="center"><table width="720" border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td><img src="mainpic/webboard_bullet.gif" align="absmiddle">
                <?php 	if($_SESSION["EWT_MID"] != ""){ echo "ยินดีต้อนรับคุณ ".$_SESSION["EWT_NAME"]; ?>
  &nbsp; &nbsp;<a href="#change" onClick="window.open('member_pwd.php','','width=300,height=200');">
  <!--&lt;&lt; 
      เปลี่ยนรหัสผ่าน-->
  </a> &nbsp; |&nbsp;<a href="ewt_login.php"> ออกจากระบบ &gt;&gt; </a>
  <?php }else{ ?>
  <a href="ewt_login.php?fn=m_webboard.php"><strong>เข้าสู่ระบบ</strong></a>
  <?php } ?></td>
            <td><table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
                <form name="formSearchWEBB" method="post" action="search_webboard.php?filename=<?php echo $filename; ?>">
                  <tr>
                    <td align="right"><input type="text" name="keyword" class="styleMe">
                        <input type="submit" name="search" value="ค้นหา webboard" class="styleMe">                    </td>
                  </tr>
                </form>
            </table></td>
        </tr>
    </table></td>
</tr>
  <tr>
        <td height="13">&nbsp;</td>
  </tr>
      <tr>
        <td height="13" align="center"><?php @include("forum_introduce.php"); ?></td>
      </tr>
      <tr>
        <td height="20" align="center">&nbsp;</td>
      </tr>
  <tr>
    <td><table width="920" border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#006699">
                        <tr>
                          <td width="901" height="23">&nbsp;&nbsp;<strong class="style5"><a href="m_webboard2.php">หน้าหลักกระทู้</a><img src="mainpic/arrow_r.gif" width="7" height="7" align="absmiddle"> <a href="index_question2.php?wcad=<?php echo $wcad; ?>"><?php echo $QQ[c_name]; ?></a></strong>&nbsp;&nbsp;&nbsp;<?php echo $link;?></strong></td>
                          <td width="11"><div align="right"><img src="mainpic/content_r2_c4.gif" width="10" height="23" /></div></td>
                        </tr>
                      </table>
                        <!--#F4F4F4-->
                        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="#006699">
						 <tr bgcolor="#88bbdd">
                                <td colspan="2" valign="top"><a href="addquestion.php?wcad=<?php echo $wcad; ?>"><img src="mainpic/contract.gif" width="16" height="16" border="0" align="absmiddle">ตั้งกระทู้ใหม่</a></td>
                          </tr>
                          <tr>
                            <td colspan="2" width="100%" valign="top" class="text11" bgcolor="white"><!--Content-->
                                <table width="0" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><!--detail-->
                                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                                          <tr>
                                            <td align="center"><table width="820" border="0" align="left" cellpadding="3" cellspacing="2">
                                                <tr>
                                                  <td colspan="4" valign="top"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                                                      <tr>
                                                        <td valign="center" class="text9"><h4><strong><font color="006699">หัวข้อ&#3585;&#3619;&#3632;&#3607;&#3641;&#3657;</font></strong></h4></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                                <tr>
                                                  <td align="center" bgcolor="ffffff">&nbsp;</td>
                                                  <td align="center" bgcolor="ffffff">&nbsp;</td>
                                                  <td width="55" align="center" bgcolor="ffffff">&#3629;&#3656;&#3634;&#3609;</td>
                                                  <td width="40" align="center" bgcolor="ffffff">&#3605;&#3629;&#3610;</td>
                                                </tr>
                                                <tr>
                                                  <td colspan="4" bgcolor="ffffff"><hr size="1" color="eeeeee" /></td>
                                                </tr>
												<?php
											  if($rows > 0){
											  $nu = $rows - $offset;
											   while($R = mysql_fetch_array($Execsql)){ 
											 
											   $count = $db->query("SELECT * FROM w_answer WHERE t_id = '$R[t_id]' AND s_id = '1' ORDER BY a_id DESC");
											   $countrow = mysql_num_rows($count);
											   $Z = mysql_fetch_array($count);
											   $timer = explode("-",$R[t_date]); $YearT = $timer[0]+543;
											   ?>
                                                <tr>
                                                  <td  width="42" valign="top"><img src="mainpic/edit_user.gif" width="25" height="25"></td>
                                                  <td valign="top"><a href="index_answer2.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $R[t_id]; ?>" target="_blank"><?php  $name =  stripslashes($R[t_name]);  echo CheckVulgar($name); ?></a>
												  <br>by:<?php  echo stripslashes($R[q_name]); ?> &nbsp;&nbsp;date - time :<?php echo $timer[2]."/".$timer[1]."/".$YearT."-".$R[t_time]; ?>
												  </td>
                                                  <td align="center" valign="top"><?php echo $R[t_count]; ?></td>
                                                  <td align="center" valign="top"><?php echo $countrow; ?></td>
                                                </tr>
                                                <tr>
                                                  <td colspan="4" bgcolor="ffffff" height="3"><hr size="1" color="eeeeee" /></td>
                                                </tr>
												  <?php $nu--; }}else{ ?>
											  <tr bgcolor="#FFFFFF"> 
												<td height="30" colspan="8"><div align="center"><font color="#FF0000"><strong>ไม่มีกระทู้ในหมวดนี้</strong></font></div></td>
											  </tr>
											  
											  <?php } ?>
											  <tr bgcolor="#FFFFFF">
											    <td height="30" colspan="8">page:<?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='index_question2.php?offset=$prevoffset&wcad=$wcad'>
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
                  echo  "<a href='index_question2.php?offset=$newoffset&wcad=$wcad' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='index_question2.php?offset=$newoffset&wcad=$wcad'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
    }
?></td>
										      </tr>
                                            </table></td>
                                          </tr>
                                        </table>
                                      <!--detail-->
                                    </td>
                                  </tr>
                                </table>
                              <!--Content-->
                            </td>
                          </tr>
                      </table></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?php @include("com_bottom.php"); ?></td>
  </tr>
</table>

</body>
</html>
