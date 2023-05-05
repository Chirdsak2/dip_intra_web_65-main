<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//===========================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	$category_id  = checkNumeric($category_id);
	$_GET[category_id] = checkNumeric($_GET[category_id]);
	$_POST[category_id] = checkNumeric($_POST[category_id]);
	//===========================================================
	
//include("language/language.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

$sql = "select * from site_info";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

$gallery_type_show =$rec['site_display_gallery'];//กำหนดการแสดงผลของรายการรูปภาพ มี 2 แบบ คือ ถ้าเป็นค่าว่าจะแสดงแบบ list รายการ แต่ถ้าค่า = Y จะแสดงผลเป็นกรอบ
if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
$lang_sh1 = explode('___',$F[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			include("language/language".$lang_sh.".php");
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$F = $db->db_fetch_array($sql_temp);
$design_id = $F["d_id"];

$global_theme = $F["d_bottom_content"];
$mainwidth = "0";

$sql_rude="SELECT * FROM vulgar_table ";
$query_rude=$db->query($sql_rude);
while($data = $db->db_fetch_array($query_rude)){ 
	 $array_rude[]=$data[vulgar_text];
}

function cencer_rude($str){
		global  $array_rude;
		for($i=0;$i<sizeof($array_rude);$i++){
				$str=ereg_replace($array_rude[$i],'***',$str);
				//str_replace($array_rude[$i],$str
		}
		return  $str;
}

	?>
<html><head>
<title>Gallery</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php include("ewt_script.php");	?>

<script type="text/javascript" src="js/jquery/jquery.lightbox.js"></script>
		<style type="text/css">
		#lightbox{
	position: absolute;
	left: 0;
	width: 100%;
	z-index: 100;
	text-align: center;
	line-height: 0;
	}

#lightbox a img{ border: none; }

#outerImageContainer{
	position: relative;
	background-color: #fff;
	width: 250px;
	height: 250px;
	margin: 0 auto;
	}

#imageContainer{
	padding: 10px;
	}

#loading{
	position: absolute;
	top: 40%;
	left: 0%;
	height: 25%;
	width: 100%;
	text-align: center;
	line-height: 0;
	}
#hoverNav{
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	width: 100%;
	z-index: 10;
	}
#imageContainer>#hoverNav{ left: 0;}
#hoverNav a{ outline: none;}

#prevLink, #nextLink{
	width: 49%;
	height: 100%;
	background: transparent url(mainpic/lightbox/blank.gif) no-repeat; /* Trick IE into showing hover */
	display: block;
	}
#prevLink { left: 0; float: left;}
#nextLink { right: 0; float: right;}
#prevLink:hover, #prevLink:visited:hover { background: url(mainpic/lightbox/prev.gif) left 50% no-repeat; }
#nextLink:hover, #nextLink:visited:hover { background: url(mainpic/lightbox/next.gif) right 50% no-repeat; }

/*** START : next / previous text links ***/
#nextLinkText, #prevLinkText{
color: #FF9834;
font-weight:bold;
text-decoration: none;
}
#nextLinkText{
padding-left: 0px;
}
#prevLinkText{
padding-right: 0px;
}
/*** END : next / previous text links ***/
/*** START : added padding when navbar is on top ***/

.ontop #imageData {
    padding-top: 5px;
}

/*** END : added padding when navbar is on top ***/

#imageDataContainer{
	font: 12px Verdana, Helvetica, sans-serif;
	background-color: #fff;
	margin: 0 auto;
	line-height: 1.4em;
	}

#imageData{
	padding:0 10px;
	}
#imageData #imageDetails{ width: 70%; float: left; text-align: left; }	
#imageData #caption{ font-weight: bold;	}
#imageData #numberDisplay{ display: block; clear: center; padding-bottom: 1.0em;	}
#imageData #bottomNavClose{ width: 10px; float: right;  padding-bottom: 0.7em;	}
#imageData #helpDisplay {clear: left; float: left; display: block; }

#overlay{
	position: absolute;
	top: 0;
	left: 0;
	z-index: 90;
	width: 100%;
	height: 500px;
	background-color: #000;
	filter:alpha(opacity=60);
	-moz-opacity: 0.6;
	opacity: 0.6;
	display: none;
	}
	

.clearfix:after {
	content: "."; 
	display: block; 
	height: 0; 
	clear: both; 
	visibility: hidden;
	}

* html>body .clearfix {
	display: inline-block; 
	width: 100%;
	}

* html .clearfix {
	/* Hides from IE-mac \*/
	height: 1%;
	/* End hide from IE-mac */
	}	
		</style>
		<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function show_icon_link(mid,vote,comment,mail){
var htm='';
	if(vote == '1'){
		htm = "<img src=\"mainpic/lightbox/check.jpg\" border=\"0\" alt=\"คลิกเมื่อต้องการ Vote\">";
	}
	if(comment == '1'){
		htm += "<img src=\"mainpic/lightbox/message.jpg\" border=\"0\" alt=\"คลิกเมื่อต้องการ Comment\">";
	}
	if(mail == '1'){
		htm += "<img src=\"mainpic/lightbox/mail.jpg\" border=\"0\" alt=\"คลิกเมื่อต้องการ ส่งต่อให้เพื่อน\">";
	}
	if(htm != ''){
		self.document.all.iconname.innerHTML = "<a href=\"gallery_view_img_comment.php?category_id=<?php echo $category_id;?>&filename=<?php echo $_GET["filename"];?>&img_id="+mid+"&BID=<?php echo $BID;?>\">"+htm+"</a>";
	}
}
//-->
</script>

</head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth =$F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
     <td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>">
   <?php
			$mainwidth = $F["d_site_content"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		<!--GGG---->
		<table width="96%" border="0" align="center">
		  <tr>
			<td ><br>
			<?php
			function findparent($id){
			 global $db;
			 global $filename;
			  global $lang_shw;
			// if($lang_shw != ''){
			// $sql =$db->query("select * from  article_group,lang_article_group,lang_config where lang_article_group.c_id =article_group.c_id AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_id = '".$id."'");
			 // }else{
			 $sql = $db->query("select category_name,category_id,parent_id from gallery_category where category_id ='".$id."'");
			// }
				if($db->db_num_rows($sql)){
					$G = $db->db_fetch_array($sql);
					// if($lang_shw != ''){	
					//$G[c_name] = $G[lang_detail];
					 //}
					$txt = " <a href = \"gallery_view_catelogy.php?category_id=".$G["category_id"]."\">".$G["category_name"]."</a> &gt;&gt; ";
					if($G[parent_id] != "0" AND $G[parent_id] != ""){
						$txt = findparent($G[parent_id]).$txt;
					}		
				}
				return $txt;
			 }
			if(($_GET[category_id]!= '') && ($_GET[category_id] != '0')){
			$sql =$db->query("select category_name,parent_id,col,row,height_s,width_s,category_vote,category_comment,category_send from gallery_category where category_id ='".$_GET[category_id]."'");
			$num_row = $db->db_num_rows($sql);
			$sql_gname =  $db->db_fetch_array($sql);
			$name = ' >> '.findparent($sql_gname[parent_id]).$sql_gname[category_name];
			$col = $sql_gname[col];
			$row = $sql_gname[row];
			$hi = $sql_gname[height_s];
			$wi = $sql_gname[width_s];
			}
			?>
<span class="text_head"><div style="FONT: 17px 'Tahoma';"><a href="gallery_view_catelogy.php"><?php echo $text_GenGallery_cat;?></a><?php echo $name;?></div><hr size="1"></span></td>
		</tr>
		</table>

		<DIV id="group_gallery"></DIV>
		<script type="text/javascript" language="javascript1.2">
function galery_show(offset,category_id) {
	var objDiv = document.getElementById("group_gallery");
	url='gallery_group_list.php?offset='+offset+'&category_id='+category_id;				
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
		}
	);
	
}
galery_show('0','<?php echo $_GET[category_id];?>');
</script>
<?php
if($gallery_type_show ==''){
?>
<span id="galery_show2"></span>
		<script type="text/javascript" language="javascript1.2">

function galery_show2(offset,category_id,col,row,hi,wi) {
	var objDiv = document.getElementById("galery_show2");
	url='gallery_list.php?offset='+offset+'&category_id='+category_id+'&col='+col+'&row='+row+'&hi='+hi+'&wi='+wi;				
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					$(document).ready(function(){
						$("a.lightbox").lightbox({
							category_id : '<?php echo $_GET[category_id];?>',
							filename : 'index',
							vote : '<?php echo $sql_gname[category_vote];?>',
							comment : '<?php echo $sql_gname[category_comment];?>',
							send : '<?php echo $sql_gname[category_send];?>'
						});
					});
			}
		}
	);
	
}
galery_show2('0','<?php echo $_GET[category_id];?>','<?php echo $col;?>','<?php echo $row;?>','<?php echo $hi;?>','<?php echo $wi;?>');
</script>
	<?php 
}//End if  $gallery_type_show =='' ?>
<?php if($gallery_type_show =='Y'){ ?>
		<span id="group_gallery2"></span>
		<script type="text/javascript" language="javascript1.2">
function galery_show2(offset,category_id,col,row,hi,wi) {
	var objDiv = document.getElementById("group_gallery2");
	url='gallery_list2.php?offset='+offset+'&category_id='+category_id+'&col='+col+'&row='+row+'&hi='+hi+'&wi='+wi;				
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
		}
	);
	
}
galery_show2('0','<?php echo $_GET[category_id];?>','5','50','150','150');
</script>
<?php }//end if($gallery_type_show =='Y'){ ?>
<?php if($gallery_type_show =='S'){ 
include("gallery_list3.php");
}
?>

		<!--GGG---->
    </td>
    <td id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth = $F["d_site_right"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>

</body>
</html>
<?php 
if(!empty($img_id)){
$sql_insert = "insert into gallery_log (img_id,ip,date,time) VALUES ('".$img_id."','".getenv("REMOTE_ADDR")."','".date('Y-m-d')."','".date('H:i:s')."')";
$db->query($sql_insert);
}




$db->db_close(); ?>
