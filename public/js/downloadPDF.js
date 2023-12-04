$(document).ready(function() {
    $('#downloadPDF').on('click', function(e) {
        e.preventDefault();

        var orlaId = $(this).data('id'); 
        console.log('ID de la orla:', orlaId); 

        var url = 'descarregar-orla/' + orlaId;
        console.log('URL:', url);

      
        $('.loading-indicator').show();

        $.ajax({
            url: url,   
            type: 'GET',
            dataType: 'json', 
            success: function(response) {
                console.log(response);
                console.log("Solicitud enviada correctamente");

                
            },
            error: function(error) {
                console.log(error); 
                console.log("Error al enviar la solicitud");

                
                setTimeout(function() {
                    $('.loading-indicator').hide();
                }, 1000);
            }
        });
    });
});
