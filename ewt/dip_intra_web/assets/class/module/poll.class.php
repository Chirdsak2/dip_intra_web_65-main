<?php
class poll
{
    public static function getPollListLimit($start, $perpage, $s_search = null)
    {
        $wh = "";
        if ($s_search) {
            $wh .= "AND c_name LIKE '%" . trim($s_search) . "%' ";
        }

        $date_now = date('Y-m-d');
        $wh = "AND ((c_start = '' AND c_stop = '')";
        $wh .= "OR ('{$date_now}' between c_start AND c_stop))";

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM poll_cat WHERE c_approve = 'Y' {$wh} ORDER BY c_id DESC LIMIT {$start},{$perpage} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        $_sql_all = "SELECT c_id FROM poll_cat WHERE c_approve = 'Y' {$wh}";
        $a_row_all = db::getRowCount($_sql_all);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
                "countAll" => $a_row_all
            );
        }
    }

    public static function getPoll($s_cid)
    {
        $wh = "";
        if ($s_cid) {
            $wh .= "AND c_id = '{$s_cid}'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM poll_cat WHERE c_approve = 'Y'  {$wh}  ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getPollAswer($s_cid)
    {
        $wh = "";
        if ($s_cid) {
            $wh .= "AND c_id = '{$s_cid}'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM poll_ans WHERE  1=1  {$wh}  ORDER BY a_position ASC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getPollAswerSum($s_cid, $field)
    {
        $wh = "";
        if ($s_cid) {
            $wh .= "AND c_id = '{$s_cid}'";
        }

        $sum_field = 'SUM(' . $field . ')';

        db::setDB(E_DB_NAME);
        $_sql = "SELECT {$sum_field} AS total FROM poll_ans WHERE  1=1  {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetch($_sql);
        if ($a_data) {
            return $a_data['total'];
        }
    }

    public static function getPollVote($c_id, $a_id, $time_check = null)
    {
        db::setDB(E_DB_NAME);
        if ($a_id) {
            $array_insert = array(
                'c_id' => $c_id,
                'a_id' => $a_id,
                'ip' => getIP(),
                'date' => date('Y-m-d'),
                'time' => (empty($time_check) ? date('H:i') : $time_check),
                'uid' => $_SESSION['EWT_MID'],
            );

            if (db::insert('poll_log', $array_insert) == true) {
                $_sql = "UPDATE poll_ans SET a_counter = a_counter + 1 WHERE a_id = '{$a_id}' ";
                db::getFetch($_sql);
                $result = "success";
            } else {
                $result = "error";
            }
        }

        return $result;
    }

    public static function getPollLog($c_id, $a_id, $uid)
    {
        $wh = "";
        if ($c_id) {
            $wh .= "AND c_id = '{$c_id}'";
        }

        if ($a_id) {
            $wh .= "AND a_id = '{$a_id}'";
        }

        if ($uid) {
            $wh .= "AND uid = '{$uid}'";
        }

        $wh .= " AND date =  '" . date('Y-m-d') . "' ";

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM poll_log WHERE 1=1 {$wh} ORDER BY poll_log_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }
}
