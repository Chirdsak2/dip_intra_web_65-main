<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");
?>
<html>

<head>
  <title>WebAdmin</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<script language=JavaScript src='../ewt/scripts/innovaeditor.js'></script>
<script language="JavaScript" src="date-picker.js"></script>

<body leftmargin="0" topmargin="0">
  <form name="form1" method="post" action="function_qa.php" onSubmit="return GoNext();"><br>
    <?php if ($type == "N") { ?>
      <table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse">
        <tr bgcolor="B2B4BF" height="30" class="ewttablehead">
          <td colspan="2">
            <div align="center"><strong>
                <font face="MS Sans Serif"><?php echo $lang_add_question_createquestion; ?>
                  <?php echo $post; ?>
                </font>
              </strong></div>
          </td>
        </tr>
        <tr bgcolor="ECEBF0" height="25">
          <td width="15%" bgcolor="ECEBF0">
            <div align="right">
              <font face="MS Sans Serif"><?php echo $lang_add_question_questionnumber; ?></font>
            </div>
          </td>
          <td width="85%" bgcolor="ECEBF0">
            <font face="MS Sans Serif">
              <input name="ch" type="text" id="ch" size="5">
            </font>
          </td>
        </tr>
        <tr bgcolor="ECEBF0">
          <td valign="top">
            <div align="right">
              <font face="MS Sans Serif">
                <?php echo $lang_add_question_question; ?>
              </font>
            </div>
          </td>
          <td>
            <textarea name="name" cols="40" rows="10" wrap="VIRTUAL" id="name"></textarea>
            <script>
              var oEdit1 = new InnovaEditor("oEdit1");

              oEdit1.width = "100%";
              oEdit1.height = "200";
              oEdit1.tabs = [
                ["tabHome", "", ["grpFont", "grpPara"]]
              ];

              oEdit1.groups = [
                ["grpFont", "", ["FontName", "FontSize", "BRK", "Bold", "Italic", "Underline", "Strikethrough", "Superscript", "Subscript", "ForeColor", "BackColor"]],
                ["grpPara", "", ["Paragraph", "Indent", "Outdent", "LTR", "RTL", "BRK", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyFull", "Numbering", "Bullets", "XHTMLSource"]]
              ];
              oEdit1.mode = "HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"

              oEdit1.REPLACE("name");
            </script>
          </td>
        </tr>
        <tr bgcolor="ECEBF0" height="25">
          <td>
            <div align="right">
              <font face="MS Sans Serif"><?php echo $lang_add_question_answertype; ?></font>
            </div>
          </td>
          <td>
            <select name="sel" id="sel" onChange="ChangeBox('<?php echo $i; ?>');">
              <option value="">กรุณาเลือกชนิดคำตอบ</option>
              <option value="A">เลือกได้คำตอบเดียว</option>
              <option value="B">เลือกได้หลายคำตอบ</option>
              <option value="C">List Box</option>
              <option value="D">Text Box</option>
              <option value="E">Browse File</option>
              <option value="F">Calendar</option>
              <option value="G">Area</option>
            </select>
          </td>
        </tr>
        <tr bgcolor="ECEBF0" height="25">
          <td>
            <div align="right">
              <font face="MS Sans Serif"><?php echo $lang_add_question_answerhowmany; ?></font>
            </div>
          </td>
          <td>
            <font face="MS Sans Serif">
              <input name="num" type="text" id="num" value="2" size="5">
            </font>
          </td>
        </tr>
        <tr bgcolor="ECEBF0" height="25">
          <td width="15%" bgcolor="ECEBF0">
            <div align="right">
              <font face="MS Sans Serif"><?php echo $lang_add_question_rank; ?></font>
            </div>
          </td>
          <td width="85%" bgcolor="ECEBF0">
            <font face="MS Sans Serif">
              <input name="pos" type="text" id="pos" value="<?php echo $pos; ?>" size="5">
            </font>
          </td>
        </tr>
        <tr bgcolor="ECEBF0" height="25">
          <td>
            <div align="right">
              <font face="MS Sans Serif">
                <input name="just" type="checkbox" id="just" value="Y">
              </font>
            </div>
          </td>
          <td>
            <font face="MS Sans Serif"><?php echo $lang_add_question_require; ?></font>
          </td>
        </tr>
        <tr bgcolor="ECEBF0" id="email_tr" style="display:none" height="25">
          <td>&nbsp; </td>
          <td><input name="email_data" type="radio" id="email_data" value="" checked="checked"> ข้อมูลตัวอักษรทั่วไป <input name="email_data" type="radio" id="email_data" value="Y"> ข้อมูลรูปแบบ email <input name="email_data" type="radio" id="email_data" value="N"> ข้อมูลรูปแบบตัวเลข<br>
            <input type="checkbox" name="no_replate" value="QNR">
            ไม่ต้องการให้ข้อมูลซ้ำ
          </td>
        </tr>

        <tr bgcolor="ECEBF0" height="25">
          <td>
            <font face="MS Sans Serif">&nbsp;</font>
          </td>
          <td>
            <font face="MS Sans Serif">
              <input type="submit" name="Submit" value="<?php echo $lang_survey_save; ?>">
              <input name="Flag" type="hidden" id="Flag" value="Q">
              <input name="path" type="hidden" id="path" value="<?php echo $path; ?>">
            </font>
          </td>
        </tr>
      </table>
    <?php } elseif ($type == "Y") { ?>
      <table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse">
        <tr bgcolor="B2B4BF" height="30" class="ewttableuse">
          <td colspan="2">
            <div align="center"><strong>
                <font face="MS Sans Serif"><?php echo $lang_add_question_createquestion; ?>
                  <?php echo $post; ?>
                </font>
              </strong></div>
          </td>
        </tr>
        <tr bgcolor="ECEBF0" height="25">
          <td width="15%" bgcolor="ECEBF0">
            <div align="right">
              <font face="MS Sans Serif">
                <?php echo $lang_add_question_questionnumber; ?>
              </font>
            </div>
          </td>
          <td width="85%" bgcolor="ECEBF0">
            <font face="MS Sans Serif">
              <input name="ch" type="text" id="ch" size="5">
            </font>
          </td>
        </tr>
        <tr bgcolor="ECEBF0">
          <td valign="top">
            <div align="right">
              <font face="MS Sans Serif">
                <?php echo $lang_add_question_question; ?>
              </font>
            </div>
          </td>
          <td>
            <textarea name="name" cols="40" rows="10" wrap="VIRTUAL" id="name"></textarea>
            <script>
              var oEdit1 = new InnovaEditor("oEdit1");

              oEdit1.width = "100%";
              oEdit1.height = "200";
              oEdit1.tabs = [
                ["tabHome", "", ["grpFont", "grpPara"]]
              ];

              oEdit1.groups = [
                ["grpFont", "", ["FontName", "FontSize", "BRK", "Bold", "Italic", "Underline", "Strikethrough", "Superscript", "Subscript", "ForeColor", "BackColor"]],
                ["grpPara", "", ["Paragraph", "Indent", "Outdent", "LTR", "RTL", "BRK", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyFull", "Numbering", "Bullets", "XHTMLSource"]]
              ];
              oEdit1.mode = "HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"

              oEdit1.REPLACE("name");
            </script>
          </td>
        </tr>
        <tr bgcolor="ECEBF0" height="25">
          <td width="15%" bgcolor="ECEBF0">
            <div align="right">
              <font face="MS Sans Serif">
                <?php echo $lang_add_question_rank; ?>
              </font>
            </div>
          </td>
          <td width="85%" bgcolor="ECEBF0">
            <font face="MS Sans Serif">
              <input name="pos" type="text" id="pos" value="<?php echo $pos; ?>" size="5">
            </font>
          </td>
        </tr>
        <tr bgcolor="ECEBF0" height="25">
          <td>
            <div align="right">
              <font face="MS Sans Serif">
                <input name="just" type="checkbox" id="just" value="Y">
              </font>
            </div>
          </td>
          <td>
            <font face="MS Sans Serif">
              <?php echo $lang_add_question_require; ?>
            </font>
          </td>
        </tr>
        <?php
        $SQL3 = $db->query("SELECT * FROM p_question WHERE c_id = '$path'");
        $row = $db->db_num_rows($SQL3);
        if ($row == 0) { ?>
          <tr bgcolor="B2B4BF" height="25">
            <td>
              <font face="MS Sans Serif">&nbsp;</font>
            </td>
            <td>
              <font face="MS Sans Serif">
                <?php echo $lang_add_question_answerforpart; ?>
                <?php echo $post; ?>
              </font>
            </td>
          </tr>
          <?php $SQL2 = $db->query("SELECT * FROM p_cate WHERE c_id = '$path'");
          $R = $db->db_fetch_array($SQL2);
          for ($i = 0; $i < $R[option2]; $i++) {
          ?>
            <tr bgcolor="ECEBF0" height="25">
              <td>
                <div align="right">
                  <font face="MS Sans Serif"><?php echo $lang_add_question_answerrank; ?>
                    <?php echo $i + 1; ?>
                  </font>
                </div>
              </td>
              <td>
                <font face="MS Sans Serif">
                  <input name="ans<?php echo $i; ?>" type="text" id="ans<?php echo $i; ?>" size="40">
                  <!-- คะแนน/น้ำหนัก <input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="0" size="4">  -->

                </font>
              </td>
            </tr>
        <?php
          }
        }
        ?>
        <tr bgcolor="ECEBF0" height="25">
          <td>
            <font face="MS Sans Serif">&nbsp;</font>
          </td>
          <td>
            <font face="MS Sans Serif">
              <input type="submit" name="Submit" value="<?php echo $lang_survey_save; ?>">
              <input name="Flag" type="hidden" id="Flag" value="B">
              <input name="path" type="hidden" id="path" value="<?php echo $path; ?>">
              <input name="all" type="hidden" id="all" value="<?php echo $R[option2]; ?>">
            </font>
          </td>
        </tr>
      </table>
      <br>
    <?php } ?>
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
      document.getElementById('email_tr').style.display = '';
    } else if (document.form1.sel.value == "G") {
      document.form1.num.disabled = true;
      document.form1.just.disabled = false;
      document.getElementById('email_tr').style.display = 'none';
    } else if (document.form1.sel.value == "F") {
      document.form1.num.disabled = true;
      document.form1.just.disabled = false;
      document.getElementById('email_tr').style.display = 'none';
    } else if (document.form1.sel.value == "E") {
      document.form1.num.disabled = true;
      document.form1.just.disabled = false;
      document.getElementById('email_tr').style.display = 'none';
    } else if (document.form1.sel.value == "B") {
      document.form1.just.disabled = false;
      document.form1.num.disabled = false;
      document.getElementById('email_data').checked = false;
      document.getElementById('email_tr').style.display = 'none';
    } else {
      document.getElementById('email_data').checked = false;
      document.getElementById('email_tr').style.display = 'none';
      document.form1.just.disabled = false;
      document.form1.num.disabled = false;
    }
  }
</script>
<?php @$db->db_close(); ?>