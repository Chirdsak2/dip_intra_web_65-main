<?php
class sso
{
    //เชื่อมต่อฐานข้อมูล     
    function __construct()
    {
        $db_host = '203.151.166.132';
        $db_name = 'PRD_INTRA_SSO';
        $db_user = 'PRD_INTRA_SSO';
        $db_pass = '550PrD';

        try {
            $conn = new PDO("sqlsrv:server=$db_host; Database=$db_name", $db_user, $db_pass);
            // echo "Connected to database";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $this->conn = $conn;
    }

    //ฟังก์ชันเข้ารหัส SSO
    function hashPass($password)
    {
        if ($password) {
            return hash('sha1', trim($password));
        }
    }

    //ฟังก์ชันแปลง Array
    function setArray2String($dataArray, $operator = ", ")
    {
        $data = array();

        foreach ($dataArray as $_key => $_val) {
            if ($_key != "") {
                $data[] = $_key . " = '" . $_val . "'";
            }
        }

        return implode($operator, $data);
    }

    //ฟังก์ดำเนินการข้อมูล
    function execute($sql)
    {
        try {
            $query = $this->conn->prepare($sql);
            if ($query) {
                $query->execute();
                return true;
            }
            return false;
        } catch (PDOException $exc) {
            return false;
        }
    }

    //Query ข้อมูล 1 row
    function getFetch($sql)
    {
        try {
            $query = $this->conn->prepare($sql);
            if ($query) {
                $query->execute();
                return $query->fetch();
            }
            return false;
        } catch (PDOException $exc) {
            return false;
        }
    }

    //Query ข้อมูลทั้งหมด
    function getFetchAll($sql)
    {
        try {
            $query = $this->conn->prepare($sql);
            if ($query) {
                $query->execute();
                return $query->fetchAll();
            }
            return false;
        } catch (PDOException $exc) {
            return false;
        }
    }

    //นับจำนวน row ที่ Query
    function getRowCount($sql)
    {
        try {
            $query = $this->conn->prepare($sql);
            if ($query) {
                $query->execute();
                return count($query->fetchAll());
            }
            return false;
        } catch (PDOException $exc) {
            return false;
        }
    }

    //เพิ่มข้อมูล
    function insert($s_table, $s_data = array())
    {
        try {
            $a_source = array();
            $a_value  = array();
            $a_param  = array();
            $a_keys   = array();
            if ($s_data) {
                foreach ((array)$s_data as $_key => $_item) {
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
    }

    //แก้ไขข้อมูล
    function update($tbName, $data, $cond)
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
    }

    //ลบข้อมูล
    function del($s_table, $s_where = array())
    {
        $a_where = array();
        foreach ((array)$s_where as $_key => $_item) {
            $a_where[] = $_key . "='" . $_item . "'";
        }

        $_sql = "DELETE FROM {$s_table} WHERE " . implode(" AND ", $a_where);
        if (self::execute($_sql) == true) {
            return true;
        } else {
            return false;
        }
    }

    //เรียกข้อมูล ID ล่าสุด
    public function maxId($s_table, $field)
    {
        $sql = "SELECT COALESCE(MAX($field),0) AS $field FROM $s_table";
        $data = self::getFetch($sql);
        return $data[$field] + 1;
    }

    function getCountUser($s_type)
	{   
        if($s_type == '1'){
            $_sql = "SELECT COUNT(USR_ID) AS num FROM USR_MAIN WHERE USR_ID != 1";		  	
            $a_count = self::getFetch($_sql);
        }
        else if($s_type == '2'){
            $_sql = "SELECT COUNT(USR_ID) AS num FROM USR_MAIN 
            WHERE USR_ID != 1 
            AND USR_MOVEMENT != 'ลาออก' 
            AND USR_MOVEMENT != 'ไล่ออก' 
            AND USR_MOVEMENT != 'เกษียณอายุ' 
            AND USR_MOVEMENT != 'ถึงแก่กรรม'";		  	
            $a_count = self::getFetch($_sql);
        }
        else if($s_type == '3'){
            $_sql = "SELECT COUNT(USR_ID) AS num FROM USR_MAIN 
            WHERE USR_ID != 1
            AND USR_MOVEMENT = 'ลาออก' 
            OR USR_MOVEMENT = 'ไล่ออก' 
            OR USR_MOVEMENT = 'เกษียณอายุ' 
            OR USR_MOVEMENT = 'ถึงแก่กรรม'";		  	
            $a_count = self::getFetch($_sql);	
        }
        
        return $a_count['num'];	
	}

    function getCountOrg($s_type)
	{
        if($s_type == '1'){
            $_sql = "SELECT COUNT(DEP_ID) AS num FROM USR_DEPARTMENT";	  	
            $a_count = self::getFetch($_sql);
        }else if($s_type == '2'){
            $_sql = "SELECT COUNT(DEP_ID) AS num FROM USR_DEPARTMENT";	  	
            $a_count = self::getFetch($_sql);
        
        }else if($s_type == '3'){
            $_sql = "SELECT COUNT(DEP_ID) AS num FROM USR_DEPARTMENT 
            WHERE DEP_STATUS = 0";	  	
            $a_count = self::getFetch($_sql);
        }
	
	    return  $a_count['num'];	
	}

    function getCountPosition($s_type)
	{
        if($s_type == '1'){
            $_sql = "SELECT COUNT(POS_ID) AS num FROM USR_POSITION";	  	
            $a_count = self::getFetch($_sql);
        }else if($s_type == '2'){
            $_sql = "SELECT COUNT(POS_ID) AS num FROM USR_POSITION";	  	
            $a_count = self::getFetch($_sql);
        
        }else if($s_type == '3'){
            $_sql = "SELECT COUNT(POS_ID) AS num FROM USR_POSITION 
            WHERE POS_STATUS = 0";	  	
            $a_count = self::getFetch($_sql);
        }
	  return  $a_count['num'];	
	}

    function genUserTop5($s_limit)
	{
        $_sql = "SELECT USR_PREFIX,USR_FNAME,USR_LNAME FROM USR_MAIN 
        ORDER BY USR_ID DESC OFFSET 0 ROWS FETCH NEXT {$s_limit} ROWS ONLY";	
        $_data  = self::getFetchAll($_sql);
        return $_data;
	}

    function genOrgGroupTop5($s_limit){
        $_sql = "SELECT DEP_NAME FROM USR_DEPARTMENT 
        ORDER BY DEP_ID DESC OFFSET 0 ROWS FETCH NEXT {$s_limit} ROWS ONLY";	
        $_data  = self::getFetchAll($_sql);
        return $_data;
    }

    //เรียกข้อมูลผู่ใช้งาน
    function getUser($USR_USERNAME = null, $USR_ID = null)
    {
        $wh = "";
        if ($USR_USERNAME) {
            $wh .= " AND USR_USERNAME = '$USR_USERNAME'";
        }

        if ($USR_ID) {
            $wh .= " AND USR_ID = '$USR_ID'";
        }

        $sql = "SELECT * FROM USR_MAIN WHERE 1=1 {$wh}";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            if (!empty($USR_USERNAME)) {
                $res_data = $data;
            } elseif (!empty($USR_ID)) {
                $res_data = $data;
            } else {
                $res_data = null;
            }

            return array(
                "data" => $res_data,
                "dataAll" => $dataAll,
                "count" => $count
            );
        }
    }

    //เรียกข้อมูลคำนำหน้าผู่ใช้งาน
    function getTitle($PREFIX_ID = null)
    {
        $wh = "";
        if ($PREFIX_ID) {
            $wh .= " AND PREFIX_ID = '$PREFIX_ID'";
        }

        $sql = "SELECT * FROM USR_PREFIX WHERE 1=1 {$wh}";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            return array(
                "data" => !empty($PREFIX_ID) ? $data : null,
                "dataAll" => $dataAll,
                "count" => $count
            );
        }
    }

    //เรียกข้อมูลผู่ใช้งาน
    function getContact($start, $perpage, $s_name = null, $org_id = null)
    {
        $wh = "";
        if ($s_name) {
            $name_explode = explode(" ", $s_name);
            $name_thai = $name_explode[0];
            $surname_thai = $name_explode[1];

            if (empty($surname_thai)) {
                $wh .= " AND USR_FNAME LIKE '%" . trim($s_name) . "%' ";
                $wh .= " OR USR_LNAME LIKE '%" . trim($s_name) . "%' ";
            } else {
                $wh .= " AND USR_FNAME LIKE '%" . trim($name_thai) . "%' ";
                $wh .= " OR USR_LNAME LIKE '%" . trim($surname_thai) . "%' ";
            }
        }

        if ($org_id) {
            $wh .= " AND DEP_ID = '$org_id' ";
        }

        $sql = "SELECT * FROM USR_MAIN WHERE USR_ID != 1 {$wh} 
        ORDER BY CASE WHEN USR_POSITION LIKE '%อธิบดีกรมประชาสัมพันธ์%' THEN 0 ELSE 1 END,
        USR_ID ASC OFFSET {$start} ROWS FETCH NEXT {$perpage} ROWS ONLY";

        $data = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        $sql_user = "SELECT USR_PREFIX,USR_FNAME,USR_LNAME FROM USR_MAIN ORDER BY USR_ID DESC LIMIT 0,10";
        $data_user = self::getFetchAll($sql_user);

        $sql_all = "SELECT * FROM USR_MAIN WHERE 1=1 {$wh}";
        $countAll = self::getRowCount($sql_all);

        if ($data) {
            return array(
                "data" => $data,
                "data_user" => $data_user,
                "count" => $count,
                "countAll" => $countAll
            );
        }
    }

    //เรียกข้อมูลหน่วยงาน
    function getDepartment($DEP_ID = null)
    {
        $wh = "";
        if ($DEP_ID) {
            $wh .= " AND DEP_ID = '$DEP_ID'";
        }

        $sql = "SELECT * FROM USR_DEPARTMENT WHERE 1=1 {$wh}";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            return array(
                "data" => !empty($DEP_ID) ? $data : null,
                "dataAll" => $dataAll,
                "count" => $count
            );
        }
    }

    //เรียกข้อมูลหน่วยงาน
    public function getDepartments()
    {
        $sql = "SELECT * FROM USR_DEPARTMENT WHERE DEP_LEVEL_ID = 3 ORDER BY DEP_ORDER ASC";
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

    //เรียกข้อมูลหน่วยงาน Organization
    public function getOrg($n_org = null)
    {
        $_sql = "SELECT DEP_NAME, DEP_SHORT_NAME FROM USR_DEPARTMENT WHERE DEP_NAME = '$n_org'";
        $a_data = self::getFetch($_sql);

        if ($a_data) {
            return array(
                "name" => !empty($a_data["DEP_SHORT_NAME"]) ? $a_data["DEP_SHORT_NAME"] : $a_data["DEP_NAME"],
                "name_org" => $a_data["DEP_NAME"],
                "short_name" => $a_data["DEP_SHORT_NAME"]
            );
        }
    }

    //เรียกข้อมูลต่ำแหน่ง
    function getPosition($POS_ID = null)
    {
        $wh = "";
        if ($POS_ID) {
            $wh .= " AND POS_ID = '$POS_ID'";
        }

        $sql = "SELECT * FROM USR_POSITION WHERE 1=1 {$wh}";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            return array(
                "data" => !empty($POS_ID) ? $data : null,
                "dataAll" => $dataAll,
                "count" => $count
            );
        }
    }

    //เรียกข้อมูลสิทธ์ระบบ
    function getPersonalMappingSys($USR_ID = null)
    {
        $wh = "";
        if ($USR_ID) {
            $wh .= " AND PER_NAME = '$USR_ID'";
        }

        $sql = "SELECT * FROM WFR_PERSONAL_MAPPING_SYS WHERE 1=1 {$wh}";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            return array(
                "data" => !empty($USR_ID) ? $data : null,
                "dataAll" => $dataAll,
                "count" => $count
            );
        }
    }

    //เรียกข้อมูลรายการสิทธ์
    function getCheckBox($WFR_ID, $TYPE = null, $CHECKBOX_VALUE = null)
    {
        $wh = "";
        if ($WFR_ID) {
            $wh .= " AND WFR_ID = '$WFR_ID'";
        }

        if ($TYPE) {
            $wh .= " AND WFS_FIELD_NAME = '$TYPE'";
        }

        if ($CHECKBOX_VALUE) {
            $wh .= " AND CHECKBOX_VALUE = '$CHECKBOX_VALUE'";
        }

        $sql = "SELECT * FROM WF_CHECKBOX WHERE 1=1 {$wh}";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            return array(
                "data" => $data,
                "dataAll" => $dataAll,
                "count" => $count
            );
        }
    }

    //เรียกข้อมูลไฟล์อัพโหลด
    function getFile($WFR_ID = null)
    {
        $wh = "";
        if ($WFR_ID) {
            $wh .= " AND WFR_ID = '$WFR_ID'";
        }

        $sql = "SELECT * FROM WF_FILE WHERE FILE_STATUS = 'Y' {$wh}";
        $data = self::getFetch($sql);
        $dataAll = self::getFetchAll($sql);
        $count = self::getRowCount($sql);

        if ($data) {
            return array(
                "data" => !empty($WFR_ID) ? $data : null,
                "dataAll" => $dataAll,
                "count" => $count
            );
        }
    }
}
