<?php
/**
 * 
 *
 * @package     
 * @author      Dan Pringle
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: DPUK CPT
 * Plugin URI:  https://danielpringle.co.uk
 * Description: CPT OOP
 * Version:     1.0.0
 * Author:      Daniel Pringle
 * Author URI:  https://danielpringle.co.uk
 * Text Domain: 'dpuk-cpt'
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

define( 'DPUKCPT', plugin_dir_path( __FILE__ ) );

require DPUKCPT . '/includes/classes/class-cpt-maker.php';
require DPUKCPT . '/includes/classes/class-taxonomy.php';
require DPUKCPT . '/includes/classes/class-metabox-ft-post-checkbox.php';



/**
 * Add New Taxonomies
 * 
 * @param string Taxonomy Name
 * @param string CPT name (connected to)
 * @param string Text Domain
 * @param string Label Name (Plural)
 * @param string Singular Name
 * @param string Rewrite
 * @param bool rewrite_with_front;
 * @param bool hierarchical;
 * 
 * @example examples/example-tax.php
 */
$peopleTaxClass     = new custom_taxonomy_class( 'people-categories', 'People', 'dpuk-cpt', 'People Categories', 'People Category', 'people-categories', true, true );
$resourceTaxClass   = new custom_taxonomy_class( 'resource-categories', 'Resources', 'dpuk-cpt', 'Resource Categories', 'Resource Category', 'resource-categories', true, true );
$eventTaxClass  	= new custom_taxonomy_class( 'event-categories', 'Events', 'dpuk-cpt', 'Event Categories', 'Event Category', 'event-categories', true, true );
$suppotTaxClass  	= new custom_taxonomy_class( 'support-categories', 'Support', 'dpuk-cpt', 'Support Categories', 'Support Category', 'support-categories', true, true );
$promotionTaxClass  = new custom_taxonomy_class( 'promotion-categories', 'Promotion', 'dpuk-cpt', 'Promotion Categories', 'Promotion Category', 'promotion-categories', true, true );
$servicesTaxClass   = new custom_taxonomy_class( 'service-categories', 'Services', 'dpuk-cpt', 'Service Categories', 'service Category', 'services/service-categories', false, true );

// $solutionsTaxClass  = new custom_taxonomy_class( 'solutions-categories', 'Solutions', 'dpuk-cpt', 'Solution Categories', 'Solution Category', 'solutions-categories', true, true );

 /**
  * Build CPTs
  * 
  * @param mixed[] $customPosts Array of CPT data
  * @example examples/example-cpt.php
  */

$customPosts = array (

	"resources" => array(
        'name' => 'Resources',
		'singular' => 'Resource',
		'plural'  => 'Resources',
		'menu_icon' => 'dashicons-welcome-learn-more',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'post-formats', 'page-attributes' ),
        'taxonomies' => array('product_cat', 'product_tag' ),
		'has_archives' => false,
		'rewrite' => 'learning-center/resources',
		'rewrite_with_front' => true,
		'hierarchical' => false,
    ),

	"services" => array(
        'name' => 'Services',
		'singular' => 'Service',
		'plural'  => 'Services',
		'menu_icon' => 'dashicons-portfolio',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'post-formats', 'page-attributes'  ),
        'taxonomies' => array('product_cat', 'product_tag' ),
		'has_archives' => false,
		'rewrite' => 'services',
		'rewrite_with_front' => false,
		'hierarchical' => true,
    ),

	"people" => array(
        'name' => 'People',
		'singular' => 'Person',
		'plural'  => 'People',
		'menu_icon' => 'dashicons-businessperson',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail',  'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies' => array(),
		'has_archives' => false,
		'rewrite' => 'People',
		'rewrite_with_front' => true,
		'hierarchical' => false,
    ),

	"events" => array(
        'name' => 'Events',
		'singular' => 'Event',
		'plural'  => 'Events',
		'menu_icon' => 'dashicons-calendar',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail',  'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies' => array(),
		'has_archives' => false,
		'rewrite' => 'events',
		'rewrite_with_front' => true,
		'hierarchical' => false,
    ),

	// "solutions" => array(
    //     'name' => 'Solutions',
	// 	'singular' => 'Solution',
	// 	'plural'  => 'Solutions',
	// 	'menu_icon' => 'dashicons-code-standards',
	// 	'menu_position' => 18,
	// 	'text_domain' => 'dpuk-cpt',
    //     'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail',  'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
	// 	'taxonomies' => array(),
	// 	'has_archives' => false,
	// 	'rewrite' => 'solutions',
	// 	'rewrite_with_front' => true,
	// 	'hierarchical' => true,
    // ),

	"webinars" => array(
        'name' => 'Webinars',
		'singular' => 'Webinar',
		'plural'  => 'Webinars',
		'menu_icon' => 'dashicons-share',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail',  'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies' => array(),
		'has_archives' => false,
		'rewrite' => 'webinars',
		'rewrite_with_front' => true,
		'hierarchical' => false,
    ),

	"events" => array(
        'name' => 'Events',
		'singular' => 'Event',
		'plural'  => 'Events',
		'menu_icon' => 'dashicons-calendar-alt',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail',  'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies' => array(),
		'has_archives' => false,
		'rewrite' => 'events',
		'rewrite_with_front' => true,
		'hierarchical' => false,
    ),

	"support" => array(
        'name' => 'Support',
		'singular' => 'Support',
		'plural'  => 'Support',
		'menu_icon' => 'dashicons-calendar-alt',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail',  'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies' => array(),
		'has_archives' => false,
		'rewrite' => 'support',
		'rewrite_with_front' => true,
		'hierarchical' => false,
    ),

	"promotions" => array(
        'name' => 'Promotion',
		'singular' => 'Promotions',
		'plural'  => 'Promotions',
		'menu_icon' => 'dashicons-calendar-alt',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail',  'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies' => array(),
		'has_archives' => false,
		'rewrite' => 'promotion',
		'rewrite_with_front' => true,
		'hierarchical' => false,
    ),

	"press-release" => array(
        'name' => 'press-release',
		'singular' => 'Press Release',
		'plural'  => 'Press Release',
		'menu_icon' => 'dashicons-welcome-learn-more',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'post-formats', 'page-attributes' ),
        'taxonomies' => array(),
		'has_archives' => false,
		'rewrite' => 'company/press-releases',
		'rewrite_with_front' => true,
		'hierarchical' => false,
    ),

);


foreach ( $customPosts as $customPost ) {
	new CptMaker( 
        $customPost['name'], 
        $customPost['singular'], 
        $customPost['plural'], 
        $customPost['menu_icon'], 
        $customPost['menu_position'], 
        $customPost['text_domain'], 
        $customPost['supports'],
        $customPost['taxonomies'],
		$customPost['has_archives'],  
		$customPost['rewrite'],
		$customPost['rewrite_with_front'],
		$customPost['hierarchical']           
    );
}

/**
 * 
 */
$featuredPostMetaBox  = new MetaBox_FT_Post_Checkbox();







