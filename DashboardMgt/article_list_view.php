<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$tap = (int)(!isset($_GET['tap']) ? '' : $_GET['tap']);
$date = new DateTime();
$Y = $date->format('Y')+543; 
$MD = $date->format('-m-d');

function banner_category($ban_cid){
	 global $db,$EWT_DB_NAME;
	 $s_category = $db->query("SELECT * FROM banner_group WHERE banner_gid = '{$ban_cid}' ");	
	 if($db->db_num_rows($s_category)){
		$a_category = $db->db_fetch_array($s_category);											
		$a_data = $a_category['banner_name'];
			
	 	}		
		return $a_data;
}
function article_group($cid){
	global $db;
	$s_group = $db->query("SELECT * FROM article_group WHERE c_id = '{$cid}' ");
	 	if($db->db_num_rows($s_group)){
	 		$a_data = $db->db_fetch_array($s_group);
	
			$txt = $a_data['c_name'];
			
	return $txt;
	}
}
function article_owner($id){
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
	$db->query("USE ".$EWT_DB_USER);
	$s_user = $db->query("SELECT * FROM gen_user WHERE gen_user_id = '{$id}' ");
	 	if($db->db_num_rows($s_user)){
	 		$a_data = $db->db_fetch_array($s_user);
	
			$txt = $a_data['name_thai'];
	}else{
		$txt = 'Admin Web';
	}	
	$db->query("USE ".$EWT_DB_NAME);
	return $txt;
	
}

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

if($tap == '1'){
	
	$_sql = $db->query("SELECT * FROM article_list WHERE n_id != '' AND  n_approve = 'Y' AND n_date = '".$Y.$MD."'  ORDER BY  n_id  DESC LIMIT {$start} , {$perpage} ");
	$statement = "SELECT count(n_id) AS b
			  FROM article_list
			  WHERE n_id != '' AND  n_approve = 'Y' AND n_date = '".$Y.$MD."'
			  {$wh} ";
	$title = "ข่าวสาร/บทความใหม่รายวัน";
}else if($tap == '2'){
	
		$_sql = $db->query("SELECT * FROM article_list WHERE n_id != '' AND n_approve = '' ORDER BY  n_id  DESC LIMIT {$start} , {$perpage} ");
		$statement = "SELECT count(n_id) AS b
			  FROM article_list
			  WHERE n_id != '' AND n_approve = ''
			  {$wh} ";
	    $title = "ข่าวสาร/บทความที่รอการอนุมัติ";
	}
				
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

<!--start card-body -->
<div class="card-body">
<div class="row ">

<div class="col-md-12 col-sm-12 col-xs-12 " >

<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" > 
<div class="card-title text-left color-white">
 <h4><i class="fas fa-hashtag"></i> <?php echo $title;?></h4>
</div>
</div>
<div class="card-body">
<div class="panel-group" id="accordion">
<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($_sql)){
?>
<div class="panel panel-default ">
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					<i class="far fa-newspaper"></i>
					<?php echo $a_data['n_topic'];?>
					</a>					
                </h4>
            </div>
			<div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                   	<div><b><?php echo "วันที่ข่าว/บทความ";?> :</b> <?php echo $a_data['n_date'];?></div><br> 
					<div><b><?php echo "ชื่อผู้สร้างข่าว";?> :</b> <?php echo article_owner($a_data['n_owner']);?></div><br> 
					<div><b><?php echo "หมวดข่าว/บทความ";?> :</b> <?php echo article_group($a_data['c_id']);?></div><br> 
 
                </div>
				<div class="panel-footer ewt-bg-white text-right">

				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">


<!--<button type="button" class="btn btn-default  btn-circle  btn-sm " onClick="JQDelete_Complain(<?php echo $a_data['id']?>);" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_complain_delete;?>" >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>

<button type="button" class="btn btn-default  btn-circle  btn-sm " onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_complain_comment.php?com_id=<?php echo $a_data['id']?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_complain_comment;?>" >
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
<?php $i++;} }else{?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php } ?>

</div>			
</div>
</div>

<?php echo pagination_ewt($statement,$perpage,$page,$url='?tap='.$tap.'&'); ?>
</div>
</div>	
</div>
</div>
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