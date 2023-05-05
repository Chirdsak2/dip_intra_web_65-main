<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/menu_language.php");
function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}

$sql = $db->query("SELECT * FROM menu_list WHERE m_id = '".$_GET["m_id"]."' ");
$R = $db->db_fetch_array($sql);
$sql1 = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$_GET["m_id"]."' ORDER BY mp_id ASC");
if($R[glo_showsub]=="Y" && $R[glo_highlight]=="Y"){ 
	$show_id=3; 
}  else if($R[glo_showsub]=="Y" && $R[glo_highlight]==""){ 
	$show_id=1; 
}  else {
	$show_id=0; 
}
$show_trans=100-$R[pop_trans];
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
			function exit(){
				self.top._blank.location.href = "menu_index.php";
				self.location.href = "../ewt_left.php";
			}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">

<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" class="ewttableuse">
<form name="form1" method="post" action="">
  <tr> 
      <td width="85%" height="30" class="ewttablehead"><img src="../theme/main_theme/menu_preview.gif" width="24" height="24" align="absmiddle"> 
        <?php echo $text_menu_preview ?>		</td>

  </tr>

  <tr>
    <td colspan="2" valign="top" bgcolor="#FFFFFF">
<script type="text/javascript" language="JavaScript1.2" src="../js/stm31.js"></script>
<script type="text/javascript" language="JavaScript1.2">
<?php if($rows = $db->db_num_rows($sql1)){ ?>
<!--
stm_bm(["menu0a49",400,"","../images/o.gif",0,"","",<?php echo $R[glo_align]; ?>,<?php echo $show_id; ?>,<?php echo $R[glo_delay_ver]; ?>,<?php echo $R[glo_delay_hor]; ?>,<?php echo $R[glo_delay_hide]; ?>,1,0,0,"","",0],this);
stm_bp("p0",[<?php echo $R[pop_display]; ?>,4,0,0,<?php echo $R[pop_spacing]; ?>,<?php echo $R[pop_padding]; ?>,1,1,<?php echo $show_trans; ?>,"",-2,"",-2,50,0,0,"#fffff7","<?php echo $R[pop_bgcolor]; ?>","<?php echo $R[pop_bgimage]; ?>",3,<?php echo $R[pop_borstyle]; ?>,<?php echo $R[pop_borwidth]; ?>,"<?php echo $R[pop_borcolor]; ?>"]);
<?php
$LenChk = 0;
	$i = 0;
		while($RR=$db->db_fetch_array($sql1)){
			$len = GenLen($RR[mp_id],"_");
			if($LenChk > $len ){
				for($y=$len;$y<$LenChk;$y++){
					echo "stm_ep();\n";
			}
		}
		if($RR[Gicon] != ""){
		 $RR[Gicon] = "../ewt/".$_SESSION["EWT_SUSER"]."/".$RR[Gicon];
		}
		if($RR[Garrow] != ""){
		 $RR[Garrow] = "../ewt/".$_SESSION["EWT_SUSER"]."/".$RR[Garrow];
		}
		if($RR[Oubgpic] != ""){
		 $RR[Oubgpic] = "../ewt/".$_SESSION["EWT_SUSER"]."/".$RR[Oubgpic];
		}
		if($RR[Ovbgpic] != ""){
		 $RR[Ovbgpic] = "../ewt/".$_SESSION["EWT_SUSER"]."/".$RR[Ovbgpic];
		}
?>
stm_ai("p<?php echo $i; ?>",[1,"<?php echo stripslashes($RR[mp_name]); ?>","","",-1,-1,0,"<?php echo stripslashes($RR[Glink]); ?>","_blank","","<?php echo stripslashes($RR[Gtip]); ?>","<?php echo $RR[Gicon]; ?>","<?php echo $RR[Gicon]; ?>",-1,-1,0,"<?php echo $RR[Garrow]; ?>","<?php echo $RR[Garrow]; ?>",-1,-1,0,<?php echo $RR[Galign]; ?>,<?php echo $RR[Gvalign]; ?>,"<?php echo $RR[Oubgcolor]; ?>",<?php echo $RR[Outrans]; ?>,"<?php echo $RR[Ovbgcolor]; ?>",<?php echo $RR[Ovtrans]; ?>,"<?php echo $RR[Oubgpic]; ?>","<?php echo $RR[Ovbgpic]; ?>",3,3,<?php echo $RR[Ouborderstyle]; ?>,<?php echo $RR[Ouborderw]; ?>,"<?php echo $RR[Oubordercolor]; ?>","<?php echo $RR[Ovbordercolor]; ?>","<?php echo $RR[Oucolor]; ?>","<?php echo $RR[Ovcolor]; ?>","<?php echo $RR[Ouitalic]; ?> <?php echo $RR[Oubold]; ?> <?php echo $RR[Ousize]; ?><?php echo $RR[Ousizepr]; ?> <?php echo $RR[Oufont]; ?>","<?php echo $RR[Ovitalic]; ?> <?php echo $RR[Ovbold]; ?> <?php echo $RR[Ovsize]; ?><?php echo $RR[Ovsizepr]; ?> <?php echo $RR[Ovfont]; ?>",0,0]);	
<?php
	$selSub = $db->query("SELECT mp_id FROM menu_properties WHERE m_id = '$_GET[m_id]' AND mp_id LIKE '".$RR[mp_id]."_%'"); 
if($db->db_num_rows($selSub) > 0){
		if($RR[Popbgpic] != ""){
		 $RR[Popbgpic] = "../ewt/".$_SESSION["EWT_SUSER"]."/".$RR[Popbgpic];
		}
?>
stm_bp("p0",[<?php echo $RR[PopDisplay]; ?>,<?php echo $RR[PopDirect]; ?>,<?php echo $RR[PopX]; ?>,<?php echo $RR[PopY]; ?>,<?php echo $RR[PopSpac]; ?>,<?php echo $RR[PopPad]; ?>,1,1,100,"",-2,"",-2,<?php echo $RR[PopEffectSpeed]; ?>,<?php echo $RR[Popshadowstyle]; ?>,<?php echo $RR[Popshadowsize]; ?>,"<?php echo $RR[Popshadowcolor]; ?>","<?php echo $RR[Popbgcolor]; ?>","<?php echo $RR[Popbgpic]; ?>",3,<?php echo $RR[Popborderstyle] ?>,<?php echo $RR[PopBorderW]; ?>,"<?php echo $RR[Popbordercolor]; ?>"]);
<?php
//	$ChkClose[$len] = "1";
}

$LenChk = $len;
	$i++;
	}
echo "stm_ep();\n";
?>
stm_em();
<?php }?>
//-->
</script>	  </td>
  </tr>
  </form>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
