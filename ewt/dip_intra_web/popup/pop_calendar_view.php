<?php
include("assets/config.inc.php");
/*include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");*/
include("include.php");

$event_id      = (int)(!isset($_GET['event_id']) ? '' : $_GET['event_id']);

$_sql = $db->query("SELECT 
					cal_event.*,
					cal_show_event.event_date_start,
					cal_show_event.event_date_end,
					cal_category.cat_name,
					cal_category.cat_color 
					FROM cal_event 
					LEFT JOIN cal_show_event ON (cal_event.event_id = cal_show_event.event_id) 
					LEFT JOIN cal_category ON (cal_category.cat_id = cal_event.cat_id)
					WHERE cal_event.event_id = '{$event_id}' ");
$a_data = $db->db_fetch_array($_sql);	

$_sql_cal_event = $db->query("SELECT 
					cal_registor_event.*
					FROM cal_registor_event 
					WHERE cal_event_id = '{$event_id}' ");
$a_rows = $db->db_num_rows($_sql_cal_event);

$_sql_cal_invite = $db->query("SELECT *
					FROM cal_invite 
					WHERE event_id = '{$event_id}' ");
$a_data_invite = $db->db_fetch_array($_sql_cal_invite);		
							
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

<form id="form_main" name="form_main" method="POST" action="popup/func_faq_add_question.php" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Cal_Add_Q" />
<input type="hidden" name="event_id" id="event_id"  value="<?php echo $event_id;?>" />
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
      <div class="modal-header modal-color">
        <div class="head-sec">
          <h2><?php echo $text_calendar_seminar_training;?></h2>
        </div>
        <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
      </div>
<div class="modal-body modal-color">
<h3><?php echo $a_data['event_title'];?></h3>
	<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt"><?php echo $text_eventcalendar_info; ?></div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt"><?php echo $a_data['event_detail'];?></div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt"><?php echo $text_eventcalendar_startend ; ?></div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt"><?php echo date_formatslash($a_data['event_date_start']);?> - <?php echo date_formatslash($a_data['event_date_end']);?></div>

<!--<div class="row calendar-row">
	<div class="col-sm-3">Register Date</div>
	<div class="col-sm-9"><?php //echo $a_data['event_date_start'];?> To <?php //echo $a_data['event_date_end'];?></div>
</div>
<div class="row calendar-row">
	<div class="col-sm-3">Available for</div>
	<div class="col-sm-9"><?php //echo ($a_data['event_registor_num'] - $a_rows);?> person</div>
</div>-->


	<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt"><?php echo $text_eventcalendar_limit; ?></div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt"><?php echo $a_data['event_registor_num'];?> <?php echo $text_eventcalendar_limitperson; ?></div>


	<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt"><?php echo $text_eventcalendar_coordinate; ?></div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt">
	<?php echo cal_contact($a_data_invite['person_id']);?>
	</div>


	<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt"><?php echo $text_eventcalendar_location; ?></div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt">			
	<p><?php echo $a_data['event_location'];?></p>
	</div>


    <div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt"><?php echo $text_eventcalendar_attachment; ?></div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt">
			<?php if($a_data['event_link']){ ?> 
            <ul>
            <li><?php echo $text_eventcalendar_attachment; ?> | [ <a class="txt-dark-color" href="<?php echo $a_data['event_link'];?>" download> Download</a> ] </li> 
            </ul>
			<?php }else{ echo '-'; }  ?>
		
            </div>


	<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt"><?php echo $text_eventcalendar_relatelink; ?></div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt">		
		<a href="<?php echo create_seourl($a_data['event_relatelink'],$language); ?>" style="color: #000;"> View </a>
	</div>

	<!--</div>	 	
</div>
<div class="modal-footer">-->
<div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-5 mb-3 text-center">
<?php
if($a_data['event_registor'] == 'Y' ) 
{
	if($a_data['event_registor_num'] > $a_rows AND $a_data['event_registor_num'] != '0' ) 
	{
?>
<button type="button" class="btn btn-success" onClick="boxPopup('popup/pop_calendar_registor.php?event_id=<?php echo $a_data['event_id'];?>')" > <?php echo $text_eventcalendar_registerheader; ?> </button>
<?php 
	}
	else
	{
		//echo "<button type=\"button\" class=\"btn btn-saminar btn-success\"  >";
		//echo $text_calendar_disable_regis.PHP_EOL;
		//echo '</button>';
	}
}

if($a_data['event_registor'] == 'M') 
{
	if(!empty($a_data['event_link_registor']))
	{
//$txt .='<button type="button" class="btn btn-saminar btn-success" data-toggle="modal"  data-target="#Register-calendar">';
		echo "<button type=\"button\" class=\"btn btn-saminar btn-success\" onClick=\"window.open('".$a_data['event_link_registor']."');\" >";
		echo $text_calendar_regis.PHP_EOL;
		echo '</button>';
	}
}
 ?>
</div>
</div>
</div>
</div>	 
</form>
<script src="popup/assets/js/more-pop.js"></script> 
