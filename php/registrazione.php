<?php
include "connessione.php";


error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$nome=$_POST['nome'];
$cognome=$_POST['cognome'];
$email=$_POST['email'];
$user =$_POST['username'];
$pass =$_POST['password'];



//cripto la password da inserire nel DATABASE
$pass = password_hash($pass,PASSWORD_DEFAULT);


//Passiamo ai controlli sull'EMAIL
$query = "SELECT email FROM clienti WHERE  email = :email";

$stmt = $newIst->prepare($query);
$stmt->bindParam(':email',$email);

try{
    $stmt->execute();
    $totfound = $stmt->rowCount();
    if($totfound != 0){
        exit("Email già registrata");
    }
}

catch(PDOException $e){
    exit('Query fallita'.$e->getMessage());
}

//Adesso passiamo ad inserire i valori nel DB
$query = "INSERT INTO clienti (nome,cognome,email,username,password) VALUES (:nome,:cognome,:email,:username,:password)";

$stmt= $newIst->prepare($query);
$stmt->bindParam(':nome',$nome);
$stmt->bindParam(':cognome',$cognome);
$stmt->bindParam(':email',$email);
$stmt->bindParam(':username',$user);
$stmt->bindParam(':password',$pass);


try {
    $stmt->execute();
    exit('utente inserito');
}
catch (PDOException $e){
    exit ('Utente non inserito'.$e->getMessage());
}











}
?>