<?php
include("../EWT_ADMIN/comtop.php");
?>

<!-- START CONTAINER  -->
<div class="container-fluid">
    <?php
    include("menu-top.php");

    if ($db->check_permission("org", "tq", "")) {
        $type_right = 'Y';
    }
    $db->query("USE " . $EWT_DB_USER);

    $right_org_id = org::getOrgGroup($_SESSION['EWT_SMID']);
    $perpage = 10;
    $page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
    if ($page <= 0) $page = 1;
    $start = ($page * $perpage) - $perpage;

    // $search_condition = "";
    // $search_pagin = "";

    // if ($_GET["search"] == "Y") {

    //     $search_pagin .= "search=Y&";

    //     $fullname = trim($_GET["fullname"]);
    //     $search_pagin .= "fullname=" . ready($_GET["fullname"]) . "&";
    //     if ($fullname != "") {
    //         $find = explode(" ", $fullname);
    //         foreach ($find as $find_e) {
    //             if ($find_e != "") {
    //                 $find_e = ready($find_e);
    //                 $search_condition .= " AND ((gen_user.name_thai LIKE '%$find_e%') OR (gen_user.surname_thai LIKE '%$find_e%')) ";
    //             }
    //         }
    //     }
    // } else {
    //     $search_pagin = "&";
    // }



    if ($_SESSION["EWT_SMTYPE"] != "Y"  && $type_right  == 'Y') {
        $wh = " AND gen_user.org_id='" . $right_org_id . "'";
    }

    //{$condition} `emp_type`.`emp_type_status` = '2' {$wh}  $search_condition

    $sql = "SELECT *
		FROM `emp_type`";
    $s_sql = $db->query($sql . " LIMIT {$start} , {$perpage}");


    //{$condition} `emp_type`.`emp_type_status` = '2' {$wh} $search_condition
    $statement = "SELECT *
			  FROM  `emp_type`";

    $a_rows  = $db->db_num_rows($s_sql);
    $s_count = $db->query($statement);
    $a_count = $db->db_fetch_array($s_count);
    $total_record = $a_count['b'];
    $total_page = (int)ceil($total_record / $perpage);
    ?>
    <div class="row m-b-sm">
        <div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
            <!--start card -->
            <div class="card">
                <!--start card-header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">

                            <h4><?php echo "ประเภทบุคลากร"; ?></h4>
                            <p></p>

                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <ol class="breadcrumb">
                                    <li><a href="org_dashboard.php"><?php echo $txt_org_menu_main; ?></a></li>
                                    <li class=""><?php echo "ประเภทบุคลากร"; ?></li>
                                </ol>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
                                <a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_org_type_list.php');">
                                    <button type="button" class="btn btn-info  btn-ml" title="<?php echo "ประเภทบุคลากร"; ?>">
                                        <i class="fas fa-plus-circle"></i>&nbsp;<?php echo "ประเภทบุคลากร"; ?>
                                    </button>
                                </a>

                               
                            </div>
                          
                        </div>



                    </div>
                </div>
                <!--END card-header -->


                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-12 col-sm-12 col-xs-12" id="table-view">

                            <div class="panel-group" id="accordion">
                                <?php
                                if ($a_rows > 0) {
                                    $i = 0;
                                    while ($a_data = $db->db_fetch_array($s_sql)) {
                                ?>
                                        <div class="panel panel-default " id="<?php echo $a_data['emp_type_id']; ?>">
                                            <div class="panel-heading ewt-bg-success">
                                                <h4 class="panel-title">
                                                   
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i; ?>">
                                                        <img src="<?php echo org::getGenUserImg($a_data['emp_type_id']); ?>" alt="" class="img-circle img-rounded " style="width:24px;height:24px;" />
                                                        :: <?php echo  $a_data['emp_type_name']; ?>

                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseOne<?php echo $i; ?>" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                   
                                                </div>
                                                <div class="panel-footer ewt-bg-white text-right">
                                                    <div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">

                                                     
                                                        <a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_edit_org_type_list.php?u_id=<?php echo $a_data['emp_type_id']; ?>');">
                                                            <button type="button" class="btn btn-warning  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_edit; ?>">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>
                                                        </a>
                                                        <a onClick="JQDel_Gen_User('<?php echo $a_data['emp_type_id']; ?>');">
                                                            <button type="button" class="btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_delete; ?>">
                                                                <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                            </button>
                                                        </a>


                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    <?php $i++;
                                    }
                                } else { ?>

                                    <div class="panel panel-default ">
                                        <div class="panel-heading text-center">
                                            <h4 class="panel-title">
                                                <p class="text-danger"><?php echo $txt_ewt_data_not_found; ?></p>
                                            </h4>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                        <?php echo pagination_ewt($statement, $perpage, $page, '?' . $search_pagin); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE " . $EWT_DB_NAME);

include("../EWT_ADMIN/combottom.php");
?>
<style>
    .panel-default>.panel-heading {
        /*color: #FFFFFF;*/
        /*background-color: #FFC153 ;*/
        background-color: #FFFFFF;
        border-color: #ddd;
    }

    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        content: "\f105";
        /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>
<script>
    function txt_data(w, g) {
        $.ajax({
            type: 'GET',
            url: 'pop_set_lang_org_list.php?gid=' + g + '&id=' + w,
            beforeSend: function() {
                $('#box_popup').html('');
            },
            success: function(data) {
                $('#box_popup').html(data);
            }
        });
        $('#box_popup').fadeIn();
    }

    function txt_data1(w, g, lang) {
        $.ajax({
            type: 'GET',
            url: 'pop_org_list_multilang.php?langid=' + g + '&lang=' + lang + '&id=' + w,
            beforeSend: function() {
                $('#box_popup').html('');
            },
            success: function(data) {
                $('#box_popup').html(data);
            }
        });
        $('#box_popup').fadeIn();
    }

    function JQDel_Gen_User(id) {
        $.confirm({
            title: '<?php echo $txt_ewt_confirm_del_title; ?>',
            content: '<?php echo $txt_ewt_confirm_del_alert; ?>',
            //content: 'url:form.html',
            boxWidth: '30%',
            icon: 'fas fa-exclamation-circle',
            theme: 'modern',
            buttons: {
                confirm: {
                    text: '<?php echo $txt_ewt_confirm_del; ?>',
                    btnClass: 'btn-warning',
                    action: function() {
                        $.ajax({
                            type: 'GET',
                            url: 'func_delete_org_type_list.php',
                            data: {
                                'id': id,
                                'proc': 'DelOrgList'
                            },
                            success: function(data) {
                                $.alert({
                                    title: '<?php echo $txt_ewt_action_del_alert; ?>',
                                    theme: 'modern',
                                    content: '',
                                    boxWidth: '30%',
                                    buttons: {
                                        cancel: {
                                            text: '<?php echo $txt_ewt_submit; ?>',
                                            btnClass: 'btn-blue',
                                            action: function() {
                                                location.reload();
                                            }
                                        }
                                    }

                                });

                            }
                        });
                        //FuncDelete(id);											
                        //$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
                    }

                },
                cancel: {
                    text: '<?php echo $txt_ewt_cancel; ?>'

                }
            },
            animation: 'scale',
            type: 'orange'

        });
        // });
    }
</script>