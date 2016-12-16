<?php
/*
Template Name: Blog
*/

get_header(); ?>

 <?php 

global $menu_design6,$parallaxani,$options, $tipopage,$layerslider,$revslider,$anidiv,$aniimg,$anilink,$anip,$anih,$pageslider,$floki_custom_sidebar,$blogcategory,$spinfo,$sptitle,$spimage,$sporder,$spcontent,$sporde,$visiblezone,$bimage,$bimage2,$bimage3,$bimage4,$bcolor1,$bcolor2,$spcont,$backdot,$backtyp,$youtubeback,$youtubemute, $youtubesize;


global $parallaxani;

echo floki_get_breadcrumbfloki(); ?>

<?php



// options page
$content_css = '';
$sidebar_css = '';
$mainclass="fullwidth";

global $menu_design6;

$tipopage="";

$tipopagemain=$tipopage;

if($tipopage=="default" || $tipopage=="") $tipopage=floki_get_option( 'default_sidebar_pos3' );



if($tipopage=="" || ($tipopage != 'left' && $tipopage != 'right')) $tipopage="full";

if($tipopage == 'left') {
		$content_css = 'thirteen columns';

	}
	if($tipopage == 'right') {
		$content_css = 'thirteen columns';

	}

 ?>
 
 <?php if($tipopage=="left" || $tipopage == 'right') { ?>
<section>

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
        
        
         
             <?php if($tipopage=="" || $tipopage == 'full') { ?>

<div class="container" >


<?php } 	?>

        <article class="<?php if (has_post_thumbnail()) echo 'pbt'; ?>">
        
        <?php
		
		if (has_post_thumbnail()) {

	the_post_thumbnail();

}

		$contposts=0;
		?>
        
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php the_content('Read more on "'.the_title('', '', false).'" &raquo;'); ?>
        <?php endwhile;  endif;?>
        </article>
         
             <?php if($tipopage=="" || $tipopage == 'full') { ?>

</div>

<?php } 	?>



			<?php
			
			wp_reset_postdata();


			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array('paged' => $paged);

query_posts($args); 





if ( have_posts() ) : while (have_posts()) : the_post();


setup_postdata( $post );
			
			?>
            

			<article id="post-<?php the_ID(); ?>" class="<?php echo $mainclass; ?> hiddenover">
            
             <?php if(isset($extra)) echo $extra; ?>
            
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
		
		if (has_post_thumbnail()  && $spimage==1) {

	the_post_thumbnail();

}

echo '<div class="infopostfloki">';

echo '<h2>';
echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';
echo '</h2>';



	
	echo '<strong>';
_e( 'Posted by ', 'floki' );

echo get_the_author();
echo '</strong> | ';


the_category(', ');

		
echo '</div>';

		?>

<?php global $more; $more = 0;   the_content('<button>'.__( 'Read more', 'floki' ).' &raquo;</button>'); ?>
           
                    
           </div>         
                    
		</div>	
        <div style="clear:both"></div>	


                
                             <?php if($tipopage=="" || $tipopage == 'full') { ?>

</div>

<?php  } ?>	


               <?php if(isset($extraend)) echo $extraend; ?>  
			</article>

<?php 
$contposts++;

endwhile; ?>
<!-- pagination -->



<?php 

next_posts_link('<div style="float:right; margin:50px;" class="pagination button">'.__('Next Page >>',  'floki').'</div>'); 
?>


<?php 
previous_posts_link('<div style="float:left;margin:50px;" class="pagination button">'.__('<< Previous Page', 'floki').'</div>'); 

?>


<?php else : ?>
<!-- No posts found -->
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
</section>
<?php } ?>	



<?php get_footer(); ?>