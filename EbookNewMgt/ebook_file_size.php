<?php
include("../EWT_ADMIN/comtop.php");

?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
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
<h4><?php echo $txt_ebook_menu_file_size;?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?php echo $txt_ebook_menu_file_size;?></li>
<li></li> 
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<!--<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_ebook_file_size.php');"   target="_self">
<button type="button" class="btn btn-info  btn-ml"  title="<?php echo $txt_ebook_file_size_add;?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_ebook_file_size_add;?>
</button>
</a>
<a  target="_self" onclick="boxPopup('<?php //echo linkboxPopup();?>pop_search_list.php');" >   
<button type="button" class="btn btn-info  btn-ml"  title="<?php //echo $txt_ebook_search_list;?>"  >
<i class="fas fa-search"></i>&nbsp;<?php //echo $txt_ebook_search_list ;?>
</button>
</a>-->
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  > 
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right pointer">
		 <!--<li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_ebook_file_size.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_ebook_file_size_add;?></a></li>
       <li class=""><a onClick="boxPopup('<?php //echo linkboxPopup();?>pop_search_list.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_ebook_search_list;?></a></li>!-->
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">

<div class="title" ><i class="fas fa-hashtag"></i> <?php //echo $txt_banner_cate;?></div>
</div>
</div>
<div class="card-body">
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_ebook_file_size')?>" enctype="multipart/form-data" >
<?php
$_sql = $db->query("SELECT * 
					FROM ebook_value
					WHERE 1=1 ORDER BY ebook_value_id DESC");
			  
$a_rows = $db->db_num_rows($_sql);		
	
if($a_rows)
{	 
while($a_data = $db->db_fetch_array($_sql)) 
{
?>
<div class="form-group row " >
<label for="menu_link" class="col-sm-4 control-label text-right"><b><?php echo $a_data['ebook_value_name'];?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-4 col-sm-4 col-xs-12" >
<div class="input-group">
<input class="form-control" placeholder="<?php echo $a_data['ebook_value_name'];?>" name="ebook_value_<?php echo $a_data['ebook_value_id'];?>" type="text" id="ebook_value<?php echo $a_data['ebook_value_id'];?>"  value="<?php echo $a_data['ebook_value'];?>" required="required" aria-describedby="basic-addon2" />
 <span class="input-group-addon" id="basic-addon2">MB.</span>
</div>
</div>
</div> 
<?php 
	}
}
?>

<input type="hidden" name="proc" id="proc"  value="Edit_FileSize">
<input type="hidden" name="all" id="all"  value="<?php echo $a_rows;?>">
		


<div class="text-center">
<button onclick="JQEdit_Size($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save ;?> 
</button>
</div>
</form>	
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
function JQEdit_Size(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({ 
						title: '<?php echo $txt_ebook_file_size_edit;?>',
						content: '<?php echo $txt_ewt_confirm_alert;?> ',
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
													title: '<?php echo $txt_ewt_action_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',
													onAction: function () {
														//self.location.href="menu_builder.php?m_id="+data;		
														location.reload(true);	
														//$("#frm_edit_s").load(location.href + " #frm_edit_s");
														//$('#box_popup').fadeOut();
													}		
												});
																										
												
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


function JQDel_Ebook_File(id){
					$.confirm({
						title: '<?php echo $txt_ewt_confirm_del_title;?>',
						content: '<?php echo $txt_ewt_confirm_del_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo $txt_ewt_confirm_del;?>',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_ebook_cate.php',
											data:{'id': id,'proc':'DelOrgList'},
											success: function (data) {
												$.alert({
													title: '<?php echo $txt_ewt_action_del_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: '<?php echo $txt_ewt_submit;?>',
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
									text: '<?php echo $txt_ewt_cancel;?>'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}

</script>



