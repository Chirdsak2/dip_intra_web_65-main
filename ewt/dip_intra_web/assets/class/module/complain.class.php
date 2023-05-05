<?php
class complain
{
    public static function getComplainInfo($com_cid = null)
    {

        $wh = "";

        if ($com_cid) {
            $wh .= "AND Complain_lead_ID = '{$com_cid}'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".m_complain_info WHERE Complain_status_use = '' {$wh} ORDER BY Complain_lead_ID DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row
            );
        }
    }

    public static function getComplain($com_cid = null)
    {

        $wh = "";

        if ($com_cid) {
            $wh .= "AND flag = '{$com_cid}'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".m_complain WHERE `status` = '' {$wh} ORDER BY `date` DESC, `time` DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row
            );
        }
    }
}
