<?php get_header(); ?>

 <?php 
global $tipopage,$layerslider,$revslider,$pageslider,$floki_custom_sidebar,$blogcategory,$spinfo,$sptitle,$spimage,$sporder,$spcontent,$sporde,$visiblezone,$bimage,$bimage2,$bimage3,$bimage4,$bcolor1,$bcolor2,$spcont,$backdot,$youtubeback;

global $parallaxani;

$contposts=0;
		 

$title="";

if (have_posts()) : ?>

			<?php 
			
			$post = $posts[0]; 
			 if (is_category()) { 
             
			 $current_category = single_cat_title("", false);
			 
             $title=$current_category;
			

			 } elseif(is_tag()) {
			 $title="";

			 } elseif (is_day()) {
			 $title="".get_the_time('F jS, Y');

			 } elseif (is_month()) { 
			 $title="".get_the_time('F, Y');

			 } elseif (is_year()) { 
			 $title="".get_the_time('Y');

			} elseif (is_author()) {
			 $title="";

			} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { 
			 $title="";

		 } endif; 
         
         ?>


<?php



echo floki_get_breadcrumbfloki3($title, "");



// options page
$content_css = '';
$sidebar_css = '';
$mainclass="fullwidth";

global $menu_design6;

$tipopage=floki_get_option( 'default_sidebar_pos4' );

$tipopagemain=$tipopage;





if($tipopage=="" || ($tipopage != 'left' && $tipopage != 'right')) $tipopage="full";

if($tipopage == 'left') {
		$content_css = 'ten columns';

	}
	if($tipopage == 'right') {
		$content_css = 'ten columns';

	}

 ?>
 
 <?php if($tipopage=="left" || $tipopage == 'right') { ?>
<section>

<div class="container" style=" <?php  if($menu_design6=="sm-clean" || $menu_design6=="bimage") {
	
	echo 'width:100%; padding-left:50px;';
if($tipopage == 'left') {
		$content_css = 'twelve columns';
$mainclass="";
	}
	if($tipopage == 'right') {
		$content_css = 'twelve columns';
$mainclass="";
	}	
}
	 ?>" >

<?php } ?>	

<?php if($tipopage=="left") { ?>

		<div class="four columns sidebarleft">
<?php get_sidebar(); ?>
		</div>

	<?php } ?>	
    
<div class="<?php echo $content_css; ?> pagearticle">
		<section style="margin-top: 50px;" >
        
        
         
             <?php if($tipopage=="" || $tipopage == 'full') { ?>

<div class="container">


<?php } 	?>


         
             <?php if($tipopage=="" || $tipopage == 'full') { ?>

</div>

<?php } 	?>



			<?php
			
			





if ( have_posts() ) : while (have_posts()) : the_post();


setup_postdata( $post );
			
			?>
            
            
            

			<article id="post-<?php the_ID(); ?>" class="<?php echo $mainclass; ?> hiddenover" style="overflow:hidden !important;">

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

<div style="float:left; width:80%;">


	
	
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

		<div class="four columns sidebarright">
<?php get_sidebar(); ?>
		</div>

	<?php } ?>	
	
	<!-- /wrapper -->
 <?php if($tipopage=="left" || $tipopage == 'right') { ?>

</div>
</section>
<?php } ?>	



<?php get_footer(); ?>