<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST[Flag]<>' '){
		if($_POST[Flag]=='Cancel'){
		  $db->query("DELETE  FROM  news_comment WHERE id_comment = '$_POST[tmid]' "); 
		}
}
function convert_datedb_txt($date){
	$time = explode(" ",$date);
	$date = substr($date,0,10);
	
	if($date){
		$arr = explode("-",$date);
		$date = ($arr[2].'/'.$arr[1].'/'.($arr[0]+543))." เวลา ".$time[1];
		return $date;
	}//if
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<script language="javascript">
		 function popup_module(mod){
		   win2 = window.open('article_select_module.php','template','top=100,left=100,width=500,height=500,resizable=1,status=0,scrollbars=1');win2.focus();
		 }
 
 		function cancel_template(tmid,mod){
			document.form.Flag.value='Cancel';
			document.form.tmid.value=tmid;
			document.form.mod.value=mod;
			document.form.submit();
		}
 </script>
</head>
<body>
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">จัดการแจ้งลบความคิดเห็น</span></td>
  </tr>
</table>
<hr>

<table width="94%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
	<tr> 
		<td  valign="top">
			<table width="100%" cellpadding="5"  cellspacing="1" bgcolor="#B74900" class="ewttableuse" id="table-1">
				<tr class="nodrop ewttablehead">
					<td  width="4%" ></td>  
					<td  width="65%" align="center">แจ้งลบความคิดเห็น</td>
					<td  width="15%" align="center">วันที่แจ้งลบ</td>
				</tr>
	<?php
		$sql="SELECT * FROM article_list INNER JOIN news_comment ON article_list.n_id = news_comment.news_id where date_del != '' and date_del != '0000-00-00 00:00:00' order by date_del DESC ";
		$query = $db->query($sql); 

		$data1 = array();
		function titlegroup2($cid){
			global $db;
			global $data1;
			
			$sql_ti = "SELECT * FROM article_group where c_id = '".$cid."'";
			$exc_ti = $db->query($sql_ti);
			$row_ti = $db->db_fetch_array($exc_ti);
		
			if($row_ti['c_parent']!=null){
				array_push($data1,$row_ti['c_id']);
				titlegroup2($row_ti['c_parent']);
				
			}
			return $data1;
		}
		
		if($db->db_num_rows($query) > 0){
				while($R=$db->db_fetch_array($query)){ 
				
				$title1 = "&nbsp;จากข่าว";
				//
				//$data1 = null;
				//$data1 = array();
				
				//$arr."".$i = array();
				
				$nlink = titlegroup2($R["c_id"]);
			 	
				krsort($data1);
				$j=0;
				foreach($data1 as $x=>$x_value){
					$j++;
					$sql_ti = "SELECT * FROM article_group where c_id = '".$x_value."'";
					$exc_ti = $db->query($sql_ti);
					$row_ti = $db->db_fetch_array($exc_ti);
					
					if($row_ti["c_name"]!=null){
						$title1.= " >> ";
					}
					
					$title1.= $row_ti["c_name"];
					
					
					
					//unset($data1[$j]);
					array_pop($data1);
					
					unset($data1[$x_value]);
				}
				$title = $title1;
				$title1 = " ";
			
				
	?> 
				<tr bgcolor="#FFFFFF" >
						<td height="20"  align="center" nowrap="nowrap">
						<!--<img src="../theme/main_theme/g_not_allow.png" width="16" height="16" border="0" align="absmiddle">-->
						<img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" align="absmiddle" alt="ลบความคิดเห็น" style="cursor:pointer;" onClick="if(confirm('ยืนยันการการลบความคิดเห็นที่  <?php echo $R["id_comment"]; ?>')){cancel_template('<?php echo $R["id_comment"]; ?>','Article')}"></td>
						<td >&nbsp;<strong>ความคิดเห็นที่ <?php echo $R["id_comment"]; ?> </strong><?php echo $R["comment"]; ?>
						<br>&nbsp;<font color="red">หัวข้อข่าว/บทความ : <?php echo $R["n_topic"]; ?></font><br>
						<?php echo $title ?>
						</td>
						<td >&nbsp;<?php echo convert_datedb_txt($R["date_del"]); ?></td>
				  </tr>
				 <?php
					  $i++;
				} 
			}else{?>
			<tr bgcolor="#FFFFFF" >
						<td height="20"   align="center" 	colspan="4"><span class="style1"> ไม่พบข้อมูล</span> </td> 
			</tr>
	     <?php } ?>
			</table>
			
		</td>
	</tr>
</table>

<form name="form" action="article_comment_del.php" method="post">
	<input type="hidden" name="Flag" value="Cancel">
	<input type="hidden" name="did">
	<input type="hidden" name="mod">
	<input type="hidden" name="tmid">
</form>
</body>
</html>
<?php $db->db_close(); ?>
