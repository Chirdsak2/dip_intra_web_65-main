<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 " id="div-online">
<div class="card">
<div class="card card-banner card-chart card-blue no-br" >
<div class="card-header ">
 
<div class="card-title">
<div class="title">Active Users right now<!--ผู้เข้าชมเว็บไซต์ที่ใช้งานอยู่ --></div>
<div class="title text-right"><i class="fas fa-sync-alt fa-spin fa-1x " ></i></div>
<div class="title" >
<i class="fas fa-signal fa-1x text-danger" ></i>
<span class="sign"></span>
<span id="sessiononline">
<?php
$intRejectTime = 10; // Minute
$s_delonline 	= 	"DELETE FROM stat_online WHERE DATE_ADD(so_onlinelasttime, INTERVAL {$intRejectTime} MINUTE) <= NOW() ";
$_q_delonline = $db->query($s_delonline); 
	
$s_count = "SELECT so_session_id FROM stat_online GROUP BY so_session_id ";
$_q_count = $db->query($s_count);
$_rec = $db->db_fetch_row($_q_count); 
$_row = $db->db_num_rows($_q_count);
?>

<span class="text-large" ><?php echo number_format($_row,0)?>
</span>
</span>
</div>
</div>
</div>	
	
<div class="card-body ">
<div id="so_"></div>
<div id="chartonline" >
<?//include('chart_online.php');?>
</div>
</div>     
</div>
</div>
</div>
