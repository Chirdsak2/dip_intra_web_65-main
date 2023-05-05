<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
$sql_article = $db->query("SELECT * FROM article_list WHERE n_id = '".$_GET["nid"]."'");
$R = $db->db_fetch_array($sql_article);
$nid = $_GET["nid"];

	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="wysiwyg.js"></script>
<script language="javascript">
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
</head>
<body leftmargin="0" topmargin="0">
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">บริหารข่าว/บทความ</span></td>
  </tr>
</table>
<iframe name="ftarget" id="ftarget" width="0" height="0"></iframe>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="article_edit.php?nid=<?php echo $_GET["nid"]; ?>&cid=<?php echo $R["c_id"]; ?>"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> กลับหน้าก่อนหน้า</a>&nbsp;&nbsp;&nbsp;<a href="article_group.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> 
      หน้าหลัก</a> &nbsp;&nbsp;&nbsp;<a href="article_list.php?cid=<?php echo $R["c_id"]; ?>"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> 
      หน้ารายการข่าว/บทความ</a> &nbsp;&nbsp;&nbsp;<a href="article_new.php?cid=<?php echo $R["c_id"]; ?>"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มข่าว/บทความ</a> 
    <hr>    </td>
  </tr>
</table>
<table width="90%" border="0" align="center" class="table table-bordered">
  <form action="article_function.php" method="post" enctype="multipart/form-data" name="form1" target="ftarget">
    <input type="hidden" name="backto" value="<?php if($_SESSION["EWT_OPEN_ARTICLE"] == ""){ echo "article_group.php"; }else{ echo "article_list.php?cid=".$_SESSION["EWT_OPEN_ARTICLE"]; } ?>">
        <tr>
      <td height="50" bgcolor="#F3F3EE" class="ewttablehead"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
        News Detail : Template<?php /*echo $R["at_id"];*/ ?> : Design Preview :  <?php
						$sql_temp = $db->query("SELECT d_id,d_name,d_default FROM design_list,template_module where  template_module.tm_did = design_list.d_id");
						?>
                                <select name="template">
								<option value="" >Default</option>
                                  <!--<?php //while($T=$db->db_fetch_array($sql_temp)){ ?>
                                  <option value="<?php //echo $T["d_id"]; ?>" <?php //if($T["d_id"] == $R["d_id"]){ echo "selected"; } ?>><?php //echo $T["d_name"]; ?></option>
                                  <?php //} ?>-->
                                </select>
								<?php $sql_temp = $db->query("SELECT d_id,d_name,d_default FROM design_list,template_module where  template_module.tm_did = design_list.d_id");?>
								<!--W3c Template :
								  <select name="template_w3c">
								<option value="" >Default</option>
                                  <?php /*while($T=$db->db_fetch_array($sql_temp)){ ?>
                                  <option value="<?php echo $T["d_id"]; ?>" <?php if($T["d_id"] == $R["d_id_w3c"]){ echo "selected"; } ?>><?php echo $T["d_name"]; ?></option>
                                  <?php } */?>
                                </select>-->
        <input type="submit" name="Button" value="Update"  onClick="document.form1.n_action.value='save';form1.submit();" />
        <input type="button" name="Submit2" value="Reset" onClick="self.location.reload();" />
		<input type="submit" name="Button" value="Preview" 
		onClick="window.open('','artpv','width=800,height=550,resizable=1,scrollbars=1'); document.form1.n_action.value='preview';form1.submit(); "
		 />
		<input type="submit" name="Button" value="Save &amp; Exit"  onClick="document.form1.n_action.value='exit';form1.submit();" /> 
		<input type="submit" name="Button5" value="Cancel this article"  onClick="document.form1.n_action.value='cancel'; return confirm('คุณแน่ใจหรือไม่ที่ต้องการลบ ข่าว/บทความนี้?'); " />
        
		
		<input name="Flag" type="hidden" id="Flag" value="NewsDetail" />
        <input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>" />
        <input name="cid" type="hidden" id="cid" value="<?php echo $R["c_id"]; ?>" />
        <input name="n_action" type="hidden" id="n_action"></td>
</tr>
<tr>
<td height="50" bgcolor="F3F3EE" class="head_table"><h2>การแสดงในหน้ารายละเอียด: </h2>
<h3>
<!--<input name="chk_group" type="checkbox" id="chk_group" value="1" <?php //if($R["show_group"] =='1'){ echo "checked";}?>>
            แสดงหมวดข่าว/บทความ 
			 <input name="chk_topic" type="checkbox" id="chk_topic" value="1" <?php //if($R["show_topic"] =='1'){ echo "checked";}?>>
         แสดงหัวข้อข่าว/บทความ-->
<input name="chk_date" type="checkbox" id="chk_date" value="1" <?php if($R["show_date"] =='1' OR $R["show_date"] ==''){ echo "checked";}?>>
แสดงวันที่
		<!-- <input name="chk_textsize" type="checkbox" id="chk_textsize" value="1" <?php //if($R["show_textsize"] =='1'){ echo "checked";}?>>
        แสดงเครื่องมือปรับขนาดอักษร -->
<input name="chk_show_count" type="checkbox" id="chk_show_count" value="1"  <?php if($R["show_count"] =='1' OR $R["show_count"] ==''){ echo checked;}?>>
แสดงจำนวนการเข้าอ่าน[ครั้ง] 
<input name="chk_newsshow" type="checkbox" id="chk_newsshow" value="1" <?php if($R["show_newstop"] =='1'){ echo "checked";}?>>
ข่าว/บทความ 5 อันดับสูงสุด 
<input name="chk_vote" type="checkbox" id="chk_vote" value="1" <?php if($R["show_vote"] =='1'){ echo "checked";}?>>
โหวตคะแนนให้ข่าว/บทความ
<input name="chk_comment" type="checkbox" id="chk_comment" value="1" <?php if($R["show_comment"] =='1'){ echo checked;}?> onClick="if(this.checked){document.all.comment_type.style.display='';}else{document.all.comment_type.style.display='none';}">
แสดงความคิดเห็นเพิ่มเติม
<select name="comment_type">
<option value="1" <?php if($R["comment_type"] =='1'){ echo "selected";}?>>ทุกคนแสดงความคิดเห็นได้</option>
<option value="2" <?php if($R["comment_type"] =='2'){ echo "selected";}?>>Login ก่อนแสดงความคิดเห็น</option>
</select>
</h3>
<script >
			  if(document.form1.chk_comment.checked){
			  document.all.comment_type.style.display='';
			  }else{
			  document.all.comment_type.style.display='none';}
</script>
<hr>
			<a href="article_upload_file.php?n_id=<?php echo $nid; ?>&cid=<?php echo $R["c_id"];?>"><h3><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="middle"> เพิ่มรายการเอกสารแนบ</a></h3></td>
        </tr>
		</form>
	<?php
	$sql_t = $db->query("SELECT at_file FROM article_template WHERE at_id = '$R[at_id]'");
	$A = $db->db_fetch_array($sql_t);

	?>
	<tr> 
      <td valign="top" bgcolor="#FFFFFF">
	  <?php 
	 $title_img = "รูปที่อัพโหลดผ่านระบบ หากเป็นรูปเคลื่อนไหวทีเป็น Gif Animation จะไม่สามารถแสดงการเคลื่อนไหวได้";
	  include("../article_template/".$A["at_file"]);
	  ?></td>
    </tr>
  
</table>
  
</body>
</html>
<?php
 	$db->db_close(); ?>
