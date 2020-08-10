<?php
////////////////////////////////////////////////////////////////////
// Shortcode Funtions
////////////////////////////////////////////////////////////////////
// [featuredimage]
function vanderstrapfeaturedimage_func( $atts ){
	global $post;	
	$a = shortcode_atts( array(
		'id' => $post->ID,
		'size' => 'large',
		'class' => '',
	), $atts );	
	$postid = $a['id'];
	$size = $a['size'];
	$class = $a['class'];
 
	$posttitle = get_the_title( $postid );
	$featuredimage = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), $size, false, '');
	
	if($featuredimage){
		$featuredimagehtml = '<div id="vanderstrap-featuredimage-widget-'.$postid.'" class="vanderstrap-featuredimage-widget '.$class.'">';	
		$featuredimagehtml .= '<a href="'.$featuredimage[0].'" class="fancybox" rel="gallery'.$postid.'" title="'.$posttitle.'">';
		$featuredimagehtml .= '<img class="img-responsive" src="'.$featuredimage[0].'" alt="'.$posttitle.'" title="'.$posttitle.'" width="'.$featuredimage[1].'" height="'.$featuredimage[2].'" />';
		$featuredimagehtml .= '</a>';
		$featuredimagehtml .= '</div>';
	}
	return $featuredimagehtml;
}
add_shortcode( 'featuredimage', 'vanderstrapfeaturedimage_func' );

// [customsearchform]
function customsearchform_func( $atts ){
	$a = shortcode_atts( array(
		'slug' => '',
		'class' => '',
  'layout' => '1',
  'title' => 'Søg',
	), $atts );	
	$slug = $a['slug'];
	$class = $a['class'];
 $layout = $a['layout'];
 $title = $a['title'];
 
 switch ($layout) {
 case '1':
  $shlayout_icon = '<i class="fa fa-search" aria-hidden="true"></i> ';
  $shlayout_title = '';
  $shlayout_title_inside = '';
  $shlayout_title_class = '';
  break;
 case '2':
  $shlayout_icon = '<i class="fa fa-search search-foldout-cta2" aria-hidden="true"></i> ';
  $shlayout_title = '';
  $shlayout_title_inside = '';
  $shlayout_title_class = 'class="search-foldout2"';
  break;
 case '3':
  $shlayout_icon = '<i class="fa fa-search" aria-hidden="true"></i>';
  $shlayout_title = '';
  $shlayout_title_inside = 'placeholder="'.$title.'"';
  $shlayout_title_class = '';
  break;
 case '4':
  $shlayout_icon = '';
  $shlayout_title = '';
  $shlayout_title_inside = 'placeholder="'.$title.'"';
  $shlayout_title_class = '';
  break;
 case '5':
  $shlayout_icon = '';
  $shlayout_title = '<span class="search-title">'.$title.' </span>';
  $shlayout_title_inside = '';
  $shlayout_title_class = '';
  break;
 case '6':
  $shlayout_icon = '';
  $shlayout_title = '<span class="search-title search-foldout-cta2">'.$title.' </span>';
  $shlayout_title_inside = '';
  $shlayout_title_class = 'class="search-foldout2"';
  break;
 }

	$searchformhtml = '<div class="vanderstrap-shortcode-searchform searchform-layout-'.$layout.' '.$class.'">';
	$searchformhtml .= '<form role="search" method="get" id="searchform" action="'.home_url( '/' ).$slug.'">';
	$searchformhtml .= '<div class="search-form">';
 $searchformhtml .= $shlayout_icon;
 $searchformhtml .= $shlayout_title;
	$searchformhtml .= '<input '.$shlayout_title_class.' type="text" value="" '.$shlayout_title_inside.' name="s" id="s" />';
	$searchformhtml .= '<input type="hidden" id="searchsubmit" value="Search" />';
	$searchformhtml .= '</div>';
	$searchformhtml .= '</form>';
	$searchformhtml .= '</div>';
 
 if($layout == '2' || $layout == '6'){
  ob_start();
  ?>
  <script type="text/javascript">
   jQuery(function(){
    jQuery('.search-foldout-cta2').click(function() {
     jQuery('.search-foldout2').toggle("slow");
    });
   });
  </script>
  <?php
		$searchformhtml .= ob_get_clean();
 }
 
	return $searchformhtml;
}
add_shortcode( 'customsearchform', 'customsearchform_func' );

// [displaycookies]
function get_cookies_func( $paras = '', $content = '' ) {
 if ( strtolower( $paras[ 0 ] ) == 'novalue' ) { $novalue = true; } else { $novalue = false; }
 if ( $content == '' ) { $seperator = ' : '; } else { $seperator = $content; }
 $cookie = $_COOKIE;
 ksort( $cookie );
 $content = "<div class='vanderstrapcookies'>";
  $content .= "<table class='table table-striped'>";
   $content .= "<thead><tr>";
    $content .= "<th>Cookie Navn</th>";
    $content .= "<th>Cookie Værdi</th>";
   $content .= "</tr></thead>";
   $content .= "<tbody>";
   foreach ( $cookie as $key => $val ) {
    $content .= '<tr>';
     $content .= '<td>' . $key. '</td>';
     $content .= '<td>';
     if ( !$novalue ) { $content .= $val; }
     $content .= '</td>';
    $content .= "</tr>";
   }
   $content .= "</tbody>";
  $content .= "</table>";
 $content .= "</div>";
 return do_shortcode( $content );
}
add_shortcode( 'displaycookies', 'get_cookies_func' );

// [categoryloop]
function customcatloop_func( $atts ){
 $a = shortcode_atts( array(
  'slug' => 'ikke-kategoriseret',
  'class' => '',
  'rowclass' => '',
  'posttype' => 'post',
  'taxonomy' => 'category',
  'col' => 4,
  'colsmall' => 6,
  'title' => '',
  'showtitlelink' => 'yes',
  'count' => 50,
  'offset' => 0,
  'order' => 'ASC',
  'orderby' => 'date',
  'layout' => 1,
  'showpagination' => 'yes',
  'showdivider' => 'yes',
  'showreadmore' => 'yes',
  'readmore' => 'Læs mere',
  'readmoreclass' => '',
  'showboxlink' => 'yes',
  'hidedate' => 'yes',
  'dateformat' => 'j. M. Y',
  'hideauthor' => 'yes',
  'acf' => array(),
  'showdesc' => 'yes',
  'descexcerpt' => 'yes',
  'showimage' => 'yes',
  'showimagelink' => 'yes',
  'hideimagefull' => 'yes',
  'imagecolsize' => 2,
  'imagefill' => 'cover',
		'imageratio' => '1:1',
	), $atts );	
 $slug = $a['slug'];
	$class = $a['class'];
 $rowclass = $a['rowclass'];
 $posttype = $a['posttype'];
 $taxonomy = $a['taxonomy'];
 $col = $a['col'];
 $colsmall = $a['colsmall'];
 $title = $a['title'];
 $showtitlelink = $a['showtitlelink'];
 $count = $a['count'];
 $offset = $a['offset'];
 $order = $a['order'];
 $orderby = $a['orderby'];
 $layout = $a['layout'];
 $showpagination = $a['pagination'];
 $showdivider = $a['showdivider'];
 $showreadmore = $a['showreadmore'];
 $readmore = $a['readmore'];
 $readmoreclass = $a['readmoreclass'];
 $showboxlink = $a['showboxlink'];
 $hidedate = $a['hidedate'];
 $dateformat = $a['dateformat'];
 $hideauthor = $a['hideauthor'];
 $acf = $a['acf'];
 $showdesc = $a['showdesc'];
 $descexcerpt = $a['descexcerpt'];
 $showimage = $a['showimage'];
 $showimagelink = $a['showimagelink'];
 $hideimagefull = $a['hideimagefull'];
 $imagecolsize = $a['imagecolsize'];
 $imagefilling = $a['imagefill'];
	$imageratio = $a['imageratio'];
 
	$imageheight = '480x480';
	switch ($imageratio) {
  case '1:1':
   $imageheight = '480x480';
   break;
  case '3:2':
   $imageheight = '480x320';
   break;
  case '4:3':
   $imageheight = '480x360';
   break;
  case '2:3':
   $imageheight = '320x480';
   break;
  case '3:4':
   $imageheight = '360x480';
   break;
	}
	$imagesize = 'cover';
	switch ($imagefilling) {
  case 'width':
   $imagesize = '100% auto';
   break;
  case 'height':
   $imagesize = 'auto 100%';
   break;
  case 'auto':
   $imagesize = 'auto';
   break;
  case 'cover':
   $imagesize = 'cover';
   break;
	}
 if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
 if($offset == 0){
  $args = array(
   'tax_query' => array(
    array(
     'taxonomy' => $taxonomy,
     'field' => 'slug',
     'terms' => array( $slug )
    ),
    ),
   'post_type' => $posttype,
   'paged' => $paged,
   'order' => $order,
   'orderby' => $orderby,
   'posts_per_page' => $count
  );
 }else{
  $args = array(
   'tax_query' => array(
    array(
     'taxonomy' => $taxonomy,
     'field' => 'slug',
     'terms' => array( $slug )
    ),
   ),
   'post_type' => $posttype,
   'paged' => $paged,
   'order' => $order,
   'orderby' => $orderby,
   'posts_per_page' => $count,
   'offset' => $offset
  );
 }
  
 $category_loop = new WP_Query($args);
 $catloophtml = '';
 if ( $category_loop->have_posts() ){
  $catloophtml .= '<div id="vanderstrapcategory-slug-'.$slug.'" class="vanderstrapcategory-loop '.$class.' vanderstrapcategory-layout-'.$layout.'">';
  if ($title != ''){
   $catloophtml .= '<div class="vanderstrapcategory-header"><h3>'.$title.'</h3></div>';
  }
  switch ($layout) {
   case 2:
    $catloophtml .= '<ul class="vanderstrapcategory-ul menu">';
    break;
   case 3:
    $catloophtml .= '<div class="vanderstrapcategory-row row '.$rowclass.'">';
    break;
			case 4:
    $catloophtml .= '<form action="">';
				$catloophtml .= '<div class="form-row"><div class="col-auto">';
				$catloophtml .= '<select class="vanderstrapcategory-select form-control" onchange="window.open(this.options[this.selectedIndex].value,\'_self\')">';
				$catloophtml .= '<option value="" selected disabled>'.$readmore.'</option>';
    break;
  }
  while( $category_loop->have_posts() ){
   $category_loop->the_post();
   $date = get_the_time($dateformat);
   $title = get_the_title();
   $author = get_the_author();
   $link = get_the_permalink();
   $contentcolsize = '';
   if($descexcerpt == 'yes') {
       $desc = get_the_excerpt();
   }else{
       $desc = get_the_content();
   }
   $post_image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium', false );
   $post_image_full_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false );
   if($hideimagefull != 'yes'){
   $imagelink = '<a class="vanderstrapcategory-image-link fancybox" href="'.$post_image_full_src[0].'">';
   }else{
   $imagelink = '<a class="vanderstrapcategory-image-link" href="'.$link.'">';
   }
   
   if($acf){
     $acflist = explode(",", $acf);
     $acfloophtml = '';
     foreach ($acflist as $key => $fieldvalue) {
         $acf_field_id = $fieldvalue;
         $acf_field = get_field($fieldvalue);
         if($acf_field){
           $acfloophtml .= '<span class="'.$acf_field_id.'">'.$acf_field.'</span>';
         }
     }
   }

   if ($layout == 1):
     $catloophtml .= '<div class="vanderstrapcategory-row row">';
     if($showimage == 'yes' AND $post_image_src){
     $catloophtml .= '<div class="vanderstrapcategory-image col-12 col-md-'.$imagecolsize.'">';
     if($showimagelink == 'yes'){
     $catloophtml .= $imagelink;
     }
     $catloophtml .= "<div class='vanderstrapcategory-image-inner' style='background-image: url(&#039;".$post_image_full_src[0]."&#039;); background-size: ".$imagesize.";'>";
     $catloophtml .= '<img src="'.get_stylesheet_directory_uri().'/images/blank-'.$imageheight.'.png" alt="'.$title.'" />';
     $catloophtml .= '</div>';
     if($showimagelink == 'yes'){
     $catloophtml .= '</a>';
     }
     $catloophtml .= '</div>';
     $contentcolsize = 12-$imagecolsize;
     $contentcolsize = 'col-sm-'.$contentcolsize;
     }
     $catloophtml .= '<div class="vanderstrapcategory-content col-12 '.$contentcolsize.'">';
     // Link around Title - start
     if($showtitlelink == 'yes'){
     $catloophtml .= '<a class="vanderstrapcategory-title-link" href="'.$link.'">';
     $catloophtml .= '<h3 class="vanderstrapcategory-title">'.$title.'</h3>';
     $catloophtml .= '</a>';
     }else{
     $catloophtml .= '<h3 class="vanderstrapcategory-title">'.$title.'</h3>'; 
     }
     // Link around Title - end      
     // Meta info - start
     if($hidedate != 'yes' AND $hideauthor == 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-meta">'.$date.'</div>'; 
     }elseif($hidedate == 'yes' AND $hideauthor != 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-meta">Af '.$author.'</div>';  
     }elseif($hidedate != 'yes' AND $hideauthor != 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-meta">'.$date.' af '.$author.'</div>';   
     }
     // Meta info - end
     // ACF - start
     if($acf){
     $catloophtml .= '<div class="vanderstrapcategory-acf">'.$acfloophtml.'</div>';
     }
     // ACF - end
     // Short description - start
     if($showdesc == 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-text">'.$desc.'</div>';
     }
     // Short description - end
     // Readmore - start
					/*
     if($showreadmore == 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-readmore"><a class="vanderstrapcategory-readmore-link '.$readmoreclass.'" href="'.$link.'">'.$readmore.'</a></div>'; 
     }
     */
     // Readmore - end
     $catloophtml .= '</div></div>';
     if($showdivider == 'yes'){
     $catloophtml .= '<hr />';
     }
   endif;
      
   if ($layout == 2):
     $catloophtml .= '<li class="vanderstrapcategory-li">';
     $catloophtml .= '<a class="vanderstrapcategory-simple-link" href="'.$link.'">'.$title.'</a>';   
     $catloophtml .= '</li>';
   endif;
      
   if ($layout == 3):
     $catloophtml .= '<div class="vanderstrapcategory-col col-12 col-md-'.$colsmall.' col-lg-'.$col.'">';
     if($showboxlink == 'yes'){
     $catloophtml .= '<a class="vanderstrapcategory-box-link" href="'.$link.'">';
     }else{
     $catloophtml .= '<div class="vanderstrapcategory-box">'; 
     }
     if($showimage == 'yes' AND $post_image_full_src){
     if($hideimagefull != 'yes' and $showboxlink != 'yes'){
     $catloophtml .= $imagelink;
     }
     $catloophtml .= "<div class='vanderstrapcategory-image' style='background-image: url(&#039;".$post_image_full_src[0]."&#039;); background-size: ".$imagesize.";'>";
     $catloophtml .= '<img src="'.get_stylesheet_directory_uri().'/images/blank-'.$imageheight.'.png" alt="'.$title.'" />';
     $catloophtml .= '</div>';
     if($hideimagefull != 'yes' and $showboxlink != 'yes'){
     $catloophtml .= '</a>';
     }
     }
     $catloophtml .= '<div class="vanderstrapcategory-content">';    
     $catloophtml .= '<h3 class="vanderstrapcategory-title">'.$title.'</h3>';
     // Meta info - start
     if($hidedate != 'yes' AND $hideauthor == 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-meta">'.$date.'</div>'; 
     }elseif($hidedate == 'yes' AND $hideauthor != 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-meta">Af '.$author.'</div>';  
     }elseif($hidedate != 'yes' AND $hideauthor != 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-meta">'.$date.' af '.$author.'</div>';   
     }
     // Meta info - end
     // ACF - start
     if($acf){
     $catloophtml .= '<div class="vanderstrapcategory-acf">'.$acfloophtml.'</div>';
     }
     // ACF - end
     // Short description - start
     if($showdesc == 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-text">'.$desc.'</div>';
     }
     // Short description - end
     // Readmore - start
					/*
     if($showreadmore == 'yes' AND $showboxlink != 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-readmore"><a class="vanderstrapcategory-readmore-link '.$readmoreclass.'" href="'.$link.'">'.$readmore.'</a></div>'; 
     }elseif($showreadmore == 'yes' AND $showboxlink == 'yes'){
     $catloophtml .= '<div class="vanderstrapcategory-readmore"><span class="vanderstrapcategory-readmore-nolink '.$readmoreclass.'">'.$readmore.'</span></div>'; 
     }
     */
     // Readmore - end
     $catloophtml .= '</div>';
     if($showboxlink == 'yes'){
     $catloophtml .= '</a>';
     }else{
     $catloophtml .= '</div>'; 
     }
     $catloophtml .= '</div>';
   endif;
			
			if ($layout == 4):
     $catloophtml .= '<option value="'.$link.'">'.$title.'</option>';
   endif;
  }
  $catloophtml .= '<div style="clear: left;"></div>';
  switch ($layout) {
   case 2:
    $catloophtml .= '</ul>';
    break;
   case 3:
    $catloophtml .= '</div>';
    break;
			case 4:
    $catloophtml .= '</select>';
				$catloophtml .= '</form>';
				$catloophtml .= '</div></div>';
    break;
  }
  if ($category_loop->max_num_pages > 1 AND $showpagination == 'yes') :
   $orig_query = $wp_query; // fix for pagination to work
   $wp_query = $category_loop;
   $catloophtml .= '<div class="vanderstrap-pagination">';		
   $catloophtml .= '<span class="nav-next alignright">'.get_previous_posts_link( '< Forrige side' ).'</span>';
   $catloophtml .= ' - <span class="nav-previous alignleft">'.get_next_posts_link( 'Næste side >', $category_loop->max_num_pages ).'</span>';
   $catloophtml .= '</div>';
   $wp_query = $orig_query; // fix for pagination to work
  endif;
  wp_reset_query();  
  $catloophtml .= '</div>';
 }
	return $catloophtml;
}
add_shortcode( 'categoryloop', 'customcatloop_func' );