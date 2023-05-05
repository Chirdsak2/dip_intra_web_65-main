<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");


if($db->check_permission("org","u","")){ $type_right = 'Y';}
$db->query("USE ".$EWT_DB_USER);

/*$name_field = array('name_thai','surname_thai','position_person','officeaddress');
$sql_lang = "select gen_user_id,surname_eng,name_eng from gen_user where surname_eng <> '' and name_eng <> ''";
$query_lang = $db->query($sql_lang);
while($rec_lang = $db->db_fetch_array($query_lang)){
$sql_chk = "select * from lang_gen_user where c_id ='".$rec_lang[gen_user_id]."'";
	if($db->db_num_rows($db->query($sql_chk))==0){
		for($i=0;$i<count($name_field);$i++){
			if($i ==0){
			$filename = $rec_lang[name_eng];
			}else if($i ==1){
			$filename = $rec_lang[surname_eng];
			}else if($i ==2){
			$filename = '';
			}else if($i ==3){
			$filename = '';
			}
			$db->query("insert into lang_gen_user (c_id,lang_name,lang_field,lang_detail) values ('".$rec_lang[gen_user_id]."','2','".$name_field[$i]."','".$filename."')");
		}
	}
}*/
function chk_org($s_id){
global $db;
$sql = "select * from gen_user where gen_user_id ='".$s_id."'";
$query  = $db->query($sql);
$R = $db->db_fetch_array($query);
return $R[org_id];
}

$right_org_id= chk_org($_SESSION["EWT_SMID"]);

function chk_status($status){
	switch($status){
			case 1:$status_type = 'ใช้งาน';break;
			case 2:$status_type = 'ไม่ใช้งาน';break;
			default:$status_type = '';break;	
	}
	return $status_type;
}
 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
if(empty($limit)){
$limit = 20;
}

if($_GET["proc"]=='delete'){
$sql_chk = $db->db_fetch_array($db->query("select * from gen_user where emp_type_id ='".$_GET["gen_user_id"]."' "));
$db->query("USE ".$_SESSION["EWT_SDB"]);
$db->write_log("delete","member","ลบเจ้าหน้าที่ชื่อ : ".$sql_chk['name_thai'].'  '.$sql_chk['surname_thai']);
$db->query("USE ".$EWT_DB_USER);
$sql_del = "delete from gen_user where gen_user_id = '".$_GET["gen_user_id"]."'";
$db->query($sql_del);
$sql_del2 = "DELETE FROM permission WHERE pu_id='".$_GET["gen_user_id"]."' AND UID='$_SESSION[EWT_SUID]'";
$db->query($sql_del2);
$sql_del3= "DELETE FROM web_group_member WHERE ugm_tid='".$_GET["gen_user_id"]."' AND ug_id='$_SESSION[EWT_SUID]'";
$db->query($sql_del3);

$db->query("delete from gen_user_order where up_user_id = '".$_GET["gen_user_id"]."' ");
		echo "<script language=\"javascript\">";
		echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
		//echo "document.location.href='MemberList.php';" ;
		echo "</script>";
}
?>
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script >
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
function txt_data(w) {
	var mytop = findPosY(document.form1.org_id) +document.form1.org_id.offsetHeight;
	var myleft = findPosX(document.form1.org_id);	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='nav_pad.php?d='+ w;
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
<script >
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
		function txt_data2(w,g) {
	
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

	 window.location.href='../multilangMgt/MemberList.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>


<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?=$txt_article_group;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="article_group.php"><?=$txt_article_group;?></a></li>

</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	
<a href="article_gadd.php?cid=<?=$cid;?>" target="_self">  
<button type="button" class="btn btn-info  btn-sm"    title="<?=$txt_article_add_group;?>"  >
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_article_add_group;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <!--<li><a onClick="boxPopup('<?//=linkboxPopup();?>pop_add_complain_form.php?com_cid=<?//=$com_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?//=$txt_complain_add_cate;?></a></li>-->	
			<li><a href="article_gadd.php?cid=<?=$cid;?>" target="_self"> <i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_complain_add_cate;?></a></li>	
			<li><a href="article_new.php?cid=<?=$cid;?>" target="_self"> <i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_article_add;?></a></li>							
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->


<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >
  
<table width="100%" class="table table-bordered">
<thead>
<tr class="success">

                      <th width="5%"  class="text-center">&nbsp;</th>
                      <th width="20%" class="text-center">ชื่อ - สกุล </th>
                      <th width="20%" class="text-center">หน่วยงาน</th>
                      <th width="15%" class="text-center">ตำแหน่งภายในหน่วยงาน</th>
                      <th width="20%" class="text-center">ตำแหน่งทางวิชาการ</th>
                      <th width="10%" class="text-center">สถานะ</th>
                      <th width="10%" class="text-center">ภาษาอื่น</th>
</tr>
</thead>
<tbody>
<?php
					if($namesurname){
					   $name=split(' ',$namesurname);
					   if($name[0]  &&  $name[1]=='' ){
					   $condition.="(gen_user.name_thai  like '$name[0]%'  OR  gen_user.surname_thai  like '$name[0]%' or gen_user.name_eng  like '$name[0]%'  OR  gen_user.surname_eng  like '$name[0]%')   AND "; 
					   }
					   if($name[0]    &&   $name[1]){
						 $condition.=" (gen_user.name_thai  like '$name[0]%'  OR  gen_user.surname_thai  like '$name[1]%' or gen_user.name_eng  like '$name[0]%'  OR  gen_user.surname_eng  like '$name[0]%')   and "; 
					   }
					   $db->query("USE ".$_SESSION["EWT_SDB"]);
					   $db->write_log("search","member","ค้นหาสมาชิกชื่อ : ".$namesurname);
					   $db->query("USE ".$EWT_DB_USER);
					}
					
						if($org_id){
						  $condition.="(org_name.name_org  LIKE  '%".$org_id."%')   and  ";
						  $sql_chk = $db->db_fetch_array($db->query("select * from org_name where org_id ='".$_POST["org_id"]."' "));
						  $db->query("USE ".$_SESSION["EWT_SDB"]);
						  $db->write_log("search","member","ค้นหาหน่วยงาน : ".$sql_chk[name_org]);
						  $db->query("USE ".$EWT_DB_USER);
						}
					if($position_person){
						  $condition.="(gen_user.position_person  like  '%$position_person%')   and  ";
						  $db->query("USE ".$_SESSION["EWT_SDB"]);
						  $db->write_log("search","member","ค้นหาตำแหน่งทางวิชาการ : ".$position_person);
						  $db->query("USE ".$EWT_DB_USER);
						}
					if($pos_id){
						  $sql_chk = $db->db_fetch_array($db->query("select * from position_name where pos_id ='".$_POST["pos_id"]."' "));
						  $db->query("USE ".$_SESSION["EWT_SDB"]);
						  $db->write_log("search","member","ค้นหาตำแหน่งภายในหน่วยงาน : ".$sql_chk[pos_name]);
						  $db->query("USE ".$EWT_DB_USER);
						  $condition.="(position_name.pos_id  = '$pos_id')   and  ";
						}
					
						if($_SESSION["EWT_SMTYPE"] != "Y"  && $type_right  == 'Y'){
					$wh = " AND gen_user.org_id='".$right_org_id."'";
					}
					
$sql = "SELECT *
		FROM `gen_user`
		LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		WHERE  {$condition} `emp_type`.`emp_type_status` = '2' {$wh} 
		ORDER BY `gen_user`.`name_thai` ";
  		//AND  `gen_user`.gen_user_id IN (SELECT DISTINCT(pu_id) FROM permission WHERE UID='$_SESSION[EWT_SUID]')
					$sql_member = $sql." LIMIT {$offset},{$limit} ";
					//echo '<div style="color:#FFFFFF;">'.$sql_member.'</div>';
					$query = $db->query($sql_member);
					$num_rows = $db->db_num_rows($query);
					$rows = mysql_num_rows($db->query($sql));
					$i = 1;
					if(!empty($num_rows)){
					while($rec = $db->db_fetch_array($query)){
					//print_r($rec);
						if($bg == "#FFFFFF"){
							$bg = "#FFF8EC";
						}else{
							$bg = "#FFFFFF";
						}
							$gen_user_id	=	$rec['gen_user_id'];
							$title_thai		=	$rec['title_thai'];
							$name_thai		=	$rec['name_thai'];
							$surname_thai	=	$rec['surname_thai'];
							$emp_type_name	=	$rec['emp_type_name'];
							$name_org		=	$rec['name_org'];
							$level_name		=	$rec['level_name'];
						?>
						<tr >
						  <td class="text-left"><nobr><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไขข้อมูล" onMouseOver="this.style.cursor='hand';" onClick="win3=window.open('frm_add_member.php?gen_user_id=<?php echo $rec[gen_user_id]?>&emp_id=<?php echo $rec[emp_id]?>&proc=edit', 'editmember', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=600, width=800, left=10,top=10');win3.focus();">   <a href="MemberList.php?gen_user_id=<?php echo $rec[gen_user_id]?>&emp_id=<?php echo $rec[emp_id]?>&proc=delete"><img src="../theme/main_theme/g_del.gif" alt="ลบข้อมูล" width="16" height="16" border="0" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');" onMouseOver="this.style.cursor='hand';" ></a> 
						  <a href="#G" onClick="txt_data2('<?php echo $rec[gen_user_id]; ?>','')"><img id="lang<?php echo $rec[gen_user_id]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a></nobr></td>
						  <td class="text-left">&nbsp;<a href="#view" onClick="window.open('view_profile.php?emp_id=<?php echo $gen_user_id; ?>', 'select_org', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');"><?php echo $name_thai;?> <?php echo $surname_thai;?></a></td>
						  <td class="text-left">&nbsp;<?php echo $name_org;?></td>
						  <td class="text-left">&nbsp;<?php if($rec[pos_name] != ''){echo $rec[pos_name];}else{ echo '-';}?></td>
						  <td class="text-left">&nbsp;<?php echo $rec[position_person];?></td>
						  <td class="text-left">&nbsp;<?php echo chk_status($rec[status]);?></td>
					      <td class="text-left"><?php echo show_icon_lang_ewt($gen_user_id,'gen_user');?></td>
						</tr>


						<?php
						 $i++;
								
						}//end while
					}else{
					?>


<tr bgcolor="#FFFFFF">
<td colspan="7" align="center">ไม่พบข้อมูล</td>
</tr>
					
					<?php
					}
					?>				
</tbody>						
</table>
</div>

</div>
</div>

</div>
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE ".$EWT_DB_NAME);

include("../EWT_ADMIN/combottom.php");
?>
