<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");

$SQL1 = $db->query("SELECT * FROM p_question WHERE q_id = '{$qid}' ");
$PR = $db->db_fetch_array($SQL1);
$SQL2 = $db->query("SELECT * FROM p_ans WHERE q_id = '{$qid}' ORDER BY option3 ASC");
$row = $db->db_num_rows($SQL2);
?>

<html>

<head>
  <title>WebAdmin</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link href="txt.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0">
  <form name="form1" enctype="multipart/form-data" method="post" action="function_eqa.php" onSubmit="return GoNext();"><br>
    <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="txt11">
      <tr>
        <td bgcolor="B2B4BF">
          <font face="MS Sans Serif">
            <?php echo $lang_edit_ansitem; ?><?php echo $qname; ?>
            <select name="sel" id="sel" onChange="ChangeBox(this.value);">
              <option value="">กรุณาเลือกชนิดคำตอบ</option>
              <option value="A" <?php if ($PR[q_anstype] == "A") {
                                  echo "selected";
                                } ?>>เลือกได้คำตอบเดียว</option>
              <option value="B" <?php if ($PR[q_anstype] == "B") {
                                  echo "selected";
                                } ?>>เลือกได้หลายคำตอบ</option>
              <option value="C" <?php if ($PR[q_anstype] == "C") {
                                  echo "selected";
                                } ?>>Select Box</option>
              <option value="D" <?php if ($PR[q_anstype] == "D") {
                                  echo "selected";
                                } ?>>Text Box</option>
              <option value="E" <?php if ($PR[q_anstype] == "E") {
                                  echo "selected";
                                } ?>>Browse File</option>
              <option value="F" <?php if ($PR[q_anstype] == "F") {
                                  echo "selected";
                                } ?>>Calendar</option>
              <option value="G" <?php if ($PR[q_anstype] == "G") {
                                  echo "selected";
                                } ?>>Area</option>
            </select>
            <input name="Flag" type="hidden" value="A">
            <input name="qname" type="hidden" id="qname" value="<?php echo $qname; ?>">
            <input name="qid" type="hidden" id="qid" value="<?php echo $qid; ?>">
          </font>
        </td>
      </tr>
    </table>
    <table id="tb1" style="display:'<?php if ($PR[q_anstype] == "D" or $PR[q_anstype] == "E" or $PR[q_anstype] == "F" or $PR[q_anstype] == "G") {
                                      echo "none";
                                    } ?>'" width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt10">
      <tr bgcolor="B2B4BF">
        <td colspan="2">
          <font face="MS Sans Serif">&nbsp;</font>
        </td>
        <!-- <td align="center">คะแนน/น้ำหนัก</td> -->
        <!-- <td><div align="center"><font face="MS Sans Serif"><?php echo $lang_edit_default_answer; ?></font></div></td> -->
        <td>
          <div align="center">
            <font face="MS Sans Serif"><?php echo $lang_survey_rank; ?></font>
          </div>
        </td>
        <td>
          <div align="center">
            <font face="MS Sans Serif"><?php echo $lang_survey_delete; ?></font>
          </div>
        </td>
      </tr>
      <?php
      $i = 0;
      if (($PR[q_anstype] != "D" and $PR[q_anstype] != "E" and $PR[q_anstype] != "F" and $PR[q_anstype] != "G") and ($row > 0)) {
        echo "<div id=sho></div>";
        while ($R = $db->db_fetch_array($SQL2)) { ?>
          <tr bgcolor="ECEBF0">
            <td bgcolor="ECEBF0">
              <div align="center">
                <font face="MS Sans Serif"><?php echo $lang_edit_ansnumber; ?>
                  <?php echo $i + 1; ?>
                </font>
              </div>
            </td>
            <td width="53%">
              <font face="MS Sans Serif">
                <?php
                $answer_ex = explode("#@form#img@#", $R[a_name]);
                if ($answer_ex[1] != "") {
                  echo "<img src=\"../ewt/" . $_SESSION["EWT_SUSER"] . "/" . $answer_ex[1] . "\" width=\"50\" height=\"50\"><br>";
                }
                ?>
                <?php if ($PR[q_anstype] != "C") { ?><input type="file" name="file<?php echo $i; ?>">
                  <input type="hidden" name="pic<?php echo $i; ?>" value="<?php echo $answer_ex[1]; ?>">
                  <br>
                  <input type="checkbox" name="dpic<?php echo $i; ?>" value="<?php echo $answer_ex[1]; ?>"> <?php echo $lang_edit_delpic; ?><br><?php } ?>
                <input name="an<?php echo $i; ?>" type="text" id="an<?php echo $i; ?>" value="<?php echo $answer_ex[0]; ?>" size="35">
                <?php if ($PR[q_anstype] != "C") { ?><br>
                  <input name="ch<?php echo $i; ?>" type="checkbox" value="Y" <?php if ($R[a_other] == "Y") {
                                                                                echo "checked";
                                                                              } ?>>
                  <?php echo $lang_edit_type_other; ?> <?php } ?>
              </font>
            </td>
            <!-- <td align="center" bgcolor="ECEBF0"><input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="<?php echo $R[a_weight]; ?>" size="4"></td> -->
            <!-- <td align="center" bgcolor="ECEBF0"><font face="MS Sans Serif">  -->
            <!-- <input type="radio" name="defa" value="<?php echo $i + 1; ?>" <?php if ($R[option4] == "Y") {
                                                                                  echo "checked";
                                                                                } ?>> -->
            </font>
            </td>
            <td align="center" bgcolor="ECEBF0">
              <font face="MS Sans Serif">
                <input name="pos<?php echo $i; ?>" type="text" id="pos<?php echo $i; ?>" value="<?php echo $R[option3]; ?>" size="2">
              </font>
            </td>
            <td align="center" bgcolor="ECEBF0">
              <font face="MS Sans Serif">
                <input name="del<?php echo $i; ?>" type="checkbox" id="del<?php echo $i; ?>" value="Y">
              </font>
            </td>
          </tr>
        <?php $i++;
        }
      } else { ?>
        <tr bgcolor="ECEBF0" id="sho">
          <td colspan="6">
            <div align="center">
              <font color="#FF0000" face="MS Sans Serif"><?php echo $lang_edit_noans; ?></font>
            </div>
          </td>
        </tr>
      <?php
        $m = "Y";
      } ?>
      <tr bgcolor="ECEBF0" id="hid" style="display:none">
        <td bgcolor="ECEBF0">
          <div align="center">
            <font face="MS Sans Serif">
              <?php echo $lang_edit_ansnumber; ?>

              <?php echo $i + 1; ?>
            </font>
          </div>
        </td>
        <td bgcolor="ECEBF0">
          <font face="MS Sans Serif">
            <?php if ($PR[q_anstype] != "C") { ?><!--<input type="file" name="file<?php echo $i; ?>"><br>--><?php } ?>
            <input name="an<?php echo $i; ?>" type="text" id="an<?php echo $i; ?>" size="35">
            <?php if ($PR[q_anstype] != "C") { ?><br>
              <input name="ch<?php echo $i; ?>" type="checkbox" value="Y">
              <?php echo $lang_edit_type_other; ?><?php } ?>
          </font>
        </td>
        <!-- <td align="center" bgcolor="ECEBF0"><input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="0" size="4"></td> -->
        <!-- <td align="center" bgcolor="ECEBF0"><font face="MS Sans Serif"> 
        <input type="radio" name="defa" value="<?php echo $i + 1; ?>">
        </font></td> -->
        <td align="center" bgcolor="ECEBF0">
          <font face="MS Sans Serif">
            <input name="pos<?php echo $i; ?>" type="text" id="pos<?php echo $i; ?>" value="<?php echo $i; ?>" size="2">
          </font>
        </td>
        <td align="center" bgcolor="ECEBF0">
          <font face="MS Sans Serif">&nbsp;</font>
        </td>
      </tr>
      <tr bgcolor="ECEBF0">
        <td bgcolor="B2B4BF">
          <div align="center">
            <font face="MS Sans Serif">
              <input type="button" name="Submit3" value="<?php echo $lang_edit_add_answer; ?>" onClick="add1();">
              <input name="addf" type="hidden" id="addf">
            </font>
          </div>
        </td>
        <td colspan="5" bgcolor="B2B4BF">
          <div align="right">
            <font face="MS Sans Serif">
              <input name="FlagA" type="hidden" id="FlagA">
              <input name="all" type="hidden" id="all" value="<?php echo $i; ?>">
              <input name="SubmitX" type="submit" id="SubmitX" value="<?php echo $lang_survey_update; ?>" <?php if ($m == "Y") {
                                                                                                            echo "disabled";
                                                                                                          } ?>>
              <input name="SubmitY" type="submit" id="SubmitY" value="<?php echo $lang_survey_save; ?>" <?php if ($m == "Y") {
                                                                                                          echo "disabled";
                                                                                                        } ?>>
            </font>
          </div>
        </td>
      </tr>
    </table>
    <?php
    if ($PR[q_anstype] == "D" or $PR[q_anstype] == "E") {
      $PV = $db->db_fetch_array($SQL2);
    }
    ?>
    <!-- <table  id="tb2" style="display:'<?php if ($PR[q_anstype] != "D") {
                                            echo "none";
                                          } ?>'"  width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt10">
    <tr bgcolor="ECEBF0"> 
      <td width="27%" bgcolor="ECEBF0"> 
        <div align="left"><font face="MS Sans Serif"><?php echo $lang_edit_textbox; ?></font></div>
      </td>
      <td colspan="3"><font face="MS Sans Serif"> 
        <input type="radio" name="de" value="S" onClick="document.all.T2.style.display='<?php if ($PV[a_other] == "S") {
                                                                                          echo "none";
                                                                                        } ?>';document.all.T1.style.display='<?php if ($PV[a_other] != "S") {
                                                                                                                                echo "none";
                                                                                                                              } ?>';" <?php if ($PV[a_other] == "S") {
                                                                                                                                                                                  echo "checked";
                                                                                                                                                                                } ?>>
        <?php echo $lang_edit_singleline; ?><br>
        <input name="de" type="radio" value="M" onClick="document.all.T1.style.display='<?php if ($PV[a_other] == "S") {
                                                                                          echo "none";
                                                                                        } ?>';document.all.T2.style.display='<?php if ($PV[a_other] != "S") {
                                                                                                                                echo "none";
                                                                                                                              } ?>';" <?php if ($PV[a_other] != "S") {
                                                                                                                                                                                  echo "checked";
                                                                                                                                                                                } ?>>
        <?php echo $lang_edit_multiline; ?></font></td>
    </tr>
    <tr bgcolor="ECEBF0"> 
      <td> 
        <div align="left"><font face="MS Sans Serif"><?php echo $lang_survey_default; ?></font></div>
      </td>
      <td colspan="3"><font face="MS Sans Serif"> 
        <input name="def" type="text" id="def" value="<?php echo $PV[a_name]; ?>" size="40">
        </font></td>
    </tr>
    <tr id="T1" bgcolor="ECEBF0" style="display:'<?php if ($PV[a_other] == "S") {
                                                    echo "none";
                                                  } ?>'"> 
      <td><font face="MS Sans Serif">
        <?php echo $lang_edit_linenumber; ?>
        </font></td>
      <td width="24%"><font face="MS Sans Serif"> 
        <input name="line" type="text" id="line" value="<?php if ($PV[a_other] == "M") {
                                                          echo $PV[option3];
                                                        } ?>" size="3">
        <?php echo $lang_edit_line; ?></font></td>
      <td width="21%"><font face="MS Sans Serif"><?php echo $lang_edit_width; ?></font></td>
      <td width="28%"><font face="MS Sans Serif"> 
        <input name="wid1" type="text" id="wid1" value="<?php if ($PV[a_other] == "M") {
                                                          echo $PV[option4];
                                                        } ?>" size="3">
        <?php echo $lang_edit_character; ?>
        </font></td>
    </tr>
    <tr id="T2" bgcolor="ECEBF0" style="display:'<?php if ($PV[a_other] != "S") {
                                                    echo "none";
                                                  } ?>'"> 
      <td><font face="MS Sans Serif"><?php echo $lang_edit_maxchar; ?></font></td>
      <td width="24%"><font face="MS Sans Serif"> 
        <input name="wor" type="text" id="wor" value="<?php if ($PV[a_other] == "S") {
                                                        echo $PV[option3];
                                                      } ?>" size="3">
        <?php echo $lang_edit_character; ?>
        </font></td>
      <td width="21%"><font face="MS Sans Serif">
        <?php echo $lang_edit_width; ?>
        </font></td>
      <td width="28%"><font face="MS Sans Serif"> 
        <input name="wid2" type="text" id="wid2" value="<?php if ($PV[a_other] == "S") {
                                                          echo $PV[option4];
                                                        } ?>" size="3">
        <?php echo $lang_edit_character; ?>
        </font></td>
    </tr>
    <tr bgcolor="ECEBF0"> 
      <td colspan="4" bgcolor="B2B4BF"> 
        <div align="right"> <font face="MS Sans Serif"> 
          <input type="submit" name="Submit" value="<?php echo $lang_survey_save; ?>">
          <input name="reset" type="reset" value="<?php echo $lang_survey_reset; ?>">
          </font></div>
      </td>
    </tr>
  </table>  
  <table  id="tb3" style="display:'<?php if ($PR[q_anstype] != "E") {
                                      echo "none";
                                    } ?>'"  width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt10">
    <tr bgcolor="ECEBF0"> 
      <td width="27%" bgcolor="ECEBF0"> 
        <div align="left"><font face="MS Sans Serif">นามสกุลไฟล์ที่อนุญาตให้ Upload</font></div>      </td>
      <td width="73%"><font face="MS Sans Serif"> 
        <input name="stype" type="text" id="stype" value="<?php echo $PV[a_name] ?>" size="40">
      <br>
      ถ้ามีมากกว่า 1 ชนิดให้คั่นด้วยจุลภาค (,) เช่น ( doc,xls,jpg ) เป็นต้น</font></td>
    </tr>
    <tr bgcolor="ECEBF0"> 
      <td> 
        <div align="left"><font face="MS Sans Serif">ขนาดไฟล์ไม่เกิน</font></div>      </td>
      <td><input name="sdef" type="text" id="sdef" value="<?php echo $PV[a_other] ?>" size="6"> 
    KB. </td>
    </tr>
    <tr bgcolor="ECEBF0"> 
      <td colspan="2" bgcolor="B2B4BF"> 
        <div align="right"> <font face="MS Sans Serif"> 
          <input type="submit" name="Submit" value="<?php echo $lang_survey_save; ?>">
          <input name="reset" type="reset" value="<?php echo $lang_survey_reset; ?>">
          </font></div>      </td>
    </tr>
  </table>
  <table  id="tb4" style="display:'<?php if ($PR[q_anstype] != "F" and $PR[q_anstype] != "G") {
                                      echo "none";
                                    } ?>'"  width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt10">
    <tr bgcolor="ECEBF0"> 
      <td width="100%" bgcolor="B2B4BF"> 
        <div align="right"> <font face="MS Sans Serif"> 
          <input type="submit" name="Submit" value="<?php echo $lang_survey_save; ?>">
          </font></div>      </td>
    </tr>
  </table>-->
  </form>
</body>

</html>
<script language="JavaScript">
  function GoNext() {
    if (document.form1.name.value == "") {
      alert("<?php echo $lang_add3_pleasequestion; ?>");
      document.form1.name.focus();
      return false;
    }
  }

  function add1() {
    if (document.all.hid.style.display == "none") {
      document.all.hid.style.display = '';
      document.all.Submit3.disabled = true;
      document.form1.FlagA.value = "A";
      document.all.SubmitX.disabled = false;
      document.all.SubmitY.disabled = false;
      document.all.sho.style.display = 'none';
    }
  }

  function ChangeBox(c) {
    if (c == "D") {
      document.all.tb2.style.display = '';
      document.all.tb1.style.display = 'none';
      document.all.tb3.style.display = 'none';
      document.all.tb4.style.display = 'none';
    } else if (c == "F" || c == "G") {
      document.all.tb2.style.display = 'none';
      document.all.tb1.style.display = 'none';
      document.all.tb3.style.display = 'none';
      document.all.tb4.style.display = '';
    } else if (c == "E") {
      document.all.tb2.style.display = 'none';
      document.all.tb1.style.display = 'none';
      document.all.tb3.style.display = '';
      document.all.tb4.style.display = 'none';
    } else {
      document.all.tb1.style.display = '';
      document.all.tb2.style.display = 'none';
      document.all.tb3.style.display = 'none';
      document.all.tb4.style.display = 'none';
    }
  }
</script>
<?php @$db->db_close(); ?>