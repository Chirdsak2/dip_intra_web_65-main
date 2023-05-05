<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

## >> Get subgroup id

		/*if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}*/
		$_SESSION["EWT_OPEN_ARTICLE"] = "";

$cid = (int)(!isset($_GET['cid']) ? '' : $_GET['cid']);
		
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

function getArticleSub($c_id)
{
	global $db;
	$wh = "";
	$s_cid = array();
	array_push($s_cid, $c_id);

	if ($c_id) {
		$wh .= " AND c_parent = '$c_id'";
	}

	$_sql_sub = "SELECT c_id FROM article_group WHERE c_show_document = 'Y' {$wh}";
	while ($a_data_sub = $db->db_fetch_array($_sql_sub)) {
		array_push($s_cid, $a_data_sub['c_id']);
	}

	return implode(",", array_unique($s_cid));
}

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


/*if($db->check_permission($ptype,$ppms,"0")){
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
}*/


$sql_search = '';

$search_pagin = "";

if($_GET['cid'] != ""){
	$sql_search .= " AND c_parent = '{$_GET['cid']}' ";
}

if($_GET["search"]=="Y"){
	
	$search_pagin .= "search=Y&";

	$articlegroup_name = trim($_GET['articlegroup_name']);
	$search_pagin .= "article_group=".ready($_GET["article_group"])."&";

	if($articlegroup_name != ""){
		$find = ready($articlegroup_name);
		$sql_search .= " AND c_name LIKE '%$find%' ";
	}
}
else{
	$search_pagin = "&";
}
	
if(empty($sql_search)){
if($db->check_permission($ptype,$ppms,"0")){
$wh = "WHERE c_parent = '0'";
$sql_article = "SELECT * FROM article_group {$wh} {$sql_search} ";	
}else{
$wh = $sql_text;
$sql_article = "SELECT * FROM article_group {$wh} {$sql_search} ";
}
	}else{
		$wh = "WHERE c_id != '0'";
		$sql_article = "SELECT * FROM article_group {$wh} {$sql_search} ";	
		}
		
$db->query("USE ".$EWT_DB_NAME);

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query($sql_article." ORDER BY c_order ASC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(c_id) AS b
			  FROM article_group
			  {$wh} {$sql_search}";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);

$sql_xml = $db->query("SELECT * FROM article_list WHERE c_id = '{$_GET['cid']}'");
?>


<div id="nav" style="position:absolute;width:400px;z-index:1;display:none"></div>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo $txt_article_group;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
	<div class="col-md-12 col-sm-12 col-xs-12" >
		<ol class="breadcrumb">
			<li><a href="article_group.php"><?php echo $txt_article_group;?></a></li>
			<?php echo article_group_parent($cid);?>
		</ol>
	</div>

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
<table width="100%" border="0"  align="center" class="table table-bordered " id="sortableLv1">
<form name="form1" method="post" action="article_function.php">
<input type="hidden" name="Flag" value="DelGroup">
<thead>
<tr class="success">
    <th width="5%" class="text-center"><?php echo $txt_ewt_space;?></th>
    <th class="text-center" colspan="2"><?php echo $txt_article_group_name; ?></th>
	<!--<th width="10%" class="text-center">เรียงลำดับ</th>-->
    <!-- <th width="10%" class="text-center"><?php echo $txt_ewt_multilang; ?></th> -->
	<th class="text-center">หมวดย่อย</th>
	<th class="text-center">บทความ</th>
	<th class="text-center">สถานะเผยแพร่เอกสาร</th>
    <th class="text-center"<?php echo $disabled2;?>><?php echo $txt_article_rss; ?><a href="#help_01">*</a><br></th>
    <th class="text-center"<?php echo $disabled1;?>><?php echo $txt_article_delete_group;?></th>
</tr>
</thead>
<tbody>
<?php
if($a_rows){
$i = 0;
$block_edit = "Y";
if($db->check_permission("Ag","w","0") || $db->check_permission("Ag","a","0") ){ 
	$pass = 'Y';
}
	
while($G = $db->db_fetch_array($_sql)){ 
	 if(($db->check_permission("Ag","w",$G['c_id']) || $db->check_permission("Ag","a",$G['c_id']) )  ||   $pass == 'Y' ){
	 	if($db->check_permission("Ag","w",$G['c_id'])){
		 	$pass_w='Y';
		}else{
			$pass_w='';
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
<tr class="productCategoryLevel1-td move"  id="<?php echo $G['c_id'];?>"> 
<td class="text-center">
<nobr>
<!-- <a href="article_group.php?cid=<?php echo $G['c_id'];?>" >
<button type="button" class="btn btn-primary  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_article_group_sub;?>" >
<i class="fas fa-folder-plus text-white" aria-hidden="true"></i>
</button>
</a> 

<a href="article_list.php?cid=<?php echo $G['c_id'];?>">
<button type="button" class="btn btn-success btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_article_view_list;?>" >
<i class="fa fa-th-list" aria-hidden="true"></i>
</button>
</a>  -->

<?php if($pass_w == 'Y'){ ?>

<a href="article_gedit.php?cid=<?php echo $G['c_id'];?>" >
<button type="button" class="btn btn-warning  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_article_edit_group;?>" >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a> 


<!-- <a onClick="txt_data('<?php echo $G['c_id'];?>','')" >
<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $G['c_id'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang;?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a> -->
<?php }  ?>


<?php echo $link;?>

</nobr>
</td>

<td class="text-left" colspan="2"> 
<input class="input-inline-sm text-center" name="category_order[]" id="category_order<?php echo $G['c_order'];?>"  type="text" value="<?php echo $G['c_order'];?>" readonly />
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?php echo $G['c_order'];?>" value="<?php echo $a_data['c_order'];?>">

	<i class="fas fa-folder"></i> 
	<a href="article_list.php?cid=<?php echo $G['c_id'];?>">
	<!--<a href="article_group.php?cid=<?php echo $G['c_id'];?>" >-->
		<?php echo $G['c_name']; ?>
		<?php
		$article_subnew_array["detail"] = array();
		$article_subnew_array["list"]   = array();
		$this_breadcrumb                = find_sub_group($G['c_id']);

		$totalsubgroup = count($this_breadcrumb["list"]);
		array_push($this_breadcrumb["list"],$G['c_id']);
		$this_line     = "'".implode("','",$this_breadcrumb["list"])."'";
		
		$allnews_data  = $db->query("SELECT COUNT(n_id) AS total_allnews FROM article_list WHERE c_id IN ($this_line) AND n_approve = 'Y' AND n_approve != 'D'");
		$allnews_info  = $db->db_fetch_array($allnews_data);
		?>
		<!-- [<b><?php echo number_format($totalsubgroup); ?></b> กลุ่ม 
		 <b><?php echo number_format($allnews_info["total_allnews"]); ?></b> บทความ] -->
	</a> 

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
if($pass_w=='Y'){   
	echo show_icon_lang($G['c_id'],'article_group');
	}
 ?>
</td> -->

<td class="text-center"> 
<a href="article_group.php?cid=<?php echo $G['c_id'];?>" >
<b><?php echo number_format($totalsubgroup); ?></b> กลุ่ม 
</a>

</td>

<td class="text-center">
<a href="article_list.php?cid=<?php echo $G['c_id'];?>">
<b><?php echo number_format($allnews_info["total_allnews"]); ?></b> บทความ
</a>
</td>

<td class="text-center"> 
<?php if($pass_w=='Y'){ ?>
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
<?php if($pass_w=='Y'){ ?>
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
if($pass_w=='Y'){ 
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
<td colspan="5" valign="top">&nbsp;<a id="#bottom"></a></td>
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
<td colspan="3" valign="top"><span class="ewtnormal"><a name="help_01"></a>*  เลือก RSS เป็นการกำหนดให้ข่าวกลุ่มนั้นมีการส่งออกเป็นไฟล์ XML ตามมาตรฐาน  RSS ได้</span></td>
      <td align="center"  <?php echo $disabled2;?>>&nbsp;</td>
      <td align="center"  <?php echo $disabled1;?>>&nbsp;</td>
</tr>
<input type="hidden" name="alli" id="alli" value="<?php echo $i;?>">
</tfoot>
<?php 
}else{
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
</div>
</div>
<?//=pagination($statement,$per_page,$page,$url='?');?>
<?php echo pagination_ewt($statement,$perpage,$page,'?cid='.$_GET['cid'].$search_pagin);?>	

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
$(function  () {
	$("table tbody").sortable({
	placeholder: 'drop-placeholder-td',
	update: function (event) {									
		var page_id_array = new Array();
			$('#sortableLv1 tr').each(function(){
				page_id_array.push($(this).attr("id"));
			});		
			
			console.log(page_id_array);			
									$.ajax({
											type: 'POST',
											url: 'func_sortable_article_group.php',											
											data:{proc:'Sortable_Edit',page_id_array:page_id_array,start:'<?php echo $start;?>'},
											success: function (data) {												
												console.log(data);	
												location.reload(true);																							
												//$("#frm_edit_s").load(location.href + " #frm_load");												
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												//document.location.reload();
											}
										});	
										
		}	
	});
});

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


function txt_data(w,g) {	
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

function txt_data1(w,g,lang) {
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