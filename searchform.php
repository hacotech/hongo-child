<?php
/**
 * Template for displaying search forms
 *
 * @package Hongo
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

	$hongo_unique_id = esc_attr( uniqid( 'search-form-' ) );
	$hongo_search_placeholder_text = apply_filters( 'hongo_search_placeholder_text', __( 'جستجو کنید...', 'hongo' ) );
	
?>
<form role="search" method="get" class="navbar-form no-padding search-box alt-font" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group add-on">
		<input class="form-control" id="<?php echo esc_attr( $hongo_unique_id );?>" placeholder="<?php echo esc_attr( $hongo_search_placeholder_text ); ?>" name="s" value="<?php echo get_search_query(); ?>" type="text" autocomplete="off">
		<div class="input-group-btn">
			<button class="btn btn-default" type="submit"><i class="icon-magnifier icons"></i></button>
		</div>
	</div>
</form>