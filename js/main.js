jQuery('document').ready(function($) {

    var menuBtn = $('.menu-movil'),
        menu = $('.navegacion-principal ul');

    menuBtn.click(function() {
        if (menu.hasClass('show')) {
            menu.removeClass('show');
        } else {
            menu.addClass('show');
        }

    });
});


jQuery('document').ready(function($) {

    var menuBtnLog = $('.menu-movil-log'),
        menu = $('.navegacion-principal-log ul');

    menuBtnLog.click(function() {
        if (menu.hasClass('show')) {
            menu.removeClass('show');
        } else {
            menu.addClass('show');
        }

    });
});



jQuery('document').ready(function($) {


    var menuSplit = $('.SplitUser'),
        menu = $('.userpanelMin');

    menuSplit.click(function() {
        if (menu.hasClass('show')) {
            menu.removeClass('show');
            $('.Arrow').removeClass('fas fa-chevron-down').addClass('fas fa-chevron-up');
        } else {
            menu.addClass('show');
            $('.Arrow').removeClass('fas fa-chevron-up').addClass('fas fa-chevron-down');
        }

    });
});






var cripBtn = $('.cripButtonContenedor'),
    crip = $('.cripBody ul');

cripBtn.click(function() {
    if (crip.hasClass('open')) {
        crip.removeClass('open');
    } else {
        crip.addClass('open');
    }

});





var libBtn = $('.libButtonContenedor'),
    lib = $('.libBody ul');

libBtn.click(function() {
    if (lib.hasClass('open')) {
        lib.removeClass('open');
    } else {
        lib.addClass('open');
    }

});





var comBtn = $('.commerceButtonContenedor'),
    com = $('.commerceBody ul');

comBtn.click(function() {
    if (com.hasClass('open')) {
        com.removeClass('open');
    } else {
        com.addClass('open');
    }

});




var regBtn = $('.regButtonContenedor'),
    reg = $('.regBody ul');

regBtn.click(function() {
    if (reg.hasClass('open')) {
        reg.removeClass('open');
    } else {
        reg.addClass('open');
    }

});




var myaccBtn = $('.myaccButtonContenedor'),
    myacc = $('.myaccBody ul');

myaccBtn.click(function() {
    if (myacc.hasClass('open')) {
        myacc.removeClass('open');
    } else {
        myacc.addClass('open');
    }

});



var usuBtn = $('.usuButtonContenedor'),
    usu = $('.usuBody ul');

usuBtn.click(function() {
    if (usu.hasClass('open')) {
        usu.removeClass('open');
    } else {
        usu.addClass('open');
    }

});




var feeBtn = $('.feeButtonContenedor'),
    fee = $('.feeBody ul');

feeBtn.click(function() {
    if (fee.hasClass('open')) {
        fee.removeClass('open');
    } else {
        fee.addClass('open');
    }

});




var calBtn = $('.calButtonContenedor'),
    cal = $('.calBody ul');

calBtn.click(function() {
    if (cal.hasClass('open')) {
        cal.removeClass('open');
    } else {
        cal.addClass('open');
    }

});





var privBtn = $('.privButtonContenedor'),
    priv = $('.privBody ul');

privBtn.click(function() {
    if (priv.hasClass('open')) {
        priv.removeClass('open');
    } else {
        priv.addClass('open');
    }

});




var termBtn = $('.termButtonContenedor'),
    term = $('.termBody ul');

termBtn.click(function() {
    if (term.hasClass('open')) {
        term.removeClass('open');
    } else {
        term.addClass('open');
    }

});




var nc1 = $('.nosotrosContenedor1'),
    tc1 = $('.textColumn.1');

nc1.click(function() {
    if (tc1.hasClass('show') && nc1.hasClass('show')) {
        tc1.removeClass('show'),
            nc1.removeClass('show');
    } else {
        tc1.addClass('show'),
            nc1.addClass('show');
    }

});




var nc2 = $('.nosotrosContenedor2'),
    tc2 = $('.textColumn.2');

nc2.click(function() {
    if (tc2.hasClass('show') && nc2.hasClass('show')) {
        tc2.removeClass('show'),
            nc2.removeClass('show');
    } else {
        tc2.addClass('show'),
            nc2.addClass('show');
    }

});




var nc3 = $('.nosotrosContenedor3'),
    tc3 = $('.textColumn.3');

nc3.click(function() {
    if (tc3.hasClass('show') && nc3.hasClass('show')) {
        tc3.removeClass('show'),
            nc3.removeClass('show');
    } else {
        tc3.addClass('show'),
            nc3.addClass('show');
    }

});



function mostrarPassword() {
    var cambio = document.getElementById("password");
    if (cambio.type == "text") {
        cambio.type = "password";
        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
        cambio.type = "text";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
}

function mostrarPasswordLog() {
    var cambio = document.getElementById("passwordLog");
    if (cambio.type == "text") {
        cambio.type = "password";
        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
        cambio.type = "text";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
}

function mostrarPasswordActual() {
    var cambio = document.getElementById("passActual");
    if (cambio.type == "text") {
        cambio.type = "password";
        $('.iconActual').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
        cambio.type = "text";
        $('.iconActual').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
}

function mostrarPassword1() {
    var cambio = document.getElementById("pass1");
    if (cambio.type == "text") {
        cambio.type = "password";
        $('.icon1').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
        cambio.type = "text";
        $('.icon1').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
}

function mostrarPassword2() {
    var cambio = document.getElementById("pass2");
    if (cambio.type == "text") {
        cambio.type = "password";
        $('.icon2').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
        cambio.type = "text";
        $('.icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
}

function mostrarPasswordNew() {
    var cambio = document.getElementById("pass");
    if (cambio.type == "text") {
        cambio.type = "password";
        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
        cambio.type = "text";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
}