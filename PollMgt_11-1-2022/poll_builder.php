<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$c_id = (int)(!isset($_GET['c_id']) ? 0 : $_GET['c_id']);



?> 

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?='สร้างคำตอบแบบสำรวจ';?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="poll_list.php"><?=$txt_poll_menu_main;?></a></li>
<li><?='สร้างคำตอบแบบสำรวจ';?>  </li> 
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  



</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->


<?php

$perpage = 12;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * FROM poll_ans WHERE c_id = '{$c_id}' ORDER BY a_position ASC ");


			  
$a_rows = $db->db_num_rows($_sql);		
?> 
<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<div class="row ">

<div class="col-md-4 col-sm-4 col-xs-12 m-b-sm"  >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<div class="card-title text-left color-white">
<i class="fas fa-cogs color-white fa-1x" aria-hidden="true"></i>

</div>
</div>
<div class="card-body m-b-sm text-center">
<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?=linkboxPopup();?>pop_add_poll_answer.php?c_id=<?=$c_id;?>');" title="<?=$txt_poll_add;;?>"  target="_self">
<i class="fas fa-plus-circle"></i>&nbsp;<?="เพิ่มคำตอบแบบสำรวจ";?>
</button>
</div>
</div>

</div>

<div class="col-md-8 col-sm-8 col-xs-12 m-b-sm"  >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<div class="card-title text-left color-white">
<i class="fas fa-comment-dots color-white fa-1x" aria-hidden="true"></i>
<?='คำตอบแบบสำรวจ';?>
</div>
</div>
<div class="card-body m-b-sm">

<ul id="sortableLv1" class="sortableLv1 " style="width: 100%;">
<?php
if($a_rows > 0){
while($a_data = $db->db_fetch_array($_sql)){	
?>
<input type="hidden" name="category_id" id="category_id"  value="<?=$a_data['a_id'];?>" >
<li class="productCategoryLevel1 move" id="<?=$a_data['a_id'];?>">
&nbsp;
<span class="">
<i class="fa fa-ellipsis-v text-medium text-dark"></i>
</span>

<input class="input-inline-sm text-center" name="category_order[]" id="category_order<?=$a_data['a_position'];?>"  type="text" value="<?=$a_data['a_position'];?>" readonly />
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?=$a_data['faq_cate_order'];?>" value="<?=$a_data['faq_cate_id'];?>">

<i class="fas fa-comment-dots text-medium text-dark"></i>
<b style="word-break: break-all;"><?=$a_data['a_name'];?> </b>

<div class="iconAction1" style="top:1px;">
<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_poll_answer.php?a_id=<?=$a_data['a_id'];?>');" >
<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?="Edit";?>"  >
<i class="fa fa-edit  fa-1x text-dark  pointer" aria-hidden="true"></i>
</button>
</a>
<a onClick="JQDel_Poll_Ans('<?=$a_data['a_id'];?>');" >
<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?="Delete";?>"  >
<i class="fas fa-trash-alt  fa-1x text-dark  pointer" aria-hidden="true"></i>
</button>
</a>

</div>
</li>
<?php } }else{?>	
<li class="productCategoryLevel1" >
<p class="text-danger text-center"><?=$text_general_notfound;?></p>
</li>
		
<?php } ?>
</ul>	

</div>
<div class="card-body m-t-xxl text-right">
<!--<button onclick="boxPopup('<?=linkboxPopup();?>pop_view_form.php?com_fid=<?=$com_fid;?>');" type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?=$txt_ewt_viewform;?>
</button>-->
<button onclick="JQAdd_Poll_Builder($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>


</div>

</div>

</div>
			
</div>
</div>

</div>
<!--END card-body -->
</div>
<!--END card -->

</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>

<style>
.panel-default > .panel-heading {
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
        color: #FFFFFF;
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
$(function  () {

	$("#sortableLv1").sortable({
	placeholder: 'drop-placeholder',
	update: function (event, ui) {									
		var page_id_array = new Array();
			$('#sortableLv1 li').each(function(){
				page_id_array.push($(this).attr("id"));
			});		
			console.log(page_id_array);			
									$.ajax({
											type: 'POST',
											url: 'func_sortable_poll_answer.php',											
											data:{proc:'Sortable_Edit',page_id_array:page_id_array},
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
/*$(function  () {
 $("#accordion").sortable({
placeholder: 'drop-placeholder'
});

});*/

function JQAdd_Lang_Poll(w,g,lang) {
	$.ajax({
      type: 'GET',
      url: 'pop_add_lang_poll.php?langid='+g+'&lang='+lang+'&id='+w,
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
function JQSet_Lang_Poll(w,g) {	
	$.ajax({
      type: 'GET',
      url: 'pop_set_lang_poll.php?gid='+g+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}
		
    }); 
	
$('#box_popup').fadeIn();	
}

function JQAdd_faq_group(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?="เพิ่มหมวด FAQ";?>',
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
												});
												$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 

								
}

function JQDel_Poll_Ans(id){
	
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
											url: 'func_delete_poll_ans.php',
											data:{'id': id,'proc':'DelAns'},
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


function JQAdd_Poll_Builder(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?="สร้างคำตอบแบบสำรวจ";?>',
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
													onAction: function () {
														self.location.href="poll_list.php";			
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
</script>