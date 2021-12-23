<?php
class Conectar{
              
         public static function conexion(){
                $serverName = "tcp:piscitec2.database.windows.net,1433"; // update me
                $connectionOptions = array(
                    "Database" => "P3SC3T2C", // update me
                     "Uid" => "excapps", // update me
                     "PWD" => "Anka*2015",
                     "CharacterSet" => "UTF-8" // update me
                 );
            //Establishes the connection
            $conn = sqlsrv_connect($serverName, $connectionOptions);
            return $conn;
        }
         
}


?>