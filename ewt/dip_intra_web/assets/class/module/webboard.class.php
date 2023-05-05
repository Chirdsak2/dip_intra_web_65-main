<?php
class webboard
{
    //หมวดกระทู้
    public static function getWCate($c_id = null)
    {
        $wh = "";
        if ($c_id) {
            $wh .= "AND c_id = '$c_id'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM w_cate WHERE c_use = 'Y' {$wh} ORDER BY c_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row
            );
        }
    }

    //กระทู้คำถาม
    public static function getWQuestion($t_id = null, $c_id = null)
    {
        $wh = "";
        if ($t_id) {
            $wh .= " AND t_id = '$t_id'";
        }

        if ($c_id) {
            $wh .= " AND c_id = '$c_id'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM w_question WHERE s_id = 1 {$wh} ORDER BY t_date DESC, t_time DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        $f_data = db::getFetch($_sql);

        //ลิมิตคำค้นหารายการกระทู้ล่าสุด 10 รายการ
        $_sql_sh_lm = "SELECT * FROM w_question WHERE 1=1 {$wh} ORDER BY t_date DESC, t_time DESC LIMIT 0, 10";
        $data_sh_lm = db::getFetchAll($_sql_sh_lm);

        if ($a_data) {
            if(!empty($t_id)){
                $res_data = $f_data;
            }elseif(!empty($c_id)){
                $res_data = $f_data;
            }else{
                $res_data = null;
            }

            return array(
                "data" => $a_data,
                "first" => $res_data,
                "data_sh_lm" => $data_sh_lm,
                "count" => $a_row
            );
        }
    }

    //ตอบคำถามกระทู้
    public static function getWAnswer($a_id = null, $t_id = null)
    {
        $wh = "";
        if ($a_id) {
            $wh .= " AND a_id = '$a_id'";
        }

        if ($t_id) {
            $wh .= " AND t_id = '$t_id'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM w_answer WHERE s_id = 1 {$wh} ORDER BY a_date DESC, a_time DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        $f_data = db::getFetch($_sql);

        if ($a_data) {
            if(!empty($a_id)){
                $res_data = $f_data;
            }elseif(!empty($t_id)){
                $res_data = $f_data;
            }else{
                $res_data = null;
            }

            return array(
                "data" => $a_data,
                "first" => $res_data,
                "count" => $a_row
            );

        }
    }

    //แจ้งลบกระทู้หรือลบคำตอบกระทู้
    public static function getWQuestionStsRequest($request_id = null, $t_id = null, $a_id = null, $request_type = null)
    {
        $wh = "";
        if ($request_id) {
            $wh .= "AND request_id = '$request_id'";
        }

        if ($t_id) {
            $wh .= " AND t_id = '$t_id'";
        }

        if ($a_id) {
            $wh .= " AND a_id = '$a_id'";
        }

        if($request_type){
            $wh .= " AND request_type = '$request_type'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM w_question_sts_request WHERE 1=1 {$wh} ORDER BY request_createdate DESC, request_lastdate DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row
            );
        }
    }

    //หมวดกระทู้ / กระทู้คำถาม
    public static function getWQuestionList($start, $per_page, $c_id = null, $t_id = null, $s_search = null)
    {
        $wh = "";
        if ($c_id) {
            $wh .= " AND w_cate.c_id = '$c_id'";
        }

        if ($t_id) {
            $wh .= " AND w_question.t_id = '$t_id'";
        }

        if ($s_search) {
            $wh .= " AND w_question.t_name LIKE '%" . trim($s_search) . "%' ";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT w_question.t_id, w_question.user_id, w_question.t_name, 
        w_question.q_name, w_question.t_date, w_question.t_time, w_question.t_count, w_question.t_top,
        w_question.t_web_name, w_cate.c_id, w_cate.c_name FROM w_cate INNER JOIN w_question ON (w_cate.c_id = w_question.c_id)
        WHERE w_question.s_id = 1 AND w_question.t_sts = 1 AND w_cate.c_use = 'Y' {$wh} 
        ORDER BY CASE WHEN t_top > 0 THEN t_top END DESC, w_question.t_date DESC, w_question.t_time DESC 
        LIMIT {$start},{$per_page}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        //นับจำนวนกระทู้ทั้งหมด
        $_sql_all = "SELECT w_cate.c_use FROM w_cate INNER JOIN w_question ON (w_cate.c_id = w_question.c_id)
        WHERE w_question.s_id = 1 AND w_question.t_sts = 1 AND w_cate.c_use = 'Y' {$wh}";
        $a_row_all = db::getRowCount($_sql_all);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
                "countAll" => $a_row_all,
            );
        }
    }

    //คำถาม / คำตอบ
    public static function getQuestionAnswer($c_id = null, $t_id = null, $a_id = null)
    {
        $wh = "";
        if ($c_id) {
            $wh .= "AND w_question.c_id = '$c_id'";
        }

        if ($t_id) {
            $wh .= "AND w_question.t_id = '$t_id'";
        }

        if ($a_id) {
            $wh .= "AND w_answer.a_id = '$a_id'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT COUNT('*') AS count
        FROM w_question INNER JOIN w_answer ON (w_question.t_id = w_answer.t_id)
        WHERE 1=1 {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $total = 0;
            foreach ($a_data as $value) {
                $total += $value["count"];
            }
            return array(
                "data" => $a_data,
                "count" => $a_row,
                "total" => ($total == 0 ? "" : $total)
            );
        }
    }

    //อิโมจิ
    public static function getEmotion($emotion_id = null){
        $wh = "";
        if ($emotion_id) {
            $wh .= " AND emotion_id = '$emotion_id'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM emotion WHERE emotion_status = 'Y' {$wh} ORDER BY emotion_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row
            );
        }
    }

    //คำไม่สุภาพ
    public static function getVulgar($vulgar_id = null, $vulgar_text = null){
        $wh = "";
        if ($vulgar_id) {
            $wh .= "AND vulgar_id = '$vulgar_id'";
        }

        if($vulgar_text){
            $wh .= "AND vulgar_text LIKE '%$vulgar_text%'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM w_vulgar WHERE vulgar_status = 'Y' {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetch($_sql);
        $a_dataAll = db::getFetchAll($_sql);

        $vulgar_text = array();
        foreach($a_dataAll as $value){
            array_push($vulgar_text, $value["vulgar_text"]);
        }

        if ($a_data) {
            return array(
                "data" => $a_data,
                "dataAll" => $a_dataAll,
                "vulgar_text" => $vulgar_text,
                "count" => $a_row
            );
        }
    }

    //เรียกข้อมูลการตั้งค่า webboard
    public static function getConfig(){
        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM w_config WHERE c_config = '1'";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข้อมูลผู้ใช้
    public static function getUser($gen_user_id = null)
    {
        $wh = "";
        if ($gen_user_id) {
            $wh .= " AND gen_user_id = '$gen_user_id'";
        }

        db::setDB(E_DB_USER);
        $_sql = "SELECT * FROM gen_user WHERE 1=1 {$wh}";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            if (!empty($gen_user_id) && $gen_user_id != 0) {
                $res_data = $a_data;
            } else {
                $res_data = null;
            }

            return $res_data;
        }
    }
}
