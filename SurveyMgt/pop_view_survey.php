<?php
include("../EWT_ADMIN/comtop_pop.php");

$s_id = (int)(!isset($_GET['s_id']) ? '' : $_GET['s_id']);

$SQL1  	= $db->query("SELECT * FROM p_survey WHERE s_id = '{$s_id}'");
$PR    	= $db->db_fetch_array($SQL1);

$sql0 	= $db->query("SELECT * FROM {$PR['s_table']} ORDER BY survey_id ");
$fi 	= mysqli_num_fields($sql0);
$ro 	= $db->db_num_rows($sql0);
echo $sendTB = $PR['s_table'];
?>
<div class="container" > 
<div class="modal-dialog modal-lg"  >

<div class="modal-content">

<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6" >
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"> <i class="fas fa-search"></i> <?php //echo strip_tags($PR['s_title']);?></h4>
</div>
<div class="modal-body">
<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right m-b-sm"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fas fa-file-export"></i>&nbsp;export <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <!--<li class="pointer"><a onClick="boxPopup('<?php echo linkboxPopup();?>export_survey_xlsx.php');" ><i class="fas fa-file-excel text-success  text-medium"></i>&nbsp;<?php echo "Excel";?></a></li>
			<li class="pointer"><a onClick="boxPopup('<?php echo linkboxPopup();?>export_survey_pdf.php');" ><i class="fas fa-file-pdf  text-danger text-medium"></i>&nbsp;<?php echo "PDF";?></a></li>-->
			<li class="pointer"><a href="export_survey_xlsx.php?s_id=<?php echo $s_id;?>" download ><i class="fas fa-file-excel text-success  text-medium"></i>&nbsp;<?php echo "Excel";?></a></li>

		</ul>
</div>
</div>
<div class="scrollbar_view_overflow scrollbar-near-moon thin " >

<table class="table table-bordered">
<thead>
<tr class="info">	
<th class="text-center text-dark">PDF</th>
<?php 
$i = 0;
//while($i<$fi){ 
?>
<th class="text-center text-dark">
<?php 
/*$field[$i] = mysqli_fetch_field_direct($sql0,$i);   
	 $RR = explode("B",$field[$i]);
	  if($RR[1]==""){ //field รายละเอียด	
			  echo $RR[0];
	  }else{ //คำถามข้อต่างๆ
			$RRR = explode("_",$RR[1]);	  
			if($RRR[1]==""){ //ตอบข้อเดียว
				$sql1 = $db->query("SELECT q_des FROM p_question WHERE q_id ='{$RRR[0]}' ");
				$T = $db->db_fetch_array($sql1);
				echo $T['q_des'];
				//echo $field[$i];
				
				$sql2 = $db->query("SELECT a_name,a_weight, (SELECT MAX(a_weight) FROM p_ans WHERE q_id = '{$RRR[0]}') AS max_weight FROM p_ans WHERE q_id ='{$RRR[0]}' GROUP BY a_weight");
				while($W = $db->db_fetch_array($sql2)){
					$point = md5($i."RDBiZ".$W['a_name']);
					$arrpoint[$point] = $W['a_weight'];
					$arrpoint['max'.$point] = $W['max_weight'];
//					echo $i.'>>'.$W[a_name].'>>'.$point.'<--<br/>';
				}
			}else{ //มากกว่า 1
			
				$sql1 = $db->query("SELECT q_des FROM p_question WHERE q_id ='{$RRR[0]}' ");
				$T = $db->db_fetch_array($sql1);
				
				echo $T['q_des'];
				
				$sql2 = $db->query("SELECT a_name,a_weight FROM p_ans WHERE a_id ='{$RRR[1]}' ");
				$W = $db->db_fetch_array($sql2);
				$er = explode("#@form#img@#",$W['a_name']);
				
				echo " (".$er[0].")";
				
				$point = md5($i."RDBiZ".$W['a_name']);
				$arrpoint[$point] = $W['a_weight'];
				
			}
			//	  echo $RR[1];
	  }
?>
</th>
<?php 
$i++;
} ?>
<th class="text-center">รวมคะแนน/น้ำหนัก</th>
</tr>
</thead>
<tbody>
<?php
$tweight = 0;
$ttotal = 0;
$sum_each = array();
$total_each = array();
while($R = mysqli_fetch_row($sql0)){ 
?>
	
<tr>
<td class="text-center">
<a href="survey_pdf.php?sendTB=<?php echo $sendTB;?>&s_id=<?php echo $_GET['s_id'];?>&su_id=<?php echo $R[0];?>" target="_blank" data-toggle="tooltip" data-placement="right" title="<?php echo "Export PDF";?>">
<button type="button" class="btn btn-danger btn-circle   btn-xs " >
<i class="fa fa-file-pdf fa-1x" aria-hidden="true"></i>
</button>
</a>
</td> 
<?php
	for($y=0;$y<$i;$y++){ ?>
      <td class="text-left" ><?php
		if($R[$y]){ $er = explode("#@form#img@#",$R[$y]); 
				$field[$y] = mysqli_fetch_field_direct($sql0,$y); 
				  $XX = explode("B",$field[$y]);
				  $XXX = explode("_",$XX[1]);
				  $sql1 = $db->query("SELECT q_anstype FROM p_question WHERE q_id ='{$XXX[0]}' ");
				  $T = $db->db_fetch_array($sql1); 
				  $ptype = $T["q_anstype"];
				  if($ptype == 'E'){
					  $subf = explode('/',$er[0]);
					echo '<a href="../ewt/'.$EWT_FOLDER_USER.'/'.$er[0].'" target="_blank">'.$subf[3].'</a>';
				  }else{
				  echo $er[0];
				  }
			$point = md5($y."RDBiZ".$R[$y]);
			$tweight += $arrpoint[$point];
			$ttotal += $arrpoint['max'.$point];
			$sum_each[$y]+=$arrpoint[$point];
			$total_each[$y]+=$arrpoint['max'.$point];
			if($arrpoint[$point]!='') {
				echo ' ('.$arrpoint[$point].' / '.$arrpoint['max'.$point].')';
			}
		}else{ echo "&nbsp;"; } ?></td>
<?php
	}
	$sum_each[$i+1]=$tweight;
	$total_each[$i+1]=$ttotal;
?>
<td ><?php echo '('.number_format($tweight,0).' / '.number_format($ttotal,0).')'; ?></td>
</tr>
 <?php 
	$tweight = 0;
	$ttotal = 0;*/
//}
 
?>
<tr >
<td>Total : </td>
<?php
	/*for($y=0;$y<$i;$y++){ ?>
      <td class="text-center"><?php
		if($sum_each[$y]!='') {
	  		echo '('.$sum_each[$y].' / '.$total_each[$y].')';
		}?>&nbsp;</td>
<?php
	}*/
?>
<td ><?php //echo '('.$sum_each[$i+1].' / '.$total_each[$i+1].')'; ?></td>
</tr>
<tbody>	
</table>


</div>
</div>

</div>
</div>
</div>

<?php $db->db_close(); ?>
<script>
$(document).ready(function(){ 					
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>