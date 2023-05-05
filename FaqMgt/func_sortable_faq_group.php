<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Sortable_Edit'){
	
$s_data = array();

//$a_data['page_id_array'];
for($i=0; $i<count($a_data['page_id_array']); $i++){
	
$s_data['faq_cate_order']  = $i+1;
	
update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
}
							   
//print_r($a_data['page_id_array']);	

unset($a_data);
unset($s_data);

exit;
	} 
?>