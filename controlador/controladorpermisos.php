<?php
//Llamada al modelo del permisos
require_once("modelo/permisos.php");
$permisos=new permisos_modelo(); 

//Validacion para uso de algunas funciones especificas
if($opcion=='getpermisos'){
    $ValorRetorno=array("permisos"=>$permisos->get_permisos());
    echo json_encode($ValorRetorno);
}else if (!isset($valorUso) && $opcion=='reg'){
    //Pagina de ingreso para el registro de permisos
}

?>