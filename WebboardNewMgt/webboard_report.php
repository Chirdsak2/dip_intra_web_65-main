<?php
include("../EWT_ADMIN/comtop.php");
$date = date("m");
$sql_a = $db->query("SELECT count(*) as num from w_answer where MONTH(a_date) = '{$date}'");
$rec_a = $db->db_fetch_array($sql_a);

$sql_q = $db->query("SELECT SUM(t_count) as num from w_question where MONTH(t_date) = '{$date}'");
$rec_q = $db->db_fetch_array($sql_q);

$sql_aq = $db->query("select count(*) as num from w_question,w_cate where 1=1 and w_question.c_id =w_cate.c_id AND MONTH(w_question.t_date) = '{$date}'");
$rec_aq = $db->db_fetch_array($sql_aq);
?>  
<!-- START CONTAINER  -->
<div class="container-fluid"  >
<?php
include("menu-top.php"); 
?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo 'รายงาน';?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?php echo 'รายงาน';?></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<div class="row">

<div class="col-md-4 col-sm-4 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3">
<div class="card-title color-white">
    รายงานสถิติการเข้าเว็บบอร์ดจำนวนผู้ตอบ
  </div>
</div>
<div class="card-body">
	<div class="card-title">
		ยอดรวมประจำเดือน <?php echo $rec_a['num']; ?> คน
	</div>
	<hr>
	<a class="btn btn-primary" href="webboard_report_user_stat_excel_export.php">Excel</a>
	<a class="btn btn-primary" href="webboard_report_user_stat_csv_export.php">CSV</a>
</div>
</div>
</div>

<div class="col-md-4 col-sm-4 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header  ewt-bg-color m-b-sm b-t-l-3 b-t-r-3">
<div class="card-title color-white">
รายงานสถิติการเข้าเว็บบอร์ดจำนวนผู้อ่าน
</div>
</div>
<div class="card-body" >
	<div class="card-title">
		ยอดรวมประจำเดือน <?php echo $rec_q['num']; ?> คน
	</div>
	<hr>
	<a class="btn btn-primary" href="webboard_report_reader_stat_excel_export.php">Excel</a>
	<a class="btn btn-primary" href="webboard_report_reader_stat_csv_export.php">CSV</a>
</div>
</div>
</div>

<div class="col-md-4 col-sm-4 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header  ewt-bg-color m-b-sm b-t-l-3 b-t-r-3">
<div class="card-title color-white">
รายงานการใช้งาน
</div>
</div>
<div class="card-body" >
	<div class="card-title">
		ยอดรวมประจำเดือน <?php echo $rec_aq['num']; ?> กระทู้
	</div>
	<hr>
	<a class="btn btn-primary" href="webboard_report_usage_excel_export.php">Excel</a>
	<a class="btn btn-primary" href="webboard_report_usage_csv_export.php">CSV</a>
</div>
</div>
</div>

</div> 

</div>
</div>

</div>
<!--END card-body-->
</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE ".$EWT_DB_NAME);
include("../EWT_ADMIN/combottom.php");
?>

                                                                                                                                                                                                       <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
</style>
     