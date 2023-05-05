<?php
include("../EWT_ADMIN/comtop.php");

if($_POST["proc"]=="remove_request"){

	if($_POST["request_id"]){
		$sql_delrequest = "DELETE FROM w_question_sts_request WHERE request_id='$_POST[request_id]'";
		$db->query($sql_delrequest);
		
		$db->write_log("delete","webboard question sts request","ลบการแจ้งลบกระทู้ ");
		?>
			<script>
				location.href = "webboard_delete_notify.php";
			</script>
	
		<?php	
	}
}
else if($_POST[proc]=="approve_comment"){
	
	if($_POST[a_id]){
		$sql_approve = "UPDATE w_answer SET s_id='1' WHERE a_id='$_POST[a_id]'";
		$db->query($sql_approve);
		
		$db->write_log("approve","approve comment","อนุมัติความคิดเห็น");
	}
	
	?>
		<script>
			location.href = "webboard_delete_notify.php";
		</script>
	

	<?php	
	
	exit();

}
else if($_POST[proc]=="disapprove_comment"){

	if($_POST[a_id]){
		$sql_approve = "UPDATE w_answer SET s_id='0' WHERE a_id='$_POST[a_id]'";
		$db->query($sql_approve);
		
		$db->write_log("disapprove","disapprove comment","ยกเลิกอนุมัติความคิดเห็น");
	}
	
	?>
		<script>
			location.href = "webboard_delete_notify.php";
		</script>
	<?php	
	
	exit();

}
else if($_POST[proc]=="approve_question"){

	if($_POST[t_id]){
		$sql_approve = "UPDATE w_question SET s_id='1' WHERE t_id='$_POST[t_id]'";
		$db->query($sql_approve);
		$db->write_log("approve","webboard question","อนุมัติกระทู้ ");
	}
	
	?>
		<script>
			location.href = "webboard_delete_notify.php";
		</script>
	<?php	
	
	exit();

}
else if($_POST[proc]=="disapprove_question"){

	if($_POST[t_id]){
		$sql_approve = "UPDATE w_question SET s_id='0' WHERE t_id='$_POST[t_id]'";
		$db->query($sql_approve);
		$db->write_log("disapprove","webboard question","ยกเลิกการอนุมัติกระทู้ ");
	}
	
	?>
		<script>
			location.href = "webboard_delete_notify.php";
		</script>
	<?php	
	
	exit();

}

else if($_POST[proc]=="delete_comment"){

	if($_POST[a_id]){
		$sql_del = "DELETE FROM w_answer WHERE a_id='$_POST[a_id]'";
		$db->query($sql_del);
		
		$db->write_log("delete","webboard comment","ลบความคิดเห็นกระทู้");
	}
	
	?>
		<script>
			location.href = "webboard_delete_notify.php";
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


	if($_POST[t_id]){
		$sql_del = "DELETE FROM w_question WHERE t_id='$_POST[t_id]'";
		$db->query($sql_del);

		$db->write_log("delete","webboard question","ลบกระทู้ ".$question_info[t_name]);
	}

	?>
		<script>
			location.href = "webboard_delete_notify.php";
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

$_sql = $db->query("SELECT * 
                    FROM emotion  
					{$wh}
					ORDER BY emotion_id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(emotion_id) AS b
			  FROM emotion
			  {$wh} ";
			  
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
<h4><?php echo 'Emotion';?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li class=""><?php echo 'Emotion';?></li>
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	
<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_webboard_emotion.php');">
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo 'เพิ่ม Emotion';?> 
</button>  
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
	<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">
		<i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span>
		</button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
			<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_webboard_emotion.php');" >
			<i class="fas fa-plus-circle"></i>&nbsp;<?php echo 'เพิ่ม Emotion';?> 
			</a>
			</li>
			
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
$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/";
$i = 0;
if($a_rows > 0)
{
	while($a_data = $db->db_fetch_array($_sql))
	{	
?>
        <div class="panel panel-default ">
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					<img src="<?php echo $dir_base.$a_data['emotion_img'];?>" class='img-thumbnail' style='width:60px;height:60px;'>  
					<img src="<?php echo $IMG_PATH ;?>images/grabme.svg"> 
					
					<?php echo $a_data['emotion_name'];?>
					</a>
					<span class="pull-right">
					<button type="button" class="btn btn-warning  btn-circle btn-sm"  data-toggle="tooltip" data-placement="top" title="<?php echo 'แก้ไข Emotion';?>" >
				<i class="fas fa-edit" aria-hidden="true"></i>
				</button>
				</a>		
				<a onClick="JQDel_Emotion('<?php echo $a_data['emotion_id'];?>');" > 
				<button type="button" class="btn btn-danger  btn-circle btn-sm"  data-toggle="tooltip" data-placement="top" title="<?php echo 'ลบ Emotion';?>" >
				<i class="fas fa-trash-alt " aria-hidden="true"></i>
				</button>
				</a>	
				&nbsp;&nbsp;</span>				
                </h4>
            </div>
		
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body"> 
                <div class="m-b"><b><i class="fas fa-angle-right color-ewt" style="color:#FFBE7D;"></i> โค้ด :</b> <?php echo $a_data['emotion_character'];?></div>    
				<div class="m-b"><b><i class="fas fa-angle-right color-ewt" style="color:#FFBE7D;" ></i>  คำอธิบาย :</b> <?php echo $a_data['emotion_name'];?></div>    	
             	<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>                  	
				สถานะการใช้งาน &nbsp;:</b> <?php echo  ($a_data['emotion_status']=='Y' ? 'ใช้งาน' : 'ไม่ใช้งาน');?>  
				</div>
				</div>
				<div class="panel-footer ewt-bg-white text-right">
				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
				<div class="text-right">    
				<!--<button onclick="boxPopup('<?php echo linkboxPopup();?>pop_view_emotion.php?emo_id=<?php //echo $a_data['emotion_id'];?>');" type="button" class="btn btn-info btn-circle  " data-toggle="tooltip" data-placement="top" title="<?php echo 'View';?>" >
				<i class="fas fa-search"></i>
				</button>-->   
				<!--<a href="rss_knowledge.php?rss_id=<?php //echo $a_data['rss_id'];?>" >  					
				<button type="button" class="btn btn-success btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="<?php //echo 'คลังข่าว';?>"   > 
				<i class="fa fa-th-list " aria-hidden="true"></i>
				</button>
				</a>-->
				<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_webboard_emotion.php?emo_id=<?php echo $a_data['emotion_id'];?>')" > 
				
				</div> 					
				<!--<a onClick="JQSet_Lang_Poll('<?php //echo $a_data['c_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?php //echo $txt_ewt_create_multilang;?>">
				<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?php //echo $a_data['m_id'];?>" >
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

<?php echo pagination_ewt($statement,$perpage,$page,$url='webboard_emotion.php?');?>	
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
.pull-right {float:right;}
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
function JQDel_Emotion(Id){ 

	$.confirm({
		title: 'ลบ emotion',
		content: 'คุณต้องการลบ emotion หรือไม่?', 
		boxWidth: '80%',
		icon: 'fas fa-exclamation-circle',
		theme: 'modern',
		buttons: {
			confirm: {
				text: 'ยืนยันการลบ',
				btnClass: 'btn-danger',
				action: function () {
					$.ajax({
						type: 'POST',
						url: "func_del_webboard_emotion.php",   	 				
						data: {id:Id,proc:"DelEmo"},
						success: function (data) { 
		
											$.alert({
													title: 'ลบ emotion เรียบร้อย', 
													theme: 'modern',
													icon: 'far fa-check-circle',
													content: 'Success! ',
													type: 'green',
													typeAnimated: true,
													boxWidth: '30%',	
													buttons: {
														ok: {
															btnClass: 'btn-green'
															}     
														},
													onAction: function () {
														//self.location.href="complain_builder.php?com_cid=6";	
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});		
							
						}
						
					});																										
				}											
			},
			cancel: {
				text: 'ยกเลิก'													
			}
		},                          
		animation: 'scale',
		type: 'red'						
		});		
}



	$(".delete_comment").click(function(){

		var a_id = this.value;

		if(confirm("<?php echo $txt_webboard_delete_comment_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="proc" value="delete_comment"></form>');
			$("#manage_comment").submit();
		}
	});

	$(".approve_comment").click(function(){
		//var comment = $("#comment_desc").val();
		var a_id = this.value;
		if(confirm("<?php echo $txt_webboard_approve_comment_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="proc" value="approve_comment"></form>');
			$("#manage_comment").submit();
		}
	});

	$(".disapprove_comment").click(function(){
		//var comment = $("#comment_desc").val();
		var a_id = this.value;
		if(confirm("<?php echo $txt_webboard_disapprove_comment_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="proc" value="disapprove_comment"></form>');
			$("#manage_comment").submit();
		}
	});

	$(".delete_question").click(function(){
		var t_id = this.value;
		if(confirm("<?php echo $txt_webboard_delete_question_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_form"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="delete_question"></form>');			
			$("#manage_form").submit();
		}
	});

	$(".approve_question").click(function(){
		//var comment = $("#comment_desc").val();
		var t_id = this.value;
		if(confirm("<?php echo $txt_webboard_approve_question_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="approve_question"></form>');
			$("#manage_question").submit();
		}
	});

	$(".disapprove_question").click(function(){
		//var comment = $("#comment_desc").val();
		var t_id = this.value;
		if(confirm("<?php echo $txt_webboard_disapprove_question_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="disapprove_question"></form>');
			$("#manage_question").submit();
		}
	});

	

	$(".delete_request").click(function(){
		//var comment = $("#comment_desc").val();
		var request_id = this.value;
		if(confirm("<?php echo $txt_webboard_delete_notify_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_request"><input type="hidden" name="request_id" value="'+request_id+'"><input type="hidden" name="proc" value="remove_request"></form>');
			$("#manage_request").submit();
		}
	});


</script>