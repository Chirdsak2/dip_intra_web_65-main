<?php 
$file_page='calendar_visit.php';
include("include.php");
include('comtop.php');?>
<?php include('chat_messenger.php'); ?>



<!-- Open Container-fluid -->
<div class="container-fluid bg-space pr-0">
	<div class="height-menu-sub">
		<?php include 'menu.php';?>
	</div>

	<!-- <div class="w-100 bg-sup-top">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb just-center">
				<li class="breadcrumb-item"><a href="index.php"> หน้าหลัก </a></li>
				<li class="breadcrumb-item active" aria-current="page"> ค้นหา </li>
			</ol>
		</nav>
	</div> -->

	<!-- Open Content -->

	<div class="container-fluid txt-white-color p-4 bg-black-sub">
		<div class="container">

			<div class="title-page">
				ปฏิทินเยี่ยมชม GISTDA
			</div>

			<!-- Open List VDO -->
			<div class="mt-5">
				<div class="row">
				                    <div class="col-md-12">
				                        <nav>
				                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
				                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">ปฏิทินเยี่ยมชม</a>
				                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">ระเบียบการเข้าเยี่ยมชม</a>
				                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">คำถามที่พบบ่อย</a>
				                            </div>
				                        </nav>
				                        <div class="tab-content" id="nav-tabContent">
				                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
																			
																				<div class="mt-3 text-center">

																					<button type="button" class="mt-3 btn btn-visitbkk">แบบฟอร์มเข้าเยี่ยมชมกิจการและดูงาน สทอภ.สำนักงานใหญ่</button>

																					<button type="button" class="mt-3 btn btn-visitsriracha">แบบฟอร์มเข้าเยี่ยมชมกิจการและดูงาน สทอภ.อำเภอศรีราชา </button>


																				</div>

				                            </div>
				                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
				                               <div class="mt-3">
																				 ! ดึงข้อมูลมาจาก article !
																			 </div>
				                            </div>
				                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
																			<div class="mt-3">
																				! ดึงข้อมูลมาจาก faq !
																			</div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
			</div>
			<!-- Close List VDO -->

		</div>

	</div> <!-- Close Container -->
	<!-- Close Content -->
</div> <!-- Close Container-fluid -->

<?php include 'newsletter.php';?>
<?php include 'combottom.php';?>
<?php include 'footer.php';
include 'calendar/index.php';?>
