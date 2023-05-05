<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> DIPROM INTRANET </title>
  <!-- Open Add Code 12/05/2565 -->
  <link rel="shortcut icon" href="assets/img/favicon.png" />
  <!-- Close Add Code 12/05/2565 -->
  <link rel="stylesheet" href="assets/login/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/login/assets/js/ionicons.min.css">
  <link rel="stylesheet" href="assets/login/assets/css/style.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/login/assets/css/prompt.css">


<!-- Font Awesome Free 5.15.4 -->
<link rel="stylesheet" href="assets/css/all.css">
 <!-- Font Awesome Free 5.15.4 -->
 <script src="assets/js/all.js"></script>

</head>


<style> 
  .feild--form{
    border: 1px solid #981c9d;
    border-radius: 5px;
  }
  .icon_eye{
    position: absolute;
    top: 59%;
    left: 82%;
    font-size: 30px;
  }
  @media (min-width: 768px) { 
    .icon_eye{
      top: 59%;
      left: 87%;
  }
}
</style>
<body>
  <div class="login-dark">
    <form id="form_main" name="form_main" action="func_login.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="proc" id="proc" value="Login">
      <h2 class="sr-only">Login Form</h2>

      <div class="illustration">
        <img src="assets/login/assets/img/logo_color.png" class="img-fluid mb-3">
        <div class="welcome"> Welcome to </div>
        <div class="diprom"> DIPROM </div>
        <div class="diprom-fullname"> DEPARTMENT OF INDUSTRIAL PROMOTION </div> 
      </div>

      <div class="form-group">
        <label for="username" hidden>Username</label>
        <input class="form-control" type="text" name="username" placeholder="Username" required="required">
      </div>

      <div class="form-group">
        <label for="password" hidden>Password</label>
        <div id="show_hide_password">
           <input class="form-control checkpassword" type="password" name="password"  id="password" placeholder="Password" maxlength="16" required="required">
           <div class="input-group-addon icon_eye" >
				 <i class="bi bi-eye-slash" id="togglePassword" style="color: black;"></i>
           </div>
        </div>

        <!-- <input type="password" class="form-control pass-swap col-8" placeholder="Password">
            <div class="input-group-append col-8">
                <button class="btn btn-light">
                   <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
            </div>    -->
      </div>

	
      <!--
      <div class="text-center">
        <a href="#" class="forgot" data-toggle="modal" data-target="#ForgetPWModal">ลืมรหัสผ่าน ? </a>
      </div>
      -->

      <div class="form-group form-check mt-3 text-center">
        <input type="checkbox" class="form-check-input" name="policy_check" id="policy_check" checked>
        <label class="form-check-label color-gray font14px" for="policy_check"> <a href="#" class="gray-color">ยอมรับนโยบายการเก็บข้อมูล</a></label>
      </div>

      <div class="form-group">
        <a class="btn btn-primary btn-block" role="button" onclick="SubmitForm($('#form_main'));">เข้าสู่ระบบ</a>
      </div>

      <div class="text-center" style="font-weight: normal;">
		 <a href="#" class="forgot" data-toggle="modal" data-target="#NewUserModel">วิธีการสมัครสมาชิก | </a>
        <!-- <a href="http://203.151.166.133/DIP_SSO/public/workflow.php?wfp=WNzNrMmw0ZTR3NDA1ZzRhNHI0bzRmM3E1aTRwNHEzdzNiMjI0eDJlMnY0bjM=" class="forgot" data-toggle="modal" data-target="#NewUserModel">สมัครสมาชิก  </a> -->
        <a href="https://portal.diprom.go.th/DIP_SSO/public/workflow.php?wfp=WNzNrMmw0ZTR3NDA1ZzRhNHI0bzRmM3E1aTRwNHEzdzNiMjI0eDJlMnY0bjM=" target="_blank" rel="noopener noreferrer" class="forgot" >สมัครสมาชิก  </a>
        <!-- <a href="http://" target="_blank" rel="noopener noreferrer"></a> -->
        <!-- <a href="assets/download/PRD_INTRA_64_Manual_ADMIN.pdf" class="forgot" target="_blank"> คู่มือ Admin | </a>
        <a href="assets/download/PRD_INTRA_64_Manual_User.pdf" class="forgot" target="_blank"> คู่มือ User </a> -->
      </div>
      <div class="diprom-fullname text-center mt-2 mb-0" style="letter-spacing: 1px;">
      Version 1.0 <!-- Update 21/04/2566 -->
      </div>
    </form>
  </div>

  <!-- ForgetPWModal -->
  <div class="modal fade" id="ForgetPWModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ForgetPWModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ForgetPWModal">รีเซตรหัสผ่าน</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="forgetForm">
          <div class="modal-body">
            <strong>ระบุหมายเลขบัตรประชาชน</strong>
            <div class="form-group">
              <label for="fg_id_card">เลขบัตรประชาชน <span class="red-text">**</span></label>
              <input type="text" class="feild--form" name="fg_id_card" id="fg_id_card" placeholder="กรุณากรอกเลขบัตรประชาชน" oninput="forget('forget');">
            </div>

            <div class="form-group" id="list_fg_m_email" style="display: none;">
              <input type="radio" name="fg_email" id="fg_m_email">
              <label for="fg_cut_m_email">อีเมล 1</label>
              <input type="text" class="feild--form" id="fg_cut_m_email" value="ii****m@gmail.com" disabled>
            </div>

            <div class="form-group" id="list_fg_u_email" style="display: none;">
              <input type="radio" name="fg_email" id="fg_u_email">
              <label for="fg_cut_u_email">อีเมล 2</label>
              <input type="text" class="feild--form" id="fg_cut_u_email" value="ii****m@prd.com" disabled>
            </div>

            <div class="text-center">
              <div class="alert alert-success alert-dismissible fade show" role="alert" id="list_ck_fg_success" style="display:none;">
                <small id="m_fg_success"></small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="alert alert-danger alert-dismissible fade show" role="alert" id="list_ck_fg_danger" style="display:none;">
                <small id="m_fg_danger"></small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type="hidden" name="Flag" id="Flag" value="Forget">
            <button type="submit" name="btn_submit_fg" id="btn_submit_fg" class="btn btn--submit" disabled>ตกลง</button>
            <button type="button" class="btn btn--cancel" data-dismiss="modal">ยกเลิก</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- NewUserModel -->
  <div class="modal fade" id="NewUserModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="NewUserModelLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="NewUserModel"> สร้างบัญชี </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="registerForm">
            <!-- ส่วนที่ 1 เมื่อกรอกรหัสบัตรปชช แล้วกดปุ่ม ส่ง ระบบจะทำการเข้าไปกวาดหาจากฐานข้อมูล หากพบ ก็ทำการดึงมาแสดงในฟิลด์ บัตรประชาชน ทันที และแสดงส่วนที่ 2 ขึ้นมาทันที หากไม่เจอจะแสดงการแจ้งเตือน -->
            <strong> กรอกรายละเอียดอย่างครบถ้วน เพียงเท่านี้คุณสามารถเข้าถึงบริการต่างๆ ของ DIP Portal ได้อย่างง่ายดาย </strong>
            <!--
            <a href="https://forms.gle/SMv7di1bdYBy5k6A8" target="_blank" class="btn-fileform my-3">
              <div class="text-center">
                >> แบบฟอร์มขอสร้างบัญชี << </div>
            </a>
            -->
            

            <!-- ส่วนที่ 2 เมื่อกรอกรหัสบัตรปชช แล้วกดปุ่ม ส่ง ระบบจะทำการเข้าไปกวาดหาจากฐานข้อมูล หากพบ ก็ทำการดึงมาแสดงในฟิลด์ บัตรประชาชน ทันที หากไม่เจอจะแสดงการแจ้งเตือน -->
            <!-- <strong>ขั้นตอนที่ 2 : แบบฟอร์มลงทะเบียน</strong> -->
            <div class="form-row mt-3">
              <!-- <img src="assets/login/assets/img/icon_user1.png" style="max-width: 35px;"> -->
              <h4 class="w-100">  ชื่อผู้สมัคร  </h4>

              <!--------------------------- Open Code Demo ---------------------------------->
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label for="txt_org_list_title_thai"> คำนำหน้าชื่อ  <span class="red-text">*</span> </label>
                <select name="txt_org_list_title_thai" id="txt_org_list_title_thai" class="selectpicker  feild--form" required="required" data-live-search="true" title="คำนำหน้าชื่อ">
                    <option class="bs-title-option" value=""> เลือกคำนำหน้าชื่อ </option>
                    <option value="2">นาง</option>
                    <option value="3">นางสาว</option>
                    <option value="6">นาย</option>
                    <option value="12">ดร.</option>
                    <option value="14">หม่อมหลวง</option>
                    <option value="17">หม่อมราชวงศ์</option>
                    <option value="19">พลตำรวจโท</option>
                    <option value="21">ร้อยตรี</option>
                    <option value="23">ว่าที่ร้อยตรี</option>
                </select>
              </div>

              <div class="form-group col-md-6 col-sm-6 col-12">
                <label for="nickname_thai">ชื่อเล่น <span class="red-text">*</span></label>
                <input type="text" class="feild--form" name="nickname_thai" id="nickname_thai" placeholder="ชื่อเล่น" required>
              </div>

              <!--------------------------- Close Code Demo ---------------------------------->

              <div class="form-group col-md-6 col-sm-6 col-12">
                <label for="name_thai">ชื่อภาษาไทย <span class="red-text">*</span></label>
                <input type="text" class="feild--form" name="name_thai" id="name_thai" placeholder="ชื่อภาษาไทย" required>
              </div>

              <div class="form-group col-md-6 col-sm-6 col-12">
                <label for="surname_thai">นามสกุลภาษาไทย <span class="red-text">*</span> </label>
                <input type="text" class="feild--form" name="surname_thai" id="surname_thai" placeholder="นามสกุลภาษาไทย" required>
              </div>

              <!--------------------------- Open Code Demo ---------------------------------->
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label for="name_thai">ชื่อภาษาอังกฤษ <span class="red-text">*</span></label>
                <input type="text" class="feild--form" name="name_en" id="name_en" placeholder="ชื่อภาษาอังกฤษ" required>
              </div>

              <div class="form-group col-md-6 col-sm-6 col-12">
                <label for="surname_thai">นามสกุลภาษาอังกฤษ <span class="red-text">*</span> </label>
                <input type="text" class="feild--form" name="surname_en" id="surname_en" placeholder="นามสกุลภาษาอังกฤษ" required>
              </div>


              <h4 class="w-100 mt-3"> ข้อมูลการทำงาน </h4>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_pos_name"> ตำแหน่งการบริหารงาน  <span class="red-text">*</span> </label>
                  <select name="txt_org_list_pos_name" id="txt_org_list_pos_name" class="selectpicker  feild--form" required="required" data-live-search="true" title="ตำแหน่งการบริหารงาน" tabindex="-98">
                    <option class="bs-title-option" value=""> เลือกตำแหน่งการบริหารงาน </option>
                    <option value="222">กลุ่มพัฒนาระบบบริหาร</option>
                    <option value="191">กองกฎหมายและระเบียบ</option>
                    <option value="190">กองการเจ้าหน้าที่</option>
                    <option value="189">กองคลัง</option>
                    <option value="187">ผู้เชี่ยวชาญ / ที่ปรึกษา</option>
                    <option value="186">รองอธิบดีกรมประชาสัมพันธ์</option>
                    <option value="204">ศูนย์ปฎิบัติการข้อมูลข่าวสารเพื่อการประชาสัมพันธ์ กรมประชาสัมพันธ์</option>
                    <option value="221">ศูนย์ประชาสัมพันธ์ กอ.รมน.ภาค 4 สน. จ.ปัตตานี</option>
                    <option value="184">ศูนย์เทคโนโลยีสารสนเทศการประชาสัมพันธ์</option>
                    <option value="192">สถานีวิทยุกระจายเสียงแห่งประเทศไทย</option>
                    <option value="200">สถานีวิทยุกระจายเสียงแห่งประเทศไทยเพื่อการศึกษา</option>
                    <option value="193">สถานีวิทยุโทรทัศน์แห่งประเทศไทย</option>
                    <option value="201">สถาบันการประชาสัมพันธ์</option>
                    <option value="202">สหกรณ์ออมทรัพย์กรมประชาสัมพันธ์ จำกัด</option>
                    <option value="194">สำนักการประชาสัมพันธ์ต่างประเทศ</option>
                    <option value="195">สำนักข่าว</option>
                    <option value="213">สำนักงานประชาสัมพันธ์จังหวัดในภาค 1</option>
                    <option value="226">สำนักงานประชาสัมพันธ์จังหวัดในภาค 2</option>
                    <option value="214">สำนักงานประชาสัมพันธ์จังหวัดในภาค 3</option>
                    <option value="215">สำนักงานประชาสัมพันธ์จังหวัดในภาค 4</option>
                    <option value="216">สำนักงานประชาสัมพันธ์จังหวัดในภาค 5</option>
                    <option value="217">สำนักงานประชาสัมพันธ์จังหวัดในภาค 6</option>
                    <option value="218">สำนักงานประชาสัมพันธ์จังหวัดในภาค 7</option>
                    <option value="219">สำนักงานประชาสัมพันธ์จังหวัดในภาค 8</option>
                    <option value="188">สำนักงานเลขานุการกรม</option>
                    <option value="205">สำนักประชาสัมพันธ์เขต 1 ขอนแก่น</option>
                    <option value="206">สำนักประชาสัมพันธ์เขต 2 อุบลราชธานี</option>
                    <option value="207">สำนักประชาสัมพันธ์เขต 3 เชียงใหม่</option>
                    <option value="208">สำนักประชาสัมพันธ์เขต 4 พิษณุโลก</option>
                    <option value="209">สำนักประชาสัมพันธ์เขต 5 สุราษฎร์ธานี</option>
                    <option value="210">สำนักประชาสัมพันธ์เขต 6 สงขลา</option>
                    <option value="211">สำนักประชาสัมพันธ์เขต 7 จันทบุรี</option>
                    <option value="212">สำนักประชาสัมพันธ์เขต 8 กาญจนบุรี</option>
                    <option value="196">สำนักพัฒนาการประชาสัมพันธ์</option>
                    <option value="197">สำนักพัฒนานโยบายและแผนการประชาสัมพันธ์</option>
                    <option value="220">สำนักสารสนเทศและประชาสัมพันธ์ ศูนย์อำนวยการบริหารจังหวัดชายแดนภาคใต้ จ.ยะลา (ศอ.บต.)</option>
                    <option value="198">สำนักส่งเสริมและพัฒนางานเทคนิค</option>
                    <option value="199">หน่วยตรวจสอบภายใน</option>
                    <option value="185">อธิบดีกรมประชาสัมพันธ์</option>
                </select>
              </div>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_pos_person"> ตำแหน่งในสายงาน <span class="red-text">*</span></label>
                <input type="text" class="feild--form" name="txt_org_list_pos_person" id="txt_org_list_pos_person" placeholder="ตำแหน่งในสายงาน" required>
              </div>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_pos_level_name"> ระดับตำแหน่ง  <span class="red-text">*</span> </label>
                  <select name="txt_org_pos_level_name" id="txt_org_pos_level_name" class="selectpicker  feild--form" required="required" data-live-search="true" title="ระดับตำแหน่ง" tabindex="-98">
                      <option class="bs-title-option" value=""> เลือกระดับตำแหน่ง </option>
                      <option value="1">Admin</option>
                      <option value="2">Telephone</option>
                      <option value="3">Visitor</option>
                      <option value="4">สมาชิกภายนอกทั่วไป</option>
                  </select>
              </div>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_afft_name">สังกัด </label>
                <input type="text" class="feild--form" name="txt_org_list_afft_name" id="txt_org_list_afft_name" placeholder="สังกัด">
              </div>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_org_name"> หน่วยงานที่ปฏิบัติงานจริง  <span class="red-text">*</span> </label>
                  <select name="txt_org_list_org_name" id="txt_org_list_org_name" class="selectpicker  feild--form" required="required" data-live-search="true" title="หน่วยงานที่ปฏิบัติงานจริง" tabindex="-98">
                    <option class="bs-title-option" value=""> เลือกหน่วยงานที่ปฏิบัติงานจริง </option>
                    <option value="222">กลุ่มพัฒนาระบบบริหาร</option>
                    <option value="191">กองกฎหมายและระเบียบ</option>
                    <option value="190">กองการเจ้าหน้าที่</option>
                    <option value="189">กองคลัง</option>
                    <option value="187">ผู้เชี่ยวชาญ / ที่ปรึกษา</option>
                    <option value="186">รองอธิบดีกรมประชาสัมพันธ์</option>
                    <option value="204">ศูนย์ปฎิบัติการข้อมูลข่าวสารเพื่อการประชาสัมพันธ์ กรมประชาสัมพันธ์</option>
                    <option value="221">ศูนย์ประชาสัมพันธ์ กอ.รมน.ภาค 4 สน. จ.ปัตตานี</option>
                    <option value="184">ศูนย์เทคโนโลยีสารสนเทศการประชาสัมพันธ์</option>
                    <option value="192">สถานีวิทยุกระจายเสียงแห่งประเทศไทย</option>
                    <option value="200">สถานีวิทยุกระจายเสียงแห่งประเทศไทยเพื่อการศึกษา</option>
                    <option value="193">สถานีวิทยุโทรทัศน์แห่งประเทศไทย</option>
                    <option value="201">สถาบันการประชาสัมพันธ์</option>
                    <option value="202">สหกรณ์ออมทรัพย์กรมประชาสัมพันธ์ จำกัด</option>
                    <option value="194">สำนักการประชาสัมพันธ์ต่างประเทศ</option>
                    <option value="195">สำนักข่าว</option>
                    <option value="213">สำนักงานประชาสัมพันธ์จังหวัดในภาค 1</option>
                    <option value="226">สำนักงานประชาสัมพันธ์จังหวัดในภาค 2</option>
                    <option value="214">สำนักงานประชาสัมพันธ์จังหวัดในภาค 3</option>
                    <option value="215">สำนักงานประชาสัมพันธ์จังหวัดในภาค 4</option>
                    <option value="216">สำนักงานประชาสัมพันธ์จังหวัดในภาค 5</option>
                    <option value="217">สำนักงานประชาสัมพันธ์จังหวัดในภาค 6</option>
                    <option value="218">สำนักงานประชาสัมพันธ์จังหวัดในภาค 7</option>
                    <option value="219">สำนักงานประชาสัมพันธ์จังหวัดในภาค 8</option>
                    <option value="188">สำนักงานเลขานุการกรม</option>
                    <option value="205">สำนักประชาสัมพันธ์เขต 1 ขอนแก่น</option>
                    <option value="206">สำนักประชาสัมพันธ์เขต 2 อุบลราชธานี</option>
                    <option value="207">สำนักประชาสัมพันธ์เขต 3 เชียงใหม่</option>
                    <option value="208">สำนักประชาสัมพันธ์เขต 4 พิษณุโลก</option>
                    <option value="209">สำนักประชาสัมพันธ์เขต 5 สุราษฎร์ธานี</option>
                    <option value="210">สำนักประชาสัมพันธ์เขต 6 สงขลา</option>
                    <option value="211">สำนักประชาสัมพันธ์เขต 7 จันทบุรี</option>
                    <option value="212">สำนักประชาสัมพันธ์เขต 8 กาญจนบุรี</option>
                    <option value="196">สำนักพัฒนาการประชาสัมพันธ์</option>
                    <option value="197">สำนักพัฒนานโยบายและแผนการประชาสัมพันธ์</option>
                    <option value="220">สำนักสารสนเทศและประชาสัมพันธ์ ศูนย์อำนวยการบริหารจังหวัดชายแดนภาคใต้ จ.ยะลา (ศอ.บต.)</option>
                    <option value="198">สำนักส่งเสริมและพัฒนางานเทคนิค</option>
                    <option value="199">หน่วยตรวจสอบภายใน</option>
                    <option value="185">อธิบดีกรมประชาสัมพันธ์</option>
                </select>
              </div>


              <!--------------------------- Close Code Demo ------------------------------->

              

              <!--------------------------- Open Code Demo ------------------------------->
              
              <h4 class="w-100 mt-3"> ข้อมูลการติดต่อ </h4>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_tel_in"> หมายเลขโทรศัพท์ <span class="red-text">*</span></label>
                <input type="text" class="feild--form" name="txt_org_list_tel_in" id="txt_org_list_tel_in" placeholder="หมายเลขโทรศัพท์" required>
                <div class="form-text font-detial-form font11px text-danger">
                  กรุณากรอกหมายเลขโทรศัพท์เป็นตัวเลขให้ครบ
                </div>
              </div>

              <!-- เพิ่มฟิลดิ์โทรสารที่ Organize ด้วย -->
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_teletext"> หมายเลขโทรสาร <span class="red-text">*</span></label>
                <input type="text" class="feild--form" name="txt_org_list_teletext" id="txt_org_list_teletext" placeholder="หมายเลขโทรสาร" required>
                <div class="form-text font-detial-form font11px text-danger">
                  กรุณากรอกหมายเลขโทรสาร (Fax) เป็นตัวเลขให้ครบ
                </div>
              </div>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_mobile"> หมายเลขมือถือ <span class="red-text">*</span></label>
                <input type="text" class="feild--form" name="txt_org_list_mobile" id="txt_org_list_mobile" placeholder="หมายเลขมือถือ" required>
                <div class="form-text font-detial-form font11px text-danger">
                  กรุณากรอกหมายเลขมือถือเป็นตัวเลขให้ครบ 10 หลัก
                </div>
              </div>

              <!-- open ส่วนนี้ Coding ไปแล้ว -->
              <div class="form-group col-md-12">
                <label for="email_person">อีเมล <span class="red-text">*</span></label>
                <input type="email" class="feild--form" name="email_person" id="email_person" placeholder="email" required>
                <div class="form-text font-detial-form font11px text-danger">
                  กรุณากรอกอีเมลให้ตรงตามรูปแบบ เช่น email@mail.com เป็นต้น
                </div>
              </div>

              <div class="text-center" id="list_ck_username" style="display:none;">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <small id="m_username"></small>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <!-- Close ส่วนนี้ Coding ไปแล้ว -->

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_line_id"> ไอดีไลน์ </label>
                <input type="text" class="feild--form" name="txt_org_list_line_id" id="txt_org_list_line_id" placeholder="ไอดีไลน์">
              </div>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_address"> ที่อยู่ </label>
                <textarea rows="5" type="text" class="feild--form" name="txt_org_list_address" id="txt_org_list_address" placeholder="ที่อยู่" ></textarea>
              </div>

              <!--------------------------- Close Code Demo ------------------------------->

              <!-- <strong> แนบแบบฟอร์ม <span class="red-text">*</span> </strong> -->
              <div class="form-group col-md-12">
                <label for="fileattach">ภาพประจำตัว <span class="red-text">*</span></label>
                <input type="file" class="feild--form form-control-file" name="file_attach" id="file_attach" placeholder="ภาพประจำตัว" required>
                <div class="form-text font-detial-form font11px text-danger">
                  ประเภทไฟล์ที่สามารถใช้ได้คือ jpg,gif,png,svg และมีขนาดไฟล์ต้องไม่เกิน 20 MB.
                </div>
              </div>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_gen_pass"> รหัสผ่าน <span class="red-text">*</span></label>
                <input type="text" class="feild--form" name="txt_org_list_gen_pass" id="txt_org_list_gen_pass" placeholder="รหัสผ่าน" required>
                <div class="form-text font-detial-form font11px text-danger">
                  กรอกข้อมูลเป็นภาษาอังกฤษหรือตัวเลข 8 - 16 ตัวอักษร
                </div>
              </div>

              <div class="form-group col-md-12 col-sm-12 col-12">
                <label for="txt_org_list_gen_confirmpass"> ยืนยันรหัสผ่าน <span class="red-text">*</span></label>
                <input type="text" class="feild--form" name="txt_org_list_gen_confirmpass" id="txt_org_list_gen_confirmpass" placeholder="ยืนยันรหัสผ่าน" required>
                <div class="form-text font-detial-form font11px text-danger">
                  กรอกข้อมูลเป็นภาษาอังกฤษหรือตัวเลข 8 - 16 ตัวอักษร
                </div>
              </div>


              <div class="text-center">
                ในการสร้างบัญชี หมายความว่าคุณยอมรับ<a href="download/policy/PRIVACY_POLICY_BIZAPP_2563.pdf" target="_blank"><spen style="color:#981c9d;">นโยบายความเป็นส่วนตัว </spen></a> และ <a href="#">
                <spen style="color:#981c9d;">ข้อกำหนดการใช้</spen>  
                </a> ของ DIP Portal
              </div>

              <div class="form-group form-check mt-3 mx-auto">
                <input type="checkbox" class="form-check-input" name="policy_check_reqister" id="policy_check_reqister">
                <label class="form-check-label color-gray font14px" for="policy_check_reqister"> <a href="#" class="gray-color">ยอมรับนโยบายการเก็บข้อมูล</a></label>
              </div>

              <div class="form-group col-md-12">
                <div class="text-center" id="list_ck_policy" style="display:none;">
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <small id="m_policy">กรุณาติ๊กยอมรับนโยบายการเก็บข้อมูล</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <hr>

            <div class="text-center">
              <input type="hidden" name="Flag" id="Flag" value="AddUser">
              <button type="submit" name="btn_submit" id="btn_submit" class="btn " style="background: -webkit-linear-gradient(90deg, #82288c 0%, #ff54ff 100%); color:#fff;"> สร้างบัญชี </button>
              <button type="button" class="btn" style="background-color: #ccc; color: #fff;" data-dismiss="modal">ยกเลิก</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/login/assets/js/jquery.min.js"></script>
  <script src="assets/login/assets/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="js/ajax/register.js"></script>
  <script type="text/javascript" src="js/ajax/forgetpassword.js"></script>
  <?php include 'script_footer.php'; ?>






</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toggle Password Visibility</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });

        // prevent form submit
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    </script>
</body>

</html>