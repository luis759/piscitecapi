<?php
class especies_modelo{
    private $db;
    private $especies;
    /*
    LA TABLAS DE especies ES APP2_S32M_ESP
    ID:int /not null
    IDESP:int /not null
    GRUPO:nvarchar(70,0) /not null
    ESPECIE:nvarchar(70,0) /not null
    CIENTIFICO:nvarchar(70,0) /not null
    ACTIVO:int /not null
    usuario:numeric(18,0)/not null
    temporal:Datetime/not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->especies=array();
    }
    public function get_especies(){
        $sql = "SELECT * FROM APP2_S32M_ESP where activo = '1'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->especies,$row);
        }
        return $this->especies;
    }
}
?>