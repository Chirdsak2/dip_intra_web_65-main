<?php
include("admin.php");
include_once ("../src_jpgraph/jpgraph.php");
include ("../src_jpgraph/jpgraph_bar.php");
include ("../src_jpgraph/jpgraph_canvas.php");
##create grate
$color = array("","#CC9933","#CCCC00","#66CCFF","#00CC66","#FF99CC","#FF9933");
$i=0;
$y_datapie=array();
$data=array();
$data1=array();
$data2=array();
$data3=array();
$data4=array();
$data5=array();
$data6=array();
$data7=array();$data8=array();
$data9=array();
$data10=array();
$count_to=array();
$x=1;
for($i=1;$i<=$total;$i++){
$count_to[] .= $i;
}
$i=1;
	if($start_date == "" AND $end_date == ""){
			$con = "";
			}elseif($start_date != "" AND $end_date == ""){
			$st = explode("/",$start_date);
			$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
			}elseif($start_date == "" AND $end_date != ""){
			$st = explode("/",$end_date);
			$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
			}else{
			$st = explode("/",$start_date);
			$en = explode("/",$end_date);
			$con = " AND (date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
			}
		
$sql = "select * from poll_ans where c_id = '".$_GET["c_id"]."'";
$query = $db->query($sql);

array_push($data,0);

while($rec = $db->db_fetch_array($query)){

array_push($y_datapie,$color[$x]);
$sql_aws = "select count(*) as num from poll_log where c_id = '".$_GET["c_id"]."' and a_id = '".$rec[a_id]."' $con ";
$rec_aws = $db->db_fetch_array($db->query($sql_aws));

if($_GET["total"] == 0){ $b='';}else{
array_push($data,$rec_aws[num]);
	/*for($v=1;$v<=$total;$v++){
	
		if($v == $rec_aws[num]){
		array_push(${"data".$i},($rec_aws[num]*100)/$_GET["total"]);
		}else if($v > $rec_aws[num]){
		array_push(${"data".$i},'');
		}else{
		array_push(${"data".$i},0);
		}
	}*/
}
$a[$i] = $rec[a_name];
//$data[$i] = $b;
$num[$i] = $rec_aws[num];
$i++;
$x++;
}


?>
