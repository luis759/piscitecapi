<?php
//Llamada al modelo del especies
require_once("modelo/especies.php");
$especies=new especies_modelo(); 

//Validacion para uso de algunas funciones especificas
if($opcion=='getespecies'){
    $ValorRetorno=array("especies"=>$especies->get_especies());
    echo json_encode($ValorRetorno);
}else if (!isset($valorUso) && $opcion=='reg'){
    //Pagina de ingreso para el registro de especies
}

?>