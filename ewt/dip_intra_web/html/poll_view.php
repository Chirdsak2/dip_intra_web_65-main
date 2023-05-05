<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->
<link rel="stylesheet" href="assets/css/poll.css">

<div class="container-fluid mar-t-90px bg--purple text-center">
	<div class="container py-5">
		<div class="top--topic--detial"> แบบสำรวจที่ 1 </div>
	</div>
</div>


<div class="container-fluid">
	<!-- Open News -->
	<div class="container mt-3">
	
		<!-- start breadcrumb -->
        <p><a href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a> / <a href="poll.php" title="ชื่อหมวด">แบบสำรวจ</a> </p>
        <!-- start breadcrumb -->
        <hr>
		
		<div class="row mb-5 mt-5">
			
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div>
							<!-- Show FAQs -->
							<div>
							<form class="font20px" action="#" id="home_search_form_1">
							<fieldset>

								<div class="container mb-2">
									<div class="radio pb-3">
										<label for="selectradio1" hidden> ดีมาก </label>
										<input type="radio" name="radio2" id="selectradio1"> ดีมาก
									</div>
									<div class="radio pb-3">
										<label for="selectradio2" hidden> ดี </label>
										<input type="radio" name="radio2" id="selectradio2"> ดี
									</div>
									<div class="radio pb-3">
										<label for="selectradio3" hidden> พอใช้ </label>
										<input type="radio" name="radio2" id="selectradio3"> พอใช้
									</div>
								</div>
								
								<!--
								<div align="center" class="container my-3">
										<button type="submit" class="btn btn-success"> Submit Form </button>
								 </div>
								 -->
								 
								<div class="col-xl-12 text-center ">
									<a class="btn btn-success mb-3 " role="button" href="#" data-toggle="modal" data-target="#Vote">
										<em class="fa fa-check-circle"></em> โหวต
									</a>
									<a class="btn btn-primary mb-3" role="button" href="#" data-toggle="modal" data-target="#Result">
										<i class="fa fa-signal"></i> ผลโหวต
									</a>
								</div>


								<!-- Modal ปุ่มตอบแบบฟอร์ม -->
								<div class="margintop15 mb-2">

								</div>
								<div class="clearfix"></div> 
								
							</fieldset>
						</form>
					</div>

											 
					<!-- end Show Form -->
												
												
											  
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
	<!-- Close News -->

</div>



<!-- Modal Vote -->
<div class="modal fade" id="Vote" tabindex="-1" role="dialog" aria-labelledby="Vote" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue-only">
        <h5 class="modal-title font23px txt-white1" id="Vote">โหวต</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="txt-white1" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body font18px text-center">
          <div class="text-success  font1-2em"> <em class="fa fa-check-circle"></em> ขอบคุณสำหรับการโหวต <!-- Thank you for your voted.--> </div>  <!-- ใช้กรณี vote สำเร็จ -->
		  <div class="text-primary  font1-2em"> คุณได้ทำการโหวตไปเรียบร้อยแล้ว ขอบคุณสำหรับการโหวต <!--You have voted already, Thank You.--> </div> <!-- ใช้กรณี vote สำเร็จ แล้วกด vote ซ้ำอีกครั้งแต่ระบบไม่อนุญาติให้โหวตซ้ำตามเงื่อนไขที่ตั้งไว้ เช่น โหวตได้ทุก 1 ชั่วโมงและจะไม่เก็บสถิติ -->
		  <div class="text-warning  font1-2em"> กรุณาเลือกข้อมูลที่ต้องการโหวต <!--  Choose one choice to vote. --> </div>  <!-- ใช้กรณีไม่ได้เลือกตัวเลือกในการ Vote-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Vote Result -->
<div class="modal fade" id="Result" tabindex="-1" role="dialog" aria-labelledby="Result" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
		<div class="modal-header bg-blue-only">
			<h5 class="modal-title font23px txt-white1" id="Vote">ผลโหวตให้คะแนนแบบสำรวจออนไลน์ จาก 17 คน</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span class="txt-white1" aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body font25px">
			<div class="mb-3">
				<em class="fas fa-poll-h pr-1 pl-2 pt-2 font35px"></em>  แบบสำรวจที่ 1 
			</div>
 
			<div class="row calendar-row">
				<div class="col-sm-3 text-right font20px"> ดีมาก </div>
				<div class="col-sm-9">
					<div class="progress mt-2">
					  <div class="progress-bar font15px" role="progressbar" style="width: 73%" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100">73% (14)</div>
					</div>
				</div>
			</div>
	  
			<div class="row calendar-row">
				<div class="col-sm-3 text-right font20px"> ดี </div>
				<div class="col-sm-9">
					<div class="progress mt-2">
					  <div class="progress-bar font15px" role="progressbar" style="width: 16%" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100">16% (2)</div>
					</div>
				</div>
			</div>
	  
			<div class="row calendar-row">
				<div class="col-sm-3 text-right font20px"> พอใช้ </div>
				<div class="col-sm-9">
					<div class="progress mt-2">
					  <div class="progress-bar font15px" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10% (1)</div>
					</div>
				</div>
			</div>
		  
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>
    </div>
  </div>
</div>


<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->