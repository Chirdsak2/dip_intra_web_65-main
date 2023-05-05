<?php
class vdo
{
    public static function getVdoGroup($vdog_id = null)
    {
        $wh = "";
        if ($vdog_id) {
            $wh .= " AND vdog_id = '{$vdog_id}'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".vdo_group WHERE 1=1 {$wh} ORDER BY vdog_createdate DESC LIMIT 0,3";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetch($_sql);
        $a_dataAll = db::getFetchAll($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "dataAll" => $a_dataAll,
                "count" => $a_row
            );
        }
    }

    public static function getVdoList($vdo_id = null, $vdo_group = null, $vdo_show_vdo = null)
    {
        $wh = "";

        if ($vdo_id) {
            $wh .= " AND vdo_id = '{$vdo_id}'";
        }

        if ($vdo_group) {
            $wh .= " AND vdo_group = '{$vdo_group}'";
        }

        if ($vdo_show_vdo) {
            $wh .= " AND vdog_id = '{$vdo_show_vdo}'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".vdo_list WHERE 1=1 {$wh} ORDER BY vdo_createdate DESC LIMIT 0,3";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetch($_sql);
        $a_dataAll = db::getFetchAll($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "dataAll" => $a_dataAll,
                "count" => $a_row
            );
        }
    }
    public static function ShowAllvdo($vdo_group = null){
        $wh = "";
        if ($vdo_group) {
            $wh .= " AND vdo_group = '{$vdo_group}'";
        }

        $_sql = "SELECT * FROM ". E_DB_NAME. ".vdo_list WHERE 1=1 {$wh} ORDER BY vdo_createdate DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetch($_sql);
        $a_dataAll = db::getFetchAll($_sql);
        if ($a_data) {
            return array(
                "data" => $a_data,
                "dataAll" => $a_dataAll,
                "count" => $a_row
            );
        }
    }
   

}
