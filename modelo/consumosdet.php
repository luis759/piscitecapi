<?php
class consumosdet_modelo{
    private $db;
    private $consumos;
    private $consumos2;
     /*
    LA TABLAS DE CONSUMOS_DETA ES APP6_C4NS_D2T1
    ID:int /not null
    IDEMP:int /not null
    IDGRA:int /not null
    NORC:int /not null
    CODESPA:nvarchar(10)/not null
    LOTE:int /not null
    CANTIDAD:numeric(18,3)/not null
    CODIGO:int /not null
    LOTEMP:int /not null
    OBSERVA:nvarchar(200)/not null
    ACTIVO:int /not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->consumos=array();
    }
    public function reg_conumosdet($IDEMP,$IDGRA,$NORC,$CODESPA,$LOTE,$CANTIDAD,$CODIGO,$LOTEMP,$OBSERVA){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP6_C4NS_D2T1";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->consumos,$row);
        }
       $valorMaximo=$this->consumos[0]['Maximo']+1;
       $sql = "INSERT INTO APP6_C4NS_D2T1 ( IDEMP,IDGRA,NORC,CODESPA,LOTE,CANTIDAD,CODIGO,LOTEMP,OBSERVA,ACTIVO,VERSIONES) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       $params = array( $IDEMP,$IDGRA,$NORC,$CODESPA,$LOTE,$CANTIDAD,$CODIGO,$LOTEMP,$OBSERVA, '1', '1');

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }else{
            return array("UltimoId"=>$valorMaximo,"Paso"=>true);
        }
    }
}
?>