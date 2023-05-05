<?php include('comtop.php'); ?>
<?php include('header.php'); ?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/webboard.css">	

<div class="container-fluid mar-t-90px bg--purple text-center">
	<div class="container py-5 text-center">
		<div class="article--topic"> คุย เรื่อง คน </div>
	</div>
</div>

<section id="article-sec bg--white">
    <div class="container mt-3">
        <!-- start breadcrumb -->
        <p><a href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a> / <a href="webboard.php" title="ชื่อหมวด"> กระดานถามตอบ </a> </p>
        <!-- start breadcrumb -->
        <hr>
		
		<div class="container mb-4">
			<form action="#" method="post" novalidate="novalidate">
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-5 col-md-5 col-sm-12 p-0">
								<input type="text" class="form-control search-slt" placeholder="กรอกคำค้น" list="datalistOptions">
								<datalist id="datalistOptions">
									<option value="หนังสือเวียน"></option>
									<option value="ประชาสัมพันธ์"></option>
									<option value="สื่อประชาสมพันธ์"></option>
									<option value="วาระผู้บริหาร"></option>
								</datalist>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-12 p-0">
								<select class="form-control search-slt search-select" id="exampleFormControlSelect1">
									<option> ทุกหมวด </option>
									<option> คุย เรื่อง คน </option>
									<option> คุยกับนิติกร </option>
									<option> คุยกับ กองคลัง </option>
									<option> ร่วมคิด ร่วมพัฒนา กับ กพร. กปส. </option>
									<option> คุยกับ นคส. </option>
									<option> ถามมา-ตอบไป กับ สพท. </option>
									<option> ห้องรับแขก สลก. </option>
								</select>
							</div>
							
							<div class="col-lg-2 col-md-2 col-sm-12 p-0">
								<button type="button" class="btn btn--search wrn-btn">Search</button>
							</div>
						</div>
						<div class="text-center mt-5 text-red">ผลการคันหา "G-Chat "พบทั้งหมด 1500 รายการ</div>
					</div>
					
				</div>
			</form>
		</div>
	</div>
</section>

<div class="container-fluid bg--purple padding--50">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-12 txt-h-table-left">
				<div class="pt-3">
					กระทู้เว็บบอร์ด
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-12 text-right pb-3">
				<button type="button" class="btn btn-success btn-sm mt-3 font18px border-ra-30px px-3" data-toggle="modal" data-target="#newpost">
					<em class="fa fa-plus"></em> ตั้งกระทู้ใหม่
				</button>
			</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table-responsive">
					<!-- จำนวนการแสดงผลของแต่ละหน้า สามารถกำหนดได้ที่ระบบบริหาร -->
					<table class="table table-hover table-striped table-light">
						<thead>
							<tr class="bg-dark text-white">
								<th scope="col" class="w-1-table"> หัวข้อ </th>
								<th scope="col" class="w-2-table"> หมวดหลัก </th>
								<th scope="col" class="w-3-table"> อ่าน </th>
								<th scope="col" class="w-4-table"> ตอบ </th>
								<th scope="col" class="w-5-table"> ผู้ตอบล่าสุด </th>
							</tr>
						</thead>
						<tbody>
							<tr class="bg-pin">
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark">  
										<img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline"> กระทู้กองการเจ้าหน้าที่ 169 
									</a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> คุย เรื่อง คน </td>
								<td> <em class="fa fa-eye"></em> 182,136 </td>
								<td> <em class="fa fa-clipboard"></em> 25,316 </td>
								<td> <em class="fa fa-user-circle"></em> ณเดช </td>
							</tr>
							<tr class="bg-pin">
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark">  
										<img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline"> กระทู้กองการเจ้าหน้าที่ 236
									</a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> คุย เรื่อง คน </td>
								<td> <em class="fa fa-eye"></em> 2,455 </td>
								<td> <em class="fa fa-clipboard"></em> 1,799 </td>
								<td> <em class="fa fa-user-circle"></em> พลายกระซิบ </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark"> กระทู้กองการเจ้าหน้าที่ 2 </a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> คุย เรื่อง คน </td>
								<td> <em class="fa fa-eye"></em> 3 </td>
								<td> <em class="fa fa-clipboard"></em> 1 </td>
								<td> <em class="fa fa-user-circle"></em> น้องบิ๊ก </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark"> กระทู้กองการเจ้าหน้าที่ 3 </a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> คุย เรื่อง คน </td>
								<td> <em class="fa fa-eye"></em> 16,589 </td>
								<td> <em class="fa fa-clipboard"></em> 118 </td>
								<td> <em class="fa fa-user-circle"></em> ชายตามอง </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark">  กระทู้กองการเจ้าหน้าที่ 4 </a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> คุย เรื่อง คน </td>
								<td> <em class="fa fa-eye"></em> 89 </td>
								<td> <em class="fa fa-clipboard"></em> 4 </td>
								<td> <em class="fa fa-user-circle"></em> ประคอง </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark"> กระทู้กองการเจ้าหน้าที่ 5 </a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> คุย เรื่อง คน </td>
								<td> <em class="fa fa-eye"></em> 47 </td>
								<td> <em class="fa fa-clipboard"></em> 8 </td>
								<td> <em class="fa fa-user-circle"></em> ง่วงนอน </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark">  กระทู้กองการเจ้าหน้าที่ 6 </a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> คุย เรื่อง คน </td>
								<td> <em class="fa fa-eye"></em> 117 </td>
								<td> <em class="fa fa-clipboard"></em> 2 </td>
								<td> <em class="fa fa-user-circle"></em> ณเดช </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark"> กระทู้กองการเจ้าหน้าที่ 7 </a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> คุย เรื่อง คน </td>
								<td> <em class="fa fa-eye"></em> 3 </td>
								<td> <em class="fa fa-clipboard"></em> 1 </td>
								<td> <em class="fa fa-user-circle"></em> น้องบิ๊ก </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark"> กระทู้กองการเจ้าหน้าที่ 8 </a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> คุย เรื่อง คน </td>
								<td> <em class="fa fa-eye"></em> 16,589 </td>
								<td> <em class="fa fa-clipboard"></em> 118 </td>
								<td> <em class="fa fa-user-circle"></em> ชายตามอง </td>
							</tr>
						</tbody>
					</table>
				</div>
				
            </div>
			
			<!-- Start แสดงการตัดหน้าเพจ -->
			<div class="text-center">
				<div class="pagination p6">
				  <ul>
					<a href="#"><li>1</li></a>
					<a href="#"><li>2</li></a>
					<a href="#"><li>3</li></a>
					<a href="#"><li>4</li></a>
					<a class="is-active" href="#"><li>5</li></a>
					<a href="#"><li>6</li></a>
				  </ul>
				</div>
			</div>
			<!-- End แสดงการตัดหน้าเพจ-->
            
        </div>
        
	</div>
</div>

<section id="article-sec">
    <div class="container">
        <div class="webboard--subcat"> หมวดภายใน </div>
        <div class="row">
		
			<div class="table-responsive">
				<table class="table table-hover table-striped table-light">
					<thead>
						<tr class="bg-dark text-white">
							<th scope="col" class="w-1-1-table"> หมวด </th>
							<th scope="col" class="w-1-2-table"> จำนวนกระทู้ </th>
							<th scope="col" class="w-1-3-table"> จำนวนผู้ตอบ </th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row"> 
								<a href="more_webboard.php" class="txt-dark font20px"> 
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px">  <span class=""> เรื่องทั่วไป </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 35 </td>
							<td> <em class="fa fa-user-circle"></em> 44 </td>
						</tr>
						<tr>
							<th scope="row"> 
								<a href="more_webboard.php" class="txt-dark font20px"> 
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px">  <span class=""> ข้อสงสัยเกี่ยวกับกองการเจ้าหน้าที่ </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 3 </td>
							<td> <em class="fa fa-user-circle"></em> 3 </td>
						</tr>
					</tbody>
				</table>
			</div>
        </div>
		
		
		
    </div>
</section>



<!-- Modal -->
<div class="modal fade" id="newpost" tabindex="-1" aria-labelledby="newpost" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title font20px" id="newpost"> ตั้งคำถามหรือเปิดประเด็นใหม่ตรงนี้ </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="alert alert-warning font18px" role="alert">
				กรุณาแสดงความคิดเห็นอย่างสร้างสรรค์ หน่วยงานจะไม่รับผิดชอบต่อความคิดเห็นใดๆ ทั้งสิ้น เพราะไม่สามารถระบุได้ว่าเป็นความจริง ผู้อ่านจึงควรใช้วิจารณญาณในการกลั่นกรอง หรือถ้าท่านพบเห็นข้อความใดที่ขัดต่อกฎหมายและศีลธรรม หรือเป็นการกลั่นแกล้งเพื่อให้เกิดความเสียหาย ต่อบุคคล หรือหน่วยงานใด กรุณาแจ้งมาที่ <a href="#"> ผู้ดูแลระบบ </a> เพื่อให้ระบบทราบและทำการลบข้อความนั้น ออกจากระบบต่อไป ขอขอบพระคุณล่วงหน้า มา ณ โอกาสนี้
			</div>
			<form>
				<div class="form-group row font18px">
					<label for="inputuser" class="col-sm-3 col-form-label font18px font-w-600"><span class="red">*</span> ผู้ตั้ง </label>
					<div class="col-sm-9">
						<input type="text" class="form-control font18px" id="inputuser" value="ลลิษา" disabled>
					</div>
				</div>
				<div class="form-group row font18px">
					<label for="inputtopic-w" class="col-sm-3 col-form-label font18px font-w-600"><span class="red">*</span> หัวข้อกระทู้ </label>
					<div class="col-sm-9">
						<input type="text" class="form-control font18px" id="inputtopic-w" placeholder="ตั้งหัวข้อกระทู้">
					</div>
				</div>
				<div class="form-group row font18px">
					<label for="inputdetial" class="col-sm-3 col-form-label font18px font-w-600"><span class="red">*</span> รายละเอียด </label>
					<div class="col-sm-9">
						<textarea class="form-control font18px" id="inputdetial" rows="3" placeholder="กรอกรายละเอียดกระทู้"></textarea>
						<div class="dis-flex p-2">
							<a href="#">
								<img src="assets/img/emotion/emo1.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo2.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo3.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo4.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo5.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo6.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo7.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo8.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo9.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo10.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo11.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
							<a href="#">
								<img src="assets/img/emotion/emo12.png" title="emotion" alt="emotion" class="width-emotion">
							</a>
						</div>
					</div>
				</div>
				<div class="form-group row font18px">
					<label for="inputuser" class="col-sm-3 col-form-label font18px font-w-600"><span class="red">*</span> ความปลอดภัย </label>
					<div class="col-sm-9">
						<div class="w-100 max-width350px text-center">
							<div class="bg-captcha">
								<img src="assets/img/captcha/ewt_picmain.png" title="captcha" alt="captcha" class="mx-auto">
							</div>
							<a href="#">
								<div class="re-captcha mb-2"> คลิกเพื่อเปลี่ยนรูป <i class="fas fa-sync-alt"></i> </div>
							</a>
						</div>
						<input type="text" class="form-control font18px" id="inputuser" placeholder="กรอกรหัสความปลอดภัย">
						<div class="text-center mt-2">
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<small>กรุณาตรวจสอบรหัสความปลอดภัยของท่านให้ถูกต้องค่ะ!</small>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>	  
						</div>
						<br> 
					</div>
				</div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger font18px border-ra-30px px-3" data-dismiss="modal">ยกเลิก </button>
        <button type="button" class="btn btn-success font18px border-ra-30px px-3"> ตั้งกระทู้ใหม่ </button>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>