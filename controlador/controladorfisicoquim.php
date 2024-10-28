<?php
//Llamada al modelo del reportes
/*require_once("modelo/fisicoquimicoprin.php");
require_once("modelo/parametrosfisicoquimicos.php");
require_once("modelo/fisicoquimicodet.php");
$fisicoquimicoprin=new fisicoquimiprin_modelo(); 
$paramfis=new paramfisico_modelo(); 
$fisicoquimicodeta=new fisicoquimidet_modelo(); */

//Validacion para uso de algunas funciones especificas
if (!isset($valorUso) && $opcion=='reg' && !isset($isAPi)){
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

}else if($opcion=='getfisicoquimicosparam' && !isset($isAPi)){
    $ValorRetorno=array("parametros"=>$paramfis->get_paramfisico());
    echo json_encode($ValorRetorno);
}else if ($opcion=='registroWebhook' && isset($isAPi)){
header('Content-type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
print_r(ArreglarInfoGet($data));
}


function ArreglarInfoGet($Array) {
  return array_map(function($datoInfo){
    $CentroProduccion=$datoInfo['productionCenterId'];
    $Unidades=$datoInfo['productionUnitIds'];
    $Usuario=$datoInfo['deviceId'];
    $Parametro=$datoInfo['sensorId'];
    $fecha=date('Y-m-d',$datoInfo['sensorId']);
    $hora=date('H:i:s',$datoInfo['sensorId']);
    $valor=$datoInfo['value'];
    $arrayRetorno=UnidadesDeProduccion($Unidades,$CentroProduccion,$Parametro,$fecha,$hora,$valor);
    return $arrayRetorno;
  },$Array);
  }

  function  UnidadesDeProduccion($Array,$centroProduccio,$parametro,$fecha,$hora,$valor) {
    return array_map(function($dataInfo) use ($parametro,$fecha,$valor,$hora) {
    $IDEMP='Prueba';
    $IDGRA='Prueba';
    $CODESPA='Prueba';
    $parametro=$parametro;
    $fecha=$fecha;
    $valor=$valor;
        return array('IDEMP'=>$IDEMP,'IDGRA'=>$IDGRA,'CODESPA'=>$CODESPA,'parametro'=>$parametro,'fecha'=>$fecha,'hora'=>$hora,'valor'=>$valor);
    },$Array);
  }
?>