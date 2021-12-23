<?php
//Llamada al modelo del reportes
require_once("modelo/vacuna.php");
$vacuna=new vacuna_modelo(); 

//Validacion para uso de algunas funciones especificas
if($opcion=='getreportes'){
   $ValorRetorno=array("vacunas"=>$vacuna->get_vacuna());
    echo json_encode($ValorRetorno);
}else if (!isset($valorUso) && $opcion=='reg'){
    $IDEMP=$_POST['IDEMP'];
    $IDGRA=$_POST['IDGRA'];
    $LOTE=$_POST['LOTE'];
    $PROVEEDOR=$_POST['PROVEEDOR'];
    $LABORATORIO=$_POST['LABORATORIO'];
    $FECHA=$_POST['FECHA'];
    $TIPOVACUNA=$_POST['TIPOVACUNA'];
    $LOTEVACUNA=$_POST['LOTEVACUNA'];
    if(empty($_POST['HORAINI'])){
        $HORAINI=NULL;
    }else{
        $HORAINI=date('H:i', strtotime($_POST['HORAINI']));
    }
    if(empty($_POST['HORAFIN'])){
        $HORAFIN=NULL;
    }else{
        $HORAFIN=date('H:i', strtotime($_POST['HORAFIN']));
    }
    $CANTIDAD=$_POST['CANTIDAD'];
    if(empty($_POST['PESO'])){
        $PESO=NULL;
    }else{
        $PESO=$_POST['PESO'];
    }
    if(empty($_POST['PERSONAS'])){
        $PERSONAS=NULL;
    }else{
        $PERSONAS=$_POST['PERSONAS'];
    }
    $RESPONSABLE=$_POST['RESPONSABLE'];
    $OBSERVACIONES=$_POST['OBSERVACIONES'];
    if(empty($_POST['ANEXO'])){
        $ANEXO=NULL;
    }else{
        $ANEXO=$_POST['ANEXO'];
    }
    $USUARIO=$_POST['USUARIO'];
    $valorprincipal=$vacuna->reg_vacuna($IDEMP,$IDGRA,$LOTE,$FECHA,$PROVEEDOR,$LABORATORIO,$TIPOVACUNA,$LOTEVACUNA,$HORAINI,$HORAFIN,$CANTIDAD,$PESO,$PERSONAS,$RESPONSABLE,$OBSERVACIONES,$ANEXO,$USUARIO);
    $retorno=array("Principal"=>$valorprincipal);
    echo json_encode($retorno);
}

?>