<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

//$com_fid = (int)(!isset($_GET['com_fid']) ? '' : $_GET['com_fid']);

$mid = get('mid','');
$mtype = get('mtype','');


function complain_form($com_fid){
	 global $db,$EWT_DB_NAME;
	 $s_category = $db->query("SELECT * FROM m_complain_form WHERE com_form_id = '{$com_fid}' ");	
	 if($db->db_num_rows($s_category)){
		$a_category = $db->db_fetch_array($s_category);											
		$a_data = $a_category['com_form_title'];
			
	 	}		
		return $a_data;
}



$perpage = 12;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT *
					FROM m_complain_form_element 
					INNER JOIN m_complain_form_item ON (m_complain_form_item.com_item_id = m_complain_form_element.com_ele_id)
					WHERE com_ele_fid = '{$com_fid}' {$wh} 
					ORDER BY com_ele_order ASC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(com_ele_id) AS b
			  FROM m_complain_form_element 
			  WHERE com_ele_fid = '{$com_fid}' {$wh}  ";
			  
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

<h4><?=$txt_permission_set;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="complain_form.php"><?=$txt_permission_menu_user;?></a></li>
<li class=""><?=$txt_permission_set;?></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<!--<button type="button" class="btn btn-info  btn-ml"  onClick="boxPopup('<?=linkboxPopup();?>pop_add_complain_form.php?com_cid=<?=$com_cid;?>');"  title="<?=$txt_complain_add_cate;?>"  target="_self">
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_complain_add_form;?>
</button>-->
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?=$cal_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_calendar_add_cate;?></a></li>
			<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_calendar.php?cal_cid=<?=$cal_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_calendar_add;?></a></li>
          	<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_search_banner.php');" ><i class="fas fa-search"></i>&nbsp;<?=$txt_calendar_search;?></a></li>
			<li><a href="banner_group.php" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?></a></li>
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

<div class="col-md-8 col-sm-8 col-xs-12 m-b-sm"  >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<i class="far fa-edit color-white fa-1x"></i>
<div class="card-title text-left">

</div>
</div>
<div class="card-body m-b-sm">
<input type="hidden" name="com_fid" id="com_fid"  value="<?=$com_fid;?>" >
<ul id="sortableLv1-form" class="sortableLv1 connectedSortable" style="width: 100%;">
<li class="productCategoryLevel1 bg-info ui-state-disabled text-center " id="0" >
<b>เลือก item ด้านขวา</b>
</li>
<?php
if($a_rows > 0){
$i = 0;
$s_data = array();
while($a_data = $db->db_fetch_array($_sql)){
	
	array_push($s_data,$a_data['com_ele_id']); 

	
?>	
<li class="productCategoryLevel1 move" id="<?=$a_data['com_ele_id'];?>">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?=$a_data['com_ele_id'];?>" value="<?=$a_data['com_ele_id'];?>">
<i class="<?=$a_data['com_item_icon'];?> text-medium text-dark"></i>
&nbsp;<?=$a_data['com_item_title'];?>

<div class="iconAction1">
&nbsp;
<button type="button" class="btn btn-default btn-circle btn-sm " onClick="boxPopup('<?=linkboxPopup();?>pop_setting_item.php?com_eid=<?=$a_data['com_ele_id'];?>&com_fid=<?=$com_fid;?>');" data-toggle="tooltip" data-placement="top" title="<?=$txt_complain_setting;?>">
<i class="fas fa-cogs" aria-hidden="true"></i>
</button>
&nbsp;
</div>

</li>
<?php $i++;} }else{?>

<li class="productCategoryLevel1 ui-state-disabled text-center "  >
  <p class="text-danger"><?=$txt_ewt_data_not_found;?></p>
</li>

<?php } ?>	

</ul>
</div>
<div class="card-body m-t-xxl text-right">
<!--<button onclick="boxPopup('<?=linkboxPopup();?>pop_view_form.php?com_fid=<?=$com_fid;?>');" type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?=$txt_ewt_viewform;?>
</button>-->
<button onclick="JQAdd_Complain_Form($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>
<div class="col-md-4 col-sm-4 col-xs-12 m-b-sm" > 
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<i class="fas fa-cogs color-white fa-1x"></i>
<div class="card-title text-left">

</div>
</div>
<div class="card-body">
<ul id="sortableLv1" class="sortableLv1 connectedSortable " style="width: 100%;">

<li class="productCategoryLevel1 bg-info ui-state-disabled text-center " id="00" >
<b>item</b>
</li>
<?php
//print_r($s_data);
$data = implode("','",$s_data);
$_sql_form = $db->query("SELECT *
					FROM m_complain_form
					WHERE com_form_id = '{$com_fid}'
					");	
					
$a_data_form = $db->db_fetch_array($_sql_form);

$com_form_type = $a_data_form['com_form_type'];	
				
$_sql_item = $db->query("SELECT *
					FROM m_complain_form_item
					WHERE com_item_id  NOT IN ('".$data."')
					ORDER BY com_item_id ASC ");	
$x = 0;					
while($a_data_item = $db->db_fetch_array($_sql_item)){
	
	
if($com_form_type == '1'){	

	if($a_data_item['com_item_id'] != '8'){
?>

<li class="productCategoryLevel1 move" id="<?=$a_data_item['com_item_id'];?>">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?=$a_data_item['com_item_id'];?>" value="<?=$a_data_item['com_item_id'];?>">
<i class="<?=$a_data_item['com_item_icon'];?> text-medium text-dark"></i>
&nbsp;<?=$a_data_item['com_item_title'];?>
</li>

<?php }}else{ ?>

<li class="productCategoryLevel1 move" id="<?=$a_data_item['com_item_id'];?>">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?=$a_data_item['com_item_id'];?>" value="<?=$a_data_item['com_item_id'];?>">
<i class="<?=$a_data_item['com_item_icon'];?> text-medium text-dark"></i>
&nbsp;<?=$a_data_item['com_item_title'];?>
</li>

<?php 
}
$x++; } 
?>	

<!--<li class="productCategoryLevel1 move" id="1">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id1" value="1">
<i class="far fa-id-card text-medium text-dark"></i>
&nbsp;<?=$txt_complain_idcard;?>
</li>

<li class="productCategoryLevel1 move" id="2">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id2" value="2">
<i class="fas fa-file-signature text-medium text-dark"></i>
&nbsp;<?=$txt_complain_name;?>
</li>

<li class="productCategoryLevel1 move" id="3">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id3" value="3">
<i class="fas fa-heading text-medium text-dark"></i>
&nbsp;<?=$txt_complain_title;?>
</li>

<li class="productCategoryLevel1 move" id="4">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id4" value="4">
<i class="fas fa-info-circle text-medium text-dark"></i>
&nbsp;<?=$txt_complain_detail;?>
</li>


<li class="productCategoryLevel1 move" id="5">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id5" value="5">
<i class="fas fa-phone-square text-medium text-dark"></i>
&nbsp;<?=$txt_complain_tel;?>
</li>

<li class="productCategoryLevel1 move" id="6">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id6" value="6">
<i class="fas fa-envelope text-medium text-dark"></i>
&nbsp;<?=$txt_complain_email;?>
</li>

<li class="productCategoryLevel1 move" id="7">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id7" value="7">
<i class="fas fa-upload text-medium text-dark"></i>
&nbsp;<?=$txt_complain_attack;?>
</li>


<li class="productCategoryLevel1 move" id="8">
&nbsp;
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id8" value="8">
<i class="fas fa-clipboard-check text-medium text-dark"></i>
&nbsp;<?=$txt_complain_category;?>
</li>-->


</ul>	

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
			
			var com_fid = $('#com_fid').val();

	//console.log(changedList);	
	
if(changedList == 'sortableLv1-form'){
    console.log({
      id: changedList,
      positions: positions
    });
		
									$.ajax({
											type: 'POST',
											url: 'func_sortable_complain_builder.php',											
											data:{proc:'Sortable_Edit',page_id_array_form:order,com_fid:com_fid},
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