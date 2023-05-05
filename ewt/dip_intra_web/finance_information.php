<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->

<?php

dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);

$USR_USERNAME       = $_SESSION['EWT_USERNAME']; 
// $USR_USERNAME       = 'passakorn';
$PER_ID             = '';
$EncryptSal         = new encrypt_money();

$POSTYPE = dbdpis::getFetch("SELECT USR_OPTION4 FROM USR_MAIN WHERE USR_USERNAME = '$USR_USERNAME' ");
$TYPE = $POSTYPE['USR_OPTION4'];

$r_log = dbdpis::getFetch("SELECT TOP 1 LOG_ID FROM M_PAYROLL_LOG  WHERE POSTYPE_ID = '$TYPE' ORDER BY LOG_ID DESC ");

$sql_payroll = "SELECT C.* 
                FROM USR_MAIN A 
                LEFT JOIN M_PER_PROFILE B ON REPLACE(A.USR_OPTION3, '-', '') = REPLACE(B.PER_IDCARD, '-', '')
                LEFT JOIN PAYROLL C ON C.PER_ID = B.PER_ID  WHERE C.LOG_ID = '".$r_log['LOG_ID']."' AND A.USR_USERNAME = '$USR_USERNAME'  ";

$q = dbdpis::execute($sql_payroll);
$PAYROLL = dbdpis::Fetch($q);

$sql = "SELECT A.* FROM SETUP_PAYROLL_LIST A
        INNER JOIN WF_CHECKBOX B ON A.PAY_LIST_ID = B.WFR_ID  AND B.W_ID = 33 AND B.WFS_FIELD_NAME = 'POSTYPE_ID'
        WHERE B.CHECKBOX_VALUE = '".$TYPE."'
        ORDER BY A.SEQ_NO ASC ";
$q_list = dbdpis::execute($sql);

$arr_income = array();
$arr_pay = array();
$in = 1;
$out = 1;
while ($r = dbdpis::Fetch($q_list)) {

   $sql = "SELECT PAYROLL_MONEY 
            FROM PAYROLL_LIST 
            WHERE PAYROLL_ID = '".$PAYROLL['PAYROLL_ID']."' AND PAY_LIST_ID = '".$r['PAY_LIST_ID']."'";
    $q_money = dbdpis::execute($sql);
    $r_money = dbdpis::Fetch($q_money);

    if($r['PAY_LIST_TYPE']==1){

        $arr_income[$r['PAY_LIST_ID']]['NAME'] = $r['PAY_LIST_NAME'];
        $arr_income[$r['PAY_LIST_ID']]['MONEY'] = $EncryptSal->decode($r_money['PAYROLL_MONEY']);
        $in++;
    }

    if($r['PAY_LIST_TYPE']==2){

        $arr_pay[$r['PAY_LIST_ID']]['NAME'] = $r['PAY_LIST_NAME'];
        $arr_pay[$r['PAY_LIST_ID']]['MONEY'] = $EncryptSal->decode($r_money['PAYROLL_MONEY']);
        $out++;
    }

 

}

$PER_ID = $PAYROLL['PER_ID'];
$LOG_ID = $r_log['LOG_ID'];
$income_money = $EncryptSal->decode($PAYROLL['INCOME_MONEY']);
$pay_money = $EncryptSal->decode($PAYROLL['PAY_MONEY']);
$final_money = $EncryptSal->decode($PAYROLL['FINAL_MONEY']);

?>
<div class="container mar-spacehead mb-5">

    <div>
        <!-- ส่วนของข้อมูลผู้ใช้ -->
        <h2 class="h2-color pt-4">
            <i class="fa fa-book" aria-hidden="true"></i> ข้อมูลการเงินและหนังสือรับรอง
        </h2>
        <div class="row">
            <div class="col-lg-10 col-md-8 col-sm-12 col-12">
                <h5 class="h2-color mt-2"><a href="profile.php">ข้อมูลผู้ใช้งาน > </a> <span>ข้อมูลการเงินและหนังสือรับรอง</span></h5>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12 col-12">
                <a href="Request_Certificate.php" type="button" class="btn bg-color-purple white-text btn-sm mt-1">ขอหนังสือรับรอง</a>
            </div>
        </div>
        <hr class="hr_news mt-0">

        <!-- แบ่งฝั่งข้อมูล -->

        <div class=" shadow-sm box-border-profile px-3 py-3 ">
            <div class="row">
                <div class="col-lg-10 col-md-8 col-sm-12 col-12">
                    <h3 class="h2-color">ใบรับรองการจ่ายเงินเดือนและเงินอื่นๆประจำเดือน <?php echo dbdpis::getMonth($PAYROLL['BG_MONTH']); ?> พ.ศ. <?php echo $PAYROLL['BG_YEAR']; ?> </h3>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-12 col-12">
                    <a href="slip_list.php"><u>ข้อมูลย้อนหลัง</u></a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 border-right-profile ">
                    <h3 class="h2-color mt-3 mb-3" style="color:#0047FF ;">
                        รายรับ
                    </h3>
                    <div class="table-responsive-sm">
                        <table class="table table-sm" style="text-align:left ;">
                            <thead class="white-text bg-color-purple ta-fontmini">
                                <tr>

                                    <th scope="col">รายการ</th>
                                    <th scope="col" style="width:170px;" class="text-center">จำนวนเงิน (บาท)</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i=1;
                                foreach($arr_income as $key => $val){ 
                                ?>
                                <tr>
                                    <td class="text-left"><?php echo $i.". ".$val['NAME']?></td>
                                    <td class="text-right"><?php echo ($val['MONEY'] != 0) ? number_format($val['MONEY'], 2) . " บาท" : " - "; ?> </td>
                                </tr>
                                <?php $i++; } ?>
                               

                            </tbody>
                        </table>
                        <div class="row" style="color:#0047FF ;">
                            <div class="col-lg-8 col-md-6 col-sm-3 col-3">
                                <h4 class="text-right">รวม</h4>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-9 col-9 ">
                                <h4 class="text-center"><?php echo ($income_money != 0) ? number_format($income_money, 2) . " บาท" : " - "; ?></h4>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 ">
                    <h3 class="h2-color mt-3 mb-3" style="color:#C60000;">
                        รายจ่าย
                    </h3>
                    <div class="table-responsive-sm">
                        <table class="table table-sm" style="text-align:left ;">
                            <thead class="white-text bg-color-purple ta-fontmini">
                                <tr>

                                    <th scope="col">รายการ</th>
                                    <th scope="col" style="width:170px;" class="text-center">จำนวนเงิน (บาท)</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $i=1;
                                foreach($arr_pay as $key => $val){ 
                                ?>
                                <tr>
                                    <td class="text-left"><?php echo $i.". ".$val['NAME']?></td>
                                    <td class="text-right"><?php echo ($val['MONEY'] != 0) ? number_format($val['MONEY'], 2) . " บาท" : " - "; ?> </td>
                                </tr>
                                <?php $i++; } ?>

                            </tbody>
                        </table>
                        <div class="row" style="color:#C60000;">
                            <div class="col-lg-8 col-md-6 col-sm-3 col-3">
                                <h4 class="text-right">รวม</h4>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-9 col-9 ">
                                <h4 class="text-center"><?php echo ($pay_money != 0) ? number_format($pay_money, 2) . " บาท" : " - "; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="h2-color">รับสุทธิ : <?php echo ($final_money != 0) ? number_format($final_money, 2) . " บาท" : " - "; ?> <span><a href="payroll_display.php?PER_ID=<?php echo $PER_ID;?>&LOG_ID=<?php echo $LOG_ID;?>" target="_blank" type="button" class="ml-2 border-ra-15px btn-sm btn btn-outline-primary">พิมพ์ใบสลิปเงินเดือน</a></span></h4>
        </div>



    </div>
   
   
</div>




<?php include('footer.php'); ?>
<!-- Footer Website -->
<?php include('combottom.php'); ?>
<!-- Include file js and properties -->