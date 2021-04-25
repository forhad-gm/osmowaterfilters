/* used for the media uploader on the main options page */
jQuery(document).ready(function($) {
    
    
    var mainproduct_media_file_frame;

    $('#upload_main_prod_image').on( 'click', function(e) {
        e.preventDefault();
        if ( mainproduct_media_file_frame ) {
            mainproduct_media_file_frame.open();
            return;
        }

        // Create media frame using data elements from the clicked element
        mainproduct_media_file_frame = wp.media.frames.file_frame = wp.media( {
            title: 'Choose Your Product\'s Featured Image',
            button: { text: 'Use This Image!' },
            class: $(this).attr('id')
        } );

        // What to do when the image is selected
        mainproduct_media_file_frame.on( 'select', function() {
            var attachment = mainproduct_media_file_frame.state().get('selection').first().toJSON();

            $( '#upload_mainproduct_preview img' ).attr( 'src', attachment.url ).css( 'display', 'block' );


            // put the image url where we can get it
            $('#main_product_img').attr( 'value', attachment.id );

            $( '#delete_logo_button' ).css( 'display', 'inline-block' );
            $( '.default-logo-txt').css( 'display', 'none' );
        } );
        // Open the modal
        mainproduct_media_file_frame.open();
    } );

    // Attach the remove button to our functionality
    $( '#delete_main_product_image' ).on( 'click', function(e) {
        e.preventDefault();
        $(this).css( 'display', 'none' );
        $( '#main_product_img' ).attr( 'value', '' );
        $( '#upload_mainproduct_preview img' ).attr( 'src', '../wp-content/themes/ultimateazon/images/no-product-image.gif' );
        $( '.default-logo-txt').css( 'display', 'block' );
    } );



});  