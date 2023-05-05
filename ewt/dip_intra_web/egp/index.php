<?php
include("top.php");

function chg_date($date){
		$d=explode("-",$date);
		$date=$d[2];
		$month=$d[1];
		$year= ($d[0]+543);
		return $date."-".$month."-".$year;
}

$perpage = 10;

if(isset($_GET['page'])){
	$page = $_GET['page'];
	}else{
		$page = 1;
		}

$start = ($page - 1) * $perpage;
?>
<div class="container" style="padding-top: 0cm;"></div>

<div class="container" style="width:95%;">
<h2></h2>
<div class="col-md-12 col-sm-12 col-xs-12" > 
<div class="panel panel-default">
<div class="panel-body">
  <form name="form1" method="GET">
    <div class="form-group" >
	<div class="col-md-6 col-sm-6 col-xs-12" > 
      <label for="type">เลือกประเภทประกาศ<span class="text-danger"></span>  :</label>
      <select class="form-control" id="type" name="type" >
        <option value=""selected="" _disabled="disabled" >เลือกประเภทประกาศ</option> 
        <?php $s_egp_type  = $db->query("SELECT * FROM egp_type  ORDER BY egp_type_id ASC"); 
		while($a_row = $db->db_fetch_array($s_egp_type)){
		$sel = ($a_row["egp_type_code"] == trim($_GET['type'])) ? "selected":"";
		?>
		<option value="<?=$a_row["egp_type_code"]; ?>" <?=$sel; ?>><?=$a_row["egp_type_name"]; ?>( <?=$a_row["egp_type_code"]; ?> )</option>
		<?php } ?>
      </select>
	  </div>
	  <div class="col-md-6 col-sm-6 col-xs-12" > 
      <label for="pro">เลือกวิธีการจัดหา<span class="text-danger"></span> :</label>
      <select class="form-control" id="pro" name="pro" >
         <option value=""selected="" _disabled="disabled" >เลือกวิธีการจัดหา</option> 
        <?php $s_egp_process  = $db->query("SELECT * FROM egp_process  ORDER BY egp_process_id ASC"); 
		while($a_process = $db->db_fetch_array($s_egp_process)){
		$sel1 = ($a_process["egp_process_code"] == trim($_GET['pro'])) ? "selected":"";
		?>
		<option value="<?=$a_process["egp_process_code"]; ?>" <?=$sel1; ?>><?=$a_process["egp_process_name"]; ?>( <?=$a_process["egp_process_code"]; ?> )</option>
		<?php } ?>
      </select>
	  </div>
	  <div class="col-md-6 col-sm-6 col-xs-12" > 
	   <label for="date_start">ตั้งแต่วันที่  :</label>
      <div class='input-group date ' id='datetimepicker' >
                     <input name="date_start" id="date_start" type="text"  class="form-control form-control-sm " value="<?=$_GET['date_start'];?>" readonly="readonly" />
                    <span class="input-group-addon " for="date_start" data-date="date_start">
                         <a href="#date" onClick="return showCalendar('date_start', 'dd-mm-y');" ><span class="glyphicon glyphicon-calendar"></span></a>
                    </span>
                </div>
	  </div>
	  <div class="col-md-6 col-sm-6 col-xs-12" > 
	   <label for="date_end">ถึงวันที่  :</label>
      <div class='input-group date ' id='datetimepicker1'  >
                     <input name="date_end" id="date_end" type="text"  class="form-control form-control-sm" value="<?=$_GET['date_end'];?>" readonly="readonly" />
                    <span class="input-group-addon " for="date_end" data-date="date_end">
                         <a href="#date" onClick="return showCalendar('date_end', 'dd-mm-y');" ><span class="glyphicon glyphicon-calendar"></span></a>
                    </span>
                </div>
	  </div>
	  <div class="clearfix">&nbsp;</div>
	  <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;" > 
	  <input name="ID" id="ID" type="hidden" value="<?=$_GET['ID']?>" />
	  <button type="submit" class="btn btn-success">ค้นหา</button>
	 </div>
    </div>
  </form>
</div>
</div>
</div>
</div>
<div class="container" style="width:95%;">
<div class="col-md-12 col-sm-12 col-xs-12" > 
<?php if($_GET['ID']){	?>
<div class="panel panel-default">
<div class="panel-heading">
<h4>ประกาศจัดซื้อจัดจ้าง</h4>
</div>
<div class="panel-body">
<table class="table table-bordered">
    <thead>
      <tr>
		<th style="text-align:center;width:5%;">&nbsp;</th>
        <th style="text-align:center;width:75%;">รายการประกาศ</th>
		<th style="text-align:center;width:10%;">วันที่</th>
        <th style="text-align:center;width:10%;">รายละเอียด</th>
	
      </tr>
    </thead>
    <tbody>
<?php

if($start==0){
$i=1;
}else{
$i=$start+1;	
}

$wh1 ="WHERE 1=1 ";
if($_GET['ID']){	
$wh1 .="AND egp_list_dept = '".$_GET['ID']."' ";
}
if($_GET['type']){	
$wh1 .="AND egp_list_type = '".$_GET['type']."' ";
}
if($_GET['pro']){	
$wh1 .="AND egp_list_process ='".$_GET['pro']."' ";
}


if($_GET['date_start'] != '' && $_GET['date_end'] != '' ){
			$st = stripslashes(htmlspecialchars(trim($_GET['date_start']),ENT_QUOTES));
			$st = explode("/",$st );
			$st = ($st[2]-543)."-".$st[1]."-".$st[0];
			if($st_time != ''){ $st  .= ' '.$st_time; }
			$et = stripslashes(htmlspecialchars(trim($_GET['date_end']),ENT_QUOTES));
			$et = explode("/",$et );
			$et = ($et[2]-543)."-".$et[1]."-".$et[0];
			
			$wh1 .= "AND  (egp_list_pubdate  BETWEEN '".$st."' AND '".$et."'  )";
		}

$s_feed  = $db->query("SELECT * FROM egp_list $wh1  ORDER BY egp_list_pubdate DESC
LIMIT {$start} , {$perpage}");
$a_row = $db->db_num_rows($s_feed);   

//echo "SELECT * FROM egp_list $wh1  ORDER BY egp_list_id ASC";

$s_feed2 = $db->query("SELECT * FROM egp_list $wh1  ORDER BY egp_list_id ASC");
$total_record = $db->db_num_rows($s_feed2);	
$total_page = ceil($total_record / $perpage);	

if($a_row){	
while($a_feed = $db->db_fetch_array($s_feed)){
?>
<tr>
<td style="text-align:center;"><?=$i.".";?></td>
<td style="text-align:left;"><?=$a_feed['egp_list_title'];?></td>
<td style="text-align:left;"><?=chg_date($a_feed['egp_list_pubdate']);?></td>
<td>
<a  onclick="boxPopup('http://<?php echo $_SERVER['SERVER_NAME']; ?>/ewtadmin86_mots_province_utf8_dev/ewt/phetchabun/egp/pop_system.php?id=<?=$a_feed['egp_list_id']; ?>');" data-toggle="tooltip" data-placement="right" title="ดูรายละเอียดประกาศ" >
<button type="button" class="btn btn-info" >
<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;ดูข้อมูล
</button>
</a>
</td>
</tr>
<?php	  
	$i++;
	}
}
?>
</tbody> 
</table>  
</div>
</div>
<?php if($a_row){ ?>
<?=pagination($start,$perpage,$total_page,$_SERVER['SCRIPT_NAME'],$page,'&ID='.$_GET['ID'].'&type='.$_GET['type'].'&pro='.$_GET['pro'].'&date_start='.$_GET['date_start'].'&date_end='.$_GET['date_end'].'');?>
<?php } } ?>
</div>
</div>
<?php
function pagination($start,$perpage,$total_page,$_SERVER,$page,$wh){
	global $db;
	
$txt ="";				
$txt .="<div align=\"center\" >".PHP_EOL;
$txt .="<nav aria-label=\"Page navigation\" >".PHP_EOL;
$txt .="<ul class=\"pagination\" style=\"padding-top:2px;padding-bottom:40px;\">".PHP_EOL;

if($page == '1'){
	$disabledprevioust = 'disabled';
}else{
	$previous1 = "href=".$_SERVER."?page=1".$wh;
	$previous2 = "href=".$_SERVER."?page=".($page - 1).$wh;
}
		  
$txt .="<li class=\"previous ".$disabledprevioust."\">";
$txt .="<a ".$previous1." aria-label=\"Previous\">";
$txt .="<span aria-hidden=\"true\"> &laquo; </span> <span class=\"hidden-xs\"> หน้าแรก </span>";
$txt .="</a>";
$txt .="</li>".PHP_EOL;

$txt .="<li class=\"previous ".$disabledprevioust."\">";
$txt .="<a ".$previous2." aria-label=\"Previous\">";
$txt .="<span aria-hidden=\"true\"> &lt; </span> <span class=\"hidden-xs\"> ก่อนหน้านี้ </span>";
$txt .="</a>";
$txt .="</li>".PHP_EOL;
	
for($i=1;$i<=$total_page;$i++){ 
	if($page == $i){ 
	
$txt .="<li class=\"active\"><a href=\"".$_SERVER."?page=".$i.$wh."\">".$i."</a></li>".PHP_EOL;
 }else{ 
$txt .="<li ><a href=\"".$_SERVER."?page=".$i.$wh."\">".$i."</a></li>".PHP_EOL;
} 
	} 
	
if($page == $total_page){		
	$disablednext = 'disabled';
	$next1 = "";
	$next2 = "";
}else{
	$next1 = "href=".$_SERVER."?page=".($page + 1).$wh;
	$next2 = "href=".$_SERVER."?page=".$total_page.$wh;
}

$txt .="<li class=\"next ".$disablednext."\">";
$txt .="<a ".$next1." aria-label=\"Next\">";
$txt .="<span class=\"hidden-xs\">หน้าถัดไป</span><span aria-hidden=\"true\">  &gt; </span>";
$txt .="</a>";
$txt .="</li>".PHP_EOL;

$txt .="<li class=\"next ".$disablednext."\">";
$txt .="<a ".$next2." aria-label=\"Next\">";
$txt .="<span class=\"hidden-xs\">หน้าท้ายสุด</span> <span aria-hidden=\"true\">  &raquo; </span>";
$txt .="</a>";
$txt .="</li>";
$txt .="</ul>".PHP_EOL;
	  
$txt .="</nav>".PHP_EOL;
$txt .="</div>".PHP_EOL;

return $txt;
}
?>
<?php 
include("footer.php");
?>