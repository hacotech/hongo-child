<?php

/**
 *
 * [Parent Theme] child theme functions and definitions
 * 
 * @package [Parent Theme]
 * @author  Themezaa <info@themezaa.com>
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
add_theme_support( 'custom-logo' );
//change copyright
function remove_footer_admin () {
    echo "تمام حقوق سایت نزد <a href='https://hacoupianinc.com' target='_blank'>هاکوپیان</a> محفوظ است.";
}
add_filter('admin_footer_text', 'remove_footer_admin');
if ( ! function_exists( 'hongo_child_style' ) ) :
	function hongo_child_style() {
		//wp_enqueue_style('bootstrap5-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css', array(), '5.0.0', 'all');
	    wp_enqueue_style( 'hongo-parent-style', get_template_directory_uri(). '/style.css' );
		wp_enqueue_style( 'hongo-child', get_stylesheet_uri() );
		
		
		wp_dequeue_script( 'jquery' );
        //wp_enqueue_script( 'jquery', 'http://wrank.ir/assets/js/vendor/jquery-1.11.2.min.js', true );
        
		
		//wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', true );
		

        //wp_enqueue_script( 'bootstrap5-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js', array('jquery'), '4.0.0', true );
		wp_enqueue_script( 'bootstrap3-js', get_template_directory_uri(). '/assets/js/bootstrap.min.js', array('jquery'), '3.0.0', true );

	}
endif;
add_action( 'wp_enqueue_scripts', 'hongo_child_style', 11 );





function my_scripts_method() {
    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        array( 'jquery' ),
        true,
        true
    );
}


add_action( 'wp_enqueue_scripts', 'my_scripts_method' );







?>