<?php
$category_id = (int)(!isset($_GET['category_id']) ? 0 : $_GET['category_id']);
?>

<form id="form_main" name="form_main" method="POST" action="popup/func_album_cate_tell.php" enctype="multipart/form-data" >
	<input type="hidden" name="proc" id="proc"  value="album_cate_tell">
	<input type="hidden" name="category_id" id="category_id"  value="<?php echo $category_id ;?>">

	<div class="container" >   
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<div class="head-sec">
						<h2>Tell a friend</h2>
					</div>
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
				</div>
				<div class="modal-body">
					<div class="row calendar-row">
						<div class="col-sm-3"><span class="text-danger">* </span>ชื่อผู้ส่ง :</div>
						<div class="col-sm-9">
							<label for="name-sender" hidden>ชื่อผู้ส่ง</label>
							<input class="form-control font19px h-auto" type="text" id="name-sender" name="name-sender" required="" value="">
						</div>
					</div>

					<div class="row calendar-row">
						<div class="col-sm-3"><span class="text-danger">* </span>อีเมล์ผู้ส่ง :</div>
						<div class="col-sm-9">
							<label for="email-sender" hidden>อีเมล์ผู้ส่ง</label>
							<input class="form-control font19px h-auto checkmail" type="text" id="email-sender" name="email-sender" required="" value="">
						</div>
					</div>

					<div class="row calendar-row">
						<div class="col-sm-3"><span class="text-danger">* </span>รายละเอียด :</div>
						<div class="col-sm-9">
							<label for="detail-sender" hidden>รายละเอียด</label>
							<textarea class="form-control" id="detail-sender" name="detail-sender" rows="3" required=""></textarea>
						</div>
					</div>

					<div class="row calendar-row">
						<div class="col-sm-3"><span class="text-danger">* </span>ชื่อผู้รับ :</div>
						<div class="col-sm-9">
							<label for="name-recipient" hidden>ชื่อผู้รับ</label>
							<input class="form-control font19px h-auto" type="text" id="name-recipient" name="name-recipient" required="" value="">
						</div>
					</div>

					<div class="row calendar-row">
						<div class="col-sm-3"><span class="text-danger">* </span>อีเมล์ผู้รับ :</div>
						<div class="col-sm-9">
							<label for="email-recipient" hidden>อีเมล์ผู้รับ</label>
							<input class="form-control font19px h-auto checkmail" type="text" id="email-recipient" name="email-recipient" required="" value="">
						</div>
					</div>

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
					<button onclick="JQAdd_GalCate_Tall($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
					<i class="far fa-paper-plane"></i>&nbsp;<?php echo "ยืนยันการส่งอีเมล์";?>
					</button>
				</div>
			</div>
		</div>
	</div>	 
</form>
<script src="popup/assets/js/more-pop.js"></script> 