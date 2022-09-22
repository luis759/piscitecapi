<?php
//Llamada al modelo del reportes
require_once("modelo/consumosprin.php");
require_once("modelo/consumosdet.php");
$consumosprin=new consumosprin_modelo(); 
$consumosdet=new consumosdet_modelo(); 

//Validacion para uso de algunas funciones especificas
if (!isset($valorUso) && $opcion=='reg'){
    $IDEMP=$_POST['IDEMP'];
    $IDGRA=$_POST['IDGRA'];
    $FECHA=$_POST['FECHA'];
    $RESPONSABLE=$_POST['RESPONSABLE'];
    $OBSERVA=$_POST['OBSERVA'];  
    $USUARIO=$_POST['USUARIO'];
    $DATADETA=json_decode($_POST['detallejson'],true);
    $valorprincipal=$consumosprin->reg_consumoprin($IDEMP,$IDGRA,$FECHA,$RESPONSABLE,$USUARIO,$OBSERVA);
    $NORC=$valorprincipal['NORC'];
    $contado=0;
    for ($i = 0; $i < count($DATADETA); $i++) {
        $CODESPA=$DATADETA[$i]['CODESPA'];
        $LOTE=(int)$DATADETA[$i]['LOTE'];
        $CANTIDAD=(float)$DATADETA[$i]['CANTIDAD'];
        $LOTEMP=$DATADETA[$i]['LOTEMP'];
        $CODIGO=(int)$DATADETA[$i]['CODIGO'];
        $OBSERVA=$DATADETA[$i]['OBSERVA'];
        $valorsecundario=$consumosdet->reg_conumosdet($IDEMP,$IDGRA,$NORC,$CODESPA,$LOTE,$CANTIDAD,$CODIGO,$LOTEMP,$OBSERVA);
        if($valorsecundario['paso']){
            $contado=$contado+1;
        }
    }
    $retorno=array("Principal"=>$valorprincipal,"DetalleCuenta"=>$contado);
    echo json_encode($retorno);

}else if($opcion=='getmaterias'){
    $ValorRetorno=array("materias"=>$consumosprin->get_AllMaterias());
    echo json_encode($ValorRetorno);
}

?>