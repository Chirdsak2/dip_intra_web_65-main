<?php
function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}
function GenMenu($m_id){

global $db;

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

$txt = "<script type=\"text/javascript\" language=\"JavaScript1.2\">";
if($rows = mysql_num_rows($sql1)){

$txt .= "stm_bm([\"menu0a49\",400,\"\",\"blank.gif\",0,\"\",\"\",".$R[glo_align].",".$show_id.",".$R[glo_delay_ver].",".$R[glo_delay_hor].",".$R[glo_delay_hide].",1,0,0,\"\",\"\",0],this);\n";
$txt .= "stm_bp(\"p0\",[".$R[pop_display].",4,0,0,".$R[pop_spacing].",".$R[pop_padding].",0,0,".$show_trans.",\"\",-2,\"\",-2,50,0,0,\"#fffff7\",\"".$R[pop_bgcolor]."\",\"".$R[pop_bgimage]."\",3,".$R[pop_borstyle].",".$R[pop_borwidth].",\"".$R[pop_borcolor]."\"]);\n";
$LenChk = 0;
	$i = 0;
		while($RR=$db->db_fetch_array($sql1)){
			$len = GenLen($RR[mp_id],"_");
			if($LenChk > $len ){
				for($y=$len;$y<$LenChk;$y++){
					$txt .= "stm_ep();\n";
			}
		}

$txt .= "stm_ai(\"p".$i."\",[1,\"".stripslashes($RR[mp_name])."\",\"\",\"\",-1,-1,0,\"".stripslashes($RR[Glink])."\",\"".$RR[Gtarget]."\",\"\",\"".stripslashes($RR[Gtip])."\",\"\",\"\",0,0,0,\"\",\"\",0,0,0,".$RR[Galign].",".$RR[Gvalign].",\"".$RR[Oubgcolor]."\",".$RR[Outrans].",\"".$RR[Ovbgcolor]."\",".$RR[Ovtrans].",\"".$RR[Oubgpic]."\",\"".$RR[Ovbgpic]."\",3,3,".$RR[Ouborderstyle].",".$RR[Ouborderw].",\"".$RR[Oubordercolor]."\",\"".$RR[Ovbordercolor]."\",\"".$RR[Oucolor]."\",\"".$RR[Ovcolor]."\",\"".$RR[Ouitalic]." ".$RR[Oubold]." ".$RR[Ousize].$RR[Ousizepr]." ".$RR[Oufont]."\",\"".$RR[Ovitalic]." ".$RR[Ovbold]." ".$RR[Ovsize].$RR[Ovsizepr]." ".$RR[Ovfont]."\",0,0]);\n";	

	$selSub = $db->query("SELECT mp_id FROM menu_properties WHERE m_id = '".$m_id."' AND mp_id LIKE '".$RR[mp_id]."_%'"); 
if($db->db_num_rows($selSub) > 0){

$txt .= "stm_bp(\"p0\",[".$RR[PopDisplay].",".$RR[PopDirect].",".$RR[PopX].",".$RR[PopY].",".$RR[PopSpac].",".$RR[PopPad].",0,0,100,\"\",-2,\"\",-2,".$RR[PopEffectSpeed].",".$RR[Popshadowstyle].",".$RR[Popshadowsize].",\"".$RR[Popshadowcolor]."\",\"".$RR[Popbgcolor]."\",\"".$RR[Popbgpic]."\",3,".$RR[Popborderstyle].",".$RR[PopBorderW].",\"".$RR[Popbordercolor]."\"]);\n";

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
function GenMenu_w3c($m_id){

global $db;

$sql1 = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$m_id."' ORDER BY mp_id ASC");
if($rows = mysql_num_rows($sql1)){
while($RR=$db->db_fetch_array($sql1)){
if($RR[Glink] != ""){
$txt .= "<a href=\"".stripslashes($RR[Glink])."\" target=\"".$RR[Gtarget]."\">";
}
$txt .= "<li>".stripslashes($RR[mp_name])."</li>";
if($RR[Glink] != ""){
$txt .= "</a>";
}
$txt .= "<br>";
}
}
return $txt;
}
function GenFontSize($text_id){
	?><style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 8pt;
	color: #8b4513;
}
-->
</style>
	<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="162336">
  <tr>
    <td align="center"><img src="mainpic/text_size.gif" width="121" height="26" border="0" usemap="#Map<?php echo $text_id; ?>"></td>
  </tr>
</table>
<map name="Map<?php echo $text_id; ?>">
  <area shape="rect" coords="66,4,80,24" href="#123" onClick="document.all.stext.href='css/small.css';" >
  <area shape="rect" coords="82,4,97,24" href="#123" onClick="document.all.stext.href='css/normal.css';">
  <area shape="rect" coords="103,4,118,23" href="#123" onClick="document.all.stext.href='css/big.css';">
</map>
	<?php
}
function GenChart_old($org){
$o = explode(",",$org);
$org_id = $o[0];
$type = $o[1];
$sname = $o[2];
$spic = $o[3];
$sdetail = $o[4];
global $db;
$db->query("USE ".$EWT_DB_NAME);
if($type == "1"){
?>
<?php
  $sql_group1 = $db->query("SELECT * FROM org_name WHERE org_id = '".$org_id."' ");
  $R = $db->db_fetch_array($sql_group1);
?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#EEEEEE"><font size="4"><strong><?php echo $R[name_org]; ?></strong></font><?php if($sdetail == "Y"){ ?><hr size="1">
      <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
        <tr> 
          <td width="31%" class="bg_color_row">สถานที่ตั้ง :</td>
          <td width="69%"><?php echo $R[org_place] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">ที่อยู่ :</td>
          <td><?php echo $R[org_address] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">เบอร์โทรศัพท์ภายใน :</td>
          <td><?php echo $R[tel] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">Fax :</td>
          <td><?php echo $R[fax] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">Email : </td>
          <td><?php echo $R[email] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">URL :</td>
          <td><?php echo $R[org_url] ?></td>
        </tr>
      </table>
      <?php } ?></td>
  </tr>
</table>
<br>
<?php
$sql_position = $db->query("SELECT * FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.org_id = '".$R["org_id"]."' ORDER BY user_position.up_rank ASC");
while($P = $db->db_fetch_array($sql_position)){
?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="2">
  <tr>
    <td align="center" bgcolor="#F7F7F7"><font size="1"  face="MS Sans Serif"><b><?php echo $P["pos_name"]; ?></b></font></td>
  </tr>
   <tr>
    <td align="center" >&nbsp;</td>
  </tr>
  <tr>
    <td>
	<?php
	$sql_user = $db->query("SELECT * FROM gen_user WHERE posittion = '".$P["up_id"]."' ORDER BY org_type_id DESC,name_thai ASC");//gen_user_id ASC ,
	$x=0;
	while($U = $db->db_fetch_array($sql_user)){
		if($x%3 == 0){
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
		}
		if($U["path_image"] != ""){
		$path1 = eregi_replace("../pic_upload/","",$U["path_image"]);
		$path = "../nha_profile/pic_upload/".$path1;
		}else{
		$path = "../../images/ImageFile.gif";
		}
	?>

    <td align="center" valign="top" width="33%"><?php if($spic == "Y"){ ?><img src="img.php?p=<?php echo base64_encode($path); ?>"  height="150" align="absmiddle"><?php } ?><?php if($sname == "Y"){ ?><div><font size="2"><?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?></font><?php } ?></div>
	</td>
        
	  <?php $x++;
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

<?php } ?>
<?php
}else{
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
win5 = window.open('ewt_org.php?oid='+c+'&org=<?php echo $org; ?>','org','height=500,width=600,resizable=1,scrollbars=1');
win5.focus();
}
</script>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
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
		   if($count_sub[0] > 0){ ?><img src="mainpic/minus.gif" border="0" align="absmiddle" onClick="divshow(document.all.dv<?php echo $i; ?>,this)"><?php }else{ ?><img src="mainpic/o.gif" width="20" height="20" border="0" align="absmiddle"><?php } ?>
        <a href="#show" onClick="divshow1('<?php echo $R["org_id"]; ?>')"><img src="mainpic/user_group.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<?php echo $R["name_org"]; ?></a> 
      </div>
	                      <?php
	   $k++;
		   ?>
	   <?php  if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  >"; }  ?>
  <?php 
	
   $i++; } ?>
  </div>
</td>
  </tr>
</table>
<?
}

if($_SESSION["EWT_SDB"] != ""){
$db->query("USE ".$_SESSION["EWT_SDB"]);
}else{
global $EWT_DB_NAME;
$db->query("USE ".$EWT_DB_NAME);
}
}
echo $org;
function GenChart($org){
$o = explode(",",$org);
$org_id = $o[0];
$type = $o[1];
$sname = $o[2];
$spic = $o[3];
$sdetail = $o[4];
global $db;
$db->query("USE ".$EWT_DB_NAME);
if($type == "1"){
?>
<?php
  $sql_group1 = $db->query("SELECT * FROM org_name WHERE org_id = '".$org_id."' ");
  $R = $db->db_fetch_array($sql_group1);
?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#EEEEEE"><font size="4"><strong><?php echo $R[name_org]; ?></strong></font><?php if($sdetail == "Y"){ ?><hr size="1">
      <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
        <tr> 
          <td width="31%" class="bg_color_row">สถานที่ตั้ง :</td>
          <td width="69%"><?php echo $R[org_place] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">ที่อยู่ :</td>
          <td><?php echo $R[org_address] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">เบอร์โทรศัพท์ภายใน :</td>
          <td><?php echo $R[tel] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">Fax :</td>
          <td><?php echo $R[fax] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">Email : </td>
          <td><?php echo $R[email] ?></td>
        </tr>
        <tr> 
          <td class="bg_color_row">URL :</td>
          <td><?php echo $R[org_url] ?></td>
        </tr>
      </table>
      <?php } ?></td>
  </tr>
</table>
<br>
<?php
echo $sql = "select max(org_type_id) as max_c FROM gen_user WHERE org_id = '".$R["org_id"]."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$max_c = $rec[max_c];
$sql2 = "select min(org_type_id) as min_c FROM gen_user WHERE org_id = '".$R["org_id"]."'  ";
$query2 = $db->query($sql2);
$rec2 = $db->db_fetch_array($query2);
$min_c = $rec2[min_c];
$sql_position = $db->query("SELECT * FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.org_id = '".$R["org_id"]."' ORDER BY user_position.up_rank ASC");
while($P = $db->db_fetch_array($sql_position)){
?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="2">
  <tr>
    <td align="center" bgcolor="#F7F7F7"><font size="1"  face="MS Sans Serif"><b><?php echo $P["pos_name"]; ?></b></font></td>
  </tr>
   <tr>
    <td align="center" >&nbsp;</td>
  </tr>
  <tr>
    <td>
	<?php
	for($i=$max_c;$i >=$min_c;$i--){
	$sql_user = $db->query("SELECT * FROM gen_user WHERE org_type_id = '".$i."' and   org_id = '".$R["org_id"]."' and posittion = '".$P["up_id"]."' ORDER BY org_type_id DESC,name_thai ASC");//gen_user_id ASC ,
	$x=0;
	if(mysql_num_rows($sql_user)>0){
	
	//echo "ระดับ".$i; 
	
	}
	while($U = $db->db_fetch_array($sql_user)){
		if($x%3 == 0){
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
		}
		if($U["path_image"] != ""){
		$path1 = eregi_replace("../pic_upload/","",$U["path_image"]);
		$path = "../nha_profile/pic_upload/".$path1;
		}else{
		$path = "../../images/ImageFile.gif";
		}
	?>

  <td align="center" valign="top" width="33%"><?php if($spic == "Y"){ ?><img src="img.php?p=<?php echo base64_encode($path); ?>"  height="150" align="absmiddle"><?php } ?><?php if($sname == "Y"){ ?><div><font size="2"><?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?>(<?php echo "ระดับ".$i; ?>)</font><?php } ?></div>
	</td>
        
	  <?php $x++;
		if($x%3 == 0){
		echo "</tr></table><br>";
		}
} 
	if($x%3==1 OR $x%3==2){
		echo "</tr></table><br>";
	}
}
?>
	  </td>
  </tr>
</table>

<?php } ?>
<?php
}else{
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
win5 = window.open('ewt_org.php?oid='+c+'&org=<?php echo $org; ?>','org','height=500,width=600,resizable=1,scrollbars=1');
win5.focus();
}
</script>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
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
		   if($count_sub[0] > 0){ ?><img src="mainpic/minus.gif" border="0" align="absmiddle" onClick="divshow(document.all.dv<?php echo $i; ?>,this)"><?php }else{ ?><img src="mainpic/o.gif" width="20" height="20" border="0" align="absmiddle"><?php } ?>
        <a href="#show" onClick="divshow1('<?php echo $R["org_id"]; ?>')"><img src="mainpic/user_group.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<?php echo $R["name_org"]; ?></a> 
      </div>
	                      <?php
	   $k++;
		   ?>
	   <?php  if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  >"; }  ?>
  <?php 
	
   $i++; } ?>
  </div>
</td>
  </tr>
</table>
<?
}

if($_SESSION["EWT_SDB"] != ""){
$db->query("USE ".$_SESSION["EWT_SDB"]);
}else{
global $EWT_DB_NAME;
$db->query("USE ".$EWT_DB_NAME);
}
}
function GenPoll($text_id){
global $db;
$PollSel = $db->query("SELECT * FROM poll_cat WHERE  c_id = '".$text_id."' ");
if($rows = $db->db_num_rows($PollSel)){
$pollR = $db->db_fetch_array($PollSel);
?>
<TABLE width="100%" border=0 align="center" cellPadding=0 cellSpacing=0 style="font-family:Tahoma;font-size:13px;">
<form name=PollForm onSubmit="winPollVote = window.open('', 'PollVote', 'alwaysRaised=1,menuber=0,toolbar=0,location=0,directories=0,personalbar=0,scrollbars=0,status=0,resizable=1,width=550,height=410'); winPollVote.focus();  return true;" action="ewt_vote.php" method=post target=PollVote>
<TBODY>
      <tr>
        <td width="12" background="mainpic/krom1_03.jpg" height="35"></td>
        <td background="mainpic/krom1_05.jpg"><table cellspacing="0" cellpadding="0" width="100%" border="0">
          <tbody>
            <tr>
              <td width="30" background="mainpic/krom3_04.jpg" height="35"></td>
              <td valign="bottom"><span style="FONT-SIZE: 8pt; COLOR: #8b4513; FONT-FAMILY: Tahoma"><strong>ร่วมแสดงความคิดเห็น</strong></span></td>
            </tr>
          </tbody>
        </table></td>
        <td width="9" background="mainpic/krom1_06.jpg"></td>
      </tr>
      <tr>
        <td background="mainpic/krom1_07.jpg"></td>
        <td><table width="100%"  border="0" align="center" cellpadding="1" cellspacing="0" >
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1">
              <TR>
<TD valign="top" bgColor=#FFFFFF>
<TABLE  cellSpacing=0 cellPadding=3 width="100%" border=0 style="font-family:Tahoma;font-size:12px;">
<TBODY>
<TR>
<TD colSpan=2><STRONG><?php echo stripslashes($pollR[c_name]); ?></STRONG></TD></TR>
<?php $SelPoll = $db->query("SELECT * FROM poll_ans WHERE c_id = '$pollR[c_id]' ORDER BY a_id ASC"); 
while($pollAns = $db->db_fetch_array($SelPoll)){
?>
<TR>
<TD width=20><INPUT type="radio" value="<? echo $pollAns[a_id]; ?>" name="vote"></TD>
<TD width=926><? echo stripslashes($pollAns[a_name]); ?></TD></TR>
<? } ?>
<TR>
<TD colspan="2">
<INPUT type=submit value="Vote!" name="Submit" style="font-family:Tahoma;font-size:11px;color:#000000">  
<INPUT type=submit value="Vote Result" name="Submit1" style="font-family:Tahoma;font-size:11px;color:#000000">
  <input name="cad_id" type="hidden" id="cad_id" value="<?php echo $pollR[c_id]; ?>"></TD>
</TR></TBODY></TABLE></TD>
</TR>
            </table></td>
          </tr>
        </table></td>
        <td background="mainpic/krom1_09.jpg"></td>
      </tr>
      <tr>
        <td><img height="17" src="mainpic/krom1_10.jpg" width="12" /></td>
        <td background="mainpic/krom1_11.jpg"></td>
        <td><img height="17" src="mainpic/krom1_12.jpg" width="9" /></td>
      </tr>
    </tbody>
  </form>
</table>
<? }

}
function GenENews(){
	global $filename;
?>
<table id="tball" width="174" border="0" align="center" cellpadding="0" cellspacing="0" >
<form name="NewsLetterForm" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" onSubmit="return ChkValueNewsLetter();">
   <tbody>
     <tr>
       <td width="12" background="mainpic/krom1_03.jpg" height="35"> </td>
       <td background="mainpic/krom1_05.jpg">
         <table cellspacing="0" cellpadding="0" width="100%" border="0">
           <tbody>
             <tr>
               <td width="30" background="mainpic/krom2_04.jpg" height="35"> </td>
               <td valign="bottom"><span style="FONT-SIZE: 8pt; COLOR: #8b4513; FONT-FAMILY: Tahoma"><strong>Newsletter Sign up</strong></span></td>
            </tr>
          </tbody>
        </table></td>
       <td width="9" background="mainpic/krom1_06.jpg"> </td>
    </tr>
     <tr>
       <td background="mainpic/krom1_07.jpg"></td>
       <td><table width="100%"  border="0" align="center" cellpadding="1" cellspacing="0" >
         <tr>
           <td align="left" valign="top" bgcolor="#FFFFFF">
		    	<table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1">
						<tr>
						  <td height="15" align="center" ><span style="FONT-SIZE: 8pt; FONT-FAMILY: Tahoma">สมัครรับข่าวสาร<br>กรุณาใส่อีเมล์ของท่าน</span></td>
						</tr>
						<tr>
							<td height="10" align="center" >
									<input name="newsletteremail" type="text" id="newsletteremail"  style="width:92%">
							</td>
						</tr>
						<tr>
							<td height="10" align="center" >
									<input name="applynewsletter" type="radio" value="Y" checked><span style="FONT-SIZE: 8pt; FONT-FAMILY: Tahoma"><span id="newsapp" style=";">สมัคร</span><input type="radio" name="applynewsletter" value="N"><span style="FONT-SIZE: 8pt; FONT-FAMILY: Tahoma"><span id="newscan" style=";">ยกเลิก</span>
							</td>
						</tr>
						<tr>
						  <td align="center"><input name="Button01" type="submit" id="Button01" value="ตกลง">
						 </td>
						</tr>
				</table>
		   </td>
         </tr>
       </table></td>
       <td background="mainpic/krom1_09.jpg"></td>
    </tr>
     <tr>
       <td>
        <img height="17" src="mainpic/krom1_10.jpg" width="12" /></td>
       <td background="mainpic/krom1_11.jpg"></td>
       <td>
        <img height="17" src="mainpic/krom1_12.jpg" width="9" /></td>
    </tr>
  </tbody>
  </form>
</table>
<!--<table id="tball" width="160" border="0" align="center" cellpadding="0" cellspacing="0" >
<form name="NewsLetterForm" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" onSubmit="return ChkValueNewsLetter();">
  <tr>
    <td height="25" align="center" background="images/" bgcolor="FFCC00" id="tbd01"><font face="MS Sans Serif" color="333333" size="2"><span id="Hnews01" style="font-Weight:bold;">ข่าวสาร</span></font></td>
  </tr>
  <tr>
    <td align="center" background="images/" bgcolor="FFFFFF" id="tbd02">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		        <tr>
          <td height="10" align="center" ><font face="TAHOMA" color="000000" size="1"><span id="Dnews01" style=";">สมัครรับข่าวสาร</span></font></td>
        </tr>
      </table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		        <tr><td height="10" align="center" >
	  <input name="newsletteremail" type="text" id="newsletteremail"  style="width:92%">
			</td>
        </tr>
      </table>
			<input name="applynewsletter" type="radio" value="Y" checked><font face="MS Sans Serif" color="FFFFFF" size="1"><span id="newsapp" style=";">สมัคร</span></font><input type="radio" name="applynewsletter" value="N"><font face="MS Sans Serif" color="FFFFFF" size="1"><span id="newscan" style=";">ยกเลิก</span></font>
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td  align="right"><input name="Button01" type="submit" id="Button01" value="ตกลง">
         </td>
        </tr>
      </table></td>
  </tr></form>
</table>-->
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
function ChkValueNewsLetter(){
	if(document.NewsLetterForm.newsletteremail.value == ""){
		alert('กรุณาระบุอีเมล์ของท่าน');
		document.NewsLetterForm.newsletteremail.focus();
		return false;
	}else if(!validEMail(document.NewsLetterForm.newsletteremail)){
		alert('รูปแบบของอีเมล์ไม่ถูกต้อง');
		document.NewsLetterForm.newsletteremail.select();
		return false;
	}
	if(document.NewsLetterForm.applynewsletter[1].checked){
		r = confirm("คุณต้องการยกเลิกการรับข้อมูลจากทางเรา ?");
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
function GenSurvey($s_id){
	if($s_id != ""){
global $db;
global $filename;
$Yn = date("Y")+543;
$dn = date("m-d");
$dn = $Yn."-".$dn;
$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' and s_approve = 'Y' and ( '$dn' between s_start and s_end )");

if(!$rows = mysql_num_rows($SQL1)){
	$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
	$PX = mysql_fetch_array($SQLX);
?>
<script language="javascript">
window.location.href="<?php if($PX[start_page]!=""){ echo $PX[start_page]; }else{ echo "survey_error.php"; } ?>";
	</script>
<?
exit;
}
	if(getenv(HTTP_X_FORWARDED_FOR)){
						$IPn = getenv(HTTP_X_FORWARDED_FOR);
				}else{
						$IPn = getenv("REMOTE_ADDR");
				}
$SQL1 = $db->query("SELECT * FROM p_ip WHERE p_id = '$s_id' and ip = '$IPn'");

if(mysql_num_rows($SQL1)>0){
	$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
	$PX = mysql_fetch_array($SQLX);
?>
<script language="javascript">
//window.location.href="<?php if($PX[start_page]!=""){ echo $PX[start_page]; }else{ echo "survey_error.php"; } ?>";
	</script>
<?
//exit;
}
$PR = mysql_fetch_array($SQL1);

$SubjectMainF = "Tahoma";
$SubjectMainS = "4";
$SubjectMainC = "FF9900";
$SubjectMainB = "Y";
$SubjectMainI = "";
$SubjectPartF = "Tahoma";
$SubjectPartS = "2";
$SubjectPartC = "FFFF00";
$SubjectPartB = "Y";
$SubjectPartI = "";
$SubjectPartBGC = "996600";
$SubjectPartW = "";
$DescPartF = "Tahoma";
$DescPartS = "2";
$DescPartC = "FFFFCC";
$DescPartB = "";
$DescPartI = "";
$Question1F = "Tahoma";
$Question1S = "2";
$Question1C = "663300";
$Question1B = "";
$Question1I = "";
$Question1BGC = "CC9933";
$Answer1F = "Tahoma";
$Answer1S = "2";
$Answer1C = "990000";
$Answer1B = "";
$Answer1I = "";
$Answer1BGC = "CCCCCC";
$Head1F = "Tahoma";
$Head1S = "2";
$Head1C = "663366";
$Head1B = "Y";
$Head1I = "";
$Head1BGC = "CC9900";
$Head2F = "Tahoma";
$Head2S = "2";
$Head2C = "996600";
$Head2B = "Y";
$Head2I = "";
$Head2BGC = "FFCC00";
$Question2F = "Tahoma";
$Question2S = "2";
$Question2C = "663300";
$Question2B = "";
$Question2I = "";
$Question2BGC = "FFCC66";
$Answer2BGC = "CCCCCC";
$HeadName1 = "ข้อที่";
$HeadName2 = "การประเมินความพึงพอใจ";
$HeadName3 = "ระดับความพึงพอใจ";
$PartName1 = "ส่วนที่";
$DescName1 = "คำชี้แจง";

?>
<?
$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");
?>
<form name="Surveyform" method="post" onSubmit="return GoNext();" action="survey_function.php?filename=<?php echo $filename; ?>">
<div align="center"><br>
    <font color="<? echo $SubjectMainC; ?>" size="<? echo $SubjectMainS; ?>" face="<? echo $SubjectMainF; ?>"><? if($SubjectMainB=="Y"){ echo "<b>"; } ?><? if($SubjectMainI=="Y"){ echo "<em>"; } ?><? echo $PR[s_title]; ?><? if($SubjectMainI=="Y"){ echo "</em>"; } ?><? if($SubjectMainB=="Y"){ echo "</b>"; } ?></font></div>

  <? 
if($PR[file_page] != ""){
  ?>
<div align="left"><font  size="1" face="<? echo $SubjectMainF; ?>"><a href="<?php echo $PR[file_page]; ?>" target="_blank">เอกสารแนบ : <?php echo $PR[file_page]; ?></a></font></div>
  <?
  }	  
  while($R=mysql_fetch_array($SQL)){  
  
  ?>
  <br>
	<?
	if($R[c_gp] =="Y" ){
	?>
	
	<table width="<? if($SubjectPartW!=""){ echo $SubjectPartW; }else{ echo "98%"; } ?>" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF" >
	  <tr>
	    <td colspan="<? echo $R[option2]+2; ?>" bgcolor="<? echo $SubjectPartBGC; ?>"><font color="<? echo $SubjectPartC; ?>" size="<? echo $SubjectPartS; ?>" face="<? echo $SubjectPartF; ?>"><? if($SubjectPartB=="Y"){ echo "<b>"; } ?><? if($SubjectPartI=="Y"){ echo "<em>"; } ?><? echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><? if($SubjectPartI=="Y"){ echo "</em>"; } ?><? if($SubjectPartB=="Y"){ echo "</b>"; } ?></font>
	    <font color="<? echo $DescPartC; ?>" size="<? echo $DescPartS; ?>" face="<? echo $DescPartF; ?>"><? if($DescPartB=="Y"){ echo "<b>"; } ?><? if($DescPartI=="Y"){ echo "<em>"; } ?><?  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><? if($DescPartI=="Y"){ echo "</em>"; } ?><? if($DescPartB=="Y"){ echo "</b>"; } ?></font></td>
      </tr>
		
	  <tr>
	    <td width="5%" rowspan="2" align="center" bgcolor="<? echo $Head1BGC; ?>"><font color="<? echo $Head1C; ?>" size="<? echo $Head1S; ?>" face="<? echo $Head1F; ?>"><? if($Head1B=="Y"){ echo "<b>"; } ?><? if($Head1I=="Y"){ echo "<em>"; } ?><? echo $HeadName1; ?><? if($Head1I=="Y"){ echo "</em>"; } ?><? if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	    <td width="50%" rowspan="2" align="center" bgcolor="<? echo $Head1BGC; ?>" ><font color="<? echo $Head1C; ?>" size="<? echo $Head1S; ?>" face="<? echo $Head1F; ?>"><? if($Head1B=="Y"){ echo "<b>"; } ?><? if($Head1I=="Y"){ echo "<em>"; } ?><? echo $HeadName2; ?><? if($Head1I=="Y"){ echo "</em>"; } ?><? if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	    <td colspan="<? echo $R[option2]; ?>" align="center" bgcolor="<? echo $Head1BGC; ?>" ><font color="<? echo $Head1C; ?>" size="<? echo $Head1S; ?>" face="<? echo $Head1F; ?>"><? if($Head1B=="Y"){ echo "<b>"; } ?><? if($Head1I=="Y"){ echo "<em>"; } ?><? echo $HeadName3; ?><? if($Head1I=="Y"){ echo "</em>"; } ?><? if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	  </tr>
	<tr>
	    <?
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		 while($Q = mysql_fetch_array($SQL2)){ ?>		
	    <td align="center" bgcolor="<? echo $Head2BGC; ?>"><font color="<? echo $Head2C; ?>" size="<? echo $Head2S; ?>" face="<? echo $Head2F; ?>"><? if($Head2B=="Y"){ echo "<b>"; } ?><? if($Head2I=="Y"){ echo "<em>"; } ?>
<? echo $Q[a_name]; ?>
	    <? if($Head2I=="Y"){ echo "</em>"; } ?><? if($Head2B=="Y"){ echo "</b>"; } ?></font></td>
<? } ?>	
	</tr>
	<? $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){
	?>
		  <tr>		  
	    <td align="center" bgcolor="<? echo $Question2BGC; ?>"><font color="<? echo $Question2C; ?>" size="<? echo $Question2S; ?>" face="<? echo $Question2F; ?>"><? if($Question2B=="Y"){ echo "<b>"; } ?><? if($Question2I=="Y"){ echo "<em>"; } ?>     
	      <? echo $X[q_name]; ?><? if($Question2I=="Y"){ echo "</em>"; } ?><? if($Question2B=="Y"){ echo "</b>"; } ?></font></td>
	    <td bgcolor="<? echo $Question2BGC; ?>"><font color="<? echo $Question2C; ?>" size="<? echo $Question2S; ?>" face="<? echo $Question2F; ?>"><? if($Question2B=="Y"){ echo "<b>"; } ?><? if($Question2I=="Y"){ echo "<em>"; } ?><? echo $X[q_des]; ?><? if($Question2I=="Y"){ echo "</em>"; } ?><? if($Question2B=="Y"){ echo "</b>"; } ?></font> <? if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	   <?
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		$a=0;
		 while($Q = mysql_fetch_array($SQL2)){ ?>		
	    <td align="center" bgcolor="<? echo $Answer2BGC; ?>">
		<? if($R[option1]=="A"){ ?>
	      <input type="radio" name="ans<? echo $X[q_id]; ?>" value="<? echo $Q[a_name]; ?>" >
		  <? }else{ ?>
	      <input type="checkbox" name="ans<? echo $X[q_id]; ?>_<? echo $a; ?>" value="<? echo $Q[a_name]; ?>" >
		  <? } ?>
	    </td>
<?
$a++;
 } ?>
	  </tr>
<? } ?>	  	
  </table>
	<?
	}else{
	?>
<table width="<? if($SubjectPartW!=""){ echo $SubjectPartW; }else{ echo "98%"; } ?>" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#ECEBF0" >
	  <tr bgcolor="<? echo $SubjectPartBGC; ?>">
	    <td colspan="2"><font color="<? echo $SubjectPartC; ?>" size="<? echo $SubjectPartS; ?>" face="<? echo $SubjectPartF; ?>"><? if($SubjectPartB=="Y"){ echo "<b>"; } ?><? if($SubjectPartI=="Y"){ echo "<em>"; } ?><? echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><? if($SubjectPartI=="Y"){ echo "</em>"; } ?><? if($SubjectPartB=="Y"){ echo "</b>"; } ?></font>
	    <font color="<? echo $DescPartC; ?>" size="<? echo $DescPartS; ?>" face="<? echo $DescPartF; ?>"><? if($DescPartB=="Y"){ echo "<b>"; } ?><? if($DescPartI=="Y"){ echo "<em>"; } ?><?  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><? if($DescPartI=="Y"){ echo "</em>"; } ?><? if($DescPartB=="Y"){ echo "</b>"; } ?></font></td>
    </tr>
	<? $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){
	?>		
	  <tr bgcolor="<? echo $Question1BGC; ?>">
	    <td colspan="2">	      
	      <font color="<? echo $Question1C; ?>" size="<? echo $Question1S; ?>" face="<? echo $Question1F; ?>"><? if($Question1B=="Y"){ echo "<b>"; } ?><? if($Question1I=="Y"){ echo "<em>"; } ?><? echo $X[q_name]; ?>  <? echo $X[q_des]; ?><? if($Question1I=="Y"){ echo "</em>"; } ?><? if($Question1B=="Y"){ echo "</b>"; } ?></font> <? if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?>
        </td>
    </tr>

		  <tr bgcolor="<? echo $Answer1BGC; ?>">		  
	    <td width="143">&nbsp;</td>
	    <td width="809"><div align="left"><font color="<? echo $Answer1C; ?>" size="<? echo $Answer1S; ?>" face="<? echo $Answer1F; ?>"><? if($Answer1B=="Y"){ echo "<b>"; } ?><? if($Answer1I=="Y"){ echo "<em>"; } ?>
			<?	
			$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
			if($X[q_anstype]=="D"){ 
			if($RrRows = mysql_num_rows($SSS1)){
			$Z = mysql_fetch_array($SSS1);
			if($Z[a_other]=="S"){  ?>
			<input name="ans<? echo $X[q_id]; ?>" type="text" <? if($Z[option4] != ""){ echo " size=\"$Z[option4]\" ";}  if($Z[option3] != ""){ echo " maxlength=\"$Z[option3]\" ";} ?> value="<? echo $Z[a_name] ?>">
	<?		}else{ ?>
	<textarea name="ans<? echo $X[q_id]; ?>" <? if($Z[option4] != ""){ echo " cols=\"$Z[option4]\" ";}  if($Z[option3] != ""){ echo " rows=\"$Z[option3]\" ";} ?> wrap="VIRTUAL" ><? echo $Z[a_name] ?></textarea>
<?	}			
			}else{ ?>
			<textarea name="ans<? echo $X[q_id]; ?>" cols="50" rows="3" wrap="VIRTUAL" id="ans<? echo $X[q_id]; ?>"></textarea>
	<?		}
			}elseif($X[q_anstype]=="A"){
			$p=0;
	while($Z = mysql_fetch_array($SSS1)){
	?>
		<input name="ans<? echo $X[q_id]; ?>" type="radio" value="<? echo $Z[a_name]; ?>" <? if($Z[option4] == "Y"){  echo "checked"; } ?>> 
		<? echo $Z[a_name]; ?>
		<? if($Z[a_other]=="Y"){ ?> <input name="oth<? echo $X[q_id]; ?>_<? echo $p; ?>" type="text">  
		<? } ?><br>
		
		<? $p++; }
		}elseif($X[q_anstype]=="B"){
		$p = 0;
while($Z = mysql_fetch_array($SSS1)){
	?>
		<input name="ans<? echo $X[q_id]; ?>_<? echo $p; ?>" type="checkbox" value="<? echo $Z[a_name]; ?>" <? if($Z[option4] == "Y"){  echo "checked"; } ?>> 
		<? echo $Z[a_name]; ?>
		<? if($Z[a_other]=="Y"){ ?>  <input name="oth<? echo $X[q_id]; ?>_<? echo $p; ?>" type="text">  
		<? } ?><br>
		
		<? $p++;  }		
		}elseif($X[q_anstype]=="C"){ ?>
		<select name="ans<? echo $X[q_id]; ?>" >
<? while($Z = mysql_fetch_array($SSS1)){
	?>
		 <option value="<? echo $Z[a_name]; ?>" <? if($Z[option4] == "Y"){  echo "selected"; } ?>><? echo $Z[a_name]; ?></option>
		
		<? } ?>
		</select>
		<?		
		}
		?>
		<? if($Answer1I=="Y"){ echo "</em>"; } ?><? if($Answer1B=="Y"){ echo "</b>"; } ?></font></div></td>

	  </tr>
<? } ?>	  	
  </table>	
	<? } ?>
  <? } ?><br>

  <table width="<? if($SubjectPartW!=""){ echo $SubjectPartW; }else{ echo "98%"; } ?>" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td >      <div align="right">
        <input name="s_id" type="hidden" id="s_id" value="<? echo $s_id; ?>">
		<input name="mid" type="hidden" id="mid" value="<? echo $mid; ?>">
        <input type="submit" name="Submit" value="Submit">
        <input type="reset" name="Submit2" value="Reset">
      </div></td></tr>
</table>

</form>
<script language="javascript">
function GoNext(){
<?
$SSSS = $db->query("SELECT * FROM p_question,p_cate WHERE p_cate.s_id='$s_id' AND p_cate.c_id = p_question.c_id AND (p_question.q_req = 'Y' OR p_question.q_req = 'E') ");
if($gg = mysql_num_rows($SSSS)){
while($TT = mysql_fetch_array($SSSS)){
if($TT[q_anstype]=="D"){
if($TT[q_req] == "Y"){
?>
if(document.Surveyform.elements["ans"+<? echo $TT[q_id]; ?>].value =="" ){
		alert("กรุณาตอบคำถามข้อที่ <? echo $TT[q_name]; ?> ในส่วนที่ <? echo $TT[c_d]; ?> ด้วยครับ");
		document.Surveyform.elements["ans"+<? echo $TT[q_id]; ?>].focus();
		return false;
}
<?
}elseif($TT[q_req] == "E"){
?>
 	if(document.Surveyform.elements["ans"+<? echo $TT[q_id]; ?>].value == ""){
		alert('กรุณาระบุอีเมล์ของท่าน');
		document.Surveyform.elements["ans"+<? echo $TT[q_id]; ?>].focus();
		return false;
	}else if((document.Surveyform.elements["ans"+<? echo $TT[q_id]; ?>].value.search("^.+@.+\\..+$") == -1)){
		alert('รูปแบบของอีเมล์ไม่ถูกต้อง');
		document.Surveyform.elements["ans"+<? echo $TT[q_id]; ?>].select();
		return false;
	}
<?
}
}elseif(($TT[q_anstype]=="A")or($TT[q_anstype]=="")){
echo "
var x = 0;
for (var i=0; i<document.Surveyform.ans".$TT[q_id].".length; i++) {
         if (document.Surveyform.ans".$TT[q_id]."[i].checked) {
            var x = 1;
         }
      }
	if(x==0){
	alert(\"กรุณาตอบคำถามข้อที่ ".$TT[q_name]." ในส่วนที่ ".$TT[c_d]." ด้วยครับ\");
	document.Surveyform.ans".$TT[q_id]."[0].focus();
	return false;
	}  
	  ";
}
}}else{  echo "return true;";  }
?>
}
	</script>

<?php
	}
}
function GenCalendar(){
?>
<table width="174" height="180" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td align="center" valign="top"><iframe name="calendar" src="calendar.php"  frameborder="0"  width="100%" height="100%" scrolling="no" ></iframe></td>
  </tr>
</table>
<?php
}
function GenWebboard($text_id){
global $db;
global $filename;
$e = explode("_",$text_id);
$c = count($e);
$txt = " AND ( 0 ";
	for($i=0;$i<$c;$i++){
		if($e[$i] != ""){
			$txt .= " OR c_id = '".$e[$i]."' ";
		}
	}
	$txt .= " ) ";
	$sql = "SELECT * FROM w_cate WHERE c_use = 'Y' ".$txt;
	$Execsql = $db->query($sql);
	if($db->db_num_rows($Execsql) > 0){
	
		?>
<br />
<table cellspacing="0" cellpadding="0" width="95%" border="0" align="center">
   <tbody>   
   <tr>
       <td>&nbsp;</td>
       <td align="right" ><table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
				<form name="formSearchWEBB" method="post" action="search_webboard.php?filename=<?php echo $filename; ?>">
  <tr>
    <td align="right">
                        <input type="text" name="keyword" class="styleMe">
              <input type="submit" name="search" value="ค้นหา webboard" class="styleMe">
      </td>
  </tr></form>
</table></td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td width="12" height="35" valign="top"><img src="mainpic/c_03.jpg" width="15" height="38"></td>
       <td background="mainpic/calendar_poll_05.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td align="center"><font face="tahoma" size="2">หมวดของกระทู้</font></td>
           <td width="10%" align="center"><font face="tahoma" size="2">จำนวนกระทู้</font></td>
           <td width="10%" align="center"><font face="tahoma" size="2">จำนวนผู้ตอบ</font></td>
         </tr>
       </table></td>
       <td width="9" valign="top"><img src="mainpic/c_05.jpg" width="14" height="38"></td>
    </tr>
     <tr>
       <td background="mainpic/c_07.jpg"><span style="FONT-SIZE: 10pt; FONT-FAMILY: Tahoma"> </span></td>
       <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="normal_font">
<?php
   while($R = mysql_fetch_array($Execsql)){
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
      <td width="4%" align="center" valign="top" bgcolor="#FFFFFF"><br ><? if($R[c_view] == "Y"){ ?><img src="mainpic/lock.gif" width="24" height="24"><? }else{ ?><img src="mainpic/book_blue.gif" width="24" height="24"><? } ?></td>
      
    <td width="78%" valign="top" >
      <div align="left" class="head_font">
	  <a href="index_question.php?wcad=<? echo $R[c_id]; ?>" target="_blank"><font  face="tahoma" size="2" color="#A80000"><strong>
	  <?php  echo stripslashes($R[c_name]); ?></strong></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $link;?></div>
      <a href="index_question.php?wcad=<? echo $R[c_id]; ?>" target="_blank"><font  face="tahoma" size="2" color="#000000"><?php  echo stripslashes($R[c_detail]); ?></font>      </a></td>
      <td align="center"><font  face="tahoma" size="2" color="#000000"><? echo $countrow; ?></font></td>
      <td align="center"><font  face="tahoma" size="2" color="#000000"><? echo $countrow1; ?></font></td>
    </tr>
    <? }?>
</table></td>
       <td background="mainpic/c_09.jpg"><span style="FONT-SIZE: 8pt"> </span></td>
    </tr>
     <tr>
       <td><img src="mainpic/c_12.jpg" width="15" height="16"></td>
       <td background="mainpic/c_13.jpg"></td>
       <td><img src="mainpic/c_14.jpg" width="14" height="16"></td>
    </tr>
  
  </tbody>
</table>
		<?php
	}
}
function GenSearch(){
	global $filename;
?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">
  <form name="search" method="post" action="search_result.php">
    <tr> 
      <td align="center"><input name="keyword" type="text" id="keyword"  size="20" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;"><input name="filename" type="hidden" id="filename" value="<?php echo $filename; ?>"><input name="oper" type="hidden" id="oper" value="OR"></td>
    </tr>
    <tr> 
      <td align="center"><input type="submit" name="Submit" value=" ค้นหา... " style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;"><input type="button" name="Button" value="ค้นหาขั้นสูง" onClick="window.location.href='search_advance.php?filename=<?php echo $filename; ?>';"  style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;"></td>
    </tr>
  </form>
</table>
<?php
}
function GenBanner(){
	global $db;
?>
<table width="100%" border="0" cellpadding="1" cellspacing="0" >
	<?php
    $query_set = $db->query("SELECT * FROM banner_setting ");
    $rs_set = $db->db_fetch_array($query_set);
    if($rs_set[banner_type]=='R'){
      $sql_banner = "SELECT * FROM banner  ORDER BY RAND() LIMIT ".$rs_set[banner_rand_row];
   }else{
     $sql_banner = "SELECT * FROM banner WHERE banner_show = 'yes' ORDER BY banner_position";
   }
		$query_banner = $db->query($sql_banner);
		$num_banner = $db->db_num_rows($query_banner);
		if($num_banner > 0){
             $k=1;
			for($i=0;$i<$num_banner;$i++){
				$rs_banner = $db->db_fetch_array($query_banner);
				if(eregi("www", $rs_banner[banner_link]) AND !eregi("http://", $rs_banner[banner_link])){
					$link = "http://".$rs_banner[banner_link];
				}else{
					 $link = $rs_banner[banner_link];	
				}
			   if($rs_set[banner_view]=='V'){
				?>
				  <tr>
					<td align="center" bgcolor="#FFFFFF" width="<?=(100/$num_banner)?>%"><a href="<?=$link?>"  target="_blank" onClick="var url = 'banner_ajax_log.php?banner_id=<?=$rs_banner[banner_id]?>';load_divForm(url,'','');"><img src="<?=$rs_banner[banner_pic]?>" border="0" width="97%" height="38"></a></td>
				  </tr>
				<?php
			}else{
                	if($k%$rs_set[banner_rand_max]==1){ ?><tr><? } 
                       ?><td align="center" bgcolor="#FFFFFF" width="<?=(100/$num_banner)?>%"><a href="<?=$link?>"  target="_blank" onClick="var url = 'banner_ajax_log.php?banner_id=<?=$rs_banner[banner_id]?>';load_divForm(url,'','');"><img src="<?=$rs_banner[banner_pic]?>" border="0" width="97%" height="38"></a></td><?
				    if($k%$rs_set[banner_rand_max]==0){ ?></tr><? }
				    $k++;
			}
		}//end for	
	}//end if
	?>

</table>
<?
}

 function chg_date_th ($date_input)
{
	   $date = substr($date_input,8,2);
	   $mont= substr($date_input,5,2);
	   $year_en = substr($date_input,0,4);
	   $year=$year_en+543;

	   return $date."/".$mont."/".$year;
}

	function GenGuestbook(){
	global $db;
	global $offset;
	$path_cal = "../";

	//#####################replace *** to word  #########################
$sql_vul = " SELECT * FROM vulgar_table ";
$query_vul = mysql_query($sql_vul);
$num_vul  = mysql_num_rows($query_vul);
for($i=1;$i<=$num_vul;$i++){
		$rec = mysql_fetch_array($query_vul);
		$vulels[$i] = $rec['vulgar_text'];		
}
//##############################################################
$chk_config = mysql_query("SELECT * FROM guest_config ");
$CO = mysql_fetch_array($chk_config);


//#########################    Chack Date < guest_config_date ########
$d = date(d) - $CO['guest_config_date'];
$m = date(m);
$y = date(Y);
$today = $y."-".$m."-".date(d);
$chk_date=  date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));
//###############################################################


$sel = "SELECT * FROM guestbook_list  WHERE date_guest BETWEEN '$chk_date' AND ' $today' AND status_guest = 'Y' ORDER BY id_guest DESC";

   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = $CO[guest_config_page];

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = mysql_query($sel) or die(mysql_error());
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
			
}else if($check_data == 'yes'){ //method การยืนยัน		
			$name_guest = stripslashes(htmlspecialchars($name_guest ,ENT_QUOTES));
			$comment_guest = stripslashes(htmlspecialchars($comment_guest ,ENT_QUOTES));
			$name_guest1= $name_guest;
			$comment_guest1 = $comment_guest;
			$sql_vul = " SELECT * FROM vulgar_table ";
			$query_vul = mysql_query($sql_vul);
			$num_vul  = mysql_num_rows($query_vul);
			for($chk=1;$chk<=$num_vul;$chk++){
					$rec = mysql_fetch_array($query_vul);
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
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
-->
</style>
<script language="javascript1.2" type="text/javascript">
function chk_input(){
		if(document.frm1.name_guest.value == ''){
				alert('กรุณากรอกชื่อ');
				return false;
		}
		if(document.frm1.comment_guest.value == ''){
				alert('กรุณากรอกข้อความแสดงความเห็นอ');
				return false;
		}else{
				document.frm1.action='<?=$yes_chk?>';
		}
}
</script>
<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="0"><form name="frm1" action="" method="post">
          <tr> 
            <td colspan="2" valign="top">
			<? if($check_data != 'yes'){//เมื่อกรอกข้อความคิดเห็นหน้ายืนยันข้อความไม่ต้องแสดงความเห็นทั้งหมด?>
			<DIV id="guest_book" align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%">                 
				<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B74900" class="styleMe">
								  <tr align="center" bgcolor="#FFCC66"> 
										<td width="72%" height="30"><strong>รายการสมุดเยี่ยมชม</strong></td>
								  </tr>
					<?
							
						  if($rows > 0){
								   while($rec = mysql_fetch_array($Execsql)){ 
											$count = $db->query("SELECT * FROM guestbook_list WHERE id_guest = '$rec[id_guest]' ");
											$countrow = mysql_num_rows($count);
											$date_print = chg_date_th($rec['date_guest']);
				?>
								  <tr bgcolor="#FFFFFF" > 
										<td align="center" height="30" >
												<table  width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF"
													onMouseOver="document.getElementById('tr_chg<?=$count?>').style.backgroundColor='#FFCC66'" 
													onMouseOut="document.getElementById('tr_chg<?=$count?>').style.backgroundColor='#CCCCCC'" class="styleMe"
												>
														<tr height="30" bgcolor="#FFFFFF">
																<td >
																		<?=str_replace($vulels, "***",$rec['detail_guest']);?>
																</td>
														</tr>
														<tr height="20" id="tr_chg<?=$count?>" bgcolor="#CCCCCC" >
																<td width="95%"><font color="#005CA2"><strong>
																	<?  print "&nbsp;&nbsp;ชื่อ&nbsp;&nbsp;:&nbsp;&nbsp;";
																			print str_replace($vulels, "***",$rec['name_guest'])."&nbsp;&nbsp;";
																			print $date_print;
																	?>
																</strong></font></td>
														</tr>
										  </table>
										</td>
			      </tr>
	
					<?						
									}
							 }else{ 
					?>
								  <tr bgcolor="#FFFFFF"> 
										<td height="30" align="center"><font color="#FF0000"><strong>ไม่มีข้อความเยี่ยมชม</strong></font></td>
								  </tr>
					  <? } 
				    if($rows > 0){ ?>
						<tr bgcolor="#FFFFFF">
								<td height="25" colspan="2" valign="top"><strong>หน้าที่ :</strong><?php
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?filename=index&offset=$prevoffset'>
								<font  color=\"red\"><< ก่อนหน้า</font></a>\n\n";
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
											echo  "<a href='$PHP_SELF?filename=index&offset=$newoffset'". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href='$PHP_SELF?filename=index&offset=$newoffset'>
										<font color=\"red\">ถัดไป>></font></a>"; 
								}
								?></td>
						</tr>
					<? } ?>
                </table></DIV>
                <br>
            
			
			<?
			}
			?>
			</td>
          </tr>  <tr> 
    <td  align='middle' vAlign='top'   bgcolor="#FFFFFF" width="100%" > 
			<table  width="80%" border="0" align="center" cellpadding="1" cellspacing="1"  bgcolor="#666666">
					<tr  bgcolor="#FFFFFF">
							<td bgcolor="#FFCC66" colspan="2" class="styleMe">
									::  สมุดเยี่ยมชม ::							
							</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
							<td align="right" valign="top" width="35%" class="styleMe">
									ชื่อ&nbsp; : &nbsp;&nbsp;
							</td>
							<td align="left" valign="top" width="65%" class="styleMe">
									<? if($check_data == 'yes')  print $name_guest_print; ?>
									<input name="name_guest" type="<?=$indata?>"  value="<?=$name_guest?>">	&nbsp;
							</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
							<td align="right" valign="top" class="styleMe">
								ความคิดเห็น&nbsp; : &nbsp;&nbsp;
							</td>
							<td align="left" valign="top" width="65%" class="styleMe">
								<? if($check_data != 'yes') {?>
											<textarea name="comment_guest" cols="30" rows="5" 
													style="scrollbar-base-color:#FFCC66;" wrap="VIRTUAL" class="normaltxt" id="t_detail"><?=$comment_guest?></textarea> 
								<? }else{ ?>
											<?=$comment_guest_print?>
											<input name="comment_guest" type="hidden"  value="<?=$comment_guest?>">	&nbsp;
								<? } ?>
							</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
							<td align="center" valign="top" colspan="2">	
									<input name="submit" type="submit" value="&nbsp;&nbsp;<? if($check_data == 'yes'){echo "ยืนยัน";}else{echo "ตกลง";}?>&nbsp;&nbsp;" onClick="<? if($chk_vulgar == 'Y'){echo "alert('กดยกเลิกเพื่อกลับไปแก้ไขข้อความไม่สุภาพ');return false;";}else{ echo 'chk_input()';}?>">&nbsp;&nbsp;
									<input name="cancle" type="submit" value="&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;" onClick="<?=$no_chk?>">
							</td>
				</tr>
	  </table>
    </td>
  </tr></form>
</table>
<?php
	}//end GenGuestbook
	
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
				echo "<img src=\"mainpic/arrow_r.gif\" border=\"0\" align=\"absmiddle\">";
				break;
		case '1':
				for($i=1;$i<count($s);$i++){
					?><img width="25" src="mainpic/o.gif" border="0" align="absmiddle" ><?
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
		return $pass;
}


function GenSitemap(){
    global $db;
    $sql="select * from menu_setting";
    $query = $db->query($sql);
    $data1 = $db->db_fetch_array($query);
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
								?><tr><td width="<?php echo $column_width?>%" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0" class="styleMe"><?php
				}else{
								?><td  valign="top" width="<?php echo $column_width?>%"><table width="100%"  border="0" cellpadding="2" cellspacing="0" class="styleMe"><?php
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
					?><img  width="25" src="mainpic/minus.gif" border="0" align="absmiddle" onClick="divshow(document.all.div<?php echo $j; ?>,this)">&nbsp;<?
				}else{
					?><img width="25" src="mainpic/o.gif" border="0" align="absmiddle">&nbsp;<?
				}
				?><strong><nobr><a href="<?php echo $R["Glink"]?>" target="<?php $R["Gtarget"]?>"><? echo $nameMS;?></a></nobr></strong><br><?
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
<? }// end if
}




 function GenFaq(){
global $db;
global $filename;
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
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
				<?php
				$Execsql = $db->query("SELECT * FROM f_cat where f_use='Y'  ORDER BY f_no ASC");
$row = $db->db_num_rows($Execsql);
				?>
				<form name="formSearchFAQ" method="post" action="faq_search.php">
  <tr>
    <td align="right"><input name="filename" type="hidden" id="filename" value="<?php echo $filename; ?>"> 
                        <input type="text" name="keyword" class="styleMe">
              <input type="submit" name="search" value="ค้นหา FAQ" class="styleMe">
      </td>
  </tr></form>
</table>

               <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td width="12" height="35"></td>
                      <td><table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#6A2B00" class="normal_font">
                  <tr align="center" bgcolor="#FFDFCA"> 
                    <td height="30" class="head_font"><strong>หมวดของ FAQ </strong></td>
                    <td width="12%"><strong>จำนวน FAQ ในหมวด</strong></td>
                  </tr>
                  <?php
  if($row > 0){
   while($R = mysql_fetch_array($Execsql)){ 
	$f_id = $R[f_id];
   $count = $db->query("SELECT * FROM faq WHERE f_id = '$f_id'   and faq_use='Y' ");
   $countrow = mysql_num_rows($count);
	
   ?>
                  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#FFF3E8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
                    <td width="67%" valign="top" > 
                      <div align="left" class="head_font"><font color="000099"> <b>
                        &diams; <?=($R[f_cate]); ?></b>
                        </font></div>
   <?=($R[f_detail]); ?>
                    </td>
                    <td align="center">&nbsp;</td>
                  </tr>
                <?   $sql_subcat="select * from f_subcat where f_id='$R[f_id]'  and f_use='Y'  ORDER BY f_sub_no ASC "  ;
					$query_subcat=$db->query($sql_subcat);
					while($R_SUB=$db->db_fetch_array($query_subcat)){
 ?>
				  <tr bgcolor="#FFFFFF"   style="cursor:'hand'" onMouseOver="this.style.backgroundColor='#FFF3E8'" onMouseOut="this.style.backgroundColor='#FFFFFF'">
					<td height="42" onClick="window.location.href='faq_list.php?f_id=<? echo $f_id; ?>&f_sub_id=<? echo $R_SUB[f_sub_id]; ?>&filename=<? echo $filename; ?>'">														  
			 
			<div align="left" class="head_font"><font color="000099"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &rArr;  <?=($R_SUB[f_subcate]); ?></b></font></div>
			          
			     <?=($R_SUB[f_subdetail]); ?></td>

 <?  
$count2 = $db->query("SELECT * FROM faq WHERE f_sub_id = '$R_SUB[f_sub_id]'  and faq.faq_use='Y'  ");
   $countrow2 = mysql_num_rows($count2);?>
		            <td height="42" align="center"><? echo $countrow2; ?></td>
				  </tr>  

<? } }}else{ ?>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="30" colspan="2"><div align="center"><font color="#FF0000"><strong>ไม่มีหมวดของ 
                        FAQ </strong></font></div></td>
                  </tr>
                  <? } ?>
                </table></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td></td>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody>
    </table>
<?php
 }
 function GenGallery($category_id){
 global $db;
 global $filename;
 
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
 <form name="gallery<?php echo $category_id; ?>" action="" method="post">
<?php
	$sql_category = "SELECT * FROM gallery_category WHERE category_id = '".$category_id."' ";
	$query_category = $db->query($sql_category);
	$rs_category = $db->db_fetch_array($query_category);
	$limit = $rs_category[col]*$rs_category[row];
	
	if($_POST[page]) $page = $_POST[page];
	else $page = $_GET[page];
	if(!$limit) $limit = 5;
	if($page == '' || $page < 1)$page =1;
	$page1=$page-1;
	if($page1 == '' || $page1 < 0)$page1 =0;
	
	$sql_img = "SELECT * FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_cat_img.category_id = '".$category_id."' ORDER BY cat_img_id";
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

?>
<table width="90%"  border="0" cellpadding="0" cellspacing="1" align="center" class="styleMe">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="styleMe">
      <tr>
        <td height="6" width="7"><img src="<?=$path;?>mainpic/head_left.gif" width="7" height="6"></td>
        <td bgcolor="#5599CC"></td>
        <td height="6" width="7"><img src="<?=$path;?>mainpic/head_right.gif" width="7" height="6"></td>
      </tr>
      <tr>
        <td height="30" width="7" bgcolor="#5599CC"></td>
        <td valign="middle" bgcolor="#5599CC" height="30"><div align="center"><strong style="color:#FFFFFF">หมวด <?=$rs_category[category_name]?></strong></div></td>
        <td height="30" width="7" bgcolor="#5599CC"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#006699">
      <tr>
        <td bgcolor="#FFFFFF"  style="color:#FFFFFF"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
                  <th scope="col">&nbsp;</th>
            </tr>
        </table>
          <table border="0" cellpadding="5" cellspacing="1" align="center">
            <tr>
<?php @$percent=100/$num_rows_2*$rs_category[col];?>
              <td ><div align="center">
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="styleMe">
                  <?php 
                     
					if($num_rows_2 > 0){
						for($i=1;$i<=$num_rows_2;$i++){
							$rs_img = $db->db_fetch_array($query);
							if($i%$rs_category[col] == 0 && $i==1) {
							?>
                  <tr align=\"center\">
                    <?php }?>
                    <td width="<?php echo $percent?>%" align=\"center\" valign="top">
                      <table border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" style="cursor:hand" onMouseOver="document.getElementById('name_<?=$rs_img[img_id]?>').style.color = '#FF0000'; " onMouseOut="document.getElementById('name_<?=$rs_img[img_id]?>').style.color = '#000000'; " onClick="location.href='gallery_view_img_comment.php?category_id=<?=$category_id?>&filename=<?php echo $filename; ?>&img_id=<?=$rs_img[img_id]?>&page_cat=<?=$page?>';">
                        <tr>
                          <td bgcolor="#FFFFFF"  align="center"><table border="0" cellpadding="1" cellspacing="1" bgcolor="#999999" align="center">
                            <tr>
                              <th bgcolor="#FFFFFF" scope="col" align="center"><img src="<?php echo $rs_img[img_path_s]?>" height="100" width="100"></th>
								    </tr>
                            </table></td>
					          </tr>
                        <tr>
                          <td bgcolor="#FFFFFF"  align="center"><span id="name_<?=$rs_img[img_id]?>"  class="styleMe"><?=$rs_img[img_name]?></span></td>
						      </tr>
                        </table>						  </td>
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
                  <tr><td align="center" style="color:#FF0000"><strong>ไม่มีรูปภาพ</strong></td></tr>
                  <? }?>
                  </table>
              </div></td>
            </tr>
            </table>          <br></td>
      </tr>
      
    </table>
      <table width="100%" border="0" align="left">
        <tr>
          <th scope="col"  class="styleMe"><div align="right">หน้าที่
              <select name="page" onChange="document.gallery<?php echo $category_id; ?>.submit();"  class="styleMe">
                <?php
							for($i=1;$i<=$page_all;$i++){
								if($i == $page) $selected = "selected";
								else $selected = "";
								print "<option value=\"$i\" $selected>$i</option>";
							}
						?>
              </select>
/
<?=$page_all?>
หน้า</div></th>
        </tr>
      </table></td>
  </tr>
</table>
</form>
 <?php
 }
function GenComplain(){
global $db;

?>
 <style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:11px;
}
-->
</style>
<table width="97%" border="0" align=center cellpadding="3" cellspacing="1" bordercolor="#0000CC" bgcolor="C4B74E" style="border-collapse: collapse" class="styleMe">
            <form name="Complainform" method="post" action="m_complain_sendmail.php"  enctype="multipart/form-data">
              <tr bgcolor="#FFF2BF"> 
                <td height="25" colspan="2" ><b>ร้องทุกข์ 
                  / ร้องเรียน</b></td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="#FCF8D0" width="50%">เรื่อง:</td>
                <td bgcolor="#FCF8D0"><div align="left"> <font size="2" face="Tahoma"> 
                    <input name="topic" type="text" id="topic" class="styleMe" size="15">
                    </font></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="#FCF8D0">ชื่อผู้ร้องทุกข์ 
                  / ร้องเรียน :</span></font></td>
                <td bgcolor="#FCF8D0"><div align="left"><input name="name" type="text" id="name" class="styleMe" size="15"></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="#FCF8D0">E-mail 
                  address :</td>
                <td bgcolor="#FCF8D0"> <input name="email" type="text" id="email" class="styleMe" size="15">
</td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="#FCF8D0">เบอร์โทรศัพท์:</td>
                <td bgcolor="#FCF8D0">
                    <input name="tel" type="text" id="tel"  class="styleMe" size="15">
                </td>
              </tr>
              <tr> 
                <td align="right" valign="top" bgcolor="#FCF8D0">รายละเอียดเรื่องร้องทุกข์/ 
                  ร้องเรียน :</td>
                <td bgcolor="#FCF8D0">
                    <textarea name="detail" cols="15" rows="5" wrap="physical" id="detail" class="styleMe"></textarea></td>
              </tr>
			    <tr> 
                <td align="right" valign="top" bgcolor="#FCF8D0">เอกสารประกอบการร้องทุกข์/ร้องเรียน :</td>
                <td bgcolor="#FCF8D0">
                   <input type="file" name="file" class="styleMe" size="5"></td>
              </tr>
			  <tr> 
                <td align="right" valign="top" bgcolor="#FCF8D0">หน่วยงานที่รับเรื่อง:</td>
                <td bgcolor="#FCF8D0">
<div align="left">
<?
$ss = mysql_query("Select * From m_complain_info ");
?>
                    <select name="select" class="styleMe">
					<?
					while($XX = mysql_fetch_row($ss)){
					?>
                      <option value="<? echo $XX[0]; ?>"><? echo $XX[1]; ?></option>
<? } ?>
                    </select>
                  </div></td>
              </tr>
              <tr> 
                <td colspan="2" valign="top" bgcolor="#FCF8D0"><div align="center"> 
                    <input type="submit" name="Submit" value="บันทึก" class="styleMe">
                    &nbsp; 
                    <input type="reset" name="Submit2" value="ยกเลิก" class="styleMe">
                    <input type="hidden" name="flag" value="1" class="styleMe"></div></td>
              </tr>
            </form>
    </table>
<?php

}


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

function GenLogin(){
global $db;
global $EWT_DB_NAME;

if($_SESSION["EWT_MID"] == ""){

	if(!session_is_registered("gen_pic_login")){
	session_register("gen_pic_login");
	}
	$_SESSION["gen_pic_login"] = random_code(3);
	?>
	<style type="text/css">
	<!--
	BODY {
		FONT-SIZE: 11px; MARGIN: 0px; COLOR: #000000; FONT-FAMILY: "Tahoma"
	}
	.copyright {
		COLOR: #e1e1e1
	}
	A:link {
		COLOR: #000000; TEXT-DECORATION: none
	}
	A:visited {
		COLOR: #000000; TEXT-DECORATION: none
	}
	A:active {
		COLOR: #000000; TEXT-DECORATION: none
	}
	A:hover {
		COLOR: #000000; TEXT-DECORATION: none
	}
	.mytext_normal {
		FONT: 11px "Tahoma"
	}
	.myhead {
		FONT: 23px "Tahoma"
	}
	INPUT {
		FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: "Tahoma"
	}
	TEXTAREA {
		FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: "Tahoma"
	}
	TABLE {
		FONT: 11px "Tahoma"
	}
	SELECT {
		FONT: 11px "Tahoma"
	}
	-->
	</style>
	<table cellspacing="0" cellpadding="0" width="100%" border="0">
  <form name="form_loginm" method="post" action="ewt_login.php" onSubmit="return chk();">
     <tbody>
       <tr>
         <td width="12" background="mainpic/krom1_03.jpg" height="35"></td>
         <td background="mainpic/krom1_05.jpg">
           <table cellspacing="0" cellpadding="0" width="100%" border="0">
             <tbody>
               <tr>
                 <td width="30" background="mainpic/krom4_04.jpg" height="35"></td>
                 <td valign="bottom"><span style="FONT-SIZE: 8pt; COLOR: #8b4513; FONT-FAMILY: Tahoma"><strong>เข้าสู่ระบบสมาชิก</strong></span></td>
              </tr>
            </tbody>
          </table></td>
         <td width="9" background="mainpic/krom1_06.jpg"></td>
      </tr>
       <tr>
         <td background="mainpic/krom1_07.jpg"><span style="FONT-SIZE: 10pt; FONT-FAMILY: Tahoma"> </span></td>
         <td bgcolor="#FFFFFF">
           <table cellspacing="2" cellpadding="2" width="100%" border="0">
             <tbody>
               <tr>
                 <td width="34%" align="right">
                  <label><span class="style1" style="FONT-SIZE: 8pt; FONT-FAMILY: Tahoma">ชื่อผู้ใช้  :</span></label></td>
                 <td>
                  <label><span style="FONT-SIZE: 10pt; FONT-FAMILY: Tahoma">
                      <input name="ewt_user1" type="text" id="ewt_user1" size="10"></span></label></td>
              </tr>
               <tr>
                 <td align="right"><span class="style1" style="FONT-SIZE: 8pt; FONT-FAMILY: Tahoma">รหัสผ่าน : </span> </td>
                 <td>
                  <label>
                    <input name="ewt_pass1" type="password" id="ewt_pass1" size="10"><span style="FONT-SIZE: 8pt; FONT-FAMILY: Tahoma"></span></label></td>
              </tr>
               <tr>
                 <td align="right"><img src="ewt_pic.php" align="absmiddle"></td>
                 <td align="left"><input name="chkpic1" type="text" id="chkpic1" size="3" maxlength="3" />&nbsp;&nbsp;<input type="button" name="Submit3" value="New" onclick="self.location.reload();" /></td>
               </tr>
               <tr>
                 <td colspan="2" align="center"><span style="FONT-SIZE: 8pt; FONT-FAMILY: Tahoma">
                   <input class="cadweb2007"  type="submit" name="Submit4" value="เข้าสู่ระบบ" />
                 </span></td>
               </tr>
               <tr>
                 <td colspan="2" align="center" ><span style="FONT-SIZE: 8pt; FONT-FAMILY: Tahoma">
				 <a href="##" onclick="location.href = 'frm_gen_user.php';">สมัครสมาชิก</a>|
				 <a href="##" onClick="window.open('member_forgot.php','','width=350,height=120');">Forgot password</a>
					<input name="Flag" type="hidden" id="Flag" value="AcceptLogin">
					<input name="fn" type="hidden" id="Flag2" value="<?=($_GET[fn])?$_GET[fn]:$_POST[fn]?>">
                 <input id="Flag" type="hidden" value="AcceptLogin" name="Flag" /></span></td>
               </tr>
            </tbody>
         </table></td>
         <td background="mainpic/krom1_09.jpg"><span style="FONT-SIZE: 8pt"> </span></td>
      </tr>
       <tr>
         <td><span style="FONT-SIZE: 8pt">
            <img height="17" src="mainpic/krom1_10.jpg" width="12" /></span></td>
         <td background="mainpic/krom1_11.jpg"><span style="FONT-SIZE: 8pt"> </span></td>
         <td><span style="FONT-SIZE: 8pt">
            <img height="17" src="mainpic/krom1_12.jpg" width="9" /></span></td>
      </tr>
    </tbody>
  </form>
</table>
<script language="JavaScript">
function chk(){
	if(document.form_loginm.ewt_user1.value == ""){
			alert("Please input username");
			document.form_loginm.ewt_user1.focus();
			return false;
	}
		if(document.form_loginm.ewt_pass1.value == ""){
			alert("Please input password");
			document.form_loginm.ewt_pass1.focus();
			return false;
	}
		if(document.form_loginm.chkpic1.value == ""){
			alert("Please input picture text");
			document.form_loginm.chkpic1.focus();
			return false;
	}
}
</script>
<?php
}
	
 }
 function GenLink(){
 global $db;
 global $filename;
 $sql = $db->query("SELECT * FROM link_group ORDER BY glink_id ASC");
 $rows = $db->db_num_rows($sql);
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
 <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#333333" class="styleMe" id="table_data">
  <tr bgcolor="#F8F8F8"> 
    <td height="30" align="center"><strong>กลุ่มของเว็บไซต์</strong></td>
  </tr>
  <?
						  $x = $offset;
						  if($rows > 0){
								   while($rec = mysql_fetch_array($sql)){ 
$sql_count = $db->query("SELECT COUNT(link_id) FROM link_list WHERE glink_id = '$rec[glink_id]' ");
$C = $db->db_fetch_row($sql_count);
					?>
  <tr bgcolor="#FCF8D0" onMouseOver="this.style.backgroundColor='#F5E0CD'" onMouseOut="this.style.backgroundColor='#FCF8D0'"> 
    <td height="30"><li><a href="ewt_link.php?glink_id=<?=$rec['glink_id'] ?>&filename=<?php echo $filename; ?>"><b> 
        <?=$rec[glink_name]?>
        </b> (<? echo $C[0]; ?>)</a></li>
      <br> 
      <?=$rec[glink_des]?>
    </td>
  </tr>
  <?						
									}
							 }else{ 
					?>
  <tr bgcolor="#FFFFFF"> 
    <td height="30"  align="center"><font color="#FF0000"><strong>ไม่มีกลุ่มของเว็บไซต์ 
      </strong></font></td>
  </tr>
  <? } 
				 ?>
</table>
 <?php
 }
function GenPic2($data){
$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		echo "<img src=\"mainpic/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}

?>