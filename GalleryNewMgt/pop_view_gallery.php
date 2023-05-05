<?php
include("../EWT_ADMIN/comtop_pop.php");

$sql_de = $db->query("SELECT gallery_image.*,gallery_cat_img.category_id FROM gallery_image LEFT JOIN gallery_cat_img ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_image.img_id = '{$_GET['id']}'");
$num_de = $db->db_num_rows($sql_de);
$DE = $db->db_fetch_array($sql_de);

$sql_ment = $db->query("SELECT gallery_comment.* FROM gallery_comment LEFT JOIN gallery_image ON gallery_comment.img_id = gallery_image.img_id WHERE gallery_comment.img_id = '{$_GET['id']}'");
$num_ment = $db->db_num_rows($sql_ment);
?>




<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title">รายละเอียดภาพ</h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >

<div class="panel-body text-center">
	<img src = "../ewt/otcc_web/<?php echo $DE['img_path_s'];?>" width = "150" height = "150">
</div>

<div class="panel-body text-left">
<label for="gal_detail" class="col-sm-12 control-label"><b>ชื่อ</span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php echo $DE['img_name'];?>
</div>
</div>

<div class="panel-body text-left">
<label for="gal_detail" class="col-sm-12 control-label"><b>ความนิยม</span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php echo $DE['img_vote'];?> คะแนน
</div>
</div>

<div class="panel-body text-left">
<label for="gal_detail" class="col-sm-12 control-label"><b>ความคิดเห็น (<?php echo $num_ment;?>)</span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php if($num_ment>0){ $i=1; ?>
<?php while($MENT = $db->db_fetch_array($sql_ment)){?>
ความคิดเห็นที่  : <?php echo $i;?><br>
คุณ : <?php echo $MENT['name'];?> (<?php echo $MENT['com_date'];?>)<br>
<?php echo str_replace("\n","<br>",$MENT['comment'])?><p>
<?php $i++; } ?>
<?php }else{ ?>
ไม่มีความคิดเห็น
<?php } ?>
</div>
</div>



</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="$('#box_popup').fadeOut();" type="button" class="btn btn-success  btn-ml " >
<i class="far fa-times-circle fa-1x"></i>&nbsp;ปิด
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 

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
 
function JQAdd_Gallery(form){	

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
