<?php
class sso
{
    //เชื่อมต่อฐานข้อมูล
    public function __construct()
    {
        $db_host = '172.16.1.185';
        $db_name = 'PRD_INTRA_SSO';
        $db_user = 'PRD_INTRA_SSO';
        $db_pass = '550PrD';

        try {
            $conn = new PDO("sqlsrv:server=$db_host; Database=$db_name", $db_user, $db_pass);
            //echo "Connected to database";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $this->conn = $conn;
    }

    //เข้าสู่ระบบ API DEPIS
    public function getLogin()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://prd.dpis.go.th/oapi/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"username":"intranet@prd.go.th", "password":"prd1010"}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $result = json_decode($response, true);
        return $result;
    }

    //เรียกข้อมูลบุคลากร DEPIS
    public function getPersonnel($per_cardno = null)
    {
        $login = self::getLogin();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://prd.dpis.go.th/oapi/open_api_users/callapi',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => 'endpoint=personal_all&per_cardno=' . $per_cardno . '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $login["accessToken"],
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response, true);

        if ($result["error"]["statusCode"] == 504) {
            return $result["error"]["statusCode"];
        } else {
            $data_api = self::ssl_decrypt_api($result["data"], $login["encrypt_key"]);
            $res_data = json_decode($data_api, true);
            return $res_data;
        }
    }

    //เรียกข้อ DEPIS แบบมีเงื่อนไข
    public function getDepis($array = array())
    {
        if (sizeof($array) > 0) {
            $paramiter = "";
            foreach ($array as $key => $field) {
                $paramiter .= "&" . $key . "=" . $field;
            }
        }

        $login = self::getLogin();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://prd.dpis.go.th/oapi/open_api_users/callapi',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => 'endpoint=personal_all' . $paramiter,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $login["accessToken"],
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response, true);

        $data_api = self::ssl_decrypt_api($result["data"], $login["encrypt_key"]);
        $res_data = json_decode($data_api, true);
        return $res_data;

        // if ($result["error"]["statusCode"] == 504) {
        //     return $result["error"]["statusCode"];
        // } else {
        //     $data_api = self::ssl_decrypt_api($result["data"], $login["encrypt_key"]);
        //     $res_data = json_decode($data_api, true);
        //     return $res_data;
        // }
    }

    //ฟังก์ชันถอดรหัส API DEPIS
    public function ssl_decrypt_api($string, $skey)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = base64_encode(md5($skey));
        $secret_iv = md5(base64_encode(md5($skey)));
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }

    //ฟังก์ชันเข้ารหัสข้อมูล
    public function encrypt($s_string, $s_key, $s_iv)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = $s_key;
        $secret_iv = $s_iv;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        return base64_encode(openssl_encrypt($s_string, $encrypt_method, $key, 0, $iv));
    }

    //ฟังก์ชันถอดรหัสข้อมูล
    public function decrypt($s_string, $s_key, $s_iv)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = $s_key;
        $secret_iv = $s_iv;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        return openssl_decrypt(base64_decode($s_string), $encrypt_method, $key, 0, $iv);
    }

    //ฟังก์ชันเข้ารหัสข้อมูล 2
    function endcode($string, $key)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }

        return base64_encode($result);
    }

    //ฟังก์ชันถอดรหัสข้อมูล 2
    function decode($string, $key)
    {
        $result = '';
        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }

        return $result;
    }

    //ค้นหา Array โดยใช้ Key Value
    public function getSearch($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, self::getSearch($subarray, $key, $value));
            }
        }

        return $results;
    }

    //เช็คสถาณะผู้ใช้
    public function checkMovement($movement = null, $per_status = null, $per_type_id = null)
    {
        $array = array(
            'ถึงแก่ความตาย',
            'ถึงแก่กรรม',
            'ประเภทถึงแก่กรรม',
            'ประเภทลาออก',
            'ไล่ออก',
            'ไล่ออกจากราชการ',
            'ลงโทษไล่ออกจากราชการ',
            'ลงโทษไล่ออกราชการ',
            'ให้ออก',
            'ให้ออกจากราชการ',
            'ให้ออกจากราชการเหตุวินัย',
            'ให้ออกจากราชการเนื่องจากเหตุเสียชีวิต',
        );

        if (empty($movement)) {
            return true;
        }

        switch ($per_status) {
            case 1:
                return false;
                break;
            case 2:
                switch ($per_type_id) {
                    case 5:
                        if (in_array($movement, $array)) {
                            return true;
                        } else {
                            return false;
                        }
                        break;
                    case 42:
                        if (in_array($movement, $array)) {
                            return true;
                        } else {
                            return false;
                        }
                        break;
                    case 43:
                        return true;
                        break;
                    case 53:
                        return true;
                        break;
                }
                break;
            default:
                return true;
                break;
        }
    }

    //สร้าง username ด้วยชื่อ และ นามสกุลตัวแรก
    public function genUsername($name, $lastname)
    {
        $array = array();
        $gen_n = trim($name);
        $gen_l = strlen(trim($lastname));
        for ($i = 0; $i < $gen_l; $i++) {
            if ($gen_n . "_" . substr(trim($lastname), 0, -$i) != $gen_n . "_") {
                array_push($array, $gen_n . "_" . substr(trim($lastname), 0, -$i));
            }
        }

        array_push($array, $gen_n . "_" . trim($lastname));
        sort($array);

        if ($array) {
            $username = '';
            foreach ($array as $gen_user) {
                $array_bindparam = array("USR_USERNAME" => trim($gen_user));
                $sql = "SELECT USR_ID FROM USR_MAIN WHERE USR_USERNAME = ':USR_USERNAME'";
                $count = self::getRowCount($sql, $array_bindparam);
                if ($count == 0) {
                    $username .= strtolower($gen_user);
                    break;
                }
            }
            return array(
                "genuser" => $array,
                "username" => $username
            );
        }
    }

    //ฟังก์ชันแปลง Array
    public function setArray2String($dataArray, $operator = ", ")
    {
        $data = array();

        foreach ($dataArray as $_key => $_val) {
            if ($_key != "") {
                $data[] = $_key . " = '" . $_val . "'";
            }
        }

        return implode($operator, $data);
    }

    //ฟังก์ชันเช็คตัวแปร
    public function bind($s_value)
    {
        switch (true) {
            case is_bool($s_value):
                $var_type = PDO::PARAM_BOOL;
                break;
            case is_int($s_value):
                $var_type = PDO::PARAM_INT;
                break;
            case is_null($s_value):
                $var_type = PDO::PARAM_NULL;
                break;
            default:
                $var_type = PDO::PARAM_STR;
                break;
        }

        return $var_type;
    }

    //ฟังก์ชันแปลงค่าตัวแปลเป็น String SQL
    public function pdoBindArray(&$_query, &$_paArray)
    {
        foreach ($_paArray as $key => &$val) {
            @$_query->bindParam(':' . $key, $val, self::bind($val));
        }
    }

    //ฟังก์ดำเนินการข้อมูล
    public function execute($sql, $s_param = false)
    {
        try {
            $query = $this->conn->prepare($sql);
            if ($query) {
                if ($s_param) {
                    self::pdoBindArray($query, $s_param);
                }

                $query->execute();
                return true;
            }
            return false;
        } catch (PDOException $exc) {
            return false;
        }

        $this->conn = null;
    }

    //Query ข้อมูล 1 row
    public function getFetch($sql, $s_param = false)
    {
        try {
            $query = $this->conn->prepare($sql);
            if ($query) {
                if ($s_param) {
                    self::pdoBindArray($query, $s_param);
                }

                $query->execute();
                return $query->fetch();
            }
            return false;
        } catch (PDOException $exc) {
            return false;
        }

        $this->conn = null;
    }

    //Query ข้อมูลทั้งหมด
    public function getFetchAll($sql, $s_param = false)
    {
        try {
            $query = $this->conn->prepare($sql);
            if ($query) {
                if ($s_param) {
                    self::pdoBindArray($query, $s_param);
                }

                //return $s_param;
                $query->execute();
                return $query->fetchAll();
            }
            return false;
        } catch (PDOException $exc) {
            return false;
        }

        $this->conn = null;
    }

    //นับจำนวน row ที่ Query
    public function getRowCount($sql, $s_param = false)
    {
        try {
            $query = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            if ($query) {
                if ($s_param) {
                    self::pdoBindArray($query, $s_param);
                }

                $query->execute();
                return $query->rowCount();
            }
            return false;
        } catch (PDOException $exc) {
            return false;
        }

        $this->conn = null;
    }

    //เรียกข้อมูล ID ล่าสุด
    public function maxId($s_table, $field)
    {
        $sql = "SELECT MAX($field) AS $field FROM $s_table";
        $data = self::getFetch($sql);
        return $data[$field] + 1;
    }

    //เพิ่มข้อมูล
    public function insert($s_table, $s_data = array())
    {
        try {
            $a_source = array();
            $a_value = array();
            $a_param = array();
            $a_keys = array();
            if ($s_data) {
                foreach ((array) $s_data as $_key => $_item) {
                    array_push($a_source, $_key);
                    array_push($a_value, "'" . $_item . "'");
                    array_push($a_keys, ":" . $_key);
                }

                $_sql = 'INSERT INTO ' . $s_table . ' (' . implode(',', $a_source) . ') VALUES (' . implode(',', $a_value) . ')';
                if (self::execute($_sql) == true) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        $this->conn = null;
    }

    //แก้ไขข้อมูล
    public function update($tbName, $data, $cond)
    {
        if (count($data) > 0) {
            $updateData = self::setArray2String($data);
            $condition = self::setArray2String($cond, " and ");

            $setSQL = "UPDATE " . $tbName . " SET " . $updateData . " WHERE 1=1 and " . $condition;
            if (self::execute($setSQL) == true) {
                return true;
            } else {
                return false;
            }
        }

        $this->conn = null;
    }

    //ลบข้อมูล
    public function del($s_table, $s_where = array())
    {
        $a_where = array();
        foreach ((array) $s_where as $_key => $_item) {
            $a_where[] = $_key . "='" . $_item . "'";
        }

        $_sql = "DELETE FROM {$s_table} WHERE " . implode(" AND ", $a_where);
        if (self::execute($_sql) == true) {
            return true;
        } else {
            return false;
        }

        $this->conn = null;
    }

    //เช็คสถาณะ User
    public function getUserStatusLogin($username)
    {
        $array_bindparam = array("USR_USERNAME" => trim($username));
        $sql = "SELECT USR_MOVEMENT,USR_PRE_STATUS, USR_PERTYPE_ID FROM USR_MAIN WHERE USR_USERNAME = :USR_USERNAME";
        $data = self::getFetch($sql, $array_bindparam);

        if ($data) {
            return self::checkMovement($data["USR_MOVEMENT"], $data["USR_PRE_STATUS"], $data["USR_PERTYPE_ID"]);
        } else {
            return false;
        }
    }

    //เรียกข้อมูลผู้ใช้งาน
    public function getUser($USR_USERNAME = null, $USR_ID = null, $USR_CARDNO = null)
    {
        $wh = "";
        if ($USR_USERNAME) {
            $wh .= " AND USR_USERNAME = :USR_USERNAME";
            $arr_wh1 = array("USR_USERNAME" => trim($USR_USERNAME));
        }

        if ($USR_ID) {
            $wh .= " AND USR_ID = :USR_ID";
            $arr_wh2 = array("USR_ID" => trim($USR_ID));
        }

        if ($USR_CARDNO) {
            $wh .= " AND USR_CARDNO = :USR_CARDNO";
            $arr_wh3 = array("USR_CARDNO" => trim($USR_CARDNO));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array(),
            !empty($arr_wh3) ? $arr_wh3 : array()
        );

        $sql = "SELECT * FROM USR_MAIN WHERE USR_STATUS = 'Y' {$wh}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if (!empty($USR_USERNAME) || !empty($USR_ID) || !empty($USR_CARDNO)) {
            $res_data = $data;
            $res_dataAll = $dataAll;
            $res_count = $count;
        } else {
            $res_data = null;
            $res_dataAll = null;
            $res_count = null;
        }

        $array_list = array();
        $array_list["data"] = $res_data;
        $array_list["dataAll"] = $res_dataAll;
        $array_list["count"] = $res_count;
        return $array_list;
    }

    //เช็คข้อมูลผู้ใช้งาน
    public function getChkUserDepis($USR_CARDNO)
    {
        $array_bindparam = array("USR_CARDNO" => trim($USR_CARDNO));
        $sql = "SELECT * FROM USR_MAIN WHERE USR_STATUS = 'Y' AND USR_CARDNO = :USR_CARDNO AND USR_CARDNO != '' ";
        $data = self::getFetch($sql, $array_bindparam);
        $count = self::getRowCount($sql, $array_bindparam);

        if ($data) {
            $array_list = array();
            $array_list["data"] = $data;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลคำนำหน้าผู่ใช้งาน
    public function getTitle($PREFIX_ID = null)
    {
        $wh = "";
        if ($PREFIX_ID) {
            $wh .= " AND PREFIX_ID = :PREFIX_ID";
            $arr_wh1 = array("PREFIX_ID" => trim($PREFIX_ID));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array()
        );

        $sql = "SELECT * FROM USR_PREFIX WHERE 1=1 {$wh}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            $array_list["data"] = !empty($PREFIX_ID) ? $data : null;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลการลงทะเบียน
    public function getRegister($S_WHERE = null)
    {
        $wh = "";

        if ($S_WHERE) {
            $a_where = array();
            foreach ((array)$S_WHERE as $_key => $_item) {
                $a_where[] = $_key . "='" . $_item . "'";
            }
            $wh .= implode(' AND ', $a_where);
        } else {
            $wh .= "1=1";
        }

        $sql = "SELECT * FROM WFR_REGISTER WHERE {$wh}";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            if (!empty($REGIS_IDCARD)) {
                $res_data = $data;
            } else {
                $res_data = null;
            }

            $array_list["data"] = $res_data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เช็คข้อมูลผู้ใช้งาน Depis เรียกข้อมูลผู้ใช้งานสำหรับการลงทะเบียน
    public function getUserRegister($per_cardno)
    {
        $user_depis = self::getPersonnel($per_cardno); //เช็คข้อมูล user ในระบบ dpis
        if ($user_depis == 504) {
            return "Gateway Timeout";
        }

        if (sizeof($user_depis) > 0) { //พบข้อมูล user ในระบบ dpis
            $dpis = $user_depis[0]; //เรียกข้อมูล array user
            $user_depis = self::getUser(null, null, $dpis["per_cardno"])["data"]; //เช็คข้อมูล user ในระบบ sso
            if (empty($user_depis)) { //ไม่พบข้อมูล user ในระบบ sso => Insert ข้อมูล user เข้าระบบ sso 
                $array_insert = array();
                $array_insert["USR_ID"] = self::maxId("USR_MAIN", "USR_ID");
                $array_insert["USR_PREFIX"] = $dpis["prename_th"];
                $array_insert["USR_FNAME"] = $dpis["per_name"];
                $array_insert["USR_LNAME"] = $dpis["per_surname"];
                $array_insert["USR_PREFIX_EN"] = $dpis["prename_en"];
                $array_insert["USR_FNAME_EN"] = $dpis["per_eng_name"];
                $array_insert["USR_LNAME_EN"] = $dpis["per_eng_surname"];
                $array_insert["USR_EMAIL"] = $dpis["per_email"];
                $array_insert["USR_TEL"] = $dpis["per_mobile"];
                $array_insert["USR_STATUS"] = "Y";
                $array_insert["USR_DEPARTMENT"] = $dpis["pos_organize_th"];
                $array_insert["USR_DIVISION"] = $dpis["division"];
                $array_insert["USR_CARDNO"] = $dpis["per_cardno"];
                $array_insert["USR_LEVEL_NAME"] = $dpis["per_levelname"];
                $array_insert["USR_BIRTH_DATE"] = $dpis["birth_date"];
                $array_insert["USR_PRE_STATUS"] = $dpis["per_status"];
                $array_insert["USR_MOVEMENT"] = $dpis["movement"];
                $array_insert["USR_POSITION"] =  $dpis["linename_th"];
                $array_insert["USR_MPOSITION"] =  $dpis["mposition"];

                if (self::insert("USR_MAIN", $array_insert) == true) {
                    return self::getUserRegisterDB($per_cardno);
                } else {
                    return "Error Insert New User Depis!!!";
                }
            }
        }
    }

    //เรียกข้อมูลผู่ใช้งานสำหรับการลงทะเบียน
    public function getUserRegisterDB($per_cardno)
    {
        //dpis = "Y" => อนุญาติให้ลงทะเบียน
        //dpis = "NA" => ไม่อนุญาติให้ลงทะเบียนเนื่องจากเสียชีวิต
        //dpis = "NY" => ไม่อนุญาติให้ลงทะเบียนเนื่องจากเป็นสมาชิกแล้ว
        //dpis = "NP" => ไม่อนุญาติให้ลงทะเบียนเนื่องจากไม่ใช่บุคลากรกรม
        //status = "N" => สร้าง username
        //status = "Y" => มี username แล้ว
        //-------------------------------------------------------------------------------//
        $array_user = array("USR_CARDNO" => trim($per_cardno));
        $sql_depis = "SELECT * FROM USR_MAIN WHERE USR_CARDNO = :USR_CARDNO"; //เช็คข้อมูลมี user ในระบบ dpis
        $user_depis = self::getFetch($sql_depis, $array_user);
        $user_count = self::getRowCount($sql_depis, $array_user);

        if ($user_count > 0) { //พบข้อมูล user
            if (empty($user_depis["USR_USERNAME"])) { //กรณีไม่รหัสผู้ใช้
                $array_list["status"] = "N"; //สร้าง username
                if (self::checkMovement($user_depis["USR_MOVEMENT"], $user_depis["USR_PRE_STATUS"], $user_depis["USR_PERTYPE_ID"])) { //เช็คสถาณะ user 
                    $array_list["dpis"] = "NA"; //ไม่อนุญาติให้ลงทะเบียน
                } else {
                    $array_list["dpis"] = "Y"; //อนุญาติให้ลงทะเบียน
                }
            } elseif (!empty($user_depis["USR_USERNAME"])) { //กรณีพบรหัสผู้ใช้
                $array_list["status"] = "Y"; //มี username แล้ว
                if (self::checkMovement($user_depis["USR_MOVEMENT"], $user_depis["USR_PRE_STATUS"], $user_depis["USR_PERTYPE_ID"])) { //เช็คสถาณะ user 
                    $array_list["dpis"] = "NA"; //ไม่อนุญาติให้ลงทะเบียน
                } elseif (!empty($user_depis["USR_USERNAME"])) {
                    $array_list["dpis"] = "NY"; //ไม่อนุญาติให้ลงทะเบียนเนื่องจากเป็นสมาชิกแล้ว
                } else {
                    $array_list["dpis"] = "Y"; //อนุญาติให้ลงทะเบียน
                }
            } else {
                $array_list["dpis"] = "NN"; //ไม่พบข้อมูลผู้ใช้ในระบบ
            }
        } else { //ไม่พบข้อมูล user
            $array_list["dpis"] = "NP"; //ไม่อนุญาติให้ลงทะเบียนเนื่องจากไม่ใช่บุคลากรกรม
        }

        $array_list["count"] = $user_count;

        return $array_list;
    }

    //เรียกข้อมูลผู่ใช้งานสำหรับการตอบคำถาม
    public function getUserQuest($SEQUEST_ID = null, $SEQ_NAME = null)
    {
        $wh = "";
        if ($SEQUEST_ID) {
            $wh .= " AND SEQUEST_ID = :SEQUEST_ID";
            $arr_wh1 = array("SEQUEST_ID" => trim($SEQUEST_ID));
        }

        if ($SEQ_NAME) {
            $wh .= " AND SEQ_NAME = :SEQ_NAME";
            $arr_wh2 = array("SEQ_NAME" => trim($SEQ_NAME));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array()
        );

        $sql = "SELECT * FROM M_SEQUEST WHERE 1=1 {$wh}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            if (!empty($SEQUEST_ID)) {
                $res_data = $data;
            } elseif (!empty($SEQ_NAME)) {
                $res_data = $data;
            } else {
                $res_data = null;
            }

            $array_list["data"] = $res_data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //การ์ดวันเกิด
    public function getEcardUser($date_current)
    {
        $wh = "";
        if ($date_current) {
            $date = explode('-', $date_current);
            $wh .= " AND MONTH(USR_BIRTH_DATE) = :USR_BIRTH_DATE";
            $wh .= " AND DAY(USR_BIRTH_DATE) = :USR_BIRTH_DATE";

            $arr_wh1 = array(
                "USR_BIRTH_DATE" => $date[1],
                "USR_BIRTH_DATE" => $date[2]
            );
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array()
        );

        $sql = "SELECT * FROM USR_MAIN WHERE USR_BIRTH_DATE_STATUS = 'Y' {$wh} ORDER BY USR_ID DESC";
        $count = self::getRowCount($sql, $array_field);
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);

        if ($data) {
            $array_list["data"] = $data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลผู่ใช้งานปัจจุบัน
    public function getContact($start, $perpage, $s_name = null, $dep_id = null, $dvs_id, $pertype_id = null)
    {
        $wh = "";
        $array_field = array();

        if ($s_name) {
            $name_explode = explode(" ", $s_name);
            $name_thai = $name_explode[0];
            $surname_thai = $name_explode[1];

            if (empty($surname_thai)) {
                $wh .= " AND (USR_FNAME LIKE :USR_FNAME";
                $wh .= " OR USR_LNAME LIKE :USR_LNAME) ";
                $arr_wh1 = array("USR_FNAME" => '%' . $s_name . '%', "USR_LNAME" => '%' . $s_name . '%');
            } else {
                $wh .= " AND (USR_FNAME LIKE :USR_FNAME";
                $wh .= " OR USR_LNAME LIKE :USR_LNAME) ";
                $arr_wh2 = array("USR_FNAME" => '%' . $name_thai . '%', "USR_LNAME" => '%' . $surname_thai . '%');
            }
        }

        if ($dep_id) {
            $wh .= " AND (DEP_ORG_ID = :DEP_ORG_ID)";
            $arr_wh3 = array("DEP_ORG_ID" => $dep_id);
        }

        if ($dvs_id) {
            $wh .= " AND (USR_DIVISION_ID = :USR_DIVISION_ID)";
            $arr_wh4 = array("USR_DIVISION_ID" => $dvs_id);
        }

        if ($pertype_id) {
            $wh .= " AND (USR_PERTYPE_ID = :USR_PERTYPE_ID)";
            $arr_wh5 = array("USR_PERTYPE_ID" => $pertype_id);
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array(),
            !empty($arr_wh3) ? $arr_wh3 : array(),
            !empty($arr_wh4) ? $arr_wh4 : array(),
            !empty($arr_wh5) ? $arr_wh5 : array()
        );

        // $wh .= " AND USR_MOVEMENT NOT IN ('ถึงแก่ความตาย','ถึงแก่กรรม','ประเภทถึงแก่กรรม','ประเภทลาออก','ไล่ออก','ลาออก',
        // 'ไล่ออกจากราชการ','ประเภทไล่ออกจากราชการ','ให้ออกจากราชการเหตุวินัย','ให้ออกจากราชการเนื่องจากเหตุเสียชีวิต','เกษียณอายุ')";

        $sql = "SELECT * FROM USR_MAIN WHERE USR_ID != 1 AND USR_PRE_STATUS = 1 AND USR_STATUS = 'Y' {$wh} 
        ORDER BY CASE WHEN USR_LEVEL_NAME LIKE '%ประเภทบริหาร%' THEN 0 ELSE 1 END,
        CASE WHEN USR_PERTYPE LIKE '%ข้าราชการ%' THEN 0 ELSE 1 END,
        CASE WHEN USR_PERTYPE LIKE '%ลูกจ้างประจำ%' THEN 0 ELSE 1 END,
        CASE WHEN USR_PERTYPE LIKE '%พนักงานราชการ%' THEN 0 ELSE 1 END,
        CASE WHEN USR_PERTYPE LIKE '%ลูกจ้างชั่วคราว%' THEN 0 ELSE 1 END ASC
        OFFSET {$start} ROWS FETCH NEXT {$perpage} ROWS ONLY";

        $data = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql);

        $sql_user = "SELECT USR_PREFIX,USR_FNAME,USR_LNAME FROM USR_MAIN ORDER BY USR_ID DESC LIMIT 0,10";
        $data_user = self::getFetchAll($sql_user);

        $sql_all = "SELECT USR_ID FROM USR_MAIN WHERE USR_ID != 1 AND USR_PRE_STATUS = 1 AND USR_STATUS = 'Y' {$wh}";
        $countAll = self::getRowCount($sql_all, $array_field);

        if ($data) {
            $array_list["data"] = $data;
            $array_list["data_user"] = $data_user;
            $array_list["count"] = $count;
            $array_list["countAll"] = $countAll;
            return $array_list;
        }
    }

    //เรียกข้อมูลแดชบอร์ดบุคลากร กปส.
    public function getDashboard($USR_PERTYPE_ID = null, $USR_PERTYPE = null)
    {
        $wh = "";
        if ($USR_PERTYPE_ID) {
            $wh .= " AND USR_PERTYPE_ID = :USR_PERTYPE_ID";
            $arr_wh1 = array("USR_PERTYPE_ID" => trim($USR_PERTYPE_ID));
        }

        if ($USR_PERTYPE) {
            $wh .= " AND USR_PERTYPE = :USR_PERTYPE";
            $arr_wh2 = array("USR_PERTYPE" => trim($USR_PERTYPE));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array()
        );

        $sql = "SELECT USR_ID FROM USR_MAIN WHERE USR_PRE_STATUS = 1 AND USR_STATUS = 'Y' {$wh}";
        $data = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            $array_list["data"] = $data;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    public function getNumberOfEmployee(){
        $url = 'http://dev.prd.go.th/dpis_plus/read/';
        $data = file_get_contents($url);
        $replace = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
        $result = json_decode($replace, true);
        $division = $result["Division"];

        $NumberArray = array();
        $NumberOfEmployee = 0;
        foreach($division as $value){
            $NumberOfEmployee += $value["NumberOfEmployee"];
            array_push($NumberArray, $value["NumberOfEmployee"]);
        }

        return $NumberOfEmployee;
    }

    //เรียกข้อมูล Log depis call api
    public function getLogDepis($date = null, $status = null)
    {
        $wh = "";

        if ($date) {
            $wh .= " AND USR_DATE = :USR_DATE";
            $arr_wh1 = array("USR_DATE" => trim($date));
        }

        if ($status) {
            $wh .= " AND USR_STATUS_LOG = :USR_STATUS_LOG";
            $arr_wh2 = array("USR_STATUS_LOG" => trim($status));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array()
        );

        $sql = "SELECT * FROM USR_MAIN WHERE 1=1 {$wh}";
        $data = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            $array_list["data"] = $data;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลหน่วยงาน
    public function getDepartment($S_WHERE = null)
    {
        $_wh = "";
        if ($S_WHERE) {
            $a_where = array();
            foreach ((array)$S_WHERE as $_key => $_item) {
                $a_where[] = $_key . "='" . $_item . "'";
            }
            $_wh .= implode(' AND ', $a_where);
        } else {
            $_wh .= "1=1";
        }

        $sql = "SELECT * FROM USR_DEPARTMENT WHERE {$_wh} ORDER BY DEP_ORDER ASC";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            $array_list["data"] = $data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลหน่วยงาน เฉพาะเลเวล 3
    public function getDepartments()
    {
        $sql = "SELECT * FROM USR_DEPARTMENT WHERE DEP_LEVEL_ID = 3 AND DEP_STATUS = 'Y' ORDER BY DEP_ORDER ASC";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            $array_list["data"] = $data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลหน่วยงาน เลเวล 3 และต่ำกว่า
    public function getDepartmentLevel($org_pid = null, $dep_id = null, $sort = null)
    {
        $wh = "";

        if ($org_pid) {
            $org_pid_array = self::getCrushDepartmentLevel($org_pid);
            $wh .= " AND DEP_ORGANIZE_ID IN ($org_pid_array)";
        }

        if ($dep_id) {
            $wh .= " OR DEP_ID = '$dep_id'";
        }

        if ($sort) {
            $wh .= " ORDER BY {$sort} DESC";
        } else {
            $wh .= " ORDER BY DEP_ORGANIZE_ID ASC";
        }

        $sql = "SELECT * FROM USR_DEPARTMENT WHERE DEP_STATUS = 'Y' AND DEP_LEVEL_ID IN(3,4,5) {$wh}";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            $dep_name = "";
            foreach ($dataAll as $value) {
                $dep_name .= trim($value["DEP_NAME"]) . " / ";
            }
            $array_list["data"] = $data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            $array_list["dep_name"] = rtrim($dep_name, " / ");
            return $array_list;
        }
    }

    //เรียกข้อมูลหน่วยงาน และเช็คหน่วยงานย่อย
    public function getCrushDepartmentLevel($org_pid = null)
    {
        $wh = "";
        $s_org_pid = array();
        array_push($s_org_pid, $org_pid);

        if ($org_pid) {
            $wh .= " AND DEP_ORGANIZE_ID = :DEP_ORGANIZE_ID";
            $arr_wh1 = array("DEP_ORGANIZE_ID" => trim($org_pid));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array()
        );

        $sql = "SELECT * FROM USR_DEPARTMENT WHERE DEP_STATUS = 'Y' AND DEP_LEVEL_ID NOT IN (1,2) {$wh}";
        $data = self::getFetchAll($sql, $array_field);

        foreach ($data as $value) {
            array_push($s_org_pid, self::getCrushDepartmentLevel($value['DEP_ORGANIZE_PID']));
        }

        sort($s_org_pid);
        return implode(",", array_unique($s_org_pid));
    }

    //เรียกข้อมูลหน่วยงาน Organization
    public function getOrg($n_org = null)
    {
        $wh = "";

        if ($n_org) {
            $wh .= " AND DEP_NAME = :DEP_NAME";
            $arr_wh1 = array("DEP_NAME" => trim($n_org));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array()
        );

        $_sql = "SELECT DEP_NAME, DEP_SHORT_NAME FROM USR_DEPARTMENT WHERE 1=1 {$wh}";
        $a_data = self::getFetch($_sql, $array_field);

        if ($a_data) {
            return array(
                "name" => !empty($a_data["DEP_SHORT_NAME"]) ? $a_data["DEP_SHORT_NAME"] : $a_data["DEP_NAME"],
                "name_org" => $a_data["DEP_NAME"],
                "short_name" => $a_data["DEP_SHORT_NAME"]
            );
        }
    }

    //เรียกข้อมูลต่ำแหน่ง
    public function getPosition($POS_ID = null)
    {
        $wh = "";

        if ($POS_ID) {
            $wh .= " AND POS_ID = :POS_ID";
            $arr_wh1 = array("POS_ID" => trim($POS_ID));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array()
        );

        $sql = "SELECT * FROM USR_POSITION WHERE 1=1 {$wh}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            $array_list["data"] = !empty($POS_ID) ? $data : null;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลสิทธ์ระบบ
    public function getPersonalMappingSys($USR_ID = null)
    {
        $wh = "";
        if ($USR_ID) {
            $wh .= " AND PER_NAME = :PER_NAME";
            $arr_wh1 = array("PER_NAME" => trim($USR_ID));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array()
        );

        $sql = "SELECT * FROM WFR_PERSONAL_MAPPING_SYS WHERE 1=1 {$wh}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            $array_list["data"] = !empty($USR_ID) ? $data : null;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลรายการสิทธ์
    public function getCheckBox($WFR_ID, $TYPE = null, $CHECKBOX_VALUE = null)
    {
        $wh = "";
        if ($WFR_ID) {
            $wh .= " AND WFR_ID = :WFR_ID";
            $arr_wh1 = array("WFR_ID" => trim($WFR_ID));
        }

        if ($TYPE) {
            $wh .= " AND WFS_FIELD_NAME = :WFS_FIELD_NAME";
            $arr_wh2 = array("WFS_FIELD_NAME" => trim($TYPE));
        }

        if ($CHECKBOX_VALUE) {
            $wh .= " AND CHECKBOX_VALUE = :CHECKBOX_VALUE";
            $arr_wh3 = array("CHECKBOX_VALUE" => trim($CHECKBOX_VALUE));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array(),
            !empty($arr_wh3) ? $arr_wh3 : array()
        );

        $sql = "SELECT * FROM WF_CHECKBOX WHERE 1=1 {$wh}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            $array_list["data"] = $data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลไฟล์อัพโหลด
    public function getFile($WFR_ID = null, $WF_MAIN_ID = null)
    {
        $wh = "";
        if ($WFR_ID) {
            $wh .= " AND WFR_ID = :WFR_ID";
            $arr_wh1 = array("WFR_ID" => trim($WFR_ID));
        }

        if ($WF_MAIN_ID) {
            $wh .= " AND WF_MAIN_ID = :WF_MAIN_ID";
            $arr_wh2 = array("WF_MAIN_ID" => trim($WF_MAIN_ID));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array()
        );

        $sql = "SELECT * FROM WF_FILE WHERE FILE_STATUS = 'Y' AND FILE_EXT != 'mp3' {$wh}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            $array_list["data"] = !empty($WFR_ID) ? $data : null;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลไฟล์เสียง
    public function getSound($WFR_ID = null, $WFS_FIELD_NAME = null)
    {
        $wh = "";
        if ($WFR_ID) {
            $wh .= " AND WFR_ID = :WFR_ID";
            $arr_wh1 = array("WFR_ID" => trim($WFR_ID));
        }

        if ($WFS_FIELD_NAME) {
            $wh .= " AND WFS_FIELD_NAME = :WFS_FIELD_NAME";
            $arr_wh2 = array("WFS_FIELD_NAME" => trim($WFS_FIELD_NAME));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array()
        );

        $sql = "SELECT * FROM WF_FILE WHERE FILE_STATUS = 'Y' AND FILE_EXT = 'mp3' {$wh}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            $array_list["data"] = $data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูล English Chit chat 1  
    public function getChitChat($VOCAB_ID = null)
    {
        $date_now =  date('Y-m-d');

        $wh = "";
        if ($VOCAB_ID) {
            $wh .= " AND VOCAB_ID = :VOCAB_ID";
            $arr_wh1 = array("VOCAB_ID" => trim($VOCAB_ID));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array()
        );

        $sql = "SELECT * FROM M_VOCAB WHERE VOCAB_STARTDATE != '1900-01-01' AND ((VOCAB_STARTDATE = '' AND VOCAB_ENDDATE = '') OR ('{$date_now}' between VOCAB_STARTDATE AND VOCAB_ENDDATE)) {$wh} ORDER BY VOCAB_ID DESC";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);

        if ($data) {
            return array(
                "data" => $data,
                "dataAll" => $dataAll
            );
        }
    }

    //เรียกข้อมูล English Chit chat 2 
    public function getVocab($start, $per_page, $s_search = null)
    {
        $wh = "";
        if ($s_search) {
            $wh .= " AND VOCAB_TITLE1 LIKE '%" . $s_search . "%' ";
            $arr_wh1 = array("VOCAB_TITLE1" => '%' . trim($s_search) . '%');
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array()
        );

        $sql = "SELECT * FROM M_VOCAB WHERE 1=1 {$wh} ORDER BY VOCAB_ID DESC OFFSET {$start} ROWS FETCH NEXT {$per_page} ROWS ONLY";
        $data = self::getFetchAll($sql, $array_field);

        $sqlAll = "SELECT * FROM M_VOCAB WHERE 1=1 {$wh}";
        $countAll = self::getRowCount($sqlAll, $array_field);

        if ($data) {
            return array(
                "data" => $data,
                "countAll" => $countAll
            );
        }
    }

    //เรียกข้อมูลจัดการสิทธิ์หน่วยงาน
    public function getDepPermission($S_WHERE = null)
    {
        $_wh = "";
        if ($S_WHERE) {
            $a_where = array();
            foreach ((array)$S_WHERE as $_key => $_item) {
                if ($_key == "DEP_NAME") {
                    $DEP_NID = self::getDepartment(array("DEP_NAME" => $_item))["data"]["DEP_ID"];
                    $a_where[] = "DEP_ID" . "='" . $DEP_NID . "'";
                } else {
                    $a_where[] = $_key . "='" . $_item . "'";
                }
            }
            $_wh .= implode(' AND ', $a_where);
        } else {
            $_wh .= "1=1";
        }

        $sql = "SELECT * FROM M_DEP_PERMISSION WHERE {$_wh}";
        $data = self::getFetch($sql);

        if ($data) {
            return $data;
        }
    }

    //เรียกข้อมูลรายการระบบ
    public function getSystemSetting($USR_USERNAME, $USR_DEPARTMENT)
    {
        if ($USR_USERNAME) {
            //----------------------------------เช็คข้อมูลสิทธิ์จากใช้-----------------------------//
            $user = self::getUser($USR_USERNAME);
            $personal = self::getPersonalMappingSys($user["data"]["USR_ID"]);
            if ($personal) {
                $check_box1 = self::getCheckBox($personal["data"]["WFR_ID"], 'SYSTEM_LIST');
            }
            //-------------------------------เช็คข้อมูลสิทธิ์จากหน่วยงาน---------------------------//
            $user_dep = self::getDepPermission(array("DEP_NAME" => $USR_DEPARTMENT));
            if ($user_dep) {
                $check_box2 = self::getCheckBox($user_dep["data"]["DEP_PER_ID"], 'DEP_TO_SYSTEM');
            }
        } else {
            $check_box1 = null;
            $check_box2 = null;
        }

        $wh = "";
        if ($check_box1) {
            $WFR_ID = $check_box1["data"]["WFR_ID"];
            $wh .= " AND WF_CHECKBOX.WFR_ID = :WFR_ID";
            $arr_wh1 = array("WFR_ID" => trim($WFR_ID));
            $field_name = 'SYSTEM_LIST';
        }

        if (empty($check_box1) && !empty($check_box2)) {
            $WFR_ID = $check_box2["data"]["WFR_ID"];
            $wh .= " AND WF_CHECKBOX.WFR_ID = :WFR_ID";
            $arr_wh2 = array("WFR_ID" => trim($WFR_ID));
            $field_name = 'DEP_TO_SYSTEM';
        }

        if (!empty($check_box1)) {
            $WFS_FIELD_NAME = 'SYSTEM_LIST';
        } elseif (!empty($check_box2)) {
            $WFS_FIELD_NAME = 'DEP_TO_SYSTEM';
        } else {
            $WFS_FIELD_NAME = $field_name;
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array()
        );

        $sql = "SELECT M_SYSTEMS_LIST.*,WF_CHECKBOX.W_POS,WF_CHECKBOX.CHECKBOX_ID FROM M_SYSTEMS_LIST
        INNER JOIN WF_CHECKBOX ON (M_SYSTEMS_LIST.SYSTEMS_ID = WF_CHECKBOX.CHECKBOX_REF)
        WHERE M_SYSTEMS_LIST.ENABLE = 'Y' AND WF_CHECKBOX.WFS_FIELD_NAME = '$WFS_FIELD_NAME' 
        {$wh} ORDER BY WF_CHECKBOX.W_POS ASC";
        $data = self::getFetchAll($sql, $array_field);

        if ($data) {
            return $data;
        }
    }

    //เรียกข้อมูลรายการระบบ
    public function getSystem($SYSTEMS_ID = null, $SYS_ID = null, $SYS_type = null)
    {
        $wh = "";
        if ($SYSTEMS_ID) {
            $wh .= " AND SYSTEMS_ID = :SYSTEMS_ID";
            $arr_wh1 = array("SYSTEMS_ID" => trim($SYSTEMS_ID));
        }

        $orderby = "";
        if ($SYS_ID) {
            switch ($SYS_type) {
                case 'have':
                    $wh .= "AND SYSTEMS_ID IN ({$SYS_ID})";
                    break;
                case 'not':
                    $wh .= "AND SYSTEMS_ID NOT IN ({$SYS_ID})";
                    break;
            }

            $orderby .= "ORDER BY CASE SYSTEMS_ID";
            $i = 1;
            foreach (explode(",", $SYS_ID) as $id) {
                $orderby .= " WHEN $id THEN $i";
                $i++;
            }
            $orderby .= " END ASC";
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array()
        );

        $sql = "SELECT SYSTEMS_ID,SYSTEMS_NAME,ENABLE FROM M_SYSTEMS_LIST WHERE ENABLE = 'Y' AND SYSTEMS_ID != 31 {$wh} {$orderby}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            if (!empty($SYSTEMS_ID) || !empty($SYS_ID)) {
                $res_data = $data;
            } else {
                $res_data = null;
            }

            $array_list["data"] = $res_data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เรียกข้อมูลรายการระบบ
    public function getSystems($USR_USERNAME, $USR_DEPARTMENT, $template_id)
    {
        if ($USR_USERNAME) {
            //----------------------------------เช็คข้อมูลสิทธิ์จากใช้-----------------------------//
            $user = self::getUser($USR_USERNAME);
            $personal = self::getPersonalMappingSys($user["data"]["USR_ID"]);
            if ($personal) {
                $check_box1 = self::getCheckBox($personal["data"]["WFR_ID"], 'SYSTEM_LIST');
            }
            //-------------------------------เช็คข้อมูลสิทธิ์จากหน่วยงาน---------------------------//
            $user_dep = self::getDepPermission(array("DEP_NAME" => $USR_DEPARTMENT));
            if ($user_dep) {
                $check_box2 = self::getCheckBox($user_dep["data"]["DEP_PER_ID"], 'DEP_TO_SYSTEM');
            }
        } else {
            $check_box1 = null;
            $check_box2 = null;
        }

        $wh = "";
        if ($check_box1) {
            $WFR_ID = $check_box1["data"]["WFR_ID"];
            $wh .= " AND WF_CHECKBOX.WFR_ID = :WFR_ID";
            $arr_wh1 = array("WFR_ID" => trim($WFR_ID));
            $field_name = 'SYSTEM_LIST';
        }

        if (empty($check_box1) && !empty($check_box2)) {
            $WFR_ID = $check_box2["data"]["WFR_ID"];
            $wh .= " AND WF_CHECKBOX.WFR_ID = :WFR_ID";
            $arr_wh2 = array("WFR_ID" => trim($WFR_ID));
            $field_name = 'DEP_TO_SYSTEM';
        }

        if (!empty($check_box1)) {
            $WFS_FIELD_NAME = 'SYSTEM_LIST';
        } elseif (!empty($check_box2)) {
            $WFS_FIELD_NAME = 'DEP_TO_SYSTEM';
        } else {
            $WFS_FIELD_NAME = $field_name;
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array()
        );

        $sql = "SELECT M_SYSTEMS_LIST.*,WF_CHECKBOX.W_POS,WF_CHECKBOX.CHECKBOX_ID FROM M_SYSTEMS_LIST
        INNER JOIN WF_CHECKBOX ON (M_SYSTEMS_LIST.SYSTEMS_ID = WF_CHECKBOX.CHECKBOX_REF)
        WHERE M_SYSTEMS_LIST.ENABLE = 'Y' AND WF_CHECKBOX.WFS_FIELD_NAME = '$WFS_FIELD_NAME' 
        {$wh} ORDER BY WF_CHECKBOX.W_POS ASC";

        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        $sql2 = "SELECT * FROM M_SYSTEMS_LIST WHERE ENABLE = 'Y' AND SYSTEMS_ID = 31";
        $dataAll2 = self::getFetchAll($sql2);
        $count2 = self::getRowCount($sql2);

        if ($count > 0 || $count2 > 0) {
            $array_data = array_chunk(array_merge($dataAll, $dataAll2), 4);
            $array_count = count($array_data);

            $txt = '';
            $txt3 = '';

            $sys_id = array();
            foreach ($dataAll as $key => $value) {
                array_push($sys_id, $value['SYSTEMS_ID']);
                $file = self::getFile($value["SYSTEMS_ID"], 3);

                if ($value['SYSTEMS_ID'] == '12') {
                    $TOKEN = '&token=' . $value["TOKEN_ID"] . '&secret=' . $value["SECRET_KEY"] . '&secretKey=' . $personal["data"]["SECRET_KEY"] . '&system=' . $value["SYSTEMS_ID"] . '';
                } else {
                    $TOKEN = "";
                }

                $authen = self::endcode($user["data"]["USR_CARDNO"] . ',' . $_SESSION['EWT_USERNAME'], 'hnqbioi7l0r7lrhjpfltv6tlq3');
                $url_call = '&authen=' . $authen . '' . $TOKEN;

                if (!empty($file["data"]["FILE_SAVE_NAME"])) {
                    $FILE_SAVE_NAME = $file["data"]["FILE_SAVE_NAME"];
                } else {
                    $FILE_SAVE_NAME = 'f20220817144619_vh6NgraPT6.png';
                }

                if ($template_id == 1) {
                    $txt .= '<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">';
                    $txt .= '<a href="' . $value["CALL_BACK"] . '' . $url_call . '" target="_blank">';
                    $txt .= '<div class="icon-box">';
                    $txt .= '<img src="' . HOST_SSO . 'attach/w3/' . $FILE_SAVE_NAME . '" class="max-width-icon-system-t2" title="' . $value["SYSTEMS_NAME"] . '" alt="' . $value["SYSTEMS_NAME"] . '" >';
                    $txt .= '<h3 class=""> ' . $value["SYSTEMS_NAME"] . ' </h3>';
                    $txt .= '</div>';
                    $txt .= '</a>';
                    $txt .= '</div>';
                } elseif ($template_id == 2) {
                    if ($key > 4) {
                        $txt .= '<div class="col-lg-2 col-md-2 col-sm-6 col-12 collapse" id="collapsesystem">';
                    } else {
                        $txt .= '<div class="col-lg-2 col-md-2 col-sm-6 col-12">';
                    }

                    $txt .= '<a href="' . $value["CALL_BACK"] . '' . $url_call . '" target="_blank">';
                    $txt .= '<div class="bg-icon-index text-center">';
                    $txt .= '<img src="' . HOST_SSO . 'attach/w3/' . $FILE_SAVE_NAME . '"  class="max-width-icon-system-t2" title="' . $value["SYSTEMS_NAME"] . '" alt="' . $value["SYSTEMS_NAME"] . '">';
                    $txt .= '</div>';
                    $txt .= '<div class="txt-white text-center pt-2"> ' . $value["SYSTEMS_NAME"] . ' </div>';
                    $txt .= '</a>';
                    $txt .= '</div>';
                }
            }

            for ($i = 0; $i < $array_count; $i++) {
                $txt3 .= '<div class="carousel-item py-1 ' . ($i == 0 ? "active" : null) . '">';
                $txt3 .= '<div class="row">';

                foreach ($array_data[$i] as $key => $value) {
                    $file = self::getFile($value["SYSTEMS_ID"], 3);

                    if ($value['SYSTEMS_ID'] == '12') {
                        $TOKEN = '&token=' . $value["TOKEN_ID"] . '&secret=' . $value["SECRET_KEY"] . '&secretKey=' . $personal["data"]["SECRET_KEY"] . '&system=' . $value["SYSTEMS_ID"] . '';
                    } else {
                        $TOKEN = "";
                    }

                    $authen = self::endcode($user["data"]["USR_CARDNO"] . ',' . $_SESSION['EWT_USERNAME'], 'hnqbioi7l0r7lrhjpfltv6tlq3');
                    $url_call = '&authen=' . $authen . '' . $TOKEN;

                    if (!empty($file["data"]["FILE_SAVE_NAME"])) {
                        $FILE_SAVE_NAME = $file["data"]["FILE_SAVE_NAME"];
                    } else {
                        $FILE_SAVE_NAME = 'f20220817144619_vh6NgraPT6.png';
                    }

                    $txt3 .= '<div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">';
                    $txt3 .= '<a href="' . $value["CALL_BACK"] . '' . $url_call . '" target="_blank">';
                    $txt3 .= '<div class="text-center bg-system-icon">';
                    $txt3 .= '<img src="' . HOST_SSO . 'attach/w3/' . $FILE_SAVE_NAME . '" class="max-width-pic-today" title="' . $value["SYSTEMS_NAME"] . '" alt="' . $value["SYSTEMS_NAME"] . '">';
                    $txt3 .= '</div>';
                    $txt3 .= '<div>';
                    $txt3 .= '<div class="media-body font10px text-center">';
                    $txt3 .= '<div class="mt-1 txt-white"> ' . $value["SYSTEMS_NAME"] . ' </div>';
                    $txt3 .= '</div>';
                    $txt3 .= '</div>';
                    $txt3 .= '</a>';
                    $txt3 .= '</div>';
                }
                $txt3 .= '</div>';
                $txt3 .= '</div>';
            }

            $array_list["dataAll"] = $dataAll;
            $array_list["data_t"] = ""; //$txt;
            $array_list["data_t3"] = ""; //$txt3;
            $array_list["sys_id"]  = implode(",", array_unique($sys_id));
            $array_list["array_row"] = $array_count;
            return $array_list;
        }
    }

    //เรียกข้อมูลสิทธิ์ระบบงาน
    public function getPermission($SYSTEMNAME_LIST = null, $ORG_NAME = null)
    {
        $wh = "";
        if ($SYSTEMNAME_LIST) {
            $wh .= " AND SYSTEMNAME_LIST = :SYSTEMNAME_LIST";
            $arr_wh1 = array("SYSTEMNAME_LIST" => trim($SYSTEMNAME_LIST));
        }

        if ($ORG_NAME) {
            $wh .= " AND ORG_NAME = :ORG_NAME";
            $arr_wh2 = array("ORG_NAME" => trim($ORG_NAME));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array()
        );

        $sql = "SELECT * FROM WFR_PERMISSION WHERE 1=1 {$wh}";
        $data = self::getFetch($sql, $array_field);
        $dataAll = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            if (!empty($SYSTEMNAME_LIST)) {
                $res_data = $data;
            } elseif (!empty($ORG_NAME)) {
                $res_data = $data;
            } else {
                $res_data = null;
            }

            $array_list["data"] = $res_data;
            $array_list["dataAll"] = $dataAll;
            $array_list["count"] = $count;
            return $array_list;
        }
    }

    //เช็คข้อมูลผู้ใช้ร้องขอสิทธิ์
    public function checkPermission($SYSTEMNAME_LIST = null, $NAME = null)
    {
        $wh = "";
        if ($SYSTEMNAME_LIST) {
            $wh .= " AND SYSTEMNAME_LIST = :SYSTEMNAME_LIST";
            $arr_wh1 = array("SYSTEMNAME_LIST" => trim($SYSTEMNAME_LIST));
        }

        if ($NAME) {
            $wh .= " AND NAME = :NAME";
            $arr_wh2 = array("NAME" => trim($NAME));
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
            !empty($arr_wh2) ? $arr_wh2 : array()
        );

        $sql = "SELECT WFR_ID FROM WFR_PERMISSION WHERE 1=1 {$wh}";
        $count = self::getRowCount($sql, $array_field);

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    //เรียกข้อมูลแจ้งเตือนคำถาม
    public function getCreateQuestion()
    {
        $date_now =  date('Y-m-d');
        $wh = "";
        $wh .= " AND ((START_DATE = '' AND END_DATE = '')";
        $wh .= " OR ('{$date_now}' BETWEEN START_DATE AND END_DATE))";

        $sql = "SELECT * FROM M_CREATE_QUESTION WHERE STATUS = 1 {$wh}";
        $data = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        // if ($count > 0) {
        //     foreach($data as $value){
        //         $sql = "INSERT INTO M_SYSTEMS_WARN (
        //             SYSTEMS_ID, 
        //             SYSTEMS_NAME, 
        //             SYSTEMS_COUNT,
        //             SYSTEMS_DATE
        //         ) 
        //         VALUES (
        //             '".self::maxId("M_SYSTEMS_WARN", "SYSTEMS_ID")."', 
        //             '".$value->QUESTION."', 
        //             '".$count."',
        //             '".$date_now."'
        //         )";

        //         self::execute($sql);
        //     }
        // }

        if ($data) {
            return array(
                "data" => $data,
                "count" => $count
            );
        }
    }

    //เรียกข้อมูลแจ้งเตือนระบบ
    public function getNotification($status = null)
    {
        $date_now = date("Y-m-d");

        $wh = "";
        if ($status) {
            $wh .= "AND SYSTEMS_STATUS = :SYSTEMS_STATUS";
            $arr_wh1 = array("SYSTEMS_STATUS" => trim($status));
        } else {
            $wh .= "AND SYSTEMS_STATUS = :SYSTEMS_STATUS";
            $arr_wh1 = array("SYSTEMS_STATUS" => "Y");
        }

        $array_field = array_merge(
            !empty($arr_wh1) ? $arr_wh1 : array(),
        );

        $sql = "SELECT * FROM M_SYSTEMS_WARN WHERE SYSTEMS_DATE = '{$date_now}' {$wh}";
        $data = self::getFetchAll($sql, $array_field);
        $count = self::getRowCount($sql, $array_field);

        if ($data) {
            return array(
                "data" => $data,
                "count" => $count
            );
        }
    }
}
