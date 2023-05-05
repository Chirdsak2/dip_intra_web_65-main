<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->
<?php
$km_point = km::getKmPoint();
$ecard_user_birthdate = ecard::getEcardHistory($_SESSION["EWT_MID"], $ech_date, $ech_date_year);
$birth_date = date("m-d", strtotime($birth_day)); //วันเกิด User
$birth_date_cy = date("Y") . '-' . $birth_date; //วันเกิด User ปีปัจจุบัน
$birth_date_bfy = date("Y", strtotime(" - 1 years")) . '-' . $birth_date; //วันเกิด User ปีก่อน 
?>

<!-- Font on Website -->
<link rel="stylesheet" href="assets/css/profile.css">

<style>
  .max-width50px{
    max-width: 50px;
  }

  .img-fluid1 {
    height: 80px;
  }
</style>

<div class="container-fluid b__profile mar-t-90px">
  <div class="container py-5 text-center">
    <h3>ข้อมูลส่วนตัว</h3>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-12">
        <?php include 'profile_menu.php'; ?>
      </div>
      <div class="col-lg-9 col-md-9 col-12">
        <!-- KM Point -->
        <div class="bg--white shadow">
          <div class="mt-3 mb-5">
            <h6 class=""><i class="fa fa-trophy"></i> KM Point </h6>
            <div class="row">
              <?php foreach ($km_point as $key => $value) { ?>
                <?php $km = km::getKm(null, $value["id"], $_SESSION["EWT_MID"]); ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                  <div class="card--km--block bg--card--km<?php echo $key + 1; ?> shadow">
                    <div class="row">
                      <div class="col-7">
                        <img src="assets/img/icon/<?php echo $value["km_image"]; ?>" class="img-icon-km">
                        <div class="km-point-title">
                          <small>คะแนน</small><br>
                          <span><?php echo $value["km_name"]; ?></span>
                        </div>
                      </div>
                      <div class="col-5 km--num">
                        <h3><?php echo $km["km_point"]; ?></h3>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <!-- HBD card List per year just show only last month -->
        <div class="mt-4 bg--white shadow">
          <div class="mt-3 mb-5">
            <div class="row">
              <div class="col-md-9 col-sm-7 col-7">
                <h6><i class="fas fa-birthday-cake"></i> การ์ดอวยพรวันเกิดของคุณในปีนี้ </h6>
              </div>
              <div class="col-md-3 col-sm-5 col-5 text-right">
                <a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                  <i class="fa fa-arrow-left"></i>
                </a>
                <a class="btn btn-primary mb-3 " href="#carouselExampleIndicators2" role="button" data-slide="next">
                  <i class="fa fa-arrow-right"></i>
                </a>
              </div>
              <div class="card-carousel">
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <?php
                    $i = 1;
                    foreach ($ecard_user_birthdate['data'] as $key => $value) {
                      //echo  $i%6; 
                      if ($i % 6 == 1) {
                        if ($i <= 6) {
                          $active =  'active';
                        } else {
                          $active =  '';
                        }
                        echo '<div class="carousel-item  ' . $active . ' ">';
                        echo '<div class="row">';
                      }
                    ?>
                      <?php
                      $ecard_list = ecard::getEcardList($value['ech_ecardid'])[0]; //ภาพการ์ดวันเกิด
                      $ecard_greeting = ecard::getEcardGreeting($value['ech_cid'])[0]; //ข้อความการ์ดวันเกิด
                      $user = user::chkUser(array("gen_user_id" => $value['ech_from_userid']))[0]; //ข้อมูลผู้ใช้ EWT
                      $user_sso = $sso->getUser($user["gen_user"])["data"]; //ข้อมูลผู้ใช้ SSO
                      $full_name = $user_sso["USR_FNAME"] . ' ' . $user_sso["USR_LNAME"]; //ชื่อ-นามสกุลผู้ส่งการ์ดวันเกิด
                      $user_image = getImgbase64("profile/" . $user_sso["USR_PICTURE"], "images/user_profile_empty.png"); //รูปผู้ส่งการ์ดวันเกิด
                      ?>

                      <div class="col-md-4 col-sm-6">
                        <a href="#" data-toggle="modal" data-target="#cardhbdpopup" id="<?php echo $value['ech_ecardid'] ?>" data-id="<?php echo $key; ?>">
                          <div class="profile__card__block shadow ">
                            <div class="row">
                              <div class="col-4">
                                <!-- <img src="assets/img/hbd/hbd1.png" class="img-fluid"> -->
                                <img src="<?php echo 'assets/images/ecard/' . (empty($ecard_list['ec_filename']) ? 'no_image.jpg' : $ecard_list['ec_filename']); ?> " class="img-fluid img-fluid1" alt="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>" title="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>" id="ecard_image<?php echo $key; ?>">
                              </div>
                              <div class="col-6">
                                <div class="bd--title">
                                  <figcaption id="">
                                    <?php echo mb_strimwidth($ecard_greeting['c_detail'], 0, 35, '...'); ?>
                                  </figcaption>
                                  <input type="hidden" id="ecard_text<?php echo $key; ?>" value="<?php echo $ecard_greeting['c_detail']; ?>">
                                </div>
                              </div>
                              <div class="col-2">
                                <img src="<?php echo $user_image; ?>" class="profile--img--block" data-toggle="tooltip" id="ecard_user<?php echo $key; ?>" alt="<?php echo $full_name; ?>" title="<?php echo $full_name; ?>" width="40" height="40">
                                <input type="hidden" id="ecard_name<?php echo $key; ?>" value="<?php echo $full_name ?>">
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                    <?php
                      if ($i % 6 == 0) {
                        echo '</div>';
                        echo '</div>';
                      }
                      $i++;
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cardhbdpopup" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header border-b-0">
        <h5 class="modal-title" id="staticBackdropLabel">
          <i class="fas fa-birthday-cake"></i> การ์ดอวยพรวันเกิดของคุณในปีนี้
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div class="profile__card__block shadow">

              <div class="row">
                <div class="col-12 text-center p-4">
                  <div id="img_modal_new">
                    <!-- <img src="assets/img/hbd/hbd1.png" class="card-img-top-fix-img-fluid" alt="สุขภาพแข็งแรง รวยๆ ตลอดไป.." title="สุขภาพแข็งแรง รวยๆ ตลอดไป.."> -->
                    <img src="<?php echo 'assets/images/ecard/' . (empty($ecard_list['ec_filename']) ? 'no_image.jpg' : $ecard_list['ec_filename']); ?>" class="card-img-top-fix" alt="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>" title="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>">
                  </div>
                </div>
                <div class="col-12 px-5 pt-3">
                  <blockquote class="blockquote px-3">
                    <div id="caption">
                      <p class="mb-0 px-5">
                        <?php echo empty($ecard_greeting['c_detail']) ? null : $ecard_greeting['c_detail']; ?>
                      </p>
                    </div>
                    <div style="font-family: Georgia, serif;position: absolute;bottom: -30px;line-height: 100px;right: 90px;font-size: 19em;color: rgba(238, 238, 238, 0.8);font-weight: normal;opacity: 0.5;">
                    </div>
                    <footer class="blockquote-footer pt-3 px-5">
                      <div class="dis-inline" id="img_modal_user">
                        <img src="<?php echo $user_image; ?>" class="rounded-circle max-width50px shadow-user" alt="<?php echo $full_name; ?>" title="<?php echo $full_name; ?>">
                      </div>
                      <div class="dis-inline" id="fullname">
                        คุณ<?php echo $full_name; ?>
                      </div>
                    </footer>
                  </blockquote>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $("[data-toggle='modal']").on("click", function(event) {
    // alert(<?php echo $value['ech_ecardid'] ?>);   
    var ImgId = this.id;
    var Id = $(this).attr("data-id");
    var img = document.getElementById("ecard_image" + Id);
    var modalImg = document.getElementById("img_modal_new");

    var imguser = document.getElementById("ecard_user" + Id);
    var modaluser = document.getElementById("img_modal_user");

    var captionText = document.getElementById("caption");
    var text = document.getElementById("ecard_text" + Id).value;
    // alert(text);

    var name = document.getElementById("fullname");
    var nametext = document.getElementById("ecard_name" + Id).value;
    // alert(nametext);
    modalImg.src = this.src;
    modalImg.innerHTML = '<img src="' + img.src + '"  class=" img-fluid">';
    modaluser.innerHTML = '<img src="' + imguser.src + '" class="rounded-circle max-width50px shadow-user">';
    captionText.innerHTML = text;
    name.innerHTML = nametext;

  });
</script>

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->