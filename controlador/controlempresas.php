<?php
//Llamada al modelo del Empresas
require_once("modelo/empresas.php");
$empresas=new empresas_modelo(); 

//Validacion para uso de algunas funciones especificas
if($opcion=='getempresas'){
    $ValorRetorno=array("empresas"=>$empresas->get_Empresas());
    echo json_encode($ValorRetorno);
}else if (!isset($valorUso) && $opcion=='reg'){
    //Pagina de ingreso para el registro de Empresas
}

?>