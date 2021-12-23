<?php
class detarep_modelo{
    private $db;
    private $detarep;
    private $detarep2;
    /*
    LA TABLAS DE DETALLES_DEL_REPORTES ES APP2_M52S_D2T1
    ID:int /not null
    IDEMP:int /not null
    IDGRA:int /not null
    NORC:int /not null
    LOTE:int /not null
    FECHA:Datetime/not null
    IDESP:int /not null
    PESOTOT:numeric(18,3)/not null
    CANTIDAD:numeric(18,3)/not null
    PESO:numeric(18,3)/not null
    LARGO:numeric(18,3)/not null
    ALTO:numeric(18,3)/not null
    SEXO:nvarchar(1)/not null
    ACTIVO:int /not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->detarep=array();
    }
    public function get_detarep(){
        $sql = "SELECT * FROM APP2_M52S_D2T1";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->detarep2,$row);
        }
        return $this->detarep2;
    }
    public function reg_detarep($IDEMP,$IDGRA,$NORC,$LOTE,$FECHA,$DETALLE){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP2_M52S_D2T1";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->detarep,$row);
        }
       $valorMaximo=($this->detarep[0]['Maximo'])+count($DETALLE);
       for ($i = 0; $i < count($DETALLE); $i++) {

      
       $idEspecie=$DETALLE[$i]['especie']['IDESP'];
       $pesotot=(float)$DETALLE[$i]['pesototal'];
       $cantidad=(float)$DETALLE[$i]['CantidadAnimales'];
       $peso=(float)$DETALLE[$i]['pesoprom'];
       if(empty($DETALLE[$i]['largo'])){
        $largo= NULL;
       }else{
        $largo=(float)$DETALLE[$i]['largo'];
       }
       if(empty($DETALLE[$i]['sexo'])){
        $sexo= NULL;
       }else{
        $sexo=$DETALLE[$i]['sexo'];
       }
       if(empty($DETALLE[$i]['alto'])){
        $alto= NULL;
       }else{
        $alto=(float)$DETALLE[$i]['alto'];
       }
       $idinicial=$valorMaximo-$i;
       $sql = "INSERT INTO APP2_M52S_D2T1 ( IDEMP,IDGRA,NORC,LOTE,FECHA,IDESP,PESOTOT,CANTIDAD,PESO,LARGO,ALTO,SEXO,ACTIVO,VERSIONES) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       $params = array($IDEMP,$IDGRA,$NORC,$LOTE,$FECHA,$idEspecie,$pesotot,$cantidad,$peso,$largo,$alto,$sexo, '1', '1');

      $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        }
        return array("UltimoId"=>$valorMaximo,"Paso"=>true,"Veces"=>count($DETALLE));
    }
}
?>