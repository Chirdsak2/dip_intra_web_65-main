<?php
  $sql_cate = $db->query("SELECT * FROM mobile_contents left join article_group on article_group.c_id=mobile_contents.c_id order by mobile_contents.mcont_order");
?>
<div id="eff" style="position: absolute; top: 9px; left: 10px;"><img src="images/mobile_web/icon_16.png"></div>

<div class="effmenu" style="position: fixed; top: 0; left: 0; ; bottom: 0;display: none; background-color:#fff;-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);">
<span class="beffmenu">menu</span>
<ul>
<?php while($cate_menu = $db->db_fetch_array($sql_cate)) { ?>
  <li><a href="mobile_list.php?cid=<?php echo $cate_menu['c_id']; ?>"><span class="icon_bullet"><?php echo $cate_menu['c_name']; ?></span></a></li >

<?php } ?>
</ul>
<div class="close-btn" id="effclose">
    <span >Close</span>
</div>
</div>
