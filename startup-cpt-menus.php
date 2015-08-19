<?php
/*
Plugin Name: StartUp Menus Custom Post Type
Description: Le plugin pour activer le Custom Post Menus
Author: Yann Caplain
Version: 0.3.0
*/

//GitHub Plugin Updater

function startup_reloaded_github_plugin_updater() {
	require_once 'lib/updater.php';
	define( 'WP_GITHUB_FORCE_UPDATE', true );
	if ( is_admin() ) {
		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'startup-cpt-menus',
			'api_url' => 'https://api.github.com/repos/yozzi/startup-cpt-menus',
			'raw_url' => 'https://raw.github.com/yozzi/startup-cpt-menus/dev',
			'github_url' => 'https://github.com/yozzi/startup-cpt-menus',
			'zip_url' => 'https://github.com/yozzi/startup-cpt-menus/archive/dev.zip',
			'sslverify' => true,
			'requires' => '3.0',
			'tested' => '3.3',
			'readme' => 'README.md',
			'access_token' => '',
		);
		new WP_GitHub_Updater( $config );
	}
}

add_action( 'init', 'startup_reloaded_github_plugin_updater' );

//CPT
function startup_reloaded_menus() {
	$labels = array(
		'name'                => _x( 'Menus', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Menu', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Menus', 'text_domain' ),
		'name_admin_bar'      => __( 'Menus', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' )
	);
	$args = array(
		'label'               => __( 'menus', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'revisions', ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-carrot',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
        'capability_type'     => array('menu','menus'),
        'map_meta_cap'        => true
	);
	register_post_type( 'menus', $args );

}

add_action( 'init', 'startup_reloaded_menus', 0 );

// Capabilities
function startup_reloaded_menus_caps() {
	$role_admin = get_role( 'administrator' );
	$role_admin->add_cap( 'edit_menu' );
	$role_admin->add_cap( 'read_menu' );
	$role_admin->add_cap( 'delete_menu' );
	$role_admin->add_cap( 'edit_others_menus' );
	$role_admin->add_cap( 'publish_menus' );
	$role_admin->add_cap( 'edit_menus' );
	$role_admin->add_cap( 'read_private_menus' );
	$role_admin->add_cap( 'delete_menus' );
	$role_admin->add_cap( 'delete_private_menus' );
	$role_admin->add_cap( 'delete_published_menus' );
	$role_admin->add_cap( 'delete_others_menus' );
	$role_admin->add_cap( 'edit_private_menus' );
	$role_admin->add_cap( 'edit_published_menus' );
}

register_activation_hook( __FILE__, 'startup_reloaded_menus_caps' );

// Menu types taxonomy
function startup_reloaded_menu_types() {
	$labels = array(
		'name'                       => _x( 'Menu Types', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Menu Type', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Menu Types', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' )
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false
	);
	register_taxonomy( 'menu-type', array( 'menus' ), $args );

}

add_action( 'init', 'startup_reloaded_menu_types', 0 );

// Retirer la boite de la taxonomie sur le coté
function startup_reloaded_menu_types_metabox_remove() {
	remove_meta_box( 'tagsdiv-menu-type', 'menus', 'side' );
    // tagsdiv-project_types pour les taxonomies type tags
    // custom_taxonomy_slugdiv pour les taxonomies type categories
}

add_action( 'admin_menu' , 'startup_reloaded_menu_types_metabox_remove' );

// Metaboxes
function startup_reloaded_menus_meta() {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_startup_reloaded_menus_';

	$cmb_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Menu details', 'cmb2' ),
		'object_types'  => array( 'menus' )
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'Main picture', 'cmb2' ),
		'desc' => __( 'Main image of the menu, may be different from the thumbnail. i.e. 5-course diner', 'cmb2' ),
		'id'   => $prefix . 'main_pic',
		'type' => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false
        )
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'Thumbnail', 'cmb2' ),
		'desc' => __( 'The menu picture on your website listings, if different from Main picture.', 'cmb2' ),
		'id'   => $prefix . 'thumbnail',
		'type' => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false
        )
	) );

	$cmb_box->add_field( array(
		'name'       => __( 'Short description', 'cmb2' ),
		'desc'       => __( 'i.e. "French gourmet menu."', 'cmb2' ),
		'id'         => $prefix . 'short',
		'type'       => 'text'
	) );
    
    $cmb_box->add_field( array(
		'name'     => __( 'Type', 'cmb2' ),
		'desc'     => __( 'Select the type(s) of the menu', 'cmb2' ),
		'id'       => $prefix . 'type',
		'type'     => 'taxonomy_multicheck',
		'taxonomy' => 'menu-type', // Taxonomy Slug
		'inline'  => true // Toggles display to inline
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Inclusions', 'cmb2' ),
		'id'         => $prefix . 'inclusions',
		'type'       => 'multicheck',
        'options' => array(
            'cocktail' => 'Cocktail local',
            'vin' => '1/2 bouteille de vin',
            'cheese' => 'Assiette de fromages fins',
            'digest' => 'Digestif',
            'coffee' => 'Café, thé, infusion',
        )
	) );
    
    $cmb_box->add_field( array(
        'name' => 'Mise en bouche',
        'type' => 'title',
        'id'   => $prefix . 'miseenbouche-title'
    ) );
      
    $miseenbouche = $cmb_box->add_field( array(
		'id'          => $prefix . 'miseenbouche',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Course {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'cmb2' ),
			'remove_button' => __( 'Remove Course', 'cmb2' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $miseenbouche, array(
        'name'             => __( 'Name', 'cmb2' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $miseenbouche, array(
        'name'             => __( 'Description', 'cmb2' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $miseenbouche, array(
		'name'             => __( 'Extra', 'cmb2' ),
		'id'               => 'extra',
		'type'             => 'checkbox'
	) );
    
    $cmb_box->add_field( array(
        'name' => 'Entrée',
        'type' => 'title',
        'id'   => $prefix . 'entree-title'
    ) );
      
    $entree = $cmb_box->add_field( array(
		'id'          => $prefix . 'entree',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Course {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'cmb2' ),
			'remove_button' => __( 'Remove Course', 'cmb2' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $entree, array(
        'name'             => __( 'Name', 'cmb2' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $entree, array(
        'name'             => __( 'Description', 'cmb2' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $entree, array(
		'name'             => __( 'Extra', 'cmb2' ),
		'id'               => 'extra',
		'type'             => 'checkbox'
	) );
    
    $cmb_box->add_field( array(
        'name' => 'Prélude',
        'type' => 'title',
        'id'   => $prefix . 'prelude-title'
    ) );
      
    $prelude = $cmb_box->add_field( array(
		'id'          => $prefix . 'prelude',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Course {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'cmb2' ),
			'remove_button' => __( 'Remove Course', 'cmb2' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $prelude, array(
        'name'             => __( 'Name', 'cmb2' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $prelude, array(
        'name'             => __( 'Description', 'cmb2' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $prelude, array(
		'name'             => __( 'Extra', 'cmb2' ),
		'id'               => 'extra',
		'type'             => 'checkbox'
	) );
    
    $cmb_box->add_field( array(
        'name' => 'Plat principal',
        'type' => 'title',
        'id'   => $prefix . 'plat-title'
    ) );
      
    $plat = $cmb_box->add_field( array(
		'id'          => $prefix . 'plat',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Course {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'cmb2' ),
			'remove_button' => __( 'Remove Course', 'cmb2' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $plat, array(
        'name'             => __( 'Name', 'cmb2' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $plat, array(
        'name'             => __( 'Description', 'cmb2' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $plat, array(
		'name'             => __( 'Extra', 'cmb2' ),
		'id'               => 'extra',
		'type'             => 'checkbox'
	) );
    
    $cmb_box->add_field( array(
        'name' => 'Dessert',
        'type' => 'title',
        'id'   => $prefix . 'dessert-title'
    ) );
      
    $dessert = $cmb_box->add_field( array(
		'id'          => $prefix . 'dessert',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Course {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'cmb2' ),
			'remove_button' => __( 'Remove Course', 'cmb2' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $dessert, array(
        'name'             => __( 'Name', 'cmb2' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $dessert, array(
        'name'             => __( 'Description', 'cmb2' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $dessert, array(
		'name'             => __( 'Extra', 'cmb2' ),
		'id'               => 'extra',
		'type'             => 'checkbox'
	) );
    
}

add_action( 'cmb2_init', 'startup_reloaded_menus_meta' );
?>
