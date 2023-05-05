<?php
include("../EWT_ADMIN/comtop.php");

if($_POST["proc"]=="remove_request"){

	if($_POST["request_id"]){
		$sql_delrequest = "DELETE FROM w_question_sts_request WHERE request_id='$_POST[request_id]'";
		$db->query($sql_delrequest);
		
		$db->write_log("delete","webboard","ลบการแจ้งลบกระทู้ ");
		?>
			<script>
				location.href = "webboard_del_noti.php";
			</script>
	
		<?php	
	}
}
else if($_POST["proc"]=="approve_comment"){ 
	
	if($_POST["a_id"]){
		$sql_approve = "UPDATE w_answer SET s_id='1' WHERE a_id='$_POST[a_id]'";
		$db->query($sql_approve);
		
		$db->write_log("approve","webboard","อนุมัติความคิดเห็น");
	}
	
	?>
		<script>
			location.href = "webboard_del_noti.php";
		</script>
	

	<?php	
	
	exit();

}
else if($_POST["proc"]=="disapprove_comment"){

	if($_POST["a_id"]){
		$sql_approve = "UPDATE w_answer SET s_id='0' WHERE a_id='$_POST[a_id]'";
		$db->query($sql_approve);
		
		$db->write_log("disapprove","webboard","ยกเลิกอนุมัติความคิดเห็น");
	}
	
	?>
		<script>
			location.href = "webboard_del_noti.php";
		</script>
	<?php	
	
	exit();

}
else if($_POST["proc"]=="approve_question"){

	if($_POST["t_id"]){
		$sql_approve = "UPDATE w_question SET s_id='1' WHERE t_id='$_POST[t_id]'";
		$db->query($sql_approve);
		$db->write_log("approve","webboard","อนุมัติกระทู้ ");
	}
	
	?>
		<script>
			location.href = "webboard_del_noti.php";
		</script>
	<?php	
	
	exit();

}
else if($_POST["proc"]=="disapprove_question"){

	if($_POST["t_id"]){
		$sql_approve = "UPDATE w_question SET s_id='0' WHERE t_id='$_POST[t_id]'";
		$db->query($sql_approve);
		$db->write_log("disapprove","webboard","ยกเลิกการอนุมัติกระทู้ ");
	}
	
	?>
		<script>
			location.href = "webboard_del_noti.php";
		</script>
	<?php	
	
	exit();

}

else if($_POST["proc"]=="delete_comment"){

	if($_POST["a_id"]){
		$sql_del = "DELETE FROM w_answer WHERE a_id='$_POST[a_id]'";
		$db->query($sql_del);
		
		$db->write_log("delete","webboard","ลบความคิดเห็นกระทู้");
	}
	
	?>
		<script>
			location.href = "webboard_del_noti.php";
		</script>

	<?php	
	
	exit();
}

else if($_POST["proc"]=="delete_question"){
	
	$question_sql = $db->query("SELECT *
					FROM w_question
					LEFT JOIN w_cate ON w_question.c_id=w_cate.c_id
					WHERE t_id='$_POST[t_id]'");

	$question_info = $db->db_fetch_array($question_sql);


	if($_POST["t_id"]){
		$sql_del = "DELETE FROM w_question WHERE t_id='$_POST[t_id]'";
		$db->query($sql_del);

		$db->write_log("delete","webboard","ลบกระทู้ ".$question_info["t_name"]);
	}

	?>
		<script>
			location.href = "webboard_del_noti.php";
		</script>

	<?php	
	
	exit();
		
}

?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
include("lib/webboard_function.php");

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);

if($page <= 0){ $page = 1;}

$start = ($page * $perpage) - $perpage;

if($page=='topic') {
	$wh.="AND wr.request_type='T' ";
} else if($page=='comment') {
	$wh.="AND wr.request_type='A' ";
}
if (!empty($data)) {
	$wh = "AND (wq.t_name LIKE '%$data%' OR wq.t_detail LIKE '%$data%')";
}

$_sql = $db->query("SELECT * 
                    FROM w_question_sts_request wr 
					LEFT JOIN  w_question wq ON wr.t_id=wq.t_id 
					WHERE (approve_sts=0 OR approve_sts=1) {$wh}
					ORDER BY request_createdate DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(request_id) AS b
			  FROM w_question_sts_request
			  WHERE (approve_sts=0 OR approve_sts=1) {$wh} "; 
			  
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
<h4><?php echo $txt_webboard_delete_notify_section;?></h4>
<p></p> 
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li class=""><?php echo $txt_webboard_delete_notify_section;?></li>
</ol>
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
	$i = (($page-1)*$perpage)+1;
	while($a_data = $db->db_fetch_array($_sql))
	{
	$rq_type =$a_data['request_type'];
?>			
			<div class="panel panel-default ">	
			<div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					<img src="<?php echo $IMG_PATH ;?>images/grabme.svg"> 
					<div class="blockico color_ewt"><i class="fas fa-exclamation-triangle" style="color:#FFBE7D;"></i></div>  
					<?php echo $a_data['t_name'];?>  (<?php if($a_data['request_type']=="T"){ ?> กระทู้<?php } ?><?php if($a_data['request_type']=="A"){ ?> ความคิดเห็น<?php } ?> )
					</a>					
                </h4>
			</div>	
			<div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="float-right text-right" style="background-color: #FFC153;padding: 10px;color:white;"> 
						<table border="0" width="100%">
						<tr>
						<td align="left">คำขอแจ้งลบที่ <?php echo $i; ?></td>
						</tr>
						</table>
					</div>
					<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
                   	ประเภท&nbsp;:</b> <?php if($a_data['request_type']=="T"){ ?> กระทู้<?php } ?><?php if($a_data['request_type']=="A"){ ?> ความคิดเห็น<?php } ?>
					</div>
					<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
					หัวข้อกระทู้&nbsp;:</b> <?php echo $a_data['t_name'];?> (<a class="attachment_link" target="_blank" href="webboard_main_question.php?t_id=<?php echo $a_data['t_id'];?>">คลิกเพื่อตรวจสอบกระทู้</a>)
					</div>
					<?php if($a_data['request_type']=="A"){ ?>
					<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
                   	ความคิดเห็น&nbsp;:</b> <?php echo  comment_detail($a_data['a_id']); ?>
					</div>	
					<?php } ?>
					<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
                   	สถานะการแสดงผล &nbsp;:</b>
						<?php if($a_data['t_name'] == ""){ ?>
							<?php if($a_data['request_type']=="T"){ ?> <span style="color:red;">ไม่พบกระทู้ดังกล่าว</span><?php } ?>
							<?php if($a_data['request_type']=="A"){ ?> <?php comment_status_text($a_data['a_id']); ?><?php } ?>
						<?php }else{ ?>
							<?php if($a_data['request_type']=="T"){ ?> <?php question_status_text($a_data['t_id']); ?><?php } ?>
							<?php if($a_data['request_type']=="A"){ ?> <?php comment_status_text($a_data['a_id']); ?><?php } ?>
						<?php } ?>
					</div>	
					<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>                  	
					เหตุผล &nbsp;:</b> <?php echo strip_tags($a_data['request_reason']);?>
					</div>
					<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>                  	
					วันที่ &nbsp;:</b> <?php echo datetimetool::format($a_data['request_createdate'],'d/m/Y H:i').' .น';?>
					</div>
					<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>                  	
					IP Address &nbsp;:</b> <?php echo $a_data['requestor_ip'];?>
					</div>	
					
					</div>
					<div class="panel-footer ewt-bg-white text-right" >
					<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
						<?php if($a_data['request_type']=="T"){ ?> 
								<?php if(question_status($a_data['t_id'])==0){ ?>
									<button value="<?php echo $a_data['t_id'];?>" type="button" class="approve_question btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_webboard_approve_question; ?>" >
											<i class="fas fa-times"></i>
									</button>
								<?php } else { ?>
									<button value="<?php echo $a_data['t_id'];?>" type="button" class="disapprove_question btn btn-success  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_webboard_disapprove_question; ?>" >
									<i class="fa fa-check"></i>
									</button>
								<?php } ?>

							<?php } ?>

							<?php if($a_data['request_type']=="A"){ ?> 

								<?php if(comment_status($a_data['a_id'])==0){ ?>
									<button value="<?php echo $a_data['a_id'];?>" type="button" class="approve_comment btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_webboard_approve_comment; ?>" >
											<i class="fas fa-times"></i>
									</button>
								<?php } else { ?>
									<button value="<?php echo $a_data['a_id'];?>" type="button" class="disapprove_comment btn btn-success  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_webboard_disapprove_comment; ?>" >
										<i class="fa fa-check"></i>
									</button>
								<?php } ?>

							<?php } ?>

							<?php if($a_data['request_type']=="T"){ ?> 
								<button 
									type="button" class="delete_question btn btn-danger  btn-circle  btn-sm " 
									data-toggle="tooltip" data-placement="top" 
									title="<?php echo $txt_webboard_delete_question; ?>" value="<?php echo $a_data['t_id'];?>">
									<i class="far fa-trash-alt " aria-hidden="true"></i>
								</button>
							<?php } ?>

							<?php if($a_data['request_type']=="A"){ ?> 
								<button value="<?php echo $a_data['a_id'];?>" type="button" class="delete_comment btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_webboard_delete_comment; ?>" >
									<i class="far fa-trash-alt" aria-hidden="true"></i>
								</button>
							<?php } ?>


							<button 
								type="button" class="delete_request btn btn-warning  btn-circle  btn-sm " 
								data-toggle="tooltip" data-placement="top" 
								title="<?php echo $txt_webboard_delete_notify_text; ?>" value="<?php echo $a_data['request_id'];?>">
								<i class="fas fa-ban"></i>
							</button>

			</div>
			</div>				
		</div>
		</div>
		<?php 
		$i++;
		} 
			}
			else
			{
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
	
<?php echo pagination_ewt($statement,$perpage,$page,$url='webboard_del_noti.php?');?>	 
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

<span id="manage_info">
</span>

<script>

	$(".delete_comment").click(function(){

		var a_id = this.value;
		$.alert({
					title: 'Warning',
					content: '<?php echo $txt_webboard_delete_comment_ask; ?>',
					icon: 'fas fa-exclamation-circle',
					theme: 'modern',                          
					type: 'orange',
					closeIcon: false,						
					buttons: {
						confirm: {
							text: 'ตกลง',
							btnClass: 'btn-green',
							action: function () {
								$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="proc" value="delete_comment"></form>');
								$("#manage_comment").submit();															
							}															
						},	
						close: {
							text: 'ยกเลิก',
							btnClass: 'btn-orange',
						}
					},
					onAction: function () {	
							//$('#loader').fadeOut();	 									
					},
					boxWidth: '30%',  
					useBootstrap: false,
					closeIcon: true, 
					closeIconClass: 'far fa-times-circle',	
					});
					
		//if(confirm("<?php echo $txt_webboard_delete_comment_ask; ?>")){
			//$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="proc" value="delete_comment"></form>');
			//$("#manage_comment").submit();
		//}
	});

	$(".approve_comment").click(function(){
		//var comment = $("#comment_desc").val();
		var a_id = this.value;
		$.alert({
					title: 'Warning',
					content: '<?php echo $txt_webboard_approve_comment_ask; ?>',
					icon: 'fas fa-exclamation-circle',
					theme: 'modern',                          
					type: 'orange',
					closeIcon: false,						
					buttons: {
						confirm: {
							text: 'ตกลง',
							btnClass: 'btn-green',
							action: function () {
								$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="proc" value="approve_comment"></form>');
								$("#manage_comment").submit(); 	  								
							}															
						},	
						close: {
							text: 'ยกเลิก',
							btnClass: 'btn-orange',
						}
					},
					onAction: function () {	
							//$('#loader').fadeOut();	 									
					},
					boxWidth: '30%',  
					useBootstrap: false,
					closeIcon: true, 
					closeIconClass: 'far fa-times-circle',	
					});
		//if(confirm("<?php echo $txt_webboard_approve_comment_ask; ?>")){
			//$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="proc" value="approve_comment"></form>');
			//$("#manage_comment").submit();
		//}
	});

	$(".disapprove_comment").click(function(){
		//var comment = $("#comment_desc").val();
		var a_id = this.value;
				$.alert({
					title: 'Warning',
					content: '<?php echo $txt_webboard_disapprove_comment_ask; ?>',
					icon: 'fas fa-exclamation-circle',
					theme: 'modern',                          
					type: 'orange',
					closeIcon: false,						
					buttons: {
						confirm: {
							text: 'ตกลง',
							btnClass: 'btn-green',
							action: function () {
								$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="proc" value="disapprove_comment"></form>');
								$("#manage_comment").submit();	 									
							}															
						},	
						close: {
							text: 'ยกเลิก',
							btnClass: 'btn-orange',
						}
					},
					onAction: function () {	
							//$('#loader').fadeOut();	 									
					},
					boxWidth: '30%',  
					useBootstrap: false,
					closeIcon: true, 
					closeIconClass: 'far fa-times-circle',	
					});
		//if(confirm("<?php echo $txt_webboard_disapprove_comment_ask; ?>")){
			//$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="proc" value="disapprove_comment"></form>');
			//$("#manage_comment").submit();
		//}
	});

	$(".delete_question").click(function(){
		var t_id = this.value;
		$.alert({
					title: 'Warning',
					content: '<?php echo $txt_webboard_delete_question_ask; ?>',
					icon: 'fas fa-exclamation-circle',
					theme: 'modern',                          
					type: 'orange',
					closeIcon: false,						
					buttons: {
						confirm: {
							text: 'ตกลง',
							btnClass: 'btn-green',
							action: function () {
								$("#manage_info").html('<form method="post" id="manage_form"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="delete_question"></form>');			
								$("#manage_form").submit();		 													
							}															
						},	
						close: {
							text: 'ยกเลิก',
							btnClass: 'btn-orange',
						}
					},
					onAction: function () {	
							//$('#loader').fadeOut();	 									
					},
					boxWidth: '30%',  
					useBootstrap: false,
					closeIcon: true, 
					closeIconClass: 'far fa-times-circle',	
					});
		//if(confirm("<?php echo $txt_webboard_delete_question_ask; ?>")){
			//$("#manage_info").html('<form method="post" id="manage_form"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="delete_question"></form>');			
			//$("#manage_form").submit();
		//}
	});

	$(".approve_question").click(function(){
		//var comment = $("#comment_desc").val();
		var t_id = this.value;
			$.alert({
					title: 'Warning',
					content: '<?php echo $txt_webboard_approve_question_ask; ?>',
					icon: 'fas fa-exclamation-circle',
					theme: 'modern',                          
					type: 'orange',
					closeIcon: false,						
					buttons: {
						confirm: {
							text: 'ตกลง',
							btnClass: 'btn-green',
							action: function () {
								$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="approve_question"></form>');
								$("#manage_question").submit();											
							}															
						},	
						close: {
							text: 'ยกเลิก',
							btnClass: 'btn-orange',
						}
					},
					onAction: function () {	
							//$('#loader').fadeOut();	 									
					},
					boxWidth: '30%',  
					useBootstrap: false,
					closeIcon: true, 
					closeIconClass: 'far fa-times-circle',	
					});
		//if(confirm("<?php echo $txt_webboard_approve_question_ask; ?>")){
			//$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="approve_question"></form>');
			//$("#manage_question").submit();
		//}
	});

	$(".disapprove_question").click(function(){
		//var comment = $("#comment_desc").val();
		var t_id = this.value;
			$.alert({
					title: 'Warning',
					content: '<?php echo $txt_webboard_disapprove_question_ask; ?>',
					icon: 'fas fa-exclamation-circle',
					theme: 'modern',                          
					type: 'orange',
					closeIcon: false,						
					buttons: {
						confirm: {
							text: 'ตกลง',
							btnClass: 'btn-green',
							action: function () {
								$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="disapprove_question"></form>');
								$("#manage_question").submit(); 												
							}															
						},	
						close: {
							text: 'ยกเลิก',
							btnClass: 'btn-orange',
						}
					},
					onAction: function () {	
							//$('#loader').fadeOut();	 									
					},
					boxWidth: '30%',  
					useBootstrap: false,
					closeIcon: true, 
					closeIconClass: 'far fa-times-circle',	
					});
		//if(confirm("<?php echo $txt_webboard_disapprove_question_ask; ?>")){
			//$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="disapprove_question"></form>');
			//$("#manage_question").submit();
		//}
	});

	

	$(".delete_request").click(function(){
		//var comment = $("#comment_desc").val();
		var request_id = this.value;
		$.alert({
					title: 'Warning',
					content: '<?php echo $txt_webboard_delete_notify_ask; ?>',
					icon: 'fas fa-exclamation-circle',
					theme: 'modern',                          
					type: 'orange',
					closeIcon: false,						
					buttons: {
						confirm: {
							text: 'ตกลง',
							btnClass: 'btn-green',
							action: function () {
								$("#manage_info").html('<form method="post" id="manage_request"><input type="hidden" name="request_id" value="'+request_id+'"><input type="hidden" name="proc" value="remove_request"></form>');
								$("#manage_request").submit(); 													
							}															
						},	
						close: {
							text: 'ยกเลิก',
							btnClass: 'btn-orange',
						}
					},
					onAction: function () {	
							//$('#loader').fadeOut();	 									
					},
					boxWidth: '30%',  
					useBootstrap: false,
					closeIcon: true, 
					closeIconClass: 'far fa-times-circle',	
					});
					
		//if(confirm("<?php echo $txt_webboard_delete_notify_ask; ?>")){
			//$("#manage_info").html('<form method="post" id="manage_request"><input type="hidden" name="request_id" value="'+request_id+'"><input type="hidden" name="proc" value="remove_request"></form>');
			//$("#manage_request").submit(); 
		//}
	});


</script>