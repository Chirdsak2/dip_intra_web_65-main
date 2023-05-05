<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->

<?php 
$s_gen_user_id  = " WHERE gen_user_id = $user_ewt[gen_user_id]";
$_sql_pro     = " SELECT *  FROM gen_user as gen
                        INNER JOIN title ON title.title_id = gen.title_thai
                        INNER JOIN emp_type ON emp_type.emp_type_id = gen.emp_type_id
                        INNER JOIN org_name ON org_name.org_id = gen.org_id 
                        INNER JOIN position_name ON position_name.pos_id = gen.posittion
                        INNER JOIN level ON level.level_id = gen.level_id
                        $s_gen_user_id";
$a_data_pro   = db::getfetch($_sql_pro);
?>

<div class="container mar-spacehead mb-5">
    <div class="row">
        <!-- picture profile -->
        <div class="col-lg-3 col-md-5 col-sm-12 col-12">
            <div class="line-pic-profile my-3"></div>
            <div>
                <img src="images/profile.jpg" class="shadow box-pic-profile" alt="pictureProfile">
                <a class="btn btn-change-pic" href="#" role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            </div>
        </div>

        <!-- ข้อมูลส่วนตัว -->
        <div class="col-lg-9 col-md-7 col-sm-12 col-12 martop-profile">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                    <h2 class="h2-color "><?php echo $name_thai . "  " . $surname_thai; ?></h2>
                    <h3 class="mb-2"><?php echo $name_eng . "  " . $surname_eng; ?></h3>
                    <p class="mb-0">หน่วยงานที่ปฏิบัติงานจริง :<span> <?php echo $org_name ?></span></p>
                    <p>สังกัด :<span> <?php echo $a_data_pro[afft_name]; ?> </span></p>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <a href="profile.php" class="btn Gradient-Color border-ra-15px white-text  btn-sm">ข้อมูลส่วนบุคคล</a>
                </div>
            </div>
        </div>
    </div>

    <div>
        <!-- ส่วนของข้อมูลผู้ใช้ -->
        <h2 class="h2-color pt-4">
            <i class="fa fa-user" aria-hidden="true"></i>
             ข้อมูลส่วนบุคคล
        </h2>
        <hr class="hr_news mt-0">
 
        <!-- แบ่งฝั่งข้อมูล -->

        <div class=" shadow-sm box-border-profile px-3 py-3 ">
            <h3 class="h2-color">ประวัติส่วนตัว</h3>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 border-right-profile ">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">ประเภทบุคคล </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: บุคคลธรรมดา</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">ประเภทข้าราชการ </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: <?php echo $a_data_pro[emp_type_name]; ?> </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">ระดับ </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: ระดับต้น</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">วันที่เข้ารับราชการ </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: 19 กรกฎาคม 2563</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">อายุราชการ </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: 2 ปี</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">วันที่ครบเกษียณอายุฯ </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: 16 พฤษภาคม 2603</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">วันเดือนปีเกิด</h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: 22 มิถุนายน 2533</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">อายุ</h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: 32</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">เลขประจำตัวประชาชน</h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: x-xxxx-xxxxx-x-xx</div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 ">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">บิดา </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: นาย อิซิคุ ฮิราตะ</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">มารดา </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: นาง อุราระกะ ฮิราตะ </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">หมู่โลหิต </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: O</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">ศาสนา </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: พุทธ</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">ภูมิลำเนาเดิม </h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: อุบลราชธานี</div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">ที่อยู่ตามทะเบียนบ้าน</h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: <?php echo $a_data_pro[officeaddress]; ?> </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">ที่อยู่ที่สามารถติดต่อได้</h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: <?php echo $a_data_pro[officeaddress]; ?> </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">หมายเลขโทรศัพท์มือถือ</h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: <?php echo $a_data_pro[mobile]; ?></div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <h5 class="m-0">สถานะ</h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="mr-5 txtcolor-646464">: โสด</div>
                        </div>

                    </div>
                </div>
            </div>



        </div>



    </div>
    <h3 class="h2-color mt-3 mb-3">
        ข้อมูลส่วนบุคคล

    </h3>
    <div class="table-responsive-sm">
        <table class="table table-sm" >
            <thead class="white-text bg-color-purple ta-fontmini" >
                <tr>
                    <th scope="col">ลำดับที่</th>
                    <th scope="col">วุฒิการศึกษา</th>
                    <th scope="col">วิชาเอก</th>
                    <th scope="col">สถานศึกษา</th>
                    <th scope="col">ปีที่เริ่มศึกษา</th>
                    <th scope="col">ปีที่จบการศึกษา</th>
                    <th scope="col">ประเภททุน</th>
                    <th scope="col">ประเทศเจ้าของทุน</th>
                    <th scope="col">หน่วยงานที่ให้ทุน</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>เศรษฐศาสตรมหาบันฑิต</td>
                    <td> </td>
                    <td>มหาวิทยาลัยเชียงใหม่</td>
                    <td>2551</td>
                    <td>2554</td>
                    <td> </td>
                    <td>ไทย</td>
                    <td> </td>
                </tr>
               
            </tbody>
        </table>
    </div>
</div>




    <?php include('footer.php'); ?>
    <!-- Footer Website -->
    <?php include('combottom.php'); ?>
    <!-- Include file js and properties -->