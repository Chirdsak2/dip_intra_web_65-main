<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
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
<form name="form1" method="post" action="menu_sitemap_function.php">



<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/sitemap_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_gensmap_function2;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>
    </td>
  </tr>
</table>
  
  <table width="94%"  border="0" cellpadding="5" cellspacing="1" bgcolor="#E8F1F8" align="center" class="ewttableuse">
     <tr class="ewttablehead"> 
            <td height="30" >
         &nbsp;&nbsp;<?php echo $text_gensmap_column1;?> </td>
            <td height="30" ><input  type="checkbox" onClick="select_all(this)"> <?php echo $text_gensmap_column2;?></td>
     </tr>
<?php
$sql_menu = $db->query("SELECT m_id,m_name,m_realname,m_show FROM menu_list where m_id ='".$_GET["mid"]."' ");
$i=0;
$j=0;
$bgcolor='#E6E6E6';
 while($M = $db->db_fetch_array($sql_menu)){
 //Find sitemap
 $sqlSMG = "select m_show,m_realname from menu_sitemap_list where s_id='".$_GET["sid"]."' and m_id ='".$_GET["mid"]."' ";
 $querySMg = $db->query($sqlSMG);
 $RG = $db->db_fetch_array($querySMg);
 if($RG["m_show"]=='Y'){
    $checked= "checked";
 }else{
   $checked= "";
 }
 if($bgcolor=='#E2E2E2'){
     $bgcolor='#EeEeEe';
 }else{
      $bgcolor='#E2E2E2';
 }

      $sql_menu_sub = $db->query("SELECT mp_id,m_id,mp_name,mp_realname,mp_show 
                                                                   FROM menu_properties WHERE m_id = '".$M["m_id"]."' ORDER BY mp_id ");
      $count_child=$db->db_num_rows($sql_menu_sub)-1;


$bgcolor='#FFFFFF';
 ?>
      <tr bgcolor="<?php echo $bgcolor ?>" >
	          <td height="30" valign="middle" ><strong><font color="#0000FF"><?php echo $M["m_name"]; ?></font></strong> </td>
			  <td><input type="checkbox" name="menuMain<?php echo $i; ?>"  value="<?php echo $M["m_id"]; ?>" <?php echo $checked;  echo $java_function ?> onClick="groupCHK(this,<?php echo $j?>,<?php echo $count_child;?>+1)">
			         <input type="hidden" name="menu2Main<?php echo $i; ?>" value="<?php echo $M["m_id"]; ?>"> 
					 <input type="text" name="inputMM<?php echo $i; ?>" value="<?php echo $RG["m_realname"];?>"></td>
	   </tr><?php


	   while($R = $db->db_fetch_array($sql_menu_sub)){
	    //Find sitemap
		 $sqlSML = "select m_show,m_realname from menu_sitemap_list where s_id='".$_GET["sid"]."' and mp_id ='".$R["mp_id"]."' ";
		 $querySMl = $db->query($sqlSML);
		 $RL = $db->db_fetch_array($querySMl);
	    if($RL["m_show"]=='Y'){
			$checked2= "checked";
		 }else{
		   $checked2= "";
		 }
		 
		  if($bgcolor=='#E2E2E2'){
			 $bgcolor='#EeEeEe';
		 }else{
			  $bgcolor='#E2E2E2';
		 }

       $sql_menu_sub2 = $db->query("SELECT mp_id  FROM menu_properties WHERE mp_id  like '".$R["mp_id"]."_%' ");
//echo  "SELECT mp_id  FROM menu_properties WHERE mp_id  like '".$R["mp_id"]."_' ";
       $count_child=$db->db_num_rows($sql_menu_sub2);

$bgcolor='#FFFFFF';
	   ?>
	         <tr bgcolor="<?php echo $bgcolor ?>"> 
			        <td  valign="middle" ><strong><?php GenPic($R["mp_id"]) ; echo $R["mp_name"]; ?></strong></td>
			       <td><input type="checkbox" name="menuSub<?php echo $j; ?>" value="<?php echo $R["mp_id"]; ?>" <?php echo $checked2; ?> onClick="groupCHK(this,<?php echo $j+1?>,<?php echo $count_child;?>)">
				           <input type="hidden" name="menu2Sub<?php echo $j; ?>" value="<?php echo $R["mp_id"]; ?>"> 
						   <input type="text" name="inputMS<?php echo $j; ?>" value="<?php echo $RL["m_realname"];?>"></td>
			</tr><?php
			$j++;
		 }
		 $i++;
		 
 } ?>
  <tr bgcolor="#E6E6E6"> 
			        <td  valign="middle" ></td>
			       <td>
				   <input type="hidden" name="alli" value="<?php echo $i; ?>">
				   <input type="hidden" name="allj" value="<?php echo $j; ?>">
				   <input type="hidden" name="sid" value="<?php echo $_GET["sid"]; ?>">
				   <input type="hidden" name="Flag" value="UpdateSitemap"><input type="submit" value="<?php echo $text_gensmap_formupdate;?>"> <input type="reset" value="<?php echo $text_gensmap_formreset;?>"> 
				                             <!--  <a href="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/menu_sitemapview.php" target="_blank">View</a>   -->  
                   </td>
			</tr>
</table>  
</form>
</body>
</html>
<?php

$db->db_close(); ?>
