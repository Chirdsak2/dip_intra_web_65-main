<!-- Optional JavaScript; choose one of the two! -->

<!-- jQuery JavaScript Library v3.5.1 -->
<!-- <script src="assets/js/jquery.js"></script> -->

<!-- Bootstrap v4.6.1 -->
<script src="assets/js/bootstrap.js"></script>

<!-- Popper version 1.16.1 -->
<script src="assets/js/popper.js"></script>

<!-- Font Awesome Free 5.15.4 -->
<script src="assets/js/all.js"></script>

<!-- FontSize JS -->
<script src="assets/js/fontsize.js"></script>

<script type="text/javascript" src="js/main_questionnair.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src='Calendar_new/fullCalendar/lib/main.js'></script>
<script src='Calendar_new/fullCalendar/lib/locales/th.js'></script>

<!-- Search header JS -->
<script src="assets/js/search_header.js"></script>

<!--<script src="calendar/fullCalendar/lib/main.js"></script> -->
<!-- <script src="calendar/fullCalendar/lib/locales/th.js"></script> -->

<script>
    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
<?php
$timestamp_end     =    $_SERVER['REQUEST_TIME_FLOAT'];
$gmtimenow         =     $timestamp_end - $timestamp_start;
$REQUEST_URI     =     $_SERVER['REQUEST_URI'];
?>
<script>
    $(document).ready(function() {
        //select2
        $('.select2').select2({
            width: '100%',
            // theme: "bootstrap"
        });

        $.ajax({
            url: 'func_visitor_stat.php',
            data: {
                'proc': 'VisitorStat',
                't': 'page',
                'filename': '<?php echo $REQUEST_URI; ?>',
                'load': '<?php echo $gmtimenow; ?>',
                'res': screen.width + 'x' + screen.height
            },
            dataType: 'json',
            type: "POST",
            beforeSend: function() {},
            success: function(data) {
                //console.log(data);
            }
        });
    });

    function submitForm(url, formData, nameArray) {

        for (i = 0; i < nameArray.length; i++) {
            if ($('#' + nameArray[i]).val() == '') {
                console.log(nameArray[i])
                messageBox('กรุณากรอก ' + $('#c_' + nameArray[i]).text(), 'Warning!', 'fa fa-exclamation-circle', 'orange', 'btn-orange', 'none'); //เช็คข้อมูลที่ไม่ได้กรอก
                return false;
            }
        }

        $.ajax({
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            type: "POST",
            success: function(data) {
                let object = JSON.parse(data, true);

                if (object.status == "success") { //บันทึกข้อมูลสำเร็จ
                    messageBox(object.message, 'Success!', 'fa fa-check-circle', 'green', 'btn-green', 'show');
                }

                if (object.status == "emailFailed" || //กรอกอีเมลไม่ถูกต้อง  
                    object.status == "phoneFailed" || //กรอกเบอร์โทรไม่ถูกต้อง
                    object.status == "sizeFail" || //ขนาดรูปเกิน
                    object.status == "fileFail" || //นามสกุลไฟล์ไม่ถูกต้อง 
                    object.status == "passOldFailed" || //ไม่พบรหัสผ่าน  
                    object.status == "passconfirmFailed" || //รหัสผ่านใหม่และยืนยันรหัสผ่านไม่ตรงกัน   
                    object.status == "passFailed" || //รหัสผ่านต้องประกอบด้วยภาษาอังกฤษมีพิมพ์ใหญ่พิมพ์เล็กหรือตัวเลขและจำนวนไม่น้อยกว่า 8 ตัว  
                    object.status == "captchaFailed" || //ตรวจสอบแคปซ่า
                    object.status == "warning") { //ตรวจสอบข้อมูล   
                    messageBox(object.message, 'Warning!', 'fa fa-exclamation-circle', 'orange', 'btn-orange', 'show');
                }

                if (object.status == "error") { //error ที่ต้องการแจ้งผู้ใช้
                    messageBox(object.message, 'Error!', 'fa fa-times-circle', 'red', 'btn-red', 'show');
                }
            },
            error: function(data) {
                messageBox("ไม่สามารถส่งข้อมูลได้!", 'Error!', 'fa fa-times-circle', 'red', 'btn-red', 'none'); //ส่งข้อมูลไม่ผ่าน หาไฟล์ ajax ปลายทางไม่พบ
            }
        });
    }

    function messageBox(message, status, icon, color, btnClass, action) {
        if (message == '') {
            location.reload(true);
        } else {
            $.alert({
                title: message,
                content: status,
                icon: icon,
                theme: 'modern',
                type: color,
                typeAnimated: true,
                boxWidth: '30%',
                buttons: {
                    ok: {
                        btnClass: btnClass
                    }
                },
                onAction: function() {
                    if (action == "show") {
                        location.reload(true);
                    }
                }
            });
        }
    }
</script>
</body>

</html>
<?php db::closeDB(); ?>