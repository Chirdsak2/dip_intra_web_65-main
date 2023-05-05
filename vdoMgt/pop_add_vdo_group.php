<?php
include("../EWT_ADMIN/comtop_pop.php");

$sql_Imsize = "SELECT * FROM site_info";
$query_Imsize = $db->query($sql_Imsize);
$rec_Imsize = $db->db_fetch_array($query_Imsize);
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_vdo_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate">
<input type="hidden" name="vdog_creator" id="vdog_creator"  value="<?=$_SESSION['EWT_SMUSER'];?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"><?=$txt_vdo_add_cate;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="vdog_name" class="col-sm-12 control-label"><b><?=$txt_vdo_cate_name;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_vdo_cate_name;?>" name="vdog_name" type="text" id="vdog_name"  value="" required="required" />
</div>
</div>
<div class="form-group row " >
<label for="vdog_info" class="col-sm-12 control-label"><b><?=$txt_vdo_cate_detail;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_vdo_cate_detail;?>"  rows="6" id="vdog_info" name="vdog_info"  required="required" ></textarea>
</div>
</div>
<div class="form-group row " >
<label for="vdog_img" class="col-sm-12 control-label"><b><?=$txt_vdo_img_cate;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input type="file" name="vdog_img" id="vdog_img" class="form-control" required="required" onchange="JSCheck_Img(this.id,this.value);" />
</div>
<span class="text-danger">
<code>
ประเภทไฟล์ที่สามารถใช้ได้คือ <?=EwtTypefile('img');?>
</code>
</span>
<br>
<span class="text-danger"><code>
ขนาดไฟล์ต้องไม่เกิน <?=EwtMaxfile('img');?> MB.
</code></span>
</div>

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_vdo_group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save" ></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>	
<script>  
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
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
		$('#category_parent').attr("disabled",false);
		$('#category_parent').attr("required",false);
		}else{
			$('#category_parent').attr("disabled",true);
			$('#category_parent').attr("required",true);
		}	
	console.log(check);
}

function JQAdd_vdo_group(form){	

/*$.ajaxSetup({
        cache: false,
        contentType: false,
        processData: false
    });*/
	
var fail = CKSubmitData(form);

if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 
//var form = $('#form_main')[0];

		// Create an FormData object 
 //var data = new FormData(form);
 //var formData = new FormData($('#form_main')[0]);
     //formData.append("vdog_img",$("#vdog_img").val()); 

//alert(formData); 
//console.log(formData);  
			 $.confirm({
						title: '<?=$txt_vdo_add_cate;?>',
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
										/*$.post(action,formData,function(data){
											console.log(data);
											 });*/
										$.ajax({
											type: method,
											url: action,
											data: formData,
											async: false,
           									cache: false,
           									contentType: false,
            								processData: false,
											success: function (data) {	
											    //alert(data); 
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