<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 


$path = $_GET['path'];
$post = $_GET['post'];
	
$SQL1 = $db->query("SELECT * FROM p_cate WHERE c_id = '{$path}'");
$PR = $db->db_fetch_array($SQL1);
?>
<div class="dContainer" > 
<div class="modal-dialog modal-lg"  >

<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" >&times;</button>
          <h4 class="modal-title"><?=$lang_add3_edititem;?> <?=$post;?></h4>
        </div>


<form name="form1" method="post" >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">



<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="des"><?php echo $lang_add3_edititem; ?><span class="text-danger">*</span> : </label>
<input class="form-control numberint" name="pa"  id="pa"  value="<?=$post;?>"/>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="name"><?=$lang_edit_partname;?><span class="text-danger">*</span> : </label>
<textarea   class="form-control" name="name"  id="name"  cols="40" rows="5" ><?=$PR['c_name']; ?></textarea>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="des"><?=$lang_edit_partexplain;?><span class="text-danger">*</span> : </label>
<textarea   class="form-control" name="des"  id="des"  cols="40" rows="5" ><?=$PR['c_title']; ?></textarea>
</div>
</div>

<input name="path" type="hidden" id="path" value="<?=$path;?>">
<input name="proc" type="hidden" id="proc" value="P">
</div>

</div>
</form>		

		
<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<button onclick="JQEdit();" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
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
<?php @$db->db_close(); ?>