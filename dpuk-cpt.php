<?php
/**
 * 
 *
 * @package     
 * @author      Dan Pringle
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Azenta CPT
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

 /**
  * Build CPTs
  * 
  * @param mixed[] $customPosts Array of CPT data
  * @example examples/example-cpt.php
  */

$customPosts = array (
	"people" => array(
        'name' => 'People',
		'singular' => 'Person',
		'plural'  => 'People',
		'menu_icon' => 'dashicons-businessperson',
		'menu_position' => 18,
		'text_domain' => 'az-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail',  'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies' => array(),
		'has_archives' => false,
		'rewrite' => 'People',
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

