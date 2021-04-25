<?php
/**
 * Template for Single post
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2020, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.0
 */

?>

<div <?php astra_blog_layout_class( 'single-layout-1' ); ?>>

	<?php astra_single_header_before(); ?>

	<header class="entry-header <?php astra_entry_header_class(); ?>">

		<?php astra_single_header_top(); ?>

		<?php astra_blog_post_thumbnail_and_title_order(); ?>

		<?php astra_single_header_bottom(); ?>

	</header><!-- .entry-header -->

	<?php astra_single_header_after(); ?>

  	<?php
  	if ( 'main_product' == get_post_type() ) {

		add_theme_support('post-thumbnails');
		add_image_size('product-large', 1000, 1000, false); // Large Thumbnail
		add_image_size('product-medium', 300, 300, false); // Medium Thumbnail
		
        $main_prod_image = get_post_meta( $post->ID, '_main_product_img', true );
        $image= esc_attr($main_prod_image);
        $size = 'small';
		$size_2 = 'product-large';
		$size_3 = 'product-medium';
        $image_src_sm=wp_get_attachment_image_src( $image, $size );
		$image_src_md=wp_get_attachment_image_src( $image, $size_3 );
		$image_src_lg=wp_get_attachment_image_src( $image, $size_2 );

		
		?>
		<div id="review-magnifier">
			<a href="<?php echo $image_src_lg[0]; ?>" class="magnify" title="<?php echo $product_name; ?>">
				<img class="main-img-single-review" src="<?php echo $image_src_md[0]; ?>" alt="<?php the_title(); ?>" />
			</a>
			<span class="mobile-hide zoom-tip"><?php _e('(hover to zoom)','ultimateazon'); ?></span>
			<span class="mobile-show zoom-tip"><?php _e('(tap once to zoom, tap left, right, top, bottom to move image, tap outside of image to cancel)','ultimateazon'); ?></span>
		</div>
		<?php
		
		
		
		/////////////////////////////////////////////////////// 
		// get our custom specs values from the post meta field
		$current_specs = unserialize(get_post_meta( $post->ID, '_uat_ama_specs', true ));
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

		$temp_specs = get_option( 'uat_options_product' );
		$_temp_specs = $temp_specs['uat_main_product_custom_specs'];
		$custom_options = unserialize($_temp_specs);
		$_groupings = $custom_options;

		$groupings = array();
		if (is_array($_groupings)) {
			foreach ($_groupings as $field => $group) {
				for ($i=0; $i<count($group); $i++) {
					$groupings[$i][$field] = $group[$i];
				}
			}
		}

		echo '<div class="single-main-product-table"><table>';
		$spec_value_counter = 0;
		foreach ($groupings as $field => $grouping) {

			$spec_value = '';

			foreach ($grouping as $value_name => $value){

				if($value_name == 'uat_ama_spec_meta_key'):

					if (is_array($current_specs)):

					foreach ($current_specs as $field => $spec_meta_key) {

						if($spec_meta_key['spec_meta_key'] == $grouping['uat_ama_spec_meta_key']){
							$spec_value =  $spec_meta_key['spec_value'];
						}
					}

					endif;

				endif;

			if('uat_ama_spec_name' === $value_name):
				echo '<tr>';
				echo '<th>' . $value . '</th>';
			endif;
				
			} // End foreach loop for $value

			if ( 3 === $spec_value_counter ) {
				echo '<td>';
				switch ($spec_value) {
					case '1':
						echo '<i class="fa fa-star"></i>';
						break;
					case '1.5':
						echo '<i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i>';
						break;
					case '2':
						echo '<i class="fa fa-star"></i> <i class="fa fa-star"></i>';
						break;
					case '2.5':
						echo '<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i>';
						break;
					case '3':
						echo '<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>';
						break;
					case '3.5':
						echo '<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i>';
						break;
					case '4':
						echo '<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>';
						break;
					case '4.5':
						echo '<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i>';
						break;
					case '5':
						echo '<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>';
						break;
				}
				echo '</td>';
			} else {
				echo '<td>' . $spec_value . '</td>';
			}
			$spec_value_counter++;
			
			echo '</tr>';
			
		}
		echo '</table></div>';
		///////////////////////////////////////////////////////
		// Link Bar Title One
		$main_product_link_top_text = get_post_meta( $post->ID, '_link_bar_title_1', true );
		echo '<a class="main-product-link-top-text" href="' . $current_specs[0]['spec_value'] . '">' . $main_product_link_top_text . '</a>';

		
		
    }
  	?>
  
	<div class="entry-content clear" 
	<?php
				echo astra_attr(
					'article-entry-content-single-layout',
					array(
						'class' => '',
					)
				);
				?>
	>

		<?php astra_entry_content_before(); ?>

		<?php the_content(); ?>

		<?php
			astra_edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'astra' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>

		<?php astra_entry_content_after(); ?>

		<?php
			wp_link_pages(
				array(
					'before'      => '<div class="page-links">' . esc_html( astra_default_strings( 'string-single-page-links-before', false ) ),
					'after'       => '</div>',
					'link_before' => '<span class="page-link">',
					'link_after'  => '</span>',
				)
			);
			?>
	</div><!-- .entry-content .clear -->
	<?php 
	///////////////////////////////////////////////////////
	// Link Bar Title Two
	$main_product_link_bottom_text = get_post_meta( $post->ID, '_link_bar_title_2', true );
	echo '<a class="main-product-link-bottom-text" href="' . $current_specs[0]['spec_value'] . '">' . $main_product_link_bottom_text . '</a>';
	?>
</div>
