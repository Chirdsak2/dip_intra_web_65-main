<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid"  >
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

<h4><?php echo $txt_webboard_menu_main;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?php echo $txt_webboard_menu_main;?></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

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
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<div class="row">
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
<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card">
<div class="card card-banner card-chart  no-br" >
<div class="card-header ">
<div class="card-title">
</div>
</div>
<div class="card-body" >
<div id='myChartBrowser2'></div> 
</div>
</div>
</div>
</div>
</div> 


<div class="row ">
<?php

?>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-blue-light" onclick="self.location.href='webboard_main.php'">
<div class="card-body">
<i class="icon far fa-address-card fa-4x"></i>
    <div class="content">
      <div class="title "><h4><?php echo 'หมวดกระทู้';?></h4></div>
      <div class="value"><span class="sign"></span><span class="counter"><?php echo webboard::getCate();?></span></div>
	  <div class="title"><h5><?php echo $txt_ewt_list;?></h5></div>
    </div>
	<div class="content">
      <div class="title ">	 
	  <i class="far fa-check-circle text-success"></i>
	  <?php echo 'ใช้งาน' ;?> <span class="counter"><span class="sign text-success"><?php echo webboard::getCate('Y');?></span></span> 
	  /
	  <i class="far fa-times-circle text-danger"></i>
	 <?php echo 'ไม่ใช้งาน' ;?> <span class="counter"><span class="sign text-danger"><?php echo webboard::getCate('N');?></span></span> 
	  </div>
    </div>
  </div>
</a>
</div>
<?php

?>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-green-light" onclick="self.location.href='webboard_main.php'"> 
<div class="card-body">
<i class="icon far fa-comment-dots fa-4x"></i>
    <div class="content">
      <div class="title "><h4><?php echo 'กระทู้คำถาม';?></h4></div>
      <div class="value"><span class="sign"></span><span class="counter"><?php echo webboard::getQuestion();?></span></div> 
	  <div class="title"><h5><?php echo $txt_ewt_list;?></h5></div>
    </div>
	<div class="content">
       <div class="title ">	 
	  <i class="far fa-check-circle text-success"></i>
	  <?php echo 'อนุมัติ' ;?> <span class="counter"><span class="sign text-success"><?php echo webboard::getQuestion('1');?></span></span>  
	  /
	  <i class="far fa-times-circle text-danger"></i>
	 <?php echo 'ไม่อนุมัติ' ;?> <span class="counter"><span class="sign text-danger"><?php echo webboard::getQuestion('0');?></span></span> 
	  </div>
    </div>
  </div>
</a>
</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<?php
$a_dataNoti = webboard::getDelnoti();
//print_r($a_dataNoti);
foreach($a_dataNoti as  $_key => $_item)
{
	$count = $a_dataNoti['count'];
}
?>
<a class="card card-banner card-yellow-light"  onclick="self.location.href='webboard_del_noti.php'" title="" data-toggle="tooltip" data-placement="top" data-original-title="คำขอแจ้งลบ ">

<div class="card-body">
<i class="icon far fa-trash-alt fa-4x"></i> 
    <div class="content">
      <div class="title"><h4>คำขอแจ้งลบ<!--  คำขอแจ้งลบ   --></h4></div> 
      <div class="value"><span class="sign"></span><span class="counter"><?php echo $count;?></span></div> 
		<div class="title"><h5><?php echo $txt_ewt_list;?></h5></div>
	</div>
	<div class="content">
       <div class="title ">	 
	  <i class="far fa-question-circle text-success"></i>
	  <?php echo 'กระทู้คำถาม' ;?> <span class="counter"><span class="sign text-success"><?php echo webboard::getDelnoti('T')['count'];?></span></span> 
	  /
	  <i class="far fa-comment-dots text-danger"></i>
	 <?php echo 'ความคิดเห็น' ;?> <span class="counter"><span class="sign text-danger"><?php echo webboard::getDelnoti('A')['count'];?></span></span> 
	  </div>
    </div>
  </div>
</a>

</div>


</div>



</div>
</div>

</div>
<!--END card-body-->
</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE ".$EWT_DB_NAME);
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
"title": {
        "text": "สถิติผู้เข้าชมตามหมวดกระทู้",
		"font-family":"'Sarabun', sans-serif",
		"font-weight":"bold",
		"font-size":"18px",
      },	
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
		"text":"%t: %v",
		"font-family":"'Sarabun', sans-serif",
		"font-weight":"normal",
		"font-size":"16px",
		},
	"valueBox": {
		"placement": 'out',
 	    "text": '%t : %v : \n%npv% ',
 	    "font-family":"'Sarabun', sans-serif",
		"font-weight":"normal",
	    "font-size":"16px",
 	  },
	"value-box": {
          "text": "%pie-total-value",
          "placement": "center",
          "font-color": "black",
          "font-size": "12px",
          "font-family": "'Sarabun', sans-serif",
          "font-weight": "normal", 
          "rules": [{
            "rule": "%p != 0",
            "visible": false
          }] 
	},	  
	"animation":{
		"effect":"2",
		"method":"9",
		"sequence":"ANIMATION_BY_PLOT",
		"speed":"ANIMATION_FAST"
		},
},
"legend":{
		"highlight-plot": true,
		"background-color":"none",
		"border-width":0,
		"shadow":false,
		"layout":"float",
		"margin":"auto auto 1% auto",
		"marker":{
			"border-radius":2,
			"border-width":0
		},
		"item":{
			"color":"%backgroundcolor",
			"font-family":"'Sarabun', sans-serif",
			"font-weight":"normal",
			"font-size":"13px"
			}
	},
series : [

	{ 
		values: [1], 
		text:"แลกเปลี่ยนความคิดเห็น - ความรู้", 
		backgroundColor: '#A3E7D8'
	},
	{ 
		values: [2], 
		text:"ห้องแห่ง PRD",  
		backgroundColor: '#B0C4DE'
	}
	]
};
 
zingchart.render({ 
	"id" : 'myChartBrowser', 
	"data" : myConfig, 
	"height" : '350px', 
	"width" : '100%' 
});


var myConfig2 = {
"title": {
        "text": "กระทู้คำถาม",
		"font-family":"'Sarabun', sans-serif",
		"font-weight":"bold",
		"font-size":"18px",
      },
	
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
		"text":"%t: %v",
		"font-family":"'Sarabun', sans-serif",
		"font-weight":"normal",
		"font-size":"16px",
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
		},
},
"legend":{
		"highlight-plot": true,
		"background-color":"none",
		"border-width":0,
		"shadow":false,
		"layout":"float",
		"margin":"auto auto 1% auto",
		"marker":{
			"border-radius":2,
			"border-width":0
		},
		"item":{
			"color":"%backgroundcolor",
			"font-family":"'Sarabun', sans-serif",
			"font-weight":"normal",
			"font-size":"13px"
			}
	},	
series : [

	{ 
		values: [1], 
		text:"ตอบกลับแล้ว", 
		backgroundColor: '#8dcffd'
	},
	{ 
		values: [2], 
		text:"ยังไม่ได้ตอบกลับ",  
		backgroundColor: '#FF8C00'
	}
	]
};
zingchart.render({ 
	"id" : 'myChartBrowser2', 
	"data" : myConfig2, 
	"height" : '350px', 
	"width" : '100%' 
});

</script>                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
</style>
     