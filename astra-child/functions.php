<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

/////////////////////////////////////////////////////////////////////////////////////////
/*
    Create Custom Taxonomies
*/
function create_mainprod_taxonomies() {

    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Product Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Product Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Product Categories' ),
        'all_items'         => __( 'All Product Categories' ),
        'parent_item'       => __( 'Parent Product Category' ),
        'parent_item_colon' => __( 'Parent Product Category:' ),
        'edit_item'         => __( 'Edit Product Category' ),
        'update_item'       => __( 'Update Product Category' ),
        'add_new_item'      => __( 'Add New Product Category' ),
        'new_item_name'     => __( 'New Product Category' ),
        'menu_name'         => __( 'Product Category' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'product-category' ),
    );

    register_taxonomy( 'product-category', array( 'main_product' ), $args );

}
add_action( 'init', 'create_mainprod_taxonomies', 0 );

/*
    Main Product - Custom Post Type Settings
*/
function create_main_product() {
    
    // sets main product slug to main product plural field
    $uat_options_products = get_option('uat_options_product');
    if ( $uat_options_products['uat_main_product_plural_name'] != '' ) {
        $main_product_rewrite_slug = $uat_options_products['uat_main_product_plural_name'];
        // sanitizes and cleans up the slug
        $main_product_rewrite_slug = sanitize_title($main_product_rewrite_slug);
    }
    else {
        $main_product_rewrite_slug = "main_product";
    }

    if ( $uat_options_products['uat_main_product_singular_name'] != '' && $uat_options_products['uat_main_product_plural_name'] != '' ) {
        $plural_name = $uat_options_products['uat_main_product_plural_name'];
        $singular_name = $uat_options_products['uat_main_product_singular_name'];
    }
    else {
        $plural_name = __('Main Products','ultimateazon');
        $singular_name = __('Main Product','ultimateazon');
    }

    register_post_type( 'main_product',
        array(
            'labels' => array(
                'name' => $plural_name,
                'singular_name' => $singular_name,
                'add_new' => __('Add New','ultimateazon'),
                'add_new_item' => __('Add New','ultimateazon').' '.$singular_name,
                'edit' => __('Edit','ultimateazon'),
                'edit_item' => __('Edit','ultimateazon').' '.$singular_name,
                'new_item' => __('New','ultimateazon').' '.$singular_name,
                'view' => __('View','ultimateazon'),
                'view_item' => __('View','ultimateazon').' '.$singular_name,
                'search_items' => __('Search','ultimateazon').' '.$plural_name,
                'not_found' => __('No','ultimateazon').' '.$plural_name.__('found','ultimateazon'),
                'not_found_in_trash' => __('No','ultimateazon').' '.$plural_name.' '.__('found in Trash','ultimateazon'),
                'parent' => __('Parent','ultimateazon').' '.$singular_name
            ),

            'public' => true,
            'show_in_menu' => true,
            'menu_position' => 7,
            'rewrite' => array( 'slug' => $main_product_rewrite_slug ),
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
            'taxonomies' => array( '' ),
            'menu_icon' => 'https://www.osmowaterfilters.com/wp-content/uploads/2021/04/main-prod-icon.png',
            'has_archive' => true
        )
    );
}
add_action( 'init', 'create_main_product' );


////////////////////////////////////////////////////////
// sets up custom product specs on main product page
function uat_main_product_create() {
 
    add_meta_box(
        'uat_affiliate_link_bars', 
        'Affiliate Link Bars', 
        'uat_affiliate_link_bars_function', 
        'main_product', 
        'normal', 
        'high'
    );

    add_meta_box(
        'uat_product_specs', 
        'Custom Product Specifications', 
        'uat_main_product_specs_function', 
        'main_product', 
        'normal', 
        'high'
    );

    add_meta_box(
        'uat_product-image', 
        'Main Product Image', 
        'uat_main_product_image_function', 
        'main_product', 
        'normal', 
        'high'
    );

}
add_action('add_meta_boxes', 'uat_main_product_create');

function admin_tips($admin_tip_location) {

	switch ($admin_tip_location) {
		
	  case "home_page_title":
	    _e('Add your search engine optimized h1 tag for the home page here. This heading is displayed on your homepage. A great place to use one of your main key phrases. Try using it within a longer phrase that reads naturally and catches your visitor\'s attention.','ultimateazon');
	    break;

	    case "home_page_intro":
	    	 _e('This is your first block of text on your homepage. It will show above the fold and is a great place to let your visitor know how you are going to help them solve a problem, alleviate a stress, make an informed buying decision, etc... Make sure to include your main key phrase somewhere in this area.','ultimateazon');
	    	break;

	    case "top_selling_products":
	    	 _e('Add products to the homepage "Top Products" slider or sortable table. The statistics you checked above will be automatically populated on the front end.','ultimateazon');
	  		break;

	  	case "top_selling_products_toggle":
	    	 _e('Choose wether you want to display a top products slider, sortable table, or nothing on the homepage right under the site intro.','ultimateazon');
	  		break;

	  	case "home_page_main_content":
	    	 _e('This is your main content editor for the homepage. Put the bulk of your homepage content here. It\'s recommended to have over 1000 words here and is the perfect place for a buying guide or any other content related to your general topic.','ultimateazon');
	  		break;

	  	case "prod_img_toggle":
	    	 _e('Choose wether you want the main product image to be zoomable, link to the product affiliate link, or do nothing.','ultimateazon');
	  		break;


	  		

	  default:
	     _e('No tips for this field.','ultimateazon');

	}

}

// custom product specs fields
function uat_affiliate_link_bars_function($post) {

    // Add an nonce field so we can check for it later when validating
    wp_nonce_field( 'main_product_link_bars_custom_box', 'main_product_link_bars_custom_box_nonce' );

    $amatheme_options = get_option( 'uat_options_product' );

    $top_link_bar_toggle_1 = get_post_meta( $post->ID, '_top_link_bar_toggle_1', true );
    $top_link_bar_toggle_2 = get_post_meta( $post->ID, '_top_link_bar_toggle_2', true );
    $link_bar_title_1 = get_post_meta( $post->ID, '_link_bar_title_1', true );
    $link_bar_title_2 = get_post_meta( $post->ID, '_link_bar_title_2', true );

    if ($top_link_bar_toggle_1==''):
        $top_link_bar_toggle_1=on;
    endif;

    if ($top_link_bar_toggle_2==''):
        $top_link_bar_toggle_2=on;
    endif;
?>

    <p class="admin-tips"><?php admin_tips('top_link_bar_toggle_1'); ?></p>

    <input type="hidden" id="top_link_bar_toggle_1" class="toggle-field" name="top_link_bar_toggle_1" value="<?php echo $top_link_bar_toggle_1; ?>" />
     
    <img class="toggle-check <?php echo $top_link_bar_toggle_1; ?>" src="<?php echo 'https://www.osmowaterfilters.com/wp-content/uploads/2021/04/active' . $top_link_bar_toggle_1 . '.png'; ?>" alt="" /><label>Turn On/Off Top Affiliate Link Bar</label>
    <br />
    <br />
     <div class="amatheme-metabox">
        <label>Top Affiliate Link Bar Text</label>
        <input class="full-width_input" type="text" name="link_bar_title_1" value="<?php echo esc_attr($link_bar_title_1); ?>" />
    </div>
    <br />
    <br />

    <p class="admin-tips"><?php admin_tips('top_link_bar_toggle_2'); ?></p>

    <input type="hidden" id="top_link_bar_toggle_2" class="toggle-field" name="top_link_bar_toggle_2" value="<?php echo $top_link_bar_toggle_2; ?>" />
     
    <img class="toggle-check <?php echo $top_link_bar_toggle_2; ?>" src="<?php echo 'https://www.osmowaterfilters.com/wp-content/uploads/2021/04/active' . $top_link_bar_toggle_2 . '.png'; ?>" alt="" /><label>Turn On/Off Bottom Affiliate Link Bar</label>
    <br />
    <br />
    <div class="amatheme-metabox">
        <label>Bottom Affiliate Link Bar Text</label>
        <input class="full-width_input" type="text" name="link_bar_title_2" value="<?php echo esc_attr($link_bar_title_2); ?>" />
    </div>
    <br />

    <?php

}

////////////// save custom product specs fields meta data
function uat_affiliate_link_bars_save_data($post_id) {
 
    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */
 
    // Check if our nonce is set.
    if ( ! isset( $_POST['main_product_link_bars_custom_box_nonce'] ) )
        return $post_id;
 
    $nonce = $_POST['main_product_link_bars_custom_box_nonce'];
 
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'main_product_link_bars_custom_box' ) )
        return $post_id;
 
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
 
    // Check the user's permissions.
    if ( 'main_product' == $_POST['post_type'] ) {
 
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } else {
 
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
    }
 
    /* OK, its safe for us to save the data now. */

    $old_top_link_bar_toggle_1 = get_post_meta( $post->ID, '_top_link_bar_toggle_1', true );
    $old_top_link_bar_toggle_2 = get_post_meta( $post->ID, '_top_link_bar_toggle_2', true );
    $old_link_bar_title_1 = get_post_meta( $post->ID, '_link_bar_title_1', true );
    $old_link_bar_title_2 = get_post_meta( $post->ID, '_link_bar_title_2', true );

    $user_top_link_bar_toggle_1 = sanitize_text_field( $_POST['top_link_bar_toggle_1'] );
    $user_top_link_bar_toggle_2 = sanitize_text_field( $_POST['top_link_bar_toggle_2'] );
    $user_link_bar_title_1 = sanitize_text_field( $_POST['link_bar_title_1'] );
    $user_link_bar_title_2 = sanitize_text_field( $_POST['link_bar_title_2'] );

    update_post_meta( $post_id, '_top_link_bar_toggle_1', $user_top_link_bar_toggle_1, $old_top_link_bar_toggle_1 );
    update_post_meta( $post_id, '_top_link_bar_toggle_2', $user_top_link_bar_toggle_2, $old_top_link_bar_toggle_2 );
    update_post_meta( $post_id, '_link_bar_title_1', $user_link_bar_title_1, $old_link_bar_title_1 );
    update_post_meta( $post_id, '_link_bar_title_2', $user_link_bar_title_2, $old_link_bar_title_2 );


}
add_action( 'save_post', 'uat_affiliate_link_bars_save_data' );





// custom product specs fields
function uat_main_product_specs_function($post) {
 
    // Add an nonce field so we can check for it later when validating
    wp_nonce_field( 'main_product_inner_custom_box', 'main_product_inner_custom_box_nonce' );

    // get our custom specs values from the post meta field
    $current_specs = unserialize(get_post_meta( $post->ID, '_uat_ama_specs', true ));

    //echo '$current_specs: <pre>'; print_r( $current_specs ); echo '</pre>';

    if (is_array($current_specs)) {

    	foreach($current_specs as $key => $subarray) {
    		foreach($subarray as $subkey => $subsubarray) {

    			if($subkey=='spec_value'):
    				$current_specs[$key][$subkey] = htmlspecialchars(stripslashes(base64_decode($subsubarray)));
    			else: 
    				$current_specs[$key][$subkey] = htmlspecialchars(stripslashes($subsubarray));
    			endif;
    		}
    	}

    }

	//echo '$current_specs_decoded: <pre>'; print_r( $current_specs ); echo '</pre>';
	//die;

    if(is_array($current_specs) && !empty($current_specs)):
        foreach ($current_specs as $field => $spec_meta_key) {
            $spec_value =  stripslashes($spec_meta_key['spec_value']);
        }
    endif;

    // get our custom specs fields from the products options page
    $temp_specs = get_option( 'uat_options_product' );
    $_temp_specs = $temp_specs['uat_main_product_custom_specs'];
    //print_r( $temp_specs['uat_main_product_custom_specs']);

    if(!is_array($_temp_specs)) {
        $custom_options = unserialize($_temp_specs);
    } else {
        $custom_options = $_temp_specs;
    }

    //print_r($custom_options);

    $_groupings = $custom_options;
    $groupings = array();

    if (is_array($_groupings)) {
        foreach ($_groupings as $field => $group) {
            for ($i=0; $i<count($group); $i++) {
                $groupings[$i][$field] = $group[$i];
            }
        }
    }

    echo '<div>';

    if ( is_plugin_active( 'easyazon/easyazon.php' ) ) {
        echo '<p>If you are using the Easy Azon WordPress Plugin along with this theme, you must create your product affiliate link in the editor above and insert the shortcode there, then copy and paste the shortcode into the "Product Affiliate Link" field below. Only the plain text link created by Easy Azon will work here. The advanced links are for in your content editors only.</p><p><strong>NOTE*</strong>If using the EasyAzon shortcode, do not click upload. Simply paste your shortcode in the field and it will get uploaded upon saving your review.</p>';
    } 

    echo '<table>';

    foreach ($groupings as $field => $grouping) {

        if($grouping['uat_ama_spec_toggle'] == 'off'):
            $hide_show = ' inactive-spec';
        else: 
            $hide_show = '';
        endif;

        echo '<tr class="row'.$hide_show.'">';
        $spec_value = '';

        foreach ($grouping as $value_name => $value){

            if($value_name == 'uat_ama_spec_meta_key'):
                echo '<td class="meta_key_holder">';
                echo '<input type="hidden" name="uat_ama_specs[spec_meta_key][]" value="'.$value.'">';
                echo '</td>';
                if(is_array($current_specs) && !empty($current_specs)):
                    foreach ($current_specs as $field => $spec_meta_key) {
                        //echo $field.' => '.$spec_meta_key['spec_meta_key'].'<br />';
                        if($spec_meta_key['spec_meta_key'] == $grouping['uat_ama_spec_meta_key']){
                            $spec_value =  $spec_meta_key['spec_value'];
                        }
                    }
                endif;
            elseif($value_name == 'uat_ama_spec_name'):
                echo '<th class="spec-name">'.$value.'</th>';
                echo '<td>';
                    if($value=='Rating'):
                        echo '<select name="uat_ama_specs[spec_value][]">';
                            echo '<option '.selected( $spec_value, '', false).' value="">- select -</option>';
                            echo '<option '.selected( $spec_value, 1, false).' value="1">1</option>';
                            echo '<option '.selected( $spec_value, 1.5, false).' value="1.5">1.5</option>';
                            echo '<option '.selected( $spec_value, 2, false).' value="2">2</option>';
                            echo '<option '.selected( $spec_value, 2.5, false).' value="2.5">2.5</option>';
                            echo '<option '.selected( $spec_value, 3, false).' value="3">3</option>';
                            echo '<option '.selected( $spec_value, 3.5, false).' value="3.5">3.5</option>';
                            echo '<option '.selected( $spec_value, 4, false).' value="4">4</option>';
                            echo '<option '.selected( $spec_value, 4.5, false).' value="4.5">4.5</option>';
                            echo '<option '.selected( $spec_value, 5, false).' value="5">5</option>';

                        echo '</select>';
                    else:
                        echo '<input type="text" name="uat_ama_specs[spec_value][]" value="'.$spec_value.'">';
                    endif;

                echo '</td>';
            endif;
        }
        echo '</tr>';
     }
    echo '</table></div>';
}

////////////// save custom product specs fields meta data
function uat_main_product_save_data($post_id) {
 
    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */
 
    // Check if our nonce is set.
    if ( ! isset( $_POST['main_product_inner_custom_box_nonce'] ) )
        return $post_id;
 
    $nonce = $_POST['main_product_inner_custom_box_nonce'];
 
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'main_product_inner_custom_box' ) )
        return $post_id;
 
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
 
    // Check the user's permissions.
    if ( 'main_product' == $_POST['post_type'] ) {
 
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } else {
 
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
    }
 
    /* OK, its safe for us to save the data now. */

    // store old custom spec values if they exist in array
    $old_user_specs_serialized =  get_post_meta( $post_id, '_uat_ama_specs', true );

    $_groupings = $_POST['uat_ama_specs'];

    $groupings = array();

    if (is_array($_groupings)) {
        foreach ($_groupings as $field => $group) {
            for ($i=0; $i<count($group); $i++) {

                $escaped_value = $group[$i];

                // we only need to encode the spec values, not the meta keys
                if($field!='spec_meta_key'):
	                $groupings[$i][$field] = base64_encode($escaped_value);
	            else:
	            	$groupings[$i][$field] = $escaped_value;
	            endif;

            }
        }
    }

    $user_specs_serialized = serialize($groupings);
    update_post_meta( $post_id, '_uat_ama_specs', $user_specs_serialized, $old_user_specs_serialized );

}
add_action( 'save_post', 'uat_main_product_save_data' );





function uat_main_product_image_function($post) { 
    
    //retrieve the metadata values if they exist
    $main_product_img = get_post_meta( $post->ID, '_main_product_img', true );
    $get_image_toggle = get_post_meta( $post->ID, '_prod_img_toggle', true );
    ?>

    <?php 

    $image= esc_attr($main_product_img);

    if($image==''):
        $image_url_string = get_site_url().'/wp-content/themes/ultimateazon/images/no-product-image.gif';
    else:
        $size = 'medium';
        $image_src=wp_get_attachment_image_src( $image, $size );
        $image_url_string = $image_src[0];
    endif;

    if ( $image_url_string == '/wp-content/themes/ultimateazon/images/no-product-image.gif') {$hideshow='style="display: none"';} else {$hideshow='style="display: inline-block"';}

    ?>

    <p class="admin-tip"><?php _e('Upload your main product image here. Upload a large image, ideally a square image that is between 700px and 1000px wide and high. All sizes required by this theme will be automatically created upon upload.', 'amatheme-options' ); ?></p>

    <br />

    <?php

    $easyazon_check = 'hidden';

    if ( is_plugin_active( 'easyazon/easyazon.php' ) ) {

        echo '<p>To add your main product image using the easyAzon Image shortcode, first add the shortcode for the image you would like to use in the editor above, then copy and paste the shortcode into this box instead of uploading an image. Make sure to use the largest image size available when creating the shortcode with EasyAzon.</p>';

        $easyazon_check = 'text';

    }

    ?>

    <!-- change type back to text to see img path -->
    <input type="<?php echo $easyazon_check; ?>" id="main_product_img" name="main_product_img" value="<?php echo esc_attr($main_product_img); ?>" />
    <input id="upload_main_prod_image" type="button" class="button" value="<?php _e( 'Upload Main Product Image', 'amatheme' ); ?>" />

    <input id="delete_main_product_image" name="delete_main_product_image" type="submit" class="button" <?php echo $hideshow; ?> value="<?php _e( 'Delete Image', 'amatheme' ); ?>" />

    <div id="upload_mainproduct_preview">

        <?php if ( $image_url_string == '/wp-content/themes/ultimateazon/images/no-product-image.gif') {$hideshow='style="display: inline-block"';} else {$hideshow='style="display: none"';} ?>
        
        <?php if($image_url_string != '') : ?>
            <span class="default-logo-txt" <?php echo $hideshow; ?>><br />(default product image, upload your own!)</span><br />
            <img src="<?php echo $image_url_string; ?>" alt="" />
        <?php endif; ?>

    </div>

    <p class="admin-tip"><?php admin_tips('prod_img_toggle'); ?></p>

    <span>
        <input type="radio" name="prod_img_toggle" value="zoom" <?php if ( isset ( $get_image_toggle ) ) checked( $get_image_toggle, 'zoom' ); ?>>Enable Image Zoom
    </span>
    <span>
        <input type="radio" name="prod_img_toggle" value="aff-link" <?php if ( isset ( $get_image_toggle ) ) checked( $get_image_toggle, 'aff-link' ); ?>>Enable Affiliate Link
    </span>
    <span>
        <input type="radio" name="prod_img_toggle" value="none" <?php if ( isset ( $get_image_toggle ) ) checked( $get_image_toggle, 'none' ); ?>>Image Does Nothing
    </span>

<?php
}


////////////// save custom product specs fields meta data
function uat_main_product_save_image($post_id) {
    // Check if our nonce is set.
    if ( ! isset( $_POST['main_product_inner_custom_box_nonce'] ) )
        return $post_id;
 
    $nonce = $_POST['main_product_inner_custom_box_nonce'];
 
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'main_product_inner_custom_box' ) )
        return $post_id;
 
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
 
    // Check the user's permissions.
    if ( 'main_product' == $_POST['post_type'] ) {
 
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } else {
 
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
    }
 
    /* OK, its safe for us to save the data now. */

    // If old entries exist, retrieve them
    $old_image = get_post_meta( $post_id, '_main_product_img', true );

 
    // Sanitize user input.
    $image = sanitize_text_field( $_POST['main_product_img'] );

    //echo $image;

    if (0 === strpos($image, '[easyazon_image')) :
        $image_url = stripslashes(htmlspecialchars_decode($image));

        //echo '<br /><br /><br />';

        // echo $image_url;

        $count = preg_match('/src=(["\'])(.*?)\1/', $image_url, $match);

        if ($count === FALSE) { $image = $old_image; echo '<br /><br /><br />old image: '.$image;}
        else {
            $image = add_media_from_url($match[2], $post_id);
            //echo '<br /><br /><br />new image ID: '.$image;
        }

    endif;

    // Update the meta field in the database.
    update_post_meta( $post_id, '_main_product_img', $image, $old_image );

    $user_image_toggle =  $_POST['prod_img_toggle'];
    $old_image_toggle =  get_post_meta( $post_id, '_prod_img_toggle', true );


    if( isset( $_POST[ 'prod_img_toggle' ] ) ) {
        update_post_meta( $post_id, '_prod_img_toggle',$user_image_toggle, $old_image_toggle );
    }

}
add_action( 'save_post', 'uat_main_product_save_image' );




/**
 * Register and enqueue a custom scripts in the WordPress admin.
 */
function uat_enqueue_custom_admin_style() {
	global $post_type;
	if( 'main_product' == $post_type ) {

		wp_enqueue_style( 'uat-styles', get_stylesheet_directory_uri() . '/assets/admin/uat-styles.css', array(), ASTRA_THEME_VERSION );
		wp_enqueue_script( 'uat-script-global', get_stylesheet_directory_uri() . '/assets/admin/uat-options-global.js', array(), ASTRA_THEME_VERSION );
		wp_enqueue_script( 'uat-script-main-product', get_stylesheet_directory_uri() . '/assets/admin/uat-main-product.js', array(), ASTRA_THEME_VERSION );
	}
}
add_action( 'admin_enqueue_scripts', 'uat_enqueue_custom_admin_style' );




/**
 * Register and enqueue custom scripts on the Front Page.
 */
function uat_add_theme_scripts() {

	global $post_type;
	if( 'main_product' == $post_type ) {
		
		wp_enqueue_style( 'style-jqzoom', get_stylesheet_directory_uri() . '/assets/jqzoom-core.css', array(), ASTRA_THEME_VERSION . time() );
		wp_enqueue_script( 'script-jqzoom', get_stylesheet_directory_uri() . '/assets/jquery.jqzoom-core.js', array( 'jquery' ), ASTRA_THEME_VERSION . time() );
		wp_enqueue_script( 'script-public', get_stylesheet_directory_uri() . '/assets/public.js', array( 'script-jqzoom' ), ASTRA_THEME_VERSION . time() );
		wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/assets/font-awesome-4.1.0/css/font-awesome.min.css', array(), ASTRA_THEME_VERSION . time() );
	}
}
add_action( 'wp_enqueue_scripts', 'uat_add_theme_scripts' );