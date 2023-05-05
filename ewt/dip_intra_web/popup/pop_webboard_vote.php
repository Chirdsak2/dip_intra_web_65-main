<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$tid = $_GET["t_id"];
$aid = $_GET["a_id"];

?>
<form id="form_main" name="form_main" method="POST" action="popup/func_webboard_vote.php" enctype="multipart/form-data" >
<div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="head-sec">
          <h2><?php echo $TITLE;?></h2>
        </div>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
	  
      <div class="modal-body">
		<div class="form-group row">
			<label class="col-sm-3 col-form-label">โหวตให้คะแนน : <span class="text-danger">* </span></label>
			<div class="col-sm-9">
				<form class="form-check pad-l-0">
					<fieldset>
						<legend hidden>Donut Type</legend>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="vote" id="inlineRadio1" value="1">
					  <label class="form-check-label" for="inlineRadio1">1</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="vote" id="inlineRadio2" value="2">
					  <label class="form-check-label" for="inlineRadio2">2</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="vote" id="inlineRadio3" value="3" checked>
					  <label class="form-check-label" for="inlineRadio3">3</label>
					</div>

					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="vote" id="inlineRadio4" value="4">
					  <label class="form-check-label" for="inlineRadio4">4</label>
					</div>

					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="vote" id="inlineRadio5" value="5" checked>
					  <label class="form-check-label" for="inlineRadio5">5</label>
					</div>
					</fieldset>
				</form>
			</div>
		</div>
      </div>
      
	  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" onclick="$('#box_popup').fadeOut();" >
			<i class="far fa-times-circle"></i>&nbsp;<?php echo "ปิด";?></button>
			<button onclick="JQWebbord_Vote($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
			<i class="far fa-paper-plane"></i>&nbsp;<?php echo "โหวต";?>
			</button>
		</div>
		
		<input name="proc" type="hidden" id="proc" value="vote">
		<input name="tid" type="hidden" id="tid" value="<?php echo $tid; ?>">
		<input name="aid" type="hidden" id="aid" value="<?php echo $aid; ?>">
	  
    </div>
  </div>
</div>
</form>

<script src="popup/assets/js/more-pop.js"></script> 