<?php
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

$sql0 = $db->query("SELECT * FROM $PR[s_table] ORDER BY survey_id ");
$fi = mysql_num_fields($sql0);
$ro = mysql_num_rows($sql0);

?>
<html>
<head>                     
<title><?php echo preg_replace($search, $replace, $PR[s_title]); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0">
<div align="center"><br>
    <font size="3" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php if($_GET["FlagE"] != "excel"){  echo $PR[s_title]; }else{ echo preg_replace($search, $replace, $PR[s_title]); } ?></strong></font></div>
	<?php if($_GET["FlagE"] != "excel"){ ?>
  <font size="1" face="MS Sans Serif, Tahoma, sans-serif">>><a href="view_survey.php?s_id=<?php echo $_GET["s_id"]; ?>&FlagE=excel"><?php echo $lang_survey_excel; ?></a><br>>><a href="graph_field_print.php?s_id=<?php echo $_GET["s_id"]; ?>" target="_blank">พิมพ์ออกรายงาน</a><br>
  <?php } ?>
  <table border="0" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="ewttableuse" width="90%">
 
  <?php
  $i = 0;
  $s = "G";
  while( $i<$fi){ 
  $field[$i] = mysql_field_name($sql0,$i); 
	  $RR = explode("B",$field[$i]);
	  if($RR[1]!=""){
			$RRR = explode("_",$RR[1]);	  
			if($RRR[1]==""){
				$sql1 = $db->query("SELECT q_des,q_anstype FROM p_question WHERE q_id ='$RRR[0]' ");
				$T = mysql_fetch_array($sql1);
				
				if($T[q_anstype] == "A" OR $T[q_anstype] == "C"){
				$sql = $db->query("SELECT ".$field[$i].", COUNT(".$field[$i].") AS CT  FROM ".$PR[s_table]."   GROUP BY ".$field[$i]." ORDER BY CT DESC");
				?>
				<tr bgcolor="B2B4BF" height="30"><td  bgcolor="#FFFFFF"   class="ewttablehead"><?php echo $T[q_des]; ?></td></tr>
				<tr bgcolor="B2B4BF" height="30"><td align="left"  bgcolor="#FFFFFF">
				<?php
			$graph_name = array();
			$graph_data = array();
				while($G=mysql_fetch_row($sql)){
				$fname = "";
				if($G[0] != ""){
				$er = explode("#@form#img@#",$G[0]);
				$fname = $er[0];
				}else{
				$fname = "ไม่ตอบคำถาม";
				}
				array_push($graph_name,$fname);
				array_push($graph_data,$G[1]);
				}
				$graph_height  = "500";
  				$graph_width  = "800";
				$graph_group = "Y";
		//		$graph_rotate = "1";
				include("../ewt_graph_include.php");
				?>
				</td></tr>
				<?php	
				}elseif($T[q_anstype] == "D"  || $T[q_anstype] == "E"){
				$sql = $db->query("SELECT ".$field[$i].", COUNT(".$field[$i].") AS CT  FROM ".$PR[s_table]."   GROUP BY ".$field[$i]." ORDER BY CT DESC");
				?>
				<tr bgcolor="B2B4BF" height="30"><td nowrap bgcolor="#FFFFFF"   class="ewttablehead"><?php echo $T[q_des]; ?></td></tr>
				<tr bgcolor="B2B4BF" height="30"><td align="left" nowrap bgcolor="#FFFFFF">
				 <DIV style="HEIGHT: 200;OVERFLOW-Y: scroll;WIDTH: 100%;">
				 <ul style="display:block;">
				<?php
				while($G=mysql_fetch_row($sql)){
				$fname = "";
				if($G[0] != ""){
				if($T[q_anstype] == "E"){
					echo "<li><a href=\"../ewt/".$EWT_FOLDER_USER."/".$G[0]."\" target=\"_blank\">".$G[0]." (".$G[1]." คน)</li>";
					}else{
						$newtext = wordwrap($G[0], 80, "<br/>", true);
					echo "<li>".nl2br($newtext)." (".$G[1]." คน)</li>";
					}
				}else{
					echo "<li>ไม่ตอบคำถาม (".$G[1]." คน)</li>";
				}
				}
				?></ul></DIV>
				</td></tr>
				<?php
				}else{
				$sql = $db->query("SELECT ".$field[$i].", COUNT(".$field[$i].") AS CT  FROM ".$PR[s_table]."   GROUP BY ".$field[$i]." ORDER BY CT DESC");
				?>
				<tr bgcolor="B2B4BF" height="30"><td nowrap bgcolor="#FFFFFF"   class="ewttablehead"><?php echo $T[q_des]; ?></td></tr>
				<tr bgcolor="B2B4BF" height="30"><td align="left" nowrap bgcolor="#FFFFFF">
				<?php
			$graph_name = array();
			$graph_data = array();
				while($G=mysql_fetch_row($sql)){
				$fname = "";
				if($G[0] != ""){
				$er = explode("#@form#img@#",$G[0]);
				$fname = $er[0];
				}else{
				$fname = "ไม่ตอบคำถาม";
				}
				array_push($graph_name,$fname);
				array_push($graph_data,$G[1]);
				}
				$graph_height  = "500";
  				$graph_width  = "800";
				$graph_group = "Y";
		//		$graph_rotate = "1";
				include("../ewt_graph_include.php");
				?>
				</td></tr>
				<?php
				}
				$i++;
			}else{
			
				$sql1 = $db->query("SELECT q_des,q_anstype FROM p_question WHERE q_id ='$RRR[0]' ");
				$T = mysql_fetch_array($sql1);
				
				$sql2 = $db->query("SELECT a_name FROM p_ans WHERE q_id ='$RRR[0]' ");
			$graph_name = array();
			$graph_data = array();
				?>
				<tr bgcolor="B2B4BF" height="30"><td nowrap bgcolor="#FFFFFF"   class="ewttablehead"><?php echo $T[q_des]; ?></td></tr>
				<tr bgcolor="B2B4BF" height="30"><td align="left" nowrap bgcolor="#FFFFFF">
				<?php
				
				while($W = mysql_fetch_array($sql2)){
				$field[$i] = mysql_field_name($sql0,$i);
				$sql = $db->query("SELECT COUNT(".$field[$i].") AS CT  FROM ".$PR[s_table]."   WHERE ".$field[$i]." != ''  ");
				$CT = $db->db_fetch_row($sql);
				$er = explode("#@form#img@#",$W[a_name]);
				$fname = preg_replace($search, $replace, $er[0]);
				array_push($graph_name,$fname);
				array_push($graph_data,$CT[0]);
				$i++;
				}
				$graph_height  = "500";
  				$graph_width  = "800";
				$graph_group = "Y";
				include("../ewt_graph_include.php");
				?>
				</td></tr>
				<?php
			}
	  }else{
	  $i++;
	  }

} ?>
    
  </table>
</body>
</html>
<?php @$db->db_close(); ?>