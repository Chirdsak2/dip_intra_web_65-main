<?php
include("../EWT_ADMIN/comtop_pop.php");
include("../language/banner_language.php");


?>	
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_banner_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate_Banner">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">

<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_banner_add_cate;?></h4>
</div>

<div class="modal-body">
<div class="card ">

<div class="card-body" >

<div class="form-group row " >
<label for="banner_name" class="col-sm-6 control-label"><b><?php echo $txt_banner_cate_name;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_banner_cate_name;?>" name="banner_name" type="text" id="banner_name"  value="" required="required" />
</div>
</div>
<div class="form-group row " >
<label for="banner_detail" class="col-sm-6 control-label"><b><?php echo $txt_banner_cate_detail;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo $txt_banner_cate_detail;?>"  rows="5" id="banner_detail" name="banner_detail"  ></textarea>
</div>
</div>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="banner_w"><b><?php echo $txt_banner_set_w ;?> <!--<span class="text-danger"><code>*</code></span>--> : </b></label>
<input type="text" class="form-control" placeholder="<?php echo $txt_banner_h_placeholder;?>"  id="banner_w" name="banner_w"/> 
<p class="text-danger"><code>Ex. 1000</code></p>
</div>

<div class="col-md-6 col-sm-6 col-xs-12">
<label for="banner_h"><b><?php echo $txt_banner_set_h ;?> <!--<span class="text-danger"><code>*</code></span>--> : </b></label>
<input type="text" class="form-control" placeholder="<?php echo $txt_banner_w_placeholder;?>"  id="banner_h" name="banner_h"/> 
<p class="text-danger"><code>Ex. 480</code></p>
</div>
</div>

</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Banner_Cate($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?> 
</button>
</div>
</div>
</div>
 </div>
 
</div>
</div>	 
</form>	
<script>  
function JQAdd_Banner_Cate(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo "เพิ่มหมวด Banner";?>',
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
</script>