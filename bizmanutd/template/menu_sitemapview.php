<?php
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

function GenPic($data){
$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		echo " &nbsp; &nbsp; &nbsp;";
	}
}


function check_root($dataMM,$dataMS){
		global $db;
        $pass=1;
		$query = $db->query("SELECT m_show  FROM  menu_list   where   m_id='$dataMM'  and  m_show='Y' ");
		$count = $db->db_fetch_row($query);
		
		if($count==0){
		   $pass=0;
		}
		if($dataMS<>0){
			$s = explode("_",$dataMS);
			$sch=$s[0].'_'.$s[1];
			 for($i=2;$i<count($s);$i++){
				   $query = $db->query("SELECT mp_show  FROM menu_properties WHERE mp_id = '$sch' and  mp_show='Y' ");
				   $count = $db->db_fetch_row($query);
				   if( $count == 0){
				        $pass=0;
						break;
				   }else{
				       $sch.='_'.$s[$i];
				   }
			 }
		}
		//echo $pass;
		return $pass;
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">

</head>
<body leftmargin="0" topmargin="0">

 <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
<?php
$sql_menu = $db->query("SELECT m_id,m_name,m_realname,m_show  FROM  menu_list   where m_show='Y'  " );
$i=0;
$j=0;
 while($M = $db->db_fetch_array($sql_menu)){
 if($M["m_show"]=='Y'){
    $checked= "checked";
 }else{
   $checked= "";
 }
 
 check_root($M["m_id"],$dataMS);
 if($M["m_realname"]){
   $nameMM=$M["m_realname"];
 }else{
   $nameMM=$M["m_name"];
 }
 
if( check_root($M["m_id"],0) ==1 ){
 ?> <tr> <td height="30" valign="middle" ><strong><font color="#0000FF"><?php echo $nameMM; ?></font></strong> </td></tr><?php
}
       $sql_menu_sub = $db->query("SELECT *  FROM menu_properties WHERE m_id = '".$M["m_id"]."' and  mp_show='Y'   ORDER BY mp_id ");
	   while($R = $db->db_fetch_array($sql_menu_sub)){
	    if($R["mp_show"]=='Y'){
			$checked2= "checked";
		 }else{
		   $checked2= "";
		 }
		 check_root($R["m_id"],$R["mp_id"]);
		  if($R["mp_realname"] ){
		   $nameMS=$R["mp_realname"];
		 }else{
		   $nameMS=$R["mp_name"];
		 }
	if( check_root($R["m_id"],$R["mp_id"]) ==1 ){
		   ?> <tr > <td  valign="middle" >
		        <?php GenPic($R["mp_id"]);?><a href="<?php echo $R["Glink"]?>" target="<?php $R["Gtarget"]?>"><?php echo $nameMS; ?></a></td></tr><?php
	}
			$j++;
		 }
		 $i++;
 } ?>
</table>  
</form>
</body>
</html>
<?php

$db->db_close(); ?>
