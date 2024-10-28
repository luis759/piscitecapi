<?php
class prinrep_modelo{
    private $db;
    private $prinrep;
    private $prinrep2;
    /*
    LA TABLAS DE PRINCIPAL_DEL_REPORTES ES APP2_M52S_PR3N
    ID:int /not null
    IDEMP:int /not null
    IDGRA:int /not null
    NORC:int /not null
    LOTE:int /not null
    FECHA:Datetime/not null
    TIPO:nvarchar(50)/not null
    ANEXO:nvarchar(50)/not null
    RESPONSABLE:int/not null
    OBSERVA:nvarchar(300)/not null
    USUARIO:int/not null
    TEMPORAL:Datetime/not null
    ACTIVO:int /not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->prinrep=array();
        $this->prinrep2=array();
    }
    public function getNumeroNORC($IDEMP,$IDGRA){
        $sql = "SELECT MAX(NORC) as Maximo FROM APP2_M52S_PR3N WHERE IDEMP='".strval($IDEMP)."' AND IDGRA='".strval($IDGRA)."'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->prinrep2,$row);
        }
        return $this->prinrep2[0]['Maximo']+1;
    }
    public function reg_prinreport($IDEMP,$IDGRA,$LOTE,$FECHA,$TIPO,$ANEXO,$RESPONSABLE,$OBSERVA,$USUARIO){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP2_M52S_PR3N";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->prinrep,$row);
        }
       $valorMaximo=$this->prinrep[0]['Maximo']+1;
       $valorNORC=$this->getNumeroNORC($IDEMP,$IDGRA);
       $sql = "INSERT INTO APP2_M52S_PR3N ( IDEMP,IDGRA,NORC,LOTE,FECHA,TIPO,ANEXO,RESPONSABLE,OBSERVA,USUARIO,TEMPORAL,ACTIVO,VERSIONES) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       $params = array( $IDEMP,$IDGRA,$valorNORC,$LOTE,$FECHA,$TIPO,$ANEXO,$RESPONSABLE,$OBSERVA,$USUARIO, date("Y-m-d H:i:s"), '1', '1');

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            file_put_contents("Error.txt", sqlsrv_errors());
            die( print_r( sqlsrv_errors(), true) );
        }else{
            return array("UltimoId"=>$valorMaximo,"NORC"=>$valorNORC,"Paso"=>true);
        }
    }
}
?>