<?php
include("../EWT_ADMIN/comtop.php");

if($_POST["flag"] == "change"){
	
	$Execsql = $db->query("UPDATE w_admin SET t_user = '$user',t_pass = '$pass'");
	?>
	<script language="JavaScript">
		alert("แก้ไขข้อมูลเรียบร้อยแล้ว");
	window.location.href = "webboard_main.php";
	</script>
	<?php
	exit;
	}
	if($_POST["flag"] == "config"){
	
	$Execsql=$db->query("SELECT * FROM w_config");
	if($db->db_num_rows($Execsql)>0){
				$Execsql = $db->query("UPDATE w_config SET c_approve = '".$_POST["wtype"]."',c_number = '".$_POST[nump]."',c_mail = '".$_POST[wemail]."',c_img='".$_POST[Img]."',c_link='".$_POST[txt_time]."',c_sizeupload='".$_POST[txt_size]."',c_vote='".$_POST[wvote]."',c_voteshow ='".$_POST[txtshowdate]."',c_showip='".$_POST[wip]."' WHERE c_config = '1'");
	}else{
				$Execsql = $db->query("INSERT INTO 
				w_config(c_approve,c_number,c_mail,c_img,c_link,c_sizeupload,c_vote,c_voteshow,c_showip) 
				VALUES('".$_POST[wtype]."','".$_POST[nump]."','".$_POST[wemail]."','".$_POST[Img]."','".$_POST[txt_time]."','".$_POST[txt_size]."','".$_POST[wvote]."','".$_POST[txtshowdate]."','".$_POST[wip]."' )");
	}
	$db->write_log("update","webboard","ตั้งค่ากระทู้");
	?>
	<script language="JavaScript">
		alert("แก้ไขข้อมูลเรียบร้อยแล้ว");
	window.location.href = "webboard_admin.php";
	</script>
	<?php
	exit;
	}

?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
include("lib/webboard_function.php");

?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?=$txt_webboard_menu_main;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?=$txt_webboard_menu_main;?></li>
<!-- <li class=""><?=$txt_webboard_menu_user;?></li>        -->
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
	<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">
			<i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span>
		</button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
				<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?=$cal_cid;?>');" >
					<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_calendar_add_cate;?>
				</a>
			</li>
			
			<li>
				<a href="banner_group.php" target="_self" >
					<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
				</a>
			</li>
		</ul>
	</div>
</div>

	
<div class="float-right text-right" style="top:18px;margin-bottom:10px;"> 
			
	<a href="webboard_add_room.php" title="<?=$txt_webboard_menu_main ;?>"  target="_self">
		<button type="button" class="btn btn-default btn-sm" >
			<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_webboard_new_room;?>
		</button>
	</a>

</div>

</div>
</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<div class="card ">
	<div class="card-header ewt-bg-color m-b-sm" >
		<div class="card-title text-left color-white">
			<p><h4><?=$txt_webboard_menu_main;?></h4></p>
		</div>
	</div>
	<div class="card-body">

	<div class="panel-group" id="accordion">
		
		<div class="panel panel-default ">

			<div class="panel-heading ewt-bg-success">
				<table border="0" width="100%">
					<tr>
						<td align="left">
							<h4 class="panel-title">
								<i class="fas fa-comment-dots color-ewt"></i> 
								ตั้งค่าของกระทู้ 
							</h4>
						</td>
					</tr>
				</table>
			</div>
		
			<div class="">
				<div class="panel-body">

					<style>
						td { 
							padding: 10px;
						}
					</style>

					<?php
						$sql = $db->query("SELECT * 
						                   FROM w_config 
										   WHERE c_config = '1'");
						$R = mysqli_fetch_array($sql);
					?>

					<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse" style="padding:10px;">
						<form name="form2"  method="post">

							<tr bgcolor="#FFFFFF">
								<td width="34%"><b>มีการอนุมัติก่อนขึ้นแสดง</b><font color="#FF0000">&nbsp;</font></td>
								<td width="66%"><select name="wtype" id="wtype">
								<option value="1" <?php if($R[c_approve] == "1"){ echo "selected"; } ?>>Yes</option>
								<option value="0" <?php if($R[c_approve] == "0"){ echo "selected"; } ?>>No</option>
								</select></td>
							</tr>

							<!-- <tr bgcolor="#FFFFFF"> 
								<td><b>มีการแจ้งเตือนทางอีเมล์เมื่อมีข้อความใหม่</b></td>
								<td><input name="wemail" type="text" id="wemail" value="<?php echo $R[c_mail]; ?>">
								<br>
								<span class="style1">(ในกรณีที่ต้องการใส่หลายคน ให้คั้นด้วยเครื่องหมาย ; )</span></td>
							</tr> -->

							<tr bgcolor="#FFFFFF">
								<td><b>จำนวนกระทู้ในหมวดต่อหนึ่งหน้า</b><font color="#FF0000">&nbsp;</font></td>
								<td><input name="nump" type="text" id="nump" value="<?php echo $R[c_number]; ?>" size="2" onKeyUp="chkformatnum(this)"></td>
							</tr>

							<tr bgcolor="#FFFFFF">
								<td><b>กำหนดประเภทนามสกุลรูปภาพ</b></td>
								<td><input type="text" name="Img" id="Img" value="<?php echo $R[c_img]; ?>">
								Ex: jpg,gif </td>
							</tr>

							<!-- <tr bgcolor="#FFFFFF">
								<td><b>กำหนดเวลาการตอบกระทู้อัตโนมัติ</b></td>
								<td><input name="txt_time" type="text" id="txt_time" size="5" value="<?php echo $R[c_link]; ?>" onKeyUp="chkformatnum(this)">
								นาที</td>
							</tr> -->

							<tr bgcolor="#FFFFFF">
								<td><b>กำหนดขนาดไฟล์ที่สามารถนำขึ้นได้</b></td>
								<td><input name="txt_size" type="text" size="5" value="<?php echo $R[c_sizeupload]; ?>" onKeyUp="chkformatnum(this)">
								KB.</td>
							</tr>

							<!-- <tr bgcolor="#FFFFFF">
								<td><b>กำหนดให้สามารถโหวตคำถามได้</b></td>
								<td><select name="wvote" id="wvote" onChange="fixdate(this);">
								<option value="0" <?php if($R[c_vote] == "0"){ echo "selected"; } ?>>Yes</option>
								<option value="1" <?php if($R[c_vote] == "1"){ echo "selected"; } ?>>No</option>
								</select>
								<span id='showdate'  <?php if($R[c_vote] == "1"){ ?>style="display:none"<?php }?>> จากวันตั้งกระทู้      
								<input name="txtshowdate" value="<?php echo $R[c_voteshow]; ?>" type="text" size="3" maxlength="3" onKeyUp="chkformatnum(this)"> 
								วัน<br>
								<span class="style1">(ในกรณีที่ใส่เป็น 0 หรือ ช่องว่าง จะเป็นการไม่กำหนดเวลา)</span></span></td>
							</tr>
							 -->
							 
							<tr bgcolor="#FFFFFF">
								<td><b>กำหนดการแสดงหมายเลขเครื่อง (IP)</b></td>
								<td><select name="wip" id="wip" >
								<option value="Y" <?php if($R[c_showip] == "Y"){ echo "selected"; } ?>>แสดง</option>
								<option value="N" <?php if($R[c_showip] == "N"){ echo "selected"; } ?>>ไม่แสดง</option>
								</select></td>
							</tr>

							<tr bgcolor="#FFFFFF">
								<td>&nbsp;</td>
								<td><input type="submit" name="Submit" value="Submit" class="normaltxt">
								<input type="reset" name="Submit2" value="Reset" class="normaltxt">
								<input name="flag" type="hidden" id="flag" value="config">	  </td>
							</tr>

						</form>
					</table>
				</div>
			</div>
			
		</div>
			
	</div>

</div>
</div>	
</div>
</div>

</div>
<!--END card-body-->
</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
/* <!-- */
.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
/* --> */
</style>



<script language="JavaScript">
function fixdate(t){
if(t.value == '0'){
document.getElementById('showdate').style.display ='' ; 
}else{
document.getElementById('showdate').style.display ='none' ; 
}
}
function CHK(){
if(document.form1.user.value == ""){
alert("กรุณาใส่ username");
document.form1.user.focus();
return false;
}
if(document.form1.pass.value == ""){
alert("กรุณาใส่ password");
document.form1.pass.focus();
return false;
}

if(document.form1.cpass.value != document.form1.pass.value){
alert("กรุณายืนยัน password ตรงกัน");
document.form1.cpass.select();
return false;
}
}
function CHK1(){
if(document.form2.nump.value == ""){
alert("กรุณาใส่จำนวนกระทู้ในหมวดต่อหนึ่งหน้า");
document.form2.nump.focus();
return false;
}
}
 function isNum (charCode) 
   {
       if (charCode >= 48 && charCode <= 57 )
	       return true;
      else
	     return false;
   }
 function chkFormatNam (str) {//0-9
  strlen = str.length;
  for (i=0;i<strlen;i++)
  {
      var charCode = str.charCodeAt(i);
	  if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
		  return false;
	  }
   }
   return true;
}
function chkformatnum(t){ 
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
</script>
<?php @$db->db_close(); ?>