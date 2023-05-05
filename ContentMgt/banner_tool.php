<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");
if($_GET[banner_gid]==''){
?>
      <script language="JavaScript">
	  alert("กรุณาเลือกกลุ่ม Banner List ก่อน !!");
	  document.location.href='banner_main.php?B=<?php echo $_GET[B];?>';
     </script>
   <?php
}
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
 $bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
if($_POST[flag] == "tool"){	
$bcode = base64_decode($_POST["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
if($_POST["marquee_id"]!=''){
if($_POST["time_marquee"] == '' || $_POST["time_marquee"] =='0'){ $timemarq = '1';}else{$timemarq = $_POST["time_marquee"];}
$marquee = $_POST["marquee_id"].'#'.$timemarq;
}
	$sql_edit = "UPDATE banner SET banner_show='yes',banner_update=NOW() WHERE banner_gid = '".$_POST[banner_gid]."'   ";
	$db->query($sql_edit);
	/*for($i=0;$i<count($_POST[show]);$i++){
		$sql_edit = "UPDATE banner SET banner_show='yes',banner_update=NOW(),banner_position='".$_POST[ban_pos][$i]."'  WHERE banner_id = '".$_POST[show][$i]."' ";
		$db->query($sql_edit);
	}
	for($i=0;$i<count($_POST[ban_id]);$i++){
		$sql_edit = "UPDATE banner SET banner_position='".$_POST[ban_pos][$i]."'  WHERE banner_id = '".$_POST[ban_id][$i]."' ";
		$db->query($sql_edit);
	}
*/
	$width=trim($_POST[rand_width]);
	$height=trim($_POST[rand_height]);
	$sql_gbanner = $db->query("select banner_gid from banner_setting where BID = '".$BID."' ");
	
	if($db->db_num_rows($sql_gbanner)>0){
     $sql_edit = "UPDATE banner_setting SET 
	 							banner_gid = '".$_POST[banner_gid]."',
                               banner_type='".$_POST[banner_type]."',
                               banner_view='".$_POST[banner_view]."',
                               banner_rand_max='".$_POST[rand_max]."',
                               banner_rand_row='".$_POST[rand_row]."',
                               banner_width='$width',
                               banner_height='$height',
							   banner_show = '".implode(",",$_POST[show])."',
							   banner_marquee = '".$marquee."' where  BID = '".$BID."' ";
	 $db->query($sql_edit);
		 if($_POST[banner_type] == 'R'){
			 $show_id = array();
			 $sql = $db->query("select * from banner where banner_gid = '".$_POST[banner_gid]."'");
			while($rec = $db->db_fetch_array($sql )){
			array_push($show_id,$rec[banner_id]);
			}
			$db->query("UPDATE banner_setting SET banner_show = '".implode(",",$show_id)."' WHERE BID = '".$BID."' ");
		}
	$db->write_log("update","banner","ตั้งค่าการแสดงผล banner   ");
	}else{
	$sql_insert = "INSERT INTO banner_setting (banner_type,banner_view,banner_rand_max,banner_rand_row,banner_width,banner_height,banner_gid,BID,banner_show,banner_marquee)
							VALUES
							('".$_POST[banner_type]."','".$_POST[banner_view]."','".$_POST[rand_max]."','".$_POST[rand_row]."','$width','$height','".$_POST[banner_gid]."', '".$BID."','".implode(",",$_POST[show])."','".$marquee."' )";
                               
	 $db->query($sql_insert);
		  if($_POST[banner_type] == 'R'){
			 $show_id = array();
			 $sql = $db->query("select * from banner where banner_gid = '".$_POST[banner_gid]."'");
			while($rec = $db->db_fetch_array($sql )){
			array_push($show_id,$rec[banner_id]);
			}
			$db->query("UPDATE banner_setting SET banner_show = '".implode(",",$show_id)."' WHERE BID = '".$BID."' ");
		}
	$db->write_log("insert","banner","ตั้งค่าการแสดงผล banner   ");
	}

	?>
      <script language="JavaScript">
	  top.close();
     </script>
   <?php
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
	function hdd_show(obj){
	if(obj.value=='R' || obj.value=='A'){
	document.getElementById("tb_show").style.display ='none' ; 
	}else if(obj.value=='F' || obj.value=='P'){
	document.getElementById("tb_show").style.display ='' ; 
	}else if(obj.value=='J'){
	document.getElementById("tb_show").style.display ='' ; 
		if(document.getElementById("banner_view2").checked == true){
			document.getElementById("rand_max").value =document.frm1.num_rows.value; 
		}
	}
}
function chk(){
if((document.frm1.rand_max.value==0 || document.frm1.rand_max.value=='')&& document.frm1.banner_view[1].value=='H'){document.frm1.rand_max.value=1;} 
var used = 0;
	if(document.getElementById("banner_type2").checked==true){
		if(document.frm1.rand_width.value==' '){alert("กรุณาใส่ความกว้าง!!");return false;}
		if(document.frm1.rand_height.value==' '){alert("กรุณาใส่ความสุง!!");return false;}
	}
	if(document.getElementById("banner_type2").checked==true || document.getElementById("banner_type3").checked==true){
		for(var i=0;i<document.frm1.num_rows.value;i++){
			if(document.getElementById("show"+i).checked == true){
				used = 1;
			}
		}
		if(used == 0){
		alert("กรุณาเลือก banner ที่ต้องการ !!");return false;
		}
	}
	return true;
}
</script>
<script  language="javascript1.1" type="text/javascript">
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
</script>
</head>
<body leftmargin="0" topmargin="0">
<form name="frm1" action="" method="post"  onSubmit="return chk()">
 <input type="hidden" name="banner_gid"   value="<?php echo $_GET["banner_gid"];?>">
  <input type="hidden" name="B"   value="<?php echo $_GET["B"];?>">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/banner_function_setting.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_genbanner_function2;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="banner_add.php?flag=add" target="_self"><hr>
    </td>
  </tr>
</table>
  
  <?php
 
						$query_set = $db->query("SELECT * FROM banner_setting where banner_gid = '".$_GET["banner_gid"]."' and BID = '".$BID."'  ");
                        $rs_set = $db->db_fetch_array($query_set);
						if($rs_set[banner_type] == 'F' || $rs_set[banner_type] == 'J' || $rs_set[banner_type] == 'P'){
						$displaynone = '';
						}else{
						$displaynone = 'none';
						}
						
?>
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse" >
    <tr  class="ewttablehead" > 
      <td colspan="3"> &nbsp; <?php echo $text_genbanner_formset;?></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td  width="25%" valign="top">&nbsp;<?php echo $text_genbanner_formline;?> </td>
      <td colspan="2"><input  name="banner_view" id="banner_view1"  type="radio" value="V" checked <?php if($rs_set[banner_view]=='V')echo 'checked';?>>
        <?php echo $text_genbanner_formline2;?><br> 
        <input type="radio"  name="banner_view" id="banner_view2" value="H" <?php if($rs_set[banner_view]=='H')echo 'checked';?>>
        <?php echo $text_genbanner_formline3;?> 
        <input type="text" name="rand_max" id="rand_max" size="5"  value=" <?php echo  $rs_set[banner_rand_max];?>">
      <?php echo $text_genbanner_formline4;?></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td  width="25%" valign="top">&nbsp;<?php echo $text_genbanner_formsize;?> </td>
      <td colspan="2">&nbsp;
	  <?php echo $text_genbanner_formsize1;?> 
	  <input type="text" name="rand_width" size="5"  value="<?php echo  ereg_replace('%','',$rs_set[banner_width]);?>">
	  <?php echo $text_genbanner_formsize3;?> X	  <?php echo $text_genbanner_formsize2;?> 
	  <input type="text" name="rand_height" size="5"  value="<?php echo  ereg_replace('%','',$rs_set[banner_height]);?>">
      <?php echo $text_genbanner_formsize3;?>	  </td></tr>
    <tr bgcolor="#FFFFFF"> 
      <td valign="top"><?php echo $text_genbanner_formtype;?> </td>
      <td colspan="2">
        <input  name="banner_type" id="banner_type1" type="radio" value="R" checked <?php if($rs_set[banner_type]=='R')echo 'checked';?> onClick="hdd_show(this)">
        <?php echo $text_genbanner_formtype2;?> 
        <input type="text" name="rand_row" size="5"  value=" <?php if($rs_set[banner_rand_row] != ''){echo  $rs_set[banner_rand_row];}else{ echo "5";}?>"> <?php echo $text_genbanner_formtype3;?><br>
		<input  name="banner_type" id="banner_type2" type="radio" value="J"  <?php if($rs_set[banner_type]=='J')echo 'checked';?> onClick="hdd_show(this)"><?php echo $text_genbanner_formtype4;?> เล็กขยายใหญ่ <br>
		<input type="radio"  id="banner_type3"  onClick="hdd_show(this)" name="banner_type" value="F" <?php if($rs_set[banner_type]=='F')echo 'checked';?>> <?php echo $text_genbanner_formtype4;?><br>
		<input type="radio"  id="banner_type4"  onClick="hdd_show(this)" name="banner_type" value="P" <?php if($rs_set[banner_type]=='P')echo 'checked';?>> <?php echo $text_genbanner_formtype5;?><br>
		<input type="radio"  id="banner_type5"  onClick="hdd_show(this)" name="banner_type" value="A" <?php if($rs_set[banner_type]=='A')echo 'checked';?>> <?php echo $text_genbanner_formtype6;?>
        <br><br>
		<?php
			$banner_show  = array();
			$banner_show = explode(',',$rs_set[banner_show]);
			$sql_banner = "SELECT * FROM banner where banner_gid = '".$_GET["banner_gid"]."'order by banner_position,banner_id";
			$query_banner = $db->query($sql_banner);
			$num_banner = $db->db_num_rows($query_banner);
			
?>
<table width="100%" border="0" cellspacing="1" cellpadding="5"  class="ewttableuse" id="tb_show" style="display:<?php echo $displaynone;?>">
  <tr class="ewttablehead">
    <td align="center" width="70%">&nbsp; <?php echo $text_genbanner_column1;?></td>
    <td align="center" width="30%" style="display:none">&nbsp;<?php echo $text_genbanner_formsort;?></td>
  </tr>
  <?php $b=0;
  while($rs_banner = $db->db_fetch_array($query_banner)) {
  //check default
	  for($x=0;$x<count($banner_show);$x++){
			if($banner_show[$x]==$rs_banner[banner_id] ){
			
				$showbanner = "checked";
				break;
			}else if($banner_show[$x] == ''){
				if($rs_set[banner_show]==$rs_banner[banner_id] ){
				$showbanner = "checked";
				}
			}else{
				$showbanner = "";
			}
	  }
  	
 
  
  ?>
  <tr bgcolor="#FFFFFF">
    <td><div align="left">&nbsp;<input type="checkbox" name="show[]" id="show<?php echo $b;?>" <?php echo $showbanner;?> value="<?php echo $rs_banner[banner_id]?>">
	&nbsp;<?php echo $rs_banner[banner_name];?>&nbsp;
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
	  <img src="../FileMgt/phpThumb.php?src=<?php echo $Globals_Dir?><?php echo $rs_banner[banner_pic]; ?>&h=50&w=150">
  <?php
  		}
   }else{  echo "No image.";   }?>
   </div>	</td>
    <td align="center" style="display:none">&nbsp;<input type="text" name="ban_pos[]"  size="5" value="<?php echo $rs_banner[banner_position]?>">
            <input type="hidden" name="ban_id[]"   value="<?php echo $rs_banner[banner_id]?>"></td>
  </tr>
  <?php  $b++;} ?>
</table></td></tr>
    <tr bgcolor="#FFFFFF">
      <td colspan="3" valign="top"><STRONG>#ตั้งค่าเพิ่มเติม : การแสดงผลของการเลื่อนการแสดงผล(marquee) </STRONG></td>
    </tr>
	<?php
	$marq = explode('#',$rs_set[banner_marquee]);
	
	?>
    <tr bgcolor="#FFFFFF">
      <td valign="top">&nbsp;</td>
      <td width="34%" valign="top"><input name="marquee_id" type="radio" value="" <?php if($marq[0]==''){echo 'checked';}?> >
ไม่แสดงผล </td>
      <td width="41%" valign="top"><input name="marquee_id" type="radio" value="A" <?php if($marq[0]=='A'){echo 'checked';}?> >
เลื่อนแนวตั้ง(วิ่งขึ้น) </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td valign="top">&nbsp;</td>
      <td valign="top"><input name="marquee_id" type="radio" value="B" <?php if($marq[0]=='B'){echo 'checked';}?>>
เลื่อนแนวตั้ง(วิ่งลง) </td>
      <td valign="top"><input name="marquee_id" type="radio" value="C" <?php if($marq[0]=='C'){echo 'checked';}?>>
เลื่อนแนวนอน(วิ่งจากขวาไปซ้าย) </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td valign="top">&nbsp;</td>
      <td valign="top"><input name="marquee_id" type="radio" value="D" <?php if($marq[0]=='D'){echo 'checked';}?>>
เลื่อนแนวนอน(วิ่งจากซ้ายไปขวา)</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td colspan="3" valign="top"><STRONG>#ตั้งค่าเพิ่มเติม : ความเร็วของการเลื่อนการแสดงผล(marquee) </STRONG></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td valign="top">&nbsp;</td>
      <td colspan="2" valign="top">ความเร็ว :
        <input onKeyUp="chkformatnum(this)" size="7" name="time_marquee" value="<?php echo $marq[1];?>">
(กรุณาระบุตัวเลขตั้งแต่ 1 ขึ้นไป)</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;<input type="hidden" name="flag" value="tool"> <input type="submit" name="Submit" value="<?php echo $text_genbanner_formupdate;?>" >
      <input type="hidden" name="num_rows" value="<?php echo $num_banner;?>"></td>
    </tr>
  </table>

  
  
</form>
</body>
</html>
<?php
$db->db_close(); ?>
