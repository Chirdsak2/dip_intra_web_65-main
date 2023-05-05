<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 

$s_id = $_GET['s_id'];

$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '{$s_id}' ");
$PR = $db->db_fetch_array($SQL1);
?>
<div class="dContainer" > 
<div class="modal-dialog modal-lg"  >




<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" >&times;</button>
          <h4 class="modal-title">แก้ไขส่วนหัวข้อ</h4>
        </div>


<form name="form1" method="post" >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="name"><?="หัวข้อแบบสำรวจ";?><span class="text-danger">*</span> : </label>
<textarea   class="form-control" name="name"  id="name"  cols="40" rows="5" ><?=$PR['s_title']; ?></textarea>
</div>
</div>
<div class="form-group row">
<div class="col-md-3 col-sm-3 col-xs-12">
<label for="des"><?="ตำแหน่ง";?><span class="text-danger">*</span> : </label>
<input class="form-control numberint" name="des"  id="des"  value="<?=$PR['s_pos'];?>"/>
</div>
</div>
<input name="s_id" type="hidden" id="s_id" value="<?=$s_id;?>">
<input name="proc" type="hidden" id="proc" value="P">
</div>
</div>
</form>

<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<button onclick="JQEdit_s();" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?=$lang_survey_save; ?>
</button> 
<!--<input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
<input name="reset" type="reset" value="ยกเลิก" class="btn btn-warning"  onClick="$('#box_popup').fadeOut();">
<button class="btn btn-warning btn-lm" onClick="$('#box_popup').fadeOut();" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_update; ?>" >
<span class="glyphicon glyphicon-remove"></span>&nbsp;<?="ยกเลิก";?>-->
</button> 
</div>
</div>
</div>


</div>	

</div>
</div>

<script>
$(document).ready(function(){ 

$('.numberint').keypress(function (event) {
            return isNumberInt(event, this)
      });
	  
  });

function ChangeBox(c){
if(document.form1.sel.value =="D"){
document.form1.num.disabled = true;
document.form1.just.disabled = false;
}else if(document.form1.sel.value =="B"){
document.form1.just.disabled = true;
document.form1.num.disabled = false;
}else{
document.form1.just.disabled = false;
document.form1.num.disabled = false;
}
}
</script>
<?php @$db->db_close(); ?>