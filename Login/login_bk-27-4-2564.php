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
	<title>Login EasyWebTime 8.9</title>   
    <meta name="description" content="Bizpotential,Login EasyWebTime 8.9">
    <meta name="keywords" content="Bizpotential,Login EasyWebTime 8.9">
	<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet"> 
	<link rel="shortcut icon" type="image/icon" href="../EWT_ADMIN/images/logo_biz.png"/>
    <!-- Bootstrap & Styling-->
	<!-- bootstrap 3.3.7 -->
	<link href="../EWT_ADMIN/css/bootstrap.css" rel="stylesheet"/>
	<!-- END -->

	<!-- Main Style -->
    <!--link(rel="stylesheet", href="css/bootstrap/bootstrap-grid.min.css")-->
    <!--link(rel="stylesheet", href="css/bootstrap/bootstrap-reboot.min.css")-->
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/style.css">
	<!-- font-awesome Style -->
	<link rel="stylesheet" href="../EWT_ADMIN/assets/css/font-awesome/css/all.css"/>
	<!-- END -->
	<!-- animate Style -->
	<link rel="stylesheet" href="../EWT_ADMIN/assets/css/animate.min.css"/>
	<!-- END -->

	<link rel="stylesheet" type="text/css" href="../js/jquery-confirm-master/css/jquery-confirm.css"/>


    <!--HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries-->
    <!--[if lt IE 9]
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    [endif]-->
  </head>
  <body>
    <!--Header-->
    <section class="login">
      <div class="container">
		<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="text-center">
						<a href="index.php">
						<img src="../images/logo.png" alt="logo"> 
						</a>
						</div>
						<div class="text-center">
						<h2 style="color:#FFFFFF;">สำนักงานคณะกรรมการการแข่งขันทางการค้า </h2>
						<h2 style="color:#FFFFFF;">OFFICE OF TRADE COMPETITION COMMISSION</h2>
						</div>
					</div>
		</div>
        <div class="box-wrapper">		
          <div class="box box-border">
            <div class="box-body">
			<form id="form_main" name="form_main" method="POST" action="process.php" enctype="multipart/form-data" >
				<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
					<label for="EWT_User"  style="color:#FFFFFF;">Username</label>
					<input class="form-control" type="text" name="EWT_User" required />
					</div>
					<div class="form-group">
					<label for="EWT_Password" class="fw" style="color:#FFFFFF;">Password <!--<a class="pull-right" style="color:#FFFFFF;" href="forgot.php">ลืมรหัสผ่าน??</a>--></label>
					<input class="form-control" type="password" name="EWT_Password" required />
					</div>
			
					<div class="form-group " style="padding-top:10px;">				
                    <div class="col-md-10 col-sm-10 col-xs-10 text-left" >
					<span id="recapt" class="text-left"></span>
					</div>
                    <div class="col-md-2  col-sm-2 col-xs-2">
                      <span class="btn btn-warning text-white" onclick="Func_ReCaptcha();">
					  <i class="fas fa-sync-alt"></i>
					  </span>				  
                    </div>												
					</div>
					<div class="form-group" >	
					<label for="chkpic"   style="color:#FFFFFF;">กรอกตัวเลขตามภาพที่ปรากฎ </label>						
					<input class="form-control " type="text" name="chkpic" id="chkpic" required="required" autocomplete="off" />
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">	
					<div class="title-line"></div>
					<div class="form-group text-right">
					<button class="btn btn-success" onclick="JQLogin($('#form_main'));" type="button"><i class="fas fa-sign-in-alt"></i> Login</button>
					</div>
					
					<!--<a class="pull-right" href="login.php">Reset</a>-->
					<input type="hidden" name="proc" value="login" />
					<input type="hidden" name="capt" id="capt"  value="" />						
		            <input type="hidden" name="requesttoken" value="<?=$encoded_Auth_Key;?>" />	
					<input type="hidden" name="<?php echo SHA1(session_id()); ?>" value="1" />
				</div>
				</div>
				</form>      
    </div>
	</div>					
    </div>

	<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="text-center " style="color:#FFFFFF;">
	© Copyright © 2019, BizPotential.com - All Rights Reserved.
	</div>
	</div>
	</div>	
    </section>
    <!--Footer-->
  </body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../EWT_ADMIN/js/bootstrap.js"></script>
<script type="text/javascript" src="../js/jquery-confirm-master/js/jquery-confirm.js"></script> 

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
</html>