<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);


dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);

$USR_USERNAME       = $_SESSION['EWT_USERNAME'];
// $USR_USERNAME       = 'passakorn';
$PER_ID             = '';
$arr_payroll        = array();
$EncryptSal         = new encrypt_money();
$ID_CARD            = '';




$PERSON = dbdpis::getFetch("SELECT REPLACE(A.USR_OPTION3, '-', '') AS USR_OPTION3,B.PER_ID  FROM USR_MAIN A LEFT JOIN M_PER_PROFILE B ON REPLACE(A.USR_OPTION3, '-', '') = REPLACE(B.PER_IDCARD, '-', '') WHERE A.USR_USERNAME = '$USR_USERNAME' ");
$ID_CARD    = $PERSON['USR_OPTION3'];
$PER_ID     = $PERSON['PER_ID'];

$list = dbdpis::execute("SELECT * FROM PAYROLL A WHERE REPLACE(A.PER_IDCARD, '-', '') = '$ID_CARD' ORDER BY BG_YEAR DESC,BG_MONTH DESC");

?>

<link rel="stylesheet" href="assets/css/poll.css">

<div class="container mar-spacehead mb-5">

    <div>
        <!-- ส่วนของข้อมูลผู้ใช้ -->
        <div class="row">
            <div class="col">
            <h2 class="h2-color pt-4">
            <i class="fa fa-book" aria-hidden="true"></i> ข้อมูลการเงินและหนังสือรับรอง
        </h2>
            </div>
            <div class="col"> <h2 class="h2-color pt-4 text-right">รายได้สุทธิ</h2></div>
        </div>
        <hr class="hr_news mt-0">

        <!-- รายการ -->
        <div class="contaier-fluid">
            <div class="container">

                <?php while ($rec = dbdpis::Fetch($list)) { ?>
                    <div class="row">
                        <!-- Open รูปแบบ List รายการ -->
                        <div class="col-12">
                            <div class="mb-2 poll--card py-2">
                                <div class="float-left w-100">
                                    <a href="payroll_display.php?PER_ID=<?php echo $PER_ID; ?>&LOG_ID=<?php echo $rec['LOG_ID']; ?>" target="_blank" class="title-news font25px">
                                        <?php echo  dbdpis::getMonth($rec['BG_MONTH']) . " " . $rec['BG_YEAR']; ?>
                                    </a>
                                    <div style="float: right;"><?php echo number_format($EncryptSal->decode($rec['FINAL_MONEY']), 2); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>




            </div>
        </div>




    </div>
</div>




<?php include('footer.php'); ?>
<!-- Footer Website -->
<?php include('combottom.php'); ?>
<!-- Include file js and properties -->