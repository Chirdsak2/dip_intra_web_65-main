<?php
session_start();
//session_destroy();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("webboard_log.php");

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


$Execsql = $db->query("SELECT * FROM w_cate WHERE c_use = 'Y' ORDER BY c_id ASC");
$row = mysql_num_rows($Execsql)
?>
<html>
<head>
<title><?php if($MyTitle==""){?>===== Welcome =====<?php }else{ echo $MyTitle; }?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link id="stext" href="css/size.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style5 {font-size: 14}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php @include("com_top.php"); ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td align="center"><table width="720" border="0" cellspacing="0" cellpadding="1">
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><?php @include("forum_introduce.php"); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="820" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#006699">
                            <tr>
                              <td width="17">&nbsp;</td>
                              <td width="784" height="23">&nbsp;</td>
                              <td width="11"><div align="right"><img src="mainpic/content_r2_c4.gif" width="10" height="23"></div></td>
                            </tr>
                          </table>
                            <!--#F4F4F4-->
                            <table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="#006699">
                              <tr bgcolor="#88bbdd">
                                <td colspan="2" valign="top"><strong class="style5"><a href="m_webboard2.php">หน้าหลักกระทู้</a></strong></td>
                              </tr>
                              <tr>
                                <td colspan="2" width="100%" valign="top" class="text11" bgcolor="white"><!--Content-->
                                    <table width="0" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td><!--detail-->
                                            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                                              <tr>
                                                <td align="center"><table width="720" border="0" align="left" cellpadding="3" cellspacing="2">
                                                    <tr>
                                                      <td colspan="2" valign="top"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                                                          <tr>
                                                            <td valign="center" class="text9"><h4><strong>&nbsp;<font color="006699">หมวด&#3585;&#3619;&#3632;&#3607;&#3641;&#3657;</font></strong></h4></td>
                                                          </tr>
                                                      </table></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="2" bgcolor="ffffff" height="3"><hr size="1" color="eeeeee" /></td>
                                                    </tr>
													<?php
													$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
													$QQ= mysql_fetch_array($Execsql1);
													 if($row > 0){
													   while($R = mysql_fetch_array($Execsql)){ 
													   if($R["c_rss"]=='Y'){
																 $filename="rss/webboard".$R["c_id"].".xml";
																 if(file_exists($filename)){
																	 $link='<a href="rss/webboard'.$R["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0"> </a>';
																 }else{
																	 $link='';
																 }
															}else{ $link='';
															}
													?>
                                                    <tr>
                                                      <td  width="42" valign="top"> <?php if($R[c_view] == "Y"){ ?>
													  <img src="mainpic/lock.gif" width="20" height="20"> 
													  <?php }else{ ?>
													  <img src="mainpic/book_blue.gif" width="20" height="20"> 
													  <?php } ?></td>
                                                      <td><a href="index_question2.php?wcad=<?php echo $R[c_id]; ?>" target="_blank"><?php  echo stripslashes($R[c_name]); ?> </a><?php echo $link;?><br><?php  echo stripslashes($R[c_detail]); ?></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="2" bgcolor="ffffff" height="3"><hr size="1" color="eeeeee" /></td>
                                                    </tr>
													<?php } } ?>
                                                </table></td>
                                              </tr>
                                            </table>
                                          <!--detail-->                                        </td>
                                      </tr>
                                    </table>
                                  <!--Content-->                                </td>
                              </tr>
                          </table></td>
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
