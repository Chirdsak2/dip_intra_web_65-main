<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language/language_TH.php");
include("../lib/config_path.php");
$id = (int)(!isset($_GET['id']) ? '' : $_GET['id']);
$langid = (int)(!isset($_GET['langid']) ? '' : $_GET['langid']);

$s_poll_cat = $db->query("SELECT poll_cat.c_id,
									 poll_cat.c_name,
									 poll_cat.c_detail,
									 poll_cat.c_approve									 
									 FROM poll_cat 
									 WHERE c_id = '{$id}' ");
$a_data = $db->db_fetch_array($s_poll_cat);
$a_num = $db->db_num_rows($s_poll_cat);
	
?>	

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_set_lang_poll')?>" enctype="multipart/form-data" >
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"><?=$txt_poll.$txt_ewt_multilang;?></h4>
</div>

<div class="modal-body">


<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b>&bull;&nbsp;กรุณาใส่ภาษาตามที่เลือก &nbsp;</b><?=show_icon_setlang($a_data['c_id'],'poll');?></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="" class="col-sm-12 col-xs-12 control-label"><b><?=$txt_poll_title;?> :</b></label>
<div class="col-md-12 col-sm-6 col-xs-6" style="margin-right:auto;margin-left:auto;word-wrap: break-word;" >

<h4 class="text-info"><?=$a_data['c_name'];?></h4>
</div>
</div>
<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12 control-label"><b><?=$txt_poll_title_multilang;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input name="lang_detail[0]" id="lang_detail[0]" placeholder="<?=$txt_poll_title_multilang;?>" type="text" class="form-control"  value="<?=select_lang_detail($id,$langid,'c_name','poll');?>">
<input type="hidden" name="lang_field[0]" id="lang_field[0]" value="c_name">
</div>
</div>

<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12  control-label"><b><?=$txt_poll_detail;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >

<h4 class="text-info"><?=$a_data['c_detail'];?></h4>

</div>
</div>
<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12 control-label"><b><?=$txt_poll_detail_multilang;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input name="lang_detail[1]" id="lang_detail[1]" placeholder="<?=$txt_poll_detail_multilang;?>" type="text" class="form-control"  value="<?=select_lang_detail($id,$langid,'c_detail','poll');?>" >
<input type="hidden" name="lang_field[1]" id="lang_field[1]" value="c_detail">
</div>
</div>


<input type="hidden" name="lang_field[9]" id="lang_field[9]" value="link_html">
<input type="hidden" name="lang_field[10]" id="lang_field[10]" value="browse_file">
<input type="hidden" name="news_use" id="news_use" value="<?=$a_data['news_use'] ;?>">


</div>
</div>	

</div>
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Lang_Poll($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>
	 
</div>
</div>

      <input type="hidden" name="proc" id="proc" value="set_lang">
	  <input type="hidden" name="num" id="num" value="<?php 
	  if($a_data['at_id'] > 0 && $a_data['at_id'] < 10 && $a_data['news_use'] == '2'){  
	  echo ($n); 
	  }else if($a_data['at_id']  == 10){  
	  echo '10';
	  }else if($a_data['news_use'] == '1'){  
	  echo '11';
	  }else{ 
	  echo '9';
	  }?>">
      <input type="hidden" name="c_id" id="c_id"  value="<?=$_GET['id']?>">
	  <input type="hidden" name="c_parent" id="c_parent" value="<?=$a_data['c_id'];?>">
	  <input type="hidden" name="lang_name" id="lang_name" value="<?=$_GET['langid']?>">
	  <input type="hidden" name="lang" id="lang" value="<?=$_GET['lang']?>">
	  <input type="hidden" name="module" id="module"  value="article_list">
	  <input type="hidden" name="at_id" id="at_id" value="<?=$a_data['at_id'];?>">
	  
</form>	
