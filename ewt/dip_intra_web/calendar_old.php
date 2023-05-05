<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php 
$mount = $_GET["mount"];
$year = $_GET["year"];
$calendar_manager = calendar::getManagerCalendar();
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/calendar.css">
<link rel="stylesheet" href="assets/css/calendar_table.css">
<style>
	.text_search {
		background-color: #011f5d;
		margin: 0px 10px;
		color: #FFF;
		padding: 6px 20px;
		font-size: 20px;
		border-radius: 30px;
	}

	.w-10 {
		width: 10% !important;
	}
</style>

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
								<img src="assets/images/calendar/<?php echo $value['m_images']; ?>" title="<?php echo $value['m_name'] . ' ' . $value['m_surname']; ?>" alt="<?php echo $value['m_name'] . ' ' . $value['m_surname']; ?>" class="position-pic-list-ceo pic-list<?php echo $key + 1 ?>">
							</li>
						<?php } ?>
					</ol>

					<div class="carousel-inner">
						<?php foreach ($calendar_manager as $keys => $value) { ?>
							<div class="carousel-item mt-5 <?php echo ($keys == 0 ? "active" : ""); ?>">
								<div class="calendar table-responsive">
									<div class="p-5">
										<div class="align-items-center text-white text-center mb-3">
											<!-- <div class="w-100 text-center my-4">
												<a class="txt-between-arrow-calendar"> <?php echo convDateThai(date('Y-m-d'))['DateThaiM']; ?> </a>
											</div> -->
											<select class="custom-select w-10 text-center my-4 text_search" name="month_search<?php echo $value['cat_id']; ?>" id="month_search<?php echo $value['cat_id']; ?>" onchange="search(<?php echo $value['cat_id']; ?>);">
												<?php for ($i = 1; $i <= 12; $i++) { ?>
													<?php $m = ($i < 10 ? "0".$i : $i); ?>
													<option value="<?php echo $m; ?>" <?php echo (date('m') === $m && $mount !== $m) ? "selected" : null; ?> <?php echo ($mount === $m && date('m') !== $m) ? "selected" : null; ?>><?php echo convDateThai(date('Y-' . $i . '-d'))['MT']; ?></option>
												<?php } ?>
											</select>

											<select class="custom-select w-10 text-center my-4 text_search" name="year_search<?php echo $value['cat_id']; ?>" id="year_search<?php echo $value['cat_id']; ?>" onchange="search(<?php echo $value['cat_id']; ?>);">
												<option value="<?php echo date('Y'); ?>" ><?php echo convDateThai(date('Y-m-d'))['YT']; ?></option>
												<?php for ($i = 1; $i <= 10; $i++) { ?>
													<option value="<?php echo date('Y') - $i; ?>" <?php echo date('Y') - $i == $year ? "selected" : null; ?>><?php echo convDateThai(date('Y-m-d') - $i)['YT']; ?></option>
												<?php } ?>
											</select>
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
											<?php foreach (calendar::getCalendarList($value["cat_id"], $mount, $year) as $week) {
												echo $week;
											} ?>
										</ol>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>
			<!-- Close leftside -->
		</div>
	</div>
</section>

<script>
	function search(cat_id){
        window.location.href = 'calendar.php?mount=' + $('#month_search' + cat_id).val() + '&year=' + $('#year_search' + cat_id).val();
	}
</script>
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>