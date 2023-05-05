<?php
/*include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");
include("../language/banner_language.php");*/

include("../EWT_ADMIN/comtop_pop.php");

$ban_id = (int)(!isset($_GET['ban_id']) ? 0 : $_GET['ban_id']);

$s_banner = $db->query("SELECT * FROM banner  WHERE  banner_id = '{$ban_id}' ");
$a_banner = $db->db_fetch_array($s_banner);

?>	
<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_banner')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="set_lang_group">

<div class="dContainer" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"><?=$txt_banner_name;?> : <?=$a_banner['banner_name'];?></h4>
</div>

<div class="modal-body">
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" style="margin-right:auto;margin-left:auto;" >
<?php
echo "<img class=\"\" src=\"../ewt/".$_SESSION["EWT_SUSER"]."/".$a_banner['banner_pic']."\" alt=\"".$a_banner['banner_name']."\" title=\"".$a_banner['banner_name']."\" />	";		
?>
</div>
</div>
</div>

</div>
</div>	
</div> 
</form>	
<style>
<!--
img {
    max-width: 100%;
    height: auto;
	margin-right:auto;
	margin-left:auto;
}
-->
</style>
<script>  
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	
});
</script>