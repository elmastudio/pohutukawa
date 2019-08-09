/*---------------------------------------------------------------------------------------------
  Flexible width for embedded videos (see https://github.com/davatron5000/FitVids.js/)
----------------------------------------------------------------------------------------------*/
	jQuery(document).ready(function(){
		// Target your .container, .wrapper, .post, etc.
		jQuery('#wrap').fitVids();
	});

/*---------------------------------------------------------------------------------------------
  Support Placeholder input text in IE (see https://github.com/danielstocks/jQuery-Placeholder)
----------------------------------------------------------------------------------------------*/
	jQuery(document).ready(function(){
		jQuery('input[placeholder], textarea[placeholder]').placeholder();
	});