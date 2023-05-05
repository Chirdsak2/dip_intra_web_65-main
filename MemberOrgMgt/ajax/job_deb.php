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
<select  id="job_dep"  name="job_dep" onChange="url='../ajax/type_job.php?id2='+this.value+'';load_divForm(url,'div_type_job1');">
  <option value="">--โปรดเลือก--</option>
  <?php echo $disp->ddw_list_selected ("SELECT JOB_DEP_NAME,JOB_DEP_ID FROM JOB_DEP WHERE DEPARTMENT_ID = '$id' ORDER BY JOB_DEP_NAME  ","JOB_DEP_NAME","JOB_DEP_ID","");?>
</select>

