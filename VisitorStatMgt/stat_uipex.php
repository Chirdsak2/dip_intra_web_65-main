<ul class="list-group">
<?php
$s_uipex = $db->query("SELECT sv_ip,count(sv_id) AS ct 
FROM stat_visitor 
WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_country != 'THAILAND'   AND sv_country != '-' {$con} 
GROUP BY sv_ip 
ORDER BY ct DESC LIMIT 0,5");

while($a_uipex = $db->db_fetch_row($s_uipex)){
?>
<li class="list-group-item "><?=$a_uipex[0];?><span class="badge badge-success"><?=$a_uipex[1];?></span></li>

<?php } ?>
</ul>