<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
 
 //Initial var
 $data = $HTTP_POST_VARS['data'];
 $dest = "../ewt/".$_SESSION["EWT_SUSER"]."/ebook/"; //Source ebook
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
.font_basic {font-size: 12px;
	font-family: sans-serif, Arial, Helvetica;
	color: #003399;
	text-decoration: none;
}
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
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/ebook_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">การจัดการ E-Book</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("การจัดการ E-Book");?>&module=ebook&url=<?php echo urlencode("book_mgt.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp; 
	  <a href="mgt_ebook.php" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่ม E-Book  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
	  <a href="book_mgt.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
      การจัดการ</a><hr>
    </td>
</table>

  <table width="94%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
    <tr>
      <td valign="top"  class="MemberTitle">  
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td ><input type="hidden" name="curPage" value="1">
                ค้นหา E-Book
                <input type="text" name="data" value="<?php echo $data;?>">
              <input type="submit" name="Submit" value="ค้นหา"></td>
            </tr>
          </table>
        <table width="100%"   border="0" cellpadding="5" cellspacing="1" class="ewttableuse">
          <tr align="center" class="ewttablehead"> 
            <td width="5%" >&nbsp;</td>
            <td width="5%" >รหัส<!--Code--></td>
            <td width="10%"  >ชื่อ E-Book <!--Name--></td>
            <td width="10%" >รายละเอียด<!--Description--></td>
            <td width="10%" >จำนวนหน้า<!--Page--></td>
            <td width="10%" >ขนาด<!--Size--><br> <font color="#990000" size="-7">(pixel)</font></td>
            <td width="15%" >วันที่สร้าง<!--Date Create--></td>
            <td width="15%" >แก้ไขล่าสุด<!--Last Update--></td>
            <td width="10%" >ผู้สร้าง<!--Create by--></td>
            <td width="10%" >แสดง<!--Show--></td>
          </tr>
          <?php  
			
			   if (!empty($data)) {
			        $wh = " where ebook_name like '%$data%' or ebook_desc like '%$data%' ";
			   }
			   
			   $i=1;
			 	$sql1="select * from ebook_info $wh order by ebook_code";
				$exc1=mysql_query($sql1);
				$num_rows = mysql_num_rows($exc1);
				
				if(!$_GET[curPage]) $_GET[curPage]=1;
				$limit = 10;
				$Totalpages=ceil($num_rows/$limit);
				
				$start = ($_GET[curPage]-1)*$limit;
				$query=mysql_query($sql1."  LIMIT $start,$limit");
				$count=mysql_num_rows($query);
				
			   $num = 0;
			   while ($rec = $db->db_fetch_array ($query))  {		
			      $num++;   
				  
				  if ($bg=='#F7F7F7') {
				     $bg = '#ECECFF';
				  }else {
				     $bg = '#F7F7F7'; 
				  }
			?>
          <tr bgcolor="#FFFFFF"> 
		    <td align="center" valign="top" nowrap>
			<a href="mgt_page.php?ebookCode=<?php echo $rec['ebook_code'];?>"><img src="../theme/main_theme/g_apply.gif" width="16" height="16" alt="ปรับปรุงหน้า"  border="0"></a>
			<a href="<?php print $dest.$rec['ebook_code'];?>/index.html" target="_blank"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" alt="แสดงผล"></a>
			<a href="mgt_ebook.php?mode=edit&ebookCode=<?php echo $rec['ebook_code'];?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="ปรับปรุง E-book" border="0"></a>
			<a href="javascript:cfmDel('<?php echo $rec['ebook_code'];?>');"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" alt="ลบข้อมูล"></a>
			</td>
          
            <td height="25" align="center" valign="top"><a href="#article" onClick="parent.location.href='rss_index.php?cid=<?php echo $G["rss_id"]; ?>';"></a>
              <?php echo $rec['ebook_code'];?>
            </td>
            <td height="25" valign="top">  <?php echo $rec['ebook_name'];?> </td>
            <td  align="left" valign="top">
              <span class="style1">
              <?php echo nl2br($rec['ebook_desc']);?>
              </span></td>
			  
            <td height="25" valign="top" align="center">
              <?php 
					   print $db->db_num_rows($db->query("select ebook_code from ebook_page where ebook_code  like '$rec[ebook_code]' "));
					?>
            </td>
			  
            <td height="25" valign="top" align="center">  <?php echo $rec['ebook_w'];?>   X   <?php echo $rec['ebook_h'];?>  </td>
			  
            <td height="25" valign="top" align="center">
              <?php
					   $arrDate = explode ('-',$rec['create_date']);
					   print $arrDate['2'].'/'.$arrDate['1'].'/'.$arrDate['0'];
					 ?>
            </td>
			  
            <td height="25" valign="top" align="center">
              <?php
					   $arrDate = explode ('-',$rec['update_date']);
					   print $arrDate['2'].'/'.$arrDate['1'].'/'.$arrDate['0'];
					 ?>
            </td>
			  
            <td height="25" valign="top" align="center"> <?php echo $rec['ebook_by'];?> </td>
			  
            <td height="25" valign="top"  align="center">
              <?php
					 if ($rec['show_status']=='Y') {
					     print '<span class="style5">Yes</span>';
					}else {
					    print ' <span class="style6">No</span>';
					}
					?>
            </td> 
          </tr>
          <?php  } //while ?>
		    
          <?php		
			  			
			  			if($Totalpages==1){
								$p1=$p2=$p3=$p4=1;
						}else if($_GET[curPage]==1){
								$p1=1;
								$p2=$_GET[curPage];
								$p3=$_GET[curPage]+1;
								$p4=$Totalpages;
						}else if($_GET[curPage]==$Totalpages){
								$p1=1;
								$p2=$_GET[curPage]-1;
								$p3=$_GET[curPage];
								$p4=$Totalpages;
						}else{
								$p1=1;
								$p2=$_GET[curPage]-1;
								$p3=$_GET[curPage]+1;
								$p4=$Totalpages;
						}
						
						$search="&txtsearch=".$_GET['txtsearch']
			  ?>
          <tr>
            <td width="86%" bgcolor="#ffffff" colspan="10">&nbsp;&nbsp;<strong>หน้า :</strong> <!--( หน้า <?php echo $_GET[curPage]; ?> จากทั้งหมด <?php echo $Totalpages; ?> หน้า ) 
            <a href="?curPage=<?php echo $p1; ?>&data=<?php echo $data?>"><img src="../images/arrow_first.gif" alt="หน้าแรก" width="10" height="12" hspace="5" border="0" /></a> <a href="?curPage=<?php echo $p2; ?>&data=<?php echo $data;?>"><img src="../images/arrow_prev.gif" alt="ย้อนกลับ" width="7" height="12" hspace="3" border="0" /></a> <a href="?curPage=<?php echo $p3; ?>&data=<?php echo $data;?>"><img src="../images/arrow_next.gif" alt="ถัดมา" width="7" height="12" hspace="3" border="0" /></a> <a href="?curPage=<?php echo $p4; ?>&data=<?php echo $data;?>"><img src="../images/arrow_last.gif" alt="หน้าสุดท้าย" width="10" height="12" hspace="5" border="0" /></a> &nbsp;
			<br-->
			<?php if($_GET[curPage]>1){echo '<a href="?curPage='.($_GET[curPage]-1).'&data='.$data.'">&lt;&lt;กลับ</a>';}?>
			<?php for($i=1;$i<$_GET[curPage];$i++){  echo '<a href="?curPage='.$i.'&data='.$data.'">'.$i.'</a>'; }?>
			<strong>[<?php echo $i;?>]</strong> 
			 <?php for($i=$i+1;$i<=$Totalpages;$i++){  echo '<a href="?curPage='.$i.'&data='.$data.'">'.$i.'</a>'; }?>
            <?php if($_GET[curPage]<$Totalpages){ echo '<a href="?curPage='.($_GET[curPage]+1).'&data='.$data.'">ต่อไป &gt;&gt;</a>';}?>
			</td>
          </tr>
        </table> </td>
    </tr>
  </table>
</form>
</body>
</html>
<?php $db->db_close(); ?>
