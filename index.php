<?php
//require_once("db/db.php");
include 'src/Router/Route.php';
include 'src/Router/Router.php';
include 'src/Router/RouteNotFoundException.php';
//Inicializcion de Ruteo de paginas
$router = new Router\Router();
$tokenKey="ef17dc2abf938d93c1638641f46f7a1cbf9e8721";
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
$router->add('/espacioscod/([0-9]*)/([0-9]*)', function ($IDEMP,$IDGRA) {
    $opcion='getespacioscod';
    require_once("controlador/controlgranjas.php");
});
$router->add('/espacioscod', function () {
    $opcion='getespaciosall';
    require_once("controlador/controlgranjas.php");
});
$router->add('/espacioscodlote', function () {
    $opcion='getespaciosalllote';
    require_once("controlador/controlgranjas.php");
});
$router->add('/espaciocodigobyempresa', function () {
    $opcion='getespaciobycodigo';
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
$router->add('/fisicoquimicos/parametros', function () {
    $opcion='getfisicoquimicosparam';
    require_once("controlador/controladorfisicoquim.php");
});
$router->add('/api/fisicoquimicos/registroWebhook', function () {
    $opcion='registroWebhook';
    $isAPi=true;
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
$router->add('/materias/get', function () {
    $opcion='getmaterias';
    require_once("controlador/controladorconsumos.php");
});

$router->add('/consumos', function () {
    $opcion='reg';
    require_once("controlador/controladorconsumos.php");
});
$router->add('/consumos/consultadieta', function () {
    $opcion='consultadieta';
    require_once("controlador/controladorconsumos.php");
});
$router->add('/versionAPP', function () {
    $opcion='getversion';
    require_once("controlador/controladorversionapp.php");
});
$router->add('/mortalidad/getcausas', function () {
    $opcion='getcausas';
    require_once("controlador/controladormortalidad.php");
});

$router->add('/mortalidad', function () {
    $opcion='reg';
    require_once("controlador/controladormortalidad.php");
});
//Ruta de LLamada para las paginas que no se encuentran
$router->add('/.*', function () {
  echo "NO SE PUEDE INGRESAR";
});

$router->route();

?>