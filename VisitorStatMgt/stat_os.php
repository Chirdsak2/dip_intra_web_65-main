<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card ">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
<div class="title" >ระบบปฏิบัติการ (Operating System)</div>

<div class="title" ><i class="fas fa-hashtag"></i> Top 5
</div>
</div>
</div>
<div class="card-body" id="tabos">
<ul class="list-group">
<?php
$s_isp = $db->query("SELECT sv_os,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_os != '' {$con} 
GROUP BY sv_os 
ORDER BY ct DESC LIMIT 0,5");

while($a_isp = $db->db_fetch_row($s_isp)){
?>
<li class="list-group-item "><?=$a_isp[0];?><span class="badge badge-success"><?=$a_isp[1];?></span></li>

<?php } ?>
</ul>
<!--<ul class="nav nav-tabs">
    <li class="active"><a href="#tabos-1" title="chart-pie"><i class="fas fa-chart-pie fa-2x"></i></a></li>
    <li ><a href="#tabos-2" title="chart-bar"><i class="fas fa-chart-bar fa-2x"></i></a></li>
    <li ><a href="#tabos-3" title="chart-line"><i class="fas fa-chart-line fa-2x"></i></a></li>
    <li ><a href="#tabos-4" title="chart-area"><i class="fas fa-chart-area fa-2x"></i></i></a></li>
</ul>-->
<!--<div>


<div id="tabos-1">
<div id='myChartOS'></div>
<script>
var myConfig = {
	"type": "pie", 
 	
	"plot": {
	"highlight-state": {
      "background-color": "#999999 #999999",
      "border-width": 5,
      "border-color": "#666666",
      "line-style": "solid",
	  "font-family":"'Kanit', sans-serif",
	  "font-weight":"normal",
	  "font-size":"14px",
	  "placement":"out",
    },
	"tooltip":{
			"text":"%t: %v"
			},
	"valueBox": {
 	    "placement": 'out',
 	    "text": '%t\n%npv%',
 	    "font-family":"'Kanit', sans-serif",
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
 	
 	
	series : [
		{
			values : [11.38],
			text: "Windows 10",
		  backgroundColor: '#50ADF5',
		},
		{
		  values: [56.94],
		  text: "Android",
		  backgroundColor: '#FF7965'
		}
	]
};
 
zingchart.render({ 
	"id" : 'myChartOS', 
	"data" : myConfig, 
	"height" : '100%', 
	"width" : '100%' 
});

</script>
</div>

<div id="tabos-2">
<div id='myChartbar'></div>

<script>
var myConfigbar = {
"type":"bar",
"title":{
        "text":"<?=$R['graph_subject'];?>",
        "font-family":"'Kanit', sans-serif",
        "font-weight":"normal",
        "font-size":"18px",
        "text-color":"#000000",	
		
    },
"subtitle":{
    "text":"<?=$R['graph_description'];?>",
	"font-family":"'Kanit', sans-serif",
    "font-weight":"normal",
	"font-size":"14px",
  },
"legend":{
		"highlight-plot": true,
        "font-family":"'Kanit', sans-serif",
        "background-color":"none",
        "border-color":"none",
        "item":{
		"font-color":"#825634",
		"font-family":"'Kanit', sans-serif",
		"font-weight":"normal",
		"font-size":"13px",
        },
		"margin-right":"1%",
		"margin-top":"100%",
        //"y":"10%",
        //"width":"100%",
        //"shadow":0,
   },
"plot": {
    "value-box": {
      "text": "%v",
      "font-family":"'Kanit', sans-serif",
      "font-color":"#FFFFFF",
      "font-weight": "normal",
      "rules": [
	  {
        "rule": "%v < 9000",
        "placement": "top-in",
      },{
        "rule": "%v > 9000",
        "placement": "top-in",
		"angle": -90,
      }]
    },
  },   
"scale-x":{ 
	"label":{
      "text":"<?=$R['graph_x'];?>",
	  "font-size":"16px",  
	  "font-family":"'Kanit', sans-serif",

    },
	"labels":[<?=$graph_title_x ?>],
	"item":{
		  "font-size":"13px",  
	      "font-family":"'Kanit', sans-serif",
		  },
   },
"scale-y":{ 
	"label":{
      "text":"<?=$R['graph_y'];?>",
	  "font-size":"16px",  
	  "font-family":"'Kanit', sans-serif",
    },
	"item":{
		  "font-size":"13px",  
	      "font-family":"'Kanit', sans-serif",
		  },
},
"plotarea":{
		"margin-left":"8%"
	},

"series":[	   
	{
	   "values":[<?=$values[$i];?>],
	   "text":"<?=$ytitle[$i];?>",
	   
	   "background-color":"<?=$ycolor[$i];?>",
	   "tooltip":{
                "background-color":"<?=$ycolor[$i];?>",
                "text":"<?=$ytitle[$i];?> : %v",
                "font-size":"16px",
                "font-family":"'Kanit', sans-serif",
                "padding":"6 12",
                "border-color":"none",
                "shadow":0,
                "border-radius":5
            }
	   },

		   ]};
 
zingchart.render({ 
	id : 'myChartbar', 
	data : myConfigbar, 
	height: '100%', 
	width: '100%' 
});
</script>	

</div>


<div id="tabos-3">
<div id='myChartline'></div>

<script>
var myConfigline = {
"type":"bar",
"title":{
        "text":"<?=$R['graph_subject'];?>",
        "font-family":"'Kanit', sans-serif",
        "font-weight":"normal",
        "font-size":"18px",
        "text-color":"#000000",	
		
    },
"subtitle":{
    "text":"<?=$R['graph_description'];?>",
	"font-family":"'Kanit', sans-serif",
    "font-weight":"normal",
	"font-size":"14px",
  },
"legend":{
		"highlight-plot": true,
        "font-family":"'Kanit', sans-serif",
        "background-color":"none",
        "border-color":"none",
        "item":{
		"font-color":"#825634",
		"font-family":"'Kanit', sans-serif",
		"font-weight":"normal",
		"font-size":"13px",
        },
		"margin-right":"1%",
		"margin-top":"100%",
        //"y":"10%",
        //"width":"100%",
        //"shadow":0,
   },
"plot": {
    "value-box": {
      "text": "%v",
      "font-family":"'Kanit', sans-serif",
      "font-color":"#FFFFFF",
      "font-weight": "normal",
      "rules": [
	  {
        "rule": "%v < 9000",
        "placement": "top-in",
      },{
        "rule": "%v > 9000",
        "placement": "top-in",
		"angle": -90,
      }]
    },
  },   
"scale-x":{ 
	"label":{
      "text":"<?=$R['graph_x'];?>",
	  "font-size":"16px",  
	  "font-family":"'Kanit', sans-serif",

    },
	"labels":[<?=$graph_title_x ?>],
	"item":{
		  "font-size":"13px",  
	      "font-family":"'Kanit', sans-serif",
		  },
   },
"scale-y":{ 
	"label":{
      "text":"<?=$R['graph_y'];?>",
	  "font-size":"16px",  
	  "font-family":"'Kanit', sans-serif",
    },
	"item":{
		  "font-size":"13px",  
	      "font-family":"'Kanit', sans-serif",
		  },
},
"plotarea":{
		"margin-left":"8%"
	},

"series":[	   
	{
	   "values":[<?=$values[$i];?>],
	   "text":"<?=$ytitle[$i];?>",
	   
	   "background-color":"<?=$ycolor[$i];?>",
	   "tooltip":{
                "background-color":"<?=$ycolor[$i];?>",
                "text":"<?=$ytitle[$i];?> : %v",
                "font-size":"16px",
                "font-family":"'Kanit', sans-serif",
                "padding":"6 12",
                "border-color":"none",
                "shadow":0,
                "border-radius":5
            }
	   },

		   ]};
 
zingchart.render({ 
	id : 'myChartline', 
	data : myConfigline, 
	height: '100%', 
	width: '100%' 
});
</script>	

</div>


</div>-->
<!--<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more" class="hi-icon hi-icon-list text-dark" title="View more" onclick="boxPopup('<?=linkboxPopup();?>pop_stat_os.php');">View more</a>
</div>-->
</div>

				
</div>

</div>