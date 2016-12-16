<?php get_header(); ?>



<?php

$style="";

global $tipopage,$layerslider,$revslider,$pageslider,$floki_custom_sidebar,$blogcategory,$spinfo,$sptitle,$spimage,$sporder,$spcontent,$sporde,$visiblezone,$bimage,$bimage2,$bimage3,$bimage4,$bcolor1,$bcolor2,$spcont,$backdot,$youtubeback;

// options page
$content_css = '';
$sidebar_css = '';
$mainclass="";

$tipopage=floki_get_option( 'default_sidebar_pos' );
$tipopagemain=$tipopage;

if($tipopage=="" || ($tipopage != 'left' && $tipopage != 'right')) $tipopage="full";

if($tipopage == 'left') {
		$content_css = 'fourteen columns sl';
$mainclass="grid2";
	}
	if($tipopage == 'right') {
		$content_css = 'fourteen columns sr';
$mainclass="grid2";
	}


echo floki_get_breadcrumbfloki(); ?>


<section>

 <?php
 
 $cssextra="";
 
  if($tipopage=="left" || $tipopage == 'right') { 
  
   $cssextra="";
  
  ?>


<div class="container" style=" <?php  if($menu_design6=="sm-clean" || $menu_design6=="bimage") {
	
	echo 'width:100%;';
if($tipopage == 'left') {
		$content_css = 'fourteen columns sl';
$mainclass="";
	}
	if($tipopage == 'right') {
		$content_css = 'fourteen columns sr';
$mainclass="";
	}	
}
	 ?>" >


<?php } 

else {
	
	//$style="padding-top: 50px;";
	
}
?>	

<?php if($tipopage=="left") { ?>

		<div class="four columns sidebarleft">
        
<?php if($floki_custom_sidebar=="" || $floki_custom_sidebar=="default") get_sidebar(); else  get_sidebar($floki_custom_sidebar); ?>
    
		</div>

	<?php } ?>	




<div class="<?php echo $content_css; ?>">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


			<article id="post-<?php the_ID(); ?>" class="<?php echo $mainclass; ?> hiddenover">

				
<?php if($tipopage=="" || $tipopage == 'full') {  ?>


<div class="container">

<?php } 	?>

<div class="flokipost" style="<?php echo  $cssextra;  ?>">

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

echo '<div style="margin-top: 15px; margin-bottom: 15px;">';

_e( 'Posted by ', 'floki' );

echo get_the_author();

echo ' | ';

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
		
        <?php if(is_single($post)) include("coments.php"); ?>
	<?php endwhile; else: ?>

	
			<article>
				<p><?php _e( 'Sorry, no posts matched your criteria.', 'floki' ); ?></p>
			</article>
            

		

	<?php endif; ?>
</div>



<?php if($tipopage=="right") { ?>

		<div class="four columns sidebarright">
        
      
<?php 

if($floki_custom_sidebar=="" || $floki_custom_sidebar=="default") get_sidebar(); 

else  get_sidebar("custom"); 

?>



		</div>

	<?php } ?>	
	
 <?php if($tipopage=="left" || $tipopage == 'right') { ?>

</div>

<?php } ?>	


                   <?php if(is_single($post)) {
				
				next_post_link('<div style="float:right; margin:50px;" class="pagination button2"> %link </div>'); 
				
				previous_post_link('<div style="float:left; margin:50px;" class="pagination button2"> %link </div>'); 
				
				
			}
				?>


</section>

<?php get_footer(); ?>