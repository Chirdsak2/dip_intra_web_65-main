<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRD Intranet: เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="assets/login/assets/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="assets/login/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/login/assets/css/style.css">
	<link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/login/assets/css/prompt.css">
</head>
<body>
<div class="login-dark">
<form id="form_main" name="form_main"  action="func_login.php" method="POST" enctype="multipart/form-data" > 
<input type="hidden" name="proc" id="proc" value="Login"> 
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration">
            <img src="assets/login/assets/img/logo.png">
			<br>INTRANET
			</div>          
            <div class="form-group">
				<label for="username" hidden>Username</label>
				<input class="form-control" type="text" name="username" placeholder="Username" required="required"> 
			</div>
            <div class="form-group">
				<label for="password" hidden>Password</label>   
				<input class="form-control checkpassword" type="password" name="password" placeholder="Password" maxlength="16" required="required"> 
			</div> 
			<!-- ตอบผิด 3 ครั้งถึงจะแสดง 
			<div class="form-group text-center">
				<div class="bg-captcha">
					<img src="assets/img/captcha/ewt_picmain.png" title="captcha" alt="captcha" class="">
				</div>
				<a href="#">
					<div class="re-captcha mb-2"> คลิกเพื่อเปลี่ยนรูป <i class="fas fa-sync-alt"></i> </div>
				</a>
                <input class="form-control" type="text" name="captcha" placeholder="captcha">
            </div>
			-->
            <div class="text-center">
            <a href="#" class="forgot" data-toggle="modal" data-target="#ForgetPWModal">ลืมรหัสผ่าน ? </a> 
            </div>
            <div class="form-group form-check mt-3">
			<input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
			<label class="form-check-label color-gray font14px" for="exampleCheck1"> <a href="#"class="gray-color">ยอมรับนโยบายการเก็บข้อมูล</a></label>
            </div>
            <div class="form-group"> 
            <a class="btn btn-primary btn-block"  role="button" onclick="SubmitForm($('#form_main'));" >Log In</a>                 
            </div>
            <div class="text-center">
            <a href="#" class="forgot" data-toggle="modal" data-target="#NewUserModel">ลงทะเบียน | </a> 
            <a href="#" class="forgot">คู่มือ</a>
            </div>
</form>
</div>

    

    
    <!-- ForgetPWModal -->
<div class="modal fade" id="ForgetPWModal" data-backdrop="static"  data-keyboard="false"  tabindex="-1" aria-labelledby="ForgetPWModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ForgetPWModal">รีเซตรหัสผ่าน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <strong>ระบุหมายเลขบัตรประชาชน</strong>
        <form>
              <div class="form-group">
                <label for="idcard">เลขบัตรประชาชน <span class="red-text">**</span></label>
                <input type="text" class="feild--form" id="idcard" aria-describedby="idcard" placeholder="กรุณากรอกเลขบัตรประชาชน"> 
              </div>
		</form>
          
          
          <div class="text-center">
          <div class="alert alert-success alert-dismissible fade show" role="alert">
             ระบบได้ทำการส่งรหัสผ่านของท่านไปยังอีเมลที่ได้ลงทะเบียนไว้ กรุณาตรวจสอบอีเมลของท่านค่ะ
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
             กรุณาตรวจสอบเลขบัตรประชาชนที่ถูกต้องของท่านค่ะ!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              
          </div>
      </div>
        
      <div class="modal-footer">
            <button type="button" class="btn btn--submit">ตกลง</button>
            <button type="button" class="btn btn--cancel" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
</div>
    
     <!-- NewUserModel -->
<div class="modal fade" id="NewUserModel" data-backdrop="static"  data-keyboard="false"  tabindex="-1" aria-labelledby="NewUserModelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="NewUserModel">ลงทะเบียน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
         <h6 class="mb-3">เนื่องจาก ศสช. ได้เปลี่ยนวิธีการเข้าสู่ระบบอินทราเน็ตใหม่คือ รหัสผู้ใช้ (Username) และรหัสผ่าน (Password) ของอีเมล กปส. (name.s@prd.go.th) ดังนั้น สำหรับผู้ที่ยังไม่มีอีเมล กปส.และยังไม่มีรหัสผู้ใช้งานอินทราเน็ต สามารถลงทะเบียนขอใช้อีเมลได้ตามขั้นตอนดังนี้</h6> 
        
          <form>
            <!-- ส่วนที่ 1 เมื่อกรอกรหัสบัตรปชช แล้วกดปุ่ม ส่ง ระบบจะทำการเข้าไปกวาดหาจากฐานข้อมูล หากพบ ก็ทำการดึงมาแสดงในฟิลด์ บัตรประชาชน ทันที และแสดงส่วนที่ 2 ขึ้นมาทันที หากไม่เจอจะแสดงการแจ้งเตือน -->
              
              <strong>ขั้นตอนที่ 1 : ระบุหมายเลขบัตรประชาชน</strong>
              
              <div class="form-group">
                <label for="idcard">เลขบัตรประชาชน <span class="red-text">**</span></label>
                <input type="text" class="feild--form" id="idcard" aria-describedby="idcard" placeholder="กรอกเลขบัตรประชาชน" > 
                <input type="password" class="feild--form mt-1" id="idcard" placeholder="3321100093021" disabled>
              </div>
                   
			<div class="text-center">
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<small>กรุณาตรวจสอบเลขบัตรประชาชนที่ถูกต้องของท่านค่ะ!</small>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>

        <!-- ส่วนที่ 2 เมื่อกรอกรหัสบัตรปชช แล้วกดปุ่ม ส่ง ระบบจะทำการเข้าไปกวาดหาจากฐานข้อมูล หากพบ ก็ทำการดึงมาแสดงในฟิลด์ บัตรประชาชน ทันที หากไม่เจอจะแสดงการแจ้งเตือน -->
          <strong>ขั้นตอนที่ 2 : แบบฟอร์มลงทะเบียน</strong> 
            <div class="form-row">           
                <div class="form-group col-md-6">
                  <label for="inputEmail4">ชื่อ-สกุล(ไทย)</label>
                  <input type="email" class="feild--form" id="name" placeholder="ลลิษา มโนบาล" disabled>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword4">รหัสผู้ใช้(username)</label>
                  <input type="password" class="feild--form" id="inputPassword4" placeholder="lalisa_m@prd.go.th">
						<div class="form-text font-detial-form"> username คือชื่อภาษาอังกฤษตามด้วย _(underscore)และอักษรตัวแรกของนามสกุล หากซ้ำกับผู้ลงทะเบียนก่อนหน้า สามารถใช้ 2 ตัวอักษรแรกของนามสกุลแทนได้ </div>
<!--                    <small>username คือชื่อภาษาอังกฤษตามด้วย _(underscore)และอักษรตัวแรกของนามสกุล หากซ้ำกับผู้ลงทะเบียนก่อนหน้า สามารถใช้ 2 ตัวอักษรแรกของนามสกุลแทนได้</small>-->
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword4">รหัสผ่าน(password)</label>
                  <input type="password" class="feild--form" id="inputPassword4" placeholder="ระบุ password">
<!--                    <small>username คือชื่อภาษาอังกฤษตามด้วย _(underscore)และอักษรตัวแรกของนามสกุล หากซ้ำกับผู้ลงทะเบียนก่อนหน้า สามารถใช้ 2 ตัวอักษรแรกของนามสกุลแทนได้</small>-->
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword4">ยืนยันรหัสผ่านอีกครั้ง</label>
                  <input type="text" class="feild--form" id="inputPassword4" placeholder="ยืนยัน password อีกครั้ง">
                   
                </div>
				
				<div class="text-center">
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<small>กรุณาตรวจสอบ Username ของท่านเนื่องจากมีข้อมูลนี้ในระบบแล้วค่ะ!  </small>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
                
                <strong class="mb-3">ป้อนข้อมูล Security Question กรณีลืมรหัสผ่าน</strong>
                <div class="form-group col-md-6">
                  <label for="inputQuestion">คำถาม</label>
                  <select class="feild--form" id="inputQuestion">
      <option>สัตว์เลี้ยงของคุณชื่ออะไร?</option>
      <option>ปลาในภาษาอังกฤษคือ</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
                   
                </div>
                
                <div class="form-group col-md-6">
                  <label for="inputAnswer">คำตอบ</label>
                  <input type="text" class="feild--form" id="inputAnswer" placeholder="กรอกคำตอบ">
                </div>
                
            </div>
            <hr>
            <div class="text-center">
                <button type="button" class="btn btn--submit">ตกลง</button>
                <button type="button" class="btn btn--cancel" data-dismiss="modal">ยกเลิก</button>
            </div> 
        </form>
          

      </div>
        
<!--
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-primary">ตกลง</button>
      </div>
-->
</div>
</div>
</div>   
    
    
<script src="assets/login/assets/js/jquery.min.js"></script>
<script src="assets/login/assets/js/bootstrap.bundle.min.js"></script>
<?php include 'script_footer.php';?> 
</body>
</html>