<?php
include("../EWT_ADMIN/comtop_pop.php");

$db->query("USE ".$EWT_DB_USER);

$_GET['ug'] = $_SESSION["EWT_SUID"];

?>

<form id="form_main" name="form_main" method="POST" action="func_set_permission_addorg" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add">
<input name="ug" type="hidden" id="ug" value="<?php echo $_GET['ug']; ?>">

<div class="container" id="frm_edit_s">   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">    
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white">
 <?php echo "เพิ่มกลุ่ม";?></h4>
</div>

<div class="modal-body">
	<div class="card ">
	
			<div class="card-body" >

				<div class="col-lg-12 row" style="margin-bottom:20px;">
					<div style="margin-bottom:8px;">
						<div><label for="group_name"><b>ชื่อกลุ่ม:</b></label></div>
						<div><input class="form-control" type="text" id="group_name" name="group_name" value=""></div>
					</div>
					
					<div align="center" style="margin-top:20px;padding:15px;">
						<button onclick="JQAdd_Permission_user($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
							<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>
						</button>
					</div>
				</div>

				<table class="table table-bordered">
					<thead>
						<tr class="text-center ">
							<th class="text-center" >ชื่อกลุ่ม</th>
						</tr>
					</thead>
					<tbody id="search_genuser_area">
						
					</tbody>  
				</table>
			</div>	
	</div>
</div>		
</div>
</div>
</div>	 
</form>

<!-- ----------------------------------------------------------------------------------------------- -->

<script> 
$(document).ready(function() {
	$('.chk').change(function () {
		var name  = $(this).attr('name'); 
		$('input:checkbox[name='+name+']').prop('checked',$(this).prop('checked'));	
		
		if($( this ).is(':checked') == true){
		//$('input:checkbox').is(':checked').attr("disabled",true);
		$('input:checkbox').attr("disabled",true);
		$( this ).attr("disabled",false);
			}else if($( this ).is(':checked') == false){
				$('input:checkbox').attr("disabled",false);
			}
		
	});
 });

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

function JQAdd_Permission_user(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 	
//alert(form.serialize());  
			 $.confirm({
						title: '<?php echo "คุณต้องการบันทึกข้อมูลนี้หรือไม่";?>',
						// content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
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
												//console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
													self.location.href="permission_builder_user.php?mid="+data+"&mtype=<?php echo url_encode('U');?>";			
														//location.reload(true);	
														//$("#frm_edit_s").load(location.href + " #frm_edit_s");
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

function search_genuser(){
	$("#search_genuser_area").html("");
	var fullname = $("#fullname").val();
	var username = $("#username").val();

	$("#search_genuser_area").html('<tr align="center" bgcolor="#FFFFFF">'+ 
                                   '<td height="40" colspan="2"><font color="#0ed145">..กำลังดำเนินการ..</font></td>'+
                                   '</tr>');
	
	$.ajax({  
		url:"search_genuser_process.php",  
		method:"post",  
		data: {fullname:fullname,username:username},
		success:function(data){
			setTimeout(function(){
				$("#search_genuser_area").html(data);
			}, 1000);
		}
    })
}

</script>