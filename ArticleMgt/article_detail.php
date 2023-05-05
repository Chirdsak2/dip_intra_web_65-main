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

.border_dashed { 
   margin-top: 10px;
   margin-right: 0px;
   margin-bottom: 5px;
   margin-left: 0px;
   padding:0px 10px 10px 10px;
   _border-top: 2px dashed #cbcccc;
   border-top: 2px dashed #cbcccc;
   border-bottom: 2px dashed #cbcccc;
   border-right: 2px dashed #cbcccc;
   border-left: 2px dashed #cbcccc;
   text-align:center;
}
.border_dashed:hover { 
   border-top: 2px dashed #cbcccc;
   border-bottom: 2px dashed #cbcccc;
   border-right: 2px dashed #cbcccc;
   border-left: 2px dashed #cbcccc;
   background-color:#f9f9f9;
   
}
.jFiler-input-icon {
    font-size: 48px;
    margin-top: -10px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
img {
    max-width: 100%;
    height: auto;
}

</style>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<h4><b><?php echo $txt_article_detail;?></b></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="permission_user.php"><?php echo $txt_permission_menu_user;?></a></li>
<li class=""><?php echo $txt_permission_set;?></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >
<a  onclick="self.location.href='article_upload_file.php?nid=<?php echo $nid;?>&cid=<?php echo $R['c_id']?>';" title="เพิ่มเอกสารแนบ" >
<button type="button" class="btn btn-success btn-ml" >
<i class="fas fa-edit"></i>&nbsp;เพิ่มเอกสารแนบ
</button>
</a>
&nbsp;
<a href="article_edit.php?nid=<?php echo $nid;?>" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right"> 
			<li><a href="article_edit.php?nid=<?php echo $nid;?>" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?></a></li>
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

<div class="col-md-12 col-sm-12 col-xs-12" >
<form action="article_function.php" method="post" enctype="multipart/form-data" name="form1" target="ftarget">
<!--<div class="page-header">
<h4>การแสดงในหน้ารายละเอียด</h4>      
</div>-->
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="checkbox">
<label>
<input name="chk_date" type="checkbox" id="chk_date" value="1" <?php echo "checked"; /*if($R["show_date"] =='1'){ echo "checked";}*/?> />
แสดงวันที่
<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
</label>

<label>
<input name="chk_show_count" type="checkbox" id="chk_show_count" value="1"  <?php echo "checked"; /*if($R["show_count"] =='1'){ echo "checked";}*/?> />
แสดงจำนวนการเข้าอ่าน[ครั้ง] 
<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
</label>

<!-- <label>
<input name="chk_newsshow" type="checkbox" id="chk_newsshow" value="1" <?php echo "checked"; /*if($R["show_newstop"] =='1'){ echo "checked";}*/?> />
ข่าว/บทความ 5 อันดับสูงสุด 
<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
</label>

<label>
<input name="chk_vote" type="checkbox" id="chk_vote" value="1" <?php if($R["show_vote"] =='1'){ echo "checked";}?> />
โหวตคะแนนให้ข่าว/บทความ
<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
</label> -->
<!--
<label> 
<input name="comment_type" type="hidden" id="comment_type" value="1" <?php if($R["comment_type"] =='2'){ echo "checked";}?> />
<input name="chk_comment" type="checkbox" id="chk_comment" value="1" <?php echo "checked"; /*if($R["show_comment"] == '1'){ echo "checked";}*/?> />
แสดงความคิดเห็นเพิ่มเติม
<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
</label>-->

</div>

<?php
/*<div class="form-inline"> 
<input name="chk_date" type="checkbox" id="chk_date" value="1" <?php if($R["show_date"] =='1' OR $R["show_date"] ==''){ echo "checked";}?> />
แสดงวันที่
<!-- <input name="chk_textsize" type="checkbox" id="chk_textsize" value="1" <?php //if($R["show_textsize"] =='1'){ echo "checked";}?> />
 แสดงเครื่องมือปรับขนาดอักษร -->
<input name="chk_show_count" type="checkbox" id="chk_show_count" value="1"  <?php if($R["show_count"] =='1' OR $R["show_count"] ==''){ echo checked;}?> />
แสดงจำนวนการเข้าอ่าน[ครั้ง] 
<input name="chk_newsshow" type="checkbox" id="chk_newsshow" value="1" <?php if($R["show_newstop"] =='1'){ echo "checked";}?> />
ข่าว/บทความ 5 อันดับสูงสุด 
<input name="chk_vote" type="checkbox" id="chk_vote" value="1" <?php if($R["show_vote"] =='1'){ echo "checked";}?> />
โหวตคะแนนให้ข่าว/บทความ
<input name="chk_comment" type="checkbox" id="chk_comment" value="1" <?php if($R["show_comment"] =='1'){ echo checked;}?> onClick="if(this.checked){document.all.comment_type.style.display='';}else{document.all.comment_type.style.display='none';}" />
แสดงความคิดเห็นเพิ่มเติม
<select name="comment_type" id="comment_type" class="form-control" >
<option value="1" <?php if($R['comment_type'] =='1'){ echo "selected";}?> >ทุกคนแสดงความคิดเห็นได้</option>
<option value="2" <?php if($R['comment_type'] =='2'){ echo "selected";}?> >Login ก่อนแสดงความคิดเห็น</option>
</select>
</div>*/
?>


</div>
</div>

<div class="panel panel-default">
<div class="panel-heading form-inline" style="text-align:right;">
<!--<div class="dropdown" style="color: #fff;border-color: #46b8da;"> 	
  <button class="btn btn-info btn-ml dropdown-toggle" type="button" data-toggle="dropdown">จัดการข้อมูล
  <span class="caret"></span></button>
  <ul class="dropdown-menu dropdown-menu-right">
    <li><a href="#" onClick="document.form1.n_action.value='save';form1.submit();">Update</a></li>
    <li><a href="#" onClick="window.open('','artpv','width=800,height=550,resizable=1,scrollbars=1'); document.form1.n_action.value='preview';form1.submit();" >Preview</a></li>
    <li><a href="#" onClick="document.form1.n_action.value='exit';form1.submit();" >Save &amp; Exit</a></li>
	<!--<li><a href="#">Cancel this article</a></li>->
  </ul>
</div>-->
<input name="Flag" type="hidden" id="Flag" value="NewsDetail" />
<input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>" />
<input name="cid" type="hidden" id="cid" value="<?php echo $R['c_id']; ?>" />
<input name="n_action" type="hidden" id="n_action">
<input type="hidden" name="backto" value="<?php if($_SESSION["EWT_OPEN_ARTICLE"] == ""){ echo "article_group.php"; }else{ echo "article_list.php?cid=".$_SESSION["EWT_OPEN_ARTICLE"]; } ?>">

	<a href="#" target="_self" onclick="document.form1.n_action.value='save';form1.submit();">
	<button type="button" class="btn btn-info  btn-sm " onclick="document.form1.n_action.value='save';form1.submit();" >
	<span class="glyphicon glyphicon-floppy-save"></span>&nbsp;<?php echo "Update";?>
	</button>
	</a>
	<a href="#" target="_self" onClick="window.open('','artpv','width=1000,height=550,resizable=1,scrollbars=1'); document.form1.n_action.value='preview';form1.submit();">
	<button type="button" class="btn btn-info  btn-sm " >
	<span class="glyphicon glyphicon-zoom-in"></span>&nbsp;<?php echo "Preview";?>
	</button>
	</a>
	<a href="#" target="_self" onClick="document.form1.n_action.value='exit';form1.submit();" >
	<button type="button" class="btn btn-info  btn-sm "  >
	<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?php echo "Save &amp; Exit";?>
	</button>
	</a>
	<!--<a href="article_group.php" target="_self">
	<button type="button" class="btn btn-success  btn-ml " >
	<span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;<?php echo "Cancel this article";?>
	</button>
	</a>-->
</div>

<div class="panel-body" style="background-color:#FFFFFF;">
  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12" > 
  <div class="panel panel-default border_dashed">
  <div class="panel-body" style="margin:5px;padding-top:20px; word-wrap: break-word;text-align:left;"> 
  <?php echo $R["n_topic"];?>
  </div>
  </div>
  </div>
  
<?php 

$_host = $_SERVER['HTTP_HOST'];	
$_name = $_SERVER['SCRIPT_NAME'];
$_url = $_SERVER['REQUEST_URI'];	
$_protocal = 'http';
	
	function getEwt1($_url){
	
   $s_method = strtok($_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/";
		
		return  $chk_site;
	}
}

$_directory = getEwt1($_url);

$sql_article_detail_11 = $db->query("SELECT * FROM article_detail WHERE n_id = '{$nid}' AND at_type_row = '11' AND at_type_col = '1' ORDER BY ad_id DESC, at_type_row ASC LIMIT 1"); 
$a_detail_11 = $db->db_fetch_array($sql_article_detail_11);
//$a_detail_11['ad_des'] = eregi_replace($_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/","images/",$a_detail_11['ad_des']);
//$a_detail_11['ad_des'] = eregi_replace("images/",$_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/",$a_detail_11['ad_des']);	

$a_detail_11['ad_des'] = preg_replace('/(src=\")(.*)(\images)/','$1'.$_protocal.'://'.$_host.$_directory.'ewt/'.$_SESSION['EWT_SUSER'].'/$3',$a_detail_11['ad_des']);


if($a_detail_11['at_type_row'] == '11' ){	
if($a_detail_11['ad_pic_b'] == '' AND $a_detail_11['ad_des'] == '' ){
?>
	<div class="col-md-12 col-sm-12 col-xs-12" >
	<div class="panel panel-default border_dashed" >
	<div class="panel-body">
	<div class="" style="margin-top: 30px;">
	<span class="glyphicon glyphicon-cloud-upload" style="font-size:72px;color:#5bc0de;"></span>
	</div>
	<div class="" style="margin-top: 30px;">
	<button type="button" class="btn btn-info btn-sm" onclick="boxPopup('<?php echo linkboxPopup();?>pop_edit_img.php?nid=<?php echo $nid;?>&col=<?php echo $a_detail_11['at_type_col'];?>&row=<?php echo $a_detail_11['at_type_row'];?>&ad_pic_b=<?php echo $a_detail_11['ad_pic_b'];?>&ad_pic_s=<?php echo $a_detail_11['ad_pic_s'];?>&ad_id=<?php echo $a_detail_11['ad_id'];?>');"> คลิกเพื่อใส่ข้อมูล</button>
	</div>
	</div>
	</div>
	</div>
<?php }else{ ?>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="panel panel-default border_dashed">
<div style="margin-top: 5px;text-align:right;">
<a onclick="boxPopup('<?php echo linkboxPopup();?>pop_view_detail.php?nid=<?php echo $nid;?>&ad_id=<?php echo $a_detail_11['ad_id'];?>&row=<?php echo $a_detail_11['at_type_row'];?>');" data-toggle="tooltip" data-placement="right" title="ดูรายละเอียด" >
<button type="button" class="btn btn-info  btn-xs " >
<span class="glyphicon glyphicon-search"></span>
</button>
</a>

<a onclick="JQDelete(<?php echo $a_detail_11['ad_id'];?>);" data-toggle="tooltip" data-placement="right" title="ลบข้อมูล" >
<button type="button" class="btn btn-danger  btn-xs del-img"  >
<span class="glyphicon glyphicon-trash"></span>
</button>
</a>

<a onclick="boxPopup('<?php echo linkboxPopup();?>pop_edit_img.php?nid=<?php echo $nid;?>&col=<?php echo $a_detail_11['at_type_col'];?>&row=<?php echo $a_detail_11['at_type_row'];?>&ad_pic_b=<?php echo $a_detail_11['ad_pic_b'];?>&ad_pic_s=<?php echo $a_detail_11['ad_pic_s'];?>&ad_id=<?php echo $a_detail_11['ad_id'];?>');"  data-toggle="tooltip" data-placement="right" title="แก้ไขข้อมูล" >
<button type="button" class="btn btn-default  btn-xs " >
<span class="glyphicon glyphicon-pencil"></span>
</button>
</a>
</div>
<div class="panel-body" style="margin:5px;padding-top:20px; word-wrap: break-word;text-align:left;"> 
<span>
<?php echo $a_detail_11['ad_des'];?>
</span>
</div>
</div>
</div>		
<?php 
} 
}
 
$sql_article_detail = $db->query("SELECT * FROM article_detail WHERE n_id = '{$nid}' ORDER BY at_type_row ASC "); 
$i = 1;
while($a_detail = $db->db_fetch_array($sql_article_detail)){

//$a_detail['ad_des'] = eregi_replace($_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/","images/",$a_detail['ad_des']);
//$a_detail['ad_des'] = eregi_replace("images/",$_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/",$a_detail['ad_des']);	
$a_detail['ad_des'] = preg_replace('/(src=\")(.*)(\images)/','$1'.$_protocal.'://'.$_host.$_directory.'ewt/'.$_SESSION['EWT_SUSER'].'/$3',$a_detail['ad_des']);

if($a_detail['at_type_row'] != '11'){		
if($a_detail['ad_pic_b'] == '' AND $a_detail['ad_des'] == '' ){
?>
  <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 10px;" >
  <div class="panel panel-default border_dashed" style="height:220px;">
  <div class="panel-body">
  <div class="" style="margin-top: 30px;">
  <span class="glyphicon glyphicon-cloud-upload" style="font-size:72px;color:#5bc0de;"></span>
  </div>
  <div class="" style="margin-top: 30px;">
  <button type="button" class="btn btn-info btn-sm" _style="border-color:#5bc0de;" onclick="boxPopup('<?php echo linkboxPopup();?>pop_edit_img.php?nid=<?php echo $nid;?>&col=<?php echo $a_detail['at_type_col'];?>&row=<?php echo $a_detail['at_type_row'];?>&ad_pic_b=<?php echo $a_detail['ad_pic_b'];?>&ad_pic_s=<?php echo $a_detail['ad_pic_s'];?>&ad_id=<?php echo $a_detail['ad_id'];?>');" > คลิกเพื่อใส่ข้อมูล</button>
  </div>
  </div>
  </div>
  </div>
<?php }else{ ?>
<div class="col-md-4 col-sm-4 col-xs-12" style="padding: 10px;">

<div class="panel panel-default border_dashed">

<div style="margin-top: 5px;text-align:right;">
<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $a_detail['ad_id'];?>" />

<a onclick="boxPopup('<?php echo linkboxPopup();?>pop_view_detail.php?nid=<?php echo $nid;?>&ad_id=<?php echo $a_detail['ad_id'];?>');" data-toggle="tooltip" data-placement="right" title="ดูรายละเอียด" >
<button type="button" class="btn btn-info  btn-xs " >
<span class="glyphicon glyphicon-search"></span>
</button>
</a>

<a onclick="JQDelete(<?php echo $a_detail['ad_id'];?>);" data-toggle="tooltip" data-placement="right" title="ลบข้อมูล" >
<button type="button" class="btn btn-danger  btn-xs del-img"  >
<span class="glyphicon glyphicon-trash"></span>
</button>
</a>
<a  onclick="boxPopup('<?php echo linkboxPopup();?>pop_edit_img.php?nid=<?php echo $nid;?>&col=<?php echo $a_detail['at_type_col'];?>&row=<?php echo $a_detail['at_type_row'];?>&ad_pic_b=<?php echo $a_detail['ad_pic_b'];?>&ad_pic_s=<?php echo $a_detail['ad_pic_s'];?>&ad_id=<?php echo $a_detail['ad_id'];?>');" data-toggle="tooltip" data-placement="right" title="แก้ไขข้อมูล" >
<button type="button" class="btn btn-default  btn-xs">
<span class="glyphicon glyphicon-pencil"></span>
</button>
</a>
</div> 
 

<div class="panel-body" style="margin:5px;padding-top:20px; word-wrap: break-word;text-align:center;"> 
<div style="border: 0.5px solid #cbcccc;padding: 5px;border-radius: 5px;">
<img src="<?php if($a_detail['ad_pic_b'] != ""){ echo "../ewt/".$_SESSION['EWT_SUSER']."/images/article/news".$nid."/".$a_detail['ad_pic_b']; }else{ echo "../images/pic_preview.gif"; } ?>" class="img-responsive" style="width:100%;height:225px; " />

</div>
</br>
<span style=""><?php echo $a_detail['ad_des'];?></span>
</div>

</div>
	
</div>
	
<?php 
} 
	}
if($i%3 == '0'){
//echo "<div class=\"clearfix\"></div>".PHP_EOL;
}

$i++;
	} 

?> 
</div> 
</div>
</form>
<iframe name="ftarget" id="ftarget" width="0" height="0"></iframe>
</div>

</div>
</div>
</div>
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
var adid = $('#ad_id').val();

//$('.del-img').on('click', function () {
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
											data:{'id': id,'proc':'DelArtImg'},
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
				
function FuncDelete(id)
  {
	alert(id);
	$.ajax({
      type: 'GET',
      url: 'proc_delete_img.php',
	  data:{"id": id},
      success: function (data) {
        //$('#box_popup').html(data);
      }
    }); 
	//alert(id);
}

$(document).ready(function(){
	
	if(document.form1.chk_comment.checked){
			  document.all.comment_type.style.display='';
			  }else{
			  document.all.comment_type.style.display='none';
	}
	
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

</script>

