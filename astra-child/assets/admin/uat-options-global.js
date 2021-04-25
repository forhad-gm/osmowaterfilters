/* general options js */
jQuery(document).ready(function($) {
    

	$('.top_prods_shortcode_selector').on('change', function() {
		$('#shortcode_holder_id').attr('value', this.value);
	});

	$('.radio_top_prods_chooser').on('click', function() {
		$('#shortcode_holder_type').attr('value', this.value);
	});


	$('body').on('click', '#insert_slider_shortcode', function() {
		var temp_ID_value = $('#shortcode_holder_id').attr('value');
		var temp_ID_type = $('#shortcode_holder_type').attr('value');
		var slider_shortcode = '[topproducts id="'+temp_ID_value+'" type="'+temp_ID_type+'"]';
		tinymce.activeEditor.execCommand('mceInsertContent', false, slider_shortcode);
		self.parent.tb_remove();
	});


	// function for toggling on/off button image and class
	$('body').on('click', '.toggle-check', function() {
		if ($(this).hasClass('on')) {
			$(this).addClass('off');
			$(this).removeClass('on');
			$(this).attr('src', '../wp-content/themes/ultimateazon/uat-dashboard/uat-options/img/activeoff.png');
			// fades out row on product options page
			$(this).closest('#main-product-custom-specs tbody tr').addClass('inactive-spec');
			$(this).prev().attr('value', 'off');
		}
		else{
			$(this).addClass('on');
			$(this).removeClass('off');
			$(this).attr('src', '../wp-content/themes/ultimateazon/uat-dashboard/uat-options/img/activeon.png');
			$(this).prev().attr('value', 'on');
			// fades IN row on product options page
			$(this).closest('#main-product-custom-specs tbody tr').removeClass('inactive-spec');
		}
        return false;
    });


	// shows help tips image popup in options panels
    $('body').on('click', 'span.help-popup-img i.fa', function() {
    	help_img=$(this).closest('.help-popup-img').attr('data-img');
    	help_title=$(this).closest('.help-popup-img').attr('data-title');
    	help_div=$(this).closest('.help-popup-img').attr('data-section');
		help_container = $('#'+help_div);
		help_container.addClass('help-img-open');
    	help_container.html('<img src="'+help_img+'" alt="" /><p class="help-caption">'+help_title+'</p>');
    	help_container.fadeIn('fast');
    });


    // shows help tips image popup in options panels
    $('body').on('click', 'span.help-popup-txt i.fa', function() {
    	help_div=$(this).closest('.help-popup-txt').attr('data-section');
		help_container = $('#'+help_div);
    	help_container.fadeIn('fast');
    });



    // hides help tips image popup in options panels
    $('body').on('click', '.help-section', function() {
		$(this).fadeOut('fast', function() {
			$(this).removeClass('help-img-open');
			$(this).html('');
		});
		
    });


    // font preview - font-family
    $('.font-option-family').on( 'change', function() {
        var font_css = $(this).find(':selected').attr("data-font-css");
        var preview_id = $(this).attr("data-font-preview");
        //alert(preview_id);
        $('#'+preview_id).attr("style", "font-family: "+font_css );
    });

    // font preview - font-size
    $('.font-option-size').on( 'change', function() {
        var font_size = $(this).find(':selected').attr("data-font-size");
        var preview_id = $(this).attr("data-font-preview");
        $('#'+preview_id+' span').attr("style", "font-size: "+font_size+';' );
    });
    
/*
    // confirm before deleting all user preset themes
	$('body').on('click', '#uat_reset_user_preset', function() {
		if(!confirm('WARNING: This action will delete all of your own custom color schemes that you have saved.')) { 
			event.preventDefault();
		}
    });

*/

});   

