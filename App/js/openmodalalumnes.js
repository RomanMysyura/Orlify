// Exporta la funció per obrir el modal
export function openModal() {
    console.log("hola");

    // Obté tots els modals de fotos
    const modalsFotos = document.querySelectorAll('.modalFoto');

    // Afegeix un event listener a cada modal de foto
    modalsFotos.forEach(modal => {
        modal.addEventListener("click", () => {
            // Obté l'ID de l'usuari des de l'atribut data-user-id
            const userId = modal.getAttribute('data-user-id');
            
            // Obté l'element del títol del modal
            var modalTitle = document.getElementById('modalTitle');

            // Actualitza el contingut del títol amb el valor de userId
            modalTitle.innerText = 'ID d\'usuari: ' + userId;

            // Obté l'element d'entrada oculta per al user_id al formulari
            var userIdInput = document.getElementById('userIdInput');
            var UserIdInputEdit = document.getElementById('UserIdInputEdit');

            // Actualitza el valor del camp user_id al formulari
            userIdInput.value = userId;
            UserIdInputEdit.value = userId;

            // Mostra el modal
            document.getElementById('my_modal_2').showModal();
        });
    });
}

// Exporta la funció per tancar el modal
export function closeModal() {
    console.log("holasds");
    // Tanca el modal
    document.getElementById("modalCancelar").addEventListener(() => {
        // Add your logic here to handle modal closure
    });
}

// Exporta la funció per buscar un alumne
export function searchAlumne() {
    
}
