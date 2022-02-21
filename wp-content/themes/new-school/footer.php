<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package usb-travel
 */

?>


<?php

$currentLink = explode( get_site_url(), get_permalink() )[1];
$link        = '/questionnaire';
$name        = 'Анкета для родителей';

if ( $currentLink != '/' ) {
	$link = '/';
	$name = 'Школа';
}

?>

<footer class="footer">
    <div class="footer__block layout">
        <a href="/" class="footer__item footer__name"><?= get_bloginfo() ?></a>


        <a href="<?= $link ?>" class="footer__item footer__link"><?= $name ?></a>
    </div>
</footer>


<?php wp_footer(); ?>

</body>
</html>
