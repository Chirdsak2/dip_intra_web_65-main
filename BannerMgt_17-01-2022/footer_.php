<!-- END CONTAINER  -->
<div id="box_popup" class="layer-modal"></div>
</div>
	
<div  style="padding-bottom:30px;"></div>

<?php include("../EWT_ADMIN/panel-footer.php");?>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?=$IMG_PATH;?>js/bootstrap.js"></script>

<script type="text/javascript" src="../js/jquery-confirm-master/js/jquery-confirm.js"></script>

<link rel="stylesheet" href="../js/bootstrap-datepicker/css/bootstrap-datepicker.css" />
<link rel="stylesheet" href="../js/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

<script src="../js/bootstrap-datepicker/js/bootstrap-datepicker-custom.js"></script>
<script src="../js/bootstrap-datepicker/locales/bootstrap-datepicker.th.min.js"></script>
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
});
</script>

<!-- Counter -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/waypoints.js"></script>
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/jquery.counterup.js"></script>

<!-- Slick Slider -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/slick.js"></script> 
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>
<script>
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
function JQSetIntro(id,proc){
	if(proc == 'SetIntro'){
		var con = 'คุณต้องการตั้งค่ารายการนี้หรือไม่?';
	}else if(proc == 'UnSetIntro'){
		var con = 'คุณต้องยกเลิกการตั้งค่ารายการนี้หรือไม่?';
	}
	
	
					$.confirm({
						title: 'ตั้งค่า Popup Intro',
						content: con,
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-question-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการตั้งค่า',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_set_intro.php',
											data:{'id': id,'proc':proc},
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
                            type: 'blue'
						
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
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
	
});
</script>