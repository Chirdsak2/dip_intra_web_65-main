<!-- Java Script
================================================== -->

<div id="box_popup1" class="layer-modal"></div>
<div id="box_popup" class="layer-modal"></div>
<div id="loader" class="loader"></div>

</body>

</html>
<style>
	/* .jconfirm-box{
	width: 30%;
} */

	@media(min-width: 400px) and (max-width: 991px) {
		.jconfirm-box {
			width: 300px !important;
		}
	}

	@media(min-width: 1px) and (max-width: 399px) {
		.jconfirm-box {
			width: 250px !important;
		}
	}

	/* .layer-modal{
	z-index:1000; 
	display:none;
	padding-top:10px;
	position:fixed;
	left:0;
	right:0;
	top:0;
	width:100%;
	height:100vh;
	overflow: auto;
	background-color:rgb(0,0,0);
    background-color:rgba(255,255,255,0.9);
}
.panel {
    margin-bottom: 0px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
}
.panel-body {
    padding: 10px;
}
.loader {  
	display:none;
	position: fixed;  
	top: 0px;   
	left: 0px;  
	background: #ccc;   
	width: 100%;   
	height:100vh;
	opacity: .85;   
	filter: alpha(opacity=85);   
	-moz-opacity: .85;  
	z-index: 9999;
	background: #fff url(https://assets.materialup.com/uploads/fa8430a1-4dea-49d9-a4a3-e5c6bf0b2afb/preview.gif
) 50% 50% no-repeat;
 }
.modal-content { 
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(255, 255, 255, 0.1); 
    border-radius: 0.6rem; 
    outline: 0;
	box-shadow: 0 12px 28px 0 rgb(0 0 0 / 25%),0 2px 4px 0 rgb(0 0 0 / 15%),inset 0 0 0 1px rgb(0 0 0 / 15%);  
}
.icon-post{
	display: block;
    background-color: #FFFFFF;
    background-repeat: no-repeat;
    background-size: 18px 18px;
    background-position: center;
    height: 4.5rem;
    width: 4.5rem;
    line-height: 6rem;
    border-radius: 50%;
}
.icon-post:hover{
	display: block;
    background-color: #F5F5F5;
    background-repeat: no-repeat;
    background-size: 18px 18px;
    background-position: center;
    height: 4.5rem;
    width: 4.5rem;
    line-height: 6rem;
    padding: 0;
    margin: 0;
    border-radius: 50%;
    box-shadow: 0 2px 3px rgb(0 0 0 / 35%);
}
textarea.comment-ff {
     min-height: 10rem; 
}	  */
</style>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript">
	function boxPopup(link) {
		$.ajax({
			type: 'GET',
			url: link,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}
		});
		$('#box_popup').fadeIn();
	}

	function boxPopup1(link) {
		$.ajax({
			type: 'GET',
			url: link,
			beforeSend: function() {
				$('#box_popup1').html('');
			},
			success: function(data) {
				$('#box_popup1').html(data);
			}
		});
		$('#box_popup1').fadeIn();
	}

	function SubmitForm(form) {

		var action = form.attr('action');
		var method = form.attr('method');
		var formid = form.attr('id');
		var temp = '1';
		var fail = false;
		$('#' + formid).find('select, textarea, input').each(function() {

			//$('#DUP_'+$( this ).attr( 'id' )+'_ALERT').hide(); 	  	

			if (!$(this).prop('required')) {

			} else {
				//alert(genCapt());
				var chkcaptcha = $(this).hasClass("chkcaptcha");
				var Base64 = {
					_keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
					encode: function(e) {
						var t = "";
						var n, r, i, s, o, u, a;
						var f = 0;
						e = Base64._utf8_encode(e);
						while (f < e.length) {
							n = e.charCodeAt(f++);
							r = e.charCodeAt(f++);
							i = e.charCodeAt(f++);
							s = n >> 2;
							o = (n & 3) << 4 | r >> 4;
							u = (r & 15) << 2 | i >> 6;
							a = i & 63;
							if (isNaN(r)) {
								u = a = 64
							} else if (isNaN(i)) {
								a = 64
							}
							t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a)
						}
						return t
					},
					decode: function(e) {
						var t = "";
						var n, r, i;
						var s, o, u, a;
						var f = 0;
						e = e.replace(/[^A-Za-z0-9\+\/\=]/g, "");
						while (f < e.length) {
							s = this._keyStr.indexOf(e.charAt(f++));
							o = this._keyStr.indexOf(e.charAt(f++));
							u = this._keyStr.indexOf(e.charAt(f++));
							a = this._keyStr.indexOf(e.charAt(f++));
							n = s << 2 | o >> 4;
							r = (o & 15) << 4 | u >> 2;
							i = (u & 3) << 6 | a;
							t = t + String.fromCharCode(n);
							if (u != 64) {
								t = t + String.fromCharCode(r)
							}
							if (a != 64) {
								t = t + String.fromCharCode(i)
							}
						}
						t = Base64._utf8_decode(t);
						return t
					},
					_utf8_encode: function(e) {
						e = e.replace(/\r\n/g, "\n");
						var t = "";
						for (var n = 0; n < e.length; n++) {
							var r = e.charCodeAt(n);
							if (r < 128) {
								t += String.fromCharCode(r)
							} else if (r > 127 && r < 2048) {
								t += String.fromCharCode(r >> 6 | 192);
								t += String.fromCharCode(r & 63 | 128)
							} else {
								t += String.fromCharCode(r >> 12 | 224);
								t += String.fromCharCode(r >> 6 & 63 | 128);
								t += String.fromCharCode(r & 63 | 128)
							}
						}
						return t
					},
					_utf8_decode: function(e) {
						var t = "";
						var n = 0;
						var r = c1 = c2 = 0;
						while (n < e.length) {
							r = e.charCodeAt(n);
							if (r < 128) {
								t += String.fromCharCode(r);
								n++
							} else if (r > 191 && r < 224) {
								c2 = e.charCodeAt(n + 1);
								t += String.fromCharCode((r & 31) << 6 | c2 & 63);
								n += 2
							} else {
								c2 = e.charCodeAt(n + 1);
								c3 = e.charCodeAt(n + 2);
								t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63);
								n += 3
							}
						}
						return t
					}
				}

				if (chkcaptcha == true) {

					var chkpic = $(this).val();
					var name = $(this).attr('name');
					var id = $(this).attr('id');
					var text = $("[for=" + name + "]").text();
					var captcha = Base64.decode($('#capt').val());

					if (captcha != chkpic) {

						//fail = true;	
						$(this).focus();

						if (temp == 1) {
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
							//return false;
						} else if (temp == '2') {
							//$('#'+id).addClass('bsf-error');
							//$('#'+id).removeClass('form-control');
							//$('#DUP_'+id+'_ALERT').show();
							//$('#DUP_'+id+'_ALERT').html('<small  class="form-text text-danger"> กรุณากรอกข้อมูล ' + text + '</small>');	
							//$('#DUP_'+id+'_ALERT').fadeOut(5000);			
						}
						//return false;					

					}
				}

				var checkusername = $(this).hasClass("checkusername");

				if (checkusername == true) {
					var maxlength = $(this).attr('maxlength');
					var minlength = '8';
					var name = $(this).attr('name');
					var text = $("[for=" + name + "]").text();
					var username = $(this).val();
					//var chkStr = /^\s*[a-zA-Z0-9,\s]+\s*$/; //Pattern ตรวจสอบการกรอกตัวอักษร 8-16 ตัวอักษร 
					var chkStrName = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/; //Pattern ตรวจสอบการกรอกตัวอักษร 8-16 ตัวอักษร
					var validUsername = chkStrName.test(username);

					if ($(this).val() != '') {
						if (validUsername) {


						} else {
							fail = true;
							$(this).focus();
							$.alert({
								title: 'กรุณากรอกข้อมูล ',
								content: text + '  กรอกข้อมูลเป็นภาษาอังกฤษตัวพิมพ์ใหญ่ตัวพิมพ์เล็กและตัวเลข  ' + minlength + ' - ' + maxlength + ' ตัวอักษร',
								icon: 'fa fa-exclamation-circle',
								theme: 'modern',
								type: 'orange',
								animation: 'scale',
								closeAnimation: 'scale',
								buttons: {
									close: {
										text: 'ปิด',
										btnClass: 'btn-orange',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});
							return false;
						}

					} else {
						fail = true;
						$(this).focus();

						if (temp == 1) {
							$.alert({
								title: 'กรุณากรอกข้อมูล',
								content: text,
								icon: 'fa fa-exclamation-circle',
								theme: 'modern',
								type: 'orange',
								animation: 'scale',
								closeAnimation: 'scale',
								buttons: {
									close: {
										text: 'ปิด',
										btnClass: 'btn-orange',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});
						} else if (temp == '2') {
							$('#' + id).addClass('bsf-error');
							$('#' + id).removeClass('form-control');
							$('#DUP_' + id + '_ALERT').show();
							$('#DUP_' + id + '_ALERT').html('<small  class="form-text text-danger"> กรุณากรอกข้อมูล ' + text + '</small>');
							//$('#DUP_'+id+'_ALERT').fadeOut(5000);
						}
						return false;
					}
				}

				if ($(this).is("select")) { //select

					var name = $(this).attr('name');
					var id = $(this).attr('id');
					var label = $("[for=" + name + "]");
					var text = $(label).text();

					if ($(this).val() == '' || $(this).val() == null) {

						fail = true;
						$(this).focus();
						if (temp == 1) {
							$.alert({
								title: 'กรุณาเลือก',
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
								onAction: function() {

								},
								columnClass: 'medium',
							});
						} else if (temp == '2') {
							$('#' + id).addClass('bsf-error');
							$('span[aria-labelledby="select2-' + id + '-container"]').addClass('bsf-sel-error');
							$('#' + id).removeClass('form-control');
							$("#" + name + "_BSF_AREA.col-md-3").append('<small id="DUP_' + id + '_ALERT" class="form-text text-danger" style="display:none;"  ></small>');
							$('#DUP_' + id + '_ALERT').show();
							$('#DUP_' + id + '_ALERT').html('<small  class="form-text text-danger"> กรุณาเลือก ' + text + '</small>');
							//$('#DUP_'+id+'_ALERT').fadeOut(5000);							
						}
						return false;
					} else {

					}

				} else if ($(this).is("[type=radio]")) { //type=radio	

					var name = $(this).attr('name');
					var id = $(this).attr('id');
					if ($("input:radio[name=" + name + "]").is(':checked') == false) {
						fail = true;
						var label = $("[for=" + name + "]");
						var text = $(label).text();
						//console.log(text);
						$(this).focus();
						if (temp == 1) {
							$.alert({
								title: 'กรุณาเลือก',
								content: text,
								icon: 'fa fa-exclamation-circle',
								theme: 'modern',
								type: 'orange',
								animation: 'scale',
								closeAnimation: 'scale',
								buttons: {
									close: {
										text: 'ปิด',
										btnClass: 'btn-orange',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});
						} else if (temp == '2') {
							$('#' + id).addClass('bsf-error');
							$('#' + id).removeClass('form-control');
							$("#" + name + "_BSF_AREA .form-radio").append('<small id="DUP_' + id + '_ALERT" class="form-text text-danger" style="display:none;"  ></small>');
							$('#DUP_' + id + '_ALERT').show();
							$('#DUP_' + id + '_ALERT').html('<small  class="form-text text-danger"> กรุณาเลือก ' + text + '</small>');
							//$('#DUP_'+id+'_ALERT').fadeOut(5000);
						}
						return false;

					} else if ($("input:radio[name=" + name + "]").is(':checked') == true) {
						$('#DUP_' + id + '_ALERT').hide();
					}


				} else if ($(this).is("[type=file]")) { //type=file		

					var name = $(this).attr('name');
					var id = $(this).attr('id');
					var label = $("[for=" + id + "]");
					var text = $(label).text();
					var file = $(this).val();

					if ($(this).val() != '') {


					} else {

						fail = true;
						$(this).focus();
						if (temp == 1) {
							$.alert({
								title: 'กรุณาเลือกไฟล์ ',
								content: text,
								icon: 'fa fa-exclamation-circle',
								theme: 'modern',
								type: 'orange',
								animation: 'scale',
								closeAnimation: 'scale',
								buttons: {
									close: {
										text: 'ปิด',
										btnClass: 'btn-orange',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});
						} else if (temp == '2') {
							$('#' + id).addClass('bsf-error');
							$('#' + id).removeClass('form-control');
							$("#" + id + "_BSF_AREA .md-group-add-on").append('<small id="DUP_' + id + '_ALERT" class="form-text text-danger" style="display:none;"  ></small>');
							$('#DUP_' + id + '_ALERT').show();
							$('#DUP_' + id + '_ALERT').html('<small  class="form-text text-danger"> กรุณาเลือกไฟล์ ' + text + '</small>');
							//$('#DUP_'+id+'_ALERT').fadeOut(5000);	
						}

						return false;
					}


				} else if ($(this).is("[type=email]")) { //type=email		

					var name = $(this).attr('name');
					var id = $(this).attr('id');
					var label = $("[for=" + id + "]");
					var text = $(label).text();
					var email = $(this).val();
					var regEx = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

					if ($(this).val() != '') {

						var validEmail = regEx.test(email);

						if (!validEmail) {
							fail = true;
							$(this).focus();
							$.alert({
								title: 'กรุณากรอกข้อมูล ',
								content: text + ' รูปแบบอีเมล์ไม่ถูกต้อง ',
								icon: 'fa fa-exclamation-circle',
								theme: 'modern',
								type: 'orange',
								animation: 'scale',
								closeAnimation: 'scale',
								buttons: {
									close: {
										text: 'ปิด',
										btnClass: 'btn-orange',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});
							return false;
						}
					} else {

						fail = true;
						$(this).focus();
						$.alert({
							title: 'กรุณากรอกข้อมูล',
							content: text,
							icon: 'fa fa-exclamation-circle',
							theme: 'modern',
							type: 'orange',
							animation: 'scale',
							closeAnimation: 'scale',
							buttons: {
								close: {
									text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},
							boxWidth: '30%',
							useBootstrap: false,
							closeIcon: true,
							closeIconClass: 'fa fa-close',
						});

						return false;
					}

				} else if ($(this).is("[type=password]")) { //type=password

					var checklength = $(this).hasClass("checklength");
					var checkpassword = $(this).hasClass("checkpassword");
					var checkrepassword = $(this).hasClass("checkrepassword");

					if (checklength == true) {
						if ($(this).val() != '') {
							var maxlength = $(this).attr('maxlength');
							var minlength = $(this).attr('minlength');
							var name = $(this).attr('name');
							var id = $(this).attr('id');
							var text = $("[for=" + name + "]").text();

							if ($(this).val().length < minlength) { //ความยาวอย่างน้อย	 
								fail = true;
								$(this).focus();
								if (temp == 1) {
									$.alert({
										title: 'กรุณากรอกข้อมูล ',
										content: ' ความยาวอย่างน้อย ' + minlength + ' ตัวอักษร',
										icon: 'fa fa-exclamation-circle',
										theme: 'modern',
										type: 'orange',
										animation: 'scale',
										closeAnimation: 'scale',
										buttons: {
											close: {
												text: 'ปิด',
												btnClass: 'btn-orange',
											}
										},
										boxWidth: '30%',
										useBootstrap: false,
										closeIcon: true,
										closeIconClass: 'fa fa-close',
									});
								} else if (temp == '2') {
									$('#' + id).addClass('bsf-error');
									$('#' + id).removeClass('form-control');
									$('#DUP_' + id + '_ALERT').show();
									$('#DUP_' + id + '_ALERT').html('<small  class="form-text text-danger"> กรุณากรอกข้อมูล ' + text + '</small>');
									//$('#DUP_'+id+'_ALERT').fadeOut(5000);
								}

								return false;
							}

							if ($(this).val().length > maxlength) { //ความยาวสูงสุด

								fail = true;
								$(this).focus();
								if (temp == 1) {
									$.alert({
										title: 'กรุณากรอกข้อมูล ',
										content: ' ความยาวสูงสุด ' + maxlength + ' ตัวอักษร',
										icon: 'fa fa-exclamation-circle',
										theme: 'modern',
										type: 'orange',
										animation: 'scale',
										closeAnimation: 'scale',
										buttons: {
											close: {
												text: 'ปิด',
												btnClass: 'btn-orange',
											}
										},
										boxWidth: '30%',
										useBootstrap: false,
										closeIcon: true,
										closeIconClass: 'fa fa-close',
									});
								} else if (temp == '2') {
									$('#' + id).addClass('bsf-error');
									$('#' + id).removeClass('form-control');
									$('#DUP_' + id + '_ALERT').show();
									$('#DUP_' + id + '_ALERT').html('<small  class="form-text text-danger"> กรุณากรอกข้อมูล ' + text + '</small>');
									//$('#DUP_'+id+'_ALERT').fadeOut(5000);
								}
								return false;
							}

						} else { //เช็คค่าว่าง	 
							fail = true;
							$(this).focus();
							if (temp == 1) {
								$.alert({
									title: 'กรุณากรอกข้อมูล',
									content: text,
									icon: 'fa fa-exclamation-circle',
									theme: 'modern',
									type: 'orange',
									animation: 'scale',
									closeAnimation: 'scale',
									buttons: {
										close: {
											text: 'ปิด',
											btnClass: 'btn-orange',
										}
									},
									boxWidth: '30%',
									useBootstrap: false,
									closeIcon: true,
									closeIconClass: 'fa fa-close',
								});
							} else if (temp == '2') {
								$('#' + id).addClass('bsf-error');
								$('#' + id).removeClass('form-control');
								$('#DUP_' + id + '_ALERT').show();
								$('#DUP_' + id + '_ALERT').html('<small  class="form-text text-danger"> กรุณากรอกข้อมูล ' + text + '</small>');
								//$('#DUP_'+id+'_ALERT').fadeOut(5000);
							}

							return false;
						}
					}

					if (checkpassword == true) //checkpassword 
					{
						var maxlength = $(this).attr('maxlength');
						var minlength = '8';
						var name = $(this).attr('name');
						var text = $("[for=" + name + "]").text();
						var id = $(this).attr('id');
						var password = $(this).val();
						var chkStr = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/; //Pattern ตรวจสอบการกรอกตัวอักษร 8-16 ตัวอักษร
						var validPass = chkStr.test(password);
						var getpass = $('.getpass').val();
						if ($(this).val() != '') //ไม่ว่าง
						{
							//if(validPass)
							//{	
							if (checkrepassword == true) //checkpassword 
							{
								if (password == getpass) {
									//$('#DUP_'+id+'_ALERT').hide();
									//$('#'+id).removeClass('bsf-error');
									//$('#'+id).addClass('form-control');
									return true;
								} else {
									fail = true;
									$(this).focus();
									if (temp == 1) {
										$.alert({
											title: 'กรุณากรอกข้อมูล ',
											content: 'กรอกข้อมูลยืนยันรหัสผ่านไม่ถูกต้อง ',
											icon: 'fa fa-exclamation-circle',
											theme: 'modern',
											type: 'orange',
											animation: 'scale',
											closeAnimation: 'scale',
											buttons: {
												close: {
													text: 'ปิด',
													btnClass: 'btn-orange',
												}
											},
											boxWidth: '30%',
											useBootstrap: false,
											closeIcon: true,
											closeIconClass: 'fa fa-close',
										});
									} else if (temp == '2') {

										$('#' + id).addClass('bsf-error');
										$('#' + id).removeClass('form-control');
										$('#DUP_' + id + '_ALERT').show();
										$('#DUP_' + id + '_ALERT').html('<small  class="form-text text-danger"> กรอกข้อมูลยืนยันรหัสผ่านไม่ถูกต้อง (Confirm password)*</small>');
										//$('#DUP_'+id+'_ALERT').fadeOut(5000);
										//alert(id);
									}
									return false;
								}
							}

							/*}
							else
							{
								
							fail = true;					
							$( this ).focus();
							
							if(temp == 1)
							{
								$.alert({
									title: 'กรุณากรอกข้อมูล ',
									content: text+' กรอกข้อมูลเป็นภาษาอังกฤษตัวพิมพ์ใหญ่ตัวพิมพ์เล็กและตัวเลข  '+minlength+' - '+maxlength+' ตัวอักษร',
									icon: 'fa fa-exclamation-circle',
									theme: 'modern',                          
									type: 'orange',
									animation: 'scale',
									closeAnimation: 'scale',						
									buttons: { 
									close: {
										 text: 'ปิด',
											btnClass: 'btn-orange',
										} 
									},	
									boxWidth: '30%',  
									useBootstrap: false,
									closeIcon: true, 
									closeIconClass: 'fa fa-close',
								}); 
							}
							else if(temp == '2')
							{
								$('#'+id).addClass('bsf-error');
								$('#'+id).removeClass('form-control');
								$('#DUP_'+id+'_ALERT').show();
								$('#DUP_'+id+'_ALERT').html('<small  class="form-text text-danger"> กรอกข้อมูลเป็นภาษาอังกฤษตัวพิมพ์ใหญ่ตัวพิมพ์เล็กและตัวเลข  '+minlength+' - '+maxlength+' ตัวอักษร </small>');	
								//$('#DUP_'+id+'_ALERT').fadeOut(5000); 
							}			
							return false;	
							}	*/
						} else //ว่าง
						{
							fail = true;
							$(this).focus();

							if (temp == 1) {
								$.alert({
									title: 'กรุณากรอกข้อมูล',
									content: text,
									icon: 'fa fa-exclamation-circle',
									theme: 'modern',
									type: 'orange',
									animation: 'scale',
									closeAnimation: 'scale',
									buttons: {
										close: {
											text: 'ปิด',
											btnClass: 'btn-orange',
										}
									},
									boxWidth: '30%',
									useBootstrap: false,
									closeIcon: true,
									closeIconClass: 'fa fa-close',
								});
							} else if (temp == '2') {
								$('#' + id).addClass('bsf-error');
								$('#' + id).removeClass('form-control');
								$('#DUP_' + id + '_ALERT').show();
								$('#DUP_' + id + '_ALERT').html('<small  class="form-text text-danger"> กรุณากรอกข้อมูล ' + text + '</small>');
								//$('#DUP_'+id+'_ALERT').fadeOut(5000);	
								//alert(id);	
							}
							return false;
						}
					} //end

				} else if (!$(this).val()) {

					var name = $(this).attr('name');
					var id = $(this).attr('id');
					var label = $("[for=" + name + "]");
					var text = $(label).text();
					fail = true;
					$(this).focus();
					if (temp == 1) {
						$.alert({
							title: 'กรุณากรอกข้อมูล',
							content: text,
							icon: 'fa fa-exclamation-circle',
							theme: 'modern',
							type: 'orange',
							animation: 'scale',
							closeAnimation: 'scale',
							buttons: {
								close: {
									text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},
							boxWidth: '30%',
							useBootstrap: false,
							closeIcon: true,
							closeIconClass: 'fa fa-close',
						});
					} else if (temp == '2') {
						/*$('#'+id).addClass('bsf-error');
						$('#'+id).removeClass('form-control');
						
						if( $( this ).hasClass("textarea") == true) {	
						
							$("#"+name+"_BSF_AREA.col-md-8").after('<small id="DUP_'+id+'_ALERT" class="form-text text-danger" style="display:none;"  ></small>');	
							$('#DUP_'+id+'_ALERT').show();
							$('#DUP_'+id+'_ALERT').html('<small  class="form-text text-danger"> กรุณากรอกข้อมูล ' + text + '</small>');	
							//$('#DUP_'+id+'_ALERT').fadeOut(5000);
						
						}else if( $( this ).hasClass("date") == true) {
							
							$("#"+name+"_BSF_AREA .input-group").after('<small id="DUP_'+id+'_ALERT" class="form-text text-danger" style="display:none;"  ></small>');	
							$('#DUP_'+id+'_ALERT').show();
							$('#DUP_'+id+'_ALERT').html('<small  class="form-text text-danger"> กรุณาเลือก ' + text + '</small>');
							//$('#DUP_'+id+'_ALERT').fadeOut(5000);							
						}else{
							
							if(id.search('wfsflow') == 0){ 
		
						    $("#"+id).after('<small id="DUP_'+id+'_ALERT" class="form-text text-danger" style="display:none;"  ></small>');		
							$('#DUP_'+id+'_ALERT').show();
							$('#DUP_'+id+'_ALERT').html('<small  class="form-text text-danger"> กรุณากรอกข้อมูล ' + text + '</small>');			
							//$('#DUP_'+id+'_ALERT').fadeOut(5000);
							
							}else{
								
								$('#DUP_'+id+'_ALERT').show();
								$('#DUP_'+id+'_ALERT').html('<small  class="form-text text-danger"> กรุณากรอกข้อมูล ' + text + '</small>');		
								//$('#DUP_'+id+'_ALERT').fadeOut(5000);
							}
						}*/
					}
					return false;

				}
				//alert($( this ).attr( 'id' ));	
				//$('#DUP_'+$( this ).attr( 'id' )+'_ALERT').hide();
				//$('#'+$( this ).attr( 'id' )).removeClass('bsf-error');
				//$('#'+$( this ).attr( 'id' )).addClass('form-control');
				//$('span[aria-labelledby="select2-'+$( this ).attr( 'id' )+'-container"]').removeClass('bsf-sel-error'); 
				//$('#DUP_'+$( this ).attr( 'id' )+'_ALERT').fadeOut(5000);
			}
		});

		var formData = false;
		if (window.FormData) {
			formData = new FormData(form[0]);
		}

		if (fail == false) {
			//$('#loader').fadeIn();	
			$.ajax({
				type: method,
				url: action,
				data: formData ? formData : form.serialize(),
				async: true,
				processData: false,
				contentType: false,
				beforeSend: function() {

					$('#loader').fadeIn();

				},
				success: function(data) {

					setTimeout(function() {
						$('#loader').fadeOut();
					}, 2500);

					var Newdata = JSON.stringify(eval("(" + data + ")"));
					var Obj = jQuery.parseJSON(Newdata);
					console.log(data);

					if (Obj.err) {
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
							},
							onAction: function() {
								$('#loader').fadeOut();
							},
							boxWidth: '30%',
							useBootstrap: false,
							closeIcon: true,
							closeIconClass: 'fa fa-close',
						});
						return false;
					}

					if (Obj.warn) {
						if (Obj.btn == 2) {
							$.alert({
								title: 'Warning',
								content: Obj.message,
								icon: 'fa fa-exclamation-circle',
								theme: 'modern',
								type: 'orange',
								closeIcon: false,
								buttons: {
									confirm: {
										text: 'ตกลง',
										btnClass: 'btn-green',
										action: function() {
											/*if(Obj.act.includes('location'))
											{
												location.reload(true);
											}
											else
											{
												window.location.href = Obj.act;		
											}*/
											boxPopup1(Obj.popup);
										}
									},
									close: {
										text: 'ยกเลิก',
										btnClass: 'btn-orange',
									}
								},
								onAction: function() {
									$('#loader').fadeOut();
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});

						} else {
							$.alert({
								title: 'Warning',
								content: Obj.message,
								icon: 'fa fa-exclamation-circle',
								theme: 'modern',
								type: 'orange',
								closeIcon: false,
								buttons: {
									close: {
										text: 'ยกเลิก',
										btnClass: 'btn-orange',
									}
								},
								onAction: function() {
									$('#loader').fadeOut();
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});
						}
						return false;
					}

					if (Obj.url) {
						//var url = Obj.url;													
						if (Obj.alert) {
							$.alert({
								title: '',
								content: Obj.message,
								icon: 'far fa-check-circle',
								theme: 'modern',
								type: 'blue',
								closeIcon: false,
								buttons: {
									close: {
										text: 'ตกลง',
										btnClass: 'btn-blue',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: false,
								closeIconClass: 'fa fa-close',
								onAction: function() {
									if (Obj.url.includes('location')) {
										location.reload(true);
									} else {
										window.location.href = Obj.url;
									}
								}
							});
						} else {
							location.reload(true);
							window.location.href = Obj.url;
						}
						return false;
					} else {
						if (Obj.btn == 2) {
							if (Obj.alert) {

							} else {
								boxPopup(Obj.popup);
							}
						} else {
							if (Obj.alert) {
								$.alert({
									title: '',
									content: Obj.message,
									icon: 'far fa-check-circle',
									theme: 'modern',
									type: 'blue',
									closeIcon: false,
									buttons: {
										close: {
											text: 'ตกลง',
											btnClass: 'btn-blue',
										}
									},
									boxWidth: '30%',
									useBootstrap: false,
									closeIcon: false,
									closeIconClass: 'fa fa-close',
									onAction: function() {

										location.reload(true);

									}
								});
							}

						}

					}
				}
			});
		}
	}

	$(document).ready(function() {
		$('input').keyup(function(event) {
			if (event.which === 13) {
				event.preventDefault();
				SubmitForm($('#form_main'));
				SubmitForm($('#form_forgot'));
				SubmitForm($('#form_post'));
			}
		});
	});
</script>