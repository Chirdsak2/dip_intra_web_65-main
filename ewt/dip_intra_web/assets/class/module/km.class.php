<?php
class km
{
    //เรียกข้อมูล KM
    public static function getKmPoint($id = null)
    {
        $wh = "";
        if ($id) {
            $wh .= "AND id = '{$id}'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM km_point WHERE km_status = 'Y' {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
       
    }

    //เรียกข้อมูล User 
    public static function getKmUser($id = null, $km_id = null)
    {
        $wh = "";
        if ($id) {
            $wh .= "AND id = '{$id}'";
        }

        if ($km_id) {
            $wh .= "AND km_id = '{$km_id}'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM km_user WHERE 1=1 {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }

    }

    public static function getKm($id = null, $km_id = null, $gen_user_id = null)
    {
        $wh = "";
        if ($id) {
            $wh .= "AND km_user.id = '{$id}'";
        }

        if ($km_id) {
            $wh .= "AND km_user.km_id = '{$km_id}'";
        }

        if($gen_user_id){
            $wh .= "AND km_user.gen_user_id = '{$gen_user_id}'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT km_user.*, km_point.km_point 
        FROM km_user INNER JOIN km_point 
        ON (km_user.km_id = km_point.id)
        WHERE km_point.km_status = 'Y' {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        $point = 0;
        foreach ($a_data as $key => $value) {
            $point += $value["km_point"];
        }

        $array_list["data"] = !empty($a_data) ? $a_data : null;
        $array_list["count"] = $a_row;
        $array_list["km_point"] = $point;
        return $array_list;
    }

    //เก็บคะแนน
    public static function postPoint($km_id = null, $module_id = null, $module_name = null)
    {
        if ($km_id) {
            db::setDB(E_DB_NAME);
            $today = date("Y-m-d");
            $array_insert["km_id"] = $km_id;
            $array_insert["module_id"] = $module_id;
            $array_insert["module_name"] = $module_name;
            $array_insert["username"] = $_SESSION["EWT_USERNAME"];
            $array_insert["name"] = $_SESSION["EWT_NAME"];
            $array_insert["lastname"] = $_SESSION["EWT_SURNAME"];
            $array_insert["gen_user_id"] = $_SESSION["EWT_MID"];
            $array_insert["km_date"] = date("Y-m-d");
            $array_insert["create_date"] = date("Y-m-d H:i:s");

            $sql_ck_at = "SELECT id FROM km_user WHERE km_id = 5 
            AND module_id = {$module_id}
            AND module_name = 'article'
            AND gen_user_id = {$_SESSION['EWT_MID']}
            AND km_date = '{$today}'";
            $row_ck_at = db::getRowCount($sql_ck_at);

            // $sql_ck_wb = "SELECT id FROM km_user WHERE km_id = 3 
            // AND module_id = {$module_id}
            // AND module_name = 'webboard'
            // AND gen_user_id = {$_SESSION['EWT_MID']}
            // AND km_date = '{$today}'";
            // $row_ck_wb = db::getRowCount($sql_ck_wb);

            if ($row_ck_at > 0) {
                return null;
            } else {
                return db::insert('km_user', $array_insert);
            }
        }
    }

    //คะแนนรวม
    public static function getKmtotal($id = null, $km_id = null, $gen_user_id = null)
    {
        $wh = "";
        if ($id) {
            $wh .= "AND km_user.id = '{$id}'";
        }

        if ($km_id) {
            $wh .= "AND km_user.km_id = '{$km_id}'";
        }

        if($gen_user_id){
            $wh .= "AND km_user.gen_user_id = '{$gen_user_id}'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT km_user.*, km_point.km_point , SUM(km_point.km_point) AS km_total
        FROM km_user INNER JOIN km_point 
        ON (km_user.km_id = km_point.id)
        WHERE km_point.km_status = 'Y' {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetch($_sql);


        $point = 0;
        foreach ($a_data as $key => $value) {
            $point += $value["km_point"];
        }

        $array_list["count"] = $a_row;
        $array_list["km_point"] = $point;
        $array_list["km_total"] = $a_data["km_total"];
        return $array_list;


    }
}
