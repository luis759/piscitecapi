<?php
//Llamada al modelo del usuario
require_once("modelo/usuario.php");
$usuario=new usuario_modelo(); 

//Validacion para uso de algunas funciones especificas
if($opcion=='getusuarios'){
    $ValorRetorno=array("usuarios"=>$usuario->get_Usuarios());
    echo json_encode($ValorRetorno);
}else if (!isset($valorUso) && $opcion=='reg'){
    //Pagina de ingreso para el registro de usuarios
}

?>