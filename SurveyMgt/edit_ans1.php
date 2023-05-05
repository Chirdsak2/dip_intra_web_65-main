<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");
$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name),p_ans.option3,p_ans.a_weight FROM p_ans,p_question WHERE p_question.c_id = '$path' AND p_question.q_id = p_ans.q_id  ORDER BY p_ans.option3");
?>
<html>

<head>
  <title>WebAdmin</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link href="txt.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0">
  <form name="form1" method="post" action="function_eqa.php"><br>

    <table width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt11">
      <tr bgcolor="B2B4BF">
        <td colspan="2">
          <div align="left"><strong>
              <font face="MS Sans Serif">
                <?php echo $lang_add_question_answerforpart; ?>
                <?php echo $post; ?>
              </font>
            </strong></div>
        </td>
        <!--<td>คะแนน/น้ำหนัก</td>-->
        <td>
          <div align="center">
            <font face="MS Sans Serif">
              <?php echo $lang_survey_rank; ?>
            </font>
          </div>
        </td>

        <td>
          <div align="center">
            <font face="MS Sans Serif">
              <?php echo $lang_survey_delete; ?>
            </font>
          </div>
        </td>
      </tr>
      <?php
      $i = 0;
      while ($Q = $db->db_fetch_array($SQL2)) { ?>
        <tr bgcolor="ECEBF0">
          <td width="30%">
            <div align="center">
              <font face="MS Sans Serif"><?php echo $lang_add_question_answerrank; ?>
                <?php echo $i + 1; ?>
              </font>
            </div>
          </td>
          <td width="53%">
            <font face="MS Sans Serif">
              <input name="an<?php echo $i; ?>" type="text" id="an<?php echo $i; ?>" value="<?php echo $Q[a_name]; ?>" size="40">
            </font>
          </td>
          <!--<td width="8%" align="center"><input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="<?php echo $Q[a_weight]; ?>" size="4"></td>-->
          <td width="9%" align="center">
            <font face="MS Sans Serif">
              <input name="pos<?php echo $i; ?>" type="text" id="pos<?php echo $i; ?>" value="<?php echo $Q[option3]; ?>" size="3">
            </font>
          </td>

          <td width="17%" align="center">
            <font face="MS Sans Serif">
              <input name="del<?php echo $i; ?>" type="checkbox" id="del<?php echo $i; ?>" value="Y">
            </font>
          </td>
        </tr>
      <?php
        $i++;
      }
      if ($next == "Y") {
      ?>
        <tr bgcolor="ECEBF0">
          <td width="30%">
            <div align="center">
              <font face="MS Sans Serif"><?php echo $lang_add_question_answerrank; ?>
                <?php echo $i + 1; ?>
              </font>
            </div>
          </td>
          <td width="53%">
            <font face="MS Sans Serif">
              <input name="an<?php echo $i; ?>" type="text" id="an<?php echo $i; ?>" value="<?php echo $Q[a_name]; ?>" size="40">
            </font>
          </td>
          <!--<td width="8%" align="center"><input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="0" size="4"></td>-->
          <td width="9%" align="center">
            <font face="MS Sans Serif">
              <input name="pos<?php echo $i; ?>" type="text" id="pos<?php echo $i; ?>" value="<?php echo $i; ?>" size="3">
            </font>
          </td>

          <td width="17%" align="center">&nbsp;</td>
        </tr>
      <?php $i++;
      } ?>
      <tr bgcolor="ECEBF0">
        <td bgcolor="B2B4BF">
          <div align="center">
            <font face="MS Sans Serif">
              <input type="button" name="Submit2" value="<?php echo $lang_edit_add_answer; ?>" onClick="window.location.href='edit_ans1.php?next=Y&post=<?php echo $post; ?>&path=<?php echo $path; ?>&type=<?php echo $type; ?>'">
            </font>
          </div>
        </td>
        <td colspan="4" bgcolor="B2B4BF">
          <div align="right">
            <font face="MS Sans Serif">
              <input name="post" type="hidden" id="post" value="<?php echo $post; ?>">
              <input name="type" type="hidden" id="type" value="<?php echo $type; ?>">
              <input name="path" type="hidden" id="path" value="<?php echo $path; ?>">
              <input name="all" type="hidden" id="num2" value="<?php echo $i; ?>">
              <input name="Flag" type="hidden" id="Flag" value="P">
              <input type="submit" name="Submit1" value="<?php echo $lang_survey_update; ?>">
              <input name="Submit" type="submit" value="<?php echo $lang_survey_save; ?>">
            </font>
          </div>
        </td>
      </tr>
    </table>
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


  function ChangeBox(c) {
    if (document.form1.sel.value == "D") {
      document.form1.num.disabled = true;
      document.form1.just.disabled = false;
    } else if (document.form1.sel.value == "B") {
      document.form1.just.disabled = true;
      document.form1.num.disabled = false;
    } else {
      document.form1.just.disabled = false;
      document.form1.num.disabled = false;
    }
  }
</script>
<?php @$db->db_close(); ?>