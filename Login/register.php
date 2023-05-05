<?php
	session_start();
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect_uncheck.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>สมัครสมาชิก</title>
    <meta name="description" content="DMR">
    <meta name="keywords" content="DMR">
    <!-- Bootstrap & Styling-->
    <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
    <!--link(rel="stylesheet", href="css/bootstrap/bootstrap-grid.min.css")-->
    <!--link(rel="stylesheet", href="css/bootstrap/bootstrap-reboot.min.css")-->
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/plugin/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="http://www.dmr.go.th/ewtadmin/js/jquery-confirm-master/css/jquery-confirm.css"/>
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
        <div class="box-wrapper">
          <div class="box box-border">
            <div class="box-body">
              <h4 class="text-center">สมัครสมาชิก</h4>
              <form method="POST" action="process.php" name="register" id="register" enctype="multipart/form-data" >
                    <div class="form-group">
                      <label for="idnum">รหัสบัตรประชาชน<span class="required"></span></label>
                      <input class="form-control checkidc" type="text" name="idnum"  id="idnum"  required>
                    </div>
					
                    <div class="form-group">
                      <label for="title_thai">คำนำหน้า<span class="required"></span></label>
                      <select class="form-control" name="title_thai" id="title_thai"  required >
                       <option value=""selected="" disabled="disabled" >เลือกคำนำหน้า</option>   
                        <?php 
	
						$s_title = "SELECT title_thai,title_id FROM title GROUP BY title_thai";
						$q_title = $db->query($s_title);
						while($a_title = $db->db_fetch_array($q_title)){
							
							if($a_title['title_id'] == $title_thai) $selected_title = "selected";
							else $selected_title = "";
							echo '<option value="'.$a_title['title_id'].'" '.$selected_title.'>'.ConvertUTF8($a_title['title_thai']).'</option>';
						}
						
					  ?>
					  
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="name_thai">ชื่อ<span class="required"></span></label>
                      <input class="form-control" type="text" name="name_thai" id="name_thai" required>
                    </div>
                    <div class="form-group">
                      <label for="surname_thai">นามสกุล<span class="required"></span></label>
                      <input class="form-control" type="text" name="surname_thai" id="surname_thai" required>
                    </div>
                    <div class="form-group">
                      <label>ชื่อ (ภาษาอังกฤษ)<span></span></label>
                      <input class="form-control" type="text" name="name_en">
                    </div>
                    <div class="form-group">
                      <label>นามสกุล (ภาษาอังกฤษ)<span></span></label>
                      <input class="form-control" type="text" name="surname_en">
                    </div>
                    <div class="form-group">
                      <label>รูปภาพ<span></span></label>
                      <input class="form-control" type="file" name="picture">
                    </div>
                <div class="title-line"></div>
                    <div class="form-group">
                      <label for="org_id">หน่วยงาน<span class="required"></span></label>
                      <select class="form-control" name="org_id"  id="org_id"   required>
					  <option value=""selected="" disabled="disabled">เลือกหน่วยงาน</option>   
                      <?php 
					  $s_org_name = $db->query("SELECT * FROM org_name ");
					  while($a_org_name = $db->db_fetch_array($s_org_name)){
						  
					  if($a_org_name['org_id'] == $org_id) $selected_unit = "selected";
							else $selected_unit = "";
							echo  '<option value="'.$a_org_name['org_id'].'" '.$selected_unit.'>'.ConvertUTF8($a_org_name['name_org']).'</option>';
					  } 
					  ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>ตำแหน่งภายในหน่วยงาน<span></span></label>
                      <select class="form-control" name="posittion"  id="posittion">
                        <option value=""selected="" disabled="disabled">เลือกตำแหน่งภายในหน่วยงาน</option>   
                    <?php 
					
					$s_position = $db->query("SELECT * FROM position_name ORDER BY pos_level,pos_name ASC ");
					 while($a_position = $db->db_fetch_array($s_position)){
						if($a_position['pos_id'] ==  $posittion) $a_position= "selected";
							else $selected_position = "";
							echo  '<option value="'.$a_position['pos_id'].'" '.$selected_position.'>'.ConvertUTF8($a_position['pos_name']).'</option>';
						}
						
					?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>ตำแหน่งทางวิชาการ<span></span></label>
                      <input class="form-control" type="text" name="position_person">
                    </div>
                    <div class="form-group">
                      <label for="email_person">E-mail<span class="required"></span></label>
                      <input class="form-control checkmail" type="email" name="email_person" id="email_person" required>
                    </div>
                    <div class="form-group">
                      <label>เบอร์โทรติดต่อ<span></span></label>
                      <input class="form-control" type="text" name="tel_in">
                    </div>
                <div class="form-group">
                  <label>สถานที่ทำงาน</label>
                  <textarea class="form-control" rows="4" cols="" name="officeaddress"></textarea>
                </div>
                    <div class="form-group">
                      <label for="emp_type_id" >กลุ่ม<span class="required"></span></label>
                      <select class="form-control" name="emp_type_id" id="emp_type_id" required>
                        <option value=""selected="" disabled="disabled" >เลือกกลุ่ม</option>   
                        <?php 
						
						$s_title = "SELECT * FROM emp_type WHERE emp_type_status = '2' ";
						$q_title = $db->query($s_title);
						while($a_title = $db->db_fetch_array($q_title)){
							
						echo  '<option value="'.$a_title['emp_type_id'].'">'.ConvertUTF8($a_title['emp_type_name']).'</option>';
						
						}
						?>
                      </select>
                    </div>
                <div class="title-line"></div>
                    <div class="form-group">
                      <label for="gen_user">ชื่อผู้ใช้งาน<span class="required"></span></label>
                      <input class="form-control checkuser checklength" type="text" name="gen_user" id="gen_user" minlength="8" maxlength="16" required>
					  	<span class="text-danger">กรอกได้เฉพาะตัวอักษรภาษาอังกฤษและตัวเลข ความยาวอย่างน้อย 8 ตัวอักษร สูงสุด 16  ตัวอักษร</span>
                    </div>
                    <div class="form-group">
                      <label for="gen_pass">รหัสผ่าน<span class="required"></span></label>
                      <input class="form-control checkuser checklength" type="password" name="gen_pass" id="gen_pass"  minlength="8" maxlength="16" required>
					  	<span class="text-danger">กรอกได้เฉพาะตัวอักษรภาษาอังกฤษและตัวเลข ความยาวอย่างน้อย 8 ตัวอักษร สูงสุด 16  ตัวอักษร</span>
                    </div>
                    <div class="form-group">
                      <label for="re_gen_pass">ยืนยันรหัสผ่าน<span class="required"></span></label>
                      <input class="form-control checkuser checklength" type="password" name="re_gen_pass" id="re_gen_pass" minlength="8" maxlength="16" required>
					  	<span class="text-danger">กรอกได้เฉพาะตัวอักษรภาษาอังกฤษและตัวเลข ความยาวอย่างน้อย 8 ตัวอักษร สูงสุด 16  ตัวอักษร</span>
                    </div>
                <div class="form-group text-right">
                  <span class="btn btn-primary btn-block" onclick="Func_Check();">Register</span>
                </div>
                <div class="form-group text-center"><a href="login.php">กลับสู่หน้าหลัก</a></div>
                <p class="text-center">กรุณาติดต่อ admin เพื่ออนุมัติการใช้งานได้ที่หมายเลข <span class="fw-700">9694&nbsp;</span><span>และ&nbsp;</span><span class="fw-700">9695</span></p>
              <input type="hidden" name="proc" value="register" >
			  </form>
            </div>
          </div>
        </div>
      </div>
    </section>
	
    <!--Footer-->
	
  </body>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins)-->
  <script src="../assets/js/jquery-3.3.1.min.js"></script>
  <!--Include all compiled plugins (below), or include individual files as needed-->
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/moment.min.js"></script>
  <script src="../assets/js/custom.js"></script>
  
  <script type="text/javascript" src="http://www.dmr.go.th/ewtadmin/js/jquery-confirm-master/js/jquery-confirm.js"></script> 
  <script src="http://www.parliament.go.th/aseanrelated_law/assets/js/jquery.mask.min.js"></script>

  <script>
$(document).ready(function(){ 

$('.checkuser').keyup(function (event) {
            return Func_CheckUser(event,this.id)
      });
	  
$('#idnum').mask('0-0000-00000-00-0');

	  
});
  
  
function Func_ReCaptcha(){
	  var txt = '<img src="../ewt_pic.php">';
	$("#recapt").html(txt);
}

function Func_checkID(id){	
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

function Func_CheckUser(event,id){
	 
	var v =  $('#'+id).val();	  
	console.log(v);

	if(!v.match(/^([a-z0-9\_])+$/i)){
		
		//alert('กรอกได้เฉพาะตัวอักษรภาษาอังกฤษและตัวเลข ความยาวอย่างน้อย 8 ตัวอักษร');
		$.alert({
						title: 'กรุณากรอกข้อมูล',
						content: 'กรอกได้เฉพาะตัวอักษรภาษาอังกฤษและตัวเลข ความยาวอย่างน้อย 8 ตัวอักษร',
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
		
		$('#'+id).val("");
		$('#'+id).focus();
		return false;
	}else{
		return true;
	}
}

function Func_RePass(){ 

	var v =  $('#gen_pass').val();	 
	var vre =  $('#re_gen_pass').val();

if(vre != ""){	
	if(v != vre){
		//alert('ยืนยันรหัสผ่านไม่ถูกต้อง ');
		//return false;
			$.alert({
						title: 'กรุณากรอกข้อมูล',
						content: 'ยืนยันรหัสผ่านไม่ถูกต้อง',
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
	
function Func_LengthStr(v){  
     var n =  v.length;
	 return n;
}


function Func_Check(){

var fail = false;
        var fail_log = '';
        $( '#register' ).find( 'select, textarea, input' ).each(function(){
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
						
		$( this ).focus();		
		return false;
									
	
		}

	}	
	
var checklength = $( this ).hasClass("checklength");
var checkmail = $( this ).hasClass("checkmail");
var checkidc = $( this ).hasClass("checkidc");
var checknumber = $( this ).hasClass("checknumber");

//alert(s);	

if(checklength == true) {
	
var maxlength = $( this ).attr( 'maxlength' );		
var minlength = $( this ).attr( 'minlength' );	
var name = $( this ).attr( 'name' );	
var text = $("[for="+name+"]").text();
		 if ($(this).val().length < minlength) {
			 
				 fail = true;	
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
		$( this ).focus();		
		return false;	
		 }
		 
		if ($(this).val().length > maxlength) {
			
			 fail = true;	
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
		$( this ).focus();		
		return false;	
			
		}
	}
	
if(checkmail == true) {
	
var name = $( this ).attr( 'name' );	
var text = $("[for="+name+"]").text();
var email = $( this ).val();
var regEx = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

      var validEmail = regEx.test(email);
      if (!validEmail) {
			 
				 fail = true;	
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
		$( this ).focus();		
		return false;	
		 }	
	
}


if(checkidc == true) {
	
var name = $( this ).attr( 'name' );	
var text = $("[for="+name+"]").text();
var valID = $( this ).val();
	
  if (!Func_checkID(valID)) {
	  				fail = true;	
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
		$( this ).focus();		
		return false;	
  }

}



var gen_pass =  $('#gen_pass').val();	 
var re_gen_pass =  $('#re_gen_pass').val();

if(re_gen_pass != ""){	
	if(gen_pass != re_gen_pass){		
			fail = true;
			$.alert({
						title: 'กรุณากรอกข้อมูล',
						content: 'ยืนยันรหัสผ่านไม่ถูกต้อง',
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
			$('#re_gen_pass').focus();					
			return false;	
	}
}
	
});	

	
	
 if (fail == false) { 
			$.confirm({
						title: 'สมัครสมาชิก',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่ ',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fa fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$( '#register' ).submit();
										/*$.ajax({
											type: 'POST',
											url: 'process.php',					
											data:{'id': id,'proc':'Approve'},						
											success: function (data) {
												//location.reload();	
												//$("#register").load();
												//$("#register").load(location.href + " #register");
												 window.location.href="login.php";
											}
										});	*/																									
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});

					} 
					
				
//var proc = $("#proc").val();
			 
}

</script>
</html>