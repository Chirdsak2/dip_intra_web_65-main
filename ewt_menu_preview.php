<?php
function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}
function GenMenu($m_id){
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
$txt = "<script type=\"text/javascript\" language=\"JavaScript1.2\">";
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
			
//$menu_log.php?m_id=$m_id&mp_id=$RR[mp_id];
if($RR[Glink]!='' && $RR[Gtarget] != '_blank') {
	$menu_script='javascript:ajax_save_menu_log(\''.$m_id.'\',\''.$RR[mp_id].'\',\''.$RR[Glink].'\',\''.$RR[Gtarget].'\');';
	$menu_taget = '';
}else if($RR[Glink]!='' && $RR[Gtarget] == '_blank'){
	$menu_script='menu_log.php?m_id='.$m_id.'&mp_id='.$RR[mp_id];
	$menu_taget = $RR[Gtarget];
}
//stripslashes($RR[Glink])

$txt .= "stm_ai(\"p".$i."\",[1,\"".stripslashes($RR[mp_name])."\",\"\",\"\",-1,-1,0,\"".$menu_script."\",\"".$menu_taget."\",\"\",\"".stripslashes($RR[Gtip])."\",\"".$RR[Gicon]."\",\"".$RR[Gicon]."\",-1,-1,0,\"".$RR[Garrow]."\",\"".$RR[Garrow]."\",-1,-1,0,".$RR[Galign].",".$RR[Gvalign].",\"".$RR[Oubgcolor]."\",".$RR[Outrans].",\"".$RR[Ovbgcolor]."\",".$RR[Ovtrans].",\"".$RR[Oubgpic]."\",\"".$RR[Ovbgpic]."\",3,3,".$RR[Ouborderstyle].",".$RR[Ouborderw].",\"".$RR[Oubordercolor]."\",\"".$RR[Ovbordercolor]."\",\"".$RR[Oucolor]."\",\"".$RR[Ovcolor]."\",\"".$RR[Ouitalic]." ".$RR[Oubold]." ".$RR[Ousize].$RR[Ousizepr]." ".$RR[Oufont]."\",\"".$RR[Ovitalic]." ".$RR[Ovbold]." ".$RR[Ovsize].$RR[Ovsizepr]." ".$RR[Ovfont]."\",0,0]);\n";	

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

$txt .= "</script>";
return $txt;
}
function GenFontSize($BID){
global $db;
global $mainwidth;
global $global_theme;

$sql = $db->query("select block_themes from block where BID = '$BID' ");
$count_rec = $db->db_num_rows($sql);
$rec = $db->db_fetch_array($sql);

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
		$namefolder = "themes".($themeid);
		
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		 //if($themes_type == 'F'){
		$buffer = "";
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
                echo $design[0];
		 }
      }

	?><style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 8pt;
	color: #8b4513;
}
.style2 {font-family: Tahoma; font-size: 8pt; color: #864420; }
.style3 {font-family: Tahoma; font-size: 8pt; color: #000000; }
-->
</style>
	<link href="ewt/dmr_web/css/text1.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
<!--
.style4 {color: #FFFFFF}
-->
    </style><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table><?php echo $design[0];?>
	<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">
 <table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="3" cellspacing="1" >
  <tr>
    <td align="center" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
	<TABLE cellSpacing=1 cellPadding=6 width=120 bgColor=#dddddd border=0>
	<TBODY>
	<TR>
	<TD style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #555555; FONT-FAMILY: Tahoma; TEXT-DECORATION: none" align=middle bgColor=#ffffff>FONTSIZE <A onClick="changeStyle('small');" href="javascript:void(0);"><IMG height=10 src="mainpic/s.gif" width=10 border=0></A> <A onClick="changeStyle('normal');" href="javascript:void(0);"><IMG height=10 src="mainpic/n.gif" width=10 border=0></A> <A onClick="changeStyle('big');" href="javascript:void(0);"><IMG height=10 src="mainpic/b.gif" width=10 border=0></A> </TD></TR></TBODY></TABLE>
	</td>
  </tr>
</table>
	</td>
     </tr>
</table>
<?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
	<?php
}
					function genOrgChart($up_id) {
						global $db,$lang_sh;
						global $mainwidth;
						$lang_shw = substr($lang_sh , 1);
						$sql_order = "select * from gen_user_order where up_user_id = '".$up_id."' order by order_no asc";
						$query_order = $db->query($sql_order);
						$return = '
						<tr>
							<td align="center" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>';
						$i = 1;
						$max = $db->db_num_rows($query_order);
						while($result_order = $db->db_fetch_array($query_order)) {
							if($i == 1) { $bgcolor1 = 'border-top:0px solid #FFFFFF;'; } else { $bgcolor1 = 'border-top:1px solid #000000;'; }
							if($i == $max) { $bgcolor2 = 'border-top:0px solid #FFFFFF;'; } else { $bgcolor2 = 'border-top:1px solid #000000;'; }
							$sql_staff = "select * from gen_user  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) where gen_user_id = '".$result_order['gen_user_id']."'";
							$query_staff = $db->query($sql_staff);
							$result_staff = $db->db_fetch_array($query_staff);
							$sql_title = "select * from title where title_id = '".$result_staff['title_thai']."' ";
							$query_title = $db->query($sql_title);
							$result_title = $db->db_fetch_array($query_title);
							$sql_position_staff = "select * from position_name where pos_id = '".$result_staff['posittion']."'";
							$query_position_staff = $db->query($sql_position_staff);
							$result_position_staff = $db->db_fetch_array($query_position_staff);
							if($result_staff[path_image] != ""){
								$path_image= "../pic_upload/".$result_staff[path_image];
								if (file_exists($path_image)) {
									$path_image=$path_image;
								}else{
									$path_image="../images/ImageFile.gif";
								}
							}
							
							$return .= '
										<td align="center" valign="top">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">';
							if($max == 1) {
								$return .= '
												<tr>
													<td align="center"><img src="img.php?p='.base64_encode("mainpic/horizonline.gif").'" width="1" height="13" border="0" align="absmiddle"></td>
												</tr>';
							} else {
								$return .= '
												<tr>
													<td align="center" width="100%">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="50%">
																	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="'.$bgcolor1.'">
																		<tr><td> </td></tr>
																	</table>
																</td>
																<td align="center" valign="bottom" bgcolor="#000000" height="14px"><img src="img.php?p='.base64_encode("mainpic/hline2.gif").'" width="1" height="13" border="0" align="absmiddle"></td>
																<td width="50%">
																	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="'.$bgcolor2.'">
																		<tr><td> </td></tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>';
							}
							if($lang_sh != ''){
							$result_position_staff['pos_name'] = select_lang_detail_ewt($result_position_staff['pos_id'],$lang_shw,'pos_name','position_name');
							$result_title['title_thai'] = select_lang_detail_ewt($result_title['title_id'],$lang_shw,'title_thai','title');
							$result_staff['name_thai'] = select_lang_detail_ewt($result_staff['gen_user_id'],$lang_shw,'name_thai','gen_user');
							$result_staff['surname_thai'] = select_lang_detail_ewt($result_staff['gen_user_id'],$lang_shw,'surname_thai','gen_user');
								if($result_staff['name_thai'] == ''){
								$result_title['title_thai']  ='';
								}
							}
							$return .= '
												<tr>
													<td align="center" valign="middle" style="padding:1px 1px 1px 1px;">
														<table width="90px" cellspacing="0" cellpadding="0">
															<tr>
																<td align="center" valign="middle">
																	<table width="90px" height="120px" border="0" cellspacing="0" cellpadding="0" class="orgchartperson" style="border:1px solid #FAC663; background-color:#FFF3D9;">
																		<tr>
																			<td align="center" valign="middle">
																				<div style="margin:10px 3px 5px 3px">
																				<img src="img.php?p='.base64_encode($path_image).'" name="previewField" width="75" height="75" id="previewField" style="border:1px solid #555;" />
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td align="center" valign="middle" height="25" style="FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #000000; FONT-FAMILY: \'Tahoma\'"><nobr>'.$result_title["title_thai"].$result_staff["name_thai"].'&nbsp;'.$result_staff["surname_thai"].'</nobr></td>
																		</tr>
																		<tr>
																			<td align="center" valign="middle" height="25" style="FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #000000; FONT-FAMILY: \'Tahoma\'"><strong>ตำแหน่ง : '.$result_position_staff["pos_name"].'</strong><br/>อีเมล์ : '.$result_staff['email_person'].'</td>
																		</tr>
																	</table>
																</td>
															</tr>';
							$sql_child = $db->query("select * from gen_user_order where up_user_id = '".$result_staff["gen_user_id"]."' order by order_no asc");
							$child = $db->db_num_rows($sql_child);	
							if($child > 0) {
								$return .= '
															<tr>
																<td align="center"><img src="img.php?p='.base64_encode("mainpic/horizonline.gif").'" width="1" height="13" border="0" align="absmiddle"></td>
															</tr>';
							}
							$return .= genOrgChart($result_staff["gen_user_id"]);
							$return .= '				</table>
													</td>
												</tr>
											</table>
										</td>';
							$i++;
						}
						$return .= '
									</tr>
								</table>
							</td>
						</tr>';
						return $return;
					}
					function genOrgChart2($gen_id) {
						global $db;
						global $filename;
						global $staff_flag,$lang_sh;
						global $mainwidth;
						$lang_shw = substr($lang_sh , 1);
						if($staff_flag == 1) {
							$sql_org = $db->query("SELECT * FROM org_name where parent_org_id = '".$gen_id."'");
							$R = $db->db_fetch_array($sql_org);
							
							$sql_user = $db->query("SELECT * FROM gen_user where org_id = '".$R["org_id"]."' order by level_id ASC");
							$return = '
							<style>
								#body_wrap {
									margin: 0 auto;
								}
								#content {
									float: left;
								}
								.gallery {
									min-height: 108px;
									list-style: none;
								}
								* html .gallery {
									height: 108px;
								}
								.gallery li {
									float: left;
									width: 120px;
									height: 150px;
									margin: 8px 8px 8px 8px;
								}
							</style>
							<tr>
								<td align="center" valign="top">
									<table width="95%" border="0" cellspacing="0" cellpadding="0" style="padding:5px 5px 5px 5px; border:1px solid #000000;" class="childOrg">
										<tr>
											<td>
												<div id="body_wrap">
													<div id="content">
														<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="padding:5px 5px 5px 5px;">
															<tr>
																<td valign="middle" align="center">
														<ul class="gallery">';
													while($R_user = $db->db_fetch_array($sql_user)){
							$sql_title = "select * from title where title_id = '".$R_user['title_thai']."'";
							$query_title = $db->query($sql_title);
							$result_title = $db->db_fetch_array($query_title);
							if($lang_sh != ''){
							$R_user["name_thai"] = select_lang_detail_ewt($R_user[gen_user_id],$lang_shw,'name_thai','gen_user');
							$R_user["surname_thai"] = select_lang_detail_ewt($R_user[gen_user_id],$lang_shw,'surname_thai','gen_user');
							$R_user["position_person"] = select_lang_detail_ewt($R_user[gen_user_id],$lang_shw,'position_person','gen_user');
								if($R_user["name_thai"] != ''){
								$result_title["title_thai"] = select_lang_detail_ewt($result_title[title_id],$lang_shw,'title_thai','title');
								}else{
								$result_title["title_thai"] =  '';
								}
							}

							if($R_user[path_image] != ""){
								$path_image= "../pic_upload/".$R_user[path_image];
								if (file_exists($path_image)) {
									$path_image=$path_image;
								}else{
									$path_image="../images/ImageFile.gif";
								}
							}else{
							$path_image="../images/ImageFile.gif";
							}
														$return .= '
															<li>
																<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding:5px 5px 5px 5px; border:1px solid #000000;" class="childOrg">
																	<tr onClick="window.open(\'staff_info.php?filename='.$filename.'&gen_user_id='.$R_user["gen_user_id"].'\',\'staff_info\',\'width=600 , height=550, scrollbars=1,resizable = 0\');" style="cursor:hand">
																		<td>
																			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding:5px 5px 5px 5px;">
																				<tr>
																					<td valign="middle" align="center"><img src="img.php?p='.base64_encode($path_image).'" name="previewField" width="50" height="50" id="previewField" style="border:1px solid #555;" /></td>
																				</tr>
																				<tr>
																					<td align="center" valign="middle" height="25"><nobr>'.$R_user["name_thai"].'&nbsp;'.$R_user["surname_thai"].'</nobr></td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
															</li>';
															}
														$return .= '
														</ul></td>
										</tr>
									</table>
													</div>
												</div>';
							$return .= '	</td>
										</tr>
									</table>
								</td>
							</tr>';
						} else {
							$sql_group = $db->query("SELECT * FROM org_name where parent_org_id LIKE '".$gen_id."\_____' ORDER BY parent_org_id ASC");
							$return = '
							<tr>
								<td align="center" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>';
							$i = 1;
							$max = $db->db_num_rows($sql_group);
							if($max > 1) { $tb_width = $mainwidth/(floor($max/2)); } else { $tb_width = $mainwidth; }
							while($R = $db->db_fetch_array($sql_group)){
								if($i == 1) { $bgcolor1 = ''; } else { $bgcolor1 = '#000000'; }
								if($i == $max) { $bgcolor2 = ''; } else { $bgcolor2 = '#000000'; }
								//if(trim($R["short_name"]) == '') { $text_name = $R["name_org"]; } else { $text_name = $R["short_name"]; }
								$text_name = $R["name_org"];
								if( $lang_sh!= ''){
								$text_name = select_lang_detail_ewt($R[org_id],$lang_shw,'name_org','org_name');
								}
								$logo = "img.php?p=".base64_encode("../../MemberMgt/pic_org/".$R[org_pics]);
								$map = "../../MemberMgt/pic_org/".$R[org_map];
								$area = "../../MemberMgt/pic_org/".$R[org_area];
								if($R["org_color"] == '') { $R["org_color"] = '#FFFFFF'; }
								if($R[org_pics] != ''){ $logo = $logo; } else { $logo = "img.php?p=".base64_encode("mainpic/no_pic_2.gif"); }
								if($R[org_map] != ''){ $map = "<a href=\"img.php?p=".base64_encode($map)." target=\"_blank\"> ??????".$R[name_org]."</a>"; } else { $map = ""; }
								if($R[org_area] != ''){ $area =  "<a href=\"img.php?p=".base64_encode($area)." target=\"_blank\"> ?????????".$R[name_org]."</a>"; } else { $area = ""; }
								$sql_child = $db->query("SELECT * FROM org_name where parent_org_id LIKE '".$R["parent_org_id"]."\_____' ORDER BY parent_org_id ASC");
								$child = $db->db_num_rows($sql_child);	
								$return .= '
											<td align="center" valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">';
								$return .= '		
													<tr>
														<td width="'.((100%$max)*2).'%">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td align="center" background="img.php?p='.base64_encode("mainpic/h_v_line.png").'" style="background-repeat:no-repeat; background-position:center;" valign="top" height="10" >
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="50%" height="1" bgcolor="'.$bgcolor1.'"> </td>
																				<td width="50%" height="1" bgcolor="'.$bgcolor2.'"> </td>
																			</tr>
																		</table>
																	</td>';
								if($i+1 == 1) { $bgcolor1 = ''; } else { $bgcolor1 = '#000000'; }
								if($i+1 == $max) { $bgcolor2 = ''; } else { $bgcolor2 = '#000000'; }
								if($i+1 <= $max) {
								
										$return .= '
																	<td width="30px" background="img.php?p='.base64_encode("mainpic/hline2.gif").'" style="background-repeat:repeat-y; background-position:center;" valign="top" height="15">
																		<table width="30" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="15" height="1" bgcolor="'.$bgcolor1.'"> </td>
																				<td width="15" height="1" bgcolor="'.$bgcolor2.'"> </td>
																			</tr>
																		</table>
																	</td>';
								} else {
										$return .= '
																	<td width="30px"valign="top" height="15"> </td>';
								}
								$return .= '
																</tr>
																<tr>
																	<td align="center" valign="middle">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td>
																		<table width="100%" border="0" cellspacing="0" cellpadding="1" style="padding:0px 0px 0px 0px; border:1px solid #000000;" height="80" bgcolor="'.$R["org_color"].'" class="childOrg">
																			<tr>
																				<td align="center" valign="middle"><div style="width=100%; height=100%" class="gradient"><table width="100%" border="0" cellspacing="0" cellpadding="1" height="100%">
																			<tr>
																				<td align="center" valign="middle"><span class="text_normal">';
																				if($child > 0) {
																				$return .= '<a href="?org_id='.$R[org_id].'&filename='.$filename.'">'.$text_name.'</a>';
																				} else {
																				$return .= '<a href="?org_id='.$R[org_id].'&filename='.$filename.'&staff_flag=1">'.$text_name.'</a>';
																				}
																				$return .= '</span></td>
																			</tr>
																		</table></div></td>
																			</tr>
																		</table><br></td>
																			</tr>
																		</table>
																	</td>';
								
								if($i+1 <= $max) {
								
								$return .= '
																	<td width="30px" background="img.php?p='.base64_encode("mainpic/hline2.gif").'" style="background-repeat:repeat-y; background-position:center;"><img src="img.php?p='.base64_encode("mainpic/blank.gif").'" width="30" height="10" border="0" align="absmiddle"></td>';
								} else {
								$return .= '<td width="30px" style="background-repeat:repeat-y; background-position:center"><img src="img.php?p='.base64_encode("mainpic/blank.gif").'" width="30" height="10" border="0" align="absmiddle"></td>';
								}
								$return .= '
																</tr>
															</table>
														</td>
													</tr>';
								$i++;
								$R = $db->db_fetch_array($sql_group);
								$sql_child = $db->query("SELECT * FROM org_name where parent_org_id LIKE '".$R["parent_org_id"]."\_____' ORDER BY parent_org_id ASC");
								$child = $db->db_num_rows($sql_child);	
								//if(trim($R["short_name"]) == '') { $text_name = $R["name_org"]; } else { $text_name = $R["short_name"]; }
								$text_name = $R["name_org"];
								if($lang_sh != ''){
								$text_name  = select_lang_detail_ewt($R[org_id],$lang_shw,'name_org','org_name');
								}
								$logo = "img.php?p=".base64_encode("../../MemberMgt/pic_org/".$R[org_pics]);
								$map = "../../MemberMgt/pic_org/".$R[org_map];
								$area = "../../MemberMgt/pic_org/".$R[org_area];
								if($R["org_color"] == '') { $R["org_color"] = '#FFFFFF'; }
								if($R[org_pics] != ''){ $logo = $logo; } else { $logo = "img.php?p=".base64_encode("mainpic/no_pic_2.gif"); }
								if($R[org_map] != ''){ $map = "<a href=\"img.php?p=".base64_encode($map)." target=\"_blank\"> $text_genchat_map".$R[name_org]."</a>"; } else { $map = ""; }
								if($R[org_area] != ''){ $area =  "<a href=\"img.php?p=".base64_encode($area)." target=\"_blank\"> $text_genchat_place".$R[name_org]."</a>"; } else { $area = ""; }
								$return .= '		<tr>
														<td>';
								if($i <= $max) {
								$return .= '
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td width="10px"><img src="img.php?p='.base64_encode("mainpic/blank.gif").'" width="10" height="10" border="0" align="absmiddle"></td>
																	<td align="center" valign="middle">
																		<table width="100%" border="0" cellspacing="0" cellpadding="1" style="padding:0px 0px 0px 0px; border:1px solid #000000;" height="80" bgcolor="'.$R["org_color"].'" class="childOrg">
																			<tr>
																				<td align="center" valign="middle"><div style="width=100%; height=100%" class="gradient"><table width="100%" border="0" cellspacing="0" cellpadding="1" height="100%">
																			<tr>
																				<td align="center" valign="middle"><span class="text_normal">';
																				if($child > 0) {
																				$return .= '<a href="?org_id='.$R[org_id].'&filename='.$filename.'">'.$text_name.'</a>';
																				} else {
																				$return .= '<a href="?org_id='.$R[org_id].'&filename='.$filename.'&staff_flag=1">'.$text_name.'</a>';
																				}
																				$return .= '</span></td>
																			</tr>
																		</table><div></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>';
								} else {
								$return .= '&nbsp;';
								}
								$return .= '
														</td>
													</tr>';
								$return .= '	</table>
											</td>';
								$i++;
							}
							$return .= '
										</tr>
									</table>
								</td>
							</tr>';
						}
						return $return;
					}
function GenChart($org){
global $lang_sh,$EWT_DB_USER;
	@include("language/language".$lang_sh.".php");
	$uploaddir = "../pic_upload/";
	
	$o = explode(",",$org);
	$org_id = $o[0];
	$type = $o[1];
	$sname = $o[2];
	$spic = $o[3];
	$sdetail = $o[4];
	global $db;
	$lang_shw = substr($lang_sh , 1);
	$db->query("USE ".$EWT_DB_USER);
	if($type == "1"){
		$sql_group1 = $db->query("SELECT * FROM org_name WHERE org_id = '".$org_id."' ");
		$R = $db->db_fetch_array($sql_group1);
		$logo = "../../MemberMgt/pic_org/".$R[org_pics];
		$map = "../../MemberMgt/pic_org/".$R[org_map];
		$area = "../../MemberMgt/pic_org/".$R[org_area];
		
					if($lang_sh != ''){
					$R["name_org"] = select_lang_detail_ewt($R[org_id],$lang_shw,'name_org','org_name');
					}
		if(file_exists($logo) && $R[org_pics] != ''){ $logo = $logo; } else { $logo = "../../images/a_no_pic.gif"; }
		if(file_exists($map) && $R[org_map] != ''){ $map = "<a href=\"img.php?p=".base64_encode($map)." target=\"_blank\"> ??????".$R[name_org]."</a>"; } else { $map = ""; }
		if(file_exists($area) && $R[org_area] != ''){ $area =  "<a href=\"img.php?p=".base64_encode($area)." target=\"_blank\"> ?????????".$R[name_org]."</a>"; } else { $area = ""; }
?>
	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0"  >
		<tr>
			<td align="center" bgcolor="<?php if($R[org_color] != ''){ echo $R[org_color]; } else { echo "#EEEEEE"; } ?>"><font size="4"><strong><span class="text_head"><?php echo $R[name_org]; ?></span></strong></font>
				<?php if($sdetail == "Y"){ ?>
				<hr size="1">
				<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
					<tr> 
						<td width="31%" class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_location;?> :</span></td>
						<td width="69%"><span class="text_normal"><?php echo $R[org_place] ?></span></td>
						<td width="69%" align="center"><span class="text_normal"><?php echo $text_genchat_logo;?></span></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_addess;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[org_address] ?></span></td>
						<td rowspan="9" align="center"><img src="img.php?p=<?php echo base64_encode($logo); ?>" width="98" height="98" align="absmiddle"></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_phonin;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[tel] ?></span></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_fax;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[fax] ?></span></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_email;?> : </span></td>
						<td><span class="text_normal"><?php echo $R[email] ?></span></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_url;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[org_url] ?></span></td>
					</tr>
					<tr>
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_objective;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[org_object]; ?></span></td>
					</tr>
					<tr>
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_map;?> :</span></td>
						<td><span class="text_normal"><?php echo $map;?></span></td>
					</tr>
					<tr>
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_place;?> :</span></td>
						<td><span class="text_normal"><?php echo $area;?></span></td>
					</tr>
					<tr>
						<td class="bg_color_row">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<?php } ?>
			</td>
		</tr>
	</table>
	<br>
	<?php
		$sql_position = $db->query("SELECT distinct(pos_name) AS pos_name ,pos_id FROM position_name INNER JOIN gen_user ON position_name.pos_id = gen_user.posittion WHERE gen_user.org_id = '".$R["org_id"]."' ORDER BY position_name.pos_level ASC ");
		while($P = $db->db_fetch_array($sql_position)){
	?>
	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="2" bgcolor="#FFFFFF">
		<tr><td align="center" bgcolor="<?php if($R[org_color] != ''){ echo $R[org_color];}else{ echo "#F7F7F7";} ?>"><font size="1"  face="MS Sans Serif"><b><span class="text_head"><?php echo $P["pos_name"]; ?></span></b></font></td></tr>
		<tr><td align="center" >&nbsp;</td></tr>
		<tr>
			<td>
			<?php
				$sql_user = $db->query("SELECT * FROM gen_user WHERE posittion = '".$P["pos_id"]."' AND org_id = '".$R["org_id"]."' order by level_id ASC,org_type_id DESC,display_order ASC ");
				$x=0;
				while($U = $db->db_fetch_array($sql_user)){
					$sql_title = "SELECT title_thai,title_eng FROM title where title_id = '$U[title_thai]'";
					$query_title = $db->query($sql_title);
					$rec = $db->db_fetch_array($query_title);
					$path_image=$U[path_image];
					if($path_image != ''){
						$path_image22 = $uploaddir.$path_image;
						if(file_exists($path_image22)){
							$path_image2 = $path_image22;
						}else{
							$path_image2 = "../images/ImageFile.gif";
						}
					}else{
						$path_image2 = "../images/ImageFile.gif";
					}
					if($x%3 == 0){
						echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
					}
					/*if($U["path_image"] != ""){
					$path1 = eregi_replace("../pic_upload/","",$U["path_image"]);
					$path = "../dmr_profile/pic_upload/".$path1;
					}else{
					$path = "../../images/ImageFile.gif";
					}*/
					if($lang_sh != ''){
					$U["name_thai"] = select_lang_detail_ewt($U[gen_user_id],$lang_shw,'name_thai','gen_user');
					$U["surname_thai"] = select_lang_detail_ewt($U['gen_user_id'],$lang_shw,'surname_thai','gen_user');
					$U["position_person"] = select_lang_detail_ewt($U['gen_user_id'],$lang_shw,'position_person','gen_user');
					}
?>
<td align="center" valign="top" width="33%">
<?php if($spic == "Y"){ ?>
<img src="img.php?p=<?php echo base64_encode($path_image2); ?>" width="100px" height="120px" align="absmiddle">
<?php } ?>
<?php if($sname == "Y"){ ?>
<div><font size="2"><span class="text_normal">
<a href="person_detail.php?pid=<?php echo $U['gen_user_id']; ?>">
<?php echo $rec["title_thai"];?><?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?>
</a>
<br/>
<?php echo $U["position_person"]; ?>
<br/>
อีเมล์ : <?php echo $U['email_person']; ?>
<br/>
เบอร์โทรศัพท์  : <?php echo $U['tel_in']; ?>
</span></font>
<?php } ?>
</div>
</td>
<?php 
					$x++;
					if($x%3 == 0){
						echo "</tr></table><br>";
					}
				} 
				if($x%3==1 OR $x%3==2){
					echo "</tr></table><br>";
				}
?>
</td>
</tr>
</table>
	<?php 
		}
		//echo "SELECT * FROM gen_user  WHERE gen_user.org_id = '".$R["org_id"]."' and posittion = '' order by level_id ASC,org_type_id DESC,name_thai  ASC ";
		$sql_position2 = $db->query("SELECT * FROM gen_user  WHERE gen_user.org_id = '".$R["org_id"]."' and posittion = '' order by level_id ASC,org_type_id DESC,name_thai  ASC ");
		if($db->db_num_rows($sql_position2) >0){
	?>
	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="2">
		<tr><td align="center" bgcolor="<?php if($R[org_color] != ''){ echo $R[org_color];}else{ echo "#F7F7F7";} ?>"><font size="1"  face="MS Sans Serif"><b><span class="text_normal"><?php echo $text_genchat_lblstaff; ?></span></b></font></td></tr>
		<tr><td align="center" >&nbsp;</td></tr>
		<?php
			///while($P2 = $db->db_fetch_array($sql_position2)){
		?>
		<tr>
			<td>
			<?php
				$sql_user2 = $db->query("SELECT * FROM gen_user WHERE  gen_user.org_id = '".$R["org_id"]."' and posittion = '' order by  level_id ASC,org_type_id DESC,display_order  ASC ");
				$x=0;
				while($U2 = $db->db_fetch_array($sql_user2)){
				$sql_title2 = "SELECT title_thai,title_eng FROM title where title_id = '$U2[title_thai]'";
					$query_title2 = $db->query($sql_title2);
					$rec2 = $db->db_fetch_array($query_title2);

					$path_image=$U2[path_image];
					if($path_image != ''){
						$path_image22 = $uploaddir.$path_image;
						if(file_exists($path_image22)){
							$path_image2 = $path_image22;
						}else{
							$path_image2 = "../images/ImageFile.gif";
						}
					}else{
						$path_image2 = "../images/ImageFile.gif";
					}
					if($x%3 == 0){
						echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
					}
					/*if($U["path_image"] != ""){
					$path1 = eregi_replace("../pic_upload/","",$U2["path_image"]);
					$path = "../dmr_profile/pic_upload/".$path1;
					}else{
					$path = "../../images/ImageFile.gif";
					}*/
					if($lang_sh != ''){
					$U2["name_thai"] = select_lang_detail_ewt($U2[gen_user_id],$lang_shw,'name_thai','gen_user');
					$U2["surname_thai"] = select_lang_detail_ewt($U2[gen_user_id],$lang_shw,'surname_thai','gen_user');
					$U2["position_person"] = select_lang_detail_ewt($U2[gen_user_id],$lang_shw,'position_person','gen_user');
					}
?>
<td align="center" valign="top" width="33%">
<?php if($spic == "Y"){ ?>
<img src="img.php?p=<?php echo base64_encode($path_image2); ?>" width="98" height="98" align="absmiddle">
<?php } ?>
<?php if($sname == "Y"){ ?>
<div><font size="2"><span class="text_normal">
<a href="person_detail.php?pid=<?php echo $U2['gen_user_id']; ?>">
<?php echo $rec2["title_thai"];?><?php echo $U2["name_thai"]; ?> <?php echo $U2["surname_thai"]; ?>
</a>
<br/>
ตำแหน่ง : <?php echo $U2["position_person"]; ?>
<br/>
อีเมล์ : <?php echo $U2['email_person']; ?>
<br/>
เบอร์โทรศัพท์  : <?php echo $U2['tel_in']; ?>
</span></font>
<?php } ?>
</div>
</td>
			<?php 
					$x++;
					if($x%3 == 0){
						echo "</tr></table><br>";
					}
				} 
				if($x%3==1 OR $x%3==2){
					echo "</tr></table><br>";
				}
			?>
			</td>
		</tr>
		<?php //} ?>
	</table>
	<?php 
			}
		} else if($type == "0") {
	?>
	<script language="JavaScript">
		function divshow(c,d){
			if(c.style.display == ""){
				c.style.display = 'none';
				d.src = "mainpic/plus.gif";
			}else{
				c.style.display = '';
				d.src = "mainpic/minus.gif";
			}
		}
		function divshow1(c){
			win5 = window.open('ewt_org.php?oid='+c+'&sh=<?php echo $lang_shw;?>&org=<?php echo $org; ?>','org','height=500,width=600,resizable=1,scrollbars=1');
			win5.focus();
		}
	</script>
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr><td>&nbsp;</td></tr>
	</table>
	<table width="98%" border="0" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
		<tr> 
			<td>
				<?php
					$sql_group1 = $db->query("SELECT parent_org_id FROM org_name WHERE org_id = '".$org_id."' ");
					$R1 = $db->db_fetch_array($sql_group1);
					
					$sql_group = $db->query("SELECT * FROM org_name WHERE parent_org_id LIKE '".$R1["parent_org_id"]."%' ORDER BY parent_org_id ASC");
					$i = 0;
					$k = 0;
					$LenChk =0;
					while($R = $db->db_fetch_array($sql_group)){
					if($lang_sh != ''){
					$R["name_org"] = select_lang_detail_ewt($R[org_id],$lang_shw,'name_org','org_name');
					}
						$sql_sub = $db->query("SELECT COUNT(org_id) FROM org_name WHERE parent_org_id LIKE '".$R["parent_org_id"]."_%'");
						$count_sub = $db->db_fetch_row($sql_sub);
						$len = GenLen($R["parent_org_id"],"_");
						if($LenChk > $len ){
							for($y=$len;$y<$LenChk;$y++){
								echo "</div>";
							}
						}
						$LenChk = $len;
				?>
				<div>
				<?php
						GenPic2($R["parent_org_id"]);
						if($count_sub[0] > 0){ 
				?>
				<img src="../../images/minus.gif" border="0" align="absmiddle" onClick="divshow(document.all.dv<?php echo $i; ?>,this)">
				<?php 
						}else{ 
				?>
				<img src="../../images/o.gif" width="20" height="20" border="0" align="absmiddle">
				<?php 
						} 
				?>
				<img src="../../images/user_group.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<a href="#show" onClick="divshow1('<?php echo $R["org_id"]; ?>')"><span class="text_normal"><?php echo $R["name_org"]; ?></span></a>      </div>
				<?php
						$k++;
						if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  >"; }  
						$i++; 
					} 
				?>
				</div>
			</td>
		</tr>
	</table>
	<?php
		} else if($type == "2") {
		if(isset($_GET['org_id'])) {
			$org_id = $_GET['org_id'];
		}
		global $filename;
		global $staff_flag;
	?>
	<script type="text/javascript" src="js/jquery/jquery.corner.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.dimensions.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.dropshadow.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.gradient.js"></script>
	<script language="javascript">
	$(document).ready( function() {
		//$(".childOrg").dropShadow({left: 8, top: 8, blur: 3, opacity: 0.6});
		$('.gradient').gradient({
			from:      'AAAAAA',
			to:        'FFFFFF',
			direction: 'horizontal'
		});
		$(".childOrg").corner("10px");
	});
	</script>
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table width="98%" border="0" align="center"   cellpadding="0" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
		<tr> 
			<td><br />
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php
					
					$sql_group2 = $db->query("SELECT * FROM org_name where org_id = '".$org_id."' ORDER BY parent_org_id ASC");
					$R2 = $db->db_fetch_array($sql_group2);
					$logo = "img.php?p=".base64_encode("../../MemberMgt/pic_org/".$R2[org_pics]);
					$map = "../../MemberMgt/pic_org/".$R2[org_map];
					$area = "../../MemberMgt/pic_org/".$R2[org_area];
					if($R2["org_color"] == '') { $R2["org_color"] = '#FFFFFF'; }
					if($R2[org_pics] != ''){ $logo = $logo; } else { $logo = "img.php?p=".base64_encode("mainpic/no_pic_2.gif"); }
					if($R2[org_map] != ''){ $map = "<a href=\"img.php?p=".base64_encode($map)." target=\"_blank\"> $text_genchat_map".$R2[name_org]."</a>"; } else { $map = ""; }
					if($R2[org_area] != ''){ $area =  "<a href=\"img.php?p=".base64_encode($area)." target=\"_blank\"> $text_genchat_place".$R2[name_org]."</a>"; } else { $area = ""; }
					$sql_child = $db->query("SELECT * FROM org_name where parent_org_id LIKE '".$R2["parent_org_id"]."\_____' ORDER BY parent_org_id ASC");
					$child = $db->db_num_rows($sql_child);
					if($child == 0) {
					$staff_flag=1;
					}	
					$org_code = explode("_", $R2["parent_org_id"]);
					if(count($org_code) == 1) {
						$parent = 0;
					} else {
						$parent = 1;
						$code = array_pop($org_code);
						$parent_code = implode("_", $org_code);
						$sql_parent = $db->query("SELECT * FROM org_name where parent_org_id = '".$parent_code."'");
						$row_parent = $db->db_fetch_array($sql_parent);	
					}
								if($lang_sh != ''){
								$R2["name_org"] = select_lang_detail_ewt($R2[org_id],$lang_shw,'name_org','org_name');
								}
				?>
				<?php
				if($parent) {
					echo '
					<tr>
						<td align="center" valign="top">
							<table width="300" border="0" cellspacing="0" cellpadding="0">
								<tr><td align="center" valign="middle"><a href="?org_id='.$row_parent['org_id'].'&filename='.$filename.'"><img src="img.php?p='.base64_encode("mainpic/navigate_open.gif").'" border="0" align="absmiddle"></a></td></tr>
							</table>
						</td>
					</tr>';
				}
				?>
					<tr>
						<td align="center" valign="top">
							<table width="300" border="0" cellspacing="0" cellpadding="0" style="padding:0px 0px 0px 0px; border:1px solid #000000;" height="80" bgcolor="<?php echo $R2["org_color"];?>" class="childOrg">
								<tr><td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
																			<tr>
																				<td align="center" valign="middle"><div style="width=100%; height=100%" class="gradient"><table width="100%" border="0" cellspacing="0" cellpadding="1" height="100%">
																			<tr>
																				<td align="center" valign="middle">
													<!--<img src="<?php echo $logo;?>" border="0" align="absmiddle"><br /><br /> -->
													<strong><?php echo $R2["name_org"]; ?></strong>
												</td></tr></table></div></td></tr>
							</table></td></tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" valign="top">
							<table width="300" border="0" cellspacing="0" cellpadding="0">
								<tr><td align="center" valign="middle"><img src="img.php?p=<?php echo base64_encode("mainpic/horizonline.gif"); ?>" width="11" height="20" border="0" align="absmiddle"></td></tr>
							</table>
						</td>
					</tr>
					<?php
						echo genOrgChart2($R2["parent_org_id"]);/*
						$sql_group = $db->query("SELECT * FROM org_name where parent_org_id LIKE '".$R2["parent_org_id"]."\_____' ORDER BY parent_org_id ASC");
						while($R = $db->db_fetch_array($sql_group)){
						//echo genOrgChart($R["parent_org_id"]);
						}*/
					?>
				</table><br />
			</td>
		</tr>
	</table>
	<br />
<?php
	} else if($type == "3") {
	global $mainwidth;
	?>
	<script type="text/javascript" src="js/jquery/jquery.corner.js"></script>
	<script language="javascript">
		$(document).ready(function(){
			$(".orgchartperson").corner("10px");
		});
	</script>
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table width="98%" border="0" bgcolor="#FFFFFF" align="center" cellpadding="0" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
		<tr> 
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php
					
					$sql_position_id = "select min(pos_level), pos_id from position_name group by pos_id";
					//echo $sql_position_id.'<hr>';
					$query_position_id = $db->query($sql_position_id);
					$result_position_id = $db->db_fetch_array($query_position_id);
					$position_level = $result_position_id[0];
					$position_id= $result_position_id[1];
					$sql_current_pos = "select * from position_name where pos_id = '".$position_id."'";
					//echo $sql_current_pos.'<hr>';
					$query_current_pos = $db->query($sql_current_pos);
					$result_current_pos = $db->db_fetch_array($query_current_pos);
					$position_level = $result_current_pos['pos_level'];
					$sql_staff = "select * from gen_user LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) where gen_user.posittion = '".$position_id."' ";
					//echo $sql_staff.'<hr>';
					$query_staff = $db->query($sql_staff);
				?>
					<tr>
				<?php
					while($result_staff = $db->db_fetch_array($query_staff)) {
						$sql_order = "select * from gen_user_order where gen_user_id = '".$result_staff['gen_user_id']."'";
						$query_order = $db->query($sql_order);
						$sql_title = "select * from title where title_id = '".$result_staff['title_thai']."'";
						$query_title = $db->query($sql_title);
						$result_title = $db->db_fetch_array($query_title);
						$sql_position_staff = "select * from position_name where pos_id = '".$result_staff['posittion']."'";
						$query_position_staff = $db->query($sql_position_staff);
						$result_position_staff = $db->db_fetch_array($query_position_staff);
						if($result_staff[path_image] != ""){
							$path_image= "../pic_upload/".$result_staff[path_image];
							if (file_exists($path_image)) {
								$path_image=$path_image;
							}else{
								$path_image="../images/ImageFile.gif";
							}
						}
					if($lang_sh != ''){
					$result_position_staff['pos_name'] = select_lang_detail_ewt($result_position_staff['pos_id'],$lang_shw,'pos_name','position_name');
					$result_title['title_thai'] = select_lang_detail_ewt($result_title['title_id'],$lang_shw,'title_thai','title');
					$result_staff['name_thai'] = select_lang_detail_ewt($result_staff['gen_user_id'],$lang_shw,'name_thai','gen_user');
					$result_staff['surname_thai'] = select_lang_detail_ewt($result_staff['gen_user_id'],$lang_shw,'surname_thai','gen_user');
						if($result_staff['name_thai'] ==''){
						$result_title['title_thai']  =='';
						}
					}
				?>
						<td align="center" valign="top">
							<table width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td align="center" valign="middle">
										<table width="<?php echo ($mainwidth-300)/2;?>px" height="120px" border="0" cellspacing="0" cellpadding="0" class="orgchartperson" style="border:1px solid #FAC663; background-color:#FFF3D9;">
											<tr>
												<td align="center" valign="middle">
													<div style="margin:5px 5px 5px 5px">
													<img src="img.php?p=<?php echo base64_encode($path_image); ?>" name="previewField" width="80" height="80" id="previewField" style="border:1px solid #555;" />
													</div>
												</td>
											</tr>
											<tr>
												<td align="center" valign="middle" height="25"><strong><?php echo $result_position_staff['pos_name']?></strong></td>
											</tr>
											<tr>
												<td align="center" valign="middle" height="25"><nobr>&nbsp;<a href="person_detail.php?pid=<?php echo $result_staff['gen_user_id']; ?>">(<?php echo $result_title['title_thai']; ?><?php echo $result_staff['name_thai']; ?>&nbsp;<?php echo $result_staff['surname_thai']; ?>)</a>&nbsp;</nobr><br/><nobr>อีเมล์ : <?php echo $result_staff['email_person']; ?></nobr></td>
											</tr>
										</table>
									</td>
								</tr>
								<?php
									$sql_child = $db->query("select * from gen_user_order where up_user_id = '".$result_staff["gen_user_id"]."' order by order_no asc");
									$child = $db->db_num_rows($sql_child);	
									if($child > 0) {
										echo '
								<tr>
									<td align="center"><img src="img.php?p='.base64_encode("mainpic/horizonline.gif").'" width="11" height="13" border="0" align="absmiddle"></td>
								</tr>';
									}
									echo genOrgChart($result_staff['gen_user_id']);
								?>
							</table>
						</td>
				<?php
					}
				?>
					</tr>
				</table>
				<div id="lightbox" style="display:none"></div>
			</td>
		</tr>
	</table>
	<br />
<?php
	}else if($type == "4") {
	
	?>
	<DIV id="show_org_list<?php echo $org;?>">
	</DIV>
	<script language="javascript1.2">
	show_org_list('<?php echo $org;?>');
	</script>
	<?php
	}
	if($_SESSION["EWT_SDB"] != ""){
		$db->query("USE ".$_SESSION["EWT_SDB"]);
	}else{
		global $EWT_DB_NAME;
		$db->query("USE ".$EWT_DB_NAME);
	}
}

function GenPoll($text_id,$BID){
	global $db;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;


	$lang_c = explode('_',$lang_sh);
	@include("language/language".$lang_sh.".php");
	$date_poll_now = date("Y-m-d H:i:s");
	$time_poll_now = date("H:i:s");
	$q_date = "and ((('$date_poll_now' between c_start and c_stop) or (c_start = '' and c_stop = '')))";
	//$q_date .= "and (('$time_poll_now' between c_timestart and c_timestop) or (c_timestart = '' and c_timestop = '')))";
	if($lang_sh != ''){

		$PollSel = $db->query("SELECT * FROM poll_cat 
		INNER JOIN lang_poll ON poll_cat.c_id = lang_poll.c_id
		INNER JOIN lang_config ON lang_config.lang_config_id = lang_poll.lang_name
		WHERE lang_config.lang_config_suffix = '".$lang_c[1]."' AND lang_poll.c_id = '".$text_id."' AND lang_field ='c_name' and c_approve = 'Y' $q_date ");
	}
	else{
		$PollSel = $db->query("SELECT * FROM poll_cat WHERE  c_id = '".$text_id."' and c_approve = 'Y' $q_date");
	}
//echo "SELECT * FROM poll_cat WHERE  c_id = '".$text_id."' $q_date";
if($rows = $db->db_num_rows($PollSel)>0){
	$pollR = $db->db_fetch_array($PollSel);
	$polls = random_code(4);
	if($lang_sh != ''){
	$pollR[c_name] = $pollR[lang_detail];
	}
    if($pollR[c_start]==''){ 
		  $sdate=date('YmdHi');
	}else{
		$sdate=$pollR[c_start].$pollR[c_timestart];
	}
	if($pollR[c_stop]==''){ 
		$edate=date('YmdHi');
	}else{
		$edate=$pollR[c_stop].$pollR[c_timestop];
	}

	
	/*if($pollR[c_approve]!='Y'){
		$show = 0;
	}else{*/
		$show = 1;
		/*if(date('YmdHi')>=$sdate and date('YmdHi')<=$edate){ 
			$show = 1; 
		}else{
			$show = 0;
		}*/
	//}

	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != "" AND $show==1){
		$namefolder = "themes".($themeid);

		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		 //if($themes_type == 'F'){
 			$buffer = "";
			if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
 			     $fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
						$buffer .= @fgets($fd, 4096);
				 }
 				@fclose ($fd);
				$design = explode('<?php#htmlshow#?>',$buffer);
			 }

?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>

<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">

<table width="<?php echo $bg_width;?>"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
    <form name="PollForm<?php echo $polls; ?><?php echo $BID; ?>" onSubmit="return show_data_pollview<?php echo $polls; ?><?php echo $BID; ?>();" action="ewt_vote.php?lang_sh=<?php echo $lang_sh;?>" method=post target="">
	<tr>
      <td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"> <span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genpoll_head;?></span></font></span></td>
    </tr>
    <tr>
      <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td colspan="2"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo stripslashes($pollR[c_name]); ?></span></font></span></td>
          </tr>
			<?php 
			if($lang_sh != ''){
			$SelPoll = $db->query("SELECT * FROM poll_ans
									INNER JOIN lang_poll ON poll_ans.a_id = lang_poll.lang_field
									INNER JOIN lang_config ON lang_config.lang_config_id = lang_poll.lang_name
									WHERE lang_config.lang_config_suffix = '".$lang_c[1]."' AND  lang_poll.c_id = '$pollR[c_id]' ORDER BY a_id ASC "); 
			}else{
			$SelPoll = $db->query("SELECT * FROM poll_ans WHERE c_id = '$pollR[c_id]' ORDER BY a_id ASC"); 
			}
						while($pollAns = $db->db_fetch_array($SelPoll)){
			if($lang_sh != ''){$pollAns[a_name] = $pollAns[lang_detail];}
			?>
          <tr>
            <td colspan="2"><label>
              <INPUT type="radio" value="<?php echo $pollAns[a_id]; ?>" name="vote">
            <span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo stripslashes($pollAns[a_name]); ?></span></font></span></label></td>
          </tr>
		  <?php } ?>
          <tr>
            <td width="50%" align="center"><label>
			 <input type="hidden" name="flag">
			  <input type="Submit" name="submit"  value="<?php echo $text_genpoll_votesubmit ;?>"   onClick="document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.flag.value='0';   return chkPoll<?php echo $polls; ?>();"/>
            </label></td>
            <td width="50%" align="center"><label>
              <input type="Submit" name="views"  value="<?php echo $text_genpoll_submitvote;?>"  onclick="document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.flag.value='1'; ">
            </label><input name="cad_id" type="hidden" id="cad_id" value="<?php echo $pollR[c_id]; ?>"></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="<?php echo $bottom_height ;?>" background="<?php echo $Current_Dir1.$bottom_img;?>"   bgcolor="<?php echo $bottom_color;?>"></td>
    </tr>
    </form>
  </table>

  	</td>
     </tr>
</table>
 <?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php
}else if($show==1){
?>
<style type="text/css">
/*
.style2 {font-size: 11px;FONT-FAMILY: tahoma}
*/
</style>
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="f7f7f7">
    <form name="PollForm<?php echo $polls; ?><?php echo $BID; ?>" onSubmit="return show_data_pollview<?php echo $polls; ?><?php echo $BID; ?>();" action="ewt_vote.php?lang_sh=<?php echo $lang_sh;?>" method=post target="">
	<tr>
      <td><img src="mainpic/vote/head_vote.jpg" width="200" height="25" /></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td colspan="2"><span class="text_normal"><?php echo stripslashes($pollR[c_name]); ?></span><strong></strong></td>
          </tr>
			<?php if($lang_sh != ''){
			$SelPoll = $db->query("SELECT * FROM poll_ans
									INNER JOIN lang_poll ON poll_ans.a_id = lang_poll.lang_field
									INNER JOIN lang_config ON lang_config.lang_config_id = lang_poll.lang_name
									WHERE lang_config.lang_config_suffix = '".$lang_c[1]."' AND  lang_poll.c_id = '$pollR[c_id]' ORDER BY a_id ASC "); 
			}else{
			$SelPoll = $db->query("SELECT * FROM poll_ans WHERE c_id = '$pollR[c_id]' ORDER BY a_id ASC"); 
			}
						while($pollAns = $db->db_fetch_array($SelPoll)){
			if($lang_sh != ''){$pollAns[a_name] = $pollAns[lang_detail];}
			?>
          <tr>
            <td colspan="2"><label>
              <INPUT type="radio" value="<?php echo $pollAns[a_id]; ?>" name="vote">
            <span class="text_normal"><?php echo stripslashes($pollAns[a_name]); ?></span></label></td>
          </tr>
		  <?php } ?>
          <tr>
            <td width="50%" align="center"><label>
			<input type="hidden" name="flag">
			  <input type="image" name="imageField2" src="mainpic/vote/vote.gif"  onClick="document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.flag.value='0'; return chkPoll<?php echo $polls; ?>();"/>
            </label></td>
            <td width="50%" align="center"><label>
				<?php /*
              	<input type="image" name="imageField2" src="mainpic/vote/result.gif"  onclick="document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.flag.value='1';"/>
				*/ ?>
				<a href="javascript:void(0);" onclick="show_pollresult();"><img src="mainpic/vote/result.gif"></a>
				</label><input name="cad_id" type="hidden" id="cad_id" value="<?php echo $pollR[c_id]; ?>">
				
				<script language="javascript">
					function show_pollresult(){
						window.open("ewt_voteresult.php?c_id=<?php echo $pollR[c_id]; ?>&lang_sh=<?php echo $lang_c[1]; ?>","Vote Result", "width=800,height=500");
					}
				</script>
			</td>
         	
			</tr>
      </table></td>
    </tr></form>
  </table>
<?php } ?>
<iframe name="iframe_showpoll<?php echo $polls; ?><?php echo $BID; ?>" src="" frameborder="0" width="1" height="1" scrolling="no"></iframe>
	<script language="javascript">
		function show_data_pollview<?php echo $polls; ?><?php echo $BID; ?>(){
		var flag = document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.flag.value;
		
			if(flag == '0'){
			
				document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.target = "iframe_showpoll<?php echo $polls; ?><?php echo $BID; ?>";
				return true;
			}else if(flag == '1'){
				PollForm<?php echo $polls; ?><?php echo $BID; ?>.target = "PollVote";
				winPollVote = window.open('', 'PollVote', 'alwaysRaised=1,menuber=0,toolbar=0,location=0,directories=0,personalbar=0,scrollbars=1,status=0,resizable=1,width=550,height=410');
				winPollVote.focus();  
				return true;
			}
		}
		function chkPoll<?php echo $polls; ?>(){
			var x = 0;
				for (var i=0; i<document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.vote.length; i++) {
					if (document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.vote[i].checked) {
						var x = 1;
					 }
				 }
				if(x==0){
					alert("<?php echo $text_genpoll_alert;?>");
					return false;
				}else{
					return true;
				}
			}		
	</script>
<?php }

}
function GenENews($BID){
	global $filename;
	global $db;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;
	@include("language/language".$lang_sh.".php");
$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);

@include("themesdesign/".$namefolder."/".$namefolder.".php");
 //if($themes_type == 'F'){
 	$buffer = "";
	if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
 	   $fd = @fopen ($Current_Dir1.$themes_file, "r");
		while (!@feof ($fd)) {
			$buffer .= @fgets($fd, 4096);
		}
 		@fclose ($fd);
		$design = explode('<?php#htmlshow#?>',$buffer);
	}
?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">

<table id="tball" width="<?php echo $bg_width;?>"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
<form name="NewsLetterForm<?php echo $BID;?>" method="post" action="newsletter_function.php" onSubmit="return ChkValueNewsLetter<?php echo $BID;?>();">
   <tbody>
     <tr>
       <td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp;<?php echo $text_genenews_title;?></span></font></span></td>
      </tr>
     <tr>
       <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
         <tr>
           <td align="left" valign="top">
		    	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td height="10" align="center" >
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="33" align="center"><label>
              <input name="newsletteremail" type="text" id="newsletteremail" value="<?php echo $text_genenews_email;?>" onFocus="this.value='';">
            </label></td>
          </tr>
		  </table></td>
						</tr>
						<tr>
						  <td height="10" align="center" >
									<input name="applynewsletter" type="radio" value="Y" checked><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genenews_apply;?></span></font></span>
									<input type="radio" name="applynewsletter" value="N"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genenews_cancle;?></span></font></span>							</td>
						</tr>
						<tr>
						  <td align="center" height="<?php echo $bottom_height ;?>" background="<?php echo $Current_Dir1.$bottom_img;?>"   bgcolor="<?php echo $bottom_color;?>">
						 <input type="hidden" name="t" value="<?php echo $rec[block_themes];?>">
						 <input name="Button01" type="submit"  id="Button01" value="<?php echo $text_genenews_submit;?>">
						 <br><br>
						 </td>
						</tr>
				</table>		   </td>
         </tr>
       </table></td>
      </tr>
  </tbody>
  </form>
</table>
	</td>
     </tr>
</table>
<?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php
}else{
?>
<table id="tball" width="200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="f7f7f7">
<form name="NewsLetterForm<?php echo $BID;?>" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" 
onSubmit="return ChkValueNewsLetter<?php echo $BID;?>();">
   <tbody>
     <tr>
       <td height="20" align="center" ><img src="mainpic/enews/head_newsletter.jpg" width="200" height="25"></td>
      </tr>
     <tr>
       <td><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
         <tr>
           <td align="left" valign="top">
		    	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
						  <td height="15" align="center" ><span class="text_head"><?php echo $text_genenews_title;?></span></td>
						</tr>
						<tr>
							<td height="10" align="center" >
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="33" align="center" background="mainpic/login/form1.jpg"><label>
              <input name="newsletteremail" type="text" id="newsletteremail" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none; FONT-FAMILY: tahoma; border: thin solid #FFFFFF;border-top: 1px solid #D1D1D1; height: 20px; width: 150px;" value="<?php echo $text_genenews_email;?>" onFocus="this.value='';">
            </label></td>
          </tr>
		  </table></td>
						</tr>
						<tr>
						  <td height="10" align="center" >
									<input name="applynewsletter" type="radio" value="Y" checked><span class="text_normal"><?php echo $text_genenews_apply;?></span>
									<input type="radio" name="applynewsletter" value="N"><span class="text_normal"><?php echo $text_genenews_cancle;?></span>							</td>
						</tr>
						<tr>
						  <td align="center">
						  <input type="hidden" name="t" value="<?php echo $rec[block_themes];?>">
						  <input name="Button01" type="image" src="mainpic/ok.gif" id="Button01" value="<?php echo $text_genenews_submit;?>">						 </td>
						</tr>
				</table>		   </td>
         </tr>
       </table></td>
      </tr>
  </tbody>
  </form>
</table>
<?php } ?>
<script language="JavaScript">
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
}
function validEMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			//return false;
			if (mailObj.value.search("^.+@.+\\..+$") != -1)
				return true;
			else return false;
 		}
		return true;
}
function ChkValueNewsLetter<?php echo $BID;?>(){
	if(document.NewsLetterForm<?php echo $BID;?>.newsletteremail.value == ""){
		alert('<?php echo $text_genenews_alertemail;?>');
		document.NewsLetterForm<?php echo $BID;?>.newsletteremail.focus();
		return false;
	}else if(!validEMail(document.NewsLetterForm<?php echo $BID;?>.newsletteremail)){
		alert('<?php echo $text_genenews_alertemail_no;?>');
		document.NewsLetterForm<?php echo $BID;?>.newsletteremail.select();
		return false;
	}
	if(document.NewsLetterForm<?php echo $BID;?>.applynewsletter[1].checked){
		r = confirm("<?php echo $text_genenews_alertcancle;?>");
		if(r==true){
			return true;
		}else{
			return false;
		}
	}
}
</script>
<?php
}

function GenSurvey($BID){
global $db;
global $mainwidth;
global $global_theme;
global $EWT_DB_NAME,$EWT_DB_USER;
$sql = $db->query("select block_themes,block_link from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];

 $bg_width="84%";

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);

@include("themesdesign/".$namefolder."/".$namefolder.".php");
 //if($themes_type == 'F'){
 	$buffer = "";
if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
   $fd = @fopen ($Current_Dir1.$themes_file, "r");
	 while (!@feof ($fd)) {
		$buffer .= @fgets($fd, 4096);
	 }
 	@fclose ($fd);
	$design = explode('<?php#htmlshow#?>',$buffer);
 }
?>
<?php echo $design[0];
}
if($s_id != ""){
	$db->query("USE ".$EWT_DB_USER);
    $sqlu = "SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_MID"]."' AND status = '1' ";
	$queryu = $db->query($sqlu);
	$RU = $db->db_fetch_array($queryu);
	$mid = $RU["gen_user_id"];
	$morg = $RU["org_id"];
	//$mpos = $RU["posittion"];
	$db->query("USE  ".$EWT_DB_NAME);
	if($_SESSION["EWT_MID"]){
		$SQL2 = $db->query("SELECT * FROM p_survey_group WHERE s_id = '$s_id' and (sg_mid = '$mid' or sg_oid = '$morg') ");
		$allowUser = mysql_num_rows($SQL2);
	}
	global $filename;
	global $EWT_FOLDER_USER;
	global $lang_sh;
	@include("language/language".$lang_sh.".php");
	$Yn = date("Y")+543;
	$dn = date("m-d");
	$dn = $Yn."-".$dn;
	$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' and s_approve = 'Y' and ( '$dn' between s_start and s_end )");
	if(!$rows = mysql_num_rows($SQL1) and $allowUser==0){
		$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
		$PX = $db->db_fetch_array($SQLX);
		?>
		<script language="javascript">
			//window.location.href="<?php if($PX[start_page]!=""){ echo $PX[start_page]; }else{ echo "survey_error.php"; } ?>";
		</script>
		<?php
//exit;
	}else{
		if(getenv(HTTP_X_FORWARDED_FOR)){
			$IPn = getenv(HTTP_X_FORWARDED_FOR);
		}else{
			$IPn = getenv("REMOTE_ADDR");
		}
		$SQL11 = $db->query("SELECT * FROM p_ip WHERE p_id = '$s_id' and ip = '$IPn'");
		if($pasformgenerator == "Yes"){
		//if(mysql_num_rows($SQL11)>0){
			$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
			$PX = $db->db_fetch_array($SQLX);
		?>
			<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#660000">
			  <tr>
				<td align="center"  bgcolor="#FFBF80"><font size="2" face="Tahoma"><span class="text_normal"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genSurvey_warning;?></span></font></span></font></td>
			  </tr>
			</table>
<?php
//exit;
}else{
if($_SESSION["EWT_MID"]){
      $SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' and s_approve = 'Y' ");
}
$PR = $db->db_fetch_array($SQL1);
@include("survey_default.ewt");
?>
			<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" style="display:none" bgcolor="#660000" id="tbsuccess<?php echo $BID; ?>">
			  <tr>
				<td align="center"  bgcolor="#FFBF80"><font size="2" face="Tahoma"><strong><span class="text_normal"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genSurvey_waiting;?></span></font></span></strong></font></td>
			  </tr>
			</table>
<?php
$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");
?>
<form name="Surveyform<?php echo $BID; ?>" method="post" onSubmit="return GoNext();" action="survey_preview.php" enctype="multipart/form-data" ><!--survey_function.php?filename=<?php//php echo $filename; ?>-->
<div align="left"><br>
    <font color="<?php echo $SubjectMainC; ?>" size="<?php echo $SubjectMainS; ?>" face="<?php echo $SubjectMainF; ?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><?php if($SubjectMainB=="Y"){ echo "<b>"; } ?><?php if($SubjectMainI=="Y"){ echo "<em>"; } ?><?php echo $PR[s_title]; ?><?php if($SubjectMainI=="Y"){ echo "</em>"; } ?><?php if($SubjectMainB=="Y"){ echo "</b>"; } ?></font></font></div>

  <?php 
if($PR[file_page] != ""){
  ?>
<div align="left"><font  size="2" face="<?php echo $SubjectMainF; ?>"><a href="<?php echo $PR[file_page]; ?>" target="_blank"><?php echo $text_genSurvey_attachfile;?><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><?php echo $PR[file_page]; ?></font></a></font></div>
  <?php
  }	  
  while($R=$db->db_fetch_array($SQL)){  
  
  ?>
  <br>
	<?php
	if($R[c_gp] =="Y" ){
	?>
	<table border="0" width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
	  <tr>
	    <td colspan="<?php echo $R[option2]+2; ?>"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><?php if($SubjectPartB=="Y"){ echo "<b>"; } ?><?php if($SubjectPartI=="Y"){ echo "<em>"; } ?><?php echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><?php if($SubjectPartI=="Y"){ echo "</em>"; } ?><?php if($SubjectPartB=="Y"){ echo "</b>"; } ?></font></span>
	    <span style="font-size: <?php echo $head_font_size2;?><?php  if($head_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size: <?php echo $head_font_size2;?>"><?php if($DescPartB=="Y"){ echo "<b>"; } ?><?php if($DescPartI=="Y"){ echo "<em>"; } ?><?php  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><?php if($DescPartI=="Y"){ echo "</em>"; } ?><?php if($DescPartB=="Y"){ echo "</b>"; } ?></font></span></td>
      </tr>
		
	  <tr>
	    <td width="1%" rowspan="2" align="left" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName1; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	    <td width="50%" rowspan="2" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName2; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	    <td colspan="<?php echo $R[option2]; ?>" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName3; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	  </tr>
	<tr>
	    <?php
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		 while($Q = $db->db_fetch_array($SQL2)){  ?>		
	    <td align="left" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php if($Head2B=="Y"){ echo "<b>"; } ?><?php if($Head2I=="Y"){ echo "<em>"; } ?>
<?php echo $Q[a_name]; ?>
	    <?php if($Head2I=="Y"){ echo "</em>"; } ?><?php if($Head2B=="Y"){ echo "</b>"; } ?></span></font></td>
<?php } ?>	
	</tr>
	<?php $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = $db->db_fetch_array($SSS)){
	$qreg = explode('#zz#',$X[q_req]);
	$X[q_req] = $qreg[0];
	?>
		  <tr>		  
	    <td align="left" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php if($Question2B=="Y"){ echo "<b>"; } ?><?php if($Question2I=="Y"){ echo "<em>"; } ?>     
	      <?php echo $X[q_name]; ?><?php if($Question2I=="Y"){ echo "</em>"; } ?><?php if($Question2B=="Y"){ echo "</b>"; } ?></span></font><?php if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size:<?php echo $body_font_size2;?> <?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php if($Question2B=="Y"){ echo "<b>"; } ?><?php if($Question2I=="Y"){ echo "<em>"; } ?><?php echo $X[q_des]; ?><?php if($Question2I=="Y"){ echo "</em>"; } ?><?php if($Question2B=="Y"){ echo "</b>"; } ?></span></font> </td>
	   <?php
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		$a=0;
		 while($Q = $db->db_fetch_array($SQL2)){ ?>		
	    <td align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
		<?php if($R[option1]=="A"){ ?>
	      <input type="radio" name="ans<?php echo $X[q_id]; ?>" value="<?php echo $Q[a_name]; ?>" >
		  <?php }else{ ?>
	      <input type="checkbox" name="ans<?php echo $X[q_id]; ?>_<?php echo $a; ?>" value="<?php echo $Q[a_name]; ?>" >
		  <?php } ?>
	    </td>
<?php
$a++;
 } ?>
	  </tr>
<?php } ?>	  	
  </table>
	<?php 
	}else{
	?>
<table border="0" width="<?php echo $bg_width;?>" align="center" cellpadding="0" cellspacing="0"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
	  <tr bgcolor="<?php echo $SubjectPartBGC; ?>">
	    <td colspan="2"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><?php if($SubjectPartB=="Y"){ echo "<b>"; } ?><?php if($SubjectPartI=="Y"){ echo "<em>"; } ?><?php echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><?php if($SubjectPartI=="Y"){ echo "</em>"; } ?><?php if($SubjectPartB=="Y"){ echo "</b>"; } ?></font>
	    <font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size:<?php echo $head_font_size2;?>"><?php if($DescPartB=="Y"){ echo "<b>"; } ?><?php if($DescPartI=="Y"){ echo "<em>"; } ?><?php  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><?php if($DescPartI=="Y"){ echo "</em>"; } ?><?php if($DescPartB=="Y"){ echo "</b>"; } ?></span></font></td>
    </tr>
	<?php $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = $db->db_fetch_array($SSS)){
	$qreg = explode('#zz#',$X[q_req]);
	$X[q_req] = $qreg[0];
	?>		
	  <tr >
	    <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"  nowrap><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php if($Question1B=="Y"){ echo "<b>"; } ?><?php if($Question1I=="Y"){ echo "<em>"; } ?><?php echo $X[q_name]; ?>  <?php if($Question1I=="Y"){ echo "</em>"; } ?><?php if($Question1B=="Y"){ echo "</b>"; } ?></span></font> <?php if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td width="100%" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">	      
	      <font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php if($Question1B=="Y"){ echo "<b>"; } ?><?php if($Question1I=="Y"){ echo "<em>"; } ?><?php echo $X[q_des]; ?><?php if($Question1I=="Y"){ echo "</em>"; } ?><?php if($Question1B=="Y"){ echo "</b>"; } ?></span></font> 
        </td>
    </tr>

		  <tr >		  
	    <td width="143" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">&nbsp;</td>
	    <td  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><div align="left"><font color="<?php echo $Answer1C; ?>" size="<?php echo $Answer1S; ?>" face="<?php echo $Answer1F; ?>"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>"><span style="font-size:<?php echo $body_font_size2;?>"><?php if($Answer1B=="Y"){ echo "<b>"; } ?><?php if($Answer1I=="Y"){ echo "<em>"; } ?>
			<?php	
			$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
			if($X[q_anstype]=="D"){ 
			if($RrRows = mysql_num_rows($SSS1)){
			$Z = $db->db_fetch_array($SSS1);
			if($Z[a_other]=="S"){  ?>
			<input name="ans<?php echo $X[q_id]; ?>" type="text" <?php if($Z[option4] != ""){ echo " size=\"$Z[option4]\" ";}  if($Z[option3] != ""){ echo " maxlength=\"$Z[option3]\" ";} ?> value="<?php echo $Z[a_name] ?>">
	<?php		}else{ ?>
	<textarea name="ans<?php echo $X[q_id]; ?>" <?php if($Z[option4] != ""){ echo " cols=\"$Z[option4]\" ";}  if($Z[option3] != ""){ echo " rows=\"$Z[option3]\" ";} ?> wrap="VIRTUAL" ><?php echo $Z[a_name] ?></textarea>
<?php	}			
			}else{ ?>
			<textarea name="ans<?php echo $X[q_id]; ?>" cols="50" rows="3" wrap="VIRTUAL" id="ans<?php echo $X[q_id]; ?>"></textarea>
	<?php		}
			}elseif($X[q_anstype]=="A"){
			$p=0;
	while($Z = $db->db_fetch_array($SSS1)){
		$answer_ex = explode("#@form#img@#",$Z[a_name]);
	?>
		<input name="ans<?php echo $X[q_id]; ?>" type="radio" value="<?php echo $Z[a_name]; ?>" <?php if($Z[option4] == "Y"){  echo "checked"; } ?>> 
		<?php 
			  if($answer_ex[1] != ""){
	  echo "<img src=\"".$answer_ex[1]."\"  align=\"absmiddle\">";
	  }
		echo $answer_ex[0]; ?>
		<?php if($Z[a_other]=="Y"){ ?> <input name="oth<?php echo $X[q_id]; ?>_<?php echo $p; ?>" type="text">  
		<?php } ?><br>
		
		<?php $p++; }
		}elseif($X[q_anstype]=="B"){
		$p = 0;
while($Z = $db->db_fetch_array($SSS1)){
	$answer_ex = explode("#@form#img@#",$Z[a_name]);
	?>
		<input name="ans<?php echo $X[q_id]; ?>_<?php echo $p; ?>" type="checkbox" value="<?php echo $Z[a_name]; ?>" <?php if($Z[option4] == "Y"){  echo "checked"; } ?>> 
		<?php 
			  if($answer_ex[1] != ""){
	  echo "<img src=\"".$answer_ex[1]."\"  align=\"absmiddle\">";
	  }
		echo $answer_ex[0]; ?>
		<?php if($Z[a_other]=="Y"){ ?>  <input name="oth<?php echo $X[q_id]; ?>_<?php echo $p; ?>" type="text">  
		<?php } ?><br>
		
		<?php $p++;  }		
		}elseif($X[q_anstype]=="C"){ ?>
		<select name="ans<?php echo $X[q_id]; ?>" >
<?php while($Z = $db->db_fetch_array($SSS1)){
			$answer_ex = explode("#@form#img@#",$Z[a_name]);
	?>
		 <option value="<?php echo $answer_ex[0]; ?>" <?php if($Z[option4] == "Y"){  echo "selected"; } ?>><?php echo $answer_ex[0]; ?></option>
		
		<?php } ?>
		</select>
		<?php		
		}else if($X[q_anstype]=="E"){
		if($RrRows = mysql_num_rows($SSS1)){
			$Z = $db->db_fetch_array($SSS1);?>
			ไฟล์แนบ<?php echo $Z[a_name]; ?><br>
			<input type="file" name="file<?php echo $X[q_id]; ?>"><br>
ท่านสามารถใส่ไฟล์แนบได้ไม่เกิน <?php echo number_format($Z[a_other],0); ?> KB.
	<?php		}
		}else if($X[q_anstype]=="F"){
		?>
		<input name="start_date<?php echo $X[q_id]; ?>"  readonly="" type="text" size="15" value="<?php echo date("d")."/".date("m")."/".(date("Y")+543); ?>">
             <a href="#date" onClick="return showCalendar('start_date<?php echo $X[q_id]; ?>', 'dd-mm-y');" ><img src="mainpic/b_calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>
		<?php
		}else if($X[q_anstype]=="G"){
		genjava_ddwlist1call2 ("SELECT p_code, a_code, a_name FROM   amphur","p_code","a_name","a_code",1,'Y',"- เลือกอำเภอ-                            ");
		
		?>
		
		<table width="500"  border="0" cellspacing="1" cellpadding="1">
                            <tr>
                              <td > จังหวัด </td>
                              <td ><select name="addr_prov<?php echo $X[q_id];?>"  id="addr_prov<?php echo $X[q_id];?>"  
															onChange="
																selectChange(this, document.getElementById('addr_amp<?php echo $X[q_id];?>'), arrItemsTxt1,arrItemsValue1,arrItemsGrp1,'');
																document.getElementById('addr_tamb<?php echo $X[q_id];?>').value='';
																">
                                <option value="" selected>- เลือกจังหวัด -
                                  <?php echo $tab.' '.$tab?>
                                  </option>
                                <?php
								$db->query("USE ".$EWT_DB_USER);
								$sql_province = "select * from province ORDER BY p_name ASC";
								$query_province = $db->query($sql_province);
								while($rec_province = $db->db_fetch_array($query_province)){
								?>
								<option value="<?php echo $rec_province[p_code];?>"><?php echo $rec_province[p_name];?></option>
								<?php
								}
								$db->query("USE ".$EWT_DB_NAME);
								?>
                              </select>                                        </td>
                              <td >อำเภอ</td>
                              <td ><select name="addr_amp<?php echo $X[q_id];?>"  id="addr_amp<?php echo $X[q_id];?>"
															onFocus="
																if(document.getElementById('addr_prov<?php echo $X[q_id];?>').value==''){
																	alert('กรุณาเลือกจังหวัด'); 
																	document.getElementById('addr_prov<?php echo $X[q_id];?>').focus();
																}"
																onChange="
																txt_area( document.getElementById('addr_prov<?php echo $X[q_id];?>').value,this.value,'<?php echo $X[q_id];?>');
																"
															>
                                <option value="">- กรุณาเลือกอำเภอ -
                                  <?php echo $tab.$tab.$tab?>
                                  </option>
                                 
                              </select>                                              </td>
                            </tr>
                            <tr>
                              <td > ตำบล</td>
                              <td ><div id="nav<?php echo $X[q_id];?>" >
								<select name="addr_tamb<?php echo $X[q_id];?>"  id="addr_tamb<?php echo $X[q_id];?>"
															onFocus="
																if(document.getElementById('addr_amp<?php echo $X[q_id];?>').value==''){
																	alert('กรุณาเลือกอำเภอ'); 
																}"
															>
                                <option value="">- กรุณาเลือกตำบล-
                                  <?php echo $tab.$tab.$tab?>
                                  </option>
                              </select></div></td>
                              <td >&nbsp;</td>
                              <td >&nbsp;</td>
                            </tr>
                          </table>
		<?php
		}
		?>
		<?php if($Answer1I=="Y"){ echo "</em>"; } ?><?php if($Answer1B=="Y"){ echo "</b>"; } ?></span></font></font></div></td>

	  </tr>
<?php } ?>	  	
  </table>	
	<?php } ?>
  <?php } ?><br>

  <table border="0" width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" >
  <tr>
    <td >      <div align="right">
        <input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id; ?>">
        <input name="user_mail" type="hidden" id="user_mail" value="">
		<input name="mid" type="hidden" id="mid" value="<?php echo $mid; ?>">
		<input name="BID" type="hidden" id="BID" value="<?php echo $BID; ?>">
        <input name="filename" type="hidden" id="filename" value="<?php echo $filename; ?>">
		<input name="setflag" type="hidden" id="setflag" value="0">
		<input type="submit" name="Submit" value="<?php echo $text_genSurvey_submit_but?>">
        <input type="reset" name="Submit2" value="<?php echo $text_genSurvey_reset_but?>">
      </div></td></tr>
</table>

</form>
<?php echo $design[1]; ?>
<script language="javascript">
function GoNext(){

<?php
$SSSS = $db->query("SELECT * FROM p_question,p_cate WHERE p_cate.s_id='$s_id' AND p_cate.c_id = p_question.c_id AND (p_question.q_req = 'Y' OR p_question.q_req = 'E' OR p_question.q_req = 'N') AND p_question.q_anstype != 'B' AND p_cate.option1 != 'B' ");
if($gg = mysql_num_rows($SSSS)){
while($TT = $db->db_fetch_array($SSSS)){

if($TT[q_anstype]=="D"){
$qreg = explode('#zz#',$TT[q_req]);
if($qreg[1] == 'N'){
//$qreg[0] = '';
$qreg[1] = 'N';
}
if($qreg[1] == 'E'){
//$qreg[0] = '';
$qreg[1] = 'E';
}
if( $qreg[0]== "Y"){//$TT[q_req]
?>
if(document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
<?php
}
if($qreg[1]== "E" && $qreg[0]== "Y"){
?>
 	if(document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value == ""){
		alert('<?php echo $text_genSurvey_alertmail1;?>ข้อที่<?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?> ');
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].focus();
		return false;
	}else if((document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value.search("^.+@.+\\..+$") == -1)){
		alert('<?php echo $text_genSurvey_alertmail1;?>ข้อที่<?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>');
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].select();
		return false;
	}
<?php
}elseif($qreg[1]== "E" && $qreg[0]!= "Y"){
?>
 	if(document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value != "" && (document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value.search("^.+@.+\\..+$") == -1)){
		alert('<?php echo $text_genSurvey_alertmail1;?>ข้อที่<?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>');
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].focus();
		return false;
	}
<?php
}
if($qreg[1]== "N" && $qreg[0]== "Y"){
?>
 	if(document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value == ""){
		alert('กรุณากรอกข้อมูลข้อที่<?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>');
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].focus();
		return false;
	}else if(isNaN(document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value)){
		alert('กรุณากรอกข้อมูลเป็นตัวเลขข้อที่<?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>');
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].select();
		return false;
	}
<?php
}elseif($qreg[1]== "N" && $qreg[0]!= "Y"){
?>
 	if(document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value != "" && isNaN(document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value)){
		alert('กรุณากรอกข้อมูลเป็นตัวเลขข้อที่<?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>');
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].focus();
		return false;
	}
<?php
}
}elseif(($TT[q_anstype]=="A")or($TT[q_anstype]=="")){
?>
var x = 0;
for (var i=0; i<document.Surveyform<?php echo $BID; ?>.ans<?php echo  $TT[q_id]; ?>.length; i++) {
         if (document.Surveyform<?php echo $BID; ?>.ans<?php echo  $TT[q_id]; ?>[i].checked) {
            var x = 1;
         }
      }
	if(x==0){
	alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
	document.Surveyform<?php echo $BID; ?>.ans<?php echo  $TT[q_id]; ?>[0].focus();
	return false;
	}  
	<?php
}else if($TT[q_anstype]=="E"){
if($TT[q_req] == "Y"){
?>
if(document.Surveyform<?php echo $BID; ?>.elements["file"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["file"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
<?php
}


}else if($TT[q_anstype]=="F"){
if($TT[q_req] == "Y"){
?>
if(document.Surveyform<?php echo $BID; ?>.elements["start_date"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["start_date"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
<?php
}
}else if($TT[q_anstype]=="G"){
if($TT[q_req] == "Y"){
?>
if(document.Surveyform<?php echo $BID; ?>.elements["addr_prov"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["addr_prov"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
if(document.Surveyform<?php echo $BID; ?>.elements["addr_amp"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["addr_amp"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
if(document.Surveyform<?php echo $BID; ?>.elements["addr_tamb"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["addr_tamb"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
<?php
}
}
}}
?>
if(document.Surveyform<?php echo $BID; ?>.setflag.value == "1"){
Surveyform<?php echo $BID; ?>.target = "_self";
Surveyform<?php echo $BID; ?>.enctype = "multipart/form-data";
Surveyform<?php echo $BID; ?>.action = "survey_function.php";
Surveyform<?php echo $BID; ?>.submit();
}else{ 
Surveyform<?php echo $BID; ?>.target = "ewt<?php echo $BID; ?>ewt";
Surveyform<?php echo $BID; ?>.enctype = "multipart/form-data";
window.open("","ewt<?php echo $BID; ?>ewt","scrollbars=1,resizable=1");
Surveyform<?php echo $BID; ?>.action = "survey_preview.php";
Surveyform<?php echo $BID; ?>.submit();
}
}

	</script>

<?php
}
}
	}
}
function  genjava_ddwlist1call2 ($sql,$fieldGrp,$fieldTxt,$fieldValue,$ddwlistNum,$showFunc,$firstField) {
global $db,$EWT_DB_NAME,$EWT_DB_USER;
$db->query("USE ".$EWT_DB_USER);
								
								
		 //Use in page : onchange="selectChange(this, form1.sale_id, arrItemsTxt,arrItemsValue ,arrItemsGrp);"
		 $nl = "\n"; // New line
         echo '<SCRIPT LANGUAGE="JavaScript">'.$nl;
         echo '<!-- Begin '.$nl;
		 echo 'var arrItemsTxt'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsValue'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsGrp'.$ddwlistNum.' = new Array();'.$nl.$nl;
         //Create variable
		  $query         = $db->query ($sql);
		  $numRows  = $db->db_num_rows ($query);
          for ($i=0;$i < $numRows;$i++) {
          $result = $db->db_fetch_array ($query);
          echo 'arrItemsGrp'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldGrp].'";'.$nl;
          echo 'arrItemsTxt'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldTxt].'";'.$nl;
          echo 'arrItemsValue'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldValue].'";'.$nl;
		  }//for
		 // Java function
		 if ($showFunc=='Y') {
         echo $nl.'function selectChange(control, controlToPopulate, ItemArrayTxt,ItemArrayValue, GroupArray,selectedValue)'.$nl;
         echo '{'.$nl;
         echo 'var myEle ;'.$nl;
         echo 'var x ;'.$nl;
         echo '// Empty the second drop down box of any choices'.$nl;
		 echo 'for (var q=controlToPopulate.options.length;q>=0;q--) controlToPopulate.options[q]=null;'.$nl;
         echo '// ADD Default Choice - in case there are no values'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
		
		 if (!empty($firstField)) {
			  echo 'myEle.value=0;'.$nl;
			  echo 'myEle.text="'.$firstField.'";'.$nl;
			  echo 'controlToPopulate.add(myEle) ;'.$nl;
		 }
		 echo 'for ( x = 0 ; x < ItemArrayTxt.length  ; x++ )'.$nl;
         echo   '{'.$nl;
         echo '    if ( GroupArray[x] == control.value)'.$nl;
         echo '   {'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
         echo ' myEle.text = ItemArrayTxt[x] ;'.$nl;
		 echo ' myEle.value= ItemArrayValue[x] ;'.$nl;

		 echo 'if (ItemArrayValue[x]==selectedValue)'.$nl;
		 echo '   myEle.selected=true;'.$nl;
         echo '   controlToPopulate.add(myEle) ;'.$nl;
         echo '   }'.$nl;
         echo ' }'.$nl;
         echo '}'.$nl;
		 }
		 echo '//  End -->'.$nl;
		 echo '</SCRIPT>';
		 $db->query("USE ".$EWT_DB_NAME);
	 }


function GenCalendar($BID){
	global $db;
	global $filename;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;

	@include("language/language".$lang_sh.".php");
	$sql = $db->query("select block_themes,block_link from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
if($themeid != '0' && $themeid != ''){	// theme found
	$namefolder = "themes".($themeid);
	@include("themesdesign/".$namefolder."/".$namefolder.".php");
	 //if($themes_type == 'F'){
	$buffer = ''; $buffer2=''; $design='';
 	if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
		$buffer = "";
		$fd = @fopen ($Current_Dir1.$themes_file, "r");
		 while (!@feof ($fd)) {
			$buffer .= @fgets($fd, 4096);
		}
		@fclose ($fd);
		$design = explode('<?php#htmlshow#?>',$buffer);
	}
	 //body
	$content_background_color = $body_color;
	
	$content_font_color = $body_font_color; 
	$content_font_size = $body_font_size;
	$content_font_style = "normal"; 
	$content_font_weight = "normal"; 
	if($body_font_italic=='Y'){ $content_font_style = "italic";  }
	if($body_font_bold=='Y'){ $content_font_weight = "bold";  }

	$today_background_color = "#FFDB4F"; 
	$today_font_color = "#8B4513"; 
	$today_font_size = $body_font_size;
	$today_font_style = "normal"; 
	$today_font_weight = "normal"; 

	$info_background_color = "#FB9D15"; 
	//$info_background_color = "#F4F4F4"; 
	$info_font_color = "#3467FF"; 
	$info_font_size = $body_font_size; 
	$info_font_style = "normal"; 
	$info_font_weight = "bold"; 
	
	//head
	$head_background_color = $head_color; 
	$head_background_color2 = $Current_Dir1.$head_img;
	$head_font_color = $head_font_color; 
	$head_height = $head_height;
	 
	$head_font_size = $head_font_size; // month year on the top of calendar
	$head_font_style = "normal"; 
	$head_font_weight = "normal";
	if($head_font_italic=='Y'){ $head_font_style = "italic";  }
	if($head_font_bold=='Y'){ $head_font_weight = "bold";  }
	

	$days_head_background_color = "#EBECE2"; 
	$days_head_font_color = $body_font_color2; 
	$days_head_font_size = $head_font_size; 
	$days_head_font_style = "normal"; 
	$days_head_font_weight = "normal"; 
	if($body_font_italic2=='Y'){ $days_head_font_style = "italic";  }
	if($body_font_bold2=='Y'){ $days_head_font_weight = "bold";  }

	$table_border = 0; 
	$table_cellspacing = 1; 
	$table_cellpadding = 1; 
	$table_width = '100%'; 
	$table_height = '100%'; 

	$head_link_color = "#666666"; 
	$font_family = "Tahoma"; 
}else{	// no theme found hard-code it
	//$head_test = "<img src=\"mainpic/calendar/head_calendar.jpg\" />";
  $head_test = "";
	$content_background_color = "#EBECE2"; 
	$content_font_color = "#333333"; 
	$content_font_size = 11; 
	$content_font_style = "normal"; 
	$content_font_weight = "normal"; 

	$today_background_color = "#FFDB4F"; 
	$today_font_color = "#8B4513"; 
	$today_font_size = 11; 
	$today_font_style = "normal"; 
	$today_font_weight = "normal"; 

	$info_background_color = "#FB9D15"; 
	//$info_background_color = "#F4F4F4"; 
	$info_font_color = "#3467FF"; 
	$info_font_size = 11; 
	$info_font_style = "normal"; 
	$info_font_weight = "bold"; 

	$head_background_color = "#EBECE2"; 
	$head_background_color2 = '';
	$head_height = '';
	
	$head_font_color = "#8B4513"; 
	$head_font_size = 11; 
	$head_font_style = "normal"; 
	$head_font_weight = "normal"; 

	$days_head_background_color = "#EBECE2"; 
	$days_head_font_color = "#CD7305"; 
	$days_head_font_size = 11; 
	$days_head_font_style = "normal"; 
	$days_head_font_weight = "normal"; 

	$table_border = 0; 
	$table_cellspacing = 1; 
	$table_cellpadding = 1; 
	$table_width = '100%'; 
	$table_height = '100%'; 

	$head_link_color = "#666666"; 
	$font_family = "Tahoma"; 
	}
	if($rec[block_link]==""){
?>

<script language="javascript">
$(document).ready(function(){
		$('span.tips').cluetip({
							splitTitle: '|', 
							width: '370px',
							arrows: true, 
							dropShadow: false, 
							cluetipClass: 'jtip'}
						);
	});
/*$(document).ready(
	function() {
		var objDiv = document.getElementById("divCalendar<?php //echo $BID;?>");
		url='calendar.php?date='+date+'&BID='+BID+'&sh=<?php //echo $lang_sh;?>';
		AjaxRequest.get(
			{
				'url':url
				,'onLoading':function() { }
				,'onLoaded':function() { }
				,'onInteractive':function() { }
				,'onComplete':function() { }
				,'onSuccess':function(req) { 
						objDiv.innerHTML = req.responseText; 
						$('span[@title]').cluetip({
							splitTitle: '|', 
							width: '370px',
							arrows: true, 
							dropShadow: false, 
							cluetipClass: 'jtip'}
						);
				}
			}
		);
	}
);
*/
function change_calendar<?php echo $BID;?>(date,BID) {
		var objDiv = document.getElementById("divCalendar"+BID);
		url='calendar.php?date='+date+'&BID='+BID+'&sh=<?php echo $lang_sh;?>';
		AjaxRequest.get(
			{
				'url':url
				,'onLoading':function() { 
						objDiv.innerHTML = '<table cellspacing="0" cellpadding="0" width="100%" border="0" height="180"><tbody><tr><td height="20" align="center" ></td></tr><tr><td width="100%" align="center"><img src="mainpic/loading.gif" /></td></tr></tbody></table>'; 
				}
				,'onLoaded':function() { }
				,'onInteractive':function() { }
				,'onComplete':function() { }
				,'onSuccess':function(req) { 
						objDiv.innerHTML = req.responseText; 
						$('span[@title]').cluetip({
							splitTitle: '|', 
							width: '370px',
							arrows: true, 
							dropShadow: false, 
							cluetipClass: 'jtip'}
						);
				}
			}
		);
}
</script>

<style type="text/css"> 
	A { COLOR: #0066FF; TEXT-DECORATION: none }
	A:hover { TEXT-DECORATION: underline }
	A.underlined { TEXT-DECORATION: underline }
	A.underlined:visited { TEXT-DECORATION: underline }
	a.cal_head { color: <?php echo $head_link_color; ?>; } 
	a.cal_head:hover { text-decoration: none; } 
	.cal_head<?php echo $BID;?> { 
		background-color: <?php echo $head_background_color; ?>; 
		color: <?php echo $head_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $head_font_size; ?>; 
		font-weight: <?php echo $head_font_weight; ?>; 
		font-style: <?php echo $head_font_style; ?>; 
	} 
	.cal_days<?php echo $BID;?> { 
		background-color: <?php echo $days_head_background_color; ?>; 
		color: <?php echo $days_head_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $days_head_font_size; ?>; 
		font-weight: <?php echo $days_head_font_weight; ?>; 
		font-style: <?php echo $days_head_font_style; ?>; 
	} 
	.cal_content<?php echo $BID;?> { 
		background-color: <?php echo $content_background_color; ?>; 
		color: <?php echo $content_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $content_font_size; ?>; 
		font-weight: <?php echo $content_font_weight; ?>; 
		font-style: <?php echo $content_font_style; ?>; 
	} 
	.cal_today<?php echo $BID;?> { 
		background-color: <?php echo $today_background_color; ?>; 
		color: <?php echo $today_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $today_font_size; ?>; 
		font-weight: <?php echo $today_font_weight; ?>; 
		font-style: <?php echo $today_font_style; ?>; 
	} 
	.cal_info<?php echo $BID;?> { 
		background-color: <?php echo $info_background_color; ?>; 
		color: <?php echo $info_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $info_font_size; ?>; 
		font-weight: <?php echo $info_font_weight; ?>; 
		font-style: <?php echo $info_font_style; ?>; 
	} 
</style> 
<table width="<?php echo $table_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $table_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">

<table width="<?php echo $table_width;?>"  border="0" cellpadding="0" cellspacing="0" align="center">
<tr><td height="<?php echo $head_height;?>"  background="<?php echo $head_background_color2;?>" >
<span class="text_head">
  <font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>">
    <span style="font-size:<?php echo $head_font_size;?>"><?php echo $head_test;?></span>
  </font>
</span>
</td></tr>

  <tr>
    <td align="center" valign="top"><div id='divCalendar<?php echo $BID;?>' width="<?php echo $bg_width;?>" height="100%"><?php 	$dayname = array ($text_Gencalendar_san,$text_Gencalendar_mon,$text_Gencalendar_thu,$text_Gencalendar_wed,$text_Gencalendar_tre,$text_Gencalendar_fri,$text_Gencalendar_sat );

	$monthname =  array($text_Gencalendar_m1, $text_Gencalendar_m2, $text_Gencalendar_m3,$text_Gencalendar_m4, $text_Gencalendar_m5, $text_Gencalendar_m6, $text_Gencalendar_m7,$text_Gencalendar_m8, $text_Gencalendar_m9,$text_Gencalendar_m10, $text_Gencalendar_m11, $text_Gencalendar_m12); 

	if( isset( $_GET['date'] ) ) list($month,$year) = explode("-",$_GET['date']); 
	else { 
		$month = date("m"); 
		$year = date("Y"); 
	} 

	$date_string = mktime(0,0,0,$month,1,$year); //The date string we need for some info... saves space ^_^ 

	$day_start = date("w",$date_string); //The number of the 1st day of the week 

	//print $_SERVER['QUERY_STRING'];
	/*$QUERY_STRING = ereg_replace("&date=".$month."-".$year,"",$_SERVER['QUERY_STRING']); */

	if( $month < 12 ) { 
		$next_month = $month+1; 
		$next_date = $next_month."-".$year; 
	} else { 
		$next_year = $year+1; 
		$next_date = "1-".$next_year; 
		$next_month = 1; 
	} 

	if( $month > 1 ) { 
		$previous_month = $month-1; 
		$next_month = $month+1; 
		$previous_date = $previous_month."-".$year; 
	} else { 
		$previous_year = $year-1; 
		$previous_date = "12-".$previous_year; 
		$previous_month = 12; 
	} 
	$y_y= 0;
	if($lang_sh == ''){
	$y_y= '543';
	}
	$table_caption_prev = $monthname[$previous_month-1] . " " . ($year+$y_y); 
	$table_caption = $monthname[date("n",$date_string)-1] . " " . ($year+$y_y); 
	$table_caption_foll = $monthname[$next_month-1] . " " . ($year+$y_y);
	//echo $bg_width; ?><table cellspacing="0" cellpadding="0" width="100%" border="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $bg_img;?>">
		<tbody>
			<tr>
				<td width="100%">
					<table border="<?php echo $table_border; ?>" cellpadding="<?php echo $table_cellpadding; ?>" cellspacing="<?php echo $table_cellspacing; ?>" style="height:<?php echo $table_height; ?>" width="<?php echo $table_width; ?>"> 
						<tr> 
							<td align="center" class="cal_head<?php echo $BID;?>"><a class="cal_head<?php echo $BID;?>" href="javascript:void(0);" onClick="change_calendar<?php echo $BID;?>('<?php echo $previous_date; ?>','<?php echo $BID;?>');" title="<?php echo $table_caption_prev; ?>">&laquo;</a></td> 
							<td align="center" class="cal_head<?php echo $BID;?>" colspan="5"><?php echo $table_caption; ?></td> 
							<td align="center" class="cal_head<?php echo $BID;?>"><a class="cal_head<?php echo $BID;?>" href="javascript:void(0);" onClick="change_calendar<?php echo $BID;?>('<?php echo $next_date; ?>','<?php echo $BID;?>');" title="<?php echo $table_caption_foll; ?>">&raquo;</a></td> 
						</tr> 
						<tr align=center> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[0]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[1]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[2]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[3]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[4]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[5]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[6]; ?></td> 
						</tr>
						<tr>
							<?php 
								for( $i = 0 ; $i < $day_start; $i++ ) { ?><td class="cal_content<?php echo $BID;?>" >&nbsp;</td><?php } 
								$current_position = $day_start; //The current (column) position of the current day from the loop 
								$total_days_in_month = date("t",$date_string); //The total days in the month for the end of the loop 
								if($_SESSION["EWT_MID"]) {
									$where1 = " AND (((cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' OR cal_invite.person_id = '".$_SESSION["EWT_MID"]."' OR cal_invite.division_id = '".$_SESSION["EWT_ORG"]."')) OR (cal_event.event_private = '2'))";
									$where2 = " AND (cal_event.event_user_id = '".$_SESSION["EWT_MID"]."') ";
								} else {
									$where1 = " AND (cal_event.event_private = '2')";
								}
								for( $i = 1; $i <= $total_days_in_month ; $i++) { 
									$class = "cal_content".$BID; 
									$date = $year."-".sprintf("%02d", $month)."-".sprintf("%02d", $i);
									if( $i == date("j") && $month == date("n") && $year == date("Y") ) $class = "cal_today".$BID; 
									/*
									$sql = "select *,cal_show_event.event_show_end,cal_show_event.event_show_start from cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id left join cal_invite on cal_event.event_id = cal_invite.event_id 
									where (cal_show_event.event_date_start <= '".$date."' and  cal_show_event.event_date_end >= '".$date."')  
									and  ((cal_show_event.event_show_start <= '".$date."' OR cal_show_event.event_show_start = '0000-00-00' $bbbb ) and  (cal_show_event.event_show_end >= '".$date."' OR cal_show_event.event_show_end = '0000-00-00' $bbbb ))  
									and (cal_event.event_private = '2' $aaaa ) 
									";
									*/
									$sql = "
										select 
											cal_event.*, cal_show_event.event_date_start, cal_show_event.event_date_end, cal_category.cat_name, 
											cal_category.cat_color, cal_show_event.event_show_end, cal_show_event.event_show_start
										from 
											cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id 
											inner join cal_category on cal_category.cat_id = cal_event.cat_id 
											left join cal_invite on cal_event.event_id = cal_invite.event_id 
										where 
											(cal_event.event_date_start <= '".$date."' and  cal_event.event_date_end >= '".$date."') and 
											((cal_show_event.event_show_start <= '".date('Y-m-d')."' OR cal_show_event.event_show_start = '0000-00-00') and  (cal_show_event.event_show_end >= '".date('Y-m-d')."' OR cal_show_event.event_show_end = '0000-00-00')) 
											 $where1 
										group by cal_event.event_id  
										order by cal_show_event.event_date_start, cal_show_event.event_date_end";
									$query = $db->query($sql);
									$num_rows = $db->db_num_rows($query);
									$chk_num_rows = 0;
									for($chk_i=0;$chk_i<$num_rows;$chk_i++) {
										$row_event_show = $db->db_fetch_array($query);
										if((($row_event_show[event_show_end] >= $date) || !isset($row_event_show[event_show_end]) || $row_event_show[event_show_end] == "0000-00-00") ){
											if( ( $row_event_show[event_show_start] <= $date  ||  !isset($row_event_show[event_show_start]) || $row_event_show[event_show_start] == "0000-00-00" ) ){
												$chk_num_rows++;
											}
										}
									}
									if($chk_num_rows>0) {
										$linkdate = sprintf("%04d",$year).'-'.sprintf("%02d",$month).'-'.sprintf("%02d",$i);
										$class = "cal_info".$BID; 
										if( $i == date("j") && $month == date("n") && $year == date("Y") ) $class = "cal_today".$BID; 
										$a1 = '<a  href="javascript:void(0);" onClick="window.open(\'main_calendar.php?sh='.$sh.'&display_date='.$linkdate.'\',\'\',\'width=900 , height=650, scrollbars=1,resizable = 1\');" >';
										$a2 = '</a>';
									}else{
										$a1='';
										$a2='';
									}
									$current_position++; 
									$data_show = explode("-", $date);
									$html_show = '';
									$html_show .= date('j', mktime(0, 0, 0, $data_show[1], $data_show[2], $data_show[0])).'&nbsp;';
									switch($data_show[1]) {
										case 1:  $html_show .= $text_Gencalendar_m1; break;
										case 2:  $html_show .= $text_Gencalendar_m2; break;
										case 3:  $html_show .= $text_Gencalendar_m3; break;
										case 4:  $html_show .=$text_Gencalendar_m4; break;
										case 5:  $html_show .= $text_Gencalendar_m5; break;
										case 6:  $html_show .= $text_Gencalendar_m6; break;
										case 7:  $html_show .= $text_Gencalendar_m7; break;
										case 8:  $html_show .=$text_Gencalendar_m8; break;
										case 9:  $html_show .= $text_Gencalendar_m9; break;
										case 10:  $html_show .= $text_Gencalendar_m10; break;
										case 11:  $html_show .= $text_Gencalendar_m11; break;
										case 12:  $html_show .= $text_Gencalendar_m12; break;
									}
									$html_show .= '&nbsp;'.$text_Gencalendar_textpsyear.(date('Y', mktime(0, 0, 0, $data_show[1], $data_show[2], $data_show[0]))+$y_y);
									?><td align="center" class="<?php echo $class; ?>">
									<?php if($chk_num_rows>0) { ?><span  class="tips" title="<?php echo $html_show; ?>|
								<table width='100%' border='0' cellspacing='0' cellpadding='2'>
									<?php
										$query = $db->query($sql);
										while($row_event = $db->db_fetch_array($query)) {
												$html = "";
												$start_time = explode(':', $row_event['event_time_start']);
												$end_time = explode(':', $row_event['event_time_end']);
												$end_ampm = $text_Gencalendar_textpm;
												$start_ampm = $text_Gencalendar_textpm;
												if(($row_event['event_date_start'] != $row_event['event_date_end']) && ($row_event['event_date_end'] != '0000-00-00') && ($row_event['event_all_day'] != '1')) {
													$html .= date('j', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4))).'&nbsp;';
													switch(substr($row_event['event_date_start'], 5, 2)) {
														case 1:  $html .=$text_Gencalendar_m1; break;
														case 2:  $html .=$text_Gencalendar_m2; break;
														case 3:  $html .=$text_Gencalendar_m3; break;
														case 4:  $html .= $text_Gencalendar_m4; break;
														case 5:  $html .= $text_Gencalendar_m5; break;
														case 6:  $html .= $text_Gencalendar_m6; break;
														case 7:  $html .= $text_Gencalendar_m7; break;
														case 8:  $html .=$text_Gencalendar_m8; break;
														case 9:  $html .=$text_Gencalendar_m9; break;
														case 10:  $html .=$text_Gencalendar_m10; break;
														case 11:  $html .=$text_Gencalendar_m11; break;
														case 12:  $html .= $text_Gencalendar_m12; break;
													}
													$html .= '&nbsp;';
													$html .= (date('Y', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))+$y_y);
													$html .= '&nbsp;';
													//$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."";
													$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
													$html .= "&nbsp;-&nbsp;";
													$html .= date('j', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4))).'&nbsp;';
													switch(substr($row_event['event_date_end'], 5, 2)) {
														case 1:  $html .=$text_Gencalendar_m1; break;
														case 2:  $html .=$text_Gencalendar_m2; break;
														case 3:  $html .=$text_Gencalendar_m3; break;
														case 4:  $html .= $text_Gencalendar_m4; break;
														case 5:  $html .= $text_Gencalendar_m5; break;
														case 6:  $html .= $text_Gencalendar_m6; break;
														case 7:  $html .= $text_Gencalendar_m7; break;
														case 8:  $html .=$text_Gencalendar_m8; break;
														case 9:  $html .=$text_Gencalendar_m9; break;
														case 10:  $html .=$text_Gencalendar_m10; break;
														case 11:  $html .=$text_Gencalendar_m11; break;
														case 12:  $html .= $text_Gencalendar_m12; break;
													}
													$html .= '&nbsp;';
													$html .= (date('Y', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)))+$y_y);
													$html .= '&nbsp;';
													//$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
													$html .= '&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
												} else {
													if($row_event['event_time_start'] == '00:00:00' && $row_event['event_time_start'] == '00:00:00') {
														$html .= $text_Gencalendar_textallday ;
													} else {
														if(($row_event['event_all_day'] != '1')) {
															$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
														} else {
															$html .= $text_Gencalendar_textallday ;
														}
													}
												}
									 		if($lang_shw != ''){
										 	$event_title = select_lang_detail($row_event['event_id'],$lang_shw,'event_title','cal_event');
											if($event_title != ''){$row_event['event_title']=$event_title;} 
											}
									?>
										<tr>
											<td valign='top' width='12' align='center'><img src='<?php echo $path_cal;?>mainpic/colorrange.gif' border='0' width='8' height='8' align='absmiddle' style='padding: 0; border-style:solid; border-color:#000000; background:<?php echo $row_event['cat_color'] ?>'></td>
											<td valign='top' width='350'><strong><?php echo nl2br($row_event['event_title']);?>&nbsp;(<?php echo $html;?>)</strong></td>
										</tr>
										<tr>
											<td valign='top' width='12' align='center'></td>
											<td valign='top' width='350'><strong><?php if($row_event['event_registor']=='1' && $set_calendar_registor=='Y'){ echo "[<img src='".$path_cal."mainpic/icon_news.gif'   align='absmiddle' >รับสมัครเข้าร่วมสัมมนา]";}?></strong></td>
										</tr>
									<?php
										}
									?>
									</table>"><?php } ?><?php echo $a1.$i.$a2; ?><?php if($chk_num_rows>0) { ?></span><?php } ?></td><?php  
									if( $current_position == 7 ){ 
										?></tr><tr><?php
										$current_position = 0; 
									} 
								} 
	
								$end_day = 7-$current_position; //There are 
	
								for( $i = 0 ; $i < $end_day ; $i++ )  {
							?>
							<td class="cal_content<?php echo $BID;?>"></td>
							<?php } ?>
						</tr>
						<tr>
							<td class="cal_days<?php echo $BID;?>"  colspan="7" align="center"><span style="cursor:hand"  onmouseover="this.style.color='#FF0000';" onMouseOut="this.style.color='#333333';" onClick="window.open('calendar_month.php?sh=<?php echo $sh;?>','','width=900 , height=650, scrollbars=1,resizable = 1');"><?php echo $text_Gencalendar_textview;?></span></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr><td></td></tr>
		</tbody>
	</table></div></td>
  </tr>
</table>
	</td>
     </tr>
</table><?php echo $design[1];?>
<table width="<?php //echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php
	}else if($rec[block_link]=="1"){
	?>
	<script language="javascript">
	function ajax_calendarMGT<?php echo $BID;?>(tab) {
			var objDiv = document.getElementById("divCalendarMGT<?php echo $BID;?>");
			document.formcalendarMGt.block_link<?php echo $BID;?>.value=tab;
			var search_mode = document.formcalendarMGt.block_link<?php echo $BID;?>.value;
			changebg<?php echo $BID;?>(eval(tab))
			url='activity_display.php?Blockid='+tab+'&themeid=<?php echo $themeid;?>&BID=<?php echo $BID;?>';
			AjaxRequest.get({
					'url':url
					,'onLoading':function() { }
					,'onLoaded':function() { }
					,'onInteractive':function() { }
					,'onComplete':function() { }
					,'onSuccess':function(req) { 
						objDiv.innerHTML = req.responseText; 
					}
				});
	}
function changebg<?php echo $BID;?>(c) {
	for(i=1;i<3;i++) {
		if(i != c) {
			document.getElementById("mytd<?php echo $BID;?>"+i).style.background="url()";
		} else {
			document.getElementById("mytd<?php echo $BID;?>"+i).style.background="url(mainpic/bg_webboard.gif)";
		}	
	}
	document.formcalendarMGt.block_link<?php echo $BID;?>.value=c;
}

</script>
<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
	
	<tr valign="top" > 
		<td ><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
				<form name="formcalendarMGt" method="get" action="activity_display.php">
				<input name="block_link<?php echo $BID;?>" type="hidden" value="<?php echo $rec[block_link];?>" />
				<tr> 
					<td  height="<?php echo $head_height;?>"  align="center" background="<?php echo $head_background_color2;?>" >
						<table width="100%"  border="0" cellpadding="0" cellspacing="0">
							<tr >
								<td width="144"  height="<?php echo $head_height-7;?>" align="center" background="mainpic/bg_on.gif" id="mytd<?php echo $BID;?>1" style="cursor:hand"   onClick="ajax_calendarMGT<?php echo $BID;?>('1');" ><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>">ปฏิทินมีการสมัครสมาชิก</span></font></span></td>
									<td width="90"   height="<?php echo $head_height-7;?>" align="center" id="mytd<?php echo $BID;?>2"  style="cursor:hand"  onClick="ajax_calendarMGT<?php echo $BID;?>('2');" ><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>">ปฏิทินกิจกรรม</span></font></span></td>
									<td width="90"   height="<?php echo $head_height-7;?>" align="center"  >&nbsp;</td>
								<td >&nbsp;</td>
							</tr>
						</table>					</td>
				</tr>
				<tr> 
					<td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
					<div id="divCalendarMGT<?php echo $BID;?>"></div>
					</td>
				</tr>
				<tr> 
					<td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>" align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>"><span style="cursor:hand"  onmouseover="this.style.color='#FF0000';" onMouseOut="this.style.color='#333333';" onClick="window.open('calendar_month.php?sh=<?php echo $sh;?>','','width=900 , height=650, scrollbars=1,resizable = 1');"><?php echo $text_Gencalendar_textview;?></span></span></font></td>
				</tr>
				</form>
	  </table></td>
	</tr>
</table>
<?php echo $design[1];?>
<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<script language="javascript"><?php
						if($rec[block_link] != "") {
							?>
							ajax_calendarMGT<?php echo $BID;?>('<?php echo $rec[block_link];?>');
							<?php
						}
					?>
</script>
	<?php
	}
}


function GenWebboard($text_id,$BID){
global $db;
global $filename;
global $mainwidth;
global $global_theme;
global $lang_sh;
$target = '_self';

@include("language/language".$lang_sh.".php");
$lang_shw = ereg_replace ("_", "",$lang_sh);
$e = explode("_",$text_id);
$c = count($e);
$txt = " AND ( 0 ";
	for($i=0;$i<$c;$i++){
		if($e[$i] != ""){
			$txt .= " OR w_cate.c_id = '".$e[$i]."' ";
		}
	}
	$txt .= " ) ";
	if($lang_sh != ''){
	$sql = "SELECT * FROM w_cate 
		INNER JOIN lang_w_cate ON lang_w_cate.c_id =w_cate.c_id
		INNER JOIN lang_config ON lang_config.lang_config_id = lang_w_cate.lang_name 
		WHERE  c_use = 'Y' and lang_field = 'c_name'".$txt;
	}else{
	$sql = "SELECT * FROM w_cate WHERE c_use = 'Y' ".$txt;
	}
	$Execsql = $db->query($sql);
	if($db->db_num_rows($Execsql) > 0){
	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);

	
	@include("themesdesign/".$namefolder."/".$namefolder.".php");
	 //if($themes_type == 'F'){
	if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
 		$buffer = "";
 		$fd = @fopen ($Current_Dir1.$themes_file, "r");
		 while (!@feof ($fd)) {
			$buffer .= @fgets($fd, 4096);
	 	}
 		@fclose ($fd);
		$design = explode('<?php#htmlshow#?>',$buffer);
	 }
	?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
	<?php echo $design[0];?>
		<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
						<form name="formSearchWEBB" method="post" action="search_result.php?filename=<?php echo $filename; ?>&search_mode=4" target="_blank">
		  <tr>
			<td align="right" >
								<input type="text" name="keyword" class="cadweb2007">
								<input type="submit" name="search" value="<?php echo $text_genwebboard_buttom_search;?>" class="cadweb2007">      </td>
		  </tr></form>
		</table>
	
	<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">
		
		
	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
    <tr>
       <td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" >
	   
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td  align="center" width="60%"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genwebboard_cat;?></span></font></span></td>
           <td width="20%" align="center"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genwebboard_numqu;?></span></font></span></td>
           <td width="20%" align="center"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genwebboard_numanw;?></span></font></span></td>
         </tr>
       </table>
	   
	   </td>
     </tr>
     <tr>
       <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
	   
	   	<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
<?php
   while($R = $db->db_fetch_array($Execsql)){
   if($lang_sh != ''){
   $R[c_name] = $R[lang_detail];
   $R[c_detail] = select_lang_detail($R[c_id],$lang_shw,"c_detail",w_cate);
   }
   if($R["c_rss"]=='Y'){
			 $filename1="rss/webboard".$R["c_id"].".xml";
			 if(file_exists($filename1)){
			     $link='<a href="rss/webboard'.$R["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0" align="absmiddle"> </a>';
			 }else{
			     $link='';
			 }
		}else{ $link='';
		}
   $count = $db->query("SELECT * FROM w_question WHERE c_id = '$R[c_id]' AND s_id = '1' AND t_date >= '$dateshowl'");
   $countrow = mysql_num_rows($count);
  $count1 = $db->query("SELECT DISTINCT(w_answer.a_id) FROM w_answer,w_question WHERE w_question.t_id = w_answer.t_id AND w_question.c_id = '$R[c_id]' AND w_answer.s_id = '1' ");
   $countrow1 = mysql_num_rows($count1);
   ?>
    <tr onMouseOver="this.style.backgroundColor='#E7E7E7'" onMouseOut="this.style.backgroundColor='<?php echo $body_color;?>'"  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"> 
      <td width="4%" align="center" valign="top">
        <?php if($R[c_view] == "Y"){ ?><img src="mainpic/lock.gif" width="24" height="24"><?php }else{ ?><img src="mainpic/book_blue.gif" width="24" height="24"><?php } ?></td>
      
    <td  valign="top"  width="56%">
	  <a href="index_question.php?wcad=<?php echo $R[c_id]; ?>&filename=<?php echo $filename; ?>&t=<?php echo $rec[block_themes]; ?>"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php  echo stripslashes($R[c_name]); ?></span></font></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $link;?>
     	<span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>"><span style="font-size:<?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php  echo stripslashes(nl2br ($R[c_detail])); ?></span></font></span></td>
      <td width="20%" align="center"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $countrow; ?></span></font></span></td>
      <td width="20%"  align="center"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $countrow1; ?></span></font></span></td>
    </tr>
    <?php }?>
</table>

	</td>
     </tr>
</table>

	</td>
     </tr>
</table>
<?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
	<?php
	}else{
	
		?>
<br />
<table cellspacing="0" cellpadding="0" width="95%" border="0" align="center">
   <tbody>   
   <tr>
       <td align="right" ><table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
				<form name="formSearchWEBB" method="post" action="search_result.php?filename=<?php echo $filename; ?>&search_mode=4">
  <tr>
    <td align="right">
                        <input type="text" name="keyword" class="cadweb2007">
              <input type="submit" name="search" value="<?php echo $text_genwebboard_buttom_search;?>" class="cadweb2007">      </td>
  </tr></form>
</table></td>
     </tr>
     <tr>
       <td height="33" background="mainpic/bg_book.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td height="33" align="center"><span class="style4"><font face="tahoma" size="2" color="#FFFFFF"><span class="text_head"><?php echo $text_genwebboard_cat;?></span></font></span></td>
           <td width="9%" align="center"><span class="style4"><font face="tahoma" size="2" color="#FFFFFF"><span class="text_head"><?php echo $text_genwebboard_numqu;?></span></font></span></td>
           <td width="9%" align="center"><span class="style4"><font face="tahoma" size="2" color="#FFFFFF"><span class="text_head"><?php echo $text_genwebboard_numanw;?></span></font></span></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#D6A161"  class="normal_font">
<?php
   while($R = $db->db_fetch_array($Execsql)){
   if($R["c_rss"]=='Y'){
			 $filename1="rss/webboard".$R["c_id"].".xml";
			 if(file_exists($filename1)){
			     $link='<a href="rss/webboard'.$R["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0" align="absmiddle"> </a>';
			 }else{
			     $link='';
			 }
		}else{ $link='';
		}
   $count = $db->query("SELECT * FROM w_question WHERE c_id = '$R[c_id]' AND s_id = '1' AND t_date >= '$dateshowl'");
   $countrow = mysql_num_rows($count);
  $count1 = $db->query("SELECT DISTINCT(w_answer.a_id) FROM w_answer,w_question WHERE w_question.t_id = w_answer.t_id AND w_question.c_id = '$R[c_id]' AND w_answer.s_id = '1' ");
   $countrow1 = mysql_num_rows($count1);
   ?>
    <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#E7E7E7'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
      <td width="4%" align="center" valign="top" bgcolor="#FFFFFF"><br ><?php if($R[c_view] == "Y"){ ?><img src="mainpic/lock.gif" width="24" height="24"><?php }else{ ?><img src="mainpic/book_blue.gif" width="24" height="24"><?php } ?></td>
      
    <td width="78%" valign="top" >
      <div align="left" class="head_font">
	  <a href="index_question.php?wcad=<?php echo $R[c_id]; ?>&filename=<?php echo $filename; ?>"><font  face="tahoma" size="2" color="#A80000"><strong>
	  <span class="text_normal"><?php  echo stripslashes($R[c_name]); ?></span></strong></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $link;?></div>
      <a href="index_question.php?wcad=<?php echo $R[c_id]; ?>&filename=<?php echo $filename; ?>"><font  face="tahoma" size="2" color="#000000"><span class="text_normal"><?php  echo stripslashes($R[c_detail]); ?></span></font>      </a></td>
      <td align="center"><font  face="tahoma" size="2" color="#000000"><span class="text_normal"><?php echo $countrow; ?></span></font></td>
      <td align="center"><font  face="tahoma" size="2" color="#000000"><span class="text_normal"><?php echo $countrow1; ?></span></font></td>
    </tr>
    <?php }?>
</table></td>
     </tr>
  </tbody>
</table>
		<?php
		}
	}
}
function GenSearch($BID){
	global $filename;
	global $db;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;
	@include("language/language".$lang_sh.".php");
	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
			$namefolder = "themes".($themeid);
			
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
			$text_search = "<span class=\"text_head\"><font color=\"".$head_font_color."\"  face=\"".$head_font_face."\"><span style=\"font-size:".$head_font_size."\"><b>$text_gensearch_lblsearch</b></span></font></span><br />";
			 //if($themes_type == 'F'){
			if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
					$buffer = "";
					$fd = @fopen ($Current_Dir1.$themes_file, "r");
					 while (!@feof ($fd)) {
						$buffer .= @fgets($fd, 4096);
					}
					@fclose ($fd);
					$design = explode('<?php#htmlshow#?>',$buffer);
			 }
	 }
?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">

<table width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
<tr><td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_search;?></span></td></tr>
<tr><td>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="5" cellspacing="0"  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">
    <tr > 
      <td align="center">
	  <form name="search<?php echo $BID?>" method="post" action="search_result.php">
	  <table  cellpadding="0" cellspacing="0">
			  	<tr>
					<td>
					<input name="keyword" type="text" id="keyword"  size="10" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">
      				<input name="filename" type="hidden" id="filename" value="<?php echo $filename; ?>"><input name="oper" type="hidden" id="oper" value="OR">
					</td>
					<td>
					<input type="button" name="Submit"  
					onclick="
					if(document.search<?php echo $BID?>.searchby.value==2){
						//location.href='http://www.google.co.th/search?q='+document.search<?php echo $BID?>.keyword.value;
						window.open ('http://www.google.co.th/search?q='+document.search<?php echo $BID?>.keyword.value,'mygoogle'); 
					}else{
						document.search<?php echo $BID?>.submit();
					}" value="<?php echo $text_gensearch_buttonsubmit;?> " style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;"><!--input type="button" name="Button" value="<?php echo $text_gensearch_buttonadvance;?>" onClick="window.location.href='search_advance.php?filename=<?php echo $filename; ?>';"  style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;"-->
					</td>
				</tr>
			  	<tr>
					<td colspan="2"> 
					<input type="hidden" name="searchby" value="1" />
					<!--input  type="radio" name="chk" checked="checked" value="1"  onclick="if(this.checked==true){document.search<?php echo $BID?>.searchby.value=this.value;} "/> <font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_gensearch_insearch;?></span></font><br />
	  				<input  type="radio" name="chk" value="2" onclick="if(this.checked==true){document.search<?php echo $BID?>.searchby.value=this.value;} " /> <font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_gensearch_google;?></font-->
					</td>
				</tr>
			 </table>
			   </form>
	  </td>
    </tr>
</table></td></tr>
</table>

	</td>
     </tr>
</table>
<?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php
}
function GenBanner($banner_gid,$BID){
	global $db;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;

	if($banner_gid!=''){
		$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
		$rec = $db->db_fetch_array($sql);
		
		if($rec[block_themes] != '0'){
			$themeid = $rec[block_themes];
		}else{
			$themeid = $global_theme;
		}
		if($themeid != "0" AND $themeid != ""){
			$namefolder = "themes".($themeid);
	
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
			//if($themes_type == 'F'){
			if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				}
				@fclose ($fd);
				$design = explode('<?php#htmlshow#?>',$buffer);
			}
		}

		## >> Get banner setting
		$db->prepare("SELECT * 
		              FROM   banner_setting 
					  where  BID = ?");
		$query_set = $db->set_execute(array(ready($BID))); 
		$db->deallocate();
		$rs_set    = $db->db_fetch_array($query_set);

		$banner_marquee = explode('#',$rs_set["banner_marquee"]);
		$runtime 		= $banner_marquee[1];
		$b_marquee	 	= $banner_marquee[0];
	
		?>
		
		<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0">
			<tr>
				<td>
				</td>
			</tr>
		</table>
		<?php echo $design[0];?>
	
		<?php
		## >> set marquee
		if($rs_set['banner_type']!='P' && $rs_set['banner_type']!='A') {
			if($b_marquee == 'A'){
				echo  ' <marquee direction="up" id=A onMouseOver=this.scrollAmount=0 
							onMouseOut=this.scrollAmount='.$runtime.' truespeed scrollamount='.$runtime.'
							scrolldelay=30 loop=21 >';
				}else if($b_marquee == 'B'){
				echo  '<marquee direction="down" id=B onMouseOver=this.scrollAmount=0 
							onMouseOut=this.scrollAmount='.$runtime.' truespeed scrollamount='.$runtime.' 
							scrolldelay=30 loop=21 >';
				}else if($b_marquee == 'C'){
				echo  '<marquee   id=C onMouseOver=this.scrollAmount=0 
							onMouseOut=this.scrollAmount='.$runtime.' truespeed scrollamount='.$runtime.' 
							scrolldelay=30 loop=21 >';
				}else if($b_marquee == 'D'){
				echo  ' <marquee direction="right"  id=D onMouseOver=this.scrollAmount=0 
							onMouseOut=this.scrollAmount='.$runtime.' truespeed scrollamount='.$runtime.' 
							scrolldelay=30 loop=21 >';
			}
		}
		?>

		<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
			<tr>
				<td align="center" >
			
		<table width="200"  border="0" cellpadding="1" cellspacing="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
			<?php
			if($db->db_num_rows($query_set)>0 ){
				
				## Set current date
				$current_date = date("Y-m-d");
				$current_date = explode("-",$current_date);
				$date_now     = ((int)$current_date[0]+543)."-".$current_date[1]."-".$current_date[2];
				
				$wh = "and ((banner_show_start = '' and banner_show_end = '')";
				$wh .= "or ('".$date_now."' between banner_show_start and banner_show_end))";
				
				if($rs_set[banner_type]=='R' && $rs_set[banner_show] != ''){
					$sql_banner = "SELECT * 
					               FROM banner 
								   where banner_gid = '$banner_gid' $wh 
								   ORDER BY RAND() LIMIT ".$rs_set[banner_rand_row];
				}
				else if($rs_set[banner_type]=='A' && ($rs_set[banner_show] == '' || $rs_set[banner_show] != '')){
					$sql_banner = "SELECT * 
							       FROM banner 
								   where banner_gid = '$banner_gid' $wh ";
				}
				else if($rs_set[banner_type]!='A' && $rs_set[banner_type]!='R'  && $rs_set[banner_show] != ''){
					$sql_banner = "SELECT * 
					               FROM banner 
								   WHERE banner_id IN (".$rs_set[banner_show].") and banner_gid = '$banner_gid' $wh 
								   ORDER BY banner_position";
				}

				$query_banner = $db->query($sql_banner);
				$rFirstImg=$db->db_fetch_array($db->query($sql_banner));
				$num_banner = $db->db_num_rows($query_banner);
				if($num_banner > 0){
					$k=1;
					if($rs_set['banner_type']=='P' || $rs_set['banner_type']=='A') {
					if(eregi("www", $rFirstImg[banner_link]) AND !eregi("http://", $rFirstImg[banner_link])){
						$linkF = "http://".$rFirstImg[banner_link];
					}else{
						$linkF = $rFirstImg[banner_link];	
					}
		?>
		<tr><td>
		<!--<script type="text/javascript">
		var fadeimages<?php //echo $BID; ?> = new Array;
		var linkarr<?php //echo $BID; ?> = new Array;
		var numimg<?php //echo $BID; ?> = new Array;
		</script>
		<div>
		<SCRIPT>

		var cliImg<?php //echo $BID; ?> = '';
		var cliImgSrc<?php //echo $BID; ?> = '';
		var n<?php //echo $BID; ?> = Math.round(Math.random() * 10);
		var currentPos<?php //echo $BID; ?>=0;
		var interval<?php //echo $BID; ?>= 6000;
		var setTimeId<?php //echo $BID; ?>= '';
		function rotateStop<?php //echo $BID; ?>(){
			clearTimeout(setTimeId<?php //echo $BID; ?>);
		}
		function rotateStart<?php //echo $BID; ?>(){
			rotate<?php //echo $BID; ?>();
		}
		function chki<?php //echo $BID; ?>(ci, no){
			var pImg = document.getElementById("RollImg<?php //echo $BID; ?>");
			var pUrl = document.getElementById("RollUrl<?php //echo $BID; ?>");
			if(cliImg<?php //echo $BID; ?> == '') {
				cliImg<?php //echo $BID; ?> = ci;
				cliImgSrc<?php //echo $BID; ?> = ci.src;
				ci.src = numimg<?php //echo $BID; ?>[no];
				n<?php //echo $BID; ?>=no;
				pImg.src = fadeimages<?php //echo $BID; ?>[no];
				pUrl.href = linkarr<?php //echo $BID; ?>[no];
				if(linkarr<?php //echo $BID; ?>[no].charAt(0)=='#'){
					document.getElementById("RollUrl<?php //echo $BID; ?>").style.cursor='default';
				}else{
					document.getElementById("RollUrl<?php //echo $BID; ?>").style.cursor='pointer';
				}
			} else if(cliImg<?php //echo $BID; ?> != ci) {
				cliImg<?php //echo $BID; ?>.src = cliImgSrc<?php //echo $BID; ?>;
				cliImg<?php //echo $BID; ?>= ci;
				cliImgSrc<?php //echo $BID; ?> = ci.src;
				ci.src = numimg<?php //echo $BID; ?>[no];
				n<?php //echo $BID; ?>=no;
				pImg.src = fadeimages<?php //echo $BID; ?>[no];
				pUrl.href = linkarr<?php //echo $BID; ?>[no];
				if(linkarr<?php //echo $BID; ?>[no].charAt(0)=='#'){
					document.getElementById("RollUrl<?php //echo $BID; ?>").style.cursor='default';
				}else{
					document.getElementById("RollUrl<?php //echo $BID; ?>").style.cursor='pointer';
				}
			}
		}
		function rotate<?php //echo $BID; ?>(){
			if(n<?php //echo $BID; ?>>=6) {
				n<?php //echo $BID; ?>=(<?php //echo $num_banner-1; ?>+0);
			} else if(n<?php //echo $BID; ?><6 && n<?php //echo $BID; ?>><?php //echo $num_banner-1; ?>) {
				n<?php //echo $BID; ?>=0;
			}
			currentPos<?php //echo $BID; ?>=n<?php //echo $BID; ?>;
			if(document.getElementById("RollImg<?php //echo $BID; ?>")!=null) {
				setimgurl<?php //echo $BID; ?>();
				setTimeId<?php //echo $BID; ?>=setTimeout('rotate<?php //echo $BID; ?>()',interval<?php //echo $BID; ?>);
			} else {
				setTimeout('rotate<?php //echo $BID; ?>()',3000);
			}
			n<?php //echo $BID; ?>=Math.round(Math.random() * 10);
		}
		function setimgurl<?php //echo $BID; ?>(){
			var ci = eval('document.getElementById("num_img<?php //echo $BID; ?>_'+currentPos<?php //echo $BID; ?>+'")');
			document.getElementById("RollImg<?php //echo $BID; ?>").filters.blendTrans.apply();
			document.getElementById("RollUrl<?php //echo $BID; ?>").href=linkarr<?php //echo $BID; ?>[currentPos<?php //echo $BID; ?>];
			document.getElementById("RollImg<?php //echo $BID; ?>").src=fadeimages<?php //echo $BID; ?>[currentPos<?php //echo $BID; ?>];
			document.getElementById("RollImg<?php //echo $BID; ?>").filters.blendTrans.play();
		if(linkarr<?php //echo $BID; ?>[currentPos<?php //echo $BID; ?>].charAt(0)=='#'){
		document.getElementById("RollUrl<?php //echo $BID; ?>").style.cursor='default';
		}else{
		document.getElementById("RollUrl<?php //echo $BID; ?>").style.cursor='pointer';
		}
		//alert(cliImg);
		if(cliImg<?php //echo $BID; ?> == '') {
				cliImg<?php //echo $BID; ?> = ci;
				cliImgSrc<?php //echo $BID; ?> = ci.src;
				ci.src = numimg<?php //echo $BID; ?>[currentPos<?php //echo $BID; ?>];
			} else if(cliImg<?php //echo $BID; ?> != ci) {
				cliImg<?php //echo $BID; ?>.src = cliImgSrc<?php //echo $BID; ?>;
				cliImg<?php //echo $BID; ?> = ci;
				cliImgSrc<?php //echo $BID; ?> = ci.src;
				ci.src = numimg<?php //echo $BID; ?>[currentPos<?php //echo $BID; ?>];
			}
		}
		function moveForward<?php //echo $BID; ?>() {
			if(currentPos<?php //echo $BID; ?>!=(<?php //echo $num_banner-1; ?>+0)) {
				currentPos<?php //echo $BID; ?>+=1;
				setimgurl<?php //echo $BID; ?>();
			}
		}
		function moveBackward<?php //echo $BID; ?>() {
			if(currentPos<?php //echo $BID; ?>!=0) {
				currentPos<?php //echo $BID; ?>-=1;
				setimgurl<?php //echo $BID; ?>();
			}
		}
		rotate<?php //echo $BID; ?>();
		//document.body.onload=function() { rotate<?php //echo $BID; ?>(); };
		</SCRIPT></div>-->

		<script type="text/javascript">
		var fadeimages<?php echo $BID; ?> = new Array;
		var linkarr<?php echo $BID; ?> = new Array;
		var numimg<?php echo $BID; ?> = new Array;
		var linktarget<?php echo $BID; ?> = new Array;
		var cliImg<?php echo $BID; ?> = '';
		var cliImgSrc<?php echo $BID; ?> = '';
		//var n<?php echo $BID; ?> = Math.round(Math.random() * 10);
		var n<?php echo $BID; ?> = 0;
		var currentPos<?php echo $BID; ?>=0;
		var interval<?php echo $BID; ?>= 6000;
		var setTimeId<?php echo $BID; ?>= '';
		function rotateStop<?php echo $BID; ?>(){
			clearTimeout(setTimeId<?php echo $BID; ?>);
		}
		function rotateStart<?php echo $BID; ?>(){
			rotate<?php echo $BID; ?>();
		}
		function chki<?php echo $BID; ?>(ci, no){
			var pImg = document.getElementById("RollImg<?php echo $BID; ?>");
			var pUrl = document.getElementById("RollUrl<?php echo $BID; ?>");
			if(cliImg<?php echo $BID; ?> == '') {
				cliImg<?php echo $BID; ?> = ci;
				cliImgSrc<?php echo $BID; ?> = ci.src;
				ci.src = numimg<?php echo $BID; ?>[no];
				n<?php echo $BID; ?>=no;
				pImg.src = fadeimages<?php echo $BID; ?>[no];
				pUrl.href = linkarr<?php echo $BID; ?>[no];
		pUrl.target = linktarget<?php echo $BID; ?>[no];
				if(linkarr<?php echo $BID; ?>[no].charAt(0)=='#'){
					document.getElementById("RollUrl<?php echo $BID; ?>").style.cursor='default';
				}else{
					document.getElementById("RollUrl<?php echo $BID; ?>").style.cursor='pointer';
				}
			} else if(cliImg<?php echo $BID; ?> != ci) {
				cliImg<?php echo $BID; ?>.src = cliImgSrc<?php echo $BID; ?>;
				cliImg<?php echo $BID; ?>= ci;
				cliImgSrc<?php echo $BID; ?> = ci.src;
				ci.src = numimg<?php echo $BID; ?>[no];
				n<?php echo $BID; ?>=no;
				pImg.src = fadeimages<?php echo $BID; ?>[no];
				pUrl.href = linkarr<?php echo $BID; ?>[no];
		pUrl.target = linktarget<?php echo $BID; ?>[no];
				if(linkarr<?php echo $BID; ?>[no].charAt(0)=='#'){
					document.getElementById("RollUrl<?php echo $BID; ?>").style.cursor='default';
				}else{
					document.getElementById("RollUrl<?php echo $BID; ?>").style.cursor='pointer';
				}
			}
		}
		function rotate<?php echo $BID; ?>(){
			if(n<?php echo $BID; ?>>=<?php echo $num_banner-1; ?>) {
				n<?php echo $BID; ?>=0;
			} else {
				n<?php echo $BID; ?>++;
			}
			currentPos<?php echo $BID; ?>=n<?php echo $BID; ?>;
			if(document.getElementById("RollImg<?php echo $BID; ?>")!=null) {
				setimgurl<?php echo $BID; ?>();
				setTimeId<?php echo $BID; ?>=setTimeout('rotate<?php echo $BID; ?>()',interval<?php echo $BID; ?>);
			} else {
				setTimeout('rotate<?php echo $BID; ?>()',3000);
			}
		//	n<?php echo $BID; ?>=Math.round(Math.random() * 10);
		}
		function setimgurl<?php echo $BID; ?>(){
			var ci = eval('document.getElementById("num_img<?php echo $BID; ?>_'+currentPos<?php echo $BID; ?>+'")');
			//document.getElementById("RollImg<?php echo $BID; ?>").filters.blendTrans.apply();
			document.getElementById("RollUrl<?php echo $BID; ?>").href=linkarr<?php echo $BID; ?>[currentPos<?php echo $BID; ?>];
		document.getElementById("RollUrl<?php echo $BID; ?>").target=linktarget<?php echo $BID; ?>[currentPos<?php echo $BID; ?>];
			document.getElementById("RollImg<?php echo $BID; ?>").src=fadeimages<?php echo $BID; ?>[currentPos<?php echo $BID; ?>];
			//document.getElementById("RollImg<?php echo $BID; ?>").filters.blendTrans.play();
		if(linkarr<?php echo $BID; ?>[currentPos<?php echo $BID; ?>].charAt(0)=='#'){
		document.getElementById("RollUrl<?php echo $BID; ?>").style.cursor='default';
		}else{
		document.getElementById("RollUrl<?php echo $BID; ?>").style.cursor='pointer';
		}
		//alert(cliImg);
		if(cliImg<?php echo $BID; ?> == '') {
				cliImg<?php echo $BID; ?> = ci;
				cliImgSrc<?php echo $BID; ?> = ci.src;
				ci.src = numimg<?php echo $BID; ?>[currentPos<?php echo $BID; ?>];
			} else if(cliImg<?php echo $BID; ?> != ci) {
				cliImg<?php echo $BID; ?>.src = cliImgSrc<?php echo $BID; ?>;
				cliImg<?php echo $BID; ?> = ci;
				cliImgSrc<?php echo $BID; ?> = ci.src;
				ci.src = numimg<?php echo $BID; ?>[currentPos<?php echo $BID; ?>];
			}
		}
		function moveForward<?php echo $BID; ?>() {
			if(currentPos<?php echo $BID; ?>!=(<?php echo $num_banner-1; ?>+0)) {
				currentPos<?php echo $BID; ?>+=1;
				setimgurl<?php echo $BID; ?>();
			}
		}
		function moveBackward<?php echo $BID; ?>() {
			if(currentPos<?php echo $BID; ?>!=0) {
				currentPos<?php echo $BID; ?>-=1;
				setimgurl<?php echo $BID; ?>();
			}
		}
		rotate<?php echo $BID; ?>();
		//document.body.onload=function() { rotate<?php echo $BID; ?>(); };
		</SCRIPT></div>
<?php
	$bw=($rs_set['banner_width']=='') ? 699: $rs_set['banner_width'];
	$bh=($rs_set['banner_height']=='') ? 140: $rs_set['banner_height'];
?>
<TABLE cellSpacing=0 cellPadding=0 width=100% border=0 align="center">
  <TBODY>
  <TR>
    <TD align="center"><A href="<?php echo $linkF; ?>" onfocus=this.blur() target=_top name="RollUrl<?php echo $BID; ?>" id="RollUrl<?php echo $BID; ?>"> <IMG style="FILTER: blendTrans(duration=1)" height=<?php echo $bh; ?> src="<?php echo $rFirstImg['banner_pic']; ?>" width=<?php echo $bw; ?>  border=0  name="RollImg<?php echo $BID; ?>" id="RollImg<?php echo $BID; ?>"></A></TD>
  </TR>
  <TR >
    <TD vAlign=top align=left style="background-color:#ffffff; ">
  <TABLE border=0 align="left" cellPadding=0 cellSpacing=0 style="line-height:30px;">
          <TR >
       <TD vAlign=center align=middle width=5 style="">&nbsp;</TD>
	   <!--TD vAlign=center align=middle width=5>
	   <span style="CURSOR: hand; text-align:center; font-size:12px; background-color:#000000; border:solid 1px white; margin-left:10px; color:#FFFFFF;" width=30  name="num_img_left" id="num_img_left" onclick="moveBackward<?php echo $BID; ?>();">&nbsp;&nbsp;<&nbsp;&nbsp;</span></TD-->
<?php
		}
		for($i=0;$i<$num_banner;$i++){	
			$rs_banner = $db->db_fetch_array($query_banner);
			if(eregi("www", $rs_banner[banner_link]) AND !eregi("http://", $rs_banner[banner_link])){
				$link = "http://".$rs_banner[banner_link];
			}else{
				 $link = $rs_banner[banner_link];	
			}
			$filetypename = explode('.',$rs_banner[banner_pic]);
			$wi='97%';
			$hi='38';
			if( $rs_set[banner_width]){   $sizes =' width="'.trim($rs_set[banner_width]).'"'; }
			if( $rs_set[banner_height]){   $sizes .=' height="'.trim($rs_set[banner_height]).'"'; }
			
			//chk lang other
			if($lang_sh != ''){
				$nr = 'banner'.$lang_sh.'_'.$rs_banner[banner_id];
				$Dir1 = "language/".$nr.".php";
				if (file_exists($Dir1)) {
					@include($Dir1);
					$rs_banner[banner_alt] = $txt_alt;
				}else{
					$rs_banner[banner_alt] = '';
				}
			}
			//End chk lang other

			 if($rs_banner[banner_traget] != ''){$target = $rs_banner[banner_traget];}else{ $target = '_blank';}
			 if($rs_set[banner_view]=='V'){ 
			   $V_jquery = 'center';
			   $W_jquery = $rs_set[banner_width];
			   $left = 0;
			  // echo $rs_banner[banner_alt];
			  		if($rs_set[banner_type]=='J'){
					
						$iconn .= "<a href=\"".$link."\"  target=\"".$target."\" onClick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$rs_banner[banner_id]."');\">";
						if($filetypename[1] == 'swf'){
						}else{
						$iconn .="<img src=\"".$rs_banner[banner_pic]."\" border=\"0\" ".$sizes." title=\"".$rs_banner[banner_alt]."\">";
						}
						$iconn .="</a>";
					}else{
						if($rs_set['banner_type']!='P' && $rs_set['banner_type']!='A') {
			   ?>
				  <tr > <td align="center"   background="<?php echo $Current_Dir1.$body_bg_img;?>">
				  <a href="<?php echo $link; ?>"  target="<?php echo $target; ?>" onClick="ajax_save_log('banner_ajax_log.php?banner_id=<?php echo $rs_banner[banner_id]; ?>');">
<?php
						}
				  	if($filetypename[1] == 'swf'){
										echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0"  "'.$sizes.'">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$rs_banner[banner_pic].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$rs_banner[banner_pic].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash"  "'.$sizes.'"> </embed>
										</object>';
									}else{
										if($rs_set['banner_type']=='P' || $rs_set['banner_type']=='A') {	// new banner type
?>
<script type="text/javascript">
	fadeimages<?php echo $BID; ?>[<?php echo $i; ?>] = '<?php echo $rs_banner['banner_pic'];?>';
	linkarr<?php echo $BID; ?>[<?php echo $i; ?>] = '<?php echo $link; ?>';
	numimg<?php echo $BID; ?>[<?php echo $i; ?>] = '<?php echo $rs_banner['banner_pic'];?>';
</script>
					<TD vAlign=center align=middle>
					<a href="<?php echo $link?>"  target="<?php echo $target;?>" onClick="ajax_save_log('banner_ajax_log.php?banner_id=<?php echo $rs_banner[banner_id]?>');">
					<!--IMG onmouseover=chki(this,<?php echo $i; ?>); style="CURSOR: hand" height=20 
					  src="<?php echo $rs_banner[banner_pic]?>" width=20 border=0 
					  name="num_img<?php echo $BID.'_'.$i; ?>" id="num_img<?php echo $BID.'_'.$i; ?>" title="<?php echo $rs_banner['banner_alt']?>"-->
					  <span onmouseover=chki<?php echo $BID; ?>(this,<?php echo $i; ?>); style="CURSOR: hand; text-align:center; font-size:12px; background-color:#000000; border:solid 1px white; margin-left:10px; color:#FFFFFF;" width=30  name="num_img<?php echo $BID.'_'.$i; ?>" 
					  id="num_img<?php echo $BID.'_'.$i; ?>">&nbsp;&nbsp;<?php echo $i+1; ?>&nbsp;&nbsp;</span></TD></a>
					<!--img src="<?php echo $rs_banner[banner_pic]?>" border="0" <?php echo $sizes;?> alt="<?php echo $rs_banner[banner_alt]?>"-->
<?php
										
										} else {
?>
				  <img src="<?php echo $rs_banner[banner_pic]?>" border="0" <?php echo $sizes;?> alt="<?php echo $rs_banner[banner_alt]?>"></a>
<?php									} // banner type=='P'
				  }	//end check file type
					if($rs_set['banner_type']!='P' && $rs_set['banner_type']!='A') {
?>
					</td>
				  </tr>
				<?php
					}
				}
			}else{	//not V
			$V_jquery = 'top';
			$W_jquery = $rs_set[banner_height];
			 $left = '-'.($rs_set[banner_width]*$num_banner)/2;
					if($rs_set[banner_type]=='J'){
					$iconn .= "<a href=\"".$link."\"  target=\"".$target."\" onClick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$rs_banner[banner_id]."');\">";
						if($filetypename[1] == 'swf'){
						}else{
						$iconn .= "<img src=\"".$rs_banner[banner_pic]."\" border=\"0\" ".$sizes." title=\"".$rs_banner[banner_alt]."\">";
						}
					$iconn .= "</a>";
					}else{
						if($rs_set['banner_type']!='P' && $rs_set['banner_type']!='A') {
							if($k%$rs_set[banner_rand_max]==1){ ?><tr><?php } 
                       ?><td align="center"   background="<?php echo $Current_Dir1.$body_bg_img;?>"><a href="<?php echo $link?>"  target="<?php echo $target;?>" onClick="ajax_save_log('banner_ajax_log.php?banner_id=<?php echo $rs_banner[banner_id]; ?>');">
<?php
						}
				  	if($filetypename[1] == 'swf'){
										echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0"  "'.$sizes.'">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$rs_banner[banner_pic].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$rs_banner[banner_pic].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash"  "'.$sizes.'"> </embed>
										</object>';
									}else{
										if($rs_set['banner_type']=='P' || $rs_set['banner_type']=='A') {	// new banner type
?>
<script type="text/javascript">
	fadeimages<?php echo $BID; ?>[<?php echo $i; ?>] = '<?php echo $rs_banner['banner_pic'];?>';
	linkarr<?php echo $BID; ?>[<?php echo $i; ?>] = '<?php echo $link; ?>';
	numimg<?php echo $BID; ?>[<?php echo $i; ?>] = '<?php echo $rs_banner['banner_pic'];?>';
</script>
					<TD vAlign=center align=middle >
					<a href="<?php echo $link; ?>"  target="<?php echo $target;?>" onClick="ajax_save_log('banner_ajax_log.php?banner_id=<?php echo $rs_banner[banner_id]?>');">
					<!--IMG onmouseover=chki(this,<?php echo $i; ?>); style="CURSOR: hand" height=20 
					  src="<?php echo $rs_banner[banner_pic]?>" width=20 border=0 
					  name="num_img<?php echo $BID.'_'.$i; ?>" id="num_img<?php echo $BID.'_'.$i; ?>" title="<?php echo $rs_banner['banner_alt']?>"-->
					  <span onmouseover=chki<?php echo $BID; ?>(this,<?php echo $i; ?>); style="CURSOR: hand; text-align:center; font-size:11px; font-weight:600; background-color:#FFFF00; " width=20 border=0 name="num_img<?php echo $BID.'_'.$i; ?>" id="num_img<?php echo $BID.'_'.i; ?>">&nbsp;&nbsp;<?php echo $i+1; ?>&nbsp;&nbsp;</span></TD></a>
					<!--img src="<?php echo $rs_banner[banner_pic]?>" border="0" <?php echo $sizes;?> alt="<?php echo $rs_banner[banner_alt]?>"-->
<?php
										
										} else {
?>
				  <img src="<?php echo $rs_banner[banner_pic]?>" border="0" <?php echo $sizes;?> alt="<?php echo $rs_banner[banner_alt]?>"></a>
											</td><?php
											if($k%$rs_set[banner_rand_max]==0){ ?></tr><?php }
											$k++;
											}
										} // banner type=='P'
									}
			}
		}//end for	
		if($rs_set['banner_type']=='P' || $rs_set['banner_type']=='A') {
?>
		<!--TD vAlign=center align=middle width=5>
	   <span style="CURSOR: hand; text-align:center; font-size:12px; background-color:#666666; border:solid 1px white; margin-left:10px; color:#FFFFFF;" width=30  name="num_img_right" id="num_img_right" onclick="moveForward<?php echo $BID; ?>();">&nbsp;&nbsp;>&nbsp;&nbsp;</span></TD-->
</TR>
    </TABLE>
		</TD>
  </TR>
</TABLE>
<?php
		}
	}//end if
	}
	if($rs_set[banner_type]=='J'){
			echo "<tr><td><table id='top".$BID."' width=\"".$rs_set[banner_width]."\"  height=\"".$rs_set[banner_height]."\" border=\"0\"><tr><td    valign=\"top\">";
			echo "<div id=\"icon_botton".$BID."\" class=\"demo\">";
			echo $iconn;
			echo "</div>";
			echo "</td></tr></table></td></tr>";
		if($W_jquery =='' || $W_jquery =='0'){ $W_jquery = 48;}

	?>

	<style type="text/css">
		/* #icon_botton<?php echo $BID;?>{
			LEFT: 0px; POSITION: relative; TOP: 0px
		}
		#icon_botton<?php echo $BID;?> DIV.jqDockLabel {
			FONT-WEIGHT: normal; FONT-SIZE: 12px; PADDING-BOTTOM: 0px; COLOR: #000000; PADDING-TOP: 1px; 
		} */
	</style>

<?php } ?>
<?php if($rs_set[banner_type]=='J'){ ?>
<script>
	var mytop = findPosY(document.all.top<?php echo $BID;?>) ;
	var myleft = <?php echo $left;?>;	
	var objDiv = document.getElementById("icon_botton<?php echo $BID;?>");

	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	jQuery(document).ready(function(){
		var opts<?php echo $BID;?> =
		{ align: '<?php echo $V_jquery;?>'
		, size: <?php echo $W_jquery;?>
		, labels: true
		};
		jQuery('#icon_botton<?php echo $BID;?>').jqDock(opts<?php echo $BID;?>);
	});
</script>
<?php } ?>
  </table>
  </td>
     </tr>
</table>  <?php 
 				if(($rs_set['banner_type']!='P') && ($rs_set['banner_type']!='A') && ($b_marquee == 'A' or $b_marquee == 'B' or $b_marquee == 'C' or $b_marquee == 'D')){
					echo "</marquee>";
				}
  ?><?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php
	}
}

##===================================================================================##

function chg_date_th ($date_input)
{
	   $date = substr($date_input,8,2);
	   $mont= substr($date_input,5,2);
	   $year_en = substr($date_input,0,4);
	   $year=$year_en+543;

	   return $date."/".$mont."/".$year;
}

function GenGuestbook($BID){
	global $db;
	global $mainwidth;
	global $global_theme;
	
	$sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$s_id=$rec[block_link];
	
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);

			
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
			 //if($themes_type == 'F'){
			 if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
					$buffer = "";
					$fd = @fopen ($Current_Dir1.$themes_file, "r");
					 while (!@feof ($fd)) {
						$buffer .= @fgets($fd, 4096);
					 }
					@fclose ($fd);
					$design = explode('<?php#htmlshow#?>',$buffer);
			 }
			
	}else{
		$head_font_color='';
		$bg_color='#F6F6F6';
		$Current_Dir1='mainpic/';
		$bg_img='';
		$head_img='';
		$head_height='';
		$body_color='';
		$body_font_color='';
	}
	
	global $filename;
	global $offset;
	global $lang_sh;
	@include("language/language".$lang_sh.".php");
	$path_cal = "../";

	//#####################replace *** to word  #########################
$sql_vul = " SELECT * FROM vulgar_table ";
$query_vul = mysql_query($sql_vul);
$num_vul  = mysql_num_rows($query_vul);
for($i=1;$i<=$num_vul;$i++){
		$rec = $db->db_fetch_array($query_vul);
		$vulels[$i] = $rec['vulgar_text'];		
}
//##############################################################
$chk_config = mysql_query("SELECT * FROM guest_config ");
$CO = $db->db_fetch_array($chk_config);
$message = explode(',',$CO["guest_config_message"]);

//#########################    Chack Date < guest_config_date ########
$d = date(d) - $CO['guest_config_date'];
$m = date(m);
$y = date(Y);
$today = $y."-".$m."-".date(d);
$chk_date=  date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));
//###############################################################


$sel = "SELECT * FROM guestbook_list WHERE   status_guest = 'Y' ORDER BY id_guest DESC ";//WHERE date_guest BETWEEN '$chk_date' AND ' $today' AND

   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = $CO[guest_config_page];

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = mysql_query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = mysql_query($Show); 

if($check_data != 'yes'){ 
			$yes_chk = 'guestbook.php?check_data=yes'; 
			$indata = 'text';
			$no_chk = "self.location.href='$PHP_SELF';document.frm1.name_guest.value='';document.frm1.comment_guest.value=''; ";
			if(!empty($name_guest))$name_guest = stripslashes(htmlspecialchars($name_guest ,ENT_QUOTES));
			if(!empty($comment_guest))$comment_guest = stripslashes(htmlspecialchars($comment_guest ,ENT_QUOTES));
			
}else if($check_data == 'yes'){ //method ?????????		
			$name_guest = stripslashes(htmlspecialchars($name_guest ,ENT_QUOTES));
			$comment_guest = stripslashes(htmlspecialchars($comment_guest ,ENT_QUOTES));
			$name_guest1= $name_guest;
			$comment_guest1 = $comment_guest;
			$sql_vul = " SELECT * FROM vulgar_table ";
			$query_vul = mysql_query($sql_vul);
			$num_vul  = mysql_num_rows($query_vul);
			for($chk=1;$chk<=$num_vul;$chk++){
					$rec = $db->db_fetch_array($query_vul);
					$chk_vulels = $rec['vulgar_text'];							
					
					if(eregi($chk_vulels,$name_guest1)){
							$chk_vulgar = 'Y';
					}
					if(eregi($chk_vulels,$comment_guest1)){
							$chk_vulgar = 'Y';
					}
					$name_guest1   = eregi_replace($chk_vulels, "<font style=background-color:red>".$chk_vulels."</font>",$name_guest1);
					$comment_guest1  = eregi_replace($chk_vulels, "<font style=background-color:red>".$chk_vulels."</font>",$comment_guest1);
					
					unset($chk_vulels);
					
			}					
			
			$yes_chk="guestbook_function.php?name_guest=$name_guest"; 
			$indata = 'hidden';

			$name_guest_print   = $name_guest1;
			$comment_guest_print  = $comment_guest1;
			//##############################################################
			$no_chk = "document.frm1.action='$PHP_SELF' ";
} 
?>
<style type="text/css">
/*
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
*/
</style><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0]; ?>
<script language="javascript1.2" type="text/javascript">
function chk_input(){
		
		if(document.frm1.comment_guest.value == '' && document.frm1.title_show.value == ''){
				alert('<?php echo $text_genguestbook_alertcomment;?>');
				return false;
		}
		if(document.frm1.name_guest.value == ''){
				alert('<?php echo $text_genguestbook_alertname;?>');
				return false;
		}
		//if(document.frm1.surname_guest.value == ''){
			//	alert('<//?php echo $text_genguestbook_alertsurname;?>');
			//	return false;
		//}
		
		if( !validEMail(document.frm1.provice_ctry)){
				alert('<?php echo $text_genguestbook_alertemail;?>');
				return false;
		}else{
				document.frm1.action='<?php echo $yes_chk?>';
		}
}
</script>
<style type="text/css">
/*
.style1 {color: #000000}
*/
</style>
<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="0"><form name="frm1" action="" method="post">
          <tr> 
            <td colspan="2" valign="top">          
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td align="right"><a href="##" onClick="window.open('guestbook.php','','width=800 , height=880,scrollbars=1,resizable = 1');"><img src="mainpic/m_address.gif" border="0" width="20" height="20" align="absmiddle"> <span class="text_normal"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><strong><?php echo $text_genguestbook_add;?></strong></span></font></span> </a></td>
				  </tr>
				</table>
				<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
				 <tr>
					<td align="center" bgcolor="#FFFFFF">
				<table border="0" width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
								  <tr align="center"> 
										<td width="72%" height="33"  bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
										<font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><strong><?php echo $text_genguestbook_title;?></strong></span></font></td>
								  </tr>
					
								  <tr > 
									<td align="center" height="30" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
									<?php
							
						  if($rows > 0){
						  	$tmpGroup='';
						   while($rec = $db->db_fetch_array($Execsql)){ 
								$count = $db->query("SELECT * FROM guestbook_list WHERE id_guest = '$rec[id_guest]' ");
								$countrow = mysql_num_rows($count);
								$date_print = chg_date_th($rec['date_guest']);
								if($tmpGroup!=$rec['title_message']) {
									$tmpGroup=$rec['title_message'];
				?><table width="100%" border="0" cellspacing="1" cellpadding="5">
                                      <tr>
                                        <td align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">หัวข้อ : </span></font></td>
                                        <td><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo str_replace($vulels, "***",$rec['title_message']);?></span></font></td>
                                      </tr>
									  <tr>
                                        <td align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_message;?> : </span></font></td>
                                        <td><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo str_replace($vulels, "***",$rec['detail_guest']);?></span></font></td>
                                      </tr>
									  <tr>
                                        <td width="22%" align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_name;?> :</span></font></td>
                                        <td width="78%"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo str_replace($vulels, "***",$rec['name_guest']);?></span></font></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_unit;?> : </span></font></td>
                                        <td><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo str_replace($vulels, "***",$rec['unit_guest']);?></span></font></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_email;?> : </span></font></td>
                                        <td><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo str_replace($vulels, "***",$rec['country_province']);?></span></font></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_day;?> : </span></font>&nbsp;</td>
                                        <td><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php print $date_print;?></span></font></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="right"><hr size="0.2" color="#C8C8C8"></td>
                                      </tr>
<?php
								} else {
?>
					<table width="100%" border="0" cellspacing="1" cellpadding="5">
                                      <tr>
                                        <td align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_message;?> : </span></font></td>
                                        <td><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo str_replace($vulels, "***",$rec['detail_guest']);?></span></font></td>
                                      </tr>
									  <tr>
                                        <td width="22%" align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_name;?> :</span></font></td>
                                        <td width="78%"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo str_replace($vulels, "***",$rec['name_guest']);?></span></font></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_unit;?> : </span></font></td>
                                        <td><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo str_replace($vulels, "***",$rec['unit_guest']);?></span></font></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_email;?> : </span></font></td>
                                        <td><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo str_replace($vulels, "***",$rec['country_province']);?></span></font></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_genguestbook_day;?> : </span></font>&nbsp;</td>
                                        <td><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php print $date_print;?></span></font></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="right"><hr size="0.2" color="#C8C8C8"></td>
                                      </tr>
                                    </table>
									<?php
										}			
									}
							 }else{ 
					?><span class="text_normal"><?php echo $text_genguestbook_nodetail;?></span></td>
			      </tr> <?php }  ?>
              </table>
			  
	</td>
     </tr>
</table>
			  <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="0">
			  <?php if($rows > 0){ ?><tr>
								<td height="30" colspan="2"><span class="text_normal"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp;&nbsp;<?php echo $text_genguestbook_page;?> :<?php
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?filename=".$filename."&offset=$prevoffset'>
								<font  color=\"red\"><span class=\"text_normal\">$text_genguestbook_pre</span></font></a>\n\n";
								}
								$pages = intval($rows/$limit); 
								if ($rows%$limit) { 
										$pages++; 
								} 
								for ($i=1;$i<=$pages;$i++) { 
									if (($offset/$limit) == ($i-1)) { 
											echo "<font  color=\"blue\">[ $i ] </font>"; 
									} else { 
											$newoffset=$limit * ($i-1); 
											echo  "<a href='$PHP_SELF?filename=".$filename."&offset=$newoffset'". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\"><span class=\"text_normal\">$i</span></font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href='$PHP_SELF?filename=".$filename."&offset=$newoffset'>
										<font color=\"red\"><span class=\"text_normal\">$text_genguestbook_next</span></font></a>"; 
								}
								?></strong></span></font></span></td>
						</tr>
					<?php } ?>
			</table>

			</td>
          </tr>  </form>
</table>
<?php echo $design[1]; ?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php
	}//end GenGuestbook
	

function GenSitemap($BID){
    global $db;
	global $mainwidth;
	global $global_theme;
	@include("ewt_module_sitemap.php");
	
	$sql = $db->query("select block_link,block_themes from block where BID = '$BID' ");
	$rec = $db->db_fetch_array($sql);
	$sitemapid = $rec["block_link"];
	if($rec[block_themes] != '0'){$themeid = $rec[block_themes];}else{$themeid = $global_theme;}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);
	@include("themesdesign/".$namefolder."/".$namefolder.".php");
	}


    $sql="select * from menu_setting where s_id ='$sitemapid'";
    $query = $db->query($sql);
    $data1 = $db->db_fetch_array($query);
if($data1['s_map_type']=='1') {
	$column=$data1[s_column];
	if($column==0){$column=1;}	
	if (eregi("%", $bg_width)) {
	 //ok
	 $bg_width2 = (100/$column).'%';
	}else{
	//no ok
	 $bg_width2 = ($bg_width/$column);
	}
?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
 <?php 

#find data menu main
$sqlS = "select m_id from menu_sitemap_list where menu_type = '0' and s_id ='$sitemapid' and sm_active = 'Y'";
$queryS = $db->query($sqlS);
$num_rows = $db->db_num_rows($queryS);
if($num_rows > 0 ){ 
	if($column){echo "<table  width=".$bg_width." border=\"0\">";}
	$i=1;
		while($R = $db->db_fetch_array($queryS)){
						if($i%$column==1 or $column==1){ echo "<tr><td  width=".$bg_width2.">"; }else{ echo "<td width=".$bg_width2.">"; }
						if($data1["s_type"]==0){//defult
						gensitemap_data($themeid,$R[m_id],$sitemapid,$column);//gen data sitemap
						}else if($data1["s_type"]==1){//???????????????????????
						gensitemap_data2($themeid,$R[m_id],$sitemapid,$column);//gen data sitemap
						}
						$i++;
						if($i%$column==1){ echo "</td></tr>";}else if($num_rows == ($i-1)){echo "</td></tr>";}else{echo "</td>"; }
		}
	if($column){echo "</table>";}
	}

  ?>
  <table width="100%" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
  <?php
} else if($data1['s_map_type']=='2') {
?>
	<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0">
  	 <tr>
		<td bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp;แผนผังเว็บไซต์</span></font></span></td>
	  </tr>
	  <tr><td>&nbsp;</td></tr>
	<tr><td style="padding-left:15px;">
<?php
		$qFolder=$db->query('SELECT * FROM temp_main_group ORDER BY Main_Position ASC');
		while($rFolder = $db->db_fetch_array($qFolder)){
			$qFile=$db->query('SELECT ti.* FROM temp_index ti WHERE ti.Main_Group_ID = \''.$rFolder['Main_Group_ID'].'\' AND (SELECT COUNT(id) FROM block_sitemap bs WHERE bs.filename=ti.filename AND sid=\''.$data1['s_id'].'\')>0 ORDER BY filename ASC');
			$numFile=$db->db_num_rows($qFile);
			if($numFile>0) {
				while($rFile=$db->db_fetch_array($qFile)){
					$arrSelected=array();
					$qSelected=$db->query('SELECT * FROM block_sitemap WHERE filename=\''.$rFile['filename'].'\' AND sid=\''.$data1['s_id'].'\'');
					while($rSelected=$db->db_fetch_array($qSelected)) {
						array_push($arrSelected, $rSelected['BID']);
					}
	?>
				 <span class="text_body"><font color="<?php echo $body_font_color; ?>"  face="<?php echo $body_font_face;?>"><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp;&nbsp;&nbsp;&nbsp;<a href="main.php?filename=<?php echo $rFile['filename']; ?>"><img src="images/content_page.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $rFile['filename']; ?></a></span></font></span><br/>
	<?php
					$sql_top = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side IN ('1','2','3','4','5') AND block_function.filename = '".$rFile['filename']."' ORDER BY block_function.side, block_function.position ASC");
					while($TB = $db->db_fetch_array($sql_top)) {
						if(in_array($TB['BID'],$arrSelected)){
?>
							<span class="text_body"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 
<?php
						if($TB['block_type']=='article') {
							$rLink=$db->db_fetch_array($db->query('SELECT article_group.c_id FROM article_group INNER JOIN article_apply ON article_group.c_id = article_apply.c_id AND article_apply.text_id = \''.$TB['BID'].'\' AND article_apply.a_active = \'Y\''));
							echo '<a href="more_news.php?cid='.$rLink['c_id'].'&filename='.$rFile['filename'].'">'.$TB['block_name'].'</a><br/>';
						} else if($TB['block_type']=='menu') {
							$rLink=$db->db_fetch_array($db->query('SELECT article_group.c_id FROM article_group INNER JOIN article_apply ON article_group.c_id = article_apply.c_id AND article_apply.text_id = \''.$TB['BID'].'\' AND article_apply.a_active = \'Y\''));
							echo '<a href="more_news.php?cid='.$rLink['c_id'].'&filename='.$rFile['filename'].'">'.$TB['block_name'].'</a><br/>';
							$qLink=$db->query('SELECT mp.* FROM menu_properties mp, block b WHERE b.BID=\''.$TB[0].'\' AND mp.m_id=b.block_link');
							while($rLink=$db->db_fetch_array($qLink)) {
								echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a href="'.$rLink['Glink'].'&filename='.$rFile['filename'].'">'.$rLink['mp_name'].'</a><br/>';
							}
						} else {
							echo $TB['block_name'].'<br/>';
						}
?></span></font></span>
<?php
							//echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$TB['block_name'].'<br/>';
						}
					}	// end block
				}
				//loopChild($rFolder['Main_Position']);
			} // file > 0
		}	// end while folder
?>
		</td></tr>
  </table>
  
  <table width="100%" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr></table>
<?php
}	// end type 2

}
 function GenFaq($BID){

global $db;
global $mainwidth;
global $global_theme;

$sql = $db->query("select * from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);
$g_id=$rec[block_link];

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);

		
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		//if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
		 //<echo $design[0];
}else{
	$head_font_color='#666666';
	$bg_color='#6A2B00';
	$Current_Dir1='mainpic/';
	$bg_img='';
	$head_img='toolbars.gif';
	$head_height=30;
	$body_color='#FFFFFF';
	$body_font_color='#000099';
}

global $filename;
global $$lang_sh;
@include("language/language".$lang_sh.".php");
?>
<style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
-->
</style>
<?php

if($g_id=='' || !$g_id){
	$wh = "";
}else{
	if(count(explode(',',$g_id))>1){
	$wh = "and f_sub_id IN ($g_id)";
	}else{
	$wh = "and f_sub_id='$g_id'";
	}
}
if($g_id == ''){
$Execsql = $db->query("SELECT * FROM f_subcat where f_use='Y'  and f_parent=0 ORDER BY f_parent ASC,f_sub_no ASC");
$row = $db->db_num_rows($Execsql);
?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
<form name="formSearchFAQ" method="post" action="search_result.php">
  <tr>
    <td align="right">
	     <input name="filename" type="hidden" id="filename" value="<?php echo $filename; ?>"> 
         <input type="text" name="keyword" class="styleMe">
		 <input type="hidden" name="search_mode" value="5">
         <input type="submit" name="search" value="<?php echo $text_genfaq_buttonsrarch;?>" class="styleMe">
     </td>
  </tr>
  </form>
</table>
<?php
  			if($row > 0){
   	while($R = $db->db_fetch_array($Execsql)){ 
	//$f_id = $R[f_sub_id];
	
?>
<table width="<?php echo $bg_width;?>" border="0"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
     <tr>
        <td  bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" height="<?php echo $head_height;?>">
					<span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp;<?php echo ($R[f_subcate]); ?></span></font></span>
	
<!--<?php//php if(trim($R[f_subdetail])){?><br>&nbsp;&nbsp; <font  color="<?php//php echo $head_font_color2;?>"  face="<?php//php echo $head_font_face2;?>"><span  id="Hfont2"  style="font-size: <?php//php echo $head_font_size2;?>"><?php//php echo $R[f_subdetail]?></span></font><?php//php } ?>  -->   
		</td>
     </tr>
	 <tr>
        <td align="center" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
		<?php   
		//$sql_subcat="select * from f_subcat where f_id='$R[f_sub_id]'  and f_use='Y'  ORDER BY f_sub_no ASC "  ;
		$sql_subcat="SELECT * FROM faq WHERE f_sub_id = '$R[f_sub_id]'   and faq_use='Y'  $seld ORDER BY  faq_top DESC ,faq_date DESC limit 0,10"  ;
		$query_subcat=$db->query($sql_subcat);
?>
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"  id="tbbg" background="<?php echo $Current_Dir1.$body_bg_img;?>"  bgcolor="<?php echo $body_color;?>">

<tr>
    <td ><ul><?php 	while($R_SUB=$db->db_fetch_array($query_subcat)){ $f_subid = $R_SUB[f_sub_id]; ?><li><a href="##lo"  onclick="window.open('faq_open.php?fa_id=<?php echo $R_SUB[fa_id];?>','showass','scrollbars=yes,width=650,height=450')"><font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo ($R_SUB[fa_name]); ?></span></font></a></li><?php                       }//while($R_SUB=$db->db_fetch_array($query_subcat)){ ??
	 ?></ul></td>
</tr> 

	 <tr>
	<td align="right" >														  
	 	<a href="faq_list.php?f_id=<?php echo $f_id; ?>&f_sub_id=<?php echo $f_subid; ?>&filename=<?php echo $filename; ?>"  > <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" style="cursor:'hand'"><span id="Bfont" style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"> ดูทั้งหมด</span></font></a> </td>
</tr>  
 </table>

				     
		</td>
     </tr>
</table>
						<?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>

 <?php
                        }//while($R = $db->db_fetch_array($Execsql)){ 
						
           } 
		 }else{
		 $Execsql = $db->query("SELECT * FROM f_subcat where f_use='Y'  $wh ORDER BY f_parent ASC,f_sub_no ASC");
$row = $db->db_num_rows($Execsql);
	if($row > 0){
		while($R = $db->db_fetch_array($Execsql)){ 
	?>
<table width="<?php echo $bg_width;?>" border="0"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
     <tr>
        <td  bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" height="<?php echo $head_height;?>">
					<span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp;<?php echo ($R[f_subcate]); ?></span></font></span>
	
<!--<?php//php if(trim($R[f_subdetail])){?><br>&nbsp;&nbsp; <font  color="<?php//php echo $head_font_color2;?>"  face="<?php//php echo $head_font_face2;?>"><span  id="Hfont2"  style="font-size: <?php//php echo $head_font_size2;?>"><?php//php echo $R[f_subdetail]?></span></font><?php//php } ?>  -->   
		</td>
     </tr>
	 <tr>
        <td align="center" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
		<?php   
		$sql_subcat="SELECT * FROM faq WHERE f_sub_id = '$R[f_sub_id]'   and faq_use='Y'  $seld ORDER BY  faq_top DESC ,faq_date DESC limit 0,10"  ;
		$query_subcat=$db->query($sql_subcat);
?>
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"  id="tbbg" background="<?php echo $Current_Dir1.$body_bg_img;?>"  bgcolor="<?php echo $body_color;?>">

<tr>
    <td ><ul><?php 	while($R_SUB=$db->db_fetch_array($query_subcat)){ $f_subid = $R_SUB[f_sub_id]; ?><li><a href="##lo"  onclick="window.open('faq_open.php?fa_id=<?php echo $R_SUB[fa_id];?>','showass','scrollbars=yes,width=650,height=450')"><font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo ($R_SUB[fa_name]); ?></span></font></a></li>
    <?php                       }//while($R_SUB=$db->db_fetch_array($query_subcat)){ ??
	 ?></ul></td>
</tr> 

	 <tr>
	<td align="right" >	<font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" style="cursor:'hand'"><span id="Bfont" style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">										  
	 	<a href="faq_list.php?f_id=<?php echo $R[f_id]; ?>&amp;f_sub_id=<?php echo $R[f_sub_id]; ?>&amp;filename=<?php echo $filename; ?>"  >ดูทั้งหมด>></font></a> </td>
</tr>  
 </table>

				     
		</td>
     </tr>
</table>
						<?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
	<?php
		}
	}
		 }?>
<?php
 }
  function GenGallery($BID){
 	global $db;
	global $mainwidth;
	global $global_theme;

 //echo "select * from block where BID = '".$BID."' ";
 	$sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$block_link=explode("@",$rec[block_link]);
	$type_choi = $block_link[0];
	$row = $block_link[1]*$block_link[2];
	$cal = $block_link[2];
	
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);
			
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
			//if($themes_type == 'F'){
		   if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
					 while (!@feof ($fd)) {
						$buffer .= @fgets($fd, 4096);
					 }
					@fclose ($fd);
					$exp = "<"."?#htmlshow#?".">";
					$design = explode($exp,$buffer);
			 }
			 //echo $design[0];
	}else{
		
		$bg_color='#F6F6F6';
		$Current_Dir1='mainpic/';
		$bg_img='';
		
		$head_img='';
		$head_height='';
		$head_font_color='#FF6600';
		
		$body_color='#FFFFFF';
		$body_font_color='';
		
		$bottom_color='#FFFFFF';
		
	}
 
 global $filename;
 global $lang_sh;
 @include("language/language".$lang_sh.".php");
 $lang_c = explode('_',$lang_sh);
 ?>
 <style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
-->
 </style>
<?php if($type_choi != '1' && $type_choi != '2'){ ?>

<form name="gallery<?php echo $category_id; ?>" action="" method="post">
<?php
$category_id = $type_choi;
	if($lang_sh != ''){
	$sql_category = "SELECT * FROM gallery_category 
					INNER JOIN lang_gallery_category ON gallery_category.category_id = lang_gallery_category.c_id
					INNER JOIN lang_config ON lang_config.lang_config_id = lang_gallery_category.lang_name
					WHERE lang_config.lang_config_suffix = '$lang_c[1]'  AND lang_field ='category_name' AND category_id = '".$category_id."'";
	}else{
	$sql_category = "SELECT * FROM gallery_category WHERE category_id = '".$category_id."' ";
	}

	$query_category = $db->query($sql_category);
	
	$rs_category = $db->db_fetch_array($query_category);
	
	if($lang_sh != ''){
	$rs_category[category_name] = $rs_category[lang_detail];
	}
	
	$limit = $rs_category[col]*$rs_category[row];
	$hi = $rs_category[height_s];
	$wi = $rs_category[width_s];
	
	if($_POST[page]) $page = $_POST[page];
	else $page = $_GET[page];
	if(!$limit) $limit = 5;
	if($page == '' || $page < 1)$page =1;
	$page1=$page-1;
	if($page1 == '' || $page1 < 0)$page1 =0;
	if($lang_sh != ''){
	$sql_img = "SELECT * FROM gallery_cat_img 
				INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id 
				INNER JOIN lang_gallery_image ON gallery_image.img_id = lang_gallery_image.c_id
				INNER JOIN lang_config ON lang_config.lang_config_id = lang_gallery_image.lang_name
				WHERE gallery_cat_img.category_id = '".$category_id."' and lang_config.lang_config_suffix = '$lang_c[1]' and lang_field ='img_name' ORDER BY cat_img_id,gallery_image.img_id";
	}else{
	$sql_img = "SELECT * FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_cat_img.category_id = '".$category_id."' ORDER BY cat_img_id,gallery_image.img_id";
	}

	$query_img = $db->query($sql_img);
	$num_img = $num_all = $db->db_num_rows($query_img);
	
	if($num_all%$limit==0){
		@$page_all = $num_all/$limit;
	}else{
		@$page_all = (int)($num_all/$limit)+1;
	}
	if($page_all==0) $page_all = 1;
	if($page>=$page_all){$page1 = $page_all-1;$page=$page_all;}
	$sql_2 = $sql_img."  limit ".$page1*$limit.",$limit";
	$query = $db->query($sql_2);
	$num_rows_2 = $db->db_num_rows($query);

?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table><?php echo $design[0];?>
<table width="100%" align="center" cellpadding="3" cellspacing="1" >

  <tr>
    <td valign="top"><table width="<?php echo $bg_width;?>" border="0" cellspacing="0" cellpadding="0" class="text_normal">
      <tr>
        <td ><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><strong><?php //echo $text_GenGallery_cat;?>
          <?php echo $rs_category[category_name];?></strong></span></font></td>
        <td height="30" width="7"></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td >
         <table border="0" cellpadding="5" cellspacing="1" align="center">
            <tr>
<?php @$percent=100/$num_rows_2*$rs_category[col];?>
              <td ><div align="center">
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="text_normal">
                  <?php 
                     
					if($num_rows_2 > 0){
						for($i=1;$i<=$num_rows_2;$i++){
							$rs_img = $db->db_fetch_array($query);
							if($lang_sh != ''){
							$rs_img[img_name] = $rs_img[lang_detail];
							}
							if($i%$rs_category[col] == 0 && $i==1) {
							?>
                  <tr align=\"center\">
                    <?php }?>
                    <td width="100%" align=\"center\" valign="top">
					  
                      <table border="0"   width="100%"  cellpadding="1" cellspacing="1" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" align="center" style="cursor:hand" onMouseOver="document.getElementById('name_<?php echo $rs_img[img_id]?>').style.color = '#FF0000'; " onMouseOut="document.getElementById('name_<?php echo $rs_img[img_id]?>').style.color = '<?php echo $head_font_color2;?>'; " onClick="location.href='gallery_view_img_comment.php?category_id=<?php echo $category_id?>&filename=<?php echo $filename; ?>&img_id=<?php echo $rs_img[img_id]?>&page_cat=<?php echo $page?>&BID=<?php echo $BID?>';">
                        <tr>
                          <td   align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><table border="0" cellpadding="1" cellspacing="1"  align="center">
                            <tr>
                              <th  scope="col" align="center"><table width="<?php echo $wi;?>"  height="<?php echo $hi;?>" border="0" cellpadding="1" cellspacing="0" >
								  <tr>
									<td align="center" valign="bottom"><img src="phpThumb.php?src=<?php echo $rs_img[img_path_s]?>&h=<?php echo $wi;?>&w=<?php echo $hi;?>" hspace="0" vspace="0"  border="1"></td>
								  </tr>
								</table></th>
								    </tr>
                            </table> </td>
					          </tr>
                        <tr>
                          <td  align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size: <?php echo $head_font_size2;?><?php  if($head_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"  id="name_<?php echo $rs_img[img_id]?>"><?php echo $rs_img[img_name]?></span></font></td>
						      </tr>
                        </table>				  	</td>
						  <?php
							if($i%$rs_category[col] == 0 ) {
							?>
                    </tr>
                  <?php }?>
                  <!-- <tr>
                  <td>&nbsp;</td>
                </tr>-->
                  <?php 
						}// end for
					}else{//end if num_rows_2
				?>
                  <tr><td align="center" style="color:#FF0000"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size: <?php echo $head_font_size2;?><?php  if($head_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>" ><strong><?php echo $text_GenGallery_noimg;?></strong></span></font></td>
                  </tr>
                  <?php }?>
                  </table>
              </div></td>
            </tr>
            </table>          <br></td>
      </tr>
      
    </table>
      <table width="100%" border="0" align="left" class="text_normal">
        <tr>
          <td align="right"  scope="col"><span class="text_normal"><?php echo $text_GenGallery_pageno;?>
              <select name="page" onChange="document.gallery<?php echo $category_id; ?>.submit();" >
                <?php
							for($i=1;$i<=$page_all;$i++){
								if($i == $page) $selected = "selected";
								else $selected = "";
								print "<option value=\"$i\" $selected>$i</option>";
							}
						?>
              </select>
<?php echo $page_all;?>
<?php echo $text_GenGallery_page;?></span></td>
        </tr>
      </table></td>
  </tr>
</table><?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>	
</form>
<?php }else{ ?>
  <form name="gallery<?php echo $category_id; ?>" action="" method="post">
<?php
$w = 100;
//if($type_choi  !='1' || $type_choi != '2'){
//$cal = 3;
//$row = 9;
//}
if($type_choi == '2'){
$cat_id = array();
$sql_g = "select * from gallery_tmp_cat_img where tmp_id = '".$BID."'";
$query = $db->query($sql_g);
	if($db->db_num_rows($query) > 0){
		while($R = $db->db_fetch_array($query)){
			array_push($cat_id,$R[category_id]);
		}
		$wh = "WHERE category_id IN (".implode(",", $cat_id).")";
		$wh1 = "and category_id IN (".implode(",", $cat_id).")";
		
		$row = count($cat_id);
		
	}
}
	//$w = '100';
	$cal = 3;
    $w= $w/$cal;
	if($lang_sh != ''){
	$sql_category = "SELECT * FROM gallery_category 
					INNER JOIN lang_gallery_category ON gallery_category.category_id = lang_gallery_category.c_id
					INNER JOIN lang_config ON lang_config.lang_config_id = lang_gallery_category.lang_name
					WHERE lang_config.lang_config_suffix = '$lang_c[1]'  AND lang_field ='category_name' $wh1  order by  category_id ASC";
	}else{
	$sql_category = "SELECT * FROM gallery_category  $wh  order by cat_timestamp DESC,category_id DESC";
	}

	$query_category = $db->query($sql_category);
	$num_rows_2  = $db->db_num_rows($query_category);
	if($num_rows_2<$row){
	$row = $num_rows_2;
	}
?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center"  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>" >

                <table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="0"  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
					  <tr>
						<td colspan="<?php echo $row;?>"  valign="middle" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><strong><?php echo $text_GenGallery_cat;?>
						  </strong></span></font></td>
					  </tr>
                  <?php 
					if($num_rows_2 > 0){
						for($i=1;$i<=$row;$i++){
							$rs_img = $db->db_fetch_array($query_category);
							if($lang_sh != ''){
								$rs_img[category_name] = $rs_img[lang_detail];
							}
							$sql_img = $db->query("select * from gallery_image,gallery_cat_img where gallery_cat_img.img_id=gallery_image.img_id and gallery_cat_img.category_id = '".$rs_img[category_id]."' order by gallery_image.img_id ASC");
							$rec_img = $db->db_fetch_array($sql_img);
							$img_p = $rec_img[img_path_s];
							if (!file_exists($rec_img[img_path_s]) ) {
									$img_p = "mainpic/no-download.gif";
							}
							if($i%$cal == 0 && $i==1) {
							?>
                  <tr >
                    <?php }?>
                    <td  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
					
                      <table border="0" cellpadding="3" cellspacing="1"  align="center"  width="100%"  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
						<tr valign="top" style="cursor:hand"  onClick="location.href='gallery_view_catelogy.php?category_id=<?php echo $rs_img[category_id];?>&filename=<?php echo $filename;?>'">
                          <td  height="150"  align="center" valign="bottom"  ><table width="50" height="50" border="0" cellpadding="6" cellspacing="1" bgcolor="C3C3C3"><tr><td align="center" bgcolor="#FFFFFF"  valign="left">
						 <?php
			//chk img or swf
																			$filetypename = explode('.',$img_p);
																			//print_r($filetypename);
																			if($filetypename[1] == 'swf'){
																			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="150" height="150">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$img_p.'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$img_p.'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="150" height="150"> </embed>
										</object>';
																			}else{
		?> <img src="<?php echo $img_p;?>"  width="150" height="150" align="top"  style="border:1px #C3C3C3 double ; padding:5px;"><?php } ?>
						  </td></tr></table></td></tr>
						  <tr valign="top" ><td  height="50" align="center" valign="top"  ><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"  id="name_<?php echo $rs_img[img_id]?>"><?php echo nl2br($rs_img[category_name]);?></span></font></a></td>
						  
				        </tr>
                        </table>
						</td>
						  <?php
							if($i%$cal == 0 ) {
							?>
                    </tr>
                  <?php }?>
                  <!-- <tr>

                  <td>&nbsp;</td>
                </tr>-->
                  <?php 
						}// end for
						?>
						<tr><td align="right" colspan="<?php echo $cal;?>"  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><a href="gallery_view_catelogy_all.php?flag=all&filename=<?php echo $filename;?>&BID=<?php echo $BID;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"  id="name_<?php echo $rs_img[img_id]?>"><?php echo $text_GenGallery_viewall;?></span></font></a></td></tr>
						<?php
					}else{//end if num_rows_2
				?>
                  <tr><td align="center" style="color:#FF0000"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size: <?php echo $body_font_size;?>"  id="name_<?php echo $rs_img[img_id]?>"><strong><?php echo $text_GenGallery_notfound;?></strong></span></font></td></tr>
                  <?php }?>
                  </table>	
				  
				  	</td>
     </tr>
</table>
				  <?php echo $design[1];?> <table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
</form>
<?php } ?>
 <?php
 }
 
 
 
function GenComplain($BID){
global $db;
global $mainwidth;
global $global_theme;
global $lang_sh,$filename;
$sql = $db->query("select block_themes,block_link from block where BID = '$BID' ");
$count_rec = $db->db_num_rows($sql);
$rec = $db->db_fetch_array($sql);

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);
		
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		//if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
			   $buffer = "";
			   $fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
		 
	
}else{
		$bg_color='#B0733';
		$Current_Dir1='mainpic/';
		$bg_img='';
		
		$bg_width='98%';
		
		$head_img='';
		$head_height='';
		$head_font_color='#FF6600';
		$head_color='#FFF2BF';
		
		$body_color='#FFFFFF';
		$body_font_color='';
		
		$bottom_color='#FFFFFF';
}

@include("language/language".$lang_sh.".php");
if($rec[block_link] == 'A'){
?>
 <style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
-->
 </style>
<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">
<table   width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
            <form name="Complainform" method="post" action="m_complain_sendmail.php"  >
              <tr> 
                <td  colspan="2" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenComplain_head;?></span></font></td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenComplain_title;?>:</span></font></td>
                <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><div align="left"> <font size="2" face="Tahoma"> <span class="text_normal">
                    <input name="topic" type="text" id="topic" /></span>
                    </font></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenComplain_name;?> :</span></font></td>
                <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><div align="left"> <font size="2" face="Tahoma"> 
                    <span class="text_normal"><input name="name" type="text" id="name" /></span>
                    </font></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenComplain_email;?> :</span></font></td>
                <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><div align="left"> <font size="2" face="Tahoma"> 
                    <span class="text_normal"><input name="email" type="text" id="email" /></span>
                    </font></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenComplain_phone;?>:</span></font></td>
                <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><div align="left"> <font size="2" face="Tahoma"> 
                    <span class="text_normal"><input name="tel" type="text" id="tel"  /></span>
                    </font></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenComplain_detail;?> :</span></font></td>
                <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><div align="left"> <font size="2" face="Tahoma"> 
                   <span class="text_normal"> <textarea name="detail" cols="30" rows="5" wrap="physical" id="detail"></textarea></span>
                    </font></div></td>
              </tr>
			  <tr> 
                <td align="right" valign="top" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenComplain_unit;?>:</span></font></td>
                <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
<div align="left">
<?php
$ss = mysql_query("Select * From m_complain_info ");
?>
                    <select name="select">
					<?php
					while($XX = mysql_fetch_row($ss)){
					?>
                      <option value="<?php echo $XX[0]; ?>"><?php echo $XX[1]; ?></option>
<?php } ?>
                    </select>
                  </div></td>
              </tr>
              <tr> 
                <td colspan="2" valign="top" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><div align="center"> 
                    <font size="2" face="Tahoma"> 
                    <input type="submit" name="Submit" value="<?php echo $text_GenComplain_add;?>" />
                    &nbsp; 
                    <input type="reset" name="Submit2" value="<?php echo $text_GenComplain_cancle;?>" />
                    <input type="hidden" name="flag" value="1" />
                    </font></div></td>
              </tr>
            </form>
</table>
	</td>
     </tr>
</table>
 <?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php
	}else if($rec[block_link] == 'B'){
	?>
				<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
				 <tr>
					<td align="center" bgcolor="#FFFFFF"><form name="form1" method="post" action="complain_function.php" onsubmit="return complain_chk(this)" ><table width="100%" border="0" cellpadding="3" cellspacing="1" class="text_normal">
			  <tr>
				<td width="37%" align="right">ประเภทเรื่องร้องเรียน</td>
				<td width="63%">
				<select name="type_name">
				<option value="">ประเภทเรื่องร้องเรียน</option>
				<?php
				$sql_comp = "select Complain_lead_ID,Complain_lead_name from m_complain_info where Complain_lead_status = 'B'";
				$query = $db->query($sql_comp);
				while($R_Comp = $db->db_fetch_array($query)){
				?>
				<option value="<?php echo $R_Comp[Complain_lead_ID];?>"><?php echo $R_Comp[Complain_lead_name];?></option>
				<?php
				}
				?>
				</select>
				<span  style="color:#FF0000">	*    </span></td>
			  </tr>
			  <tr>
				<td align="right">Url เว็บไซต์ที่ไม่เหมาะสม </td>
				<td><input name="url_name" type="text" size="45" value="http://"><span  style="color:#FF0000">	*    </span></td>
			  </tr>
			  <tr>
				<td align="right">รายละเอียดเรื่องร้องเรียน</td>
				<td><textarea name="detail" cols="55" rows="6"></textarea><span  style="color:#FF0000">	*    </span></td>
			  </tr>
			  <tr>
				<td colspan="2"  class="text_head">รายละเอียดผู้ร้องเรียน(ข้อมูลนี้จะเก็บไว้เป็นความลับ หากต้องการให้มีการติดต่อกลับ กรุณากรอกรายละเอียด)</td>
			  </tr>
			  <tr>
				<td align="right">ชื่อผู้ร้องทุกข์/ร้องเรียน</td>
				<td><input name="name" type="text" size="30"></td>
			  </tr>
			  <tr>
				<td align="right">E-Mail Address </td>
				<td><input name="email" type="text" size="30"><span  style="color:#FF0000">	*    </span></td>
			  </tr>
			  <tr>
				<td align="right">เบอร์โทรศัพท์</td>
				<td><input name="tel" type="text" size="30"></td>
			  </tr>
			  <tr>
				<td align="right">&nbsp;</td>
				<td><span id="logpic_complain"><img src="ewt_pic_complain.php" align="absmiddle"></span></td>
			  </tr>
			  <tr>
				<td align="right">กรุณากรอกรหัสตัวเลขตามรูปภาพด้านบนเพื่อยืนยัน</td>
				<td><input name="pict" type="text" size="10">&nbsp;<a href="#changpic" onClick="document.all.logpic_complain.innerHTML = '<img src=ewt_pic_complain.php align=absmiddle>';">[เปลี่ยนภาพใหม่]</a></td>
			  </tr>
			 <tr>
			<td colspan="2" align="center"><span  class="text_normal"><input type="submit" name="Submit" value="    ส่ง    ">
			  <input type="reset" name="Submit2" value="ยกเลิก">
			  <input name="fn" type="hidden" id="fn" value="main.php?filename=<?php echo $filename; ?>"></span></td>
			</tr>
			</table>
			</form>
			</td>
			</tr>
			</table>
	<?php
	}
	?>
	<script language="javascript1.2">
function complain_chk(obj){
	if(obj.type_name.value == ''){
	alert("กรุณาเลือกประเภทเว็บไซต์ไม่เหมาะสม");
	return false;
	}
	if(obj.url_name.value.length == '7'){
	alert("กรุณากรอก Url");
	return false;
	}
	if(obj.detail.value == ''){
	alert("กรุณากรอกรายละเอียด");
	return false;
	}
	if(obj.email.value == ''){
	alert("กรุณากรอกe-mail");
	return false;
	}
	if(obj.pict.value == ''){
	alert("กรุณากรอกอักษรภาพ");
	return false;
	}
}
</script>
	<?php
}
?>

<?php
function random_code($len){
			srand((double)microtime()*10000000);
			$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
			$ret_str = "";
			$num = strlen($chars);
			for($i=0;$i<$len;$i++){
				$ret_str .= $chars[rand()%$num];
			}
			return $ret_str;
	}




 function GenDownload($BID){

	global $db;
	global $mainwidth;
	global $global_theme;

	$sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$g_id=$rec[block_link];

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}

	if($themeid != "0" AND $themeid != ""){
		$namefolder = "themes".($themeid);

		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		//if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
		 //<echo $design[0];
	}else{
		$head_font_color='#666666';
		$bg_color='#6A2B00';
		$Current_Dir1='mainpic/';
		$bg_img='';
		$head_img='toolbars.gif';
		$head_height=30;
		$body_color='#FFFFFF';
		$body_font_color='#000099';
	}

global $filename;
global $$lang_sh;
@include("language/language".$lang_sh.".php");
?>
<style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
-->
</style>
	


<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
<form name="formSearchFile" method="post" action="search_download.php?filename=<?php echo $filename;?>">
  <tr>
    <td align="right">
          <input type="text" name="keyword" class="styleMe"> 
		 <input type="hidden" name="search_mode" value="1">
         <input type="submit" name="search" value="ค้นหาเอกสาร" class="styleMe"  onClick="return chkSchButt(document.formSearchFile.keyword)">
     </td>
  </tr>
  <tr>
    <td align="right"><a href="search_download_adv.php">ค้นหาขั้นสูง</a></td>
  </tr>
  </form>
  <script>    function chkSchButt(c){   if(c.value!=''){ return true; }else{ return false;}  } </script>
</table>

<?php

if($g_id=='' || !$g_id){
   $wh="AND dlg_parent = '0' ";
}else{
   $g=explode(',',$g_id);
   $wh= " AND ( dlg_id  = '".$g[0]."'";
   for($i=0;$i<sizeof($g);$i++){
       $wh.=" OR dlg_id = '".$g[$i]."'";
   }
    $wh.=")";
}

$Execsql = $db->query("SELECT * FROM docload_group where dlg_id <> '' $wh  ORDER BY dlg_name ASC");
$row = $db->db_num_rows($Execsql);


  			if($row > 0){
   	while($R = $db->db_fetch_array($Execsql)){ 
	$g_id = $R[dlg_id];
?>
<table width="<?php echo $bg_width;?>" border="0"  cellpadding="0" cellspacing="0"><tr> <td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
     <tr>
        <td  bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" height="<?php echo $head_height;?>">
					<span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp;<?php echo ($R[dlg_name]); ?></span></font></span>
		</td>
     </tr>
	 <tr>
        <td align="center" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
		<?php   
		$sql_subcat="SELECT * FROM docload_list WHERE dl_dlgid = '$R[dlg_id]' AND dl_open='Y'  $seld ORDER BY  dl_count  DESC ,dl_update DESC limit 0,10"  ;
		$query_subcat=$db->query($sql_subcat);
?>
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"  id="tbbg" background="<?php echo $Current_Dir1.$body_bg_img;?>"  bgcolor="<?php echo $body_color;?>">

<tr>
    <td ><ul><?php 	
	while($R_SUB=$db->db_fetch_array($query_subcat)){ 
	//$f_subid = $R_SUB[dl_dlgid]; ?>
	<li><a href="##lo"  onclick="window.open('download_detail.php?dl_id=<?php echo $R_SUB[dl_id];?>','showass','scrollbars=yes,width=650,height=450')"><font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo ($R_SUB[dl_detail]); ?></span></font></a></li>
		<?php  }//while($R_SUB=$db->db_fetch_array($query_subcat)){ ??  ?></ul></td>
</tr> 

	 <tr>
	<td align="right" >														  
	 	<a href="download_list.php?f_id=<?php echo $f_id; ?>&f_sub_id=<?php echo $g_id; ?>&filename=<?php echo $filename; ?>"  > <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" style="cursor:'hand'"><span id="Bfont" style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"> ดูทั้งหมด></span></font></a> </td>
</tr>  
 </table>

				     
		</td>
     </tr>
</table>
						<?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>

 <?php
                        }//while($R = $db->db_fetch_array($Execsql)){ 
						
           } ?>
<?php
 }




function GenLogin($BID){
global $db;
global $mainwidth;
global $global_theme;
global $EWT_DB_NAME;
global $filename;
global $lang_sh;
global  $EWT_FOLDER_USER;
global  $EWT_DB_USER;
//echo $lang_sh;
@include("language/language".$lang_sh.".php");

$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	
	if($themeid != "0" AND $themeid != ""){
$namefolder = "themes".($themeid);
@include("themesdesign/".$namefolder."/".$namefolder.".php");
//if($themes_type == 'F'){
 	$buffer = "";
	if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
 	$fd = @fopen ($Current_Dir1.$themes_file, "r");
	 while (!@feof ($fd)) {
		$buffer .= @fgets($fd, 4096);
	 }
 	@fclose ($fd);
	$exp = "<"."?#htmlshow#?".">";
	$design = explode($exp,$buffer);
 }
 
}
 if($_SESSION["EWT_MID"] == ""){

?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
	
    <table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
        <tr>
          <td align="center" bgcolor="#FFFFFF">
		  
<table width="<?php echo $bg_width;?>"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
<form name="form_loginm<?php echo $BID;?>" method="post" action="ewt_login.php" onSubmit="return chkp<?php echo $BID;?>();">
    <tr>
      <td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>">&nbsp;<?php echo $text_GenLogin_name;?></span></font></span></td>
    </tr>
    <tr>
      <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
	  <table id="firstbox<?php echo $BID;?>" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" align="center" ><label><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><?php echo $text_GenLogin_title1;?></span></font></span>
              <input name="ewt_user1" type="text" id="ewt_user1"  value=""   size="10">
            </label></td>
          </tr>
          <tr>
            <td height="30" align="center"><label><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><?php echo $text_GenLogin_title2;?></span></font></span> <input name="ewt_pass1" id="ewt_pass1" type="password"   value=""   size="10"></label></td>
          </tr>
          <tr>
            <td height="22" align="center"><label>
              <input type="button" name="submit2"  value="<?php echo $text_GenLogin_name;?>" OnClick="chk<?php echo $BID;?>();">
            </label></td>
          </tr>
      </table>
	  <table  id="secbox<?php echo $BID;?>" width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none">
              <tr>
                <td align="center"><label><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>">เพื่อความปลอดภัย กรุณากรอกตัวเลข</span></font></span><br><a href="#change"  onClick="Getmessage<?php echo $BID;?>();"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><u>คลิ๊กที่นี่</u> เพื่อเปลี่ยนรูป</span></font></span></a>
				</label><div id="logpic<?php echo $BID;?>"><img src="ewt_pic.php" align="absmiddle"></div> <input name="chkpic1<?php echo $BID;?>" type="text" id="chkpic1<?php echo $BID;?>"  size="4" /><label>
				<input name="Submit32" type="Submit" value="  OK  " >
                 
				  <script language="javascript">
				function Getmessage<?php echo $BID;?>(){
					current_local_time = new Date();
					document.all.logpic<?php echo $BID;?>.innerHTML = "<img src=ewt_pic.php?#" + current_local_time.getDate() + (current_local_time.getMonth()+1) + current_local_time.getYear() + current_local_time.getHours() + current_local_time.getMinutes() +current_local_time.getSeconds() + "  align=absmiddle>";
					document.form_loginm<?php echo $BID;?>.chkpic1<?php echo $BID;?>.select();

				  }	  
				  </script>
                </label></td>
              </tr>
            </table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" height="23"><label>
                  <a href="frm_gen_user.php"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><?php echo $text_GenLogin_addmember ;?>&nbsp;</span></font></span></span></a>
                </label> <label>
                  <a href="##" onClick="window.open('member_forgot.php','','width=350,height=120');"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>">|&nbsp;<?php echo $text_GenLogin_forget  ;?></span></font></span></span></a><br />
				  	<?php
	$db->query("USE ".$EWT_DB_USER);
		$sql_info = "select url,login_openid from user_info where EWT_User = '".$EWT_FOLDER_USER."'";
	$query_info = $db->query($sql_info);
	$rec_info  = $db->db_fetch_array($query_info);
	if($rec_info[url] != ''){
	$url = $rec_info[url];
	}else{
	$url = $_SERVER['HTTP_HOST'].'/';
	}
	$ststusopenid = $rec_info[login_openid];
	$db->query("USE ".$EWT_DB_NAME);
	if($ststusopenid == 'Y'){
	?>
				 <a href="#L" onclick="openid<?php echo $BID;?>();"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>">Openid Login</span></font></span></span></a>
		<?php } ?>
                <input name="fn" type="hidden" id="fn" value="main.php?filename=<?php echo $filename; ?>">
                 <input id="Flag" type="hidden" value="AcceptLogin" name="Flag" />
				 <input id="BID" type="hidden" value="<?php echo $BID;?>" name="BID" /></label></td>
              </tr>
            </table></td>
    </tr>
	</form>

	<form action="http://www.bizpotential.com/sso_project/rpx_sign_in.php" method="post" name="frm<?php echo $BID;?>">
	<input name="redirect" type="hidden" value="<?php echo $url;?>openid_function.php" >
	</form>
  </table>

  </td>
        </tr>
      </table>
  <?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
  <script language="JavaScript">
function openid<?php echo $BID;?>(){
document.frm<?php echo $BID;?>.submit();
 }
function chk<?php echo $BID;?>(){
	if(document.form_loginm<?php echo $BID;?>.ewt_user1.value == ""){
			alert("<?php echo $text_GenLogin_alertusername;?>");
			document.form_loginm<?php echo $BID;?>.ewt_user1.focus();
			return false;
	}else if(document.form_loginm<?php echo $BID;?>.ewt_pass1.value == ""){
			alert("<?php echo $text_GenLogin_alertpassword;?>");
			document.form_loginm<?php echo $BID;?>.ewt_pass1.focus();
			return false;
	}else{
	document.all.firstbox<?php echo $BID;?>.style.display = 'none';
	document.all.secbox<?php echo $BID;?>.style.display = '';
	document.form_loginm<?php echo $BID;?>.chkpic1<?php echo $BID;?>.focus();
	}

}
function chkp<?php echo $BID;?>(){
		if(document.form_loginm<?php echo $BID;?>.chkpic1<?php echo $BID;?>.value == ""){
			alert("<?php echo $text_GenLogin_alertpictext;?>");
			document.form_loginm<?php echo $BID;?>.chkpic1<?php echo $BID;?>.focus();
			return false;
	}
}
</script>
<?php
}else{
$db->query("USE ".$EWT_DB_USER);
$_SESSION["EWT_SMID"] = $_SESSION["EWT_MID"];
//echo "SELECT site_intra FROM user_info WHERE EWT_User = '".$EWT_FOLDER_USER."'  ";
$sql_site = $db->query("SELECT site_intra FROM user_info WHERE EWT_User = '".$EWT_FOLDER_USER."'  ");
$intra = $db->db_fetch_row($sql_site);
	?>
<script type="text/javascript" src="js/jquery/jquery-1.2.2.pack.js"></script>

<script type="text/javascript" src="js/jquery/ddaccordion.js"></script>
<SCRIPT type=text/javascript>

ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click" or "mouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='mainpic/arrow2.gif' class='statusicon' />", "<img src='mainpic/arrow3.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "normal", //speed of animation: "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		myiframe=window.frames["myiframe"]
		if (expandedindices.length>0 && expandedindices[expandedindices.length-1]>=2)
			myiframe.location.replace(headers[expandedindices.pop()].getAttribute('href')) //Get "href" attribute of final expanded header to load into IFRAME
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		if (state=="block" && isuseractivated==true && index>=2){ //if header is expanded and as the result of the user initiated action
			myiframe.location.replace(header.getAttribute('href'))
		}
	}
})

</SCRIPT>
<STYLE type=text/css>
.glossymenu DIV.submenu {
	BACKGROUND: white;BORDER-BOTTOM: #9a9a9a 1px solid;BORDER-LEFT: #9a9a9a 1px solid;BORDER-TOP: #9a9a9a 1px solid;BORDER-RIGHT: #9a9a9a 1px solid;
}
.glossymenu DIV.submenu UL {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP:0px; LIST-STYLE-TYPE: none
}
.glossymenu DIV.submenu UL LI {
	BORDER-BOTTOM: white 0px solid;
}
.glossymenu DIV.submenu UL LI A {
	PADDING-RIGHT: 0px; DISPLAY: block; PADDING-LEFT: 10px; PADDING-BOTTOM: 2px; FONT: 13px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif; COLOR: black; PADDING-TOP: 2px; TEXT-DECORATION: none
}
.glossymenu DIV.submenu UL LI A:hover {
	BACKGROUND: #dfdccb; colorz: white
}
</STYLE>
<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>"align="center" cellpadding="0"  border="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
  <tr>
    <td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>">ยินดีต้อนรับ คุณ <?php echo $_SESSION["EWT_NAME"];?></span></font></span></td>
  </tr>
<!--<tr>  <?php//php if($EWT_FOLDER_USER == "dmr_web"){ ?>

    <td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ><a href="../dmr_intranet"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>">เข้าสู่เว็บไซต์อินทราเน็ต</span></font></span></a></td>
  </tr>
  <?php//php } ?>-->
  <tr>
    <td>
	<table width="100%" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
  <tr>
    <td >
<DIV class=glossymenu  style="cursor:hand">
  <?php if($EWT_FOLDER_USER == "dmr_web" AND $_SESSION["EWT_ORG"] != "0"){ ?><a href="../dmr_intranet"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"  ><span style="font-size: <?php echo $body_font_size;?>">เข้าสู่เว็บไซต์อินทราเน็ต</span></font></span></a>
<br ><hr > <?php } ?>
<span  style="height: 20px;"><a href="#logout" onClick="if(confirm('ออกจากระบบ')){self.location.href='logout.php';}"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/close.gif" width="24" height="24" align="absmiddle" border="0"> ออกจากระบบ</span></font></span></a> </span><br /><hr />
<!--span class="submenuheader" style="height: 20px;"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"  >
<span style="font-size: <?php echo $body_font_size;?>">Website</span></font></span></span>
  <DIV class=submenu  >
      <UL>
        <!--<LI><a href="#logout" onClick="if(confirm('ออกจากระบบ')){self.location.href='logout.php';}"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/close.gif" width="24" height="24" align="absmiddle" border="0"> 
                        ออกจากระบบ</span></font></span></a> 
		<LI><a href="main3.php?filename=index"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_custom.gif" width="24" height="24" border="0" align="absmiddle" /> Customize your home page</span></font></span></a>-->
		<!--LI><a href="sendprnews.php" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_custom.gif" width="24" height="24" border="0" align="absmiddle" />ระบบฝากข่าวประชาสัมพันธ์</span></font></span></a>
		</LI>
	</UL>
</DIV>
<br />
<span class="submenuheader" style="height: 20px;"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"> Profile</span></font></span></span>
<DIV class=submenu>
      <UL>
        <LI><a href="frm_gen_user_edit.php"><img src="mainpic/m_profile.gif" width="24" height="24" border="0" align="absmiddle"> 
                       <span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"> Edit Profile</span></font></span></a>
		</LI>
	</UL>
</DIV>	
  <?php
						$pass = "0";
		$reccount1 = $db->db_fetch_row($db->query("SELECT COUNT(permission.p_id) as ccs FROM permission WHERE ( p_type = 'U' AND pu_id = '".$_SESSION["EWT_MID"]."' ) AND permission.s_type = 'asset' "));
		if($reccount1[0] > 0){
			$site1 = "p";
			$pass = "1";
		}
	//echo "SELECT org_id FROM gen_user Where  gen_user_id= '".$_SESSION["EWT_MID"]."' ";
				$reccount2 = $db->db_fetch_row($db->query("SELECT org_id FROM gen_user Where  gen_user_id= '".$_SESSION["EWT_MID"]."' "));
		if($reccount2[0] == '0'){
			$site1 = "";
			$pass = "0";
		}else{
			$site2 = "p";
			$pass = "1";
		}
						?>
						<?php
						if((@include("../blog/lib/blog_config.php")) AND ($site2 == "p")){
						?>
	<br />
  <span class="submenuheader" style="height: 20px;"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size: <?php echo $body_font_size;?>"> Blog</span></font></span></span>
 <DIV class=submenu>
	<UL>
					<?php
						$sql_profile="SELECT * FROM `blog_list` WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";
						$exc_profile=$db->query($sql_profile);
						$count_profile=$db->db_num_rows($exc_profile);
						if($count_profile > 0){
						while($row_profile=$db->db_fetch_array($exc_profile)){
										$photo_name="nophoto.jpg";
								if($row_profile[blog_picture]){
									$photo_name= $row_profile[blog_picture];
								}
					?>
                   
						<LI><a href="<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="phpThumb.php?src=../blog/images_profile/<?php echo $photo_name; ?>&h=120&w=120" border="0" align="absmiddle" > <?php echo $row_profile[blog_title]; ?></span></font></span></a>
									<?php }}else{ ?>
						<LI><a href="<?php echo $blog_url; ?>blog_install.php"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_blog.gif" width="24" height="24" border="0" align="absmiddle"> 
													Create Your Blog</span></font></span></a>
					<?php } ?>

  				</LI>
			</UL>
		</DIV>	
  <?php } ?>
<br />
<span class="submenuheader" style="height: 20px;"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"> E-newsletter </span></font></span></span>
 <DIV class=submenu>
	<UL><LI><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size:<?php echo $body_font_size2;?>">
							<img src="mainpic/mail2.gif" width="24" height="24" border="0" align="absmiddle">
							<?php
							//$ewt_email = 'tatorera@hotmail.com';
							$sql_user = "select email_person from gen_user where gen_user_id ='".$_SESSION["EWT_MID"]."'";
							$query_user = $db->query($sql_user);
							$rec_user = $db->db_fetch_array($query_user);
							$db->query("USE ".  $EWT_DB_NAME);
							if($rec_user[email_person] != ''){
									$sql_enews = "select * from n_member where m_email ='".$rec_user[email_person]."'";
									$query_enews = $db->query($sql_enews);
									
								if($db->db_num_rows($query_enews)>0){ 
								?>&nbsp; <a href="#d" onClick="window.open('newsletter_edit.php','','width=500 , height=300, scrollbars=1,resizable=1');">บริหารจดหมายข่าว</a>
								<img src="mainpic/mail_del.gif" width="24"  border="0" align="absmiddle">
								<a href="newsletter_edit.php?del_new=Y" target="funcas" onClick="return confirm('ยืนยันการยกเลิกจดหมายข่าว')"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size:<?php echo $body_font_size2;?>"><font color=red>ยกเลิกจดหมายข่าว</font></span></font></span></a></font>
								<?php
								}else{ 
								?><a href="#d" onClick="window.open('newsletter_add.php','','width=500 , height=300, scrollbars=1,resizable=1');"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size:<?php echo $body_font_size2;?>">สมัครจดหมายข่าว</span></font></span></a><?php 
								}
							}else{
								?>
								<font color=red>ท่านยังไม่มี email<br />(กรุณาแก้ไขที่<a href="frm_gen_user_edit.php"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size:<?php echo $body_font_size2;?>">Edit profile</span></font></span></a>)</font>
								<?php
							}
							$db->query("USE ".$EWT_DB_USER);
							
							?>	</span></span></span><iframe name="funcas" width="0" height="0" scrolling="no"></iframe>
						</LI>
			</UL>
		</DIV>	
<br />
<span class="submenuheader" style="height: 20px;"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size: <?php echo $body_font_size;?>"> Tools</span></font></span></span>
	   <DIV class=submenu>
									<UL>
								<?php
								if($site2 == "p"){
								?>
                              <LI><a href="message.php" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_message.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบข้อความ</span></font></span></a>
									<?php
$sql_new="SELECT COUNT(id) as newmail FROM n_message 
WHERE m_to = '".$HTTP_SESSION_VARS['EWT_MID']."' 
AND m_flaginout = '1' 
AND m_flagdel='0'  
AND m_flagnewold = '1'
";
$query_new=$db->query($sql_new);
$data_new=$db->db_fetch_array($query_new) ;
echo '(่'.$data_new[newmail].' ไม่ได้อ่าน)';
?>

								<?php } ?>

                               <LI><a href="favorite.php" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_favorites.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจัดเก็บเนื้อหา (Favorites)</span></font></span></a> 
								<LI><a href="address.php" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_address.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจัดเก็บ Address</span></font></span></a>
                                <LI><a href="contact_index.php" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_contact.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบ Contact</span></font></span></a>
                        	</LI>
			</UL>
		</DIV>		     
  							<?php
								if($pass == "1"){
								?>
<br /><span class="submenuheader" style="height: 20px;"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"> Application</span></font></span></span>
	 <DIV class=submenu>
	<UL>						
	<LI>	<a href="/ewtadmin" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_custom.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบบริหารเว็บไซต์</span></font></span></a>
	<?php
								if($site1 == "p" AND $intra[0] == "Y" AND $EWT_FOLDER_USER == "dmr_web" ){
								?>
                               <LI>	<a href="../w2/asset/Synchronize.php" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_asset.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจัดการทรัพย์สิน</span></font></span></a>
								<?php
								}
								if($site2 == "p" AND $EWT_FOLDER_USER == "dmr_web"){
								?>
                                <LI>	<a href="../w2/monitoring/Synchronize.php" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_task.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจัดการงานที่รับผิดชอบ</span></font></span></a>
								<?php } ?>
								<?php
								if($site2 == "p" AND $intra[0] == "Y" AND $EWT_FOLDER_USER == "dmr_web"){
								?>
                               <LI>	<a href="../w2/reserve/Synchronize.php" target="_blank"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="mainpic/m_borrow.gif" width="24" height="24" border="0" align="absmiddle"> 
                                    ระบบจอง ยืม คืน อุปกรณ์</span></font></span></a>
								<?php } ?>
                               
	
              	</LI>
			</UL-->
		</DIV>	 <?php } ?>
	</DIV>	 
	<IFRAME style="WIDTH: 0;HEIGHT: 0px"  name=myiframe src="about:blank"></IFRAME>
	</td>
  </tr>
</table>
	</td>
  </tr>
</table>
<?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>



<?php
$db->query("USE ".$EWT_DB_NAME);
}
	
 }
 function GenVdo($BLink,$BID){
	global $db;
	global $global_theme;
	global $filename;
	$x=explode(',',$BLink);
	$vdo=$x[0];									//link ID  vdo group
	$vdo_WIDTH=$x[1];                //vdo width
	$vdo_HEIGHT=$x[2];              //vdo height
	$vdo_AUTOPLAY=$x[3];                   //vdo play type
	$vdo_LIST=$x[4];
	if($vdo_WIDTH==''){  $vdo_WIDTH=200; }
	if($vdo_HEIGHT==''){  $vdo_HEIGHT=200; }
	if($vdo_AUTOPLAY==''){  $vdo_AUTOPLAY='N'; }
	if($vdo_LIST=='' || $vdo_LIST=='0'){  $vdo_LIST=''; }else{ $vdo_LIST='LIMIT 0,'.$vdo_LIST;$MORE_SHOW='Y';}

 	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);

	@include("themesdesign/".$namefolder."/".$namefolder.".php");
	$bg_color1=ereg_replace ("#", "0x", $bg_color);
	$head_color1=ereg_replace ("#", "0x", $head_color);
	$body_color1=ereg_replace ("#", "0x", $body_color);
	$head_font_face1 = ereg_replace ("#", "0x", $head_font_face);
	//if($themes_type == 'F'){
		$buffer = "";
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
		$fd = @fopen ($Current_Dir1.$themes_file, "r");
		 while (!@feof ($fd)) {
			$buffer .= @fgets($fd, 4096);
		 }
		@fclose ($fd);
	    $exp = "<"."?#htmlshow#?".">";
		$design = explode( $exp,$buffer);
		$bg_color1=ereg_replace ("#", "0x", '#333333');
		$head_color1=ereg_replace ("#", "0x", '#F8F8F8');
		$body_color1=ereg_replace ("#", "0x", '#FFFFFF');
		$head_font_face1 = ereg_replace ("#", "0x", '#000099');
	 }
	}
	if($bg_color1 == ''){$bg_color1 = '';}
	if($head_color1 == ''){$head_color1 = '0xF8F8F8';}
	if($body_color1 == ''){$body_color1 = '0x000000';}
	if($head_font_face1 == ''){$head_font_face1 = '0x000099';}
	if($bg_color == ''){$bg_color = '#333333';}


// $Current_Dir = "file_vdo/vdo_".$vdo.'.xml';
 //if (file_exists($Current_Dir)) {
	 if($vdo){
 	$sql = "SELECT vl.*, vg.vdog_downloadable, vg.vdog_name FROM vdo_list vl JOIN vdo_group vg ON vg.vdog_id=vl.vdo_group WHERE vdo_group = '$vdo' ORDER BY vdo_id DESC $vdo_LIST";
	$query=$db->query($sql);
	$data1=$db->db_fetch_array($query);
	
	$Current_Dir="download/file_vdo/mediaplayer";
	$Current_Dir2="download/file_vdo/mediaplayer";
 ?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
 <?php echo $design[0]; ?>

<script type="text/javascript" src="swfobject.js"></script>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">
 <table width="<?php echo $bg_width;?>" border="0" cellspacing="0" cellpadding="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" align="center">
  <tr>
      <td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
	  
	       <strong><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"><?php echo $data1[vdog_name];?></span></font></strong>
	  </td>
  </tr>
  <tr>
       <td align="center">
	   <?php
			   $sql = "SELECT vl.*, vg.vdog_downloadable FROM vdo_list vl JOIN vdo_group vg ON vg.vdog_id=vl.vdo_group WHERE vdo_group = '$vdo' ORDER BY vdo_id DESC $vdo_LIST";
				$query=$db->query($sql);
				$data1=$db->db_fetch_array($query);
	 $filetype = explode('.',$data1[vdo_filename]);
				//echo $data1[vdo_filename];
		
	   ?>
	<script type="text/javascript" src="js/jquery.media.js"></script>
	<script>
var urlname = document.URL.split("/");
var urlen = (urlname.length - 1);
var myurl = "";
for(i=0;i<urlen;i++){
myurl = myurl + urlname[i] + "/";
}
	
//alert(myurl);
		    function play<?php echo $BID;?>(vdoFile,id) {
			
				var url = vdoFile.split(".");
				
				if(url[1] == 'wma' || url[1] == 'wmv' || url[1] == 'avi'){
		
				document.getElementById('SM<?php echo $BID;?>').innerHTML = '';
				 $(function() {
						$('div.media<?php echo $BID;?>').media(
						{
						width:<?php echo $vdo_WIDTH;?>, 
						height:<?php echo $vdo_HEIGHT;?>, 
						autoplay: true , 
						src :      vdoFile
						}
						);
					});
				vdo_count<?php echo $BID;?>.location.href = "vdo_count.php?v="+id;
				}else{
				var s<?php echo $BID;?> = new SWFObject("media/mediaplayer.swf","single<?php echo $BID;?>","<?php echo $vdo_WIDTH;?>","<?php echo $vdo_HEIGHT;?>","1");
				s<?php echo $BID;?>.addParam("allowfullscreen","true");
				s<?php echo $BID;?>.addVariable("file",myurl + vdoFile);
				//if (previewFile!='') s1.addVariable("image","http://203.154.183.2/ewt/cadweb_2007/vdo/"+previewFile);
				s<?php echo $BID;?>.addVariable("width","<?php echo $vdo_WIDTH;?>");
				s<?php echo $BID;?>.addVariable("height","<?php echo $vdo_HEIGHT;?>");
				s<?php echo $BID;?>.addVariable("autostart","true");
				s<?php echo $BID;?>.write("SM<?php echo $BID;?>");
				s<?php echo $BID;?>.addParam('wmode','transparent');
				vdo_count<?php echo $BID;?>.location.href = "vdo_count.php?v="+id;
				}
			}
	   </script>
		<div id="SM<?php echo $BID;?>"  class="media<?php echo $BID;?>" ><a href="http://www.macromedia.com/go/getflashplayer"><?php echo $data1[vdo_name];?></a></div>
<?php if($filetype[1] == 'wmv' || $filetype[1] == 'wma'  || $filetype[1] == 'avi'){ ?>
<script type="text/javascript">
 $(function() {
        $('div.media<?php echo $BID;?>').media(
		{
		width:<?php echo $vdo_WIDTH;?>, 
		height:<?php echo $vdo_HEIGHT;?>, 
		<?php if($vdo_AUTOPLAY=='Y'){?> autoplay: true ,  <?php } ?>
		src :       '<?php echo $data1[vdo_filename];?>'
		}
		);
   		});
</script>
<?php }else{ ?>
	        <script type="text/javascript">
				var s<?php echo $BID;?> = new SWFObject("media/mediaplayer.swf","single<?php echo $BID;?>","<?php echo $vdo_WIDTH;?>","<?php echo $vdo_HEIGHT;?>","1");
				s<?php echo $BID;?>.addParam("allowfullscreen","true");
				s<?php echo $BID;?>.addVariable("file",myurl + "<?php echo $data1[vdo_filename];?>");
				s<?php echo $BID;?>.addVariable("image","<?php echo $data1[vdo_image];?>");
				s<?php echo $BID;?>.addVariable("width","<?php echo $vdo_WIDTH;?>");
				s<?php echo $BID;?>.addVariable("height","<?php echo $vdo_HEIGHT;?>");
				s<?php echo $BID;?>.addParam('wmode','transparent');
               <?php if($vdo_AUTOPLAY=='Y'){?>  s<?php echo $BID;?>.addVariable("autostart","true");  <?php } ?>
				s<?php echo $BID;?>.write("SM<?php echo $BID;?>");
			</script>
<?php } 
?>
	   </td>
   </tr>
    <tr  > 
	    <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
	        <li><a href="#view" onclick="play<?php echo $BID;?>('<?php echo $data1[vdo_filename];?>','<?php echo $data1[vdo_id];?>'); " title="จำนวนผู้เข้าชม <?php echo number_format($data1[vdo_count],0);?> คน">
			 <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>"><span id="Bfont" style="font-size: <?php echo $body_font_size;?>"><?php echo $data1[vdo_name];?></span></font>
			 </a>&nbsp;&nbsp;<?php if($data1['vdog_downloadable']=='1') { echo '<a href="./'.$data1['vdo_filename'].'" ><img src="../../images/download_icon.gif" width="18" height="18" style="border-style:none;"/></a>'; } ?></li>
		</td> 
	</tr>
   <?php 
	while($data1=$db->db_fetch_array($query)){ ?>
    <tr> 
	    <td  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>" >
	         <li><a href="#view" onclick="play<?php echo $BID;?>('<?php echo $data1[vdo_filename];?>','<?php echo $data1[vdo_id];?>'); " title="จำนวนผู้เข้าชม <?php echo number_format($data1[vdo_count],0);?> คน">
			 <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>"><span id="Bfont" style="font-size: <?php echo $body_font_size;?>"><?php echo $data1[vdo_name];?></span></font>
			 </a>&nbsp;&nbsp;<?php if($data1['vdog_downloadable']=='1') { echo '<a href="./'.$data1['vdo_filename'].'" ><img src="../../images/download_icon.gif" width="18" height="18" style="border-style:none;"/></a>'; } ?>
			 </li>
			 
		</td> 
	</tr>
	<?php  } ?>
	<?php if($MORE_SHOW == 'Y'){ ?>
		<tr ><td><table width="100%" border="0">
		  <tr>
			<td align="right"><a href="more_video.php?gid=<?php echo $vdo;?>&filename=<?php echo $filename;?>&BID=<?php echo base64_encode ('ZY'.$BID);?>"><font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>"><span id="Bfont" style="font-size: <?php echo $body_font_size;?>">&nbsp;ดูทั้งหมด</span></font></a></td>
		  </tr>
		</table></td> 
			</tr>
		<?php } ?>
</table>
<iframe name="vdo_count<?php echo $BID;?>" src=""  frameborder="0"  width="0" height="0" scrolling="no" ></iframe>

 

 <!--table width="<?php echo $bg_width;?>" border="0" cellspacing="0" cellpadding="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" align="center">
  <tr><td height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><strong><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"><?php echo $data1[vdog_name];?></span></font></strong></td></tr>
  <tr><td align="center"><embed src="media/mediaplayer.swf" width="240" height="250" allowfullscreen="true" allowscriptaccess="always" flashvars="&displayheight=185&file=<?php echo $Current_Dir; ?>&height=250&width=240&frontcolor=<?php echo $head_font_face1;?>&backcolor=<?php echo $head_color1;?>&lightcolor=<?php echo $body_color1;?>&displaywidth=240&overstretch=fit&autostart=true&bufferlength=50&shuffle=false" /></td></tr>
</table-->

	</td>
     </tr>
</table>
 <?php echo $design[1]; ?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
 <?php
 	} 
 }
 function GenLink($BID){
 	global $db;
	global $mainwidth;
	global $global_theme;
 
 	$sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$s_id=$rec[block_link];
	
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);
			
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
	  //if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
                     $buffer = "";
                     $fd = @fopen ($Current_Dir1.$themes_file, "r");
					 while (!@feof ($fd)) {
						$buffer .= @fgets($fd, 4096);
					 }
					@fclose ($fd);
					$exp = "<"."?#htmlshow#?".">";
					$design = explode($exp,$buffer);
			 }
			 //echo $design[0];
	}else{
		//$head_font_color='#666666';
		$bg_color='#333333';
		$head_color='#F8F8F8';
		$Current_Dir1='mainpic/';
		$bg_img='';
		//$head_img='toolbars.gif';
		$head_height=30;
		$body_color='#FFFFFF';
		//$body_font_color='#000099';
		$bottom_height=30;
		
	}
 
 global $filename;
 global $lang_sh;
 @include("language/language".$lang_sh.".php");
 $sql = $db->query("SELECT * FROM link_group ORDER BY glink_id ASC");
 $rows = $db->db_num_rows($sql);
 ?>

 <style type="text/css">
/*
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
*/
 </style><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
 <?php echo $design[0]; ?>
 <table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">
   <table width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
  <tr height="<?php echo $head_height;?>"> 
    <td height="30" align="center"  bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><strong><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenLink_head;?></span></font></strong></td>
  </tr>
  <?php
						  $x = $offset;
						  if($rows > 0){
								   while($rec = $db->db_fetch_array($sql)){ 
$sql_count = $db->query("SELECT COUNT(link_id) FROM link_list WHERE glink_id = '$rec[glink_id]' ");
$C = $db->db_fetch_row($sql_count);
					?>
  <tr bgcolor="<?php echo $body_color;?>" onMouseOver="this.style.backgroundColor='#F5E0CD'" onMouseOut="this.style.backgroundColor='<?php echo $body_color;?>'"> 
    <td height="30" background="<?php echo $Current_Dir1.$body_bg_img;?>"><li><a href="ewt_link.php?glink_id=<?php echo $rec['glink_id'] ?>&filename=<?php echo $filename; ?>&BID=<?php echo $BID; ?>"> 
        <font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><b><?php echo $rec[glink_name]?>
        </b>(<?php echo $C[0]; ?>)</span></font></a></li>
      <br> 
      <font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $rec[glink_des]?></span></font>
    </td>
  </tr>
  <?php						
									}
							 }else{ 
					?>
  <tr bgcolor="#FFFFFF"> 
    <td  align="center" height="<?php echo $bottom_height ;?>" background="<?php echo $Current_Dir1.$bottom_img;?>"   bgcolor="<?php echo $bottom_color;?>"><font color="#FF0000"><strong><span class="text_normal"><?php echo $text_GenLink_Nodetail;?></span></strong></font></td>
  </tr>
  <?php } 
				 ?>
</table>
	</td>
     </tr>
</table>
<?php echo $design[1]; ?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php
}

function GenPic2($data){
	$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		echo "<img src=\"../../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}

function GenEBook($BID){
	 global $db;
	 global $mainwidth;
	 global $global_theme,$filename;

	$sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$BB = explode('##',$rec[block_link]);
	$ebook_id=$BB[0];
	$show_list = $BB[1];
	$hi = $BB[2];
/*	if($hi  == ''){
		$hi  = '85';
	}*/
	$wi = $BB[3];
/*	if($wi  == ''){
		$wi  = '85';
	}*/
	$sh = $BB[4];
	$limit  = '';
	if($show_list != ''){
		$limit = 'limit 0,'.$show_list;
	}
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);
		
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		 //if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
                $buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				}
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
       //echo $design[0];
}else{
	$head_font_color='#666666';
	$bg_color='#666666';
	$Current_Dir1='mainpic/';
	$bg_img='';
	$head_img='';
	$head_height=30;
	$body_color='#FFFFFF';
	$body_font_color='#000099';
	$bg_width= "100%";
}

	 global $dataSearchEbook; 
	 
	@include("language/language".$lang_sh.".php");
	 //Initial var
 //$data = $HTTP_POST_VARS['data'];
 $dest = "ebook/"; //Source ebook
 if($ebook_id==''){
	   if (!empty($dataSearchEbook)) {
			$wh = " and (ebook_name like '%$dataSearchEbook%' or ebook_desc like '%$dataSearchEbook%') ";
			$sql = "select * from ebook_info where show_status='Y' $wh order by ebook_name";
			$query = $db->query ($sql);
			$numRows = $db->db_num_rows ($query);
	   }
}else{
	$tb=explode('@',$ebook_id);
	$GEID = $tb[0];
	$AB = $tb[1];
	if($tb[1]=='C'){
	$GEID = $tb[0];
		$sql = "select * from ebook_info inner join ebook_group on ebook_info.g_ebook_id=ebook_group.g_ebook_id  where ebook_info.g_ebook_id='$tb[0]' and show_status='Y' and g_ebook_status='Y' order by ebook_id DESC,ebook_name ASC $limit";
	}else{
		//echo $ebook_id;
	$sql = "select * from ebook_info where ebook_id='$tb[0]' and show_status='Y' order by ebook_name ";
	}
    $query = $db->query ($sql);
	$numRows = $db->db_num_rows ($query);
}
//echo $sql.$numRows;

?>
<script language="javascript">
     function cfmDel (ref) {
      if (confirm ("<?php echo $text_GenEbook_alertcomf_del;?> "+ref)) {
	       self.location.href='proc_ebook.php?proc=delEbook&ebookCode='+ref;		   
	  }
   }
</script>

<?php if($ebook_id==''){ ?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>

  <table width="<?php echo $bg_width;?>" align="center" border="0" cellpadding="10" cellspacing="0" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
    <form name="form1" method="post" action=""><tr>
      <td valign="top"  class="MemberTitle"><font  color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span  id="Hfont" style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenEbook_head;?></span></font>
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td><font  color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span  id="Hfont2"  style="font-size: <?php echo $head_font_size2;?><?php  if($head_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenEbook_Search;?>:
              <input name="dataSearchEbook" type="text" value="<?php echo $dataSearchEbook;?>" size="15">
            <input type="submit" name="Submit" value="<?php echo $text_GenEbook_button_ok;?>"></span></font></td>
		 <td align="right" valign="bottom"><font  color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span  id="Hfont2"  style="font-size: <?php echo $head_font_size2;?><?php  if($head_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>">
		 <?php    if (!empty($dataSearchEbook)){  echo $text_GenEbook_Search_text.' '.$numRows.' '.$text_GenEbook_list;  }  ?> 
		 </span></font></td>
      </tr>
    </table>
	 <?php    if (!empty($dataSearchEbook)){  ?>
          <table width="100%" height="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
            <input type="hidden" name="Flag" value="DelGroup">
            <input type="hidden" name="cid" >
            <input type="hidden" name="rss_title" >
            <input type="hidden" name="rss_url" >
            <input type="hidden" name="rss_row" >
           
            <?php  
			   $num = 0;
			   while ($rec = $db->db_fetch_array ($query))  {		
			      $num++;    
				  
				  if ($bg=='#F7F7F7') {
				     $bg = '#ECECFF';
				  }else {
				     $bg = '#F7F7F7'; 
				  }
				$GEID = $rec["g_ebook_id"];
			?>
            <tr bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
              <td height="25" align="left" valign="top">
			 <a href="<?php print $dest.$rec['ebook_code'];?>/index.html" target="_blank"><font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"> - <?php echo $rec['ebook_name'];?> </span></font></a>
                <font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span id="Bfont2" style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>">(
		<?php  print $db->db_num_rows($db->query("select ebook_code from ebook_page where ebook_code  like '$rec[ebook_code]' "));?>
                 page) </span></font></td>
            </tr>
            <?php  } //while ?>
      </table><?php   }  ?> 
	  </td></tr></form>
  </table>
  <?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>

<?php }else{ ?><br><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
 <?php echo $design[0];?>
          <table width="<?php echo $bg_width;?>" align="center"   border="0" cellpadding="0" cellspacing="0" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
<?php     if($numRows>0){ 
			  while($rec = $db->db_fetch_array($query)){

			  $querypage=$db->query("select ebook_code,ebook_page_file from ebook_page where ebook_code  like '$rec[ebook_code]' ORDER BY ebook_page");
			  $datapage = $db->db_fetch_array($querypage);
			  $sizeOfPage=$db->db_num_rows($querypage);
?>
            <tr > 
			   <td  width="25%" align="center" valign="top">
			   <table width="100" height="100" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><a href="<?php print $dest.$rec['ebook_code'];?>/index.html" target="_blank" ><img src="phpThumb.php?src=ebook/<?php echo $datapage[ebook_code].'/pages/'.$datapage[ebook_page_file];?>&h=<?php echo $hi; ?>&w=<?php echo $wi?>" hspace="0" vspace="0" align="middle" border=0></a></td>
  </tr>
</table>
			   </td>
			   <?php if($sh=='U'){ ?></tr><tr> <?php } ?>
			   <td width="75%" valign="top" <?php if($sh=='U'){ ?>align="center" <?php } ?>><a href="<?php print $dest.$rec['ebook_code'];?>/index.html" target="_blank"><font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><span class="text_head"><?php echo $rec['ebook_name'];?></span></span></font></a>
			  <?php if($rec['ebook_desc'] != ''){?> <br><br> <font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span id="Bfont2" style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp; &nbsp; &nbsp; <span class="text_normal"><?php echo $rec['ebook_desc'];?></span></span></font><?php } ?>
			   <!--br><br><font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>" ><span id="Bfont3" style="font-size: <?php echo $body_font_size3;?><?php  if($body_font_italic3=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold3=='Y'){ ?>;font-weight:bold<?php } ?>"> <?php echo $text_GenEbook_lblsize;?>) <?php echo $rec['ebook_w'];?> x <?php echo $rec['ebook_h'];?> <?php echo $text_GenEbook_lblpix;?> <?php echo $sizeOfPage ?>  <?php echo $text_GenEbook_lblpage;?>  <br>
                <?php echo $text_GenEbook_lblby;?> <?php echo $rec['ebook_by'];?> <br ><a href="ebook_print.php?ebook_id=<?php echo $rec['ebook_code'];?>" target="_blank">Download File</a></span></font-->
                </td>
            </tr>
          
         <?php 
			  }
?>
				<tr > 
			   <td  colspan="2" align="right" valign="top" ><font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>" ><span id="Bfont3" style="font-size: <?php echo $body_font_size3;?><?php  if($body_font_italic3=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold3=='Y'){ ?>;font-weight:bold<?php } ?>"><a href="more_ebook.php?EGID=<?php echo $GEID;?>&filename=<?php echo $filename; ?>"><span class="text_normal">ดูทั้งหมด</span></a></span></font></td>
            </tr>
<?php
		 }else{?>
		 <tr > 
			   <td  colspan="2" align="center" valign="top"><?php echo $text_GenEbook_notfound;?></td>
            </tr>
		<?php } //if?>
      </table>
 
<?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php }
}?>

<?php
function GenBlog($BID){
	@include("../blog/lib/blog_config.php");
	global $lang_sh; 
	@include("language/language".$lang_sh.".php");
	 global $db;
	 global $mainwidth;
	 global $global_theme;
 global $EWT_DB_USER;
$sql = $db->query("select * from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);
		
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		 //if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
		 //echo $design[0];
}else{
	$head_font_color='#666666';
	$bg_color='#B07533';
	$Current_Dir1='mainpic/';
	$bg_img='';
	$head_img='toolbars.gif';
	$head_height=30;
	$body_color='#FFFFFF';
	$body_font_color='#000099';
}
	 
	 
	 
	 $db->query("USE ".$EWT_DB_USER);
?>
<style type="text/css">
/*
.font_basic {
	font-size: 12px;
	font-family: sans-serif,Arial, Helvetica ;
}
*/
</style><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0]; ?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="<?php echo $bg_span;?>" bgcolor="<?php echo $bg_color;?>">
     <tr>
        <td align="center" bgcolor="#FFFFFF">
	
	<table width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
      <tr>
        <td align="center"  bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><strong><?php echo $text_GenBlog_update_blog;?></strong></span></font></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="5" cellpadding="0" class="font_basic">
<?php
		if($_SESSION["EWT_MID"]){
			$qPer=mysql_query('SELECT * FROM blog_settings');
			$rPer=$db->db_fetch_array($qPer);
			if($rPer['insider']=='1') {
				$selChk='SELECT gu.* FROM gen_user gu JOIN emp_type et ON et.emp_type_id=gu.emp_type_id WHERE gu.org_id>0 AND et.emp_type_status=2 AND gu.gen_user_id='.$_SESSION['EWT_MID'];
				$qPermission=mysql_query($selChk);
				$numPermission=mysql_num_rows($qPermission);
			} else if($rPer['outsider']=='1') {
				$selChk='SELECT gu.* FROM gen_user gu JOIN emp_type et ON et.emp_type_id=gu.emp_type_id WHERE et.emp_type_status=4 AND gu.gen_user_id='.$_SESSION['EWT_MID'];
				$qPermission=mysql_query($selChk);
				$numPermission=mysql_num_rows($qPermission);
			} else if($rPer['closed']=='1') {
				$numPermission=0;
			} else if($rPer['public']=='1') {
				$numPermission=1;
			}

			if($numPermission>0) {
?>
          <tr height="50">
            <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CC99CC" class="font_basic">
                <tr>
                  <td height="30" align="center" bgcolor="#DEDEEF" style="cursor:hand;"><?php 
		$sql_profile="SELECT * FROM `blog_list` WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";
		$exc_profile=mysql_query($sql_profile);
		$count_profile=mysql_num_rows($exc_profile);
		$row_profile=$db->db_fetch_array($exc_profile);
		
		if($count_profile>0){
		?>
                      <a href="<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank"><b><span class="text_normal"><?php echo $text_GenBlog_manageblog;?></span></b></a>
                      <?php
		}else{
		?>
                      <a href="<?php echo $blog_url; ?>blog_install.php" target="_blank"><b><span class="text_normal"><?php echo $text_GenBlog_configblog;?></span></b></a>
                      <?php
		}
		?></td>
                </tr>
            </table></td>
          </tr>
          <?php
			}
		}  
?>
          <tr>
            <td ><table width="100%" border="0" cellpadding="0" cellspacing="5" class="font_basic">
                <?php
		
		$sql_profile="SELECT * FROM `blog_list` ORDER BY  `blog_list`.`blog_lastdate` DESC LIMIT 0,10";
		$exc_profile=mysql_query($sql_profile);
		$count_profile=mysql_num_rows($exc_profile);
		while($row_profile=$db->db_fetch_array($exc_profile)){
				$photo_name="nophoto.jpg";
				if($row_profile[blog_picture]){
					$photo_name=$row_profile[blog_picture];
				}
				
				$sp_datetime=split(" ",$row_profile[blog_lastdate]);
				$sp_date=split("-",$sp_datetime[0]);
				$sp_time=split(":",$sp_datetime[1]);
				
	?>
                <tr bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
                  <td width="50" height="50" align="center" valign="middle" bgcolor="#CCCCCC"><img src="phpThumb.php?src=../blog/images_profile/<?php echo $photo_name; ?>&h=48&w=48" border="0" align="absmiddle" ></td>
                  <td valign="top"><div><a href="<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank"><b><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $row_profile[blog_title]; ?></span></font></b></a></div>
                      <!--<div><b><font color="<?php//php echo $body_font_color2;?>"  face="<?php//php echo $body_font_face2;?>" ><span style="font-size: <?php//php echo $body_font_size2;?>"><?php//php echo $text_GenBlog_name;?>:</span></font></b> <font color="<?php//php echo $body_font_color3;?>"  face="<?php//php echo $body_font_face3;?>" ><span style="font-size: <?php//php echo $body_font_size3;?>"><?php//php echo $row_profile[blog_name]; ?></span></font></div>-->
                    <div><b><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenBlog_Update;?>:</span></font></b> <font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>" ><span style="font-size: <?php echo $body_font_size3;?><?php  if($body_font_italic3=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold3=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $sp_date[2]."/".$sp_date[1]."/".($sp_date[0]+543); ?> <?php echo ($sp_time[0]*1).":".$sp_time[1] ?></span></font></div></td>
                </tr>
                <?php
	  		}
	  ?>
            </table></td>
          </tr>
          <tr>
            <td align="right">&raquo; <a href="blog.php" target="_blank"><font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>" ><span  style="font-size: <?php echo $body_font_size3;?><?php  if($body_font_italic3=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold3=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $text_GenBlog_showtotal;?></span></font></a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php echo $design[1]; ?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php
		  if($_SESSION["EWT_SDB"] != ""){
$db->query("USE ".$_SESSION["EWT_SDB"]);
}else{
global $EWT_DB_NAME;
$db->query("USE ".$EWT_DB_NAME);
}
}





function show_icon_lang1($langid,$type,$body_font_color,$body_font_face,$body_font_size,$body_font_italic,$body_font_bold){//list language
	global $db;
	global $EWT_FOLDER_USER;
	global $filename;  
	$Globals_Dir  = '';//'../ewt/'.$EWT_FOLDER_USER;
	$Globals_Dir1 = 'language';
	$lang_exp 	  = explode(',',$langid);
	$lang_num 	  = count($lang_exp);

	if($lang_num >'1'){
		$wh = "WHERE lang_config_id IN (".substr($langid, 0, -1).") ";
	}else if($lang_num =='1'){
		$wh = "WHERE lang_config_id = '".$langid."' ";
	}

	$sql_lang = "select * from lang_config $wh";
	$query = $db->query($sql_lang);
	
	while($rec_db = $db->db_fetch_array($query)){

		$spacial_text= "";
		
		if($body_font_italic=='Y'){$spacial_text= ";font-style:italic"; } 
		if($body_font_bold=='Y'){ $spacial_text.= ";font-weight:bold";}

		if($rec_db[lang_config_status]=='T'){ 
			$rec_db[lang_config_name] ='thai';
		}
		else if($rec_db[lang_config_status]=='E'){ 
			$rec_db[lang_config_name] ='english';
		}

		if($rec_db[lang_config_img]!='' && $type == 'Y'){ 
			$text .= "<a onclick=\"ChangeLanguage('".$rec_db[lang_config_suffix]."')\" href=\"#language\"><span class=\"text_head\"><font color=\"".$body_font_color."\"  face=\"".$body_font_face."\"><span style=\"font-size:".$body_font_size.$spacial_text."\"><img src=\"".$Globals_Dir.$Globals_Dir1."/".$rec_db[lang_config_img]."\" border=\"0\" align=\"absmiddle\"  alt=".$rec_db[lang_config_name]."></span></font></span></a>&nbsp; &nbsp;";
		}
		else{
			$text .= "<a onclick=\"ChangeLanguage('".$rec_db[lang_config_suffix]."')\" href=\"#language\"><span class=\"text_head\"><font color=\"".$body_font_color."\"  face=\"".$body_font_face."\"><span style=\"font-size:".$body_font_size.$spacial_text."\">".$rec_db[lang_config_name]."</span></font></span></a>&nbsp;|&nbsp;";
		}
	}
	
	return substr($text,0,(strlen($text)-7));
}


function Genlanguage($langid,$BID){
	global $db;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;

	$lang_c = explode('_',$lang_sh);
	@include("language/language".$lang_sh.".php");

	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");

	## >> Get block theme
	$db->prepare("SELECT block_themes 
	              FROM   block 
				  WHERE  BID = ? ");
	$blocktheme_data = $db->set_execute(array(ready($BID)));
	$db->deallocate();
	$rec = $db->db_fetch_array($blocktheme_data);

	if($rec["block_themes"] != '0'){
		$themeid = $rec["block_themes"];
	}else{
		$themeid = $global_theme;
	}

	if($themeid != "0" AND $themeid != "" ){
		$namefolder = "themes".($themeid);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
			//if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
			$buffer = "";
			$fd = @fopen ($Current_Dir1.$themes_file, "r");
				while (!@feof ($fd)) {
				$buffer .= @fgets($fd, 4096);
				}
			@fclose ($fd);
			$exp = "<"."?#htmlshow#?".">";
			$design = explode($exp,$buffer);
		}
	}//End if



	?>
	<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  
	       cellpadding="0" cellspacing="0">
		<tr>
			<td></td>
		</tr>
	</table>
	
	<?php echo $design[0];?>
	
	<table width="<?php echo $bg_width;?>" border="0" align="center" cellspacing="0" cellpadding="0" 
	       bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
		<tr  height="<?php echo $head_height;?>">
			<td align="center"  bgcolor="<?php echo $head_color;?>" 
			    background="<?php echo $Current_Dir1.$head_img;?>">
			<?php 
			echo show_icon_lang1($langid,'Y',$body_font_color,$body_font_face,$body_font_size,$body_font_italic,$body_font_bold);
			?>
			</td>
		</tr>
	</table>

	<?php echo $design[1];?>
	
	<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>">
		<tr>
			<td></td>
		</tr>
	</table>
	<?php
}
function GenTooltipsBlock($BID){
global $db;
global $mainwidth;
global $global_theme;
global $filename;
global $nid;
global $lang_sh;

$lang_c = explode('_',$lang_sh);
@include("language/language".$lang_sh.".php");

	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != "" ){
		$namefolder = "themes".($themeid);
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
			 //if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
			 }
	}//End if

$name_page = basename($_SERVER["PHP_SELF"]);
if($name_page == 'main.php' || $name_page == 'site_preview.php'){
$page_tooltips = $filename;
}else if($name_page == 'ewt_news.php'){
$page_tooltips = $nid;
}

?>
<table width="<?php echo $bg_width;?>" border="0"  cellspacing="0" cellpadding="0" >
  <tr  height="<?php echo $head_height;?>">
    <td  ><a href="##H" onclick="help('<?php echo $page_tooltips;?>');"><img src="mainpic/help.gif" border="0"  alt="Tool Tips" align="absmiddle">ตัวช่วยเหลือ</a></td>
  </tr>
</table>

<?php
}

function GenvirtualBlock($BID){
global $db;
global $mainwidth;
global $global_theme;
global $filename;
global $nid;
global $lang_sh;

$lang_c = explode('_',$lang_sh);
@include("language/language".$lang_sh.".php");

	$sql = $db->query("select block_themes,block_link from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != "" ){
		$namefolder = "themes".($themeid);
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
			 //if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
			 }
	}//End if

			$sql_chid = "SELECT * FROM virtual_list WHERE vg_id  ='$rec[block_link]' and v_status ='1' ";
			$query_chid = $db->query($sql_chid);
			

?>
<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
<?php echo $design[0];?>
<table width="<?php echo $bg_width;?>" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
  <tr  height="<?php echo $head_height;?>">
    <td   bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
	<?php while($R_chid = $db->db_fetch_array($query_chid)){ ?>
<table width="100%" border="0">
  <tr>
    <td width="4%"><a href="#view"  onClick="window.open('ewt_virtual.php?vid=<?php echo $R_chid[v_id];?>','','width=800,height=600,scrollbars=1,resizable=1');"><img src="phpThumb.php?src=virtual/<?php echo $R_chid["v_images"]; ?>&h=85&w=85" hspace="0" vspace="0" align="middle" border=0></a></td></td>
    <td width="96%" valign="top"><span class="text_normal">ชื่อภาพ : <?php echo nl2br($R_chid["v_name"]); ?><br /> 
    รายละเอียด : <?php echo $R_chid["v_detail"]; ?></span></td>
  </tr>
</table>
<?php } ?>
	</td>
</tr>
</table>
<?php echo $design[1];?>
<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"><tr><td></td></tr></table>
<?php

}









 function GenEcard($BID){
 	global $db;
	global $mainwidth;
	global $global_theme;
 
 	$sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$block_link=explode("@",$rec[block_link]);
	$type_choi = $block_link[0];
	$row = $block_link[1]*$block_link[2];
	$cal = $block_link[2];
	
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);
			
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
			//if($themes_type == 'F'){
		   if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
					 while (!@feof ($fd)) {
						$buffer .= @fgets($fd, 4096);
					 }
					@fclose ($fd);
					$exp = "<"."?#htmlshow#?".">";
					$design = explode($exp,$buffer);
			 }
			 //echo $design[0];
	}else{
		
		$bg_color='#F6F6F6';
		$Current_Dir1='mainpic/';
		$bg_img='';
		
		$head_img='';
		$head_height='';
		$head_font_color='#FF6600';
		
		$body_color='#FFFFFF';
		$body_font_color='';
		
		$bottom_color='#FFFFFF';
		
	}
 
 global $filename;
 global $lang_sh;
 @include("language/language".$lang_sh.".php");
 $lang_c = explode('_',$lang_sh);
 ?>
 <style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
-->
 </style>

<table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0">
<tr><td>555</td></tr>
</table>
<?php echo $design[0];?>

<table width="100%" align="center" cellpadding="3" cellspacing="1" >
  <tr>
    <td valign="top">
	    <table width="<?php echo $bg_width;?>" border="0" cellspacing="0" cellpadding="0" class="text_normal">
             <tr>
                <td height="30" align="center" valign="middle" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><strong>E-Card</strong></span></font>
				</td>
                <td height="30" width="7"></td>
            </tr>
       </table>
	   
       <table width="100%" border="0" cellpadding="3" cellspacing="1">
         <tr>
           <td >
		      <?php @$percent=100/$num_rows_2*$rs_category[col];
			  $sql_ecard= "SELECT * FROM ecard_list limit 0,$row";
			  $query = $db->query($sql_ecard);
			   $count=$db->db_num_rows($query);
			  ?>
              <table border="0" cellpadding="5" cellspacing="1" align="center" width="100%">
                 <tr>
                    <td ><div align="center">
                            <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="text_normal">
                             <?php  
								if($count > 0){	//for($i=1;$i<=$num_rows_2;$i++){
									$i=0;
									$wi=100;
									$hi=100;
									while($rs_card = $db->db_fetch_array($query)){
										      if($i%$cal == 0) { ?> <tr align="center"> <?php }?>
                                              <td  align="center" valign="top">
					                               <table border="0"   width="100%"  cellpadding="1" cellspacing="1" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" align="center" style="cursor:hand" >
                                                        <tr>
                                                              <td   align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
															         <table border="0" cellpadding="1" cellspacing="1"  align="center">
                                                                           <tr>
                                                                                  <th  scope="col" align="center">
																				        <table width="<?php echo $wi;?>"  height="<?php echo $hi;?>" border="0" cellpadding="1" cellspacing="0" >
								                                                               <tr>
									                                                                 <td align="center" valign="bottom">
				<img src="phpThumb.php?src=<?php echo "ecard/".$rs_card[ec_filename]?>&h=<?php echo $hi;?>&w=<?php echo $wi;?>" hspace="0" vspace="0"  border="1">
				                                                                                    </td>
								                                                               </tr>
								                                                        </table>
																			    </th>
								                                           </tr>
                                                                     </table> 
														   </td>
												    </tr>
                                                    <tr>
                                                           <td  align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size: <?php echo $head_font_size2;?><?php  if($head_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>" ><?php echo $rs_card[ec_name];?><br>(<?php echo number_format($rs_card[ec_filesize]/1024,2);?> KB.)</span></font>
														   </td>
						                            </tr>
                                                 </table>			
									   </td>
						               <?php    $i++;    if($i%$cal == 0 ) { ?>    </tr>  <?php } ?>
                     <?php    }// end for while
					}else{ //end if count
				?>
                  <tr><td align="center" style="color:#FF0000"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size: <?php echo $head_font_size2;?><?php  if($head_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>" ><strong><?php echo $text_GenGallery_noecard;?>Not found</strong></span></font></td>
                  </tr>
                  <?php }?>
                  </table></div>
              </td>
            </tr>
            </table><br>
		</td>
      </tr>
    </table>
    </td>
  </tr>
</table><?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>	

 <?php
 }
function GenprinterBlock($BID){
global $db;
global $mainwidth;
global $global_theme;
global $filename;
global $nid,$s,$cid,$keyword;
global $lang_sh;

$lang_c = explode('_',$lang_sh);
@include("language/language".$lang_sh.".php");

	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != "" ){
		$namefolder = "themes".($themeid);
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
			 //if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
			 }
	}//End if



?>
<table width="<?php echo $bg_width;?>" border="0" cellspacing="0" cellpadding="0" class="text_normal" >
  <tr  height="<?php echo $head_height;?>">
    <td  ><a href="##P" onclick="PrintNews('<?php echo $filename;?>', 600, 400,'');" ><img src="mainpic/printer.gif" border="0"  alt="Print this page" align="absmiddle">   Print this page</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="##M" onclick="window.open('mail_send.php', 'mail', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');" ><img src="mainpic/mail.gif" border="0"  alt="Send this page" align="absmiddle">   Send this page</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="pdf.php" target="_blank"><img src="mainpic/pdf.gif" border="0"  alt="export to PDF" align="absmiddle">   Export to PDF</a></td>
  </tr>
</table>
<script language="javascript1.2">
function PrintNews(filename,w,h){
var page = chk_path();
if(page == 'search_result.php'){
var keyword =window.document.formSearchAEWT.keyword.value;
var search_mode =window.document.formSearchAEWT.search_mode.value;
window.open('printerFriendlt.php?filename=<?php echo $filename; ?>&page='+page+'&keyword='+keyword+'&search_mode='+search_mode, 'printer_search', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');
}
if(page == 'main.php' || page == 'site_preview.php'){

window.open('printerFriendlt.php?filename=<?php echo $filename; ?>&page='+page, 'printer_main', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');
}
if(page == 'ewt_news.php'){

window.open('printerFriendlt.php?filename=<?php echo $filename; ?>&page='+page+'&nid=<?php echo $nid;?>', 'printer_ewt_news', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');
}
if(page == 'ewt_snews.php'){

window.open('printerFriendlt.php?filename=<?php echo $filename; ?>&page='+page+'&s=<?php echo $s;?>', 'printer_ewt_snews', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');
}
if(page == 'more_news.php'){

window.open('printerFriendlt.php?filename=<?php echo $filename; ?>&page='+page+'&cid=<?php echo $cid;?>', 'printer_more_news', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');
}
}
function chk_path(){
<!--
var sPath = window.location.pathname;
var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
return sPage;
//-->
}
</script>
<?php
}
function GenTor($BID){
global $db;
global $mainwidth;
global $global_theme;
global $filename;
global $lang_sh,$EWT_DB_NAME;

$lang_c = explode('_',$lang_sh);
@include("language/language".$lang_sh.".php");

	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}

	if($themeid != "0" AND $themeid != "" ){
		$namefolder = "themes".($themeid);
			@include("themesdesign/".$namefolder."/".$namefolder.".php");
			 //if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
			 }
	}//End if
	  $db->query("USE db_moc_tor");
	//config
	$sql_config =$db->query('SELECT config_row FROM tor_config WHERE config_id=\'1\'');
	$C = $db->db_fetch_array($sql_config);
	$rowconfig = $C["config_row"];
	if (empty($offset) || $offset < 0) { 
		$offset=0; 
	} 
	$limit = $rowconfig;
	if(empty($limit)){
		$limit = 20;
	}
	$sql_query = 'SELECT m.*, (SELECT l.t_date_start FROM tor_list l WHERE l.tg_id=m.tg_id ORDER BY l.t_id DESC LIMIT 1) AS t_date_start FROM tor_main m ORDER BY tg_id DESC';
	$totalRows = mysql_num_rows($db->query($sql_query));
	
	 $sql = $sql_query." LIMIT 0,$limit";	
	  $query = $db->query($sql);
	  ?>
	  <table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>	
	  <?php echo $design[0];?>
	 	<table width="<?php echo $bg_width;?>" align="center" cellpadding="0" cellspacing="0"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
      <tr>
        <td bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"> ร่างประกาศ TOR</span></font><br/></td>
  </tr> <tr bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="1" class="text_normal" >
	    <tr bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>"> 
        <td bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" width="150"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">หน่วยงาน</span></font></td>
        <td bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" width="250"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"> เรื่อง</span></font></td>
        <td bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"> งบประมาณเบื้องต้น</span></font></td>
      </tr>
  <?php
   $rows = mysql_num_rows($db->query($sql_query));
	$nu = $rows-$offset;
	$cntr=1;
 while($F = $db->db_fetch_array($query)){
  ?>
              <tr <?php if($cntr%2==0) echo 'bgcolor="#CCCCCC"'; ?>> 
                <td width="50" valign="top"><?php echo $F["org_name"];?></td>
                <td valign="top"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><a href="tor_news.php?tid=<?php echo $F["tg_id"];?>" target="_blank"> <?php echo $F["tg_name"];?>&nbsp;(<?php echo ($F['t_date_start']!='')?$F['t_date_start']:'-'; ?>)</a></span></font>
                </td>
                <td width="50" valign="top"><div class="text_normal"><span  style="FONT: 12px 'Tahoma';"><?php echo number_format($F["tg_budget"]);?> บาท</span></div></td>
              </tr>
            
<?php
		$cntr++;
	}
?></table></td>
  </tr>
  <tr bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><td><hr /></td></tr>
   <tr bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
    <td class="text_normal" align="left"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">
<?php
	$pages = intval($totalRows/$limit); 
	 
	// $pages now contains total number of pages needed unless there is a remainder from division  
	if ($totalRows%$limit) { 
			// has remainder so add one page  
			$pages++; 
	} 
	 
	// Now loop through the pages to create numbered links 
	// ex. 1 2 3 4 5 NEXT 
	for ($i=1;$i<=$pages;$i++) { 
			// Check if on current page 
			if (($_GET[offset]/$limit) == ($i-1)) { 
					// $i is equal to current page, so don't display a link 
					echo "<font color=\"blue\">[$i]</font>"; 
			} else { 
					// $i is NOT the current page, so display a link to page $i 
					$newoffset=$limit * ($i-1); 
								echo  " <a href='tor_more_news.php?offset=$newoffset&filename=$_GET[filename]' ". 
								"onMouseOver=\"window.status='Page $i'; return true\";>$i</a> \n\n"; 
			} 
	} 
	
	// Check to see if current page is last page 
 if (!((($_GET[offset]/$limit)+1)==$pages) && $pages!=1 && $totalRows != 0) { 
			// Not on the last page yet, so display a NEXT Link 
			$newoffset=$offset+$limit; 
			echo   " <a href='tor_more_news.php?offset=$newoffset&filename=$_GET[filename]'>
		<font color=\"red\">$text_general_next>></font></a> "; 
	}
?>
    <!--a href="tor_more_news.php">ดูทั้งหมด</a-->
    </span></font></td>
  </tr>
</table><?php echo $design[1];?><table width="<?php echo $bg_width;?>" border="0" height="<?php echo $bg_height; ?>"  cellpadding="0" cellspacing="0"><tr><td></td></tr></table>	
	  <?php
	    $db->query("USE ".$EWT_DB_NAME);
}


function GenOrgTop($BID){
	
	global $db;
	$sql = $db->query("select block_link from block where BID = '".$BID."' ");
	$count_rec = $db->db_num_rows($sql);
	$rec = $db->db_fetch_array($sql);
	
	$data_pos="SELECT * FROM ewt_user_alro.position_name WHERE pos_id = '".$rec['block_link']."' ";
	$query_pos=$db->query($data_pos);
	$pos=$db->db_fetch_array($query_pos);
	
	$data_per="SELECT * FROM ewt_user_alro.gen_user WHERE posittion = '".$rec['block_link']."' ";
	$query_per=$db->query($data_per);
	$count_per = $db->db_num_rows($query_per);
	$per=$db->db_fetch_array($query_per);
	
	$txt.="<table align='center'>";
	$txt.="<tr>";
	$txt.="<td align='center'>";
	if($per['path_image']!=""){
		$txt.="<image src='../../../pic_upload/".$per['path_image']."' height='200' width='180'><br>";
	}else{
		$txt.="<image src='../../../pic_upload/ImageFile.gif' height='200' width='180'><br>";
	}
	
	if($count_per>0){
		$person=$per['name_thai']." ".$per['surname_thai'];
	}else{
		$person="ว่าง";
	}
	$txt.="<span style='font-size:16px;'>".$person."<br>";
	$txt.=$pos['pos_name']."<br></span>";
	
	$txt.="</td>";
	$txt.="</tr>";
	$txt.="</table>";
	return $txt;
}
?>