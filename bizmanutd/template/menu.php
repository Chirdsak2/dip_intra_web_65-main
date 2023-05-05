<?php
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}
function GenMenux($m_id){

global $db;
global $filename;
$sql = $db->query("SELECT * FROM menu_list WHERE m_id = '".$m_id."' ");
$R = $db->db_fetch_array($sql);
$sql1 = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$m_id."' ORDER BY mp_id ASC");
if($R[glo_showsub]=="Y" && $R[glo_highlight]=="Y"){ 
	$show_id=3; 
}  else if($R[glo_showsub]=="Y" && $R[glo_highlight]==""){ 
	$show_id=1; 
}  else {
	$show_id=0; 
}
$show_trans=100-$R[pop_trans];
if($filename != ''){
$filenmae_link = '&filename='.$filename;
}
$txt = "";
if($rows = mysql_num_rows($sql1)){

$txt .= "stm_bm([\"menu0a49\",430,\"\",\"mainpic/o.gif\",0,\"\",\"\",".$R[glo_align].",".$show_id.",".$R[glo_delay_ver].",".$R[glo_delay_hor].",".$R[glo_delay_hide].",1,0,0,\"\",\"\",0],this);\n";
$txt .= "stm_bp(\"p0\",[".$R[pop_display].",4,0,0,".$R[pop_spacing].",".$R[pop_padding].",1,1,".$show_trans.",\"\",-2,\"\",-2,50,0,0,\"#fffff7\",\"".$R[pop_bgcolor]."\",\"".$R[pop_bgimage]."\",3,".$R[pop_borstyle].",".$R[pop_borwidth].",\"".$R[pop_borcolor]."\"]);\n";
$LenChk = 0;
	$i = 0;
		while($RR=$db->db_fetch_array($sql1)){
			$len = GenLen($RR[mp_id],"_");
			if($LenChk > $len ){
				for($y=$len;$y<$LenChk;$y++){
					$txt .= "stm_ep();\n";
			}
		}

$txt .= "stm_ai(\"p".$i."\",[1,\"".stripslashes($RR[mp_name])."\",\"\",\"\",-1,-1,0,\"".stripslashes($RR[Glink])."\",\"".$RR[Gtarget]."\",\"\",\"".stripslashes($RR[Gtip])."\",\"".$RR[Gicon]."\",\"".$RR[Gicon]."\",-1,-1,0,\"".$RR[Garrow]."\",\"".$RR[Garrow]."\",-1,-1,0,".$RR[Galign].",".$RR[Gvalign].",\"".$RR[Oubgcolor]."\",".$RR[Outrans].",\"".$RR[Ovbgcolor]."\",".$RR[Ovtrans].",\"".$RR[Oubgpic]."\",\"".$RR[Ovbgpic]."\",3,3,".$RR[Ouborderstyle].",".$RR[Ouborderw].",\"".$RR[Oubordercolor]."\",\"".$RR[Ovbordercolor]."\",\"".$RR[Oucolor]."\",\"".$RR[Ovcolor]."\",\"".$RR[Ouitalic]." ".$RR[Oubold]." ".$RR[Ousize].$RR[Ousizepr]." ".$RR[Oufont]."\",\"".$RR[Ovitalic]." ".$RR[Ovbold]." ".$RR[Ovsize].$RR[Ovsizepr]." ".$RR[Ovfont]."\",0,0]);\n";	

	$selSub = $db->query("SELECT mp_id FROM menu_properties WHERE m_id = '".$m_id."' AND mp_id LIKE '".$RR[mp_id]."_%'"); 
if($db->db_num_rows($selSub) > 0){

$txt .= "stm_bp(\"p0\",[".$RR[PopDisplay].",".$RR[PopDirect].",".$RR[PopX].",".$RR[PopY].",".$RR[PopSpac].",".$RR[PopPad].",1,1,100,\"\",-2,\"\",-2,".$RR[PopEffectSpeed].",".$RR[Popshadowstyle].",".$RR[Popshadowsize].",\"".$RR[Popshadowcolor]."\",\"".$RR[Popbgcolor]."\",\"".$RR[Popbgpic]."\",3,".$RR[Popborderstyle].",".$RR[PopBorderW].",\"".$RR[Popbordercolor]."\"]);\n";

}

$LenChk = $len;
	$i++;
	}
$txt .= "stm_ep();\n";
$txt .= "stm_em();\n";
}

$txt .= "";
return $txt;
}
echo GenMenux($m);
 $db->db_close(); 
?>