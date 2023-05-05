<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../lib/config_path.php");
$s_group = $db->query("SELECT c_parent,c_name,c_id FROM article_group WHERE c_id = '{$_GET['id']}' ");
$a_data = $db->db_fetch_array($s_group);
$a_num = $db->db_num_rows($s_group);
?>	
<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_set_multilang')?>" enctype="multipart/form-data" >
      <input type="hidden" name="proc" id="proc"  value="set_lang_group">
	  <input type="hidden" name="num"  id="num" value="2">
	  <input type="hidden" name="c_parent" id="c_parent" value="<?=$a_data['c_parent'];?>">
      <input type="hidden" name="c_id" id="c_id" value="<?=$_GET['id']?>">
	  <input type="hidden" name="lang_name"  id="lang_name" value="<?=$_GET['langid']?>">
	  <input type="hidden" name="module" id="module" value="article_group">
<div class="dContainer" >   
<div class="modal-dialog modal-ml" style="width:60%;">

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"><?="บริหารกลุ่มข่าว/บทความภาษาอื่นๆ";?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b>&bull;&nbsp;กรุณาใส่ภาษาตามที่เลือก &nbsp;</b><?=show_icon_setlang($a_data ['c_id'],'article_group');?></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="" class="col-sm-6 control-label"><b>ชื่อกลุ่มภาษาหลัก :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<h4><span class="label label-primary"><?=$a_data['c_name'];?></span></h4>
</div>
</div>
<div class="form-group row" >
<label for="" class="col-sm-6 control-label"><b>ชื่อกลุ่มภาษาตามที่เลือก :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input name="lang_detail[0]" type="text" class="form-control" value="<?=select_lang_detail($_GET['id'],$_GET['langid'],'c_name','article_group');?>">
<input type="hidden" name="lang_field[0]" value="c_name">
</div>
</div>
</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQSet_lang_group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?="บันทึก";?>
</button>
</div>
</div>
</div>
 
</div>
</div>	 
</form>	
<script>  

</script>