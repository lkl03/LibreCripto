var btnAbrirPopup = document.getElementById('btn-publish-popup'),
    overlay = document.getElementById('overlay'),
    popup = document.getElementById('publishannouncer'),
    publish = document.getElementById('publishShow'),
    btnCerrarPopup = document.getElementById('btn-cerrar-popup'),
    formpublish = document.getElementById('publishform');

btnAbrirPopup.addEventListener('click', function() {
    overlay.classList.add('active');
    popup.classList.add('active');
    publish.classList.add('active');
    formpublish.reset();
});

btnCerrarPopup.addEventListener('click', function(e) {
    e.preventDefault();
    overlay.classList.remove('active');
    popup.classList.remove('active');
    publish.classList.remove('active');
    //Esto activa el reset del formulario
    formpublish.reset();
});

var filterAbrirPopup = document.getElementById('filterbutton'),
    filteroverlay = document.getElementById('filteroverlay'),
    filterpublish = document.getElementById('filterpublishannouncer'),
    filterclose = document.getElementById('filterbtn-cerrar-popup');

filterAbrirPopup.addEventListener('click', function() {
    filteroverlay.classList.add('active');
    filterpublish.classList.add('active');
    publish.classList.add('active');
});

filterclose.addEventListener('click', function(e) {
    e.preventDefault();
    filteroverlay.classList.remove('active');
    filterpublish.classList.remove('active');
    publish.classList.remove('active');
});

$(function() {
    // Asignar evento a todos los contenedores con clase publishContainer
    $('.publishContainer').on('click', function(e) {
        // Obtener ventana del anuncio y mostrar
        $(this).find('.publishOverlay').addClass('active');
        $(this).find('.publishannounce').addClass('active');
        $(this).find('.publish').addClass('active');
        $(this).find('.publishCriptoTop').addClass('active');
        $(this).addClass('active');
    });
    // Asignar evento a todos los enlaces con clase btn-cerrar-popup
    $('.btn-cerrar-popup').on('click', function(e) {
        // Detener evento, para evitar abrir nuevamente por la función anterior
        e.stopPropagation();
        // Encontrar padre (elemento con clase overlay y ocultar
        $(this).closest('.publishOverlay').removeClass('active');
        $(this).closest('.publishannounce').removeClass('active');
        $('.publish').removeClass('active');
        $('.publishCriptoTop').removeClass('active');
        $('.publishContainer').removeClass('active');
    });
});

function P2P(checkP2P) {
    ($(checkP2P).val() == "") ? $(checkP2P).val("P2P"): $(checkP2P).val("");
    console.log($(checkP2P).val());
};

function F2F(checkF2F) {
    ($(checkF2F).val() == "") ? $(checkF2F).val("F2F"): $(checkF2F).val("");
    console.log($(checkF2F).val());
};