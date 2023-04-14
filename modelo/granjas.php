<?php
class granjas_modelo{
    private $db;
    private $granjas;
    /*
    LA TABLAS DE granjas ES APP3_GR1N
    ID:int /not null
    IDEMP:int /not null
    IDGRA:int /not null
    NOMBRE:nvarchar(50,0) /not null
    MUNICIPIO:nvarchar(50,0) /not null
    DIRECCION:nvarchar(250,0) /not null
    ACTIVO:int /not null
    usuario:numeric(18,0)/not null
    temporal:Datetime/not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->granjas=array();
    }
    public function get_espacios($IDEMP,$IDGRAN){
        $sql = "SELECT NOMBRE,LOTE  FROM APP2_L4T2_BY_2SP1(".$IDEMP.",".$IDGRAN.")";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->granjas,$row);
        }
        return $this->granjas;
    }
    public function get_espaciosWithCod($IDEMP,$IDGRAN){
        $sql = "SELECT COD,NOMBRE  FROM APP0_2SP1_D2T1 where activo=1 AND IDEMP=".strval($IDEMP)." AND IDGRA=".strval($IDGRAN);
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->granjas,$row);
        }
        return $this->granjas;
    }
    
    public function get_espaciosWithCodAll(){
        $sql = "SELECT COD,NOMBRE,IDEMP,IDGRA  FROM APP0_2SP1_D2T1 where activo=1";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->granjas,$row);
        }
        return $this->granjas;
    }
    public function get_espaciosWithCodAllLOTE(){
        $sql = "SELECT * FROM dbo.APP2_L4T2_BY_2SP1_TOT(1) where LOTE is not  null";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->granjas,$row);
        }
        return $this->granjas;
    }
    public function getAllInfoCodigoEspacios(){
        $sql = "SELECT * FROM dbo.APP2_L4T2_BY_2SP1_TOT(1)";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->granjas,$row);
        }
        return $this->granjas;
    }
    public function get_granjas(){
        $sql = "SELECT * FROM APP3_GR1N where activo = '1'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->granjas,$row);
        }
        return $this->granjas;
    }
}
?>