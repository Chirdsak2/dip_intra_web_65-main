<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql_article = $db->query("SELECT * FROM article_list INNER JOIN share_article ON article_list.n_id = share_article.n_id AND article_list.UID = share_article.UID_s   AND article_list.user_share = share_article.user_s WHERE share_article.s_status = 'W' AND share_article.user_t = '".$_SESSION["EWT_SUSER"]."' ORDER BY  share_article.c_id, share_article.s_date DESC");

	function g_name($cid){
		global $db,$EWT_DB_USER;
		$db->query("USE ".$_SESSION["EWT_SDB"]);
	
			$sql = $db->query("SELECT c_name FROM article_group WHERE c_id = '$cid'");
			$G = $db->db_fetch_row($sql);
			
		$db->query("USE ".$EWT_DB_USER);
		return $G[0];
	}
	function countparent($c,$ppms){
global $db,$y,$EWT_DB_USER;

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"],$ppms);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
	AND (
	   (s_type = 'Ag' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_parent"]."' ) 
	  ) ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  $db->query("use ".$_SESSION["EWT_SDB"]);
  return $y;
}
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<?php 
$disabled1='style="display:none"';
$disabled2='style="display:none"';
if($db->check_permission('art','w','')){ $disabled1='';}
if($db->check_permission('art','a','')){ $disabled2=''; }
?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ดึงข่าว/บทความที่มีการแชร์ </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
	<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ( "ดึงข่าว/บทความที่มีการแชร์ "); ?>&module=article&url=<?php echo urlencode ( "article_request.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
<hr>
    </td>
  </tr>
</table>
<table width="94%"  border="0" align="center" cellpadding="5" class="table table-bordered">
  <form name="form1" method="post" action="article_request_function.php">
    <tr bgcolor="#E0DFE3"  class="ewttablehead"> 
      <td width="5%" height="18" align="center"  <?php echo $disabled1;?>><input type="submit" name="Submit" value="Accept" ></td>
      <td width="50%" height="18" align="center" >หัวข้อข่าว/บทความ</td>
      <td width="30%" align="center" >กลุ่มข่าว/บทความ</td>
      <td width="15%" align="center" >วันที่</td>
    </tr>
    <?php
	$i = 0;
	if($db->db_num_rows($sql_article) > 0){
	while($N = $db->db_fetch_array($sql_article)){ 
	$date = explode("-",$N["s_date"]);
	 $pass_sub_a=''; 
		 $y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
		 if($db->check_permission("Ag","a","0") or $db->check_permission("Ag","a",$N["c_id"]) ){
			 $pass_sub_a='Y';
		 }else{
		   if(countparent($N["c_id"],"a")>0){
				$pass_sub_a='Y';
		   }
		 }
	?>
    <tr bgcolor="#FFFFFF" > 
      <td height="20" align="center" valign="middle" <?php echo $disabled1;?>> 
        <input name="news<?php echo $i; ?>" type="checkbox" id="news<?php echo $i; ?>" value="<?php echo $N["sg_id"]; ?>" <?php if($pass_sub_a != "Y"){ echo "disabled"; } ?>> 
      </td>
      <td height="20" valign="top" > <?php echo $N["n_topic"]; ?> </td>
      <td height="20"><?php echo g_name($N["c_id"]); ?> <a href="#browse" title="เปลี่ยนกลุ่ม" onClick="win2 = window.open('article_select_share.php?cid=<?php echo $N["sg_id"]; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle" ></a></td>
      <td height="20" align="center" valign="top"><?php echo $date[2]."/".$date[1]."/".$date[0]; ?></td>
    </tr>
    <?php $i++; }}else{
	?>
    <tr bgcolor="#FFFFFF" > 
      <td height="20" colspan="4" align="center" valign="middle" >ไม่มีข้อมูล</td>
    </tr>
    <?php
	} ?>
    <input name="allx" type="hidden" id="allx" value="<?php echo $i; ?>">
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
