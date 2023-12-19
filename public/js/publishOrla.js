$(document).ready(function() {
    // Utilitza una classe en lloc d'un id, ja que els id han de ser únics
    $('.toggle').change(function() {
        var isChecked = $(this).prop('checked');
        // Captura el valor de orlaId del checkbox actual

        var url = '/publish-orla';

        // Mostra l'animació de càrrega
        $('.loading-indicator').show();

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'isPublished': isChecked
            },
            success: function(response) {
                console.log(response);
                console.log("Sol·licitud enviada correctament");

                // Espera 1 segon (1000 mil·lisegons) abans d'amagar l'animació
                setTimeout(function() {
                    // Amaga l'animació de càrrega després d'1 segon
                    $('.loading-indicator').hide();

                    // Recarrega la pàgina després que la sol·licitud AJAX s'hagi completat amb èxit
                    location.reload();
                }, 1000);
            },
            error: function(error) {
                console.log("Error en enviar la sol·licitud");

                // Amaga l'animació de càrrega en cas d'error
                setTimeout(function() {
                    $('.loading-indicator').hide();
                }, 1000);
            }
        });

        if (isChecked) {
            console.log('Public');
        } else {
            console.log('Privat');
        }
    });
});