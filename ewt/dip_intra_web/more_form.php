<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php

dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);
// $s_search = '';
// $a_survey = survey::getSurveyListLimit($s_search, E_SYS_PAGE, E_SYS_LIMIT);
// $a_countItem = survey::getSurveyListLimit($s_search, '', '');
// $_sql     = "SELECT * FROM " . E_DB_NAME . ".p_survey WHERE s_approve = 'Y'  ORDER BY s_id DESC {$lim} ";
// $a_row    = db::getRowCount($_sql);
// $a_data = db::getFetchAll($_sql, PDO::FETCH_ASSOC);
// $_sql     = "SELECT s_id FROM " . E_DB_NAME . ".p_survey WHERE s_approve = 'Y' ";
// $a_row_all    = db::getRowCount($_sql);
$sql_sur = "SELECT * FROM M_QUESTIONNAIR WHERE QUES_STATUS = '1'";
$row_sql = "SELECT QUESTIONNAIR_ID FROM M_QUESTIONNAIR WHERE QUES_STATUS = '1'";
$a_row_all = dbdpis::getRowCount($row_sql);
// $a_row = dbdpis::getRowCount($sql_sur);
$a_data = dbdpis::getFetchAll($sql_sur);
// print_r($a_data);

?>
<!-- Close Top -->
<link rel="stylesheet" href="assets/css/poll.css">

<div class="container-fluid mar-t-90px header--bg">
    <div class="container py-5 text-center">
        <h3> แบบสอบถาม </h3>
    </div>
</div>


<!-- Open News -->
<div class="contaier-fluid">
    <div class="container">
        <div class="row mb-5 mt-5">
            <!-- Open รูปแบบ List รายการ -->
            <?php if ($a_data) { ?>
                <?php foreach ($a_data as $_item) { ?>
                    <div class="col-12">
                        <div class="mb-2 poll--card py-2">
                            <div class="float-left">
                                <a href="<?php echo $_item["QUES_LINK"]; ?>" class="title-news font25px">
                                    <em class="fas fa-poll-h pr-1 pl-2 pt-2 font35px"></em>
                                    <?php echo strip_tags($_item['QUES_NAME']); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

           

            <?php  echo pagination_ewt('more_form.php', '', E_SYS_PAGE, E_SYS_LIMIT, $a_row_all); ?>
        </div>
    </div>
</div>
<!-- Close News -->

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->

