<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");
//$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<form name="frm1" action="banner_process.php" method="post">

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
						$query_set = $db->query("SELECT * FROM banner_setting ");
                        $rs_set = $db->db_fetch_array($query_set);
?>
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse" >
    <tr  class="ewttablehead" > 
      <td colspan="2"> &nbsp; <?php echo $text_genbanner_formset;?></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td  width="12%" valign="top">&nbsp;<?php echo $text_genbanner_formline;?> </td>
      <td width="88%"><input type="radio"  name="banner_view" value="V" <?php if($rs_set[banner_view]=='V')echo 'checked';?>>
        <?php echo $text_genbanner_formline2;?><br> <input type="radio"  name="banner_view" value="H" <?php if($rs_set[banner_view]=='H')echo 'checked';?>>
        <?php echo $text_genbanner_formline3;?> 
        <input type="text" name="rand_max" size="5"  value=" <?php echo  $rs_set[banner_rand_max];?>">
        <?php echo $text_genbanner_formline4;?></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td  width="12%" valign="top">&nbsp;<?php echo $text_genbanner_formsize;?> </td>
      <td width="88%">&nbsp;
	  <?php echo $text_genbanner_formsize1;?> 
	  <input type="text" name="rand_width" size="5"  value=" <?php echo  ereg_replace('%','',$rs_set[banner_width]);?>">
	  <?php echo $text_genbanner_formsize3;?> X	  <?php echo $text_genbanner_formsize2;?> 
	  <input type="text" name="rand_height" size="5"  value=" <?php echo  ereg_replace('%','',$rs_set[banner_height]);?>">
	   <?php echo $text_genbanner_formsize3;?> 
	  </td></tr>
    <tr bgcolor="#FFFFFF"> 
      <td valign="top"><?php echo $text_genbanner_formtype;?> </td>
      <td><input type="radio"  name="banner_type" value="R" <?php if($rs_set[banner_type]=='R')echo 'checked';?>> <?php echo $text_genbanner_formtype2;?> 
        <input type="text" name="rand_row" size="5"  value=" <?php echo  $rs_set[banner_rand_row];?>"> <?php echo $text_genbanner_formtype3;?><br>
		<input type="radio"  name="banner_type" value="F" <?php if($rs_set[banner_type]=='F')echo 'checked';?>> <?php echo $text_genbanner_formtype4;?>
        <br><br>
		<?php
			$sql_banner = "SELECT * FROM banner order by banner_position,banner_id";
			$query_banner = $db->query($sql_banner);
			$num_banner = $db->db_num_rows($query_banner);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="5"  class="ewttableuse">
  <tr class="ewttablehead">
    <td align="center" width="70%">&nbsp; <?php echo $text_genbanner_column1;?></td>
    <td align="center" width="30%">&nbsp;<?php echo $text_genbanner_formsort;?></td>
  </tr>
  <?php while($rs_banner = $db->db_fetch_array($query_banner)) {?>
  <tr bgcolor="#FFFFFF">
    <td><div align="left">&nbsp;<input type="checkbox" name="show[]"  <?php if($rs_banner[banner_show] == "yes"){print "checked";}?> value="<?php echo $rs_banner[banner_id]?>"> 
	&nbsp;<?php echo $rs_banner[banner_name];?>&nbsp;
	<?php if(file_exists($Globals_Dir.$rs_banner[banner_pic]) and $rs_banner[banner_pic]!=''){?>
	  <img src="../FileMgt/phpThumb.php?src=<?php echo $Globals_Dir?><?php echo $rs_banner[banner_pic]; ?>&h=50&w=150">
  <?php }else{  echo "No image.";   }?>
   </div>
	</td>
    <td align="center">&nbsp;<input type="text" name="ban_pos[]"  size="5" value="<?php echo $rs_banner[banner_position]?>">
            <input type="hidden" name="ban_id[]"   value="<?php echo $rs_banner[banner_id]?>"></td>
  </tr>
  <?php } ?>
</table>

		
</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td>&nbsp;<input type="hidden" name="flag" value="tool"> <input type="Button" name="Submit" value="<?php echo $text_genbanner_formupdate;?>" onClick="if(document.frm1.rand_max.value==0 && document.frm1.banner_view[1].value=='H'){document.frm1.rand_max.value=1;} document.frm1.submit();"></td>
    </tr>
  </table>

  
  
</form>
</body>
</html>
<?php
$db->db_close(); ?>
