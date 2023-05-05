<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../js/FolderPreviewIdeas-master/css/normalize.css" />
<link rel="stylesheet" type="text/css" href="../js/FolderPreviewIdeas-master/css/demo.css" />

<?php include('../EWT_ADMIN/link.php'); ?>
<script src="../js/FolderPreviewIdeas-master/js/anime.min.js"></script>
<script src="../js/FolderPreviewIdeas-master/js/charming.min.js"></script>
<script src="../js/FolderPreviewIdeas-master/js/main.js"></script>

<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<!--<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">ประเภทของรูปภาพดาวน์โหลด</h4>
</div>-->
<div class="container" style="width:98%;">
<h2>Infographics</h2>
<p></p> 
              
<ol class="breadcrumb">
<li><a href="index.php">Infographics</a></li>
<li class=""></li>       
</ol>

</div>	

<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" >
</div>	
</div>
<hr>
</div>

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		  <a class="img" href="infograp_list.php?type=1"  data-toggle="tooltip" data-placement="right" title="ภาพถ่าย">
		  <img class="img-responsive thumbnail" src="../EWT_ADMIN/images/images.jpg">
		  </a>
		  </div>
          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		  <a class="img" href="infograp_list.php?type=2"  data-toggle="tooltip" data-placement="right" title="ภาพเวกเตอร์">
		  <img class="img-responsive thumbnail" src="../EWT_ADMIN/images/vectors.jpg">
		  </a>
		  </div>
        </div>  
</div>
</div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
<?php
$db->db_close(); ?>