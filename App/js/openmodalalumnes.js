export function openModal() {

    console.log("hola")


    const modalsFotos = document.querySelectorAll('.modalFoto');

    modalsFotos.forEach(modal => {

        modal.addEventListener("click", () => {
            const userId = modal.getAttribute('data-user-id');
            // Obtener el elemento del título del modal
            var modalTitle = document.getElementById('modalTitle');
    
            // Actualizar el contenido del título con el valor de userId
            modalTitle.innerText = 'User ID: ' + userId;
    
            // Obtener el elemento de entrada oculta para el user_id en el formulario
            var userIdInput = document.getElementById('userIdInput');
    
            // Actualizar el valor del campo user_id en el formulario
            userIdInput.value = userId;
    
            // Mostrar el modal
            document.getElementById('my_modal_2').showModal();
        })
    })
}

export function closeModal() {
    console.log("holasds");
    // Cerrar el modal
    document.getElementById("modalCancelar").addEventListener(() => {

    })

}



export function searchAlumne() {
    
};