<footer>
         <?php if (floki_get_option( 'footerwidgets' )!="none") { ?>
        <div class="container" style="margin-bottom:50px">
        
       
        <?php 
		global $googlemarkup;
		
		echo $googlemarkup;
		
		$csswidget="four columns";
		
		if(floki_get_option( 'footerwidgets' )=="3") $csswidget="six columns";
		if(floki_get_option( 'footerwidgets' )=="2") $csswidget="nine columns";
		if(floki_get_option( 'footerwidgets' )=="1") $csswidget="";
		
		$cont=1;
		while($cont<=floki_get_option( 'footerwidgets' )) {
		
			echo '<div class="'.$csswidget.'">';
			dynamic_sidebar( 'footer'.$cont ); 
			echo '</div>';
			$cont++;
		
		}
		
		?>
        
      
        </div>
           <?php } ?>
        
    
        
        
         <div class="footer2">
        
         <?php if (floki_get_option( 'footersocial' )!="none") { ?>
         
         
         <div class="nine columns"  style="padding-top:37px;">
         
         <?php echo esc_textarea(floki_get_option( 'footertext' )); ?>
         
         </div>
         
         <div class="nine columns socialfooter">
         
         <?php floki_printsocial(floki_get_option( "footersocial" )); ?>

         
         </div>
         <?php } else { ?>
			
            <p><?php echo esc_textarea(floki_get_option( 'footertext' )); ?></p>
            
            <?php } ?>
            
            
            
            
            
            </div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>