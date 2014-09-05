<?php
/*
 * Plugin Name: Nivo Image Slider
 * Plugin URI: http://wordpress.org/plugins/nivo-image-slider/
 * Description: A WordPress plugin to include image slider into your theme.
 * Version: 1.2.1
 * Author: Sayful Islam
 * Author URI: http://www.sayful.net
 * Text Domain: nivoslider
 * Domain Path: /languages/
 * License: GPL2
*/

/**
 * Load plugin textdomain.
 */
function sis_nivoslider_load_textdomain() {
  load_plugin_textdomain( 'nivoslider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'sis_nivoslider_load_textdomain' );

/* Adding Latest jQuery for Wordpress plugin */
function sis_nivoslider_plugin_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('sis_nivoslider_script',plugins_url( '/js/jquery.nivo.slider.js' , __FILE__ ),array( 'jquery' ));

	wp_enqueue_style('sis_nivoslider_style',plugins_url( '/css/nivo-slider.css' , __FILE__ ));
	//Nivo Theme
	wp_enqueue_style('sis_nivoslider_default',plugins_url( '/themes/default/default.css' , __FILE__ ));
	wp_enqueue_style('sis_nivoslider_light',plugins_url( '/themes/light/light.css' , __FILE__ ));
	wp_enqueue_style('sis_nivoslider_dark',plugins_url( '/themes/dark/dark.css' , __FILE__ ));
	wp_enqueue_style('sis_nivoslider_bar',plugins_url( '/themes/bar/bar.css' , __FILE__ ));
}
add_action('init', 'sis_nivoslider_plugin_scripts');


function sis_nivoslider_activation(){
	?>
    <script type="text/javascript">
    	jQuery(window).load(function() {
        	jQuery('#slider').nivoSlider();
    	});
    </script>
	<?php
}
add_action('wp_footer','sis_nivoslider_activation');

// Register Custom Post Type for Slider
function nivoslider_custom_post_type() {

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
		'description'         => __( 'Post Type Description', 'nivoslider' ),
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

// Hook into the 'init' action
add_action( 'init', 'nivoslider_custom_post_type', 0 );



/**add the shortcode for the slider- for use in editor**/
function sis_insert_nivoslider($atts, $content=null){
    extract(shortcode_atts(array(
        'theme' =>'default',
    ), $atts));  

	$slider= '<div class="slider-wrapper theme-'.$theme.'"><div id="slider" class="nivoSlider">';
	$efs_query= "post_type=slider&posts_per_page=-1";
	query_posts($efs_query);
	if (have_posts()) : while (have_posts()) : the_post();

		$slider_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );	
		$slider.='<img src="'.$slider_image[0].'" data-thumb="'.$slider_image[0].'" alt="" title="'.get_the_title().'" />';		
	endwhile; endif; wp_reset_query();
	$slider.= '</div></div>';
	return $slider;
}
add_shortcode('all-nivoslider', 'sis_insert_nivoslider');

/* Slider for individual image */
function sis_slider_wrapper_shortcode( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'theme' =>'default',
        'id' =>'sisnivoslider',
    ), $atts));    
    return '<div class="slider-wrapper theme-'.$theme.'"><div id="'.$id.'" class="nivoSlider">'.do_shortcode($content).'</div></div><script type="text/javascript">jQuery(window).load(function(){jQuery("#'.$id.'").nivoSlider()});</script>';
}
add_shortcode( 'nivo-slider', 'sis_slider_wrapper_shortcode' );
 
function sis_slide_shortcode( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'image_link' =>'',
        'caption' =>'',
        'alt' =>'',
    ), $atts));  
    return '<img src="'.$image_link.'" data-thumb="'.$image_link.'" alt="'.$alt.'" title="'.$caption.'" />';
}
add_shortcode( 'nivoslides', 'sis_slide_shortcode' );