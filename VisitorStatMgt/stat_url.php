<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 m-b-sm" >
<div class="card">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
<div class="title" >ผู้เข้าชมเว็บไซต์หน้าใด</div>
<div class="title text-right" ><i class="fas fa-hashtag"></i> Top 5</div>
</div>

</div>
<div class="card-body">
<div>

<!--<div class="list-group">
<?php
$s_url = $db->query("SELECT sv_fullurl,count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' 
AND (sv_fullurl != '' ) {$con} GROUP BY sv_fullurl ORDER BY ct DESC LIMIT 0,5");

while($a_url = $db->db_fetch_row($s_url)){
?>
      <a href="#" class="list-group-item">
        <span class="badge badge-success"><?php echo $a_url[1];?></span> <?php echo $a_url[0];?>
      </a>
      
<?php } ?>
</div>-->
<ul class="list-group">
<?php
$s_url = $db->query("SELECT sv_menu,sv_fullurl,count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' 
AND (sv_menu != '' ) {$con} GROUP BY sv_menu ORDER BY ct DESC LIMIT 0,5");

while($a_url = $db->db_fetch_row($s_url)){
?>

<li class="list-group-item "> <?php echo $a_url[0];?><span class="badge badge-success"><?php echo $a_url[2];?></span></li>

<?php } ?>

</ul>
</div>
<!--<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more" class="hi-icon hi-icon-list text-dark" title="View more" onclick="boxPopup('<?php echo linkboxPopup();?>pop_stat_url.php');">View more</a>
</div>-->
</div>
</div>
</div>
