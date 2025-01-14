 let f = document.getElementById('form2');
let campi = document.querySelectorAll('input');


f.addEventListener("submit",(e)=>{
e.preventDefault()
// Raccoglie i valori dai campi di input
var username = campi[0].value.trim();
var password = campi[1].value.trim();

 // Validazione dei campi
 if (!username || !password) {
document.getElementById('messaggio2').innerHTML = "Compila tutti i campi.";
return;
}


// Recupera i dati del modulo
const formData = new FormData();
formData.append('username', username);
formData.append('password', password);

// Invia la richiesta AJAX
const xhr = new XMLHttpRequest();
xhr.open("POST", "./php/login.php", true);
xhr.onload = function() {
    if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
            if (response.success) {
                window.location.href = "./php/dashboard.php";
        
    } else {
        document.getElementById('messaggio2').innerHTML = "Credenziali non valide";
    }
};

 xhr.onerror = function() {
 document.getElementById('messaggio2').innerHTML = "Errore nella connessione al server.";
 };
}

 xhr.send(formData);
}); 

