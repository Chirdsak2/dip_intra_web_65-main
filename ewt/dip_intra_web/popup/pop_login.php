<?php 
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

?>
<form id="form_main" name="form_main" method="POST" action="" enctype="multipart/form-data" >

	<div class="container">   
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<div class="head-sec">
						<h2 id="shw_head">สำรวจความคิดเห็น</h2>
					</div>
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
				</div>
				<div class="modal-body" id="shw_poll_result">
					
					<div class="form-group row" >
						<label for="chkpic" class="col-sm-12 control-label"><b>กรอกตัวเลขตามภาพที่ปรากฎ <span class="text-danger"><code>*</code></span> : </b></label>
						<div class="col-md-3 col-sm-3 col-xs-3 text-center" style="padding-top:5px;" >
							<span id="recapt" ></span>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2" >
							<span class="btn btn-warning text-white" onclick="Func_ReCaptcha();"><i class="fas fa-sync"></i></span>	
						</div>
						<div class="col-md-7 col-sm-7 col-xs-7" >
							<input class="form-control chkcaptcha" type="text" name="chkpic" id="chkpic" required="required" autocomplete="off" />
						</div>
					</div>
					
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" onclick="$('#box_popup').fadeOut();" >
					<i class="far fa-times-circle"></i>&nbsp;<?php echo "ปิด";?></button>
					
					<div id="hide_btn">
						<button onclick="JQAdd_Poll($('#form_main'));" type="button" class="btn btn-success btn-ml">
							<i class="far fa-paper-plane"></i>&nbsp;<?php echo "โหวต";?>
						</button>&nbsp;&nbsp;
						
						<button onclick="view_poll('<?php echo $c_id;?>','<?php echo $no;?>');" type="button" class="btn btn-danger btn-ml" >
							<i class="fas fa-search" aria-hidden="true"></i>&nbsp;<?php echo "ดูผลโหวต";?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>	 
</form>
