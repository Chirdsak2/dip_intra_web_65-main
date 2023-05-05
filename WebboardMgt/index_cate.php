<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../lib/set_lang.php");
$session_id = isset( $HTTP_COOKIE_VARS['phpbb2mysql_sid'] ) ? $HTTP_COOKIE_VARS['phpbb2mysql_sid'] : '';

 $data = $_REQUEST['data'];
 if (!empty($data)) {
			  $wh = " where c_name like '%$data%'  OR c_detail like '%$data%'  ";
}

$sel = "SELECT * FROM w_cate  $wh ORDER BY c_level,c_id ASC";

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


$row = mysql_num_rows($Execsql);


 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="../BannerMgt/js/jquery/jquery.core.js"></script>
<script src="../BannerMgt/js/jquery/jquery.tablednd.js"></script>
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
.style2 {
	color: #005CA2;
	font-weight: bold;
}
-->
</style>
<script language="javascript1.2">
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
		function txt_data(w,g) {
	
	var mytop = findPosY(document.getElementById("lang"+w)) +document.getElementById("lang"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("lang"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='../language_set.php?gid='+g+'&id='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function txt_data1(w,g,lang) {

	 window.location.href='../multilangMgt/webboard_cat.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>

</head>

<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
	
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
    <tr>
      <td width="100%" height="100%" valign="top" bgcolor="#F3F3EE">
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="A3C7E2">
<?php
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
?>
  <!--<tr>
    <td width="18%" height="25" bgcolor="F3F3EE" class="style2"><!--<a href="../ewt/<?php//php echo $EWT_FOLDER_USER;?>/board/admin/index.php?sid=<?php//php echo $session_id;?>" target="_blank">เข้าสู่กระทู้ phpbb2 </a></td>
    <td width="9%" bgcolor="F3F3EE" class="style2"><a href="emotion_list.php">emotion</a></td>
    <td width="16%" align="center" bgcolor="F3F3EE"><span class="style2"><a href="subadmin.php">บริหารผู้ดูแลหมวดกระทู้</a></span></td>
	<td width="9%" align="center" bgcolor="F3F3EE"><strong><a href="admin.php">config ค่า</a></strong></td>
	<td width="9%" align="center" bgcolor="F3F3EE" class="style2"><a href="professor_list.php">ผู้เชี่ยวชาญ</a></td>
    <td width="14%" align="right" bgcolor="F3F3EE"><strong><a href="report_webboard2.php">รายงานการใช้งาน</a></strong></td>
    <td width="16%" align="right" bgcolor="F3F3EE"><span class="style2"><a href="report_webboard_stat2.php">สถิติการเข้าWebboard</a></span></td>
  </tr>-->
   <tr>
    <td height="1" colspan="11" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td colspan="8" valign="top" bgcolor="#FFFFFF"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">หมวดกระทู้</span> </td>
      </tr>
    </table>
      <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
        <tr>
          <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("หมวดกระทู้");?>&module=webboard&url=<?php echo urlencode("index_cate.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <?php if( $db->check_permission("webboard","g",'0') ){ ?><a href="edit_cate.php?flag=category"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่มหมวด</a>
		 <?php } ?>
              <hr>
          </td>
        </tr>
      </table>
	  
	    <table width="94%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
         <tr>
             <td valign="top"  class="MemberTitle">  
					<table width="100%" border="0" cellspacing="1" cellpadding="3">
					 <form method="post" action="index_cate.php">
									<tr>
									  <td ><input type="hidden" name="curPage" value="1">
										ค้นหาหมวดกระทู้
										<input type="text" name="data" value="<?php echo $data;?>">
									  <input type="submit" name="Submit" value="ค้นหา"></td>
									</tr>
					</form>	
					</table>
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse" id="table-1">
					  <form name="form2" method="post" action="question_function.php">
	                      <input type="hidden" name="flag" value="">
					  <tr align="center" bgcolor="#FFCC99" class="nodrop nodrag ewttablehead">
						<td height="25" class="head_font"></td>
						<td height="25" class="head_font">หมวดของกระทู้</td>
						<td class="head_font">ภาษาอื่น</td>
						<td width="17%">จำนวนกระทู้ใหม่ที่<br>ยังไม่ได้อนุมัติ่</td>
						<td width="18%">จำนวนผู้ตอบใหมที่<br>
						  ยังไม่ได้อนุมัติ</td>
						<td width="3%">ใช้ RSS</td>
						<td width="4%">ลำดับ</td>
					  </tr>
					  <?php
			  if($row > 0){
			  $i = 0;
			  
			  if( $db->check_permission("webboard","g",'0') || $db->check_permission("webboard","a",'0') ){
				  $pass='Y';
			  }
			   while($R = mysql_fetch_array($Execsql)){ 
			   
			   if(($db->check_permission("webboard","g",$R[c_id]) || $db->check_permission("webboard","a",$R[c_id])) ||  $pass=='Y'  ){
			   
					if( $db->check_permission("webboard","a",$R[c_id]) ){ $pass_a='Y';   }else{$pass_a='N'; }
					if( $db->check_permission("webboard","g",$R[c_id]) ){ $pass_g='Y';   }else{$pass_g='N'; }
				 
			   $count = $db->query("SELECT * FROM w_question WHERE c_id = '$R[c_id]' AND s_id != '1'");
			   $countrow = mysql_num_rows($count);
			  $count1 = $db->query("SELECT DISTINCT(w_answer.a_id) FROM w_answer,w_question WHERE w_question.t_id = w_answer.t_id AND w_question.c_id = '$R[c_id]' AND w_answer.s_id != '1'");
			   $countrow1 = mysql_num_rows($count1);
					if($R["c_rss"]=='Y'){
						 $checked= "checked";
						 $filename="../ewt/".$_SESSION["EWT_SUSER"]."/rss/webboard".$R["c_id"].".xml";
						 if(file_exists($filename)){
							 $link='<a href="../ewt/'.$_SESSION["EWT_SUSER"].'/rss/webboard'.$R["c_id"].'.xml" target="_blank"><img src="../theme/main_theme/g_rss.gif" border="0" alt="มีการกระจายข่าวสาร"> </a>';
						 }else{
							 $link='';
						 }
						 
					}else{
						$checked=''; $link='';
					}
			   ?>
					  <tr bgcolor="#FFFFFF" id="<?php echo $i;?>">
						<td width="11%" align="left">
						<?php if($pass_g=='Y' or $db->check_permission("webboard","g","0")){?>
						<nobr><a href="edit_cate.php?wcad=<?php echo $R[c_id]; ?>&flag=editcategory"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไข" width="16" height="16" border="0"> </a>
				  <a href="question_function.php?flag=delcate&wcad=<?php echo $R[c_id]; ?>&c_name=<?php echo $R[c_name];?>" onClick="return confirm('คุณต้องการลบหมวดกระทู้นี้?');"><img src="../theme/main_theme/g_del.gif" alt="ลบ" width="16" height="16" border="0"></a> 
				  <a href="#" onClick="txt_data('<?php echo $R[c_id]; ?>','')"><img id="lang<?php echo $R[c_id]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a>
				  <a href="question_function.php?flag=dropcate&wcad=<?php echo $R[c_id]; ?>&c_use=<?php echo $R[c_use]; ?>&c_name=<?php echo $R[c_name];?>" >
						  <?php if($R[c_use] == "Y"){ echo "<img src=\"../theme/main_theme/g_hide.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"คลิกเพื่อซ่อนการแสดงหมวด\"> "; }else{ echo "<img src=\"../theme/main_theme/g_show.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"คลิกเพื่อยกเลิกการซ่อนการแสดงหมวด\">"; }?>
						</a><?php echo $link;?></nobr>
						<?php }?>			</td>
						<td width="40%" valign="top" bgcolor="#FFFFFF" style="cursor:'hand'" onClick="window.location.href='index_question.php?wcad=<?php echo $R[c_id]; ?>'"><div align="left" class="head_font"><font color="000099">
							<?php  biz($R[c_name]); ?>
						  </font></div>
							<?php  biz($R[c_detail]); ?></td>
					  
						<td width="7%" valign="top" bgcolor="#FFFFFF" ><?php echo show_icon_lang($R[c_id],'w_cate');?>&nbsp;</td>
						<td align="center"><?php echo $countrow; ?></td>
						<td align="center"><?php echo $countrow1; ?></td>
						  <td align="center">
						  <?php if($pass_g=='Y' or $db->check_permission("webboard","g","0")){?>
							<input type="checkbox" name="chk_rss<?php echo $i;?>" id="chk_rss<?php echo $i;?>" value="<?php echo $R["c_id"]; ?>" <?php echo $checked; ?>>
							<?php }?>
							<input name="chkrssH<?php echo $i; ?>" type="hidden" id="chkrssH<?php echo $i; ?>" value="<?php echo $R["c_id"]; ?>">
							<input name="chkrssD<?php echo $i; ?>" type="hidden" id="chkrssD<?php echo $i; ?>" value="<?php echo $R["c_name"]; ?>"></td>
						  <td align="center"><input name="webb_pos[]" id="webb_pos" type="text" size="3" value="<?php echo $R["c_level"]; ?>">
						  <input type="hidden" name="webb_id[]" id="webb_id"   value="<?php echo $R["c_id"]; ?>"></td>
					  </tr>
						
					  <?php $i++; 
					  }//end if 
					}// end while
						  if($i > 0){
						  ?>
						  <tr bgcolor="#FFFFFF" class="nodrop">
							<td height="15" colspan="5">&nbsp;</td>
							<td height="15">
							<?php if($pass_g=='Y' or $db->check_permission("webboard","g","0")){?>
							<input name="button"  type="button" onClick="document.form2.flag.value='SetRSS';document.form2.submit();" value="Use RSS">
							<?php }?>				</td>
							<td height="15"><input name="button"  type="button" onClick="document.form2.flag.value='set_level';document.form2.submit();" value="บันทึก"></td>
						  </tr>
						  <?php   }   
				    } ?>   
					
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
					 <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
	                </form> 
					</table>
					</td>
             </tr>
       </table> 
	   
	  <br></td>
  </tr>
</table>
      </td>
    </tr>
   
  </table>

</body>
</html>
<script language="JavaScript">
function CHK(){
if(document.form1.t_topic.value == ""){
alert("กรุณาใส่หัวข้อกระทู้");
document.form1.t_topic.focus();
return false;
}
if(document.form1.t_detail.value == ""){
alert("กรุณาใส่หัวข้อรายละเอียด");
document.form1.t_detail.focus();
return false;
}
}

</script>
<script type="text/javascript">
$(document).ready(function() {
	$('#table-1').tableDnD( {
		onDrop: function(table, row) {
			var webb_pos = $('* > #webb_pos');
			for(var i=0; i<webb_pos.length; i++) {
				jQuery(webb_pos[i]).val(i+1);
			}
        }
	});
});
</script>
<?php @$db->db_close(); ?>