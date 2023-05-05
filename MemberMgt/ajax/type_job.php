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
?>
<select name="type_job"  id="type_job">
  <option value="">--โปรดเลือก--</option>
  <?php echo $disp->ddw_list_selected ("SELECT TYPE_JOB_NAME,TYPE_JOB_ID FROM TYPE_JOB WHERE TYPE_JOB.JOB_DEP_ID = '$id2' ORDER BY TYPE_JOB_NAME","TYPE_JOB_NAME","TYPE_JOB_ID","");?>
</select>