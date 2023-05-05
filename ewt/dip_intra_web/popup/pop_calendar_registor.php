<?php
include("assets/config.inc.php");
//include("../lib/function.php");
//include("../lib/user_config.php");
//include("../lib/connect.php");
include("include.php");

$event_id = (int)(!isset($_GET['event_id']) ? '' : $_GET['event_id']);


$_sql = $db->query("SELECT 
					cal_event.*,
					cal_show_event.event_date_start,
					cal_show_event.event_date_end,
					cal_category.cat_name,
					cal_category.cat_color 
					FROM cal_event 
					LEFT JOIN cal_show_event ON (cal_event.event_id = cal_show_event.event_id) 
					LEFT JOIN cal_category ON (cal_category.cat_id = cal_event.cat_id)
					WHERE cal_event.event_id = '{$event_id}'
					");
$a_data = $db->db_fetch_array($_sql);	
							
if($lang_config_status == "T"){
	//convert n_date
	$convert_date = explode("-",$a_data['event_date_start']);
	$a_data['event_date_start'] = ($convert_date[0]+543)."-".$convert_date[1]."-".$convert_date[2];
	
	$convert_date = explode("-",$a_data['event_date_end']);
	$a_data['event_date_end'] = ($convert_date[0]+543)."-".$convert_date[1]."-".$convert_date[2];
}
else{
	//convert n_date
}				
?>

<?php
include "include_currentstyle.php";
?>

<form id="form_registor" name="form_registor" method="POST" action="popup/func_calendar_registor.php" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Cal_Add_Registor" />
<input type="hidden" name="event_id" id="event_id"  value="<?php echo $event_id;?>" />
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
 <div class="modal-header">
        <div class="head-sec">
          <h2><?php echo $text_eventcalendar_registerheader; ?></h2>
        </div>
        <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
</div>
<div class="modal-body">
<h3><?php echo $a_data['event_title'];?></h3>
<p class="pb-4"><?php //echo $a_data['event_title'];?></p>
		
<div class="form-row">
		<div class="form-group col-md-6"><?php echo $text_eventcalendar_registeridnum; ?> <span class="text-danger"></span>:  
			<input class="form-control font19px h-auto " type="text" id="ID-calendar" name="ID-calendar" >
			<label for="ID-calendar" hidden> <?php echo $text_eventcalendar_registeridnum; ?></label>		
        </div>

        <div class="form-group col-md-6"> <?php echo $text_eventcalendar_registerfullname; ?>  <span class="text-danger"><code>*</code></span>:
			<input class="form-control font19px h-auto" type="text" id="Name-Surname-calendar" name="Name-Surname-calendar" required="">
			<label for="Name-Surname-calendar" hidden> <?php echo $text_eventcalendar_registerfullname; ?> </label>
		</div>
     
        <div class="form-group col-md-6"><?php echo $text_eventcalendar_registertel; ?> <span class="text-danger"><code>*</code></span>: 
			<input class="form-control font19px h-auto phone" type="text" id="tel-calendar" name="tel-calendar" required="">
        <label for="tel-calendar" hidden> <?php echo $text_eventcalendar_registertel; ?></label>
        </div>
     
        <div class="form-group col-md-6"> <?php echo $text_eventcalendar_registeremail; ?> <span class="text-danger"><code>*</code></span>:
			<input class="form-control font19px h-auto checkmail " type="email" id="email-calendar" name="email-calendar" required="">
        <label for="email-calendar" hidden>  <?php echo $text_eventcalendar_registeremail; ?></label>
        </div>
       
     
<div class="form-group col-md-6">
<label for="" class="col-sm-12 control-label"></label>
<span id="recapt" ></span>
<span class="btn btn-warning text-white" onclick="Func_ReCaptcha();"><i class="fas fa-sync"></i></span>	
</div> 
<div class="form-group col-md-6">
<label for="chkpic" ><?php echo $text_eventcalendar_registercaptcha; ?> <span class="text-danger"><code>*</code></span> : </label>
<input class="form-control chkcaptcha" type="text" name="chkpic" id="chkpic" required="required" autocomplete="off" />
<input type="hidden" name="capt" id="capt"  value="" />	
</div> 
</div> 
      <div class="modal-footer">
	   <div class="row calendar-row">
	   <div class="col-md-12 col-sm-12 col-xs-12" >
        <button type="button" class="btn btn-secondary" onclick="$('#box_popup').fadeOut();" >
		<i class="far fa-times-circle"></i>&nbsp;<?php echo $text_eventcalendar_registercancel; ?></button>
		<button onclick="JQAdd_Cal_Registor($('#form_registor'));" type="button" class="btn btn-success  btn-ml " >
		<i class="far fa-save"></i>&nbsp;<?php echo $text_eventcalendar_registerconfirm; ?>
		</button>
	</div> 
</div>
      </div>
</div>

</div>
</div>	 
</form>
<script src="popup/assets/js/more-pop.js"></script> 