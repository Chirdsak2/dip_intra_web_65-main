<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
@include("../blog/lib/blog_config.php");
@include("language/language.php");
?>
<html>
<head>
<title>Blog</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td align="center" valign="top" bgcolor="#FFFFFF"><br>
                  <table width="98%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666"><?php echo $text_GenBlog_textheader;?></font></strong></font></td>
                    </tr>
                  </table><br>
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

<form name="frm" action="blog_list.php" method="post">
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td width="35%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="AAAAAA">
      <tr>
        <td height="25" background="blog/images/bg_title.jpg" bgcolor="#FFFFFF" class="font_basic">&nbsp;&nbsp;<strong><?php echo $text_GenBlog_UpdateBlog;?></strong></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="5" class="font_basic">
    <?php
		
		$sql_profile="SELECT * FROM `blog_list` ORDER BY  `blog_list`.`blog_lastdate`,`blog_list`.`blog_pin` DESC LIMIT 0,10";
		$exc_profile=mysql_query($sql_profile)or die("Error: ". mysql_error(). " with query ". $query);
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
              <td width="100" height="100" align="center" valign="middle"><table width="108" height="108" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A8AAE">
                <tr>
                  <td align="center" bgcolor="#FFFFFF"><img src="phpThumb.php?src=../blog/images_profile/<?php echo $photo_name; ?>&h=100&w=100" border="0" align="absmiddle" ></td>
                </tr>
              </table></td>
              <td valign="top"><div><a href="<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank"><b><font  class="font_basic"><?php echo $row_profile[blog_title]; ?></font></b></a>&nbsp;<?php if($row_profile['blog_pin']=='1') { echo '<img src="mainpic/pin.jpg" width="18" height="18" />'; } ?></div>
			 <!-- <div><?php//php echo $text_GenBlog_name;?>: <?php//php echo $row_profile[blog_name]; ?></div>-->
			  <div><?php echo $text_GenBlog_Update;?>: <?php echo $sp_date[2]."/".$sp_date[1]."/".($sp_date[0]+543); ?> <?php echo ($sp_time[0]*1).":".$sp_time[1] ?></div></td>
            </tr>
          <?php
	  		}
	  		?>
        </table></td>
      </tr>
    </table></td>
    <td width="35%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="AAAAAA">
      <tr>
        <td height="25" background="blog/images/bg_title.jpg" bgcolor="#FFFFFF" class="font_basic">&nbsp;&nbsp;<strong><?php echo $text_GenBlog_texttoptentopvote;?> </strong></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="5" class="font_basic">
            <?php
		
		$sql_profile="SELECT * FROM `blog_list` ORDER BY  `blog_list`.`blog_rate`,`blog_list`.`blog_pin` DESC LIMIT 0,10";
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
              <td width="100" height="100" align="center" valign="middle"><table width="108" height="108" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A8AAE">
                  <tr>
                    <td align="center" bgcolor="#FFFFFF"><img src="phpThumb.php?src=../blog/images_profile/<?php echo $photo_name; ?>&h=100&w=100" border="0" align="absmiddle" ></td>
                  </tr>
              </table></td>
              <td valign="top"><div><a href="<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank"><b><font  class="font_basic"><?php echo $row_profile[blog_title]; ?></font></b></a>&nbsp;<?php if($row_profile['blog_pin']=='1') { echo '<img src="mainpic/pin.jpg" width="18" height="18" />'; } ?></div>
                  <!--<div><?php//php echo $text_GenBlog_name;?>: <?php//php echo $row_profile[blog_name]; ?></div>-->
                <div><?php echo $text_GenBlog_Update;?>: <?php echo $sp_date[2]."/".$sp_date[1]."/".($sp_date[0]+543); ?> <?php echo ($sp_time[0]*1).":".$sp_time[1] ?></div>
                <div><?php echo $text_GenBlog_textcount;?>: <?php echo $row_profile[blog_rate]; ?></div>
				<div><?php echo $text_GenBlog_textVote;?>: <?php echo $row_profile[blog_number]; ?> <?php echo $text_GenBlog_texttime;?></div></td>
            </tr>
            <?php
	  		}
	  ?>
        </table></td>
      </tr>
    </table></td>
    <td width="30%" valign="top">   <?php
		if($_SESSION["EWT_MID"]){
?>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CC99CC" class="font_basic">
          <tr>
            <td height="30" align="center" bgcolor="#DEDEEF" style="cursor:hand;"><?php 
		$sql_profile="SELECT * FROM `blog_list` WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";
		$exc_profile=mysql_query($sql_profile);
		$count_profile=mysql_num_rows($exc_profile);
		$row_profile=mysql_fetch_array($exc_profile);
		
		if($count_profile>0){
		?>
              <a href="<?php echo $blog_url; ?>?blog_id=<?php echo  $row_profile[blog_id]; ?>" target="_blank"><b><?php echo $text_GenBlog_manageblog;?></b></a>
              <?php
		}else{
		?>
              <a href="<?php echo $blog_url; ?>blog_install.php" target="_blank"><b><?php echo $text_GenBlog_configblog;?></b></a>
              <?php
		}
		?></td>
          </tr>
      </table><br />
    <?php
		}  
?>
    
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="AAAAAA">
      <tr>
        <td height="25" background="blog/images/bg_title.jpg" bgcolor="#FFFFFF" class="font_basic">&nbsp;&nbsp;<strong><?php echo $text_GenBlog_textsearchblog;?></strong></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="5" cellpadding="2">
          <tr>
            <td class="font_basic"><?php echo $text_GenBlog_textBlogname;?> :<br />
              <input name="txtblog" type="text" class="font_basic" id="txtblog" size="40" /></td>
          </tr>
         <!-- <tr>
            <td class="font_basic"><?php//php echo $text_GenBlog_textBlogcat;?> :<br />
              <select name="selcat" class="font_basic" id="selcat">
			  <option value=""><?php//php echo $text_GenBlog_textBlogselet ;?></option>
              </select>              </td>
          </tr>
          <tr>
            <td class="font_basic"><?php//php echo $text_GenBlog_name;?>:<br />
              <input name="txtname" type="text" class="font_basic" id="txtname" size="40" /></td>
          </tr>
          <tr>
            <td class="font_basic"><?php//php echo $text_GenBlog_textposition;?>:<br />
              <input name="txtposition" type="text" class="font_basic" id="txtposition" size="40" /></td>
          </tr>
          <tr>
            <td class="font_basic"><?php//php echo $text_GenBlog_textunit;?>:<br />
              <input name="txtdept" type="text" class="font_basic" id="txtdept" size="40" /></td>
          </tr>-->
          <tr>
            <td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <!--<td width="36%"><a href="#"  class="font_small">More option</a></td>-->
                <td width="64%" align="right"><input name="hid" type="hidden" id="hid" value="0" />
                    <input name="Submit2" type="submit" class="botton1" value="<?php echo $text_GenBlog_textbuttonSearch;?>" />
                    <input name="Button" type="button" class="botton1" value="<?php echo $text_GenBlog_textbuttonClear;?>" /></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<script>
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

                </td>
              </tr>
            </table></td>
          <td width="5" height="100%" background="mainpic/bg_r.gif"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
