<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
 session_unregister('g_ebook_id');
 //Initial var
 $dest = "../ewt/".$_SESSION["EWT_SUSER"]."/ebook/"; //Source ebook
 
 $data = $_REQUEST['data'];
 if (!empty($data)) {
			  $wh = " where g_ebook_name like '%$data%' ";
}

$sel = "select * from ebook_group $wh order by g_ebook_id asc";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;

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
     function cfmDel (gname,ref) {
      if (confirm ("ยืนยันการลบกลุ่ม "+gname)) {
	       self.location.href='proc_ebookg.php?proc=delEbook&ebookCode='+ref;		   
	  }
   }
</script>
</head>
<body leftmargin="0" topmargin="0" >
<form name="form1" method="post" action="bookg_mgt.php">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/ebook_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">การจัดการกลุ่ม E-Book</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("การจัดการกลุ่ม E-Book");?>&module=ebook&url=<?php echo urlencode("bookg_mgt.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp; 
	  <a href="mgt_ebookg.php" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มกลุ่ม E-Book  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
	  <a href="bookg_mgt.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
      การจัดการกลุ่ม</a><hr>
    </td>
</table>

  <table width="94%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
    <tr>
      <td valign="top"  class="MemberTitle">  
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td ><input type="hidden" name="curPage" value="1">
                ค้นหากลุ่ม E-Book
                <input type="text" name="data" value="<?php echo $data;?>">
              <input type="submit" name="Submit" value="ค้นหา"></td>
            </tr>
          </table>
        <table width="100%"   border="0" cellpadding="5" cellspacing="1" class="ewttableuse">
          <tr align="center" class="ewttablehead"> 
            <td width="5%" >&nbsp;</td>
            <td width="85%"  >ชื่อกลุ่ม E-Book <!--Name--></td>
            <td width="10%" >จำนวนหนังสือ<!--Number--></td>
            <!--<td width="10%" >แสดง<!--Show</td>-->
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
				  
				  $sql3="select COUNT(ebook_id) as CountBook from ebook_info where  g_ebook_id = '$rec[g_ebook_id]' ";
				 $exc3=$db->query($sql3);
				 $CountBook =  $db->db_fetch_array($exc3);
			?>
          <tr bgcolor="#FFFFFF"> 
		    <td align="center" valign="top" nowrap>
			<a href="mgt_ebookg.php?mode=edit&ebookCode=<?php echo $rec['g_ebook_id'];?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="ปรับปรุงกลุ่ม E-book" border="0"></a>
			<?php if($CountBook[CountBook]>0){?>
			<img src="../theme/main_theme/g_not_allow.png" width="16" height="16" border="0" alt="ห้ามลบข้อมูล">
			<?php }else{?>
			<a href="javascript:cfmDel('<?php echo $rec['g_ebook_name'];?>','<?php echo $rec['g_ebook_id'];?>');"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" alt="ลบข้อมูล"></a>
			<?php }?>
			</td>
            <td height="25" valign="top"> <a href="book_mgt_list.php?ebookCode=<?php echo $rec['g_ebook_id'];?>"><?php echo $rec['g_ebook_name'];?></a> </td>
			 <td height="25" valign="top"  align="center">  <?php   echo $CountBook[CountBook];  ?>  </td> 
			 <!--<td height="25" valign="top"  align="center">
              <?php
					 if ($rec['g_ebook_status']=='Y') {
					     print '<span class="style5">Yes</span>';
					}else {
					    print ' <span class="style6">No</span>';
					}
					?>
            </td> -->
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
