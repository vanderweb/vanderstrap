<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>
<?php do_action ( 'vanderstrap_site_bottom' ); ?>
<?php do_action ( 'vanderstrap_after_contentsection_custom' ); ?>
<?php do_action ( 'vanderstrap_after_contentsection' ); ?>

<footer class="wrapper" id="wrapper-footer">
	<?php do_action ( 'vanderstrap_footer' ); ?>
</footer><!-- wrapper end -->

<?php do_action ( 'vanderstrap_body_bottom' ); ?>
</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>
<?php do_action ( 'vanderstrap_scripts_footer' ); ?>
</body>

</html>

