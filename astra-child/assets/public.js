(function( $ ) {
	'use strict';

	$(document).ready(function () {
		
		$('.magnify').jqzoom({  
			zoomType: 'innerzoom', 
			showEffect : 'fadein',  
			hideEffect: 'fadeout'
		});

	});

})( jQuery );