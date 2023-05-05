<?php
include("../EWT_ADMIN/comtop_pop.php");

if (!$db->check_permission("preview", "w", "")) {
    echo '<script>';
    echo 'alert("You can not access this section!!");';
    echo 'window.history.back();';
    echo '</script>	';
}

echo '<script type="text/javascript">';
echo 'location.replace("' . HTTP_HOST . '");';
echo '</script>';
exit;
