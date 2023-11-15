window.addEventListener('DOMContentLoaded', function() {
    // Verifica se o tamanho da tela é pequeno, indicando um dispositivo móvel
    if (window.innerWidth <= 768 && /Mobi|Android/i.test(navigator.userAgent)) {
        var formLogin = $("#form-login");
        formLogin.animate({height:'100vh'}, "slow");
        formLogin.animate({width:'100vw'}, "slow");

        var boxLogin = $('.box-login');
        boxLogin.css ('display','flex');
        boxLogin.css('align-items','center');
    } else {
        var formLogin = $("#form-login");
        formLogin.animate({height:'400px'}, "slow");
        formLogin.animate({width:'400px'}, "slow");

        var boxLogin = $('.box-login');
        boxLogin.css ('display','flex');
        boxLogin.css('align-items','center');

    }
});

    