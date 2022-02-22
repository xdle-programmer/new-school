<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package usb-travel
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php

$currentLink = explode( get_site_url(), get_permalink() )[1];
$link        = '/questionnaire';
$name        = 'Анкета для родителей';

if ( $currentLink != '/' ) {
	$link = '/';
	$name = 'Школа';
}

?>

<header class="header">
    <div class="header__block layout">
        <a href="/" class="header__item header__name"><?= get_bloginfo() ?></a>


        <a href="<?= $link ?>" class="header__item header__link"><?= $name ?></a>
    </div>
</header>

<div class="content">
