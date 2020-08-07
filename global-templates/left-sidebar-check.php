<?php
/**
 * Left sidebar check.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<?php do_action ( 'vanderstrap_content_wrap_top' ); ?>

<?php do_action ( 'vanderstrap_left_sidebar' ); ?>

<div class="col-md content-area" id="primary">

<?php do_action ( 'vanderstrap_above_loop' ); ?>