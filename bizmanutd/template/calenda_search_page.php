<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
include("../../ewt_public_function.php");
@include("language/language.php");
$text_status = "Search File & Folder.";
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">

				
			function sendfile(c){
					self.top.window.opener.AddForm.event_link.value =  "main.php?filename=" + c;
					window.close();
			}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <form name="formSearch" method="post" action="calenda_search_page.php"><tr>
    <td height="40" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;&nbsp; 
      <?php echo $text_Gencalenda_Search;?>
      
        <input name="c_search" type="text" id="c_search" value="<?php echo $_POST["c_search"]; ?>" size="30">
        <input type="submit" name="Submit" value="<?php echo $text_Gencalendar_Search;?>">
      <input name="Flag" type="hidden" id="Flag" value="Search"> </td>
  </tr></form>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
<tr>
    <td height="20" bgcolor="F9FAFD"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
    <td height="1" bgcolor="B5B6C8"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
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
      <DIV align="center"  style="OVERFLOW-Y:scroll;HEIGHT: 100%;WIDTH: 100%">
		  <table width="100%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
		  <form name="form1" method="post" action="">
          <?php

  $sql_page = $db->query("SELECT temp_index.filename,temp_main_group.Main_Group_Name,temp_main_group.Main_Group_ID FROM temp_index INNER JOIN temp_main_group ON temp_index.Main_Group_ID = temp_main_group.Main_Group_ID $wh ORDER BY temp_index.filename ASC");//WHERE temp_index.filename LIKE '%".$_POST["c_search"]."%' 
  	while($P = $db->db_fetch_row($sql_page)){
  ?>
          <tr> 
            <td width="60%" height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <img src="mainpic/bb1.jpg" align="absmiddle" onClick="window.open('calendar_view_link.php?flag=link&img_name=main.php?filename=<?php echo $P[0];?>','','width=500 , height=400,scrollbars=1,resizable = 1');" style="cursor:hand" alt="ดูหน้าเว็บ"> <?php echo $P[0]; ?> </td>
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
     <input name="num" type="hidden" id="num" value="0">
  </form>
        </table>
<?php 
if($i == 0){
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> <td height="50" align="center"><font color="#FF0000"><?php echo $text_Gencalendar_nodata;?> '<?php echo $_POST["c_search"]; ?>'</font></td></tr>
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
<script language="JavaScript">
document.formSearch.c_search.focus();
//top.content_bottom.document.all.txt_status.innerHTML = "<?php//php echo $text_status; ?>";
</script>
</body>
</html>
<?php $db->db_close(); ?>
