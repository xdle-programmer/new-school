<?php

/*
Template Name: Анкета
*/

get_header();

?>


    <div class="parent-auth">
        <div class="parent-auth__form">
            <div class="parent-auth__form-item">
                <div class="placeholder">
                    <input class="input placeholder__input input-mask" data-mask="000000000000" placeholder="Введите номер телефона"
                           data-parent-auth-number
                    >
                    <div class="placeholder__item">Введите номер телефона</div>
                </div>
            </div>
            <div class="parent-auth__form-item">
                <div class="button" data-parent-auth-get-code>Войти</div>
            </div>
        </div>

        <div class="parent-auth__form">
            <div class="parent-auth__form-item">
                <div class="placeholder">
                    <input class="input placeholder__input input-mask" data-mask="000000000000" placeholder="Введите код из СМС"
                           data-parent-auth-code
                    >
                    <div class="placeholder__item">Введите код из СМС</div>
                </div>
            </div>
            <div class="parent-auth__form-item">
                <div class="button" data-parent-auth-send-code>Войти</div>
            </div>
        </div>
    </div>

<?php

get_footer();
