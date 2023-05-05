<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");

$s_id = $_GET['s_id'];
 
?>


<div class="dContainer" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" >&times;</button>
          <h4 class="modal-title"><?=$lang_add3_part; ?></h4>
        </div>
		
<form name="form1" method="post" >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">



<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="des"><?php echo $lang_add3_part; ?><span class="text-danger">*</span> : </label>
<input class="form-control numberint" name="pa"  id="pa"  value=""/>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="name"><?=$lang_edit_partname;?><span class="text-danger">*</span> : </label>
<textarea   class="form-control" name="name"  id="name"  cols="40" rows="5" ></textarea>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="des"><?=$lang_edit_partexplain;?><span class="text-danger">*</span> : </label>
<textarea   class="form-control" name="des"  id="des"  cols="40" rows="5" ></textarea>
</div>
</div>

<div class="form-inline">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="gr"><?=$lang_add_questiontype;?><span class="text-danger">*</span> : </label>
<input name="gr" type="radio" value="N"  onClick="document.getElementById('sel').disabled = true;document.getElementById('num').disabled = true;" checked>
<?=$lang_add_questiontype_separate; ?> 
<input type="radio" name="gr" value="Y" onClick="document.getElementById('sel').disabled = false;document.getElementById('num').disabled = false;">
<?=$lang_add_questiontype_single; ?>

<select name="sel" id="sel" disabled class="form-control">
    <option value="A">Radio Box</option>
    <option value="B">Check Box</option>
</select>

<?=$lang_add_questiontype_single_amount;?>
<input name="num" type="text" disabled id="num" value="3" size="5" class="form-control numberint"> 
<?=$lang_add_questiontype_single_answer;?>
</div>
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
<button onclick="JQAdd();" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
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

<script >
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
