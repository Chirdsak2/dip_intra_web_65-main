<?php 
header('Content-type: application/json; charset=utf-8');
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$flag        = $_POST["flag"];
$error_array = array();

if($flag == "register_submit"){
    $register_from          = trim($_POST["register_from"]);
    $register_purpose       = trim($_POST["register_purpose"]);
    $register_union         = trim($_POST["register_union"]);
    $register_date          = trim($_POST["register_date"]);
    $register_time          = trim($_POST["register_time"]);
    $register_topic         = $_POST["register_topic"];
    $register_coordinator   = trim($_POST["register_coordinator"]);
    $register_tel           = trim($_POST["register_tel"]);
    $register_permission    = trim($_POST["register_permission"]);
    $register_file          = $_FILES["register_file"];

    $register_type          = trim($_POST["register_type"]);


    $time_array = array();
    $time_data = $db->query("SELECT time_id FROM cal_register_time");
    while($time_info = $db->db_fetch_array($time_data)){
        array_push($time_array,$time_info["time_id"]);
    }	

    $topicname_array = array();
    $topic_data  = $db->query("SELECT topic_id FROM cal_register_topic WHERE reg_type = '$register_type' ORDER BY topic_id");
    while($topic_info = $db->db_fetch_array($topic_data)){
        array_push($topicname_array,$topic_info["topic_id"]);
    }

    ## >> Check from
    if($register_from==""){
        array_push($error_array,array("input_text"=>'กรุณาระบุชื่อหน่วยงาน/สถาบันการศึกษา',"input_id"=>"alert_text_registerfrom"));
    }
    
    ## >> Check purpose
    if($register_purpose==""){
        array_push($error_array,array("input_text"=>'กรุณาระบุวัตถุประสงค์',"input_id"=>"alert_text_registerpurpose"));
    }

    ## >> Check date (Tuesday and Thurday only)
    if($register_date==""){
        array_push($error_array,array("input_text"=>'กรุณาระบุวันที่',"input_id"=>"alert_text_registerdate"));
    }
    else{
        $r_date = explode("/",$register_date);
        $r_date = ($r_date[2]-543)."-".$r_date[1]."-".$r_date[0];
        $r_date = filter_date("-",$r_date);
        
        if($r_date==""){
            array_push($error_array,array("input_text"=>'รูปแบบวันที่ไม่ถูกต้อง',"input_id"=>"alert_text_registerdate"));
        }
        else{
            $dayofweek = date('w',strtotime($r_date));

            if(!in_array($dayofweek,array(2,4))){
                array_push($error_array,array("input_text"=>'กรุณาเลือกเฉพาะวันอังคารหรือวันพฤหัสเท่านั้น',"input_id"=>"alert_text_registerdate"));
            }
            else if(strtotime($r_date)<strtotime(date("Y-m-d"))){
                array_push($error_array,array("input_text"=>'ท่านไม่สามารถเลือกวันที่ที่ผ่านมาแล้วได้',"input_id"=>"alert_text_registerdate"));
            }
            else{
                $register_date = $r_date;
            }
        }
    }

    ## >> Check time
    if($register_time==""){
        array_push($error_array,array("input_text"=>'กรุณาเลือกเวลา',"input_id"=>"alert_text_registertime"));
    }
    else{
        if(!in_array($register_time,$time_array)){
            array_push($error_array,array("input_text"=>'เวลาไม่ถูกต้อง',"input_id"=>"alert_text_registertime"));
        }
    }

    ## >> Check topic
    $valid_topic_array = $topicname_array;

    if($register_type==1){
        $valid       = "Y";
        $count_topic = count($register_topic);

        foreach($register_topic AS $topic){
            if(!in_array($topic,$valid_topic_array)){
                $valid = "N";
            }
        }

        if($count_topic == 0){
            array_push($error_array,array("input_text"=>'กรุณาเลือกอย่างน้อย 1 คำตอบ',"input_id"=>"alert_text_registertopic"));
        }
        else if($count_topic > 3){
            array_push($error_array,array("input_text"=>'กรุณาเลือกเพียง 3 คำตอบ',"input_id"=>"alert_text_registertopic"));
        }
        else if($valid=="N"){
            array_push($error_array,array("input_text"=>'คำตอบไม่ถูกต้อง',"input_id"=>"alert_text_registertopic"));
        }
    }
    else if($register_type==2){
        $register_topic = trim($register_topic);
        
        if($register_topic==""){
            array_push($error_array,array("input_text"=>'กรุณาเลือกหัวข้อในการเข้าชม',"input_id"=>"alert_text_registertopic"));
        }
        else if(!in_array($register_topic,$valid_topic_array)){
            array_push($error_array,array("input_text"=>'หัวข้อในการเข้าชมไม่ถูกต้อง',"input_id"=>"alert_text_registertopic"));
        }
    }

    ## >> Check coordinator
    if($register_coordinator==""){
        array_push($error_array,array("input_text"=>'กรุณาระบุผู้ประสานงาน',"input_id"=>"alert_text_registercoordinator"));
    }
    
    ## >> Check tel
    if($register_tel==""){
        array_push($error_array,array("input_text"=>'กรุณาระบุเบอร์ติดต่อ',"input_id"=>"alert_text_registertel"));
    }
    else{
        if(filter_number($register_tel)==""){
            array_push($error_array,array("input_text"=>'กรุณาใส่เฉพาะตัวเลข',"input_id"=>"alert_text_registertel"));
        }
    }
    
    ## >> Check recording permission
    if($register_permission==""){
        array_push($error_array,array("input_text"=>'กรุณาเลือก 1 คำตอบ',"input_id"=>"alert_text_registerpermission"));
    }
    else if(!in_array($register_permission,array("Yes","No"))){
        array_push($error_array,array("input_text"=>'คำตอบไม่ถูกต้อง',"input_id"=>"alert_text_registerpermission"));
    }

    ## >> Check file
    if($register_file["size"]==0){
        array_push($error_array,array("input_text"=>"กรุณาเลือกไฟล์เพื่อ upload","input_id"=>"alert_text_registerfile"));
    }
    else{
        $extension = explode(".",$register_file["name"]);
        $extension = strtolower($extension[count($extension)-1]);
        $valid_extension = array("pdf");

        if(!in_array($extension,$valid_extension)){
            array_push($error_array,array("input_text"=>"นามสกุลไฟล์ไม่ถูกต้อง","input_id"=>"alert_text_registerfile"));
        }
        else if($register_file["size"]>5000000){
            array_push($error_array,array("input_text"=>"ไฟล์ขนาดเกินกว่าที่กำหนด","input_id"=>"alert_text_registerfile"));
        }
    }

    if(!in_array($register_type,array(1,2))){
        exit();
    }
    
    ##==========================================================================================================##
    if(count($error_array)>0){
        return_data("error",$error_array);
        exit();
    }
    ##==========================================================================================================##
    ## >> Insert into table
    $register_from          = ready($register_from);
    $register_purpose       = ready($register_purpose);
    $register_union         = ready($register_union);
    $register_date          = ready($register_date);
    $register_time          = ready($register_time);
    $register_coordinator   = ready($register_coordinator);
    $register_tel           = ready($register_tel);
    $register_permission    = ready($register_permission);

    $register_type          = ready($register_type);

    if($_SERVER["REMOTE_ADDR"]){
		$reg_ip = ready($_SERVER["REMOTE_ADDR"]);
	}else{
		$reg_ip = ready($_SERVER["REMOTE_HOST"]);
    }
    
    $reg_code = makerandomletter(50);

    $db->query("INSERT INTO cal_register_visit (reg_from,reg_purpose,reg_union,
                                                reg_date,reg_time,reg_coordinator,
                                                reg_tel,reg_permission,
                                                reg_timestamp,reg_ip,reg_code,
                                                reg_type)
                                        VALUES ('$register_from','$register_purpose','$register_union',
                                                '$register_date','$register_time','$register_coordinator',
                                                '$register_tel','$register_permission',
                                                NOW(),'$reg_ip','$reg_code',
                                                '$register_type')");

    ## Get reg_id and insert topic
    $reg_data = $db->query("SELECT reg_id FROM cal_register_visit WHERE reg_code = '$reg_code' COLLATE utf8_bin");
    $reg_info = $db->db_fetch_array($reg_data);
    $reg_id   = $reg_info["reg_id"];

    $db->query("UPDATE cal_register_visit SET reg_code = NULL WHERE reg_id = '$reg_id'");

    if($register_type==1){
        foreach($register_topic AS $topic){
            $db->query("INSERT INTO cal_register_visit_topic (reg_id,topic_id) VALUES ('$reg_id','$topic') ");
        }
    }
    else if($register_type==2){
        $db->query("INSERT INTO cal_register_visit_topic (reg_id,topic_id) VALUES ('$reg_id','$register_topic') ");
    }

    ## Copy file - update
    $newname = "reg_".$reg_id.makerandomletter(5)."_".date("YmdHis").".pdf";
    copy($register_file["tmp_name"],"../calendar_register/".$newname);
    $db->query("UPDATE cal_register_visit SET reg_file = '$newname' WHERE reg_id = '$reg_id'");

    return_data("success",array("text"=>"ระบบได้ทำการบันทึกข้อมูลการจองของท่านเรียบร้อยแล้ว","redirect"=>"calendar_visit.php"));
    exit();
}

?>