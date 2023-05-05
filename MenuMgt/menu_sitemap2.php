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
<form name="form1" method="post" action="menu_function.php">
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#333333">
  <tr> 
    <td height="30" background="../images/m_bg.gif" bgcolor="E8F1F8">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td>&nbsp;&nbsp;<strong><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> 
              Sitemap</strong>&nbsp;</td>
          </tr>
        </table>
		</td>
  </tr>
  </table>
  
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" bgcolor="#E8F1F8">
<?php
$sql_menu = $db->query("SELECT m_id,m_name,m_realname,m_show FROM menu_list ");
$i=0;
$j=0;
$bgcolor='#E6E6E6';
 while($M = $db->db_fetch_array($sql_menu)){
 if($M["m_show"]=='Y'){
    $checked= "checked";
 }else{
   $checked= "";
 }
 if($bgcolor=='#E2E2E2'){
     $bgcolor='#EeEeEe';
 }else{
      $bgcolor='#E2E2E2';
 }
 ?>
      <tr bgcolor="<?php echo $bgcolor ?>" >
	          <td height="30" valign="middle" ><strong><font color="#0000FF"><?php echo $M["m_name"]; ?></font></strong> </td>
			  <td><input type="checkbox" name="menuMain<?php echo $i; ?>"  value="<?php echo $M["m_id"]; ?>" <?php echo $checked; ?>>
			         <input type="hidden" name="menu2Main<?php echo $i; ?>" value="<?php echo $M["m_id"]; ?>"> 
					 <input type="text" name="inputMM<?php echo $i; ?>" value="<?php echo $M["m_realname"];?>"></td>
	   </tr><?php
       $sql_menu_sub = $db->query("SELECT mp_id,m_id,mp_name,mp_realname,mp_show 
                                                                   FROM menu_properties WHERE m_id = '".$M["m_id"]."' ORDER BY mp_id ");
	   while($R = $db->db_fetch_array($sql_menu_sub)){
	    if($R["mp_show"]=='Y'){
			$checked2= "checked";
		 }else{
		   $checked2= "";
		 }
		 
		  if($bgcolor=='#E2E2E2'){
			 $bgcolor='#EeEeEe';
		 }else{
			  $bgcolor='#E2E2E2';
		 }
	   ?>
	         <tr bgcolor="<?php echo $bgcolor ?>"> 
			        <td  valign="middle" ><strong><?php GenPic($R["mp_id"]) ; echo $R["mp_name"]; ?></strong></td>
			       <td><input type="checkbox" name="menuSub<?php echo $j; ?>" value="<?php echo $R["mp_id"]; ?>" <?php echo $checked2; ?>>
				           <input type="hidden" name="menu2Sub<?php echo $j; ?>" value="<?php echo $R["mp_id"]; ?>"> 
						   <input type="text" name="inputMS<?php echo $j; ?>" value="<?php echo $R["mp_realname"];?>"></td>
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
				   <input type="hidden" name="Flag" value="UpdateSitemap"><input type="submit" value="Save"> 
				                             <!--  <a href="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/menu_sitemapview.php" target="_blank">View</a>   -->  </td>
			</tr>
</table>  
</form>
</body>
</html>
<?php

$db->db_close(); ?>
