<?php
class Conectar{
              
         public static function conexion(){
                $serverName = "tcp:statisticsfishco.database.windows.net,1433"; // update me
                $connectionOptions = array(
                    "Database" => "PISCITEC", // update me
                     "Uid" => "excapps", // update me
                     "PWD" => 'kOE%e*M@2^Y5WL0a',
                     "CharacterSet" => "UTF-8" // update me
                 );
            //Establishes the connection
            $conn = sqlsrv_connect($serverName, $connectionOptions);
            return $conn;
        }
         
}


?>