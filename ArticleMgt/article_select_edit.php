<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

function GenPic($data){
	for($i=0;$i<=$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
		//echo "<span style=\"width:10%\"></span>";
	}
}
		
		
function showgroup($start,$i,$id,$idp,$dis){
	global $db;
	$x = $i+1;
	$sql_show = $db->query("SELECT * FROM article_group WHERE c_parent = '".$start."' ");
	if($db->db_num_rows($sql_show)){
					while($R = $db->db_fetch_array($sql_show)){
						echo ''.GenPic($i).'<input  type="radio" name="c_parent" value="'.$R[c_id].'" ';
						if($id == $R[c_id]){
						echo ' disabled ';
						}
						if($dis == "Y"){
						echo ' disabled ';
						}
						if($id == $R[c_id] OR $dis == "Y"){
						$dis1 = "Y";
						}else{
						$dis1 = "";
						}
						if($idp == $R[c_id]){
						echo ' checked ';
						}
							$y=$i+1;
						 if($y>=1 and $y<10){
							echo '  onClick="window.opener.document.form1.c_parent.value=this.value;   window.opener.document.all.gname.innerHTML= '."'".preg_replace('/&#039;/',"`",$R["c_name"])."'".' ; window.close(); "><img src="../images/folder_closed'.$y.'.gif" width="16" height="16" border="0" align="absmiddle"> '.$R["c_name"]."<br>";
							$y=0;
						 }else{
							echo '  onClick="window.opener.document.form1.c_parent.value=this.value; window.opener.document.all.gname.innerHTML= '."'".preg_replace('/&#039;/',"`",$R["c_name"])."'".' ; window.close();"><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> '.$R["c_name"]."<br>";
						}
						
						showgroup($R[c_id],$x,$id,$idp,$dis1);
					}
	}
}


function showgroup2($start,$i,$id,$idp,$dis){
	global $db;
	$x = $i+1;
	$sql_show = $db->query("SELECT * FROM article_group WHERE c_parent = '".$start."' ");
	if($db->db_num_rows($sql_show)){
					while($R = $db->db_fetch_array($sql_show)){
						echo '<div class="radio"><label>'.GenPic($i).'<input type="checkbox" name="ct_parent'.$x.'" value="'.$R[c_id].'" ';
						if($id == $R[c_id]){
						echo ' disabled ';
						}
						if($dis == "Y"){
						echo ' disabled ';
						}
						if($id == $R[c_id] OR $dis == "Y"){
						$dis1 = "Y";
						}else{
						$dis1 = "";
						}
						if($idp == $R[c_id]){
						echo ' checked ';
						}
							$y=$i+1;
						 if($y>=1 and $y<10){
							echo '><img src="../images/folder_closed'.$y.'.gif" width="16" height="16" border="0" align="absmiddle"> '.$R["c_name"]."</label></div><br>";
							$y=0;
						 }else{
							echo '><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> '.$R["c_name"]."</label></div><br>";
						}
						
						showgroup2($R[c_id],$x,$id,$idp,$dis1);
					}
	}
}

		
		$ptype = "Ag";
		$ppms1 = "w";
		
		
function countparent($c){
		global $db,$EWT_DB_USER,$ptype,$ppms1,$ppms2,$y;
	
		$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
		while($U = $db->db_fetch_array($sql)){
				$c = countparent($U["c_parent"]);
				$y += $c;
				$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
				AND (
				   (s_type = '".$ptype."' AND s_permission = '".$ppms1."'  AND s_id = '".$U["c_parent"]."' )
				  ) ",$EWT_DB_USER);
				if($db->db_num_rows($sql2) > 0){
					$y++;
				}
		}
		return $y;
}	

$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$_GET["cid"]."'");
$G = $db->db_fetch_array($sql_group);

include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<style type="text/css">

</style>
</head>
<body leftmargin="0" topmargin="0" bgcolor="#FFFFFF">
<div class="container" style="width: 100%;">
<div class="col-md-12 col-sm-12 col-xs-12" _style="border-color:#000000;background-color:#FFFFFF;border: 3px solid #FFC153;
    padding: 10px;
    border-radius: 15px;top:10px;">
<div class="clearfix">&nbsp;</div>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">กลุ่มข่าว/บทความ</h4>
</div>	


<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >

</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" >
<!--<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("หน้าหลัก".$text_genbanner_function1);?>&module=banner&url=<?php echo urlencode("main_group_banner.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="banner_gadd.php?flag=add" target="_self"><img src="../theme/main_theme/g_add.gif"  width="16" height="16"  align="absmiddle" border="0"> 
      เพิ่มหมวด</a>
<a href="article_gadd.php?p=0" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-plus-sign "></span>  เพิ่มกลุ่มข่าวและบทความ
	</button>
</a>  	  
<a href="article_new.php" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-plus-sign "></span>  เพิ่มข่าวและบทความ
	</button>
</a>-->  
<a href="#close" target="_self" onClick="window.close();">
<button type="button" class="btn btn-danger  btn-ml " >
       <span class="glyphicon glyphicon-remove-sign"></span>&nbsp;&nbsp;<?="ปิด";?>
</button>
</a>
</div>	
</div>
<hr>
</div>


<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="radio">
<label>	
 <?php
  if($db->check_permission($ptype,$ppms,"0")){
  ?>
          <input type="radio" name="c_parent" value="0" <?php if($G["c_parent"] == "0"){ echo "checked"; } ?> onClick="window.opener.document.form1.c_parent.value=this.value;  window.opener.document.all.gname.innerHTML= 'กลุ่มข่าว/บทความ'; window.close();">
          <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">กลุ่มข่าว/บทความ<br>
</label>
</div>		  
<?php
	  showgroup(0,0,$G["c_id"],$G["c_parent"],"");
?>
  
<?php
}else{
?>
          <input type="radio" name="c_parent" value="<?php echo $G["c_parent"]; ?>" checked  onClick="window.opener.document.form1.c_parent.value=this.value;  window.opener.document.all.gname.innerHTML= 'กลุ่มข่าว/บทความ'; window.close(); ">
          <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">กลุ่มข่าว/บทความ<br>
<?php
		$sql_supadmin = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
		AND ( (s_type = 'Ag' AND s_permission = 'w'  AND s_id != '0' )  	)",$EWT_DB_USER);
		
			 $sql_text = "WHERE ( 0 ";
			while($Gx = $db->db_fetch_row($sql_supadmin)){
			$y = 0;
				if(countparent($Gx[0]) == 0){
				$sql_text .= " OR c_id = '".$Gx[0]."' ";
				}
			}
			$sql_text .= " ) ";
		$sql_articleg = $db->query_db("SELECT * FROM article_group  ".$sql_text." ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
		
		while($GP=$db->db_fetch_array($sql_articleg)){
		$dis = "";
		?>
<div class="radio">
<label>
  <input type="radio" name="c_parent" value="<?php echo $GP["c_id"]; ?>" <?php if($G["c_parent"] == $GP["c_id"]){ echo "checked"; } ?> <?php if($G["c_id"] == $GP["c_id"]){ echo "disabled"; $dis = "Y"; }   ?>  onClick="window.opener.document.form1.c_parent.value=this.value;  window.opener.document.all.gname.innerHTML= '<?php echo eregi_replace('/&#039;/',"`",$GP["c_name"])?>'; window.close(); ">
        <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"><?php echo $GP["c_name"]; ?>
</label>
</div>
<?php
		showgroup($GP["c_id"],0,$G["c_id"],$G["c_parent"],$dis);
		
?>
<?php
		}
}
  ?>


</div>
</div>
</div>
</div>
</div>
<?php
//include('footer.php');
?>
</body>
</html>
<?php $db->db_close(); ?>
