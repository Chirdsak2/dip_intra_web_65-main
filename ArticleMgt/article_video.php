<?php
include("../EWT_ADMIN/comtop.php");
$nid = (int)(!isset($_GET['nid']) ? '' : $_GET['nid']);

$sql_article = $db->query("SELECT * FROM article_list WHERE n_id = '{$nid}'");
$R = $db->db_fetch_array($sql_article);
?>
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
?>
<style type="text/css">
<!--
.border_dashed { 
   argin-top: 10px;
   margin-right: 0px;
   margin-bottom: 5px;
   margin-left: 0px;
   padding:0px 10px 10px 10px;
   _border-top: 2px dashed #cbcccc;
   border-top: 3px dashed #cbcccc;
   border-bottom: 3px dashed #cbcccc;
   border-right: 3px dashed #cbcccc;
   border-left: 3px dashed #cbcccc;
   text-align:center;
}
.border_dashed:hover { 
   border-top: 3px dashed #cbcccc;
   border-bottom: 3px dashed #cbcccc;
   border-right: 3px dashed #cbcccc;
   border-left: 3px dashed #cbcccc;
   background-color:#f9f9f9;
   
}
.jFiler-input-icon {
    font-size: 48px;
    margin-top: -10px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

-->
</style>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<h4><b><?=$txt_article_video;?></b></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="permission_user.php"><?=$txt_permission_menu_user;?></a></li>
<li class=""><?=$txt_permission_set;?></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a href="article_edit.php?nid=<?=$nid;?>" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right"> 
			<li><a href="article_edit.php?nid=<?=$nid;?>" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?></a></li>
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->

<div class="card-body">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" >
<form action="article_function.php" method="post" enctype="multipart/form-data" name="form1" target="ftarget">
<!--<div class="page-header">
<h4>การแสดงในหน้ารายละเอียด</h4>      
</div>-->

<div class="panel panel-default">
<div class="panel-heading form-inline" style="text-align:right;">
<a  onclick="boxPopup('<?=linkboxPopup();?>pop_edit_vdo.php?nid=<?=$nid;?>');" data-toggle="tooltip" data-placement="right" title="เพิ่มวีดีโอ" >
<button type="button" class="btn btn-success" id="btn1">
<span class="glyphicon glyphicon-film"></span>&nbsp;&nbsp;เพิ่มวีดีโอ
</button>
</a>

<a  onclick="boxPopup('<?=linkboxPopup();?>pop_edit_location.php?nid=<?=$nid;?>');" data-toggle="tooltip" data-placement="right" title="เพิ่มแหล่งที่มา" >
<button type="button" class="btn btn-success" id="btn2" style="display:none;">
<span class="glyphicon glyphicon-film"></span>&nbsp;&nbsp;เพิ่มแหล่งที่มา
</button>
</a>

<input name="Flag" type="hidden" id="Flag" value="NewsDetail" />
<input name="nid" type="hidden" id="nid" value="<?=$nid;?>" />
<input name="cid" type="hidden" id="cid" value="<?=$R['c_id'];?>" />
<input name="n_action" type="hidden" id="n_action">
<input type="hidden" name="backto" value="<?php if($_SESSION["EWT_OPEN_ARTICLE"] == ""){ echo "article_group.php"; }else{ echo "article_list.php?cid=".$_SESSION["EWT_OPEN_ARTICLE"]; } ?>">
</div>



<div class="panel-body" style="background-color:#FFFFFF;" id="show1">
<ul class="nav nav-tabs">
  <li class="active" style=""><a >วีดีโอ</a></li>
  <li style="cursor: pointer;"><a onclick="tab('1')">แหล่งที่มา</a></li>
</ul>
<div class="row" > 
<?php   
$s_video = $db->query("SELECT * FROM article_video WHERE n_id = '{$nid}' ");
$a_row = $db->db_num_rows($s_video);   
if($a_row){	
$i = 1;
while($a_video = $db->db_fetch_array($s_video)) {
	
	if($a_video['av_filename'] != ""){
	$type = "mp4";
}else{
	$type = "youtube";
}

?>

<div class="col-md-3 col-sm-3 col-xs-12" style="padding: 15px;">
<div class="panel panel-default border_dashed" style="">
<div style="margin-top: 5px;text-align:right;">
<a onclick="boxPopup('<?=linkboxPopup();?>pop_view_vdo.php?nid=<?=$nid;?>&vid=<?=$a_video['av_id'];?>');" data-toggle="tooltip" data-placement="right" title="ดูวีดีโอ" >
<button type="button" class="btn btn-info  btn-xs " >
<span class="glyphicon glyphicon-search"></span>
</button>
</a>
<a onclick="JQDelete(<?=$a_video['av_id'];?>);" data-toggle="tooltip" data-placement="right" title="ลบข้อมูล" >
<button type="button" class="btn btn-danger  btn-xs del-img"  >
<span class="glyphicon glyphicon-trash"></span>
</button>
</a>
<a  onclick="boxPopup('<?=linkboxPopup();?>pop_edit_vdo.php?nid=<?=$nid;?>&vid=<?=$a_video['av_id'];?>&Flag=EditVdo');" data-toggle="tooltip" data-placement="right" title="แก้ไขข้อมูล" >
<button type="button" class="btn btn-default  btn-xs">
<span class="glyphicon glyphicon-pencil"></span>
</button>
</a>
</div> 
<div class="panel-body" style="margin:5px;padding-top:20px; word-wrap: break-word;text-align:left;"> 
<div style="border: 0.5px solid #cbcccc;;padding: 5px;border-radius: 5px;">
<?php
$vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $a_video['av_filenameyoutube']);
$vdo_tempimg = explode('&',$vdo_fileyoutube);
$v_num = count($vdo_tempimg);
if($v_num > 1){
	$fileyoutube = $vdo_tempimg[0];
}else{
	$fileyoutube = $vdo_fileyoutube;
}

$vdo_image = "../images/pic_preview.gif";
 
if($a_video['av_filename'] != ""){	
echo "<img src=\"".$vdo_image."\" alt=\"".$a_video['av_filename']."\"  width=\"187\" height=\"140.25\" title=\"".$a_video['av_filename']."\" class=\"img-responsive\"/>";		
//echo "<video class=\"mejs-wmp\" id=\"vplayer".$i."\" width=\"100%\" height=\"300\" src=\"".$a_vdo['vdo_filename']."\" poster=\"".$vdo_image."\"  type=\"video/mp4\" controls=\"controls\" preload=\"none\"></video>";	
}else{ 
	echo "<img src=\"https://i.ytimg.com/vi/".$fileyoutube."/sddefault.jpg\" alt=\"".$a_video['av_filenameyoutube']."\"  title=\"".$a_video['av_filenameyoutube']."\" class=\"img-responsive\" />";
	//echo "<iframe  class=\"mejs-wmp \" width=\"100%\"  height=\"300\"  src=\"//www.youtube.com/embed/".$vdo_fileyoutube."?wmode=transparent&#038;iv_load_policy=3&#038;modestbranding=1&#038;rel=0&#038;autohide=1&#038;autoplay=0&#038;mute=0\" class=\"arve-inner\" allowfullscreen frameborder=\"0\" scrolling=\"no\"></iframe>";	
	} 
?>
</div>
</div>
</div>
</div>		
<?php 
 	
if($i%4 == '0'){
echo "<div class=\"clearfix\"></div>".PHP_EOL;
}

$i++;
	} 
}else{
	
	echo "<div class=\"col-md-12 col-sm-12 col-xs-12\" style=\"padding: 15px;text-align:center;\"><p class=\"text-danger\">".$txt_ewt_data_not_found."</p></div>";
}
?> 
</div> 

</div>


<div class="panel-body" style="background-color:#FFFFFF;display:none;" id="show2">
<ul class="nav nav-tabs">
  <li style="cursor: pointer;"><a  onclick="tab('2')">วีดีโอ</a></li>
  <li class="active"><a >แหล่งที่มา</a></li>
</ul>
<div class="row" > 
<?php   
/*$s_video = $db->query("SELECT * FROM article_video WHERE n_id = '{$nid}' ");
$a_row = $db->db_num_rows($s_video);   
if($a_row){	
$i = 1;
while($a_video = $db->db_fetch_array($s_video)) {
	
	if($a_video['av_filename'] != ""){
	$type = "mp4";
}else{
	$type = "youtube";
}*/
$s_article = $db->query("SELECT * FROM article_list WHERE n_id='{$nid}' ");
$a_row = $db->db_num_rows($s_article);

$a_article = $db->db_fetch_array($s_article);
	
if($a_article['n_address']){
$n_address = explode("###",$a_article['n_address']);
for($i = 0; $i < count($n_address); $i++ ){	
if($n_address[$i]!=''){  
$article = explode("#@#",$n_address[$i]);

?>
<div class="col-md-4 col-sm-4 col-xs-12" style="padding: 15px;">
<div class="panel panel-default border_dashed" style="">
<div style="margin-top: 5px;text-align:right;">
<a onclick="JQDelete(<?=$i;?>);" data-toggle="tooltip" data-placement="right" title="ลบข้อมูล" >
<button type="button" class="btn btn-danger  btn-xs del-img"  >
<span class="glyphicon glyphicon-trash"></span>
</button>
</a>
<a  onclick="boxPopup('<?=linkboxPopup();?>pop_edit_location.php?nid=<?=$nid;?>&i=<?=$i;?>&proc=Edit');" data-toggle="tooltip" data-placement="right" title="แก้ไขข้อมูล" >
<button type="button" class="btn btn-default  btn-xs">
<span class="glyphicon glyphicon-pencil"></span>
</button>
</a>
</div> 
<div class="panel-body" style="margin:5px;padding-top:20px; word-wrap: break-word;text-align:left;"> 
<div class="form-group row"  >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="แหล่งที่มาไฟล์วิดีโอ ";?> : </label>&nbsp;<?=$article[0];?>
<input name="n_address1<?=$i;?>" type="hidden" class="form-control" value="<?=$article[0];?>" />

</div>
</div>

<div class="form-group row"  >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="url";?> :  </label>&nbsp;<?=$article[1];?>
<input name="n_address2<?=$i;?>" type="hidden" class="form-control" value="<?=$article[0];?>" />

</div>
</div>

</div>
</div>
</div>		
<?php 
}
	}
		}else{
	
	echo "<div class=\"col-md-12 col-sm-12 col-xs-12\" style=\"padding: 15px;text-align:center;\"><p class=\"text-danger\">".$txt_ewt_data_not_found."</p></div>";
}	
/*if($i%2 == '0'){
echo "<div class=\"clearfix\"></div>".PHP_EOL;
}

$i++;
	} 
}*/
?> 
</div> 
</div>

</form>
</div>
</div>
</div>
</div>
</div>



<iframe name="ftarget" id="ftarget" width="0" height="0"></iframe>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script>
	function JQDelete(id){
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-exclamation-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_img.php',
											data:{'id': id,'nid':<?=$nid;?>,'proc':'DelArtVdo'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'url:text.html',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: 'ตกลง',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}
  function boxPopup(link)
  {
    $.ajax({
      type: 'GET',
      url: link,
      beforeSend: function() {
        $('#box_popup').html('');
      },
      success: function (data) {
        $('#box_popup').html(data);
      }
    });
    $('#box_popup').fadeIn();
  }

</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
		
});

</script>
<script>
function showpic(c,d,e,f,g){
d.removeAttribute("height");
d.removeAttribute("width");

	if(g.checked == true){
		 d.height = e.value;
		 d.width = f.value;
	}else{
		e.value = d.height;
		f.value = d.width;
	}
}
function chkU(c,d){
	if(c.fileb.value != ""){
	c.submit();
	c.style.display='none';
	d.style.display='';
	d.src = "../images/loading.gif";
	}
}
function chkE(c,d){
	c.Flag.value = "EEdit";
	c.submit();
	c.style.display='none';
	d.style.display='';
	d.src = "../images/loading.gif";
}
function chkED(c,d){
	c.Flag.value = "Editor";
	c.submit();
	c.style.display='none';
	d.style.display='';
	d.src = "../images/loading.gif";
}
function cancED(c,d){
	c.Flag.value = "C";
	c.submit();
	c.style.display='none';
	d.style.display='';
	d.src = "../images/loading.gif";
}
function DelP(c,d){
	if(confirm('Are you sure to delete this picture?')){
		c.Flag.value = "EDel";
		c.submit();
		c.style.display='none';
		d.style.display='';
		d.src = "../images/loading.gif";
	}
}
function activeC(c,d,e){
	if(c.value != ""){
	d.style.display='';
	e.disabled = false;
	}
}
function ShowEdit(c){
	c.style.display='';
}


function tab(id){

if(id=='1'){	

document.getElementById("show1").style.display='none';
document.getElementById("show2").style.display='';
$('#btn2').show();
$('#btn1').hide();	
}else{
	
document.getElementById("show1").style.display='';
document.getElementById("show2").style.display='none';
$('#btn1').show();
$('#btn2').hide();	
	
	}
}

</script>

