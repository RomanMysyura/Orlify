$(document).ready(function() {
    $(".editorles, .editphoto, .crear_usuari, .notifications").hide();

    $("#editarUsuarioBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles, .editphoto, .notifications").hide();
        $("#editorlesBtn, #editphotoBtn, #crearUsuarioBtn, #notificationsBtn").removeClass("bg-gray-400").addClass(
            "bg-white");

        $(".editar_usuari").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#crearUsuarioBtn").click(function() {
        $(".editar_usuari, .editorles, .editphoto, .notifications").hide();
        $("#editarUsuarioBtn, #editphotoBtn, #editorlesBtn, #notificationsBtn").removeClass("bg-gray-400").addClass(
            "bg-white");

        $(".crear_usuari").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#editorlesBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles, .editphoto, .notifications").hide();
        $("#editarUsuarioBtn, #editphotoBtn,  #crearUsuarioBtn, #notificationsBtn").removeClass("bg-gray-400")
            .addClass("bg-white");

        $(".editorles").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#editphotoBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles, .editphoto , .notifications").hide();
        $("#editarUsuarioBtn, #editorlesBtn,  #crearUsuarioBtn, #notificationsBtn").removeClass("bg-gray-400")
            .addClass("bg-white");

        $(".editphoto").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#notificationsBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles, .editphoto, .notifications").hide();
        $("#editarUsuarioBtn, #editorlesBtn,  #crearUsuarioBtn, #editphotoBtn").removeClass("bg-gray-400")
            .addClass("bg-white");

        $(".notifications").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
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

    $("#crearUsuarioPrueba").click(function() {
        fetch('https://randomuser.me/api/')
            .then(response => response.json())
            .then(data => {
                document.getElementById('mail').value = data.results[0].email;
                document.getElementById('username').value = data.results[0].name.first;
                document.getElementById('surname').value = data.results[0].name.last;
                document.getElementById('birth_date').value = data.results[0].dob.date.substring(0, 10);
                document.getElementById('password').value = 'testing10';
                document.getElementById('role').value = 'Alumne';
            })
            .catch(error => console.error('Error:', error));
    });
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
                addHiddenField(form, 'role', 'Alumne');
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
});
function openEditModal(userId, name, surname, email, phone, dni, birth_date,  role) {
    // Obtén los datos del usuario correspondiente (puedes hacer una solicitud AJAX si es necesario)
    var user = obtenerDatosUsuario(userId, name, surname, email, phone, dni, birth_date,  role);

    // Actualiza el contenido del modal con los datos del usuario
    document.getElementById('user_details').innerHTML = `
        
        

        <div class="w-full max-w-md m-auto bg-gray-100 rounded-md mt-5">
        <form action="/uploadUserAdmin" method="post">
            <input type="hidden" name="id" value="${user.id}">
            <div class="card-body items-center text-center">
                
                <h2 class="text-center text-lg font-bold mb-5">Les meves dades</h2>

                <input type="text" title="name" id="name" name="name"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="Nom" value="${user.name}">

                <input type="text" title="surname" id="surname" name="surname"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="Cognom" value="${user.surname}">

                <input type="text" id="email" title="email" name="email"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="email" value="${user.email}">

                <input type="text" id="phone" title="phone" name="phone"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="telefon" value="${user.phone}">

                <input type="text" id="dni" title="dni" name="dni"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="dni" value="${user.dni}">

                <input type="date" id="birth_date" title="birth_date" name="birth_date"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="data de naixement" value="${user.birth_date}">


             
                    <select id="role" title="role" name="role" class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300">
                    <option value="Alumno" ${user.role === 'Alumne' ? 'selected' : ''}>Alumne</option>
                    <option value="Profesor" ${user.role === 'Professor' ? 'selected' : ''}>Professor</option>
                    <option value="Admin" ${user.role === 'Admin' ? 'selected' : ''}>Admin</option>
                </select>
                <div class="card-actions justify-end mt-5">
                    <button type="submit" class="btn btn-active btn-neutral">Editar</button>
                </div>
            </div>
        </form>
    </div>
    `;

    // Abre el modal
    document.getElementById('edit_modal').showModal();
}

// Función para cerrar el modal
function closeEditModal() {
    document.getElementById('edit_modal').close();
}

// Esta función es solo un ejemplo y deberías reemplazarla con la lógica real para obtener los datos del usuario
function obtenerDatosUsuario(userId, name, surname, email, phone, dni, birth_date,  role) {
    // Aquí puedes hacer una solicitud AJAX al servidor para obtener los datos del usuario
    // Por ahora, devolvemos un objeto con datos de ejemplo
    return {
        id: userId,
        name: name,
        surname: surname,
        email: email,
        phone: phone,
        dni: dni,
        birth_date: birth_date,
        role: role


        
        
    };
}

// Function to create a random user

 