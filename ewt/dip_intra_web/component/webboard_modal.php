<script>
    //POST แสดงความคิด, แจ้งลบกระทู้, แจ้งลบความคิดเห็น
    $(document).ready(function() {
        $(".webboard").on("submit", function(event) {
            event.preventDefault();

            // let request_reason = "";
            // if (CKEDITOR.instances['request_reason'] !== undefined) {
            //     request_reason = CKEDITOR.instances['request_reason'].getData();
            // }

            let a_detail = "";
            if (CKEDITOR.instances['a_detail'] !== undefined) {
                a_detail = CKEDITOR.instances['a_detail'].getData();
            }

            let t_detail = "";
            if (CKEDITOR.instances['t_detail'] !== undefined) {
                t_detail = CKEDITOR.instances['t_detail'].getData();
            }

            let formData = new FormData($(this)[0]);

            formData.append('t_id', '<?php echo $t_id; ?>');
            formData.append('t_detail', t_detail);
            formData.append('a_detail', a_detail);
            //formData.append('request_reason', request_reason);

            $.ajax({
                url: "ajax/webboard.ajax.php",
                data: formData,
                processData: false,
                contentType: false,
                type: "POST",
                success: function(data) {
                    let object = JSON.parse(data, true);
                    if (object.status == "captchaFailed") {
                        $('.webboard_captcha').show();
                    } else if (object.status == "success") {
                        // $.alert({
                        // 	title: 'บันทึกเรียบร้อย',
                        // 	content: object.type_text,
                        // 	icon: 'fa fa-check-circle',
                        // 	theme: 'modern',
                        // 	type: 'green',
                        // 	closeIcon: false,
                        // 	buttons: {
                        // 		ปิด: function(b) {
                        // 			location.reload(true);
                        // 		}
                        // 	},
                        // });
                        location.reload(true);
                    } else {
                        $.alert({
                            title: 'เกิดข้อผิดพลาด',
                            content: object.type_text,
                            icon: 'fa fa-times-circle',
                            theme: 'modern',
                            type: 'red',
                            closeIcon: false,
                            buttons: {
                                ปิด: function(b) {
                                    location.reload(true);
                                }
                            },
                        });
                    }
                },
                error: function(data) {
                    console.log('Error');
                }
            });
        });
    });

    // c_id ไอดีหมวดกระทู้ || t_id ไอดีกระทู้ || a_id ไอดี ความคิดเห็น || a_id_number ลำดับความคิดเห็น
    function setEventWebboardId(c_id, t_id, a_id, a_id_number, type, list) {
        $.ajax({
            type: 'POST',
            url: 'ajax/webboard_modal.ajax.php',
            data: {
                c_id: c_id,
                t_id: t_id,
                a_id: a_id,
                a_id_number: a_id_number,
                type: type,
                list: list
            },
            datatype: "text",
            success: function(data) {
                let object = JSON.parse(data, true);
                if (object.status == "success") {
                    $('#' + object.list).html(object.output);
                } else {
                    $.alert({
                        title: 'เกิดข้อผิดพลาด',
                        content: 'กรุณาติดต่อผู้ดูแลระบบ',
                        icon: 'fa fa-times-circle',
                        theme: 'modern',
                        type: 'red',
                        closeIcon: false,
                        buttons: {
                            ปิด: function(b) {
                                location.reload(true);
                            }
                        },
                    });
                }
            },
            error: function() {
                console.log('Error');
            }
        });
    }

    $('.btn_close').click(function() {
        $('.webboard_captcha').hide();
    });
</script>