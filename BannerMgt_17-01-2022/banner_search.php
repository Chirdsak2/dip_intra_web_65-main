<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$gid     = filter_number($_GET['banner_gid']);
$keyword = ready($_GET["keyword"]);

if(trim($gid)!=""){
	$group_cond = " AND banner_gid = '$gid'";
}

if(trim($keyword)!=""){
	$name_cond = " AND banner_name = '$keyword'";
}

$s_banner_g = $db->query("SELECT * FROM banner_group  WHERE 1=1 $group_cond ");
$a_banner_g = $db->db_fetch_array($s_banner_g);

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
$s_banner = $db->query("SELECT * FROM banner 
						WHERE 1=1 $group_cond $name_cond
					    ORDER BY banner_position ASC,banner_id ASC");
$a_rows = $db->db_num_rows($s_banner);

?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?=$text_genbanner_module;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="banner_group.php"><?=$text_genbanner_module;?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_banner_group.php?gid=<?=$gid;?>');" data-toggle="tooltip" data-placement="bottom" title="<?=$txt_banner_add_cate;?>"  target="_self">
<button type="button" class="btn btn-info  btn-ml">
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_banner_add_cate;?>
</button>
</a>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_banner.php?gid=<?=$gid;?>');" data-toggle="tooltip" data-placement="bottom" title="<?=$txt_banner_add;?>" > 
<button type="button" class="btn btn-info  btn-ml">
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_banner_add;?>
</button>
</a>
<a  target="_self" onclick="boxPopup('<?=linkboxPopup();?>pop_search_banner.php');" data-toggle="tooltip" data-placement="buttom" title="<?="Search FAQ";?>">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?="ค้นหาแบนเนอร์";?>
</button>
</a>
<a href="banner_group.php" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt"></i>&nbsp;<?="ย้อนกลับ";?>
</button>
</a>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_faq_group.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?="เพิ่มหมวด FAQ";?></a></li>
			<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_search_faq.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?="Search FAQ";?></a></li>
          	
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >
<div class="table-responsive">			
<form name="frm1" action="banner_process.php" method="post">		
<table width="100%" class="table table-bordered" id="table-1" align="center">
<thead>
<tr class="nodrop nodrag success">
							<th  width="10%" ></th>  
							<th  width="40%" class="text-center"><?php echo $text_genbanner_column1;?></th>
							<th  width="30%" class="text-center"><?php echo $text_genbanner_column2;?></th> 
							<?php /*<th  width="10%" class="text-center"><?='Popup Intro';?></th>  
							<th  width="10%" class="text-center"><?php echo $text_genbanner_formsort;?></th>*/ ?>
						</tr>
						</thead>
<tbody>						
<?php
if($a_rows > 0){
$i = 1;
while($a_banner = $db->db_fetch_array($s_banner)){
?>						
<tr id="<?=$i;?>">
<td class="text-center" >
							<!--<a href="#" title="แก้ไข" target="_self" onClick="location.href='banner_edit.php?flag=edit&banner_id=<?php echo $rs_banner['banner_id']?>&banner_gid=<?php echo $_GET["banner_gid"];?>';" >
							<span class="glyphicon glyphicon-cog text-warning" style="font-size:16px;"></span>
							</a>
							<a href="#" title="ลบ" target="_self" onClick="if(confirm('<?php echo $text_genbanner_confirm_del;?>'))location.href = 'banner_process.php?flag=del&banner_id=<?php echo $rs_banner[banner_id]?>&banner_gid=<?php echo $_GET["banner_gid"];?>'; ">
							<span class="glyphicon glyphicon-trash text-danger" style="font-size:16px;"></span>
							</a>-->
<nobr>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_banner.php?proc=edit&ban_id=<?=$a_banner['banner_id']?>&ban_cid=<?=$gid;?>');" data-toggle="tooltip" data-placement="right" title="<?=$text_genbanner_altedit;?>" > 
<button type="button" class="btn btn-warning  btn-circle  btn-xs " >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_banner.php?proc=edit&ban_id=<?=$a_banner['banner_id']?>&ban_cid=<?=$gid;?>');" data-toggle="tooltip" data-placement="right" title="<?=$text_genbanner_altdel;?>" > 
<button type="button" class="btn btn-danger  btn-circle  btn-xs " >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_view_banner.php?ban_id=<?=$a_banner['banner_id']?>');" data-toggle="tooltip" data-placement="right" title="<?="ดูรูปภาพ";?>">
<button type="button" class="btn btn-success  btn-circle  btn-xs " >
<i class="fas fa-search" aria-hidden="true"></i>
</button>
</a> 
							<!--<img src="../theme/main_theme/g_edit.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altedit;?>" style="cursor:hand" onClick="location.href='banner_edit.php?flag=edit&banner_id=<?php echo $rs_banner[banner_id]?>&banner_gid=<?php echo $_GET["banner_gid"];?>';">&nbsp;
							<img src="../theme/main_theme/g_garbage.png" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altdel;?>" style="cursor:hand" onClick="if(confirm('<?php echo $text_genbanner_confirm_del;?>'))location.href = 'banner_process.php?flag=del&banner_id=<?php echo $rs_banner[banner_id]?>&banner_gid=<?php echo $_GET["banner_gid"];?>'; "> 
							<a href="#" onClick="txt_data('<?php//=$rs_banner[banner_id]?>','<?php//=$_GET[banner_gid]?>')"><img id="lang<?php//=$rs_banner[banner_id]?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a>-->
</nobr>
</td>
<td >
&nbsp;&nbsp;
<?php 
if(file_exists($Globals_Dir.$a_banner['banner_pic']) AND $a_banner['banner_pic']!=''){
$filetypename = explode('.',$Globals_Dir.$a_banner['banner_pic']);																
									if($filetypename[3] == 'swf'){
									$wi = '150';$hi = '50';
										echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'.$wi.'" height="'.$hi.'">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$Globals_Dir.$a_banner['banner_pic'].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$Globals_Dir.$a_banner['banner_pic'].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'.$wi.'" height="'.$hi.'"> </embed>
										</object><br><br>';
									}else{
									?>
									<img src="../FileMgt/phpThumb.php?src=<?=$Globals_Dir?><?=$a_banner['banner_pic']; ?>&h=50&w=150" border="1">
									<?php
									}
								 }else{  echo "No image.";   }?>
</td>
<td  width="10%" class="text-left"><?=$a_banner['banner_name']?></td>

<?php /*
<td  width="10%" class="text-center" >
<?php 
if($a_banner['banner_intro']=='Y'){
	echo '<span class="glyphicon glyphicon glyphicon-ok text-danger" onclick="JQSetIntro('.$a_banner['banner_id'].',\'UnSetIntro\',);"></span>';
	}else{
	?>						
<input type="radio" name="intro" id="intro<?=$a_banner['banner_id']?>" value="<?=$a_banner['banner_id']?>" onclick="JQSetIntro(<?=$a_banner['banner_id'];?>,'SetIntro');" >
<?php } ?>
</td>  			
<td width="10%" class="text-center">
<input class="form-control"  type="text" name="ban_pos[]" id="ban_pos" size="5" value="<?=$a_banner['banner_position']?>" onKeyUp="chkformatnum(this)" >
<input type="hidden" name="ban_id[]" id="ban_id"  value="<?=$a_banner['banner_id']?>">
</td>
*/ ?>
</tr>
<?php  
	$i++;
		}
?>
						<tr  class="nodrop nodrag">
							<td colspan="4"  class="text-center" >&nbsp;</td>
							<?php /*<td class="text-center" >
							
							<input type="hidden" name="flag" value="tool"> 
							<input type="hidden" name="banner_gid" value="<?=$gid;?>">
							<input class="btn btn-success" type="Button" name="Submit" value="<?php echo $text_genbanner_formupdate;?>" onClick="document.frm1.submit();">
							
							</td>*/ ?>
						</tr>
						<?php } else { ?>
						<tr >
							<th  colspan="3" scope="col"><div align="center" style="color:#FF0000"><?php echo $text_genbanner_notfound?></div></th>
						</tr>
						<?php 
							}
						?>
	</tbody>
	</table>	
	</form>
</div>
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
                                                                                                                                                                                                       <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
