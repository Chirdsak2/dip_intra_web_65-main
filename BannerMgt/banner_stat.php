<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

//$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";

?>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?=$txt_banner_stat;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="banner_stat.php"><?=$txt_banner_stat;?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a  target="_self" onclick="boxPopup('<?=linkboxPopup();?>pop_search_banner_stat.php');" data-toggle="tooltip" data-placement="buttom" title="<?=$txt_banner_search_stat;?>">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?=$txt_banner_search_stat;?>
</button>
</a>

<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fas fa-file-export"></i>&nbsp;export <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_export_banner_stat_xlsx.php');" ><i class="fas fa-file-excel text-medium text-success"></i>&nbsp;<?="Excel";?></a></li>
			<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_export_banner_stat_pdf.php');" ><i class="fas fa-file-pdf text-medium text-danger"></i>&nbsp;<?="PDF";?></a></li>
		</ul>
</div>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_search_banner_stat.php');" ><i class="fas fa-search"></i>&nbsp;<?=$txt_banner_search_stat;?></a></li>
		</ul>
</div>
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fas fa-file-export"></i>&nbsp;export <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_export_banner_stat_xlsx.php');" ><i class="fas fa-file-excel text-success  text-medium"></i>&nbsp;<?="Excel";?></a></li>
			<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_export_banner_stat_pdf.php');" ><i class="fas fa-file-pdf  text-danger text-medium"></i>&nbsp;<?="PDF";?></a></li>
		</ul>
</div>
</div>	
</div>
<!--<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right "  >	  
<form class="form-inline"  name="form1" method="post" action="">
<div class="form-group"> 
<label for="start_date"><b><?=$text_genbanner_graphfrom;?> : </b></label>
            <div class='input-group date' id='datetimepicker'>
                <input type='text' class="form-control datepicker" placeholder="<?=$text_genbanner_graphfrom;?>" name="start_date"  id="start_date" value="<?=$a_banner['banner_show_start'];?>">
                <span class="input-group-addon">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div> 
</div>
<div class="form-group"> 
<label for="end_date"><b><?=$text_genbanner_graphto;?> : </b></label>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control datepicker" placeholder="<?=$text_genbanner_graphto;?>"  name="end_date"  id="end_date" value="">
                <span class="input-group-addon">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>  
</div>

<input type="submit" name="Submit" value="<?php echo $text_genbanner_graphbut;?>" class="btn btn-success" style="text-align:right;" />
<input name="Flag" type="hidden" id="Flag" value="View">
</form>
</div>-->

</div>
</div>
<!--END card-header -->
	
<!--start card-body -->
<div class="card-body">



<div class="row ">
<?php
$Flag=$_POST[Flag];
if($Flag == ""){
///$db->write_log("view","banner","ดูรายงานแสดงสถิติการเข้าBanner ");

$start_date=$_POST[start_date];
$end_date=$_POST[end_date];

if($start_date == "" AND $end_date == ""){
$con = "";
}elseif($start_date != "" AND $end_date == ""){
$st = explode("/",$start_date);
$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
}elseif($start_date == "" AND $end_date != ""){
$st = explode("/",$end_date);
$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
}else{
$st = explode("/",$start_date);
$en = explode("/",$end_date);
$con = " AND (date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
}
//echo "select banner_pic,count(banner_log.banner_id) as ct,banner_name from  banner,banner_log where banner.banner_id = banner_log.banner_id  ".$con."group by banner_log.banner_id";
$_sql = $db->query("select banner_pic,count(banner_log.banner_id) as ct,banner_name from  banner,banner_log where banner.banner_id = banner_log.banner_id  ".$con." group by banner_log.banner_id ORDER BY ct DESC");
$_sql_ct = $db->query("select count(banner_log.banner_id) as ct from  banner,banner_log where banner.banner_id = banner_log.banner_id  ".$con."group by banner_log.banner_id LIMIT 0,1");
$A = $db->db_fetch_row($_sql_ct);

?>

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="table-responsive">			  
<table width="100%" class="table table-bordered" >
<thead>
<tr class="success">
<th width="20%" class="text-center"><?=$txt_banner_name;?></th>
<th width="10%" class="text-center"><?=$txt_banner_stat_click;?></th>
<th width="70%" class="text-center"></th>
</tr>
</thead>
<tbody>
<?php
while($a_data =  $db->db_fetch_row($_sql)){
?>
<tr> 
<td class="text-left" > 
<?php 
if(file_exists($Globals_Dir.$a_data[0]) AND $a_data[0]!=''){
				  $filetypename = explode('.',$Globals_Dir.$a_data[0]);
								
								
									if($filetypename[3] == 'swf'){
									$wi = '150';$hi = '50';
									echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'.$wi.'" height="'.$hi.'">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$Globals_Dir.$a_data[0].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$Globals_Dir.$a_data[0].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'.$wi.'" height="'.$hi.'"> </embed>
										</object><br><br>';
									}else{
				  ?>
                  <img src="../FileMgt/phpThumb.php?src=<?=$Globals_Dir;?><?=$a_data[0]; ?>&h=50&w=150">
				  <br>
<?php 
}
	}
?>
<?=$a_data[2];?>
</td>
<td class="text-center"><span class="badge badge-info"><?=number_format($a_data[1],0);?></span></td>
<td class="text-left"> 
<?php 
if($A[0] > 0){
	$value = number_format((($a_data[1]*5)/$A[0]),0)/10;
	}else{
		$value = 0;
		  }
?>	   

<div class="progress">
  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?=$value;?>"
  aria-valuemin="0" aria-valuemax="100" >
    <?=$a_data[2];?>
  </div>
</div>

</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<?php } ?>
</div>
</div>

</div>
<!--END card-body-->
</div>
<!--END card-->

</div>

</div>

</div>
<!-- END CONTAINER  -->

<?php
include("../EWT_ADMIN/combottom.php");
?>
<script>
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        });
  });

  
$('.progress-bar').each(function() {
  var valueNow = $(this).attr('aria-valuenow');

  $(this).animate({
    
    width: valueNow + '%',

    percent: 100

  }, {

    progress: function(a, p, n) {

      $(this)
        .css('width', (valueNow * p + '%'))
        .html((valueNow * p) + '%');

    }

  });

});
</script>  