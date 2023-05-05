<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$db->query("USE ".$EWT_DB_USER);

function level_name($L,$id){
	global $db,$EWT_DB_USER;
		if($L == "A"){
			//echo "<img src=\"../images/user_a.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$s_sql = $db->query("SELECT emp_type_name FROM emp_type WHERE emp_type_id = '{$id}' ");
			$r_data = $db->db_fetch_row($s_sql);
			return $r_data[0];
		}
		if($L == "D"){
			//echo "<img src=\"../images/user_group.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$s_sql = $db->query("SELECT name_org FROM org_name WHERE org_id = '{$id}' ");
			$r_data = $db->db_fetch_row($s_sql);
			return $r_data[0];
		}
		if($L == "L"){
			//echo "<img src=\"../images/user_c.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$s_sql = $db->query("SELECT ul_name FROM user_level WHERE ul_id = '{$id}' ");
			$r_data = $db->db_fetch_row($s_sql);
			return $r_data[0];
		}
		if($L == "P"){
			//echo "<img src=\"../images/user_pos.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$s_sql = $db->query("SELECT position_name.pos_name FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.up_id = '{$id}' ORDER BY user_position.up_rank ASC ");
			$r_data = $db->db_fetch_row($s_sql);
			return $r_data[0];
		}
		if($L == "U"){
			//echo "<img src=\"../images/user_logo.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$s_sql = $db->query("SELECT name_thai,surname_thai,gen_user FROM gen_user WHERE gen_user_id = '{$id}' ");
			$r_data = $db->db_fetch_row($s_sql);
			return $r_data[0]." - ".$r_data[1]." (".$r_data[2].")";
	}
}
	
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;


/*if($_SESSION['EWT_SMID']){
	
	$_sql = $db->query("SELECT * 
						FROM leader_list 
						WHERE leader_list.leader_id = '{$_SESSION['EWT_SMID']}'{$wh}  
						ORDER BY leader_list.under_id ASC LIMIT {$start} , {$perpage} 
						");
	$statement = "SELECT count(leader_id) AS b
				  FROM leader_list WHERE leader_list.leader_id = '{$_SESSION['EWT_SMID']}'  {$wh}";
	
}else{*/


##===========================================================================================##
## >> Filter search
$where_user   = " 1=1 ";
$search_pagin = "";

if($_GET["search"]=="Y"){

	$search_pagin .= "search=Y&";
	
	$fullname = trim($_GET["fullname"]);
	$search_pagin .= "fullname=".ready($_GET["fullname"])."&";
	if($fullname!=""){
		$find = explode(" ",$fullname);
		foreach($find AS $find_e){
			if($find_e!=""){
				$find_e = ready($find_e);
				$where_user .= " AND ((g.name_thai LIKE '%$find_e%') OR (g.surname_thai LIKE '%$find_e%')) ";
			}
		}
	}
	
	$username = trim($_GET["username"]);
	$search_pagin .= "username=".ready($_GET["username"])."&";
	if($username!=""){
		$find = explode(" ",$username);
		foreach($find AS $find_e){
			if($find_e!=""){
				$find_e = ready($find_e);
				$where_user .= " AND ((g.gen_user LIKE '%$find_e%')) ";
			}
		}
	}
}
else{
	$search_pagin = "&";
}
##===========================================================================================##
$_sql = $db->query("SELECT wgm.*
					FROM   web_group_member wgm 
					WHERE  wgm.ug_id = '{$_SESSION["EWT_SUID"]}' 
					AND  wgm.ugm_tid IN (SELECT gen_user_id 
										 FROM   gen_user g
										 WHERE  $where_user)
					ORDER BY wgm.ugm_type ASC
					LIMIT   {$start} , {$perpage} 
					");
$statement = "      SELECT count(ugm_id) AS b
			        FROM   web_group_member wgm
			        WHERE  wgm.ug_id = '{$_SESSION['EWT_SUID']}' 
					AND  wgm.ugm_tid IN (SELECT gen_user_id 
										 FROM   gen_user g
										 WHERE  $where_user)";
//}

					
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);

?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<h4><?php echo $txt_permission_menu_user;?></h4>
<p></p> 
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="permission_main.php"><?php echo $txt_permission_menu_user;?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
	<button type="button" class="btn btn-info  btn-ml"  onClick="boxPopup('<?php echo linkboxPopup();?>pop_set_permission_user.php');"  title="<?php echo $txt_complain_add_cate;?>"  target="_self">
	<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_permission_add_user;?>
	</button>
	<button type="button" class="btn btn-primary btn-ml search_module_button">
		<i class="fas fa-search"></i>&nbsp;ค้นหาผู้ใช้งาน
	</button>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_set_permission_user.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_permission_add_user;?></a></li>
			
            <li><a href="javascript:void(0);" class="search_module_button"><i class="fas fa-search"></i>&nbsp;ค้นหาผู้ใช้งาน</a></li>
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<div class="card ">
<div class="card-header ewt-bg-color " >
<div class="card-title text-left color-white">
<h4><?php echo $txt_permission_menu_user;?></h4>
</div>
</div>
<div class="card-body">
<div class="panel-group" id="accordion">
<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($_sql)){
?>	
<div class="panel panel-default ">
            <div class="panel-heading ewt-bg-success">
                <p class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					<i class="fas fa-user-cog color-ewt"></i>
					<?php echo level_name($a_data['ugm_type'],$a_data['ugm_tid']);?> 
					</a>					
                </p>
            </div>
		
<div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
<div class="panel-body">
<div><b><?php echo $txt_permission_admission;?> :</b></div><br> 
<?php echo show_permission($a_data['ugm_type'],$a_data['ugm_tid']);?>
</div>
<div class="panel-footer ewt-bg-white text-right">
<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">

<button type="button" class="btn btn-default  btn-circle  btn-sm " onClick="JQDelete_Permission_user('<?php echo $a_data['ugm_tid'];?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_permission_del_user ;?>" >
<i class="far fa-trash-alt " aria-hidden="true"></i>
</button>
<a href="permission_builder_user.php?mid=<?php echo url_encode($a_data['ugm_tid']);?>&mtype=<?php echo url_encode($a_data['ugm_type']);?>" >
<button type="button" class="btn btn-default  btn-circle  btn-sm "  data-toggle="tooltip" data-placement="top" title="<?php echo $txt_permission_set ;?>" >
<i class="fas fa-user-cog" aria-hidden="true"></i>
</button>
</a>					
<!--<a onClick="JQSet_Lang_Calendar('<?//=$a_data['event_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?//=$txt_ewt_create_multilang;?>">
<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?//=$a_data['event_id'];?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>-->
</div>
</div>
</div>
</div>
<?php $i++;} }else{?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php } ?>		
		
</div>

</div>
</div>	
<?php 
echo pagination_ewt($statement,$perpage,$page,$url='?'.$search_pagin);?>	
</div>
</div>

</div>
<!--END card-body-->
</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php

function show_permission($type,$id){
	global $db,$EWT_DB_USER,$IMG_PATH;
	
	echo "<ul>";
	$sql_sadmin = $db->query("SELECT * FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'suser' ");
	if($db->db_num_rows($sql_sadmin) > 0){
			echo '<i class="fas fa-user-shield"></i> Super admin';
	}else{
	$sql_p = $db->query("SELECT web_permission.p_name,web_permission.p_code,web_permission.p_type FROM permission INNER JOIN web_permission ON permission.s_type = web_permission.p_code AND permission.s_permission = web_permission.p_type WHERE permission.p_type = '".$type."' AND permission.pu_id = '".$id."' AND permission.UID = '".$_SESSION["EWT_SUID"]."'  GROUP BY web_permission.p_name ORDER BY web_permission.p_id");
	
		while($PP = $db->db_fetch_row($sql_p)){

	$_sql_item = $db->query("SELECT *
					FROM web_permission
					LEFT JOIN web_module_ewt ON web_module_ewt.m_code = web_permission.p_code
					WHERE web_permission.p_status = 'Y' 
					AND web_module_ewt.m_status = 'Y' 
					AND web_permission.p_code = '{$PP['1']}' 
					");						
	$a_data_item = $db->db_fetch_array($_sql_item);	

			echo "<li> <i class=\"far fa-check-circle text-success\"></i> ";
			echo ' <img src="'.$IMG_PATH.$a_data_item['m_image'].'" class="img-responsive" style="display:inline;margin: 0 1px;width:24px;height:24px;" />';
			echo ' '.$a_data_item['m_name'];
			echo ' ('.$PP[0].") </li>";
			    // cms w
				if($PP[1] == "cms" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'w' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'w' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT Main_Group_Name FROM temp_main_group WHERE Main_Group_ID = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// cms a
				if($PP[1] == "cms" AND $PP[2] == "a"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'a' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'a' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT Main_Group_Name FROM temp_main_group WHERE Main_Group_ID = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li><i class=\"fas fa-folder\"></i> ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// art w
				if($PP[1] == "art" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'w' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'w' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT c_name FROM article_group WHERE c_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li style=\"padding-left:50px;\"><i class=\"fas fa-folder\"></i> ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				//art a
				if($PP[1] == "art" AND $PP[2] == "a"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'a' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'a' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT c_name FROM article_group WHERE c_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li style=\"padding-left:50px;\"><i class=\"fas fa-folder\"></i> ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
					//img and dl
				if(($PP[1] == "img" or $PP[1] == "dl") AND $PP[2] == "w"){
				if($PP[1] == "img" ){
				$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'imgFo' AND s_permission = 'w' AND s_id = '0' and s_name = '0'");
				}else if($PP[1] == "dl"){
				$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'dlFo' AND s_permission = 'w' AND s_id = '0' and s_name = '0'");
				}
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>Folder all</li></ul>";
					}else{
						if($PP[1] == "img"){
							$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";
						}else if($PP[1] == "dl"){
						$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download";
						}

							$folder = base64_decode($_REQUEST["myfolder"]);
							
							$Current_Dir = $Globals_Dir."/".$folder;
							//echo $Current_Dir;
							if (!(file_exists($Current_Dir))) {
							
							$Current_Dir = $Globals_Dir;
							}
							$array_folder = array();
							$objFolder = opendir($Current_Dir);
							rewinddir($objFolder);
							$f = 0;
										  while($file = readdir($objFolder)){
											  if(!(($file == ".") or ($file == "..") or ($file == "Thumbs.db") )){
											  $FT= filetype($Current_Dir."/".$file);
												  if($FT == "dir"){
												  array_push ($array_folder,$file);
												  }else{
												  $array_file[$f][0] = $file;
												$f++;
												  }
											  }
										  }
										  closedir($objFolder);
							 $numfolder = count($array_folder);
							 echo "<ul>";
							 for($y=0;$y<$numfolder;$y++){
								if($folder != ""){
								$preview_path = $folder."/".$array_folder[$y];
								}else{
								$preview_path = $array_folder[$y];
								}
								$preview_path_en = base64_encode($preview_path);
								if($PP[1] == "img" ){
								 $sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'imgFo' AND s_permission = 'w' AND s_id = '0' AND s_name = '".$array_folder[$y]."' ",$EWT_DB_USER);
								}else if($PP[1] == "dl"){
								$sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'dlFo' AND s_permission = 'w' AND s_id = '0' AND s_name = '".$array_folder[$y]."' ",$EWT_DB_USER);
								}
								
									if($db->db_num_rows($sql_sadmin) > 0){
										echo "<li style=\"padding-left:50px;\"><i class=\"fas fa-folder\"></i> ".$array_folder[$y]."</li>";
									}else{
										
									}
									
								}
								 echo "</ul>";
							}
						}
				//Gallery w
					if($PP[1] == "Gallery" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Gg' AND s_permission = 'w' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Gg' AND s_permission = 'w' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT category_name FROM gallery_category WHERE category_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				//menu
				if($PP[1] == "menu" AND $PP[2] == "w"){
					    $sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'menu' AND s_permission = 'w' AND s_name = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					     echo "<ul><li>ทุกเมนู</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_name FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'menu'  ");
					//echo "SELECT s_name FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'menu'  ";
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT m_name FROM menu_list WHERE m_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>ดีไซน์ ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				
				// site design
				if($PP[1] == "sdes" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'sdes' AND s_permission = 'm' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'sdes' AND s_permission = 'm' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT d_name FROM design_list WHERE d_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>template ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// download management
				if($PP[1] == "dlmgt" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'dlmgt' AND s_permission = 'm' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'dlmgt' AND s_permission = 'm' ");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT dlg_name FROM docload_group WHERE dlg_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// calendar
				if($PP[1] == "calendar" AND $PP[2] == "w"){
					    $sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'calendar' AND s_permission = 'a' AND s_name = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					     echo "<ul><li>ทุกเมนู</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'calendar'  ");
					//echo "SELECT s_name FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'menu'  ";
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT cat_name FROM cal_category WHERE cat_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				//end check
		}
		}
		echo "</ul>";
	}



$db->query("USE ".$EWT_DB_NAME);	
include("../EWT_ADMIN/combottom.php");
?>
                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>

.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}

</style>
<script>
function JQDel_Permission(id){
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_permission.php',
											data:{'id': id,'proc':'DelPer'},
											success: function (data) {
												$.alert({
													title: '',
													theme: 'modern',
													content: 'ลบข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}

function JQDelete_Permission_user(id){
	$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_delete_permission_user.php',
											data:{'id': id,'proc':'DelPermisUser'},
											success: function (data) {
												$.alert({
													title: '',
													theme: 'modern',
													content: 'ลบข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
	
}
function JQDelete(id){
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-exclamation-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_vdo.php',
											data:{'id': id,'proc':'DelVdo'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'url:text.html',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: 'ตกลง',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}

</script>

<?php
## >> Include search modal

$search_button_class = "search_module_button";
$search_title        = "ค้นหาผู้ใช้งานระบบ ";
$search_action       = "../PermissionMgt/permission_user.php";
$search_parameter    = array(array("name"=>"fullname",
								   "type"=>"text",
								   "label"=>"ชื่อ-สกุล ผู้ใช้งาน"),
							 array("name"=>"username",
								   "type"=>"text",
								   "label"=>"Username"));
include "../include/module_search.php";
?>