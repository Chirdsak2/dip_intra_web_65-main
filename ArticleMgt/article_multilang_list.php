<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../lib/config_path.php");

$s_article_list = $db->query("SELECT article_list.c_id,
									 article_list.n_id,
									 article_list.n_date,
									 article_list.link_html,
									 article_list.n_topic,
									 article_list.n_des,
									 article_list.source,
									 article_list.news_use,
									 article_list.sourceLink,
									 article_list.keyword,
									 article_list.n_date_start,
									 article_list.n_date_end,
									 article_list.at_id 
									 FROM article_list 
									 WHERE n_id = '{$_GET['id']}' ");
$a_data = $db->db_fetch_array($s_article_list);
$a_num = $db->db_num_rows($s_group);

$_host = $_SERVER['HTTP_HOST'];	
$_name = $_SERVER['SCRIPT_NAME'];
$_url = $_SERVER['REQUEST_URI'];	
$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';
	
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
?>	

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_set_multilang')?>" enctype="multipart/form-data" >
<div class="dContainer" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"><?php echo "บริหารข่าว/บทความภาษาอื่นๆ";?></h4>
</div>

<div class="modal-body">


<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b>&bull;&nbsp;กรุณาใส่ภาษาตามที่เลือก &nbsp;</b><?php echo show_icon_setlang($a_data ['c_id'],'article_group');?></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="" class="col-sm-12 col-xs-12 control-label"><b>หัวข้อข่าวภาษาหลัก :</b></label>
<div class="col-md-12 col-sm-6 col-xs-6" style="margin-right:auto;margin-left:auto;word-wrap: break-word;" >

<h4 class="text-info"><?php echo $a_data['n_topic'];?></h4>
</div>
</div>
<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12 control-label"><b>หัวข้อข่าวภาษาตามที่เลือก :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input name="lang_detail[0]" id="lang_detail[0]" placeholder="หัวข้อข่าวภาษาตามที่เลือก" type="text" class="form-control"  value="<?php echo select_lang_detail($_GET['id'],$_GET['langid'],'n_topic','article_list');?>">
<input type="hidden" name="lang_field[0]" id="lang_field[0]" value="n_topic">
</div>
</div>

<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12  control-label"><b>รายละเอียดหัวข้อข่าวภาษาหลัก :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >

<h4 class="text-info"><?php echo $a_data['n_des'];?></h4>

</div>
</div>
<div class="form-group row" >
	<label for="" class="col-sm-12 col-xs-12 control-label"><b>รายละเอียดหัวข้อข่าวภาษาตามที่เลือก :</b></label>
	<div class="col-md-12 col-sm-12 col-xs-12" >
		<input name="lang_detail[1]" id="lang_detail[1]" placeholder="รายละเอียดหัวข้อข่าวภาษาตามที่เลือก" type="text" class="form-control"  value="<?php echo select_lang_detail($_GET['id'],$_GET['langid'],'n_des','article_list');?>" >
		<input type="hidden" name="lang_field[1]" id="lang_field[1]" value="n_des">
	</div>
</div>


<div class="form-group row" >
	<label for="" class="col-sm-12 col-xs-12 control-label"><b>Tags หัวข้อข่าวภาษาหลัก :</b></label>
	<div class="col-md-12 col-sm-12 col-xs-12" >
		<?php
		$nid     = ready($_GET['id']);
		$lang_id = ready($_GET["langid"]);
		$article_tag = "";
		$tag_data = $db->query("SELECT tag_name FROM article_taglist WHERE n_id = '$nid' AND lang_id = '1' ORDER BY taglist_id");
		
		?>
		<div class="well">
			<?php while($tag_info = $db->db_fetch_array($tag_data)){ ?>
			<span class="tag label label-info" style="display: inline;"><?php echo $tag_info["tag_name"]; ?></span>
			<?php } ?>
		</div>
	</div>
</div>

<div class="form-group row" >
	<label for="" class="col-sm-12 col-xs-12 control-label"><b>Tags หัวข้อข่าวภาษาตามที่เลือก :</b></label>
	<br>
	<div style="color:red" class="col-sm-12 col-xs-12">ใช้เครื่องหมาย , เพื่อแยก tag หรือคลิกนอกช่องใส่ tag</div>
	<div class="col-md-12 col-sm-12 col-xs-12" >
		<?php
		$article_tag = "";
		$tag_data = $db->query("SELECT tag_name FROM article_taglist WHERE n_id = '$nid' AND lang_id = '$lang_id' ORDER BY taglist_id");
		while($tag_info = $db->db_fetch_array($tag_data)){
			$article_tag .= $tag_info["tag_name"].",";
		}

		$article_tag = rtrim($article_tag,",");
		?>
		<input type="text" name="article_tag" id="article_tag" class="form-control" data-role="tagsinput" value="<?php echo $article_tag; ?>">
	</div>
</div>

<?php
	if($a_data['n_date'] != ''){
		$date_n = explode("-",$a_data['n_date']);
		$Y = $date_n[0];
		$m = $date_n[1];
		$d = $date_n[2];
		$date_n = ($Y-543).'-'.$m.'-'.$d;
	}
	if($a_data['n_date_start'] != ''){
		$date_s = explode(" ",$a_data['n_date_start']);
		$date_start = explode("-",$date_s[0]);
		$date_time = explode(":",$date_s[1]);
		$Y = $date_start[0];
		$m = $date_start[1];
		$d = $date_start[2];
		$date_s = ($Y-543).'-'.$m.'-'.$d.' '.$date_s[1];
	}
	if($a_data['n_date_end'] != ''){
		$date_e = explode(" ",$a_data['n_date_end']);
		$date_end = explode("-",$date_e[0]);
		$date_time = explode(":",$date_e[1]);
		$Y = $date_end[0];
		$m = $date_end[1];
		$d = $date_end[2];
		$date_e = ($Y-543).'-'.$m.'-'.$d.' '.$date_e[1];
	}
	?>
<input name="lang_detail[5]" id="lang_detail[5]" type="hidden" value="<?php echo $date_n;?>">
<input type="hidden" name="lang_field[5]" id="lang_field[5]" value="n_date">
<input name="lang_detail[8]" id="lang_detail[8]" type="hidden" value="">
<input type="hidden" name="lang_field[8]" id="lang_field[8]" value="d_id">
<?php
//echo $a_data['at_id'];
if($a_data['news_use'] == "2" || $a_data['news_use'] == "3"){ 
if($a_data['at_id'] > 0 && $a_data['at_id'] < 10){
$n = 9;
$s_detail = $db->query("SELECT ad_id,ad_des,at_type_col,at_type_row,ad_pic_b,n_id FROM article_detail WHERE n_id = '{$_GET[id]}' ORDER BY at_type_row ASC");
while($a_detail= $db->db_fetch_array($s_detail)){
	
//$a_detail['ad_des'] = eregi_replace($_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/","images/",$a_detail['ad_des']);
//$a_detail['ad_des'] = eregi_replace("images/",$_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/",$a_detail['ad_des']);	
$a_detail['ad_des'] = preg_replace('/(src=\")(.*)(\images)/','$1'.$_protocal.'://'.$_host.$_directory.'ewt/'.$_SESSION['EWT_SUSER'].'/$3',$a_detail['ad_des']);

if($a_detail['ad_pic_b'] != '' OR $a_detail['ad_des'] != ''){	
if($a_detail['at_type_row'] != '11'){	
?>
<div class="form-group row" >
<div class="text-center">
<img src="<?php if($a_detail['ad_pic_b'] != ""){ echo "../ewt/".$_SESSION['EWT_SUSER']."/images/article/news".$a_detail['n_id']."/".$a_detail['ad_pic_b']; }else{ echo "../images/pic_preview.gif"; } ?>" class="img-responsive" style="width:160px;height:120px;border: 0.5px solid #cbcccc;padding: 5px;border-radius: 5px;"  />
</div>
</div>
<?php } ?>
<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12  control-label"><b>รายละเอียดข่าวภาษาหลัก ( <?php echo $a_detail['at_type_col'].'-'.$a_detail['at_type_row'];?> ) :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="well">
<?php echo $a_detail['ad_des'];?>
</div>

</div>
</div>
<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12  control-label"><b>รายละเอียดข่าวภาษาตามที่เลือก ( <?php echo $a_detail['at_type_col'].'-'.$a_detail['at_type_row'];?> ) :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php
$detail = select_lang_detail_withslash($_GET['id'],$_GET['langid'],'ad_des'.$a_detail['ad_id'],'article_list');

//$detail = eregi_replace($_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/","images/",$detail);
//$detail = eregi_replace("images/",$_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/",$detail);
$detail = preg_replace('/(src=\")(.*)(\images)/','$1'.$_protocal.'://'.$_host.$_directory.'ewt/'.$_SESSION['EWT_SUSER'].'/$3',$detail);	
?>
<textarea id="lang_detail[<?php echo $n;?>]" class="form-control" name="lang_detail[<?php echo $n;?>]"><?php echo $detail;?></textarea>
<input type="hidden" name="lang_field[<?php echo $n;?>]" id="lang_field[<?php echo $n;?>]" value="ad_des<?php echo $a_detail['ad_id'];?>">
<input type="hidden" name="lang_datack[<?php echo $n;?>]" id="lang_datack[<?php echo $n;?>]" value="">			
</div>
</div>

<script>
  CKEDITOR.replace('lang_detail[<?php echo $n;?>]', {
		allowedContent: true,
	  	customConfig: '../../js/ckeditor/custom_config.js',
		on: {
        change: function( evt ) {
			var newContent = this.getData()			
				change_data('<?php echo $n;?>',newContent);		   
            //console.log( this.getData() );
				}
		}
  }); 
  
</script>

<?php
} 
$n++;
	}
		}
?>
<hr>
<?php		
$_sql = $db->query("SELECT * FROM article_attach WHERE n_id = '{$_GET[id]}' ORDER BY fileattact_id ASC");	
$a_rows = $db->db_num_rows($_sql);
$m = 0;
if($a_rows){	
while($a_attach = $db->db_fetch_array($_sql)){			
?>		
<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12  control-label"><b>เอกสารแนบภาษาหลัก :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="well well-sm ewt-bg-white text-dark">
<?php echo $a_attach['fileattach_name'];?> 
<button type="button" class="btn btn-info  btn-sm " onclick="window.open('<?php echo "../ewt/".$_SESSION['EWT_SUSER']."/article_attach/".$a_attach['fileattach_path'];?>')" >
<i class="fas fa-search"></i>&nbsp;View
</button>
</div>

<label for="" class="col-sm-12 col-xs-12  control-label"><b>เอกสารแนบภาษาตามที่เลือก :</b></label>
<input name="lang_name_attach[<?php echo $m;?>]" id="lang_name_attach[<?php echo $m;?>]" placeholder="ชื่อเอกสารแนบภาษาตามที่เลือก" type="text" class="form-control"  value="<?php echo select_lang_detail($_GET['id'],$_GET['langid'],'a_name_attach'.$a_attach['fileattact_id'],'article_list');?>" />
</br>
<input type="file" name="lang_attach[<?php echo $m;?>]" id="lang_attach<?php echo $m;?>" class="form-control" onchange="JSCheck_filenameTH(this.id,this.value);" />
<?php if(select_lang_detail($_GET['id'],$_GET['langid'],'a_attach'.$a_attach['fileattact_id'],'article_list')){ ?>
<button type="button" class="btn btn-info  btn-sm " onclick="window.open('<?php echo "../ewt/".$_SESSION['EWT_SUSER']."/article_attach/".select_lang_detail($_GET['id'],$_GET['langid'],'a_attach'.$a_attach['fileattact_id'],'article_list')?>')" >
<i class="fas fa-search"></i>&nbsp;View
</button> <?php echo select_lang_detail($_GET['id'],$_GET['langid'],'a_attach'.$a_attach['fileattact_id'],'article_list');?>
<?php } ?>
</div>
</div>
<hr>
<input type="hidden" name="lang_attach_field[<?php echo $m;?>]" id="lang_attach_field[<?php echo $m;?>]" value="a_attach<?php echo $a_attach['fileattact_id'];?>">	
<input type="hidden" name="lang_name_attach_field[<?php echo $m;?>]" id="lang_name_attach_field[<?php echo $m;?>]" value="a_name_attach<?php echo $a_attach['fileattact_id'];?>">	
<input type="hidden" name="lang_attach_old[<?php echo $m;?>]" id="lang_attach_old[<?php echo $m;?>]" class="form-control" value="<?php echo select_lang_detail($_GET['id'],$_GET['langid'],'a_attach'.$a_attach['fileattact_id'],'article_list');?>" />
<?php
$m++;
}
?>
<input type="hidden" name="num_attach" id="num_attach" value="<?php echo $a_rows;?>" />
<?php
	}
	
}else{
$browse_file = select_lang_detail($_GET['id'],$_GET['langid'],'browse_file','article_list');
?>
<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12  control-label"><b>ลิงค์ข่าว/บทความภาษาหลัก :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12 form-inline" >
<span class="label label-success text-small"><?php echo $a_data['link_html'];?></span>
<!--<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-search"></i>&nbsp;ดูไฟล์
</button>-->
</div>
</div>
<div class="form-group row" >
<label for="" class="col-sm-12 col-xs-12  control-label"><b>ลิงค์ข่าว/บทความภาษาตามที่เลือก :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="panel panel-info">
<div class="panel-heading">
<input name="browsefile" id="browsefile1"type="radio" value="1" <?php if($browse_file == '' OR $browse_file == '1'){ echo 'checked="checked"';} ?> >
 เลือก  URL ของเว็บหรือไฟล์  <a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.form_main.link.value','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0');document.form_main.browsefile[0].checked=true;win2.focus();">
<button type="button" class="btn btn-info  btn-sm " >
<i class="far fa-folder-open"></i>&nbsp;เลือกไฟล์
</button>
</a>
</br></br>
<input name="link" type="text" id="link"  class="form-control" value="<? if($browse_file == '1'){ echo select_lang_detail($_GET['id'],$_GET['langid'],'link_html','article_list'); } ?>" onClick="check_brow('1');" >
</div> 
</div>
<div class="panel panel-info">
<div class="panel-heading">

<input name="browsefile" id="browsefile2" type="radio" value="2" <?php if($browse_file == '2'){ echo 'checked="checked"';} ?>>
เลือกไฟล์จากเครื่อง  <span class="label label-success text-small"><?php echo select_lang_detail($_GET['id'],$_GET['langid'],'link_html','article_list');?></span>
</br></br>
<input type="file" name="filebrowse" id="filebrowse" class="form-control" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'link_html','article_list');?>" onClick="check_brow('2');">
</div>
</div>			 
</div>
</div>
<input type="hidden" name="lang_field[9]" id="lang_field[9]" value="link_html">
<input type="hidden" name="lang_field[10]" id="lang_field[10]" value="browse_file">
<input type="hidden" name="news_use" id="news_use" value="<?php echo $a_data['news_use'] ;?>">

<script>
function check_brow(id){
	if(id == 1){
	$( "#browsefile1" ).prop( "checked", true );
	$( "#filebrowse" ).val(""); 
	}else{
		$( "#browsefile2" ).prop( "checked", true );
		$( "#link" ).val(""); 
	}
}

</script>
<?php } ?>
</div>
</div>	

</div>
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQSet_lang_list($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo "บันทึก";?>
</button>
</div>
</div>
</div>
	 
</div>
</div>

      <input type="hidden" name="proc" id="proc" value="set_lang">
	  <input type="hidden" name="num" id="num" value="<?php 
	  if($a_data['at_id'] > 0 && $a_data['at_id'] < 10 && $a_data['news_use'] == '2'){  
	  echo ($n); 
	  }else if($a_data['at_id']  == 10){  
	  echo '10';
	  }else if($a_data['news_use'] == '1'){  
	  echo '11';
	  }else{ 
	  echo '9';
	  }?>">
      <input type="hidden" name="c_id" id="c_id"  value="<?php echo $_GET['id']?>">
	  <input type="hidden" name="c_parent" id="c_parent" value="<?php echo $a_data['c_id'];?>">
	  <input type="hidden" name="lang_name" id="lang_name" value="<?php echo $_GET['langid']?>">
	  <input type="hidden" name="lang" id="lang" value="<?php echo $_GET['lang']?>">
	  <input type="hidden" name="module" id="module"  value="article_list">
	  <input type="hidden" name="at_id" id="at_id" value="<?php echo $a_data['at_id'];?>">
	  
</form>	
<script>
function change_data(id,data){
   document.getElementById('lang_detail['+id+']').value = data;
   document.getElementById('lang_datack['+id+']').value = data;

   console.log( id );
}
</script>
<!-- Custom js -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/custom.js"></script>	
<script src="../js/bootstrap-tagsinput.js"></script>