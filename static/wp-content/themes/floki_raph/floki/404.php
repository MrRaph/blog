<?php
/**
 * The template for displaying 404 pages (Not Found).
**/
?>
<?php get_header(); ?>
<div style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/error.png');">
<br/><br/>
		<div class="container">
        <h1 style="text-align:center;"><img class="svg" src="<?php echo get_template_directory_uri(); ?>/images/svg/sos.svg" /> <?php echo __( 'ERROR 404, PAGE NOT FOUND', 'floki' ); ?></h1><br/>
			<div style="margin: 0 auto; width:534px; height: 328px;">
				<div style="margin-left:92px; width:170px;">
                <br/>
                
                </div>
			</div>
          
				<center>
                
               
               <?php get_search_form(); ?>
                 
				</center>
		</div>
<br/><br/>
</div>

<?php get_footer(); ?>