<?php
$path = '../';
session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$blog_url ="../../blog/";
@include("../language/language.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title>Blog</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.font_basic {
	font-size: 12px;
	font-family: sans-serif, Arial, Helvetica;
	color: #003399;
	text-decoration: none;
}
.font_small {
	font-size: 10px;
	font-family: sans-serif,Arial, Helvetica ;
}
.botton1{
	background-image: url(blog/images/button_bg.gif);
	background-color: #FFFFFF;
	border: 1px solid #333333;
}
-->
</style>

</head>

<body>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800"  border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%"  style="background:url(../mainpic/bg_l.gif)"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770"  border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td align="center" valign="top" bgcolor="#FFFFFF"><br>
                  <table width="98%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666"><?php echo $text_GenBlog_textheader;?></font></strong></font></td>
                    </tr>
                  </table><br>

<form name="frm" action="blog_list.php" method="post">
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td width="35%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="AAAAAA">
      <tr>
        <td height="25" style="background:url(../../blog/images/bg_title.jpg)" bgcolor="#FFFFFF" class="font_basic">&nbsp;&nbsp;<strong><?php echo $text_GenBlog_UpdateBlog;?></strong></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="5" class="font_basic">
    <?
		
		$sql_profile="SELECT * FROM `blog_list` ORDER BY  `blog_list`.`blog_lastdate` DESC LIMIT 0,10";
		$exc_profile=mysql_query($sql_profile);
		$count_profile=mysql_num_rows($exc_profile);
		while($row_profile=mysql_fetch_array($exc_profile)){
				$photo_name="nophoto.jpg";
				if($row_profile[blog_picture]){
					$photo_name=$row_profile[blog_picture];
				}
				
				$sp_datetime=split(" ",$row_profile[blog_lastdate]);
				$sp_date=split("-",$sp_datetime[0]);
				$sp_time=split(":",$sp_datetime[1]);
				
	?>
            <tr>
              <td width="100" height="100" align="center" valign="middle"><table width="108"  border="0" cellpadding="3" cellspacing="1" bgcolor="#3A8AAE">
                <tr>
                  <td align="center" bgcolor="#FFFFFF"><img src="../phpThumb.php?src=../blog/images_profile/<?php echo $photo_name; ?>&amp;h=100&amp;w=100" border="0" alt="<?php echo $row_profile[blog_title]; ?>" ></td>
                </tr>
              </table></td>
              <td valign="top"><div><a href="<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank" accesskey=<?php echo $db->genaccesskey();?>><b><font  class="font_basic"><?php echo $row_profile[blog_title]; ?></font></b></a></div>
			  <div><?php echo $text_GenBlog_Update;?>: <?php echo $sp_date[2]."/".$sp_date[1]."/".($sp_date[0]+543); ?> <?php echo ($sp_time[0]*1).":".$sp_time[1] ?></div></td>
            </tr>
          <?
	  		}
	  		?>
        </table></td>
      </tr>
    </table></td>
    <td width="35%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="AAAAAA">
      <tr>
        <td height="25" style="background:url(../../blog/images/bg_title.jpg)"   bgcolor="#FFFFFF" class="font_basic">&nbsp;&nbsp;<strong><?php echo $text_GenBlog_texttoptentopvote;?> </strong></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="5" class="font_basic">
            <?
		
		$sql_profile="SELECT * FROM `blog_list` ORDER BY  `blog_list`.`blog_rate` DESC LIMIT 0,10";
		$exc_profile=mysql_query($sql_profile);
		$count_profile=mysql_num_rows($exc_profile);
		while($row_profile=mysql_fetch_array($exc_profile)){
				$photo_name="nophoto.jpg";
				if($row_profile[blog_picture]){
					$photo_name=$row_profile[blog_picture];
				}
				
				$sp_datetime=split(" ",$row_profile[blog_lastdate]);
				$sp_date=split("-",$sp_datetime[0]);
				$sp_time=split(":",$sp_datetime[1]);
				
	?>
            <tr>
              <td width="100" height="100" align="center" valign="middle"><table width="108"  border="0" cellpadding="3" cellspacing="1" bgcolor="#3A8AAE">
                  <tr>
                    <td align="center" bgcolor="#FFFFFF"><img src="../phpThumb.php?src=../blog/images_profile/<?php echo $photo_name; ?>&amp;h=100&amp;w=100" border="0"  alt="<?php echo $row_profile[blog_title]; ?>"></td>
                  </tr>
              </table></td>
              <td valign="top"><div><a href="<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank" accesskey=<?php echo $db->genaccesskey();?>><b><font  class="font_basic"><?php echo $row_profile[blog_title]; ?></font></b></a></div>
                <div><?php echo $text_GenBlog_Update;?>: <?php echo $sp_date[2]."/".$sp_date[1]."/".($sp_date[0]+543); ?> <?php echo ($sp_time[0]*1).":".$sp_time[1] ?></div>
                <div><?php echo $text_GenBlog_textcount;?>: <?php echo $row_profile[blog_rate]; ?></div>
				<div><?php echo $text_GenBlog_textVote;?>: <?php echo $row_profile[blog_number]; ?> <?php echo $text_GenBlog_texttime;?></div></td>
            </tr>
            <?
	  		}
	  ?>
        </table></td>
      </tr>
    </table></td>
    <td width="30%" valign="top">   <?
		if($_SESSION["EWT_MID"]){
?>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CC99CC" class="font_basic">
          <tr>
            <td height="30" align="center" bgcolor="#DEDEEF" style="cursor:hand;"><? 
		$sql_profile="SELECT * FROM `blog_list` WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";
		$exc_profile=mysql_query($sql_profile);
		$count_profile=mysql_num_rows($exc_profile);
		$row_profile=mysql_fetch_array($exc_profile);
		
		if($count_profile>0){
		?>
              <a href="<?php echo $blog_url; ?>?blog_id=<?php echo  $row_profile[blog_id]; ?>" target="_blank" accesskey=<?php echo $db->genaccesskey();?>><b><?php echo $text_GenBlog_manageblog;?></b></a>
              <?
		}else{
		?>
              <a href="<?php echo $blog_url; ?>blog_install.php" target="_blank" accesskey=<?php echo $db->genaccesskey();?>><b><?php echo $text_GenBlog_configblog;?></b></a>
              <?
		}
		?></td>
          </tr>
      </table><br >
    <?
		}  
?>
    
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="AAAAAA">
      <tr>
        <td height="25" style="background:url(../../blog/images/bg_title.jpg)" bgcolor="#FFFFFF" class="font_basic">&nbsp;&nbsp;<strong><?php echo $text_GenBlog_textsearchblog;?></strong></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="5" cellpadding="2">
          <tr>
            <td class="font_basic"><?php echo $text_GenBlog_textBlogname;?> :<br >
              <input name="txtblog" type="text" class="font_basic" id="txtblog" size="40" ></td>
          </tr>
         
          <tr>
            <td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="64%" align="right"><input name="hid" type="hidden" id="hid" value="0" >
                    <input name="Submit2" type="submit" class="botton1" value="<?php echo $text_GenBlog_textbuttonSearch;?>" >
                    <input name="Button" type="button" class="botton1" value="<?php echo $text_GenBlog_textbuttonClear;?>" ></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<script language="javascript" type="text/javascript">
function show_more(){
		if(frm.hid.value==0){
				document.all.t1.style.display='';
				document.all.t2.style.display='';
				document.all.t3.style.display='';
				frm.hid.value=1;
		}else{
				document.all.t1.style.display='none';
				document.all.t2.style.display='none';
				document.all.t3.style.display='none';
				frm.hid.value=0;
		}
}
</script>
<a href="http://validator.w3.org/check?uri=referer" ><img src="images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
                </td>
              </tr>
            </table></td>
          <td width="5"   style="background:url(../mainpic/bg_r.gif)"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
