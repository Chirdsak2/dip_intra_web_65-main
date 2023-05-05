<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
<div class="title" >ผู้ให้บริการ (Internet service provider)</div>

<div class="title" ><i class="fas fa-hashtag"></i> Top 5
</div>
</div>
</div>
<div class="card-body">
<div>
<ul class="list-group">
<?php
$s_isp = $db->query("SELECT sv_isp,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND sv_isp != '' AND sv_isp != '-' {$con} 
GROUP BY sv_isp 
ORDER BY ct DESC LIMIT 0,5");

while($a_isp = $db->db_fetch_row($s_isp)){
?>
<li class="list-group-item "><?=$a_isp[0];?><span class="badge badge-success"><?=$a_isp[1];?></span></li>

<?php } ?>
</ul>

</div>


<!--<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more" class="hi-icon hi-icon-list text-dark" title="View more" onclick="boxPopup('<?=linkboxPopup();?>pop_stat_isp.php');">View more</a>
</div>-->
</div>
</div>
</div>