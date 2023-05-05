<?php
session_start();
$client_id 		= 	$_SERVER['UNIQUE_ID'];
$client_secret 	= 	$_REQUEST['PHPSESSID'];
$_SESSION['EWT_CLIENT_ID']	=	$client_id;
$Auth_Key 		= 	base64_encode($_SESSION['EWT_CLIENT_ID']).":".base64_encode($client_secret);
$encoded_Auth_Key 	= 	$Auth_Key;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title> Login EasyWebTime 8.9 </title>
	<meta name="description" content="Bizpotential,Login EasyWebTime 8.9">
    <meta name="keywords" content="Bizpotential,Login EasyWebTime 8.9">
<!--===============================================================================================-->	
	<link rel="shortcut icon" type="image/icon" href="../EWT_ADMIN/images/logo_biz.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../EWT_ADMIN/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="../index.php" method="get" target="_self">
					<div class="text-center">
						<img src="images/EWT_logo.png" title="Logo" alt="Logo" class="img-fluid">
					</div>

					<span class="login100-form-title p-b-34">
						ระบบบริหารจัดการเว็บไซต์
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="EWT_User" placeholder="ชื่อผู้ใช้">
						<span for="EWT_User" class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="EWT_Password" placeholder="รหัสผ่าน">
						<span for="EWT_Password" class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					
					<!--
					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					-->
					
					<div class="text-center">
						<span id="recapt" class="text-left"></span>
						<!--
							<img src="images/ewt_pic.png" title="capcha" alt="capcha" class="img-fluid">
						-->
					</div>
					<div class="text-center">
						<a href="Func_ReCaptcha();"> คลิกที่นี่เพื่อเปลี่ยนรูปภาพ </a>
					</div>
					
					<div class="wrap-input100 validate-input" data-validate="Enter capcha">
						<input class="input100" type="text" name="chkpic" placeholder="capcha" required="required" autocomplete="off">
						<span for="chkpic" class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" onclick="JQLogin($('#form_main'));">
							เข้าสู่ระบบ
						</button>
					</div>

					<div class="text-center txt-contact">
						© สงวนลิขสิทธิ์ - บริษัท บิซโพเทนเชียล จำกัด .
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="../EWT_ADMIN/js/bootstrap.js"></script>
	<script type="text/javascript" src="../js/jquery-confirm-master/js/jquery-confirm.js"></script> 

	
<!--===============================================================================================-->
	<!-- <script src="vendor/jquery/jquery-3.2.1.min.js"></script> -->
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<!-- <script src="vendor/bootstrap/js/bootstrap.min.js"></script> -->
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../js/main.js"></script>
	
	
	<script>
	$(document).ready(function(){ 
		var txt = '<img src="captcha/captcha.php" class="captcha" >';
		$("#recapt").html(txt);	
		//genCapt();
	}); 

	function Func_ReCaptcha(){	
		var txt = '<img src="captcha/captcha.php" class="captcha">';
		$("#recapt").html(txt);
		//genCapt();
	}

	function genCapt(){
		$.ajax({
			url: "captcha/session-check.php",
			success: function (data) {	
			//console.log(data);
					 var usercaptchaval = $("#capt").val(data);				
			}	
		});	 
	} 

	function JQLogin(form){	

	var fail = CKSubmitData(form);
	if (fail == false) {	
		var action  = form.attr('action'); 
		var method  = form.attr('method'); 
		var formData = false;
			if (window.FormData){
				formData = new FormData(form[0]);
				} 
			
											$.ajax({
												type: method,
												url: action,					
												data: formData ? formData : form.serialize(),
												async: true,
												processData: false,
												contentType: false,
												success: function (data) {
													var Newdata= JSON.stringify(eval("("+data+")"));
													var Obj = jQuery.parseJSON(Newdata);											
													console.log(data);
													
													if(Obj.err){
														$.alert({
															title: 'Error',
															content: Obj.message,
															icon: 'fa fa-exclamation-circle',
															theme: 'modern',                          
															type: 'orange',
															closeIcon: false,						
															buttons: {
															close: {
															text: 'ปิด',
																btnClass: 'btn-orange',
																}
															}
														
														});		
													return false;													
													}
													if(Obj.warn){
														$.alert({
															title: 'Warning',
															content: Obj.message,
															icon: 'fa fa-exclamation-circle',
															theme: 'modern',                          
															type: 'orange',
															closeIcon: false,						
															buttons: {
															close: {
															text: 'ปิด',
																btnClass: 'btn-orange',
																}
															}
														
														});		
													return false;													
													}
													
													if(Obj.url){													
														window.location.href = Obj.url;													
														
													}											
												}
											});																																			
				/* $.confirm({
							title: '<?="ฟอร์มแจ้งเบาะแส";?>',
							content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
							//content: 'url:form.html',
							boxWidth: '30%',
							icon: 'far fa-question-circle',
							theme: 'modern',
							buttons: {
									confirm: {
										text: '',
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
													/*$.alert({
														title: '',
														theme: 'modern',
														content: 'บันทึกข้อมูลเรียบร้อย',
														boxWidth: '30%',
														onAction: function () {
															//self.location.href="complain_builder.php?com_fid="+data;			
															location.reload(true);			
															$('#box_popup').fadeOut();
														}		
													});*
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
							
							});*/
							
							
						} 
									
	}

	function Func_CheckNumber(valnum){	
		if (valnum !== "" && !$.isNumeric(valnum)) {
		return false;
		}else{
			return true;
		}	
	}

	function Func_CheckID(id){	
	//ตัดข้อความ - ออก
	var zid = id;
	var zids = zid.split("-");
	for(var i=0;i<zids.length;i++){
	 zids[i];
	}
	var pid = zids[0]+zids[1]+zids[2]+zids[3]+zids[4];

	if(pid.length != 13) return false;
	for(i=0, sum=0; i < 12; i++)
	sum += parseFloat(pid.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(pid.charAt(12)))
	return false; return true;
	}

	function CKSubmitData(form){
		
		var formid  = form.attr('id');
		var fail = false;
			var fail_log = '';
			$( '#'+formid ).find( 'select, textarea, input' ).each(function(){
				if( ! $( this ).prop( 'required' )){

				} else {
					if ( ! $( this ).val() ) {
						fail = true;
						var name = $( this ).attr( 'name' );
						var id = $( this ).attr( 'id' );
						//fail_log += name + id +" is required \n";
						var label = $("[for="+name+"]");
							text = $(label).text();
							//console.log(text);
				$( this ).focus();				
				$.alert({
							title: 'กรุณากรอกข้อมูล',
							content: text,
							icon: 'fa fa-exclamation-circle',
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

		}	
		
	var checklength = $( this ).hasClass("checklength");
	var checkmail   = $( this ).hasClass("checkmail");
	var checkidc    = $( this ).hasClass("checkidc");
	var checknumber = $( this ).hasClass("checknumber");
	var chkcaptcha  = $( this ).hasClass("chkcaptcha");
	var checktext   = $( this ).hasClass("checktext");
	//alert(s);

		
	if(chkcaptcha == true){	
		//genCapt();
		var chkpic =  $( this ).val();	
		var name = $( this ).attr('name');	
		var text = $("[for="+name+"]").text(); 
		var captcha =  $('#capt').val();		

		if(captcha != chkpic){		
		fail = true;	
					 $( this ).focus();	
						$.alert({
							title: 'กรุณากรอกข้อมูลใหม่อีกครั้ง ',
							content: text + '',
							icon: 'fa fa-exclamation-circle',
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
	}

	if(checklength == true) {
		
	var maxlength = $( this ).attr( 'maxlength' );		
	var minlength = $( this ).attr( 'minlength' );	
	var name = $( this ).attr( 'name' );	
	var text = $("[for="+name+"]").text();
			 if ($(this).val().length < minlength) {
				 
					 fail = true;	
					 $( this ).focus();	
						$.alert({
							title: 'กรุณากรอกข้อมูล ',
							content: text + ' ความยาวอย่างน้อย' + minlength + ' ตัวอักษร',
							icon: 'fa fa-exclamation-circle',
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
			 
			if ($(this).val().length > maxlength) {
				
				 fail = true;
				 $( this ).focus();	
						$.alert({
							title: 'กรุณากรอกข้อมูล ',
							content: text + ' ความยาวสูงสุด' + maxlength + ' ตัวอักษร',
							icon: 'fa fa-exclamation-circle',
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
		}
		

	if(checkmail == true) {
		
	var name = $( this ).attr( 'name' );	
	var text = $("[for="+name+"]").text();
	var email = $( this ).val();
	var regEx = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if($(this).val() != ""){ 
	 
		  var validEmail = regEx.test(email);
		  if (!validEmail) {
				 
					 fail = true;
					 $( this ).focus();	
						$.alert({
							title: 'กรุณากรอกข้อมูล ',
							content: text+' รูปแบบ E-mail ไม่ถูกต้อง ',
							icon: 'fa fa-exclamation-circle',
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
		}else{
			
	return true;	
		}

	}

	if(checkidc == true) {
		
	var name = $( this ).attr( 'name' );	
	var text = $("[for="+name+"]").text();
	var valID = $( this ).val();
		
	  if (!Func_CheckID(valID)) {
					fail = true;
					$( this ).focus();	
						$.alert({
							title: 'กรุณากรอกข้อมูล ',
							content: text+' ไม่ถูกต้อง ',
							icon: 'fa fa-exclamation-circle',
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
	}

	if(checknumber == true) {
		
	var name = $( this ).attr( 'name' );	
	var text = $("[for="+name+"]").text();
	var valnumber = $( this ).val();

	if (valnumber !== "" && !$.isNumeric(valnumber)) {	
					fail = true;
					$( this ).focus();	
						$.alert({
							title: 'กรุณากรอกข้อมูลเป็นตัวเลข',
							content: text+' ไม่ถูกต้อง ',
							icon: 'fa fa-exclamation-circle',
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
	}

	if(checktext == true) {
		
	var name = $( this ).attr( 'name' );	
	var text = $("[for="+name+"]").text();
	var valtext = $( this ).val();

			var pattern_en = '/^([a-zA-Z\s])+$/i';
			var pattern_th = '/^[ก-ฮ\s]+$/';
			
			
	var validvaltext = valtext.match(/[ก-ฮa-zA-Z]/g);
	if(!validvaltext) {	
					fail = true;
					$( this ).focus();	
						$.alert({
							title: 'กรุณากรอก',
							content: text+' ไม่ถูกต้อง กรอกได้เฉพาะตัวอักษรภาษาไทยและตัวอักษรภาษาอังกฤษเท่านั้น ',
							icon: 'fa fa-exclamation-circle',
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
	}
		
	});	

	return fail;	
			 
	}
	</script>

</body>
</html>