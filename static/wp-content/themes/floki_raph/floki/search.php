<?php get_header(); ?>

<?php echo floki_get_breadcrumbfloki3(__( 'Search Results for', 'floki' ), get_search_query()); ?>

		<section>
        <div class="container" style="margin-top: 50px; margin-bottom: 50px;">

			<?php if (have_posts()) : ?>

			<article id="post-<?php the_ID(); ?>">
				<ol>

					<?php while (have_posts()) : the_post(); ?>
           <br/>          

<div style="float:left; width: 15%; margin-right: 15px; text-align:center;">

<?php echo '<h2>'.get_the_time('j').'</h2>';
 echo '<strong>'.strtoupper(get_the_time('M Y')).'</strong><hr style="margin:10px" />';

 echo '<strong><img class="svg" src="'.get_template_directory_uri().'/images/svg/commentsico.svg" height="15px"/><br/>';

comments_popup_link('', '1', '%');
 ?>
</strong>
</div>

<div style="float:left; width:80%;">


	
	
 <?php
	

echo '<div style="margin-top: 15px; margin-bottom: 15px;" class="postinfo">';

echo '<h2>';
echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';
echo '</h2><strong>';



_e( 'Posted by ', 'floki' );

echo get_the_author();

echo '</strong> | ';

the_category(', ');

		
echo '</div>';

		?>


				<?php	
				
				
				$content = get_the_content();
$content = preg_replace('/(<)([img])(\w+)([^>]*>)/', '', $content);
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
$content=  strip_tags($content);

$content= str_replace(get_search_query(), "<strong>".get_search_query()."</strong>", $content);

echo $content;
				
				 ?>

			
                    
                    
                    
                    
		</div>	
        <div style="clear:both"></div>	
                    
                    <br/>
                     <br/>
                    
                    <hr/>

					<?php endwhile; ?>

				</ol>
			</article>
			<nav>
				
                
                
                <?php 

next_posts_link('<div style="float:right; margin:50px;" class="pagination button">'.__('Next Page >>',  'floki').'</div>'); 
?>


<?php 
previous_posts_link('<div style="float:left;margin:50px;" class="pagination button">'.__('<< Previous Page', 'floki').'</div>'); 

?>
                
			</nav>

			<?php else : ?>

			<article>
				<h3><?php _e( 'Not Found', 'floki' ); ?></h3>
				<p><?php _e( 'Sorry, but the requested resource was not found on this site.', 'floki' ); ?></p>
				<?php get_search_form(); ?>
			</article>

			<?php endif; ?>
</div>
		</section>



<?php get_footer(); ?>