<?php
//Llamada al modelo del especies
require_once("modelo/versionapp.php");
$versionapp=new versionapp(); 
$versionActual=18;
//Validacion para uso de algunas funciones especificas
if($opcion=='getversion'){
    $infoData=$versionapp->getVersion($versionActual);
    if(count($infoData)<=0){
        $data=$versionapp->reg_version("Version nueva ".$versionActual,$versionActual);
    }
    $ValorRetorno=array("version"=>$versionapp->getVersion($versionActual));
    echo json_encode($ValorRetorno);
}else if (!isset($valorUso) && $opcion=='reg'){
    //Pagina de ingreso para el registro de especies
}

?>