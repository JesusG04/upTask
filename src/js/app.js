document.addEventListener('DOMContentLoaded', function () {
   iniciaApp(); 
});

function iniciaApp(){
    selecionaIconos();//Muestra la contraeña escrita por el usuario
}

function selecionaIconos() {
    const contIconos = document.querySelectorAll('.input-eye');

    contIconos.forEach( contIcono => {
        contIcono.addEventListener('click', function () {
            mostrarContraseña(contIcono);
        });
    });
}
function mostrarContraseña(contIcono) {
    
    const inputPass = contIcono.previousElementSibling;//Selecionamos el elemento previo osea le input del password
    const icono = contIcono.firstElementChild;
         
        if (contIcono.getAttribute("data-password") === "true") {
            inputPass.type = 'password';
            contIcono.setAttribute("data-password", "false");
            icono.classList.remove("fa-solid", "fa-eye-slash");
            contIcono.classList.remove("input-seleccionado");
            icono.classList.add("fa-regular", "fa-eye");
        } else {
            inputPass.type = 'text';
            contIcono.setAttribute("data-password", "true");
            icono.classList.remove("fa-regular", "fa-eye");
            contIcono.classList.add("input-seleccionado");
            icono.classList.add("fa-solid", "fa-eye-slash");       
        }
    };