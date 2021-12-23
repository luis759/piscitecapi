<?php
//Llamada al modelo del reportes
require_once("modelo/detarep.php");
require_once("modelo/saldorep.php");
require_once("modelo/prinrep.php");
$detarep=new detarep_modelo(); 
$saldorep=new saldorep_modelo(); 
$prinrep=new prinrep_modelo(); 

//Validacion para uso de algunas funciones especificas
if($opcion=='getreportes'){
   $ValorRetorno=array("Value"=>$prinrep->get_prinrep());
    echo json_encode($ValorRetorno);
}else if (!isset($valorUso) && $opcion=='reg'){
    $detalljson=json_decode($_POST['detalljson'],true);
    $FECHA=$_POST['FECHA'];
    $IDEMP=$_POST['IDEMP'];
    $IDGRA=$_POST['IDGRA'];
    $LOTE=$_POST['LOTE'];
    if(empty($_POST['OBSERVA'])){
        $OBSERVA=NULL;
    }else{
        $OBSERVA=$_POST['OBSERVA'];
    }
    if(empty($_POST['ANEXO'])){
        $ANEXO=NULL;
    }else{
        $ANEXO=$_POST['ANEXO'];
    }
    $RESPONSABLE=$_POST['RESPONSABLE'];
    $SALDOJSON=json_decode($_POST['saldojson'],true);
    $TIPO=$_POST['TIPO'];
    $USUARIO=$_POST['USUARIO'];
    $valorprincipal=$prinrep->reg_prinreport($IDEMP,$IDGRA,$LOTE,$FECHA,$TIPO,$ANEXO,$RESPONSABLE,$OBSERVA,$USUARIO);
    $NORC=$valorprincipal['NORC'];
    $retorno=array("Principal"=>$valorprincipal,"Saldo"=>$saldorep->reg_saldorep($IDEMP,$IDGRA,$NORC,$LOTE,$FECHA,$SALDOJSON),"Detalles"=>$detarep->reg_detarep($IDEMP,$IDGRA,$NORC,$LOTE,$FECHA,$detalljson));
    echo json_encode($retorno);
}

?>