<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function vanderstrap_theme_scripts() {
	
}
//add_action('wp_enqueue_scripts', 'vanderstrap_theme_scripts');

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

////////////////////////////////////////////////////////////////////
// Files
////////////////////////////////////////////////////////////////////
function vanderstrap_files() {
 require_once(get_stylesheet_directory().'/lib/vanderstrap-hooks.php');
	require_once(get_stylesheet_directory().'/lib/customizer.php');
	require_once(get_stylesheet_directory().'/lib/widgets.php');
}
add_action( 'after_setup_theme', 'vanderstrap_files' );

////////////////////////////////////////////////////////////////////
// Register Widget areas
////////////////////////////////////////////////////////////////////
function vanderstrap_remove_widgets(){
 unregister_sidebar( 'footerfull' );
}
add_action( 'widgets_init', 'vanderstrap_remove_widgets', 11 );

function vanderstrap_widgets_init() {
	register_sidebar(
  array(
   'name' => __( 'Topbar', 'understrap-child' ),
   'id' => 'topbarwidget',
   'before_widget' => '<div id="%1$s" class="align-self-center col-auto widget-topbar %2$s">',
   'after_widget' => '</div>',
   'before_title' => '<span class="notitle">',
   'after_title' => '</span>',
  )
 );
	
 register_sidebar(
  array(
   'name' => __( 'Logo Widget', 'understrap-child' ),
   'id' => 'logowidget',
   'before_widget' => '<div id="%1$s" class="widget-logo col-auto align-self-center %2$s">',
   'after_widget' => '</div>',
   'before_title' => '<span class="notitle">',
   'after_title' => '</span>',
  )
 );
	
	register_sidebar(
  array(
   'name' => __( 'Main Menu Widget', 'understrap-child' ),
   'id' => 'navwidget',
   'before_widget' => '<div id="%1$s" class="widget-mainmenu col-auto align-self-center %2$s">',
   'after_widget' => '</div>',
   'before_title' => '<span class="notitle">',
   'after_title' => '</span>',
  )
 );
	
 register_sidebar(
  array(
   'name' => __( 'Slider', 'understrap-child' ),
   'id' => 'slider',
   'before_widget' => '<div id="%1$s" class="widget-slider %2$s">',
   'after_widget' => '</div>',
   'before_title' => '<span class="notitle">',
   'after_title' => '</span>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Section Above 1', 'understrap-child' ),
   'id' => 'section-above-1',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-above-1 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Section Above 2', 'understrap-child' ),
   'id' => 'section-above-2',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-above-2 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Section Above 3', 'understrap-child' ),
   'id' => 'section-above-3',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-above-3 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 
 register_sidebar(
  array(
   'name' => __( 'Content Above', 'understrap-child' ),
   'id' => 'content-above',
   'before_widget' => '<div id="%1$s" class="contentabove widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );

 register_sidebar(
  array(
   'name' => __( 'Content Below', 'understrap-child' ),
   'id' => 'content-below',
   'before_widget' => '<div id="%1$s" class="contentbelow widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 
 register_sidebar(
  array(
   'name' => __( 'Section Below 1', 'understrap-child' ),
   'id' => 'section-below-1',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-below-1 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Section Below 2', 'understrap-child' ),
   'id' => 'section-below-2',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-below-2 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Section Below 3', 'understrap-child' ),
   'id' => 'section-below-3',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-below-3 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 
 register_sidebar(
  array(
   'name' => __( 'Footer Boxes', 'understrap-child' ),
   'id' => 'footerboxes',
   'before_widget' => '<div id="%1$s" class="col-12 col-md footerboxes widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Footer Copyright', 'understrap-child' ),
   'id' => 'footercopyright',
   'before_widget' => '<div id="%1$s" class="col-12 footercopyright widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
}
add_action( 'widgets_init', 'vanderstrap_widgets_init' );

////////////////////////////////////////////////////////////////////
// Functions - Actions and Filters
////////////////////////////////////////////////////////////////////
function vanderstrap_body_class( $classes ) {
 global $post;
 $id = get_current_blog_id();
 $slug = strtolower(str_replace(' ', '-', trim(get_bloginfo('name'))));
 $classes[] .= $slug;
 $classes[] .= 'site-id-'.$id;
 
 if ( wp_is_mobile() ){
  $classes[] .= 'touchscreen';
 } else{
  $classes[] .= 'no-touchscreen';
 }
 if ( is_user_logged_in() ){
  $classes[] .= 'logged-in';
 } else{
  $classes[] .= 'logged-out';
 }

 return $classes;
}
add_filter( 'body_class','vanderstrap_body_class' );