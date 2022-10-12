
<?php
class permisos_modelo{
    private $db;
    private $permisos;
    /*
    LA TABLAS DE permisos ES APP2_S32M_ESP
    ID:int /not null
    IdMod:int /not null
    IdHoja:int /not null
    UsuarioAcc::numeric(18,0)/not null
     PermisoIng:bit(1)/not null
     PermisoCre:bit(1)/not null
    Usuario::numeric(18,0)/not null
    ACTIVO:int /not null
    temporal:Datetime/not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->permisos=array();
    }
    public function get_permisos(){
        $sql = "SELECT * FROM ACO_1SS1 where  activo = '1'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->permisos,$row);
        }
        return $this->permisos;
    }
}
?>