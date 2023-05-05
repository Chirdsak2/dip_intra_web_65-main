<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php

$id = $_GET['s_id'];

// $current_date_TH = date("Y-m-d");
// $current_date_TH = explode("-", $current_date_TH);
// $current_date_TH = $current_date_TH[0] . "-" . $current_date_TH[1] . "-" . $current_date_TH[2];

$surv = survey::getSurvey($id);

// $form_start = explode("-", $surv["s_start"]);
// $form_start = ($form_start[0] + 543) . "-" . $form_start[1] . "-" . $form_start[2];
// $form_end   = explode("-", $surv["s_end"]);
// $form_end   = ($form_end[0] + 543) . "-" . $form_end[1] . "-" . $form_end[2];
// if (strtotime($current_date_TH) < strtotime($form_start)) {
//   // echo "<script>alert('ขอบคุณสำหรับการตอบแบบฟอร์มค่ะ')</script>";
// } else if (strtotime($current_date_TH) > strtotime($form_end)) {
//   echo "<script>alert('หมดเวลาทำแบบทดสอบ')</script>";
//   echo "<script>";
//   echo "window.location='more_form.php'";
//   echo "</script>";
// }
$k = 0;


$SQL1 = "SELECT * FROM " . E_DB_NAME . ".p_survey WHERE s_id = '{$id}'";
$a_row  = db::getRowCount($SQL1);
$PR = db::getFetch($SQL1, PDO::FETCH_ASSOC);

$SQL = "SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1
            ,p_cate.option2 
            FROM " . E_DB_NAME . ".p_cate," . E_DB_NAME . ".p_question 
            WHERE p_cate.s_id = '{$id}' AND p_cate.c_id = p_question.c_id
            ORDER BY p_cate.c_d ASC";
$WL = db::getFetch($SQL, PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($WL);
// echo "</pre>";
// exit();

$s_title = strip_tags($PR['s_title']);
$file_page  = "form_view.php?s_id=" . $id;
$page_title = $s_title;

?>


<style>
  * {
    font-family: 'prompt-Reg';

  }

  ul#sub_menu li {
    display: inline;
    color: #82288C;
    font-weight: bold;
  }

  /*navbar-toggle x icon end....*/
  .icons-section i {
    color: #2571b3;
  }


  hr.style-eight {
    width: 250px;
    border: 0;
    height: 2px;
    position: relative;
    background: -moz-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
    /* FF3.6+ */
    background: -webkit-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
    /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
    /* Opera 11.10+ */
    background: -ms-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
    /* IE10+ */
    background: linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
    /* W3C */

  }

  hr.style-eight:before {
    content: "";
    display: block;
    border-top: solid 1px #f9f9f9;
    width: 100%;
    height: 1px;
    position: absolute;
    top: 50%;
    z-index: 1;
  }

  .welcome-section h5 {
    color: #2571b3;
  }

  .footer-section {
    background: #2571b3;
    color: #FFF;
  }

  .stepwizard-step p {
    margin-top: 35px;
    padding-left: 15px;
  }

  .stepwizard-row {
    display: table-row;
  }

  .stepwizard {
    display: table;
    width: 100%;
    position: relative;
  }

  .stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
  }

  .stepwizard-row:before {
    top: -86px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 79%;
    left: 0px;
    right: -40px;
    margin: auto;
    height: 4px;
    background-color: #82288C;
  }

  .stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
  }

  .btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
  }

  .stepwizard-step a {
    background: #82288C;
    color: #fff;
    position: absolute;
    top: 0;
    margin-left: -10px;
  }

  .stepwizard-step a.btn-primary {
    background: #82288C;
    border-color: #82288C;
    color: #FFF;
    box-shadow: 0 0 0px 5px #82288C;
  }

  .studentform-section span {
    color: red;
  }

  .studentform-section ul.list-unstyled b {
    color: #2571b3;
  }

  #step-3 {
    overflow-x: hidden;
  }

  .has-error input {
    border: 1px solid red;
  }

  .studentform-section input:focus {
    box-shadow: none;
  }

  .stepwizard-row .btn-default[disabled] {
    background-color: #E978F5;
    border-color: #ccc;
  }

  .stepwizard-row .btn[disabled] {
    pointer-events: none;
    cursor: not-allowed;
    filter: alpha(opacity=65);
    -webkit-box-shadow: none;
    box-shadow: none;
    opacity: 1;
  }

  .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
    background-color: #2571b3;
  }

  .studentform-section .btn-primary {
    background: #2571b3;
    border-color: #2571b3;
  }

  .ui-state-highlight,
  .ui-widget-content .ui-state-highlight,
  .ui-widget-header .ui-state-highlight {
    border: 1px solid #2571b3 !important;
    background: #2571b3 !important;
    color: #FFF !important;
  }

  /* @media(max-width:504px){
      .stepwizard-step p {
      margin-top:35px;
      padding-left: 15px;
  font-size: 12px;
  } 
    .stepwizard-row::before {
      top: -50px;
      }
      
  } */

  @media (min-width: 576px) {
    .stepwizard-step p {
      margin-top: 40px;
      padding-left: 15px;
      font-size: 12px;
    }
  }

  @media (min-width: 768px) {
    .dropdown:hover>.dropdown-menu {
      display: block;
    }

    .stepwizard-step p {
      margin-top: 35px;
      padding-left: 15px;
      font-size: 1rem;
    }
  }

  @media (min-width: 992px) {}

  @media (min-width: 1200px) {}

  .box {
    width: 100%;
    height: 130px;
    background-color: #82288C;
  }

  @media (min-width: 992px) and (max-width: 1199.98px) {
    .stepwizard-row:before {
      top: -107px;
      bottom: 0;
      position: absolute;
      content: " ";
      width: 79%;
      left: 0px;
      right: -27px;
      margin: auto;
      height: 4px;
      background-color: #82288C;
    }
  }

  @media (min-width: 768px) and (max-width: 991.98px) {
    .stepwizard-row:before {
      top: -152px;
      bottom: 0;
      position: absolute;
      content: " ";
      width: 79%;
      left: 0px;
      right: -27px;
      margin: auto;
      height: 4px;
      background-color: #82288C;
    }
  }

  @media (max-width: 575.98px) {
    .stepwizard-row:before {
      top: -152px;
      bottom: 0;
      position: absolute;
      content: " ";
      width: 79%;
      left: 0px;
      right: -27px;
      margin: auto;
      height: 4px;
      background-color: #82288C;
    }

    .stepwizard-step p {
      /* margin-top: 35px; */
      /* padding-left: 15px; */
      font-size: 12px;
    }

    .stepwizard-step p {
      margin-top: 35px;
      padding-left: 0px;
    }
  }
</style>

<div class="container-fluid mar-spacehead" style="background-color: #82288c">
  <div class="container ">
    <form id="contact-form" action="#" method="post" role="form" novalidate="novalidate">
      <div class="error-container"></div>
      <div class="row">
        <h1 class="col-12 text-center text-white font-h-search  pt-4 pb-4">
          แบบสอบถาม
        </h1>
      </div>
    </form>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-xl-12">
      <h1 class="h2-color pt-4"><?php echo $s_title; ?></h1>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <ul id="sub_menu">
        <li>
          <a href="index.php">หน้าแรก</a>
        </li>
        <li>
          &gt;
        </li>
        <li>
          <a href="#"> แบบสอบถาม</a>
        </li>
      </ul>
    </div>
    <hr class="hr_news mt-3">
  </div>
</div>

<div class="row no-gutters">
  <div class="container" style="margin-top:40px;">
    <div class="row">
      <div class="col-12">
        <div class="stepwizard">
          <div class="stepwizard-row setup-panel">
            <?php
            $SQL = "SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1
            ,p_cate.option2 
            FROM " . E_DB_NAME . ".p_cate," . E_DB_NAME . ".p_question 
            WHERE p_cate.s_id = '{$id}' AND p_cate.c_id = p_question.c_id
            ORDER BY p_cate.c_d ASC";
            $k = 0;
            $a_row    =   db::getRowCount($SQL);
            $a_pCate   =   db::getFetchAll($SQL, PDO::FETCH_ASSOC);
            $a_countItem = count($a_pCate);
            // print_r($a_pCate);
            // exit;
            if ($a_pCate) {
              foreach ((array)$a_pCate as $R) {
            ?>
                <div class="stepwizard-step">
                  <a href="#step-<?php echo $R['c_d'] ?>" class="btn btn-primary btn-circle"><?php echo $R['c_d'] ?></a>
                  <div class="clearfix"></div>
                  <p class="text_h_ques"> ส่วนที่ <?php echo $PartName1 . $R['c_d']; ?><br><?php if ($R['c_name'] != "") {
                                                                                              echo  strip_tags($R['c_name']);
                                                                                            }  ?></p>
                </div>
            <?php
              }
            }
            ?>
          </div>
        </div>
        <form role="form" action="" method="post" class="studentform-section">
          <?php $SQL = "SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1
            ,p_cate.option2 
            FROM " . E_DB_NAME . ".p_cate," . E_DB_NAME . ".p_question 
            WHERE p_cate.s_id = '{$id}' AND p_cate.c_id = p_question.c_id
            ORDER BY p_cate.c_d ASC";
          $k = 0;
          $a_row    =   db::getRowCount($SQL);
          $a_pCate   =   db::getFetchAll($SQL, PDO::FETCH_ASSOC);
          $a_countItem = count($a_pCate);
          // print_r($a_pCate);
          // exit;
          if ($a_pCate) {
            foreach ((array)$a_pCate as $R) { ?>
              <div class="setup-content" id="step-<?php echo $R['c_d'] ?>" style="<?php echo ($R['c_d'] == 1 ? '' : 'display: none;') ?>">
                <div class="row">
                  <div class="col-12">
                    <h5 class="h2-color"><?php
                                          if ($R['c_title'] != "") {
                                            echo  strip_tags($R['c_title']);
                                          } ?></h5>
                  </div>
                </div>
                <?php
                $SSS = "SELECT * FROM " . E_DB_NAME . ".p_question WHERE c_id = '{$R['c_id']}' ORDER BY q_pos ASC";
							if ($R['c_gp'] == "Y") {
                if ($a_pQuestion) {
                  foreach ((array)$a_pQuestion as $X) {
                    $just = explode('#zz#', $X['q_req']);
                    $req = "";
                    if ($just[0] == "Y") {
                      $req = $X['q_name'] . ".";
                    }
                  }
                }
                $SQL2 = "SELECT DISTINCT(p_ans.a_name) FROM " . E_DB_NAME . ".p_ans," . E_DB_NAME . ".p_question WHERE p_question.c_id = '{$R['c_id']}' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3";
                $a_pAns = db::getFetchAll($SQL2, PDO::FETCH_ASSOC);
                if ($a_pAns) {
                  foreach ((array)$a_pAns as $Q) {
                    // echo '<td align="center">' . $Q['a_name'] . '</td>';
                    echo "<pre>";
                    print_r($Q);
                    echo "</pre>";
                  }
                }
              }
                ?>
                <div class="row mb-2">

                  <div class="col-12 col-sm-6">
                    <div class="row">
                      <label class="h2-color col-xl-2 text-right" for=""><?php echo $Q; ?> : </label>
                      <input type="text" class="form-control col-xl-10" placeholder="กรุณากรอกหัวข้อการประชุม">
                    </div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <div class="row">
                      <label class="h2-color col-xl-2 text-right" for="">นามสกุล : </label>
                      <input type="text" class="form-control col-xl-10" placeholder="กรุณากรอกชื่อประธานในที่ประชุม">
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-12 col-sm-6">
                    <div class="row">
                      <label class="h2-color col-xl-2 text-right" for="">เพศ : </label>
                      <div class="form-check form-check-inline">
                        <input type="checkbox" id="man" value="man">
                        <label class="h2-color col-xl-4" for="man">ชาย</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input type="checkbox" id="female" value="female">
                        <label class=" h2-color col-xl-4" for="female">หญิง</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <div class="row">
                      <label class="h2-color col-xl-2 text-right" for="exampleFormControlSelect1">อายุ : </label>
                      <select class="form-control col-xl-10" id="exampleFormControlSelect1">
                        <option>กรุณาเลือก..</option>
                        <option>13 - 18 ปี</option>
                        <option>19 - 30 ปี</option>
                        <option>31 - 45 ปี</option>
                        <option>46 - 59 ปี</option>
                        <option>60 ปีขึั้นไป</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-12 col-sm-6 ">
                    <div class="row">
                      <label class="h2-color col-xl-2 text-right" label for="">อาชีพ : </label>
                      <div class="col-xl-10 p-0">
                        <div class="form-check col-xl-12">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                          <label class="form-check-label" for="exampleRadios1"> นักเรียน/ นักศึกษา</label>
                        </div>
                        <div class="form-check col-xl-12">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                          <label class="form-check-label" for="exampleRadios2"> ลูกจ้างเอกชน/ พนักงานบริษัท</label>
                        </div>
                        <div class="form-check v">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
                          <label class="form-check-label" for="exampleRadios3">ค้าขาย/ ธุรกิจส่วนตัว</label>
                        </div>
                        <div class="form-check col-xl-12">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="option4">
                          <label class="form-check-label" for="exampleRadios4">ข้าราชการ / รัฐวิสาหกิจ</label>
                        </div>
                        <div class="form-check col-xl-12">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios5" value="option5">
                          <label class="form-check-label" for="exampleRadios5">อื่นๆ โปรดระบุ <span> <input type="text" class="form-control" placeholder="อื่นๆ"></span> </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <div class="row">
                      <label class="h2-color col-xl-2 text-right" label for="">รายได้เฉลี่ยต่อเดือน : </label>
                      <div class="col-xl-10 p-0">
                        <div class="form-check col-xl-12">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                          <label class="form-check-label" for="exampleRadios1"> น้อยกว่า 5,000 บาท</label>
                        </div>
                        <div class="form-check col-xl-12">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                          <label class="form-check-label" for="exampleRadios2"> 10,001-15,000 บาท</label>
                        </div>
                        <div class="form-check v">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
                          <label class="form-check-label" for="exampleRadios3">30,001-50,000 บาท</label>
                        </div>
                        <div class="form-check col-xl-12">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="option4">
                          <label class="form-check-label" for="exampleRadios4">50,001 บาท ขึ้นไป</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <div class="row">
                        <label class="h2-color col-xl-2 text-right" for="exampleFormControlSelect1">ระดับการศึกษาสูงสุด : </label>
                        <select class="form-control col-xl-10" id="exampleFormControlSelect1">
                          <option>กรุณาเลือก..</option>
                          <option>ต่ำกว่าปริญญาตรี</option>
                          <option>ปริญญาตรี</option>
                          <option>สูงกว่าปริญญษตรี</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <div class="row">
                        <label class="h2-color  col-xl-2 text-right" for="exampleFormControlSelect1">สถานภาพสมรส : </label>
                        <select class="form-control col-xl-10" id="exampleFormControlSelect1">
                          <option>กรุณาเลือก..</option>
                          <option>โสด</option>
                          <option>สมรส</option>
                          <option>หย่าร้าง/แยกกันอยู่</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-12 col-sm-12 text-center">
                    <button type="button" class="btn button_main nextBtn text-white">
                      <h4>ถัดไป</h4>
                    </button>
                  </div>
                </div>

              </div>
          <?php
            }
          }
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>


<script src='Calendar/fullCalendar/lib/main.js'></script>
<script src='Calendar/fullCalendar/lib/locales/th.js'></script>
<script src='js/login.js'></script>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>