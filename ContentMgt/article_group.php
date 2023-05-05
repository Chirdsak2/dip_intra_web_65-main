<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
		if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}
		$_SESSION["EWT_OPEN_ARTICLE"] = "";
$db->write_log("view","article","เข้าสู่ Module Article");

function countchild($c){
global $db;

$sql = $db->query("SELECT c_id FROM article_group WHERE c_parent = '$c'   ");
$x = 0;
  while($U = $db->db_fetch_array($sql)){
	$c = countchild($U["c_id"]);
	$x += $c;
	$x++;
  }
  return $x;
}
function countchild2($c){
global $db;

$sql = $db->query("SELECT c_id FROM article_group WHERE c_parent = '$c'   ");
$x = 0;
  while($U = $db->db_fetch_array($sql)){
	$c = countchild2($U["c_id"]);
	$x += $c;
	$sql2 = $db->query("SELECT COUNT(n_id) FROM article_list WHERE c_id = '".$U["c_id"]."' ");
	$C = $db->db_fetch_row($sql2);
	$x += $C[0];
  }
  return $x;
}


$ptype = "Ag";

$ppms1 = "w";
$ppms2 = "a";

function countparent($c){
global $db,$ptype,$ppms1,$ppms2,$y,$EWT_DB_USER;

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"]);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
	AND (
	   (s_type = '".$ptype."' AND s_permission = '".$ppms1."'  AND s_id = '".$U["c_parent"]."' ) OR 
	   (s_type = '".$ptype."' AND s_permission = '".$ppms2."'  AND s_id = '".$U["c_parent"]."' )
	  ) ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  return $y;
}

// $sql_article = $db->query("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC");
if($db->check_permission($ptype,$ppms,"0")){
  $sql_article = $db->query_db("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
}else{
		$sql_supadmin = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
		AND (
		(s_type = '".$ptype."' AND s_permission = '".$ppms1."'  AND s_id != '0' )  OR
		(s_type = '".$ptype."' AND s_permission = '".$ppms2."'  AND s_id != '0' )
		)",$EWT_DB_USER);
		
			 $sql_text = "WHERE ( 0 ";
			while($G = $db->db_fetch_row($sql_supadmin)){
			$y = 0;
				if(countparent($G[0]) == 0){
				$sql_text .= " OR c_id = '".$G[0]."' ";
				}
			}
			$sql_text .= " ) ";
		//$sql_group = $db->query_db("SELECT * FROM gallery_category ".$sql_text." ORDER BY category_id ASC ",$_SESSION["EWT_SDB"]);
		//$sql_article = $db->query_db("SELECT * FROM article_group  ".$sql_text." ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
		$sql_article = $db->query_db("SELECT * FROM article_group  ".$sql_text." ORDER BY d_id ASC",$_SESSION["EWT_SDB"]);
}


	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">

<!--<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>-->
<script language="JavaScript">
//self.parent.document.all.backon.style.display = 'none';
//self.parent.document.all.backoff.style.display = '';
//self.parent.document.all.folderoff.style.display = 'none';
//self.parent.document.all.folderon.style.display = '';
//self.parent.document.all.deloff.style.display = 'none';
//self.parent.document.all.delon.style.display = '';
			 function chkKeyFo(c){
			 		if(event.keyCode == 13){
						create_fo(c);
					}
			 }
			 function create_fo(c){
				if(c.value == ""){
					document.all.new_fo.style.display = 'none';
				}else{
					var gname = c.value;
					document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"article_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateFolder\"><input name=\"gname\" type=\"hidden\" id=\"gname\" value=\""+ gname + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
					createform.submit();

				}
			}
			function CHK(t){
	if(t.search_txt.value == '' && t.date_s.value == '' && t.date_e.value == ''){
	alert("กรุณาระบุเงื่อนไขการค้นหา!!!!!!!!!!!");
	return false;
	}else{
	return true;
	}
	return false;
	}

</script>
</head>
<body leftmargin="0" topmargin="0">

<?php 

$db->query("USE ".$_SESSION["EWT_SDB"]);
?>

<span id="formtext"></span>
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">บริหารกลุ่มข่าว<a href="../PKMgt/pk_index.php" target="_top">/</a>บทความ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">

	<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ( 'บริหารกลุ่มข่าว/บทความ');?>&module=article&url=<?php echo urlencode ( "article_group.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if($db->check_permission("Ag","w","0")){?><a href="article_gadd.php?p=0"><img src="../theme/main_theme/g_folder_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มกลุ่ม</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="article_new.php"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มข่าว/บทความ</a> 
	  <?php } ?>
      <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form2" method="get" action="article_list.php" >
      <td>
                              ค้นหาข่าว/บทความ :
                                <input name="search_txt" type="text"  class="form-control" style="width:30%;" value="<?php echo $_POST["search_txt"];?>" size="50"><!--
วันที่ :
<input name="date_s" type="text" size="11" value="<?php echo $_POST["date_s"];?>">
<img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('date_s', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> ถึง
<input name="date_e" type="text" size="11" value="<?php echo $_POST["date_e"];?>">
<img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('date_e', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">-->
<input type="submit" name="Submit" value="ค้นหา" class="btn btn-success" />
<input name="serach_flag" type="hidden" value="<?php echo $_POST["serach_flag"];?>" />
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="search_type" value="1">
        ค้นหาตามกลุ่ม
		<input type="radio" name="search_type" value="2">
		 ค้นหาตามบทความ
		 <input name="search_type" type="radio" value="" checked>
		  ค้นหาทั้งหมด </td>
    </form>
  </tr>
</table>
<table  width="94%"  align="center"  class="table table-bordered">
  <form name="form1" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="13%" height="18" align="center">&nbsp;</td>
      <td  width="61%" height="18" align="center">ชื่อกลุ่มข่าว/บทความ</td>
	  <td  width="7%" align="center">เรียงลำดับ</td>
      <td  width="8%" align="center">ภาษาอื่น</td>
      <td width="8%" align="center" <?php echo $disabled2;?>>แสดง RSS<a href="#help_01">*</a><br></td>
      <td width="10%" align="center"  <?php echo $disabled1;?>>ลบ</td>
    </tr>
    <?php
	$i = 0;
	$block_edit = "Y";
     if($db->check_permission("Ag","w","0") || $db->check_permission("Ag","a","0") ){ 
	 $pass = 'Y';
	 }
	
	 while($G = $db->db_fetch_array($sql_article)){ 
	 if( ($db->check_permission("Ag","w",$G[c_id]) || $db->check_permission("Ag","a",$G[c_id]) )  ||   $pass == 'Y' ){
	  if( $db->check_permission("Ag","w",$G[c_id]) ){$pass_w='Y';}else{$pass_w='';}
	 //if(  $db->check_permission("Ag","",$G[c_id]) ){ 
	 
	$S_count = $db->query("SELECT COUNT(n_id) FROM article_list WHERE c_id = '$G[c_id]' "); 
	$C = $db->db_fetch_row($S_count);
			
		if($G["c_rss"]=='Y'){
		     $checked= "checked";
			 $filename="../ewt/".$_SESSION["EWT_SUSER"]."/rss/group".$G["c_id"].".xml";
			 if(file_exists($filename)){
			     $link='<a href="../ewt/'.$_SESSION["EWT_SUSER"].'/rss/group'.$G["c_id"].'.xml" target="_blank"><img src="../theme/main_theme/g_rss.gif" border="0" alt="ดูข้อมูล RSS"> </a>';
			 }else{
			     $link='';
			 }
			 
		}else{
		    $checked=''; $link='';
		}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td><nobr><a href="article_list.php?cid=<?php echo $G["c_id"]; ?>"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" align="absmiddle" alt="ดูข้อมูล"></a> 
	  <?php if($pass_w=='Y'){ ?>
        <a href="article_gedit.php?cid=<?php echo $G["c_id"]; ?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle" alt="แก้ไขหมวดข่าว/บทความ"></a> 
        <a href="#A" onClick="txt_data('<?php echo $G["c_id"]; ?>','')"><img id="lang<?php echo $G["c_id"]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a>
		<?php }?>
		<?php echo $link;?></nobr></td>
      <td height="25" valign="top"> <img src="../theme/main_theme/g_folder_closed.gif" alt="news folder" width="16" height="16" align="absmiddle"><a href="#article" onClick="self.location.href='article_list.php?cid=<?php echo $G["c_id"]; ?>';"> 
        <?php echo $G["c_name"]; ?> <font color="#666666">[<?php $numfolder = countchild($G["c_id"]); echo number_format($numfolder,0); ?> กลุ่ม   <?php echo number_format($C[0] + countchild2($G["c_id"]),0); ?> บทความ]</font></a>      </td>
      <td height="25" align="center"><?php if($G["d_id"]>0){echo $G["d_id"];} ?></td>
	  <td height="25" valign="top"><?php if($pass_w=='Y'){   echo show_icon_lang($G["c_id"],'article_group'); }?></td>
      <td align="center" > 
      <?php if($pass_w=='Y'){ ?>
        <input name="chkrss<?php echo $i; ?>" type="checkbox" id="chkrss<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>" <?php echo $checked; ?>> 
        <input name="chkrssH<?php echo $i; ?>" type="hidden" id="chkrssH<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>"> 
        <?php } ?>      </td>
      <td width="10%" align="center" <?php echo $disabled1;?>> 
        <?php if($pass_w=='Y'){ $block_edit = "Y"; ?>
        <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>" <?php  if($numfolder > 0){ echo "disabled"; } ?>> 
        <?php } ?>      </td>
    </tr>
    <?php $i++; }
	} ?>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="4" valign="top">&nbsp;<a id="#bottom"></a></td>
      <td align="center"  <?php echo $disabled2;?>>
         <?php if($block_edit == "Y"){ ?>
        <input name="button" type="button" onClick="document.form1.Flag.value='SetRSS'; document.form1.submit();" value="ตั้งค่า">
        <?php } ?>      </td>
      <td width="10%" align="center"  <?php echo $disabled1;?>>
        <?php if($block_edit == "Y"){ ?>
        <input type="button" name="Button" value="ลบกลุ่ม" onClick="if(confirm('Are you sure to delete selected group?')){ form1.submit(); }">
    <?php } ?>    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="4" valign="top"><span class="ewtnormal"><a name="help_01"></a>* 
        เลือก RSS เป็นการกำหนดให้ข่าวกลุ่มนั้นมีการส่งออกเป็นไฟล์ XML ตามมาตรฐาน 
        RSS ได้</span></td>
      <td align="center"  <?php echo $disabled2;?>>&nbsp;</td>
      <td align="center"  <?php echo $disabled1;?>>&nbsp;</td>
    </tr>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
  </form>
</table>
<br>

</body>
</html>
<?php $db->db_close(); ?>
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

	 window.location.href='../multilangMgt/article_group.php?langid='+g+'&lang='+lang+'&id='+ w;
}
</script>
