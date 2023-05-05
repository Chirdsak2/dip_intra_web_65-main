<?php
include("lib/permission.php");
include("lib/include.php");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$IMG_PATH = 'EWT_ADMIN/';
$EWT_PATH = '';
$MAIN_PATH = 'EWT_ADMIN/';

 			$f1 = fopen("font_list.txt","r");
			  while($line1 = fgets($f1,1024)){
			  $fontL .= $line1; 
			  }
			  fclose($f1);
			 $FontA = explode("###",$fontL);  

$sql = "select * from site_info";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$db->query("USE ".$EWT_DB_USER);
$sql_user = "select url from user_info where UID = '".$_SESSION["EWT_SUID"]."'";
$query_user = $db->query($sql_user);
$rec_user = $db->db_fetch_array($query_user);
$db->query("USE ".$EWT_DB_NAME);
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>EasyWebTime 8.9</title>
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<script >
function selColor(c,d){
				Win2=window.open('ewt_color.php?c_value='+ c +'&c_block=' + d + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
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
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
 table {
	 font-size: 14px;
	 font-weight: 400;
 }  
 input {
	 
	 height:30px;
	 
 }
 
</style>
</head>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<!--<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<hr />    
</div>				
<div class="col-md-12 col-sm-12 col-xs-12" >
<img src="theme/main_theme/site_function_lang.gif" width="32" height="32" align="absmiddle" />
<span class="ewtfunction">&#3605;&#3633;&#3657;&#3591;&#3588;&#3656;&#3634;&#3605;&#3633;&#3623;&#3629;&#3633;&#3585;&#3625;&#3619;&#3607;&#3637;&#3656;&#3651;&#3594;&#3657;&#3651;&#3609;&#3648;&#3623;&#3655;บ&#3652;&#3595;&#3605;&#3660;</span>
</div>
<div class="col-md-12 col-sm-12 col-xs-12" >
 <hr />            
</div>
</div>-->
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">&#3605;&#3633;&#3657;&#3591;&#3588;&#3656;&#3634;&#3605;&#3633;&#3623;&#3629;&#3633;&#3585;&#3625;&#3619;&#3607;&#3637;&#3656;&#3651;&#3594;&#3657;&#3651;&#3609;&#3648;&#3623;&#3655;บ&#3652;&#3595;&#3605;&#3660;</h4>
</div>	


<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-10 col-sm-10 col-xs-12 form-inline" ></div>

<div class="col-md-2 col-sm-2 col-xs-12 float-right" style="text-align:right;" >
 
</div>	
</div>
</div>

<div class="clearfix">&nbsp;</div>	

<div class="col-md-12 col-sm-12 col-xs-12 ">	
<form action="ewt_info_function.php" method="post" name="form3" id="form3">
      <input name="hdd_site_info_id" type="hidden" value="<?php echo $rec[site_info_id]?>" />
      <input name="hdd_flag" type="hidden" value="interface_setting" />
      <table width="100%" align="center" class="table table-bordered">
        <tr bgcolor="#FFFFFF" style="display:none">
          <td width="30%" bgcolor="#F5F5F5">ภาษา </td>
          <td width="70%">
		  <select name="lang" class="form-control" style="width:30%" >
            <option value="" <?php if(''==$rec["site_language"]){ echo "selected"; } ?>>Thai</option>
            <option value="1" <?php if(1==$rec["site_language"]){ echo "selected"; } ?>>English</option>
          </select>          
		  </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="30%" bgcolor="#F5F5F5">ตัวอักษรทั่วไป</td>
          <td width="70%">
		  <div class="form-group">
			<label for="AMHeadF">Font Face :</label>
            <select name="AMHeadF" id="AMHeadF" class="form-control" style="width:30%"  >
                  <option value="">none </option>
                  <?php $i = 0;
		 while($FontA[$i]){ ?>
                  <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$rec["font_face"]){ echo "selected"; } ?>> <?php echo $FontA[$i]; ?> </option>
                  <?php $i++;
		 } ?>
               </select>
			</div>
            <br>
			<div class="form-group">
			<label for="AMBottomS" style="width:100%">Font size :</label>

            <select name="AMBottomS" class="form-control" style="width:30%" >
				  <option value="">none </option>
				  <?php for($m=8;$m<=36;$m++){?>
				  		<option value="<?php echo $m;?>" <?php if($rec["font_size"]==$m){ echo "selected"; } ?>><?php echo $m;?></option>
				  <?php } ?>
            </select>
			&nbsp;
            <select name="typefont" class="form-control" style="width:30%" >
              <option value="px" <?php if($rec["font_type"]=="px"){ echo "selected"; } ?>>px </option>
              <option value="pt" <?php if($rec["font_type"]=="pt"){ echo "selected"; } ?>>pt </option>
            </select>
			</div>
			
			
            <br>
		   <div class="form-group">
			<label for="AMHeadF">Font color :</label>
				
			<a id="CPreview3" style="background-color: <?php echo $rec[font_color]; ?>;" onClick="selColor('window.opener.document.form3.color_set.value','window.opener.document.all.CPreview3.style.backgroundColor');"><img src="images/box_color.gif" width="21" height="23" align="absbottom" /></a>
            <input name="color_set" type="text" style="width:30%" class="form-control"   id="color_set" value="<?php echo $rec[font_color]; ?>"  size="7" maxlength="7" />
           	</div>
		   <br>
			
			<div class="form-group">
			<label for="AMHeadF">Font style :</label>
				<div class="checkbox-inline">
				<label>
				<input name="c_b" type="checkbox" id="c_b" value="1" <?php if($rec["font_B"]=="1"){ echo "checked"; } ?> />B</label>
				</div>
				<div class="checkbox-inline">
				<label><input name="c_i" type="checkbox" id="c_i" value="1" <?php if($rec["font_i"]=="1"){ echo "checked"; } ?> />I</label>
				</div>
			</div>
			
			</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td bgcolor="#F5F5F5">ตัวอักษรที่เป็นหัวข้อ</td>
          <td>
		  <div class="form-group">
			<label for="AMHeadFH">Font Face :</label>
            <select name="AMHeadFH" id="AMHeadFH" class="form-control" style="width:30%" >
                  <option value="">none </option>
                  <?php $i = 0;
		 while($FontA[$i]){ ?>
                  <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$rec["font_faceH"]){ echo "selected"; } ?>> <?php echo $FontA[$i]; ?> </option>
                  <?php $i++;
		 } ?>
                </select>
			</div>
		   <br>	
		
		<div class="form-group">
			<label for="AMBottomSH" style="width:100%">Font size :</label>
			
            <select name="AMBottomSH" id="AMBottomSH" class="form-control" style="width:30%"  >
                              <option value="">none </option>
				<?php for($m=8;$m<=36;$m++){?>
				  		<option value="<?php echo $m;?>" <?php if($rec["font_sizeH"]==$m){ echo "selected"; } ?>><?php echo $m;?></option>
				<?php } ?>
            </select>
            &nbsp;
            <select name="typefontH" id="typefontH" class="form-control" style="width:30%">
              <option value="px" <?php if($rec["font_typeH"]=="px"){ echo "selected"; } ?>>px </option>
              <option value="pt" <?php if($rec["font_typeH"]=="pt"){ echo "selected"; } ?>>pt </option>
            </select>
            </div>
		   <br>	
		   
			<div class="form-group">
			<label for="AMHeadF">Font color :</label>
				 
			
			<a id="CPreview4" style="background-color: <?php echo $rec[font_colorH]; ?>;" onClick="selColor('window.opener.document.form3.color_setH.value','window.opener.document.all.CPreview4.style.backgroundColor');"><img src="images/box_color.gif" width="21" height="23" align="absbottom" /></a>
            
			<input name="color_setH" type="text" style="width:30%" class="form-control"  id="color_setH" value="<?php echo $rec[font_colorH]; ?>"  size="7" maxlength="7" />
            </div>
		   <br>
			
			
			<div class="form-group">
			<label for="AMHeadF">Font style :</label>
				<div class="checkbox-inline">
				<label>
				<input type="checkbox" name="c_bH"  id="c_bH" value="1" <?php if($rec["font_BH"]=="1"){ echo "checked"; } ?> />
				B
				</label>
				</div>
				<div class="checkbox-inline">
				<label>
				<input name="c_iH" type="checkbox" id="c_iH" value="1" <?php if($rec["font_iH"]=="1"){ echo "checked"; } ?> />
				I
				</label>
			  	</div>
			</div>
			  
			  </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td bgcolor="#F5F5F5">&nbsp;</td>
          <td>
		  <input type="submit" name="Submit" value="&nbsp;&nbsp;บันทึก&nbsp;&nbsp;" class="btn btn-success" />
                  <input type="reset" name="Submit2" value="&nbsp;&nbsp;ล้างข้อมูล&nbsp;&nbsp;" class="btn btn-warning" />
				
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
<?php
$db->db_close(); ?>
