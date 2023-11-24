$(document).ready(function() {
    $(".editorles, .editphoto, .crear_usuari").hide();

    $("#editarUsuarioBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles, .editphoto").hide();
        $("#editorlesBtn, #editphotoBtn, #crearUsuarioBtn").removeClass("bg-gray-400").addClass(
            "bg-white");

        $(".editar_usuari").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#crearUsuarioBtn").click(function() {
        $(".editar_usuari, .editorles, .editphoto").hide();
        $("#editarUsuarioBtn, #editphotoBtn, #editorlesBtn").removeClass("bg-gray-400").addClass(
            "bg-white");

        $(".crear_usuari").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#editorlesBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles, .editphoto").hide();
        $("#editarUsuarioBtn, #editphotoBtn,  #crearUsuarioBtn").removeClass("bg-gray-400")
            .addClass("bg-white");

        $(".editorles").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#editphotoBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles, .editphoto").hide();
        $("#editarUsuarioBtn, #editorlesBtn,  #crearUsuarioBtn").removeClass("bg-gray-400")
            .addClass("bg-white");

        $(".editphoto").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });
});

$("#crearUsuariosBtn").click(function() {
    var numUsuarios = $("#numUsuarios").val();

    if (numUsuarios && !isNaN(numUsuarios) && numUsuarios > 0) {
        for (var i = 0; i < numUsuarios; i++) {
            crearUsuarioAleatorio();
        }
    } else {
        alert("Please enter a valid number of users.");
    }
});
document.getElementById('crearUsuarioPrueba').addEventListener('click', function() {
    fetch('https://randomuser.me/api/')
        .then(response => response.json())
        .then(data => {
            document.getElementById('mail').value = data.results[0].email;
            document.getElementById('username').value = data.results[0].name.first;
            document.getElementById('surname').value = data.results[0].name.last;
            document.getElementById('birth_date').value = data.results[0].dob.date.substring(0, 10);
            document.getElementById('password').value = 'testing10';
        })
        .catch(error => console.error('Error:', error));
});

// Function to create a random user
function crearUsuarioAleatorio() {
    fetch('https://randomuser.me/api/')
        .then(response => response.json())
        .then(data => {
            // Create a new form for each user
            var form = document.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', '/randomuser');

            // Create hidden input fields for user data
            addHiddenField(form, 'mail', data.results[0].email);
            addHiddenField(form, 'username', data.results[0].name.first);
            addHiddenField(form, 'surname', data.results[0].name.last);
            addHiddenField(form, 'birth_date', data.results[0].dob.date.substring(0, 10));
            addHiddenField(form, 'password', 'testing10');

            // Append the form to the body
            document.body.appendChild(form);

            // Submit the form
            form.submit();

            // Remove the form from the body
            document.body.removeChild(form);
        })
        .catch(error => console.error('Error:', error));
}

// Function to add hidden input field to a form
function addHiddenField(form, name, value) {
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', name);
    input.value = value;
    form.appendChild(input);
}