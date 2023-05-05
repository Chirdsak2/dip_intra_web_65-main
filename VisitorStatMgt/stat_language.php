<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title ">
<div class="title text-left" >
ภาษาที่ใช้ (Accept Language)</div> 
<div class="title text-right" ><i class="fas fa-hashtag"></i> Top 5</div>
</div>
</div>
<div class="card-body">
<ul class="list-group">
<?php
$s_isp = $db->query("SELECT sv_language,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_language != '' {$con} 
GROUP BY sv_language 
ORDER BY ct DESC LIMIT 0,5");

while($a_isp = $db->db_fetch_row($s_isp)){
?>
<li class="list-group-item "><?=$a_isp[0];?><span class="badge badge-success"><?=$a_isp[1];?></span></li>

<?php } ?>
</ul>


<!--<ul class="nav nav-tabs">
    <li class="active"><a ><i class="fas fa-chart-pie fa-2x"></i></a></li>
    <li><a ><i class="fas fa-chart-bar fa-2x"></i></a></li>
    <li><a ><i class="fas fa-chart-line fa-2x"></i></a></li>
    <li><a ><i class="fas fa-chart-area  fa-2x"></i></i></a></li>
</ul>-->
<!--<div>
<div _id='myChartLang'></div>
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
			text: "Internet Explorer",
		  backgroundColor: '#50ADF5',
		},
		{
		  values: [56.94],
		  text: "Chrome",
		  backgroundColor: '#FF7965'
		},
		{
		  values: [14.52],
		  text: 'Firefox',
		  backgroundColor: '#FFCB45'
		},
		{
		  text: 'Safari',
		  values: [9.69],
		  backgroundColor: '#6877e5'
		},
		{
		  text: 'Other',
		  values: [7.48],
		  backgroundColor: '#6FB07F'
		}
	]
};
 
zingchart.render({ 
	"id" : 'myChartLang', 
	"data" : myConfig, 
	"height" : '100%', 
	"width" : '100%' 
});

</script>
</div>-->
<!--<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more" class="hi-icon hi-icon-list text-dark" title="View more" onclick="boxPopup('<?=linkboxPopup();?>pop_stat_language.php');" >View more</a>
</div>-->
</div>
</div>
</div>