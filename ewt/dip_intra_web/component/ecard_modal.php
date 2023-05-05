<?php
$ecard_list = ecard::getEcardList(); //คำอวยพร
$ecard_greeting = ecard::getEcardGreeting(); //การ์ดวันเกิด
?>
<style>
    .max-height150px {
        max-height: 150px;
    }
</style>
<!-- ฟังก์ชันส่งการ์ดวันเกิด -->
<div class="modal fade" id="modal_birth_date" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_birth_dateLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_birth_date">
                <div class="modal-header border-b-0">
                    <h5 class="modal-title" id="modal_birth_dateLabel"> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="media mb-2" id="list_user_birth_date"></div>
                            <div class="txt-color-purple2 font20px my-4 pl-4 font-weight-bold">
                                เลือกคำอวยพร
                            </div>
                            <div class="pl-4 mb-5 font20px">
                                <?php foreach ($ecard_greeting as $key => $value) { ?>
                                    <div class="custom-control custom-radio py-2">
                                        <input type="radio" class="custom-control-input" name="ech_cid" id="ech_cid<?php echo $key; ?>" value="<?php echo $value['c_id']; ?>" required>
                                        <label class="custom-control-label small2" for="ech_cid<?php echo $key; ?>"> <?php echo $value['c_detail']; ?> </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="txt-color-purple font25px font-weight-bold mb-4">
                                <img src="assets/img/pick_gift_card.png" title="pick gift card" alt="pick gift card" class="mr-3">เลือกรูปแบบการ์ดอวยพร
                            </div>
                            <div class="row">
                                <?php foreach ($ecard_list as $key => $value) { ?>
                                    <div class="form-check mb-5 text-center px-0 mx-2">
                                        <div class="w-100">
                                            <label class="form-check-label" for="ech_ecardid<?php echo $key; ?>">
                                                <img src="<?php echo 'assets/images/ecard/' . $value['ec_filename']; ?>" title="<?php echo $value['ec_name']; ?>" alt="<?php echo $value['ec_name']; ?>" class="pic-hbd max-height150px">
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio py-2 w-100 mx-auto">
                                            <input type="radio" class="form-check-input ml-0" name="ech_ecardid" id="ech_ecardid<?php echo $key; ?>" value="<?php echo $value['ec_id']; ?>" required>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-t-0 mx-auto">
                    <button type="submit" class="send-index"> ส่งการ์ดอวยพร </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(".small2").each(function() {
        text = $(this).text();
        if (text.length > 35) {
            $(this).html(text.substr(0, 35) + '<span class="elipsis">' + text.substr(35) + '</span><a class="elipsis" href="#"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i> ดูเพิ่มเติม</a>');
        }
    });
    $(".small2 > a.elipsis").click(function(e) {
        e.preventDefault();
        $(this).prev('span.elipsis').fadeToggle(500);
    });

    $(document).ready(function() {
        $("#form_birth_date").on("submit", function(event) {
            event.preventDefault();

            let formData = new FormData($(this)[0]);

            $.ajax({
                url: "ajax/main_top_index.modal.ajax.php",
                data: formData,
                processData: false,
                contentType: false,
                type: "POST",
                success: function(data) {
                    //console.log(data);
                    let object = JSON.parse(data, true);
                    if (object.status == "success") {
                        $.alert({
                        	title: 'บันทึกเรียบร้อย',
                        	content: 'ส่งการ์ดอวยพรสำเร็จ',
                        	icon: 'fa fa-check-circle',
                        	theme: 'modern',
                        	type: 'green',
                        	closeIcon: false,
                        	buttons: {
                        		ปิด: function(b) {
                        			location.reload(true);
                        		}
                        	},
                        });
                    } else {
                        $.alert({
                            title: 'ไม่สามารถส่งการ์ดอวยพรได้!',
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

    function setEventEcardId(id, gen_user_id) {
        $.ajax({
            type: 'POST',
            url: 'ajax/main_top_index.modal.ajax.php',
            data: {
                id: id,
                gen_user_id: gen_user_id
            },
            datatype: "text",
            success: function(data) {
                let object = JSON.parse(data, true);
                //console.log(object);
                if (object.status == "getModel") {
                    $('#list_user_birth_date').html(object.output);
                }

            },
            error: function() {
                console.log('Error');
            }
        });
    }
</script>