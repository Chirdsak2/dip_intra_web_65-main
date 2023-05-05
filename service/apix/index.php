<?php
require_once 'vendor/autoload.php';
require_once 'config/config.php';

$app = new Slim\App(['settings' => $config]);
$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer('./views');

$container['db'] = function ($c){
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'],$db['user'],$db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("SET NAMES UTF8");
    return $pdo;
};

require_once 'router.php';
$app->run();
?>