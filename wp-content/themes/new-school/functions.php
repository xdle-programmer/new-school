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

function render_text_block($block)
{
    $class = 'text-block';

    echo '<div class="' . $class . ' layout">';

    echo '<div class="' . $class . '__title">';
    render_title($block['заголовок']);
    echo '</div>';

    echo '<div class="' . $class . '__items">';

    foreach ($block['блок_абзаца'] as $text) {
        echo '<div class="' . $class . '__item">'.$text['абзац'].'</div>';
    }

    echo '</div>';

    echo '</div>';




    echo '<pre>';

    print_r($block);

    echo '</pre>';

}

function render_slider($block)
{

    echo '<pre>';

    print_r($block);

    echo '</pre>';

}

function render_group_numbers($block)
{

    echo '<pre>';

    print_r($block);

    echo '</pre>';

}

function render_img_text_block($block)
{

    echo '<pre>';

    print_r($block);

    echo '</pre>';

    return;

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
