<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//===========================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	//===========================================================
	
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

if($_GET["filename"] != ""){
	$sql_index = $db->query("SELECT template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
	$XX = $db->db_fetch_array($sql_index);
	$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '$XX[0]'  ");
}else{
	$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
}
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
if($_GET["filename"] == ''){
$_GET["filename"] = 'index';
}
$lang_sh1 = explode('___',$_GET["filename"]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
//$page = 'news';
include("ewt_function.php");
if($use_template != ""){
$d_idtemp =$use_template;
}	

$global_theme = $R["d_bottom_content"];
$mainwidth = "0";
	
	 $temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);
$design_id = $R["d_id"];

	?>
<html>
<head>
<title>TOR</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
include("ewt_script.php");	
?>
<script language="javascript" type="text/javascript">
function CHK(obj){
	if(obj.tddetail.value == ''){
		alert("กรุณากรอกคำถาม!!");
		return false;
	}
	if(obj.tdname.value == ''){
		alert("กรุณากรอกชื่อผู้ถาม!!");
		return false;
	}
}
</script>
</head>
<body  leftmargin="0" topmargin="0" <?php if($R["d_site_bg_c"] != ""){ echo "bgcolor=\"".$R["d_site_bg_c"]."\""; } ?> <?php if($R["d_site_bg_p"] != ""){ echo "background=\"".$R["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $R["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $R["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $R["d_top_height"]; ?>" bgcolor="<?php echo $R["d_top_bg_c"]; ?>" background="<?php echo $R["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $R["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $R["d_site_left"]; ?>" bgcolor="<?php echo $R["d_left_bg_c"]; ?>" background="<?php echo $R["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $R["d_site_content"]; ?>" bgcolor="<?php echo $R["d_body_bg_c"]; ?>" height="160" background="<?php echo $R["d_body_bg_p"]; ?>">
	<?php
			$mainwidth = $R["d_site_content"];
			?>
      <!--body-->
	  <?php
	  $db->query("USE db_moc_tor");
	
	  
	$sql_query = "select * from tor_main where tg_id = '".$_GET["tid"]."' order by tg_id DESC";
	 $sql = $sql_query;
	  $query = $db->query($sql);
	  $F = $db->db_fetch_array($query);
	  ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
    <td  class="text_normal"> 
           <TABLE width=120 border=0 align="right" cellPadding=6 cellSpacing=1 bgColor=#dddddd>
<TBODY>
<TR>
<TD style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #555555; FONT-FAMILY: Tahoma; TEXT-DECORATION: none" align=middle bgColor=#ffffff>FONTSIZE <A onClick="changeStyle('small');" href="#size"><IMG height=10 src="mainpic/s.gif" width=10 border=0></A> <A onClick="changeStyle('normal');" href="#size"><IMG height=10 src="mainpic/n.gif" width=10 border=0></A> <A onClick="changeStyle('big');" href="#size"><IMG height=10 src="mainpic/b.gif" width=10 border=0></A> </TD></TR></TBODY></TABLE></td>
  </tr>
  <tr>
    <td  class="text_head"> 
            <span style="FONT: 17px 'Tahoma';">ร่างประกาศ TOR </span> <div><hr size="1"></div>                     </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" class="text_normal">
              <tr> 
                <td width="5" valign="top">&nbsp;                  </td>
                <td valign="top"  class="text_normal">
				<ul>
				<li><strong>ชื่อเรื่อง</strong> : <?php echo $F["tg_name"];?></li>
				<li><strong>วงเงินงบประมาณเบื้องต้น(บาท)</strong> :  <?php echo number_format($F["tg_budget"]);?>  </li>
				<li><strong>ชื่อหน่วยงาน</strong> : <?php echo $F["org_name"];?></li>
				<li><strong>E-Mail Address</strong>  : <?php echo $F["org_email"];?></li>
				<li><strong>ที่อยู่ของหน่วยงาน</strong> : <?php echo $F["org_address"];?></li>
				<li><strong>สำเนา TOR</strong></li>
				</ul>
				<div>
				<ul><table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_normal">
				<?php
				$day = date('Y-m-d');
				$n=1;
				//echo "select * from tor_list where tg_id = '".$_GET["tid"]."' and ('".$day."' between t_date_start and t_date_end) order by t_id DESC limit 0,1";
				$sql_f = $db->query("select * from tor_list where tg_id = '".$_GET["tid"]."' order by t_id DESC ");//ปรับใหม่ให้แสดงล่าสุด เท่านั้น
				$num_list = $db->db_num_rows($sql_f);
				if($num_list  > 0){
				$FF = $db->db_fetch_array($sql_f);
				$dateU = explode('-',$FF["t_date_end"]);
				$dateU = mktime(0, 0, 0, $dateU[1], $dateU[2], $dateU[0]);
				$dayU =mktime(0, 0, 0, date("m"),date("d"), date("Y"));
				$t_id = $FF["t_id"];
				$t_last = $FF["t_last"];
				if($dayU < $dateU){
				?>
			  <tr>
				<td width="5%" valign="top"><?php echo $n;?>.</td>
				<td width="50%"><?php echo $FF["t_name"];?>
				<div><br>
				<?php 
				if($FF["t_type"]=='1'){ 
					echo 'ข้อความ TOR : '.$FF["t_detail"];
				}else{
					echo 'ไฟล์สำเนา : <a href="tor_dl.php?tid='.$_GET["tid"].'&url='.urlencode ($FF["t_copy_file"]).'" target="_blank"><img src="mainpic/load.gif" alt="คลิกเพื่อ download เอกสาร" width="32" height="32" border="0"></a>';
				}
				?>
				</div>
				<?php 	$sql_ff = $db->query("select * from tor_file where t_id ='".$t_id."'");
				if($db->db_num_rows($sql_ff)>0){
				?><div><br>เอกสารแนบอื่นๆ<ul>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_normal">
				<?php
				$X = 1;
					$sql_ff = $db->query("select * from tor_file where t_id ='".$t_id."'");
					while($RFF = $db->db_fetch_array($sql_ff)){
						$file = urldecode ($RFF["tf_path"]);
						$typename = explode('.',$file);
						$C = count($typename);
				       $CT = $C-1;
				       $dir = strtolower($typename[$CT]);
					   $typename2 = explode('/',$typename[0]);
					   $C2 = count($typename2);
				       $CT2 = $C2-1;
				       $dl_userfile  = strtolower($typename2[$CT2]).'.'.$dir;
				?>
				  <tr>
					<td><?php echo $X++;?>. <a href="<?php echo urlencode ($file);?>"><?php echo $dl_userfile;?></a></td>
				  </tr>
				  <?php } ?>
				</table>
				</ul>
</div><?php }?></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr ><td colspan="3"><br><hr size="1" ></td></tr>
			  <?php $n++; }}else{ ?>
			  <tr><td>--สิ้นสุดการประกาศร่าง TOR--</td></tr>
			  <?php } ?>
			</table></ul>
				</div>                </td>
              </tr>
            </table></td>
  </tr>
  <?php 
	  $sql_q = "select * from tor_comment where t_id='".$t_id ."'";
	  $query = $db->query($sql_q);
	  if(($db->db_num_rows($query)>0 ) && $t_last != 'Y'){
	  ?>
  <tr>
    <td ><span style="FONT: 17px 'Tahoma';">สอบถาม</span> <br><br></td>
  </tr>
  <tr>
    <td class="text_normal"><?php
	  while($Q = $db->db_fetch_array($query)){
	  ?><table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#333333" class="text_normal">
      <tr>
        <td bgcolor="#FFFFFF"><strong>คำถาม</strong> : <?php echo $Q["tc_detail"];?>
          <div><font color="#000000">[โดย <?php echo $Q["tc_name"];?>  วันที่ <?php echo $Q["tc_date"];?> เวลา <?php echo $Q["tc_time"];?>] </font></div>
		  <?php
		  $sql_a = $db->query("select * from tor_answer where tc_id = '".$Q["tc_id"]."'"); 
		  if($db->db_num_rows($sql_a)>0){
		  while($A = $db->db_fetch_array($sql_a)){
		  ?>
          <table width="100%" border="0" cellpadding="1" cellspacing="1" class="text_normal">
		  <tr><td><hr></td></tr>
            <tr>
              <td bgcolor="#FFFFFF"><strong>คำตอบ</strong> :
                <div><?php echo $A["ta_detail"];?> </div><div><font color="#000000">[โดย <?php echo $A["ta_user"];?>  วันที่ <?php echo $A["ta_date"];?> เวลา <?php echo $A["ta_time"];?>] </font></div></td>
            </tr>
          </table><?php 
		  }
		  }  ?></td>
      </tr>
</table><br><br>
	  <?php
	  }
	   }
	   ?></td>
  </tr>
  <tr>
    <td class="text_normal">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="text_normal"><?php if($t_last != 'Y' && $num_list > 0 ){?><form name="form1" method="post" action="tor_function.php" onSubmit="return CHK(this);"> 
	<table width="60%" border="0" cellpadding="1" cellspacing="1" class="text_normal">
      <tr>
        <td colspan="2" align="center" ><strong>ส่งคำถาม</strong></td>
      </tr>

      <tr>
        <td width="20%" >คำถาม : <font color="#FF0000">*</font></td>
        <td width="80%" ><textarea name="tddetail" cols="50" rows="5" id="tddetail"></textarea></td>
      </tr>
      <tr>
        <td >ชื่อผู้ถาม : <font color="#FF0000">*</font></td>
        <td ><input name="tdname" type="text" id="tdname" ></td>
      </tr>
      <tr>
        <td colspan="2" align="center" ><input type="submit" name="Submit" value="ส่งคำถาม" />
          <input name="tid" type="hidden" id="tid" value="<?php echo $t_id ;?>">
		  <input name="tgid" type="hidden" id="tgid" value="<?php echo $_GET[tid];?>">
          <input name="flag" type="hidden" id="flag" value="sent_data"></td>
      </tr>
</table>
    </form><?php } ?>
    </td>
  </tr>
</table>

	  <?php $db->query("USE ".$EWT_DB_NAME);?>
	   <!--body-->
      </td>
          <td id="ewt_main_structure_right" width="<?php echo $R["d_site_right"]; ?>" bgcolor="<?php echo $R["d_right_bg_c"]; ?>" background="<?php echo $R["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $R["d_bottom_height"]; ?>" bgcolor="<?php echo $R["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $R["d_bottom_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
      </table>

</body>
</html>
<?php if(!session_is_registered("TOR_VISITOR_STAT")){
	session_register("TOR_REFERER");
	$_SESSION["TOR_REFERER"] = $HTTP_REFERER.$t_id;
	} 
	$end_time_counter = date("YmdHis");
	$gap = $end_time_counter - $start_time_counter;
?>
<script language="javascript">
document.write("<img src=\"tor_stat.php?tid=<?php echo $t_id;?>&load=<?php echo $gap; ?>&res="+screen.width+"x"+screen.height+"\" width=\"100\" height=\"100\" style=\"display:none\">");	
</script>
<?php
	$db->db_close(); ?>
