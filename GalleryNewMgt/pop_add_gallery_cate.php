<?php
include("../EWT_ADMIN/comtop_pop.php");

?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_gallery_cate')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Gallery_cate">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title">เพิ่มห้องรูปภาพ</h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="gal_cat_title" class="col-sm-12 control-label"><b>ชื่อหมวดหมู่<span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class = "form-control" type = "text" placeholder = "ชื่อหมวดหมู่" id= "gal_cat_title" name = "gal_cat_title" required="required">
</div>
</div>
<div class="form-group row " >
<label for="gal_cat_detail" class="col-sm-12 control-label"><b>รายละเอียด</span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="รายละเอียด"  rows="6" id="gal_cat_detail" name="gal_cat_detail"></textarea>
</div>
</div>

<!--<label class="col-sm-12 control-label"><b>การแสดงผล คอลัมน์*แถว :</b></label>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
    <input class = "form-control" type = "number" placeholder = "คอลัมน์" id= "gal_cat_col" name = "gal_cat_col" min = "0">
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
     <input class = "form-control" type = "number" placeholder = "แถว" id= "gal_cat_row" name = "gal_cat_row" min = "0">
</div>
</div>

<label class="col-sm-12 control-label"><b>กำหนดขนาดภาพเล็ก :</b></label>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
    <input class = "form-control" type = "number" placeholder = "ความสูง" id= "gal_cat_smh" name = "gal_cat_smh" min = "0">
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
     <input class = "form-control" type = "number" placeholder = "ความกว้าง" id= "gal_cat_smw" name = "gal_cat_smw" min = "0">
</div>
</div>

<label class="col-sm-12 control-label"><b>กำหนดขนาดภาพใหญ่ :</b></label>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
    <input class = "form-control" type = "number" placeholder = "ความสูง" id= "gal_cat_lgh" name = "gal_cat_lgh" min = "0">
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
     <input class = "form-control" type = "number" placeholder = "ความกว้าง" id= "gal_cat_lgw" name = "gal_cat_lgw" min = "0">
</div>
</div>-->

<div class="form-group row " >
<label for="gal_cat_allow" class="col-sm-12 control-label"><b>การอนุญาติ :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
  <label><input type="checkbox" name="gal_cat_allow_vote" value="1">อนุญาตให้มีการ Vote
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="checkbox">
  <label><input type="checkbox" name="gal_cat_allow_send" value="1" >อนุญาตให้มีการส่งต่อให้เพื่อน
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="checkbox">
  <label><input type="checkbox" name="gal_cat_allow_ment" value="1" >อนุญาตให้มีการ Comment
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>



</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Gallery_cate($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save ;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
	
<script>  

$(document).ready(function() {
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'yyyy-mm-dd',
			todayHighlight: true,
            //language: 'th-th',
			//thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	
});

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_sub').attr("disabled",false);
		}else{
			$('#category_sub').attr("disabled",true);
		}	
	console.log(check);
}
 
function JQAdd_Gallery_cate(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?='';?>',
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
												//var cdata= JSON.stringify(eval("("+data+")"));
												//var jsonObject = jQuery.parseJSON(cdata);
												//console.log(jsonObject);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														
														//self.location.href="poll_builder.php?c_id="+jsonObject;	
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
