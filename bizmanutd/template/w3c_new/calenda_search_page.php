<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
@include("../language/language.php");
$text_status = "Search File & Folder.";
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">

				
			function sendfile(c){
					self.top.window.opener.AddForm.event_link.value =  "main.php?filename=" + c;
					window.close();
			}
</script>
</head>
<body >
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>

 <table width="100%"  border="0" cellpadding="0" cellspacing="0">
 <tr>
    <td height="40" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;&nbsp; 
      <form name="formSearch" method="post" action="calenda_search_page.php"> <?php echo $text_Gencalenda_Search;?>
      
        <input name="c_search" type="text" id="c_search" value="<?php echo $_POST["c_search"]; ?>" size="30">
        <input type="submit" name="Submit" value="<?php echo $text_Gencalendar_Search;?>">
      <input name="Flag" type="hidden" id="Flag" value="Search"> </form></td>
  </tr>
    <tr>
    <td  bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td  bgcolor="#FFFFFF"></td>
  </tr>
<tr>
    <td  bgcolor="F9FAFD"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="59%" align="center"><?php echo $text_Gencalendar_name;?></td>
          <td width="1"><font color="#9D9EB7" size="2">|</font></td>
          <td width="20%" align="center"><?php echo $text_Gencalendar_Location;?></td>
          <td align="center"><font color="#9D9EB7" size="2">|</font></td>
          <td width="21%" align="center"><?php echo $text_Gencalendar_Select;?></td>
        </tr>
      </table></td>
  </tr>
    <tr>
    <td  bgcolor="B5B6C8"></td>
  </tr>
  <tr>
    <td  bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td valign="top"> 
      <?php
	if($_POST["Flag"] == "Search"){
	$wh= "WHERE temp_index.filename LIKE '%".$_POST["c_search"]."%' ";
	}
	$i = 0;
	$count_folder = 0;
   	$count_file = 0;
	?>
      <DIV align="center"  style="scrollbar-face-color: # ff6699; left: 306px; float: right; overflow-x: hidden; overflow: scroll;  scrollbar-3dlight-color: #000000; scrollbar-arrow-color: #ffffff; scrollbar-base-color: #ffffff; HEIGHT: 350px ">
		 <form name="form1" method="post" action="">  <table width="100%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
		 
          <?php

  $sql_page = $db->query("SELECT temp_index.filename,temp_main_group.Main_Group_Name,temp_main_group.Main_Group_ID FROM temp_index INNER JOIN temp_main_group ON temp_index.Main_Group_ID = temp_main_group.Main_Group_ID $wh ORDER BY temp_index.filename ASC");//WHERE temp_index.filename LIKE '%".$_POST["c_search"]."%' 
  	while($P = $db->db_fetch_row($sql_page)){
  ?>
          <tr> 
            <td width="60%" bgcolor="#FFFFFF">&nbsp;&nbsp; <img src="../mainpic/bb1.jpg" alt="ดูหน้าเว็บ" width="16" height="16"  style="cursor:hand" onClick="window.open('calendar_view_link.php?flag=link&img_name=main.php?filename=<?php echo $P[0];?>','','width=500 , height=400,scrollbars=1,resizable = 1');"> <?php echo $P[0]; ?> </td>
            <td width="20%" align="center" bgcolor="#FFFFFF"><?php echo $P[1]; ?></td>
            <td width="20%" align="center" bgcolor="#FFFFFF"><a href="#" onClick="sendfile('<?php echo $P[0]; ?>')"><?php echo $text_Gencalendar_Select;?></a></td>
          </tr>
          <?php
  $count_file++;
   $i++; } ?>
            <tr> 
              <td  bgcolor="F7F7F7">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
        </table>
		   <input name="num" type="hidden" id="num" value="0">
		  </form>
<?php 
if($i == 0){
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> <td align="center"><font color="#FF0000"><?php echo $text_Gencalendar_nodata;?> '<?php echo $_POST["c_search"]; ?>'</font></td></tr>
</table>
<?php  }  ?>
</DIV>
<?php $text_status = "Found : ".$count_folder." Folder";
				if($count_folder >1){
				$text_status .= "s"; 
				} 
            	$text_status .= " and ".$count_file." file";
				if($count_file >1){
				$text_status .= "s"; 
				}
				$text_status .= "."; 
  ?>
</td>
  </tr>
</table>

<script language="JavaScript" type="text/javascript">
document.formSearch.c_search.focus();
//top.content_bottom.document.all.txt_status.innerHTML = "<?php//php echo $text_status; ?>";
</script>

</body>
</html>
<?php $db->db_close(); ?>
