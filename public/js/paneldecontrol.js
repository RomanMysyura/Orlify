
// Alternar la descripció quan es prem el botó
function toggleDescription(button) {
    var description = button.previousElementSibling; // Suposant que la descripció és el germà anterior
    description.classList.toggle('hidden');
    button.classList.toggle('bg-gray-400');

    // Alternar el text del botó entre "Mostrar más" i "Mostrar menos"
    var buttonText = button.textContent.trim();
    button.textContent = buttonText === 'Mostrar más' ? 'Mostrar menos' : 'Mostrar más';
}

$(document).ready(function() {
    // Amaga tots els elements que no són el primer
    $(".editorles,  .crear_usuari, .notifications, .editar_grups").hide();

    // Gestionar els botons de la barra lateral
    $("#editarUsuarioBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles, .editar_grups  .notifications").hide();
        $("#editorlesBtn,  #crearUsuarioBtn, #notificationsBtn, #editarGrupsBtn").removeClass("bg-gray-400").addClass(
            "bg-white");

        $(".editar_usuari").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#crearUsuarioBtn").click(function() {
        $(".editar_usuari, .editorles,  .notifications, .editar_grups").hide();
        $("#editarUsuarioBtn,  #editorlesBtn, #notificationsBtn, #editarGrupsBtn").removeClass("bg-gray-400").addClass(
            "bg-white");

        $(".crear_usuari").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#editorlesBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles,  .notifications, .editar_grups").hide();
        $("#editarUsuarioBtn,   #crearUsuarioBtn, #notificationsBtn,#editarGrupsBtn").removeClass("bg-gray-400")
            .addClass("bg-white");

        $(".editorles").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

  
    $("#notificationsBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles,  .notifications, .editar_grups").hide();
        $("#editarUsuarioBtn, #editorlesBtn,  #crearUsuarioBtn, #editarGrupsBtn").removeClass("bg-gray-400")
            .addClass("bg-white");

        $(".notifications").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");
    });

    $("#editarGrupsBtn").click(function() {
        $(".editar_usuari, .crear_usuari, .editorles,  .notifications, .editar_grups").hide();
        $("#editarUsuarioBtn, #editorlesBtn,  #crearUsuarioBtn, #notificationsBtn").removeClass("bg-gray-400")
            .addClass("bg-white");

        $(".editar_grups").show();

        $(this).removeClass("bg-white").addClass("bg-gray-400");

    });
    

   
// Funció per a crear un usuari aleatori
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

    // Funció per crear un buscador de usuaris
    $("#searchInput").on("keyup", function () {
        var searchTerm = $(this).val().toLowerCase();

        $(".userRow").each(function () {
            var currentRowText = $(this).text().toLowerCase();
            var showRow = currentRowText.indexOf(searchTerm) > -1;
            $(this).toggle(showRow);
        });
    });

    
 
});

// Funció per a obrir el modal d'edició
function openEditModal(userId, name, surname, email, phone, dni, birth_date,  role, group) {
    // Obté els dades de l'usuari corresponent 
    var user = obtenerDatosUsuario(userId, name, surname, email, phone, dni, birth_date,  role, group);

    // Actualiza el contingut del modal amb les dades de l'usuari
    document.getElementById('user_details').innerHTML = `
        
        

        <div class="w-full max-w-md m-auto bg-white rounded-md mt-5">
        <form action="/uploadUserAdmin" method="post">
            <input type="hidden" name="id" value="${user.id}">
            <div class="card-body items-center text-center">
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
                    
                    <input type="text" id="group" title="group" name="group"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="grup" value="${user.group}">

                <input type="date" id="birth_date" title="birth_date" name="birth_date"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="data de naixement" value="${user.birth_date}">

              
                
                    <select id="role" title="role" name="role" class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300">
                    <option value="Alumne" ${user.role === 'Alumne' ? 'selected' : ''}>Alumne</option>
                    <option value="Professor" ${user.role === 'Professor' ? 'selected' : ''}>Professor</option>
                    <option value="Equip Directiu" ${user.role === 'Equip Directiu' ? 'selected' : ''}>Equip Directiu</option>
                </select>
                <div class="card-actions justify-end mt-5">
                    <button type="submit" class="btn btn-active btn-neutral">Editar</button>
                </div>
            </div>
        </form>
    </div>
    `;

    // Obre el modal
    document.getElementById('edit_modal').showModal();
}

// Funció per tancar el modal
function closeEditModal() {
    document.getElementById('edit_modal').close();
}

// Obté les dades de l'usuari 
function obtenerDatosUsuario(userId, name, surname, email, phone, dni, birth_date,  role, group) {
    // Retorna un objecte amb les dades de l'usuari
    return {
        id: userId,
        name: name,
        surname: surname,
        email: email,
        phone: phone,
        dni: dni,
        birth_date: birth_date,
        role: role,
        group: group
    };
}

// Funcio per crear un numero d'usuaris aleatoris a partir de el numero que es posa el usuari
$("#crearUsuariosBtn").click(async function () {
    var numUsuarios = $("#numUsuarios").val();

    if (numUsuarios && !isNaN(numUsuarios) && numUsuarios > 0) {
        // Ensenyar el loader
        $("#loader").removeClass("hidden");

        try {
            
            for (var i = 0; i < numUsuarios; i++) {
                await crearUsuarioAleatorio(); // Espera a que es crei l'usuari
            }

           
            window.location.href = "/panel-de-control";
        } catch (error) {
            console.error('Error creating users:', error);
        } finally {
            // Amaga el loader
            $("#loader").addClass("hidden");
        }
    } else {
        alert("Please enter a valid number of users.");
    }
});

// Funció per crear un usuari aleatori
async function crearUsuarioAleatorio() {
    try {
        // Obtenir les dades de l'usuari aleatori
        const response = await fetch('https://randomuser.me/api/');
        const data = await response.json();

        // Crear un formulari per enviar les dades de l'usuari
        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', '/randomuser');

        // Afegir els camps ocults amb les dades de l'usuari
        addHiddenField(form, 'mail', data.results[0].email);
        addHiddenField(form, 'username', data.results[0].name.first);
        addHiddenField(form, 'surname', data.results[0].name.last);
        addHiddenField(form, 'birth_date', data.results[0].dob.date.substring(0, 10));
        addHiddenField(form, 'role', 'Alumne');
        addHiddenField(form, 'password', 'testing10');

        // Afegir el formulari al body
        document.body.appendChild(form);

        // Enviar el formulari
        const formResponse = await fetch('/randomuser', {
            method: 'POST',
            body: new FormData(form),
        });

        // Comprovar que s'ha enviat correctament
        console.log('Form submitted successfully');

        // Eliminar el formulari
        document.body.removeChild(form);
    } catch (error) {
        console.error('Error:', error);
    }
}


// Funció per amagar els inputs de la creació d'usuari
function addHiddenField(form, name, value) { 
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', name);
    input.value = value;
    form.appendChild(input);
}

// Funció per obrir el collapse de les orles y mostrar les fotos
function toggleCollapse(id) {
    console.log("Toggle collapse for ID:", id); 

    const collapseElement = document.getElementById(id);
    if (collapseElement) {
        collapseElement.classList.toggle('hidden');

        if (!collapseElement.classList.contains('hidden')) {
            const orlaId = id.replace('collapse', '');
            const photosContainer = collapseElement.querySelector('.collapse-title');
            const photos = orles[orlaIndex].photos;
            console.log(photos);

            photosContainer.innerHTML = '';

            // Afegir les fotos al contenidor
            photos.forEach(photo => {
                const photoContainer = document.createElement('div');
                photoContainer.classList.add('flex-shrink-0', 'items-center', 'justify-center', 'mx-5');

                const img = document.createElement('img');
                img.src = photo.url;
                img.alt = photo.name;
                img.classList.add('w-32', 'h-32', 'object-cover', 'rounded-lg');

                const p = document.createElement('p');
                p.textContent = photo.name;

                const deleteButton = document.createElement('button');
                deleteButton.classList.add('btn', 'btn-outline', 'btn-error', 'btn-xs');
                deleteButton.innerHTML = '<a href="/eliminarPhoto?id=' + photo.photo_id + '">Eliminar</a>';

                photoContainer.appendChild(img);
                photoContainer.appendChild(p);
                photoContainer.appendChild(deleteButton);
                photosContainer.appendChild(photoContainer);
            });
        } 
        
    }
}


// Funció per obrir el collapse dels usuaris y mostrar les fotos
function toggleCollapse2(id) {
    console.log("Toggle collapse for ID:", id);

    const collapseElement = document.getElementById(id);
    if (collapseElement) {
        collapseElement.classList.toggle('hidden');

        if (!collapseElement.classList.contains('hidden')) {
            const userId = id.replace('collapse', '');
            const photosContainer = collapseElement.querySelector('.collapse-title');
            const photod = users[userIndex].photos;

            photosContainer.innerHTML = '';

            // Afegir les fotos al contenidor
            photod.forEach(photo => {
                const photoContainer = document.createElement('div');
                photoContainer.classList.add('flex-shrink-0', 'items-center', 'justify-center', 'mx-5');

                const img = document.createElement('img');
                img.src = photo.url;
                img.alt = photo.name;
                img.classList.add('w-32', 'h-32', 'object-cover', 'rounded-lg');

                const p = document.createElement('p');
                p.textContent = photo.name;

                const deleteButton = document.createElement('button');
                deleteButton.classList.add('btn', 'btn-outline', 'btn-error', 'btn-xs');
                deleteButton.innerHTML = '<a href="/eliminarPhoto?id=' + photo.photo_id + '">Eliminar</a>';

                photoContainer.appendChild(img);
                photoContainer.appendChild(p);
                photoContainer.appendChild(deleteButton);
                photosContainer.appendChild(photoContainer);
            });
        }
    }
}

// Funció per obrir el modal d'edició
function openEditModal2(orlaid, name, status, url, group_id, group_name) {
    // Obté els dades de la orla corresponent  
    var orla = obtenerDatosOrla(orlaid, name, status, url, group_id, group_name);

    // Actualiza el contingut del modal amb les dades de la orla
    document.getElementById('user_details2').innerHTML = `
    <div class="w-full max-w-md m-auto bg-white rounded-md mt-5">
    <form action="/UploadOrla" method="post">
        <input type="hidden" name="id" value="${orla.orlaid}">
        <div class="card-body items-center text-center">
            <input type="text" title="name" id="name" name="name"
                class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                placeholder="Nom" value="${orla.name}">

                <select id="status" title="status" name="status" class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300">
                <option value="Publica" ${orla.status === 'Publica' ? 'selected' : ''}>Publica</option>
                <option value="Privada" ${orla.status === 'Privada' ? 'selected' : ''}>Privada</option>
            </select>

            <input type="text" id="url" title="url" name="url"
                class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                placeholder="Enllaç" value="${orla.url}">

            <input type="text" id="group_name" title="group_name" name="group_name"
                class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                placeholder="Grup" value="${orla.group_name}">

         
               
            <div class="card-actions justify-end mt-5">
                <button type="submit" class="btn btn-active btn-neutral">Editar</button>
            </div>
        </div>
    </form>
</div>

        
    `;

    // Obre el modal
    document.getElementById('edit_modal2').showModal();
}

// Funció per tancar el modal
function closeEditModal2() {
    document.getElementById('edit_modal2').close();
}

// Obté les dades de la orla
function obtenerDatosOrla(orlaid, name, status, url, group_id, group_name) {
    // Retorna un objecte amb les dades de la orla
    return {
        orlaid: orlaid,
        name: name,
        status: status,
        url: url,
        group_id: group_id,
        group_name: group_name
    };
}

// Funció per obrir el modal d'edició
function openEditModal3(id, name, description) {
    

    // Crea un nou grup 
    document.getElementById('user_details3').innerHTML = `
    <div class="w-full max-w-md m-auto bg-white rounded-md mt-5">
   <form action="/crearGrup" method="post">
    <input type="hidden" name="id" >
        <div class="card-body items-center text-center">
        <input type="text" title="name" id="name" name="name"
        class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
        placeholder="Nom" >
        <div class="card-actions justify-end mt-5">
            <button type="submit" class="btn btn-active btn-neutral">Crear</button>
        </div>
    </div>
    </form>
</div>

        
    `;

    // Obre el modal
    document.getElementById('edit_modal3').showModal();
}

// Funció per tancar el modal
function closeEditModal3() {
    document.getElementById('edit_modal2').close();
}
