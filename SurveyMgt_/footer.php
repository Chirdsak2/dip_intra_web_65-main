
</div>
</div>

<div  style="padding-bottom:50px;"></div>
<footer class="footer panel-footer fix navbar-fixed-footer">
<div class="container">
<p>© Copyright © 2017, BizPotential.com - All Rights Reserved.</p>
</div>
</footer>
<a href="#" class="scrollup" style="display: none;"><span class="glyphicon glyphicon-circle-arrow-up scrollup-icon"></span></a>	

<script src="<?=$IMG_PATH;?>js/jquery-3.1.0.js"></script> 
<script src="<?=$IMG_PATH;?>js/bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
			
			$(window).scroll(function(){
				if ($(this).scrollTop() > 100) {
					$('.scrollup').fadeIn();
					
				} else {
					$('.scrollup').fadeOut();
				}
					
			}); 			
			$('.scrollup').click(function(){
				$("html, body").animate({ scrollTop: 0 }, 600);
				return false;
			});	
			
			setTimeout( function() { 			
						$('.scrollup').fadeOut();			
					} , 5000 );
					
					
    $('[data-toggle="tooltip"]').tooltip(); 

	$('.numberint').keypress(function (event) {
            return isNumberInt(event, this)
      });
				
					
});

</script>
<script type="text/javascript" src="../js/jquery-confirm-master/js/jquery-confirm.js"></script> 	
<!-- Slick Slider -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/slick.js"></script> 
<!-- Custom js -->
<script>

function isNumberInt(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            //(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            //(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    
	
function JQDelete(id){
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-exclamation-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_vdo.php',
											data:{'id': id,'proc':'DelVdo'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'url:text.html',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: 'ตกลง',
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
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}

function JQEdit_s(){	
var s_id = $("#s_id").val();
var name = $("#name").val();
var des = $("#des").val();
var proc = $("#proc").val();

					$.confirm({
						title: 'แก้ไขส่วนหัวข้อ',
						content: 'คุณต้องการบันทึกการแก้ไขนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: '	glyphicon glyphicon-question-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการแก้ไข',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_edit_s.php',
											data:{'s_id': s_id,'name': name,'des': des,'proc':proc},
											success: function (data) {
												$('#box_popup').fadeOut();
												//location.reload();	
												//$("#frm_edit_s").load();
												$("#frm_edit_s").load(location.href + " #frm_edit_s");
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
                   // });
}

function JQEdit(){	

var path = $("#path").val();
var name = $("#name").val();
var des = $("#des").val();
var pa = $("#pa").val();
var proc = $("#proc").val();

			  $.confirm({
						title: '<?=$lang_add3_edititem;?>'+' '+pa,
						content: 'คุณต้องการบันทึกการแก้ไขนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: '	glyphicon glyphicon-question-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการแก้ไข',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_edit.php',
											data:{'path': path,'name': name,'des': des,'pa':pa,'proc':proc},
											success: function (data) {
												$('#box_popup').fadeOut();
												//location.reload();	
												//$("#frm_edit_s").load();
												$("#frm_edit_s").load(location.href + " #frm_edit_s");
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
                   // });
}

function JQa_Edit(){	

var path = $("#path").val();
var name = $("#name").val();
var des = $("#des").val();
var proc = $("#proc").val();
var pa = $("#pa").val();

			  $.confirm({
						title: '<?=$lang_add3_edititem;?>'+' '+pa,
						content: 'คุณต้องการบันทึกการแก้ไขนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: '	glyphicon glyphicon-question-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการแก้ไข',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_a_edit.php',
											data:{'path': path,'name': name,'des': des,'proc':proc},
											success: function (data) {
												$('#box_popup').fadeOut();
												//location.reload();	
												//$("#frm_edit_s").load();
												$("#frm_edit_s").load(location.href + " #frm_edit_s");
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
                   // });
}

function JQEdit_Question(){	

var qid = $("#qid").val();
var pos = $("#pos").val();
var name = $("#name").val();
var proc = $("#proc").val();
var ch = $("#ch").val();
var no_replate = $("input:checkbox[name=no_replate]:checked").val();
var just = $("input:checkbox[name=just]:checked").val();
var email_data = $("input:radio[name=email_data]:checked").val();
//var email_data = $("#email_data").val();

			  $.confirm({
						title: '<?=$lang_survey_edit_question; ?>'+' '+pos,
						content: 'คุณต้องการบันทึกการแก้ไขนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: '	glyphicon glyphicon-question-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการแก้ไข',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_edit_question.php',
											data:{'qid': qid,'pos': pos,'name': name,'ch': ch,'just':just,'no_replate':no_replate,'email_data': email_data,'proc':proc},
											success: function (data) {
												$('#box_popup').fadeOut();
												//location.reload();	
												//$("#frm_edit_s").load();
												$("#frm_edit_s").load(location.href + " #frm_edit_s");
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
                   // });
}

function JQAdd(){	

var pa = $("#pa").val();
var name = $("#name").val();
var des = $("#des").val();
var proc = $("#proc").val();
var num = $("#num").val();
var s_id = $("#s_id").val();
var sel = $("#sel").val();
var gr = $("input:radio[name=gr]:checked").val();


			  $.confirm({
						title: 'เพิ่มส่วนใหม่',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: '	glyphicon glyphicon-question-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_add.php',
											data:{'pa': pa,'name': name,'des': des,'num': num,'s_id': s_id,'sel': sel,'gr': gr,'proc':proc},
											success: function (data) {
												$('#box_popup').fadeOut();
												//location.reload();	
												//$("#frm_edit_s").load();
												$("#frm_edit_s").load(location.href + " #frm_edit_s");
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
                   // });
}


function JQAdd_question(){	

var type = $("#type").val();

if(type == 'N'){
	
var ch = $("#ch").val();
var name = $("#name").val();
var sel = $("#sel").val();
var num = $("#num").val();
var pos = $("#pos").val();
var just = $("input:checkbox[name=just]:checked").val();

var email_data = $("input:radio[name=email_data]:checked").val();
var no_replate = $("#no_replate").val();
var path = $("#path").val();
var proc = $("#proc").val();

}
if(type == 'Y'){
	
var ch = $("#ch").val();
var name = $("#name").val();
var pos = $("#pos").val();
var just = $("input:checkbox[name=just]:checked").val();
var path = $("#path").val();
var proc = $("#proc").val();	

var all = $("#all").val();

var ans = [];
var weight = [];

for(var i=0; i < all; i++){

	ans.push($("#ans"+i).val());
	weight.push($("#weight"+i).val());
}

	
}

if(type == 'N'){
	
var dataString = {'ch': ch,'name': name,'sel': sel,'num': num,'pos': pos,'just': just,'email_data': email_data,'no_replate': no_replate,'path': path,'proc':proc};

}else if(type == 'Y'){
	
var	dataString = {'ch': ch,'name': name,'pos': pos,'just': just,'proc':proc,'path':path,'all':all,'ans':ans,'weight':weight};

}

console.log(dataString);
console.log(weight);

			  $.confirm({
						title: 'เพิ่มคำถาม',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-question-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_add_question.php',					
											//data:{'ch': ch,'name': name,'sel': sel,'num': num,'pos': pos,'just': just,'email_data': email_data,'no_replate': no_replate,'path': path,'proc':proc},
											data: dataString,
											success: function (data) {
												$('#box_popup').fadeOut();
												//location.reload();	
												//$("#frm_edit_s").load();
												$("#frm_edit_s").load(location.href + " #frm_edit_s");
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
                   // });
}

function JQAdd_survey1(){	
	
var topic = $("#topic").val();
var date_start = $("#date_start").val();
var date_last = $("#date_last").val();
var error_page = $("#error_page").val();
var end_page = $("#end_page").val();
var file_page = $("#file_page").val();
var mail_data = $("#mail_data").val();

var proc = $("#proc").val();

if(topic == ""){			
			var Data = 'หัวข้อแบบฟอร์ม';			
			$("#topic").focus();
			$.alert({
						title: 'กรุณากรอกข้อมูล',
						content: Data,
						icon: 'glyphicon glyphicon-exclamation-sign',
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
if(date_start == ""){			
			var Data = 'วันเริ่มต้น';			
			$("#date_start").focus();
			$.alert({
						title: 'กรุณากรอกข้อมูล',
						content: Data,
						icon: 'glyphicon glyphicon-exclamation-sign',
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
if(date_last == ""){			
			var Data = 'วันสิ้นสุด';			
			$("#date_last").focus();
			$.alert({
						title: 'กรุณากรอกข้อมูล',
						content: Data,
						icon: 'glyphicon glyphicon-exclamation-sign',
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

			  $.confirm({
						title: 'เพิ่มแบบฟอร์ม',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-question-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_add_survey1.php',					
											data:{'topic': topic,'date_start': date_start,'date_last': date_last,'error_page': error_page,'end_page': end_page,'file_page': file_page,'mail_data': mail_data,'proc':proc},
											success: function (data) {
												//alert("Data Save: " + data);
												setTimeout(function(){
													    window.location.href="edit_survey.php?s_id="+ data;
													
												}, 1000);
												//$('#box_popup').fadeOut();
												//location.reload();
												//boxPopup('<?=linkboxPopup();?>pop_add_survey2.php');

												$("#frm_edit_s").load(location.href + " #frm_edit_s");
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
                   // });
}


function JQApprove_Survey(id){	

			  $.confirm({
						title: 'อนุมัติแบบสอบถาม',
						content: 'คุณต้องการอนุมัติแบบสอบถามนี้หรือไม่ ',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการอนุมัติ',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_approve_survey.php',					
											data:{'id': id,'proc':'ApproveSurvey'},						
											success: function (data) {
												$.alert({
													title: '',
													content: 'url:text_approve.html',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: 'ตกลง',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
                   // });
}

function JQDelete_Survey(id){
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_delete_survey.php',
											data:{'id': id,'proc':'DelSurvey'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'url:text.html',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: 'ตกลง',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
													
											}
										});											
																							
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}


function boxPopup(link)
  {
    $.ajax({
      type: 'GET',
      url: link,
      beforeSend: function() {
        $('#box_popup').html('');
      },
      success: function (data) {
        $('#box_popup').html(data);
      }
    });
    $('#box_popup').fadeIn();
  }

</script>
<!-- Slick Slider -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/slick.js"></script> 
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>