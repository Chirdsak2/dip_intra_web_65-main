<?php include('comtop.php'); ?>
<?php include('header.php'); ?>



<style>
  *{
    font-family: 'prompt-Reg';
   
}
	ul#sub_menu li{
  display: inline;
  color: #82288C;
  font-weight: bold;
}
/*navbar-toggle x icon end....*/
.icons-section i{
    color: #2571b3;
}


hr.style-eight {
	width: 250px;
    border: 0;
    height: 2px;
    position:relative;
    background: -moz-linear-gradient(left, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 10%, rgb(37, 113, 179) 50%, rgba(0,0,0,0) 90%, rgba(0,0,0,0) 100%); /* FF3.6+ */
    background: -webkit-linear-gradient(left, rgba(0,0,0,0) 0%,rgba(0,0,0,0) 10%,rgb(37, 113, 179) 50%,rgba(0,0,0,0) 90%,rgba(0,0,0,0) 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(left, rgba(0,0,0,0) 0%,rgba(0,0,0,0) 10%,rgb(37, 113, 179) 50%,rgba(0,0,0,0) 90%,rgba(0,0,0,0) 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(left, rgba(0,0,0,0) 0%,rgba(0,0,0,0) 10%,rgb(37, 113, 179) 50%,rgba(0,0,0,0) 90%,rgba(0,0,0,0) 100%); /* IE10+ */
    background: linear-gradient(left, rgba(0,0,0,0) 0%,rgba(0,0,0,0) 10%,rgb(37, 113, 179) 50%,rgba(0,0,0,0) 90%,rgba(0,0,0,0) 100%); /* W3C */
    
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
.welcome-section h5{
    color: #2571b3;
}
.footer-section{
    background: #2571b3;
    color: #FFF;
}

.stepwizard-step p {
    margin-top:35px;
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

.stepwizard-step a{
    background: #82288C;
    color: #fff;
    position: absolute;
    top: 0;
    margin-left:-10px;
}
.stepwizard-step a.btn-primary{
    background: #82288C;
    border-color: #82288C;
    color:#FFF;
    box-shadow: 0 0 0px 5px #82288C;
}
.studentform-section span{
    color: red;
}
.studentform-section ul.list-unstyled b{
      color: #2571b3;
}
#step-3{
    overflow-x: hidden;
}
.has-error input{
    border: 1px solid red;
}
.studentform-section input:focus{
    box-shadow: none;
}

.stepwizard-row .btn-default[disabled]{
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

.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #2571b3;
}
.studentform-section .btn-primary{
    background: #2571b3;
    border-color: #2571b3;
}
.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
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
    margin-top:40px;
    padding-left: 15px;
        font-size: 12px;
}
}
@media (min-width: 768px) {
    .dropdown:hover > .dropdown-menu {
  display: block;
}
        .stepwizard-step p {
    margin-top:35px;
    padding-left: 15px;
        font-size: 1rem;
} 
}
@media (min-width: 992px) {}
@media (min-width: 1200px) {}

.box{
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
          <h1 class="h2-color pt-4">ทัศนคติ และพฤติกรรมการเข้าชมและติดตามสื่อโฆษณาในเว็บเครือข่ายสังคมออนไลน์</h1>
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

<div class="row no-gutters" >
      <div class="container" style="margin-top:40px;">
        <div class="row">
          <div class="col-12">
            <div class="stepwizard">
              <div class="stepwizard-row setup-panel">
              <div class="stepwizard-step">
              <a href="#step-1"  class="btn btn-primary btn-circle">1</a>
              <div class="clearfix"></div>
                 <p class="text_h_ques"> ส่วนที่ 1  <br> แบบสอบถามข้อมูลทั่ว <br>ไปเกี่ยวกับผู้ตอบแบบสอบถาม</p>
              </div>
              <div class="stepwizard-step">
              <a href="#step-2"  class="btn btn-default btn-circle" disabled="disabled">2</a>
              <div class="clearfix"></div>
              <p> ส่วนที่ 2  <br> แบบสอบถามด้านการเข้าใช้
<br>เครือข่ายสังคมออนไลน์</p>
              </div>
              <div class="stepwizard-step">
              <a href="#step-3"  class="btn btn-default btn-circle" disabled="disabled">3</a>
              <div class="clearfix"></div>
              <p> ส่วนที่ 3   <br> แบบสอบถามด้านทัศนคติที่มีต่อการเข้าชม
<br>เว็บไซต์เครือข่ายสังคมออนไลน์
</p>
              </div>
              <div class="stepwizard-step">
              <a href="#step-4"  class="btn btn-default btn-circle" disabled="disabled">4</a>
              <div class="clearfix"></div>
              <p> ส่วนที่ 4  <br> ตรวจสอบแบบสอบถาม
</p>
              </div>

              <div class="stepwizard-step">
              <a href="#step-5"  class="btn btn-default btn-circle" disabled="disabled">5</a>
              <div class="clearfix"></div>
              <p> ส่วนที่ 5  <br> ส่งแบบสอบถามเสร็จสิ้น</p>
              </div>
              </div>
            </div>
            <form role="form" action="" method="post" class="studentform-section">
              <div class="setup-content" id="step-1" style="">
                <div class="row">
                    <div class="col-12">
                        <h5 class="h2-color">คำแนะนํา: กรุณาตอบแบบสอบถาม โดยเลือกตัวเลือก ที่ตรงกับคำตอบ และความคิดเห็นของท่านมากที่สุด</h5>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                      <div class="row">
                       <label class="h2-color col-xl-2 text-right" for="">ชื่อ : </label>
                        <input type="text" class="form-control col-xl-10" placeholder="กรุณากรอกหัวข้อการประชุม">
                      </div>  
                    </div>
                  <div class="col-12 col-sm-6">
                      <div class="row">
                        <label class="h2-color col-xl-2 text-right"  for="">นามสกุล  : </label>
                        <input type="text" class="form-control col-xl-10" placeholder="กรุณากรอกชื่อประธานในที่ประชุม">
                      </div>
                  </div>
                </div>  
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                      <div class="row">
                         <label class="h2-color col-xl-2 text-right" for="">เพศ : </label>
                          <div class="form-check form-check-inline">
                              <input  type="checkbox" id="man" value="man">
                              <label class="h2-color col-xl-4" for="man">ชาย</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input  type="checkbox" id="female" value="female">
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
                        <button type="button" class="btn button_main nextBtn text-white"><h4>ถัดไป</h4></button> 
                    </div>
                </div>     
              </div>
              <div class="setup-content" id="step-2" style="display: none;">
                  <div class="row mb-2">
                    <div class="col-12">
                      <h5 class="h2-color">เหตุผลที่ท่านเข้าใช้เว็บไซต์สังคมออนไลน์ (ตอบได้มากกว่า 1 ข้อ)</h5>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">ติดต่อกับบุคคลที่รู้จัก</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เพื่อค้นหาเพื่อนใหม่</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เพื่อหาคู่</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">อัพเดทสถานะ/ ข้อมูลส่วนตัว/ รูปภาพ</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เล่นเกม</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">หาข้อมูล/ แลกเปลี่ยนข้อมูล</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">ติดตามข่าวสารศิลปิน / ดารา / บุคคลมีชื่อเสียง</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">ติดตามข่าวสารของสินค้า, ผลิตภัณฑ์ หรือ บริการต่างๆ</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เชิญชวนให้บุคคลอื่น เข้าร่วมเป็นสมาชิกกลุ่ม</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เชิญชวนให้บุคคลอื่น ซื้อสินค้า หรือบริการ</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เชิญชวนให้บุคคลอื่นเข้าร่วมกิจกรรมที่ตนเองจัดขึ้นหรือที่หน่วยงานอื่นจัดขึ้น</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เชิญชวนให้บุคคลอื่นเข้าร่วมกิจกรรมกลุ่มออนไลน์ต่างๆ เช่น อ่านและแสดงความคิดเห็น, ร่วมเป็นแฟนคลับ ฯลฯร่วมกิจกรรมที่ตนเองจัดขึ้นหรือที่หน่วยงานอื่นจัดขึ้น</label>
                        </div>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-12">
                        <h5 class="h2-color">ท่านเข้าใช้บริการเว็บไซด์เครือข่ายสังคมออนไลน์ใดบ้าง (ตอบได้มากกว่า 1 ข้อ)</h5>
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">YouTube </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">Facebook </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">Twitter </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">Instagram </label>
                      </div>
                    </div>
                  </div>

          
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">google </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">line </label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 mt-3">
                        <h5 class="h2-color">วัยรุ่นส่วนใหญ่นิยมใช้ iPhone 11 หรือ iPhone 6</h5>
                      </div>
                  </div>
                  
                  <div class="row mb-4">
                    <div class="col-12 col-sm-12">
                      <div class="form-check mb-2">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                              <div class="row">
                                   <div class="col-xl-2 text-center ">
                                      <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                  </div>
                                  <div class="col-xl-10 text-center ">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                              </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                               <div class="row">
                                   <div class="col-xl-2 text-center ">
                                      <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                  </div>
                                  <div class="col-xl-10 text-center ">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                        <h5 class="h2-color">iPhone รุ่นไหนที่คุณชอบมากที่สุด (ตอบได้มากกว่า 1 ข้อ)</h5>
                      </div>
                  </div>


                  <div class="row">
                    <div class="col-12 col-sm-12">
                      <div class="form-check">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                              <div class="row">
                                 <div class="col-xl-2 text-center">
                                       <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                  </div>
                                  <div class="col-xl-10 text-center ">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                              </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                              <div class="row">
                                <div class="col-xl-2 text-center">
                                       <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                  </div>
                                  <div class="col-xl-10 text-center ">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                              <div class="row">
                              <div class="col-xl-2 text-center">
                                       <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                  </div>
                                  <div class="col-xl-10 text-center ">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                              </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                              <div class="row">
                              <div class="col-xl-2 text-center">
                                       <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                  </div>
                                  <div class="col-xl-10 text-center ">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                              <div class="row">
                              <div class="col-xl-2 text-center">
                                       <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                  </div>
                                  <div class="col-xl-10 text-center ">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                              </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                              <div class="row">
                              <div class="col-xl-2 text-center">
                                       <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                  </div>
                                  <div class="col-xl-10 text-center ">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-12 col-sm-12 text-center">
                        <button type="button" class="btn button_main nextBtn text-white"><h4>ถัดไป</h4></button> 
                    </div>
                </div>     
              </div>


              <div class="setup-content" id="step-3" style="">
                <div class="row">
                    <div class="col-12">
                        <h5 class="h2-color">คำแนะนํา: ท่านมีความคิดเห็นต่อข้อความนี้อย่างไร กรุณาตอบแบบสอบถาม โดยเลือกคำตอบตามลำดับความสำคัญที่ตรงกับความเห็นของท่าน</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12">
                    <div class="table-responsive">
													<table class="table table-bordered " style="border-color:#B5B5B5;">
														<tbody><tr class="alert text-center">
															<td rowspan="2" style="padding-top:25px;" class="text-center">
															  รายการ
															</td>
															<td colspan="5" class="text-center">
                             ความคิดเห็น
															</td>
														</tr>
														<tr class="alert ">
															<td class="text-center">
                                เห็นด้วยอย่างยิ่ง
															</td>
															<td class="text-center">
                              เห็นด้วย
															</td>
															<td class="text-center">
                              ไม่แน่ใจ
															</td>
															<td class="text-center">
                              ไม่เห็นด้วย
															</td>
															<td class="text-center">
                              ไม่เห็นด้วยอย่างยิ่ง
															</td>
														</tr>
														<tr>
															<td>
                              เครือข่ายสังคมออนไลน์มีประโยชน์ 															</td>
															<td class="text-center">
																<label for="radio01" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio01">
															</td>
															<td class="text-center">
																<label for="radio02" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio02">
															</td>
															<td class="text-center">
																<label for="radio03" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio03">
															</td>
															<td class="text-center">
																<label for="radio04" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio04">
															</td>
															<td class="text-center">
																<label for="radio05" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio05">
															</td>
														</tr>
														<tr>
															<td>
                              สะดวกในการติดต่อสื่อสาร
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>

                            <tr>
															<td>
                              เป็นแหล่งเพิ่มพูนความรู้
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>
                            
                            <tr>
															<td>
                              เป็นแหล่งให้ความบันเทิง
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>

                            <tr>
															<td>
                              เป็นแหล่งพบปะสังสรรค์กับกลุ่มเพื่อน/คนรู้จัก
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>

                            <tr>
															<td>
                              เป็นแหล่งแสดงความคิดเห็นความเป็นตัวของตัวเอง
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>
                          </tbody>
                        </table>
												</div>
                        <div class="row">
                            <div class="col-xl-12">
                              <div class="form-group">
                                <label for="exampleFormControlFile1">แนบไฟล์ รูป Social Media (หน้า Facebook,Instragram ฯลฯ)</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1">
                                <small>* ไฟล์ที่อนุญาตให้แนบได้ pdf,png,jpg ขนาดไฟล์ไม่เกิน 10 MB.</small>
                            </div>                
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label for="birthday"> วัน/เดือน/ปี และ เวลา ที่ตอบแบบสอบถาม  </label>
                                    <input type="date" class="form-control col-xl-6"  id="birthday" name="birthday">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="row mb-2">
                    <div class="col-12 col-sm-12 text-center">
                        <button type="button" class="btn button_main nextBtn text-white"><h4>ถัดไป</h4></button> 
                    </div>
                </div>     
              </div>
              
              <!-- <div class="row setup-content" id="step-3" style="">
                <div class="row">
                  <div class="col-12">
                    <h1 class="H_form1">คำแนะนํา: ท่านมีความคิดเห็นต่อข้อความนี้อย่างไร กรุณาตอบแบบสอบถาม โดยเลือกคำตอบตามลำดับความสำคัญที่ตรงกับความเห็นของท่าน</h1>
                  </div>
                </div>
              </div> -->
              <div class="setup-content" id="step-4" style="">
                <div class="row">
                <div class="col-12 col-sm-6">
                      <div class="row">
                       <label class="h2-color col-xl-2 text-right" for="">ชื่อ : </label>
                        <input type="text" class="form-control col-xl-10" placeholder="กรุณากรอกหัวข้อการประชุม">
                      </div>  
                    </div>
                  <div class="col-12 col-sm-6">
                      <div class="row">
                        <label class="h2-color col-xl-2 text-right"  for="">นามสกุล  : </label>
                        <input type="text" class="form-control col-xl-10" placeholder="กรุณากรอกชื่อประธานในที่ประชุม">
                      </div>
                  </div>
                </div>  
                
                <div class="row mt-2">
                    <div class="col-12 col-sm-6">
                      <div class="row">
                         <label class="h2-color col-xl-2 text-right" for="">เพศ : </label>
                          <div class="form-check form-check-inline">
                              <input  type="checkbox" id="man" value="man">
                              <label class="h2-color col-xl-4" for="man">ชาย</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input  type="checkbox" id="female" value="female">
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
                
                <div class="row mt-2">
                  <div class="col-12 col-sm-6">
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

                <div class="row mt-2">
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




                <div class="row">
                    <div class="col-12">
                      <h5 class="h2-color">เหตุผลที่ท่านเข้าใช้เว็บไซต์สังคมออนไลน์ (ตอบได้มากกว่า 1 ข้อ)</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">ติดต่อกับบุคคลที่รู้จัก</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เพื่อค้นหาเพื่อนใหม่</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เพื่อหาคู่</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">อัพเดทสถานะ/ ข้อมูลส่วนตัว/ รูปภาพ</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เล่นเกม</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">หาข้อมูล/ แลกเปลี่ยนข้อมูล</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">ติดตามข่าวสารศิลปิน / ดารา / บุคคลมีชื่อเสียง</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">ติดตามข่าวสารของสินค้า, ผลิตภัณฑ์ หรือ บริการต่างๆ</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เชิญชวนให้บุคคลอื่น เข้าร่วมเป็นสมาชิกกลุ่ม</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เชิญชวนให้บุคคลอื่น ซื้อสินค้า หรือบริการ</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เชิญชวนให้บุคคลอื่นเข้าร่วมกิจกรรมที่ตนเองจัดขึ้นหรือที่หน่วยงานอื่นจัดขึ้น</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">เชิญชวนให้บุคคลอื่นเข้าร่วมกิจกรรมกลุ่มออนไลน์ต่างๆ เช่น อ่านและแสดงความคิดเห็น, ร่วมเป็นแฟนคลับ ฯลฯร่วมกิจกรรมที่ตนเองจัดขึ้นหรือที่หน่วยงานอื่นจัดขึ้น</label>
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <h5 class="h2-color">ท่านเข้าใช้บริการเว็บไซด์เครือข่ายสังคมออนไลน์ใดบ้าง (ตอบได้มากกว่า 1 ข้อ)</h5>
                    </div>
                </div>

                 <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">YouTube </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">Facebook </label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">Twitter </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">Instagram </label>
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-12">
                        <h5 class="h2-color">iPhone รุ่นไหนที่คุณชอบมากที่สุด (ตอบได้มากกว่า 1 ข้อ)</h5>
                      </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-12 col-sm-12">
                      <div class="form-check">
                        <div class="row">
                            <div class="col-xl-6">
                            <div class="row">
                                  <div class="col-xl-12 text-center m-2">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                                  <div class="col-xl-12 text-center m-2">
                                       <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                  </div>
                              </div>
                            </div>
                            <div class="col-xl-6">
                            <div class="row">
                                  <div class="col-xl-12 text-center m-2">
                                    <label label class="form-check-label" for="exampleRadios1"><img class="img-fluid" src="images/iphone.jpg" alt=""></label>
                                  </div>
                                  <div class="col-xl-12 text-center m-2">
                                       <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                  </div>
                              </div>
                            </div>
                        </div>

                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-12 col-sm-12">
                    <div class="table-responsive">
													<table class="table table-bordered " style="border-color:#B5B5B5;">
														<tbody><tr class="alert text-center">
															<td rowspan="2" style="padding-top:25px;" class="text-center">
															  รายการ
															</td>
															<td colspan="5" class="text-center">
                             ความคิดเห็น
															</td>
														</tr>
														<tr class="alert ">
															<td class="text-center">
                                เห็นด้วยอย่างยิ่ง
															</td>
															<td class="text-center">
                              เห็นด้วย
															</td>
															<td class="text-center">
                              ไม่แน่ใจ
															</td>
															<td class="text-center">
                              ไม่เห็นด้วย
															</td>
															<td class="text-center">
                              ไม่เห็นด้วยอย่างยิ่ง
															</td>
														</tr>
														<tr>
															<td>
                              เครือข่ายสังคมออนไลน์มีประโยชน์ 															</td>
															<td class="text-center">
																<label for="radio01" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio01">
															</td>
															<td class="text-center">
																<label for="radio02" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio02">
															</td>
															<td class="text-center">
																<label for="radio03" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio03">
															</td>
															<td class="text-center">
																<label for="radio04" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio04">
															</td>
															<td class="text-center">
																<label for="radio05" hidden=""> text </label>
																<input type="radio" name="1" required="required" id="radio05">
															</td>
														</tr>
														<tr>
															<td>
                              สะดวกในการติดต่อสื่อสาร
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>

                            <tr>
															<td>
                              เป็นแหล่งเพิ่มพูนความรู้
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>
                            
                            <tr>
															<td>
                              เป็นแหล่งให้ความบันเทิง
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>

                            <tr>
															<td>
                              เป็นแหล่งพบปะสังสรรค์กับกลุ่มเพื่อน/คนรู้จัก
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>

                            <tr>
															<td>
                              เป็นแหล่งแสดงความคิดเห็นความเป็นตัวของตัวเอง
															</td>
															<td class="text-center">
																<label for="radio06" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio06">
															</td>
															<td class="text-center">
																<label for="radio07" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio07">
															</td>
															<td class="text-center">
																<label for="radio08" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio08">
															</td>
															<td class="text-center">
																<label for="radio09" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio09">
															</td>
															<td class="text-center">
																<label for="radio10" hidden=""> text </label>
																<input type="radio" name="2" required="required" id="radio10">
															</td>
														</tr>
                          </tbody>
                        </table>
												</div>
                        <div class="row">
                            <div class="col-xl-12">
                              <div class="form-group">
                                <label for="exampleFormControlFile1">แนบไฟล์ รูป Social Media (หน้า Facebook,Instragram ฯลฯ)</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1">
                                <small>* ไฟล์ที่อนุญาตให้แนบได้ pdf,png,jpg ขนาดไฟล์ไม่เกิน 10 MB.</small>
                            </div>                
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label for="birthday"> วัน/เดือน/ปี และ เวลา ที่ตอบแบบสอบถาม  </label>
                                    <input type="date" class="form-control col-xl-6"  id="birthday" name="birthday">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="row mb-2">
                    <div class="col-12 col-sm-12 text-center">
                        <button type="button" class="btn button_main nextBtn text-white"><h4>ถัดไป</h4></button> 
                    </div>
                </div>     
              </div>
              <div class="setup-content" id="step-5" style="">
                <div class="row">
                  <div class="col-xl-12 text-center">
                    <div class="shadow-sm p-3 mb-5 bg-white rounded">
                       <h1 class="h2-color">ส่งแบบสอบถามเสร็จสิ้น</h1>
                       <img src="images/wrong.png" alt="">
                    </div> 
                     <button type="button" class="btn button_main nextBtn text-white">เสร็จสิ้น</button>
                  </div>
                </div>
              </div>
              </div>
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



