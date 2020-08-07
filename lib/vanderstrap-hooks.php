<?php
////////////////////////////////////////////////////////////////////
// Hooks in Head
////////////////////////////////////////////////////////////////////
function vanderstrap_favicon() {
    if( get_site_icon_url() != '' ):
    ?>
        <link rel="icon" href="<?php echo get_site_icon_url(); ?>" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo get_site_icon_url(); ?>" type="image/x-icon" />
    <?php
    endif;
}
add_action( 'vanderstrap_meta_header' , 'vanderstrap_favicon', 5 );

////////////////////////////////////////////////////////////////////
// Hooks in Header
////////////////////////////////////////////////////////////////////
function vanderstrap_topbar() {
    if(is_active_sidebar( 'topbarwidget' )):
    ?>
    <div id="vanderstrap-topbar">
        <div class="topbar-container container">
            <div class="topbar-row row justify-content-end">
            <?php
                dynamic_sidebar( 'topbarwidget' );
            ?>
            </div>
        </div>
    </div>
    <?php
    endif;
}
add_action( 'vanderstrap_header' , 'vanderstrap_topbar', 5 );

function vanderstrap_toplogo() {
    $container = get_theme_mod( 'understrap_container_type' );
    $headertoogle = get_option( 'vanderstrap_headertoogle' );
    if($headertoogle == 'logotop'):
    ?>
    <header id="vanderstrap-toplogo">
        <?php do_action ( 'vanderstrap_toplogo_top' ); ?>
        <?php if ( 'container' == $container ) : ?>
		<div class="container">
		<?php endif; ?>
            <div class="toplogo-row row">
                <?php do_action ( 'vanderstrap_toplogo_col_before' ); ?>
                <div class="toplogo-col align-self-center col text-center">
                    <!-- Your site title as branding in the menu -->
                    <?php if ( ! has_custom_logo() ) { ?>
                        <h2 class="toplogo-text">
                            <a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>
                        </h2>
                    <?php } else {
                        the_custom_logo();
                    } ?><!-- end custom logo -->
                </div>
                <?php
                if(is_active_sidebar( 'logowidget' )):
                    dynamic_sidebar( 'logowidget' );
                endif;
                do_action ( 'vanderstrap_toplogo_col_after' );
                ?>
            </div>
        <?php if ( 'container' == $container ) : ?>
        </div><!-- .container -->
        <?php endif; ?>
        <?php do_action ( 'vanderstrap_toplogo_bottom' ); ?>
    </header>
    <?php
    endif;
}
add_action( 'vanderstrap_header' , 'vanderstrap_toplogo', 10 );

function vanderstrap_mainmenu() {
    $container = get_theme_mod( 'understrap_container_type' );
    $headertoogle = get_option( 'vanderstrap_headertoogle' );
    $headersticky = get_option( 'vanderstrap_headersticky' );
    $navposparam = get_option( 'vanderstrap_navpos' );
    $navpos = 'ml-auto';
    $navpos = ($navposparam == 'center') ? 'ml-auto mr-auto' : $navposparam;
    ?>
    <!-- ******************* The Navbar Area ******************* -->
	<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite" class="<?php echo $headersticky; ?>">
		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>
		<nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <?php do_action ( 'vanderstrap_navbar_top' ); ?>
		<?php if ( 'container' == $container ) : ?>
			<div class="container">
		<?php endif; ?>
            <?php do_action ( 'vanderstrap_navbar_before' ); ?>
            <div class="logo">
            <?php if($headertoogle == 'logomain'): ?>
                <!-- Your site title as branding in the menu -->
                <?php if ( ! has_custom_logo() ) { ?>
                    <h2 class="navbar-brand mb-0">
                        <a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>
                    </h2>
                <?php } else {
                    the_custom_logo();
                } ?><!-- end custom logo -->
            <?php endif; ?>
            </div><!-- .container -->
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
            <span class="navbar-toggler-icon"></span>
        </button>

            <!-- The WordPress Menu goes here -->
            <?php wp_nav_menu(
                array(
                    'theme_location'  => 'primary',
                    'container_class' => 'collapse navbar-collapse',
                    'container_id'    => 'navbarNavDropdown',
                    'menu_class'      => 'navbar-nav '.$navpos,
                    'fallback_cb'     => '',
                    'menu_id'         => 'main-menu',
                    'depth'           => 2,
                    'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
                )
            ); ?>
            <?php
            if(is_active_sidebar( 'navwidget' )):
                dynamic_sidebar( 'navwidget' );
            endif;
            do_action ( 'vanderstrap_navbar_after' );
            ?>
        <?php if ( 'container' == $container ) : ?>
            </div><!-- .container -->
        <?php endif; ?>
            <?php do_action ( 'vanderstrap_navbar_bottom' ); ?>
		</nav><!-- .site-navigation -->

	</div><!-- #wrapper-navbar end -->
    <?php
}
add_action( 'vanderstrap_header' , 'vanderstrap_mainmenu', 15 );

////////////////////////////////////////////////////////////////////
// Hooks above Content
////////////////////////////////////////////////////////////////////
function vanderstrap_slider() {
	if (is_active_sidebar( 'slider' ) ) {
	?>
	<section id="vanderstrap-slider">
		<div class="container slider-container">
			<?php dynamic_sidebar( 'slider' ); ?>
		</div>
	</section>
	<?php }
}
add_action( 'vanderstrap_before_contentsection' , 'vanderstrap_slider', 20 );

function vanderstrap_section_above_1() {
	if (is_active_sidebar( 'section-above-1' )) {
    ?>
	<section id="vanderstrap-section-above-1">
		<div class="container section-above-1-container">
			<div class="row section-above-1-row section-row">
				<?php dynamic_sidebar( 'section-above-1' ); ?>
			</div>
		</div>
	</section>
	<?php }
}
add_action( 'vanderstrap_before_contentsection' , 'vanderstrap_section_above_1', 30 );
function vanderstrap_section_above_2() {
	if (is_active_sidebar( 'section-above-2' )) {
    ?>
	<section id="vanderstrap-section-above-2">
		<div class="container section-above-2-container">
			<div class="row section-above-2-row section-row">
				<?php dynamic_sidebar( 'section-above-2' ); ?>
			</div>
		</div>
	</section>
	<?php }
}
add_action( 'vanderstrap_before_contentsection' , 'vanderstrap_section_above_2', 35 );
function vanderstrap_section_above_3() {
	if (is_active_sidebar( 'section-above-3' )) {
    ?>
	<section id="vanderstrap-section-above-3">
		<div class="container section-above-3-container">
			<div class="row section-above-3-row section-row">
				<?php dynamic_sidebar( 'section-above-3' ); ?>
			</div>
		</div>
	</section>
	<?php }
}
add_action( 'vanderstrap_before_contentsection' , 'vanderstrap_section_above_3', 40 );

////////////////////////////////////////////////////////////////////
// Above the Loop
////////////////////////////////////////////////////////////////////
function vanderstrap_contentabove() {
	if (is_active_sidebar( 'content-above' )) { ?>
	<div id="vanderstrap-contentabove">
		<?php dynamic_sidebar( 'content-above' ); ?>
	</div>
	<?php }
}
add_action( 'vanderstrap_above_loop' , 'vanderstrap_contentabove', 10 );

////////////////////////////////////////////////////////////////////
// Sidebars
////////////////////////////////////////////////////////////////////
function vanderstrap_leftsidebarwidgets() {
    $sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
    
    if ( is_active_sidebar( 'left-sidebar' ) AND ('left' === $sidebar_pos || 'both' === $sidebar_pos) ) : ?>
	<?php if ( 'both' === $sidebar_pos ) : ?>
		<div class="col-md-3 widget-area" id="left-sidebar" role="complementary">
	<?php else : ?>
		<div class="col-md-4 widget-area" id="left-sidebar" role="complementary">
	<?php endif; ?>
			<?php do_action ( 'vanderstrap_leftsidebar_abovewidget' ); ?>
			<?php dynamic_sidebar( 'left-sidebar' ); ?>
			<?php do_action ( 'vanderstrap_leftsidebar_belowwidget' ); ?>
		</div><!-- #left-sidebar -->
    <?php endif;
}
add_action( 'vanderstrap_left_sidebar' , 'vanderstrap_leftsidebarwidgets', 10 );

function vanderstrap_rightsidebarwidgets() {
    $sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
    
    if ( is_active_sidebar( 'right-sidebar' ) AND ('right' === $sidebar_pos || 'both' === $sidebar_pos) ) : ?>
	<?php if ( 'both' === $sidebar_pos ) : ?>
		<div class="col-md-3 widget-area" id="right-sidebar" role="complementary">
	<?php else : ?>
		<div class="col-md-4 widget-area" id="right-sidebar" role="complementary">
	<?php endif; ?>
			<?php do_action ( 'vanderstrap_rightsidebar_abovewidget' ); ?>
			<?php dynamic_sidebar( 'right-sidebar' ); ?>
			<?php do_action ( 'vanderstrap_rightsidebar_belowwidget' ); ?>
		</div><!-- #right-sidebar -->
    <?php endif;
}
add_action( 'vanderstrap_right_sidebar' , 'vanderstrap_rightsidebarwidgets', 10 );

////////////////////////////////////////////////////////////////////
// Below the Loop
////////////////////////////////////////////////////////////////////
function vanderstrap_contentbelow() {
    if (is_active_sidebar( 'content-below' )) { ?>
	<div id="vanderstrap-contentbelow">
		<?php dynamic_sidebar( 'content-below' ); ?>
	</div>
	<?php }
}
add_action( 'vanderstrap_below_loop' , 'vanderstrap_contentbelow', 10 );

////////////////////////////////////////////////////////////////////
// Hooks below Content
////////////////////////////////////////////////////////////////////
function vanderstrap_section_below_1() {
	if (is_active_sidebar( 'section-below-1' )) {
    ?>
	<section id="vanderstrap-section-below-1">
		<div class="container section-below-1-container">
			<div class="row section-below-1-row section-row">
				<?php dynamic_sidebar( 'section-below-1' ); ?>
			</div>
		</div>
	</section>
	<?php }
}
add_action( 'vanderstrap_after_contentsection' , 'vanderstrap_section_below_1', 5 );
function vanderstrap_section_below_2() {
	if (is_active_sidebar( 'section-below-2' )) {
    ?>
	<section id="vanderstrap-section-below-2">
		<div class="container section-below-2-container">
			<div class="row section-below-2-row section-row">
				<?php dynamic_sidebar( 'section-below-2' ); ?>
			</div>
		</div>
	</section>
	<?php }
}
add_action( 'vanderstrap_after_contentsection' , 'vanderstrap_section_below_2', 10 );
function vanderstrap_section_below_3() {
	if (is_active_sidebar( 'section-below-3' )) {
    ?>
	<section id="vanderstrap-section-below-3">
		<div class="container section-below-3-container">
			<div class="row section-below-3-row section-row">
				<?php dynamic_sidebar( 'section-below-3' ); ?>
			</div>
		</div>
	</section>
	<?php }
}
add_action( 'vanderstrap_after_contentsection' , 'vanderstrap_section_below_3', 15 );

////////////////////////////////////////////////////////////////////
// Footer Section(Hook located in footer.php)
////////////////////////////////////////////////////////////////////
function vanderstrap_footerboxes() {
    $container = get_theme_mod( 'understrap_container_type' );
    
    if (is_active_sidebar( 'footerboxes' )) {
	?>
	<div id="vanderstrap-footerboxes">
		<div class="footerboxes-container <?php echo esc_attr( $container ); ?>">
			<div class="row footerboxes-row section-row">
				<?php dynamic_sidebar( 'footerboxes' ); ?>
			</div>
		</div>
	</div>
	<?php }
}
add_action( 'vanderstrap_footer' , 'vanderstrap_footerboxes', 5 );
function vanderstrap_footercopyright() {
    $container = get_theme_mod( 'understrap_container_type' );
	?>
	<div id="vanderstrap-footercopyright" class="site-footer">
		<div class="footercopyright-container <?php echo esc_attr( $container ); ?>">
			<div class="row footercopyright-row section-row">
                <?php
                if (is_active_sidebar( 'footercopyright' )) { 
                    dynamic_sidebar( 'footercopyright' );
                }else{
                    ?>
                    <div class="site-info col-12">
						<?php understrap_site_info(); ?>
					</div><!-- .site-info -->
                    <?php
                }
                ?>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'vanderstrap_footer' , 'vanderstrap_footercopyright', 15 );