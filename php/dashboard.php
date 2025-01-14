<?php
session_start();
include 'connessione.php';

$id = $_SESSION['id_cliente'];



$query= "SELECT * FROM clienti WHERE id_cliente = :id_cliente";

$stmt = $newIst->prepare($query);
$stmt->bindParam(':id_cliente',$id);
try{
    $stmt->execute();

}
catch(PDOException $e){
    exit('Errore nel DB'.$e->getMessage());
}

$array=$stmt->fetch(PDO::FETCH_ASSOC);

$nome= $array['nome'];
$cognome= $array['cognome'];
$email= $array['email'];

// Gestione dell'invio del form

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati inviati dal form
    $motivo = $_POST['motivo'];
    $giorno = $_POST['giorno'];
    $meseSelezionato = $_POST['mese'];
    $ora = $_POST['ora'];

    $q = "INSERT INTO prenotazioni (motivo,mese,giorno,ora ) VALUES(:motivo,:mese,:giorno,:ora)";

    if ($statement = $newIst->prepare($q)) {
        $statement->bindParam(':motivo', $motivo);
        $statement->bindParam(':mese', $meseSelezionato);
        $statement->bindParam(':giorno', $giorno);
        $statement->bindParam(':ora', $ora);
        if($statement->execute()){
            echo json_encode(['success' => true, 'message' => "Appuntamento fissato per il giorno $giorno del mese $meseSelezionato per: $motivo."]);
        }
        else {
            echo json_encode(['success' => false, 'message' => 'Errore durante l\'inserimento dei dati.']);
        }
        //$statement->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query.']);
    }
    exit;
}
?>



<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../bmw-foto/bmw-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
    <title>Bmw | DashBoard | Clienti</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../bmw-foto/bmw-logo.svg" alt="bmw-logo">
        </div>
        <div class="menu">
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="../modelli.html">Modelli</a></li>
                <li><a href="../all-elettric.html">All Elettric</a></li>
                <li><a href="../concessionarie.html">Concessionarie</a></li>
                <li><a href="../registrazione.html">Registrati</a></li>
                <li><a href="../login.html">Login</a></li>
            </ul>
        </div>
        <div class="hamburger">
            <img width="48" height="48" src="https://img.icons8.com/fluency/48/menu-squared-2.png" alt="menu-squared-2"/>
        </div>
        <div class="social">
            <ul>
                <li><a href="https://www.facebook.com/bmw/" target="_blank"><img src="../bmw-foto/icons8-facebook-nuovo-48.png" alt="logo-facebook" width="32px" height="32px"></a></li>
                <li><a href="https://www.instagram.com/bmw/" target="_blank"><img src="../bmw-foto/icons8-instagram-32.png" alt="logo-instagram"></a></li>
                <li><a href="https://www.twitter.com/bmw/" target="_blank"><img src="../bmw-foto/icons8-twitter-48.png" height="32px" width="32px" alt="logo-twitter"></a></li>
            </ul>

        </div>

    </header>

    
    <main class="mostraDati">
        <h4>Benvenuto <?php echo $nome." "  .$cognome  ?></h4>
    </main>
    

    
    <div class="contact">
        <form action="" method="post" id="appointmentForm">
            <h3>Fissa il tuo appuntamento con noi</h3>
            <label for="motivo">Ci contatta per:</label>
            <select name="motivo" id="motivo" required>
                
                    <?php
                    $motivi=["Acquisto","Prova","Tagliandi","permuta"];

                    foreach($motivi as $motivo){
                        echo "<option value ='$motivo'>$motivo</option>";
                    }
                    ?>
                
            </select>
        <div class="contact-inside">
           
            <h4>Stabiliamo una data: </h4>
            <select name="mese" id="mese" onchange="updateDays()" required>
                <?php
                $mesi = ["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"];

                foreach($mesi as $mese){
                    echo "<option value='$mese'>$mese<option>";
                }
                
                ?>
            </select>
            <label for="giorno">Giorno: </label>
            <select select name="giorno" id="giorno" required>
                <!-- <?php
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $meseSelezionato = $_POST
                ['mese'];
                

                if( $meseSelezionato == "Gennaio" || $meseSelezionato== "Marzo" || $meseSelezionato== "Maggio" || $meseSelezionato == "Luglio" || $meseSelezionato == "Agosto" || $meseSelezionato == "Ottobre" || $meseSelezionato == "Dicembre"){
                    for ($i = 1; $i <= 31; $i++){
                        echo "<option value='$i'>$i</option>";
                    }
                }
                 else if ($meseSelezionato == "Febbraio") {
                for ($i = 1; $i <= 28; $i++){
                    echo "<option value='$i'>$i</option>";
                }
             }
                else {
                    for ($i = 1; $i <= 30; $i++){
                        echo "<option value='$i'>$i</option>";
                    }
                }
            }
                
                ?> -->
            </select>
            <label for="ora">Orario</label>
            <select name="ora"  id="ora" required>
            <?php
            $orario = [9,10,11,12,13,14,15,16,17,18,19];
            foreach($orario as $ora){
                echo "<option value ='$ora'>$ora<option>";
            }
            
            ?>

            </select>
        </div>
        <button type="submit" class="button">Invia appuntamento</button>
        </form>
    </div> 

    

   
     
        
        

    <!--Footer-->
    <footer class="footer">
        <div class="settore">
           <p>TROVA LA TUA BMW</p>
           <a href="">Contatti bmw-foto</a>
            <a href="">Concessionarie & Centri Service BMW</a>
            <a href="">Preventivo</a>
            <a href="">Test Drive NOW</a>
           
        </div>
        <div class="settore">
        <p>INSIDE BMW</p>
                <a href="">Gamma Bmw</a>
                <a href="">BMW Genius</a>
                <a href="">Informazioni sugli pneumatici</a>
                <a href="">BMW Business</a>
                <a href="">Lavora con noi</a>
                <a href="">Offerte di lavoro Rete BMW</a>
                <a href="">FAQ</a>
                <a href="">BMW.com</a>

        </div>
        <div class="settore">
            <p>TERMINI DI UTILIZZO</p>
            <a href="">Informazioni legali ConnectDrive</a>
            <a href="">Codice etico</a>
            <a href="">Licenza SIAE Internet AMC 3880</a>
            <a href="">Partita IVA IT 123456689</a>
            <a href="">Garanzia compravendita</a>           

        </div>
    </footer>


   <script src="../js/bmw.js"></script>
   <script src="../js/updateDays.js"></script>
   <script src="../js/dashboard.js"></script> 
</body>
</html>