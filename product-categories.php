<?php
//hook into the init action and call create_featured_nonhierarchical_taxonomy when it fires

add_action( 'init', 'create_featured_nonhierarchical_taxonomy', 0 );

function create_featured_nonhierarchical_taxonomy() {

// Labels part for the GUI

  $labels = array(
    'name' => _x( 'Featured Product', 'taxonomy general name' ),
    'singular_name' => _x( 'Featured Product', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Featured Products' ),
    'popular_items' => __( 'Popular Featured Products' ),
    'all_items' => __( 'All Featured Products' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Featured Products' ), 
    'update_item' => __( 'Update Featured Products' ),
    'add_new_item' => __( 'Add New Featured Product' ),
    'new_item_name' => __( 'New Featured Product Name' ),
    'separate_items_with_commas' => __( 'Separate featured products with commas' ),
    'add_or_remove_items' => __( 'Add or remove featured products' ),
    'choose_from_most_used' => __( 'Choose from the most used featured products' ),
    'menu_name' => __( 'Featured Products' ),
  ); 

// Now register the non-hierarchical taxonomy like tag

  register_taxonomy('featured_products','post',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'featured-products' ),
  ));
}

//hook into the init action and call create_top_nonhierarchical_taxonomy when it fires

add_action( 'init', 'create_top_nonhierarchical_taxonomy', 0 );

function create_top_nonhierarchical_taxonomy() {

// Labels part for the GUI

  $labels = array(
    'name' => _x( 'Top Products', 'taxonomy general name' ),
    'singular_name' => _x( 'Top Product', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Top Products' ),
    'popular_items' => __( 'Popular Top Products' ),
    'all_items' => __( 'All Top Products' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Top Products' ), 
    'update_item' => __( 'Update Top Products' ),
    'add_new_item' => __( 'Add New Top Product' ),
    'new_item_name' => __( 'New Top Product Name' ),
    'separate_items_with_commas' => __( 'Separate top products with commas' ),
    'add_or_remove_items' => __( 'Add or remove top products' ),
    'choose_from_most_used' => __( 'Choose from the most used top products' ),
    'menu_name' => __( 'Top Products' ),
  ); 

// Now register the non-hierarchical taxonomy like tag

  register_taxonomy('top_products','post',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'top-products' ),
  ));
}

//hook into the init action and call create_productwall_nonhierarchical_taxonomy when it fires

add_action( 'init', 'create_productwall_nonhierarchical_taxonomy', 0 );

function create_productwall_nonhierarchical_taxonomy() {

// Labels part for the GUI

  $labels = array(
    'name' => _x( 'Product Wall', 'taxonomy general name' ),
    'singular_name' => _x( 'Product Wall', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Product Wall' ),
    'popular_items' => __( 'Popular Product Wall' ),
    'all_items' => __( 'All Product Wall' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Product Wall' ), 
    'update_item' => __( 'Update Product Wall' ),
    'add_new_item' => __( 'Add Product Wall' ),
    'new_item_name' => __( 'New Product Wall Name' ),
    'separate_items_with_commas' => __( 'Separate product wall with commas' ),
    'add_or_remove_items' => __( 'Add or remove product wall' ),
    'choose_from_most_used' => __( 'Choose from the most used product wall' ),
    'menu_name' => __( 'Product Wall' ),
  ); 

// Now register the non-hierarchical taxonomy like tag

  register_taxonomy('product_wall','post',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'product-wall' ),
  ));
}