<?php
require_once 'config.php';
require_once 'models/Database.php';

$controller = 'Productos';

// Todo esta lógica hara el papel de un FrontController
if(!isset($_REQUEST['c']))
{
    require_once "controllers/".$controller."Controller.php";
    $controller = ucwords($controller) . 'Controller';
    $controller = new $controller;
    $controller->Index();    
}
else
{
    // Obtenemos el controlador que queremos cargar
    $controller = ucwords($_REQUEST['c']);
    $accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'Index';
    
    // Instanciamos el controlador
    require_once "controllers/".$controller."Controller.php";
    $controller = $controller . 'Controller';
    $controller = new $controller;
    
    // Llama la accion
    call_user_func( array( $controller, $accion ) );
}