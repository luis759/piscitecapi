<?php
class versionapp{
    private $db;
    private $versionapps;
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
        $this->versionapps=array();
    }
    public function getVersion($version){
        $sql = "SELECT * FROM APP0_V2RS_APP where VERSIONES='".strval($version)."'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->versionapps,$row);
        }
        return $this->versionapps;
    }
    public function reg_version($DESCRIPCION,$VERSION){
       $sql = "INSERT INTO APP0_V2RS_APP (FECHA,DESCRIPCION,VERSIONES) VALUES ( ?,?,?)";
       $params = array(date("Y-m-d H:i:s"), $DESCRIPCION,$VERSION);

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }else{
            return array("Paso"=>true);
        }
    }
}
?>