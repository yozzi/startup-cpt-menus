<?php
/*
Plugin Name: StartUp CPT Menus
Description: Le plugin pour activer le Custom Post Menus
Author: Yann Caplain
Version: 1.0.0
Text Domain: startup-cpt-menus
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//Include this to check if a plugin is activated with is_plugin_active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

//Include this to check dependencies
include_once( 'inc/dependencies.php' );

//GitHub Plugin Updater
function startup_cpt_menus_updater() {
	include_once 'lib/updater.php';
	//define( 'WP_GITHUB_FORCE_UPDATE', true );
	if ( is_admin() ) {
		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'startup-cpt-menus',
			'api_url' => 'https://api.github.com/repos/yozzi/startup-cpt-menus',
			'raw_url' => 'https://raw.github.com/yozzi/startup-cpt-menus/master',
			'github_url' => 'https://github.com/yozzi/startup-cpt-menus',
			'zip_url' => 'https://github.com/yozzi/startup-cpt-menus/archive/master.zip',
			'sslverify' => true,
			'requires' => '3.0',
			'tested' => '3.3',
			'readme' => 'README.md',
			'access_token' => '',
		);
		new WP_GitHub_Updater( $config );
	}
}

//add_action( 'init', 'startup_cpt_menus_updater' );

//CPT
function startup_cpt_menus() {
	$labels = array(
		'name'                => _x( 'Menus', 'Post Type General Name', 'startup-cpt-menus' ),
		'singular_name'       => _x( 'Menu', 'Post Type Singular Name', 'startup-cpt-menus' ),
		'menu_name'           => __( 'Menus', 'startup-cpt-menus' ),
		'name_admin_bar'      => __( 'Menus', 'startup-cpt-menus' ),
		'parent_item_colon'   => __( 'Parent Menu:', 'startup-cpt-menus' ),
		'all_items'           => __( 'All Menus', 'startup-cpt-menus' ),
		'add_new_item'        => __( 'Add New Menu', 'startup-cpt-menus' ),
		'add_new'             => __( 'Add New', 'startup-cpt-menus' ),
		'new_item'            => __( 'New Menu', 'startup-cpt-menus' ),
		'edit_item'           => __( 'Edit Menu', 'startup-cpt-menus' ),
		'update_item'         => __( 'Update Menu', 'startup-cpt-menus' ),
		'view_item'           => __( 'View Menu', 'startup-cpt-menus' ),
		'search_items'        => __( 'Search Menu', 'startup-cpt-menus' ),
		'not_found'           => __( 'Not found', 'startup-cpt-menus' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'startup-cpt-menus' )
	);
	$args = array(
		'label'               => __( 'menus', 'startup-cpt-menus' ),
		'description'         => __( 'Post Type Description', 'startup-cpt-menus' ),
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

add_action( 'init', 'startup_cpt_menus', 0 );

//Flusher les permalink à l'activation du plugin pour qu'ils fonctionnent sans mise à jour manuelle
function startup_cpt_menus_rewrite_flush() {
    startup_cpt_menus();
    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'startup_cpt_menus_rewrite_flush' );

// Capabilities
function startup_cpt_menus_caps() {
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

register_activation_hook( __FILE__, 'startup_cpt_menus_caps' );

// Menu season taxonomy
function startup_cpt_menu_season() {
	$labels = array(
		'name'                       => _x( 'Menu Seasons', 'Taxonomy General Name', 'startup-cpt-menus' ),
		'singular_name'              => _x( 'Menu Season', 'Taxonomy Singular Name', 'startup-cpt-menus' ),
		'menu_name'                  => __( 'Seasons', 'startup-cpt-menus' ),
		'all_items'                  => __( 'All Seasons', 'startup-cpt-menus' ),
		'parent_item'                => __( 'Parent Season', 'startup-cpt-menus' ),
		'parent_item_colon'          => __( 'Parent Season:', 'startup-cpt-menus' ),
		'new_item_name'              => __( 'New Season Name', 'startup-cpt-menus' ),
		'add_new_item'               => __( 'Add New Season', 'startup-cpt-menus' ),
		'edit_item'                  => __( 'Edit Season', 'startup-cpt-menus' ),
		'update_item'                => __( 'Update Season', 'startup-cpt-menus' ),
		'view_item'                  => __( 'View Season', 'startup-cpt-menus' ),
		'separate_items_with_commas' => __( 'Separate seasons with commas', 'startup-cpt-menus' ),
		'add_or_remove_items'        => __( 'Add or remove seasons', 'startup-cpt-menus' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'startup-cpt-menus' ),
		'popular_items'              => __( 'Popular Seasons', 'startup-cpt-menus' ),
		'search_items'               => __( 'Search Seasons', 'startup-cpt-menus' ),
		'not_found'                  => __( 'Not Found', 'startup-cpt-menus' )
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
	register_taxonomy( 'menu-season', array( 'menus' ), $args );

}

add_action( 'init', 'startup_cpt_menu_season', 0 );

// Menu types taxonomy
function startup_cpt_menu_types() {
	$labels = array(
		'name'                       => _x( 'Menu Types', 'Taxonomy General Name', 'startup-cpt-menus' ),
		'singular_name'              => _x( 'Menu Type', 'Taxonomy Singular Name', 'startup-cpt-menus' ),
		'menu_name'                  => __( 'Types', 'startup-cpt-menus' ),
		'all_items'                  => __( 'All Types', 'startup-cpt-menus' ),
		'parent_item'                => __( 'Parent Type', 'startup-cpt-menus' ),
		'parent_item_colon'          => __( 'Parent Type:', 'startup-cpt-menus' ),
		'new_item_name'              => __( 'New Type Name', 'startup-cpt-menus' ),
		'add_new_item'               => __( 'Add New Type', 'startup-cpt-menus' ),
		'edit_item'                  => __( 'Edit Type', 'startup-cpt-menus' ),
		'update_item'                => __( 'Update Type', 'startup-cpt-menus' ),
		'view_item'                  => __( 'View Type', 'startup-cpt-menus' ),
		'separate_items_with_commas' => __( 'Separate types with commas', 'startup-cpt-menus' ),
		'add_or_remove_items'        => __( 'Add or remove types', 'startup-cpt-menus' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'startup-cpt-menus' ),
		'popular_items'              => __( 'Popular Types', 'startup-cpt-menus' ),
		'search_items'               => __( 'Search Types', 'startup-cpt-menus' ),
		'not_found'                  => __( 'Not Found', 'startup-cpt-menus' )
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

add_action( 'init', 'startup_cpt_menu_types', 0 );

// Menu company taxonomy
function startup_cpt_menu_company() {
	$labels = array(
		'name'                       => _x( 'Menu Companies', 'Taxonomy General Name', 'startup-cpt-menus' ),
		'singular_name'              => _x( 'Menu Company', 'Taxonomy Singular Name', 'startup-cpt-menus' ),
		'menu_name'                  => __( 'Companies', 'startup-cpt-menus' ),
		'all_items'                  => __( 'All Companies', 'startup-cpt-menus' ),
		'parent_item'                => __( 'Parent Company', 'startup-cpt-menus' ),
		'parent_item_colon'          => __( 'Parent Company:', 'startup-cpt-menus' ),
		'new_item_name'              => __( 'New Company Name', 'startup-cpt-menus' ),
		'add_new_item'               => __( 'Add New Company', 'startup-cpt-menus' ),
		'edit_item'                  => __( 'Edit Company', 'startup-cpt-menus' ),
		'update_item'                => __( 'Update Company', 'startup-cpt-menus' ),
		'view_item'                  => __( 'View Company', 'startup-cpt-menus' ),
		'separate_items_with_commas' => __( 'Separate companies with commas', 'startup-cpt-menus' ),
		'add_or_remove_items'        => __( 'Add or remove companies', 'startup-cpt-menus' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'startup-cpt-menus' ),
		'popular_items'              => __( 'Popular Companies', 'startup-cpt-menus' ),
		'search_items'               => __( 'Search Companies', 'startup-cpt-menus' ),
		'not_found'                  => __( 'Not Found', 'startup-cpt-menus' )
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
	register_taxonomy( 'menu-company', array( 'menus' ), $args );

}

add_action( 'init', 'startup_cpt_menu_company', 0 );

// Retirer la boite de la taxonomie sur le coté
function startup_cpt_menu_types_metabox_remove() {
	remove_meta_box( 'tagsdiv-menu-type', 'menus', 'side' );
    remove_meta_box( 'tagsdiv-menu-company', 'menus', 'side' );
    remove_meta_box( 'tagsdiv-menu-season', 'menus', 'side' );
    // tagsdiv-project_types pour les taxonomies type tags
    // custom_taxonomy_slugdiv pour les taxonomies type categories
}

add_action( 'admin_menu' , 'startup_cpt_menu_types_metabox_remove' );

// Metaboxes
function startup_cpt_menus_meta() {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_startup_cpt_menus_';

	$cmb_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Courses', 'startup-cpt-menus' ),
		'object_types'  => array( 'menus' )
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Inclusions', 'startup-cpt-menus' ),
		'id'         => $prefix . 'inclusions',
		'type'       => 'multicheck',
        'inline'  => true, // Toggles display to inline
        'select_all_button' => false,
        'options' => array(
            'cocktail' => 'Cocktail de bienvenue',
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
			'group_title'   => __( 'Course {#}', 'startup-cpt-menus' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'startup-cpt-menus' ),
			'remove_button' => __( 'Remove Course', 'startup-cpt-menus' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $miseenbouche, array(
        'name'             => __( 'Name', 'startup-cpt-menus' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $miseenbouche, array(
        'name'             => __( 'Description', 'startup-cpt-menus' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $miseenbouche, array(
		'name'             => __( 'Extra', 'startup-cpt-menus' ),
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
			'group_title'   => __( 'Course {#}', 'startup-cpt-menus' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'startup-cpt-menus' ),
			'remove_button' => __( 'Remove Course', 'startup-cpt-menus' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $entree, array(
        'name'             => __( 'Name', 'startup-cpt-menus' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $entree, array(
        'name'             => __( 'Description', 'startup-cpt-menus' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $entree, array(
		'name'             => __( 'Extra', 'startup-cpt-menus' ),
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
			'group_title'   => __( 'Course {#}', 'startup-cpt-menus' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'startup-cpt-menus' ),
			'remove_button' => __( 'Remove Course', 'startup-cpt-menus' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $prelude, array(
        'name'             => __( 'Name', 'startup-cpt-menus' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $prelude, array(
        'name'             => __( 'Description', 'startup-cpt-menus' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $prelude, array(
		'name'             => __( 'Extra', 'startup-cpt-menus' ),
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
			'group_title'   => __( 'Course {#}', 'startup-cpt-menus' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'startup-cpt-menus' ),
			'remove_button' => __( 'Remove Course', 'startup-cpt-menus' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $plat, array(
        'name'             => __( 'Name', 'startup-cpt-menus' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $plat, array(
        'name'             => __( 'Description', 'startup-cpt-menus' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $plat, array(
		'name'             => __( 'Extra', 'startup-cpt-menus' ),
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
			'group_title'   => __( 'Course {#}', 'startup-cpt-menus' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Course', 'startup-cpt-menus' ),
			'remove_button' => __( 'Remove Course', 'startup-cpt-menus' ),
			'sortable'      => true // beta
			// 'closed'     => true, // true to have the groups closed by default
		)
	) );
    
    $cmb_box->add_group_field( $dessert, array(
        'name'             => __( 'Name', 'startup-cpt-menus' ),
        'id'               => 'name',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $dessert, array(
        'name'             => __( 'Description', 'startup-cpt-menus' ),
        'id'               => 'desc',
        'type'             => 'text'
    ) );
    
    $cmb_box->add_group_field( $dessert, array(
		'name'             => __( 'Extra', 'startup-cpt-menus' ),
		'id'               => 'extra',
		'type'             => 'checkbox'
	) );
    
    $cmb_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox2',
		'title'         => __( 'Other menu types', 'startup-cpt-menus' ),
		'object_types'  => array( 'menus' )
	) );
    
    $cmb_box->add_field( array(
//		'name'       => __( 'Content', 'startup-cpt-menus' ),
		'desc'       => __( 'Use [strong] for titles, [list] for items, [italic] for description and [line] for separator', 'startup-cpt-menus' ),
		'id'         => $prefix . 'others',
		'type'    => 'wysiwyg',
        'options' => array(
            'wpautop' => true, // use wpautop?
            'media_buttons' => false, // show insert/upload button(s)
//            'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
            'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
            'tabindex' => '',
            'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
            'editor_class' => '', // add extra class(es) to the editor textarea
            'teeny' => false, // output the minimal editor config used in Press This
            'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
            'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
            'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
        ),
	) );
    
    $cmb_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox3',
		'title'         => __( 'Footer notes', 'startup-cpt-menus' ),
		'object_types'  => array( 'menus' )
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'On site', 'startup-cpt-menus' ),
        'id'         => $prefix . 'notes_site',
		'type'       => 'textarea_small'
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'On portal', 'startup-cpt-menus' ),
        'id'         => $prefix . 'notes_portal',
		'type'       => 'textarea_small'
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'On both', 'startup-cpt-menus' ),
        'id'         => $prefix . 'notes',
		'type'       => 'textarea_small'
	) );
    
    $cmb_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox4',
		'title'         => __( 'Details', 'startup-cpt-menus' ),
		'object_types'  => array( 'menus' ),
        'context'      => 'side',
		'priority'     => 'high',
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Short description', 'startup-cpt-menus' ),
		'desc'       => __( 'i.e. "French gourmet menu."', 'startup-cpt-menus' ),
		'id'         => $prefix . 'short',
		'type'       => 'text'
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Price', 'startup-cpt-menus' ),
		'id'         => $prefix . 'price',
		'type'       => 'text'
	) );
    
//    
//    $cmb_box->add_field( array(
//		'name' => __( 'Thumbnail', 'startup-cpt-menus' ),
//		'desc' => __( 'The menu picture on your website listings, if different from Main picture.', 'startup-cpt-menus' ),
//		'id'   => $prefix . 'thumbnail',
//		'type' => 'file',
//        // Optionally hide the text input for the url:
//        'options' => array(
//            'url' => false
//        )
//	) );
//
    
    $cmb_box->add_field( array(
		'name'     => __( 'Season', 'startup-cpt-menus' ),
		'id'       => $prefix . 'season',
		'type'     => 'taxonomy_multicheck',
        'select_all_button' => false,
		'taxonomy' => 'menu-season', // Taxonomy Slug
	) );
    
    $cmb_box->add_field( array(
		'name'     => __( 'Type', 'startup-cpt-menus' ),
		'id'       => $prefix . 'type',
		'type'     => 'taxonomy_multicheck',
        'select_all_button' => false,
		'taxonomy' => 'menu-type', // Taxonomy Slug
	) );
    
    $cmb_box->add_field( array(
		'name'     => __( 'Company', 'startup-cpt-menus' ),
		'id'       => $prefix . 'company',
		'type'     => 'taxonomy_multicheck',
        'select_all_button' => false,
		'taxonomy' => 'menu-company', // Taxonomy Slug
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'Main picture', 'startup-cpt-menus' ),
//		'desc' => __( 'Main image of the menu, may be different from the thumbnail. i.e. 5-course diner', 'startup-cpt-menus' ),
		'id'   => $prefix . 'main_pic',
		'type' => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false
        )
	) );
    
}

add_action( 'cmb2_admin_init', 'startup_cpt_menus_meta' );

// Shortcode
function startup_cpt_menus_shortcode( $atts ) {

	// Attributes
    $atts = shortcode_atts(array(
            'bg' => '',
            'id' => '',
            'price' => ''
        ), $atts);
    
	// Code
    if ( function_exists( 'startup_cpt_setup' ) ) {
        ob_start();
        require get_template_directory() . '/template-parts/content-menus.php';
    } else {
        echo 'Should <a href="https://github.com/yozzi/startup-reloaded" target="_blank">install StartUp Reloaded Theme</a> to make things happen...';
    }
    return ob_get_clean();
}
add_shortcode( 'menus', 'startup_cpt_menus_shortcode' );

// Shortcode UI
function startup_cpt_menus_shortcode_ui() {

    shortcode_ui_register_for_shortcode(
        'menus',
        array(
            'label' => esc_html__( 'Menus', 'startup-cpt-menus' ),
            'listItemImage' => 'dashicons-carrot',
            'attrs' => array(
                array(
                    'label' => esc_html__( 'Background', 'startup-cpt-menus' ),
                    'attr'  => 'bg',
                    'type'  => 'color',
                ),
                array(
                    'label' => esc_html__( 'Price', 'startup-cpt-menus' ),
                    'attr'  => 'price',
                    'type'  => 'checkbox',
                ),
                array(
                    'label'       => esc_html__( 'ID', 'startup-cpt-menus' ),
                    'attr'        => 'id',
					'type' => 'post_select',
					'query' => array( 'post_type' => 'menus' ),
					'multiple' => false,
                ),
            ),
        )
    );
};

if ( function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
    add_action( 'init', 'startup_cpt_menus_shortcode_ui');
}

// Enqueue scripts and styles.
function startup_cpt_menus_scripts() {
    wp_enqueue_style( 'startup-cpt-menus-style', plugins_url( '/css/startup-cpt-menus.css', __FILE__ ), array( ), false, 'all' );
}

add_action( 'wp_enqueue_scripts', 'startup_cpt_menus_scripts', 15 );

// Settings
require('inc/settings.php');



//////////////
function randomString($length = 8) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}


add_filter( 'wp_unique_post_slug', 'custom_unique_post_slug', 10, 4 );
function custom_unique_post_slug( $slug, $post_ID, $post_status, $post_type ) {
    if ( "menus" == $post_type ) {
        $post = get_post($post_ID);
        if ( empty($post->post_name) || $slug != $post->post_name ) {
            $slug = md5( time() );
            $slug = substr($slug, 0, 10);
        }
    }
    return $slug;
}

?>