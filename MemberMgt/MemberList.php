<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($db->check_permission("org","u","")){ $type_right = 'Y';}
$db->query("USE ".$EWT_DB_USER);
include("../lib/set_lang.php");
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
include("../lib/config_path.php");
include("../header.php");	
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
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
</head>

<body leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
<?php
include('top.php');
?>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?="บริหารข้อมูลบุคลากร" ;?></h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-8 col-sm-8 col-xs-12">
<form class="form-inline" name="form1" method="post" action="">
<div class="form-group form-inline">
<label for="namesurname" >ค้นหา  : </label>
ชื่อ-สกุล : <input name="namesurname" type="text" class="form-control"  value="<?php echo $namesurname;?>" /> หน่วยงาน : <input class="form-control"  name="org_id" type="text" id="org_id" onKeyUp="txt_data(this.value)" value="<?php echo $org_id; ?>"  autocomplete="off" />
</div>
<input type="hidden" name="limit" value="20"> 
<input type="hidden" name="offset" value="0">
<input type="submit" name="Submit" value="ค้นหา" class="btn btn-success" />
</form>


</div>
<div class="col-md-4 col-sm-4 col-xs-12" style="text-align:right;" >

<a onMouseOver="this.style.cursor='hand';" onClick="self.location.href='frm_add_member.php?proc=add';">
<button type="button" class="btn btn-info" >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?="เพิ่มข้อมูลบุคลากร";?>
</button>	  	  
</a>
<!--<a href="ewt_permission0.php" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>-->


</div>
</div>
<hr />
</div>	
<div class="clearfix">&nbsp;</div>




  <!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">บริหารข้อมูลบุคลากร</span> </td>
    </tr>
  </table>
  
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("บริหารข้อมูลบุคลากร");?>&module=org&url=<?php echo urlencode("MemberList.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a onMouseOver="this.style.cursor='hand';" onClick="self.location.href='frm_add_member.php?proc=add';"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"><span class="MemberHead"> เพิ่มข้อมูลบุคลากร</span></a>
        <hr>
      </td>
    </tr>
  </table>-->
  
  
  <!--<form name="form1" method="post" action="">
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="87%" colspan="2" >
	  <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewttableuse" style="border-collapse:collapse">
                  <tr>
                    <td>
                      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#B2B2B2" >
                <tr class="ewttablehead"> 
                  <td colspan="2">ค้นหา</td>
                </tr>
                <tr> 
                  <td width="28%" align="left" bgcolor="#FFFFFF"> ชื่อ-สกุล :</td>
                  <td width="72%" align="left" bgcolor="#FFFFFF"><input name="namesurname" type="text" size="50" value="<?php echo $namesurname;?>" /></td>
                </tr>
                <tr> 
                  <td align="left" bgcolor="#FFFFFF">หน่วยงาน : </td>
                  <td align="left" bgcolor="#FFFFFF"> <input name="org_id" type="text" id="org_id" onKeyUp="txt_data(this.value)" value="<?php echo $org_id; ?>" size="50" autocomplete="off" ></td>
                </tr>
                <tr  style="display:none"> 
                  <td align="left" bgcolor="#FFFFFF">ตำแหน่งภายในหน่วยงาน : </td>
                  <td align="left" bgcolor="#FFFFFF"><select name="pos_id"  id="pos_id"    >
                      <option value="">--โปรดเลือก--</option>
                      <?php 
					//pos_name
					/*$sql_position = $db->query("select * from position_name ORDER BY pos_level,pos_name ASC ");
					 while($rec_position = $db->db_fetch_array($sql_position)){
					  if($rec_position[pos_id] ==  $posittion) $selected_position= "selected";
							else $selected_position = "";
							print '<option value="'.$rec_position[pos_id].'" '.$selected_position.'>'.$rec_position[pos_name].'</option>';
					  }*/
					?>
                    </select></td>
                </tr>
                <tr   style="display:none"> 
                  <td align="left" bgcolor="#FFFFFF">ตำแหน่งทางวิชาการ :</td>
                  <td align="left" bgcolor="#FFFFFF"><input name="position_person" type="text" id="position_person" value="<?php echo $position_person;?>" size="50"></td>
                </tr>
                <tr align="right"> 
                  <td colspan="2" bgcolor="#FFFFFF"> <input name="Submit" type="submit" value="ค้นหา"  > 
                    &nbsp; <script language="javascript">
						  function clear_data(){
						   frm.namesurname.value='';
						   frm.emp_type_id.value='';
						   frm.level_id.value='';
						   frm.name_org.value='';
						   frm.org_id.value='';
						  }
						  </script> <input type="hidden" name="limit" value="20"> 
                    <input type="hidden" name="offset" value="0"></td>
                </tr>
              </table></td>
                  </tr>
              </table></td>
    </tr>
  </table>
  </form>-->
  
  
  <table width="100%" class="table table-bordered">
                    <tr class="ewttablehead">
                      <th width="5%" style="text-align:center;">&nbsp;</th>
                      <th width="20%" style="text-align:center;">ชื่อ - สกุล </th>
                      <th width="20%" style="text-align:center;">หน่วยงาน</th>
                      <th width="15%" style="text-align:center;">ตำแหน่งภายในหน่วยงาน</th>
                      <th width="20%" style="text-align:center;">ตำแหน่งทางวิชาการ</th>
                      <th width="10%" style="text-align:center;">สถานะ</th>
                      <th width="10%" style="text-align:center;">ภาษาอื่น</th>
                    </tr>
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
					
		$sql="SELECT *
FROM
  `gen_user`
  LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
  LEFT OUTER JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
  WHERE  $condition emp_type.emp_type_status = '2'  $wh ORDER BY gen_user.name_thai ";
  		//AND  `gen_user`.gen_user_id IN (SELECT DISTINCT(pu_id) FROM permission WHERE UID='$_SESSION[EWT_SUID]')
					$sql_member = $sql." LIMIT $offset,$limit ";
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
							$gen_user_id=$rec[gen_user_id];
							$title_thai=$rec[title_thai];
							$name_thai=$rec[name_thai];
							$surname_thai=$rec[surname_thai];
							$emp_type_name=$rec[emp_type_name];
							$name_org=$rec[name_org];
							$level_name=$rec[level_name];
						?>
						<tr bgcolor="<?php echo $bg?>" onMouseOver="this.style.backgroundColor='#FEFEEB';this.style.color='#FF6600'" onMouseOut="this.style.backgroundColor='<?php echo $bg?>';this.style.color='#000000'">
						  <td height="20" align="center" bgcolor="#FFFFFF"><nobr><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไขข้อมูล" onMouseOver="this.style.cursor='hand';" onClick="win3=window.open('frm_add_member.php?gen_user_id=<?php echo $rec[gen_user_id]?>&emp_id=<?php echo $rec[emp_id]?>&proc=edit', 'editmember', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=600, width=800, left=10,top=10');win3.focus();">   <a href="MemberList.php?gen_user_id=<?php echo $rec[gen_user_id]?>&emp_id=<?php echo $rec[emp_id]?>&proc=delete"><img src="../theme/main_theme/g_del.gif" alt="ลบข้อมูล" width="16" height="16" border="0" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');" onMouseOver="this.style.cursor='hand';" ></a> 
						  <a href="#G" onClick="txt_data2('<?php echo $rec[gen_user_id]; ?>','')"><img id="lang<?php echo $rec[gen_user_id]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a></nobr></td>
						  <td bgcolor="#FFFFFF">&nbsp;<a href="#view" onClick="window.open('view_profile.php?emp_id=<?php echo $gen_user_id; ?>', 'select_org', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');"><?php echo $name_thai;?> <?php echo $surname_thai;?></a></td>
						  <td bgcolor="#FFFFFF">&nbsp;<?php echo $name_org;?></td>
						  <td bgcolor="#FFFFFF">&nbsp;<?php if($rec[pos_name] != ''){echo $rec[pos_name];}else{ echo '-';}?></td>
						  <td bgcolor="#FFFFFF">&nbsp;<?php echo $rec[position_person];?></td>
						  <td align="center" bgcolor="#FFFFFF">&nbsp;<?php echo chk_status($rec[status]);?></td>
					      <td align="center" bgcolor="#FFFFFF"><?php echo show_icon_lang_ewt($gen_user_id,'gen_user');?></td>
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
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30">หน้าที่ 
        :</strong></font> 
        <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&namesurname=$namesurname&org_id=$org_id&pos_id=$pos_id&position_person=$position_person'>
<font color=\"red\"><< ก่อนหน้า</font></a>\n\n";
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
                  echo  "<a href='$PHP_SELF?offset=$newoffset&namesurname=$namesurname&org_id=$org_id&pos_id=$pos_id&position_person=$position_person' ". 
                  " ><font  color=\"black\">&nbsp;$i&nbsp;</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&namesurname=$namesurname&org_id=$org_id&pos_id=$pos_id&position_person=$position_person'>
		  <font color=\"red\">ถัดไป>></font></a>"; 
    }
?></td>
  </tr>
</table>

</div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
<?php $db->db_close(); ?>
