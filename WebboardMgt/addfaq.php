<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
include("../language.php");
if($_GET["fa_id"]){
$sql = $db->query("SELECT * FROM faq WHERE fa_id = '".$_GET["fa_id"]."'");
$R = mysql_fetch_array($sql);
$flag = 'editfaq';
$functionname =  $text_genfaq_faqedit;
}else{
$flag = 'addfaq';
$functionname = $text_genfaq_faqadd;
}

 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" class="normal_font">
 <?php include("../FavoritesMgt/favorites_include.php");?>
<form name="form1" method="post" action="faqfunction.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
<?php
$Execsql1 = $db->query("SELECT * FROM f_subcat WHERE  f_sub_id = '".$_GET["f_id"]."' ");
$R1 = mysql_fetch_array($Execsql1);
$sql_subcat="select * from f_subcat where f_sub_id='".$_GET[f_sub_id]."' order by  f_sub_no  "  ;
$query_subcat=$db->query($sql_subcat);
$R_SUB=$db->db_fetch_array($query_subcat);
?>
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><a href="faq_cate.php"><?php echo $text_genfaq_category;?>  : <?php echo biz($R1[f_cate]); ?></a> >> <a href="faq_sub.php?f_id=<?php echo $f_id;?>"><?php echo $text_genfaq_categorysub;?>  : <?php echo $R_SUB[f_subcate];?></a>>><?php echo $functionname;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genfaq_categorysub.">".$R_SUB[f_subcate].'>'.$functionname);?>&module=faq&url=<?php echo urlencode("addfaq.php?fa_id=".$_GET[fa_id]."&f_sub_id=".$_GET[f_sub_id]."&f_id=".$_GET[f_id]."");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="faq_sub.php?f_id=<?php echo $_GET["f_id"];?>&f_sub_id=<?php echo $_GET["f_sub_id"];?>"><img border="0" src="../theme/main_theme/g_back.gif" width="16" height="16" align="absmiddle"><?php echo $text_general_back;?></a>
      <hr> </td>
  </tr>
</table>
<table width="70%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> <?php echo $functionname;?></td>
  </tr>
  <?php if($_GET["fa_id"]){ ?>
    <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%"><?php echo $text_genfaq_classification;?></td>
    <td width="62%">
						   <?php 
						    $sql_faq = $db->query("SELECT * FROM f_subcat  WHERE f_parent='0'"); 
						    function child($id,$tag,$cur){
								  global  $db;
								  $sql = $db->query("SELECT * FROM f_subcat  WHERE f_parent='$id' "); 
								  while($F=mysql_fetch_array($sql)){
									  ?><option value="<?php echo $F[f_sub_id]; ?>" <?php if($F[f_sub_id]==$cur){echo 'selected';}?> ><?php echo $tag.$F[f_subcate]; ?></option><?php 
										$sql_faq = $db->query("SELECT * FROM f_subcat  WHERE f_parent='$F[f_sub_id]' "); 
										if($db->db_num_rows($sql_faq)>0){
										   child($F[f_sub_id],$tag.$tag,$cur);
										}
								  } 
							}
							?>
						   <select name="faqsub_id" id="faqsub_id">
								<?php while($F=mysql_fetch_array($sql_faq)){ ?>
								<option value="<?php echo $F[f_sub_id]; ?>" <?php if($F[f_sub_id]==$_GET["f_sub_id"]){echo 'selected';}?>><?php echo $F[f_subcate]; ?></option>
								<?php 
								
									$sql_faq2 = $db->query("SELECT * FROM f_subcat  WHERE f_parent='$F[f_sub_id]' "); 
									if($db->db_num_rows($sql_faq2)>0){
									   child($F[f_sub_id],'&nbsp;&nbsp;&nbsp;&nbsp;',$_GET["f_sub_id"]);
									}
								
								} ?>
                        </select></td>
  </tr>
 <?php } ?>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%"><?php echo $text_genfaq_item;?></td>
    <td width="62%"><textarea name="fname" cols="50" rows="3" wrap="VIRTUAL" id="fname"><?php echo eregi_replace("<br>","", $R[fa_name]); ?></textarea></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td><?php echo $text_genfaq_categorydetail;?></td>
    <td><textarea name="fdetail" cols="50" rows="4" wrap="VIRTUAL" id="fdetail"><?php echo eregi_replace("<br>","", $R[fa_detail]); ?></textarea></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td><?php echo $text_genfaq_answer;?></td>
    <td><textarea name="fans" cols="50" rows="5" wrap="VIRTUAL" id="fans"><?php echo eregi_replace("<br>","", $R[fa_ans]); ?></textarea> </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td><?php echo $text_general_status ;?></td>
    <td><input name="faq_use" type="radio" value="Y" <?php if($R[faq_use]=='Y'){ echo "checked";  } ?>>
                             <?php echo $text_general_enable;?>
                             <input name="faq_use" type="radio" value="N" <?php if($R[faq_use]=='N' || $R[faq_use]==''){ echo "checked";  } ?>>
                             <?php echo $text_general_disable;?> </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td><?php echo $text_general_interest;?></td>
    <td><input type="checkbox" name="faq_top" value="Y" <?php if($R[faq_top]=='Y'){ echo "checked";  } ?>></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="<?php echo $text_general_submit;?>">
      <input type="reset" name="Submit3" value="<?php echo $text_general_Reset;?>">
	   <input name="flag" type="hidden" id="flag" value="<?php echo $flag;?>">
                               <input name="f_id" type="hidden" id="f_id" value="<?php echo $_GET["f_id"]; ?>">
                               <input name="f_sub_id" type="hidden" id="f_sub_id" value="<?php echo $_GET["f_sub_id"]; ?>">
                               <input name="fa_id" type="hidden" id="fa_id" value="<?php echo $_GET["fa_id"]?>">
							   </td>
  </tr>
</table>
</form>
</body>
</html>
<script language="JavaScript">
function CHK(){
if(document.form1.a_detail.value == ""){
alert("<?php echo $text_genfaq_alertdetail_faq;?>");
document.form1.a_detail.focus();
return false;
}
if(document.form1.t_name.value == ""){
alert("<?php echo $text_genfaq_alertname_faq ;?>");
document.form1.t_name.focus();
return false;
}
}
</script>
<?php @$db->db_close(); ?>