document.addEventListener('DOMContentLoaded', function () {
    const menu = document.getElementById('menu');
    const lateralMenu = document.getElementById('lateralMenu');
    const cerrar = document.getElementById('cruz-cerrar');
    const fondoMenu = document.getElementById('backgroundMenu');

    function abrirMenu() {
        lateralMenu.classList.add('active');
        fondoMenu.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function cerrarMenu() {
        lateralMenu.classList.remove('active');
        fondoMenu.classList.remove('active');
        document.body.style.overflow = '';
    }

    menu.addEventListener('click', abrirMenu);
    cerrar.addEventListener('click', cerrarMenu);
    fondoMenu.addEventListener('click', cerrarMenu);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lateralMenu.classList.contains('active')) {
            cerrarMenu();
        }
    });
});