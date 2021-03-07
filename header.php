<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "header" tag.
 *
 * @package Hongo
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<!-- keywords -->
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<!-- viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<!-- profile -->
		<link rel="profile" href="//gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php
			if ( function_exists( 'wp_body_open' ) ) {
				wp_body_open();
			} else {
				do_action( 'wp_body_open' );
			}
			$hongo_box_layout 			= hongo_option( 'hongo_enable_box_layout', '0' );
			$hongo_enable_header_general= hongo_builder_customize_option( 'hongo_enable_header_general', '1' );
			$hongo_header_layout 		= hongo_builder_option( 'hongo_header_type', 'headertype1', $hongo_enable_header_general );
			$hongo_enable_header 		= hongo_builder_option( 'hongo_enable_header', '1', $hongo_enable_header_general );

			/* Box Layout Start */
			$main_wrapper_class = ( $hongo_box_layout == '1' ) ? 'box-layout' : 'hongo-layout';
		?>
		<div class="<?php echo esc_attr( $main_wrapper_class ) ?>">
			<?php if ( $hongo_header_layout == 'headertype2' && $hongo_enable_header == 1 ) { // Left Menu Style Start ?>
				<!-- Main wrap -->
				<div class="hongo-main-wrap" data-sticky_parent>
					<div class="hongo-overlay"></div>
			<?php } ?>
				<?php get_template_part( 'templates/header/header' ); ?>
				<?php if ( $hongo_header_layout == 'headertype2' ) { // Left Menu Style Content Start ?>
					<!-- Main site content -->
					<div class="hongo-main-site-content" data-sticky_column >
				<?php } ?>
				<?php
					/* Title OR WooCommerce plugin is activated and WooCommerce product page */
					if ( ! is_single() || ( hongo_is_woocommerce_activated() && is_product() ) ) {

						get_template_part( 'templates/title' );
					}
						
						
?>
						
						
						
						
