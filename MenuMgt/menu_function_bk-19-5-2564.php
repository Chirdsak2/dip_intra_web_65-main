<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/sitemap_language.php");

function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}

$m_name = stripslashes(htmlspecialchars($_REQUEST["m_name"],ENT_QUOTES));
$m_name = eregi_replace(" ","&nbsp;",$m_name);
$m_name = eregi_replace("&lt;br&gt;","<br>",$m_name);

if($_POST["Flag"] == "Add"){

$sql_check = $db->query("SELECT block_name FROM block WHERE block_name = '".$_POST["menu_name"]."'");
	if($db->db_num_rows($sql_check) > 0){
		?>
			<script language="javascript">
				alert("\"<?php echo $_POST["menu_name"]; ?>\" is already exist in WebBlock database!!!!");
				self.location.href = "menu_index.php";
			</script>
		<?php
			exit;
	}
	$sql_check = $db->query("SELECT m_name FROM menu_list WHERE m_name = '".$_POST["menu_name"]."'");
	if($db->db_num_rows($sql_check) > 0){
		?>
			<script language="javascript">
				alert("\"<?php echo $_POST["menu_name"]; ?>\" is already exist!!!!");
				self.location.href = "menu_index.php";
			</script>
		<?php
			exit;
	}

		$sql_d=$db->query("select glo_align,glo_showsub,glo_highlight,glo_delay_hor,glo_delay_ver,glo_delay_hide,pop_display,pop_bgcolor,pop_spacing,pop_padding,pop_trans,pop_bgimage,pop_borcolor,pop_borwidth,pop_borstyle from menu_default");
		$R_d=$db->db_fetch_array($sql_d);
		$db->query("INSERT INTO menu_list (m_name,glo_align,glo_showsub,glo_highlight,glo_delay_hor,glo_delay_ver,glo_delay_hide,pop_display,pop_bgcolor,pop_spacing,pop_padding,pop_trans,pop_bgimage,pop_borcolor,pop_borwidth,pop_borstyle) VALUES('".$_POST["menu_name"]."','$R_d[glo_align]','$R_d[glo_showsub]','$R_d[glo_highlight]','$R_d[glo_delay_hor]','$R_d[glo_delay_ver]','$R_d[glo_delay_hide]','$R_d[pop_display]','$R_d[pop_bgcolor]','$R_d[pop_spacing]','$R_d[pop_padding]','$R_d[pop_trans]','$R_d[pop_bgimage]','$R_d[pop_borcolor]','$R_d[pop_borwidth]','$R_d[pop_borstyle]')");
		$db->write_log("create","menu","สร้าง menu   ".$_POST["menu_name"]);
		$sql_max = $db->query("SELECT MAX(m_id) AS MID FROM menu_list WHERE m_name = '".$_POST["menu_name"]."' ");
		$M = $db->db_fetch_row($sql_max);

				?>
			<script language="javascript">
				self.location.href = "menu_main.php?m_id=<?php echo sprintf("%04d",$M[0]); ?>";
			</script>
		<?php
}
if($_POST["Flag"] == "AddSub"){

	$exec = $db->query("SELECT mp_id FROM menu_properties WHERE m_id = '".$_POST["m_id"]."' ORDER BY mp_id DESC");
		if($row = $db->db_num_rows($exec)){
			$R = $db->db_fetch_array($exec);
			$m = explode("_",$R[mp_id]);
			$Nmenu = $m[1]+1;
			$gen_menu = sprintf("%04d",$_POST["m_id"])."_".sprintf("%04d",$Nmenu);
			$properties_point="equal";
		}else{
			$gen_menu = sprintf("%04d",$_POST["m_id"])."_0001";
			$properties_point="default";
		}
			if($properties_point=="equal"){
				$sql_p=$db->query("SELECT * FROM menu_properties WHERE m_id = '".$_POST["m_id"]."'");
				$get_d= $db->db_fetch_array($sql_p);
						$get_g[pop_display]=$get_d[PopDisplay];
						$get_g[pop_trans]=$get_d[PopTrans];
						$get_g[pop_padding]=$get_d[PopPad];
						$get_g[pop_spacing]=$get_d[PopSpac];
						$get_g[pop_bgcolor]=$get_d[Popbgcolor];
						$get_g[pop_bgimgage]=$get_d[Popbgpic];
						$get_g[pop_borwidth]=$get_d[PopBorderW];
						$get_g[pop_borcolor]=$get_d[Popbordercolor];
						$get_g[pop_borstyle]=$get_d[Popborderstyle];
			} else if($properties_point=="default") {
				$sql_d = $db->query("SELECT * FROM menu_default");// get style DEFAULT (get เฉพาะตอน ADD อันแรก)
				$get_d = $db->db_fetch_array($sql_d); 
				$sql_g = $db->query("SELECT pop_display,pop_trans,pop_spacing,pop_padding,pop_bgcolor,pop_bgimage,pop_borcolor,pop_borwidth,pop_borstyle FROM menu_list");// get style GLOBAL
				$get_g = $db->db_fetch_array($sql_g);
			}
				$sql = $db->query("INSERT INTO menu_properties (mp_id,m_id,mp_name,Oufont,Ousize,Ousizepr, Oucolor, Oubold,Ouitalic,Oubgcolor,Outrans,Oubgpic,Oubordercolor,Ouborderw,Ouborderstyle,Gicon,Giconw,Giconh,Giconb,Garrow,Garroww,Garrowh,Garrowb,Ovfont,Ovsize,Ovsizepr,Ovcolor,Ovbold,Ovitalic,Ovbgcolor,Ovtrans,Ovbgpic,Ovbordercolor,PopDisplay,PopTrans,PopSpac,PopPad,Popbgcolor,Popbgpic,PopBorderW,Popbordercolor,Popborderstyle,Popshadowstyle,Popshadowsize,Popshadowcolor,PopDirect,PopX,PopY,PopEffectShow,PopEffectHide,PopEffectSpeed) VALUES('$gen_menu','".sprintf("%04d",$_POST["m_id"])."','$m_name','$get_d[Oufont]','$get_d[Ousize]','$get_d[Ousizepr]','$get_d[Oucolor]','$get_d[Oubold]','$get_d[Ouitalic]','$get_d[Oubgcolor]','$get_d[Outrans]','$get_d[Oubgpic]','$get_d[Oubordercolor]','$get_d[Ouborderw]','$get_d[Ouborderstyle]','$get_d[Gicon]','$get_d[Giconw]','$get_d[Giconh]','$get_d[Giconb]','$get_d[Garrow]','$get_d[Garroww]','$get_d[Garrowh]','$get_d[Garrowb]','$get_d[Ovfont]','$get_d[Ovsize]','$get_d[Ovsizepr]','$get_d[Ovcolor]','$get_d[Ovbold]','$get_d[Ovitalic]','$get_d[Ovbgcolor]','$get_d[Ovtrans]','$get_d[Ovbgpic]','$get_d[Ovbordercolor]','$get_g[pop_display]','$get_g[pop_trans]','$get_g[pop_spacing]','$get_g[pop_padding]','$get_g[pop_bgcolor]','$get_g[pop_bgimage]','$get_g[pop_borwidth]','$get_g[pop_borcolor]','$get_g[pop_borstyle]','$get_d[Popshadowstyle]','$get_d[Popshadowsize]','$get_d[Popshadowcolor]','$get_d[PopDirect]','$get_d[PopX]','$get_d[PopY]','$get_d[PopEffectShow]','$get_d[PopEffectHide]','$get_d[PopEffectSpeed]')");
				$db->write_log("create","menu","สร้าง submenu   ".$m_name);
		//$sql_max = $db->query("SELECT MAX(m_id) AS MID FROM menu_list WHERE m_name = '".$_POST["menu_name"]."' ");
		//$M = $db->db_fetch_row($sql_max);
		$_SESSION["EWT_MENU_POSITION"] = $gen_menu;
				?>
			<script language="javascript">
				self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
				self.location.href = "menu_detail.php?mp_id=<?php echo $gen_menu; ?>";
			</script>
		<?php
				exit;
}
if($_POST["Flag"] == "ADDY"){
$exec = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$_POST["m_id"]."' AND mp_id LIKE '".$_POST["mp_id"]."_%' ORDER BY mp_id DESC");

if($row = $db->db_num_rows($exec)){
$R = $db->db_fetch_array($exec);
	$m = explode("_",$R[mp_id]);
$len = GenLen($_POST["mp_id"],"_");
$Nmenu = $m[$len]+1;
$gen_menu = $_POST["mp_id"]."_".sprintf("%04d",$Nmenu);
$properties_point=$R[mp_id];

//equal
}else{
$gen_menu = $_POST["mp_id"]."_0001";
$properties_point=$_POST["mp_id"];//parent
}

$sql_p=$db->query("SELECT * FROM menu_properties WHERE m_id = '".$_POST["m_id"]."' AND mp_id = '$properties_point'");
if($row = $db->db_num_rows($sql_p)){
	$get_p = $db->db_fetch_array($sql_p);
} else {
	$sql_d = $db->query("SELECT * FROM menu_default");
	$get_p = $db->db_fetch_array($sql_d);
}

$sql = $db->query("INSERT INTO menu_properties (mp_id,m_id,mp_name,Oufont,Ousize,Ousizepr, Oucolor, Oubold,Ouitalic,Oubgcolor,Outrans,Oubgpic,Oubordercolor,Ouborderw,Ouborderstyle,Gicon,Giconw,Giconh,Giconb,Garrow,Garroww,Garrowh,Garrowb,Ovfont,Ovsize,Ovsizepr,Ovcolor,Ovbold,Ovitalic,Ovbgcolor,Ovtrans,Ovbgpic,Ovbordercolor,PopDisplay,PopTrans,PopSpac,PopPad,Popbgcolor,Popbgpic,PopBorderW,Popbordercolor,Popborderstyle,Popshadowstyle,Popshadowsize,Popshadowcolor,PopDirect,PopX,PopY,PopEffectShow,PopEffectHide,PopEffectSpeed)
VALUES('$gen_menu','".$_POST["m_id"]."','$m_name','$get_p[Oufont]','$get_p[Ousize]','$get_p[Ousizepr]','$get_p[Oucolor]','$get_p[Oubold]','$get_p[Ouitalic]','$get_p[Oubgcolor]','$get_p[Outrans]','$get_p[Oubgpic]','$get_p[Oubordercolor]','$get_p[Ouborderw]','$get_p[Ouborderstyle]','$get_p[Gicon]','$get_p[Giconw]','$get_p[Giconh]','$get_p[Giconb]','$get_p[Garrow]','$get_p[Garroww]','$get_p[Garrowh]','$get_p[Garrowb]','$get_p[Ovfont]','$get_p[Ovsize]','$get_p[Ovsizepr]','$get_p[Ovcolor]','$get_p[Ovbold]','$get_p[Ovitalic]','$get_p[Ovbgcolor]','$get_p[Ovtrans]','$get_p[Ovbgpic]','$get_p[Ovbordercolor]','$get_p[PopDisplay]','$get_p[PopTrans]','$get_p[PopSpac]','$get_p[PopPad]','$get_p[Popbgcolor]','$get_p[Popbgpic]','$get_p[PopBorderW]','$get_p[Popbordercolor]','$get_p[Popborderstyle]','$get_p[Popshadowstyle]','$get_p[Popshadowsize]','$get_p[Popshadowcolor]','$get_p[PopDirect]','$get_p[PopX]','$get_p[PopY]','$get_p[PopEffectShow]','$get_p[PopEffectHide]','$get_p[PopEffectSpeed]')");

$_SESSION["EWT_MENU_POSITION"] = $gen_menu;
$db->write_log("create","menu","สร้าง submenu   ".$_POST["m_name"]);
?>
<script language="JavaScript">
				self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
				self.location.href = "menu_detail.php?mp_id=<?php echo $gen_menu; ?>";
</script>
<?php
}
if($_POST["Flag"] == "BEFORE"){
	$len = GenLen($_POST["mp_id"],"_");
	$len--;
	$numr = strlen($_POST["mp_id"]);
	$rest = substr($_POST["mp_id"], 0, -4);

	if($EWT_DB_TYPE == "MYSQL"){
	$sql = $db->query("SELECT mp_id FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id >= '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND length(mp_id) >= '$numr' ORDER BY mp_id DESC");
	}elseif($EWT_DB_TYPE == "MSSQL"){
	$sql = $db->query("SELECT mp_id FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id >= '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND len(mp_id) >= '$numr' ORDER BY mp_id DESC");	
	}

	while($R = $db->db_fetch_array($sql)){
	$data = explode("_",$R[mp_id]);
	$num_array = count($data);
	$field_change = $data[$len]+1;
	$field_change = sprintf("%04d",$field_change);
	$total = "";
	for($i=0;$i<$num_array;$i++){
		if($i == $len ){
		$total .= $field_change."_";
		}else{
		$total .= $data[$i]."_";
		}
	 }
	 $total = substr($total, 0, -1);
	$sel = "UPDATE menu_properties SET mp_id = '$total' WHERE mp_id = '$R[mp_id]' AND m_id = '".$_POST["m_id"]."' ";
	$db->query($sel);
	}// end while

	if($EWT_DB_TYPE == "MYSQL"){
		$sql_g = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id >= '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND length(mp_id) >= '$numr' ORDER BY mp_id ASC");
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql_g = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id >= '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND len(mp_id) >= '$numr' ORDER BY mp_id ASC");
	}

if($db->db_num_rows($sql_g) > 0){

$get_p =$db->db_fetch_array($sql_g);

}else{

	$sql_d = $db->query("SELECT * FROM menu_default");
	$get_p = $db->db_fetch_array($sql_d);

}

$db->query("INSERT INTO menu_properties (mp_id,m_id,mp_name,Oufont,Ousize,Ousizepr, Oucolor, Oubold,Ouitalic,Oubgcolor,Outrans,Oubgpic,Oubordercolor,Ouborderw,Ouborderstyle,Gicon,Giconw,Giconh,Giconb,Garrow,Garroww,Garrowh,Garrowb,Ovfont,Ovsize,Ovsizepr,Ovcolor,Ovbold,Ovitalic,Ovbgcolor,Ovtrans,Ovbgpic,Ovbordercolor,PopDisplay,PopTrans,PopSpac,PopPad,Popbgcolor,Popbgpic,PopBorderW,Popbordercolor,Popborderstyle,Popshadowstyle,Popshadowsize,Popshadowcolor,PopDirect,PopX,PopY,PopEffectShow,PopEffectHide,PopEffectSpeed) VALUES('".$_POST["mp_id"]."','".$_POST["m_id"]."','$m_name','$get_p[Oufont]','$get_p[Ousize]','$get_p[Ousizepr]','$get_p[Oucolor]','$get_p[Oubold]','$get_p[Ouitalic]','$get_p[Oubgcolor]','$get_p[Outrans]','$get_p[Oubgpic]','$get_p[Oubordercolor]','$get_p[Ouborderw]','$get_p[Ouborderstyle]','$get_p[Gicon]','$get_p[Giconw]','$get_p[Giconh]','$get_p[Giconb]','$get_p[Garrow]','$get_p[Garroww]','$get_p[Garrowh]','$get_p[Garrowb]','$get_p[Ovfont]','$get_p[Ovsize]','$get_p[Ovsizepr]','$get_p[Ovcolor]','$get_p[Ovbold]','$get_p[Ovitalic]','$get_p[Ovbgcolor]','$get_p[Ovtrans]','$get_p[Ovbgpic]','$get_p[Ovbordercolor]','$get_p[PopDisplay]','$get_p[PopTrans]','$get_p[PopSpac]','$get_p[PopPad]','$get_p[Popbgcolor]','$get_p[Popbgpic]','$get_p[PopBorderW]','$get_p[Popbordercolor]','$get_p[Popborderstyle]','$get_p[Popshadowstyle]','$get_p[Popshadowsize]','$get_p[Popshadowcolor]','$get_p[PopDirect]','$get_p[PopX]','$get_p[PopY]','$get_p[PopEffectShow]','$get_p[PopEffectHide]','$get_p[PopEffectSpeed]')");

$_SESSION["EWT_MENU_POSITION"] = $_POST["mp_id"];;
$db->write_log("create","menu","สร้าง submenu   ".$_POST["m_name"]);
?>
<script language="JavaScript">
				self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
				self.location.href = "menu_detail.php?mp_id=<?php echo $_POST["mp_id"]; ?>";
</script>
<?php
}
if($_POST["Flag"] == "AFTER"){

$len = GenLen($_POST["mp_id"],"_");
$len--;
$numr = strlen($_POST["mp_id"]);
$rest = substr($_POST["mp_id"], 0, -4);

	if($EWT_DB_TYPE == "MYSQL"){
		$sql = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id > '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND length(mp_id) >= '$numr' ORDER BY mp_id DESC");
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id > '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND len(mp_id) >= '$numr' ORDER BY mp_id DESC");
	}

	while($R = $db->db_fetch_array($sql)){
		$sqlR = $db->query("SELECT mp_id FROM menu_properties WHERE mp_id LIKE '".$_POST["mp_id"]."%' AND mp_id = '$R[mp_id]' AND m_id = '".$_POST["m_id"]."' ");
			if(!$tttt = $db->db_num_rows($sqlR)){
				$data = explode("_",$R[mp_id]);
				$num_array = count($data);
				$field_change = $data[$len]+1;
				$field_change = sprintf("%04d",$field_change);
				$total = "";
						for($i=0;$i<$num_array;$i++){
							if($i == $len ){
								$total .= $field_change."_";
							}else{
								$total .= $data[$i]."_";
							}
						 }
				$total = substr($total, 0, -1);
			$sel = "UPDATE menu_properties SET mp_id = '$total' WHERE mp_id = '$R[mp_id]' AND m_id = '".$_POST["m_id"]."' ";
			$db->query($sel);
		}
	}

$m = explode($rest,$_POST["mp_id"]);
$Nmenu = $m[1]+1;
$gen_menu = $rest.sprintf("%04d",$Nmenu);

$properties_point=$R[mp_id];//equal
	$sql_p=$db->query("SELECT * FROM menu_properties WHERE m_id = '".$_POST["m_id"]."' AND mp_id = '$properties_point'");
		if($row = $db->db_num_rows($sql_p)){
			$get_p = $db->db_fetch_array($sql_p);
		} else if($sql_pa=$db->query("SELECT * FROM menu_properties WHERE m_id = '".$_POST["m_id"]."' AND mp_id = '".$_POST["mp_id"]."'")){//parent
			$get_p = $db->db_fetch_array($sql_pa);
		} else {
			$sql_d = $db->query("SELECT * FROM menu_default");
			$get_p = $db->db_fetch_array($sql_d);
		}

$db->query("INSERT INTO menu_properties (mp_id,m_id,mp_name,Oufont,Ousize,Ousizepr, Oucolor, Oubold,Ouitalic,Oubgcolor,Outrans,Oubgpic,Oubordercolor,Ouborderw,Ouborderstyle,Gicon,Giconw,Giconh,Giconb,Garrow,Garroww,Garrowh,Garrowb,Ovfont,Ovsize,Ovsizepr,Ovcolor,Ovbold,Ovitalic,Ovbgcolor,Ovtrans,Ovbgpic,Ovbordercolor,PopDisplay,PopTrans,PopSpac,PopPad,Popbgcolor,Popbgpic,PopBorderW,Popbordercolor,Popborderstyle,Popshadowstyle,Popshadowsize,Popshadowcolor,PopDirect,PopX,PopY,PopEffectShow,PopEffectHide,PopEffectSpeed)
VALUES('$gen_menu','".$_POST["m_id"]."','$m_name','$get_p[Oufont]','$get_p[Ousize]','$get_p[Ousizepr]','$get_p[Oucolor]','$get_p[Oubold]','$get_p[Ouitalic]','$get_p[Oubgcolor]','$get_p[Outrans]','$get_p[Oubgpic]','$get_p[Oubordercolor]','$get_p[Ouborderw]','$get_p[Ouborderstyle]','$get_p[Gicon]','$get_p[Giconw]','$get_p[Giconh]','$get_p[Giconb]','$get_p[Garrow]','$get_p[Garroww]','$get_p[Garrowh]','$get_p[Garrowb]','$get_p[Ovfont]','$get_p[Ovsize]','$get_p[Ovsizepr]','$get_p[Ovcolor]','$get_p[Ovbold]','$get_p[Ovitalic]','$get_p[Ovbgcolor]','$get_p[Ovtrans]','$get_p[Ovbgpic]','$get_p[Ovbordercolor]','$get_p[PopDisplay]','$get_p[PopTrans]','$get_p[PopSpac]','$get_p[PopPad]','$get_p[Popbgcolor]','$get_p[Popbgpic]','$get_p[PopBorderW]','$get_p[Popbordercolor]','$get_p[Popborderstyle]','$get_p[Popshadowstyle]','$get_p[Popshadowsize]','$get_p[Popshadowcolor]','$get_p[PopDirect]','$get_p[PopX]','$get_p[PopY]','$get_p[PopEffectShow]','$get_p[PopEffectHide]','$get_p[PopEffectSpeed]')");
$_SESSION["EWT_MENU_POSITION"] = $gen_menu;
$db->write_log("create","menu","สร้าง submenu   ".$_POST["m_name"]);
?>
<script language="JavaScript">
				self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
				self.location.href = "menu_detail.php?mp_id=<?php echo $gen_menu; ?>";
</script>
<?php
}
if($_POST["Flag"] == "DELMENU"){
$db->query("DELETE FROM menu_properties WHERE mp_id LIKE '".$_POST["mp_id"]."%' AND m_id = '".$_POST["m_id"]."'");
$len = GenLen($_POST["mp_id"],"_");
$len--;
$numr = strlen($_POST["mp_id"]);
$rest = substr($_POST["mp_id"], 0, -4);

	if($EWT_DB_TYPE == "MYSQL"){
		$sql = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id > '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND length(mp_id) >= '$numr' ORDER BY mp_id ASC");
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id > '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND len(mp_id) >= '$numr' ORDER BY mp_id ASC");
	}

while($R = $db->db_fetch_array($sql)){
$data = explode("_",$R[mp_id]);
$num_array = count($data);
$field_change = $data[$len]-1;
$field_change = sprintf("%04d",$field_change);
$total = "";
for($i=0;$i<$num_array;$i++){
if($i == $len ){
$total .= $field_change."_";
}else{
$total .= $data[$i]."_";
}
 }
 $total = substr($total, 0, -1);
$sel = "UPDATE menu_properties SET mp_id = '$total' WHERE mp_id = '$R[mp_id]' AND m_id = '".$_POST["m_id"]."' ";
$db->query($sel);
}
$_SESSION["EWT_MENU_POSITION"] = "";
$db->write_log("delete","menu","ลบ submenu   ".$_POST["m_name"]);
?>
<script language="JavaScript">
		self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
		self.location.href = "menu_properties.php?m_id=<?php echo sprintf("%04d",$_POST["m_id"]); ?>";
</script>
<?php 
	}
if($_POST["Flag"] == "EDIT"){
$mp_name = stripslashes(htmlspecialchars($_POST["mp_name"],ENT_QUOTES));
$mp_name = eregi_replace(" ","&nbsp;",$mp_name);
$mp_name = eregi_replace("&lt;br&gt;","<br>",$mp_name);

$link = addslashes(htmlspecialchars($_POST["link"]));
$Gtip = addslashes(htmlspecialchars($_POST["Gtip"]));
$sqledit = "UPDATE `menu_properties` SET `mp_name` = '$mp_name',
`Galign` = '$_POST[Galign]',
`Gvalign` = '$_POST[Gvalign]',
`Glink` = '$link',
`Gtarget` = '$_POST[Gtarget]',
`Gtip` = '$Gtip',
`Oufont` = '$_POST[Oufont]',
`Ousize` = '$_POST[Ousize]',
`Ousizepr` = '$_POST[Ousizepr]',
`Oucolor` = '$_POST[Oucolor]',
`Oubold` = '$_POST[Oubold]',
`Ouitalic` = '$_POST[Ouitalic]',
`Oubgcolor` = '$_POST[Oubgcolor]',
`Outrans` = '$_POST[Outrans]',
`Oubgpic` = '$_POST[Oubgpic]',
`Oubordercolor` = '$_POST[Oubordercolor]',
`Ouborderw` = '$_POST[Ouborderw]',
`Ouborderstyle` = '$_POST[Ouborderstyle]',
`Gicon` = '$_POST[Gicon]',
`Giconw` = '$_POST[Giconw]',
`Giconh` = '$_POST[Giconh]',
`Giconb` = '$_POST[Giconb]',
`Garrow` = '$_POST[Garrow]',
`Garroww` = '$_POST[Garroww]',
`Garrowh` = '$_POST[Garrowh]',
`Garrowb` = '$_POST[Garrowb]',
`Ovfont` = '$_POST[Ovfont]',
`Ovsize` = '$_POST[Ovsize]',
`Ovsizepr` = '$_POST[Ovsizepr]',
`Ovcolor` = '$_POST[Ovcolor]',
`Ovbold` = '$_POST[Ovbold]',
`Ovitalic` = '$_POST[Ovitalic]',
`Ovbgcolor` = '$_POST[Ovbgcolor]',
`Ovtrans` = '$_POST[Ovtrans]',
`Ovbgpic` = '$_POST[Ovbgpic]',
`Ovbordercolor` = '$_POST[Ovbordercolor]',
`PopDisplay` = '$_POST[PopDisplay]',
`PopTrans` = '$_POST[PopTrans]',
`PopSpac` = '$_POST[PopSpac]',
`PopPad` = '$_POST[PopPad]',
`Popbgcolor` = '$_POST[Popbgcolor]',
`Popbgpic` = '$_POST[Popbgpic]',
`PopBorderW` = '$_POST[PopBorderW]',
`Popbordercolor` = '$_POST[Popbordercolor]',
`Popborderstyle` = '$_POST[Popborderstyle]',
`Popshadowstyle` = '$_POST[Popshadowstyle]',
`Popshadowsize` = '$_POST[Popshadowsize]',
`Popshadowcolor` = '$_POST[Popshadowcolor]',
`PopDirect` = '$_POST[PopDirect]',
`PopX` = '$_POST[PopX]',
`PopY` = '$_POST[PopY]',
`PopEffectShow` = '$_POST[PopEffectShow]',
`PopEffectHide` = '$_POST[PopEffectHide]',
`PopEffectSpeed` = '$_POST[PopEffectSpeed]' WHERE `mp_id` = '".$_POST["mp_id"]."' AND `m_id` = '".$_POST["m_id"]."' ";

$sql = $db->query($sqledit);

if($_POST[set_default1]=='Y' || $_POST[set_default2]=='Y'){
$sql_d = "UPDATE `menu_default` SET 
`Oufont` = '$_POST[Oufont]',
`Ousize` = '$_POST[Ousize]',
`Ousizepr` = '$_POST[Ousizepr]',
`Oucolor` = '$_POST[Oucolor]',
`Oubold` = '$_POST[Oubold]',
`Ouitalic` = '$_POST[Ouitalic]',
`Oubgcolor` = '$_POST[Oubgcolor]',
`Outrans` = '$_POST[Outrans]',
`Oubgpic` = '$_POST[Oubgpic]',
`Oubordercolor` = '$_POST[Oubordercolor]',
`Ouborderw` = '$_POST[Ouborderw]',
`Ouborderstyle` = '$_POST[Ouborderstyle]',
`Gicon` = '$_POST[Gicon]',
`Giconw` = '$_POST[Giconw]',
`Giconh` = '$_POST[Giconh]',
`Giconb` = '$_POST[Giconb]',
`Garrow` = '$_POST[Garrow]',
`Garroww` = '$_POST[Garroww]',
`Garrowh` = '$_POST[Garrowh]',
`Garrowb` = '$_POST[Garrowb]',
`Ovfont` = '$_POST[Ovfont]',
`Ovsize` = '$_POST[Ovsize]',
`Ovsizepr` = '$_POST[Ovsizepr]',
`Ovcolor` = '$_POST[Ovcolor]',
`Ovbold` = '$_POST[Ovbold]',
`Ovitalic` = '$_POST[Ovitalic]',
`Ovbgcolor` = '$_POST[Ovbgcolor]',
`Ovtrans` = '$_POST[Ovtrans]',
`Ovbgpic` = '$_POST[Ovbgpic]',
`Ovbordercolor` = '$_POST[Ovbordercolor]',
`PopDisplay` = '$_POST[PopDisplay]',
`PopTrans` = '$_POST[PopTrans]',
`PopSpac` = '$_POST[PopSpac]',
`PopPad` = '$_POST[PopPad]',
`Popbgcolor` = '$_POST[Popbgcolor]',
`Popbgpic` = '$_POST[Popbgpic]',
`PopBorderW` = '$_POST[PopBorderW]',
`Popbordercolor` = '$_POST[Popbordercolor]',
`Popborderstyle` = '$_POST[Popborderstyle]',
`Popshadowstyle` = '$_POST[Popshadowstyle]',
`Popshadowsize` = '$_POST[Popshadowsize]',
`Popshadowcolor` = '$_POST[Popshadowcolor]',
`PopDirect` = '$_POST[PopDirect]',
`PopX` = '$_POST[PopX]',
`PopY` = '$_POST[PopY]',
`PopEffectShow` = '$_POST[PopEffectShow]',
`PopEffectHide` = '$_POST[PopEffectHide]',
`PopEffectSpeed` = '$_POST[PopEffectSpeed]' ";
$sql = $db->query($sql_d);
}
$db->write_log("update","menu","ปรับปรุง submenu   ".$_POST["m_name"]);
	if($_POST["set_to1"]=='Y' || $_POST["set_to2"]=='Y'){
	?>
<script language="JavaScript">
	self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
	self.location.href = "menu_apply1.php?m_id=<?php echo $_POST["m_id"]; ?>&mp_id=<?php echo $_POST["mp_id"]; ?>&tb_show=<?php echo $_POST["tbshow"]; ?>";
</script>
<?php
	}else{
?>
<script language="JavaScript">
	self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
	self.location.href = "menu_detail.php?mp_id=<?php echo $_POST["mp_id"]; ?>&tb_show=<?php echo $_POST["tbshow"]; ?>";
</script>
<?php
		}
	}
		if($_POST["Flag"] == "Apply"){

$query = $db->query("SELECT * FROM menu_properties WHERE `mp_id` = '".$_POST["mp_id"]."' AND `m_id` = '".$_POST["m_id"]."' ");
$D = $db->db_fetch_array($query);

for($i=0;$i<$_POST["num"];$i++){
$usem = $_POST["use".$i];
	if($usem != ""){
				
				
			$sqledit = "UPDATE `menu_properties` SET `Oufont` = '$D[Oufont]',
			`Ousize` = '$D[Ousize]',
			`Ousizepr` = '$D[Ousizepr]',
			`Oucolor` = '$D[Oucolor]',
			`Oubold` = '$D[Oubold]',
			`Ouitalic` = '$D[Ouitalic]',
			`Oubgcolor` = '$D[Oubgcolor]',
			`Outrans` = '$D[Outrans]',
			`Oubgpic` = '$D[Oubgpic]',
			`Oubordercolor` = '$D[Oubordercolor]',
			`Ouborderw` = '$D[Ouborderw]',
			`Ouborderstyle` = '$D[Ouborderstyle]',
			`Gicon` = '$D[Gicon]',
			`Giconw` = '$D[Giconw]',
			`Giconh` = '$D[Giconh]',
			`Giconb` = '$D[Giconb]',
			`Garrow` = '$D[Garrow]',
			`Garroww` = '$D[Garroww]',
			`Garrowh` = '$D[Garrowh]',
			`Garrowb` = '$D[Garrowb]',
			`Ovfont` = '$D[Ovfont]',
			`Ovsize` = '$D[Ovsize]',
			`Ovsizepr` = '$D[Ovsizepr]',
			`Ovcolor` = '$D[Ovcolor]',
			`Ovbold` = '$D[Ovbold]',
			`Ovitalic` = '$D[Ovitalic]',
			`Ovbgcolor` = '$D[Ovbgcolor]',
			`Ovtrans` = '$D[Ovtrans]',
			`Ovbgpic` = '$D[Ovbgpic]',
			`Ovbordercolor` = '$D[Ovbordercolor]',
			`PopDisplay` = '$D[PopDisplay]',
			`PopTrans` = '$D[PopTrans]',
			`PopSpac` = '$D[PopSpac]',
			`PopPad` = '$D[PopPad]',
			`Popbgcolor` = '$D[Popbgcolor]',
			`Popbgpic` = '$D[Popbgpic]',
			`PopBorderW` = '$D[PopBorderW]',
			`Popbordercolor` = '$D[Popbordercolor]',
			`Popborderstyle` = '$D[Popborderstyle]',
			`Popshadowstyle` = '$D[Popshadowstyle]',
			`Popshadowsize` = '$D[Popshadowsize]',
			`Popshadowcolor` = '$D[Popshadowcolor]',
			`PopDirect` = '$D[PopDirect]',
			`PopX` = '$D[PopX]',
			`PopY` = '$D[PopY]',
			`PopEffectShow` = '$D[PopEffectShow]',
			`PopEffectHide` = '$D[PopEffectHide]',
			`PopEffectSpeed` = '$D[PopEffectSpeed]'  WHERE `mp_id` = '".$usem."' AND `m_id` = '".$_POST["m_id"]."' ";
			$sql = $db->query($sqledit);

	}
}
$db->write_log("approve","menu","อนุมัติ menu   ".$_POST["m_name"]);
?>
<script language="JavaScript">
	self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
	self.location.href = "menu_detail.php?mp_id=<?php echo $_POST["mp_id"]; ?>&tb_show=<?php echo $_POST["tbshow"]; ?>";
</script>
<?php
	}
if($_POST["Flag"] == "EDIT_MAIN"){
		$menu_name = stripslashes(htmlspecialchars($_POST["menu_name"],ENT_QUOTES));
$sqledit = "UPDATE `menu_list` SET  `m_name` = '".$menu_name."' ,
`glo_align` = '$_POST[glo_align]',
`glo_showsub` = '$_POST[glo_showsub]',
`glo_highlight` = '$_POST[glo_highlight]',
`glo_delay_hor` = '$_POST[glo_delay_hor]',
`glo_delay_ver` = '$_POST[glo_delay_ver]',
`glo_delay_hide` = '$_POST[glo_delay_hide]',
`pop_display` = '$_POST[pop_display]',
`pop_trans` = '$_POST[pop_trans]',
`pop_bgcolor` = '$_POST[pop_bgcolor]',
`pop_spacing` = '$_POST[pop_spacing]',
`pop_padding` = '$_POST[pop_padding]',
`pop_bgimage` = '$_POST[pop_bgimage]',
`pop_borcolor` = '$_POST[pop_borcolor]',
`pop_borwidth` = '$_POST[pop_borwidth]',
`pop_borstyle` = '$_POST[pop_borstyle]'
WHERE  `m_id` = '$_POST[m_id]' ";
$sql = $db->query($sqledit);

if($_POST[set_default]=='Y'){
$sql_d = $db->query("UPDATE `menu_default` SET 
`glo_align` = '$_POST[glo_align]',
`glo_showsub` = '$_POST[glo_showsub]',
`glo_highlight` = '$_POST[glo_highlight]',
`glo_delay_hor` = '$_POST[glo_delay_hor]',
`glo_delay_ver` = '$_POST[glo_delay_ver]',
`glo_delay_hide` = '$_POST[glo_delay_hide]',
`pop_display` = '$_POST[pop_display]',
`pop_trans` = '$_POST[pop_trans]',
`pop_bgcolor` = '$_POST[pop_bgcolor]',
`pop_spacing` = '$_POST[pop_spacing]',
`pop_padding` = '$_POST[pop_padding]',
`pop_bgimage` = '$_POST[pop_bgimage]',
`pop_borcolor` = '$_POST[pop_borcolor]',
`pop_borwidth` = '$_POST[pop_borwidth]',
`pop_borstyle` = '$_POST[pop_borstyle]'
");
}
$db->write_log("update","menu","ปรับปรุง menu   ".$_POST["m_name"]);
?>
<script language="JavaScript">
	self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
	self.location.href = "menu_properties.php?m_id=<?php echo $_POST["m_id"]; ?>&tb_show=<?php echo $_POST["tbshow"]; ?>";
</script>
<?php
	}
	

if($_POST["Flag"] == "UpdateSitemap"){
  //  $db->query("Update article_group SET c_rss='' WHERE c_id = '$chk'");
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["menuMain".$i];
		$nid = $_POST["menu2Main".$i];
		if($chk != ""){
			$db->query("Update menu_list SET 
			            m_realname='".$_POST["inputMM".$i]."' ,
						m_show='Y'
						WHERE m_id = '$chk'");
		}else{
			$db->query("Update menu_list SET 
			            m_realname='".$_POST["inputMM".$i]."' ,
						m_show=NULL
						WHERE m_id = '$nid'");
		}
	}
	
	for($i=0;$i<$_POST["allj"];$i++){
		$chk = $_POST["menuSub".$i];
		$nid = $_POST["menu2Sub".$i];
		if($chk != ""){
			$db->query("Update menu_properties SET 
			            mp_realname='".$_POST["inputMS".$i]."' ,
						mp_show='Y'
						WHERE mp_id = '$chk'");
		}else{
			$db->query("Update menu_properties SET 
			            mp_realname='".$_POST["inputMS".$i]."' ,
						mp_show=NULL
						WHERE mp_id = '$nid'");
		}
	}
	$db->write_log("update","sitemap","แก้ไข sitemap");
	?>
			<script language="javascript">
		        alert('<?php echo $text_gensmap_complete2;?>');
				self.location.href = "menu_sitemap.php";
			</script>
	<?php
}
if($_GET["Flag"] == "Delete" AND $_GET["m_id"] != ""){
	$db->query("DELETE FROM menu_list WHERE m_id = '".$_GET["m_id"]."' ");
	$db->query("DELETE FROM menu_properties WHERE m_id = '".$_GET["m_id"]."' ");
	$db->write_log("delete","menu","ลบ menu   ".$_GET["m_id"]);
		?>
			<script language="javascript">
				self.location.href = "menu_list.php";
			</script>
	<?php
}
if($_POST["Flag"] == "Move" ){

$sql_child = $db->query("SELECT mp_id FROM menu_properties WHERE mp_id LIKE '".$_POST["mp_id"]."%' AND m_id = '".$_POST["m_id"]."' ORDER BY mp_id ASC");
  	$mpid = array();
	$tempid = array();
	$len = strlen($_POST["mp_id"]);
	$x = 0;
	while($C = $db->db_fetch_row($sql_child)){
	$pos = substr($C[0], $len);
	array_push ($mpid,$pos);
	array_push ($tempid,sprintf("%010d",$x));
	$db->query("UPDATE menu_properties SET mp_id = '".sprintf("%010d",$x)."' WHERE mp_id = '".$C[0]."' AND  m_id = '".$_POST["m_id"]."' ");
	$x++;
	}

//del
$len = GenLen($_POST["mp_id"],"_");
$len--;
$numr = strlen($_POST["mp_id"]);
$rest = substr($_POST["mp_id"], 0, -4);

	if($EWT_DB_TYPE == "MYSQL"){
		$sql = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id > '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND length(mp_id) >= '$numr' ORDER BY mp_id ASC");
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id > '".$_POST["mp_id"]."' AND m_id = '".$_POST["m_id"]."' AND len(mp_id) >= '$numr' ORDER BY mp_id ASC");
	}

while($R = $db->db_fetch_array($sql)){
$data = explode("_",$R[mp_id]);
$num_array = count($data);
$field_change = $data[$len]-1;
$field_change = sprintf("%04d",$field_change);
$total = "";
for($i=0;$i<$num_array;$i++){
if($i == $len ){
$total .= $field_change."_";
}else{
$total .= $data[$i]."_";
}
 }
 $total = substr($total, 0, -1);
$sel = "UPDATE menu_properties SET mp_id = '$total' WHERE mp_id = '$R[mp_id]' AND m_id = '".$_POST["m_id"]."' ";
$db->query($sel);
}

//insert

$len = GenLen($_POST["newpos"],"_");
$len--;
$numr = strlen($_POST["newpos"]);
$rest = substr($_POST["newpos"], 0, -4);

	if($EWT_DB_TYPE == "MYSQL"){
		$sql = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id > '".$_POST["newpos"]."' AND m_id = '".$_POST["m_id"]."' AND length(mp_id) >= '$numr' ORDER BY mp_id DESC");
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '$rest%' AND mp_id > '".$_POST["newpos"]."' AND m_id = '".$_POST["m_id"]."' AND len(mp_id) >= '$numr' ORDER BY mp_id DESC");
	}

	while($R = $db->db_fetch_array($sql)){
		$sqlR = $db->query("SELECT mp_id FROM menu_properties WHERE mp_id LIKE '".$_POST["newpos"]."%' AND mp_id = '$R[mp_id]' AND m_id = '".$_POST["m_id"]."' ");
			if(!$tttt = $db->db_num_rows($sqlR)){
				$data = explode("_",$R[mp_id]);
				$num_array = count($data);
				$field_change = $data[$len]+1;
				$field_change = sprintf("%04d",$field_change);
				$total = "";
						for($i=0;$i<$num_array;$i++){
							if($i == $len ){
								$total .= $field_change."_";
							}else{
								$total .= $data[$i]."_";
							}
						 }
				$total = substr($total, 0, -1);
			$sel = "UPDATE menu_properties SET mp_id = '$total' WHERE mp_id = '$R[mp_id]' AND m_id = '".$_POST["m_id"]."' ";
			$db->query($sel);
		}
	}

$m = explode($rest,$_POST["newpos"]);
$Nmenu = $m[1]+1;
$gen_menu = $rest.sprintf("%04d",$Nmenu);

//update

  $n = count($tempid);
  for($i=0;$i<$n;$i++){
  $position = $tempid[$i];
  $mid = $gen_menu.$mpid[$i];
  $db->query("UPDATE menu_properties SET mp_id = '$mid'  WHERE mp_id = '$position' AND m_id = '".$_POST["m_id"]."' ");
  }

		?>
			<script language="javascript">
				self.parent.menu_left.location.reload();
				self.parent.menu_main.location.reload();
				self.location.href = "menu_detail.php?mp_id=<?php echo $gen_menu; ?>";
			</script>
	<?php
}
$db->db_close(); ?>
