<?php
class empresas_modelo{
    private $db;
    private $empresas;
    /*
    LA TABLAS DE EMPRESAS ES APP0_2MPR
    IDEMP:int /not null
    EMPRESA:nvarchar(100,0)/not null
    usuario:numeric(18,0)/not null
    temporal:Datetime/not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->empresas=array();
    }
    public function get_Empresas(){
        $sql = "SELECT * FROM APP0_2MPR";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->empresas,$row);
        }
        return $this->empresas;
    }
}
?>