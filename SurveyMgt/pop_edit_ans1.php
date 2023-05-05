<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");
include("lang_config.php");

$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name),p_ans.option3,p_ans.a_weight 
FROM p_ans,p_question 
WHERE p_question.c_id = '$path' AND p_question.q_id = p_ans.q_id  
ORDER BY p_ans.option3 ASC");

?>
<div class="dContainer">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#box_popup').fadeOut();">&times;</button>
        <h4 class="modal-title"><?= $lang_add_question_answerforpart; ?> <?= $post; ?></h4>
      </div>

      <form name="form1" method="post">
        <div class="modal-body">
          <div class="scrollbar scrollbar-near-moon thin">


            <table class="table table-bordered">
              <thead>
                <tr class="info">
                  <th width="55%" class="text-center"></th>
                  <th width="15%" class="text-center">คะแนน/น้ำหนัก</th>
                  <th width="15%" class="text-center"><?= $lang_survey_rank; ?></th>
                  <th width="15%" class="text-center"><?= $lang_survey_delete; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                while ($Q = $db->db_fetch_array($SQL2)) {
                ?>
                  <tr>
                    <td>
                      <div class="form-inline">
                        <label for="an<?= $i; ?>"><?= $lang_add_question_answerrank; ?> <?= $i + 1; ?> : </label>
                        <input name="an<?= $i; ?>" class="form-control" type="text" id="an<?= $i; ?>" value="<?= $Q['a_name']; ?>">
                      </div>
                    </td>
                    <td class="text-center"><input name="weight<?= $i; ?>" class="form-control" type="text" id="weight<?= $i; ?>" value="<?= $Q['a_weight']; ?>" size="4"></td>
                    <td class="text-center"><input name="pos<?= $i; ?>" class="form-control" type="text" id="pos<?= $i; ?>" value="<?= $Q['option3']; ?>" size="3"></td>
                    <td class="text-center"><input name="del<?= $i; ?>" type="checkbox" id="del<?= $i; ?>" value="Y"></td>
                  </tr>
                <?php
                  $i++;
                } ?>
              </tbody>
            </table>


            <div class="form-group row">
              <div class="col-md-12 col-sm-12 col-xs-12">

              </div>
            </div>


            <input name="post" type="hidden" id="post" value="<?= $post; ?>">
            <input name="type" type="hidden" id="type" value="<?= $type; ?>">
            <input name="path" type="hidden" id="path" value="<?= $path; ?>">
            <input name="all" type="hidden" id="num2" value="<?= $i; ?>">
            <input name="Flag" type="hidden" id="Flag" value="P">

          </div>
        </div>
      </form>

      <div class="modal-footer">
        <div class="form-group row">
          <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
            <button onclick="JQEdit_Question();" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?= $lang_survey_save; ?>">
              <span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?= $lang_survey_save; ?>
            </button>
            <!--<input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
            <input name="reset" type="reset" value="ยกเลิก" class="btn btn-warning"  onClick="$('#box_popup').fadeOut();">
            <button class="btn btn-warning btn-lm" onClick="$('#box_popup').fadeOut();" data-toggle="tooltip" data-placement="top" title="<?= $lang_survey_update; ?>" >
            <span class="glyphicon glyphicon-remove"></span>&nbsp;<?= "ยกเลิก"; ?>-->
            </button>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>






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
        <td>คะแนน/น้ำหนัก</td>
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
          <td width="8%" align="center"><input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="<?php echo $Q[a_weight]; ?>" size="4"></td>
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
          <td width="8%" align="center"><input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="0" size="4"></td>
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


<script>
  $(document).ready(function() {

    $('.numberint').keypress(function(event) {
      return isNumberInt(event, this)
    });

  });

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