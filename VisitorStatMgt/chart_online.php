<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>

<div id='myChart'></div>
<script>
var startTime = (new Date().getTime());
var myConfig = {
  //chart styling
  type: 'line',
  globals: {
      "font-family":"'Kanit', sans-serif",
  },
  backgroundColor: '#fff',
  
  crosshairX: {
    lineWidth: 1,
    lineStyle: 'dashed',
    lineColor: '#424242',
    marker : {
	    visible : true,
        size : 9
	  },
    plotLabel: {
      backgroundColor: '#fff',
      borderColor: '#e3e3e3',
      borderRadius:1,
      padding:5,
      fontSize: 13,
      shadow : true,
	    shadowAlpha : 0.2,
	    shadowBlur : 5,
	    shadowDistance : 4,
    },
    scaleLabel: {
      backgroundColor: '#424242',
      padding:0
    }
  },
  utc: true,
  timezone: -5,
  scaleX:{
    minValue: startTime,
    step: 1000, 
    transform:{ 
      type: 'date',
      all: '%D, %d %M %Y<br>%h:%i:%s %a'
	  }
},
/*scaleX :{
 	  step: 'year',
 	  transform:{
 	    type: 'date',
 	    all: '%h:%i:%s %a'
    },
	label: {
 	    text: 'ms'
 	  }
},*/
 scaleY:{
 	  label: {
 	    text: 'Active Users right now'
 	  }
 	},
  
  tooltip: {
    visible: false
  },
  
  //real-time feed
  refresh: {
    type: 'feed',
    transport: 'js',
    url: 'feed()',
    interval: 500
  },
  plot: {
    shadow: 1,
    shadowColor: '#eee',
    shadowDistance: '10px',
    lineWidth:5,
    hoverState: {visible: false},
    marker:{ visible: false},
    aspect:'spline'
  },
  series: [{
    values: [],
    lineColor: '#2196F3',
    //text: 'ผู้เข้าชมเว็บไซต์ที่ใช้งานอยู่'
	text: 'Active Users right now'
  }]
};
 
zingchart.render({
  id: 'myChart',
  data: myConfig,
  height: '280px',
  width: '100%'
});
 
//real-time feed random math function
window.feed = function(callback) {
  var tick = {};
  tick.plot0 = $('#so_session').val();
  callback(JSON.stringify(tick));
  //console.log(<?php echo $_row; ?>);
  //alert(parseInt(10 + 90 * Math.random(), 10));
};

</script>
