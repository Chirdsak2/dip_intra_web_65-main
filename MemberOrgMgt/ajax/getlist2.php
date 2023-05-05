<?php
	header ("Content-Type:text/plain;charset=UTF-8");

   set_time_limit(180);
   session_start ();
   $path = '../';
   include ($path.'include/config.inc.php');
   include ($path.'include/class_db.php');
   include ($path.'include/class_display.php');
   
   $CLASS['db']   = new db();
   $CLASS['db']->connect ();
   $CLASS['disp'] = new display();
   
  $db   = $CLASS['db'];
  $disp = $CLASS['disp'];

  /* $mode = 'tambon';
   $ref1='10';
   $ref2 ='01';*/
  if ($mode=='amphur'){
		print '<select class="Form-TextField" name="place_amphur" onChange="url=\'../ajax/getlist2.php?mode=tambon&ref1=\'+frm.place_province.value+\'&ref2=\'+this.value; load_divForm(url,\'sp_tambon\');  url=\'../ajax/getlist2.php?mode=postcode&ref1=\'+frm.place_province.value+\'&ref2=\'+this.value; load_divForm(url,\'sp_postcode\'); " >'; 
		print '<option value="">--โปรดเลือก--</option>';
		$disp->ddw_list_selected_thai ("select * from AMPHUR where PROVINCE_ID = '$ref1' ORDER BY AMPHUR_NAME","AMPHUR_NAME","AMPHUR_ID"); 
		print '</select>';
  }
  if ($mode=='tambon'){
		print '<select class="Form-TextField" name="place_tumbon">';
		print '<option value="">--โปรดเลือก--</option>';
		$disp->ddw_list_selected_thai ("select * from TAMBON where PROVINCE_ID = '$ref1' and AMPHUR_ID = '$ref2' ORDER BY TAMBON_NAME","TAMBON_NAME","TAMBON_ID"); 
		print '</select>';
}
if ($mode=='postcode'){
		 $sql_opt="SELECT  ZIPCODE FROM AMPHUR WHERE PROVINCE_ID = '$ref1' AND AMPHUR_ID = '$ref2' ";
		$exec_opt = $db->query($sql_opt);
		$rst_opt=$db->fetch_array($exec_opt);
		print '<input name="place_zipcode" type="text" class="Form-TextRead" value="'.$rst_opt[ZIPCODE].'" size="7" readonly>';
}
 
  $db->close_db();
?>