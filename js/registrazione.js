

    let f = document.getElementById('form');
    let campi = document.querySelectorAll('input');


    f.addEventListener("submit",(e)=>{
        e.preventDefault()
        // Raccoglie i valori dai campi di input
        var nome = campi[0].value.trim();
        var cognome = campi[1].value.trim();
        var email = campi[2].value.trim();
        var username = campi[3].value.trim();
        var password = campi[4].value.trim();

        // Validazione dei campi
        if (!nome || !cognome || !email || !username || !password) {
        document.getElementById('messaggio').innerHTML = "Compila tutti i campi.";
        return;
        }

        // Recupera i dati del modulo
        let formData = new FormData();
        formData.append('nome', nome);
        formData.append('cognome', cognome);
        formData.append('email', email);
        formData.append('username', username);
        formData.append('password', password);

        // Invia la richiesta AJAX
        const xhr = new XMLHttpRequest();
            xhr.open("post","./php/registrazione.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Registrazione avvenuta con successo!');
                    window.location.href = '/Bmw/login.html'; 
                } else {
                    document.getElementById('messaggio').innerHTML = "Errore nella registrazione.";
                }
            };

            xhr.onerror = function() {
            document.getElementById('messaggio').innerHTML = "Errore nella connessione al server.";
            };

            xhr.send(formData);
        });

        
    

