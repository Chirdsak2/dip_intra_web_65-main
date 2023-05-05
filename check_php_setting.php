<?php
echo 'error_reporting = ' . decbin(ini_get('error_reporting')) . "<br/>";
echo 'display_errors = ' . ini_get('display_errors') . "<br/>";
echo 'register_globals = ' . ini_get('register_globals') . "<br/>";
echo 'post_max_size = ' . ini_get('post_max_size') . "<br/>";
echo 'max_execution_time = ' . ini_get('max_execution_time') . "<br/>";
echo 'upload_max_filesize = ' . ini_get('upload_max_filesize') . "<br/>";
echo 'memory_limit = ' . ini_get('memory_limit') . "<br/>";
echo 'short_open_tag = ' . ini_get('short_open_tag') . "<br/>";
echo 'session.auto_start = ' . ini_get('session.auto_start') . "<br/>";
echo 'date.timezone = ' . ini_get('date.timezone') . "<br/>";
echo 'default_charset = ' . ini_get('default_charset') . "<br/>";
phpinfo();
?>



