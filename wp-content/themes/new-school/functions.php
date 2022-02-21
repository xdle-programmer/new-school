<?php
/**
 * new-school functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package usb-travel
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

function render_blocks()
{

    $id = get_the_ID();
    $blocks = get_field('блок', $id);

    foreach ($blocks as $block) {

        if ($block['контент']['тип_блока'] == 'Фото-блок с большой кнопкой') {
            render_img_block_big_button($block['контент']['фото_блок_с_большой_кнопкой']);
        } else if ($block['контент']['тип_блока'] == 'Текстовый блок') {
            render_text_block($block['контент']['текстовый_блок']);
        } else if ($block['контент']['тип_блока'] == 'Слайдер') {
            render_slider($block['контент']['слайдер']);
        } else if ($block['контент']['тип_блока'] == 'Группа чисел') {
            render_group_numbers($block['контент']['группа_чисел']);
        } else if ($block['контент']['тип_блока'] == 'Блок с фотографией и текстом') {
            render_img_text_block($block['контент']['блок_с_фотографией_и_текстом']);
        } else if ($block['контент']['тип_блока'] == 'Фото-блок с маленькой кнопкой') {
            render_img_block_small_button($block['контент']['фото_блок_с_маленькой_кнопкой']);
        }
    }
}

function render_img_block_big_button($block)
{
    $class = 'img-block';

    echo '<div class="' . $class . '">';
    echo '<div class="' . $class . '__background-wrapper">';
    echo '<img class="' . $class . '__background" src="' . $block['фото_на_фон'] . '">';
    echo '</div>';

    echo '<div class="' . $class . '__block layout">';
    echo '<div class="' . $class . '__title-wrapper">';
    echo '<div class="' . $class . '__title">' . $block['заголовок'] . '</div>';
    echo '<div class="' . $class . '__subtitle">' . $block['подзаголовок'] . '</div>';
    echo '</div>';

    echo '<a href="' . $block['ссылка_на_кнопке'] . '" class="' . $class . '__button">' . $block['текст_на_кнопке'] . '</a>';

    echo '<div class="' . $class . '__geometry">';
    echo '<div class="' . $class . '__geometry-elem ' . $class . '__geometry-elem--1"></div>';
    echo '<div class="' . $class . '__geometry-elem ' . $class . '__geometry-elem--2"></div>';
    echo '<div class="' . $class . '__geometry-elem ' . $class . '__geometry-elem--3"></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';


}

function render_img_block_small_button($block)
{
    $class = 'img-block';

    echo '<div class="' . $class . ' ' . $class . '--small">';
    echo '<div class="' . $class . '__background-wrapper">';
    echo '<img class="' . $class . '__background" src="' . $block['фото_на_фон'] . '">';
    echo '</div>';

    echo '<div class="' . $class . '__block layout">';
    echo '<div class="' . $class . '__title-wrapper">';
    echo '<div class="' . $class . '__title">' . $block['заголовок'] . '</div>';
    echo '<div class="' . $class . '__subtitle">' . $block['подзаголовок'] . '</div>';
    echo '</div>';

    echo '<a href="' . $block['ссылка_на_кнопке'] . '" class="' . $class . '__button">' . $block['текст_на_кнопке'] . '</a>';

    echo '<div class="' . $class . '__geometry">';
    echo '<div class="' . $class . '__geometry-elem ' . $class . '__geometry-elem--1"></div>';
    echo '<div class="' . $class . '__geometry-elem ' . $class . '__geometry-elem--2"></div>';
    echo '<div class="' . $class . '__geometry-elem ' . $class . '__geometry-elem--3"></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';


}

function render_text_block($block)
{
    $class = 'text-block';

    echo '<div class="' . $class . ' layout">';

    echo '<div class="' . $class . '__title">';
    render_title($block['заголовок']);
    echo '</div>';

    echo '<div class="' . $class . '__items">';

    foreach ($block['блок_абзаца'] as $text) {
        echo '<div class="' . $class . '__item">' . $text['абзац'] . '</div>';
    }

    echo '</div>';

    echo '</div>';
}

function render_slider($block)
{

    $class = 'slider';

    echo '<div class="' . $class . '">';

    foreach ($block as $slide) {
        echo '<div class="' . $class . '__item">';
        echo '<div class="' . $class . '__item-inner">';

        echo '<div class="' . $class . '__item-img-wrapper">';
        echo '<img class="' . $class . '__item-img" src="' . $slide['слайд']['фото'] . '">';
        echo '</div>';
        echo '<div class="' . $class . '__desc">';
        echo '<div class="' . $class . '__desc-title">' . $slide['слайд']['заголовок'] . '</div>';
        echo '<div class="' . $class . '__desc-text">' . $slide['слайд']['текст'] . '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';

}

function render_group_numbers($block)
{

    $class = 'group-numbers';

    echo '<div class="' . $class . ' layout">';

    echo '<div class="' . $class . '__title">';
    render_title($block['заголовок']);
    echo '</div>';

    echo '<div class="' . $class . '__items ' . $class . '__items--' . $block['количество_блоков_в_линии'] . '">';

    foreach ($block['блок_числа'] as $item) {
        $group = $item['блок_числа'];

        echo '<div class="' . $class . '__item">';
        echo '<div class="' . $class . '__item-number">' . $group['число'] . '</div>';
        echo '<div class="' . $class . '__item-text">' . $group['текст'] . '</div>';
        echo '</div>';
    }

    echo '</div>';

    echo '</div>';

}

function render_img_text_block($block)
{

    $class = 'img-text-block';

    echo '<div class="' . $class . '">';

    echo '<div class="' . $class . '__block layout">';

    echo '<div class="' . $class . '__title">';
    render_title($block['заголовок']);
    echo '</div>';

    echo '<div class="' . $class . '__item">';
    echo '<div class="' . $class . '__item-desc">';
    echo '<div class="' . $class . '__item-desc-text">' . $block['текст'] . '</div>';
    echo '<a href="' . $block['ссылка_на_кнопке'] . '" class="' . $class . '__button">' . $block['текст_на_кнопке'] . '</a>';
    echo '</div>';

    echo '<div class="' . $class . '__img-wrapper">';
    echo '<img class="' . $class . '__img" src="' . $block['фото'] . '">';
    echo '</div>';

    echo '</div>';

    echo '</div>';
    echo '</div>';


}

function render_title($title)
{
    echo '<div class="title">' . $title . '</div>';
}

function loadFrontScripts()
{
    wp_enqueue_script('script', get_template_directory_uri() . '/scripts.js', null, null, true);
//    wp_register_script('load', themplugins_url('/dist/scripts.js', __FILE__));
//    wp_enqueue_script('load');
}

function loadFrontStyles()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
}

function loadAdminStyles()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/admin-style.css');
}

add_action('wp_enqueue_scripts', 'loadFrontStyles');
add_action('wp_enqueue_scripts', 'loadFrontScripts');

add_action('admin_enqueue_scripts', 'loadAdminStyles');


/**
 * Аякс запросы.
 * Запросы для регистрации и проверки кода и телефона
 */

add_action('wp_ajax_ajax_parent_auth', 'ajax_parent_auth');
add_action('wp_ajax_ajax_check_pass', 'ajax_check_pass');

function ajax_parent_auth()
{

    // Получаем номер из запроса
    $number = $_REQUEST['data'];

    // Создаем случайный пароль
    $password = rand(1000, 9999);

    // Проверяем, есть ли юзер с таким номером
    $user = get_user_by('slug', $number);


    if (!$user) {
        $userId = wp_insert_user([
            'user_login' => $number,
        ]);
    } else {
        $userId = $user->ID;
    }

    wp_set_password($password, $userId);

    wp_send_json_success([$userId, $password]);

    // Высылаем пароль по смс

    wp_die();


}

function ajax_check_pass()
{
    $data = json_decode(stripcslashes($_REQUEST['data']), true);

    $userId = $data['userId'];
    $password = $data['password'];

    $user = get_user_by('ID', $userId);
    $hash = $user->data->user_pass;

    if (wp_check_password($password, $hash))
        wp_send_json_success(11111111111);
    else
        wp_send_json_error(
            new WP_Error('-1', '')
        );

    wp_die();

}

/**
 * Вопросы анкеты
 */

add_action('init', 'register_question_post_type');

function register_question_post_type()
{
	$labels = array(
		'name' => _x('Вопросы в анкете', 'post type general name'),
		'singular_name' => _x('Вопрос в анкете', 'post type singular name'),
		'add_new' => 'Добавить вопрос в анкете'
	);

	// Set various pieces of information about the post type
	$args = array(
		'labels' => $labels,
		'description' => 'Вопросы в анкете',
		'public' => true,
		'menu_icon' => 'dashicons-editor-help'
	);

	register_post_type('question', $args);
}

/**
 * Вопросы анкеты
 */

add_action('init', 'register_answers_post_type');

function register_answers_post_type()
{
	$labels = array(
		'name' => _x('Ответы на анкету', 'post type general name'),
		'singular_name' => _x('Ответ на анкету', 'post type singular name'),
		'add_new' => 'Добавить ответ на анкету'
	);

	// Set various pieces of information about the post type
	$args = array(
		'labels' => $labels,
		'description' => 'Ответы на анкету',
		'public' => true,
		'menu_icon' => 'dashicons-editor-spellcheck'
	);

	register_post_type('answers', $args);
}
