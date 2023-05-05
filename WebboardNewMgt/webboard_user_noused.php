<?php
include("../EWT_ADMIN/comtop.php");
$db->write_log("view","webboard","เข้าสู่ Module Webboard กำหนดชื่อห้ามใช้ ");
//============
//  Removing
//============

?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
include("lib/webboard_function.php");

?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?=$txt_webboard_menu_main;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?=$txt_webboard_menu_main;?></li>
<!-- <li class=""><?=$txt_webboard_menu_user;?></li>        -->
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
	<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">
			<i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span>
		</button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
				<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?=$cal_cid;?>');" >
					<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_calendar_add_cate;?>
				</a>
			</li>
			
			<li>
				<a href="banner_group.php" target="_self" >
					<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
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

<div class="card ">
	<div class="card-header ewt-bg-color m-b-sm" >
		<div class="card-title text-left color-white">
			<p><h4>สถิติการเข้าเว็บบอร์ดจำนวนผู้อ่าน</h4></p>
		</div>
	</div>
	<div class="card-body">

	<div class="panel-group" id="accordion">
		
		<div class="panel panel-default ">

			<div class="panel-heading ewt-bg-success">

				<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
					<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?=linkboxPopup();?>pop_add_name.php?');" title="<?=$txt_poll_add;?>"  target="_self">
						<i class="fas fa-plus-circle"></i>&nbsp;<?="เพิ่มรายชื่อ";?>
					</button>
				</div>
			</div>
		
			<div class="">
				<div class="panel-body">
					
					<table width="80%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
					<tr class="ewttablehead">
						<td width="10%" align="center" class="MemberHead">&nbsp;</td>
						<td width="10%" align="center" class="MemberHead">&nbsp;</td>
						<td class="MemberHead" align="center"><b>ชื่อ</a></td>
					</tr>

					<?php
					$i=1;
					$sql="select * from w_name";
					$query = $db->query($sql);
					$num = mysql_num_rows($query);
					while($rec = $db->db_fetch_array($query)){
					
					?>
					<tr>
						<td align="left" bgcolor="#FFFFFF" style="padding-top: 10px; padding-bottom: 10px; padding-left: 5px; padding-right: 5px;">
							<button type="button" class="btn btn-default btn-sm" onClick="boxPopup('<?=linkboxPopup();?>pop_edit_name.php?w_id=<?= $rec[w_name_id];?>');" title="<?=$txt_poll_add;?>"  target="_self">
								<img src="../images/content_edit.gif" alt="แก้ไข" width="16" height="16" border="0">&nbsp;<?="แก้ไขรายชื่อ";?>
							</button>
						</td>
						
						<td bgcolor="#FFFFFF" style="padding-top: 10px; padding-bottom: 10px; padding-left: 5px; padding-right: 5px;">
							<button type="button" class="delete_name btn btn-default btn-sm" title="<?=$txt_poll_add;?>"  target="_self" value="<?= $rec[w_name_id];?>">
								<img src="../images/b_delete.gif" alt="ลบ" width="16" height="16" border="0">&nbsp;<?="ลบรายชื่อ";?>
							</button>
						</td>

						<td bgcolor="#FFFFFF" style="padding-top: 10px; padding-bottom: 10px; padding-left: 5px; padding-right: 5px;">
							<?php echo $rec[w_name];?>
						</td>
					</tr>
					<?php $i++; } 
					if($num==0){
					?>
					<tr>
						<td colspan="2" align="center" bgcolor="#FFFFFF" class="MemberNormalRed">-----ไม่พบรายการ-----</td>
					</tr>
					<tr>
						<?php } ?>
						<td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
					</tr>
					</table>
				</div>
			</div>
			
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
include("../EWT_ADMIN/combottom.php");
?>
                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
/* <!-- */
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
/* --> */
</style>

<script>

	$(".delete_name").click(function(){

		var a_id = this.value;
		//alert(a_id);
		/*
		if(confirm("<?php echo $txt_webboard_delete_comment_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="t_id" value="<?=$question_info[t_id];?>"><input type="hidden" name="proc" value="delete_comment"></form>');
			$("#manage_comment").submit();
		}
		*/

		$.confirm({
			title: '<?='';?>',
			content: 'คุณต้องการลบชื่อนี้หรือไม่',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'far fa-question-circle',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยันการลบ',
					btnClass: 'btn-blue',
					action: function () {
						$.ajax({  
						url:"func_delete_name.php",  
						method:"post",  
						data:{w_name_id : a_id,
							proc: "Delete_Name"
						},  
							
						success:function(data){						
						}  
						});
						location.reload(true);

					}								
			
				},
				cancel: {
					text: 'ยกเลิก',
					action: function () {
					//$('#box_popup').fadeOut(); 	
					}									
				}
			},                          
			animation: 'scale',
			type: 'blue'
				
		});
	});

</script>