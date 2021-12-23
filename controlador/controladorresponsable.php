<?php
//Llamada al modelo del responsable
require_once("modelo/responsable.php");
$responsable=new responsable_modelo(); 

//Validacion para uso de algunas funciones especificas
if($opcion=='getresponsable'){
    $ValorRetorno=array("responsables"=>$responsable->get_responsable());
    echo json_encode($ValorRetorno);
}else if (!isset($valorUso) && $opcion=='reg'){
    $IDEMP=$_POST['IDEMP'];
    $CEDULA=$_POST['CEDULA'];
    $NOMBRES=$_POST['NOMBRES'];
    $USUARIO=$_POST['USUARIO'];
    $ValorRetorno=array("responsables"=>$responsable->reg_responsable($IDEMP,$CEDULA,$NOMBRES,$USUARIO));
    echo json_encode($ValorRetorno);
}

?>