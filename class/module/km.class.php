<?php
class km
{

    public static function getKmPoint($id = null, $status = null)
    {
        global $db;
        $wh = "";
        if ($id) {
            $wh .= "AND id = '{$id}'";
        }

        if ($status == 'Y') {
            $wh .= "AND km_status = 'Y'";
        }
        
        if ($status == 'N') {
            $wh .= "AND km_status = 'N'";
        }

        $_sql = $db->query("SELECT * FROM km_point WHERE 1=1 {$wh}");

        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_data[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function getKmUser($id = null)
    {
        global $db;
        $wh = "";
        if ($id) {
           $wh .= "AND id = '{$id}'";
        }

        $_sql = $db->query("SELECT * FROM km_user WHERE 1=1 {$wh}");

        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_data[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }
}
