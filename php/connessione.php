<?php
$dsn = 'mysql:dbname=bmw;host=localhost';
$user = 'root';
$password = 'root';


try
 {
    $newIst = new PDO($dsn, $user, $password);
}

catch (PDOException $e)

{
    exit('Nessuna connessione al Db'.$e->getMessage());
}


?>