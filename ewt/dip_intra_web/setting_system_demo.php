<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>  


<style>
     .icon_request{
          color:var(--green);
     }
     .title_request{
          color:var(--green);
     }
     .icon_check_square{
          color:var(--purple);
          font-size:30px;
     }
     .icon_question-circle{
          color:var(--purple);
          font-size:30px;
     }
     .text_h_table th{
          font-size:16px;
          text-align: center;
     }
     @media (min-width: 1024px) {
          .form_width{
               width:50%;
               text-align:center;
               margin-left: auto;
               margin-right: auto;
          }
      }
</style>

<div class="container-fluid mar-t-90px header--bg">
	<div class="container py-5 text-center">
		<h3> ตั้งค่าระบบงาน </h3>
	</div>
</div>
<div class="container">
	<div class="row">
          <div class="col-12">
               <div class="table-responsive">
                    <table class="table table-hover">
                         <thead>
                              <tr class="text_h_table">
                                   <th scope="col">#</th>
                                   <th scope="col">ชื่อระบบ</th>
                                   <th scope="col">ลำดับ</th>
                                   <th scope="col">ตั้งค่าสถานะการใช้งาน</th>
                                   <th scope="col">สิทธ์การใช้งาน</th>
                              </tr>
                         </thead>
                         <tbody>
                              <tr>
                                   <th scope="row">1</th>
                                        <td>
                                             <div class="row">
                                                  <div class="col-12 text-center">
                                                       <img src="images/icon_setting/icon_1.png" class="img-fluid"  title="สารบรรณอิเล็กทรอนิกส์" alt="สารบรรณอิเล็กทรอนิกส์">
                                                  </div>
                                                  <div class="col-12 text-center">
                                                       สารบรรณอิเล็กทรอนิกส์
                                                  </div>
                                             </div>
                                             
                                        </td>
                                   <td>
                                        <input class="form-control text-center form_width" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="1">                  
                                   </td>
                                   <td>
                                        <div class="form-group form-check">
                                             <input type="checkbox" checked class="form-check-input" id="exampleCheck1">
                                             <label class="form-check-label" for="exampleCheck1">ใช้งาน </label>
                                        </div>
                                   </td>
                                   <td>
                                        <button type="button" class="btn btn-success w-100"><i class="fa fa-check-square" aria-hidden="true"></i> มีสิทธิ์ใช้งานระบบ</button>
                                   </td>
                              </tr>
                              <tr>
                                   <th scope="row">2</th>
                                   <td>
                                         <div class="row">
                                             <div class="col-12 text-center">
                                                   <img src="images/icon_setting/e_document.png" class="img-fluid" title="E-DOCUMENT" alt="E-DOCUMENT">
                                             </div>
                                             <div class="col-12 text-center">
                                                   E-DOCUMENT
                                             </div>
                                        </div>
                                   </td>
                                   <td>
                                        <input class="form-control text-center form_width" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="2">                  
                                   </td>
                                   <td>
                                        <div class="form-group form-check">
                                             <input type="checkbox" checked class="form-check-input" id="exampleCheck1">
                                             <label class="form-check-label" for="exampleCheck1">ใช้งาน </label>
                                        </div>
                                   </td>
                                   <td>
                                        <button type="button" class="btn btn-success w-100"><i class="fa fa-check-square" aria-hidden="true"></i> มีสิทธิ์ใช้งานระบบ</button>
                                   </td>
                              </tr>
                              <tr>
                                   <th scope="row">3</th>
                                        <td>
                                             <div class="row">
                                                  <div class="col-12 text-center">
                                                       <img src="images/icon_setting/icon_2.png" class="img-fluid"  title="ระบบจองยานพาหนะ" alt="ระบบจองยานพาหนะ">
                                                  </div>
                                                  <div class="col-12 text-center">
                                                        ระบบจองยานพาหนะ
                                                  </div>
                                             </div>
                                        </td>
                                   <td>
                                        <input class="form-control text-center form_width" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="3">                  
                                   </td>
                                   <td>
                                        <div class="form-group form-check">
                                             <input type="checkbox" checked class="form-check-input" id="exampleCheck1">
                                             <label class="form-check-label" for="exampleCheck1">ใช้งาน </label>
                                        </div>
                                   </td>
                                   <td>
                                        <button type="button" class="btn btn-success w-100"><i class="fa fa-check-square" aria-hidden="true"></i> มีสิทธิ์ใช้งานระบบ</button>
                                   </td>
                              </tr>
                              <tr>
                                   <th scope="row">4</th>
                                   <td>
                                        <div class="row">
                                             <div class="col-12 text-center">
                                                  <img src="images/icon_setting/icon_3.png" class="img-fluid"  title="ระบบจองห้องประชุม" alt="ระบบจองห้องประชุม">
                                             </div>
                                             <div class="col-12 text-center">
                                                  ระบบจองห้องประชุม
                                             </div>
                                        </div>   
                                      </td>
                                   <td>
                                        <input class="form-control text-center form_width" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="4">                  
                                   </td>
                                   <td>
                                        <div class="form-group form-check">
                                             <input type="checkbox" checked class="form-check-input" id="exampleCheck1">
                                             <label class="form-check-label" for="exampleCheck1">ใช้งาน </label>
                                        </div>
                                   </td>
                                   <td>
                                        <button type="button" class="btn btn-success w-100"><i class="fa fa-check-square" aria-hidden="true"></i> มีสิทธิ์ใช้งานระบบ</button>
                                   </td>
                              </tr>
                              <tr>
                                   <th scope="row">5</th>
                                   <td>
                                        <div class="row">
                                             <div class="col-12 text-center">
                                                  <img src="images/icon_setting/icon_4.png" class="img-fluid"  title="ขอหนังสือรับรอง" alt="ขอหนังสือรับรอง">
                                             </div>
                                             <div class="col-12 text-center">
                                                   ขอหนังสือรับรอง
                                             </div>
                                        </div>   
                                   </td>
                                   <td>
                                        <input class="form-control text-center form_width" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>                  
                                   </td>
                                   <td>
                                        -
                                   </td>
                                   <td>
                                        <button type="button" class="btn btn-primary w-100"><i class="fa fa-check-square" aria-hidden="true"></i> อยู่ระหว่าง Admin พิจารณาสิทธิ์</button>
                                   </td>
                              </tr>
                              <tr>
                                   <th scope="row">6</th>
                                   <td>
                                        <div class="row">
                                             <div class="col-12 text-center">
                                                  <img src="images/icon_setting/intranet.png" class="img-fluid"    title="INTRANET WEBPORTAL" alt=" INTRANET WEBPORTAL">
                                             </div>
                                             <div class="col-12 text-center">
                                                   INTRANET WEBPORTAL
                                             </div>
                                        </div>   
                                       </td>
                                   <td>
                                        <input class="form-control text-center form_width" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>                  
                                   </td>
                                   <td>
                                   -
                                   </td>
                                   <td>
                                        <button type="button" class="btn btn-secondary w-100" data-toggle="modal" data-target="#request" > ร้องขอใช้สิทธิ์</button>
                                   </td>
                              </tr>
                         </tbody>
                    </table>
               </div>
          </div>
     </div>
     <div class="row">
          <div class="col-12 text-center my-2">
                 <button type="button" class="btn btn-success " data-toggle="modal" data-target="#changedata" > บันทึกการเปลี่ยนแปลงข้อมูล </button>
          </div>
     </div>	
</div>





<!-- Modal การเปลี่ยนแปลงข้อมูล  -->
<div class="modal fade" id="changedata" tabindex="-1" role="dialog" aria-labelledby="changedata" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changedata">ยืนยันการเปลี่ยนแปลงข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
               <div class="col-12 text-center">
                    ท่านต้องการยืนยันการเปลี่ยนแปลงข้อมูลหรือไม่  <i class="fa fa-question-circle icon_question-circle" aria-hidden="true"></i>
               </div>
          </div>
          <div class="row">
               <div class="col-12 text-center">
                   
               </div>
          </div>
      </div>
      <div class="modal-footer ">
          <div class="row">
               <div class="col-12 text-center">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#confir_changedata"><i class="fa fa-check-square" aria-hidden="false"></i> ยืนยันการเปลี่ยนแปลงข้อมูล</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
               </div>
          </div>
      </div>
    </div>
  </div>
</div>






<!-- Modal ร้องขอใช้สิทธิ์  -->
<div class="modal fade" id="request" tabindex="-1" role="dialog" aria-labelledby="request" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="request">การร้องขอใช้สิทธิ์ระบบ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
               <div class="col-12 text-center">
                    ท่านต้องการร้องของการใช้สิทธิ์ระบบ
               </div>
          </div>
          <div class="row">
               <div class="col-12 text-center">
                     <img src="images/icon_setting/intranet.png" alt="INTRANET WEBPORTAL" title="INTRANET WEBPORTAL"> INTRANET WEBPORTAL 
               </div>
          </div>
      </div>
      <div class="modal-footer ">
          <div class="row">
               <div class="col-12 text-center">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#confir_request" onclick="hide_butoon()"><i class="fa fa-check-square" aria-hidden="false"></i> ยืนยันการร้องขอสิทธิ์</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
               </div>
          </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal ยืนยันร้องขอใช้สิทธิ์  -->
<div class="modal fade" id="confir_request" tabindex="-1" role="dialog" aria-labelledby="confir_request" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title_request" id="confir_request"><i class="fa fa-check-square icon_request" aria-hidden="true"></i> ยืนยันการร้องขอใช้สิทธิ์ระบบ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
               <div class="col-12 text-center">
                     <img src="images/icon_setting/intranet.png" alt="INTRANET WEBPORTAL" title="INTRANET WEBPORTAL">INTRANET WEBPORTAL 
               </div>
          </div>
          <div class="row">
               <div class="col-12 text-center">
                          รอการให้สิทธิ์จากทางศูนย์เทคโนโลยีสารสนเทศอีกครั้ง
               </div>
          </div>
      </div>
      <div class="modal-footer ">
          <div class="row">
               <div class="col-12 text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
               </div>
          </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal ยืนยันการเปลี่ยนแปลงข้อมูล -->
<div class="modal fade" id="confir_changedata" tabindex="-1" role="dialog" aria-labelledby="confir_changedata" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title_request" id="confir_changedata"><i class="fa fa-check-square icon_request" aria-hidden="true"></i> ยืนยันการเปลี่ยนแปลงข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
               <div class="col-12 text-center">
                     <i class="fa fa-check-square icon_check_square" aria-hidden="true"></i>
               </div>
          </div>
          <div class="row">
               <div class="col-12 text-center">
                      ยืนยันการเปลี่ยนแปลงข้อมูลเรียบร้อย
               </div>
          </div>
      </div>
      <div class="modal-footer ">
          <div class="row">
               <div class="col-12 text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
               </div>
          </div>
      </div>
    </div>
  </div>
</div>







<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->
