// JavaScript Document

jQuery(document).ready( function () { 
	

	
		jQuery.fn.exists = function(){return this.length>0;}
		
		var uploadID = ''; /*setup the var in a global scope*/

jQuery('.upload-button').click(function() {
	

//uploadID = jQuery(this).prev('input');
uploadID = jQuery(this).prev('input');


window.send_to_editor = function(html) {

var textt=html;


if(textt.search("img")!=-1) imgurl = jQuery('img',html).attr('src');

else {

	imgurl = jQuery(html).attr('href');

}

uploadID.val(imgurl)
tb_remove();
}




if ( typeof wp !== 'undefined' && wp.media && wp.media.editor ) wp.media.editor.open();

else tb_show('', 'media-upload.php?type=image&amp;amp;amp;amp;TB_iframe=true&uploadID=' + uploadID);

return false;
});


jQuery('.adminbutton').click(function() {
	
	jQuery('.groupoptions').css({"display" : "none"});
	jQuery('.adminbutton').removeClass("buttonactive");
	jQuery('.adminbutton').addClass("buttoninactive");
	jQuery('#'+jQuery(this).attr("name")+'_group').show();
	jQuery(this).removeClass("buttoninactive");
	jQuery(this).addClass("buttonactive");
	
});

jQuery('#sdtype').change(function() {
	
	
	
	jQuery('.gmm').hide("fast");
	jQuery('#gm'+jQuery('#sdtype').val()).show("fast");

	
});

});