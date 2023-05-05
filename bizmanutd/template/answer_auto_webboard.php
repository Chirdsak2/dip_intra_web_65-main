<?php
session_start();
//session_destroy();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("webboard_log.php");
@include("language/language.php");
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
$row = mysql_num_rows($Execsql);/*
$dateshowl= date ("Y-m-d", mktime (0,0,0,date("m"),date("d")-$question_expire,date("Y")));
if($R['cms_keyword'] != ""){ $MetaKey= stripslashes($R['cms_keyword']); }
if($R['cms_description'] != ""){ $MetaDes= stripslashes($R['cms_description']); }
if($R['title'] != ""){ $MyTitle = stripslashes($R['title']); }else{ $MyTitle = stripslashes($WebTitle); }
if($R['encoding'] != ""){ $MyEncoding = $R['encoding']; }else{ $MyEncoding = "UTF-8"; }
if($R['bgpicture'] != ""){ $MyBgPicture = $R['bgpicture']; }else{ $MyBgPicture = $MasterB1; }
if($R['bgcolor'] != ""){ $MyBgColor = stripslashes($R['bgcolor']); }else{ $MyBgColor = stripslashes($MasterA1); }
if($R['text'] != ""){ $MyText = stripslashes($R['text']); }
if($R['link'] != ""){ $MyLink = stripslashes($R['link']); }
if($R['visited_link'] != ""){ $MyVLink = stripslashes($R['visited_link']); }
if($R['active_link'] != ""){ $MyALink = stripslashes($R['active_link']); }
if($R['left_margin'] != ""){ $MyLMargin = stripslashes($R['left_margin']); }else{ $MyLMargin=0 ;}
if($R['top_margin'] != ""){ $MyTMargin = stripslashes($R['top_margin']); }else{ $MyTMargin=0 ;}
if($R['margin_width'] != ""){ $MyMarginW = stripslashes($R['margin_width']); }
if($R['margin_height'] != ""){ $MyMarginH = stripslashes($R['margin_height']); }
if($R['img_tpr'] != "0"){ $MyImgTpr = stripslashes($R['img_tpr']); }*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php if($MyTitle==""){?>===== Welcome =====<?php }else{ echo $MyTitle; }?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #996699}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
<?php
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);

?>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td width="15%" background="mainpic/dd_06.jpg" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="74%" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="mytext_normal"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?php echo $text_genwebboard_auto1;?></td>
              </tr>
              <tr>
                <td>หรือ</td>
              </tr>
              <tr>
                <td><?php echo $text_genwebboard_auto2;?></td>
              </tr>
            </table>     </td>
          </tr>
          <tr>
            <td background="mainpic/krom1_11.jpg" class="mytext_normal">&nbsp;</td>
          </tr>
          <tr>
            <td class="mytext_normal"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" class="style1">หรือค้นหาจากกระทู้ : </td>
                  </tr>
                <tr>
                  <td width="5%" class="style1">&nbsp;</td>
                  <td width="95%" class="style1"><img src="mainpic/arrow_r.gif" width="7" height="7">12345</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td background="mainpic/krom1_11.jpg" class="mytext_normal">&nbsp;</td>
          </tr>
          <tr>
            <td class="mytext_normal"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" class="style1">หรือ Faq: </td>
                  </tr>
                <tr>
                  <td width="5%" class="style1">&nbsp;</td>
                  <td width="95%" class="style1"><img src="mainpic/arrow_r.gif" width="7" height="7">123457</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td background="mainpic/krom1_11.jpg" class="mytext_normal">&nbsp;</td>
          </tr>
          <tr>
            <td class="mytext_normal style1">By ระบบตอบAutomatic  </td>
          </tr>

          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td width="11%" background="mainpic/dd_07.jpg" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table>
    <br></td>
  </tr>
</table>
</body>
</html>
