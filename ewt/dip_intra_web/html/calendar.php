<?php include('comtop.php'); ?>
<?php include('header.php'); ?>

<?php if ($monthAmount < 29) { ?>
	<li class="outside">
		<div class="date">1</div>
	</li>
	<li class="outside">
		<div class="date">2</div>
	</li>
	<li class="outside">
		<div class="date">3</div>
	</li>
	<li class="outside">
		<div class="date">4</div>
	</li>
	<li class="outside">
		<div class="date">5</div>
	</li>
	<li class="outside">
		<div class="date">6</div>
	</li>
	<li class="outside">
		<div class="date">7</div>
	</li>
<?php } ?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/calendar.css">
<link rel="stylesheet" href="assets/css/calendar_table.css">

<div class="container-fluid mar-t-90px bg--purple text-center">
	<div class="container py-5">
		<div class="calendar--topic"> วาระงานผู้บริหาร </div>
	</div>
</div>

<section id="article-sec bg--white">
	<div class="container-fluid">
		<div class="form-group row mb-0">
			<div class="col-12 bg-calendar-table bg-calendar-transparent">
				<div id="carouselcalendar" class="carousel slide" data-bs-interval="false">
					<ol class="carousel-indicators position-list-carousel-ceo">
						<?php foreach ($calendar_manager as $key => $value) { ?>
							<li data-target="#carouselcalendar" data-slide-to="<?php echo $key; ?>" class="<?php echo ($key == 0 ? "active" : ""); ?>">
								<img src="<?php echo HOST_NAME; ?>assets/images/calendar/<?php echo $value['m_images']; ?>" title="<?php echo $value['m_pos']; ?>" alt="<?php echo $value['m_pos']; ?>" class="position-pic-list-ceo pic-list<?php echo $key + 1 ?>">
							</li>
						<?php } ?>
					</ol>
					<div class="carousel-inner">
						<!-- Open ceo1 -->
						<div class="carousel-item mt-5 active">
							<div class="calendar table-responsive">
								<div class="p-5">
									<div class="align-items-center text-white text-center mb-3">
										<!--<h2 class="month font-weight-bold mb-0 text-uppercase"> JANUARY 2022</h2>-->
										<div class="w-100 text-center my-4">
											<a class="txt-between-arrow-calendar"> มกราคม 2022 </a>
										</div>
									</div>
									<ol class="day-names list-unstyled">
										<li class="font-weight-bold text-uppercase bg-date-weekend">อาทิตย์</li>
										<li class="font-weight-bold text-uppercase bg-date-work">จันทร์</li>
										<li class="font-weight-bold text-uppercase bg-date-work">อังคาร</li>
										<li class="font-weight-bold text-uppercase bg-date-work">พุธ</li>
										<li class="font-weight-bold text-uppercase bg-date-work">พฤหัส</li>
										<li class="font-weight-bold text-uppercase bg-date-work">ศุกร์</li>
										<li class="font-weight-bold text-uppercase bg-date-weekend">เสาร์</li>
									</ol>

									<ol class="days list-unstyled list">
										<li class="list-item">
											<div class="dateweekend">1</div>
										</li>
										<li class="list-item">
											<div class="date">2</div>
											<div class="event">
												<div class="">
													<a href="#" data-toggle="modal" data-target="#calendardetial" class="txt-white">
														ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
													</a>
												</div>
												<div class="border-t-calendar">
													รับเสด็จทูลกระหม่อมหญิงอุบลรัตนราชกัญญา สิริวัฒนาพรรณวดี เนื่องในโอกาสมาบันทึกเทปรายการ ทู บี นัมเบอร์ วัน วาไรตี้ เวลา 18.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">3</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">4</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">5</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">6</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">7</div>
											<div class="event">
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">8</div>
										</li>
										<li class="list-item">
											<div class="date">9</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">10</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">11</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">12</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">13</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">14</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">15</div>

										</li>
										<li class="list-item">
											<div class="date">16</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">17</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">18</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">19</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">20</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">21</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">22</div>
										</li>
										<li class="list-item">
											<div class="date">23</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item list-item-today">
											<div class="date">24</div>
											<div class="event">
												<div class="pb-2">
													<a href="#" data-toggle="modal" data-target="#calendardetial" class="txt-dark">
														ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
													</a>
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">25</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">26</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">27</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">28</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">29</div>
										</li>
										<li class="list-item">
											<div class="date">30</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">31</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="outside">
											<div class="date">1</div>
										</li>
										<li class="outside">
											<div class="date">2</div>
										</li>
										<li class="outside">
											<div class="date">3</div>
										</li>
										<li class="outside">
											<div class="date">4</div>
										</li>
									</ol>
								</div>
							</div>
						</div>
						<!-- Close ceo1 -->

						<!-- Open ceo2 -->
						<div class="carousel-item mt-5">
							<div class="calendar">
								<div class="p-5">
									<div class="align-items-center text-white text-center mb-3">
										<div class="w-100 text-center my-4">
											<a class="txt-between-arrow-calendar"> มกราคม 2022 </a>
										</div>
									</div>
									<ol class="day-names list-unstyled">
										<li class="font-weight-bold text-uppercase bg-date-weekend">อาทิตย์</li>
										<li class="font-weight-bold text-uppercase bg-date-work">จันทร์</li>
										<li class="font-weight-bold text-uppercase bg-date-work">อังคาร</li>
										<li class="font-weight-bold text-uppercase bg-date-work">พุธ</li>
										<li class="font-weight-bold text-uppercase bg-date-work">พฤหัส</li>
										<li class="font-weight-bold text-uppercase bg-date-work">ศุกร์</li>
										<li class="font-weight-bold text-uppercase bg-date-weekend">เสาร์</li>
									</ol>

									<ol class="days list-unstyled list">
										<li class="list-item">
											<div class="dateweekend">1</div>
										</li>
										<li class="list-item">
											<div class="date">2</div>
											<div class="event">
												<div class="">
													<a href="#" data-toggle="modal" data-target="#calendardetial" class="txt-white">
														ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
													</a>
												</div>
												<div class="border-t-calendar">
													รับเสด็จทูลกระหม่อมหญิงอุบลรัตนราชกัญญา สิริวัฒนาพรรณวดี เนื่องในโอกาสมาบันทึกเทปรายการ ทู บี นัมเบอร์ วัน วาไรตี้ เวลา 18.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">3</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">4</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">5</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">6</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">7</div>
											<div class="event">
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">8</div>
										</li>
										<li class="list-item">
											<div class="date">9</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">10</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">11</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">12</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">13</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">14</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">15</div>

										</li>
										<li class="list-item">
											<div class="date">16</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">17</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">18</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">19</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">20</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">21</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">22</div>
										</li>
										<li class="list-item">
											<div class="date">23</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item list-item-today">
											<div class="date">24</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">25</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">26</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">27</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">28</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">29</div>
										</li>
										<li class="list-item">
											<div class="date">30</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">31</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="outside">
											<div class="date">1</div>
										</li>
										<li class="outside">
											<div class="date">2</div>
										</li>
										<li class="outside">
											<div class="date">3</div>
										</li>
										<li class="outside">
											<div class="date">4</div>
										</li>
									</ol>
								</div>
							</div>
						</div>
						<!-- Close ceo 2 -->

						<!-- Open ceo 3 -->
						<div class="carousel-item mt-5">
							<div class="calendar">
								<div class="p-5">
									<div class="align-items-center text-white text-center mb-3">
										<div class="w-100 text-center my-4">
											<a class="txt-between-arrow-calendar"> มกราคม 2022 </a>
										</div>
									</div>
									<ol class="day-names list-unstyled">
										<li class="font-weight-bold text-uppercase bg-date-weekend">อาทิตย์</li>
										<li class="font-weight-bold text-uppercase bg-date-work">จันทร์</li>
										<li class="font-weight-bold text-uppercase bg-date-work">อังคาร</li>
										<li class="font-weight-bold text-uppercase bg-date-work">พุธ</li>
										<li class="font-weight-bold text-uppercase bg-date-work">พฤหัส</li>
										<li class="font-weight-bold text-uppercase bg-date-work">ศุกร์</li>
										<li class="font-weight-bold text-uppercase bg-date-weekend">เสาร์</li>
									</ol>

									<ol class="days list-unstyled list">
										<li class="list-item">
											<div class="dateweekend">1</div>
										</li>
										<li class="list-item">
											<div class="date">2</div>
											<div class="event">
												<div class="">
													<a href="#" data-toggle="modal" data-target="#calendardetial" class="txt-white">
														ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
													</a>
												</div>
												<div class="border-t-calendar">
													รับเสด็จทูลกระหม่อมหญิงอุบลรัตนราชกัญญา สิริวัฒนาพรรณวดี เนื่องในโอกาสมาบันทึกเทปรายการ ทู บี นัมเบอร์ วัน วาไรตี้ เวลา 18.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">3</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">4</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">5</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">6</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">7</div>
											<div class="event">
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">8</div>
										</li>
										<li class="list-item">
											<div class="date">9</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">10</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">11</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">12</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">13</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">14</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">15</div>

										</li>
										<li class="list-item">
											<div class="date">16</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">17</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">18</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">19</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">20</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">21</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">22</div>
										</li>
										<li class="list-item">
											<div class="date">23</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item list-item-today">
											<div class="date">24</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">25</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">26</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">27</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">28</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">29</div>
										</li>
										<li class="list-item">
											<div class="date">30</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">31</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="outside">
											<div class="date">1</div>
										</li>
										<li class="outside">
											<div class="date">2</div>
										</li>
										<li class="outside">
											<div class="date">3</div>
										</li>
										<li class="outside">
											<div class="date">4</div>
										</li>
									</ol>
								</div>
							</div>
						</div>
						<!-- Close ceo 3 -->

						<!-- Open ceo 4 -->
						<div class="carousel-item mt-5">
							<div class="calendar">
								<div class="p-5">
									<div class="align-items-center text-white text-center mb-3">
										<div class="w-100 text-center my-4">
											<a class="txt-between-arrow-calendar"> มกราคม 2022 </a>
										</div>
									</div>
									<ol class="day-names list-unstyled">
										<li class="font-weight-bold text-uppercase bg-date-weekend">อาทิตย์</li>
										<li class="font-weight-bold text-uppercase bg-date-work">จันทร์</li>
										<li class="font-weight-bold text-uppercase bg-date-work">อังคาร</li>
										<li class="font-weight-bold text-uppercase bg-date-work">พุธ</li>
										<li class="font-weight-bold text-uppercase bg-date-work">พฤหัส</li>
										<li class="font-weight-bold text-uppercase bg-date-work">ศุกร์</li>
										<li class="font-weight-bold text-uppercase bg-date-weekend">เสาร์</li>
									</ol>

									<ol class="days list-unstyled list">
										<li class="list-item">
											<div class="dateweekend">1</div>
										</li>
										<li class="list-item">
											<div class="date">2</div>
											<div class="event">
												<div class="">
													<a href="#" data-toggle="modal" data-target="#calendardetial" class="txt-white">
														ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
													</a>
												</div>
												<div class="border-t-calendar">
													รับเสด็จทูลกระหม่อมหญิงอุบลรัตนราชกัญญา สิริวัฒนาพรรณวดี เนื่องในโอกาสมาบันทึกเทปรายการ ทู บี นัมเบอร์ วัน วาไรตี้ เวลา 18.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">3</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">4</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">5</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">6</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">7</div>
											<div class="event">
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">8</div>
										</li>
										<li class="list-item">
											<div class="date">9</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">10</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">11</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">12</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">13</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">14</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">15</div>

										</li>
										<li class="list-item">
											<div class="date">16</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">17</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">18</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">19</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">20</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">21</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">22</div>
										</li>
										<li class="list-item">
											<div class="date">23</div>
											<div class="event">
												<div class="pb-2">
													ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
												</div>
											</div>
										</li>
										<li class="list-item list-item-today">
											<div class="date">24</div>
											<div class="event">
												<div class="pb-2">
													<a href="#" data-toggle="modal" data-target="#calendardetial" class="txt-dark">
														ประชุมคณะกรรมการประชาสัมพันธ์แห่งชาติ (กปช.) ครั้งที่ 2/2565 เวลา 13.30 น.
													</a>
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">25</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">26</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">27</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">28</div>
										</li>
										<li class="list-item">
											<div class="dateweekend">29</div>
										</li>
										<li class="list-item">
											<div class="date">30</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="list-item">
											<div class="date">31</div>
											<div class="event">
												<div class="pb-2">
													ประชุม ครม. <br>
													เวลา 08.30 น.
												</div>
											</div>
										</li>
										<li class="outside">
											<div class="date">1</div>
										</li>
										<li class="outside">
											<div class="date">2</div>
										</li>
										<li class="outside">
											<div class="date">3</div>
										</li>
										<li class="outside">
											<div class="date">4</div>
										</li>
									</ol>
								</div>
							</div>
						</div>
						<!-- Close ceo 4 -->
					</div>

					<!--
					<button class="carousel-control-prev" type="button" data-target="#carouselcalendar" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-target="#carouselcalendar" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</button>
					-->
				</div>

			</div>
			<!-- Close leftside -->
		</div>
	</div>
</section>


<div class="modal fade" id="calendardetial" tabindex="-1" role="dialog" aria-labelledby="calendardetial" style="padding-right: 17px;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-th" id="calendardetial"> ปฏิทินกิจกรรม </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row">

					<div class="col-12 mb-2">
						<div class="h-ac"> วันที่ 28-30 มกราคม 2565 เดินทางไปราชการ จ.อุดรธานี บึงกาฬ และ ขอนแก่น </div>
						<div class="calendar--subcate1 width-fitcontent mt-3">
							<img src="assets/img/icon/group_calendar.svg" class="dis-inline icon-w-detail">
							การประชุม
						</div>
					</div>

					<div class="form-check col-lg-12 col-md-12 col-sm-12 mb-3">
						<!--
				<img src="img/slide-1.jpg" class="img-fluid" title="picture activity" alt="picture activity">
				-->
						<p class="mt-3">
							13.30 น. ลงทะเบียน <br>
							14.00 น. แนะนำกำหนดการเบื้องต้นและเกริ่นหัวข้อหลักๆของวันนี้ <br>
							14.30 น. รับประทานอาหารว่าง <br>
							14.40 น. เข้าสู่หัวข้อการพัฒนาความก้าวหน้าทางการสื่อสารระดับประเทศกับทางกรมประชาสัมพันธ์ <br>
							16.00 น. ปิดการประชุมระดับประเทศ <br>
						</p>
						<p>
							*หมายเหตุ ควรลงทะเบียนที่หน้างานก่อนเข้างานก่อนเวลา 12.45 น. เพื่อให้เตรียมพร้อมก่อนประชุม ดูรายละเอียดเพิ่มเติมได้ที่
						</p>
						<p></p>
					</div>

					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<th scope="row" class="w-detial-modal-1"> วันที่จัดกิจกรรม : </th>
									<td class="w-detial-modal-2"> 13 ม.ค. 2563 - 13 ม.ค. 2563 </td>
								</tr>
								<tr>
									<th scope="row"> เวลาจัดกิจกรรม : </th>
									<td> 13:00 - 16:00 </td>
								</tr>
								<tr>
									<th scope="row"> สถานที่จัดกิจกรรม : </th>
									<td> จ.อุดรธานี บึงกาฬ และ ขอนแก่น </td>
								</tr>
								<tr>
									<th scope="row"> รายละเอียดผู้จัดงาน : </th>
									<td>
										นายสุทธิสาร ประกอบผล <br>
										เบอร์ : 0899123456 <br>
										เมล์ : mail@mail.com
									</td>
								</tr>
								<tr>
									<th scope="row"> ไฟล์ประกอบ : </th>
									<td>
										<div class="">
											<a href="#"> <em class="fa fa-download"></em> detial-1.pdf </a>
										</div>
										<div class="">
											<a href="#"> <em class="fa fa-download"></em> detial-2.pdf </a>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>


				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success border-ra-30px" data-dismiss="modal" onclick="window.location.href='calendar_view.php'"> <i class="fas fa-list-ul"></i> ดูรายละเอียดเพิ่มเติม </button>
				<button type="button" class="btn btn-danger border-ra-30px" data-dismiss="modal"> <i class="fas fa-times"></i> ปิดหน้าต่าง </button>
			</div>
		</div>
	</div>
</div>


<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>