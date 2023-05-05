<?php
header ("Content-Type:text/html;Charset=UTF-8");
include("../lib/permission1.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ประกาศจัดซื้อจัดจ้างภาครัฐ</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet">
    
<style>
a:link {
    text-decoration: none;
	color:#000000;
}

a:visited {
    text-decoration: none;
	color:#000000;
}

a:hover {
    text-decoration: none;
	color:#000000;
}

a:active {
   text-decoration: none;
   color:#000000;
}
body {
	font-family: 'Prompt', sans-serif;
	font-size: 16px;
	overflow-x: hidden !important;
	color: #000000;
	padding:0px !important;
	margin:0px !important;
}
.font_ahrf a:link {
   color:#000000;
}
.font_ahrf a:visited {
   color:#000000;
}
.font_ahrf a:hover {
   color:#838282;
}
.font_ahrf a:active {
   color:#838282;
}
.bg_navbar{
	background-color:#FFFFFF;
}
.navbar-inverse .btn-link:focus, .navbar-inverse .btn-link:hover {
     color: #9d9d9d;
	 text-decoration: none;
}
.btn-link, .btn-link:active, .btn-link:focus, .btn-link:hover{
	 color: #000000;	
}
.navbar-inverse .btn-link {
    color: #000000;
}
.navbar {
	   
}
/*--------------------*/
/* MODAL */
/*--------------------*/

.option_doc {
  color:#7F7F7F;
  padding:3px;
}
.layer-modal{
  z-index:3000;
  display:none;
  padding-top:60px;
  position:fixed;
  left:0;
  right:0;
  top:0;
  width:100%;
  height:100%;
  overflow:auto;
  background-color:rgb(0,0,0);
  background-color:rgba(0,0,0,0.4);
}
.form-doc {
  position: relative;
  background-color: #fff;
  -webkit-background-clip: padding-box;
  background-clip: padding-box;
  border: 1px solid rgba(0, 0, 0, .2);
  border-radius: .3rem;
  outline: 0;
}
.card-animate-zoom {
  -webkit-animation:animatezoom 0.6s;
  animation:animatezoom 0.6s;
  }
.pop-header {
    padding: 5px 15px;
    border-bottom: 1px solid #e5e5e5;

}
.pop-title {
    margin: 0;
    line-height: 1.5;
}
.pop-body {
    position: relative;
    padding: 15px;
}
.pop-footer {
    padding: 15px;
    text-align: right;
    border-top: 1px solid #e5e5e5;
}

</style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top bg_navbar">
<div class="container-fluid">
<div class="navbar-header">
<img alt="Brand" src="http://process3.gprocurement.go.th/EPROCRssFeedWeb/images/header_eGP1.jpg">
</div>  
</div>


<div class="row">
<div class="col-sm-12">
<a href="gprocurement.php" target="_self">
<button type="button" class="btn btn-link"  >
<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;<?="Home";?>
</button>
</a>
<a href="gprocurement_type.php" target="_self">
<button type="button" class="btn btn-link  btn-ml"   >
<span class="glyphicon glyphicon-triangle-right"></span>&nbsp;<?="ประเภทประกาศ";?>
</button>
</a>
<a href="gprocurement_process.php" target="_self">
<button type="button" class="btn btn-link  btn-ml" >
<span class="glyphicon glyphicon-triangle-right"></span>&nbsp;<?="วิธีการจัดหา";?>
</button>
</a>	
<a href="gprocurement_dept.php" target="_self">
<button type="button" class="btn btn-link  btn-ml"   >
<span class="glyphicon glyphicon-triangle-right"></span>&nbsp;<?="รหัสหน่วยงานรัฐ";?>
</button>
</a>
<a href="gprocurement_deptsub.php" target="_self">
<button type="button" class="btn btn-link  btn-ml"  >
<span class="glyphicon glyphicon-triangle-right"></span>&nbsp;<?="รหัสหน่วยจัดซื้อย่อย";?>
</button>
</a>
</div>
</div>
</nav>
<?php
$perpage = 10;

if(isset($_GET['page'])){
	$page = $_GET['page'];
	}else{
		$page = 1;
		}

$start = ($page - 1) * $perpage;
?>

<div class="container" style="padding-top: 5cm;"></div>
<div class="container" style="width:95%;">
<div class="col-md-12 col-sm-12 col-xs-12" > 

<div class="panel panel-default">
<div class="panel-heading">
<div class="row" >
<div class="col-md-6 col-sm-6 col-xs-12" >
<h4>วิธีการจัดหา</h4>
</div>
<div class="col-md-6 col-sm-6 col-xs-12"  style="text-align:right;" >
<a  onclick="boxPopup('http://<?php echo $_SERVER['SERVER_NAME']; ?>/ewtadmin86_mots_province_utf8_dev/gprocurement/pop_add_process.php?proc=AddProc');" data-toggle="tooltip" data-placement="right" title="เพิ่มวิธีการจัดหา" >
<button type="button" class="btn btn-success" >
<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;เพิ่มวิธีการจัดหา
</button>
</a>
</div>
</div>
</div>

  <div class="panel-body">
      <table class="table table-bordered">
    <thead>
      <tr>
		<th style="text-align:center;width:5%;">&nbsp;</th>
        <th style="text-align:center;width:15%;">รหัส</th>
        <th style="text-align:center;width:70%;">วิธีการจัดหา</th>
        <th style="text-align:center;width:10%;"></th>
      </tr>
    </thead>
    <tbody>
	<?php
if($start==0){
$i=1;
}else{
$i=$start+1;	
}
$s_feed  = $db->query("SELECT * FROM egp_process  ORDER BY egp_process_id ASC
LIMIT {$start} , {$perpage}");
$a_row = $db->db_num_rows($s_feed);   

$s_feed2 = $db->query("SELECT * FROM egp_process  ORDER BY egp_process_id ASC");
$total_record = $db->db_num_rows($s_feed2);	
$total_page = ceil($total_record / $perpage);	

if($a_row){	
while($a_feed = $db->db_fetch_array($s_feed)){
?>
<tr>
<td style="text-align:center;"><?=$i.".";?></td>
<td style="text-align:center;"><?=$a_feed['egp_process_code'];?></td>
<td><?=$a_feed['egp_process_name'];?></td>
<td></td>
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
<?=pagination($start,$perpage,$total_page,$_SERVER['SCRIPT_NAME'],$page,'&id='.$_GET[id].'');?>
<?php } ?>
</div>
</div>
<div id="box_popup" class="layer-modal"></div>
<footer class="footer panel-footer fix navbar-fixed-bottom">
<div class="container">
<p>© Copyright © 2018, สำนักงานปลัดกระทรวงการท่องเที่ยวและกีฬา เลขที่ 4 ถนนราชดำเนินนอก แขวงวัดโสมนัส เขตป้อมปราบศัตรูพ่าย กรุงเทพฯ 10100</p>
</div>
</footer>
<script>
  function boxPopup(link)
  {
    $.ajax({
      type: 'GET',
      url: link,
      beforeSend: function() {
        $('#box_popup').html('');
      },
      success: function (data) {
        $('#box_popup').html(data);
      }
    });
    $('#box_popup').fadeIn();
  }

</script>
</body>
</html>

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
<script type="text/javascript">
var	url='feedsapar.php';
var data = {t:"page"};
	$.get(url,data,function(req){
	});
	
	
</script>
