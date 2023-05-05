<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
<div class="card">
<div class="card card-banner card-chart card-blue no-br" >
<div class="card-header ">
<div class="card-title">
<div class="title">Sessions by device<!-- การเข้าชมตามอุปกรณ์--></div> 
<div class="title text-right" title="Desktop" data-toggle="tooltip" data-placement="right"><span class="sign"> <i class="fas fa-desktop fa-1x"></i></span> <span class="counter text-large" ><?php echo count_device('1',$con);?></span></div>
<div class="title text-right" title="Tablet" data-toggle="tooltip" data-placement="right"><span class="sign"> <i class="fas fa-tablet-alt fa-1x"></i></span> <span class="counter text-large"><?php echo count_device('2',$con);?></span></div>
<div class="title text-right" title="Mobile" data-toggle="tooltip" data-placement="right"><span class="sign"> <i class="fas fa-mobile-alt fa-1x"></i></span> <span class="counter text-large"><?php echo count_device('3',$con);?></span></div>
</div> 
</div>	 

<div class="card-body" >
<div id='myChartBrowser'></div> 
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
		"font-size":"14px",
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
	    "font-size":"14px",
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
		"margin":"auto auto 1% auto",
		"marker":{
			"border-radius":1,
			"border-width":0
		},
		"item":{
			"color":"%backgroundcolor",
			"font-family":"'Kanit', sans-serif",
			"font-weight":"normal",
			"font-size":"16px"
			}
	},	
series : [
		{
		  values: [<?php echo count_device('1',$con);?>],
		  text: "Desktop",
		  backgroundColor: '#A3E7D8'
		},
		{
		  values: [<?php echo count_device('2',$con);?>],
		  text: 'Tablet',
		  backgroundColor: '#FFBE7D'
		},
		{
		  text: 'Mobile',
		  values: [<?php echo count_device('3',$con);?>],
		  backgroundColor: '#8dcffd'
		}	
	]
};
 
zingchart.render({ 
	"id" : 'myChartBrowser', 
	"data" : myConfig, 
	"height" : '280px', 
	"width" : '100%' 
});

</script>


<!--<div class="text-center col-lg-4 col-md-4 col-sm-4 col-xs-4">
 <div class="content-chart " >
      <div class="value"><span class="sign"> <i class="fas fa-desktop fa-1x"></i></span></div>    
	  <div class="value"><span class="counter">9</span></div>
</div>
</div>
<div class="text-center col-lg-4 col-md-4 col-sm-4 col-xs-4  ">
 <div class="content-chart " >
      <div class="value"><span class="sign"> <i class="fas fa-mobile-alt fa-1x"></i></span></div>
	  <div class="value"><span class="counter ">10</span></div>
</div> 	  
</div> 
<div class=" text-center col-lg-4 col-md-4 col-sm-4 col-xs-4  "> 
 <div class="content-chart " >
	  <div class="value "><span class="sign"> <i class="fas fa-tablet-alt fa-1x"></i></span></div>
	  <div class="value"><span class="counter">1</span></div>
</div> 
</div>--> 



</div>
</div>
</div>
</div>
