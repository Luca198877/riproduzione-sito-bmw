<?php
ob_start(); 
session_start();
include 'connessione.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$user = $_POST['username'];
$pass = $_POST['password'];


//Effettuo i controlli sull'USERNAME
$query = "SELECT * FROM clienti WHERE username=:user";//user è un placeholder, l'importante è che corrisponda al parametro passato in bindParam

$stmt = $newIst->prepare($query);// si fa per prevenire attacchi di SQL injection
$stmt->bindParam('user',$user);// quando eseguitò la query prenderò la variabile


try{
    $stmt->execute();//eseguo la query
    $totfound = $stmt->rowCount();// conto le righe presenti con quel username nel db
    if($totfound == 0){
        echo json_encode(['success' => false, 'message' => 'Credenziali non valide']);
        exit();
    }

    // Recupera i dati dell'utente

    $arrecord = $stmt->fetch(PDO::FETCH_ASSOC);//Trasforma il record del DB in un array associativo
    $indbpass = $arrecord['password'];//prendo la password dall'array associativo

//controllo sulla Password
    if(!password_verify($pass,$indbpass)){ // confronto la password con la password estrapolata dall'array
        echo json_encode(['success' => false, 'message' => 'Credenziali non valide']);  
    exit();
    }
    else 
    {
    $_SESSION['username'] = $user; // Memorizza l'username nella sessione
    //echo("Accesso riuscito"
    $id=$arrecord['id_cliente'];
    $_SESSION['id_cliente']=$id;

    echo json_encode(['success' => true]);
            exit();
}
}

 catch(PDOException $e){
    echo json_encode(['success' => false, 'message' => 'Collegamento fallito: ' . $e->getMessage()]);
    exit();
}   

}

ob_end_flush();
?> 

<