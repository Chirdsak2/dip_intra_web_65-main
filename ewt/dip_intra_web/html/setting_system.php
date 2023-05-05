<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->

<div class="container-fluid mar-t-90px header--bg">
	<div class="container py-5 text-center">
		<h3> ตั้งค่าระบบงาน </h3>
	</div>
</div>


<div class="container-fluid mt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 py-5 section-setting">
				<!-- <div class="font30px mb-4 text-center txt-purple-prd"> ข้อมูลระบบงาน </div> -->
					<div class="table-responsive"> 
						<table class="table table-hover table-striped font20px">
							<thead>
								<tr class="h-setting-table">
									<th scope="col" class="w-setting-1 font-weight-100 text-center"> # </th>
									<!--<th scope="col" class="w-setting-icon font-weight-100 text-center"> สัณลักษณ์ </th> -->
									<th scope="col" colspan="2" class="w-setting-namesystem font-weight-100">ชื่อระบบ</th>
									<th scope="col" class="w-setting-num font-weight-100">ลำดับ</th>
									<th scope="col" class="w-setting-num font-weight-100"> ตั้งค่าสถานะการใช้งาน </th>
									<th scope="col" class="w-setting-permission font-weight-100"> สิทธิ์การใช้งาน </th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row" class="text-center">1</th>
									<td class="text-center"> <img src="assets/img/system/system_01.png" title="ระบบประเมินผล" alt="ระบบประเมินผล" class="mar-t--14px"> </td>
									<td>  ระบบประเมินผล </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="1">
									</td>
									<td class="text-center">
										<div class="form-group form-check">
											<input type="checkbox" class="form-check-input mt-2" id="showsystemindex">
											<label class="form-check-label" for="showsystemindex"> ใช้งาน  </label>
										</div>
									</td>
									<td class="text-center">
										<a class="btn btn-success mb-3 border-ra-30px" role="button">
											<em class="fa fa-check-circle"></em> มีสิทธิ์ใช้งานระบบ
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">2</th>
									<td class="text-center"> <img src="assets/img/system/system_02.png" title="รวมสื่อประชาสัมพันธ์ 2565" alt="รวมสื่อประชาสัมพันธ์ 2565" class="mar-t--14px"> </td>
									<td> รวมสื่อประชาสัมพันธ์ 2565 </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="2">
									</td>
									<td class="text-center">
										<div class="form-group form-check">
											<input type="checkbox" class="form-check-input mt-2" id="showsystemindex">
											<label class="form-check-label" for="showsystemindex"> ใช้งาน </label>
										</div>
									</td>
									<td class="text-center">
										<a class="btn btn-success mb-3 border-ra-30px" role="button">
											<em class="fa fa-check-circle"></em> มีสิทธิ์ใช้งานระบบ
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">3</th>
									<td class="text-center"> <img src="assets/img/system/system_03.png" title="สารบรรณอิเล็กทรอนิกส์" alt="สารบรรณอิเล็กทรอนิกส์" class="mar-t--14px"> </td>
									<td> สารบรรณอิเล็กทรอนิกส์ </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="3">
									</td>
									<td class="text-center">
										<div class="form-group form-check">
											<input type="checkbox" class="form-check-input mt-2" id="showsystemindex">
											<label class="form-check-label" for="showsystemindex"> ใช้งาน </label>
										</div>
									</td>
									<td class="text-center">
										<a class="btn btn-success mb-3 border-ra-30px" role="button">
											<em class="fa fa-check-circle"></em> มีสิทธิ์ใช้งานระบบ
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">4</th>
									<td class="text-center"> <img src="assets/img/system/system_04.png" title="อีเมล กปส." alt="อีเมล กปส." class="mar-t--14px"> </td>
									<td> อีเมล กปส. </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="4">
									</td>
									<td class="text-center">
										<div class="form-group form-check">
											<input type="checkbox" class="form-check-input mt-2" id="showsystemindex">
											<label class="form-check-label" for="showsystemindex"> ใช้งาน </label>
										</div>
									</td>
									<td class="text-center">
										<a class="btn btn-success mb-3 border-ra-30px" role="button">
											<em class="fa fa-check-circle"></em> มีสิทธิ์ใช้งานระบบ
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">5</th>
									<td class="text-center"> <img src="assets/img/system/system_05.png" title="BIG DATA" alt="BIG DATA" class="mar-t--14px"> </td>
									<td> BIG DATA </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>
									</td>
									<td class="text-center">
										-
									</td>
									<td class="text-center">
										<a class="btn btn-primary mb-3 border-ra-30px" role="button">
											<em class="fa fa-check-circle"></em> อยู่ระหว่าง Admin พิจารณาสิทธิ์
										</a>
									</td>
									
								</tr>
								<tr>
									<th scope="row" class="text-center">6</th>
									<td class="text-center"> <img src="assets/img/system/system_06.png" title="คลังภาพและสินค้า" alt="คลังภาพและสินค้า" class="mar-t--14px"> </td>
									<td> คลังภาพและสินค้า </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>
									</td>
									<td class="text-center">
										-
									</td>
									<td class="text-center">  
										<a class="btn btn-secondary mb-3 border-ra-30px" role="button" href="#" data-toggle="modal" data-target="#Vote">
											ร้องขอใช้สิทธิ์
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">7</th>
									<td class="text-center"> <img src="assets/img/system/system_07.png" title="E-DOCUMENT" alt="E-DOCUMENT" class="mar-t--14px"> </td>
									<td> E-DOCUMENT </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>
									</td>
									<td class="text-center">
										-
									</td>
									<td class="text-center">  
										<a class="btn btn-secondary mb-3 border-ra-30px" role="button" href="#" data-toggle="modal" data-target="#Vote">
											ร้องขอใช้สิทธิ์
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">8</th>
									<td class="text-center"> <img src="assets/img/system/system_08.png" title="SMART CARD" alt="SMART CARD" class="mar-t--14px"> </td>
									<td> SMART CARD </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>
									</td>
									<td class="text-center">
										-
									</td>
									<td class="text-center">  
										<a class="btn btn-secondary mb-3 border-ra-30px" role="button" href="#" data-toggle="modal" data-target="#Vote">
											 ร้องขอใช้สิทธิ์
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">9</th>
									<td class="text-center"> <img src="assets/img/system/system_09.png" title="INTRANET WEBPORTAL" alt="INTRANET WEBPORTAL" class="mar-t--14px"> </td>
									<td> INTRANET WEBPORTAL </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>
									</td>
									<td class="text-center">
										-
									</td>
									<td class="text-center">  
										<a class="btn btn-secondary mb-3 border-ra-30px" role="button" href="#" data-toggle="modal" data-target="#Vote">
											ร้องขอใช้สิทธิ์
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">10</th>
									<td class="text-center"> <img src="assets/img/system/system_10.png" title="PBMS" alt="PBMS" class="mar-t--14px"> </td>
									<td> PBMS </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>
									</td>
									<td class="text-center">
										-
									</td>
									<td class="text-center">  
										<a class="btn btn-secondary mb-3 border-ra-30px" role="button" href="#" data-toggle="modal" data-target="#Vote">
											ร้องขอใช้สิทธิ์
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">11</th>
									<td class="text-center"> <img src="assets/img/system/system_11.png" title="ติดตามเงินรายได้" alt="ติดตามเงินรายได้" class="mar-t--14px"> </td>
									<td> ติดตามเงินรายได้ </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>
									</td>
									<td class="text-center">
										-
									</td>
									<td class="text-center">   
										<a class="btn btn-secondary mb-3 border-ra-30px" role="button" href="#" data-toggle="modal" data-target="#Vote">
											ร้องขอใช้สิทธิ์
										</a>
									</td>
								</tr>
								<tr>
									<th scope="row" class="text-center">12</th>
									<td class="text-center"> <img src="assets/img/system/system_12.png" title="ระบบเงินเดือน" alt="ระบบเงินเดือน" class="mar-t--14px"> </td>
									<td> ระบบเงินเดือน </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>
									</td>
									<td class="text-center">
										-
									</td>
									<td class="text-center">  
										<a class="btn btn-secondary mb-3 border-ra-30px" role="button" href="#" data-toggle="modal" data-target="#Vote">
											ร้องขอใช้สิทธิ์
										</a>
									</td>
								</tr>
								<tr class="">
									<th scope="row" class="text-center">13</th>
									<td class="text-center"> <img src="assets/img/system/system_13.png" title="ระบบทะเบียนทรัพย์สิน (ครุภัณฑ์)" alt="ระบบทะเบียนทรัพย์สิน (ครุภัณฑ์)" class="mar-t--14px"> </td>
									<td> ระบบทะเบียนทรัพย์สิน (ครุภัณฑ์) </td>
									<td>
										<input class="form-control text-center" type="text" placeholder="ลำดับ" aria-label="กรอกลำดับ" value="-" disabled>
									</td>
									<td class="text-center">
										-
									</td>
									<td class="text-center">  
										<a class="btn btn-secondary mb-3 border-ra-30px" role="button" href="#" data-toggle="modal" data-target="#Vote">
											ร้องขอใช้สิทธิ์
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<div class="col-12 text-center mt-5">
						<div class="text-center mb-5">
							<button type="submit" class="btn btn-success btn-radius"> บันทึกการเปลี่ยนแปลงข้อมูล </button>
						</div>
					</div>
					
					<!--
					<div class="col-12 text-center">
						<div class="captcha-center mt-5">
							<div class="form-group m-b--15px">
								<img src="assets/img/captcha.png" alt="captcha" title="captcha" class="captcha">
								<button type="button" class="btn btn-light">
									<i class="fas fa-sync-alt"></i>
								</button>
								<input type="text" name="captcha" id="captcha" class="form-control mt-1 mx-auto max-w-450px" placeholder="กรอกรหัสตามภาพ">
								<label for="captcha" class="sr-only"> captcha </label>
							</div>
						</div>
						<div class="mb-3 mt-3 form-check text-center">
							<input type="checkbox" class="" id="exampleCheck1">
							<label class="form-check-label" for="exampleCheck1">
								<a href="assets/download/policy.pdf" target="_blank"> ยินยอมนโยบายการเก็บข้อมูลของกรมประชาสัมพันธ์  </a>
							</label>
						</div>
						<div class="text-center mb-5">
							<button type="submit" class="btn btn-success btn-radius"> บันทึกการเปลี่ยนแปลงข้อมูล </button>
						</div>
					</div>
					-->
					<!--
					<div class="mb-3 form-check text-center">
						<input type="checkbox" class="" id="exampleCheck1">
						<label class="form-check-label" for="exampleCheck1">ยินยอมนโยบายการเก็บข้อมูลของกรมประชาสัมพันธ์</label>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-success"> บันทึกลำดับการแสดง </button>
					</div>
					-->
				</div>

				
			</div>
			
		</div>
	</div>
</div>


<!-- Modal ร้องขอใช้สิทธิ์ -->
<div class="modal fade" id="Vote" tabindex="-1" role="dialog" aria-labelledby="Vote" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue-only">
        <h5 class="modal-title font23px txt-white1" id="Vote">การร้องขอใช้สิทธิ์ระบบ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="txt-white1" aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body font18px text-center">
			<div class="text-dark font1-2em">
				ท่านต้องการร้องของการใช้สิทธิ์ระบบ <br>
				 <img src="assets/img/system/system_11.png" title="ติดตามเงินรายได้" alt="ติดตามเงินรายได้" class=""> <span class="txt-color-system"> ติดตามเงินรายได้ </span>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger border-ra-30px" data-dismiss="modal"> <i class="fas fa-times"></i> ปิด </button>
			<button type="button" class="btn btn-primary border-ra-30px" data-dismiss="modal" role="button" data-toggle="modal" data-target="#requestpermission"> <em class="fa fa-check-circle"></em>  ยืนยันการร้องขอสิทธิ์ </button>
		</div>
    </div>
  </div>
</div>


<!-- Modal ยืนยันการร้องขอใช้สิทธิ์ -->
<div class="modal fade" id="requestpermission" tabindex="-1" role="dialog" aria-labelledby="requestpermission" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue-only">
        <h5 class="modal-title font23px text-success" id="requestpermission"> <em class="fa fa-check-circle"></em> ยืนยันการร้องขอใช้สิทธิ์ระบบ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="txt-white1" aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body font18px text-center">
			<div class="text-success font1-2em"> 
					<img src="assets/img/system/system_11.png" title="ติดตามเงินรายได้" alt="ติดตามเงินรายได้" class=""> <span class="txt-color-system"> ติดตามเงินรายได้ </span>
				<br>
				รอการให้สิทธิ์จากทางศูนย์เทคโนโลยีสารสนเทศอีกครั้ง
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger border-ra-30px" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
		</div>
    </div>
  </div>
</div>


<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->