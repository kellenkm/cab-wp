<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Comic_Arts_Brooklyn
 * @since Comic Arts Brooklyn 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!-- <meta name="viewport" content="width=device-width"> -->
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico?v=2" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>?v=12" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/js/bootstrap/css/bootstrap.min.css" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php if ( get_header_image() ) : ?>
	<div id="site-header">
		
	</div>
	<?php endif; ?>

	<div class='parallax-image-wrapper parallax-image-wrapper-100' data-bottom-top='transform:translate3d(0px, 200%, 0px)' data-top-bottom='transform:translate3d(0px, 0%, 0px)'>
      <div class='parallax-image parallax-image-100' data-bottom-top='transform: translate3d(0px, -80%, 0px);' data-top-bottom='transform: translate3d(0px, 80%, 0px);' style='background-image:url(<?php bloginfo('template_directory'); ?>/images/bg-cover.jpg)'></div>
    </div>
    <section class="cover">
        <div class="gap gap-100" style="background-image:url(<?php bloginfo('template_directory'); ?>/images/bg-cover.jpg)"></div>
      </section>

	<div id="main" class="site-main">
