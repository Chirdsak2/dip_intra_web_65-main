<?php
class notification
{
    public static function article()
    {
        $date = date("Y-m-d");
        $wh = "";
        if ($date) {
            $wh .= " AND DATE(n_approvedate) = '$date'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function ecard($ech_gen_userid = null, $ech_from_userid = null, $sso = null)
    {
        $wh = "";
        if ($ech_gen_userid) {
            $wh .= "AND ech_gen_userid = '{$ech_gen_userid}'";
        }

        if ($ech_from_userid) {
            $wh .= "AND ech_from_userid = '{$ech_from_userid}'";
        }

        $current_date = date("Y-m-d");
        $_sql = "SELECT * FROM " . E_DB_NAME . ".ecard_history WHERE DATE(ech_datetime) = '{$current_date}' 
        {$wh} AND ech_status = 'N' ORDER BY ech_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        // if ($a_row > 0) {
        //     $array_binparam = array(
        //         "SYSTEMS_ID" => $sso->maxId("M_SYSTEMS_WARN", "SYSTEMS_ID"),
        //         "SYSTEMS_NAME" => "คุณได้รับการ์ดวันเกิด " . $a_row . " รายการ",
        //         "SYSTEMS_COUNT" => $a_row,
        //         "SYSTEMS_DATE" => date("Y-m-d")
        //     );

        //     $sql = "INSERT INTO M_SYSTEMS_WARN (SYSTEMS_ID, SYSTEMS_NAME, SYSTEMS_COUNT, SYSTEMS_DATE) 
        //     VALUES (:SYSTEMS_ID, :SYSTEMS_NAME, :SYSTEMS_COUNT, :SYSTEMS_DATE)";
        //     $sso->execute($sql, $array_binparam);
        // }

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function changeProfile($date_current, $sso = null)
    {
        $wh = "";
        if ($date_current) {
            $date = explode('-', $date_current);
            $wh .= "AND MONTH(USR_BIRTH_DATE) = '" . $date[1] . "'";
            $wh .= " AND DAY(USR_BIRTH_DATE) = '" . $date[2] . "'";
        }

        $_sql = "SELECT USR_BIRTH_DATE FROM USR_MAIN WHERE 1=1 {$wh}";
        $a_data = $sso->getFetch($_sql);

        $date_change = date("Y") . '-' . date('m-d', strtotime("+6 months", strtotime($a_data['USR_BIRTH_DATE'])));
        $date_after = date("Y-m-d", strtotime($date_change . "-5 days"));
        $date_current = date('Y-m-d');

        if ($date_current == $date_after) {
            $count = 1;
        } else {
            $count = 0;
        }

        // if ($count > 0) {
        //     $array_binparam = array(
        //         "SYSTEMS_ID" => $sso->maxId("M_SYSTEMS_WARN", "SYSTEMS_ID"),
        //         "SYSTEMS_NAME" => "แจ้งอัพเดทข้อมูลส่วนตัว",
        //         "SYSTEMS_COUNT" => $count,
        //         "SYSTEMS_DATE" => date("Y-m-d")
        //     );

        //     $sql = "INSERT INTO M_SYSTEMS_WARN (SYSTEMS_ID, SYSTEMS_NAME, SYSTEMS_COUNT, SYSTEMS_DATE) 
        //     VALUES (:SYSTEMS_ID, :SYSTEMS_NAME, :SYSTEMS_COUNT, :SYSTEMS_DATE)";
        //     $sso->execute($sql, $array_binparam);
        // }

        return array(
            "date_change" => $date_change,
            "date_after" => $date_after,
            "count" => $count,
        );
    }

    public static function getAbsent($card_no, $sso = null)
    {
        $url = 'http://dev.prd.go.th/api_absent/v1/prd_person/' . $card_no;
        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_HEADER, false);

        // $data = curl_exec($curl);
        // curl_close($curl);
        $data = file_get_contents($url);
        $replace = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
        $result = json_decode($replace, true);

        // if ($result["data"]["absent_amount"] > 0) {
        //     $array_binparam1 = array(
        //         "SYSTEMS_ID" => $sso->maxId("M_SYSTEMS_WARN", "SYSTEMS_ID"),
        //         "SYSTEMS_NAME" => "จำนวนใบลาที่ยังไม่อนุมัติ ".$result["data"]["absent_amount"]." ใบ",
        //         "SYSTEMS_COUNT" => $result["data"]["absent_amount"],
        //         "SYSTEMS_STATUS" => "N",
        //         "SYSTEMS_DATE" => date("Y-m-d"),
        //         "SYSTEMS_API" => '1'
        //     );

        //     $sql1 = "INSERT INTO M_SYSTEMS_WARN (
        //         SYSTEMS_ID, 
        //         SYSTEMS_NAME, 
        //         SYSTEMS_COUNT, 
        //         SYSTEMS_STATUS, 
        //         SYSTEMS_DATE
        //     ) VALUES (
        //         :SYSTEMS_ID, 
        //         :SYSTEMS_NAME, 
        //         :SYSTEMS_COUNT,
        //         :SYSTEMS_STATUS,
        //         :SYSTEMS_DATE,
        //         :SYSTEMS_API
        //     )";
        //     $sso->execute($sql1, $array_binparam1);
        // }else{
        //     $sql1 = "UPDATE M_SYSTEMS_WARN SET SYSTEMS_STATUS = 'Y' WHERE SYSTEMS_API = '1'";
        //     $sso->execute($sql1);
        // }

        // if ($result["data"]["cancel_amount"] > 0) {
        //     $array_binparam2 = array(
        //         "SYSTEMS_ID" => $sso->maxId("M_SYSTEMS_WARN", "SYSTEMS_ID"),
        //         "SYSTEMS_NAME" => "จำนวนใบยกเลิกลาที่ยังไม่อนุมัติ ".$result["data"]["cancel_amount"]." ใบ",
        //         "SYSTEMS_COUNT" => $result["data"]["cancel_amount"],
        //         "SYSTEMS_STATUS" => "N",
        //         "SYSTEMS_DATE" => date("Y-m-d"),
        //         "SYSTEMS_API" => '2'
        //     );

        //     $sql2 = "INSERT INTO M_SYSTEMS_WARN (
        //         SYSTEMS_ID, 
        //         SYSTEMS_NAME, 
        //         SYSTEMS_COUNT, 
        //         SYSTEMS_STATUS, 
        //         SYSTEMS_DATE
        //     ) VALUES (
        //         :SYSTEMS_ID, 
        //         :SYSTEMS_NAME, 
        //         :SYSTEMS_COUNT,
        //         :SYSTEMS_STATUS,
        //         :SYSTEMS_DATE,
        //         :SYSTEMS_API
        //     )";
        //     $sso->execute($sql2, $array_binparam2);
        // }else{
        //     $sql1 = "UPDATE M_SYSTEMS_WARN SET SYSTEMS_STATUS = 'Y' WHERE SYSTEMS_API = '2'";
        //     $sso->execute($sql1);
        // }

        return array(
            "data" => !empty($result["message"]) ? null : $result,
            "count" => !empty($result["message"]) ? 0 : 1
        );
    }
}
