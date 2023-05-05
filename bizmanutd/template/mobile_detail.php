<?php
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

	//===============================================================
	if($cid){ $cid  = checkNumeric($cid); }
	if($_GET["cid"]){ $_GET["cid"] = checkNumeric($_GET["cid"]); }
	if($_POST["cid"]){ $_POST["cid"] = checkNumeric($_POST["cid"]); }
	
	if($nid){ $nid  = checkNumeric($nid); }
	if($_GET["nid"]){ $_GET["nid"] = checkNumeric($_GET["nid"]); }
	if($_POST["nid"]){ $_POST["nid"] = checkNumeric($_POST["nid"]); }
	//===============================================================
	
  $c_id = $_GET['cid'];
  $n_id = $_GET['nid'];

	$sql_index = $db->query("SELECT * FROM mobile_config WHERE mconf_code = 'logo' ");
	$F = $db->db_fetch_array($sql_index);

  $sql_cate = $db->query("SELECT * FROM article_group where c_id=".$c_id);
  $cate = $db->db_fetch_array($sql_cate);

  $sql_contents = $db->query('SELECT * FROM article_list where n_id='.$n_id);
  $content = $db->db_fetch_array($sql_contents);

  $sql_detail = $db->query("SELECT * FROM article_detail WHERE n_id = '".$n_id."'");
  $chk = $db->db_num_rows($sql_detail);

?>
<!DOCTYPE HTML>
<html>
<head lang="en">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
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
<div class="apps" ><a href="width:auto;"><img src="images/mobile_web/apps_02.png"></a></div>
<div class="bg_logo">
<img src="images/mobile_web/logo2_02.png" >
</div>
<?php
  include('mobile_menu.php');
?>
<div  class="news">
<a href="mobile.php"><img src="images/mobile_web/icon2_06.png">
<?php echo $cate['c_name']; ?></a>
 </div>
 <!--------------------------->
<div class="bg_content">
<h1 style="color: #000066"><?php echo $content['n_topic']; ?></h1>
<?php   if(!$chk) {?>
<div class="dNews">
  
<?php
  if(is_file('images/article/news'.$content['n_shareid'].'/'.$content['picture']))
    echo '  <img src="images/article/news'.$content['n_shareid'].'/'.$content['picture'].'" />'.PHP_EOL;
  else if(is_file('images/article/news'.$content['n_id'].'/'.$content['picture']))
    echo '  <img src="images/article/news'.$content['n_id'].'/'.$content['picture'].'" />'.PHP_EOL;
?>
  <div><?php echo ''; ?></div>
  <?php echo $content['n_des']; ?>

  <div style="clear: left;"></div>
</div>
<?php
  }
  else
  {
    echo '<div class="dDetail">';
    while($detail = $db->db_fetch_array($sql_detail))
    {
		        if($detail['ad_pic_b'])
      {
?>
  <center><img src="images/article/news<?php echo $detail['n_id']; ?>/<?php echo $detail['ad_pic_b']; ?>" /></center>
  <div style="clear: left;"></div>
<?php
      }
      else if(trim( $detail['ad_des'])){
?>
  <?php echo $detail['ad_des']; ?>
  <div style="clear: left;"></div>
<?php
    }
	}
  echo '</div>';
  }
?>
<div style="height: 30px;"></div>
<?php
  if($content['link_html'])
  {
?>
    <div class="source"><a href="<?php echo $content['link_html']; ?>" target="_blank">:: แสดงข้อมูล ::</a></div>
<?php
  }
?>
</div>
<div class="back" ><a href="mobile.php"><div style="margin-top:5px; margin-left:5px; margin-right:5px; float:left; width:20px;"><img src="images/mobile_web/icon9_03.png" border="0"></div> back</a></div>

<div class="desktop" align="center"><a href="main.php?filename=<?php echo $rec['filename']; ?>"><img src="images/mobile_web/home_06.png">เข้าสู่เว็บไซต์ ocpb แบบปกติ</a></div>
</body>
</html>
