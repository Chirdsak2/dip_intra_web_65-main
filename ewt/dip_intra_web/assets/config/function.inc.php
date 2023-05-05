<?php
spl_autoload_register('autoload');
function autoload($classname)
{
  $a_path = array(
    path . 'class'
  );
  foreach ($a_path as $_path) {
    $myDirectory = opendir($_path);
    while ($entryName = readdir($myDirectory)) {
      $a_dir[] = $entryName;
    }
    closedir($myDirectory);
    if ($a_dir) {
      foreach ($a_dir as $_item) {
        $filename = $_path . "/" . $_item . "/" . $classname . ".class.php";
        if (is_file($filename)) {
          include_once($filename);
          break;
        }
      }
    }
  }
}

function setSessionTime($_timeSecond)
{
  if (!isset($_SESSION['ses_time_life'])) {
    $_SESSION['ses_time_life'] = time();
  }
  if (isset($_SESSION['ses_time_life']) && time() - $_SESSION['ses_time_life'] > $_timeSecond) {
    if (count($_SESSION) > 0) {
      foreach ($_SESSION as $key => $value) {
        unset($$key);
        unset($_SESSION[$key]);
      }
    }
  }
}

function redirect($s_url)
{
  echo '<script type="text/javascript">';
  echo 'window.location.href="' . $s_url . '";';
  echo '</script>';
  echo '<noscript>';
  echo '<meta http-equiv="refresh" content="0;url=' . $s_url . '" />';
  echo '</noscript>';
  exit;
}

function getLocation($s_mod, $s_value = false)
{
  if (is_array($s_value)) $a_value = $s_value;
  else parse_str($s_value, $a_value);

  $s_value_query = ($s_value) ? '?' . urldecode(http_build_query($a_value)) : '';
  // $s_url = sys::baseURL().$s_mod.$s_value_query;
  // return $s_url;
}

function getIP()
{
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
    $ipaddress = getenv('HTTP_CLIENT_IP');
  else if (getenv('HTTP_X_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if (getenv('HTTP_X_FORWARDED'))
    $ipaddress = getenv('HTTP_X_FORWARDED');
  else if (getenv('HTTP_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if (getenv('HTTP_FORWARDED'))
    $ipaddress = getenv('HTTP_FORWARDED');
  else if (getenv('REMOTE_ADDR'))
    $ipaddress = getenv('REMOTE_ADDR');
  else
    $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

function get($s_name, $s_defalut = null)
{
  return ($_GET[$s_name]) ? $_GET[$s_name] : $s_defalut;
}

function getParam($s_name, $s_defalut = null)
{
  return !empty($_GET[$s_name]) ? $_GET[$s_name] : $s_defalut;
}

function getLink($link_html)
{
  if (strstr($link_html, 'cid')) {
    $link = $link_html;
  } else if (strstr($link_html, 'http') || strstr($link_html, 'https') || strstr($link_html, 'wwww')) {
    $link = $link_html;
  } else if (strstr($link_html, 'nid')) {
    $sub_link = explode("=", $link_html);

    $_sql   =  "SELECT * FROM article_list WHERE n_id = '{$sub_link[1]}' ";
    $a_data =   db::getFetch($_sql, PDO::FETCH_ASSOC);

    if ($a_data["link_html"] == "") {
      $link = "news_view.php?nid=" . $sub_link[1];
    } else {
      //$link = glink($a_data["link_html"]);
    }
  } else if (strstr($link_html, 'news_view.php') || strstr($link_html, 'news_view.php')) {
    //$sub_link = explode("=",$link_html);
    $_sql   =  "SELECT * FROM article_list WHERE link_html = '{$link_html}' ";
    $a_data =   db::getFetch($_sql, PDO::FETCH_ASSOC);
    $link = "news_view.php?nid=" . $a_data["n_id"];
  } else {
    if ($link_html != "" && $link_html != "#") {
      $link = "" . E_IP_ROOT . "ewt/" . E_FOLDER_USER . "/" . $link_html;
    } else {
      $link = "";
    }
  }
  return $link;
}

function getSalt($s_num)
{
  $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789][{}";:?.>,<!@#$^&*()-_=+|';
  $randStringLen = $s_num;

  $randString = "";
  for ($i = 0; $i < $randStringLen; $i++) {
    $randString .= $charset[mt_rand(0, strlen($charset) - 1)];
  }
  return $randString;
}

function getNumber($length)
{
  $chars = '0123456789';
  return substr(str_shuffle($chars), 0, $length);
}

function getPass($s_num)
{
  $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $randStringLen = $s_num;

  $randString = "";
  for ($i = 0; $i < $randStringLen; $i++) {
    $randString .= $charset[mt_rand(0, strlen($charset) - 1)];
  }
  return getNumber('2') . $randString;
}

function isDate($s_date)
{
  $s_date = date('Y-m-d H:i:s', strtotime($s_date));
  if (preg_match("/^[0-9]{1,2}//[0-9]{1,2}//[0-9]{4}+$/", $s_date) || preg_match("/^[0-9]{1,2}//[0-9]{1,2}//[0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}+$/", $s_date) || preg_match("/^[0-9]{1,2}//[0-9]{1,2}//[0-9] [0-9]{1,2}:[0-9]{1,2}+$/", $s_date)) {
    $a_data = explode(' ', $s_date);
    $a_date = explode('/', $a_data[0]);
    $s_d = $a_date[0];
    $s_m = $a_date[1];
    $s_y = $a_date[2] - 543;
    return checkdate($s_m, $s_d, $s_y);
  } else if (preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}+$/", $s_date) || preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}+$/", $s_date) || preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{1,2}:[0-9]{1,2}+$/", $s_date)) {
    $a_data = explode(' ', $s_date);
    $a_date = explode('-', $a_data[0]);
    $s_y = $a_date[0] - 543;
    $s_m = $a_date[1];
    $s_d = $a_date[2];
    return checkdate($s_m, $s_d, $s_y);
  } else if ($s_date == '' || is_null($s_date)) {
    return false;
  }
  return false;
}

function convDateStartToEnd($s_start, $s_end, $s_format = 'd/m/Y H:i')
{
  $a_month = array(
    'January' => 'มกราคม',
    'February' => 'กุมภาพันธ์',
    'March' => 'มีนาคม',
    'April' => 'เมษายน',
    'May' => 'พฤษภาคม',
    'June' => 'มิถุนายน',
    'July' => 'กรกฎาคม',
    'August' => 'สิงหาคม',
    'September' => 'กันยายน',
    'October' => 'ตุลาคม',
    'November' => 'พฤศจิกายน',
    'December' => 'ธันวาคม',
  );

  $a_sh_month = array(
    'Jan' => 'ม.ค.',
    'Feb' => 'ก.พ.',
    'Mar' => 'มี.ค.',
    'Apr' => 'เม.ย',
    'May' => 'พ.ค.',
    'Jun' => 'มิ.ย.',
    'Jul' => 'ก.ค.',
    'Aug' => 'ส.ค.',
    'Sep' => 'ก.ย.',
    'Oct' => 'ต.ค.',
    'Nov' => 'พ.ย.',
    'Dec' => 'ธ.ค.',
  );

  if ($s_start == '0000-00-00' || $s_end == '0000-00-00' || $s_start == '' || $s_end == '') {
    return null;
  } else if (isDate($s_start) && isDate($s_end)) {

    $s_sdata = date($s_format, strtotime($s_start));
    $s_edata = date($s_format, strtotime($s_end));
    $s_jsday   = date('j', strtotime($s_start));
    $s_nsmonth = date('n', strtotime($s_start));
    $s_jeday   = date('j', strtotime($s_end));
    $s_nemonth = date('n', strtotime($s_end));

    $s_syear    = date('Y', strtotime($s_start));
    $s_smonth   = date('F', strtotime($s_start));
    $s_sshmonth = date('M', strtotime($s_start));
    $s_eyear    = date('Y', strtotime($s_end));
    $s_emonth   = date('F', strtotime($s_end));
    $s_eshmonth = date('M', strtotime($s_end));

    if (preg_match("/F/", $s_format)) {
      if ($s_nsmonth == $s_nemonth  &&  $s_syear == $s_eyear &&   $s_jsday != $s_jeday) {
        $s_data =  $s_jsday . ' - ' . $s_jeday . ' ' . $a_month[$s_smonth] . ' ' . ($s_syear + 543);
      } else if ($s_nsmonth == $s_nemonth  &&  $s_syear == $s_eyear &&   $s_jsday == $s_jeday) {
        $s_data =  $s_jsday . ' ' . $a_month[$s_smonth] . ' ' . ($s_syear + 543);
      } else if ($s_nsmonth != $s_nemonth  &&  $s_syear == $s_eyear &&   $s_jsday != $s_jeday) {
        $s_data =  $s_jsday . ' ' . $a_month[$s_smonth] . ' - ' . $s_jeday . ' ' . $a_month[$s_emonth] . ' ' . ($s_syear + 543);
      } else {

        $s_data =  $s_jsday . ' ' . $a_month[$s_smonth] . ' ' . ($s_syear + 543) . ' - ' . $s_jeday . ' ' . $a_month[$s_emonth] . ' ' . ($s_eyear + 543);
      }
    }
    if (preg_match("/M/", $s_format)) {
      if ($s_nsmonth == $s_nemonth  &&  $s_syear == $s_eyear &&   $s_jsday != $s_jeday) {
        //$s_data =  $s_jsday.' '.$s_jeday.' '.$a_shot_month[$s_sshmonth].' '.$s_syear;
      }
    }

    return trim($s_data);
  }
  return null;
}

function convDateTimeStartToEnd($s_start, $s_end, $s_format = 'd/m/Y H:i')
{
  $a_month = array(
    'January' => 'มกราคม',
    'February' => 'กุมภาพันธ์',
    'March' => 'มีนาคม',
    'April' => 'เมษายน',
    'May' => 'พฤษภาคม',
    'June' => 'มิถุนายน',
    'July' => 'กรกฎาคม',
    'August' => 'สิงหาคม',
    'September' => 'กันยายน',
    'October' => 'ตุลาคม',
    'November' => 'พฤศจิกายน',
    'December' => 'ธันวาคม',
  );

  $a_sh_month = array(
    'Jan' => 'ม.ค.',
    'Feb' => 'ก.พ.',
    'Mar' => 'มี.ค.',
    'Apr' => 'เม.ย',
    'May' => 'พ.ค.',
    'Jun' => 'มิ.ย.',
    'Jul' => 'ก.ค.',
    'Aug' => 'ส.ค.',
    'Sep' => 'ก.ย.',
    'Oct' => 'ต.ค.',
    'Nov' => 'พ.ย.',
    'Dec' => 'ธ.ค.',
  );
  //return $s_start;
  //exit;

  if ($s_start == '0000-00-00' || $s_end == '0000-00-00' || $s_start == '' || $s_end == '') {
    return null;
  } else if (isDate($s_start) && isDate($s_end)) {
    $a_sdate = explode('-', $s_start);
    $s_y = $a_sdate[0] - 543;
    $s_m = $a_sdate[1];
    $s_d = $a_sdate[2];

    $a_edate = explode('-', $s_end);
    $e_y = $a_edate[0] - 543;
    $e_m = $a_edate[1];
    $e_d = $a_edate[2];

    $s_start = $s_y . '-' . $s_m . '-' . $s_d;
    $s_end   = $e_y . '-' . $e_m . '-' . $e_d;

    $s_sdata = date($s_format, strtotime($s_start));
    $s_edata = date($s_format, strtotime($s_end));
    $s_jsday   = date('j', strtotime($s_start));
    $s_nsmonth = date('n', strtotime($s_start));
    $s_jeday   = date('j', strtotime($s_end));
    $s_nemonth = date('n', strtotime($s_end));

    $s_syear    = date('Y', strtotime($s_start));
    $s_smonth   = date('F', strtotime($s_start));
    $s_sshmonth = date('M', strtotime($s_start));
    $s_eyear    = date('Y', strtotime($s_end));
    $s_emonth   = date('F', strtotime($s_end));
    $s_eshmonth = date('M', strtotime($s_end));

    //return  $s_syear;
    //exit;

    if (preg_match("/F/", $s_format)) {
      if ($s_nsmonth == $s_nemonth  &&  $s_syear == $s_eyear &&   $s_jsday != $s_jeday) {
        $s_data =  $s_jsday . ' - ' . $s_jeday . ' ' . $a_month[$s_smonth] . ' ' . ($s_syear + 543);
      } else if ($s_nsmonth == $s_nemonth  &&  $s_syear == $s_eyear &&   $s_jsday == $s_jeday) {
        $s_data =  $s_jsday . ' ' . $a_month[$s_smonth] . ' ' . ($s_syear + 543);
      } else if ($s_nsmonth != $s_nemonth  &&  $s_syear == $s_eyear &&   $s_jsday != $s_jeday) {
        $s_data =  $s_jsday . ' ' . $a_month[$s_smonth] . ' - ' . $s_jeday . ' ' . $a_month[$s_emonth] . ' ' . ($s_syear + 543);
      } else {

        $s_data =  $s_jsday . ' ' . $a_month[$s_smonth] . ' ' . ($s_syear + 543) . ' - ' . $s_jeday . ' ' . $a_month[$s_emonth] . ' ' . ($s_eyear + 543);
      }
    }
    if (preg_match("/M/", $s_format)) {
      if ($s_nsmonth == $s_nemonth  &&  $s_syear == $s_eyear &&   $s_jsday != $s_jeday) {
        //$s_data =  $s_jsday.' '.$s_jeday.' '.$a_shot_month[$s_sshmonth].' '.$s_syear;
      }
    }

    return trim($s_data);
  }
  return null;
}

function convDateShow($s_date, $s_format = 'd/m/Y H:i')
{
  $a_month = array(
    'January' => 'มกราคม',
    'February' => 'กุมภาพันธ์',
    'March' => 'มีนาคม',
    'April' => 'เมษายน',
    'May' => 'พฤษภาคม',
    'June' => 'มิถุนายน',
    'July' => 'กรกฎาคม',
    'August' => 'สิงหาคม',
    'September' => 'กันยายน',
    'October' => 'ตุลาคม',
    'November' => 'พฤศจิกายน',
    'December' => 'ธันวาคม',
  );
  $a_sh_month = array(
    'Jan' => 'ม.ค.',
    'Feb' => 'ก.พ.',
    'Mar' => 'มี.ค.',
    'Apr' => 'เม.ย',
    'May' => 'พ.ค.',
    'Jun' => 'มิ.ย.',
    'Jul' => 'ก.ค.',
    'Aug' => 'ส.ค.',
    'Sep' => 'ก.ย.',
    'Oct' => 'ต.ค.',
    'Nov' => 'พ.ย.',
    'Dec' => 'ธ.ค.',
  );

  if ($s_date == '0000-00-00 00:00:00' || $s_date == '0000-00-00' || $s_date == '00:00:00' || $s_date == '') {
    return null;
  } else if (isDate($s_date)) {
    $a_sdate = explode('-', $s_date);
    $s_y = $a_sdate[0];
    $s_m = $a_sdate[1];
    $s_d = $a_sdate[2];
    $s_date = $s_y . '-' . $s_m . '-' . $s_d;

    $s_data = date($s_format, strtotime($s_date));
    $s_year = date('Y', strtotime($s_date));
    $s_month = date('F', strtotime($s_date));
    $s_sh_month = date('M', strtotime($s_date));
    $s_data = str_replace($s_year, ($s_year + 543), $s_data);
    if (preg_match("/F/", $s_format)) {
      $s_data = str_replace($s_month, $a_month[$s_month], $s_data);
    }
    if (preg_match("/M/", $s_format)) {
      $s_data = str_replace($s_sh_month, $a_sh_month[$s_sh_month], $s_data);
    }
    return trim($s_data);
  }
  return null;
}

function convDateShowEN($s_date, $s_format = 'd/m/Y H:i')
{
  $a_month = array(
    'January' => 'มกราคม',
    'February' => 'กุมภาพันธ์',
    'March' => 'มีนาคม',
    'April' => 'เมษายน',
    'May' => 'พฤษภาคม',
    'June' => 'มิถุนายน',
    'July' => 'กรกฎาคม',
    'August' => 'สิงหาคม',
    'September' => 'กันยายน',
    'October' => 'ตุลาคม',
    'November' => 'พฤศจิกายน',
    'December' => 'ธันวาคม',
  );
  $a_sh_month = array(
    'Jan' => 'ม.ค.',
    'Feb' => 'ก.พ.',
    'Mar' => 'มี.ค.',
    'Apr' => 'เม.ย',
    'May' => 'พ.ค.',
    'Jun' => 'มิ.ย.',
    'Jul' => 'ก.ค.',
    'Aug' => 'ส.ค.',
    'Sep' => 'ก.ย.',
    'Oct' => 'ต.ค.',
    'Nov' => 'พ.ย.',
    'Dec' => 'ธ.ค.',
  );

  if ($s_date == '0000-00-00 00:00:00' || $s_date == '0000-00-00' || $s_date == '00:00:00' || $s_date == '') return null;
  else if (isDate($s_date)) {
    $s_data = date($s_format, strtotime($s_date));
    $s_year = date('Y', strtotime($s_date));
    $s_month = date('F', strtotime($s_date));
    $s_sh_month = date('M', strtotime($s_date));
    $s_data = str_replace($s_year, ($s_year), $s_data);
    if (preg_match("/F/", $s_format)) {
      $s_data = str_replace($s_month, $a_month[$s_month], $s_data);
    }
    if (preg_match("/M/", $s_format)) {
      $s_data = str_replace($s_sh_month, $a_sh_month[$s_sh_month], $s_data);
    }
    return trim($s_data);
  }
  return null;
}

function convDateTimeShow($s_date, $s_format = 'd/m/Y H:i')
{
  $a_month = array(
    'January' => 'มกราคม',
    'February' => 'กุมภาพันธ์',
    'March' => 'มีนาคม',
    'April' => 'เมษายน',
    'May' => 'พฤษภาคม',
    'June' => 'มิถุนายน',
    'July' => 'กรกฎาคม',
    'August' => 'สิงหาคม',
    'September' => 'กันยายน',
    'October' => 'ตุลาคม',
    'November' => 'พฤศจิกายน',
    'December' => 'ธันวาคม',
  );
  $a_sh_month = array(
    'Jan' => 'ม.ค.',
    'Feb' => 'ก.พ.',
    'Mar' => 'มี.ค.',
    'Apr' => 'เม.ย',
    'May' => 'พ.ค.',
    'Jun' => 'มิ.ย.',
    'Jul' => 'ก.ค.',
    'Aug' => 'ส.ค.',
    'Sep' => 'ก.ย.',
    'Oct' => 'ต.ค.',
    'Nov' => 'พ.ย.',
    'Dec' => 'ธ.ค.',
  );

  if ($s_date == '0000-00-00 00:00:00' || $s_date == '0000-00-00' || $s_date == '00:00:00' || $s_date == '') {
    return null;
  } else if (isDate($s_date)) {
    $s_data = date($s_format, strtotime($s_date));
    $s_year = date('Y', strtotime($s_date));
    $s_month = date('F', strtotime($s_date));
    $s_sh_month = date('M', strtotime($s_date));
    $s_h = date('H', strtotime($s_date));
    $s_i = date('i', strtotime($s_date));

    $s_data = str_replace($s_year, ($s_year + 543), $s_data);
    if (preg_match("/F/", $s_format)) {
      $s_data = str_replace($s_month, $a_month[$s_month], $s_data);
    }
    if (preg_match("/M/", $s_format)) {
      $s_data = str_replace($s_sh_month, $a_sh_month[$s_sh_month], $s_data);
    }
    return trim($s_data) . ' : ' . $s_h . '.' . $s_i . ' น.';
  }
  return null;
}

function convDateTimeShowEN($s_date, $s_format = 'd/m/Y H:i')
{
  $a_month = array(
    'January' => 'มกราคม',
    'February' => 'กุมภาพันธ์',
    'March' => 'มีนาคม',
    'April' => 'เมษายน',
    'May' => 'พฤษภาคม',
    'June' => 'มิถุนายน',
    'July' => 'กรกฎาคม',
    'August' => 'สิงหาคม',
    'September' => 'กันยายน',
    'October' => 'ตุลาคม',
    'November' => 'พฤศจิกายน',
    'December' => 'ธันวาคม',
  );
  $a_sh_month = array(
    'Jan' => 'ม.ค.',
    'Feb' => 'ก.พ.',
    'Mar' => 'มี.ค.',
    'Apr' => 'เม.ย',
    'May' => 'พ.ค.',
    'Jun' => 'มิ.ย.',
    'Jul' => 'ก.ค.',
    'Aug' => 'ส.ค.',
    'Sep' => 'ก.ย.',
    'Oct' => 'ต.ค.',
    'Nov' => 'พ.ย.',
    'Dec' => 'ธ.ค.',
  );

  if ($s_date == '0000-00-00 00:00:00' || $s_date == '0000-00-00' || $s_date == '00:00:00' || $s_date == '') {
    return null;
  } else if (isDate($s_date)) {
    $s_data = date($s_format, strtotime($s_date));
    $s_year = date('Y', strtotime($s_date));
    $s_month = date('F', strtotime($s_date));
    $s_sh_month = date('M', strtotime($s_date));
    $s_h = date('H', strtotime($s_date));
    $s_i = date('i', strtotime($s_date));

    $s_data = str_replace($s_year, $s_year, $s_data);
    if (preg_match("/F/", $s_format)) {
      $s_data = str_replace($s_month, $a_month[$s_month], $s_data);
    }
    if (preg_match("/M/", $s_format)) {
      $s_data = str_replace($s_sh_month, $a_sh_month[$s_sh_month], $s_data);
    }
    return trim($s_data) . ' : ' . $s_h . '.' . $s_i;
  }
  return null;
}

function sizeMB2byte($size)
{
  $bytesize = $size * (1024.0 * 1024);
  return $bytesize;
}

function EwtMaxfile($s_type)
{
  //if(SYS_LANG){
  //include('language/lang_'.SYS_LANG.'.php');
  //}
  $s_sql   = "SELECT * FROM site_info";
  $a_data =  db::getFetch($s_sql);

  if ($s_type == 'file') {
    $a_size =  $a_data['site_info_max_file'];
  } else if ($s_type == 'img') {
    $a_size = $a_data['site_info_max_img'];
  } else if ($s_type == 'vdo') {
    $a_size = $a_data['site_info_max_vdo'];
  } else {
    $a_size = '';
  }
  $text_size = '';

  return $text_size . ' ' . $a_size . ' MB.';
}

function EwtTypefile($s_type)
{
  //if(SYS_LANG){
  //include('language/lang_'.SYS_LANG.'.php');
  //}
  $s_sql = "SELECT * FROM site_info";
  $a_data =  db::getFetch($s_sql);

  if ($s_type == 'file') {
    $a_tyle = $a_data['site_type_file'];
  } else if ($s_type == 'img') {
    $a_tyle = $a_data['site_type_img_file'];
  } else if ($s_type == 'vdo') {
    $a_tyle = $a_data['site_type_vdo_file'];
  } else {
    $a_tyle = '';
  }
  return $a_tyle;
}

function ValidfileType($s_type)
{
  if ($s_type) {
    return str_replace(",", "|", EwtTypefile($s_type));
  }
}

function showWord($s_text, $s_limit = 0, $s_type = false)
{
  if ($s_limit) {
    $i_lenstr = mb_strlen($s_text);
    if ($s_limit > 0 && $i_lenstr > $s_limit) {
      $s_str = mb_substr(nl2br(showText($s_text, $s_type)), 0, $s_limit);
      return $s_str . '&hellip;' . 'อ่านต่อ';
    } else return nl2br(showText($s_text, $s_type));
  } else {
    if ($s_type) return showText($s_text, $s_type);
    else return nl2br(showText($s_text, $s_type));
  }
}

function showText($s_text, $s_type = false)
{
  if ($s_type) return $s_text;
  return htmlspecialchars($s_text, ENT_QUOTES);
}

function showNumber($s_data)
{
  if (is_numeric($s_data)) return number_format($s_data, 0, '.', ',');
  else return 0;
}

function showZero($s_text, $s_len = 4)
{
  $s_count = mb_strlen($s_text);
  if ($_i = $s_count <= $s_len) {
    $s_zero = str_repeat('0', ($s_len - $s_count));
  }
  return $s_zero . $s_text;
}

function showFloat($s_data, $s_decimal = 2)
{
  if (is_numeric($s_data)) return number_format($s_data, $s_decimal, '.', ',');
  else return number_format(0, $s_decimal, '.', ',');
}

function getExtensionFile($s_fullname, $s_name)
{
  $idx = explode('.', $s_fullname);
  $count_explode = count($idx);
  if ($count_explode == 1) {
    $name = $s_name;
  } else {
    $idx = strtolower($idx[$count_explode - 1]);
    $name = $s_name . '.' . $idx;
  }
  return $name;
}

function getExtension($s_fullname)
{
  $idx = explode('.', $s_fullname);
  $count_explode = count($idx);
  if ($count_explode == 1) {
    return '';
  } else {
    $idx = strtolower($idx[$count_explode - 1]);
    return $idx;
  }
}

function getImgbase64($s_fullname, $_img_show = null)
{
  // Get the image and convert into string 
  $img = file_get_contents($s_fullname);
  if ($img) {
    $Extension = getExtension($s_fullname);
    // Encode the image string data into base64 
    $imgbase64 = base64_encode($img);
    return 'data:image/' . $Extension . ';base64,' . $imgbase64;
  } else {
    return $_img_show;
  }
}

//Creating Function
function getTimeAgo($oldTime, $newTime = false)
{
  $newTime = date("Y-m-d H:i:s");

  $timeCalc = strtotime($newTime) - strtotime($oldTime);

  if ($timeCalc >= (60 * 60 * 24 * 30 * 12 * 2)) {
    //$timeCalc = intval($timeCalc/60/60/24/30/12) . " years ago";
    $timeCalc = convDateShow($oldTime, 'd M Y');
  } else if ($timeCalc >= (60 * 60 * 24 * 30 * 12)) {
    //$timeCalc = intval($timeCalc/60/60/24/30/12) . " year ago";
    $timeCalc = convDateShow($oldTime, 'd M Y');
  } else if ($timeCalc >= (60 * 60 * 24 * 30 * 2)) {
    //$timeCalc = intval($timeCalc/60/60/24/30) . " เดือน";
    $timeCalc = convDateShow($oldTime, 'd M Y');
  } else if ($timeCalc >= (60 * 60 * 24 * 30)) {
    //$timeCalc = intval($timeCalc/60/60/24/30) . " เดือน";
    $timeCalc = convDateShow($oldTime, 'd M Y : H:i น.');
  } else if ($timeCalc >= (60 * 60 * 24 * 4.35)) {
    $timeCalc = intval($timeCalc / 60 / 60 / 24 / 4.35) . " สัปดาห์";
  } else if ($timeCalc >= (60 * 60 * 24 * 2)) {
    $timeCalc = intval($timeCalc / 60 / 60 / 24) . " วัน";
  } else if ($timeCalc >= (60 * 60 * 24)) {
    $timeCalc = " เมื่อวาน";
  } else if ($timeCalc >= (60 * 60 * 2)) {
    $timeCalc = intval($timeCalc / 60 / 60) . " ชม.";
  } else if ($timeCalc >= (60 * 60)) {
    $timeCalc = intval($timeCalc / 60 / 60) . " ชม.";
  } else if ($timeCalc >= 60 * 2) {
    $timeCalc = intval($timeCalc / 60) . " นาที";
  } else if ($timeCalc >= 60) {
    $timeCalc = intval($timeCalc / 60) . " นาที";
  } else if ($timeCalc > 0) {
    $timeCalc .= " วินาที";
  }
  return $timeCalc;
}

function getAgo($time)
{
  $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
  $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

  $now = time();

  $difference     = $now - $time;
  $tense         = "ago";

  for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
    $difference /= $lengths[$j];
  }

  $difference = round($difference);

  if ($difference != 1) {
    $periods[$j] .= "s";
  }

  return "$difference $periods[$j] 'ago' ";
}

function content($buffer)
{
  //return iconv('UTF-8', 'TIS-620//IGNORE', $buffer); 
}

function date2db($value = '')
{
  $new_date = "";
  if ($value != "") {
    $old_date = explode("/", $value);
    $new_date = ($old_date[2] - 543) . "-" . $old_date[1] . "-" . $old_date[0];
  } else {
    $new_date = "";
  }

  return $new_date;
}

function conText($text, $format = "")
{
  //$s_text = iconv('TIS-620', 'UTF-8//IGNORE', $s_text); 
  //return iconv("utf-8","utf-8//IGNORE",$s_text); 

  $outText = stripslashes(htmlspecialchars(trim($text), ENT_QUOTES));

  if ($format == "number") {
    $outText = str_replace(',', '', $outText);
  } elseif ($format == "date") {
    $outText = date2db($outText);
  }

  return $outText;
}

function conTextTis620($s_text)
{
  return iconv('UTF-8', 'TIS-620', $s_text);
}

function getLen($s_data, $s_op)
{
  $a_data = explode($s_op, $s_data);
  return count($a_data);
}

function toThaiNumber($s_number)
{
  $numthai = array("๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙", "๐");
  $numarabic = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
  $str = str_replace($numarabic, $numthai, $s_number);
  return $str;
}

## >> Escape and HTMLspecialchar
function esc($text)
{
  $text = str_replace("&#039;", "'", $text);
  $text = str_replace("\\", "\\\\", $text);
  $text = str_replace("'", "\'", $text);
  return $text;
}

function ready($text)
{
  $text = htmlspecialchars_decode($text);
  $text = esc($text);
  $text = htmlspecialchars($text);
  $text = trim($text);
  return $text;
}

//ฟังก์ชันเช็ครูปแบบ Email ที่ถูกต้อง คืนค่ากลับเป็น 1 เท่ากับถูกต้อง 0 เท่ากับผิด
function checkEmail($email)
{
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
    return false;
  endif;

  return true;
}

//ฟังก์ชันเช็ครูปแบบเบอร์โทรศัพท์ที่ถูกต้อง คืนค่ากลับเป็น 1 เท่ากับถูกต้อง 0 เท่ากับผิด
function checkMobile($mobile)
{
  $regExp = "/^0[0-9]{9}$/i";
  return preg_match($regExp, $mobile);
}

//ฟังก์ชันเช็ครูปแบบบัตรประชาชนที่ถูกต้องคืนค่ากลับเป็น true หรือ false
function checkCitizenId($pid)
{
  if (strlen($pid) != 13) :
    return false;
  endif;

  for ($i = 0, $sum = 0; $i < 12; $i++) :
    $sum += (int) ($pid[$i]) * (13 - $i);
  endfor;

  if ((11 - ($sum % 11)) % 10 == (int) ($pid[12])) :
    return true;
  endif;

  return false;
}

//ฟังก์ชันใส่ - เลขบัตรประชาชน
function idCard($data)
{
  $txt1 = substr($data, 0, -12);
  $txt2 = substr($data, 1, -8);
  $txt3 = substr($data, 5, -3);
  $txt4 = substr($data, 10, -1);
  $txt5 = substr($data, 12, 1);
  $txt = $txt1 . "-" . $txt2 . "-" . $txt3 . "-" . $txt4 . "-" . $txt5;
  return $txt;
}

//ฟังก์ชันเช็ควันหยุดรูปแบบที่ 1
function convWeek($week)
{
  $ThDay = array("Sunday", "Monday ", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturay");

  if ($ThDay[$week] == "Sunday" || $ThDay[$week] == "Saturay") {
    $day_off = "true";
  } else {
    $day_off = "false";
  }

  return array(
    "day" => $ThDay[$week],
    "day_off" => $day_off
  );
}

//ฟังก์ชันเช็ควันหยุดรูปแบบที่ 2
function isDayOff($date)
{
  if (date('w', strtotime($date)) == 0 || date('w', strtotime($date)) == 6) {
    $day_off = "true";
  } else {
    $day_off = "false";
  }

  return $day_off;
}

//แปลงวันที่ พ.ศ. ไทย
function convDateThai($data)
{
  if (!empty($data) && $data != "0000-00-00 00:00:00" && $data != "0000-00-00") {
    //วันภาษาไทย
    $ThDay = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์");
    $week = date("w");
    $a = explode(" ", $data);
    $b = explode("-", checkArray($a, 0));
    $c = explode(":", checkArray($a, 1));

    switch (checkArray($b, 1)) {
      case "01":
        $mThai = 'มกราคม';
        $ms = 'ม.ค.';
        break;
      case "02":
        $mThai = 'กุมภาพันธ์';
        $ms = 'ก.พ.';
        break;
      case "03":
        $mThai = 'มีนาคม';
        $ms = 'มี.ค.';
        break;
      case "04":
        $mThai = 'เมษายน';
        $ms = 'เม.ย.';
        break;
      case "05":
        $mThai = 'พฤษภาคม';
        $ms = 'พ.ค.';
        break;
      case "06":
        $mThai = 'มิถุนายน';
        $ms = 'มิ.ย.';
        break;
      case "07":
        $mThai = 'กรกฎาคม';
        $ms = 'ก.ค.';
        break;
      case "08":
        $mThai = 'สิงหาคม';
        $ms = 'ส.ค.';
        break;
      case "09":
        $mThai = 'กันยายน';
        $ms = 'ก.ย.';
        break;
      case "10":
        $mThai = 'ตุลาคม';
        $ms = 'ต.ค.';
        break;
      case "11":
        $mThai = 'พฤศจิกายน';
        $ms = 'พ.ย.';
        break;
      case "12":
        $mThai = 'ธันวาคม';
        $ms = 'ธ.ค.';
        break;
    }

    $array = array(
      "Date" => checkArray($b, 2) . '/' . checkArray($b, 1) . '/' . (checkArray($b, 0) + 543),
      "DateT" => checkArray($b, 2) . '-' . checkArray($b, 1) . '-' . (checkArray($b, 0) + 543),
      "Time" => checkArray($b, 0) . ":" . checkArray($c, 1),
      "DateThai" => checkArray($b, 2) . ' ' . $mThai . ' ' . (checkArray($b, 0) + 543),
      "DateThaiM" => $mThai . ' ' . (checkArray($b, 0) + 543),
      "DateThaiShot" => checkArray($b, 2) . ' ' . $ms . ' ' . (checkArray($b, 0) + 543),
      "DateThaiTime" => checkArray($b, 2) . '-' . checkArray($b, 1) . '-' . (checkArray($b, 0) + 543) . ' ' . checkArray($b, 0) . ":" . checkArray($c, 1),
      "DateH" => $ms . ' ' . substr((checkArray($b, 0) + 543), 2),
      "DateTH" => checkArray($b, 2) . ' ' . $ms . ' ' . substr((checkArray($b, 0) + 543), 2),
      "TimeTH" => " : " . checkArray($b, 0) . "." . checkArray($c, 1) . ' น.',
      "DateDay" => 'วันที่ ' . checkArray($b, 2) . ' ' . $mThai . ' ' . (checkArray($b, 0) + 543),
      "DateDayThai" => 'วัน' . $ThDay[$week] . ' ' . checkArray($b, 2) . ' ' . $mThai . ' ' . (checkArray($b, 0) + 543),
      "DateDayThaiShort" => 'วัน' . $ThDay[$week] . ' ' . checkArray($b, 2) . ' ' . $ms . ' ' . (checkArray($b, 0) + 543),
      "DateChat" => 'วัน' . $ThDay[$week] . 'ที่ ' . checkArray($b, 2) . ' ' . $mThai . ' ' . (checkArray($b, 0) + 543) . ' | ' . checkArray($b, 0) . "." . checkArray($c, 1) . ' น.',
      "D" => checkArray($b, 2),
      "MT" => $mThai,
      "MTs" => $ms,
      "YT" => (checkArray($b, 0) + 543),
    );
    return $array;
  }
}

function convDateAd($data)
{
  if (!empty($data)) {
    $date = explode("/", $data);

    if (!empty($date)) {
      $year = $date[2] - 543;
      return $year . "-" . $date[1] . "-" . $date[0];
    } else {
      return $data;
    }
  }
}

function datediffThai($date1, $date2)
{
  $diff = date_diff(date_create($date1), date_create($date2));
  if ($diff->format("%a") == 7) {
    $date = $diff->format("%a วัน");
  } elseif ($diff->format("%a") >= 30) {
    $date = $diff->format("%m เดือน");
  } elseif ($diff->format("%a") >= 365) {
    $date = $diff->format("%y ปี");
  } else {
    $date = $diff->format("%a วัน");
  }

  return array(
    "data" => $date,
    "count" => $diff->format("%a")
  );
}

//เช็คไฟล์รูป
function getImage($path, $img, $imgShow)
{
  if (!empty($img)) {
    return $path . $img;
  } else {
    return $imgShow;
  }
}

//อัพโหลดไฟล์รูป
function uploadFile($path, $file, $name_img = null)
{
  if (isset($file)) {
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_tmp = $file['tmp_name'];
    $file_type = $file['type'];
    $file_ext = strtolower(end(explode('.', $file['name'])));
    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false) {
      $status = "fileFail";
      $message = "นามสกุลไฟล์ต้องเป็น jpg, jpeg หรือ png";
    }
    //2097152
    if ($file_size > 2097152) {
      $status = "sizeFail";
      $message = "ไฟล์อัพโหลดขนาดเกิน 2 MB";
    }

    $safe_filename = preg_replace(array("/\s+/", "/[^-\.\w]+/"), array("_", ""), trim($file_name));
    $type_file = strrchr($safe_filename, '.');
    $newfile = $name_img . date("YmdHis") . $type_file;

    if ($status != "fileFail" && $status != "sizeFail") {
      if (move_uploaded_file($file_tmp, $path . $newfile)) {
        $status = "success";
        $message = "อัพโหลดไฟล์สำเร็จ!";
        $filename = $newfile;
      } else {
        $status = "error";
        $message = "ไม่สามารถอัพโหลดไฟล์ได้!";
        $filename = null;
      }
    }

    return array(
      "status" => $status,
      "message" => $message,
      "filename" => $filename,
    );
  }
}

//อัพโหลดไฟล์รูป sso
function uploadFileSSO($path, $file)
{
  $host = "172.16.1.184";
  $username = "bizpotential";
  $password = "B!zpotentialFTP4321!!";

  $file_name = $file['name'];
  $file_size = $file['size'];
  $file_tmp = $file['tmp_name'];

  $extension = pathinfo($file_name);
  $connect = ftp_connect($host) or die('no service');
  $loginf = ftp_login($connect, $username, $password);

  $newFileName = date('YmdHis') . '.' . $extension['extension'];
  ftp_put($connect, $newFileName, $file_tmp, FTP_BINARY, 0);

  return ftp_pwd($connect) . "/" . $path . $newFileName;

  ftp_close($connect);
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

  return rtrim(strtr(base64_encode(base64_encode($result)), '+/', '-_'), '=');
}

//ฟังก์ชันถอดรหัสข้อมูล 2
function decode($string, $key)
{
  $result = '';
  $string = base64_decode($string);
  $string = base64_decode(str_pad(strtr($string, '-_', '+/'), strlen($string) % 4, '=', STR_PAD_RIGHT));

  for ($i = 0; $i < strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key)) - 1, 1);
    $char = chr(ord($char) - ord($keychar));
    $result .= $char;
  }

  return $result;
}

//เปิดไฟล์ Notepad
function openFile($file)
{
  if (file_exists($file)) {
    $myfile = fopen($file, "r") or die("Unable to open file!");
    $openFile = fread($myfile, filesize($file));
    fclose($myfile);
    return $openFile;
  } else {
    return null;
  }
}

//ฟังก์แสดงค่าจำนวนวันของแต่ละเดือน
function monthDayAmount($month, $year)
{
  return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

//ฟังก์ชันเช็ค Url Template เว็บไซต์
function getUrlTemplate($base_url)
{
  $template = sitelayout::getTemplate();
  if ($template == "Template 1") {
    $_SESSION["template_name"] = "index-t1.php";
    $template_name = "index-t1.php";
  } elseif ($template == "Template 2") {
    $_SESSION["template_name"] = "index-t2.php";
    $template_name = "index-t2.php";
  } else {
    $_SESSION["template_name"] = "index.php";
    $template_name = "index.php";
  }

  if (strpos($base_url, "index-t1.php") !== false) {
    unset($_SESSION["tpage2"]);
    unset($_SESSION["tpage3"]);
    $_SESSION["tpage1"] = "index-t1.php";
  } elseif (strpos($base_url, "index-t2.php") !== false) {
    unset($_SESSION["tpage1"]);
    unset($_SESSION["tpage3"]);
    $_SESSION["tpage2"] = "index-t2.php";
  } elseif (strpos($base_url, "index.php") !== false || strpos($base_url, "home.php") !== false) {
    unset($_SESSION["tpage1"]);
    unset($_SESSION["tpage2"]);
    $_SESSION["tpage3"] = "index.php";
  } else {
    $_SESSION["tpage3"] = "index.php";
  }

  $tpage = $_SESSION["tpage1"] . " " . $_SESSION["tpage2"] . " " . $_SESSION["tpage3"];

  if ($_SESSION["template_name"] != $tpage) {
    return $tpage;
  } else {
    return $template_name;
  }
}

//ฟังก์ชันเช็คช่วงเวลา
function checkPeriodTime($text = null)
{
  $time = date("H");
  $timezone = date("e");

  if ($time < "12") {
    $period = 'เช้า!';
  } elseif ($time >= "12" && $time < "17") {
    $period = 'บ่าย!';
  } elseif ($time >= "17" && $time < "19") {
    $period = 'เย็น!';
  } elseif ($time >= "19") {
    $period = 'กลางคืน!';
  }

  return $text . $period;
}

//ฟังก์ชันไฮไลท์คำ
function highlightWords($text, $word)
{
  return preg_replace('#' . preg_quote($word) . '#i', '<span class="search-tag">\\0</span>', $text);
}

//ฟังก์ชันตรวจสอบคำหยาบ
function cutWords($array, $text)
{
  $replace = "***";
  for ($i = 0; $i < sizeof($array); $i++) {
    $arr = $array[$i];
    $text = preg_replace("/$arr/", $replace, $text);
  }

  return $text;
}

//ฟังก์ชันแสดงข้อมูล XML
function getXML($url)
{
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_TIMEOUT, 10);

  $content = curl_exec($curl);

  if ($content == false || $content == "") {
    return curl_error($curl) . " --- " . curl_errno($curl);
  }

  curl_close($curl);

  $parsed_xml = simplexml_load_string($content);
  $rss_count = count($parsed_xml->channel->item);

  return array(
    "parsed_xml" => $parsed_xml,
    "rss_count" => $rss_count
  );
}

function xmlCheckValue($url)
{
  $dom = new DomDocument;
  $dom->loadXml($url);
  $xph = new DOMXPath($dom);
  $xph->registerNamespace('rdf', "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
  $attribute = "";
  foreach ($xph->query('//@rdf:about') as $attribute) {
    $attribute .= $attribute->value; // PHP_EOL;
  }
  return $attribute;
}

//ฟังก์ชันถอดรหัส API DEPIS
function ssl_decrypt_api($string, $skey)
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
function encrypt($string)
{
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'WS-SERVICE-KEY';
  $secret_iv = 'WS-SERVICE-VALUE';
  $key = hash('sha256', $secret_key);
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
  return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
}

//ฟังก์ชันถอดรหัสข้อมูล
function decrypt($string)
{
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'WS-SERVICE-KEY';
  $secret_iv = 'WS-SERVICE-VALUE';
  $key = hash('sha256', $secret_key);
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
  return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
}

//ฟังก์ชันเข้ารหัส SSO
function hashPass($password)
{
  if ($password) {
    return hash('sha1', trim($password));
  }
}

//ฟังก์ชันเข้ารหัส EWT
function encryptPassword($s_password)
{
  if ($s_password) {
    $s_source = md5($s_password);
    $s_password = 'บิซโพเทนเชียล#' . $s_source;
    $s_password = hash('SHA512', $s_password);
    return $s_password;
  }
}

//ฟังก์ชันแบ่งข้อมูล Array
function getSeparate($array, $um)
{
  return array_chunk($array, $um);
}

//ฟังก์เช็คสิทธิ์ผู้ใช้
function chk_authent($mid, $muser, $mdiv, $mpos, $mtype)
{
  ## >> Check user's permission
  ## U is for user type permission
  ## A is for group type permission

  db::setDB(E_DB_USER);
  $s_sql2 = "SELECT DISTINCT(permission.UID) AS UID FROM permission
  INNER JOIN user_info ON user_info.UID = permission.UID
  WHERE (( p_type = 'U' AND pu_id = '$mid') 
  OR (p_type = 'A' AND pu_id = '$mtype' ) 
  OR (p_type = 'D' AND pu_id = '$mdiv' )) 
  AND s_id = '0' AND EWT_Status = 'Y' ";
  $a_rows2 = db::getRowCount($s_sql2);

  if ($a_rows2 == 0) {   ## Case: No permission
    $EWT_PORTAL_USER = "N";
  } else if ($a_rows2 == 1) { ## Case: Has one site permission
    $a_data2 = db::getFetch($s_sql2);
    $s_sql3 = "SELECT * FROM user_info WHERE UID = '{$a_data2['UID']}' AND EWT_Status = 'Y' ";
    $s_result3 = db::getFetch($s_sql3);
    $a_rows3 = db::getRowCount($s_sql3);
    if ($a_rows3 > 0) {
      $a_data3 = $s_result3;
      $_SESSION['EWT_SUID'] = $a_data3['UID'];
      $_SESSION['EWT_SUSER'] = 'prd_intra_web'; //$a_data3['EWT_User']; 
      $_SESSION['EWT_SDB'] = $a_data3['db_db'];
      $_SESSION['EWT_SMID'] = $mid;
      $_SESSION['EWT_SMUSER'] = $muser;
      $_SESSION['EWT_SMDIV']  =   $mdiv;

      $s_sql_chk = " SELECT COUNT(permission.p_id) AS UID FROM permission
      WHERE (( p_type = 'U' AND pu_id = '$mid') 
      OR (p_type = 'A' AND pu_id = '$mtype' ) 
      OR (p_type = 'D' AND pu_id = '$mdiv' )) 
      AND permission.s_type = 'suser'
      AND permission.UID = '{$a_data2['UID']}' ";
      $CH = db::getFetch($s_sql_chk);
      if ($CH['UID'] > 0) {
        $_SESSION['EWT_SMTYPE'] = "Y";
      } else {
        $_SESSION['EWT_SMTYPE'] = "N";
      }
      $EWT_PORTAL_USER = "Y";
    } else {
      $EWT_PORTAL_USER = "N";
    }
  }

  return $EWT_PORTAL_USER;
}

//ฟังก์ชันเช็ครหัสผ่าน
function checkStrenght($password)
{
  $upperCase = "/[A-Z]+/";
  $lowerCase = "/[a-z]+/";
  $numbers   = "/[0-9]+/";
  //$specialchars   = "/\W+/";
  $length = strlen($password);
  $minLength = 8;
  $capitalletters = 0;
  $loweletters = 0;
  $number = 0;
  $special = 0;
  $count = 0;

  if ($length >= 0) {
    //รหัสผ่านต้องมีอักษรตัวใหญ่
    if ($length >= $minLength) {
      $count = 1;
    }

    if (preg_match($upperCase, $password)) {
      $capitalletters = 1;
    }

    //รหัสผ่านต้องมีอักษรตัวเล็ก
    if (preg_match($lowerCase, $password)) {
      $loweletters = 1;
    }

    //รหัสผ่านต้องมีตัวเลข
    if (preg_match($numbers, $password)) {
      $number = 1;
    }

    // //รหัสผ่านต้องมีตัวอักษรพิเศษ
    // if (preg_match($specialchars, $password))
    // {
    //     $special = 1;
    // }
  }

  return $capitalletters + $loweletters + $number + $special + $count;
}

//ฟังก์ชันเก็บข้อมูลผู้ใช้งาน
function write_log($site = null)
{
  $log_data = array();
  $date = date("Y-m-d");
  $time = date("H:i:s");

  if ($_SERVER["REMOTE_ADDR"]) {
    $IPn = $_SERVER["REMOTE_ADDR"];
  } else {
    $IPn = $_SERVER["REMOTE_HOST"];
  }

  $log_data['log_user_uid'] = $_SESSION['EWT_MID'];
  $log_data['log_user_username'] = $_SESSION['EWT_USERNAME'];
  $log_data['log_user_ip'] = $IPn;
  $log_data['log_user_date'] = $date;
  $log_data['log_user_time'] = $time;
  $log_data['log_user_site'] = $site;
  // $_sql = "SELECT log_user_id FROM " . E_DB_USER . ".log_user_view WHERE log_user_uid = '{$_SESSION['EWT_MID']}' AND log_user_date = '{$date}'";
  // $a_row  = db::getRowCount($_sql);

  //if ($a_row == 0) {
  if (db::insert('' . E_DB_USER . '.log_user_view', $log_data)) {
    return true;
  } else {
    return false;
  }
  unset($log_data);
  //} else {
  //return false;
  //}
}

//ฟังก์แบ่งหน้าข้อมูล รูปแบบที่ 1
function pagination($page_name, $page_data, $pages, $per_page, $total_page)
{
  $page = isset($pages) ? $pages : 1;
  $prev = $page - 1;
  $next = $page + 1;

  $txt = '';
  $txt .= '<div class="text-center">';
  $txt .= '<div class="pagination p6">';
  $txt .= '<ul>';

  if ($page >= 2) {
    $txt .= '<a href="' . $page_name . '?page=' . $prev . '&' . (!empty($page_data) ? "" . $page_data : null) . '">';
    $txt .= '<i class="fa fa-thin fa-chevron-left"></i>';
    $txt .= '</a>';
  }

  for ($i = 1; $i <= $total_page; $i++) {
    if ($i <= 5 && $total_page > 1) {
      $txt .= '<a class="' . ($i == $page ? "is-active" : "") . '" href="' . $page_name . '?page=' . $i . '&' . (!empty($page_data) ? "" . $page_data : null) . '">';
      $txt .= '<li>' . $i . '</li>';
      $txt .= '</a>';
    }
  }

  if ($page > 5 && $page != $total_page) {
    $txt .= '<a class="' . ($page == $total_page ? "" : "is-active") . '" href="' . $page_name . '?page=' . $page . '&' . (!empty($page_data) ? "" . $page_data : null) . '">';
    $txt .= '<li>' . $page . '</li>';
    $txt .= '</a>';
  }

  if ($total_page > 5) {
    $txt .= '<a href="#"><li>...</li></a>';

    $txt .= '<a class="' . ($page == $total_page ? "is-active" : "") . '" href="' . $page_name . '?page=' . $total_page . '&' . (!empty($page_data) ? "" . $page_data : null) . '">';
    $txt .= '<li>' . $total_page . '</li>';
    $txt .= '</a>';
  }

  if ($page < $total_page) {
    $txt .= '<a href="' . $page_name . '?page=' . $next . '&' . (!empty($page_data) ? "" . $page_data : null) . '">';
    $txt .= '<li><i class="fa fa-thin fa-chevron-right"></i></li>';
    $txt .= '</a>';
  }

  $txt .= '</ul>';
  $txt .= '</div>';
  $txt .= '</div>';

  return $txt;
}

//ฟังก์แบ่งหน้าข้อมูล รูปแบบที่ 2
function pagination_ewt($page_name, $page_data, $page = 1, $per_page, $total)
{
  $adjacents = "2";
  // $prevlabel = "&lsaquo; Prev";
  // $nextlabel = "Next &rsaquo;";
  // $lastlabel = "Last &rsaquo;&rsaquo;";
  // $firstlabel = "&lsaquo;&lsaquo; First";
  $prevlabel = "&lsaquo; ก่อนหน้า";
  $nextlabel = "หน้าถัดไป &rsaquo;";
  $lastlabel = "หน้าสุดท้าย &rsaquo;&rsaquo;";
  $firstlabel = "&lsaquo;&lsaquo; หน้าแรก";

  $page = ($page == 0 ? 1 : $page);
  $start = ($page - 1) * $per_page;

  $prev = $page - 1;
  $next = $page + 1;

  $lastpage = ceil($total / $per_page);

  $lpm1 = $lastpage - 1;

  if ($lastpage >= $page) {
    $pagination = "";
    $pagination .= "<div class='text-center'>";
    $pagination .= "<div class='pagination p6'>";
    if ($lastpage > 1) {
      $pagination .= "<ul class='pagination'>";
      if ($page > 1) {
        $pagination .= "<a href='{$page_name}?page=1&{$page_data}'><li class='page-item active'>{$firstlabel}</li></a>";
        $pagination .= "<a href='{$page_name}?page={$prev}&{$page_data}'><li>{$prevlabel}</li></a>";
      }

      if ($lastpage < 7 + ($adjacents * 2)) {
        for ($counter = 1; $counter <= $lastpage; $counter++) {
          if ($counter == $page) {
            $pagination .= "<a class='current'><li>{$counter}</li></a>";
          } else {
            $pagination .= "<a href='{$page_name}?page={$counter}&{$page_data}'><li>{$counter}</li></a>";
          }
        }
      } elseif ($lastpage > 5 + ($adjacents * 2)) {
        if ($page < 1 + ($adjacents * 2)) {
          for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
            if ($counter == $page) {
              $pagination .= "<a class='current'><li>{$counter}</li></a>";
            } else {
              $pagination .= "<a href='{$page_name}?page={$counter}&{$page_data}'><li>{$counter}</li></a>";
            }
          }
          $pagination .= "<a><li class='disabled'>...</li></a>";
          $pagination .= "<a href='{$page_name}?page={$lpm1}&{$page_data}'><li>{$lpm1}</li></a>";
          $pagination .= "<a href='{$page_name}?page={$lastpage}&{$page_data}'><li>{$lastpage}</li></a>";
        } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
          $pagination .= "<a href='{$page_name}?page=1&{$page_data}'><li>1</li></a>";
          $pagination .= "<a href='{$page_name}?page=2&{$page_data}'><li>2</li></a>";
          $pagination .= "<a><li class='disabled'>...</li></a>";
          for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
            if ($counter == $page) {
              $pagination .= "<a class='current'><li>{$counter}</li></a>";
            } else {
              $pagination .= "<a href='{$page_name}?page={$counter}&{$page_data}'><li>{$counter}</li></a>";
            }
          }
          $pagination .= "<a><li class='disabled'>...</li></a>";
          $pagination .= "<a href='{$page_name}?page={$lpm1}&{$page_data}'><li>{$lpm1}</li></a>";
          $pagination .= "<a href='{$page_name}?page={$lastpage}&{$page_data}'><li>{$lastpage}</li></a>";
        } else {
          $pagination .= "<a href='{$page_name}?page=1&{$page_data}'><li>1</li></a>";
          $pagination .= "<a href='{$page_name}?page=2&{$page_data}'><li>2</li></a>";
          $pagination .= "<a><li class='disabled'>...</li></a>";
          for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
            if ($counter == $page) {
              $pagination .= "<a class='current'><li>{$counter}</li></a>";
            } else {
              $pagination .= "<a href='{$page_name}?page={$counter}&{$page_data}'><li>{$counter}</li></a>";
            }
          }
        }
      }

      if ($page < $counter - 1) {
        $pagination .= "<a href='{$page_name}?page={$next}&{$page_data}'><li>{$nextlabel}</li></a>";
        $pagination .= "<a href='{$page_name}?page=$lastpage&{$page_data}'><li>{$lastlabel}</li></a>";
      }

      $pagination .= "</ul>";
    }
    $pagination .= "</div>";
    $pagination .= "</div>";
  }
  return $pagination;
}

//ฟังก์แบ่งหน้าข้อมูล รูปแบบที่ 2
function pagination_ewt2($page_name, $page_data, $page = 1, $per_page, $total)
{
  $adjacents = "2";
  // $prevlabel = "&lsaquo; Prev";
  // $nextlabel = "Next &rsaquo;";
  // $lastlabel = "Last &rsaquo;&rsaquo;";
  // $firstlabel = "&lsaquo;&lsaquo; First";
  $prevlabel = "Prev";
  $nextlabel = "Next";
  $lastlabel = "&rsaquo;&rsaquo;";
  $firstlabel = "&lsaquo;&lsaquo;";

  $page = ($page == 0 ? 1 : $page);
  $start = ($page - 1) * $per_page;

  $prev = $page - 1;
  $next = $page + 1;

  $lastpage = ceil($total / $per_page);

  $lpm1 = $lastpage - 1;

  if ($lastpage >= $page) {
    $pagination = "";
    $pagination .= "<div class='d-flex justify-content-center mb-2'>";
    $pagination .= "<nav aria-label=''>";
    if ($lastpage > 1) {
      $pagination .= "<ul class='pagination'>";
      if ($page > 1) {
        $pagination .= "<li class='page-item active'><a class='page-link' href='{$page_name}?page=1&{$page_data}'>{$firstlabel}</a></li>";
        $pagination .= "<li class='page-item'><a class='page-link'  href='{$page_name}?page={$prev}&{$page_data}'>{$prevlabel}</a></li>";
      }

      if ($lastpage < 7 + ($adjacents * 2)) {
        for ($counter = 1; $counter <= $lastpage; $counter++) {
          if ($counter == $page) {
            $pagination .= "<li class='page-item' aria-current='page'><a class='page-link'>{$counter}</a></li>";
          } else {
            $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page={$counter}&{$page_data}'>{$counter}</a></li>";
          }
        }
      } elseif ($lastpage > 5 + ($adjacents * 2)) {
        if ($page < 1 + ($adjacents * 2)) {
          for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
            if ($counter == $page) {
              $pagination .= "<li class='page-item' aria-current='page'><a class='page-link'>{$counter}</a></li>";
            } else {
              $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page={$counter}&{$page_data}'>{$counter}</a></li>";
            }
          }
          $pagination .= "<li class='page-item disabled'><a class='page-link'>...</a></li>";
          $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page={$lpm1}&{$page_data}'>{$lpm1}</a></li>";
          $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page={$lastpage}&{$page_data}'>{$lastpage}</a></li>";
        } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
          $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page=1&{$page_data}'>1</a></li>";
          $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page=2&{$page_data}'>2</a></li>";
          $pagination .= "<li class='page-item disabled'><a class='page-link'>...</a></li>";
          for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
            if ($counter == $page) {
              $pagination .= "<li class='page-item' aria-current='page'><a class='page-link'>{$counter}</a></li>";
            } else {
              $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page={$counter}&{$page_data}'>{$counter}</a></li>";
            }
          }
          $pagination .= "<li class='page-item disabled'><a class='page-link'>...</a></li>";
          $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page={$lpm1}&{$page_data}'>{$lpm1}</a></li>";
          $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page={$lastpage}&{$page_data}'>{$lastpage}</a></li>";
        } else {
          $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page=1&{$page_data}'>1</a></li>";
          $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page=2&{$page_data}'>2</a></li>";
          $pagination .= "<li class='page-item disabled'><a class='page-link'>...</a></li>";
          for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
            if ($counter == $page) {
              $pagination .= "<li class='page-item' aria-current='page'><a class='page-link'>{$counter}</a></li>";
            } else {
              $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page={$counter}&{$page_data}'>{$counter}</a></li>";
            }
          }
        }
      }

      if ($page < $counter - 1) {
        $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page={$next}&{$page_data}'>{$nextlabel}</a></li>";
        $pagination .= "<li class='page-item'><a class='page-link' href='{$page_name}?page=$lastpage&{$page_data}'>{$lastlabel}</a></li>";
      }

      $pagination .= "</ul>";
    }
    $pagination .= "</nav>";
    $pagination .= "</div>";
  }
  return $pagination;
}

//ฟังก์ชันเช็คค่าว่างตัวแปร Array
function checkArray($value, $val)
{
  if (!empty($value[$val])) {
    return $value[$val];
  }
}

//ฟังก์ชันเช็คค่าว่างตัวแปร ไม่มี Object
function CheckVal($val)
{
  if (!empty($val)) {
    return $val;
  }
}

//ฟังก์ชันเช็คค่าว่างตัวแปร Object
function CheckValue($value, $val)
{
  if (!empty($value)) {
    return $value->$val;
  }
}

//ฟังก์ชันเช็คค่าว่างตัวแปร 2 Object
function CheckWithValue($value, $val, $v)
{
  if (!empty($value->$val)) {
    return $value->$val->$v;
  }
}

//ฟังก์ชันเช็คชนิดตัวแปรเช็คค่าว่าง ก่อน explode
function ArrayExplode($value, $c)
{
  if (empty($value) or strstr($value, $c) == "false") {
    return [$value];
  } else {
    return explode($c, $value);
  }
}

//ฟังก์ชันเช็คชนิดตัวแปรเช็คค่าว่าง โดยใช้ข้อมูล Array ก่อน sum ผลรวมของ Array
function ArraySum($array)
{
  if (empty($array) or strstr($array, ',') == "false") {
    $data = [$array];
  } else {
    $data_array = ArrayExplode($array, ",");
    foreach ($data_array as $val) {
      $Darray[] = $val;
    }
    $data = array_sum($Darray);
  }

  return $data;
}

function tagBg($key)
{
  switch ($key) {
    case 0:
      $tag_bg = "know";
      break;
    case 1:
      $tag_bg = "PR";
      break;
    case 2:
      $tag_bg = "event";
      break;
    default:
      $tag_bg = "know";
      break;
  }
  return $tag_bg;
}

function connectLdap($ldapconfig, $dn, $search = null)
{
  $array_list = array();
  #parameter array ldapconfig => host and port *
  $ldapconn = ldap_connect($ldapconfig['host'], $ldapconfig['port']);
  ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

  if ($ldapconn) {

    $ldapbind = ldap_bind($ldapconn, "{$dn}", LDAP_PASS);
    // $array_list["message"] = "Conect Ldap Success";
    // $array_list["data"] = null;
    // $array_list["status"] = "success";

    if ($ldapbind) {

      if ($search) {
        #example parameter string "employeenumber=1234567890123"
        $ldap_search = ldap_search($ldapconn, $ldapconfig['searchuser'], "({$search})");
      } else {
        $ldap_search = ldap_search($ldapconn, $ldapconfig['searchuser'], "(cn=*)");
      }

      $data = ldap_get_entries($ldapconn, $ldap_search);

      if ($ldap_search) {
        $array_list["message"] = "Search Ldap Success";
        $array_list["data"] = $data;
        $array_list["status"] = "success";
      } else {
        $array_list["message"] = "Not Search Ldap Failed!";
        $array_list["data"] = null;
        $array_list["status"] = "error";
      }

      // $array_list["message"] = "Conect Bind Success";
      // $array_list["data"] = null;
      // $array_list["status"] = "success";
    } else {
      $array_list["message"] = "Not Ldap Bind Failed!";
      $array_list["data"] = null;
      $array_list["status"] = "error";
    }
  } else {
    $array_list["message"] = "Not Conect Ldap Failed!";
    $array_list["data"] = null;
    $array_list["status"] = "error";
  }

  ldap_close($ldapconn);
  return $array_list;
}
