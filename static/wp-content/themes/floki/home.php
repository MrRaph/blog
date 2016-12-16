<?php 

	global $tipopage,$revslider,$layerslider,$pageslider,$floki_custom_sidebar,$blogcategory,$spinfo,$sptitle,$spimage,$sporder,$spcontent,$sporde,$visiblezone,$bimage,$bimage2,$bimage3,$bimage4,$bcolor1,$bcolor2,$spcont,$backdot,$youtubeback;
	
	global $parallaxani;
	

get_header(); ?>

<?php

// options page
$content_css = '';
$sidebar_css = '';
$mainclass="fullwidth";

$spinfo=1;

global $menu_design6;

//$tipopage=get_post_meta($post->ID, 'pagetype', true);

$tipopage=floki_get_option( 'default_sidebar_pos2' );
$tipopagemain=$tipopage;

if($tipopage=="" || ($tipopage != 'left' && $tipopage != 'right')) $tipopage="full";

if($tipopage == 'left') {
		$content_css = 'thirteen columns';
$mainclass="";
	}
	if($tipopage == 'right') {
		$content_css = 'thirteen columns';
$mainclass="";
	}

 ?>
 
 <?php if($tipopage=="left" || $tipopage == 'right') { ?>

<div class="container" style=" <?php  if($menu_design6=="sm-clean" || $menu_design6=="bimage") {
	
	echo 'width:100%;';
if($tipopage == 'left') {
		$content_css = 'thirteen columns';
$mainclass="";
	}
	if($tipopage == 'right') {
		$content_css = 'thirteen columns';
$mainclass="";
	}	
}
	 ?>" >

<?php } ?>	

<?php if($tipopage=="left") { ?>

		<div class="five columns sidebarleft">
<?php get_sidebar(); ?>
		</div>

	<?php } ?>	
    
<div class="<?php echo $content_css; ?> pagearticle">
		<section>

			<?php
            
			if ( have_posts() ) : while (have_posts()) : the_post();


setup_postdata( $post );

 ?>

				<article id="post-<?php the_ID(); ?>"  class=" <?php echo $mainclass; ?> hiddenover" style="overflow:hidden !important; ">
            
             <?php if($tipopage=="" || $tipopage == 'full') { ?>

<div class="container">

<?php } 	?>

 
<div class="flokipost">


<div class="postinfo">

<?php 


$format = get_post_format(get_the_ID());
if ( false === $format ) {
	$format = '';
}
$icon_post="";
if($format!="") {
	$icon_post='<h2><img class="svg" src="'.get_template_directory_uri().'/images/svg/'.$format.'.svg" /></h2>';
}

echo '<h2>'.get_the_time('j').'</h2>';
echo '<strong>'.strtoupper(get_the_time('M Y')).'</strong><br/>';
echo $icon_post;
if (comments_open()){
	echo '<strong>';
	comments_popup_link('', '1', '%');
	echo ' <img class="svg" src="'.get_template_directory_uri().'/images/svg/commentsico.svg" /></strong>';
}
 ?>

</div>

<div <?php post_class(); ?> style="float:left; width:83%;">


	
	
 <?php
		
		if (has_post_thumbnail()) {

	the_post_thumbnail();

}

echo '<div class="infopostfloki">';

echo '<h2>';
echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';
echo '</h2><strong>';



_e( 'Posted by ', 'floki' );

echo get_the_author();

echo '</strong> | ';

the_category(', ');

		
echo '</div>';

		?>

<?php  the_content('<button>'.__( 'Read more', 'floki' ).' &raquo;</button>'); ?>
    
           </div>         
		</div>	
        <div style="clear:both"></div>	
                
                             <?php if($tipopage=="" || $tipopage == 'full') { ?>

</div>

<?php  } ?>	

			</article>

			<?php endwhile; ?>

			<nav>
                
          
                <?php 

next_posts_link('<div style="float:right; margin:50px;" class="pagination button">'.__('Older Entries',  'floki').'</div>'); 
?>


<?php 
previous_posts_link('<div style="float:left; margin:50px;" class="pagination button">'.__('Newer Entries', 'floki').'</div>'); 

?>

                
			</nav>

			<?php else : ?>

			<article>
				<h3><?php _e( 'Not found', 'floki' ); ?></h3>
				<p><?php _e( 'Sorry, no posts matched your criteria.', 'floki'); ?></p>
				<?php get_search_form(); ?>
			</article>

			<?php endif; ?>

		</section>

</div>

<?php if($tipopage=="right") { ?>

		<div class="five columns sidebarright">
<?php get_sidebar(); ?>
		</div>

	<?php } ?>	
	
	<!-- /wrapper -->
 <?php if($tipopage=="left" || $tipopage == 'right') { ?>

</div>

<?php } ?>	

<?php get_footer(); ?>