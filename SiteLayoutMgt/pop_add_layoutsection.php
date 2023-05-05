<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$template_id = (int)(!isset($_GET['template_id']) ? 0 : $_GET['template_id']);
$template_id = ready($template_id);

$section_id = (int)(!isset($_GET['section_id']) ? 0 : $_GET['section_id']);
$section_id = ready($section_id);

$section_data = $db->query("SELECT * FROM site_management_tsection_config WHERE template_id = '$template_id' AND section_id = '$section_id'");
$section_info = $db->db_fetch_array($section_data);		

if($section_info["section_no"]!=""){
	$section_title = $section_info["section_no"]." - ".$section_info["section_title"];
}
else{
	$section_title = $section_info["section_title"];
}


## >> Get Bannergroup
$bannergroup_array = array();
$bannergroup_data  = $db->query("SELECT * FROM banner_group ORDER BY banner_name ASC");
while($bannergroup_info = $db->db_fetch_array($bannergroup_data)){
	array_push($bannergroup_array,$bannergroup_info);
}

## >> Get Articlegroup
$group_array = array();
$group_data  = $db->query("SELECT * FROM article_group ORDER BY c_name ASC");
while($group_info = $db->db_fetch_array($group_data)){
	array_push($group_array,$group_info);
}

?>

<form id="form_main" name="form_main" method="POST" action="layout_function.php" enctype="multipart/form-data" >
<input type="hidden" name="flag" id="flag"  value="edit_section">
<input type="hidden" name="section_id" id="section_id"  value="<?php echo $section_id; ?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> สร้าง Section - <span id="section_name"></span></h4>
</div>

<div class="modal-body">

	<div class="card ">
	<div class="scrollbar scrollbar-near-moon thin">
		<div class="card-header ewt-bg-success m-b-sm" >
			<div class="card-title text-left"><b></b></div>
		</div>

		<div class="card-body" >
		
			<?php if($section_info["use_no"]=="Y"){ ?>
			<div class="form-group row">
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
					<div>
						<label for="section_no"><b>NO. : </b></label>   
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
						<input type="text" class="form-control" placeholder="" id="section_no" name="section_no" 
						       value="<?php echo $section_info["section_no"];?>">
					</div>
				</div>
			</div>
			<?php } ?>
		
			<div class="form-group row">
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
					<div>
						<label for="section_title"><b>Title : </b></label>   
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
						<input type="text" class="form-control" placeholder="" id="section_title" name="section_title" 
						       value="<?php echo $section_info["section_title"];?>">
					</div>
				</div>
			</div>
		
			<?php if($section_info["use_subtitle"]=="Y"){ ?>
			<div class="form-group row">
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
					<div>
						<label for="section_subtitle"><b>Sub-Title : </b></label>   
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
						<input type="text" class="form-control" placeholder="" id="section_subtitle" name="section_subtitle" 
						       value="<?php echo $section_info["section_subtitle"];?>">
					</div>
				</div>
			</div>
			<?php } ?>

			<?php
			if($section_info["module_name"]=="banner"){
			?>
			<div class="form-group row">
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
					<div>
						<label for="section_data"><b>แบนเนอร์ :</b></label>
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
						<select class="form-control" id="section_data" name="section_data">
							<option value="">เลือกแบนเนอร์</option>
							<?php
							foreach($bannergroup_array AS $bannergroup){
							?>
							<option value="<?php echo $bannergroup["banner_gid"]; ?>" 
								<?php if($section_info["section_data"]==$bannergroup["banner_gid"]){echo "selected"; } ?>>
								<?php echo $bannergroup["banner_name"]; ?>
							</option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<?php
			}
			else if($section_info["module_name"]=="article"){
			?>
			<div class="form-group row">
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
					<div>
						<label for="section_data"><b>หมวดข่าว :</b></label>
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
						<select class="form-control" id="section_data" name="section_data">
							<option value="">เลือกหมวดข่าว</option>
							<?php
							foreach($group_array AS $group){
							?>
							<option value="<?php echo $group["c_id"]; ?>" 
								<?php if($section_info["section_data"]==$group["c_id"]){echo "selected"; } ?>>
								<?php echo $group["c_name"]; ?>
							</option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
			</div>


			<?php
			}
			else if($section_info["module_name"]=="text"){
			?>
			<div class="form-group row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div>
						<label for="section_data"><b>Text : </b></label>   
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">     
						<textarea type="text" class="form-control" placeholder="" id="section_data" name="section_data" 
						><?php echo $section_info["section_data"];?></textarea>
					</div>
				</div>
			</div>
			<script>
			CKEDITOR.replace('section_data', {
					allowedContent: true,
					customConfig: '../../js/ckeditor/custom_config.js',
					on: {
						change: function( evt ) {
							var newContent = this.getData()				
							document.getElementById('section_data').value = newContent;
						}
					}
			});

			</script>	
			<?php
			}
			?>

		</div>
	</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Calendar($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
<!-- Custom js -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/custom.js"></script>		
<script>  
	var section_title = $("#section_title_<?php echo $section_id; ?>").val();
	$("#section_title").val(section_title);

	<?php if($section_info["use_no"]=="Y"){ ?>
		var section_no = $("#section_no_<?php echo $section_id; ?>").val();
		$("#section_no").val(section_no);
		section_title = section_no+' - '+section_title
	<?php } ?>
	$("#section_name").html(section_title);

	<?php if($section_info["use_subtitle"]=="Y"){ ?>
		var section_subtitle = $("#section_subtitle_<?php echo $section_id; ?>").val();
		$("#section_subtitle").val(section_subtitle);
	<?php } ?>
	<?php
	if($section_info["module_name"]=="banner"){
	?>
		var section_data = $("#section_data_<?php echo $section_id; ?>").val();
		$('#section_data option[value="'+section_data+'"]').prop("selected", "selected");
	<?php
	}
	else if($section_info["module_name"]=="article"){
	?>
		var section_data = $("#section_data_<?php echo $section_id; ?>").val();
		$('#section_data option[value="'+section_data+'"]').prop("selected", "selected");
	<?php
	}
	else if($section_info["module_name"]=="text"){
	?>
		var section_data = $("#section_data_<?php echo $section_id; ?>").val();
		$("#section_data").val(section_data);
	<?php
	}
	?>

function JQEdit_Calendar(form){	
	var section_title = $("#section_title").val().trim();
	$("#section_title_<?php echo $section_id; ?>").val(section_title);

	<?php if($section_info["use_no"]=="Y"){ ?>
	var section_no = $("#section_no").val();
	$("#section_no_<?php echo $section_id; ?>").val(section_no);
	section_title = section_no+' - '+section_title
	<?php } ?>
	$("#section_titledisplay_<?php echo $section_id; ?>").html(section_title);

	<?php if($section_info["use_subtitle"]=="Y"){ ?>
	var section_subtitle = $("#section_subtitle").val();
	$("#section_subtitle_<?php echo $section_id; ?>").val(section_subtitle);
	<?php } ?>
	var section_data = $("#section_data").val();
	$("#section_data_<?php echo $section_id; ?>").val(section_data);
	
	$('#box_popup').fadeOut();
} 
								

</script>