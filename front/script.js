document.addEventListener('DOMContentLoaded', function() {
    prueba();
    obtenerUsuarios();
    let popupEliminar = document.getElementById('popupEliminar');
    let popupModificar = document.getElementById('popupModificar');
    let popupAgregar = document.getElementById('popupAgregar');
    let popupAgregar2 = document.getElementById('popupAgregar2');

    let btnEliminar = document.getElementById('eliminarUsuarioBtn');
    let btnModificar = document.getElementById('modificarUsuarioBtn');
    let btnAgregar = document.getElementById('agregarUsuarioBtn');
    let btnAgregar2 = document.getElementById('agregarUsuario2Btn');

    let closeButtons = document.querySelectorAll('.close'); 

    let confirmarEliminarBtn = document.getElementById('confirmarEliminarBtn');
    let confirmarModificarBtn = document.getElementById('confirmarModificarBtn');
    let confirmarAgregarBtn = document.getElementById('confirmarAgregarBtn');
    let confirmarAgregar2Btn = document.getElementById('confirmarAgregar2Btn');

    // Función para abrir el pop-up
    function openPopup(popup) {
        popup.style.display = 'block';
    }

    // Función para cerrar el pop-up
    function closePopup(popup) {
        popup.style.display = 'none';
    }


    // Asignar evento de click para abrir pop-ups
    btnAgregar.addEventListener('click', () => openPopup(popupAgregar));
    btnEliminar.addEventListener('click', () => openPopup(popupEliminar));
    btnModificar.addEventListener('click', () => openPopup(popupModificar));
    btnAgregar2.addEventListener('click', () => openPopup(popupAgregar2));

    // Asignar evento de click a todos los botones de cierre
    closeButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            var popup = event.target.closest('.popup');
            closePopup(popup);
        });
    });

    // Cerrar el pop-up si el usuario hace clic fuera del contenido del pop-up
    window.addEventListener('click', (event) => {
        if (event.target.classList.contains('popup')) {
            closePopup(event.target);
        }
    });

    // Manejar la eliminación del usuario
    confirmarEliminarBtn.onclick = function() {
        let userId = document.getElementById('userIdEliminar').value;
        if (userId) {
            eliminarUsuario(userId);
            document.getElementById("userIdEliminar").value = ""; //Borro el valor buscado para proligidad.
            popupEliminar.style.display = 'none';
        } else {
            alert('Por favor, ingrese un ID de usuario válido.');
        }
    }

    // Manejar la modificación del usuario
    confirmarModificarBtn.onclick = function() {
        let userId = document.getElementById('userIdModificar').value;
        let nombre = document.getElementById('nombreModificar').value;
        let apellido = document.getElementById('apellidoModificar').value;
        let email = document.getElementById('emailModificar').value;
        let celular = document.getElementById('celularModificar').value;
        if (userId && nombre && apellido && email && celular) {
            modificarUsuario(userId, nombre, apellido, email, celular);
            popupModificar.style.display = 'none';
        } else {
            alert('Por favor, complete todos los campos.');
        }
    }

    // Manejar la adicion del usuario
    confirmarAgregarBtn.onclick = function() {
        let nombre = document.getElementById('nombreAgregar').value;
        let apellido = document.getElementById('apellidoAgregar').value;
        let email = document.getElementById('emailAgregar').value;
        let celular = document.getElementById('celularAgregar').value;
        if (nombre && apellido && email && celular) {
            agregarUsuario(nombre, apellido, email, celular);
            popupAgregar.style.display = 'none';
        } else {
            alert('Por favor, complete todos los campos.');
        }
    }
    confirmarAgregar2Btn.onclick = function() {
        let nombre = document.getElementById('nombre').value;
        let apellido = document.getElementById('apellido').value;
        let email = document.getElementById('email').value;
        let celular = document.getElementById('celular').value;
        if (nombre && apellido && email && celular) {
            popupAgregar.style.display = 'none';
        } else {
            alert('Por favor, complete todos los campos.');
        }
    }
});

function prueba(){
    console.log("cargaste la pagina")
}


function obtenerUsuarios() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../back/ListarUsuarios.php', true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            console.log('Respuesta del servidor:', xhr.responseText);
            try {
                let response = JSON.parse(xhr.responseText);
                if (Array.isArray(response)) {
                    // let listaUsuarios = document.getElementById("listaUsuarios");
                    // listaUsuarios.innerHTML = "";

                    // response.forEach(function(usuario) {
                    //     let listItem = document.createElement("li");
                    //     listItem.textContent = "ID: " + usuario.id_usuario + " Nombre: " + usuario.nombre + ", Apellido: " + usuario.apellido + ", Email: " + usuario.email + ", Telefono: " + usuario.celular;
                    //     listaUsuarios.appendChild(listItem);
                    // });

                    let listaUsuarios = document.getElementById("listaUsuarios");
                    listaUsuarios.innerHTML = "";

                    response.forEach(function(usuario) {
                        let row = document.createElement("tr");

                        let cellID = document.createElement("td");
                        cellID.textContent = usuario.id_usuario;
                        row.appendChild(cellID);

                        let cellNombre = document.createElement("td");
                        cellNombre.textContent = usuario.nombre;
                        row.appendChild(cellNombre);

                        let cellApellido = document.createElement("td");
                        cellApellido.textContent = usuario.apellido;
                        row.appendChild(cellApellido);

                        let cellEmail = document.createElement("td");
                        cellEmail.textContent = usuario.email;
                        row.appendChild(cellEmail);

                        let cellTelefono = document.createElement("td");
                        cellTelefono.textContent = usuario.celular;
                        row.appendChild(cellTelefono);

                        listaUsuarios.appendChild(row);
                    });
                } else {
                    console.log("Actualizado");
                    console.error('Error en la respuesta:', response.error);
                    if (response.error) {
                        console.error('Mensaje de error:', response.error);
                    }
                }
            } catch (e) {
                console.error('Error al analizar JSON:', e);
                console.log('Respuesta cruda:', xhr.responseText);
            }
        } else {
            console.error('Error al obtener usuarios:', xhr.statusText);
        }
    };

    xhr.onerror = function() {
        console.error('Error de red al intentar obtener usuarios.');
    };

    xhr.send();
}

function eliminarUsuario(userId) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../back/EliminarUsuario.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
                console.log('Usuario eliminado:', response.message);
                obtenerUsuarios(); // Actualizar la lista de usuarios
            } else {
                alert(response.error || 'Error al eliminar usuario.');
            }
        } else {
            console.error('Error al eliminar usuario:', xhr.statusText);
        }
    };
    
    xhr.onerror = function() {
        console.error('Error de red al intentar eliminar usuario.');
    };
    
    xhr.send(JSON.stringify({ id: userId }));
}

function modificarUsuario(userId, nombre, apellido, email, celular) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../back/ModificarUsuario.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
                console.log('Usuario actualizado:', response.message);
                obtenerUsuarios(); // Actualizar la lista de usuarios
            } else {
                alert(response.error || 'Error al actualizar usuario.');
            }
        } else {
            console.error('Error al actualizar usuario:', xhr.statusText);
        }
    };

    xhr.onerror = function() {
        console.error('Error de red al intentar actualizar usuario.');
    };

    xhr.send(JSON.stringify({ 
        id_usuario: userId, 
        nombre: nombre, 
        apellido: apellido, 
        email: email, 
        celular: celular 
    }));
}

function agregarUsuario(nombre, apellido, email, celular) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../back/AgregarUsuario.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
                console.log('Usuario agregado:', response.message + nombre + " " + apellido + ".");
                obtenerUsuarios(); // Actualizar la lista de usuarios
            } else {
                alert(response.error || 'Error al agregar usuario.');
            }
        } else {
            console.error('Error al agregar usuario:', xhr.statusText);
        }
    };

    xhr.onerror = function() {
        console.error('Error de red al intentar agregar usuario.');
    };

    xhr.send(JSON.stringify({ nombre: nombre, apellido: apellido, email: email, celular: celular }));
}