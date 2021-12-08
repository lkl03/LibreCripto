var btnAbrirPopup = document.getElementById('cambiaroverlay'),
    overlay = document.getElementById('emailoverlay'),
    popup = document.getElementById('emailpublishannouncer'),
    btnCerrarPopup = document.getElementById('emailbtn-cerrar-popup'),
    formpublish = document.getElementById('formemail');

btnAbrirPopup.addEventListener('click', function() {
    overlay.classList.add('active');
    popup.classList.add('active');
    formpublish.reset();
});

btnCerrarPopup.addEventListener('click', function(e) {
    e.preventDefault();
    overlay.classList.remove('active');
    popup.classList.remove('active');
    //Esto activa el reset del formulario
    formpublish.reset();
});

var phoneAbrirPopup = document.getElementById('cambiarphoneoverlay'),
    phoneoverlay = document.getElementById('phoneoverlay'),
    phonepopup = document.getElementById('phonepublishannouncer'),
    phonebtnCerrarPopup = document.getElementById('phonebtn-cerrar-popup'),
    phoneformpublish = document.getElementById('formphone');

phoneAbrirPopup.addEventListener('click', function() {
    phoneoverlay.classList.add('active');
    phonepopup.classList.add('active');
    phoneformpublish.reset();
});

phonebtnCerrarPopup.addEventListener('click', function(e) {
    e.preventDefault();
    phoneoverlay.classList.remove('active');
    phonepopup.classList.remove('active');
    //Esto activa el reset del formulario
    phoneformpublish.reset();
});