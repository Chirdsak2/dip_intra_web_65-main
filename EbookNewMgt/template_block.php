<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
 
 //Initial var
 $data = $HTTP_POST_VARS['data'];
 $dest = "../ewt/".$_SESSION["EWT_SUSER"]."/ebook/"; //Source ebook
 
  if (!empty($data)) {
			        $wh = " where ebook_name like '%$data%' or ebook_desc like '%$data%' ";
			   }
			   $query = $db->query ("select * from ebook_info $wh order by ebook_code");
			   $numRows = $db->db_num_rows ($query);
	?>
<html>
<head>
<title>E-Book</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.head_table {	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
}
.style1 {color: #666666}
.style5 {color: #FF6600}
.style6 {color: #333333}
-->
</style>
<script language="javascript">
     function cfmDel (ref) {
      if (confirm ("ยืนยันการลบ E-Book รหัส "+ref)) {
	       self.location.href='proc_ebook.php?proc=delEbook&ebookCode='+ref;		   
	  }
   }
</script>
</head>
<body leftmargin="0" topmargin="0" >
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="FFFFFF">
    <tr>
      <td valign="top" bgcolor="#F4F4F4" class="MemberTitle"><span >E-Book</span>
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td>Search:
              <input name="data" type="text" value="<?php echo $data;?>" size="15">
            <input type="submit" name="Submit" value="Ok"></td>
          </tr>
    <tr>
      <td>ค้นหา <?php echo $numRows;?> รายการ </td>
    </tr>
    </table>
          <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
            <input type="hidden" name="Flag" value="DelGroup">
            <input type="hidden" name="cid" >
            <input type="hidden" name="rss_title" >
            <input type="hidden" name="rss_url" >
            <input type="hidden" name="rss_row" >
           
            <?php  
			
			  
			   $num = 0;
			   while ($rec = $db->db_fetch_array ($query))  {		
			      $num++;   
				  
				  if ($bg=='#F7F7F7') {
				     $bg = '#ECECFF';
				  }else {
				     $bg = '#F7F7F7'; 
				  }
			?>
            <tr>
              <td height="25" align="left" valign="top">
			 <a href="<?php print $dest.$rec['ebook_code'];?>/index.html" target="_blank"> - <?php echo $rec['ebook_name'];?></a>
                (<span class="style1"><?php 
					   print $db->db_num_rows($db->query("select ebook_code from ebook_page where ebook_code  like '$rec[ebook_code]' "));
					?>
page</span>) </td>
            </tr>
            <?php  } //while ?>
      </table></td></tr>
  </table>
</form>
</body>
</html>
<?php $db->db_close(); ?>
