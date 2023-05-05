<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
	$defwidth = "120";
	$defheight = "120";
$img = array();
$link = array();
$img_w = array();
$img_h = array();
$mainwidth = $mainwidth;
$global_theme = $global_theme;
	$sql_show = $db->query("SELECT block_link,block_themes FROM block WHERE BID = '".$bid."' ");
	$B = $db->db_fetch_row($sql_show);
	
	$block_link = explode('#',$B[0]);
	$B[0] = $block_link[0];
	$B[1] = $block_link[1];
	if($B[1] != '0'){
		$themeid = $B[1];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
		$namefolder = "themes".($themeid);
		
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		 //if($themes_type == 'F'){
		$buffer = "";
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
                echo $design[0];
		 }
      }
$sql_article_group = $db->query("SELECT * FROM article_group INNER JOIN article_apply ON article_group.c_id = article_apply.c_id  WHERE article_apply.text_id = '".$bid."'  AND article_apply.a_active = 'Y' ORDER BY article_apply.a_pos ASC");
while($AG = $db->db_fetch_array($sql_article_group)){
		$sql_article = $db->query("SELECT * FROM article_list WHERE c_id = '".$AG["c_id"]."' AND n_approve = 'Y' and (('$date_now' between n_date_start  and n_date_end) or (n_date_start = '' and n_date_end = '')) ORDER BY RAND() LIMIT 0,3");
			while($A = $db->db_fetch_array($sql_article)) {
						if($A["picture"] != "") { 
													
													if($AG["AMBodyBPW"] == "" AND $AG["AMBodyBPH"] == ""){
														$ewtw = $defwidth;
														$ewth = $defheight;
													}else{
				
														$ewtw = $AG["AMBodyBPW"];
														$ewth = $AG["AMBodyBPH"];
													}
											if(file_exists("images/article/news".$A["n_id"]."/".$A["picture"])){
				
												$pic= $Website."images/article/news".$A["n_id"]."/".$A["picture"]; 
											}else{
													$sql_pic_detail = $db->query("SELECT ad_pic_b FROM article_detail WHERE n_id = '".$A["n_id"]."' AND ad_pic_b != '' ORDER BY ad_id ASC LIMIT 0,1");
													if($db->db_num_rows($sql_pic_detail) > 0){
													$pd = $db->db_fetch_row($sql_pic_detail);
														 if(file_exists("images/article/news".$A["n_id"]."/".$pd[0])){
															$pic = "images/article/news".$A["n_id"]."/".$pd[0];
														 }
													}
											}
									
									}else{ //ว่าง
													if($AG["AMBodyBPW"] == "" AND $AG["AMBodyBPH"] == ""){
														$ewtw = $defwidth;
														$ewth = $defheight;
													}else{
														$ewtw = $AG["AMBodyBPW"];
														$ewth = $AG["AMBodyBPH"];
													}
												
													$sql_pic_detail = $db->query("SELECT ad_pic_b FROM article_detail WHERE n_id = '".$A["n_id"]."' AND ad_pic_b != '' ORDER BY ad_id ASC LIMIT 0,1");
													if($db->db_num_rows($sql_pic_detail) > 0){
													$pd = $db->db_fetch_row($sql_pic_detail);
														 if(file_exists("images/article/news".$A["n_id"]."/".$pd[0])){
															 $pic = "images/article/news".$A["n_id"]."/".$pd[0];
														 }
													}
									}
				if($pic != ''){
					array_push($img,$pic);
				}else{
					array_push($img,'mainpic/spacer.gif');
				}
				array_push($img_w,$ewtw);
				array_push($img_h,$ewth);
														if($A["news_use"] == "2" or $A["news_use"] == "3") { 
															$linknews = "ewt_news.php?nid=".$A["n_id"]."&filename=".$filename;
														} elseif($A["news_use"] == "4") { 
															$linknews = "ewt_dl.php?nid=".$A["n_id"]."&filename=".$filename;
														} else { 
															$linknews = $A["link_html"];
														}
				if($linknews != ''){
					array_push($link,$linknews);
				}else{
					array_push($link,'#NEWS');
				}
			
			}
}
if($img[0] == ''){$img[0]  = "mainpic/spacer.gif";}
if($img[1] == ''){$img[1]  = "mainpic/spacer.gif";}
if($img[2] == ''){$img[2]  = "mainpic/spacer.gif";}
if($link[0] == ''){$link[0]  = "#NEWS";}
if($link[1] == ''){$link[1]  = "#NEWS";}
if($link[2] == ''){$link[2]  = "#NEWS";}
if($img_w[0]== ''){$img_w[0]  = $mainwidth;}
if($img_h[0] == ''){$img_h[0]  = "263";}
?>
<HTML>
<HEAD>
<TITLE></TITLE>
<style type="text/css">
<!--
body {
	background-color: <?php echo $bg_color;?>;
}
-->
</style>
<SCRIPT>
<!--

var fadeimages = new Array;
var linkarr = new Array;
var numimg = new Array;

fadeimages[0] = '<?php echo $img[0];?>';
fadeimages[1] = '<?php echo $img[1];?>';
fadeimages[2] = '<?php echo $img[2];?>';

linkarr[0] = '<?php echo $link[0];?>';
linkarr[1] = '<?php echo $link[1];?>';
linkarr[2] = '<?php echo $link[2];?>';

numimg[0] = 'mainpic/ad-no-over_01.gif';
numimg[1] = 'mainpic/ad-no-over_02.gif';
numimg[2] = 'mainpic/ad-no-over_03.gif';



var cliImg = '';
var cliImgSrc = '';
var n = Math.round(Math.random() * 10);
var interval = 5000;
var setTimeId = '';
function rotateStop(){
	clearTimeout(setTimeId);
}
function rotateStart(){
	rotate();
}
function chki(ci, no){
	var pImg = document.all.RollImg;
	var pUrl = document.all.RollUrl;
	if(cliImg == '') {
		cliImg = ci;
		cliImgSrc = ci.src;
		ci.src = numimg[no];
		n=no;
		pImg.src = fadeimages[no];
		pUrl.href = linkarr[no];
	} else if(cliImg != ci) {
		cliImg.src = cliImgSrc;
		cliImg = ci;
		cliImgSrc = ci.src;
		ci.src = numimg[no];
		n=no;
		pImg.src = fadeimages[no];
		pUrl.href = linkarr[no];
	}
}
function rotate(){
	n = (n >= 2) ? 0 : n+1;
	setimgurl();
	setTimeId=setTimeout('rotate()',interval);
}
function setimgurl(){
	var ci = eval('document.all.num_img'+n);
	document.all.RollImg.filters.blendTrans.apply();
	document.all.RollUrl.href=linkarr[n];
	document.all.RollImg.src=fadeimages[n];
	document.all.RollImg.filters.blendTrans.play();
	if(cliImg == '') {
		cliImg = ci;
		cliImgSrc = ci.src;
		ci.src = numimg[n];
	} else if(cliImg != ci) {
		cliImg.src = cliImgSrc;
		cliImg = ci;
		cliImgSrc = ci.src;
		ci.src = numimg[n];
	}
}
//-->
</SCRIPT>

</HEAD>
<BODY bottomMargin=0 leftMargin=0 topMargin=0 onload=rotateStart(); rightMargin=0 0>
<TABLE cellSpacing=0 cellPadding=0 width=<?php echo $mainwidth;?> border=0>
  <TBODY>
  <TR>
    <TD><A href="<?php echo $link[0];?>" onfocus=this.blur() target=_top name=RollUrl> <IMG style="FILTER: blendTrans(duration=1)"  src="<?php echo $img[0];?>" width='<?php echo $img_w[0];?>' border=0 height="<?php echo $img_h[0];?>"  name=RollImg></A></TD>
  </TR>
  <TR>
    <TD vAlign=top align=middle> 
      <TABLE width=98 border=0 align="left" cellPadding=0 cellSpacing=0>
        <TBODY> 
        <TR>
		 <TD vAlign=center align=middle width=15>&nbsp;</TD>
		  <TD vAlign=center align=middle><a href="<?php echo $link[0];?>" target="_parent"><IMG 
            onmouseover=chki(this,0); style="CURSOR: hand"  
            src="mainpic/ad-no_01.gif"  border=0 
            name=num_img0></a></TD>
		  <TD vAlign=center align=middle><a href="<?php echo $link[1];?>" target="_parent"><IMG 
            onmouseover=chki(this,1); style="CURSOR: hand" 
            src="mainpic/ad-no_02.gif"  border=0 
            name=num_img1></a></TD>
		 <TD vAlign=center align=middle><a href="<?php echo $link[2];?>" target="_parent"><IMG 
            onmouseover=chki(this,2); style="CURSOR: hand" 
            src="mainpic/ad-no_03.gif"  border=0 
            name=num_img2></a></TD> 
        </TR>
		</TBODY>
	</TABLE>
  </TD>
 </TR>
 </TBODY>
</TABLE>
</BODY>
</HTML>