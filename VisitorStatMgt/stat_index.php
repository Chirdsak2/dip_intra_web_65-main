<?php
include("../EWT_ADMIN/comtop.php");
include('../assets/configs/function.inc.php');
?>
<script src="../chart/zingchart_2.3.2/zingchart.min.js"></script>
<script>
	zingchart.MODULESDIR = '../chart/zingchart_2.3.2/modules/'
	ZC.LICENSE = ["24fa905934561fc198cc36fb29177d4a"];
</script>
<style>
	.zc-style.zc-license {
		display: none
	}
</style>
<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	?>
	<div id="frm_edit_s" class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<div class="card">
				<div class="card-header">

					<div class="row m-b-sm hidden-xs">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<ol class="breadcrumb">
								<li><a href="index.php">VisitorStat Dashboard</a></li>
								<li class=""></li>
							</ol>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right">
							<a target="_self" onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_search.php');">
								<button type="button" class="btn btn-info  btn-ml ">
									<i class="fas fa-search"></i>&nbsp;<?php echo "Search"; ?>
								</button>
							</a>

							<a target="_blank" href="visitor_report_excel_export.php?startdate=<?php echo $_GET["startdate"]; ?>&enddate=<?php echo $_GET["enddate"];?>&proc=<?php echo $_GET["proc"]; ?>">
								<button type="button" class="btn btn-info  btn-ml ">
									<i class="fas fa-file-excel"></i>&nbsp;<?php echo "Excel"; ?>
								</button>
							</a>

							<!-- <a target="_blank" href="visitor_report_pdf_export.php?startdate=<?php echo $_GET["startdate"]; ?>&enddate=<?php echo $_GET["enddate"];?>&proc=<?php echo $_GET["proc"]; ?>">
								<button type="button" class="btn btn-info  btn-ml ">
									<i class="fas fa-file-pdf"></i>&nbsp;<?php echo "PDF"; ?>
								</button>
							</a> -->
						</div>
					</div>
					<div class="row m-b-sm text-right visible-xs">
						<div class="btn-group">
							<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">action <span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-right">
								<li><a href="#<?php echo "Search"; ?>" onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_search.php');"><i class="fas fa-search"></i>&nbsp;<?php echo "Search"; ?></a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="card-body">
					<?php
					$date = new DateTime();
					$clone = clone $date;
					$clone2 = clone $date;
					if (!empty($_GET['proc'])) {
						if ($_GET['proc'] == 'TO') {
							$con = " AND (sv_date = '" . $date->format('Y-m-d') . "') ";
						} else if ($_GET['proc'] == 'YE') {
							$clone->modify('-1 day');
							$con = " AND (sv_date = '" . $clone->format('Y-m-d') . "') ";
						} else if ($_GET['proc'] == 'L7') {
							$clone->modify('-7 day');
							//$con = " AND (sv_date = '".$clone->format('Y-m-d')."') ";
							$con = " AND (sv_date BETWEEN '" . $clone->format('Y-m-d') . "' AND '" . $date->format('Y-m-d') . "')";
						} else if ($_GET['proc'] == 'L3') {
							$clone->modify('-30 day');
							//$con = " AND (sv_date = '".$clone->format('Y-m-d')."') ";
							$con = " AND (sv_date BETWEEN '" . $clone->format('Y-m-d') . "' AND '" . $date->format('Y-m-d') . "')";
						} else if ($_GET['proc'] == 'TM') {
							$clone->modify('-30 day');
							//echo  $con = " AND (sv_date = '".$clone->format('Y-m-d')."') ";
							$con = " AND (sv_date BETWEEN '" . $clone->format('Y-m-d') . "' AND '" . $date->format('Y-m-d') . "')";
						} else if ($_GET['proc'] == 'LM') {
							$clone->modify('-1 month');
							$clone2->modify('-2 month');
							//$con = " AND (sv_date = '".$clone->format('Y-m-d')."') ";
							$con = " AND (sv_date BETWEEN '" . $clone2->format('Y-m-d') . "' AND '" . $clone->format('Y-m-d') . "')";
						} else if ($_GET['proc'] == 'CU') {
							$s = explode("/", $_GET['startdate']);
							$n = explode("/", $_GET['enddate']);
							$con = " AND (sv_date BETWEEN '" . $s[2] . "-" . $s[1] . "-" . $s[0] . "' AND '" . $n[2] . "-" . $n[1] . "-" . $n[0] . "')";
						}
					} else {
						$con = " AND (sv_date = '" . $date->format('Y-m-d') . "') ";
					}
					?>
					<div class="row p-xs">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="card">
								<div class="card-header ewt-bg-success ">

									<div class="card-title text-left ">
										<div class="title"><i class="far fa-calendar-alt"></i> <span class="date-today-th text-large"></span></div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="row p-xs">
						<?php include('stat_sessions.php'); ?>
					</div>

					<?php if ($_GET['proc'] == 'TO' or $_GET['proc'] == '') { ?>
						<div class="row p-xs">
							<?php include('stat_online.php'); ?>
							<?php include('stat_platforms.php'); ?>
						</div>
					<?php } ?>

					<div class="row p-xs">
						<?php //include('stat_timestamp.php'); 
						?>
						<?php include('stat_url.php'); ?>
						<?php include('stat_ipaddress.php'); ?>
					</div>

					<div class="row p-xs">
						<?php include('stat_os.php'); ?>
						<?php include('stat_browser.php'); ?>
					</div>


					<div class="row p-xs">
						<?php include('stat_resolution.php'); ?>
						<?php include('stat_language.php'); ?>
					</div>

					<div class="row p-xs">
						<?php //include('stat_isp.php'); 
						?>
						<?php //include('stat_ipaddress.php'); 
						?>
					</div>


					<!--<div class="row m-b-sm">
<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-success" >
<h4>UIP ภายในประเทศ</h4>
</div>
<div class="card-body">
<div><?php //include('stat_uipin.php') 
		?></div>
</div>
</div>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-success" >
<h4>UIP ต่างประเทศ</h4>
</div>
<div class="card-body">
<div><?php //include('stat_uipex.php') 
		?></div>
</div>
</div>
</div>
</div>-->


					<!--<div class="row p-xs">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-success" >
<div class="card-title text-left">
<div class="title" >ผู้เข้าชมเว็บไซต์จากที่ไหน (Locations)</div>
</div>

</div>

<div class="card-body">
<div class="contact-right wow fadeInRight">
<div id="map" style="width:100%;height:500px;"></div>
</div>
</div>
</div>
</div>
</div>-->


					<!--<div class="row p-xs">
<div class="col-md-4 col-sm-12 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
<div class="title" >Search engine</div>
<div class="title" ><i class="fas fa-hashtag"></i> Top 5</div>
</div>
</div>
<div class="card-body">

</div>
</div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
<div class="title" >คำค้น</div>
<div class="title" ><i class="fas fa-hashtag"></i> Top 5</div>
</div>
</div>
<div class="card-body">

</div>
</div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
<div class="title" >Referer</div>
<div class="title" ><i class="fas fa-hashtag"></i> Top 5</div>
</div>
</div>
<div class="card-body">

</div>
</div>
</div>
</div>--->


				</div>
			</div>
		</div>
	</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script>
	$(document).ready(function() {

		var today = new Date();
		$('.datepicker')
			.datepicker({
				format: 'dd/mm/yyyy',
				language: 'th-th',
				thaiyear: true,
				leftArrow: '<i class="fas fa-angle-double-left"></i>',
				rightArrow: '<i class="fas fa-angle-double-right"></i>',
			})
			.datepicker("setDate", "0");
		//.datepicker("setDate", today.toLocaleDateString());  	
	});

	function getRefresh() {
		$("#chartonline").load("chart_online.php", '', callback);
	}

	function callback() {
		window.setTimeout("getRefresh();", 18000);
	}

	function getRefreshSes() {
		$("#sessiononline").load("session_online.php", '', callbackSes);
	}

	function callbackSes() {
		window.setTimeout("getRefreshSes();", 1000);
	}

	function getRefreshSesSO() {
		$("#so_").load("so_session.php", '', callbackSesSO);
	}

	function callbackSesSO() {
		window.setTimeout("getRefreshSesSO();", 1000);
	}
	$(document).ready(getRefresh);
	$(document).ready(getRefreshSes);
	$(document).ready(getRefreshSesSO);

	/*$(document).ready(function () {
	var url = 'chart_online.php';  
	  
	//$('#div-online').load(url); 

	setTimeout(function(){										
	  $("#chartonline").load(url);
		}, 1000);
		
	});*/
</script>