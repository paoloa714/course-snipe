<?php

require_once(__DIR__ . '/vendor/autoload.php');
if (isset($_REQUEST['data'])){
    $Request = json_decode($_REQUEST['data']);
}else{
    $Request = NULL;
}



$controllerName = isset($Request->controller) ? $Request->controller : 'test';
$controllerClassName = $controllerName . 'Controller';

$controller = new $controllerClassName();


$action = isset($Request->action) ? $Request->action : 'run';

try {
    if (isset($Request->params)) {
        $returnObj->data = $controller->$action($Request->params);
    }
    else
        $returnObj->data = $controller->$action();
    $returnObj->status = true;
} catch (Exception $exc) {
    $returnObj->data = $exc;
    $returnObj->status = false;
}
echo json_encode($returnObj);
