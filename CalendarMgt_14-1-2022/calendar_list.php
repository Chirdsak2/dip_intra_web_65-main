<?php
include("../EWT_ADMIN/comtop.php");
$sso = new sso();
?>   
<link rel="stylesheet" href="../js/pick-a-color/build/1.2.3/css/pick-a-color-1.2.3.min.css">
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);



function banner_category($ban_cid){
	 global $db,$EWT_DB_NAME;
	 $s_category = $db->query("SELECT * FROM banner_group WHERE banner_gid = '{$ban_cid}' ");	
	 if($db->db_num_rows($s_category)){
		$a_category = $db->db_fetch_array($s_category);											
		$a_data = $a_category['banner_name'];
			
	 	}		
		return $a_data;
}

$s_banner_g = $db->query("SELECT * FROM banner_group  WHERE  banner_gid = '{$ban_cid}' ");
$a_banner_g = $db->db_fetch_array($s_banner_g);

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";


$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

// $_sql = $db->query("SELECT 
// 					cal_event.*,
// 					cal_show_event.event_date_start,
// 					cal_show_event.event_date_end,
// 					cal_category.cat_name,
// 					cal_category.cat_color 
// 					FROM cal_event 
// 					INNER JOIN cal_show_event ON (cal_event.event_id = cal_show_event.event_id) 
// 					INNER JOIN cal_category ON (cal_category.cat_id = cal_event.cat_id)
// 					{$wh} 
// 					ORDER BY cal_show_event.event_date_start DESC, cal_event.event_id DESC LIMIT {$start} , {$perpage} "); 
$_sql = $db->query("SELECT * FROM cal_event {$wh} ORDER BY event_date_start DESC, event_id DESC LIMIT {$start} , {$perpage}");
$statement = "SELECT count(event_id) AS b FROM cal_event {$wh} ";	  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);

?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo $txt_calendar_list;?></h4> 
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="calendar_list.php"><?php echo $txt_calendar_list;?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

<!---<button type="button" class="btn btn-info  btn-ml"  onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?php echo $cal_cid;?>');"  title="<?php echo $txt_calendar_add_cate;?>"  target="_self">
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_calendar_add_cate;?>
</button>-->

<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_calendar.php?cal_cid=<?php echo $cal_cid;?>');"  title="<?php echo $txt_calendar_add;?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_calendar_add;?>
</button>


<!--<button type="button" class="btn btn-info  btn-ml "  target="_self" onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_calendar.php');"  title="<?php echo $txt_calendar_search;?>" >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_calendar_search;?>
</button>-->

</div>

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
</div>	
</div>
</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<div class="panel-group" id="accordion">
<?php   
if($a_rows > 0)
{
	$i = 0;
	while($a_data = $db->db_fetch_array($_sql))
	{
?>	
<div class="panel panel-default ">
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
				<img src="<?php echo $IMG_PATH ;?>images/grabme.svg">  
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">				
					<div class="blockico"><i class="far fa-calendar-alt color-ewt"></i></div>
					<?php echo $a_data['event_title'];?>
					</a>					
                </h4>
            </div>
		
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body"> 
                   	<div class="m-b"><b><i class="fas fa-angle-right color-ewt"></i> </b><?php echo $a_data['event_detail'];?></div> 
					<div class="m-b"><b><i class="fas fa-angle-right color-ewt"></i>&nbsp;<i class="far fa-clock"></i></b>&nbsp;&nbsp;  
					<?php echo datetimetool::format($a_data['event_date_start'],'d/m/Y');?> <?php echo datetimetool::format($a_data['event_time_start'],'H:i');?> น.&nbsp;&nbsp;ถึง&nbsp;&nbsp;<?php echo  datetimetool::format($a_data['event_date_end'],'d/m/Y');?> <?php echo datetimetool::format($a_data['event_time_end'],'H:i');?>  น.</div> 
					<div class="m-b"><b><i class="fas fa-angle-right color-ewt"></i>&nbsp;<i class="fas fa-paperclip"></i></b>&nbsp;&nbsp; 
					<?php if($a_data['event_link']){ ?>Document | [ <a href="<?php echo $a_data['event_link'];?>" download> Download</a> ] </li>  
					<?php }else{ echo '-'; }  ?>
					</div>
					<!--<div><i class="far fa-address-book"></i>&nbsp;&nbsp; </div> --> 
					<div class="m-b"><b><i class="fas fa-angle-right color-ewt"></i>&nbsp;<i class="fas fa-map-marker-alt"></i></b>&nbsp;&nbsp;
					<?php echo $a_data['event_location'];?></div> 
					<div class="m-b"><b><i class="fas fa-angle-right color-ewt"></i>&nbsp;<i class="fas fa-user-cog"></i></b>
					<?php
					if($a_data['event_user_id'] > 0){
						//ข้อมูล User SSO
						$_sql_u = $db->query("SELECT gen_user FROM ewt_user_prd_intra_web.gen_user WHERE gen_user_id = {$a_data['event_user_id']}");
						$u_data = $db->db_fetch_array($_sql_u);
						$s_data = $sso->getUser($u_data['gen_user'])["data"];
						$fullname = $s_data["USR_FNAME"] . ' ' . $s_data["USR_LNAME"];
						echo $fullname;
					}else{
						echo $a_data['event_webname'];
					}
					
					?></div> 
<div><br><h4><span class="label label-primary "><?php echo $txt_ewt_multilang; ?></span></h4>
<?php if(show_icon_lang($a_data['event_id'],'cal_event')) { ?>
<button  type="button" class="btn btn-default  btn-ml " <?php echo $disabled;?> data-toggle="tooltip" data-placement="top" title="<?php echo $a_data['lang_config_name'];?>" ><?php echo show_icon_lang($a_data['event_id'],'cal_event');?></button>
<?php } ?>
</div>
                </div>
				<div class="panel-footer ewt-bg-white text-right">

				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
<!-- <a onClick="txt_data('<?php echo $a_data['event_id']?>','')" >
<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $a_data['event_id']?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang;?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a> -->

<a onClick="JQDelete_Calendar(<?php echo $a_data['event_id']?>);" >  
<button type="button" class="btn btn-danger btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_calendar_delete;?>"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>
<?php
if($a_data['event_registor'] == 'Y'){ 
?>
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_view_registor.php?event_id=<?php echo $a_data['event_id'];?>');" >					
<button type="button" class="btn btn-success btn-circle btn-sm "  data-toggle="tooltip" data-placement="top" title="<?php echo "ดูรายชื่อผู้สมัคร";?>" >
<i class="fa fa-th-list" aria-hidden="true"></i>
</button>
</a>
<?php } ?>
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_calendar.php?event_id=<?php echo $a_data['event_id'];?>');" >					
<button type="button" class="btn btn-warning  btn-circle btn-sm "  data-toggle="tooltip" data-placement="top" title="<?php echo $txt_calendar_edit;?>" >
<i class="far fa-edit" aria-hidden="true"></i>
</button>
</a>
					
<!--<a onClick="JQSet_Lang_Calendar('<?//=$a_data['event_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?//=$txt_ewt_create_multilang;?>">
<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?//=$a_data['event_id'];?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>-->

				</div>
				</div>
            </div>
        </div>
<?php 
$i++;
}  
}else{
	?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p> 
                </h4>
            </div>
        </div>
<?php } ?> 		
		
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
        /*$.samaskHtml();
        $('.phone').samask("(000)000-0000");
        $('.hour').samask("00:00:00");
        $('.date').samask("00/00/0000");
        $('.date_hour').samask("00/00/0000 00:00:00");
        $('.ip_address').samask("000.000.000.000");
        $('.percent').samask("%00");
        $('.mixed').samask("SSS-000");
		$('.number').samask("000");*/
      });
function JQDelete(id){
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
											type: 'GET',
											url: 'func_delete_vdo.php',
											data:{'id': id,'proc':'DelVdo'},
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