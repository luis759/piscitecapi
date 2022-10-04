<?php
class mortalidaddeta_modelo{
    private $db;
    private $mortalidad;
    private $mortalidad2;
     /*
    LA TABLAS DE MORTALIDADDETA ES APP6_M4RT_D2T1
    IDEMP:int /not null
    IDGRA:int /not null
    NORC:int /not null
    CODESPA:nvarchar(10)/not null
    LOTE:int /not null
    CANTAM:numeric(18,0)/not null
    KILOSAM:numeric(18,1)/not null
    CANTPM:numeric(18,0)/not null
    KILOSPM:numeric(18,1)/not null
    OBSERVA:nvarchar(200)/not null
    CAUSA:int /not null
    ACTIVO:int /not null
    VERSIONES:int /not null
    */
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->mortalidad=array();
        $this->mortalidad2=array();
    }
    public function reg_mortalidaddet($IDEMP,$IDGRA,$NORC,$CODESPA,$LOTE,$CANTAM,$KILOSAM,$CANTPM,$KILOSPM,$OBSERVA,$CAUSA){
  
        $sql = "SELECT MAX(ID) as Maximo FROM APP6_M4RT_D2T1";
        $stmt = sqlsrv_query(  $this->db, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($this->mortalidad,$row);
        }
       $valorMaximo=$this->mortalidad[0]['Maximo']+1;
       $sql = "INSERT INTO APP6_M4RT_D2T1 ( IDEMP,IDGRA,NORC,CODESPA,LOTE,CANTAM,KILOSAM,CANTPM,KILOSPM,OBSERVA,CAUSA,ACTIVO,VERSIONES) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       $params = array( $IDEMP,$IDGRA,$NORC,$CODESPA,$LOTE,$CANTAM,$KILOSAM,$CANTPM,$KILOSPM,$OBSERVA,$CAUSA, '1', '1');

       $stmt = sqlsrv_query( $this->db, $sql, $params);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }else{
            return array("UltimoId"=>$valorMaximo,"Paso"=>true);
        }
    }
}
?>