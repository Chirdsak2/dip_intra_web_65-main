<?php
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

	$sql_index = $db->query("SELECT * FROM mobile_config WHERE mconf_code = 'logo' ");
	$F = $db->db_fetch_array($sql_index);

  $sql_index = $db->query("SELECT filename,template_id FROM temp_index WHERE filename = 'index_2013' ");
 	$rec = $db->db_fetch_array($sql_index);

?>
<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=320, initial-scale=1" />
  <script type='text/javascript' src='js/jquery/jquery.js'></script>
  <link rel="stylesheet" href="css/mobile.css" />

  <style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image:url(images/mobile_web/bg.png);
	background-size:100% auto;
	background-repeat:no-repeat;

}

  </style>

  <script>
  
  $(function() {
    $("#eff").click(function(){
      $(".effmenu").show(20);
    });
    $("#effclose").click(function(){
      $(".effmenu").hide(20);
    });
  });
  </script>

</head>
<body bgcolor="#05aff2">




<div class="apps" ><a href="https://play.google.com/store/apps/details?id=com.ocpb.ocpbonline&hl=en"><img src="images/mobile_web/apps_02.png"></a></div>
<div class="bg_logo">
<img src="images/mobile_web/logo2_02.png" >
</div>
<?php
  include('mobile_menu.php');
?>

<div class="desktop" align="center"><a href="main.php?filename=<?php echo $rec['filename']; ?>"><img src="images/mobile_web/home_06.png">เข้าสู่เว็บไซต์ ocpb แบบปกติ</a></div>

<!-- hide 
<div id="dHeader">
<?php if(is_file($F['mconf_value'])) {?>
  <img src="<?php echo $F['mconf_value']; ?>" alt="Logo Image" />
<?php } ?>
</div>
// hide  -->
<?php
  $sql_cate = $db->query("SELECT * FROM article_group where c_id=3".$c_id);
  $cates = $db->db_fetch_array($sql_cate);
  $sql_row = $db->query('SELECT * FROM article_list where c_id=3 and n_approve="Y"');
  $row = $db->db_num_rows($sql_row);
  $limit = 2;
  $size = 5;
  if($page_end > $page_all) $page_end = $page_all;
  $sql_contents = $db->query('SELECT * FROM article_list where c_id=3 and n_approve="Y" order by  n_date DESC,n_timestamp DESC limit 0, '.$limit);
?>
<!----------->
  <div  class="news">
<a href="mobile_list.php?cid=3" style="display: block;"><img src="images/mobile_web/icon2_06.png">
 <?php echo $cates['c_name']; ?></a>
 </div>

<?php
  while($content = $db->db_fetch_array($sql_contents)) {
?>
<div class="detail">
  <a href="mobile_detail.php?cid=3&nid=<?php echo $content['n_id']; ?>">
<?php
  if(is_file('images/article/news'.$content['n_shareid'].'/'.$content['picture']))
    echo '  <img src="images/article/news'.$content['n_shareid'].'/'.$content['picture'].'" />'.PHP_EOL;
  else if(is_file('images/article/news'.$content['n_id'].'/'.$content['picture']))
    echo '  <img src="images/article/news'.$content['n_id'].'/'.$content['picture'].'" />'.PHP_EOL;
?>
<?php echo $content['n_topic']; ?>
  </a>
  <div style="clear: left;"></div>
</div>
<?php } ?>

<div class="more" align="center"><a href="mobile_list.php?cid=3" style="display: block;">อ่านทั้งหมด</a></div>



<?php 
  $sql_cate = $db->query("SELECT * FROM mobile_contents left join article_group on article_group.c_id=mobile_contents.c_id order by mobile_contents.mcont_order");

while($cate = $db->db_fetch_array($sql_cate)) { ?>
  <div class="topic"><a href="mobile_list.php?cid=<?php echo $cate['c_id']; ?>"><img src="images/mobile_web/icon3_06.png"><?php echo $cate['c_name']; ?></a></div>

<?php } ?>


</body>

</html>