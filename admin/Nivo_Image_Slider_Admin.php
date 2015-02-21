<?php

class Nivo_Image_Slider_Admin {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register Custom Post Type for Slider
	 */
	public function custom_post_type() {

		$labels = array(
			'name'                => _x( 'Slides', 'Post Type General Name', 'nivoslider' ),
			'singular_name'       => _x( 'Slide', 'Post Type Singular Name', 'nivoslider' ),
			'menu_name'           => __( 'Slider', 'nivoslider' ),
			'parent_item_colon'   => __( 'Parent Slide:', 'nivoslider' ),
			'all_items'           => __( 'All Slides', 'nivoslider' ),
			'view_item'           => __( 'View Slide', 'nivoslider' ),
			'add_new_item'        => __( 'Add New Slide', 'nivoslider' ),
			'add_new'             => __( 'Add New', 'nivoslider' ),
			'edit_item'           => __( 'Edit Slide', 'nivoslider' ),
			'update_item'         => __( 'Update Slide', 'nivoslider' ),
			'search_items'        => __( 'Search Slide', 'nivoslider' ),
			'not_found'           => __( 'Not found', 'nivoslider' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'nivoslider' ),
		);
		$args = array(
			'label'               => __( 'slider', 'nivoslider' ),
			'description'         => __( 'Custom post for Nivo Image Slider', 'nivoslider' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-slides',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => array('slug' => 'slide',),
			'capability_type'     => 'page',
		);
		register_post_type( 'slider', $args );

	}

	public function post_thumbnail_image_box() {
	    remove_meta_box( 'postimagediv', 'slider', 'side' );
	    add_meta_box('postimagediv', __('Upload Slide Image', 'nivoslider'), 'post_thumbnail_meta_box', 'slider', 'normal', 'high');
	}
	// Register Custom Taxonomy
	public function custom_taxonomy() {

	    $labels = array(
	        'name'                       => _x( 'Slide Categories', 'Taxonomy General Name', 'nivoslider' ),
	        'singular_name'              => _x( 'Slide Category', 'Taxonomy Singular Name', 'nivoslider' ),
	        'menu_name'                  => __( 'Portfolio Categories', 'nivoslider' ),
	        'all_items'                  => __( 'All Slide Categories', 'nivoslider' ),
	        'parent_item'                => __( 'Parent Slide Category', 'nivoslider' ),
	        'parent_item_colon'          => __( 'Parent Slide Category:', 'nivoslider' ),
	        'new_item_name'              => __( 'New Slide Category Name', 'nivoslider' ),
	        'add_new_item'               => __( 'Add New Slide Category', 'nivoslider' ),
	        'edit_item'                  => __( 'Edit Slide Category', 'nivoslider' ),
	        'update_item'                => __( 'Update Slide Category', 'nivoslider' ),
	        'separate_items_with_commas' => __( 'Separate Slide Categories with commas', 'nivoslider' ),
	        'search_items'               => __( 'Search Slide Categories', 'nivoslider' ),
	        'add_or_remove_items'        => __( 'Add or remove Slide Categories', 'nivoslider' ),
	        'choose_from_most_used'      => __( 'Choose from the most used Slide Categories', 'nivoslider' ),
	        'not_found'                  => __( 'Not Found', 'nivoslider' ),
	    );
	    $args = array(
	        'labels'                     => $labels,
	        'hierarchical'               => false,
	        'public'                     => true,
	        'show_ui'                    => true,
	        'show_admin_column'          => true,
	        'show_in_nav_menus'          => true,
	        'show_tagcloud'              => true,
	        'rewrite'                    => array( 'slug' => 'slide-category', ),
	    );
	    register_taxonomy( 'slide_category', array( 'slider' ), $args );

	}
	public function add_meta_box() {
	    add_meta_box(
	    	'nivo_image_slider_id', 
	    	__( 'Slide Meta Box','nivoslider' ), 
	    	array( $this, 'nivo_image_slider_meta_box_callback' ), 
	    	'slider' 
	    );
	}
	public function save_meta_box( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['nivo_image_slider_meta_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['nivo_image_slider_meta_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'nivo_image_slider_inner_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$caption = sanitize_text_field( $_POST['nivo_image_slider_caption'] );
		$transition = sanitize_text_field( $_POST['nivo_image_slider_transition'] );

		// Update the meta field.
		update_post_meta( $post_id, '_nivo_image_slider_caption_value', $caption );
		update_post_meta( $post_id, '_nivo_image_slider_transition_value', $transition );
	}
	public function nivo_image_slider_meta_box_callback( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'nivo_image_slider_inner_custom_box', 'nivo_image_slider_meta_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$caption = get_post_meta( $post->ID, '_nivo_image_slider_caption_value', true );
		$transition = get_post_meta( $post->ID, '_nivo_image_slider_transition_value', true );

        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="nivo_image_slider_caption">
                        <?php _e('Slide Caption','nivoslider') ?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" id="nivo_image_slider_caption" name="nivo_image_slider_caption" value="<?php echo esc_attr( $caption ); ?>" style="width:100% !important">
                    <p><?php _e('Write slide caption.','nivoslider'); ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="nivo_image_slider_transition">
                        <?php _e('Slide Transition','nivoslider') ?>
                    </label>
                </th>
                <td>
                    <select name="nivo_image_slider_transition">
                    	<option value="" <?php selected( $transition, '' ); ?>>--- Select ---</option>
                    	<option value="sliceDown" <?php selected( $transition, 'sliceDown' ); ?>>sliceDown</option>
                        <option value="sliceDownLeft" <?php selected( $transition, 'sliceDownLeft' ); ?>>sliceDownLeft</option>
                        <option value="sliceUp" <?php selected( $transition, 'sliceUp' ); ?>>sliceUp</option>
                        <option value="sliceUpLeft" <?php selected( $transition, 'sliceUpLeft' ); ?>>sliceUpLeft</option>
                        <option value="sliceUpDown" <?php selected( $transition, 'sliceUpDown' ); ?>>sliceUpDown</option>
                        <option value="sliceUpDownLeft" <?php selected( $transition, 'sliceUpDownLeft' ); ?>>sliceUpDownLeft</option>
                        <option value="fold" <?php selected( $transition, 'fold' ); ?>>fold</option>
                        <option value="fade" <?php selected( $transition, 'fade' ); ?>>fade</option>
                        <option value="random" <?php selected( $transition, 'random' ); ?>>random</option>
                        <option value="slideInRight" <?php selected( $transition, 'slideInRight' ); ?>>slideInRight</option>
                        <option value="slideInLeft" <?php selected( $transition, 'slideInLeft' ); ?>>slideInLeft</option>
                        <option value="boxRandom" <?php selected( $transition, 'boxRandom' ); ?>>boxRandom</option>
                        <option value="boxRain" <?php selected( $transition, 'boxRain' ); ?>>boxRain</option>
                        <option value="boxRainReverse" <?php selected( $transition, 'boxRainReverse' ); ?>>boxRainReverse</option>
                        <option value="boxRainGrow" <?php selected( $transition, 'boxRainGrow' ); ?>>boxRainGrow</option>
                        <option value="boxRainGrowReverse" <?php selected( $transition, 'boxRainGrowReverse' ); ?>>boxRainGrowReverse</option>
                    </select>
                    <p><?php _e('Select transition for this slide.','nivoslider'); ?></p>
                </td>
            </tr>
        </table>
        <?php
	}

}
