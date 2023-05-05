<?php
include("../EWT_ADMIN/comtop.php");
?>  
<link rel="stylesheet" href="../js/pick-a-color/build/1.2.3/css/pick-a-color-1.2.3.min.css">
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");


$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";


$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * FROM cal_register_visit ORDER BY reg_id DESC");

$statement = "SELECT count(reg_id) AS b
			  FROM cal_register_visit ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);


##===================================================================================================##
$reg_type_short = array("1"=>"สทอภ.สำนักงานใหญ่",
                        "2"=>"สทอภ.อำเภอศรีราชา");
$reg_type       = array("1"=>"จองเข้าเยี่ยมชมกิจการและดูงานของ สทอภ. สำนักงานใหญ่ ศูนย์ราชการฯ ถนนแจ้งวัฒนะ กรุงเทพมหานคร",
                        "2"=>"จองเข้าเยี่ยมชมกิจการและดูงานของ สทอภ. อำเภอศรีราชา จังหวัดชลบุรี");
$reg_approve    = array("Y"=>'<font color="green">อนุมัติ</font>',"N"=>'<font color="red">ไม่อนุมัติ</font>');
$reg_permission = array("Yes"=>'<font color="green">อนุญาต</font>',"No"=>'<font color="red">ไม่อนุญาต</font>');

##===================================================================================================##
$topic_array = array();
$topic_data  = $db->query("SELECT reg_id,topic_id FROM cal_register_visit_topic ORDER BY topic_id");
while($topic_info = $db->db_fetch_array($topic_data)){
	if(!is_array($topic_array[$topic_info["reg_id"]])){
		$topic_array[$topic_info["reg_id"]] = array();
	}
	array_push($topic_array[$topic_info["reg_id"]],$topic_info["topic_id"]);
}

$topicname_array = array();
$topic_data  = $db->query("SELECT topic_id,topic_name FROM cal_register_topic ORDER BY topic_id");
while($topic_info = $db->db_fetch_array($topic_data)){
	$topicname_array[$topic_info["topic_id"]]=$topic_info["topic_name"];
}

$time_array = array();

$time_data = $db->query("SELECT * FROM cal_register_time ORDER BY time_start, time_end");
while($time_info = $db->db_fetch_array($time_data)){
	$time_array[$time_info["time_id"]] = $time_info["time_start"]." - ".$time_info["time_end"];
}	
##===================================================================================================##
?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4>หัวข้อการเข้าเยี่ยมชม</h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

<!---<button type="button" class="btn btn-info  btn-ml"  onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?php echo $cal_cid;?>');"  title="<?php echo $txt_calendar_add_cate;?>"  target="_self">
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_calendar_add_cate;?>
</button>-->

<?php /*<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_calendar.php?cal_cid=<?php echo $cal_cid;?>');"  title="<?php echo $txt_calendar_add;?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_calendar_add;?>
</button> */ ?>


<!--<button type="button" class="btn btn-info  btn-ml "  target="_self" onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_calendar.php');"  title="<?php echo $txt_calendar_search;?>" >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_calendar_search;?>
</button>-->

</div>

<?php /*
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
	<div class="btn-group ">
		<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
		<ul class="dropdown-menu dropdown-menu-right">
			<li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?php echo $cal_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_calendar_add_cate;?></a></li>
			<li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_calendar.php?cal_cid=<?php echo $cal_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_calendar_add;?></a></li>
			<li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search_banner.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_calendar_search;?></a></li>
			<li><a href="banner_group.php" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?></a></li>
		</ul>
	</div>
</div>	*/ ?>

</div>
</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<div class="card ">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
</div>
</div>
<div class="card-body">
<div class="panel-group" id="accordion">

	<div class="panel panel-default ">
		<div class="panel-heading ewt-bg-success">
			<h4 class="panel-title">
				<a href="calendar_visit_topic_edit.php?register_type=1"> จองเข้าเยี่ยมชมกิจการและดูงานของ สทอภ. สำนักงานใหญ่ ศูนย์ราชการฯ ถนนแจ้งวัฒนะ กรุงเทพมหานคร</a>
			</h4>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading ewt-bg-success">
			<h4 class="panel-title">
				<a href="calendar_visit_topic_edit.php?register_type=2"> จองเข้าเยี่ยมชมกิจการและดูงานของ สทอภ. อำเภอศรีราชา จังหวัดชลบุรี</a>
			</h4>
		</div>
	</div>


</div>

</div>

<?php echo pagination_ewt($statement,$perpage,$page,$url='?');?>
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
include("../EWT_ADMIN/combottom.php");
?>
<script src="../js/mask-input-jquery/docs/jquery.samask-masker.js"></script>
<script src="../js/pick-a-color/build/dependencies/tinycolor-0.9.15.min.js"></script>
<script src="../js/pick-a-color/build/1.2.3/js/pick-a-color-1.2.3.min.js"></script>	                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
<!--
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
-->
</style>
<script>
 $(function() {
        $.samaskHtml();
        $('.phone').samask("(000)000-0000");
        $('.hour').samask("00:00:00");
        $('.date').samask("00/00/0000");
        $('.date_hour').samask("00/00/0000 00:00:00");
        $('.ip_address').samask("000.000.000.000");
        $('.percent').samask("%00");
        $('.mixed').samask("SSS-000");
		$('.number').samask("000");
      });
function calendar_visit_delete(id){
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-exclamation-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_calendar_visit.php',
											data:{'reg_id': id,'proc':'del_calendar_visit'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'url:text.html',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: 'ตกลง',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}
function JQDelete_Calendar(id){
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_delete_calendar.php',
											data:{'id': id,'proc':'DelCal'},
											success: function (data) {
												$.alert({
													title: '',
													theme: 'modern',
													content: 'ลบข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}

function txt_data(w,g) {	
	$.ajax({
      type: 'GET',
      url: 'pop_set_lang_cal_event.php?gid='+g+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}
		
    }); 
	
$('#box_popup').fadeIn();		
}

function txt_data1(w,g,lang) {
	$.ajax({
      type: 'GET',
      url: 'pop_cal_event_multilang.php?langid='+g+'&lang='+lang+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}
		
    }); 
	
$('#box_popup').fadeIn();	
	 //window.location.href='../multilangMgt/article_group.php?langid='+g+'&lang='+lang+'&id='+ w;
}
</script>