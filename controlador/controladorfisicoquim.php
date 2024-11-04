<?php
//Llamada al modelo del reportes
require_once("modelo/fisicoquimicoprin.php");
require_once("modelo/parametrosfisicoquimicos.php");
require_once("modelo/fisicoquimicodet.php");
$fisicoquimicoprin=new fisicoquimiprin_modelo(); 
$paramfis=new paramfisico_modelo(); 
$fisicoquimicodeta=new fisicoquimidet_modelo(); 

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
    date_default_timezone_set('America/Bogota');
header('Content-type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
if(isset($data)){
    $dataAcomodada=ArreglarInfoGet($data);
$arregloCorrecto=[];
foreach ($dataAcomodada as &$valor) {
    foreach ($valor as &$valor2) {
        $dataBusqueda=$valor2['CODESPA']."-".$valor2['fecha']."-".$valor2['hora'];
        $datausqueda=array_search($dataBusqueda,array_column($arregloCorrecto, 'dataBusqueda'));
        if(!empty($datausqueda) || $datausqueda===0){
            array_push( $arregloCorrecto[$datausqueda]['data'],$valor2);
        }else{
            array_push( $arregloCorrecto,array('dataBusqueda'=>$dataBusqueda,'CODESPA'=>$valor2['CODESPA'],'IDEMP'=>$valor2['IDEMP'],'IDGRA'=>$valor2['IDGRA'],'usuario'=>$valor2['usuario'],'fecha'=>$valor2['fecha'],'hora'=>$valor2['hora'],'data'=>array($valor2)));
        }
    }
}
$notasNORC=array();
foreach($arregloCorrecto as &$valor){
    $IDEMP=$valor['IDEMP'];
    $IDGRA=$valor['IDGRA'];
    $CODESPA=$valor['CODESPA'];
    $FECHA=$valor['fecha'];
    $HORA=$valor['hora'];
    $RESPONSABLE=NULL;
    $ANEXO=NULL;
    $OBSERVA="Registro de Medusa";  
    $USUARIO=$valor['usuario'];
    $valorprincipal=$fisicoquimicoprin->reg_fisicoprin($IDEMP,$IDGRA,$FECHA,$HORA,$CODESPA,$RESPONSABLE,$ANEXO,$OBSERVA,$USUARIO);
    $NORC=$valorprincipal['NORC'];
    array_push($notasNORC,$valorprincipal['NORC']);
    foreach($valor['data'] as &$valor2){
        $VARIABLE=$valor2['parametro'];
        $VALOR=(float)$valor2['valor'];
        $valorsecundario=$fisicoquimicodeta->reg_fisicodeta($IDEMP,$IDGRA,$NORC,$VARIABLE,$VALOR);
    }
}
echo json_encode(array('Success'=>true,'NUMEROS ORDEN GENERADAS'=>$notasNORC));
}

}

function ArreglarInfoGet($Array) {
  return array_map(function($datoInfo){
    $fisicoquimicoprin=new fisicoquimiprin_modelo(); 
    $CentroProduccion=$datoInfo['productionCenterId'];
    $Unidades=$datoInfo['productionUnitIds'];
    $deviceID=$datoInfo['deviceId'];
    $usuraio=$fisicoquimicoprin->getDeviceID($deviceID);
    $Parametro=$datoInfo['sensorId'];
    $ParametroName=$fisicoquimicoprin->getParametroID($Parametro);
    $fecha=date('Y-m-d',$datoInfo['timestamp']);
    $hora=date('H:i:s',$datoInfo['timestamp']);
    $valor=$datoInfo['value'];
    $arrayRetorno=UnidadesDeProduccion($Unidades,$CentroProduccion,$ParametroName['PARAMETRO'],$fecha,$hora,$valor, $usuraio['CEDULA']);
    return $arrayRetorno;
  },$Array);
  }

  function  UnidadesDeProduccion($Array,$centroProduccio,$parametro,$fecha,$hora,$valor,$Usuario) {
    return array_map(function($dataInfo) use ($parametro,$centroProduccio,$fecha,$valor,$hora,$Usuario) {
        $fisicoquimicoprin=new fisicoquimiprin_modelo(); 
        $informacion=$fisicoquimicoprin->getSMARTWATERCLOUD($centroProduccio,$dataInfo);
    $IDEMP=$informacion['IDEMP'];
    $IDGRA=$informacion['IDGRA'];
    $CODESPA=$informacion['CODESPA'];
    $parametro=$parametro;
    $fecha=$fecha;
    $valor=$valor;
        return array('IDEMP'=>$IDEMP,'IDGRA'=>$IDGRA,'CODESPA'=>$CODESPA,'parametro'=>$parametro,'fecha'=>$fecha,'hora'=>$hora,'valor'=>$valor,'usuario'=>$Usuario);
    },$Array);
  }
?>