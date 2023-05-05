<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

/*if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
	session_register("EWT_OPEN_ARTICLE");
}*/
$_SESSION["EWT_OPEN_ARTICLE"] = "";

$cid = (int)(!isset($_GET['cid']) ? '' : $_GET['cid']);

##======================================================================================================================##
function article_group_parent($id){
	global $db;

	$s_parent = $db->query("SELECT * FROM article_group WHERE c_id = '{$id}' ");
	if($db->db_num_rows($s_parent)){
		$a_parent = $db->db_fetch_array($s_parent);
		$txt = "<li ><a href =\"article_group.php?cid=".$a_parent['c_id']."\">".$a_parent['c_name']."</a></li>";
		if($a_parent['c_parent'] != "0" AND $a_parent['c_parent'] != ""){
			$txt = article_group_parent($a_parent['c_parent']).$txt;
		}

	}
	return $txt;
}

function article_group_backto($cid){
	global $db;
	$s_group = $db->query("SELECT * FROM article_group WHERE c_id = '{$cid}' ");
	if($db->db_num_rows($s_group)){
	 		$a_data = $db->db_fetch_array($s_group);
		if($a_data['c_parent'] != "0"){
			$txt = "article_group.php?cid={$a_data['c_parent']}";
		}else{
			$txt = "article_group.php";
		}
		return $txt;
	}
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
		$sql2 = $db->query("SELECT COUNT(n_id) FROM article_list WHERE n_approve != 'D' AND c_id = '".$U["c_id"]."' ");
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
		$sql2 = $db->query_db("SELECT s_id FROM permission 
		WHERE ((p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."') 
		OR (p_type = 'D' AND pu_id = '".$_SESSION["EWT_SMDIV"]."')) 
		AND UID = '".$_SESSION["EWT_SUID"]."' 
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

$sql_supadmin = $db->query_db("SELECT s_id FROM permission 
WHERE ((p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."') 
OR (p_type = 'D' AND pu_id = '".$_SESSION["EWT_SMDIV"]."'))  
AND UID = '".$_SESSION["EWT_SUID"]."' 
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


##======================================================================================================================##
		
$db->query("USE ".$EWT_DB_NAME);

$perpage 	= 10;
$page 		= (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start 		= ($page * $perpage) - $perpage;

##======================================================================================================================##
$sql_search_group     = '1=1 ';
$sql_search_article   = '';
$search_pagin         = "";

if($_GET["search"]=="Y"){
	$search_word        = trim($_GET['search_word']);

	if($search_word != ""){
		$find       =  ready($search_word);
		$sql_search_group   .= " AND c_name LIKE '%$find%' ";
		$sql_search_article .= " AND n_topic LIKE '%$find%' ";
		$search_pagin      .= "search_word=".$find."&";
	}
	else{
		$search_pagin      .= "search_word=&";
	}
	$search_pagin      .= "search=Y&";
}
else{
	$search_pagin = "";
}

##======================================================================================================================##
if(empty($sql_search_group)){
	if($db->check_permission($ptype,$ppms,"0")){
		//$wh = "WHERE c_parent = '0'";
		$sql_article = "SELECT * FROM article_group WHERE $sql_search_group ";	
	}else{
		$wh = $sql_text;
		$sql_article = "SELECT * FROM article_group WHERE $sql_search_group ";
	}
}
else{
	//$wh = "WHERE c_id != '0'";
	$sql_article = "SELECT * FROM article_group WHERE $sql_search_group ";	
}

$group_sql = $db->query($sql_article." ORDER BY c_order ASC LIMIT {$start} , {$perpage} ");

$statement 		= "SELECT count(c_id) AS b
				   FROM article_group
				   WHERE $sql_search_group ";
			  
$a_rows_group	= $db->db_num_rows($group_sql);		
$s_count 		= $db->query($statement);
$a_count 		= $db->db_fetch_array($s_count);
$total_record 	= $a_count['b'];
$total_page_group 	= (int)ceil($total_record / $perpage);

##=======================================================================================================================##

$article_sql = $db->query("SELECT *
							FROM article_list 
							WHERE n_approve <> 'D' AND n_id != '' $sql_search_article
							ORDER BY n_date DESC , n_timestamp DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(n_id) AS b
				FROM article_list 
				WHERE n_approve <> 'D' AND n_id != '' $sql_search_article ";

$a_rows = $db->db_num_rows($article_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page_article = (int)ceil($total_record / $perpage);	 

##=======================================================================================================================##
if($total_page_article>$total_page_group){
	$total_page = $total_page_article;
}
else{
	$total_page = $total_page_group;
}
?>


<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4>ค้นหาหมวดข่าว/บทความ</h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

	<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	
	<a href="article_gadd.php?cid=<?php echo $cid;?>" target="_self">  
	<button type="button" class="btn btn-info  btn-sm"    title="<?php echo $txt_article_add_group;?>"  >
	<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_article_add_group;?>
	</button>
	</a>
	<a href="article_new.php?cid=<?php echo $_GET['cid']; ?>" target="_self">
	<button type="button" class="btn btn-info  btn-sm">
	<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_article_add;?> 
	</button>
	</a>
	<?php if($cid){ ?> 
	<a href="<?php echo article_group_backto($cid);?>" target="_self">
	<button type="button" class="btn btn-info   btn-sm " >
	<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?>
	</button>
	</a>
	<?php } ?>

	<button type="button" class="btn btn-primary btn-sm search_module_button">
		<i class="fas fa-search"></i>&nbsp;ค้นหาหมวดข่าว/บทความ
	</button>
	</div>

	<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
		<div class="btn-group ">
			<button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
			<ul class="dropdown-menu dropdown-menu-right">
				<!--<li><a onClick="boxPopup('<?//=linkboxPopup();?>pop_add_complain_form.php?com_cid=<?//=$com_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?//=$txt_complain_add_cate;?></a></li>-->	
				<li><a href="article_gadd.php?cid=<?php echo $cid;?>" target="_self"> <i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_complain_add_cate;?></a></li>	
				<li><a href="article_new.php?cid=<?php echo $cid;?>" target="_self"> <i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_article_add;?></a></li>							
				<li><a href="javascript:void(0);" class="search_module_button"><i class="fas fa-search"></i>&nbsp;ค้นหาหมวดข่าว/บทความ</a></li>
			</ul>
		</div>
	</div>	

	</div>
	

	</div>

</div>
<!--END card-header -->

	<div class="card-body">
		<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
		<div class="row ">
			<!--<div class="clearfix">&nbsp;</div>-->
			<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

				<div class="table-responsive"	style="overflow: visible;">	  
					<table width="100%" border="0"  align="center" class="table table-bordered">
						<form name="form1" method="post" action="article_function.php">
							<input type="hidden" name="Flag" value="DelGroup">
							<input type="hidden" name="backto" value="article_search.php?<?php echo $search_pagin."page=".$page; ?>">
							<thead>
								<tr class="success">
									<th width="5%" class="text-center"><?php echo $txt_ewt_space;?></th>
									<th width="50%" class="text-center"><?php echo $txt_article_group_name; ?></th>
									<!--<th width="10%" class="text-center">เรียงลำดับ</th>-->
									<!-- <th width="10%" class="text-center"><?php echo $txt_ewt_multilang; ?></th> -->
									<th width="10%" class="text-center">สถานะเผยแพร่เอกสาร</th>
									<th width="10%" class="text-center"<?php echo $disabled2;?>><?php echo $txt_article_rss; ?><a href="#help_01">*</a><br></th>
									<th width="10%" class="text-center"<?php echo $disabled1;?>><?php echo $txt_article_delete_group;?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								if($a_rows_group > 0){
								$i = 0;
								$block_edit = "Y";
								if($db->check_permission("Ag","w","0") || $db->check_permission("Ag","a","0") ){ 
									$group_pass = 'Y';
								}
									
								while($G = $db->db_fetch_array($group_sql)){ 
									if(($db->check_permission("Ag","w",$G['c_id']) || $db->check_permission("Ag","a",$G['c_id']) )  ||   $group_pass == 'Y' ){
									if($db->check_permission("Ag","w",$G['c_id'])){
										$group_pass_w='Y';
										}else{
											$group_pass_w='';
											}
									//if(  $db->check_permission("Ag","",$G['c_id']) ){ 	 
									$S_count = $db->query("SELECT COUNT(n_id) FROM article_list WHERE n_approve != 'D' AND c_id = '{$G['c_id']}' "); 
									$C = $db->db_fetch_row($S_count);
											
										if($G['c_rss']=='Y'){
											$checked= "checked";
											$filename="../ewt/".$_SESSION["EWT_SUSER"]."/rss/group".$G['c_id'].".xml";
											
											if(file_exists($filename)){			 
												$link ='<a href="../ewt/'.$_SESSION["EWT_SUSER"].'/rss/group'.$G['c_id'].'.xml" target="_blank">';
												$link .='<button type="button" class="btn btn-default  btn-circle  btn-xs color-ewt" data-toggle="tooltip" data-placement="top" title="'.$txt_article_rss.'" ><i class="fas fa-rss-square" aria-hidden="true"></i></button>';
												$link .='</a>';
											}else{
												$link='';
											}
											
										}else{
											$checked=''; 
											$link='';
										}

										if($G['c_show_document']=='Y'){
											$chkdocument = "checked";
										}else{
											$chkdocument = "";
										}
								?>
								<tr class="productCategoryLevel1-td"> 
									<td class="text-center">
										<nobr>
										<!-- <a href="article_group.php?cid=<?php echo $G['c_id'];?>" >
										<button type="button" class="btn btn-primary  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_article_group_sub;?>" >
										<i class="fas fa-folder-plus text-white" aria-hidden="true"></i>
										</button>
										</a>  -->

										<a href="article_list.php?cid=<?php echo $G['c_id'];?>">
										<button type="button" class="btn btn-success btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_article_view_list;?>" >
										<i class="fa fa-th-list" aria-hidden="true"></i>
										</button>
										</a> 

										<?php if($group_pass_w == 'Y'){ ?>

										<a href="article_gedit.php?cid=<?php echo $G['c_id'];?>" >
										<button type="button" class="btn btn-warning  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_article_edit_group;?>" >
										<i class="fa fa-edit" aria-hidden="true"></i>
										</button>
										</a> 


										<!-- <a onClick="txt_group_data('<?php echo $G['c_id'];?>','')" >
										<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $G['c_id'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang;?>" >
										<i class="fa fa-language" aria-hidden="true"></i>
										</button>
										</a> -->
										<?php }  ?>


										<?php echo $link;?>

										</nobr>
									</td>
									<td class="text-left"> 
										<h5>
										<i class="fas fa-folder"></i> 
										<a href="article_group.php?cid=<?php echo $G['c_id'];?>" >
											<?php echo $G['c_name']; ?>
										
										<?php
										$article_subnew_array["detail"] = array();
										$article_subnew_array["list"]   = array();
										$this_breadcrumb                = find_sub_group($G['c_id']);

										$totalsubgroup = count($this_breadcrumb["list"]);
										array_push($this_breadcrumb["list"],$G['c_id']);
										$this_line     = "'".implode("','",$this_breadcrumb["list"])."'";
										
										$allnews_data  = $db->query("SELECT COUNT(n_id) AS total_allnews FROM article_list WHERE c_id IN ($this_line)");
										$allnews_info  = $db->db_fetch_array($allnews_data);
										
										?>
										[<b><?php echo number_format($totalsubgroup); ?></b> กลุ่ม 
										<b><?php echo number_format($allnews_info["total_allnews"]); ?></b> บทความ] 
										</a>
										</h5>
										<!--<font color="#666666">[<?php //$numfolder = countchild($G['c_id']); echo number_format($numfolder,0); ?> กลุ่ม   <?php //echo number_format($C[0] + countchild2($G['c_id']),0); ?> บทความ]</font>-->
									</td>

									<!--<td class="text-center" >
									<?php 
									/*if($G['d_id']>0){
										echo $G['d_id'];
										}*/
										?>
									</td>-->

									<!-- <td class="text-center" >
										<?php 
										if($group_pass_w=='Y'){   
											echo show_icon_lang($G['c_id'],'article_group');
											}
										?>
									</td> -->

									<td class="text-center"> 
									<?php if($group_pass_w=='Y'){ ?>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="chkdocument<?php echo $i; ?>" id="chkdocument<?php echo $i; ?>" value="<?php echo $G['c_id']; ?>" <?php echo $chkdocument;?> /> 
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
									<input name="chkdocumentH<?php echo $i;?>" type="hidden" id="chkdocumentH<?php echo $i;?>" value="<?php echo $G['c_id']; ?>" /> 
									<?php } ?>  
									</td>

									<td class="text-center"> 
										<?php if($group_pass_w=='Y'){ ?>
										<div class="checkbox">
												<label>
													<input name="chkrss<?php echo $i;?>" type="checkbox" id="chkrss<?php echo $i;?>" value="<?php echo $G['c_id']; ?>" <?php echo $checked;?> /> 
													<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
												</label>
										</div>
										<input name="chkrssH<?php echo $i;?>" type="hidden" id="chkrssH<?php echo $i;?>" value="<?php echo $G['c_id']; ?>" /> 
										<?php } ?>      
									</td>

									<td class="text-center" <?php echo $disabled1;?>> 
										<?php 
										if($group_pass_w=='Y'){ 
											$block_edit = "Y"; 
										?>
										<div class="checkbox">
												<label>
													<input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $G['c_id']; ?>" <?php  if($numfolder > 0){ echo "disabled"; } ?> /> 
													<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
												</label>
										</div>
										<?php } ?>      
									</td>
								</tr>

								<?php
								$i++; 
								}
									}
								?>
							</tbody>
							<tfoot>
								<tr class="ui-state-default" > 
								<td colspan="2" valign="top">&nbsp;<a id="#bottom"></a></td>
								<td class="text-center" <?php echo $disabled2;?>>
								<?php if($block_edit == "Y"){ ?> 
									<button type="button" class="btn btn-success btn-ml " onClick="document.form1.Flag.value='SetDocument'; document.form1.submit();" >
									<i class="fas fa-cog"></i>&nbsp;Setting
									</button>
								<?php } ?>      		
								</td>
								<td class="text-center" <?php echo $disabled2;?>>
								<?php if($block_edit == "Y"){ ?>
										<!--<input name="button" type="button" onClick="document.form1.Flag.value='SetRSS'; document.form1.submit();" value="ตั้งค่า"  class="btn btn-success btn-ml">-->       
										<button type="button" class="btn btn-success  btn-ml " onClick="document.form1.Flag.value='SetRSS'; document.form1.submit();" >
										<i class="fas fa-cog"></i>&nbsp;<?php echo $txt_article_btn_set_rss;?>
										</button>
										<?php } ?>      		
								</td>

								<td class="text-center" <?php echo $disabled1;?>>
										<?php if($block_edit == "Y"){ ?>	
										<button type="button" class="btn btn-danger  btn-ml " onClick="if(confirm('Are you sure to delete selected group?')){ form1.submit(); }" >
										<i class="far fa-trash-alt"></i>&nbsp;<?php echo $txt_article_btn_del_group;?>
										</button>
										<!--<input type="button" name="Button" value="ลบกลุ่ม" onClick="if(confirm('Are you sure to delete selected group?')){ form1.submit(); }" class="btn btn-danger">-->
										
									<?php } ?>    
								</tr>
								<tr class="ui-state-default" > 
								<td colspan="2" valign="top"><span class="ewtnormal"><a name="help_01"></a>*  เลือก RSS เป็นการกำหนดให้ข่าวกลุ่มนั้นมีการส่งออกเป็นไฟล์ XML ตามมาตรฐาน  RSS ได้</span></td>
									<td align="center"  <?php echo $disabled2;?>>&nbsp;</td>
									<td align="center"  <?php echo $disabled1;?>>&nbsp;</td>
								</tr>
								<input name="alli" type="hidden" id="alli" value="<?php echo $i;?>">
							</tfoot>
							<?php 
							}
							else{
							?>
							<tr class="ui-state-default" > 
								<td colspan="5" class="text-center">
									<h4 >
									<p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
									</h4>
								</td>
							</tr>
							<?php	}  ?>
						</form>
					</tbody>
				</table>

				<div class="table-responsive" id="frm_edit_s">	  
					<table width="100%" border="0"  align="center" class="table table-bordered" >
						<form name="form2" method="post" action="article_function.php">
							<input type="hidden" name="Flag" value="DelArticle">
							<input name="cid" type="hidden" id="cid" value="<?php echo $_GET["cid"]; ?>">	
							<input type="hidden" name="backto" value="article_search.php?<?php echo $search_pagin."page=".$page; ?>">
							<thead> 
								<tr class="info" > 
									<th width="5%" class="text-center">&nbsp;</th>
									<th width="10%" class="text-center">วันที่</th>
									<th width="40%" class="text-center" colspan="2">หัวข้อข่าว/บทความ</th>
									<!-- <th width="10%" class="text-center">ภาษาอื่น</th> -->
									<th width="10%" class="text-center">ผู้สร้าง</th>
									<!--<th width="4%" class="text-center">สร้าง</th>
									<th width="5%" class="text-center">แก้ไข</th>-->
									<?php /*<th width="5%" class="text-center">Share</th>*/ ?>
									<th width="5%" class="text-center">อนุมัติ</th>
									<th width="5%" class="text-center">ลบ</th>
								</tr>
							</thead>
							<?php
								$i = 0;
								$rows = $db->db_num_rows($article_sql);
								$nu = $rows-$offset;
									
							while($N = $db->db_fetch_array($article_sql)){ 


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
								$sql_chk = "SELECT name_thai,surname_thai FROM `gen_user` where  gen_user_id ='".$N["n_owner"]."'  ";
								$query = $db->query($sql_chk);
								$rec = $db->db_fetch_array($query);
								$db->query("USE ".$EWT_DB_NAME);
								$owner = $rec['name_thai'].'   '.$rec['surname_thai'];
								}
								$group_text = "";
								
								$sql_gname = $db->query("SELECT c_name FROM article_group WHERE c_id = '".$N["c_id"]."' ");
								$GN = $db->db_fetch_row($sql_gname);
								$group_text = "<div><a href=\"article_list.php?cid=".$N["c_id"]."\"><img src=\"../theme/main_theme/g_folder_closed.gif\" alt=\"news folder\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\"> ".$GN[0]."</a></div>";
		
								$article_pass_w='';

								$y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
								
								if($db->check_permission("Ag","w","0") or $db->check_permission("Ag","w",$N["c_id"]) ){
									$article_pass_w='Y';
								}
								else{
									if(countparent($N["c_id"],"w")>0){
										$article_pass_w='Y';
									}
								}
								
								$article_pass_a='';
									$y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
										if($db->check_permission("Ag","a","0") or $db->check_permission("Ag","a",$N['c_id']) ){
											$article_pass_a='Y';
										}else{
										if(countparent($N['c_id'],"a")>0){
												$article_pass_a='Y';
										}
										}
									
								## >> Only super admin and article owner can edit the article
								if($article_pass_w == "Y" AND $N['n_owner'] != $_SESSION['EWT_SMID']){
									$article_pass_w='';
								}
								if($_SESSION['EWT_SMTYPE'] == "Y"){
									$article_pass_w = "Y";
								}

								## >> Only super admin and article owner can approve the article
								if($article_pass_a == "Y" AND $N['n_owner'] != $_SESSION['EWT_SMID']){
									$article_pass_a='';
								}
								if($_SESSION['EWT_SMTYPE'] == "Y"){
									$article_pass_a = "Y";
								}
								
								?>
							<tr bgcolor="#FFFFFF" > 
								<td height="20" align="center" valign="top" nowrap>
									<?php
									$path_news="";
									if($N['news_use'] == "2" OR $N['news_use'] == "3" OR $N['news_use'] == "4"){
											$path_news= "../ewt/".$_SESSION['EWT_SUSER']."/article-views-backend.php?nid=".$N['n_id']."&lang=TH" ;
									}else{

										$url_array = array("http://","https://");
										$is_outsidelink = "N";

										## >> Check link from outside
										foreach($url_array AS $url_e){
											$check_link = (string)strpos($N['link_html'],$url_e);
											if($check_link=="0"){
												$is_outsidelink = "Y";
											}
										}

										if($is_outsidelink == "Y"){
											$path_news= $N["link_html"];
										}
										else{
											$path_news= "../ewt/".$_SESSION['EWT_SUSER']."/".$N['link_html'];
										}
									}
									?>	

									<!--<a href="#view" onClick="window.open('<?php //echo $path_news;?>');">
									<img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" align="absmiddle" alt="ดูข้อมูล">
									</a>-->
									<a href="#view" onClick="window.open('<?php echo $path_news;?>');" >
									<button type="button" class="btn btn-success  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo "ดูข้อมูล";?>" >
									<i class="fas fa-search" aria-hidden="true"></i>
									</button>
									</a> 

									<?php if($article_pass_w=='Y'){ ?>
										
										<!--<a href="#set" onClick="txt_article_data3('<?//=$N["n_id"]; ?>','')">
										<img id="lang<?php //echo $N["n_id"]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0">
										</a>-->
										
										<!-- <a onClick="txt_article_data3('<?php echo $N['n_id'];?>','')" >
										<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $N['n_id'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang?>" >
										<i class="fa fa-language" aria-hidden="true"></i>
										</button>
										</a> -->
											<!--<a href="##P" title="เพิ่ม Tool Tips"  onClick="window.open('content_tooltips.php?type=a&filename=<?php echo $N["n_id"]; ?>','','height=600,width=780,scrollbars=1,resizable=1');">
											<img src="../images/help.gif" alt="เพิ่ม Tool Tips" width="16" height="16" align="absmiddle" border="0">
											</a>-->	
										<a href="article_edit.php?nid=<?php echo $N['n_id']; ?>&cid=<?php echo $N['c_id']; ?>">
										<button type="button" class="btn btn-warning  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_article_edit;?>" >
										<i class="fa fa-edit" aria-hidden="true"></i>
										</button>
										</a> 
										
									<?php } ?>	
								</td>

								<td class="text-center"><?php echo $date[2]."/".$date[1]."/".$date[0]; ?></td>
								<td class="text-left" colspan="2"> 

									<!--<img src="../theme/main_theme/g_document.gif" alt="News" width="16" height="16" align="absmiddle">-->
									<?php if($N["n_shareuse"] != "Y"){ ?>
										<?php if($article_pass_w=='Y'){ ?> 
												<?php /*<a href="#article" onClick="self.location.href='article_edit.php?nid=<?php echo $N["n_id"]; ?>&cid=<?php echo $_GET["cid"]; ?>';"  > */ ?>
										<?php }?>
										<?php echo $N["n_topic"]; ?> 
										<?php if($article_pass_w=='Y'){ ?>
										<?php /*</a>*/ ?>
									<?php }?>
									<?php  }else{ ?>
									<img src="../images/share.gif" width="20" height="20" border="0" align="absmiddle"> 
									<?php echo $N["n_topic"]; ?> [From:<?php echo $N["n_sharename"]; ?>] 
									<?php } ?>
									<?php echo  $group_text; ?>
								</td>
								<!-- <td class="text-center" >
									<?php if($article_pass_w=='Y'){ echo show_icon_lang2($N["n_id"],'article_list'); }?>
								</td> -->
								<td class="text-center" >
									<span class="label label-success text-small"><?php echo $owner; ?></span>
								</td>
								<!--
								<td class="text-center" ><?//=$date_create_f;?></td>
								<td class="text-center" ><?//=$date_modi_f; ?></td>-->

								<?php /*
								<td class="text-center" > 
									<?php if($article_pass_w=='Y'){ ?>

									<?php if($N['n_share'] != "Y" AND $N['n_shareuse'] != "Y"){ ?>
									<div class="checkbox">
									<label>
									<input name="share<?php echo $i; ?>" type="checkbox" id="share<?php echo $i; ?>"  value="<?php echo $N['n_id'];?>" /> 
									<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
									</label>
									</div>
									<?php } ?>   

									<?php if($N['n_share'] == "Y"){ ?>
									<a href="#change" onClick="win2=window.open('article_share_news.php?nid=<?php echo $N['n_id']; ?>','change','width=400,height=500,resizable=1,scrollbars=1');"><img src="../images/bar_share.gif" width="20" height="20" border="0"></a> 
									<?php } ?>
									<?php if($N['n_shareuse'] == "Y"){ ?>
									<img src="../images/share.gif" width="20" height="20" border="0" /> 
									<?php 
									} 
										}
									?>      
								</td>
								*/ ?>
								<td class="text-center"  > 
									<?php 

									if($article_pass_a=='Y'){ ?>       
									<div class="checkbox">
										<label>
											<input name="app<?php echo $i; ?>" type="checkbox" id="app<?php echo $i; ?>"  value="Y" <?php if($N['n_approve'] == "Y"){ echo "checked"; } ?>  /> 
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
									<input name="nid<?php echo $i; ?>" type="hidden" id="nid<?php echo $i; ?>" value="<?php echo $N["n_id"]; ?>"> 

									<?php
										$block_approve = "Y"; 
										$count_approvable++;
									}
									else{
									if($N["n_approve"] == "Y"){ 
										echo "<img src=\"../theme/main_theme/g_approve.gif\"  border=\"0\" align=\"absmiddle\" alt=\"อนุมัติแล้ว\">"; }
									} 
									?>      
								</td>
								<td align="center" valign="top">   
									<?php if($article_pass_w=='Y'){ ?>
									<div class="checkbox">
										<label>
											<input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $N['n_id']; ?>"  /> 
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
									<?php  $block_edit = "Y";
									} 
									?>
								</td>
							</tr>
							<?php $i++;$nu--; 
							}
							?>
								<input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
							<tr bgcolor="#FFFFFF"> 
								<td height="30" colspan="5">&nbsp;</td>

								<?php /*
								<td class="text-center" >
									<?php if($block_edit=="Y"){ ?>
									<button type="button" class="btn btn-info  btn-ml " onClick="sharing();" >
									<i class="fas fa-share-alt-square fa-1x"></i>&nbsp;<?php echo "Share";?>
									</button>
									<?php }?>
								</td> */ ?>

								<td class="text-center" >
								<?php 
								//if($block_approve=="Y"){ 
								if($count_approvable>0){	
								?>
								<button type="button" class="btn btn-success  btn-ml " onClick="document.form2.Flag.value='AppArticle';form2.submit();" >
								<i class="far fa-check-circle fa-1x"></i>&nbsp;<?php echo "อนุมัติ";?>
								</button>
								<?php }?>
								</td>
								<td class="text-center" >
								<?php if($block_edit=="Y"){ ?>
								<button type="submit" class="btn btn-danger  btn-ml " onClick="return confirm('Are you sure to delete selected article?');" >
								<i class="fas fa-trash-alt fa-1x"></i>&nbsp;<?php echo "ลบข่าว";?>
								</button>

								<?php } ?>
								</td>	
							</tr>

						</form>
					</table>
				</div>
			</div>
		</div>

		<?php echo pagination_ewt($statement,$perpage,$page,'?'.$search_pagin);?>	

		</div>
	</div>

</div>
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<script>

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

function JQSet_lang_list(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'เพิ่มข่าว/บทความภาษาอื่นๆ',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: method,
											url: action,					
											data: formData ? formData : form.serialize(),
											async: true,
											processData: false,
											contentType: false,
											success: function (data) {												
												console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													action: function () {	
																location.reload(true);
																}
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}

function JQSet_lang_group(form){	

var fail = CKSubmitData(form);

if (fail == false) {	 
var action  = form.attr('action'); 
//alert(form.serialize());															
			 $.confirm({
						title: 'เพิ่มกลุ่มข่าว/บทความภาษาอื่นๆ',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: action,					
											data: form.serialize(),
											success: function (data) {
												console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													action: function () {	
																location.reload(true);
																}
												});
												
												//$("#frm_edit_s1").load(location.href + " #frm_edit_s1");
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												$('#box_popup').fadeOut();
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}


function txt_group_data(w,g) {	
	$.ajax({
      type: 'GET',
      url: 'pop_set_lang.php?gid='+g+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}
		
    }); 
	
$('#box_popup').fadeIn();		
}

function txt_group_data1(w,g,lang) {
	$.ajax({
      type: 'GET',
      url: 'article_multilang_group.php?langid='+g+'&lang='+lang+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}
		
    }); 
	
$('#box_popup').fadeIn();	
	 //window.location.href='../multilangMgt/article_group.php?langid='+g+'&lang='+lang+'&id='+ w;
}





function sharing(){
	document.form2.Flag.value = "Share";
	form2.action = "article_share.php";
	form2.submit();
}

function txt_article_data(w,g) {	
	$.ajax({
		type: 'GET',
		url: 'pop_set_lang.php?gid='+g+'&id='+w,
		beforeSend: function() {
			$('#box_popup').html('');
		},
			success: function (data) {
				$('#box_popup').html(data);
			}
			
		}); 
		
	$('#box_popup').fadeIn();	
	
}
function txt_article_data1(w,g,lang) {
	$.ajax({
      type: 'GET',
      url: 'article_multilang_group.php?langid='+g+'&lang='+lang+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}
		
    }); 	
	$('#box_popup').fadeIn();	
	 //window.location.href='../multilangMgt/article_group.php?langid='+g+'&lang='+lang+'&id='+ w;
}
function txt_article_data2(w,g,lang) {
	$.ajax({
      type: 'GET',
      url: 'article_multilang_list.php?langid='+g+'&lang='+lang+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}
		
    }); 
	
$('#box_popup').fadeIn();	
	 //window.location.href='../multilangMgt/article_list.php?langid='+g+'&lang='+lang+'&id='+ w;
}
function txt_article_data3(w,g) {	
	$.ajax({
      type: 'GET',
      url: 'pop_set_lang_list.php?gid='+g+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}
		
    }); 
	
$('#box_popup').fadeIn();	
	
}
</script>

<?php
## >> Include search modal

$search_button_class = "search_module_button";
$search_title        = "ค้นหา";
$search_action       = "../ArticleMgt/article_search.php";
$search_parameter    = array(array("name"=>"search_word",
								   "type"=>"text",
								   "label"=>"คำค้น"));

include "../include/module_search.php";
?>