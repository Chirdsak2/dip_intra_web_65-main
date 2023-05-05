<?php
include("../EWT_ADMIN/comtop.php");
$db->query("USE ".$EWT_DB_USER);
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

//$com_fid = (int)(!isset($_GET['com_fid']) ? '' : $_GET['com_fid']);

$mid = get('mid','');
$mtype = get('mtype','');
$UID = $_SESSION['EWT_SUID'];

function random_to($len){
			srand((double)microtime()*10000000);
			$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
			$ret_str = "";
			$num = strlen($chars);
			for($i=0;$i<$len;$i++){
				$ret_str .= $chars[rand()%$num];
			}
			return $ret_str;
	}
	
$myFlag = random_to(20);
	
function level_name($L,$id){
	global $db;
		if($L == "A"){
			//echo "<img src=\"../images/user_a.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT emp_type_name FROM emp_type WHERE emp_type_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "D"){
			//echo "<img src=\"../images/user_group.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_org FROM org_name WHERE org_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "L"){
			//echo "<img src=\"../images/user_c.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT ul_name FROM user_level WHERE ul_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "P"){
			//echo "<img src=\"../images/user_pos.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT position_name.pos_name FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.up_id = '".$id."' ORDER BY user_position.up_rank ASC ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "U"){
			//echo "<img src=\"../images/user_logo.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_thai,surname_thai,gen_user FROM gen_user WHERE gen_user_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0]." ".$R[1]." (".$R[2].")";
		}
	}
	



$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

/*$_sql = $db->query("SELECT *
					FROM m_complain_form_element 
					INNER JOIN m_complain_form_item ON (m_complain_form_item.com_item_id = m_complain_form_element.com_ele_id)
					WHERE com_ele_fid = '{$com_fid}' {$wh} 
					ORDER BY com_ele_order ASC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(com_ele_id) AS b
			  FROM m_complain_form_element 
			  WHERE com_ele_fid = '{$com_fid}' {$wh}  ";
			  
	
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
$db->query("USE ".$EWT_DB_USER);*/

$_sql = $db->query("SELECT *
					FROM permission 
					WHERE pu_id = '{$mid}' AND p_type = '{$mtype}'  AND UID = '{$UID}' AND s_id = '0' AND s_name = ''
					ORDER BY p_id ASC ");
$a_rows = $db->db_num_rows($_sql);	
?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?=$txt_permission_set;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="permission_user.php"><?=$txt_permission_menu_user;?></a></li>
<li class=""><?=$txt_permission_set;?></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a href="permission_user.php" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
</button>
</a>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            			<li><a href="permission_user.php" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?></a></li>
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
<div class="row ">

<div class="col-md-8 col-sm-8 col-xs-8 m-b-sm"  >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<div class="card-title text-left color-white">
<i class="fas fa-user-cog color-white fa-1x" aria-hidden="true"></i>
<?=level_name($mtype,$mid);?> 
</div>
</div>
<div class="card-body m-b-sm">
<div class="scrollbar scrollbar-near-moon thin">
<input type="hidden" name="mid" id="mid" value="<?php echo $mid; ?>">
<input type="hidden" name="UID" id="UID" value="<?php echo $UID; ?>">
<input type="hidden" name="mtype" id="mtype" value="<?php echo $mtype; ?>">
<input name="Flag" type="hidden" id="Flag" value="SaveAndExit">
<input type="hidden" name="myFlag" value="<?php echo $myFlag; ?>">

<ul id="sortableLv1-form" class="sortableLv1 connectedSortable " style="width: 100%;">
<li class="productCategoryLevel1 bg-info ui-state-disabled text-center " id="0" >
<b>เลือก Module ด้านขวา</b>
</li>
<?php
//$db->query("USE ".$EWT_DB_NAME);
if($a_rows > 0){
$i = 0;
$s_data = array();
while($a_data = $db->db_fetch_array($_sql)){
if($a_data['s_type'] == 'suser'){	
	array_push($s_data,$a_data['s_type']); 
	}else{
		array_push($s_data,$a_data['s_type']."#".$a_data['s_permission']); 
	}

$_sql_item = $db->query("SELECT *
					FROM web_permission
					LEFT JOIN web_module_ewt ON web_module_ewt.m_code = web_permission.p_code
					WHERE web_permission.p_status = 'Y' 
					AND web_module_ewt.m_status = 'Y' 
					AND web_permission.p_code = '{$a_data['s_type']}' 
					AND p_type = '{$a_data['s_permission']}'
					");										
$a_data_item = $db->db_fetch_array($_sql_item);	
	
if($a_data['s_type'] == 'suser'){	
?>	
<li class="productCategoryLevel1 move" >
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?=$a_data['p_id'];?>" value="<?=$a_data['p_id'];?>">
<i class="fas fa-user-cog text-medium text-dark "></i>
&nbsp;<b>Super Admin</b>

<!--<div class="iconAction1">
&nbsp;
<button type="button" class="btn btn-default btn-circle btn-sm " onClick="boxPopup('<?=linkboxPopup();?>pop_setting_item.php?com_eid=<?=$a_data['com_ele_id'];?>&com_fid=<?=$com_fid;?>');" data-toggle="tooltip" data-placement="top" title="<?=$txt_complain_setting;?>">
<i class="fas fa-cogs" aria-hidden="true"></i>
</button>
&nbsp;
</div>-->
</li>

<?php }else{
if($a_data['s_type'] != 'Ag'){
?>

<li class="productCategoryLevel1 ui-state-disabled"  >
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?=$a_data['p_id'];?>" value="<?=$a_data['p_id'];?>">
<i class="far fa-check-circle text-success"></i>
<img src="<?=$IMG_PATH;?><?=$a_data_item['m_image'];?>" class="img-responsive " style="display:inline;margin: 0 1px;width:24px;height:24px;" />
&nbsp;<?=$a_data_item['m_name'];?> (<?=$a_data_item['p_name'];?>)

<div class="iconAction1" style="">
&nbsp;
<!--<button type="button" class="btn btn-default btn-circle btn-sm " onClick="boxPopup('<?=linkboxPopup();?>pop_setting_item.php?com_eid=<?=$a_data['com_ele_id'];?>&com_fid=<?=$com_fid;?>');" data-toggle="tooltip" data-placement="top" title="<?=$txt_complain_setting;?>">
<i class="fas fa-cogs" aria-hidden="true"></i>
</button>
<a onClick="JQDel_Permission('<?=$a_data['p_id'];?>');" data-toggle="tooltip" data-placement="top" title="<?="ลบ";?> <?=$a_data_item['p_name'];?>"  >
<i class="fas fa-minus-circle text-danger"  aria-hidden="true"></i>
</a>-->
<?php if(!empty($a_data_item['m_permission_link'])){ ?>
<button type="button"  class="btn btn-default btn-circle btn-sm " onClick="boxPopup('<?=linkboxPopup();?>pop_set_admission_user.php?p_id=<?=$a_data['p_id'];?>&s_type=<?=$a_data['s_type'];?>&pu_id=<?=$a_data['pu_id'];?>&p_type=<?=$a_data['s_permission'];?>');" data-toggle="tooltip" data-placement="top" title="<?=$txt_complain_setting;?>">
<i class="fas fa-cogs text-info" aria-hidden="true"></i>
</button>
<?php } ?>
<button type="button"   class="btn btn-default btn-circle btn-sm " onClick="JQDel_Permission('<?=$a_data['p_id'];?>');" data-toggle="tooltip" data-placement="top" title="<?=$txt_permission_del_admission;?> (<?=$a_data_item['p_name'];?>) " >
<i class="fas fa-trash-alt text-danger " aria-hidden="true"></i>
</button>
&nbsp;
</div>

</li>	
<?php } } ?>
<?php $i++;} }else{?>

<li class="productCategoryLevel1 ui-state-disabled text-center "  >
  <p class="text-danger"><?=$txt_ewt_data_not_found;?></p>
</li>

<?php } ?>	

</ul>
</div>
</div>
<div class="card-body m-t-xxl text-right">
<!--<button onclick="boxPopup('<?=linkboxPopup();?>pop_view_form.php?com_fid=<?=$com_fid;?>');" type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?=$txt_ewt_viewform;?>
</button>-->
<button onclick="JQAdd_Permission_User($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>
<div class="col-md-4 col-sm-4 col-xs-4 m-b-sm" > 
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<div class="card-title text-left  color-white">
<i class="fas fa-cogs color-white fa-1x"></i>
Module
</div>
</div>
<div class="card-body">
<div class="scrollbar scrollbar-near-moon thin">
<ul id="sortableLv1" class="sortableLv1 connectedSortable " style="width: 100%;">
<li class="productCategoryLevel1 bg-info ui-state-disabled text-center " id="00" >
<b>Module</b>
</li>
<?php
//print_r($s_data);
$data = implode("','",$s_data);
if($data != 'suser'){
?>
<li class="productCategoryLevel1 bg-success text-left move" id="suser" >
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?=$a_data_item['p_id'];?>" value="<?=$a_data_item['p_id'];?>">
<i class="fas fa-user-cog text-medium text-dark "></i>
&nbsp;<b>Super Admin</b>
</li>
<?php
}				

$_sql_item = $db->query("SELECT *
					FROM web_permission
					LEFT JOIN web_module_ewt ON web_module_ewt.m_code = web_permission.p_code
					WHERE web_permission.p_status = 'Y' AND web_module_ewt.m_status = 'Y'
					ORDER BY web_permission.p_id ASC ");					
$x = 0;					
while($a_data_item = $db->db_fetch_array($_sql_item)){

$_sql = $db->query("SELECT *
					FROM permission 
					WHERE 
					pu_id = '{$mid}' 
					AND p_type = '{$mtype}'  
					AND UID = '{$UID}'
					AND s_type = '{$a_data_item['p_code']}'
					AND s_permission = '{$a_data_item['p_type']}'
					");
$a_rows = $db->db_num_rows($_sql);	
$a_data_permission = $db->db_fetch_array($_sql);	
if(empty($a_rows)){
?>

<li class="productCategoryLevel1 move" id="<?=$a_data_item['p_code'].'#'.$a_data_item['p_type'];?>">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?=$a_data_item['p_id'];?>" value="<?=$a_data_item['p_id'];?>">
<i class="fas fa-ellipsis-v text-medium text-dark"></i>
<img src="<?=$IMG_PATH;?><?=$a_data_item['m_image'];?>" class="img-responsive " style="display:inline;margin: 0 1px;width:24px;height:24px;" />
&nbsp;<?=$a_data_item['m_name'];?> (<?=$a_data_item['p_name'];?>)
</li>

<?php 
}
$x++; } 
?>	

</ul>	
</div>
</div>
</div>
</div>

</div>
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
$db->query("USE ".$EWT_DB_NAME);
include("../EWT_ADMIN/combottom.php");
?>
<script src="../js/mask-input-jquery/docs/jquery.samask-masker.js"></script>                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
<!--
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
-->
</style>

<script>
$(function  () {
	
	$(".sortableLv1").sortable({
	placeholder: 'drop-placeholder',
	connectWith: ".sortableLv1",
	items: "li:not(.ui-state-disabled)",
	update: function (event, ui) {	
	
			var changedList = this.id;
			var order = $(this).sortable('toArray');
			var positions = order.join(',');
			
			var mid = $('#mid').val();
			var UID = $('#UID').val();
			var mtype = $('#mtype').val();

	//console.log(changedList);	
	
if(changedList == 'sortableLv1-form'){
    console.log({
      id: changedList,
      positions: positions
    });
		
									$.ajax({
											type: 'POST',
											url: 'func_sortable_user_builder.php',											
											data:{proc:'Sortable_Edit',page_id_array_form:order,mid:mid,UID:UID,mtype:mtype},
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
		}	
	});
	
        $.samaskHtml();
        $('.phone').samask("(000)000-0000");
        $('.hour').samask("00:00:00");
        $('.date').samask("00/00/0000");
        $('.date_hour').samask("00/00/0000 00:00:00");
        $('.ip_address').samask("000.000.000.000");
        $('.percent').samask("%00");
        $('.mixed').samask("SSS-000");
		$('.number').samask("000");

});

function JQAdd_Permission_User(form){
	
	var fail = CKSubmitData(form);
if (fail == false) {	
	var action  = form.attr('action'); 
	var method  = form.attr('method'); 
	var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?="กำหนดสิทธิ์การใช้งานระบบ";?>',
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
												//console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														self.location.href="permission_user.php";
														//location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="complain_builder.php?com_cid="+data;											
												//$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									//$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
	
}


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

</script>