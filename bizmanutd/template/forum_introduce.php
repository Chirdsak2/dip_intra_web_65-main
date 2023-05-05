<table width="820" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#006699">
              <tr>
                <td width="801" height="23">&nbsp;</td>
                <td width="11"><div align="right"><img src="mainpic/content_r2_c4.gif" width="10" height="23" /></div></td>
              </tr>
            </table>
                    <!--#F4F4F4-->
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="#006699">
                      <tr>
                        <td colspan="2" width="100%" valign="top" class="text11" bgcolor="white"><!--Content-->
                            <table width="0" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><!--detail-->
                                    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                                      <tr>
                                        <td align="center"><table width="720" border="0" align="left" cellpadding="3" cellspacing="2">
                                            <tr>
                                              <td colspan="4" valign="top"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                                                  <tr>
                                                    <td valign="center" class="text9"><h4><strong><font color="006699">&#3585;&#3619;&#3632;&#3607;&#3641;&#3657;&#3649;&#3609;&#3632;&#3609;&#3635;</font></strong></h4></td>
                                                  </tr>
                                              </table></td>
                                            </tr>
                                            <tr>
                                              <td align="center" bgcolor="ffffff">&nbsp;</td>
                                              <td align="center" bgcolor="ffffff">&nbsp;</td>
                                              <td width="55" align="center" bgcolor="ffffff">&#3629;&#3656;&#3634;&#3609;</td>
                                              <td width="40" align="center" bgcolor="ffffff">&#3605;&#3629;&#3610;</td>
                                            </tr>
                                            <tr>
                                              <td colspan="4" bgcolor="ffffff"><hr size="1" color="eeeeee" /></td>
                                            </tr>
                                            
											<?php
											$sql = $db->query("SELECT * FROM w_question ");
											while($rec = $db->db_fetch_array($sql)){
											$count = $db->query("SELECT * FROM w_answer WHERE t_id = '$rec[t_id]' AND s_id = '1' ORDER BY a_id DESC");
   											$countrow = mysql_num_rows($count);
											$timer = explode("-",$rec[t_date]); $YearT = $timer[0]+543;
											?>
                                            <tr>
                                              <td  width="22" valign="top"><img src="mainpic/magic-wand2.gif"></td>
                                              <td valign="top"><a href="index_answer.php?wcad=<?php echo $rec[c_id]; ?>&wtid=<?php echo $rec[t_id]; ?>" target="_blank"><?php  echo stripslashes($rec[t_name]); ?></a> <br>by:<?php  echo stripslashes($rec[q_name]); ?> &nbsp;&nbsp;date - time :<?php echo $timer[2]."/".$timer[1]."/".$YearT."-".$rec[t_time]; ?></td>
                                              <td align="center" valign="top"><?php  echo stripslashes($rec[t_count]); ?></td>
                                              <td align="center" valign="top"> <?php echo $countrow;?></td>
                                            </tr>
                                            <tr>
                                              <td colspan="4" bgcolor="ffffff" height="3"><hr size="1" color="eeeeee" /></td>
                                            </tr>
											<?php } ?>
                                        </table></td>
                                      </tr>
                                    </table>
                                  <!--detail-->
                                </td>
                              </tr>
                            </table>
                          <!--Content-->
                        </td>
                      </tr>
                  </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
