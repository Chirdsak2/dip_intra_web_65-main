<?php
$accept_token     = ready(trim($_COOKIE["acceptcookie_token"]));
$current_datetime = date("Y-m-d H:i:s"); 

if($accept_token!=""){
    $find_accept = $db->query("SELECT COUNT(accept_id) AS total FROM accept_cookie_history 
                               WHERE accept_token = '$accept_token' COLLATE utf8_bin
                                 AND accept_expire > '$current_datetime'");
    $findtoken_data = $db->db_fetch_array($find_accept);

    if($findtoken_data["total"]==0){
        $_COOKIE["acceptcookie_token"] = '';
        setcookie("acceptcookie_token","",
        ['expires' =>  time()+0,
         'path' => '/',
         'domain' => $EWT_COOKIE_DOMAIN,
         'secure' => $EWT_COOKIE_SECURE,
         'httponly' => $EWT_COOKIE_HTTPONLY,
         'samesite' => $EWT_COOKIE_SAMESITE
        ]);
        unset($accept_token);
    }
    else{
        ## >> Start session since accept cookie token is confirmed
        session_start();
    }
}
?>