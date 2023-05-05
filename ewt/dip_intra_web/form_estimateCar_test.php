<?php
//phpinfo(); 5.6.40
include '../include/comtop_user.php';
include '../function/sg_functions.php';
include '../function/sg_function_roomName.php';

$m_room = conText($_GET['ROOM_ID']);
$dep_id = conText($_GET['DEP_ID']);
$m_Date = conText($_GET['MEETING_DATE']);
$m_eDate = conText($_GET['MEETING_EDATE']);

/////////////////////////////////////////////////////////////// filter //////////////////////////////////////////////////////////////////

$filter_room = '';
$filter_depId = '';
$filter_mDate = '';
$filter_meDate = '';

// meetroom_complacent.php
$link_self = 'meetroom_complacent.php';

if ($m_room) {
    $filter_room = "AND WMRN.ROOM_ID = '{$m_room}'";
}

if ($dep_id) {
    $filter_depId = "AND MMR.DEP_KEEPER = '{$dep_id}'";
}

if ($m_Date) {
    $db_date = date2db($m_Date);
    $filter_mDate = "AND WMRN.MEETING_DATE = '{$db_date}'";
}

if ($m_eDate) {
    $db_date = date2db($m_eDate);
    $filter_meDate = "AND WMRN.MEETING_EDATE = '{$db_date}'";
}

$rec_main = db_selectWhere('WF_MAIN', '*', "WF_MAIN_ID = '10229'")[0];

$rooms = db_selectWhere('M_MEETING_ROOM', 'MEETING_ID, ROOM_NAME, DEP_KEEPER', "ROOM_STATUS = 'Y'");

$usr_deps = db_selectWhere('USR_DEPARTMENT', 'DEP_ID, DEP_NAME, DEP_CODE', "DEP_STATUS = 'Y'");

$field = "WMRN.WFR_ID, WMRN.MEETING_DATE, WMRN.STIME, WMRN.ETIME, WMRN.MEETING_TITLE, WMRN.ROOM_ID";
$condition = "WHERE WMRN.FORM_STATUS = 'Y' {$filter_room} {$filter_depId} {$filter_mDate} {$filter_meDate} ORDER BY WMRN.WFR_ID DESC";
$sql_rooms = "SELECT {$field} FROM WFR_MEETING_ROOM_NEW1 AS WMRN
	INNER JOIN M_MEETING_ROOM AS MMR 
	ON WMRN.ROOM_ID = MMR.MEETING_ID {$condition}";
$res_rooms = db_getStmt($sql_rooms);


$arr_detail = array();
$query_data = db::query("SELECT * FROM M_SUB_TOPIC ORDER BY ST_ID ASC");
while ($fetch_data = db::fetch_array($query_data)) {
    $arr_detail['H'][$fetch_data['MT_ID']]    =  bsf_show_text('10247', $fetch_data, "##MT_ID!!", 'M');
    $arr_detail['D'][$fetch_data['MT_ID']][$fetch_data['ST_ORDER']]    = $fetch_data['ST_NAME'];
    $arr_detail['ID'][$fetch_data['MT_ID']][$fetch_data['ST_ORDER']]    = $fetch_data['ST_ID'];
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// filter /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 1;
$sql_form = "select ";
$arr_form = array('ANS_01', 'ANS_02', 'ANS_03', 'ANS_04', 'ANS_05', 'ANS_06', 'ANS_07', 'ANS_08', 'ANS_09', 'ANS_10', 'ANS_11', 'ANS_12');
$arr_order = array('1', '2', '3', '4');
foreach ($arr_form as $k => $v) {
    $sql_form .= "
		(SELECT COUNT({$v}) FROM WFR_MEETING_ROOM_NEW1 AS WMRN LEFT JOIN M_MEETING_ROOM AS MMR ON WMRN.ROOM_ID = MMR.MEETING_ID WHERE {$v} = 1 AND WMRN.FORM_STATUS = 'Y' {$filter_room} {$filter_depId} {$filter_mDate} {$filter_meDate}) as {$v}_1,
		(SELECT COUNT({$v}) FROM WFR_MEETING_ROOM_NEW1 AS WMRN LEFT JOIN M_MEETING_ROOM AS MMR ON WMRN.ROOM_ID = MMR.MEETING_ID WHERE {$v} = 2 AND WMRN.FORM_STATUS = 'Y' {$filter_room} {$filter_depId} {$filter_mDate} {$filter_meDate}) as {$v}_2,
		(SELECT COUNT({$v}) FROM WFR_MEETING_ROOM_NEW1 AS WMRN LEFT JOIN M_MEETING_ROOM AS MMR ON WMRN.ROOM_ID = MMR.MEETING_ID WHERE {$v} = 3 AND WMRN.FORM_STATUS = 'Y' {$filter_room} {$filter_depId} {$filter_mDate} {$filter_meDate}) as {$v}_3,
		(SELECT COUNT({$v}) FROM WFR_MEETING_ROOM_NEW1 AS WMRN LEFT JOIN M_MEETING_ROOM AS MMR ON WMRN.ROOM_ID = MMR.MEETING_ID WHERE {$v} = 4 AND WMRN.FORM_STATUS = 'Y' {$filter_room} {$filter_depId} {$filter_mDate} {$filter_meDate}) as {$v}_4
		";

    if (count($arr_form) != $i) {
        $sql_form .= ",";
    }
    $i++;
}

//////////////////////////////////////////////////////////////////////////////// func form  /////////////////////////////////////////////////////////////////////////////////

$query = db::query($sql_form);
$fetch_form = db::fetch_array($query);

function avgForm($num)
{
    global $fetch_form;

    $num_result = $fetch_form["ANS_{$num}_4"] + $fetch_form["ANS_{$num}_3"] + $fetch_form["ANS_{$num}_2"] + $fetch_form["ANS_{$num}_1"];
    $point_sum = (($fetch_form["ANS_{$num}_4"] * 4) + ($fetch_form["ANS_{$num}_3"] * 3) + ($fetch_form["ANS_{$num}_2"] * 2) + ($fetch_form["ANS_{$num}_1"] * 1)) / $num_result;
    return ($point_sum !== false) ? $point_sum : '0';
}

//////////////////////////////////////////////////////////////////////////////// func form  /////////////////////////////////////////////////////////////////////////////////

?>

<link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row" id="animationSandbox">
            <div class="col-sm-12">
                <div class="main-header">
                    <h4><img src="../icon/<?php echo $rec_main['WF_MAIN_ICON']; ?>" width="72" height="74"> รายงานความพึงพอใจการใช้ห้องประชุม </h4>
                    <ol class="breadcrumb breadcrumb-title breadcrumb-arrow"></ol>
                    <div class="f-right">
                        <a class="btn btn-danger waves-effect waves-light" href="../workflow/index.php" role="button" title=""><i class="icofont icofont-home"></i> กลับหน้าหลัก</a>
                        <a class="btn btn-warning waves-effect waves-light" href="#export" role="button" onclick="type_doc('pdfl'); export_file();"><i class="fa fa-file-pdf-o"></i> ส่งออก PDF</a>
                        <a class="btn btn-info waves-effect waves-light" href="#export" role="button" onclick="type_doc('doc'); export_file();"><i class="fa fa-file-word-o"></i> ส่งออก WORD</a>
                        <!-- <a class="btn btn-success waves-effect waves-light" href="#export" role="button" onclick="type_doc('xls'); export_file();"><i class="fa fa-file-excel-o"></i> ส่งออก EXCEL</a> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="showborder">
                <?php
                foreach ($arr_form as $k => $v) {
                    arsort($arr_order);
                    foreach ($arr_order as $k_order => $v_order) {
                        //print_pre($v);

                        $arr_data[$v][$v_order]  = $fetch_form[$v . "_" . $v_order];

                        $arr_data_sum[$v_order]  += $fetch_form[$v . "_" . $v_order];
                    }
                }
                //print_pre($arr_detail);
                ?>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-header-text"></h5>
                            <h4><i class="icofont icofont-search-alt-2"></i> ค้นหา</h4>
                            <!--- ROW 1 --->
                            <form action="../report/<?php echo $link_self; ?>" method="GET">
                                <div class="form-group row">
                                    <div id="MEETING_DATE_BSF_AREA" class="col-md-2 "><label for="MEETING_DATE" class="form-control-label wf-right">ห้องประชุม</label></div>
                                    <div id="MEETING_DATE_BSF_AREA" class="col-md-3 wf-left">
                                        <label class="input-group">
                                            <select id="ROOM_ID" name="ROOM_ID" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                <option value="">ทั้งหมด</option>
                                                <?php foreach ($rooms as $rooms_k => $row) { ?>
                                                    <option value="<?php echo $row['MEETING_ID']; ?>" <?php echo ($row['MEETING_ID'] == $m_room ? "selected" : ''); ?>><?php echo $row['ROOM_NAME']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="input-group-addon bg-primary"><i class="fa fa-list-ul"></i></span>
                                        </label>
                                    </div>

                                    <div id="MEETING_USR_DEPARTMENT" class="col-md-2 "><label for="MEETING_USR_DEPARTMENT" class="form-control-label wf-right">หน่วยงานที่ดูเเล</label></div>
                                    <div id="MEETING_USR_DEPARTMENT" class="col-md-3 wf-left">
                                        <label class="input-group">
                                            <select name="DEP_ID" id="DEP_ID" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                <option value="">ทั้งหมด</option>
                                                <?php foreach ($usr_deps as $usr_deps_k => $rows) { ?>
                                                    <option value="<?php echo $rows['DEP_ID']; ?>" <?php echo ($rows['DEP_ID'] == $dep_id ? "selected" : ''); ?>><?php echo $rows['DEP_NAME']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="input-group-addon bg-primary"><i class="fa fa-list-ul"></i></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div id="MEETING_DATE_BSF_AREA" class="col-md-2 "><label for="MEETING_DATE" class="form-control-label wf-right">วันที่ประชุม</label></div>
                                    <div id="MEETING_DATE_BSF_AREA" class="col-md-3 wf-left">
                                        <label class="input-group">
                                            <input id="MEETING_DATE" name="MEETING_DATE" value="" aria-required="true" class="form-control datepicker" placeholder="">
                                            <span class="input-group-addon bg-primary">
                                                <span class="icofont icofont-ui-calendar"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div id="MEETING_USR_DEPARTMENT" class="col-md-2 "><label for="MEETING_USR_DEPARTMENT" class="form-control-label wf-right">ถึงวันที่</label></div>
                                    <div id="MEETING_USR_DEPARTMENT" class="col-md-3 wf-left">
                                        <label class="input-group">
                                            <input id="MEETING_EDATE" name="MEETING_EDATE" value="" aria-required="true" class="form-control datepicker" placeholder="">
                                            <span class="input-group-addon bg-primary">
                                                <span class="icofont icofont-ui-calendar"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <!--- ROW 2 --->

                                <!--- ROW 2 --->

                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" name="wf_search" id="wf_search" class="btn btn-info" onClick="func_ch_input()"><i class="icofont icofont-search-alt-2"></i> ค้นหา</button>&nbsp;&nbsp;
                                        <button type="button" name="wf_reset" id="wf_reset" class="btn btn-warning" onclick="window.location.href='../report/<?php echo $link_self; ?>';"><i class="zmdi zmdi-refresh-alt"></i> Reset</button>
                                        <input type="hidden" name="WF_SEARCH" id="WF_SEARCH" value="Y">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-block">
                            <div class="showborder">
                                <div class="table-responsive" data-pattern="priority-columns">
                                    <table class="table table-bordered" style="width: 100%; margin: 0 auto; ">
                                        <thead class="text-center" style="color: #FFFFFF; background-color: #007549;">
                                            <tr>
                                                <th class="text-center" width="8%" rowspan="2" style="color: #FFFFFF; background-color: #007549;">ลำดับ</th>
                                                <th class="text-center" rowspan="2" style="color: #FFFFFF; background-color: #007549;">รายการ</th>
                                                <th class="text-center" colspan="5" style="color: #FFFFFF; background-color: #007549;">ระดับความคิดเห็น</th>
                                            </tr>
                                            <tr style="font-size: 18px;">
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">ดีมาก</th>
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">ดี</th>
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">พอใช้</th>
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">ปรับปรุง</th>
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">คะแนนเฉลี่ย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!--////////////////////////////////////////////////////////////////////////////-->

                                            <?php foreach ($arr_detail['H'] as $k_head => $v_head) { ?>
                                                <tr>
                                                    <td></td>
                                                    <td class="text-center"><b><?php echo $v_head; ?></b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php foreach ($arr_detail['D'][$k_head] as $k_detail => $v_detail) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $k_detail; ?>.</td>
                                                        <td><?php echo $v_detail; ?></td>
                                                        <?php
                                                        $sum_aver = 0;
                                                        $ID =  sprintf('%02d', $arr_detail['ID'][$k_head][$k_detail]);
                                                        if (count($arr_data['ANS_' . $ID]) > 0) { ?>
                                                            <?php foreach ($arr_data['ANS_' . $ID] as $key => $value) { ?>
                                                                <td class="text-center"><?php echo $value; ?></td>
                                                            <?php
                                                                $sum_aver += ($key * $value);
                                                            } ?>

                                                            <td class="text-center"><?php echo $sum_aver / array_sum($arr_data['ANS_' . $ID]); ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>

                                                <tr>
                                                    <td class="text-center" colspan="2"></td>
                                                    <?php
                                                    $sum_aver_1 = array();
                                                    foreach ($arr_order as $k_order => $v_order) {
                                                        foreach ($arr_detail['ID'][$k_head] as $k_id => $v_id) {

                                                            $sum_aver_1[$v_order] += $arr_data['ANS_' . sprintf('%02d', $v_id)][$v_order];
                                                        }
                                                    ?>
                                                    <?php } ?>
                                                    <?php
                                                    $sum_aver = 0;
                                                    foreach ($sum_aver_1 as $k_aver_1 => $v_aver_1) { ?>
                                                        <td class="text-center"><?php echo $v_aver_1; ?></td>
                                                    <?php
                                                        $sum_aver += ($k_aver_1 * $v_aver_1);
                                                    } ?>
                                                    <td class="text-center"><?php echo $sum_aver / array_sum($sum_aver_1); ?></td>

                                                </tr>
                                            <?php } ?>
                                            <!-- sum -->
                                            <tr>
                                                <td class="text-center" width="8%" rowspan="2" style="color: #FFFFFF; background-color: #007549;">&nbsp;</td>
                                                <td class="text-center" rowspan="2" style="color: #FFFFFF; background-color: #007549;">&nbsp;</td>
                                            </tr>
                                            <tr style="font-size: 15px;">
                                                <?php
                                                $sum_aver = 0;
                                                if (count($arr_data_sum) > 0) { ?>
                                                    <?php foreach ($arr_data_sum as $key => $value) { ?>
                                                        <td class="text-center" style="color: #FFFFFF; background-color: #007549;"><?php echo $value; ?></td>
                                                    <?php
                                                        $sum_aver += ($key * $value);
                                                    } ?>

                                                    <td class="text-center" style="color: #FFFFFF; background-color: #007549;"><?php echo $sum_aver / array_sum($arr_data_sum); ?></td>
                                                <?php } ?>
                                            </tr>
                                            <!-- sum -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- REPORT -->
                        <div class="card-block" id="export_data" style="display: none;">
                            <style>
                                #head-fixed {
                                    display: none;
                                }
                            </style>
                            <div id="head-fixed">
                                <table width="100%">
                                    <tr>
                                        <!--<td align="left" colspan="5"><?php echo $logo_report; ?></td>-->
                                        <td align="right" colspan="13">
                                            <h6>หน้าที่ {PAGENO}/{nbpg}<br>วันที่พิมพ์ <?php echo db2date(date("Y-m-d")); ?></h6>
                                        </td>
                                    </tr>
                                </table>
                                <table width="100%">
                                    <tr>
                                        <td align="center" colspan="13">
                                            <h3>รายงานความพึงพอใจการใช้ห้องประชุม</h3>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="showborder">
                                <div class="table-responsive" data-pattern="priority-columns">
                                    <table class="table table-bordered" style="width: 100%; margin: 0 auto; ">
                                        <thead class="text-center" style="color: #FFFFFF; background-color: #007549;">
                                            <tr>
                                                <th class="text-center" width="8%" rowspan="2" style="color: #FFFFFF; background-color: #007549;">ลำดับ</th>
                                                <th class="text-center" rowspan="2" style="color: #FFFFFF; background-color: #007549;">รายการ</th>
                                                <th class="text-center" colspan="5" style="color: #FFFFFF; background-color: #007549;">ระดับความคิดเห็น</th>
                                            </tr>
                                            <tr style="font-size: 18px;">
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">ดีมาก</th>
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">ดี</th>
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">พอใช้</th>
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">ปรับปรุง</th>
                                                <th class="text-center" width="8%" style="color: #FFFFFF; background-color: #007549;">คะแนนเฉลี่ย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!--////////////////////////////////////////////////////////////////////////////-->

                                            <?php foreach ($arr_detail['H'] as $k_head => $v_head) { ?>
                                                <tr>
                                                    <td></td>
                                                    <td style="text-align: center;"><b><?php echo $v_head; ?></b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php foreach ($arr_detail['D'][$k_head] as $k_detail => $v_detail) { ?>
                                                    <tr>
                                                        <td style="text-align: center;"><?php echo $k_detail; ?>.</td>
                                                        <td><?php echo $v_detail; ?></td>
                                                        <?php
                                                        $sum_aver = 0;
                                                        $ID =  sprintf('%02d', $arr_detail['ID'][$k_head][$k_detail]);
                                                        if (count($arr_data['ANS_' . $ID]) > 0) { ?>
                                                            <?php foreach ($arr_data['ANS_' . $ID] as $key => $value) { ?>
                                                                <td style="text-align: center;"><?php echo $value; ?></td>
                                                            <?php
                                                                $sum_aver += ($key * $value);
                                                            } ?>

                                                            <td style="text-align: center;"><?php echo $sum_aver / array_sum($arr_data['ANS_' . $ID]); ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>

                                                <tr>
                                                    <td style="text-align: center;" colspan="2"></td>
                                                    <?php
                                                    $sum_aver_1 = array();
                                                    foreach ($arr_order as $k_order => $v_order) {
                                                        foreach ($arr_detail['ID'][$k_head] as $k_id => $v_id) {

                                                            $sum_aver_1[$v_order] += $arr_data['ANS_' . sprintf('%02d', $v_id)][$v_order];
                                                        }
                                                    ?>
                                                    <?php } ?>
                                                    <?php
                                                    $sum_aver = 0;
                                                    foreach ($sum_aver_1 as $k_aver_1 => $v_aver_1) { ?>
                                                        <td style="text-align: center;"><?php echo $v_aver_1; ?></td>
                                                    <?php
                                                        $sum_aver += ($k_aver_1 * $v_aver_1);
                                                    } ?>
                                                    <td style="text-align: center;"><?php echo $sum_aver / array_sum($sum_aver_1); ?></td>

                                                </tr>
                                            <?php } ?>
                                            <!-- sum -->
                                            <tr>
                                                <td class="text-center" width="8%" rowspan="2" style="text-align: center; color: #FFFFFF; background-color: #007549;">&nbsp;</td>
                                                <td class="text-center" rowspan="2" style="text-align: center; color: #FFFFFF; background-color: #007549;">&nbsp;</td>
                                            </tr>
                                            <tr style="font-size: 15px;">
                                                <?php
                                                $sum_aver = 0;
                                                if (count($arr_data_sum) > 0) { ?>
                                                    <?php foreach ($arr_data_sum as $key => $value) { ?>
                                                        <td class="text-center" style="text-align: center; color: #FFFFFF; background-color: #007549;"><?php echo $value; ?></td>
                                                    <?php
                                                        $sum_aver += ($key * $value);
                                                    } ?>

                                                    <td class="text-center" style="text-align: center; color: #FFFFFF; background-color: #007549;"><?php echo $sum_aver / array_sum($arr_data_sum); ?></td>
                                                <?php } ?>
                                            </tr>
                                            <!-- sum -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- REPORT -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" id="form_export" name="form_export" target="_blank" action="export_report.php">
    <input type="hidden" name="export_content" id="export_content" />
    <input type="hidden" name="export_type" id="export_type" value="" />
    <input type="hidden" name="margin_left" id="margin_left" value="10">
    <input type="hidden" name="margin_right" id="margin_right" value="10">
    <input type="hidden" name="margin_top" id="margin_top" value="45">
    <input type="hidden" name="margin_bottom" id="margin_bottom" value="16">
    <input type="hidden" name="margin_header" id="margin_header " value="5">
    <input type="hidden" name="margin_footer" id="margin_footer" value="9">
    <input type="hidden" name="header_pdf" id="header_pdf" value="">
    <input type="hidden" name="R_SET_FONT" id="R_SET_FONT" value="">
    <input type="hidden" name="watermark_img" id="watermark_img" value="">
    <input type="hidden" name="page_type" id="page_type" value="L">
    <!--<input type="hidden" name="R_SET_FONT" id="R_SET_FONT" value="12">-->
</form>

<?php include '../include/combottom_js_user.php'; ?>
<?php include '../include/combottom_user.php'; ?>

<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        document.getElementById("header_pdf").value = document.getElementById("head-fixed").innerHTML;
        // document.getElementById("watermark_img").value = "../images/logo_ldo.png";
    });

    function func_ch_input() {
        var x = document.getElementById("G_DATE").value;
        if (x != '') {
            document.getElementById("WF_SEARCH").value = "Y";
        } else {
            document.getElementById("WF_SEARCH").value = "";
            //alert("กรุณากรอกข้อมูลวันที่ขนส่ง");
        }
    }
</script>