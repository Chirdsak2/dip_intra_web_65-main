<?php $ech_history_birthdate = ecard::getEcardHistory($_SESSION["EWT_MID"]); ?>
<div class="card-profile shadow">
    <img src="<?php echo $webb_image; ?>" class="img-100w img-db mrtop shadow mb-3" alt="<?php echo $full_name; ?>" title="<?php echo $full_name; ?>">
    <div style="font-size:14px" ;> <?php echo $full_name; ?> </div>
    <small><i class="far fa-user"></i> <?php echo mb_strimwidth($pos_name, 0, 17, '...'); ?> | <i class="far fa-folder-open"></i> <?php echo mb_strimwidth($name_org, 0, 17, '...'); ?></small>

    <div class="text-left mt-2">
        <ul class="profile-menu list-group list-group-flush">
            <li class="list-group-item"><i class="fa  fa-home"></i><a href="setting_profile.php" title="หน้าหลัก "> หน้าหลัก </a>
            </li>
            <li class="list-group-item"><i class="fa fa-user-edit"></i>
                <a href="edit_profile.php" title="มูลส่วนตัว"> มูลส่วนตัว</a>
            </li>
            <li class="list-group-item"><i class="fa fa-bell"></i>
                <a href="notify_warn.php" title="แจ้งเตือน"> แจ้งเตือน</a>
                <?php if ($noti_count > 0) { ?>
                    <span class="badge badge-profile"><?php echo $noti_count; ?></span>
                <?php } ?>
            </li>
            <li class="list-group-item"><i class="fas fa-birthday-cake"></i>
                <a href="receive_card_hbd.php" title="การ์ดวันเกิด"> การ์ดวันเกิด </a>
                <span class="badge badge-profile"><?php echo $ech_history_birthdate['count']; ?></span>
            </li>

            <li class="list-group-item"><i class="fa fa-folder"></i>
                <a href="setting_system.php" title="ตั้งค่าระบบงาน"> ตั้งค่าระบบงาน</a>
            </li>
            <li class="list-group-item"><i class="fa fa-key"></i>
                <a href="setting_password.php" title="เปลี่ยนรหัสผ่าน"> เปลี่ยนรหัสผ่าน</a>
            </li>
            <li class="list-group-item"><i class="fa fa-sign-out-alt"></i> <a href="logout.php" title="ออกจากระบบ">ออกจากระบบ</a>
            </li>
        </ul>
    </div>
</div>