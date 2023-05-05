<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
function phpxcopy($s, $d){
$l = "/"; // Plz Change to '/' when your OS is Unix.
if(!file_exists($d)){ mkdir($d, "0777"); @chmod ($d, 0777); }
if(is_dir($s)){
	$dp = opendir($s);
	while($file = readdir($dp)){
	if(!($file == "." || $file == ".." || $file == "Thumbs.db")){
		$SPath = $s.$l.$file;
		$DPath = $d.$l.$file;
		if(is_dir($SPath)){
			phpxcopy($SPath, $DPath);
		}else{
			if(!copy($SPath, $DPath)){
					echo "Error : Failed to copy the folder or files";
					exit();
			}else{
			@chmod ($DPath, 0777);
			}
      }
	}
	}
	closedir($dp);
}
return true;
}

function LooPDel($p){
			$dir=@opendir($p);
			while($data=@readdir($dir))
			{
				if(($data!=".")and($data!="..")and($data!="")){
					if(!@unlink($p."/".$data))
						{
							LooPDel($p."/".$data);
						}	
				}
			}
		@closedir($dir);
		@rmdir($p);
}
		
		
if($_POST[flag]=='addtemplate'){
//เคลียร์ตารางในฐานข้อมูลเพื่อสร้าง site wizard ใหม่
$db->query("USE ".$_SESSION["EWT_SDB"]);
$db->query("DELETE from block ");
$db->query("DELETE from block_function ");
$db->query("DELETE from block_member");
$db->query("DELETE from block_text");
$db->query("DELETE from block_visit");
$db->query("DELETE from design_block ");
$db->query("DELETE from design_list");
$db->query("DELETE from temp_index");
$db->query("DELETE from temp_main_group where Main_Group_ID != '101'");
$db->query("DELETE from menu_list");
$db->query("DELETE from menu_properties");
$db->query("DELETE from themes");
//$db->query("TRUNCATE TABLE 'themes'");
//manage menu	
$db->query("USE db_00_template");
			//add group
			$sql = $db->query("SELECT * FROM menu_list WHERE m_id = '".$_POST[m_id]."' ");
			$R = $db->db_fetch_array($sql);
			$db->query("USE ".$_SESSION["EWT_SDB"]);
   
			$db->query("insert into menu_list (m_name,m_detail,glo_align,glo_showsub,glo_highlight,
																		glo_delay_ver,glo_delay_hor,glo_delay_hide,pop_display,
																		pop_bgcolor,pop_spacing,pop_padding,pop_trans,pop_bgimage,
																		pop_borcolor,pop_borwidth,pop_borstyle,m_realname,m_show) 
									values ('templatemenu','".$R[m_detail]."','".$R[glo_align]."','".$R[glo_showsub]."','".$R[glo_highlight]."',
													'".$R[glo_delay_ver]."','".$R[glo_delay_hor]."','".$R[glo_delay_hide]."','".$R[pop_display]."',
													'".$R[pop_bgcolor]."','".$R[pop_spacing]."','".$R[pop_padding]."','".$R[pop_trans]."','".$R[pop_bgimage]."',
													'".$R[pop_borcolor]."','".$R[pop_borwidth]."','".$R[pop_borstyle]."','".$R[m_realname]."','".$R[m_show]."')");
			$sql_max = $db->query("select max(m_id) as maxid from menu_list order by m_id DESC");
			$query_max =$db->db_fetch_array($sql_max);
			 $maxid =$query_max[maxid];
			 //add sub menu
			$num= $_POST[num];
			for($i=1;$i<$num;$i++){
				$mp_id = $_POST["mp_id".$i];
				$mp_name = $_POST["mp_name".$mp_id];
				$gen_menu = sprintf("%04d",$maxid);
				$m = explode("_",$mp_id);
				for($x=1;$x<count($m);$x++){
					$gen_menu .="_".$m[$x];
				}
				$link_name = "main.php?filename=".$_POST["m_page".$mp_id];
				$db->query("USE db_00_template");
				$sql1 = $db->query("SELECT * FROM menu_properties WHERE mp_id = '".$mp_id."' ORDER BY mp_id ASC");
				$RR = $db->db_fetch_array($sql1);
				$db->query("USE ".$_SESSION["EWT_SDB"]);
					$db->query("insert into menu_properties (mp_id,m_id,mp_name,Galign,Gvalign,Glink,
																			Gtarget,Gtip,Oufont,Ousize,
																			Ousizepr,Oucolor,Oubold,Ouitalic,Oubgcolor,
																			Outrans,Oubgpic,Oubordercolor,Ouborderw,Ouborderstyle,
																			Gicon,Giconw,Giconh,Giconb,Garrow,Garroww,Garrowh,Garrowb,Ovfont,
																			Ovsize,Ovsizepr,Ovcolor,Ovbold,Ovitalic,Ovbgcolor,Ovtrans,Ovbgpic,Ovbordercolor,PopDisplay,
																			PopTrans,PopSpac,PopPad,Popbgcolor,Popbgpic,PopBorderW,Popbordercolor,Popborderstyle,
																			Popshadowstyle,Popshadowsize,Popshadowcolor,PopDirect,PopX,PopY,
																			PopEffectShow,PopEffectHide,PopEffectSpeed,mp_realname,mp_show) 
										values ('".$gen_menu."','".$maxid."','".$mp_name."','".$RR[Galign]."','".$RR[Gvalign]."','".$link_name."',
														'".$RR[Gtarget]."','".$RR[Gtip]."','".$RR[Oufont]."','".$RR[Ousize]."',
														'".$RR[Ousizepr]."','".$RR[Oucolor]."','".$RR[Oubold]."','".$RR[Ouitalic]."','".$RR[Oubgcolor]."',
														'".$RR[Outrans]."','".$RR[Oubgpic]."','".$RR[Oubordercolor]."','".$RR[Ouborderw]."','".$RR[Ouborderstyle]."',
														'".$RR[Gicon]."','".$RR[Giconw]."','".$RR[Giconh]."','".$RR[Giconb]."','".$RR[Garrow]."','".$RR[Garroww]."','".$RR[Garrowh]."','".$RR[Garrowb]."','".$RR[Ovfont]."',
														'".$RR[Ovsize]."','".$RR[Ovsizepr]."','".$RR[Ovcolor]."','".$RR[Ovbold]."','".$RR[Ovitalic]."','".$RR[Ovbgcolor]."','".$RR[Ovtrans]."','".$RR[Ovbgpic]."','".$RR[Ovbordercolor]."','".$RR[PopDisplay]."',
														'".$RR[PopTrans]."','".$RR[PopSpac]."','".$RR[PopPad]."','".$RR[Popbgcolor]."','".$RR[Popbgpic]."','".$RR[PopBorderW]."','".$RR[Popbordercolor]."','".$RR[Popborderstyle]."',
														'".$RR[Popshadowstyle]."','".$RR[Popshadowsize]."','".$RR[Popshadowcolor]."','".$RR[PopDirect]."','".$RR[PopX]."','".$RR[PopY]."',
														'".$RR[PopEffectShow]."','".$RR[PopEffectHide]."','".$RR[PopEffectSpeed]."','".$RR[mp_realname]."','".$RR[mp_show]."')");
				
			}//end for $i
$db->query("USE db_00_template");

					//add design
					$sql_default = $db->query("SELECT * FROM design_list WHERE d_id = '".$_POST["d_id"]."' ");
					$D = $db->db_fetch_array($sql_default);
					$d_name = $D["d_name"];
					$d_default = "";
					$d_site_align = $D["d_site_align"];
					$d_site_width = $D["d_site_width"];
					$d_site_left = $D["d_site_left"];
					$d_site_content = $D["d_site_content"];
					$d_site_right = $D["d_site_right"];
					$d_site_bg_c = $D["d_site_bg_c"];
					$d_site_bg_p = $D["d_site_bg_p"];
					$d_top_height = $D["d_top_height"];
					$d_top_bg_c = $D["d_top_bg_c"];
					$d_top_bg_p = $D["d_top_bg_p"];
					echo $d_top_content = $D["d_top_content"];
					$d_left_bg_c = $D["d_left_bg_c"];
					$d_left_bg_p = $D["d_left_bg_p"];
					$d_right_bg_c = $D["d_right_bg_c"];
					$d_right_bg_p = $D["d_right_bg_p"];
					$d_bottom_height = $D["d_bottom_height"];
					$d_bottom_bg_c = $D["d_bottom_bg_c"];
					$d_bottom_bg_p = $D["d_bottom_bg_p"];
					$d_bottom_content = $D["d_bottom_content"];
					
					$db->query("USE ".$_SESSION["EWT_SDB"]);
					include("../ewt_menu_preview.php");
					$menu_text = GenMenu($maxid);
					$db->query("INSERT INTO design_list (d_name,d_default,d_site_align,d_site_width,d_site_left,d_site_content,d_site_right,d_site_bg_c,d_site_bg_p,d_top_height,d_top_bg_c,d_top_bg_p,d_top_content,d_left_bg_c,d_left_bg_p,d_right_bg_c,d_right_bg_p,d_bottom_height,d_bottom_bg_c,d_bottom_bg_p,d_bottom_content) VALUES ('".$d_name."','Y','".$d_site_align."','".$d_site_width."','".$d_site_left."','".$d_site_content."','".$d_site_right."','".$d_site_bg_c."','".$d_site_bg_p."','".$d_top_height."','".$d_top_bg_c."','".$d_top_bg_p."','".$d_top_content."','".$d_left_bg_c."','".$d_left_bg_p."','".$d_right_bg_c."','".$d_right_bg_p."','".$d_bottom_height."','".$d_bottom_bg_c."','".$d_bottom_bg_p."','".$d_bottom_content."')");
		$db->write_log("create","Site Design","import template ".$d_name);
		$sql_max = $db->query("SELECT MAX(d_id) AS DID FROM design_list WHERE d_name = '".$d_name."' ");
		$M = $db->db_fetch_row($sql_max);
		
		$db->query("USE db_00_template");
		$sql_block = $db->query("SELECT * FROM block,design_block WHERE block.BID=design_block.BID and  design_block.d_id  = '".$_POST["d_id"]."' ");
		while($R=$db->db_fetch_array($sql_block)){
		//add menu
		if($R[block_type] =='menu'){
		$R[block_link] = $maxid;
		$R[block_html] = $menu_text;
		}
		
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		
		$db->query("INSERT INTO block (block_name,block_type,block_html,block_link,filename) VALUES ('".$R[block_name]."','".$R[block_type]."','".addslashes($R[block_html])."','".$R[block_link]."','') ");
				$sql_max2 = $db->query("SELECT MAX(BID) AS BID FROM block WHERE block_name = '".$R[block_name]."' ");
				$B = $db->db_fetch_row($sql_max2);
		
		$db->query("USE db_00_template");
			$sql_text = $db->query("SELECT * FROM block_text WHERE BID = '".$R["BID"]."' ");
			if($db->db_num_rows($sql_text) > 0){
				while($T=$db->db_fetch_array($sql_text)){
			$db->query("USE ".$_SESSION["EWT_SDB"]);
			$db->query("INSERT INTO block_text (BID,text_html) VALUES ('$B[0]','".addslashes($T[text_html])."')");
					$sql_max3 = $db->query("SELECT MAX(text_id) AS TID FROM block_text WHERE BID = '".$B[0]."' ");
					$BT = $db->db_fetch_row($sql_max3);
					$db->query("UPDATE block SET block_link = '$BT[0]' WHERE BID = '".$B[0]."' ");
		$db->query("USE db_00_template");
				}
			}
			$sql_pos = $db->query("SELECT * FROM design_block WHERE BID = '".$R["BID"]."' AND d_id = '".$_POST["d_id"]."' ");
			if($db->db_num_rows($sql_pos) > 0){
				while($P=$db->db_fetch_array($sql_pos)){
					$db->query("USE ".$_SESSION["EWT_SDB"]);
			$db->query("INSERT INTO design_block (BID,side,position,d_id) VALUES ('$B[0]','$P[side]','$P[position]','$M[0]')");
		$db->query("USE db_00_template");
				}
			}
		
		
		}//end while
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		//add temp_index and block_function
		$Main_Group_ID = '101';
		$filename_link ='E';
		$template_id = $M["d_id"];
		$d_site_align = 'center';
		$d_site_width = '100%';
		$d_site_left = '15%';
		$d_site_content = '70%';
		$d_site_right ='15%';
		$d_site_bg_c = '#FFFFFF';
		$d_site_bg_p='';
		$d_top_height='80';
		$d_top_bg_c = '';
		$d_top_bg_p = '#FF9900';
		$d_top_content1 = '';
		$d_body_bg_p='#FFFFFF';
		$d_left_bg_c ='';
		$d_left_bg_p = '#FFFFFF';
		$d_right_bg_c='';
		$d_right_bg_p='#FFFFFF';
		$d_bottom_height='';
		$d_bottom_bg_c='40';
		$d_bottom_bg_p='#FF9900';
		$d_bottom_content1='';
			for($q=1;$q<$num;$q++){
				$mp_id = $_POST["mp_id".$q];
				$mp_name = $_POST["mp_name".$mp_id];
				$link_name =$_POST["m_page".$mp_id];
				//add temp_index
				$insert = "insert into `temp_index` (`filename`,`Created_Date`,`Modified_Date`,`Last_HTML`,`Main_Group_ID`,`filename_link`,`cms_keyword`,`cms_description`,`title`,`encoding`,`css_file`,`template_id`,`d_site_align`,`d_site_width`,`d_site_left`,`d_site_content`,`d_site_right`,`d_site_bg_c`,`d_site_bg_p`,`d_top_height`,`d_top_bg_c`,`d_top_bg_p`,`d_top_content`,`d_body_bg_c`,`d_body_bg_p`,`d_left_bg_c`,`d_left_bg_p`,`d_right_bg_c`,`d_right_bg_p`,`d_bottom_height`,`d_bottom_bg_c`,`d_bottom_bg_p`,`d_bottom_content`) values ('$link_name','0000-00-00 00:00:00','2007-09-30 23:00:28','2007-09-27 22:34:21',101,'A',NULL,NULL,NULL,NULL,NULL,'".$M[0]."','center','100%','15%','70%','15%','#FFFFFF','','80','#FF9900','','','#FFFFFF','','#FFFFFF','','#FFFFFF','','40','#FF9900','','');";
				$db->query($insert);
				//add block_function
				//echo "SELECT * FROM design_list WHERE d_id = '".$M[0]."' ";
				$sql_temp1 = $db->query("SELECT * FROM design_list WHERE d_id = '".$M[0]."' ");
					$R = $db->db_fetch_array($sql_temp1);
					for($i=1;$i<6;$i++){
						 $sql_block = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON block.BID = design_block.BID WHERE block.block_edit != 'Y' AND design_block.side = '".$i."' AND design_block.d_id = '".$M[0]."' ORDER BY design_block.position ASC");
								$x = 0;
							while($B = $db->db_fetch_row($sql_block)){
								$bid[$i][$x] = $B[0];
								$x++;
							}
					}
					$db->query("UPDATE temp_index SET d_site_align = '".$R["d_site_align"]."' , d_site_width = '".$R["d_site_width"]."' , d_site_left = '".$R["d_site_left"]."' , d_site_content = '".$R["d_site_content"]."' , d_site_right = '".$R["d_site_right"]."' , d_site_bg_c = '".$R["d_site_bg_c"]."' , d_site_bg_p = '".$R["d_site_bg_p"]."' , d_top_height = '".$R["d_top_height"]."' , d_top_bg_c = '".$R["d_top_bg_c"]."' , d_top_bg_p = '".$R["d_top_bg_p"]."' , d_top_content = '".$R["d_top_content"]."' , d_body_bg_c = '".$R["d_body_bg_c"]."' , d_body_bg_p = '".$R["d_body_bg_p"]."' , d_left_bg_c = '".$R["d_left_bg_c"]."' , d_left_bg_p = '".$R["d_left_bg_p"]."' , d_right_bg_c = '".$R["d_right_bg_c"]."' , d_right_bg_p = '".$R["d_right_bg_p"]."' , d_bottom_height = '".$R["d_bottom_height"]."' , d_bottom_bg_c = '".$R["d_bottom_bg_c"]."' , d_bottom_bg_p = '".$R["d_bottom_bg_p"]."' , d_bottom_content = '".$R["d_bottom_content"]."',set_intro = '' WHERE filename = '".$link_name."' ");
			
					for($i=1;$i<6;$i++){
						$sql_block = $db->query("SELECT block.BID FROM block INNER JOIN block_function ON block.BID = block_function.BID WHERE block.block_edit = 'Y' AND block_function.side = '".$i."' AND block_function.filename = '".$link_name."' ORDER BY block_function.position ASC");
								$x = count($bid[$i]);
							while($B = $db->db_fetch_row($sql_block)){
								$bid[$i][$x] = $B[0];
								$x++;	
							}
							$db->query("DELETE FROM block_function WHERE side = '".$i."' AND filename = '".$link_name."'");
							$c = count($bid[$i]);
							for($y=0;$y<$c;$y++){
									if($bid[$i][$y] != ""){
										$db->query("INSERT INTO block_function (BID,side,position,filename) VALUES ('".$bid[$i][$y]."','".$i."','".$y."','".$link_name."')");
									}
							}
					}
		
			}//end for $i
			$db->query("USE db_00_template");
$Current_Del = "../ewt/".$_SESSION["EWT_SUSER"]."/images/templates";
LooPDel($Current_Del);
//echo $d_top_content;
@mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/images/templates", 0777);
phpxcopy("../ewt/template/images/templates/".$d_top_content, "../ewt/".$_SESSION["EWT_SUSER"]."/images/templates/".$d_top_content);
	
?>
<script language="javascript1.2">
window.location.href = 'site_wizard_03.php?d_id=<?php echo $M[0];?>';
</script>
<?php
}//end if flag==addtemplate




function create_filethemes($themes_id){
global $db;
$namefolder = "themes".$themes_id;

//create file php for include
$fields_themes = array();
$sql_themes = $db->query("SHOW FULL FIELDS FROM `themes`");
while($rec_themes = $db->db_fetch_array($sql_themes)){
array_push($fields_themes,$rec_themes[Field]);
}
//print_r($fields_themes);
$sql = "select  * from themes where themes_id = '".$themes_id."'";
$query = $db->query($sql);
$rec=$db->db_fetch_array($query);
$text .= "<?php   \n";

	for($i=0;$i<count($fields_themes);$i++){
		$text .= "$".$fields_themes[$i]."='".$rec[$fields_themes[$i]]."';"."\n";
	}
$text .="$"."Current_Dir1 = \"themesdesign/".$namefolder."/\";"."\n";
$text .="if (eregi(\"%\", "."$"."mainwidth".")) {
 //ok
 "."$"."bg_width = (100 - "."$"."bg_width).'%';
}else{
//no ok
 "."$"."bg_width = ("."$"."mainwidth - "."$"."bg_width);
}";
$text .= "    ?>";
$Current_Dir1 = "../ewt/".$_SESSION["EWT_SUSER"]."/themesdesign/".$namefolder."/".$namefolder.".php";
	if (!$fp = fopen($Current_Dir1, 'w')) {
         //print "Cannot open file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot open file(<?php echo $Current_Dir1;?>)");
		</script>
		 <?php
         exit;
   		 }
		 if (!fwrite($fp, $text)) {
        //print "Cannot write to file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot write to file(<?php echo $Current_Dir1;?>)");
		</script>
		 <?php
        exit;
  	  }
		fclose($fp);
}



//add theme block
if($_GET[flag]=='addtheme'){

$db->query("USE db_00_template");

$sql=$db->query("select * from themes where themes_id ='".$_GET[thm_id]."'");
$rec = $db->db_fetch_array($sql);
$themesname_folder = 'themes'.$_GET[thm_id];
$themes_group=$rec[themes_group];    
$themes_type=$rec[themes_type];       
$themes_file=$rec[themes_file];             
$themes_namethems=$rec[themes_namethems];   
$themes_name=$rec[themes_name];         
$themes_modulename=$rec[themes_modulename];   
$bg_img=$rec[bg_img];     
$bg_color=$rec[bg_color];   
$bg_width =$rec[bg_width];   
$head_img=$rec[head_img];   
$head_color  =$rec[head_color];   
$head_font_face=$rec[head_font_face];   
$head_font_face2 =$rec[head_font_face2];   
$head_font_size =$rec[head_font_size];   
$head_font_size2 =$rec[head_font_size2];   
$head_font_color =$rec[head_font_color];   
$head_font_color2 =$rec[head_font_color2];   
$head_height =$rec[head_height];   
$body_bg_img =$rec[body_bg_img];   
$body_color =$rec[body_color];   
$body_font_face =$rec[body_font_face];   
$body_font_face2  =$rec[body_font_face2];   
$body_font_face3 =$rec[body_font_face3];   
$body_font_size =$rec[body_font_size];   
$body_font_size2=$rec[body_font_size2];   
$body_font_size3 =$rec[body_font_size3];   
$body_font_color =$rec[body_font_color];   
$body_font_color2 =$rec[body_font_color2];   
$body_font_color3 =$rec[body_font_color3];   
$bottom_img =$rec[bottom_img];   
$bottom_color  =$rec[bottom_color];   
$bottom_height =$rec[bottom_height];
//add block design   
$db->query("USE ".$_SESSION["EWT_SDB"]);
$insert = "insert into themes (themes_group,themes_type,themes_file,themes_namethems,themes_name,themes_modulename,bg_img,bg_color,
								bg_width,head_img,head_color,head_font_face,head_font_face2,head_font_size,head_font_size2,
								head_font_color,head_font_color2,head_height,body_bg_img,body_color,body_font_face,body_font_face2,
								body_font_face3,body_font_size,body_font_size2,body_font_size3,body_font_color,body_font_color2,
								body_font_color3,bottom_img,bottom_color,bottom_height) 
						values ('".$rec[themes_group]."','".$rec[themes_type]."','".$rec[themes_file]."','".$rec[themes_namethems]."','".$rec[themes_name]."','".$rec[themes_modulename]."','".$rec[bg_img]."','".$rec[bg_color]."',
								'".$rec[bg_width]."','".$rec[head_img]."','".$rec[head_color]."','".$rec[head_font_face]."','".$rec[head_font_face2]."','".$rec[head_font_size]."','".$rec[head_font_size2]."',
								'".$rec[head_font_color]."','".$rec[head_font_color2]."','".$rec[head_height]."','".$rec[body_bg_img]."','".$rec[body_color]."','".$rec[body_font_face]."','".$rec[body_font_face2]."',
								'".$rec[body_font_face3]."','".$rec[body_font_size]."','".$rec[body_font_size2]."','".$rec[body_font_size3]."','".$rec[body_font_color]."','".$rec[body_font_color2]."',
								'".$rec[body_font_color3]."','".$rec[bottom_img]."','".$rec[bottom_color]."','".$rec[bottom_height]."')";

$db->query($insert);
//id-max
$sql_max = $db->query("select max(themes_id) as maxid from themes order by themes_id DESC");
$query_max =$db->db_fetch_array($sql_max);
$themes_maxid =$query_max[maxid];
$themesname_folder_new = 'themes'.$themes_maxid;
$Current_Del = "../ewt/".$_SESSION["EWT_SUSER"]."/themesdesign";
LooPDel($Current_Del);
@mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/themesdesign", 0777);
@mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/templates", 0777);
copy("../ewt/template/themesdesign/configthemes.php", "../ewt/".$_SESSION["EWT_SUSER"]."/themesdesign/configthemes.php");
@mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/themesdesign/".$themesname_folder_new, 0777);
if($themes_file != ''){
copy("../ewt/template/themesdesign/".$themesname_folder."/".$themes_file, "../ewt/".$_SESSION["EWT_SUSER"]."/themesdesign/".$themesname_folder_new."/".$themes_file);
}
$sql_update = $db->query("update themes set themes_namethems = '".$themesname_folder_new."'
													where themes_id = '".$themes_maxid."'");
create_filethemes($themes_maxid);
//update to design tb
$update = "update design_list set d_bottom_content = '$themes_maxid' where d_id = '".$_GET[d_id]."'";
$db->query($update);
//update block
	$sql_block = $db->query("SELECT * FROM block,design_block WHERE block.BID=design_block.BID and  design_block.d_id  = '".$_GET[d_id]."' ");
		while($R=$db->db_fetch_array($sql_block)){
			$update = "update block set block_themes = '$themes_maxid' where BID = '".$R[BID]."'";
			$db->query($update);
		}

phpxcopy("../ewt/template/themesdesign/".$themesname_folder, "../ewt/".$_SESSION["EWT_SUSER"]."/themesdesign/".$themesname_folder_new);
phpxcopy("../ewt/template/templates/".$themes_modulename, "../ewt/".$_SESSION["EWT_SUSER"]."/templates/".$themes_modulename);
@unlink("../ewt/".$_SESSION["EWT_SUSER"]."/themesdesign/".$themesname_folder_new.'/'.$themesname_folder.".php");
session_unregister("EWT_OPEN_SAVE");
?>
<script language="javascript1.2">

//window.top.location.href = '../ewt_main.php';
window.opener.top.location.href = '../index_frame.php';
window.close();
</script>
<?php
}//end if flag =addtheme
exit;
?>

