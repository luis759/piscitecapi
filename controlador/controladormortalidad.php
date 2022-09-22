<?php
//Llamada al modelo del reportes
require_once("modelo/mortalidadprin.php");
require_once("modelo/mortalidadeta.php");
$mortalidadprin=new mortalidadprin_modelo(); 
$mortalidaddet=new mortalidaddeta_modelo(); 

//Validacion para uso de algunas funciones especificas
if (!isset($valorUso) && $opcion=='reg'){
    $IDEMP=$_POST['IDEMP'];
    $IDGRA=$_POST['IDGRA'];
    $FECHA=$_POST['FECHA'];
    $RESPONSABLE=$_POST['RESPONSABLE'];
    $OBSERVA=$_POST['OBSERVA'];  
    $USUARIO=$_POST['USUARIO'];
    $DATADETA=json_decode($_POST['detallejson'],true);
    $valorprincipal=$mortalidadprin->reg_mortalidadprin($IDEMP,$IDGRA,$FECHA,$RESPONSABLE,$USUARIO,$OBSERVA);
    $NORC=$valorprincipal['NORC'];
    $contado=0;
    for ($i = 0; $i < count($DATADETA); $i++) {
        $CODESPA=$DATADETA[$i]['CODESPA'];
        $LOTE=(int)$DATADETA[$i]['LOTE'];
        $CANTAM=(float)$DATADETA[$i]['CANTAM'];
        $KILOSAM=(float)$DATADETA[$i]['KILOSAM'];
        $CANTPM=(float)$DATADETA[$i]['CANTPM'];
        $KILOSPM=(float)$DATADETA[$i]['KILOSPM'];
        $CAUSA=(int)$DATADETA[$i]['CAUSA'];
        $OBSERVA=$DATADETA[$i]['OBSERVA'];
        $valorsecundario=$mortalidaddet->reg_mortalidaddet($IDEMP,$IDGRA,$NORC,$CODESPA,$LOTE,$CANTAM,$KILOSAM,$CANTPM,$KILOSPM,$OBSERVA,$CAUSA);
        if($valorsecundario['paso']){
            $contado=$contado+1;
        }
    }
    $retorno=array("Principal"=>$valorprincipal,"DetalleCuenta"=>$contado);
    echo json_encode($retorno);

}else if($opcion=='getcausas'){
    $ValorRetorno=array("causas"=>$mortalidadprin->get_allcausas());
    echo json_encode($ValorRetorno);
}

?>