<?php
class ecard
{
    public static function getEcardList($ec_id = null)
    {
        $wh = "";
        if ($ec_id) {
            $wh .= "AND ec_id = '{$ec_id}'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM ecard_list WHERE ec_status = 'Y' {$wh} ORDER BY ec_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getEcardGreeting($c_id = null)
    {
        $wh = "";
        if ($c_id) {
            $wh .= "AND c_id = '{$c_id}'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM ecard_greeting WHERE c_status = 'Y' {$wh} ORDER BY c_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    public static function getEcardHistory($ech_gen_userid, $ech_date = null, $ech_date_year = null)
    {
        $current_year = date('Y');

        $wh = "";

        if($ech_date){
            $wh = " AND DATE(ech_datetime) = '{$ech_date}'";
        }

        if($ech_date_year){
            $wh .= " AND YEAR(ech_datetime) = '{$ech_date_year}'";
        }else{
            $wh .= " AND YEAR(ech_datetime) = '{$current_year}'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM ecard_history WHERE ech_gen_userid = '{$ech_gen_userid}' {$wh} ORDER BY ech_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function getEcardUser($date_current)
    {
        $wh = "";
        if ($date_current) {
            $date = explode('-', $date_current);
            $wh .= " AND MONTH(birth_date) = '" . $date[1] . "'";
            $wh .= " AND DAY(birth_date) = '" . $date[2] . "'";
        }

        db::setDB(E_DB_USER);
        $_sql = "SELECT * FROM gen_user WHERE birth_status = 'Y' {$wh} ORDER BY gen_user_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        return array(
            "data" => $a_data,
            "count" => $a_row,
        );
    }

    public static function getChangePassword($date_current, $color = null)
    {
        $wh = "";
        if ($date_current) {
            $date = explode('-', $date_current);
            $wh .= "AND MONTH(birth_date) = '" . $date[1] . "'";
            $wh .= " AND DAY(birth_date) = '" . $date[2] . "'";
        }

        db::setDB(E_DB_USER);
        $_sql = "SELECT birth_date FROM gen_user WHERE birth_status = 'Y' {$wh} ORDER BY gen_user_id DESC";
        $a_data = db::getFetch($_sql);

        $date_change = date('m-d', strtotime("+6 months", strtotime($a_data['birth_date'])));
        $date_current = date('m-d');

        $txt = '';
        if ($date_current == $date_change) {

            if (!empty($color)) {
                $txt_color = $color;
            } else {
                $txt_color = "text-danger";
            }

            $txt .= '<a href="setting_profile.php">';
            $txt .= '<div class="font10px mt-1 ' . $txt_color . '">';
            $txt .= '<i class="fas fa-exclamation-circle"></i> ถึงเวลาอัพเดทข้อมูลส่วนตัวแล้วนะคะ';
            $txt .= '</div>';
            $txt .= '</a>';
        }

        return $txt;
    }
}
