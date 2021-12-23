<?php
class fisicoquimidet_modelo{
    private $db;
    private $fisicoquimidet;
    private $fisicoquimidet2;
    /*
    LA TABLAS DE FISICOQUIMICOS_PRINCIPAL ES APP0_F3Q3_D2T1
    ID:int /not null
    IDEMP:int /not null
    IDGRA:int /not null
    NORC:int /not null
    VARIABLE:nvarchar(50)/not null
    VALOR:numeric(18,6)/not null
    ACTIVO:int /not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->fisicoquimidet=array();
    }
    public function reg_fisicodeta($IDEMP,$IDGRA,$NORC,$VARIABLE,$VALOR){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP0_F3Q3_D2T1";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->fisicoquimidet,$row);
        }
       $valorMaximo=$this->fisicoquimidet[0]['Maximo']+1;
       $sql = "INSERT INTO APP0_F3Q3_D2T1 ( IDEMP,IDGRA,NORC,VARIABLE,VALOR,ACTIVO,VERSIONES) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
       $params = array( $IDEMP,$IDGRA,$NORC,$VARIABLE,$VALOR, '1', '1');

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }else{
            return array("UltimoId"=>$valorMaximo,"Paso"=>true);
        }
    }
}
?>