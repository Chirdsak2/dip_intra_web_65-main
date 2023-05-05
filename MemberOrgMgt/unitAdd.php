<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$db->query("USE ".$EWT_DB_USER);
if($_POST["flag"] != ''){
	if($org_id != ''){
		$wh = "and org_id<>'$org_id' ";
	}
	if($_POST["flag"] == 'add'){
	
	if($_POST["url"] != ""){
	if(!eregi("http://", $_POST["url"])){
		$url = "http://".$_POST["url"];
	}else{
		$url = $_POST["url"];
	}
		$fp = @fopen($url ,"r");
		if($fp){ 
		$pass = "Y";
		}else{
		?>
		<script>
		alert("ตรวจสอบ <?php echo $url; ?> ข้อมูลไม่ถูกต้อง !");
		</script>
		<?php
		exit;
		}
		@fclose($fp);
}
		$sql_chk = "select * from org_name where name_org = '$name_org'  $wh";
		$query = $db->query($sql_chk);
		if($db->db_num_rows($query)>0){
			echo "<script language=\"javascript\">";
			echo "alert('ชื่อหน่วยงานนี้มีอยู่แล้ว ท่านไม่สามารถบันทึกได้ กรุณาตรวจสอบ!!!!!!');";
		//	echo "document.location.href='unitList.php';" ;
			echo "</script>";
			exit;
		}
	}
	$save_path="pic_org/";
	if($_FILES['pics']['size'] > 0){
	$file_ext = explode('.',strtolower($_FILES['pics']['name'])); // หา นามสกุล ของไฟล์
	$picName = date('YmdHis').'.'.$file_ext[1];    //ชื่อไฟล์ ไหม่
	$uploadfile = $save_path.$picName; // path พร้อม newname ที่จะ upload
	 		 if(copy($_FILES['pics']['tmp_name'], $uploadfile)) { 	// upload to sever
			 	chmod($uploadfile,0777);							
				@unlink($save_path.$Hpics);																	
				$Hpics=$picName;
	         } 
	}else{
	$picName = $Hpics;
	}
	if($_FILES['map']['size'] > 0){
	$file_ext = explode('.',strtolower($_FILES['map']['name'])); // หา นามสกุล ของไฟล์
	$picMap = 'M'.date('YmdHis').'.'.$file_ext[1];    //ชื่อไฟล์ ไหม่
	$uploadfile = $save_path.$picMap; // path พร้อม newname ที่จะ upload
	 		 if(copy($_FILES['map']['tmp_name'], $uploadfile)) { 	// upload to sever
			 	chmod($uploadfile,0777);							
				@unlink($save_path.$Hmap);																	
				$Hmap=$picMap;
	         } 
	}else{
	$picMap = $Hmap;
	}
	if($_FILES['area']['size'] > 0){
	$file_ext =  explode('.',strtolower($_FILES['area']['name'])); // หา นามสกุล ของไฟล์
	$picArea = 'A'.date('YmdHis').'.'.$file_ext[1];     //ชื่อไฟล์ ไหม่
	$uploadfile = $save_path.$picArea; // path พร้อม newname ที่จะ upload
	 		 if(copy($_FILES['area']['tmp_name'], $uploadfile)) { 	// upload to sever
			 	chmod($uploadfile,0777);							
				@unlink($save_path.$Harea);																	
				$Harea=$picArea;
	         } 	
	}else{
	$picArea = $Harea;
	}

		
	if($_POST["flag"]=="add"){
		$rec = $db->db_fetch_array($db->query("SELECT max(parent_org_id) as parent_max FROM org_name WHERE parent_org_id LIKE '".$parent_org_id_send."_%' "));
		$parent_org_id_full =  $rec[parent_max];
		$parent_send_chk = explode("_",$parent_org_id_send);
		if($parent_org_id_full){
			$parent_org_id_full_split = explode("_",$parent_org_id_full);
			$get = count($parent_send_chk);
			$first = "";
			for($i=0;$i<$get;$i++){
				if($i>0) $first.="_";
				$first.=$parent_org_id_full_split[$i];
			}
			$parent_org_id_max = $first."_".sprintf("%04d",$parent_org_id_full_split[$get]+1);
		 }else{
		 	$parent_org_id_max = $parent_org_id_send."_0001";
		 }
		 $parent_org_id_max;
		 $insert="insert into  org_name (parent_org_id,title_name,desription,tel,email,fax,name_org,short_name,level_org,
		 org_object,org_address,org_place,org_map,org_area,org_color,org_pics,org_url) 
		                                       values('$parent_org_id_max','$title_name','$desription','$tel','$email','$fax','$name_org','$short_name','$hlevel',
		'$object','$address','$place','$picMap','$picArea','$g_bgcolor','$picName','$url')";	
		 $db->query($insert);
		 $db->query("USE ".$_SESSION["EWT_SDB"]);
		 $db->write_log("create","member","สร้างหน่วยงาน : ".$name_org);
		 $db->query("USE ".$EWT_DB_USER);
	}else{
	
				if($_POST["url"] != ""){
			if(!eregi("http://", $_POST["url"])){
				$url = "http://".$_POST["url"];
			}else{
				$url = $_POST["url"];
			}
				$fp = @fopen($url ,"r");
				if($fp){ 
				$pass = "Y";
				}else{
				?>
				<script language="javascript">
				alert("ตรวจสอบ <?php echo $url; ?> ข้อมูลไม่ถูกต้อง !");
				</script>
				<?php
				exit;
				}
				@fclose($fp);
		}

		 $update="update org_name set  title_name='$title_name',
														     desription='$desription',
														     tel='$tel',
														     email='$email',
														     fax='$fax',
															 name_org ='$name_org '  ,
															 short_name ='$short_name '  ,
															 org_object='$object',
															 org_address='$address',
															 org_place='$place',
															 org_map='$picMap',
															 org_area='$picArea',
															 org_color='$g_bgcolor',
															 org_pics='$picName',
															 org_url='$url'
												Where  org_id='$org_id' ";
	     $db->query($update);	
		 $db->query("USE ".$_SESSION["EWT_SDB"]);
		 $db->write_log("update","member","แก้ไขหน่วยงาน : ".$name_org);
		 $db->query("USE ".$EWT_DB_USER);
	}
	echo "<script>";
	//echo "alert('".$label."ข้อมูลเรียบร้อยแล้ว');";
	echo "parent.location.href='unitList.php';" ;
	echo "</script>";
}

	$select_main="SELECT  * FROM  `org_name` Where  org_id='$org_id' ";
	$exec_main = $db->query($select_main);
	$rst_main = $db->db_fetch_array($exec_main);
			
	$org_id=$rst_main[org_id];
	$org_type_id=$rst_main[org_type_id];
	$name_org=$rst_main[name_org];
	$short_name=$rst_main[short_name];
	$parent_org_id=$rst_main[parent_org_id];
	$title_name=$rst_main[title_name];
	$desription=$rst_main[desription];
	$tel=$rst_main[tel];
	$email=$rst_main[email];
	$fax=$rst_main[fax];
	
	$object=$rst_main[org_object];
	$place=$rst_main[org_place];
	$address=$rst_main[org_address];
	$color=$rst_main[org_color];
	$pics=$rst_main[org_pics];
	if($pics != ''){
	$pics2 = "pic_org/".$pics;
	}else{
	$pics2 = "../images/a_news_pic.gif";
	}
	$map=$rst_main[org_map];
	if($pics != ''){
	$picsmap2 = "pic_org/".$map;
	}else{
	$picsmap2 = "../images/a_news_pic.gif";
	}
	$area=$rst_main[org_area];
	if($pics != ''){
	$picsarea2 = "pic_org/".$area;
	}else{
	$picsarea2 = "../images/a_news_pic.gif";
	}
	$url=$rst_main[org_url];
	
	if($_GET["cmd"] == 'add'){
	$lable = 'เพิ่ม';
	}else{
	$lable = 'แก้ไข';
	}
?>
<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $lable;?>ข้อมูลหน่วยงาน</span> </td>
  </tr>
</table>-->
<?php
if($_GET["cmd"]=='add'){
$linkk = "unitAdd.php?cmd=".$_GET["cmd"]."&parent_org_id_send=".$_GET["parent_org_id_send"];
}else{
$linkk = "unitAdd.php?cmd=".$_GET["cmd"]."&org_id=".$_GET["org_id"];
}
?>
<!--<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($lable."ข้อมูลหน่วยงาน ".$name_org );?>&module=org&url=<?php echo urlencode($linkk);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="unitList.php"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> 
     กลับ</a>
      <hr>
    </td>
  </tr>
</table>-->



<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?="บริหารหน่วยงาน" ;?></h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
</div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >

<!--<a href="unitAdd.php?cmd=add&parent_org_id_send=0001" title="เพิ่มข้อมูลหน่วยงาน">
<button type="button" class="btn btn-info" >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?php //echo $lable;?>ข้อมูลหน่วยงาน
</button>	  	  
</a>-->
<a href="unitList.php" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>


</div>
</div>
<hr />
</div>	
<div class="clearfix">&nbsp;</div>


<div class="col-md-12 col-sm-12 col-xs-12" >
<form name="frm" method="post" action="" enctype="multipart/form-data" onSubmit="return CHK(document.frm);" target="urltest">
<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="name_org"><?php echo "ข้อมูลหน่วยงาน";?><span class="text-danger">*</span> : </label>
        <input class="form-control" name="name_org" type="text" id="name_org"  value="<?=trim($name_org);?>" />
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="short_name"><?php echo "ชื่อย่อหน่วยงาน"; ?><span class="text-danger">*</span> : </label>
		  <input class="form-control" name="short_name" type="text" id="short_name"  value="<?=trim($short_name);?>">
        
      </div>
</div>

<?php /*<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="desription"><?php echo "คำอธิบาย";?> : </label>
        <textarea class="form-control" rows="5" id="desription" name="desription"><?=$desription;?></textarea>
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="object"><?php echo "วัตถุประสงค์และภารกิจ"; ?> : </label>
		 <textarea class="form-control" rows="5" id="object" name="object"><?=$object;?></textarea>

        
      </div>
</div>


<div class="form-group row ">
      <div class="col-md-6 col-sm-6 col-xs-12 ">
        <label for="g_bgcolor"><?php echo "กำหนดสี";?> : </label>
        <a id="CPreview1" style="background-color:<?php echo $color;?>;" onClick="selColor('window.opener.document.frm.g_bgcolor.value','window.opener.document.all.CPreview1.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a>
         &nbsp;
         <input name="g_bgcolor" type="text" id="g_bgcolor" value="<?php echo $color;?>" class="form-control">
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12 form-inline ">
        <label for="pics"><?php echo "ภาพสัญลักษณ์"; ?> : </label>
		 <img src="<?php echo $pics2;?>" name="logo" width="100" height="100" id="logo">
					  <input name="pics" type="file" id="pics" class="form-control" onChange="document.getElementById('logo').src=this.value; document.frm.Hpics2.value=this.value;" />
					  <input type="hidden" value="<?php echo $pics;?>" name="Hpics" />
					  <input type="hidden" value="<?php echo $pics;?>" name="Hpics2" />
					        
      </div>
</div>

<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="place"><?php echo "สถานที่ตั้ง";?> : </label>
        <textarea class="form-control" rows="5" id="place" name="place"><?=$place;?></textarea>
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="address"><?php echo "ที่อยู่"; ?> : </label>
		 <textarea class="form-control" rows="5" id="address" name="address"><?=$address;?></textarea>

        
      </div>
</div>
<div class="form-group row form-inline">
      <div class="col-md-6 col-sm-6 col-xs-12 form-inline">
        <label for="map"><?="แผนที่";?> : </label>
        <img src="<?=$picsmap2;?>" width="100" height="100" id="mapP">
		<input name="map" type="file" id="map" class="form-control" onChange="document.getElementById('mapP').src=this.value; document.frm.Hmap2.value=this.value;" />
		<input type="hidden" value="<?=$map;?>" name="Hmap" />
		<input type="hidden" value="<?=$map;?>" name="Hmap2" />
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12 form-inline">
        <label for="area"><?="ภาพสถานที่"; ?> : </label>
		 <img src="<?php echo $picsarea2;?>" width="100" height="100" id="areaP">
					  <input name="area" type="file" id="area"  class="form-control"
					  onChange="document.getElementById('areaP').src=this.value; document.frm.Harea2.value=this.value;" />
					  <input type="hidden" value="<?php echo $area;?>" name="Harea" />
					  <input type="hidden" value="<?php echo $area;?>" name="Harea2" />
					  

        
      </div>
</div>*/ ?>
<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="tel"><?php echo "เบอร์โทรศัพท์ภายใน";?> : </label>
		<input name="tel" type="text" id="tel" value="<?=$tel;?>" class="form-control">
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="fax"><?php echo "Fax"; ?> : </label>
		<input name="fax" type="text" id="fax" value="<?=$fax;?>" class="form-control">		 
      </div>
</div>
<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="email"><?php echo "Email";?> : </label>
		<input name="email" type="text" id="email" value="<?=$email;?>" class="form-control">	
      </div>

	 
</div> 
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<input type="submit" name="Submit2" value="&nbsp;&nbsp;บันทึก&nbsp;&nbsp;" onClick="return ChkInput(document.myForm)" class="btn btn-success btn-ml" />
<input name="hlevel" type="hidden" id="hlevel" value="<?=$level; ?>" />
<input type="hidden" name="flag" value="<?=$_GET["cmd"];?>">
<input type="reset" name="Submit3" value="&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;" class="btn btn-warning" />
</div>
</div>
</form>

<!--<table width="70%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse" style="border-collapse:collapse">
                    <tr class="ewttablehead">
                      <td height="20" colspan="2" >ข้อมูลหน่วยงาน</td>
                    </tr>
                    <tr>
                      <td width="31%" bgcolor="#FFFFFF" >ชื่อหน่วยงาน : <font color="#FF0000">*</font></td>
                      <td width="69%" bgcolor="#FFFFFF">
					  <input name="name_org" type="text" id="name_org"  value="<?php echo trim($name_org);?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
                    </tr>
                    <tr>
                      <td width="31%" bgcolor="#FFFFFF" >ชื่อย่อหน่วยงาน : <font color="#FF0000">*</font></td>
                      <td width="69%" bgcolor="#FFFFFF">
					  <input name="short_name" type="text" id="short_name"  value="<?php echo trim($short_name);?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >คำอธิบาย :</td>
                      <td bgcolor="#FFFFFF">
					  <textarea name="desription" cols="45" rows="5" id="desription"  class="<?php echo $text_read;?>" <?php echo $close_text;?>><?php echo $desription;?></textarea>
					 				  </td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF">วัตถุประสงค์และภารกิจ :</td>
                      <td bgcolor="#FFFFFF">
	                    <textarea name="object" cols="45" rows="5" id="object"><?php echo $object;?></textarea>				  </td>
                    </tr>
											
                    <tr>
                      <td bgcolor="#FFFFFF" >กำหนดสี :</td>
                      <td bgcolor="#FFFFFF"><a id="CPreview1" style="background-color:<?php echo $color;?>;" onClick="selColor('window.opener.document.frm.g_bgcolor.value','window.opener.document.all.CPreview1.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a>
         &nbsp;
         <input name="g_bgcolor" type="text" id="g_bgcolor" value="<?php echo $color;?>" size="7">
		 </td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >กำหนดภาพสัญลักษณ์ :</td>
                      <td bgcolor="#FFFFFF"><img src="<?php echo $pics2;?>" name="logo" width="100" height="100" id="logo"><br>
					  <input name="pics" type="file" id="pics"  
					  onChange="document.getElementById('logo').src=this.value; document.frm.Hpics2.value=this.value;" />
					  <input type="hidden" value="<?php echo $pics;?>" name="Hpics" /><input type="hidden" value="<?php echo $pics;?>" name="Hpics2" />
					  
					  </td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >สถานที่ตั้ง :</td>
                      <td bgcolor="#FFFFFF"><textarea name="place" id="place"  cols="45" rows="5"><?php echo $place;?></textarea></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >ที่อยู่ :</td>
                      <td bgcolor="#FFFFFF"><textarea name="address" id="address"  cols="45" rows="5"><?php echo $address;?></textarea></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >แผนที่ :</td>
                      <td bgcolor="#FFFFFF"><img src="<?php echo $picsmap2;?>" width="100" height="100" id="mapP"><br>
					  <input name="map" type="file" id="map"  
					  onChange="document.getElementById('mapP').src=this.value; document.frm.Hmap2.value=this.value;" />
					  <input type="hidden" value="<?php echo $map;?>" name="Hmap" /><input type="hidden" value="<?php echo $map;?>" name="Hmap2" /></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >ภาพสถานที่ :</td>
                      <td bgcolor="#FFFFFF"><img src="<?php echo $picsarea2;?>" width="100" height="100" id="areaP"><br>
					  <input name="area" type="file" id="area" 
					  onChange="document.getElementById('areaP').src=this.value; document.frm.Harea2.value=this.value;" />
					  <input type="hidden" value="<?php echo $area;?>" name="Harea" /><input type="hidden" value="<?php echo $area;?>" name="Harea2" /></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >เบอร์โทรศัพท์ภายใน :</td>
                      <td bgcolor="#FFFFFF"><input name="tel" type="text" id="tel"  value="<?php echo $tel;?>" size="50"/></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >Fax :</td>
                      <td bgcolor="#FFFFFF"><input name="fax" type="text" id="fax" value="<?php echo $fax;?>" size="50"  class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >Email : </td>
                      <td bgcolor="#FFFFFF"><input name="email" type="text" id="email"  value="<?php echo $email;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF" >URL :</td>
                      <td bgcolor="#FFFFFF"><input name="url" type="text" id="url"  value="<?php echo $url;?>" size="50"></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center" bgcolor="#FFFFFF" ><input name="save" type="submit" class="submit" style="width:80"  value="บันทึก" />
                        <input type="button" name="Submit2" class="submit" value="ยกเลิก"  onclick="window.location.href = 'unitList.php';"  style="width:80" />
                      <input name="hlevel" type="hidden" id="hlevel" value="<?php echo $level; ?>" />
                      <input type="hidden" name="flag" value="<?php echo $_GET["cmd"];?>"></td>
                    </tr>
</table>-->


<iframe name="urltest" width="1" height="1"></iframe>

</div>

</div>
<hr />
</div>

</div>			  

					
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script>
function CHK(t){
	
	if(t.name_org.value == ''){
		alert('กรุณากรอกชื่อหน่วยงาน');
		t.name_org.focus();
		return false;
	}
	if(t.short_name.value == ''){
		alert('กรุณากรอกชื่อย่อหน่วยงาน');
		t.short_name.focus();
		return false;
	}
	/*if(t.email.value != '' && !validEMail(t.email.value.toLowerCase())){
		
						alert('กรุณากรอกรูปแบบ Email  ให้ถูกต้อง');
						t.email.select();
						return false;
	}*/
}


function validEMail(mo){
		if (validLength(mo,1,50)){
			if (mo.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
				return true;
			else return false;
 		}
		return true;
}
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
}
function chkwww(c){
if(c.value != ""){
document.all.urltest.src = "check.php?url=" + c.value;
}
}

	function selColor(c,d,e){
					Win2=window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '&c_preview='+ e +'','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
	}
	
	function CreColor(va,bg,pre,flag){
		bg.style.backgroundColor= va;
		if(flag == 'color'){
			pre.style.color = va;
		}else{
			pre.style.backgroundColor = va;
		}
	}
</script>
