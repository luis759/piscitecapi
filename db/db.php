<?php
class Conectar{
              
         public static function conexion(){
                $serverName = "tcp:mssql-179977-0.cloudclusters.net,10036"; // update me
                $connectionOptions = array(
                    "Database" => "st1t3st3cs1rt3f3s21s", // update me
                     "Uid" => "Edu8cifqGns1vsFAdkzZ", // update me
                     "PWD" => 'VnUJz!%fRy%7rFFiDLL6',
                     "CharacterSet" => "UTF-8" // update me
                 );
            //Establishes the connection
            $conn = sqlsrv_connect($serverName, $connectionOptions);
            return $conn;
        }
         
}


?>