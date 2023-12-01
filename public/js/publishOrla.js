$(document).ready(function() {
    // Usa una clase en lugar de un id, ya que los id deben ser únicos
    $('.toggle').change(function() {
        var isChecked = $(this).prop('checked');
        // Captura el valor de orlaId del checkbox actual

        var url = '/publish-orla';

        // Muestra la animación de carga
        $('.loading-indicator').show();

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'isPublished': isChecked
            },
            success: function(response) {
                console.log(response);
                console.log("Solicitud enviada correctamente");

                // Espera 1 segundo (1000 milisegundos) antes de ocultar la animación
                setTimeout(function() {
                    // Oculta la animación de carga después de 1 segundo
                    $('.loading-indicator').hide();

                    // Recarga la página después de que la solicitud AJAX se ha completado con éxito
                    location.reload();
                }, 1000);
            },
            error: function(error) {
                console.log("Error al enviar la solicitud");

                // Oculta la animación de carga en caso de error
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
