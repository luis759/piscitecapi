<?php
require_once("db/db.php");
include 'src/Router/Route.php';
include 'src/Router/Router.php';
include 'src/Router/RouteNotFoundException.php';
//Inicializcion de Ruteo de paginas
$router = new Router\Router();
$router->add('/usuarios', function () {
    $opcion='getusuarios';
    require_once("controlador/controlusuario.php");
});
$router->add('/permisos', function () {
    $opcion='getpermisos';
    require_once("controlador/controladorpermisos.php");
});
$router->add('/especies', function () {
    $opcion='getespecies';
    require_once("controlador/controladorespecies.php");
});
$router->add('/empresas', function () {
    $opcion='getempresas';
    require_once("controlador/controlempresas.php");
});
$router->add('/reportes', function () {
    $opcion='getreportes';
    require_once("controlador/controladorreportes.php");
});
$router->add('/espacios/([0-9]*)/([0-9]*)', function ($IDEMP,$IDGRA) {
    $opcion='getespacios';
    require_once("controlador/controlgranjas.php");
});
$router->add('/responsable', function () {
    $opcion='getresponsable';
    require_once("controlador/controladorresponsable.php");
});
$router->add('/responsable_reg', function () {
    $opcion='reg';
    require_once("controlador/controladorresponsable.php");
});
$router->add('/registro/vacuna', function () {
    $opcion='reg';
    require_once("controlador/controladorvacuna.php");
});
$router->add('/registro/fisicoquimicos', function () {
    $opcion='reg';
    require_once("controlador/controladorfisicoquim.php");
});
$router->add('/reportes/registro', function () {
    $opcion='reg';
    require_once("controlador/controladorreportes.php");
});
$router->add('/granjas', function () {
    $opcion='getgranjas';
    require_once("controlador/controlgranjas.php");
});
//Ruta de LLamada para las paginas que no se encuentran
$router->add('/.*', function () {
  echo "NO SE PUEDE INGRESAR";
});

$router->route();

?>