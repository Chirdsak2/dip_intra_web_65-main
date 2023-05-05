<?php
  $sql_cate = $db->query("SELECT * FROM mobile_contents left join article_group on article_group.c_id=mobile_contents.c_id order by mobile_contents.mcont_order");
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<div class="bg_call" style="width: 100%;">
<div style="float: right;">
  <span class="tel2">สายด่วน&nbsp;สคบ.</span><span class="tel">1</span><span class="tel">1</span><span class="tel">6</span><span class="tel">6</span>&nbsp;
</div>
<div class="call" id="eff"><img src="images/mobile_web/all_03.png"></div>

</div>


<div class="effmenu" style="position: fixed; top: 0; left: 0; ; bottom: 0;display: none; 
-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.50);
-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.50);
box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.50);"><div style="background-image:url(images/mobile_web/popup_07.png); background-position:right; background-repeat:no-repeat;">
<div class="beffmenu" align="center" ;"><img src="images/mobile_web/logo3_05.png" />สคบ.</div></div>
<ul>
  <li><a href="mobile_list.php?cid=3"><img src="images/mobile_web/icon10_03.png" /> ข่าวเด่น</a></li >
<?php while($cate_menu = $db->db_fetch_array($sql_cate)) { ?>
  <li><a href="mobile_list.php?cid=<?php echo $cate_menu['c_id']; ?>"><img src="images/mobile_web/icon10_03.png" /> <?php echo $cate_menu['c_name']; ?></a></li >

<?php } ?>
</ul>
<div class="close-btn" id="effclose">
    <span >Close</span>
</div>
</div>
