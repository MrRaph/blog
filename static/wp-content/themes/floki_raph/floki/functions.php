<?php

// widgets and sidebars

function floki_widgets()  {
// sidebar
	register_sidebar(array(
		'id'            => 'mainsidebar',
		'name'          => __( 'Main sidebar', 'floki' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));


	$args = array(
		'id'            => 'footer1',
		'name'          => __( 'Footer column 1', 'floki' ),
		'description'   => __( 'Footer widget zone 1', 'floki' ),
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
	);
	register_sidebar( $args );
	
	$args = array(
		'id'            => 'footer2',
		'name'          => __( 'Footer column 2', 'floki' ),
		'description'   => __( 'Footer widget zone 2', 'floki' ),
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
	);
	register_sidebar( $args );
	
	$args = array(
		'id'            => 'footer3',
		'name'          => __( 'Footer column 3', 'floki' ),
		'description'   => __( 'Footer widget zone 3', 'floki' ),
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
	);
	register_sidebar( $args );
	
	$args = array(
		'id'            => 'footer4',
		'name'          => __( 'Footer column 4', 'floki' ),
		'description'   => __( 'Footer widget zone 4', 'floki' ),
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
	);
	register_sidebar( $args );

	require get_template_directory() . '/default-widgets.php';
	
	register_widget( 'floki_WP_floki_Widget_Recent_Posts' );
	register_widget( 'floki_WP_floki_Widget_Recent_Comments' );
	register_widget( 'floki_WP_floki_Widget_Tag_Cloud' );

}

add_action( 'widgets_init', 'floki_widgets' );


///////// THEME SETUP

if ( ! function_exists( 'floki_setup' ) ) :

function floki_setup(){
	
    load_theme_textdomain('floki', get_template_directory() . '/languages');
	
	register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu', 'floki' ),
      'extra-menu' => __( 'Extra Menu', 'floki' )
    )
  );
	
	// actions
		
	add_action( 'admin_menu', 'floki_theme_options_add_page' ); 
	add_action( 'admin_head', 'floki_add_header_admin_floki' );
	
	// filters
	
	add_filter('previous_posts_link','floki_add_class_previous_post_link');
	add_filter('next_posts_link','floki_add_class_next_post_link');
	add_filter('image_send_to_editor','floki_linked_images_class',10,8);
	
	// theme support
	
	add_theme_support('post-thumbnails');
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'video', 'image', 'audio', 'quote') );
	
	// content width
	if ( ! isset( $content_width ) ) $content_width = 1099;
}

endif;

add_action('after_setup_theme', 'floki_setup');

// Theme activation and default options

function floki_get_option_defaults() {
    $defaults = array(
        'palcolor1' => '3B97D2',
        'palcolor2' => '5E5E4A',
		'palcolor3' => 'ffffff', 
		'palcolor4' => '607890', 
		'favicon' => '',   
		'iconapple' => '', 
		'iconapple2' => '',
		'hslider' => 'none',
		'iconapple3' => '', 
		'iconapple4' => '', 
		'default_sidebar_pos' => 'none', 
		'default_sidebar_pos2' => 'none',
		'default_sidebar_pos3' => 'none',
		'default_sidebar_pos4' => 'none',
		'default_sidebar_pos5' => 'none',
		'comments' => '1',     
		'bodycode' => '',
		'headcode' => '',   
		'menu_design' => '34495E',
		'logo' => get_template_directory_uri().'/images/logo.png',
		'mainimage' => get_template_directory_uri().'/images/header.jpg',
		'headertitle' => 'AWESOME WORDPRESS THEME',     
		'headerdescription' => 'Seo optimized, 3D animations, Google Fonts, sidebars, menus, great theme options and more',     
		'menusize' => '34495E',     
		'menupading' => '3498DB', 
		'menu_posi' => 'FFFFFF',   
		'menu_posi2' => 'logo',   
		'menu_design2' => 'sm-blue', 
		'colorstrong' => '3B97D2', 
		'stylezone1' => 'otro',
		'colorzone1' => '3498DB',
		'menu_design6' => 'sm-blue',   
		'bimage' => '',
		'colorzone6' => 'FFFFFF', 
		'color2zone1 =  "3498DB',
		'visiblezone2' => 'sm-blue',
		'colorzone2' => 'FFFFFF',    
		'color2zone2' => 'FFFFFF',  
		'visiblezone5' => 'sm-blue',    
		'colorzone5' => 'FFFFFF',
		'color2zone5' => 'FFFFFF',    
		'visiblezone1' => 'sm-blue',     
		'visiblezone3' => 'sm-blue',     
		'colorzone3' => '444444',  
		'color2zone3' => '333333',    
		'menusize2' => 'CCCCCC',   
		'menupading2' => 'FFFFFF',
		'googlefont' => 'Open+Sans', 
		'manualfont' => '',    
		'sizefont' => '16px',  
		'colorfont' => '7F8C8D',     
		'sizefont2' => '16px',     
		'colorfont2' => '3B97D2',
		'colorfont3' => '235A7D',     
		'colorfont4' => '48B7FF',     
		'sizefonth1' => '38px',    
		'colorfonth1' => '3B97D2',     
		'sizefonth2' => '36px',   
		'colorfonth2' => '3B97D2',       
		'sizefonth3' => '32px',   
		'colorfonth3' => '3B97D2',         
		'sizefonth4' => '24px', 
		'colorfonth4' => '3B97D2',         
		'sizefonth5' => '20px',   
		'colorfonth5' => '3B97D2',         
		'socialopacity' => '0.5',    
		'facebook' => '',     
		'rss' => '',  
		'twitter' => '',    
		'flickr' => '',     
		'youtube' => '',      
		'vimeo' => '',    
		'google' => '',   
		'pinterest' => '', 
		'tumblr' => '',      
		'dribbble' => '', 
		'digg' => '',    
		'linkedin' => '',     
		'blogger' => '',    
		'skype' => '',     
		'myspace' => '',   
		'yahoo' => '',     
		'tipesocial' => 'white',    
		'hfixed' => '0',
		'footertext' => '',   
		'footersocial' => 'white',    
		'footerwidgets' => '3',    
		'colorzone4' => '222222',
		'headingfont' => 'Roboto',
		'anidiv' => 'despx',     
		'aniimg' => 'rotate',     
		'anih' => 'despy',     
		'anilink' => 'rotate',     
		'anip' => 'despy'     
    );
    // protip: wrap the output in a filter, to allow child theme override
    return apply_filters( 'floki_option_defaults', $defaults );
}

// Restore defauls values

function floki_default_options() {
	$defaults = floki_get_option_defaults();
	foreach($defaults as $k => $v) {
		 set_theme_mod($k, $v);
	}
}

function floki_get_option( $option ) {
    $defaults = floki_get_option_defaults();
    return get_theme_mod( $option, $defaults[$option] );
}
	
// pagination functions
function floki_add_class_next_post_link($html){
    $html = str_replace('<a','<a rel="prev"',$html);
    return $html;
}

function floki_add_class_previous_post_link($html){
    $html = str_replace('<a','<a rel="next"',$html);
    return $html;
}

// Attach a class to linked images' parent anchors
function floki_linked_images_class($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
  $classes = 'swipebox'; // separated by spaces, e.g. 'img image-link'

  // check if there are already classes assigned to the anchor
  if ( preg_match('/<a.*? class=".*?">/', $html) ) {
    $html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
  } else {
    $html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
  }
  return $html;
}

// function get color
function floki_getContrastYIQ($hexcolor){
	$r = hexdec(substr($hexcolor,0,2));
	$g = hexdec(substr($hexcolor,2,2));
	$b = hexdec(substr($hexcolor,4,2));
	$yiq = (($r*299)+($g*587)+($b*114))/1000;
	return ($yiq >= 128) ? 'black' : 'white';
}

// Print functions
function floki_printsocial($color) {
	$sociallinks=array("facebook", "rss", "twitter", "flickr","youtube","vimeo","google","pinterest","tumblr","dribbble","digg","linkedin","blogger","skype","myspace","yahoo");
	foreach($sociallinks as $s) {		
			if(floki_get_option( $s )!="") echo ' <a href="'.esc_url(floki_get_option( $s )).'"><img src="'.get_template_directory_uri().'/images/social_icons/'.$color.'/'.$s.'.png" /></a>';		
	}
}

function floki_get_breadcrumbfloki() {
 
	global $post;
 $page_title = get_the_title($post->ID);
	$trail = '<div class="breadcrumbflokistyle">
	<div class="container ">
	<div class="breadcrumbfloki" style=" text-align:center; padding:50px;">

 <h1 style="color:#fff;">'.$page_title.'</h1>
';
	
 $fpost=0;
	if($post->post_parent) {
		
		$trail.='<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="margin-top:10px">';
		 $fpost=1;
		$parent_id = $post->post_parent;
 
		while ($parent_id) {
			$page = get_page($parent_id);
			$breadcrumbflokis[] = '<a href="' . get_permalink($page->ID) . '" itemprop="url"><span itemprop="title">' . get_the_title($page->ID) . '</span></a> » ';
			$parent_id = $page->post_parent;
		}
 
		$breadcrumbflokis = array_reverse($breadcrumbflokis);
		foreach($breadcrumbflokis as $crumb) $trail .= $crumb;
	
	}
	
	else {
		$cates=get_the_category();
		$cc=0;
		foreach($cates as $c) {
			if($cc>0) $trail .=', '.$c->cat_name;
			else $trail .=$c->cat_name;
			$cc++;
		}
	} 
	if( $fpost==1) {
		$trail .= $page_title;
		$trail.='</div>';
	}
	$trail .= '
	</div>
	</div>
 </div>
';
	return $trail;	
}

function floki_get_breadcrumbfloki3($page_title, $subtitle) {
 

	$trail = '<div class="breadcrumbflokistyle">
	<div class="container ">
	<div class="breadcrumbfloki" style=" text-align:center; padding:50px;">

 <h1 style="color:#fff;">'.$page_title.'</h1>
 
 <strong style="color:#fff;">'.$subtitle.'</strong>
';
	$trail .= '
	</div>
	</div>
 </div>
';
	return $trail;	 
}

function floki_get_breadcrumbfloki2($sptitle, $spinfo, $tipopage) {
	
 
	global $post;
	$caux="2-3";
	$caux2="1-3";
	
	if($spinfo==1 || !isset($spinfo)) {
		$caux="3-3";
	$caux2="1-3";
	}
	
	$widthp="width: 100%;";
	
	if($tipopage=="" || ($tipopage != 'left' && $tipopage != 'right'))$widthp="";
	
 $page_title = get_the_title($post->ID);
	$trail = '<div class="portfoliotitle">

<div class="container" style="'.$widthp.'"><div class="su-row">
	<div>
 <div class="su-column su-column-size-'.$caux.'" style="margin:0;">
 <div class="su-column-inner">
 
 <a href="'.get_permalink().'" rel="bookmark" title="'.$page_title.'" ><h2 style="margin:0;">'.$page_title.'</h2></a>
 </div>
 </div>';
 
 if($spinfo==1 || !isset($spinfo)) $trail .= '<div class="su-column su-column-size-'.$caux2.'" style="margin-right:10px; margin-bottom: 0; margin-top:0;">
  <div class="su-column-inner"><img class="svg" src="'.get_template_directory_uri().'/images/svg/alarm-clock.svg" height="15px" /> '.get_the_time(get_option('date_format')).'  -  <img class="svg" src="'.get_template_directory_uri().'/images/svg/user.svg" height="15px"/> '.get_the_author().'</div></div>';
	
	 $trail .= '
	</div>
	</div>
	</div>
	</div>
';
 
	return $trail;	
}

// Theme options functions

function floki_theme_options_add_page() {
	 
add_theme_page( __( 'floki Theme', 'floki' ), __( 'floki theme options', 'floki' ), 'edit_theme_options', 'theme_options', 'floki_theme_options_do_page', get_template_directory_uri().'/images/minilogo.png', 25 );
 
} 

function floki_theme_options_do_page() { 

	global $select_options; 

	$optionsurl=get_template_directory().'/options.php';
	include $optionsurl;
}

// admin init
function floki_add_header_admin_floki() {

	 
	wp_enqueue_style( 'floki-admincss', get_template_directory_uri().'/admin_style.css');
	wp_enqueue_script('floki-color', get_template_directory_uri().'/js/jscolor.js', array('jquery'));
	wp_enqueue_script('floki-adminfunctions', get_template_directory_uri().'/js/adminfunctions.js', array('jquery'));
	did_action( 'wp_enqueue_media' );
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');

	
	echo '
<script>
function appendText(text) {
//Insert content
var str=text;
str=str.replace(/4s0/g, \'"\');
window.send_to_editor(str);

}
</script>
';
	// editor styles
	
	if(floki_get_option( 'googlefont' )!="not") { 
		$protocol = is_ssl() ? 'https' : 'http';
		$fonts_url=$protocol.'://fonts.googleapis.com/css?family=Open+Sans:400,800italic,800,700italic,600italic,600,400italic,300italic,300&subset=latin,latin-ext';
		add_editor_style( str_replace( ',', '%2C', $fonts_url ));	
	} 

	 if(floki_get_option( 'headingfont' )!="not") { 				
		$protocol = is_ssl() ? 'https' : 'http';
		$fonts_url=$protocol.'://fonts.googleapis.com/css?family=Roboto:400,800italic,800,700italic,600italic,600,400italic,300italic,300&subset=latin,latin-ext';
		add_editor_style( str_replace( ',', '%2C', $fonts_url ));	
	} 
			
	add_editor_style('custom-editor-style.css');	
}

// Frontend Styles and Scripts

function floki_add_header_scripts() {

	global $menu_design6,$parallaxani,$options, $tipopage,$layerslider,$revslider,$anidiv,$aniimg,$anilink,$anip,$anih,$pageslider,$floki_custom_sidebar,$blogcategory,$spinfo,$sptitle,$spimage,$sporder,$spcontent,$sporde,$visiblezone,$bimage,$bimage2,$bimage3,$bimage4,$bcolor1,$bcolor2,$spcont,$backdot,$backtyp,$youtubeback,$youtubemute, $youtubesize;

	   $isMobile=wp_is_mobile();	   
	   $animate=0;

	$animation=1;
	$parallaxani=1;
	
	if($isMobile) {
		$animation=0;
		$parallaxani=0;
	}
	//$animation= floki_get_option( 'colorfonth1' );
	
	// options

	$demooptions=false; // demos design options	
	$colorfonth1= esc_attr(floki_get_option( 'colorfonth1' ));

	
	$colorfonth2= esc_attr(floki_get_option( 'colorfonth2' ));
	$colorfont2= esc_attr(floki_get_option( 'colorfont2' ));
	$colorfont3= esc_attr(floki_get_option( 'colorfont3' ));
	$colorfont4= esc_attr(floki_get_option( 'colorfont4' ));
	$colorfont= esc_attr(floki_get_option( 'colorfont' ));
	$colorstrong=  esc_attr(floki_get_option( 'colorstrong' ));
	$menusize= esc_attr(floki_get_option( 'menusize' ));
	
	$colorzone1= esc_attr(floki_get_option( 'colorzone1' ));
	$colorzone3= esc_attr(floki_get_option( 'colorzone3' ));
	$colorzone6= esc_attr(floki_get_option( 'colorzone6' ));
	$colorzone5= esc_attr(floki_get_option( 'colorzone5' ));
	
	$menupading= esc_attr(floki_get_option( 'menupading' ));
	$menu_design= esc_attr(floki_get_option( 'menu_design' ));
	$colorstrong= esc_attr(floki_get_option( 'colorstrong' ));
	$colorfonth3= esc_attr(floki_get_option( 'colorfonth3' ));
	$colorfonth4=esc_attr(floki_get_option( 'colorfonth4' ));
	
	$menu_design6= esc_attr(floki_get_option( 'menu_design6' ));
	
	$hfixed= esc_attr(floki_get_option( 'hfixed' ));
	$anidiv = esc_attr(floki_get_option("anidiv")); 
	$aniimg = esc_attr(floki_get_option("aniimg"));
	$anih = esc_attr(floki_get_option("anih"));
	$anilink = esc_attr(floki_get_option("anilink"));
	$anip = esc_attr(floki_get_option("anip")); 
	$mainimage = esc_attr(floki_get_option("mainimage")); 
	
	if($isMobile) $hfixed=0;
	
	$markup="";
	
  			$visiblezone=esc_attr(floki_get_option( 'visiblezone5' ));
		
			$bodycolor1=$colorzone5;
			$bodycolor2=esc_attr(floki_get_option( 'color2zone5' ));

			$style="";

/* if page options
if($visiblezone=="sm-blue" && isset($post_id)) {
					$colorzone5=esc_attr(get_post_meta($post_id, 'colorzone', true));
				}
*/
global $custom_syle; 

	require get_template_directory() . '/custom-css.php';

	wp_enqueue_style( 'floki-stylesheet', get_bloginfo('stylesheet_url'));
	wp_add_inline_style( 'floki-stylesheet', $custom_syle );
	
	wp_enqueue_script( 'jquery');
	wp_enqueue_script('floki-script', get_template_directory_uri().'/js/floki.js');
	
	wp_localize_script( 'floki-script', 'floki', array( 'animation' => $animation, 'parallaxani' => $parallaxani, 'logo' => esc_url(floki_get_option( 'logo' )), 'isMobile' => $isMobile, 'auxiv1' => '0', 'anidiv' => $anidiv, 'aniimg' => $aniimg, 'anih' => $anih, 'anilink' => $anilink, 'anip' => $anip, 'mainimage' => $mainimage) );
	
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	
	if(floki_get_option( 'googlefont' )!="not") { 
		
	wp_enqueue_style( 'floki-googlefont', '//fonts.googleapis.com/css?family='.esc_attr(floki_get_option( 'googlefont' )).':400,800italic,800,700italic,600italic,600,400italic,300italic,300&subset=latin,latin-ext');		
		} 

	 if(floki_get_option( 'headingfont' )!="not") { 
		wp_enqueue_style( 'floki-googlefonth', '//fonts.googleapis.com/css?family='.esc_attr(floki_get_option( 'headingfont' )).':400,800italic,800,700italic,600italic,600,400italic,300italic,300&subset=latin,latin-ext');		
		} 

}

add_action('wp_enqueue_scripts', 'floki_add_header_scripts'); 
// get youtube video id
function floki_getYTidyoutubevideo($ytURL) {
#http://youtu.be/VXPoJAyeF8k
 
#
$ytvIDlen = 11; // This is the length of YouTube's video IDs
#
 
#
// The ID string starts after "v=", which is usually right after
#
// "youtube.com/watch?" in the URL
#
$idStarts = strpos($ytURL, "?v=");
#
 
#
// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
#
// bases covered), it will be after an "&":
#
if($idStarts === FALSE)
#
$idStarts = strpos($ytURL, "&v=");

if($idStarts === FALSE)
$idStarts = strpos($ytURL, "be/");

#
// If still FALSE, URL doesn't have a vid ID
#
if($idStarts === FALSE)
#
die(__("YouTube video ID not found. Please double-check your URL.", "floki"));
#
 
#
// Offset the start location to match the beginning of the ID string
#
$idStarts +=3;
#
 
#
// Get the ID string and return it
#
$ytvID = substr($ytURL, $idStarts, $ytvIDlen);
#
 
#
return $ytvID;
#
 
#
}
?>