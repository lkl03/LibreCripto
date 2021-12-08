$(function() {
    $('.publishPModify').on('click', function(e) {
        // $(this) es el elemento que disparó el evento
        let publishContainer = $(this).closest('.publishContainer');
        // Obtener ventana del anuncio y mostrar
        $(publishContainer).find('.overlay').addClass('active');
        $(publishContainer).find('.publishannouncer').addClass('active');
        $(publishContainer).find('.publish').addClass('active');
        //$('.publishmShow').addClass('active');
        $(publishContainer).addClass('active');
    });
    $('.btn-volver').on('click', function(e) {
        let publishContainer = $(this).closest('.publishContainer');
        e.stopPropagation();
        $(this).closest('.overlay').removeClass('active');
        $(this).closest('.publishannouncer').removeClass('active');
        $('.publish').removeClass('active');
        //$('.publishmShow').removeClass('active');
        $(publishContainer).removeClass('active');
        //Esto activa el reset del formulario
        $('#publishform').trigger("reset");
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