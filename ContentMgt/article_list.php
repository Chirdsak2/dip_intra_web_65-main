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
		$_SESSION["EWT_OPEN_ARTICLE"] = $_GET["cid"];
		
function countparent($c,$ppms){
global $db,$EWT_DB_USER,$y;

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"],$ppms);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
	AND (
	   (s_type = 'Ag' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_parent"]."' ) 
	  ) ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  $db->query("use ".$_SESSION["EWT_SDB"]);
  return $y;
}
		if($_GET["cid"] != ""){
		
$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$_GET["cid"]."'");


$pass_w='';
 $y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
 if($db->check_permission("Ag","w","0") or $db->check_permission("Ag","w",$_GET["cid"]) ){
     $pass_w='Y';
 }else{
   if(countparent($_GET[cid],"w")>0){
   		$pass_w='Y';
   }
 }
 
 $pass_a='';
  $y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
  if($db->check_permission("Ag","a","0") or $db->check_permission("Ag","a",$_GET["cid"])){
     $pass_a='Y';
 }else{
   if(countparent($_GET[cid],"a")>0){
   		$pass_a='Y';
   }
 }

 
if($db->db_num_rows($sql_group) == 0 AND $_GET["search_txt"] == ""){
		?>
			<script language="javascript">
				self.location.href = "article_group.php";
			</script>
		<?php
			exit;
}
$G = $db->db_fetch_array($sql_group);
 }
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

 function findparent($id){
	 global $db;
	 $sql = $db->query("SELECT * FROM article_group WHERE c_id = '$id' ");
	 	if($db->db_num_rows($sql)){
	 		$G = $db->db_fetch_array($sql);
			$txt = " <a href = \"article_list.php?cid=".$G["c_id"]."\">".$G["c_name"]."</a> &gt;&gt; ";
			if($G[c_parent] != "0" AND $G[c_parent] != ""){
				$txt = findparent($G[c_parent]).$txt;
			}		
	 	}
		return $txt;
	 }
 function findparent2($id){
	 global $db;
	 $sql = $db->query("SELECT * FROM article_group WHERE c_id = '$id' ");
	 	if($db->db_num_rows($sql)){
	 		$G = $db->db_fetch_array($sql);
			$txt = $G["c_name"]." &gt;&gt; ";
			if($G[c_parent] != "0" AND $G[c_parent] != ""){
				$txt = findparent2($G[c_parent]).$txt;
			}		
	 	}
		return $txt;
	 }

 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
if(empty($limit)){
$limit = 20;
}


	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">

<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script language="JavaScript">
function sharing(){
document.form1.Flag.value = "Share";
form1.action = "article_share.php";
form1.submit();
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><a href="article_group.php">หน้าหลัก</a>  &gt;&gt;  <?php echo findparent($G["c_parent"]); ?> 
      <a href="article_list.php?cid=<?php echo $G["c_id"]; ?>"><?php echo $G["c_name"]; ?></a> <?php if($_GET["search_txt"] != ""){ echo "  &gt;&gt;  ค้นหา \"".$_GET["search_txt"]."\""; } ?></span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
		<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ( "หมวด&gt;&gt;".findparent2($G["c_parent"]).$G["c_name"]);?>&module=article&url=<?php echo urlencode ( "article_list.php?cid=".$_GET["cid"]); ?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
	<a href="article_group.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> หน้าหลัก</a>
	
	<?php if( $pass_w=='Y' ){?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="article_gadd.php?p=<?php echo $_GET["cid"]; ?>"><img src="../theme/main_theme/g_folder_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มกลุ่ม</a>
	  <?php if($G["c_type"]!='M'){?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="article_new.php?cid=<?php echo $_GET["cid"]; ?>"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มข่าว/บทความ</a> 
	  <?php } ?>
	  <?php } ?>
      <hr>
    </td>
  </tr>
</table>

<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
<tr> 
<form name="form2" method="get" action="article_list.php" ><td>
  ค้นหา Article :
        <input name="search_txt" type="text" class="form-control" style="width:30%;" value="<?php echo $_GET["search_txt"];?>" size="50" /> &nbsp;<input type="submit" name="Submit" value="ค้นหา"  class="btn btn-success" />
		<input name="serach_flag" type="hidden" value="<?php echo $_POST["serach_flag"];?>" />
        <?php
		if($_GET["cid"] != ""){
?>
		<br><br>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cid" type="checkbox" value="<?php echo $_GET["cid"]; ?>" checked>
        เฉพาะหมวด <?php echo $G["c_name"]; ?><?php }else{ ?><input name="cid" type="hidden" id="cid" value="<?php echo $_GET["cid"]; ?>">
		<?php } ?><?php
		if($_GET["uid_show"] == ""){
		?>&nbsp;&nbsp;<input name="uid_show" type="checkbox" value="<?php if($_SESSION["EWT_SMID"]!=''){echo $_SESSION["EWT_SMID"];}else{ echo "0";}?>" <?php if($_GET["uid_show"]!=''){ echo "checked";}?>>เฉพาะข่าวที่รับผิดชอบ<?php } ?></td>
</form>
</tr>
</table>

<?php
if($_GET["search_type"] != "2" OR $_GET["search_txt"] == ""){
$sql_search = "SELECT * FROM article_group WHERE c_id != '0' ";
	if($_GET["cid"] != ""){
		$sql_search .= " AND c_parent = '".$_GET["cid"]."' ";
	}
		if($_GET["search_txt"] != ""){
		$sql_search .= " AND c_name REGEXP '".$_GET["search_txt"]."' ";
	}

//$sql_search .= "ORDER BY c_id ASC";
$sql_search .= "ORDER BY d_id ASC";
$sql_article = $db->query($sql_search);
?>
<div class="table-responsive"> 
<form name="form11" method="post" action="article_function.php">

<table  class="table table-bordered" width="90%"  align="center">
    <input type="hidden" name="Flag" value="DelGroup">
	<input name="p" type="hidden" id="p" value="<?php echo $_GET["cid"]; ?>">
    <!--<tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="9%" height="18" align="center">&nbsp;</td>
      <td width="66%"height="18" align="center">ชื่อกลุ่มข่าว/บทความ</td>
	  <td width="7%" align="center">เรียงลำดับ</td>
      <td width="7%" align="center">ภาษาอื่น</td>
      <td width="9%" align="center">แสดง RSS<a href="#help_01">*</a><br></td>
      <td width="9%" align="center">ลบ</td>
    </tr>-->
	<thead>
      <tr bgcolor="#E0DFE3" class="ewttablehead">
		<th  width="10%"></th>
        <th  width="50%">ชื่อกลุ่มข่าว/บทความ</th>
        <th  width="10%">เรียงลำดับ</th>
		<th  width="10%">ภาษาอื่น</th>
        <th  width="10%">แสดง RSS<a href="#help_01">*</a><br></th>
		<th  width="10%">ลบ</th>
      </tr>
</thead>
<tbody>
    <?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_article)){ 

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
		
 $pass_sub_w=''; 
 $y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
 if($db->check_permission("Ag","w","0") or $db->check_permission("Ag","w",$G["c_id"]) ){
     $pass_sub_w='Y';
 }else{
   if(countparent($G["c_id"],"w")>0){
   		$pass_sub_w='Y';
   }
 }
 	
	?>
    <tr bgcolor="#FFFFFF" style="display:<?php if($_GET["uid_show"] != "" && $pass_sub_w !='Y'){ echo "none";}?>"> 
      <td><nobr><a href="article_list.php?cid=<?php echo $G["c_id"]; ?>"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" align="absmiddle" alt="ดูข้อมูล"></a> 
	  <?php if($pass_sub_w=='Y'){ ?>
        <a href="article_gedit.php?cid=<?php echo $G["c_id"]; ?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle" alt="แก้ไขหมวดข่าว/บทความ"></a>
		<a href="#A" onClick="txt_data('<?php echo $G["c_id"]; ?>','')"><img id="lang<?php echo $G["c_id"]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a> 
		<?php  }?>
        <?php echo $link;?></nobr></td>
      <td height="25" valign="top"> <img src="../theme/main_theme/g_folder_closed.gif" alt="news folder" width="16" height="16" align="absmiddle"><a href="#article" onClick="self.location.href='article_list.php?cid=<?php echo $G["c_id"]; ?>';"> 
        <?php echo $G["c_name"]; ?>  <font color="#666666">[<?php $numfolder = countchild($G["c_id"]); echo number_format($numfolder,0); ?> หมวด <?php echo number_format($C[0] + countchild2($G["c_id"]),0); ?> บทความ]</font></a>      </td>
      <td height="25" align="center"><?php if($G["d_id"]>0){echo $G["d_id"];} ?></td>
	  <td height="25" valign="top"><?php if($pass_sub_w=='Y'){  echo show_icon_lang($G["c_id"],'article_group'); }?></td>
      <td align="center" > 
       <?php if($pass_sub_w=='Y'){ ?>
        <input name="chkrss<?php echo $i; ?>" type="checkbox" id="chkrss<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>" <?php echo $checked; ?>> 
        <input name="chkrssH<?php echo $i; ?>" type="hidden" id="chkrssH<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>">
		 
        <?php } ?>      </td>
      <td width="9%" align="center"> 
       <?php if($pass_sub_w=='Y'){ ?>
        <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>" <?php  if($numfolder > 0){ echo "disabled"; } ?>> 
        <?php $i++; } ?>      </td>
    </tr>
	
    <?php  
	}
 ?>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3" valign="top">&nbsp;<a id="#bottom"></a></td>
	  <td>&nbsp;</td>
      <td align="center"  >
        <?php if($i>0){ ?>
        <input name="button" type="button" onClick="document.form11.Flag.value='SetRSS'; document.form11.submit();" value="ตั้งค่า">
        <?php } ?>      </td>
      <td width="9%" align="center" >
        <?php if($i>0){ ?>
        <input type="button" name="Button" value="ลบกลุ่ม" onClick="if(confirm('Are you sure to delete selected group?')){ form11.submit(); }">
    <?php } ?>    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="4" valign="top"><span class="ewtnormal"><a name="help_01"></a>* 
        เลือก RSS เป็นการกำหนดให้ข่าวกลุ่มนั้นมีการส่งออกเป็นไฟล์ XML ตามมาตรฐาน 
        RSS ได้</span></td>
      <td align="center" >&nbsp;</td>
      <td align="center"  >&nbsp;</td>
    </tr>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
</tbody>
</table> 
</form>
</div> 
<?php
}
if($_GET["search_type"] != "1" OR $_GET["search_txt"] == ""){
$block_edit = "";
$block_approve = "";
	$sql_query = "SELECT n_id,n_topic,n_date,n_new_modi,n_last_modi,n_owner,news_use,n_share,n_shareuse,n_sharename,n_approve,c_id,link_html FROM article_list WHERE  n_approve<>'D' and n_id != '' ";
		if($_GET["cid"] != ""){
		$sql_query .= " AND c_id = '".$_GET["cid"]."' ";
		}
		if($_GET["search_txt"] != ""){
		$sql_query .= " AND n_topic REGEXP '".$_GET["search_txt"]."' ";
		}
		if($_GET["uid_show"] != ""){
		$sql_query .= " AND n_owner = '".$_GET["uid_show"]."' ";
		}
		$sql_article = $sql_query." ORDER BY n_date DESC,n_timestamp DESC LIMIT $offset,$limit ";
	 $sql_article = $db->query($sql_article);
?>
<table width="94%"  align="center" class="table table-bordered">
  <form name="form1" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="DelArticle">
    <input name="cid" type="hidden" id="cid" value="<?php echo $_GET["cid"]; ?>">
	
    <input type="hidden" name="backto" value="<?php if($_GET["cid"] != ""){ echo "article_list.php?cid=".$_GET["cid"]; }else{ echo "article_group.php"; } ?>">
   <thead> 
	<tr bgcolor="#E0DFE3" class="ewttablehead" > 
	<td width="3%" align="center" >&nbsp;</th>
      <th width="4%" align="center" >วันที่</th>
      <th width="51%"  height="18" align="center" >หัวข้อข่าว/บทความ</th>
      <th width="6%" align="center" >ภาษาอื่น</th>
      <th width="9%" align="center" >ผู้สร้าง</th>
      <th width="4%" align="center" >สร้าง</th>
      <th width="5%" align="center" >แก้ไข</th>
      <th width="6%" height="18" align="center" >Share</th>
      <th width="6%" align="center" >อนุมัติ</th>
      <th width="6%" align="center"  >ลบ</th>
    </tr>
	</thead>
    <?php
	$i = 0;
	$rows = $db->db_num_rows($db->query($sql_query));
		  $nu = $rows-$offset;
	 while($N = $db->db_fetch_array($sql_article)){ 
	$date = explode("-",$N["n_date"]);
	if($N["n_new_modi"] != ''){
	$n_new_modi_Y=substr($N["n_new_modi"], 0, 4);    
	$n_new_modi_M=substr($N["n_new_modi"], 4, 2);   
	$n_new_modi_D=substr($N["n_new_modi"], 6, 2);   
	$date_create_f =$n_new_modi_D."/".$n_new_modi_M."/".($n_new_modi_Y+543);
	}else{
	$date_create_f  = '-';
	}
	if($N["n_last_modi"] != '' && $N["n_new_modi"] != ''){
	$n_last_modi_Y=substr($N["n_last_modi"], 0, 4);    
	$n_last_modi_M=substr($N["n_last_modi"], 4, 2);   
	$n_last_modi_D=substr($N["n_last_modi"], 6, 2);   
	$date_modi_f = $n_last_modi_D."/".$n_last_modi_M."/".($n_last_modi_Y+543);
	}else{
	$date_modi_f  ='-';
	}
	if($N["n_owner"] == 0 || $N["n_owner"] == ''){
	$owner = 'Web Admin';
	}else{
	$db->query("USE ".$EWT_DB_USER);
	$sql_chk = "SELECT name_thai,surname_thai
							FROM
							  `gen_user`
							  where  gen_user_id ='".$N["n_owner"]."'  ";
	$query = $db->query($sql_chk);
	$rec = $db->db_fetch_array($query);
	$db->query("USE ".$EWT_DB_NAME);
	$owner = $rec[name_thai].'   '.$rec[surname_thai];
	}
	$group_text = "";
	if($_GET["cid"] == ""){
			 $sql_gname = $db->query("SELECT c_name FROM article_group WHERE c_id = '".$N["c_id"]."' ");
			 $GN = $db->db_fetch_row($sql_gname);
			 $group_text = "<div><a href=\"#article\" onClick=\"self.location.href='article_list.php?cid=".$N["c_id"]."';\"><img src=\"../theme/main_theme/g_folder_closed.gif\" alt=\"news folder\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\"> ".$GN[0]."</a></div>";
	}	
	$pass_w='';

	 $y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
		 if($db->check_permission("Ag","w","0") or $db->check_permission("Ag","w",$N["c_id"]) ){
			 $pass_w='Y';
		 }else{
		   if(countparent($N["c_id"],"w")>0){
				$pass_w='Y';
		   }
		 }
		$pass_a='';
		 $y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
			 if($db->check_permission("Ag","a","0") or $db->check_permission("Ag","a",$N["c_id"]) ){
				 $pass_a='Y';
			 }else{
			   if(countparent($N["c_id"],"a")>0){
					$pass_a='Y';
			   }
			 }
	if($pass_w == "Y" AND $N["n_owner"] != $_SESSION["EWT_SMID"]){
	$pass_w='';
	}
	if($_SESSION["EWT_SMTYPE"] == "Y"){
	$pass_w = "Y";
	}
	?>
    <tr bgcolor="#FFFFFF" > 
	<td height="20" align="center" valign="top" nowrap>
	<?php
	$path_news="";
	if($N["news_use"] == "2" OR $N["news_use"] == "3" OR $N["news_use"] == "4"){
			$path_news= "../ewt/".$_SESSION[EWT_SUSER]."/news_view.php?nid=".$N["n_id"] ;
	}else{
			if(eregi('http://',$N["link_html"]) || eregi('https://',$N["link_html"])){
			      $path_news= $N["link_html"];
			}else{
				 $path_news= "../ewt/".$_SESSION[EWT_SUSER]."/".$N["link_html"];
			}
	}
	
	?>
	<a href="#view" onClick="window.open('<?php echo $path_news; ?>');"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" align="absmiddle" alt="ดูข้อมูล"></a>
	<?php if($pass_w=='Y'){ ?>
	<a href="#set" onClick="txt_data3('<?php echo $N["n_id"]; ?>','')"><img id="lang<?php echo $N["n_id"]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a> 
	<?php } ?>
	<a href="##P" title="เพิ่ม Tool Tips"  onClick="window.open('content_tooltips.php?type=a&filename=<?php echo $N["n_id"]; ?>','','height=600,width=780,scrollbars=1,resizable=1');"><img src="../images/help.gif" alt="เพิ่ม Tool Tips" width="16" height="16" align="absmiddle" border="0"> </a>
	</td>
      <td height="20" align="center" valign="top"><?php echo $date[2]."/".$date[1]."/".$date[0]; ?></td>
      <td height="20" valign="top" > 
        <img src="../theme/main_theme/g_document.gif" alt="News" width="16" height="16" align="absmiddle">
        <?php if($N["n_shareuse"] != "Y"){ ?>
             <?php if($pass_w=='Y'){ ?> 
                     <a href="#article" onClick="self.location.href='article_edit.php?nid=<?php echo $N["n_id"]; ?>&cid=<?php echo $_GET["cid"]; ?>';"  > 
			 <?php }?>
              <?php echo $N["n_topic"]; ?> 
			  <?php if($pass_w=='Y'){ ?></a><?php }?>
        <?php  }else{ ?>
        <img src="../images/share.gif" width="20" height="20" border="0" align="absmiddle"> 
        <font color="#666666"><?php echo $N["n_topic"]; ?></font> [From:<?php echo $N["n_sharename"]; ?>] 
        <?php } ?><?php echo  $group_text; ?></td>
		<td height="20" valign="top" ><?php if($pass_w=='Y'){ echo show_icon_lang2($N["n_id"],'article_list'); }?></td>
		<td height="20" align="center" valign="top"><?php echo $owner; ?></td>
      <td height="20" align="center" valign="top"><?php echo $date_create_f; ?></td>
      <td height="20" align="center" valign="top"><?php echo $date_modi_f; ?></td>
      <td height="20" align="center" valign="top" > 
	   <?php if($pass_w=='Y'){ ?>
        <?php if($N["n_share"] != "Y" AND $N["n_shareuse"] != "Y"){ ?>
        <input name="share<?php echo $i; ?>" type="checkbox" id="share<?php echo $i; ?>" value="<?php echo $N["n_id"]; ?>">
        <?php } ?>   
		<?php if($N["n_share"] == "Y"){ ?>
        <a href="#change" onClick="win2=window.open('article_share_news.php?nid=<?php echo $N["n_id"]; ?>','change','width=400,height=500,resizable=1,scrollbars=1');"><img src="../images/bar_share.gif" width="20" height="20" border="0"></a> 
        <?php } ?>
		<?php if($N["n_shareuse"] == "Y"){ ?>
        <img src="../images/share.gif" width="20" height="20" border="0"> 
        <?php } 
		}?>      
	  </td>
      <td height="20" align="center" valign="top"  > 
         <?php if($pass_a=='Y'){ ?>
        <input name="app<?php echo $i; ?>" type="checkbox" id="app<?php echo $i; ?>" value="Y" <?php if($N["n_approve"] == "Y"){ echo "checked"; } ?>>
        <input name="nid<?php echo $i; ?>" type="hidden" id="nid<?php echo $i; ?>" value="<?php echo $N["n_id"]; ?>"> 
        <?php
$block_approve = "Y"; 
}else{
if($N["n_approve"] == "Y"){ echo "<img src=\"../theme/main_theme/g_approve.gif\"  border=\"0\" align=\"absmiddle\" alt=\"อนุมัติแล้ว\">"; }
} ?>      </td>
		
      <td align="center" valign="top"  >   
	   <?php if($pass_w=='Y'){ ?>
	  <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $N["n_id"]; ?>"> 
	  <?php  $block_edit = "Y";
	  } ?>
	  </td>
  
    </tr>
    <?php $i++;$nu--; }?>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
    <tr bgcolor="#FFFFFF"> 
      <td height="30" colspan="7">&nbsp;</td>
      <td height="30" align="center" >
	   <?php if($block_edit=="Y"){ ?>
	  <input type="button" name="Button" value="Share" onClick="sharing();">
	   <?php }?>
	  </td>
      <td height="30" align="center">
	   <?php if($block_approve=="Y"){ ?>
	  <input type="button" name="Button" value="อนุมัติ" onClick="document.form1.Flag.value='AppArticle';form1.submit();">
	   <?php }?>
	  </td>
      <td height="30" align="center">
	   <?php if($block_edit=="Y"){ ?>
	  <input type="submit" name="Submit" value="   ลบ   "  onClick="return confirm('Are you sure to delete selected article?');">
	  <?php } ?></td>
    </tr>
	<?php if($rows > 0){ ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="30" colspan="10"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>หน้าที่ 
        :</strong></font> 
        <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&cid=".$_GET["cid"]."&search_type=$search_type&search_txt=$search_txt'>
<font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ก่อนหน้า</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($rows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($rows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">&nbsp;[$i]&nbsp;</font>\n\n"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&cid=".$_GET["cid"]."&search_type=$search_type&search_txt=$search_txt' ". 
                  " ><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">&nbsp;$i&nbsp;</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&cid=".$_GET["cid"]."&search_type=$search_type&search_txt=$search_txt'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
    }
?>      </td>
    </tr>
	<?php } ?>
  </form>
</table>
<?php } ?>
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
function txt_data2(w,g,lang) {

	 window.location.href='../multilangMgt/article_list.php?langid='+g+'&lang='+lang+'&id='+ w;
}
function txt_data3(w,g) {
	
	var mytop = findPosY(document.getElementById("lang"+w)) +document.getElementById("lang"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("lang"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='../language_set_article_list.php?gid='+g+'&id='+ w;
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
</script>
