<?php
function gen_pic($subject)
{
?>
    <div class="form-group row">
        <label for="inputuser" class="col-sm-3 col-form-label font18px"><span class="red">*</span> ความปลอดภัย </label>
        <div class="col-sm-9">
            <div class="w-100 max-width350px text-center">
                <div class="bg-captcha" id="logpic_<?php echo $subject; ?>">
                    <img src="<?php echo HOST_CAPTCHA; ?>?subject=<?php echo $subject; ?>" title="captcha" alt="captcha" class="mx-auto">
                </div>
                <a href="#" id="btn_captcha" onclick="Getmessage_<?php echo $subject; ?>('');return false;" style="cursor: pointer;">
                    <div class="re-captcha mb-2"> คลิกเพื่อเปลี่ยนรูป <i class="fas fa-sync-alt"></i> </div>
                </a>
            </div>
            <input type="text" class="form-control max-width350px font18px" name="chkpic1_<?php echo $subject; ?>" id="chkpic1_<?php echo $subject; ?>" placeholder="กรอกรหัสความปลอดภัย">
            <input type="hidden" name="captcha_id" value="<?php echo $subject; ?>">

            <div class="text-center mt-2 webboard_captcha" id="list_captcha" style="display: none;">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <small>กรุณาตรวจสอบรหัสความปลอดภัยของท่านให้ถูกต้องค่ะ!</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function Getmessage_<?php echo $subject; ?>() {
            current_local_time = new Date();
            document.getElementById('logpic_<?php echo $subject; ?>').innerHTML = '<img src="<?php echo HOST_CAPTCHA; ?>?subject=<?php echo $subject; ?>" title="captcha" alt="captcha" class="mx-auto">';
        }
    </script>
<?php } ?>

<?php
function gen_pic2($subject)
{
?>
    <div class="form-group row">
        <label for="inputuser" class="col-sm-3 col-form-label font18px"><span class="red">*</span> ความปลอดภัย </label>
        <div class="col-sm-9">
            <div class="w-100 max-width350px text-center">
                <div class="bg-captcha" id="logpic_<?php echo $subject; ?>">
                    <img src="<?php echo HOST_CAPTCHA; ?>?subject=<?php echo $subject; ?>" title="captcha" alt="captcha" class="mx-auto">
                </div>
                <a href="#" id="btn_captcha" onclick="Getmessage_<?php echo $subject; ?>('');return false;" style="cursor: pointer;">
                    <div class="re-captcha mb-2"> คลิกเพื่อเปลี่ยนรูป <i class="fas fa-sync-alt"></i> </div>
                </a>
            </div>
            <input type="text" class="form-control max-width350px font18px" name="chkpic1_<?php echo $subject; ?>" id="chkpic1_<?php echo $subject; ?>" placeholder="กรอกรหัสความปลอดภัย">
            <input type="hidden" name="captcha_id" value="<?php echo $subject; ?>">

            <div class="text-center mt-2 webboard_captcha" id="list_captcha" style="display: none;">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <small>กรุณาตรวจสอบรหัสความปลอดภัยของท่านให้ถูกต้องค่ะ!</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function Getmessage_<?php echo $subject; ?>() {
            current_local_time = new Date();
            document.getElementById('logpic_<?php echo $subject; ?>').innerHTML = '<img src="<?php echo HOST_CAPTCHA; ?>?subject=<?php echo $subject; ?>" title="captcha" alt="captcha" class="mx-auto">';
        }
    </script>
<?php } ?>