<?php include('comtop.php'); 
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php
      $s_gen_user_id  = " WHERE gen_user_id = $user_ewt[gen_user_id]";
      $_sql_pro     = " SELECT * FROM gen_user as gen
                        INNER JOIN title ON title.title_id = gen.title_thai
                        INNER JOIN emp_type ON emp_type.emp_type_id = gen.emp_type_id
                        INNER JOIN org_name ON org_name.org_id = gen.org_id 
                        INNER JOIN position_name ON position_name.pos_id = gen.posittion
                        INNER JOIN level ON level.level_id = gen.level_id
                        $s_gen_user_id";
      $a_data_pro   = db::getfetch($_sql_pro);

?>

<style>
    .icon-edit{
        position: absolute;
        bottom: 0px; 
        color:#82288c; 
        top: 4px; 
        right: 32px;
    }
    .image-upload>input {
  display: none;
}
</style>

<div class="container  mar-spacehead">
  <form id="form_main_img" name="form_main001_img" method="POST" action="pop_profile_img.php" enctype="multipart/form-data">
    <div class="row">
        <!-- picture profile -->
      
        <div class="col-lg-3 col-md-5 col-sm-12 col-12">
            <div class="line-pic-profile my-5"></div>
            <div>
                <img src="<?php echo $a_data_pro[path_image];?>" class=" shadow   box-pic-profile" alt="pictureProfile">
            <div class="image-upload">
            <label for="file-input">
            <!-- <i class="fa fa-plus-circle" aria-hidden="true"></i> -->
                <i class="fa-solid fa fa-plus-circle btn btn-change-pic" role="button"></i>
            </label>
                <input id="file-input" type="file" accept="image/*" />
    
               </div> 
            </div>
        </div>
      
        <!-- ข้อมูลส่วนตัว -->
        <div class="col-lg-9 col-md-7 col-sm-12 col-12 martop-profile">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                    <h2 class="h2-color "><?php echo $name_thai ."  ".$surname_thai; ?></h2>
                    <h3 class="mb-2"><?php echo $name_eng."  ".$surname_eng; ?></h3>
                    <p class="mb-0">หน่วยงานที่ปฏิบัติงานจริง :<span> <?php echo $a_data_pro[name_org];?> </span></p>
                    <p>สังกัด :<span> <?php echo $a_data_pro[afft_name];?>  </span></p>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <a  href="personal_information.php"  class="btn Gradient-Color border-ra-15px white-text  btn-sm">ข้อมูลส่วนบุคคล</a>
                </div>
            </div>
        </div>
    </div>
  </form>
    <div>
        <!-- ส่วนของข้อมูลผู้ใช้ -->
        <h2 class="h2-color pt-4">
        <i class="fa fa-user" aria-hidden="true"></i>
        
        ข้อมูลผู้ใช้งาน
        </h2>
        <hr class="hr_news mt-0">
        <div class="row pb-5">
            <!-- แบ่งฝั่งข้อมูล -->
            <div class="col-lg-8 col-md-8 col-sm-12 col-12 shadow-sm box-border-profile  px-3 py-3">
            
              <form id="form_main" name="form_main" method="POST" action="func_add_profile.php" enctype="multipart/form-data">

                <div class="row">
                <input type="hidden" name="Flag" id="Flag"  value="EditPro">
	              <input type="hidden" name="gen_user_id" id="gen_user_id" value="<?php echo $a_data_pro['gen_user_id'] ?>">

                <div class="form-group col-md-4">
                  <label for="name_thai" class="label-form"> ชื่อ(ภาษาไทย)<span class="txt-red"></span> </label>
                  <input type="text" class="form-control" id="name_thai" name="name_thai" placeholder="ชื่อ(ภาษาไทย)"  value="<?php echo $name_thai;?>"  readonly></input>
                </div>

                <div class="form-group col-md-4">
                  <label for="surname_thai" class="label-form"> นามสกุล(ภาษาไทย)<span class="txt-red"></span> </label>
                  <input type="text" class="form-control" id="surname_thai" name="surname_thai" placeholder="นามสกุล(ภาษาไทย)" value="<?php echo $surname_thai; ?>"readonly ></input>
                </div>

                <div class="form-group col-md-4">
                  <label for="nickname" class="label-form"> ชื่อเล่น  <span class="txt-red"></span> </label>
                  <input type="text" class="form-control" id="nickname_thai" name="nickname_thai" placeholder="ชื่อเล่น" value="<?php echo $a_data_pro[nickname_thai];?>"></input>
                </div>

                <div class="form-group col-md-4">
                  <label for="name_eng" class="label-form"> ชื่อ(ภาษาอังกฤษ)<span class="txt-red"></span> </label>
                  <input type="text" class="form-control" id="name_eng" name="name_eng" placeholder="ชื่อ(ภาษาอังกฤษ)"  value="<?php echo $name_eng;?>"  ></input>
                </div>

                <div class="form-group col-md-4">
                  <label for="surname_eng" class="label-form"> นามสกุล(ภาษาอังกฤษ)<span class="txt-red"></span> </label>
                  <input type="text" class="form-control" id="surname_eng" name="surname_eng" placeholder="นามสกุล(ภาษาอังกฤษ)" value="<?php echo $surname_eng; ?>" ></input>
                </div>

               <div class="form-group col-md-4">
                  <label for="surname_eng" class="label-form"> ตำแหน่งการบริหารงาน<span class="txt-red"></span> </label>
                  <input type="text" class="form-control" id="pos_name" name="pos_name"  placeholder="-"  value="<?php echo $a_data_pro[pos_name];?>" readonly></input>
                </div>
               
                <div class="form-group col-md-4">
                  <label for="surname_eng" class="label-form"> ตำแหน่งในสายงาน<span class="txt-red"></span> </label>
                  <input type="text" class="form-control" id="position_person" name="position_person" placeholder="-" value="<?php echo $a_data_pro[position_person];?>" readonly></input>
                </div>


                <div class="form-group col-md-4">
                  <label for="level_name" class="label-form"> ระดับตำแหน่ง*<span class="txt-red"></span> </label>
                  <input class="form-control" id="level_name" name="level_name"  placeholder="-" value="<?php echo $a_data_pro[level_name];?>"  disabled>
                </div>
                

                <div class="form-group col-md-4">
                  <label for="afft_name" class="label-form"> สังกัด*<span class="txt-red"></span> </label>
                  <input class="form-control" id="afft_name" name="afft_name" placeholder="-" value="<?php echo $a_data_pro[afft_name];?>" disabled>
                </div>


                <div class="form-group col-md-4">
                  <label for="name_org" class="label-form"> หน่วยงานที่ปฏิบัติงานจริง<span class="txt-red"></span> </label>
                  <input class="form-control" id="name_org" name="name_org" placeholder="-" value="<?php echo $a_data_pro[name_org];?>" disabled>
                </div>

                <div class="form-group col-md-4">
                  <label for="tel_in" class="label-form"> หมายเลขโทรศัพท์<span class="txt-red"></span> </label>
                  <input class="form-control" id="tel_in" name="tel_in" list="Affiliation"value="<?php echo $tel_in; ?>" >
                </div>

                <!-- <div class="form-group col-md-4">
                  <label for="level_name" class="label-form"> หมายเลขโทรศัพท์<span class="txt-red"></span> </label>
                  <input class="form-control" list="Affiliation" name="level_name" id="level_name" value="<?php //echo $level_name; ?>" >
                </div> -->

                <div class="form-group col-md-4">
                  <label for="tel_convenient" class="label-form"> หมายเลขโทรสาร<span class="txt-red"></span> </label>
                  <input type="tel" class="form-control" name="tel_convenient" id="tel_convenient" placeholder="-" value="<?php echo $a_data_pro[tel_convenient]; ?>" >
                  <!-- <small>กรุณากรอกหมายเลขโทรศัพท์ที่ใช้งานอยู่จริงและกรอกในรุปแบบให้ถูกต้องเช่น 0912345678</small> -->
                </div>


                <div class="form-group col-md-4">
                  <label for="mobile" class="label-form">หมายเลขมือถือ<span class="txt-red"></span> </label>
                  <input type="tel" class="form-control" name="mobile" id="mobile" placeholder="-" value="<?php echo $a_data_pro[mobile]; ?>" >
                  <!-- <small>กรุณากรอกหมายเลขโทรศัพท์ที่ใช้งานอยู่จริงและกรอกในรุปแบบให้ถูกต้องเช่น 0912345678</small> -->
                </div>

                <div class="form-group col-md-4">
                  <label for="email_person" class="label-form"> Email *<span class="txt-red"></span> </label>
                  <input type="email" class="form-control" name="email_person" id="email_person" aria-describedby="emailHelp" value="<?php echo $email_person; ?>" >
                </div>


                <div class="form-group col-md-4">
                  <label for="line_id" class="label-form"> ไอดีไลน์ <span class="txt-red"></span> </label>
                  <input type="tel" class="form-control" name="line_id" id="line_id" placeholder="ไม่ระบุ" value="<?php echo $a_data_pro[line_id]; ?>">
                </div>


                <div class="form-group col-md-12">
                  <label for="officeaddress" class="label-form"> ที่อยู่ <span class="txt-red"></span> </label>
                  <textarea  type="tel" class="form-control" name="officeaddress" id="officeaddress" placeholder="ไม่ระบุ"  value="">
                  <?php echo $a_data_pro[officeaddress]; ?>
                  </textarea>
                </div>


                 <!-- แคปชา -->
            <div class="col-12 text-center">
              <div class="mb-3 mt-3 form-check txt-center">
                <input type="checkbox" name="policy_check" id="policy_check" checked>
                <label class="form-check-label" for="policy_check">
                  <a href="assets/download/policy.pdf" target="_blank">
                    ยินยอมนโยบายการเก็บข้อมูลของกรมประชาสัมพันธ์ </a>
                </label>
              </div>
              <div class="txt-center mb-5">
                <button onclick="JQEdit_OrgUser($('#form_main'));" type="submit" class="btn btn-success btn-radius"> บันทึกการเปลี่ยนแปลงข้อมูล </button>
              </div>
            </div>
            
            </div>

          </form>

        </div>

            <!-- box เมนู -->
            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-6 col-6 p-2">
                        <a class="btn shadow-sm border-ra-15px bg-color-purple w-100 white-text fontAw-position boxsize-menu " href="tenure_information.php" role="button">
                        <img class="imgMenu-icon" src="images/suitcase.png" alt="img">
                            <p class="font-boxMenu white-text ">ข้อมูลการดำรง
                                ตำแหน่ง</p>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-6 col-6 p-2">
                        <a class="btn shadow-sm border-ra-15px bg-color-purple w-100 white-text fontAw-position boxsize-menu p-0" href="finance_information.php" role="button">
                        <img class="imgMenu-icon" src="images/Edit2playcopy2.png" alt="img">
                            <p class="font-boxMenu white-text ">ข้อมูลการเงิน</p>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-6 col-6 p-2">
                    <a class="btn shadow-sm border-ra-15px bg-color-purple w-100 white-text fontAw-position boxsize-menu p-0" href="Request_Certificate.php" role="button">
                        <img class="imgMenu-icon" src="images/contract.png" alt="img">
                            <p class="font-boxMenu white-text ">ขอหนังสือรับรอง</p>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-6 col-6 p-2">
                    <a class="btn shadow-sm border-ra-15px bg-color-purple w-100 white-text fontAw-position boxsize-menu p-0" href="private_floder.php" role="button">
                        <img class="imgMenu-icon" src="images/folder1.png" alt="img">
                            <p class="font-boxMenu white-text ">แฟ้มส่วนตัว</p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>


    
    
<script>
    var myEditableElement = document.getElementById('myContent');
myEditableElement.addEventListener('input', function() {
    console.log('An edit input has been detected');
    console.log(myEditableElement.innerHTML);
});

function JQEdit_OrgUser(form) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			  }
			  $.confirm({
				  content: 'คุณต้องการบันทึกข้อมูลหรือไม่',
				  boxWidth: '30%',
				  icon: 'far fa-question-circle',
				  theme: 'modern',
				  buttons: {
					  confirm: {
						
						text: 'ยืนยันการบันทึก',
						btnClass: 'btn-blue',
						  action: function() {
							  $.ajax({
								  type: method,
								  url: action,
								  data: formData ? formData : form.serialize(),
								  async: true,
								  processData: false,
								  contentType: false,
								    success: function(data) {
                      console.log(data);
                      $.alert({
                          title: 'บันทึกข้อมูลเรียบร้อย',
                          theme: 'modern',
                          icon: 'far fa-check-circle',
                          content: 'Success! ',
                          type: 'green',
                          typeAnimated: true,
                          boxWidth: '30%',
                          buttons: {
                            ok: {
                              btnClass: 'btn-green'
                              // location.reload(true);
                            }
                        },
                      });
								}
							});
						}
					},
					cancel: {
						text: 'ยกเลิก',
						action: function() {

						}
					}
				},
				animation: 'scale',
				type: 'blue'
			});
		}
</script>




    <?php include('footer.php'); ?>
    <!-- Footer Website -->
    <?php include('combottom.php'); ?>
    <!-- Include file js and properties -->