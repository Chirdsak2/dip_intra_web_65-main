<?php
$faq_cid = (int)(!isset($_GET['faq_cid']) ? 0 : $_GET['faq_cid']);
?>
<form id="form_main" name="form_main" method="POST" action="popup/func_faq_add_question.php" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Faq_Add_Q" />
<input type="hidden" name="faq_cid" id="faq_cid"  value="<?=$faq_cid;?>" />
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
      <div class="modal-header">
        <div class="head-sec">
          <h2>ส่งคำถาม</h2>
        </div>
        <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
      </div>
      <div class="modal-body">

        <div class="row calendar-row">
          <div class="col-sm-3"><span class="text-danger">* </span>คำถาม :</div>
          <div class="col-sm-9">
            <label hidden for="question-ask">คำถาม</label>
            <textarea class="form-control" id="question-ask" name="question-ask"  rows="3" required=""></textarea>
          </div>
        </div>

        <div class="row calendar-row">
          <div class="col-sm-3"><span class="text-danger">* </span>รายละเอียด :</div>
          <div class="col-sm-9">
            <label hidden for="detail-ask">รายละเอียด</label>
            <textarea class="form-control" id="detail-ask" name="detail-ask" rows="3" required=""></textarea>
    </div>
        </div>

         <?php /*<div class="row calendar-row">
          <div class="col-sm-3"><span class="text-danger">* </span>ผู้ตั้งคำถาม :</div>
          <div class="col-sm-9">
      <label hidden for="name-ask">ผู้ตั้งคำถาม</label>
      <input class="form-control font19px h-auto" type="text" id="name-ask" name="name-ask" required="">
    </div>
        </div>

       <div class="row calendar-row">
          <div class="col-sm-3"><span class="text-danger">* </span>อีเมล์ :</div>
          <div class="col-sm-9">
      <label hidden for="email-ask">อีเมล์</label>
      <input class="form-control font19px h-auto" type="text" id="email-ask" name="email-ask" required="">
    </div>
        </div>*/?>
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
<input type="hidden" name="capt" id="capt"  value="" />	
</div>
</div>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="$('#box_popup').fadeOut();" >
		<i class="far fa-times-circle"></i>&nbsp;<?="ยกเลิก";?></button>
		<button onclick="JQAdd_Faq_Q($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
		<i class="far fa-paper-plane"></i>&nbsp;<?="ส่งคำถาม";?>
		</button>
      </div>
</div>

</div>
</div>	 
</form>
<script src="popup/assets/js/more-pop.js"></script> 