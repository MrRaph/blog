<?php
$mens1="";
if(isset($_REQUEST['settings-updated'])) { //update options


if(isset($_POST["palette"])) {
	
	$_POST["menusize"]=esc_attr($_POST["palcolor1"]);
	    
	$_POST["colorfont2"]=esc_attr($_POST["palcolor1"]);
	$_POST["colorfont4"]=esc_attr($_POST["palcolor1"]);
	$_POST["colorfont3"]=esc_attr($_POST["palcolor1"]);
	$_POST["colorfonth1"]=esc_attr($_POST["palcolor1"]);
	$_POST["colorfonth2"]=esc_attr($_POST["palcolor1"]);
	
	$_POST["colorzone1"]=esc_attr($_POST["palcolor2"]);
	$_POST["colorzone3"]=esc_attr($_POST["palcolor2"]);
	$_POST["menupading"]=esc_attr($_POST["palcolor2"]);
	$_POST["menu_design"]=esc_attr($_POST["palcolor2"]);
	$_POST["colorzone6"]=esc_attr($_POST["palcolor2"]);
	$_POST["colorfonth3"]=esc_attr($_POST["palcolor2"]);	
	$_POST["colorfonth4"]=esc_attr($_POST["palcolor2"]);
	$_POST["colorstrong"]=esc_attr($_POST["palcolor2"]);	
	
	$_POST["colorzone2"]=esc_attr($_POST["palcolor3"]);
	$_POST["menupading2"]=esc_attr($_POST["palcolor3"]);
	$_POST["menusize2"]=esc_attr($_POST["palcolor3"]);
	
	$_POST["colorfont"]=esc_attr($_POST["palcolor4"]);
	$_POST["colorfonth5"]=esc_attr($_POST["palcolor4"]);
	
}


if(isset($_POST["palcolor1"])) {

$palcolor1 = esc_attr($_POST["palcolor1"]);     
set_theme_mod("palcolor1", $palcolor1);

}

if(isset($_POST["palcolor2"])) {

$palcolor2 = esc_attr($_POST["palcolor2"]);     
set_theme_mod("palcolor2", $palcolor2);

}

if(isset($_POST["palcolor3"])) {

$palcolor3 = esc_attr($_POST["palcolor3"]);     
set_theme_mod("palcolor3", $palcolor3);

}

if(isset($_POST["palcolor4"])) {

$palcolor4 = esc_attr($_POST["palcolor4"]);     
set_theme_mod("palcolor4", $palcolor4);

}

if(isset($_POST["favicon"])) {

$favicon = esc_url($_POST["favicon"]);     
if(floki_validate_image($favicon)) set_theme_mod("favicon", $favicon);
else $mens1.=__("  * Incorrect image url", "floki");

}

if(isset($_POST["iconapple"])) {

$iconapple = esc_url($_POST["iconapple"]);     
if(floki_validate_image($iconapple)) set_theme_mod("iconapple", $iconapple);
else $mens1.=__("  * Incorrect image url", "floki");

}

if(isset($_POST["iconapple2"])) {

$iconapple2 = esc_url($_POST["iconapple2"]);     
if(floki_validate_image($iconapple2)) set_theme_mod("iconapple2", $iconapple2);
else $mens1.=__("  * Incorrect image url", "floki");

}

if(isset($_POST["hslider"])) {

$hslider = esc_attr($_POST["hslider"]);     
set_theme_mod("hslider", $hslider);

}

if(isset($_POST["iconapple3"])) {

$iconapple3 = esc_url($_POST["iconapple3"]);     
if(floki_validate_image($iconapple3)) set_theme_mod("iconapple3", $iconapple3);
else $mens1.=__("  * Incorrect image url", "floki");

}

if(isset($_POST["iconapple4"])) {

$iconapple4 = esc_url($_POST["iconapple4"]);     
if(floki_validate_image($iconapple4)) set_theme_mod("iconapple4", $iconapple4);
else $mens1.=__("  * Incorrect image url", "floki");

}

if(isset($_POST["default_sidebar_pos"])) {

$default_sidebar_pos = esc_attr($_POST["default_sidebar_pos"]);     
set_theme_mod("default_sidebar_pos", $default_sidebar_pos);

}

if(isset($_POST["default_sidebar_pos2"])) {


$default_sidebar_pos2 = esc_attr($_POST["default_sidebar_pos2"]);     
set_theme_mod("default_sidebar_pos2", $default_sidebar_pos2);

}

if(isset($_POST["default_sidebar_pos3"])) {


$default_sidebar_pos3 = esc_attr($_POST["default_sidebar_pos3"]);     
set_theme_mod("default_sidebar_pos3", $default_sidebar_pos3);

}

if(isset($_POST["default_sidebar_pos4"])) {


$default_sidebar_pos4 = esc_attr($_POST["default_sidebar_pos4"]);     
set_theme_mod("default_sidebar_pos4", $default_sidebar_pos4);

}

if(isset($_POST["default_sidebar_pos5"])) {


$default_sidebar_pos5 = esc_attr($_POST["default_sidebar_pos5"]);     
set_theme_mod("default_sidebar_pos5", $default_sidebar_pos5);

}

if(isset($_POST["google_analytics"])) {


$google_analytics = esc_attr($_POST["google_analytics"]);     
set_theme_mod("google_analytics", $google_analytics);

}

if(isset($_POST["comments"])) {


$comments = esc_attr($_POST["comments"]);     
set_theme_mod("comments", $comments);

}

else {
	
	set_theme_mod("comments", 0);
}

if(isset($_POST["bodycode"])) {


$bodycode = esc_textarea($_POST["bodycode"]);     
set_theme_mod("bodycode", $bodycode);

}

if(isset($_POST["headcode"])) {

$headcode = esc_attr($_POST["headcode"]);     
set_theme_mod("headcode", $headcode);
 
}

if(isset($_POST["menu_design"])) {

$menu_design = "#".esc_attr($_POST["menu_design"]);     
set_theme_mod("menu_design", $menu_design);

}

if(isset($_POST["logo"])) {

$logo = esc_url($_POST["logo"]);     
if(floki_validate_image($logo)) set_theme_mod("logo", $logo);
else $mens1.=__("  * Incorrect image url", "floki");
}

if(isset($_POST["mainimage"])) {

$mainimage = esc_url($_POST["mainimage"]);     
if(floki_validate_image($mainimage)) set_theme_mod("mainimage", $mainimage);
else $mens1.=__("  * Incorrect image url", "floki");
}

if(isset($_POST["headertitle"])) {

$headertitle = esc_html($_POST["headertitle"]);     
set_theme_mod("headertitle", $headertitle);

}

if(isset($_POST["headerdescription"])) {

$headerdescription = esc_html($_POST["headerdescription"]);     
set_theme_mod("headerdescription", $headerdescription);

}

if(isset($_POST["menusize"])) {

$menusize = "#".esc_attr($_POST["menusize"]);     
set_theme_mod("menusize", $menusize);

}

if(isset($_POST["menupading"])) {

$menupading = "#".esc_attr($_POST["menupading"]);     
set_theme_mod("menupading", $menupading);

}

if(isset($_POST["menu_posi"])) {

$menu_posi = esc_attr($_POST["menu_posi"]);     
set_theme_mod("menu_posi", $menu_posi);

}

if(isset($_POST["menu_posi2"])) {

$menu_posi2 = esc_attr($_POST["menu_posi2"]);     
set_theme_mod("menu_posi2", $menu_posi2);

}

if(isset($_POST["menu_design2"])) {

$menu_design2 = esc_attr($_POST["menu_design2"]);     
set_theme_mod("menu_design2", $menu_design2);

}

if(isset($_POST["colorstrong"])) {

$colorstrong = "#".esc_attr($_POST["colorstrong"]);     
set_theme_mod("colorstrong", $colorstrong);

}

if(isset($_POST["stylezone1"])) {

$stylezone1 = esc_attr($_POST["stylezone1"]);     
set_theme_mod("stylezone1", $stylezone1);

}

if(isset($_POST["colorzone1"])) {

$colorzone1 = "#".esc_attr($_POST["colorzone1"]);     
set_theme_mod("colorzone1", $colorzone1);

}

if(isset($_POST["menu_design6"])) {

$menu_design6 = esc_attr($_POST["menu_design6"]);     
set_theme_mod("menu_design6", $menu_design6);


}

if(isset($_POST["bimage"])) {

$bimage = esc_attr($_POST["bimage"]);     
set_theme_mod("bimage", $bimage);

}

if(isset($_POST["colorzone6"])) {

$colorzone6 = "#".esc_attr($_POST["colorzone6"]);     
set_theme_mod("colorzone6", $colorzone6);

}

if(isset($_POST["color2zone1"])) {

$color2zone1 = "#".esc_attr($_POST["color2zone1"]);     
set_theme_mod("color2zone1", $color2zone1);

}

if(isset($_POST["visiblezone2"])) {

$visiblezone2 = esc_attr($_POST["visiblezone2"]);     
set_theme_mod("visiblezone2", $visiblezone2);

}

if(isset($_POST["colorzone2"])) {

$colorzone2 = "#".esc_attr($_POST["colorzone2"]);     
set_theme_mod("colorzone2", $colorzone2);

}

if(isset($_POST["color2zone2"])) {

$color2zone2 = "#".esc_attr($_POST["color2zone2"]);     
set_theme_mod("color2zone2", $color2zone2);

}

if(isset($_POST["visiblezone5"])) {

$visiblezone5 = esc_attr($_POST["visiblezone5"]);     
set_theme_mod("visiblezone5", $visiblezone5);

}

if(isset($_POST["colorzone5"])) {

$colorzone5 = "#".esc_attr($_POST["colorzone5"]);     
set_theme_mod("colorzone5", $colorzone5);

}

if(isset($_POST["color2zone5"])) {

$color2zone5 = "#".esc_attr($_POST["color2zone5"]);     
set_theme_mod("color2zone5", $color2zone5);

}

if(isset($_POST["visiblezone1"])) {

$visiblezone1 = esc_attr($_POST["visiblezone1"]);     
set_theme_mod("visiblezone1", $visiblezone1);

}
else {
	
	set_theme_mod("visiblezone1", 0);
	
}

if(isset($_POST["visiblezone3"])) {

$visiblezone3 = esc_attr($_POST["visiblezone3"]);     
set_theme_mod("visiblezone3", $visiblezone3);

}

if(isset($_POST["colorzone3"])) {


$colorzone3 = "#".esc_attr($_POST["colorzone3"]);     
set_theme_mod("colorzone3", $colorzone3);

}

if(isset($_POST["color2zone3"])) {


$color2zone3 = "#".esc_attr($_POST["color2zone3"]);     
set_theme_mod("color2zone3", $color2zone3);

}

if(isset($_POST["menusize2"])) {


$menusize2 = "#".esc_attr($_POST["menusize2"]);     
set_theme_mod("menusize2", $menusize2);

}

if(isset($_POST["menupading2"])) {

$menupading2 = "#".esc_attr($_POST["menupading2"]);     
set_theme_mod("menupading2", $menupading2);

}

if(isset($_POST["googlefont"])) {


$googlefont = esc_attr($_POST["googlefont"]);
set_theme_mod("googlefont", $googlefont);


}

if(isset($_POST["manualfont"])) {

$manualfont = esc_attr($_POST["manualfont"]);     
set_theme_mod("manualfont", $manualfont);

}

if(isset($_POST["sizefont"])) {

$sizefont = esc_attr($_POST["sizefont"]);     
if(floki_validate_size($sizefont)) set_theme_mod("sizefont", $sizefont);
else $mens1.=__("  * Incorrect font size", "floki");
}

if(isset($_POST["colorfont"])) {

$colorfont = "#".esc_attr($_POST["colorfont"]);     
set_theme_mod("colorfont", $colorfont);

}

if(isset($_POST["sizefont2"])) {

$sizefont2 = esc_attr($_POST["sizefont2"]);     
if(floki_validate_size($sizefont2)) set_theme_mod("sizefont2", $sizefont2);
else $mens1.=__("  * Incorrect font size", "floki");
}

if(isset($_POST["colorfont2"])) {

$colorfont2 = "#".esc_attr($_POST["colorfont2"]);     
set_theme_mod("colorfont2", $colorfont2);

}

if(isset($_POST["colorfont3"])) {

$colorfont3 = "#".esc_attr($_POST["colorfont3"]);     
set_theme_mod("colorfont3", $colorfont3);

}

if(isset($_POST["colorfont4"])) {


$colorfont4 = "#".esc_attr($_POST["colorfont4"]);     
set_theme_mod("colorfont4", $colorfont4);

}

if(isset($_POST["sizefonth1"])) {


$sizefonth1 = esc_attr($_POST["sizefonth1"]);
if(floki_validate_size($sizefonth1)) set_theme_mod("sizefonth1", $sizefonth1);
else $mens1.=__("  * Incorrect font size", "floki");
}

if(isset($_POST["colorfonth1"])) {

$colorfonth1 = "#".esc_attr($_POST["colorfonth1"]);     
set_theme_mod("colorfonth1", $colorfonth1);

}

if(isset($_POST["sizefonth2"])) {

$sizefonth2 = esc_attr($_POST["sizefonth2"]);     
if(floki_validate_size($sizefonth2)) set_theme_mod("sizefonth2", $sizefonth2);
else $mens1.=__("  * Incorrect font size", "floki");

}

if(isset($_POST["colorfonth2"])) {

$colorfonth2 = "#".esc_attr($_POST["colorfonth2"]);     
set_theme_mod("colorfonth2", $colorfonth2);

}

if(isset($_POST["sizefonth3"])) {

$sizefonth3 = esc_attr($_POST["sizefonth3"]);     
if(floki_validate_size($sizefonth3)) set_theme_mod("sizefonth3", $sizefonth3);
else $mens1.=__("  * Incorrect font size", "floki");

}

if(isset($_POST["colorfonth3"])) {

$colorfonth3 = "#".esc_attr($_POST["colorfonth3"]);     
set_theme_mod("colorfonth3", $colorfonth3);

}

if(isset($_POST["sizefonth4"])) {

$sizefonth4 = esc_attr($_POST["sizefonth4"]);     
if(floki_validate_size($sizefonth4)) set_theme_mod("sizefonth4", $sizefonth4);
else $mens1.=__("  * Incorrect font size", "floki");

}

if(isset($_POST["colorfonth4"])) {

$colorfonth4 = "#".esc_attr($_POST["colorfonth4"]);     
set_theme_mod("colorfonth4", $colorfonth4);

}

if(isset($_POST["sizefonth5"])) {

$sizefonth5 = esc_attr($_POST["sizefonth5"]);     
if(floki_validate_size($sizefonth5)) set_theme_mod("sizefonth5", $sizefonth5);
else $mens1.=__("  * Incorrect font size", "floki");
}

if(isset($_POST["colorfonth5"])) {

$colorfonth5 = "#".esc_attr($_POST["colorfonth5"]);     
set_theme_mod("colorfonth5", $colorfonth5);
}

if(isset($_POST["socialopacity"])) {

$socialopacity = esc_attr($_POST["socialopacity"]);     
set_theme_mod("socialopacity", $socialopacity);
}

if(isset($_POST["facebook"])) {

$facebook = esc_url($_POST["facebook"]);     
set_theme_mod("facebook", $facebook);
}

if(isset($_POST["rss"])) {

$rss = esc_url($_POST["rss"]);     
set_theme_mod("rss", $rss);
}

if(isset($_POST["twitter"])) {

$twitter = esc_url($_POST["twitter"]);     
set_theme_mod("twitter", $twitter);
}

if(isset($_POST["flickr"])) {

$flickr = esc_url($_POST["flickr"]);     
set_theme_mod("flickr", $flickr);
}

if(isset($_POST["youtube"])) {

$youtube = esc_url($_POST["youtube"]);     
set_theme_mod("youtube", $youtube);
}

if(isset($_POST["vimeo"])) {

$vimeo = esc_url($_POST["vimeo"]);     
set_theme_mod("vimeo", $vimeo);
}

if(isset($_POST["google"])) {

$google = esc_url($_POST["google"]);     
set_theme_mod("google", $google);
}

if(isset($_POST["pinterest"])) {

$pinterest = esc_url($_POST["pinterest"]);     
set_theme_mod("pinterest", $pinterest);
}

if(isset($_POST["tumblr"])) {

$tumblr = esc_url($_POST["tumblr"]);     
set_theme_mod("tumblr", $tumblr);
}

if(isset($_POST["dribbble"])) {

$dribbble = esc_url($_POST["dribbble"]);     
set_theme_mod("dribbble", $dribbble);
}

if(isset($_POST["digg"])) {

$digg = esc_url($_POST["digg"]);     
set_theme_mod("digg", $digg);
}

if(isset($_POST["linkedin"])) {

$linkedin = esc_url($_POST["linkedin"]);     
set_theme_mod("linkedin", $linkedin);
}

if(isset($_POST["blogger"])) {

$blogger = esc_url($_POST["blogger"]);     
set_theme_mod("blogger", $blogger);
}

if(isset($_POST["skype"])) {

$skype = esc_url($_POST["skype"]);     
set_theme_mod("skype", $skype);
}

if(isset($_POST["myspace"])) {

$myspace = esc_url($_POST["myspace"]);     
set_theme_mod("myspace", $myspace);
}

if(isset($_POST["yahoo"])) {

$yahoo = esc_url($_POST["yahoo"]);     
set_theme_mod("yahoo", $yahoo);
}

if(isset($_POST["tipesocial"])) {

$tipesocial = esc_attr($_POST["tipesocial"]);     
set_theme_mod("tipesocial", $tipesocial);
}

if(isset($_POST["hfixed"])) {
$hfixed = esc_attr($_POST["hfixed"]);     
set_theme_mod("hfixed", $hfixed);
}
else {
	set_theme_mod("hfixed", 0);
}

if(isset($_POST["footertext"])) {

$footertext = esc_attr($_POST["footertext"]);     
set_theme_mod("footertext", $footertext);
}

if(isset($_POST["footersocial"])) {

$footersocial = esc_attr($_POST["footersocial"]);     
set_theme_mod("footersocial", $footersocial);
}

if(isset($_POST["footerwidgets"])) {

$footerwidgets = esc_attr($_POST["footerwidgets"]);     
set_theme_mod("footerwidgets", $footerwidgets);
}

if(isset($_POST["colorzone4"])) {

$colorzone4 = "#".esc_attr($_POST["colorzone4"]);     
set_theme_mod("colorzone4", $colorzone4);
}

if(isset($_POST["headingfont"])) {

$headingfont = esc_attr($_POST["headingfont"]);     
set_theme_mod("headingfont", $headingfont);

}


if(isset($_POST["anidiv"])) {

$anidiv = esc_attr($_POST["anidiv"]);     
set_theme_mod("anidiv", $anidiv);

}

if(isset($_POST["aniimg"])) {

$aniimg = esc_attr($_POST["aniimg"]);     
set_theme_mod("aniimg", $aniimg);

}

if(isset($_POST["anih"])) {

$anih = esc_attr($_POST["anih"]);     
set_theme_mod("anih", $anih);

}

if(isset($_POST["anilink"])) {

$anilink = esc_attr($_POST["anilink"]);     
set_theme_mod("anilink", $anilink);

}

if(isset($_POST["anip"])) {

$anip = esc_attr($_POST["anip"]);     
set_theme_mod("anip", $anip);

}


if(isset($_POST["su_compatibility_mode_prefix"])) {


$su_compatibility_mode_prefix = esc_attr($_POST["su_compatibility_mode_prefix"]);     
set_theme_mod("su_compatibility_mode_prefix", $su_compatibility_mode_prefix);


$mens1= '<div id="message" class="updated">'.__( 'Options updated', 'floki' ).'</div>  ';

}


}

function floki_validate_size($size) {
	
	$size=trim($size);
	$med=strlen($size);
	$number=substr($size, 0, $med-2);
	if((strpos($size, "em", $med-2) || strpos($size, "px", $med-2)) && is_numeric(trim($number))) return true;
	else return false;
}

function floki_validate_image($url)
{
	if($url=="") return true;
	$auxi=explode('.', $url);
	$ext = strtolower(end($auxi));
	
	switch($ext)
	{
		case 'jpg': return true;
		case 'png': return true;
		case 'gif': return true;
		case 'tiff': return true;
		case 'svg': return true;
		case 'ico': return true;
		case 'tif': return true;
		///Blah
		break;
	}
	
	return false;

}

if(isset($_POST["floki_default"])) {
	floki_default_options();
}
//// end update
?>


<div class="admin_main">

<div class="admin_logo">
<h1><img src="<?php echo get_stylesheet_directory_uri() . '/images/logo.png'; ?>"> <?php _e( 'floki theme options', 'floki' ); ?></h1>
</div>
<form method="post" action="">
<div class="admin_men">

<div class="cleft">
<?php echo $mens1; ?>
</div>

<div class="cright">
<br/>
<input type="submit" value="<?php _e( 'Save Options', 'floki' ); ?>" class="button-primary"/>
</div>

</div>

<div class="admin_left">
<ul>
<li><a class="adminbutton buttonactive" href="#" id="general" name="general" ><?php _e( 'General options', 'floki' ); ?></a></li>
<li><a class="adminbutton buttoninactive" href="#" id="palette" name="palette"><?php _e( 'Colors', 'floki' ); ?></a></li>
<li><a class="adminbutton buttoninactive" href="#" id="style" name="style"><?php _e( 'Design', 'floki' ); ?></a></li>
<li><a class="adminbutton buttoninactive" href="#" id="font" name="font"><?php _e( 'Fonts', 'floki' ); ?></a></li>
<li><a class="adminbutton buttoninactive" href="#" id="header" name="header"><?php _e( 'Header options', 'floki' ); ?></a></li>
<li><a class="adminbutton buttoninactive" href="#" id="sidebar" name="sidebar"><?php _e( 'Sidebar options', 'floki' ); ?></a></li>
<li><a class="adminbutton buttoninactive" href="#" id="footer" name="footer"><?php _e( 'Footer options', 'floki' ); ?></a></li>
<li><a class="adminbutton buttoninactive" href="#" id="animations" name="animations"><?php _e( 'Animations options', 'floki' ); ?></a></li>
</ul>
</div>

<div class="admin_right">
<div class="groupoptions" id="animations_group" name="animations_group"  style="display: none">
<?php

$value = floki_get_option('anidiv');

  echo '<h3>';
       _e( 'Select div animations', 'floki' );
  echo ' </h3>';
  echo '<select name="anidiv" id="anidiv">
  <option value="" ';
selected( esc_attr( $value ), '' );
 
 echo '>'.__('None', 'floki').'</option>
  <option value="despx" ';
selected( esc_attr( $value ), 'despx' );
 
 echo '>'.__('Opacity', 'floki').'</option>
  <option value="despy" ';
selected( esc_attr( $value ), 'despy' );
 
 echo '>'.__('Rotate Y', 'floki').'</option>
  <option value="rotate" ';
selected( esc_attr( $value ), 'rotate' );
 
 echo '>'.__('Rotate X', 'floki').'</option>
  </select> ';
  
  
    $value = floki_get_option('aniimg');

  echo '<br/><br/><h3>';
       _e( 'Select image animations', 'floki' );
  echo ' </h3>';
  echo '<select name="aniimg" id="aniimg">
  <option value="" ';
selected( esc_attr( $value ), '' );
 
 echo '>'.__('None', 'floki').'</option>
  <option value="despx" ';
selected( esc_attr( $value ), 'despx' );
 
 echo '>'.__('Opacity', 'floki').'</option>
  <option value="despy" ';
selected( esc_attr( $value ), 'despy' );
 
 echo '>'.__('Rotate Y', 'floki').'</option>
  <option value="rotate" ';
selected( esc_attr( $value ), 'rotate' );
 
 echo '>'.__('Rotate X', 'floki').'</option>
  </select> ';
  
  
      $value = floki_get_option('anih');

  echo '<br/><br/><h3>';
       _e( 'Select heading animations', 'floki' );
  echo ' </h3>';
  echo '<select name="anih" id="anih">
  <option value="" ';
selected( esc_attr( $value ), '' );
 
 echo '>'.__('None', 'floki').'</option>
  <option value="despx" ';
selected( esc_attr( $value ), 'despx' );
 
 echo '>'.__('Opacity', 'floki').'</option>
  <option value="despy" ';
selected( esc_attr( $value ), 'despy' );
 
 echo '>'.__('Rotate Y', 'floki').'</option>
  <option value="rotate" ';
selected( esc_attr( $value ), 'rotate' );
 
 echo '>'.__('Rotate X', 'floki').'</option>
  </select> ';
  
  
        $value = floki_get_option('anilink');

  echo '<br/><br/><h3>';
       _e( 'Select link animations', 'floki' );
  echo ' </h3>';
  echo '<select name="anilink" id="anilink">
  <option value="" ';
selected( esc_attr( $value ), '' );
 
 echo '>'.__('None', 'floki').'</option>
  <option value="despx" ';
selected( esc_attr( $value ), 'despx' );
 
 echo '>'.__('Opacity', 'floki').'</option>
  <option value="despy" ';
selected( esc_attr( $value ), 'despy' );
 
 echo '>'.__('Rotate Y', 'floki').'</option>
  <option value="rotate" ';
selected( esc_attr( $value ), 'rotate' );
 
 echo '>'.__('Rotate X', 'floki').'</option>
  </select> ';
  
   $value = floki_get_option('anip');

  echo '<br/><br/><h3>';
       _e( 'Select text animations', 'floki' );
  echo ' </h3>';
  echo '<select name="anip" id="anip">
  <option value="" ';
selected( esc_attr( $value ), '' );
 
 echo '>'.__('None', 'floki').'</option>
  <option value="despx" ';
selected( esc_attr( $value ), 'despx' );
 
 echo '>'.__('Opacity', 'floki').'</option>
  <option value="despy" ';
selected( esc_attr( $value ), 'despy' );
 
 echo '>'.__('Rotate Y', 'floki').'</option>
  <option value="rotate" ';
selected( esc_attr( $value ), 'rotate' );
 
 echo '>'.__('Rotate X', 'floki').'</option>
  </select> ';

?>

</div>
<div class="groupoptions" id="general_group" name="general_group">

<h3><?php _e( 'Custom Favicon', 'floki' ); ?></h3>
<input type="text" name="favicon" id="favicon" class="input1" value ="<?php echo esc_url(floki_get_option( 'favicon' )); ?>"  />
<input class="upload-button btn btn-sm btn-info" name="wsl-image-add" type="button" value="Select" /> <br/>
<span><?php _e( 'You can put url of an icon image that will represent your website\'s favicon (16px x 16px)', 'floki' ); ?></span>

<h3><?php _e( 'Apple iPhone Icon', 'floki' ); ?></h3>
<input type="text" name="iconapple" id="iconapple" class="input1" value ="<?php echo esc_url(floki_get_option( 'iconapple' )); ?>"  />
<input class="upload-button btn btn-sm btn-info" name="wsl-image-add" type="button" value="Select" /> <br/>
<span><?php _e( 'Icon for Apple iPhone (57px x 57px)', 'floki' ); ?></span>

<h3><?php _e( 'Apple iPhone Retina Icon', 'floki' ); ?></h3>
<input type="text" name="iconapple2" id="iconapple2" class="input1" value ="<?php echo esc_url(floki_get_option( 'iconapple2' )); ?>"  />
<input class="upload-button btn btn-sm btn-info" name="wsl-image-add" type="button" value="Select" /> <br/>
<span><?php _e( 'Icon for Apple iPhone Retina Version (114px x 114px)', 'floki' ); ?></span>

<h3><?php _e( 'Apple iPad Icon', 'floki' ); ?></h3>
<input type="text" name="iconapple3" id="iconapple3" class="input1" value ="<?php echo esc_url(floki_get_option( 'iconapple3' )); ?>"  />
<input class="upload-button btn btn-sm btn-info" name="wsl-image-add" type="button" value="Select" /> <br/>
<span><?php _e( 'Icon for Apple iPhone (72px x 72px)', 'floki' ); ?></span>

<h3><?php _e( 'Apple iPad Retina Icon', 'floki' ); ?></h3>
<input type="text" name="iconapple4" id="iconapple4" class="input1" value ="<?php echo esc_url(floki_get_option( 'iconapple4' )); ?>"  />
<input class="upload-button btn btn-sm btn-info" name="wsl-image-add" type="button" value="Select" /> <br/>
<span><?php _e( 'Icon for Apple iPad Retina Version (144px x 144px)', 'floki' ); ?></span>


<h3><?php _e( 'Allow comments on pages', 'floki' ); ?></h3>
<span>
<input id="comments" name="comments" type="checkbox" value="1"
<?php checked( '1', floki_get_option( 'comments' )); ?> /> 
<?php _e( 'Allow comments on regular pages.', 'floki' ); ?></span>

 
 <h3><?php _e( 'Code inside head tag', 'floki' ); ?></h3>
<textarea class="of-input" name="headcode" id="headcode" cols="70" rows="7"><?php echo (floki_get_option( 'headcode' )); ?></textarea> <br/>
<span><?php _e( 'Add code before the /head tag.', 'floki' ); ?></span>

<h3><?php _e( 'Code inside body tag', 'floki' ); ?></h3>
<textarea class="of-input" name="bodycode" id="bodycode" cols="70" rows="7"><?php echo esc_textarea(floki_get_option( 'bodycode' )); ?></textarea> <br/>
<span><?php _e( 'Add code before the /body tag.', 'floki' ); ?></span>  

</div>

<div class="groupoptions" id="header_group" name="header_group" style="display: none">



<h3><?php _e( 'Logo', 'floki' ); ?></h3>
<input type="text" name="logo" id="logo" class="input1" value ="<?php echo esc_url(floki_get_option( 'logo' )); ?>"  />
<input class="upload-button btn btn-sm btn-info" name="wsl-image-add" type="button" value="Select" /> <br/>
<span><?php _e( 'Url image logo', 'floki' ); ?></span>

<h3><?php _e( 'Home Main Image', 'floki' ); ?></h3>
<input type="text" name="mainimage" id="mainimage" class="input1" value ="<?php echo esc_url(floki_get_option( 'mainimage' )); ?>"  />
<input class="upload-button btn btn-sm btn-info" name="wsl-image-add" type="button" value="Select" /> <br/>
<span><?php _e( 'Url image home', 'floki' ); ?></span>

<h3><?php _e( 'Text Title home', 'floki' ); ?></h3>
<input type="text" name="headertitle" id="headertitle" value ="<?php echo esc_html(floki_get_option( 'headertitle' )); ?>" size="50" /><br/>
<span><?php _e( 'Title in home header', 'floki' ); ?></span>

<h3><?php _e( 'Text Description home', 'floki' ); ?></h3>
<input type="text" name="headerdescription" id="headerdescription" value ="<?php echo esc_html(floki_get_option( 'headerdescription' )); ?>" size="50" /><br/>
<span><?php _e( 'Description in home header', 'floki' ); ?></span>

<h3><?php _e( 'Slider shortcode', 'floki' ); ?></h3>
<input type="text" name="hslider" id="hslider" value ="<?php echo esc_attr(floki_get_option( 'hslider' )); ?>" size="50" /><br/>
<span><?php _e( 'Write plugin shortcode for home slider position.', 'floki' ); ?></span>

<h3><?php _e( 'Header fixed', 'floki' ); ?></h3>
<span>
<input id="hfixed" name="hfixed" type="checkbox" value="1"
<?php checked( '1', floki_get_option( 'hfixed' )); ?> /> 
<?php _e( 'Header fixed in top page.', 'floki' ); ?></span>

<h2><?php _e( 'TOP BAR', 'floki' ); ?></h2>

<h3><?php _e( 'TOP BAR Visible', 'floki' ); ?></h3>
<span>
<input id="visiblezone1" name="visiblezone1" type="checkbox" value="1"
<?php checked( '1', floki_get_option( 'visiblezone1' )); ?> /> 
<?php _e( 'TOP BAR visible.', 'floki' ); ?></span>

<h3><?php _e( 'Secondary menu position', 'floki' ); ?></h3>
 <select class="adminselect" name="menu_posi2" id="menu_posi2"><option id="sm-blue" value="logo"  <?php selected( floki_get_option( 'menu_posi2' ), 'logo' ); ?> /><?php _e( 'Not show', 'floki' ); ?></option><option id="sm-clean" value="top2" <?php selected( floki_get_option( 'menu_posi2' ), 'top2' ); ?> /><?php _e( 'Left', 'floki' ); ?></option> <option id="sm-simple" value="top" <?php selected( floki_get_option( 'menu_posi2' ), 'top' ); ?> /><?php _e( 'Right', 'floki' ); ?></option></select><br/>
<span><?php _e( 'Select submenu position in top bar', 'floki' ); ?></span>


<h3><?php _e( 'Social icons position', 'floki' ); ?></h3>
 <select class="adminselect" name="stylezone1" id="stylezone1"><option id="sm-blue" value="solid"  <?php selected( floki_get_option( 'stylezone1' ), 'solid' ); ?> /><?php _e( 'Not show', 'floki' ); ?></option><option id="sm-clean" value="degradate" <?php selected( floki_get_option( 'stylezone1' ), 'degradate' ); ?> /><?php _e( 'Left', 'floki' ); ?></option> <option id="sm-simple" value="otro" <?php selected( floki_get_option( 'stylezone1' ), 'otro' ); ?> /><?php _e( 'Right', 'floki' ); ?></option></select><br/>
<span><?php _e( 'Select social icons position in top bar', 'floki' ); ?></span>

<h2><?php _e( 'SOCIAL LINKS', 'floki' ); ?></h2>

<h3><?php _e( 'Social icons style', 'floki' ); ?></h3>
 <select class="adminselect" name="tipesocial" id="tipesocial"><option id="sm-blue" value="black"  <?php selected( floki_get_option( 'tipesocial' ), 'black' ); ?> /><?php _e( 'Black', 'floki' ); ?></option><option id="sm-clean" value="white" <?php selected( floki_get_option( 'tipesocial' ), 'white' ); ?> /><?php _e( 'Color', 'floki' ); ?></option></select><br/>
<span><?php _e( 'Select icons design: black or white.', 'floki' ); ?></span>

<h3><?php _e( 'Icons opacity', 'floki' ); ?></h3>
<input type="number" step="0.1" max="1" min="0" name="socialopacity" id="socialopacity" value ="<?php echo esc_attr(floki_get_option( 'socialopacity' )); ?>" size="5" /> <br/>
<span><?php _e( 'Number between 0-1. Sample: 0.5 ', 'floki' ); ?></span>



<h3><?php _e( 'Facebook link', 'floki' ); ?></h3>
<input type="text" name="facebook" id="facebook" value ="<?php echo esc_url(floki_get_option( 'facebook' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'RSS link', 'floki' ); ?></h3>
<input type="text" name="rss" id="rss" value ="<?php echo esc_url(floki_get_option( 'rss' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Twitter link', 'floki' ); ?></h3>
<input type="text" name="twitter" id="twitter" value ="<?php echo esc_url(floki_get_option( 'twitter' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Flickr link', 'floki' ); ?></h3>
<input type="text" name="flickr" id="flickr" value ="<?php echo esc_url(floki_get_option( 'flickr' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Youtube link', 'floki' ); ?></h3>
<input type="text" name="youtube" id="youtube" value ="<?php echo esc_url(floki_get_option( 'youtube' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Vimeo link', 'floki' ); ?></h3>
<input type="text" name="vimeo" id="vimeo" value ="<?php echo esc_url(floki_get_option( 'vimeo' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Google Plus link', 'floki' ); ?></h3>
<input type="text" name="google" id="google" value ="<?php echo esc_url(floki_get_option( 'google' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Pinterest link', 'floki' ); ?></h3>
<input type="text" name="pinterest" id="pinterest" value ="<?php echo esc_url(floki_get_option( 'pinterest' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Tumblr link', 'floki' ); ?></h3>
<input type="text" name="tumblr" id="tumblr" value ="<?php echo esc_url(floki_get_option( 'tumblr' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Dribbble link', 'floki' ); ?></h3>
<input type="text" name="dribbble" id="dribbble" value ="<?php echo esc_url(floki_get_option( 'dribbble' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Digg link', 'floki' ); ?></h3>
<input type="text" name="digg" id="digg" value ="<?php echo esc_url(floki_get_option( 'digg' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'LinkedIn link', 'floki' ); ?></h3>
<input type="text" name="linkedin" id="linkedin" value ="<?php echo esc_url(floki_get_option( 'linkedin' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Blogger link', 'floki' ); ?></h3>
<input type="text" name="blogger" id="blogger" value ="<?php echo esc_url(floki_get_option( 'blogger' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Skype link', 'floki' ); ?></h3>
<input type="text" name="skype" id="skype" value ="<?php echo esc_url(floki_get_option( 'skype' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Myspace link', 'floki' ); ?></h3>
<input type="text" name="myspace" id="myspace" value ="<?php echo esc_url(floki_get_option( 'myspace' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>

<h3><?php _e( 'Yahoo link', 'floki' ); ?></h3>
<input type="text" name="yahoo" id="yahoo" value ="<?php echo esc_url(floki_get_option( 'yahoo' )); ?>" size="50" /> <br/>
<span><?php _e( 'Write url with http://', 'floki' ); ?></span>
</div>
<div class="groupoptions" id="style_group" name="style_group" style="display: none">
<h2><?php _e( 'Background', 'floki' ); ?></h2>

<h3><?php _e( 'Background style', 'floki' ); ?></h3>
 <select class="adminselect" name="menu_design6" id="menu_design6"><option id="sm-blue" value="sm-blue"  <?php selected( floki_get_option( 'menu_design6' ), 'sm-blue' ); ?> /><?php _e( 'Not background', 'floki' ); ?></option><option id="sm-clean" value="sm-clean" <?php selected( floki_get_option( 'menu_design6' ), 'sm-clean' ); ?> /><?php _e( 'Color', 'floki' ); ?></option><option id="sm-clean" value="bimage" <?php selected( floki_get_option( 'menu_design6' ), 'bimage' ); ?> /><?php _e( 'Image', 'floki' ); ?></option></select><br/>
<span><?php _e( 'Select color type', 'floki' ); ?></span>

<script>
jQuery( "#menu_design6" ).change(function() {

if(jQuery( "#menu_design6" ).val()!="bimage") {
	jQuery('#color6').hide();
}
else {
	jQuery('#color6').show();
}

});
</script>

<h3><?php _e( 'Background Color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorzone6" id="colorzone6"  value ="<?php echo esc_attr(floki_get_option( 'colorzone6' )); ?>" size="7" /> <br/>
<span><?php _e( 'Select color', 'floki' ); ?></span>

<div id="color6" name="color6" style="<?php if(floki_get_option( 'menu_design6' )!="bimage") echo 'display:none;'; ?>" >
<h3><?php _e( 'Image background', 'floki' ); ?></h3>
<input type="text" name="bimage" id="bimage" class="input1" value ="<?php echo esc_url(floki_get_option( 'bimage' )); ?>"  />
<input class="upload-button btn btn-sm btn-info" name="wsl-image-add" type="button" value="Select" /> <br/> <br/>
<span><?php _e( 'Image background', 'floki' ); ?></span>
</div>

<h2><?php _e( 'Top Bar', 'floki' ); ?></h2>

<h3><?php _e( 'Color style', 'floki' ); ?></h3>
 <select class="adminselect" name="menu_design2" id="menu_design2"><option id="sm-blue" value="sm-blue"  <?php selected( floki_get_option( 'menu_design2' ), 'sm-blue' ); ?> /><?php _e( 'Solid color', 'floki' ); ?></option><option id="sm-clean" value="sm-clean" <?php selected( floki_get_option( 'menu_design2' ), 'sm-clean' ); ?> /><?php _e( 'Degradate color', 'floki' ); ?></option></select><br/>
<span><?php _e( 'Select color type', 'floki' ); ?></span>

<script>
jQuery( "#menu_design2" ).change(function() {

if(jQuery( "#menu_design2" ).val()=="sm-blue") {
	jQuery('#color1').hide();
}
else {
	jQuery('#color1').show();
}

});
</script>

<h3><?php _e( 'Color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorzone1" id="colorzone1"  value ="<?php echo esc_attr(floki_get_option( 'colorzone1' )); ?>" size="7" /> <br/>
<span><?php _e( 'Color top bar', 'floki' ); ?></span>

<div id="color1" name="color1" style="<?php if(floki_get_option( 'menu_design2' )=="sm-blue") echo 'display:none;'; ?>" >
<h3><?php _e( 'Color 2', 'floki' ); ?></h3>
<input class="color" type="text" name="color2zone1" id="color2zone1"  value ="<?php echo esc_attr(floki_get_option( 'color2zone1' )); ?>" size="7" /> <br/>
<span><?php _e( 'Color 2 top bar', 'floki' ); ?></span>
</div>


<h2><?php _e( 'Header', 'floki' ); ?></h2>




<h3><?php _e( 'Color style', 'floki' ); ?></h3>
 <select class="adminselect" name="visiblezone2" id="visiblezone2"><option id="sm-blue" value="sm-blue"  <?php selected( floki_get_option( 'visiblezone2' ), 'sm-blue' ); ?> /><?php _e( 'Solid color', 'floki' ); ?></option><option id="sm-clean" value="sm-clean" <?php selected( floki_get_option( 'visiblezone2' ), 'sm-clean' ); ?> /><?php _e( 'Degradate color', 'floki' ); ?></option></select><br/>
<span><?php _e( 'Select color type', 'floki' ); ?></span>

<script>

jQuery( "#visiblezone2" ).change(function() {

if(jQuery( "#visiblezone2" ).val()=="sm-blue") {
	jQuery('#color2').hide();
}
else {
	jQuery('#color2').show();
}

});
</script>


<h3><?php _e( 'Color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorzone2" id="colorzone2"  value ="<?php echo esc_attr(floki_get_option( 'colorzone2' )); ?>" size="7" /> <br/>
<span><?php _e( 'Color header', 'floki' ); ?></span>


<div id="color2" name="color2" style="<?php if(floki_get_option( 'visiblezone2' )=="sm-blue") echo 'display:none;'; ?>" >
<h3><?php _e( 'Color 2', 'floki' ); ?></h3>
<input class="color" type="text" name="color2zone2" id="color2zone2"  value ="<?php echo esc_attr(floki_get_option( 'color2zone2' )); ?>" size="7" /> <br/>
<span><?php _e( 'Color 2 header', 'floki' ); ?></span>
</div>

<h2><?php _e( 'Body', 'floki' ); ?></h2>




<h3><?php _e( 'Color style', 'floki' ); ?></h3>
 <select class="adminselect" name="visiblezone5" id="visiblezone5"><option id="sm-blue" value="sm-blue"  <?php selected( floki_get_option( 'visiblezone5' ), 'sm-blue' ); ?> /><?php _e( 'Solid color', 'floki' ); ?></option><option id="sm-clean" value="sm-clean" <?php selected( floki_get_option( 'visiblezone5' ), 'sm-clean' ); ?> /><?php _e( 'Degradate color', 'floki' ); ?></option></select><br/>
<span><?php _e( 'Select color type', 'floki' ); ?></span>

<script>

jQuery( "#visiblezone5" ).change(function() {

if(jQuery( "#visiblezone5" ).val()=="sm-blue") {
	jQuery('#color5').hide();
}
else {
	jQuery('#color5').show();
}

});
</script>


<h3><?php _e( 'Color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorzone5" id="colorzone5"  value ="<?php echo esc_attr(floki_get_option( 'colorzone5' )); ?>" size="7" /> <br/>
<span><?php _e( 'Color body', 'floki' ); ?></span>


<div id="color5" name="color5" style="<?php if(floki_get_option( 'visiblezone5' )=="sm-blue") echo 'display:none;'; ?>" >
<h3><?php _e( 'Color 2', 'floki' ); ?></h3>
<input class="color" type="text" name="color2zone5" id="color2zone5"  value ="<?php echo esc_attr(floki_get_option( 'color2zone5' )); ?>" size="7" /> <br/>
<span><?php _e( 'Color 2 body', 'floki' ); ?></span>
</div>

<h2><?php _e( 'Footer', 'floki' ); ?></h2>


<h3><?php _e( 'Color style', 'floki' ); ?></h3>
 <select class="adminselect" name="visiblezone3" id="visiblezone3"><option id="sm-blue" value="sm-blue"  <?php selected( floki_get_option( 'visiblezone3' ), 'sm-blue' ); ?> /><?php _e( 'Solid color', 'floki' ); ?></option><option id="sm-clean" value="sm-clean" <?php selected( floki_get_option( 'visiblezone3' ), 'sm-clean' ); ?> /><?php _e( 'Degradate color', 'floki' ); ?></option></select><br/>
<span><?php _e( 'Select color type', 'floki' ); ?></span>

<script>

jQuery( "#visiblezone3" ).change(function() {

if(jQuery( "#visiblezone3" ).val()=="sm-blue") {
	jQuery('#color3').hide();
}
else {
	jQuery('#color3').show();
}

});
</script>


<h3><?php _e( 'Color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorzone3" id="colorzone3"  value ="<?php echo esc_attr(floki_get_option( 'colorzone3' )); ?>" size="7" /> <br/>
<span><?php _e( 'Color footer', 'floki' ); ?></span>


<div id="color3" name="color3" style="<?php if(floki_get_option( 'visiblezone3' )=="sm-blue") echo 'display:none;'; ?>" >
<h3><?php _e( 'Color 2', 'floki' ); ?></h3>
<input class="color" type="text" name="color2zone3" id="color2zone3"  value ="<?php echo esc_attr(floki_get_option( 'color2zone3' )); ?>" size="7" /> <br/>
<span><?php _e( 'Color 2 footer', 'floki' ); ?></span>
</div>

<h3><?php _e( 'Bottom', 'floki' ); ?></h3>
<input class="color" type="text" name="colorzone4" id="colorzone4"  value ="<?php echo esc_attr(floki_get_option( 'colorzone4' )); ?>" size="7" /> <br/>
<span><?php _e( 'Color bottom footer', 'floki' ); ?></span>

<h3><?php _e( 'Text Color', 'floki' ); ?></h3>
<input class="color" type="text" name="menusize2" id="menusize2"  value ="<?php echo esc_attr(floki_get_option( 'menusize2' )); ?>" size="7" /> <br/>
<span><?php _e( 'Select text footer color', 'floki' ); ?></span>



<h2><?php _e( 'Main Menu', 'floki' ); ?></h2>



<h3><?php _e( 'Text Color', 'floki' ); ?></h3>
<input class="color" type="text" name="menupading" id="menupading" value ="<?php echo esc_attr(floki_get_option( 'menupading' )); ?>" size="4" /> <br/>
<span><?php _e( 'Select or write menu text color.', 'floki' ); ?></span>


<h3><?php _e( 'Active Color', 'floki' ); ?></h3>
<input class="color" type="text" name="menusize" id="menusize"  value ="<?php echo esc_attr(floki_get_option( 'menusize' )); ?>" size="7" /> <br/>
<span><?php _e( 'Select or write color', 'floki' ); ?></span>

<h3><?php _e( 'Sub menu Text Color', 'floki' ); ?></h3>
<input class="color" type="text" name="menu_posi" id="menu_posi" value ="<?php echo esc_attr(floki_get_option( 'menu_posi' )); ?>" size="4" /> <br/>
<span><?php _e( 'Select or write sub menu text color.', 'floki' ); ?></span>

<h3><?php _e( 'Sub menu background color', 'floki' ); ?></h3>
<input class="color" type="text" name="menu_design" id="menu_design"  value ="<?php echo esc_attr(floki_get_option( 'menu_design' )); ?>" size="7" /> <br/>
<span><?php _e( 'Select or write color', 'floki' ); ?></span>

<h2><?php _e( 'Secondary Menu', 'floki' ); ?></h2>







<h3><?php _e( 'Text Color', 'floki' ); ?></h3>
<input class="color" type="text" name="menupading2" id="menupading2" value ="<?php echo esc_attr(floki_get_option( 'menupading2' )); ?>" size="4" /> <br/>
<span><?php _e( 'Select menu text color.', 'floki' ); ?></span>



</div>

<div class="groupoptions" id="font_group" name="font_group" style="display: none">

<h2><?php _e( 'Body', 'floki' ); ?></h2>

<h3><?php _e( 'Recommended google fonts', 'floki' ); ?></h3>
 <select class="adminselect" name="googlefont" id="googlefont">
 
  <option id="sm-simple" value="not" <?php selected( floki_get_option( 'googlefont' ), 'not' ); ?> /><?php _e('Use manual font', 'floki' ); ?></option>
 
 <option id="sm-blue" value="Open+Sans"  <?php selected( floki_get_option( 'googlefont' ), 'Open+Sans' ); ?> />Open Sans</option>
 
 <option id="sm-clean" value="Josefin+Slab" <?php selected( floki_get_option( 'googlefont' ), 'Josefin+Slab' ); ?> />Josefin Slab</option>
 
 <option id="sm-simple" value="Arvo" <?php selected( floki_get_option( 'googlefont' ), 'Arvo' ); ?> />Arvo</option>
 
 
 <option id="sm-simple" value="Lato" <?php selected( floki_get_option( 'googlefont' ), 'Lato' ); ?> />Lato</option>
 <option id="sm-simple" value="Vollkorn" <?php selected( floki_get_option( 'googlefont' ), 'Vollkorn' ); ?> />Vollkorn</option>
 <option id="sm-simple" value="Abril+Fatface" <?php selected( floki_get_option( 'googlefont' ), 'Abril+Fatface' ); ?> />Abril+Fatface</option>

  <option id="sm-simple" value="Roboto" <?php selected( floki_get_option( 'googlefont' ), 'Roboto' ); ?> />Roboto</option>
 </select><br/>
<h3><?php _e( 'Heading font', 'floki' ); ?></h3>
 <select class="adminselect" name="headingfont" id="headingfont">
 
  <option id="sm-simple" value="not" <?php selected( floki_get_option( 'headingfont' ), 'not' ); ?> /><?php _e( 'Use same font', 'floki' ); ?></option>
 
 <option id="sm-blue" value="Open+Sans"  <?php selected( floki_get_option( 'headingfont' ), 'Open+Sans' ); ?> />Open Sans</option>
 
 <option id="sm-clean" value="Josefin+Slab" <?php selected( floki_get_option( 'headingfont' ), 'Josefin+Slab' ); ?> />Josefin Slab</option>
 
 <option id="sm-simple" value="Arvo" <?php selected( floki_get_option( 'headingfont' ), 'Arvo' ); ?> />Arvo</option>
 
 
 <option id="sm-simple" value="Lato" <?php selected( floki_get_option( 'headingfont' ), 'Lato' ); ?> />Lato</option>
 <option id="sm-simple" value="Vollkorn" <?php selected( floki_get_option( 'headingfont' ), 'Vollkorn' ); ?> />Vollkorn</option>
 <option id="sm-simple" value="Abril+Fatface" <?php selected( floki_get_option( 'headingfont' ), 'Abril+Fatface' ); ?> />Abril+Fatface</option>
  <option id="sm-simple" value="Roboto" <?php selected( floki_get_option( 'headingfont' ), 'Roboto' ); ?> />Roboto</option>

 </select><br/> 
 
 
 
<span><?php _e( 'Select font', 'floki' ); ?></span>

<h3><?php _e( 'Manual font', 'floki' ); ?></h3>
<input type="text" name="manualfont" id="manualfont" value ="<?php echo esc_attr(floki_get_option( 'manualfont' )); ?>" size="30" /> <br/>
<span><?php _e( 'Write manual font', 'floki' ); ?></span>


<h3><?php _e( 'Font size', 'floki' ); ?></h3>
<input type="text" name="sizefont" id="sizefont" value ="<?php echo esc_attr(floki_get_option( 'sizefont' )); ?>" size="10" /> <br/>
<span><?php _e( 'Write size font: 12px, 1.2em, ...', 'floki' ); ?></span>


<h3><?php _e( 'Font color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorfont" id="colorfont" value ="<?php echo esc_attr(floki_get_option( 'colorfont' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select font color', 'floki' ); ?></span>

<h3><?php _e( 'Strong color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorstrong" id="colorstrong" value ="<?php echo esc_attr(floki_get_option( 'colorstrong' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select strong text color', 'floki' ); ?></span>

<h2>Link</h2>

<h3><?php _e( 'Font size', 'floki' ); ?></h3>
<input type="text" name="sizefont2" id="sizefont2" value ="<?php echo esc_attr(floki_get_option( 'sizefont2' )); ?>" size="10" /> <br/>
<span><?php _e( 'Write size font: 12px, 1.2em, ...', 'floki' ); ?></span>


<h3><?php _e( 'Font color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorfont2" id="colorfont2" value ="<?php echo esc_attr(floki_get_option( 'colorfont2' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select font color', 'floki' ); ?></span>

<h3><?php _e( 'Font color link hover', 'floki' ); ?></h3>
<input class="color" type="text" name="colorfont4" id="colorfont4" value ="<?php echo esc_attr(floki_get_option( 'colorfont4' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select font color', 'floki' ); ?></span>

<h3><?php _e( 'Font color link visited', 'floki' ); ?></h3>
<input class="color" type="text" name="colorfont3" id="colorfont3" value ="<?php echo esc_attr(floki_get_option( 'colorfont3' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select font color', 'floki' ); ?></span>


<h2>H1</h2>

<h3><?php _e( 'Font size', 'floki' ); ?></h3>
<input type="text" name="sizefonth1" id="sizefonth1" value ="<?php echo esc_attr(floki_get_option( 'sizefonth1' )); ?>" size="10" /> <br/>
<span><?php _e( 'Write size font: 12px, 1.2em, ...', 'floki' ); ?></span>


<h3><?php _e( 'Font color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorfonth1" id="colorfonth1" value ="<?php echo esc_attr(floki_get_option( 'colorfonth1' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select font color', 'floki' ); ?></span>

<h2>H2</h2>

<h3><?php _e( 'Font size', 'floki' ); ?></h3>
<input type="text" name="sizefonth2" id="sizefonth2" value ="<?php echo esc_attr(floki_get_option( 'sizefonth2' )); ?>" size="10" /> <br/>
<span><?php _e( 'Write size font: 12px, 1.2em, ...', 'floki' ); ?></span>


<h3><?php _e( 'Font color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorfonth2" id="colorfonth2" value ="<?php echo esc_attr(floki_get_option( 'colorfonth2' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select font color', 'floki' ); ?></span>

<h2>H3</h2>

<h3><?php _e( 'Font size', 'floki' ); ?></h3>
<input type="text" name="sizefonth3" id="sizefonth3" value ="<?php echo esc_attr(floki_get_option( 'sizefonth3' )); ?>" size="10" /> <br/>
<span><?php _e( 'Write size font: 12px, 1.2em, ...', 'floki' ); ?></span>


<h3><?php _e( 'Font color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorfonth3" id="colorfonth3" value ="<?php echo esc_attr(floki_get_option( 'colorfonth3' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select font color', 'floki' ); ?></span>

<h2>H4</h2>

<h3><?php _e( 'Font size', 'floki' ); ?></h3>
<input type="text" name="sizefonth4" id="sizefonth4" value ="<?php echo esc_attr(floki_get_option( 'sizefonth4' )); ?>" size="10" /> <br/>
<span><?php _e( 'Write size font: 12px, 1.2em, ...', 'floki' ); ?></span>


<h3><?php _e( 'Font color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorfonth4" id="colorfonth4" value ="<?php echo esc_attr(floki_get_option( 'colorfonth4' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select font color', 'floki' ); ?></span>

<h2>H5</h2>

<h3><?php _e( 'Font size', 'floki' ); ?></h3>
<input type="text" name="sizefonth5" id="sizefonth5" value ="<?php echo esc_attr(floki_get_option( 'sizefonth5' )); ?>" size="10" /> <br/>
<span><?php _e( 'Write size font: 12px, 1.2em, ...', 'floki' ); ?></span>


<h3><?php _e( 'Font color', 'floki' ); ?></h3>
<input class="color" type="text" name="colorfonth5" id="colorfonth5" value ="<?php echo esc_attr(floki_get_option( 'colorfonth5' )); ?>" size="4" /> <br/>
<span><?php _e( 'Write or select font color', 'floki' ); ?></span>


</div>


<div class="groupoptions" id="footer_group" name="footer_group" style="display: none">

<h3><?php _e( 'Widget columns', 'floki' ); ?></h3>
 <select class="adminselect" name="footerwidgets" id="footerwidgets"><option id="none" value="none"  <?php selected( floki_get_option( 'footerwidgets' ), 'none' ); ?> /><?php _e( 'None', 'floki' ); ?></option><option id="1" value="1"  <?php selected( floki_get_option( 'footerwidgets' ), '1' ); ?> />1 <?php _e( 'column', 'floki' ); ?></option><option id="2" value="2"  <?php selected( floki_get_option( 'footerwidgets' ), '2' ); ?> />2 <?php _e( 'columns', 'floki' ); ?></option><option id="3" value="3"  <?php selected( floki_get_option( 'footerwidgets' ), '3' ); ?> />3 <?php _e( 'columns', 'floki' ); ?></option><option id="4" value="4"  <?php selected( floki_get_option( 'footerwidgets' ), '4' ); ?> />4 <?php _e( 'columns', 'floki' ); ?></option></select> <br/>
<span><?php _e( 'Select footer widget columns', 'floki' ); ?></span>

 <h3><?php _e( 'Copyright and footer text', 'floki' ); ?></h3>
<textarea class="of-input" name="footertext" id="footertext" cols="70" rows="7"><?php echo esc_textarea(floki_get_option( 'footertext' )); ?></textarea> <br/>
<span><?php _e( 'Write footer text', 'floki' ); ?></span>

<h3><?php _e( 'Social icons', 'floki' ); ?></h3>
 <select class="adminselect" name="footersocial" id="footersocial"><option id="none" value="none"  <?php selected( floki_get_option( 'footersocial' ), 'none' ); ?> /><?php _e( 'Not show', 'floki' ); ?></option><option id="white" value="white"  <?php selected( floki_get_option( 'footersocial' ), 'white' ); ?> /><?php _e( 'Color icons', 'floki' ); ?></option><option id="black" value="black" <?php selected( floki_get_option( 'footersocial' ), 'black' ); ?> /><?php _e( 'Black icons', 'floki' ); ?></option></select> <br/>
<span><?php _e( 'Social icons in footer. Social links in header options.', 'floki' ); ?></span>

</div>

<div class="groupoptions" id="sidebar_group" name="sidebar_group" style="display: none">




<h3><?php _e( 'Sidebar Position home', 'floki' ); ?></h3>
 <select class="adminselect" name="default_sidebar_pos2" id="default_sidebar_pos2"><option id="none" value="none"  <?php selected( floki_get_option( 'default_sidebar_pos2' ), 'none' ); ?> /><?php _e( 'Not show', 'floki' ); ?></option><option id="right" value="right"  <?php selected( floki_get_option( 'default_sidebar_pos2' ), 'right' ); ?> /><?php _e( 'Position Right', 'floki' ); ?></option><option id="left" value="left" <?php selected( floki_get_option( 'default_sidebar_pos2' ), 'left' ); ?> /><?php _e( 'Position Left', 'floki' ); ?></option></select> <br/>
<span><?php _e( 'Select the position of the sidebar in home page.', 'floki' ); ?></span>


<h3><?php _e( 'Sidebar Position in Posts', 'floki' ); ?></h3>
 <select class="adminselect" name="default_sidebar_pos" id="default_sidebar_pos"><option id="none" value="none"  <?php selected( floki_get_option( 'default_sidebar_pos' ), 'none' ); ?> /><?php _e( 'Not show', 'floki' ); ?></option><option id="right" value="right"  <?php selected( floki_get_option( 'default_sidebar_pos' ), 'right' ); ?> /><?php _e( 'Position Right', 'floki' ); ?></option><option id="left" value="left" <?php selected( floki_get_option( 'default_sidebar_pos' ), 'left' ); ?> /><?php _e( 'Position Left', 'floki' ); ?></option></select> <br/>
<span><?php _e( 'Select the defeault position of the sidebar.', 'floki' ); ?></span>

<h3><?php _e( 'Sidebar Position in pages', 'floki' ); ?></h3>
 <select class="adminselect" name="default_sidebar_pos3" id="default_sidebar_pos3"><option id="none" value="none"  <?php selected( floki_get_option( 'default_sidebar_pos3' ), 'none' ); ?> /><?php _e( 'Not show', 'floki' ); ?></option><option id="right" value="right"  <?php selected( floki_get_option( 'default_sidebar_pos3' ), 'right' ); ?> /><?php _e( 'Position Right', 'floki' ); ?></option><option id="left" value="left" <?php selected( floki_get_option( 'default_sidebar_pos3' ), 'left' ); ?> /><?php _e( 'Position Left', 'floki' ); ?></option></select> <br/>
<span><?php _e( 'Select the position of the sidebar in pages.', 'floki' ); ?></span>

<h3><?php _e( 'Sidebar Position in archives', 'floki' ); ?></h3>
 <select class="adminselect" name="default_sidebar_pos4" id="default_sidebar_pos4"><option id="none" value="none"  <?php selected( floki_get_option( 'default_sidebar_pos4' ), 'none' ); ?> /><?php _e( 'Not show', 'floki' ); ?></option><option id="right" value="right"  <?php selected( floki_get_option( 'default_sidebar_pos4' ), 'right' ); ?> /><?php _e( 'Position Right', 'floki' ); ?></option><option id="left" value="left" <?php selected( floki_get_option( 'default_sidebar_pos4' ), 'left' ); ?> /><?php _e( 'Position Left', 'floki' ); ?></option></select> <br/>
<span><?php _e( 'Select the position of the sidebar in home page.', 'floki' ); ?></span>

</div>


<div class="groupoptions" id="palette_group" name="palette_group" style="display: none">


<h3><?php _e( 'Main color', 'floki' ); ?></h3>
<input class="color" type="text" name="palcolor1" id="palcolor1" value ="<?php echo esc_attr(floki_get_option( 'palcolor1' )); ?>" size="6" /> <br/>
<span><?php _e( 'Write or select color', 'floki' ); ?></span>

<h3><?php _e( 'Dark color', 'floki' ); ?></h3>
<input class="color" type="text" name="palcolor2" id="palcolor2" value ="<?php echo esc_attr(floki_get_option( 'palcolor2' )); ?>" size="6" /> <br/>
<span><?php _e( 'Write or select color', 'floki' ); ?></span>

<h3><?php _e( 'Light color', 'floki' ); ?></h3>
<input class="color" type="text" name="palcolor3" id="palcolor3" value ="<?php echo esc_attr(floki_get_option( 'palcolor3' )); ?>" size="6" /> <br/>
<span><?php _e( 'Write or select color', 'floki' ); ?></span>

<h3><?php _e( 'Text color', 'floki' ); ?></h3>
<input class="color" type="text" name="palcolor4" id="palcolor4" value ="<?php echo esc_attr(floki_get_option( 'palcolor4' )); ?>" size="6" /> <br/>
<span><?php _e( 'Write or select color', 'floki' ); ?></span>

<br/><br/>
<button id="palette" name="palette" class="button-primary"><?php _e( 'LOAD COLORS', 'floki' ); ?></button>




</div>



</div>


<div style="clear: both"></div>
<div class="admin_men">

<div class="cleft">
<?php echo $mens1; ?>
</div>

<div class="cright">
<input type="submit" value="<?php _e( 'Save Options', 'floki' ); ?>" class="button-primary"/>
<br/><br/>
<input type="submit" id="floki_default" name="floki_default" value="<?php _e( 'Restore Default', 'floki' ); ?>" class="button-secondary"/>
</div>

</div>

</div>
<input type="hidden" id="settings-updated" name="settings-updated" value="1" />
</form>