<?php
class consumosprin_modelo{
    private $db;
    private $consumos;
    private $consumos2;
    private $materia;
    /*
    LA TABLAS DE CONSUMOS PRIN ES APP6_C4NS_PR3N
    IDEMP:int /not null
    IDGRA:int /not null
    NORC:int /not null
    FECHA:Datetime/not null
    RESPONSABLE:int /not null
    OBSERVA:nvarchar(200)/not null
    USUARIO:numeric(18,3)/not null
    ACTIVO:int /not null
    TEMPORAL:Datetime/not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->consumos=array();
        $this->materia=array();
        $this->consumos2=array();
    }
  public function get_AllMaterias(){
        $sql = "SELECT * FROM dbo.APP0_1L3M_L3ST(1)";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->materia,$row);
        }
        return $this->materia;
    }
    public function getNumeroNORC($IDEMP,$IDGRA){
        $sql = "SELECT MAX(NORC) as Maximo FROM APP6_C4NS_PR3N WHERE IDEMP='".strval($IDEMP)."'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->consumos2,$row);
        }
        return $this->consumos2[0]['Maximo']+1;
    }
    public function reg_consumoprin($IDEMP,$IDGRA,$FECHA,$RESPONSABLE,$USUARIO,$OBSERVA){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP6_C4NS_PR3N";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->consumos,$row);
        }
       $valorMaximo=$this->consumos[0]['Maximo']+1;
       $valorNORC=$this->getNumeroNORC($IDEMP,$IDGRA);
       $sql = "INSERT INTO APP6_C4NS_PR3N ( IDEMP,IDGRA,NORC,FECHA,RESPONSABLE,OBSERVA,USUARIO,TEMPORAL,ACTIVO,VERSIONES) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
       $params = array( $IDEMP,$IDGRA,$valorNORC,$FECHA,$RESPONSABLE,$OBSERVA,$USUARIO, date("Y-m-d H:i:s"), '1', '1');

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }else{
            return array("UltimoId"=>$valorMaximo,"NORC"=>$valorNORC,"Paso"=>true);
        }
    }
    public function get_materias(){
        $sql = "SELECT * FROM dbo.APP0_1L3M_L3ST(1)";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->consumos,$row);
        }
        return $this->consumos;
    }
}
?>