<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


if($_GET['ebookCode']){
	$_SESSION['g_ebook_id']=$_GET['ebookCode'];
 }
 //Initial var
 $data = $_REQUEST['data'];
 $dest = "../ewt/".$_SESSION["EWT_SUSER"]."/ebook/"; //Source ebook
 
 if (!empty($data)) {
			$wh = "and ebook_name like '%$data%' or ebook_desc like '%$data%' ";
}

$sel = "select ebook_group.g_ebook_name,ebook_info.* from ebook_info inner join ebook_group on  ebook_info.g_ebook_id = ebook_group.g_ebook_id where ebook_info.g_ebook_id = '".$_SESSION['g_ebook_id']."' $wh order by ebook_id desc";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = $db->db_num_rows($ExecSel);
$G = $db->db_fetch_row($ExecSel);
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
<title>E-Book</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet"> 
<link href="../EWT_ADMIN/style.css" rel="stylesheet"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/backend_style.css"/>
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
	       self.location.href='proc_ebook.php?proc=delEbook&ebookCode='+ref+'&ebookCodegroup=<?php echo $_SESSION['g_ebook_id'];?>';		   
	  }
   }
</script>
</head>
<body leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="form1" method="post" action="book_mgt_list.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/ebook_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">การจัดการ E-Book</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <td align="right">
	<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("การจัดการกลุ่ม E-Book : ".$G[0]);?>&module=ebook&url=<?php echo urlencode("book_mgt_list.php?ebookCode=".$_GET['ebookCode']);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp; 
	  <a href="mgt_ebook.php" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่ม E-Book  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
	  <a href="bookg_mgt.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
      การจัดการกลุ่ม</a><hr>
    </td>
</table>
  <br>
  <table width="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
    <tr>
      <td valign="top"  class="MemberTitle">  
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td ><input type="hidden" name="curPage" value="1">
                ค้นหา E-Book
                <input type="text" name="data" value="<?php echo $data;?>"class="form-control"   style="width:30%;">
              <input type="submit" name="Submit" value="ค้นหา" class="btn btn-success" /></td>
            </tr>
          </table>
		  <br>
        <table width="100%"   align="center" class="table table-bordered">
          <tr align="center" class="ewttablehead"> 
            <td width="5%" >&nbsp;</td>
            <td width="5%" >รหัส<!--Code--></td>
            <td width="15%"  >ชื่อ E-Book <!--Name--></td>
            <td width="15%" >รายละเอียด<!--Description--></td>
            <td width="10%" >จำนวนหน้า<!--Page--></td>
            <td width="10%" >ขนาด<!--Size--><br> <font color="#990000" size="-7">(pixel)</font></td>
            <td width="15%" >วันที่สร้าง<!--Date Create--></td>
            <td width="15%" >แก้ไขล่าสุด<!--Last Update--></td>
            <td width="10%" >ผู้สร้าง<!--Create by--></td>
          </tr>
          <?php  
				
			   $num = 0;
			   while ($rec = $db->db_fetch_array ($Execsql))  {		
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
			<!-- 
            <td height="25" valign="top"  align="center">
              <?php
					 if ($rec['show_status']=='Y') {
					     print '<span class="style5">Yes</span>';
					}else {
					    print ' <span class="style6">No</span>';
					}
					?>
            </td>
			-->
          </tr>
          <?php  } //while ?>
		    <?php if($rows > 0){ ?>
                    <tr bgcolor="#FFFFFF"> 
                      <td height="25" colspan="15" valign="top"><?php echo $text_general_page;?> :
                        <?php
								// Begin Prev/Next Links 
								// Don't display PREV link if on first page 
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?offset=$prevoffset&data=$data'>
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
											echo  "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\"". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\">
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
		</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php $db->db_close(); ?>
