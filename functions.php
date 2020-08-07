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
    load_child_theme_textdomain( 'vanderstrap', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

////////////////////////////////////////////////////////////////////
// Files
////////////////////////////////////////////////////////////////////
function vanderstrap_files() {
 require_once(get_stylesheet_directory().'/lib/vanderstrap-hooks.php');
	require_once(get_stylesheet_directory().'/lib/customizer.php');
	require_once(get_stylesheet_directory().'/lib/widgets.php');
	require_once(get_stylesheet_directory().'/lib/shortcodes.php');
	require_once(get_stylesheet_directory().'/lib/galleryslider.php');
}
add_action( 'after_setup_theme', 'vanderstrap_files' );

////////////////////////////////////////////////////////////////////
// Register Widget areas
////////////////////////////////////////////////////////////////////
function vanderstrap_remove_widgets(){
 unregister_sidebar( 'right-sidebar' );
	unregister_sidebar( 'left-sidebar' );
	unregister_sidebar( 'hero' );
	unregister_sidebar( 'herocanvas' );
	unregister_sidebar( 'statichero' );
	unregister_sidebar( 'footerfull' );
}
add_action( 'widgets_init', 'vanderstrap_remove_widgets', 11 );

function vanderstrap_widgets_init() {
	register_sidebar(
			array(
				'name'          => __( 'Right Sidebar', 'vanderstrap' ),
				'id'            => 'right-sidebar',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Left Sidebar', 'vanderstrap' ),
				'id'            => 'left-sidebar',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	
	register_sidebar(
  array(
   'name' => __( 'Topbar', 'vanderstrap' ),
   'id' => 'topbarwidget',
   'before_widget' => '<div id="%1$s" class="align-self-center col-auto widget-topbar %2$s">',
   'after_widget' => '</div>',
   'before_title' => '<span class="notitle">',
   'after_title' => '</span>',
  )
 );
	
 register_sidebar(
  array(
   'name' => __( 'Logo Widget', 'vanderstrap' ),
   'id' => 'logowidget',
   'before_widget' => '<div id="%1$s" class="widget-logo col-auto align-self-center %2$s">',
   'after_widget' => '</div>',
   'before_title' => '<span class="notitle">',
   'after_title' => '</span>',
  )
 );
	
	register_sidebar(
  array(
   'name' => __( 'Main Menu Widget', 'vanderstrap' ),
   'id' => 'navwidget',
   'before_widget' => '<div id="%1$s" class="widget-mainmenu col-auto align-self-center %2$s">',
   'after_widget' => '</div>',
   'before_title' => '<span class="notitle">',
   'after_title' => '</span>',
  )
 );
	
 register_sidebar(
  array(
   'name' => __( 'Slider', 'vanderstrap' ),
   'id' => 'slider',
   'before_widget' => '<div id="%1$s" class="widget-slider %2$s">',
   'after_widget' => '</div>',
   'before_title' => '<span class="notitle">',
   'after_title' => '</span>',
  )
 );
	
	register_sidebar(
			array(
				'name'          => __( 'Hero Slider', 'vanderstrap' ),
				'id'            => 'hero',
				'description'   => __( 'Hero slider area. Place two or more widgets here and they will slide!', 'vanderstrap' ),
				'before_widget' => '<div class="carousel-item">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Hero Canvas', 'vanderstrap' ),
				'id'            => 'herocanvas',
				'description'   => __( 'Full size canvas hero area for Bootstrap and other custom HTML markup', 'vanderstrap' ),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Top Full', 'vanderstrap' ),
				'id'            => 'statichero',
				'description'   => __( 'Full top widget with dynamic grid', 'vanderstrap' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s dynamic-classes">',
				'after_widget'  => '</div><!-- .static-hero-widget -->',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	
 register_sidebar(
  array(
   'name' => __( 'Section Above 1', 'vanderstrap' ),
   'id' => 'section-above-1',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-above-1 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Section Above 2', 'vanderstrap' ),
   'id' => 'section-above-2',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-above-2 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Section Above 3', 'vanderstrap' ),
   'id' => 'section-above-3',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-above-3 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 
 register_sidebar(
  array(
   'name' => __( 'Content Above', 'vanderstrap' ),
   'id' => 'content-above',
   'before_widget' => '<div id="%1$s" class="contentabove widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );

 register_sidebar(
  array(
   'name' => __( 'Content Below', 'vanderstrap' ),
   'id' => 'content-below',
   'before_widget' => '<div id="%1$s" class="contentbelow widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 
 register_sidebar(
  array(
   'name' => __( 'Section Below 1', 'vanderstrap' ),
   'id' => 'section-below-1',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-below-1 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Section Below 2', 'vanderstrap' ),
   'id' => 'section-below-2',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-below-2 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Section Below 3', 'vanderstrap' ),
   'id' => 'section-below-3',
   'before_widget' => '<div id="%1$s" class="col-12 col-md section-below-3 widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 
	register_sidebar(
		array(
			'name'          => __( 'Footer Full', 'vanderstrap' ),
			'id'            => 'footerfull',
			'description'   => __( 'Full sized footer widget with dynamic grid', 'vanderstrap' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s dynamic-classes">',
			'after_widget'  => '</div><!-- .footer-widget -->',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
 register_sidebar(
  array(
   'name' => __( 'Footer Boxes', 'vanderstrap' ),
   'id' => 'footerboxes',
   'before_widget' => '<div id="%1$s" class="col-12 col-md footerboxes widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
 register_sidebar(
  array(
   'name' => __( 'Footer Copyright', 'vanderstrap' ),
   'id' => 'footercopyright',
   'before_widget' => '<div id="%1$s" class="col-12 footercopyright widget %2$s"><div class="widget-inner">',
   'after_widget' => '</div></div>',
   'before_title' => '<div class="widget-title"><h3>',
   'after_title' => '</h3></div>',
  )
 );
}
add_action( 'widgets_init', 'vanderstrap_widgets_init', 12 );

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