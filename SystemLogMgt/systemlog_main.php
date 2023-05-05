<?php
include("../EWT_ADMIN/comtop.php");
$sso = new sso();
?>  
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
$wh1 = '';
if(!empty($_GET['startdate']) && !empty($_GET['enddate'])){
	$st = explode("/",$_GET['startdate']);
	$startdate = $st[2]."-".$st[1]."-".$st[0];
	
	$et = explode("/",$_GET['enddate']);
	$enddate = $et[2]."-".$et[1]."-".$et[0];
	
	$wh1 .= " (log_date  BETWEEN '".$startdate."' AND '".$enddate."'  )";
	
}
if(!empty($_GET['module_code'])){
	if($_GET['module_code'] == 'art'){		
		$_GET['module_code'] = 'article';
		}
	
	$wh1 .= " AND (log_module_detail  = '".$_GET['module_code']."' )";
	
}
if(!empty($_GET['user_id'])){
	
	$wh1 .= " AND (log_mid  = '".$_GET['user_id']."' ) ";
}

//echo $wh1;
if(!empty($wh1)){
	
	$wh = "WHERE ".$wh1;
}

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;
//echo "SELECT * FROM log_user {$wh} ORDER BY  log_date DESC,log_time DESC LIMIT {$start} , {$perpage} ";
$_sql = $db->query("SELECT * FROM log_user {$wh} ORDER BY  log_date DESC,log_time DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(log_id) AS b
			  FROM log_user
			  {$wh} {$sql_search}";
			  
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

<h4><?=$txt_systemlog_menu_main;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="systemlog_main.php"><?=$txt_systemlog_menu_main;?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<button type="button" class="btn btn-info  btn-sm"  onClick="boxPopup('<?=linkboxPopup();?>pop_search_systemlog.php');"  title="<?=$txt_complain_add_cate;?>"  target="_self">
<i class="fas fa-search"></i>&nbsp;<?=$txt_systemlog_search;?> 
</button>
<a target="_blank" onclick ="submitForm()" >
								<button type="button" class="btn btn-info  btn-ml ">
									<i class="fas fa-file-excel"></i>&nbsp;<?php echo "Excel"; ?>
								</button>
</a>
</div>


<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right"></ul>
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

<div class="card ">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
</div>
</div>
<div class="card-body">
<div class="panel-group" id="accordion">
<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($_sql)){
$s_data = $sso->getUser($a_data['log_user'])["data"];
$fullname = $s_data["USR_FNAME"] . ' ' . $s_data["USR_LNAME"];
?>
<div class="panel panel-default ">
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?=$i;?>">
					<i class="fas fa-chalkboard-teacher color-ewt"></i>
					<?=$fullname. " :: ".$a_data['log_detail'];?>
					</a>					
                </h4>
            </div>
		
            <div id="collapseOne<?=$i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                   	<div><b><?="วันที่";?> :</b> <?=date("d/m/Y",strtotime($a_data['log_date']));?>
                   		<?=date("H:i",strtotime($a_data['log_time']));?> น.
					</div><br>
					<div><b><?="Username";?> :</b> <?=$a_data['log_user'];?></div><br> 
					<div><b><?="IP";?> :</b> <?=$a_data['log_ip'];?></div><br> 
					<div><b><?="Module";?> :</b> <?=$a_data['log_module_detail'];?></div><br> 
                </div>
				<div class="panel-footer ewt-bg-white text-right">

				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">


<!--<button type="button" class="btn btn-default  btn-circle  btn-sm " onClick="JQDelete_Complain(<?=$a_data['id']?>);" data-toggle="tooltip" data-placement="top" title="<?=$txt_complain_delete;?>" >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>

<button type="button" class="btn btn-default  btn-circle  btn-sm " onClick="boxPopup('<?=linkboxPopup();?>pop_add_complain_comment.php?com_id=<?=$a_data['id']?>');" data-toggle="tooltip" data-placement="top" title="<?=$txt_complain_comment;?>" >
<i class="far fa-comment-dots" aria-hidden="true"></i>
</button>
					
<a onClick="JQSet_Lang_Calendar('<?//=$a_data['event_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?//=$txt_ewt_create_multilang;?>">
<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?//=$a_data['event_id'];?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>-->

				</div>
				</div>
            </div>
        </div>
		<Form action="systemlog_report_excel_export.php?startdate=<?php echo $_GET["startdate"]; ?>&enddate=<?php echo $_GET["enddate"];?>&user_id=<?php echo $ban_cid;?>&module_code=<?php echo $_GET['module_code'];?>" method="POST" name="form1">
												<?php
												echo '<input type="hidden" name="username[]" value="'. $a_data['log_user']. '">';
												echo '<input type="hidden" name="fullname[]" value="'. $fullname. '">';
												echo '<input type="hidden" name="detail[]" value="'. $a_data['log_detail']. '">';
												echo '<input type="hidden" name="IP[]" value="'. $a_data['log_ip']. '">';
												echo '<input type="hidden" name="datetime[]" value="'. date("H:i",strtotime($a_data['log_time'])). '">';
												echo '<input type="hidden" name="dateday[]" value="'. date("d/m/Y",strtotime($a_data['log_date'])). '">';
												echo '<input type="hidden" name="module[]" value="'. $a_data['log_module_detail']. '">';
												?>
		<?php $i++; ?>
<?php $i++;} }else{?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?=$txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php } ?>			
</div>
</div>
</div>
<?=pagination_ewt($statement,$perpage,$page,$url='?user_id='.$_GET['user_id'].'&module_code='.$_GET['module_code'].'&startdate='.$_GET['startdate'].'&enddate='.$_GET['enddate'].'&');?>
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
                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
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
function submitForm() {
	document.form1.submit();
}
function JQDelete_ComGroup(id){
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
											url: 'func_delete_complain_group.php',
											data:{'id': id,'proc':'DelComGroup'},
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
	
}

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

</script>