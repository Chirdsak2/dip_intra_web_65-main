<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->

<style>
.header--bg{
    padding: 50px 0px 0px 0px;
    background: #EEEEEE;
    text-align: center;
}
</style>

<div class="container-fluid mar-t-90px header--bg">
	<div class="container py-5 text-center">
		<h3> แก้ไขข้อมูลส่วนตัว </h3>
	</div>
</div>


<div class="container-fluid mt-5">
	<div class="container">
		<form>
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-12 col-12">
					<div>
						<div class="">
							<img src="assets/img/user-pic.jpg" class="w-100" title="ภาพประกอบ" alt="ภาพประกอบ">
						</div>
						<label for="myfile"> เลือกภาพผู้ใช้งาน </label>
						<input type="file" id="myfile" name="myfile">
					</div>
					
					<div class="row g-3 mt-4">
						<div class="form-floating mb-3 col-lg-12 col-md-12 col-sm-12 col-12">
							<label for="nameuserwebboard" class="label-form"> นามสมมุติ  </label>
							<input type="text" class="form-control" placeholder="กรอกชื่อนามสมมุติ" id="nameuserwebboard"></input>
							<div class="form-text font-detial-form">
								ชื่อสมมุติที่ใช้กับ Webboard หากไม่ได้กรอกจะดึงชื่อจริงไปแสดงที่เว็บบอร์ด
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-12">
							<button type="button" class="btn btn-warning w-100 border-ra-30px" onclick="window.open('card_receive.php','_blank')">
								ได้รับการ์ดอวยพรวันเกิด <span class="badge badge-light">99</span> รายการ
							  <span class="sr-only">unread messages</span>
							</button>
						</div>
					</div>
					
					<div class="row mt-4">
						<div class="col-12">
							<div class="bg-green border-ra-15px">
								<div class="text-white font35px text-center font-weight-bold"> <!--<img src="assets/img/gift.png" title="gift" alt="gift" class="max-width50px pr-2">--> KM POINT </div>
								<div class="bg-white">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="row py-3 px-1 font-weight-bold border-b-km">
												<div class="col-lg-7 col-md-12 col-sm-12 col-12">
													<div class="text-left text-dark font20px">
														POST POINT
													</div>
												</div>
												<div class="col-lg-5 col-md-12 col-sm-12 col-12">
													<div class="text-right txt-color-purple font20px pl-0">
														50
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="row py-3 px-1 font-weight-bold border-b-km">
												<div class="col-lg-7 col-md-12 col-sm-12 col-12">
													<div class="text-left text-dark font20px">
														VIEW POINT
													</div>
												</div>
												<div class="col-lg-5 col-md-12 col-sm-12 col-12 pl-0">
													<div class="text-right txt-color-purple font20px">
														50,000
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
				<div class="col-lg-9 col-md-9 col-sm-12 col-12">
					<div class="row g-3">
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="firstDataList" class="label-form"> คำนำหน้า <span class="txt-red">*</span> </label>
							<input class="form-control" list="datalistOptions" value=" นางสาว /Miss"> 
							<datalist id="datalistOptions">
								<!--<option selected> เลือกคำนำหน้า </option> -->
								<option value="นาย"> นาย / Mr. </option>
								<option value="นาง"> นาง /Mrs. </option>
								<option value="นางสาว"> นางสาว /Miss </option>
								<option value="ร้อยตำรวจเอก"> ร้อยตำรวจเอก / police lieutenant colonel </option>
								<option value="สิบเอก"> สิบเอก / sergeant </option>
							</datalist>
						</div>
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="firstnameuser" class="label-form"> ชื่อ </label>
							<input type="text" class="form-control" placeholder="กรอกชื่อผู้ใช้" id="firstnameuser" value="ลลิษา"></input>
						</div>
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="lastnameuser" class="label-form"> นามสกุล </label>
							<input type="text" class="form-control" placeholder="กรอกนามสกุลผู้ใช้" id="lastnameuser" value="มโนบาล"></input>
						</div>
						<div class="offset-lg-4 offset-md-4 form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="firstnameuser" class="label-form"> Name </label>
							<input type="text" class="form-control" placeholder="กรอกชื่อผู้ใช้" id="firstnameuser" value="Lalisa"></input>
						</div>
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="lastnameuser" class="label-form"> Surname </label>
							<input type="text" class="form-control" placeholder="กรอกนามสกุลผู้ใช้" id="lastnameuser" value="Manoban"></input>
						</div>
					</div>
					<!--
					<div class="mb-3">
						<label for="firstnameuser" class="form-label"> ชื่อ </label>
						<input type="text" class="form-control" id="firstnameuser" placeholder="กรอกชื่อผู้ใช้" value="สุริยะ" disabled>
					</div>
					<div class="mb-3">
						<label for="lastnameuser" class="form-label"> นามสกุล </label>
						<input type="text" class="form-control" id="lastnameuser" placeholder="กรอกนามสกุลผู้ใช้" value="อาจจะนะ" disabled>
					</div>
					-->
					<div class="row g-3">
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="Affiliationuser" class="form-label label-form"> สังกัด  (ตามโครงสร้าง)<span class="txt-red">*</span></label>
							<input class="form-control" list="Affiliation" id="Affiliationuser" value="ผู้เชี่ยวชาญ" disabled>
							<datalist id="Affiliation">
								<option value="ผู้เชี่ยวชาญ">
								<option value="กองการเจ้าหน้าที่">
								<option value="กองกฎหมายและระเบียบ">
								<option value="กองคลัง">
								<option value="กลุ่มพัฒนาระบบบริหาร">
								<option value="หน่วยตรวจสอบภายใน">
								<option value="สำนักพัฒนานโยบายและแผนการประชาสัมพันธ์">
								<option value="สำนักส่งเสริมและพัฒนางานเทคนิค">
								<option value="สำนักพัฒนาการประชาสัมพันธ์">
								<option value="สำนักงานเลขานุการกรม">
								<option value="สถานีวิทยุกระจายเสียงแห่งประเทศไทย">
								<option value="ศูนย์เทคโนโลยีสารสนเทศการประชาสัมพันธ์">
								<option value="สำนักการประชาสัมพันธ์ต่างประเทศ">
								<option value="สำนักข่าว">
								<option value="สถาบันการประชาสัมพันธ์">
								<option value="กลุ่มงานคุ้มครองจริยธรรม">
								<option value="สหกรณ์ออมทรัพย์กรมประชาสัมพันธ์">
							</datalist>
							
						</div>
						
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="Affiliationusertrue" class="form-label label-form"> สังกัด  (ปฏิบัติงานจริง)<span class="txt-red">*</span></label>
							<input class="form-control" list="Affiliationtrue" id="Affiliationusertrue" value="ผู้เชี่ยวชาญ" disabled>
							<datalist id="Affiliationtrue">
								<option value="ผู้เชี่ยวชาญ">
								<option value="กองการเจ้าหน้าที่">
								<option value="กองกฎหมายและระเบียบ">
								<option value="กองคลัง">
								<option value="กลุ่มพัฒนาระบบบริหาร">
								<option value="หน่วยตรวจสอบภายใน">
								<option value="สำนักพัฒนานโยบายและแผนการประชาสัมพันธ์">
								<option value="สำนักส่งเสริมและพัฒนางานเทคนิค">
								<option value="สำนักพัฒนาการประชาสัมพันธ์">
								<option value="สำนักงานเลขานุการกรม">
								<option value="สถานีวิทยุกระจายเสียงแห่งประเทศไทย">
								<option value="ศูนย์เทคโนโลยีสารสนเทศการประชาสัมพันธ์">
								<option value="สำนักการประชาสัมพันธ์ต่างประเทศ">
								<option value="สำนักข่าว">
								<option value="สถาบันการประชาสัมพันธ์">
								<option value="กลุ่มงานคุ้มครองจริยธรรม">
								<option value="สหกรณ์ออมทรัพย์กรมประชาสัมพันธ์">
							</datalist>
							
						</div>
						
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="Positionuser" class="form-label label-form"> ตำแหน่ง  <span class="txt-red">*</span></label>
							<input class="form-control" list="Position" id="Positionuser" value="ข้าราชการ" disabled>
							<datalist id="Position">
								<option value="ลูกจ้าง">
								<option value="ลูกจ้างประจำ">
								<option value="ข้าราชการ">
								<option value="ช้าราชการชำนาญการ">
								<option value="ช้าราชการชำนาญการพิเศษ">
							</datalist>
						</div>
					</div>
					
					<div class="row g-3">
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="Inputemail" class="form-label label-form"> Email <span class="txt-red">*</span> </label>
							<input type="email" class="form-control" id="Inputemail" aria-describedby="emailHelp" value="lalisa_m@gmail.com">
							<div id="emailHelp" class="form-text font-detial-form">กรุณากรอกอีเมลที่ท่านใช้งานอยู่จริงและกรอกในรุปแบบของ Email ให้ถูกต้องเช่น  prd-user@gmail.com เป็นต้น</div>
							
							<div class="text-center mt-2">
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<small>กรุณาตรวจสอบอีเมลของท่านให้ถูกต้องค่ะ!</small>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>	  
							</div>
						
						</div>
						
						<!--
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="teluser" class="form-label label-form"> เบอร์โทรศัพท์  (เบอร์สำนักงาน)</label>
							<input type="tel" class="form-control" id="teluser" placeholder="กรอกเบอร์โทรศัพท์เช่น 021234567">
							
							<div class="text-center mt-2">
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<small>กรุณาตรวจสอบเบอร์โทรศัพท์ (เบอร์สำนักงาน) ของท่านให้ถูกต้องค่ะ!</small>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>	  
							</div>
						
						</div>
						-->
						
						<div class="form-floating mb-3 col-lg-4 col-md-4 col-sm-12 col-12">
							<label for="telusermobile" class="form-label label-form"> เบอร์โทรศัพท์  (เบอร์มือถือ)</label>
							<input type="tel" class="form-control" id="telusermobile" placeholder="กรอกเบอร์โทรศัพท์เช่น 021234567">
							<div id="emailHelp" class="form-text font-detial-form">กรุณากรอกเบอร์โทรศัพม์มือถือที่ท่านใช้งานอยู่จริงและกรอกในรุปแบบให้ถูกต้องเช่น  0123456789 </div>
							
							<div class="text-center mt-2">
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<small>กรุณาตรวจสอบเบอร์โทรศัพท์(เบอร์มือถือ) ของท่านให้ถูกต้องค่ะ!</small>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>	  
							</div>
						
						</div>
							
					</div>
					
					<div class="row">
						<div class="mb-3 col-lg-6 col-md-6 col-sm-12 col-12">
							<label for="teluser" class="form-label label-form"> วัน/เดือน/ปี เกิด </label>
							<!--<input type="date" class="form-control" id="teluser" placeholder="เลือกวันเดือนปีเกิด"> -->
							<input placeholder="วันเดือนปีเกิด" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="startdate" />
						</div>
					</div>
					
					
					<div class="my-3">
						<label for="statusseting" class="form-label"> ตั้งค่าสถานะวันเกิด  <span class="txt-red">*</span></label>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
							<label class="form-check-label" for="flexRadioDefault1">
								เปิดสถานะ 
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
							<label class="form-check-label" for="flexRadioDefault2">
								ปิดสถานะ
							</label>
						</div>
					</div>
					
				</div>
				
				
				
				<div class="col-12 text-center">
					<div class="captcha-center mt-5">
						<div class="form-group m-b--15px">
							<div class="w-100 max-w-450px text-center mx-auto">
								<div class="bg-captcha">
									<img src="assets/img/captcha/ewt_picmain.png" title="captcha" alt="captcha" class="mx-auto">
								</div>
								<a href="#">
									<div class="re-captcha mb-2"> คลิกเพื่อเปลี่ยนรูป <i class="fas fa-sync-alt"></i> </div>
								</a>
							</div>
							<input type="text" name="captcha" id="captcha" class="form-control mt-1 mx-auto max-w-450px" placeholder="กรอกรหัสตามภาพ">
							<label for="captcha" class="sr-only"> captcha </label>
						</div>
					</div>
					<div class="mb-3 mt-3 form-check txt-center">
						<input type="checkbox" class="" id="exampleCheck1" checked>
						<label class="form-check-label" for="exampleCheck1">
							<a href="assets/download/policy.pdf" target="_blank"> ยินยอมนโยบายการเก็บข้อมูลของกรมประชาสัมพันธ์  </a>
						</label>
					</div>
					<div class="txt-center mb-5">
						<button type="submit" class="btn btn-success btn-radius">  บันทึกการเปลี่ยนแปลงข้อมูล </button>
					</div>
				</div>
			
			</div>
			
			
			<!--
			<div class="mb-3 form-check txt-center">
				<input type="checkbox" class="" id="exampleCheck1">
				<label class="form-check-label" for="exampleCheck1">ยินยอมนโยบายการเก็บข้อมูลของกรมประชาสัมพันธ์</label>
			</div>
			<div class="txt-center">
				<button type="submit" class="btn btn-success"> แก้ไขข้อมูลส่วนตัว </button>
			</div>
			-->
		</form>
	</div>
</div>


<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->