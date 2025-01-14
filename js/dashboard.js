document.getElementById('appointmentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Previene l'invio tradizionale del form

    const formData = new FormData(this); // Crea un oggetto FormData con i dati del form

    fetch('../php/dashboard.php', { // Invia una richiesta POST alla stessa pagina
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Ottieni la risposta come json
    .then(data => {
         if (data.success) {
            alert(data.message);
            window.location.href = '/Bmw/login.html'; // Reindirizza solo se l'operazione ha avuto successo
        } else {
            alert('Errore: ' + data.message);
        }
       
    })
    .catch(error => console.error('Errore:', error)); // Gestione degli errori
});