<?php
$app->get('/home',function($reguest, $response){
    echo"hello .API.";
});
$app->get('/home/{say}',function($reguest, $response,$string){
    echo"say = ".$string['say'];
});
$app->group('/home1',function(){
    $this->get('/',
        function($reguest, $response){
            echo'aaaaa';
        });
    $this->get('/index', 'App\Controller\Home:index');
    $this->get('/showproduct','App\Controller\Home:showProduct');
    $this->get('/showproduct/{id}','App\Controller\Home:showProid');

    $this->post('/showproduct','App\Controller\Home:findProduct');
});
?>