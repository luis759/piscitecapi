<?php
class saldorep_modelo{
    private $db;
    private $saldorep;
    private $saldorep2;
    /*
    LA TABLAS DE SALDOS_REPORTES ES APP2_M52S_S1LD
    ID:int /not null
    IDEMP:int /not null
    IDGRA:int /not null
    NORC:int /not null
    LOTE:int /not null
    FECHA:Datetime/not null
    IDESP:int /not null
    SALDO:numeric(18,3)/not null
    ACTIVO:int /not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->saldorep=array();
        $this->saldorep2=array();
    }
    public function get_saldorep(){
        $sql = "SELECT * FROM APP2_M52S_S1LD";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->saldorep2,$row);
        }
        return $this->saldorep2;
    }

    public function reg_saldorep($IDEMP,$IDGRA,$NORC,$LOTE,$FECHA,$JSONSALDO){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP2_M52S_S1LD";
        $stmt = sqlsrv_query($this->db, $sql);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->saldorep,$row);
        }
       $valorMaximo=($this->saldorep[0]['Maximo'])+count($JSONSALDO);

       for ($i = 0; $i < count($JSONSALDO); $i++) {
       $IDESP=$JSONSALDO[$i]['especie']['IDESP'];
       $SALDO=(float)$JSONSALDO[$i]['saldo'];
       $idinicial=$valorMaximo-$i;
       $sql = "INSERT INTO APP2_M52S_S1LD ( IDEMP,IDGRA,NORC,LOTE,FECHA,IDESP,SALDO,ACTIVO,VERSIONES) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       $params = array($IDEMP,$IDGRA,$NORC,$LOTE,$FECHA,$IDESP,$SALDO, '1', '1');

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
            file_put_contents("Error.txt", sqlsrv_errors());
        }
        
        }

        return array("UltimoId"=>$valorMaximo,"Paso"=>true,"Veces"=>count($JSONSALDO));
    }
}
?>