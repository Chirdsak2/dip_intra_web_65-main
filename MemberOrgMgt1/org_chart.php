<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$db->query("USE ".$EWT_DB_USER);

?>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?=$txt_org_menu_chart;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="org_dashboard.php"><?=$txt_org_menu_main;?></a></li>
<li class=""><?=$txt_org_menu_chart;?></li>   
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	

</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >

</div>	
</div>
</div>
</div>
<!--END card-header -->

<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >
<div class="row ">

<div class="col-md-6 col-sm-6 col-xs-12"  >
<div class="blog-card-item spring-fever m-b-sm">
<div class="title-content">
<h3 ><span class=""><?=$txt_org_chart_org_group;?></span></h3>
<hr class="hr-blog-card" />
<div class="intro-max">
<span class="text-dark" >จำนวน</span> 
<span class="counter"><?=org::getCountOrg('1');?></span>
<span class="text-dark" >รายการ</span>
</div>
</div>
<div class="card-info-max" >
<div class="view_details" >
<a href="org_chart_org_group.php"  target="_self" >
<button type="button" class="btn btn-default  btn-sm  " data-toggle="tooltip" data-placement="top" title="<?='รายการทั้งหมด';?>">
<i class="fas fa-external-link-alt text-dark" aria-hidden="true" ></i>
</button>
</a>
</div>
</div>
<div class="gradient-overlay"></div>
<div class="color-overlay-max"></div>
</div>
</div>

<div class="col-md-6 col-sm-6 col-xs-12"  >
<div class="blog-card-item spring-fever m-b-sm">
<div class="title-content">
<h3 ><span class=""><?=$txt_org_chart_org_list;?></span></h3>
<hr class="hr-blog-card" />
<div class="intro-max">
<span class="text-dark" >จำนวน</span> 
<span class="counter"><?=org::getCountOrg('1');?></span>
<span class="text-dark" >รายการ</span>
</div>
</div>
<div class="card-info-max" >
<div class="view_details" >
<a href="org_chart_org_list.php"  target="_self">
<button type="button" class="btn btn-default  btn-sm  " data-toggle="tooltip" data-placement="top" title="<?='รายการทั้งหมด';?>">
<i class="fas fa-external-link-alt text-dark" aria-hidden="true"></i>
</button>
</a>
</div>

</div>
<div class="gradient-overlay"></div>
<div class="color-overlay-max"></div>
</div>
</div>

</div>
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
</style>
<script>
function txt_data(w,g) {	
	$.ajax({
      type: 'GET',
      url: 'pop_set_lang_org_group.php?gid='+g+'&id='+w,
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
      url: 'pop_org_group_multilang.php?langid='+g+'&lang='+lang+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}		
    }); 
	$('#box_popup').fadeIn();	
}

function JQDel_Org_Group(id){
					$.confirm({
						title: '<?=$txt_ewt_confirm_del_title;?>',
						content: '<?=$txt_ewt_confirm_del_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?=$txt_ewt_confirm_del;?>',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_org_group.php',
											data:{'id': id,'proc':'DelOrgGroup'},
											success: function (data) {
												$.alert({
													title: '<?=$txt_ewt_action_del_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: '<?=$txt_ewt_submit;?>',
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
									text: '<?=$txt_ewt_cancel;?>'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}
</script>	