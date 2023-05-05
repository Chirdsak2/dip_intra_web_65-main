$(document).ready(function(){
	var txt = '<img src="popup/assets/captcha/captcha.php" style="border-color:#FFFF;width:180px;height:60px;" >';
	$("#recapt").html(txt);	
	//$("#recapt").after('<input class="form-control chkcaptcha" type="hidden" name="capt" id="capt" required="required" autocomplete="off" />');
	genCapt();
}); 
 
function Func_ReCaptcha(){	
	var txt = '<img src="popup/assets/captcha/captcha.php" style="border-color:#FFFF;width:180px;height:60px;" >';
	$("#recapt").html(txt);
	genCapt();
}	

function genCapt(){
	$.ajax({
		url: "popup/assets/captcha/session-check.php",
        success: function (data) {	
			$("#capt").val(data);				
		}	
	});	 
}
$("#chkpic").click(function (e){
    genCapt();
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
 
function JQAdd_Faq_Q(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'ส่งคำถาม',
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
														//self.location.href="complain_builder.php?com_fid="+data;			
														//location.reload(true);			
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

function JQAdd_Faq_Tall(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'Tell a friend',
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
														//self.location.href="complain_builder.php?com_fid="+data;			
														//location.reload(true);			
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
function JQAdd_GalCate_Tall(form){	

	var fail = CKSubmitData(form);
	if (fail == false) {
		var action  = form.attr('action'); 
		var method  = form.attr('method'); 
		var formData = false;
		if (window.FormData){
			formData = new FormData(form[0]);
		} 														
		$.confirm({
			title: 'Tell a friend',
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
										//self.location.href="complain_builder.php?com_fid="+data;			
										//location.reload(true);			
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
function JQAdd_GalCate_Comment(form){	

	var fail = CKSubmitData(form);
	if (fail == false) {
		var action  = form.attr('action'); 
		var method  = form.attr('method'); 
		var formData = false;
		if (window.FormData){
			formData = new FormData(form[0]);
		} 														
		$.confirm({
			title: 'แสดงความคิดเห็น',
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
										//self.location.href="complain_builder.php?com_fid="+data;			
										//location.reload(true);
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

function JQAdd_Poll(form){
	if($('input[name=a_id]').is(':checked') == false){
		$.alert({
			title: 'กรุณากรอกข้อมูล',
			content: 'เลือกคำตอบ',
			//icon: 'fa fa-exclamation-circle',
			theme: 'modern',                          
			type: 'orange',
			closeIcon: false,						
			buttons: {
				close: {
					 text: 'ปิด',
						btnClass: 'btn-orange',
					}
				},						
		});		
		return false;
	}
	var fail = CKSubmitData(form);
	if (fail == false) {
		var action  = form.attr('action'); 
		var method  = form.attr('method'); 
		var formData = false;
		if (window.FormData){
			formData = new FormData(form[0]);
		} 
		if($('#status_poll').val() == 'Y'){
			$.alert({
				title: '',
				theme: 'modern',
				content: 'คุณได้ทำแบบสำรวจแล้ว ไม่สามารถทำแบบสำรวจใหม่ได้ในเวลานี้',
				boxWidth: '30%',
				onAction: function () {	
					$('#box_popup').fadeOut();
				}		
			});
		}else{
			
		
			$.confirm({
				title: 'สำรวจความคิดเห็น',
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
											$('#box_popup').fadeOut();
										}		
									});
								}
							});																										
						}
					},
					cancel: {
						text: 'ยกเลิก',
							action: function () {	
						}									
					}
				},                          
				animation: 'scale',
				type: 'blue'
			});
		}
	}						
}

function JQAdd_Cal_Registor(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'ลงทะเบียนเข้าร่วม',
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
														//self.location.href="complain_builder.php?com_fid="+data;			
														//location.reload(true);			
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
function JQDel_Webbord_Comment(form){	

	var fail = CKSubmitData(form);
	if (fail == false) {
		var action  = form.attr('action'); 
		var method  = form.attr('method'); 
		var formData = false;
		if (window.FormData){
			formData = new FormData(form[0]);
		} 														
		$.confirm({
			title: 'แจ้งลบความคิดเห็น',
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
										
										location.reload(true);													
										$('#box_popup').fadeOut();
									}		
								});
								
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
function JQWebbord_Vote(form){	

	var fail = CKSubmitData(form);
	if (fail == false) {
		var action  = form.attr('action'); 
		var method  = form.attr('method'); 
		var formData = false;
		if (window.FormData){
			formData = new FormData(form[0]);
		} 														
		$.confirm({
			title: 'โหวตความคิดเห็น',
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
										
										location.reload(true);													
										$('#box_popup').fadeOut();
									}		
								});
								
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