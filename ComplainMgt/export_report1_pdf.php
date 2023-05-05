<?php 
include("../EWT_ADMIN/comtop_pop.php");


function FuncStatus($Id){
	if($Id == 'M')
	{
		$a_data = 'เจ้าหน้าที่ติอต่อกลับ';
	}
	else if($Id == 'S')
	{
		$a_data = 'รับเรื่องแล้ว';
	}	
	else
	{
		$a_data = '';		
	}
		return $a_data;
}
function FuncInfo($ID){
	global $db;
	if($ID)
	{
	$_sql = $db->query("SELECT 
						* 						
						FROM m_complain_info 
						WHERE Complain_lead_ID = '{$ID}' {$wh} 
					");
	$a_data = $db->db_fetch_array($_sql);
	return 'หมวด : '.$a_data['Complain_lead_name'];
	}
}
function FuncCount($ID,$wh){
	global $db;
	if($ID)
	{
	$statement = "SELECT count(id) AS b FROM m_complain  WHERE flag = '{$ID}' {$wh}  ";		
	$s_count = $db->query($statement);
	$a_count = $db->db_fetch_array($s_count);
	$total_record = $a_count['b'];
	return $total_record;
	}
}

$start_date = (!isset($_GET['start_date']) ? '' : $_GET['start_date']);
$end_date = (!isset($_GET['end_date']) ? '' : $_GET['end_date']);
  
if(!empty($start_date))
{	
	if(!empty($end_date))
	{
		$wh = " AND date BETWEEN '".$start_date."' AND '".$end_date."'";  
	}
	else
	{
		$wh = " AND date = '".$start_date."' ";
	}	
} 
$_sql = $db->query("SELECT *
					FROM m_complain_info
					WHERE Complain_status_use = '' 
					{$wh} 
					ORDER BY Complain_lead_ID DESC"); 


$contents = '<div class="container" >   
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  > 
<h5 class="text-center">รายงานสถิติเรื่องร้องเรียน</h5>	 
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
	<div class="table-responsive">     
	<table class="table table-striped" border="1" x:str>   
    <thead>
      <tr>
	    <th class="text-center" style="width:5%;">ลำดับที่</th>
        <th class="text-center" style="width:40%;">หมวดเรื่องร้องเรียน</th> 
        <th class="text-center" style="width:20%;">จำนวน(เรื่อง)</th>
      </tr>
    </thead>';

	$i=1;
	while($a_data = $db->db_fetch_array($_sql))
	{

	$contents .= '	<tbody> 
					<tr>
					<td class="text-center">'.$i.'</td>
					<td>'.$a_data['Complain_lead_name'].'</td>
					<td>'.FuncCount($a_data['Complain_lead_ID'],$wh).'</td>
					</tr>	
					</tbody>';

				$i++;
	}

	$contents .='</table>	
	</div>
</div>
</div>
</div>';

require_once("../libraries/mpdf/mpdf.php");   

 
$mpdf = new mPDF('th', 'A4', '0', 'thsarabun',$margin_left,$margin_right,$margin_top,$margin_bottom,$margin_header,$margin_footer); 

//$mpdf->SetHTMLHeader($header_pdf); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;


$db->db_close(); 

	
?>