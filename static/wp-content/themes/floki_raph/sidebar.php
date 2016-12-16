	<?php 

$sidebar_choice = get_post_meta($post->ID, 'floki_custom_sidebar', true);

if($sidebar_choice=="" || $sidebar_choice=="default") $sidebar_choice="mainsidebar";
  
?>  
 
      
    <ul class="widgets">  
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :   
            dynamic_sidebar($sidebar_choice);  
        else :   
            /* No widget */  
        endif; ?>  
    </ul>  