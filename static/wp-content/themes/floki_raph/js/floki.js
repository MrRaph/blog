animation=floki.animation;
parallaxani=floki.parallaxani;
var ww = 0;
	jQuery(document).ready(function(){
/* menu  responsive */
ww =jQuery(window).width();

	jQuery(".nav li a").each(function() {
		if (jQuery(this).next().length > 0) {
			jQuery(this).addClass("parent");
		};
	})
	
	jQuery(".toggleMenu").click(function(e) {
		e.preventDefault();
		jQuery(this).toggleClass("active");
		jQuery(".nav").toggle("slow");
	});
	
	jQuery(".toggleMenu2").click(function(e) {
		e.preventDefault();
		jQuery(this).toggleClass("active");
		jQuery(".sm-clean").toggle("slow");
	});
	adjustMenu();
		
		
function supportsSVG() {
    return !! document.createElementNS && !! document.createElementNS('http://www.w3.org/2000/svg','svg').createSVGRect;  
}

if(!supportsSVG()) {
    var imgs = document.getElementsByTagName('img');
    var dotSVG = /.*\.svg$/;
    for (var i = 0; i != imgs.length; ++i) {
        if(imgs[i].src.match(dotSVG)) {
            imgs[i].src = imgs[i].src.slice(0, -3) + 'png';
        }
    }
}

	
		
		jQuery(".swipebox").swipebox();
		
		if (supportsSVG()) {
		
		 jQuery('img.svg').each(function(){
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG
                if(typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if(typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass+' replaced-svg');
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');

                // Replace image with new SVG
                $img.replaceWith($svg);

            }, 'xml');

        });
		
		}
  
	
	
	
	
	
	
	multimg=1;
 if(floki.logo!="") {
	 
	multimg=1;
	
 }  
 
 // header home image and texts
 
 if(floki.mainimage!="") {
	 
	jQuery('<img/>').attr('src', floki.mainimage).load(function() {
	   jQuery(this).remove(); // prevent memory leaks as @benweet suggested
	   jQuery('#mainheader').css('background-image', 'url('+floki.mainimage+')');
	   jQuery('#mainheader').animate({'opacity' : 1}, "slow", function () { 
	   
	   		jQuery('#mainheader .text').animate({'opacity' : 1, 'top' : '30%'}, "slow");
	   });
   
});
	 
 }
 
 else {
	 
	  jQuery('#mainheader').animate({'opacity' : 1}, "slow", function () { 
	   
	   		jQuery('#mainheader .text').animate({'opacity' : 1, 'top' : '30%'}, "slow");
	   });
 }

function resizemenu() {		
			
						$med=Math.floor(jQuery('#logoweb').height()/multimg);
					 if($med>0) {
					 }
					 else {
						 
						 $med=50;
					 }
						
						//jQuery('#logoweb').css({"margin-top" : "20px", "margin-bottom" : "20px", 'height' : (jQuery('#logoweb').height()*1.5)+'px'});
						 
						  jQuery('.nav a').animate({ 
    'height' : $med+50,
	'line-height' : $med+50
  }, "fast");			
  
  
						 jQuery('#logoweb').animate({ 
    'margin-top' : 25,
	'margin-bottom' : 25
  }, "fast", function() {
    // Animation complete.
	  //jQuery('.firstdiv').height(($med+47));
	  
	  jQuery('.firstdiv').animate({"height" : jQuery('header > .logo').height()+"px"}); 
	
  });
  

  	//jQuery('.nav a').css({"padding-bottom": ((jQuery('#logoweb').height()/2)+20)+"px", "padding-top" : ((jQuery('#logoweb').height()/2)+20)+"px"});
	
	
						//jQuery('.menutop .container').hide();
						 if (jQuery('.menutop').length) jQuery('.menutop').show();
						 //jQuery('.menutop .container').fadeIn("fast");
						 
}
		 
             
			var $posi=1;
				
			  	if(floki.isMobile) {  jQuery('.menu-menu-container .parent').attr("onclick","return false");
		
 }
				
 


  jQuery('.toggleMenu img').css({'margin-top': (jQuery('.logo').height()-40)/2+'px'});

 
 		//ipad and iphone fix
if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
    jQuery(".framemain").click(function(){
		
		
        //we just need to attach a click event listener to provoke iPhone/iPod/iPad's hover event
        //strange
    });
}
		
		
					jQuery('#logoweb').load(function() {
						
						recolocateheader();
						
    
}).each(function() {
  recolocateheader();
});

var inipage=0;

function recolocateheader() {
	
	
	//jQuery('.firstdiv').height(jQuery('.logo').height());
  
if(!floki.isMobile) { 
  jQuery('.toggleMenu img').css({'margin-top': (jQuery('.logo').height()-40)/2+'px'});
			
 }  
 
					
}


var $win = jQuery(window);
					
					
	function floki_header() { 
	

                 if ($win.scrollTop() == 0)
                     {
							if($posi!=1) resizemenu();
							$posi=1;
						
					 }
                 else if($posi==1) {
					 	
					 $posi=0;
					 
					 $med=Math.floor(jQuery('#logoweb').height()*multimg);
					 
					 if($med>0) {
					 }
					 else {
						 
						 $med=30;
					 }
					 
					 
					 


			
					 
					 jQuery('.nav a').animate({ 
						'height' : $med+20,
						'line-height' : $med+20
					  }, "fast");
					  
								
					
					jQuery('#logoweb').animate({ 
						'margin-top' : 10,
						'margin-bottom' : 10

						
					  }, "fast", function() {
						// Animation complete.
						if (jQuery('.menutop').length) jQuery('.menutop').toggle();
						//jQuery('.firstdiv').height(($med+20));
					  });	 
					 
	
                 	
                 }
					 
}  
			  
			 
         
			
		
	function showanimation() {
		
		
		var ani1="";
		floki.auxiv1=0;
		
		if(floki.anidiv=="rotate") {
			ani1=".flokipost > div";
			floki.auxiv1=1;
		}
		if(floki.aniimg=="rotate") {
			
			
			if(floki.auxiv1==1) ani1+=','; 
			ani1+='.flokipost img'; 
			floki.auxiv1=1;
			
		}
		
		if(floki.anih=="rotate") {if(floki.auxiv1==1) ani1+=','; ani1+='.flokipost h1,.flokipost h2,.flokipost h3,.flokipost h4,.flokipost h5'; floki.auxiv1=1; }
		if(floki.anilink=="rotate") { if(floki.auxiv1==1) ani1+=','; ani1+='.flokipost a'; floki.auxiv1=1; }
		if(floki.anip=="rotate") { if(floki.auxiv1==1) ani1+=','; ani1+='.flokipost p'; floki.auxiv1=1; }

		
				var ani2="";
		floki.auxiv1=0;
		
		if(floki.anidiv=="despx") {
			ani2=".flokipost > div";
			floki.auxiv1=1;
		}
		if(floki.aniimg=="despx") {
			
			
			if(floki.auxiv1==1) ani2+=','; 
			ani2+='.flokipost img'; 
			floki.auxiv1=1;
			
		}
		
		if(floki.anih=="despx") {if(floki.auxiv1==1) ani2+=','; ani2+='.flokipost h1,.flokipost h2,.flokipost h3,.flokipost h4,.flokipost h5'; floki.auxiv1=1; }
		if(floki.anilink=="despx") { if(floki.auxiv1==1) ani2+=','; ani2+='.flokipost a'; floki.auxiv1=1; }
		if(floki.anip=="despx") { if(floki.auxiv1==1) ani2+=','; ani2+='.flokipost p'; floki.auxiv1=1; }

	
						var ani3="";
		floki.auxiv1=0;
		
		if(floki.anidiv=="despy") {
			ani3=".flokipost > div";
			floki.auxiv1=1;
		}
		if(floki.aniimg=="despy") {
			
			
			if(floki.auxiv1==1) ani3+=','; 
			ani3+='.flokipost img'; 
			floki.auxiv1=1;
			
		}
		
		if(floki.anih=="despy") {if(floki.auxiv1==1) ani3+=','; ani3+='.flokipost h1,.flokipost h2,.flokipost h3,.flokipost h4,.flokipost h5'; floki.auxiv1=1; }
		if(floki.anilink=="despy") { if(floki.auxiv1==1) ani3+=','; ani3+='.flokipost a'; floki.auxiv1=1; }
		if(floki.anip=="despy") { if(floki.auxiv1==1) ani3+=','; ani3+='.flokipost p'; floki.auxiv1=1; }
		
		
		
		
		jQuery(ani1).each(function() {
    			if(jQuery(this).offset().top-jQuery(window).height()  <= jQuery(window).scrollTop() && jQuery(this).data( "animation")!=1) {
					jQuery(this).data( "animation", 1 );
					
					
					if(!jQuery(this).hasClass( "su-custom-gallery-slide" ) && !jQuery(this).hasClass( "su-custom-gallery-title" ) && !jQuery(this).hasClass( "su-custom-gallery" ) && !jQuery(this).hasClass( "custom-gallery" ))
					
										
					
										
					jQuery(this).animate({"opacity" : 1}, { duration: 1000, step: function(now, fx){



				var rotationr=(45*(1-fx.pos));
					
	
				//var auxi=Math.round(rotationr*fx.pos);
                			
				
                var rota="rotateX("+rotationr+"deg)";
                
				
				jQuery(fx.elem).css({'-webkit-transform': rota, '-moz-transform': rota, '-ms-transform': rota,'-o-transform': rota,'transform': rota });
				
				

				 
            }, complete: function() {
				
				jQuery(this).css({"opacity" : 1});
				
				} });


				else 			
				
				jQuery(this).animate({"opacity" : 1}, { duration: 1000});		
					
				}
			});
			
			
			
					jQuery(ani2).each(function() {
    			if(jQuery(this).offset().top-jQuery(window).height()  <= jQuery(window).scrollTop() && jQuery(this).data( "animation")!=1) {
					jQuery(this).data( "animation", 1 );
					
					
					
				
				jQuery(this).animate({"opacity" : 1}, { duration: 500});		
					
				}
			});
			
			
			
					jQuery(ani3).each(function() {
    			if(jQuery(this).offset().top-jQuery(window).height()  <= jQuery(window).scrollTop() && jQuery(this).data( "animation")!=1) {
					jQuery(this).data( "animation", 1 );
					
					
					if(!jQuery(this).hasClass( "su-custom-gallery-slide" ) && !jQuery(this).hasClass( "su-custom-gallery-title" ) && !jQuery(this).hasClass( "su-custom-gallery" ) && !jQuery(this).hasClass( "custom-gallery" ))
					
										
					
										
					jQuery(this).animate({"opacity" : 1}, { duration: 1000, step: function(now, fx){



				var rotationr=(45*(1-fx.pos));
					
	
				//var auxi=Math.round(rotationr*fx.pos);
                			
				
                var rota="rotateY("+rotationr+"deg)";
                
				
				jQuery(fx.elem).css({'-webkit-transform': rota, '-moz-transform': rota, '-ms-transform': rota,'-o-transform': rota,'transform': rota });
				
				

				 
            }, complete: function() {
				
				jQuery(this).css({"opacity" : 1});
				
				} });


				else 			
				
				jQuery(this).animate({"opacity" : 1}, { duration: 1000});		
					
				}
			});
			
			
			/*
			jQuery('.youtubebg').each(function() {
    			if(jQuery(this).offset().top-jQuery(window).height()  <= jQuery(window).scrollTop() && jQuery(this).data( "animation")!=1) {
					jQuery(this).data( "animation", 1 );
					
					
					
					
					
					var idvid = window['player' + jQuery(this).attr('id')];
				
					idvid.playVideo();	
					
				}
			});
			
			*/
		
			/*
					jQuery('section .container > div ').each(function() {
    			if(jQuery(this).offset().top-jQuery(window).height()  <= jQuery(window).scrollTop() && jQuery(this).data( "animation")!=1) {
					jQuery(this).data( "animation", 1 );
					
					
							
				
				jQuery(this).animate({"opacity" : 1}, { duration: 500});		
					
				}
			});
			*/
			
	}
	

		// show animations
		// portfolio filter
	 var conta=0;	
	jQuery('.filterport').click(function() {

	jQuery('.filterport').removeClass("filterportactive");
	jQuery(this).addClass("filterportactive"); 
 	var categorie=jQuery(this).attr("rel");
 	 conta=0;
  
	  hideportcat(conta, categorie);
  
  
	});

function hideportcat(conta, categorie) {
	
	var item1= jQuery('.all')[ conta ];
	
	var auxi=0;
	
	jQuery(document).find(item1).animate({
    opacity: 0
  }, { step: function(now, fx){
				
				
				


				//var rotationr=(jQuery(fx.elem).data("iangle")*(1-fx.pos))+(jQuery(fx.elem).data("mangle")*fx.pos);	
				var arx=1-fx.pos;
                var rota="scale("+arx+","+arx+")";
				
	jQuery(fx.elem).css({'-webkit-transform': rota, '-moz-transform': rota, '-ms-transform': rota,'-o-transform': rota,'transform': rota });
				
				if(fx.pos>0.5 && auxi==0) {
					
					auxi=1;
					conta++;
					var itemaux= jQuery('.all')[ conta ];
						
					while(conta<jQuery('.all').length && jQuery(itemaux).is(":hidden"))	{
						conta++;
						var itemaux= jQuery('.all')[ conta ];
					}
					
					if(conta<jQuery('.all').length) hideportcat(conta, categorie);
				
				}

				
				 
            }, duration: 300, complete: function() {
				
				
   			
    			if(conta==jQuery('.all').length){
					jQuery('.all').hide();
					jQuery('.'+categorie).show();
					conta=0;
					showportcat(categorie, conta);
				}
				
  }});
}

function showportcat(categorie, conta) {
	
	var auxi=0;
	

	
	var item2= jQuery('.'+categorie)[ conta ];
	
	if(categorie=="all" || categorie=="") jQuery(".portsepar").css({"clear" : "both"});
	else jQuery(".portsepar").css({"clear" : "none"});
	
	jQuery(document).find(item2).animate({
    opacity: 1
  }, { step: function(now, fx){
				
				
				


				//var rotationr=(jQuery(fx.elem).data("iangle")*(1-fx.pos))+(jQuery(fx.elem).data("mangle")*fx.pos);	
				var arx=fx.pos;
                var rota="scale("+arx+","+arx+")";
				
	jQuery(fx.elem).css({'-webkit-transform': rota, '-moz-transform': rota, '-ms-transform': rota,'-o-transform': rota,'transform': rota });
				

		if(fx.pos>0.5 && auxi==0) {
					
					auxi=1;
					
					conta++;
					if(conta<jQuery('.'+categorie).length) showportcat(categorie, conta);
				
				}
				
				 
            }, duration: 300, complete: function() {
  
  }});
}
		//
		
		// link hover images effect
		
		
		jQuery(".linkimage").parent().hover(
  function() {
	  var parent = jQuery( this );
	
	  
	  jQuery(this).animate({"opacity": 0.5}); 
	 
   
  }, function() {
	   var parent = jQuery( this );
	  jQuery( this ).animate({"opacity": 1});
	 
    
  }
);
		
		///



function scrollactions() {
	floki_header();
	if(animation>0) showanimation();
    if(parallaxani>0) {
		parallaxfloki();
		changeimagefloki();
	}
		
    }
	
	
	
	if(!floki.isMobile) { 
		
 jQuery(document).scroll(function() {

scrollactions();
		
    });  
	
 } 
	


function changeimagefloki() {	


var ajust=100;

var aspeed=300;

var effect='swing';

	
    jQuery('.changeimage').each(function(){
		
		
			
			jQuery(this).clearQueue();
			
            var yPos = (jQuery(this).offset().top- jQuery(window).scrollTop()); 

            // Move the background
			var vall=jQuery(window).height()-jQuery(this).height();
	
			//alert(yPos+" "+vall+ " "+jQuery(this).height());
			
			if(yPos<(vall/2)+ajust) {
				
				yPos=0;
			}
			
			else yPos=1;
	
			
           
			jQuery(this).animate({
				 'opacity': yPos
			  }, aspeed, effect);
        }); 
		
		jQuery('.changeimage2').each(function(){
			
			jQuery(this).clearQueue();
			
            var yPos = (jQuery(this).offset().top- jQuery(window).scrollTop()); 
			var vall=jQuery(window).height()-jQuery(this).height();
			
			
			var multi=1;

			
			if(yPos>(vall/2)+(ajust) || yPos<(vall/2)-ajust) {
				
				yPos=0;
			}
			
			else yPos=1;

            // Move the background
			
			
           
			jQuery(this).animate({
				 'opacity': yPos
			  }, aspeed, effect);
        }); 
		
		jQuery('.changeimage3').each(function(){
			
			jQuery(this).clearQueue();
			
             var yPos = (jQuery(this).offset().top- jQuery(window).scrollTop()); 
			var vall=jQuery(window).height()-jQuery(this).height();
			
			
			var multi=1;
			
			if(yPos>(vall/2)-ajust) {
				
				yPos=0;
			}
			else yPos=1;

          
			jQuery(this).animate({
				 'opacity': yPos
			  }, aspeed, effect);
        }); 
		
		
		
		
}



function parallaxfloki() {		
    jQuery('.parallax').each(function(){
		
		
			
			jQuery(this).clearQueue().finish();
			
            var yPos = (jQuery(this).offset().top- jQuery(window).scrollTop())*0.1; 

            // Move the background
			
           
			jQuery(this).animate({
				 'background-position-y': yPos+'px'
			  }, 500, 'linear');
        }); 
		
		jQuery('.parallax2').each(function(){
			
			jQuery(this).clearQueue().finish();
			
            var yPos = (jQuery(this).offset().top- jQuery(window).scrollTop())*0.3; 

            // Move the background
			
           
			jQuery(this).animate({
				 'background-position-y': yPos+'px'
			  }, 500, 'linear');
        }); 
		
		jQuery('.parallax3').each(function(){
			
			jQuery(this).clearQueue().finish();
			
            var yPos = (jQuery(this).offset().top- jQuery(window).scrollTop())*0.5; 
			
		
			
				//yPos+=(jQuery(this).height())*0.02;
			

            // Move the background
			
           
			jQuery(this).animate({
				 'background-position-y': yPos+'px'
			  }, 500, 'linear');
        }); 
		
		
}

var contq=0;

		function movesliderq(obj, desp) {
			
			
			contq=0;
			
			var contqt=0;
			
			var elem="";
			
			jQuery(obj+' > div').each(function() {
					
					if(jQuery(this).css('display')!="none") {
						emp=1;
						 elem=jQuery(this);
						
						
						
						contq=contqt;
						
						if(desp==1) contq--;
						else contq++;
					}
					
					
					contqt++;
			});
			
			
			if(contq>=contqt) contq=0;
			
			if(contq<0) contq=contqt-1;
			
			contqt=0;
			
			var elem2="";
			
			jQuery(obj+' > div').each(function() {
					
					if(contqt==contq) {
						
						elem2=jQuery(this);
						
					
						elem.fadeOut("medium", function() {
    					elem2.fadeIn("medium");

 					 });
						

					}
					
					contqt++;
			});
			
			
		}
	resizemenu();		
	scrollactions();
	
});

/* menu responsive */
	
jQuery(window).bind('resize orientationchange', function() {
	ww =jQuery(window).width();
	adjustMenu();
});

var adjustMenu = function() {
	if (ww <= 768) {
		if (!jQuery(".toggleMenu").hasClass("active")) {
			jQuery(".nav").hide();
			jQuery(".sm-clean").hide();
		} else {
			jQuery(".nav").show();
			jQuery(".sm-clean").show();
		}
		jQuery(".nav li").unbind('mouseenter mouseleave');
		jQuery(".nav li a.parent").unbind('click').bind('click', function(e) {
			// must be attached to anchor element to prevent bubbling
			e.preventDefault();
			jQuery(this).parent("li").toggleClass("hover");
		});
	} 
	else if (ww > 768) {
		jQuery(".nav").show();
		jQuery(".sm-clean").show();
		jQuery(".nav li").removeClass("hover");
		jQuery(".nav li a").unbind('click');
		jQuery(".nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
		 	// must be attached to li so that mouseleave is not triggered when hover over submenu
		 	jQuery(this).toggleClass('hover');
		});
	}
}
/*---------------------------------------------------------------------------------------------

@author       Constantin Saguin - @brutaldesign
@link            http://csag.co
@github        http://github.com/brutaldesign/swipebox
@version     1.2.1
@license      MIT License

----------------------------------------------------------------------------------------------*/

;(function (window, document, $, undefined) {
	
	$.swipebox = function(elem, options) {

		var defaults = {
			useCSS : true,
			initialIndexOnArray : 0,
			hideBarsDelay : 3000,
			videoMaxWidth : 1140,
			vimeoColor : 'CCCCCC',
			beforeOpen: null,
		      	afterClose: null
		},
		
		plugin = this,
		elements = [], // slides array [{href:'...', title:'...'}, ...],
		elem = elem,
		selector = elem.selector,
		$selector = $(selector),
		isTouch = document.createTouch !== undefined || ('ontouchstart' in window) || ('onmsgesturechange' in window) || navigator.msMaxTouchPoints,
		supportSVG = !!(window.SVGSVGElement),
		winWidth = window.innerWidth ? window.innerWidth : $(window).width(),
		winHeight = window.innerHeight ? window.innerHeight : $(window).height(),
		html = '<div id="swipebox-overlay">\
				<div id="swipebox-slider"></div>\
				<div id="swipebox-caption"></div>\
				<div id="swipebox-action">\
					<a id="swipebox-close"></a>\
					<a id="swipebox-prev"></a>\
					<a id="swipebox-next"></a>\
				</div>\
		</div>';

		plugin.settings = {}

		plugin.init = function(){

			plugin.settings = $.extend({}, defaults, options);

			if ($.isArray(elem)) {

				elements = elem;
				ui.target = $(window);
				ui.init(plugin.settings.initialIndexOnArray);

			}else{

				$selector.click(function(e){
					elements = [];
					var index , relType, relVal;

					if (!relVal) {
						relType = 'rel';
						relVal  = $(this).attr(relType);
					}

					if (relVal && relVal !== '' && relVal !== 'nofollow') {
						$elem = $selector.filter('[' + relType + '="' + relVal + '"]');
					}else{
						$elem = $(selector);
					}

					$elem.each(function(){

						var title = null, href = null;
						
						if( $(this).attr('title') )
							title = $(this).attr('title');

						if( $(this).attr('href') )
							href = $(this).attr('href');

						elements.push({
							href: href,
							title: title
						});
					});
					
					index = $elem.index($(this));
					e.preventDefault();
					e.stopPropagation();
					ui.target = $(e.target);
					ui.init(index);
				});
			}
		}

		plugin.refresh = function() {
			if (!$.isArray(elem)) {
				ui.destroy();
				$elem = $(selector);
				ui.actions();
			}
		}

		var ui = {

			init : function(index){
				if (plugin.settings.beforeOpen) 
					plugin.settings.beforeOpen();
				this.target.trigger('swipebox-start');
				$.swipebox.isOpen = true;
				this.build();
				this.openSlide(index);
				this.openMedia(index);
				this.preloadMedia(index+1);
				this.preloadMedia(index-1);
			},

			build : function(){
				var $this = this;

				$('body').append(html);

				if($this.doCssTrans()){
					$('#swipebox-slider').css({
						'-webkit-transition' : 'left 0.4s ease',
						'-moz-transition' : 'left 0.4s ease',
						'-o-transition' : 'left 0.4s ease',
						'-khtml-transition' : 'left 0.4s ease',
						'transition' : 'left 0.4s ease'
					});
					$('#swipebox-overlay').css({
						'-webkit-transition' : 'opacity 1s ease',
						'-moz-transition' : 'opacity 1s ease',
						'-o-transition' : 'opacity 1s ease',
						'-khtml-transition' : 'opacity 1s ease',
						'transition' : 'opacity 1s ease'
					});
					$('#swipebox-action, #swipebox-caption').css({
						'-webkit-transition' : '0.5s',
						'-moz-transition' : '0.5s',
						'-o-transition' : '0.5s',
						'-khtml-transition' : '0.5s',
						'transition' : '0.5s'
					});
				}


				if(supportSVG){
					var bg = $('#swipebox-action #swipebox-close').css('background-image');
					bg = bg.replace('png', 'svg');
					$('#swipebox-action #swipebox-prev,#swipebox-action #swipebox-next,#swipebox-action #swipebox-close').css({
						'background-image' : bg
					});
				}
				
				$.each( elements,  function(){
					$('#swipebox-slider').append('<div class="slide"></div>');
				});

				$this.setDim();
				$this.actions();
				$this.keyboard();
				$this.gesture();
				$this.animBars();
				$this.resize();
				
			},

			setDim : function(){

				var width, height, sliderCss = {};
				
				if( "onorientationchange" in window ){

					window.addEventListener("orientationchange", function() {
						if( window.orientation == 0 ){
							width = winWidth;
							height = winHeight;
						}else if( window.orientation == 90 || window.orientation == -90 ){
							width = winHeight;
							height = winWidth;
						}
					}, false);
					
				
				}else{

					width = window.innerWidth ? window.innerWidth : $(window).width();
					height = window.innerHeight ? window.innerHeight : $(window).height();
				}

				sliderCss = {
					width : width,
					height : height
				}


				$('#swipebox-overlay').css(sliderCss);

			},

			resize : function (){
				var $this = this;
				
				$(window).resize(function() {
					$this.setDim();
				}).resize();
			},

			supportTransition : function() {
				var prefixes = 'transition WebkitTransition MozTransition OTransition msTransition KhtmlTransition'.split(' ');
				for(var i = 0; i < prefixes.length; i++) {
					if(document.createElement('div').style[prefixes[i]] !== undefined) {
						return prefixes[i];
					}
				}
				return false;
			},

			doCssTrans : function(){
				if(plugin.settings.useCSS && this.supportTransition() ){
					return true;
				}
			},

			gesture : function(){
				if ( isTouch ){
					var $this = this,
					distance = null,
					swipMinDistance = 10,
					startCoords = {},
					endCoords = {};
					var bars = $('#swipebox-caption, #swipebox-action');

					bars.addClass('visible-bars');
					$this.setTimeout();

					$('body').bind('touchstart', function(e){

						$(this).addClass('touching');

		  				endCoords = e.originalEvent.targetTouches[0];
		    				startCoords.pageX = e.originalEvent.targetTouches[0].pageX;

						$('.touching').bind('touchmove',function(e){
							e.preventDefault();
							e.stopPropagation();
		    					endCoords = e.originalEvent.targetTouches[0];

						});
			           			
			           			return false;

	           			}).bind('touchend',function(e){
	           				e.preventDefault();
					e.stopPropagation();
   				
   					distance = endCoords.pageX - startCoords.pageX;
	       				
	       				if( distance >= swipMinDistance ){
	       					
	       					// swipeLeft
	       					$this.getPrev();
	       				
	       				}else if( distance <= - swipMinDistance ){
	       					
	       					// swipeRight
	       					$this.getNext();
	       				
	       				}else{
	       					// tap
	       					if(!bars.hasClass('visible-bars')){
							$this.showBars();
							$this.setTimeout();
						}else{
							$this.clearTimeout();
							$this.hideBars();
						}

	       				}	

	       				$('.touching').off('touchmove').removeClass('touching');
						
					});

           				}
			},

			setTimeout: function(){
				if(plugin.settings.hideBarsDelay > 0){
					var $this = this;
					$this.clearTimeout();
					$this.timeout = window.setTimeout( function(){
						$this.hideBars() },
						plugin.settings.hideBarsDelay
					);
				}
			},
			
			clearTimeout: function(){	
				window.clearTimeout(this.timeout);
				this.timeout = null;
			},

			showBars : function(){
				var bars = $('#swipebox-caption, #swipebox-action');
				if(this.doCssTrans()){
					bars.addClass('visible-bars');
				}else{
					$('#swipebox-caption').animate({ top : 0 }, 500);
					$('#swipebox-action').animate({ bottom : 0 }, 500);
					setTimeout(function(){
						bars.addClass('visible-bars');
					}, 1000);
				}
			},

			hideBars : function(){
				var bars = $('#swipebox-caption, #swipebox-action');
				if(this.doCssTrans()){
					bars.removeClass('visible-bars');
				}else{
					$('#swipebox-caption').animate({ top : '-50px' }, 500);
					$('#swipebox-action').animate({ bottom : '-50px' }, 500);
					setTimeout(function(){
						bars.removeClass('visible-bars');
					}, 1000);
				}
			},

			animBars : function(){
				var $this = this;
				var bars = $('#swipebox-caption, #swipebox-action');
					
				bars.addClass('visible-bars');
				$this.setTimeout();
				
				$('#swipebox-slider').click(function(e){
					if(!bars.hasClass('visible-bars')){
						$this.showBars();
						$this.setTimeout();
					}
				});

				$('#swipebox-action').hover(function() {
				  		$this.showBars();
						bars.addClass('force-visible-bars');
						$this.clearTimeout();
					
					},function() { 
						bars.removeClass('force-visible-bars');
						$this.setTimeout();

				});
			},

			keyboard : function(){
				var $this = this;
				$(window).bind('keyup', function(e){
					e.preventDefault();
					e.stopPropagation();
					if (e.keyCode == 37){
						$this.getPrev();
					}
					else if (e.keyCode==39){
						$this.getNext();
					}
					else if (e.keyCode == 27) {
						$this.closeSlide();
					}
				});
			},

			actions : function(){
				var $this = this;
				
				if( elements.length < 2 ){
					$('#swipebox-prev, #swipebox-next').hide();
				}else{
					$('#swipebox-prev').bind('click touchend', function(e){
						e.preventDefault();
						e.stopPropagation();
						$this.getPrev();
						$this.setTimeout();
					});
					
					$('#swipebox-next').bind('click touchend', function(e){
						e.preventDefault();
						e.stopPropagation();
						$this.getNext();
						$this.setTimeout();
					});
				}

				$('#swipebox-close').bind('click touchend', function(e){
					$this.closeSlide();
				});
			},
			
			setSlide : function (index, isFirst){
				isFirst = isFirst || false;
				
				var slider = $('#swipebox-slider');
				
				if(this.doCssTrans()){
					slider.css({ left : (-index*100)+'%' });
				}else{
					slider.animate({ left : (-index*100)+'%' });
				}
				
				$('#swipebox-slider .slide').removeClass('current');
				$('#swipebox-slider .slide').eq(index).addClass('current');
				this.setTitle(index);

				if( isFirst ){
					slider.fadeIn();
				}

				$('#swipebox-prev, #swipebox-next').removeClass('disabled');
				if(index == 0){
					$('#swipebox-prev').addClass('disabled');
				}else if( index == elements.length - 1 ){
					$('#swipebox-next').addClass('disabled');
				}
			},
		
			openSlide : function (index){
				$('html').addClass('swipebox');
				$(window).trigger('resize'); // fix scroll bar visibility on desktop
				this.setSlide(index, true);
			},
		
			preloadMedia : function (index){
				var $this = this, src = null;

				if( elements[index] !== undefined )
					src = elements[index].href;

				if( !$this.isVideo(src) ){
					setTimeout(function(){
						$this.openMedia(index);
					}, 1000);
				}else{
					$this.openMedia(index);
				}
			},
			
			openMedia : function (index){
				var $this = this, src = null;

				if( elements[index] !== undefined )
					src = elements[index].href;

				if(index < 0 || index >= elements.length){
					return false;
				}

				if( !$this.isVideo(src) ){
					$this.loadMedia(src, function(){
						$('#swipebox-slider .slide').eq(index).html(this);
					});
				}else{
					$('#swipebox-slider .slide').eq(index).html($this.getVideo(src));
				}
				
			},

			setTitle : function (index, isFirst){
				var title = null;

				$('#swipebox-caption').empty();

				if( elements[index] !== undefined )
					title = elements[index].title;
				
				if(title){
					$('#swipebox-caption').append(title);
				}
			},

			isVideo : function (src){

				if( src ){
					if( 
						src.match(/youtube\.com\/watch\?v=([a-zA-Z0-9\-_]+)/) 
						|| src.match(/vimeo\.com\/([0-9]*)/) 
					){
						return true;
					}
				}
					
			},

			getVideo : function(url){
				var iframe = '';
				var output = '';
				var youtubeUrl = url.match(/watch\?v=([a-zA-Z0-9\-_]+)/);
				var vimeoUrl = url.match(/vimeo\.com\/([0-9]*)/);
				if( youtubeUrl ){

					iframe = '<iframe width="560" height="315" src="//www.youtube.com/embed/'+youtubeUrl[1]+'" frameborder="0" allowfullscreen></iframe>';
				
				}else if(vimeoUrl){

					iframe = '<iframe width="560" height="315"  src="http://player.vimeo.com/video/'+vimeoUrl[1]+'?byline=0&amp;portrait=0&amp;color='+plugin.settings.vimeoColor+'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
				
				}

				return '<div class="swipebox-video-container" style="max-width:'+plugin.settings.videomaxWidth+'px"><div class="swipebox-video">'+iframe+'</div></div>';
			},
			
			loadMedia : function (src, callback){
				if( !this.isVideo(src) ){
					var img = $('<img>').on('load', function(){
						callback.call(img);
					});
					
					img.attr('src',src);
				}	
			},
			
			getNext : function (){
				var $this = this;
				index = $('#swipebox-slider .slide').index($('#swipebox-slider .slide.current'));
				if(index+1 < elements.length){
					index++;
					$this.setSlide(index);
					$this.preloadMedia(index+1);
				}
				else{
					
					$('#swipebox-slider').addClass('rightSpring');
					setTimeout(function(){
						$('#swipebox-slider').removeClass('rightSpring');
					},500);
				}
			},
			
			getPrev : function (){
				index = $('#swipebox-slider .slide').index($('#swipebox-slider .slide.current'));
				if(index > 0){
					index--;
					this.setSlide(index);
					this.preloadMedia(index-1);
				}
				else{
					
					$('#swipebox-slider').addClass('leftSpring');
					setTimeout(function(){
						$('#swipebox-slider').removeClass('leftSpring');
					},500);
				}
			},


			closeSlide : function (){
				$('html').removeClass('swipebox');
				$(window).trigger('resize');
				this.destroy();
			},

			destroy : function(){
				$(window).unbind('keyup');
				$('body').unbind('touchstart');
				$('body').unbind('touchmove');
				$('body').unbind('touchend');
				$('#swipebox-slider').unbind();
				$('#swipebox-overlay').remove();
				if (!$.isArray(elem))
					elem.removeData('_swipebox');
				if ( this.target )
					this.target.trigger('swipebox-destroy');
				$.swipebox.isOpen = false;
				if (plugin.settings.afterClose) 
					plugin.settings.afterClose();
 			}

		};

		plugin.init();
		
	};

	$.fn.swipebox = function(options){
		if (!$.data(this, "_swipebox")) {
			var swipebox = new $.swipebox(this, options);
			this.data('_swipebox', swipebox);
		}
		return this.data('_swipebox');
	}

}(window, document, jQuery));