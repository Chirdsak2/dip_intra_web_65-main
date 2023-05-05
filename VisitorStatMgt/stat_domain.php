<ul class="list-group">
<?php
$s_domain= $db->query("SELECT sv_domain,count(sv_id) AS ct 
FROM stat_visitor 
WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_domain != ''   AND sv_domain != '-' {$con}
GROUP BY sv_domain 
ORDER BY ct DESC LIMIT 0,5");

while($a_domain = $db->db_fetch_row($s_domain)){
?>
<li class="list-group-item "><?=$a_domain[0];?><span class="badge badge-success"><?=$a_domain[1];?></span></li>

<?php } ?>
</ul>