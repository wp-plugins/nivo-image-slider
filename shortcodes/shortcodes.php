<?php

/**add the shortcode for the slider- for use in editor**/
if( ! function_exists('all_nivo_image_slider' ) ) :

function all_nivo_image_slider($atts, $content=null){
    global $post;

    extract(shortcode_atts(array(
        'id'            =>'',
        'theme'         =>'default',
        'category_slug' =>'',
    ), $atts));


    if (trim($category_slug) !='') {

        $termname = $category_slug;

    } else {
    	function all_terms(){
    		// It is blank
    	}
        $termname = all_terms();
    }

	$slider= '<div class="slider-wrapper theme-'.$theme.'"><div id="slider'.$id.'" class="nivoSlider">';
	$efs_query= "post_type=slider&posts_per_page=-1&slide_category=$termname";
	query_posts($efs_query);
	if (have_posts()) : while (have_posts()) : the_post();

        $caption = get_post_meta( $post->ID, '_nivo_image_slider_caption_value', true );
        $transition = get_post_meta( $post->ID, '_nivo_image_slider_transition_value', true );
        
		$slider_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

		$slider.='<img src="'.$slider_image[0].'" data-thumb="'.$slider_image[0].'" alt="" title="'.esc_textarea( $caption ).'" data-transition="'.$transition.'">';

	endwhile; endif; wp_reset_query();
	$slider.= '</div></div>';
	$slider.= '<script>jQuery(window).load(function($){jQuery("#slider'.$id.'").nivoSlider();});</script>';
	return $slider;
}
endif;

add_shortcode('all-nivoslider', 'all_nivo_image_slider');

/* Slider for individual image */
if( ! function_exists('sis_slider_wrapper_shortcode' ) ) :

function sis_slider_wrapper_shortcode( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'theme' =>'default',
        'id' =>'sisnivoslider',
    ), $atts));    
    return '<div class="slider-wrapper theme-'.$theme.'"><div id="'.$id.'" class="nivoSlider">'.do_shortcode($content).'</div></div><script type="text/javascript">jQuery(window).load(function(){jQuery("#'.$id.'").nivoSlider()});</script>';
}
endif;

add_shortcode( 'nivo-slider', 'sis_slider_wrapper_shortcode' );
 

if( ! function_exists('sis_slide_shortcode' ) ) :

function sis_slide_shortcode( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'image_link' =>'',
        'caption' =>'',
        'alt' =>'',
    ), $atts));  
    return '<img src="'.$image_link.'" data-thumb="'.$image_link.'" alt="'.$alt.'" title="'.$caption.'" />';
}
endif;

add_shortcode( 'nivoslides', 'sis_slide_shortcode' );