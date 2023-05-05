<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

if($_GET['ad_id']){
	$wh = "AND ad_id = '{$_GET[ad_id]}'";
}
	
	
$s_detail = $db->query("SELECT * FROM article_detail WHERE n_id = '{$_GET[nid]}' {$wh} ");	 
$a_detail = $db->db_fetch_array($s_detail);

if($a_detail['ad_des'] != ''){
$txt = $a_detail["ad_des"]; 
}	
	
?>	
<div class="dContainer" >   
    <div class="modal-dialog modal-lg">

      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
          <h4 class="modal-title">รายละเอียด</h4>
        </div>
        <div class="modal-body" style='overflow-y : auto;  max-height:420px;'>
		<div class="form-group row" >
		<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="text-center" >
		<?php if($_GET['row'] != "11" ){ ?>
		<img src="<?php if($a_detail['ad_pic_b'] != ""){ echo "../ewt/".$_SESSION['EWT_SUSER']."/images/article/news".$_GET[nid]."/".$a_detail['ad_pic_b']; }else{ echo "../images/pic_preview.gif"; } ?>" class="img-responsive" _style="width:100%;height:100%;" style="width:90%; border: 0.5px solid #cbcccc;padding: 5px;border-radius: 5px; margin:0 auto;" />


		<?php } ?>	
		</div>
		</div>
		</div>
		<div class="form-group row" >
		<div class="col-md-12 col-sm-12 col-xs-12">
		<?=$txt;?>
		</div>
		</div>
        </div>
		
      </div>
	 
    </div>
 </div>	 

