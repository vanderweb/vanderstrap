<!--
	##########################################
	## Vander Web							##
	## https://vander-web.com				##
	##########################################
-->
<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

// action hook for any content placed before the header, including the widget area
do_action ( 'vanderstrap_before_header' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php do_action ( 'vanderstrap_top_header' ); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php do_action ( 'vanderstrap_meta_header' ); ?>
	<?php wp_head(); ?>
	<?php do_action ( 'vanderstrap_bottom_header' ); ?>
    <?php do_action ( 'vanderstrap_scripts_header' ); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action ( 'vanderstrap_scripts_bodytop' ); ?>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">
	<?php do_action ( 'vanderstrap_header' ); ?>
	<?php do_action ( 'vanderstrap_body_top' ); ?>
	<?php do_action ( 'vanderstrap_before_contentsection' ); ?>
	<?php do_action ( 'vanderstrap_before_contentsection_custom' ); ?>
	<?php do_action ( 'vanderstrap_site_top' ); ?>
