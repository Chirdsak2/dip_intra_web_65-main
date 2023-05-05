<?php
session_start();

ini_set("session.gc_maxlifetime", 60*60); 

include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" language="JavaScript1.2" src="../../js/stm31.js"></script>
<link href="../../css/style_content.css" rel="stylesheet" type="text/css">
<link href="css/style_calendar.css" rel="stylesheet" type="text/css">

<title>Preview</title>
<link href="css/normal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
</style>

</head>
<body  leftmargin="0" topmargin="0" <?php if($R["d_site_bg_c"] != ""){ echo "bgcolor=\"".$R["d_site_bg_c"]."\""; } ?> <?php if($R["d_site_bg_p"] != ""){ echo "background=\"userpic/".$R["d_site_bg_p"]."\""; } ?> >

<?php
$show="111";
$dis0='';
$dis1='';
$dis2='';

if($show[0]=='0'){$dis0="style=\"display:none\" ";}
if($show[1]=='0'){$dis1="style=\"display:none\" ";}
if($show[2]=='0'){$dis2="style=\"display:none\" ";}
?>
<table width="90%" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
<tr >
         <td <?php echo $dis0?>align="center" bgcolor="#FFECC6" background="../../images/../images/m_bg.gif">ข่าว/บทความ ยอดนิยม 5 อันดับ</td>
         <td <?php echo $dis1?>align="center" bgcolor="#FFECC6" background="../../images/../images/m_bg.gif">ข่าว/บทความ ที่มีคะแนนโหวตสูงสุด 5 อันดับ</td>
         <td <?php echo $dis2?>align="center" bgcolor="#FFECC6" background="../../images/../images/m_bg.gif">ข่าว/บทความ ใหม่อัพเดท 5 อันดับ</td>
</tr>
<tr>
         <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis0?>>
		 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="mytext_normal" bgcolor="#999999">
		 <tr bgcolor="#FFFFFF">   
			 <td align="center">อันดับ</td> 
			 <td align="center">หัวเรื่อง</td> 
			 <td align="center">ผู้เข้าชม</td>
		 </tr>
		 <?php
					            $sql ="SELECT  news_view.news_id, count(news_view.id_view) AS count_view, article_list.n_topic
													FROM article_list  INNER JOIN news_view ON (article_list.n_id = news_view.news_id)
													GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc limit 0,5";
								$query = $db->query($sql);
                                $num = $db->db_num_rows($query);
								while($rs = $db->db_fetch_array($query)){
								$i++;
								?><tr bgcolor="#FFFFFF">    
								         <td align="center" height="17"><?php echo $i?></td>
								         <td align="left"><a href="../../ewt/<?php echo $_SESSION["EWT_SUSER"]?>/ewt_news.php?nid=<?php echo $rs[news_id]?>"><?php echo $rs[n_topic]?></a></td>  
										  <td align="center"><?php echo $rs[count_view]?></td>
								   </tr><?php
								}
        ?>
				  </table>
            </td>
            <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis1?>>
				  
				  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="mytext_normal"  bgcolor="#999999">
					 <tr bgcolor="#FFFFFF">    
						 <td align="center">อันดับ</td> 
						 <td align="center">หัวเรื่อง</td> 
						 <td align="center">ระดับ</td>
					 </tr>
		 <?php

					            $sql ="SELECT sum(point)/count(news_id) as rating ,n_topic,news_id
											FROM  article_list  INNER JOIN news_vote ON (article_list.n_id = news_vote.news_id)
											GROUP BY  news_id
											ORDER BY rating DESC  limit 0,5";
								$query = $db->query($sql);
                                $num = $db->db_num_rows($query);
								$i=0;
								while($rs = $db->db_fetch_array($query)){
								$i++;
								?><tr bgcolor="#FFFFFF">   
								         <td align="center"><?php echo $i?></td>
								         <td align="left"><a href="../../ewt/<?php echo $_SESSION["EWT_SUSER"]?>/ewt_news.php?nid=<?php echo $rs[news_id]?>"><?php echo $rs[n_topic]?></a></td>  
										  <td align="left">
										   <?php 
											   $star=explode('.',number_format($rs[rating],1));
											   for($s=1;$s<=$star[0];$s++){?><img src="mainpic/star_yellow.gif"><?php }
											   if($star[1]>=5){?><img src="mainpic/half_star_yellow.gif"><?php };
									  		?>
										  </td>
								   </tr><?php
								}
        ?>
				  </table>
     </td>
	  <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis2?>>
				  
				  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="mytext_normal"  bgcolor="#999999">
					 <tr bgcolor="#FFFFFF">    
						 <td align="center">อันดับ</td> 
						 <td align="center">หัวเรื่อง</td> 
						 <td align="center">สถานะ</td>
					 </tr>
		 <?php

					            $sql ="SELECT n_id,n_topic,n_new_modi,n_last_modi FROM  article_list  ORDER BY  n_new_modi desc,n_last_modi desc limit 0,5";
								$query = $db->query($sql);
                                //$num = $db->db_num_rows($query);
								$i=0;
								while($rs = $db->db_fetch_array($query)){
								
								$i++;
								?><tr bgcolor="#FFFFFF">   
								         <td align="center"><?php echo $i?></td>
								         <td align="left"><a href="../../ewt/<?php echo $_SESSION["EWT_SUSER"]?>/ewt_news.php?nid=<?php echo $rs[n_id]?>"><?php echo $rs[n_topic]?></a></td>  
										  <td align="center">
										       <?php if($rs[n_new_modi]!=$rs[n_last_modi]){
											         ?><img src="../../ewt/<?php echo $_SESSION["EWT_SUSER"]?>/icon/update.gif"><?php
												}else{
												     ?><img src="../../ewt/<?php echo $_SESSION["EWT_SUSER"]?>/icon/new.gif"><?php
												}?></td>
								   </tr><?php
								}
        ?>
				  </table>
     </td>
   </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
