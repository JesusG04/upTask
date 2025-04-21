(function () {

    obtenerTareas();
    let tareas = [];
    let filtradas = [];

    //Boton para mostrar el Modal de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', function () {
        mostrarFomulario();
    });

    //Busqueda por filtros
    const filtros = document.querySelectorAll('.filtros input[type="radio"]');
    
    filtros.forEach(radio=> {
        radio.addEventListener('input', filtrarTareas);
    })

    function filtrarTareas(e) {
        const filtro = e.target.value;

        if (filtro!== '') {
            filtradas = tareas.filter(tarea => tarea.estado === filtro);
        } else {
            filtradas = [];
        }
        mostrarTareas();
    }

    //Conexion api para obtener las tareas del proyecto 
    async function obtenerTareas() {
        try {
            const id = obtenerProyecto();
            const url = `/api/tasks?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            tareas = resultado.tareas

            //Mostrar las tareas
            mostrarTareas();

        } catch (error) {
            console.log(error);

        }
    }

    function mostrarTareas() {

        limpiarTareas();
        totalPendientes();
        totalCompletadas();

        const arrayTareas = filtradas.length ? filtradas : tareas;

        const estados = {
            0: 'Pendiente',
            1: 'Completa'
        }
        
        const contenedorTareas = document.querySelector('#listado-tareas');


        if (arrayTareas.length === 0) {
            const textNoTareas = document.createElement('LI');
            textNoTareas.textContent = 'No hay Tareas';
            textNoTareas.classList.add('no-tareas');
            contenedorTareas.appendChild(textNoTareas);

            return;
        }

        arrayTareas.forEach(tarea => {
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P')
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.onclick = function () {
                mostrarFomulario(true,{ ...tarea });
            };

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            //Botones
            const btnEstado = document.createElement('BUTTON');
            btnEstado.classList.add('estado-tarea', `${estados[tarea.estado].toLowerCase()}`);
            btnEstado.textContent = estados[tarea.estado];
            btnEstado.dataset.estadoTarea = tarea.estado;
            btnEstado.onclick = function () {
                cambiarEstadoTarea({ ...tarea });
            };


            //Eliminar tareas
            const btnEliminar = document.createElement('BUTTON');
            btnEliminar.classList.add('eliminar-tarea');
            btnEliminar.textContent = 'Eliminar';
            btnEliminar.dataset.idTarea = tarea.id;
            btnEliminar.onclick = function () {
                confirmarEliminar({ ...tarea });
            };

            opcionesDiv.append(btnEstado, btnEliminar);
            contenedorTarea.append(nombreTarea, opcionesDiv);

            contenedorTareas.appendChild(contenedorTarea);

        });

    }

    function mostrarFomulario(editar = false, tarea = {}) {
        
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>${editar ? 'Editar Tarea': 'Nueva Tarea'}</legend>
                <div class="campo">
                    <label for="tarea">Tarea</label>
                    <input 
                        type="text" 
                        name="tarea" 
                        placeholder="${tarea.nombre ? 'Edita la tarea': 'Escribe una nueva tarea'}" 
                        id="tarea" 
                        value="${tarea.nombre ? tarea.nombre: ''}";
                    />
                </div>
        
                <div class="opciones">
                    <input 
                        type="submit" 
                        class="submit-nueva-tarea" 
                        value="${tarea.nombre ? 'Guardar Cambios': 'Añadir Tarea'}"
                    >
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
        `;
        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            const body = document.querySelector('body');
            formulario.classList.add('animar');
            body.classList.add('bloquear-scroll'); 
        }, 0);

        modal.addEventListener('click', function (e) {
            e.preventDefault();

            //Cerrar modal
            if (e.target.classList.contains('cerrar-modal') || e.target.classList.contains('modal')) {
                const formulario = document.querySelector('.formulario');
                const body = document.querySelector('body');
                formulario.classList.add('cerrar');
                body.classList.remove('bloquear-scroll'); 
                
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
            //Boton añadir tarea
            if (e.target.classList.contains('submit-nueva-tarea')) {
                const nombreTarea = document.querySelector('#tarea').value.trim();

                if (nombreTarea === '') {
                    //Mostrar una alerta
                    mostrarAlerta('Por favor, ingresa una tarea', 'error', document.querySelector('.formulario .campo'));
                    return;
                }

                if (editar) {
                    tarea.nombre = nombreTarea
                    actualizarTarea(tarea);
                } else {
                    agregarTarea(nombreTarea);
                }

            }


        });
        document.querySelector('.dashboard').appendChild(modal);
    }

    //Consultamos el servidor para añadir una nueva tarea
    async function agregarTarea(tarea) {
        //Contruir la peticion
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoId', obtenerProyecto());//Obtener el id del proyecto 


        try {
            //URL
            const url = 'http://localhost:3000/api/task';
            //Conectarnos con el servidor 
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();

            if (resultado.tipo === 'exito') {

                Swal.fire ('Creado', resultado.mensaje, 'success');

                const modal = document.querySelector('.modal');
                modal.remove();

                //Agregar el objeto de tarea al global de tareas
                const tareaObj = {
                    id: String(resultado.id),
                    nombre: tarea,
                    estado: "0",
                    proyectoId: resultado.proyectoId
                }

                tareas = [...tareas, tareaObj];//Creamos una copia y le pasamos el nuevo objeto 
                mostrarTareas();
            }

        } catch (error) {
            console.log(error);
        }
    }

    //Cambia la tarea en el objeto que esta en memoria
    function cambiarEstadoTarea(tarea) {
        const estadoTarea = tarea.estado === '0' ? '1' : '0';
        tarea.estado = estadoTarea;
        actualizarTarea(tarea, true);
    }

    //Recibe el objeto de tarea que esta en memoria y lo actualiza en la BD
    async function actualizarTarea(tarea, cambioEstado = false) {

        const { nombre, id, estado, proyectoId } = tarea;

        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());

        try {
            const url = 'http://localhost:3000/api/task/update';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            if (resultado.tipo === 'exito') {

                if (!cambioEstado) {
                    Swal.fire(
                        resultado.mensaje,
                        '',
                        'success'
                    )  
                }
              
                const modal = document.querySelector('.modal');
                if (modal) {
                    modal.remove();
                }
                tareas = tareas.map(tareaMemoria => {

                    if (tareaMemoria.id === id) {
                        tareaMemoria.estado = estado;
                        tareaMemoria.nombre = nombre;
                    }
                    return tareaMemoria;
                });

                mostrarTareas();

            }


        } catch (error) {
            console.log(error);
        }
    }

    function confirmarEliminar(tarea) {
        Swal.fire({
            title: "¿Eliminar Tarea?",
            showCancelButton: true,
            confirmButtonText: "Si",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                eliminarTarea(tarea);
            }
        });
    }

    async function eliminarTarea(tarea) {
        const { nombre, id, estado } = tarea;

        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());

        try {
            const url = 'http://localhost:3000/api/task/delete';

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            })

            const resultado = await respuesta.json();

            if (resultado.resultado) {
                Swal.fire ('Eliminado', resultado.mensaje, 'success');
                tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== id);
                mostrarTareas();
            }

        } catch (error) {
            console.log(error);

        }
    }

    function mostrarAlerta(mensaje, tipo, referencia) {
        //Elimina una alerta previa
        const alertaPrevia = document.querySelector('.alerta');
        if (alertaPrevia) {
            alertaPrevia.remove();
        }

        //Crea una nueva alerta
        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;
        referencia.parentElement.insertBefore(alerta, referencia);

        //Eliminar la alerta despues de 3 segundos
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }

    function obtenerProyecto() {
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }

    function limpiarTareas() {
        const listadoTareas = document.querySelector('#listado-tareas');
        while (listadoTareas.firstChild) {
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }
    
    function totalPendientes() {
        const totalPendientes = tareas.filter(tarea => tarea.estado === "0");
        const pendientesRadio = document.querySelector('#pendientes');

        if (totalPendientes.length === 0) {
            pendientesRadio.disabled = true;
        } else {
            pendientesRadio.disabled = false;
        }
    }

    function totalCompletadas() {
        const totalCompletadas = tareas.filter(tarea => tarea.estado === "1");
        const completadasRadio = document.querySelector('#completadas');

        if (totalCompletadas.length === 0) {
            completadasRadio.disabled = true;
        } else {
            completadasRadio.disabled = false;
        }
    }

})();