<?php
include("../EWT_ADMIN/comtop.php");
$c_id = (int)(!isset($_GET['c_id']) ? 0 : $_GET['c_id']);
$no = $_GET['no'];
$s_poll = $db->query("select * from poll_cat where c_id = '{$c_id}' "); 
$a_data = $db->db_fetch_array($s_poll);
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
?> 
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo 'สถิติการสำรวจความคิดเห็น';?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="poll_list.php"><?php echo $txt_poll_menu_main;?></a></li> 
<li><?php echo 'สถิติการสำรวจความคิดเห็น';?>  </li> 
</ol>
</div> 

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

<a href="poll_list.php?c_id=<?php echo $c_id;?>" target="_self" title="ย้อนกลับ">
<button type="button" class="btn btn-info  btn-ml ">
<i class="fas fa-undo-alt"></i>&nbsp;ย้อนกลับ</button> 
</a>

</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->
 
<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left color-white">
<p><i class="fas fa-comment-dots color-white fa-1x" aria-hidden="true"></i>
<?php echo 'สถิติการสำรวจความคิดเห็น';?></p>
</div>
</div>
<div class="card-body m-b-sm">
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
	<h4 class="text-dark"><?php echo $a_data['c_name'];?></h4>
	<p class="text-dark">วันที่ : <?php echo $a_data['c_start'];?> ถึงวันที่ <?php echo $a_data['c_stop'];?> </p>     
	<p class="text-dark"> รายละเอียด : <?php echo $a_data['c_detail'];?></p>
	<table class="table table-striped"> 
    <thead>
      <tr>
        <th class="text-center" style="width:60%;">คำตอบ</th> 
        <th class="text-center">จำนวนคนที่ตอบ(คน)</th> 
      </tr>
    </thead>
    <tbody>
	<?php
	$s_ans = $db->query("SELECT * FROM poll_ans WHERE c_id = '{$c_id}' ORDER BY a_position ASC"); 
	while($a_data_ans = $db->db_fetch_array($s_ans))
	{
	?>
      <tr>
        <td><?php echo $a_data_ans['a_name'];?></td>
        <td class="text-center"><?php echo $a_data_ans['a_counter'];?> </td>      
      </tr>
	<?php
	$total += $a_data_ans['a_counter'];
	}
	?>
	<tr>
        <td>รวม</td>
        <td class="text-center" ><?php echo $total;?></td>      
      </tr>
    </tbody>
  </table>

</div>
<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card">
<div class="card card-banner card-chart  no-br" >
<div class="card-header ">
<div class="card-title">
</div>
</div>
<div class="card-body" >
<div id='myChartBrowser'></div> 

</div>
</div>
</div>
</div>


</div> 
</div>
			
</div>
</div>



</div>
<!--END card-body -->
</div>
<!--END card -->

</div>
</div>

</div>
<?php   
	$a_pollans = array();
	$s_ans = $db->query("SELECT * FROM poll_ans WHERE c_id = '{$c_id}' ORDER BY a_position ASC"); 
	while($a_data_ans = $db->db_fetch_array($s_ans)) 
	{
			array_push($a_pollans,array(
			"a_name"  		=> $a_data_ans['a_name'],
			"a_counter" 	=> $a_data_ans['a_counter'],
			"a_color" 		=> $a_data_ans['a_color']		 			
			));		
	}
?>	 	
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script src= "../chart/zingchart_2.3.2/zingchart.min.js"></script>
<script>
zingchart.MODULESDIR='../chart/zingchart_2.3.2/modules/'
ZC.LICENSE = ["24fa905934561fc198cc36fb29177d4a"];
</script>
<style>
	.zc-style.zc-license{display:none}
</style>
<script>
var myConfig = {
	
"type": "ring", 
"plot": {
	"highlight-state": {
		//"background-color": "#999999 #999999",
		//"border-width": 5,
		//"border-color": "#666666",
		"line-style": "solid",
		"font-family":"'Sarabun', sans-serif",
		"font-weight":"normal",
		"font-size":"16px",
		"placement":"out",
		},
	"tooltip":{
		"text":"%t: %v"
		},
	"valueBox": {
		"placement": 'out',
 	    "text": '%t : %v : \n%npv% ',
 	    "font-family":"'Sarabun', sans-serif",
		"font-weight":"normal",
	    "font-size":"16px",
 	  },
	"animation":{
		"effect":"2",
		"method":"9",
		"sequence":"ANIMATION_BY_PLOT",
		"speed":"ANIMATION_FAST"
		}
},	
"legend":{
		"highlight-plot": true,
		"background-color":"none",
		"border-width":0,
		"shadow":false,
		"layout":"float",
		"margin":"1% auto 1% auto",
		"marker":{
			"border-radius":2,
			"border-width":1
		},
		"item":{
			"color":"%backgroundcolor",
			"font-family":"'Sarabun', sans-serif",
			"font-weight":"normal",
			"font-size":"16px"
			}
	},	
series : [
<?php
if($a_pollans) 
{
	$i = 0;
	foreach((array)$a_pollans as $_item)
	{	  
?>	
	{ 
		values: [ <?php echo  $_item['a_counter'];?>], 
		text:"<?php echo  $_item['a_name'];?>", 
		backgroundColor: '<?php echo  $_item[a_color];?>'
	},
<?php 
	} 
}
?>
	]
};
 
zingchart.render({ 
	"id" : 'myChartBrowser', 
	"data" : myConfig, 
	"height" : '350px', 
	"width" : '100%' 
});

</script>
<script>



</script>