// Afegeix un esdeveniment que s'activa quan es realitza una entrada en el camp de cerca
document.getElementById('searchInput').addEventListener('input', function() {
    // Obté la cadena de cerca i converteix-la a minúscules per a una cerca no sensible a majúscules/minúscules
    var searchQuery = this.value.toLowerCase();
    // Obté totes les files de la taula
    var rows = document.querySelectorAll('.table tbody tr');

    // Itera sobre totes les files de la taula
    rows.forEach(function(row) {
        // Obté el contingut de text de la fila i converteix-lo a minúscules
        var textContent = row.textContent.toLowerCase();
        // Comprova si la cadena de cerca es troba dins del contingut de text de la fila
        if (textContent.includes(searchQuery)) {
            // Si es troba, elimina la classe 'hidden' per fer visible la fila
            row.classList.remove('hidden');
        } else {
            // Si no es troba, afegeix la classe 'hidden' per amagar la fila
            row.classList.add('hidden');
        }
    });
});
