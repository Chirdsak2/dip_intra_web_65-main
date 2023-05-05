<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");

	include("ewt_template.php");
	include("../language/language".$lang_sh.".php");
	
	$db->access=200;
	$color = array("","#CC9933","#CCCC00","#66CCFF","#00CC66","#FF99CC","#FF9933");
function datetime($str){
  $y=substr($str,0,4);
  $m=substr($str,4,2);
  $d=substr($str,6,2);
  $h=substr($str,8,2);
  $i=substr($str,10,2);
  $s=substr($str,12,2);
  
  $str="$d/$m/$y [$h:$i:$s]";
  if(trim($str)=="// [::]"){ return '-'; }else{ return  $str;}
}
function DiffToText_new($diff){

global $text_genpoll_msg_day;
global $text_genpoll_msg_month;
global $text_genpoll_msg_year;
global $text_genpoll_msg_hour;
global $text_genpoll_msg_min;
global $text_genpoll_msg_sec;
		
          /*  if (floor($diff/31536000))
                        {
                        $x = floor($diff / 31536000);
                        echo " $x $text_genpoll_msg_year ";
                        $diff = $diff - ($x * 31536000);
                        return DiffToText_new($diff);
                        }
            elseif (floor($diff/2678400))
                        {
                        $x = floor($diff / 2678400);
                        echo " $x $text_genpoll_msg_month ";
                        $diff = $diff - ($x * 2678400);
                        return DiffToText_new($diff);
                        }
            else*/if ($diff>=86400)
                        {
                        $x = floor($diff / 86400);
						//if($x  > 0){
                        echo " $x $text_genpoll_msg_day";
                        $diff = $diff - ($x * 86400);
                        return DiffToText_new($diff);
						//}
                        }
            elseif ($diff>=3600)
                        {
                        $x = floor($diff / 3600);
                        echo " $x $text_genpoll_msg_hour";
                        $diff = $diff - ($x * 3600);
                        return DiffToText_new($diff);
                        }

            elseif ($diff>=60)
                        {
                        $x = floor($diff / 60);
                        echo " $x $text_genpoll_msg_min ";
                        $diff = $diff - ($x * 60);
                        return DiffToText_new($diff);
                        }
            else if ($diff)
						if($diff > 0){
                        echo " $diff $text_genpoll_msg_sec";
						}
            }
setcookie("votevote".$_POST["cad_id"], $d1,time()+2678400);			
$recValue = $db->db_fetch_array ($db->query("select * from site_info")); 
if($recValue['set_poll'] != 0 AND $recValue['set_poll'] != ""){
   $cookieTimes=$recValue['set_poll'];
   $skip = "0";
}else{
	$cookieTimes=30*24*3600;
	$skip = "1";
}
?>
<?php echo $template_design[0];?>
	<?php
			$mainwidth = $F["d_site_content"];
			?>
			<?php
			// post poll
			if($_POST["vote"] != "" and  $_POST["flag"]<>'1' ){

		$oldTime = $_COOKIE["votevote".$_POST["cad_id"]];
		$date_now = explode("-",date("Y-m-d"));
		$time_now = explode(":",date("H:i:s"));
		$newTime = mktime($time_now[0], $time_now[1], $time_now[2], $date_now[1], $date_now[2], $date_now[0]);
		$diff= ($oldTime+$cookieTimes)-$newTime;

		if(!isset($_COOKIE["votevote".$_POST["cad_id"]]) OR $diff < 0 OR $skip == "1"){
		        $date_now = explode("-",date("Y-m-d"));
				$time_now = explode(":",date("H:i:s"));
				$d1 = mktime($time_now[0], $time_now[1], $time_now[2], $date_now[1], $date_now[2], $date_now[0]);
				
				$udp = $db->query("UPDATE poll_ans SET a_counter = a_counter+1 WHERE a_id = '".$_POST["vote"]."'");
				$sql_insert = "INSERT INTO poll_log (c_id,a_id,ip,date,time) VALUES ('".$_POST["cad_id"]."','".$_POST["vote"]."','".$_SERVER['REMOTE_ADDR']."',NOW(),NOW())";
				$db->query($sql_insert);
				?>
	
		<table width="100%" height="70" border="0" align="center" cellpadding="0" cellspacing="0" >
		  <tr>
			<td align="center"> <font color="#FF0000"><?php echo $text_genpoll_message1;?></font></td>
		  </tr>
			<tr><td align="center" ><input type="button" value="<?php echo $text_genpoll_buttonview;?>" onClick="location.href='ewt_vote.php?cad_id=<?php echo $cad_id?>&vote=<?php echo $_POST["vote"]?>&filename=<?php echo $filename;?>';"></td>
			</tr>
	  </table>
		<?php
		}else{
				$err = "1";
		?>
	
		<table width="100%" height="70" border="0" align="center" cellpadding="0" cellspacing="0" >
		  <tr>
			<td align="center">
				<? if($err == "1"){ ?> <font color="#FF0000"><?php echo $text_genpoll_message2;?>  <?php echo  DiffToText_new($diff);?></font>
			<? } ?></td>
		  </tr>
			<tr><td align="center" ><input type="button" value="<?php echo $text_genpoll_buttonview;?>" onClick="location.href='ewt_vote.php?cad_id=<?php echo $cad_id?>&vote=<?php echo $_POST["vote"]?>&filename=<?php echo $filename;?>';"></td>
			</tr>
	  </table>
		<?php
	      exit;
		}
}
			
	?>
	
	<?php
	//view poll
	$cad_id=$_GET[cad_id];
	$vote=$_GET[vote];
	$lang_c = explode('_',$lang_sh);
	if($cad_id or $_POST["flag"]=='1'){
	   if($_POST["flag"]=='1'){
		   $cad_id=$_POST[cad_id];
		   $vote=$_POST[vote];
	   }
	   if($lang_sh != ''){
$PollSel = $db->query("SELECT * FROM poll_cat 
INNER JOIN lang_poll ON poll_cat.c_id = lang_poll.c_id
INNER JOIN lang_config ON lang_config.lang_config_id = lang_poll.lang_name
WHERE lang_config.lang_config_suffix = '".$lang_c[1]."' AND lang_poll.c_id = '".$cad_id."' AND lang_field ='c_name'");
}else{
	  $PollSel = $db->query("SELECT * FROM poll_cat WHERE  c_id = '$cad_id' ");
}
	  $pollR = $db->db_fetch_array($PollSel);
if($lang_sh != ''){
	$pollR[c_name] = $pollR[lang_detail];
	}
	  	if($Flag == "View"){
			if($start_date == "" AND $end_date == ""){
			$con = "";
			}elseif($start_date != "" AND $end_date == ""){
			$st = explode("/",$start_date);
			$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
			}elseif($start_date == "" AND $end_date != ""){
			$st = explode("/",$end_date);
			$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
			}else{
			$st = explode("/",$start_date);
			$en = explode("/",$end_date);
			$con = " AND (date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
			}
		}
		$Sel = $db->query("SELECT count(*) as num FROM poll_log WHERE c_id = '$pollR[c_id]' $con"); 
		$total = 0;
		while($R = $db->db_fetch_row($Sel)){ $total = $total + $R[0]; }
		##create graph
	?>		
<br><div align="center"><h1><? echo stripslashes($pollR[c_name]); ?></h1> </div>
<table width="100%" border="0" cellpadding="0" cellspacing="0"  align="center">
      <tr>
        <td align="center"><?php
		$graph_name = array();
		$graph_data = array();
	  $total1 = 0;
	  $i = 1;
	
 if($lang_sh != ''){
	 $sql_color = "SELECT * FROM poll_ans
									INNER JOIN lang_poll ON poll_ans.a_id = lang_poll.lang_field
									INNER JOIN lang_config ON lang_config.lang_config_id = lang_poll.lang_name
									WHERE lang_config.lang_config_suffix = '".$lang_c[1]."' AND  lang_poll.c_id = '$cad_id' ORDER BY a_id ASC";
	}else{
	$sql_color = "select * from poll_ans where c_id = '$cad_id' order by a_id";
}
	$query_color = $db->query($sql_color);
	while($rec_color = $db->db_fetch_array($query_color)){
	$sql_aws = "select count(*) as num from poll_log where c_id = '$cad_id' and a_id = '".$rec_color[a_id]."' $con ";
	$rec_aws = $db->db_fetch_array($db->query($sql_aws));
	$b = $rec_aws[num];
	if($lang_sh != ''){
	$rec_color[a_name] = $rec_color[lang_detail];
	}
				array_push($graph_name,$rec_color[a_name]);
				array_push($graph_data,$b);
$total1 += $b;
		}
				$graph_height  = "300";
  				$graph_width  = "450";
				$graph_group = "Y";
			//	$graph_rotate = "1";
				include("ewt_graph_include.php");
	?></td>
      </tr>

      <tr>
        <td align="center">
		<?php
		echo "<ul>";
		for($p=0;$p<count($graph_name);$p++){
			echo "<li>".$graph_name[$p]."จำนวนคนตอบคำถาม :".$graph_data[$p]."คน</li>";
		}
		?>
		</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><?php echo $text_genpoll_report_result1;?> <? echo $total1; ?> <?php echo $text_genpoll_report_result2;?></td>
      </tr>
    </table>
	<?php  }?>		
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>