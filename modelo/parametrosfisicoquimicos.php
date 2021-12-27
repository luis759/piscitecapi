<?php
class paramfisico_modelo{
    private $db;
    private $paramfisico;
    /*
    LA TABLAS DE granjas ES APP0_P1R1_L3ST
    ID:int /not null
    PARAMETRO:int /not null
    VALMIN:numeric(18,3)/not null
    VALMAX:numeric(18,3)/not null
    UNIDAD:nvarchar(50,0) /not null
    ACTIVO:int /not null
    usuario:numeric(18,0)/not null
    temporal:Datetime/not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->paramfisico=array();
    }
    
    public function get_paramfisico(){
        $sql = "SELECT * FROM APP0_P1R1_L3ST where activo = '1'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->paramfisico,$row);
        }
        return $this->paramfisico;
    }
}
?>