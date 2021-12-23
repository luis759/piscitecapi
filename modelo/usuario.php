<?php
class usuario_modelo{
    private $db;
    private $usuarios;
    /*
    LA TABLAS DE USAURIOS ES ACO_5S5R
    id:int /not null
    Cedula:numeric(18,0)/not null
    Nombre:nvarchar(100,0)/not null
    correo:nvarchar(100,0)/not null
    movil:nvarchar(50,0)/not null
    palabra:nvarchar(50,0)/not null
    usuario:numeric(18,0)/not null
    activo:int/not null
    temporal:Datetime/not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->usuarios=array();
    }
    public function get_Usuarios(){
        $sql = "SELECT * FROM ACO_5S5R where  activo = '1'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->usuarios,$row);
        }
        return $this->usuarios;
    }
}
?>