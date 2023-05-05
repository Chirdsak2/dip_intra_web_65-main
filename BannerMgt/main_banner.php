<?php
	session_start();
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	include("../language/banner_language.php");
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
	$sql_banner = "SELECT * FROM banner_group where banner_gid ='".$_GET["banner_gid"]."' order by banner_gid";
	$rec = $db->db_fetch_array($db->query($sql_banner));
	$gname = $rec['banner_name'];
	
include("../lib/config_path.php");
include("../header.php");
?>

<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="js/jquery/jquery.core.js"></script>
<script src="js/jquery/jquery.tablednd.js"></script>

<?php include('link.php'); ?>

<script >
function isNum (charCode) {
	if (charCode >= 48 && charCode <= 57 ) return true;
	else return false;
}

function chkFormatNam (str) {//0-9
	strlen = str.length;
	for (i=0;i<strlen;i++) {
		var charCode = str.charCodeAt(i);
		if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
			return false;
		}
	}
	return true;
}

function chkformatnum(t) { 
	_MyObj = t;
	_MyObj_Name = t.name;
	_MyObj_Value = t.value;
	_MyObj_Strlen =_MyObj_Value.length; 
	if( _MyObj_Strlen >1 && _MyObj_Value.substr(0,1)==0){
		t.value = _MyObj_Value.substr(1);
	}
	if(!chkFormatNam (t.value)){
		alert('กรุณากรอกตัวเลขเท่านั้น');
		t.value = 0;
		t.focus();
	} 
}

function findPosX(obj) {
	var curleft = 0;
	if (document.getElementById || document.all) {
		while (obj.offsetParent) {
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	} else if (document.layers) curleft += obj.x;
	return curleft;
}

function findPosY(obj) {
	var curtop = 0;
	if (document.getElementById || document.all) {
		while (obj.offsetParent) {
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (document.layers) curtop += obj.y;
	return curtop;
}

function txt_data(w,g) {
	var mytop = findPosY(document.getElementById("lang"+w)) +document.getElementById("lang"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("lang"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='../language_set.php?gid='+g+'&id='+ w;
	AjaxRequest.get(
	{
		'url':url
		,'onLoading':function() { }
		,'onLoaded':function() { }
		,'onInteractive':function() { }
		,'onComplete':function() { }
		,'onSuccess':function(req) { 
			objDiv.innerHTML = req.responseText; 
		}
	});
}

function txt_data1(w,g,lang) {
	var mytop = findPosY(document.getElementById("lang"+w)) +document.getElementById("lang"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("lang"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='banner_lang.php?gid='+g+'&lang='+lang+'&id='+ w;
	AjaxRequest.get(
	{
		'url':url
		,'onLoading':function() { }
		,'onLoaded':function() { }
		,'onInteractive':function() { }
		,'onComplete':function() { }
		,'onSuccess':function(req) { 
			objDiv.innerHTML = req.responseText; 
		}
	});
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
<?php
include('top.php');
?>
<?php include("../FavoritesMgt/favorites_include.php");?>
<!--<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 4px;">
<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">			
<div class="col-md-12 col-sm-12 col-xs-12" ><hr /> 
			<img src="../theme/main_theme/banner_function.gif" width="32" height="32" align="absmiddle"> 
			<span class="ewtfunction"><?php //echo $text_genbanner_function1;?> >> <a href="main_banner.php?banner_gid=<?php //echo $_GET[banner_gid];?>">หมวด&nbsp;&nbsp;<?php //echo $gname;?></a></span> 
</div>    
</div>
</div>
</div>
</div>-->		
		<!--<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
			<tr>
				<td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php //echo urlencode($text_genbanner_function1.">>หมวด&nbsp;&nbsp;". $gname);?>&module=banner&url=<?php //echo urlencode("main_banner.php?banner_gid=".$_GET["banner_gid"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="banner_add.php?flag=add&banner_gid=<?php //echo $_GET["banner_gid"];?>" target="_self"><img src="../theme/main_theme/g_add.gif"  width="16" height="16"  align="absmiddle" border="0"> <?php //echo $text_genbanner_addnew;?></a>&nbsp;
					<a href="main_group_banner.php"> <img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> <?php //echo $text_genbanner_manage;?></a>
					<hr>
				</td>
			</tr>
		</table>-->
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $text_genbanner_function1;?> <span class="glyphicon glyphicon-triangle-right"></span> หมวด&nbsp;&nbsp;<?=$gname;?></h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;" >
	<!--<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php //echo urlencode($text_genpoll_function);?>&module=poll&url=<?php //echo urlencode("main.php");?>', 'divForm', 300, 80, -1,433, 1);">
	<img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="add.php" ><img src="../theme/main_theme/g_add.gif" alt="<?php //echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle"> <?php //echo $text_general_add;?></a> &nbsp;-->
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12"></div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >
	<a href="banner_add.php?flag=add&banner_gid=<?php echo $_GET["banner_gid"];?>" target="_self">
	<!--<button type="button" class="btn btn-info btn-block" />
	<img src="../theme/main_theme/g_add.gif" alt="<?php echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $text_general_add;?>
	</button>-->
	<button type="button" class="btn btn-info  btn-sm " >
	<span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?php echo $text_genbanner_addnew;?>
	</button>
	</a>
	<a href="main_group_banner.php" target="_self">

<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>
</div>
</div>
</div>

<div class="clearfix">&nbsp;</div>
	
<div class="col-md-12 col-sm-12 col-xs-12" >		
<form name="frm1" action="banner_process.php" method="post">		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
			<tr> 
				<td  valign="top">
					<table width="100%" class="table table-bordered" id="table-1" align="center">
						<tr class="nodrop nodrag ewttablehead">
							<td  width="10%" ></td>  
							<td  width="40%" align="center"><?php echo $text_genbanner_column1;?></td>
							<td  width="20%"  align="center"><?php echo $text_genbanner_column2;?></td> 
							<td  width="15%"  align="center"><?='Popup Intro';?></td>  
							<td  width="15%"  align="center">&nbsp;<?php echo $text_genbanner_formsort;?></td>
						</tr>
						<?php
							$sql_banner = "SELECT * FROM banner where banner_gid ='".$_GET["banner_gid"]."' order by banner_position,banner_id";
							$query_banner = $db->query($sql_banner);
							$num_banner = $db->db_num_rows($query_banner);
							if($num_banner > 0){
								$i = 1;
								while($rs_banner = $db->db_fetch_array($query_banner)){
						?>
						<tr bgcolor="#FFFFFF" id="<?=$i;?>">
							<td align="center">
							<!--<a href="#" title="แก้ไข" target="_self" onClick="location.href='banner_edit.php?flag=edit&banner_id=<?php echo $rs_banner['banner_id']?>&banner_gid=<?php echo $_GET["banner_gid"];?>';" >
							<span class="glyphicon glyphicon-cog text-warning" style="font-size:16px;"></span>
							</a>
							<a href="#" title="ลบ" target="_self" onClick="if(confirm('<?php echo $text_genbanner_confirm_del;?>'))location.href = 'banner_process.php?flag=del&banner_id=<?php echo $rs_banner[banner_id]?>&banner_gid=<?php echo $_GET["banner_gid"];?>'; ">
							<span class="glyphicon glyphicon-trash text-danger" style="font-size:16px;"></span>
							</a>-->
							<nobr>
							<img src="../theme/main_theme/g_edit.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altedit;?>" style="cursor:hand" onClick="location.href='banner_edit.php?flag=edit&banner_id=<?php echo $rs_banner[banner_id]?>&banner_gid=<?php echo $_GET["banner_gid"];?>';">&nbsp;
							<img src="../theme/main_theme/g_garbage.png" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altdel;?>" style="cursor:hand" onClick="if(confirm('<?php echo $text_genbanner_confirm_del;?>'))location.href = 'banner_process.php?flag=del&banner_id=<?php echo $rs_banner[banner_id]?>&banner_gid=<?php echo $_GET["banner_gid"];?>'; "> 
							<!--<a href="#" onClick="txt_data('<?php//=$rs_banner[banner_id]?>','<?php//=$_GET[banner_gid]?>')"><img id="lang<?php//=$rs_banner[banner_id]?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a>-->
							</nobr>
							</td>
							<td >
								&nbsp;&nbsp;
								<?php if(file_exists($Globals_Dir.$rs_banner[banner_pic]) and $rs_banner[banner_pic]!=''){
								$filetypename = explode('.',$Globals_Dir.$rs_banner[banner_pic]);
								
								
									if($filetypename[3] == 'swf'){
									$wi = '150';$hi = '50';
										echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'.$wi.'" height="'.$hi.'">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$Globals_Dir.$rs_banner[banner_pic].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$Globals_Dir.$rs_banner[banner_pic].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'.$wi.'" height="'.$hi.'"> </embed>
										</object><br><br>';
									}else{
									?>
									<img src="../FileMgt/phpThumb.php?src=<?php echo $Globals_Dir?><?php echo $rs_banner[banner_pic]; ?>&h=50&w=150" border=1>
									<?php
									}
								 }else{  echo "No image.";   }?>
								
							</td>
							<td  width="10%" >&nbsp;<?=$rs_banner['banner_name']?></td>
							<td  width="10%" style="text-align:center;">
							<?php 
							if($rs_banner['banner_intro']=='Y'){
								echo '<span class="glyphicon glyphicon glyphicon-ok text-danger" onclick="JQSetIntro('.$rs_banner['banner_id'].',\'UnSetIntro\',);"></span>';
							}else{
							?>						
							<input type="radio" name="intro" id="intro<?=$rs_banner['banner_id']?>" value="<?=$rs_banner['banner_id']?>" 
							onclick="JQSetIntro(<?=$rs_banner['banner_id'];?>,'SetIntro');" >
							<?php } ?>
							</td>  			
							<td  width="10%" align="center" >
							<input class="form-control" style="width:30%;" type="text" name="ban_pos[]" id="ban_pos"  size="5" value="<?=$rs_banner[banner_position]?>" onKeyUp="chkformatnum(this)" >
							<input type="hidden" name="ban_id[]" id="ban_id"   value="<?=$rs_banner['banner_id']?>">
							</td>
						</tr>
						<?php  
								$i++;
							}
						?>
						<tr bgcolor="#FFFFFF" class="nodrop nodrag">
							<td colspan="4"  align="center">&nbsp;</td>
							<td align="center" >
							<input type="hidden" name="flag" value="tool"> 
							<input type="hidden" name="banner_gid" value="<?php echo $_GET[banner_gid]?>">
							<input class="btn btn-success" type="Button" name="Submit" value="<?php echo $text_genbanner_formupdate;?>" onClick="document.frm1.submit();">
							</td>
						</tr>
						<?php } else { ?>
						<tr bgcolor="#FFFFFF">
							<th height="23" colspan="5" scope="col"><div align="center" style="color:#FF0000"><?php echo $text_genbanner_notfound?></div></th>
						</tr>
						<?php 
							}
						?>
					</table>
				</td>
			</tr>
		</table>
	</form>
</div>
</div>
</div>
<?php
include('footer.php');
?>	
	
</body>
</html>
<?php $db->db_close(); ?>
<script >
function CHK(t) {
	if(t.banner_name.value == '') {
		alert("กรุณากรอกชื่อป้ายโฆษณา!!!!!!");
		return false;
	}
}
</script>
<script type="text/javascript">
$(document).ready(function() {
	$('#table-1').tableDnD( {
		onDrop: function(table, row) {
			var ban_pos = $('* > #ban_pos');
			for(var i=0; i<ban_pos.length; i++) {
				jQuery(ban_pos[i]).val(i+1);
			}
        }
	});
});
</script>