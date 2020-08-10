<?php
////////////////////////////////////////////////////////////////////
// Adds Custom Post Type.
////////////////////////////////////////////////////////////////////
function vanderstrap_slides_post_types() {
	$labels = array(
		'name'               => __( 'Slider and Gallery', 'vanderstrap' ),
		'singular_name'      => __( 'Slider and Gallery', 'vanderstrap' ),
		'menu_name'          => __( 'Slider and Gallery', 'vanderstrap' ),
		'name_admin_bar'     => __( 'Slider and Gallery', 'vanderstrap' ),
		'add_new'            => __( 'Add new', 'vanderstrap' ),
		'add_new_item'       => __( 'Add new image', 'vanderstrap' ),
		'new_item'           => __( 'New image', 'vanderstrap' ),
		'edit_item'          => __( 'Edit image', 'vanderstrap' ),
		'view_item'          => __( 'Show', 'vanderstrap' ),
		'all_items'          => __( 'Slider and Gallery', 'vanderstrap' ),
		'search_items'       => __( 'Search images', 'vanderstrap' ),
		'parent_item_colon'  => __( 'Parent images:', 'vanderstrap' ),
		'not_found'          => __( 'No images found.', 'vanderstrap' ),
		'not_found_in_trash' => __( 'No trashed images found.', 'vanderstrap' )
	);

	$args = array( 
		'public'      => false, 
		'labels'      => $labels,
  'has_archive' => false,
		'description' => __( 'Slider and Gallery', 'vanderstrap' ),
  'show_ui'	        => true,
  'show_in_admin_bar' => true,
		'menu_position' => 25.2,
		'menu_icon' => 'dashicons-id',
  'taxonomies' => array( 'vanderstrap_slides_cats' ),
  'exclude_from_search' => true,
  'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes' )
	);
    	register_post_type( 'vanderstrap_slides', $args );
}
add_action( 'init', 'vanderstrap_slides_post_types' );

////////////////////////////////////////////////////////////////////
// Adds Custom Category.
////////////////////////////////////////////////////////////////////
function create_vanderstrap_slides_taxonomy() {
	$labels = array(
		'name'                           => __( 'Slider and Gallery - Categories', 'vanderstrap' ),
		'singular_name'                  => __( 'Slider and Gallery - Categories', 'vanderstrap' ),
		'search_items'                   => __( 'Search Categories', 'vanderstrap' ),
		'all_items'                      => __( 'All Categories', 'vanderstrap' ),
		'edit_item'                      => __( 'Edit Category', 'vanderstrap' ),
		'update_item'                    => __( 'Update Category', 'vanderstrap' ),
		'add_new_item'                   => __( 'Add new Category', 'vanderstrap' ),
		'new_item_name'                  => __( 'New Category Name', 'vanderstrap' ),
		'menu_name'                      => __( 'Categories', 'vanderstrap' ),
		'view_item'                      => __( 'Show Category', 'vanderstrap' ),
		'popular_items'                  => __( 'Popular Categories', 'vanderstrap' ),
		'separate_items_with_commas'     => __( 'Seperate Categories with commas', 'vanderstrap' ),
		'add_or_remove_items'            => __( 'Add or Remove Categories', 'vanderstrap' ),
		'choose_from_most_used'          => __( 'Select from the mosu used Categories', 'vanderstrap' ),
		'not_found'                      => __( 'No Categories found', 'vanderstrap' )
	);
	$args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud' => false,
        'show_admin_column' => true
	);
    register_taxonomy( 'vanderstrap_slides_cats', array( 'vanderstrap_slides' ), $args );
}
add_action( 'init', 'create_vanderstrap_slides_taxonomy', 0 );

////////////////////////////////////////////////////////////////////
// Custom Meta Box and Fields
////////////////////////////////////////////////////////////////////
function vanderstrap_slides_add_custom_box(){
	$screens = ['vanderstrap_slides'];
	foreach ($screens as $screen) {
		add_meta_box(
			'vanderstrap_slides_box_id',           // Unique ID
			__( 'Link', 'vanderstrap' ), // Box title
			'vanderstrap_slides_box_html',  // Content callback, must be of type callable
			$screen,                   // Post type
			'advanced', // Context: normal, advanced, or side
			'high' // Priority: high, core, default, or low
		);
	}
}
add_action('add_meta_boxes', 'vanderstrap_slides_add_custom_box');

function vanderstrap_slides_box_html($post){
	$value_link = get_post_meta($post->ID, '_vanderstrap_link_meta_key', true);
	$value_linktarget = get_post_meta($post->ID, '_vanderstrap_linktarget_meta_key', true);
	?>
	<label for="vanderstrap_link_field"><?php echo __( 'Link', 'vanderstrap' )?></label><br />
 <input type="text" name="vanderstrap_link_field" id="vanderstrap_link_field" value="<?php if ( isset ( $value_link ) ) echo $value_link; ?>" />
	<br /><br />
	<label for="vanderstrap_linktarget_field"><?php echo __( 'Link Target', 'vanderstrap' )?></label><br />
	<select name="vanderstrap_linktarget_field" id="vanderstrap_linktarget_field" class="postbox">
		<option value="">Samme side</option>
		<option value="_blank" <?php selected($value_linktarget, '_blank'); ?>>Ny side</option>
	</select>
	<?php
}
function vanderstrap_slides_save_postdata($post_id){
	
	if (array_key_exists('vanderstrap_link_field', $_POST)) {
		update_post_meta( $post_id, '_vanderstrap_link_meta_key', sanitize_text_field( $_POST[ 'vanderstrap_link_field' ] ) );
	}
	if (array_key_exists('vanderstrap_linktarget_field', $_POST)) {
		update_post_meta($post_id, '_vanderstrap_linktarget_meta_key', $_POST['vanderstrap_linktarget_field']);
	}
}
add_action('save_post', 'vanderstrap_slides_save_postdata');

////////////////////////////////////////////////////////////////////
// Subpage
////////////////////////////////////////////////////////////////////
function vanderstrapslider_shortcodes_menu() {
	add_submenu_page(
		'edit.php?post_type=vanderstrap_slides',
		'Slider and Gallery - Shortcodes',
		'Shortcodes',
		'manage_options',
		'vanderstrap-slides-shortcodes',
		'vanderstrap_slides_shortcodes'
	);
}
add_action( 'admin_menu', 'vanderstrapslider_shortcodes_menu' );

function vanderstrap_slides_shortcodes() {
	if ( !current_user_can( 'manage_options' ) )  {
	 wp_die('You do not have sufficient permissions to access this page.');
	}
	//get our global options
	global $developer_uri;
	$terms = get_terms( array( 
		'taxonomy' => 'vanderstrap_slides_cats',
	) );
	$slugs = '';
	$galleries = '';
	if( !empty( $terms ) && !is_wp_error( $terms )){
		foreach( $terms as $term ) {
			$sliders .= '[vanderstrapslider slug="'.$term->slug.'"]<br />';
			$galleries .= '[vanderstrapgallery slug="'.$term->slug.'"]<br />';
		}
	}else{
		$slugs = '[vanderstrapslider slug="your-category-slug"]';
		$galleries = '[vanderstrapgallery slug="your-category-slug"]';
	}
	
	// html
	echo '<h1>Slider and Gallery - Shortcodes</h1>';
	echo '<hr />';
	echo '<h3>Slider</h3>';
	echo '<p>';
	echo $sliders;
	echo '</p>';
	echo '<p><b>Shortcode attributes:</b></p>';
	echo '<p>class=""</p>';
	echo '<p>count="50"</p>';
	echo '<p>order="ASC" <br />( ASC, DESC )</p>';
	echo '<p>orderby="menu_order" <br />( none, ID, author, title, name, type, date, modified, parent, rand, menu_order )</p>';
	echo '<p>caption="TRUE"</p>';
	echo '<p>captionclass="d-none d-md-block" <br />( left-top, left-center, left-bottom, right-top, right-center, right-bottom, center-top, center-bottom )</p>';
	echo '<p>speed="5000"</p>';
	echo '<p>transition="carousel-fade"</p>';
	echo '<p>bullets="TRUE"</p>';
	echo '<p>arrows="TRUE"</p>';
	echo '<hr />';
	echo '<h3>Gallery</h3>';
	echo '<p>';
	echo $galleries;
	echo '</p>';
	echo '<p><b>Shortcode attributes:</b></p>';
	echo '<p>class=""</p>';
	echo '<p>count="50"</p>';
	echo '<p>order="ASC" <br />( ASC, DESC )</p>';
	echo '<p>orderby="menu_order" <br />( none, ID, author, title, name, type, date, modified, parent, rand, menu_order )</p>';
	echo '<p>caption="FALSE"</p>';
	echo '<p>cols="col-6 col-lg-4"</p>';
	echo '<p>imagessize="480x480" <br />( 320x480, 360x480, 480x320, 480x360, 480x480 )</p>';
	echo '<p>imagesfill="auto"</p>';
	echo '<p>quality="medium" <br />( small, medium, large, full )</p>';
	echo '<p>linkmode="fancybox" <br />( fancybox, url )</p>';
}

////////////////////////////////////////////////////////////////////
// Shortcodes
////////////////////////////////////////////////////////////////////

// [vanderstrapslider]
function vanderstrapslider_func( $atts ){
 $a = shortcode_atts( array(
  'slug' => '',
  'class' => '',
  'count' => 50,
  'order' => 'ASC', // ASC, DESC
  'orderby' => 'menu_order', // none, ID, author, title, name, type, date, modified, parent, rand, menu_order, 
  'speed' => 5000,
  'transition' => 'carousel-fade',
		'bullets' => 'TRUE',
		'arrows' => 'TRUE',
		'caption' => 'TRUE',
		'captionclass' => 'd-none d-md-block', // left-top, left-center, left-bottom, right-top, right-center, right-bottom, center-top, center-bottom
	), $atts );
 $slug = $a['slug'];
 $class = $a['class'];
 $count = $a['count'];
 $order = $a['order'];
 $orderby = $a['orderby'];
 $speed = $a['speed'];
 $transition = $a['transition'];
	$bullets = $a['bullets'];
	$arrows = $a['arrows'];
	$caption = $a['caption'];
	$captionclass = $a['captionclass'];
 
 $args = array(
  'tax_query' => array(
   array(
    'taxonomy' => 'vanderstrap_slides_cats',
    'field' => 'slug',
    'terms' => array( $slug )
   ),
  ),
  'post_type' => 'vanderstrap_slides',
  'order' => $order,
  'orderby' => $orderby,
  'posts_per_page' => $count
 );
 
 $slider_loop = new WP_Query($args);
 $sliderhtml = '';
 $i= 0 ;
 $slide_count = $slider_loop->found_posts;
 
 if ( $slider_loop->have_posts() ):
  $sliderhtml .= '<div id="vanderstrap-slider-bs4-'.$slug.'" class="carousel '.$transition.' slide vanderstrap-slider-bs4 '.$class.' slide-total-'.$slide_count.'" data-ride="carousel" data-interval="'.$speed.'" data-pause="hover">';
		$sliderhtml .= '<div class="vanderstrap-slider-bs4-inner carousel-inner">';
  while( $slider_loop->have_posts() ){
   $slider_loop->the_post();
   $title = get_the_title();
			$desc = get_the_content();
			$meta_slider_link = get_post_meta(get_the_ID(), '_vanderstrap_link_meta_key', true);
			$meta_slider_linktarget = get_post_meta(get_the_ID(), '_vanderstrap_linktarget_meta_key', true);
   $post_image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false );
 
   if($i == 0) {
    $activeslide = 'active';
   }else{
    $activeslide = '';
   }
   $carousel_indicators .= '<li data-target="#vanderstrap-slider-bs4-'.$slug.'" data-slide-to="'.$i.'" class="'.$activeslide.'"></li>';
   // Item - Start
   $sliderhtml .= "<a class='vanderstrap-slider-bs4-slide slide-number-".$i." carousel-item ".$activeslide."' href='".$meta_slider_link."' target='".$meta_slider_linktarget."' title='".$title."' style='background-image: url(&#039;".$post_image_src[0]."&#039;);'>";
			if(!empty($desc) AND $caption == 'TRUE'){
				$sliderhtml .= '<div class="vanderstrap-slider-bs4-caption '.$captionclass.'">';
					$sliderhtml .= '<div class="vanderstrap-slider-bs4-caption-inner">'.$desc.'</div>';
				$sliderhtml .= '</div>';
			}
   $sliderhtml .= '</a>'; // .vanderstrap-slider-bs4-slide
   // Item - End
   $i++;
  }
  wp_reset_query();
		wp_reset_postdata();
  $sliderhtml .= '</div>'; // .vanderstrap-slider-bs4
		
		// Arrows - Start
		if($slide_count != 1 AND $arrows == 'TRUE'){
		$sliderhtml .= '<a class="carousel-control-prev" href="#kumento-slider-bs4-'.$slug.'" role="button" data-slide="prev">';
			$sliderhtml .= '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
			$sliderhtml .= '<span class="sr-only">Previous</span>';
		$sliderhtml .= '</a>';
		$sliderhtml .= '<a class="carousel-control-next" href="#kumento-slider-bs4-'.$slug.'" role="button" data-slide="next">';
			$sliderhtml .= '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
			$sliderhtml .= '<span class="sr-only">Next</span>';
		$sliderhtml .= '</a>';
		}
		// Arrows - End
		
  // Bullets - Start
		if($slide_count != 1 AND $bullets == 'TRUE'){
		$sliderhtml .= '<ol class="carousel-indicators">';
			$sliderhtml .= $carousel_indicators;
		$sliderhtml .= '</ol>';
		}
		// Bullets - End
		
  $sliderhtml .= '</div>'; // .vanderstrap-slider-bs4-inner
 endif;
 return $sliderhtml;
}
add_shortcode( 'vanderstrapslider', 'vanderstrapslider_func' );

// [vanderstrapgallery]
function vanderstrapgallery_func( $atts ){
 $a = shortcode_atts( array(
  'slug' => '',
  'class' => '',
  'count' => 50,
  'order' => 'ASC', // ASC, DESC
  'orderby' => 'menu_order', // none, ID, author, title, name, type, date, modified, parent, rand, menu_order, 
  'cols' => 'col-6 col-lg-4',
  'imagessize' => '480x480', // 320x480, 360x480, 480x320, 480x360, 480x480
		'imagesfill' => 'auto',
		'quality' => 'medium', // small, medium, large, full
		'caption' => 'FALSE',
		'linkmode' => 'fancybox', // fancybox, url
	), $atts );
 $slug = $a['slug'];
 $class = $a['class'];
 $count = $a['count'];
 $order = $a['order'];
 $orderby = $a['orderby'];
 $cols = $a['cols'];
 $imagessize = $a['imagessize'];
	$imagesfill = $a['imagesfill'];
	$quality = $a['quality'];
	$caption = $a['caption'];
	$linkmode = $a['linkmode'];
 
 $args = array(
  'tax_query' => array(
   array(
    'taxonomy' => 'vanderstrap_slides_cats',
    'field' => 'slug',
    'terms' => array( $slug )
   ),
  ),
  'post_type' => 'vanderstrap_slides',
  'order' => $order,
  'orderby' => $orderby,
  'posts_per_page' => $count
 );
	
 $gallery_loop = new WP_Query($args);
 $galleryhtml = '';
 
 if ( $gallery_loop->have_posts() ):
		$galleryhtml .= '<div id="vanderstrap-gallery-'.$slug.'" class="vanderstrap-gallery '.$class.'">';
		$galleryhtml .= '<div class="vanderstrap-gallery-row row">';
		
		while( $gallery_loop->have_posts() ){
   $gallery_loop->the_post();
   $title = get_the_title();
			$desc = get_the_content();
			$stripped_desc = strip_tags($desc, '<br>');
			$meta_gallery_link = get_post_meta(get_the_ID(), '_vanderstrap_link_meta_key', true);
			$meta_gallery_linktarget = get_post_meta(get_the_ID(), '_vanderstrap_linktarget_meta_key', true);
   $post_image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false );
			$thumb_image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $quality, false );
			if ($linkmode == 'fancybox'){
				$imagelinkhtml = "href='".$post_image_src[0]."' class='vanderstrap-gallery-link fancybox' title='".$stripped_desc."'";
			}elseif($linkmode == 'url'){
				$imagelinkhtml = "href='".$meta_gallery_link."' class='vanderstrap-gallery-link url' target='".$meta_gallery_linktarget."' title='".$title."'";
			}
   // Item - Start
			$galleryhtml .= '<div class="vanderstrap-gallery-col '.$cols.'">';
			$galleryhtml .= "<a ".$imagelinkhtml." rel='gallery-".$slug."' alt='".$title."' style='background-image: url(&#039;".$thumb_image_src[0]."&#039;); background-size: ".$imagesfill.";'>";
			$galleryhtml .= '<img src="'.get_stylesheet_directory_uri().'/images/blank-'.$imagessize.'.png" alt="'.$title.'" />';
			$galleryhtml .= '</a>';
			if( ($caption != 'FALSE') AND ($desc != '') ){
				$galleryhtml .= '<div class="vanderstrap-gallery-caption">'.$desc.'</div>';
			}
			$galleryhtml .= ' </div>';
   // Item - End
  }
		wp_reset_query();
		wp_reset_postdata();
		$galleryhtml .= '<div class="clear"></div>';
		$galleryhtml .= '</div>';
		$galleryhtml .= '</div>';
 endif;
 return $galleryhtml;
}
add_shortcode( 'vanderstrapgallery', 'vanderstrapgallery_func' );