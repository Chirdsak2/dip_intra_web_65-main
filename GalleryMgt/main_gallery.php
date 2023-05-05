<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

function GenLen($data,$op){
		$s = explode($op,$data);
		return count($s);
  }
  
  function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
  /*
  function GenPic2($data){
	$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		echo "<img src=\"images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
 }
 
 function GenPic3($id){
	global $db;
	$sql = "select * from gallery_category where category_id = '$id' ";
	//echo  $sql ;
	$query = $db->query($sql); 
	$R = mysql_fetch_array($query);
	if($R[parent_id] > 0){  GenPic($R[parent_id]); }
	if($id<>0){
		 //echo ' > <a href="faq_sub.php?f_id='.$R[f_sub_id].'">'.$R[f_subcate].'</a>';
		 echo "<img src=\"images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
*/

function countchild($c){
global $db;

$sql = $db->query_db("SELECT category_id FROM gallery_category WHERE parent_id = '$c'   ",$_SESSION["EWT_SDB"]);
$x = 0;
  while($U = $db->db_fetch_array($sql)){
	$c = countchild($U["category_id"]);
	$x += $c;
	$x++;
  }
  return $x;
}



function countparent($c){
global $db,$ptype,$ppms,$y,$EWT_DB_USER;

$sql = $db->query_db("SELECT parent_id FROM gallery_category WHERE category_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["parent_id"]);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' AND (s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '".$U["parent_id"]."' ) ",$EWT_DB_USE);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  return $y;
}

function child($c,$x,$decho){
global $db,$mtype,$mid,$UID,$ptype,$ppms,$myFlag,$i,$txt,$EWT_DB_USER;
$y = $x+1;
$sql = $db->query_db("SELECT * FROM gallery_category WHERE parent_id = '$c' ORDER BY category_id ASC ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_id"]."' AND myFlag = '$myFlag' ",$EWT_DB_USER);
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
	$ct = countchild($U["category_id"]);
	global $text_general_edit;
	global $text_general_delete;
	global $text_general_addsub;
	
	
			$sql_count_img = "select count(*) as count_img FROM gallery_cat_img WHERE category_id = '$U[category_id]' ";
			$query_count_img = $db->query($sql_count_img);
			$rs_count_img = $db->db_fetch_array($query_count_img);
			$count_img = $rs_count_img[count_img];
	
  ?>
    <tr bgcolor="#FFFFFF" > 
	<td align="center">
	<?php if($db->check_permission("Gallery","g","")){?>
	<nobr>
	<a href="gallery_addedit_category.php?flag=edit&id=<?php echo $U["category_id"]?>"><img src="../theme/main_theme/g_edit.gif" alt="<?php echo $text_general_edit;?>" width="16" height="16" border="0" align="absmiddle"> </a> 
	<span style="cursor:hand" onClick=" if(confirm('ยืนยันการลบ')){location.href = 'gallery_addedit_category.php?flag=del&parent_id=<?php echo $U["category_parent_id"]?>&category_id=<?php echo $U["category_id"]?>';}"><img src="../theme/main_theme/g_garbage.png" width="16" height="16" align="absmiddle" alt="<?php echo $text_general_delete;?>"></span> 
	<a href="gallery_addedit_category.php?flag=add&parent_cat_id_send=<?php echo $U["category_parent_id"]?>"> <img src="../theme/main_theme/g_folder_add.gif" width="16" height="16" align="absmiddle" border="0" alt="<?php echo $text_general_addsub;?>"></a>
	 <a href="#G" onClick="txt_data('<?php echo $U["category_id"]; ?>','')"><img id="lang<?php echo $U["category_id"]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a>  </nobr>
	 <?php } ?>
	 </td>


      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php GenPic($y); ?><img src="../theme/main_theme/arrow_r.gif" width="7" height="7" border="0" align="absmiddle">&nbsp;  
	  <a href="gallery_view_category.php?category_id=<?php echo $U["category_id"]?>"><?php echo $U["category_name"]." ( $count_img รูป ) "; ?></a>
	  </td>
	  <td><?php echo show_icon_lang($R["category_id"],'gallery_category');?></td>
    </tr>
    <?php
	if($check == "checked"){
	$txt .= "chkdis(document.form1.chk".$i.",'".$U["category_id"]."',".$i.",".$ct."); ";
	}
	$i++; 
	child($U["category_id"],$y,$decho);
  }
}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
<form name="form1" method="post" action="main_gallery.php">

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/gallery_function_cat.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $text_genGallery_modulesub_cat;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genGallery_modulesub_cat);?>&module=gallery&url=<?php echo urlencode("main_gallery.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if($db->check_permission("Gallery","g","")){?><a href="gallery_addedit_category.php?flag=add"><img src="../theme/main_theme/g_folder_add.gif" width="16" height="16" align="absmiddle" border="0" alt="<?php echo $text_general_addcat;?>"> <?php echo $text_general_addcat;?></a><?php } if($db->check_permission("Gallery","p","")){?>&nbsp;&nbsp;&nbsp;&nbsp;
                             <a href="gallery_add_img.php?flag=add"><img src="../theme/main_theme/g_add.gif" alt="<?php echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle">
                            <?php echo $text_genGallery_addpic;?> </a><?php }?>
                             <hr>
    </td>
  </tr>
</table>


   <table width="94%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
    <tr>
      <td valign="top"  class="MemberTitle">  
				<table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" >
						<tr>
							<td >
							<input type="hidden" name="curPage" value="1"> ค้นหาห้องแสดงภาพ
							<input type="text" name="data" value="<?php echo $data;?>">
							<input type="submit" name="Submit" value="ค้นหา">
							</td>
						</tr>
				</table>
				<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
				  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
					<td width="12%" height="30" align="center">&nbsp;</td>
					<td width="74%" ><?php echo $text_genGallery_modulesub_cat;?></td>
					<td width="14%" align="center" >ภาษาอื่น</td>
				  </tr>
				  <script language="JavaScript">
										function divshow(c,d){
											if(c.style.display == ""){
											c.style.display = 'none';
											d.src = "images/plus.gif";
											}else{
												c.style.display = '';
											d.src = "images/minus.gif";
											}
										}
										</script>
				  <?php
				
				
				//$sql_group = $db->query("SELECT * FROM gallery_category ORDER BY category_parent_id ASC");
				
				$ptype = "Gg";
				$ppms = "w";
				
				 $data = $_REQUEST['data'];
				 if (!empty($data)) {
									$wh = " AND category_name like '%$data%' ";
				}
				
				if($db->check_permission($ptype,$ppms,"0")){
				  $sql_group = $db->query_db("SELECT * FROM gallery_category WHERE parent_id='0' $wh ORDER BY category_id ASC ",$_SESSION["EWT_SDB"]);
				  $sel="SELECT * FROM gallery_category WHERE parent_id='0' $wh ORDER BY category_id ASC ";
				}else{
						$sql_supadmin = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' AND (s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id != '0' ) ",$EWT_DB_USER);
						
							 $sql_text = "WHERE ( 0 ";
							while($G = $db->db_fetch_row($sql_supadmin)){
							$y = 0;
								if(countparent($G[0]) == 0){
								$sql_text .= " OR category_id = '".$G[0]."' ";
								}
							}
							$sql_text .= " ) ";
						   $sql_group = $db->query_db("SELECT * FROM gallery_category ".$sql_text."  $wh ORDER BY category_id ASC ",$_SESSION["EWT_SDB"]);
						  $sel="SELECT * FROM gallery_category ".$sql_text."  $wh ORDER BY category_id ASC ";
					}
					
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
					
					
					$sql_group=$Execsql;
					$num = $db->db_num_rows($sql_group);
					if($num > 0){
					
					$i = 0;
					$LenChk =0;
					
					while($R = $db->db_fetch_array($sql_group)){
							$sql_sub = $db->query("SELECT COUNT(category_id) FROM gallery_category WHERE category_parent_id LIKE '".$R["category_parent_id"]."_%'");
							$count_sub = $db->db_fetch_row($sql_sub);
							$len = GenLen($R["category_parent_id"],"_");
								//echo $LenChk."-".$len;		
							if($LenChk > $len ){
								for($y=$len;$y<$LenChk;$y++){
									echo "</div>";
								}
							}
							$LenChk = $len;
				  ?>
				  <tr bgcolor="#FFFFFF"> 
					<td align="center">
					<?php if($db->check_permission("Gallery","g","")){?>
					<nobr><a href="gallery_addedit_category.php?flag=edit&id=<?php echo $R["category_id"]?>"><img src="../theme/main_theme/g_edit.gif" alt="<?php echo $text_general_edit;?>" width="16" height="16" border="0" align="absmiddle"> </a> 
					<span style="cursor:hand" onClick=" if(confirm('ยืนยันการลบ')){location.href = 'gallery_addedit_category.php?flag=del&parent_id=<?php echo $R["category_parent_id"]?>&category_id=<?php echo $R["category_id"]?>';}"><img src="../theme/main_theme/g_garbage.png" width="16" height="16" align="absmiddle" alt="<?php echo $text_general_delete;?>"></span> 
					<a href="gallery_addedit_category.php?flag=add&parent_cat_id_send=<?php echo $R["category_parent_id"]?>"> <img src="../theme/main_theme/g_folder_add.gif" width="16" height="16" align="absmiddle" border="0" alt="<?php echo $text_general_addsub;?>"></a>
					 <a href="#G" onClick="txt_data('<?php echo $R["category_id"]; ?>','')"><img id="lang<?php echo $R["category_id"]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a>  </nobr>
					 <?php } ?>
					 </td>
					<td> <?php
							//GenPic($R["category_parent_id"]);
							//GenPic($R["parent_id"]);
						   ?>
											  <img src="images/o.gif" width="20" height="20" border="0" align="absmiddle">
									  <?php       
												$sql_count_img = "select count(*) as count_img FROM gallery_cat_img WHERE category_id = '$R[category_id]' ";
												$query_count_img = $db->query($sql_count_img);
												$rs_count_img = $db->db_fetch_array($query_count_img);
												$count_img = $rs_count_img[count_img];
											  ?><img src="../theme/main_theme/arrow_r.gif" width="7" height="7" border="0" align="absmiddle">&nbsp;<a href="gallery_view_category.php?category_id=<?php echo $R["category_id"]?>"><?php echo $R["category_name"]." ( $count_img รูป ) "; ?></a> </div>
										  <?php  if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  style=\"display:none\">"; }  ?></td>
					<td><?php if($db->check_permission("Gallery","g","")){ echo show_icon_lang($R["category_id"],'gallery_category'); }?></td>
				  </tr>
				  <?php 
				
				   $i++;
				   
				   child($R["category_id"],0,$decho);
				   
				   } ?>
				  <?php }?>
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
<?php
$db->db_close(); ?>
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

	 window.location.href='../multilangMgt/gallery_catogory.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>
