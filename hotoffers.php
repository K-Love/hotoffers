<?php
/**
 * @package Hot_Stuff
 */
/*
Plugin Name: Hot Stuff
Description: Enter and present hot products
Author: Backstage Interactive
Author URI: http://backstageinteractive.com
Version: 1.0
Text Domain: hotstuff
*/

// Register Custom Post Type
function hot_stuff_post_type() {

	$labels = array(
		'name'                  => _x( 'Products', 'Post Type General Name', 'hotstuff' ),
		'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'hotstuff' ),
		'menu_name'             => __( 'Hot Stuff Products', 'hotstuff' ),
		'name_admin_bar'        => __( 'Hot Stuff', 'hotstuff' ),
		'archives'              => __( 'Product Archives', 'hotstuff' ),
		'attributes'            => __( 'Product Attributes', 'hotstuff' ),
		'parent_item_colon'     => __( 'Parent Product:', 'hotstuff' ),
		'all_items'             => __( 'All Products', 'hotstuff' ),
		'add_new_item'          => __( 'Add New Product', 'hotstuff' ),
		'add_new'               => __( 'Add New', 'hotstuff' ),
		'new_item'              => __( 'New Product', 'hotstuff' ),
		'edit_item'             => __( 'Edit Product', 'hotstuff' ),
		'update_item'           => __( 'Update Product', 'hotstuff' ),
		'view_item'             => __( 'View Product', 'hotstuff' ),
		'view_items'            => __( 'View Products', 'hotstuff' ),
		'search_items'          => __( 'Search Product', 'hotstuff' ),
		'not_found'             => __( 'Not found', 'hotstuff' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'hotstuff' ),
		'featured_image'        => __( 'Product Image', 'hotstuff' ),
		'set_featured_image'    => __( 'Set Product image', 'hotstuff' ),
		'remove_featured_image' => __( 'Remove Product image', 'hotstuff' ),
		'use_featured_image'    => __( 'Use as Product image', 'hotstuff' ),
		'insert_into_item'      => __( 'Insert into Product', 'hotstuff' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Product', 'hotstuff' ),
		'items_list'            => __( 'Products list', 'hotstuff' ),
		'items_list_navigation' => __( 'Products list navigation', 'hotstuff' ),
		'filter_items_list'     => __( 'Filter Products list', 'hotstuff' ),
	);
	
	$args = array(
		'label'                 => __( 'Product', 'hotstuff' ),
		'description'           => __( 'Add stuff to GiveMeStuff', 'hotstuff' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'post-formats', ),
		'taxonomies'            => array( 'product_type', 'department' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-cart',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		// 'rewrite'            	=> array('slug' => 'product', 'with_front' => false),
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'hot_stuff', $args );

}
add_action( 'init', 'hot_stuff_post_type', 0 );

class Rational_Meta_Box {
	private $screens = array(
		'hot_stuff',
	);
	private $fields = array(
		array(
			'id' => 'gimmebuttonlink',
			'label' => 'Gimme Button Link URL',
			'type' => 'url',
		),
		array(
			'id' => 'hotstuffprice',
			'label' => 'Hot Stuff Product Price',
			'type' => 'text',
		),
	);

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'hot-stuff-product-link',
				__( 'Hot Stuff Product Info', 'hotstuff' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'normal',
				'high'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'hot_stuff_product_link_data', 'hot_stuff_product_link_nonce' );
		// echo 'Insert link for the Gimme button';
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, 'hot_stuff_product_link_' . $field['id'], true );
			switch ( $field['type'] ) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['hot_stuff_product_link_nonce'] ) )
			return $post_id;

		$nonce = $_POST['hot_stuff_product_link_nonce'];
		if ( !wp_verify_nonce( $nonce, 'hot_stuff_product_link_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'hot_stuff_product_link_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'hot_stuff_product_link_' . $field['id'], '0' );
			}
		}
	}
}

new Rational_Meta_Box;

add_filter( 'template_include', 'single_product_template', 1 );

function single_product_template( $template_path ) {
    if ( get_post_type() == 'hot_stuff' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-product.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-product.php';
            }
        }
    }
    return $template_path;
}






//Two functions to remove slug from team_member and event CPTs:
function remove_hotstuff_slug($post_link, $post, $leavename) {

    if('hot_stuff' != $post->post_type ||'publish' != $post->post_status) {
        return $post_link;
    }

    $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);

    return $post_link;
}
add_filter('post_type_link', 'remove_hotstuff_slug', 10, 3);

function  parse_hotstuff_slug($query) {

    if(!$query->is_main_query() || 2 != count($query->query) || !isset($query->query['page'])) {
        return;
    }

    if(!empty($query->query['name'])) {
        $query->set('post_type', array('post', 'hot_stuff', 'page'));
    }
}
add_action('pre_get_posts', 'parse_hotstuff_slug');