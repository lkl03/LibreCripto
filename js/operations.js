var btnAbrirPopup = document.getElementById('confirmopbutton'),
    overlay = document.getElementById('overlay'),
    popup = document.getElementById('publishannouncer'),
    btnCerrarPopup = document.getElementById('btn-cerrar-popup'),
    checkbutton = document.getElementById('userlistchecked'),
    continuebutton = document.getElementById('continuebutton'),
    overlaynew = document.getElementById('newoverlay'),
    popupnew = document.getElementById('newpublishannouncer'),
    newbtnCerrarPopup = document.getElementById('new-btn-cerrar-popup'),
    newcontinuebutton = document.getElementById('publicar'),
    operationsform = document.getElementById('operationsform'),
    usercheck = document.getElementById('usercheck');

btnAbrirPopup.addEventListener('click', function() {
    overlay.classList.add('active');
    popup.classList.add('active');
});

btnCerrarPopup.addEventListener('click', function(e) {
    e.preventDefault();
    overlay.classList.remove('active');
    popup.classList.remove('active');
    operationsform.reset();
});
$(document).ready(function(){
    // Asignar evento a todos los contenedores con clase publishContainer
    $('.userlistcheck').on('change', function(e) {
        var todosOn = $('.userlistcheck:checked').length;
        if (todosOn == '1') {
            continuebutton.disabled = false;
        } else {
            continuebutton.disabled = true;
        }
    });
});
continuebutton.addEventListener('click', function() {
    overlay.classList.remove('active');
    popup.classList.remove('active');
    overlaynew.classList.add('active');
    popupnew.classList.add('active');
});
newbtnCerrarPopup.addEventListener('click', function(e) {
    e.preventDefault();
    overlaynew.classList.remove('active');
    popupnew.classList.remove('active');
    overlay.classList.add('active');
    popup.classList.add('active');
});
$(function() {
    // Asignar evento a todos los contenedores con clase publishContainer
    $('.selectannouncebutton').on('change', function(e) {
        var publitodosOn = $('.selectannouncebutton:checked').length;
        if (publitodosOn == '1') {
            newcontinuebutton.disabled = false;
        } else {
            newcontinuebutton.disabled = true;
        }
    });
});

function P2P(checkP2P) {
    console.log($(checkP2P).val());
};

$('.userlistcheck').on("click", function() {
    $('.usercheck').prop("checked", this.checked);
});