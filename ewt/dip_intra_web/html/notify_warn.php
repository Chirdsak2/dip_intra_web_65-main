<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->
<?php
if ($noti_ecard["count"] > 0) {
  foreach (notification::ecard($_SESSION["EWT_MID"])["data"] as $key => $value) {
    $ecard_list = ecard::getEcardList($value['ech_ecardid'])[0]; //ภาพการ์ดวันเกิด
    $ecard_greeting = ecard::getEcardGreeting($value['ech_cid'])[0]; //ข้อความการ์ดวันเกิด
    $user = user::chkUser(array("gen_user_id" => $value['ech_from_userid']))[0]; //ข้อมูลผู้ใช้ EWT
    $user_sso = $sso->getUser($user["gen_user"])["data"]; //ข้อมูลผู้ใช้ SSO
    $full_name = $user_sso["USR_FNAME"] . ' ' . $user_sso["USR_LNAME"]; //ชื่อ-นามสกุลผู้ส่งการ์ดวันเกิด
    $user_image = getImgbase64("profile/" . $user_sso["USR_PICTURE"], "images/user_profile_empty.png"); //รูปผู้ส่งการ์ดวันเกิด
    $group1[] = array(
      "date" => date("d/m/Y", strtotime($value["ech_datetime"])),
      "title" => "คุณได้รับการ์ดวันเกิดจาก :: " . $full_name,
      "detail" => $ecard_greeting['c_detail'],
      "search" => 1
    );
  }
}

if ($noti_change_profile["count"] > 0) {
  $group2[] = array(
    "date" => date("d/m/Y", strtotime($noti_change_profile["date_after"])),
    "title" => "ข้อมูลส่วนตัว",
    "detail" => "แจ้งอัพเดทอัพเดทข้อมูลส่วน",
    "search" => 2
  );
}

$all_array = array_merge(!empty($group1) ? $group1 : array(), !empty($group2) ? $group2 : array());
$array_data = array_chunk($all_array, 10);
$array_count = count($array_data);

if (!empty($noti_search)) {
  $a_data = $sso->getSearch($all_array, "search", $noti_search);
} else {
  $a_data = $all_array;
}
?>

<!-- Font on Website -->
<link rel="stylesheet" href="assets/css/profile.css">
<style>
  .max-width50px {
    max-width: 50px;
  }

  .img-fluid1 {
    height: 80px;
  }
</style>

<!-- ตาราง -->
<style>
  table {
    border-collapse: collapse;
    width: 100%;
    background-color: white;
  }

  th,
  td {
    padding: 8px;
    border-bottom: 1px solid #DDD;
  }

  tr:hover {
    background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
  }
</style>

<div class="container-fluid b__profile mar-t-90px">
  <div class="container py-5 text-center">
    <h3>
      <i class="fas fa-bell"></i> แจ้งเตือน
    </h3>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-12">
        <?php include 'profile_menu.php'; ?>
      </div>
      <div class="col-lg-9 col-md-9 col-12">
        <div class="bg--white shadow">
          <div class="mt-3 mb-5">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-12"></div>
              <div class="col-12">
                <div class="col-12">
                  <div class="row mb-4">
                    <h3 class="col-lg-6 col-md-6 col-sm-12 col-12">
                      รายการแจ้งเตือน
                    </h3>
                    <!-- <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                      <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-12 col-12">
                          <select class="form-control" name="noti_search" id="noti_search">
                            <option value="">-- เลือกรายการแจ้งเตือน -- </option>
                            <option value="1">การ์ดวันเกิด</option>
                            <option value="2">โปรไฟล์</option>
                          </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                          <button type="button" class="btn btn-search-hbd mb-2" id="btn_search">ค้นหา</button>
                        </div>
                      </div>
                    </div> -->

                    <div class="table-responsive">
                      <table class="table table-bordered font16px" id="sortable">
                        <thead>
                          <tr class="h-setting-table text-center">
                            <th scope="col" class="font-weight-100">ลำดับ</th>
                            <th scope="col" class="font-weight-100">วันที่</th>
                            <th scope="col" class="font-weight-100" style="width: 40%;">เรื่องแจ้งเตือน</th>
                            <th scope="col" class="font-weight-100">รายละเอียด</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($a_data)) { ?>
                            <?php foreach ($a_data as $key => $value) { ?>
                              <tr>
                                <td class="text-center"><?php echo $key + 1; ?></td>
                                <td class="text-center"><?php echo $value["date"]; ?></td>
                                <td>
                                  <?php echo $value['title']; ?>
                                </td>
                                <td class="small2"><?php echo $value["detail"]; ?></td>
                              </tr>
                            <?php } ?>
                          <?php } else { ?>
                            <tr>
                              <td colspan="4" class="text-center text-danger">ไม่พบข้อมูล</td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
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
</div>

<script type="text/javascript">
  $(".small2").each(function() {
    text = $(this).text();
    if (text.length > 30) {
      $(this).html(text.substr(0, 30) + '<span class="elipsis">' + text.substr(30) + '</span><a class="elipsis" href="#"><iclass="fa fa-caret-square-o-right" aria-hidden="true"></iclass=> ดูเพิ่มเติม</a>');
    }
  });

  $(".small2 > a.elipsis").click(function(e) {
    e.preventDefault();
    $(this).prev('span.elipsis').fadeToggle(500);
  });
</script>

<script type="text/javascript">
  $("#btn_search").click(function() {
    window.location.href = 'notify_warn.php?noti_search=' + $('#noti_search').val();
  });
</script>

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->