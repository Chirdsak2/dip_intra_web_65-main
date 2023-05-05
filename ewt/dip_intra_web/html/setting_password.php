<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->

<div class="container-fluid mar-t-90px header--bg">
	<div class="container py-5 text-center">
		<h3> เปลี่ยนรหัสผ่าน </h3>
	</div>
</div>


<div class="container-fluid mt-5">
	<div class="container">
		<div class="row">
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 border-l-graylight">
				<div class="font30px mb-4 text-center txt-color-purple"> ขั้นตอนที่ 1 : ระบุรหัสผ่านเดิม </div> 
				<div class="font25px mb-4 text-center"> คุณ ลลิษา มโนบาล  </div>
				<div class="row g-3">
					<!--
					<div class="mb-3 form-floating col-12">
						<input type="text" class="form-control" id="q-for-question" value="ชื่อที่คุณชื่นชอบ" disabled>
						<label for="q-for-question" class="form-label"> คำถามขอเปลี่ยนรหัสผ่าน </label>
					</div>
					-->
					
					<div class="form-floating mb-3 offset-lg-4 col-lg-4 offset-md-4 col-md-4 col-sm-12 col-12">
						<label for="firstnameuser" class="label-form"> รหัสผ่านเดิม : </label>
						<input type="password" class="form-control" placeholder="กรอกรหัสผ่านเดิม" id="passwordold"></input>
					</div>
					
					<div class="form-floating mb-3 offset-lg-4 col-lg-4 offset-md-4 col-md-4 col-sm-12 col-12">
						<label for="firstnameuser" class="label-form"> รหัสผ่านใหม่ : </label>
						<input type="password" class="form-control" placeholder="กรอกรหัสผ่านใหม่" id="passwordnew"></input>
					</div>
					
					<div class="form-floating mb-3 offset-lg-4 col-lg-4 offset-md-4 col-md-4 col-sm-12 col-12">
						<label for="firstnameuser" class="label-form"> ยืนยันรหัสผ่านใหม่ : </label>
						<input type="password" class="form-control" placeholder="กรอกรหัสผ่านใหม่อีกครั้ง" id="passwordnewconfirm"></input>
					</div>
					
					<div class="font15px text-danger offset-lg-4 col-lg-4 col-md-4 col-sm-12 col-12">
						* รหัสผ่านควรมีจำนวนตัวอักษรอย่างน้อย 8 ตัว, ประกอบไปด้วยตัวเลข 0-9, ประกอบไปด้วยตัวอักษรภาษาอังกฤษ
					</div>
					
				</div>
			</div>
			
			
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
				<div class="text-center mb-5">
					<button type="submit" class="btn btn-success btn-radius"> ตกลง </button>
					<button type="submit" class="btn btn-danger btn-radius"> ยกเลิก </button>
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