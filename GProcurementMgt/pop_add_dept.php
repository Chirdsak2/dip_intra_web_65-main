<?php
include("../EWT_ADMIN/comtop_pop.php");
	
$s_egp_dept = $db->query("SELECT * FROM egp_dept WHERE egp_dept_id = '{$_GET[egp_id]}' AND egp_dept_sub = '0' ");	 
$a_egp_dept = $db->db_fetch_array($s_egp_dept);

if($a_detail['ad_des'] != ''){
$txt = $a_detail["ad_des"]; 
}	

if($_GET['proc'] == 'AddProc'){
	
$PROCESS = 'AddDept';

}else{	

	$PROCESS = 'EditDept';		
}	
?>	
<form action="process.php" method="post" enctype="multipart/form-data" name="form" >
<input name="id" 		type="hidden" id="id" 		value="<?php echo $_GET['egp_id']; ?>" />
<input name="proc" 		type="hidden" id="proc" 	value="<?php echo $PROCESS;?>" />
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_egp_dept_add;?></h4>
</div>


<div class="modal-body">
  
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >
  
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic1"><?php echo $txt_egp_dept_code;?> <span class="text-danger"><code>*</code></span> : </label>        
<input name="topic1" type="text" id="topic1"  class="form-control" required value="<?php echo $a_egp_dept['egp_dept_code']; ?>" />	
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic2"><?php echo $txt_egp_dept_name;?> <span class="text-danger"><code>*</code></span> : </label>        
<input name="topic2" type="text" id="topic2"  class="form-control" required  value="<?php echo $a_egp_dept['egp_dept_name']; ?>"/>	
</div>
</div>
</div>
</div>
</div>

<div class="modal-footer "> 
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<button type="submit" class="btn btn-success  btn-ml " >
		<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save ;?>
		</button>
</div>
</div>
</div>
</div>	 
</div>
</div>	 
</form>
