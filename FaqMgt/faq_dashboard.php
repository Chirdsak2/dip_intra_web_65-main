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

<h4><?php echo $txt_faq_module ;?></h4>
<p></p> 

</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="faq_group.php"><?php echo $txt_faq_menu_main ;?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
</div>
	
</div>
</div>

</div>
<!--END card-header -->


<?php
function countFaqCate(){
	global $db;
$_sql    = $db->query("SELECT COUNT(faq_cate_id) AS num FROM faq_category WHERE faq_cate_status = 'Y' AND faq_cate_parent = '0' ");		  	
$a_count = $db->db_fetch_array($_sql);
return $a_count['num'];
}
function countFaq(){
	global $db;
$_sql    = $db->query("SELECT COUNT(fa_id) AS num FROM faq WHERE (faq_use = 'Y') ");		  	
$a_count = $db->db_fetch_array($_sql);
return $a_count['num'];
}
function countFaqQ(){
	global $db;
$_sql    = $db->query("SELECT COUNT(fa_id) AS num FROM faq WHERE faq_use = 'A' ");		  	
$a_count = $db->db_fetch_array($_sql);
return $a_count['num'];
}
?>
<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<div class="" id="frm_edit_s">	
<div id="frm_load">  

<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-green-light" onclick="self.location.href='faq_group.php'">
<!--Users Who have initiated at lest one session during the date range.    -->
<div class="card-body">
<i class="icon far fa-question-circle fa-4x"></i>
    <div class="content">
      <div class="title"><h4><?php echo $txt_faq_cate;?></h4></div>
      <div class="value"><span class="sign"></span><span class="counter"><?php echo countFaqCate();?></span></div>
	  <div class="title"><h5><?php echo $txt_ewt_list;?></h5></div>
    </div>
	
  </div>
</a>
</div>	
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-blue-light" onclick="self.location.href='faq_list.php'">
<!--Users Who have initiated at lest one session during the date range.    -->
<div class="card-body">
<i class="icon far fa-comment-dots fa-4x"></i>
    <div class="content">
      <div class="title"><h4><?php echo $txt_faq_list;?></h4></div>
      <div class="value"><span class="sign"></span><span class="counter"><?php echo countFaq();?></span></div>
	  <div class="title"><h5><?php echo $txt_ewt_list;?></h5></div>
    </div>
	
  </div>
</a>
</div>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-yellow-light" onclick="self.location.href='faq_question.php'">
<!--Users Who have initiated at lest one session during the date range.    -->
<div class="card-body">
<i class="icon far fa-paper-plane fa-4x"></i>
    <div class="content">
      <div class="title"><h4><?php echo $txt_faq_q;?></h4></div>
      <div class="value"><span class="sign"></span><span class="counter"><?php echo countFaqQ();?></span></div>
	  <div class="title"><h5><?php echo $txt_ewt_list;?></h5></div>
    </div>
	
  </div>
</a>
</div>	

<div class="col-gl-6 col-md-6 col-sm-12 col-xs-12 m-b-sm" >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">
<div class="title" ><i class="fas fa-hashtag"></i> <?php echo $txt_faq_list_top_view;?></div>

</div>
</div>
<div class="card-body" id="tab1">

<ul class="list-group">
<?php
$_sql = $db->query("SELECT * FROM faq WHERE faq_use = 'Y' ORDER BY fa_count DESC  LIMIT 0,5");

while($a_datafaq = $db->db_fetch_array($_sql))
{
?>
 
<li class="list-group-item "><i class="far fa-newspaper"></i> <?php echo $a_datafaq['fa_name'];?> 	<b><i class="far fa-eye"></i>&nbsp;:&nbsp;<?php echo $a_datafaq['fa_count']; ?> view</b></li>

<?php } ?>
</ul>

<!--<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more"  class="hi-icon hi-icon-list text-dark" title="View more" onclick="window.location.href='../DashboardMgt/article_list_view.php?tap=1'">View more</a>
</div>-->
</div>				
</div>
</div>

<div class="col-gl-6 col-md-6 col-sm-12 col-xs-12 m-b-sm" >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">
<div class="title" ><i class="fas fa-hashtag"></i> <?php echo $txt_faq_list_top_tell;?></div>

</div>
</div>
<div class="card-body" id="tab1">

<ul class="list-group">
<?php
/*$date = new DateTime();
$Y = $date->format('Y')+543; 
$MD = $date->format('-m-d');

$s_art_new = $db->query("SELECT n_id,n_topic,n_owner 
FROM article_list WHERE n_id != '' AND  n_approve = 'Y' AND n_date = '".$Y.$MD."'
ORDER BY n_id DESC LIMIT 0,5");

while($a_art_new = $db->db_fetch_row($s_art_new)){
?>
<li class="list-group-item "><i class="far fa-newspaper"></i> <?php echo $a_art_new[1];?></li>

<?php }*/?>
</ul>
 
<!--<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more"  class="hi-icon hi-icon-list text-dark" title="View more" onclick="window.location.href='../DashboardMgt/article_list_view.php?tap=1'">View more</a>
</div>-->
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
						content: '<?php echo txt_ewt_confirm_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo txt_ewt_confirm_submit;?>',
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
						content: '<?php echo txt_ewt_confirm_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo txt_ewt_confirm_submit;?>',
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