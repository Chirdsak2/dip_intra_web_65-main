<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");

 
?>
<div class="dContainer" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
          <h4 class="modal-title"><i class="far fa-plus-square fa-1x"></i>&nbsp;<?="Create Templates"; ?></h4>
        </div>
		
<form name="form1" method="post" >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">

<div class="section">
<div class="section-title"></div>
<div class="section-body">

<div class="step">
    <ul class="nav nav-tabs nav-justified" role="tablist">
        <li role="step" class="active">
            <a href="#step1" id="step1-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                <div class="icon far fa-file-alt"></div>				
                <div class="heading">
                    <div class="title">Title Template</div>
                    <div class="description">&nbsp;</div>
                </div>
            </a>
        </li>
        <li role="step" >
            <a href="#step2" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                <div class="icon fas fa-list-alt"></div>
                <div class="heading">
                    <div class="title">Detail Template</div>
                    <div class="description">&nbsp;</div>
                </div>
            </a>
        </li>
        <li role="step">
            <a href="#step3" role="tab" id="step3-tab" data-toggle="tab" aria-controls="profile">
                <div class="icon fa fa-check"></div>
                <div class="heading">
                    <div class="title">Confirm Template</div>
                    <div class="description">&nbsp;</div>
                </div>
            </a>
        </li>

    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="step1">
            <b>Step1</b> : 
        </div>
        <div role="tabpanel" class="tab-pane active" id="step2">
            <b>Step2</b> : 
        </div>
        <div role="tabpanel" class="tab-pane" id="step3">
            <b>Step3</b> : 
    </div>
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
<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?="Save"; ?>
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

</script>
