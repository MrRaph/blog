<?php

global $custom_syle; 

  $custom_syle.=" html { ";
  
  
   if($menu_design6=="sm-clean") {
		
		
		
		$custom_syle.="background-color: ".$colorzone6.";";
		



 } 

if($menu_design6=="bimage") {


		$custom_syle.="background-image:url(".esc_url(floki_get_option( 'bimage' )).");background-repeat:repeat;";


 } 
  
   $custom_syle.="}";
  
  $custom_syle.="body {
	  color:".$colorfont.";
	  font-size:".esc_attr(floki_get_option( 'sizefont' )).";
	  -webkit-font-smoothing: antialiased;
	  
	  background-color: ".esc_attr(floki_get_option( 'colorzone5')).";
	  margin: 0 auto;
	  
	  ".$style;
	  
	  
	 if(floki_get_option( 'googlefont' )!="not") {
         
	 $custom_syle.="font-family: '".str_replace("+", " ", esc_attr(floki_get_option( 'googlefont' )))."', sans-serif;";
        
         }
		
		else {
		 
			$custom_syle.="font-family: '".esc_attr(floki_get_option( 'manualfont' ))."';";

		 } 



$custom_syle.="font-weight:300;		
	 line-height:".round(intval(esc_attr(floki_get_option( 'sizefont' )))*1.5). preg_replace('/[0-9]+/', '', esc_attr(floki_get_option( 'sizefont' ))).";";
		
		
		 if($menu_design6=="sm-clean") {
		
$custom_syle.="		
		width: 1144px;
		border-left:solid 1px #ccc;
		border-right:solid 1px #ccc;
";

}

 if($menu_design6=="bimage") {

	
$custom_syle.="		
		width: 1144px;
		
		border-left:solid 1px #ccc;
		border-right:solid 1px #ccc;";



} 
		
$custom_syle.="}
  
  
  h1, h2, h3, h4, h5, #menu li a {";
	  
	  if(floki_get_option( 'headingfont' )!="not") { 
         
		  $custom_syle.="font-family: '".str_replace("+", " ", esc_attr(floki_get_option( 'headingfont' )))."', serif;";
        
     }
		
	
	
$custom_syle.="	font-weight:lighter;
	  
  }";
  
  
 $custom_syle.=" 
  input, textarea {
	border: solid 1px ".$colorfont.";
	padding:15px;
}";
  
 if($menu_design6=="sm-clean") {
  
  $custom_syle.="
  section {
		}";
  
  
  
 } 	
  
  $custom_syle.="
  .themenext:before,
.themenext:after,
.themeprev:before,
.themeprev:after {
    background: ".$colorfonth1.";
}

.themenext:hover:before,
.themenext:hover:after,
.themenext:focus:before,
.themenext:focus:after,
.themeprev:hover:before,
.themeprev:hover:after,
.themeprev:focus:before,
.themeprev:focus:after { background: ".$colorfont."; }

.flokisearch {
	
	border:solid 1px ".$colorfont2."; height:auto;  padding-left:15px; vertical-align:middle;border-radius: 3px;
}

    svg {
	  
	  fill: ".$colorfont.";

	  vertical-align:middle;
	  position: relative;
	  width: 64px;
	  height: 64px;
transition: 1s all;
border: none;
}

svg:hover {
	opacity:0.5;
}


 
 body a {
	 color:".$colorfont2.";
	 
 }
 
 body a:visited {
	 
	 color:".$colorfont3.";
 }
 
 

a:hover, a:focus
{
	
color:".$colorfont4.";
}


hr {
	background-color:".$colorfont.";
height: 1px;
	border:none;
}
 
 h1 {
	 
	  color:".$colorfonth1.";
	  font-size:".esc_attr(floki_get_option( 'sizefonth1' )).";
	   line-height:".round(intval(esc_attr(floki_get_option( 'sizefonth1' )))*1.3).""; $custom_syle.= preg_replace('/[0-9]+/', '', esc_attr(floki_get_option( 'sizefonth1' ))).";
	  vertical-align:middle;

 }
 
 .postinfo h2 {
	 margin:0;
	 font-size:22px;
	  line-height:26px;
}

 .postinfo hr {
	 
	 background-color:".$colorfonth2.";
	 height:1px;
	 border:none;
	 width: 65%;
	 margin-top:2px;
	 margin-bottom:2px;
	 

}

 .postinfo strong {
	 
	color:".$colorfonth2.";
	 font-size:16px;
	 line-height:16px;
	 margin: 0;
	 padding:0;

}


.ico-small .svg {
	width:18px;
	height:18px;
	margin: 0;
}
 
 
 .back1 {
	 position: relative;
background-color:rgba(44,62,80 , 0.6 );
background: url(".get_template_directory_uri()."/images/blackdot.png);
	background-position: fixed;
	overflow:hidden;
	
	

}

 .back2 {
position:relative;
background: url(".get_template_directory_uri()."/images/whitedot.png);
	background-position: fixed;

}

 
 .stitched {
   padding: 20px;
   margin: 10px;
   background: ".$colorfonth1.";
   color: #fff;
   font-size: 21px;
   font-weight: bold;
   line-height: 1.3em;
   border: 2px dashed #fff;
   border-radius: 10px;
   box-shadow: 0 0 0 4px #ff0030, 2px 1px 6px 4px rgba(10, 10, 0, 0.5);
   text-shadow: -1px -1px #aa3030;
   font-weight: normal;
}
 
 button {
	 
	  border: solid 1px ".$colorfonth1.";
 }
 
 .filterportactive
{
	background-color:transparent !important;
	
	 color: ".$colorfonth1." !important;
	
}

 .more-link {
	 margin-top:20px;
	 margin-bottom:20px;
	float:right;
 }
 
   .more-link .svg {
	  
	  fill: ".$colorfont2.";
	  height:20px;
	  width:20px;
	  vertical-align:middle;
}

article ul  {

   list-style-type:disc;

  
}

.tagsfloki {
	line-height:".esc_attr(floki_get_option( 'sizefonth1' )).";
}

.tagsfloki a {
	color:  ".$colorfont2." !important;
	
	border: solid 1px ".$colorfont2.";
	transition-duration: 0.2s;
transition-timing-function: linear;

}
 .tagsfloki a:hover {
	
	background-color: ".$colorfont2.";
	color: #fff !important;
}

	.button,
	button,
	input[type=\"submit\"],
	input[type=\"reset\"],
	input[type=\"button\"] {
		
			background-color: ".$colorfont2.";
	color: #fff;	
border: solid 1px ".$colorfont2.";
	}
	
		.button:hover,
	button:hover,
	input[type=\"submit\"]:hover,
	input[type=\"reset\"]:hover,
	input[type=\"button\"]:hover {
		background-color:transparent;
		color:  ".$colorfont2.";

	}
	
		.button2 {
		
			
	background-color:transparent;
		color:  ".$colorfont2." !important;	
border: solid 2px ".$colorfont2.";
	}
	
		.button2:hover {
opacity: 0.5;

	}
	

.su-quote {
	
	 background-color:".$colorfonth1.";
	 color: #fff;
}

h1 .svg {
	  
	  fill: ".$colorfonth1.";
	  height:128px;
	  width:128px;
	  vertical-align:middle;

}

.breadcrumbfloki .svg {
	  
	  fill: #fff;
	  height:20px;
	  width:20px;
	  vertical-align:middle;

}

.su-dropcap-style-flat {
	background: ".$colorfonth1.";

}

.su-dropcap-style-simple {
	color: ".$colorfonth1.";
}

.su-pullquote-align-right {
	color: ".$colorfonth3.";
	border-left: 5px solid ".$colorfonth1.";
}

.su-pullquote-align-left {
	color: ".$colorfonth3.";
	border-right: 5px solid ".$colorfonth1.";
	text-align:right;
}



strong {
	color: ".$colorstrong.";
	font-weight:normal;
}

 strong .svg {
	  
	  fill:  ".$colorstrong.";
	  height:32px;
	  width:32px;
	  vertical-align:middle;
	  padding-bottom:2px;
}


 
 .su-divider {

	background: ".$colorfonth1.";

}
 
 .headingline {
	background-color: ".$colorfonth1."; 
	height:1px;
	text-shadow: 3px 3px 0px #2c2e38, 5px 5px 0px #5c5f72;
 }
 .sticky h2 {
	 border-color: ".$colorfonth2.";
}

blockquote {
	border-left: 5px solid ".$colorfonth1.";
	padding-left:10px;
	}

 .breadcrumbflokistyle {

		background-color: ".$colorfonth1.";
	  top:50%;
	  color: #fff;	

}
 .breadcrumbfloki {
	 padding-top:20px;

 }
 .breadcrumbfloki a {
	 color:#ddd;
 }
 
  .breadcrumbfloki a:hover {
	 color:#ccc;
 }

 
  h2 {
	 
	  color:".$colorfonth2.";
	  font-size:".esc_attr(floki_get_option( 'sizefonth2' )).";
	   line-height:".round(intval(esc_attr(floki_get_option( 'sizefonth2' )))*1.3).""; $custom_syle.=preg_replace('/[0-9]+/', '', esc_attr(floki_get_option( 'sizefonth2' ))).";
	    vertical-align:middle;

 }

 h2 .svg {
	  
	  fill: ".$colorfonth2.";
	  height:48px;
	  width:48px;
	  vertical-align:middle;
}

  h3 {
	 
	  color:".$colorfonth3.";
	  font-size:".esc_attr(floki_get_option( 'sizefonth3' )).";
	   line-height:".round(intval(esc_attr(floki_get_option( 'sizefonth3' )))*1.3)."".preg_replace('/[0-9]+/', '', esc_attr(floki_get_option( 'sizefonth3' ))).";
 }

 .sidebarright {
 margin-top:50px;
margin-bottom:20px;
}

 .sidebarleft {
	  margin-top:50px;
	 margin-bottom:20px;

}

 .sidebarright a {
	 
	 color:".$colorfonth3.";
 }
 
  .sidebarleft a {
	 
	 color:".$colorfonth3.";
 }

.widgets ul li {
padding-left:15px;
padding-right:15px;
padding-bottom:15px;
margin-top:15px;
border-bottom: dotted 1px ".$colorfont.";

background-image:url('".get_template_directory_uri()."/images/arrow.png');
background-repeat:no-repeat;
background-position:top right;	
}

.widgets ul li li {
border-bottom: dotted 1px ".$colorfont.";
background-image:none;	
}

 .su-custom-gallery-title div {
	background-color:".$colorfonth1.";
 }

  h3 .svg {	  
	  fill: ".$colorfonth3.";
	  height:48px;
	  width:48px;
	  vertical-align:middle;
}

 
   h4 {	 
	  color:".$colorfonth4.";
	  font-size:".esc_attr(floki_get_option( 'sizefonth4' )).";
	   line-height:".round(intval(esc_attr(floki_get_option( 'sizefonth4' )))*1.3)."".preg_replace('/[0-9]+/', '', esc_attr(floki_get_option( 'sizefonth4' ))).";
 }
  h4 .svg {	  
	  fill: ".$colorfonth4.";
	  height:32px;
	  width:32px;
	  vertical-align:middle;
	  border: none;
}

.su-quote-inner .svg {	
	fill: #ffffff;
}

 
   h5 {	 
	  color: ".esc_attr(floki_get_option( 'colorfonth5' )).";
	  font-size: ".esc_attr(floki_get_option( 'sizefonth5' )).";
	   line-height: ".round(intval(esc_attr(floki_get_option( 'sizefonth5' )))*1.3)."".preg_replace('/[0-9]+/', '', esc_attr(floki_get_option( 'sizefonth5' ))).";
 }
  h5 .svg {	  
	  fill: ".esc_attr(floki_get_option( 'colorfonth5' )).";
	  height:16px;
	  width:16px;
	  vertical-align:middle;
}
 
 	h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { font-weight: inherit; }
  	.social-icons img {
 		opacity: ".esc_attr(floki_get_option( 'socialopacity' )).";
	}
.nav a {
		color: ".$menupading.";
	}
	
	.nav li > a:after { 
	border-top-color: ".$menupading.";
  } 
  
  	.nav li li > a:after { 
  
	
	border-left-color: ".floki_getContrastYIQ($menu_design).";


  
  
  }

	
	.cl-effect-21 a::before {
	
	background: ".$menusize.";

}
.cl-effect-21 a:hover,
.cl-effect-21 a:focus {
	color: ".$menusize.";
}

.cl-effect-21 .current_page_item > a::before, .current-menu-item > a::before {
	position: absolute;
	left: 0;
	width: 100%;
	height: 4px;
	background: ".$menusize.";
	content: '';
	opacity: 1;
	-webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
	-moz-transition: opacity 0.3s, -moz-transform 0.3s;
	transition: opacity 0.3s, transform 0.3s;
	-webkit-transform: translateY(0px);
	-moz-transform: translateY(0px);
	transform: translateY(0px);
}

	
.nav li  ul {

	background-color: ".$menu_design.";

	

}

.nav li  li a {

	color: ".floki_getContrastYIQ($menu_design).";

	

}
	
	.current_page_item  > a, .current-menu-item > a {
		
		color: ".$menusize.";
	}
	
	.current_page_item > a, .current-menu-item > a  { 
  

	border-top-color: ".$menusize.";


  
  
  } 
	
	.sm-clean a {
		color: ".esc_attr(floki_get_option( 'menupading2' )).";
		padding: 0;
		font-size:12px;
		line-height:12px;
		
		
	}
	
	
	.sm-clean a span.sub-arrow { 
		border-color:transparent transparent transparent ".esc_attr(floki_get_option( 'menupading2' )).";
	}
	
	
	
	.menutop {
		background-color: ".$colorzone1.";";
	
	 if(floki_get_option( 'menu_design2' )=="sm-clean") { 
	$custom_syle.="background:-webkit-gradient(linear, 0 0, 0 100%, from(".$colorzone1."), to(".esc_attr(floki_get_option( 'color2zone1' ))."));
	
	background:-moz-linear-gradient(".$colorzone1.", ".esc_attr(floki_get_option( 'color2zone1' )).");
	background:-o-linear-gradient(".$colorzone1.", ".esc_attr(floki_get_option( 'color2zone1' )).");
	background:linear-gradient(".$colorzone1.", ".esc_attr(floki_get_option( 'color2zone1' )).");";
	
 }
	
	$custom_syle.="}";
	
	
if($menu_design6=="sm-clean") {

$custom_syle.="
		margin-left:100px;
		margin-right:100px;
		background:none;
		
		background-color: ".$colorzone6.";
		
		border-left:solid 1px #ccc;
		border-right:solid 1px #ccc;";


 } 	

if($menu_design6=="bimage") {

$custom_syle.="
		margin-left:100px;
		margin-right:100px;
		background:none;
		
		
		border-left:solid 1px #ccc;
		border-right:solid 1px #ccc;
		background-image:url(".esc_url(floki_get_option( 'bimage' )).");background-repeat:repeat;";


 } 	
	
	
$custom_syle.="	}
	
		section {";
			
if(floki_get_option( 'visiblezone5' )=="sm-clean" || floki_get_option( 'visiblezone5' )=="sm-blue") {
	$custom_syle.="	background-color: ".esc_attr(floki_get_option( 'colorzone5')).";";
		
 } 

	/* css3 */

 if(floki_get_option( 'visiblezone5' )=="sm-clean") { 
 $custom_syle.="
	background:-webkit-gradient(linear, 0 0, 0 100%, from(".esc_attr(floki_get_option( 'colorzone5'))."), to(".esc_attr(floki_get_option( 'color2zone5' ))."));
	
	background:-moz-linear-gradient(".esc_attr(floki_get_option( 'colorzone5')).", ".esc_attr(floki_get_option( 'color2zone5' )).");
	background:-o-linear-gradient(".esc_attr(floki_get_option( 'colorzone5')).", ".esc_attr(floki_get_option( 'color2zone5' )).");
	background:linear-gradient(".esc_attr(floki_get_option( 'colorzone5')).", ".esc_attr(floki_get_option( 'color2zone5' )).");";
	
 } 
	
$custom_syle.="	
	
	}

.states{
background-image:url(".get_template_directory_uri()."/images/svg/search3.svg);
background-repeat:no-repeat;
background-position: center center;
padding: 0 !important;
float:right;
margin:0 !important;
margin-top:6px !important;
background-color:transparent !important;
width: 32px;
height: 32px;
border: none !important;

opacity: 0.5;

}

.states{

fill: ".$colorfont2."; 

}
	
	.black {
	  
	  fill: #000000;

}

	
	.white {
	  
	  fill: #ffffff;

}
	
  .small {
	  

	  height:16px;
	  width:16px;

}

  .medium {
	  

	  height:32px;
	  width:32px;

}

  .big {
	  

	  height:64px;
	  width:64px;

}

  .bigbig {
	  

	  height:128px;
	  width:128px;

}





.portfoliotitle svg {
	fill: ".$colorfonth2.";
	 height:16px;
	  width:16px;
}

.iarrow svg, .iarrow2 svg, .postinfo strong svg {
	
		  height:16px;
	  width:16px;
}
	
	
	footer {
		background-color: ".$colorzone3.";
		
		color: ".esc_attr(floki_get_option( 'menusize2' )).";";
	
 if(floki_get_option( 'visiblezone3' )=="sm-clean") { 
 
 $custom_syle.="
	background:-webkit-gradient(linear, 0 0, 0 100%, from(".$colorzone3."), to(".esc_attr(floki_get_option( 'color2zone3' ))."));
	
	background:-moz-linear-gradient(".$colorzone3.", ".esc_attr(floki_get_option( 'color2zone3' )).");
	background:-o-linear-gradient(".$colorzone3.", ".esc_attr(floki_get_option( 'color2zone3' )).");
	background:linear-gradient(".$colorzone3.", ".esc_attr(floki_get_option( 'color2zone3' )).");";
	
 } 
 
 $custom_syle.="
	
	}
	
	.footer2 {
		
		background-color: ".esc_attr(floki_get_option( 'colorzone4' )).";
	}
	
	.logo, .firstdiv {
		background-color: ".esc_attr(floki_get_option( 'colorzone2' )).";";
		
		
if(floki_get_option( 'visiblezone2' )=="sm-clean") {


$custom_syle.="
	background:-webkit-gradient(linear, 0 0, 0 100%, from(".esc_attr(floki_get_option( 'colorzone2' ))."), to(".esc_attr(floki_get_option( 'color2zone2' ))."));
	
	background:-moz-linear-gradient(".esc_attr(floki_get_option( 'colorzone2' )).", ".esc_attr(floki_get_option( 'color2zone2' )).");
	background:-o-linear-gradient(".esc_attr(floki_get_option( 'colorzone2' )).", ".esc_attr(floki_get_option( 'color2zone2' )).");
	background:linear-gradient(".esc_attr(floki_get_option( 'colorzone2' )).", ".esc_attr(floki_get_option( 'color2zone2' )).");";
	
 } 
	
	$custom_syle.="}";
	
 if($hfixed!="1")  { 
$custom_syle.="	
	.logo {
		position:relative;
	}
	
	.firstdiv {
		display: none;
	}";
	
	
 }
	
	$custom_syle.="
	nav {
		background:none;
		background-color: ".$colorzone3.";

	/* css3 */
	background:-webkit-gradient(linear, 0 0, 0 100%, from(".$colorzone3."), to(".esc_attr(floki_get_option( 'color2zone3' ))."));
	
	background:-moz-linear-gradient(".$colorzone3.", ".esc_attr(floki_get_option( 'color2zone3' )).");
	background:-o-linear-gradient(".$colorzone3.", ".esc_attr(floki_get_option( 'color2zone3' )).");
	background:linear-gradient(".$colorzone3.", ".esc_attr(floki_get_option( 'color2zone3' )).");
	}
	
	.shadow-top {
		position:absolute;
		background-image:url(".get_template_directory_uri()."/images/shadow-top.png);
		background-repeat:no-repeat;
		background-position:top center;
	}
		.shadow-top2 {
		background-image:url(".get_template_directory_uri()."/images/shadow2.png);
		background-repeat:no-repeat;
		background-position: top center;
		position:absolute;
		top:0;
		  
		height:57px;
		width:100%;
		overflow:hidden;
	}
	.shadow-bottom {
		position:absolute;
		background-image:url(".get_template_directory_uri()."/images/shadow-bottom.png);
		background-repeat:no-repeat;
		background-position:top center;
	}";
	
if(floki_get_option( 'menu_posi2' )=="top") {
	
	$custom_syle.="
	.sm-clean {
		float: right;
	}";
	 } 
	
	if($animation>0 && $anidiv!="") {
	
	$custom_syle.="
	.flokipost > div {
		opacity : 0;
		perspective: 500px;
-webkit-perspective: 500px;
		
	}";
	
 } 
	
	
	
if($animation>0 && $aniimg!="") {

$custom_syle.="	
	.flokipost img {
		opacity : 0;
		perspective: 500px;
-webkit-perspective: 500px;
		
	}";
	
 } 
	
	
if($animation>0 && $anilink!="") {

$custom_syle.="
	
	.flokipost a {
		opacity : 0;
		perspective: 500px;
-webkit-perspective: 500px;
		
	}";
	
 } 
	
	if($animation>0 && $anip!="") {
	
$custom_syle.="
	.flokipost p {
		opacity : 0;
		perspective: 500px;
-webkit-perspective: 500px;
		
	}";
	
} 
	
	
	
	
if($animation>0 && $anih!="") {
	$custom_syle.="
	
	.flokipost h1,.flokipost h2,.flokipost h3,.flokipost h4,.flokipost h5 {
		opacity : 0;
		perspective: 500px;
-webkit-perspective: 500px;
		
	}";
	
 } 
	
// header titles and description.
if(floki_get_option( 'mainimage' )!="") {
$custom_syle.="#mainheader {
	   background-repeat:no-repeat;
    background-position: center center;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;

}
";
}
$custom_syle.="	

 .backmainheader {
	 position: relative;
background: url(".get_template_directory_uri()."/images/blackdot.png);
	background-position: fixed;
	overflow:hidden;
	height:500px;
	

}

	@media screen and (max-width: 768px) {
    	body {
width:100%;
		}
		
		
		.sl {
	padding-left:0px;
	padding-right:10px;
	margin: 0 auto;
}

.sr {
	padding-right:0px;
	padding-left:10px;
	margin: 0 auto;
}
	
	
}
";
?>