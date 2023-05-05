<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/sitemap_language.php");
function GenPic($data){
$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		//echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
		echo " &nbsp; &nbsp; &nbsp;";
	}
}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>

			function groupCHK(c,sid,len_sub){
			      var i;
                 //alert(sid+'  --  '+len_sub);
				  if(c.checked==false && len_sub > 0){
						 for(i=sid;i<sid+len_sub;i++){//alert(i);
                                  document.getElementById('menuSub'+i).disabled=true;
						}
				 }else{
                       for(i=sid;i<sid+len_sub;i++){//alert(i);
                                  document.getElementById('menuSub'+i).disabled=false;
						}
                }
			}

			function select_all(c){
			      var i;
				  if(c.checked==true){
						 for(i=0;i<document.form1.alli.value;i++){
                                  document.getElementById('menuMain'+i).checked=true;
						}
                        for(i=0;i<document.form1.allj.value;i++){
                                  document.getElementById('menuSub'+i).checked=true;
						}
				 }else{
                       for(i=0;i<document.form1.alli.value;i++){
                                  document.getElementById('menuMain'+i).checked=false;
						}
                        for(i=0;i<document.form1.allj.value;i++){
                                  document.getElementById('menuSub'+i).checked=false;
						}
                }
			}


			function exit(){
				self.top.ewt_main.location.href = "menu_index.php";
			}
			function hlah(c){
				var d = document.form1.num.value;
				for(i=0;i<d;i++){
				if(i == c){
					document.getElementById('ah'+i).style.backgroundColor = "#E6E6E6";
				}else{
					document.getElementById('ah'+i).removeAttribute("style");
				}
				}
			}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">




<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_gensmap_function2;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">

<?php
if($_POST[savesetting]){
    $sql="select *from menu_setting";
    $query = $db->query($sql);
	$count=$db->db_num_rows($query);
    if($count>0){
      $db->query("update menu_setting set menu_column='$_POST[map_col]',menu_type='$_POST[map_style]' ");
   }else{
      $db->query("insert into menu_setting(menu_column,menu_type) values('$_POST[map_col]','$_POST[map_style]')");
  }
  $db->write_log("update","sitemap","แก้ไข sitemap");
  ?>
  <script language="javascript">
		        alert('<?php echo $text_gensmap_complete2;?>');
 </script>
 <?php
}

    $sql="select *from menu_setting";
    $query = $db->query($sql);
    $data = $db->db_fetch_array($query);
?>

<form name="siteForm"  method="post">

<table width="100%" cellspacing="1" cellpadding="5"   class="ewttableuse">
  <tr class="ewttablehead">
    <td colspan="2">&nbsp; <?php echo $text_gensmap_formset;?></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td width="26%">&nbsp; <?php echo $text_gensmap_formtype;?></td>
    <td width="74%"><select  name="map_style">
      <option value="0" >แบบมาตรฐาน</option>
      <option value="1" <?php if($data[menu_type]==1) echo 'selected'?>>แบบมีเครื่องหมายบวก</option>
    </select></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td>&nbsp; <?php echo $text_gensmap_formline;?></td>
    <td><input type="text"  name="map_col" size="5" value="<?php echo $data[menu_column]?>"> <?php echo $text_gensmap_formline2;?></td>
  </tr>
 
  <tr bgcolor="#FFFFFF" >
    <td>&nbsp;</td>
    <td><input type="submit" value="<?php echo $text_gensmap_formupdate;?>" name="savesetting"> <input name="button" type="button"  onClick="window.open('menu_sitemapview.php','','width=500 , height=400,resizable=1,scrollbars=1 ');" value="<?php echo $text_gensmap_formview;?>">
      <br>
      <br>
      * คลิกปุ่ม <b><u><?php echo $text_gensmap_formview;?></u></b> เพื่อดูตัวอย่างการแสดงผลของ Site Map ตามค่าที่คุณกำหนด</td>
  </tr>
</table>



</form>

</td>
  </tr>
</table>
</body>
</html>
<?php

$db->db_close(); ?>
