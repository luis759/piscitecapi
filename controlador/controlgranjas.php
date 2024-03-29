<?php
//Llamada al modelo del GRANJAS
require_once("modelo/granjas.php");
$granjas=new granjas_modelo(); 

//Validacion para uso de algunas funciones especificas
if($opcion=='getgranjas'){
    $ValorRetorno=array("granjas"=>$granjas->get_granjas());
    echo json_encode($ValorRetorno);
}else if($opcion=='getespacios'){
    if(empty($IDEMP) || empty($IDGRA)){
        echo "Error";
    }else{
        $ValorRetorno=array("espacios"=>$granjas->get_espacios($IDEMP,$IDGRA));
        echo json_encode($ValorRetorno);
    }
    
}else if($opcion=='getespacioscod'){
    if(empty($IDEMP) || empty($IDGRA)){
        echo "Error";
    }else{
        $ValorRetorno=array("espacios"=>$granjas->get_espaciosWithCod($IDEMP,$IDGRA));
        echo json_encode($ValorRetorno);
    }
    
}else if($opcion=='getespaciosall'){
        $ValorRetorno=array("espacios"=>$granjas->get_espaciosWithCodAll());
        echo json_encode($ValorRetorno);    
}else if($opcion=='getespaciosalllote'){
    $ValorRetorno=array("espacios"=>$granjas->get_espaciosWithCodAllLOTE());
    echo json_encode($ValorRetorno);    
    
}else if($opcion=='getespaciobycodigo'){
    $ValorRetorno=array("espacios"=>$granjas->getAllInfoCodigoEspacios());
    echo json_encode($ValorRetorno); 
}else if (!isset($valorUso) && $opcion=='reg'){
    //Pagina de ingreso para el registro de GRANJAS
}

?>