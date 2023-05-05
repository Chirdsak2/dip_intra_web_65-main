<div id="loader" class="loader"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- bootstrap 3.3.7 -->
<script src="<?php echo $IMG_PATH;?>js/bootstrap.js"></script>
<!-- END -->

<!-- bootstrap Library -->
<script src="<?php echo $IMG_PATH;?>assets/js/bootstrap-select/1.13.11/bootstrap-select.js"></script>
<script src="../js/bootstrap-filestyle-1.2.3/src/bootstrap-filestyle.js"></script>
<!-- END -->

<script src="../js/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>

<script type="text/javascript" src="../js/jquery-confirm-master/js/jquery-confirm.js"></script> 
<script type="text/javascript" src="<?php echo $IMG_PATH;?>js/gnmenu-js/js/gnmenu.js"></script>

<script src="../js/IconHoverEffects/js/modernizr.custom.js"></script>
<script src="../js/ckeditor/ckeditor.js"></script> 
<script src="../js/x0popup-master/dist/x0popup.min.js"></script> 

<link rel="stylesheet" href="../js/bootstrap-datepicker/css/bootstrap-datepicker.css" />
<link rel="stylesheet" href="../js/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

<script src="../js/bootstrap-datepicker/js/bootstrap-datepicker-custom.js"></script>
<script src="../js/bootstrap-datepicker/locales/bootstrap-datepicker.th.min.js"></script>

<script src="../js/linedtextarea/jquery-linedtextarea.js"></script>


<!-- Select 2 js -->
<script src="../js/select2/js/select2.full.min.js"></script> 
<!-- Multi Select js -->
<script src="../js/multi-select/js/bootstrap-multiselect.js"></script> 
<script src="../js/multi-select/js/jquery.multi-select.js"></script> 
<script type="text/javascript" src="../js/multi-select/js/jquery.quicksearch.js"></script> 

<script type="text/javascript">

<?php 
$sql_file = "SELECT site_info_max_file,site_type_file FROM site_info";
$query_file = $db->query($sql_file);
$rec_file = $db->db_fetch_array($query_file);
?>
function JSCheck_file(id,fileInput) {
		var fileTypes = '<?php echo $rec_file['site_type_file'];?>';
		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = <?php echo sizeMB2byte($rec_file['site_info_max_file']); ?>;
		var name = $('#'+id).val();
		
		var n = name.split('.').pop().toLowerCase();
		var m = 0;
		//alert(fileTypes);
	    if(parseInt(fileTypes.indexOf(n)) < 0){
		$('#'+id).val("");
			$.alert({
						title: 'รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง ',
						content: 'กรุณาเลือกรูปแบบใหม่',
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
				//alert('กรุณาเลือกชนิดไฟล์ '+fileTypes);
				return false;
		}	
	if(size > maxsize){
		//var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 5000 KB.</div>";
		//document.getElementById("warning1").innerHTML = sms1;
		//alert(sms1);
			$('#'+id).val("");
			$.alert({
						title: 'ขนาดไฟล์ใหญ่เกินไป ',
						content: 'กรุณาเลือกไฟล์ใหม่',
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
		}else{
		  //document.getElementById("warning1").innerHTML = "";
	  }							
}
function JSCheck_CSV(id,fileInput) {
		var fileTypes = 'csv';
		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = <?php echo sizeMB2byte($rec_file['site_info_max_file']); ?>;
		var name = $('#'+id).val();
		
		var n = name.split('.').pop().toLowerCase();
		var m = 0;
	    if(parseInt(fileTypes.indexOf(n)) < 0){
		$('#'+id).val("");
			$.alert({
						title: 'รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง ',
						content: 'กรุณาเลือกรูปแบบใหม่',
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
	if(size > maxsize){
			$('#'+id).val("");
			$.alert({
						title: 'ขนาดไฟล์ใหญ่เกินไป ',
						content: 'กรุณาเลือกไฟล์ใหม่',
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
		}else{
		  //document.getElementById("warning1").innerHTML = "";
	  }							
}
<?php 
$sql_Imsize = "SELECT site_info_max_img,site_type_img_file FROM site_info";
$query_Imsize = $db->query($sql_Imsize);
$rec_Imsize = $db->db_fetch_array($query_Imsize);
?>
function JSCheck_Img(id,fileInput) {
		var fileTypes = '<?php echo $rec_Imsize['site_type_img_file'];?>';
		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = <?php echo sizeMB2byte($rec_Imsize['site_info_max_img']); ?>;
		var name = $('#'+id).val();
		
		var n = name.split('.').pop().toLowerCase();
		var m = 0;
		
		//alert(fileTypes);
		
	    if(parseInt(fileTypes.indexOf(n)) < 0){
		$('#'+id).val("");
			$.alert({
						title: 'รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง ',
						content: 'กรุณาเลือกรูปแบบใหม่',
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
				//alert('กรุณาเลือกชนิดไฟล์ '+fileTypes);
				return false;
		}	
	if(size > maxsize){
		//var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 5000 KB.</div>";
		//document.getElementById("warning1").innerHTML = sms1;
		//alert(sms1);
			$('#'+id).val("");
			$.alert({
						title: 'ขนาดไฟล์ใหญ่เกินไป ',
						content: 'กรุณาเลือกไฟล์ใหม่',
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
		}else{
		  //document.getElementById("warning1").innerHTML = "";
	  }							
}
<?php 
$sql_vdo = "SELECT site_info_max_vdo,site_type_vdo_file FROM site_info";
$query_vdo = $db->query($sql_vdo);
$rec_vdo = $db->db_fetch_array($query_vdo);
?>
function JSCheck_Vdo(id,fileInput) {
		var fileTypes= '<?php echo $rec_vdo['site_type_vdo_file'];?>';
		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = <?php echo sizeMB2byte($rec_vdo['site_info_max_vdo']); ?>;;
		var name = $('#'+id).val();
		var n = name.split('.').pop().toLowerCase();
		var m = 0;
		
		//alert(fileTypes);
		
	    if(parseInt(fileTypes.indexOf(n)) < 0){
		$('#'+id).val("");
			$.alert({
						title: 'รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง ',
						content: 'กรุณาเลือกรูปแบบใหม่',
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
				//alert('กรุณาเลือกชนิดไฟล์ '+fileTypes);
				return false;
		}	
	if(size > maxsize){
		//var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 5000 KB.</div>";
		//document.getElementById("warning1").innerHTML = sms1;
		//alert(sms1);
			$('#'+id).val("");
			$.alert({
						title: 'ขนาดไฟล์ใหญ่เกินไป ',
						content: 'กรุณาเลือกไฟล์ใหม่',
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
		}else{
		  //document.getElementById("warning1").innerHTML = "";
	  }						
							
}

function isNumberInt(evt, element) 
{

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            //(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            //(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }  
	
$('.file_upload').filestyle({
	iconName : 'fas fa-folder-open',
	buttonName : 'btn-info',
    buttonText : 'Choose file'
	});
	
function Func_CheckNumber(valnum)
{	
    if (valnum !== "" && !$.isNumeric(valnum)) {
	return false;
	}else{
		return true;
	}	
}
function Func_CheckID(id)
{	
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

function CKSubmitData(form)
{
	
	var formid  	= form.attr('id');
	var fail 		= false;
    var fail_log 	= '';
	
	$( '#'+formid ).find( 'select, textarea, input' ).each(function(){
	
			var checklength = $( this ).hasClass("checklength");
			var checkmail 	= $( this ).hasClass("checkmail");
			var checkidc 	= $( this ).hasClass("checkidc");
			var checknumber = $( this ).hasClass("checknumber");
			var checkpassword = $( this ).hasClass("checkpassword");
			var checkusername = $( this ).hasClass("checkusername");
			var checkconfpass = $( this ).hasClass("checkconfpass");

	if( ! $( this ).prop( 'required' )){
		
            } else {
				
				if ($( this ).is("[type=radio]")) {	
					var name = $( this ).attr( 'name' );
					var id   = $( this ).attr( 'id' );
					
					if ($("input:radio[name="+name+"]").is(':checked') == false){
						fail = true;					

						var label = $("[for="+name+"]");
						text = $(label).text();
						//console.log(text);
						$( this ).focus();				
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
							});		
						return false;		
					}else{
						
					}				
				}else{				
                if ( ! $( this ).val()){
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
	}
	
//alert(checkmail);	

if(checklength == true)
{
var maxlength = $( this ).attr( 'maxlength' );		
var minlength = $( this ).attr( 'minlength' );	
var name = $( this ).attr( 'name' );	
var text = $("[for="+name+"]").text();
		 if ($(this).val().length < minlength) {
			 
				 fail = true;	
				 $( this ).focus();	
					$.alert({
						title: 'กรุณากรอกข้อมูล ',
						content: text + '  ความยาวอย่างน้อย ' + minlength + ' ตัวอักษร',
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
						content: text + '  ความยาวสูงสุด ' + maxlength + ' ตัวอักษร',
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

if(checkpassword == true)
{
var maxlength = $( this ).attr( 'maxlength' );		
var minlength = $( this ).attr( 'minlength' );	
var name = $( this ).attr( 'name' );	
var text = $("[for="+name+"]").text();
var password = $( this ).val();
var chkStr = /^\s*[a-zA-Z0-9,\s]+\s*$/; //Pattern ตรวจสอบการกรอกตัวอักษร 5-16 ตัวอักษร
if($(this).val() != ""){ 
	 if(password.search(chkStr)){		 
				 fail = true;	
				 $( this ).focus();	
					$.alert({
						title: 'กรุณากรอกข้อมูล ',
						content: text + ' กรอกข้อมูลเป็นภาษาอังกฤษหรือตัวเลข '+minlength+' - '+maxlength+' ตัวอักษร',
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

if(checkconfpass == true)
{
var valpass = $('.password').val();
	
var name = $( this ).attr( 'name' );	
var text = $("[for="+name+"]").text();
var repass = $( this ).val();

if(valpass != "" && repass != "" ){ 
	 if(valpass != repass){		 
				 fail = true;	
				 $( this ).focus();	
					$.alert({
						title: 'กรุณากรอกข้อมูล ',
						content: text + ' ! ไม่ถูกต้อง กรุณากรอกใหม่อีกครั้ง',
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

if(checkusername == true)
{
var maxlength = $( this ).attr( 'maxlength' );		
var minlength = $( this ).attr( 'minlength' );	
var name = $( this ).attr( 'name' );	
var text = $("[for="+name+"]").text();
var username = $( this ).val();
var chkStr = /^\s*[a-zA-Z0-9,\s]+\s*$/; //Pattern ตรวจสอบการกรอกตัวอักษร 5-16 ตัวอักษร

if($(this).val() != ""){ 
	 if(username.search(chkStr)){		 
				 fail = true;	
				 $( this ).focus();	
					$.alert({
						title: 'กรุณากรอกข้อมูล ',
						content: text + ' กรอกข้อมูลเป็นภาษาอังกฤษหรือตัวเลข '+minlength+' - '+maxlength+' ตัวอักษร',
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
	
if(checkmail == true)
{	
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

if(checkidc == true) 
{	
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

if(checknumber == true) 
{
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
				$( this ).val('');			
		return false;	
								
  }
}
	
});	

return fail;	
		 
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
function boxPopup2(link)
  {
    $.ajax({
      type: 'GET',
      url: link,
      beforeSend: function() {
        $('#box_popup2').html('');
      },
      success: function (data) {
        $('#box_popup2').html(data);
      }
    });
    $('#box_popup2').fadeIn();
 }
 
function formatState (opt) {
    if (!opt.id) {
        return opt.text.toUpperCase();
    } 

    var optimage = $(opt.element).attr('data-image'); 
    console.log(optimage)
    if(!optimage){
       return opt.text.toUpperCase();
    } else {                    
        var $opt = $(
           '<span><img src="' + optimage + '" height="55px" class="img-circle" /> ' + opt.text.toUpperCase() + '</span>'
        );
        return $opt;
    }
};

</script>
<style>
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

.ringBell, .ringBell:after {
	width: 20px;
	height: 20px;
	
}

.-count, .-count:before, .ringBell:after {
	position: absolute;
 
}

.-count, .-count:before {
	width: 18px;
	height: 18px;
	border-radius: 50%;
}

.ringBell {
	margin: 0px 10px;
	cursor: pointer;
}

.ringBell:after {
	content: '';
	transform-origin: top;
	background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNDczLjczMyA0NzMuNzMzIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzMuNzMzIDQ3My43MzM7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPjxnPjxwYXRoIGQ9Ik0yMi42NDgsMzk4LjY1YzIuNTUsNi4yMzMsOC43ODMsMTAuNDgzLDE1LjU4MywxMC40ODNoMTIzLjUzM2M1LjM4MywzNi41NSwzNy4xMTcsNjQuNiw3NC44LDY0LjZzNjkuNDE3LTI4LjA1LDc0LjgtNjQuNiAgICBoMTIzLjgxN2wwLDBjMC44NSwwLDEuNywwLDIuNTUtMC4yODNjNi4yMzMtMC44NSwxMS4zMzMtNS4xLDEzLjYtMTAuNzY3YzIuMjY3LTYuNTE3LDAuNTY3LTEzLjMxNy00LjI1LTE3Ljg1ICAgIGMtMC4yODMtMC4yODMtMC41NjctMC41NjctMC44NS0wLjg1Yy0xLjctMS43LTguNS05LjM1LTE1LjAxNy0yNS41Yy03LjA4My0xNy4yODMtMTUuODY3LTQ4LjE2Ny0xNS44NjctOTYuMDUgICAgYzAtOTQuNjMzLTM1LjctMTQ0LjUtNjUuNDUtMTY5LjcxN2MtMTkuODMzLTE2LjcxNy0zOS42NjctMjQuOTMzLTUyLjctMjguOWMtMC41NjctMTEuNjE3LTMuNC0yNy40ODMtMTQuMTY3LTQwLjIzMyAgICBDMjc1LjY2NSwxMC4yLDI2MS43ODIsMCwyMzcuMTMyLDBjLTI0LjM2NywwLTM4LjI1LDEwLjQ4My00NS42MTcsMTguOTgzYy0xMS4wNSwxMy4wMzMtMTQuMTY3LDI5LjE4My0xNC40NSw0MS4wODMgICAgYy0xMy4zMTcsMy45NjctMzMuMTUsMTIuMTgzLTUyLjcsMjguMzMzYy01NC42ODMsNDQuNzY3LTY2LjAxNywxMTYuNzMzLTY2LjAxNywxNjguODY3YzAsNDYuNDY3LTguNzgzLDc3LjM1LTE2LjE1LDk1LjIgICAgYy03LjkzMywxOC45ODMtMTUuNTgzLDI3LjQ4My0xNS41ODMsMjcuNDgzbDAsMEMyMS41MTUsMzg0Ljc2NywyMC4wOTgsMzkyLjEzMywyMi42NDgsMzk4LjY1eiBNMjM2Ljg0OCw0MzkuNzMzICAgIGMtMTguOTgzLDAtMzUuMTMzLTEzLjAzMy00MC4yMzMtMzAuNmg4MC40NjdDMjcxLjk4Miw0MjYuNywyNTUuODMyLDQzOS43MzMsMjM2Ljg0OCw0MzkuNzMzeiBNOTIuMzQ4LDI1Ny4yNjcgICAgYzAtMTUyLjQzMyw5OS43MzMtMTY2Ljg4MywxMDMuNy0xNjcuNDVjNC41MzMtMC41NjcsOC43ODMtMi44MzMsMTEuNjE3LTYuNTE3YzIuODMzLTMuNjgzLDMuOTY3LTguMjE3LDMuNC0xMy4wMzMgICAgYy0wLjg1LTUuMzgzLTEuNDE3LTIxLjI1LDYuMjMzLTMwLjAzM2MxLjQxNy0xLjcsNS45NS03LjA4MywxOS44MzMtNy4wODNzMTguNDE3LDUuMzgzLDIwLjExNyw3LjA4MyAgICBjNy4wODMsOC4yMTcsNi44LDIzLjgsNS45NSwyOC45Yy0wLjg1LDQuNTMzLDAuMjgzLDkuMzUsMy4xMTcsMTMuMDMzYzIuODMzLDMuNjgzLDYuOCw2LjIzMywxMS42MTcsNi44ICAgIGMwLjI4MywwLDI1LjUsMy42ODMsNTAuNzE3LDI0LjkzM2MzNS40MTcsMjkuNzUsNTMuMjY3LDc4LjIsNTMuMjY3LDE0My45MzNjMCw1Ny44LDExLjA1LDk0LjkxNywyMi4xLDExNy41ODNINjkuNjgyICAgIEM4MC40NDgsMzUxLjksOTIuMzQ4LDMxMy45MzMsOTIuMzQ4LDI1Ny4yNjd6IiBmaWxsPSIjRkZGRkZGIi8+PC9nPjwvc3ZnPg==);
	background-size: cover;
}

.ringBell:hover:after {
	animation: ring .16s ease-in-out 5;
}

@keyframes ring {
  0% {
    transform: rotate(18deg);
  }
  50% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(-18deg);
  }
}

.-count {
	display: flex;
	flex-flow: row wrap;
	justify-content: center;
	align-items: center;
	width: 18px;
	height: 18px; 
	background-color: #f5ac07; 
	margin: -6px 0 0 22px; 
	color:#000000;
	font-size: 12px;
	font-weight: bold;
	z-index: 90;
}

.-count:before {
	content: '';
	box-sizing: border-box;
	border: 0.5px solid #f5ac07;
}

.ringBell:hover .-count:before {
	animation: pulse .6s ease-out;
}

@keyframes pulse {
  from {
    opacity: 1;
    transform: scale(.8);
  }
  to {
    opacity: 0;
    transform: scale(2);
  }
}
</style>

<!-- Counter -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/waypoints.js"></script>
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/jquery.counterup.js"></script>
<!-- Slick Slider -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/slick.js"></script> 
<!-- Custom js -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/custom.js"></script>