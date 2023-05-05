<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$filename_temp = "index";

$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$filename_temp."'  ");
$F = $db->db_fetch_array($sql_index);
$sql_article = $db->query("SELECT * FROM article_list WHERE n_id = '".$_GET["nid"]."'");
$RR= $db->db_fetch_array($sql_article);
$nid = $_GET["nid"];
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<title>Thank you</title></head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$filename_temp."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
		  $sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$filename_temp."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
          
    <td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"> 
     <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
        <tr> 
          <td height="10">
		  <br><br>
		  <?php
	 $sql_group ="select * from  article_group where c_id = '".$RR[c_id]."'";
	 $query_group = $db->query($sql_group);
	 $U = $db->db_fetch_array($query_group);
	 echo " <br><a href=\"index.php\">หน้าหลัก</a> >><a href=\"more_news.php?cid=".$RR[c_id]."&filename=index\"> ".$U[c_name]."</a>";
	 ?>

	<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td align="center"><b><?php echo $RR["n_topic"]; ?></b></td>
  </tr>
</table>

<table width="99%" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="3" valign="top"><?php if($RR["picture"] != ""){ ?>
<table width="50%" border="0" cellpadding="0" cellspacing="1" bgcolor="E0DFE3">
        <tr> 
          <td align="center" valign="middle" bgcolor="#FFFFFF" style="cursor:hand" onClick="win1=window.open('<?php if($RR["picture"] != ""){ echo "images/article/news".$nid."/".$RR["picture"]; }else{ echo "../../images/o.gif"; } ?>','','width=500,height=500,resizable=1,scrollbars=1');"><img src="<?php if($RR["picture"] != ""){ echo "images/article/news".$nid."/".$RR["picture"]; }else{ echo "../../images/o.gif"; } ?>" ></td>
        </tr>
      </table>
      <?php } ?>
     </tr>
</table>

      <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
          <td align="center"><b><?php echo $RR["n_des"]; ?></b></td>
        </tr>
      </table>
      <br> 
	  


      <?php
	$news_id = $_GET["nid"];	  
 	$ip_view = getenv("REMOTE_ADDR");
	$date_view = date("Y-m-d");
	$time_view = date("h:i:s");


	############ บันทึกข้อมูล ผู้ที่ทำการ vote #############
	if ($vote_status != "" && !session_is_registered("newsvote".$news_id)) {	
	 	$point = $vote_status;
		$sql_vote = "INSERT INTO news_vote(news_id,ip_vote,point) VALUE ('$news_id','$ip_view','$point')";
		$query_vote = mysql_query($sql_vote);			
		session_register("newsvote".$news_id);
		unset($vote_status);		
		$db->query("update  article_list set n_last_modi='".date('YmdHis')."' where n_id = '$news_id' ");
	}

	####### บันทึกข้อมูล ข้อมูลจำนวนคนเข้ามาอ่าน ###########
	if(!session_is_registered("newsvisit".$news_id)){
	$sql = "INSERT INTO news_view(news_id,ip_view,date_view,time_view) VALUE ('$news_id','$ip_view','$date_view','$time_view') ";
	$query = mysql_query($sql);	
	session_register("newsvisit".$news_id);
	}
	####### select ข้อมูลเพื่อดูจำนวนคนอ่าน ###############		
	$sql_view ="SELECT count(id_view) as count_view FROM news_view WHERE news_id LIKE '$news_id' ";
	$query_view = mysql_query($sql_view);
	$res_view = mysql_fetch_array($query_view);
	
	####### select ข้อมูลเพื่อดูจำนวนคน vote ###############		
	$sql_vote ="SELECT count(id_vote) as count_vote  FROM news_vote WHERE news_id LIKE '$news_id' ";
	$query_vote = mysql_query($sql_vote);
	$res_vote = mysql_fetch_array($query_vote);

	####### select ข้อมูลเพื่อดูสถานะการ vote ###############		
   $sql_status="SELECT point,count(id_vote) as count_vote  FROM news_vote where news_id='$news_id' GROUP BY point  order by point ";
   $query_status = mysql_query($sql_status);
   $rating=0;
   while($res_status=mysql_fetch_array($query_status)){
		  @$per_score[$res_status[point]]= number_format($res_status[count_vote]/$res_vote[count_vote]*100);
          $sum_score=$sum_score+$res_status[point]*$res_status[count_vote];
  }
 @$rating=$sum_score/$res_vote[count_vote];
/*
	$sql_status_Y ="SELECT count(id_vote) as count_vote  FROM news_vote WHERE news_id LIKE '$news_id' AND point = '1' GROUP BY point ";
	$query_status_Y = mysql_query($sql_status_Y);
	$res_status_y = mysql_fetch_array($query_status_Y);
	
	$sql_status_N ="SELECT count(id_vote) as count_vote  FROM news_vote WHERE news_id LIKE '$news_id' AND point = '0' GROUP BY point ";
	$query_status_N = mysql_query($sql_status_N);
	$res_status_N = mysql_fetch_array($query_status_N);

	$total = $res_vote[count_vote];	
	$per_Y =  @number_format(($res_status_y[count_vote]/$total)*100); 		
	$per_N =  @number_format(($res_status_N[count_vote]/$total)*100); 		
	*/
?>
      <a href="ewt_news_all.php">ข่าว/บทความ 5 อันดับสูงสุด</a> 
      <?php
$show="111";
$dis0='';
$dis1='';
$dis2='';

if($show[0]=='0'){$dis0="style=\"display:none\" ";}
if($show[1]=='0'){$dis1="style=\"display:none\" ";}
if($show[2]=='0'){$dis2="style=\"display:none\" ";}
?>
      <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">
        <tr > 
          <td <?php echo $dis0?>align="center" bgcolor="#FFECC6" background="../../images/../images/m_bg.gif">ข่าว/บทความ 
            ยอดนิยม 5 อันดับ</td>
          <td <?php echo $dis1?>align="center" bgcolor="#FFECC6" background="../../images/../images/m_bg.gif">ข่าว/บทความ 
            ที่มีคะแนนโหวตสูงสุด 5 อันดับ</td>
          <td <?php echo $dis2?>align="center" bgcolor="#FFECC6" background="../../images/../images/m_bg.gif">ข่าว/บทความ 
            ใหม่อัพเดท 5 อันดับ</td>
        </tr>
        <tr> 
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis0?>> 
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="mytext_normal" bgcolor="#FFFFFF">

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
                <td width="16" align="left"><img src="mainpic/bb1.jpg"  ></td>
                <td align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]?>"><?php echo $rs[n_topic]?></a></td>
              </tr>
              <?php
								}
        ?>
            </table></td>
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis1?>> 
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="mytext_normal"  bgcolor="#FFFFFF">
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
                <td width="16" align="left"><img src="mainpic/bb1.jpg"  ></td>
                <td align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]?>"><?php echo $rs[n_topic]?></a></td>
              </tr>
              <?php
								}
        ?>
            </table></td>
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis2?>> 
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="mytext_normal"  bgcolor="#FFFFFF">
             
              <?php

					            $sql ="SELECT n_id,n_topic,n_new_modi,n_last_modi FROM  article_list  ORDER BY  n_new_modi desc,n_last_modi desc limit 0,5";
								$query = $db->query($sql);
                                //$num = $db->db_num_rows($query);
								$i=0;
								while($rs = $db->db_fetch_array($query)){
								
								$i++;
								?>
              <tr align="left" valign="top" bgcolor="#FFFFFF"> 
                <td width="16" align="left"><img src="mainpic/bb1.jpg"  ></td>
                <td><a href="ewt_news.php?nid=<?php echo $rs[n_id]?>"><?php echo $rs[n_topic]?></a>
                </td>
              </tr>
              <?php
								}
        ?>
            </table></td>
        </tr>
      </table>
      <form name="form1" method="post" action="">
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr> 
            <td bgcolor="#FFECC6" background="../../images/../images/m_bg.gif"><?php print "จำนวนคนอ่าน $res_view[count_view] คน";?></td>
            <td align="right" bgcolor="#FFECC6" background="../../images/../images/m_bg.gif"><?php print  "จำนวนคนโหวต $res_vote[count_vote] คน";?></td>
          </tr>
          <tr> 
            <td width="50%" align="center" valign="top" bgcolor="#FFFFFF" ><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" class="mytext_normal">
                <tr> 
                  <td colspan="5" align="center"><?php print "โหวตคะแนนให้ข่าว/บทความนี้";?></td>
                </tr>
                <tr> 
                  <td align="center"><input name="vote_status" type="radio" value="1">
                    1</td>
                  <td align="center"><input name="vote_status" type="radio" value="2">
                    2</td>
                  <td align="center"><input name="vote_status" type="radio" value="3">
                    3</td>
                  <td align="center"><input name="vote_status" type="radio" value="4">
                    4</td>
                  <td align="center"><input name="vote_status" type="radio" value="5">
                    5</td>
                </tr>
                <tr> 
                  <td colspan="5" align="center" valign="middle"><input type="submit" name="Submit" value="โหวต" onClick=""></td>
                </tr>
              </table>
              <br></td>
            <td width="50%" align="center" valign="middle" bgcolor="#FFFFFF"> 
              <?php  if ($res_vote[count_vote] >0){  ?>
              <table width="80%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
                <tr bgcolor="#FFFFFF"> 
                  <td>&nbsp;&nbsp;ระดับ<br> &nbsp; 
                    <?php 
                               $star=explode('.',number_format($rating,1));
                               for($s=1;$s<=$star[0];$s++){?>
                    <img src="mainpic/star_yellow.gif">
                    <?php }
                               if($star[1]>=5){?>
                    <img src="mainpic/half_star_yellow.gif">
                    <?php };
                      ?>
                  </td>
                </tr>
              </table>
              <br> 
              <?php } ?>
              <table width="80%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
                <tr> 
                  <td bgcolor="#FFFFFF"> 
                    <?php 
				if ($res_vote[count_vote] >0){
				?>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <?php    for($p=1;$p<=5;$p++){  $per_score[$p]=$per_score[$p]*1;?>
                      <tr> 
                        <td colspan="2">&nbsp;&nbsp;ให้ <?php echo $p;?> คะแนน 
                        </td>
                        <td width="23%">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="6%">&nbsp;</td>
                        <td width="71%"> <table width="<?php echo  $per_score[$p] ."%"; ?>" height="10" border="0" cellpadding="0" cellspacing="0" bgcolor="#009900">
                            <tr> 
                              <td height="10"></td>
                            </tr>
                          </table></td>
                        <td width="23%" align="right">&nbsp;<?php echo  $per_score[$p]."%"; ?></td>
                      </tr>
                      <?php    } //end for($p=1;$p<$i;$p++) ?>
                    </table>
                    <?php }else{ ?>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td align="center">ไม่พบข้อมูลการโหวต</td>
                      </tr>
                    </table>
                    <?php } ?>
                  </td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form>
      <div id="show_comment"> 
        <?php
		   $sql_comment = "SELECT * FROM news_comment   news_id WHERE news_id LIKE '$news_id' AND status_comment LIKE 'Y' ORDER BY id_ans DESC";
		   $query_comment  = mysql_query($sql_comment);
		   $num_rows = mysql_num_rows($query_comment);
		   if ($num_rows >0){
					   while($res_comment = mysql_fetch_array($query_comment)){
					  ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr bgcolor="#E9E9E9" > 
            <td width="31%" align="left"><li>ความคิดเห็นที่ <?php print $res_comment[id_ans];?></li></td>
            <td width="69%" align="right" bgcolor="#E9E9E9" > <a href="#" onClick="window.open('comment_alt_del.php?id_ans=<?php echo $res_comment[id_ans]?>&news_id=<?php echo $news_id?>','','width=400 , height=200, location=0');" >แจ้งลบ 
              </a> </td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;<?php print $res_comment[comment];?></td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;<span style="color:#FF9900"><?php print $res_comment[name_comment];?></span></td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
        <?php
					  }//end while
		  }//end if  
  ?>
      </div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#E9E9E9"> 
          <td height="20" align="center" background="../../images/../images/m_bg.gif" bgcolor="#E9E9E9">แสดงความคิดเห็นเพิ่มเติม</td>
        </tr>
        <tr> 
          <td> <form name="form2" method="post" action="">
              <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
                <tr> 
                  <td><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#F4F4F4">
                      <tr> 
                        <td width="36%" align="right">ชื่อ ของคุณ :</td>
                        <td width="64%" align="left"><input type="text" name="textfield" id="name_comment"> 
                          <span class="style2">*</span> </td>
                      </tr>
                      <tr> 
                        <td align="right" valign="top">ความคิดเห็น :</td>
                        <td align="left" valign="top" nowrap><textarea name="textarea" cols="40" rows="4" id="detail"></textarea> 
                          <span class="style2">*</span></td>
                      </tr>
                      <tr> 
                        <td colspan="2" align="center"><label> 
                          <input type="button" name="button" value="ส่งความคิดเห็น" onClick="chk_comment();">
                          </label></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>
		  </td>
        </tr>
      </table>
</td>
          <td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
		  $sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$filename_temp."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$filename_temp."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>
