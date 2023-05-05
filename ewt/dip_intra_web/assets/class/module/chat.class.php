<?php
class chat
{
    public static function getChatLog($s_where = null)
    {
        $_wh = "";
        if ($s_where) {
            $a_where = array();
            foreach ((array)$s_where as $_key => $_item) {
                $a_where[] = $_key . "='" . $_item . "'";
            }
            $_wh .= implode(' AND ', $a_where);
        } else {
            $_wh .= "1=1";
        }

        $_sql = "SELECT * FROM ".E_DB_NAME.".chat_log WHERE {$_wh} ORDER BY chat_id ASC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetch($_sql);
        $a_dataAll = db::getFetchAll($_sql);

        if ($a_row) {
            return array(
                "data" => $a_data,
                "dataAll" => $a_dataAll
            );
        }
    }

    public static function getChatUser($s_where = null)
    {
        $_wh = "";
        if ($s_where) {
            $a_where = array();
            foreach ((array)$s_where as $_key => $_item) {
                $a_where[] = $_key . "='" . $_item . "'";
            }
            $_wh .= implode(' AND ', $a_where);
        } else {
            $_wh .= "1=1";
        }

        $_sql = "SELECT * FROM ".E_DB_NAME.".chat_log WHERE {$_wh} GROUP BY chat_from_id ORDER BY chat_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetch($_sql);
        $a_dataAll = db::getFetchAll($_sql);

        if ($a_row) {
            return array(
                "data" => $a_data,
                "dataAll" => $a_dataAll,
            );
        }
    }

    public static function getUser($chat_ids = null, $s_search = null)
    {
        $_wh = "";
        if ($s_search) {
            if (!preg_match('/[^A-Za-z0-9_\\-]/', trim($s_search))) {
                $_wh .= " AND name_eng LIKE '%" . trim($s_search) . "%' ";
                $_wh .= " OR surname_eng LIKE '%" . trim($s_search) . "%' ";
            } else {
                $_wh .= " AND name_thai LIKE '%" . trim($s_search) . "%' ";
                $_wh .= " OR surname_thai LIKE '%" . trim($s_search) . "%' ";
            }
        }

        if ($chat_ids) {
            $_wh .= " AND gen_user_id IN ($chat_ids) ";
            $orderBy = " ORDER BY field(gen_user_id, $chat_ids)";
        }

        $_sql = "SELECT * FROM ".E_DB_USER.".gen_user WHERE 1=1 {$_wh} {$orderBy} LIMIT 0,50";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }
}
