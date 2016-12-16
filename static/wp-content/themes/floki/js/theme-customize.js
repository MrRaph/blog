( function( $ ) {

	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '#site-title a' ).html( newval );
		} );
	} );
	
	//Update the site description in real time...
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newval ) {
			$( '.site-description' ).html( newval );
		} );
	} );

	//Update site title color in real time...
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( newval ) {
			$('#site-title a').css('color', newval );
		} );
	} );

	//Update site background color...
	wp.customize( 'colorzone6', function( value ) {
		value.bind( function( newval ) {
			$('body').css('background-color', newval );
		} );
	} );
	
	//Update header background color...
	wp.customize( 'colorzone2', function( value ) {
		value.bind( function( newval ) {
			$('.logo').css('background-color', newval );
		} );
	} );
	
		//Update top bar header background color...
	wp.customize( 'colorzone1', function( value ) {
		value.bind( function( newval ) {
			$('.menutop').css('background-color', newval );
		} );
	} );
	
		//Update Content background color...
	wp.customize( 'colorzone5', function( value ) {
		value.bind( function( newval ) {
			$('section').css('background-color', newval );
		} );
	} );
	
			//Update Footer background color...
	wp.customize( 'colorzone3', function( value ) {
		value.bind( function( newval ) {
			$('footer').css('background-color', newval );
		} );
	} );
	
			//Update Footer 2 background color...
	wp.customize( 'colorzone4', function( value ) {
		value.bind( function( newval ) {
			$('.footer2').css('background-color', newval );
		} );
	} );
	
				//Update submenus background color...
	wp.customize( 'menu_design', function( value ) {
		value.bind( function( newval ) {
			$('.nav li ul').css('background-color', newval );
		} );
	} );
	
	
	
	//Update text color
	wp.customize( 'colorfont', function( value ) {
		value.bind( function( newval ) {
			$('body').css('color', newval );
		} );
	} );
	
	//Update site link color in real time...
	wp.customize( 'colorfont2', function( value ) {
		value.bind( function( newval ) {
			$('a').css('color', newval );
		} );
	} );
	
		//Update site link color in real time...
	wp.customize( 'colorfont4', function( value ) {
		value.bind( function( newval ) {

			$('a').hover(function(){
					$(this).css({'color': newval});
				});
			
		} );
	} );
	
		//Update site link color in real time...
	wp.customize( 'colorfont3', function( value ) {
		value.bind( function( newval ) {
			$('a:visited').css('color', newval );
		} );
	} );
	
			//Update site link color in real time...
	wp.customize( 'menupading', function( value ) {
		value.bind( function( newval ) {
			$('.nav a').css('color', newval );
		} );
	} );
	
			//Update site link color in real time...
	wp.customize( 'menusize', function( value ) {
		value.bind( function( newval ) {
			$('.current_page_item  > a, .current-menu-item > a').css('color', newval );
		} );
	} );
	
			//Update site link color in real time...
	wp.customize( 'menu_posi', function( value ) {
		value.bind( function( newval ) {
			$('a:visited').css('color', newval );
		} );
	} );
	
				//Update site link color in real time...
	wp.customize( 'menupading2', function( value ) {
		value.bind( function( newval ) {
			$('.sm-clean a').css('color', newval );
		} );
	} );
	
					//Update headings colors
	wp.customize( 'colorfonth1', function( value ) {
		value.bind( function( newval ) {
			$('h1').css('color', newval );
		} );
	} );
	
	wp.customize( 'colorfonth2', function( value ) {
		value.bind( function( newval ) {
			$('h2').css('color', newval );
		} );
	} );
	
	wp.customize( 'colorfonth3', function( value ) {
		value.bind( function( newval ) {
			$('h3').css('color', newval );
		} );
	} );
	
	wp.customize( 'colorfonth4', function( value ) {
		value.bind( function( newval ) {
			$('h4').css('color', newval );
		} );
	} );
	
	wp.customize( 'colorfonth5', function( value ) {
		value.bind( function( newval ) {
			$('h5').css('color', newval );
		} );
	} );
	
} )( jQuery );