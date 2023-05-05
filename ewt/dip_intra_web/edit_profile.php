<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->

<!-- Font on Website -->
<link rel="stylesheet" href="assets/css/profile.css">
<style>
  .header--bg {
    padding: 50px 0px 0px 0px;
    background: #EEEEEE;
    text-align: center;
  }
</style>

<div class="container-fluid b__profile mar-t-90px">
  <div class="container py-5 text-center">
    <h3><i class="fa fa-user"></i> ข้อมูลส่วนตัว</h3>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-12">
        <?php include 'profile_menu.php'; ?>
      </div>

      <div class="col-lg-9 col-md-9 col-12">
        <div class="bg--white shadow">
          <form id="profile_form">
            <div class="card card-carousel">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="firstDataList" class="label-form"> คำนำหน้า <span class="txt-red">*</span> </label>
                  <!-- <input type="text" class="form-control" name="title_thai" id="title_thai" value="" readonly></input> -->
                  <select class="form-control" name="title_thai" id="title_thai">
                    <?php foreach ($user_title as $value) { ?>
                      <option value="<?php echo $value['title_thai']; ?>" <?php echo ($value['title_thai'] == $title_name) ? "selected" : null; ?>>
                        <?php echo $value['title_thai']; ?>
                        <?php echo (!empty($value['title_eng']) ? "/ " . $value['title_eng'] : null); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="firstDataList" class="label-form"> ชื่อ(ภาษาไทย) <span class="txt-red">*</span> </label>
                  <input type="text" class="form-control" placeholder="กรอกชื่อผู้ใช้" name="name_thai" id="name_thai" value="<?php echo $name_thai; ?>" readonly></input>
                </div>
                <div class="form-group col-md-4">
                  <label for="firstDataList" class="label-form"> นามสกุล(ภาษาไทย) <span class="txt-red">*</span> </label>
                  <input type="text" class="form-control" placeholder="กรอกนามสกุลผู้ใช้" name="surname_thai" id="surname_thai" value="<?php echo $surname_thai; ?>" readonly></input>
                </div>

                <div class="form-group col-md-4">
                  <label for="teluser" class="form-label label-form"> วัน/เดือน/ปี เกิด </label>
                  <!--<input type="date" class="form-control" id="teluser" placeholder="เลือกวันเดือนปีเกิด"> datepicker-->
                  <input type="text" name="birth_date" id="birth_date" placeholder="วันเดือนปีเกิด" class="form-control" value="<?php echo convDateThai($birth_day)['Date']; ?>" readonly>
                </div>

                <div class="form-group col-md-4">
                  <label for="name_eng" class="label-form"> ชื่อ(ภาษาอังกฤษ)<span class="txt-red"></span> </label>
                  <input type="text" class="form-control"  name="name_eng" id="name_eng" value="<?php echo $name_eng; ?>" readonly></input>
                </div>

                <div class="form-group col-md-4">
                  <label for="surname_eng" class="label-form"> นามสกุล(ภาษาอังกฤษ)<span class="txt-red"></span> </label>
                  <input type="text" class="form-control"  name="surname_eng" id="surname_eng" value="<?php echo $surname_eng; ?>" readonly></input>
                </div>

                <div class="form-group col-md-6">
                  <label for="department_name" class="label-form"> สังกัด (ตามโครงสร้าง)*<span class="txt-red"></span> </label>
                  <input class="form-control" name="department_name" id="department_name" value="<?php echo $name_department; ?>" disabled>
                </div>

                <div class="form-group col-md-6">
                  <label for="org_id" class="label-form"> สังกัด (ปฏิบัติงานจริง)*<span class="txt-red"></span> </label>
                  <input class="form-control" name="name_org" id="name_org" value="<?php echo $name_org; ?>" disabled>
                </div>

                <div class="form-group col-md-6">
                  <label for="pos_name" class="label-form"> ตำแหน่ง *<span class="txt-red"></span> </label>
                  <input class="form-control" list="Position" name="pos_name" id="pos_name" value="<?php echo $pos_name; ?>" disabled>
                </div>

                <div class="form-group col-md-6">
                  <label for="level_name" class="label-form"> ระดับตำแหน่ง*<span class="txt-red"></span> </label>
                  <input class="form-control" list="Affiliation" name="level_name" id="level_name" value="<?php echo $level_name; ?>" disabled>
                </div>

                <div class="form-group col-md-12">
                  <label for="email_person" class="label-form"> Email *<span class="txt-red"></span> </label>
                  <input type="email" class="form-control" name="email_person" id="email_person" aria-describedby="emailHelp" value="<?php echo $email_person; ?>" readonly>
                </div>

                <div class="form-group col-md-12">
                  <label for="tel_in" class="label-form"> หมายเลขโทรศัพท์ (เบอร์มือถือ)<span class="txt-red"></span> </label>
                  <input type="tel" class="form-control" name="tel_in" id="tel_in" placeholder="หมายเลขโทรศัพท์ เช่น 0912345678" value="<?php echo $tel_in; ?>">
                  <small>กรุณากรอกหมายเลขโทรศัพท์ที่ใช้งานอยู่จริงและกรอกในรุปแบบให้ถูกต้องเช่น 0912345678</small>
                </div>
              </div>
              
              <div class="alert alert-primary" role="alert">
                <strong>ตั้งค่าอื่นๆ</strong>
                <div class="row mt-3">
                  <div class="col-md-2">
                    <label for="birth_status" class="label-form"> ตั้งค่าสถานะวันเกิด *<span class="txt-red"></span> </label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="birth_status" id="birth_status" value="Y" <?php echo ($birth_status == "Y" ? "checked" : null); ?>>
                      <label class="form-check-label" for="">
                        เปิดสถานะ
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="birth_status" id="birth_status" value="N" <?php echo ($birth_status == "Y" ? null : "checked"); ?>>
                      <label class="form-check-label" for="">
                        ปิดสถานะ
                      </label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="webb_name" class="label-form"> นามสมมุติ<span class="txt-red"></span> </label>
                    <input type="text" class="form-control" name="webb_name" id="webb_name" placeholder="กรอกชื่อนามสมมุติ" value="<?php echo $webb_name; ?>">
                    <small>ชื่อสมมุติที่ใช้กับ Webboard หากไม่ได้กรอกจะดึงชื่อจริงไปแสดงที่เว็บบอร์ด</small>
                  </div>
                  <div class="col-md-6">
                    <label for="path_image" class="label-form"> Profile Picture<span class="txt-red"></span> </label>
                    <div class="d-flex flex-row align-items-center"> <img src="<?php echo $path_image; ?>" width="60" class="rounded" alt="<?php echo $full_name; ?>" title="<?php echo $full_name; ?>">
                      <div class="ml-3"><input type="file" class="form-control-file" name="path_image" id="path_image"></div>
                    </div>
                    <small>* ขนาดของภาพที่เหมาะสมควรเป็น 200x200px</small>
                  </div>
                </div>
              </div>
            </div>

            <!-- แคปชา -->
            <div class="col-12 text-center">
              <div class="mb-3 mt-3 form-check txt-center">
                <input type="checkbox" name="policy_check" id="policy_check" checked>
                <label class="form-check-label" for="policy_check">
                  <a href="assets/download/policy.pdf" target="_blank">
                    ยินยอมนโยบายการเก็บข้อมูลของกรมส่งเสริมอุตสาหกรรม </a>
                </label>
              </div>
              <div class="txt-center mb-5">
                <button type="submit" class="btn btn-success btn-radius"> บันทึกการเปลี่ยนแปลงข้อมูล </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on("click", ".browse", function() {
    var file = $(this)
      .parent()
      .parent()
      .parent()
      .find(".file");
    file.trigger("click");
  });
  $(document).on("change", ".file", function() {
    $(this)
      .parent()
      .find(".form-control")
      .val(
        $(this)
        .val()
        .replace(/C:\\fakepath\\/i, "")
      );
  });
</script>

<script>
  $(document).ready(function() {
    $("#profile_form").on("submit", function(event) {
      event.preventDefault();
      let formData = new FormData($(this)[0]);
      let policy_check = document.getElementById("policy_check").checked;

      if (policy_check == true) {
        $.ajax({
          url: "ajax/setting_profile.ajax.php",
          data: formData,
          processData: false,
          contentType: false,
          type: "POST",
          success: function(data) {
            let object = JSON.parse(data, true);
            if (object.message !== null) {
              $.alert({
                title: object.message,
                content: 'Success!',
                icon: 'fa fa-check-circle',
                theme: 'modern',
                type: 'green',
                typeAnimated: true,
                boxWidth: '30%',
                buttons: {
                  ok: {
                    btnClass: 'btn-green'
                  }
                },
                onAction: function() {
                  location.reload(true);
                }
              });
            } else {
              $.alert({
                title: 'ไม่สามารถแก้ไขข้อมูลส่วนตัวได้',
                content: 'Error!',
                icon: 'fa fa-times-circle',
                theme: 'modern',
                type: 'red',
                typeAnimated: true,
                boxWidth: '30%',
                buttons: {
                  ok: {
                    btnClass: 'btn-red'
                  }
                },
                onAction: function() {
                  location.reload(true);
                }
              });
            }

            if (object.status == "captchaFailed") {
              $('#chkpic1_edit_profile').focus();
            } else if (object.status == "emailFailed" && $('#email_person').val() !== null) {
              $('#email_person').focus();
              $('#validation_email').show();
            } else if (object.status == "phoneFailed" && $('#tel_in').val() !== null) {
              $('#tel_in').focus();
              $('#validation_phone').show();
            } else if (object.status == "success") {
              // window.location.reload();
            }
          },
          error: function(data) {
            console.log('Error');
          }
        });
      } else {
        $.alert({
          title: 'กรุณาติ๊กยินยอมนโยบายการเก็บข้อมูลของกรมประชาสัมพันธ์',
          content: "Warning!",
          icon: 'fa fa-exclamation-circle',
          theme: 'modern',
          type: 'orange',
          closeIcon: false,
          buttons: {
            ok: {
              btnClass: 'btn-orange'
            }
          },
          onAction: function() {
            location.reload(true);
          }
        });
      }
    });
  });
</script>

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->