<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->

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
                      <table class="table font16px" id="sortable">
                        <thead>
                          <?php if($noti_ecard["count"]){ ?>
                          <tr>
                            <th class="text-left font-weight-100">คุณได้รับการ์ดวันเกิด</th>
                            <td class="text-center"><?php echo '(' . (int)$noti_ecard["count"] . ' รายการ)'; ?></td>
                          </tr>
                          <?php } ?>

                          <?php if ($noti_absent["count"] > 0) { ?>
                            <tr>
                              <th class="text-left font-weight-100">จำนวนใบลาที่ยังไม่อนุมัติ</th>
                              <td class="text-center"><?php echo '(' . (int)$noti_absent["data"]["absent_amount"] . ' รายการ)'; ?></td>
                            </tr>
                            <tr>
                              <th class="text-left font-weight-100">จำนวนใบยกเลิกลาที่ยังไม่อนุมัติ</th>
                              <td class="text-center"><?php echo '(' . (int)$noti_absent["data"]["cancel_amount"] . ' รายการ)'; ?></td>
                            </tr>
                          <?php } ?>

                          <!-- <tr>
                            <th class="text-left font-weight-100">ร่วมส่งการ์ดวันเกิดให้เพื่อนที่เกิดวันนี้</th>
                            <td class="text-center"><?php echo '(' . (int)$noti_from_ecard["count"] . ' รายการ)'; ?></td>
                          </tr> -->

                          <!-- <tr>
                            <th class="text-left font-weight-100">กรุณาอัพเดตข้อมูลส่วนตัวของคุณ</th>
                            <td class="text-center"><?php echo '(' . $noti_change_profile["count"] . ' รายการ)'; ?></td>
                          </tr> -->
                        </thead>
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