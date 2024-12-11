<?php
class vacuna_modelo{
    private $db;
    private $vacuna;
    private $vacuna2;
    /*
    LA TABLAS DE DETALLES_DEL_REPORTES ES APP2_M52S_D2T1
    ID:int /not null
    IDEMP:int /not null
    IDGRA:int /not null
    NORC:int /not null
    LOTE:int /not null
    FECHA:Datetime/not null
    PROVEEDOR:nvarchar(150)/not null
    LABORATORIO:nvarchar(150)/not null
    TIPOVACUNA:nvarchar(150)/not null
    LOTEVACUNA:nvarchar(150)/not null
    HORAINI:time(7)/null
    HORAFIN:time(7)/null
    CANTIDAD:numeric(18,3)/not null
    PESO:numeric(18,3)/null
    PERSONAS:numeric(18,3)/null
    RESPONSABLE:int /not null
    OBSERVACIONES:nvarchar(150)/not null
    ANEXO:nvarchar(50)/null
    USUARIO:numeric(18,3)/not null
    ACTIVO:int /not null
    TEMPORAL:datetime /nor null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->vacuna=array();
        $this->vacuna2=array();
    }
    public function get_vacuna(){
        $sql = "SELECT * FROM APP2_V1C5";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->vacuna,$row);
        }
        return $this->vacuna;
    }
    public function reg_vacuna($IDEMP,$IDGRA,$LOTE,$FECHA,$PROVEEDOR,$LABORATORIO,$TIPOVACUNA,$LOTEVACUNA,$HORAINI,$HORAFIN,$CANTIDAD,$PESO,$PERSONAS,$RESPONSABLE,$OBSERVACIONES,$ANEXO,$USUARIO){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP2_V1C5";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->vacuna,$row);
        }
       $valorMaximo=$this->vacuna[0]['Maximo']+1;
       $valorNORC=$this->getNumeroNORC($IDEMP,$IDGRA);
       $sql = "INSERT INTO APP2_V1C5 (NORC,IDEMP,IDGRA,LOTE,FECHA,PROVEEDOR,LABORATORIO,TIPOVACUNA,LOTEVACUNA,HORAINI,HORAFIN,CANTIDAD,PESO,PERSONAS,RESPONSABLE,OBSERVACIONES,ANEXO,USUARIO,ACTIVO,TEMPORAL,VERSIONES) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,GETDATE(),?)";
       $params = array($valorNORC, $IDEMP,$IDGRA,$LOTE,$FECHA,$PROVEEDOR,$LABORATORIO,$TIPOVACUNA,$LOTEVACUNA,$HORAINI,$HORAFIN,$CANTIDAD,$PESO,$PERSONAS,$RESPONSABLE,$OBSERVACIONES,$ANEXO,$USUARIO,1, '1');

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }else{
            return array("UltimoId"=>$valorMaximo,"NORC"=>$valorNORC,"Paso"=>true);
        }
    }
    public function getNumeroNORC($IDEMP,$IDGRA){
        $sql = "SELECT MAX(NORC) as Maximo FROM APP2_V1C5 WHERE IDEMP='".strval($IDEMP)."' AND IDGRA='".strval($IDGRA)."'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->vacuna2,$row);
        }
        return $this->vacuna2[0]['Maximo']+1;
    }
}
?>