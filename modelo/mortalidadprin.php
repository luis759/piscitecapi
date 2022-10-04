<?php
class mortalidadprin_modelo{
    private $db;
    private $mortalidad;
    private $mortalidad2;
    private $mortalidaddata;
    /*
    LA TABLAS DE MORTALIDAD PRIN ES APP6_M4RT_PR3N
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
        $this->mortalidad=array();
        $this->mortalidaddata=array();
        $this->mortalidad2=array();
    }
  public function get_allcausas(){
        $sql = "SELECT *  FROM APP6_M4RT_C15S";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->mortalidaddata,$row);
        }
        return $this->mortalidaddata;
    }
    public function getNumeroNORC($IDEMP,$IDGRA){
        $sql = "SELECT MAX(NORC) as Maximo FROM APP6_M4RT_PR3N WHERE IDEMP='".strval($IDEMP)."' AND IDGRA='".strval($IDGRA)."'";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->mortalidad2,$row);
        }
        return $this->mortalidad2[0]['Maximo']+1;
    }
    public function reg_mortalidadprin($IDEMP,$IDGRA,$FECHA,$RESPONSABLE,$USUARIO,$OBSERVA){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP6_M4RT_PR3N";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->mortalidad,$row);
        }
       $valorMaximo=$this->mortalidad[0]['Maximo']+1;
       $valorNORC=$this->getNumeroNORC($IDEMP,$IDGRA);
       $sql = "INSERT INTO APP6_M4RT_PR3N ( IDEMP,IDGRA,NORC,FECHA,RESPONSABLE,OBSERVA,USUARIO,TEMPORAL,ACTIVO,VERSIONES) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
       $params = array( $IDEMP,$IDGRA,$valorNORC,$FECHA,$RESPONSABLE,$OBSERVA,$USUARIO, date("Y-m-d H:i:s"), '1', '1');

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }else{
            return array("UltimoId"=>$valorMaximo,"NORC"=>$valorNORC,"Paso"=>true);
        }
    }
}
?>