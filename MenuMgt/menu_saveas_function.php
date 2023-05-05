<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($_POST[flag]=='save_as'){
//add group
			$sql = $db->query("SELECT * FROM menu_list WHERE m_id = '".$_POST[m_id]."' ");
			$R = $db->db_fetch_array($sql);
   			$R[m_name] = $_POST[menu_name];
			$db->query("insert into menu_list (m_name,m_detail,glo_align,glo_showsub,glo_highlight,
																		glo_delay_ver,glo_delay_hor,glo_delay_hide,pop_display,
																		pop_bgcolor,pop_spacing,pop_padding,pop_trans,pop_bgimage,
																		pop_borcolor,pop_borwidth,pop_borstyle,m_realname,m_show) 
									values ('".$R[m_name]."','".$R[m_detail]."','".$R[glo_align]."','".$R[glo_showsub]."','".$R[glo_highlight]."',
													'".$R[glo_delay_ver]."','".$R[glo_delay_hor]."','".$R[glo_delay_hide]."','".$R[pop_display]."',
													'".$R[pop_bgcolor]."','".$R[pop_spacing]."','".$R[pop_padding]."','".$R[pop_trans]."','".$R[pop_bgimage]."',
													'".$R[pop_borcolor]."','".$R[pop_borwidth]."','".$R[pop_borstyle]."','".$R[m_realname]."','".$R[m_show]."')");
			$sql_max = $db->query("select max(m_id) as maxid from menu_list order by m_id DESC");
			$query_max =$db->db_fetch_array($sql_max);
			$maxid =$query_max[maxid];
			
			//echo "SELECT * FROM menu_properties WHERE m_id = '".$_GET[m_id]."' ORDER BY mp_id ASC";
				$sql1 = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$_POST[m_id]."' ORDER BY mp_id ASC");
				while($RR = $db->db_fetch_array($sql1)){
			//add sub menu
				$mp_id = $RR[mp_id];
				$gen_menu = sprintf("%04d",$maxid);
				$m = explode("_",$mp_id);
				for($x=1;$x<count($m);$x++){
					$gen_menu .="_".$m[$x];
				}
					$db->query("insert into menu_properties (mp_id,m_id,mp_name,Galign,Gvalign,Glink,
																			Gtarget,Gtip,Oufont,Ousize,
																			Ousizepr,Oucolor,Oubold,Ouitalic,Oubgcolor,
																			Outrans,Oubgpic,Oubordercolor,Ouborderw,Ouborderstyle,
																			Gicon,Giconw,Giconh,Giconb,Garrow,Garroww,Garrowh,Garrowb,Ovfont,
																			Ovsize,Ovsizepr,Ovcolor,Ovbold,Ovitalic,Ovbgcolor,Ovtrans,Ovbgpic,Ovbordercolor,PopDisplay,
																			PopTrans,PopSpac,PopPad,Popbgcolor,Popbgpic,PopBorderW,Popbordercolor,Popborderstyle,
																			Popshadowstyle,Popshadowsize,Popshadowcolor,PopDirect,PopX,PopY,
																			PopEffectShow,PopEffectHide,PopEffectSpeed,mp_realname,mp_show) 
										values ('".$gen_menu."','".$maxid."','".$RR[mp_name]."','".$RR[Galign]."','".$RR[Gvalign]."','".$RR[Glink]."',
														'".$RR[Gtarget]."','".$RR[Gtip]."','".$RR[Oufont]."','".$RR[Ousize]."',
														'".$RR[Ousizepr]."','".$RR[Oucolor]."','".$RR[Oubold]."','".$RR[Ouitalic]."','".$RR[Oubgcolor]."',
														'".$RR[Outrans]."','".$RR[Oubgpic]."','".$RR[Oubordercolor]."','".$RR[Ouborderw]."','".$RR[Ouborderstyle]."',
														'".$RR[Gicon]."','".$RR[Giconw]."','".$RR[Giconh]."','".$RR[Giconb]."','".$RR[Garrow]."','".$RR[Garroww]."','".$RR[Garrowh]."','".$RR[Garrowb]."','".$RR[Ovfont]."',
														'".$RR[Ovsize]."','".$RR[Ovsizepr]."','".$RR[Ovcolor]."','".$RR[Ovbold]."','".$RR[Ovitalic]."','".$RR[Ovbgcolor]."','".$RR[Ovtrans]."','".$RR[Ovbgpic]."','".$RR[Ovbordercolor]."','".$RR[PopDisplay]."',
														'".$RR[PopTrans]."','".$RR[PopSpac]."','".$RR[PopPad]."','".$RR[Popbgcolor]."','".$RR[Popbgpic]."','".$RR[PopBorderW]."','".$RR[Popbordercolor]."','".$RR[Popborderstyle]."',
														'".$RR[Popshadowstyle]."','".$RR[Popshadowsize]."','".$RR[Popshadowcolor]."','".$RR[PopDirect]."','".$RR[PopX]."','".$RR[PopY]."',
														'".$RR[PopEffectShow]."','".$RR[PopEffectHide]."','".$RR[PopEffectSpeed]."','".$RR[mp_realname]."','".$RR[mp_show]."')");
				
			}
?>
			<script language="javascript">
				alert("ทำการคัดลอกเมนูเรียบร้อยแล้ว");
				//self.location.href = "menu_list.php";
				self.location.href = "menu_main.php?m_id=<?php echo $maxid;?>";
			</script>
		<?php
			exit;
}
$db->db_close(); ?>
