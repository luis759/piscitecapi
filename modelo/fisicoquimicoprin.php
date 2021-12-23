<?php
class fisicoquimiprin_modelo{
    private $db;
    private $fisicoquimiprin;
    private $fisicoquimiprin2;
    /*
    LA TABLAS DE FISICOQUIMICOS_PRINCIPAL ES APP0_F3Q3_PR3N
    ID:int /not null
    IDEMP:int /not null
    IDGRA:int /not null
    NORC:int /not null
    FECHA:Datetime/not null
    HORA:time(7)/not null
    CODESPA:nvarchar(5)/not null
    RESPONSABLE:int/not null
    ANEXO:nvarchar(50)/not null
    OBSERVA:nvarchar(300)/not null
    USUARIO:int/not null
    TEMPORAL:Datetime/not null
    ACTIVO:int /not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->fisicoquimiprin=array();
        $this->fisicoquimiprin2=array();
    }
    public function getNumeroNORC($IDEMP,$IDGRA){
        $sql = "SELECT MAX(NORC) as Maximo FROM APP0_F3Q3_PR3N WHERE IDEMP='".strval($IDEMP)."' AND IDGRA='".strval($IDGRA)."'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->fisicoquimiprin2,$row);
        }
        return $this->fisicoquimiprin2[0]['Maximo']+1;
    }
    public function reg_fisicoprin($IDEMP,$IDGRA,$FECHA,$HORA,$CODESPA,$RESPONSABLE,$ANEXO,$OBSERVA,$USUARIO){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP0_F3Q3_PR3N";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->fisicoquimiprin,$row);
        }
       $valorMaximo=$this->fisicoquimiprin[0]['Maximo']+1;
       $valorNORC=$this->getNumeroNORC($IDEMP,$IDGRA);
       $sql = "INSERT INTO APP0_F3Q3_PR3N ( IDEMP,IDGRA,NORC,FECHA,HORA,CODESPA,ANEXO,RESPONSABLE,OBSERVA,USUARIO,TEMPORAL,ACTIVO,VERSIONES) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       $params = array( $IDEMP,$IDGRA,$valorNORC,$FECHA,$HORA,$CODESPA,$ANEXO,$RESPONSABLE,$OBSERVA,$USUARIO, date("Y-m-d H:i:s"), '1', '1');

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }else{
            return array("UltimoId"=>$valorMaximo,"NORC"=>$valorNORC,"Paso"=>true);
        }
    }
}
?>