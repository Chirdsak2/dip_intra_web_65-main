<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php !empty($t_header) ? include($t_header) : null; ?>
<?php include('popup-home.php'); ?>
<!-- Close Top -->

<?php echo ($template_id == 1) ? '<main id="main">' : null; ?>
<?php !empty($t_main_top_index) ? include($t_main_top_index) : null; ?>
<?php foreach($template_position as $value){ ?>
<?php include($value["section_file"]); ?>
<?php } ?>
<?php echo ($template_id == 1) ? '</main>' : null; ?>

<!-- Open Footer -->
<?php !empty($t_footer) ? include($t_footer) : null; ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->

<!-- Start Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> Popup Intro </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php include('popup_intro.php'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> ปิด </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal แจ้งเตือน  -->
<div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="alert" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="shadow-sm  bg-white box_main_alert">
      <div class="modal-body">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                   <h1>ประกาศจากกรม</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row mt-2">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                   <h1>ประกาศจากกรม</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row mt-2">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                   <h1>ประกาศจากกรม</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
           <div class="col-xl-12 mt-2">
               <a href="more_alert.php"><button type="button" class="btn bg_alert_bottom text-white cursor-pointer">ดูการแจ้งเตือนเพิ่มเติม</button></a>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal mail -->
<div class="modal fade" id="alert_mail" tabindex="-1" role="dialog" aria-labelledby="alert" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="shadow-sm  bg-white box_main_alert">
      <div class="modal-body">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                   <h1>ประกาศจากเมล</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row mt-2">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                  <h1>ประกาศจากเมล</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row mt-2">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                    <h1>ประกาศจากเมล</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
           <div class="col-xl-12 mt-2">
               <a href="more_alert.php"><button type="button" class="btn bg_alert_bottom text-white cursor-pointer">ดูการแจ้งเตือนเพิ่มเติม</button></a>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>