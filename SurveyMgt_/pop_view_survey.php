<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 

$s_id = $_GET['s_id'];

$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '{$s_id}'");
$PR = mysql_fetch_array($SQL1);

$sql0 = $db->query("SELECT * FROM $PR[s_table] ORDER BY survey_id ");
$fi = mysql_num_fields($sql0);
$ro = mysql_num_rows($sql0);
$sendTB = $PR['s_table'];
?>
<div class="dContainer" > 
<div class="modal-dialog" style="width:90%;" >

<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" >&times;</button>
          <h4 class="modal-title"><?=$PR['s_title'];?></h4>
        </div>
<div class="modal-body">
<div class="scrollbar_view scrollbar-near-moon ">


<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr class="info">	
<th class="text-center">PDF</th>
  <?php 
  $i = 0;

  while( $i<$fi){ 

?>
<th class="text-center">
<?php 
$field[$i] = mysql_field_name($sql0,$i);   
	 $RR = explode("B",$field[$i]);
	  if($RR[1]==""){ //field รายละเอียด	
			  echo $RR[0];
	  }else{ //คำถามข้อต่างๆ
			$RRR = explode("_",$RR[1]);	  
			if($RRR[1]==""){ //ตอบข้อเดียว
				$sql1 = $db->query("SELECT q_des FROM p_question WHERE q_id ='$RRR[0]' ");
				$T = mysql_fetch_array($sql1);
				
				echo $T['q_des'];
				
				$sql2 = $db->query("SELECT a_name,a_weight, (SELECT MAX(a_weight) FROM p_ans WHERE q_id = '{$RRR[0]}') AS max_weight FROM p_ans WHERE q_id ='{$RRR[0]}' GROUP BY a_weight");
				while($W = mysql_fetch_array($sql2)){
					$point = md5($i."RDBiZ".$W['a_name']);
					$arrpoint[$point] = $W['a_weight'];
					$arrpoint['max'.$point] = $W['max_weight'];
//					echo $i.'>>'.$W[a_name].'>>'.$point.'<--<br/>';
				}
			}else{ //มากกว่า 1
			
				$sql1 = $db->query("SELECT q_des FROM p_question WHERE q_id ='{$RRR[0]}' ");
				$T = mysql_fetch_array($sql1);
				
				echo $T['q_des'];
				
				$sql2 = $db->query("SELECT a_name,a_weight FROM p_ans WHERE a_id ='{$RRR[1]}' ");
				$W = mysql_fetch_array($sql2);
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
while($R = mysql_fetch_row($sql0)){ 
?>
	
<tr>
<td class="text-center">
<a href="survey_pdf.php?sendTB=<?=$sendTB;?>&s_id=<?=$_GET['s_id'];?>&su_id=<?=$R[0];?>" target="_blank" data-toggle="tooltip" data-placement="right" title="<?="Export PDF";?>">
<button type="button" class="btn btn-danger btn-circle   btn-xs " >
<i class="fa fa-file-pdf fa-1x" aria-hidden="true"></i>
</button>
</a>
</td>
<?php
	for($y=0;$y<$i;$y++){ ?>
      <td class="text-center" ><?php
		if($R[$y]){ $er = explode("#@form#img@#",$R[$y]); 
				$field[$y] = mysql_field_name($sql0,$y); 
				  $XX = explode("B",$field[$y]);
				  $XXX = explode("_",$XX[1]);
				  $sql1 = $db->query("SELECT q_anstype FROM p_question WHERE q_id ='{$XXX[0]}' ");
				  $T = mysql_fetch_array($sql1); 
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
	$ttotal = 0;
}
 
?>
<tr >
<td>Total : </td>
<?php
	for($y=0;$y<$i;$y++){ ?>
      <td class="text-center"><?php
		if($sum_each[$y]!='') {
	  		echo '('.$sum_each[$y].' / '.$total_each[$y].')';
		}?>&nbsp;</td>
<?php
	}
?>
<td ><?php echo '('.$sum_each[$i+1].' / '.$total_each[$i+1].')'; ?></td>
</tr>
<tbody>	
</table>
</div>

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