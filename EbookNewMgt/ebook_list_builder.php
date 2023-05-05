<?php
include("../EWT_ADMIN/comtop.php");
?> 

<link href="../js/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css" rel="stylesheet">
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");


$ebook_code = (!isset($_GET['ebook_code']) ? '' : $_GET['ebook_code']);
$c_id = (int)(!isset($_GET['c_id']) ? '' : $_GET['c_id']);

$s_sql 	= $db->query("SELECT * FROM ebook_group WHERE g_ebook_id = '{$c_id}' ");
$a_data_cate = $db->db_fetch_array($s_sql);  

$s_sql_info  = $db->query("SELECT * FROM ebook_info WHERE ebook_code = '{$ebook_code}' ");
$a_data_info = $db->db_fetch_array($s_sql_info);  

$s_sql_v = $db->query("SELECT * 
					FROM ebook_value
					WHERE 1=1 ORDER BY ebook_value_id DESC");
$a_data_v = $db->db_fetch_array($s_sql_v); 



$dest = "../ewt/".$_SESSION["EWT_SUSER"]."/ebook/".$ebook_code; //Source ebook
$destPage = $dest.'/pages/';


function FuncSizeValue($id)
{
	global $db;
	if($id)
	{
	$_sql = $db->query("SELECT 
						* 
						FROM ebook_value
						WHERE ebook_value_id = '{$id}' 
						");
			  
	$a_data = $db->db_fetch_array($_sql);	
	return $a_data['ebook_value'];
	}	
}

function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "." , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}
function Extension($filename) 
{
	$file_extension = strtolower(substr(strrchr($filename,"."),1));
	switch ($file_extension) {
		case "pdf": $ctype='<i class="fas fa-file-pdf text-danger fa-lg"></i>'; break;
		case "exe": $ctype='<i class="fas fa-file text-info fa-lg"></i>'; break;
		case "zip": case "rar": $ctype='<i class="fas fa-file-archive text-danger fa-lg"></i>'; break;
		case "doc": case "docx": $ctype='<i class="fas fa-file-word text-info fa-lg"></i>'; break;
		case "xls": case "xlsx": $ctype='<i class="fas fa-file-excel text-success fa-lg"></i>'; break;
		case "csv": case "xlsx": $ctype='<i class="fas fa-file-csv text-success fa-lg"></i>'; break;
		case "ppt": case "pptm": $ctype='<i class="fas fa-file-powerpoint text-warning fa-lg"></i>'; break;
		case "gif": $ctype='<i class="fas fa-file-video text-info fa-lg"></i>'; break;
		case "png": $ctype='<i class="fas fa-file-image text-info fa-lg"></i>'; break;
		case "jpe": case "jpeg": case "jpg": $ctype='<i class="fas fa-file-image text-info fa-lg"></i>'; break;
		default: $ctype='<i class="fas fa-file text-info fa-lg"></i>';;
		}
	return $ctype;
    }
					
$perpage = 5;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * FROM ebook_page WHERE ebook_code = '{$ebook_code}'  ORDER BY ebook_page DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(ebook_page) AS b
			  FROM ebook_page 
			  WHERE ebook_code = '{$ebook_code}'  {$wh} ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);

?>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo 'จัดการหน้า e-Book';?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<!--<ol class="breadcrumb">
<li><a href="menu_list.php"><?php echo $txt_menu_menu_main;?></a></li>
<li><?php echo $txt_menu_menu_builder;?></li> 
<li><?php echo $a_menu['m_name'];?></li> 
</ol>-->
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<!--<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_menu.php');" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_menu_add;?>
</button>

<button type="button" class="btn btn-info  btn-ml " onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_menu.php');" >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?>
</button>-->

<a href="ebook_list.php?c_id=<?php echo $c_id;?>" target="_self" title="<?php echo $txt_ewt_back;?>">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  > 
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right pointer">
            <li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_menu.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_menu_add;;?></a></li>
          	<!--<li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search_menu.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?></a></li>-->
			<li><a href="ebook_list.php?c_id=<?php echo $c_id;?>" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?></a></li>
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->


<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >

<div class="card-title text-left color-white">
<i class="fas fa-bars color-white fa-1x"></i> e-Book : &quot; <?php echo $a_data_info['ebook_name'];?> &quot; 
</div>
</div>
<div class="card-body m-b-sm" id="card-view">
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_ebook_list_builder')?>" enctype="multipart/form-data" >
<?php 
if(empty($refPage)) 
{ //ADD
	$recPage = $db->db_fetch_array($db->query("select * from ebook_page where ebook_code like '{$ebook_code}' order by ebook_page desc"));
	$refPage = ($recPage['ebook_page']+1);	
}
if(empty($amtFile)) 
{
	$amtFile = 1;
}
?>
<input name="amtFile" type="hidden" value="<?php echo $amtFile;?>">
<input name="lastPage" type="hidden"  value="<?php echo $refPage;?>">
	
<div class="row m-b-sm m-t-xx" > 
<div class="col-md-offset-3 col-md-6" >

<div class="form-row"> 
<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 " id="file-brows">
<legend>Upload file Image Or PDF</legend>
<div class="form-inline m-b-sm"> 
<div class="radio">
  <label><input type="radio" name="show_image" id="show_image" class="show_image" value="1" _onclick="JSChange(this.value);" checked >
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><b>Image </b> 
  </label>
</div>

<div class="radio">
  <label><input type="radio" name="show_image" id="show_image" class="show_image" value="2" _onclick="JSChange(this.value);" >
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><b>PDF </b>
  </label>
</div>
</div> 
<!--<input type="file" name="cont_pic[]" id="cont_pic" data-type-file="multi-file-uploader" accept="image/*" multiple>-->
<input type="file" name="file_pic[]" id="file_pic" data-type-file="multi-file-uploader" onchange="JSCheckImage(this.id,this.value);" accept="image/*" multiple>

<div id="size-pic">
<label for="pic_hidden" hidden><b>ไฟล์ GIF,PNG,JPG,JPEG</b></label>	
<input type="hidden" name="pic_hidden" id="pic_hidden" value="">
<br>   
<span class="text-danger"><code>ไฟล์นามสกุล GIF,PNG,JPG,JPEG</code></span> 
<span class="text-danger"><code>ขนาดไฟล์ไม่เกิน <?php echo FuncSizeValue('1');?> MB. </code></span> 
</div>

<div class="file-upload-drag " id="layout-pdf" style="display:none;">
<b>PDF Output:</b> 
<div class="form-group row " >
<div class="col-md-6 col-sm-6 col-xs-12" >
<label for="zoom" class=""><b><?php echo 'Zoom';?> <span class="text-danger"><code>*</code></span> :</b></label> 
<div class="input-group">
<input class="form-control checknumber" onkeyup="Func_CheckNumber(this.value);" size="3" placeholder="Zoom" name="zoom" type="text" id="zoom"  value="100"  aria-describedby="basic-addon2" />
 <span class="input-group-addon" id="basic-addon2">%</span>
</div>
<p class="text-danger"><code>Ex. 100 %</code></p> 
</div>

<div class="col-md-6 col-sm-6 col-xs-12" >
<label for="quality" class=""><b><?php echo 'Quality';?> <span class="text-danger"><code>*</code></span> :</b></label> 
<div class="input-group">
<input class="form-control checknumber" size="3" placeholder="Quality" name="quality" type="text" id="quality"  value="100"  aria-describedby="basic-addon2" />
 <span class="input-group-addon" id="basic-addon2">%</span>
</div>
<p class="text-danger"><code>Ex. 100 %</code></p>
</div>
</div>
	<div class="image-upload-wrap"> 
	<label for="file_pdf" hidden><b>ไฟล์ Pdf</b></label>	
    <input class="file-upload-input" name="file_pdf" id="file_pdf" type="file" onchange="readURL(this);JSCheckPDF(this.id,this.value);" accept="application/pdf" >
    <div class="drag-icon1"> 
	<i class="fas fa-cloud-upload-alt " style="font-size: 7em;"></i>
	</div>	 
	<div class="drag-text" style="font-size: 14px;padding: 10px;"> 
		Choose Your Pdf to Upload	
    </div>
	<div class="drag-text" style="font-size: 14px;padding: 10px;"> 
	or Drag and Drop your Pdf Here
	 </div>
	</div>
	<div class="file-upload-content"> 
	</div>	
<br>
<span class="text-danger"><code>ไฟล์นามสกุล PDF ขนาดไฟล์ไม่เกิน <?php echo FuncSizeValue('2');?> MB. </code></span>
</div>

</div>
<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12  text-center">
<!--<button  type="submit" id="submitBtnImg" class="btn btn-success  btn-ml m-t-xxl text-center submitBtn" >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>  
</button> -->
<button _style="display:none;" onclick="JQAdd_Ebook($('#form_main'));" type="button" id="submitBtnPdf" class="btn btn-success  btn-ml m-t-xxl text-center submitBtn" >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>  
</button>
</div>
</div>
</div>
</div>
<input type="hidden" name="c_id" value="<?php echo $c_id;?>"> 
<input type="hidden" name="ebookCode" value="<?php echo $ebook_code;?>">  
<input type="hidden" name="proc" value="savePage">
<input type="hidden" name="mode" value="add<?php echo $mode;?>">


<hr>

<div class="row" id="table-view">
<div class="col-md-offset-2 col-md-8"  id="tc_table_file">  
<a href="../ewt/gistda_web/ebook/<?php echo $ebook_code;?>/index.html#p=0" target="_blank" > 
<button  type="button" class="btn btn-info  btn-ml text-right float-right m-b-sm " >
<i class="fas fa-book-open"></i>&nbsp;View e-Book
</button>
</a>
<h5> จำนวน <?php echo $total_record;?> หน้า</h5>	
<table class="table table-striped file_list tablesorter"  >
  <tbody>
	<tr class="directory">
	<th class="text-center">
	<?php 
	if($a_rows) 
	{	
	?>
	<input class="btn btn-warning btn-sm"  name="btn_chk_all" id="btn_chk_all" type="button" onclick="chk_all(this);" value="ทั้งหมด"> 
	<?php 
	}
	?>
	</th>
	<th class="text-center"><b>view </b></th>
	<th class="text-center"><b>หน้า </b></th>
	<th class="text-center size"><b>ขนาด </b></th>
	<th class="text-center date"><b>วันที่แก้ไข </b></th>
	</tr>
<?php
if($start==0){
$i=1;
}else{
$i=$start+1;	
}
	
if($a_rows > 0)
{	
while($a_data = $db->db_fetch_array($_sql))
{	

	$arrDate = explode ('-',$a_data['ebook_page_date']);
		
?>
	<tr class="directory" >
	<td class="chkboxes text-center">
	<div class="checkbox">
        <label>
		<input onclick="" name="del" id="del" type="checkbox" class="delpage" value="<?php echo $a_data['ebook_page'];?>">
        <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
       </label>
	</div>
	</td>
	<td class="chkboxes text-center">
	<button onClick="boxPopup('<?php echo linkboxPopup();?>pop_view_page.php?p=<?php echo $a_data['ebook_page'];?>&ebook_code=<?php echo $ebook_code;?>');" type="button" class="btn btn-info  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ebook_list_view;?>" >
	<i class="fas fa-search" aria-hidden="true"></i>
	</button> 
	</td>
	
	<td class="filename text-center" ><?php echo $a_data['ebook_page'];?> <?php echo Extension($a_data['ebook_page_file']);?>  </td>     
	<td class="filetype text-center size" data-sort-size="<?php echo $destPage.$a_data['ebook_page_file'];?>" >
	<?php echo FileSizeConvert(filesize($destPage.$a_data['ebook_page_file']));?>
	</td>	 
	<td class="filetype text-center date"><?php echo $arrDate['2'].'/'.$arrDate['1'].'/'.$arrDate['0'];?></td> 

	</tr> 
	
<?php 
$i++;
} 
	}
	else
	{ 
?>
<tr class="directory" > 
<td colspan="5"><p class="text-center text-danger">No Data<?php echo $lang_survey_nodata; ?></p></td>
</tr>
<?php } ?>

<?php
if($a_rows > 0)
{	
?>
<tr >
<td  class="text-center">
<button  type="button" class="btn btn-danger btn-sm " onclick="JQDelEbookPage();" id="delpage" >
<i class="fas fa-trash-alt"></i> ลบ
</button>
</td>
<td  colspan="4"></td>
</tr> 
<?php
}
?> 	
</tbody>



</table>
<?php echo pagination_ewt($statement,$perpage,$page,$url='?ebook_code='.$_GET['ebook_code'].'&c_id='.$_GET['c_id'].'&');?>
</div>	
</div>
</form> 
</div> 
<div class="card-body" id="loaderP" style="display:none;">	
	<div class="container_loader">
	<div class="circle_loader circle-1"></div>
	<div class="circle_loader circle-2"></div>
	<div class="circle_loader circle-3"></div>
	<div class="circle_loader circle-4"></div>
	<div class="circle_loader circle-0"></div> 
	</div> 	 
</div>	 
 			
</div> 
</div>

</div>
<!--END card-body -->
</div>
<!--END card -->
</div>
</div>
</div>
<!-- END CONTAINER  -->
</div>

<?php
include("../EWT_ADMIN/combottom.php");
?>
 
<link href="../js/imageuploadify/dist/imageuploadify.min.css" rel="stylesheet">
<script type="text/javascript" src="../js/imageuploadify/imageuploadify.js"></script>
<script src="../js/sortable-jQuery-lists/jquery-sortable-lists.js"></script>
<script src="../js/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.js"></script>
<style>
<!--
.image-upload-wrap {
	margin-top: 0px;
	border-radius: 4px;
	border: 2px dashed #87CEFA;
	background-color: #87CEFA;
	color:#FFFFFF;
}
.image-dropping,
.image-upload-wrap:hover {
	background-color: rgb(255, 255, 255);
	border-radius: 4px;
	border: 2px dashed #87CEFA;
	color:#87CEFA;
}
.file-upload-input { 
	min-width: 250px;
    max-width: 1000px;
	height: 400px; 
	width: 100%;
}
.file-upload-drag {
	padding: 0px;
	width: 100%;
}
.drag-icon1 {
    text-align: center;
    padding-top: 49px;
	padding-bottom: 21px;
}
-->
</style>
<style> 
body {
  overflow: hidden;
}

.container_loader {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40vh;
  overflow: hidden;
}

.circle_loader {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  margin: 7px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.circle_loader:before {
  content: "";
  width: 20px;
  height: 20px;
  border-radius: 50%;
  opacity: 0.7;
  animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
}
.circle-1 {
  background-color: #49b8e5;
}
.circle-1:before {
  background-color: #49b8e5;
  animation-delay: 200ms;
}
.circle-2 {
  background-color: #1e98d4;
}
.circle-2:before {
  background-color: #1e98d4;
  animation-delay: 400ms;
}
.circle-3 {
  background-color: #2a92d0;
}
.circle-3:before {
  background-color: #2a92d0;
  animation-delay: 600ms;
}
.circle-4 {
  background-color: #3a88c8;
}
.circle-4:before {
  background-color: #3a88c8;
  animation-delay: 800ms;
}
.circle-0 {
  background-color: #507cbe; 
}
.circle-0:before {
  background-color: #507cbe;
  animation-delay: 1000ms;
}
@keyframes scale {
  0% {
    transform: scale(1);
  }
  50%, 75% {
    transform: scale(2.5);
  }
  78%, 100% {
    opacity: 0;
  }
}

</style>  
<script>
$(document).ready(function(){
	
	$('input[data-type-file="multi-file-uploader"]').imageuploadify();
	$('#pic_hidden').attr('required',true);
	$('#delpage').attr("disabled","disabled");
	
	});
	
$(function(){ 
	$('.delpage').on("change", function(){   
	var ref= ""; 
	var checkboxes = document.getElementsByName('del');
	for (var i = 0; i < checkboxes.length; i++) 
	{
		if(checkboxes[i].checked == true)
		{
			ref = ref+checkboxes[i].value+",";
		}
	}
	if(ref)
	{
		$('#delpage').attr("disabled",false);
	}
	else
	{		
		$('#delpage').attr("disabled","disabled");
	}
	
	});
	
	$('.show_image').on("change", function(){   
		let  v = $( this ).val();	
		if(v == 1)
		{ 
			//alert(size); 
			$('#file_pic').attr('data-type-file','multi-file-uploader');
			$('input[data-type-file="multi-file-uploader"]').imageuploadify();
			$('#layout-pdf').hide();
			$('#file_pdf').val('');
			$('.image-upload-wrap').show();
			$('.file-upload-content').hide(); 
			$('#size-pic').css('display','');
			$('#file_pdf').attr('required',false);
	
			$('#pic_hidden').attr('required',true);
			//$('#submitBtnPdf').hide();
			//$('#submitBtnImg').show();
			
		}
		else if(v == 2)	
		{
			$('.imageuploadify').remove();
			$('#layout-pdf').show(); 
			$('#file_pic').attr('data-type-file','');
			$('#file_pic').val('');
			$('.image-upload-wrap').show();
			$('.file-upload-content').hide();
			$('#file_pdf').attr('required',true);
			$('#size-pic').css('display','none');
			$('#pic_hidden').attr('required',false);
			//$('#submitBtnPdf').show();
			//$('#submitBtnImg').hide();
		}
		
	});
	
		$('#file_pic').on("change", function(){  

			var totalfiles = document.getElementById('file_pic').files.length;
			if(totalfiles > 0)
			{
				 totalfiles += totalfiles; 
				
				$('#pic_hidden').val(totalfiles);
			}
			else
			{
				//$('#pic_hidden').val('');
			}
		
		});
    
});	
function chk_all(ele)
{
	var checkboxes = document.getElementsByName('del'); 
				
	if(ele.value=="ทั้งหมด")
	{
		for (var i = 0; i < checkboxes.length; i++)
		{
			checkboxes[i].checked = true;
		}
			ele.value="ยกเลิก";
		$('#delpage').attr("disabled",false); 	
	}
	else
	{
		for (var i = 0; i < checkboxes.length; i++)
		{
			checkboxes[i].checked = false;
		}
			ele.value="ทั้งหมด";
		$('#delpage').attr("disabled",true);	
	} 
}	
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader(); 
	let type = "<i class='fas fa-file-pdf'></i>";	
	let span = $("<span>" + type + "</span>");
	span.css("font-size", "60px");
	span.css("color", "#ff0000"); 
	let title = input.files[0].name;
	let span_title = $("<div>" + title + "</div>");
	span_title.css("font-size", "20px");
	span_title.css("color", "#ff0000"); 
	span.append(span_title);
	let remove ='<div style="padding-top:10px;text-align:left;"><button type="button" class="btn btn-danger  btn-circle  btn-sm " onclick="removeUpload();" data-toggle="tooltip" data-placement="top" title="Remove"   ><i class="glyphicon glyphicon-remove" aria-hidden="true"></i></button></div>';
    span.append(remove);
	reader.onload = function(e) {
		$('.image-upload-wrap').hide(); 
		$('.file-upload-content').show();
		$('.file-upload-content').append(span);
    };
	
    reader.readAsDataURL(input.files[0]);
  } else {
    removeUpload(); 
  }
}
function removeUpload() 
{
	$('.file-upload-content').html('');
	$('#file_pdf').val('');
	$('.image-upload-wrap').show();
	$('.file-upload-content').hide();
}

function JSChange1(ID) 
{
	if(ID == 1)
	{	
		$('#file_pic').show();
		$('#layout-pdf').hide();
	}
	else if(ID == 2)
	{
		$('#layout-pdf').show();
		$('#file_pic').hide(); 
	}
}  
function JQAdd_Ebook(form){  
$('#loader').fadeIn(); 	
var numItems = $('.imageuploadify-container').length;
var totalfiles = document.getElementById('file_pic').files.length; 
//alert(totalfiles);
var fail = CKSubmitData(form);
if (fail == false) {	
	var action  = form.attr('action'); 
	var method  = form.attr('method'); 
	var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  }  
		for (var index = 0; index < numItems; index++) 
		{
			//formData.append("file_pic[]", document.getElementById('file_pic').files[index]);
		}
			 $.confirm({
						title: '<?php echo "Upload file";?>',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										//form.submit();
										$.ajax({
											type: method,
											url: action,					
											data: formData ? formData : form.serialize(),
											async: true,
											processData: false,
											contentType: false,
											beforeSend: function(){
												$('.submitBtn').attr("disabled","disabled");												
											},
											success: function (data) {
												console.log(data);
												
												setTimeout(function () { 
													$('#loader').fadeOut();	
												}, 3000);														
												
												$.alert({
													title: '<?php echo $txt_ewt_action_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',
													onAction: function () { 
														
														self.location.href="ebook_list_builder.php?"+data;	  															
														$('#box_popup').fadeOut();
													}		
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="complain_builder.php?com_cid="+data;											
												//$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									//$('#box_popup').fadeOut(); 
									$('#loader').fadeOut();	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					}
					else
					{
						$('#loader').fadeOut();	
					}						
								
	
}

/*$("#form_main").submit(function(e) { 

	e.preventDefault();

   //get the action-url of the form
    var actionurl = e.currentTarget.action;
	$('#loader').fadeIn();	 
	alert( $(".imageuploadify-container").length );
   
	var numItems = $('.imageuploadify-container').length;


});*/

$(function  () {
	

	
$('#tc_table_file').hide(); 
$('#loaderP').show();   
	 		
	setTimeout(function () { 
		$('#loaderP').hide(); 
		$('#tc_table_file').show(); 	
	}, 1200);		 
});

function JQDelEbookPage()
{
	$('#loader').fadeIn();	
	var cid = '<?php echo $c_id;?>';
	var ebookcode = '<?php echo $ebook_code;?>';
	var ref= ""; 
	var checkboxes = document.getElementsByName('del');
	for (var i = 0; i < checkboxes.length; i++) 
	{
		if(checkboxes[i].checked == true)
		{
			ref = ref+checkboxes[i].value+",";
		}
	}

					var url = "func_del_ebook.php";  
			 //alert(url);
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'POST', 
											url: url,
											data:{proc:'DelPage',c_id:cid,ebook_code:ebookcode,ref:ref},
											success: function (data) {
												console.log(data);
												setTimeout(function () { 
													$('#loader').fadeOut();																				
												 										
												$.alert({
													title: '<?php echo $txt_ewt_action_del_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  confirm: {
																text: '<?php echo $txt_ewt_submit;?>',
									 							btnClass: 'btn-blue',
																action: function () {	
																	location.reload(true);			
																$('#box_popup').fadeOut();
																}
														  }													     
													},                          
													animation: 'scale',
													type: 'blue'
																						
												});	
																																			
												}, 3000);																						
											}
										});	
										
									}														
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									//$('#box_popup').fadeOut(); 
									$('#loader').fadeOut();	
									}											
								}
							},                          
                            animation: 'scale',
                            type: 'orange'						
						});
	}
	
function JSCheckPDF(id,fileInput) { 
		var fileTypes = 'pdf';
		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = <?php echo sizeMB2byte(FuncSizeValue('2')); ?>;
		var name = $('#'+id).val();
		
		var n = name.split('.').pop().toLowerCase();
		var m = 0;		
		//alert(size);		
	    if(parseInt(fileTypes.indexOf(n)) < 0){
		$('#'+id).val("");
			$.alert({
						title: 'รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง ',
						content: 'กรุณาเลือกรูปแบบใหม่',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
								 btnClass: 'btn-orange',
								}
							},						
						});	
				//alert('กรุณาเลือกชนิดไฟล์ '+fileTypes);
				return false;
		}	
		if(size > maxsize)
		{ 	
			//$('#'+id).val("");
			$.alert({
						title: 'ขนาดไฟล์ใหญ่เกินไป ',
						content: 'กรุณาเลือกไฟล์ใหม่',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								text: 'ปิด',
								btnClass: 'btn-orange',
								action: function () {	
									removeUpload();				
									}
								}
							},						
						});	
			return false;
		}else{
		  //document.getElementById("warning1").innerHTML = "";
	  }							
}
function JSCheckImage(id,fileInput) { 
		var fileTypes = 'gif,png,jpg,jpeg'; 
		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = <?php echo sizeMB2byte(FuncSizeValue('1')); ?>;
		var name = $('#'+id).val();
		
		var n = name.split('.').pop().toLowerCase();
		var m = 0;		
		//alert(size);		
	    if(parseInt(fileTypes.indexOf(n)) < 0){
		$('#'+id).val("");
			$.alert({
						title: 'รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง ',
						content: 'กรุณาเลือกรูปแบบใหม่',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
								 btnClass: 'btn-orange',
								}
							},						
						});	
				//alert('กรุณาเลือกชนิดไฟล์ '+fileTypes);
				return false;
		}	
		if(size > maxsize)
		{ 
			
			//$('#'+id).val("");
			$.alert({
						title: 'ขนาดไฟล์ใหญ่เกินไป ',
						content: 'กรุณาเลือกไฟล์ใหม่',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								text: 'ปิด',
								btnClass: 'btn-orange',
								action: function () {	
									location.reload(true);					
									}
								}
							},						
						});	
			
		}else{
		  //document.getElementById("warning1").innerHTML = "";
	  }							
}
</script>