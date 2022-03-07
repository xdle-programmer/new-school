<?php
/**
 * new-school functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package usb-travel
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

function render_blocks() {

	$id     = get_the_ID();
	$blocks = get_field( 'блок', $id );

	foreach ( $blocks as $block ) {

		if ( $block['контент']['тип_блока'] == 'Фото-блок с большой кнопкой' ) {
			render_img_block_big_button( $block['контент']['фото_блок_с_большой_кнопкой'] );
		} else if ( $block['контент']['тип_блока'] == 'Текстовый блок' ) {
			render_text_block( $block['контент']['текстовый_блок'] );
		} else if ( $block['контент']['тип_блока'] == 'Слайдер' ) {
			render_slider( $block['контент']['слайдер'] );
		} else if ( $block['контент']['тип_блока'] == 'Группа чисел' ) {
			render_group_numbers( $block['контент']['группа_чисел'] );
		} else if ( $block['контент']['тип_блока'] == 'Блок с фотографией и текстом' ) {
			render_img_text_block( $block['контент']['блок_с_фотографией_и_текстом'] );
		} else if ( $block['контент']['тип_блока'] == 'Фото-блок с маленькой кнопкой' ) {
			render_img_block_small_button( $block['контент']['фото_блок_с_маленькой_кнопкой'] );
		}
	}
}

function render_img_block_big_button( $block ) {
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

function render_img_block_small_button( $block ) {
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

function render_text_block( $block ) {
	$class = 'text-block';

	echo '<div class="' . $class . ' layout">';

	echo '<div class="' . $class . '__title">';
	render_title( $block['заголовок'] );
	echo '</div>';

	echo '<div class="' . $class . '__items">';

	foreach ( $block['блок_абзаца'] as $text ) {
		echo '<div class="' . $class . '__item">' . $text['абзац'] . '</div>';
	}

	echo '</div>';

	echo '</div>';
}

function render_slider( $block ) {

	$class = 'slider';

	echo '<div class="' . $class . '">';

	foreach ( $block as $slide ) {
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

function render_group_numbers( $block ) {

	$class = 'group-numbers';

	echo '<div class="' . $class . ' layout">';

	echo '<div class="' . $class . '__title">';
	render_title( $block['заголовок'] );
	echo '</div>';

	echo '<div class="' . $class . '__items ' . $class . '__items--' . $block['количество_блоков_в_линии'] . '">';

	foreach ( $block['блок_числа'] as $item ) {
		$group = $item['блок_числа'];

		echo '<div class="' . $class . '__item">';
		echo '<div class="' . $class . '__item-number">' . $group['число'] . '</div>';
		echo '<div class="' . $class . '__item-text">' . $group['текст'] . '</div>';
		echo '</div>';
	}

	echo '</div>';

	echo '</div>';

}

function render_img_text_block( $block ) {

	$class = 'img-text-block';

	echo '<div class="' . $class . '">';

	echo '<div class="' . $class . '__block layout">';

	echo '<div class="' . $class . '__title">';
	render_title( $block['заголовок'] );
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

function render_title( $title ) {
	echo '<div class="title">' . $title . '</div>';
}

function loadFrontScripts() {
	wp_enqueue_script( 'script', get_template_directory_uri() . '/scripts.js', null, null, true );
}

function loadFrontStyles() {
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
}

function loadAdminStyles() {
	wp_enqueue_style( 'style', get_template_directory_uri() . '/admin-style.css' );
}

add_action( 'wp_enqueue_scripts', 'loadFrontStyles' );
add_action( 'wp_enqueue_scripts', 'loadFrontScripts' );

add_action( 'admin_enqueue_scripts', 'loadAdminStyles' );


/**
 * Аякс запросы.
 * Запросы для регистрации и проверки кода и телефона
 */

add_action( 'wp_ajax_nopriv_ajax_parent_auth', 'ajax_parent_auth' );
add_action( 'wp_ajax_nopriv_ajax_check_pass', 'ajax_check_pass' );
add_action( 'wp_ajax_nopriv_ajax_check_parent_code', 'ajax_check_parent_code' );
add_action( 'wp_ajax_nopriv_ajax_get_answers', 'ajax_get_answers' );

function ajax_parent_auth() {

	// Получаем номер из запроса
	$number = preg_replace( '/[^0-9]/', '', $_REQUEST['data'] );

	// Создаем случайный пароль
	$password = rand( 1000, 9999 );

	// Проверяем, есть ли юзер с таким номером
	$user = get_user_by( 'login', $number );

	if ( ! $user ) {
		$userId = wp_insert_user( [
			'user_login' => $number,
		] );
	} else {
		$userId = $user->ID;
	}

	wp_set_password( $password, $userId );

	wp_send_json_success( [ $userId, $password ] );

	// Высылаем пароль по смс

	wp_die();


}

function ajax_check_pass() {
	$data = json_decode( stripcslashes( $_REQUEST['data'] ), true );

	$userId   = $data['userId'];
	$password = $data['password'];

	$user = get_user_by( 'ID', $userId );
	$hash = $user->data->user_pass;

	if ( wp_check_password( $password, $hash ) ) {
		wp_send_json_success( true );
	} else {
		wp_send_json_error(
			new WP_Error( '-1', '' )
		);
	}

	wp_die();

}

function ajax_check_parent_code() {
	$data = json_decode( stripcslashes( $_REQUEST['data'] ), true );

	$parentCode = $data['parentCode'];
	$fname      = $data['fname'];
	$mname      = $data['mname'];
	$userId     = $data['userId'];

	$currentParentCode     = get_user_meta( $userId, 'parent_code', true );
	$parentCodeFromList    = get_page_by_title( $parentCode, 'ARRAY_A', 'parent_code' );
	$parentCodeErrorCounts = (integer) get_user_meta( $userId, 'error_counts', true );

	if ( $parentCodeErrorCounts > 2 ) {
		wp_send_json_error(
			new WP_Error( '-1', 'Неправильный код введен три раза. Для прохождения анкеты обратитесь на почту info@новаяшкола.рф для уточнения данных ученика в нашей базе данных' )
		);

		wp_die();
	}

	if ( ! $parentCodeFromList ) {
		update_user_meta( $userId, 'error_counts', $parentCodeErrorCounts + 1 );

		wp_send_json_error(
			new WP_Error( '-1', 'Неправильный код. Осталось попыток: ' . ( 3 - $parentCodeErrorCounts ) )
		);
	} else {
		if ( $parentCodeFromList['post_status'] == 'publish' ) {
			update_user_meta( $userId, 'parent_code', $parentCode );
			update_user_meta( $userId, 'fname', $fname );
			update_user_meta( $userId, 'mname', $mname );
			$parentCodePost                = array();
			$parentCodePost['ID']          = $parentCodeFromList['ID'];
			$parentCodePost['post_status'] = 'trash';

			// Обновляем данные в БД
			wp_update_post( wp_slash( $parentCodePost ) );

			wp_send_json_success();
		} else {
			update_user_meta( $userId, 'error_counts', $parentCodeErrorCounts + 1 );

			wp_send_json_error(
				new WP_Error( '-1', 'Неправильный код. Осталось попыток: ' . ( 3 - $parentCodeErrorCounts ) )
			);
		}

	}

	wp_die();
}

function ajax_get_answers() {
	$data = json_decode( stripcslashes( $_REQUEST['data'] ), true );

//	wp_send_json_success(  $data['answers'] );

	$answerPost = array(
		'post_title'   => 'Ответ на анкету',
		'post_content' => json_encode( $data['answers'], JSON_UNESCAPED_UNICODE ),
		'post_status'  => 'publish',
		'post_type'    => 'answers',
		'post_author'  => $data['userId']
	);

	// добавляем пост и получаем его ID
	$newPostId = wp_insert_post( $answerPost );

	update_user_meta( $data['userId'], 'about', json_encode( $data['about'], JSON_UNESCAPED_UNICODE ) );

	wp_send_json_success( json_encode( $data['answers'] ) );

	wp_die();
}

/**
 * Вопросы анкеты
 */

add_action( 'init', 'register_question_post_type' );

function register_question_post_type() {
	$labels = array(
		'name'          => _x( 'Вопросы в анкете', 'post type general name' ),
		'singular_name' => _x( 'Вопрос в анкете', 'post type singular name' ),
		'add_new'       => 'Добавить вопрос в анкете'
	);

	// Set various pieces of information about the post type
	$args = array(
		'labels'      => $labels,
		'description' => 'Вопросы в анкете',
		'public'      => true,
		'menu_icon'   => 'dashicons-editor-help'
	);

	register_post_type( 'question', $args );
}

/**
 * Ответы анкеты
 */

add_action( 'init', 'register_answers_post_type' );

function register_answers_post_type() {
	$labels = array(
		'name'          => _x( 'Ответы на анкету', 'post type general name' ),
		'singular_name' => _x( 'Ответ на анкету', 'post type singular name' ),
		'add_new'       => 'Добавить ответ на анкету'
	);

	// Set various pieces of information about the post type
	$args = array(
		'labels'      => $labels,
		'description' => 'Ответы на анкету',
		'public'      => true,
		'menu_icon'   => 'dashicons-editor-spellcheck'
	);

	register_post_type( 'answers', $args );
}

/**
 * Родительские коды
 */

add_action( 'init', 'register_parent_code_post_type' );

function register_parent_code_post_type() {
	$labels = array(
		'name'          => _x( 'Родительские коды', 'post type general name' ),
		'singular_name' => _x( 'Родительский код', 'post type singular name' ),
		'add_new'       => 'Добавить родительский код'
	);

	// Set various pieces of information about the post type
	$args = array(
		'labels'      => $labels,
		'description' => 'Родительские коды',
		'public'      => true,
		'menu_icon'   => 'dashicons-welcome-learn-more'
	);

	register_post_type( 'parent_code', $args );
}

/**
 * Кастомная страница респондентов
 */

add_action( 'admin_menu', 'respondents_register_admin_page' );

function respondents_register_admin_page() {

	add_menu_page(
		'Респонденты',
		'Респонденты',
		'publish_posts',
		'respondents',
		'respondents_render_admin_page',
		'dashicons-admin-users'
	);
}

function respondents_render_admin_page() {
	include get_template_directory() . '/respondents.php';
}

/**
 * Кастомная страница ответов на анкеты
 */

add_action( 'admin_menu', 'answers_result_register_admin_page' );

function answers_result_register_admin_page() {

	add_menu_page(
		'Результаты опроса',
		'Результаты опроса',
		'publish_posts',
		'answers_result',
		'answers_result_render_admin_page',
		'dashicons-editor-spellcheck'
	);
}

function answers_result_render_admin_page() {
	include get_template_directory() . '/answers_result.php';
}

/**
 * Удаляем пункты меню
 */


add_action( 'admin_init', 'remove_menu_pages_for_editors' );

function remove_menu_pages_for_editors() {

	global $user_ID;

	$roles = get_userdata( $user_ID )->roles;

	if ( in_array( 'editor', $roles, true ) ) {
		remove_menu_page( 'index.php' );
		remove_menu_page( 'edit.php' );
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'edit.php?post_type=question' );
		remove_menu_page( 'edit.php?post_type=answers' );
		remove_menu_page( 'profile.php' );
		remove_menu_page( 'tools.php' );
	}
}

/**
 * Настройки админки.
 * Управляем настройками меню, добавляем стили
 */
function wpse_custom_menu_order( $menu_ord ) {
	if ( ! $menu_ord ) {
		return true;
	}

	return array(
		'edit.php?post_type=page', // Страницы
		'upload.php', // Медиа

		'separator1',

		'respondents',
		'answers_result',

		'separator2',  // Разделитель
	);
}

add_filter( 'custom_menu_order', 'wpse_custom_menu_order', 10, 1 );

add_filter( 'menu_order', 'wpse_custom_menu_order', 10, 1 );

function admin_styles() {
	wp_register_style( 'admin-styles', get_stylesheet_directory_uri() . '/admin/style.css' );
	wp_enqueue_style( 'admin-styles' );
}

function admin_scripts() {
//	wp_register_style('admin-styles', get_stylesheet_directory_uri() . '/admin/style.css');
//	wp_enqueue_style('admin-styles');
	wp_enqueue_script( 'script', get_template_directory_uri() . '/scripts.js', null, null, true );
}

add_action( 'admin_enqueue_scripts', 'admin_scripts' );
