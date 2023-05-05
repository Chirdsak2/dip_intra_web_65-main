<?php
include("../EWT_ADMIN/comtop_pop.php");

$info_id = (int)(!isset($_GET['info_id']) ? '' : $_GET['info_id']);

$s_site_info = "SELECT * FROM site_info";
$query = $db->query($s_site_info);
$rec = $db->db_fetch_array($query);

?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_set_site_info')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Set_Site_Info">
<input type="hidden" name="info_id" id="info_id"  value="<?=$info_id;?>">
<input type="hidden" name="site_info_id" id="site_info_id"  value="<?=$rec['site_info_id'];?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?=$txt_site_set_info;?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >
<?php /*<div class="form-group row">
<label for="txt_url"><b><?="Url Name";?> :</b></label>  
<div class="col-md-12 col-sm-12 col-xs-12">
<input class="form-control" name="txt_url" type="text" id="txt_url"  value="<?=$a_user['url'];?>" />
<span class="text-danger">Ex:http://www.yahoo.com/ </span>
</div>
</div>*/?>

<div class="form-group row">
<label for="txt_title"><b><?="Title";?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12"> 
<input class="form-control" name="txt_title" type="text" id="txt_title"  value="<?=$rec['site_info_title'];?>">    
</div>
</div>

<div class="form-group row">
<label for="txt_keyword"><b><?="Keyword";?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12">  
<textarea name="txt_keyword" cols="60" rows="5"  id="txt_keyword" class="form-control" ><?=$rec['site_info_keyword'];?></textarea>     
</div>
</div>

<div class="form-group row">
<label for="txt_desc"><b><?="Description";?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12">  
<textarea name="txt_desc" cols="60" rows="5"  id="txt_desc" class="form-control" ><?=$rec['site_info_description'];?></textarea>
</div>
</div>
<?php
//echo sizeMB2byte($rec['site_info_max_img']);
?>
<div class="form-group row">
<label for="txt_max_Img"><b><?="Max Image Size Upload";?> :</b></label> 
<div class="col-md-12 col-sm-12 col-xs-12">
<input class="form-control" name="txt_max_Img" type="text" id="txt_max_Img"  _style="width:15%;" value="<?=$rec['site_info_max_img'];?>" />
 MB.
</div>
</div>

<div class="form-group row">
<label for="type_img_file"><b><?="Image type allowed";?> :</b></label> 
<div class="col-md-12 col-sm-12 col-xs-12">
<input name="type_img_file"  id="type_img_file" class="form-control" type="text"  _style="width:79%;" value="<?=$rec['site_type_img_file']?>" />
<span class="text-danger"><code>Ex: jpg,gif</code></span> 
<br>
<span class="text-danger"><code>คั่นข้อความด้วยเครื่องหมายจุลภาค(,) </code></span>
</div>
</div>

<div class="form-group row">
<label for="txt_max_file"><b><?="Max File Size Upload";?> :</b></label> 
<div class="col-md-12 col-sm-12 col-xs-12">
<input class="form-control" name="txt_max_file" type="text" id="txt_max_file" _style="width:15%;"  value="<?=$rec['site_info_max_file'];?>">
MB.
</div>
</div>

<div class="form-group row">
<label for="type_file"><b><?="File type allowed";?> :</b></label> 
<div class="col-md-12 col-sm-12 col-xs-12">
<input name="type_file"  id="type_file" class="form-control" type="text" _style="width:79%;" value="<?=$rec['site_type_file']?>">
<span class="text-danger"><code>Ex: doc,zip,exe</code></span>
<br>
<span class="text-danger"><code>คั่นข้อความด้วยเครื่องหมายจุลภาค(,) </code></span>
</div>
</div>

<div class="form-group row">
<label for="txt_max_vdo"><b><?="Max Vedio Size Upload";?> :</b></label> 
<div class="col-md-12 col-sm-12 col-xs-12">
<input class="form-control" name="txt_max_vdo" type="text" id="txt_max_vdo" _style="width:15%;"  value="<?=$rec['site_info_max_vdo'];?>">
MB.
</div>
</div>

<div class="form-group row">
<label for="type_vdo_file"><b><?="Vedio type allowed";?> :</b></label> 
<div class="col-md-12 col-sm-12 col-xs-12">
<input name="type_vdo_file"  id="type_vdo_file" class="form-control" type="text" _style="width:79%;" value="<?=$rec['site_type_vdo_file']?>">
<span class="text-danger"><code>Ex: mp4,mp3</code></span>
<br>
<span class="text-danger"><code>คั่นข้อความด้วยเครื่องหมายจุลภาค(,) </code></span>
</div>
</div>

<?php /*<div class="form-group row">
<label for="txtcountor"><b><?="Start counter";?> :</b></label> 
<div class="col-md-12 col-sm-12 col-xs-12">
<input class="form-control" name="txtcountor" type="text" id="txtcountor" style="width:20%;"  value="<?=$rec['set_countor'];?>" />
</div>
</div> */ ?>

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Site_Info($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>

<script> 

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var type_data = $('input:radio[name='+name+']:checked').val();
	
	if(type_data == '0'){
		$('#show_complain_category').hide();
		$('#complain_category').attr("disabled",true);
		$('#complain_category').attr("required",false);
		}else{
			$('#show_complain_category').show();
			$('#complain_category').attr("disabled",false);
			$('#complain_category').attr("required",true);
		}	
	console.log(type_data);
}
 
function JQAdd_Complain_Form(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_complain_add_form;?>',
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
														self.location.href="complain_builder.php?com_fid="+data;			
														//location.reload(true);			
														//$('#box_popup').fadeOut();
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

function JQAdd_Site_Info(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_site_set_info;?>',
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
														//self.location.href="complain_builder.php?com_cid=6";	
														location.reload(true);			
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