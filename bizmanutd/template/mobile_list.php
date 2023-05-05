<?php
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	
	//===================================================================
	if($cid){ $cid  = checkNumeric($cid); }
	if($_GET["cid"]){ $_GET["cid"] = checkNumeric($_GET["cid"]); }
	if($_POST["cid"]){ $_POST["cid"] = checkNumeric($_POST["cid"]); }
	
	if($c_id){ $c_id  = checkNumeric($c_id); }
	if($_GET["c_id"]){ $_GET["c_id"] = checkNumeric($_GET["c_id"]); }
	if($_POST["c_id"]){ $_POST["c_id"] = checkNumeric($_POST["c_id"]); }
	
	if($page){ $page  = checkNumeric($page);  }
	if($_GET["page"]){ $_GET["page"] = checkNumeric($_GET["page"]); }
	if($_POST["page"]){ $_POST["page"] = checkNumeric($_POST["page"]); }
	//===================================================================
	
  $s_page = ($_GET['page'])?$_GET['page']:1;
  $c_id = $_GET['cid'];

	$sql_index = $db->query("SELECT * FROM mobile_config WHERE mconf_code = 'logo' ");
	$F = $db->db_fetch_array($sql_index);

  $sql_cate = $db->query("SELECT * FROM article_group where c_id=".$c_id);
  $cate = $db->db_fetch_array($sql_cate);
  $sql_row = $db->query('SELECT * FROM article_list where c_id='.$c_id.' and n_approve="Y"');
  $row = $db->db_num_rows($sql_row);
  $limit = 10;
  $size = 5;
  $page_all = ceil($row / $limit);
  $row_start = (($s_page-1) * $limit);
  $targetPage = ceil($s_page / $size);
  $page_start = (($targetPage-1) * $size) + 1;;
  $page_end =  $targetPage * $size;;

  if($page_end > $page_all) $page_end = $page_all;
  $sql_contents = $db->query('SELECT * FROM article_list where c_id='.$c_id.' and n_approve="Y" order by  n_date DESC,n_timestamp DESC limit '.$row_start.', '.$limit);
?>
<!DOCTYPE HTML>
<html>
<head lang="en">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/mobile.css" />
  <script type='text/javascript' src='js/jquery/jquery.js'></script>
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


<?php
  while($content = $db->db_fetch_array($sql_contents)) {
?>
<div class="detail">
<?php if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $content['link_html'])) { ?>
  <a href="<?php echo $content['link_html']; ?>" target="_blank">
<?php } else if(preg_match("/^more_news/i", $content['link_html'])) { 
$s_value = str_replace('more_news.php?', '', $content['link_html']);
parse_str($s_value);
?>
  <a href="mobile_list.php?cid=<?php echo $cid;?>">
<?php } else if($content['link_html']) { ?>
  <a href="<?php echo $content['link_html']; ?>">
<?php } else { ?>
  <a href="mobile_detail.php?cid=<?php echo $c_id; ?>&nid=<?php echo $content['n_id']; ?>">
<?php } ?>

<?php
  if(is_file('images/article/news'.$content['n_shareid'].'/'.$content['picture']))
    echo '  <img src="images/article/news'.$content['n_shareid'].'/'.$content['picture'].'" />'.PHP_EOL;
  else if(is_file('images/article/news'.$content['n_id'].'/'.$content['picture']))
    echo '  <img src="images/article/news'.$content['n_id'].'/'.$content['picture'].'" />'.PHP_EOL;
?>
  <h1><?php echo $content['n_topic']; ?></h1>
  </a>
  <div style="clear: left;"></div>
</div>
<?php } ?>
<div class="dPage">
<?php
  if($s_page > $size)
  {
?>
  <a href="mobile_list.php?cid=<?php echo $c_id; ?>&page=<?php echo ($page_start-1); ?>">&laquo;</a>
<?php
  }
  for($_i=$page_start; $_i<=$page_end; $_i++)
  {
    $current = ($s_page==$_i)?' class="current"':'';
?>
  <a href="mobile_list.php?cid=<?php echo $c_id; ?>&page=<?php echo $_i; ?>"<?php echo $current; ?>><?php echo $_i; ?></a>
<?php
  }
  if($page_end < $page_all)
  {
?>
  <a href="mobile_list.php?cid=<?php echo $c_id; ?>&page=<?php echo ($page_end+1); ?>">&raquo;</a>
<?php
  }
?>
</div>
<div style="height: 30px;"></div>
<div class="back" ><a href="mobile.php"><div style="margin-top:5px; margin-left:5px; margin-right:5px; float:left; width:20px;"><img src="images/mobile_web/icon9_03.png" border="0"></div> back</a></div>

<div class="desktop" align="center"><a href="main.php?filename=<?php echo $rec['filename']; ?>"><img src="images/mobile_web/home_06.png">เข้าสู่เว็บไซต์ ocpb แบบปกติ</a></div>
</body>
</html>
