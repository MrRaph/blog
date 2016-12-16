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
        'palcolor1' => '#3B97D2',
        'palcolor2' => '#5E5E4A',
		'palcolor3' => '#ffffff', 
		'palcolor4' => '#607890', 
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
		'menu_design' => '#34495E',
		'logo' => get_template_directory_uri().'/images/logo.png',
		'mainimage' => get_template_directory_uri().'/images/header.jpg',
		'headertitle' => 'AWESOME WORDPRESS THEME',     
		'headerdescription' => 'Seo optimized, 3D animations, Google Fonts, sidebars, menus, great theme options and more',     
		'menusize' => '#2c3e50',     
		'menupading' => '#34495e', 
		'menu_posi' => '#FFFFFF',   
		'menu_posi2' => 'top2',   
		'menu_design2' => 'sm-blue', 
		'colorstrong' => '#3B97D2', 
		'stylezone1' => 'otro',
		'colorzone1' => '#3498DB',
		'menu_design6' => 'sm-blue',   
		'bimage' => '',
		'colorzone6' => '#FFFFFF', 
		'color2zone1 =  "#3498DB',
		'visiblezone2' => 'sm-blue',
		'colorzone2' => '#FFFFFF',    
		'color2zone2' => '#FFFFFF',  
		'visiblezone5' => 'sm-blue',    
		'colorzone5' => '#FFFFFF',
		'color2zone5' => '#FFFFFF',    
		'visiblezone1' => '0',     
		'visiblezone3' => 'sm-blue',     
		'colorzone3' => '#444444',  
		'color2zone3' => '#333333',    
		'menusize2' => '#CCCCCC',   
		'menupading2' => '#FFFFFF',
		'googlefont' => 'Roboto', 
		'manualfont' => '',    
		'sizefont' => '16px',  
		'colorfont' => '#7F8C8D',     
		'sizefont2' => '16px',     
		'colorfont2' => '#3B97D2',
		'colorfont3' => '#235A7D',     
		'colorfont4' => '#48B7FF',     
		'sizefonth1' => '38px',    
		'colorfonth1' => '#3B97D2',     
		'sizefonth2' => '36px',   
		'colorfonth2' => '#3B97D2',       
		'sizefonth3' => '32px',   
		'colorfonth3' => '#3B97D2',         
		'sizefonth4' => '24px', 
		'colorfonth4' => '#3B97D2',         
		'sizefonth5' => '20px',   
		'colorfonth5' => '#3B97D2',         
		'socialopacity' => '0.5',    
		'facebook' => 'https://www.facebook.com/webpsilon',     
		'rss' => 'http://www.webpsilon.com',  
		'twitter' => 'http://www.extendyourweb.com',    
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
		'hfixed' => '1',
		'footertext' => 'Wordpress Themes & Plugins ExtendYourWeb.com',   
		'footersocial' => 'white',    
		'footerwidgets' => '3',    
		'colorzone4' => '#222222',
		'headingfont' => 'Arvo',
		'anidiv' => '',     
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
	
	$devoption=$defaults[$option];
	
	if(strpos($devoption, "#")===false && strlen($devoption)==6) {
		
		$devoption="#".$devoption;
	}
	
    return get_theme_mod( $option, $devoption  );
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


class floki_Customize {
   /**
    * This hooks into 'customize_register' (available as of WP 3.4) and allows
    * you to add new sections and controls to the Theme Customize screen.
    * 
    * Note: To enable instant preview, we have to actually write a bit of custom
    * javascript. See live_preview() for more.
    *  
    * @see add_action('customize_register',$func)
    * @param \WP_Customize_Manager $wp_customize
    * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
    * @since floki 1.0
    */
   public static function register ( $wp_customize ) {
      //1. Define a new section (if desired) to the Theme Customizer

	  	  	  $wp_customize->add_section( 'floki_general_design', 
         array(
            'title' => __( 'General options', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Icon, comments, ...', 'floki'), //Descriptive tooltip
         ) 
      );
	  
	  
	  
	  	  $wp_customize->add_section( 'floki_fonts_design', 
         array(
            'title' => __( 'Fonts', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Google fonts, sizes, ...', 'floki'), //Descriptive tooltip
         ) 
      );

	  $wp_customize->add_section( 'floki_header_design', 
         array(
            'title' => __( 'Header', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Design, colors from header', 'floki'), //Descriptive tooltip
         ) 
      );
	  
	  $wp_customize->add_section( 'floki_slider_design', 
         array(
            'title' => __( 'Slider', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Slider design', 'floki'), //Descriptive tooltip
         ) 
      );
	  
	  	  $wp_customize->add_section( 'floki_sidebar_design', 
         array(
            'title' => __( 'Sidebars', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Set sidebars in home, pages, post ...', 'floki'), //Descriptive tooltip
         ) 
      );
	  
	  
	  	  $wp_customize->add_section( 'floki_footer_design', 
         array(
            'title' => __( 'Footer', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Text and columns from footer', 'floki'), //Descriptive tooltip
         ) 
      );

	  
	  	  	  $wp_customize->add_section( 'floki_animations_design', 
         array(
            'title' => __( 'Animations', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Custom automatic animations', 'floki'), //Descriptive tooltip
         ) 
      );


	  	  $wp_customize->add_section( 'floki_social_design', 
         array(
            'title' => __( 'Social Links', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Social Links', 'floki'), //Descriptive tooltip
         ) 
      );


	  $wp_customize->add_section( 'floki_colors_design', 
         array(
            'title' => __( 'Background colors', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Set backgrounds colors.', 'floki'), //Descriptive tooltip
         ) 
      );
	  
	    $wp_customize->add_section( 'floki_text_colors', 
         array(
            'title' => __( 'Text colors', 'floki' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to customize text colors.', 'floki'), //Descriptive tooltip
         ) 
      );
	  
	  
	  //animations
	  
	  	  	  $wp_customize->add_setting(
    'anidiv',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => ''
    )
);

	  $wp_customize->add_control(
    'anidiv',
    array(
        'type' => 'select',
        'label' => __( 'DIVS', 'floki' ),
        'section' => 'floki_animations_design',
        'choices' => array(
            '' => 'None',
            'despx' => 'Opacity',
            'despy' => 'Rotate Y',
			 'rotate' => 'Rotate X'
        ),
    )
);

 $wp_customize->add_setting(
    'aniimg',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'rotate'
    )
);

	  $wp_customize->add_control(
    'aniimg',
    array(
        'type' => 'select',
        'label' => __( 'Images', 'floki' ),
        'section' => 'floki_animations_design',
        'choices' => array(
            '' => 'None',
            'despx' => 'Opacity',
            'despy' => 'Rotate Y',
			 'rotate' => 'Rotate X'
        ),
    )
);

 $wp_customize->add_setting(
    'anih',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'despy'
    )
);

	  $wp_customize->add_control(
    'anih',
    array(
        'type' => 'select',
        'label' => __( 'Heading(H1,H2,...)', 'floki' ),
        'section' => 'floki_animations_design',
        'choices' => array(
            '' => 'None',
            'despx' => 'Opacity',
            'despy' => 'Rotate Y',
			 'rotate' => 'Rotate X'
        ),
    )
);

 $wp_customize->add_setting(
    'anilink',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'rotate'
    )
);

	  $wp_customize->add_control(
    'anilink',
    array(
        'type' => 'select',
        'label' => __( 'Links', 'floki' ),
        'section' => 'floki_animations_design',
        'choices' => array(
            '' => 'None',
            'despx' => 'Opacity',
            'despy' => 'Rotate Y',
			 'rotate' => 'Rotate X'
        ),
    )
);

 $wp_customize->add_setting(
    'anip',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'despy'
    )
);

	  $wp_customize->add_control(
    'anip',
    array(
        'type' => 'select',
        'label' => __( 'Texts', 'floki' ),
        'section' => 'floki_animations_design',
        'choices' => array(
            '' => 'None',
            'despx' => 'Opacity',
            'despy' => 'Rotate Y',
			 'rotate' => 'Rotate X'
        ),
    )
);
	  
	  
	  //slider 
	  
	  $wp_customize->add_setting( 'mainimage', array(
	  'sanitize_callback' => 'esc_url_raw',
	  'type' => 'theme_mod',
	  'default' => get_template_directory_uri().'/images/header.jpg'
	  
	  ) );
	  
	  	    $wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'mainimage',
        array(
            'label' => __( 'Slider image', 'floki' ),
            'section' => 'floki_slider_design',
            'settings' => 'mainimage'
        )
    )
);
	  
	  	  $wp_customize->add_setting( 'headertitle', array('sanitize_callback' => 'floki_sanitize_pro_version', 'type' => 'theme_mod', 'default' => 'AWESOME WORDPRESS THEME') );
	  $wp_customize->add_control(
    'headertitle',
    array(
        'label' => __( 'Title', 'floki' ),
        'section' => 'floki_slider_design',
        'type' => 'text'
    )
);

	  	  $wp_customize->add_setting( 'headerdescription' , array('sanitize_callback' => 'floki_sanitize_pro_version', 'type' => 'theme_mod', 'default' => 'Seo optimized, 3D animations, Google Fonts, sidebars, menus, great theme options and more') );
	  $wp_customize->add_control(
    'headerdescription',
    array(
        'label' => __( 'Sub title', 'floki' ),
        'section' => 'floki_slider_design',
        'type' => 'text',
    )
);

	  	  $wp_customize->add_setting( 'hslider'  , array('sanitize_callback' => 'floki_sanitize_pro_version', 'type' => 'theme_mod','default' => 'none'));
	  $wp_customize->add_control(
    'hslider',
    array(
        'label' => __( 'Slider shortcode', 'floki' ),
        'section' => 'floki_slider_design',
        'type' => 'text'
    )
);
	  
	  
	  
	  
	  // social links
	  
	  
	  $wp_customize->add_setting( 'facebook'  , array('sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod','default' => 'https://www.facebook.com/webpsilon'));
	  $wp_customize->add_control(
    'facebook',
    array(
        'label' => __( 'Facebook', 'floki' ),
        'section' => 'floki_social_design',
        'type' => 'text'
    )
);

	  $wp_customize->add_setting( 'rss'  , array('sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod','default' => 'http://www.webpsilon.com'));
	  $wp_customize->add_control(
    'rss',
    array(
        'label' => __( 'rss', 'floki' ),
        'section' => 'floki_social_design',
        'type' => 'text'
    )
);

	  $wp_customize->add_setting( 'twitter' , array('sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod','default' => 'http://www.extendyourweb.com') );
	  $wp_customize->add_control(
    'twitter',
    array(
        'label' => __( 'twitter', 'floki' ),
        'section' => 'floki_social_design',
        'type' => 'text'
    )
);

	  $wp_customize->add_setting( 'google' , array('sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod', 'default' => '') );
	  $wp_customize->add_control(
    'google',
    array(
        'label' => __( 'google', 'floki' ),
        'section' => 'floki_social_design',
        'type' => 'text'
    )
);

	  $wp_customize->add_setting( 'youtube', array('sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod')  );
	  $wp_customize->add_control(
    'youtube',
    array(
        'label' => __( 'youtube', 'floki' ),
        'section' => 'floki_social_design',
        'type' => 'text'
    )
);

	  $wp_customize->add_setting( 'vimeo', array('sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod')  );
	  $wp_customize->add_control(
    'vimeo',
    array(
        'label' => __( 'vimeo', 'floki' ),
        'section' => 'floki_social_design',
        'type' => 'text'
    )
);
	  
	  // general options
	  
	  $wp_customize->add_setting( 'favicon', array('sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod') );
	  
	    $wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'favicon',
        array(
            'label' => __( 'Favicon icon', 'floki' ),
            'section' => 'floki_general_design',
            'settings' => 'favicon'
        )
    )
);
	  
	  	  	  $wp_customize->add_setting(
    'menu_design6',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'sm-blue'
    )
);

	  $wp_customize->add_control(
    'menu_design6',
    array(
        'type' => 'select',
        'label' => __( 'Background design', 'floki' ),
        'section' => 'floki_general_design',
        'choices' => array(
            'sm-blue' => 'Normal',
            'sm-clean' => 'Lateral color'
        ),
    )
);
	  
	  
	  $wp_customize->add_setting( 'comments', array('sanitize_callback' => 'floki_sanitize_pro_version', 'type' => 'theme_mod') );
	  
	  	  $wp_customize->add_control(
    'comments',
    array(
        'type' => 'checkbox',
        'label' =>  __( 'Allow comments on regular pages', 'floki' ),
        'section' => 'floki_general_design'
    )
);

	  
	  
	  
	  // header options
	  
	  $wp_customize->add_setting( 'logo', array('sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod', 'default' => get_template_directory_uri().'/images/logo.png') );
	  $wp_customize->add_setting( 'hfixed', array('sanitize_callback' => 'floki_sanitize_pro_version', 'type' => 'theme_mod', 'default' => '1') );
	  $wp_customize->add_setting( 'visiblezone1', array('sanitize_callback' => 'floki_sanitize_pro_version', 'type' => 'theme_mod', 'default' => '0') );
	  
	  
	  
	  // header controls
	  
	  $wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'logo',
        array(
            'label' => __( 'Image logo', 'floki' ),
            'section' => 'floki_header_design',
            'settings' => 'logo'
        )
    )
);
	  
	  
	  	  $wp_customize->add_control(
    'hfixed',
    array(
        'type' => 'select',
        'label' => __( 'Header fixed in top page', 'floki' ),
        'section' => 'floki_header_design',
        'choices' => array(
            '0' => 'Non',
            '1' => 'Yes'
        ),
    )
);
	  
	  	  $wp_customize->add_control(
    'visiblezone1',
    array(
        'type' => 'select',
        'label' => __( 'TOP BAR visible', 'floki' ),
        'section' => 'floki_header_design',
        'choices' => array(
            '0' => 'Non',
            '1' => 'Yes'
        ),
    )
);
	  
	  //footer options
	  
	  		$wp_customize->add_setting( 'footerwidgets', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
		 'type' => 'theme_mod',
            'default' => '3'
         ) 
      ); 
	  
	  $wp_customize->add_setting(
    'footertext',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'Floki by Extendyourweb.com'
    )
);
	  
	  
	  //footer controls
	  
	  $wp_customize->add_control(
    'footerwidgets',
    array(
        'type' => 'select',
        'label' => __( 'Widget columns', 'floki' ),
        'section' => 'floki_footer_design',
        'choices' => array(
            'none' => 'None',
            '1' => '1 Column',
            '2' => '2 Column',
            '3' => '3 Column',
			'4' => '4 Column'
        )
    )
);

$wp_customize->add_control(
    'footertext',
    array(
        'label' => __( 'Footer text', 'floki' ),
        'section' => 'floki_footer_design',
        'type' => 'text'
    )
);
	  
	  
	  
	  //sidebar options
	  
	  
	  	  $wp_customize->add_setting(
    'default_sidebar_pos2',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'none'
    )
);

	  $wp_customize->add_control(
    'default_sidebar_pos2',
    array(
        'type' => 'select',
        'label' => __( 'Home', 'floki' ),
        'section' => 'floki_sidebar_design',
        'choices' => array(
            'none' => 'Not show',
            'right' => 'Right',
            'left' => 'Left'
        )
    )
);
	  
	  
	  	  	  $wp_customize->add_setting(
    'default_sidebar_pos',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'none'
    )
);

	  $wp_customize->add_control(
    'default_sidebar_pos',
    array(
        'type' => 'select',
        'label' => __( 'Post', 'floki' ),
        'section' => 'floki_sidebar_design',
        'choices' => array(
            'none' => 'Not show',
            'right' => 'Right',
            'left' => 'Left'
        )
    )
);
	  
	  
	 	  	  	  $wp_customize->add_setting(
    'default_sidebar_pos3',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'none'
    )
);

	  $wp_customize->add_control(
    'default_sidebar_pos3',
    array(
        'type' => 'select',
        'label' => __( 'Page', 'floki' ),
        'section' => 'floki_sidebar_design',
        'choices' => array(
            'none' => 'Not show',
            'right' => 'Right',
            'left' => 'Left'
        )
    )
);

	 	  	  	  $wp_customize->add_setting(
    'default_sidebar_pos4',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'none'
    )
);

	  $wp_customize->add_control(
    'default_sidebar_pos4',
    array(
        'type' => 'select',
        'label' => __( 'Archive', 'floki' ),
        'section' => 'floki_sidebar_design',
        'choices' => array(
            'none' => 'Not show',
            'right' => 'Right',
            'left' => 'Left'
        )
    )
);


// fonts options

	 	  	  	  $wp_customize->add_setting(
    'googlefont',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'Roboto'
    )
);

	  $wp_customize->add_control(
    'googlefont',
    array(
        'type' => 'select',
        'label' => __( 'Text font', 'floki' ),
        'section' => 'floki_fonts_design',
        'choices' => array(
            'not' => 'Manual font',
            'Open+Sans' => 'Open Sans',
            'Josefin+Slab' => 'Josefin Slab',
			'Arvo' => 'Arvo',
			'Lato' => 'Lato',
			'Vollkorn' => 'Vollkorn',
			'Abril+Fatface' => 'Abril Fatface',
			'Roboto' => 'Roboto'
        )
    )
);

	 	  	  	  $wp_customize->add_setting(
    'headingfont',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'Arvo'
    )
);

	  $wp_customize->add_control(
    'headingfont',
    array(
        'type' => 'select',
        'label' => __( 'Headings font(h1, h2, ...)', 'floki' ),
        'section' => 'floki_fonts_design',
        'choices' => array(
            'not' => 'Same font',
            'Open+Sans' => 'Open Sans',
            'Josefin+Slab' => 'Josefin Slab',
			'Arvo' => 'Arvo',
			'Lato' => 'Lato',
			'Vollkorn' => 'Vollkorn',
			'Abril+Fatface' => 'Abril Fatface',
			'Roboto' => 'Roboto'
        )
    )
);

	 	  	  	  $wp_customize->add_setting(
    'manualfont',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => 'Times'
    )
);

$wp_customize->add_control(
    'manualfont',
    array(
        'label' => __( 'Manual font', 'floki' ),
        'section' => 'floki_fonts_design',
        'type' => 'text'
    )
);


	 	  	  	  $wp_customize->add_setting(
    'sizefont',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => '14px'
    )
);

$wp_customize->add_control(
    'sizefont',
    array(
        'label' => __( 'Size font', 'floki' ),
        'section' => 'floki_fonts_design',
        'type' => 'text'
    )
);

	 	  	  	  $wp_customize->add_setting(
    'sizefonth1',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => '32px'
    )
);

$wp_customize->add_control(
    'sizefonth1',
    array(
        'label' => __( 'H1 Size font', 'floki' ),
        'section' => 'floki_fonts_design',
        'type' => 'text'
    )
);

	 	  	  	  $wp_customize->add_setting(
    'sizefonth2',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => '28px'
    )
);

$wp_customize->add_control(
    'sizefonth2',
    array(
        'label' => __( 'H2 Size font', 'floki' ),
        'section' => 'floki_fonts_design',
        'type' => 'text'
    )
);

	 	  	  	  $wp_customize->add_setting(
    'sizefonth3',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => '24px'
    )
);

$wp_customize->add_control(
    'sizefonth3',
    array(
        'label' => __( 'H3 Size font', 'floki' ),
        'section' => 'floki_fonts_design',
        'type' => 'text'
    )
);

	 	  	  	  $wp_customize->add_setting(
    'sizefonth4',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => '20px'
    )
);

$wp_customize->add_control(
    'sizefonth4',
    array(
        'label' => __( 'H4 Size font', 'floki' ),
        'section' => 'floki_fonts_design',
        'type' => 'text'
    )
);

	 	  	  	  $wp_customize->add_setting(
    'sizefonth5',
    array(
	'sanitize_callback' => 'floki_sanitize_pro_version',
	'type' => 'theme_mod',
        'default' => '16px'
    )
);

$wp_customize->add_control(
    'sizefonth5',
    array(
        'label' => __( 'H5 Size font', 'floki' ),
        'section' => 'floki_fonts_design',
        'type' => 'text'
    )
);


	  
	  // Design colors
	  
		$wp_customize->add_setting( 'colorzone6', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
		 'sanitize_callback' => 'sanitize_hex_color',
            'default' => '#ffffff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  
	  
	  	  $wp_customize->add_setting( 'colorzone1', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#3498DB', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  $wp_customize->add_setting( 'colorzone2', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#ffffff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  $wp_customize->add_setting( 'colorzone5', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#ffffff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  	  $wp_customize->add_setting( 'colorzone3', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#444444', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  	  $wp_customize->add_setting( 'colorzone4', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#222222', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  	  	  $wp_customize->add_setting( 'menu_design', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#34495E', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  
	  
	  
      
      // Register fonts colors
	  	  
	    $wp_customize->add_setting( 'colorfont', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#7F8C8D', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
        $wp_customize->add_setting( 'colorfont2', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#3B97D2', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 

	    $wp_customize->add_setting( 'colorfont4', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#48B7FF', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	    $wp_customize->add_setting( 'colorfont3', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#235A7D', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	    $wp_customize->add_setting( 'menupading', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#34495e', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  	    $wp_customize->add_setting( 'menusize2',         array(
				'sanitize_callback' => 'floki_sanitize_pro_version',
				'type' => 'theme_mod',
            'default' => '#cccccc') //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
      );
	  
	  
	  
	  
	  	    $wp_customize->add_setting( 'menusize', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#2c3e50', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	    $wp_customize->add_setting( 'menu_posi', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#ffffff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  	    $wp_customize->add_setting( 'menupading2', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#ffffff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  
	  $wp_customize->add_setting( 'colorfonth1', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#3B97D2', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  $wp_customize->add_setting( 'colorfonth2', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#3B97D2', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  $wp_customize->add_setting( 'colorfonth3', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#3B97D2', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  $wp_customize->add_setting( 'colorfonth4', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#3B97D2', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  	  $wp_customize->add_setting( 'colorfonth5', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
		 'sanitize_callback' => 'floki_sanitize_pro_version',
            'default' => '#3B97D2', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      ); 
	  
	  
	  // header

	  
	  //Controls design
	  
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_background_color', //Set a unique ID for the control
         array(
            'label' => __( 'Lateral', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_colors_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorzone6', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_header_color', //Set a unique ID for the control
         array(
            'label' => __( 'Header', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_colors_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorzone2', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_topbar_color', //Set a unique ID for the control
         array(
            'label' => __( 'Top Bar', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_colors_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorzone1', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_submenubk_color', //Set a unique ID for the control
         array(
            'label' => __( 'Submenus', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_colors_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'menu_design', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_content_color', //Set a unique ID for the control
         array(
            'label' => __( 'Content', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_colors_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorzone5', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  	  		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_footer1_color', //Set a unique ID for the control
         array(
            'label' => __( 'Footer', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_colors_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorzone3', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  	  		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_footer2_color', //Set a unique ID for the control
         array(
            'label' => __( 'Footer bottom', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_colors_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorzone4', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  

            
      //Controls colors texts
	  
	    $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Text color', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorfont', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  
        $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_link_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Link color', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorfont2', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	    $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_link_over_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Link hover color', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorfont4', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_link_visited_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Link visited color', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorfont3', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  
	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_menu_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Main menu', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'menupading', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_menu_active_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Main menu active button', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'menusize', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_submenus_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Submenus', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'menu_posi', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_menu2_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Secondary menu', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'menupading2', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  
	  	  	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'floki_menusize2_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Footer', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'menusize2', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  
	 
	  
	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'colorfonth1', //Set a unique ID for the control
         array(
            'label' => __( 'H1', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorfonth1', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'colorfonth2', //Set a unique ID for the control
         array(
            'label' => __( 'H2', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorfonth2', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'colorfonth3', //Set a unique ID for the control
         array(
            'label' => __( 'H3', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorfonth3', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  
	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'colorfonth4', //Set a unique ID for the control
         array(
            'label' => __( 'H4', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorfonth4', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  	  	$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'colorfonth5', //Set a unique ID for the control
         array(
            'label' => __( 'H5', 'floki' ), //Admin-visible name of the control
            'section' => 'floki_text_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'colorfonth5', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
      	  
      //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
      //$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
      //$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
      //$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
      //$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	  //$wp_customize->get_setting( 'colorfont2' )->transport = 'postMessage';
   }
   
   
   /**
    * This outputs the javascript needed to automate the live settings preview.
    * Also keep in mind that this function isn't necessary unless your settings 
    * are using 'transport'=>'postMessage' instead of the default 'transport'
    * => 'refresh'
    * 
    * Used by hook: 'customize_preview_init'
    * 
    * @see add_action('customize_preview_init',$func)
    * @since floki 1.0
    */
   public static function live_preview() {
      wp_enqueue_script( 
           'floki-themecustomize', // Give the script a unique ID
           get_template_directory_uri() . '/js/theme-customize.js', // Define the path to the JS file
           array(  'jquery', 'customize-preview' ), // Define dependencies
           '1.2', // Define a version (optional) 
           true // Specify whether to put in footer (leave this true)
      );
   }
	
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'floki_Customize' , 'register' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'floki_Customize' , 'live_preview' ) );

function floki_sanitize_text( $input ) {

    return wp_kses_post( force_balance_tags( $input ) );

}

function floki_sanitize_pro_version( $input ) {

    return $input;

}

function floki_sanitize_number( $input ) {

    return force_balance_tags( $input );

}


?>