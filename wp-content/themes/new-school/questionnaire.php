<?php

/*
Template Name: Анкета
*/

get_header();

?>

    <div class="layout layout--small">

        <div class="questionnaire">

            <div class="questionnaire__item">

                <div class="questionnaire__item-title title title--small">
                    Анкета для родителей
                </div>

                <div class="questionnaire__item-text" data-questionnaire-text-about-questionnaire>
                    Описание анкеты и почему мы собираем эту информацию. Секстант, как бы это ни казалось парадоксальным, прочно иллюстрирует межпланетный математический горизонт,
                    при этом плотность Вселенной в 3 * 10 в 18-й степени раз меньше, с учетом некоторой неизвестной добавки скрытой массы. Различное расположение постоянно.
                    Засветка неба параллельна. Космогоническая гипотеза Шмидта позволяет достаточно просто объяснить эту нестыковку, однако магнитное поле колеблет экваториальный
                    перигей.
                </div>

                <div class="questionnaire__item-questions questionnaire__hidden" data-questionnaire-items>

					<?php

					//Получаем все анкеты
					$args = array(
						'post_type'   => 'question',
						'numberposts' => - 1,
					);

					$questions = get_posts( $args );

					$questionsCount   = count( $questions );
					$questionsCounter = 1;


					// Подготовка и сортировка массива
					$questionsArray = array();

					foreach ( $questions as $question ) {
						$meta               = get_post_meta( $question->ID );
						$questionsArrayItem = array();

						$questionsArrayItem['title'] = $question->post_title;
						$questionsArrayItem['order'] = $meta['порядок_в_анкете'][0];
						$questionsArrayItem['max']   = $meta['можно_выбрать_вариантов'][0];

						$options = [];

						for ( $index = 0; $index < 30; $index ++ ) {
							if ( isset( $meta[ 'варианты_ответа_' . $index . '_варианты_ответа' ] ) ) {
								$options[] = $meta[ 'варианты_ответа_' . $index . '_варианты_ответа' ][0];
							}
						}

						$questionsArrayItem['options'] = $options;

						$questionsArray[] = $questionsArrayItem;
					}

					function array_sort( $array, $on, $order = SORT_ASC ) {
						$new_array      = array();
						$sortable_array = array();

						if ( count( $array ) > 0 ) {
							foreach ( $array as $k => $v ) {

								if ( is_array( $v ) ) {
									foreach ( $v as $k2 => $v2 ) {
										if ( $k2 == $on ) {
											$sortable_array[ $k ] = $v2;
										}
									}
								} else {
									$sortable_array[ $k ] = $v;
								}
							}

							switch ( $order ) {
								case SORT_ASC:
									asort( $sortable_array );
									break;
								case SORT_DESC:
									arsort( $sortable_array );
									break;
							}

							foreach ( $sortable_array as $k => $v ) {
								$new_array[ $k ] = $array[ $k ];
							}
						}

						return $new_array;
					}

					$questionsArraySort = array_sort( $questionsArray, 'order', SORT_ASC );

					foreach ( $questionsArraySort as $question ):

						?>

                        <div class="questionnaire__item-question <?= $questionsCounter !== 1 ? 'questionnaire__hidden' : '' ?>" data-questionnaire-item
                             data-questionnaire-item-max="<?= $question['max']; ?>">

                            <div class="questionnaire__item-question-title">
                                <div class="questionnaire__item-question-title-inner"><?= $questionsCounter . '/' . $questionsCount . '. '; ?></div>
                                <div class="questionnaire__item-question-title-inner" data-questionnaire-item-title><?= $question['title']; ?></div>

                            </div>
                            <div class="questionnaire__item-question-subtitle">(можно выбрать вариантов ответов: <?= $question['max']; ?>)</div>

							<?php
							foreach ( $question['options'] as $option ):
								?>

                                <div class="questionnaire__check-box-block">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text"><?= $option ?></span>
                                        </span>
                                    </label>
                                </div>

							<?php
							endforeach;
							?>

                            <div class="questionnaire__check-box-text-block">
                                <label class="checkbox">
                                    <input class="checkbox__input" type="checkbox" data-questionnaire-own-answer>
                                    <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">
                                            </span>
                                        </span>
                                </label>
                                <div class="placeholder placeholder--textarea">
                                    <textarea disabled class="input input--textarea input--blue-border placeholder__input" placeholder="Ваш вариант ответа"></textarea>
                                    <div class="placeholder__item">Ваш вариант ответа</div>
                                </div>
                            </div>

                            <div class="questionnaire__item-buttons">
								<?php
								if ( $questionsCounter > 0 ) {
									echo '<div class="questionnaire__item-button questionnaire__button questionnaire__button--fill" data-questionnaire-item-button-prev>Назад</div>';
								} else {
									echo '<div></div>';
								}

								$questionsCounter ++;
								?>

                                <div class="questionnaire__item-button questionnaire__button questionnaire__button--disabled questionnaire__button--fill"
                                     data-questionnaire-item-button-next>Далее
                                </div>
                            </div>
                        </div>

					<?php


					endforeach;
					?>

                    <div class="questionnaire__about questionnaire__hidden" data-questionnaire-about>
                        <div class="questionnaire__about-title">Расскажите о себе</div>

                        <div class="questionnaire__about-question" data-questionnaire-about-question-wrapper>
                            <div class="questionnaire__about-question-title">В каком классе сейчас учится Ваш ребенок/дети (посещает детский сад)?</div>

                            <div class="questionnaire__about-question-item">
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">посещает детский сад</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">в начальной школе</span>
                                        </span>
                                    </label>
                                    <div class="placeholder">
                                        <input class="input input--blue-border placeholder__input" placeholder="Укажите класс" disabled>
                                        <div class="placeholder__item">Укажите класс</div>
                                    </div>
                                </div>
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">в средней школе </span>
                                        </span>
                                    </label>
                                    <div class="placeholder">
                                        <input class="input input--blue-border placeholder__input" placeholder="Укажите класс" disabled>
                                        <div class="placeholder__item">Укажите класс</div>
                                    </div>
                                </div>
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">в старшей школе</span>
                                        </span>
                                    </label>
                                    <div class="placeholder">
                                        <input class="input input--blue-border placeholder__input" placeholder="Укажите класс" disabled>
                                        <div class="placeholder__item">Укажите класс</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="questionnaire__about-question" data-questionnaire-about-question-wrapper>
                            <div class="questionnaire__about-question-title">Ваш возраст:</div>

                            <div class="questionnaire__about-question-item">
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">до 35 лет;</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">36-45 лет;</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">старше 45 лет</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="questionnaire__about-question" data-questionnaire-about-question-wrapper>
                            <div class="questionnaire__about-question-title">Ваше образование:</div>

                            <div class="questionnaire__about-question-item">
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">среднее;</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">среднее специальное;</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">неполное высшее;</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="questionnaire__about-question-item-inner">
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox">
                                        <span class="checkbox__item">
                                            <span class="checkbox__icon"></span>
                                            <span class="checkbox__text">высшее.</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="questionnaire__about-button questionnaire__button questionnaire__button--disabled questionnaire__button--fill" data-questionnaire-send-result-button>Отправить</div>
                    </div>
                </div>

                <div class="questionnaire__result questionnaire__hidden" data-questionnaire-result>
                    <div class="questionnaire__result-title">Благодарим за Ваши ответы!</div>
                    <a href="/" class="questionnaire__result-button questionnaire__button questionnaire__button--fill">Вернуться на сайт школы</a>
                </div>
            </div>

            <div class="questionnaire__item" data-questionnaire-register>
                <div class="questionnaire__item-title title title--small">
                    Регистрация
                </div>

                <div class="questionnaire__item-inner form-check" data-questionnaire-get-sms-screen data-questionnaire-auth-screen>
                    <div class="questionnaire__input-button-block">
                        <div class="questionnaire__input-button-block-title">Ваш номер телефона</div>
                        <div class="questionnaire__input-button-block-input">

                            <div class="placeholder form-check__field" data-elem="input" data-rule="input-empty">
                                <input class="input placeholder__input input-mask" data-mask="+{7}-000-000-00-00" placeholder="Введите номер телефона"
                                       data-questionnaire-get-sms-input
                                >
                                <div class="placeholder__item">Введите номер телефона</div>
                            </div>

                        </div>
                        <div class="questionnaire__input-button-block-button questionnaire__button form-check__button" data-questionnaire-get-sms-button>Отправить</div>
                    </div>

                    <div class="questionnaire__item-inner-desc">
                        Пожалуйста указывайте действующий номер телефона.<br>
                        На этот номер поступит СМС сообщение с проверочным кодом.
                    </div>

                </div>

                <div class="questionnaire__item-inner form-check questionnaire__hidden" data-questionnaire-send-sms-code-screen data-questionnaire-auth-screen>
                    <div class="questionnaire__input-button-block">
                        <div class="questionnaire__input-button-block-title">Введите полученный код</div>
                        <div class="questionnaire__input-button-block-input">

                            <div class="placeholder form-check__field" data-elem="input" data-rule="input-empty">
                                <input class="input placeholder__input" placeholder="Код"
                                       data-questionnaire-send-sms-code-input
                                >
                                <div class="placeholder__item">Код</div>
                            </div>

                        </div>
                        <div class="questionnaire__input-button-block-button questionnaire__button form-check__button" data-questionnaire-send-sms-code-button>Отправить</div>
                    </div>

                    <div class="questionnaire__item-inner-result questionnaire__hidden" data-questionnaire-send-sms-code-error>Код введен неверно!</div>

                    <div class="questionnaire__item-inner-desc">
                        <div class="questionnaire__item-inner-desc-inner">Введите верный код или измените номер телефона</div>
                        <div class="questionnaire__item-inner-desc-inner questionnaire__item-inner-desc-inner--link" data-questionnaire-back-to-get-sms-code>здесь</div>
                    </div>
                </div>

                <div class="questionnaire__item-inner form-check questionnaire__hidden" data-questionnaire-send-parent-code-screen data-questionnaire-auth-screen>

                    <div class="questionnaire__input-title-block">
                        <div class="questionnaire__input-title-block-item">
                            <div class="questionnaire__input-title-block-item-title">Код родителя</div>
                            <div class="questionnaire__input-title-block-item-input">
                                <div class="placeholder form-check__field" data-elem="input" data-rule="input-empty">
                                    <input class="input placeholder__input" placeholder="Код родителя"
                                           data-questionnaire-send-parent-code-input
                                    >
                                    <div class="placeholder__item">Код родителя</div>
                                </div>
                                <div class="questionnaire__input-title-block-item-desc">
                                    Этот код вы получили от классного руководителя для заполнения этой анкеты
                                </div>

                            </div>
                        </div>

                        <div class="questionnaire__input-title-block-item">
                            <div class="questionnaire__input-title-block-item-title">Имя</div>
                            <div class="questionnaire__input-title-block-item-input">
                                <div class="placeholder form-check__field" data-elem="input" data-rule="input-empty">
                                    <input class="input placeholder__input" placeholder="Имя"
                                           data-questionnaire-send-parent-code-fname
                                    >
                                    <div class="placeholder__item">Имя</div>
                                </div>
                            </div>
                        </div>

                        <div class="questionnaire__input-title-block-item">
                            <div class="questionnaire__input-title-block-item-title">Отчество</div>
                            <div class="questionnaire__input-title-block-item-input">
                                <div class="placeholder form-check__field" data-elem="input" data-rule="input-empty">
                                    <input class="input placeholder__input" placeholder="Отчество"
                                           data-questionnaire-send-parent-code-mname
                                    >
                                    <div class="placeholder__item">Отчество</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="questionnaire__check-box-block form-check__field" data-elem="input" data-rule="checkbox-not-check">
                        <label class="checkbox">
                            <input class="checkbox__input" type="checkbox">
                            <span class="checkbox__item">
                                <span class="checkbox__icon"></span>
                                <span class="checkbox__text">Я даю свое согласие на обработку персональных данных и соглашаюсь с политикой конфиденциальности.</span>
                            </span>
                        </label>
                    </div>


                    <div class="questionnaire__button-center-wrapper">
                        <div class="questionnaire__button questionnaire__button--fill form-check__button" data-questionnaire-send-parent-code-button>Отправить</div>
                    </div>

                    <div class="questionnaire__item-inner-result questionnaire__hidden" data-questionnaire-send-parent-code-error>Код введен неверно!</div>
                </div>
            </div>

        </div>

    </div>

<?php

get_footer();
