<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>

<script language="JavaScript">
function divshow(c,d){
	if(c.style.display == ""){
	c.style.display = 'none';
	d.src = "../images/plus.gif";
	}else{
		c.style.display = '';
	d.src = "../images/minus.gif";
	}
}
function divshow1(c){
	if(c.style.display == ""){
	c.style.display = 'none';
	}else{
		c.style.display = '';
	}
}
</script>

<?php

function GenPic($data){
    global $db;
    $sql="select *from menu_setting";
    $query = $db->query($sql);
    $data1 = $db->db_fetch_array($query);
    $s = explode("_",$data);

	switch($data1[menu_type]){
		case '0':
				for($i=1;$i<count($s);$i++){
				echo"&nbsp; &nbsp; &nbsp;";
				} 
				echo "<img src=\"../ewt/".$_SESSION["EWT_SUSER"]."/mainpic/arrow_r.gif\" border=\"0\" align=\"absmiddle\">";
				break;
		case '1':
				for($i=1;$i<count($s);$i++){
					if($i==count($s)-1){
						if(chk_child($data)>0){
						  //echo"&nbsp;&nbsp;+";
						  ?><img src="../images/plus.gif" border="0" align="absmiddle" onClick="divshow(document.all.dv<?php echo $data; ?>,this)"><?php
					   }else{
						   echo"&nbsp; &nbsp; &nbsp;";
					   }
					}else{
						echo"&nbsp; &nbsp; &nbsp;";
					}
				} 
				break;
		}
}

function chk_child($data){
    global $db;
    $sql_child="SELECT mp_id FROM menu_properties where mp_id  like '$data"."_%' ";
    $sql_child = $db->query($sql_child);
	return $db->db_num_rows($sql_child);
}

function check_root($dataMM,$dataMS){
		global $db;
        $pass=1;
		$query = $db->query("SELECT m_show  FROM  menu_list   where   m_id='$dataMM'  and  m_show='Y' ");
		$count = $db->db_fetch_row($query);
		
		if($count==0){  $pass=0; }
		
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
		return $pass;
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

</head>
<body leftmargin="0" topmargin="0">

<table width="90%"  border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
<?php
$query = $db->query("select *from menu_setting");
$data = $db->db_fetch_array($query);
$column=$data[menu_column];

if($column==0)
$column=1;

$sql_menu = $db->query("SELECT m_id,m_name,m_realname,m_show  FROM  menu_list   where m_show='Y'  " );
@$column_width=100/$column;

$i=1;
$j=1;
while($M = $db->db_fetch_array($sql_menu)){
		if($i%$column==1 or $column==1){
			?><tr><td width="<?php echo $column_width?>%" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" ><?php
		}else{
			?><td  valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" ><?php
		}

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
		 ?> <tr> <td height="20" valign="middle" nowrap><strong><font color="#0000FF"><?php echo $nameMM; ?></font></strong> </td></tr><?php
		}
			   $sql_menu_sub = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$M["m_id"]."' and  mp_show='Y'   ORDER BY mp_id ");
			   while($R = $db->db_fetch_array($sql_menu_sub)){
				//if($R["mp_show"]=='Y'){ $checked2= "checked";  }else{ $checked2= "";  }
				 check_root($R["m_id"],$R["mp_id"]);
				  if($R["mp_realname"] ){
				     $nameMS=$R["mp_realname"];
				 }else{
				     $nameMS=$R["mp_name"];
				 }
			if( check_root($R["m_id"],$R["mp_id"]) ==1 ){
				   ?> <tr > <td  valign="middle" nowrap><strong><?php GenPic($R["mp_id"]) ;?> <a href="<?php echo $R["Glink"]?>" target="<?php $R["Gtarget"]?>"><?php echo $nameMS; ?></a></strong></td></tr><?php
			}
					$j++;
				 }
		
				 $i++;
		if($i%$column==1){
			?></td></tr></table><?php
		}else{
			?></table></td><?php
		}

 } ?>
</table>  
</form>
</body>
</html>
<?php

$db->db_close(); ?>
