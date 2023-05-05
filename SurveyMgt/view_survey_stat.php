<?php
if($_GET["FlagE"] == "excel"){
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition:attachment;  filename=form_excel.xls");
	header( 'Content-Description: Download Data' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );
}
if($_GET["FlagE"] == "csv"){
	header("Content-Type: application/csv");
	header("Content-Disposition:  filename=form_excel.csv");
	header( 'Content-Description: Download Data' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );
	include('survey_csv.php');
}
if($_GET["FlagE"] == "xml"){
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=form_excel.xml");
	header( 'Content-Description: Download Data' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );
}

//$db->query("USE ".$EWT_DB_USER);

$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("lang_config.php");
$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id'");
$PR = mysql_fetch_array($SQL1);
if($PR[s_table]=="N"){
?>
<script>
alert("<?php echo $langsurvey_surveynotapproveyet ?>");
window.location.href="main_survey.php";
</script>
<?php
}

if($_GET[type]=='m'){
   $where ="WHERE person_answer <> '0' ";
} else if($_GET[type]=='u'){
   $where ="WHERE person_answer = '0' ";
}else if(!$_GET[type]){
} 

$sql0 = $db->query("SELECT person_answer as Person,time_stamp as TimeStamp,survey_id FROM $PR[s_table] $where ORDER BY survey_id ");
$fi = mysql_num_fields($sql0);
$ro = mysql_num_rows($sql0);
$sendTB=$PR[s_table];
?>
<html>
<head>                     
<title><?php echo preg_replace($search, $replace, $PR[s_title]); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php if($_GET["FlagE"] != "excel"){ ?>
<link href="txt.css" rel="stylesheet" type="text/css">
<?php } ?>
</head>

<body leftmargin="0" topmargin="0">
<div align="center">
<br>
<?php if($_GET[type]=='m'){echo 'รายการตอบแบบฟอร์ม (เฉพาะสมาชิก)';}?>
<?php if($_GET[type]=='u'){echo 'รายการตอบแบบฟอร์ม (เฉพาะผู้ที่ไม่ใช่สมาชิก)';}?>
<?php if(!$_GET[type]){echo 'รายการตอบแบบฟอร์ม (ทั้งหมด)';}?>
<br>
    <font size="3" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php if($_GET["FlagE"] != "excel"){  echo $PR[s_title]; }else{ echo preg_replace($search, $replace, $PR[s_title]); } ?></strong></font>
 
	</div>
	
	<?php if($_GET["FlagE"] != "excel"){ ?>
  <font size="1" face="MS Sans Serif, Tahoma, sans-serif">>>
  <a href="view_survey_stat.php?s_id=<?php echo $_GET["s_id"]; ?>&FlagE=excel&type=<?php echo $_GET["type"];?>"><?php echo $lang_survey_excel; ?></a>  <!-- | 
<a href="view_survey_stat.php?s_id=<?php //echo $_GET["s_id"]; ?>&FlagE=csv&type=<?php //echo $_GET["type"];?>">ไฟล์ CSV</a> | 
  <a href="view_survey_stat.php?s_id=<?php // echo $_GET["s_id"]; ?>&FlagE=xml&type=<?php //echo $_GET["type"];?>">ไฟล์ XML</a>-->
  </font><br>
  <?php } ?>

  <table border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt10" width="100%">
 <tr bgcolor="B2B4BF" height="30">
     <?php if($_GET["FlagE"] != "excel"){ ?><td nowrap="nowrap" align="center">View</td><?php } ?>
     <td nowrap="nowrap" align="center">No.</td>
  <?php
  $i = 0;
  $db->write_log("view","servey","ดูรายงานข้อมูลการร่วมตอบแบบสำรวจ");
  while( $i<$fi){ ?>
      <td nowrap><?php $field[$i] = mysql_field_name($sql0,$i); 
	  $RR = explode("B",$field[$i]);
	  if($RR[1]==""){
			  echo preg_replace($search, $replace, $RR[0]);
	  }else{
			$RRR = explode("_",$RR[1]);	  
			if($RRR[1]==""){
				$sql1 = $db->query("SELECT q_des FROM p_question WHERE q_id ='".$RRR[0]."' ");
				$T = mysql_fetch_array($sql1);
		//		echo $T[q_des];
				echo preg_replace($search, $replace, $T[q_des]);
			}else{
				$sql1 = $db->query("SELECT q_des FROM p_question WHERE q_id ='".$RRR[0]."' ");
				$T = mysql_fetch_array($sql1);
		//		echo $T[q_des];
				echo preg_replace($search, $replace, $T[q_des]);
				$sql2 = $db->query("SELECT a_name FROM p_ans WHERE a_id ='".$RRR[1]."' ");
				$W = mysql_fetch_array($sql2);
				$er = explode("#@form#img@#",$W[a_name]);
				echo " (".preg_replace($search, $replace, $er[0]).")";
			}
			//	  echo $RR[1];
	  }
	  ?></td>
      <?php 
$i++;
} ?>
    </tr>
<?php  $j=1;
while($R=mysql_fetch_row($sql0)){ ?>	
    <tr bgcolor="ECEBF0" >
	<?php if($_GET["FlagE"] != "excel"){ ?>
	<td nowrap="nowrap" align="center"><a href="survey_pdf.php?sendTB=<?php echo $sendTB;?>&s_id=<?php echo $_GET[s_id];?>&su_id=<?php echo $R[2];?>" target="_blank">View</a></td>
	<?php } ?>
	<td nowrap="nowrap" align="center"><?php echo $j++; ?></td>
	<td><?php
	//$db->query("USE ".$_SESSION["EWT_SDB"]);
	//$db->query("USE ewt_user");  //for version  8.3
	$db->query("USE ".$EWT_DB_USER);  //for version  8.5
    $sssql="SELECT name_thai , surname_thai FROM gen_user  WHERE gen_user_id = '".$R[0] ."' ";
	$ssquery=$db->query($sssql); 
	$ssr=$db->db_fetch_array($ssquery); 
	if($ssr[name_thai]==''){
	  	$sssql="SELECT  WebsiteName FROM user_info  WHERE UID = '".$R[0] ."' ";
		$ssquery=$db->query($sssql); 
		if($db->db_num_rows($ssquery)>0){
		$ssr=$db->db_fetch_array($ssquery); 
	    echo   "&nbsp;".$ssr[WebsiteName]; 
		}else{
		echo "บุคคลทั่วไป";
		}
	}else{ 
	   echo   "&nbsp;".$ssr[name_thai].'  '.$ssr[surname_thai]; 
	}
	$db->query("USE ".$_SESSION["EWT_SDB"]);
	 ?></td>
	<?php for($y=1;$y<$i;$y++){ ?>
      <td><?php if($R[$y]){ $er = explode("#@form#img@#",$R[$y]); echo $er[0]; }else{ echo "&nbsp;"; } ?></td>
<?php } ?>
    </tr>
 <?php 
 
 } 
 
 ?>
  </table>
</body>
</html>
<?php $db->db_close(); ?>