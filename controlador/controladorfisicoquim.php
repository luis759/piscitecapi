<?php
//Llamada al modelo del reportes
require_once("modelo/fisicoquimicoprin.php");
require_once("modelo/parametrosfisicoquimicos.php");
require_once("modelo/fisicoquimicodet.php");
$fisicoquimicoprin=new fisicoquimiprin_modelo(); 
$paramfis=new paramfisico_modelo(); 
$fisicoquimicodeta=new fisicoquimidet_modelo(); 

//Validacion para uso de algunas funciones especificas
if (!isset($valorUso) && $opcion=='reg'){
    $IDEMP=$_POST['IDEMP'];
    $IDGRA=$_POST['IDGRA'];
    $CODESPA=$_POST['IDESPA'];
    $FECHA=$_POST['FECHA'];
    $HORA=date('H:i', strtotime($_POST['HORA']));
    $RESPONSABLE=$_POST['RESPONSABLE'];
    $OBSERVA=$_POST['OBSERVA'];  
    if(empty($_POST['ANEXO'])){
        $ANEXO=NULL;
    }else{
        $ANEXO=$_POST['ANEXO'];
    }
    $USUARIO=$_POST['USUARIO'];
    $DATADETA=json_decode($_POST['detallejson'],true);
    $valorprincipal=$fisicoquimicoprin->reg_fisicoprin($IDEMP,$IDGRA,$FECHA,$HORA,$CODESPA,$RESPONSABLE,$ANEXO,$OBSERVA,$USUARIO);
    $NORC=$valorprincipal['NORC'];
    $contado=0;
    for ($i = 0; $i < count($DATADETA); $i++) {
        $VARIABLE=$DATADETA[$i]['variable'];
        $VALOR=(float)$DATADETA[$i]['valor'];
        $valorsecundario=$fisicoquimicodeta->reg_fisicodeta($IDEMP,$IDGRA,$NORC,$VARIABLE,$VALOR);
        if($valorsecundario['paso']){
            $contado=$contado+1;
        }
    }
    $retorno=array("Principal"=>$valorprincipal,"DetalleCuenta"=>$contado);
    echo json_encode($retorno);

}else if($opcion=='getfisicoquimicosparam'){
    $ValorRetorno=array("parametros"=>$paramfis->get_paramfisico());
    echo json_encode($ValorRetorno);
}

?>