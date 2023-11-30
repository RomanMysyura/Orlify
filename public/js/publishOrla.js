$(document).ready(function() {
    $('#checkboxToggle').change(function() {
        var isChecked = $(this).prop('checked');
        var orlaId = 1; // Adjust this to get the correct orlaId

        var url = '/publish-orla';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'orlaId': orlaId,
                'isPublished': isChecked
            },
            success: function(response) {
                console.log(response);
                console.log("Solicitud enviada correctamente");
            },
            error: function(error) {
                console.log("Error al enviar la solicitud");
            }
        });

        if (isChecked) {
            console.log('Public');
        } else {
            console.log('Privat');
        }
    });
});
