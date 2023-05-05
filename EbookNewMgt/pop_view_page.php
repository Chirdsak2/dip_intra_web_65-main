<?php
include("../EWT_ADMIN/comtop_pop.php");
$p = (int)(!isset($_GET['p']) ? '' : $_GET['p']);
$ebook_code = (!isset($_GET['ebook_code']) ? '' : $_GET['ebook_code']);
$dest = "../ewt/".$_SESSION["EWT_SUSER"]."/ebook/".$ebook_code; //Source ebook
$destPage = $dest.'/pages/';
$s_sql 	= $db->query("SELECT * FROM ebook_page WHERE ebook_code = '{$ebook_code}'  AND ebook_page = '{$p}' ");
$a_data = $db->db_fetch_array($s_sql);  
?>
<div class="container" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">

<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"></h4>
</div>

	

<div class="modal-body">

<div class="card "> 
<div class="row" > 
<div class="col-md-12" >
<img src="<?php echo $destPage.''.$a_data['ebook_page_file'];?>" alt="" class="img-responsive " />
</div>
</div>
</div>
</div>
</div> 

</div>
</div>
</div>
<script>


</script>