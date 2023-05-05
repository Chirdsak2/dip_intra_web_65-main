					<table width="90%" border="0" align="center" cellpadding="5" cellspacing="5">
					  <tr>
						<td align="center"><span class="ewtfunction"><?php echo $R["n_topic"]; ?></span></td>
					  </tr>
					</table>

<table width="99%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
  <?php
	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '1' AND at_type_col = '1' ");
	  $C1 = $db->db_fetch_array($sql_r);
	  $a = "1";
	  $b = "";
	  ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="3" valign="top">
						   <strong>รายละเอียด:  <br>
						  <?php
							  $edWP=800;      //ความกว้าง  กล่อง Text ก่อน คลิก 
							  $edHP=320;      //ความสูง      กล่อง Text ก่อน คลิก 
							  $edWEP=800;  //ความกว้าง  iframe 
							  $edHEP=520;   //ความสูง     iframe 
							  $edWE=800;    //ความกว้าง   editor
							  $edHE=440;     //ความสูง      editor
							  $edID=$C1["ad_id"];
							  $ed_detail=$C1["ad_des"];
							  $OEname='b_ftargetx'.$a.'y'.$b;
							  $OPname='b_previewex'.$a.'y'.$b;
							  $OTname='t_previewex'.$a.'y'.$b;
							  include("../article_template/inc_editor.php"); 
						?>
    </td>
  </tr>
  <?php
$b = 1;
$sql = $db->query("SELECT MAX(at_type_row) FROM article_detail WHERE n_id = '$nid'");
$M = $db->db_fetch_row($sql);
for($x=2;$x<=$M[0];$x++){
$sql_l = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$x' AND at_type_col = '1' ");

	if($db->db_num_rows($sql_l) > 0){
	$C1 = $db->db_fetch_array($sql_l);
	$a = "1";
?>
  <tr bgcolor="#FFFFFF"> 
    <td width="33%" valign="top"><iframe style="display:none" scrolling="no"  frameborder="0"  name="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" id="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" width="0" height="0"></iframe><span  id="previewpx<?php echo $a; ?>y<?php echo $b; ?>"><form action="article_upload.php" method="post" enctype="multipart/form-data" name="formx<?php echo $a; ?>y<?php echo $b; ?>" target="ftargetx<?php echo $a; ?>y<?php echo $b; ?>"><strong>รูปภาพ: </strong><?php  if($C1["ad_pic_s"] != ""){ ?><div align = "right"><a href="#change" onClick="ShowEdit(document.all.whcx<?php echo $a; ?>y<?php echo $b; ?>);"><img src="../theme/main_theme/photo_scenery.jpg" width="16" height="16" border="0" align="absmiddle"> แก้ไขขนาดภาพ</a> <a href="#del" onClick="DelP(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>);"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" align="absmiddle"> ลบรูปภาพ</a></div>
						<div id="whcx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">แก้ไขขนาดภาพ สูง: 
							<input name="hbb" type="text" id="hbb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wbb" type="text" id="wbb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> <input type="Button" name="Button" value=" Save " style="width:60 px" onClick="chkE(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>)">
						  </div>
						<?php } ?>
						<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $C1["ad_id"]; ?>">
						<input name="ad_pic_b" type="hidden" id="ad_pic_b" value="<?php echo $C1["ad_pic_b"]; ?>">
						<input name="ad_pic_s" type="hidden" id="ad_pic_s" value="<?php echo $C1["ad_pic_s"]; ?>">
						<input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>">
						<input name="posdisp" type="hidden" id="posdisp" value="x<?php echo $a; ?>y<?php echo $b; ?>">
						  <input name="Flag" type="hidden" id="Flag" value="EUpload">
						  <table width="<?php echo $C1["ad_pic_w"]; ?>" height="<?php echo $C1["ad_pic_h"]; ?>" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" >
							<tr> 
							  <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php if($C1["ad_pic_s"] != ""){ echo "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$nid."/".$C1["ad_pic_s"]; }else{ echo "../images/pic_preview.gif"; } ?>" ></td>
							</tr>
						  </table>
						  <input name="fileb" type="file" id="fileb"  size="10" onChange="activeC(this,document.all.whx<?php echo $a; ?>y<?php echo $b; ?>,document.all.Buttonx<?php echo $a; ?>y<?php echo $b; ?>);"><input type="Button" name="Buttonx<?php echo $a; ?>y<?php echo $b; ?>" value=" Upload " style="width:60 px" onClick="chkU(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>)" disabled>
						  <div id="whx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">สูง: 
							<input name="hb" type="text" id="hb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wb" type="text" id="wb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> 
						  </div>
						  </form><img  style="display:none" name="pvx<?php echo $a; ?>y<?php echo $b; ?>" id="pvx<?php echo $a; ?>y<?php echo $b; ?>" src= "../images/o.gif">
						  </span>

						 <strong>รายละเอียด:  <br>
						  <?php
							  $edWP=290;      //ความกว้าง  กล่อง Text ก่อน คลิก 
							  $edHP=140;      //ความสูง      กล่อง Text ก่อน คลิก 
							  $edWEP=600;  //ความกว้าง  iframe 
							  $edHEP=500;   //ความสูง     iframe 
							  $edWE=600;    //ความกว้าง   editor
							  $edHE=440;     //ความสูง      editor
							  $edID=$C1["ad_id"];
							  $ed_detail=$C1["ad_des"];
							  $OEname='b_ftargetx'.$a.'y'.$b;
							  $OPname='b_previewex'.$a.'y'.$b;
							  $OTname='t_previewex'.$a.'y'.$b;
							  include("../article_template/inc_editor.php"); 
						?>

    </td>
    <?php
	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$x' AND at_type_col = '2' ");
	  $C1 = $db->db_fetch_array($sql_r);
	  $a = "2";
	  ?>
    <td width="33%" valign="top"><iframe style="display:none" scrolling="no"  frameborder="0"  name="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" id="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" width="0" height="0"></iframe><span  id="previewpx<?php echo $a; ?>y<?php echo $b; ?>"><form action="article_upload.php" method="post" enctype="multipart/form-data" name="formx<?php echo $a; ?>y<?php echo $b; ?>" target="ftargetx<?php echo $a; ?>y<?php echo $b; ?>"><strong>รูปภาพ: </strong><?php  if($C1["ad_pic_s"] != ""){ ?><div align = "right"><a href="#change" onClick="ShowEdit(document.all.whcx<?php echo $a; ?>y<?php echo $b; ?>);"><img src="../theme/main_theme/photo_scenery.jpg" width="16" height="16" border="0" align="absmiddle"> แก้ไขขนาดภาพ</a> <a href="#del" onClick="DelP(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>);"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" align="absmiddle"> ลบรูปภาพ</a></div>
						<div id="whcx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">แก้ไขขนาดภาพ สูง: 
							<input name="hbb" type="text" id="hbb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wbb" type="text" id="wbb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> <input type="Button" name="Button" value=" Save " style="width:60 px" onClick="chkE(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>)">
						  </div>
						<?php } ?>
						<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $C1["ad_id"]; ?>">
						<input name="ad_pic_b" type="hidden" id="ad_pic_b" value="<?php echo $C1["ad_pic_b"]; ?>">
						<input name="ad_pic_s" type="hidden" id="ad_pic_s" value="<?php echo $C1["ad_pic_s"]; ?>">
						<input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>">
						<input name="posdisp" type="hidden" id="posdisp" value="x<?php echo $a; ?>y<?php echo $b; ?>">
						  <input name="Flag" type="hidden" id="Flag" value="EUpload">
						  <table width="<?php echo $C1["ad_pic_w"]; ?>" height="<?php echo $C1["ad_pic_h"]; ?>" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" >
							<tr> 
							  <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php if($C1["ad_pic_s"] != ""){ echo "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$nid."/".$C1["ad_pic_s"]; }else{ echo "../images/pic_preview.gif"; } ?>" ></td>
							</tr>
						  </table>
						  <input name="fileb" type="file" id="fileb"  size="10" onChange="activeC(this,document.all.whx<?php echo $a; ?>y<?php echo $b; ?>,document.all.Buttonx<?php echo $a; ?>y<?php echo $b; ?>);"><input type="Button" name="Buttonx<?php echo $a; ?>y<?php echo $b; ?>" value=" Upload " style="width:60 px" onClick="chkU(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>)" disabled>
						  <div id="whx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">สูง: 
							<input name="hb" type="text" id="hb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wb" type="text" id="wb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> 
						  </div>
						  </form><img  style="display:none" name="pvx<?php echo $a; ?>y<?php echo $b; ?>" id="pvx<?php echo $a; ?>y<?php echo $b; ?>" src= "../images/o.gif">
						  </span>

						  <strong>รายละเอียด:  <br>
						  <?php
							  $edWP=290;      //ความกว้าง  กล่อง Text ก่อน คลิก 
							  $edHP=140;      //ความสูง      กล่อง Text ก่อน คลิก 
							  $edWEP=400;  //ความกว้าง  iframe 
							  $edHEP=300;   //ความสูง     iframe 
							  $edWE=400;    //ความกว้าง   editor
							  $edHE=250;     //ความสูง      editor
							  $edID=$C1["ad_id"];
							  $ed_detail=$C1["ad_des"];
							  $OEname='b_ftargetx'.$a.'y'.$b;
							  $OPname='b_previewex'.$a.'y'.$b;
							  $OTname='t_previewex'.$a.'y'.$b;
							  include("../article_template/inc_editor.php"); 
						?>
						  </td>
     <?php
	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$x' AND at_type_col = '3' ");
	  $C1 = $db->db_fetch_array($sql_r);
	  $a = "3";
	  ?><td width="34%" valign="top"><iframe style="display:none" scrolling="no"  frameborder="0"  name="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" id="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" width="0" height="0"></iframe><span  id="previewpx<?php echo $a; ?>y<?php echo $b; ?>"><form action="article_upload.php" method="post" enctype="multipart/form-data" name="formx<?php echo $a; ?>y<?php echo $b; ?>" target="ftargetx<?php echo $a; ?>y<?php echo $b; ?>"><strong>รูปภาพ: </strong><?php  if($C1["ad_pic_s"] != ""){ ?><div align = "right"><a href="#change" onClick="ShowEdit(document.all.whcx<?php echo $a; ?>y<?php echo $b; ?>);"><img src="../theme/main_theme/photo_scenery.jpg" width="16" height="16" border="0" align="absmiddle"> แก้ไขขนาดภาพ</a> <a href="#del" onClick="DelP(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>);"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" align="absmiddle"> ลบรูปภาพ</a></div>
						<div id="whcx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">แก้ไขขนาดภาพ สูง: 
							<input name="hbb" type="text" id="hbb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wbb" type="text" id="wbb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> <input type="Button" name="Button" value=" Save " style="width:60 px" onClick="chkE(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>)">
						  </div>
						<?php } ?>
						<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $C1["ad_id"]; ?>">
						<input name="ad_pic_b" type="hidden" id="ad_pic_b" value="<?php echo $C1["ad_pic_b"]; ?>">
						<input name="ad_pic_s" type="hidden" id="ad_pic_s" value="<?php echo $C1["ad_pic_s"]; ?>">
						<input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>">
						<input name="posdisp" type="hidden" id="posdisp" value="x<?php echo $a; ?>y<?php echo $b; ?>">
						  <input name="Flag" type="hidden" id="Flag" value="EUpload">
						  <table width="<?php echo $C1["ad_pic_w"]; ?>" height="<?php echo $C1["ad_pic_h"]; ?>" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" >
							<tr> 
							  <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php if($C1["ad_pic_s"] != ""){ echo "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$nid."/".$C1["ad_pic_s"]; }else{ echo "../images/pic_preview.gif"; } ?>" ></td>
							</tr>
						  </table>
						  <input name="fileb" type="file" id="fileb"  size="10" onChange="activeC(this,document.all.whx<?php echo $a; ?>y<?php echo $b; ?>,document.all.Buttonx<?php echo $a; ?>y<?php echo $b; ?>);"><input type="Button" name="Buttonx<?php echo $a; ?>y<?php echo $b; ?>" value=" Upload " style="width:60 px" onClick="chkU(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>)" disabled>
						  <div id="whx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">สูง: 
							<input name="hb" type="text" id="hb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wb" type="text" id="wb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> 
						  </div>
						  </form><img  style="display:none" name="pvx<?php echo $a; ?>y<?php echo $b; ?>" id="pvx<?php echo $a; ?>y<?php echo $b; ?>" src= "../images/o.gif">
						  </span>


						  <strong>รายละเอียด:  <br>
						  <?php
							  $edWP=290;      //ความกว้าง  กล่อง Text ก่อน คลิก 
							  $edHP=140;      //ความสูง      กล่อง Text ก่อน คลิก 
							  $edWEP=400;  //ความกว้าง  iframe 
							  $edHEP=300;   //ความสูง     iframe 
							  $edWE=400;    //ความกว้าง   editor
							  $edHE=250;     //ความสูง      editor
							  $edID=$C1["ad_id"];
							  $ed_detail=$C1["ad_des"];
							  $OEname='b_ftargetx'.$a.'y'.$b;
							  $OPname='b_previewex'.$a.'y'.$b;
							  $OTname='t_previewex'.$a.'y'.$b;
							  include("../article_template/inc_editor.php"); 
						?>
						  
						  </td>
  </tr>
  <?php $b++; }} ?>

</table>
