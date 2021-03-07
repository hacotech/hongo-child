<?php
/*
	==========================================
	 Custom Post Type
	==========================================
*/
function awesome_custom_post_type (){
	
	$labels = array(
		'name' => 'محصولات',
		'singular_name' => 'محصول',
		'add_new' => 'اضافه کردن محصول',
		'all_items' => 'همه محصولات',
		'add_new_item' => 'اضافه کردن محصول',
		'edit_item' => 'ویرایش محصول',
		'new_item' => 'اضافه کردن محصول',
		'view_item' => 'مشاهده محصول',
		'search_item' => 'جستجو محصول',
		'not_found' => 'محصولی یافت نشد',
		'not_found_in_trash' => 'محصولی در زباله دان یافت نشد',
		'parent_item_colon' => 'محصول والد'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'page',
		'hierarchical' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'revisions',
			'author',
			'page-attributes',
		),
		//'taxonomies' => array('category', 'post_tag'),
		'menu_position' => 5,
		'exclude_from_search' => false
	);
	register_post_type('products-hacoupian',$args);
}
add_action('init','awesome_custom_post_type');

//////////////////////////////////////////////////////////////////////

function awesomee_custom_post_type (){
	
	$labels = array(
		'name' => 'کالکشن ها',
		'singular_name' => 'کالکشن',
		'add_new' => 'Add Item',
		'all_items' => 'All Items',
		'add_new_item' => 'Add Item',
		'edit_item' => 'Edit Item',
		'new_item' => 'New Item',
		'view_item' => 'View Item',
		'search_item' => 'Search Portfolio',
		'not_found' => 'No items found',
		'not_found_in_trash' => 'No items found in trash',
		'parent_item_colon' => 'Parent Item'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'page',
		'hierarchical' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'revisions',
			'author',
			'page-attributes',
		),
		//'taxonomies' => array('category', 'post_tag'),
		'menu_position' => 5,
		'exclude_from_search' => false
	);
	register_post_type('collections',$args);
}
add_action('init','awesomee_custom_post_type');