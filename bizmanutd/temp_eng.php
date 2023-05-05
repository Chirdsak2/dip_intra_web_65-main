<?php
exit;
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE ".$EWT_DB_NAME);


//step 1
//DELETE  FROM temp_eng WHERE temp_fname_en='' or temp_lname_en='' 
//echo "Done step 1 !";

/*
//step 2
$sql = $db->query("SELECT * FROM  temp_eng ");
while($R=$db->db_fetch_array($sql)){
  $fname_th = eregi_replace("'","",trim($R[temp_fname_th]));
  $fname_th = eregi_replace('"',"",$fname_th);

  $lname_th = eregi_replace("'","",trim($R[temp_lname_th]));
  $lname_th = eregi_replace('"',"", $lname_th);

  $fname_en = eregi_replace("'","",trim($R[temp_fname_en]));
  $fname_en = eregi_replace('"',"",$fname_en);

  $lname_en = eregi_replace("'","",trim($R[temp_lname_en]));
  $lname_en = eregi_replace('"',"", $lname_en);

  $db->query("UPDATE  temp_eng SET temp_fname_th = '$fname_th', temp_lname_th='$lname_th' ,temp_fname_en = '$fname_en', temp_lname_en='$lname_en'  
  WHERE  id = '$R[id]' ");
}
echo "Done step 2 !";
*/

//step 3
 $sql = $db->query("SELECT temp_fname_en,temp_lname_en,gen_user_id 
                                        FROM gen_user INNER JOIN  temp_eng ON 
										gen_user.name_thai=temp_eng.temp_fname_th  AND
										gen_user.surname_thai=temp_eng.temp_lname_th ");
 while($R=$db->db_fetch_array($sql)){
    $db->query("UPDATE  gen_user SET name_eng = '$R[temp_fname_en]', surname_eng='$R[temp_lname_en]' WHERE gen_user_id='$R[gen_user_id]' ");
 }
echo "Done step 3 !";
$db->db_close();
?>
