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
	include("../language/language".$lang_sh.".php");
	include("ewt_template.php");
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
</head>

<body <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?>>
<table <?php if($F["d_site_width"] != ""){ echo "width=\"".$F["d_site_width"]."\""; } ?> border="0" cellpadding="0" cellspacing="0" <?php if($F["d_site_align"] != ""){ echo "align=\"".$F["d_site_align"]."\""; } ?>>
  <tr>
    <td  <?php if($F["d_top_height"] != ""){ echo "height=\"".$F["d_top_height"]."\""; } ?> <?php  if($F["d_top_bg_c"] != ""){ echo "bgcolor=\"".$F["d_top_bg_c"]."\""; } ?>  colspan="3" >
	  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
	</td>
  </tr>
  <tr>
    <td  valign="top"  <?php if($F["d_site_left"] != ""){ echo "width=\"".$F["d_site_left"]."\""; } ?> <?php  if($F["d_left_bg_c"] != ""){ echo "bgcolor=\"".$F["d_left_bg_c"]."\""; } ?>>
	  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
	
	
	
	</td>
    <td  valign="top"  <?php if($F["d_site_content"] != ""){ echo "width=\"".$F["d_site_content"]."\""; } ?> <?php  if($F["d_body_bg_c"] != ""){ echo "bgcolor=\"".$F["d_body_bg_c"]."\""; } ?>>
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
				<?php if($err == "1"){ ?> <font color="#FF0000"><?php echo $text_genpoll_message2;?>  <?php echo  DiffToText_new($diff);?></font>
			<?php } ?></td>
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
	
	if($cad_id or $_POST["flag"]=='1'){
	   if($_POST["flag"]=='1'){
		   $cad_id=$_POST[cad_id];
		   $vote=$_POST[vote];
	   }
	  $PollSel = $db->query("SELECT * FROM poll_cat WHERE  c_id = '$cad_id' ");
	  $pollR = $db->db_fetch_array($PollSel);
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
<br><div align="center"><b><?php echo stripslashes($pollR[c_name]); ?></b> </div>
<table width="100%" border="0" cellpadding="0" cellspacing="0"  align="center">
      <tr>
        <td align="center"><?php
		$graph_name = array();
		$graph_data = array();
	  $total1 = 0;
	  $i = 1;
	

	$sql_color = "select * from poll_ans where c_id = '$cad_id' order by a_id";

	$query_color = $db->query($sql_color);
	while($rec_color = $db->db_fetch_array($query_color)){
	$sql_aws = "select count(*) as num from poll_log where c_id = '$cad_id' and a_id = '".$rec_color[a_id]."' $con ";
	$rec_aws = $db->db_fetch_array($db->query($sql_aws));
	$b = $rec_aws[num];
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
        <td align="center"><?php echo $text_genpoll_report_result1;?> <?php echo $total1; ?> <?php echo $text_genpoll_report_result2;?></td>
      </tr>
    </table>
			
			
	<?php  }?>		
			
			
			
			
			
			
			
			
			
	
	
	</td>
    <td  valign="top"  <?php if($F["d_site_right"] != ""){ echo "width=\"".$F["d_site_right"]."\""; } ?> <?php  if($F["d_right_bg_c"] != ""){ echo "bgcolor=\"".$F["d_right_bg_c"]."\""; } ?>>	 
	 <?php
			$mainwidth =  $F["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?></td>
  </tr>
 
<tr valign="top" > 
          <td  colspan="3"  valign="top"  <?php if($F["d_bottom_height"] != ""){ echo "height=\"".$F["d_bottom_height"]."\""; } ?> <?php  if($F["d_bottom_bg_c"] != ""){ echo "bgcolor=\"".$F["d_bottom_bg_c"]."\""; } ?> <?php if($F["d_bottom_bg_p"] != ""){ echo "background=\"".$F["d_bottom_bg_p"]."\""; } ?>>	 
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
</table>
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</body>
</html>
<?php $db->db_close(); ?>