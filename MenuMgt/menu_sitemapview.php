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
			//d.src = "plus.gif";
		}else{
			c.style.display = '';
			d.src = "../images/minus.gif";
			//d.src = "minus.gif";
		}
}
</script>

<?php
function GenLen($data,$op){
	$s = explode($op,$data);
	return count($s);
}

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
				//echo "<img src=\"".$_SESSION["EWT_SUSER"]."/mainpic/arrow_r.gif\" border=\"0\" align=\"absmiddle\">";
				break;
		case '1':
				for($i=1;$i<count($s);$i++){
					?><img width="25" src="../images/o.gif" border="0" align="absmiddle" ><?php
				} 
				break;
		}
}

function chk_child($data){
    global $db;
    $sql_child="SELECT mp_id FROM menu_properties where mp_id  like '$data"."_%' and  mp_show='Y'  ";
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



<?php
sitemap_tree();

function sitemap_tree(){
    global $db;
    $sql="select * from menu_setting";
    $query = $db->query($sql);
    $data1 = $db->db_fetch_array($query);
	
	if($data1[menu_type]==0){ ?>
		<table width="90%"  border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
			<?php
			$query = $db->query("select * from menu_setting");
			$data = $db->db_fetch_array($query);
			$column=$data[menu_column];
					
			if($column==0)$column=1;
					
			$sql_menu = $db->query("SELECT m_id,m_name,m_realname,m_show  FROM  menu_list   where m_show='Y'  " );
			@$column_width=100/$column;
					
			$i=1;
			$j=1;
			while($M = $db->db_fetch_array($sql_menu)){
				if($i%$column==1 or $column==1){
								?><tr><td width="<?php echo $column_width?>%" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" ><?php
				}else{
								?><td  valign="top" width="<?php echo $column_width?>%"><table width="100%"  border="0" cellpadding="0" cellspacing="0" ><?php
				}
					
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
<?php }else{ ?>
		<table width="90%"  border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
		<?php
		$query = $db->query("select * from menu_setting");
		$data = $db->db_fetch_array($query);
		$column=$data[menu_column];
		if($column==0) $column=1;

		$sql_menu = $db->query("SELECT m_id,m_name,m_realname,m_show  FROM  menu_list   where m_show='Y'  " );
		@$column_width=100/$column;
		$i=1;   //  For  Site map Column
		$j=0;  // For Group of <DIV>
		while($M = $db->db_fetch_array($sql_menu)){
			if($i%$column==1 or $column==1){
				?><tr><td width="<?php echo $column_width?>%" valign="top"><?php
			}else{
				?><td  valign="top" width="<?php echo $column_width?>%"><?php
			}
			
			
				if($M["m_realname"]){
							   $nameMM=$M["m_realname"];
				}else{
							   $nameMM=$M["m_name"];
				 }
			
			if( check_root($M["m_id"],0) ==1 ){
					?><strong><font color="#0000FF"><?php echo $nameMM; ?></font></strong><br><?php
			}
										
			$sql_menu_sub = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$M["m_id"]."' and  mp_show='Y'   ORDER BY mp_id ");
			$k=0; // For  Close Group  is </DIV>
			while($R = $db->db_fetch_array($sql_menu_sub)){
				if($R["mp_realname"] ){
					 $nameMS=$R["mp_realname"];
				 }else{
					 $nameMS=$R["mp_name"];
				 } 
				$len = GenLen($R["mp_id"],"_");
									 
				if($len<>$keep_len and $len>2){ // $len>2 Because  we not check on the head menu
					echo "<div id=\"div$j\">";
					$j++;
					$k++;
				}
				if($keep_len>$len){
					for($loop=0;$loop<$k;$loop++){
						echo "</div>";
					}
					$k=$k-$loop;
				}
												 
				GenPic($R["mp_id"]) ;
				if(chk_child($R["mp_id"])>0){
					?><img  width="25" src="../images/minus.gif" border="0" align="absmiddle" onClick="divshow(document.all.div<?php echo $j; ?>,this)">&nbsp;<?php
				}else{
					?><img width="25" src="../images/o.gif" border="0" align="absmiddle">&nbsp;<?php
				}
				?><strong><a href="<?php echo $R["Glink"]?>" target="<?php $R["Gtarget"]?>"><?php echo $nameMS;?></a></strong><br><?php
				$keep_len=$len;
			}
			
			for($loop=0;$loop<$k;$loop++){
					echo "</div>";
			}
			$i++;
			if($i%$column==1){
				?></td ></tr><?php
			}else{
				?></td><?php
			}
		}
		?>
	</table>
<?php }// end if
}//end Function
?>


</form>
</body>
</html>
<?php

$db->db_close(); ?>
