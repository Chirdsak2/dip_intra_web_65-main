<?php
$path = '../';
	session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect_uncheck.php");
	$lang_shw = $sh;
	if($sh != ''){
	$lang_sh = '_'.$sh;
	}
	include($path."language/language".$lang_sh.".php");
	$uploaddir =$path."../pic_upload/";
	$or = explode(",",$_GET[org]);
	$sname = $or[2];
	$spic = $or[3];
	$sdetail = $or[4];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Organization Chart</title>
<style type="text/css">
<!--
BODY {
	FONT-SIZE: 11px; MARGIN: 0px; COLOR: #000000; FONT-FAMILY: "Tahoma"
}
.copyright {
	COLOR: #e1e1e1
}
A:link {
	COLOR: #000000; TEXT-DECORATION: none
}
A:visited {
	COLOR: #000000; TEXT-DECORATION: none
}
A:active {
	COLOR: #000000; TEXT-DECORATION: none
}
A:hover {
	COLOR: #000000; TEXT-DECORATION: none
}
H2 {
	FONT: 11px "Tahoma"
}
H1 {
	FONT: 23px "Tahoma"
}
INPUT {
	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: "Tahoma"
}
TEXTAREA {
	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: "Tahoma"
}
TABLE {
	FONT: 11px "Tahoma"
}
SELECT {
	FONT: 11px "Tahoma"
}
-->
</style>
</head>
<body  >
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<?php
  $sql_group1 = $db->query("SELECT * FROM org_name WHERE org_id = '".$_GET["oid"]."' ");
  $R = $db->db_fetch_array($sql_group1);
    $logo = "../../../MemberMgt/pic_org/".$R[org_pics];
   $map= "../../../MemberMgt/pic_org/".$R[org_map];
   $area= "../../../MemberMgt/pic_org/".$R[org_area];
   if(file_exists($logo) && $R[org_pics] != ''){$logo = $logo;}else{$logo = "../../../images/a_no_pic.gif";}
   if(file_exists($map) && $R[org_map] !=''){$map = "<a href=\"img.php?p=".base64_encode($map)." target=\"_blank\"> แผนที่".$R[name_org]."</a>";}else{$map = "";}
   if(file_exists($area) && $R[org_area] !=''){$area =  "<a href=\"img.php?p=".base64_encode($area)." target=\"_blank\"> ภาพสถานที่".$R[name_org]."</a>";}else{$area = "";}
						if($lang_shw != ''){
							$R["name_org"] = select_lang_detail_ewt($R[org_id],$lang_shw,'name_org','org_name');
							$R["org_place"] = select_lang_detail_ewt($R[org_id],$lang_shw,'org_place','org_name');
							$R["org_address"] = select_lang_detail_ewt($R[org_id],$lang_shw,'org_address','org_name');
							$R["org_object"] = select_lang_detail_ewt($R[org_id],$lang_shw,'org_object','org_name');
							
							}
?>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" >
  <tr>
    <td align="center" bgcolor="<?php if($R[org_color] != ''){ echo $R[org_color];}else{ echo "#EEEEEE";} ?>" ><font size="4"><strong><?php echo $R[name_org]; ?></strong></font>
	<?php if($sdetail == "Y"){ ?><hr size="1">
	  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
        <tr>
          <td width="31%" class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_location;?> :</span></td>
          <td width="69%"><span class="text_normal"><?php echo $R[org_place] ?></span></td>
          <td width="69%" align="center"><span class="text_normal"><?php echo $text_genchat_logo;?></span></td>
        </tr>
        <tr>
          <td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_addess;?> :</span></td>
          <td><span class="text_normal"><?php echo $R[org_address] ?></span></td>
          <td rowspan="9" align="center"><img src="img.php?p=<?php echo base64_encode($logo); ?>" width="98" height="98" alt="logo"></td>
        </tr>
        <tr>
          <td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_phonin;?> :</span></td>
          <td><span class="text_normal"><?php echo $R[tel] ?></span></td>
        </tr>
        <tr>
          <td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_fax;?> :</span></td>
          <td><span class="text_normal"><?php echo $R[fax] ?></span></td>
        </tr>
        <tr>
          <td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_email;?> : </span></td>
          <td><span class="text_normal"><?php echo $R[email] ?></span></td>
        </tr>
        <tr>
          <td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_url;?> :</span></td>
          <td><span class="text_normal"><?php echo $R[org_url] ?></span></td>
        </tr>
        <tr>
          <td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_objective;?> :</span></td>
          <td><span class="text_normal"><?php echo $R[org_object]; ?></span></td>
        </tr>
        <tr>
          <td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_map;?> :</span></td>
          <td><span class="text_normal"><?php echo $map;?></span></td>
        </tr>
        <tr>
          <td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_place;?> :</span></td>
          <td><span class="text_normal"><?php echo $area;?></span></td>
        </tr>
        <tr>
          <td class="bg_color_row">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
	  <?php } ?></td>
  </tr>
</table>
<?php
$sql_position = $db->query("SELECT distinct(pos_name) AS pos_name ,pos_id FROM position_name INNER JOIN gen_user ON position_name.pos_id = gen_user.posittion WHERE gen_user.org_id = '".$R["org_id"]."' ORDER BY position_name.pos_level ASC ");
while($P = $db->db_fetch_array($sql_position)){
						if($lang_shw != ''){
							$P["pos_name"] = select_lang_detail_ewt($P[pos_id],$lang_shw,'pos_name','position_name');
							}
?><br>
<table width="70%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center" bgcolor="<?php if($R[org_color] != ''){ echo $R[org_color];}else{ echo "#F7F7F7";} ?>"><?php echo $P["pos_name"]; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<?php
	$sql_user = $db->query("SELECT * FROM gen_user WHERE posittion = '".$P["pos_id"]."'  and  gen_user.org_id = '".$R["org_id"]."' order by  level_id ASC,org_type_id DESC,name_thai  ASC ");
		$x=0;
	while($U = $db->db_fetch_array($sql_user)){
	$path_image=$U[path_image];
	if($path_image != ''){
	$path_image22 = $uploaddir.$path_image;
	if(file_exists($path_image22)){
	$path_image2 = $path_image22;
	}else{
	$path_image2 = "../../images/ImageFile.gif";
	}
	}else{
	$path_image2 = "../../images/ImageFile.gif";
	}
//echo $lang_shw;
					if($lang_shw != ''){
					$U["name_thai"] = select_lang_detail_ewt($U[gen_user_id],$lang_shw,'name_thai','gen_user');
					$U["surname_thai"] = select_lang_detail_ewt($U[gen_user_id],$lang_shw,'surname_thai','gen_user');
					$U["position_person"] = select_lang_detail_ewt($U[gen_user_id],$lang_shw,'position_person','gen_user');
					}//echo $U[name_thai];
	if($x%3 == 0){
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
		}
	?>
          <td width="33%" align="center"><?php if($spic == "Y"){ ?><img src="img.php?p=<?php echo base64_encode($path_image2); ?>" width="98" height="98" alt=" <?php echo $U["surname_thai"]; ?><br><?php echo $U["position_person"]; ?>"><?php } ?><?php if($sname == "Y"){ ?><br><font size="2"><?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?><br><?php echo $U["position_person"]; ?></font><?php } ?>
		  
</td>
	  <?php $x++;
		if($x%3 == 0){
		echo "</tr></table><br>";
		}
} 
	if($x%3==1 OR $x%3==2){
		echo "</tr></table><br>";
	}
?>
	  </td>
  </tr>
</table><br>
<br>
<br>
<?php } ?>
<!--เจ้าหน้าที่-->
<?php
$sql_position2 = $db->query("SELECT * FROM gen_user  WHERE gen_user.org_id = '".$R["org_id"]."' and posittion = '' order by level_id ASC,org_type_id DESC,name_thai  ASC");
if($db->db_num_rows($sql_position2) >0){
?><br>
<table width="70%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center" bgcolor="<?php if($R[org_color] != ''){ echo $R[org_color];}else{ echo "#F7F7F7";} ?>"><?php echo $text_genchat_lblstaff;?>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<?php
	$sql_user2 = $db->query("SELECT * FROM gen_user WHERE  gen_user.org_id = '".$R["org_id"]."' and posittion = '' order by  level_id ASC,org_type_id DESC,name_thai  ASC ");
	$x=0;
	while($U2 = $db->db_fetch_array($sql_user2)){
	$path_image=$U2[path_image];
	if($path_image != ''){
	$path_image22 = $uploaddir.$path_image;
	if(file_exists($path_image22)){
	$path_image2 = $path_image22;
	}else{
	$path_image2 = "../../images/ImageFile.gif";
	}
	}else{
	$path_image2 = "../../images/ImageFile.gif";
	}
					if($lang_shw != ''){
					$U2["name_thai"] = select_lang_detail_ewt($U2[gen_user_id],$lang_shw,'name_thai','gen_user');
					$U2["surname_thai"] = select_lang_detail_ewt($U2[gen_user_id],$lang_shw,'surname_thai','gen_user');
					$U2["position_person"] = select_lang_detail_ewt($U2[gen_user_id],$lang_shw,'position_person','gen_user');
					}
	if($x%3 == 0){
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
		}
	?>
          <td width="33%" align="center"><?php if($spic == "Y"){ ?><img src="img.php?p=<?php echo base64_encode($path_image2); ?>" width="98" height="98" alt="<?php echo $U2["name_thai"]; ?> <?php echo $U2["surname_thai"]; ?>"><?php } ?><?php if($sname == "Y"){ ?><br><font size="2"><?php echo $U2["name_thai"]; ?> <?php echo $U2["surname_thai"]; ?><br><?php echo $U2["position_person"]; ?></font><?php } ?>
		  
</td>
	  <?php $x++;
		if($x%3 == 0){
		echo "</tr></table><br>";
		}
} 
	if($x%3==1 OR $x%3==2){
		echo "</tr></table><br>";
	}
?>
	  </td>
  </tr>
</table>
<? } ?>
<br>
<br>
<a href="http://validator.w3.org/check?uri=referer"><img src="images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</body>
</html>
<?php $db->db_close(); ?>
