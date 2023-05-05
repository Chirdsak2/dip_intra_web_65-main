<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?><br>
<table width="98%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">
  <tr> 
    <td width="50%" align="center" valign="top" bgcolor="#FFFFFF"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="mytext_normal"  bordercolor="#cccccc">
        <tr align="center" bgcolor="#FFFFFF"> 
          <td colspan="2" background="../../images/../images/m_bg.gif" bgcolor="#FFECC6" <?php echo $dis0?>align="center"><strong>ข่าว/บทความยอดนิยม 
            5 อันดับ</strong></td>
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
								?>
        <tr valign="top" bgcolor="#FFFFFF"> 
          <td width="10%" align="right"><img src="mainpic/bb1.jpg"></td>
          <td width="90%" align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]?>" target="_blank"><?php echo $rs[n_topic]?></a></td>
        </tr>
        <?php
								}
        ?>
      </table></td>
    <td width="50%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis1?>> 
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="mytext_normal"   bordercolor="#cccccc">
        <tr bgcolor="#FFFFFF"> 
          <td <?php echo $dis1?> colspan="2" align="center" bgcolor="#FFECC6" background="../../images/../images/m_bg.gif"><strong>ข่าว/บทความ 
            ที่มีคะแนนโหวตสูงสุด 5 อันดับ</strong></td>
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
								?>
        <tr valign="top" bgcolor="#FFFFFF"> 
          <td width="10%" align="right"><img src="mainpic/bb1.jpg"></td>
          <td width="90%" align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]?>" target="_blank"><?php echo $rs[n_topic]?></a></td>
        </tr>
        <?php
								}
        ?>
      </table></td>
  </tr>
</table>
<?php $db->db_close(); ?>
