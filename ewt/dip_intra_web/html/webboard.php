<?php include('comtop.php'); ?>
<?php include('header.php'); ?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/webboard.css">		


<div class="container-fluid mar-t-90px header--bg">
	<div class="container py-5 text-center">
		<h3> กระดานถามตอบ </h3>
	</div>
</div>

<section class="search-sec header--bg">
    
    <div class="container">
        <form action="#" method="post" novalidate="novalidate">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12 p-0">
                            <input type="text" class="form-control search-slt" placeholder="กรอกคำค้น" list="datalistOptions">
							<datalist id="datalistOptions">
								<!--<option selected> เลือกคำนำหน้า </option> -->
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
</section>
<div class="container-fluid bg--purple padding--50">
	<div class="container">
		<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="txt-h-section-white">
					กระทู้ล่าสุด
				</div>
				<div class="table-responsive">
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
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark">  คู่มือการจัดทำชุดข้อมูล (Open Data) สำหรับหน่วยงานภายในกรมประชาสัมพันธ์ </a>
									<span class="txt-purple-webboard"> โดยมโนจิต | (11/01/2565 09:24:43) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> สหกรณ์ออมทรัพย์กรมประชาสัมพันธ์ </td>
								<td> <em class="fa fa-eye"></em> 117 </td>
								<td> <em class="fa fa-clipboard"></em> 2 </td>
								<td> <em class="fa fa-user-circle"></em> ณเดช </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark"> จะรู้ได้ยังไงว่าใครมีสิทธิ์ใช้ระบบอะไรบ้างเหรอ หรือใครรู้ช่วยบอกที </a>
									<span class="txt-purple-webboard"> โดยฉันไม่รู้ | (9/01/2565 06:06:06) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> สำนักพัฒนานโยบายและแผนการประชาสัมพันธ์ </td>
								<td> <em class="fa fa-eye"></em> 3 </td>
								<td> <em class="fa fa-clipboard"></em> 1 </td>
								<td> <em class="fa fa-user-circle"></em> น้องบิ๊ก </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark"> เพิ่งเข้ามาใหม่สวัสดีค่ะ </a>
									<span class="txt-purple-webboard"> โดยนางบริสุทธิ์ | (8/01/2565 16:47:31) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> กองคลัง </td>
								<td> <em class="fa fa-eye"></em> 16,589 </td>
								<td> <em class="fa fa-clipboard"></em> 118 </td>
								<td> <em class="fa fa-user-circle"></em> ชายตามอง </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark">  มาสำรวจสุขกันเถอะ </a>
									<span class="txt-purple-webboard"> โดยกระบอกน้ำ | (5/01/2565 13:57:24) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> กองการเจ้าหน้าที่ </td>
								<td> <em class="fa fa-eye"></em> 89 </td>
								<td> <em class="fa fa-clipboard"></em> 4 </td>
								<td> <em class="fa fa-user-circle"></em> ประคอง </td>
							</tr>
							<tr>
								<th scope="row"> 
									<a href="webboard_answer.php" class="txt-dark"> ขอบพระคุณคนที่เก็บกระเป๋าเหรียญให้นะคะ </a>
									<span class="txt-purple-webboard"> โดยละลาย | (4/01/2565 15:55:55) </span>
								</th>
								<td class="font14px">  <img src="assets/img/icon/file.svg" class="float-left max-w-20px"> กองผู้เชี่ยวชาญ </td>
								<td> <em class="fa fa-eye"></em> 47 </td>
								<td> <em class="fa fa-clipboard"></em> 8 </td>
								<td> <em class="fa fa-user-circle"></em> ง่วงนอน </td>
							</tr>
						</tbody>
					</table>
				</div>
				
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

<section id="article-sec">
    <div class="container">
        <div class="webboard--subcat"> หมวดหลักกระทู้ </div>
        <div class="row">
		
			<div class="table-responsive">
				<table class="table table-hover table-striped table-light">
					<thead>
						<tr class="bg-dark text-white">
							<th scope="col" class="w-1-1-table"> หมวดหลัก </th>
							<th scope="col" class="w-1-2-table"> จำนวนกระทู้ </th>
							<th scope="col" class="w-1-3-table"> จำนวนผู้ตอบ </th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row"> 
								<a href="more_webboard.php" class="txt-dark font20px"> 
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px">  <span class=""> คุย เรื่อง คน </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 112 </td>
							<td> <em class="fa fa-user-circle"></em> 52 </td>
						</tr>
						<tr>
							<th scope="row"> 
								<a href="more_webboard.php" class="txt-dark font20px"> 
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px">  <span class=""> คุยกับนิติกร </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 112 </td>
							<td> <em class="fa fa-user-circle"></em> 52 </td>
						</tr>
						
						<tr>
							<th scope="row"> 
								<a href="more_webboard.php" class="txt-dark font20px"> 
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px">  <span class=""> คุยกับ กองคลัง </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 112 </td>
							<td> <em class="fa fa-user-circle"></em> 52 </td>
						</tr>
						<tr>
							<th scope="row"> 
								<a href="more_webboard.php" class="txt-dark font20px"> 
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px">  <span class=""> ร่วมคิด ร่วมพัฒนา กับ กพร. กปส. </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 112 </td>
							<td> <em class="fa fa-user-circle"></em> 52 </td>
						</tr>
						<tr>
							<th scope="row"> 
								<a href="more_webboard.php" class="txt-dark font20px"> 
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px">  <span class=""> คุยกับ นคส. </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 112 </td>
							<td> <em class="fa fa-user-circle"></em> 52 </td>
						</tr>
						<tr>
							<th scope="row"> 
								<a href="more_webboard.php" class="txt-dark font20px"> 
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px">  <span class=""> ถามมา-ตอบไป กับ สพท. </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 112 </td>
							<td> <em class="fa fa-user-circle"></em> 52 </td>
						</tr>
						<tr>
							<th scope="row"> 
								<a href="more_webboard.php" class="txt-dark font20px"> 
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px">  <span class=""> ห้องรับแขก สลก. </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 112 </td>
							<td> <em class="fa fa-user-circle"></em> 52 </td>
						</tr>
						
					</tbody>
				</table>
			</div>
		
            
        </div>
    </div>
</section>

<div class="container mt-4">
	<div class="row">
		<div class="col-12 text-center alert alert-warning" role="alert">
			<h4> ประกาศ </h4>
			<div class=" text-left font18px">
				เนื่องจาก Intranet Portal กรมประชาสัมพันธ์ เป็น Website ที่ให้บริการเข้าถึงระบบต่างๆ ได้ให้ผู้เข้าเยี่ยมชมได้ร่วมกันแสดงความคิดเห็น ไม่ว่าจะเป็นการตั้งกระทู้ หรือการร่วมแสดงความเห็นในกระทู้ต่างๆ จึงจำเป็นต้องกระทำด้วยความระมัดระวัง เพื่อไม่ให้เกิดความเสียหายต่อสังคมส่วนรวม โปรดใช้ข้อความที่สุภาพ ตั้งกระทู้ให้ตรงกับเนื้อหาหรือระบบใน Website ห้ามเสนอข้อความหรือเนื้อหาที่ส่อไปในทางหยาบคาย ก้าวร้าว ลามก อนาจาร หรือก่อให้เกิดความเสียหายต่อบุคคลอื่น และเนื้อหาอันเป็นสิ่งที่เกี่ยวข้องกับสิ่งผิดกฎหมาย หรือศีลธรรมอันดีของสังคม
			</div>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>