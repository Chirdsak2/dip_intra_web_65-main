<?php
include("../EWT_ADMIN/comtop_pop.php");

$rss_id = (int)(!isset($_GET['rss_id']) ? '' : $_GET['rss_id']);

$s_sql 	= $db->query("SELECT * FROM rss WHERE rss_id = '{$rss_id}' ");
$a_data = $db->db_fetch_array($s_sql);  
?>
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_rss')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Rss">
<input type="hidden" name="rss_id" id="rss_id"  value="<?php echo $rss_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo 'แก้ไข Rss Feed' ;?></h4>  
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >

<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="rss_status"><b>สถานะการใช้งาน</b></label> :  
<div >
<label class="switch"> 
  <input type="checkbox" value="Y" name="rss_status" id="rss_status" <?php if($a_data['rss_status'] == 'Y'){ echo 'checked="checked"'; } ?> > 
  <span class="slider round"></span>
  <span class="absolute-no">NO</span> 
</label>
</div>
</div>
</div>

<div class="form-group row " >
<label for="rss_title" class="col-sm-12 control-label"><b><?php echo 'ชื่อ Rss Feed';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo 'ชื่อ Rss Feed';?>"  id="rss_title" name="rss_title" value="<?php echo $a_data['rss_title'];?>" required="required"  >
</div>
</div>

<div class="form-group row " > 
<label for="rss_url" class="col-sm-12 control-label"><b><?php echo 'ลิงค์ที่อยู่ RSS Feed';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo 'ลิงค์ที่อยู่ RSS Feed';?>"  id="rss_url" name="rss_url" value="<?php echo $a_data['rss_url'];?>"  required="required"  >
</div>
</div>

<div class="form-group row " >
<label for="rss_row" class="col-sm-12 control-label"><b><?php echo 'จำนวนแถว';?><span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="input-group">
<input class="form-control" placeholder="<?php echo 'จำนวนแถว';?> " name="rss_row" type="text" id="rss_row"  value="<?php echo $a_data['rss_row'];?>" required="required" aria-describedby="basic-addon2" />
 <span class="input-group-addon" id="basic-addon2">แถว</span> 
</div>
<p class="text-danger"><code>Ex. 10 แถว</code></p> 
</div>
</div>

<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="rss_images"><b>แสดงรูปภาพประกอบข่าว</b></label> :   
<div >
<label class="switch">  
  <input type="checkbox" value="Y" name="rss_images" id="rss_images" <?php if($a_data['rss_images'] == 'Y'){ echo 'checked="checked"'; } ?> > 
  <span class="slider round"></span>
  <span class="absolute-no">NO</span> 
</label>
</div>
</div>
</div>
	
</div>		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_RSS($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?> 
</button>
</div>
</div>
</div>
</div>
</div>
 </div>
</div>	 
</form>
	
<script>  
$(document).ready(function() {

/*var urlExists = function(url, callback) {

    if ( ! $.isFunction(callback)) {
       throw Error('Not a valid callback');
    }   

    $.ajax({
        type: 'HEAD',
        url: url,
        success: $.proxy(callback, this, true),
        error: $.proxy(callback, this, false)      
    });

};*/
	
});
$(function() {
	$('#btnValidate').click(function() {
	var txt = $('#txturl').val();
	var re = '/(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/';
	if (re.test(txt)) {
	alert('Valid URL')
	}
	else 
	{
	alert('Please Enter Valid URL');
	return false;
	}
	});
});
function JQEdit_RSS(form){   	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({ 
						title: 'แก้ไข Rss Feed', 
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
													title: '',
													theme: 'modern',
													content: '<?php echo $txt_ewt_action_alert;?>',
													boxWidth: '30%',
													type: 'blue', 
													onAction: function () {
															
														location.reload(true);														
														$('#box_popup').fadeOut();
													}		
												});
																										
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: '<?php echo $txt_ewt_cancel;?>',
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