<?php
include("authority.php");
?>
<?php 
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
if($thisday == ""){
$thisday = date("d");
}
if($thismonth == ""){
$thismonth = date("m");
}
if($thisyear == ""){
$thisyear = date("Y");
}
$basediv = 0;
$db->write_log("view","enews","ดูรายงานสถิติการเข้าเว็บของวันที่".$thisday."/".$thismonth."/".$thisyear);
?>
<html>
<head>
<title>Newsletter Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td class="ewtfunction"><img src="../images/document_view.gif" width="24" height="24" border="0" align="left"> สถิติการส่งของวันที่ <?php echo number_format($thisday,0); ?> 
      <?php echo $monthname[number_format($thismonth,0)]; ?> <?php echo ($thisyear + 543); ?></td>
    <td align="right" ><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("สถิติการส่ง");?>&module=newsletter&url=<?php echo urlencode("mail_stat.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a></td>
  </tr>
  <tr height="1">
    <td height="1" colspan="2" bgcolor="#DDDDDD"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">

  <tr>
    <td><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle"><font size="2" face="Tahoma"><strong>สถิติรายปี</strong></font></td>
  </tr>
  <tr>
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
        <tr bgcolor="#FFFFFF">
		<?php for($y=2007;$y<=date("Y");$y++){ 
		$sql_year = mysql_query("SELECT COUNT(h_id) AS cmonth FROM n_history WHERE h_date LIKE '".$y."-%' ");
		$ccount = mysql_fetch_row($sql_year);
		?>
          <td  align="center" <?php if($y==$thisyear){  $basediv = $ccount[0]; ?>bgcolor="#FF9966"<?php } ?>><a href="mail_stat.php?thisday=<?php echo $thisday; ?>&thismonth=<?php echo $thismonth; ?>&thisyear=<?php echo $y; ?>"><font size="2" face="Tahoma"><b><?php echo ($y+543); ?></b></font></a><font size="2" face="Tahoma"><br>
            (<?php echo number_format($ccount[0],0); ?>)</font></td>
		  <?php } ?>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle"><font size="2" face="Tahoma"><strong>สถิติรายเดือนปี <?php echo ($thisyear + 543); ?>
      </strong></font></td>
  </tr>
  <tr>
    <td><table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
              <?php for($i=1;$i<13;$i++){ 
		$schdate="%/$i/$thisyear";
		$sql_month = mysql_query("SELECT COUNT(h_id) AS cmonth FROM n_history WHERE h_date LIKE '".$thisyear."-".sprintf("%02d",$i)."-%' ");
		$ccount = mysql_fetch_row($sql_month);
		?>
              <tr bgcolor="#FFFFFF"> 
                <td width="15%" align="center" <?php if($i==number_format($thismonth,0)){ $divmonth =$ccount[0];  ?>bgcolor="#FF9966"<?php } ?>><a href="mail_stat.php?thisday=<?php echo $thisday; ?>&thismonth=<?php echo sprintf("%02d",$i); ?>&thisyear=<?php echo $thisyear; ?>"><font size="2" face="Tahoma"><b><?php echo $monthname[$i]; ?></b></font></a></td>
                <td width="10%" align="right" <?php if($i==number_format($thismonth,0)){ $divmonth =$ccount[0];  ?>bgcolor="#FF9966"<?php } ?>>
				ร้อยละ <?php   
				if($basediv > 0){
				  echo number_format((($ccount[0]*100)/$basediv),0);
				  }else{
				  echo "0";
				  }
				  ?></td>
                <td width="5%" align="right" <?php if($i==number_format($thismonth,0)){ $divmonth =$ccount[0];  ?>bgcolor="#FF9966"<?php } ?>><font size="2" face="Tahoma">(<?php echo number_format($ccount[0],0); ?>)</font></td>
                <td width="70%" <?php if($i==number_format($thismonth,0)){ $divmonth =$ccount[0];  ?>bgcolor="#FF9966"<?php } ?>> 
                  <?php 
		  if($basediv > 0){
		  $width = number_format((($ccount[0]*100)/$basediv),0);
		  }else{
		  $width = 0;
		  }
		   ?>
                  <table width="<?php echo $width; ?>%" height="12" border="0" cellpadding="0" cellspacing="1" bgcolor="#333333">
                    <tr width="<?php echo $width; ?>%" height="12" > 
                      <td width="<?php echo $width; ?>%" height="12" background="../images/bg.gif"></td>
                    </tr>
                  </table></td>
              </tr>
              <?php } ?>
            </table></td>
  </tr>
</table>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle"><font size="2" face="Tahoma"><strong>สถิติรายวันภายในเดือน 
      <?php echo $monthname[number_format($thismonth,0)]; ?> <?php echo ($thisyear + 543); ?></strong></font></td>
    <td><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle"><font size="2" face="Tahoma"><strong>สถิติช่วงเวลาของวันที่ <?php echo number_format($thisday,0); ?> <?php echo $monthname[number_format($thismonth,0)]; ?> <?php echo ($thisyear + 543); ?>
      </strong></font></td>
  </tr>
  <tr> 
    <td width="47%" align="center"><table width="95%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
              <tr align="center" bgcolor="#999999"> 
                <td width="20%"><strong><font size="2" face="Tahoma">วันที่</font></strong></td>
                <td width="10%"><strong><font size="2" face="Tahoma">จำนวน</font></strong></td>
                <td width="20%"><strong><font size="2" face="Tahoma">ร้อยละ</font></strong></td>
                <td width="50%" ><font size="2" face="Tahoma"><strong>กราฟ</strong></font></td>
              </tr>
              <?php
		if($thismonth == "01" OR $thismonth == "03" OR $thismonth == "05" OR $thismonth == "07" OR $thismonth == "08" OR $thismonth == "10" OR $thismonth == "12" ){
		$endmonth = "31";
		}
		if($thismonth == "04" OR $thismonth == "06" OR $thismonth == "09" OR $thismonth == "11" ){
		$endmonth = "30";
		}
		if($thismonth == "02"){
		if($thisyear % 4 == 0){
				$endmonth = "29";
		}else{
				$endmonth = "28";
		}
		}
		 for($d=1;$d<=$endmonth;$d++){ 
		 $todate = $thisyear."-".$thismonth."-".sprintf("%02d",$d);
		 //$todate="%/$d/$thisyear";
		 $sql_date = mysql_query("SELECT COUNT(h_id) AS cmonth FROM n_history WHERE h_date like '$todate'  ");
		 //echo "SELECT COUNT(h_id) AS cmonth FROM n_history WHERE h_date like '$todate'  ";
		$ccount = mysql_fetch_row($sql_date);
		 ?>
              <tr <?php if($d==number_format($thisday,0)){  $divday =$ccount[0]; ?>bgcolor="#FF9966"<?php } ?>> 
                <td align="center" ><a href="mail_stat.php?thisday=<?php echo sprintf("%02d",$d); ?>&thismonth=<?php echo $thismonth; ?>&thisyear=<?php echo $thisyear; ?>"><strong><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $d; ?></font></strong></a></td>
                <td align="right"><font size="1" face="MS Sans Serif, Tahoma, sans-serif">(<?php echo number_format($ccount[0],0); ?>)</font></td>
                <td align="center"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><?php 
		  if($divmonth > 0){
		  echo number_format((($ccount[0]*100)/$divmonth),0);
		  }else{
		  echo "0";
		  }
		   ?></font></td>
                <td> 
                  <?php 
		  if($divmonth > 0){
		  $width = number_format((($ccount[0]*100)/$divmonth),0);
		  }else{
		  $width = 0;
		  }
		   ?>
                  <table width="<?php echo $width; ?>%" height="12" border="0" cellpadding="0" cellspacing="1" bgcolor="#333333">
                    <tr width="<?php echo $width; ?>%" height="12" > 
                      <td width="<?php echo $width; ?>%" height="12" background="../images/block_bg1.gif"></td>
                    </tr>
                  </table></td>
              </tr>
              <?php  } ?>
            </table></td>
  </tr>
</table>
</td>
    <td width="53%" align="center" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
              <tr align="center" bgcolor="#999999"> 
                <td width="20%"><strong><font size="2" face="Tahoma">เวลา</font></strong></td>
                <td width="10%"><strong><font size="2" face="Tahoma">จำนวน</font></strong></td>
                <td width="20%"><font size="2" face="Tahoma"><strong>ร้อยละ</strong></font></td>
                <td width="50%"><font size="2" face="Tahoma"><strong>กราฟ</strong></font></td>
              </tr>
              <?php for($m=0;$m<24;$m++){ 
		$mstart = sprintf("%02d",$m).":00";
		$mend = sprintf("%02d",$m).":59";
		$sql_time = mysql_query("SELECT COUNT(h_id) AS cmonth FROM n_history WHERE h_date  = '".$thisyear."-".$thismonth."-".$thisday."'   AND (h_time BETWEEN '".$mstart.":00"."' AND '".$mend.":59"."')");
		//echo  "SELECT COUNT(h_id) AS cmonth FROM n_history WHERE h_date  = '".$thisyear."-".$thismonth."-".$thisday."'   AND (h_time BETWEEN '".$mstart.":00"."' AND '".$mend.":59"."')";
		$ccount = mysql_fetch_row($sql_time);
		?>
              <tr bgcolor="#FFFFFF"> 
                <td align="center" bgcolor="#E7E7E7"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $mstart; ?>-<?php echo $mend; ?></font></td>
                <td align="right"><font size="1" face="MS Sans Serif, Tahoma, sans-serif">(<?php echo number_format($ccount[0],0); ?>)</font></td>
                <td align="center"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><?php 
		  if($divday > 0){
		  echo number_format((($ccount[0]*100)/$divday),0);
		  }else{
		 echo  "0";
		  }
		   ?></font></td>
                <td> 
                  <?php 
		  if($divday > 0){
		  $width = number_format((($ccount[0]*100)/$divday),0);
		  }else{
		  $width = 0;
		  }
		   ?>
                  <table width="<?php echo $width; ?>%" height="12" border="0" cellpadding="0" cellspacing="1" bgcolor="#333333">
                    <tr width="<?php echo $width; ?>%" height="12" > 
                      <td width="<?php echo $width; ?>%" height="12" background="../images/f_bg.gif"></td>
                    </tr>
                  </table></td>
              </tr>
              <?php } ?>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
