<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
/*
include("../EWT_ADMIN/comtop_pop.php");*/


$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Sortable_Edit'){
	
$s_data = array();

//$a_data['page_id_array'];
$start = $a_data['start'];
$val   = count($a_data['page_id_array'])+$start;
for($i=0; $i<$val; $i++){
	
$s_data['c_order']  = $i+$start;
	
update('article_group',$s_data,array('c_id'=>$a_data['page_id_array'][$i]));
	
}
							   
print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>