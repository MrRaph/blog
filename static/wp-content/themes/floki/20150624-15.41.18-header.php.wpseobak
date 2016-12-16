<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>

		<!-- "Floki": The HTML-5 WordPress Template Theme -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
		
		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<meta name="description" content="<?php bloginfo('description'); ?>">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
        <?php if(floki_get_option( 'favicon' ) && floki_get_option( 'favicon' )!=""): ?>
	<link rel="shortcut icon" href="<?php echo esc_url(floki_get_option( 'favicon' )); ?>" type="image/x-icon" />
	<?php endif; ?>

	<?php if(floki_get_option( 'iconapple' ) && floki_get_option( 'iconapple' )!=""): ?>
	<!-- For iPhone -->
	<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url(floki_get_option( 'iconapple' )); ?>">
	<?php endif; ?>

	<?php if(floki_get_option( 'iconapple2' ) && floki_get_option( 'iconapple2' )!=""): ?>
	<!-- For iPhone 4 Retina display -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo esc_url(floki_get_option( 'iconapple2' )); ?>">
	<?php endif; ?>

	<?php if(floki_get_option( 'iconapple3' ) && floki_get_option( 'iconapple3' )!=""): ?>
	<!-- For iPad -->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo esc_url(floki_get_option( 'iconapple3' )); ?>">
	<?php endif; ?>

	<?php if(floki_get_option( 'iconapple4' ) && floki_get_option( 'iconapple4' )!=""): ?>
	<!-- For iPad Retina display -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo esc_url(floki_get_option( 'iconapple4' )); ?>">
	<?php endif; ?>
        

<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
    
    
    <header>
    
        <?php 
		$topmargin=67;
		
		if(floki_get_option( 'visiblezone1' )=="1") { 
		
		?>   
      <div class="menutop">
    <div class="container">
        
        <div class="nine columns">
       	<div class="social-icons">
       			
            
            
            
                        <?php if(floki_get_option( 'stylezone1' )=="degradate")  floki_printsocial(floki_get_option( "tipesocial" )); ?>
           
           <?php if(floki_get_option( 'menu_posi2' )=="top") {?>
            
            <a class="toggleMenu2" href="#" style="float:right"><img src="<?php echo get_template_directory_uri(); ?>/images/mobile_menu.png" /></a>
            
            <?php } ?>
            
            </div>
            
            
            
             <?php if(floki_get_option( 'menu_posi2' )=="top2") {?>
       
			<?php wp_nav_menu( array( 'theme_location' => 'extra-menu', 'menu_class' => 'sm sm-clean', 'menu_id'  => 'main-menu2' ) ); ?>
         
         
            <?php } ?>
            
           </div>
           <div class="nine columns" style="text-align:right"> 
           
            <div class="social-icons">
            
			<?php if(floki_get_option( 'menu_posi2' )=="top2") {?>
            
            <a class="toggleMenu2" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/mobile_menu.png" /></a>
            
            <?php } ?>
            
            
            <?php if(floki_get_option( 'stylezone1' )=="otro") floki_printsocial(floki_get_option( "tipesocial" ));
			 ?>
           
           </div>
           

            
             <?php if(floki_get_option( 'menu_posi2' )=="top") {?>
       
			<?php wp_nav_menu( array( 'theme_location' => 'extra-menu', 'menu_class' => 'sm sm-clean', 'menu_id'  => 'main-menu2' ) ); ?>
        
         
            <?php } ?>
           
          
         </div>
         </div>
         </div>
         
         <?php } ?>
         
        
         
         <div class="logo">
    <div class="container">
		
        <div class="four columns" >
        <?php if(floki_get_option( 'logo' )!="") {?>
        
        
        <a href="<?php echo home_url(); ?>/"><img id="logoweb" name="logoweb" src="<?php echo esc_url(floki_get_option( 'logo' )); ?>" /></a>
        
        <?php }
		
		else { 
		
		?>
        
		
            <h1 id="logoweb" name="logoweb"><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> <a class="toggleMenu" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/mobile_menu.png" /></a></h1>
  
            
        <?php } ?>
        
        <?php if(floki_get_option( 'logo' )!="") {?>
		<a class="toggleMenu" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/mobile_menu.png" /></a>
         <?php } ?>
         
       </div>
        
           
        
       
        <div class="fourteen columns" style="float:right;">
			<nav>
				<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'menu_class' => 'nav cl-effect-21', 'menu_id'  => 'menu' ) ); ?>
			</nav>
         </div>
   
        
		</div>
        
        
         </div>

</header> 

<div class="firstdiv"></div>

<?php if(is_front_page() && (floki_get_option( 'hslider' )!="none" && floki_get_option( 'hslider' )!="")) { ?>

          <div class="nav2">
        <div class="shadow-top"></div>
         <?php echo apply_filters( 'the_content', esc_attr(floki_get_option( 'hslider' ))); ?>      
        <div class="shadow-bottom"></div>
         </div> 
         <?php } ?>
		 
         <?php if(is_front_page() && (floki_get_option( 'mainimage' )!="" || floki_get_option( 'headertitle' )!="" || floki_get_option( 'headerdescription' )!="")) { ?>

          <div class="nav2" style="height:500px; overflow:hidden;">
                 
        <div class="shadow-top"></div>
        

         
         <center id="mainheader" name="mainheader">

         <div class="backmainheader">

         <?php
		 
		 if(floki_get_option( 'headertitle' )!="" || floki_get_option( 'headerdescription' )!="") {
			 
			 ?>
             <div class="text">
			 <?php
		 
			 if(floki_get_option( 'headertitle' )!="") {
				 ?>
				 
				 <h2><?php echo esc_html(floki_get_option( 'headertitle' )); ?></h2>
				 <?php }
				 
			 if(floki_get_option( 'headerdescription' )!="") {
				 ?>
				  <br/><span><?php echo esc_html(floki_get_option( 'headerdescription' )); ?></span>
				 <?php } ?>
			 </div>
             <?php
		 }
			 
			 ?>
                 
         </div>
 
         </center> 

        <div class="shadow-bottom"></div>
        
         </div> 
         <?php } ?>