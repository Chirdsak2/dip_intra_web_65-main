<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php //include('header.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);


$EncryptSal = new encrypt_money();

dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);

$PER_ID             = $_GET['PER_ID'];
$LOG_ID             = $_GET['LOG_ID'];
$USR_USERNAME       = $_SESSION['EWT_USERNAME'];
$arr_payroll        = array();
$arr_list_income    = array();
$arr_list_pay       = array();


$GET_PERID = dbdpis::getFetch("SELECT B.PER_ID,B.PER_TYPE FROM USR_MAIN A LEFT JOIN M_PER_PROFILE B ON REPLACE(A.USR_OPTION3, '-', '') = REPLACE(B.PER_IDCARD, '-', '') WHERE A.USR_USERNAME = '$USR_USERNAME' ");

//$r_log = dbdpis::getFetch("SELECT * FROM M_PAYROLL_LOG WHERE LOG_ID = '$LOG_ID' ");



if ($GET_PERID['PER_ID'] != $PER_ID) {
    $txt = 'ท่านไม่มีสิทธิเข้าถึง';
    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    echo "<script>
        swal({
            title: '',
            text: '{$txt}',
            type: 'warning',
            showConfirmButton: true
        });
    </script>";
    die("<center>" . $txt . "</center>");
}

$sql_payroll = "SELECT C.* 
                FROM USR_MAIN A 
                LEFT JOIN M_PER_PROFILE B ON REPLACE(A.USR_OPTION3, '-', '') = REPLACE(B.PER_IDCARD, '-', '')
                LEFT JOIN PAYROLL C ON C.PER_ID = B.PER_ID  WHERE C.LOG_ID = '" . $LOG_ID . "' AND C.PER_ID = '$PER_ID'  ";

$q = dbdpis::execute($sql_payroll);
$PAYROLL = dbdpis::Fetch($q);


$sql = "SELECT A.* FROM SETUP_PAYROLL_LIST A
        INNER JOIN WF_CHECKBOX B ON A.PAY_LIST_ID = B.WFR_ID  AND B.W_ID = 33 AND B.WFS_FIELD_NAME = 'POSTYPE_ID'
        WHERE B.CHECKBOX_VALUE = '" . $GET_PERID['PER_TYPE'] . "'
        ORDER BY A.SEQ_NO ASC ";
$q_list = dbdpis::execute($sql);

$sign = dbdpis::getFetch("SELECT FILE_SAVE_NAME FROM WF_FILE WHERE WF_MAIN_ID = '39' AND FILE_STATUS = 'Y' AND WFR_ID = '{$PAYROLL['SIGNATURE_PAY_ID']}' ");

$arr_income = array();
$arr_pay = array();
$in = 1;
$out = 1;
while ($r = dbdpis::Fetch($q_list)) {

    $sql = "SELECT PAYROLL_MONEY 
            FROM PAYROLL_LIST 
            WHERE PAYROLL_ID = '" . $PAYROLL['PAYROLL_ID'] . "' AND PAY_LIST_ID = '" . $r['PAY_LIST_ID'] . "'";
    $q_money = dbdpis::execute($sql);
    $r_money = dbdpis::Fetch($q_money);

    if ($r['PAY_LIST_TYPE'] == 1) {

        $arr_income[$r['PAY_LIST_ID']]['NAME'] = $r['PAY_LIST_NAME'];
        $arr_income[$r['PAY_LIST_ID']]['MONEY'] = $EncryptSal->decode($r_money['PAYROLL_MONEY']);
        $in++;
    }

    if ($r['PAY_LIST_TYPE'] == 2) {

        $arr_pay[$r['PAY_LIST_ID']]['NAME'] = $r['PAY_LIST_NAME'];
        $arr_pay[$r['PAY_LIST_ID']]['MONEY'] = $EncryptSal->decode($r_money['PAYROLL_MONEY']);
        $out++;
    }
}


$income_money = $EncryptSal->decode($PAYROLL['INCOME_MONEY']);
$pay_money = $EncryptSal->decode($PAYROLL['PAY_MONEY']);
$final_money = $EncryptSal->decode($PAYROLL['FINAL_MONEY']);

?>

<!-- Close Top -->
<link rel="stylesheet" href="assets/css/poll.css">

<!-- <div class="container-fluid mar-t-90px header--bg">
    <div class="container py-5 text-center">
        <h3> ใบแจ้งเงินเดือน  </h3>
    </div>
</div> -->

<style>
    .font-body {
        font-size: 11px;
    }

    td {
        padding: 1px;
		font-size: 11px !important;
    }
</style>

<!-- Open News -->
<div class="contaier-fluid font-body">
    <div class="container">
        <div class="row">

            <main>
                <br><br>
                <table style="width:800px;">
                    <tr>
                        <td style=""><img src="images/DIP_100.png" style="width:48px;"></td>
                        <td><strong><span style="font-size:150%">กรมส่งเสริมอุตสาหกรรม</span></strong></td>
                        <td style="text-align:right;line-height: 1.8;">ใบจ่ายเงินเดือนและเงินอื่น (PAY SLIP)<br>ประจำเดือน <?php echo dbdpis::getMonth($PAYROLL['BG_MONTH']); ?> พ.ศ. <?php echo $PAYROLL['BG_YEAR']; ?></td>
                    </tr>
                </table>
                <br>
                <table style="width:800px;" border="0">
                    <tr>
                        <td style="width:110px;">เลขตำแหน่ง 0000339</td>
                        <td style="width:24%">ชื่อ-สกุล <?php echo $PAYROLL['PER_PREFIX'] . $PAYROLL['PER_FNAME'] . " " . $PAYROLL['PER_LNAME']; ?></td>
                        <td style="width:;">หน่วยงาน : <?php echo $PAYROLL['ORG_3_NAME']; ?></td>
                        <td style="width:130px;">จังหวัด <?php echo $PAYROLL['PROV']; ?></td>
                    </tr>

                    <tr>
                        <td colspan="3">โอนเงินเข้าบัญชี <?php echo $PAYROLL['BANK_NAME']; ?></td>
                        <td style="width:130px;">เลขที่บัญชี <?php echo $PAYROLL['BOOK_BANK_NO']; ?></td>
                    </tr>
                </table>

                <br>
                <table style="width:800px; min-height:200px;" border="0">
                    <tr>
                        <td rowspan="2" style="vertical-align:top;">

                            <table style="width:98%; line-height:16px;" border="1">
                                <tr>
                                    <td style="width:37%; text-align:center;">รายได้<br>Earnings</td>
                                    <td style="width:13%; text-align:center;">จำนวนเงิน (บาท)<br>Amount</td>
                                    <td style="width:37%; text-align:center;">รายการหัก<br>Deductions</td>
                                    <td style="width:13%; text-align:center;">จำนวนเงิน (บาท)<br>Amount</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:top; text-align:left; padding:5px;" colspan="2">

                                        <table style="vertical-align:top; width:100%;">

                                            <?php
                                            $i = 1;
                                            foreach ($arr_income as $key => $val) {
                                            ?>
                                                <tr>
                                                    <td class="text-left"><?php echo $i . ". " . $val['NAME'] ?></td>
                                                    <td class="text-right"><?php echo ($val['MONEY'] != 0) ? number_format($val['MONEY'], 2) : " - "; ?> </td>
                                                </tr>
                                            <?php $i++;
                                            } ?>

                                        </table>


                                    </td>
                                    <td style="vertical-align:top; text-align:left; padding:5px;" colspan="2">
                                        <table style="width:100%;">
                                            <?php
                                            $i = 1;
                                            foreach ($arr_pay as $key => $val) {
                                            ?>
                                                <tr>
                                                    <td class="text-left"><?php echo $i . ". " . $val['NAME'] ?></td>
                                                    <td class="text-right"><?php echo ($val['MONEY'] != 0) ? number_format($val['MONEY'], 2) : " - "; ?> </td>
                                                </tr>
                                            <?php $i++;
                                            } ?>
                                        </table>


                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;">รวมรายรับ<br>Total Earnings</td>
                                    <td style="text-align:right;"><?php echo ($income_money != 0) ? number_format($income_money, 2) : " - "; ?></td>
                                    <td style="text-align:right;">รวมรายจ่าย<br>Total Deductions</td>
                                    <td style="text-align:right;"><?php echo ($pay_money != 0) ? number_format($pay_money, 2) : " - "; ?></td>
                                </tr>
                            </table>


                        </td>
                        <td style="width:130px; vertical-align:top;">

                            <table style="background-color:#000; width:110px;" border="1">
                    </tr>
                    <td style="text-align:center; background-color:#FFF; line-height:16px;">วันที่จ่ายเงิน<br>PaySlip Date</td>
                    </tr>

                    </tr>
                    <td style="text-align:center; background-color:#FFF; line-height:16px; height:34px;"><?php echo dbdpis::db2date_show($PAYROLL['PAYROLL_PAY_DATE']); ?></td>
                    </tr>
                </table>

                </td>
                </tr>
                <tr>
                    <td style="width:130px; vertical-align:bottom;">

                        <table style="background-color:#000; width:110px;" border="1">
                </tr>
                <td style="text-align:center; background-color:#FFF; line-height:16px;">เงินรับสุทธิ<br>Net Pay</td>
                </tr>

                </tr>
                <td style="text-align:center; background-color:#FFF; line-height:16px; height:34px;"><?php echo ($final_money != 0) ? number_format($final_money, 2) : " - "; ?></td>
                </tr>
                </table>

                </td>
                </tr>
                </table>
                <br><br>
                <table style="width:800px;">
                    <tr>
                        <td></td>
                        <td style="width:60px; text-align:right; vertical-align:bottom;">ลงชื่อ</td>
                        <td style="width:160px; border-bottom:1px dotted #000; text-align:center;">
                            <!-- <img src="https://portal.dip.go.th/webstorage/slip/picture/1-20220523085037-662.png" width="120px"></td> -->
                            <?php if ($sign['FILE_SAVE_NAME']) { ?>
                                <img src="<?php echo SSO_PATH . 'attach/w39/' . $sign['FILE_SAVE_NAME']; ?>" width="120px">
                            <?php } else {
                                echo '<div style="height: 60px;"></div>';
                            } ?>
                        </td>
                        <td style="width:130px; text-align:left; vertical-align:bottom;">ผู้มีหน้าที่จ่ายเงิน</td>
                    </tr>

                    <tr>
                        <td style="height:30px;"></td>
                        <td style="width:60px; text-align:right; vertical-align:bottom;">(</td>
                        <td style="width:160px; text-align:center;"><?php echo dbdpis::db2date_show($PAYROLL['PAYROLL_DATE']); ?></td>
                        <td style="width:130px; text-align:left; vertical-align:bottom;">) วัน / เดือน / ปี ที่ออกหนังสือ</td>
                    </tr>
                </table>
            </main>



        </div>
    </div>
</div>
<!-- Close News -->

<!-- Open Footer -->
<?php //include('footer.php'); 
?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->