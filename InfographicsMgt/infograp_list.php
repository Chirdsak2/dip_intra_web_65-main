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
<!--Include gallery style-->
<link rel="stylesheet" href="../js/gallery-plugins/css/style.css">
<link rel="stylesheet" href="../js/gallery-plugins/assets/css/lightgallery.css">
<?php include('../EWT_ADMIN/link.php'); ?>

<script src="../js/FolderPreviewIdeas-master/js/anime.min.js"></script>
<script src="../js/FolderPreviewIdeas-master/js/charming.min.js"></script>
<script src="../js/FolderPreviewIdeas-master/js/main.js"></script>

<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<?php 
$type = $_REQUEST['type'];

if($type == '1'){ 
	$topic =  'Photo';
	}else{ 
		$topic = 'Vectors';
	}
?>
<!--<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">
</h4>
</div>-->	
<div class="container" style="width:98%;">
<h2><?=$topic?></h2>
<p></p> 
              
<ol class="breadcrumb">
<li><a href="index.php">Infographics</a></li>
<li class=""><?=$topic?></li>       
</ol>

</div>	


<?php
$folder = "../images";

//$files = glob($folder."/*.*"); 
$files = glob($folder."/*.{jpg,png,gif}", GLOB_BRACE);
//$files = glob($folder."/*.jpg");
$total = count($files);


$perpage = 12;
?>

<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" >
<a href="infograp_main.php" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt" aria-hidden="true">&nbsp;&nbsp;<?="ย้อนกลับ";?></i>
</button>
</a> 
</div>	
</div>
<?php echo '<div class=\"col-xs-12 col-sm-12 col-md-12 \" ><h4>ภาพทั้งหมด <span class="label label-info" >'.$total.'</span> รูป </h4></div>'; ?>
<hr>
</div>

<!--<div class="col-md-12 col-sm-12 col-xs-12" >
        <div class="row">
          <div class="col-xs-12">
            <div class="list-unstyled row clearfix" id="aniimated-thumbnials">
              <div id="container-01">
<?php		  
/*$pathDir = "../images";
$openDir = opendir($pathDir);

while ($file = readdir($openDir)) {
                if ($file == "." || $file == "..") {
                    continue;
                }
                $fileName = $file;
                //readdir() มันอ่านได้แค่ชื่อมาแต่เราต้องการข้อมูลมากกว่านนั้นทำต่อ
                $fullPath = $pathDir . "/" . $file; // เอาตำแหน่งเต็มๆมา
                $type = "dir";

                if (is_file($fullPath)) { // ตรวจว่า $fullpath ใช่ไฟล์ไหม
                    $information = pathinfo($fullPath); //pathinfo() แตกข้อมูลของ $fullpath
                    $type = $information['extension']; //extension คือ นามสกุลไฟล์
                }

                $size = filesize($fullPath); // หาขนาดของไฟล์ได้มาเป็น Bytes
                if ($size >= 1073741824) {
                    $size = round($size / 1073741824, 2) . " GB"; //เอาทศนิยม 2 ตำแหน่ง
                } elseif ($size >= 1048576) {
                    $size = round($size / 1048576, 2) . " MB";
                } elseif ($size >= 1024) {
                    $size = round($size / 1024, 2) . " KB";
                }			  
?>			  
			  
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 pinto">
				<a class="img" href="<?=$pathDir."/".$fileName;?>" title="<?=$fileName;?>" data-download-url="<?=$pathDir."/".$fileName;?>">
				<img class="img-responsive thumbnail mb-10" src="<?=$pathDir."/".$fileName;?>">
				</a>
                  <div class="btn-download text-right mb-20"><a href="<?=$pathDir."/".$fileName;?>" download target="_BLANK">
                      <button class="btn btn-default"><span class="glyphicon glyphicon-download-alt">&nbsp;</span><span>download</span></button></a></div>
                </div>
				
<?php						
            }*/
            ?>				
				
</div> 
</div> 
</div> 
</div> 
</div> 	-->


<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >
        <div class="row">
          <div class="col-xs-12">
            <div class="list-unstyled row clearfix" id="aniimated-thumbnials">
              <div id="container-01">
<?php
if(isset($_GET['page'])) {
$i = ($_GET['page']*$perpage) - $perpage;
$max = $i+$perpage;
	}else{
		$i=0;
		$max = $perpage;
        }
		
        if($max > count($files)){
            $max = count($files);
        }

   for ($i; $i<$max; $i++) 
            { 
                $fileName = $files[$i]; 
                $title = str_replace($folder.'/', '', $num);
				
				$size = file_size($fileName);
                /*echo '
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 pinto"">
                    <div class="thumbnail">
                      <img src="'.$num.'" alt="...">
                      <div class="caption">
                        <h3>'.$i.$title.'</h3>
                      </div>
                    </div>
                </div>';*/

?>
 <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 pinto">
 <div class="thumbnail">
				<a class="img" href="<?=$fileName;?>" title="<?=$fileName;?>" data-download-url="<?=$fileName;?>">
				<img class="img-responsive  mb-10" src="<?=$fileName;?>">
				</a>
                  <div class="btn-download text-right mb-20">
				   <?=$size;?>
				  <a href="<?=$fileName;?>" download target="_BLANK">
                      <button class="btn btn-default"><span class="glyphicon glyphicon-download-alt">&nbsp;</span><span>download</span></button></a></div>
                </div>
</div>


<?php				
if($i%4 == '1'){
echo "<div class=\"clearfix\"></div>".PHP_EOL;
}				
            }
?>
</div> 
</div> 
</div> 
</div>
<hr> 
</div> 

<?=pagination_folder($total,$perpage,$page,$url='?type='.$type.'&');?>

<?php
/*
echo '<div class="col-md-12 col-sm-12 col-xs-12" ><div style="clear:both;"></div>';

//Page
$p = round(count($files)/$perpage);

echo '<nav><ul class="pagination">';
        for ($i=0; $i < $p; $i++) { 
            $page = $i+1;
            if ( isset($_GET['page']) && ($_GET['page']==$i) ) {

                $class = ' class="active"';
            }else{
                $class = '';
            }
            echo '
                <li'.$class.'>
                    <a href="?type='.$type.'&page='.$i.'">'.$page.'</a>
                </li>';
        }
        echo '</ul></nav></div>';
		*/
?>
</div>			

</div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
  <!--Include gallery plugins-->
  <script src="../js/gallery-plugins/assets/js/lightgallery-all.js"></script>
  <script src="../js/gallery-plugins/assets/js/image-gallery.js"></script>
  <script src="../js/gallery-plugins/assets/js/imagesloaded.pkgd.min.js"></script>
  <script src="../js/gallery-plugins/assets/js/jquery.pinto.js"></script>
  <script src="../js/gallery-plugins/js/custom.js"></script>
<?php
$db->db_close(); ?>