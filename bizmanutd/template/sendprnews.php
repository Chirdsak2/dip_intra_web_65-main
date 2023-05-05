<?php
session_start();
include("../../lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
			function LooPDel($p){
					$dir=@opendir($p);
					//echo $p;
					while($data=@readdir($dir)){
						if(($data!=".")and($data!="..")and($data!="")){
							if(!@unlink($p."/".$data)){
								LooPDel($p."/".$data);
							}
						}
					}
					@closedir($dir);
					@rmdir($p);
			}
if($_GET["flag"] == 'delpr'){
				$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '".$_GET["nid"]."' ");
				$R = $db->db_fetch_array($sql_edit);
				$cid=$R[c_id];
				$db->query("DELETE FROM article_list WHERE n_id = '".$_GET["nid"]."'");
				$db->query("DELETE FROM article_detail WHERE n_id = '".$_GET["nid"]."'");
			
				if($R[news_use] == '1'){
					$rest = substr($R[link_html], 0, 7);
					if($rest == "http://"){
					}else{
						@unlink("images/article/freetemp/".$R[link_html]);
					}
			
				}else if($R[news_use] == '2' || $R[news_use] == '3'){
					$path = "images/article";
					if(!@rmdir($path."/news".$chk)){

					}
					LooPDel($path."/news".$chk);
					$pathall = "article/TEMP".$chk.".tmp";
					@unlink($pathall);
				}
			?>
			<script language="javascript">
				self.location.href = "sendprnews.php";
			</script>
		<?php
}
?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript">
function ChkMessage(f){
	if (f.mto.value=='' || f.mto.value==0){
	  alert("กรุณาเลือก ผู้รับ");
	} else if (f.m_subject.value==''){
	  alert("กรุณากรอก Subject");
	  f.m_subject.focus();
	}else {
	  return true;
	}
	return false;
}
	function checkfeeall(totalrec){
		if(document.getElementById('chkfeeall').checked == true){
			for(i=1; i<=totalrec.value; i++){
				document.getElementById("chkfee"+i).checked=true;		
			}
		}else{
			for(i = 1; i<=totalrec.value;i++){
				document.getElementById("chkfee"+i).checked=false;
			}
		}
	}
	function checkfeeeach(totalrec){
		var num = 0
		for(i = 1; i<=totalrec.value;i++){
			if(document.getElementById("chkfee"+i).checked==true){
				num = num+1
			}
		}
		if(num==totalrec.value){
			document.getElementById('chkfeeall').checked = true;
		}else{
			document.getElementById('chkfeeall').checked = false;
		}
	}	
function chkchecked(maxx){
    if(maxx==0) {
        alert('กรุณาเลือกรายการที่ต้องการลบ');
		return false; 
   }else {
         return true;
   }
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" >
<table width="110%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><br>
                  <table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666">ระบบฝากข่าวประชาสัมพันธ์</font></strong></font><br />
					<hr>
					  <img src="mainpic/bl_orange.gif">&nbsp;<a href="sendprnews_add.php" >เพิ่มการฝากข่าวประชาสัมพันธ์ใหม่</a> </td>
                    </tr>
                  </table>
                  <br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td height="447" valign="top">
		<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
		  <tr>
			<td valign="top" >
            <!--gggg-->
					<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
					  <tr>
						<td width="5%" align="center" bgcolor="#CCCCCC"><strong>No.</strong></td>
						<td width="10%" align="center" bgcolor="#CCCCCC"><strong>วันที่</strong></td>
						<td width="55%" align="center" bgcolor="#CCCCCC"><strong>หัวข้อข่าว/บทความ</strong></td>
						<td width="20%" align="center" bgcolor="#CCCCCC"><strong>สถานะ</strong></td>
						<td width="10%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
					  </tr>
					  <?php
					  $i=1;
					  $sql = "select * from article_list inner join article_group_module on  article_list.c_id = article_group_module.c_id where n_owner = '".$_SESSION["EWT_MID"]."' order by  n_timestamp DESC";
					  $query = $db->query($sql);
					 $num = $db->db_num_rows($query);
					  if($num > 0){
					  while($N = $db->db_fetch_array($query)){
					  $date = explode("-",$N["n_date"]);
					  $path_news="";
						if($N["news_use"] == "2" OR $N["news_use"] == "3" OR $N["news_use"] == "4"){
								$path_news= "ewt_news.php?nid=".$N["n_id"] ;
						}else{
								if(eregi('http://',$N["link_html"])){
									  $path_news= $N["link_html"];
								}else{
									 $path_news= $N["link_html"];
								}
						}
					  ?>
					  <tr>
						<td align="center" bgcolor="#FFFFFF"><?php echo $i; ?></td>
						<td bgcolor="#FFFFFF"><?php echo $date[2]."/".$date[1]."/".$date[0]; ?></td>
						<td bgcolor="#FFFFFF"><?php echo $N["n_topic"]; ?></td>
						<td align="center" bgcolor="#FFFFFF"> <?php if($N["n_approve"]=='Y'){ echo 'อนุมัติแล้ว'; }else { echo 'รอตรวจสอบ'; } ?></td>
						<td bgcolor="#FFFFFF"><a href="#view" onClick="window.open('<?php echo $path_news; ?>');">  <img src="mainpic/document_view.gif" width="20" height="20" border="0" alt="ดู"></a>&nbsp;&nbsp;&nbsp;
						<?php if($N["n_approve"]!='Y'){?>
						<a href="sendprnews.php?flag=delpr&nid=<?php echo $N["n_id"]; ?>"><img src="mainpic/b_delete.gif" width="14" height="14"  border="0" alt="ลบ" onClick="return confirm('Are you sure to delete selected article?');"></a>
						<?php } ?>						</td>
					  </tr>
					  <?php 
					  		$i++;
					  	} 
					  }
					  if($num == 0){
					  ?>
					  <tr>
						<td colspan="5" align="center" bgcolor="#FFFFFF"><span class="style1">ไม่พบรายการ</span></td>
						</tr>
					  <?php } ?>
					</table>
				<!--ggg-->
			  </td>
		  </tr>
		</table>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Page : 1
	</td>
  </tr>
</table>
                </td>
              </tr>
            </table></td>
          <td width="5" height="100%" background="mainpic/bg_r.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>

</body>
</html>
<?php  $db->db_close(); ?>
