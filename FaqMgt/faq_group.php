<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid"  >
<?php
include("menu-top.php");
?> 

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo $txt_faq_cate ;?></h4>
<p></p> 

</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="faq_dashboard.php"><?php echo $txt_faq_menu_main;?></a></li>
<li class=""><?php echo $txt_faq_cate;?></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_faq_group.php');"  target="_self">
<button type="button" class="btn btn-info  btn-md" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_faq_cate_add;?>
</button>
</a>
<!-- <a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_faq.php?faq_cid=<?php echo $faq_cid;?>');"  target="_self">
<button type="button" class="btn btn-info  btn-md">
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_faq_add;?>
</button>
</a> -->
<a  target="_self" onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_faq.php');" >
<button type="button" class="btn btn-info btn-md" >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_faq_search;?>
</button>
</a>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_faq_group.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_faq_cate_add;?></a></li>
			<li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_faq.php?faq_cid=<?php echo $faq_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_faq_add;?></a></li>
			<li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search_faq.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_faq_search;?></a></li>
          	
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->


<?php

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * FROM faq_category WHERE faq_cate_status = 'Y' AND faq_cate_parent = '0'  {$wh} ORDER BY faq_cate_order ASC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(faq_cate_id) AS b
			  FROM faq_category {$wh} ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
?>
<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<div class="" id="frm_edit_s">	
<div id="frm_load">  
	
<div class="card">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">

<div class="title" ><i class="fas fa-hashtag"></i> <?php echo $txt_faq_cate;?></div>
</div>
</div>
<div class="card-body">	
<div class="panel-group" id="accordion">
<?php
if($a_rows > 0)
{
	$i = 0;
	while($a_data = $db->db_fetch_array($_sql))
	{
?>	
<div class="panel panel-default " id="<?php echo $a_data['faq_cate_id'];?>"  >
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
				<i class="fas fa-arrows-alt text-info move" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="<?php echo 'Move';?>" ></i>
				<input class="input-inline-sm text-center" name="fa_order[]" id="fa_order<?php echo $a_data['faq_cate_order'];?>"  type="text" value="<?php echo $a_data['faq_cate_order'];?>" readonly />
				
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					<i class="fas fa-comment-dots"></i>
					<?php echo $a_data['faq_cate_title'];?>
					</a>
					<span class="pull-right">
					<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_faq_group.php?faq_cid=<?php echo $a_data['faq_cate_id'];?>');">
<button type="button" class="btn btn-warning  btn-circle  btn-xs "  data-toggle="tooltip" data-placement="top" title="<?php echo $txt_faq_cate_edit;?>" >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a>
<a onClick="JQDel_Faq_Cate('<?php echo $a_data['faq_cate_id'];?>');" >
<button type="button" class="btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_faq_cate_del;?>"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>
<a href="faq_list.php?faq_cid=<?php echo $a_data['faq_cate_id'];?>" >
<button type="button" class="btn btn-success btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_faq_list;?>"   >
<i class="fa fa-th-list " aria-hidden="true"></i>
</button>
</a>
<a href="faq_subgroup.php?faq_cid=<?php echo $a_data['faq_cate_id'];?>" >
<button type="button" class="btn btn-info btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_faq_cate_sub;?>"   >
<i class="fas fa-folder-plus" aria-hidden="true"></i>
</button>
</a>	&nbsp;&nbsp;		
	</span>		
                </h4>
            </div>	
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                   	<div><b><?php echo $txt_faq_cate_name;?> :</b> <?php echo $a_data['faq_cate_title'];?></div><br> 
					<?php if($a_data['faq_cate_detail'] != ''){ ?>
					<div><b><?php echo $txt_faq_cate_detail;?> :</b> <?php echo $a_data['faq_cate_detail'];?></div><br> 
					<?php } ?>
				</div>	
				<div class="panel-footer ewt-bg-white text-right">
				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">



					
<!--<a onClick="JQSet_Lang_Calendar('<?php //echo $a_data['event_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?php //echo $txt_ewt_create_multilang;?>">
<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?php //echo $a_data['event_id'];?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>-->

				</div>
				</div>
            </div>
        </div>
<?php 
	$i++;
	}
		}
		else
		{
	?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php 	
		} 
?>		
	
</div>

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
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
.pull-right {float:right;}
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

	$("#accordion").sortable({
	placeholder: 'drop-placeholder',
	update: function (event, ui) {									
		var page_id_array = new Array();
			$('#accordion div.panel').each(function(){
				page_id_array.push($(this).attr("id"));
			});	
			console.log(page_id_array);			
									$.ajax({
											type: 'POST',
											url: 'func_sortable_faq_group.php',											
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
	
function JQDel_Faq_Cate(id){
	//alert(id);
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
											url: 'func_delete_faq_q.php',
											data:{'id': id,'proc':'Del_Faq_Cate'},
											success: function (data) {
												$.alert({
													title: 'ลบข้อมูลเรียบร้อย',
													theme: 'modern',
													content: '',
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
						title: '<?php echo $txt_faq_cate_add;?>',
						content: '<?php echo $txt_ewt_confirm_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo $txt_ewt_confirm_submit;?>',
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
													content: '<?php echo $txt_ewt_action_alert;?>',
													boxWidth: '30%',
													onAction: function () {
														document.location.reload();
														$('#box_popup').fadeOut();
													}													
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: '<?php echo $txt_ewt_cancel;?>',
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

function JQEdit_faq_group(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_faq_cate_edit;?>',
						content: '<?php echo $txt_ewt_confirm_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo $txt_ewt_confirm_submit;?>',
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
												try
												{
												var cdata= JSON.stringify(eval("("+data+")"));
												var jsonObject = jQuery.parseJSON(cdata);												
											console.log(jsonObject.faq_cate_parent);	
											$.alert({
													title: '',
													theme: 'modern',
													content: '<?php echo $txt_ewt_action_alert;?>',
													boxWidth: '30%',
													onAction: function () {
														$('#box_popup').fadeOut();
														if(jsonObject.faq_cate_status_parent == 'Y'){
														self.location.href="faq_subgroup.php?faq_cid="+jsonObject.faq_cate_parent;
														}else{		
														self.location.href="faq_group.php";														
															document.location.reload();		
														}														
													}																					
												});
												//$("#frm_edit_s").load(location.href + "frm_edit_s");
												//alert("Data Save: " + location.href);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												//document.location.reload();
												//window.location.reload();												
											}									
											catch(e){
												}															
											}
										});																										
									}								
							
								},
								cancel: {
									text: '<?php echo $txt_ewt_cancel;?>',
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

</script>