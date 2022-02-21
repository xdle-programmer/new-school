<?php

/*
Template Name: Анкета
*/

get_header();

?>


    <div class="layout">

        <div class="questionnaire">

            <div class="questionnaire__item">

                <div class="questionnaire__item-title title">
                    Анкета для родителей
                </div>

                <div class="questionnaire__item-text">
                    Описание анкеты и почему мы собираем эту информацию. Секстант, как бы это ни казалось парадоксальным, прочно иллюстрирует межпланетный математический горизонт, при этом плотность Вселенной в 3 * 10 в 18-й степени раз меньше, с учетом некоторой неизвестной добавки скрытой массы. Различное расположение постоянно. Засветка неба параллельна. Космогоническая гипотеза Шмидта позволяет достаточно просто объяснить эту нестыковку, однако магнитное поле колеблет экваториальный перигей.
                </div>

            </div>


            <div class="questionnaire__item">
                <div class="questionnaire__item-title title">
                    Регистрация
                </div>

                <div class="questionnaire__item-inner">
                    <div class="questionnaire__input-button-block">
                        <div class="questionnaire__input-button-block-title">Ваш номер телефона</div>
                        <div class="questionnaire__input-button-block-input">

                            <div class="placeholder">
                                <input class="input placeholder__input input-mask" data-mask="+{7}-000-000-00-00" placeholder="Введите номер телефона"
                                       data-questionnaire-number
                                >
                                <div class="placeholder__item">Введите номер телефона</div>
                            </div>

                        </div>
                        <div class="questionnaire__input-button-block-button questionnaire__button" data-questionnaire-get-code>Отправить</div>
                    </div>

                    <div class="questionnaire__item-inner-result">Код введен неверно!</div>

                    <div class="questionnaire__item-inner-desc">
                        Пожалуйста указывайте действующий номер телефона.<br>
                        На этот номер поступит СМС сообщение с проверочным кодом.
                    </div>

                </div>
            </div>

        </div>


    </div>


    <div class="parent-auth">

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
