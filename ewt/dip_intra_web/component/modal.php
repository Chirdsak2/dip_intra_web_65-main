<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);

//----------------------------------Get Model------------------------------------//
$table = conText($_REQUEST["table"]);
$table_join = conText($_REQUEST["table_join"]);
$select = conText($_REQUEST["select"]);
$where = conText($_REQUEST["where"]);
$where_id = conText($_REQUEST["where_id"]);
//----------------------------------Set Array------------------------------------//
$array_list = array();
$array_field = array();
$array_data = array();

$_sql = "";
$_sql .= "SELECT {$select} FROM {$table} ";

if (!empty($table_join)) {
    $_sql .= $table_join;
}

$_sql .= " WHERE 1=1 {$where} " . $where_id;
$a_row = dbdpis::getRowCount($_sql);
$a_data = dbdpis::getFetch($_sql);
$a_field = dbdpis::getColumn($_sql);

if ($a_row > 0) {
    $array_list["arrayData"] = $a_data;
    $array_list["status"] = "success";
    $array_list["messages"] = "พบข้อมูล";
} else {
    $array_list["arrayData"] = null;
    $array_list["status"] = "error";
    $array_list["messages"] = "ไม่พบข้อมูล!";
}
$array_list["type"] = $type;
$array_list["sql"] = $_sql;

echo json_encode($array_list);
exit();
