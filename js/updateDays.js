function updateDays() {
    const meseSelezionato = document.getElementById('mese').value;
    const giornoSelect = document.getElementById('giorno');
    giornoSelect.innerHTML = ''; // Resetta le opzioni dei giorni

    let giorni = 31; // Default per i mesi con 31 giorni

    // Determina il numero di giorni in base al mese selezionato
    if (meseSelezionato === 'Febbraio') {
        giorni = 28; // Ignoriamo gli anni bisestili per semplicità
    } else if (['Aprile', 'Giugno', 'Settembre', 'Novembre'].includes(meseSelezionato)) {
        giorni = 30;
    }

    // Popola il select con i giorni
    for (let i = 1; i <= giorni; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        giornoSelect.appendChild(option);
    }
}

// Chiama la funzione updateDays al caricamento della pagina

document.addEventListener('DOMContentLoaded',updateDays)