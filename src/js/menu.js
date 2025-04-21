const mobileMenuBtn = document.querySelector('#mobile-menu');
const cerrarMenuBtn = document.querySelector('#cerrar-menu');
const sidebar = document.querySelector('.sidebar');
const body = document.querySelector('body');


if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function () {
        sidebar.classList.add('mostrar'); 
        body.classList.add('bloquear-scroll'); 
    });
}
if (cerrarMenuBtn) {
    cerrarMenuBtn.addEventListener('click', function () {
        
        sidebar.classList.add('ocultar');
        body.classList.remove('bloquear-scroll');  
        setTimeout(() => {
            sidebar.classList.remove('mostrar'); 
            sidebar.classList.remove('ocultar'); 
        }, 500);
    });
}


const anchoPantalla = document.body.clientWidth;

window.addEventListener('resize', function () {
    const anchoPantalla = document.body.clientWidth;
    if (anchoPantalla >= 768) {
        sidebar.classList.remove('mostrar');
    }
});


